<?php
 include("../principal/conectar_sec_web.php");
  $Fecha = $Ano.'-'.$Mes.'-'.$Dia;
  $FechaIni = $AnoIni.'-'.$MesIni.'-'.$DiaIni;
  $FechaTer = $AnoTer.'-'.$MesTer.'-'.$DiaTer;
  $FechaRen = $AnoRen.'-'.$MesRen.'-'.$DiaRen;

  if($Proceso == "G" && ($SubContrato == '' || $SubContrato == 0))
  {
		//Graba En Contrato
	 	$Consulta = "SELECT * FROM sec_web.contrato WHERE num_contrato = $Contrato";
		$rs = mysqli_query($link, $Consulta);
		if($row = mysqli_fetch_array($rs))
		{
			$Actualiza = "UPDATE sec_web.contrato SET cod_cliente = '$cmbcliente'";
			$Actualiza = $Actualiza." WHERE num_contrato = $Contrato AND num_subcontrato = 0";			
			mysqli_query($link, $Actualiza);
			//echo $Actualiza;
		}
		else
		{
			$Insertar = "INSERT INTO sec_web.contrato(num_contrato,num_subcontrato,cod_cliente)";
			$Insertar = $Insertar." values($Contrato,0,'$cmbcliente')"; 
			mysqli_query($link, $Insertar);
			//echo $Insertar;
		}

	 	$Consulta1 = "SELECT * FROM sec_web.det_contrato WHERE num_contrato = $Contrato AND num_subcontrato = 0 AND cod_producto = $cmbproducto AND cod_subproducto = $cmbsubproducto";
		$rs1 = mysqli_query($link, $Consulta1);
		if($row1 = mysqli_fetch_array($rs1))
		{
			$Actualiza = "UPDATE sec_web.det_contrato SET vigente = '$estado',nom_contrato = '$TxtNomContrato',contrato_vent = '$ContratoVent',confeccion = '$radio',peso_vendido = $TxtPesoVent, estado_vendido = '$radio1', precio_compraventa = $TxtPrecioCompVent, estado_compraventa = '$radio2',";
			$Actualiza = $Actualiza."analisis_comercial = '$AnalisisComercial', analisis_impurezas = '$AnalisisImpurezas', transporte = '$Transporte', cod_cliente = '$cmbcliente',";
			$Actualiza = $Actualiza."fecha_contrato = '$Fecha',fecha_ini = '$FechaIni',fecha_ter = '$FechaTer',fecha_ren = '$FechaRen'";
			$Actualiza = $Actualiza." WHERE num_contrato = $Contrato AND num_subcontrato = 0 AND cod_producto = $cmbproducto AND cod_subproducto = $cmbsubproducto";			
			mysqli_query($link, $Actualiza);
		}
		else
		{
			$Insertar = "INSERT INTO sec_web.det_contrato(fecha_contrato,fecha_ini,fecha_ter,fecha_ren,num_contrato,contrato_vent,num_subcontrato,nom_contrato,cod_producto,cod_subproducto,peso_vendido,estado_vendido,precio_compraventa,estado_compraventa,analisis_comercial,analisis_impurezas,confeccion,transporte,cod_cliente,vigente)";
			$Insertar = $Insertar." values('$Fecha','$FechaIni','$FechaTer','$FechaRen',$Contrato,'$ContratoVent',0,'$TxtNomContrato',$cmbproducto,$cmbsubproducto,$TxtPesoVent,'$radio1',$TxtPrecioCompVent,'$radio2','$AnalisisComercial','$AnalisisImpurezas','$radio','$Transporte','$cmbcliente','$estado')"; 
			mysqli_query($link, $Insertar);
			//echo $Insertar;			
		}

  }


	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmIngCliente.action = 'sec_ingreso_contrato_clientes.php';";
	echo "window.opener.document.FrmIngCliente.submit();";
	echo "window.close();";
	echo "</script>";

?>