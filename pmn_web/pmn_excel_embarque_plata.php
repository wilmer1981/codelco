<?php  ob_end_clean();
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
<title>Planta de Metales Nobles</title>
<link>
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "S":
			f.action = "pmn_consulta_report.php";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
function Excel(FI,FT)
{
	var f = document.frmConsulta;
	f.action ="pmn_excel_embarque_plata.php?FechaIni="+FI + "&FechaFin="+FT;
	f.submit();	
}
</script>
</head>

<body>
<form name="frmConsulta" action="" method="post">
  <table width="750" border="1" cellspacing="0" cellpadding="3">
    <tr> 
      <td width="263" align="center" colspan="5"><strong>Consulta Embarque 
          PLata</strong>&nbsp; </td>
    </tr>
  </table>
   <table width="691" border="1" cellspacing="0" cellpadding="3">
    <tr> 
      <td width="427" align="center" valign="middle" colspan="2">Fecha Inicio:</td>
      <td width="427" align="center" valign="middle" colspan="1"><?php echo $FechaIni;?></td>
      <td width="427" align="center" valign="middle" colspan="1">Fecha Termino:</td>
      <td width="427" align="center" valign="middle" colspan="1"><?php echo $FechaFin;?></td>
    </tr>
  </table>    
  <br>
  <table width="730" border="1" cellpadding="0" cellspacing="0">
    <tr align="center"> 
      <td width="120"><strong>Fecha</strong></td>
      <td width="120"><strong>Cantidad</strong></td>
      <td width="120"><strong>Peso</strong></td>
      <td width="120"><strong>Valor Us$</strong></td>
      <td width="120"><strong>Acta</strong></td>
    </tr>
    <?php  
	$Consulta="select * from pmn_web.embarque_plata  ";
	$Consulta.= " where fecha between '".$FechaIni."' and '".$FechaFin."' ";
	$Consulta.= " order by correlativo,cantidad";
	$Respuesta=mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdFecha'>\n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	$FechaAnt="";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n"; 
		echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
		$IdDia=substr($Row["fecha"],8,2);
		echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
		$IdMes=substr($Row["fecha"],5,2);
		echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
		$IdAno=substr($Row["fecha"],0,4);
		echo "<td align='center'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
		echo "<td align='right'>".number_format($Row[cantidad],2,",",".")."</td>\n";
		echo "<td align='right'>".$Row["peso"]."</td>\n";
		echo "<td align='right'>".number_format($Row["valor"],2,",",".")."</td>\n";
		echo "<td align='left'>".$Row[num_acta]."&nbsp;</td>\n";
		echo "</tr>\n";
		$FechaAnt=$Row["fecha"];
		$TotalCantidad=$TotalCantidad+$Row[cantidad];
		$TotalPeso=$TotalPeso+$Row["peso"];
		$TotalValor=$TotalValor+$Row["valor"];
	}
	echo "<tr>";
		echo "<td align='right'><strong>Totales</strong></td>";									
		echo "<td align='left'><strong>";
		echo $TotalCantidad;
		echo "</strong></td>";
		echo "<td><strong>";
		echo $TotalPeso;
		echo "</strong></td>";
		echo "<td><strong>";
		echo number_format($TotalValor,2,",","");
		echo "</strong></td>";
		echo "<td>";
		echo "</td>";
	echo "</tr>";
?>
  </table>
</form>
</body>
</html>
