<?php
   include("../principal/conectar_ref_web.php");
   include("../principal/graficos/phpchartdir.php");

	$DiaIni    = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
	$MesIni    = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$AnoIni    = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");
	$DiaFin    = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d");
	$MesFin    = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
	$AnoFin    = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	$cmbgrupo  = isset($_REQUEST["cmbgrupo"])?$_REQUEST["cmbgrupo"]:"";

	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;

 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	$FechaInicio2=$DiaIni."-".$MesIni."-".$AnoIni;
    $FechaTermino2=$DiaFin."-".$MesFin."-".$AnoFin;

   $cmbgrupo=intval($cmbgrupo);
   $consulta="select * from ref_web.produccion where cod_grupo='".$cmbgrupo."' and fecha between '".$FechaInicio."' and '".$FechaTermino."'";
   $respuesta=mysqli_query($link, $consulta);
   $i=0;
   while ($row=mysqli_fetch_array($respuesta))
	  {
	   $row["fecha"]=substr($row["fecha"],8,2).'-'.substr($row["fecha"],5,2).'-'.substr($row["fecha"],0,4);
	   $arreglo_fecha[$i]=$row["fecha"];
	   $arreglo_delgadas[$i]=$row["rechazo_delgadas"];
	   $arreglo_granuladas[$i]=$row["rechazo_granuladas"];
	   $arreglo_gruesas[$i]=$row["rechazo_gruesas"];
	   $i++;
	  
	  }
$data0 = $arreglo_delgadas;
$data1 = $arreglo_granuladas;
$data2 = $arreglo_gruesas;
$labels = $arreglo_fecha;

$c = new XYChart(920, 720);

$c->setPlotArea(70, 35, 800, 500);

$c->addTitle("Rechazo de Laminas Iniciales desde ".$FechaInicio2." a ".$FechaTermino2."", "mtcorsva.ttf", 20, 0x80);
/*para cambiar posicion de cuadro de informacion aqui abajo se hace*/
$legendObj = $c->addLegend(750, 35, true, "timesbd.ttf", 12); /* <------------------------ */
$legendObj->setBackground(0xd0d0d0, 0xd0d0d0, 1);

$titleObj = $c->yAxis->setTitle("Rechazos", "arialbd.ttf",12, 0x80);
$titleObj->setBackground(0xffff00, 0xffff00, 2);

$c->yAxis->setLabelStyle("impact.ttf", 10, 0xcc6600);

$c->yAxis->setLabelFormat("{value}");

$labelStyleObj = $c->xAxis->setLabelStyle("impact.ttf", 10, 0x8000);
$labelStyleObj->setFontAngle(45);

$c->xAxis->setLabels($labels);

$layer = $c->addBarLayer2(Stack, 5);

$layer->setDataLabelStyle("ariali.ttf");

$aggregateLabelStyleObj = $layer->setAggregateLabelStyle("timesbi.ttf", 10);
$aggregateLabelStyleObj->setBackground(0xffcc66, Transparent, 1);

$layer->addDataSet($data0, -1, "Delgadas");

$layer->addDataSet($data1, -1, "Granuladas");

$dataSetObj = $layer->addDataSet($data2, -1, "Gruesas");
$textbox = $dataSetObj->setDataLabelStyle("arialbi.ttf");

$textbox->setFontColor(0xffff00);

$textbox->setBackground(SameAsMainColor, Transparent, 1);

header("Content-type: image/png");
print($c->makeChart2(PNG));
include("../principal/cerrar_ref_web.php"); 
?>
