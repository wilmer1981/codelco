<?  include("../principal/conectar_sget_web.php");
	$Fecha=date('Y-m-d');
	$RutDV=$TxtRutPrv;
	$Fecha_Hora = date("Y-m-d h:i");
	$Directorio='doc';
	
	switch($Opcion)
	{
		case "N":
			$Consulta="SELECT * from sget_prevencionistas where rut_prev='".$RutDV."' ";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysql_fetch_array($Respuesta))
			{
				$Encontro=true;				
				header("location:sget_mantenedor_prevencionista_proceso.php?Mensaje=".$Encontro."&Opc=".$Opcion."&Volver=".$Volver);	 
			}
			else
			{
				if($CmbClase =='-1')
					$CmbCiudad='';
				if($CmbSubClase =='-1')
					$CmbComuna='';	
				
				if($DocSerna_name!='')
					$RESerna=CargaDoc($DocSerna_name,$DocSerna,'Res_Sernageomin',substr(str_pad($RutDV,10,'0',l_pad),0,10));	
				if($DocSNS_name!='')	
					$RESSNS=CargaDoc($DocSNS_name,$DocSNS,'Res_SNS',substr(str_pad($RutDV,10,'0',l_pad),0,10));	
				if($DocTitulo_name!='')
					$DocTitulo=CargaDoc($DocTitulo_name,$DocTitulo,'Titulo_profesional',substr(str_pad($RutDV,10,'0',l_pad),0,10));	
				if($DocCurri_name!='')	
					$DocCurriculum=CargaDoc($DocCurri_name,$DocCurri,'Curriculum',substr(str_pad($RutDV,10,'0',l_pad),0,10));	
					
				$Insertar="INSERT INTO sget_prevencionistas(rut_prev,nombres, ";
				$Insertar.=" apellido_paterno,apellido_materno,direccion,telefono, ";
				$Insertar.=" regis_sns_serg,estado,celular,email_1,email_2,titulo,observacion,curriculum,titulo_prof,res_sns,res_serna) ";
				$Insertar.="values ('".substr(str_pad($RutDV,10,'0',l_pad),0,10)."','".strtoupper($TxtNombres)."','".strtoupper($TxtApellidoPaterno)."','".strtoupper($TxtApellidoMaterno)."', ";
				$Insertar.=" '".strtoupper($TxtDireccion)."','".strtoupper($TxtFono)."', ";
				$Insertar.="'".$TxtSerga."~".$TxtSNS."','".$CmbEstado."','".$TxtCelular."', ";
				$Insertar.="'".$TxtEmail1."','".$TxtEmail2."','".strtoupper($TxtTitulo)."','".strtoupper($Observacion)."','".strtoupper($DocCurriculum)."','".strtoupper($DocTitulo)."','".strtoupper($RESSNS)."','".strtoupper($RESerna)."') ";
				//echo $Insertar;
				mysql_query($Insertar);
				if($Volver=='S')
				{
					echo "<script languaje='JavaScript'>";	
					echo " window.opener.document.FrmPopupUsuario.action='sget_mantenedor_contratos_proceso.php?Prevencionista=$TxtRutPrv-$TxtDv'; ";
					echo " window.opener.document.FrmPopupUsuario.submit();";		
					echo " window.close();</script>";	
				}
				else
				{			
					echo "<script languaje='JavaScript'>";		
					echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_prevencionista.php'; ";
					echo " window.opener.document.FrmPrincipal.submit();";		
					echo " window.close();</script>";	
				}
			}
		break;
		case "M":
			//$Eliminar="delete  from sget_prevencionistas  ";
			//$Eliminar.=" where rut_prev='".$RutDV."'";	
			//mysql_query($Eliminar);
			//echo $Eliminar;
			if($CmbClase =='-1')
				$CmbCiudad='';
			if($CmbSubClase =='-1')
				$CmbComuna='';	

			if($DocSerna_name!='' && $DocSerna2!='S')
				$RESerna=CargaDoc($DocSerna_name,$DocSerna,'Res_Sernageomin',substr(str_pad($RutDV,10,'0',l_pad),0,10));
			else
				$RESerna=$DocSerna;		
			if($DocSNS_name!='' && $DocSNS2!='S')	
				$RESSNS=CargaDoc($DocSNS_name,$DocSNS,'Res_SNS',substr(str_pad($RutDV,10,'0',l_pad),0,10));	
			else
				$RESSNS=$DocSNS;	
			if($DocTitulo_name!='' && $DocTitulo2!='S')
				$DocTitulo=CargaDoc($DocTitulo_name,$DocTitulo,'Titulo_profesional',substr(str_pad($RutDV,10,'0',l_pad),0,10));	
			else
				$DocTitulo=$DocTitulo;		
			if($DocCurri_name!='' && $DocCurri2!='S')	
				$DocCurriculum=CargaDoc($DocCurri_name,$DocCurri,'Curriculum',substr(str_pad($RutDV,10,'0',l_pad),0,10));	
			else
				$DocCurriculum=$DocCurri;		

			$Actualiza="UPDATE sget_prevencionistas set nombres='".strtoupper($TxtNombres)."',apellido_paterno='".strtoupper($TxtApellidoPaterno)."',apellido_materno='".strtoupper($TxtApellidoMaterno)."',direccion='".strtoupper($TxtDireccion)."',telefono='".strtoupper($TxtFono)."',";
			$Actualiza.="contacto='".strtoupper($TxtContacto)."',regis_sns_serg='".$TxtSerga."~".$TxtSNS."',estado='".$CmbEstado."',celular='".$TxtCelular."',email_1='".$TxtEmail1."',email_2='".$TxtEmail2."',";
			$Actualiza.="titulo='".strtoupper($TxtTitulo)."',observacion='".strtoupper($Observacion)."',curriculum='".strtoupper($DocCurriculum)."',titulo_prof='".strtoupper($DocTitulo)."',res_sns='".strtoupper($RESSNS)."',res_serna='".strtoupper($RESerna)."'";
			$Actualiza.=" where rut_prev='".$RutDV."'";
			//echo $Actualiza;
			mysql_query($Actualiza);
