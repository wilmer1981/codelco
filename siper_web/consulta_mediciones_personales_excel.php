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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consulta Mediciones Personales Excel</title>
</head>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<body>
<form name="MantenedorPel" method="post" >
	<table width="90%" border="0" cellpadding="0" cellspacing="4">
      <tr>
        <td width="16%" height="28" align="right" class="formulario">Area Organizacional:</td>
        <td colspan="5" align="left">
		<?
		$Codigo=ObtenerCodParent($SelTarea);
		$Consulta="SELECT NAREA from sgrs_areaorg where CAREA = '".$Codigo."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
		echo $Fila[NAREA];

		?>
		&nbsp;</td>
      </tr>
      <tr>
        <td width="16%" height="28" align="right" class="formulario">Rut:</td>
        <td width="18%" align="left"><? echo $TxtRut;?></td>
        <td width="10%" align="right" class="formulario">Apellido Paterno:</td>
        <td width="21%" align="left"><? echo $TxtApePat;?></td>
        <td width="16%" align="right" nowrap="nowrap" class="formulario">Agente:		</td>
	    <td width="19%" align="left" nowrap="nowrap">
		  <?
			$Consulta="SELECT t1.CAGENTE,t1.NAGENTE from sgrs_cagentes t1 where t1.CAGENTE='".$CmbAgentes."'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
				echo $Fila[NAGENTE];
		  ?>	  </td>
      </tr>
      <tr>
        <td height="25" align="right" class="formulario">MR:</td>
        <td align="left">
		<?
			switch($CmbMr)
			{
				case "ACEPTABLE":
					echo "Aceptable";
				break;
				case "MODERADO":
					echo "Moderado";
				break;
				case "INACEPTABLE":
					echo "Inaceptable";
				break;
			}
		?>		</td>
        <td align="right" class="formulario"> Rango de Fechas: </td>
        <td align="left">
		Desde
		<? echo $TxtFechaIni; ?>
		Hasta
		<? echo $TxtFechaFin; ?></td>
        <td align="right" class="formulario">Rango de Valor Magnitud:</td>
        <td align="left">Entre&nbsp;
		<? echo $TxtMag; ?> Y
		<? echo $TxtMag2; ?></td>
      </tr>
      <tr>
        <td height="25" align="right" class="formulario">Ocupaci&oacute;n:</td>
        <td align="left">		  <?
			$Consulta="SELECT t1.NOCUPACION from sgrs_ocupaciones t1 where t1.COCUPACION='".$CmbOcupacion."'";
			$Resp=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resp);
				echo $Fila[NOCUPACION];
		  ?>&nbsp;</td>
        <td align="right" class="formulario">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="right" class="formulario">
		<?
		if($Nivel=='6')
			echo "Con Obs. de Gesti�n";	
		?>
		</td>
        <td align="left">
		<? 
		if($Nivel=='6'&&$CheckAccion<>'')
			echo "S";
		
		?>&nbsp;</td>
      </tr>
    </table>
		  <table width="100%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="13%" class="TituloCabecera" align="center">Ruta</td>
			<td width="13%" class="TituloCabecera" align="center">Area Organ.</td>
			<td width="25%" class="TituloCabecera" align="center">Persona</td>
			<td width="10%" class="TituloCabecera" align="center">Agente</td>
			<td width="5%" class="TituloCabecera" align="center">Magnitud</td>
			<td width="4%" class="TituloCabecera" align="center">LPP</td>
			<td width="4%" class="TituloCabecera" align="center">Unid.</td>
			<td width="4%" class="TituloCabecera" align="center">Dosis</td>
			<td width="4%" class="TituloCabecera" align="center">MR</td>
			<td width="13%" class="TituloCabecera" align="center">Ocupaci�n</td>
			<td width="10%" class="TituloCabecera" align="center">Fecha Inicio</td>
			<td width="10%" class="TituloCabecera" align="center">Fecha T�rmino</td>
			<td width="10%" class="TituloCabecera" align="center">Informe</td>
			<?
			if($Nivel=='6')
				echo "<td width='10%' class='TituloCabecera' align='center'>Acci�n Tomada</td>";
			?>
		 </tr>
		 <? 
				$Consulta="SELECT t1.REGACCIONES,t7.CPARENT,t7.NAREA,t3.QLPP,t5.TNARCHIVO,t5.CVINFORME,t1.CMEDPERSONAL,t1.QMEDICION,t1.QMR,t1.QDOSIS,t1.FINICIO,t1.FTERMINO,t4.NOCUPACION,t2.rut,t2.ape_paterno,t2.ape_materno,t2.nombres,T3.NAGENTE,t6.AUNIDAD from sgrs_medpersonales t1 inner join uca_web.uca_personas t2 on t1.CRUT=t2.RUT and t2.estado='A' and t2.tipo='C' ";
				$Consulta.="inner join sgrs_cagentes t3 on t1.CAGENTE=t3.CAGENTE inner join sgrs_unidades t6 on t3.CUNIDAD=t6.CUNIDAD inner join sgrs_ocupaciones t4 on t1.COCUPACION=t4.COCUPACION inner join sgrs_informes t5 on t1.CINFORME=t5.CINFORME inner join sgrs_areaorg t7 on t1.CAREA=t7.CAREA where t1.CRUT <> 0 ";
				switch($Buscar)
				{
					case "BG"://BUSCAR GENERAL
						if($SelTarea!='')
						{
							$CodNivel=ObtenerCodParent($SelTarea);
							$Consulta.=" and (t7.CPARENT like '%".$CodNivel."%' or t1.CAREA='".$CodNivel."') ";
						}
						if($TxtRut!='')
							$Consulta.=" and t1.CRUT like '".$TxtRut."%'";
						if($TxtApePat!='')
							$Consulta.=" and  t2.ape_paterno like '".$TxtApePat."%' ";
						if($CmbAgentes!='T')
							$Consulta.=" and  t1.CAGENTE = '".$CmbAgentes."%' ";
						if($CmbOcupacion!='T')
							$Consulta.=" and  t1.COCUPACION = '".$CmbOcupacion."%' ";
							
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
				$Consulta.="group by t2.rut,t1.CMEDPERSONAL order by t2.ape_paterno";
				//echo $Consulta;
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					echo "<tr>";
					OrigenOrg($Fila[CPARENT],&$Ruta);
					echo "<td>".$Ruta."</td>";
					echo "<td>".$Fila[NAREA]."</td>";
					echo "<td align='left'>&nbsp;".str_pad($Fila["rut"],10,'0',STR_PAD_LEFT)." - ".$Fila[ape_paterno]." ".$Fila[ape_materno]." ".$Fila["nombres"]."</td>";
					echo "<td align='left'>&nbsp;".$Fila[NAGENTE]."</td>";
					echo "<td>".$Fila[QMEDICION]."</td>";
					echo "<td>".$Fila[QLPP]."</td>";
					echo "<td>".$Fila[AUNIDAD]."</td>";
					echo "<td>".$Fila[QDOSIS]."</td>";
					echo "<td align='left'>".$Fila[QMR]."</td>";
					echo "<td align='left'>".$Fila[NOCUPACION]."</td>";
					echo "<td>&nbsp;".$Fila[FINICIO]."</td>";
					echo "<td>&nbsp;".$Fila[FTERMINO]."</td>";
					echo "<td align='left'>".$Fila["CVINFORME"]."</td>";
					if($Nivel=='6')
						echo "<td align='center'>".$Fila[REGACCIONES]."</td>";
					echo "</tr>";
				}
		 ?>
	    </table>
</form>
</body>
</html>