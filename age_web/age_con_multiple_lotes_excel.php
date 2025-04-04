<?php
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename="";
	if ( preg_match( '/MSIE/i', $userBrowser ) ) {
	$filename = urlencode($filename);
	}
	$filename = iconv('UTF-8', 'gb2312', $filename);
	$file_name = str_replace(".php", "", $file_name);
	header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
	header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
	
	header("content-disposition: attachment;filename={$file_name}");
	header( "Cache-Control: public" );
	header( "Pragma: public" );
	header( "Content-type: text/csv" ) ;
	header( "Content-Dis; filename={$file_name}" ) ;
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_principal.php");	
	include("age_funciones.php");	

	$Busq = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
	$TxtFechaIni = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:date('Y-m')."-01";
	$TxtFechaFin = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:date('Y-m')."-".date('t');
	$TxtLoteIni = isset($_REQUEST["TxtLoteIni"])?$_REQUEST["TxtLoteIni"]:"";
	$TxtLoteFin = isset($_REQUEST["TxtLoteFin"])?$_REQUEST["TxtLoteFin"]:"";
	$TxtConjIni = isset($_REQUEST["TxtConjIni"])?$_REQUEST["TxtConjIni"]:"";
	$TxtConjFin = isset($_REQUEST["TxtConjFin"])?$_REQUEST["TxtConjFin"]:"";
	$OpcConsulta = isset($_REQUEST["OpcConsulta"])?$_REQUEST["OpcConsulta"]:"";

	$Mes = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbFlujos      = isset($_REQUEST["CmbFlujos"])?$_REQUEST["CmbFlujos"]:"";	
	$CmbProveedor   = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";

	$TxtFiltroPrv    = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$OpcTR           = isset($_REQUEST["OpcTR"])?$_REQUEST["OpcTR"]:"";
	$OpcSF           = isset($_REQUEST["OpcSF"])?$_REQUEST["OpcSF"]:"";
	$OpcHLF          = isset($_REQUEST["OpcHLF"])?$_REQUEST["OpcHLF"]:"";
	$TxtLeyesMuestra = isset($_REQUEST["TxtLeyesMuestra"])?$_REQUEST["TxtLeyesMuestra"]:"";
	$TxtCodLeyes     = isset($_REQUEST["TxtCodLeyes"])?$_REQUEST["TxtCodLeyes"]:"";
	$TxtLimitesMuestra = isset($_REQUEST["TxtLimitesMuestra"])?$_REQUEST["TxtLimitesMuestra"]:"";
	$TxtCodLimites     = isset($_REQUEST["TxtCodLimites"])?$_REQUEST["TxtCodLimites"]:"";

	$ArrLimites = array();
	$ArrLeyes = array();
	$ArrCodLeyes = array();
	if (isset($TxtCodLeyes) && $TxtCodLeyes != "")
	{
		$TxtCodLeyes = "01~".$TxtCodLeyes;
		$ArrCodLeyes = explode("~",$TxtCodLeyes);
	}
	if (isset($TxtCodLimites) && $TxtCodLimites != "")
	{
		$Datos = explode("~~",$TxtCodLimites);
		foreach($Datos as $k => $v)
		{			
			$Datos2 = explode("~",$v);
			$ArrLimites[$Datos2[0]][0] = $Datos2[0];
			$ArrLimites[$Datos2[0]][1] = $Datos2[1];
			$ArrLimites[$Datos2[0]][2] = $Datos2[2];
		}
	}
	$ArrLoteLeyes = array();
	$ArrSubTotalLeyes = array();
	$ArrTotalLeyes = array();
	$Humedad = false;
	if ($OpcConsulta == "P" || $OpcConsulta == "C")
	{
		$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
		$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
		$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
		$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
	}
	//CONSULTA CANTIDAD DE LEYES
	if ($OpcHLF!="P")
	{		
		$Consulta = "select distinct t3.cod_leyes, t4.abreviatura ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on ";
		$Consulta.= " t1.lote=t2.lote inner join age_web.leyes_por_lote t3 on";
		$Consulta.= " t2.lote=t3.lote inner join proyecto_modernizacion.leyes t4 on ";
		$Consulta.= " t3.cod_leyes=t4.cod_leyes ";
		$Consulta.= " where t1.lote<>''  and t1.estado_lote<>'6' ";
		if ($OpcConsulta == "L")
			$Consulta.= " and t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
		if ($OpcConsulta == "F")
			$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
		if ($OpcConsulta == "C")
			$Consulta.= " and t1.num_conjunto between '".$TxtConjIni."' and '".$TxtConjFin."'";
		if ($CmbSubProducto != "S")
			$Consulta.= " and t1.cod_producto='1' and t1.cod_subproducto='".$CmbSubProducto."'";
		if ($CmbProveedor != "S")
		{
			$Datos = explode("-",$CmbProveedor);
			$RutAux = ($Datos[0]*1)."-".$Datos[1];
			$Consulta.= " and t1.rut_proveedor='".$RutAux."'";
		}
		if (count($ArrCodLeyes)>0)
		{
			$Consulta.= " and (";
			reset($ArrCodLeyes);
			foreach($ArrCodLeyes as $k => $v)
			{			
				$Consulta.= " t3.cod_leyes='".$v."' or";
			}
			$Consulta = substr($Consulta,0,strlen($Consulta)-3);
			$Consulta.= ")";
		}
		$Consulta.= " order by t3.cod_leyes";
		//echo $Consulta;
		$Resp = mysqli_query($link, $Consulta);
		$CantLeyes = 0;
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($Fila["cod_leyes"]=="01")
				$Humedad=true;
			$ArrLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
			$ArrLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
			$ArrLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
			$ArrLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
			$ArrLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
			$ArrLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION		
			//PARA ACUMULAR EL TOTAL DEL LOTE
			$ArrLoteLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
			$ArrLoteLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
			$ArrLoteLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
			$ArrLoteLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
			$ArrLoteLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
			$ArrLoteLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION	
			//PARA ACUMULAR EL SUB-TOTAL 
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION	
			//PARA ACUMULAR EL STOTAL 
			$ArrTotalLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
			$ArrTotalLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
			$ArrTotalLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
			$ArrTotalLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
			$ArrTotalLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
			$ArrTotalLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION	
			$CantLeyes++;
		}
	}
	else
	{
		$Humedad = true;
		$Consulta = "select distinct cod_leyes, abreviatura ";
		$Consulta.= " from  proyecto_modernizacion.leyes  ";
		$Consulta.= " where cod_leyes='01' ";		
		$Consulta.= " order by cod_leyes";
		$Resp = mysqli_query($link, $Consulta);
		$CantLeyes = 0;
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$ArrLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
			$ArrLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
			$ArrLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
			$ArrLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
			$ArrLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
			$ArrLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION		
			//PARA ACUMULAR EL TOTAL DEL LOTE
			$ArrLoteLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
			$ArrLoteLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
			$ArrLoteLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
			$ArrLoteLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
			$ArrLoteLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
			$ArrLoteLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION	
			//PARA ACUMULAR EL SUB-TOTAL 
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
			$ArrSubTotalLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION	
			//PARA ACUMULAR EL STOTAL 
			$ArrTotalLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
			$ArrTotalLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
			$ArrTotalLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
			$ArrTotalLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
			$ArrTotalLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
			$ArrTotalLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION	
			$CantLeyes++;
		}
	}
	
