<?php
	//$DiaAuxSig=13+1;
	//echo date("Y-m-d", mktime(1,0,0,10,$DiaAuxSig,2006));	
	$CodigoDeSistema = 3;
	$CodigoDePantalla =16; 
	include("../principal/conectar_principal.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Dia = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");

	$PaqLavar = "";
	$PaqPesar = "";
	$PaqStandard = "";
	$PaqCatodosGranel = "";
	$PaqStandardGranel = "";
	$ConfecGranel = "";
	$Observacion = "";
	$EnPreparacion = "";

	$Validacion = "";
	
	$RecuperadoDiario = "";
	$RecuperadoAcumulado = "";
	$StandardDiario = "";
	$StandardAcumulado = "";
	$Genera = false;
	if (isset($Dia))
	{
		$FechaInf = $Ano."-".$Mes."-".$Dia;
		$Consulta = "SELECT * from sec_web.informe_diario ";
		$Consulta.= " where fecha = '".$FechaInf."'";
		
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Genera = true;
			$PaqLavar = $Fila["peso_paquete_lavar"];
			$PaqPesar = $Fila["peso_paquete_pesar"];
			$PaqStandard = $Fila["peso_paquete_standard"];
			$PaqCatodosGranel = $Fila["peso_catodos_granel"];
			$PaqStandardGranel = $Fila["peso_standard_granel"];
			$ConfecGranel = $Fila["peso_confec_paquetes"];
			$Observacion = $Fila["observacion"];
			//$Validacion = $Fila["validacion"];
			$RecuperadoDiario = $Fila["recuperado_diario"];
			$RecuperadoAcumulado = $Fila["recuperado_acumulado"];
			$StandardDiario = $Fila["standard_diario"];
			$StandardAcumulado = $Fila["standard_acumulado"];
			$EnPreparacion=$Fila["sin_preparar_arrastre"];
			$Validacion = $PaqLavar + $PaqPesar + $PaqStandard + $PaqCatodosGranel + $PaqStandardGranel + $EnPreparacion;
		}
		
		
	}
		
		if ($EnPreparacion == 0)
		{
		
		
			$Consulta = "SELECT *  from sec_web.catodo_por_pesar ";
			$Resp1 = mysqli_query($link, $Consulta);
			if ($Fila1 = mysqli_fetch_array($Resp1))
			{
				$EnPreparacion=$Fila1["catodo_por_pesar"];
				$Validacion = $Validacion + $EnPreparacion;
				
			}
		}
	
?>
<html>
<head>
<title>Informe Diario de Productos Finales</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{	
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "G":
			f.action = "sec_informe_diario_ing01.php?Proceso=G";
			f.submit();
			break;
		case "GW":
			f.action = "sec_informe_diario.php";
			f.submit();
			break;
		case "GE":
			f.action = "sec_informe_diario_excel.php";
			f.submit();
			break;		
		case "E":
			var msj = confirm("�Seguro que desea eliminar los datos base para este dia?");
			if (msj == true)
			{
				f.action = "sec_informe_diario_ing01.php?Proceso=E";			
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=3";
			f.submit();
			break;
		case "R":
			f.action = "sec_informe_diario_ing.php";
			f.submit();
			break;
	}
}

function Calcula()
{
	var f = document.frmPrincipal;
	if (f.PaqLavar.value=="")
		f.PaqLavar.value="0";
	if (f.PaqPesar.value=="")
		f.PaqPesar.value="0";
	if (f.PaqStandard.value=="")
		f.PaqStandard.value="0";
	if (f.PaqCatodosGranel.value=="")
		f.PaqCatodosGranel.value="0";
	if (f.PaqStandardGranel.value=="")
		f.PaqStandardGranel.value="0";
	if (f.EnPreparacion.value=="")
		f.EnPreparacion.value="0";	
	f.Validacion.value = parseFloat(f.PaqLavar.value.replace(".",",")) + parseFloat(f.PaqPesar.value.replace(".",",")) + parseFloat(f.PaqStandard.value.replace(".",","))  + parseFloat(f.EnPreparacion.value.replace(".",",")) + parseFloat(f.PaqCatodosGranel.value.replace(".",",")) + parseFloat(f.PaqStandardGranel.value.replace(".",","));
	
}
</script>

