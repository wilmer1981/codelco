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
<title>Sistema Estadistico de Catodos</title>
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sec_con_inf_boletas_cortes.php";
			f.submit();
			break;
		case "S":
			f.action ="../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
function Excel()
{
 var f=document.frmPrincipal;
 f.action ="sec_con_inf_boletas_cortes_excel.php";
 f.submit();
}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <br>
     
<table width="786" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01"> 
    <td width="45">GRUPO</td>
    <td width="73">TIPO DESC.</td>
    <td width="86">NUM. CIRC.</td>
    <td width="96">HORA DESC.</td>
    <td width="80">KAH DIR. D</td>
    <td width="74">KAH INV. D</td>
    <td width="94">FECHA CONEX.</td>
    <td width="80">HORA CONEX.</td>
    <td width="63">KAH DIR.C</td>
    <td width="72">KAH INV.C</td>
  </tr>  
  <?php
	$Consulta = "select * from sec_web.cortes_refineria ";
	$Consulta.= " where fecha_desconexion between '".$FechaInicio." 00:00:00' and '".$FechaTermino." 23:59:59' ";
	$Consulta.= " order by fecha_desconexion";
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalCortes = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
		echo "<td align='center'>".$Fila["tipo_desconexion"]."</td>\n";
		echo "<td align='center'>&nbsp;</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_desconexion"],11,5)."</td>\n";
		echo "<td align='right'>".$Fila["kahdird"]."</td>\n";
		echo "<td align='right'>".$Fila["kahinvd"]."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_desconexion"],8,2)."/".substr($Fila["fecha_desconexion"],5,2)."/".substr($Fila["fecha_desconexion"],0,4)."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_conexion"],11,5)."</td>\n";
		echo "<td align='right'>".$Fila["kahdirc"]."</td>\n";
		echo "<td align='right'>".$Fila["kahinvc"]."</td>\n";
		echo "</tr>\n";
		$TotalCortes++;
	}
	?>
	
  <tr> 
    <td colspan="10"><strong>TOTAL CORTES EN PERIODO <?php echo $DiaIni."/".$MesIni."/".$AnoFin." al ".$DiaFin."/".$MesFin."/".$AnoFin ?> 
      <?php echo $TotalCortes ?> </strong></td>
  </tr>
</table>
<br>
<br>
</form>
</body>
</html>

