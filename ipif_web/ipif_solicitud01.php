<?  session_start(); 
	$Fecha_Sistema= date("Y-m-d");
	$Hora= date("G:i:s");
	include("../principal/conectar_ipif_web.php");
	include("funciones/ipif_funciones.php");
	$CODIGOSISTEMA=CODIGOSISTEMA();
	$Cuenta=CuentaRut($CookieRut);
	switch ($Opt)
	{
		case "SSAL":
		header("location:../principal/sistemas_usuario.php?CodSistema=".$CODIGOSISTEMA);
		break;
		case "IS":
		
			$Consulta="select max(nro_solicitud) as num_sol from ipif_novedades ";
			$RespSolp=mysql_query($Consulta);
			if($FilaSolp=mysql_fetch_array($RespSolp))
			{
				if (substr($FilaSolp["num_sol"],0,4) == date("Y"))
				{
					$NumNov =$FilaSolp["num_sol"]+1;										
				}
				else
				{
					$NumNov=date("Y")."00001";	
				}
			}
			else
			{
				$NumNov=date("Y")."00001";	
			}
			
			$Insertar="insert into ipif_novedades(nro_solicitud) values";
			$Insertar.="('".intval($NumNov)."')";
			//echo $Insertar;
			mysql_query($Insertar);
			header("location:ipif_solicitud.php?Opt=M");
		break;
		case "MS":
				$NumNov=$NV;
			header("location:ipif_solicitud.php?Opt=M");
		break;
		case "ECA":
			EnvioCorreo($NumNov,'A');//ENVIO POR CECO
			header("location:ipif_solicitud.php?Opt=M&Msj=S");
		break;
		case "ECB":
			EnvioCorreo($NumNov,'B');// ENVIO A VARIOS
			header("location:ipif_solicitud.php?Opt=M&Msj=S");
		break;
		case "G":
			$ce=CECOFuncionario($Cuenta);
			$TxtFechaAMD=FechaDMA($TxtFecha);
			$Actualizar = "UPDATE ipif_novedades set ";
			$Actualizar.= " fecha='".$Fecha_Sistema."',turno='".$CmbTurno."',hora='".$Hora."',fecha_ingreso='".$TxtFechaAMD."' ";
			$Actualizar.= " ,observacion='".$textnovedad."',informe_gerencia='".$InfGer."',envio_jefe='".$EJF."',cuenta='".$Cuenta."',rut_originador='".$CookieRut."',estado=1,ceco_origen='".$ce."',informe_diario='".$InfGer."'  ";
			$Actualizar.= " where nro_solicitud='".$NumNov."' ";
			mysql_query($Actualizar);
			//echo $Actualizar;
			$Eliminar.="delete from ipif_novedades_condicion where nro_solicitud='".intval($NumNov)."'";
			mysql_query($Eliminar);
			$Datos = explode("//",$Valores);
			foreach($Datos as $k => $v)
			{
				$Insertar="insert into ipif_novedades_condicion(nro_solicitud,cod_condicion) values";
				$Insertar.="('".intval($NumNov)."',".$v.")";
				mysql_query($Insertar);
			}
			if($EJF=="S")
				EnvioCorreo($NumNov,'C');
			if($InfGer =='S')
			{
				$NombreApe=NombreFuncCorto($CookieRut);
				$Consulta="select * from informe_diario.novedades where Fecha='".$Fecha_Sistema."' and Cod_tipo='15'  ";
				$RespE=mysql_query($Consulta);
				if(!$FilaE=mysql_fetch_array($RespE))
				{
					$Insertar="insert into informe_diario.novedades(Fecha,Rut,Cod_Tipo,Nombre,Texto)values ";
					$Insertar.=" ('".$Fecha_Sistema."','".$CookieRut."','15','".$NombreApe."','".$textnovedad."'  )";
					mysql_query($Insertar);
				}
				else
				{
					$Actualizar = "UPDATE informe_diario.novedades set  Texto='".$textnovedad."' where Fecha='".$Fecha_Sistema."' and Cod_Tipo ='15' ";
					mysql_query($Actualizar);
				}
			}
			$Consulta="select * from ipif_novedades_correos  where nro_solicitud='".$NumNov."' ";
			$RespNov=mysql_query($Consulta);
			if(!$FilaNov=mysql_fetch_array($RespNov))
			{
				$Actualizar = "UPDATE ipif_novedades set mantencion='' where nro_solicitud='".$NumNov."' ";
				mysql_query($Actualizar);
			}
				
			header("location:ipif_solicitud.php?Opt=M");
			break;
		case "E":
			$Eliminar = "delete from ipif_novedades where nro_solicitud='".$NumNov."' ";
			mysql_query($Eliminar);
			$Eliminar = "delete from ipif_novedades_condicion where nro_solicitud='".$NumNov."' ";
			mysql_query($Eliminar);
			$Eliminar = "delete from ipif_novedades_correos where nro_solicitud='".$NumNov."' ";
			mysql_query($Eliminar);
			header("location:ipif_solicitud.php?Opt=N");
			break;
		case "EM":
			
			$Datos = explode("//",$NumVarios);
			foreach($Datos as $k => $v)
			{
				$Eliminar = "delete from ipif_novedades where nro_solicitud='".$v."' ";
				mysql_query($Eliminar);
				$Eliminar = "delete from ipif_novedades_condicion where nro_solicitud='".$v."' ";
				mysql_query($Eliminar);
				$Eliminar = "delete from ipif_novedades_correos where nro_solicitud='".$v."' ";
				mysql_query($Eliminar);
			}	
			header("location:ipif_adm_novedades.php?Buscar=S&TxtFecha=".$TxtFecha."&CmbTurno=".$CmbTurno);
			break;
			
		case "CD":
			$Actualizar = "UPDATE ipif_novedades set ";
			$Actualizar.= " estado=".$Es." ";
			$Actualizar.= " where nro_solicitud='".$NV."' ";
			mysql_query($Actualizar);
			header("location:ipif_adm_novedades.php?Buscar=S&TxtFecha=".$TxtFecha."&CmbTurno=".$CmbTurno);
			break;	
	}
?>