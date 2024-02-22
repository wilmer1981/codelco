<?php	
	include("../principal/conectar_principal.php");
	if (isset($TxtLote))
	{
		$EstadoInput = "";
		$Consulta = "select * ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 ";
		$Consulta.= " on t1.lote = t2.lote";
		$Consulta.= " where t1.lote = '".$TxtLote."'";
		$Resp = mysqli_query($link, $Consulta);
		$CantRecargos=0;
		while ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$TxtLote = $Fila["lote"];
			$CmbSubProducto = $Fila["cod_subproducto"];
			$CmbProveedor = $Fila["rut_proveedor"];
			$CmbCodFaena = $Fila["cod_faena"];
			$CmbCodRecepcion = $Fila["cod_recepcion"];
			$CmbClaseProducto = $Fila["clase_producto"];
			$TxtConjunto = $Fila["num_conjunto"];
			$ChkRemuestreo = $Fila["remuestreo"];
			$TxtLoteRemuestreo = $Fila["num_lote_remuestreo"];
			$CmbEstadoLote = $Fila["estado_lote"];
			$CmbEstadoRecargo = $Fila["estado_recargo"];
			//DATOS DEL DETALLE			
			
			if ($Fila["recargo"]==1)
				$TxtFechaRecep = $Fila["fecha_recepcion"];			
			$TotalPesoBruto = $TotalPesoBruto + $Fila["peso_bruto"];
			$TotalPesoTara = $TotalPesoTara + $Fila["peso_tara"];
			$TotalPesoNeto = $TotalPesoNeto + $Fila["peso_neto"];
			$CantRecargos++;
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
	var f = document.frmPopUp;
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
			window.close();
			break;
	}
}
</script>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(../principal/imagenes/fondo3.gif);
}
a:link {
	color: #FFFFFF;
}
a:visited {
	color: #FFFFFF;
}
a:hover {
	color: #FFFFFF;
}
a:active {
	color: #FFFF00;
}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<form name="frmPopUp" action="" method="post">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="NewRec" value="<?php echo $NewRec; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<table width="650"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02">
    <td colspan="4"><strong>DATOS DEL LOTE </strong></td>
  </tr>
<?php
	if ($EstOpe != "")
	{  
		switch ($EstOpe)
		{
			case "S":
				$Clase="ErrorSI";
				break;
			case "N":
				$Clase="ErrorNO";
				break;
		}
		echo "<tr class='ColorTabla02'>\n";
    	echo "<td colspan='4' class='Colum01' align='center'><font class='".$Clase."'>".$Mensaje."</font></td>\n";
    	echo "</tr>\n";
	}
?>
  <tr class="Colum01">
    <td width="89" class="Colum01">Lote:</td>
    <td width="337" class="Colum01"><?php echo $TxtLote; ?>
      </td>
    <td width="104" align="right" class="Colum01">Num.Conjunto:</td>
    <td width="143" class="Colum01"><?php echo $TxtConjunto; ?>&nbsp;</td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">SubProducto:</td>
    <td class="Colum01">
<?php
	$Consulta = "select cod_subproducto, descripcion, abreviatura, LPAD(cod_subproducto,2,'0') as orden ";
	$Consulta.= " from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' order by orden";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{		
		echo  $Fila["orden"]." - ".$Fila["abreviatura"]."\n";
	}
?>	
	</td>
    <td align="right" class="Colum01">Clase Producto:</td>
    <td class="Colum01">
      <?php
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='15001' and nombre_subclase='".$CmbClaseProducto."' order by nombre_subclase";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		echo $Fila["valor_subclase1"]."\n";
	}
?>
    </td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Proveedor: </td>
    <td class="Colum01">
<?php
	$Datos = explode("-",$CmbProveedor);
	$RutAux = ($Datos[0]*1)."-".$Datos[1];
	$Consulta = "select * ";
	$Consulta.= " from rec_web.proved ";
	$Consulta.= " where RUTPRV_A='".$RutAux."'";
	$Consulta.= " order by TRIM(nomprv_a) ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Datos = explode("-",$Fila["RUTPRV_A"]);
		$RutAux = ($Datos[0]*1)."-".$Datos[1];
		echo  $Fila["RUTPRV_A"]." - ".$Fila["NOMPRV_A"]."\n";
	}
?>	
    </td>
    <td align="right" class="Colum01">Cod.Recepcion:</td>
    <td class="Colum01">
      <?php
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='15002' and nombre_subclase='".$CmbCodRecepcion."' order by nombre_subclase";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
			echo $Fila["valor_subclase1"]."\n";
	}
?>
    </td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Cod Faena: </td>
    <td class="Colum01">
<?php
	$Consulta = "select * from age_web.mina where cod_faena='".$CmbCodFaena."' order by descripcion ";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		echo $Fila["cod_faena"]." - ".$Fila["descripcion"]."\n";
	}
?>	
    </td>
    <td align="right" class="Colum01">Remuestreo:</td>
    <td class="Colum01"><?php
	switch ($ChkRemuestreo)
	{
		case "S":
			echo "SI";
			break;
		default:
			echo "NO";
			break;
	}
?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Estado Lote:</td>
    <td class="Colum01">
      <?php
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='15003' and cod_subclase='".$CmbEstadoLote."' order by cod_subclase";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		echo $Fila["nombre_subclase"]."\n";
	}
