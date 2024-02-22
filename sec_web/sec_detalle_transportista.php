<?php
include("../principal/conectar_pmn_web.php");

$ValoresIE = isset($_REQUEST["ValoresIE"])?$_REQUEST["ValoresIE"]:"";
$Envio     = isset($_REQUEST["Envio"])?$_REQUEST["Envio"]:"";

?>
<html>
<head>
<title>Detalle Transportista</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Salir()
{
	window.close();
}			
function Eliminar()
{
	var Frm=document.frmConsulta;
	var ValoresCheck="";
	var Checkeo="";
	for (i=1;i<Frm.checkbox.length;i++)
	{
		if (Frm.checkbox[i].checked==true)
		{
			ValoresCheck =ValoresCheck + Frm.checkbox[i].value + "//" ;
			Checkeo=true;
		}	
	}
	if (Checkeo==false)
	{
		alert("Debe seleccionar un Elemento");
	}
	else
	{
		ValoresCheck=ValoresCheck.substr(0,ValoresCheck.length-2);
		Frm.action="sec_autorizacion_despacho01.php?ValoresCheck="+ValoresCheck+"&Envio="+Frm.EnvioAux.value+"&Proceso=EliminarTransportista";
		Frm.submit();
	}
}	
</script>
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">
<input type="hidden" value="<?php echo $Envio  ?>" name="EnvioAux">
  <br>
  <table width="442" border="0">
    <tr>
      <td width="436" align="center"> &nbsp; <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70px" onClick="Eliminar();" value="Eliminar">
        <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Salir('');">
    </td>
  </tr>
</table>
<br>
  <table width="447" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="15"></td>
	  <td width="194"><strong>Rut Transportista</strong></td>
      <td width="247"><strong>Nombre</strong></td>
    </tr>
    <?php  
	$Consulta="SELECT t2.rut_transportista,t1.corr_enm,t2.nombre_transportista from sec_web.relacion_transporte_inst_embarque t1 		";
	$Consulta.=" inner join sec_web.transporte t2 on t1.rut_transportista=t2.rut_transportista	";
	$Consulta.=" where corr_enm='".$ValoresIE."'   group by rut_transportista			";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<input name='checkbox' type='hidden'>";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n"; 
		echo "<td><input type='checkbox' name='checkbox' value='".$Row["rut_transportista"]."~~".$Row["corr_enm"]."'></td>";
		echo "<td align='center'>".$Row["rut_transportista"]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row["nombre_transportista"]."&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>
  </table>
</form>
</body>
</html>
