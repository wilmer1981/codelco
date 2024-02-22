<?php
	include("../principal/conectar_sec_web.php");
	$Proceso = $_REQUEST["Proceso"];
	$CmbDias = $_REQUEST["CmbDias"];
	$CmbMes = $_REQUEST["CmbMes"];
	$CmbAno = $_REQUEST["CmbAno"];
	$TxtNroLoteo = $_REQUEST["TxtNroLoteo"];
	$TxtDescripcion = $_REQUEST["TxtDescripcion"];
	$Valores = $_REQUEST["Valores"];

	switch ($Proceso)
	{
		case "N":
			$FechaMaxima=$CmbAno."-".$CmbMes."-".$CmbDias;
			$Insertar="insert into sec_web.programa_loteo(num_prog_loteo,fecha_hora,fecha_maxima,estado,descripcion) values (";
			$Insertar = $Insertar.$TxtNroLoteo.",'";
			$Insertar = $Insertar.date('Y-m-d h:i')."','";
			$Insertar = $Insertar.$FechaMaxima."','P','$TxtDescripcion')";
			mysqli_query($link, $Insertar)."<br>";
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$IE  =$Datos2[0];
				$Tipo=$Datos2[1];
				switch ($Tipo)
				{
					case "E":
						$Actualizar="UPDATE sec_web.programa_enami set num_prog_loteo='$TxtNroLoteo',estado2='' where corr_enm=".$IE;
						mysqli_query($link, $Actualizar);
						break;
					case "C":
						$Actualizar="UPDATE sec_web.programa_codelco set num_prog_loteo='$TxtNroLoteo',estado2='' where corr_codelco=".$IE;
						mysqli_query($link, $Actualizar);
						break;
				}
			}
			break;
		case "D":
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$IE  =$Datos2[0];
				$Tipo=$Datos2[1];
				switch ($Tipo)
				{
					case "E":
						$Modificar="UPDATE sec_web.programa_enami set descripcion='".$TxtDescripcion."' where corr_enm=".$IE;
						mysqli_query($link, $Modificar);
						break;
					case "C":
						$Modificar="UPDATE sec_web.programa_enami set descripcion='".$TxtDescripcion."' where corr_enm=".$IE;
						mysqli_query($link, $Modificar);
						break;
				}
			}
			break;	
		case "M":
			if (strlen($CmbMes)==1)
			{
				$CmbMes="0".$CmbMes;
			}
			if (strlen($CmbDias)==1)
			{
				$CmbDias="0".$CmbDias;
			}
			$FechaPreeEmbarque = $CmbAno."-".$CmbMes."-".$CmbDias;
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$IE=$Datos2[0];
				$Tipo=$Datos2[1];
				switch ($Tipo)
				{
					case "E"://PROGRAMA ENAMI
						$Consulta="select eta_programada from sec_web.programa_enami where corr_enm=".$IE;
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						if (date($Fila["eta_programada"])>=date($FechaPreeEmbarque))
						{
							$Modificar = "UPDATE sec_web.programa_enami set ";
							$Modificar.= " fecha_disponible='".$FechaPreeEmbarque."' ";
							$Modificar.= " ,estado2='' ";
							$Modificar.= " ,modif_usuario='S' ";
							$Modificar.= " where corr_enm=".$IE;
							mysqli_query($link, $Modificar);
						}
						else
						{
							$Mensaje='Una o Mas Fechas de Preembarque no fueron Modificadas por ser mayor a Fecha Programada';
						}
						break;
					case "C"://PROGRAMA CODELCO
						$Consulta="select fecha_programacion from sec_web.programa_codelco where corr_codelco=".$IE;
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						if ($Fila["fecha_programacion"]>=$FechaPreeEmbarque)
						{
							$Modificar = "UPDATE sec_web.programa_codelco set ";
							$Modificar.= " fecha_disponible='".$FechaPreeEmbarque."'";
							$Modificar.= " ,estado2='' ";
							$Modificar.= " ,modif_usuario='S' ";
							$Modificar.= " where corr_codelco=".$IE;
							mysqli_query($link, $Modificar);
						}
						else
						{
							$Mensaje='Una o Mas Fechas de Preembarque no fueron Modificadas por ser mayor a Fecha Programada';
						}
						break;
				}				
			}	
			break;
		case "A":
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$IE=$Datos2[0];
				$Tipo=$Datos2[1];
				switch ($Tipo)
				{
					case "E":
						$Actualizar="UPDATE sec_web.programa_enami set estado2='A' where corr_enm=".$IE;
						mysqli_query($link, $Actualizar);
						break;
					case "C":
						$Actualizar="UPDATE sec_web.programa_codelco set estado2='A' where corr_codelco=".$IE;
						mysqli_query($link, $Actualizar);
						break;
				}
			}
			break;

	case "ACT":
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$IE=$Datos2[0];
				$Tipo=$Datos2[1];
				switch ($Tipo)
				{
					case "E":
						$Actualizar="UPDATE sec_web.programa_enami set estado2='', num_prog_loteo='0' where corr_enm=".$IE;
					//	echo $Actualizar."<br>";
						 mysqli_query($link, $Actualizar);
						break;
					case "C":
						$Actualizar="UPDATE sec_web.programa_codelco set estado2= '', num_prog_loteo='0' where corr_codelco=".$IE;
					//	echo $Actualizar."<br>";
					mysqli_query($link, $Actualizar);
						break;
				}
			}
			break;



		case "MC":
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$IE=$Datos2[0];
				$Tipo=$Datos2[1];
				$Contrato=strtoupper(trim($Datos2[2]));
				$Cuota=$Datos2[3];
				$PuertoEmb=$Datos2[4];
				$PuertoDest=$Datos2[5];
				switch ($Tipo)
				{
					case "E":
						$Actualizar="UPDATE sec_web.programa_enami set ";
						$Actualizar.= " cod_contrato='".$Contrato."', mes_cuota='".$Cuota."' ";
						$Actualizar.= " ,cod_puerto='".$PuertoEmb."'";
						$Actualizar.= " ,cod_puerto_destino='".$PuertoDest."'";
						$Actualizar.= " where corr_enm=".$IE;
						mysqli_query($link, $Actualizar);
						break;
					case "C":
						$Actualizar="UPDATE sec_web.programa_codelco set ";
						$Actualizar.= " cod_contrato='".$Contrato."', mes_cuota='".$Cuota."' ";
						$Actualizar.= " ,cod_puerto='".$PuertoEmb."'";
						$Actualizar.= " ,cod_puerto_destino='".$PuertoDest."'";						
						$Actualizar.= " where corr_codelco=".$IE;
						mysqli_query($link, $Actualizar);
						break;					
				}
			}
			break;	
	}
	switch ($Proceso)
	{
		case "D":
			$ValorCheck=$Valores."//";
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProgLoteo.action='sec_programa_loteo.php?ValorCheck=".$Valores."';";
			echo "window.opener.document.FrmProgLoteo.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "M":
			echo "<script languaje='JavaScript'>";
			$ValorCheck=$ValorCheck."//";
			if (isset($Mensaje))
			{
				echo "window.opener.document.FrmProgLoteo.action='sec_programa_loteo.php?CmbAno=".$CmbAnoMax."&CmbMes=".$CmbMesMax."&CmbDias=".$CmbDiasMax."&Mensaje=".$Mensaje."&ValorCheck=".$ValorCheck."';";
			}
			else
			{
				echo "window.opener.document.FrmProgLoteo.action='sec_programa_loteo.php?CmbAno=".$CmbAnoMax."&CmbMes=".$CmbMesMax."&CmbDias=".$CmbDiasMax."&ValorCheck=".$ValorCheck."';";
			}
			echo "window.opener.document.FrmProgLoteo.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "N":	
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProgLoteo.action='sec_programa_loteo.php';";
			echo "window.opener.document.FrmProgLoteo.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "A":	
			header('location:sec_programa_loteo.php?Programa=A');
			break;
case "ACT":	
			header('location:sec_programa_loteo.php?Programa=A');
			break;
		case "MC":
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProgLoteo.action = 'sec_programa_loteo.php';";
			echo "window.opener.document.FrmProgLoteo.submit();";
			echo "window.close();";
			echo "</script>";
			break;
	}		
?>