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
	include("../principal/conectar_ref_web.php");

$fecha    = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$dia1    = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:"";
$mes1    = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
$ano1    = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";
	
?>
<html>    
<head>

<title>Sistema GYC Nave Electrolitica</title>
<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="form1">
	<tr align="center"> 
    <td height="59" colspan="15">
	
		<table width="80%" height="92" border="1">
    		<tr align="center"> 
    			<td height="18" colspan="9"><strong>2.-PRODUCCION AREA DE HOJAS MADRES</strong></td>
            </tr>
            <tr> 
            	<td width="15%" rowspan="2" align="center"><strong>GRUPO</strong></td>
                <td width="1%" rowspan="2" align="center"><strong>PRODUCCION</strong></td>
                <td width="2%" colspan="5" align="center"><strong>RECHAZO</strong></td>
                <td width="3%" colspan="2" align="center"><strong>RECUPERADO</strong></td>
           	</tr>
            <tr> 
            	<td width="10%" align="center"><strong>DELGADAS</strong></td>
                <td width="10%" align="center"><strong>GRANULADAS</strong></td>
                <td width="10%" align="center"><strong>GRUESAS</strong></td>
                <td width="10%" align="center"><strong>TOTAL</strong></td>
                <td width="10%" align="center"><strong>%</strong></td>
                <td width="10%" align="center"><strong>TOTAL</strong></td>
                <td width="10%" align="center"><strong>%</strong></td>
         	</tr>
	<?php
	if (strlen($dia1) == 1)
	{
		$dia1 = '0'.$dia1;
	}
	if (strlen($mes1) ==1) 
  	{
		$mes1 = '0'.$mes1;
	}
	$fecha=$ano1.'-'.$mes1.'-'.$dia1;
	$porc_rech2 =0;
	$porc_tot_rec=0;
		$mostrar='S';
		if ($mostrar == "S")
		{		   
			$total_peso=0;
			$total_del=0;
			$total_gran=0;
			$total_grue=0;
			$total_recuperado=0;
			$total_unidades=0; //WSO	
			$total2=0; //WSO  	
	    	$consulta="select nombre_subclase as sub_clas, valor_subclase1 as sub_clase1 from proyecto_modernizacion.sub_clase ";
			$consulta=$consulta."where cod_clase='10001' order by cod_subclase";
			$Resp = mysqli_query($link, $consulta);
			while ($row2 = mysqli_fetch_array($Resp))
	       	{
            	$total_rech=0;		   
	    		echo "<tr>";
					echo "<td align='center'>".$row2["sub_clas"]."</td>";
					$Consulta5 = "select cod_grupo,ifnull(rechazo_delgadas,0) as rec_del,ifnull(rechazo_granuladas,0) as rec_gran,ifnull(rechazo_gruesas,0) as rec_grue from ref_web.produccion as t1 ";
					$Consulta5 = $Consulta5."inner join proyecto_modernizacion.sub_clase as t2  on t1.cod_grupo=t2.valor_subclase1 ";
					$Consulta5 = $Consulta5."where t1.fecha = '".$fecha."' and t1.cod_grupo = t2.valor_subclase1 and t1.cod_grupo= '".$row2["sub_clase1"]."' group by t1.cod_grupo";
					$rs12 = mysqli_query($link, $Consulta5);
					$row12 = mysqli_fetch_array($rs12);
					$consulta_fecha="select max(t1.fecha) as fecha from ref_web.grupo_electrolitico2 as t1 where t1.fecha <=  '".$fecha."' and t1.cod_grupo ='0".$row2["sub_clase1"]."' group by t1.cod_grupo";
					$rs_fecha = mysqli_query($link, $consulta_fecha);
					$row_fecha = mysqli_fetch_array($rs_fecha);
					$Consulta6 =  "select max(t1.fecha) as fecha,t1.cod_grupo,t1.cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 as t1 ";
					$Consulta6 = $Consulta6." where  t1.fecha = '".$row_fecha["fecha"]."' and t1.cod_grupo ='0".$row2["sub_clase1"]."' group by t1.cod_grupo";
					$rs3 = mysqli_query($link, $Consulta6);
					$row3 = mysqli_fetch_array($rs3);
					$produccion=(($row3["hojas_madres"]*$row3["num_catodos_celdas"])*2);         
					echo "<td align='center'>$produccion</td>";
					$Consulta5 = "select cod_grupo,ifnull(rechazo_delgadas,0) as rec_del,ifnull(rechazo_granuladas,0) as rec_gran,ifnull(rechazo_gruesas,0) as rec_grue from ref_web.produccion as t1 ";
					$Consulta5 = $Consulta5."inner join proyecto_modernizacion.sub_clase as t2  on t1.cod_grupo=t2.valor_subclase1 ";
					$Consulta5 = $Consulta5."where t1.fecha = '".$fecha."' and t1.cod_grupo = t2.valor_subclase1 and t1.cod_grupo= '".$row2["sub_clase1"]."' group by t1.cod_grupo";
				
       				$rs12 = mysqli_query($link, $Consulta5);
					$row12 = mysqli_fetch_array($rs12);
					$rec_del  = isset($row12["rec_del"])?$row12["rec_del"]:0;
					$rec_gran = isset($row12["rec_gran"])?$row12["rec_gran"]:0;
					$rec_grue = isset($row12["rec_grue"])?$row12["rec_grue"]:0;
					if ($rec_del >0)
					{
						echo "<td align='center'>".$rec_del."</td>";
					}
					else
					{
						echo "<td align='center'>0</td>";
					}	
					if ($rec_gran >0)
					{
						echo "<td align='center'>".$rec_gran."</td>";
					}
					else
					{
						echo "<td align='center'>0</td>";
					}	
					if ($rec_grue >0)
					{
						echo "<td align='center'>".$rec_grue."</td>";
					}
					else
					{
					echo "<td align='center'>0</td>";
					}	
					
					/*else
					{
						echo "<td align='center'>--</td>";
					}	*/
					$total=$rec_del + $rec_gran + $rec_grue;
					$total_unidades=$total_unidades+$produccion;
					$total_del=$total_del+$rec_del;
		    		$total_gran=$total_gran+$rec_gran;
		    		$total_grue=$total_grue+$rec_grue;
					$total2=$total2+$total;
					if (($produccion==0) or ($total==0))
					{
						$porc_rech=0;
					}
						//poly aqui revisar calculo de % de rechazo
					else
					{
						$porc_rech=(($total/$produccion)*100);
						
					}
						//;
						
					$porc_rech2=number_format($porc_rech,"2",",","");
					echo "<td align='center'>$total</td>";
					echo "<td align='center'>$porc_rech2</td>";
					$Consulta7="select ifnull(recuperado,0) as recuperado from ref_web.recuperado as t1 "; 
					$Consulta7=$Consulta7."where t1.fecha ='".$fecha."' ";
					$rs13 = mysqli_query($link, $Consulta7);
					$row13 = mysqli_fetch_array($rs13);
					echo "<td align='center'>&nbsp;</td>";
					echo "<td align='center'>&nbsp;</td>";
			echo "</tr>";								
          	}    
			
            echo "<td align='right'>TOTAL</td>";	
			echo "<td align='center'>$total_unidades</td>";
			echo "<td align='center'>$total_del</td>";
			echo "<td align='center'>$total_gran</td>";
			echo "<td align='center'>$total_grue</td>";	
			echo "<td align='center'>$total2</td>";
			if (($total_unidades==0) or($total_unidades==0))
			{
				$porc_tot_rech=0;
			}
			else
			{
				 $porc_tot_rech=(($total2/$total_unidades)*100);
			}
				$porc_tot_rech=number_format($porc_tot_rech,"2",",","");
				$recuperado = isset($row13["recuperado"])?$row13["recuperado"]:0;
				echo "<td align='center'>$porc_tot_rech</td>";
				echo "<td align='center'>".$recuperado."</td>";
			if (($total_unidades==0) or ($total2==0))
			{
				$porc_tot_rec=0;
			}
			else
			{
				$porc_tot_rec=(($recuperado/$total_unidades)*100);
			}
			$porc_tot_rec=number_format($porc_tot_rec,"2",".","");
			echo "<td align='center'>".$porc_tot_rec."</td>";
		}
	?>
	</table>	
</td>	
</tr>	
</form>
</body>
</html>
