<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opc)
{
	case "GI":
			$Insertar="insert into pcip_eva_asig_cargo_unidad (corr,cod_cargo,cod_unidad)";
			$Insertar.=" values('".$TxtCodigo."','".$CmbCargo."','".$CmbUnidad2."')";
			//echo $Insertar."<br>";
			mysql_query($Insertar);
			$Mensaje='Registro Guardado Exitosamente';	
			header('location:pcip_evaluacion_negocio_proceso_asig.php?Opc=GI&Mensaje='.$Mensaje.'&CmbCargo='.$CmbCargo);
	break;
	case "MI":
			$Actualizar="UPDATE pcip_eva_asig_cargo_unidad set cod_unidad='".$CmbUnidad2."'";
			$Actualizar.=" where corr='".$TxtCodigo."' and cod_cargo='".$CmbCargo."'";
			//echo $Actualizar."<br>";
			mysql_query($Actualizar);
			$Mensaje='Registro Modificado Exitosamente';
			header('location:pcip_evaluacion_negocio_proceso_asig.php?Opc=GI&Mensaje='.$Mensaje.'&CmbCargo='.$CmbCargo);
	break;
	case "E":
			$Eliminar="delete from pcip_eva_asig_cargo_unidad where corr='".$Corr."' and cod_cargo='".$Cod."'";	
			//echo $Eliminar."<br>";
			mysql_query($Eliminar);
			$Mensaje='Registro Eliminado Exitosamente';
			header("location:pcip_evaluacion_negocio_proceso_asig.php?Mensaje=".$Mensaje.'&Opcion='.$Opcion.'&CmbCargo=-1');
	break;
}

?>