<?php 	
	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_pac_web.php");
	switch($Proceso)
	{
		case "N":
			/*$Consulta = "select max(cod_subclase) as Cod_Mayor from proyecto_modernizacion.sub_clase where cod_clase = 2003";
			$Resultado = mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resultado);
			$Codigo=$Fila["Cod_Mayor"]+1;*/
			break;
		case "M":
			$Datos=substr($Valores,0,strlen($Valores)-2);
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				
				//	echo "Datos".$Datos."<br>";
					$arr=explode('~',$Datos);
					//echo "0 =>".$arr[0]."<br>";
					//echo "1 =>".$arr[1]."<br>";
					
					$RutDv=$arr[0];
					$corr_interno_cliente=$arr[1];
					for ($j=0;$j<=strlen($RutDv);$j++)
					{
						if (substr($RutDv,$j,1)=="-")
						{
							$Rut=substr($RutDv,0,$j);
							$DV=substr($RutDv,$j+1);
							$RutCliente=$Rut."-".$DV;
							
						}
					}						
					break;
				
			}
			$Consulta="select * from pac_web.clientes where rut_cliente='".$RutCliente."' and corr_interno_cliente='".$corr_interno_cliente."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Referencia=$Fila["referencia"];
			$Nombre=$Fila["nombre"];
			$corr_interno_cliente=$Fila["corr_interno_cliente"];
			$Direccion=$Fila["direccion"];
			$Ciudad=$Fila["ciudad"];
			$Telefono=$Fila["telefonos"];
			$Fax=$Fila["fax"];
			$Precio=$Fila["precio_us"];
			$DivSap=$Fila["div_sap"];
			$AlmacenSap=$Fila["almacen_sap"];
			$Glosa=$Fila["glosa"];
			$Giro=$Fila["giro_cliente"];
			$Contrato=$Fila["contrato"];
			$Indicador=$Fila["indicador_traslado"];
			$ConsultaIndTras= "select * from pac_web.pac_indicador_traslado where indicador=".$Indicador;
				$ResultTras=mysqli_query($link, $ConsultaIndTras);
				while ($FilaTras=mysqli_fetch_array($ResultTras))
					{
						$IndicadorTraslado = $FilaTras["nombre"];
					}
			break;	
	}	

?>
<html>
<head>
<script language="JavaScript">
/*document.onkeydown = TeclaPulsada; 

function TeclaPulsada (tecla) 
{ 
var teclaCodigo = event.keyCode; 
var teclaReal = String.fromCharCode(teclaCodigo); 
alert("C�digo de la tecla: " + teclaCodigo + "\nTecla pulsada: " + teclaReal); 
}*/ 


