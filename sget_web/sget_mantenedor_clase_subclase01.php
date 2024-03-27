<? include("../principal/conectar_sget_web.php");
	
	$Encontro=false;
	
	switch($Opcion)
	{
		case "N":
			
			$Consulta = "SELECT ifnull(max(cod_clase),0) as mayor from sget_clase"; 
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$Mayor=$Fila["mayor"] + 1;			
			
			$Inserta="INSERT INTO sget_afp (cod_AFP,descripcion)";
			$Inserta.=" values('".$Mayor."','".$Descri."')";
			mysql_query($Inserta);
		
				//echo 	$Inserta;
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.FrmPrincipal.action=\"sget_mantenedor_clase_subclase.php\";";
			echo " window.opener.document.FrmPrincipal.submit();";		
			echo " window.close();</script>";
			
			
			
		break;
		case "M":
		
				
				$Actualizar="UPDATE sget_afp set descripcion='".$Descri."' ";
				$Actualizar.=" where cod_AFP='".$Codigo."'";	
				mysql_query($Actualizar);
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.FrmPrincipal.action=\"sget_mantenedor_clase_subclase.php\";";
				echo " window.opener.document.FrmPrincipal.submit();";		
				echo " window.close();</script>";
				
		break;
		
		case "E":
			$Mensaje='N';
			echo "$Eliminar";
			$Datos = explode("//",$Valor);
			foreach($Datos as $clave => $Codigo)
			{
				
				$Eliminar="delete from sget_afp where cod_AFP='".$Codigo."'";
					mysql_query($Eliminar);
				
				/*$Consulta="SELECT * from sgpt_documentos where cod_tipo_doc='".$Codigo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if(!$Fila=mysql_fetch_array($Respuesta))
				{
					$Eliminar="delete from sgpt_tipo_documento where cod_tipo_doc='".$Codigo."'";
					mysql_query($Eliminar);
					$Eliminar="delete from sgpt_hitos where cod_hito='".$Codigo."'";
					mysql_query($Eliminar);
				}
				else
				{
					$Mensaje='S';
				}	*/
			}
			header("location:sget_mantenedor_AFP.php?Pagina=".$Pagina."&Mensaje=".$Mensaje);
		break;
	
	}
?>
