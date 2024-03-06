<?php
include("../principal/conectar_sec_web.php");

$CmbAno   = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";
$CodBulto = isset($_REQUEST["CodBulto"])?$_REQUEST["CodBulto"]:"";
$NumBulto = isset($_REQUEST["NumBulto"])?$_REQUEST["NumBulto"]:"";
$CorrEnm  = isset($_REQUEST["CorrEnm"])?$_REQUEST["CorrEnm"]:"";
$FechaLoteModifi = isset($_REQUEST["FechaLoteModifi"])?$_REQUEST["FechaLoteModifi"]:"";

//MODIFICO FECHA DE CREACION DEL LOTE EN TABLA LOTE_CATODO
$Actualiza="UPDATE sec_web.lote_catodo set fecha_creacion_lote='".$FechaLoteModifi."' where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and corr_enm='".$CorrEnm."'";
mysqli_query($link, $Actualiza);
header('location:sec_adm_lote_modifica_fecha.php?CodBulto='.$CodBulto.'&NumBulto='.$NumBulto.'&CmbAno='.$CmbAno)
?>