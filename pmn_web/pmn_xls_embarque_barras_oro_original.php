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
	if ($Op=="S")
	{
		$Dia = $D;
		$Mes = $M;
		$Ano = $Anito;
	}
	if ($Consulta == "S")
	{
		$Dia = $IdDia;
		$Mes = $IdMes;
		$Ano = $IdAno;
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
  <table width="770" border="0" >
    <tr>
    <td width="762"><table width="761" cellpadding="3" cellspacing="0" >
          <tr> 
            <td width="100" height="30"></td>
            <td colspan="2"><strong>ACTA DE EMBARQUE Y RECEPCION N&deg;</strong></td>
            <td width="72"> </td>
          </tr>
        </table>
		  
       <strong>Barras de Oro</strong><br>
        <br> 
        <table width="739" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr align="center"> 
            <td width="96"><strong> N&deg; de Barra</strong></td>
            <td width="102"><strong>Peso Neto Barra</strong></td>
            <td width="101"><strong>Peso Neto (Caja)</strong></td>
            <td width="97"><strong>Peso Bruto Caja</strong></td>
            <td width="92"><strong>Valor Declarado</strong></td>
            <td width="80"><strong>#Sello</strong></td>
          </tr>
         <?php	
		$Consulta = "select * from pmn_web.embarque_oro ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";	  
		$Consulta.= " order by num_sello,num_barra";
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		$TotalPeso = 0;
		$sw=0;
		$SelloAnt="";
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
			//echo "<td align='center'><input type='checkbox' name='ChkBarra1[".$i."]' value='".$Row[num_barra]."'>\n";
			echo "<input type='hidden' name='ChkBarra[".$i."]' value='".$Row[num_barra]."'>\n";
			echo "<input type='hidden' name='ChkPeso[".$i."]' value='".$Row[peso_neto_barra]."'>\n";
			//echo "</td>\n";
			echo "<td>".$Row[num_barra]."</td>\n";
			echo "<td align='center'>".$Row[peso_neto_barra]."</td>\n";
			if ($SelloAnt != $Row[num_sello])	
			{
					$Consulta = "select count(*) as total from pmn_web.embarque_oro  ";
					$Consulta.= " where fecha = '".$Row["fecha"]."' and num_sello='".$Row[num_sello]."' ";
					//echo $Consulta."<br>";
					$Resp2 = mysqli_query($link, $Consulta);
					$Row2 = mysqli_fetch_array($Resp2);	
					$TotalFilas = $Row2["total"];
					echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[peso_neto_caja]."</td>\n";
					echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[peso_bruto_caja]."</td>\n";
					echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[valor_declarado]."</td>\n";
					echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[num_sello]."</td>\n";
			}
			echo "</tr>\n";
			$i++;
			$cont = $cont +  4;
			$SelloAnt = $Row[num_sello];
		}
		?>
          <tr align="center"> 
            <td></td> 
            <td></td>
            <td></td>
            <td></td>
            <td></td>
			<td></td>
          </tr>
        </table>
        
      </td>
  </tr>
</table>
</form>
</body>
</html>
