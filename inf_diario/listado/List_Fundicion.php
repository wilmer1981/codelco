
<?
include("conectar.php");  

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo1="1";

   $fundicion = "SELECT * FROM fundicion WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo1%' ";
   $result1 = mysql_query($fundicion, $link);



   if ($row = mysql_fetch_array($result1))
   {

	$Nombre1 = $row["Nombre"];
    $Campo1 = $row["Campo1"];
    $Campo2 = $row["Campo2"];
    $Campo3 = $row["Campo3"];
    $Campo4 = $row["Campo4"];
    $Campo5 = $row["Campo5"];
    $Campo6 = $row["Campo6"];
	if($Campo6 != "" || $Campo1 == "")
	{
	$Campo6="F/S"; 
    }
	$Campo7 = $row["Campo7"];
    $Campo8 = $row["Campo8"];
    $Campo9 = $row["Campo9"];
    $Campo10 = $row["Campo10"];
	if($Campo10 != "" || $Campo9 == "")
	{
	$Campo10="F/S"; 
    }
    $Campo11 = $row["Campo11"];
    $Campo12 = $row["Campo12"];
    $Campo13 = $row["Campo13"];
    $Campo14 = $row["Campo14"];
    $Campo15 = $row["Campo15"];
    $Campo16 = $row["Campo16"];
	if($Campo16 != "" || $Campo12 == "")
	{
	$Campo16="F/S"; 
    }
    $Campo17 = $row["Campo17"];
	if($Campo17 != "" || $Campo14 == "")
	{
	$Campo17="F/S"; 
    }
    $Campo18 = $row["Campo18"];
    $Campo19 = $row["Campo19"];
    $Campo20 = $row["Campo20"];
    $Campo21 = $row["Campo21"];
    $Campo22 = $row["Campo22"];
    $Campo23 = $row["Campo23"];
	if($Campo23 != "" || $Campo18 == "")
	{
	$Campo23="F/S"; 
    }
    $Campo24 = $row["Campo24"];
	if($Campo24 != "" || $Campo20 == "")
	{
	$Campo24="F/S"; 
    }
    $Campo25 = $row["Campo25"];
    $Campo26 = $row["Campo26"];
    $Campo27 = $row["Campo27"];
    $Campo28 = $row["Campo28"];
    $Campo29 = $row["Campo29"];
    $Campo30 = $row["Campo30"];
    $Campo31 = $row["Campo31"];
    $Campo32 = $row["Campo32"];
    $Campo33 = $row["Campo33"];
    $Campo34 = $row["Campo34"];
    $Campo35 = $row["Campo35"];
	$Campo36 = $row["Campo36"];
	$Campo37 = $row["Campo37"];
	$Campo38 = $row["Campo38"];
    }
    include("cerrar.php"); 
    
?>