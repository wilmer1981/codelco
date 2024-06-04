<?php 	

	set_time_limit(5000);
	include("../principal/conectar_principal.php");
	include("../principal/graficos/phpchartdir.php");
	$ArregloMeses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Cont=0;
	$USPEC=0;

	$CmbMes = $_REQUEST["CmbMes"];
	$CmbAno = $_REQUEST["CmbAno"];
	$CmbMesT = $_REQUEST["CmbMesT"];
	$CmbAnoT = $_REQUEST["CmbAnoT"];
	$CmbProductos = $_REQUEST["CmbProductos"];
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	$CmbLeyes = $_REQUEST["CmbLeyes"];
	$CmbUnidad = $_REQUEST["CmbUnidad"];
	$CmbTipo = $_REQUEST["CmbTipo"];
	$CmbTipoAnalisis = $_REQUEST["CmbTipoAnalisis"];
	$Tipo = $_REQUEST["Tipo"];

	$FechaI=$CmbAno."-".$CmbMes."-1 ";
	$FechaT=$CmbAnoT."-".$CmbMesT."-31 ";
	$fecha1 = mktime(0,0,0,$CmbMes,1,$CmbAno); 
	$fecha2 = mktime(0,0,0,$CmbMesT,31,$CmbAnoT);  
	$dif =  mktime(0,0,0,$CmbMesT,31,$CmbAnoT,1)-mktime(0,0,0,$CmbMes,1,$CmbAno,1); 
	$Mes=floor($dif/(24*60*60*30));	
	if($Mes>0 && $Mes<=6)
	{
	
	$MESC=$CmbMes;
	$ANOC=$CmbAno;
	$ArregloLabel=array();
	$ArregloCPK=array();
	$ArregloCV=array();
	$Consulta="select  t1.valor AS USPEC from cal_web.gestion_indicadores t1 where t1.cod_producto='".$CmbProductos."' ";
	$Consulta.=" and t1.cod_subproducto='".$CmbSubProducto."' and t1.cod_leyes='".$CmbLeyes."' and cod_unidad='".$CmbUnidad."' ";
	$Respuesta=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Respuesta))
	{	
		$USPEC=$Fila["USPEC"];
	}
	
		$Consulta="select t1.cod_unidad,t1.nombre_unidad,t1.abreviatura from proyecto_modernizacion.unidades t1 "; 
		$Consulta.=" where t1.cod_unidad='".$CmbUnidad."'  ";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$Unidad=ucwords(strtolower($Fila["abreviatura"]));				
		}
	$Consulta="select t1.descripcion from proyecto_modernizacion.subproducto t1 "; 
		$Consulta.=" where t1.cod_subproducto='".$CmbSubProducto."' and  t1.cod_producto='".$CmbProductos."' ";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$SubProducto=ucwords(strtolower($Fila["descripcion"]));				
		}
		$Consulta="select t1.nombre_leyes,t1.abreviatura from proyecto_modernizacion.leyes t1 "; 
		$Consulta.=" where t1.cod_leyes='".$CmbLeyes."'  ";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$Ley=ucwords(strtolower($Fila["abreviatura"]));				
		}
	$Titulo= " Gestión Indicadores ".$SubProducto. " - Ley ".$Ley;
	for($i=0;$i<$Mes;$i++)
	{
		                                  
		if($MESC>12)
		{
			$MESC=1;
			$ANOC=$CmbAno+1;
		}
		$FECHAINICONSULTA=$ANOC."-".$MESC."-1";
		$FECHAFINCONSULTA=$ANOC."-".$MESC."-31";
		$PROMEDIO=0;$DESV=0;
		$Consulta="select STDDEV(t3.valor) AS DESV from cal_web.solicitud_analisis t1 ";
		$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
		$Consulta = $Consulta." t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo ";
		$Consulta = $Consulta." where (t1.estado_actual ='6') and (t1.fecha_muestra between '".$FECHAINICONSULTA."' and '".$FECHAFINCONSULTA."') ";
		if($CmbTipoAnalisis!='-1')
			$Consulta =$Consulta." and t1.cod_analisis='".$CmbTipoAnalisis."' ";
		if($CmbTipo!='-1')
			$Consulta =$Consulta." and t1.tipo='".$CmbTipo."' ";
		if($CmbProductos!='-1')
			$Consulta =$Consulta." and t3.cod_producto='".$CmbProductos."' ";
		if($CmbSubProducto!='-1')
			$Consulta =$Consulta." and t3.cod_subproducto='".$CmbSubProducto."' ";
		if($CmbLeyes!='-1')
			$Consulta =$Consulta." and t3.cod_leyes='".$CmbLeyes."' ";
		if($CmbUnidad!='-1')
			$Consulta =$Consulta." and t3.cod_unidad='".$CmbUnidad."' ";
	//	echo $Consulta."<br><br>";
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{	
			$DESV=number_format($Fila["DESV"],3);
		}
		//	echo "DESV ".$DESV."<br>";

		$Consulta="select sum(t3.valor)/ Count(t3.valor)  as PROMEDIO from cal_web.solicitud_analisis t1 ";
		$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
		$Consulta = $Consulta." t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo ";
		$Consulta = $Consulta." where (t1.estado_actual ='6') and (t1.fecha_muestra between '".$FECHAINICONSULTA."' and '".$FECHAFINCONSULTA."') ";
		if($CmbTipoAnalisis!='-1')
			$Consulta =$Consulta." and t1.cod_analisis='".$CmbTipoAnalisis."' ";
		if($CmbTipo!='-1')
			$Consulta =$Consulta." and t1.tipo='".$CmbTipo."' ";
		if($CmbProductos!='-1')
			$Consulta =$Consulta." and t3.cod_producto='".$CmbProductos."' ";
		if($CmbSubProducto!='-1')
			$Consulta =$Consulta." and t3.cod_subproducto='".$CmbSubProducto."' ";
		if($CmbLeyes!='-1')
			$Consulta =$Consulta." and t3.cod_leyes='".$CmbLeyes."' ";
		if($CmbUnidad!='-1')
			$Consulta =$Consulta." and t3.cod_unidad='".$CmbUnidad."' ";
	//echo $Consulta."<br>"; 
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{	
			$PROMEDIO=number_format($Fila["PROMEDIO"],3);
		}
		//	echo "PROMEDIO ".$PROMEDIO."<br>";
		
		$CV=0;$CPK=0;
	//	echo "CPK =(".$USPEC."-".$PROMEDIO.")*3*".$DESV;
	//	echo "CV =(".$DESV."/".$PROMEDIO.")*100";
		$CPK=number_format((($USPEC-$PROMEDIO)/(3*$DESV)),3);
		if($PROMEDIO>0)
			$CV=number_format((($DESV/$PROMEDIO)*100),3);
//echo " CPK ".$CPK." CV ".$CV;
//echo $ArregloMeses[$MESC-1]." ".$ANOC."     CPK=".$CPK."     CV=".$CV."<br>";
		$ArregloLabel[$Cont]= $ArregloMeses[$MESC-1]." ".$ANOC;
		$ArregloCPK[$Cont]=$CPK;
		$ArregloCV[$Cont]=$CV;
		$MESC=$MESC+1;      
		$Cont=$Cont+1;
	}

