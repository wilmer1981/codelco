<?php
 include("../principal/conectar_sec_web.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
 
 	$Dia   = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
	$Mes   = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano   = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");

	$DiaIni   = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
	$MesIni   = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$AnoIni   = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");

	$DiaTer   = isset($_REQUEST["DiaTer"])?$_REQUEST["DiaTer"]:date("d");
	$MesTer   = isset($_REQUEST["MesTer"])?$_REQUEST["MesTer"]:date("m");
	$AnoTer   = isset($_REQUEST["AnoTer"])?$_REQUEST["AnoTer"]:date("Y");
	
	$TxtContrato  = isset($_REQUEST["TxtContrato"])?$_REQUEST["TxtContrato"]:"";
	$cmbcontrato  = isset($_REQUEST["cmbcontrato"])?$_REQUEST["cmbcontrato"]:"";
	$TxtRut  = isset($_REQUEST["TxtRut"])?$_REQUEST["TxtRut"]:"";
	$estado  = isset($_REQUEST["estado"])?$_REQUEST["estado"]:"";
	$TxtNombreCont     = isset($_REQUEST["TxtNombreCont"])?$_REQUEST["TxtNombreCont"]:"";
	$cmbtransportista  = isset($_REQUEST["cmbtransportista"])?$_REQUEST["cmbtransportista"]:"";
	$TxtRepresentante  = isset($_REQUEST["TxtRepresentante"])?$_REQUEST["TxtRepresentante"]:"";
	$cmbproducto     = isset($_REQUEST["cmbproducto"])?$_REQUEST["cmbproducto"]:"";
	$cmbsubproducto  = isset($_REQUEST["cmbsubproducto"])?$_REQUEST["cmbsubproducto"]:"";
	$Contrato  = isset($_REQUEST["Contrato"])?$_REQUEST["Contrato"]:"";
	$TxtPesoVenta  = isset($_REQUEST["TxtPesoVenta"])?$_REQUEST["TxtPesoVenta"]:"";
	$Transporte  = isset($_REQUEST["Transporte"])?$_REQUEST["Transporte"]:"";
	$radio1  = isset($_REQUEST["radio1"])?$_REQUEST["radio1"]:"";
	if($TxtPesoVenta=="")
		$TxtPesoVenta  = 0;

	if($Proceso == "G")
    {

	    $Fecha = $Ano.'-'.$Mes.'-'.$Dia;
	    $FechaIni = $AnoIni.'-'.$MesIni.'-'.$DiaIni;
	    $FechaTer = $AnoTer.'-'.$MesTer.'-'.$DiaTer;
		$contrato = intval(substr($cmbcontrato,0,6));
		$subcontrato = intval(substr($cmbcontrato,6,6));
		
	 	$Consulta = "SELECT * FROM sec_web.contrato_transporte WHERE num_cont_transporte = '".$Contrato."' AND num_contrato = '".$contrato."' AND num_subcontrato = '".$subcontrato."' ";
		$rs = mysqli_query($link, $Consulta);
		//echo $Consulta;
		if($row = mysqli_fetch_array($rs))
		{		
			if($TxtRut != '')
				$Rut = $TxtRut;
			if($cmbtransportista != -1)
				$Rut = $cmbtransportista;	

			$Actualiza = "UPDATE sec_web.contrato_transporte SET";
			$Actualiza.= " num_cont_transporte = $Contrato,nombre_contrato = '$TxtNombreCont',";
			$Actualiza.= "num_contrato = $contrato,num_subcontrato = $subcontrato,peso_venta = $TxtPesoVenta,";
			$Actualiza.= "estado_peso = '$radio1',transportista = '$Rut',";
			$Actualiza.= "representante = '$TxtRepresentante',fecha_contrato = '$Fecha',";
			$Actualiza.= "fecha_ini = '$FechaIni',fecha_ter = '$FechaTer',";
			$Actualiza.= "vigente = '$estado',tipo_contrato = '$Transporte',";
			$Actualiza.= "cod_producto = '$cmbproducto',cod_subproducto = '$cmbsubproducto'";
			$Actualiza.=" WHERE num_cont_transporte = '".$Contrato."' AND num_contrato = '".$contrato."' AND num_subcontrato = '".$subcontrato."'";			
			mysqli_query($link, $Actualiza);
	//		echo $Actualiza;
		}
		else
		{
			if($TxtRut != '')
				$Rut = $TxtRut;
			if($cmbtransportista != -1)
				$Rut = $cmbtransportista;	

			$Insertar = "INSERT INTO sec_web.contrato_transporte(num_cont_transporte,nombre_contrato,";
			$Insertar.= "num_contrato,num_subcontrato,peso_venta,";
			$Insertar.= "estado_peso,transportista,";
			$Insertar.= "representante,fecha_contrato,";
			$Insertar.= "fecha_ini,fecha_ter,";
			$Insertar.= "vigente,tipo_contrato,";
			$Insertar.= "cod_producto,cod_subproducto)";
			$Insertar.= " values($Contrato,'$TxtNombreCont',";
			$Insertar.= "$contrato,$subcontrato,$TxtPesoVenta,";
			$Insertar.= "'$radio1','$Rut',";
			$Insertar.= "'$TxtRepresentante','$Fecha',";
			$Insertar.= "'$FechaIni','$FechaTer',";
			$Insertar.= "'$estado','$Transporte',";
			$Insertar.= "'$cmbproducto','$cmbsubproducto')"; 
			mysqli_query($link, $Insertar);
			
		}

  }

	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmIngCliente.action = 'sec_ingreso_transporte.php';";
	echo "window.opener.document.FrmIngCliente.submit();";
	echo "window.close();";
	echo "</script>";

?>