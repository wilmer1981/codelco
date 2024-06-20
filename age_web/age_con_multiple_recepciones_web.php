<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");	
	$CmbSubProducto = isset($_REQUEST['CmbSubProducto']) ? $_REQUEST['CmbSubProducto'] : '';
	$CmbProveedor = isset($_REQUEST['CmbProveedor']) ? $_REQUEST['CmbProveedor'] : '';
	$OpcConsulta = isset($_REQUEST['OpcConsulta']) ? $_REQUEST['OpcConsulta'] : '';
	$OpcHLF = isset($_REQUEST['OpcHLF']) ? $_REQUEST['OpcHLF'] : '';
	$OpcSF  = isset($_REQUEST['OpcSF']) ? $_REQUEST['OpcSF'] : '';
	$OpcTR  = isset($_REQUEST['OpcTR']) ? $_REQUEST['OpcTR'] : '';
	$CmbMes = isset($_REQUEST['CmbMes']) ? $_REQUEST['CmbMes'] : date('m');
	$CmbAno = isset($_REQUEST['CmbAno']) ? $_REQUEST['CmbAno'] : date('Y');
	$CmbFlujos  = isset($_REQUEST['CmbFlujos']) ? $_REQUEST['CmbFlujos'] : '';
	$TxtLoteIni = isset($_REQUEST['TxtLoteIni']) ? $_REQUEST['TxtLoteIni'] : '';
	$TxtLoteFin = isset($_REQUEST['TxtLoteFin']) ? $_REQUEST['TxtLoteFin'] : '';
	$TxtConjIni = isset($_REQUEST['TxtConjIni']) ? $_REQUEST['TxtConjIni'] : '';
	$TxtConjFin  = isset($_REQUEST['TxtConjFin']) ? $_REQUEST['TxtConjFin'] : '';
	$TxtFechaIni = isset($_REQUEST['TxtFechaIni']) ? $_REQUEST['TxtFechaIni'] : "";
	$TxtFechaFin = isset($_REQUEST['TxtFechaFin']) ? $_REQUEST['TxtFechaFin'] : "";
	
	$ArrLeyes = array();
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
		$Consulta = "select STRAIGHT_JOIN distinct t3.cod_leyes, t4.abreviatura ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on ";
		$Consulta.= " t1.lote=t2.lote inner join age_web.leyes_por_lote t3 on";
		$Consulta.= " t2.lote=t3.lote inner join proyecto_modernizacion.leyes t4 on ";
		$Consulta.= " t3.cod_leyes=t4.cod_leyes ";
		$Consulta.= " where t1.estado_lote<>'6' ";
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
			$RutAux = str_pad(($Datos[0]*1),8,"0",STR_PAD_LEFT)."-".$Datos[1];
			$Consulta.= " and t1.rut_proveedor='".$RutAux."'";
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
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "I":
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;	
		case "S":
			f.action = "age_con_multiple_recepciones.php";
			f.submit();
			break;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla02">
    <td colspan="2"><strong>CONSULTA  DE RECEPCIONES </strong></td>
  </tr>
<?php
	if ($OpcConsulta=="F")
	{
?>		  
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Fecha</span></td>
    <td width="401"><?php echo $TxtFechaIni; ?> Al <?php echo $TxtFechaFin; ?></td>
  </tr>
<?php
	}
	if ($OpcConsulta=="L")
	{
?>	
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Rango de Lote:</span></td>
    <td><?php echo $TxtLoteIni; ?> Al <?php echo $TxtLoteFin; ?></td>
  </tr>
<?php	
	}
	if ($OpcSF=="S")
	{
?>  
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">SubProducto:</span></td>
    <td>
<?php
	if ($CmbSubProducto == "S")
	{
		echo "Todos";
	}
	else
	{
		$Consulta = "select cod_subproducto, descripcion, abreviatura, LPAD(cod_subproducto,2,'0') as orden ";
		$Consulta.= " from proyecto_modernizacion.subproducto ";
		$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' order by orden";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{		
			echo  $Fila["orden"]." - ".$Fila["abreviatura"]."\n";
		}
	}
