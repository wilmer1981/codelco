<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=15;
	include("../principal/conectar_principal.php");

	$TipoCon        = isset($_REQUEST['TipoCon']) ? $_REQUEST['TipoCon'] : ''; 
	$CmbSubProducto = isset($_REQUEST['CmbSubProducto']) ? $_REQUEST['CmbSubProducto'] : ''; 
	$TxtLoteIni  = isset($_REQUEST['TxtLoteIni']) ? $_REQUEST['TxtLoteIni'] : ''; 
	$TxtLoteFin  = isset($_REQUEST['TxtLoteFin']) ? $_REQUEST['TxtLoteFin'] : ''; 
	$TxtFechaIni = isset($_REQUEST['TxtFechaIni']) ? $_REQUEST['TxtFechaIni'] : date("Y-m-d");
	$TxtFechaFin = isset($_REQUEST['TxtFechaFin']) ? $_REQUEST['TxtFechaFin'] :  date("Y-m-d");
	$ContReg     = isset($_REQUEST['ContReg']) ? $_REQUEST['ContReg'] : 0; 
	$TotPesoBr = isset($_REQUEST['TotPesoBr']) ? $_REQUEST['TotPesoBr'] : 0; 
	$Decimales = isset($_REQUEST['Decimales']) ? $_REQUEST['Decimales'] : 0; 
	$TotPesoTr = isset($_REQUEST['TotPesoTr']) ? $_REQUEST['TotPesoTr'] : 0; 
	$TotPesoNt = isset($_REQUEST['TotPesoNt']) ? $_REQUEST['TotPesoNt'] : 0; 
	$NomProdAnt   = isset($_REQUEST['NomProdAnt']) ? $_REQUEST['NomProdAnt'] : ''; 
	$NomRutAnt    = isset($_REQUEST['NomRutAnt']) ? $_REQUEST['NomRutAnt'] : ''; 
	$TotPesoBrAnt = isset($_REQUEST['TotPesoBrAnt']) ? $_REQUEST['TotPesoBrAnt'] : 0; 
	$TotPesoTrAnt = isset($_REQUEST['TotPesoTrAnt']) ? $_REQUEST['TotPesoTrAnt'] : 0; 
	$TotPesoNtAnt = isset($_REQUEST['TotPesoNtAnt']) ? $_REQUEST['TotPesoNtAnt'] : 0; 
	$Reg          = isset($_REQUEST['Reg']) ? $_REQUEST['Reg'] : 0; 
	$TotPesoBrAntSubProd = isset($_REQUEST['TotPesoBrAntSubProd']) ? $_REQUEST['TotPesoBrAntSubProd'] : 0; 
	$TotPesoTrAntSubProd = isset($_REQUEST['TotPesoTrAntSubProd']) ? $_REQUEST['TotPesoTrAntSubProd'] : 0; 
	$TotPesoNtAntSubProd = isset($_REQUEST['TotPesoNtAntSubProd']) ? $_REQUEST['TotPesoNtAntSubProd'] : 0; 
	$RegSubProd = isset($_REQUEST['RegSubProd']) ? $_REQUEST['RegSubProd'] : 0; 
	$LimitFinAnt= isset($_REQUEST['LimitFinAnt']) ? $_REQUEST['LimitFinAnt'] : 0; 
	$LimitIni   = isset($_REQUEST['LimitIni']) ? $_REQUEST['LimitIni'] : 0; 
	$LimitFin   = isset($_REQUEST['LimitFin']) ? $_REQUEST['LimitFin'] : 999; 
	$Orden      = isset($_REQUEST['Orden']) ? $_REQUEST['Orden'] : "T"; 

?>
<html>
<head>
<title>AGE-Consulta Recepcion Diaria</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">

