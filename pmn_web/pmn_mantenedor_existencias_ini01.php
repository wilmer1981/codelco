<?php 	
	$CodigoDeSistema = 99;
	$CodigoDePantalla = 10;
	include("../principal/conectar_principal.php");
	include("funciones/pmn_funciones.php");
	if(!isset($TipoBusq))
		$TipoBusq='0';
		
		
	if($Graba=='S')
	{
		$Datos=explode('//',$Valores);
		while(list($c,$v)=each($Datos))
		{
			$Dato=explode('~',$v);
			$STIP=str_replace('.','',$Dato[1]);
			$STIP=str_replace(',','.',$STIP);
			$ProdP=str_replace('.','',$Dato[2]);
			$ProdP=str_replace(',','.',$ProdP);
			$BeneP=str_replace('.','',$Dato[3]);
			$BeneP=str_replace(',','.',$BeneP);
			$STFP=str_replace('.','',$Dato[4]);
			$STFP=str_replace(',','.',$STFP);
			$AjustePosiP=str_replace('.','',$Dato[5]);
			$AjustePosiP=str_replace(',','.',$AjustePosiP);
			$AjusteNegaP=str_replace('.','',$Dato[6]);
			$AjusteNegaP=str_replace(',','.',$AjusteNegaP);
			$ObservacionP=str_replace('.','',$Dato[7]);
			
			$STIC=str_replace('.','',$Dato[8]);
			$STIC=str_replace(',','.',$STIC);
			$ProdC=str_replace('.','',$Dato[9]);
			$ProdC=str_replace(',','.',$ProdC);
			$BeneC=str_replace('.','',$Dato[10]);
			$BeneC=str_replace(',','.',$BeneC);
			$STFC=str_replace('.','',$Dato[11]);
			$STFC=str_replace(',','.',$STFC);
			$AjustePosiC=str_replace('.','',$Dato[12]);
			$AjustePosiC=str_replace(',','.',$AjustePosiC);
			$AjusteNegaC=str_replace('.','',$Dato[13]);
			$AjusteNegaC=str_replace(',','.',$AjusteNegaC);
			$ObservacionC=str_replace('.','',$Dato[14]);

			$Consulta="select * from pmn_web.stock_pmn where ano='".$Ano."' and mes='".$Dato[0]."' and cod_producto='".$Productos."' and cod_subproducto='".$Subproductos."'";
			//echo 	$Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			if(!$Fila=mysqli_fetch_array($Resp))
			{
				if($ProdP=='0.00' && $BeneP=='0.00')
				{
					$STIP=0;$STFP=0;
				}	
				if($ProdC=='0.00' && $BeneC=='0.00')
				{
					$STIC=0;$STFC=0;
				}	
				$Inserta="INSERT INTO pmn_web.stock_pmn (ano,mes,cod_producto,cod_subproducto,si_p,pr_p,bn_p,sf_p,ajuste_posi_p,ajuste_nega_p,observacion_p,si_c,pr_c,bn_c,sf_c,ajuste_posi_c,ajuste_nega_c,observacion_c)";		
				$Inserta.=" values('".$Ano."','".$Dato[0]."','".$Productos."','".$Subproductos."','".$STIP."','".$ProdP."','".$BeneP."','".$STFP."','".$AjustePosiP."','".$AjusteNegaP."','".$ObservacionP."','".$STIC."','".$ProdC."','".$BeneC."','".$STFC."','".$AjustePosiC."','".$AjusteNegaC."','".$ObservacionC."')";	
				//echo 	$Inserta."<br>";
				mysqli_query($link, $Inserta);
			}
			else
			{
				if($Fila[si_p]!=$STIP)
				{
					$SFinalP=$Fila[si_p]+$Fila[pr_p]-$Fila[bn_p];
					//$MES=$Dato[0];
				}	
				else					
					$SFinalP=$STFP;	
				if($Fila[si_c]!=$STIC)
				{
					$SFinalC=$Fila[si_c]+$Fila[pr_c]-$Fila[bn_c];
					//$MES=$Dato[0];
				}	
				else					
					$SFinalC=$STFC;	
				/*if($Fila[observacion_p]!=$ObservacionP)
					$MES=$Dato[0];
				if($Fila[observacion_c]!=$ObservacionC)
					$MES=$Dato[0];*/
				
					
				if($ProdP=='0' && $BeneP=='0' && $STFP==0 && $AjustePosiP=='0' && $AjusteNegaP=='0')
				{
					$STIP=0;$SFinalP=0;
				}	
				else
				{
					$AjustePositivoGP=$Fila[ajuste_posi_p];	//ajuste positivo guardado peso
					$AjusteNegativoGP=$Fila[ajuste_nega_p];	//ajuste negativo guardado peso
					if($AjustePositivoGP!=$AjustePosiP)
						$SFinalP=$SFinalP-$AjustePositivoGP+$AjustePosiP;
					if($AjusteNegativoGP!=$AjusteNegaP)
						$SFinalP=$SFinalP+$AjusteNegativoGP-$AjusteNegaP;
				}
				if($ProdC=='0' && $BeneC=='0' && $STFC==0 && $AjustePosiC=='0' && $AjusteNegaC=='0')
				{
					$STIC=0;$SFinalC=0;
				}	
				else
				{
					$AjustePositivoGC=$Fila[ajuste_posi_c];	//ajuste positivo guardado cant
					$AjusteNegativoGC=$Fila[ajuste_nega_c];	//ajuste negativo guardado cant
					if($AjustePositivoGC!=$AjustePosiC)
						$SFinalC=$SFinalC-$AjustePositivoGC+$AjustePosiC;
					if($AjusteNegativoGC!=$AjusteNegaC)
						$SFinalC=$SFinalC+$AjusteNegativoGC-$AjusteNegaC;
				}
				/*if($Fila[sf_p]!=$SFinalP)					
					$MES=$Dato[0];
				if($Fila[sf_c]!=$SFinalC)					
					$MES=$Dato[0];*/
				
				if($ProdP=='')
					$ProdP=0;
				if($BeneP=='')
					$BeneP=0;
				if($ProdC=='')
					$ProdC=0;
				if($BeneC=='')
					$BeneC=0;
				$Actualiza="UPDATE pmn_web.stock_pmn set si_p='".$STIP."',pr_p='".$ProdP."',bn_p='".$BeneP."',sf_p='".$SFinalP."',si_c='".$STIC."',pr_c='".$ProdC."',bn_c='".$BeneC."',sf_c='".$SFinalC."'";
				$Actualiza.=",ajuste_posi_p='".$AjustePosiP."',ajuste_nega_p='".$AjusteNegaP."',observacion_p='".$ObservacionP."'";
				$Actualiza.=",ajuste_posi_c='".$AjustePosiC."',ajuste_nega_c='".$AjusteNegaC."',observacion_c='".$ObservacionC."'";
				$Actualiza.=" where ano='".$Ano."' and mes='".$Dato[0]."' and cod_producto='".$Productos."' and cod_subproducto='".$Subproductos."'";		
				//echo $Actualiza."<br>";
				mysqli_query($link, $Actualiza);
			}
		}
		RecarlculaStockMantenedorExiste($Ano,$Mes,$Productos,$Subproductos);
		//header('location:pmn_mantenedor_existencias_ini.php?Ano='.$Ano.'&Productos='.$Productos.'&Subproductos='.$Subproductos);
		?>
		<script language="javascript">
		location.replace("pmn_mantenedor_existencias_ini.php?Ano=<?php echo $Ano;?>&Productos=<?php echo $Productos;?>&Subproductos=<?php echo $Subproductos;?>");
		</script>
		<?php
	}
	
