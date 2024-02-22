<?php
	include("../principal/conectar_pac_web.php");
	$RutCliente=$TxtRut."-".$TxtDv;
	$HoraInicio=$CmbHora.":".$CmbMinutos.":00";
	$HoraFinal=$CmbHoraFinal.":".$CmbMinutoFinal.":00";
	switch ($Proceso)
	{
		case "N":
			$FechaHora=$CmbAno."-".$CmbMes."-".$CmbDia." ".$CmbHora.":".$CmbMinutos.":".date('s');
			$FechaHoraTermino=$CmbAnoT."-".$CmbMesT."-".$CmbDiaT." ".$CmbHoraFinal.":".$CmbMinutosFinal.":".date('s');
			$Insertar="insert into pac_web.movimientos (fecha_hora,toneladas,volumen_m3,hora_inicio,hora_final,cod_estanque_origen,cod_estanque_destino,rut_funcionario,tipo_movimiento,fecha_hora_termino) values (";
			$Insertar = $Insertar."'$FechaHora','".str_replace(',','.',$TxtVolumen)."','".str_replace(',','.',$TxtMts)."','$HoraInicio','$HoraFinal','$CmbEstanqueOrigen','$CmbEstanqueDestino','$CmbOperario',2,'$FechaHoraTermino')";
			mysqli_query($link, $Insertar);
			break;
		case "M":
			$Modificar="UPDATE pac_web.movimientos set toneladas='".str_replace(',','.',$TxtVolumen)."',volumen_m3='".str_replace(',','.',$TxtMts)."',hora_inicio='$HoraInicio',hora_final='$HoraFinal',cod_estanque_origen='$CmbEstanqueOrigen',cod_estanque_destino='$CmbEstanqueDestino',rut_funcionario='$CmbOperario' where fecha_hora='".$FechaHora."' and tipo_movimiento=2";
			mysqli_query($link, $Modificar);
			break;
		case "E":
			$EncontroRelacion=false;
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$FechaHora=substr($Datos,0,$i);
					$Eliminar ="delete from pac_web.movimientos where fecha_hora='".$FechaHora."' and tipo_movimiento=2";
					mysqli_query($link, $Eliminar);
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}
	if ($Proceso=="E")
	{
		header("location:pac_recepcion_envio_acido_pta_acido.php?EncontroRelacion=".$EncontroRelacion);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmRecepEnvioAcido.action='pac_recepcion_envio_acido_pta_acido.php';";
		echo "window.opener.document.FrmRecepEnvioAcido.submit();";
		echo "window.close();";
		echo "</script>";	
	}	
?>