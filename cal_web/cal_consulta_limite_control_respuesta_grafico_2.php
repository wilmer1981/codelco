<?php 	include("../principal/conectar_principal.php");
	include("../principal/graficos/phpchartdir.php");
	
 	$Seleccion1= "select distinct t3.cod_leyes,t4.abreviatura";
	$Seleccion2= "select distinct t1.nro_solicitud,t1.recargo ";
	$Seleccion3= "select count(distinct t1.nro_solicitud,t1.recargo) as total_registros ";
	$Eliminar="Delete from cal_web.tmp_limite_control where usuario='".$CookieRut."'";
	mysqli_query($link, $Eliminar);
	$ConsultaAux = "select t1.cod_producto, t2.cod_subproducto, t1.descripcion as nom_prod, t2.descripcion as nom_subprod from proyecto_modernizacion.productos t1 inner join proyecto_modernizacion.subproducto t2 ";
	$ConsultaAux.= " on t1.cod_producto=t2.cod_producto ";
	$ConsultaAux.= " where t1.cod_producto='".$CmbProductos."' and t2.cod_subproducto='".$CmbSubProducto."'";
	$Resp=mysqli_query($link, $ConsultaAux);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$Producto=$Fila["nom_prod"];
		$SubProducto=$Fila["nom_subprod"];
	}
	
	$Consulta1="select cod_unidad,cod_leyes,abreviatura from proyecto_modernizacion.leyes where cod_leyes='".$CmbLey."' "; 
	$Respuesta1 = mysqli_query($link, $Consulta1);
	if ($Fila=mysqli_fetch_array($Respuesta1))
	{
		$LeyDES=$Fila["abreviatura"];
	}
	$Consulta1="select cod_unidad,abreviatura from proyecto_modernizacion.unidades where cod_unidad='".$CmbUnidad."' "; 
	$Respuesta1 = mysqli_query($link, $Consulta1);
	if ($Fila=mysqli_fetch_array($Respuesta1))
	{
		$UnidadDES=$Fila["abreviatura"];
	}
	if($CmbProveedores=='T' || $CmbProveedores!='' )
	{
		if($CmbProveedores=='T')
		{
			$Proveedor="Todos";
		}
		else
		{
			$ConsultaProv="select rut_prv,nombre_prv from sipa_web.proveedores where rut_prv='".$CmbProveedores."' order by nombre_prv"; 
			$Respuesta = mysqli_query($link, $ConsultaProv);
			if($Fila=mysqli_fetch_array($Respuesta))
			{
				$Proveedor=str_pad($Fila[rut_prv], 10, "0", STR_PAD_LEFT)." - ".ucwords(strtolower($Fila["nombre_prv"]));
			}
		}
	}		
	else
	{
		$CmbProveedores='';
	}				
	//--------------------------------------
	//CONSULTA CENTRO COSTO
	$ConsultaAux = "select descripcion from proyecto_modernizacion.centro_costo ";
	$ConsultaAux.= " where centro_costo='".$CmbCCosto."' ";
	$Resp=mysqli_query($link, $ConsultaAux);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$CCosto=$Fila["descripcion"];
	}
	//--------------------------------------
	//CONSULTA AREA
	$ConsultaAux = "select nombre_subclase from proyecto_modernizacion.sub_clase ";
	$ConsultaAux.= " where cod_clase = 3 and cod_subclase='".$CmbAreasProceso."' order by cod_subclase";
	$Resp=mysqli_query($link, $ConsultaAux);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$Areas=$Fila["nombre_subclase"];
	}
	//--------------------------------------
	$Consulta1 ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
	$Respuesta1 = mysqli_query($link, $Consulta1);
	$Fila1=mysqli_fetch_array($Respuesta1);
	$Nivel=$Fila1["nivel"];
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin =50;
	
	$LimitFin=$LimitFinAux;
	///echo $LimitIni."   ".$LimitFin."<br>";	
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 22;
	if ($CmbTipo=='-1')
	{
		$Tipo='';
	}
	else
	{
		$Tipo=" and t1.tipo='".$CmbTipo."'";
	}
	if ($CmbTipoAnalisis=='-1')
	{
		$TipoAnalisis='';
	}
	else
	{
		$TipoAnalisis=" and t1.cod_analisis='".$CmbTipoAnalisis."'";
	}
	$Consulta = $Consulta." from cal_web.solicitud_analisis t1 ";
	$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
	$Consulta = $Consulta." t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo ";
