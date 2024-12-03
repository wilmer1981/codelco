
<?php
include("conectar.php");
	$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";
	$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
	$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo6="6";

   $sql = "SELECT * FROM informe_diario.novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo6%' ";
   $result = mysqli_query($link, $sql);
   $Nombre_seg="";
   $Texto_seg="";
   if ($row = mysqli_fetch_array($result))
   {
       $Nombre_seg = $row["Nombre"];
       $Texto_seg = strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
