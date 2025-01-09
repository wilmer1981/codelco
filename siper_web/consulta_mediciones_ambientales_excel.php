<?php
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
<title>Consulta Mediciones Ambientales Excel</title>
</head>
<table width="90%" border="0" cellpadding="0" cellspacing="4">
      <tr>
        <td width="16%" height="28" align="right" class="formulario">Area Organizacional:</td>
        <td colspan="5" align="left">
		<?php
		$Codigo=ObtenerCodParent($SelTarea);
		$Consulta="select NAREA from sgrs_areaorg where CAREA = '".$Codigo."'";
		//echo $Consulta;
		$Resp=mysqli_query($link,$Consulta);
		$Fila=mysqli_fetch_array($Resp);
		echo $Fila[NAREA];

		?>
		&nbsp;</td>
      </tr>

      <tr>
        <td width="16%" height="28" align="right" class="formulario">Lugar de Medici&oacute;n:</td>
        <td width="18%" align="left">
		<?php
			$Consulta="select * from sgrs_lugares where CLUGAR='".$CmbLugares."'";
			$Resp=mysqli_query($link,$Consulta);
			if($Fila=mysqli_fetch_array($Resp))
				echo $Fila[NLUGAR]."  -> CORD_XYZ (".$Fila[CCORDX].",".$Fila[CCORDY].",".$Fila[CCORDZ];
		?></td>
        <td width="10%" align="right" class="formulario">MR:</td>
        <td width="21%" align="left"><?php echo $CmbMr;?></td>
        <td width="16%" align="right" nowrap="nowrap" class="formulario">Agente: </td>
        <td width="19%" align="left" nowrap="nowrap"><?php
			$Consulta="select t1.CAGENTE,t1.NAGENTE from sgrs_cagentes t1 where t1.CAGENTE='".$CmbAgentes."'";
			$Resp=mysqli_query($link,$Consulta);
			if($Fila=mysqli_fetch_array($Resp))
				echo $Fila[NAGENTE];
		  ?>        </td>
      </tr>
      <tr>
        <td height="25" align="right" class="formulario">Unidad Operativa:</td>
        <td align="left">
            <?php
			$Consulta="select t1.CAREA,t1.NAREA from sgrs_areaorg t1 where t1.CTAREA='5' and CAREA='".$CmbUnidOpe."'";
			$Resp=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resp);
			echo $Fila[NAREA];
		  ?>        </td>
        <td align="right" class="formulario"> Rango de Fechas: </td>
        <td align="left"> Desde <?php echo $TxtFechaIni; ?> Hasta <?php echo $TxtFechaFin; ?></td>
        <td align="right" class="formulario">Rango de Valor Magnitud:</td>
        <td align="left">Entre&nbsp; <?php echo $TxtMag; ?> Y <?php echo $TxtMag2; ?></td>
      </tr>
      <tr>
        <td height="25" align="right" class="formulario"><?php
		if($Nivel=='6')
			echo "Con Obs. de Gesti&oacute;n";	
		?></td>
        <td align="left"><?php 
		if($Nivel=='6'&&$CheckAccion<>'')
			echo "S";
		
		?></td>
        <td align="right" class="formulario">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="right" class="formulario">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr>
    </table>
	  <br>
		  <table width="95%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="20%" class="TituloCabecera" align="center">Ruta</td>
			<td width="20%" class="TituloCabecera" align="center">Area organizacional</td>
			<td width="15%" class="TituloCabecera" align="center">Lugar de Medici&oacute;n </td>
			<td width="2%" class="TituloCabecera" align="center">X</td>
			<td width="2%" class="TituloCabecera" align="center">Y</td>
			<td width="2%" class="TituloCabecera" align="center">Z</td>
			<td width="8%" class="TituloCabecera" align="center">Agente</td>
			<td width="8%" class="TituloCabecera" align="center">Magnitud</td>
			<td width="8%" class="TituloCabecera" align="center">LPP</td>
			<td width="8%" class="TituloCabecera" align="center">Unid.</td>
			<td width="8%" class="TituloCabecera" align="center">Dosis</td>
			<td width="8%" class="TituloCabecera" align="center">MR</td>
			<td width="15%" class="TituloCabecera" align="center">Fecha Inicio</td>
			<td width="15%" class="TituloCabecera" align="center">Fecha Término</td>
			<td width="10%" class="TituloCabecera" align="center">Informe</td>
			<?php
			if($Nivel=='6')
				echo "<td width='10%' class='TituloCabecera' align='center'>Acción Tomada</td>";
			?>
		 </tr>
		 <?php 
			$Consulta="select t1.REGACCIONES,t7.CPARENT,t7.NAREA,t5.TNARCHIVO,t5.CVINFORME,t1.CMEDAMB,t1.QDOSIS,t1.QMR,t1.QMEDICION,t1.FINICIO,t1.FTERMINO,t2.NAREA,t4.NLUGAR,t3.NAGENTE,t3.QLPP,t4.CCORDX,t4.CCORDY,t4.CCORDZ,t6.AUNIDAD from sgrs_medambientes t1 inner join sgrs_areaorg t2 on t1.CAREA=t2.CAREA ";
			$Consulta.="inner join sgrs_cagentes t3 on t1.CAGENTE=t3.CAGENTE inner join sgrs_unidades t6 on t3.CUNIDAD=t6.CUNIDAD inner join sgrs_lugares t4 on t1.CLUGAR = t4.CLUGAR inner join sgrs_informes t5 on t1.CINFORME=t5.CINFORME inner join sgrs_areaorg t7 on t1.CAREA=t7.CAREA where t1.CMEDAMB <> 0 ";
			switch($Buscar)
			{
				case "BG"://BUSCAR GENERAL
					if($SelTarea!='')
					{
						$CodNivel=ObtenerCodParent($SelTarea);
						$Consulta.=" and (t7.CPARENT like '%".$CodNivel."%' or t1.CAREA='".$CodNivel."') ";
					}
					if($CmbUnidOpe!='T')
						$Consulta.=" and t1.CAREA = '".$CmbUnidOpe."'";
					if($CmbLugares!='T')
						$Consulta.=" and  t4.CLUGAR = '".$CmbLugares."' ";
					if($CmbAgentes!='T')
						$Consulta.=" and  t1.CAGENTE = '".$CmbAgentes."%' ";
					if($CmbMr!='T')
						$Consulta.=" and  t1.QMR like '".$CmbMr."%' ";
					if($TxtFechaIni!=''&&$TxtFechaFin!='')
						$Consulta.=" and  t1.FINICIO >= '".FormatoFechaAAAAMMDD($TxtFechaIni)." 00:00:00'  and t1.FTERMINO <='".FormatoFechaAAAAMMDD($TxtFechaFin)." 23:59:59'";
					if($TxtMag!=''&&$TxtMag2!='')
						$Consulta.=" and  t1.QMEDICION >= '".str_replace(',','.',$TxtMag)."' and t1.QMEDICION <= '".str_replace(',','.',$TxtMag2)."'";	
						if($CheckAccion=='checked')
							$Consulta.=" and REGACCIONES <>''";	
					break;
			}
			$Consulta.="order by t4.NLUGAR";
			//echo $Consulta;
			$Resp=mysqli_query($link,$Consulta);echo "<input type='hidden' name='CheckRut'>";
			while($Fila=mysqli_fetch_array($Resp))
			{
				echo "<tr>";
				OrigenOrg($Fila[CPARENT],&$Ruta);
				echo "<td>".$Ruta."</td>";
				echo "<td align='left'>&nbsp;".$Fila[NAREA]."</td>";
				echo "<td align='left'>&nbsp;".$Fila[NLUGAR]."</td>";
				echo "<td>".$Fila[CCORDX]."</td>";
				echo "<td>".$Fila[CCORDY]."</td>";
				echo "<td>".$Fila[CCORDZ]."</td>";
				echo "<td align='left'>&nbsp;".$Fila[NAGENTE]."</td>";
				echo "<td>".$Fila[QMEDICION]."</td>";
				echo "<td>".$Fila[QLPP]."</td>";
				echo "<td>".$Fila[AUNIDAD]."</td>";
				echo "<td>".$Fila[QDOSIS]."</td>";
				echo "<td>".$Fila[QMR]."</td>";
				echo "<td>&nbsp;".$Fila[FINICIO]."</td>";
				echo "<td>&nbsp;".$Fila[FTERMINO]."</td>";
				echo "<td align='left'>".$Fila["CVINFORME"]."</td>";
				if($Nivel=='6')
					echo "<td align='center'>".$Fila[REGACCIONES]."</td>";
				echo "</tr>";
			}
		 ?>
	    </table>
</html>