function Proceso(opt,valor)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "CF":
			/*if (f.CmbSubProducto.value=="S")
			{
				alert("Debe Seleccionar SubProducto");
				f.CmbSubProducto.focus();
				return;
			}*/
			f.TxtLoteIni.value = "";
			f.TxtLoteFin.value = "";
			f.action = "age_con_recepcion_diaria.php?TipoCon=CF";
			f.submit();
			break;
		case "CL"://BUSQUEDA POR LOTE
			if (f.TxtLoteIni.value=="")
			{
				alert("Debe Ingresar Lote Inicial");
				f.TxtLoteIni.focus();
				return;
			}
			if (f.TxtLoteFin.value=="" && f.TxtLoteIni.value!="")
			{
				f.TxtLoteFin.value = f.TxtLoteIni.value;
			}
			f.CmbSubProducto.value="S";
			f.action = "age_con_recepcion_diaria.php?TipoCon=CL&Orden=L";
			f.submit();
			break;
		case "E":
			f.action = "age_con_recepcion_diaria_excel.php?TipoCon=<?php echo $TipoCon; ?>&Orden=<?php echo $Orden; ?>";
			f.submit();
			break;
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=10";
			f.submit();
			break;
		case "O": //ORDENA
			f.action = "age_con_recepcion_diaria.php?LimitIni=<?php echo $LimitIni; ?>&TipoCon=<?php echo $TipoCon; ?>&Orden=" + valor;
			f.submit();
			break;
		case "R": //RECARGA
			f.action = "age_con_recepcion_diaria.php?LimitIni=<?php echo $LimitIni; ?>&TipoCon=<?php echo $TipoCon; ?>&Orden=<?php echo $Orden; ?>&"+valor;
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
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
</style></head>

<body><DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<input type="hidden" name="TipoBusqueda" value="<?php echo $TipoCon; ?>">
<table class="TablaPrincipal" width="770">
	<tr>
	  <td width="770" height="340" align="center" valign="top"><br>
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr>
              <td colspan="5"><strong>Ver Recepciones </strong></td>
            </tr>
            <tr>
              <td width="11%">Entre Fechas:</td>
              <td width="38%"><input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al 
              <input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"></td>
              <td width="11%">SubProducto:</td>
              <td colspan="2"><select name="CmbSubProducto" style="width:230px ">
<option value="S" class="NoSelec">VER TODOS LOS SUBPRODUCTOS</option>			  
<?php
	$Consulta = "select * from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='1' order by lpad(cod_subproducto,3,'0')";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($CmbSubProducto == $Fila["cod_subproducto"])
			echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
		else
			echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
	}
?>			  
              </select>                <input name="BtnConsultar" type="button" id="BtnConsultar3" style="width:40px " onClick="Proceso('CF')" value="OK"></td>
            </tr>
            <tr>
              <td>Por Lote: </td>
              <td><input name="TxtLoteIni" type="text" class="InputDer" id="TxtLoteIni" value="<?php echo $TxtLoteIni; ?>" size="15" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtLoteFin');"> 
                Al
                  <input name="TxtLoteFin" type="text" class="InputDer" id="TxtLoteFin" value="<?php echo $TxtLoteFin; ?>" size="15" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'');"></td>
              <td><input name="BtnConsultar2" type="button" id="BtnConsultar22" style="width:40px " onClick="Proceso('CL')" value="OK"></td>
              <td width="19%" align="right">Registros por Pantalla:</td>
              <td width="24%"><input name="LimitFin" type="text" class="InputCen" value="<?php echo $LimitFin; ?>" size="7" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');">              </td>
            </tr>
            <tr align="center">
              <td colspan="5" class="Detalle03"><input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px " onClick="Proceso('I')" value="Imprimir">
                <input name="BtnExcel" type="button" id="BtnExcel" style="width:70px " onClick="Proceso('E')" value="Excel">
              <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
            </tr>
        </table>
		  <br>
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
            <tr class="ColorTabla01">
              <td width="5%"><a href="JavaScript:Proceso('O','F');">Fecha</a></td>
              <td width="7%"><a href="JavaScript:Proceso('O','O');">Correl.</a></td>
              <td width="4%"><a href="JavaScript:Proceso('O','L');">Lote</a></td>
              <td width="4%">R</td>
              <td width="4%">U</td>
              <td width="6%">P.Bruto</td>
              <td width="9%">P.Tara</td>
              <td width="8%">P.Neto</td>
              <td width="6%"><a href="JavaScript:Proceso('O','G');">Guia</a></td>
              <td width="11%"><a href="JavaScript:Proceso('O','T');">Producto</a></td>
              <td width="21%">Proveedor</td>
              <td width="4%"><a href="JavaScript:Proceso('O','C');">Conj</a></td>
              <td width="3%">Cls</td>
              <td width="4%">Aut</td>
            </tr>
