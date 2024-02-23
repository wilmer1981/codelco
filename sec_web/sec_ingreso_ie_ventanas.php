<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 49;
	include("../principal/conectar_sec_web.php");
	$Consulta = "SELECT ifnull(max(corr_enm),800000)+ 1 as mayor  from sec_web.programa_enami where tipo='V'";
	$Resultado = mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Resultado);
	$IE_Ven=$Fila["mayor"];
?>
<html>
<head>
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Grabar(Proceso,Valores,PesoMaximo,Confeccion)
{
	var Frm=document.FrmProceso;
	
	if (Frm.CmbContrato.value == "-1")
	{
		alert("Debe Seleccionar Contrato");
		Frm.CmbContrato.focus();
		return;
	}
	if (Frm.CmbDestino.value == "-1")
	{
		alert("Debe Seleccionar Destino");
		Frm.CmbDestino.focus();
		return;
	}
	if ((Frm.TxtPeso.value == "0")||(Frm.TxtPeso.value == ""))
	{
		alert("Debe Ingresar Peso IE");
		Frm.TxtPeso.value=PesoMaximo;
		Frm.TxtPeso.focus();
		return;
	}
	if (Number(Frm.TxtPeso.value)>Number(PesoMaximo))
	{
		alert("El Peso IE no Debe ser Mayor a Peso Maximo");
		Frm.TxtPeso.value=PesoMaximo;
		Frm.TxtPeso.focus();
		return;
	}
	
	if (confirm('Esta Seguro de Grabar Los Datos'))
	{
		if (Confeccion=='G')
		{
			window.open("sec_transportista3.php?TxtIE="+Frm.TxtIE.value+"&CmbContrato="+Frm.CmbContrato.value+"&CmbDestino="+Frm.CmbDestino.value+"&TxtPeso="+Frm.TxtPeso.value,""," top=5,left=5,fullscreen=no,width=750,height=560,scrollbars=yes,resizable = yes");		
		}
		else
		{
			Frm.action="sec_ingreso_ie_ventanas01.php?Proceso=G";
			Frm.submit();
		}	
	}	
}
function Recarga(Num)
{
	var Frm=document.FrmProceso;
	
	switch (Num)
	{
		case '1':
			if (Frm.CmbContrato.value=='')
			{
				alert('Debe Ingresar Nro. Contrato');
				Frm.CmbContrato.focus();
				return;
			}	
			Frm.action="sec_ingreso_ie_ventanas.php?Buscar=S";
			break;
		case '2':
			Frm.action="sec_ingreso_ie_ventanas.php?Buscar=S&Selecciono=S&Valores="+Frm.CmbProducto.value;
			break;
	}
	Frm.submit();
	
}

