<?php 	
	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_pac_web.php");
	switch($Proceso)
	{
		case "N":
			break;
		case "M":
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$RutDv=substr($Datos,0,$i);
					for ($j=0;$j<=strlen($RutDv);$j++)
					{
						if (substr($RutDv,$j,1)=="-")
						{
							$Rut=substr($RutDv,0,$j);
							$DV=substr($RutDv,$j+1);
							$RutTransp=$Rut."-".$DV;
						}
					}						
					break;
				}
			}
			$Consulta="select * from pac_web.transportista where rut_transportista='".$RutTransp."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Nombre=$Fila["nombre"];
			$Direccion=$Fila["direccion"];
			$Ciudad=$Fila["ciudad"];
			$Telefono=$Fila["telefono"];
			$Fax=$Fila["fax"];
			$Giro=$Fila["giro_transp"];
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
		alert("Debe Ingresar Rut")
		Frm.TxtRut.focus();
		return;
	}
	if (Frm.TxtDv.value == "")
	{
		alert("Debe Ingresar Digito")
		Frm.TxtDv.focus();
		return;
	}	
	if (Frm.TxtNombre.value == "")
	{
		alert("Debe Ingresar Nombre")
		Frm.TxtNombre.focus();
		return;
	}
	if (Frm.TxtGiro.value == "")
	{
		alert("Debe Ingresar el giro del Transportista")
		Frm.TxtGiro.focus();
		return;
	}
	Frm.action="pac_ingreso_transportista_proceso01.php?Proceso="+Proceso+"&TxtRut="+Frm.TxtRut.value+"&TxtDv="+Frm.TxtDv.value+"&Valores="+Valores;
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
		echo "<body onload='document.FrmProceso.TxtNombre.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
?>

<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td>Rut</td>
            <td> 
              <?php
					if ($Proceso=='M')
					{
						echo "<input type='text' name='TxtRut' style='width:80' maxlength='10' disabled value='$Rut'>&nbsp;-&nbsp;<input type='text' name ='TxtDv' style='width:20' disabled maxlength='2' value='$DV'>";					
					}
					else
					{
						echo "<input type='text' name='TxtRut' style='width:80' maxlength='10'>&nbsp;-&nbsp;<input type='text' name ='TxtDv'style='width:20' maxlength='1'>";
					}	
				?><span class=" InputRojo">(*)</span>
            </td>
          </tr>
          <tr> 
            <td>Nombre</td>
            <td><input type="text" name="TxtNombre" style="width:285" maxlength="40" value="<?php echo $Nombre; ?>"><span class=" InputRojo">(*)</span>
            </td>
          </tr>
          <tr> 
            <td>Direcci&oacute;n</td>
            <td><input type="text" name="TxtDireccion" style="width:300" maxlength="40" value="<?php echo $Direccion;?>"></td>
          </tr>
          <tr> 
            <td>Ciudad</td>
            <td><input type="text" name="TxtCiudad" style="width:200" maxlength="25" value="<?php echo $Ciudad;?>"></td>
          </tr>
          <tr> 
            <td>Tel&eacute;fonos</td>
            <td><input type="text" name="TxtTelefono" style="width:200" maxlength="30" value="<?php echo $Telefono;?>"></td>
          </tr>
          <tr> 
            <td>Fax</td>
            <td><input type="text" name="TxtFax" maxlength="20" value="<?php echo $Fax;?>"></td>
          </tr>
          <tr> 
            <td>Giro Transportista</td>
            <td><input type="text" name="TxtGiro" maxlength="20" value="<?php echo $Giro;?>">
            <span class=" InputRojo">(*)</span></td>
          </tr>
<!--           <tr> 
            <td>Indicador de Traslado</td>
            <td>
            <?php	
/*				echo "<select name='CmbTras' style='width:100%' onChange=Recarga('$Proceso','$Valores');>";
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
				echo "</select>";*/
			?>
            </td>
          </tr> -->
        </table>
        <br>
        <table width="395" border="0" cellpadding="5" class="TablaInterior">
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
