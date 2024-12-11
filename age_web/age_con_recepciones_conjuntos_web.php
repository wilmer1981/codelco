<?php
	include("../principal/conectar_principal.php");	
	include("age_funciones.php");	

	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor   = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$OptLeyes       = isset($_REQUEST["OptLeyes"])?$_REQUEST["OptLeyes"]:"";
	$OptFinos       = isset($_REQUEST["OptFinos"])?$_REQUEST["OptFinos"]:"";
	$TxtFiltroPrv  = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$TxtConjIni    = isset($_REQUEST["TxtConjIni"])?$_REQUEST["TxtConjIni"]:"";
	$TxtConjFin    = isset($_REQUEST["TxtConjFin"])?$_REQUEST["TxtConjFin"]:"";
	$TxtFechaIni   = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:date('Y-m')."-01";
	$TxtFechaFin   = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:date('Y-m')."-".date('t');
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
			f.action = "age_con_recepciones_conjuntos.php";
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
  <table width="620" border="0" align="center">
    <tr>
      <td width="294">CODELCO CHILE<br>
        DIVISION VENTANAS <br> </td>
      <td width="296" align="right">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><strong><u>RECEPCION DE CONJUNTOS</u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="2"><?php echo substr($TxtFechaIni,8,2)."-".substr($TxtFechaIni,5,2)."-".substr($TxtFechaIni,0,4)." al ".substr($TxtFechaFin,8,2)."-".substr($TxtFechaFin,5,2)."-".substr($TxtFechaFin,0,4) ?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  </table>
  <br>
  <?php
