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
<title>AGE-Resumen Pesos</title>
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
			f.action = "age_con_resumen_pesos.php";
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
        DIVISION VENTANAS    V-1   <br> </td>
      <td width="296" align="right">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><strong><u>RESUMEN DE PESO HUMEDO Y PESO SECO </u></strong></td>
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
	$Anito = substr($TxtFechaIni,0,4);
	$Mesi =  substr($TxtFechaIni,5,2);
	$ColSpan=4;
	$FechaMer=$Anito.str_pad($Mesi,2,"0",STR_PAD_LEFT);
	echo "<table width=\"500\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
	$Consulta = "select STRAIGHT_JOIN distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,4,'0') as orden ,recepcion ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
	if ($CmbRecepcion != "S")
		$Consulta.= " and t1.cod_recepcion = '".$CmbRecepcion."' ";
	if ($CmbSubProducto != "S")
	{
		$Consulta.= " and t1.cod_producto = '1' ";
		$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
	}
	if ($CmbProveedor != "S")
		$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
	$Consulta.= " order by t1.cod_producto, orden ";
	//echo "uno".$Consulta."<br>";
	$Resp01 = mysqli_query($link, $Consulta);
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
		switch ($OptVer)
		{
			case "P":
				echo "<td align=\"center\" width=\"300\">Proveedor</td>\n";
				break;
			case "L":
				echo "<td align=\"center\" width=\"200\">Lote</td>\n";
				break;
		}		
		echo "<td align=\"center\" width=\"80\">P.Hum.<br>(Kg)</td>\n";
		echo "<td align=\"center\" width=\"80\">Hum<br>(%)</td>\n";	
		echo "<td align=\"center\" width=\"80\">P.Seco<br>(Kg)</td>\n";
		echo "</tr>\n";
		//CONSULTA LOS TIPOS DE RECEPCION
		$Consulta = "select STRAIGHT_JOIN distinct t1.cod_recepcion, t3.nombre_subclase as desc_a";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase ='3104' and t1.cod_recepcion=t3.nombre_subclase ";
		$Consulta.= " where t1.lote<>'' ";
		$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
		if ($CmbRecepcion != "S")
			$Consulta.= " and t1.cod_recepcion = '".$CmbRecepcion."' ";
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		$Consulta.= " order by t1.cod_recepcion ";
		//echo "dos".$Consulta."<br>";
		$RespTipoRecep = mysqli_query($link, $Consulta);
		while ($FilaTipoRecep = mysqli_fetch_array($RespTipoRecep))
		{					
			//TITULO COD RECEPCION
			echo "<tr bgcolor=\"#CCCCCC\">\n";	
			if ($FilaTipoRecep["desc_a"] == "" || is_null($FilaTipoRecep["desc_a"]))
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">&nbsp;</td>\n";				
			else
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";		
			echo "</tr>\n";
			//CONSULTA LOS PROVEEDOR DE UN PRODUCTO Y UN TIPO DE RECEPCION
			$Consulta = "select STRAIGHT_JOIN distinct t1.rut_proveedor, t1.cod_recepcion  ";
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
			//echo "tres".$Consulta."<br>";
			$RutPrv='';
			$RespAux = mysqli_query($link, $Consulta);
			while ($FilaAux = mysqli_fetch_array($RespAux))
			{		
				$Datos = explode("-",$FilaAux["rut_proveedor"]);
				//$RutAux = ($Datos[0]*1)."-".$Datos[1];
				$RutAux = $FilaAux["rut_proveedor"];
				$NomProveedor = "";
				$Consulta = "select * ";
				$Consulta.= " from rec_web.proved ";
				$Consulta.= " where rutprv_a = '".$RutAux."'";
				$RespProv = mysqli_query($link, $Consulta);	
				//echo $Consulta."<br>";
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$NomProveedor = $FilaProv["NOMPRV_A"];
				}		
				if ($OptVer=="L")
				{					
					echo "<tr class=\"Detalle01\">\n";
					echo "<td align=\"left\" colspan=\"".$ColSpan."\">".$FilaAux["rut_proveedor"]."&nbsp;&nbsp;".substr(strtoupper($NomProveedor),0,30)."</td>\n";
					echo "</tr>\n";				
				}
				$Consulta = "select STRAIGHT_JOIN  distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
				$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion ";		
				$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
				$Consulta.= " on t1.lote = t2.lote ";			
				$Consulta.= " where t1.cod_producto = '".$Fila01["cod_producto"]."' ";
				$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
				$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
				$Consulta.= " and t1.rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
				$Consulta.= " and t1.cod_recepcion = '".$FilaAux["cod_recepcion"]."' ";					
				$Consulta.= " and t1.estado_lote <>'6' group by t1.lote order by t1.lote, orden";
				$RespLote = mysqli_query($link, $Consulta);
				//echo "cuatro".$Consulta."<br>";
				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					$TotalPesoSecLote=0;$TotalPesoHumLote=0;
					$PorcMerma=0;$SiMerma=0;$VarMerma=0;$PrvMerma=0;
					$Consulta = "select * from age_web.mermas ";
					$Consulta.= " where cod_producto='".$Fila01["cod_producto"]."' ";
					$Consulta.= " and cod_subproducto='".$Fila01["cod_subproducto"]."' ";
					$Consulta.=" and ((year(fecha) < '".$Anito."') or (year(fecha) = '".$Anito."' and month(fecha) <= '".$Mesi."'))";
					$Consulta.=" order by cod_producto,cod_subproducto,rut_proveedor";
					$RespMerma=mysqli_query($link, $Consulta);					
					while ($FilaMerma=mysqli_fetch_array($RespMerma))
					{
						if ($FilaMerma["rut_proveedor"]=="")
						{
								$VarMerma=($FilaMerma["porc"] * 1);
						}
						$Consulta2 = "select * from age_web.mermas ";
						$Consulta2.= " where cod_producto='".$Fila01["cod_producto"]."' ";
						$Consulta2.= " and cod_subproducto='".$Fila01["cod_subproducto"]."' ";
						$Consulta2.=" and rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
						$Consulta2.=" and ((year(fecha) < '".$Anito."') or (year(fecha) = '".$Anito."' and month(fecha) <= '".$Mesi."'))";
						$RespM=mysqli_query($link, $Consulta2);					
						if($FilaM=mysqli_fetch_array($RespM))
						{
							$SiMerma = 1;
							$PrvMerma= ($FilaM["porc"] * 1);
						}
					}
					if($SiMerma==1)
					{
						$PorcMerma=str_replace(',','.',$PrvMerma);
					} 
					else
					{
						$PorcMerma=str_replace(',','.',$VarMerma);
					}
										

					$LeyCu=0;$LeyAg=0;$LeyAu=0;$LeyCuOri=0;$LeyAgOri=0;$LeyAuOri=0;$LeyCuAj=0;$LeyAgAj=0;$LeyAuAj=0;						
					$Consulta = "select * from age_web.detalle_lotes where lote='".$FilaLote["lote"]."' ";
					$Consulta.= " and fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' order by lote, lpad(recargo,4,'0')";
					$ContRecargos = 1;
					//echo "nnnn".$Consulta."<br>";;
					$RespDetLote=mysqli_query($link, $Consulta);
					while ($FilaDetLote = mysqli_fetch_array($RespDetLote))
					{					
						$PorcHum=0;
						$PesoHumedoRec = $FilaDetLote["peso_neto"];
						$Consulta = "select STRAIGHT_JOIN distinct t1.cod_leyes, t1.valor,t1.valor2, t2.cod_unidad, t2.abreviatura as nom_unidad, t2.conversion, t3.abreviatura as nom_ley,t3.nombre_leyes as nombre_ley ";
						$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
						$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes";
						$Consulta.= " where t1.lote='".$FilaLote["lote"]."' ";
						if ($ContRecargos==1)
							$Consulta.= " and (t1.recargo='".$FilaDetLote["recargo"]."' or t1.recargo='0')";
						else
							$Consulta.= " and t1.recargo='".$FilaDetLote["recargo"]."'";
						$Consulta.= " and t1.cod_leyes in('01')";	
						$Consulta.= " order by t1.cod_leyes";
						//echo "cinco".$Consulta."</br>";
						$RespLeyes = mysqli_query($link, $Consulta);
						while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
						{								
							switch ($FilaLeyes["cod_leyes"])
							{
								case "01":
									$PorcHum = $FilaLeyes["valor"]+$PorcMerma;
									break;
							}
						}
						if($PorcHum!=0)
						{
							$PesoSecoRec = $PesoHumedoRec - ($PesoHumedoRec*$PorcHum)/100;
							//echo $PesoSecoRec."<br>";
							//$TotalPesoSecLote=$TotalPesoSecLote+round($PesoSecoRec);
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
					$DecPHum=0;$DecPSeco=0;
					$EsPlamen=false;
					if($Fila01["recepcion"]=='PMN')
					{
						$EsPlamen=true;
						$DecPHum=4;$DecPSeco=4;
					}
					$PorcHumLote=0;
					if ($TotalPesoHumLote!=0)
						$PorcHumLote = abs(100 - ($TotalPesoSecLote * 100)/$TotalPesoHumLote);
						
					$TotalPesoHumPrv=$TotalPesoHumPrv+$TotalPesoHumLote;
					$TotalPesoSecPrv=$TotalPesoSecPrv+$TotalPesoSecLote;
					if ($OptVer=="L")
					{	
						echo "<tr>";
						echo "<td align=\"center\">".$FilaLote["lote"]."</td>";
						echo "<td align=\"right\">".number_format($TotalPesoHumLote,$DecPHum,',','.')."</td>";
						echo "<td align=\"right\">".number_format($PorcHumLote,2,',','.')."</td>";
						echo "<td align=\"right\">".number_format($TotalPesoSecLote,$DecPSeco,',','.')."</td>";															
						echo "</tr>";						
					}
					$TotalPesoHumLote=0;$TotalPesoSecLote=0;
				}
				//TOTAL PROVEEDOR
				if ($OptVer=="L")
				{
					echo "<tr class=\"Detalle01\">\n";
					echo "<td align=\"left\" >TOTAL ".str_pad($FilaAux["rut_proveedor"],10,"0",STR_PAD_LEFT)."</td>";
				}
				else
				{
					echo "<tr>\n";
					echo "<td align=\"left\" >".str_pad($FilaAux["rut_proveedor"],10,"0",STR_PAD_LEFT)."&nbsp;&nbsp;".substr(strtoupper($NomProveedor),0,25)."</td>";				
				}
				if($TotalPesoHumPrv<>0)
					$PorcHumPrv=100-($TotalPesoSecPrv*100)/$TotalPesoHumPrv;
				echo "<td align=\"right\">".number_format($TotalPesoHumPrv,$DecPHum,',','.')."</td>";						
				echo "<td align=\"right\">".number_format($PorcHumPrv,2,',','.')."</td>\n";				
				echo "<td align=\"right\">".number_format($TotalPesoSecPrv,$DecPSeco,',','.')."</td>";								
				echo "</tr>\n";
				$TotalPesoHumAsig=$TotalPesoHumAsig+$TotalPesoHumPrv;
				$TotalPesoSecAsig=$TotalPesoSecAsig+$TotalPesoSecPrv;
				$TotalPesoHumPrv=0;$TotalPesoSecPrv=0;
			}
			//TOTAL TIPO RECEPCION
			echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td align=\"left\">TOTAL&nbsp;".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
			$PorcHumAsig=100-($TotalPesoSecAsig*100)/$TotalPesoHumAsig;
			echo "<td align=\"right\">".number_format($TotalPesoHumAsig,$DecPHum,',','.')."</td>";
			echo "<td align=\"right\">".number_format($PorcHumAsig,2,',','.')."</td>\n";
			echo "<td align=\"right\">".number_format($TotalPesoSecAsig,$DecPSeco,',','.')."</td>";						
			echo "</tr>\n";
			$TotalPesoHumTot=$TotalPesoHumTot+$TotalPesoHumAsig;
			$TotalPesoSecTot=$TotalPesoSecTot+$TotalPesoSecAsig;
			$TotalPesoHumAsig=0;$TotalPesoSecAsig=0;
			
		}//FIN TIPO RECEPCION
		//TOTAL PRODUCTO
		$PorcHumTot=100-($TotalPesoSecTot*100)/$TotalPesoHumTot;
		echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td align=\"left\">TOTAL: ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($NomSubProd)."</td>\n";
		echo "<td align=\"right\">".number_format($TotalPesoHumTot,$DecPHum,',','.')."</td>";
		echo "<td align=\"right\">".number_format($PorcHumTot,2,',','.')."</td>\n";
		echo "<td align=\"right\">".number_format($TotalPesoSecTot,$DecPSeco,',','.')."</td>";				
		echo "</tr>\n";	
		$TotalPesoHumTot=0;$TotalPesoSecTot=0;
	}//FIN PRODUCTOS
	echo "</table>\n";
	?>  
</form>
</body>
</html>