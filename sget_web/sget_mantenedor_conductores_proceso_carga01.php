<?
include("../principal/conectar_sget_web.php");

require_once 'reader.php';
$Directorio='doc';
switch($Opcion)
{
	case "Carga":
				$Elimina="delete from sget_conductores_tmp where rut_operador='".$CookieRut."'";
				mysql_query($Elimina);

				if($file_name!='none')
				{
					$Extension=explode('.',$file_name);
					if(strtoupper($Extension[1])=='XLS')
					{
						$Acento=false;
						for ($j = 0;$j <= strlen($file_name[$Cont]); $j++)
						{
							switch(substr($file_name[$Cont],$j,1))
							{
								case "�":
									$file_name=str_replace( "�","a",$file_name);
								break;
								case "�":
									$file_name=str_replace( "�","A",$file_name);
								break;
								case "�":
									$file_name=str_replace( "�","e",$file_name);
								break;
								case "�":
									$file_name=str_replace( "�","E",$file_name);
								break;
								case "�":
									$file_name=str_replace( "�","i",$file_name);
								break;
								case "�":
									$file_name=str_replace( "�","I",$file_name);
								break;
								case "�":
									$file_name=str_replace( "�","o",$file_name);
								break;
								case "�":
									$file_name=str_replace( "�","O",$file_name);
								break;
								case "�":
									$file_name=str_replace( "�","u",$file_name);
								break;
								case "�":
									$file_name=str_replace( "�","U",$file_name);
								break;
								case "&":
									$file_name=str_replace( "&","",$file_name);
								break;
								case "$":
									$file_name=str_replace( "$","",$file_name);
								break;
								case "#":
									$file_name=str_replace( "#","",$file_name);
								break;
								case "'":
									$file_name=str_replace( "'","",$file_name);
								break;		
							}
						}
						if($Acento==false)
						{
							$NombreArchivo="carga_conductores.".$Extension[1];
							//echo $NombreArchivo."<br>";
							if(file_exists($Directorio.'/'.$NombreArchivo))
							{
								unlink($Directorio.'/'.$NombreArchivo);
							}	
							if (copy($file, $Directorio."/".$NombreArchivo))
							{
								$ProcesaArchivo = "S";
							}
							else
							{
								$ProcesaArchivo = "N";
							    header('location:sget_mantenedor_conductores_proceso_carga.php?Msj=NC');	
							}	
						}
					}
					else
					{
					  header('location:sget_mantenedor_conductores_proceso_carga.php?Msj=NE');	
					}	
				}	
				if($ProcesaArchivo=='S')
				{
					$data = new Spreadsheet_Excel_Reader();
					$data->read($Directorio."/".$NombreArchivo);
					error_reporting(E_ALL ^ E_NOTICE);
					$Hoja=0;$Det='N';
					//$IniCol=1;
					//$IniCol=2;
					for ($i = 2; $i <= $data->sheets[$Hoja]['numRows']; $i++) 
					{
							$TxtRut=$data->sheets[$Hoja]['cells'][$i][1];
						if(trim($TxtRut)!='')
						{
							$Nombre=trim($data->sheets[$Hoja]['cells'][$i][2]);
							$ApPate=trim($data->sheets[$Hoja]['cells'][$i][3]);
							$ApMate=trim($data->sheets[$Hoja]['cells'][$i][4]);
							$TipoVehiculo=trim($data->sheets[$Hoja]['cells'][$i][5]);
							if($TipoVehiculo=='')
								$TipoVehiculo='VL';//DEFECTO VEHICULO LIVIANO
							if($TipoVehiculo!='VL' && $TipoVehiculo!='EP')	
								$TipoVehiculo='VL';//DEFECTO VEHICULO LIVIANO
							$TipoLic5=trim($data->sheets[$Hoja]['cells'][$i][6]);
							$TipoLic6=trim($data->sheets[$Hoja]['cells'][$i][7]);
							$TipoLic7=trim($data->sheets[$Hoja]['cells'][$i][8]);
							$TipoLic8=trim($data->sheets[$Hoja]['cells'][$i][9]);
							$TxtVigMuni=explode('/',trim($data->sheets[$Hoja]['cells'][$i][10]));
							$TxtVigMuni=trim($TxtVigMuni[2]."-".$TxtVigMuni[1]."-".$TxtVigMuni[0]);
							$Restriccion=trim($data->sheets[$Hoja]['cells'][$i][11]);
							/*$FechaExaPreo=explode('/',trim($data->sheets[$Hoja]['cells'][$i][12]));
							if($FechaExaPreo[0]!='')
								$FechaExaPreo=trim($FechaExaPreo[2]."-".$FechaExaPreo[1]."-".$FechaExaPreo[0]);
							else
								$FechaExaPreo='0000-00-00';	
								
							$InstituPreo=trim($data->sheets[$Hoja]['cells'][$i][12]);*/
							$FechaPST=explode('/',trim($data->sheets[$Hoja]['cells'][$i][12]));
							if($FechaPST[0]!='')
								$FechaPST=trim($FechaPST[2]."-".$FechaPST[1]."-".$FechaPST[0]);
							else
								$FechaPST='0000-00-00';	
							
							$InstituPST=trim($data->sheets[$Hoja]['cells'][$i][13]);
							$FechaHojaVida=explode('/',$data->sheets[$Hoja]['cells'][$i][14]);
							if($FechaHojaVida[0]!='')
								$FechaHojaVida=trim($FechaHojaVida[2]."-".$FechaHojaVida[1]."-".$FechaHojaVida[0]);
							else
								$FechaHojaVida='0000-00-00';						
								
							$NumHojaVida=trim($data->sheets[$Hoja]['cells'][$i][15]);
							$FechaCurso=explode('/',trim($data->sheets[$Hoja]['cells'][$i][16]));
							if($FechaCurso[0]!='')
								$FechaCurso=trim($FechaCurso[2]."-".$FechaCurso[1]."-".$FechaCurso[0]);
							else
								$FechaCurso='0000-00-00';	
							
							$DescEmpre=trim($data->sheets[$Hoja]['cells'][$i][17]);
							$RutEmp=trim($data->sheets[$Hoja]['cells'][$i][18]);
							$NumCCtto=trim($data->sheets[$Hoja]['cells'][$i][19]);
							/*$FechaDAS=explode('/',trim($data->sheets[$Hoja]['cells'][$i][21]));
							if($FechaDAS[0]!='')
								$FechaDAS=trim($FechaDAS[2]."-".$FechaDAS[1]."-".$FechaDAS[0]);
							else
								$FechaDAS='0000-00-00';	*/
								
							//$Obs=trim($data->sheets[$Hoja]['cells'][$i][22]);
							
							//echo $Rut." ".$Nombre." ".$ApPate." ".$ApMate." ".$TipoLic." ".$VigLic." ".$Restric." ".$VigExam." ".$EmpClien." ".$FecOtor." ".$VigInte." ".$VigInte." ".$NContra." ".$NomContra." ".$CC." ".$FIni." ".$FFin." ".$Obs."<br>";
							$Consulta="SELECT ifnull(max(corr_conductor)+1,1) as maximo from sget_conductores_tmp ";
							$Resp=mysql_query($Consulta);
							if($Fila=mysql_fetch_array($Resp))
							{
								if($Fila["maximo"]=='')
									$CodConductorG=1;
								else		
									$CodConductorG=$Fila["maximo"];
							}
							if($TipoLic5!='')
							{
								$Inserta="INSERT INTO sget_conductores_licencias_tmp (corr_conductor,tipo_licencia) values('".$CodConductorG."','".strtoupper($TipoLic5)."')";
								//echo $Inserta;
								mysql_query($Inserta);
							}	
							if($TipoLic6!='')
							{
								$Inserta="INSERT INTO sget_conductores_licencias_tmp (corr_conductor,tipo_licencia) values('".$CodConductorG."','".strtoupper($TipoLic6)."')";
								//echo $Inserta;
								mysql_query($Inserta);
							}	
							if($TipoLic7!='')
							{
								$Inserta="INSERT INTO sget_conductores_licencias_tmp (corr_conductor,tipo_licencia) values('".$CodConductorG."','".strtoupper($TipoLic7)."')";
								//echo $Inserta;
								mysql_query($Inserta);
							}	
							if($TipoLic8!='')
							{
								$Inserta="INSERT INTO sget_conductores_licencias_tmp (corr_conductor,tipo_licencia) values('".$CodConductorG."','".strtoupper($TipoLic8)."')";
								//echo $Inserta;
								mysql_query($Inserta);
							}	
							$Insertar="INSERT INTO sget_conductores_tmp (corr_conductor,rut,nombres,apellido_paterno,apellido_materno,fecha_vig_licencia,restriccion_licencia,fecha_exa_pst,";
							$Insertar.=" institu_realiza_exam_pst,fecha_hoja_ruta,num_hoja_ruta,fecha_curso_manejo,rut_empresa,empresa,contrato,rut_operador,tipo_vehiculo)";
							$Insertar.=" values ('".$CodConductorG."','".$TxtRut."','".strtoupper($Nombre)."','".strtoupper($ApPate)."','".strtoupper($ApMate)."','".$TxtVigMuni."','".strtoupper($Restriccion)."','".$FechaPST."',";
							$Insertar.=" '".$InstituPST."','".$FechaHojaVida."','".$NumHojaVida."','".$FechaCurso."','".$RutEmp."','".strtoupper($DescEmpre)."','".strtoupper($NumCCtto)."','".$CookieRut."','".$TipoVehiculo."')";
							//echo "CARGA CONDUCTORES:    ".$Insertar."<br><br>";
							mysql_query($Insertar);
						}
					}					
				}	
				$Consul="SELECT corr_conductor from sget_conductores_tmp where rut_operador='".$CookieRut."'";
				$RCon=mysql_query($Consul);$Ing='NC';
				if($FCon=mysql_fetch_array($RCon))
					$Ing='S';
				header('location:sget_mantenedor_conductores_proceso_carga.php?Ing='.$Ing)	;	
	break;
	case "Carga1":
			$ConsultaTMP="SELECT * from sget_conductores_tmp ";
			$RespTMP=mysql_query($ConsultaTMP);
			while($FilaTMP=mysql_fetch_array($RespTMP))
			{
				$RutTMP=valida_rut($Filas["rut"]);
				if($FilaTMP[fecha_exa_preoc]=='')
					$FilaTMP[fecha_exa_preoc]='0000-00-00';
				if($FilaTMP[fecha_exa_pst]=='')
					$FilaTMP[fecha_exa_pst]='0000-00-00';
				if($FilaTMP[fecha_hoja_ruta]=='')
					$FilaTMP[fecha_hoja_ruta]='0000-00-00';
				if($FilaTMP[fecha_curso_manejo]=='')
					$FilaTMP[fecha_curso_manejo]='0000-00-00';
				if($FilaTMP[fecha_das_codelco]=='')
					$FilaTMP[fecha_das_codelco]='0000-00-00';
				if($RutTMP==true)//SI RUT NO ES VALIDO NO PASA PARA INSERTAR O MODIFICAR
				{
					$Consulta="SELECT * from sget_conductores where rut='".$FilaTMP["rut"]."'";
					//echo $Consulta;
					$Resp=mysql_query($Consulta);
					if($Fila=mysql_fetch_array($Resp))
					{
						$ConsultaTMPL="SELECT tipo_licencia from sget_conductores_licencias_tmp where corr_conductor='".$FilaTMP[corr_conductor]."'";
						$RespTMPL=mysql_query($ConsultaTMPL);
						while($FilaTMPL=mysql_fetch_array($RespTMPL))
						{
							$Insertar="UPDATE sget_conductores_licencias set tipo_licencia='".$FilaTMPL[tipo_licencia]."' where='".$Fila[corr_conductor]."'";
							//echo "Licencias:    ".$Insertar."<br><br>";
							mysql_query($Insertar);
						}
						$Actualiza="UPDATE sget_conductores set nombres='".strtoupper($FilaTMP["nombres"])."',apellido_paterno='".strtoupper($FilaTMP["apellido_paterno"])."',apellido_materno='".strtoupper($FilaTMP["apellido_materno"])."',tipo_licencia='".$FilaTMP[tipo_licencia]."',fecha_vig_licencia='".$FilaTMP[fecha_vig_licencia]."',restriccion_licencia='".$FilaTMP[restriccion_licencia]."',";
						$Actualiza.=" fecha_exa_preoc='".$FilaTMP[fecha_exa_preoc]."',institu_realiza_exam_preoc='".$FilaTMP[institu_realiza_exam_preoc]."',fecha_exa_pst='".$FilaTMP[fecha_exa_pst]."',";
						$Actualiza.=" institu_realiza_exam_pst='".$FilaTMP[institu_realiza_exam_pst]."',fecha_hoja_ruta='".$FilaTMP[fecha_hoja_ruta]."',num_hoja_ruta='".$FilaTMP[num_hoja_ruta]."',fecha_curso_manejo='".$FilaTMP[fecha_curso_manejo]."',rut_empresa='".$FilaTMP[rut_empresa]."',empresa='".strtoupper($FilaTMP[empresa])."',contrato='".strtoupper($FilaTMP[contrato])."',fecha_das_codelco='".$FilaTMP[fecha_das_codelco]."',observacion='".strtoupper($FilaTMP["observacion"])."',tipo_vehiculo='".strtoupper($FilaTMP[tipo_vehiculo])."'";
						$Actualiza.=" where rut='".$FilaTMP["rut"]."'";
						mysql_query($Actualiza);
					}	
					else
					{
						$Consulta="SELECT ifnull(max(corr_conductor)+1,1) as maximo from sget_conductores ";
						$Resp=mysql_query($Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							if($Fila["maximo"]=='')
								$CodConductorG=1;
							else		
								$CodConductorG=$Fila["maximo"];
						}
						$Insertar="INSERT INTO sget_conductores (corr_conductor,rut,nombres,apellido_paterno,apellido_materno,fecha_vig_licencia,restriccion_licencia,fecha_exa_preoc,institu_realiza_exam_preoc,fecha_exa_pst,";
						$Insertar.=" institu_realiza_exam_pst,fecha_hoja_ruta,num_hoja_ruta,fecha_curso_manejo,rut_empresa,empresa,contrato,fecha_das_codelco,observacion,tipo_vehiculo)";
						$Insertar.=" values ('".$CodConductorG."','".$FilaTMP["rut"]."','".$FilaTMP["nombres"]."','".$FilaTMP["apellido_paterno"]."','".$FilaTMP["apellido_materno"]."','".$FilaTMP[fecha_vig_licencia]."','".$FilaTMP[restriccion_licencia]."','".$FilaTMP[fecha_exa_preoc]."','".$FilaTMP[institu_realiza_exam_preoc]."','".$FilaTMP[fecha_exa_pst]."',";
						$Insertar.=" '".$FilaTMP[institu_realiza_exam_pst]."','".$FilaTMP[fecha_hoja_ruta]."','".$FilaTMP[num_hoja_ruta]."','".$FilaTMP[fecha_curso_manejo]."','".$FilaTMP[rut_empresa]."','".$FilaTMP[empresa]."','".$FilaTMP[contrato]."','".$FilaTMP[fecha_das_codelco]."','".$FilaTMP["observacion"]."','".strtoupper($FilaTMP[tipo_vehiculo])."')";
						//echo "inserta conductorers:    ".$Insertar."<br>";
						mysql_query($Insertar);
						
						$ConsultaTMPL="SELECT tipo_licencia from sget_conductores_licencias_tmp where corr_conductor='".$FilaTMP[corr_conductor]."'";
						$RespTMPL=mysql_query($ConsultaTMPL);
						while($FilaTMPL=mysql_fetch_array($RespTMPL))
						{
							$Insertar="INSERT INTO sget_conductores_licencias (corr_conductor,tipo_licencia) values('".$CodConductorG."','".strtoupper($FilaTMPL[tipo_licencia])."')";
							//echo "Licencias:    ".$Insertar."<br><br>";
							mysql_query($Insertar);
						}
					}			
					$Elimina="delete from sget_conductores_tmp where rut='".$FilaTMP["rut"]."' and rut_operador='".$CookieRut."'";
					mysql_query($Elimina);
					$Elimina="delete from sget_conductores_licencias_tmp where corr_conductor='".$FilaTMP[corr_conductor]."'";
					mysql_query($Elimina);
				}
			}	
			if(file_exists($Directorio.'/carga_conductores.xls'))
			{
				unlink($Directorio.'/carga_conductores.xls');
			}	
			header('location:sget_mantenedor_conductores_proceso_carga.php?Ing=R');	
	break;
}

function valida_rut($r)
{
	$r=strtoupper(ereg_replace('\.|,|-','',$r));
	$sub_rut=substr($r,0,strlen($r)-1);
	$sub_dv=substr($r,-1);
	$x=2;
	$s=0;
	for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )
	{
		if ( $x >7 )
		{
			$x=2;
		}
		$s += $sub_rut[$i]*$x;
		$x++;
	}
	$dv=11-($s%11);
	if ( $dv==10 )
	{
		$dv='K';
	}
	if ( $dv==11 )
	{
		$dv='0';
	}
	if ( $dv==$sub_dv )
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>