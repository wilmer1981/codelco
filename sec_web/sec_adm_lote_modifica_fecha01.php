<?php
include("../principal/conectar_sec_web.php");
//MODIFICO FECHA DE CREACION DEL LOTE EN TABLA LOTE_CATODO
$Actualiza="UPDATE sec_web.lote_catodo set fecha_creacion_lote='".$FechaLoteModifi."' where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and corr_enm='".$CorrEnm."'";
mysqli_query($link, $Actualiza);
header('location:sec_adm_lote_modifica_fecha.php?CodBulto='.$CodBulto.'&NumBulto='.$NumBulto.'&CmbAno='.$CmbAno)
?>