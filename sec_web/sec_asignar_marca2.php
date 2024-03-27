<?php 
include("../principal/conectar_pmn_web.php");

?>
<html>
<head>
<title>Lista de Marca Catodos</title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(valor,valor2)
{	
	window.opener.document.frm1.txtmarca.value = valor;
	window.opener.document.frm1.txtnommarca.value = valor2;
	window.close();
}
function Salir()
{
	window.close();
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">

<table width="650" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
  <tr> 
      <td width="116">&nbsp;</td>
      <td width="343"><div align="center"> &nbsp; 
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Salir()" style="width:70px">
        </div></td>
      <td width="166">&nbsp;</td>
  </tr>
</table>
<br>
  <table width="666" border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>
    <?php  
	$Consulta="select cod_marca,descripcion from sec_web.marca_catodos";
	echo "<tr>\n";
	$Respuesta = mysqli_query($link, $Consulta);
	$cont=1;	
	echo "<input type='hidden' name='IdMarca'> ";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		if($cont==8) 
		{
			echo '</tr>';
			echo '<tr>';
			$cont=1;
		}
		//echo "<input type='radio'  name='IdFecha' value='".$Row["fecha"]."' onClick=\"Proceso('E');\">\n";
		//echo "<td><input type='radio' name='IdMarca' value='".$Row["cod_marca"]."' onClick=\"Proceso('E','$Codigo','$Ano','$Numero');\">\n";
		echo "<td><input type='radio' name='IdMarca' onClick=\"Proceso('".$Row["cod_marca"]."','".$Row["descripcion"]."');\">\n";
		echo " '".$Row["descripcion"]."' </td>";
		$cont =$cont+ 1;
	}
?>
  </table>
</form>
</body>
</html>
