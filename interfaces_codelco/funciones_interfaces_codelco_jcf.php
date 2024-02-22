<?php
function Homologar($ProdAux, $SubProdAux, $CodSap, $Unidad, $CentroHomo, $CodEmpaque)
{
	$Consulta = "select * from interfaces_codelco.homologacion ";
	$Consulta.= " where cod_producto ='".$ProdAux."' and cod_subproducto = '".$SubProdAux."'";
	
	$RespAux = mysqli_query($link, $Consulta);
	if ($FilaAux = mysqli_fetch_array($RespAux))
	{
	
		$CodSap = $FilaAux["materiales_sap"];
		$Unidad = $FilaAux["unidad_medida_sap"];
		
		$CentroHomo = $FilaAux["centro"];
		$CodEmpaque = $FilaAux["cod_empaque"];
	}
	else
	{
	
		$CodSap = "3";
		$CentroHomo = "FV01";
		$CodEmpaque = "02";
	}
}

function OrdenProduccionSap($Asignacion,$Prod,$SubProd,$OrdenProd,$CodMatSAP,$UnidSAP,$ClaseValorAux,$Centro)	
{
	$Consulta = "select * from interfaces_codelco.ordenes_produccion ";
	$Consulta.= " where cod_producto ='".$Prod."' and cod_subproducto = '".$SubProd."'";
	$Consulta.= " and asignacion='".$Asignacion."'";
	if ($OrdenProd!="")
		$Consulta.= " and codigo_op='".$OrdenProd."'";
		//echo "consulra".$Consulta;
    $RespAux = mysqli_query($link, $Consulta);
    if ($FilaAux = mysqli_fetch_array($RespAux))
	{
		$OrdenProd = $FilaAux["codigo_op"];
		$CodMatSAP = $FilaAux["cod_material_sap"];
		$UnidSAP = $FilaAux["unidad_medida"];
		$ClaseValorAux = $FilaAux["clase_valorizacion"];
		$Centro = $FilaAux["centro"];
	}
	else
	{
		$Consulta = "select * from  interfaces_codelco.ordenes_produccion ";
		$Consulta.= " where cod_producto ='".$Prod."' and cod_subproducto = '0'";
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux = mysqli_fetch_array($RespAux))
		{
			$OrdenProd = $FilaAux["codigo_op"];
			$CodMatSAP = $FilaAux["cod_material_sap"];
			$UnidSAP = $FilaAux["unidad_medida"];
			$ClaseValorAux = $FilaAux["clase_valorizacion"];
			$Centro = $FilaAux["centro"];
			
		}
		else
		{
			$OrdenProd = "F6000";
			$CodMatSAP = $Prod."-".$SubProd."99";
			$UnidSAP = "TO ";
			$ClaseValorAux = "FRVCUTERC";
			$Centro = "FV01";
		}
    }
	//echo $Consulta;
}

function RescataCatodos($ProdAux, $SubProdAux, $AnoAux, $MesAux, $Arreglo, $IdLote, $ArregloLeyes, $Orden)
{		
	if ($ProdAux!="")
		DefinirArregloLeyes($ProdAux, $SubProdAux, &$ArregloLeyes);	
	else
		DefinirArregloLeyes("18", $SubProdAux, &$ArregloLeyes);	
	$Consulta = "select  t0.cod_bulto, t0.num_bulto, t0.cod_marca, t0.corr_enm, t3.abreviatura as descripcion, tt.fecha_disponible, ";
	$Consulta.= " tt.cod_producto, tt.cod_subproducto, t2.fecha_guia,sum(t1.peso_paquetes) As peso, ["fecha_creacion_lote"], tt.cod_puerto, tt.cod_puerto_destino, ";
	$Consulta.= " count(t0.num_paquete) as num_paquetes, sum(t1.num_unidades) as num_unidades, t4.descripcion as descrip_marca, tt.cod_contrato_maquila as asignacion ";
	$Consulta.= " from interfaces_codelco.asignaciones t inner join sec_web.programa_codelco tt on t.asignacion=tt.cod_contrato_maquila ";
	$Consulta.= " inner join sec_web.lote_catodo t0 on tt.corr_codelco=t0.corr_enm ";
	$Consulta.= " inner join sec_web.paquete_catodo t1 ";
	$Consulta.= " ON t0.cod_paquete=t1.cod_paquete and t0.num_paquete=t1.num_paquete ";
	$Consulta.= " and t0.fecha_creacion_paquete=t1.fecha_creacion_paquete ";
	$Consulta.= " left join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia ";
	$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on tt.cod_producto=t3.cod_producto and tt.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " inner join sec_web.marca_catodos t4 on t0.cod_marca=t4.cod_marca ";
	$Consulta.= " where tt.fecha_disponible between '".$AnoAux."-".$MesAux."-01' and '".$AnoAux."-".$MesAux."-31' ";
	$Consulta.= " and t.salida<>'' and tt.estado2 IN ('C','T')";
	if ($ProdAux=="" && $SubProdAux=="")
		$Consulta.= " and tt.cod_producto in (18)  ";
	else
	{
		$Consulta.= " and tt.cod_producto='".$ProdAux."' ";
		if ($SubProdAux!="S")
			$Consulta.= " and tt.cod_subproducto='".$SubProdAux."' ";
	}
	if ($IdLote!="")
	{
		$ValorId = explode("/",$IdLote);
		$Consulta.= " and (t0.cod_bulto='".$ValorId[0]."' and t0.num_bulto='".$ValorId[1]."') ";
	}
	$Consulta.= " group by tt.cod_producto,tt.cod_subproducto, t0.cod_bulto,t0.num_bulto";	

	switch ($Orden)
	{
		case "F":
			$Consulta.= " order by tt.cod_producto,tt.cod_subproducto,tt.fecha_disponible ";
			break;
		case "L":
			$Consulta.= " order by tt.cod_producto,tt.cod_subproducto,t0.corr_enm ";
			break;
		default:
			$Consulta.= " order by tt.cod_producto,tt.cod_subproducto,t0.corr_enm ";
			break;
	}
	//echo $Consulta;
	$RespAux = mysqli_query($link, $Consulta);
	$i=0;
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{
		//echo "LOTE=".$FilaAux["num_bulto"]." PESO=".($FilaAux["peso"]/1000)." NUM_PAQ=".$FilaAux["num_paquetes"]." NUM_UNID.".$FilaAux["num_unidades"];	
		$Arreglo[$i]["cod_producto"] = $FilaAux["cod_producto"];
		$Arreglo[$i]["cod_subproducto"] = $FilaAux["cod_subproducto"];
		$Arreglo[$i]["descripcion"] = $FilaAux["descripcion"];
		$Arreglo[$i]["cod_bulto"] = $FilaAux["cod_bulto"];
		$Arreglo[$i]["num_bulto"] = $FilaAux["num_bulto"];
		$Arreglo[$i]["fecha_embarque"] = $FilaAux["fecha_disponible"];
		$Arreglo[$i]["peso"] = $FilaAux["peso"]/1000;
		$Arreglo[$i]["["fecha_creacion_lote"]"] = $FilaAux["["fecha_creacion_lote"]"];
		$Arreglo[$i]["corr_enm"] = $FilaAux["corr_enm"];
		$Arreglo[$i]["lote"] = $FilaAux["cod_bulto"]."-".str_pad($FilaAux["num_bulto"],6,'0',STR_PAD_LEFT);
		$Arreglo[$i]["num_paquetes"] = $FilaAux["num_paquetes"]/1000;
		$Arreglo[$i]["num_unidades"] = $FilaAux["num_unidades"];
		$Arreglo[$i]["cod_marca"] = $FilaAux["cod_marca"];
		$Arreglo[$i]["descrip_marca"] = $FilaAux["descrip_marca"];
		$Arreglo[$i]["asignacion"] = $FilaAux["asignacion"];
		$Arreglo[$i]["cod_puerto"] = $FilaAux["cod_puerto"];
		$Arreglo[$i]["cod_puerto_destino"] = $FilaAux["cod_puerto_destino"];
		//ALMACEN CODELCO
		$Consulta = "select * from interfaces_codelco.relacion_almacen ";
		$Consulta.= " where cod_destino='".$FilaAux["cod_puerto"]."'";
		$RespPto=mysqli_query($link, $Consulta);
		//echo $Consulta;
		if ($FilaPto=mysqli_fetch_array($RespPto))
		{
			$Arreglo[$i]["cod_almacen_codelco"] = $FilaPto["cod_almacen_codelco"];	
			$Arreglo[$i]["desc_almacen_codelco"] = $FilaPto["abreviatura"];	
		}
		else
		{
			$Consulta = "select * from interfaces_codelco.relacion_almacen ";
			$Consulta.= " where cod_almacen_codelco='0005'";
			$RespPto=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if ($FilaPto=mysqli_fetch_array($RespPto))
			{
				$Arreglo[$i]["cod_almacen_codelco"] = $FilaPto["cod_almacen_codelco"];	
				$Arreglo[$i]["desc_almacen_codelco"] = $FilaPto["abreviatura"];	
			}
		}
		//CONSULTA LAS LEYES
		$Consulta = "select * from sec_web.solicitud_certificado t1 inner join  sec_web.certificacion_catodos t2 ";
		$Consulta.= " on t1.num_certificado=t2.num_certificado and t1.version=t2.version ";
		$Consulta.= " where t1.corr_enm = '".$FilaAux["corr_enm"]."'( and ";
		reset($ArregloLeyes);
		while (list($k,$v)=each($ArregloLeyes))
		{
			$Consulta.= " t2.cod_leyes='".$v["cod_leyes"]."' or";
		}
		$Consulta = substr($Consulta,0,strlen($Consulta)-2).")";
		//echo $Consulta."<br>";
		$Resp2 = mysqli_query($link, $Consulta);
		$ConLeyes = "N";
		$NumCertificado = "";
		$ArregloLeyes["02"]["cod_leyes"] = "02";
		$ArregloLeyes["02"]["valor"] = 99.99;
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$NumCertificado = $Fila2["num_certificado"];
			$ConLeyes = "S";
			$ArregloLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"];						
		}
		$Arreglo[$i]["con_leyes"] = $ConLeyes;
		$Arreglo[$i]["num_certificado"] = $NumCertificado;
		$i++;
	}
}

