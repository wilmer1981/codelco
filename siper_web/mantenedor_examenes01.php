<?php include('conectar_ori.php');
	$Encontro=false;
	
	
	switch($Proceso)
	{
		case "N":
			$Consulta = "select ifnull(max(CTEXAMEN),0) as mayor from sgrs_codexlaboratorio"; 
			$Respuesta=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Mayor=$Fila[mayor] + 1;			
			$Inserta="insert into sgrs_codexlaboratorio (CTEXAMEN,NEXAMEN,CUNIDAD,QPARAMETRO,MVIGENTE)";
			$Inserta.=" values('".$Mayor."','".$TxtNombre."','".$CmbUnidad."','".$TxtQPARAMETRO."','".$Vigente."')";
			mysqli_query($link,$Inserta);
			header("location:mantenedor_examenes.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "M":
			$Actualizar="update sgrs_codexlaboratorio set NEXAMEN='".$TxtNombre."',CUNIDAD='".$CmbUnidad."',QPARAMETRO='".$TxtQPARAMETRO."',MVIGENTE='".$Vigente."' where CTEXAMEN='".$Datos."' ";
			mysqli_query($link,$Actualizar);
			header("location:mantenedor_examenes.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='';
			$Datos = explode("//",$DatosUni);
			while (list($clave,$Codigo)=each($Datos))
			{
				$DatosRel='N';
				$Consulta="select * from sgrs_exlaboratorio where CTEXAMEN='".$Codigo."'";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					$Eliminar="delete from sgrs_codexlaboratorio where CTEXAMEN='".$Codigo."'";
					mysqli_query($link,$Eliminar);
				}
				else
					$Mensaje='No se puede Eliminar Examen, Existen Examenes asociados';	
			}
			header("location:mantenedor_examenes.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
