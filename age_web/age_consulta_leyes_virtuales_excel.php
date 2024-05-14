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
	include("../principal/conectar_principal.php");	
	include("age_funciones.php");	
?>
<html>
<head>
<title>Sistema de Agencia</title>
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form name="FrmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
    <br>
      <table width="900" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr align="center" class="ColorTabla01">
		<td>&nbsp;</td>
		<td colspan="3">Leyes Provisionales </td>
		<td colspan="3">Leyes Reales</td>
		<td colspan="2">Pesos(Kg)</td>
		<td colspan="3">Ajuste Mes</td>
		</tr>
		<tr align="center" class="ColorTabla01">
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
			$Consulta="select t1.cod_producto,t1.cod_subproducto,t2.descripcion as nom_subprod from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 ";
			$Consulta.="on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and t3.provisional = 'S' ";
			$Consulta.="where t1.cod_producto='1' ";
			if($SubProducto!='S')
				$Consulta.=" and t1.cod_subproducto='".$SubProducto."' ";
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
			$Consulta.="group by t1.cod_producto,t1.cod_subproducto order by t1.cod_producto,t1.cod_subproducto";
			//echo $Consulta;
			$RespProd=mysqli_query($link, $Consulta);
			while($FilaProd=mysqli_fetch_array($RespProd))
			{
				$SubTotalPesoHum=0;$SubTotalPesoSeco=0;$SubTotalAjusteCu=0;$SubTotalAjusteAg=0;$SubTotalAjusteAu=0;
				$Consulta="select distinct t1.rut_proveedor,t2.NOMPRV_A as nom_prv from age_web.lotes t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A ";				
				$Consulta.="inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and t3.provisional = 'S' where t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
				$Consulta.="and t1.cod_producto='1' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
				$Consulta.= "order by t2.NOMPRV_a";
				//echo $Consulta."<br>";
				$RespProv = mysqli_query($link, $Consulta);
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$Consulta="select distinct t1.lote from age_web.lotes t1 inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and t3.provisional = 'S' ";				
					$Consulta.="where t1.rut_proveedor ='".$FilaProv["rut_proveedor"]."' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
					$Consulta.="and t1.cod_producto='1' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
					//echo $Consulta."<br>";
					$RespLotes = mysqli_query($link, $Consulta);
					$Cu_Fino_Ajuste=0;$Ag_Fino_Ajuste=0;$Au_Fino_Ajuste=0;$Cu_Fino_Pro=0;$Ag_Fino_Pro=0;$Au_Fino_Pro=0;$Cu_Fino_Real=0;$Ag_Fino_Real=0;$Au_Fino_Real=0;
					while ($FilaLote=mysqli_fetch_array($RespLotes))
					{
						$DatosLote= array();
						$ArrLeyes=array();
						$DatosLote["lote"]=$FilaLote["lote"];
						LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
						echo "<td>".$FilaLote["lote"]."</td>\n";	
						echo "<td align='center'>".number_format($ArrLeyes["02"][2],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($ArrLeyes["04"][2],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($ArrLeyes["05"][2],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($ArrLeyes["02"][7],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($ArrLeyes["04"][7],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($ArrLeyes["05"][7],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($DatosLote["peso_humedo"],0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($DatosLote["peso_seco"],0,'','.')."</td>\n";
						echo "<td align='center'>".number_format((($ArrLeyes["02"][7]-$ArrLeyes["02"][2])*$DatosLote["peso_seco"])/100,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format((($ArrLeyes["04"][7]-$ArrLeyes["04"][2])*$DatosLote["peso_seco"])/1000,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format((($ArrLeyes["05"][7]-$ArrLeyes["05"][2])*$DatosLote["peso_seco"])/1000,0,'','.')."</td>\n";
						echo "</tr>\n";
						$Cu_Fino_Ajuste=$Cu_Fino_Ajuste+(($ArrLeyes["02"][7]-$ArrLeyes["02"][2])*$DatosLote["peso_seco"])/100;
						$Cu_Fino_Pro=$Cu_Fino_Pro+($ArrLeyes["02"][2]*$DatosLote["peso_seco"])/100;
						$Ag_Fino_Ajuste=$Ag_Fino_Ajuste+(($ArrLeyes["04"][7]-$ArrLeyes["04"][2])*$DatosLote["peso_seco"])/1000;
						$Ag_Fino_Pro=$Ag_Fino_Pro+($ArrLeyes["04"][2]*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Ajuste=$Au_Fino_Ajuste+(($ArrLeyes["05"][7]-$ArrLeyes["05"][2])*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Pro=$Au_Fino_Pro+($ArrLeyes["05"][2]*$DatosLote["peso_seco"])/1000;
						$PesoHumProv=$PesoHumProv+$DatosLote["peso_humedo"];
						$PesoSecoProv=$PesoSecoProv+$DatosLote["peso_seco"];
					}
					echo "<tr class='Detalle02'>\n";
					echo "<td colspan=\"7\">".strtoupper(substr($FilaProv["nom_prv"],0,20))."</td>\n";	
					echo "<td align='center'>".number_format($PesoHumProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($PesoSecoProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Cu_Fino_Ajuste,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Ag_Fino_Ajuste,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Au_Fino_Ajuste,0,'','.')."</td>\n";
					echo "</tr>\n";
					$SubTotalPesoHum=$SubTotalPesoHum+$PesoHumProv;
					$SubTotalPesoSeco=$SubTotalPesoSeco+$PesoSecoProv;
					$SubTotalAjusteCu=$SubTotalAjusteCu+$Cu_Fino_Ajuste;
					$SubTotalAjusteAg=$SubTotalAjusteAg+$Ag_Fino_Ajuste;
					$SubTotalAjusteAu=$SubTotalAjusteAu+$Au_Fino_Ajuste;
				}
				echo "<tr>\n";
				echo "<td colspan=\"7\">SUBTOTAL&nbsp;&nbsp;".strtoupper($FilaProd["nom_subprod"])."</td>\n";	
				echo "<td align='center'>".number_format($SubTotalPesoHum,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalPesoSeco,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteCu,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteAg,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteAu,0,'','.')."</td>\n";
				echo "</tr>\n";
				$TotalPesoHum=$TotalPesoHum+$SubTotalPesoHum;
				$TotalPesoSeco=$TotalPesoSeco+$SubTotalPesoSeco;
				$TotalAjusteCu=$TotalAjusteCu+$SubTotalAjusteCu;
				$TotalAjusteAg=$TotalAjusteAg+$SubTotalAjusteAg;
				$TotalAjusteAu=$TotalAjusteAu+$SubTotalAjusteAu;
			}
			echo "<tr>\n";
			echo "<td>TOTAL</td>\n";	
			echo "<td colspan=\"6\">&nbsp;</td>\n";
			echo "<td align='center'>".number_format($TotalPesoHum,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalPesoSeco,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteCu,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteAg,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteAu,0,'','.')."</td>\n";
			echo "</tr>\n";
		}
		?>
      </table>
    </td>
<?php //include ("../principal/pie_pagina.php") ?>     
</form>
</body>
</html>
<?php
/*$Consulta= "select t2.abreviatura as unidad from proyecto_modernizacion.leyes t1 left join proyecto_modernizacion.unidades t2 on t1.cod_unidad=t2.cod_unidad where cod_leyes='05'";
$RespUnidad=mysqli_query($link, $Consulta);
$FilaUnidad=mysqli_fetch_array($RespUnidad);*/
?>
