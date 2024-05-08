<? 
	include("conectar.php");
	switch ($Proceso)
	{
		case "G":
			if ($CodMenu=="")
			{
				$Consulta = "select max(lpad(cod_menu,3,'0')) as maximo from intranet.menus where pos_menu='0'";
				$Resp = mysql_query($Consulta);
				if ($Fila = mysql_fetch_array($Resp))
					$CodMenu=$Fila["maximo"]+1;
				else
					$CodMenu=1;
			}
			else
			{
					//ELIMINA MENU ANTERIOR
				$Eliminar = "delete from intranet.menus where pos_menu='0' and cod_menu='".$CodMenu."'";
				mysql_query($Eliminar);		
			}
			$DirFoto = "destacado";
			if (file_exists($Archivo))
			{
				if (copy($Archivo, $DirFoto."/".$Archivo_name))
					$Foto= $DirFoto."/".$Archivo_name;
				else
					$Foto= "Error de Copiado";			
			}
			else
				$Foto="";
			//INSERTA NUEVO REGISTRO
			$Insertar = "insert into intranet.menus (pos_menu, cod_menu, descripcion, link, orden, titulo, foto, texto)";
			$Insertar.= " values('0', '".$CodMenu."','".str_replace("'","",$TxtTitulo)."','".str_replace("'","",$TxtLink)."','".$TxtOrden."','P','".$Foto."','".str_replace("'","",$TxtTexto)."')";
			mysql_query($Insertar);
			//echo $Insertar;
			break;
		case "E":
			$Eliminar = "delete from intranet.menus where pos_menu='0' and cod_menu='".$Valor."'";
			mysql_query($Eliminar);			
			break;
	}
	header("location:adm_noticias.php");
?>

