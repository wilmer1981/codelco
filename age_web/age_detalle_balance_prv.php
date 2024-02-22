<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");	
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script> 
<script language="JavaScript">
function Proceso(Proceso)
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var Resp="";
	
	switch (Proceso)
	{
		case "I"://IMPRIMIR			
			window.print();
			break;
		case "S"://SALIR
			window.close();
			break;
	} 
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
    <table width="820" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr>
        <td align="left" class="Detalle01">
		<?php 
			$Consulta="select descripcion from proyecto_modernizacion.subproducto where cod_producto ='".$Producto."' and cod_subproducto='".$SubProducto."'";
			$RespProd = mysqli_query($link, $Consulta);
			$FilaProd = mysqli_fetch_array($RespProd);
			echo "<strong>FECHA: </strong>".$FechaIni." al ".$FechaFin."&nbsp;&nbsp;&nbsp;&nbsp;<strong>SUBPRODUCTO: </strong>".$FilaProd["descripcion"]."&nbsp;&nbsp;&nbsp;&nbsp;";
			$Consulta="select NOMPRV_A as nom_prv from rec_web.proved where RUTPRV_A ='".$RutPrv."'";
			$RespProv = mysqli_query($link, $Consulta);
			$FilaProv = mysqli_fetch_array($RespProv);
			echo "<strong>PROVEEDOR: </strong>".$RutPrv." - ".$FilaProv[nom_prv];
		?>
		</td>
      </tr>
    </table>
	<br>
    <table width="820" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr>
        <td align="left" class="Detalle02">
		<?php
		switch($Opcion)
		{
			case "PMA"://PROVISIONALES MES ANTERIOR
				echo "========> PROVISIONALES MES ANTERIOR";
				break;
			case "PQ1"://PAQUETE PRIMERO
				echo "========> PAQUETE PRIMERO";
				break;
			case "PDM"://PROVISIONALES DEL MES
				echo "========> PROVISIONALES DEL MES";
				break;
			case "CAN"://CANJE
				echo "========> CANJE";
				break;
		}		
		?></td>
		<td align="center" class="Detalle02">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:80px " onClick="Proceso('I')">
		<input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="JavaScript:Proceso('S')"></td>
      </tr>
    </table>
    <br>
      <table width="820" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr align="center" class="ColorTabla01">
		<td colspan="1">&nbsp;</td>
		<td colspan="3">Leyes(Pqte.1)</td>
		<td colspan="3">
		<?php
			switch($Opcion)
			{
				case "PMA":
					echo "Leyes Provisionales";
					break;
				case "PDM":
					echo "Leyes Provisionales";
					break;
				case "CAN":	
					echo "Leyes Canje";
					break;
				default:	
					echo "Leyes";
					break;
			}
		?></td>
		<td colspan="2">Pesos(Kg)</td>
		<td colspan="3">Ajuste</td>
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
		switch($Opcion)
		{
			case "PMA"://PROVISIONALES MES ANTERIOR
				$Consulta ="select distinct t1.lote from age_web.lotes t1 inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional = 'S' ";
				$Consulta.="where t1.estado_lote <> '6' and t1.rut_proveedor='".$RutPrv."' and t1.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' ";
				$Consulta.="and t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."' order by t1.lote";
				//echo $Consulta;
				$TotalPesoHumProv=0;$TotalPesoSecoProv=0;$TotalAjusteCuProv=0;$TotalAjusteAgProv=0;$TotalAjusteAuProv=0;
				$RespLote = mysqli_query($link, $Consulta);
				while ($FilaLote = mysqli_fetch_array($RespLote))
				{
					echo "<tr align='center'>\n";
					echo "<td>$FilaLote[lote]</td>\n";
					$DatosLote= array();
					$ArrLeyes=array();
					$DatosLote["lote"]=$FilaLote[lote];
					LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","N","","","");
					echo "<td>".number_format($ArrLeyes["02"][2],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["04"][2],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["05"][2],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["02"][7],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["04"][7],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["05"][7],2,',','')."</td>\n";
					echo "<td>".number_format($DatosLote[peso_humedo],0,'','.')."</td>\n";
					echo "<td>".number_format($DatosLote[peso_seco],0,'','.')."</td>\n";
					if($ArrLeyes["02"][5]==0)
						$Dif_Cu=(($ArrLeyes["02"][2]-$ArrLeyes["02"][7])*$DatosLote[peso_seco])/1;
					else
						$Dif_Cu=(($ArrLeyes["02"][2]-$ArrLeyes["02"][7])*$DatosLote[peso_seco])/$ArrLeyes["02"][5];
					if($ArrLeyes["04"][5]==0)		
						$Dif_Ag=(($ArrLeyes["04"][2]-$ArrLeyes["04"][7])*$DatosLote[peso_seco])/1;
					else
						$Dif_Ag=(($ArrLeyes["04"][2]-$ArrLeyes["04"][7])*$DatosLote[peso_seco])/$ArrLeyes["04"][5];
					if($ArrLeyes["05"][5]==0)		
						$Dif_Au=(($ArrLeyes["05"][2]-$ArrLeyes["05"][7])*$DatosLote[peso_seco])/1;
					else
						$Dif_Au=(($ArrLeyes["05"][2]-$ArrLeyes["05"][7])*$DatosLote[peso_seco])/$ArrLeyes["05"][5];	
					echo "<td>".number_format($Dif_Cu,0,',','.')."</td>\n";
					echo "<td>".number_format($Dif_Ag,0,',','.')."</td>\n";
					echo "<td>".number_format($Dif_Au,0,',','.')."</td>\n";
					$TotalPesoHumProv=$TotalPesoHumProv+$DatosLote[peso_humedo];
					$TotalPesoSecoProv=$TotalPesoSecoProv+$DatosLote[peso_seco];
					$TotalAjusteCuProv=$TotalAjusteCuProv+$Dif_Cu;
					$TotalAjusteAgProv=$TotalAjusteAgProv+$Dif_Ag;
					$TotalAjusteAuProv=$TotalAjusteAuProv+$Dif_Au;
					echo "</tr>\n";
				}
				echo "<tr class='Detalle02'>\n";
				echo "<td colspan='7'>&nbsp;</td>\n";	
				echo "<td align='center'>".number_format($TotalPesoHumProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalPesoSecoProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteCuProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteAgProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteAuProv,0,'','.')."</td>\n";
				echo "</tr>\n";
				break;
			case "PQ1"://PAQUETE PRIMERO
				$Consulta ="select distinct t1.lote from age_web.lotes t1 left join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional <> 'S' ";
				$Consulta.="where t1.estado_lote <> '6' and t1.canjeable<>'S' and t1.rut_proveedor='".$RutPrv."' and t1.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' ";
				$Consulta.="and t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."' order by t1.lote";
				//echo $Consulta;
				$TotalPesoHumProv=0;$TotalPesoSecoProv=0;$TotalAjusteCuProv=0;$TotalAjusteAgProv=0;$TotalAjusteAuProv=0;
				$RespLote = mysqli_query($link, $Consulta);
				while ($FilaLote = mysqli_fetch_array($RespLote))
				{
					echo "<tr align='center'>\n";
					echo "<td>$FilaLote[lote]</td>\n";
					$DatosLote= array();
					$ArrLeyes=array();
					$DatosLote["lote"]=$FilaLote[lote];
					LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
					echo "<td>".number_format($ArrLeyes["02"][2],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["04"][2],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["05"][2],2,',','')."</td>\n";
					echo "<td>-</td>\n";
					echo "<td>-</td>\n";
					echo "<td>-</td>\n";
					echo "<td>".number_format($DatosLote[peso_humedo],0,'','.')."</td>\n";
					echo "<td>".number_format($DatosLote[peso_seco],0,'','.')."</td>\n";
					if($ArrLeyes["02"][5]==0)
						$Dif_Cu=0;
					else
						$Dif_Cu=($ArrLeyes["02"][2]*$DatosLote[peso_seco])/100;
					if($ArrLeyes["04"][5]==0)
						$Dif_Ag=0;
					else
						$Dif_Ag=($ArrLeyes["04"][2]*$DatosLote[peso_seco])/1000;	
					if($ArrLeyes["05"][5]==0)	
						$Dif_Au=0;
					else
						$Dif_Au=($ArrLeyes["05"][2]*$DatosLote[peso_seco])/1000;
					echo "<td>".number_format($Dif_Cu,0,',','.')."</td>\n";
					echo "<td>".number_format($Dif_Ag,0,',','.')."</td>\n";
					echo "<td>".number_format($Dif_Au,0,',','.')."</td>\n";
					$TotalPesoHumProv=$TotalPesoHumProv+$DatosLote[peso_humedo];
					$TotalPesoSecoProv=$TotalPesoSecoProv+$DatosLote[peso_seco];
					$TotalAjusteCuProv=$TotalAjusteCuProv+$Dif_Cu;
					$TotalAjusteAgProv=$TotalAjusteAgProv+$Dif_Ag;
					$TotalAjusteAuProv=$TotalAjusteAuProv+$Dif_Au;
					echo "</tr>\n";
				}
				echo "<tr class='Detalle02'>\n";
				echo "<td colspan='7'>&nbsp;</td>\n";	
				echo "<td align='center'>".number_format($TotalPesoHumProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalPesoSecoProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteCuProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteAgProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteAuProv,0,'','.')."</td>\n";
				echo "</tr>\n";
				break;
			case "PDM"://PROVISIONALES DEL MES
				$Consulta ="select distinct t1.lote from age_web.lotes t1 inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional = 'S' ";
				$Consulta.="where t1.estado_lote <> '6' and t1.rut_proveedor='".$RutPrv."' and t1.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' ";
				$Consulta.="and t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."' order by t1.lote";
				//echo $Consulta;
				$TotalPesoHumProv=0;$TotalPesoSecoProv=0;$TotalAjusteCuProv=0;$TotalAjusteAgProv=0;$TotalAjusteAuProv=0;
				$RespLote = mysqli_query($link, $Consulta);
				while ($FilaLote = mysqli_fetch_array($RespLote))
				{
					echo "<tr align='center'>\n";
					echo "<td>$FilaLote[lote]</td>\n";
					$DatosLote= array();
					$ArrLeyes=array();
					$DatosLote["lote"]=$FilaLote[lote];
					LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","N","","","");
					echo "<td>".number_format($ArrLeyes["02"][2],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["04"][2],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["05"][2],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["02"][7],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["04"][7],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["05"][7],2,',','')."</td>\n";
					echo "<td>".number_format($DatosLote[peso_humedo],0,'','.')."</td>\n";
					echo "<td>".number_format($DatosLote[peso_seco],0,'','.')."</td>\n";
					if($ArrLeyes["02"][5]==0)
						$Dif_Cu=(($ArrLeyes["02"][2]-$ArrLeyes["02"][7])*$DatosLote[peso_seco])/1;
					else
						$Dif_Cu=(($ArrLeyes["02"][2]-$ArrLeyes["02"][7])*$DatosLote[peso_seco])/$ArrLeyes["02"][5];
					if($ArrLeyes["04"][5]==0)	
						$Dif_Ag=(($ArrLeyes["04"][2]-$ArrLeyes["04"][7])*$DatosLote[peso_seco])/1;
					else
						$Dif_Ag=(($ArrLeyes["04"][2]-$ArrLeyes["04"][7])*$DatosLote[peso_seco])/$ArrLeyes["04"][5];
					if($ArrLeyes["05"][5]==0)	
						$Dif_Au=(($ArrLeyes["05"][2]-$ArrLeyes["05"][7])*$DatosLote[peso_seco])/1;
					else
						$Dif_Au=(($ArrLeyes["05"][2]-$ArrLeyes["05"][7])*$DatosLote[peso_seco])/$ArrLeyes["05"][5];
					echo "<td>".number_format($Dif_Cu,0,',','.')."</td>\n";
					echo "<td>".number_format($Dif_Ag,0,',','.')."</td>\n";
					echo "<td>".number_format($Dif_Au,0,',','.')."</td>\n";
					$TotalPesoHumProv=$TotalPesoHumProv+$DatosLote[peso_humedo];
					$TotalPesoSecoProv=$TotalPesoSecoProv+$DatosLote[peso_seco];
					$TotalAjusteCuProv=$TotalAjusteCuProv+$Dif_Cu;
					$TotalAjusteAgProv=$TotalAjusteAgProv+$Dif_Ag;
					$TotalAjusteAuProv=$TotalAjusteAuProv+$Dif_Au;
					echo "</tr>\n";
				}
				echo "<tr class='Detalle02'>\n";
				echo "<td colspan='7'>&nbsp;</td>\n";	
				echo "<td align='center'>".number_format($TotalPesoHumProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalPesoSecoProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteCuProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteAgProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteAuProv,0,'','.')."</td>\n";
				echo "</tr>\n";
				break;
			case "CAN"://CANJE
				$Consulta ="select * from age_web.lotes t1 ";
				$Consulta.="where t1.estado_lote <> '6' and t1.rut_proveedor='".$RutPrv."' and t1.canjeable='S' and t1.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' ";
				$Consulta.="and t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."' order by t1.lote";
				$TotalPesoHumProv=0;$TotalPesoSecoProv=0;$TotalAjusteCuProv=0;$TotalAjusteAgProv=0;$TotalAjusteAuProv=0;
				$RespLote = mysqli_query($link, $Consulta);
				while ($FilaLote = mysqli_fetch_array($RespLote))
				{
					echo "<tr align='center'>\n";
					echo "<td>$FilaLote[lote]</td>\n";
					$DatosLote= array();
					$ArrLeyes=array();
					$DatosLote["lote"]=$FilaLote[lote];
					LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","N","","","");
					echo "<td>".number_format($ArrLeyes["02"][2],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["04"][2],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["05"][2],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["02"][8],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["04"][8],2,',','')."</td>\n";
					echo "<td>".number_format($ArrLeyes["05"][8],2,',','')."</td>\n";
					echo "<td>".number_format($DatosLote[peso_humedo],0,'','.')."</td>\n";
					echo "<td>".number_format($DatosLote[peso_seco],0,'','.')."</td>\n";
					if($ArrLeyes["02"][5]==0)
						$Dif_Cu=(($ArrLeyes["02"][8]-$ArrLeyes["02"][2])*$DatosLote[peso_seco])/1;
					else
						$Dif_Cu=(($ArrLeyes["02"][8]-$ArrLeyes["02"][2])*$DatosLote[peso_seco])/$ArrLeyes["02"][5];
					if($ArrLeyes["04"][5]==0)	
						$Dif_Ag=(($ArrLeyes["04"][8]-$ArrLeyes["04"][2])*$DatosLote[peso_seco])/1;
					else
						$Dif_Ag=(($ArrLeyes["04"][8]-$ArrLeyes["04"][2])*$DatosLote[peso_seco])/$ArrLeyes["04"][5];
					if($ArrLeyes["05"][5]==0)		
						$Dif_Au=(($ArrLeyes["05"][8]-$ArrLeyes["05"][2])*$DatosLote[peso_seco])/1;
					else
						$Dif_Au=(($ArrLeyes["05"][8]-$ArrLeyes["05"][2])*$DatosLote[peso_seco])/$ArrLeyes["05"][5];
					echo "<td>".number_format($Dif_Cu,0,',','.')."</td>\n";
					echo "<td>".number_format($Dif_Ag,0,',','.')."</td>\n";
					echo "<td>".number_format($Dif_Au,0,',','.')."</td>\n";
					$TotalPesoHumProv=$TotalPesoHumProv+$DatosLote[peso_humedo];
					$TotalPesoSecoProv=$TotalPesoSecoProv+$DatosLote[peso_seco];
					$TotalAjusteCuProv=$TotalAjusteCuProv+$Dif_Cu;
					$TotalAjusteAgProv=$TotalAjusteAgProv+$Dif_Ag;
					$TotalAjusteAuProv=$TotalAjusteAuProv+$Dif_Au;
					echo "</tr>\n";
				}
				echo "<tr class='Detalle02'>\n";
				echo "<td colspan='7'>&nbsp;</td>\n";	
				echo "<td align='center'>".number_format($TotalPesoHumProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalPesoSecoProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteCuProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteAgProv,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($TotalAjusteAuProv,0,'','.')."</td>\n";
				echo "</tr>\n";
				break;
		}	
		?>
      </table>
</form>
</body>
</html>