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
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 14;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
			
	$Recarga  = isset($_REQUEST["Recarga"])?$_REQUEST["Recarga"]:"";
	$Mostrar  = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$TipoBusq = isset($_REQUEST["TipoBusq"])?$_REQUEST["TipoBusq"]:0;
	$CmbMes = isset($_REQUEST['CmbMes']) ? $_REQUEST['CmbMes'] : date('m');
	$CmbAno = isset($_REQUEST['CmbAno']) ? $_REQUEST['CmbAno'] : date('Y');
	$TxtBolIni = isset($_REQUEST["TxtBolIni"])?$_REQUEST["TxtBolIni"]:"";
	$TxtBolFin = isset($_REQUEST["TxtBolFin"])?$_REQUEST["TxtBolFin"]:"";
	$CmbSubProducto = isset($_REQUEST['CmbSubProducto']) ? $_REQUEST['CmbSubProducto'] : '';
	$CmbProveedor   = isset($_REQUEST['CmbProveedor']) ? $_REQUEST['CmbProveedor'] : '';
	$TxtFiltroPrv   = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
?>
<html>
<head>
<title>Consulta Boleta Pesaje</title>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaBolPesaje" method="post" action="">
 <br> 
        <table width="750" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr class="ColorTabla01">
		  <!--<td align="center" width="10">&nbsp;</td>-->
		  <td width="60" align="center">Lote</td>
		  <td align="center" width="60">Recep</td>
		  <td align="center" width="77">Rut Prv</td>
          <td align="center" width="144">Nombre Proveedor</td>
          <td align="center" width="102">SubProducto</td>
		  <td align="center" width="136">Mina</td>
		  <td align="center" width="31">Clase</td>
		  <td align="center" width="36">Conjto</td>
		  <td align="right"  width="90">Peso.Hum(Kg)</td>
		  </tr>          
		  <?php
			$SubTotalPeso=0;
			$TotalPeso = 0;
			$SubCantReg=0;
			$DescrAnt="";
			$CantReg = 0;
			if ($Mostrar=='S')	
			{
				if (strlen($CmbMes)=='1')
				{
					$FechaIni=$CmbAno."-0".$CmbMes."-01";
					$FechaFin=$CmbAno."-0".$CmbMes."-31";
				}	
				else
				{
					$FechaIni=$CmbAno."-".$CmbMes."-01";
					$FechaFin=$CmbAno."-".$CmbMes."-31";
				}	
				$Consulta ="select sum(t5.peso_neto) as tot_peso_neto,t1.lote,t1.fecha_recepcion,";
				$Consulta.= " t1.rut_proveedor,t1.cod_producto, t1.cod_subproducto,t3.nomprv_a as nombre,";
				$Consulta.= " t2.abreviatura as subproducto,t4.NOMMIN_A, t1.clase_producto, t1.num_conjunto ";
				$Consulta.= " from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto=1 and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.= " inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a inner join rec_web.minaprv t4 on t1.rut_proveedor=t4.RUTPRV_A and t1.cod_faena=t4.CODMIN_A ";
				$Consulta.= " inner join age_web.detalle_lotes t5 on t1.lote=t5.lote ";
				switch($TipoBusq)
				{
					case "1"://POR RANGO BOLETAS
						$Consulta.= " where t1.lote between '$TxtBolIni' and '$TxtBolFin'";	
						break;
					case "2"://POR PROVEEDOR
						$Consulta.= " where t1.fecha_recepcion between '$FechaIni' and '$FechaFin' and t1.rut_proveedor='".$CmbProveedor."'";
						break;
					case "3"://POR SUBPRODUCTO
						$Consulta.= " where t1.fecha_recepcion between '$FechaIni' and '$FechaFin' and t1.cod_subproducto='".$CmbSubProducto."'";
						break;
					default:
						$Consulta.= " where t1.lote='-1'";
						break;	
				}
				$Consulta.= " and t1.estado_lote<>'6' ";
				$Consulta.= " group by t1.lote order by lpad(t1.cod_producto,3,'0'), lpad(t1.cod_subproducto,3,'0'), t1.rut_proveedor,t1.lote";
				//echo $Consulta;
				$Resp = mysqli_query($link, $Consulta);
				echo "<input type='hidden' name='CheckCod'>";
				$TotalPeso = 0;
				$SubTotalPeso = 0;
				$CantReg = 0;
				$SubCantReg = 0;;	
				$ProdAnt = "";
				$SubProdAnt = "";
				$RutAnt = "";
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if (($ProdAnt!="" && $SubProdAnt!="") && ($ProdAnt!=$Fila["cod_producto"] || $SubProdAnt!=$Fila["cod_subproducto"]))
					{
						EscribeSubTotal($DescrAnt, $SubTotalPeso, $SubCantReg);
					}
					else
					{
						if (($ProdAnt!="" && $SubProdAnt!="" && $RutAnt!="") && 
						($ProdAnt==$Fila["cod_producto"] && $SubProdAnt==$Fila["cod_subproducto"] && $RutAnt!=$Fila["rut_proveedor"]))
						{
							EscribeSubTotal($DescrAnt, $SubTotalPeso, $SubCantReg);
						}
					}
					$fecha_recepcion = isset($Fila["fecha_recepcion"])?$Fila["fecha_recepcion"]:"";
					echo "<tr>\n";
					echo "<td align='center'>".$Fila["lote"]."</td>\n";
					echo "<td align='center'>".substr($fecha_recepcion,8,2)."/".substr($Meses[intval(substr($fecha_recepcion,5,2))-1],0,3)."</td>\n";
					echo "<td align='right'>".$Fila["rut_proveedor"]."</td>\n";
					echo "<td align='left'>".strtoupper(substr($Fila["nombre"],0,18))."</td>\n";
					echo "<td align='left'>".$Fila["subproducto"]."</td>\n";
					echo "<td align='left'>".strtoupper(substr($Fila["NOMMIN_A"],0,18))."</td>\n";
					echo "<td align='center'>".$Fila["clase_producto"]."</td>\n";
					echo "<td align='center'>".$Fila["num_conjunto"]."</td>\n";
					echo "<td align='right'>".number_format($Fila["tot_peso_neto"],0,',','.')."</td>\n";
					echo "</tr>\n";
					$TotalPeso = $TotalPeso + $Fila["tot_peso_neto"];
					$SubTotalPeso = $SubTotalPeso + $Fila["tot_peso_neto"];
					$CantReg++;
					$SubCantReg++;					
					$ProdAnt = $Fila["cod_producto"];
					$SubProdAnt = $Fila["cod_subproducto"];
					$RutAnt = $Fila["rut_proveedor"];
					$DescrAnt = $Fila["subproducto"]."&nbsp;".strtoupper(substr($Fila["nombre"],0,18));					
				}
			}
			EscribeSubTotal($DescrAnt, $SubTotalPeso, $SubCantReg);
			
			
function EscribeSubTotal($Descr, $PesoSubTotal, $SubTotalReg)
{
	echo '<tr class="Detalle01">';
	echo '<td colspan="8" align="right"><strong>TOTAL '.$Descr.' '.number_format( $SubTotalReg,0,",",".").' LOTES CON UN PESO DE: </strong></td>';
	echo '<td align="right"><strong>'.number_format($PesoSubTotal,0,",",".").'</strong></td>';
	echo '</tr>';
	$Descr = "";
	$PesoSubTotal = 0;
	$SubTotalReg = 0;
}			
		  ?>
		  <tr class="Detalle01">
            <td colspan="8" align="right"><strong>TOTAL <?php echo number_format($CantReg,0,",","."); ?> LOTES CON UN PESO DE: </strong></td>
            <td align="right"><strong><?php echo number_format($TotalPeso,0,",","."); ?></strong></td>
          </tr>
        </table>
        <br>

</form>
</body>
</html>