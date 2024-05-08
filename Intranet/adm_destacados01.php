<? 
	include("conectar.php");
	switch ($Proceso)
	{
		case "G":
			$Insertar = "insert into intranet.mensajes (fecha, mensaje, link)";
			$Insertar.= " values('".date("Y-m-d H:i:s")."','".str_replace("'",'"',$TxtMensaje)."','".str_replace("'",'"',$TxtLink)."')";
			mysql_query($Insertar);
			break;
		case "E":
			$Eliminar = "delete from intranet.mensajes where fecha='".$Valor."'";
			mysql_query($Eliminar);			
			break;
	}
	header("location:adm_destacados.php");
?>

