<?php
	include("../principal/conectar_principal.php");	
	include("age_funciones.php");	

	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor   = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$Busq           = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
	$OptLeyes       = isset($_REQUEST["OptLeyes"])?$_REQUEST["OptLeyes"]:"";
	$OptFinos       = isset($_REQUEST["OptFinos"])?$_REQUEST["OptFinos"]:"";
	$TxtFiltroPrv   = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$TxtConjIni     = isset($_REQUEST["TxtConjIni"])?$_REQUEST["TxtConjIni"]:"";
	$TxtConjFin     = isset($_REQUEST["TxtConjFin"])?$_REQUEST["TxtConjFin"]:"";
	$TxtFechaIni    = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:date('Y-m')."-01";
	$TxtFechaFin    = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:date('Y-m')."-".date('t');
	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
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
			f.action = "age_con_recepciones_productos.php";
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
      <td height="30" colspan="2"><strong><u>RECEPCION DE PRODUCTOS</u></strong></td>
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
echo "<table width=\"650\"  border=\"1\" align=\"center\" cellpadding=\"1\" cellspacing=\"0\">\n";
$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t3.descripcion, t3.recepcion ";
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
$Consulta.= " order by t1.cod_producto, lpad(t1.cod_subproducto,4,'0') ";
$Resp01 = mysqli_query($link, $Consulta);
//WSO
$PesoSecoTotal=0;$PesoHumTotal=0;$PorcHumTotal=0;
$FinoTotalCu=0;$FinoTotalAg=0;$FinoTotalAu=0;
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
	echo "<td align=\"center\" width=\"250\">Proveedor</td>\n";			
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
	//CONSULTA LOS PROVEEDORES
	$Consulta = "select distinct t1.rut_proveedor  ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote = t2.lote  ";
	$Consulta.= " where t1.lote<>''";
	$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";	
	$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
	$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
	if ($CmbProveedor != "S")
		$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
	$Consulta.= " order by t1.rut_proveedor";
	$RespTipoRecep = mysqli_query($link, $Consulta);
	//echo $Consulta."<br><br>";
	$PesoHumProd=0;$PesoSecoProd=0;
	$FinoProdCu=0;$FinoProdAg=0;$FinoProdAu=0;
	while ($FilaTipoRecep = mysqli_fetch_array($RespTipoRecep))
	{				
		$TipoRecep="";			
		$NomProveedor = "";
		$Consulta = "select * ";
		$Consulta.= " from rec_web.proved ";
		$Consulta.= " where rutprv_a='".$FilaTipoRecep["rut_proveedor"]."'";
		$RespProv = mysqli_query($link, $Consulta);	
		//echo $Consulta."<br>";
		while ($FilaProv = mysqli_fetch_array($RespProv))
			$NomProveedor = $FilaProv["NOMPRV_A"];
		$ArrDatosProv=array();
		$ArrLeyesProv=array();
		$ArrLeyesProv["01"][0]="01";$ArrLeyesProv["02"][0]="02";$ArrLeyesProv["04"][0]="04";$ArrLeyesProv["05"][0]="05";
		$ArrDatosProv = LeyesProveedor($TipoRecep,$FilaTipoRecep["rut_proveedor"],$Fila01["cod_producto"],$Fila01["cod_subproducto"],$ArrDatosProv,$ArrLeyesProv,"S","S","S",$TxtFechaIni,$TxtFechaFin,"","",$link);
		$ArrLeyesProv = LeyesProveedor($TipoRecep,$FilaTipoRecep["rut_proveedor"],$Fila01["cod_producto"],$Fila01["cod_subproducto"],$ArrDatosProv,$ArrLeyesProv,"S","S","S",$TxtFechaIni,$TxtFechaFin,"","L",$link);
		
		//if ($ArrDatosProv["peso_humedo"]!=0 || $ArrDatosProv["peso_seco"]!=0)
		//{
			$peso_humedo = isset($ArrDatosProv["peso_humedo"])?$ArrDatosProv["peso_humedo"]:0;
			$peso_seco   = isset($ArrDatosProv["peso_seco"])?$ArrDatosProv["peso_seco"]:0;
			$ArrLeyesProv012 = isset($ArrLeyesProv["01"][2])?$ArrLeyesProv["01"][2]:0;
			$ArrLeyesProv022 = isset($ArrLeyesProv["02"][2])?$ArrLeyesProv["02"][2]:0;
			$ArrLeyesProv042 = isset($ArrLeyesProv["04"][2])?$ArrLeyesProv["04"][2]:0;
			$ArrLeyesProv052 = isset($ArrLeyesProv["05"][2])?$ArrLeyesProv["05"][2]:0;
			$ArrLeyesProv0223 = isset($ArrLeyesProv["02"][23])?$ArrLeyesProv["02"][23]:0;
			$ArrLeyesProv0423 = isset($ArrLeyesProv["04"][23])?$ArrLeyesProv["04"][23]:0;
			$ArrLeyesProv0523 = isset($ArrLeyesProv["05"][23])?$ArrLeyesProv["05"][23]:0;
			echo "<tr>\n";
			echo "<td align=\"left\" >".str_pad($FilaTipoRecep["rut_proveedor"],10,'0',STR_PAD_LEFT)."<br>".substr(strtoupper($NomProveedor),0,20)."</td>\n";
			echo "<td align=\"right\">".number_format($peso_humedo,0,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($peso_seco,0,",",".")."</td>\n";		
			echo "<td align=\"right\">".number_format($ArrLeyesProv012,2,",",".")."</td>\n";							
			if ($OptLeyes=="S")
			{
				echo "<td align=\"right\">".number_format($ArrLeyesProv022,2,",",".")."</td>\n";		
				echo "<td align=\"right\">".number_format($ArrLeyesProv042,2,",",".")."</td>\n";
				echo "<td align=\"right\">".number_format($ArrLeyesProv052,2,",",".")."</td>\n";	
			}
			if ($OptFinos=="S")
			{
				echo "<td align=\"right\">".number_format($ArrLeyesProv0223,0,",",".")."</td>\n";		
				echo "<td align=\"right\">".number_format($ArrLeyesProv0423,0,",",".")."</td>\n";
				echo "<td align=\"right\">".number_format($ArrLeyesProv0523,0,",",".")."</td>\n";		
			}
			echo "</tr>\n";
			$PesoHumProd=$PesoHumProd + $peso_humedo;
			$PesoSecoProd=$PesoSecoProd + $peso_seco;
			$FinoProdCu=$FinoProdCu + $ArrLeyesProv0223;
			$FinoProdAg=$FinoProdAg + $ArrLeyesProv0423;
			$FinoProdAu=$FinoProdAu + $ArrLeyesProv0523;
		//}
	}
	if ($PesoSecoProd>0 && $PesoHumProd>0)
		$PorcHumProd = 100 - (($PesoSecoProd * 100)/$PesoHumProd);
	else
		$PorcHumProd = 0;
	echo "<tr class=\"Detalle02\"><td align=\"left\" >TOTAL PRODUC: ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)."</td>\n";// - ".strtoupper($Fila01["descripcion"])."</td>\n";
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
	}		
	$PesoHumTotal=$PesoHumTotal + $PesoHumProd;
	$PesoSecoTotal=$PesoSecoTotal + $PesoSecoProd;
	$FinoTotalCu=$FinoTotalCu + $FinoProdCu;
	$FinoTotalAg=$FinoTotalAg + $FinoProdAg;
	$FinoTotalAu=$FinoTotalAu + $FinoProdAu;
	$PesoHumProd=0;
	$PesoSecoProd=0;
	$PorcHumProd=0;
	$FinoProdCu=0;
	$FinoProdAg=0;
	$FinoProdAu=0;
}
if ($PesoSecoTotal>0 && $PesoHumTotal>0)
	$PorcHumTotal = 100 - (($PesoSecoTotal * 100)/$PesoHumTotal);