#The data for the bar chart
if($Tipo=='CPK')
{
	#Create a XYChart object of size 300 x 240 pixels
	$B = new XYChart(1200, 1000);
	
	#Add a title to the chart using 10 pt Arial font
	$B->addTitle($Titulo, "", 10);
	
	#Set the plot area at (45, 25) and of size 240 x 180. Use two alternative
	#background colors (0xffffc0 and 0xffffe0)
	$plotAreaObj = $B->setPlotArea(60, 60, 1100, 800);
	$plotAreaObj->setBackground(0xffffc0, 0xffffe0);
	
	#Add a legend box at (50, 20) using horizontal layout. Use 8 pt Arial font,
	#with transparent background
	$legendObj = $B->addLegend(50, 20, false, "", 8);
	$legendObj->setBackground(Transparent);
	
	#Add a title to the y-axis
	#$c->yAxis->setTitle($Unidad);
	
	#Revenue 20 pixels at the top of the y-axis for the legend box
	$B->yAxis->setTopMargin(20);
	
	#Set the x axis labels
	$B->xAxis->setLabels($ArregloLabel);
	
	
	#Add a multi-bar layer with 3 data sets
	$layer = $B->addBarLayer2(Side, 3);
	$layer->addDataSet($ArregloCPK, 0xff8080, "CPK");
	//$layer->addDataSet($ArregloCV, 0x80ff80, "CV");
	$layer->setDataLabelStyle();
	$B->yAxis->setLabelFormat("{value}".$Unidad);
	#output the chart in PNG format
	header("Content-type: image/png");
	print($B->makeChart2(PNG));

}
if($Tipo=='CV')
{
	#Create a XYChart object of size 300 x 240 pixels
	$c = new XYChart(1200, 1000);
	
	#Add a title to the chart using 10 pt Arial font
	$c->addTitle($Titulo, "", 10);
	
	#Set the plot area at (45, 25) and of size 240 x 180. Use two alternative
	#background colors (0xffffc0 and 0xffffe0)
	$plotAreaObj = $c->setPlotArea(60, 60, 1100, 800);
	$plotAreaObj->setBackground(0xffffc0, 0xffffe0);
	
	#Add a legend box at (50, 20) using horizontal layout. Use 8 pt Arial font,
	#with transparent background
	$legendObj = $c->addLegend(50, 20, false, "", 8);
	$legendObj->setBackground(Transparent);
	
	#Add a title to the y-axis
	#$c->yAxis->setTitle($Unidad);
	
	#Revenue 20 pixels at the top of the y-axis for the legend box
	$c->yAxis->setTopMargin(20);
	
	#Set the x axis labels
	$c->xAxis->setLabels($ArregloLabel);
	
	
	#Add a multi-bar layer with 3 data sets
	$layer = $c->addBarLayer2(Side, 3);
	//$layer->addDataSet($ArregloCPK, 0xff8080, "CPK");
	$layer->addDataSet($ArregloCV, 0x80ff80, "CV");
	$layer->setDataLabelStyle();
	$c->yAxis->setLabelFormat("{value}".$Unidad);
	#output the chart in PNG format
	header("Content-type: image/png");
print($c->makeChart2(PNG));

}	

	
	}
	else
	{
		header('location:cal_consulta_gestion_indicadores.php?Msj=S&CmbProductos='.$CmbProductos.'&CmbSubProducto='.$CmbSubProducto.'&CmbLeyes='.$CmbLeyes.'&CmbUnidad='.$CmbUnidad.'&CmbTipo='.$CmbTipo.'&CmbTipoAnalisis='.$CmbTipoAnalisis.'&CmbAno='.$CmbAno.'&CmbMes='.$CmbMes.'&CmbAnoT='.$CmbAnoT.'&CmbMesT='.$CmbMesT);				
	}
	




?>