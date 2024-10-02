<?php
	include("../conectar_principal.php");
	$cmb_ano = isset($_REQUEST["cmb_ano"])?$_REQUEST["cmb_ano"]:"";
	$cmb_mes = isset($_REQUEST["cmb_mes"])?$_REQUEST["cmb_mes"]:"";
	$cmb_dia = isset($_REQUEST["cmb_dia"])?$_REQUEST["cmb_dia"]:"";
	$cmb_ano_fin = isset($_REQUEST["cmb_ano_fin"])?$_REQUEST["cmb_ano_fin"]:"";
	$cmb_mes_fin = isset($_REQUEST["cmb_mes_fin"])?$_REQUEST["cmb_mes_fin"]:"";
	$cmb_dia_fin = isset($_REQUEST["cmb_dia_fin"])?$_REQUEST["cmb_dia_fin"]:"";
	$HoraIni  = isset($_REQUEST["HoraIni"])?$_REQUEST["HoraIni"]:"";
	$MinIni   = isset($_REQUEST["MinIni"])?$_REQUEST["MinIni"]:"";
	$HoraFin  = isset($_REQUEST["HoraFin"])?$_REQUEST["HoraFin"]:"";
	$MinFin   = isset($_REQUEST["MinFin"])?$_REQUEST["MinFin"]:"";

	$USUARIO = isset($_REQUEST["USUARIO"])?$_REQUEST["USUARIO"]:"";
	$SISTEMA = isset($_REQUEST["SISTEMA"])?$_REQUEST["SISTEMA"]:"";
	$TIPO_CONSULTA = isset($_REQUEST["TIPO_CONSULTA"])?$_REQUEST["TIPO_CONSULTA"]:"";
	$TIPO_GRAF     = isset($_REQUEST["TIPO_GRAF"])?$_REQUEST["TIPO_GRAF"]:"";

	$Fecha1     = $cmb_ano."-".$cmb_mes."-".$cmb_dia;
	$Fecha1_Aux = $Fecha1;
	$Fecha2     = $cmb_ano_fin."-".$cmb_mes_fin."-".$cmb_dia_fin;
	$Hora1      = $HoraIni.":".$MinIni.":00";
	$Hora2      = $HoraFin.":".$MinFin.":59";
	$i = 0;
	while (date($Fecha1) <= date($Fecha2))
	{
		if (date($Fecha1) == date($Fecha1_Aux))
		{
			$Hora3 = $Hora1;
		}
		else
		{
			$Hora3 = "00:00:00";
		}
		if (date($Fecha1) == date($Fecha2))
		{
			$Hora4 = $Hora2;
		}
		else
		{
			$Hora4 = "23:59:59";
		}
		if ($USUARIO == "TODOS")
		{
			$Consulta = "SELECT DISTINCT(RUT) AS RUT FROM proyecto_modernizacion.CONTROL_ACCESO ";
		}
		else
		{
			$Consulta = "SELECT RUT, FECHA_HORA, PC, SISTEMA, IP FROM proyecto_modernizacion.CONTROL_ACCESO ";
		}
		if ($SISTEMA == "S")
		{
			if ($SISTEMA != "S")
			{
				$Consulta = "$Consulta  WHERE RUT = '".$USUARIO."' ";
				$Consulta = "$Consulta  AND FECHA_HORA BETWEEN '".$Fecha1." ".$Hora3."' AND '".$Fecha1." ".$Hora4."'";
			}
			else
			{
				$Consulta = "$Consulta  WHERE FECHA_HORA BETWEEN '".$Fecha1." ".$Hora3."' AND '".$Fecha1." ".$Hora4."'";
			}
		}
		else
		{
			if ($USUARIO != "S")
			{
				$Consulta = "$Consulta  WHERE RUT = '".$USUARIO."' ";
				$Consulta = "$Consulta  AND SISTEMA = '".$SISTEMA."' ";
				$Consulta = "$Consulta  AND FECHA_HORA BETWEEN '".$Fecha1." ".$Hora3."' AND '".$Fecha1." ".$Hora4."'";
			}
			else
			{
				$Consulta = "$Consulta  WHERE SISTEMA = '".$SISTEMA."' ";
				$Consulta = "$Consulta  AND FECHA_HORA BETWEEN '".$Fecha1." ".$Hora3."' AND '".$Fecha1." ".$Hora4."'";
			}
		}
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($USUARIO != "S")
		{
			$Row = mysqli_fetch_array($Respuesta);
			if ($SISTEMA != "S")
			{
				$ConsAccesos = "SELECT ".$TIPO_CONSULTA." AS TOTAL_DIA ";
				$ConsAccesos.= " FROM proyecto_modernizacion.CONTROL_ACCESO T1 ";
				$ConsAccesos.= " WHERE T1.RUT = '".$Row["RUT"]."' ";
				$ConsAccesos.= " AND T1.SISTEMA = '".$SISTEMA."' ";
				$ConsAccesos.= " AND T1.FECHA_HORA BETWEEN '".$Fecha1." ".$Hora3."' AND '".$Fecha1." ".$Hora4."'";
			}
			else
			{
				$ConsAccesos = "SELECT ".$TIPO_CONSULTA." AS TOTAL_DIA ";
				$ConsAccesos.= " FROM proyecto_modernizacion.CONTROL_ACCESO T1 ";
				$ConsAccesos.= " WHERE T1.RUT = '".$Row["RUT"]."' ";
				$ConsAccesos.= " AND T1.FECHA_HORA BETWEEN '".$Fecha1." ".$Hora3."' ";
				$ConsAccesos.= " AND '".$Fecha1." ".$Hora4."' ORDER BY T1.IP DESC";
			}	
			//echo $ConsAccesos."<br>";
			$RespAccesos = mysqli_query($link, $ConsAccesos);
			$RowAccesos = mysqli_fetch_array($RespAccesos);
			//DIA DE LA SEMANA
			$ConsDia = "SELECT WEEKDAY('".$Fecha1."') AS DIA";
			$RespDia = mysqli_query($link, $ConsDia);
			$RowDia = mysqli_fetch_array($RespDia);
			$Dias = array("Lu","Ma","Mi","Ju","Vi","Sa","Do");
			$Array[$i][0] = substr($Fecha1,5,2)."-".substr($Fecha1,8,2)." ".$Dias[$RowDia["DIA"]];
			$Array[$i][1] = $RowAccesos["TOTAL_DIA"];
			$Dia = substr($Fecha1,8,2);
			$Mes = substr($Fecha1,5,2);
			$Ano = substr($Fecha1,0,4);
			$Fecha1 = date ("Y-m-d", mktime (0,0,0,$Mes,$Dia + 1,$Ano));
			$i++;
		}
		else // TODOS LOS USUARIOS
		{
			//while ($Row = mysqli_fetch_array($Respuesta))
			//{
				if ($SISTEMA != "S")
				{
					$ConsAccesos = "SELECT ".$TIPO_CONSULTA." AS TOTAL_DIA ";
					$ConsAccesos.= " FROM proyecto_modernizacion.CONTROL_ACCESO ";
					$ConsAccesos.= " WHERE SISTEMA = '".$SISTEMA."' ";
					$ConsAccesos.= " AND FECHA_HORA BETWEEN '".$Fecha1." ".$Hora3."' AND '".$Fecha1." ".$Hora4."'";
				}
				else
				{
					$ConsAccesos = "SELECT ".$TIPO_CONSULTA." AS TOTAL_DIA ";
					$ConsAccesos.= " FROM proyecto_modernizacion.CONTROL_ACCESO ";
					$ConsAccesos.= " WHERE FECHA_HORA BETWEEN '".$Fecha1." ".$Hora3."' AND '".$Fecha1." ".$Hora4."' ";
				}	
				$RespAccesos = mysqli_query($link, $ConsAccesos);
				$RowAccesos = mysqli_fetch_array($RespAccesos);
				//DIA DE LA SEMANA
				$ConsDia = "SELECT WEEKDAY('".$Fecha1."') AS DIA";
				$RespDia = mysqli_query($link, $ConsDia);
				$RowDia = mysqli_fetch_array($RespDia);
				$Dias = array("Lu","Ma","Mi","Ju","Vi","Sa","Do");
				$Array[$i][0] = substr($Fecha1,5,2)."-".substr($Fecha1,8,2)." ".$Dias[$RowDia["DIA"]];
				$Array[$i][1] = $RowAccesos["TOTAL_DIA"];
				$Dia = substr($Fecha1,8,2);
				$Mes = substr($Fecha1,5,2);
				$Ano = substr($Fecha1,0,4);
				$Fecha1 = date ("Y-m-d", mktime (0,0,0,$Mes,$Dia + 1,$Ano));
				$i++;
			//}
		}
	}