function RescataPlamen($ProdAux, $SubProdAux, $AnoAux, $MesAux, $Arreglo, $IdLote, $ArregloLeyes)
{
	//echo $ProdAux." - ".$SubProdAux." - ".$IdLote."<br>";
	if (($ProdAux=="" && $SubProdAux=="") || ($ProdAux=="34" && $SubProdAux=="2"))
	{
		if ($ProdAux!="")
			DefinirArregloLeyes($ProdAux, $SubProdAux, &$ArregloLeyes);	
		else
			DefinirArregloLeyes("34", $SubProdAux, &$ArregloLeyes);	
		//RESCATA ORO
		$Consulta = "select * from pmn_web.embarque_oro ";
		$Consulta.= " where fecha between '".$AnoAux."-".$MesAux."-01' and '".$AnoAux."-".$MesAux."-31' ";
		if ($IdLote!="")
			$Consulta.= " and num_barra='".$IdLote."'";
		$RespAux = mysqli_query($link, $Consulta);
		$i=0;
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{
			$Arreglo[$i]["cod_producto"] = "34";
			$Arreglo[$i]["cod_subproducto"] = "2";
			$Arreglo[$i]["descripcion"] = "BARRAS ORO";
			$Arreglo[$i]["cod_bulto"] = "";
			$Arreglo[$i]["num_bulto"] = "";
			$Arreglo[$i]["fecha_embarque"] = $FilaAux["fecha"];
			$Arreglo[$i]["peso"] = $FilaAux["peso_neto_barra"]*1000;
			$Arreglo[$i]["["fecha_creacion_lote"]"] = "";
			$Arreglo[$i]["num_paquetes"] = (($FilaAux["peso_bruto_caja"]/2)-$FilaAux["peso_neto_barra"])*1000;
			$Arreglo[$i]["num_unidades"] = 1;
			$Arreglo[$i]["corr_enm"] = "";
			$Arreglo[$i]["lote"] = $FilaAux["num_barra"];
			$Arreglo[$i]["sello"] = $FilaAux["num_sello"];
			$Arreglo[$i]["asignacion"] = "PMN";
			//CONSULTA LEYES
			$Consulta = " select distinct t3.nro_solicitud, t3.id_muestra,t4.cod_leyes, t4.cod_unidad, t4.valor ";
			$Consulta.= " FROM  pmn_web.carga_fusion_oro t2  ";
			$Consulta.= " INNER JOIN cal_web.solicitud_analisis t3 ";		
			$Consulta.= " ON (t2.num_electrolisis = t3.id_muestra or t2.num_barra=t3.id_muestra) AND t3.cod_periodo = '1' AND t3.agrupacion = '5' AND t3.estado_actual = '6' ";
			$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t4 ";
			$Consulta.= " ON t3.cod_producto = t4.cod_producto AND t3.cod_subproducto = t4.cod_subproducto ";
			$Consulta.= " AND t3.nro_solicitud = t4.nro_solicitud AND t3.id_muestra = t4.id_muestra ";
			$Consulta.= " AND t3.fecha_hora = t4.fecha_hora AND t3.rut_funcionario = t4.rut_funcionario ";	
			$Consulta.= " WHERE t3.cod_producto = '34' AND t3.cod_subproducto = '2'";
			$Consulta.= " and t2.num_barra='".$FilaAux["num_barra"]."' and ( ";
			reset($ArregloLeyes);
			while (list($k,$v)=each($ArregloLeyes))
			{
				$Consulta.= " t4.cod_leyes='".$v["cod_leyes"]."' or";
			}
			$Consulta = substr($Consulta,0,strlen($Consulta)-2).")";
			$Consulta.= " ORDER BY t3.nro_solicitud ";
			//echo $Consulta."<br>";
			$Resp2 = mysqli_query($link, $Consulta);
			$ConLeyes = "N";
			$NumCertificado = "";
			$ArregloLeyes["05"]["cod_leyes"] = "05";
			$ArregloLeyes["05"]["valor"] = 99.99;
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$NumCertificado = $Fila2["nro_solicitud"];
				$ConLeyes = "S";
				$ArregloLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"];
				$IdMuestra=$Fila2["id_muestra"];		
			}
			$Consulta="select ifnull(count(*),0) as cant_rem from cal_web.solicitud_analisis";
			$Consulta.= " where	nro_solicitud='$NumCertificado' and id_muestra='".$IdMuestra."R-"."%'";		
			$Resp3=mysqli_query($link, $Consulta);
			$FilaCant=mysqli_fetch_array($Resp3);
			$ContRem=$FilaCant[cant_rem];
			if($ContRem>0)
			{
				if($ContRem==1)
					$Muestras="in ('".$IdMuestra."','".$IdMuestra."R-1')";
				else
					$Muestras="in ('".$IdMuestra."R-".($ContRem-1)."','".$IdMuestra."R-".$ContRem."')";			
				$Consulta="select cod_leyes,sum(t2.valor)/2 as valor_ley from cal_web.solicitud_analisis AS t1";
				$Consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t2";
				$Consulta.= " ON t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
				$Consulta.= " AND t1.nro_solicitud = t2.nro_solicitud AND t1.id_muestra = t2.id_muestra";
				$Consulta.= " AND t1.fecha_hora = t2.fecha_hora AND t1.rut_funcionario = t2.rut_funcionario ";
				$Consulta.= " where	t1.id_muestra ".$Muestras." and t1.cod_producto = '34' AND t1.cod_subproducto = '2' group by cod_leyes";		
				$Resp4=mysqli_query($link, $Consulta);
				while($Fila4=mysqli_fetch_array($Resp4))
				{
					$ArregloLeyes[$Fila4["cod_leyes"]]["valor"] = $Fila4["valor_ley"];
				}
			}
			$Arreglo[$i]["con_leyes"] = $ConLeyes;
			$Arreglo[$i]["num_certificado"] = $NumCertificado;
			$i++;
		}
	}
		
	//EMBARQUE PLATA
	if (($ProdAux=="" && $SubProdAux=="") || ($ProdAux=="29" && $SubProdAux=="4"))
	{
		$Datos=explode("//",$IdLote);
		$IdLote=$Datos[0];
		$NumActa=$Datos[1];
		//(echo "lote".$IdLote."-".$NumActa;
		if ($ProdAux!="")
			DefinirArregloLeyes($ProdAux, $SubProdAux, &$ArregloLeyes);	
		else
			DefinirArregloLeyes("29", $SubProdAux, &$ArregloLeyes);	
		$Consulta = "select * ";
		$Consulta.= " from pmn_web.embarque_plata t1 inner join pmn_web.detalle_embarque_plata t2 ";
		$Consulta.= " on t1.num_acta=t2.num_acta ";
		$Consulta.= " where t1.fecha between '".$AnoAux."-".$MesAux."-01' and '".$AnoAux."-".$MesAux."-31'";
		if ($IdLote!="")
		{
			$Consulta.= " and t2.num_electrolisis='".$IdLote."'";
			$Consulta.= " and t1.num_acta='".$NumActa."'";
		}
		$RespAux = mysqli_query($link, $Consulta);
		//echo $Consulta;
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{
			$Arreglo[$i]["cod_producto"] = "29";
			$Arreglo[$i]["cod_subproducto"] = "4";
			$Arreglo[$i]["descripcion"] = "ELECT. PLATA";
			$Arreglo[$i]["cod_bulto"] = "";
			$Arreglo[$i]["num_bulto"] = "";
			$Arreglo[$i]["fecha_embarque"] = $FilaAux["fecha"];
			$Arreglo[$i]["peso"] = $FilaAux["cantidad"] * 25;

			$Arreglo[$i]["num_paquetes"] = $FilaAux["cantidad"];
			$Arreglo[$i]["num_unidades"] = 1;
			
			$Arreglo[$i]["caja_ini"] = $FilaAux["caja_ini"];
			$Arreglo[$i]["caja_fin"] = $FilaAux["caja_fin"];
			
			$PesoTotalActa = $FilaAux["peso"];
			$Arreglo[$i]["["fecha_creacion_lote"]"] = "";
			$Arreglo[$i]["corr_enm"] = "";
			$Arreglo[$i]["lote"] = $FilaAux["num_electrolisis"];
			$Arreglo[$i]["num_acta"] = $FilaAux["num_acta"];
			$Arreglo[$i]["asignacion"] = "PMN";
			//CONSULTO LEYES
			$Consulta = " select distinct t3.nro_solicitud, t3.recargo, t3.id_muestra,t2.num_electrolisis, t2.cantidad, t5.cod_leyes, t5.cod_unidad, t5.valor ";
			$Consulta.= " FROM pmn_web.embarque_plata AS t1";
			$Consulta.= " LEFT JOIN pmn_web.detalle_embarque_plata AS t2";
			$Consulta.= " ON t1.num_acta = t2.num_acta AND YEAR(t1.fecha) = t2.ano AND MONTH(t1.fecha) = t2.mes ";
			$Consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t3";
			$Consulta.= " ON t2.num_electrolisis = t3.id_muestra AND t3.cod_producto = '29' AND t3.cod_subproducto = '4'";
			$Consulta.= " AND t3.cod_periodo = '1' AND t3.agrupacion = '5'";
			$Consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t5";
			$Consulta.= " ON t3.cod_producto = t5.cod_producto AND t3.cod_subproducto = t5.cod_subproducto";
			$Consulta.= " AND t3.nro_solicitud = t5.nro_solicitud AND t3.id_muestra = t5.id_muestra";
			$Consulta.= " AND t3.fecha_hora = t5.fecha_hora AND t3.rut_funcionario = t5.rut_funcionario ";			
			$Consulta.= " WHERE YEAR(t1.fecha) = '".$AnoAux."' ";//AND MONTH(t1.fecha) = '".$MesAux."'";
			$Consulta.= " and t1.num_acta='".$FilaAux["num_acta"]."'";
// 			agregar funcion length para saber largo de num_electrolisis
			$Consulta.= " AND ((t2.num_electrolisis = '".$FilaAux["num_electrolisis"]."') || "; 
			$largo = strlen($FilaAux[num_electrolisis]);
			$ini= 0;
			$largo2 = 0;
			$AuxElectrolisis = $FilaAux[num_electrolisis];
			if (substr($AuxElectrolisis,0,4)=='0000')
			{
				$largo2 = $largo - 4;
				$AuxElectrolisis = substr($AuxElectrolisis,4,$largo2);
			}
			if (substr($AuxElectrolisis,0,3)=='000')
			{
				$largo2 = $largo - 3;
				$AuxElectrolisis=  substr($AuxElectrolisis,3,$largo2);
			}
			if (substr($AuxElectrolisis,0,2)=='00')
			{	
				$largo2 = $largo - 2;
				$AuxElectrolisis = substr($AuxElectrolisis,2,$largo2);
			}
			if (substr($AuxElectrolisis,0,1)=='0')
			{
				$largo2 = $largo - 1;
				$AuxElectrolisis = substr($AuxElectrolisis,1,$largo2);
			}
			$Consulta.=" (t2.num_electrolisis = '".$AuxElectrolisis."')) and (";
			reset($ArregloLeyes);
			while (list($k,$v)=each($ArregloLeyes))
			{
				$Consulta.= " t5.cod_leyes='".$v["cod_leyes"]."' or";
			}
			$Consulta = substr($Consulta,0,strlen($Consulta)-2).")";
			$Consulta.= " ORDER BY t3.nro_solicitud ";
			//echo "kkkk".$Consulta."-".$largo."--".$largo2."<br>";
			$Resp2 = mysqli_query($link, $Consulta);
			$ConLeyes = "N";
			$NumCertificado = "";			
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$NumCertificado = $Fila2["nro_solicitud"];//."~~";
				$NumRecargo = $Fila2["recargo"];
				$ConLeyes = "S";
				//$ArregloLeyes[$Fila2["cod_leyes"]]["valor"] = $ArregloLeyes[$Fila2["cod_leyes"]]["valor"] + ($Fila2["valor"] * ($Fila2["cantidad"]*25));	
				$ArregloLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"];
				$IdMuestra=$Fila2["id_muestra"];	
			}
			$Consulta="select ifnull(count(*),0) as cant_rem from cal_web.solicitud_analisis";
			$Consulta.= " where	nro_solicitud='$NumCertificado' and id_muestra='".$IdMuestra."R-"."%'";		
			$Resp3=mysqli_query($link, $Consulta);
			$FilaCant=mysqli_fetch_array($Resp3);
			$ContRem=$FilaCant[cant_rem];
			if($ContRem>0)
			{
				if($ContRem==1)
					$Muestras="in ('".$IdMuestra."','".$IdMuestra."R-1')";
				else
					$Muestras="in ('".$IdMuestra."R-".($ContRem-1)."','".$IdMuestra."R-".$ContRem."')";			
				$Consulta="select cod_leyes,sum(t2.valor)/2 as valor_ley from cal_web.solicitud_analisis AS t1";
				$Consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t2";
				$Consulta.= " ON t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
				$Consulta.= " AND t1.nro_solicitud = t2.nro_solicitud AND t1.id_muestra = t2.id_muestra";
				$Consulta.= " AND t1.fecha_hora = t2.fecha_hora AND t1.rut_funcionario = t2.rut_funcionario ";
				$Consulta.= " where	t1.id_muestra ".$Muestras." and t1.cod_producto = '29' AND t1.cod_subproducto = '4' group by cod_leyes";		
				$Resp4=mysqli_query($link, $Consulta);
				while($Fila4=mysqli_fetch_array($Resp4))
				{
					$ArregloLeyes[$Fila4["cod_leyes"]]["valor"] = $Fila4["valor_ley"];
				}
			}
			$Arreglo[$i]["con_leyes"] = $ConLeyes;
			$Arreglo[$i]["num_certificado"] = $NumCertificado;
			$Arreglo[$i]["num_recargo"] = $NumRecargo;
			$i++;
		}
		reset($ArregloLeyes);
		do {			 
			$key = key ($ArregloLeyes);
		  	if ($key=="04")
			{
				$ArregloLeyes[$key]["valor"] = 99.99;
			}
			else
			{
				/*if ($ArregloLeyes[$key]["valor"]>0 && $PesoTotalActa>0)
					$ArregloLeyes[$key]["valor"] = $ArregloLeyes[$key]["valor"]/21;
				else
					$ArregloLeyes[$key]["valor"] = 0;*/
			}
			 
		} while (next($ArregloLeyes));		
	}
	//PALADIO-PLATINO, ESCORIA, SELENI, TELURO, BARRO ANODICO CRUDO
	if (($ProdAux=="" && $SubProdAux=="") || ($ProdAux=="33" && $SubProdAux=="2") || ($ProdAux=="31" && $SubProdAux=="1") ||
		($ProdAux=="47" && $SubProdAux=="1") || ($ProdAux=="28" && $SubProdAux=="1") /*|| ($ProdAux=="24" && $SubProdAux=="9")*/)
	{
		if ($ProdAux!="")
			DefinirArregloLeyes($ProdAux, $SubProdAux, &$ArregloLeyes);	
		else
			DefinirArregloLeyes("", $SubProdAux, &$ArregloLeyes);
		//TABLA PRODUCCION_SUBPRODUCTOS
		$Consulta = "select * from pmn_web.produccion_subproductos t1";
		$Consulta.= " inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
		$Consulta.= " where t1.fecha_venta between '".$AnoAux."-".$MesAux."-01' and '".$AnoAux."-".$MesAux."-31'";
		//echo "CCC".$Consulta;
		if ($IdLote!="")
			$Consulta.= " and numero='".$IdLote."'";
		if ($ProdAux=="" && $SubProdAux=="")
		{
			$Consulta.= " and ((t1.cod_producto='33' and t1.cod_subproducto='2') or ";
			$Consulta.= " (t1.cod_producto='31' and t1.cod_subproducto='1') or ";
			$Consulta.= " (t1.cod_producto='47' and t1.cod_subproducto='1') or ";
			$Consulta.= " (t1.cod_producto='28' and t1.cod_subproducto='1'))";
			
		}
		else
		{
			$Consulta.= " and (t1.cod_producto='".$ProdAux."' and t1.cod_subproducto='".$SubProdAux."') ";
		}
		$Consulta.= " order by lpad(t1.cod_producto,3,'0'), lpad(t1.cod_subproducto,3,'0'), t1.numero";
		//echo $Consulta."<br>";
		$RespAux = mysqli_query($link, $Consulta);
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{
			$Arreglo[$i]["cod_producto"] = $FilaAux["cod_producto"];
			$Arreglo[$i]["cod_subproducto"] = $FilaAux["cod_subproducto"];
			$Arreglo[$i]["descripcion"] = $FilaAux["abreviatura"];
			$Arreglo[$i]["cod_bulto"] = "";
			$Arreglo[$i]["num_bulto"] = "";
			$Arreglo[$i]["fecha_embarque"] = $FilaAux["fecha_venta"];		
			$Arreglo[$i]["["fecha_creacion_lote"]"] = "";
			$Arreglo[$i]["corr_enm"] = "";
			$Arreglo[$i]["lote"] = $FilaAux["numero"];
			$Arreglo[$i]["asignacion"] = "PMN";
			//CONSULTA LEYES
			$Consulta = " select distinct t2.nro_solicitud, t2.recargo, t3.cod_leyes, t3.valor, t3.cod_unidad ";
			$Consulta.= " FROM pmn_web.produccion_subproductos AS t1";
			$Consulta.= " INNER JOIN cal_web.solicitud_analisis AS t2";
			$Consulta.= " ON case when ((t1.cod_producto = '31' and t1.cod_subproducto='1') or (t1.cod_producto = '33' and t1.cod_subproducto='2') or (t1.cod_producto = '24' and t1.cod_subproducto='9') or (t1.cod_producto ='47' and t1.cod_subproducto='1'))";
			$Consulta.= " then (t2.id_muestra='".$FilaAux["numero"]."' or t2.nro_solicitud ='".$FilaAux["id_analisis"]."') ";
			$Consulta.= " else ((t2.id_muestra='".$FilaAux["id_analisis"]."') or ( ";	
			$Consulta.= " t2.nro_solicitud='".$FilaAux["id_analisis"]."')) end ";	
			$Consulta.= " AND t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
			$Consulta.= " AND t2.cod_periodo = '1' AND (t2.recargo = '0' or t2.recargo = '' or t2.recargo='1')";
			$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t3";
			$Consulta.= " ON t2.nro_solicitud = t3.nro_solicitud AND  t2.recargo = t3.recargo";
			$Consulta.= " WHERE t1.cod_producto = '".$FilaAux["cod_producto"]."' AND t1.cod_subproducto = '".$FilaAux["cod_subproducto"]."'";
			$Consulta.= " AND t1.fecha_venta BETWEEN '".$AnoAux."-".$MesAux."-01' AND '".$AnoAux."-".$MesAux."-31' ";			
			$Consulta.= " AND (t2.recargo='0' or t2.recargo='' or t2.recargo = '1') and ( ";
			reset($ArregloLeyes);
			while (list($k,$v)=each($ArregloLeyes))
			{
				$Consulta.= " t3.cod_leyes='".$v["cod_leyes"]."' or";
			}
			$Consulta = substr($Consulta,0,strlen($Consulta)-2).")";
			$Consulta.= " ORDER BY t2.nro_solicitud,t2.recargo";	
			//echo $Consulta."<br>";		
			$Resp2 = mysqli_query($link, $Consulta);
			$ConLeyes = "N";
			$NumCertificado = "";
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				if ($Fila2["cod_leyes"]=="01")
					$LeyHum = $Fila2["valor"];
				if ($NumCertificado=="")
				{
					$NumCertificado = $Fila2["nro_solicitud"];
					$NumRecargo=$Fila2["recargo"];
				}
				else
				{
					if ($NumCertificado!=$Fila2["nro_solicitud"])
						$NumCertificado = $NumCertificado.$Fila2["nro_solicitud"]."~~";
				}
				$ConLeyes = "S";

				if ($Fila2["cod_leyes"]=="04" || $Fila2["cod_leyes"]=="05")
				{
				     $ArregloLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"] * 1000;
				}
				
				else
				{
					$ArregloLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"];	
				}
			}
			$Arreglo[$i]["peso"] = $FilaAux["peso"]; //jcf- (($FilaAux["peso"]*$LeyHum)/100);
			$Arreglo[$i]["con_leyes"] = $ConLeyes;
			$Arreglo[$i]["num_certificado"] = $NumCertificado;
			$Arreglo[$i]["num_recargo"] = $NumRecargo;
			$Arreglo[$i]["peso_tara"] = $FilaAux["peso_tara"];
			$i++;
		}
		}
		//producto barro anodico poly jf
		if ($ProdAux=="24" && $SubProdAux=="9")
		{
		
			if ($ProdAux!="")
				DefinirArregloLeyes($ProdAux, $SubProdAux, &$ArregloLeyes);	
			else
				DefinirArregloLeyes("", $SubProdAux, &$ArregloLeyes);
			//TABLA PRODUCCION_SUBPRODUCTOS
			$Consulta = "select * from pmn_web.produccion_subproductos t1";
			$Consulta.= " inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta.= " where t1.fecha_venta between '".$AnoAux."-".$MesAux."-01' and '".$AnoAux."-".$MesAux."-31'";
			if ($IdLote!="")
				$Consulta.= " and numero='".$IdLote."'";
			if ($ProdAux=="" && $SubProdAux=="")
			{
				$Consulta.= " (r1.cod_producto='24' and t1.cod_subproducto='9')";
			}
			else
			{
				$Consulta.= " and (t1.cod_producto='".$ProdAux."' and t1.cod_subproducto='".$SubProdAux."') ";
			}
			$Consulta.= " order by lpad(t1.cod_producto,3,'0'), lpad(t1.cod_subproducto,3,'0'), t1.numero";
			//echo $Consulta."<br>";
			$RespAux = mysqli_query($link, $Consulta);
			while ($FilaAux = mysqli_fetch_array($RespAux))
			{
				$Arreglo[$i]["cod_producto"] = $FilaAux["cod_producto"];
				$Arreglo[$i]["cod_subproducto"] = $FilaAux["cod_subproducto"];
				$Arreglo[$i]["descripcion"] = $FilaAux["abreviatura"];
				$Arreglo[$i]["cod_bulto"] = "";
				$Arreglo[$i]["num_bulto"] = "";
				$Arreglo[$i]["fecha_embarque"] = $FilaAux["fecha_venta"];		
				$Arreglo[$i]["["fecha_creacion_lote"]"] = "";
				$Arreglo[$i]["corr_enm"] = "";
				$Arreglo[$i]["lote"] = $FilaAux["numero"];
				$Arreglo[$i]["asignacion"] = "PMN";
				//CONSULTA LEYES
				$Consulta = " select distinct t2.nro_solicitud, t2.recargo, t3.cod_leyes, t3.valor, t3.cod_unidad ";
				$Consulta.= " FROM pmn_web.produccion_subproductos AS t1";
				$Consulta.= " INNER JOIN cal_web.solicitud_analisis AS t2";
				$Consulta.= " ON case when ((t1.cod_producto = '31' and t1.cod_subproducto='1') or (t1.cod_producto = '33' and t1.cod_subproducto='2') or (t1.cod_producto = '24' and t1.cod_subproducto='9'))";
				$Consulta.= " then (t2.id_muestra='".$FilaAux["numero"]."' or t2.nro_solicitud ='".$FilaAux["id_analisis"]."') ";
				$Consulta.= " else ((t2.id_muestra='".$FilaAux["id_analisis"]."') or ( ";	
				$Consulta.= " t2.nro_solicitud='".$FilaAux["id_analisis"]."')) end ";	
				$Consulta.= " AND t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
				$Consulta.= " AND t2.cod_periodo = '1' AND (t2.recargo = '0' or t2.recargo = '' or t2.recargo='1')";
				$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t3";
				$Consulta.= " ON t2.nro_solicitud = t3.nro_solicitud AND  t2.recargo = t3.recargo";
				$Consulta.= " WHERE t1.cod_producto = '".$FilaAux["cod_producto"]."' AND t1.cod_subproducto = '".$FilaAux["cod_subproducto"]."'";
				$Consulta.= " AND t1.fecha_venta BETWEEN '".$AnoAux."-".$MesAux."-01' AND '".$AnoAux."-".$MesAux."-31' ";			
				$Consulta.= " AND (t2.recargo='0' or t2.recargo='' or t2.recargo = '1') and ( ";
				reset($ArregloLeyes);
				while (list($k,$v)=each($ArregloLeyes))
				{
					$Consulta.= " t3.cod_leyes='".$v["cod_leyes"]."' or";
				}
				$Consulta = substr($Consulta,0,strlen($Consulta)-2).")";
				$Consulta.= " ORDER BY t2.nro_solicitud,t2.recargo";	
					//echo $Consulta."<br>";		
				$Resp2 = mysqli_query($link, $Consulta);
				$ConLeyes = "N";
				$NumCertificado = "";
				while ($Fila2 = mysqli_fetch_array($Resp2))
				{
					if ($Fila2["cod_leyes"]=="01")
						$LeyHum = $Fila2["valor"];
					if ($NumCertificado=="")
					{
						$NumCertificado = $Fila2["nro_solicitud"];
						$NumRecargo=$Fila2["recargo"];
					}
					else
					{
						if ($NumCertificado!=$Fila2["nro_solicitud"])
							$NumCertificado = $NumCertificado.$Fila2["nro_solicitud"]."~~";
					}
					$ConLeyes = "S";
					if ($Fila2["cod_leyes"]=="04" || $Fila2["cod_leyes"]=="05"|| $Fila2["cod_leyes"]=="44")
					     $ArregloLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"] * 1000;
					if ($Fila2["cod_leyes"]=="08" || $Fila2["cod_leyes"]=="09"|| $Fila2["cod_leyes"]=="39")
				 			$ArregloLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"] * 10000;
					if ($Fila2["cod_leyes"]!="04" and $Fila2["cod_leyes"]!="05" and  $Fila2["cod_leyes"]!="08"  and  $Fila2["cod_leyes"]!="09" and  $Fila2["cod_leyes"]!="39" and  $Fila2["cod_leyes"]!="44")
						$ArregloLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"];
				}
			$Arreglo[$i]["peso"] = $FilaAux["peso"]; //jcf- (($FilaAux["peso"]*$LeyHum)/100);
			$Arreglo[$i]["con_leyes"] = $ConLeyes;
			$Arreglo[$i]["num_certificado"] = $NumCertificado;
			$Arreglo[$i]["num_recargo"] = $NumRecargo;
			$Arreglo[$i]["peso_tara"] = $FilaAux["peso_tara"];
			$i++;
		}


		
		//producto barro anodico
		//TABLA PRODUCTOS POR MOVIMIENTO
		$Consulta = "select t1.cod_producto, t1.cod_subproducto, t2.abreviatura, t1.fecha, t1.peso_seco, t1.id ";
		$Consulta.= " from pmn_web.productos_por_movimientos t1 inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= " on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
		$Consulta.= " where fecha between '".$AnoAux."-".$MesAux."-01' and '".$AnoAux."-".$MesAux."-31'";
		if ($IdLote!="")
			$Consulta.= " and id='".$IdLote."'";
		$Consulta.= " and t1.tipo_mov='4' and t1.id not like '%aju%'  ";		
		if ($ProdAux=="" && $SubProdAux=="")
		{
			$Consulta.= " and ((t1.cod_producto='33' and t1.cod_subproducto='2') or ";
			$Consulta.= " (t1.cod_producto='31' and t1.cod_subproducto='1') or ";
			$Consulta.= " (t1.cod_producto='47' and t1.cod_subproducto='1') or ";
			$Consulta.= " (t1.cod_producto='28' and t1.cod_subproducto='1'))";
		}
		else
		{
			$Consulta.= " and (t1.cod_producto='".$ProdAux."' and t1.cod_subproducto='".$SubProdAux."') ";
		}
		$Consulta.= " order by lpad(t1.cod_producto,3,'0'), lpad(t1.cod_subproducto,3,'0')";
		$RespAux = mysqli_query($link, $Consulta);	
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{
			$Arreglo[$i]["cod_producto"] = $FilaAux["cod_producto"];
			$Arreglo[$i]["cod_subproducto"] = $FilaAux["cod_subproducto"];
			$Arreglo[$i]["descripcion"] = $FilaAux["abreviatura"];
			$Arreglo[$i]["cod_bulto"] = "";
			$Arreglo[$i]["num_bulto"] = "";
			$Arreglo[$i]["fecha_embarque"] = $FilaAux["fecha"];
			$Arreglo[$i]["peso"] = $FilaAux["peso_seco"];

		//	$Arreglo[$i]["num_paquetes"] = "25.0";
		//	$Arreglo[$i]["num_unidades"] = "1.0";

			$Arreglo[$i]["["fecha_creacion_lote"]"] = "";
			$Arreglo[$i]["corr_enm"] = "";
			$Arreglo[$i]["lote"] = $FilaAux["id"];
			$Arreglo[$i]["con_leyes"] = "S";
			$Arreglo[$i]["num_certificado"] = "S";	
			$Arreglo[$i]["asignacion"] = "PMN";			
			if (($FilaAux["fino_cu"]=='0' && $FilaAux["fino_ag"]=='0' && $FilaAux["fino_au"]=='0') || 
			($FilaAux["fino_cu"]=='' && $FilaAux["fino_ag"]=='' && $FilaAux["fino_au"]==''))
			{
				$Arreglo[$i]["con_leyes"] = "N";
				$Arreglo[$i]["num_certificado"] = "N";
			}
			$i++;
		}
	}
}	
function RescataAcido($ProdAux, $SubProdAux, $AnoAux, $MesAux, $Arreglo, $IdLote, $ArregloLeyes, $Orden)
{		
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$FechaIni=$AnoAux."-".str_pad($MesAux,2,'0',STR_PAD_LEFT)."-01";
	$FechaFin=$AnoAux."-".str_pad($MesAux,2,'0',STR_PAD_LEFT)."-31";
	if ($ProdAux!="")
		DefinirArregloLeyes($ProdAux, $SubProdAux, &$ArregloLeyes);	
	else
		DefinirArregloLeyes("46", $SubProdAux, &$ArregloLeyes);	
	$Consulta = "select t1.rut_cliente, t1.num_guia, t1.fecha_hora,sum(t1.toneladas) as toneladas, t2.nombre ";
	$Consulta.= " from pac_web.guia_despacho t1 inner join pac_web.clientes t2 on t1.rut_cliente=t2.rut_cliente ";
	$Consulta.= " where t1.fecha_hora between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' ";
	$Consulta.= " and t1.estado !='N' ";
	if ($IdLote!="")
	{
		$Consulta.= " and (t1.rut_cliente='".$IdLote."') ";
	}
	$Consulta.= " group by t1.rut_cliente ";	
	$Consulta.= " order by t1.rut_cliente ";
	//echo $Consulta;
	$RespAux = mysqli_query($link, $Consulta);
	$i=0;
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{
		//echo "LOTE=".$FilaAux["num_bulto"]." PESO=".($FilaAux["peso"]/1000)." NUM_PAQ=".$FilaAux["num_paquetes"]." NUM_UNID.".$FilaAux["num_unidades"];	
		$Arreglo[$i]["cod_producto"] = 46;
		$Arreglo[$i]["cod_subproducto"] = 1;
		$Arreglo[$i]["descripcion"] = $FilaAux["nombre"];
		//$Arreglo[$i]["cod_bulto"] = substr($AnoAux,3,1).str_pad($MesAux,2,'0',STR_PAD_LEFT);
		$Arreglo[$i]["cod_bulto"] = strtoupper(substr($Meses[$MesAux-1],0,4)).substr($AnoAux,3,1);
		$Arreglo[$i]["num_bulto"] = $FilaAux["rut_cliente"];
		$Arreglo[$i]["fecha_embarque"] = $FilaAux["fecha_hora"];
		$Arreglo[$i]["peso"] = $FilaAux["toneladas"];
		$Arreglo[$i]["["fecha_creacion_lote"]"] = $FilaAux["fecha_hora"];
		$Arreglo[$i]["corr_enm"] = str_pad($FilaAux["num_guia"],7,'0',STR_PAD_LEFT);
		$Arreglo[$i]["lote"] = $FilaAux["cod_bulto"]."-".str_pad($FilaAux["num_bulto"],6,'0',STR_PAD_LEFT);
		$Arreglo[$i]["num_paquetes"] = 0;
		$Arreglo[$i]["num_unidades"] = 0;
		$Arreglo[$i]["cod_marca"] = "";
		$Arreglo[$i]["descrip_marca"] = "";
		$Arreglo[$i]["asignacion"] = "ACIDO";
		$Arreglo[$i]["cod_puerto"] = "";
		$Arreglo[$i]["cod_puerto_destino"] = "";
		//CONSULTA LAS LEYES
		//NO TIENE LEYES
		$i++;
	}
}

