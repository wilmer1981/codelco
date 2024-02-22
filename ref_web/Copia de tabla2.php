<?php header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");include("../principal/conectar_ref_web.php");
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
<p>&nbsp;</p>
              <p>&nbsp; </p>
              <table width="93%" height="104" border="1">
              <tr align="center"  class="ColorTabla01">
                <td colspan="15">2.-PRODUCCION AREA DE HOJAS MADRES</td>
              </tr>
              <tr>
                <td width="21%" rowspan="2" align="center">GRUPO</td>
                <td width="1%" rowspan="2" align="center">PRODUCCION</td>
                <td colspan="5" align="center">RECHAZO</td>
                <td colspan="2" align="center">RECUPERADO</td>
              </tr>
              <tr>
                <td width="11%" align="center">DELGADAS</td>
                <td width="15%" align="center">GRANULADAS</td>
                <td width="10%" align="center">GRUESAS</td>
                <td width="7%" align="center">TOTAL</td>
                  <td width="7%" align="center">%</td>
                <td width="7%" align="center">TOTAL</td>
                  <td width="21%" align="center">%</td>
              </tr>
            <?php
			   $mostrar='S';
			  if ($mostrar == "S")
			   {		   
		   
				$total_peso=0;
				$total_del=0;
				$total_gran=0;
				$total_grue=0;
				$total_recuperado=0;	  	
	    		$consulta="select nombre_subclase as sub_clas, valor_subclase1 as sub_clase1 from proyecto_modernizacion.sub_clase ";
				$consulta=$consulta."where cod_clase='10001' order by cod_subclase";
				$Resp = mysqli_query($link, $consulta);
				while ($row2 = mysqli_fetch_array($Resp))
	       		{
            		$total_rech=0;		   
	    			echo "<tr>\n";
					echo "<td align='center'>".$row2["sub_clas"]."&nbsp;</td>\n";
					$Consulta5 = "select cod_grupo,ifnull(rechazo_delgadas,0) as rec_del,ifnull(rechazo_granuladas,0) as rec_gran,ifnull(rechazo_gruesas,0) as rec_grue from ref_web.produccion as t1 ";
					$Consulta5 = $Consulta5."inner join proyecto_modernizacion.sub_clase as t2  on t1.cod_grupo=t2.valor_subclase1 ";
					$Consulta5 = $Consulta5."where t1.fecha = '".$fecha."' and t1.cod_grupo = t2.valor_subclase1 and t1.cod_grupo= '".$row2[sub_clase1]."' group by t1.cod_grupo";
					$rs12 = mysqli_query($link, $Consulta5);
					$row12 = mysqli_fetch_array($rs12);
					$consulta_fecha="select max(t1.fecha) as fecha from ref_web.grupo_electrolitico2 as t1 where t1.fecha <=  '".$fecha."' and t1.cod_grupo ='0".$row2[sub_clase1]."' group by t1.cod_grupo";
					$rs_fecha = mysqli_query($link, $consulta_fecha);
					$row_fecha = mysqli_fetch_array($rs_fecha);
					$Consulta6 =  "select max(t1.fecha) as fecha,t1.cod_grupo,t1.cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 as t1 ";
					$Consulta6 = $Consulta6." where  t1.fecha = '".$row_fecha["fecha"]."' and t1.cod_grupo ='0".$row2[sub_clase1]."' group by t1.cod_grupo";
					$rs3 = mysqli_query($link, $Consulta6);
					$row3 = mysqli_fetch_array($rs3);
					$produccion=(($row3[hojas_madres]*$row3[num_catodos_celdas])*2);         
					echo "<td align='center'>$produccion&nbsp</td>\n";
					$Consulta5 = "select cod_grupo,ifnull(rechazo_delgadas,0) as rec_del,ifnull(rechazo_granuladas,0) as rec_gran,ifnull(rechazo_gruesas,0) as rec_grue from ref_web.produccion as t1 ";
					$Consulta5 = $Consulta5."inner join proyecto_modernizacion.sub_clase as t2  on t1.cod_grupo=t2.valor_subclase1 ";
					$Consulta5 = $Consulta5."where t1.fecha = '".$fecha."' and t1.cod_grupo = t2.valor_subclase1 and t1.cod_grupo= '".$row2[sub_clase1]."' group by t1.cod_grupo";
       				$rs12 = mysqli_query($link, $Consulta5);
					$row12 = mysqli_fetch_array($rs12);
					echo "<td align='center'>".$row12[rec_del]."&nbsp</td>\n";
					echo "<td align='center'>".$row12[rec_gran]."&nbsp</td>\n";
					echo "<td>".$row12[rec_grue]."&nbsp</td>\n";
					$total=$row12[rec_del]+$row12[rec_gran]+$row12[rec_grue];
					$total_unidades=$total_unidades+$produccion;
					$total_del=$total_del+$row12[rec_del];
		    		$total_gran=$total_gran+$row12[rec_gran];
		    		$total_grue=$total_grue+$row12[rec_grue];
					$total2=$total2+$total;
					if (($produccion==0) or ($total==0))
					{$porc_rech=0;}
					else {$porc_rech=(($total/$total_unidades)*100);};
					$porc_rech2=number_format($porc_rech,"2",",","");
					echo "<td align='center'>$total&nbsp</td>\n";
					echo "<td align='center'>$porc_rech2&nbsp</td>\n";
					$Consulta7="select ifnull(recuperado,0) as recuperado_tot from ref_web.recuperado as t1 "; 
					$Consulta7=$Consulta7."where t1.fecha ='".$fecha."' ";
					$rs13 = mysqli_query($link, $Consulta7);
					$row13 = mysqli_fetch_array($rs13);
					echo "<td align='center'>&nbsp</td>\n";
					//$total_recuperado=$total_recuperado+$row13["recuperado_tot"];
					//if (($produccion==0) or ($total==0)) 
					//{$porc_rec=0;}
					//else {$porc_rec=(($row13["recuperado_tot"]/$produccion)*100);};
					//$porc_rec2=number_format($porc_rec,"2",",","");
					echo "<td align='center'>&nbsp</td>\n";
					echo "</tr>\n";								
          		}    
            	echo "<td align='right'><strong>TOTAL</strong></td>\n";	
				echo "<td align='center'><font color='blue'>$total_unidades&nbsp</font></td>\n";
				echo "<td align='center'><font color='blue'>$total_del&nbsp</font></td>\n";
				echo "<td align='center'><font color='blue'>$total_gran&nbsp</font></td>\n";
				echo "<td align='center'><font color='blue'>$total_grue&nbsp</font></td>\n";	
				echo "<td align='center'><font color='blue'>$total2&nbsp</font></td>\n";
				if (($total_unidades==0) or($total_unidades==0))
				{$porc_tot_rech=0;
			 	}
				else {$porc_tot_rech=(($total2/$total_unidades)*100);};
				$porc_tot_rech=number_format($porc_tot_rech,"2",",","");
				echo "<td align='center'><font color='blue'>$porc_tot_rech&nbsp</font></td>\n";
				echo "<td align='center'><font color='blue'>$total_recuperado&nbsp</font></td>\n";
				if (($total_unidades==0) or ($total2==0))
				{$porc_tot_rec=0;
			 	}
				else {$porc_tot_rec=(($total_recuperado/$total_unidades)*100);};
				$porc_tot_rec=number_format($porc_tot_rec,"2",".","");
				echo "<td align='center'><font color='blue'>$porc_tot_rec&nbsp</font></td>\n";
			}
		?>

</table>
</table>

</form>
</body>
</html>
