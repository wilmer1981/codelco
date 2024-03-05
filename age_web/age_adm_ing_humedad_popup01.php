<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	
	
	//------------------------PREPARAMOS PARA INGRESAR DATOS-------------------------
	//AGE_WEB LEYES POR LOTE
	$VHumedadAux=str_replace(',','.',$VHumedad);
	$Inserta="INSERT INTO age_web.leyes_por_lote (lote,recargo,cod_leyes,valor,cod_unidad,valor2,provisional,modificado,ano)";
	$Inserta.=" values('".$Lote."','".$Recargo."','01','".$VHumedadAux."','1','0','','','".substr($SA,0,4)."')";
	mysqli_query($link, $Inserta);
	
	
	//--------------------------------CALIDAD-------------------------------- SOLICITUD ANALISIS
	$Consulta="select * from cal_web.solicitud_analisis where nro_solicitud='".$SA."' and id_muestra='".$Lote."' and recargo='0'";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
		$Insertar.="leyes,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
		$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
		$Insertar.= "'".$Fila["rut_funcionario"]."','".$Fila["fecha_hora"]."','".$Lote."','".$Recargo."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','01~~1//','1',";			
		$Insertar.= "'3','A','".$SA."','80','FF621','1','6','".$Fila["rut_proveedor"]."','','1','".$Fila[fecha_muestra]."')";
		//echo $Insertar."<br><BR>";
		mysqli_query($link, $Insertar);

		//--------------------------------LEYES POR SOLICITUD--------------------------------
		$Resp2=mysqli_query($link, "select peso_neto from age_web.detalle_lotes where lote='".$Lote."' and recargo='".$Recargo."'");
		$FilaLote=mysqli_fetch_array($Resp2);
		$PesoNeto=$FilaLote[peso_neto];
		$PesoSeco=($PesoNeto*$VHumedad)/100;
		$PesoSeco=$PesoNeto-$PesoSeco;
		
		$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra,peso_humedo,valor,peso_seco,rut_quimico,candado) values (";
		$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["fecha_hora"]."','".$Fila["nro_solicitud"]."','".$Recargo."','01','1','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','".$Lote."','".$PesoNeto."','".$VHumedadAux."','".round($PesoSeco)."','".$Fila["rut_funcionario"]."','1')";
		//echo $Insertar2."<br><BR><BR><BR>";
		mysqli_query($link, $Insertar2);
		
		//------------------------ESTADOS POR SOLICITUD--------------------------
		$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
		$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["nro_solicitud"]."','".$Recargo."','1','".$Fila["fecha_hora"]."','N','".$Fila["rut_funcionario"]."')";
		//echo $Insertar2."<br><BR>";
		mysqli_query($link, $Insertar2);			
		$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
		$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["nro_solicitud"]."','".$Recargo."','4','".$Fila["fecha_hora"]."','N','".$Fila["rut_funcionario"]."')";
		//echo $Insertar2."<br><BR>";
		mysqli_query($link, $Insertar2);			
		$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
		$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["nro_solicitud"]."','".$Recargo."','5','".$Fila["fecha_hora"]."','N','".$Fila["rut_funcionario"]."')";
		//echo $Insertar2."<br><BR>";
		mysqli_query($link, $Insertar2);			
		$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
		$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["nro_solicitud"]."','".$Recargo."','6','".$Fila["fecha_hora"]."','N','".$Fila["rut_funcionario"]."')";
		//echo $Insertar2."<br><BR>";
		mysqli_query($link, $Insertar2);
		
		//------------------------------REGISTROS LEYES------------------------------------------
		$Insertar2="INSERT INTO cal_web.registro_leyes(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,valor,peso_humedo,peso_seco,candado,signo,rut_proceso) values (";
		$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["fecha_hora"]."','".$Fila["nro_solicitud"]."','".$Recargo."','01','1','".$VHumedadAux."','".$PesoNeto."','".round($PesoSeco)."','1','=','".$Fila["rut_funcionario"]."')";
		//echo $Insertar2."<br><BR>";
		mysqli_query($link, $Insertar2);
	}
	echo "<script language='JavaScript'>";
	echo "window.opener.document.frmPrincipal.action='age_adm_ing_humedad.php?TxtLote=".$Lote."&Petalo=H&EsPopup=';";
	echo "window.opener.document.frmPrincipal.submit();";
	echo "window.close();";
	echo "</script>";			
?>