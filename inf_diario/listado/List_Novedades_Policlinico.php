
<?php
include("conectar.php");
	$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";
	$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
	$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";
    $Fecha =$ano."-".$mes."-".$dia;

    $Cod_Tipo7="7";

    $sql = "SELECT * FROM informe_diario.novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo7%' ";
    $result = mysqli_query($link,$sql);
	$Nombre_pol="";
    $Texto_pol ="";
   if ($row = mysqli_fetch_array($result))
   {
       $Nombre_pol = $row["Nombre"];
       $Texto_pol = strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
