<?php
	$CodigoDeSistema = 3;
	$CodigoDePantalla =16; 
	include("../principal/conectar_principal.php");
	// $link = mysql_connect('10.56.11.7','adm_bd','672312');
 mysql_SELECT_db("sec_web",$link);
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$PaqLavar = "";
	$PaqStandard = "";
	$PaqCatodosGranel = "";
	$PaqStandardGranel = "";
	$ConfecGranel = "";
	$Observacion = "";
	$Validacion = "";
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
			$PaqStandard = $Fila["peso_paquete_standard"];
			$PaqCatodosGranel = $Fila["peso_catodos_granel"];
			$PaqStandardGranel = $Fila["peso_standard_granel"];
			$ConfecGranel = $Fila["peso_confec_paquetes"];
			$Observacion = $Fila["observacion"];
			$Validacion = $Fila["validacion"];
		}
	}
	$Ayer = date("Y-m-d", mktime(0,0,0,date("m"),(date("d")-1),date("Y")));
	$DiaAyer = intval(substr($Ayer,8,2));
	$MesAyer = intval(substr($Ayer,5,2));
	$AnoAyer = intval(substr($Ayer,0,4));
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
			f.action = "sec_informe_diario.php?ConsultaGeneral=S";
			f.submit();
			break;
		case "GWA":
			f.Dia.value = f.DiaAyer.value;
			f.Mes.value = f.MesAyer.value;
			f.Ano.value = f.AnoAyer.value;
			f.action = "sec_informe_diario.php?ConsultaGeneral=S";
			f.submit();
			break;
		case "GE":
			f.action = "sec_informe_diario_excel.php?ConsultaGeneral=S";
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
		history.back();
			break;
		case "R":
			f.action = "sec_informe_diario_ing.php";
			f.submit();
			break;
	}
}
</script>

<body leftmargin="2" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php"); ?>
<input type="hidden" name="DiaAyer" value="<?php echo $DiaAyer; ?>">
<input type="hidden" name="MesAyer" value="<?php echo $MesAyer; ?>">
<input type="hidden" name="AnoAyer" value="<?php echo $AnoAyer; ?>">
<table width="770" height="315" border="0" cellpadding="3" cellspacing="3" class="TablaPrincipal">
    <tr>
      <td valign="top"> <div align="center"><strong><br>
          INFORME DIARIO DE PRODUCTOS FINALES</strong><br>
          <br>
        </div>
        <table width="548" border="1" align="center" cellpadding="2" cellspacing="0">
          <tr> 
            <td width="152" class="ColorTabla01">Fecha del Informe</td>
            <td width="491"><SELECT name="Dia" id="Dia">
                <?php
				for ($i=1;$i<=31;$i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
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
					}
					else
					{
						if ($i ==date("n"))
							echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
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
					}
					else
					{
						if ($i ==date("Y"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
              </SELECT>
            </td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2"> 
              <input name='BtnAyer' type='button' id="BtnAyer" style='width:90px' onClick="Proceso('GWA');" value='Ayer'>
              <input name='BtnGenerar' type='button' value='Generar Web' style='width:90px' onClick="Proceso('GW');"> 
              <input name='BtnGenerar2' type='button' value='Generar Excel' style='width:90px' onClick="Proceso('GE');">
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">            </td>
          </tr>
        </table>
        <br>
      </td>
  </tr>
</table><?php include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
<?php
	if ($Generado == "N")
	{
		echo "<script language='JavaScript'>\n";
		echo "alert('No se ha generado oficialmente el Informe Diario para este dia');\n";
		echo "</script>\n";
	}
?>
