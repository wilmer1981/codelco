<? 
	include("../principal/conectar_sget_web.php");
	$Rut=$CookieRut;
	switch($Opt)
	{
		case "G":
			$Seg=date("s");
			$FechaHora = $TxtFecha.' '.$HoraI.':'.$MinutosI.':'.$Seg;	
			if($Archivo_name!='none')
			{
				$Extension=explode('.',$Archivo_name);
				if(strtoupper($Extension[1])!='EXE'&&strtoupper($Extension[1])!='ZIP'&&strtoupper($Extension[1])!='RAR')
				{
					$Directorio='doc';
					//echo "nom".$Archivo_name."<br>";
					$Acento=false;
					for ($j = 0;$j <= strlen($Archivo_name); $j++)
					{
						switch(substr($Archivo_name,$j,1))
						{
							case "�":
								$Archivo_name=str_replace( "�","a",$Archivo_name);
							break;
							case "�":
								$Archivo_name=str_replace( "�","A",$Archivo_name);
							break;
							case "�":
								$Archivo_name=str_replace( "�","e",$Archivo_name);
							break;
							case "�":
								$Archivo_name=str_replace( "�","E",$Archivo_name);
							break;
							case "�":
								$Archivo_name=str_replace( "�","i",$Archivo_name);
							break;
							case "�":
								$Archivo_name=str_replace( "�","I",$Archivo_name);
							break;
							case "�":
								$Archivo_name=str_replace( "�","o",$Archivo_name);
							break;
							case "�":
								$Archivo_name=str_replace( "�","O",$Archivo_name);
							break;
							case "�":
								$Archivo_name=str_replace( "�","u",$Archivo_name);
							break;
							case "�":
								$Archivo_name=str_replace( "�","U",$Archivo_name);
							break;
							case "&":
								$Archivo_name=str_replace( "&","",$Archivo_name);
							break;
							case "$":
								$Archivo_name=str_replace( "$","",$Archivo_name);
							break;
							case "#":
								$Archivo_name=str_replace( "#","",$Archivo_name);
							break;
							case "'":
								$Archivo_name=str_replace( "'","",$Archivo_name);
							break;
						}
					}
					if($Acento==false)
					{
							$NombreArchivo="C".str_pad($CmbTipoDoc,3,0,STR_PAD_LEFT).str_pad($ID,7,0,STR_PAD_LEFT)."_".$Archivo_name;
							if (copy($Archivo, $Directorio."/".$NombreArchivo))
							{
								
								$Insertar="INSERT INTO sget_documentos(fecha_hora,cod_referencia,num_hoja_ruta,";
								$Insertar.="cod_tipo_doc,observacion,nombre_archivo) values(";
								$Insertar.="'$FechaHora','C','".$CmbContrato."','$CmbTipoDoc',";
								$Insertar.="'$TxtObservacion','$NombreArchivo')";
								mysql_query($Insertar);
								/*echo $Insertar;*/
								$Mensaje = "Archivo Copiado Exitosamente";
							}
							else
								$Mensaje = "FALLA al Copiar el Archivo";
						}
					}
				
				}	
			header('location:sget_doc_contrato.php?Formulario='.$Formulario.'&Pagina='.$Pagina.'&Proceso='.$Proceso."&CmbContrato=".$CmbContrato."&Mensaje=".$Mensaje."&TipoVolver=".$TipoVolver."&CodEstO=".$CodEstO."&NumReq=".$ID."&Acento=".$Acento);
			break;
	}
	
?>
