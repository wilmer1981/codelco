<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
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
	include("../principal/conectar_principal.php"); 
 	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaAux = $FechaInicio;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	if (isset($CodLote) && isset($NumLote))
	{
		$Consulta = "SELECT t1.corr_enm, t1.cod_bulto, t1.num_bulto, t1.corr_enm, t2.cod_producto, t2.cod_subproducto, t3.descripcion,";
		$Consulta.= " t1.cod_marca, t4.descripcion as marca, count(*) as bulto_paquetes, sum(t2.peso_paquetes) as bulto_peso";
		$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2";
		$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
		$Consulta.= " inner join proyecto_modernizacion.subproducto t3";
		$Consulta.= " on t2.cod_producto = t3.cod_producto and t2.cod_subproducto = t3.cod_subproducto ";
		$Consulta.= " inner join sec_web.marca_catodos t4 on t1.cod_marca = t4.cod_marca";
		$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."'  ";
		$Consulta.= " group by t1.cod_bulto, t1.num_bulto";
		$Respuesta = mysqli_query($link, $Consulta);
		//echo $Consulta;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Producto 		= $Fila["cod_producto"];
			$SubProducto 	= $Fila["cod_subproducto"];
			$DescProducto 	= $Fila["descripcion"];
			$CorrEnm  		= $Fila["corr_enm"];
			$Fechita     	= $Fila["fecha_creacion_lote"];
			
			$Consulta = "SELECT count(*) as existe from sec_web.programa_enami ";
			$Consulta.= " where corr_enm = '".$Fila["corr_enm"]."'";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				if ($Fila2["existe"] > 0)
				{
					$Cliente = "ENAMI";
				}
				else
				{
					$Consulta = "SELECT count(*) as existe from sec_web.programa_codelco ";
					$Consulta.= " where corr_codelco = '".$Fila["corr_enm"]."'";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))		
					{
						if ($Fila2["existe"] > 0)
						{
							$Cliente = "CODELCO";
						}
						else
						{
							$Cliente = "&nbsp;";
						}
					}
				}
			}
			$CodMarca = $Fila["cod_marca"];
			$Marca = $Fila["marca"];
			$TotPaquetes = $Fila["bulto_paquetes"];
			$TotPeso = $Fila["bulto_peso"];
			$Consulta = "SELECT sum(num_unidades) as unidades";
			$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
			$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
			$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."'";
			$Consulta.= " group by t1.cod_bulto, t1.num_bulto ";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
				$TotUnidades = $Fila2["unidades"];
			else
				$TotUnidades = 0;
		}
	}
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "R":
			f.action = "sec_con_inf_pesaje_lote_emb.php";
			f.submit();
			break;
		case "E":
		
					

			f.action = "sec_con_inf_pesaje_lote_emb_excel.php?ENM=<?php echo $CorrEnm; ?>";
			f.submit();
			break;
		case "S":
			f.action= "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
function Recarga(URL,LimiteIni)
{
	var frm=document.frmPrincipal;
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "?LimitIni=" + LimiteIni;
	frm.submit(); 
}

</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php
	$LimitFin=55;
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 55;
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">

  <table width="500" border="0" align="center" cellpadding="2" cellspacing="1">
    <tr> 
      <td colspan="2" align="center"><strong>LISTADO DE PESAJE DE LOTE DE EMBARQUE</strong></td>
    </tr>
  </table>
  <br>
  <table width="650" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
    <tr> 
      <td width="116"><strong>CODIGO LOTE: </strong></td>
      <td width="520"><SELECT name="CodLote" id="CodLote">
      		<?php
			$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '3004' order by nombre_subclase";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				if ($Fila["nombre_subclase"] == $CodLote)
					echo "<option SELECTed value = '".$Fila["nombre_subclase"]."'>".strtoupper($Fila["nombre_subclase"])."</option>\n";
				else
					echo "<option value = '".$Fila["nombre_subclase"]."'>".strtoupper($Fila["nombre_subclase"])."</option>\n";
			}
			?>
        	</SELECT> <input name="NumLote" type="text" id="NumLote" value="<?php echo $NumLote?>" size="15">
        	<strong>Lineas por p&aacute;gina : </strong>
       	<input name="LimitFin" type="text" id="LimitFin" value="<?php echo $LimitFin;?>" size="12" maxlength="12">		</td>
    </tr>
    <tr> 
      <td><strong>PRODUCTO:</strong></td>
      <td><strong><?php echo $Producto; ?></strong></td>
    </tr>
    <tr> 
      <td><strong>DESCRIPCION:</strong></td>
      <td><strong><?php echo $DescProducto ?></strong></td>
    </tr>
	<tr>
		<td><strong>INST.EMBARQUE:</strong></td>
		<td><strong><?php echo $CorrEnm ?></strong></td>
	</tr>
    <tr> 
      <td><strong>CLIENTE:</strong></td>
      <td><strong><?php echo $Cliente ?></strong></td>
    </tr>
    <tr> 
      <td><strong>MARCA:</strong></td>
      <td><strong><?php 
		if (isset($CodMarca))
	  		echo $CodMarca." / ".$Marca;
	  	else
			echo "&nbsp;";
		?></strong></td>
    </tr>
    <tr> 
      <td><strong>TOTAL PAQUETES:</strong></td>
      <td><strong><?php 
		if (isset($TotPaquetes))
			echo number_format($TotPaquetes,0,",",".");
		else
			echo "&nbsp;";
		?></strong></td>
    </tr>
    <tr> 
      <td><strong>TOTAL PESO:</strong></td>
      <td><strong><?php 
		if (isset($TotPeso))
			echo number_format($TotPeso,0,",",".");
		else
			echo "&nbsp;";	
		 ?></strong></td>
    </tr>
    <tr>
      <td><strong>TOTAL UNIDADES:</strong></td>
      <td><strong><?php 
		if (isset($TotUnidades))
			echo number_format($TotUnidades,0,",",".");
		else
			echo "&nbsp;";
		?></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="button2" type="submit" id="button4" value="Consultar" onClick="Proceso('R');" style="width:70px">
      <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')">
      <input name="btnExcel2" type="button" id="btnExcel2" style="width:70" onClick="JavaScript:Proceso('E')" value="Excel">
      <input name="btnsalir22" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"></td>
    </tr>
  </table>
<br>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="90">SERIE</td>
      <td width="105">PESO NETO</td>
      <td width="73">GRUPO</td>
      <td width="95">UNIDADES</td>
      <td width="190">UBICACION</td>
    </tr>
    <?php
	$Consulta = "SELECT * from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
	$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."' ";
	$Consulta.= " order by t1.cod_paquete,t1. num_paquete asc ";
	$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
    //echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalCortes = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["cod_paquete"]."-".$Fila["num_paquete"]."</td>\n";
		echo "<td align='center'>".$Fila["peso_paquetes"]."</td>\n";
		echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
		echo "<td align='center'>".$Fila["num_unidades"]."</td>\n";
		$Consulta = "SELECT * from ram_web.atributo_existencia ";
		$Consulta.= " where cod_existencia = '".$Fila["cod_lugar"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
			echo "<td align='left'>".$Fila2["abrev_existencia"]." - ".$Fila2["nombre_existencia"]."</td>\n";
		else
			echo "<td align='left'>&nbsp;</td>\n";
		echo "</tr>\n";
		$TotalCortes++;
	}
	?>
	</table>
<br>
<br>
</form>
</body>
</html>