//	 inner join 	proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes";
	$Consulta = $Consulta." where (t1.estado_actual ='6') and t1.recargo<>'R'";
	if($CmbPeriodo!='T')
		$Consulta =$Consulta." and (t1.cod_periodo='".$CmbPeriodo."')";
	$Consulta =$Consulta.$Tipo.$TipoAnalisis;
	if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5')||($Nivel=='8')||($CmbCCosto=='6150'))
	{
		$Consulta = $Consulta."  ";
	}
	else
	{
		$Consulta = $Consulta." and t1.cod_producto <> 1 ";
	
	}
	if ($CmbSubProducto==-2)
	{
		if ($Producto!="")
		{
			$Consulta=$Consulta." and t1.cod_producto ='".$CmbProductos."'";
		}
	}
	else
	{
		if ($Producto!="")
		{
			$Consulta=$Consulta." and t1.cod_producto ='".$CmbProductos."'";
		}
		if ($SubProducto!="")
		{
			$Consulta=$Consulta." and t1.cod_subproducto ='".$CmbSubProducto."'";
		}
	}
	if($Proveedor!='')
	{
		if($CmbProveedores!='T')
			$Consulta = $Consulta." and  t1.rut_proveedor='".$CmbProveedores."' ";
	}
	$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
	$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
	$Consulta = $Consulta." and (t1.fecha_muestra between '".$FechaI."' and '".$FechaT."')";
	$Consulta = $Consulta." and t3.cod_leyes='".$CmbLey."'  and t3.cod_unidad='".$CmbUnidad."'";
	/*if($ChkLimite=="S")
	{
	
		$Marca="N";
		$Eliminar="Delete from cal_web.tmp_limite_control where usuario='".$CookieRut."'";
		mysqli_query($link, $Eliminar);
	
		$Criterio=$Seleccion2.$Consulta." order by t1.fecha_muestra,t1.nro_solicitud ";
		$Respuesta2=mysqli_query($link, $Criterio);
		while ($Fila=mysqli_fetch_array($Respuesta2))
		{		
							
				$Consulta6 ="select t1.cod_unidad,t1.cod_leyes,t1.valor,t1.signo,t2.abreviatura from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.nro_solicitud = ".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."' and t1.cod_leyes='".$CmbLey."'  and t1.cod_unidad='".$CmbUnidad."'";
					$Consulta6.=" and t1.cod_producto='".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."'  ";
				$Respuesta3=mysqli_query($link, $Consulta6);
				if($Fila3=mysqli_fetch_array($Respuesta3))
				{		
					$Tiene="N";
					$Valor=$Fila3["valor"];
					ValorLimiteControl($CmbProductos,$CmbSubProducto,$Fila3["cod_leyes"],$Fila3["cod_unidad"],$Fila["rut_proveedor"],&$Valor,&$Tiene);
					if($Tiene=='S')
					{
						$Insertar="insert into cal_web.tmp_limite_control(nro_solicitud,recargo,usuario) values(";
						$Insertar.="'".$Fila["nro_solicitud"]."','".$Fila["recargo"]."','".$CookieRut."')";
						mysqli_query($link, $Insertar);
						$Marca="S";
					}
				}
						
		
		}
				
		$Consulta= " from cal_web.solicitud_analisis t1 ";
		$Consulta.=" inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and ";
		$Consulta.=" t1.fecha_hora = t3.fecha_hora and t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo ";
		$Consulta.=" inner join proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes inner join  cal_web.tmp_limite_control t5 ";
		$Consulta.=" on t3.nro_solicitud=t5.nro_solicitud and t3.recargo=t5.recargo where t5.usuario='".$CookieRut."' and t1.recargo<>'R' ";
		$Consulta.=" and t3.cod_leyes='".$CmbLey."'  and t3.cod_unidad='".$CmbUnidad."'";

	}
*/
	$ConcRIT2=$Seleccion3.$Consulta;
	$Criterio2=$ConcRIT2;
		$ConsultaVAR="Select * from cal_web.limite where cod_producto='".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."'";
		$ConsultaVAR.=" and cod_ley='".$CmbLey."' and unidad='".$CmbUnidad."' and rut_proveedor='".$CmbProveedores."'";
		$RespVar= mysqli_query($link, $ConsultaVAR);
		if($FilaVar=mysqli_fetch_array($RespVar))
		{
			$LimitIniVALOR=$FilaVar[limite_inicial];
			$LimitFinVALOR=$FilaVar[limite_final];
			//	$LimitIniVALOR=number_format($FilaVar[limite_inicial],3,'.','');
			//	$LimitFinVALOR=number_format($FilaVar[limite_final],3,'.','');
		}
		else
		{
			$ConsultaVAR="Select * from cal_web.limite where cod_producto='".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."'";
			$ConsultaVAR.=" and cod_ley='".$CmbLey."' and unidad='".$CmbUnidad."'";
			$RespVar= mysqli_query($link, $ConsultaVAR);
			if($FilaVar=mysqli_fetch_array($RespVar))
			{
			$LimitIniVALOR=$FilaVar[limite_inicial];
			$LimitFinVALOR=$FilaVar[limite_final];
			
			//$LimitIniVALOR=number_format($FilaVar[limite_inicial],3,'.','');
			//$LimitFinVALOR=number_format($FilaVar[limite_final],3,'.','');
			}
		
		}
		
	$Criterio=$Seleccion2.$Consulta." order by t1.fecha_muestra,t1.nro_solicitud LIMIT ".$LimitIni.", ".$LimitFin;
	$Respuesta2=mysqli_query($link, $Criterio);$Cont=0;
	while ($Fila=mysqli_fetch_array($Respuesta2))
	{
		if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==""))
		{
			$Recargo='';
		}
		else
		{
			$Recargo="-".$Fila["recargo"];
		}
		$ArregloSolicitud[$Cont]=$Fila["nro_solicitud"].$Recargo;
		$Consulta ="select t3.abreviatura as ley,t1.cod_unidad,t1.cod_leyes,t1.valor,t1.signo,t2.abreviatura from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad inner join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes where t1.nro_solicitud = ".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."'";
		$Consulta.=" and t1.cod_leyes='".$CmbLey."'  and t1.cod_unidad='".$CmbUnidad."'";
		$Respuesta3=mysqli_query($link, $Consulta);
		if($Fila3=mysqli_fetch_array($Respuesta3))
		{
			$Valor=ValorColor($Fila["nro_solicitud"],$CmbProductos,$CmbSubProducto,$Fila3["cod_leyes"],$Fila3["cod_unidad"],$Fila["rut_proveedor"],$Fila3["valor"],$Fila["recargo"]);
			$M=explode('~',$Valor);
			$ArregloSolicitudValor[$Cont]=$M[0];
			$ArregloInicial[$Cont]=$LimitIniVALOR;
			$ArreglFinal[$Cont]=$LimitFinVALOR;
		}
		$Cont=$Cont+1;
	}

		

