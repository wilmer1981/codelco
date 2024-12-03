<?php
include("conectar.php");
	$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";
	$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
	$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";	
$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo="2";

   $sql = "SELECT * FROM informe_diario.novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo%' ";
   $result = mysqli_query($link,$sql);
   $Nombre_r="";
   $Texto_r ="";
   if ($row = mysqli_fetch_array($result))
   {
       $Nombre_r = $row["Nombre"];
       $Texto_r  = strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
