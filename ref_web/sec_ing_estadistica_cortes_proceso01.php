<?php
	include("../principal/conectar_sec_web.php");

	$dia1  = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:"";
	$mes1  = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
	$ano1  = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";
	$dia2  = isset($_REQUEST["dia2"])?$_REQUEST["dia2"]:"";
	$mes2  = isset($_REQUEST["mes2"])?$_REQUEST["mes2"]:"";
	$ano2  = isset($_REQUEST["ano2"])?$_REQUEST["ano2"]:"";
	$hr1   = isset($_REQUEST["hr1"])?$_REQUEST["hr1"]:"";
	$hr2   = isset($_REQUEST["hr2"])?$_REQUEST["hr2"]:"";
	$mm1   = isset($_REQUEST["mm1"])?$_REQUEST["mm1"]:"";
	$mm2     = isset($_REQUEST["mm2"])?$_REQUEST["mm2"]:"";

	$proceso      = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$opcion       = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$cmbgrupo     = isset($_REQUEST["cmbgrupo"])?$_REQUEST["cmbgrupo"]:"";
	$cmbtipo      = isset($_REQUEST["cmbtipo"])?$_REQUEST["cmbtipo"]:"";
	$txtkah1      = isset($_REQUEST["txtkah1"])?$_REQUEST["txtkah1"]:"";
	$txtkah2      = isset($_REQUEST["txtkah2"])?$_REQUEST["txtkah2"]:"";
	$parametros   = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";


	$fecha_des = $ano1."-".$mes1."-".$dia1." ".$hr1.":".$mm1;
	$fecha_con = $ano2."-".$mes2."-".$dia2." ".$hr2.":".$mm2;
	
	if (($proceso == "G") and ($opcion == "N"))
	{
		$consulta = "SELECT * FROM sec_web.cortes_refineria WHERE cod_grupo = '".$cmbgrupo."' AND fecha_desconexion = '".$fecha_des."'";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mensaje = "Ya Exite la Fecha de Desconexion para Este Grupo";
			header("Location:sec_ing_estadistica_cortes_proceso.php?activar=&mensaje=".$mensaje);
		}
		else 
		{
			$insertar = "INSERT INTO sec_web.cortes_refineria (tipo_desconexion,cod_grupo,fecha_desconexion,fecha_conexion,kahdird,kahdirc)";
			$insertar = $insertar." VALUES ('".$cmbtipo."','".$cmbgrupo."','".$fecha_des."','".$fecha_con."',".$txtkah1.",'".$txtkah2."')";		
			mysqli_query($link, $insertar);		
			header("Location:sec_ing_estadistica_cortes_proceso.php?activar=");
		}
	}
		
	if (($proceso == "G") and ($opcion == "M"))
	{		
		$actualizar = "UPDATE sec_web.cortes_refineria SET tipo_desconexion = '".$cmbtipo."',fecha_conexion = '".$fecha_con."'";
		$actualizar = $actualizar.",kahdird = ".$txtkah1.",kahdirc = ".$txtkah2;
		$actualizar = $actualizar." WHERE cod_grupo = '".$cmbgrupo."' AND fecha_desconexion = '".$fecha_des."'";
		mysqli_query($link, $actualizar);		
		header("Location:sec_ing_estadistica_cortes_proceso.php?activar=");
	}
	
	if ($proceso == "E")
	{
		$valores = explode("~",$parametros);
		foreach($valores as $c=>$v)
		{	
			$arreglo = explode("/", $v); //0: grupo, 1: fecha_desconexion.		
			//Borra de Sec_Web.
			$eliminar = "DELETE FROM sec_web.cortes_refineria WHERE cod_grupo = '".$arreglo[0]."' AND fecha_desconexion = '".$arreglo[1]."'";
			mysqli_query($link, $eliminar);
		}
		
		$mensaje = "Grupo(s) Eliminado(s) Correctamente";
		header("Location:sec_ing_estadistica_cortes.php?mensaje=".$mensaje);	
	}
	
	include("../principal/cerrar_sec_web.php");
?>