function RecarlculaStockMantenedorExiste($Ano,$Mes,$Prod,$SubProd)
{
	for($i=$Mes;$i<=12;$i++)
	{
		$MesMas=$i+1;
		$Consulta2="select sf_p,sf_c from pmn_web.stock_pmn where ano='".$Ano."' and mes='".$i."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
		$Resp2=mysqli_query($link, $Consulta2);
		if($Fila2=mysqli_fetch_assoc($Resp2))
		{
			$ValorInicialP2=$Fila2[sf_p];
			$ValorInicialC2=$Fila2[sf_c];
		}
		if($MesMas<12)
		{			
			$Consulta="select * from pmn_web.stock_pmn where ano='".$Ano."' and mes='".$MesMas."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";	
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_assoc($Resp))
			{								
				$STockFinal1=$ValorInicialP2+$Fila[pr_p]-$Fila[bn_p]+$Fila[ajuste_posi_p]-$Fila[ajuste_nega_p];
				$STockFinal2=$ValorInicialC2+$Fila[pr_c]-$Fila[bn_c]+$Fila[ajuste_posi_c]-$Fila[ajuste_nega_c];
				//if($Fila[si_p]=='0' || $Fila[si_c]=='0')
				//{
					if($Fila[pr_p]=='0' && $Fila[bn_p]=='0')
					{
						$ValorInicialP2=0;$STockFinal1=0;
					}	
					if($Fila[pr_c]=='0' && $Fila[bn_c]=='0')
					{
						$ValorInicialC2=0;$STockFinal2=0;
					}	
					$Update="UPDATE pmn_web.stock_pmn set si_p='".$ValorInicialP2."', sf_p='".$STockFinal1."',si_c='".$ValorInicialC2."', sf_c='".$STockFinal2."' where ano='".$Ano."' and mes='".$MesMas."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";																				
					mysqli_query($link, $Update);
				//}
			}	
			else
			{
				$Inserta="INSERT INTO pmn_web.stock_pmn values('".$Ano."','".$MesMas."','".$Prod."','".$SubProd."','0','0','0','0','0','0','0','0')";
				mysqli_query($link, $Inserta);
			}	
		}
		if($i=='12' && $ValorInicialP2!='0')//si mes diciembre de año, tiene valor final, este se inserta en el mes de enero del proximo año y recalcula.
		{
			$AnoProx=date('Y-m',mktime(0,0,0,$i+1,1,$Ano));
			$AnoProx=explode('-',$AnoProx);
			
			$Consulta3="select pr_p,bn_p,pr_c,bn_c from pmn_web.stock_pmn where ano='".$AnoProx[0]."' and mes='".$AnoProx[1]."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
			$Resp3=mysqli_query($link, $Consulta3);
			if($Fila3=mysqli_fetch_assoc($Resp3))
			{
				$STockFinaProx1=$ValorInicialP2+$Fila3[pr_p]-$Fila3[bn_p];
				$STockFinaProx2=$ValorInicialC2+$Fila3[pr_c]-$Fila3[bn_c];
				$Update="UPDATE pmn_web.stock_pmn set si_p='".$ValorInicialP2."', sf_p='".$STockFinaProx1."',si_c='".$ValorInicialC2."', sf_c='".$STockFinaProx2."' where ano='".$AnoProx[0]."' and mes='".$AnoProx[1]."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";																				
				mysqli_query($link, $Update);
				RecarlculaStockMantenedorExiste($AnoProx[0],'1',$Prod,$SubProd);
			}
			else
			{
				$Inserta="INSERT INTO pmn_web.stock_pmn values('".$AnoProx[0]."','".$AnoProx[1]."','".$Prod."','".$SubProd."','".$ValorInicialP2."','0','0','".$ValorInicialP2."','".$ValorInicialC2."','0','0','".$ValorInicialC2."')";
				mysqli_query($link, $Inserta);
			}
		}
	}
}			
?>