<?php 	
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 1;
	include("../principal/conectar_ref_web.php");
	$mostrar='S';
?>
<html>
<head>
<title>Grafico Pulido de Placas (Placas Negras-Placas con Pernos) entre <?php echo $FechaInicio;?> y <?php echo $FechaTermino;?></title>
<LINK href="archivos/petalos.css" type=text/css rel=stylesheet>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngCircuito" method="post" action="">
  <table width="770" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td align="center">
	  <br>
	  <table width="700" border="4" class="tablainterior">
	  <?php 
	     $opcion='PN';
		 echo "<img src='ref_grafico_estadistica_pulido_placas.php?FechaInicio=".$FechaInicio."&FechaTermino=".$FechaTermino."&opcion=".$opcion."'>"; 
      ?>
	  </table>
	  <table width="700" border="4" class="tablainterior">
	  <?php 
	     $opcion='PP';
		 echo "<img src='ref_grafico_estadistica_pulido_placas.php?FechaInicio=".$FechaInicio."&FechaTermino=".$FechaTermino."&opcion=".$opcion."'>"; 
      ?>
       </table>
	 <br>
   <br></td>
  </tr>
</table>
</form>
</body>
</html>

