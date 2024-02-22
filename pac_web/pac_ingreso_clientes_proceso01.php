<?php
	include("../principal/conectar_pac_web.php");
	$RutCliente=$TxtRut."-".$TxtDv;
	$TxtIndicadorTras = $CmbTras;
	if($TxtPrecioUS=='')
	$TxtPrecioUS=0;
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
			while (list($Clave,$Valor)=each($Datos))
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