<?php
	include("../principal/conectar_principal.php");
	
	switch ($Proceso)
	{
		case "N"://NUEVO PROVEEDOR
			$Insertar="insert into rec_web.proved () values (";
			$Insertar.="'".$TxtRutPrv."-".strtoupper($TxtDv)."','$TxtNomPrv')";
			mysqli_query($link, $Insertar);
			$Insertar="insert into sipa_web.proveedores () values (";
			$Insertar.="'".$TxtRutPrv."-".strtoupper($TxtDv)."','$TxtNomPrv','','')";
			mysqli_query($link, $Insertar);
			$Insertar="insert into ram_web.proveedor () values (";
			$Insertar.="'".$TxtRutPrv."-".strtoupper($TxtDv)."','$TxtNomPrv')";
			mysqli_query($link, $Insertar);
			break;
		case "M"://MODIFICAR PROVEEDOR
			$Modificar="UPDATE rec_web.proved  set NOMPRV_A='$TxtNomPrv' where RUTPRV_A='".$TxtRutPrv."-".strtoupper($TxtDv)."'";
			mysqli_query($link, $Modificar);
			$Modificar="UPDATE sipa_web.proveedores  set nombre_prv='$TxtNomPrv' where rut_prv='".$TxtRutPrv."-".strtoupper($TxtDv)."'";
			mysqli_query($link, $Modificar);
			$Modificar="UPDATE ram_web.proveedor  set nombre_prv='$TxtNomPrv' where rut_prv='".$TxtRutPrv."-".strtoupper($TxtDv)."'";
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