function DefinirArregloLeyes($L_Prod, $L_SubProd, $ArregloLeyes)
{
	//CATODOS y RESTOS
	if ($L_Prod=="18" || $L_Prod=="19" || $L_Prod=="43" || $L_Prod=="48" || $L_Prod=="")
	{
		$ArregloLeyes["02"]["cod_leyes"] = "02";
		$ArregloLeyes["04"]["cod_leyes"] = "04";
		$ArregloLeyes["08"]["cod_leyes"] = "08";
		$ArregloLeyes["27"]["cod_leyes"] = "27";
		$ArregloLeyes["09"]["cod_leyes"] = "09";
		$ArregloLeyes["44"]["cod_leyes"] = "44";
		$ArregloLeyes["58"]["cod_leyes"] = "58";
		$ArregloLeyes["30"]["cod_leyes"] = "30";
		$ArregloLeyes["36"]["cod_leyes"] = "36";
		$ArregloLeyes["10"]["cod_leyes"] = "10";
		$ArregloLeyes["31"]["cod_leyes"] = "31";
		$ArregloLeyes["39"]["cod_leyes"] = "39";
		$ArregloLeyes["26"]["cod_leyes"] = "26";
		$ArregloLeyes["48"]["cod_leyes"] = "48";
		$ArregloLeyes["29"]["cod_leyes"] = "29";
		$ArregloLeyes["33"]["cod_leyes"] = "33";
		$ArregloLeyes["13"]["cod_leyes"] = "13";
		$ArregloLeyes["50"]["cod_leyes"] = "50";
		$ArregloLeyes["40"]["cod_leyes"] = "40";
		$ArregloLeyes["78"]["cod_leyes"] = "78";
	}
	//ORO
	if ($L_Prod=="34" || $L_Prod=="")
	{
		$ArregloLeyes["05"]["cod_leyes"] = "05";
		$ArregloLeyes["04"]["cod_leyes"] = "04";
		$ArregloLeyes["1000"]["cod_leyes"] = "1000";$ArregloLeyes["1000"]["valor"] = 0;//espacios
		$ArregloLeyes["37"]["cod_leyes"] = "37";
		$ArregloLeyes["1001"]["cod_leyes"] = "1001";$ArregloLeyes["1001"]["valor"] = 0;//espacios
		$ArregloLeyes["1002"]["cod_leyes"] = "1002";$ArregloLeyes["1002"]["valor"] = 0;//espacios	
		$ArregloLeyes["1003"]["cod_leyes"] = "1003";$ArregloLeyes["1003"]["valor"] = 0;//espacios
		$ArregloLeyes["1004"]["cod_leyes"] = "1004";$ArregloLeyes["1004"]["valor"] = 0;//espacios	
		$ArregloLeyes["1005"]["cod_leyes"] = "1005";$ArregloLeyes["1005"]["valor"] = 0;//espacios
		$ArregloLeyes["1006"]["cod_leyes"] = "1006";$ArregloLeyes["1006"]["valor"] = 0;//espacios
		$ArregloLeyes["39"]["cod_leyes"] = "39";
		$ArregloLeyes["1007"]["cod_leyes"] = "1007";$ArregloLeyes["1007"]["valor"] = 0;//espacios			
		$ArregloLeyes["31"]["cod_leyes"] = "31";
		$ArregloLeyes["1009"]["cod_leyes"] = "1009";$ArregloLeyes["1009"]["valor"] = 0;//espacios	
		$ArregloLeyes["02"]["cod_leyes"] = "02";
		$ArregloLeyes["60"]["cod_leyes"] = "60";
		$ArregloLeyes["40"]["cod_leyes"] = "40";
		$ArregloLeyes["56"]["cod_leyes"] = "56";	
	}
	//ACIDO SULFURICO
	if ($L_Prod=="46")
	{
		$ArregloLeyes["1000"]["cod_leyes"] = "1000";$ArregloLeyes["1000"]["valor"] = 0;//espacios
	}
	//PLATA
	if ($L_Prod=="29" || $L_Prod=="")
	{
		$ArregloLeyes["05"]["cod_leyes"] = "05";
		$ArregloLeyes["04"]["cod_leyes"] = "04";
		$ArregloLeyes["1000"]["cod_leyes"] = "1000";$ArregloLeyes["1000"]["valor"] = 0;//espacios
		$ArregloLeyes["1001"]["cod_leyes"] = "1001";$ArregloLeyes["1001"]["valor"] = 0;//espacios
		$ArregloLeyes["1002"]["cod_leyes"] = "1002";$ArregloLeyes["1002"]["valor"] = 0;//espacios
		$ArregloLeyes["1003"]["cod_leyes"] = "1003";$ArregloLeyes["1003"]["valor"] = 0;//espacios
		$ArregloLeyes["1004"]["cod_leyes"] = "1004";$ArregloLeyes["1004"]["valor"] = 0;//espacios
		$ArregloLeyes["1005"]["cod_leyes"] = "1005";$ArregloLeyes["1005"]["valor"] = 0;//espacios
		$ArregloLeyes["1006"]["cod_leyes"] = "1006";$ArregloLeyes["1006"]["valor"] = 0;//espacios
		$ArregloLeyes["27"]["cod_leyes"] = "27";	
		$ArregloLeyes["39"]["cod_leyes"] = "39";
		$ArregloLeyes["1008"]["cod_leyes"] = "1008";$ArregloLeyes["1008"]["valor"] = 0;//espacios	
		$ArregloLeyes["40"]["cod_leyes"] = "40";	
		$ArregloLeyes["02"]["cod_leyes"] = "02";
		$ArregloLeyes["31"]["cod_leyes"] = "31";	
	}
	//ESCORIA FUSION HORNO TROFF
	if ($L_Prod=="28" || $L_Prod=="")
	{
		$ArregloLeyes["02"]["cod_leyes"] = "02";
		$ArregloLeyes["05"]["cod_leyes"] = "05";
		$ArregloLeyes["04"]["cod_leyes"] = "04";
		$ArregloLeyes["40"]["cod_leyes"] = "40";
		$ArregloLeyes["08"]["cod_leyes"] = "08";
		$ArregloLeyes["09"]["cod_leyes"] = "09";
		$ArregloLeyes["39"]["cod_leyes"] = "39";
		$ArregloLeyes["01"]["cod_leyes"] = "01";
	}
	//ESCORIAS PALADIO PLATINO
	if ($L_Prod=="33" || $L_Prod=="")
	{
		$ArregloLeyes["05"]["cod_leyes"] = "05";
		$ArregloLeyes["04"]["cod_leyes"] = "04";
		$ArregloLeyes["37"]["cod_leyes"] = "37";
		$ArregloLeyes["38"]["cod_leyes"] = "38";
		$ArregloLeyes["02"]["cod_leyes"] = "02";
		$ArregloLeyes["108"]["cod_leyes"] = "108";
		$ArregloLeyes["31"]["cod_leyes"] = "31";
		$ArregloLeyes["39"]["cod_leyes"] = "39";
		$ArregloLeyes["01"]["cod_leyes"] = "01";
	}
	//SELENIO
	if ($L_Prod=="31" || $L_Prod=="")
	{
		$ArregloLeyes["40"]["cod_leyes"] = "40";	
		$ArregloLeyes["05"]["cod_leyes"] = "05";
		$ArregloLeyes["04"]["cod_leyes"] = "04";
		$ArregloLeyes["02"]["cod_leyes"] = "02";
		$ArregloLeyes["31"]["cod_leyes"] = "31";
		$ArregloLeyes["36"]["cod_leyes"] = "36";
		$ArregloLeyes["08"]["cod_leyes"] = "08";
		$ArregloLeyes["09"]["cod_leyes"] = "09";
		$ArregloLeyes["39"]["cod_leyes"] = "39";
		$ArregloLeyes["44"]["cod_leyes"] = "44";
		$ArregloLeyes["26"]["cod_leyes"] = "26";
		$ArregloLeyes["01"]["cod_leyes"] = "01";
		$ArregloLeyes["22"]["cod_leyes"] = "22";
	}
	//TELURO
	if ($L_Prod=="47" || $L_Prod=="")
	{
		$ArregloLeyes["44"]["cod_leyes"] = "44";
		$ArregloLeyes["40"]["cod_leyes"] = "40";
		$ArregloLeyes["39"]["cod_leyes"] = "39";
		$ArregloLeyes["02"]["cod_leyes"] = "02";
		$ArregloLeyes["31"]["cod_leyes"] = "31";
	}
		//BARRO ANODICO CRUDO
	if ($L_Prod=="24" || $L_Prod=="")
	{
		$ArregloLeyes["01"]["cod_leyes"] = "01";
		$ArregloLeyes["02"]["cod_leyes"] = "02";
		$ArregloLeyes["04"]["cod_leyes"] = "04";
		$ArregloLeyes["05"]["cod_leyes"] = "05";
		$ArregloLeyes["08"]["cod_leyes"] = "08";
		$ArregloLeyes["09"]["cod_leyes"] = "09";
		$ArregloLeyes["26"]["cod_leyes"] = "26";
		$ArregloLeyes["39"]["cod_leyes"] = "39";
		$ArregloLeyes["40"]["cod_leyes"] = "40";
		$ArregloLeyes["44"]["cod_leyes"] = "44";
	}

	//PRODUCTO MINERO
	if ($L_Prod=="1")
	{
		//BLISTER Y ANODOS
		if (($L_SubProd=="16")||($L_SubProd=='17'))
		{
			$ArregloLeyes["02"][0] = "02";
			$ArregloLeyes["02"][2] = "0,000";
			$ArregloLeyes["05"][0] = "05";
			$ArregloLeyes["05"][2] = "0,000";
			$ArregloLeyes["04"][0] = "04";
			$ArregloLeyes["04"][2] = "0,000";
			$ArregloLeyes["01"][0] = "01";
			$ArregloLeyes["01"][2] = "0,000";
			$ArregloLeyes["08"][0] = "08";
			$ArregloLeyes["08"][2] = "0,000";
			$ArregloLeyes["26"][0] = "26";
			$ArregloLeyes["26"][2] = "0,000";
			$ArregloLeyes["09"][0] = "09";
			$ArregloLeyes["09"][2] = "0,000";
			$ArregloLeyes["40"][0] = "40";
			$ArregloLeyes["40"][2] = "0,000";
			$ArregloLeyes["44"][0] = "44";
			$ArregloLeyes["44"][2] = "0,000";
			$ArregloLeyes["31"][0] = "31";
			$ArregloLeyes["31"][2] = "0,000";
			$ArregloLeyes["36"][0] = "36";
			$ArregloLeyes["36"][2] = "0,000";
			$ArregloLeyes["27"][0] = "27";
			$ArregloLeyes["27"][2] = "0,000";
			$ArregloLeyes["39"][0] = "39";
			$ArregloLeyes["39"][2] = "0,000";
		}
		else
		{
			//LOS DEMAS PRODUCTOS MINEROS
			$ArregloLeyes["02"][0] = "02";
			$ArregloLeyes["02"][2] = "0,000";
			$ArregloLeyes["05"][0] = "05";
			$ArregloLeyes["05"][2] = "0,000";
			$ArregloLeyes["04"][0] = "04";
			$ArregloLeyes["04"][2] = "0,000";
			$ArregloLeyes["01"][0] = "01";
			$ArregloLeyes["01"][2] = "0,000";
			$ArregloLeyes["08"][0] = "08";
			$ArregloLeyes["08"][2] = "0,000";
			$ArregloLeyes["09"][0] = "09";
			$ArregloLeyes["09"][2] = "0,000";
			$ArregloLeyes["34"][0] = "34";
			$ArregloLeyes["34"][2] = "0,000";
			$ArregloLeyes["27"][0] = "27";
			$ArregloLeyes["27"][2] = "0,000";
			$ArregloLeyes["39"][0] = "39";
			$ArregloLeyes["39"][2] = "0,000";
			$ArregloLeyes["10"][0] = "10";
			$ArregloLeyes["10"][2] = "0,000";
		}	
	}
}
?>
