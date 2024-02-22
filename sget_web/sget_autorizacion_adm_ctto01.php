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
	case "A"://Autoriza
		$Consulta="SELECT * from sget_hoja_ruta_hitos where num_hoja_ruta='".$NumHoja."' and cod_hito='".$H."' ";
		$RespHD = mysql_query($Consulta);
		if($FilaHD=mysql_fetch_array($RespHD))
		{
			if($FilaHD[autorizado]!='S')
			{
				$Actualizar=" UPDATE  sget_hoja_ruta_hitos set ";
				$Actualizar.="autorizado='S',fecha_autorizacion='".$Fecha_Sistema."',rut_autorizador='".$Rut."' ";	
				$Actualizar.=" where num_hoja_ruta='".$NumHoja."' and cod_hito='".$H."' ";
				mysql_query($Actualizar);
			}
		}
		else
		{
			$Inserta="INSERT INTO sget_hoja_ruta_hitos (num_hoja_ruta,cod_hito,autorizado,fecha_autorizacion,rut_autorizador)";
			$Inserta.=" values('".$NumHoja."','".$H."','S','".$Fecha_Sistema."','".$Rut."')";
			mysql_query($Inserta);
		}
		Registra_Estados($NumHoja,$Fecha_Creacion,$Rut,$CodPantalla,$H,'A','H');		
		ActualizaGen($NumHoja,$CodPantalla);
		if($NoPant=='S')
		{
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmPrincipal.action='$NomPag?&Cons=S&CodSistema=".$CodSistema."&CodPantalla=".$CodPantalla."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&TxtHoja=".$TxtHoja."&CmbAno=".$CmbAno."&CmbEstado=".$CmbEstado."';";
			echo "window.opener.document.FrmPrincipal.submit();";
			echo "window.close();</script>";
		}		
		else	
			header("location:$NomPag?&Cons=S&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja."&CmbEstado=".$CmbEstado);
	break;
	case "RECH":
		$Actualizar=" UPDATE  sget_hoja_ruta_hitos set ";
		$Actualizar.="autorizado='N',fecha_autorizacion='".$Fecha_Sistema."',rut_autorizador='".$Rut."' ";	
		$Actualizar.=" where num_hoja_ruta='".$NumHoja."' and cod_hito='".$H."' ";
		mysql_query($Actualizar);
		Registra_Estados($NumHoja,$Fecha_Creacion,$Rut,$CodPantalla,$H,'R','H');
		ActualizaGen($NumHoja,$CodPantalla);
		header("location:$NomPag?&Cons=S&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja."&CmbEstado=".$CmbEstado);
	break;
	
}



?>