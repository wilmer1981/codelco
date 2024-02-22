<?php 	ob_end_clean();
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
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
         <table width="215" height="18" border="1" align="center" cellpadding="0" cellspacing="0">
          <tr>
		  <td colspan="2" align="center"><strong>Lote #
		   <?php
		  		echo $NumLote;
		   ?> 		  
		  </strong></td>
		  </tr>
		  <tr> 
            <td><strong>#Barra</strong></td>
            <td><strong>Peso Barra</strong></td>
          </tr>
          <?php	
		$Consulta = "select * from pmn_web.ingreso_metal_dore ";
		$Consulta= $Consulta." where fecha = '".$Ano."-".$Mes."-".$Dia."' and ";
		$Consulta= $Consulta." num_lote = '".$NumLote."'  order by num_barra ";
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>";
			echo "<td>".$Row[num_barra]."</td>";
			echo "<td>".$Row[peso_barra]."</td>";
			echo "</tr>";
			$i++;
			$Suma=$Suma+$Row[peso_barra];
		}
		echo "<tr>";
		
		echo "<td><strong>";
		echo Total;
		echo "</td>";
		echo "<td><strong>";
		echo $Suma;
		echo "</strong></td>";
		echo "</tr>";
		?>
        </table>
        <br>
    
</form>
</body>
</html>
