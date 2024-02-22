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
	//NOMBRE SUBPRODUCTO
	$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomSubProducto = $Fila["descripcion"];
	else	$NomSubProducto = "&nbsp;";
	//NOMBRE DEFECTO
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='2008' and cod_subclase='".$Defecto."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomDefecto = $Fila["nombre_subclase"];
	else	$NomDefecto = "&nbsp;";
	
	if ($Producto == 17 && ($SubProducto==4 || $SubProducto==8))
	{
		$ColSpan1="6";
		$ColSpan="4";
	}
	else
	{
		$ColSpan1="5";
		$ColSpan="3";
	}
?>
<html>
<head>
<title>Detalle Inspeccion</title>
</head>

<body>
<form name="frmDetalle" action="" method="post">
<table width="450" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr align="center">
    <td colspan="<?php echo $ColSpan1?>"><strong>DETALLE INSPECCION DE ACUERDO A DEFECTO </strong></td>
  </tr>
  <tr>
    <td colspan="<?php echo $ColSpan1 ?>">&nbsp;</td>
  </tr>
  <tr>
    <td width="105" colspan="2">SUBPRODUCTO</td>
    <td width="327" colspan="<?php echo $ColSpan ?>"><?php echo $NomSubProducto; ?></td>
  </tr>
  <tr>
    <td colspan="2">DEFECTO</td>
    <td colspan="<?php echo $ColSpan ?>"><?php echo $NomDefecto; ?></td>
  </tr>
<?php  
	if ($Producto == 17 && ($SubProducto==4 || $SubProducto==8))
	{
		echo "<tr>\n";
		echo "<td colspan='2'>HORNO</td>\n";
		echo "<td colspan='".$ColSpan."'>";
		switch ($Horno)
		{
			case 1:
				echo "HORNO 1";
				break;
			case 2:
				echo "HORNO 2";
				break;
			case 4:
				echo "HORNO BASC.";
				break;
			case "T":
				echo "TODOS";
				break;
		}
		echo "</td>\n";
		echo "</tr>\n";
	}
?> 
  <tr align="center" class="ColorTabla01">
    <td colspan="<?php echo $ColSpan1 ?>">&nbsp;</td>
    </tr>
  <tr align="center" class="ColorTabla01">
    <td width="105">Hornada</td>
    <td width="83">Recuperables</td>
    <td width="327">Rechazados</td>
    <td width="67">Total</td>
    <td width="114">Fecha</td>
<?php	
	if ($Producto == 17 && ($SubProducto==4 || $SubProducto==8))
   		echo "<td width='91'>Rueda</td>\n";
?>	
  </tr>
<?php  
	$Consulta = "SELECT * from sea_web.rechazos ";
	$Consulta.= " where fecha_ini between '".$Ano."-".$Mes."-01 00:00:00' and '".$Ano."-".$Mes."-31 23:59:59'";
	$Consulta.= " and cod_defecto = '".$Defecto."'";
	$Consulta.= " and cod_producto = '".$Producto."' and cod_subproducto='".$SubProducto."' ";
	if (($Producto == 17 && ($SubProducto==4 || $SubProducto==8)) && ($Horno<>"T"))
		{
			switch ($Horno)
			{
				case "1":
					$Consulta.= " and substring(hornada,7) between '1000' and '1999'";		
					break;
				case "2":
					$Consulta.= " and substring(hornada,7) between '2000' and '2999'";		
					break;
				case "4":
					$Consulta.= " and substring(hornada,7) between '4000' and '4999'";		
					break;
			}
		}
	$Consulta.= " and (recuperables<>0 or rechazados<>0)";
	$Consulta.= " order by rueda, fecha_ini, hornada";
	$Resp = mysqli_query($link, $Consulta);
	$TotalRecu=0;
	$TotalRech=0;
	$Total=0;	
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr align='right'>\n";
		echo "<td align='center'>".substr($Fila["hornada"],6)."</td>\n";
		echo "<td>".$Fila["recuperables"]."</td>\n";
		echo "<td>".$Fila["rechazados"]."</td>\n";
		echo "<td>".($Fila["recuperables"] + $Fila["rechazados"])."</td>\n";
		echo "<td>".substr($Fila["fecha_ini"],8,2)."-".substr($Fila["fecha_ini"],5,2)."-".substr($Fila["fecha_ini"],0,4)."</td>\n";
		if ($Producto == 17 && ($SubProducto==4 || $SubProducto==8))
			echo "<td>".$Fila["rueda"]."</td>\n";
		echo "</tr>\n";
		$TotalRecu=$TotalRecu + $Fila["recuperables"];
		$TotalRech=$TotalRech + $Fila["rechazados"];
		$Total=$Total + ($Fila["recuperables"] + $Fila["rechazados"]);		
	}
?>
  <tr align="right" class="ColorTabla02">
    <td align="center">TOTAL</td>
    <td><?php echo number_format($TotalRecu,0,",","."); ?></td>
    <td><?php echo number_format($TotalRech,0,",","."); ?></td>
    <td><?php echo number_format($Total,0,",","."); ?></td>
<?php	
	if ($Producto == 17 && ($SubProducto==4 || $SubProducto==8))
    	echo "<td colspan='2'>&nbsp;</td>\n";
	else
		echo "<td colspan='1'>&nbsp;</td>\n";
?>
  </tr>
</table>
</form>
</body>
</html>
