<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
if(!isset($CmbContr))
	$CmbContr='-1';		
?>
<html>
<head>
<title>Reporte Ingresos Proyectados Cu Ag Au Excel</title>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<form name="frmPrincipal" action="" method="post">
  <?  
  echo $CmbProductos;
  switch($CmbProductos)
  {
	case "1":
		include('pcip_rpt_ingresos_proyectados_cobre.php');
	break;
	case "2":
		include('pcip_rpt_ingresos_proyectados_plata.php');
	break;
	case "3":
		include('pcip_rpt_ingresos_proyectados_oro.php');
	break;			
  }
  ?>
</form>
</body>
</html>
