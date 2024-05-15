<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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

	if(!isset($CmbMes))
	{
		$LoteIni=substr(date('Y'),2,2).str_pad(date('n'),2,'0',STR_PAD_LEFT)."0001";
		$LoteFin=substr(date('Y'),2,2).str_pad(date('n'),2,'0',STR_PAD_LEFT)."9999";
	}
	else
	{
		if ($CmbAno<2006)
		{
			$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
			$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
		}
		else
		{
			$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
			$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
		}
	}	
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
?>
<html>
<head>
<title>Sistema de Agencia Excel</title>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body onLoad="window.document.frmPrincipal.TxtLoteIni.focus();">
<form name="frmPrincipal" action="" method="post">
	<table width='750'  border='1' align='center' cellpadding='2' cellspacing='0'>
	<tr align="center">
	<td>Lote</td>
	<td>SubProducto</td>
	<td>Proveedor</td>
	<td>Cod.Recep</td>
	<td>Peso Hum.</td>
	<td>Peso Seco</td>
	</tr>
	<?php
	if($Buscar=='S')
	{
		$Consulta ="select distinct t1.cod_subproducto,t2.descripcion as nom_subproducto from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto='1' and t1.cod_subproducto=t2.cod_subproducto ";
		switch($TipoBusqueda)
		{
			case "BL"://POR LOTE
				$Consulta.= "where lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
				break;
			case "BM"://POR MES
				if ($CmbAno<2006)
				{
					$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
					$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
				}
				else
				{
					$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
					$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
				}
				$Consulta.= "where t1.cod_producto='1' and lote between '".$LoteIni."' and '".$LoteFin."'";
				break;
		}	
		$Consulta.=" and canjeable='S'";
		$RespProd = mysqli_query($link, $Consulta);
		while($FilaProd = mysqli_fetch_array($RespProd))
		{
			$TotPHumProd=0;
			$TotPSecoProd=0;
			$Consulta ="select distinct t1.rut_proveedor,t2.NOMPRV_A as nom_prv from age_web.lotes t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A ";
			switch($TipoBusqueda)
			{
				case "BL"://POR LOTE
					$Consulta.= "where lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
					break;
				case "BM"://POR MES
					if ($CmbAno<2006)
					{ 
						$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
						$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
					}
					else
					{	
						$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
						$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
					}
					$Consulta.= "where t1.cod_producto='1' and t1.lote between '".$LoteIni."' and '".$LoteFin."'";
					break;
			}	
			$Consulta.=" and t1.canjeable='S' and t1.cod_producto=1 and t1.cod_subproducto='$FilaProd["cod_subproducto"]'";
			$RespProv = mysqli_query($link, $Consulta);
			while($FilaProv = mysqli_fetch_array($RespProv))
			{
				$TotPHumProv=0;
				$TotPSecoProv=0;
				$Consulta ="select t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.abreviatura as nom_subproducto,t1.rut_proveedor,t4.nombre_prv as nom_prv,t1.num_conjunto, t1.cod_recepcion, ";
				$Consulta.="t1.cod_faena,t5.descripcion as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.valor_subclase1 as nom_recepcion ";
				$Consulta.="from age_web.lotes t1 left join ";
				$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
				$Consulta.="sipa_web.proveedores t4 on t1.rut_proveedor=t4.rut_prv left join ";
				$Consulta.="age_web.mina t5 on t1.cod_faena=t5.cod_faena left join ";
				$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
				$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
				$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='15002' and t1.cod_recepcion=t8.nombre_subclase ";
				switch($TipoBusqueda)
				{
					case "BL"://POR LOTE
						$Consulta.= "where t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
						break;
					case "BM"://POR MES
						if ($CmbAno<2006)
						{
							$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
							$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
						}
						else
						{
							$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
							$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
						}
						$Consulta.= "where t1.lote between '".$LoteIni."' and '".$LoteFin."'";
						break;
				}	
				$Consulta.=" and t1.canjeable='S' and t1.rut_proveedor='$FilaProv["rut_proveedor"]'";
				$Resp = mysqli_query($link, $Consulta);
				while($Fila = mysqli_fetch_array($Resp))
				{
					$DatosLote= array();
					$ArrLeyes=array();
					$DatosLote["lote"]=$Fila["lote"];
					LeyesLote(&$DatosLote,&$ArrLeyes,"N","N","S","","","");
					echo "<tr>";
					echo "<td>$Fila["lote"]</td>";
					echo "<td>$Fila["nom_subproducto"]</td>";
					echo "<td>".$Fila["rut_proveedor"]." ".$Fila["nom_prv"]."</td>";
					echo "<td>$Fila["cod_recepcion"]</td>";
					echo "<td align='right'>".number_format($DatosLote[peso_humedo],0,'','.')."</td>";
					echo "<td align='right'>".number_format($DatosLote[peso_seco],0,'','.')."</td>";
					echo "</tr>";
					$TotPHumProv=$TotPHumProv+$DatosLote[peso_humedo];
					$TotPSecoProv=$TotPSecoProv+$DatosLote[peso_seco];
				}
				$TotPHumProd=$TotPHumProd+$TotPHumProv;
				$TotPSecoProd=$TotPSecoProd+$TotPSecoProv;
				echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo '<td colspan="3">PROVEEDOR:&nbsp;'.$FilaProv["rut_proveedor"].' - '.$FilaProv["nom_prv"].'</td>';
				echo "<td align='right'>".number_format($TotPHumProv,0,'','.')."</td>";
				echo "<td align='right'>".number_format($TotPSecoProv,0,'','.')."</td>";
				echo "</tr>";
			}
			echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo '<td colspan="3">SUB-PRODUCTO:&nbsp;'.$FilaProd["cod_subproducto"].' - '.$FilaProd["nom_subproducto"].'</td>';
			echo '<td align="right">'.number_format($TotPHumProd,0,'','.').'</td>';
			echo '<td align="right">'.number_format($TotPSecoProd,0,'','.').'</td>';
			echo "</tr>";
		}
	}
	?>
	</table>	
</form>
</body>
</html>