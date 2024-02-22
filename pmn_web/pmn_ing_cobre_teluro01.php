<?php
	include("../principal/conectar_pmn_web.php");

	$PesoTe=str_replace('.','',$PesoTe);	
	$PesoTe=str_replace(',','.',$PesoTe);	
	$PesoTeB=str_replace('.','',$PesoTeB);	
	$PesoTeB=str_replace(',','.',$PesoTeB);	
	if($Tipo=='P')
		$Fecha=$AnoTe."-".$MesTe."-".$DiaTe." ".date('H:i:s');
	else
		$Fecha=$AnoTeB."-".$MesTeB."-".$DiaTeB." ".date('H:i:s');	
	switch($Opcion)
	{
		case "N":
			if($Tipo=='P')
			{
				$Inserta="INSERT INTO pmn_web.cobre_teluro (fechaHora,turno,operador,n_lixiviacion,peso,tipo) values('".$Fecha."','".$TurnoTe."','".$OperadorTe."','".$LixiviacionP."','".$PesoTe."','".$Tipo."')";
				//echo $Inserta."<br>";
				mysqli_query($link, $Inserta);
			}
			else
			{
				$Inserta="INSERT INTO pmn_web.cobre_teluro (fechaHora,turno,operador,n_lixiviacion,peso,tipo) values('".$Fecha."','".$TurnoTeB."','".$OperadorTeB."','0','".$PesoTeB."','".$Tipo."')";
				//echo $Inserta."<br>";
				mysqli_query($link, $Inserta);
			}
			header('location:pmn_principal_reportes.php?MsjTe=1&Tab14=true');
		break;
		case "M":
			if($Tipo=='P')
			{
				$Actualiza="UPDATE pmn_web.cobre_teluro set peso='".$PesoTe."',turno='".$TurnoTe."',operador='".$OperadorTe."' where correlativo='".$CorrCT."'";
				mysqli_query($link, $Actualiza);
			}
			else
			{
				$Actualiza="UPDATE pmn_web.cobre_teluro set peso='".$PesoTeB."',turno='".$TurnoTeB."',operador='".$OperadorTeB."' where correlativo='".$CorrCT."'";
				mysqli_query($link, $Actualiza);
			}
			header('location:pmn_principal_reportes.php?MsjTe=2&Tab14=true');
		break;
		case "E":
			$Eliminar="delete from pmn_web.cobre_teluro where correlativo='".$CorrCT."'";
			mysqli_query($link, $Eliminar);
			header('location:pmn_principal_reportes.php?MsjTe=3&Tab14=true');
		break;
	}
?>