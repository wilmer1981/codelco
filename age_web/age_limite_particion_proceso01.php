<?php
	include("../principal/conectar_principal.php");
	
	$Param='';
	switch ($Proceso)
	{
		case "N"://NUEVO
			$Insertar="insert into age_web.limites_particion (cod_plantilla,nombre_plantilla,cod_ley,correlativo,descripcion,rango1,rango2,limite_particion,cod_unidad,proceso) values (";
			$Insertar.="'$TxtNumPlantilla','$TxtNombrePlantilla','$CmbLeyes','$TxtCorr','$TxtDescripcion','$TxtRango1','$TxtRango2','".str_replace(',','.',$TxtLimPart)."','$CmbUnidad','$TipoProceso')";
			mysqli_query($link, $Insertar);
			$Param="?CmbPlantilla=".$CmbPlantilla."&CmbLeyes=".$CmbLeyes."&Recarga=S&TipoProceso=".$TipoProceso;
			break;
		case "M"://MODIFICAR
			$Actualizar="UPDATE age_web.limites_particion set descripcion='$TxtDescripcion',rango1='$TxtRango1',rango2='$TxtRango2',limite_particion='".str_replace(',','.',$TxtLimPart)."',cod_unidad='$CmbUnidad' ";
			$Actualizar.="where cod_plantilla='$CmbPlantilla' and cod_ley='$CmbLeyes' and correlativo='$TxtCorr'";
			mysqli_query($link, $Actualizar);
			$Actualizar="UPDATE age_web.limites_particion set nombre_plantilla='$TxtNombrePlantilla' ";
			$Actualizar.="where cod_plantilla='$CmbPlantilla'";
			mysqli_query($link, $Actualizar);
			$Param="?CmbPlantilla=".$CmbPlantilla."&CodLey=".$CmbLeyes."&Proceso=M&Corr=".$TxtCorr."&TipoProceso=".$TipoProceso;
			break;
		case "E"://ELIMINAR
			$Eliminar ="delete from age_web.limites_particion  where cod_plantilla='$CmbPlantilla' and cod_ley='$CmbLeyes' and correlativo='$TxtCorr'";
			mysqli_query($link, $Eliminar);
			$Param="?CmbPlantilla=".$CmbPlantilla."&CmbLeyes=".$CmbLeyes."&Recarga=S&TipoProceso=".$TipoProceso;
			break;
	}
	if($Param=='')
		$Param='?TipoProceso='.$TipoProceso;
	header("location:age_limite_particion_proceso.php".$Param);
?>