?>
      </td>
  </tr>
<?php
  	}
	if ($OpcSF=="F")
	{
?>  
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Flujo:</span></td>
    <td>
<?php
	if ($CmbFlujos == "S")
	{
		echo "Todos";
	}
	else
	{
		$Consulta = "select * from proyecto_modernizacion.flujos ";
		$Consulta.= "where cod_flujo = '".$CmbFlujos."' and sistema='RAM'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			echo $Fila["descripcion"];
		}
	}
?>	
	</td>
  </tr>
<?php
	}  
?>  
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Proveedor:</span></td>
    <td>
      <?php
	if ($CmbProveedor == "S")
	{
		echo "Todos";
	}
	else
	{	  
		$RutAux = $CmbProveedor;
		$Consulta = "select * ";
		$Consulta.= " from sipa_web.proveedores ";
		$Consulta.= " where rut_prv='".$RutAux."'";
		$Consulta.= " order by TRIM(nombre_prv) ";
		$Resp = mysqli_query($link, $Consulta);	
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$Datos = explode("-",$Fila["rut_prv"]);
			$RutAux = ($Datos[0]*1)."-".$Datos[1];
			echo  $Fila["rut_prv"]." - ".$Fila["nombre_prv"]."\n";
		}
	}
?>
      </td>
  </tr>
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Ver Datos: </span></td>
    <td height="18">
<?php
	if ($OpcTR=="T")
	{
		echo "Acumulado por Lote";
	}
	else
	{
		if ($OpcTR=="R")
		{
			echo "Detalle por Recargo";
		}
	}
?>	
	</td>
  </tr>
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Detalle Lote: </span></td>
    <td>
<?php
	switch ($OpcHLF)
	{
		case "P":
			echo "De Peso y Humedades";
			break;
		case "L":
			echo "De Peso y Leyes";
			break;
		case "F":
			echo "De Peso y Finos";
			break;
	}
?>		
	</td>
  </tr>
  <tr align="center">
    <td height="30" colspan="2">          <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
          <input name="BtnSalir" type="submit" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td></tr>
</table>
<br>
<?php
if ($Humedad==true)
	$ColSpan = $CantLeyes+12; 
else
	$ColSpan = $CantLeyes+11;
if ($OpcTR=="R")			
	$ColSpanSubTotal = 10;
else		 
	$ColSpanSubTotal = 2;
