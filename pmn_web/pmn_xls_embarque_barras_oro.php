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
			<td width="63"><strong>Acta</strong></td>
            <td width="101"><strong>Peso Neto (Caja)</strong></td>
            <td width="97"><strong>Peso Bruto Caja</strong></td>
            <td width="92"><strong>Valor Declarado</strong></td>
            <td width="80"><strong>#Sello</strong></td>
          </tr>
         <?php	
		$Consulta = "select num_sello,num_acta,count(*) as cant from pmn_web.embarque_oro ";
		$Consulta.= " where fecha = '".$AnoBarraOro."-".$MesBarraOro."-".$DiaBarraOro."'";	  
		$Consulta.= " group by num_sello,num_acta order by num_barra,num_acta";
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		$TotalPeso = 0;
		$sw=0;
		$SelloAnt="";
		$ActaAnt="";
		//echo $Consulta."<br>";
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			$Entro=true;
			$Consulta = "select * from pmn_web.embarque_oro ";
			$Consulta.= " where fecha = '".$AnoBarraOro."-".$MesBarraOro."-".$DiaBarraOro."' and num_sello='".$Row[num_sello]."' and num_acta='".$Row[num_acta]."'";	
			//echo   $Consulta."<br>";
			$Respuesta2 = mysqli_query($link, $Consulta);
			while ($Row2 = mysqli_fetch_array($Respuesta2))
			{
				echo "<tr>\n";
				echo "<td>".$Row2[num_barra]."</td>\n";
				echo "<td align='center'>".$Row2[peso_neto_barra]."</td>\n";
				if ($Entro==true)
				{
					echo "<td align='center' rowspan='".$Row["cant"]."'>".$Row2[num_acta]."</td>\n";
					echo "<td align='center' rowspan='".$Row["cant"]."'>".$Row2[peso_neto_caja]."</td>\n";
					echo "<td align='center' rowspan='".$Row["cant"]."'>".$Row2[peso_bruto_caja]."</td>\n";
					echo "<td align='center' rowspan='".$Row["cant"]."'>".$Row2[valor_declarado]."</td>\n";
					echo "<td align='center' rowspan='".$Row[cant]."'>".$Row2[num_sello]."</td>\n";
					$Entro=false;
					$SumaNeto=$SumaNeto+$Row2[peso_neto_caja];
				}	
				$SumaNeto2=$SumaNeto2+$Row2[peso_neto_barra];
				echo "</tr>\n";
			}	
			
			$i++;
			$cont = $cont +  4;
			$SelloAnt = $Row[num_sello];
			$ActaAnt = $Row[num_acta];
		}
		?>
          <tr align="center"> 
            <td><strong>Total Neto:</strong></td>
            <td align="rigth"><?php
				echo "<strong>$SumaNeto2</strong>";
			?></td>
            <td align="rigth">&nbsp;</td>
            <td align="rigth"><?php
				echo "<strong>".$SumaNeto."</strong>";
			?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
          </tr>
        </table>
        
      </td>
  </tr>
</table>
</form>
</body>
</html>