function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtRut.value == "")
	{
		alert("Debe Ingresar Rut del Cliente")
		Frm.TxtRut.focus();
		return;
	}
	if (Frm.TxtDv.value == "")
	{
		alert("Debe Ingresar Digito del Cliente")
		Frm.TxtDv.focus();
		return;
	}	
	if (Frm.TxtReferencia.value == "")
	{
		alert("Debe Ingresar Referencia")
		Frm.TxtReferencia.focus();
		return;
	}
	if (Frm.TxtNombre.value == "")
	{
		alert("Debe Ingresar Nombre del Cliente")
		Frm.TxtNombre.focus();
		return;
	}
	if (Frm.TxtDireccion.value == "")
	{
		alert("Debe Ingresar Direcci�n")
		Frm.TxtNombre.focus();
		return;
	}
	if (Frm.TxtCiudad.value == "")
	{
		alert("Debe Ingresar Ciudad")
		Frm.TxtNombre.focus();
		return;
	}
	Frm.action="pac_ingreso_clientes_proceso01.php?Proceso="+Proceso+"&TxtRut="+Frm.TxtRut.value+"&TxtDv="+Frm.TxtDv.value+"&Valores="+Valores;
	Frm.submit();
	
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	if ($Proceso=='N')
	{
		echo "<body onload='document.FrmProceso.TxtRut.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
	else
	{
		echo "<body onload='document.FrmProceso.TxtReferencia.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
?>

<form name="FrmProceso" method="post" action="">
  <table width="100%" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="100%" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td>Rut</td>
            <td>
				<?php
					if ($Proceso=='M')
					{
						echo "<input type='text' name='TxtRut' style='width:70%' maxlength='10' disabled value='$Rut'>&nbsp;-&nbsp;<input type='text' name ='TxtDv' style='width:20' disabled maxlength='2' value='$DV'>";					
						echo "<input type='hidden' name='TxtCorrCliente' value='$corr_interno_cliente'>";					
					}
					else
					{
						echo "<input type='text' name='TxtRut' style='maxlength='30'>&nbsp;-&nbsp;<input type='text' name ='TxtDv'style='width:20' maxlength='1'><span class='InputRojo'>(*)</span>";
						echo "<input type='hidden' name='TxtCorrCliente'  value='$corr_interno_cliente'>";					
					}	
				?>
			</td>
			<td>Referencia</td>
            <td><input type="text" name="TxtReferencia" style="width:100%" maxlength="12" value="<?php echo $Referencia;?>"></td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td colspan="3"><input type="text" name="TxtNombre" style="width:90%" maxlength="40" value="<?php echo $Nombre; ?>"><span class=" InputRojo">(*)</span></td>
          </tr>
          <tr> 
            <td>Direcci&oacute;n</td>
            <td colspan="3"><input type="text" name="TxtDireccion" style="width:90%" maxlength="40" value="<?php echo $Direccion;?>"><span class=" InputRojo">(*)</span></td>
          </tr>
          <tr>
            <td>Ciudad</td>
            <td colspan="2"><input type="text" name="TxtCiudad" style="width:90%" maxlength="25" value="<?php echo $Ciudad;?>"><span class=" InputRojo">(*)</span></td>
          </tr>
          <tr>
          <td>Indicador de Traslado</td>
            <td colspan="3">
            <?php	
				echo "<select name='CmbTras'  onChange=Recarga('$Proceso','$Valores');>";
				if ($Proceso=="N") {
				echo "<option value ='-1' selected>Seleccionar</option> ";
				}
				$ConsultaInd="select * from pac_web.pac_indicador_traslado order by indicador";
				$RespuestaInd=mysqli_query($link, $ConsultaInd);
				while ($FilaIndTras=mysqli_fetch_array($RespuestaInd))
				{
					if ($Indicador==$FilaIndTras[indicador])
						{
						echo "<option value ='$FilaIndTras[indicador]' selected>$FilaIndTras[indicador]&nbsp;-&nbsp;$FilaIndTras["nombre"]</option>";
						}
					else
						echo "<option value ='$FilaIndTras[indicador]' >$FilaIndTras[indicador]&nbsp;-&nbsp;$FilaIndTras["nombre"]</option>";
				}
				echo "</select>";
			?><span class=" InputRojo">(*)</span>
            </td>
          </tr>
          <tr> 
            <td>Telefonos</td>
            <td colspan="2"><input type="text" name="TxtTelefonos" style="width:100%" maxlength="30" value="<?php echo $Telefono;?>"></td>
          </tr>
          <tr> 
            <td>Fax</td>
            <td><input type="text" name="TxtFax" style="width:90%" maxlength="20" value="<?php echo $Fax;?>"></td>
          	<td>Divisi&oacute;n SAP</td>
            <td><input type="text" name="TxtDivSAP" maxlength="4" value="<?php echo $DivSap;?>"></td>
          </tr>
          <tr> 
            <td>Precio US$</td>
            <td><input type="text" name="TxtPrecioUS" style="width:90%" maxlength="10" value="<?php echo $Precio;?>"></td>
            <td>Almac&eacute;n SAP</td>
            <td><input type="text" name="TxtAlmacenSap" maxlength="6" value="<?php echo $AlmacenSap;?>"></td>
 		  </tr>
 		  <tr> 
            <td>Giro Cliente</td>
            <td><input type="text" name="TxtGiroCliente" style="width:90%" maxlength="20" value="<?php echo $Giro;?>"></td>
            <td>Contrato</td>
            <td><input type="text" name="TxtContrato" maxlength="50" value="<?php echo $Contrato;?>"></td>
          </tr>
 		  <tr> 
            <td>Glosa</td>
            <td colspan="3"><input maxlength="50" style="width:65%"  name="TxtGlosa" value="<?php echo $Glosa;?>"></input></td>
 		  </tr>
        </table>
        <br>
        <table width="100%" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