else
	$PorcHumTotal = 0;
echo "<tr class=\"Detalle02\"><td align=\"left\" >TOTAL CONSULTA</td>\n";
echo "<td align=\"right\">".number_format($PesoHumTotal,0,",",".")."</td>\n";
echo "<td align=\"right\">".number_format($PesoSecoTotal,0,",",".")."</td>\n";		
echo "<td align=\"right\">".number_format($PorcHumTotal,2,",",".")."</td>\n";
if ($OptLeyes=="S")
{		
	if ($PesoSecoTotal>0 && $FinoTotalCu>0)
		$LeyTotalCu=($FinoTotalCu/$PesoSecoTotal)*100;
	else
		$LeyTotalCu=0;
	if ($PesoSecoTotal>0 && $FinoTotalAg>0)
		$LeyTotalAg=($FinoTotalAg/$PesoSecoTotal)*1000;
	else
		$LeyTotalAg=0;
	if ($PesoSecoTotal>0 && $FinoTotalAu>0)
		$LeyTotalAu=($FinoTotalAu/$PesoSecoTotal)*1000;
	else
		$LeyTotalAu=0;
	echo "<td align=\"right\">".number_format($LeyTotalCu,2,",",".")."</td>\n";		
	echo "<td align=\"right\">".number_format($LeyTotalAg,2,",",".")."</td>\n";
	echo "<td align=\"right\">".number_format($LeyTotalAu,2,",",".")."</td>\n";	
}
if ($OptFinos=="S")
{
	echo "<td align=\"right\">".number_format($FinoTotalCu,0,",",".")."</td>\n";		
	echo "<td align=\"right\">".number_format($FinoTotalAg,0,",",".")."</td>\n";
	echo "<td align=\"right\">".number_format($FinoTotalAu,0,",",".")."</td>\n";
}		
echo "</table>\n";
?>  

</form>
</body>
</html>