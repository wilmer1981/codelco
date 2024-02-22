<?php
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_principal.php");
	include("funciones.php");	
	if (!isset($LimitIni))
		$LimitIni=0;
	if (!isset($LimitFin))
		$LimitFin=999;	
	/*$ArrLeyes = array();
	$Consulta = "SELECT * from proyecto_modernizacion.leyes ";
	$RespLeyes = mysqli_query($link, $Consulta);	
	while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
	{
		$ArrLeyes[$FilaLeyes["cod_leyes"]][0] = $FilaLeyes["cod_leyes"];
		$ArrLeyes[$FilaLeyes["cod_leyes"]][1] = $FilaLeyes["abreviatura"];
	}*/
?>
<html>
<head>
<title>SIPA-Adm.Recepcion Excel</title>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
            <tr class="ColorTabla01">
              <td width="5%">Fecha</td>
              <td width="5%">Correl.</td>
			  <?php if($CmbTipoRegistro=='R'||$CmbTipoRegistro=='D') 
			  {
			  ?>
              <td width="4%">Lote</td>
              <td width="4%">Rec</td>
              <td width="2%">U</td>
			  <td width="2%">Hora Entr</td>
			  <td width="2%">Hora Sal</td>
			  <td width="2%">Basc Entr</td>
			  <td width="2%">Basc Sal</td>
			  <?php
			  }
              ?>
			  <td width="6%">Patente</td>
              <td width="6%">P.Bruto</td>
              <td width="6%">P.Tara</td>
              <td width="6%">P.Neto</td>
              <td width="6%">Guia</td>
			  <?php if($CmbTipoRegistro=='R'||$CmbTipoRegistro=='D') 
			  {
			  ?>
              <td width="11%">Producto</td>
              <td width="15%">Proveedor</td>
			  <?php
			  }
			  else
			  {
              ?>
			  <td width="11%">Nombre</td>
              <td width="21%">Descripcion</td>
			  <?php
			  }
			  ?>
			  <td width="4%">Conj</td>
            </tr>
