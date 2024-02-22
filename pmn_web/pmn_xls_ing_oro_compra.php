<?php
ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename="";
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


	$AnoIniCon = $_REQUEST["AnoIniCon"];
	$MesIniCon = $_REQUEST["MesIniCon"];
	$DiaIniCon = $_REQUEST["DiaIniCon"];
	$AnoFinCon = $_REQUEST["AnoFinCon"];
	$MesFinCon = $_REQUEST["MesFinCon"];
	$DiaFinCon = $_REQUEST["DiaFinCon"];
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
</head>

<body>
<form name="frmConsulta" action="" method="post">
  <table width="748" border="0" class="TablaDetalle">
    <tr>
    <td colspan="2">Periodo</td>
    <td colspan="7"><?php echo $DiaIniCon."-".$MesIniCon."-".$AnoIniCon." AL ".$DiaFinCon."-".$MesFinCon."-".$AnoFinCon; ?></td>
    </tr>
</table>
<br>
<br>
  <table width="1039" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="135"><strong>Fecha</strong></td>
      <td width="72"><strong>Num Barra</strong></td>
      <td width="89"><strong>Peso Barra</strong></td>
      <td width="92"><strong>Ley Oro</strong></td>
      <td width="76"><strong>Peso Fino Oro</strong></td>
      <td width="70"><strong>Ley Plata</strong></td>
      <td width="81"><strong>Peso Fino Plata</strong></td>
      <td width="81"><strong>Rut Origen</strong></td>
      <td width="297"><strong>Observacion</strong></td>
    </tr>
    <?php  
	$Consulta="select * from pmn_web.ingreso_oro_compra ";
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by correlativo,num_barra";
	$Respuesta=mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdFecha'>\n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	$FechaAnt="";
	$TotalPeso=0;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n"; 
		echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
		$IdDia=substr($Row["fecha"],8,2);
		echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
		$IdMes=substr($Row["fecha"],5,2);
		echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
		$IdAno=substr($Row["fecha"],0,4);
		if ($FechaAnt!=$Row["fecha"])
		{
			$Consulta="select count(*) as total from pmn_web.ingreso_oro_compra  ";
			$Consulta.=" where fecha='".$Row["fecha"]."'	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$TotalFilas=$Fila["total"];
			//echo $TotalFilas."<br>";
			echo "<td align='center' rowspan='".$TotalFilas."'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
		}
		echo "<td align='left'>".$Row["num_barra"]."</td>\n";
		echo "<td align='left'>".$Row["peso_barra"]."</td>\n";
		echo "<td align='left'>".$Row["ley_oro"]."</td>\n";
		echo "<td align='left'>".$Row["peso_oro"]."</td>\n";
		echo "<td align='left'>".$Row["ley_plata"]."</td>\n";
		echo "<td align='left'>".$Row["peso_plata"]."</td>\n";
		echo "<td align='left'>".$Row["rut_origen"]."</td>\n";		
		echo "<td align='left'>".$Row["observacion"]."</td>\n";
		echo "</tr>\n";
		$FechaAnt=$Row["fecha"];
		$TotalPeso=$TotalPeso+$Row["peso_barra"];
	}
	echo "<tr>";
		echo "<td>";
		echo "</td>";
		echo "<td align='right'><strong>Total</strong></td>";									
		echo "<td align='center' colspan='2'><strong>";
		echo $TotalPeso;
		echo "</strong></td>";
	echo "</tr>";
?>
  </table>
</form>
</body>
</html>
