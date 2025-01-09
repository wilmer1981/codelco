<?php include('conectar_ori.php');
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
							case "á":
								$archivo1_name=str_replace( "á","a",$archivo1_name);
							break;
							case "Á":
								$archivo1_name=str_replace( "Á","A",$archivo1_name);
							break;
							case "é":
								$archivo1_name=str_replace( "é","e",$archivo1_name);
							break;
							case "É":
								$archivo1_name=str_replace( "É","E",$archivo1_name);
							break;
							case "í":
								$archivo1_name=str_replace( "í","i",$archivo1_name);
							break;
							case "Í":
								$archivo1_name=str_replace( "Í","I",$archivo1_name);
							break;
							case "ó":
								$archivo1_name=str_replace( "ó","o",$archivo1_name);
							break;
							case "Ó":
								$archivo1_name=str_replace( "Ó","O",$archivo1_name);
							break;
							case "ú":
								$archivo1_name=str_replace( "ú","u",$archivo1_name);
							break;
							case "Ú":
								$archivo1_name=str_replace( "Ú","U",$archivo1_name);
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
						
						$Consulta = "select ifnull(max(CINFORME),0) as mayor from sgrs_informes"; 
						$Respuesta=mysqli_query($link,$Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$Mayor=$Fila[mayor] + 1;			
						$Inserta="insert into sgrs_informes (CINFORME,TNARCHIVO,FINFORME,CUSUARIO,CVINFORME)";
						$Inserta.=" values('".$Mayor."','".$Nombrearchivo1."','".date("Y-m-d G:i:s")."','".$CookieRut."','".$TxtNombre."')";
						//echo $Inserta."<br>";
						mysqli_query($link,$Inserta);
						
						
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
			$Actualizar="update sgrs_informes set CVINFORME='".$TxtNombre."' where CINFORME='".$Datos."' ";
			mysqli_query($link,$Actualizar);
			header("location:mantenedor_informe.php?Buscar=S&TxtDescripcion=".$TxtDescripcion."&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='';
			$Datos = explode("//",$DatosUni);
			while (list($clave,$Codigo)=each($Datos))
			{
				$DatosRel='N';
				$Consulta="select * from sgrs_medpersonales where CINFORME='".$Codigo."'";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))
					$DatosRel='S';
				$Consulta="select * from sgrs_medambientes where CINFORME='".$Codigo."'";
				$Resp=mysqli_query($link,$Consulta);
				if($Fila=mysqli_fetch_array($Resp))
					$DatosRel='S';
				if($DatosRel=='N')
				{
					$Eliminar="delete from sgrs_informes where CINFORME='".$Codigo."'";
					mysqli_query($link,$Eliminar);
				}
				else
					$Mensaje='No se puede Eliminar Informe, Existen Mediciones asociadas';	
			}
			header("location:mantenedor_informe.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