<?php	
if (isset($TipoCon) && $TipoCon!="")	
{
	switch($CmbTipoRegistro)
	{
		case "R"://RECEPCION
			$NombreTabla='sipa_web.recepciones';
			break;
		case "D"://DESPACHOS
			$NombreTabla='sipa_web.despachos';
			break;
		case "O"://OTROS PESAJE
			$NombreTabla='sipa_web.otros_pesaje';
			break;
		default:
			$NombreTabla='sipa_web.recepciones';
			break;	
	}
	$Consulta = "SELECT fecha,correlativo, peso_bruto,peso_tara,peso_neto,guia_despacho,patente, conjunto, bascula_entrada, bascula_salida, ";
	switch($CmbTipoRegistro)
	{
		case "R"://RECEPCION
			$Consulta.= " lote,recargo,ult_registro,t5.nombre_prv as nom_proveedor,t6.valor_subclase1 as cod_clase,t1.cod_subproducto,t1.hora_entrada,t1.hora_salida,";
			$Consulta.= " t4.abreviatura, t1.rut_prv, LPAD(recargo,2,'0') as orden, leyes, impurezas,";
			break;
		case "D"://DESPACHOS
			$Consulta.= " lote,recargo,ult_registro,cod_mop,t1.cod_subproducto,t1.hora_entrada,t1.hora_salida,";		
			$Consulta.= " t4.abreviatura,t1.rut_prv, LPAD(recargo,2,'0') as orden, leyes, impurezas,";
			break;
		case "O"://OTROS PESAJE	
			$Consulta.= " nombre,descripcion,";
			break;
	}
	$Consulta.= " hora_entrada,hora_salida from ".$NombreTabla." t1 ";
	switch($CmbTipoRegistro)
	{
		case "R":
			$Consulta.= " left join proyecto_modernizacion.subproducto t4 on ";
			$Consulta.= " t1.cod_producto=t4.cod_producto and t1.cod_subproducto=t4.cod_subproducto ";
			$Consulta.= " left join sipa_web.proveedores t5 on t1.rut_prv=t5.rut_prv  ";
			$Consulta.= " left join proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15001' and t6.nombre_subclase=t1.cod_Clase ";
			break;
		case "D":
			$Consulta.= " left join proyecto_modernizacion.subproducto t4 on ";
			$Consulta.= " t1.cod_producto=t4.cod_producto and t1.cod_subproducto=t4.cod_subproducto ";
			break;	
	}	
	$Est=" estado <> 'A'";
	if ($VerAnulados=='S')
		$Est="estado = 'A'";
	switch ($TipoCon)
	{
		case "CF":
			$Consulta.= " where $Est and fecha between '2006-03-15' and '2007-01-08' and peso_neto <> '0'";		
			/*$Consulta.= " where $Est and fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";		
			$ProdSubProd=explode('~',$CmbSubProducto);
			if ($CmbGrupoProd!= "S"&&$CmbSubProducto== "S")
			{
				$ConsultaGrupo = "SELECT distinct cod_producto from sipa_web.grupos_prod_subprod where cod_grupo='$CmbGrupoProd'";
				$RespAgrup=mysqli_query($link, $ConsultaGrupo);
				while($FilaGrup=mysqli_fetch_array($RespAgrup))
					$CodProd=$CodProd."'".$FilaGrup["cod_producto"]."',";
				$CodProd=substr($CodProd,0,strlen($CodProd)-1);	
				$Consulta.= " and t1.cod_producto in (".$CodProd.")";
			}	
			if ($CmbSubProducto!= "S")
				$Consulta.= " and t1.cod_producto='".$ProdSubProd[0]."' and t1.cod_subproducto='".$ProdSubProd[1]."'";*/
			break;
		case "CL":				
			$Consulta.= " where $Est and lote between '".str_pad($TxtLoteIni,8,0,STR_PAD_LEFT)."' and '".str_pad($TxtLoteFin,8,0,STR_PAD_LEFT)."'";		
			break;
	}
	/*switch ($Orden)
	{
		case "F"://FECHA RECEPCION
			switch($CmbTipoRegistro)
			{
				case "R":
				case "D":
					$Consulta.= " order by fecha,lote,orden ";
					break;
				case "O":
					$Consulta.= " order by fecha ";
					break;	
			}		
			break;
		case "O"://CORRELATIVO
			switch($CmbTipoRegistro)
			{
				case "R":
				case "D":
					$Consulta.= " order by correlativo,lote, orden ";
					break;
				case "O":
					$Consulta.= " order by correlativo ";
					break;	
			}		
			break;
		case "L"://LOTE
			switch($CmbTipoRegistro)
			{
				case "R":
				case "D":
					$Consulta.= " order by t1.lote, orden ";
					break;
			}		
			break;
		case "E"://PATENTE
			switch($CmbTipoRegistro)
			{
				case "R":
				case "D":
					$Consulta.= " order by t1.patente, orden ";
					break;
				case "O":	
					$Consulta.= " order by t1.patente ";
					break;
			}		
			
			break;
		case "G"://GUIA DESPACHO
			switch($CmbTipoRegistro)
			{
				case "R":
				case "D":
					$Consulta.= " order by guia_despacho,lote,orden ";
					break;
				case "O":	
					$Consulta.= " order by guia_despacho ";
					break;
			}		
			break;
		case "T"://PRODUCTO
			switch($CmbTipoRegistro)
			{
				case "R":
					$Consulta.= " order by lpad(t1.cod_subproducto,3,'0'), rut_prv,lote, orden ";
					break;
				case "D":
					$Consulta.= " order by lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'), rut_prv,lote, orden ";
					break;
				case "D":
					$Consulta.= " order by nombre";
					break;
			}		
			break;
		case "P"://PROVEEDOR
			switch($CmbTipoRegistro)
			{
				case "R":
				case "D":
					$Consulta.= " order by rut_prv, lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'),lote, orden ";
					break;
				case "O":	
					$Consulta.= " order by descripcion ";
					break;
			}		
			break;
		case "C"://CONJUNTO
			switch($CmbTipoRegistro)
			{
				case "R":
				case "D":
					$Consulta.= " order by conjunto, lote, orden ";
					break;
				case "O":	
					$Consulta.= " order by conjunto";
					break;
			}		
			break;
		default://POR PROVEEDOR
			switch($CmbTipoRegistro)
			{
				case "R":
				case "D":
					$Consulta.= " order by rut_prv, lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'),lote,orden ";
					break;
			}		
			break;
	}	*/
	$Consulta.= " order by t1.fecha ";
	$ConsultaAux = $Consulta;	
	//$Consulta.= " limit ".$LimitIni.", ".$LimitFin."";	
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	//PARA SABER EL TOTAL DE REGISTROS
	$Respuesta = mysqli_query($link, $ConsultaAux);
	$Coincidencias =  mysqli_num_rows($Respuesta);
	$TotPesoBr = 0;$TotPesoTr = 0;$TotPesoNt = 0;$ContReg = 0;$Reg = 0;
	$ProdAnt="";$SubProdAnt="";$RutAnt="";$Tipo_Recep="";
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Tipo_Recep=$Fila["recepcion"];
		$Decimales=0;
		if ($Orden=="T")
		{
			if (($ProdAnt!="" && $SubProdAnt!="") && ($ProdAnt!=$Fila["cod_producto"] || $SubProdAnt!=$Fila["cod_subproducto"]))
			{
				if ($RutAnt!=$Fila["rut_proveedor"])
					EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, &$TotPesoBrAnt, &$TotPesoTrAnt, &$TotPesoNtAnt, &$Reg, $Decimales);
				EscribeSubTotal("P", $NomProdAnt, $NomRutAnt, &$TotPesoBrAntSubProd, &$TotPesoTrAntSubProd, &$TotPesoNtAntSubProd, &$RegSubProd, $Decimales);
			}
			else
			{
				if (($ProdAnt!="" && $SubProdAnt!="" && $RutAnt!="") && 
				($ProdAnt==$Fila["cod_producto"] && $SubProdAnt==$Fila["cod_subproducto"] && $RutAnt!=$Fila["rut_proveedor"]))
				{
					EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, &$TotPesoBrAnt, &$TotPesoTrAnt, &$TotPesoNtAnt, &$Reg, $Decimales);
				}
			}
		}
		//NOMBRE_PROV
		switch($CmbTipoRegistro)
		{
			case "R":
				$NomProv = $Fila["nom_proveedor"];
				break;
			case "D":
				ObtenerProveedorDespacho('D',$Fila["rut_prv"],$Fila["correlativo"],$Fila["guia_despacho"],&$RutProved,&$NombreProved);
				$NomProv = $NombreProved;
				break;
			case "O":
				$NomProv = $Fila["descripcion"];
				break;
		}
		echo "<tr >\n";
		echo "<td align='center'>".substr($Fila["fecha"],8,2)."/".substr($Fila["fecha"],5,2)."</td>\n";
		echo "<td>".str_pad($Fila["correlativo"],6,0,STR_PAD_LEFT)."&nbsp;</td>";
		if($CmbTipoRegistro=='R'||$CmbTipoRegistro=='D')
		{
			echo "<td align='center'>".str_pad($Fila["lote"],5,0,STR_PAD_LEFT)."</td>\n";
			echo "<td align='center'>".str_pad($Fila["recargo"],2,0,STR_PAD_LEFT)."</td>\n";
			if ($Fila["ult_registro"]!="" && !is_null($Fila["ult_registro"]))
				echo "<td align='center'>".$Fila["ult_registro"]."</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
		}
		echo "<td align='center'>".$Fila["hora_entrada"]."</td>\n";	
		echo "<td align='center'>".$Fila["hora_salida"]."</td>\n";
		echo "<td align='center'>".$Fila["bascula_entrada"]."</td>\n";	
		echo "<td align='center'>".$Fila["bascula_salida"]."</td>\n";
		echo "<td align='center'>".$Fila["patente"]."</td>\n";	
		echo "<td align='right'>".number_format($Fila["peso_bruto"],$Decimales,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_tara"],$Decimales,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_neto"],$Decimales,",",".")."</td>\n";
		if ($Fila["guia_despacho"]!="" && !is_null($Fila["guia_despacho"]))
			echo "<td align='center'>".$Fila["guia_despacho"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		if($CmbTipoRegistro=='R'||$CmbTipoRegistro=='D')
		{
			if ($Fila["abreviatura"]!="" && !is_null($Fila["abreviatura"]))
				echo "<td>".$Fila["abreviatura"]."</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
		}
		else
			echo "<td>".$Fila["nombre"]."</td>\n";		
		echo "<td>".$NomProv."&nbsp;</td>\n";
		if ($Fila["conjunto"]!="")
			echo "<td align='center'>".$Fila["conjunto"]."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
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
	/*if (($Orden=="T")&&($CmbTipoRegistro=='R'||$CmbTipoRegistro=='D'))		
	{
		EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, &$TotPesoBrAnt, &$TotPesoTrAnt, &$TotPesoNtAnt, &$Reg, $Decimales);
		EscribeSubTotal("P", $NomProdAnt, $NomRutAnt, &$TotPesoBrAntSubProd, &$TotPesoTrAntSubProd, &$TotPesoNtAntSubProd, &$RegSubProd, $Decimales);
	}*/
	//TOTAL POR CONSULTA
	$Consulta = "SELECT sum(t1.peso_bruto) as peso_bruto, sum(t1.peso_tara) as peso_tara, sum(t1.peso_neto) as peso_neto ";
	$Consulta.= " from sipa_web.recepciones t1 left join sipa_web.proveedores t3 on ";
	$Consulta.= " t3.rut_prv=t1.rut_prv ";
	switch ($TipoCon)
	{
		case "CF":
			$Consulta.= " where t1.fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."'";		
			if ($CmbProducto!="S")
				$Consulta.= " and t1.cod_producto='1' ";
			if ($CmbSubProducto!="S")
				$Consulta.= "  and t1.cod_subproducto='".$CmbSubProducto."'";		
			break;
		case "CL":				
			$Consulta.= " where t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";		
			break;
	}	
	$Consulta.= " and $Est ";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$TotConPesoBr = $Fila["peso_bruto"];
		$TotConPesoTr = $Fila["peso_tara"];
		$TotConPesoNt = $Fila["peso_neto"];		
	}
	//FIN TOTAL POR CONSULTA	
}	
function EscribeSubTotal($Opt, $NomProd, $NomRut, $PesoBr, $PesoTr, $PesoNt, $RegAux, $Decimales)
{	
	switch ($Opt)
	{
		case "P":
			echo '<tr class="Detalle03">';
			echo '<td colspan="4" align="left"><strong>TOTAL SUBPRODUCTO</strong></td>';
			break;
		case "R":
			echo '<tr class="Detalle01">';
			echo '<td colspan="4" align="left"><strong>TOTAL PROVEEDOR</strong></td>';
			break;
	}
	echo '<td colspan="3" align="center"><strong>'.$RegAux.'</strong></td>';	
	echo '<td align="right"><strong>'.number_format($PesoBr,$Decimales,",",".").'</strong></td>';
	echo '<td align="right"><strong>'.number_format($PesoTr,$Decimales,",",".").'</strong></td>';
	echo '<td align="right"><strong>'.number_format($PesoNt,$Decimales,",",".").'</strong></td>';
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
<?php
	if($CmbTipoRegistro=='R'||$CmbTipoRegistro=='D')
	{
		$Colum1='3';
		$Colum2=3;
	}
	else
	{
		$Colum1=3;
		$Colum2=0;
	}
?>
            <tr class="ColorTabla02">
              <td colspan="<?php echo $Colum1;?>"><strong>TOTAL PAGINA </strong></td>
              <td colspan="<?php echo $Colum2;?>" align="center"><strong><?php echo number_format($ContReg,0,",",".");?> </strong></td>
			  <td align="right"><?php echo number_format($TotPesoBr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotPesoTr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotPesoNt,0,",",".");?></td>
              <td colspan="3">&nbsp;</td>
            </tr>
		</table>	
<?php
	if ($Coincidencias>$LimitFin)			
	{
?>	<br>	
<table width="377"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01">
              <td><strong>TOTAL CONSULTA</strong></td>
              <td width="17%"><strong>P.Bruto</strong></td>
              <td width="16%"><strong>P.Tara</strong></td>
              <td width="16%"><strong>P.Neto</strong></td>
          </tr>
			<tr class="ColorTabla02">
              <td><strong><?php echo number_format($Coincidencias,0,",",".");?> Reg.</strong></td>
              <td align="right"><?php echo number_format($TotConPesoBr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotConPesoTr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotConPesoNt,0,",",".");?></td>
            </tr>
		</table>
<br>
<?php
	}
?>			
</form>
</body>
</html>
