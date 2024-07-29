<?php
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename="";
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

	$Ano      = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
    $Mes      = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
?>
<html>
<head>
<title>Sistema de Anodos</title>
</head>

<body>
<br>
		  <table width="176" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle" align="left">
                <tr align="center" class="ColorTabla01">
                  <td width="48">Dia</td>
                  <td width="187">Stock programado </td>
                </tr>
                <?php	
					$Fecha01 = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
					$FinMes = date("d", mktime(0,0,0,substr($Fecha01,5,2),intval(substr($Fecha01,8,2))-1,substr($Fecha01,0,4)));
					$TotalStockMes=0;
					for ($i=1;$i<=$FinMes;$i++)
					{	
						$Consulta = "SELECT * from sea_web.stock_programado ";
						$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$i."'";
						$Resp = mysqli_query($link, $Consulta);
						$PesoDia=0;
						if ($Fila = mysqli_fetch_array($Resp))
						{
							$PesoDia=$Fila["peso"];
						}
						if ($PesoDia==0)
							$PesoDia=0;		
						echo "<tr align='center'>\n";  
						echo "<td>".str_pad($i,2,"0",STR_PAD_LEFT)."</td>\n";
						echo "<td>".$PesoDia."</td>\n";
						echo "</tr>\n";
						$TotalStockMes = $TotalStockMes + $PesoDia;		
					}
				?>
                <tr>
                  <td><strong>TOTAL</strong></td>
                  <td align="center"><?php echo $TotalStockMes; ?></td>
                </tr>
              </table
	    ><br>
</body>
</html>
