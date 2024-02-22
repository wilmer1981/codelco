<?php	ob_end_clean();
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
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<?php
	//<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
?>
<script language="JavaScript">
function Proceso(opt)
{
	var f= document.frm1;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			window.history.back();
			break;
	}
}
function Excel(FechaI,FechaT,T)
{
	var f=document.frm1;
	f.action="pmn_xls_selenio.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
	f.submit();
}

</script>
</head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<table width="749" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      
      <td width="477" align="center" valign="middle" colspan="3"><strong>SULFATO DE COBRE</strong></td>
      <td width="76" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');"></td>
      <td width="178" align="center" valign="middle"><div align="left">
          <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
          <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
        </div></td>
    </tr>
  </table>
  <br>
  <table width="400" border="1" cellspacing="0" cellpadding="3" class="TablaDetalle">
    <tr class="ColorTabla01">
      <td width="121" align="center">Fecha Prod.</td>
      <td width="132" align="center">N. Bolsa</td>
      <td width="139" align="center">Peso</td>
    </tr>
<?php
	$consulta = "SELECT * FROM pmn_web.produccion_subproductos";
	$consulta.= " WHERE cod_producto = '64' AND cod_subproducto = '5'";
	$consulta.= " AND fecha_produccion BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{	
    	echo '<tr>';
      	echo '<td height="20" align="center">'.substr($row[fecha_produccion],8,2).'-'.substr($row[fecha_produccion],5,2).'-'.substr($row[fecha_produccion],0,4).'</td>';
      	echo '<td align="center">'.$row["numero"].'</td>';
      	echo '<td align="right">'.number_format($row["peso"],4,",","").'</td>';
    	echo '</tr>';
	}
?>
  </table>
</form>
</body>
</html>  
  