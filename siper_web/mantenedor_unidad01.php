<? include('conectar_ori.php');
	$Encontro=false;
	switch($Proceso)
	{
		case "N":
			$Consulta = "SELECT ifnull(max(CUNIDAD),0) as mayor from sgrs_unidades"; 
			$Respuesta=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$Mayor=$Fila["mayor"] + 1;			
			$Inserta="INSERT INTO sgrs_unidades (CUNIDAD,NUNIDAD,AUNIDAD)";
			$Inserta.=" values('".$Mayor."','".$TxtNombre."','".$TxtAbrev."')";
			mysql_query($Inserta);
			//echo 	$Inserta;
			header("location:mantenedor_unidad.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "M":
				$Actualizar="UPDATE sgrs_unidades set NUNIDAD='".$TxtNombre."',AUNIDAD='".$TxtAbrev."' where CUNIDAD='".$Datos."' ";
				mysql_query($Actualizar);
				header("location:mantenedor_unidad.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='';
			$Datos = explode("//",$DatosUni);
			foreach($Datos as $clave => $Codigo)
			{
				$DatosRel='N';
				$Consulta="SELECT * from sgrs_cagentes where CUNIDAD='".$Codigo."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					$Eliminar="delete from sgrs_unidades where CUNIDAD='".$Codigo."'";
					mysql_query($Eliminar);
				}
				else
					$Mensaje='No se puede Eliminar Unidad, Existen Mediciones asociadas';	
			}
			header("location:mantenedor_unidad.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
