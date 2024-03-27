<?
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');	

	ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
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
	$Nivel=ObtieneNivelUsuario($CookieRut);
	if(!isset($CheckAccion))
		$CheckAccion='';
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/siper_funciones.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consulta Examenes Laboratorio Excel</title>
</head>
<table width="90%" border="0" cellpadding="0" cellspacing="4">
  <tr>
    <td width="16%" height="28" align="right" class="formulario">Rut:</td>
    <td width="18%" align="left"><? echo $TxtRut;?></td>
    <td width="10%" align="right" class="formulario">Apellido Paterno:</td>
    <td width="21%" align="left"><? echo $TxtApePat;?></td>
    <td width="16%" align="right" nowrap="nowrap" class="formulario">Tipo Examen:: </td>
    <td width="19%" align="left" nowrap="nowrap">
				  <?
					$Consulta="SELECT t1.NEXAMEN from sgrs_codexlaboratorio t1 where t1.CTEXAMEN='".$CmbTipoExamen."'";
					$Resp=mysqli_query($link, $Consulta);
					if($Fila=mysql_fetch_array($Resp))
						echo $Fila[NEXAMEN];
				  ?>    </td>
  </tr>
  <tr>
    <td height="25" align="right" class="formulario">Evaluaci&oacute;n:</td>
    <td align="left">
		  <?
				switch($CmbEvaluacion)
				{
					case "0":
						echo "NORMAL";
					break;
					case "2":
						echo "MODERADO";
					break;
					case "1":
						echo "ALTERADO";
					break;
				}
		  ?>    </td>
    <td align="right" class="formulario"> Rango de Fechas: </td>
    <td align="left"> Desde <? echo $TxtFechaIni; ?> Hasta <? echo $TxtFechaFin; ?></td>
    <td align="right" class="formulario">Rango de Valor Magnitud:</td>
    <td align="left">Entre&nbsp; <? echo $TxtMag; ?> Y <? echo $TxtMag2; ?></td>
  </tr>
  <tr>
    <td height="25" align="right" class="formulario">Ocupaci&oacute;n:</td>
    <td align="left"><? echo $TxtOcup;?>&nbsp;</td>
    <td align="right" class="formulario">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right" class="formulario"><?
		if($Nivel=='6')
			echo "Con Obs. de Gesti&oacute;n";	
		?></td>
    <td align="left"><? 
		if($Nivel=='6'&&$CheckAccion<>'')
			echo "S";
		
		?></td>
  </tr>
</table>
<br>
	<table width="95%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="38%" class="TituloCabecera" align="center">Persona</td>
			<td width="10%" class="TituloCabecera" align="center">Examen</td>
			<td width="9%" class="TituloCabecera" align="center">Resultado</td>
			<td width="10%" class="TituloCabecera" align="center">Parametro</td>
			<td width="8%" class="TituloCabecera" align="center">Unid.</td>
			<td width="5%" class="TituloCabecera" align="center">Evaluacion</td>
			<td width="10%" class="TituloCabecera" align="center">Ocupaci�n</td>
			<td width="13%" class="TituloCabecera" align="center">Fecha Toma </td>
			<td width="10%" class="TituloCabecera" align="center">Informe</td>
			<?
			if($Nivel=='6')
				echo "<td width='10%' class='TituloCabecera' align='center'>Acci�n Tomada</td>";
			?>
	    </tr>
		 <? 
			if($Buscar!='')
			{
				$Consulta="SELECT t1.REGACCIONES,t1.CEXAMEN,t1.QVALOR,t1.FEXAMEN,t1.CEVALUACION,t7.CVINFORME,t7.TNARCHIVO,t4.NOCUPACION,t2.rut,t2.ape_paterno,t2.ape_materno,t2.nombres,t3.NEXAMEN,t3.QPARAMETRO,t6.AUNIDAD from sgrs_exlaboratorio t1 inner join uca_web.uca_personas t2 on t1.CRUT=t2.rut ";
				$Consulta.="inner join sgrs_codexlaboratorio t3 on t1.CTEXAMEN=t3.CTEXAMEN left join sgrs_ocupaciones t4 on t1.COCUPACION=t4.COCUPACION left join sgrs_informes t7 on t1.CINFORME=t7.CINFORME inner join sgrs_unidades t6 on t3.CUNIDAD=t6.CUNIDAD where t1.CRUT <> 0 ";
				switch($Buscar)
				{
					case "BG"://BUSCAR GENERAL
						if($TxtRut!='')
							$Consulta.=" and t1.CRUT like '".$TxtRut."%'";
						if($TxtApePat!='')
							$Consulta.=" and  t2.ape_paterno like '".$TxtApePat."%' ";
						if($CmbTipoExamen!='T')
							$Consulta.=" and  t1.CTEXAMEN = '".$CmbTipoExamen."' ";
						if($CmbEvaluacion!='T')
							$Consulta.=" and  t1.CEVALUACION = '".$CmbEvaluacion."' ";
						if($TxtFechaIni!=''&&$TxtFechaFin!='')
							$Consulta.=" and  t1.FEXAMEN between '".FormatoFechaAAAAMMDD($TxtFechaIni)."' and '".FormatoFechaAAAAMMDD($TxtFechaFin)."'";
						if($TxtMag!=''&&$TxtMag2!='')
							$Consulta.=" and  t1.QVALOR>= '".str_replace(',','.',$TxtMag)."' and t1.QVALOR <= '".str_replace(',','.',$TxtMag2)."'";
						if($TxtOcup!='')
							$Consulta.=" and  t4.NOCUPACION like '".$TxtOcup."%' ";	
						if($CheckAccion=='checked')
							$Consulta.=" and REGACCIONES <>''";	
					break;
				}
				$Consulta.="group by t2.rut,t1.CEXAMEN order by t2.ape_paterno";
				//echo $Consulta;
				$Resp=mysqli_query($link, $Consulta);echo "<input type='hidden' name='CheckRut'>";
				while($Fila=mysql_fetch_array($Resp))
				{
					echo "<tr>";
					echo "<td align='left'>&nbsp;".str_pad($Fila["rut"],8,'0',STR_PAD_LEFT)." - ".$Fila[ape_paterno]." ".$Fila[ape_materno]." ".$Fila["nombres"]."</td>";
					echo "<td align='left'>&nbsp;".$Fila[NEXAMEN]."</td>";
					echo "<td>".$Fila[QVALOR]."</td>";
					echo "<td>".$Fila[QPARAMETRO]."</td>";
					echo "<td>".$Fila[AUNIDAD]."</td>";
					switch($Fila[CEVALUACION])
					{
						case "0":
							echo "<td align='left'>NORMAL</td>";
						break;
						case "2":
							echo "<td align='left'>MODERADO</td>";
						break;
						case "1":
							echo "<td align='left'>ALTERADO</td>";
						break;
					}
					echo "<td align='left'>".$Fila[NOCUPACION]."&nbsp;</td>";
					echo "<td align='center'>&nbsp;".$Fila[FEXAMEN]."</td>";
					if(is_null($Fila["CVINFORME"]))
						echo "<td align='left'>&nbsp;</td>";
					else
						echo "<td align='left'>".$Fila["CVINFORME"]."</td>";
					if($Nivel=='6')
						echo "<td align='center'>".$Fila[REGACCIONES]."</td>";
					echo "</tr>";
				}
			}	
		 ?>
</table>
</html>