<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
	    if($TxtValorTotal=='')
			$TxtValorTotal='0';
		if($TxtPrecio=='')
			$TxtPrecio='0';	
		$Insertar="insert into pcip_eec_facturas_suministros (cod_suministro,ano,mes,valor_total,precio,fecha) values ";
		$Insertar.="('".$CmbSuministro."','".$Ano."','".$Mes."','".QuitaMilesDecimales($TxtValorTotal)."','".QuitaMilesDecimales($TxtPrecio)."','".date('Y-m-d')."')";
		//echo $Insertar;
		mysql_query($Insertar);
		$Corr=ObtenerMaxCorr('pcip_eec_facturas_suministros','corr')-1;
		header('location:pcip_mantenedor_facturas_suministros_proceso.php?Opcion=M&Corr='.$Corr);
	break;
	case "M":
	    if($TxtValorTotal=='')
			$TxtValorTotal=0;
		if($TxtPrecio=='')
			$TxtPrecio=0;	
		$Actualizar="UPDATE pcip_eec_facturas_suministros set cod_suministro='".$CmbSuministro."',ano='".$Ano."',mes='".$Mes."',valor_total='".QuitaMilesDecimales($TxtValorTotal)."',";
		$Actualizar.="precio='".QuitaMilesDecimales($TxtPrecio)."',fecha='".date('Y-m-d')."' where corr='".$Corr."'";
		//echo $Actualizar."<br>";
		mysql_query($Actualizar);
		header('location:pcip_mantenedor_facturas_suministros_proceso.php?Opcion=M&Corr='.$Corr);
	break;
	case "E":
		$Mensaje='1';
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
			$Eliminar="delete from pcip_eec_facturas_suministros where corr='".$Codigo."'";
			mysql_query($Eliminar);
		}
		header("location:pcip_mantenedor_facturas_suministros.php?Mensaje=".$Mensaje."&Buscar=S");
	break;
}

?>