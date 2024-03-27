<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
<tr>
<td width="20%" class="TituloTablaVerde" align="center" rowspan="2">Cobre Divisi&oacute;n Ventanas</td>
<?
for($i=$Mes;$i<=$MesFin;$i++)
{
?>
<td width="7%" class="TituloTablaVerde"align="center" colspan="2"><? echo $Meses[$i-1]?></td>
<?	
}
?>
</tr>
<tr>
<?
for($i=$Mes;$i<=$MesFin;$i++)
{
?>
<td width="7%" class="TituloTablaVerde" align="center" >Real</td>
<td width="7%" class="TituloTablaVerde" align="center">Proyectado</td>
<?	
$ArrTotal1[$i][0]=0;
$ArrTotal2Real[$i][0]=0;
$ArrTotal2Ppto[$i][0]=0;
$ArrTotalComercial[$i][0]=0;
$ArrTotalReal[$i][0]=0;
$ArrTotalPpto[$i][0]=0;
$ArrTotalRealPagable[$i][0]=0;
$ArrTotalPptoPagable[$i][0]=0;
$ArrTotalRealPagable1[$i][0]=0;
$ArrTotalPptoPagable1[$i][0]=0;
$ArrTotalMetalurgia[$i][0]=0;
}
?>
</tr>
<?	
$Buscar='S';	
if($Buscar=='S')
{	
?>  
	<tr>
	  <td colspan="25" rowspan="1" align="left" class="formulario2">Producci&oacute;n de C&aacute;todos</td>
	</tr>
	<tr class="FilaAbeja">
	  <td rowspan="1" align="left">&nbsp;A</td>
		<?
		for($i=$Mes;$i<=$MesFin;$i++)
		{
		$Valor1=DatosProyectados('1','7',$Ano,$i);
		$Valor2=DatosProyectados('1','8',$Ano,$i);
		$ValorReal=$Valor1+$Valor2;
		$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorReal;
		$ValorHVL=DatosProyectados('1','9',$Ano,$i);
		$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorHVL;	
		$ValorSurAndes=DatosProyectados('1','10',$Ano,$i);
		$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorSurAndes;
		$ValorBlisterSalvador=DatosProyectados('1','11',$Ano,$i);
		$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorBlisterSalvador;
		$ValorCuconsTte=DatosProyectados('1','1',$Ano,$i);
		$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorCuconsTte;
		$ValorAndina=DatosProyectados('1','2',$Ano,$i);
		$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorAndina;
		$ValorCN=DatosProyectados('1','3',$Ano,$i);
		$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorCN;
		$ValorCuSurAndes=DatosProyectados('1','6',$Ano,$i);
		$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorCuSurAndes;
		$ValorCuEnami=DatosProyectados('1','4',$Ano,$i);
		$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorCuEnami;	
		$ValorPrecipitado=DatosProyectados('1','5',$Ano,$i);
		$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorPrecipitado;
		$A=$ArrTotal1[$i][0];	
		?>
	    <td rowspan="1" align="right"><?  echo number_format($A,0,',','.');?>&nbsp;</td>
	    <td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
		<?
		$ArrTotalComercial[$i][0]=$ArrTotalComercial[$i][0]+$A;	
		}
		?>
	</tr>
	<tr class="FilaAbeja">
	  <td rowspan="1" align="left">&nbsp;Rechazo, L&aacute;m. y Desp.</td>
		<?
		for($i=$Mes;$i<=$MesFin;$i++)
		{
		$ValorRechazoReal=DatosProyectados('2','12',$Ano,$i);
		$ValorRechazoReal1=DatosProyectados('2','13',$Ano,$i);
        $Rechazo=$ValorRechazoReal+$ValorRechazoReal1;
		?>
		<td rowspan="1" align="right"><?  echo number_format($Rechazo,0,',','.');?>&nbsp;</td>
		<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
		<?
		$ArrTotalComercial[$i][0]=$ArrTotalComercial[$i][0]+$Rechazo;
		}
		?>
	</tr>
	<tr class="FilaAbeja">
	  <td rowspan="1" align="left">&nbsp;Est&aacute;ndar (Descobrizaci&oacute;n)</td>
		<?
		for($i=$Mes;$i<=$MesFin;$i++)
		{
		$ValorPrecipitado=DatosProyectados('2','14',$Ano,$i);
		$Estandar=$ValorPrecipitado;
		?>
		<td rowspan="1" align="right"><?  echo number_format($Estandar,0,',','.');?>&nbsp;</td>
		<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
		<?
		$ArrTotalComercial[$i][0]=$ArrTotalComercial[$i][0]+$Estandar;
		}
		?>
	</tr>
	<tr class="FilaAbeja">
	  <td rowspan="1" align="left">Total comercial</td>
		<?
		for($i=$Mes;$i<=$MesFin;$i++)
		{
		$TotalComercial=$ArrTotalComercial[$i][0];
		?>
		<td rowspan="1" align="right"><?  echo number_format($TotalComercial,0,',','.');?>&nbsp;</td>
		<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
		<?
		}
		?>
	 </tr>
			<tr>
			<td colspan="25" rowspan="1" align="left" class="formulario2">Destinos producci&oacute;n c&aacute;todos A</td>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;Ex anodos TTE</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			 $ValorReal=0; 
			 $Valor1=DatosProyectados('1','7',$Ano,$i);
			 $Valor2=DatosProyectados('1','8',$Ano,$i);
			 $ValorReal=$Valor1+$Valor2;
			 $ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorReal;
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;Ex &aacute;nodos HVL</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			 $ValorHVL=DatosProyectados('1','9',$Ano,$i);
			 $ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorHVL;			 
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorHVL,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;Ex &aacute;nodos Sur Andes</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$ValorSurAndes=0;
			$ValorSurAndes=DatosProyectados('1','10',$Ano,$i);
			$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorSurAndes;
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorSurAndes,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
			<?			
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;Ex Bl&iacute;ster Salvador</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$ValorBlisterSalvador=0;
			$ValorBlisterSalvador=DatosProyectados('1','11',$Ano,$i);
			$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorBlisterSalvador;
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorBlisterSalvador,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
			<?		
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;Ex cucons TTE</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$ValorCuconsTte=0;
			$ValorCuconsTte=DatosProyectados('1','1',$Ano,$i);
			$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorCuconsTte;
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorCuconsTte,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
			<?
			
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;Ex cucons Andina</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$ValorAndina=0; 
			$ValorAndina=DatosProyectados('1','2',$Ano,$i);
			$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorAndina;			
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorAndina,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;Ex cucons CN</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$ValorCN=0;
			$ValorCN=DatosProyectados('1','3',$Ano,$i);
			$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorCN;			
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorCN,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
			<?
			}
			?>
			</tr> 
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;Ex cucons Sur Andes</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$ValorCuSurAndes=0;
			$ValorCuSurAndes=DatosProyectados('1','6',$Ano,$i);
			$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorCuSurAndes;			
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorCuSurAndes,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;Ex cucons  Enami</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$ValorCuEnami=0;
			$ValorCuEnami=DatosProyectados('1','4',$Ano,$i);
			$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorCuEnami;						
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorCuEnami,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;Ex precipitados Enami</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$ValorPrecipitado=0;
			$ValorPrecipitado=DatosProyectados('1','5',$Ano,$i);
			$ArrTotal1[$i][0]=$ArrTotal1[$i][0]+$ValorPrecipitado;						
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorPrecipitado,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="TituloTablaVerde">
			<td rowspan="1" align="left" >SubTotal Total</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{	
			$Total=$ArrTotal1[$i][0];					
			?>
			<td rowspan="1" align="right"><? echo number_format($Total,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><? echo "Proyectado TOTAL";?>&nbsp;</td>
			<?
			}
			?>
			</tr>
				<tr>
				<td colspan="25" rowspan="1" align="left" class="formulario2">Destino producci&oacute;n c&aacute;todos est&aacute;ndar</td>
				</tr>
				<tr class="FilaAbeja">
				<td rowspan="1" align="left">&nbsp;Ex &aacute;nodos Sur Andes</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{
				$ValorRechazoReal=DatosProyectados('2','12',$Ano,$i);
				$ValorExAnodoSurAndes=$ValorRechazoReal;
				//$ValorExAnodoSurAndes=1869;
				?>
				<td rowspan="1" align="right"><?  echo number_format($ValorExAnodoSurAndes,0,',','.');?>&nbsp;</td>
				<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
				<?
				}
				?>
				</tr>
				<tr>
				<td colspan="25" rowspan="1" align="left" class="formulario2">Destino producci&oacute;n despuntes y l&aacute;minas</td>
				</tr>
				<tr class="FilaAbeja">
				<td rowspan="1" align="left">&nbsp;Ex &aacute;nodos Sur Andes</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{
				$ValorPrecipitado=DatosProyectados('2','14',$Ano,$i);
				$ValorProduccionDespuntes=$ValorPrecipitado;
				//$ValorProduccionDespuntesReal=76;
				?>
				<td rowspan="1" align="right"><?  echo number_format($ValorProduccionDespuntesReal,0,',','.');?>&nbsp;</td>
				<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
				<?
				}
				?>
				</tr>
				<tr>
				<td colspan="25" rowspan="1" align="left" class="formulario2">Destino producci�n de Scrap</td>
				</tr>
				<tr class="FilaAbeja">
				<td rowspan="1" align="left">&nbsp;Ex �nodos Teniente</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{
				$ValorTenienteReal=DatosProyectados('6','23',$Ano,$i);
				$ValorRealProduccionScrapTeniente=$ValorTenienteReal;
				//$ValorRealProduccionScrapTeniente=1495;				
				?>
				<td rowspan="1" align="right"><?  echo number_format($ValorRealProduccionScrapTeniente,0,',','.');?>&nbsp;</td>
				<td rowspan="1" align="right"><?  echo "Proyectado";?>&nbsp;</td>
				<?
				}
				?>
				</tr>
				<tr class="TituloTablaVerde">
				<td rowspan="1" align="left" >Margen metal�rgico</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{
						$TotalComercial=$ArrTotalComercial[$i][0];
						$ArrTotalMetalurgia[$i][0]=$ArrTotalMetalurgia[$i][0]+$TotalComercial;
						//echo "Total comercial ".$TotalComercial."<br>";
						$ValorRealProduccionScrapTeniente=$ValorTenienteReal;	
						$ArrTotalMetalurgia[$i][0]=$ArrTotalMetalurgia[$i][0]+$ValorRealProduccionScrapTeniente;
						//echo "valor scrap  ".$ValorRealProduccionScrapTeniente."<br>";
						$DatoEnamiReal1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','R');
						$DatoEnamiReal2=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','R');
						$DatoEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','COBRE','R');
						$ValorRealEnami=($DatoEnamiReal1-$DatoEnamiReal2)*$DatoEnamiReal3;
						$DatoRealPagableEnami=$ValorRealEnami*(1-$Numero1);
						$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagableEnami;

						$DatoPrecipitadoReal1=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','R');
						$DatoPrecipitadoReal2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');
						$DatoPrecipitadoReal3=DatosProyectadosTratam($Ano,$i,'2','7','COBRE','R');
						$ValorRealPrecipitado=($DatoPrecipitadoReal1-$DatoPrecipitadoReal2)*$DatoPrecipitadoReal3;
						$DatoRealPagablePrecipitado=$ValorRealPrecipitado*(1-$Numero2);
						$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagablePrecipitado;					

						$DatoSurAndesReal1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','R');
						$DatoSurAndesReal2=DatosProyectadosTratam($Ano,$i,'1','2','COBRE','R');
						$ValorSurAndesReal=$DatoSurAndesReal1*$DatoSurAndesReal2;
						$DatoRealPagableSurAndes=$ValorSurAndesReal*(1-$Numero1);
						$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagableSurAndes;					

						$DatoTenienteReal1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','R');
						$DatoTenienteReal2=DatosProyectadosTratam($Ano,$i,'1','3','COBRE','R');
						$ValorTenienteReal=$DatoTenienteReal1*$DatoTenienteReal2;
						$DatoRealPagableTeniente=$ValorTenienteReal*(1-$Numero1);
						$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagableTeniente;

						$DatoAndinaReal1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','R');
						$DatoAndinaReal2=DatosProyectadosTratam($Ano,$i,'1','4','COBRE','R');
						$ValorAndinaReal=$DatoAndinaReal1*$DatoAndinaReal2;
						$DatoRealPagableAndina=$ValorAndinaReal*(1-$Numero1);
						$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagableAndina;

						$DatoCodelcoNorteReal1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','R');
						$DatoCodelcoNorteReal2=DatosProyectadosTratam($Ano,$i,'1','5','COBRE','R');
						$ValorCodelcoNorteReal=$DatoCodelcoNorteReal1*$DatoCodelcoNorteReal2;
						$DatoRealPagableCodelcoNorte=$ValorCodelcoNorteReal*(1-$Numero1);
						$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagableCodelcoNorte;
						
						$TotalPagableReal=$ArrTotalRealPagable[$i][0];//Total Cucons Finos Pagable
						
						$ValorRealContenidoEnami=DatosProyectadosTratam($Ano,$i,'3','1','COBRE (Fino)','R');
						$DatoRealPagableEnami=$ValorRealContenidoEnami*(1-$Numero3);
						$ArrTotalRealPagable1[$i][0]=$ArrTotalRealPagable1[$i][0]+$DatoRealPagableEnami;
						
						$ValorRealContenidoSurAndes=DatosProyectadosTratam($Ano,$i,'3','2','COBRE (Fino)','R');
						$DatoRealPagableSurAndes=$ValorRealContenidoSurAndes*(1-$Numero3);
						$ArrTotalRealPagable1[$i][0]=$ArrTotalRealPagable1[$i][0]+$DatoRealPagableSurAndes;
						
						$ValorRealContenidoTeniente=DatosProyectadosTratam($Ano,$i,'3','3','COBRE (Fino)','R');
						$DatoRealPagableTeniente=$ValorRealContenidoTeniente*(1-$Numero3);
						$ArrTotalRealPagable1[$i][0]=$ArrTotalRealPagable1[$i][0]+$DatoRealPagableTeniente;
						
						$ValorReal1=DatosProyectadosTratam($Ano,$i,'2','8','COBRE (Fino)','R');
						$ValorReal2=DatosProyectadosTratam($Ano,$i,'2','9','COBRE (Fino)','R');
						$ValorRealContenidoBl�ster=$ValorReal1+$ValorReal2;
						$DatoRealPagableBlister=$ValorRealContenidoBl�ster*(1-$Numero3);
						$ArrTotalRealPagable1[$i][0]=$ArrTotalRealPagable1[$i][0]+$DatoRealPagableBlister;						
						
						$TotalPagableReal1=$ArrTotalRealPagable1[$i][0];// Total Anodos y Blister Pagable
						
						$TotalPagableGeneralReal=$TotalPagableReal+$TotalPagableReal1;	
						//echo $TotalPagableGeneralReal;
												
						$TotalMargenMetalurgicoReal=$ArrTotalMetalurgia[$i][0]-$TotalPagableGeneralReal;//Total Margen Metalurgico
				?>
				<td rowspan="1" align="right"><? echo number_format($TotalMargenMetalurgicoReal,0,',','.');?>&nbsp;</td>
				<td rowspan="1" align="right"><? echo "Proyectado";?>&nbsp;</td>
				<?
				$ArrTotalRealPagable[$i][0]=0;
				$ArrTotalRealPagable1[$i][0]=0;
				}
				?>
				</tr>
					<tr>
					<td colspan="25" rowspan="1" align="left" class="formulario2">Cucons (finos) [t]</td>
					</tr>
					<tr>
					<td colspan="25" rowspan="1" align="left" class="formulario2">Contenido</td>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Enami</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoEnamiReal1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','R');
					$DatoEnamiReal2=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','R');
					$DatoEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','COBRE','R');
					$ValorRealEnami=($DatoEnamiReal1-$DatoEnamiReal2)*$DatoEnamiReal3;
					$ArrTotalReal[$i][0]=$ArrTotalReal[$i][0]+$ValorRealEnami;	
					
					$DatoEnamiPpto1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','P');
					$DatoEnamiPpto2=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','P');
					$DatoEnamiPpto3=DatosProyectadosTratam($Ano,$i,'1','1','COBRE','P');
					$ValorPptoEnami=($DatoEnamiPpto1-$DatoEnamiPpto2)*$DatoEnamiPpto3;					
					$ArrTotalPpto[$i][0]=$ArrTotalPpto[$i][0]+$ValorPptoEnami;			
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorRealEnami,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorPptoEnami,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Enami Precipitado</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoPrecipitadoReal1=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','R');
					$DatoPrecipitadoReal2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');
					$DatoPrecipitadoReal3=DatosProyectadosTratam($Ano,$i,'2','7','COBRE','R');
					$ValorRealPrecipitado=($DatoPrecipitadoReal1-$DatoPrecipitadoReal2)*$DatoPrecipitadoReal3;
					$ArrTotalReal[$i][0]=$ArrTotalReal[$i][0]+$ValorRealPrecipitado;
					
					$DatoPrecipitadoPpto1=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','P');
					$DatoPrecipitadoPpto2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','P');
					$DatoPrecipitadoPpto3=DatosProyectadosTratam($Ano,$i,'2','7','COBRE','P');
					$ValorPptoPrecipitado=($DatoPrecipitadoPpto1-$DatoPrecipitadoPpto2)*$DatoPrecipitadoPpto3;	
					$ArrTotalPpto[$i][0]=$ArrTotalPpto[$i][0]+$ValorPptoPrecipitado;									
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorRealPrecipitado,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorPptoPrecipitado,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Sur Andes</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoSurAndesReal1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','R');
					$DatoSurAndesReal2=DatosProyectadosTratam($Ano,$i,'1','2','COBRE','R');
					$ValorSurAndesReal=$DatoSurAndesReal1*$DatoSurAndesReal2;
					$ArrTotalReal[$i][0]=$ArrTotalReal[$i][0]+$ValorSurAndesReal;
					
					$DatoSurAndesPpto1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','P');
					$DatoSurAndesPpto2=DatosProyectadosTratam($Ano,$i,'1','2','COBRE','P');
					$ValorSurAndesPpto=$DatoSurAndesPpto1*$DatoSurAndesPpto2;	
					$ArrTotalPpto[$i][0]=$ArrTotalPpto[$i][0]+$ValorSurAndesPpto;				
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorSurAndesReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorSurAndesPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Teniente</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoTenienteReal1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','R');
					$DatoTenienteReal2=DatosProyectadosTratam($Ano,$i,'1','3','COBRE','R');
					$ValorTenienteReal=$DatoTenienteReal1*$DatoTenienteReal2;
					$ArrTotalReal[$i][0]=$ArrTotalReal[$i][0]+$ValorTenienteReal;
					
					$DatoTenientePpto1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','P');
					$DatoTenientePpto2=DatosProyectadosTratam($Ano,$i,'1','3','COBRE','P');
					$ValorTenientePpto=$DatoTenientePpto1*$DatoTenientePpto2;
					$ArrTotalPpto[$i][0]=$ArrTotalPpto[$i][0]+$ValorTenientePpto;					
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorTenienteReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorTenientePpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Andina</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoAndinaReal1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','R');
					$DatoAndinaReal2=DatosProyectadosTratam($Ano,$i,'1','4','COBRE','R');
					$ValorAndinaReal=$DatoAndinaReal1*$DatoAndinaReal2;
					$ArrTotalReal[$i][0]=$ArrTotalReal[$i][0]+$ValorAndinaReal;
					
					$DatoAndinaPpto1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','P');
					$DatoAndinaPpto2=DatosProyectadosTratam($Ano,$i,'1','4','COBRE','P');
					$ValorAndinaPpto=$DatoAndinaPpto1*$DatoAndinaPpto2;	
					$ArrTotalPpto[$i][0]=$ArrTotalPpto[$i][0]+$ValorAndinaPpto;				
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorAndinaReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorAndinaPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Codelco Norte</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoCodelcoNorteReal1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','R');
					$DatoCodelcoNorteReal2=DatosProyectadosTratam($Ano,$i,'1','5','COBRE','R');
					$ValorCodelcoNorteReal=$DatoCodelcoNorteReal1*$DatoCodelcoNorteReal2;
					$ArrTotalReal[$i][0]=$ArrTotalReal[$i][0]+$ValorCodelcoNorteReal;
					
					$DatoCodelcoNortePpto1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','P');
					$DatoCodelcoNortePpto2=DatosProyectadosTratam($Ano,$i,'1','5','COBRE','P');
					$ValorCodelcoNortePpto=$DatoCodelcoNortePpto1*$DatoCodelcoNortePpto2;	
					$ArrTotalPpto[$i][0]=$ArrTotalPpto[$i][0]+$ValorCodelcoNortePpto;				
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorCodelcoNorteReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorCodelcoNortePpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="TituloTablaVerde">
					<td rowspan="1" align="left" >&nbsp;Total</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$TotalReal=$ArrTotalReal[$i][0];
					$TotalPpto=$ArrTotalPpto[$i][0];
					?>
					<td rowspan="1" align="right"><?  echo number_format($TotalReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($TotalPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr>
					<td colspan="25" rowspan="1" align="left" class="formulario2">Pagable</td>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Enami</td>
					<?
					$Numero1=0.034;
					$Numero2=0.04;
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoEnamiReal1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','R');
					$DatoEnamiReal2=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','R');
					$DatoEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','COBRE','R');
					$ValorRealEnami=($DatoEnamiReal1-$DatoEnamiReal2)*$DatoEnamiReal3;
					$DatoRealPagableEnami=$ValorRealEnami*(1-$Numero1);
					$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagableEnami;
					
					$DatoEnamiPpto1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','P');
					$DatoEnamiPpto2=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','P');
					$DatoEnamiPpto3=DatosProyectadosTratam($Ano,$i,'1','1','COBRE','P');
					$ValorPptoEnami=($DatoEnamiPpto1-$DatoEnamiPpto2)*$DatoEnamiPpto3;										
					$DatoPptoPagableEnami=$ValorPptoEnami*(1-$Numero1);					
					$ArrTotalPptoPagable[$i][0]=$ArrTotalPptoPagable[$i][0]+$DatoPptoPagableEnami;
					?>
					<td rowspan="1" align="right"><?  echo number_format($DatoRealPagableEnami,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($DatoPptoPagableEnami,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Enami Precipitado</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoPrecipitadoReal1=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','R');
					$DatoPrecipitadoReal2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');
					$DatoPrecipitadoReal3=DatosProyectadosTratam($Ano,$i,'2','7','COBRE','R');
					$ValorRealPrecipitado=($DatoPrecipitadoReal1-$DatoPrecipitadoReal2)*$DatoPrecipitadoReal3;
					$DatoRealPagablePrecipitado=$ValorRealPrecipitado*(1-$Numero2);
					$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagablePrecipitado;					
					
					$DatoPrecipitadoPpto1=DatosProyectadosTratam($Ano,$i,'2','7','SECO RE','P');
					$DatoPrecipitadoPpto2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','P');
					$DatoPrecipitadoPpto3=DatosProyectadosTratam($Ano,$i,'2','7','COBRE','P');
					$ValorPptoPrecipitado=($DatoPrecipitadoPpto1-$DatoPrecipitadoPpto2)*$DatoPrecipitadoPpto3;	
					$DatoPptoPagablePrecipitado=$ValorPptoPrecipitado*(1-$Numero2);	
					$ArrTotalPptoPagable[$i][0]=$ArrTotalPptoPagable[$i][0]+$DatoPptoPagablePrecipitado;									
					?>
					<td rowspan="1" align="right"><?  echo number_format($DatoRealPagablePrecipitado,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($DatoPptoPagablePrecipitado,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Sur Andes</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoSurAndesReal1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','R');
					$DatoSurAndesReal2=DatosProyectadosTratam($Ano,$i,'1','2','COBRE','R');
					$ValorSurAndesReal=$DatoSurAndesReal1*$DatoSurAndesReal2;
					$DatoRealPagableSurAndes=$ValorSurAndesReal*(1-$Numero1);
					$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagableSurAndes;					
					
					$DatoSurAndesPpto1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','P');					
					$DatoSurAndesPpto2=DatosProyectadosTratam($Ano,$i,'1','2','COBRE','P');
					$ValorSurAndesPpto=$DatoSurAndesPpto1*$DatoSurAndesPpto2;	
					$DatoPptoPagableSurAndes=$ValorSurAndesPpto*(1-$Numero1);
					$ArrTotalPptoPagable[$i][0]=$ArrTotalPptoPagable[$i][0]+$DatoPptoPagableSurAndes;									
					?>
					<td rowspan="1" align="right"><?  echo number_format($DatoRealPagableSurAndes,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($DatoPptoPagableSurAndes,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Teniente</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoTenienteReal1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','R');
					$DatoTenienteReal2=DatosProyectadosTratam($Ano,$i,'1','3','COBRE','R');
					$ValorTenienteReal=$DatoTenienteReal1*$DatoTenienteReal2;
					$DatoRealPagableTeniente=$ValorTenienteReal*(1-$Numero1);
					$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagableTeniente;
					
					$DatoTenientePpto1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','P');
					$DatoTenientePpto2=DatosProyectadosTratam($Ano,$i,'1','3','COBRE','P');
					$ValorTenientePpto=$DatoTenientePpto1*$DatoTenientePpto2;
					$DatoPptoPagableTeniente=$ValorTenientePpto*(1-$Numero1);
					$ArrTotalPptoPagable[$i][0]=$ArrTotalPptoPagable[$i][0]+$DatoPptoPagableTeniente;
					?>
					<td rowspan="1" align="right"><?  echo number_format($DatoRealPagableTeniente,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($DatoPptoPagableTeniente,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Andina</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoAndinaReal1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','R');
					$DatoAndinaReal2=DatosProyectadosTratam($Ano,$i,'1','4','COBRE','R');
					$ValorAndinaReal=$DatoAndinaReal1*$DatoAndinaReal2;
					$DatoRealPagableAndina=$ValorAndinaReal*(1-$Numero1);
					$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagableAndina;
					
					$DatoAndinaPpto1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','P');
					$DatoAndinaPpto2=DatosProyectadosTratam($Ano,$i,'1','4','COBRE','P');
					$ValorAndinaPpto=$DatoAndinaPpto1*$DatoAndinaPpto2;	
					$DatoPptoPagableAndina=$ValorAndinaPpto*(1-$Numero1);
					$ArrTotalPptoPagable[$i][0]=$ArrTotalPptoPagable[$i][0]+$DatoPptoPagableAndina;					
					?>
					<td rowspan="1" align="right"><?  echo number_format($DatoRealPagableAndina,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($DatoPptoPagableAndina,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;Codelco Norte</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoCodelcoNorteReal1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','R');
					$DatoCodelcoNorteReal2=DatosProyectadosTratam($Ano,$i,'1','5','COBRE','R');
					$ValorCodelcoNorteReal=$DatoCodelcoNorteReal1*$DatoCodelcoNorteReal2;
					$DatoRealPagableCodelcoNorte=$ValorCodelcoNorteReal*(1-$Numero1);
					$ArrTotalRealPagable[$i][0]=$ArrTotalRealPagable[$i][0]+$DatoRealPagableCodelcoNorte;
					
					$DatoCodelcoNortePpto1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','P');
					$DatoCodelcoNortePpto2=DatosProyectadosTratam($Ano,$i,'1','5','COBRE','P');
					$ValorCodelcoNortePpto=$DatoCodelcoNortePpto1*$DatoCodelcoNortePpto2;	
					$DatoPptoPagableCodelcoNorte=$ValorCodelcoNortePpto*(1-$Numero1);	
					$ArrTotalPptoPagable[$i][0]=$ArrTotalPptoPagable[$i][0]+$DatoPptoPagableCodelcoNorte;								
					?>
					<td rowspan="1" align="right"><?  echo number_format($DatoRealPagableCodelcoNorte,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($DatoPptoPagableCodelcoNorte,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="TituloTablaVerde">
					<td rowspan="1" align="left">&nbsp;Total</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$TotalPagableReal=$ArrTotalRealPagable[$i][0];
					$TotalPagablePpto=$ArrTotalPptoPagable[$i][0];
					?>
					<td rowspan="1" align="right"><?  echo number_format($TotalPagableReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($TotalPagablePpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
						<tr>
						<td colspan="25" rowspan="1" align="left" class="formulario2">�nodos y bl�ster  (finos) [t]</td>
						</tr>
						<tr>
						<td colspan="25" rowspan="1" align="left" class="formulario2">Contenido</td>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;Enami</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$ValorRealContenidoEnami=DatosProyectadosTratam($Ano,$i,'3','1','COBRE (Fino)','R');
						$ArrTotal2Real[$i][0]=$ArrTotal2Real[$i][0]+$ValorRealContenidoEnami;
						
						$ValorPptoContenidoEnami=DatosProyectadosTratam($Ano,$i,'3','1','COBRE (Fino)','P');
						$ArrTotal2Ppto[$i][0]=$ArrTotal2Ppto[$i][0]+$ValorPptoContenidoEnami;
						?>
						<td rowspan="1" align="right"><?  echo number_format($ValorRealContenidoEnami,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($ValorPptoContenidoEnami,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;Sur Andes</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$ValorRealContenidoSurAndes=DatosProyectadosTratam($Ano,$i,'3','2','COBRE (Fino)','R');
						$ArrTotal2Real[$i][0]=$ArrTotal2Real[$i][0]+$ValorRealContenidoSurAndes;
						
						$ValorPptoContenidoSurAndes=DatosProyectadosTratam($Ano,$i,'3','2','COBRE (Fino)','P');
						$ArrTotal2Ppto[$i][0]=$ArrTotal2Ppto[$i][0]+$ValorPptoContenidoSurAndes;
						?>
						<td rowspan="1" align="right"><?  echo number_format($ValorRealContenidoSurAndes,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($ValorPptoContenidoSurAndes,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;Teniente</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$ValorRealContenidoTeniente=DatosProyectadosTratam($Ano,$i,'3','3','COBRE (Fino)','R');
						$ArrTotal2Real[$i][0]=$ArrTotal2Real[$i][0]+$ValorRealContenidoTeniente;
						
						$ValorPptoContenidoTeniente=DatosProyectadosTratam($Ano,$i,'3','3','COBRE (Fino)','P');
						$ArrTotal2Ppto[$i][0]=$ArrTotal2Ppto[$i][0]+$ValorPptoContenidoTeniente;
						?>
						<td rowspan="1" align="right"><?  echo number_format($ValorRealContenidoTeniente,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($ValorPptoContenidoTeniente,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;Bl�ster (Incluye �nodos Rechazados Externos)</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$ValorReal1=DatosProyectadosTratam($Ano,$i,'2','8','COBRE (Fino)','R');
						$ValorReal2=DatosProyectadosTratam($Ano,$i,'2','9','COBRE (Fino)','R');
						$ValorRealContenidoBl�ster=$ValorReal1+$ValorReal2;
						$ArrTotal2Real[$i][0]=$ArrTotal2Real[$i][0]+$ValorRealContenidoBl�ster;

						$ValorPpto1=DatosProyectadosTratam($Ano,$i,'2','8','COBRE (Fino)','P');
						$ValorPpto2=DatosProyectadosTratam($Ano,$i,'2','9','COBRE (Fino)','P');
						$ValorPptoContenidoBl�ster=$ValorPpto1+$ValorPpto2;
						$ArrTotal2Ppto[$i][0]=$ArrTotal2Ppto[$i][0]+$ValorPptoContenidoBl�ster;
						?>
						<td rowspan="1" align="right"><?  echo number_format($ValorRealContenidoBl�ster,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($ValorPptoContenidoBl�ster,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;Scrap</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$ValorScrapReal=0;
						$ValorScrapPpto=0;
						?>
						<td rowspan="1" align="right"><?  echo number_format($ValorScrapReal,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($ValorScrapPpto,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="TituloTablaVerde">
						<td rowspan="1" align="left" >&nbsp;Total</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$TotalContenidoReal=$ArrTotal2Real[$i][0];
						$TotalContenidoPpto=$ArrTotal2Ppto[$i][0];
						?>
						<td rowspan="1" align="right"><?  echo number_format($TotalContenidoReal,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($TotalContenidoPpto,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr>
						<td colspan="25" rowspan="1" align="left" class="formulario2">Pagable</td>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;Enami</td>
						<?
						$Numero3=0.003;
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$ValorRealContenidoEnami=DatosProyectadosTratam($Ano,$i,'3','1','COBRE (Fino)','R');
						$DatoRealPagableEnami=$ValorRealContenidoEnami*(1-$Numero3);
						$ArrTotalRealPagable1[$i][0]=$ArrTotalRealPagable1[$i][0]+$DatoRealPagableEnami;
						
						$ValorPptoContenidoEnami=DatosProyectadosTratam($Ano,$i,'3','1','COBRE (Fino)','P');
						$DatoPptoPagableEnami=$ValorPptoContenidoEnami*(1-$Numero3);
						$ArrTotalPptoPagable1[$i][0]=$ArrTotalPptoPagable1[$i][0]+$DatoPptoPagableEnami;
						?>
						<td rowspan="1" align="right"><?  echo number_format($DatoRealPagableEnami,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($DatoPptoPagableEnami,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;Sur Andes</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$ValorRealContenidoSurAndes=DatosProyectadosTratam($Ano,$i,'3','2','COBRE (Fino)','R');
						$DatoRealPagableSurAndes=$ValorRealContenidoSurAndes*(1-$Numero3);
						$ArrTotalRealPagable1[$i][0]=$ArrTotalRealPagable1[$i][0]+$DatoRealPagableSurAndes;
						
						$ValorPptoContenidoSurAndes=DatosProyectadosTratam($Ano,$i,'3','2','COBRE (Fino)','P');
						$DatoPptoPagableSurAndes=$ValorPptoContenidoSurAndes*(1-$Numero3);
						$ArrTotalPptoPagable1[$i][0]=$ArrTotalPptoPagable1[$i][0]+$DatoPptoPagableSurAndes;
						?>
						<td rowspan="1" align="right"><?  echo number_format($DatoRealPagableSurAndes,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($DatoPptoPagableSurAndes,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;Teniente</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$ValorRealContenidoTeniente=DatosProyectadosTratam($Ano,$i,'3','3','COBRE (Fino)','R');
						$DatoRealPagableTeniente=$ValorRealContenidoTeniente*(1-$Numero3);
						$ArrTotalRealPagable1[$i][0]=$ArrTotalRealPagable1[$i][0]+$DatoRealPagableTeniente;
						
						$ValorPptoContenidoTeniente=DatosProyectadosTratam($Ano,$i,'3','3','COBRE (Fino)','P');
						$DatoPptoPagableTeniente=$ValorPptoContenidoTeniente*(1-$Numero3);
						$ArrTotalPptoPagable1[$i][0]=$ArrTotalPptoPagable1[$i][0]+$DatoPptoPagableTeniente;
						?>
						<td rowspan="1" align="right"><?  echo number_format($DatoRealPagableTeniente,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($DatoPptoPagableTeniente,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;Teniente Blister</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$ValorReal1=DatosProyectadosTratam($Ano,$i,'2','8','COBRE (Fino)','R');
						$ValorReal2=DatosProyectadosTratam($Ano,$i,'2','9','COBRE (Fino)','R');
						$ValorRealContenidoBl�ster=$ValorReal1+$ValorReal2;
						$DatoRealPagableBlister=$ValorRealContenidoBl�ster*(1-$Numero3);
						$ArrTotalRealPagable1[$i][0]=$ArrTotalRealPagable1[$i][0]+$DatoRealPagableBlister;

						$ValorPpto1=DatosProyectadosTratam($Ano,$i,'2','8','COBRE (Fino)','P');
						$ValorPpto2=DatosProyectadosTratam($Ano,$i,'2','9','COBRE (Fino)','P');
						$ValorPptoContenidoBl�ster=$ValorPpto1+$ValorPpto2;
						$DatoPPtoPagableBlister=$ValorPptoContenidoBl�ster*(1-$Numero3);
						$ArrTotalPptoPagable1[$i][0]=$ArrTotalPptoPagable1[$i][0]+$DatoPPtoPagableBlister;			
						?>
						<td rowspan="1" align="right"><?  echo number_format($DatoRealPagableBlister,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($DatoPPtoPagableBlister,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="TituloTablaVerde">
						<td rowspan="1" align="left" >&nbsp;Total</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$TotalPagableReal1=$ArrTotalRealPagable1[$i][0];
						$TotalPagablePpto1=$ArrTotalPptoPagable1[$i][0];
						
						?>
						<td rowspan="1" align="right"><?  echo number_format($TotalPagableReal1,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($TotalPagablePpto1,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="TituloTablaVerde">
						<td rowspan="1" align="left" >&nbsp;Total Pagable</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$TotalPagableReal=$ArrTotalRealPagable[$i][0];
						$TotalPagablePpto=$ArrTotalPptoPagable[$i][0];
						
						$TotalPagableReal1=$ArrTotalRealPagable1[$i][0];
						$TotalPagablePpto1=$ArrTotalPptoPagable1[$i][0];
						
						$TotalPagableGeneralReal=$TotalPagableReal+$TotalPagableReal1;
						$TotalPagableGeneralPpto=$TotalPagablePpto+$TotalPagablePpto1;
						?>
						<td rowspan="1" align="right" ><?  echo number_format($TotalPagableGeneralReal,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right" ><?  echo number_format($TotalPagableGeneralPpto,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
        <?				       				 
		 }
		?>
  </table>
</form>
</body>
</html>
<?
function DatosProyectados($Producto,$Proveedor,$Ano,$Mes)
{
   $Consulta="select Vporden,Vptm,VPmaterial,Vptipinv,VPordenrel,Vpordes from pcip_inp_asignacion";
   $Consulta.=" where cod_producto='".$Producto."' and cod_proveedor='".$Proveedor."'";
   //echo $Consulta."<br>";
   $Resp=mysqli_query($link, $Consulta);  
   if($Fila=mysql_fetch_array($Resp))
   {
     $Orden=$Fila[Vporden];
     $Tm=$Fila[Vptm];
     $Material=$Fila[VPmaterial];
     $Tipinv=$Fila[Vptipinv];
	 $OrdenRel=$Fila[VPordenrel];
     $Ordes=$Fila[Vpordes]; 	 	 	 	 
   }       
	$Consulta1 =" select VPcantidad from pcip_svp_valorizacproduccion ";
	$Consulta1.=" where VPorden='".$Orden."' and VPtm='".$Tm."' and VPmaterial='".$Material."' and VPtipinv='".$Tipinv."' and VPordenrel='".$OrdenRel."' and VPordes='".$Ordes."' and VPa�o='".$Ano."' and VPmes='".$Mes."'";
	//echo $Consulta1."<br>";
	$RespAux=mysql_query($Consulta1);
	if($FilaAux=mysql_fetch_array($RespAux))
	{
		$Datos1=$FilaAux[VPcantidad];
		//echo "Valor datos consyulta 1   ".$Datos1."&nbsp;";
		//$Datos2=$FilaAux[ValorPresupuestado];
		//echo "Valor datos consyulta 2   ".$Datos2."<br>";
	}
		return($Datos1);	
}
function DatosProyectadosTratam($Ano,$Mes,$Area,$Division,$Producto,$Tipo)
{
   $Datos1=0;$Datos2=0;
   $Consulta="select valor_real as ValorReal,valor_presupuestado as ValorPresupuestado from pcip_inp_tratam";
   $Consulta.=" where ano='".$Ano."' and mes='".$Mes."' and nom_area='".$Area."' and nom_division='".$Division."' and cod_producto='".$Producto."'";
   //echo $Consulta."<br>";
   $Resp=mysqli_query($link, $Consulta);  
   if($Fila=mysql_fetch_array($Resp))
   {
    $Datos1=$Fila[ValorReal];
    //echo "Valor datos consyulta 1   ".$Datos1."&nbsp;";
    $Datos2=$Fila[ValorPresupuestado];
    //echo "Valor datos consyulta 2   ".$Datos2."<br>";
   }
   if($Tipo=='R')	
	return($Datos1);
   if($Tipo=='P')	    
	return($Datos2);	
}
?>
