<?php
	include("../principal/conectar_pac_web.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$TxtRut  = isset($_REQUEST["TxtRut"])?$_REQUEST["TxtRut"]:"";
	$TxtDv = isset($_REQUEST["TxtDv"])?$_REQUEST["TxtDv"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$TxtPrecioUS = isset($_REQUEST["TxtPrecioUS"])?$_REQUEST["TxtPrecioUS"]:0;
	$CmbTras     = isset($_REQUEST["CmbTras"])?$_REQUEST["CmbTras"]:"";
	$TxtReferencia = isset($_REQUEST["TxtReferencia"])?$_REQUEST["TxtReferencia"]:"";
	$TxtNombre     = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$TxtDireccion = isset($_REQUEST["TxtDireccion"])?$_REQUEST["TxtCiudad"]:"";
	$TxtCiudad    = isset($_REQUEST["TxtCiudad"])?$_REQUEST["TxtDireccion"]:"";
	$TxtTelefonos  = isset($_REQUEST["TxtTelefonos"])?$_REQUEST["TxtTelefonos"]:"";
	$TxtFax    = isset($_REQUEST["TxtFax"])?$_REQUEST["TxtFax"]:"";
	$TxtGiroCliente   = isset($_REQUEST["TxtGiroCliente"])?$_REQUEST["TxtGiroCliente"]:"";
	$TxtGlosa  = isset($_REQUEST["TxtGlosa"])?$_REQUEST["TxtGlosa"]:"";
	$TxtDivSAP  = isset($_REQUEST["TxtDivSAP"])?$_REQUEST["TxtDivSAP"]:"";
	$TxtAlmacenSap  = isset($_REQUEST["TxtAlmacenSap"])?$_REQUEST["TxtAlmacenSap"]:"";
	$TxtContrato  = isset($_REQUEST["TxtContrato"])?$_REQUEST["TxtContrato"]:"";
	$TxtCorrCliente  = isset($_REQUEST["TxtCorrCliente"])?$_REQUEST["TxtCorrCliente"]:"";
	
	$RutCliente       = $TxtRut."-".$TxtDv;
	$TxtIndicadorTras = $CmbTras;

	switch ($Proceso)
	{
		case "N":
			$Insertar="insert into pac_web.clientes (rut_cliente,referencia,nombre,direccion,ciudad,telefonos,fax,div_sap,almacen_sap,glosa,indicador_traslado,giro_cliente,contrato,precio_us) values (";
			$Insertar = $Insertar."'$RutCliente','$TxtReferencia','$TxtNombre','$TxtDireccion','$TxtCiudad','$TxtTelefonos','$TxtFax','$TxtDivSAP','$TxtAlmacenSap','$TxtGlosa','$TxtIndicadorTras','$TxtGiroCliente','$TxtContrato',".str_replace(",",".",$TxtPrecioUS).")";
		 	echo $Insertar;
			$result1=mysqli_query($link, $Insertar);
		 	if (!$result1) {
    			die('Invalid query: ' . mysql_error());
			}
			$msg = "Registro creado correctamente.";
			break;
		case "M":
		
			$Modificar="UPDATE pac_web.clientes set referencia='$TxtReferencia',nombre='$TxtNombre',direccion='$TxtDireccion',ciudad='$TxtCiudad',telefonos='$TxtTelefonos',fax='$TxtFax',div_sap='$TxtDivSAP',almacen_sap='$TxtAlmacenSap',glosa='$TxtGlosa',indicador_traslado='$TxtIndicadorTras',giro_cliente='$TxtGiroCliente',contrato='$TxtContrato',precio_us=".str_replace(",",".",$TxtPrecioUS)." where rut_cliente='".$RutCliente."' and corr_interno_cliente='".$TxtCorrCliente."'";
			/*echo $Modificar;*/
			$result1=mysqli_query($link, $Modificar);
		 	if (!$result1) {
    			die('Invalid query: ' . mysql_error());
			}
			//echo "Query ".$Modificar."<br>";
			$msg = "Registro modificado correctamente.";
			break;
		case "E":
			$reg_delete = false;
			$EncontroRelacion=false;
			$Valores=substr($Valores,0,strlen($Valores)-2);
			$Datos=explode("//",$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode("~",$Valor);			
				$RutCliente=$Datos2[0];
				$corr_interno_cliente=$Datos2[1];
				$Eliminar ="delete from pac_web.clientes where rut_cliente='".$RutCliente."' and corr_interno_cliente='".$corr_interno_cliente."'";
				$result1=mysqli_query($link, $Eliminar);
				if (!$result1) {
					die('Invalid query: ' . mysql_error());
				}
				$reg_delete = true;
			}
			
			
			break;	
	}
	if ($Proceso=="E")
	{
		header("location:pac_ingreso_clientes.php?EncontroRelacion=".$EncontroRelacion."&reg_delete=".$reg_delete);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngCliente.action='pac_ingreso_clientes.php';";
		echo "window.opener.document.FrmIngCliente.submit();";
		echo "window.close();";
		echo "alert('".$msg."');";
		echo "</script>";	
	}	
?>