/*			$Insertar="INSERT INTO sget_prevencionistas(rut_prev,nombres, ";
			$Insertar.=" apellido_paterno,apellido_materno,direccion,telefono, ";
			$Insertar.=" contacto,regis_sns_serg,estado,celular,email_1,email_2,titulo,observacion,curriculum,titulo_prof,res_sns,res_serna) ";
			$Insertar.="values ('".$RutDV."','".strtoupper($TxtNombres)."','".strtoupper($TxtApellidoPaterno)."','".strtoupper($TxtApellidoMaterno)."', ";
			$Insertar.="'".strtoupper($TxtDireccion)."','".strtoupper($TxtFono)."' ,'".strtoupper($TxtContacto)."', ";
			$Insertar.="'".$TxtSerga."~".$TxtSNS."','".$CmbEstado."','".$TxtCelular."', ";
			$Insertar.="'".$TxtEmail1."','".$TxtEmail2."','".strtoupper($TxtTitulo)."','".strtoupper($Observacion)."','".strtoupper($DocCurriculum)."','".strtoupper($DocTitulo)."','".strtoupper($RESSNS)."','".strtoupper($RESerna)."') ";
			//echo $Insertar;
			mysql_query($Insertar);
*/			
			if($Volver=='S')
			{
				echo "<script languaje='JavaScript'>";	
				echo " window.opener.document.FrmPopupUsuario.action='sget_mantenedor_contratos_proceso.php?Prevencionista=$TxtRutPrv-$TxtDv'; ";
				echo " window.opener.document.FrmPopupUsuario.submit();";		
				echo " window.close();</script>";	
			}
			else
			{			
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_prevencionista.php'; ";
				echo " window.opener.document.FrmPrincipal.submit();";		
				echo " window.close();</script>";	
			}
			
			
		break;
		case "E":
			$Datos = explode("//",$Valor);
			while (list($clave,$Rut)=each($Datos))
			{
				$Consulta=" Select count(rut_prev) as Total from sget_contratos where rut_prev='".$Rut."'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysql_fetch_array($Respuesta);
				if ($Fila["total"]<=0)
				{
					$Eliminar="delete from sget_prevencionistas where rut_prev='".$Rut."'";
					mysql_query($Eliminar);
					$Mensaje="N";
				}
				else
				{
					$Mensaje="S";
					break;	
				}	
			}
			header("location:sget_mantenedor_prevencionista.php?Mensaje=".$Mensaje);
		break;
		case "GJor":
			$Actualiza="UPDATE sget_contratos set tipo_jornada='".$Jorn."' where cod_contrato='".$Contrato."'";
			mysql_query($Actualiza);
			header("location:sget_mantenedor_prevencionista_proceso.php?Opc=M&Valores=".$TxtRutPrv."&Msj=Jor");
		break;
		case "ELDOC";//--------------ELIMINA DOCUMENTO-----------------
			$Actualiza="UPDATE sget_prevencionistas set";
			if($Tipo=='T')
			    $Actualiza.=" titulo_prof=''";
			if($Tipo=='C')
			    $Actualiza.=" curriculum=''";
			if($Tipo=='Se')
			    $Actualiza.=" res_serna=''";
			if($Tipo=='SN')
			    $Actualiza.=" res_sns=''";
		    $Actualiza.=" where rut_prev='".$Rut."'";
			if($Tipo=='T')
			    $Actualiza.=" and titulo_prof='".$Doc."'";
			if($Tipo=='C')
			    $Actualiza.=" and curriculum='".$Doc."'";
			if($Tipo=='Se')
			    $Actualiza.=" and res_serna='".$Doc."'";
			if($Tipo=='SN')
			    $Actualiza.=" and res_sns='".$Doc."'";
			//echo $Actualiza;
			mysql_query($Actualiza);
			if(file_exists($Directorio.'/'.$Doc))
			{
				unlink($Directorio.'/'.$Doc);
			}	
			header("location:sget_mantenedor_prevencionista_proceso.php?Opc=M&Valores=".$TxtRutPrv."&Msj=DocE");
		break;
	}
	
	