<?php	
if (isset($TipoCon) && $TipoCon!="")	
{
	$Consulta = "select t2.fecha_recepcion, t2.corr, t2.lote, t2.recargo, t2.fin_lote, t5.nomprv_a as nom_proveedor,";
	$Consulta.= " t1.cod_producto, t1.cod_subproducto, t2.peso_bruto, t2.peso_tara, t2.peso_neto, t2.guia_despacho, t4.recepcion, ";
	$Consulta.= " t2.guia_despacho, t2.patente, t1.rut_proveedor, LPAD(t2.recargo,2,'0') as orden, ";
	$Consulta.= " t3.valor_subclase1 as est_rec, t2.autorizado, t1.num_conjunto, t4.abreviatura, t1.clase_producto ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote=t2.lote ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='15003' and t2.estado_recargo=t3.cod_subclase ";
	$Consulta.= " inner join proyecto_modernizacion.subproducto t4 on t1.cod_producto=t4.cod_producto and t1.cod_subproducto=t4.cod_subproducto ";
	$Consulta.= " left join rec_web.proved t5 on t1.rut_proveedor=t5.rutprv_a  ";
	switch ($TipoCon)
	{
		case "CF":
			$Consulta.= " where t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";		
			$Consulta.= " and t1.cod_producto='1' ";
			if ($CmbSubProducto!= "S")
				$Consulta.= " and t1.cod_subproducto='".$CmbSubProducto."'";		
			break;
		case "CL":				
			$Consulta.= " where t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";		
			break;
		case "CB":				
			$Consulta.= " where t2.folio between '".$TxtBoletaIni."' and '".$TxtBoletaFin."'";		
			break;
	}
	$Consulta.= " and t1.estado_lote<>'6' ";
	switch ($Orden)
	{
		case "F":
			$Consulta.= " order by t2.fecha_recepcion, t2.lote, orden ";
			break;
		case "O":
			$Consulta.= " order by t2.corr, t2.lote, orden ";
			break;
		case "L":
			$Consulta.= " order by t2.lote, orden ";
			break;
		case "G":
			$Consulta.= " order by t2.guia_despacho, t2.lote, orden ";
			break;
		case "T":
			$Consulta.= " order by lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'), t1.rut_proveedor, t2.lote, orden ";
			break;
		case "C":
			$Consulta.= " order by t1.num_conjunto, t2.lote, orden ";
			break;
		default:
			$Consulta.= " order by lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'), t1.rut_proveedor, t2.lote, orden ";
			break;
	}		
	//echo $Consulta."<br>";
	$Resp = mysqli_query($link, $Consulta);	
	$TotPesoBr = 0;
	$TotPesoTr = 0;
	$TotPesoNt = 0;
	$ContReg = 0;
	$ProdAnt = "";
	$SubProdAnt = "";
	$RutAnt = "";
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Tipo_Recep=$Fila["recepcion"];
		$Decimales=0;
		if ($Tipo_Recep=="PMN")
			$Decimales=3;
		if ($Orden=="T")
		{
			if (($ProdAnt!="" && $SubProdAnt!="") && ($ProdAnt!=$Fila["cod_producto"] || $SubProdAnt!=$Fila["cod_subproducto"]))
			{
				if ($RutAnt!=$Fila["rut_proveedor"])
					EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, $TotPesoBrAnt, $TotPesoTrAnt, $TotPesoNtAnt, $Reg, $Decimales);
				EscribeSubTotal("P", $NomProdAnt, $NomRutAnt, $TotPesoBrAntSubProd, $TotPesoTrAntSubProd, $TotPesoNtAntSubProd, $RegSubProd, $Decimales);
			}
			else
			{
				if (($ProdAnt!="" && $SubProdAnt!="" && $RutAnt!="") && 
				($ProdAnt==$Fila["cod_producto"] && $SubProdAnt==$Fila["cod_subproducto"] && $RutAnt!=$Fila["rut_proveedor"]))
				{
					EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, $TotPesoBrAnt, $TotPesoTrAnt, $TotPesoNtAnt, $Reg, $Decimales);
				}
			}
		}
		//NOMBRE_PROV			
		if ($Fila["nom_proveedor"]=="")
			$NomProv = $Fila["nom_proveedor"];
		else
			$NomProv = $Fila["rut_proveedor"];
		echo "<tr >\n";
		echo "<td align='center'>".substr($Fila["fecha_recepcion"],8,2)."/".substr($Fila["fecha_recepcion"],5,2)."</td>\n";
		echo "<td align='center'>".$Fila["corr"]."</td>\n";
		echo "<td align='center'>".$Fila["lote"]."</td>\n";
		echo "<td align='center'>".$Fila["recargo"]."</td>\n";
		if ($Fila["fin_lote"]!="" && !is_null($Fila["fin_lote"]))
			echo "<td align='center'>".$Fila["fin_lote"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_bruto"],$Decimales,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_tara"],$Decimales,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_neto"],$Decimales,",",".")."</td>\n";
		if ($Fila["guia_despacho"]!="" && !is_null($Fila["guia_despacho"]))
			echo "<td align='center'>".$Fila["guia_despacho"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		if ($Fila["abreviatura"]!="" && !is_null($Fila["abreviatura"]))
			echo "<td>".$Fila["abreviatura"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		if ($NomProv!="")
			echo "<td>".substr($NomProv,0,18)."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		if ($Fila["num_conjunto"]!="")
			echo "<td align='center'>".$Fila["num_conjunto"]."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		echo "<td align='center'>".strtoupper($Fila["clase_producto"])."</td>\n";
		echo "<td align='center'>".strtoupper($Fila["autorizado"])."</td>\n";
		echo "</tr>\n";
		$TotPesoBr = $TotPesoBr + $Fila["peso_bruto"];
		$TotPesoTr = $TotPesoTr + $Fila["peso_tara"];
		$TotPesoNt = $TotPesoNt + $Fila["peso_neto"];
		$TotPesoBrAnt = $TotPesoBrAnt + $Fila["peso_bruto"];
		$TotPesoTrAnt = $TotPesoTrAnt + $Fila["peso_tara"];
		$TotPesoNtAnt = $TotPesoNtAnt + $Fila["peso_neto"];
		$TotPesoBrAntSubProd = $TotPesoBrAntSubProd + $Fila["peso_bruto"];
		$TotPesoTrAntSubProd = $TotPesoTrAntSubProd + $Fila["peso_tara"];
		$TotPesoNtAntSubProd = $TotPesoNtAntSubProd + $Fila["peso_neto"];
		$NomProdAnt = $Fila["abreviatura"];
		$NomRutAnt = $NomProv;
		$ProdAnt = $Fila["cod_producto"];
		$SubProdAnt =$Fila["cod_subproducto"];
		$RutAnt = $Fila["rut_proveedor"];
		$ContReg++;
		$Reg++;
		$RegSubProd++;
	}
	if ($Orden=="T")
	{
		EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, $TotPesoBrAnt, $TotPesoTrAnt, $TotPesoNtAnt, $Reg, $Decimales);
		EscribeSubTotal("P", $NomProdAnt, $NomRutAnt, $TotPesoBrAntSubProd, $TotPesoTrAntSubProd, $TotPesoNtAntSubProd, $RegSubProd, $Decimales);
	}
	//TOTAL POR CONSULTA
	$Consulta = "select sum(t2.peso_bruto) as peso_bruto, sum(t2.peso_tara) as peso_tara, sum(t2.peso_neto) as peso_neto ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 ";
	$Consulta.= " on t1.lote=t2.lote left join rec_web.proved t3 on ";
	$Consulta.= " t3.RUTPRV_A=t1.rut_proveedor ";
	switch ($TipoCon)
	{
		case "CF":
			$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";		
			$Consulta.= " and t1.cod_producto='1' ";
			if ($CmbSubProducto!="S")
				$Consulta.= "  and t1.cod_subproducto='".$CmbSubProducto."'";		
			break;
		case "CL":				
			$Consulta.= " where t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";		
			break;
	}	
	$Consulta.= " and t1.estado_lote<>'6' ";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$TotConPesoBr = $Fila["peso_bruto"];
		$TotConPesoTr = $Fila["peso_tara"];
		$TotConPesoNt = $Fila["peso_neto"];		
	}
	//FIN TOTAL POR CONSULTA	
}
		
