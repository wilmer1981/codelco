<?php

if(isset($_REQUEST["filename"])){
	$filename = $_REQUEST["filename"];
}else{
	$filename = "";
}

if(isset($_REQUEST["TxtFechaIni"])){
	$TxtFechaIni = $_REQUEST["TxtFechaIni"];
}else{
	$TxtFechaIni = "";
}

if(isset($_REQUEST["TxtFechaFin"])){
	$TxtFechaFin = $_REQUEST["TxtFechaFin"];
}else{
	$TxtFechaFin = "";
}

	if(isset($_REQUEST["CmbSubProducto"])){
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else{
		$CmbSubProducto = "";
	}
	if(isset($_REQUEST["CmbProveedor"])){
		$CmbProveedor = $_REQUEST["CmbProveedor"];
	}else{
		$CmbProveedor = "";
	}
	if(isset($_REQUEST["TxtConjIni"])){
		$TxtConjIni = $_REQUEST["TxtConjIni"];
	}else{
		$TxtConjIni = "";
	}

	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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
	include("../age_web/age_funciones.php");
?>
<html>

<head>
    <title>Sistema de Agencia</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
    <form name="frmPrincipal" action="" method="post">
        <table width="620" border="0" align="center">
            <tr align="center">
                <td width="590" height="30" colspan="2"><strong><u>RECEPCION DE CONJUNTOS</u></strong></td>
            </tr>
            <tr align="center">
                <td colspan="2">
                    <?php echo substr($TxtFechaIni,8,2)."-".substr($TxtFechaIni,5,2)."-".substr($TxtFechaIni,0,4)." al ".substr($TxtFechaFin,8,2)."-".substr($TxtFechaFin,5,2)."-".substr($TxtFechaFin,0,4) ?>
                </td>
            </tr>
        </table>
        <br>
        <?php
$ColSpan01 = 5;
$LargoTabla=400;
//$LoteIni = substr($TxtFechaIni,2,2)."".substr($TxtFechaIni,5,2)."000";
//$LoteFin = substr($TxtFechaFin,2,2)."".substr($TxtFechaFin,5,2)."000";
echo "<table width=\"650\"  border=\"1\" align=\"center\" cellpadding=\"1\" cellspacing=\"0\">\n";
$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t3.descripcion  ";
$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 ";
$Consulta.= " on t1.lote = t2.lote ";
$Consulta.= " inner join proyecto_modernizacion.subproducto t3 ";

$Consulta.= " on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto";
$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
if ($CmbSubProducto != "S")
{
	$Consulta.= " and t1.cod_producto = '1' ";
	$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
}
if ($CmbProveedor != "S")
	$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
if ($TxtConjIni != "")	
	$Consulta.= " and t1.num_conjunto between '".$TxtConjIni."' and '".$TxtConjFin."'";
$Consulta.= " order by t1.cod_producto, lpad(t1.cod_subproducto,4,'0') ";
//echo $Consulta."<br>";
$Resp01 = mysqli_query($link, $Consulta);
while ($Fila01 = mysqli_fetch_array($Resp01))	
{			
	//TITULO SUBPRODUCTO
	echo "<tr class=\"ColorTabla01\">\n";	
	if ($Fila01["descripcion"] == "" || is_null($Fila01["descripcion"]))
		echo "<td align=\"left\" colspan=\"".$ColSpan01."\">&nbsp;</td>\n";				
	else
		echo "<td align=\"left\" colspan=\"".$ColSpan01."\">".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".strtoupper($Fila01["descripcion"])."</td>\n";
	echo "</tr>\n";
	echo "<tr class=\"ColorTabla02\">\n";		
	echo "<td align=\"center\" width=\"50\">Conjunto</td>\n";		
	echo "<td align=\"center\" width=\"200\">Proveedor</td>\n";			
	echo "<td align=\"center\" width=\"50\">P.Hum.</td>\n";
	echo "<td align=\"center\" width=\"50\">P.Seco</td>\n";
	echo "<td align=\"center\" width=\"50\">Hum</td>\n";
	echo "</tr>\n";
	//CONSULTA LOS CONJUNTOS
	$Consulta = "select distinct t1.num_conjunto  ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote left join rec_web.tipos t3 on t1.cod_recepcion=t3.cod_c ";
	$Consulta.= " where t1.lote<>''";
	$Consulta.= " and t1.num_conjunto<>'' and t1.num_conjunto<>'0' ";
	$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";	
	$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
	$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
	if ($CmbProveedor != "S")
		$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
	if ($TxtConjIni != "")	
		$Consulta.= " and t1.num_conjunto between '".$TxtConjIni."' and '".$TxtConjFin."'";
	$Consulta.= " order by t1.num_conjunto";
	//echo $Consulta."<br>";
	$RespTipoRecep = mysqli_query($link, $Consulta);
	while ($FilaTipoRecep = mysqli_fetch_array($RespTipoRecep))
	{					
		//TITULO NUMERO CONJUNTO
		echo "<tr bgcolor='#CCCCCC'>\n";	
		if ($FilaTipoRecep["num_conjunto"] == "" || is_null($FilaTipoRecep["num_conjunto"]))
			echo "<td align='left' colspan='".$ColSpan01."'>&nbsp;</td>\n";				
		else
			echo "<td align='left' colspan='2'><strong>".strtoupper($FilaTipoRecep["num_conjunto"])."</strong></td>\n";
		echo "<td align='center' colspan='".($ColSpan01-2)."'>&nbsp;</td>\n";		
		echo "</tr>\n";
		//CONSULTA LOS PROVEEDOR DE UN CONJUNTO
		$Consulta = "select distinct t1.rut_proveedor  ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 ";
		$Consulta.= " on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
		$Consulta.= " where t1.lote<>'' ";
		$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		if ($CmbSubProducto != "S")
		{
			$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
			$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
		}
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		$Consulta.= " and t1.num_conjunto = '".$FilaTipoRecep["num_conjunto"]."' ";	
		$Consulta.= " order by t1.rut_proveedor ";
		//echo $Consulta."<br>";
		$CodRecepAnt = "";
		$RespAux = mysqli_query($link, $Consulta);
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{															
			$NomProveedor = "";
			$Consulta = "select * ";
			$Consulta.= " from rec_web.proved ";
			$Consulta.= " where rutprv_a='".$FilaAux["rut_proveedor"]."'";
			$RespProv = mysqli_query($link, $Consulta);	
			//echo $Consulta."<br>";
			while ($FilaProv = mysqli_fetch_array($RespProv))
				$NomProveedor = $FilaProv["NOMPRV_A"];
			$ArrDatosProv=array();
			$ArrLeyesProv=array();
			$ArrLeyesProv["01"][0]="01";/*$ArrLeyesProv["02"][0]="02";$ArrLeyesProv["04"][0]="04";$ArrLeyesProv["05"][0]="05";*/
			LeyesConjunto($Fila01["cod_producto"], $Fila01["cod_subproducto"], $FilaAux["rut_proveedor"], $FilaTipoRecep["num_conjunto"],$ArrDatosProv,$ArrLeyesProv,"S","S","S",$TxtFechaIni,$TxtFechaFin,"");
			if ($ArrDatosProv["peso_humedo"]!=0 || $ArrDatosProv["peso_seco"]!=0)
			{
				echo "<tr>\n";
				echo "<td align=\"left\" colspan=\"2\">".str_pad($FilaAux["rut_proveedor"],10,'0',STR_PAD_LEFT)."&nbsp;&nbsp;".substr(strtoupper($NomProveedor),0,20)."</td>\n";
				echo "<td align=\"right\">".number_format($ArrDatosProv["peso_humedo"],0,",",".")."</td>\n";
				echo "<td align=\"right\">".number_format($ArrDatosProv["peso_seco"],0,",",".")."</td>\n";		
				echo "<td align=\"right\">".number_format($ArrLeyesProv["01"][2],2,",",".")."</td>\n";							
				echo "</tr>\n";
				$PesoHumConj=$PesoHumConj + $ArrDatosProv["peso_humedo"];
				$PesoSecoConj=$PesoSecoConj + $ArrDatosProv["peso_seco"];
			}
		}
		if ($PesoSecoConj>0 && $PesoHumConj>0)
			$PorcHumConj = 100 - (($PesoSecoConj * 100)/$PesoHumConj);
		else
			$PorcHumConj = 0;
		echo "<tr bgcolor=\"#FFFFFF\"><td align=\"left\" colspan=\"2\">TOTAL CONJTO: ".$FilaTipoRecep["num_conjunto"]."</td>\n";
		echo "<td align=\"right\">".number_format($PesoHumConj,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format($PesoSecoConj,0,",",".")."</td>\n";		
		echo "<td align=\"right\">".number_format($PorcHumConj,2,",",".")."</td>\n";
		$PesoHumProd=$PesoHumProd + $PesoHumConj;
		$PesoSecoProd=$PesoSecoProd + $PesoSecoConj;
		$PesoHumConj=0;
		$PesoSecoConj=0;
		$PorcHumConj=0;
	}
	if ($PesoSecoProd>0 && $PesoHumProd>0)
		$PorcHumProd = 100 - (($PesoSecoProd * 100)/$PesoHumProd);
	else
		$PorcHumProd = 0;
	echo "<tr class=\"Detalle02\"><td align=\"left\" colspan=\"2\">TOTAL PRODUC: ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)."</td>\n";// - ".strtoupper($Fila01["descripcion"])."</td>\n";
	echo "<td align=\"right\">".number_format($PesoHumProd,0,",",".")."</td>\n";
	echo "<td align=\"right\">".number_format($PesoSecoProd,0,",",".")."</td>\n";		
	echo "<td align=\"right\">".number_format($PorcHumProd,2,",",".")."</td>\n";
	$PesoHumProd=0;
	$PesoSecoProd=0;
	$PorcHumProd=0;
}
echo "</table>\n";
?>

    </form>
</body>

</html>