<?php
	include("../principal/conectar_pac_web.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$CmbDia = isset($_REQUEST["CmbDia"])?$_REQUEST["CmbDia"]:"";
	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";
	$CmbHora= isset($_REQUEST["CmbHora"])?$_REQUEST["CmbHora"]:"";
	$CmbMinutos   = isset($_REQUEST["CmbMinutos"])?$_REQUEST["CmbMinutos"]:"";

	$CmbHoraInicio = isset($_REQUEST["CmbHoraInicio"])?$_REQUEST["CmbHoraInicio"]:"";
	$CmbMinutoInicio = isset($_REQUEST["CmbMinutoInicio"])?$_REQUEST["CmbMinutoInicio"]:"";
	$CmbHoraFinal   = isset($_REQUEST["CmbHoraFinal"])?$_REQUEST["CmbHoraFinal"]:"";
	$CmbMinutoFinal = isset($_REQUEST["CmbMinutoFinal"])?$_REQUEST["CmbMinutoFinal"]:"";
	
	$CmbEstanque  = isset($_REQUEST["CmbEstanque"])?$_REQUEST["CmbEstanque"]:"";
	$TxtVolumen      = isset($_REQUEST["TxtVolumen"])?$_REQUEST["TxtVolumen"]:"";
	$CmbOperario  = isset($_REQUEST["CmbOperario"])?$_REQUEST["CmbOperario"]:"";
	$TxtMts       = isset($_REQUEST["TxtMts"])?$_REQUEST["TxtMts"]:"";
	$RutF         = isset($_REQUEST["RutF"])?$_REQUEST["RutF"]:"";
	$FechaHora    = isset($_REQUEST["FechaHora"])?$_REQUEST["FechaHora"]:"";

	//$RutCliente = $TxtRut."-".$TxtDv;
	$HoraInicio = $CmbHoraInicio.":".$CmbMinutoInicio.":00";
	$HoraFinal  = $CmbHoraFinal.":".$CmbMinutoFinal.":00";
	switch ($Proceso)
	{
		case "N":
			$FechaHora=$CmbAno."-".$CmbMes."-".$CmbDia." ".$CmbHora.":".$CmbMinutos.":".date('s');
			$Insertar="insert into pac_web.movimientos (fecha_hora,toneladas,volumen_m3,hora_inicio,hora_final,cod_estanque_origen,rut_funcionario,tipo_movimiento) values (";
			$Insertar = $Insertar."'$FechaHora','".str_replace(',','.',$TxtVolumen)."','".str_replace(',','.',$TxtMts)."','$HoraInicio','$HoraFinal','$CmbEstanque','$CmbOperario',3)";
			echo $Insertar;
			mysqli_query($link, $Insertar);
			break;
		case "M":
			$Modificar="UPDATE pac_web.movimientos set toneladas='".str_replace(',','.',$TxtVolumen)."',volumen_m3='".str_replace(',','.',$TxtMts)."',hora_inicio='$HoraInicio',hora_final='$HoraFinal',cod_estanque_origen='$CmbEstanque',rut_funcionario='$CmbOperario' where fecha_hora='".$FechaHora."' and tipo_movimiento=3";
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
					$Eliminar ="delete from pac_web.movimientos where fecha_hora='".$FechaHora."' and tipo_movimiento=3";
					mysqli_query($link, $Eliminar);
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}
	if ($Proceso=="E")
	{
		header("location:pac_ingreso_envio_despacho_acido.php?EncontroRelacion=".$EncontroRelacion);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngEnvioDespAcido.action='pac_ingreso_envio_despacho_acido.php';";
		echo "window.opener.document.FrmIngEnvioDespAcido.submit();";
		echo "window.close();";
		echo "</script>";	
	}	
?>