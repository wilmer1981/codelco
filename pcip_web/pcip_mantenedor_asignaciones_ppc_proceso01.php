<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
		if($CmbOrdenRel=='-1')
			$CmbOrdenRel=0;
		if($TxtMaterial=='')
			$TxtMaterial='NULL';
		if($TxtConsumo=='')
			$TxtConsumo='NULL';
		if($TxtVPtm=='')
			$TxtVPtm=0;
		if($TxtOrden=='')
			$TxtOrden='NULL';

		$Insertar="insert into pcip_svp_productos_procedencias (cod_asignacion,cod_procedencia,cod_negocio,cod_titulo,num_orden,num_orden_relacionada,cod_material,consumo_interno,vptm,orden,origen) values ";
		$Insertar.="('".$CmbProd."','".$CmbAsig."','".$CmbNegocio."','".$CmbTitulo."','".$CmbOrden."',".$CmbOrdenRel.",".$TxtMaterial.",".$TxtConsumo.",".$TxtVPtm.",".$TxtOrden.",'PPC')";
		//echo $Insertar."<br>";
		mysql_query($Insertar);
		$Cod=$CmbProd."~".$CmbAsig."~".$CmbNegocio."~".$CmbOrden."~".$CmbOrdenRel."~".'PPC';
		header('location:pcip_mantenedor_asignaciones_ppc_proceso.php?Opcion=M&Mensaje=1&Codigos='.$Cod);
	break;
	case "M":
		$Cod=explode('~',$Codigos);
			if($CmbOrdenRel=='-1')
				$CmbOrdenRel=0;
			if($TxtMaterial=='')
				$TxtMaterial='NULL';
			if($TxtConsumo=='')
				$TxtConsumo='NULL';
			if($TxtVPtm=='')
				$TxtVPtm=0;
			if($TxtOrden=='')
				$TxtOrden='NULL';
			$Actualizar="UPDATE pcip_svp_productos_procedencias set num_orden_relacionada=".$CmbOrdenRel.",cod_material=".$TxtMaterial.",consumo_interno=".$TxtConsumo.",vptm=".$TxtVPtm.",orden=".$TxtOrden." where cod_asignacion='".$Cod[0]."' and cod_procedencia='".$Cod[1]."' and cod_negocio='".$Cod[2]."' and num_orden='".$Cod[3]."'";
			$Actualizar.="and num_orden_relacionada='".$Cod[4]."' and origen='PPC'";	
			//echo $Actualizar."<br>";
			mysql_query($Actualizar);
			$Codigos=$Cod[0]."~".$Cod[1]."~".$Cod[2]."~".$Cod[3]."~".'PPC';
		header('location:pcip_mantenedor_asignaciones_ppc_proceso.php?Opcion=M&Mensaje=2&Codigos='.$Codigos);
	break;
	case "E":
		$Mensaje='1';
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
			$Cod=explode('~',$Codigo);
			$Eliminar="delete from pcip_svp_productos_procedencias where cod_asignacion='".$Cod[0]."' and  cod_procedencia='".$Cod[1]."' and cod_negocio='".$Cod[2]."' and num_orden='".$Cod[3]."' and origen='PPC'";	
			mysql_query($Eliminar);
		}
		header("location:pcip_mantenedor_asignaciones_ppc.php?Mensaje=".$Mensaje."&Buscar=S&CmbAsig=-1&CmbProd=".$Cod[0]);
	break;
}

?>