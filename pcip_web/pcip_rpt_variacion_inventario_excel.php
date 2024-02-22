<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	$Consulta = "select valor_subclase1 as mostrar_otros_inv from proyecto_modernizacion.sub_clase where cod_clase='31044' and cod_subclase='".$CmbGrupo."' ";			
	$Resp=mysql_query($Consulta);
	while ($FilaTC=mysql_fetch_array($Resp))
	{
		$MostrarOtrosInv=$FilaTC["mostrar_otros_inv"];
	}
if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');	
?>
<html>
<head>
<title>Reporte Variaci�n Inventario</title>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td  align="center"><? 
			$Consulta = "select nom_asignacion from pcip_svp_asignacion where cod_asignacion='".$CmbAsig."' ";			
			$Resp=mysql_query($Consulta);
			if ($Fila=mysql_fetch_array($Resp))
				echo $Fila[nom_asignacion]."<br> [".$Unidad."]";?>
      </td>
      <td width="13%"  align="center">Inventario <? echo ucfirst($Meses[$Mes-2]).intval($Ano);?></td>
      <td width="13%"  align="center">Inventario Actual <? echo ucfirst($Meses[$Mes-1])." ".$Ano;?></td>
      <td width="1%" class="">&nbsp;</td>
      <td width="20%"  align="center">Inventario Final <? echo ucfirst($Meses[$Mes-1])." ".$Ano;?></td>
      <td width="10%"  align="center">Variacion MES</td>
      <td align="center" >Acumulado<br>
          <? echo ucfirst($Meses[$Mes-1])." ".$Ano;?></td>
      <td width="19%" align="center">PPTO <? echo ucfirst($Meses[$Mes-1])." ".$Ano;?></td>
    </tr>
    <tr>
      <td width="8%"></td>
    </tr>
    <?
	 $Buscar='S';
		  	if($Buscar=='S')
			{
				$Consulta="select t1.cod_area,t2.nombre_subclase as nom_area from pcip_svp_variacion_inventario t1 left join proyecto_modernizacion.sub_clase t2";
				$Consulta.=" on t2.cod_clase='31009' and t2.cod_subclase=t1.cod_area where cod_asignacion='".$CmbAsig."'";
				if($CmbArea!='-1')
					$Consulta.=" and t1.cod_area='".$CmbArea."'";
				if($CmbMaqui!='-1')
					$Consulta.=" and t1.cod_maquila='".$CmbMaqui."'";
				if($CmbProd!='-1')
					$Consulta.=" and t1.cod_producto='".$CmbProd."'";
				 $Consulta.=" group by cod_asignacion,cod_area ";
				$Resp=mysql_query($Consulta);
				//echo $Consulta;
				while($Fila=mysql_fetch_array($Resp))
				{
					$TotArea_4=0;$TotArea_3=0;$TotArea_2=0;$TotArea_1=0;$TotAreaFinal_1=0;$TotAreaFinal_2=0;$TotArea_Acu_2=0;
					$NomArea=$Fila[nom_area];$TotPptoArea=0;
					?>
					<tr>
					  <td colspan="14"><? echo "&nbsp;&nbsp;".str_replace(' ','&nbsp;',$Fila[nom_area]);?>&nbsp;</td>
					</tr>
					<?
					$Consulta1="select t1.cod_maquila,t2.nombre_subclase as nom_maquila from pcip_svp_variacion_inventario t1 left join proyecto_modernizacion.sub_clase t2";
					$Consulta1.=" on t2.cod_clase='31010' and t2.cod_subclase=t1.cod_maquila where cod_asignacion='".$CmbAsig."' ";
					$Consulta1.=" and cod_area='".$Fila[cod_area]."'";
					if($CmbMaqui!='-1')
						$Consulta1.=" and t1.cod_maquila='".$CmbMaqui."'";
					if($CmbProd!='-1')
						$Consulta1.=" and t1.cod_producto='".$CmbProd."'";
					$Consulta1.=" group by cod_maquila ";
					$Resp1=mysql_query($Consulta1);
					//echo $Consulta1;
					while($Fila1=mysql_fetch_array($Resp1))
					{
						$TotMaq_4=0;$TotMaq_3=0;$TotMaq_2=0;$TotMaq_1=0;$TotMaqFinal_1=0;$TotAcu_Maq_2=0;
						$NomMaquila=$Fila1[nom_maquila];
						?>
						<tr>
						  <td colspan="14"><? echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".str_replace(' ','&nbsp;',$Fila1[nom_maquila]);?></td>
						</tr>
						<?						
						$Consulta2="select t1.cod_producto,t2.nom_producto from pcip_svp_variacion_inventario t1 left join pcip_svp_productos_inventarios t2";
						$Consulta2.=" on t1.cod_producto=t2.cod_producto where cod_asignacion='".$CmbAsig."' and cod_area='".$Fila[cod_area]."' and cod_maquila='".$Fila1[cod_maquila]."'";
						if($CmbProd!='-1')
							$Consulta2.=" and t1.cod_producto='".$CmbProd."'";
						$Consulta2.=" group by cod_producto ";
						$Resp2=mysql_query($Consulta2);$TotProd_4=0;$TotProd_3=0;$TotProd_2=0;$TotProd_1=0;$TotProdFinal_1=0;$TotVar_Final_2=0;$Producto_1=0;$ProdAcu=0;$TotAcuProd_2=0;$TotPpto=0;
						//echo $Consulta2."<br>";
						while($Fila2=mysql_fetch_array($Resp2))
						{						   
							?>
						<tr>
						  <td><? echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".str_replace(' ','&nbsp;',$Fila2["nom_producto"]);?></td>
						  <td  align="right" ><? $var_2=ValoresIn($CmbAsig,$Fila[cod_area],$Fila1[cod_maquila],$Fila2["cod_producto"],intval($Ano),$Mes-1);echo number_format($var_2,3,',','.');?>
							&nbsp;</td>
						  <td  align="right" ><? $var_1=ValoresIn($CmbAsig,$Fila[cod_area],$Fila1[cod_maquila],$Fila2["cod_producto"],intval($Ano),$Mes);echo number_format($var_1,3,',','.');?>
							&nbsp;</td>
						  <td width="1%" class="">&nbsp;</td>
						  <td  align="right" ><?  $Producto_1=+$var_1; echo number_format($Producto_1,3,',','.');?>
							&nbsp;</td>
						  <td  align="right"><? $Producto_2=($Producto_1-$var_2); echo  number_format($Producto_2,3,',','.');?></td>
						  <td width="16%"  align="right"><?  $ProdAcu=+$Producto_2; echo  number_format($ProdAcu,3,',','.');?></td>
						  <td width="19%"  align="right" ><? $var_5=ValorPpto($CmbAsig,$Fila[cod_area],$Fila1[cod_maquila],$Fila2["cod_producto"],intval($Ano),$Mes);echo number_format($var_5,3,',','.');?>
							&nbsp;</td>
						</tr>
						<?							
							$TotProd_4=$TotProd_4+$var_4;
							$TotProd_2=$TotProd_2+$var_2;	
							$TotProd_3=$TotProd_3+$var_3;	
							$TotProd_1=$TotProd_1+$var_1;	
							$TotProdFinal_1=+$TotProd_1;	
							$TotPpto=$TotPpto+$var_5;	
							$TotVar_Final_2=$TotVar_Final_2+$Producto_2;																									
						}
						$TotMaq_4=$TotMaq_4+$TotProd_4;
						$TotMaq_3=$TotMaq_3+$TotProd_3;	
						$TotMaq_2=$TotMaq_2+$TotProd_2;	
						$TotMaq_1=$TotMaq_1+$TotProd_1;	
						$TotMaqFinal_1=+$TotMaq_1;	
						$TotAcu_Maq_2=$TotAcu_Maq_2+$TotVar_Final_2																								
						?>
					<tr>
					  <td>Total <? echo $NomMaquila?></td>
					  <td align="right"><? echo number_format($TotMaq_2,3,',','.');?>&nbsp;</td>
					  <td align="right"><? echo number_format($TotMaq_1,3,',','.');?>&nbsp;</td>
					  <td align="right">&nbsp;</td>
					  <td align="right"><? echo number_format($TotMaqFinal_1,3,',','.');?>&nbsp;</td>
					  <td align="right" ><? echo number_format($TotVar_Final_2,3,',','.');?>&nbsp;</td>
					  <td align="right" ><? echo number_format($TotAcu_Maq_2,3,',','.');?>&nbsp;</td>
					  <td width="19%"  align="right" ><? echo number_format($TotPpto,3,',','.');?>&nbsp;</td>
					</tr>
					<?
				$TotArea_4=$TotArea_4+$TotMaq_4;
				$TotArea_3=$TotArea_3+$TotMaq_3;	
				$TotArea_2=$TotArea_2+$TotMaq_2;	
				$TotArea_1=$TotArea_1+$TotMaq_1;
				$TotAreaFinal_1=+$TotArea_1;
				$TotAreaFinal_2=$TotAreaFinal_2+$TotVar_Final_2;		
				$TotPptoArea=$TotPptoArea+$TotPpto;																		                
					}
				?>
			<tr>
			  <td>Total <? echo $NomArea;?></td>
			  <td align="right"><? echo number_format($TotArea_2,3,',','.');?>&nbsp;</td>
			  <td align="right"><? echo number_format($TotArea_1,3,',','.');?>&nbsp;</td>
			  <td align="right">&nbsp;</td>
			  <td align="right"><? echo number_format($TotAreaFinal_1,3,',','.');?>&nbsp;</td>
			  <td align="right"><? echo number_format($TotAreaFinal_2,3,',','.');?>&nbsp;</td>
			  <td align="right"><? echo number_format($TotArea_Acu_2=$TotAreaFinal_1-$TotArea_2,3,',','.');?>&nbsp;</td>
			  <td width="19%"  align="right" ><? echo number_format($TotPptoArea,3,',','.');?>&nbsp;</td>
			</tr>
			<?
		 $Total_dato2=$Total_dato2+$TotArea_2;
		 $Total_dato1=$Total_dato1+$TotArea_1;
		 $TotAreaFin=$TotAreaFin+$TotAreaFinal_2;	
		}
		$Dato=ValoresInDiferencia($Ano,$Mes-1);
		$Diferencia2=$Dato-$Total_dato2;
		
		$Dato1=ValoresInDiferencia($Ano,$Mes);
		$Diferencia1=$Dato1-$Total_dato1;
		//echo 	$TotAreaFin."<br>";
		$DiferenciaTotal=+$Diferencia1;
		$DiferenciaTotal2=$Diferencia1-$Diferencia2;
		$AcumuladoDiferencia=$DiferenciaTotal-$Diferencia2;
		//echo $Diferencia2."<br>";
		$TotalInventario=$Total_dato1+$DiferenciaTotal;
		$TotalInventarioMes=$TotAreaFin+$DiferenciaTotal2;
		$TotAcumTotalInventario=$TotalInventario-$Dato;
		if($MostrarOtrosInv=='S')
		{
		?>
    <tr>
      <td>Otros Inventarios</td>
      <td align="right"><? echo number_format($Diferencia2,3,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($Diferencia1,3,',','.');?>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><? echo number_format($DiferenciaTotal,3,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($DiferenciaTotal2,3,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($AcumuladoDiferencia,3,',','.');?>&nbsp;</td>
      <td width="19%" align="right" >&nbsp;</td>
    </tr>
    <?
	}
	?>
	<tr>
      <td>Total Inventarios<? echo $Fila[nom_asignacion];?></td>
      <td align="right"><? echo number_format($Dato,3,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($Dato1,3,',','.');?>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right"><? echo number_format($TotalInventario,3,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($TotalInventarioMes,3,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($TotAcumTotalInventario,3,',','.');?>&nbsp;</td>
      <td width="19%"  align="right" >&nbsp;</td>
    </tr>
    <?
			}
			?>
  </table>
</form>
</body>
</html>
<?
function ValoresIn($Asig,$Area,$Maqui,$Prod,$Ano,$MesAux1)
{
	$Valor=0;
	$Consulta="select sum(t2.VPcantidad) as total ";
	$Consulta.="from pcip_svp_variacion_inventario t1 inner join pcip_svp_valorizacproduccion t2";
	$Consulta.=" on t1.num_orden=t2.VPorden and t1.vptm=t2.VPtm and t1.num_orden_relacionada=t2.VPordenrel and t1.cod_material=t2.VPmaterial";
	$Consulta.=" and t1.vptipinv=t2.VPtipinv";
	if($Area!='-1')
		$Consulta.=" and t1.cod_area='".$Area."'";
	if($Maqui!='-1')
		$Consulta.=" and t1.cod_maquila='".$Maqui."'";
	if($Prod!='-1')
		$Consulta.=" and t1.cod_producto='".$Prod."'";
	$Consulta.="where t2.VPa�o='".$Ano."' and VPmes='".$MesAux1."'";
	//echo $Consulta."<br>";
	$Respaux=mysql_query($Consulta);
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
	$Consulta.="from pcip_svp_variacion_inventario_ppto t1";
	$Consulta.=" where t1.cod_asignacion='".$Asig."'";
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
		
	//echo $Consulta."<br>";
	$Respaux=mysql_query($Consulta);
	if($Filaaux1=mysql_fetch_array($Respaux))
	{
		$ValorPpto=$Filaaux1["total"];
		
	}
	return($ValorPpto);
}
function ValoresInDiferencia($Ano,$MesAux1)
{
	$Valor=0;
	$Consulta="select sum(t2.VPcantidad) as total ";
	$Consulta.="from pcip_svp_valorizacproduccion t2";
	$Consulta.=" where  VPtm in ('25','21') and t2.VPa�o='".$Ano."' and VPmes='".$MesAux1."' and VPorden < 5500";
	//echo $Consulta."<br>";
	$Respaux=mysql_query($Consulta);
	if($Filaaux=mysql_fetch_array($Respaux))
	{
		$Valor=$Filaaux["total"];
		
	}
	return($Valor);
}

?>