?>
    </td>
    <td align="right" class="Colum01">Lote Remues.:</td>
    <td class="Colum01"><?php echo $TxtLoteRemuestreo; ?>&nbsp;</td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Cant. Rec.</td>
    <td class="Colum01"><?php echo $CantRecargos; ?></td>
    <td align="right" class="Colum01">Peso Lote:</td>
    <td class="Colum01"><?php echo number_format($TotalPesoNeto,0,",","."); ?></td>
  </tr>
  <tr align="center" class="Colum01">
    <td height="30" colspan="4" class="Colum01"><input name="BtnImprimir" type="button" id="BtnImprimir3" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
<br>
<table width="650"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td width="4%">Rec.</td>
    <td width="3%">Ult.</td>
    <td width="10%">Folio</td>
    <td width="6%">Corr.</td>
    <td width="7%">Fecha.</td>
    <td width="6%">H.Ent</td>
    <td width="6%">H.Sal</td>
    <td width="7%">P.Bruto</td>
    <td width="10%">P.Tara</td>
    <td width="9%">P.Neto</td>
    <td width="10%">Guia</td>
    <td width="11%">Patente</td>
    <td width="4%">Est.</td>
    <td width="4%">Aut.</td>
  </tr>
  <?php	
if (isset($TxtLote) && $TxtLote!="")	
{
	$Consulta = "select t1.fecha_recepcion, t2.hora_entrada, t2.hora_salida, t2.folio, t2.corr, t2.lote, t2.recargo, t2.fin_lote, ";
	$Consulta.= " t1.cod_subproducto, t2.peso_bruto, t2.peso_tara, t2.peso_neto, t2.guia_despacho, ";
	$Consulta.= " t2.guia_despacho, t2.patente, t1.rut_proveedor, LPAD(t2.recargo,2,'0') as orden, t3.valor_subclase1 as est_rec, t2.autorizado ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote=t2.lote ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='15003' and t2.estado_recargo=t3.cod_subclase ";				
	$Consulta.= " where t1.lote = '".$TxtLote."' ";		
	switch ($Orden)
	{
		case "F":
			$Consulta.= " order by t2.fecha_recepcion, t2.lote, orden ";
			break;
		case "O":
			$Consulta.= " order by t2.folio, t2.lote, orden ";
			break;
		case "L":
			$Consulta.= " order by t2.lote, orden ";
			break;
		case "G":
			$Consulta.= " order by t2.guia_despacho, t2.lote, orden ";
			break;
		case "T":
			$Consulta.= " order by t2.patente, t2.lote, orden ";
			break;
		case "P":
			$Consulta.= " order by t1.rut_proveedor, t2.lote, orden ";
			break;
		default:
			$Consulta.= " order by t2.lote, orden ";
			break;
	}		
	$Resp = mysqli_query($link, $Consulta);	
	$TotPesoBr = 0;
	$TotPesoTr = 0;
	$TotPesoNt = 0;
	$ContReg = 0;
	while ($Fila = mysqli_fetch_array($Resp))
	{		
		echo "<tr >\n";		
		echo "<td align='center'>".$Fila["recargo"]."</td>\n";
		if ($Fila["fin_lote"]!="" && !is_null($Fila["fin_lote"]))
			echo "<td align='center'>".$Fila["fin_lote"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "<td align='center'>".$Fila["folio"]."</td>\n";		
		echo "<td align='center'>".$Fila["corr"]."</td>\n";		
		echo "<td align='center'>".substr($Fila["fecha_recepcion"],8,2)."/".substr($Fila["fecha_recepcion"],5,2)."</td>\n";		
		echo "<td align='right'>".substr($Fila["hora_entrada"],0,5)."</td>\n";
		echo "<td align='right'>".substr($Fila["hora_salida"],0,5)."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_bruto"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_tara"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_neto"],0,",",".")."</td>\n";
		if ($Fila["guia_despacho"]!="" && !is_null($Fila["guia_despacho"]))
			echo "<td align='center'>".$Fila["guia_despacho"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		if ($Fila["patente"]!="" && !is_null($Fila["patente"]))
			echo "<td align='center'>".$Fila["patente"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";		
		echo "<td align='center'>".strtoupper($Fila["est_rec"])."</td>\n";
		echo "<td align='center'>".strtoupper($Fila["autorizado"])."</td>\n";
		echo "</tr>\n";
		$TotPesoBr = $TotPesoBr + $Fila["peso_bruto"];
		$TotPesoTr = $TotPesoTr + $Fila["peso_tara"];
		$TotPesoNt = $TotPesoNt + $Fila["peso_neto"];
		$ContReg++;
	}
}	
?>
  <tr class="ColorTabla02">
    <td colspan="4"><strong>Total Lote: </strong></td>
    <td colspan="3"><strong><?php echo number_format($ContReg,0,",",".");?> Rec.</strong></td>
    <td align="right"><?php echo number_format($TotPesoBr,0,",",".");?></td>
    <td align="right"><?php echo number_format($TotPesoTr,0,",",".");?></td>
    <td align="right"><?php echo number_format($TotPesoNt,0,",",".");?></td>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
