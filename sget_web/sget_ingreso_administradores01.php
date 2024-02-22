<? include("../principal/conectar_sget_web.php");
	$Encontro=false;
	if($Volver=='R')//SI POPUP ES LLAMADA DE REASIGNACION DE ADM.CODELCO
	{
		$VolverPag='sget_adm_hoja_ruta_reasigna.php';
		$VolverPopup='FrmObs';
	}
	else
	{
		$VolverPag='sget_mantenedor_contratos_proceso.php';	
		$VolverPopup='FrmPopupUsuario';
	}
	switch($Selec)
	{
		case "G":
			$Rut=$TxtRutPrv."-".$TxtDv;
			if($Opc01=='A')
			{
				$tb=" sget_administrador_contratos ";
				$pk=" rut_adm_contrato  ";
				$CmbAdmCtto01=$Rut;
			}
			if($Opc01=='B')
			{
				$tb=" sget_administrador_contratistas ";
				$pk=" rut_adm_contratista ";
				$CmbAdmContratista01=$Rut;
			}
			$Consulta="Select * from $tb where $pk='".$Rut."'";
			$RespMod=mysql_query($Consulta);
			if($FilaMod=mysql_fetch_array($RespMod))
			{
				$Update="UPDATE $tb set nombres= '".strtoupper($TxtNombres)."',ape_paterno='".strtoupper($TxtApePaterno)."',ape_materno='".strtoupper($TxtApeMaterno)."',telefono= '".$TxtTelefono."', email='".strtoupper($TxtEmail)."',cargo='".$CmbCargo."' ";
				$Update.=" where $pk='".$Rut."'";
				mysql_query($Update);
				echo "<script languaje='JavaScript'>";
				if($Volver=='R')	
					echo " window.opener.document.".$VolverPopup.".action=\"".$VolverPag."?AdmCtto=".$Rut."\";";
				else
					echo " window.opener.document.".$VolverPopup.".action=\"".$VolverPag."?Opc=".$Opc01."&TxtContrato=".$TxtContrato01."&TxtDescripcion=".$TxtDescripcion01."&TxtMontoCtto=".$TxtMontoCtto01."&TxtAreaTrabajo=".$TxtAreaTrabajo01."&TxtFechaInicio=".$TxtFechaInicio01."&TxtFechaTermino=".$TxtFechaTermino01."&CmbTipoCtto=".$CmbTipoCtto01."&CmbAdmCtto2=".$CmbAdmCtto01."&TxtFechaSolp=".$TxtFechaSolp01."&CmbAdmContratista2=".$CmbAdmContratista01."&CmbCargo=".$CmbCargo01."&Opcion=".$Opcion01."&TxtFechaGarantia=".$TxtFechaGarantia01."&CmbEmpresa=".$CmbEmpresa01."&CmbMoneda=".$CmbMoneda01."&CmbPrevencionista=".$CmbPrevencionista01."&CmbTipoCttoPers=".$CmbTipoCttoPers01."&Opcion=".$Opcion01."\";";
				echo " window.opener.document.".$VolverPopup.".submit();";		
				echo " window.close();</script>";		
			}
			else
			{
			  	$Rut=$TxtRutPrv."-".$TxtDv;
				$Insetar="INSERT INTO $tb($pk,nombres,ape_paterno,ape_materno,telefono,email,cargo)";
				$Insetar.="values('".$TxtRutPrv."-".$TxtDv."','".strtoupper($TxtNombres)."','".strtoupper($TxtApePaterno)."','".strtoupper($TxtApeMaterno)."','".$TxtTelefono."','".strtoupper($TxtEmail)."','".$CmbCargo."')";
				//echo $Insetar;
				mysql_query($Insetar);
				
				echo "<script languaje='JavaScript'>";
				if($Volver=='R')	
					echo " window.opener.document.".$VolverPopup.".action=\"".$VolverPag."?AdmCtto=".$Rut."\";";
				else
					echo " window.opener.document.".$VolverPopup.".action=\"".$VolverPag."?Opc=".$Opc01."&TxtContrato=".$TxtContrato01."&TxtDescripcion=".$TxtDescripcion01."&TxtMontoCtto=".$TxtMontoCtto01."&TxtAreaTrabajo=".$TxtAreaTrabajo01."&TxtFechaInicio=".$TxtFechaInicio01."&TxtFechaTermino=".$TxtFechaTermino01."&CmbTipoCtto=".$CmbTipoCtto01."&CmbAdmCtto2=".$CmbAdmCtto01."&TxtFechaSolp=".$TxtFechaSolp01."&CmbAdmContratista2=".$CmbAdmContratista01."&CmbCargo=".$CmbCargo01."&Opcion=".$Opcion01."&TxtFechaGarantia=".$TxtFechaGarantia01."&CmbEmpresa=".$CmbEmpresa01."&CmbMoneda=".$CmbMoneda01."&CmbPrevencionista=".$CmbPrevencionista01."&CmbTipoCttoPers=".$CmbTipoCttoPers01."&Opcion=".$Opcion01."\";";
				echo " window.opener.document.".$VolverPopup.".submit();";		
				echo " window.close();</script>";
			}	
		break;
		case "E":
			$Rut=$TxtRutPrv."-".$TxtDv;
			if($Opc01=='A')
			{
				$tb=" sget_administrador_contratos ";
				$pk=" rut_adm_contrato  ";
				$CmbAdmCtto01=$Rut;
			}
			if($Opc01=='B')
			{
				$tb=" sget_administrador_contratistas ";
				$pk=" rut_adm_contratista ";
				$CmbAdmContratista01=$Rut;
			}
			$Eliminar="delete from $tb where $pk='".$Rut."'";
			mysql_query($Eliminar);
			echo "<script languaje='JavaScript'>";
			if($Volver=='R')	
				echo " window.opener.document.".$VolverPopup.".action=\"".$VolverPag."?AdmCtto=".$Rut."\";";
			else
				echo " window.opener.document.".$VolverPopup.".action=\"".$VolverPag."?Opc=".$Opc01."&TxtContrato=".$TxtContrato01."&TxtDescripcion=".$TxtDescripcion01."&TxtMontoCtto=".$TxtMontoCtto01."&TxtAreaTrabajo=".$TxtAreaTrabajo01."&TxtFechaInicio=".$TxtFechaInicio01."&TxtFechaTermino=".$TxtFechaTermino01."&CmbTipoCtto=".$CmbTipoCtto01."&CmbAdmCtto2=".$CmbAdmCtto01."&TxtFechaSolp=".$TxtFechaSolp01."&CmbAdmContratista2=".$CmbAdmContratista01."&CmbCargo=".$CmbCargo01."&Opcion=".$Opcion01."&TxtFechaGarantia=".$TxtFechaGarantia01."&CmbEmpresa=".$CmbEmpresa01."&CmbMoneda=".$CmbMoneda01."&CmbPrevencionista=".$CmbPrevencionista01."&CmbTipoCttoPers=".$CmbTipoCttoPers01."&Opcion=".$Opcion01."\";";
			echo " window.opener.document.".$VolverPopup.".submit();";		
			echo " window.close();</script>";		

		break;
	}
?>
