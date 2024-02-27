<?php
 include("../principal/conectar_sec_web.php");
 $Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";

 $Dia   = $_REQUEST["Dia"];
 $Mes   = $_REQUEST["Mes"];
 $Ano   = $_REQUEST["Ano"];
 $DiaIni   = $_REQUEST["DiaIni"];
 $MesIni   = $_REQUEST["MesIni"];
 $AnoIni   = $_REQUEST["AnoIni"];
 $DiaTer   = $_REQUEST["DiaTer"];
 $MesTer   = $_REQUEST["MesTer"];
 $AnoTer   = $_REQUEST["AnoTer"];
 $DiaRen   = $_REQUEST["DiaRen"];
 $MesRen   = $_REQUEST["MesRen"];
 $AnoRen   = $_REQUEST["AnoRen"];

$Contrato    = $_REQUEST["Contrato"];
$SubContrato   = isset($_REQUEST["SubContrato"])?$_REQUEST["SubContrato"]:"";
$TxtPrecioCompVent = $_REQUEST["TxtPrecioCompVent"];
$cmbcliente     = $_REQUEST["cmbcliente"];
$cmbproducto    = $_REQUEST["cmbproducto"];
$cmbsubproducto = $_REQUEST["cmbsubproducto"];
$ContratoVent   = $_REQUEST["ContratoVent"];
$TxtNomContrato   = $_REQUEST["TxtNomContrato"];
$estado   = $_REQUEST["estado"];
$TxtPesoVent  = $_REQUEST["TxtPesoVent"];

/*
$radio   = $_REQUEST["radio"];
$radio1   = $_REQUEST["radio1"];
$radio2   = $_REQUEST["radio2"];
$Transporte   = $_REQUEST["Transporte"];
$AnalisisComercial   = $_REQUEST["AnalisisComercial"];
$AnalisisImpurezas   = $_REQUEST["AnalisisImpurezas"];
*/

  $Fecha = $Ano.'-'.$Mes.'-'.$Dia;
  $FechaIni = $AnoIni.'-'.$MesIni.'-'.$DiaIni;
  $FechaTer = $AnoTer.'-'.$MesTer.'-'.$DiaTer;
  $FechaRen = $AnoRen.'-'.$MesRen.'-'.$DiaRen;

   if($Proceso == "G" && ($SubContrato != '' || $SubContrato != 0))
  {
		//Graba En Contrato
	 	$Consulta = "SELECT * FROM sec_web.contrato WHERE num_contrato = '".$Contrato."' AND num_subcontrato = '".$SubContrato."'";
		$rs = mysqli_query($link, $Consulta);
		if($row = mysqli_fetch_array($rs))
		{
			$Actualiza = "UPDATE sec_web.contrato SET cod_cliente = '$cmbcliente'";
			$Actualiza = $Actualiza." WHERE num_contrato = $Contrato AND num_subcontrato = '".$SubContrato."'";			
			mysqli_query($link, $Actualiza);
		}
		else
		{
			$Insertar = "INSERT INTO sec_web.contrato(num_contrato,num_subcontrato,cod_cliente)";
			$Insertar = $Insertar." values($Contrato,$SubContrato,'$cmbcliente')"; 
			mysqli_query($link, $Insertar);
		}

	 	$Consulta1 = "SELECT * FROM sec_web.det_contrato WHERE num_contrato = '".$Contrato."' AND num_subcontrato = '".$SubContrato."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$rs1 = mysqli_query($link, $Consulta1);
		if($row1 = mysqli_fetch_array($rs1))
		{
			$Actualiza = "UPDATE sec_web.det_contrato SET vigente = '$estado',nom_contrato = '$TxtNomContrato',contrato_vent = '$ContratoVent',peso_vendido ='$TxtPesoVent',precio_compraventa = '$TxtPrecioCompVent',";
			$Actualiza = $Actualiza."fecha_contrato = '$Fecha',fecha_ini = '$FechaIni',fecha_ter = '$FechaTer',fecha_ren = '$FechaRen'";
			$Actualiza = $Actualiza." WHERE num_contrato = '".$Contrato."' AND num_subcontrato = '".$SubContrato."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";			
			mysqli_query($link, $Actualiza);
		}
		else
		{
			$Consulta="SELECT * FROM sec_web.det_contrato WHERE num_contrato = '".$Contrato."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$radio1 = $Fila["estado_vendido"];
			$radio2 = $Fila["estado_compraventa"];
			$AnalisisComercial = $Fila["analisis_comercial"];
			$AnalisisImpurezas = $Fila["analisis_impurezas"];
			$radio = $Fila["confeccion"];
			$Transporte = $Fila["transporte"];


			$Insertar = "INSERT INTO sec_web.det_contrato(fecha_contrato,fecha_ini,fecha_ter,fecha_ren,num_contrato,contrato_vent,num_subcontrato,nom_contrato,cod_producto,cod_subproducto,peso_vendido,estado_vendido,precio_compraventa,estado_compraventa,analisis_comercial,analisis_impurezas,confeccion,transporte,cod_cliente,vigente)";
			$Insertar = $Insertar." values('$Fecha','$FechaIni','$FechaTer','$FechaRen','$Contrato','$ContratoVent','$SubContrato','$TxtNomContrato',$cmbproducto,$cmbsubproducto,'$TxtPesoVent','$radio1','$TxtPrecioCompVent','$radio2','$AnalisisComercial','$AnalisisImpurezas','$radio','$Transporte','$cmbcliente','$estado')"; 
			mysqli_query($link, $Insertar);

		}

  }

	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmIngCliente.action = 'sec_ingreso_contrato_clientes.php';";
	echo "window.opener.document.FrmIngCliente.submit();";
	echo "window.close();";
	echo "</script>";

?>