#The data for the line chart

#Create a XYChart object of size 300 x 180 pixels
$c = new XYChart(1200, 650);
#Set background color to pale yellow 0xffffc0, with a black edge and a 1
#pixel 3D border

$c->setBackground(0xffffc0, 0x0, 1);
#Set the plotarea at (45, 35) and of size 240 x 120 pixels, with white
#background. Turn on both horizontal and vertical grid lines with light
#grey color (0xc0c0c0)
$c->setPlotArea(80, 60, 1100, 400, 0xffffff, -1, -1, 0xCCCCCC, -1);

#Add a legend box at (45, 12) (top of the chart) using horizontal layout
#and 8 pts Arial font Set the background and border color to Transparent.
$legendObj = $c->addLegend(45, 20, false, "",12);
$legendObj->setBackground(Transparent);
#Add a title to the chart using 9 pts Arial Bold/white font. Use a 1 x 2
#bitmap pattern as the background.$Producto=$Fila["nom_prod"];
//echo "VI ".$LimitIniVALOR."   VF ".$LimitFinVALOR."<br>";
$titleObj = $c->addTitle(   "VI ".$LimitIniVALOR."   VF ".$LimitFinVALOR."      GRAFICO LIMITE CONTROL ".$Producto." - ".$SubProducto." - Ley ".$LeyDES, "arialbd.ttf",9, 0xffffff);
$titleObj->setBackground($c->patternColor(array(0x4000, 0x8000), 2));
#Set the y axis label format to nn%
//$c->yAxis->setLabelFormat("{value}".$UnidadDES);

$c->yAxis->setLabelFormat("{value}".$UnidadDES);//("{value}".$UnidadDES);{={value}/100}

#Set the labels on the x axis

