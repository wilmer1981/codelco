<?php 	
	include("../principal/conectar_principal.php");
	$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$TxtCodPuerto = isset($_REQUEST["TxtCodPuerto"])?$_REQUEST["TxtCodPuerto"]:"";
	$TxtNomPuerto = isset($_REQUEST["TxtNomPuerto"])?$_REQUEST["TxtNomPuerto"]:"";
	$TxtCodTransp = isset($_REQUEST["TxtCodTransp"])?$_REQUEST["TxtCodTransp"]:"";
	$TxtCodPtoCentral = isset($_REQUEST["TxtCodPtoCentral"])?$_REQUEST["TxtCodPtoCentral"]:"";
	$TxtCodCiudad = isset($_REQUEST["TxtCodCiudad"])?$_REQUEST["TxtCodCiudad"]:"";
	$TxtCodPais = isset($_REQUEST["TxtCodPais"])?$_REQUEST["TxtCodPais"]:"";
	$TxtEta     = isset($_REQUEST["TxtEta"])?$_REQUEST["TxtEta"]:"";
	$valido=0;
	if(strlen($TxtCodPuerto)<=3){
	 $valido=1;
	}

	switch($Proceso)
	{
		case "G":
				$Consulta = "SELECT * FROM sec_web.puertos WHERE cod_puerto = '".$TxtCodPuerto."'";
				$Result     = mysqli_query($link, $Consulta);
				$row_cnt = $Result->num_rows;
				if($row_cnt == 0 && $valido==1){	// si no existe cliente	
					$Insertar="insert into sec_web.puertos(cod_puerto,nom_aero_puerto,cod_v_transp,cod_puerto_central,cod_ciudad,cod_pais,eta_programada) values (";
					$Insertar.="'".strtoupper($TxtCodPuerto)."','".strtoupper($TxtNomPuerto)."','$TxtCodTransp','$TxtCodPtoCentral','$TxtCodCiudad','$TxtCodPais','$TxtEta')";
					//echo $Insertar;
					mysqli_query($link, $Insertar);
				}
			header('location:sec_programa_loteo_puerto.php?Buscar=S&CmbPtoDestino='.strtoupper($TxtCodPuerto));
			break;
		case "M":
			$Actualizar="UPDATE sec_web.puertos set nom_aero_puerto='".strtoupper($TxtNomPuerto)."',cod_v_transp='$TxtCodTransp',cod_puerto_central='$TxtCodPtoCentral',";
			$Actualizar.="cod_ciudad='$TxtCodCiudad',cod_pais='$TxtCodPais',eta_programada='$TxtEta' where cod_puerto='$TxtCodPuerto'";
			mysqli_query($link, $Actualizar);
			header('location:sec_programa_loteo_puerto.php?Buscar=S&CmbPtoDestino='.strtoupper($TxtCodPuerto));
			break;
		case "E":
			$Eliminar="delete from sec_web.puertos where cod_puerto='$TxtCodPuerto'";
			//echo $Eliminar;
			mysqli_query($link, $Eliminar);
			header('location:sec_programa_loteo_puerto.php');
			break;
	}
	
?>