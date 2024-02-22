<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;
$Cod_Tipo="4";

   $sql = "SELECT * FROM fundicion WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo%' ";
   $result = mysql_query($sql, $link);


   if ($row = mysql_fetch_array($result))
   {

	$Nombre_t = $row["Nombre"];
    $Campo1_t = $row["Campo1"];
    $Campo2_t = $row["Campo2"];
    $Campo3_t = $row["Campo3"];
    $Campo4_t = $row["Campo4"];
    $Campo5_t = $row["Campo5"];
    $Campo6_t = $row["Campo6"];
    $Campo7_t = $row["Campo7"];
    $Campo8_t = $row["Campo8"];
    $Campo9_t = $row["Campo9"];
    $Campo10_t = $row["Campo10"];
    $Campo11_t = $row["Campo11"];
    $Campo12_t = $row["Campo12"];
    	if($Campo12_t != "" || $Campo9_t == "")
    	{
    	$Campo12_t="F/S"; 
        }	
   	$Campo13_t = $row["Campo13"];
    	if($Campo13_t != "" || $Campo10_t == "")
	    {
    	$Campo13_t="F/S"; 
        }   
    $Campo14_t = $row["Campo14"];
	    if($Campo14_t != "" || $Campo11_t == "")
	    {
	     $Campo14_t="F/S"; 
        }   
    $Campo15_t = $row["Campo15"];		
    }
    
    include("cerrar.php"); 
?>