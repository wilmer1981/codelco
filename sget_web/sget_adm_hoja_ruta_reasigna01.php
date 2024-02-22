<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$Fecha_Sistema= date("Y-m-d");
$Fecha_Creacion= date("Y-m-d G:i:s");
$Rut=$CookieRut;
$NomPag=RetornoPagina($CodSistema,$CodPantalla);
//echo $NomPag;
switch($Proceso)
{
	case "GADM"://GRABA ADMINISTRADOR DE CONTRATO
		$Actualizar="UPDATE sget_hoja_ruta_adm_ctto set activo='N' where num_hoja_ruta='".$NumHoja."'";
		//echo $Actualizar."<br>";
		mysql_query($Actualizar);
		$Inserta="INSERT INTO sget_hoja_ruta_adm_ctto (num_hoja_ruta,rut_adm_ctto,activo,tipo,observacion,fecha_hora)";
		$Inserta.=" values('".$NumHoja."','".$CmbAdmCtto."','S','R','','".$Fecha_Creacion."')";
		mysql_query($Inserta);
		Registra_Estados($NumHoja,$Fecha_Creacion,$Rut,$CodPantalla,$H,'A','H');
		ActualizaGen($NumHoja,$CodPantalla);
		Registra_Actividad($NumHoja,$Rut,'8','R');
		header("location:sget_adm_hoja_ruta_reasigna.php?NumHoja=".$NumHoja);
	break;
	case "EADM"://ELIMINA ADMINISTRADOR DE CONTRATO
		$Eliminar="delete from sget_hoja_ruta_adm_ctto where num_hoja_ruta='".$NumHoja."' and rut_adm_ctto='".$RutAdm."'";
		mysql_query($Eliminar);
		Registra_Estados($NumHoja,$Fecha_Creacion,$Rut,$CodPantalla,$H,'R','H');
		ActualizaGen($NumHoja,$CodPantalla);
		header("location:sget_adm_hoja_ruta_reasigna.php?NumHoja=".$NumHoja);
	break;

	case "AADM"://ACTIVA AL ADMINISTRADOR DE LA HOJA DE RUTA
		$Actualizar="UPDATE sget_hoja_ruta_adm_ctto set activo='N' where num_hoja_ruta='".$NumHoja."'";
		//echo $Actualizar."<br>";
		mysql_query($Actualizar);
		$Actualizar="UPDATE sget_hoja_ruta_adm_ctto set activo='S',fecha_hora='".$Fecha_Creacion."' where num_hoja_ruta='".$NumHoja."' and rut_adm_ctto='".$RutAdm."'";
		//echo $Actualizar."<br>";
		mysql_query($Actualizar);
		Registra_Actividad($NumHoja,$Rut,'8','R');
		header("location:sget_adm_hoja_ruta_reasigna.php?NumHoja=".$NumHoja);
	break;
	case "GOBS"://GRABA OBSERVACION AL REASIGNADO
		$Actualizar="UPDATE sget_hoja_ruta_adm_ctto set observacion='".$Observ."' where num_hoja_ruta='".$NumHoja."' and rut_adm_ctto='".$RutAdm."'";
		//echo $Actualizar;
		mysql_query($Actualizar);
		header("location:sget_adm_hoja_ruta_reasigna.php?NumHoja=".$NumHoja);
	break;
	case "GEMAIL"://GRABA EMAIL ADM. CTTO. REASIGNADO
		$Actualizar="UPDATE sget_administrador_contratos set email='".$Email."' where rut_adm_contrato='".$RutAdm."'";
		//echo $Actualizar;
		mysql_query($Actualizar);
		header("location:sget_adm_hoja_ruta_reasigna.php?NumHoja=".$NumHoja);
	break;

	case "AHR"://ANULA LA HOJA DE RUTA DEJANDOLA EN ESTADO CREADA
		Registra_Estados($NumHoja,$Fecha_Creacion,$Rut,'','3','','E');
		$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=3, cod_estado_pantalla=1 where num_hoja_ruta='".$NumHoja."'";
        mysql_query($Actualizar);
		header("location:sget_adm_hoja_ruta.php?Cons=S&CmbEstado=1&CmbEmpresa=S&CmbContrato=S&CmbAno=".date('Y'));
	break;	
	case "ACHR"://ACTIVAR HOJA DE RUTA DEJANDOLA EN ESTADO CREADA O ENVIADA CORREO A ADM CTTO
		$Consulta="SELECT cod_estado from sget_reg_estados where num_hoja_ruta='".$NumHoja."' and cod_estado <> 3 order by fecha_hora desc ";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
		if($Fila["cod_estado"]=='6')
		{
			$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=2, cod_estado_pantalla=1 where num_hoja_ruta='".$NumHoja."'";
			Registra_Estados($NumHoja,$Fecha_Creacion,$Rut,'','6','A','H');
        }
		else
		{	
			$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=1, cod_estado_pantalla=1 where num_hoja_ruta='".$NumHoja."'";
			Registra_Estados($NumHoja,$Fecha_Creacion,$Rut,'','1','','E');
		}
		//echo $Actualizar;
		mysql_query($Actualizar);
		
		header("location:sget_adm_hoja_ruta.php?Cons=S&CmbEstado=1&CmbEmpresa=S&CmbContrato=S&CmbAno=".date('Y'));
	break;	

}



?>