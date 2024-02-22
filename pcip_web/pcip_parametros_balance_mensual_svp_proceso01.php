<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
		if($CmbOrdenRel=='-1')
			$CmbOrdenRel=0;
		if($TxtTr=='')
			$TxtTr=0;
		if($TxtTipoInv=='')
			$TxtTipoInv=0;
		if($TxtMaterial=='')
			$TxtMaterial=0;
		$Insertar="insert into pcip_svp_balance_mensual (cod_etapa,cod_tipo_negocio,cod_producto_etapa,cod_tipo_informe,cod_tipo_balance,num_orden,num_orden_relacionada,tramo,tipo_inventario,cod_material,ordes,vigente) values ";
		$Insertar.="('".$CmbEtapa."','".$CmbTipoNegocio."','".$CmbProd."','".$CmbTipoInforme."','".$CmbTipoBalance."','".$CmbOrdenProd."','".$CmbOrdenRel."','".$TxtTr."','".$TxtTipoInv."','".$TxtMaterial."','".trim($TxtOrdes)."','S')";
		//echo $Insertar."<br>";
		mysql_query($Insertar);
		$Cod=$CmbEtapa."~".$CmbTipoNegocio."~".$CmbProd."~".$CmbTipoInforme."~".$CmbTipoBalance."~".$CmbOrdenProd."~".$TxtTipoInv;
		header('location:pcip_parametros_balance_mensual_svp_proceso.php?Opcion=M&Codigos='.$Cod);
	break;
	case "M":
		if($CmbOrdenRel=='-1')
			$CmbOrdenRel=0;
		if($$TxtTr=='')
			$$TxtTr=0;
		if($TxtTipoInv=='')
			$TxtTipoInv=0;
		if($TxtMaterial=='')
			$TxtMaterial=0;
		$Cod=explode('~',$Codigos);
		$Datos=explode('~~',$Valores);
		$Actualizar="UPDATE pcip_svp_balance_mensual set num_orden_relacionada='".$CmbOrdenRel."',tramo='".$TxtTr."',tipo_inventario='".$TxtTipoInv."',cod_material='".$TxtMaterial."',ordes='".trim($TxtOrdes)."' ";
		$Actualizar.="where cod_etapa = '".$Cod[0]."' and cod_tipo_negocio='".$Cod[1]."' and cod_producto_etapa='".$Cod[2]."' and cod_tipo_informe='".$Cod[3]."' and cod_tipo_balance='".$Cod[4]."' and num_orden='".$Cod[5]."'";
		//echo $Actualizar."<br>";
		mysql_query($Actualizar);
		header('location:pcip_parametros_balance_mensual_svp_proceso.php?Opcion=M&Codigos='.$Codigos);
	break;
	case "E":
		$Mensaje='1';
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
			$Cod=explode('~',$Codigo);
			$Eliminar="delete from pcip_svp_balance_mensual where cod_etapa = '".$Cod[0]."' and cod_tipo_negocio='".$Cod[1]."' and cod_producto_etapa='".$Cod[2]."' and cod_tipo_informe='".$Cod[3]."' and cod_tipo_balance='".$Cod[4]."' and num_orden='".$Cod[5]."'";
			mysql_query($Eliminar);
		}
		header("location:pcip_parametros_balance_mensual_svp.php?Mensaje=".$Mensaje."&Buscar=S");
	break;
}

?>