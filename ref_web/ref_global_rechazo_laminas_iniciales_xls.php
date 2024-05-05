<?php
ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename = "";
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
	$DiaIni    = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
	$MesIni    = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$AnoIni    = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");
	$DiaFin    = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d");
	$MesFin    = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
	$AnoFin    = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?>
<html>
<head>
<title>Informe Rechazo de Laminas Iniciales(Globales)</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="632" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="7" class="ColorTabla01"><strong>Informe Rechazo Laminas Iniciales 
        (Globales) </strong></td>
    </tr>
    <tr> 
      <td width="90" class="Detalle02"><strong>Fecha Inicio:</strong></td>
      <td width="84" class="detalle01"><strong><?php echo $FechaInicio;?></strong>
	  <input name="AnoIni" type="hidden" value="<?php echo $AnoIni;?>">
	  <input name="MesIni" type="hidden" value="<?php echo $MesIni;?>">
	  <input name="DiaIni" type="hidden" value="<?php echo $DiaIni;?>"></td>
      <td width="51">&nbsp;</td>
      <td width="89" class="Detalle02"><strong>Fecha Termino:</strong></td>
      <td width="78" class="detalle01"><strong><?php echo $FechaTermino;?></strong>
	  <input name="AnoFin" type="hidden" value="<?php echo $AnoFin;?>">
	  <input name="MesFin" type="hidden" value="<?php echo $MesFin;?>">
	  <input name="DiaFin" type="hidden" value="<?php echo $DiaFin;?>"></td>
      <td width="47" >&nbsp;</td>
      <td width="162"><input name="graficar" type="button" value="Grafico" onClick="Grafico(this.form)" ></td>
    </tr>
  </table>
    <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"><input name="btnimprimir2" type="button" value="Excel" style="width:70;" onClick="JavaScript:Excel(this.form)"> 
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir(this.form)" value="Salir"></td>
  </tr>
</table>
<tr>
<td>&nbsp;</td>
</tr>
  <table width="594" border="2" align="center" cellpadding="2" cellspacing="2" bordercolor="#b26c4a" class="TablaDetalle">
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td width="87" align="center"><strong>Fecha</strong><strong></strong></td>
	  <?php $consulta_grupo="select distinct cod_grupo from ref_web.grupo_electrolitico2 where hojas_madres<>'0'"; 
	  	 $respuesta=mysqli_query($link, $consulta_grupo);
		 while ($row_grupos=mysqli_fetch_array($respuesta)) 
		       { 
                  echo '<td width="63" align="center"><strong>Grupo '.$row_grupos["cod_grupo"].'</strong></td>';
			   }	  
      ?>
	  <td width="63" align="center"><strong>Total</strong></td>
      </tr>
    <?php
	   $consulta_fecha="select distinct fecha from ref_web.produccion where fecha between '".$FechaInicio."' and '".$FechaTermino."'";
	   $respuesta_fecha=mysqli_query($link, $consulta_fecha);
	   while ($row_fecha=mysqli_fetch_array($respuesta_fecha))
	         {
			   echo '<tr>';
			   echo "<td align='center' class=detalle01>".$row_fecha["fecha"]."&nbsp</td>\n";
			   $consulta_grupo="select distinct cod_grupo from ref_web.grupo_electrolitico2 where hojas_madres<>'0'"; 
	  	       $respuesta=mysqli_query($link, $consulta_grupo);
			   $total_rechazos_dia=0;
		       while ($row_grupos=mysqli_fetch_array($respuesta)) 
		            {
					  $consulta_rechazos="select * from ref_web.produccion where cod_grupo='".intval($row_grupos["cod_grupo"])."' and fecha='".$row_fecha["fecha"]."'";
					  $respuesta_rechazos=mysqli_query($link, $consulta_rechazos);
					  $row_rechazos=mysqli_fetch_array($respuesta_rechazos);
					  $total_rechazos_grupo=$row_rechazos["rechazo_delgadas"]+$row_rechazos["rechazo_granuladas"]+$row_rechazos["rechazo_gruesas"];
					  echo "<td align='center' class=detalle01>".$total_rechazos_grupo."&nbsp</td>\n";
					  $total_rechazos_dia=$total_rechazos_dia+$total_rechazos_grupo;
                    }	  
			  echo "<td align='center' class=detalle01>".$total_rechazos_dia."&nbsp</td>\n";     
			 }
    ?>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>

