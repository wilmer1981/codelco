<?php include('conectar_ori.php');
	$Encontro=false;
	
	
	switch($Proceso)
	{
		case "N":
			$Consulta = "select ifnull(max(COCUPACION),0) as mayor from sgrs_ocupaciones"; 
			$Respuesta=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Mayor=$Fila[mayor] + 1;			
			$Inserta="insert into sgrs_ocupaciones (COCUPACION,NOCUPACION,MVIGENTE)";
			$Inserta.=" values('".$Mayor."','".$TxtNombre."','".$Vigente."')";
			mysqli_query($link,$Inserta);
			header("location:mantenedor_ocupaciones.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "M":
			$Actualizar="update sgrs_ocupaciones set NOCUPACION='".$TxtNombre."',MVIGENTE='".$Vigente."' where COCUPACION='".$Datos."' ";
			mysqli_query($link,$Actualizar);
			header("location:mantenedor_ocupaciones.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='';
			$Datos = explode("//",$DatosUni);
			while (list($clave,$Codigo)=each($Datos))
			{
				$DatosRel='N';
				$Consulta="select * from sgrs_medpersonales where COCUPACION='".$Codigo."'";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					$Eliminar="delete from sgrs_ocupaciones where COCUPACION='".$Codigo."'";
					mysqli_query($link,$Eliminar);
				}
				else
					$Mensaje='No se puede Eliminar Ocupacion, Existen Datos asociados';	
			}
			header("location:mantenedor_ocupaciones.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
