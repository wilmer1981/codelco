<?php
	include("../principal/conectar_principal.php");
	switch ($Proceso)
	{
		case "M":
			if($Enabal=="1")
			{
				$Enabal="S";
			}
			else
			{
				$Enabal="N";
			}
			$FechaMuestra=$CmbAno.'-'.$CmbMes.'-'.$CmbDias.' '.$CmbHora.':'.$CmbMinutos.':'.'00';
			$Actualizar="UPDATE cal_web.solicitud_analisis set id_muestra='".$IdMuestra."',cod_periodo='".$CmbPeriodo."',cod_area='".$CmbArea."', ";
			$Actualizar.=" cod_ccosto = '".$CmbCosto."',observacion = '".$Observacion."',agrupacion = '".$CmbAgrupacion."',tipo = '".$CmbTipo."', ";
			$Actualizar.=" cod_producto='".$CmbProductos."',cod_subproducto='".$CmbSubProducto."',fecha_muestra='".$FechaMuestra."',enabal='".$Enabal."'   ";
			$Actualizar.=" where nro_solicitud= '".$Sol."' ";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
			$Consulta=" select * from cal_web.leyes_por_solicitud where nro_solicitud = '".$Sol."'  ";
			$Respuesta1=mysqli_query($link, $Consulta);
			if ($Fila1=mysqli_fetch_array($Respuesta1))
			{
				$Actualizar="UPDATE cal_web.leyes_por_solicitud set id_muestra='".$IdMuestra."',cod_producto='".$CmbProductos."',cod_subproducto='".$CmbSubProducto."'  ";
				$Actualizar.=" where nro_solicitud ='".$Sol."' ";				
				mysqli_query($link, $Actualizar);
			} 
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmSolicitud.action='cal_modificador_solicitudes.php';";
			echo "window.opener.document.FrmSolicitud.submit();";
			echo "window.close();";
			echo "</script>";
			break;
	}
?>