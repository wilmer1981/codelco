<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
		$Mensaje='';$TxtCC=strtoupper(trim($TxtCC));
		$Consulta="select * from pcip_eec_centro_costos where cod_cc = '".$TxtCC."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if(!$Fila=mysql_fetch_array($Resp))
		{
			$Corr=ObtenerMaxCorr('pcip_eec_centro_costos','cod_area');
			$Insertar="insert into pcip_eec_centro_costos (cod_gerencia,cod_area,descrip_area,abreviatura,cod_cc,estado) values ";
			$Insertar.="('".$CmbGerencias."','".$Corr."','".$TxtDescripcion."','','".$TxtCC."','1')";
			//echo $Insertar;
			mysql_query($Insertar);
			$Mensaje='1';
		}
		else
		{
			$Mensaje='3';
			$Corr=$Fila[cod_area];
		}
		header('location:pcip_mantenedor_centro_costos_proceso.php?Opcion=M&Corr='.$Corr.'&Mensaje='.$Mensaje);
	break;
	case "M":
		$TxtCC=strtoupper(trim($TxtCC));
		$Actualizar="UPDATE pcip_eec_centro_costos set cod_gerencia='".$CmbGerencias."',descrip_area='".$TxtDescripcion."',cod_cc='".$TxtCC."' where cod_area='".$Corr."'";
		mysql_query($Actualizar);
		header('location:pcip_mantenedor_centro_costos_proceso.php?Opcion=M&Corr='.$Corr);
	break;
	case "E":
		$Mensaje='1';
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
			$Eliminar="delete from pcip_eec_centro_costos where cod_area='".$Codigo."'";
			mysql_query($Eliminar);
		}
		header("location:pcip_mantenedor_centro_costos.php?Mensaje=".$Mensaje."&Buscar=S");
	break;
}

?>