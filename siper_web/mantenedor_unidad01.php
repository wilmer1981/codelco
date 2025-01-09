<?php include('conectar_ori.php');
	$Encontro=false;
	switch($Proceso)
	{
		case "N":
			$Consulta = "select ifnull(max(CUNIDAD),0) as mayor from sgrs_unidades"; 
			$Respuesta=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Mayor=$Fila[mayor] + 1;			
			$Inserta="insert into sgrs_unidades (CUNIDAD,NUNIDAD,AUNIDAD)";
			$Inserta.=" values('".$Mayor."','".$TxtNombre."','".$TxtAbrev."')";
			mysqli_query($link,$Inserta);
			//echo 	$Inserta;
			header("location:mantenedor_unidad.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "M":
				$Actualizar="update sgrs_unidades set NUNIDAD='".$TxtNombre."',AUNIDAD='".$TxtAbrev."' where CUNIDAD='".$Datos."' ";
				mysqli_query($link,$Actualizar);
				header("location:mantenedor_unidad.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='';
			$Datos = explode("//",$DatosUni);
			while (list($clave,$Codigo)=each($Datos))
			{
				$DatosRel='N';
				$Consulta="select * from sgrs_cagentes where CUNIDAD='".$Codigo."'";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					$Eliminar="delete from sgrs_unidades where CUNIDAD='".$Codigo."'";
					mysqli_query($link,$Eliminar);
				}
				else
					$Mensaje='No se puede Eliminar Unidad, Existen Mediciones asociadas';	
			}
			header("location:mantenedor_unidad.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
