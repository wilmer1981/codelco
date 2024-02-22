<? include('conectar_ori.php');
	$Encontro=false;
	
	
	switch($Proceso)
	{
		case "N":
			$Consulta = "SELECT ifnull(max(CTEXAMEN),0) as mayor from sgrs_codexlaboratorio"; 
			$Respuesta=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$Mayor=$Fila["mayor"] + 1;			
			$Inserta="INSERT INTO sgrs_codexlaboratorio (CTEXAMEN,NEXAMEN,CUNIDAD,QPARAMETRO,MVIGENTE)";
			$Inserta.=" values('".$Mayor."','".$TxtNombre."','".$CmbUnidad."','".$TxtQPARAMETRO."','".$Vigente."')";
			mysql_query($Inserta);
			header("location:mantenedor_examenes.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "M":
			$Actualizar="UPDATE sgrs_codexlaboratorio set NEXAMEN='".$TxtNombre."',CUNIDAD='".$CmbUnidad."',QPARAMETRO='".$TxtQPARAMETRO."',MVIGENTE='".$Vigente."' where CTEXAMEN='".$Datos."' ";
			mysql_query($Actualizar);
			header("location:mantenedor_examenes.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='';
			$Datos = explode("//",$DatosUni);
			foreach($Datos as $clave => $Codigo)
			{
				$DatosRel='N';
				$Consulta="SELECT * from sgrs_exlaboratorio where CTEXAMEN='".$Codigo."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					$Eliminar="delete from sgrs_codexlaboratorio where CTEXAMEN='".$Codigo."'";
					mysql_query($Eliminar);
				}
				else
					$Mensaje='No se puede Eliminar Examen, Existen Examenes asociados';	
			}
			header("location:mantenedor_examenes.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
