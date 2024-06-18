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
	$CodigoDeSistema=15;
	$CodigoDePantalla=11;
	include("../principal/conectar_principal.php");
	$TipoCon = isset($_REQUEST['TipoCon']) ? $_REQUEST['TipoCon'] : '';
	$Orden = isset($_REQUEST['Orden']) ? $_REQUEST['Orden'] : '';
	$CmbSubProducto = isset($_REQUEST['CmbSubProducto']) ? $_REQUEST['CmbSubProducto'] : '';
	$TxtFechaIni = isset($_REQUEST['TxtFechaIni']) ? $_REQUEST['TxtFechaIni'] : date("Y-m-d");
	$TxtFechaFin = isset($_REQUEST['TxtFechaFin']) ? $_REQUEST['TxtFechaFin'] : date("Y-m-d");

	$LimitIni = isset($_REQUEST['LimitIni']) ? $_REQUEST['LimitIni'] : 0;
	$LimitFin = isset($_REQUEST['LimitFin']) ? $_REQUEST['LimitFin'] : 999;
	$CmbAutorizado = isset($_REQUEST['CmbAutorizado']) ? $_REQUEST['CmbAutorizado'] : 'T';
	$TxtLoteIni = isset($_REQUEST['TxtLoteIni']) ? $_REQUEST['TxtLoteIni'] : '';
	$TxtLoteFin = isset($_REQUEST['TxtLoteFin']) ? $_REQUEST['TxtLoteFin'] : '';

	$ContReg = isset($_REQUEST['ContReg']) ? $_REQUEST['ContReg'] : 0;
	$TotPesoBr = isset($_REQUEST['TotPesoBr']) ? $_REQUEST['TotPesoBr'] : 0;
	$TotPesoBrAnt = isset($_REQUEST['TotPesoBrAnt']) ? $_REQUEST['TotPesoBrAnt'] : 0;
	$TotPesoTr = isset($_REQUEST['TotPesoTr']) ? $_REQUEST['TotPesoTr'] : 0;
	$TotPesoTrAnt = isset($_REQUEST['TotPesoTrAnt']) ? $_REQUEST['TotPesoTrAnt'] : 0;
	$TotPesoNt = isset($_REQUEST['TotPesoNt']) ? $_REQUEST['TotPesoNt'] : 0;
	$TotPesoNtAnt = isset($_REQUEST['TotPesoNtAnt']) ? $_REQUEST['TotPesoNtAnt'] : 0;
	$LimitFinAnt = isset($_REQUEST['LimitFinAnt']) ? $_REQUEST['LimitFinAnt'] : 0;
	$TotPesoBrAntSubProd = isset($_REQUEST['TotPesoBrAntSubProd']) ? $_REQUEST['TotPesoBrAntSubProd'] : 0;
	$TotPesoTrAntSubProd = isset($_REQUEST['TotPesoTrAntSubProd']) ? $_REQUEST['TotPesoTrAntSubProd'] : 0;
	$TotPesoNtAntSubProd = isset($_REQUEST['TotPesoNtAntSubProd']) ? $_REQUEST['TotPesoNtAntSubProd'] : 0;
	$RegSubProd = isset($_REQUEST['RegSubProd']) ? $_REQUEST['RegSubProd'] : 0;
?>
<html>
<head>
<title>Sistema de Agencia</title></head>

<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="TipoBusqueda" value="<?php echo $TipoCon; ?>">
		  <br>
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
            <tr class="ColorTabla01">
              <td width="5%">Fecha</td>
              <td width="7%">Correl.</td>
              <td width="4%">Lote</td>
              <td width="4%">R</td>
              <td width="4%">U</td>
              <td width="6%">P.Bruto</td>
              <td width="9%">P.Tara</td>
              <td width="8%">P.Neto</td>
              <td width="6%">Guia</td>
              <td width="11%">Producto</td>
              <td width="21%">Proveedor</td>
              <td width="4%">Conj</td>
              <td width="3%">Cls</td>
              <td width="4%">Aut</td>
            </tr>
