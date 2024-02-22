<?php
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else {
		$Valores = "";
	}

	$Datos=explode('//',$Valores);
	$Rut=$Datos[0];
		
?>
<html>
<head>
<title>Funcionario</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso()
{	
	window.close();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
  <table width="450" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center"> 
      <td colspan="2"><strong>
	  <?php
		  $Consulta="select * from proyecto_modernizacion.funcionarios where rut='$Rut'";
 		  $Resultado=mysqli_query($link, $Consulta);
		  $Fila=mysqli_fetch_array($Resultado);
		  echo ucwords(strtolower($Fila["apellido_paterno"]))."&nbsp;".$Fila["apellido_materno"]."&nbsp;".$Fila["nombres"];
	  ?></strong></td>
    </tr>
  </table>
  <br>
  <table width="450" height="99" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center"> 
      
    <td height="79" colspan="2">
	<?php
			echo "<img width='250' height='300' src='http://10.56.11.6/bd_rrhh/fotos/".$Rut.".JPG'>";
	?>
	&nbsp;</td>
    </tr>
  </table>
  <br>  
  <table width="450" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr>
      <td align="center"><input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width=80" onClick="Proceso()"></td>
    </tr>
  </table>
</form>
</body>
</html>
