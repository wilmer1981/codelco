<? include('conectar_ori.php');
	$Encontro=false;
	
	
	switch($Proceso)
	{
		case "N":
			$Consulta = "SELECT ifnull(max(COCUPACION),0) as mayor from sgrs_ocupaciones"; 
			$Respuesta=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$Mayor=$Fila["mayor"] + 1;			
			$Inserta="INSERT INTO sgrs_ocupaciones (COCUPACION,NOCUPACION,MVIGENTE)";
			$Inserta.=" values('".$Mayor."','".$TxtNombre."','".$Vigente."')";
			mysql_query($Inserta);
			header("location:mantenedor_ocupaciones.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "M":
			$Actualizar="UPDATE sgrs_ocupaciones set NOCUPACION='".$TxtNombre."',MVIGENTE='".$Vigente."' where COCUPACION='".$Datos."' ";
			mysql_query($Actualizar);
			header("location:mantenedor_ocupaciones.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='';
			$Datos = explode("//",$DatosUni);
			foreach($Datos as $clave => $Codigo)
			{
				$DatosRel='N';
				$Consulta="SELECT * from sgrs_medpersonales where COCUPACION='".$Codigo."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					$Eliminar="delete from sgrs_ocupaciones where COCUPACION='".$Codigo."'";
					mysql_query($Eliminar);
				}
				else
					$Mensaje='No se puede Eliminar Ocupacion, Existen Datos asociados';	
			}
			header("location:mantenedor_ocupaciones.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
