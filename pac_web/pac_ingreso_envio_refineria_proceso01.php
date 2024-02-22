<?php
	include("../principal/conectar_pac_web.php");
	$RutCliente=$TxtRut."-".$TxtDv;
	$HoraInicio=$CmbHoraInicio.":".$CmbMinutoInicio.":00";
	$HoraFinal=$CmbHoraFinal.":".$CmbMinutoFinal.":00";
	switch ($Proceso)
	{
		case "N":
			$FechaHora=$CmbAno."-".$CmbMes."-".$CmbDia." ".$CmbHora.":".$CmbMinutos.":".date('s');
			$Insertar="insert into pac_web.movimientos (fecha_hora,toneladas,volumen_m3,hora_inicio,hora_final,cod_estanque_origen,rut_funcionario,tipo_movimiento) values (";
			$Insertar = $Insertar."'$FechaHora','".str_replace(",",".",$TxtVolumen)."','".str_replace(",",".",$TxtMts)."','$HoraInicio','$HoraFinal','$CmbEstanque','$CmbOperario',1)";
			mysqli_query($link, $Insertar);
			break;
		case "M":
			$Modificar="UPDATE pac_web.movimientos set toneladas='".str_replace(",",".",$TxtVolumen)."',volumen_m3='".str_replace(",",".",$TxtMts)."',hora_inicio='$HoraInicio',hora_final='$HoraFinal',cod_estanque_origen='$CmbEstanque',rut_funcionario='$CmbOperario' where fecha_hora='".$FechaHora."' and tipo_movimiento=1";
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
					$Eliminar ="delete from pac_web.movimientos where fecha_hora='".$FechaHora."' and tipo_movimiento=1";
					mysqli_query($link, $Eliminar);
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}
	if ($Proceso=="E")
	{
		header("location:pac_ingreso_envio_refineria.php?EncontroRelacion=".$EncontroRelacion);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngEnvioRef.action='pac_ingreso_envio_refineria.php';";
		echo "window.opener.document.FrmIngEnvioRef.submit();";
		echo "window.close();";
		echo "</script>";	
	}	
?>