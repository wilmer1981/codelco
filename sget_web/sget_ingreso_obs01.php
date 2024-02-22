<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$Fecha_Sistema= date("Y-m-d");
$Fecha_Creacion= date("Y-m-d G:i:s");
$Rut=$CookieRut;
switch($Proceso)
{
	case "GOBS":
		$Consulta="SELECT max(correlativo_obs) as mayor from sget_hoja_ruta_hitos_observaciones";
		$RespObs=mysql_query($Consulta);
		$FilaObs=mysql_fetch_array($RespObs);
		$NumObs =$FilaObs["mayor"]+1;	
		$Inserta=" INSERT INTO sget_hoja_ruta_hitos_observaciones (num_hoja_ruta,cod_hito,correlativo_obs,observacion,fecha_hora,rut)";
		$Inserta.=" values('".$NumHoja."','".$CodHito."','".$NumObs."','".$Obs."','".$Fecha_Creacion."','".$Rut."')";
		//echo $Inserta."<br>";
		mysql_query($Inserta);
		header("location:sget_detalle_obs_hito.php?Cons=S&H=".$CodHito."&NumHoja=".$NumHoja."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja);
	break;
	case "EOBS"://Ingresa Observacion Por Hitos
			$Delete="delete from sget_hoja_ruta_hitos_observaciones where num_hoja_ruta='".$NumHoja."' and  fecha_hora='".$FechaHrs."' ";
			mysql_query($Delete);
			//echo $Delete;
			header("location:sget_detalle_obs_hito.php?Cons=S&H=".$CodHito."&NumHoja=".$NumHoja."&CmbAno=".$CmbAno."&TxtHoja=".$TxtHoja);
	break;
	case "MOBS"://Ingresa Observacion Por Hitos
			$Actualizar="UPDATE sget_hoja_ruta_hitos_observaciones set observacion='$Obs' ";
			$Actualizar.=" where fecha_hora='".$FechaHrs."' and num_hoja_ruta='".$NumHoja."'";	
			mysql_query($Actualizar);
			?>
			<script languaje='JavaScript'>		
			 window.opener.document.FrmObs.action='sget_detalle_obs_hito.php?H=<? echo $CodHito;?>+&NumHoja=<? echo $NumHoja;?>';
			window.opener.document.FrmObs.submit();	
			window.close();</script>
<?
	break;
}



?>