function CargaDoc($Documento,$file,$Tipo,$RutPreve)
{
	$Directorio='doc';
	if($Documento!='none' && $Documento!='')
	{
		$Extension=explode('.',$Documento);
		if(strtoupper($Extension[1])!='RAR' || strtoupper($Extension[1])!='ZIP')
		{
			$Acento=false;
			for ($j = 0;$j <= strlen($Documento[$Cont]); $j++)
			{
				switch(substr($Documento[$Cont],$j,1))
				{
					case "�":
						$Documento=str_replace( "�","a",$Documento);
					break;
					case "�":
						$Documento=str_replace( "�","A",$Documento);
					break;
					case "�":
						$Documento=str_replace( "�","e",$Documento);
					break;
					case "�":
						$Documento=str_replace( "�","E",$Documento);
					break;
					case "�":
						$Documento=str_replace( "�","i",$Documento);
					break;
					case "�":
						$Documento=str_replace( "�","I",$Documento);
					break;
					case "�":
						$Documento=str_replace( "�","o",$Documento);
					break;
					case "�":
						$Documento=str_replace( "�","O",$Documento);
					break;
					case "�":
						$Documento=str_replace( "�","u",$Documento);
					break;
					case "�":
						$Documento=str_replace( "�","U",$Documento);
					break;
					case "&":
						$Documento=str_replace( "&","",$Documento);
					break;
					case "$":
						$Documento=str_replace( "$","",$Documento);
					break;
					case "#":
						$Documento=str_replace( "#","",$Documento);
					break;
					case "'":
						$Documento=str_replace( "'","",$Documento);
					break;		
				}
			}
			//echo $Acento; 
			if($Acento==false)
			{
				$NombreArchivo=$RutPreve."_".$Tipo.".".$Extension[1];
				//echo $file."<br>";
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
				}	
			}
		}
	}	
	return($NombreArchivo)	;
}
?>
