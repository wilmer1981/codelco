<?php
   include("../principal/conectar_ref_web.php");

   $FechaInicio     = isset($_REQUEST["FechaInicio"])?$_REQUEST["FechaInicio"]:""; 
   $FechaTermino    = isset($_REQUEST["FechaTermino"])?$_REQUEST["FechaTermino"]:""; 
   $cmbcircuito = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:""; 
   
   $i=0;
   $consulta_fecha="select distinct(fecha) as fecha from ref_web.cortocircuitos where fecha between '".$FechaInicio."' and '".$FechaTermino."'";
   $respuesta_fecha=mysqli_query($link, $consulta_fecha);
   while ($row_fecha=mysqli_fetch_array($respuesta_fecha))
      { 
	    
		$consulta_datos="select fecha,ifnull((sum(cortos_nuevo)+sum(cortos_semi)),0) as suma ";
		$consulta_datos.="from ref_web.cortocircuitos  ";
		$consulta_datos.="where fecha ='".$row_fecha["fecha"]."' and cod_circuito='".$cmbcircuito."' ";
		$consulta_datos.="group by fecha, cod_circuito ";
		$consulta_datos.="order by fecha,cod_circuito,cod_grupo";
		$respuesta_datos=mysqli_query($link, $consulta_datos);
		$row_datos=mysqli_fetch_array($respuesta_datos);
		$arreglo_fecha[$i]=$row_fecha["fecha"];
		$arreglo_cortos[$i]=$row_datos["suma"];
		if ($valor_max_y<$row_datos["suma"])
		    {
			  $valor_max_y=$row_datos["suma"];
			}
		$consulta_referencial="select ref_cir from ref_web.referenciales where cod_circuito='".$cmbcircuito."' and ";
		$consulta_referencial.="fecha=(select max(fecha) from ref_web.referenciales where cod_circuito='".$cmbcircuito."' and fecha <= '".$row_fecha["fecha"]."') ";
	    $respuesta_referencial = mysqli_query($link, $consulta_referencial);
		$row_referencial = mysqli_fetch_array($respuesta_referencial);
		if ($valor_max_y<$row_referencial["ref_cir"])
		    {
			  $valor_max_y=$row_referencial["ref_cir"]+10;
			}
		$arreglo_referencial[$i]=$row_referencial["ref_cir"];
		$i++;
	 }	
			  
//include("phpchartdir.php");
require_once("phpchartdir.php");

$data0 = $arreglo_cortos;
$data1 = $arreglo_referencial;
$data2 = $arreglo_referencial;

#The labels for the line chart
$labels =  $arreglo_fecha;

#Create a XYChart object of size 500 x 300 pixels
$c = new XYChart(420, 290);

#Set background color to pale yellow 0xffff80, with a black edge and a 1
#pixel 3D border
$c->setBackground(0xffff80, 0x0, 1);

#Set the plotarea at (55, 45) and of size 420 x 210 pixels, with white
#background. Turn on both horizontal and vertical grid lines with light
#grey color (0xc0c0c0)
$c->setPlotArea(55, 45, 350, 150, 0xffffff, -1, -1, 0xc0c0c0, -1);

#Add a legend box at (55, 25) (top of the chart) with horizontal layout.
#Use 8 pts Arial font. Set the background and border color to Transparent.
$legendObj = $c->addLegend(55, 25, false, "", 8);
$legendObj->setBackground(Transparent);

#Add a title box to the chart using 11 pts Arial Bold Italic font. The text
#is white (0xffffff) on a dark red (0x800000) background, with a 1 pixel 3D
#border.
$titleObj = $c->addTitle("Cortociruitos desde ".$FechaInicio." al ".$FechaTermino." Circuito N� ".$cmbcircuito."", "arialbi.ttf", 11, 0xffffff);
$titleObj->setBackground(0x800000, -1, 1);

#Add a title to the y axis
//echo $valor_y;
$c->yAxis->setLinearScale(0, $valor_max_y, 50);

$c->yAxis->setTitle("Cortocircuitos");

#Set the labels on the x axis
//$c->xAxis->setLabels($labels);
$labelsObj = $c->xAxis->setLabels($labels);
$labelsObj->setFontAngle(90);

#Add a title to the x axis
$c->xAxis->setTitle("Fecha");

#Add a line layer to the chart
$layer = $c->addLineLayer();

#Set the default line width to 3 pixels
$layer->setLineWidth(2);

#Add the three data sets to the line layer
//$layer->addDataSet($data0, -1, "cortocircuitos");
//$layer->addDataSet($data1, -1, "Referencial");
$dataSetObj = $layer->addDataSet($data0, 0xcf4040, "Cortocircuito Global Circuito Diario   ");
$dataSetObj->setDataSymbol(SquareSymbol, 3);
	   
$dataSetObj = $layer->addDataSet($data1, 0x40cf40, "Referencial");
$dataSetObj->setDataSymbol(DiamondSymbol, 3);
//$layer->addDataSet($data2, -1, "Referencial");

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));
echo "</tr>\n";
include("../ref_web/grafico_riles.php?fecha=".$fecha);
?>