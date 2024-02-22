<?php
include("../principal/conectar_cal_web.php");

$Proceso = $_REQUEST["Proceso"];
$cmbgrupo     = $_REQUEST["cmbgrupo"];
$cmbturno     = $_REQUEST["cmbturno"];
$cmbcuba     = $_REQUEST["cmbcuba"];
$cmblado     = $_REQUEST["cmblado"];
$encargado = $_REQUEST["encargado"];
$observacion = $_REQUEST["observacion"];
$inspector = $_REQUEST["inspector"];
$recuperado = $_REQUEST["recuperado"];
$recup_menor    = $_REQUEST["recup_menor"];
$estampa   = $_REQUEST["estampa"];
$dispersos   = $_REQUEST["dispersos"];
$rayado   = $_REQUEST["rayado"];
$c_superior   = $_REQUEST["c_superior"];
$c_lateral   = $_REQUEST["c_lateral"];
$quemados   = $_REQUEST["quemados"];
$redondos   = $_REQUEST["redondos"];
$aire   = $_REQUEST["aire"];
$otros  = $_REQUEST["otros"];

$dia = $_REQUEST["dia"];
$mes = $_REQUEST["mes"];
$ano = $_REQUEST["ano"];


if(strlen($dia) == 1)
	$dia="0".$dia;
if(strlen($mes) == 1)
	$mes="0".$mes;

if($recuperado == '')
	$recuperado = 0;

if($recup_menor == '')
	$recup_menor = 0;

if($estampa == '')
	$estampa = 0;

if($dispersos == '')
	$dispersos = 0;

if($rayado == '')
	$rayado = 0;

if($c_superior == '')
	$c_superior = 0;

if($c_lateral == '')
	$c_lateral = 0;
	
if($quemados == '')
	$quemados = 0;
	
if($redondos == '')
	$redondos = 0;
	
if($aire == '')
	$aire = 0;

if($otros == '')
	$otros = 0;
	
$fecha=$ano.'-'.$mes.'-'.$dia;
if($Proceso =="G" || $Proceso=="M")
{
	$encuentro = "N";
	$Consulta="select * from cal_web.rechazo_catodos_obs where fecha = '".$fecha."' and turno = '".$cmbturno."' and grupo = '".$cmbgrupo."'";
	$respue=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($respue))
	{
		$encuentro = "S";
	}
	if($encuentro=="N")
	{
		$Inserto = "insert into cal_web.rechazo_catodos_obs (fecha,turno,grupo,encargado,observacion) values";
		$Inserto.="('".$fecha."','".$cmbturno."','".$cmbgrupo."','".$encargado."','".$observacion."')";
		mysqli_query($link, $Inserto);
	}
}	
if($Proceso == "G")
{
	$inspector = ucwords(strtolower($inspector));
	$Insertar = "INSERT INTO cal_web.rechazo_catodos (fecha,turno,inspector,grupo,lado,cuba,unid_recup,recup_menor,estampa,dispersos,rayado,cordon_superior,cordon_lateral,quemados,redondos,aire,otros)";
	$Insertar = "$Insertar VALUES('$fecha','$cmbturno','$inspector',$cmbgrupo,'$cmblado',$cmbcuba,$recuperado,$recup_menor,$estampa,$dispersos,$rayado,$c_superior,$c_lateral,$quemados,$redondos,$aire,$otros)";
	mysqli_query($link, $Insertar);
	//PARA INTERFACES PI
	$Insertar = "INSERT INTO raf_web.ti_rechazo_catodos (fecha,turno,inspector,grupo,lado,cuba,unid_recup,recup_menor,estampa,dispersos,rayado,cordon_superior,cordon_lateral,quemados,redondos,aire,otros)";
	$Insertar = "$Insertar VALUES('$fecha','$cmbturno','$inspector',$cmbgrupo,'$cmblado',$cmbcuba,$recuperado,$recup_menor,$estampa,$dispersos,$rayado,$c_superior,$c_lateral,$quemados,$redondos,$aire,$otros)";
	mysqli_query($link, $Insertar);

	$valores = 'Proceso=B&ano='.$ano.'&mes='.$mes.'&dia='.$dia.'&cmbturno='.$cmbturno.'&cmbgrupo='.$cmbgrupo.'&inspector='.$inspector.'&cmblado='.$cmblado.'&cmbcuba='.($cmbcuba + 1);
	$valores.='&encargado='.$encargado.'&observacion='.$observacion;
	header("location:cal_rechazo_catodos.php?".$valores);
}

if($Proceso == "M")
{
	$Modificar = "UPDATE cal_web.rechazo_catodos SET lado='$cmblado', cuba=$cmbcuba, unid_recup=$recuperado, recup_menor=$recup_menor, estampa=$estampa, dispersos=$dispersos, rayado=$rayado,";
	$Modificar.=" cordon_superior=$c_superior, cordon_lateral=$c_lateral, quemados=$quemados, redondos=$redondos, aire=$aire, otros=$otros";
	$Modificar = "$Modificar WHERE fecha = '$fecha' AND turno = '$cmbturno' AND grupo = $cmbgrupo AND cuba = $cmbcuba";
	mysqli_query($link, $Modificar);
	//PARA INTERFACES PI
	$Modificar = "UPDATE raf_web.ti_rechazo_catodos SET lado='$cmblado', cuba=$cmbcuba, unid_recup=$recuperado, recup_menor=$recup_menor, estampa=$estampa, dispersos=$dispersos, rayado=$rayado,";
	$Modificar.=" cordon_superior=$c_superior, cordon_lateral=$c_lateral, quemados=$quemados, redondos=$redondos, aire=$aire, otros=$otros";
	$Modificar = "$Modificar WHERE fecha = '$fecha' AND turno = '$cmbturno' AND grupo = $cmbgrupo AND cuba = $cmbcuba";
	mysqli_query($link, $Modificar);

	$valores = 'Proceso=B&ano='.$ano.'&mes='.$mes.'&dia='.$dia.'&cmbturno='.$cmbturno.'&cmbgrupo='.$cmbgrupo.'&inspector='.$inspector.'&cmblado='.$cmblado.'&cmbcuba='.($cmbcuba + 1);
	$valores.='&encargado='.$encargado.'&observacion='.$observacion;
	header("location:cal_rechazo_catodos.php?".$valores);
	
}
?>