<body leftmargin="2" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php"); ?>
<table width="770" height="315" border="0" cellpadding="3" cellspacing="3" class="TablaPrincipal">
    <tr>
      <td valign="top"> <div align="center"><strong><br>
          DATOS BASE PARA INFORME DIARIO DE PRODUCTOS FINALES</strong><br>
          <br>
        </div>
        <table width="690" border="1" align="center" cellpadding="2" cellspacing="0">
          <tr> 
            <td class="ColorTabla01">Fecha del Informe</td>
            <td colspan="3"><SELECT name="Dia" id="Dia">
                <?php
				for ($i=1;$i<=31;$i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}/*
					else
					{
						if ($i == date("j"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}*/
				}
			?>
              </SELECT> <SELECT name="Mes" id="Mes">
                <?php
				for ($i=1;$i<=12;$i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
							echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}/*
					else
					{
						if ($i ==date("n"))
							echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}*/
				}
			?>
              </SELECT> <SELECT name="Ano" id="Ano">
                <?php
				for ($i=date("Y")-2;$i<=date("Y");$i++)
				{
					if (isset($Ano))
					{
						if ($Ano == $i)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}/*
					else
					{
						if ($i ==date("Y"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}*/
				}
			?>
              </SELECT> <input name="BtnVer" type="button" id="BtnVer" value="Ver" onClick="Proceso('R');"></td>
          </tr>
          <tr>
            <td colspan="4"><strong>DATOS BASE </strong></td>
          </tr>
          <tr> 
            <td width="202" class="ColorTabla01">1.-Peso de paquetes por lavar</td>
            <td colspan="3"><input name="PaqLavar" type="text" value="<?php echo $PaqLavar; ?>" onBlur="Calcula();" onFocus="Calcula();">
              TONS</td>
          </tr>
          <tr>
            <td class="ColorTabla01">2.-Peso de Paquetes por Pesar </td>
            <td colspan="3"><input name="PaqPesar" type="text" id="PaqPesar" value="<?php echo $PaqPesar; ?>" onBlur="Calcula();" onFocus="Calcula();"> 
              TONS</td>
          </tr>
          <tr> 
            <td class="ColorTabla01">3.-Peso de paquetes STANDARD </td>
            <td colspan="3"><input name="PaqStandard" type="text" value="<?php echo $PaqStandard; ?>" onBlur="Calcula();" onFocus="Calcula();">
              TONS</td>
          </tr>
          <tr>
            <td class="ColorTabla01">4.-Peso CATODOS &quot;A&quot; Granel</td>
            <td colspan="3"><input name="PaqCatodosGranel" type="text" id="PaqCatodosGranel" value="<?php echo $PaqCatodosGranel; ?>" onBlur="Calcula();" onFocus="Calcula();">
              TONS</td>
          </tr>
          <tr> 
            <td class="ColorTabla01">5.-Peso STANDARD a Granel</td>
            <td colspan="3"><input name="PaqStandardGranel" type="text" value="<?php echo $PaqStandardGranel; ?>" onBlur="Calcula();" onFocus="Calcula();">
              TONS </td>
          </tr>
          <tr> 
            <td class="ColorTabla01">Validaci&oacute;n
            Existencia Total</td>
            <td colspan="3"><input name="Validacion" type="text" id="Validacion2" value="<?php echo $Validacion; ?>">
            TONS</td>
          </tr>
          <tr> 
            <td class="ColorTabla01">6.-Confecci&oacute;n de paquetes</td>
            <td colspan="3"><input name="ConfecGranel" type="text" value="<?php echo $ConfecGranel; ?>">            
            TONS</td>
          </tr>
		  
		  		 		 
		  <tr> 
            <td class="ColorTabla01">7.-Sin Preparar Mes Anterior</td>
            <td colspan="3"><input name="EnPreparacion" type="text" value="<?php echo $EnPreparacion; ?>">            
            TONS</td>
          </tr>

		  
          <tr>
            <td colspan="4"><strong>%GENERACION RECUPERADO Y STANDARD EN UNIDADES </strong></td>
          </tr>
          <tr>
            <td class="ColorTabla01">RECUPERADO DIARIO</td>
            <td width="167"><input name="RecuperadoDiario" type="text" id="RecuperadoDiario" value="<?php echo $RecuperadoDiario; ?>" size="15" maxlength="15"></td>
            <td width="184" class="ColorTabla01"><span class="ColorTabla01">RECUPERADO ACUMULADO </span></td>
            <td width="111"><input name="RecuperadoAcumulado" type="text" id="RecuperadoAcumulado" value="<?php echo $RecuperadoAcumulado; ?>" size="15"></td>
          </tr>
          <tr>
            <td class="ColorTabla01">STANDARD DIARIO </td>
            <td><input name="StandardDiario" type="text" id="StandardDiario" value="<?php echo $StandardDiario; ?>" size="15"></td>
            <td class="ColorTabla01">STANDARD ACUMULADO </td>
            <td><input name="StandardAcumulado" type="text" id="StandardAcumulado" value="<?php echo $StandardAcumulado; ?>" size="15"></td>
          </tr>
          <tr>
            <td class="ColorTabla01">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td><strong>OBSERVACION</strong></td>
            <td colspan="3"><textarea name="Observacion" cols="50" rows="4" wrap="VIRTUAL" id="Observacion"><?php echo $Observacion; ?></textarea></td>
          </tr>
          <tr align="center"> 
            <td height="30" colspan="4"> <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px" onClick="Proceso('G');"> 
              <?php
				if ($Genera)
				{
	             	echo "<input name='BtnGenerar' type='button' value='Generar Web' style='width:90px' onClick=\"Proceso('GW');\">\n"; 
              		echo "<input name='BtnGenerar2' type='button' value='Generar Excel' style='width:90px' onClick=\"Proceso('GE');\"> \n";
				}
			?>
              <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:70px" onClick="Proceso('E');"> 
              <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"> 
            </td>
          </tr>
        </table>
        <br>
      </td>
  </tr>
</table><?php include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
