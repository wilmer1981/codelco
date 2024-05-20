<?php
	include("../principal/conectar_principal.php");
	include("../age_web/age_funciones.php");	
	
	$CmbRecepcion   = isset($_REQUEST["CmbRecepcion"])?$_REQUEST["CmbRecepcion"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor   = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$TxtFiltroPrv   = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$TxtFechaIni    = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:date('Y-m')."-01";
	$TxtFechaFin    = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:date('Y-m-d');
	$OptVer         = isset($_REQUEST["OptVer"])?$_REQUEST["OptVer"]:"P";
	$Busq           = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
?>
<html>
<head>
<title>AGE-Resumen Pesos Netos Por Camion</title>
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
			f.action = "age_con_resumen_patentes.php";
			f.submit();
			break;
	}
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="620" border="0" align="center">
    <tr>
      <td width="294">CODELCO CHILE<br>
        DIVISION VENTANAS       <br> </td>
      <td width="296" align="right">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><strong><u>RESUMEN DE PESO NETO POR CAMION</u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="2">PERIODO: <?php echo substr($TxtFechaIni,8,2)."-".substr($TxtFechaIni,5,2)."-".substr($TxtFechaIni,0,4)." al ".substr($TxtFechaFin,8,2)."-".substr($TxtFechaFin,5,2)."-".substr($TxtFechaFin,0,4); ?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  </table>
  <br>
	<?php
	$ColSpan=3;	
	echo "<table width=\"400\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
	$Consulta = "select distinct t1.rut_proveedor,t1.cod_subproducto ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote inner join sipa_web.proveedores t3 on t1.rut_proveedor=t3.rut_prv ";
	$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
	if ($CmbSubProducto != "S")
	{
		$Consulta.= " and t1.cod_producto = '1' ";
		$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
	}
	if ($CmbProveedor != "S")
		$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
	$Consulta.= " order by t1.rut_proveedor ";
	//echo $Consulta."<br>";
	$RespPrv = mysqli_query($link, $Consulta);
	while ($FilaPrv = mysqli_fetch_array($RespPrv))	
	{			
		$TotPrv=0;
		echo "<tr class=\"ColorTabla01\">\n";			
		$Consulta = "select * from sipa_web.proveedores ";
		$Consulta.= "where rut_prv = '".$FilaPrv["rut_proveedor"]."'";		
		$RespAux2 = mysqli_query($link, $Consulta);
		if ($FilaAux2 = mysqli_fetch_array($RespAux2))
		{
			$NomPrv = $FilaAux2["nombre_prv"];
		}
		else
			$NomPrv = "SIN IDENTIFICACION";		
		echo "<td align=\"left\" colspan=\"".$ColSpan."\">".str_pad($FilaPrv["rut_proveedor"],2,'0',STR_PAD_LEFT)." - ".$NomPrv."</td>";					
		echo "</tr>\n";
		//TITULO
		$Consulta="select distinct t1.cod_subproducto,abreviatura as NomProd,t1.cod_producto,t2.cod_subproducto from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
		$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
		//if ($CmbProveedor != "S")
			$Consulta.= "and t1.rut_proveedor = '".$FilaPrv["rut_proveedor"]."' ";
		if ($CmbSubProducto != "S")
		{
			$Consulta.= " and t1.cod_producto = '1' ";
			$Consulta.= " and t1.cod_subproducto = '".$FilaPrv["cod_subproducto"]."' ";
		}
		$RespProd=mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		while($FilaProd=mysqli_fetch_array($RespProd))
		{
			$TotProd=0;
			echo "<tr class=\"Detalle02\">";
			echo "<td colspan='3'>".$FilaProd["NomProd"]."</td>";
			echo "</tr>";
			echo "<tr class=\"ColorTabla02\">\n";		
			echo "<td align=\"center\" width=\"150\">Patente</td>\n";
			echo "<td align=\"center\" width=\"150\">Guia</td>\n";	
			echo "<td align=\"center\" width=\"100\">Peso Neto</td>\n";
			echo "</tr>\n";
			$Consulta="select * from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote=t2.lote ";
			$Consulta.="where t1.rut_proveedor='".$FilaPrv["rut_proveedor"]."' and t1.cod_producto='".$FilaProd["cod_producto"]."' and cod_subproducto='".$FilaProd["cod_subproducto"]."' ";
			$Consulta.="and t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
			//echo $Consulta."<br>";
			$RespDeta=mysqli_query($link, $Consulta);
			while($FilaDeta=mysqli_fetch_array($RespDeta))
			{
				echo "<tr>";
				echo "<td align=\"center\">".$FilaDeta["patente"]."</td>";
				echo "<td align=\"center\">".$FilaDeta["guia_despacho"]."</td>";
				echo "<td align=\"right\">".number_format($FilaDeta["peso_neto"],0,'','.')."</td>";
				echo "</tr>";
				$TotProd=$TotProd+$FilaDeta["peso_neto"];
			}
			//TOTAL PRODUCTO
			echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td colspan='2' align=\"left\">TOTAL: ".strtoupper($FilaProd["NomProd"])."</td>\n";
			echo "<td align=\"right\">".number_format($TotProd,0,',','.')."</td>\n";
			echo "</tr>\n";	
			$TotPrv=$TotPrv+$TotProd;
		}
		//TOTAL PROVEEDOR
		echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td colspan='2' align=\"left\">TOTAL: ".str_pad($FilaPrv["rut_proveedor"],2,'0',STR_PAD_LEFT)." ".strtoupper($NomPrv)."</td>\n";
		echo "<td align=\"right\">".number_format($TotPrv,0,',','.')."</td>\n";
		echo "</tr>\n";	
	}//FIN PRV
	echo "</table>\n";
	?>  
</form>
</body>
</html>