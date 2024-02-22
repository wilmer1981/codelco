<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;
$Cod_Tipo2="2";

   $refino = "SELECT * FROM fundicion WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo2%' ";
   //echo $refino;
   $result2 = mysql_query($refino, $link);


   if ($row = mysql_fetch_array($result2))
   {

	$Nombre_r = $row["Nombre"];
    $Campo1_r = $row["Campo1"];
    $Campo2_r = $row["Campo2"];
    $Campo3_r = $row["Campo3"];
	if($Campo3_r != "" || $Campo1_r == "")
	{
	$Campo3_r="F/S"; 
    }
    $Campo4_r = $row["Campo4"];
	if($Campo4_r != "" || $Campo2_r == "")
	{
	$Campo4_r="F/S"; 
    }
    $Campo5_r = $row["Campo5"];
    $Campo6_r = $row["Campo6"];
    $Campo7_r = $row["Campo7"];
    $Campo8_r = $row["Campo8"];
    $Campo9_r = $row["Campo9"];
    $Campo10_r = $row["Campo10"];
    $Campo11_r = $row["Campo11"];
    $Campo12_r = $row["Campo12"];
    $Campo13_r = $row["Campo13"];
    $Campo14_r = $row["Campo14"];
    $Campo15_r = $row["Campo15"];
    $Campo16_r = $row["Campo16"];
    $Campo17_r = $row["Campo17"];
    $Campo18_r = $row["Campo18"];
    $Campo19_r = $row["Campo19"];
    $Campo20_r = $row["Campo20"];
    $Campo21_r = $row["Campo21"];
    $Campo22_r = $row["Campo22"];	
    $Campo23_r = $row["Campo23"];
    $Campo24_r = $row["Campo24"];
    $Campo25_r = $row["Campo25"];
    $Campo26_r = $row["Campo26"];
    $Campo27_r = $row["Campo27"];
    $Campo28_r = $row["Campo28"];
    $Campo29_r = $row["Campo29"];
    $Campo30_r = $row["Campo30"];
	$Campo31_r = $row["Campo31"];
	$Campo32_r = $row["Campo32"];
	$Campo33_r = $row["Campo33"];
	$Campo34_r = $row["Campo34"];
	$Campo35_r = $row["Campo35"];
	

    }
    include("cerrar.php"); 
?>