echo "<table width='400'  border='0' align='center' cellpadding='3' cellspacing='0'>\n";
switch ($OpcConsulta)
{
	case "F":			
		$Consulta = "select STRAIGHT_JOIN distinct t2.fecha_recepcion  ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote ";
		if ($OpcSF=="F")		
		{		
			$Consulta.= " left join age_web.recpromin t3 on ";
			$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
			$Consulta.= " left join age_web.recpromin t4 on t1.cod_producto = t4.cod_producto ";
			$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
		}
		$Consulta.= " where t1.estado_lote<>'6' ";		
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
			$Consulta = "SELECT STRAIGHT_JOIN DISTINCT ifnull(case when ISNULL(t3.flujo) then t4.flujo else t3.flujo end,0) as flujo,";
			$Consulta.= " ifnull(case when ISNULL(t3.flujo) then lpad(t4.flujo,4,'0') else lpad(t3.flujo,4,'0') end,0) as orden ";
		}
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote ";
		if ($OpcSF=="F")		
		{		
			$Consulta.= " left join age_web.recpromin t3 on ";
			$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
			$Consulta.= " left join age_web.recpromin t4 on t1.cod_producto = t4.cod_producto ";
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
			$Consulta = "SELECT STRAIGHT_JOIN DISTINCT ifnull(case when ISNULL(t3.flujo) then t4.flujo else t3.flujo end,0) as flujo,";
			$Consulta.= " ifnull(case when ISNULL(t3.flujo) then lpad(t4.flujo,4,'0') else lpad(t3.flujo,4,'0') end,0) as orden, t1.num_conjunto ";
		}
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote ";
		if ($OpcSF=="F")		
		{		
			$Consulta.= " left join age_web.recpromin t3 on ";
			$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
			$Consulta.= " left join age_web.recpromin t4 on t1.cod_producto = t4.cod_producto ";
			$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
		}
		$Consulta.= " where t1.num_conjunto between '".$TxtConjIni."' and '".$TxtConjFin."'  and t1.estado_lote<>'6' ";	
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
			$Consulta = "SELECT STRAIGHT_JOIN DISTINCT ifnull(case when ISNULL(t3.flujo) then t4.flujo else t3.flujo end,0) as flujo,";
			$Consulta.= " ifnull(case when ISNULL(t3.flujo) then lpad(t4.flujo,4,'0') else lpad(t3.flujo,4,'0') end,0) as orden ";
		}
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote ";
		if ($OpcSF=="F")		
		{		
			$Consulta.= " left join age_web.recpromin t3 on ";
			$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
			$Consulta.= " left join age_web.recpromin t4 on t1.cod_producto = t4.cod_producto ";
			$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
		}
		$Consulta.= " where t1.estado_lote<>'6' ";		
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
			echo "<td align='center' colspan='".$ColSpan."'><strong>".substr($Fila01["fecha_recepcion"],8,2)."-".substr($Fila01["fecha_recepcion"],5,2)."-".substr($Fila01["fecha_recepcion"],0,4)."</strong></td>\n";			
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
						$NomFlujo = $FilaAux2["descripcion"];
					echo "<td align='center' colspan='".$ColSpan."'><strong>".str_pad($Fila01["flujo"],3,"0",STR_PAD_LEFT)." - ".$NomFlujo."</strong></td>\n";			
					break;
					case "S":
						$NomProveedor="";
						$RutAux = $Fila01["rut_proveedor"];
						$Consulta = "select * ";
						$Consulta.= " from sipa_web.proveedores ";
						$Consulta.= " where rut_prv='".$RutAux."'";
						$Consulta.= " order by TRIM(nombre_prv) ";
						$RespProv = mysqli_query($link, $Consulta);	
						while ($FilaProv = mysqli_fetch_array($RespProv))
						{
							$NomProveedor = $FilaProv["nombre_prv"];
						}
						echo "<td align='center' colspan='".$ColSpan."'>".$Fila01["rut_proveedor"]." - ".$NomProveedor."</td>";
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
				$Consulta = "SELECT STRAIGHT_JOIN DISTINCT ifnull(case when ISNULL(t3.flujo) then t4.flujo else t3.flujo end,0) as flujo,";
				$Consulta.= " ifnull(case when ISNULL(t3.flujo) then lpad(t4.flujo,4,'0') else lpad(t3.flujo,4,'0') end,0) as orden ";
			}
			$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
			$Consulta.= " on t1.lote = t2.lote ";
			if ($OpcSF=="F")		
			{		
				$Consulta.= " left join age_web.recpromin t3 on ";
				$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
				$Consulta.= " left join age_web.recpromin t4 on t1.cod_producto = t4.cod_producto ";
				$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
			}
			$Consulta.= " where t1.estado_lote<>'6' ";
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
				$Consulta = "SELECT STRAIGHT_JOIN DISTINCT ifnull(case when ISNULL(t3.flujo) then t4.flujo else t3.flujo end,0) as flujo,";
				$Consulta.= " ifnull(case when ISNULL(t3.flujo) then lpad(t4.flujo,4,'0') else lpad(t3.flujo,4,'0') end,0) as orden, t1.rut_proveedor ";
			}
			$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
			$Consulta.= " on t1.lote = t2.lote ";
			if ($OpcSF=="F")		
			{		
				$Consulta.= " left join age_web.recpromin t3 on ";
				$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
				$Consulta.= " left join age_web.recpromin t4 on t1.cod_producto = t4.cod_producto ";
				$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
			}
			$Consulta.= " where t1.estado_lote<>'6' ";
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
	$TotalPesoSeco = 0;
	$TotalPesoHum = 0;
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
			echo "<td align='left' colspan='".$ColSpan."'>".str_pad($FilaAux["cod_subproducto"],3,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>\n";
		if ($OpcSF == "F")
		{
			if ($OpcConsulta == "P")
			{				
				$NomSubProd=""; 
				$NomProveedor="";
				$RutAux = $FilaAux["rut_proveedor"];
				$Consulta = "select * ";
				$Consulta.= " from rec_web.proveedores ";
				$Consulta.= " where rut_prv='".$RutAux."'";
				$Consulta.= " order by TRIM(nombre_prv) ";
				$RespProv = mysqli_query($link, $Consulta);	
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$NomProveedor = $FilaProv["nombre_prv"];
				}
				echo "<td align='left' colspan='".$ColSpan."'>".$FilaAux["rut_proveedor"]." - ".$NomProveedor."</td>";
			}
			else			
				echo "<td align='left' colspan='".$ColSpan."'>".str_pad($FilaAux["flujo"],3,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>\n";			
		}
		echo "</tr>\n";
		echo "<tr class='ColorTabla02'>\n";
		if ($OpcConsulta!="C")
			echo "<td align='center'>Fecha</td>\n";
		else
			echo "<td align='center'>Conjto</td>\n";
		echo "<td align='center'>Lote</td>\n";
		if ($OpcTR=="R")
		{
			echo "<td align='center'>Rec.</td>\n";
			echo "<td align='center'>Ult.Rec.</td>\n";
			echo "<td align='center'>Corr</td>\n";
			echo "<td align='center'>Guia</td>\n";
			echo "<td align='center'>P.Bruto</td>\n";
			echo "<td align='center'>P.Tara</td>\n";
			echo "<td align='center'>P.Neto</td>\n";
			echo "<td align='center'>Conj.</td>\n";
		}	
		if ($Humedad==true)
			echo "<td align='center'>P.Hum.<br>Kg.</td>\n";
		echo "<td align='center'>P.Seco<br>Kg.</td>\n";
		reset($ArrLeyes);
		foreach($ArrLeyes as $k => $v)
		{
			if ($OpcHLF == "F")
			{
				if ($k=="04" || $k=="05")
					$AbrevUnidad =  "g/T";
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
		echo "</tr>\n";
	 
		$Consulta = "select STRAIGHT_JOIN distinct t1.lote, t2.recargo, t1.rut_proveedor, sum(t2.peso_neto) as peso_hum,";
		$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion, t1.num_conjunto, t2.fecha_recepcion,t2.fin_lote,t2.corr,t2.guia_despacho,t2.peso_bruto,t2.peso_tara,t2.peso_neto ";
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
			$Consulta.= " left join age_web.recpromin t3 on ";
			$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto and t1.rut_proveedor=t3.rut_proveedor ";
			$Consulta.= " left join age_web.recpromin t4 on t1.cod_producto = t4.cod_producto ";
			$Consulta.= " and t1.cod_subproducto=t4.cod_subproducto and SUBSTRING(t4.rut_proveedor,1,8)='99999999' ";			
		}
		$Consulta.= " where t1.estado_lote<>'6' ";
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
				$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
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
		if ($OpcConsulta!="C")
			$Consulta.= " group by t1.lote, t2.recargo order by t1.lote, orden";
		else
			$Consulta.= " group by t1.num_conjunto, t1.lote, t2.recargo order by t1.num_conjunto, t1.lote, orden";
		$Resp = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		for ($i = 0; $i <=mysqli_num_rows($Resp) - 1; $i++)
		{
			if (mysqli_data_seek($Resp, $i)) 
			{
				$TotalLotePesoHum =0;
				$TotalLotePesoSeco=0;
				if ($Fila = mysqli_fetch_row($Resp))  
				{        				
					$Lote = $Fila[0];
					$Recargo = $Fila[1];
					$PesoHum = $Fila[3];
					$F_Recep = $Fila[5];
					$Fin = $Fila[8];
					$Corr = $Fila[9];
					$Guia = $Fila[10];
					$PBruto = $Fila[11];
					$PTara = $Fila[12];
					$PNeto = $Fila[13];
					$Conj = $Fila[6];
					$NomProveedor="";
					$Consulta = "select * ";
					$Consulta.= " from sipa_web.proveedores ";
					$Consulta.= " where rut_prv='".$Fila[2]."'";
					$Consulta.= " order by TRIM(nombre_prv) ";
					$RespProv = mysqli_query($link, $Consulta);	
					while ($FilaProv = mysqli_fetch_array($RespProv))
					{
						$NomProveedor = $FilaProv["nombre_prv"];
					}						
					if ($OpcSF=="F" && $OpcConsulta=="C")
						$N_Conjto = $Fila[7];
					else
						if ($OpcSF!="F" && $OpcConsulta=="C")
							$N_Conjto = $Fila[6];	

					$PesoSeco=0;
					if ($OpcTR=="R")
					{
						//------------CONSULTA LEYES DE LOTE RECARGO----------
						$DatosLoteRec = array();
						$DatosLoteRec["lote"]=$Lote;
						$DatosLoteRec["recargo"]=$Recargo;
						if ($OpcConsulta=="F")
							LeyesLoteRecargo($DatosLoteRec,$ArrLeyes,"S","S","S",$Fila01["fecha_recepcion"],$Fila01["fecha_recepcion"],$link);
						else
							LeyesLoteRecargo($DatosLoteRec,$ArrLeyes,"N","S","S","","",$link);
						$PesoSeco=$DatosLoteRec["peso_seco2"];
						//------------------------------------------------------	
						echo "<tr>\n";
						if ($OpcConsulta != "C")
							echo "<td align='center'>".substr($F_Recep,8,2)."/".substr($F_Recep,5,2)."</td>\n";
						else
							echo "<td align='center'>".$N_Conjto."</td>\n";
						echo "<td align='center'>".$Lote."</td>\n";
						if ($OpcTR=="R")
						{			
							echo "<td align='center'>".$Recargo."</td>\n";
							echo "<td align='center'>".$Fin."</td>\n";
							echo "<td align='center'>".$Corr."</td>\n";
							echo "<td align='center'>".$Guia."</td>\n";
							echo "<td align='center'>".number_format($PBruto,0,",",".")."</td>\n";
							echo "<td align='center'>".number_format($PTara,0,",",".")."</td>\n";
							echo "<td align='center'>".number_format($PNeto,0,",",".")."</td>\n";
							echo "<td align='center'>".$Conj."</td>\n";
						}	
						if ($Humedad==true)		
							echo "<td align='center'>".number_format($PesoHum,0,",",".")."</td>\n";
					}
									
					//$PesoSeco = $PesoHum - ($PesoHum*$PorcHum)/100;
					if ($OpcTR=="R")
					{	
						echo "<td align='center'>".number_format($PesoSeco,0,",",".")."</td>\n";									
						reset($ArrLeyes);
						foreach($ArrLeyes as $k => $v)
						{
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
										echo "<td align='center'>".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."</td>\n";
									else
										echo "<td align='center'>".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."</td>\n";
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
					$SubTotalPesoHum =0; //WSO	
					$SubTotalPesoSeco =0;			
					if ($Totalizar)
					{
						//------------CONSULTA LEYES DE LOTE -----------------
						$DatosLote = array();
						$DatosLote["lote"]=$Lote;
						$DatosLote["recargo"]="";
						if ($OpcConsulta=="F")
							LeyesLote($DatosLote,$ArrLoteLeyes,"S","S","S",$Fila01["fecha_recepcion"],$Fila01["fecha_recepcion"],"",$link);
						else
							LeyesLote($DatosLote,$ArrLoteLeyes,"N","S","S","","","",$link);
						$TotalLotePesoHum = isset($DatosLote["peso_humedo"])?$DatosLote["peso_humedo"]:0;
						$TotalLotePesoSeco = isset($DatosLote["peso_seco2"])?$DatosLote["peso_seco2"]:0;
						//$TotalLotePesoHum = $DatosLote["peso_humedo"];
						//$TotalLotePesoSeco = $DatosLote["peso_seco2"];
						$Decimales=0;
						$recepcion = isset($DatosLote["recepcion"])?$DatosLote["recepcion"]:"";
						if ($recepcion=="PMN")
							$Decimales=3;						
						//----------------------------------------------------
						if ($TotalLotePesoSeco>0 && $TotalLotePesoHum>0)
							$TotalLoteHumedad = abs(100 - (($TotalLotePesoSeco * 100)/$TotalLotePesoHum));
						else
							$TotalLoteHumedad = 0;
						if ($OpcTR=="R")	
							echo "<tr class='ColorTabla02'>\n";
						else
							echo "<tr>\n";
						$Negrita01 = "<strong>";
						$Negrita02 = "</strong>";
						if ($OpcTR=="R")			
						{		
							echo "<td colspan='".$ColSpanSubTotal."' align='left'>".$Negrita01."Total Lote:&nbsp;".$Lote."&nbsp;&nbsp;Prov:&nbsp;".$NomProveedor."".$Negrita02."</td>\n";
						}
						else
						{
							$Negrita01 = "";
							$Negrita02 = "";
							if ($OpcConsulta != "C")
								echo "<td align='center'>".substr($F_Recep,8,2)."/".substr($F_Recep,5,2)."</td>\n";
							else
								echo "<td align='center'>".$N_Conjto."</td>\n";
							echo "<td colspan='".($ColSpanSubTotal-1)."' align='center'>".$Negrita01."".$Lote."".$Negrita02."</td>\n";
						}
						if ($Humedad==true)
							echo "<td align='center'>".$Negrita01."".number_format($TotalLotePesoHum,$Decimales,",",".")."".$Negrita02."</td>\n";
						echo "<td align='center'>".$Negrita01."".number_format($TotalLotePesoSeco,$Decimales,",",".")."".$Negrita02."</td>\n";
						if ($Humedad == true)
							echo "<td align='center'>".$Negrita01."".number_format($TotalLoteHumedad,$ArrParamLeyes["01"][2],",",".")."".$Negrita02."</td>\n";
						reset($ArrLoteLeyes);
						foreach($ArrLoteLeyes as $k => $v)
						{
							if ($k!="01")
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
										echo "<td align='center'>".$Negrita01."".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."".$Negrita02."</td>\n";						
									else
										echo "<td align='center'>".$Negrita01."".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."".$Negrita02."</td>\n";						
								}
							}
							//SUB-TOTAL
							//$ArrSubTotalLeyes02 = isset($ArrSubTotalLeyes[$v[0]][2])?$ArrSubTotalLeyes[$v[0]][2]:0;
							if ($TotalLotePesoSeco>0 && $v[2]>0 && $v[5]>0) 
								$ArrSubTotalLeyes[$v[0]][2] = $ArrSubTotalLeyes[$v[0]][2] + (($TotalLotePesoSeco * $v[2])/$v[5]);//VALOR
							else
								$ArrSubTotalLeyes[$v[0]][2] = $ArrSubTotalLeyes[$v[0]][2];

							$ArrSubTotalLeyes[$v[0]][3] = $ArrParamLeyes[$v[0]][0];//COD UNIDAD
							$ArrSubTotalLeyes[$v[0]][4] = $ArrParamLeyes[$v[0]][3];//NOM UNIDAD
							$ArrSubTotalLeyes[$v[0]][5] = $ArrParamLeyes[$v[0]][1];//CONVERSION
							$Fino = "";
							$Ley = "";
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
		echo "<td colspan='".$ColSpanSubTotal."' align='left'><font color='blue'><strong>";
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
			echo "<td align='center'><font color='blue'><strong>".number_format($SubTotalPesoHum,$Decimales,",",".")."</strong></font></td>\n";
		echo "<td align='center'><font color='blue'><strong>".number_format($SubTotalPesoSeco,$Decimales,",",".")."</strong></font></td>\n";
		if ($Humedad==true)
			echo "<td align='center'><font color='blue'><strong>".number_format($SubTotalHumedad,$ArrParamLeyes["01"][2],",",".")."</strong></font></td>\n";
		reset($ArrSubTotalLeyes);
		foreach($ArrSubTotalLeyes as $k => $v)
		{
			if ($k!="01" && ($OpcHLF!="P"))
			{
				if ($k!="")
				{
					$Ley = 0;
					$Fino = $v[2];
					if ($Fino>0 && $ArrParamLeyes[$k][1]>0 && $SubTotalPesoSeco>0)
						$Ley = ($Fino*$ArrParamLeyes[$k][1])/$SubTotalPesoSeco;		
					echo "<td align='center'><font color='blue'>";
					if ($OpcHLF=="F")
						echo "<strong>".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."</strong></font></td>\n";
					else
						echo "<strong>".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."</strong></font></td>\n";
				}
				else
				{
					 if ($OpcHLF!="H")
						echo "<td align='center'><font color='blue'><strong>".number_format(0,$ArrParamLeyes[$k][2],",",".")."</strong></font></td>\n";
				}
			}
			//TOTAL
			if ($SubTotalPesoSeco>0 && $v[2]>0 && $v[5]>0) 
				$ArrTotalLeyes[$k][2] = $ArrTotalLeyes[$k][2] + (($SubTotalPesoSeco * $Ley)/$ArrParamLeyes[$k][1]);//VALOR
			else
				$ArrTotalLeyes[$k][2] = $ArrTotalLeyes[$k][2];

			$ArrTotalLeyes[$k][3] = $ArrParamLeyes[$k][0];//COD UNIDAD
			$ArrTotalLeyes[$k][4] = $ArrParamLeyes[$k][3];//NOM UNIDAD
			$ArrTotalLeyes[$k][5] = $ArrParamLeyes[$k][1];//CONVERSION
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
			echo "<tr class='ColorTabla03' bgcolor='#CCCCCC'><td colspan='".$ColSpanSubTotal."' align='left'><strong>Total Dia&nbsp;".substr($Fila01["fecha_recepcion"],8,2)."/".substr($Fila01["fecha_recepcion"],5,2)."</strong></td>\n";
			break;
		case "P":
			switch ($OpcSF)
			{
				case "S":
					echo "<tr class='ColorTabla03' bgcolor='#CCCCCC'><td colspan='".$ColSpanSubTotal."' align='left'><strong>Total Proveedor</strong></td>\n";
					break;
				case "F":
					echo "<tr class='ColorTabla03' bgcolor='#CCCCCC'><td colspan='".$ColSpanSubTotal."' align='left'><strong>Total Flujo ".$Fila01["flujo"]."</strong></td>\n";
					break;
			}
			break;
		default:
			echo "<tr class='ColorTabla03' bgcolor='#CCCCCC'><td colspan='".$ColSpanSubTotal."' align='left'><strong>Total Consulta</strong></td>\n";
			break;
	}
	if ($Humedad==true)
		echo "<td align='center'><strong>".number_format($TotalPesoHum,$Decimales,",",".")."</strong></td>\n";
	echo "<td align='center'><strong>".number_format($TotalPesoSeco,$Decimales,",",".")."</strong></td>\n";
	if ($Humedad==true)
		echo "<td align='center'><strong>".number_format($TotalHumedad,$ArrParamLeyes["01"][2],",",".")."</strong></td>\n";
	reset($ArrTotalLeyes);
	foreach($ArrTotalLeyes as $k => $v)
	{
		if ($k!="01" && $OpcHLF!="P")
		{
			if ($k!="")
			{
				$Ley = 0;
				$Fino = $v[2];
				if ($Fino>0 && $ArrParamLeyes[$k][1]>0 && $TotalPesoSeco>0)
					$Ley = ($Fino*$ArrParamLeyes[$k][1])/$TotalPesoSeco;		
				if ($OpcHLF == "F")		
					echo "<td align='center'><strong>".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."</strong></td>\n";
				else
					echo "<td align='center'><strong>".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."</strong></td>\n";
			}
			else
			{
				echo "<td align='center'><strong>".number_format(0,$ArrParamLeyes[$k][2],",",".")."</strong></td>\n";
			}
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