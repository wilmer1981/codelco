<? include('conectar_ori.php');
include('funciones/siper_funciones.php');
	$Encontro=false;
	switch($Proceso)
	{
		case "N":
				$Correo=strlen($correos);
				$Inserta="INSERT INTO sgrs_acceso_organica (rut,cod_gerencias,AVISO_CORREO,AVISO_CORREO2,RUT_JEFE,RUT_EXPERTO)";
				$Inserta.=" values('".$CmbUsuarios."','".str_replace('//',',',$DatosGer)."','".trim($correos)."','".trim($correos2)."','".$CmbJefe."','".$CmbExperto."')";
				mysql_query($Inserta);
				//echo 	$Inserta;
				$NomGerencia=Contactos($DatosGer);
				$NomGerencia=substr($NomGerencia,0,strlen($NomGerencia)-2);		
				
				ObtieneUsuario($CmbUsuarios,&$NombreUser);
				$Obs="Se a Ingresado Usuario ".$NombreUser." con las siguientes Gerencias: ".$NomGerencia.".";	
				InsertaHistorico($CookieRut,'5',$Obs,'','','');//INGRESA GERENCIA
				
				header("location:acceso_organica.php?Buscar=S&TxtRut=".$Rut[0]."&Mensaje=".$Mensaje);
		break;
		case "M":
				$Rut=explode('~',$Datos);
				$correos=rtrim($correos,',');
				$Consulta="SELECT * from sgrs_acceso_organica where RUT='".$Rut[0]."'"; 
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$Geren=$Fila[COD_GERENCIAS];
					
				$NomGerencia=Contactos(str_replace(',','//',$Geren));//SOLO PARA IR A BUSCAR LOS NOMBRES DE LAS GERENCIAS
				$NomGerencia=substr($NomGerencia,0,strlen($NomGerencia)-2);		

				$Actualizar="UPDATE sgrs_acceso_organica set COD_GERENCIAS='".str_replace('//',',',$DatosGer)."',AVISO_CORREO='".$correos."',AVISO_CORREO2='".$correos2."', RUT_JEFE='".$CmbJefe."',RUT_EXPERTO='".$CmbExperto."' where rut='".$Rut[0]."' ";
				//echo $Actualizar;
				mysql_query($Actualizar);

				$NomGerencia2=Contactos($DatosGer);
				$NomGerencia2=substr($NomGerencia2,0,strlen($NomGerencia2)-2);		
				ObtieneUsuario($Rut[0],&$NombreUser);
				$Obs="El Usuario ".$NombreUser." a Modificado las Gerencias: ".$NomGerencia."";	
				$Obs2="Por Gerencia: ".$NomGerencia2.".";	
				InsertaHistorico($CookieRut,'6',$Obs,$Obs2,'','');//MODIFICA GERENCIA
				
				header("location:acceso_organica.php?Buscar=S&TxtRut=".$Rut[0]."&Mensaje=".$Mensaje);
		break;
		case "E":
			$Mensaje='N';
			$Datos = explode("//",$DatosRut);
			foreach($Datos as $clave => $Codigo)
			{
				$Rut=explode('~',$Codigo);	
				ObtieneUsuario($Rut[0],&$NombreUser);
				$Nom=$Nom.$NombreUser.", ";
				$Eliminar="delete from sgrs_acceso_organica where rut='".$Rut[0]."'";
				//echo $Eliminar."<br>";
				mysql_query($Eliminar);
			}
			$Nom=substr($Nom,0,strlen($Nom)-2);		
			$Obs="Se a(han) Eliminado el(los) siguiente(s) Usuario(s) ".$Nom.".";	
			InsertaHistorico($CookieRut,'7',$Obs,'','',$ObsEli);//MODIFICA GERENCIA
			header("location:acceso_organica.php?Buscar=S&Mensaje=".$Mensaje);
		break;
	
	}
?>
