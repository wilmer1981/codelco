<html>
<head>
</script>
<title>Ingreso de Parametros</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngClaseSubclase" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="middle"><strong><span style="color:#0000FF ">&nbsp;
<?php
	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	switch ($Proceso)
	{
		case "NoAuto":
			echo "LA SESION YA ESTA ACTIVA EN OTRO COMPUTADOR";
			break;
		case "T_Fuera":
			echo "POR SEGURIDAD SU TIEMPO DE SESION HA TERMINADO<BR>POR FAVOR REINGRESE...";
			break;
	}
?>	
<br>
<br>
<a href="../index.php">Inicio</a></span></strong></td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>