<?      
  include("../phplot.php");
 	$link = mysql_connect("10.56.11.6","adm_sef","phtrz23");
	mysql_select_db("sef", $link);
 
  /*$link = mysql_connect("200.1.6.47","adm_sef","phtrz23");
  mysql_select_db("sef",$link);*/

  $consulta = "select Fecha,sum(Horas_desc) as Suma from tiempo_desconexion where (Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final') and (Cod_equipo = $cod_eq) group by Fecha";

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

  $graph->SetLegend(array('Caudal')); //Lets have a legend
  $graph->SetTitle("Hrs. Soplado diario entre ".$fecha_inicio." y ".$fecha_final."");

//  $graph->SetXLabel("M3");
//  $graph->SetYLabel("Tiempo");

  $graph->DrawGraph(); 

?>

