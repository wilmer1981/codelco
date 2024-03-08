<?php
	include("../principal/conectar_pac_web.php");
	
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$CmbDia = isset($_REQUEST["CmbDia"])?$_REQUEST["CmbDia"]:date("d");
	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbHora    = isset($_REQUEST["CmbHora"])?$_REQUEST["CmbHora"]:date("H");
	$CmbMinutos = isset($_REQUEST["CmbMinutos"])?$_REQUEST["CmbMinutos"]:date("i");

	$NumGuia = isset($_REQUEST["NumGuia"])?$_REQUEST["NumGuia"]:"";
	$CmbTransportista = isset($_REQUEST["CmbTransportista"])?$_REQUEST["CmbTransportista"]:"";
	$CmbPatentes = isset($_REQUEST["CmbPatentes"])?$_REQUEST["CmbPatentes"]:"";
	$TxtVolumen = isset($_REQUEST["TxtVolumen"])?$_REQUEST["TxtVolumen"]:"";
	$CmbEstanqueDestino = isset($_REQUEST["CmbEstanqueDestino"])?$_REQUEST["CmbEstanqueDestino"]:"";
	$CmbOperario = isset($_REQUEST["CmbOperario"])?$_REQUEST["CmbOperario"]:"";
	$TipoRecep = isset($_REQUEST["TipoRecep"])?$_REQUEST["TipoRecep"]:"";
	$RutF = isset($_REQUEST["RutF"])?$_REQUEST["RutF"]:"";
	$FechaHora = isset($_REQUEST["FechaHora"])?$_REQUEST["FechaHora"]:"";

	$HoraInicio=date('h:i:')."00";
	$HoraFinal=date('h:i:')."00";
	switch ($Proceso)
	{
		case "N":
			$FechaHora=$CmbAno."-".$CmbMes."-".$CmbDia." ".$CmbHora.":".$CmbMinutos.":".date('s');
			$Consulta="select * from pac_web.recepcion_camiones where num_guia='".$NumGuia."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if (!$Fila=mysqli_fetch_array($Respuesta))
			{
				$Insertar="insert into pac_web.recepcion_camiones (fecha_hora,nro_patente,rut_transportista,num_guia,volumen,cod_estanque,rut_funcionario,tipo_recepcion,tipo_movimiento) values (";
				$Insertar = $Insertar."'$FechaHora','$CmbPatentes','$CmbTransportista','$NumGuia','".str_replace(',','.',$TxtVolumen)."','$CmbEstanqueDestino','$CmbOperario','$TipoRecep',6)";
				mysqli_query($link, $Insertar);
				$Insertar="insert into pac_web.movimientos (fecha_hora,toneladas,hora_inicio,hora_final,cod_estanque_destino,rut_funcionario,tipo_movimiento) values (";
				$Insertar = $Insertar."'$FechaHora','".str_replace(',','.',$TxtVolumen)."','$HoraInicio','$HoraFinal','$CmbEstanqueDestino','$CmbOperario',6)";
				mysqli_query($link, $Insertar);
			}	
			break;
		case "M":
			switch ($TipoRecep)
			{
				case "0":
					$Modificar="UPDATE pac_web.recepcion_camiones set volumen='".str_replace(',','.',$TxtVolumen)."',cod_estanque='".$CmbEstanqueDestino."',tipo_recepcion='".$TipoRecep."',rut_funcionario='$CmbOperario' where fecha_hora='".$FechaHora."' and tipo_movimiento=6";
					mysqli_query($link, $Modificar);
					$Modificar="UPDATE pac_web.movimientos set toneladas='".str_replace(',','.',$TxtVolumen)."',hora_inicio='$HoraInicio',hora_final='$HoraFinal',cod_estanque_destino='".$CmbEstanqueDestino."',rut_funcionario='$CmbOperario' where fecha_hora='".$FechaHora."' and tipo_movimiento=6";
					mysqli_query($link, $Modificar);
					break;
				case "1":
					$Modificar="UPDATE pac_web.recepcion_camiones set nro_patente='".$CmbPatentes."',rut_transportista='".$CmbTransportista."',num_guia='".$NumGuia."',volumen='".str_replace(',','.',$TxtVolumen)."',cod_estanque='".$CmbEstanqueDestino."',tipo_recepcion='".$TipoRecep."',rut_funcionario='$CmbOperario' where fecha_hora='".$FechaHora."' and tipo_movimiento=6";
					mysqli_query($link, $Modificar);
					$Modificar="UPDATE pac_web.movimientos set toneladas='".str_replace(',','.',$TxtVolumen)."',hora_inicio='$HoraInicio',hora_final='$HoraFinal',cod_estanque_destino='".$CmbEstanqueDestino."',rut_funcionario='$CmbOperario' where fecha_hora='".$FechaHora."' and tipo_movimiento=6";
					mysqli_query($link, $Modificar);
					break;	
			}
			break;
		case "E":
			$EncontroRelacion=false;
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$FechaHora=substr($Datos,0,$i);
					$Eliminar ="delete from pac_web.recepcion_camiones where fecha_hora='".$FechaHora."' and tipo_movimiento=6";
					mysqli_query($link, $Eliminar);
					$Eliminar ="delete from pac_web.movimientos where fecha_hora='".$FechaHora."' and tipo_movimiento=6";
					mysqli_query($link, $Eliminar);
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}
	if ($Proceso=="E")
	{
		header("location:pac_ingreso_recepcion_camiones.php?EncontroRelacion=".$EncontroRelacion);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngRecepCamiones.action='pac_ingreso_recepcion_camiones.php';";
		echo "window.opener.document.FrmIngRecepCamiones.submit();";
		echo "window.close();";
		echo "</script>";	
	}	
?>