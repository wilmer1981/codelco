<?php
  	include("../principal/conectar_ref_web.php");
  	include("phpchartdir.php");
	
	         if ($opcion=='T')
		     {
			   if ($cmbcircuito==1)
			      {
				   $parametros='FECHA,sum(TEMP1) as valor1,sum(TEMP2) as valor2';
				  }
				else if ($cmbcircuito==2)
			            {
				         $parametros='FECHA,sum(TEMP3) as valor1,sum(TEMP4) as valor2';
				        } 
					 else if ($cmbcircuito==3)
			                 {
				              $parametros='FECHA,sum(TEMP5) as valor1,sum(TEMP6) as valor2';
				             }
				     	  else if ($cmbcircuito==4)
			                     {
				                  $parametros='FECHA,sum(TEMP7) as valor1,sum(TEMP8) as valor2';
				                 }
							   else if ($cmbcircuito==5)
			                     {
				                  $parametros='FECHA,sum(TEMP9) as valor1,sum(TEMP10) as valor2';
				                 }
							   		else if ($cmbcircuito==6)
			                     			{
				                  			 $parametros='FECHA,sum(TEMP11) as valor1,sum(TEMP12) as valor2';
				                 			}
										 else if ($cmbcircuito==7)
			                                     {
				                                  $parametros='FECHA,sum(TEMP17) as valor1,sum(TEMP18) as valor2';
				                                 }  	  	 	
							   	   	  	 	  else if ($cmbcircuito==8)
			                                          {
				                                       $parametros='FECHA,sum(TEMP15) as valor1,sum(TEMP16) as valor2';
				                                      }  	  	  	  	 	   	  	 
			    $consulta_aux="select ".$parametros." from ref_web.temperaturas where ";
			   $consulta_fecha="select distinct FECHA from ref_web.temperaturas where fecha between '".$FechaInicio."' and '".$FechaTermino."' order by FECHA";
			 }
		 else if ($opcion=='V')
		         {
				   if ($cmbcircuito==1)
			          {
				       $parametros='FECHA,sum(TEMP1) as valor1,sum(PRE1) as valor2';
				      }
				   else if ($cmbcircuito==2)
			               { 
				            $parametros='FECHA,sum(TEMP2) as valor1,sum(PRE2) as valor2';
				           } 
					    else if ($cmbcircuito==3)
			                    {
				                 $parametros='FECHA,sum(TEMP3) as valor1,sum(PRE3) as valor2';
				                }
				     	     else if ($cmbcircuito==4)
			                         {
				                      $parametros='FECHA,sum(TEMP4) as valor1,sum(PRE4) as valor2';
				                    }
				     	     else if ($cmbcircuito==5)
			                         {
				                      $parametros='FECHA,sum(TEMP5) as valor1,sum(PRE5) as valor2';
				                    }
			   $consulta_fecha="select distinct FECHA from ref_web.vapor where fecha between '".$FechaInicio."' and '".$FechaTermino."' order by FECHA";			   
			   $consulta_aux="select ".$parametros." from ref_web.vapor where ";
			  } 
			  $respuesta_fecha=mysqli_query($link, $consulta_fecha);
			  $i=0;
			  $i2=0;
			  while ($row_fecha = mysqli_fetch_array($respuesta_fecha))
			       {
				     $consulta=$consulta_aux." FECHA='".$row_fecha[FECHA]."' and TURNO='C' group by FECHA,turno order by FECHA,TURNO,INSTANTE ";
				     $respuesta=mysqli_query($link, $consulta);
					 $row = mysqli_fetch_array($respuesta);
					 $total1=$row[valor1]/3;
					 $total2=$row[valor2]/3;
					 $arreglo_1_ta[$i]=$total1;
					 $arreglo_2_ta[$i]=$total2;
					 $arreglo_fecha[$i]=$row_fecha[FECHA]." Turno C";
					 $i++;
					 /*****************************************************************************************/
					 $consulta=$consulta_aux." FECHA='".$row_fecha[FECHA]."' and TURNO='A' group by FECHA,turno order by FECHA,TURNO,INSTANTE ";
				     $respuesta=mysqli_query($link, $consulta);
					 $row = mysqli_fetch_array($respuesta);
				     $total3=$row[valor1]/3;
				     $total4=$row[valor2]/3;
					 $arreglo_1_ta[$i]=$total3;
					 $arreglo_2_ta[$i]=$total4;
					 $arreglo_fecha[$i]=$row_fecha[FECHA]." Turno A";
					 $i++;
					 /******************************************************************************************/
					 $consulta=$consulta_aux." FECHA='".$row_fecha[FECHA]."' and TURNO='B' group by FECHA,turno order by FECHA,TURNO,INSTANTE ";
				     $respuesta=mysqli_query($link, $consulta);
					 $row = mysqli_fetch_array($respuesta);
				     $total5=$row[valor1]/3;
				     $total6=$row[valor2]/3;
					 
					 $arreglo_1_ta[$i]=$total5;
					 $arreglo_2_ta[$i]=$total6;
					 $arreglo_fecha[$i]=$row_fecha[FECHA]." Turno B";
					 $i++;
					 $i2++;
				   }
	    	  
	#The data for the line chart
	$data0 = $arreglo_1_ta;
	$data1 = $arreglo_2_ta;
	//$data2 = $arreglo_1_tb;
	//$data3 = $arreglo_2_tb;
	//$data4 = $arreglo_1_tc;
	//$data5 = $arreglo_2_tc;
	
	$labels = $arreglo_fecha;
	
	#Create a XYChart object of size 300 x 180 pixels
	$c = new XYChart(920, 720);
	
	#Set background color to pale yellow 0xffffc0, with a black edge and a 1
	#pixel 3D border
	$c->setBackground(0xffffc0, 0x0, 1);
	
	#Set the plotarea at (45, 35) and of size 240 x 120 pixels, with white
	#background. Turn on both horizontal and vertical grid lines with light
	#grey color (0xc0c0c0)
	$c->setPlotArea(45, 35, 820, 500, 0xffffff, -1, -1, 0xc0c0c0, -1);
	
	#Add a legend box at (45, 12) (top of the chart) using horizontal layout
	#and 8 pts Arial font Set the background and border color to Transparent.
	$legendObj = $c->addLegend(45, 12, false, "", 8);
	$legendObj->setBackground(Transparent);
	
	#Add a title to the chart using 9 pts Arial Bold/white font. Use a 1 x 2
	#bitmap pattern as the background.
	if ($opcion=='T')
	    {
		$circuitos_temp=array('1','2','3','4','5','6','HM','Parcial' );
		$titleObj = $c->addTitle("Mediciones de Temperatura entre ".$FechaInicio." y ".$FechaTermino." para el circuito ".$circuitos_temp[$cmbcircuito-1]." en turnos C-A-B ", "arialbd.ttf",9, 0xffffff);
		$titleObj->setBackground($c->patternColor(array(0x4000, 0x8000), 2));
		}
	else {
	      $circuitos_vapor=array('Matriz Entrada','1 al 4','5','6');
		  $titleObj = $c->addTitle("Mediciones de Vapor entre ".$FechaInicio." y ".$FechaTermino." para el circuito ".$circuitos_vapor[$cmbcircuito-1]." en turnos C-A-B ", "arialbd.ttf",9, 0xffffff);
		  $titleObj->setBackground($c->patternColor(array(0x4000, 0x8000), 2));
	     }
	#Set the y axis label format to nn%
	if ($opcion=='T')
	   {
	    $c->yAxis->setTitle("Temperatura Entrada (°C)");
        $c->yAxis->setColors(0xc00000, 0xc00000, 0xc00000);
	    $c->yAxis->setLinearScale(55, 80, 1);
		$yAxis2Obj = $c->yAxis2();
        $yAxis2Obj->setTitle("Temperatura Salida (°C)");
		$yAxis2Obj = $c->yAxis2();
        $yAxis2Obj->setColors(0x8000, 0x8000, 0x8000);
		$c->yAxis2->setLinearScale(55, 80, 1);

		
	   }
	else {
	      $c->yAxis->setTitle("Temperatura (°C)");
		  $c->yAxis->setColors(0xc00000, 0xc00000, 0xc00000);
	      $c->yAxis->setLinearScale(0, 190, 10);
		  $yAxis2Obj = $c->yAxis2();
		  $yAxis2Obj->setTitle("Presion (Bar)");
		  $yAxis2Obj = $c->yAxis2();
		  $yAxis2Obj->setColors(0x8000, 0x8000, 0x8000);
		  if ($circuitos_vapor[$cmbcircuito-1]<>'Matriz Entrada')
		      { $c->yAxis2->setLinearScale(0, 3, 0.5);}
		  else {$c->yAxis2->setLinearScale(0, 8, 0.5);}	  
		  
		 }   	
	
	#Set the labels on the x axis
	//$c->xAxis->setLabels($labels);
	$labelsObj = $c->xAxis->setLabels($labels);
    $labelsObj->setFontAngle(90);

	
	#Add a line layer to the chart
	$layer = $c->addLineLayer();
	
	#Add the first line. Plot the points with a 7 pixel square symbol
	if ($opcion=='T')
	   {
		$dataSetObj = $layer->addDataSet($data0, 0xcf4040, "Temperatura Entrada (°C)");
		$dataSetObj->setDataSymbol(SquareSymbol, 7);
	  
	    $dataSetObj = $layer->addDataSet($data1, 0x40cf40, "Temperatura Salida (°C)");
		$dataSetObj->setDataSymbol(DiamondSymbol, 9);
		$dataSetObj->setUseYAxis2();
	   }
	 else {
	        $dataSetObj = $layer->addDataSet($data0, 0xcf4040, "Temperatura (°C)");
		    $dataSetObj->setDataSymbol(SquareSymbol, 7);
	   
	        $dataSetObj = $layer->addDataSet($data1, 0x40cf40, "Presion (Bar)");
		    $dataSetObj->setDataSymbol(DiamondSymbol, 9);
	        $dataSetObj->setUseYAxis2();
	 
	      }  	
	
	if ($i2 < 8)
	   {
	#Enable data label on the data points. Set the label format to nn%.
	    $layer->setDataLabelFormat("{value|1}");/* aqui se muestran o no los valores en cada punto del grafico*/
	    }
	#Reserve 10% margin at the top of the plot area during auto-scaling to
	#leave space for the data labels.
	
	$c->yAxis->setAutoScale(0.1);
	$c->yAxis2->setAutoScale(0.1);
	
	#output the chart in PNG format
	header("Content-type: image/png");
	print($c->makeChart2(PNG));
?>

