<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
		
?>
<html>
<head>
<title>Reporte Cuadro diario Ventas Excel</title>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>
<form name="frmPrincipal" action="" method="post">
<table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <?
			  if($CmbMostrar=='2')
			  {
			  ?>
			  <td width="9%"  align="center" class="TituloTablaVerde">N� Documento</td>
              <td width="11%" align="center" class="TituloTablaVerde">Fecha Emisi&oacute;n</td>
              <td width="3%"  align="center" class="TituloTablaVerde">Clte</td>
              <td width="8%" align="center" class="TituloTablaVerde">Fecha Emb.</td>
              <td width="3%" align="center" class="TituloTablaVerde">Nave</td>
              <td width="6%"  align="center" class="TituloTablaVerde">Contrato</td>
              <td width="8%"  align="center" class="TituloTablaVerde">Tipo de Mercado</td>
			  <?
			  }
			  ?>
              <td width="8%"  align="center" class="TituloTablaVerde">Producto</td>
              <td width="7%"  align="center" class="TituloTablaVerde">Tipo Venta</td>
              <td width="4%" align="center" class="TituloTablaVerde">Kilos Finos</td>
              <td width="5%" align="center" class="TituloTablaVerde">Valor Neto</td>
              <td width="5%" align="center" class="TituloTablaVerde">Precio</td>
			  <td width="5%" align="center" class="TituloTablaVerde">Unid</td>				  
              <td width="7%" align="center" class="TituloTablaVerde">Est Fle Des</td>
              <td width="7%" align="center" class="TituloTablaVerde">Seguro Iva</td>
              <td width="9%" align="center" class="TituloTablaVerde">Valor Total</td>
            </tr>
            <tr>
              <td width="9%"></td>
           </tr>
            <?
		  	$Buscar='S';
			if($Buscar=='S')
			{   
				$FinosTotal2=0;$TotalNeto2=0;$TotalEstFle2=0;$TotalIva2=0;$TotalTotal2=0;$Precio3=0;
				$Consulta = "select nombre_subclase as ajuste from proyecto_modernizacion.sub_clase where cod_clase='31007' ";
				if($CmbConAjuste=='S')
					$Consulta.= " and nombre_subclase in('N','S')";			
				else
					$Consulta.= " and nombre_subclase in('N')";	
				$Consulta.= "order by ajuste";			
				$RespTC=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($RespTC))
				{
					$FinosTotal=0;$TotalNeto=0;$TotalEstFle=0;$TotalIva=0;$TotalTotal=0;$Precio=0;$Precio2=0;
					if($CmbMostrar=='2')
					{
						$Consulta="select t1.cod_producto,t1.cod_contrato,t2.nombre_subclase,t4.nom_producto,t1.num_documento,t3.nom_venta,t1.fecha_emision,t1.num_folio,t1.ajuste,";
						$Consulta.=" t1.cod_cliente,t1.fecha_embarque,t1.nave,t1.ano,t1.mes,";#t5.cod_grupo, ";
						if($CmbContr!='-1'||$CmbMerc!='-1'||$CmbProd!='-1'||$CmbVenta!='-1')
							$Consulta.="sum(t1.kilos_finos) as kilos_finos,sum(t1.valor_cif_neto) as valor_cif_neto,sum(t1.est_fle_des) as est_fle_des,sum(t1.seguro_iva) as seguro_iva,";
						else
							$Consulta.="t1.kilos_finos,t1.valor_cif_neto,t1.est_fle_des,t1.seguro_iva,";
						$Consulta.=" t1.valor_fob_total from pcip_cdv_cuadro_diario_ventas t1 left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31008'";
						$Consulta.=" and t2.cod_subclase=t1.cod_mercado left join pcip_cdv_tipo_ventas_cdv t3 on t1.tipo_venta=t3.tipo_venta left join ";
						$Consulta.=" pcip_cdv_productos_ventas t4 on t1.cod_producto=t4.cod_producto  ";
						#$Consulta.="left join pcip_cdv_productos_ventas_por_grupo t5 on t5.cod_producto=t1.cod_producto ";
						$Consulta.=" where cod_contrato<>'' and ajuste='".$FilaTC[ajuste]."'";
						if($CmbContr!='-1')			
							$Consulta.=" and t1.cod_contrato='".$CmbContr."'";
						if($CmbMerc!='-1')
							$Consulta.=" and t1.cod_mercado='".$CmbMerc."'";
						if($CmbProd!='-1')
							$Consulta.=" and t1.cod_producto='".$CmbProd."'";
						if($CmbVenta!='-1')
							$Consulta.=" and t1.tipo_venta='".$CmbVenta."'";
						$FechaInicio=$Ano."-".$Mes."-01";
						$FechaTermino=$AnoFin."-".$MesFin."-31";
						if($Ano==$AnoFin)
							$VarAno=" and (t1.ano='".$Ano."' and t1.mes between '".$Mes."' and '".$MesFin."')";
						else
							$VarAno=" and ((t1.ano='".$Ano."' and t1.mes between '".$Mes."' and '12') or (t1.ano='".$AnoFin."' and t1.mes between '1' and '".$MesFin."')) ";	
						//$Consulta.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' AND '".$FechaTermino."'";
						$Consulta.=$VarAno;
						$Consulta.=" group by t1.num_documento ";
						$Consulta.=" order by t1.num_documento,t1.fecha_emision,cod_contrato ";
					}
					else
					{
						$Consulta="select t1.cod_producto,t1.cod_contrato,t2.nombre_subclase,t4.nom_producto,t1.num_documento,t3.nom_venta,t1.fecha_emision,t1.num_folio,t1.ajuste,";
						$Consulta.=" t1.cod_cliente,t1.fecha_embarque,t1.nave,t1.ano,t1.mes,";#t5.cod_grupo, ";
						if($CmbContr!='-1'||$CmbMerc!='-1'||$CmbProd!='-1'||$CmbVenta!='-1')
							$Consulta.="sum(t1.kilos_finos) as kilos_finos,sum(t1.valor_cif_neto) as valor_cif_neto,sum(t1.est_fle_des) as est_fle_des,sum(t1.seguro_iva) as seguro_iva,";
						else
							$Consulta.="sum(t1.kilos_finos) as kilos_finos,sum(t1.valor_cif_neto) as valor_cif_neto,sum(t1.est_fle_des) as est_fle_des,sum(t1.seguro_iva) as seguro_iva,";
						$Consulta.=" t1.valor_fob_total from pcip_cdv_cuadro_diario_ventas t1 left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31008'";
						$Consulta.=" and t2.cod_subclase=t1.cod_mercado left join pcip_cdv_tipo_ventas_cdv t3 on t1.tipo_venta=t3.tipo_venta left join ";
						$Consulta.=" pcip_cdv_productos_ventas t4 on t1.cod_producto=t4.cod_producto  ";
						#$Consulta.="left join pcip_cdv_productos_ventas_por_grupo t5 on t5.cod_producto=t1.cod_producto ";
						$Consulta.=" where cod_contrato<>'' and ajuste='".$FilaTC[ajuste]."'";
						if($CmbContr!='-1')			
							$Consulta.=" and t1.cod_contrato='".$CmbContr."'";
						if($CmbMerc!='-1')
							$Consulta.=" and t1.cod_mercado='".$CmbMerc."'";
						if($CmbProd!='-1')
							$Consulta.=" and t1.cod_producto='".$CmbProd."'";
						if($CmbVenta!='-1')
							$Consulta.=" and t1.tipo_venta='".$CmbVenta."'";
						$FechaInicio=$Ano."-".$Mes."-01";
						$FechaTermino=$AnoFin."-".$MesFin."-31";
						if($Ano==$AnoFin)
							$VarAno=" and (t1.ano='".$Ano."' and t1.mes between '".$Mes."' and '".$MesFin."')";
						else
							$VarAno=" and ((t1.ano='".$Ano."' and t1.mes between '".$Mes."' and '12') or (t1.ano='".$AnoFin."' and t1.mes between '1' and '".$MesFin."')) ";	
						//$Consulta.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' AND '".$FechaTermino."'";
						$Consulta.=$VarAno;
						$Consulta.=" group by t1.cod_producto,t1.tipo_venta";
						$Consulta.=" order by t1.fecha_emision,cod_contrato ";
					}	
					$Resp=mysqli_query($link, $Consulta);				
					//echo $Consulta;
					while($Fila=mysql_fetch_array($Resp))
					{
					
						$FinosTotal=$FinosTotal+$Fila[kilos_finos];	
						$TotalNeto=$TotalNeto+$Fila[valor_cif_neto];
						$TotalEstFle=$TotalEstFle+$Fila[est_fle_des];
						$TotalIva=$TotalIva+$Fila[seguro_iva];
						$TotalTotal=$TotalTotal+$Fila[valor_fob_total];
						if($Fila[kilos_finos]<>0)
						{
							switch($Fila["cod_grupo"])
							{
								case "1":
								case "2":
								case "3":
/*										if($CodGrupo=='3'&&$i==1)
									 echo 	$Fila2[ValorNeto]."   ".$Fila2[KiloFino]."<br>";
*/										$Precio=1000*($Fila[valor_cif_neto]/$Fila[kilos_finos]);
										$Unid="[US$/TMF]";
								break;
								case "14":
								case "15":
									$Precio=($Fila[valor_cif_neto]/$Fila[kilos_finos])*(1/35.2739619);
									$Unid="[US$/Oz]";
								break;
								default:
									$Precio=$Fila[valor_cif_neto]/$Fila[kilos_finos];
									$Unid="[US$/Kg]";
								break;
							}		
							//    $Precio=$Fila[valor_cif_neto]/$Fila[kilos_finos];
						}
						else
							$Precio=0;							
						?>
						<tr>
						  <?	
						  if($CmbMostrar=='2')
						  {
						  ?>
						  <td align="center"><? echo $Fila[num_documento];?>&nbsp; </td>				  				 
						  <td align="right"><? echo $Fila[fecha_emision];?>&nbsp; </td>
						  <td align="right"><? echo $Fila[cod_cliente];?>&nbsp; </td>
						  <td align="right"><? echo $Fila[fecha_embarque];?>				  
						  <td align="left"><? echo $Fila[nave];?>&nbsp;</td>				  
						  <td><? echo $Fila[cod_contrato];?>&nbsp;</td>
						  <td><? echo $Fila["nombre_subclase"];?>&nbsp; </td>
						  <?
						  }
						  ?>
						  <td><? if($Fila["nom_producto"]=='')
								  {
							  ?> <span class="InputRojo">Sin Nombre Producto</span>
								   <?
									  }   
										else
										{
										echo $Fila["nom_producto"];
										}				  
								   ?>&nbsp; </td>
						  <td align="left"><? echo $Fila[nom_venta];?>&nbsp; </td>
						  <td align="right"><? echo number_format($Fila[kilos_finos],2,',','.');?>&nbsp; </td>				  
						  <td align="right"><? echo number_format($Fila[valor_cif_neto],2,',','.');?>&nbsp; </td>				  
						  <td align="right"><? echo number_format($Precio,2,',','.');?>&nbsp; </td>
						  <td align="right"><? echo $Unid;?>&nbsp; </td>					  						 
						  <td align="right"><? echo number_format($Fila[est_fle_des],2,',','.');?>&nbsp; </td>				  
						  <td align="right"><? echo number_format($Fila[seguro_iva],2,',','.');?>&nbsp; </td>				  				  		  
						  <td align="right"><? echo number_format($Fila[valor_fob_total],2,',','.');?>&nbsp; </td>
						</tr>
						<?			
					  }
					  	
				?>
				  <tr  class="Formulario2">
				  <td colspan="2"><? 
				  		if($FilaTC[ajuste]=='S')
							echo "Total Ajuste";
						else
							echo "Total Tipo Venta";	
				  ?></td>
				  <?
				   if($CmbMostrar=='2')
				   {
				  ?>
				  <td colspan="7">&nbsp;</td>
				  <?
				  }
				  ?>
				  <td align="right"><? echo number_format($FinosTotal,2,',','.')?>&nbsp;</td>
				  <td align="right"><? echo number_format($TotalNeto,2,',','.')?>&nbsp;</td>
				  <?
				  	if($FinosTotal<>0)
						$Precio2=$TotalNeto/$FinosTotal;
					else
						$Precio2=0;	
				  ?>
				  <td align="right">&nbsp;</td>
				  <td>&nbsp;</td>				  
				  <td align="right"><? echo number_format($TotalEstFle,2,',','.')?>&nbsp;</td>
				  <td align="right"><? echo number_format($TotalIva,2,',','.')?>&nbsp;</td>
				  <td align="right"><? echo number_format($TotalTotal,2,',','.')?>&nbsp;</td>			 
				  </tr>
				<?
				$FinosTotal2=$FinosTotal2+$FinosTotal;	
				$TotalNeto2=$TotalNeto2+$TotalNeto;
				$TotalEstFle2=$TotalEstFle2+$TotalEstFle;
				$TotalIva2=$TotalIva2+$TotalIva;
				$TotalTotal2=$TotalTotal2+$TotalTotal;
				 } 
				 if($CmbConAjuste=='S')
				 {
				 ?> 
				  <tr class="TituloTablaVerde">
				  <td  colspan="2">TOTAL</td>
				  <?
				   if($CmbMostrar=='2')
				   {
				  ?>
				  <td colspan="7">&nbsp;</td>
				  <?
				  }
				  ?>
				  <td align="right"><? echo number_format($FinosTotal2,2,',','.')?>&nbsp;</td>
				  <td align="right"><? echo number_format($TotalNeto2,2,',','.')?>&nbsp;</td>
				  <?
				  	if($FinosTotal2<>0)
						$Precio3=$TotalNeto2/$FinosTotal2;
					else
						$Precio3=0;	
				  ?>
				  <td align="right"><? echo number_format($Precio3,2,',','.')?>&nbsp;</td>
				  <td>&nbsp;</td>				  
				  <td align="right"><? echo number_format($TotalEstFle2,2,',','.')?>&nbsp;</td>				
				  <td align="right"><? echo number_format($TotalIva2,2,',','.')?>&nbsp;</td>
				  <td align="right"><? echo number_format($TotalTotal2,2,',','.')?>&nbsp;</td>			 
				  </tr>
				<?
				}			   }
			   ?>			   	
  </table>
