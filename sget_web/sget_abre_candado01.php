<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$Fecha_Sistema= date("Y-m-d");
$Fecha_Creacion= date("Y-m-d G:i:s");
$Rut=$CookieRut;
//$NomPag=RetornoPagina($CodSistema,$CodPantalla);
//echo $NomPag;
switch($Proceso)
{
	case "A"://Autoriza
	
	$Consulta = "SELECT * ";
		$Consulta.= " FROM proyecto_modernizacion.funcionarios ";
		$Consulta.= " WHERE rut = '".$Rut."'";
		$Resp0=mysqli_query($link, $Consulta);
		if($Fila0=mysql_fetch_array($Resp0))
		{
			$Consulta = "SELECT * ";
			$Consulta.= " FROM proyecto_modernizacion.funcionarios ";
			$Consulta.= " WHERE rut = '".$Rut."'";
			$Consulta.= " and password2 = md5('".strtoupper($TxtPassActual)."')"; 		
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{
				$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado='".$Est."' where num_hoja_ruta='".$NumHoja."'";
				mysql_query($Actualizar);
				Registra_Actividad($NumHoja,$Rut,$Est,'E');
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.FrmPrincipal.action=\"sget_autorizacion_gestion_terceros.php?Cons=S&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja."&CmbEstado=".$CmbEstado."\";";
				echo " window.opener.document.FrmPrincipal.submit();";		
				echo " window.close();</script>";
			}
			else
			{
				header("location:sget_abre_candado.php?Error=2&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja."&CmbEstado=".$CmbEstado."&Est=".$Est."&NumHoja=".$NumHoja);
			
			}
		}
		else
		{
			header("location:sget_abre_candado.php?Error=1&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja."&CmbEstado=".$CmbEstado."&Est=".$Est."&NumHoja=".$NumHoja);
			
		}	
	break;
	
}

?>