$labelsObj = $c->xAxis->setLabels($ArregloSolicitud);
#Add a line layer to the chart
$layer = $c->addLineLayer();
$labelsObj->setFontAngle(90);
if($ChkLimite=="S")
{
	$c->yAxis->addZone($LimitIniVALOR, $LimitFinVALOR, 0xCCFFCC);
	
	#Add a purple (0x800080) mark at y = 70 using a line width of 2.
	$markObj = $c->yAxis->addMark($LimitFinVALOR, 0xFF0000, "Fin.= ".$LimitFinVALOR.$UnidadDES);
	$markObj->setLineWidth(2);
	
	#Add a green (0x008000) mark at y = 40 using a line width of 2.
	$markObj = $c->yAxis->addMark($LimitIniVALOR, 0xFF9900, "Ini. = ".$LimitIniVALOR.$UnidadDES);
	$markObj->setLineWidth(2);
}
#Add the first line. Plot the points with a 7 pixel square symbol
$dataSetObj = $layer->addDataSet($ArregloSolicitudValor, 0x0000FF, "Valores");
//$dataSetObjf = $layer->addDataSet($ArregloInicial, 0xFFFF00, "Inicial ");
//$dataSetObji = $layer->addDataSet($ArreglFinal, 0xFF0000,"Final");

$dataSetObj->setDataSymbol(SquareSymbol, 4);
//$dataSetObjf->setDataSymbol(SquareSymbol, 1);
//$dataSetObji->setDataSymbol(SquareSymbol,1);
#Add the second line. Plot the points with a 9 pixel dismond symbol
#Enable data label on the data points. Set the label format to nn%.
//$layer->setDataLabelFormat("{value|2}");
#Reserve 10% margin at the top of the plot area during auto-scaling to
#leave space for the data labels.
$c->yAxis->setAutoScale(1);
#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));
	

function ValorLimiteControl($Producto,$SubProducto,$CodLey,$Unidad,$RutProveedor,$Valor,$Tiene)
{

	
	$Consulta="Select * from cal_web.limite where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
	$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' and rut_proveedor='".$RutProveedor."'";
	$RespColor = mysqli_query($link, $Consulta);
	if($FilaColor=mysqli_fetch_array($RespColor))
	{
		if(($Valor>=$FilaColor[limite_inicial]) && ( $Valor<=$FilaColor[limite_final] ))
		{
				$Valor=$Valor;
			$Existe='N';
		}
		else
		{
			$Existe='S';
				$Valor=$Valor;
			
		}
		
	}
	else
	{
		$Consulta="Select * from cal_web.limite where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
		$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' and rut_proveedor='T'";
		$RespColor = mysqli_query($link, $Consulta);
		if($FilaColor=mysqli_fetch_array($RespColor))
		{
		
		//    0 <= 70   && 60 >= 70
			if(($Valor>=$FilaColor[limite_inicial]) && ( $Valor<=$FilaColor[limite_final] ))
			{
				$Existe='N';
			}
			else
			{
				$Existe='S';
			}
		}
		else
		{
			$Existe='N';
		}
	}
	if($Tiene=='N' && $Existe=='S')
		$Tiene='S';
			//$Valor=number_format($Valor,3,",",".");
	return($Tiene);
}

function ValorColor($SA,$Producto,$SubProducto,$CodLey,$Unidad,$RutProveedor,$Valor,$Recargo)
{
	$Obs='';
	$Consulta="Select * from cal_web.limite where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
	$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' and rut_proveedor='".$RutProveedor."'";
	$RespColor = mysqli_query($link, $Consulta);
	if($FilaColor=mysqli_fetch_array($RespColor))
	{
	//	echo $FilaColor[limite_inicial]." ".$Valor." ".$FilaColor[limite_final];
		if(($Valor>=$FilaColor[limite_inicial]) && ( $Valor<=$FilaColor[limite_final] ))
		{
				$ValorR=$Valor;
		}
		else
		{
				$ValorR=$Valor;
		}
	}
	else
	{
		$Consulta="Select * from cal_web.limite where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
		$Consulta.=" and cod_ley='".$CodLey."' and unidad='".$Unidad."' and rut_proveedor='T'";
		$RespColor = mysqli_query($link, $Consulta);
		if($FilaColor=mysqli_fetch_array($RespColor))
		{
			if(($Valor>=$FilaColor[limite_inicial]) && ( $Valor<=$FilaColor[limite_final] ))
			{
					$ValorR=$Valor;
			}
			else
			{
					$ValorR=$Valor;
			}
		}
		else
		{
			$ValorR=$Valor;
		}
	}
//	$ValorR=number_format($Valor,3,",",".");
	$Retorno=$ValorR."~".$Obs;
	return($Retorno);
}




?>