</form>
</body>
</html>
<?
function ValoresIn($Asig,$Area,$Maqui,$Prod,$Ano,$MesAux)
{
	$Valor=0;
	$Consulta="select sum(t1.valor) as total ";
	$Consulta.="from pcip_svp_variacion_inventario t1 where t1.cod_asignacion='".$Asig."'";
	if($Area!='-1')
		$Consulta.=" and t1.cod_area='".$Area."'";
	if($Maqui!='-1')
		$Consulta.=" and t1.cod_maquila='".$Maqui."'";
	if($Prod!='-1')
		$Consulta.=" and t1.cod_producto='".$Prod."'";
	if($Ano!='T')
		$Consulta.=" and t1.ano='".$Ano."'";
	if($MesAux!='T')
		$Consulta.=" and t1.mes='".$MesAux."'";
	//echo $Consulta."<br>";
	$Respaux=mysqli_query($link, $Consulta);
	if($Filaaux=mysql_fetch_array($Respaux))
	{
		$Valor=$Filaaux["total"];
		
	}
	return($Valor);
}
function ValorPpto($Asig,$Area,$Maqui,$Prod,$Ano,$MesAux1)
{
	$ValorPpto=0;
	$Consulta="select sum(t1.valor_ppto) as total ";
	$Consulta.="from pcip_svp_variacion_inventario t1 where t1.cod_asignacion='".$Asig."'";
	if($Area!='-1')
		$Consulta.=" and t1.cod_area='".$Area."'";
	if($Maqui!='-1')
		$Consulta.=" and t1.cod_maquila='".$Maqui."'";
	if($Prod!='-1')
		$Consulta.=" and t1.cod_producto='".$Prod."'";
	if($Ano!='T')
		$Consulta.=" and t1.ano='".$Ano."'";
	if($MesAux1!='T')
		$Consulta.=" and t1.mes='".$MesAux1."'";
	echo $Consulta."<br>";
	$Respaux=mysqli_query($link, $Consulta);
	if($Filaaux1=mysql_fetch_array($Respaux))
	{
		$ValorPpto=$Filaaux1["total"];
		
	}
	return($ValorPpto);
}
?>