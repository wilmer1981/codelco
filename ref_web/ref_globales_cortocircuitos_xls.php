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

	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y"); 
	$cmbcircuito = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:""; 
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
<title>Informe de Cortocircuitos Globales </title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="632" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="7" class="ColorTabla01"><strong>INFORME DE GLOBAL DE CORTOCIRCUITOS</strong></td>
    </tr>
    <tr> 
      <td width="90" class="Detalle02"><strong>Fecha Inicio:</strong></td>
      <td width="84" class="detalle01"><strong><?php echo $FechaInicio;?></strong>
	
      <td width="51">&nbsp;</td>
      <td width="136" class="Detalle02"><strong>Fecha Termino:</strong></td>
      <td width="101" class="detalle01"><strong><?php echo $FechaTermino;?></strong>
	</td>
      <td width="29" >&nbsp;</td>
      <td width="113"><input name="graficar" type="button" value="Grafico" onClick="Grafico(this.form)" ></td>
    </tr>
  </table>
  <table width="764" border="2" align="center" cellpadding="2" cellspacing="2" bordercolor="#b26c4a" class="TablaDetalle">
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td width="104" align="center"><strong>Fecha</strong><strong></strong></td>
      <td width="96" align="center"><strong>Circuito 1</strong></td>
      <td width="98" align="center"><strong>Circuito 2</strong></td>
      <td width="98" align="center"><strong>Circuito 3</strong></td>
      <td width="94" align="center"><strong>Circuito 4</strong></td>
      <td width="104" align="center"><strong>Circuito 5</strong></td>
      <td width="108" align="center"><strong>Circuito 6</strong></td>
    </tr>
    <?php
	   $consulta_fecha="select distinct(fecha) as fecha from ref_web.cortocircuitos where fecha between '".$FechaInicio."' and '".$FechaTermino."'";
	   $respuesta_fecha=mysqli_query($link, $consulta_fecha);
	   while ($row_fecha=mysqli_fetch_array($respuesta_fecha))
	          { 
			   echo '<tr>';
			   
			   echo '<td width="104" align="center" class=detalle01>'.$row_fecha["fecha"].'</td>';
			   $consulta_circuito="select distinct(cod_circuito) from sec_web.circuitos order by cod_circuito asc";
			   $respuesta_circuito=mysqli_query($link, $consulta_circuito);
			   while ($row_circuito=mysqli_fetch_array($respuesta_circuito))
			         {
						$consulta_datos="select fecha,ifnull((sum(cortos_nuevo)+sum(cortos_semi)),0) as suma ";
						$consulta_datos.="from ref_web.cortocircuitos  ";
						$consulta_datos.="where fecha ='".$row_fecha["fecha"]."' and cod_circuito='".$row_circuito["cod_circuito"]."' ";
						$consulta_datos.="group by fecha, cod_circuito ";
						$consulta_datos.="order by fecha,cod_circuito,cod_grupo";
						$respuesta_datos=mysqli_query($link, $consulta_datos);
						while ($row_datos=mysqli_fetch_array($respuesta_datos))
						      {
							   echo '<td width="96" align="center">'.$row_datos["suma"].'</td>';
							  }
					 }	
			  
			  }
	   
	
	 
	?>
  </table>
  <p>&nbsp;</p>
  </form>
</body>
</html>

