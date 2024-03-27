<?
include("../principal/conectar_sget_web.php");

if($TxtExaPreocu=='')
	$TxtExaPreocu='0000-00-00';
if($TxtVigExamPST=='')	
	$TxtVigExamPST='0000-00-00';
if($TxtFechaHR=='')	
	$TxtFechaHR='0000-00-00';
if($TxtFechaCurso=='')	
	$TxtFechaCurso='0000-00-00';
switch($Opcion)
{
	case "N":
			$Consulta="SELECT * from sget_conductores where rut='".trim($TxtRut)."'";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{
				$Msj='Exis';
				header("location:sget_mantenedor_conductores_proceso.php?Msj=".$Msj."&CorrCond=".$Fila[corr_conductor]);
			}
			else
			{
				$Consulta="SELECT ifnull(max(corr_conductor)+1,1) as maximo from sget_conductores ";
				$Resp=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
					if($Fila["maximo"]=='')
						$CodConductorG=1;
					else		
						$CodConductorG=$Fila["maximo"];
				}
				if($TxtFechaHR=='')
					$TxtFechaHR='0000-00-00'	;				
				$Insertar="INSERT INTO sget_conductores (corr_conductor,rut,nombres,apellido_paterno,apellido_materno,fecha_vig_licencia,restriccion_licencia,fecha_exa_preoc,institu_realiza_exam_preoc,fecha_exa_pst,";
				$Insertar.=" institu_realiza_exam_pst,fecha_hoja_ruta,num_hoja_ruta,fecha_curso_manejo,rut_empresa,empresa,contrato,fecha_das_codelco,observacion,hoja_vida_n_docu,tipo_vehiculo,fecha_hoja_vida)";
				$Insertar.=" values ('".$CodConductorG."','".$TxtRut."','".strtoupper($TxtNombre)."','".strtoupper($TxtPaterno)."','".strtoupper($TxtMaterno)."','".$TxtVigMuni."','".strtoupper($TxtRestric)."','".$TxtExaPreocu."','".strtoupper($TxtInstPreocupa)."','".$TxtVigExamPST."',";
				$Insertar.=" '".$TxtInstPST."','".$TxtFechaHR."','".$TxtNumHR."','".$TxtFechaCurso."','".$TxtRutEmp."','".strtoupper($TxtEmpClien)."','".strtoupper($TxtNContra)."','".$TxtFechaDAS."','".strtoupper($Obs)."','".strtoupper($TxtCodumnto)."','".$TipVehi."','".$TxtFechEmiHojaV."')";
				//echo $Insertar."<br>";
				mysql_query($Insertar);
				
				if($Archivo!='')
				{
					$Extension=explode('.',$Archivo);
					if(strtoupper($Extension[1])!='EXE'&&strtoupper($Extension[1])!='ZIP'&&strtoupper($Extension[1])!='RAR')
					{
						$Directorio='fotos';
						$NombreArchivo=str_pad(strtoupper($TxtRut),10,'0',STR_PAD_LEFT).".jpg";
						//echo $NombreArchivo;
						copy($Archivo, $Directorio."/".$NombreArchivo);
					}   
				}
				
				$Licencia=explode('//',$LicenciasGua);
				while(list($c,$v)=each($Licencia))
				{
					$Inserta="INSERT INTO sget_conductores_licencias (corr_conductor,tipo_licencia) values('".$CodConductorG."','".$v."')";
					mysql_query($Inserta);
				}
				$Msj='G';
				header("location:sget_mantenedor_conductores_proceso.php?Opc=M&Msj=".$Msj."&CorrCond=".$CodConductorG);
			}
	break;
	case "M":
			
			$Actualiza="UPDATE sget_conductores set rut='".$TxtRut."',nombres='".strtoupper($TxtNombre)."',apellido_paterno='".strtoupper($TxtPaterno)."',apellido_materno='".strtoupper($TxtMaterno)."',fecha_vig_licencia='".$TxtVigMuni."',restriccion_licencia='".strtoupper($TxtRestric)."',fecha_exa_preoc='".$TxtExaPreocu."',institu_realiza_exam_preoc='".strtoupper($TxtInstPreocupa)."',fecha_exa_pst='".$TxtVigExamPST."',";
			$Actualiza.="institu_realiza_exam_pst='".$TxtInstPST."',fecha_hoja_ruta='".$TxtFechaHR."',num_hoja_ruta='".$TxtNumHR."',fecha_curso_manejo='".$TxtFechaCurso."',rut_empresa='".$TxtRutEmp."',empresa='".strtoupper($TxtEmpClien)."',contrato='".strtoupper($TxtNContra)."',fecha_das_codelco='".$TxtFechaDAS."',observacion='".strtoupper($Obs)."',hoja_vida_n_docu='".strtoupper($TxtCodumnto)."',tipo_vehiculo='".$TipVehi."',fecha_hoja_vida='".$TxtFechEmiHojaV."'";
			$Actualiza.=" where corr_conductor='".$CodConductor."'";
			//echo $Actualiza;
			mysql_query($Actualiza);

			$Elimina="delete from sget_conductores_licencias where corr_conductor='".$CodConductor."'";
			mysql_query($Elimina);
			
			if($Archivo!='')
			{
				$Extension=explode('.',$Archivo);
				if(strtoupper($Extension[1])!='EXE'&&strtoupper($Extension[1])!='ZIP'&&strtoupper($Extension[1])!='RAR')
				{
					$Directorio='fotos';
					$NombreArchivo=str_pad(strtoupper($TxtRut),10,'0',STR_PAD_LEFT).".jpg";
					//echo $NombreArchivo;
					copy($Archivo, $Directorio."/".$NombreArchivo);
				}   
			}

			$Licencia=explode('//',$LicenciasGua);
			while(list($c,$v)=each($Licencia))
			{
				$Inserta="INSERT INTO sget_conductores_licencias (corr_conductor,tipo_licencia) values('".$CodConductor."','".$v."')";
				//echo $Inserta."<br>";
				mysql_query($Inserta);
			}
			$Msj='M';
			header("location:sget_mantenedor_conductores_proceso.php?Opc=M&Msj=".$Msj."&CorrCond=".$CodConductor);
	break;
	case "E":
			$Valores=explode('//',$Valor);
			while(list($c,$v)=each($Valores))
			{
				$Eliminar="delete from sget_conductores where corr_conductor='".$v."'";
				//echo $Eliminar;
				mysql_query($Eliminar);
				
				$Elimina="delete from sget_conductores_licencias where corr_conductor='".$v."'";
				mysql_query($Elimina);
			}
			header("location:sget_mantenedor_conductores.php?Msj=E&Cons=S");
	break;
	case "VAL":
		   $Actualizar="UPDATE sget_conductores set validado='".$Validar."' where rut='".$Rut."'";
		   //echo $Actualizar;
		   mysql_query($Actualizar);
		   header("location:sget_mantenedor_conductores.php?Msj=VAL&Cons=S");
	break;
	
}
?>