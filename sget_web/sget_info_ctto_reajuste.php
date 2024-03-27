<? 
    include("../principal/conectar_sget_web.php");

?>
<br>
<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
<tr>
<td width="20%" align="center" class="TituloCabecera">Fecha Reajustibilidad</td>
<td width="15%" align="center" class="TituloCabecera">Periodo</td>
<td width="20%" align="center" class="TituloCabecera">Fecha Real Reajuste</td>
<td width="15%" align="center" class="TituloCabecera">Monto</td>
<td width="20%" align="center" class="TituloCabecera">Monto Reajustado</td>
<td width="15%" align="center" class="TituloCabecera">Cambio</td>
<td width="15%" align="center" class="TituloCabecera">Estado</td>
</tr>
<?
 	$Consulta="SELECT t1.corr,t1.fecha_reajuste,t2.nombre_subclase as periodo,t1.fecha_reajustada,t1.monto,t1.monto_reajustado,t3.nombre_subclase as cambio,t1.estado from sget_reajustes_contratos t1 left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='30006' and t1.tipo_reajuste=t2.valor_subclase1 ";
	$Consulta.="left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='30002' and t1.tipo_cambio=t3.cod_subclase where t1.tipo='C' and t1.cod_contrato ='".$Ctto."' order by t1.fecha_reajuste";
	//echo $Consulta;
	$RespReaj=mysqli_query($link, $Consulta);
	while($FilaReaj=mysql_fetch_array($RespReaj))
	{
		?>
        <tr>
		  <td align="center"><? echo $FilaReaj[fecha_reajuste];?>&nbsp;</td>
          <td align="center"><? echo $FilaReaj[periodo];?>&nbsp;</td>
		  <td align="center"><? echo $FilaReaj[fecha_reajustada];?>&nbsp;</td>
		  <td align="center"><? echo number_format($FilaReaj[monto],0,'','.');?>&nbsp;</td>
		  <td align="center"><? echo number_format($FilaReaj[monto_reajustado],0,'','.');?>&nbsp;</td>
		  <td align="center"><? echo $FilaReaj[cambio];?>&nbsp;</td>
		  <td align="center">
		  <? 
			if($FilaReaj["estado"]=='L')	
				echo "<img src='archivos/btn_activo.png'   border='0' align='absmiddle' width='15' height='15'>";
			else
				echo "<img src='archivos/btn_inactivo.png'   border='0' align='absmiddle' width='15' height='15'>";
			
		  ?>&nbsp;</td>
        </tr>	<?
	}
	?>
</table>		