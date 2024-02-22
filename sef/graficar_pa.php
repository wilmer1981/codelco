<?      
  include("../phplot.php");
  	$link = mysql_connect("10.56.11.6","adm_sef","phtrz23");
	mysql_select_db("sef", $link);

 /* $link = mysql_connect("200.1.6.47","adm_sef","phtrz23");
  mysql_select_db("sef",$link);*/
 
  if ($radio1 == 1)
    $consulta = "select Fecha, sum(Caudal) as Suma from detalle_pta_acido where (Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final') group by Fecha";

  if ($radio1 == 2)
    $consulta = "select Fecha, sum(HorasOp) as Suma from detalle_pta_acido where (Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final') group by Fecha"; 
  
  if ($radio1 == 3)
    $consulta = "select Fecha, sum(Azufre) as Suma from detalle_pta_acido where (Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final') group by Fecha";
  
  if ($radio1 == 4)
    $consulta = "select Fecha, sum(Produccion) as Suma from detalle_pta_acido where (Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final') group by Fecha";

  $rs = mysql_query($consulta);
  $i = 0;
  while ($row = mysql_fetch_array($rs))
  {
    $array[$i][0] = $row["Fecha"]; 
    $array[$i][1] = $row["Suma"];
    $i++;
  }
  

  if ($i < 62)
    $graph = new PHPlot(750,420,"",""); 
  else $graph = new PHPlot(1000,500,"","");   

  $graph->SetDataValues($array);//ARREGLO QUE TIENE LOS DATOS
  $graph->SetPlotType("lines");//TIPO DE GRAFICO
  $graph->SetTitleFontSize( "2");//TAMAÑO DE LETRA
  $graph->SetTextColor ("black");//COLOR DE TEXTO
  $graph->SetBackgroundColor("white"); //FONDO DEL GRAFICO
  $graph->SetGridColor ("black");// COSTADO DE LA GRILLA
  $graph->SetLightGridColor ("#CCCCCC"); //LINEAS INTERIORES
  $graph->SetDataColors(array("red"),array("black")); //COLOR DE LAS BARRAS (FONDO, BORDE)
  $graph->SetDrawDataLabels('1');
  $graph->SetXDataLabelAngle(90);//POSICION DE LOS DATOS DE X
  $graph->SetLabelScalePosition('1');

  if ($radio1 == 1)
  {
    $graph->SetLegend(array('Caudal')); //Lets have a legend
    $graph->SetTitle("Caudal diario entre ".$fecha_inicio." y ".$fecha_final."");
  }  
 
  if ($radio1 == 2)
  {
    $graph->SetLegend(array('Horas Op.')); //Lets have a legend
    $graph->SetTitle("Horas Operadas diarias entre ".$fecha_inicio." y ".$fecha_final."");
  }  

  if ($radio1 == 3)
  {
    $graph->SetLegend(array('Azufre')); //Lets have a legend
    $graph->SetTitle("Azufre diario entre ".$fecha_inicio." y ".$fecha_final."");
  }  

  if ($radio1 == 4)
  {
    $graph->SetLegend(array('Produccion')); //Lets have a legend
    $graph->SetTitle("Produción diaria entre ".$fecha_inicio." y ".$fecha_final."");
  }  
//  $graph->SetXLabel("M3");
//  $graph->SetYLabel("Tiempo");

  $graph->DrawGraph(); 

?>
