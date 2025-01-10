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
	include("../principal/conectar_principal.php");
	include("funciones.php");	

	$Proceso          = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$CmbProducto      = isset($_REQUEST["CmbProducto"])?$_REQUEST["CmbProducto"]:"";
	$TipoConsulta     = isset($_REQUEST["TipoConsulta"])?$_REQUEST["TipoConsulta"]:"";
	$TxtValores       = isset($_REQUEST["TxtValores"])?$_REQUEST["TxtValores"]:"";
	$TipoRegistro     = isset($_REQUEST["TipoRegistro"])?$_REQUEST["TipoRegistro"]:"";
	$TxtConjunto      = isset($_REQUEST["TxtConjunto"])?$_REQUEST["TxtConjunto"]:"";
	$CmbEstadoLote    = isset($_REQUEST["CmbEstadoLote"])?$_REQUEST["CmbEstadoLote"]:"";
	$CmbClaseProducto = isset($_REQUEST["CmbClaseProducto"])?$_REQUEST["CmbClaseProducto"]:"";
	$TxtNumRomana     = isset($_REQUEST["TxtNumRomana"])?$_REQUEST["TxtNumRomana"]:"";
	$TxtCorr 		 = isset($_REQUEST["TxtCorr"])?$_REQUEST["TxtCorr"]:"";
	$CmbTipoDespacho = isset($_REQUEST["CmbTipoDespacho"])?$_REQUEST["CmbTipoDespacho"]:"";
	$TxtLote        = isset($_REQUEST["TxtLote"])?$_REQUEST["TxtLote"]:"";
	$CmbGrupoProd   = isset($_REQUEST["CmbGrupoProd"])?$_REQUEST["CmbGrupoProd"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor   = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$CmbMinaPlanta  = isset($_REQUEST["CmbMinaPlanta"])?$_REQUEST["CmbMinaPlanta"]:"";
	$CmbClase       = isset($_REQUEST["CmbClase"])?$_REQUEST["CmbClase"]:"";
	$TxtAsignacion  = isset($_REQUEST["TxtAsignacion"])?$_REQUEST["TxtAsignacion"]:"";
	$TxtRecargo     = isset($_REQUEST["TxtRecargo"])?$_REQUEST["TxtRecargo"]:"";
	$TxtFechaRecep  = isset($_REQUEST["TxtFechaRecep"])?$_REQUEST["TxtFechaRecep"]:"";
	$TxtPatente     = isset($_REQUEST["TxtPatente"])?$_REQUEST["TxtPatente"]:"";
	$TxtCorrelativo = isset($_REQUEST["TxtCorrelativo"])?$_REQUEST["TxtCorrelativo"]:"";
	$TxtGuia        = isset($_REQUEST["TxtGuia"])?$_REQUEST["TxtGuia"]:"";
	$TxtObs         = isset($_REQUEST["TxtObs"])?$_REQUEST["TxtObs"]:"";
	$ChkFinLote     = isset($_REQUEST["ChkFinLote"])?$_REQUEST["ChkFinLote"]:"";
	$TxtPesoBruto   = isset($_REQUEST["TxtPesoBruto"])?$_REQUEST["TxtPesoBruto"]:"";
	$TxtPesoTara    = isset($_REQUEST["TxtPesoTara"])?$_REQUEST["TxtPesoTara"]:"";
	$TxtPesoNeto    = isset($_REQUEST["TxtPesoNeto"])?$_REQUEST["TxtPesoNeto"]:"";
	$VerAnulados = $_REQUEST["VerAnulados"];
	$TipoCon     = $_REQUEST["TipoCon"];
	$Orden       = $_REQUEST["Orden"];
	$CmbTipoRegistro = $_REQUEST["CmbTipoRegistro"];
	$LimitIni        = isset($_REQUEST["LimitIni"])?$_REQUEST["LimitIni"]:0;
	$LimitFin        = isset($_REQUEST["LimitFin"])?$_REQUEST["LimitFin"]:999;
	$TxtFechaIni     = $_REQUEST["TxtFechaIni"];
	$TxtFechaFin     = $_REQUEST["TxtFechaFin"];
	$CmbGrupoProd    = $_REQUEST["CmbGrupoProd"];
	$CmbSubProducto  = $_REQUEST["CmbSubProducto"];
	
	$RutProved       = isset($_REQUEST["RutProved"])?$_REQUEST["RutProved"]:"";
	$NombreProved     = isset($_REQUEST["NombreProved"])?$_REQUEST["NombreProved"]:"";
 
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
              <td width="5%">Correl</td>
			  <?php if($CmbTipoRegistro=='R'||$CmbTipoRegistro=='D') 
			  {
			  ?>
              <td width="4%">Lote</td>
              <td width="4%">Rec</td>
              <td width="2%">U</td>
			  <?php
			  }
              ?>
			  <td width="6%">Patente</td>
              <td width="6%">P.Bruto</td>
              <td width="6%">P.Tara</td>
              <td width="6%">P.Neto</td>
			  <?php if($CmbTipoRegistro!='C') 
			  {
			  ?>
              <td width="6%">Guia</td>
			  <?php
			  }
			  ?>
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
		case "C"://CIRCUALANTES
			$NombreTabla='sipa_web.otros_pesaje';
			break;
		default:
			$NombreTabla='sipa_web.recepciones';
			break;	
	}
	$Consulta = "SELECT fecha,correlativo, peso_bruto,peso_tara,peso_neto,guia_despacho,patente, conjunto, ";
	switch($CmbTipoRegistro)
	{
		case "R"://RECEPCION
			$Consulta.= " lote,recargo,ult_registro,t5.nombre_prv as nom_proveedor,t6.valor_subclase1 as cod_clase,t1.cod_subproducto,";
			$Consulta.= " t4.abreviatura, t1.rut_prv, LPAD(recargo,2,'0') as orden, leyes, impurezas,";
			break;
		case "D"://DESPACHOS
			$Consulta.= " lote,recargo,ult_registro,cod_mop,t1.cod_subproducto,";		
			$Consulta.= " t4.abreviatura,t1.rut_prv, LPAD(recargo,2,'0') as orden, leyes, impurezas,";
			break;
		case "O"://OTROS PESAJE	
		case "C"://OTROS PESAJE	
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
		case "CF"://CONSULTA POR PRODUCTOS
			if($CmbTipoRegistro=='R')
				$Consulta.= " where $Est and fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."' and tipo <> 'A' ";		
			else
				$Consulta.= " where $Est and fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";		
			if($CmbTipoRegistro=='R'||$CmbTipoRegistro=='D')			
			{
				$ProdSubProd=explode('~',$CmbSubProducto);
				if ($CmbGrupoProd!= "S"&&$CmbSubProducto== "S")
				{
					$ConsultaGrupo = "SELECT distinct cod_producto,cod_subproducto from sipa_web.grupos_prod_subprod where cod_grupo='$CmbGrupoProd'";
					$RespAgrup=mysqli_query($link, $ConsultaGrupo);
					while($FilaGrup=mysqli_fetch_array($RespAgrup))
					{
						$CodProd=$CodProd."(t1.cod_producto='".$FilaGrup["cod_producto"]."' and t1.cod_subproducto='".$FilaGrup["cod_subproducto"]."') or ";
						//$CodProd=$CodProd."'".$FilaGrup["cod_producto"]."',";
					}
					$CodProd=substr($CodProd,0,strlen($CodProd)-3);	
					//$CodProd=substr($CodProd,0,strlen($CodProd)-1);	
					//$Consulta.= " and t1.cod_producto in (".$CodProd.")";
					$Consulta.= " and (".$CodProd.")";
				}	
				if ($CmbSubProducto!= "S")
					$Consulta.= " and t1.cod_producto='".$ProdSubProd[0]."' and t1.cod_subproducto='".$ProdSubProd[1]."'";
			}
			if($CmbTipoRegistro=='O'||$CmbTipoRegistro=='C')
			{
				$Consulta.= " and observacion <> 'TARA' ";
				if($CmbTipoRegistro=='O')
					$Consulta.= " and (conjunto='' or conjunto='0') ";
				else
					$Consulta.= " and (conjunto<>'' and  conjunto<>'0') ";	
			}
			break;
		case "CL":
			if($CmbTipoRegistro=='R')	//CONSULTA POR LOTE			
				$Consulta.= " where $Est and lote between '".str_pad($TxtLoteIni,8,0,STR_PAD_LEFT)."' and '".str_pad($TxtLoteFin,8,0,STR_PAD_LEFT)."' and tipo <> 'A'";		
			else
				$Consulta.= " where $Est and lote between '".str_pad($TxtLoteIni,8,0,STR_PAD_LEFT)."' and '".str_pad($TxtLoteFin,8,0,STR_PAD_LEFT)."'";		
			break;
		case "CC"://CONSULTA POR CONJUNTO
			$Consulta.= " where $Est and observacion <> 'TARA' and fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."' and conjunto='".trim($TxtConjunto)."'";		
			break;

	}
	switch ($Orden)
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
				case "C":	
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
	}	
	$ConsultaAux = $Consulta;	
	$Consulta.= " limit ".$LimitIni.", ".$LimitFin."";	
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	//PARA SABER EL TOTAL DE REGISTROS
	//echo $ConsultaAux;
	$Respuesta = mysqli_query($link, $ConsultaAux);
	$Coincidencias =  mysqli_num_rows($Respuesta);
	$TotPesoBr = 0;$TotPesoTr = 0;$TotPesoNt = 0;$ContReg = 0;$Reg = 0;
	$ProdAnt="";$SubProdAnt="";$RutAnt="";$Tipo_Recep="";

	$TotPesoBrAnt=0; $TotPesoTrAnt=0; $TotPesoNtAnt=0; $TotPesoBrAntSubProd=0; $TotPesoTrAntSubProd=0;
	$TotPesoNtAntSubProd=0; $RegSubProd=0;

	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Tipo_Recep=isset($Fila["recepcion"])?$Fila["recepcion"]:"";
		$Decimales=0;
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
		switch($CmbTipoRegistro)
		{
			case "R":
				$NomProv = $Fila["nom_proveedor"];
				break;
			case "D":
				$proveedor = ObtenerProveedorDespacho('D',$Fila["rut_prv"],$Fila["correlativo"],$Fila["guia_despacho"],$RutProved,$NombreProved,$link);
				$prov      = explode("**",$proveedor);
				$RutProved = $prov[0];
				$NomProv   = $prov[1];
				//$NomProv = $NombreProved;
				break;
			case "O":
				$Nombre  = $Fila["nombre"];
				$NomProv = $Fila["descripcion"];
				break;
			case "C":
				$Consulta="SELECT descripcion from proyecto_modernizacion.productos where cod_producto='".trim($Fila["nombre"])."'";
				$RespProdRam=mysqli_query($link, $Consulta);
				if($FilaProdRam=mysqli_fetch_array($RespProdRam))
					$Nombre = $FilaProdRam["descripcion"];
				else
					$Nombre='';
				
				$Consulta="SELECT descripcion from proyecto_modernizacion.subproducto where cod_producto='".trim($Fila["nombre"])."' and cod_subproducto='".trim($Fila["descripcion"])."'";
				$RespProdRam=mysqli_query($link, $Consulta);
				if($FilaProdRam=mysqli_fetch_array($RespProdRam))
					$NomProv = $FilaProdRam["descripcion"];
				else
					$NomProv='';
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
		echo "<td align='center'>".$Fila["patente"]."</td>\n";	
		echo "<td align='right'>".number_format($Fila["peso_bruto"],$Decimales,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_tara"],$Decimales,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_neto"],$Decimales,",",".")."</td>\n";
		if($CmbTipoRegistro!='C')
		{
			if ($Fila["guia_despacho"]!="" && !is_null($Fila["guia_despacho"]))
				echo "<td align='center'>".$Fila["guia_despacho"]."</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
		}
		if($CmbTipoRegistro=='R'||$CmbTipoRegistro=='D')
		{
			if ($Fila["abreviatura"]!="" && !is_null($Fila["abreviatura"]))
				echo "<td>".$Fila["abreviatura"]."</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
		}
		else
			echo "<td>".$Nombre."&nbsp;</td>\n";		
		echo "<td>".substr($NomProv,0,18)."&nbsp;</td>\n";
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
		$NomProdAnt = isset($Fila["abreviatura"])?$Fila["abreviatura"]:"";
		$NomRutAnt  = $NomProv;
		$ProdAnt    = isset($Fila["cod_producto"])?$Fila["cod_producto"]:"";
		$SubProdAnt = isset($Fila["cod_subproducto"])?$Fila["cod_subproducto"]:"";
		$RutAnt     = isset($Fila["rut_proveedor"])?$Fila["rut_proveedor"]:"";
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
		$Colum3=3;
	}
	else
	{
		$Colum1=2;
		$Colum2=0;
		$Colum3=3;
	}
?>
            <tr class="ColorTabla02">
              <td colspan="<?php echo $Colum1;?>"><strong>TOTAL PAGINA </strong></td>
              <td colspan="<?php echo $Colum2;?>" align="center"><strong><?php echo number_format($ContReg,0,",",".");?> </strong></td>
			  <td align="right"><?php echo number_format($TotPesoBr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotPesoTr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotPesoNt,0,",",".");?></td>
              <td colspan="<?php echo $Colum3;?>">&nbsp;</td>
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
