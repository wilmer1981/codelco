<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
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
		
		$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date('d');
		$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date('m');
		$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date('Y');
		$DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date('d');
		$MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date('m');
		$AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date('Y');
	
		$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
		$CodLote = isset($_REQUEST["CodLote"])?$_REQUEST["CodLote"]:"";
		$NumLote = isset($_REQUEST["NumLote"])?$_REQUEST["NumLote"]:"";
	
		$Producto = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
		$DescProducto = isset($_REQUEST["DescProducto"])?$_REQUEST["DescProducto"]:"";
		$CorrEnm = isset($_REQUEST["CorrEnm"])?$_REQUEST["CorrEnm"]:"";
		$Cliente = isset($_REQUEST["Cliente"])?$_REQUEST["Cliente"]:"";
		
		$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date('Y');


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
	$Var10 = 0.0;
	if (isset($CodLote) && isset($NumLote))
	{
		$Consulta = "SELECT t1.cod_bulto, t1.num_bulto, t1.corr_enm, t2.cod_producto, t2.cod_subproducto, t3.descripcion,";
		$Consulta.= " t1.cod_marca, t4.descripcion as marca, count(*) as bulto_paquetes, sum(t2.peso_paquetes) as bulto_peso";
		$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2";
		$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
		$Consulta.= " inner join proyecto_modernizacion.subproducto t3";
		$Consulta.= " on t2.cod_producto = t3.cod_producto and t2.cod_subproducto = t3.cod_subproducto ";
		$Consulta.= " inner join sec_web.marca_catodos t4 on t1.cod_marca = t4.cod_marca";
		$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."'  ";
		$Consulta.= " and year(t1.fecha_creacion_lote) = '".$CmbAno."'";
		$Consulta.= " group by t1.cod_bulto, t1.num_bulto";
		$Respuesta = mysqli_query($link, $Consulta);
		//echo $Consulta;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Producto = $Fila["cod_producto"];
			$SubProducto = $Fila["cod_subproducto"];
			$DescProducto = $Fila["descripcion"];
			$CorrEnm  		= $Fila["corr_enm"];
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
			$Consulta.= " where t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."'";
			$Consulta.= " and year(t1.fecha_creacion_lote) = '".$CmbAno."'";
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="500" border="0" cellpadding="2" cellspacing="1">
    <tr> 
      <td colspan="5" align="center"><strong>LISTADO DE PESAJE DE LOTE DE EMBARQUE</strong></td>
    </tr>
  </table>
  <br>
  <table border="1" cellpadding="2" cellspacing="1">
    <tr> 
      <td width="114" colspan="2">CODIGO LOTE: </td>
      <td width="375" colspan="3"><?php echo $CodLote."-".$NumLote ?> <font size="1"><font size="2"><font size="1"><font size="2"><font size="1"><font size="1"><font size="2"><font size="1"><font size="2"><font size="1"><font size="2">
        <SELECT name="CmbAno" size="1" id="SELECT9" style="width:70px;" onChange="Recarga1();">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAno))
				{
					if ($i==$CmbAno)
						{
							echo "<option SELECTed value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}/*
				else
				{
					if ($i==date("Y"))
						{
							echo "<option SELECTed value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}*/		
			}
			?>
        </SELECT>
        </font></font></font></font></font></font></font></font></font></font></font></td>
    </tr>
    <tr> 
      <td colspan="2">PRODUCTO:</td>
      <td colspan="3"><?php echo $Producto; ?></td>
    </tr>
    <tr> 
      <td colspan="2">DESCRIPCION:</td>
      <td colspan="3"><?php echo $DescProducto ?></td>
    </tr>
    <tr> 
      <td colspan="2">CLIENTE:</td>
      <td colspan="3"><?php echo $Cliente ?></td>
    </tr>
    <tr> 
      <td colspan="2">MARCA:</td>
      <td colspan="3"><?php 
		if (isset($CodMarca))
	  		echo $CodMarca." / ".$Marca;
	  	else
			echo $Var10;
		?></td>
    </tr>
    <tr> 
      <td colspan="2">TOTAL PAQUETES:</td>
      <td colspan="3"><?php 
		if (isset($TotPaquetes))
			echo number_format($TotPaquetes,0,",",".");
		else
			echo number_format($Var10,0,",",".");
		?></td>
    </tr>
    <tr> 
      <td colspan="2">TOTAL PESO:</td>
      <td colspan="3"><?php 
		if (isset($TotPeso))
			echo number_format($TotPeso,0,",",".");
		else
			echo number_format($Var10,0,",",".");	
		 ?></td>
    </tr>
    <tr>
      <td colspan="2">TOTAL UNIDADES:</td>
      <td colspan="3"><?php 
		if (isset($TotUnidades))
			echo number_format($TotUnidades,0,",",".");
		else
			echo number_format($Var10,0,",",".");
		?></td>
    </tr>
  </table>
<br>
  <table border="1" cellpadding="0" cellspacing="0">
    <tr align="center"> 
      <td width="90">SERIE</td>
      <td width="105">PESO NETO</td>
      <td width="73">GRUPO</td>
      <td width="95">UNIDADES</td>
      <td width="190">UBICACION</td>
    </tr>
    <?php
	$Consulta = "SELECT * from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
	$Consulta.= " where t1.cod_bulto = '".$CodLote."' and t1.num_bulto = '".$NumLote."' ";
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.corr_enm = '".$CorrEnm."'";
	$Consulta.= " and year(t1.fecha_creacion_lote) = '".$CmbAno."'";
	$Consulta.= " order by t1.cod_paquete,t1. num_paquete asc ";
//	$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
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
			echo "<td align='left'>  </td>\n";
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
