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
	include("age_funciones.php");

	$Proceso    = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Mostrar    = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
    $Opcion     = isset($_REQUEST["Opcion"])?$_REQUEST["Opcion"]:"";
	$TxtFiltroPrv  = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";

	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:"";
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";

	$SubProducto   = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor     = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";

?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form name="FrmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<table width="770" height="330" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td align="center" valign="top">
      <table width="750" border="1" align="center" cellpadding="3" cellspacing="0" >
        <tr align="center" >
		<td colspan="1">&nbsp;</td>
		<td colspan="3">Pqte. 1 ero </td>
		<td colspan="3">Leyes Canje </td>
		<td colspan="2">Pesos(Kg)</td>
		<td colspan="3">Ajuste Mes</td>
		</tr>
		<tr align="center" >
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
		if($Mes=='1')
		{
			$MesAux='12';
			$AnoAux=$Ano-1;
		}
		else
		{
			$MesAux=$Mes;
			$AnoAux=$Ano;
		}
		$FechaIni = $Ano."-".$Mes."-01";
		$FechaFin = $Ano."-".$Mes."-31";		
		$AnoMes=substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT);
		if ($Mostrar=="S")
		{ 		
			$TotalPesoHum=0;$TotalPesoSeco=0;$TotalAjusteCu=0;$TotalAjusteAg=0;$TotalAjusteAu=0;
			$Consulta="select t1.cod_producto,t1.cod_subproducto, t4.descripcion as nom_subprod ";
			$Consulta.="from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t4 on t1.cod_producto=t4.cod_producto and t1.cod_subproducto=t4.cod_subproducto ";
			$Consulta.="where t1.cod_producto='1' and t1.canjeable='S' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
			if (isset($SubProducto) && $SubProducto != "S")
				$Consulta.= " and t1.cod_subproducto='".$SubProducto."' ";	
			$Consulta.=" group by t1.cod_producto,t1.cod_subproducto order by t1.cod_producto, t1.cod_subproducto";
			//echo $Consulta;
			$RespProd = mysqli_query($link, $Consulta);
			while ($FilaProd = mysqli_fetch_array($RespProd))
			{
				
				$SubTotalPesoHumProd=0;$SubTotalPesoSecoProd=0;$SubTotalAjusteCuProd=0;$SubTotalAjusteAgProd=0;$SubTotalAjusteAuProd=0;
				$Consulta="select distinct t1.rut_proveedor,t2.nombre_prv as nom_prv ";
				$Consulta.= "from age_web.lotes t1 inner join sipa_web.proveedores t2 on t1.rut_proveedor=t2.rut_prv ";				
				$Consulta.="where t1.canjeable='S' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
				$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
				$Consulta.="group by t1.cod_producto,t1.cod_subproducto order by t1.cod_producto, t1.cod_subproducto";
				$RespProv = mysqli_query($link, $Consulta);
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$Consulta ="select * from age_web.lotes t1 ";
					$Consulta.="where t1.rut_proveedor='".$FilaProv["rut_proveedor"]."' and t1.canjeable='S' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
					$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' order by t1.lote";
					$SubTotalPesoHumProv=0;$SubTotalPesoSecoProv=0;$SubTotalAjusteCuProv=0;$SubTotalAjusteAgProv=0;$SubTotalAjusteAuProv=0;
					$RespLote = mysqli_query($link, $Consulta);
					while ($FilaLote = mysqli_fetch_array($RespLote))
					{
						echo "<tr align='center'>\n";
						echo "<td>".$FilaLote["lote"]."</td>\n";
						$DatosLote= array();
						$ArrLeyes=array();
						$DatosLote["lote"]=$FilaLote["lote"];
						$DatosLote = LeyesLote($DatosLote,$ArrLeyes,"N","S","N","","","","",$link);
						$ArrLeyes  = LeyesLote($DatosLote,$ArrLeyes,"N","S","N","","","","L",$link);
						echo "<td>".number_format($ArrLeyes["02"][2],2,',','')."</td>\n";
						echo "<td>".number_format($ArrLeyes["04"][2],2,',','')."</td>\n";
						echo "<td>".number_format($ArrLeyes["05"][2],2,',','')."</td>\n";
						echo "<td>".number_format($ArrLeyes["02"][8],2,',','')."</td>\n";
						echo "<td>".number_format($ArrLeyes["04"][8],2,',','')."</td>\n";
						echo "<td>".number_format($ArrLeyes["05"][8],2,',','')."</td>\n";
						echo "<td>".number_format($DatosLote["peso_humedo"],0,'','.')."</td>\n";
						echo "<td>".number_format($DatosLote["peso_seco"],0,'','.')."</td>\n";
						if ($ArrLeyes["02"][8]>0 && $ArrLeyes["02"][2]>0 && $DatosLote["peso_seco"]>0)
							$Dif_Cu=(($ArrLeyes["02"][8]-$ArrLeyes["02"][2])*$DatosLote["peso_seco"])/$ArrLeyes["02"][5];
						else
							$Dif_Cu=0;
						if ($ArrLeyes["04"][8]>0 && $ArrLeyes["04"][2]>0 && $DatosLote["peso_seco"]>0)
							$Dif_Ag=(($ArrLeyes["04"][8]-$ArrLeyes["04"][2])*$DatosLote["peso_seco"])/$ArrLeyes["04"][5];
						else
							$Dif_Ag=0;
						if ($ArrLeyes["05"][8]>0 && $ArrLeyes["05"][2]>0 && $DatosLote["peso_seco"]>0)
							$Dif_Au=(($ArrLeyes["05"][8]-$ArrLeyes["05"][2])*$DatosLote["peso_seco"])/$ArrLeyes["05"][5];
						else
							$Dif_Au=0;
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
					echo "<tr>\n";
					echo '<td colspan="7">PROVEEDOR&nbsp;&nbsp;'.strtoupper($FilaProv["nom_prv"]).'</td>';	
					echo "<td align='center'>".number_format($SubTotalPesoHumProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalPesoSecoProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalAjusteCuProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalAjusteAgProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalAjusteAuProv,0,'','.')."</td>\n";
					echo "</tr>\n";
				}
				$TotalPesoHum=$TotalPesoHum+$SubTotalPesoHumProd;
				$TotalPesoSeco=$TotalPesoSeco+$SubTotalPesoSecoProd;
				$TotalAjusteCu=$TotalAjusteCu+$SubTotalAjusteCuProd;
				$TotalAjusteAg=$TotalAjusteAg+$SubTotalAjusteAgProd;
				$TotalAjusteAu=$TotalAjusteAu+$SubTotalAjusteAuProd;
				echo "<tr>\n";
				echo '<td colspan="7">PRODUCTO&nbsp;&nbsp;'.strtoupper($FilaProd["nom_subprod"]).'</td>';	
				echo "<td align='center'>".number_format($SubTotalPesoHumProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalPesoSecoProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteCuProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteAgProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteAuProd,0,'','.')."</td>\n";
				echo "</tr>\n";
			}
			echo "<tr>\n";
			echo '<td colspan="7"><strong>TOTAL</strong></td>';
			echo "<td align='center'>".number_format($TotalPesoHum,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalPesoSeco,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteCu,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteAg,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteAu,0,'','.')."</td>\n";
			echo "</tr>\n";
		}
		?>
      </table>    </td>
  </tr>
</table> 
</table>
</form>
</body>
</html>