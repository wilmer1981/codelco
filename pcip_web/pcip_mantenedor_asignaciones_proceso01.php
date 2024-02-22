<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
		if($CmbOrigenDatos=='SVP')
		{
			if($CmbOrdenRel=='-1')
				$CmbOrdenRel=0;
			if($TxtMaterial=='')
				$TxtMaterial='NULL';
			if($TxtConsumo=='')
				$TxtConsumo='NULL';
			if($TxtVPtm=='')
				$TxtVPtm='0';
			if($TxtOrden=='')
				$TxtOrden='NULL';
			$Factor=str_replace(',','.',$TxtFactor);	
			$Insertar="insert into pcip_svp_productos_procedencias (correlativo,cod_asignacion,cod_procedencia,cod_negocio,cod_titulo,num_orden,num_orden_relacionada,cod_material,consumo_interno,vptm,orden,origen,ano,signo,factor,nodo) values ";
			$Insertar.="('".$TxtCodigo."','".$CmbProd."','".$CmbAsig."','".$CmbNegocio."','".$CmbTitulo."','".$CmbOrden."',".$CmbOrdenRel.",".$TxtMaterial.",".$TxtConsumo.",".$TxtVPtm.",".$TxtOrden.",'".$CmbOrigenDatos."','".$Ano."','".$CmbSigno."','".$Factor."','0')";
			//echo $Insertar."<br>";
			mysql_query($Insertar);
			$Cod=$TxtCodigo."~".$CmbProd."~".$CmbAsig."~".$CmbNegocio."~".$CmbOrden."~".$CmbOrdenRel."~".$CmbOrigenDatos."~".$TxtVPtm;
		}
		if($CmbOrigenDatos=='CDV')
		{
			if($TxtOrden=='')
				$TxtOrden='NULL';
			$Factor=str_replace(',','.',$TxtFactor);	
			$Insertar="insert into pcip_svp_productos_procedencias (correlativo,cod_asignacion,cod_procedencia,cod_negocio,cod_titulo,num_orden,num_orden_relacionada,vptm,orden,origen,ano,signo,factor,nodo) values ";
			$Insertar.="('".$TxtCodigo."','".$CmbProd."','".$CmbAsig."','".$CmbNegocio."','".$CmbTitulo."','".$CmbOrden."',0,0,".$TxtOrden.",'".$CmbOrigenDatos."','".$Ano."','".$CmbSigno."','".$Factor."','0')";
			//echo $Insertar."<br>";
			mysql_query($Insertar);
			$Cod=$TxtCodigo."~".$CmbProd."~".$CmbAsig."~".$CmbNegocio."~".$CmbOrden."~0~".$CmbOrigenDatos;
		}
		if($CmbOrigenDatos=='ENA' || $CmbOrigenDatos=='PMN')
		{
			if($TxtOrden=='')
				$TxtOrden='NULL';
			$Factor=str_replace(',','.',$TxtFactor);	
			$Insertar="insert into pcip_svp_productos_procedencias (correlativo,cod_asignacion,cod_procedencia,cod_negocio,cod_titulo,num_orden,num_orden_relacionada,vptm,orden,origen,ano,signo,factor,nodo) values ";
			$Insertar.="('".$TxtCodigo."','".$CmbProd."','".$CmbAsig."','".$CmbNegocio."','".$CmbTitulo."','".$CmbOrden."','".$CmbProducto."',0,".$TxtOrden.",'".$CmbOrigenDatos."','".$Ano."','".$CmbSigno."','".$Factor."','".$CmbNodo."')";
			//echo $Insertar."<br>";
			mysql_query($Insertar);
			$Cod=$TxtCodigo."~".$CmbProd."~".$CmbAsig."~".$CmbNegocio."~".$CmbOrden."~0~".$CmbOrigenDatos;
		}
		header('location:pcip_mantenedor_asignaciones_proceso.php?Opcion=M&Mensaje=1&Codigos='.$Cod);
	break;
	case "G":
		$Consulta="select * from pcip_svp_productos_procedencias where ano='".$Ano."'";
		$Resp=mysql_query($Consulta);
		//echo $Consulta."<br>";
		while($Fila=mysql_fetch_array($Resp))
		{
		    $Asignacion=$Fila[cod_asignacion];
			$Procedencia=$Fila[cod_procedencia];
			$Negocio=$Fila[cod_negocio];			
			$Titulo=$Fila[cod_titulo];
			$NumOrden=$Fila[num_orden];
			$OrdenRel=$Fila[num_orden_relacionada];
			$VPtm=$Fila[vptm];
			$Origen=$Fila[origen];
			$Signo=$Fila[signo];
			$Factor=$Fila[factor];
			if($Fila["nodo"]!='')
				$CmbNodo=$Fila["nodo"];
			else
				$CmbNodo='0';		
			if($Fila[cod_material]!='')
				$Material=$Fila[cod_material];
			else
				$Material='Null';
			if($Fila[consumo_interno]!='')
				$Consumo=$Fila[consumo_interno];
			else
				$Consumo='Null';
			if($Fila[orden]!='')
				$Orden=$Fila[orden];
			else
				$Orden='Null';
			$Consulta2="select max(correlativo+1) as maximo from pcip_svp_productos_procedencias ";
			$Resp2=mysql_query($Consulta2);
			if($Fila2=mysql_fetch_array($Resp2))
			{
				$Correlativo=$Fila2["maximo"];
			}
			$Insertar="insert into pcip_svp_productos_procedencias (correlativo,cod_asignacion,cod_procedencia,cod_negocio,cod_titulo,num_orden,num_orden_relacionada,cod_material,consumo_interno,vptm,orden,origen,ano,signo,factor,nodo) values ";
			$Insertar.="('".$Correlativo."','".$Asignacion."','".$Procedencia."','".$Negocio."','".$Titulo."','".$NumOrden."',".$OrdenRel.",".$Material.",".$Consumo.",".$VPtm.",".$Orden.",'".$Origen."','".$AnoFin."','".$Signo."','".$Factor."','".$CmbNodo."')";
			//echo "inserta  ".$Insertar."<br>";
			mysql_query($Insertar);
		}	
		$Mensaje='1';
		header('location:pcip_mantenedor_asignaciones_proceso_ano.php?Mensaje=1');
	break;
	case "M":
		$Cod=explode('~',$Codigos);
		if($Cod[6]=='SVP')
		{
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
			$Factor=str_replace(',','.',$TxtFactor);	
			$Actualizar="UPDATE pcip_svp_productos_procedencias set cod_material=".$TxtMaterial.",num_orden_relacionada='".$CmbOrdenRel."',consumo_interno=".$TxtConsumo.",vptm=".$TxtVPtm.",orden=".$TxtOrden.", ano='".$Ano."', signo='".$CmbSigno."', factor='".$Factor."', nodo='0' where correlativo='".$Cod[0]."' and cod_asignacion='".$Cod[1]."' and cod_procedencia='".$Cod[2]."' and cod_negocio='".$Cod[3]."' and num_orden='".$Cod[4]."'";
			$Actualizar.=" and num_orden_relacionada='".$Cod[5]."' and origen='".$Cod[6]."' and vptm='".$Cod[7]."'" ;	
			//echo $Actualizar."<br>";
			mysql_query($Actualizar);			
			$Codigos=$Cod[0]."~".$Cod[1]."~".$Cod[2]."~".$Cod[3]."~".$Cod[4]."~".$CmbOrdenRel."~".$Cod[6]."~".$TxtVPtm;
			//echo $Codigos."<br>";
		}
		if($Cod[6]=='CDV')
		{
			if($TxtOrden=='')
				$TxtOrden='NULL';
			$Factor=str_replace(',','.',$TxtFactor);	
			$Actualizar="UPDATE pcip_svp_productos_procedencias set num_orden='".$CmbOrden."',orden=".$TxtOrden.",ano='".$Ano."', signo='".$CmbSigno."', factor='".$Factor."', nodo='0' where correlativo='".$Cod[0]."' and cod_asignacion='".$Cod[1]."' and cod_procedencia='".$Cod[2]."' and cod_negocio='".$Cod[3]."' and num_orden='".$Cod[4]."' and origen='".$Cod[6]."'";
			//echo $Actualizar."<br>";
			mysql_query($Actualizar);
			$Codigos=$Cod[0]."~".$Cod[1]."~".$Cod[2]."~".$Cod[3]."~".$CmbOrden."~".$TxtOrden."~".$Cod[6];
		}
		if($Cod[6]=='ENA' || $Cod[6]=='PMN')
		{
			if($TxtOrden=='')
				$TxtOrden='NULL';
			$Factor=str_replace(',','.',$TxtFactor);	
			$Actualizar="UPDATE pcip_svp_productos_procedencias set num_orden='".$CmbOrden."', orden=".$TxtOrden.", ano='".$Ano."', num_orden_relacionada='".$CmbProducto."', signo='".$CmbSigno."', factor='".$Factor."', nodo='".$CmbNodo."' where correlativo='".$Cod[0]."' and cod_asignacion='".$Cod[1]."' and cod_procedencia='".$Cod[2]."' and cod_negocio='".$Cod[3]."' and num_orden='".$Cod[4]."' and origen='".$Cod[6]."'";
			//echo $Actualizar."<br>";
			mysql_query($Actualizar);
			$Codigos=$Cod[0]."~".$Cod[1]."~".$Cod[2]."~".$Cod[3]."~".$CmbOrden."~".$Cod[7]."~".$Cod[6];
		}
		header('location:pcip_mantenedor_asignaciones_proceso.php?Opcion=M&Mensaje=2&Codigos='.$Codigos);
	break;
	case "E":
		$Mensaje='1';
		//echo $CodigoEnviar."<br>";
		$Datos = explode("//",$CodigoEnviar);
		while (list($clave,$Codigo)=each($Datos))
		{		
			$Cod=explode('~',$Codigo);
			if($Cod[6]=='SVP')
			{
				$Eliminar="delete from pcip_svp_productos_procedencias where correlativo='".$Cod[0]."' and cod_asignacion='".$Cod[1]."' and  cod_procedencia='".$Cod[2]."' and cod_negocio='".$Cod[3]."' and num_orden='".$Cod[4]."' and num_orden_relacionada='".$Cod[5]."' and origen='".$Cod[6]."' and vptm='".$Cod[7]."'";	
				mysql_query($Eliminar);
				//echo $Eliminar."<br>";
			}
			else
				$Eliminar="delete from pcip_svp_productos_procedencias where correlativo='".$Cod[0]."' and cod_asignacion='".$Cod[1]."' and  cod_procedencia='".$Cod[2]."' and cod_negocio='".$Cod[3]."' and num_orden='".$Cod[4]."' and origen='".$Cod[6]."'";	
				mysql_query($Eliminar);
				//echo $Eliminar."<br>";
		}
		header("location:pcip_mantenedor_asignaciones.php?Mensaje=".$Mensaje."&Buscar=S&CmbProd=".$CmbProd."&CmbAsig=".$CmbAsig."&Ano=".$Ano);
	break;
}

?>