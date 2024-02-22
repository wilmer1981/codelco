<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
<tr>
<td width="20%" class="TituloTablaVerde" align="center" rowspan="2">Oro Divisi&oacute;n Ventanas</td>
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
$ArrTotalCuReal[$i][0]=0;
$ArrTotalCuPpto[$i][0]=0;
$ArrTotalAnoReal1[$i][0]=0;
$ArrTotalAnoPpto1[$i][0]=0;
$ArrTotalOtroReal1[$i][0]=0;
$ArrTotalOtroPpto1[$i][0]=0;
$ArrProduReal1[$i][0]=0;
$ArrproduPpto1[$i][0]=0;
$ArrCodelcoReal1[$i][0]=0;
$ArrCodelcoPpto1[$i][0]=0;

}
?>
</tr>
<?	
$Buscar='S';	
if($Buscar=='S')
{	
?>  
	<tr>
	  <td colspan="25" rowspan="1" align="left" class="formulario2">Producci&oacute;n</td>
	</tr>
	<tr class="FilaAbeja">
	  <td rowspan="1" align="center">&nbsp;Kg</td>
		<?
		for($i=$Mes;$i<=$MesFin;$i++)
		{
		$KgReal=DatosProyectadosTratam($Ano,$i,'4','25','NULL','R');
		$KgPpto=DatosProyectadosTratam($Ano,$i,'4','25','NULL','P');
		?>
	    <td rowspan="1" align="right"><?  echo number_format($KgReal,0,',','.');?>&nbsp;</td>
	    <td rowspan="1" align="right"><?  echo number_format($KgPpto,0,',','.');?>&nbsp;</td>
		<?
		}
		?>
	</tr>
	<tr class="FilaAbeja">
	  <td rowspan="1" align="left">Ex Barro C.N.</td>
		<?
		for($i=$Mes;$i<=$MesFin;$i++)
		{
		$DatoOtroBarroReal=DatosProyectadosTratam($Ano,$i,'4','11','ORO','R');//Valor Tratam D102 real
		$DatoOtroBarroPpto=DatosProyectadosTratam($Ano,$i,'4','11','ORO','P');//Valor Tratam D102 real
        $ValorExBarroReal=$DatoOtroBarroReal;
		$ValorExBarroPpto=$DatoOtroBarroPpto;

		$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExBarroReal;
		$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExBarroPpto;	

		$ArrCodelcoReal1[$i][0]=$ArrCodelcoReal1[$i][0]+$ValorExBarroReal;//Total codelco suma
		$ArrCodelcoPpto1[$i][0]=$ArrCodelcoPpto1[$i][0]+$ValorExBarroPpto;	//Total codelco suma
		?>
		<td rowspan="1" align="right"><?  echo number_format($ValorExBarroReal,0,',','.');?>&nbsp;</td>
		<td rowspan="1" align="right"><?  echo number_format($ValorExBarroPpto,0,',','.');?>&nbsp;</td>
		<?
		}
		?>
	</tr>
	<tr class="FilaAbeja">
	  <td rowspan="1" align="left">Ex metal dor&eacute;</td>
		<?
		for($i=$Mes;$i<=$MesFin;$i++)
		{
		$DatoOtroMetalReal=DatosProyectadosTratam($Ano,$i,'4','12','ORO','R');//Valor Tratam D108 real
		$DatoOtroMetalPpto=DatosProyectadosTratam($Ano,$i,'4','12','ORO','P');//Valor Tratam D108 real
		$ValorExMetalDoreReal=$DatoOtroMetalReal;
		$ValorExMetalDorePpto=$DatoOtroMetalPpto;
		
		$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExMetalDoreReal;
		$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExMetalDorePpto;		
		?>
		<td rowspan="1" align="right"><?  echo number_format($ValorExMetalDoreReal,0,',','.');?>&nbsp;</td>
		<td rowspan="1" align="right"><?  echo number_format($ValorExMetalDorePpto,0,',','.');?>&nbsp;</td>
		<?
		}
		?>
	</tr>
	<tr class="FilaAbeja">
	  <td rowspan="1" align="left">Ex buillon oro</td>
		<?
		for($i=$Mes;$i<=$MesFin;$i++)
		{
		$DatoOtroBullionReal=DatosProyectadosTratam($Ano,$i,'4','13','ORO','R');//Valor Tratam D112 real
		$DatoOtroBullionPpto=DatosProyectadosTratam($Ano,$i,'4','13','ORO','P');//Valor Tratam D112 real
		$ValorExBullionReal=$DatoOtroBullionReal;
		$ValorExBullionPpto=$DatoOtroBullionPpto;
		
		$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExBullionReal;
		$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExBullionPpto;		
		?>
		<td rowspan="1" align="right"><?  echo number_format($ValorExBullionReal,0,',','.');?>&nbsp;</td>
		<td rowspan="1" align="right"><?  echo number_format($ValorExBullionPpto,0,',','.');?>&nbsp;</td>
		<?
		}
		?>
  </tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Ex Anodos Sur Andes</td>
			<?
			$Numero1=0.5;
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$DatoAnoPaSurReal1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','R');//Valor Tratam D79 real
			$DatoAnoPaSurPpto1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','P');//Valor Tratam D79 ppto
			$DatoAnoPaSurReal2=DatosProyectadosTratam($Ano,$i,'3','2','ORO','R');//Valor Tratam D83 real
			$DatoAnoPaSurPpto2=DatosProyectadosTratam($Ano,$i,'3','2','ORO','P');//Valor Tratam D83 ppto
			
			$ValorAnoPaSurReal=($DatoAnoPaSurReal2-$DatoAnoPaSurReal1*$Numero1/1000);
			if($ValorAnoPaSurReal<0)
				$ValorAnoPaSurReal=0;
			else
				$ValorAnoPaSurReal;														
			$ValorAnoPaSurPpto=($DatoAnoPaSurPpto2-$DatoAnoPaSurPpto1*$Numero1/1000);										
			if($ValorAnoPaSurPpto<0)
				$ValorAnoPaSurPpto=0;
			else
				$ValorAnoPaSurPpto;	
				
			$ValorExAnodosReal=$ValorAnoPaSurReal;
			$ValorExAnodosPpto=$ValorAnoPaSurPpto;
			
			$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExAnodosReal;
			$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExAnodosPpto;		
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorExAnodosReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo number_format($ValorExAnodosPpto,0,',','.');?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Ex Anodos Teniente</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$DatoAnoPaTeReal1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','R');//Valor Tratam D85 real
			$DatoAnoPaTePpto1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','P');//Valor Tratam D85 ppto
			$DatoAnoPaTeReal2=DatosProyectadosTratam($Ano,$i,'3','3','ORO','R');//Valor Tratam D89 real
			$DatoAnoPaTePpto2=DatosProyectadosTratam($Ano,$i,'3','3','ORO','P');//Valor Tratam D89 ppto
			
			$ValorAnoPaTeReal=$DatoAnoPaTeReal2-$DatoAnoPaTeReal1*$Numero1/1000;
			$ValorAnoPaTePpto=$DatoAnoPaTePpto2-$DatoAnoPaTePpto1*$Numero1/1000;
			
			$ValorExAnoTeReal=$ValorAnoPaTeReal;
			$ValorExAnoTePpto=$ValorAnoPaTePpto;
			
			$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExAnoTeReal;
			$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExAnoTePpto;	
				
			$ArrCodelcoReal1[$i][0]=$ArrCodelcoReal1[$i][0]+$ValorExAnoTeReal;//Total codelco suma
			$ArrCodelcoPpto1[$i][0]=$ArrCodelcoPpto1[$i][0]+$ValorExAnoTePpto;	//Total codelco suma
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorExAnoTeReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo number_format($ValorExAnoTePpto,0,',','.');?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Ex Blister Salvador</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$DatoAnoPaBlisReal1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','R');//Valor Tratam D58 real
			$DatoAnoPaBlisPpto1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','P');//Valor Tratam D58 ppto
			$DatoAnoPaBlisReal2=DatosProyectadosTratam($Ano,$i,'2','8','ORO','R');//Valor Tratam D62 real
			$DatoAnoPaBlisPpto2=DatosProyectadosTratam($Ano,$i,'2','8','ORO','P');//Valor Tratam D62 ppto
			
			$ValorAnoPaBlisReal=$DatoAnoPaBlisReal2-$DatoAnoPaBlisReal1*$Numero1/1000;					
			$ValorAnoPaBlisPpto=$DatoAnoPaBlisPpto2-$DatoAnoPaBlisPpto1*$Numero1/1000;
			
			$ValorExBlisReal=$ValorAnoPaBlisReal;
			$ValorExBlisPpto=$ValorAnoPaBlisPpto;
			
			$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExBlisReal;
			$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExBlisPpto;
					
			$ArrCodelcoReal1[$i][0]=$ArrCodelcoReal1[$i][0]+$ValorExBlisReal;//Total codelco suma
			$ArrCodelcoPpto1[$i][0]=$ArrCodelcoPpto1[$i][0]+$ValorExBlisPpto;	//Total codelco suma
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorExBlisReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo number_format($ValorExBlisPpto,0,',','.');?>&nbsp;</td>
			<?			
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Ex cucons Enami</td>
			<?
			$Numero=0.5;
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$DatoCuPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','R');//Valor Tratam D9 real
			$DatoCuPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','P');//Valor Tratam D9 ppto
			$DatoCuPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');//Valor Tratam D52 real
			$DatoCuPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','P');//Valor Tratam D52 ppto
			$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','ORO','R');// Valor Tratam D12 real
			$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','ORO','P');// Valor Tratam D12 ppto
			
			$ValorRealCuPaEnami=($DatoCuPaEnamiReal1-$DatoCuPaEnamiReal2)*($DatoCuPaEnamiReal3-$Numero)/1000;
			if($ValorRealCuPaEnami<0)
				$ValorRealCuPaEnami=0;
			else
				$ValorRealCuPaEnami;				
			$ValorPptoCuPaEnami=($DatoCuPaEnamiPpto1-$DatoCuPaEnamiPpto2)*($DatoCuPaEnamiReal3-$Numero)/1000;
			if($ValorPptoCuPaEnami<0)
				$ValorPptoCuPaEnami=0;
			else
				$ValorPptoCuPaEnami;	
				
			$ValorExCuReal=$ValorRealCuPaEnami;		
			$ValorExCuPpto=$ValorPptoCuPaEnami;	
				
			$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExCuReal;
			$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExCuPpto;		
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorExCuReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo number_format($ValorExCuPpto,0,',','.');?>&nbsp;</td>
			<?		
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Ex cucons Sur Andes</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$DatoCuPaSurReal1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','R');//Valor Tratam D16 real
			$DatoCuPaSurPpto1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','P');//Valor Tratam D16 ppto
			$DatoCuPaSurReal2=DatosProyectadosTratam($Ano,$i,'1','2','ORO','R');//Valor Tratam D19 real
			$DatoCuPaSurPpto2=DatosProyectadosTratam($Ano,$i,'1','2','ORO','P');//Valor Tratam D19 ppto
			
			$ValorCuPaSurReal=$DatoCuPaSurReal1*($DatoCuPaSurReal2-$Numero)/1000;//Valor Real
			if($ValorCuPaSurReal<0)
				$ValorCuPaSurReal=0;
			else
				$ValorCuPaSurReal;
			$ValorCuPaSurPpto=$DatoCuPaSurPpto1*($DatoCuPaSurPpto2-$Numero)/1000;//Valor Ppto 				
			if($ValorCuPaSurPpto<0)
				$ValorCuPaSurPpto=0;
			else
				$ValorCuPaSurPpto;

            $ValorExCuSurReal=$ValorCuPaSurReal;
			$ValorExCuSurPpto=$ValorCuPaSurPpto;
			
			$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExCuSurReal;
			$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExCuSurPpto;		
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorExCuSurReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo number_format($ValorExCuSurPpto,0,',','.');?>&nbsp;</td>
			<?
			
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Ex cucons Andina</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$DatoCuPaAndinaReal1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','R');//Valor Tratam D23 real
			$DatoCuPaAndinaPpto1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','P');//Valor Tratam D23 ppto
			$DatoCuPaAndinaReal2=DatosProyectadosTratam($Ano,$i,'1','4','ORO','R');//Valor Tratam D26 real
			$DatoCuPaAndinaPpto2=DatosProyectadosTratam($Ano,$i,'1','4','ORO','P');//Valor Tratam D26 ppto
			
			$ValorCuAndinaReal=($DatoCuPaAndinaReal1*($DatoCuPaAndinaReal2-$numero))/1000;
			if($ValorCuAndinaReal<0)
				$ValorCuAndinaReal=0;
			else
				$ValorCuAndinaReal;					
			$ValorCuAndinaPpto=($DatoCuPaAndinaPpto1*($DatoCuPaAndinaPpto2-$numero))/1000;	
			if($ValorCuAndinaPpto<0)
				$ValorCuAndinaPpto=0;
			else
				$ValorCuAndinaPpto;		
			$ValorExCuAndiReal=$ValorCuAndinaReal;	
			$ValorExCuAndiPpto=$ValorCuAndinaPpto;	
														
			$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExCuAndiReal;
			$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExCuAndiPpto;	
				
			$ArrCodelcoReal1[$i][0]=$ArrCodelcoReal1[$i][0]+$ValorExCuAndiReal;//Total codelco suma
			$ArrCodelcoPpto1[$i][0]=$ArrCodelcoPpto1[$i][0]+$ValorExCuAndiPpto;	//Total codelco suma
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorExCuAndiReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo number_format($ValorExCuAndiPpto,0,',','.');?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Ex cucons CN</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$DatoCuPaNorteReal1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','R');//Valor Tratam D23 real
			$DatoCuPaNortePpto1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','P');//Valor Tratam D23 ppto
			$DatoCuPaNorteReal2=DatosProyectadosTratam($Ano,$i,'1','5','ORO','R');//Valor Tratam D26 real
			$DatoCuPaNortePpto2=DatosProyectadosTratam($Ano,$i,'1','5','ORO','P');//Valor Tratam D26 ppto
			
			$ValorCuNorteReal=($DatoCuPaNorteReal1*($DatoCuPaNorteReal2-$numero))/1000;
			if($ValorCuNorteReal<0)
				$ValorCuNorteReal=0;
			else
				$ValorCuNorteReal;														
			$ValorCuNortePpto=($DatoCuPaNortePpto1*($DatoCuPaNortePpto2-$numero))/1000;										
			if($ValorCuNortePpto<0)
				$ValorCuNortePpto=0;
			else
				$ValorCuNortePpto;	
																	
			$ValorExCuCNReal=$ValorCuNorteReal;
			$ValorExCuCNPpto=$ValorCuNortePpto;
			
			$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExCuCNReal;
			$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExCuCNPpto;
					
			$ArrCodelcoReal1[$i][0]=$ArrCodelcoReal1[$i][0]+$ValorExCuCNReal;//Total codelco suma
			$ArrCodelcoPpto1[$i][0]=$ArrCodelcoPpto1[$i][0]+$ValorExCuCNPpto;	//Total codelco suma
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorExCuCNReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo number_format($ValorExCuCNPpto,0,',','.');?>&nbsp;</td>
			<?
			}
			?>
			</tr> 
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Ex cucons Teniente</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$DatoCuPaTeReal1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','R');//Valor Tratam D23 real
			$DatoCuPaTePpto1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','P');//Valor Tratam D23 ppto
			$DatoCuPaTeReal2=DatosProyectadosTratam($Ano,$i,'1','3','ORO','R');//Valor Tratam D26 real
			$DatoCuPaTePpto2=DatosProyectadosTratam($Ano,$i,'1','3','ORO','P');//Valor Tratam D26 ppto
			
			$ValorCuTenienteReal=($DatoCuPaTeReal1*($DatoCuPaTeReal2-$Numero))/1000;
			if($ValorCuTenienteReal<0)
				$ValorCuTenienteReal=0;
			else
				$ValorCuTenienteReal;											
			$ValorCuTenientePpto=($DatoCuPaTePpto1*($DatoCuPaTePpto2-$Numero))/1000;
			if($ValorCuTenientePpto<0)
				$ValorCuTenientePpto=0;
			else
				$ValorCuTenientePpto;
				
            $ValorExCuTenReal=$ValorCuTenienteReal;
			$ValorExCuTenPpto=$ValorCuTenientePpto;
			
			$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExCuTenReal;
			$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExCuTenPpto;	
				
			$ArrCodelcoReal1[$i][0]=$ArrCodelcoReal1[$i][0]+$ValorExCuTenReal;//Total codelco suma
			$ArrCodelcoPpto1[$i][0]=$ArrCodelcoPpto1[$i][0]+$ValorExCuTenPpto;	//Total codelco suma
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorExCuTenReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo number_format($ValorExCuTenPpto,0,',','.');?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Ex anodos Enami</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$KgReal=DatosProyectadosTratam($Ano,$i,'4','25','NULL','R');
			$KgPpto=DatosProyectadosTratam($Ano,$i,'4','25','NULL','P');

			$ValorExAnoEnamiReal=$KgReal-$ArrProduReal1[$i][0];
			$ValorExAnoEnamiPpto=$KgPpto-$ArrproduPpto1[$i][0];
			$ArrProduReal1[$i][0]=$ArrProduReal1[$i][0]+$ValorExAnoEnamiReal;
			$ArrproduPpto1[$i][0]=$ArrproduPpto1[$i][0]+$ValorExAnoEnamiPpto;
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorExAnoEnamiReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo number_format($ValorExAnoEnamiPpto,0,',','.');?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Total</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$ValorTotalReal=$ArrProduReal1[$i][0];
			$ValorTotalPpto=$ArrproduPpto1[$i][0];
			?>
			<td rowspan="1" align="right"><?  echo number_format($ValorTotalReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><?  echo number_format($ValorTotalPpto,0,',','.');?>&nbsp;</td>
			<?
			}
			?>
			</tr>
			<tr class="FilaAbeja">
			<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Margen metal&uacute;rgico</td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{	
			$KgReal=DatosProyectadosTratam($Ano,$i,'4','25','NULL','R');
			$KgPpto=DatosProyectadosTratam($Ano,$i,'4','25','NULL','P');

			$ValorExAnoEnamiReal=$KgReal-$ArrProduReal1[$i][0];
			$ValorExAnoEnamiPpto=$KgPpto-$ArrproduPpto1[$i][0];

			$DatoCuPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','R');//Valor Tratam D9 real
			$DatoCuPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','P');//Valor Tratam D9 ppto
			$DatoCuPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');//Valor Tratam D52 real
			$DatoCuPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','P');//Valor Tratam D52 ppto
			$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','ORO','R');// Valor Tratam D12 real
			$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','ORO','P');// Valor Tratam D12 ppto
			
			$ValorRealCuPaEnami=($DatoCuPaEnamiReal1-$DatoCuPaEnamiReal2)*($DatoCuPaEnamiReal3-$Numero)/1000;
			if($ValorRealCuPaEnami<0)
				$ValorRealCuPaEnami=0;
			else
				$ValorRealCuPaEnami;				
			$ValorPptoCuPaEnami=($DatoCuPaEnamiPpto1-$DatoCuPaEnamiPpto2)*($DatoCuPaEnamiReal3-$Numero)/1000;
			if($ValorPptoCuPaEnami<0)
				$ValorPptoCuPaEnami=0;
			else
				$ValorPptoCuPaEnami;	
							
			$ValorMargenReal=$ValorExAnoEnamiReal-$ValorRealCuPaEnami;
			$ValorMargenPpto=$ValorExAnoEnamiPpto-$ValorPptoCuPaEnami;
			?>
			<td rowspan="1" align="right"><? echo number_format($ValorMargenReal,0,',','.');?>&nbsp;</td>
			<td rowspan="1" align="right"><? echo number_format($ValorMargenPpto,0,',','.');?>&nbsp;</td>
			<?
			}
			?>
			</tr>
				<tr class="FilaAbeja">
				<td colspan="25" rowspan="1" align="left" >&nbsp;</td>
				</tr>
				<tr class="TituloTablaVerde">
				<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Codelco</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{
				$TotalCodelcoReal=$ArrCodelcoReal1[$i][0];
				$TotalCodelcoPpto=$ArrCodelcoPpto1[$i][0];
				?>
				<td rowspan="1" align="right"><?  echo number_format($TotalCodelcoReal,0,',','.');?>&nbsp;</td>
				<td rowspan="1" align="right"><?  echo number_format($TotalCodelcoPpto,0,',','.');?>&nbsp;</td>
				<?
				}
				?>
				</tr>
				<tr>
				<td colspan="25" rowspan="1" align="left" class="formulario2">Cucons</td>
				</tr>
				<tr>
				<td colspan="25" rowspan="1" align="left" class="formulario2">Pagable</td>
				</tr>
				<tr class="FilaAbeja">
				<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Enami</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{
				$DatoCuPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','R');//Valor Tratam D9 real
				$DatoCuPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'1','1','TMS','P');//Valor Tratam D9 ppto
				$DatoCuPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','R');//Valor Tratam D52 real
				$DatoCuPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'2','7','SECO FU','P');//Valor Tratam D52 ppto
				$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','ORO','R');// Valor Tratam D12 real
				$DatoCuPaEnamiReal3=DatosProyectadosTratam($Ano,$i,'1','1','ORO','P');// Valor Tratam D12 ppto
				
				$ValorRealCuPaEnami=($DatoCuPaEnamiReal1-$DatoCuPaEnamiReal2)*($DatoCuPaEnamiReal3-$Numero)/1000;
				if($ValorRealCuPaEnami<0)
				    $ValorRealCuPaEnami=0;
				else
					$ValorRealCuPaEnami;				
				$ValorPptoCuPaEnami=($DatoCuPaEnamiPpto1-$DatoCuPaEnamiPpto2)*($DatoCuPaEnamiReal3-$Numero)/1000;
				if($ValorPptoCuPaEnami<0)
				    $ValorPptoCuPaEnami=0;
				else
					$ValorPptoCuPaEnami;				
				
				$ArrTotalCuReal[$i][0]=$ArrTotalCuReal[$i][0]+$ValorRealCuPaEnami;
				$ArrTotalCuPpto[$i][0]=$ArrTotalCuPpto[$i][0]+$ValorPptoCuPaEnami;
				?>
				<td rowspan="1" align="right"><?  echo number_format($ValorRealCuPaEnami,0,',','.');?>&nbsp;</td>
				<td rowspan="1" align="right"><?  echo number_format($ValorPptoCuPaEnami,0,',','.');?>&nbsp;</td>
				<?
				}
				?>
				</tr>
				<tr class="FilaAbeja">
				<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Enami (precipitado)</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{
				$DatoEnamiPreReal=0;
				$DatoEnamiPrePpto=0;
				?>
				<td rowspan="1" align="right"><?  echo number_format($DatoEnamiPreReal,0,',','.');?>&nbsp;</td>
				<td rowspan="1" align="right"><?  echo number_format($DatoEnamiPrePpto,0,',','.');?>&nbsp;</td>
				<?
				}
				?>
				</tr>
				<tr class="FilaAbeja">
				<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Sur Andes</td>
				<?
				for($i=$Mes;$i<=$MesFin;$i++)
				{
				$DatoCuPaSurReal1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','R');//Valor Tratam D16 real
				$DatoCuPaSurPpto1=DatosProyectadosTratam($Ano,$i,'1','2','TMS','P');//Valor Tratam D16 ppto
				$DatoCuPaSurReal2=DatosProyectadosTratam($Ano,$i,'1','2','ORO','R');//Valor Tratam D19 real
				$DatoCuPaSurPpto2=DatosProyectadosTratam($Ano,$i,'1','2','ORO','P');//Valor Tratam D19 ppto
				
				$ValorCuPaSurReal=$DatoCuPaSurReal1*($DatoCuPaSurReal2-$Numero)/1000;//Valor Real
				if($ValorCuPaSurReal<0)
				    $ValorCuPaSurReal=0;
				else
					$ValorCuPaSurReal;
				$ValorCuPaSurPpto=$DatoCuPaSurPpto1*($DatoCuPaSurPpto2-$Numero)/1000;//Valor Ppto 				
				if($ValorCuPaSurPpto<0)
				    $ValorCuPaSurPpto=0;
				else
				  	$ValorCuPaSurPpto;

				$ArrTotalCuReal[$i][0]=$ArrTotalCuReal[$i][0]+$ValorCuPaSurReal;
				$ArrTotalCuPpto[$i][0]=$ArrTotalCuPpto[$i][0]+$ValorCuPaSurPpto;					
				?>
				<td rowspan="1" align="right"><? echo number_format($ValorCuPaSurReal,0,',','.');?>&nbsp;</td>
				<td rowspan="1" align="right"><? echo number_format($ValorCuPaSurPpto,0,',','.');?>&nbsp;</td>
				<?
				}
				?>
				</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Teniente</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoCuPaTeReal1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','R');//Valor Tratam D23 real
					$DatoCuPaTePpto1=DatosProyectadosTratam($Ano,$i,'1','3','TMS','P');//Valor Tratam D23 ppto
					$DatoCuPaTeReal2=DatosProyectadosTratam($Ano,$i,'1','3','ORO','R');//Valor Tratam D26 real
					$DatoCuPaTePpto2=DatosProyectadosTratam($Ano,$i,'1','3','ORO','P');//Valor Tratam D26 ppto
					
					$ValorCuTenienteReal=($DatoCuPaTeReal1*($DatoCuPaTeReal2-$numero))/1000;
					if($ValorCuTenienteReal<0)
						$ValorCuTenienteReal=0;
					else
						$ValorCuTenienteReal;											
					$ValorCuTenientePpto=($DatoCuPaTePpto1*($DatoCuPaTePpto2-$numero))/1000;
					if($ValorCuTenientePpto<0)
						$ValorCuTenientePpto=0;
					else
						$ValorCuTenientePpto;

					$ArrTotalCuReal[$i][0]=$ArrTotalCuReal[$i][0]+$ValorCuTenienteReal;
					$ArrTotalCuPpto[$i][0]=$ArrTotalCuPpto[$i][0]+$ValorCuTenientePpto;											
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorCuTenienteReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorCuTenientePpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Andina</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoCuPaAndinaReal1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','R');//Valor Tratam D23 real
					$DatoCuPaAndinaPpto1=DatosProyectadosTratam($Ano,$i,'1','4','TMS','P');//Valor Tratam D23 ppto
					$DatoCuPaAndinaReal2=DatosProyectadosTratam($Ano,$i,'1','4','ORO','R');//Valor Tratam D26 real
					$DatoCuPaAndinaPpto2=DatosProyectadosTratam($Ano,$i,'1','4','ORO','P');//Valor Tratam D26 ppto
					
					$ValorCuAndinaReal=($DatoCuPaAndinaReal1*($DatoCuPaAndinaReal2-$numero))/1000;
					if($ValorCuAndinaReal<0)
						$ValorCuAndinaReal=0;
					else
						$ValorCuAndinaReal;					
					$ValorCuAndinaPpto=($DatoCuPaAndinaPpto1*($DatoCuPaAndinaPpto2-$numero))/1000;	
					if($ValorCuAndinaPpto<0)
						$ValorCuAndinaPpto=0;
					else
						$ValorCuAndinaPpto;														

					$ArrTotalCuReal[$i][0]=$ArrTotalCuReal[$i][0]+$ValorCuAndinaReal;
					$ArrTotalCuPpto[$i][0]=$ArrTotalCuPpto[$i][0]+$ValorCuAndinaPpto;											
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorCuAndinaReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorCuAndinaPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Codelco Norte</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoCuPaNorteReal1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','R');//Valor Tratam D23 real
					$DatoCuPaNortePpto1=DatosProyectadosTratam($Ano,$i,'1','5','TMS','P');//Valor Tratam D23 ppto
					$DatoCuPaNorteReal2=DatosProyectadosTratam($Ano,$i,'1','5','ORO','R');//Valor Tratam D26 real
					$DatoCuPaNortePpto2=DatosProyectadosTratam($Ano,$i,'1','5','ORO','P');//Valor Tratam D26 ppto
					
					$ValorCuNorteReal=($DatoCuPaNorteReal1*($DatoCuPaNorteReal2-$numero))/1000;
					if($ValorCuNorteReal<0)
						$ValorCuNorteReal=0;
					else
						$ValorCuNorteReal;														
					$ValorCuNortePpto=($DatoCuPaNortePpto1*($DatoCuPaNortePpto2-$numero))/1000;										
					if($ValorCuNortePpto<0)
						$ValorCuNortePpto=0;
					else
						$ValorCuNortePpto;														

					$ArrTotalCuReal[$i][0]=$ArrTotalCuReal[$i][0]+$ValorCuNorteReal;
					$ArrTotalCuPpto[$i][0]=$ArrTotalCuPpto[$i][0]+$ValorCuNortePpto;											
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorCuNorteReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorCuNortePpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="TituloTablaVerde">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Total</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$TotalCuReal=$ArrTotalCuReal[$i][0];
					$TotalCuPpto=$ArrTotalCuPpto[$i][0];
					?>
					<td rowspan="1" align="right"><?  echo number_format($TotalCuReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($TotalCuPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					<tr>
					<td colspan="25" rowspan="1" align="left" class="formulario2">Ánodos y Blíster</td>					
					</tr>
					<tr>
					<td colspan="25" rowspan="1" align="left" class="formulario2">Pagable</td>					
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Enami</td>
					<?
					$Numero1=0.5;
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoAnoPaEnamiReal1=DatosProyectadosTratam($Ano,$i,'3','1','TMS','R');//Valor Tratam D73 real
					//echo "Real1   ".$DatoAnoPaEnamiReal1."<br>";
					$DatoAnoPaEnamiPpto1=DatosProyectadosTratam($Ano,$i,'3','1','TMS','P');//Valor Tratam D73 ppto
					//echo "Ppto1   ".$DatoAnoPaEnamiPpto1."<br>";
					$DatoAnoPaEnamiReal2=DatosProyectadosTratam($Ano,$i,'3','1','ORO','R');//Valor Tratam D77 real
					//echo "Real2   ".$DatoAnoPaEnamiReal2."<br>";
					$DatoAnoPaEnamiPpto2=DatosProyectadosTratam($Ano,$i,'3','1','ORO','P');//Valor Tratam D77 ppto
					//echo "Ppto2   ".$DatoAnoPaEnamiPpto2."<br>";
					
					$ValorAnoPaEnamiReal=$DatoAnoPaEnamiReal2-$DatoAnoPaEnamiReal1*$Numero1/1000;					 					
					$ValorAnoPaEnamiPpto=$DatoAnoPaEnamiPpto2-$DatoAnoPaEnamiPpto1*$Numero1/1000;

					$ArrTotalAnoReal1[$i][0]=$ArrTotalAnoReal1[$i][0]+$ValorAnoPaEnamiReal;
					$ArrTotalAnoPpto1[$i][0]=$ArrTotalAnoPpto1[$i][0]+$ValorAnoPaEnamiPpto;
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorAnoPaEnamiReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorAnoPaEnamiPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Sur Andes</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoAnoPaSurReal1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','R');//Valor Tratam D79 real
					$DatoAnoPaSurPpto1=DatosProyectadosTratam($Ano,$i,'3','2','TMS','P');//Valor Tratam D79 ppto
					$DatoAnoPaSurReal2=DatosProyectadosTratam($Ano,$i,'3','2','ORO','R');//Valor Tratam D83 real
					$DatoAnoPaSurPpto2=DatosProyectadosTratam($Ano,$i,'3','2','ORO','P');//Valor Tratam D83 ppto
					
					$ValorAnoPaSurReal=($DatoAnoPaSurReal2-$DatoAnoPaSurReal1*$Numero1/1000);
					if($ValorAnoPaSurReal<0)
						$ValorAnoPaSurReal=0;
					else
						$ValorAnoPaSurReal;														
					$ValorAnoPaSurPpto=($DatoAnoPaSurPpto2-$DatoAnoPaSurPpto1*$Numero1/1000);										
					if($ValorAnoPaSurPpto<0)
						$ValorAnoPaSurPpto=0;
					else
						$ValorAnoPaSurPpto;		

					$ArrTotalAnoReal1[$i][0]=$ArrTotalAnoReal1[$i][0]+$ValorAnoPaSurReal;
					$ArrTotalAnoPpto1[$i][0]=$ArrTotalAnoPpto1[$i][0]+$ValorAnoPaSurPpto;
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorAnoPaSurReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorAnoPaSurPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Teniente</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoAnoPaTeReal1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','R');//Valor Tratam D85 real
					$DatoAnoPaTePpto1=DatosProyectadosTratam($Ano,$i,'3','3','TMS','P');//Valor Tratam D85 ppto
					$DatoAnoPaTeReal2=DatosProyectadosTratam($Ano,$i,'3','3','ORO','R');//Valor Tratam D89 real
					$DatoAnoPaTePpto2=DatosProyectadosTratam($Ano,$i,'3','3','ORO','P');//Valor Tratam D89 ppto
					
					$ValorAnoPaTeReal=$DatoAnoPaTeReal2-$DatoAnoPaTeReal1*$Numero1/1000;
					$ValorAnoPaTePpto=$DatoAnoPaTePpto2-$DatoAnoPaTePpto1*$Numero1/1000;
					
					$ArrTotalAnoReal1[$i][0]=$ArrTotalAnoReal1[$i][0]+$ValorAnoPaTeReal;
					$ArrTotalAnoPpto1[$i][0]=$ArrTotalAnoPpto1[$i][0]+$ValorAnoPaTePpto;
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorAnoPaTeReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorAnoPaTePpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Teniente Bl&iacute;ster</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoAnoPaBlisReal1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','R');//Valor Tratam D58 real
					$DatoAnoPaBlisPpto1=DatosProyectadosTratam($Ano,$i,'2','8','TMS','P');//Valor Tratam D58 ppto
					$DatoAnoPaBlisReal2=DatosProyectadosTratam($Ano,$i,'2','8','ORO','R');//Valor Tratam D62 real
					$DatoAnoPaBlisPpto2=DatosProyectadosTratam($Ano,$i,'2','8','ORO','P');//Valor Tratam D62 ppto
					
					$ValorAnoPaBlisReal=$DatoAnoPaBlisReal2-$DatoAnoPaBlisReal1*$Numero1/1000;					
					$ValorAnoPaBlisPpto=$DatoAnoPaBlisPpto2-$DatoAnoPaBlisPpto1*$Numero1/1000;

					$ArrTotalAnoReal1[$i][0]=$ArrTotalAnoReal1[$i][0]+$ValorAnoPaBlisReal;
					$ArrTotalAnoPpto1[$i][0]=$ArrTotalAnoPpto1[$i][0]+$ValorAnoPaBlisPpto;
					?>
					<td rowspan="1" align="right"><?  echo number_format($ValorAnoPaBlisReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($ValorAnoPaBlisPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="TituloTablaVerde">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Total</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$TotalAnoPaReal=$ArrTotalAnoReal1[$i][0];
					$TotalAnoPaPpto=$ArrTotalAnoPpto1[$i][0];
					?>
					<td rowspan="1" align="right"><?  echo number_format($TotalAnoPaReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($TotalAnoPaPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr>
					<td colspan="25" rowspan="1" align="left" class="FilaAbeja">&nbsp;</td>					
					</tr>
					<tr>
					<td colspan="25" rowspan="1" align="left" class="formulario2">Otros Abastecimientos</td>					
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Barro Chuqui</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoOtroBarroReal=DatosProyectadosTratam($Ano,$i,'4','11','ORO','R');//Valor Tratam D102 real
					$DatoOtroBarroPpto=DatosProyectadosTratam($Ano,$i,'4','11','ORO','P');//Valor Tratam D102 real
					?>
					<td rowspan="1" align="right"><?  echo number_format($DatoOtroBarroReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($DatoOtroBarroPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Metal Dor&eacute;</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoOtroMetalReal=DatosProyectadosTratam($Ano,$i,'4','12','ORO','R');//Valor Tratam D108 real
					$DatoOtroMetalPpto=DatosProyectadosTratam($Ano,$i,'4','12','ORO','P');//Valor Tratam D108 real
					?>
					<td rowspan="1" align="right"><?  echo number_format($DatoOtroMetalReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($DatoOtroMetalPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Buillon oro</td>
					<?
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoOtroBullionReal=DatosProyectadosTratam($Ano,$i,'4','13','ORO','R');//Valor Tratam D112 real
					$DatoOtroBullionPpto=DatosProyectadosTratam($Ano,$i,'4','13','ORO','P');//Valor Tratam D112 real
					?>
					<td rowspan="1" align="right"><?  echo number_format($DatoOtroBullionReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><?  echo number_format($DatoOtroBullionPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
					</tr>
						<tr>
						<td colspan="25" rowspan="1" align="left" class="formulario2">Pagable</td>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Barro Chuqui</td>
						<?
						$Numero2=0.99;
						for($i=$Mes;$i<=$MesFin;$i++)
						{
					     $DatoOtroBarroReal=DatosProyectadosTratam($Ano,$i,'4','11','ORO','R');//Valor Tratam D102 real
						 $DatoOtroBarroPpto=DatosProyectadosTratam($Ano,$i,'4','11','ORO','P');//Valor Tratam D102 real
						 $ValorBarroReal=$DatoOtroBarroReal*$Numero2;
						 $ValorBarroPpto=$DatoOtroBarroPpto*$Numero2;
						 
						 $ArrTotalOtroReal1[$i][0]=$ArrTotalOtroReal1[$i][0]+$ValorBarroReal;
						 $ArrTotalOtroPpto1[$i][0]=$ArrTotalOtroPpto1[$i][0]+$ValorBarroPpto;
						?>
						<td rowspan="1" align="right"><?  echo number_format($ValorBarroReal,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($ValorBarroPpto,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Metal Dor&eacute;</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$DatoOtroMetalReal=DatosProyectadosTratam($Ano,$i,'4','12','ORO','R');//Valor Tratam D108 real
						$DatoOtroMetalPpto=DatosProyectadosTratam($Ano,$i,'4','12','ORO','P');//Valor Tratam D108 real
						$ValorMetalReal=$DatoOtroMetalReal*$Numero2;
						$ValorMetalPpto=$DatoOtroMetalppto*$Numero2;

						$ArrTotalOtroReal1[$i][0]=$ArrTotalOtroReal1[$i][0]+$ValorMetalReal;
						$ArrTotalOtroPpto1[$i][0]=$ArrTotalOtroPpto1[$i][0]+$ValorMetalPpto;
						?>
						<td rowspan="1" align="right"><?  echo number_format($ValorMetalReal,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($ValorMetalPpto,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Buillon de oro</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$DatoOtroBullionReal=DatosProyectadosTratam($Ano,$i,'4','13','ORO','R');//Valor Tratam D112 real
						$DatoOtroBullionPpto=DatosProyectadosTratam($Ano,$i,'4','13','ORO','P');//Valor Tratam D112 real
						$ValorBullionReal=$DatoOtroBullionReal*$Numero2;
						$ValorBullionPpto=$DatoOtroBullionPpto*$Numero2;

						$ArrTotalOtroReal1[$i][0]=$ArrTotalOtroReal1[$i][0]+$ValorBullionReal;
						$ArrTotalOtroPpto1[$i][0]=$ArrTotalOtroPpto1[$i][0]+$ValorBullionPpto;
						?>
						<td rowspan="1" align="right"><?  echo number_format($ValorBullionReal,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($ValorBullionPpto,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="TituloTablaVerde">
						<td rowspan="1" align="left">&nbsp;&nbsp;&nbsp;Total</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$TotalOtroReal=$ArrTotalOtroReal1[$i][0];
						$TotalOtroPpto=$ArrTotalOtroPpto1[$i][0];
						?>
						<td rowspan="1" align="right"><?  echo number_format($TotalOtroReal,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($TotalOtroPpto,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr>
						<td colspan="25" rowspan="1" align="left" class="FilaAbeja">&nbsp;</td>					
						</tr>
						<tr class="TituloTablaVerde">
						<td rowspan="1" align="left">Total pagable</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$TotalCuReal=$ArrTotalCuReal[$i][0];//Pagable Cucons 
						$TotalCuPpto=$ArrTotalCuPpto[$i][0];//Pagable Cucons
						$TotalAnoPaReal=$ArrTotalAnoReal1[$i][0];//Pagable Anodos
						$TotalAnoPaPpto=$ArrTotalAnoPpto1[$i][0];//Pagable Anodos
						$TotalOtroReal=$ArrTotalOtroReal1[$i][0];//Pagable Otros
						$TotalOtroPpto=$ArrTotalOtroPpto1[$i][0];//Pagable Otros
						
						$TotalPagableReal=$TotalCuReal+$TotalAnoPaReal+$TotalOtroReal;
						$TotalPagablePpto=$TotalCuPpto+$TotalAnoPaPpto+$TotalOtroPpto;
						?>
						<td rowspan="1" align="right"><?  echo number_format($TotalPagableReal,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($TotalPagablePpto,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="TituloTablaVerde">
						<td rowspan="1" align="left">Producci&oacute;n</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$KgReal=DatosProyectadosTratam($Ano,$i,'4','25','NULL','R');
						$KgPpto=DatosProyectadosTratam($Ano,$i,'4','25','NULL','P');
						$TotalProduccionReal=$KgReal;
						$TotalProduccionPpto=$KgPpto;
						?>
						<td rowspan="1" align="right"><?  echo number_format($TotalProduccionReal,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($TotalProduccionPpto,0,',','.');?>&nbsp;</td>
						<?
						}
						?>
						</tr>
						<tr class="TituloTablaVerde">
						<td rowspan="1" align="left">Margen</td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{
						$TotalCuReal=$ArrTotalCuReal[$i][0];//Pagable Cucons 
						$TotalCuPpto=$ArrTotalCuPpto[$i][0];//Pagable Cucons
						$TotalAnoPaReal=$ArrTotalAnoReal1[$i][0];//Pagable Anodos
						$TotalAnoPaPpto=$ArrTotalAnoPpto1[$i][0];//Pagable Anodos
						$TotalOtroReal=$ArrTotalOtroReal1[$i][0];//Pagable Otros
						$TotalOtroPpto=$ArrTotalOtroPpto1[$i][0];//Pagable Otros						
						$TotalPagableReal=$TotalCuReal+$TotalAnoPaReal+$TotalOtroReal;
						$TotalPagablePpto=$TotalCuPpto+$TotalAnoPaPpto+$TotalOtroPpto;
						
						
						$KgReal=DatosProyectadosTratam($Ano,$i,'4','25','NULL','R');
						$KgPpto=DatosProyectadosTratam($Ano,$i,'4','25','NULL','P');
						$TotalProduccionReal=$KgReal;
						$TotalProduccionPpto=$KgPpto;
						
						$MargenReal=$TotalProduccionReal-$TotalPagableReal;
						$MargenPpto=$TotalProduccionPpto-$TotalPagablePpto;
						?>
						<td rowspan="1" align="right"><?  echo number_format($MargenReal,0,',','.');?>&nbsp;</td>
						<td rowspan="1" align="right"><?  echo number_format($MargenPpto,0,',','.');?>&nbsp;</td>
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
   $Resp=mysql_query($Consulta);  
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
	$Consulta1.=" where VPorden='".$Orden."' and VPtm='".$Tm."' and VPmaterial='".$Material."' and VPtipinv='".$Tipinv."' and VPordenrel='".$OrdenRel."' and VPordes='".$Ordes."' and VPaño='".$Ano."' and VPmes='".$Mes."'";
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
   $Resp=mysql_query($Consulta);  
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
