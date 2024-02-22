<?  
 
  
  include("../phplot.php");
  
	$link = mysql_connect("10.56.11.6","adm_sef","phtrz23");
	mysql_select_db("sef", $link);

  
  
 /* $link = mysql_connect("200.1.6.47","adm_sef","phtrz23");
  mysql_select_db("sef",$link);*/
 

  if ((($radio1 == 1) or ($radio1 == 2)) and ($opc == 1))
    $consulta = "select Fecha, sum(Cantidad_mov) as Suma from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Cod_movimiento = 'S') and (Destino = $destino) group by Fecha";
 
  if ((($radio1 == 1) or ($radio1 == 2)) and ($opc == 2))
    $consulta = "select Fecha, sum(Cantidad_mov) as Suma from movimientos where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Cod_movimiento = 'E') group by Fecha";
  	
       
   if ($radio1 == 3)
    $consulta =  "select Fecha,avg(Cobre) as Suma from leyes_turno where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Cobre <> 0) group by Fecha"; 

  if ($radio1 == 4)
    $consulta =  "select Fecha,avg(Azufre) as Suma from leyes_turno where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Azufre <> 0) group by Fecha"; 

  if ($radio1 == 5)
    $consulta =  "select Fecha,avg(Fierro) as Suma from leyes_turno where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Fierro <> 0) group by Fecha"; 

  if ($radio1 == 6)
    $consulta =  "select Fecha,avg(Silice) as Suma from leyes_turno where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Silice <> 0) group by Fecha"; 

  if ($radio1 == 7)
    $consulta =  "select Fecha,avg(Magnetita) as Suma from leyes_turno where ((Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final')) and (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro) and (Magnetita <> 0) group by Fecha";     


  if ($radio1 == 2)
  {
    $consul = "select * from producto_por_equipo where (Cod_equipo = $cod_eq) and (Cod_producto = $cod_pro)";
    $rs_peso = mysql_query($consul);
    $row_peso = mysql_fetch_array($rs_peso);
  }

  $rs = mysql_query($consulta);
  $i = 0;
  while ($row = mysql_fetch_array($rs))
  {
    $array[$i][0] = $row["Fecha"]; 
    if ($radio1 == 2)
      $array[$i][1] = ($row["Suma"] * $row_peso["Peso_base"]) ;
    else $array[$i][1] = $row["Suma"];  
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
    $graph->SetLegend(array('Cantidad de Movimiento')); //Lets have a legend
    $graph->SetTitle("Movimientos diarios entre ".$fecha_inicio." y ".$fecha_final."");
  }  
 
  if ($radio1 == 2)
  {
    $graph->SetLegend(array('Peso Movimiento')); //Lets have a legend
    $graph->SetTitle("Pesos diarios de los Movimientos entre ".$fecha_inicio." y ".$fecha_final."");
  }  

  if ($radio1 == 3)
  {
    $graph->SetLegend(array('Cobre')); //Lets have a legend
    $graph->SetTitle("Cobre diario entre ".$fecha_inicio." y ".$fecha_final."");
  }  

  if ($radio1 == 4)
  {
    $graph->SetLegend(array('Azufre')); //Lets have a legend
    $graph->SetTitle("Azufre diario entre ".$fecha_inicio." y ".$fecha_final."");
  }  

  if ($radio1 == 5)
  {
    $graph->SetLegend(array('Fierro')); //Lets have a legend
    $graph->SetTitle("Fierro diario entre ".$fecha_inicio." y ".$fecha_final."");
  }  

  if ($radio1 == 6)
  {
    $graph->SetLegend(array('Silice')); //Lets have a legend
    $graph->SetTitle("Silice diario entre ".$fecha_inicio." y ".$fecha_final."");
  }  

  if ($radio1 == 7)
  {
    $graph->SetLegend(array('Magnetita')); //Lets have a legend
    $graph->SetTitle("Magnetita diario entre ".$fecha_inicio." y ".$fecha_final."");
  }  

  
//  $graph->SetXLabel("M3");
//  $graph->SetYLabel("Tiempo");

  $graph->DrawGraph(); 

?>
