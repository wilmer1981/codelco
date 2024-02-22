<? 
    include("../principal/conectar_sget_web.php");

?>
<br>
<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
<tr>
<td width="5%" align="center" class="TituloCabecera">Info.Ctto.</td>
<td width="15%" align="center" class="TituloCabecera">Rut Empresa</td>
<td width="68%" align="center" class="TituloCabecera">Raz�n Social</td>
<td width="12%" align="center" class="TituloCabecera">Fecha Reunion Arranque</td>
</tr>
<?
 	$Consulta=" SELECT t1.*,t2.razon_social from sget_sub_contratistas t1 left join sget_contratistas t2 on t1.rut_empresa=t2.rut_empresa";
	$Consulta.="  where t1.cod_contrato ='".$Ctto."'";
	$RespModificaciones=mysql_query($Consulta);
	while($FilaModificaciones=mysql_fetch_array($RespModificaciones))
	{

		?>
         <tr>
		 <td width="5%" colspan="1"  align="center"><a  href="sget_info_ctto_ac.php?Ctto=<? echo $FilaModificaciones["cod_contrato"];?>&Emp=<? echo $FilaModificaciones[rut_empresa];?>"  target="_blank"><img src="archivos/info2.png"   alt="Detalle Contrato y Personal"  border="0" align="absmiddle" /></a></td>
		 <td width="15%" colspan="1"  align="center"><a href="sget_info_empresa.php?Emp=<? echo $FilaModificaciones[rut_empresa];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Empresa" border="0" width='23' height='23' align="absmiddle" /></a>&nbsp;<? echo FormatearRun($FilaModificaciones[rut_empresa]);?>&nbsp;</td>
         <td width="68%" colspan="1"  align="left"><? echo FormatearNombre($FilaModificaciones[razon_social]);?>&nbsp;</td>
         <td width="12%" colspan="1"  align="center"><? echo $FilaModificaciones[reunion_arranque];?>&nbsp;</td>
		 </tr>
	<?
	}
	?>
</table>		