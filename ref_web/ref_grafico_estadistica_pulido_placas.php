<?php
  include("../principal/conectar_ref_web.php");
  include("phpchartdir.php");
  $FechaInicio  = isset($_REQUEST["FechaInicio"])?$_REQUEST["FechaInicio"]:""; 
  $FechaTermino = isset($_REQUEST["FechaTermino"])?$_REQUEST["FechaTermino"]:""; 
  $opcion       = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";

    if ($opcion=='PN')
	{
	   $consulta="select distinct fecha from ref_web.pulido_placas where fecha between '".$FechaInicio."' and '".$FechaTermino."'";
	   $respuesta=mysqli_query($link, $consulta);
	   $i=0;
	    while ($row=mysqli_fetch_array($respuesta))
		{
			 $consulta_placas1="select sum(placas_negras) as placas_negras from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='1' order by fecha,cod_operacion,turno";
			 echo $consulta_placas;
			 $respuesta_placas1=mysqli_query($link, $consulta_placas1);
			 $row_placas1=mysqli_fetch_array($respuesta_placas1);
			 $consulta_placas2="select sum(placas_negras) as placas_negras from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='2' order by fecha,cod_operacion,turno";
			 $respuesta_placas2=mysqli_query($link, $consulta_placas2);
			 $row_placas2=mysqli_fetch_array($respuesta_placas2);
			 $consulta_placas3="select placas_negras as stock from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='3' and turno='B' order by fecha,cod_operacion,turno";
			 $respuesta_placas3=mysqli_query($link, $consulta_placas3);
			 $row_placas3=mysqli_fetch_array($respuesta_placas3);
			 $arreglo_placas1[$i]=$row_placas1["placas_negras"];
			 $arreglo_placas2[$i]=$row_placas2["placas_negras"];
			 $arreglo_stock[$i]=$row_placas3["stock"];
			 $arreglo_fecha[$i]=$row["fecha"];
			 $i++;
		}
	}
    else if ($opcion=='PP')
        {
           $consulta="select distinct fecha from ref_web.pulido_placas where fecha between '".$FechaInicio."' and '".$FechaTermino."'";
	       $respuesta=mysqli_query($link, $consulta);
	       $i=0;
	        while ($row=mysqli_fetch_array($respuesta))
			{
				 $consulta_placas1="select sum(placas_pernos) as placas_pernos from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='1' order by fecha,cod_operacion,turno";
				 echo $consulta_placas;
				 $respuesta_placas1=mysqli_query($link, $consulta_placas1);
				 $row_placas1=mysqli_fetch_array($respuesta_placas1);
				 $consulta_placas2="select sum(placas_pernos) as placas_pernos from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='2' order by fecha,cod_operacion,turno";
				 $respuesta_placas2=mysqli_query($link, $consulta_placas2);
				 $row_placas2=mysqli_fetch_array($respuesta_placas2);
				 $consulta_placas3="select placas_pernos as stock from ref_web.pulido_placas where fecha='".$row["fecha"]."' and cod_operacion='3' and turno='B' order by fecha,cod_operacion,turno";
				 $respuesta_placas3=mysqli_query($link, $consulta_placas3);
				 $row_placas3=mysqli_fetch_array($respuesta_placas3);
				 $arreglo_placas1[$i]=$row_placas1["placas_pernos"];
				 $arreglo_placas2[$i]=$row_placas2["placas_pernos"];
				 $arreglo_stock[$i]=$row_placas3["stock"];
				 $arreglo_fecha[$i]=$row["fecha"];
				 $i++;
		    }
 
        }	 
	 
	 
$data0 =  $arreglo_placas1;
$data1 = $arreglo_placas2;
$data2 = $arreglo_stock;
$labels = $arreglo_fecha;
$c = new XYChart(920, 720);
if ($opcion=='PN')
   {$encabezado='Placas Negras';}
else if ($opcion=='PP')
        {$encabezado='Placas con Pernos';}   
$c->addTitle("Grafico de ".$encabezado." entre ".$FechaInicio." y ".$FechaTermino." ", "", 10);
$plotAreaObj = $c->setPlotArea(45, 35, 820, 500);
$plotAreaObj->setBackground(0xffffc0, 0xffffe0);
$legendObj = $c->addLegend(50, 20, false, "", 8);
$legendObj->setBackground(Transparent);
$c->yAxis->setTitle("Cantidad de ".$encabezado."");
//$c->yAxis->setLinearScale(55, 80, 1);
$c->yAxis->setTopMargin(20);

$labelsObj = $c->xAxis->setLabels($labels);
$c->xAxis->setTitle("Fechas");
$labelsObj->setFontAngle(90);
$layer = $c->addBarLayer2(Side, 3);
$layer->addDataSet($data0, 0xff8080, "Arman");
$layer->addDataSet($data1, 0x80ff80, "Cambian");
$layer->addDataSet($data2, 0x8080ff, "Stock final dia");
header("Content-type: image/png");
print($c->makeChart2(PNG));
include("../principal/cerrar_ref_web.php"); 
?>
