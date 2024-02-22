<?php
	include("../principal/conectar_principal.php");
	if ($Proceso == "G")
	{
		$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
		$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
		if ($ChkAbierto == "S")
			$Abierto = "S";
		else	$Abierto = "N";
		$Consulta = "SELECT * from sec_web.contratos_comp_venta ";
		$Consulta.= " where cod_contrato = '".$Contrato."'";
		$Consulta.= " and cod_cliente = '".$Cliente."'";
		$Consulta.= " and ano_contrato = '".$AnoContrato."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Actualizar = "UPDATE sec_web.contratos_comp_venta set ";
			$Actualizar.= " cod_pais = '".$Pais."', ";
			$Actualizar.= " fecha_inicio = '".$FechaInicio."', ";
			$Actualizar.= " fecha_termino = '".$FechaTermino."', ";
			$Actualizar.= " abierto = '".$Abierto."',";
			$Actualizar.= " peso = '".$Peso."',";
			$Actualizar.= " cuotas = '".$Cuotas."',";
			$Actualizar.= " estado = '".$Estado."',";
			$Actualizar.= " observacion = '".$Observacion."'";			
			$Actualizar.= " where cod_contrato = '".$Contrato."'";
			$Actualizar.= " and cod_cliente = '".$Cliente."'";
			$Actualizar.= " and ano_contrato = '".$AnoContrato."'";
			mysqli_query($link, $Actualizar);
		}
		else
		{
			$Insertar = "INSERT INTO sec_web.contratos_comp_venta (cod_contrato, cod_cliente, ano_contrato, cod_pais, ";
			$Insertar.= " fecha_inicio, fecha_termino, abierto, peso, cuotas, observacion) VALUES ";
			$Insertar.= "('".strtoupper($Contrato)."', '".$Cliente."', '".$AnoContrato."', '".$Pais."', '".$FechaInicio."', ";
			$Insertar.= " '".$FechaTermino."', '".$Abierto."', '".$Peso."', '".$Cuotas."', '".$Observacion."')";
			mysqli_query($link, $Insertar);
		}		
		header("location:sec_contrato.php?CodPais=".$Pais."&CodContrato=".$Contrato."&CodCliente=".$Cliente."&AnoContrato=".$AnoContrato);		
	}
	if ($Proceso == "E")
	{
		$Eliminar = "delete from sec_web.contratos_comp_venta ";
		$Eliminar.= " where cod_contrato = '".$Contrato."'";
		$Eliminar.= " and cod_cliente = '".$Cliente."'";
		$Eliminar.= " and ano_contrato = '".$AnoContrato."'";
		mysqli_query($link, $Eliminar);
		echo "<script languaje='JavaScript'> ";
		echo "window.opener.document.frmPrincipal.action = 'sec_compromiso_venta.php'; ";
		echo "window.opener.document.frmPrincipal.submit(); ";
		echo "window.close();";
		echo "</script> ";
	}
?>