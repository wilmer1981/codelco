<?php
	include("../principal/conectar_principal.php");
	//echo $Proceso."<br>";
	$Proceso = isset($_REQUEST['Proceso']) ? $_REQUEST['Proceso'] : '';
	$TxtRutPrv = isset($_REQUEST['TxtRutPrv']) ? $_REQUEST['TxtRutPrv'] : '';
	$TxtDv     = isset($_REQUEST['TxtDv']) ? $_REQUEST['TxtDv'] : '';
	$TxtNomPrv = isset($_REQUEST['TxtNomPrv']) ? $_REQUEST['TxtNomPrv'] : '';
	$ChkHumedad = isset($_REQUEST['ChkHumedad']) ? $_REQUEST['ChkHumedad'] : '';
	$CmbProveedor = isset($_REQUEST['CmbProveedor']) ? $_REQUEST['CmbProveedor'] : '';

	switch ($Proceso)
	{
		case "N"://NUEVO PROVEEDOR
			$Insertar="insert into rec_web.proved () values (";
			$Insertar.="'".$TxtRutPrv."-".strtoupper($TxtDv)."','$TxtNomPrv')";
			mysqli_query($link, $Insertar);
			//echo $Insertar."<br>";
			$Insertar="insert into sipa_web.proveedores (rut_prv,nombre_prv,hum_ult_rec,direccion) values (";
			$Insertar.="'".$TxtRutPrv."-".strtoupper($TxtDv)."','$TxtNomPrv','".$ChkHumedad."','')";
			mysqli_query($link, $Insertar);
			//echo $Insertar."<br>";
			$Insertar="insert into ram_web.proveedor () values (";
			$Insertar.="'".$TxtRutPrv."-".strtoupper($TxtDv)."','$TxtNomPrv')";
			mysqli_query($link, $Insertar);
			//echo $Insertar."<br>";
			break;
		case "M"://MODIFICAR PROVEEDOR
			$Modificar="UPDATE rec_web.proved  set NOMPRV_A='$TxtNomPrv' where RUTPRV_A='".$TxtRutPrv."-".strtoupper($TxtDv)."'";
			mysqli_query($link, $Modificar);
			$Modificar="UPDATE sipa_web.proveedores  set nombre_prv='$TxtNomPrv',hum_ult_rec='".$ChkHumedad."' where rut_prv='".$TxtRutPrv."-".strtoupper($TxtDv)."'";
		   //echo $Modificar."<br>";		
			mysqli_query($link, $Modificar);
			$Modificar="UPDATE ram_web.proveedor  set nombre='$TxtNomPrv' where rut_proveedor='".$TxtRutPrv."-".strtoupper($TxtDv)."'";
			mysqli_query($link, $Modificar);
			break;
		case "E"://ELIMINAR PROVEEDOR
			$Eliminar ="delete from rec_web.proved  where RUTPRV_A='".$TxtRutPrv."-".strtoupper($TxtDv)."'";
			mysqli_query($link, $Eliminar);
			$Eliminar ="delete from sipa_web.proveedores  where rut_prv='".$TxtRutPrv."-".strtoupper($TxtDv)."'";
			mysqli_query($link, $Eliminar);
			break;
	}
	header("location:age_proveedores_proceso.php?Recarga=S&CmbProveedor=".$TxtRutPrv."-".strtoupper($TxtDv));
?>