<?php	
if (isset($TipoCon) && $TipoCon!="")	
{
	$Consulta = "select t2.fecha_recepcion, t2.corr, t2.lote, t2.recargo, t2.fin_lote, t5.nomprv_a as nom_proveedor, ";
	$Consulta.= " t1.cod_producto, t1.cod_subproducto, t2.peso_bruto, t2.peso_tara, t2.peso_neto, t2.guia_despacho, ";
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
	if ($CmbAutorizado!="T")
			$Consulta.= " and t2.autorizado='".$CmbAutorizado."'";		
	switch ($Orden)
	{
		case "F"://FECHA RECEPCION
			$Consulta.= " order by t2.fecha_recepcion, t2.lote, orden ";
			break;
		case "O"://CORRELATIVO
			$Consulta.= " order by t2.corr, t2.lote, orden ";
			break;
		case "L"://LOTE
			$Consulta.= " order by t2.lote, orden ";
			break;
		case "G"://GUIA DESPACHO
			$Consulta.= " order by t2.guia_despacho, t2.lote, orden ";
			break;
		case "T"://PRODUCTO
			$Consulta.= " order by lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'), t1.rut_proveedor, t2.lote, orden ";
			break;
		case "P"://PROVEEDOR
			$Consulta.= " order by t1.rut_proveedor, lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'), t2.lote, orden ";
			break;
		case "C"://CONJUNTO
			$Consulta.= " order by t1.num_conjunto, t2.lote, orden ";
			break;
		default://POR PROVEEDOR
			$Consulta.= " order by t1.rut_proveedor, lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'), t2.lote, orden ";
			break;
	}	
	$ConsultaAux = $Consulta;	
	$Consulta.= " limit ".$LimitIni.", ".$LimitFin."";	
	$Resp = mysqli_query($link, $Consulta);
	//PARA SABER EL TOTAL DE REGISTROS
	$Respuesta = mysqli_query($link, $ConsultaAux);
	$Coincidencias =  mysqli_num_rows($Respuesta);
	//------------------------------
	$TotPesoBr = 0;
	$TotPesoTr = 0;
	$TotPesoNt = 0;
	$ContReg = 0;
	$Reg = 0;
	$ProdAnt="";
	$SubProdAnt="";
	$RutAnt="";
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Orden=="T")
		{
			if (($ProdAnt!="" && $SubProdAnt!="") && ($ProdAnt!=$Fila["cod_producto"] || $SubProdAnt!=$Fila["cod_subproducto"]))
			{
				if ($RutAnt!=$Fila["rut_proveedor"])
					EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, $TotPesoBrAnt, $TotPesoTrAnt, $TotPesoNtAnt, $Reg);
				EscribeSubTotal("P", $NomProdAnt, $NomRutAnt, $TotPesoBrAntSubProd, $TotPesoTrAntSubProd, $TotPesoNtAntSubProd, $RegSubProd);
			}
			else
			{
				if (($ProdAnt!="" && $SubProdAnt!="" && $RutAnt!="") && 
				($ProdAnt==$Fila["cod_producto"] && $SubProdAnt==$Fila["cod_subproducto"] && $RutAnt!=$Fila["rut_proveedor"]))
				{
					EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, $TotPesoBrAnt, $TotPesoTrAnt, $TotPesoNtAnt, $Reg);
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
		echo "<td align='right'>".number_format($Fila["peso_bruto"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_tara"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_neto"],0,",",".")."</td>\n";
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
		echo "<td align='center'>".$Fila["num_conjunto"]."</td>\n";
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
		EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, $TotPesoBrAnt, $TotPesoTrAnt, $TotPesoNtAnt, $Reg);
		EscribeSubTotal("P", $NomProdAnt, $NomRutAnt, $TotPesoBrAntSubProd, $TotPesoTrAntSubProd, $TotPesoNtAntSubProd, $RegSubProd);
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
function EscribeSubTotal($Opt, $NomProd, $NomRut, $PesoBr, $PesoTr, $PesoNt, $RegAux)
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
	echo '<td colspan="2" align="center"><strong>'.$RegAux.'</strong></td>';	
	echo '<td align="right"><strong>'.number_format($PesoBr,0,",",".").'</strong></td>';
	echo '<td align="right"><strong>'.number_format($PesoTr,0,",",".").'</strong></td>';
	echo '<td align="right"><strong>'.number_format($PesoNt,0,",",".").'</strong></td>';
	switch ($Opt)
	{
		case "P":
			echo '<td colspan="1" align="left">&nbsp;</td>';
			echo '<td colspan="5" align="left"><strong>'.$NomProd.'</strong></td>';
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
	$RegAux = 0;
}
?>			
            <tr class="ColorTabla02">
              <td colspan="3"><strong>TOTAL PAGINA </strong></td>
              <td colspan="2" align="center"><strong><?php echo number_format($ContReg,0,",",".");?> </strong></td>
              <td align="right"><?php echo number_format($TotPesoBr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotPesoTr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotPesoNt,0,",",".");?></td>
              <td colspan="6">&nbsp;</td>
            </tr>
	  </table>
<input type="hidden" name="LimitFinAnt" value="<?php echo $LimitFinAnt; ?>">
</form>
</body>
</html>
