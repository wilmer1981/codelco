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
							case "�":
							case "�":
							case "�":
							case "�":
							case "�":
							case "�":
							case "�":
							case "�":
							case "�":
								$Acento=true;
							break;
						}
					}
					if($Acento==false)
					{
							$NombreArchivo=$Proceso.str_pad($CmbTipoDoc,3,0,STR_PAD_LEFT).str_pad($ID,7,0,STR_PAD_LEFT)."_".$Archivo_name;
							if (copy($Archivo, $Directorio."/".$NombreArchivo))
							{
								
								$Insertar="INSERT INTO sget_documentos(fecha_hora,cod_referencia,num_hoja_ruta,";
								$Insertar.="cod_tipo_doc,observacion,nombre_archivo) values(";
								$Insertar.="'$FechaHora','$Proceso','$ID','$CmbTipoDoc',";
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
			header('location:sget_atach.php?Formulario='.$Formulario.'&Pagina='.$Pagina.'&Proceso='.$Proceso."&ID=".$ID."&Mensaje=".$Mensaje."&TipoVolver=".$TipoVolver."&CodEstO=".$CodEstO."&NumReq=".$ID."&Acento=".$Acento);
			break;
	}
	
?>