function EscribeSubTotal($Opt, $NomProd, $NomRut, $PesoBr, $PesoTr, $PesoNt, $Reg, $Decimales)
{	
	switch ($Opt)
	{
		case "P":
			echo '<tr class="Detalle03">';
			echo '<td colspan="3" align="left"><strong>TOTAL SUBPRODUCTO</strong></td>';
			break;
		case "R":
			echo '<tr class="Detalle01">';
			echo '<td colspan="3" align="left"><strong>TOTAL PROVEEDOR</strong></td>';
			break;
	}
	echo '<td colspan="2" align="center"><strong>'.$Reg.'</strong></td>';	
	echo '<td align="right"><strong>'.number_format($PesoBr,$Decimales,",",".").'</strong></td>';
	echo '<td align="right"><strong>'.number_format($PesoTr,$Decimales,",",".").'</strong></td>';
	echo '<td align="right"><strong>'.number_format($PesoNt,$Decimales,",",".").'</strong></td>';
	switch ($Opt)
	{
		case "P":
			echo '<td colspan="1" align="left">&nbsp;</td>';
			echo '<td colspan="6" align="left"><strong>'.$NomProd.'</strong></td>';
			break;
		case "R":
			echo '<td colspan="2" align="left">&nbsp;</td>';
			echo '<td colspan="4" align="left"><strong>'.$NomRut.'</strong></td>';
			break;
	}
	echo '</tr>';
	$NomProd = "";
	$NomRut = "";
	$PesoBr = 0;
	$PesoTr = 0;
	$PesoNt = 0;
	$Reg = 0;
}
		
?>			
            <tr class="ColorTabla02">
              <td colspan="3"><strong>TOTAL CONSULTA: </strong></td>
              <td colspan="2" align="center"><strong><?php echo number_format($ContReg,0,",",".");?></strong></td>
              <td align="right"><?php echo number_format($TotPesoBr,$Decimales,",",".");?></td>
              <td align="right"><?php echo number_format($TotPesoTr,$Decimales,",",".");?></td>
              <td align="right"><?php echo number_format($TotPesoNt,$Decimales,",",".");?></td>
              <td colspan="6">&nbsp;</td>
            </tr>
		</table>	<br>	
<br></td>
	</tr>
</table>
<input type="hidden" name="LimitFinAnt" value="<?php echo $LimitFinAnt; ?>">
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
