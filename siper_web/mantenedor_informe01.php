<? include('conectar_ori.php');
	include('funciones/siper_funciones.php');
		$Encontro=false;
	
	switch($Proceso)
	{
		case "N":
			$Directorio='informes';
			if($archivo1_name!='none')
			{
				$Extension=explode('.',$archivo1_name);
				if(strtoupper($Extension[1])=='DOC'||strtoupper($Extension[1])=='XLS'||strtoupper($Extension[1])=='PDF'||strtoupper($Extension[1])=='JPG'||strtoupper($Extension[1])=='GIF')
				{
					$Acento=false;
					for ($j = 0;$j <= strlen($archivo1_name); $j++)
					{
						switch(substr($archivo1_name,$j,1))
						{
							case "�":
								$archivo1_name=str_replace( "�","a",$archivo1_name);
							break;
							case "�":
								$archivo1_name=str_replace( "�","A",$archivo1_name);
							break;
							case "�":
								$archivo1_name=str_replace( "�","e",$archivo1_name);
							break;
							case "�":
								$archivo1_name=str_replace( "�","E",$archivo1_name);
							break;
							case "�":
								$archivo1_name=str_replace( "�","i",$archivo1_name);
							break;
							case "�":
								$archivo1_name=str_replace( "�","I",$archivo1_name);
							break;
							case "�":
								$archivo1_name=str_replace( "�","o",$archivo1_name);
							break;
							case "�":
								$archivo1_name=str_replace( "�","O",$archivo1_name);
							break;
							case "�":
								$archivo1_name=str_replace( "�","u",$archivo1_name);
							break;
							case "�":
								$archivo1_name=str_replace( "�","U",$archivo1_name);
							break;
							case "&":
								$archivo1_name=str_replace( "&","",$archivo1_name);
							break;
							case "$":
								$archivo1_name=str_replace( "$","",$archivo1_name);
							break;
							case "#":
								$archivo1_name=str_replace( "#","",$archivo1_name);
							break;
							case "'":
								$archivo1_name=str_replace( "'","",$archivo1_name);
							break;
						}
					}
					$Nombrearchivo1=$archivo1_name;
					if (copy($archivo1, $Directorio."/".$Nombrearchivo1))
					{
						
						$Consulta = "SELECT ifnull(max(CINFORME),0) as mayor from sgrs_informes"; 
						$Respuesta=mysql_query($Consulta);
						$Fila=mysql_fetch_array($Respuesta);
						$Mayor=$Fila["mayor"] + 1;			
						$Inserta="INSERT INTO sgrs_informes (CINFORME,TNARCHIVO,FINFORME,CUSUARIO,CVINFORME)";
						$Inserta.=" values('".$Mayor."','".$Nombrearchivo1."','".date("Y-m-d G:i:s")."','".$CookieRut."','".$TxtNombre."')";
						//echo $Inserta."<br>";
						mysql_query($Inserta);
						
						
						$MensajeDoc = "Archivo Copiado Exitosamente";
					}
					else
					{
						$MensajeDoc = "FALLA al Copiar el Archivo";
					}
				}
				else
					$MensajeDoc = "Adjuntar Solo Archivos (DOC, XLS, PDF, JPG, GIF)";	
			}	
			header("location:mantenedor_informe.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$MensajeDoc);
		break;
		case "M":
			$Mensaje='';
			$Actualizar="UPDATE sgrs_informes set CVINFORME='".$TxtNombre."' where CINFORME='".$Datos."' ";
			mysql_query($Actualizar);
			header("location:mantenedor_informe.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='';
			$Datos = explode("//",$DatosUni);
			foreach($Datos as $clave => $Codigo)
			{
				$DatosRel='N';
				$Consulta="SELECT * from sgrs_medpersonales where CINFORME='".$Codigo."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$DatosRel='S';
				$Consulta="SELECT * from sgrs_medambientes where CINFORME='".$Codigo."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					$Eliminar="delete from sgrs_informes where CINFORME='".$Codigo."'";
					mysql_query($Eliminar);
				}
				else
					$Mensaje='No se puede Eliminar Informe, Existen Mediciones asociadas';	
			}
			header("location:mantenedor_informe.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