function Salir()
{
	var Frm=document.FrmProceso;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=46";
	Frm.submit();

	
}
</script>
<title>Ingreso de IE Ventanas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	echo "<body onload='document.FrmProceso.CmbContrato.focus()' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style><form name="FrmProceso" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770"  height="330" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td align="center">
	<table width="750" border="0" cellpadding="0" class="TablaInterior">
          <tr> 
            <td>IE Ventanas</td>
            <td> 
              <?php
 				 echo "<input type='text' name='TxtIE' style='width:60' maxlength='10' readonly value='$IE_Ven' class='Detalle01'>";
  			  ?>
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> <table width="600" border="1" cellpadding="0" cellspacing="0" class="Detalle01">
                <tr> 
                  <td align="center" width="64">Contrato</td>
                  <td align="center" width="84">SubContrato</td>
				  <td align="center" width="110">Contrato Interno</td>
                  <td align="center" width="344">Producto-SubProducto</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>Contratos</td>
            <td> 
              <?php
					echo "<SELECT name='CmbContrato' style='width:600' onchange='Recarga(1)'>";
					echo "<option value='-1'>Seleccionar</option>";
					$Consulta="SELECT t1.contrato_vent,t1.confeccion,t1.cod_cliente,t1.nom_contrato,t1.num_contrato,t1.num_subcontrato,t1.cod_producto,t1.cod_subproducto,t2.descripcion as producto,t3.descripcion as subproducto,peso_vendido";
					$Consulta=$Consulta." from sec_web.det_contrato t1 left join proyecto_modernizacion.productos t2 ";
					$Consulta=$Consulta." on t1.cod_producto=t2.cod_producto left join proyecto_modernizacion.subproducto t3 on ";
					$Consulta=$Consulta."t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
					$Consulta=$Consulta." where vigente='V'";
					
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						$Valor=$Fila[num_contrato]."~~".$Fila[num_subcontrato]."~~".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"];
						if ($CmbContrato==$Valor)
						{								
							echo "<option value='".$Fila[num_contrato]."~~".$Fila[num_subcontrato]."~~".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."' SELECTed>".str_pad($Fila[num_contrato],6,'0',STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;".str_pad($Fila[num_subcontrato],6,'0',STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".str_pad($Fila[contrato_vent],6,'0',STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;".$Fila["producto"]." - ".$Fila["subproducto"]."</option>";
							$TxtNombreContrato=$Fila[nom_contrato];
							$TxtPesoContrato=$Fila[peso_vendido];
							$CodCliente=$Fila["cod_cliente"];
							$Confeccion=$Fila[confeccion];
						}
						else
						{
							echo "<option value='".$Fila[num_contrato]."~~".$Fila[num_subcontrato]."~~".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."'>".str_pad($Fila[num_contrato],6,'0',STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;".str_pad($Fila[num_subcontrato],6,'0',STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".str_pad($Fila[contrato_vent],6,'0',STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;".$Fila["producto"]." - ".$Fila["subproducto"]."</option>";
						}	
					}						
					echo "</SELECT>";
			  ?>
            </td>
          </tr>
          <tr> 
            <td>Nombre Contrato</td>
            <td> 
              <?php
 				 if ($CmbContrato!='-1')
				 {
				 	echo "<input type='text' name='TxtNombreContrato' style='width:500' readonly value='$TxtNombreContrato' class='detalle01'>";
				 }
				 else
				 {
					echo "<input type='text' name='TxtNombreContrato' style='width:500' readonly value='' class='detalle01'>";				 
				 }	
  			  ?>
            </td>
          </tr>
          <td>Nombre Cliente</td>
          <td> 
            <?php
 				 if ($CmbContrato!='-1')
				 {
				 	$Consulta="SELECT * from sec_web.cliente_venta where cod_cliente='".$CodCliente."'";
					$Respuesta=mysqli_query($link, $Consulta);	
					$Fila=mysqli_fetch_array($Respuesta);
					echo "<input type='text' name='TxtNombreCliente' style='width:500' readonly value='".$Fila["nombre_cliente"]."' class='detalle01'>";
				 }
				 else
				 {
					echo "<input type='text' name='TxtNombreCliente' style='width:500' readonly value='' class='detalle01'>";				 
				 }	
  			  ?>
          </td>
          </tr>
          <td>Destino(Opcional)</td>
          <td> 
            <?php
					echo "<SELECT name='CmbDestino' style='width:500'>";
					echo '<option value="-1" SELECTed>Seleccionar</option>';	
					$Consulta = "SELECT * from sec_web.sub_cliente_vta where cod_cliente='$CodCliente' order by comuna";
					$Respuesta = mysqli_query($link, $Consulta);
					while($Fila = mysqli_fetch_array($Respuesta))
					{
						if($Fila["cod_cliente"]."~~".$Fila["cod_sub_cliente"] == $CmbDestino)
							echo '<option value="'.$Fila["cod_cliente"]."~~".$Fila["cod_sub_cliente"].'" SELECTed>'.$Fila[ciudad].' - '.$Fila["comuna"].' - '.$Fila["direccion"].'</option>';
						else	
							echo '<option value="'.$Fila["cod_cliente"]."~~".$Fila["cod_sub_cliente"].'">'.$Fila[ciudad].' - '.$Fila["comuna"].' - '.$Fila["direccion"].'</option>';
					}
					echo "</SELECT>";
  			  ?>
          </td>
          </tr>
          <?php
				echo "<tr>";
				echo "<td>&nbsp;";
				echo "</td>";
				echo "<td>";
				if ($CmbContrato!='-1')
				{
					$Valor=explode('~~',$CmbContrato);
					$TxtPesoMaximo=0;
					$TxtPeso=0;
					$Consulta="SELECT corr_ie,peso from sec_web.det_contrato_por_ie where num_contrato='".$Valor[0]."' and num_subcontrato='".$Valor[1]."'";
					$Consulta.=" and cod_producto ='".$Valor[2]."' and cod_subproducto='".$Valor[3]."'";
					$Respuesta=mysqli_query($link, $Consulta);
					echo "<table border='1' cellspacing='0' cellpadding='0' class='TablaInterior'>";
					echo "<tr class='ColorTabla01'>";
					echo "<td align='center'>&nbsp;IE&nbsp;</td>";
					echo "<td align='center'>&nbsp;Peso&nbsp;Ton.</td>";
					echo "</tr>";
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						echo "<tr>";
						echo "<td align='center'>&nbsp;$Fila["corr_ie"]&nbsp;</td>";
						echo "<td align='right'>&nbsp;$Fila["peso"]&nbsp;</td>";
						echo "</tr>";
						$TxtPeso=$TxtPeso+$Fila["peso"];
					}
					echo "<tr class='Detalle01'>";
					echo "<td align='center'>Total</td>";
					echo "<td align='right'>&nbsp;$TxtPeso&nbsp;</td>";
					echo "</tr>";
					$TxtPeso=$TxtPesoContrato-$TxtPeso;
					$TxtPesoMaximo=$TxtPeso;
					echo "</table><strong>Peso Maximo De La IE: ".$TxtPesoMaximo." Ton.<strong>";
				}
				else
				{
					$TxtPesoContrato=0;
					$TxtPeso=0;
				}	
				echo "</td>";
				echo "</tr>";
			?>
          <tr> 
            <td>Peso Contrato</td>
            <td> 
              <?php
				echo "<input type='text' name='TxtPesoContrato' style='width:60' value='$TxtPesoContrato' readonly class='Detalle01'>&nbsp;Ton.&nbsp;&nbsp;";
			?>
            </td>
          </tr>
          <td>Peso IE</td>
          <td> 
            <?php
				echo "<input type='text' name='TxtPeso' style='width:60' maxlength='6' value='$TxtPeso' onkeydown='TeclaPulsada(true)'>&nbsp;Ton.";			
			?>
          </td>
          </tr>
          <tr>
            <td>Confeccion</td>
			<td><strong>
				<?php 
					if ($Confeccion=='G')
					{
						echo "GRANEL";
					}
					else
					{
						echo "LOTE";
					}
					echo "<input type='hidden' name='Confeccion' value='$Confeccion'>";
				?>
			</strong></td>
            <!--<td>Granel&nbsp;<input type="radio" name='OpcConfeccion' value=''>&nbsp&nbsp;&nbsp;Lote&nbsp;<input type="radio" name='OpcConfeccion' value=''></td>-->
          </tr>
          <!--<tr>
            <td>Pago Transporte</td>
            <td>Enami&nbsp;<input type="radio" name='OpcPago' value=''>&nbsp&nbsp;&nbsp;Cliente&nbsp;<input type="radio" name='OpcPago' value=''></td>
          </tr>-->
		  
        </table>
        <br>
        <table width="750" border="0" cellpadding="0" class="TablaInterior">
          <tr align="center"> 
            <td  align="center">
			  <input type="button" name="BtnGrabar" value="Grabar" style="width:75" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>','<?php echo $TxtPesoMaximo;?>','<?php echo $Confeccion;?>')">&nbsp;
              <input type="button" name="BtnSalir" value="Salir" style="width:75" onClick="Salir();">
            </td>
          </tr>
        </table></td>
  </tr>
</table>
  <?php include("../principal/pie_pagina.php")?>
  </form>
</body>
</html>
