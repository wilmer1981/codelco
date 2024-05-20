<?php
	include("../principal/conectar_principal.php");
	$Datos=explode('//',$Valores);
	$Lote=$Datos[0];
	$Consulta ="select sum(t5.peso_neto) as tot_peso_neto,t1.lote,t1.fecha_recepcion,t1.rut_proveedor,t1.cod_subproducto,t3.nomprv_a as nombre,t2.abreviatura as subproducto,t1.cod_faena,t4.NOMMIN_A ";
	$Consulta.="from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto=1 and t1.cod_subproducto=t2.cod_subproducto ";
	$Consulta.="inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a inner join rec_web.minaprv t4 on t1.rut_proveedor=t4.RUTPRV_A and t1.cod_faena=t4.CODMIN_A ";
	$Consulta.="inner join age_web.detalle_lotes t5 on t1.lote=t5.lote ";
	$Consulta.= " where t1.lote='$Lote'";
	$Consulta.= " group by t1.lote order by t1.lote";
	$Resp = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Resp);
	$RutPrv=$Fila["rut_proveedor"];
	$NomPrv=$Fila["nombre"];
	$NomSubProducto=$Fila["subproducto"];
	$FechaRecepcion=$Fila["fecha_recepcion"];
	$RutMina=$Fila[cod_faena];
	$NomMina=$Fila[NOMMIN_A];
	$TotalPesoNeto=$Fila[tot_peso_neto];
	
		
?>
<html>
<head>
<title>Detalle Lote</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Proceso(Tipo)
{	
	var Frm=document.FrmDetaBoletaPesaje;
	
	switch(Tipo)
	{
		case "1":
			window.close();
			break;
		case "2":
			Frm.BtnSalir.style.visibility='hidden';
			Frm.BtnImprimir.style.visibility='hidden';
			window.print();
			Frm.BtnSalir.style.visibility='';
			Frm.BtnImprimir.style.visibility='';
			break;	
	}
	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmDetaBoletaPesaje"> 
  <table width="650" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center"> 
      <td width="138">&nbsp;</td>
      <td width="354"><strong>DETALLE DE LOTE </strong></td>
      <td width="212" colspan="2">
	  <input name="BtnSalir" type="button" value="Salir" style="width=80" onClick="Proceso('1')">&nbsp;
	  <input name="BtnImprimir" type="button" value="Imprimir" style="width=80" onClick="Proceso('2')">
	  </td>
    </tr>
  </table>
  <br>
  
  <table width="650" border="1"  align="center" cellspacing="0" cellpadding="3" class="tablainterior">
    <tr> 
      <td width="65" class="Detalle02"><strong>Lote</strong></td>
      <td width="169" class="Detalle01"><?php echo $Lote;?></td>
      <td width="62" class="Detalle02"><strong>Proveedor</strong></td>
      <td width="319"class="Detalle01"><?php echo $RutPrv." - ".$NomPrv;?></td>
    </tr>
    <tr> 
      <td class="Detalle02"><strong>SubProd.</strong></td>
      <td class="Detalle01"><?php echo $NomSubProducto;?></td>
      <td class="Detalle02"><strong>Mina</strong></td>
      <td class="Detalle01"><?php echo $RutMina." - ".$NomMina;?></td>
    </tr>
    <tr> 
      <td class="Detalle02"><strong>Fec.Recep</strong></td>
      <td class="Detalle01"><?php echo $FechaRecepcion;?></td>
      <td class="Detalle02"><strong>Tot P.Neto</strong></td>
      <td class="Detalle01"><?php echo number_format($TotalPesoNeto,0,',','.');?>&nbsp;Kgrs.</td>
    </tr>
  </table>

  <br>  
  <table width="650" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01">
      <td align="center">Fecha Recep</td>
	  <td align="center">Guia</td>
	  <td align="center">Correl.</td>
	  <td align="center">Rec</td>
	  <td align="center">UR</td>
	  <td align="center">P.Bruto</td>
	  <td align="center">P.Tara</td>
	  <td align="center">P.Neto</td>
	  <td align="center">Pat.Camion</td>
    </tr>
	<?php
	$TotPBruto=0;
	$TotPTara=0;
	$TotPNeto=0;
	$CantRec=0;
	$Consulta ="select *,lpad(recargo,2,'0') as recarg from age_web.detalle_lotes ";
	$Consulta.="where lote='$Lote' order by recarg";
	$Resp = mysqli_query($link, $Consulta);
	while($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
		echo "<td align='center'>".$Fila["fecha_recepcion"]."</td>\n";
		echo "<td align='center'>".$Fila["guia_despacho"]."</td>\n";
		echo "<td align='center'>".$Fila["corr"]."</td>\n";
		echo "<td align='center'>".$Fila["recargo"]."</td>\n";
		echo "<td align='center'>".$Fila["fin_lote"]."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_bruto"],0,',','.')."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_tara"],0,',','.')."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_neto"],0,',','.')."</td>\n";
		echo "<td align='center'>".$Fila["patente"]."</td>\n";
		echo "</tr>\n";
		$TotPBruto=$TotPBruto+$Fila["peso_bruto"];
		$TotPTara=$TotPTara+$Fila["peso_tara"];
		$TotPNeto=$TotPNeto+$Fila["peso_neto"];
		$CantRec++;
	}
	echo "<tr class='Detalle02'>";
	echo "<td colspan='3'>TOTALES</td>";
	echo "<td align='center'>".number_format($CantRec,0,',','.')."</td>\n"; 
	echo "<td>&nbsp;</td>";
	echo "<td align='right'>".number_format($TotPBruto,0,',','.')."</td>\n";
	echo "<td align='right'>".number_format($TotPTara,0,',','.')."</td>\n";
	echo "<td align='right'>".number_format($TotPNeto,0,',','.')."</td>\n";
	echo "<td>&nbsp;</td>";
	echo "</tr>";
	?>
  </table>
</form>
</body>
</html>
