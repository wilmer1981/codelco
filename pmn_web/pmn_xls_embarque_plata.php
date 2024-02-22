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
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;
$CodigoDeSistema = 6;
$CodigoDePantalla = 6;
?>
<html>
<head>
<title></title>
<link>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<form name="FrmEmbarquePlata" method="post" action="">
	<tr>
    <td width="613">
      <table width="769" border="0" cellpadding="5" cellspacing="0"  left="5">
        <tr>
          <td width="757">&nbsp; <br>
            <table width="752" border="1" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="120"> <div align="center"><strong>Nro Caja</strong></div></td>
                <td width="120"> <div align="center"><strong>Nro Sello</strong></div></td>
                <td width="120"> <div align="center"><strong>Peso Neto</strong></div></td>
                <td width="120"><strong>Peso Bruto</strong></td>
                <td width="120" ><strong>Valor Declar</strong></td>
                <td width="120" ><strong>Nro Electrolisis</strong></td>
              </tr>
              <?php
				$Fecha = $CmbAno."-".$CmbMes."-".$CmbDias; 
				if (($Mostrar=='C')|| ($Mostrar =='V'))
				{
					$Consulta="select num_electrolisis,num_caja,peso_bruto,promedio_cajas,num_sello,valor_declarado from pmn_web.embarque_plata  ";
					$Consulta =$Consulta." where (fecha = '".$Fecha."') order by num_caja";
					$Cont=0;
					$SumaPeso=0;
					$SumaSobrante=0;
					$i=1;
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						echo "<tr>";
						//echo "<input type='hidden' name='ChkCaja[".$i."]' value='".$Fila[num_caja]."'>\n";
						echo "<input type='hidden' name='ChkSello[".$i."]' value='".$Fila[num_sello]."'>\n";
						echo "<input type='hidden' name='ChkPromCaja[".$i."]' value='".$Fila[promedio_cajas]."'>\n";
						echo "<input type='hidden' name='ChkPesoBruto[".$i."]' value='".$Fila[peso_bruto]."'>\n";
						echo "<input type='hidden' name='ChkValor[".$i."]' value='".$Fila[valor_declarado]."'>\n";
						echo "<input type='hidden' name='ChkElectrolisis[".$i."]' value='".$Fila[num_electrolisis]."'>\n";
						echo "<td><div align='left'>".$Fila["num_caja"]."</div></td>";
						echo "<td><div align='left'>".str_replace(".",",",$Fila["num_sello"])."</div></td>";		
						echo "<td><div align='left'>".str_replace(".",",",$Fila["promedio_cajas"])."</div></td>";		
						echo "<td><div align='left'>".str_replace(".",",",$Fila["peso_bruto"])."</div></td>";		
						echo "<td><div align='left'>".str_replace(".",",",$Fila["valor_declarado"])."</div></td>";		
						echo "<td><div align='left'>".$Fila["num_electrolisis"]."</div></td>";
						echo "</tr>";
						$i++;		
						$Cont++;
						$SumaPeso=$SumaPeso + $Fila[peso_bruto];
					}
				}
				?>
            </table>
            
          </td>
        </tr>
      </table>
  </form>
<p>&nbsp;</p>
</body>
</html>