?>
<html>
<head>
<title>Sistema de Agencia</title>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
  <br>
<?php
if ($Humedad==true)
	$ColSpan = $CantLeyes+4; 
else
	$ColSpan = $CantLeyes+4;
if ($OpcTR=="R")			
	$ColSpanSubTotal = 3;
else		 
	$ColSpanSubTotal = 2;
echo "<table width='400'  border='0' align='center' cellpadding='3' cellspacing='0'>\n";
switch ($OpcConsulta)
{
	case "F":			
		$Consulta = "select distinct t2.fecha_recepcion  ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote ";
		if ($OpcSF=="F")		
		{		
			$Consulta.= " left join age_web.relaciones t3 on ";
			$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
			$Consulta.= " left join age_web.relaciones t4 on t1.cod_producto = t4.cod_producto ";
			$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
		}
		$Consulta.= " where t1.lote<>''  and t1.estado_lote<>'6' ";		
		$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		if ($CmbSubProducto != "S" && $OpcSF=="S")
		{
			$Consulta.= " and t1.cod_producto = '1' ";
			$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
		}
		if ($CmbFlujos != "S" && $OpcSF=="F")
			$Consulta.= " and (t3.flujo = '".$CmbFlujos."' or t4.flujo = '".$CmbFlujos."') ";
		if ($OpcSF=="F")
			//$Consulta.= " and t3.flujo<>'' and t4.flujo<>'' and not isnull(t3.flujo) and not isnull(t4.flujo) ";
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		$Consulta.= " order by t2.fecha_recepcion ";
		break;
	case "L";
		if ($OpcSF=="S")		
			$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,4,'0') as orden  ";
		if ($OpcSF=="F")
		{
			$Consulta = "SELECT DISTINCT ifnull(case when ISNULL(t3.flujo) then t4.flujo else t3.flujo end,0) as flujo,";
			$Consulta.= " ifnull(case when ISNULL(t3.flujo) then lpad(t4.flujo,4,'0') else lpad(t3.flujo,4,'0') end,0) as orden ";
		}
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote ";
		if ($OpcSF=="F")		
		{		
			$Consulta.= " left join age_web.relaciones t3 on ";
			$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
			$Consulta.= " left join age_web.relaciones t4 on t1.cod_producto = t4.cod_producto ";
			$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
		}
		$Consulta.= " where t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."' and t1.estado_lote<>'6' ";
		if ($CmbSubProducto != "S" && $OpcSF=="S")
		{
			$Consulta.= " and t1.cod_producto = '1' ";
			$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
		}
		if ($CmbFlujos != "S" && $OpcSF=="F")
			$Consulta.= " and (t3.flujo = '".$CmbFlujos."' or t4.flujo = '".$CmbFlujos."') ";
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		if ($OpcSF=="F")
		{
			$Consulta.= " group by flujo, orden ";
			if ($CmbFlujos != "S")
				$Consulta.= " having flujo='".$CmbFlujos."'";
			$Consulta.= " order by flujo";
		}
		else
			$Consulta.= " order by orden ";
		break;
	case "C":
		if ($OpcSF=="S")		
			$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t1.num_conjunto, lpad(t1.num_conjunto,4,'0') as orden  ";
		if ($OpcSF=="F")
		{
			$Consulta = "SELECT DISTINCT ifnull(case when ISNULL(t3.flujo) then t4.flujo else t3.flujo end,0) as flujo,";
			$Consulta.= " ifnull(case when ISNULL(t3.flujo) then lpad(t4.flujo,4,'0') else lpad(t3.flujo,4,'0') end,0) as orden, t1.num_conjunto ";
		}
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote ";
		if ($OpcSF=="F")		
		{		
			$Consulta.= " left join age_web.relaciones t3 on ";
			$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
			$Consulta.= " left join age_web.relaciones t4 on t1.cod_producto = t4.cod_producto ";
			$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
		}
		$Consulta.= " where t1.num_conjunto between '".$TxtConjIni."' and '".$TxtConjFin."' and t1.estado_lote<>'6' ";	
		$Consulta.= " and t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
		if ($CmbSubProducto != "S" && $OpcSF=="S")
		{
			$Consulta.= " and t1.cod_producto = '1' ";
			$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
		}
		if ($CmbFlujos != "S" && $OpcSF=="F")
			$Consulta.= " and (t3.flujo = '".$CmbFlujos."' or t4.flujo = '".$CmbFlujos."') ";
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		if ($OpcSF=="F")
		{
			$Consulta.= " group by flujo, orden ";
			if ($CmbFlujos != "S")
				$Consulta.= " having flujo='".$CmbFlujos."' ";
			$Consulta.= " order by flujo";
		}
		else
			$Consulta.= " order by orden ";
		break;
	case "P":		
		if ($OpcSF=="S")		
			$Consulta = "select distinct t1.rut_proveedor  ";
		if ($OpcSF=="F")
		{
			$Consulta = "SELECT DISTINCT ifnull(case when ISNULL(t3.flujo) then t4.flujo else t3.flujo end,0) as flujo,";
			$Consulta.= " ifnull(case when ISNULL(t3.flujo) then lpad(t4.flujo,4,'0') else lpad(t3.flujo,4,'0') end,0) as orden ";
		}
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote ";
		if ($OpcSF=="F")		
		{		
			$Consulta.= " left join age_web.relaciones t3 on ";
			$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
			$Consulta.= " left join age_web.relaciones t4 on t1.cod_producto = t4.cod_producto ";
			$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
		}
		$Consulta.= " where t1.lote<>''  and t1.estado_lote<>'6' ";		
		$Consulta.= " and t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		if ($CmbSubProducto != "S" && $OpcSF=="S")
		{
			$Consulta.= " and t1.cod_producto = '1' ";
			$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
		}
		if ($CmbFlujos != "S" && $OpcSF=="F")
			$Consulta.= " and (t3.flujo = '".$CmbFlujos."' or t4.flujo = '".$CmbFlujos."') ";		
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		if ($OpcSF=="F")
		{
			$Consulta.= " group by flujo,t1.rut_proveedor ";
			if ($CmbFlujos != "S")
				$Consulta.= " having flujo='".$CmbFlujos."' ";
			$Consulta.= " order by flujo";
		}
		else
			$Consulta.= " order by t1.rut_proveedor ";
		break;
}
//echo $Consulta."<br>";
$Resp01 = mysqli_query($link, $Consulta);	
while ($Fila01 = mysqli_fetch_array($Resp01))	
{	
	switch ($OpcConsulta)
	{
		case "F":
			echo "<tr class='ColorTabla01'>\n";		
			echo "<td align='center' colspan=\"".$ColSpan."\"><strong>".substr($Fila01["fecha_recepcion"],8,2)."-".substr($Fila01["fecha_recepcion"],5,2)."-".substr($Fila01["fecha_recepcion"],0,4)."</strong></td>\n";			
			echo "</tr>\n";
			break;
		case "P":
			echo "<tr class='ColorTabla01'>\n";	
			switch ($OpcSF)
			{
				case "F":
					$Consulta = "select * from proyecto_modernizacion.flujos ";
					$Consulta.= "where cod_flujo = '".$Fila01["flujo"]."' and sistema='RAM'";			
					$RespAux2 = mysqli_query($link, $Consulta);
					if ($FilaAux2 = mysqli_fetch_array($RespAux2))
					{
						$NomFlujo = $FilaAux2["descripcion"];
					}
						
					echo "<td align='center' colspan=\"".$ColSpan."\"><strong>".str_pad($Fila01["flujo"],3,"0",STR_PAD_LEFT)." - ".$NomFlujo."</strong></td>\n";			
					break;
					case "S":
						$NomProveedor="";
						$Datos = explode("-",$Fila01["rut_proveedor"]);
						$RutAux = str_pad(($Datos[0]*1),8,'0',STR_PAD_LEFT)."-".$Datos[1];
						$Consulta = "select * ";
						$Consulta.= " from rec_web.proved ";
						$Consulta.= " where RUTPRV_A='".$RutAux."'";
						$Consulta.= " order by TRIM(nomprv_a) ";
						$RespProv = mysqli_query($link, $Consulta);	
						while ($FilaProv = mysqli_fetch_array($RespProv))
						{
							$NomProveedor = $FilaProv["NOMPRV_A"];
						}
						echo "<td align='center' colspan=\"".$ColSpan."\">".$Fila01["rut_proveedor"]." - ".$NomProveedor."</td>";
					break;
			}			
			echo "</tr>\n";
			break;
	}
	switch ($OpcConsulta)
	{		
		case "F":
			if ($OpcSF=="S")		
				$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,3,'0') as orden ";
			if ($OpcSF=="F")
			{
				$Consulta = "SELECT DISTINCT ifnull(case when ISNULL(t3.flujo) then t4.flujo else t3.flujo end,0) as flujo,";
				$Consulta.= " ifnull(case when ISNULL(t3.flujo) then lpad(t4.flujo,4,'0') else lpad(t3.flujo,4,'0') end,0) as orden ";
			}
			$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
			$Consulta.= " on t1.lote = t2.lote ";
			if ($OpcSF=="F")		
			{		
				$Consulta.= " left join age_web.relaciones t3 on ";
				$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
				$Consulta.= " left join age_web.relaciones t4 on t1.cod_producto = t4.cod_producto ";
				$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
			}
			$Consulta.= " where t1.lote<>'' and t1.estado_lote<>'6'  ";
			if ($OpcConsulta == "F")
				$Consulta.= " and t2.fecha_recepcion between '".$Fila01["fecha_recepcion"]."' and '".$Fila01["fecha_recepcion"]."'";		
			if ($CmbSubProducto != "S" && $OpcSF=="S")
			{
				$Consulta.= " and t1.cod_producto = '1' ";
				$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
			}
			if ($CmbFlujos != "S" && $OpcSF=="F")
				$Consulta.= " and (t3.flujo = '".$CmbFlujos."' or t4.flujo = '".$CmbFlujos."') ";			
			if ($CmbProveedor != "S")
				$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
			if ($OpcSF=="F")
			{
				$Consulta.= " group by flujo, orden ";
				if ($CmbFlujos != "S")
					$Consulta.= " having flujo='".$CmbFlujos."' ";
				$Consulta.= " order by flujo";
			}
			else
				$Consulta.= " order by orden ";
			break;
		case "L":
			$Consulta = $Consulta;
			break;
		case "C":
			$Consulta = $Consulta;
			break;
		case "P":		
			if ($OpcSF=="S")		
				$Consulta = "select distinct t1.rut_proveedor, t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,3,'0') as orden ";
			if ($OpcSF=="F")
			{
				$Consulta = "SELECT DISTINCT ifnull(case when ISNULL(t3.flujo) then t4.flujo else t3.flujo end,0) as flujo,";
				$Consulta.= " ifnull(case when ISNULL(t3.flujo) then lpad(t4.flujo,4,'0') else lpad(t3.flujo,4,'0') end,0) as orden, t1.rut_proveedor ";
			}
			$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
			$Consulta.= " on t1.lote = t2.lote ";
			if ($OpcSF=="F")		
			{		
				$Consulta.= " left join age_web.relaciones t3 on ";
				$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
				$Consulta.= " left join age_web.relaciones t4 on t1.cod_producto = t4.cod_producto ";
				$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
			}
			$Consulta.= " where t1.lote<>''  and t1.estado_lote<>'6' ";
			$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";		
			if ($CmbSubProducto != "S" && $OpcSF=="S")
			{
				$Consulta.= " and t1.cod_producto = '1' ";
				$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
			}
			if ($CmbFlujos != "S" && $OpcSF=="F")
				$Consulta.= " and (t3.flujo = '".$CmbFlujos."' or t4.flujo = '".$CmbFlujos."') ";
			/*if ($CmbProveedor !="S")			
				$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";*/
			if ($OpcSF == "S")
				$Consulta.= " and t1.rut_proveedor = '".$Fila01["rut_proveedor"]."' ";
			if ($OpcSF=="F")
			{
				$Consulta.= " group by flujo, t1.rut_proveedor having flujo='".$Fila01["flujo"]."'";
				$Consulta.= " order by flujo";
			}
			else
				$Consulta.= " order by orden ";
			break;
	}
	//echo $Consulta."<br>";
	$RespAux = mysqli_query($link, $Consulta);
	$TotalPesoHum=0;
	$TotalPesoSeco=0;
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{
		//TITULO		
		if ($OpcSF=="S")
		{//PRODUCTO			
			$Consulta = "select * from proyecto_modernizacion.subproducto ";
			$Consulta.= "where cod_producto = '".$FilaAux["cod_producto"]."' and cod_subproducto='".$FilaAux["cod_subproducto"]."'";
		}
		else
		{
			if ($OpcSF=="F")
			{//FLUJO		
				$Consulta = "select * from proyecto_modernizacion.flujos ";
				$Consulta.= "where cod_flujo = '".$FilaAux["flujo"]."' and sistema='RAM'";
			}
		}
		$RespAux2 = mysqli_query($link, $Consulta);
		if ($FilaAux2 = mysqli_fetch_array($RespAux2))
		{
			$NomSubProd = $FilaAux2["descripcion"];
		}
		else
			$NomSubProd = "SIN IDENTIFICACION";
		echo "<tr class='ColorTabla01'>\n";
		if ($OpcSF == "S")
			echo "<td align='left' colspan=\"".$ColSpan."\">".str_pad($FilaAux["cod_subproducto"],3,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>\n";
		if ($OpcSF == "F")
		{
			if ($OpcConsulta == "P")
			{				
				$NomSubProd=""; 
				$NomProveedor="";
				$Datos = explode("-",$FilaAux["rut_proveedor"]);
				$RutAux = str_pad(($Datos[0]*1),8,'0',STR_PAD_LEFT)."-".$Datos[1];
				$Consulta = "select * ";
				$Consulta.= " from rec_web.proved ";
				$Consulta.= " where RUTPRV_A='".$RutAux."'";
				$Consulta.= " order by TRIM(nomprv_a) ";
				$RespProv = mysqli_query($link, $Consulta);	
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$NomProveedor = $FilaProv["NOMPRV_A"];
				}
				echo "<td align='left' colspan=\"".$ColSpan."\">".$FilaAux["rut_proveedor"]." - ".$NomProveedor."</td>";
			}
			else			
				echo "<td align='left' colspan=\"".$ColSpan."\">".str_pad($FilaAux["flujo"],3,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>\n";			
		}
		echo "</tr>\n";
		echo "<tr class='ColorTabla02'>\n";
		if ($OpcConsulta!="C")
			echo "<td align='center'>Fecha</td>\n";
		else
			echo "<td align='center'>Conjto</td>\n";
		echo "<td align='center'>Lote</td>\n";
		if ($OpcTR=="R")
			echo "<td align='center'>Rec.</td>\n";
		if ($Humedad==true)
			echo "<td align='center'>P.Hum.<br>Kg.</td>\n";
		echo "<td align='center'>P.Seco<br>Kg.</td>\n";
		reset($ArrLeyes);
		foreach($ArrLeyes as $k => $v)
		{
			if($k!=''&&$v[1]!='')
			{
				if ($OpcHLF == "F")
				{
					if ($k=="04" || $k=="05")
						$AbrevUnidad =  "gr";
					else
					if($k=="01")
						$AbrevUnidad =  "%";
					else
						$AbrevUnidad =  "Kg";
				}
				else
				{
					$AbrevUnidad = $ArrParamLeyes[$v[0]][3];
				}
				if ($k=="01" && $Humedad==true)
					echo "<td align='center'>".$v[1]."<br>".$AbrevUnidad."</td>\n";
				else
					if ($k!="01" && $OpcHLF!="P")
						echo "<td align='center'>".$v[1]."<br>".$AbrevUnidad."</td>\n";
			}			
		}
		echo "</tr>\n";
	 
		$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
		$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion ";
		if ($OpcSF=="F")		
		{
			$Consulta.= " , ifnull(case when isnull(t3.flujo) then t4.flujo else t3.flujo end,0) as flujo ";
		}
		if ($OpcConsulta=="C")
			$Consulta.= " , t1.num_conjunto ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote ";	
		if ($OpcSF=="F")		
		{		
			$Consulta.= " left join age_web.relaciones t3 on ";
			$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
			$Consulta.= " left join age_web.relaciones t4 on t1.cod_producto = t4.cod_producto ";
			$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
		}
		$Consulta.= " where t1.lote<>''  and t1.estado_lote<>'6' ";
		if ($OpcSF=="S")
		{
			$Consulta.= " and t1.cod_producto = '1' ";
			$Consulta.= " and t1.cod_subproducto = '".$FilaAux["cod_subproducto"]."' ";
		}
		if ($OpcSF=="F" && $FilaAux["flujo"]!=0)
			$Consulta.= " and (t3.flujo = '".$FilaAux["flujo"]."' or t4.flujo = '".$FilaAux["flujo"]."')";
		switch ($OpcConsulta)
		{
			case "F":
				$Consulta.= " and t2.fecha_recepcion between '".$Fila01["fecha_recepcion"]."' and '".$Fila01["fecha_recepcion"]."'";
				break;
			case "L":
				$Consulta.= " and t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
				break;
			case "C":
				$Consulta.= " and t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
				$Consulta.= " and t1.num_conjunto = '".$FilaAux["num_conjunto"]."'";
				break;
			case "P":
				$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
				$Consulta.= " and t1.rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
				break;
		}
		if ($CmbProveedor != "S" && $OpcConsulta!="P")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
			
		if ($OpcSF=="F")
		{
			$Consulta.= " group by flujo, t1.lote, t2.recargo, t1.rut_proveedor,  peso_hum, orden, t2.fecha_recepcion";
			$Consulta.= " having flujo='".$FilaAux["flujo"]."' ";
		}
		else
		{
			if ($OpcConsulta!="C")
				$Consulta.= " group by t1.lote, t2.recargo order by t1.lote, orden";
			else
				$Consulta.= " group by t1.num_conjunto, t1.lote, t2.recargo order by t1.num_conjunto, t1.lote, orden";
		}		
		$Resp = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		$TotalLotePesoHum=0; //WSO
		$PesoHum =0;
		$TotalLotePesoSeco =0;
		$PesoSeco=0;
		$SubTotalPesoHum=0;
		$SubTotalPesoSeco=0;
		for ($i = 0; $i <=mysqli_num_rows($Resp) - 1; $i++)
		{
			if (mysqli_data_seek ($Resp, $i)) 
			{
				if ($Fila = mysqli_fetch_row($Resp))  
				{        				
					$Lote = $Fila[0];
					$Recargo = $Fila[1];
					//$PesoHum = $Fila[3];
					$F_Recep = $Fila[5];	
					if ($OpcSF=="F" && $OpcConsulta=="C")
						$N_Conjto = $Fila[7];
					else
						if ($OpcSF!="F" && $OpcConsulta=="C")
							$N_Conjto = $Fila[6];																							
					if ($OpcTR=="R")
					{
						//------------CONSULTA LEYES DE LOTE RECARGO---------
						$DatosLoteRec = array();
						$DatosLoteRec["lote"]=$Lote;
						$DatosLoteRec["recargo"]=$Recargo;
						$DatosLoteRec = LeyesLoteRecargo($DatosLoteRec,$ArrLeyes,"N","S","S","","","",$link);
						$ArrLeyes     = LeyesLoteRecargo($DatosLoteRec,$ArrLeyes,"N","S","S","","","L",$link);
						$PesoSeco=$DatosLoteRec["peso_seco2"];
						//----------------------------------------------------
						echo "<tr>\n";
						if ($OpcConsulta != "C")
							echo "<td align='center'>".substr($F_Recep,8,2)."/".substr($F_Recep,5,2)."</td>\n";
						else
							echo "<td align='center'>".$N_Conjto."</td>\n";
						echo "<td align='center'>".$Lote."</td>\n";
						if ($OpcTR=="R")			
							echo "<td align='center'>".$Recargo."</td>\n";
						if ($Humedad==true)		
							echo "<td align='center'>".number_format($DatosLoteRec["peso_humedo"],0,",",".")."</td>\n";										
						echo "<td align='center'>".number_format($DatosLoteRec["peso_seco"],0,",",".")."</td>\n";									
						reset($ArrLeyes);
						foreach($ArrLeyes as $k => $v)
						{
							$Color="";
							if ($k=="01" && $Humedad==true)
								echo "<td align='center'>".number_format($v[2],$ArrParamLeyes[$k][2],",",".")."</td>\n";
							else
								if ($k!="01" && $OpcHLF!="P")
								{
									$Ley = 0;
									$Fino = 0;
									if ($v[2]>0 && $PesoSeco>0 && $v[5]>0)
									{
										$Fino = ($v[2] * $PesoSeco)/$v[5];
										$Ley = ($Fino / $PesoSeco)*$ArrParamLeyes[$k][1];
									}									
									if ($OpcHLF == "F")
									{
										switch ($ArrLimites[$k][1])
										{
											case "<":
												if ($Fino<$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
											case ">":
												if ($Fino>$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
											case "=":
												if ($Fino=$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
										}											
										echo "<td ".$Color." align='center'>".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."</td>\n";
									}
									else
									{										
										switch ($ArrLimites[$k][1])
										{
											case "<":
												if ($Ley<$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
											case ">":
												if ($Ley>$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
											case "=":
												if ($Ley=$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
										}
										echo "<td ".$Color." align='center'>".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."</td>\n";
									}
								}
						}
					}					
					//TOTAL LOTE
					$TotalLotePesoHum = $TotalLotePesoHum + $PesoHum;
					$TotalLotePesoSeco = $TotalLotePesoSeco + $PesoSeco;
					//CONSULTO POR EL LOTE O CONJUNTO QUE SIGUE
					$Totalizar=true;	
					$i++;
					if ($i<=mysqli_num_rows($Resp)-1)
					{
						if (mysqli_data_seek($Resp, $i))
						{
							if ($Fila = mysqli_fetch_row($Resp))	
							{	 
								$Sgte = $Fila[0]; //LOTE									
								if ($Lote==$Sgte)
									$Totalizar=false;																				
							}								
						}								
						$i--;
					}					
					if ($Totalizar)
					{
						//------------CONSULTA LEYES DE LOTE ----------------
						$DatosLote = array();
						$DatosLote["lote"]=$Lote;
						$DatosLote["recargo"]="";
						$DatosLote    = LeyesLote($DatosLote,$ArrLoteLeyes,"N","S","S","","","","",$link);
						$ArrLoteLeyes = LeyesLote($DatosLote,$ArrLoteLeyes,"N","S","S","","","","L",$link);
						$TotalLotePesoHum  = isset($DatosLote["peso_humedo"])?$DatosLote["peso_humedo"]:0;
						$TotalLotePesoSeco = isset($DatosLote["peso_seco2"])?$DatosLote["peso_seco2"]:0;
						//----------------------------------------------------
						if ($OpcTR=="R")	
							echo "<tr class='ColorTabla02'>\n";
						else
							echo "<tr>\n";
						$Negrita01 = "<strong>";
						$Negrita02 = "</strong>";
						if ($OpcTR=="R")			
						{		
							echo "<td colspan=\"".$ColSpanSubTotal."\" align='left'>".$Negrita01."Total Lote:&nbsp;".$Lote."".$Negrita02."</td>\n";
						}
						else
						{
							$Negrita01 = "";
							$Negrita02 = "";
							if ($OpcConsulta != "C")
								echo "<td align='center'>".substr($F_Recep,8,2)."/".substr($F_Recep,5,2)."</td>\n";
							else
								echo "<td align='center'>".$N_Conjto."</td>\n";
							echo "<td colspan=\"".($ColSpanSubTotal-1)."\" align='center'>".$Negrita01."".$Lote."".$Negrita02."</td>\n";
						}
						$ArrLoteLeyes012 = isset($ArrLoteLeyes["01"][2])?$ArrLoteLeyes["01"][2]:0;
						if ($Humedad==true)
							echo "<td align='center'>".$Negrita01."".number_format($TotalLotePesoHum,0,",",".")."".$Negrita02."</td>\n";
						echo "<td align='center'>".$Negrita01."".number_format($TotalLotePesoSeco,0,",",".")."".$Negrita02."</td>\n";
						if ($Humedad == true)
							echo "<td align='center'>".$Negrita01."".number_format((float)$ArrLoteLeyes012,$ArrParamLeyes["01"][2],",",".")."".$Negrita02."</td>\n";
						reset($ArrLoteLeyes);
						foreach($ArrLoteLeyes as $k => $v)
						{
							$Color = "";
							$v1 = isset($v[1])?$v[1]:1;
							if ($k!="01"&&$k!=""&&$v1!='')
							{
								if ($OpcHLF!="P")
								{
									$Ley = 0;
									$Fino = 0;
									if ($v[2]>0 && $TotalLotePesoSeco>0 && $v[5]>0)
									{
										$Fino = ($v[2] * $TotalLotePesoSeco)/$v[5];
										$Ley = ($Fino / $TotalLotePesoSeco)*$ArrParamLeyes[$k][1];
									}
									if ($OpcHLF == "F")
									{
										switch ($ArrLimites[$k][1])
										{
											case "<":
												if ($Fino<$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
											case ">":
												if ($Fino>$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
											case "=":
												if ($Fino=$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
										}
										//echo "<td ".$Color." align='center'>".$Negrita01."".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."".$Negrita02."</td>\n";						
										echo "<td ".$Color." align='center'>".$Negrita01."".number_format($Fino,3,",",".")."".$Negrita02."</td>\n";						
									}
									else
									{
										switch ($ArrLimites[$k][1])
										{
											case "<":
												if ($Ley<$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
											case ">":
												if ($Ley>$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
											case "=":
												if ($Ley=$ArrLimites[$k][2])
													$Color = "bgcolor='YELLOW'";
												break;
										}
										//echo "<td ".$Color." align='center'>".$Negrita01."".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."".$Negrita02."</td>\n";						
										echo "<td ".$Color." align='center'>".$Negrita01."".number_format($Ley,4,",",".")."".$Negrita02."</td>\n";						
									}
								}
							}
							//SUB-TOTAL
							$v0 = isset($v[0])?$v[0]:0;
							$v2 = isset($v[2])?$v[2]:0;
							$v5 = isset($v[5])?$v[5]:0;
							$ArrSubTotalLeyes02 = isset($ArrSubTotalLeyes[$v0][2])?$ArrSubTotalLeyes[$v0][2]:0;
							$ArrParamLeyes00 = isset($ArrParamLeyes[$v0][0])?$ArrParamLeyes[$v0][0]:"";
							$ArrParamLeyes01 = isset($ArrParamLeyes[$v0][1])?$ArrParamLeyes[$v0][1]:"";
							$ArrParamLeyes03 = isset($ArrParamLeyes[$v0][3])?$ArrParamLeyes[$v0][3]:"";
							
							if ($TotalLotePesoSeco>0 && $v2>0 && $v5>0) 
								$ArrSubTotalLeyes[$v0][2] = (float)$ArrSubTotalLeyes02 + (($TotalLotePesoSeco * $v2)/$v5);//VALOR
							else
								$ArrSubTotalLeyes[$v0][2] = $ArrSubTotalLeyes02;
							
							$ArrSubTotalLeyes[$v0][3] = $ArrParamLeyes00;//COD UNIDAD
							$ArrSubTotalLeyes[$v0][4] = $ArrParamLeyes03;//NOM UNIDAD
							$ArrSubTotalLeyes[$v0][5] = $ArrParamLeyes01;//CONVERSION
							$Fino = 0;
							$Ley = 0;
						}
						echo "</tr>\n";
						$SubTotalPesoHum = $SubTotalPesoHum + $TotalLotePesoHum;
						$SubTotalPesoSeco = $SubTotalPesoSeco + $TotalLotePesoSeco;
						$TotalLotePesoHum = 0;
						$TotalLotePesoSeco = 0;
						$TotalLoteHumedad = 0;
						//LIMPIA ARREGLO DE LEYES POR RECARGO
						reset($ArrLeyes);
						do {			 
						  $key = key ($ArrLeyes);
						  $ArrLeyes[$key][2] = 0;
						  $ArrLeyes[$key][3] = "";
						  $ArrLeyes[$key][4] = "";
						  $ArrLeyes[$key][5] = "";
						} while (next($ArrLeyes));
						//LIMPIA ARREGLO DE TOTAL DE LEYES POR RECARGO
						reset($ArrLoteLeyes);
						do {			 
						  $key = key ($ArrLoteLeyes);
						  $ArrLoteLeyes[$key][2] = 0;
						  $ArrLoteLeyes[$key][3] = "";
						  $ArrLoteLeyes[$key][4] = "";
						  $ArrLoteLeyes[$key][5] = "";
						} while (next($ArrLoteLeyes));							
					}//FIN TOTAL LOTE
					echo "</tr>\n";
				}
			}
		}
		//SUB-TOTAL 
		if ($SubTotalPesoSeco>0 && $SubTotalPesoHum>0)
			$SubTotalHumedad = 100 - (($SubTotalPesoSeco * 100)/$SubTotalPesoHum);
		else
			$SubTotalHumedad = 0;
		echo "<tr class='ColorTabla03' bgcolor='#FFFFFF'>\n";
		echo "<td colspan=\"".$ColSpanSubTotal."\" align='left'><font color='blue'><strong>";
		switch ($OpcConsulta)
		{			
			case "F":		
				switch ($OpcSF)
				{
					case "S":
						echo "Total Prod.&nbsp;".str_pad($FilaAux["cod_subproducto"],3,'0',STR_PAD_LEFT);
						break;
					case "F":
						echo "Total Flujo.&nbsp;";
						echo str_pad($FilaAux["flujo"],3,'0',STR_PAD_LEFT);
						break;	
				}							
				break;
			case "L":
				switch ($OpcSF)
				{
					case "S":
						echo "Total Prod.&nbsp;".str_pad($FilaAux["cod_subproducto"],3,'0',STR_PAD_LEFT);
						break;
					case "F":
						echo "Total Flujo.&nbsp;".str_pad($FilaAux["flujo"],3,'0',STR_PAD_LEFT);
						break;	
				}						
				break;
			case "C":
				echo "Total Conjto:&nbsp;".$N_Conjto;				
				break;
			case "P":
				switch ($OpcSF)
				{
					case "S":
						echo "Total Prod.&nbsp;";
						echo str_pad($FilaAux["cod_subproducto"],3,'0',STR_PAD_LEFT);
						break;
					case "F":
						echo "Total Prov.&nbsp;";
						echo str_pad($FilaAux["rut_proveedor"],3,'0',STR_PAD_LEFT);
						break;	
				}												
				break;
		}				
		echo "</strong></font></td>\n";
		if ($Humedad==true)
			echo "<td align='center'><font color='blue'><strong>".number_format($SubTotalPesoHum,0,",",".")."</strong></font></td>\n";
		echo "<td align='center'><font color='blue'><strong>".number_format($SubTotalPesoSeco,0,",",".")."</strong></font></td>\n";
		if ($Humedad==true)
			echo "<td align='center'><font color='blue'><strong>".number_format($SubTotalHumedad,$ArrParamLeyes["01"][2],",",".")."</strong></font></td>\n";
		reset($ArrSubTotalLeyes);
		foreach($ArrSubTotalLeyes as $k => $v)
		{
			$Color = "";
			if ($k!="" && $k!="01" && ($OpcHLF!="P"))
			{
				if ($k!="")
				{
					$Ley = 0;
					$Fino = $v[2];
					if ($Fino>0 && $ArrParamLeyes[$k][1]>0 && $SubTotalPesoSeco>0)
						$Ley = ($Fino*$ArrParamLeyes[$k][1])/$SubTotalPesoSeco;							
					if ($OpcHLF=="F")
					{
						switch ($ArrLimites[$k][1])
						{
							case "<":
								if ($Fino<$ArrLimites[$k][2])
									$Color = "bgcolor='YELLOW'";
								break;
							case ">":
								if ($Fino>$ArrLimites[$k][2])
									$Color = "bgcolor='YELLOW'";
								break;
							case "=":
								if ($Fino=$ArrLimites[$k][2])
									$Color = "bgcolor='YELLOW'";
								break;
						}
						//echo "<td ".$Color." align='center'><font color='blue'><strong>".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."</strong></font></td>\n";
						echo "<td ".$Color." align='center'><font color='blue'><strong>".number_format($Fino,3,",",".")."</strong></font></td>\n";
					}
					else
					{
						switch ($ArrLimites[$k][1])
						{
							case "<":
								if ($Ley<$ArrLimites[$k][2])
									$Color = "bgcolor='YELLOW'";
								break;
							case ">":
								if ($Ley>$ArrLimites[$k][2])
									$Color = "bgcolor='YELLOW'";
								break;
							case "=":
								if ($Ley=$ArrLimites[$k][2])
									$Color = "bgcolor='YELLOW'";
								break;
						}
						echo "<td ".$Color." align='center'><font color='blue'><strong>".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."</strong></font></td>\n";
					}
				}
				/*else
				{
					 if ($OpcHLF!="H")
						//echo "<td align='center'><font color='blue'><strong>".number_format(0,$ArrParamLeyes[$k][2],",",".")."</strong></font></td>\n";
				}*/
			}
			//TOTAL
			$ArrTotalLeyes2 = isset($ArrTotalLeyes[$k][2])?$ArrTotalLeyes[$k][2]:0;
			$ArrParamLeyes0 = isset($ArrParamLeyes[$k][0])?$ArrParamLeyes[$k][0]:"";
			$ArrParamLeyes1 = isset($ArrParamLeyes[$k][1])?$ArrParamLeyes[$k][1]:0;
			$ArrParamLeyes3 = isset($ArrParamLeyes[$k][3])?$ArrParamLeyes[$k][3]:"";
			if ($SubTotalPesoSeco>0 && $v[2]>0 && $v[5]>0) 
				$ArrTotalLeyes[$k][2] = (float)$ArrTotalLeyes2 + (($SubTotalPesoSeco * $Ley)/$ArrParamLeyes1);//VALOR
			else
				$ArrTotalLeyes[$k][2] = $ArrTotalLeyes2;
			$ArrTotalLeyes[$k][3] = $ArrParamLeyes0;//COD UNIDAD
			$ArrTotalLeyes[$k][4] = $ArrParamLeyes3;//NOM UNIDAD
			$ArrTotalLeyes[$k][5] = $ArrParamLeyes1;//CONVERSION
		}
		echo "</tr>\n";
		$TotalPesoHum = $TotalPesoHum + $SubTotalPesoHum;
		$TotalPesoSeco = $TotalPesoSeco + $SubTotalPesoSeco;
		$SubTotalPesoHum = 0;
		$SubTotalPesoSeco = 0;
		$SubTotalHumedad=0;
		//LIMPIA ARREGLO DE TOTAL DE LEYES POR RECARGO
		reset($ArrSubTotalLeyes);
		do {			 
		  $key = key ($ArrSubTotalLeyes);
		  $ArrSubTotalLeyes[$key][2] = "";
		  $ArrSubTotalLeyes[$key][3] = "";
		  $ArrSubTotalLeyes[$key][4] = "";
		  $ArrSubTotalLeyes[$key][5] = "";
		} while (next($ArrSubTotalLeyes));	
	}
	//TOTAL
	if ($TotalPesoSeco>0 && $TotalPesoHum>0)
		$TotalHumedad = 100 - (($TotalPesoSeco * 100)/$TotalPesoHum);
	else
		$TotalHumedad = 0;
	switch ($OpcConsulta)
	{
		case "F":
			echo "<tr class='ColorTabla03' bgcolor='#CCCCCC'><td colspan=\"".$ColSpanSubTotal."\" align='left'><strong>Total Dia&nbsp;".substr($Fila01["fecha_recepcion"],8,2)."/".substr($Fila01["fecha_recepcion"],5,2)."</strong></td>\n";
			break;
		case "P":
			switch ($OpcSF)
			{
				case "S":
					echo "<tr class='ColorTabla03' bgcolor='#CCCCCC'><td colspan=\"".$ColSpanSubTotal."\" align='left'><strong>Total Proveedor</strong></td>\n";
					break;
				case "F":
					echo "<tr class='ColorTabla03' bgcolor='#CCCCCC'><td colspan=\"".$ColSpanSubTotal."\" align='left'><strong>Total Flujo ".$Fila01["flujo"]."</strong></td>\n";
					break;
			}
			break;
		default:
			echo "<tr class='ColorTabla03' bgcolor='#CCCCCC'><td colspan=\"".$ColSpanSubTotal."\" align='left'><strong>Total Consulta</strong></td>\n";
			break;
	}
	if ($Humedad==true)
		echo "<td align='center'><strong>".number_format($TotalPesoHum,0,",",".")."</strong></td>\n";
	echo "<td align='center'><strong>".number_format($TotalPesoSeco,0,",",".")."</strong></td>\n";
	if ($Humedad==true)
		echo "<td align='center'><strong>".number_format($TotalHumedad,$ArrParamLeyes["01"][2],",",".")."</strong></td>\n";
	reset($ArrTotalLeyes);
	foreach($ArrTotalLeyes as $k => $v)
	{
		$Color = "";
		if ($k!="01" && $OpcHLF!="P")
		{
			if ($k!="")
			{
				$Ley = 0;
				$Fino = $v[2];
				if ($Fino>0 && $ArrParamLeyes[$k][1]>0 && $TotalPesoSeco>0)
					$Ley = ($Fino*$ArrParamLeyes[$k][1])/$TotalPesoSeco;		
				if ($OpcHLF == "F")		
				{
					switch ($ArrLimites[$k][1])
					{
						case "<":
							if ($Fino<$ArrLimites[$k][2])
								$Color = "bgcolor='YELLOW'";
							break;
						case ">":
							if ($Fino>$ArrLimites[$k][2])
								$Color = "bgcolor='YELLOW'";
							break;
						case "=":
							if ($Fino=$ArrLimites[$k][2])
								$Color = "bgcolor='YELLOW'";
							break;
					}
					//echo "<td ".$Color." align='center'><strong>".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."</strong></td>\n";
					echo "<td ".$Color." align='center'><strong>".number_format($Fino,3,",",".")."</strong></td>\n";
				}
				else
				{
					switch ($ArrLimites[$k][1])
					{
						case "<":
							if ($Ley<$ArrLimites[$k][2])
								$Color = "bgcolor='YELLOW'";
							break;
						case ">":
							if ($Ley>$ArrLimites[$k][2])
								$Color = "bgcolor='YELLOW'";
							break;
						case "=":
							if ($Ley=$ArrLimites[$k][2])
								$Color = "bgcolor='YELLOW'";
							break;
					}
					echo "<td ".$Color." align='center'><strong>".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."</strong></td>\n";
				}
			}
			/*else
			{
				echo "<td align='center'><strong>".number_format(0,$ArrParamLeyes[$k][2],",",".")."</strong></td>\n";
			}*/
		}
	}
	echo "</tr>\n";
	if ($OpcConsulta!="F" && $OpcConsulta!="P")
		break;
	else
	{
		$TotalPesoSeco = 0;
		$TotalPesoHum = 0;
		$TotalHumedad = 0;
		//LIMPIA ARREGLO DE TOTAL DE LEYES POR DIA
		reset($ArrTotalLeyes);
		do {			 
		  $key = key ($ArrTotalLeyes);
		  $ArrTotalLeyes[$key][2] = "";
		  $ArrTotalLeyes[$key][3] = "";
		  $ArrTotalLeyes[$key][4] = "";
		  $ArrTotalLeyes[$key][5] = "";
		} while (next($ArrTotalLeyes));	
	}
}	
echo "</table>\n";
?>  

</form>
</body>
</html>