//*************************************************
//Include the code
require_once 'phplot.php';
//*************************************************

/*require 'phplot.php';
$plot = new phplot();
$data = array(array('', 0, 0), array('', 1, 9));
$plot->SetDataValues($data);
$plot->SetDataType('data-data');
$plot->DrawGraph();
*/
//Define the object
//$graph = new PHPlot(750,420,"","");
//$graph = new PHPlot(700,400,"","../imagenes/fondo5.jpg");
//$graph->background_done = 1;  //The image background we get from 0cars.jpg

//$graph = new PHPlot(750,420,"","");
$graph = new Phplot\Phplot\phplot(750, 420,"","");
$graph->SetDataValues($Array);//ARREGLO QUE TIENE LOS DATOS
$graph->SetPlotType($TIPO_GRAF);//TIPO DE GRAFICO
$graph->SetTitleFontSize( "2");//TAMA�O DE LETRA
$graph->SetTextColor ("black");//COLOR DE TEXTO
$graph->SetBackgroundColor("white"); //FONDO DEL GRAFICO
$graph->SetGridColor ("black");// COSTADO DE LA GRILLA
$graph->SetLightGridColor ("#CCCCCC"); //LINEAS INTERIORES
$graph->SetDataColors(array("red"),array("black")); //COLOR DE LAS BARRAS (FONDO, BORDE)
$graph->SetLegend(array('Cantidad de Usuarios')); //Lets have a legend
//$graph->SetDrawDataLabels('1');
$graph->SetXDataLabelAngle(90);//POSICION DE LOS DATOS DE X
$graph->SetLabelScalePosition('1');
$graph->SetTitle("N° de Usuarios que Accesan entre ".$Fecha1_Aux." y ".$Fecha2."");
//Set Output format
//$graph->SetFileFormat("png");
//Draw it
$graph->DrawGraph();

/*
//Specify plotting area details 
include ( "../phplot.php");
$graph = new PHPlot;

$graph->SetDataType( "linear-linear");

// 
$graph->SetImageArea(455,180);
$graph->SetPlotType( "lines");
$graph->SetTitleFontSize( "2");
$graph->SetTitle( "Social Security trust fund asset estimates, in $ billions");
$graph->SetPlotAreaWorld(2000,0,2035,2000);
$graph->SetPlotBgColor( "white");
$graph->SetPlotBorderType( "left");
$graph->SetBackgroundColor( "white");

//Define the X axis 
$graph->SetXLabel( "Year");
$graph->SetHorizTickIncrement( "5");
$graph->SetXGridLabelType( "plain");

//Define the Y axis 
$graph->SetVertTickIncrement( "500");
$graph->SetPrecisionY( "0");
$graph->SetYGridLabelType( "right");
$graph->SetLightGridColor( "blue");

$graph->SetDataColors( array( "red"), array( "black") );

$graph->DrawGraph();*/
?>
