<?php
	include("../principal/conectar_principal.php");
	$Proceso  =  isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  =  isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Opc      =  isset($_REQUEST["Opc"])?$_REQUEST["Opc"]:"";
	$CmbProductos = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$Enabal = isset($_REQUEST["Enabal"])?$_REQUEST["Enabal"]:"";
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";
	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	$CmbDias = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:"";
	$CmbHora = isset($_REQUEST["CmbHora"])?$_REQUEST["CmbHora"]:"";
	$CmbMinutos = isset($_REQUEST["CmbMinutos"])?$_REQUEST["CmbMinutos"]:"";
	$IdMuestra = isset($_REQUEST["IdMuestra"])?$_REQUEST["IdMuestra"]:"";
	$CmbPeriodo = isset($_REQUEST["CmbPeriodo"])?$_REQUEST["CmbPeriodo"]:"";
	$CmbArea = isset($_REQUEST["CmbArea"])?$_REQUEST["CmbArea"]:"";
	$CmbCosto = isset($_REQUEST["CmbCosto"])?$_REQUEST["CmbCosto"]:"";
	$Observacion = isset($_REQUEST["Observacion"])?$_REQUEST["Observacion"]:"";
	$CmbAgrupacion = isset($_REQUEST["CmbAgrupacion"])?$_REQUEST["CmbAgrupacion"]:"";
	$CmbTipo = isset($_REQUEST["CmbTipo"])?$_REQUEST["CmbTipo"]:"";
	$Sol = isset($_REQUEST["Sol"])?$_REQUEST["Sol"]:"";
	
	switch ($Proceso)
	{
		case "M":
			if($Enabal=="1"){
				$Enabal="S";
			}else{
				$Enabal="N";
			}
			$FechaMuestra=$CmbAno.'-'.$CmbMes.'-'.$CmbDias.' '.$CmbHora.':'.$CmbMinutos.':'.'00';
			$Actualizar="update cal_web.solicitud_analisis set id_muestra='".$IdMuestra."',cod_periodo='".$CmbPeriodo."',cod_area='".$CmbArea."', ";
			$Actualizar.=" cod_ccosto = '".$CmbCosto."',observacion = '".$Observacion."',agrupacion = '".$CmbAgrupacion."',tipo = '".$CmbTipo."', ";
			$Actualizar.=" cod_producto='".$CmbProductos."',cod_subproducto='".$CmbSubProducto."',fecha_muestra='".$FechaMuestra."',enabal='".$Enabal."'   ";
			$Actualizar.=" where nro_solicitud= '".$Sol."' ";
			mysqli_query($link,$Actualizar);
			//echo $Actualizar;
			$Consulta=" select * from cal_web.leyes_por_solicitud where nro_solicitud = '".$Sol."'  ";
			$Respuesta1=mysqli_query($link,$Consulta);
			if ($Fila1=mysqli_fetch_array($Respuesta1))
			{
				$Actualizar="update cal_web.leyes_por_solicitud set id_muestra='".$IdMuestra."',cod_producto='".$CmbProductos."',cod_subproducto='".$CmbSubProducto."'  ";
				$Actualizar.=" where nro_solicitud ='".$Sol."' ";				
				mysqli_query($link,$Actualizar);
			} 
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmSolicitud.action='cal_modificador_solicitudes.php';";
			echo "window.opener.document.FrmSolicitud.submit();";
			echo "window.close();";
			echo "</script>";
			break;
	}
?>