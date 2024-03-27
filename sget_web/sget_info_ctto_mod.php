<? 
    include("../principal/conectar_sget_web.php");

?>
<br>
<table width="100%" align="center" cellpadding="2" border="1" cellspacing="0">
<tr>
  <td width="20%" align="center" class="TituloCabecera">Tipo&nbsp;Modificaci�n</td>
  <td width="20%" align="center" class="TituloCabecera">Fecha</td>
  <td width="20%" align="center" class="TituloCabecera">Monto</td>
  <td width="40%"align="center" class="TituloCabecera">Observaci�n</td>
</tr>
<?
 	$Consulta=" SELECT * from sget_modificaciones_contrato t1 left join sget_tipo_modificacion t2 on t1.cod_tipo_modificacion=t2.cod_tipo_modificacion";
	$Consulta.="  where t1.cod_contrato ='".$Ctto."'";
 	$RespModificaciones=mysqli_query($link, $Consulta);
	while($FilaModificaciones=mysql_fetch_array($RespModificaciones))
	{
		?>
        <tr>
          <td > <? echo $FilaModificaciones[descrip_modificacion];?></td>
          <td  align="center"><? 
			if($FilaModificaciones["fecha"]=='0000-00-00')
				$fecha='';
			else
				$fecha=$FilaModificaciones["fecha"];	
			echo $fecha;?>
            &nbsp;</td>
          <td align="right"><? echo number_format($FilaModificaciones[monto],0,'','.');?>&nbsp;</td>
          <td><? echo $FilaModificaciones["observacion"];?>&nbsp;</td>
        </tr>
	<?
	}
	?>
</table>		