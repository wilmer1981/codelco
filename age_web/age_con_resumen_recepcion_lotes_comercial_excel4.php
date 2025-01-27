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
	include("../age_web/age_funciones.php");

	$CmbMes      = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	$CmbAno      = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";
	$TxtCodLeyes = isset($_REQUEST["TxtCodLeyes"])?$_REQUEST["TxtCodLeyes"]:"";
	$CmbRecepcion     = isset($_REQUEST["CmbRecepcion"])?$_REQUEST["CmbRecepcion"]:"";
	$CmbSubProducto   = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor     = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	
	$OptFinos  = isset($_REQUEST["OptFinos"])?$_REQUEST["OptFinos"]:"";
	$OptLeyes  = isset($_REQUEST["OptLeyes"])?$_REQUEST["OptLeyes"]:"";
	$TxtFechaCon = isset($_REQUEST["TxtFechaCon"])?$_REQUEST["TxtFechaCon"]:"";	
	
	$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
	$FechaMer=$CmbAno.str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
	//$TxtFechaCon="2005-06-22";
	$ArrLeyes=array();
	$ArrLeyesAux=array();
	$ArrLeyesPrv=array();
	$ArrLeyesAsig=array();
	$ArrLeyesProd=array();
	$ArrLeyesTot=array();
	$ArrLeyesAux["01"][0]="01";
	$ArrLeyesAux["01"][1]="H2O";
	$ArrLeyesAux["01"][2]="1";
	$ArrLeyesAux["01"][3]="100";
	$ArrLeyesAux["01"][5]=2;
	$ArrLeyes["01"][0]="01";
	$Datos=explode('//',$TxtCodLeyes);
	$ContLeyes=0;
	$LeyesImp="(01,";		
	$HayImpurezas=false;
	foreach($Datos as $c => $v)
	{
		$ContLeyes++;
		$Datos2=explode('~',$v);
		$ArrLeyesAux[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
		$ArrLeyesAux[$Datos2[0]][1]=$Datos2[1];//NOMBRE LEY
		$ArrLeyesAux[$Datos2[0]][2]=$Datos2[2];//CODIGO UNIDAD
		$ArrLeyesAux[$Datos2[0]][3]=$Datos2[3];//CONVERSION	
		$ArrLeyesAux[$Datos2[0]][4]=$Datos2[4];//NOMBRE UNIDAD
		if ($ArrLeyesAux[$Datos2[0]][2]==1)
			$ArrLeyesAux[$Datos2[0]][5]=3;// 02 DECIMALES a los porcentajes (%)
		else
			$ArrLeyesAux[$Datos2[0]][5]=$Datos2[5];//DECIMALES
		$ArrLeyes[$Datos2[0]][0]=$Datos2[0];
		if(intval($Datos2[0])>5)
			$HayImpurezas=true;
		$LeyesImp=$LeyesImp."'$Datos2[0]',";	
		$ArrLeyesPrv[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
		$ArrLeyesPrv[$Datos2[0]][1]=$Datos2[3];//CONVERSION
		$ArrLeyesAsig[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
		$ArrLeyesAsig[$Datos2[0]][1]=$Datos2[3];//CONVERSION
		$ArrLeyesProd[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
		$ArrLeyesProd[$Datos2[0]][1]=$Datos2[3];//CONVERSION
		$ArrLeyesTot[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
		$ArrLeyesTot[$Datos2[0]][1]=$Datos2[3];//CONVERSION
	}
	$LeyesImp=substr($LeyesImp,0,strlen($LeyesImp)-1);
	$LeyesImp=$LeyesImp.')';
	//echo $LeyesImp;
?>
<html>
<head>
<title>AGE-Resumen Recepcion Lotes Comercial Excel</title>
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
			f.action = "age_con_resumen_recepcion_lotes_comercial.php";
			f.submit();
			break;
	}
}
</script>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="620" border="0" align="center">
    <tr>
      <td width="294">CODELCO CHILE<br>
        DIVISION VENTANAS    V-2   <br> </td>
      <td width="296" align="right">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><strong><u>INFORME RECEPCION POR LOTES COMERCIAL</u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="2">MES: <?php echo $CmbMes."-".$CmbAno; ?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  </table>
  <br>
	<?php
	$ColSpan=3+($ContLeyes*2);
	reset($ArrLeyes);
	foreach($ArrLeyes as $c=>$v)
	{
		if($c!='01')
			$ColSpan=$ColSpan+1;
	}
	$ColSpan=$ColSpan+5;	
	echo "<table width=\"600\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,4,'0') as orden ,recepcion ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
	if ($CmbRecepcion!='S')
		$Consulta.= " and t1.cod_recepcion= '".$CmbRecepcion."' ";
	if ($CmbSubProducto != "S")
	{
		$Consulta.= " and t1.cod_producto = '1' ";
		$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
	}
	if ($CmbProveedor != "S")
		$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
	$Consulta.= " order by t1.cod_producto, orden ";
	//echo $Consulta."<br>";
	$Resp01 = mysqli_query($link, $Consulta);
	//WSO
	$TotalPesoHumTot=0;$TotalPesoSecTot=0;
	$TotalFinoCuTot=0;$TotalFinoAgTot=0;$TotalFinoAuTot=0;
	while ($Fila01 = mysqli_fetch_array($Resp01))	
	{			
		echo "<tr class=\"ColorTabla01\">\n";			
		$Consulta = "select * from proyecto_modernizacion.subproducto ";
		$Consulta.= "where cod_producto = '".$Fila01["cod_producto"]."' and cod_subproducto='".$Fila01["cod_subproducto"]."'";		
		$RespAux2 = mysqli_query($link, $Consulta);
		if ($FilaAux2 = mysqli_fetch_array($RespAux2))
		{
			$NomSubProd = $FilaAux2["descripcion"];
		}
		else
			$NomSubProd = "SIN IDENTIFICACION";		
		echo "<td align=\"left\" colspan=\"".$ColSpan."\">".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>";					
		echo "</tr>\n";
		//TITULO						
		echo "<tr class=\"ColorTabla02\">\n";		
		echo "<td align=\"center\" rowspan=\"2\">Lote</td>\n";
		echo "<td align=\"center\" rowspan=\"2\">F.Recep.</td>\n";		
		echo "<td align=\"center\" rowspan=\"2\">P.Hum.<br>(Kg)</td>\n";
		if ($OptFinos!="S")
			echo "<td align=\"center\" rowspan=\"2\">P.Seco<br>(Kg)</td>\n";
		if ($OptLeyes=="S")
			echo "<td align=\"center\" colspan=\"4\">Leyes</td>\n";
		if($OptLeyes=="S" && $HayImpurezas==true)		
			echo "<td align=\"center\" colspan=\"".($ContLeyes-3)."\">Impurezas</td>\n";
		if ($OptFinos=="S")
			echo "<td align=\"center\" rowspan=\"2\">P.Seco<br>(Kg)</td>\n";
		if ($OptFinos=="S")
			echo "<td align=\"center\" colspan=\"3\">Fino Ley</td>\n";
		if($OptFinos=="S" && $HayImpurezas==true)		
			echo "<td align=\"center\" colspan=\"".($ContLeyes-3)."\">Fino Impurezas</td>\n";
		echo "<td align=\"center\" colspan=\"3\">Deduccion Metalurgica</td>\n";
		echo "<td align=\"center\" colspan=\"3\">Finos Pagables</td>\n";	
		echo "</tr>";
		echo "<tr class=\"ColorTabla02\">\n";
		if ($OptLeyes=="S")
		{
			echo "<td align=\"center\">Hum<br>(%)</td>\n";
			reset($ArrLeyesAux);
			foreach($ArrLeyesAux as $c=>$v)
			{
				if($c!='01')
					echo "<td align=\"center\">".$v[1]."<br>(".$v[4].")</td>\n";
			}
		}
		//echo "<td align=\"center\">P.Seco<br>(Kg)</td>\n";
		if ($OptFinos=="S")
		{
			
			reset($ArrLeyesAux);
			foreach($ArrLeyesAux as $c=>$v)
			{
				switch ($c)
				{
					case "02":
						$Unidad="Kg";
						break;
					case "04":
						$Unidad="grs";
						break;
					case "05":
						$Unidad="grs";
						break;
					default:
						$Unidad="Kg";
						break;
				}
				if($c!='01')
					echo "<td align=\"center\">".$v[1]."<br>(".$Unidad.")</td>\n";
			}
		}	
		echo "<td align='center'>Cu</td>";	
		echo "<td align='center'>Ag</td>";	
		echo "<td align='center'>Au</td>";	
		echo "<td align='center'>Cu</td>";	
		echo "<td align='center'>Ag</td>";	
		echo "<td align='center'>Au</td>";	
		echo "</tr>\n";
		//CONSULTA LOS TIPOS DE RECEPCION
		$Consulta = "select distinct t1.cod_recepcion, t3.nombre_subclase as desc_a";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase ='3104' and t1.cod_recepcion=t3.nombre_subclase ";
		$Consulta.= " where t1.lote<>'' ";
		$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
		if ($CmbRecepcion!='S')
			$Consulta.= " and t1.cod_recepcion= '".$CmbRecepcion."' ";
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		$Consulta.= " order by t1.cod_recepcion ";
		//echo $Consulta."<br>";
		$RutPrv2='';
		$RespTipoRecep = mysqli_query($link, $Consulta);
		//WSO
		$TotalPesoHumProd=0;$TotalPesoSecProd=0;$TotalFinoCuProd=0;$TotalFinoAgProd=0;$TotalFinoAuProd=0;
		$TotalDeducCuProd=0;$TotalDeducAgProd=0;$TotalDeducAuProd=0;$TotalFPCuProd=0;$TotalFPAgProd=0;$TotalFPAuProd=0;
		while ($FilaTipoRecep = mysqli_fetch_array($RespTipoRecep))
		{					
			//TITULO COD RECEPCION
			echo "<tr bgcolor=\"#CCCCCC\">\n";	
			if ($FilaTipoRecep["desc_a"] == "" || is_null($FilaTipoRecep["desc_a"]))
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">&nbsp;</td>\n";				
			else
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";		
			echo "</tr>\n";
			echo "<tr><td colspan='$ColSpan'>&nbsp;</td></tr>";
			//CONSULTA LOS PROVEEDOR DE UN PRODUCTO Y UN TIPO DE RECEPCION
			$Consulta = "select distinct t1.rut_proveedor, t1.cod_recepcion  ";
			$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
			$Consulta.= " on t1.lote = t2.lote ";
			$Consulta.= " where t1.lote<>'' ";
			$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
			$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
			$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
			if ($CmbProveedor != "S")
				$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
			$Consulta.= " and t1.cod_recepcion = '".$FilaTipoRecep["cod_recepcion"]."' ";
			$Consulta.= " order by t1.cod_recepcion, t1.rut_proveedor ";
			//echo $Consulta."<br>";
			$RutPrv='';
			$RespAux = mysqli_query($link, $Consulta);
			//WSO
			$TotalPesoHumAsig=0;$TotalPesoSecAsig=0;
			$TotalFinoCuAsig=0;$TotalFinoAgAsig=0;$TotalFinoAuAsig=0;
			$TotalDeducCuAsig=0;$TotalDeducAgAsig=0;$TotalDeducAuAsig=0;
			$TotalFPCuAsig=0;$TotalFPAgAsig=0;$TotalFPAuAsig=0;
			while ($FilaAux = mysqli_fetch_array($RespAux))
			{		
				$Datos = explode("-",$FilaAux["rut_proveedor"]);
				$RutAux = $FilaAux["rut_proveedor"];
				$NomProveedor = "";
				$Consulta = "select * ";
				$Consulta.= " from sipa_web.proveedores ";
				$Consulta.= " where rut_prv = '".$RutAux."'";
				$RespProv = mysqli_query($link, $Consulta);	
				//echo $Consulta."<br>";
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$NomProveedor = $FilaProv["nombre_prv"];
				}				
				echo "<tr class=\"Detalle01\">\n";
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">".$FilaAux["rut_proveedor"]."&nbsp;&nbsp;".substr(strtoupper($NomProveedor),0,30)."</td>\n";
				echo "</tr>\n";				
				$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
				$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion, tipo_remuestreo,canjeable,cod_producto,cod_subproducto,peso_retalla,peso_muestra ";		
				$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
				$Consulta.= " on t1.lote = t2.lote ";			
				$Consulta.= " where t1.cod_producto = '".$Fila01["cod_producto"]."' ";
				$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
				//$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
				$Consulta.= " and ((t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
				if($CmbAno=='2005')
				{	
					$Consulta.= " AND left(num_lote_remuestreo,3) in ('".substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."',''))";
					$Consulta.= " or (tipo_remuestreo='A' AND left(num_lote_remuestreo,3)='".substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."'))";
				}
				else
				{	
					$Consulta.= " AND left(num_lote_remuestreo,4) in ('".substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."',''))";
					$Consulta.= " or (tipo_remuestreo='A' AND left(num_lote_remuestreo,4)='".substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."'))";	
				}	
				$Consulta.= " and t1.rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
				$Consulta.= " and t1.cod_recepcion = '".$FilaAux["cod_recepcion"]."' ";					
				$Consulta.= " and t1.estado_lote <>'6' group by t1.lote order by t1.lote, orden";
				$RespLote = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				$EsPlamen=false;
				$PorcMerma=0;$SiMerma=0;$VarMerma=0;$PrvMerma=0;
				//WSO
				$TotalPesoHumPrv=0;$TotalPesoSecPrv=0;$TotalFinoCuPrv=0;$TotalFinoAgPrv=0;$TotalFinoAuPrv=0;
				$TotalDeducCuPrv=0;$TotalDeducAgPrv=0;$TotalDeducAuPrv=0;$TotalFPCuPrv=0;$TotalFPAgPrv=0;$TotalFPAuPrv=0;
				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					echo "<tr>";
					echo "<td align=\"center\">".$FilaLote["lote"]."</td>";
					echo "<td align=\"center\">".substr($FilaLote["fecha_recepcion"],8,2)."/".substr($FilaLote["fecha_recepcion"],5,2)."/".substr($FilaLote["fecha_recepcion"],0,4)."</td>";
					$TotalPesoSecLote=0;$TotalPesoHumLote=0;
					$PorcMerma=0;$SiMerma=0;$VarMerma=0;$PrvMerma=0;
					$Consulta = "select * from age_web.mermas ";
					$Consulta.= " where cod_producto='".$FilaLote["cod_producto"]."' ";
					$Consulta.= " and cod_subproducto='".$FilaLote["cod_subproducto"]."' ";
					$Consulta.=" and ((year(fecha) < '".$CmbAno."') or (year(fecha) = '".$CmbAno."' and month(fecha) <= '".$CmbMes."'))";
					$Consulta.=" order by cod_producto,cod_subproducto,rut_proveedor";
					$RespMerma=mysqli_query($link, $Consulta);
					while($FilaMerma=mysqli_fetch_array($RespMerma))
					{
						if ($FilaMerma["rut_proveedor"]=="")
						{
							$VarMerma = ($FilaMerma["porc"] * 1);
						}
						$Consulta2 = "select * from age_web.mermas ";
						$Consulta2.= " where cod_producto='".$FilaLote["cod_producto"]."' ";
						$Consulta2.= " and cod_subproducto='".$FilaLote["cod_subproducto"]."' ";
						$Consulta2.=" and rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
						$Consulta2.=" and ((year(fecha) < '".$CmbAno."') or (year(fecha) = '".$CmbAno."' and month(fecha) <= '".$CmbMes."'))";
						$RespM=mysqli_query($link, $Consulta2);
						if($FilaM=mysqli_fetch_array($RespM))
						{
							$SiMerma=1;
							$PrvMerma=($FilaM["porc"] * 1);
						}
					}
					if ($SiMerma==1)
						$PorcMerma=str_replace(',','.',$PrvMerma);
						else
						$PorcMerma=str_replace(',','.',$VarMerma);
						
						
					$LeyCu=0;$LeyAg=0;$LeyAu=0;					
					$Consulta = "select * from age_web.detalle_lotes where lote='".$FilaLote["lote"]."' order by lote, lpad(recargo,4,'0')";
					$ContRecargos = 1;
					$RespDetLote=mysqli_query($link, $Consulta);
					while ($FilaDetLote = mysqli_fetch_array($RespDetLote))
					{					
						$PorcHum=0;
						$PesoHumedoRec = $FilaDetLote["peso_neto"];
						$Consulta = "select distinct t1.cod_leyes, t1.valor,t1.valor2, t2.cod_unidad, t2.abreviatura as nom_unidad, t2.conversion, t3.abreviatura as nom_ley,t3.nombre_leyes as nombre_ley ";
						$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
						$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes";
						$Consulta.= " where t1.lote='".$FilaLote["lote"]."' ";
						if ($ContRecargos==1)
							$Consulta.= " and (t1.recargo='".$FilaDetLote["recargo"]."' or t1.recargo='0')";
						else
							$Consulta.= " and t1.recargo='".$FilaDetLote["recargo"]."'";
						$Consulta.= " and t1.cod_leyes in".$LeyesImp;	
						$Consulta.= " order by t1.cod_leyes";
						/*if($FilaLote["lote"]=='06080336')
							echo $Consulta."<br>";*/
						$RespLeyes = mysqli_query($link, $Consulta);
						while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
						{								
							switch ($FilaLeyes["cod_leyes"])
							{
								case "01":
									$PorcHum = $FilaLeyes["valor"]+$PorcMerma;
									break;
								case "02":
									$IncRetalla=0;
									if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
										$IncRetalla = CalcIncRetalla($FilaLote["lote"],"02",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
									$LeyCu = $FilaLeyes["valor"]+$IncRetalla;
									break;
								case "04":
									$IncRetalla=0;
									if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
										$IncRetalla = CalcIncRetalla($FilaLote["lote"],"04",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
									$LeyAg = $FilaLeyes["valor"]+$IncRetalla;
									break;
								case "05":
									$IncRetalla=0;
									if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
										$IncRetalla = CalcIncRetalla($FilaLote["lote"],"05",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
									$LeyAu = $FilaLeyes["valor"]+$IncRetalla;
									break;
								default:
									$ArrLeyesAux[$FilaLeyes["cod_leyes"]][6]=$FilaLeyes["valor"];
									//echo $FilaLeyes["valor"];
									break;	
							}
						}
						if($PorcHum!=0)
						{
							$PesoSecoRec = $PesoHumedoRec - ($PesoHumedoRec*$PorcHum)/100;
							if($Fila01["recepcion"]=='PMN')
								$TotalPesoSecLote=$TotalPesoSecLote+$PesoSecoRec;
							else
								$TotalPesoSecLote=$TotalPesoSecLote+round($PesoSecoRec);
						}	
						else
						{
							$PesoSecoRec=$PesoHumedoRec;
							$TotalPesoSecLote=$TotalPesoSecLote+$PesoSecoRec;
						}	
						$TotalPesoHumLote=$TotalPesoHumLote+$PesoHumedoRec;
						$ContRecargos++;
					}
					$DecPHum=0;$DecPSeco=0;$DecLeyes=3;$DecFinos=0;
					$EsPlamen=false;
					if($Fila01["recepcion"]=='PMN')
					{
						$EsPlamen=true;
						$DecPHum=2;$DecPSeco=3;$DecLeyes=3;$DecFinos=2;
					}
					$PorcHumLote=0;
					if ($TotalPesoHumLote!=0)
						$PorcHumLote = abs(100 - ($TotalPesoSecLote * 100)/$TotalPesoHumLote);
					if($FilaLote["canjeable"]=="S")
					{
						$Consulta = "select distinct t1.lote, t2.cod_leyes, (t2.inc_retalla+t2.ley_canje) as valor, t2.pendiente, ";
						$Consulta.= " (t2.inc_retalla+t2.valor1) as valor1";
						$Consulta.= " from age_web.lotes t1 inner join age_web.leyes_por_lote_canje t2 on t1.lote = t2.lote ";	
						$Consulta.= " where (t1.lote='".$FilaLote["lote"]."' and t1.estado_lote <>'6' ";
						$Consulta.= " and t1.fecha_canje<='".$TxtFechaCon."') ";
						$Consulta.= " or (t1.lote='".$FilaLote["lote"]."' and t1.fecha_fin_canje between '".$TxtFechaIni."' and '".$TxtFechaCon."') ";	
						$Consulta.= " and t2.cod_leyes in('02','04','05')";	
						$Consulta.= " order by t2.cod_leyes";
						$RespLeyesC = mysqli_query($link, $Consulta);
						while($FilaLeyesC = mysqli_fetch_array($RespLeyesC))
						{
							switch ($FilaLeyesC["cod_leyes"])
							{
								case "02":
									$LeyCu = $FilaLeyesC["valor"];
									break;
								case "04":
									$LeyAg = $FilaLeyesC["valor"];
									break;
								case "05":
									$LeyAu = $FilaLeyesC["valor"];
									break;
							}
						}
					}
					$FinoCu=0;$FinoAg=0;$FinoAu=0;
					if($LeyCu!=0)
						$FinoCu=($TotalPesoSecLote * $LeyCu)/100;
					if($LeyAg!=0)	
						$FinoAg=($TotalPesoSecLote * $LeyAg)/1000;
					if($LeyAu!=0)	
						$FinoAu=($TotalPesoSecLote * $LeyAu)/1000;
					reset($ArrLeyesAux);
					foreach($ArrLeyesAux as $c=>$v)
					{   $ArrLeyesAux3 = isset($ArrLeyesAux[$c][3])?$ArrLeyesAux[$c][3]:0;
						$ArrLeyesAux6 = isset($ArrLeyesAux[$c][6])?$ArrLeyesAux[$c][6]:0;
						if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
						{
							$ArrLeyesAux[$c][7]=($TotalPesoSecLote * $ArrLeyesAux6)/$ArrLeyesAux3;							
						}	
					}	
					echo "<td align='right'>".number_format($TotalPesoHumLote,$DecPHum,',','.')."</td>";
					echo "<td align='right'>".number_format($PorcHumLote,2,',','.')."</td>";
					echo "<td align='right'>".number_format($LeyCu,$DecLeyes,',','.')."</td>";
					echo "<td align='right'>".number_format($LeyAg,$DecLeyes,',','.')."</td>";
					echo "<td align='right'>".number_format($LeyAu,$DecLeyes,',','.')."</td>";
					reset($ArrLeyesAux);
					foreach($ArrLeyesAux as $c=>$v)
					{   $ArrLeyesAux6 = isset($ArrLeyesAux[$c][6])?$ArrLeyesAux[$c][6]:0;
						if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
						{
							echo "<td align='right'>".number_format((float)$ArrLeyesAux6,$DecLeyes,',','.')."</td>";
							$ArrLeyesAux[$c][6]=0;
						}
							
					}	
					echo "<td align='right'>".number_format($TotalPesoSecLote,$DecPSeco,',','.')."</td>";
					echo "<td align='right'>".number_format($FinoCu,$DecFinos,',','.')."</td>";
					echo "<td align='right'>".number_format($FinoAg,$DecFinos,',','.')."</td>";
					echo "<td align='right'>".number_format($FinoAu,$DecFinos,',','.')."</td>";
					reset($ArrLeyesAux);
					foreach($ArrLeyesAux as $c=>$v)
					{   $ArrLeyesAux7 = isset($ArrLeyesAux[$c][7])?$ArrLeyesAux[$c][7]:0;
					    $ArrLeyesPrv3 = isset($ArrLeyesPrv[$c][3])?$ArrLeyesPrv[$c][3]:0;
						if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
						{
							echo "<td align='right'>".number_format((float)$ArrLeyesAux7,$DecFinos,',','.')."</td>";
							$ArrLeyesPrv[$c][3]=$ArrLeyesPrv3+$ArrLeyesAux7;
							$ArrLeyesAux[$c][7]=0;
						}	
					}
					$ValorDed=0;$ValorFP=0;$Dec=0;
					$Resp = CalculaDeduccionMet($FilaAux["cod_recepcion"],$FilaLote["cod_producto"],$FilaLote["cod_subproducto"],"02",$FilaAux["rut_proveedor"],$TotalPesoSecLote,$LeyCu,$FinoCu,$ValorDed,$ValorFP,$Dec,$link);					
					$val      = explode("**",$Resp);
					$ValorDed = $val[0];
					echo "<td align='right'>".number_format($ValorDed,$Dec,',','.')."</td>";
					$TotalDeducCuPrv=$TotalDeducCuPrv+round($ValorDed);
					$Resp = CalculaDeduccionMet($FilaAux["cod_recepcion"],$FilaLote["cod_producto"],$FilaLote["cod_subproducto"],"04",$FilaAux["rut_proveedor"],$TotalPesoSecLote,$LeyAg,$FinoAg,$ValorDed,$ValorFP,$Dec,$link);					
					$val      = explode("**",$Resp);
					$ValorDed = $val[0];
					echo "<td align='right'>".number_format($ValorDed,$Dec,',','.')."</td>";
					$TotalDeducAgPrv=$TotalDeducAgPrv+round($ValorDed);
					$Resp = CalculaDeduccionMet($FilaAux["cod_recepcion"],$FilaLote["cod_producto"],$FilaLote["cod_subproducto"],"05",$FilaAux["rut_proveedor"],$TotalPesoSecLote,$LeyAu,$FinoAu,$ValorDed,$ValorFP,$Dec,$link);									
					$val      = explode("**",$Resp);
					$ValorDed = $val[0];
					echo "<td align='right'>".number_format($ValorDed,$Dec,',','.')."</td>";
					$TotalDeducAuPrv=$TotalDeducAuPrv+round($ValorDed);
					$Resp = CalculaDeduccionMet($FilaAux["cod_recepcion"],$FilaLote["cod_producto"],$FilaLote["cod_subproducto"],"02",$FilaAux["rut_proveedor"],$TotalPesoSecLote,$LeyCu,$FinoCu,$ValorDed,$ValorFP,$Dec,$link);					
					$val      = explode("**",$Resp);
					$ValorFP = $val[1];
					echo "<td align='right'>".number_format($ValorFP,$Dec,',','.')."</td>";
					$TotalFPCuPrv=$TotalFPCuPrv+round($ValorFP);
					$Resp = CalculaDeduccionMet($FilaAux["cod_recepcion"],$FilaLote["cod_producto"],$FilaLote["cod_subproducto"],"04",$FilaAux["rut_proveedor"],$TotalPesoSecLote,$LeyAg,$FinoAg,$ValorDed,$ValorFP,$Dec,$link);					
					$val      = explode("**",$Resp);
					$ValorFP = $val[1];
					echo "<td align='right'>".number_format($ValorFP,$Dec,',','.')."</td>";
					$TotalFPAgPrv=$TotalFPAgPrv+round($ValorFP);
					$Resp = CalculaDeduccionMet($FilaAux["cod_recepcion"],$FilaLote["cod_producto"],$FilaLote["cod_subproducto"],"05",$FilaAux["rut_proveedor"],$TotalPesoSecLote,$LeyAu,$FinoAu,$ValorDed,$ValorFP,$Dec,$link);					
					$val      = explode("**",$Resp);
					$ValorFP = $val[1];
					echo "<td align='right'>".number_format($ValorFP,$Dec,',','.')."</td>";
					$TotalFPAuPrv=$TotalFPAuPrv+round($ValorFP);
					echo "</tr>";
					$TotalPesoHumPrv=$TotalPesoHumPrv+$TotalPesoHumLote;
					$TotalPesoSecPrv=$TotalPesoSecPrv+$TotalPesoSecLote;
					if($EsPlamen==true)
					{
						$TotalFinoCuPrv=$TotalFinoCuPrv+$FinoCu;
						$TotalFinoAgPrv=$TotalFinoAgPrv+$FinoAg;
						$TotalFinoAuPrv=$TotalFinoAuPrv+$FinoAu;
					}
					else
					{
						$TotalFinoCuPrv=$TotalFinoCuPrv+round($FinoCu);
						$TotalFinoAgPrv=$TotalFinoAgPrv+round($FinoAg);
						$TotalFinoAuPrv=$TotalFinoAuPrv+round($FinoAu);
					}	
					$TotalPesoHumLote=0;$TotalPesoSecLote=0;
				}
				//TOTAL PROVEEDOR
				$DecPHum=0;$DecPSeco=0;$DecLeyes=3;$DecFinos=0;
				if($EsPlamen==true)
				{
					$DecPHum=2;$DecPSeco=3;$DecLeyes=3;$DecFinos=2;
				}
				$PorcHumPrv=0;
				if ($TotalPesoHumPrv!='0')
					$PorcHumPrv=100-($TotalPesoSecPrv*100)/$TotalPesoHumPrv;
				$LeyCuPrv=0;$LeyAgPrv=0;$LeyAuPrv=0;	
				if ($TotalPesoSecPrv!='0')
				{	
					$LeyCuPrv=($TotalFinoCuPrv*100)/$TotalPesoSecPrv;
					$LeyAgPrv=($TotalFinoAgPrv*1000)/$TotalPesoSecPrv;
					$LeyAuPrv=($TotalFinoAuPrv*1000)/$TotalPesoSecPrv;
				}
				reset($ArrLeyesPrv);
				foreach($ArrLeyesPrv as $c=>$v)
				{   $ArrLeyesPrv1 = isset($ArrLeyesPrv[$c][1])?$ArrLeyesPrv[$c][1]:0;
				    $ArrLeyesPrv3 = isset($ArrLeyesPrv[$c][3])?$ArrLeyesPrv[$c][3]:0;
					if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
						$ArrLeyesPrv[$c][2]=($ArrLeyesPrv3*$ArrLeyesPrv1)/$TotalPesoSecPrv;
				}	
				echo "<tr class=\"Detalle01\">\n";
				echo "<td align=\"left\" colspan=\"2\">TOTAL ".$FilaAux["rut_proveedor"]."</td>";
				echo "<td align='right'>".number_format($TotalPesoHumPrv,$DecPHum,',','.')."</td>";
				echo "<td align='right'>".number_format($PorcHumPrv,2,',','.')."</td>";
				echo "<td align='right'>".number_format($LeyCuPrv,$DecLeyes,',','.')."</td>";
				echo "<td align='right'>".number_format($LeyAgPrv,$DecLeyes,',','.')."</td>";
				echo "<td align='right'>".number_format($LeyAuPrv,$DecLeyes,',','.')."</td>";
				reset($ArrLeyesPrv);
				foreach($ArrLeyesPrv as $c=>$v)
				{   $ArrLeyesPrv2 = isset($ArrLeyesPrv[$c][2])?$ArrLeyesPrv[$c][2]:0;
					if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
					{
						echo "<td align='right'>".number_format((float)$ArrLeyesPrv2,$DecLeyes,',','.')."</td>";
						$ArrLeyesPrv[$c][2]=0;
					}
				}	
				echo "<td align='right'>".number_format($TotalPesoSecPrv,$DecPSeco,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalFinoCuPrv,$DecFinos,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalFinoAgPrv,$DecFinos,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalFinoAuPrv,$DecFinos,',','.')."</td>";
				reset($ArrLeyesPrv);
				foreach($ArrLeyesPrv as $c=>$v)
				{   $ArrLeyesPrv3 = isset($ArrLeyesPrv[$c][3])?$ArrLeyesPrv[$c][3]:0;
					$ArrLeyesAsig3 = isset($ArrLeyesAsig[$c][3])?$ArrLeyesAsig[$c][3]:0;
					if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
					{
						echo "<td align='right'>".number_format((float)$ArrLeyesPrv3,$DecFinos,',','.')."</td>";
						$ArrLeyesAsig[$c][3]=$ArrLeyesAsig3+$ArrLeyesPrv3;
						$ArrLeyesPrv[$c][3]=0;
					}	
				}
				echo "<td align='right'>".number_format($TotalDeducCuPrv,0,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalDeducAgPrv,0,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalDeducAuPrv,0,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalFPCuPrv,0,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalFPAgPrv,0,',','.')."</td>";
				echo "<td align='right'>".number_format($TotalFPAuPrv,0,',','.')."</td>";
				echo "</tr>\n";
				echo "<tr><td colspan='$ColSpan'>&nbsp;</td></tr>";
				$TotalPesoHumAsig=$TotalPesoHumAsig+$TotalPesoHumPrv;
				$TotalPesoSecAsig=$TotalPesoSecAsig+$TotalPesoSecPrv;
				if($EsPlamen==true)
				{
					$TotalFinoCuAsig=$TotalFinoCuAsig+$TotalFinoCuPrv;
					$TotalFinoAgAsig=$TotalFinoAgAsig+$TotalFinoAgPrv;
					$TotalFinoAuAsig=$TotalFinoAuAsig+$TotalFinoAuPrv;
				}
				else
				{
					$TotalFinoCuAsig=$TotalFinoCuAsig+round($TotalFinoCuPrv);
					$TotalFinoAgAsig=$TotalFinoAgAsig+round($TotalFinoAgPrv);
					$TotalFinoAuAsig=$TotalFinoAuAsig+round($TotalFinoAuPrv);
				}
				$TotalDeducCuAsig=$TotalDeducCuAsig+round($TotalDeducCuPrv);
				$TotalDeducAgAsig=$TotalDeducAgAsig+round($TotalDeducAgPrv);
				$TotalDeducAuAsig=$TotalDeducAuAsig+round($TotalDeducAuPrv);
				$TotalFPCuAsig=$TotalFPCuAsig+round($TotalFPCuPrv);
				$TotalFPAgAsig=$TotalFPAgAsig+round($TotalFPAgPrv);
				$TotalFPAuAsig=$TotalFPAuAsig+round($TotalFPAuPrv);
				//$TotalPesoHumPrv=0;$TotalPesoSecPrv=0;$TotalFinoCuPrv=0;$TotalFinoAgPrv=0;$TotalFinoAuPrv=0;$TotalDeducCuPrv=0;$TotalDeducAgPrv=0;$TotalDeducAuPrv=0;$TotalFPCuPrv=0;$TotalFPAgPrv=0;$TotalFPAuPrv=0;
			}
			//TOTAL TIPO RECEPCION
			$DecPHum=0;$DecPSeco=0;$DecLeyes=3;$DecFinos=0;
			if($EsPlamen==true)
			{
				$DecPHum=2;$DecPSeco=3;$DecLeyes=3;$DecFinos=2;
			}
			if($TotalPesoHumAsig !=0)
				$PorcHumAsig=100-($TotalPesoSecAsig*100)/$TotalPesoHumAsig;
			$LeyCuAsig=($TotalFinoCuAsig*100)/$TotalPesoSecAsig;
			$LeyAgAsig=($TotalFinoAgAsig*1000)/$TotalPesoSecAsig;
			$LeyAuAsig=($TotalFinoAuAsig*1000)/$TotalPesoSecAsig;
			reset($ArrLeyesAsig);
			foreach($ArrLeyesAsig as $c=>$v)
			{   $ArrLeyesAsig1 = isset($ArrLeyesAsig[$c][1])?$ArrLeyesAsig[$c][1]:0;
				$ArrLeyesAsig3 = isset($ArrLeyesAsig[$c][3])?$ArrLeyesAsig[$c][3]:0;
				if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
					$ArrLeyesAsig[$c][2]=($ArrLeyesAsig3*$ArrLeyesAsig1)/$TotalPesoSecAsig;
					
			}	
			echo "<tr bgcolor=\"#CCCCCC\">";
			echo "<td align=\"left\" colspan=\"2\">TOTAL&nbsp;".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
			echo "<td align='right'>".number_format($TotalPesoHumAsig,$DecPHum,',','.')."</td>";
			echo "<td align='right'>".number_format($PorcHumAsig,2,',','.')."</td>";
			echo "<td align='right'>".number_format($LeyCuAsig,$DecLeyes,',','.')."</td>";
			echo "<td align='right'>".number_format($LeyAgAsig,$DecLeyes,',','.')."</td>";
			echo "<td align='right'>".number_format($LeyAuAsig,$DecLeyes,',','.')."</td>";
			reset($ArrLeyesAsig);
			foreach($ArrLeyesAsig as $c=>$v)
			{   $ArrLeyesAsig2 = isset($ArrLeyesAsig[$c][2])?$ArrLeyesAsig[$c][2]:0;
				if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
				{
					echo "<td align='right'>".number_format((float)$ArrLeyesAsig2,$DecLeyes,',','.')."</td>";
					$ArrLeyesAsig[$c][2]=0;
				}
					
			}	
			echo "<td align='right'>".number_format($TotalPesoSecAsig,$DecPSeco,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalFinoCuAsig,$DecFinos,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalFinoAgAsig,$DecFinos,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalFinoAuAsig,$DecFinos,',','.')."</td>";
			reset($ArrLeyesAsig);
			foreach($ArrLeyesAsig as $c=>$v)
			{   $ArrLeyesAsig3 = isset($ArrLeyesAsig[$c][3])?$ArrLeyesAsig[$c][3]:0;
			    $ArrLeyesProd3 = isset($ArrLeyesProd[$c][3])?$ArrLeyesProd[$c][3]:0;
				if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
				{
					echo "<td align='right'>".number_format((float)$ArrLeyesAsig3,$DecFinos,',','.')."</td>";
					$ArrLeyesProd[$c][3]=$ArrLeyesProd3+$ArrLeyesAsig3;
					$ArrLeyesAsig[$c][3]=0;
				}	
			}
			echo "<td align='right'>".number_format($TotalDeducCuAsig,$DecFinos,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalDeducAgAsig,$DecFinos,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalDeducAuAsig,$DecFinos,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalFPCuAsig,$DecFinos,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalFPAgAsig,$DecFinos,',','.')."</td>";
			echo "<td align='right'>".number_format($TotalFPAuAsig,$DecFinos,',','.')."</td>";
			echo "</tr>\n";
			$TotalPesoHumProd=$TotalPesoHumProd+$TotalPesoHumAsig;
			$TotalPesoSecProd=$TotalPesoSecProd+$TotalPesoSecAsig;
			if($EsPlamen==true)
			{
				$TotalFinoCuProd=$TotalFinoCuProd+$TotalFinoCuAsig;
				$TotalFinoAgProd=$TotalFinoAgProd+$TotalFinoAgAsig;
				$TotalFinoAuProd=$TotalFinoAuProd+$TotalFinoAuAsig;
			}
			else
			{
				$TotalFinoCuProd=$TotalFinoCuProd+round($TotalFinoCuAsig);
				$TotalFinoAgProd=$TotalFinoAgProd+round($TotalFinoAgAsig);
				$TotalFinoAuProd=$TotalFinoAuProd+round($TotalFinoAuAsig);
			}
			$TotalDeducCuProd=$TotalDeducCuProd+round($TotalDeducCuAsig);
			$TotalDeducAgProd=$TotalDeducAgProd+round($TotalDeducAgAsig);
			$TotalDeducAuProd=$TotalDeducAuProd+round($TotalDeducAuAsig);
			$TotalFPCuProd=$TotalFPCuProd+round($TotalFPCuAsig);
			$TotalFPAgProd=$TotalFPAgProd+round($TotalFPAgAsig);
			$TotalFPAuProd=$TotalFPAuProd+round($TotalFPAuAsig);
			/*
			$TotalPesoHumAsig=0;$TotalPesoSecAsig=0;$TotalFinoCuAsig=0;$TotalFinoAgAsig=0;$TotalFinoAuAsig=0;
			$TotalDeducCuAsig=0;$TotalDeducAgAsig=0;$TotalDeducAuAsig=0;$TotalFPCuAsig=0;$TotalFPAgAsig=0;$TotalFPAuAsig=0;	
			*/			
		}//FIN TIPO RECEPCION
		//TOTAL PRODUCTO
		$DecPHum=0;$DecPSeco=0;$DecLeyes=3;$DecFinos=0;
		if($EsPlamen==true)
		{
			$DecPHum=2;$DecPSeco=3;$DecLeyes=3;$DecFinos=2;
		}
		if($TotalPesoHumProd <>0)
			$PorcHumProd=100-($TotalPesoSecProd*100)/$TotalPesoHumProd;
		$LeyCuProd=($TotalFinoCuProd*100)/$TotalPesoSecProd;
		$LeyAgProd=($TotalFinoAgProd*1000)/$TotalPesoSecProd;
		$LeyAuProd=($TotalFinoAuProd*1000)/$TotalPesoSecProd;
		reset($ArrLeyesProd);
		foreach($ArrLeyesProd as $c=>$v)
		{   $ArrLeyesProd1 = isset($ArrLeyesProd[$c][1])?$ArrLeyesProd[$c][1]:0;
		    $ArrLeyesProd3 = isset($ArrLeyesProd[$c][3])?$ArrLeyesProd[$c][3]:0;
			if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
				$ArrLeyesProd[$c][2]=($ArrLeyesProd3*$ArrLeyesProd1)/$TotalPesoSecProd;
		}	
		echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\">";
		echo "<td align=\"left\" colspan=\"2\">TOTAL: ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($NomSubProd)."</td>\n";
		echo "<td align='right'>".number_format($TotalPesoHumProd,$DecPHum,',','.')."</td>";
		echo "<td align='right'>".number_format($PorcHumProd,2,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyCuProd,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyAgProd,$DecLeyes,',','.')."</td>";
		echo "<td align='right'>".number_format($LeyAuProd,$DecLeyes,',','.')."</td>";
		reset($ArrLeyesProd);
		foreach($ArrLeyesProd as $c=>$v)
		{   $ArrLeyesProd2 = isset($ArrLeyesProd[$c][2])?$ArrLeyesProd[$c][2]:0;
			if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
				echo "<td align='right'>".number_format((float)$ArrLeyesProd2,$DecLeyes,',','.')."</td>";
		}	
		echo "<td align='right'>".number_format($TotalPesoSecProd,$DecPSeco,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoCuProd,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoAgProd,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFinoAuProd,$DecFinos,',','.')."</td>";
		reset($ArrLeyesProd);
		foreach($ArrLeyesProd as $c=>$v)
		{   $ArrLeyesProd3 = isset($ArrLeyesProd[$c][3])?$ArrLeyesProd[$c][3]:0;
			$ArrLeyesTot3  = isset($ArrLeyesTot[$c][3])?$ArrLeyesTot[$c][3]:0;
			if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
			{
				echo "<td align='right'>".number_format((float)$ArrLeyesProd3,$DecFinos,',','.')."</td>";
				$ArrLeyesTot[$c][3]=$ArrLeyesTot3+$ArrLeyesProd3;
				$ArrLeyesProd[$c][2]=0;
				$ArrLeyesProd[$c][3]=0;
			}	
		}
		echo "<td align='right'>".number_format($TotalDeducCuProd,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalDeducAgProd,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalDeducAuProd,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFPCuProd,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFPAgProd,$DecFinos,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalFPAuProd,$DecFinos,',','.')."</td>";
		echo "</tr>\n";
		$TotalPesoHumTot=$TotalPesoHumTot+$TotalPesoHumProd;
		$TotalPesoSecTot=$TotalPesoSecTot+$TotalPesoSecProd;
		if($EsPlamen==true)
		{
			$TotalFinoCuTot=$TotalFinoCuTot+$TotalFinoCuProd;
			$TotalFinoAgTot=$TotalFinoAgTot+$TotalFinoAgProd;
			$TotalFinoAuTot=$TotalFinoAuTot+$TotalFinoAuProd;
		}
		else
		{
			$TotalFinoCuTot=$TotalFinoCuTot+round($TotalFinoCuProd);
			$TotalFinoAgTot=$TotalFinoAgTot+round($TotalFinoAgProd);
			$TotalFinoAuTot=$TotalFinoAuTot+round($TotalFinoAuProd);
		}
		/*
		$TotalPesoHumProd=0;$TotalPesoSecProd=0;$TotalFinoCuProd=0;$TotalFinoAgProd=0;$TotalFinoAuProd=0;
		$TotalDeducCuProd=0;$TotalDeducAgProd=0;$TotalDeducAuProd=0;$TotalFPCuProd=0;$TotalFPAgProd=0;$TotalFPAuProd=0;
		*/
}	
	//TOTAL
	$DecPHum=0;$DecPSeco=0;$DecLeyes=3;$DecFinos=0;
	if($TotalPesoHumTot <> 0)
		$PorcHumTot=100-($TotalPesoSecTot*100)/$TotalPesoHumTot;
	$LeyCuTot=($TotalFinoCuTot*100)/$TotalPesoSecTot;
	$LeyAgTot=($TotalFinoAgTot*1000)/$TotalPesoSecTot;
	$LeyAuTot=($TotalFinoAuTot*1000)/$TotalPesoSecTot;
	reset($ArrLeyesTot);
	foreach($ArrLeyesTot as $c=>$v)
	{   $ArrLeyesTot1  = isset($ArrLeyesTot[$c][1])?$ArrLeyesTot[$c][1]:0;
	    $ArrLeyesTot3  = isset($ArrLeyesTot[$c][3])?$ArrLeyesTot[$c][3]:0;
		if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
			$ArrLeyesTot[$c][2]=($ArrLeyesTot3*$ArrLeyesTot1)/$TotalPesoSecTot;
	}	
	echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\">";
	echo "<td align=\"left\" colspan=\"2\">TOTAL:</td>\n";
	echo "<td align='right'>".number_format($TotalPesoHumTot,0,',','.')."</td>";
	echo "<td align='right'>".number_format($PorcHumTot,2,',','.')."</td>";
	echo "<td align='right'>".number_format($LeyCuTot,$DecLeyes,',','.')."</td>";
	echo "<td align='right'>".number_format($LeyAgTot,$DecLeyes,',','.')."</td>";
	echo "<td align='right'>".number_format($LeyAuTot,$DecLeyes,',','.')."</td>";
	reset($ArrLeyesTot);
	foreach($ArrLeyesTot as $c=>$v)
	{   $ArrLeyesTot2  = isset($ArrLeyesTot[$c][2])?$ArrLeyesTot[$c][2]:0;
		if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
			echo "<td align='right'>".number_format((float)$ArrLeyesTot2,$DecLeyes,',','.')."</td>";
	}	
	echo "<td align='right'>".number_format($TotalPesoSecTot,$DecPSeco,',','.')."</td>";
	echo "<td align='right'>".number_format($TotalFinoCuTot,$DecFinos,',','.')."</td>";
	echo "<td align='right'>".number_format($TotalFinoAgTot,$DecFinos,',','.')."</td>";
	echo "<td align='right'>".number_format($TotalFinoAuTot,$DecFinos,',','.')."</td>";
	reset($ArrLeyesTot);
	foreach($ArrLeyesTot as $c=>$v)
	{   $ArrLeyesTot3  = isset($ArrLeyesTot[$c][3])?$ArrLeyesTot[$c][3]:0;
		if($c!='01'&&$c!='02'&&$c!='04'&&$c!='05')
			echo "<td align='right'>".number_format((float)$ArrLeyesTot3,$DecFinos,',','.')."</td>";
	}	
	echo "</tr>\n";
echo "</table>\n";

function CalculaDeduccionMet($CodRecepcion,$CodProd,$CodSubProd,$CodLey,$RutProv,$PSeco,$ValorLey,$ValorFino,$ValorDed,$ValorFP,$Dec,$link)
{
	switch($CodLey)
	{
		case "02":
			$Divisor=100;
			break;
		case "04":
		case "05":
			$Divisor=1000;
			break;
	}
	$ValorDed=0;$ValorFP=0;$Dec=0;
	/*$Consulta="select * from age_web.deduc_metalurgicas where cod_recepcion='$CodRecepcion' and cod_producto='$CodProd' ";
	$Consulta.="and cod_subproducto='$CodSubProd' and cod_leyes='$CodLey' ";
	if($CodRecepcion!='MAQ ENM' && $CodRecepcion!='PERMUTA')
		$Consulta.=" and rut_proveedor='$RutProv'";
	else	
		$Consulta.=" and rut_proveedor='T'";*/
	$SiProvee="T";
	$Consulta="select * from age_web.deduc_metalurgicas where cod_recepcion='$CodRecepcion' and cod_producto='$CodProd' ";
	$Consulta.="and cod_subproducto='$CodSubProd' and cod_leyes='$CodLey' ";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Resp))
	{
		if($Fila["rut_proveedor"]==$RutProv)
		{
			$SiProvee = $RutProv;
		}
	}
	$Consulta="select * from age_web.deduc_metalurgicas where cod_recepcion='$CodRecepcion' and cod_producto='$CodProd' ";
	$Consulta.="and cod_subproducto='$CodSubProd' and cod_leyes='$CodLey' ";
	$Consulta.=" and rut_proveedor='".$SiProvee."'";
	$RespDeduc=mysqli_query($link, $Consulta);
	//echo $Consulta;	
	if($FilaDeduc=mysqli_fetch_array($RespDeduc))
	{
		$ValorLey=abs(doubleval($ValorLey));
		$Valor1=abs(doubleval($FilaDeduc["valor1"]));
		$Valor2=abs(doubleval($FilaDeduc["valor2"]));
		$Valor3=abs(doubleval($FilaDeduc["valor3"]));
		$Valor4=abs(doubleval($FilaDeduc["valor4"]));
		$TipoForm=abs(doubleval($FilaDeduc["tipo_formula"]));
		//echo $TipoForm."<br>";
		switch($FilaDeduc["cant_param"])
		{
			case "1":
				switch($TipoForm)
				{	
					case '1':
						//echo $ValorFino."<br>";
						//echo $Valor1."<br>";
						$ValorDed=round($ValorFino*$Valor1);
						//echo $ValorDed."<br><br>";
						$ValorFP=round($ValorFino)-round($ValorDed);
						break;
					case '2':
						/*if($CodLey=='02')
						{
							$ValorDed=$ValorFino*$Valor1/$Divisor;
							$ValorFP=$ValorDed;
						}	
						else
						{*/
							$ValorDed=$PSeco*$Valor1/$Divisor;
							$ValorFP=round($ValorFino)-round($ValorDed);
						//}
						if($CodLey=='02'||$CodLey=='05')	
							$Dec=$FilaDeduc["decimales"];
						break;
					case '3':
						if($CodLey=='02')
							$ValorDed=$ValorFino*$Valor1/$Divisor;
						else
							$ValorDed=$ValorFino*$Valor1;
						$ValorFP=round($ValorFino)-round($ValorDed);
						if($CodLey=='02'||$CodLey=='05')	
							$Dec=$FilaDeduc["decimales"];
						break;							
					default:
						$ValorDed=$ValorFino*$Valor1/$Divisor;
						$ValorFP=$ValorDed;
						$Dec=$FilaDeduc["decimales"];
						break;	
				}	
				//$ValorDed=round($ValorDed);	
				break;
			case "2":
				if($ValorLey<=$Valor1)
					$ValorDed=$ValorFino;
				else
					$ValorDed=($PSeco*$Valor2)/$Divisor;
				$ValorFP=round($ValorFino)-round($ValorDed);
				$ValorDed=round($ValorDed);	
				break;
			case "3":
				/*echo $ValorLey."<br>";
				echo $ValorFino."<br>";
				echo $PSeco."<br>";
				echo $Valor1."<br>";
				echo $FilaDeduc["valor2"]."<br>";
				echo $FilaDeduc["valor3"]."<br><br>";*/
				if($ValorLey<=$Valor1)
					$ValorDed=$ValorFino;
				else
					if($ValorLey<=$Valor2)
						$ValorDed=($PSeco*1)/$Divisor;
					else
						$ValorDed=($ValorFino*$Valor3)/$Divisor;
				$ValorFP=round($ValorFino)-round($ValorDed);
				$ValorDed=round($ValorDed);	
				break;
			case "4":
				if($ValorLey<=$Valor1)
					$ValorDed=$ValorFino;
				else
					if($ValorLey<=$Valor2)
						$ValorDed=($PSeco*$Valor3)/$Divisor;
					else
						$ValorDed=($ValorFino*$Valor4)/$Divisor;
				$ValorFP=round($ValorFino)-round($ValorDed);
				$ValorDed=round($ValorDed);	
				break;
		}	
	}
	$valores = $ValorDed."**".$ValorFP;
	return $valores;
}
?>  
</form>
</body>
</html>