<?php 	
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename=0;//WSO
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
	include("../principal/conectar_sec_web.php");

	$CmbDias = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:date('d');
	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date('m');
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date('Y');
	$CmbDiasT = isset($_REQUEST["CmbDiasT"])?$_REQUEST["CmbDiasT"]:date('d');
	$CmbMesT = isset($_REQUEST["CmbMesT"])?$_REQUEST["CmbMesT"]:date('m');
	$CmbAnoT = isset($_REQUEST["CmbAnoT"])?$_REQUEST["CmbAnoT"]:date('Y');

?>
<html>
<head>
<title>Consulta Excel Lotes Traspasados a RAF</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProgLoteo" method="post" action="">
  <table width="770" height="350" border="0" left="6" cellpadding="6" cellspacing="0">
  <tr>
      <td align="center" valign="top"><br>
	  <table width="730" border="1" cellpadding="3" cellspacing="0">
          <tr>
		  <?php
			echo "<td width='40' align='center'>Hornada</td>";
			echo "<td width='220' align='center'>SubProducto</td>";
			echo "<td width='90' align='center'>Fecha Traspaso</td>";
			echo "<td width='60' align='right'>Peso</td>";
			echo "<td width='60' align='center'>Paquetes</td>";
			echo "<td width='60' align='center'>N&deg; Lote</td>";
			/*poly 30.04.2004*/
			echo "<td width='60' align='center'>Destino</td>";
		  ?>	
          </tr>
        </table>
		<?php
			if (strlen($CmbMes)==1)
			{ 
				$CmbMes="0".$CmbMes;
			}
			if (strlen($CmbDias)==1)
			{
				$CmbDias="0".$CmbDias;
			}
			if (strlen($CmbMesT)==1)
			{
				$CmbMesT="0".$CmbMesT;
			}
			if (strlen($CmbDiasT)==1)
			{
				$CmbDiasT="0".$CmbDiasT;
			}
			$FechaTraspaso=$CmbAno."-".$CmbMes."-".$CmbDias;
			$FechaTraspasoT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT;
			echo "<table width='730' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			$Total=0;
			$TotalUnid=0;
			$Consulta="SELECT t1.cod_producto,t1.cod_subproducto,t1.sw from sec_web.traspaso t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
			$Consulta=$Consulta." where t1.fecha_traspaso between  '".$FechaTraspaso."' and '".$FechaTraspasoT."'";
			$Consulta=$Consulta." group by t1.cod_producto,t1.cod_subproducto,sw";
			$Resultado=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Resultado))
			{
				$TotalPeso=0;
				$CantUnid=0;
				$Hornada = ' ';
				$Consulta="SELECT t1.hornada,t1.fecha_traspaso,t1.peso,t1.unidades,t1.cod_bulto,t1.num_bulto,";
				$Consulta=$Consulta." t2.descripcion as producto,t3.descripcion as subproducto from sec_web.traspaso t1";
				$Consulta=$Consulta." left join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
				$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
				$Consulta=$Consulta." where t1.fecha_traspaso between  '".$FechaTraspaso."' and '".$FechaTraspasoT."'";
				$Consulta=$Consulta." and t1.cod_producto='".$Fila["cod_producto"]."' and t1.cod_subproducto='".$Fila["cod_subproducto"]."' and t1.sw='".$Fila["sw"]."'";
				$Resultado2=mysqli_query($link, $Consulta);
				$Cont2=0;
				while($Fila2=mysqli_fetch_array($Resultado2))
				{
					echo "<tr>";
					$Hornada = $Fila2["hornada"];
					$Cont2++;
					echo "<td width='80'>".$Hornada."</td>";
					echo "<td width='180'>".$Fila2["subproducto"]."&nbsp;</td>";
					echo "<td width='80' align='center'>".$Fila2["fecha_traspaso"]."&nbsp;</td>";
					echo "<td width='60' align='right'>".$Fila2["peso"]."</td>";
					echo "<td width='60' align='right'>".$Fila2["unidades"]."&nbsp;</td>";
					echo "<td width='60' align='left'>".$Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</td>\n";
					if ($Fila["sw"] == 1)
						{
							$destino = "RAF";
							echo "<td width= '60' align='center'>".$destino."</td>";
						}
					if ($Fila["sw"] == 2)
						{
							$destino = "PMN";
							echo "<td width='60' align='center'>".$destino."</td>";
						}
					if ($Fila["sw"] == 3)
						{
							$destino = "REF.ELECT.";
							echo "<td width='60' align='center'>".$destino."</td>";
						}			
				
					echo "</tr>";
					$TotalPeso=$TotalPeso+$Fila2["peso"];
					$Total=$Total+$Fila2["peso"];
					$CantUnid=$CantUnid+$Fila2["unidades"];
					$TotalUnid=$TotalUnid+$Fila2["unidades"];
				}
				echo "<tr>";
				echo "<td colspan='3'><strong>SUB-TOTAL</strong></td>";
				//echo "<td>&nbsp;</strong></td>";
				//echo "<td>&nbsp;</strong></td>";
				echo "<td width='60' align='right'><strong>".$TotalPeso."</strong></td>";
				echo "<td width='60' align='right'><strong>".$CantUnid."&nbsp;</strong></td>";
				echo "<td>&nbsp;</td>";
				/*echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";*/
				echo "</tr>";
					
			}
			echo "<tr>";
			echo "<td colspan='3'><strong>TOTAL</strong></td>";
			//echo "<td>&nbsp;</strong></td>";
			//echo "<td>&nbsp;</strong></td>";
			echo "<td  width='60' align='right'><strong>".$Total."</strong></td>";
			echo "<td  width='60' align='right'><strong>".$TotalUnid."</strong></td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
		/*	echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";*/
			echo"</tr>";
			echo "</table>";	
		?>
      </td>
  </tr>
</table>     
</form>
</body>
</html>
