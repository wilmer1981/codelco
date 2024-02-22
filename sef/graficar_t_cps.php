<?      
  include("../phplot.php");
  	$link = mysql_connect("10.56.11.6","adm_sef","phtrz23");
	mysql_select_db("sef", $link);

  /*$link = mysql_connect("200.1.6.47","adm_sef","phtrz23");
  mysql_select_db("sef",$link);*/


  if ($num_cps == 0)
    $consulta = "select * from detalle_cps where (Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final') and (Cod_equipo in (7,8,9))";    
  else $consulta = "select * from detalle_cps where (Fecha >= '$fecha_inicio') and (Fecha <= '$fecha_final') and (Cod_equipo = $cod_eq)"; 

  $rs = mysql_query($consulta);
  $i = 0;
  $resto = 0;
  $cont = 0;
  $fecha_aux = '0000-00-00';
  while ($row = mysql_fetch_array($rs))
  {
      if ($row["Fecha"] != $fecha_aux)
      {
        $fecha_aux = $row["Fecha"];

        if ($num_cps == 0)
          $consul_cant = "select count(*) as cantidad from detalle_cps where (Fecha = '$fecha_aux') and (Cod_equipo in (7,8,9))";    
        else $consul_cant = "select count(*) as cantidad from detalle_cps where (Fecha = '$fecha_aux') and (Cod_equipo = $cod_eq)";

        $rs_cant = mysql_query($consul_cant);
	$row_cant = mysql_fetch_array($rs_cant);

      }  	
      
      if ($row["Fecha"] == $fecha_aux)
      {
        $cont = $cont + 1;
        $h1 = substr($row["Inicio_soplado"],0,2);
        $m1 = substr($row["Inicio_soplado"],3,2);
        $h2 = substr($row["Fin_soplado"],0,2);
        $m2 = substr($row["Fin_soplado"],3,2);

	if ((($h2 == 0) or ($h2 == 1) or ($h2 == 2)) and (($h1 == 23) or ($h1 == 22) or ($h1 == 21)))
	  $h2 = 24;

        $hora1 = $h1 + ($m1 / 60);
        $hora2 = $h2 + ($m2 / 60);

        if ($hora2 > $hora1)
          $resto = $resto + ($hora2 - $hora1);
        else $resto = $resto + ($hora1 - $hora2);   
      }
      
      if ($row_cant["cantidad"] == $cont)
      {
        $array[$i][0] = $row["Fecha"]; 
        $array[$i][1] = $resto;
        $i++;
	$cont = 0;
	$resto = 0;
      }
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


