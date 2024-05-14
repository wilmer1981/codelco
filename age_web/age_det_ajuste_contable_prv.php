<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 82;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");	
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script> 
<script language="JavaScript">
function Proceso(Proceso)
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var Resp="";
	
	switch (Proceso)
	{
		case "I"://IMPRIMIR			
			window.print();
			break;
		case "S"://SALIR
			window.close();
			break;
	} 
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
    <table width="730" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr>
        <td align="center" class="Detalle01">
		<?php 
			$Consulta="select NOMPRV_A as nom_prv from rec_web.proved where RUTPRV_A ='".$RutPrv."'";
			$RespProv = mysqli_query($link, $Consulta);
			$FilaProv = mysqli_fetch_array($RespProv);
			echo $RutPrv." - ".$FilaProv[nom_prv];
		
		?>
		</td>
      </tr>
    </table>
	<br>
    <table width="730" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr>
        <td align="center" class="Detalle02">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:80px " onClick="Proceso('I')">
		<input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="JavaScript:Proceso('S')"></td>
      </tr>
    </table>
    <br>
      <table width="730" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr align="center" class="ColorTabla01">
		<td colspan="1">&nbsp;</td>
		<td colspan="3">Pqte. 1 ero </td>
		<td colspan="3">Leyes Canje </td>
		<td colspan="2">Pesos(Kg)</td>
		<td colspan="3">Ajuste Mes</td>
		</tr>
		<tr align="center" class="ColorTabla01">
          <td width="30">Lote</td>
		  <td width="60">Cu(%)</td>
		  <td width="60">Ag(g/t)</td>
		  <td width="60">Au(g/t)</td>
		  <td width="60">Cu(%)</td>
		  <td width="60">Ag(g/t)</td>
		  <td width="60">Au(g/t)</td>
		  <td width="60">Hum.</td>
		  <td width="60">Seco</td>
		  <td width="60">Cu(Kg)</td>
		  <td width="60">Ag(Gr)</td>
		  <td width="60">Au(Gr)</td>
        </tr>
        <?php
		$AnoMes=substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT);
		$Consulta ="select * from age_web.lotes t1 ";
		$Consulta.="where t1.rut_proveedor='".$RutPrv."' and t1.canjeable='S' and t1.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' ";
		$Consulta.="and t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."' order by t1.lote";
		$SubTotalPesoHumProv=0;$SubTotalPesoSecoProv=0;$SubTotalAjusteCuProv=0;$SubTotalAjusteAgProv=0;$SubTotalAjusteAuProv=0;
		$RespLote = mysqli_query($link, $Consulta);
		while ($FilaLote = mysqli_fetch_array($RespLote))
		{
			echo "<tr align='center'>\n";
			echo "<td>$FilaLote["lote"]</td>\n";
			$DatosLote= array();
			$ArrLeyes=array();
			$DatosLote["lote"]=$FilaLote["lote"];
			LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","N","","","");
			echo "<td>".number_format($ArrLeyes["02"][2],2,',','')."</td>\n";
			echo "<td>".number_format($ArrLeyes["04"][2],2,',','')."</td>\n";
			echo "<td>".number_format($ArrLeyes["05"][2],2,',','')."</td>\n";
			echo "<td>".number_format($ArrLeyes["02"][8],2,',','')."</td>\n";
			echo "<td>".number_format($ArrLeyes["04"][8],2,',','')."</td>\n";
			echo "<td>".number_format($ArrLeyes["05"][8],2,',','')."</td>\n";
			echo "<td>".number_format($DatosLote[peso_humedo],0,'','.')."</td>\n";
			echo "<td>".number_format($DatosLote[peso_seco],0,'','.')."</td>\n";
			$Dif_Cu=(($ArrLeyes["02"][2]-$ArrLeyes["02"][8])*$DatosLote[peso_seco])/$ArrLeyes["02"][5];
			$Dif_Ag=(($ArrLeyes["04"][2]-$ArrLeyes["04"][8])*$DatosLote[peso_seco])/$ArrLeyes["04"][5];
			$Dif_Au=(($ArrLeyes["05"][2]-$ArrLeyes["05"][8])*$DatosLote[peso_seco])/$ArrLeyes["05"][5];
			echo "<td>".number_format($Dif_Cu,0,',','.')."</td>\n";
			echo "<td>".number_format($Dif_Ag,0,',','.')."</td>\n";
			echo "<td>".number_format($Dif_Au,0,',','.')."</td>\n";
			$SubTotalAjusteCuProv=$SubTotalAjusteCuProv+$Dif_Cu;
			$SubTotalAjusteAgProv=$SubTotalAjusteAgProv+$Dif_Ag;
			$SubTotalAjusteAuProv=$SubTotalAjusteAuProv+$Dif_Au;
			echo "</tr>\n";
		}
		$SubTotalPesoHumProd=$SubTotalPesoHumProd+$SubTotalPesoHumProv;
		$SubTotalPesoSecoProd=$SubTotalPesoSecoProd+$SubTotalPesoSecoProv;
		$SubTotalAjusteCuProd=$SubTotalAjusteCuProd+$SubTotalAjusteCuProv;
		$SubTotalAjusteAgProd=$SubTotalAjusteAgProd+$SubTotalAjusteAgProv;
		$SubTotalAjusteAuProd=$SubTotalAjusteAuProd+$SubTotalAjusteAuProv;
		echo "<tr class='Detalle02'>\n";
		echo "<td colspan='7'>&nbsp;</td>\n";	
		echo "<td align='center'>".number_format($SubTotalPesoHumProv,0,'','.')."</td>\n";
		echo "<td align='center'>".number_format($SubTotalPesoSecoProv,0,'','.')."</td>\n";
		echo "<td align='center'>".number_format($SubTotalAjusteCuProv,0,'','.')."</td>\n";
		echo "<td align='center'>".number_format($SubTotalAjusteAgProv,0,'','.')."</td>\n";
		echo "<td align='center'>".number_format($SubTotalAjusteAuProv,0,'','.')."</td>\n";
		echo "</tr>\n";
		?>
      </table>
</form>
</body>
</html>