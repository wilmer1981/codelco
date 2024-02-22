<?php include("../principal/conectar_pmn_web.php");?>
<html>
<head>
<title>Lista de Transportista</title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Salir()
{
	var Frm = document.FrmTransportista;
	window.close();
}
function Proceso(Valores)
{
	var Frm = document.FrmTransportista;
	var Checkeo=false;
	var Valores2="";
	
	for (i=1;i<Frm.RutTransporte.length;i++)
	{
		if (Frm.RutTransporte[i].checked == true)
		{
			Valores2=Valores2+ Frm.RutTransporte[i].value + "//";
			Checkeo=true;
		}
	}
	if(Checkeo==true)
	{
		Valores2=Valores2.substr(0,Valores2.length-2);
		Frm.action="sec_distribuir_lote01.php?Proceso=E&Tipo=V&Valores="+Valores+"&Valores2="+Valores2;
		Frm.submit();
	}
	else
	{
		alert("Debe Seleccionar un Transportista");
	}
}
</script>
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmTransportista" action="" method="post">
<table width="650" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
  <tr> 
      <td width="116">&nbsp;</td>
      <td width="343"><div align="center">&nbsp; 
          <input name="btnAceptar" type="button" id="btnAceptar" style="width:70px" onClick="Proceso('<?php echo $Valores?>');" value="Aceptar">
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Salir();" style="width:70px">
        </div></td>
      <td width="166">&nbsp;</td>
  </tr>
</table>
<br>
  <table width="650" border='1' cellpadding='3' cellspacing='0'>
  <?php  
	echo "<tr>\n";
	$Consulta=" select rut_transportista,nombre_transportista from ";
 	$Consulta.=" sec_web.transporte  group by rut_transportista ";
    $Consulta.=" order by nombre_transportista ";
	$Respuesta = mysqli_query($link, $Consulta);
	$cont=1;	
	echo "<input type='hidden' name='RutTransporte'>";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		if($cont==6) 
		{
			echo '</tr>';
			echo '<tr>';
			$cont=1;
		}
		echo "<td><input type='checkbox' name='RutTransporte' value='".$Row["rut_transportista"]."'>\n";
		echo "$Row[nombre_transportista]</td>";
		$cont =$cont+ 1;
	}
  ?>
  </table>
</form>
</body>
</html>