$ColSpan01 = 5;
$LargoTabla=400;
if ($OptLeyes == "S")
{	
	$ColSpan01=$ColSpan01+3;
	$LargoTabla=$LargoTabla + 150;
}
if ($OptFinos == "S")
{
	$ColSpan01=$ColSpan01+3;		  
	$LargoTabla=$LargoTabla + 150;
}
//$LoteIni = substr($TxtFechaIni,2,2)."".substr($TxtFechaIni,5,2)."000";
//$LoteFin = substr($TxtFechaFin,2,2)."".substr($TxtFechaFin,5,2)."000";
echo "<table width=\"650\"  border=\"1\" align=\"center\" cellpadding=\"1\" cellspacing=\"0\">\n";
$Consulta = "SELECT distinct t1.cod_producto, t1.cod_subproducto, t3.descripcion  ";
//$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 inner join proyecto_modernizacion.subproducto t3 ";
//$Consulta.= " on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto";
//$Consulta.= " on t1.lote = t2.lote ";
$Consulta.= " from age_web.lotes t1 ";
$Consulta.= " inner join age_web.detalle_lotes t2 on t1.lote = t2.lote ";
$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto";
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
	if ($OptLeyes=="S")
	{		
		echo "<td align=\"center\" width=\"50\">Ley.Cu</td>\n";
		echo "<td align=\"center\" width=\"50\">Ley.Ag</td>\n";
		echo "<td align=\"center\" width=\"50\">Ley.Au</td>\n";
	}
	if ($OptFinos=="S")
	{
		echo "<td align=\"center\" width=\"50\">Fino.Cu</td>\n";
		echo "<td align=\"center\" width=\"50\">Fino.Ag</td>\n";
		echo "<td align=\"center\" width=\"50\">Fino.Au</td>\n";
		
	}	
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
	//WSO
	$PesoSecoProd=0;$PesoHumProd=0;$PesoSecoProd=0;
	$FinoProdCu=0;$FinoProdAg=0;$FinoProdAu=0;
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
		$PesoSecoConj=0;$PesoHumConj=0;
		$FinoConjCu=0;$FinoConjAg=0;$FinoConjAu=0;
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
			$ArrLeyesProv["01"][0]="01";$ArrLeyesProv["02"][0]="02";$ArrLeyesProv["04"][0]="04";$ArrLeyesProv["05"][0]="05";
			LeyesConjunto($Fila01["cod_producto"], $Fila01["cod_subproducto"], $FilaAux["rut_proveedor"], $FilaTipoRecep["num_conjunto"],$ArrDatosProv,$ArrLeyesProv,"S","S","S",$TxtFechaIni,$TxtFechaFin,"",$link);
			$peso_humedo=isset($ArrDatosProv["peso_humedo"])?$ArrDatosProv["peso_humedo"]:0;
			$peso_seco  =isset($ArrDatosProv["peso_seco"])?$ArrDatosProv["peso_seco"]:0;
			if ($peso_humedo!=0 || $peso_seco!=0)
			{
				echo "<tr>\n";
				echo "<td align=\"left\" colspan=\"2\">".str_pad($FilaAux["rut_proveedor"],10,'0',STR_PAD_LEFT)."<br>".substr(strtoupper($NomProveedor),0,20)."</td>\n";
				echo "<td align=\"right\">".number_format($ArrDatosProv["peso_humedo"],0,",",".")."</td>\n";
				echo "<td align=\"right\">".number_format($ArrDatosProv["peso_seco"],0,",",".")."</td>\n";		
				echo "<td align=\"right\">".number_format($ArrLeyesProv["01"][2],2,",",".")."</td>\n";							
				if ($OptLeyes=="S")
				{
					echo "<td align=\"right\">".number_format($ArrLeyesProv["02"][2],2,",",".")."</td>\n";		
					echo "<td align=\"right\">".number_format($ArrLeyesProv["04"][2],2,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($ArrLeyesProv["05"][2],2,",",".")."</td>\n";	
				}
				if ($OptFinos=="S")
				{
					echo "<td align=\"right\">".number_format($ArrLeyesProv["02"][23],0,",",".")."</td>\n";		
					echo "<td align=\"right\">".number_format($ArrLeyesProv["04"][23],0,",",".")."</td>\n";
					echo "<td align=\"right\">".number_format($ArrLeyesProv["05"][23],0,",",".")."</td>\n";		
				}
				echo "</tr>\n";
				$PesoHumConj=$PesoHumConj + $ArrDatosProv["peso_humedo"];
				$PesoSecoConj=$PesoSecoConj + $ArrDatosProv["peso_seco"];
				$FinoConjCu=$FinoConjCu + $ArrLeyesProv["02"][23];
				$FinoConjAg=$FinoConjAg + $ArrLeyesProv["04"][23];
				$FinoConjAu=$FinoConjAu + $ArrLeyesProv["05"][23];
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
		if ($OptLeyes=="S")
		{		
			if ($PesoSecoConj>0 && $FinoConjCu>0)
				$LeyConjCu=($FinoConjCu/$PesoSecoConj)*100;
			else
				$LeyConjCu=0;
			if ($PesoSecoConj>0 && $FinoConjAg>0)
				$LeyConjAg=($FinoConjAg/$PesoSecoConj)*1000;
			else
				$LeyConjAg=0;
			if ($PesoSecoConj>0 && $FinoConjAu>0)
				$LeyConjAu=($FinoConjAu/$PesoSecoConj)*1000;
			else
				$LeyConjAu=0;
			echo "<td align=\"right\">".number_format($LeyConjCu,2,",",".")."</td>\n";		
			echo "<td align=\"right\">".number_format($LeyConjAg,2,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($LeyConjAu,2,",",".")."</td>\n";	
		}
		if ($OptFinos=="S")
		{
			echo "<td align=\"right\">".number_format($FinoConjCu,0,",",".")."</td>\n";		
			echo "<td align=\"right\">".number_format($FinoConjAg,0,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($FinoConjAu,0,",",".")."</td>\n";
		}				
		$PesoHumProd=$PesoHumProd + $PesoHumConj;
		$PesoSecoProd=$PesoSecoProd + $PesoSecoConj;
		$FinoProdCu=$FinoProdCu + $FinoConjCu;
		$FinoProdAg=$FinoProdAg + $FinoConjAg;
		$FinoProdAu=$FinoProdAu + $FinoConjAu;
		/*$PesoHumConj=0;
		$PesoSecoConj=0;
		$PorcHumConj=0;
		$FinoConjCu=0;
		$FinoConjAg=0;
		$FinoConjAu=0;*/
	}
	if ($PesoSecoProd>0 && $PesoHumProd>0)
		$PorcHumProd = 100 - (($PesoSecoProd * 100)/$PesoHumProd);
	else
		$PorcHumProd = 0;
	echo "<tr class=\"Detalle02\"><td align=\"left\" colspan=\"2\">TOTAL PRODUC: ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)."</td>\n";// - ".strtoupper($Fila01["descripcion"])."</td>\n";
	echo "<td align=\"right\">".number_format($PesoHumProd,0,",",".")."</td>\n";
	echo "<td align=\"right\">".number_format($PesoSecoProd,0,",",".")."</td>\n";		
	echo "<td align=\"right\">".number_format($PorcHumProd,2,",",".")."</td>\n";
	if ($OptLeyes=="S")
	{		
		if ($PesoSecoProd>0 && $FinoProdCu>0)
			$LeyProdCu=($FinoProdCu/$PesoSecoProd)*100;
		else
			$LeyProdCu=0;
		if ($PesoSecoProd>0 && $FinoProdAg>0)
			$LeyProdAg=($FinoProdAg/$PesoSecoProd)*1000;
		else
			$LeyProdAg=0;
		if ($PesoSecoProd>0 && $FinoProdAu>0)
			$LeyProdAu=($FinoProdAu/$PesoSecoProd)*1000;
		else
			$LeyProdAu=0;
		echo "<td align=\"right\">".number_format($LeyProdCu,2,",",".")."</td>\n";		
		echo "<td align=\"right\">".number_format($LeyProdAg,2,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format($LeyProdAu,2,",",".")."</td>\n";	
	}
	if ($OptFinos=="S")
	{
		echo "<td align=\"right\">".number_format($FinoProdCu,0,",",".")."</td>\n";		
		echo "<td align=\"right\">".number_format($FinoProdAg,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format($FinoProdAu,0,",",".")."</td>\n";
	}/*		
	$PesoHumProd=0;
	$PesoSecoProd=0;
	$PorcHumProd=0;
	$FinoProdCu=0;
	$FinoProdAg=0;
	$FinoProdAu=0;*/
}
echo "</table>\n";
?>  

</form>
</body>
</html>