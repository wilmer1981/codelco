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

$Sig    = isset($_REQUEST["Sig"])?$_REQUEST["Sig"]:"";
$Ant    = isset($_REQUEST["Ant"])?$_REQUEST["Ant"]:"";

$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";
$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";

	if (strlen($dia1) == 1)
		{$dia1 = '0'.$dia1;}
	if (strlen($mes1) ==1) 
  		{$mes1 = '0'.$mes1;}

	$fecha=$ano.'-'.$mes.'-'.$dia;	

?>
<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="form1">
				<?php 
		$fecha=$ano."-".$mes."-".$dia;
		
			if (strlen($dia) == 1)
			{
				$dia = '0'.$dia;
			}
			if (strlen($mes) ==1) 
  			{
				$mes = '0'.$mes;
			}
			//$fecha=$ano1."-".$mes1."-".$dia1;

			$fecha_poly=date("d-m-Y");
			$dia_poly =substr($fecha_poly,0,2);
			$mes_poly =substr($fecha_poly,3,2);
			$year_poly =substr($fecha_poly,6,4);
			$cheq_fecha=$year_poly."-".$mes_poly."-".$dia_poly;
				
		?>
<!-- COMIENZO PRIMERA TABLA -->
		 <table width="80%" height="175" border="1"  align="left" cellpadding="2" cellspacing="0">
          <tr align="center"> 
            <td colspan="18"><strong>1.-</strong> <strong>RENOVACION ELECTRODOS 
              GRUPOS Y PRODUCCION CATODOS COMERCIALES</strong></td>
          </tr>
          <tr align="center"> 
		  <td width="10%" align="center"><strong>CIRCUITO</strong></td>
            <td width="15%" align="center"><strong>GRUPO</strong></td>
            <td width="40%" align="center"><strong>TURNO</strong></td>
			<td width="50%" align="center"><p><strong>PESO</strong></p>
            	<p><strong>PRODUCCION</strong></p></td>
			<td width="50%" align="center"><p><strong>PESO</strong></p>
            	<p><strong>ANODOS</strong></p></td>
			<td width="50%" align="center"><p><strong>PESO</strong></p>
				<p><strong>SCRAP</strong></p></td>
			<td width="30%" align="center"><p><strong>%</strong></p>
				<p><strong>SCRAP</strong></p></td>
		    <td width="50%" align="center"><p><strong>DESC.</strong></p>
              	<p><strong>NORMAL</strong></p></td>
            <td colspan="2" align="center"><strong>RECUPERADO</strong></td>
            <td colspan="2" align="center"><strong>ESTANDAR</strong></td>
            <td colspan="6" align="center"><strong>DETALLE ESTANDAR</strong></td>
          </tr>
          <tr> 
		  
		  	<td>&nbsp;</td>
			<td>&nbsp;</td>
		  	<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td width="47%" align="center"><strong>N�</strong></td>
            <td width="46%" align="center"><strong>%</strong></td>
            <td width="45%" align="center"><strong>N�</strong></td>
            <td width="18%" align="center"><strong>%</strong></td>
            <td width="16%" align="center"><strong>NE</strong></td>
            <td width="18%" align="center"><strong>ND</strong></td>
            <td width="17%" align="center"><strong>RA</strong></td>
            <td width="16%" align="center"><strong>CL</strong></td>
            <td width="17%" align="center"><strong>CS</strong></td>
            <td width="5%" align="center"><strong>OT</strong></td>
          </tr>
<?php
  		
	//$fecha=$ano."-".$mes."-".$dia;
	
	$Consulta =  "select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito from sec_web.produccion_catodo as t1 ";
	$Consulta = $Consulta." inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
	$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_producto='18'  and t1.cod_subproducto='1'   and t2.fecha <= '".$fecha."'group by t1.cod_grupo";
	$Respuesta = mysqli_query($link, $Consulta);
	$total_prod=0;
	$total_scrap=0;
	$total_peso_anodos=0;
	$total_rec=0;
	$total_rech=0;
	$total_cuba=0;
	$cont=0;
	$i=0;
	$p=0;
	
	$total_rechaza=0;
	$sum_porc_rech=0;
	$total_ne=0;																	
	$total_nd=0;																	
	$total_ra=0;																		
	$total_cl=0;																	
	$total_cs=0;																		
	$total_ot=0;																	
	$total_porcentaje_scrap=0;	
	while ($Fila = mysqli_fetch_array($Respuesta))
	  {
	        $cont=$cont+1;
			echo "<tr>";
			$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";
			$respuesta_turno= mysqli_query($link, $Consulta_turno);
			$row_turno = mysqli_fetch_array($respuesta_turno);
			$turno1 = isset($row_turno["turno1"])?$row_turno["turno1"]:"";
			echo "<td align='center'>".$Fila["cod_circuito"]."</td>";
			echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle('".$fecha."','".$Fila["cod_grupo"]."','".$turno1."')\">";
				//aqui sacar dias de renovacion  del grupo  poly 2005-01-31
			$j=0;
			$anomes=substr($fecha,0,8);
			$fechita=$anomes.'01';
		
			$con="select dia_renovacion as dia_renovacion from  sec_web.renovacion_prog_prod";
			$con.=" where cod_grupo = '".$Fila["cod_grupo"]."' and cod_concepto = '".$turno1."'";
			$con.=" and fecha_renovacion ='".$fechita."'"; 
			$Respuestap = mysqli_query($link, $con);
			$dia11=0;
			$dia2=0;
			while ($Filap = mysqli_fetch_array($Respuestap))
			{
				if ($j ==0)
				{
					$dia11 = $Filap["dia_renovacion"];
				
					$j=$j+1;
				}
				elseif($j==1)
				{
					$dia2=$Filap["dia_renovacion"];
					$j=$j+1;
				}
				if ($j>1)
				{
					break;
				}
			}
			$diacambio = $dia11-$dia2;
			$var="D";
			$p1=0;
			echo $Fila["cod_grupo"]."-".$diacambio." ".$var."</td>";
			echo "<td align='center'>".$turno1."&nbsp</td>";
			$consulta_produccion="select sum(peso_produccion) as produccion from sec_web.produccion_catodo ";
			$consulta_produccion=$consulta_produccion."where fecha_produccion = '".$fecha."' and cod_producto='18'  and cod_subproducto='1'   and cod_grupo = '".$Fila["cod_grupo"]."' group by cod_grupo";
			$Respuesta_produccion = mysqli_query($link, $consulta_produccion);
			$Fila_produccion = mysqli_fetch_array($Respuesta_produccion);
			$produccion=number_format($Fila_produccion["produccion"],2,",",".");

			echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_produccion('".$fecha."','".$Fila["cod_grupo"]."')\">";
			echo $produccion."</td>";
			//aqui saca los grupos en un arreglo igual lo tengo que hacer yo
		
			$grupos[$i]=$Fila["cod_grupo"];
			if ($turno1=="")
			{ 
			 	$turno[$i]='N';
			}
			else
			{
				$turno[$i]=$row_turno["turno1"];
			}
			$i=$i+1;
         /****************************************************************************************************************************************/
			$Consulta20="select fecha as fecha_fila from ref_web.grupo_electrolitico2 where cod_grupo='".$Fila["cod_grupo"]."' order by fecha asc";
			$respuesta20=mysqli_query($link, $Consulta20);
			$sw=0;
			$total_por_scrap=0;
			
			while ($fila20=mysqli_fetch_array($respuesta20) and ($sw==0))
			{
				if ($fila20["fecha_fila"] <= $fecha) 
				{
					$fecha_aux=$fila20["fecha_fila"];
				}
				 else {$sw=1;
				 }
			}
			$grup=$Fila["cod_grupo"];
			if ($grup >'01' and $grup <= '09')  
			{ 
				$grup=substr($grup,1,1);
			}
			//saca el peso de produccion anodos de ese grupo
			$consultap="select campo2,sum(peso) peso_anodos,sum(unidades) as uni_anodos from sea_web.movimientos where tipo_movimiento = '2'";
			$consultap.=" and fecha_movimiento = '".$fecha."' and cod_producto != '19' and campo2 = '".$grup."' group by campo2";
			//echo "con".$consultap;
			$pj=mysqli_query($link, $consultap);
			$ppj=mysqli_fetch_array($pj);	
			$peso_anodos = isset($ppj["peso_anodos"])?$ppj["peso_anodos"]:0;
			$p1=number_format($peso_anodos,2,".","");
			
			//saca peso del produccin del resto de ese frupo	
			$consultaj="select campo2,sum(peso) as peso,sum(unidades) as unidades from sea_web.movimientos where tipo_movimiento = '3'";
			$consultaj.=" and fecha_movimiento = '".$fecha."' and campo2 ='".$grup."' group by campo2";
			$rp=mysqli_query($link, $consultaj);
			$rpp=mysqli_fetch_array($rp); 
			$peso = isset($rpp["peso"])?$rpp["peso"]:0;
			$scrap=0;
			$p=0;
			$pp=0;
			$p=number_format($peso,2,".","");
			if ($p1 != 0)
			{
				$scrap = ($p/$p1) * 100;
			}	
			$scrap=number_format($scrap,2,",",".");
			$pp=number_format($p,2,",",".");
			$peso_anodos=number_format($p1,2,",",".");
			
			
			echo "<td align='center'>$peso_anodos&nbsp;</td>";
			
			echo"<td align='center'>$pp&nbsp;</td>";
 			echo"<td align='center'>$scrap&nbsp;</td>";
			$Consulta = "select ifnull(cubas_descobrizacion,0) as cant_cuba, ifnull(num_cubas_tot,0) as num_cubas, ifnull(num_catodos_celdas,1) as num_catodos from ref_web.grupo_electrolitico2 ";
			$Consulta = $Consulta."where cod_grupo = '".$Fila["cod_grupo"]."' and  fecha = '$fecha_aux'";
			$rs1 = mysqli_query($link, $Consulta);
			$row1 = mysqli_fetch_array($rs1);
			echo "<td align='center'>".$row1["cant_cuba"]."&nbsp</td>";
			$Consulta ="select ifnull(sum(unid_recup),0) as recuperado_tot, ifnull(sum(estampa),0) as ne, ifnull(sum(dispersos),0) as nd, ifnull(sum(rayado),0) as ra, ";
			$Consulta =$Consulta."ifnull(sum(cordon_superior),0) as cs, ifnull(sum(cordon_lateral),0) as cl, ifnull(sum(otros),0) as ot from cal_web.rechazo_catodos as t1 " ;
			$Consulta = $Consulta."where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";
			$Respuesta2 = mysqli_query($link, $Consulta);
			$Fila2 = mysqli_fetch_array($Respuesta2);
			$total_prod=$total_prod+$Fila_produccion["produccion"];
			$total_scrap=$total_scrap+$p;
			
			$total_peso_anodos = $total_peso_anodos +$p1;
			
			$total_rec=$total_rec+$Fila2["recuperado_tot"];
			$total_cuba=$total_cuba+$row1["cant_cuba"];
			echo "<td align='center'>".$Fila2["recuperado_tot"]."&nbsp</td>";
			$divisor=$row1["num_cubas"]-$row1["cant_cuba"];
			$porc_rec=(($Fila2["recuperado_tot"]/($divisor*$row1["num_catodos"]))*100);
     		$porc_rec2=number_format($porc_rec,"2",".","");

			$total_rechaza=$total_rechaza+$porc_rec2;
			if ($porc_rec2 > 20)
			   {echo "<td align='center'><font color='green'><strong>$porc_rec2&nbsp</strong></font></td>";}
			 else {echo "<td align='center'>$porc_rec2&nbsp</td>\n";}  

			$rechazado_tot_fila=$Fila2["ne"]+$Fila2["nd"]+$Fila2["ra"]+$Fila2["cl"]+$Fila2["cs"]+$Fila2["ot"];
			$total_rech=$total_rech+$rechazado_tot_fila;
			echo "<td align='center'>$rechazado_tot_fila&nbsp</td>";
			$divisor2=$row1["num_cubas"]-$row1["cant_cuba"];
			$total_por_rechazado=(($rechazado_tot_fila/($divisor2*$row1["num_catodos"]))*100);
			$total_por_rechazado2=number_format($total_por_rechazado,"2",".","");
			$sum_porc_rech=$sum_porc_rech+$total_por_rechazado;
			if ($total_por_rechazado > 3.2)
				{echo "<td align='center'><font color='red'><strong>$total_por_rechazado2&nbsp</strong></font></td>";}
			else {echo "<td align='center'>$total_por_rechazado2&nbsp</td>";}	
			echo "<td align='center'>".$Fila2["ne"]."&nbsp</td>";
			$total_ne=$total_ne+$Fila2["ne"];
			echo "<td align='center'>".$Fila2["nd"]."&nbsp</td>";
			$total_nd=$total_nd+$Fila2["nd"];
			echo "<td align='center'>".$Fila2["ra"]."&nbsp</td>";
			$total_ra=$total_ra+$Fila2["ra"];
			echo "<td align='center'>".$Fila2["cl"]."&nbsp</td>";
			$total_cl=$total_cl+$Fila2["cl"];
			echo "<td align='center'>".$Fila2["cs"]."&nbsp</td>";
			$total_cs=$total_cs+$Fila2["cs"];
			echo "<td align='center'>".$Fila2["ot"]."&nbsp</td>";
			$total_ot=$total_ot+$Fila2["ot"];		
			echo "</tr>";
       }
	  
	  
$total_prod2=number_format($total_prod,2,".",".");
if ($total_scrap != 0)
{
	$total_por_scrap =($total_scrap/$total_peso_anodos)*100;
	$total_porcentaje_scrap =number_format($total_por_scrap,"2",".","");
}	
$total_anodos2=number_format($total_peso_anodos,2,",",".");
$total_scrap2=number_format($total_scrap,2,",",".");
//aqui

echo "<td align='right'><strong>TOTAL</strong></td>";
echo "<td align='center'>--</td>\n";
echo "<td align='center'>--</td>\n";	   
echo "<td align='center'><font color='blue'>$total_prod2&nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_anodos2&nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_scrap2&nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_porcentaje_scrap&nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_cuba &nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_rec</font></td>";
if ($cont==0)
    {$cont=1;}
	
//echo $total_rechaza;
$total_rechaza=($total_rechaza/$cont);
//echo $total_rechaza.'=('.$total_rechaza.'/'.$cont.')';
$porc_rechaza2=number_format($total_rechaza,"2",".","");
echo "<td align='center'><font color='blue'>$porc_rechaza2&nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_rech&nbsp</font></td>";

//echo $porc_rechaza2;
$sum_porc_rech=($sum_porc_rech/$cont);
$sum_porc_rech2=number_format($sum_porc_rech,"2",".","");
echo "<td align='center'><font color='blue'>$sum_porc_rech2&nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_ne&nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_nd&nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_ra&nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_cl&nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_cs&nbsp</font></td>";
echo "<td align='center'><font color='blue'>$total_ot&nbsp</font></td>";
//hasta aqui copio lo de consulta produccion
?>

</tr>
</table>

	
		<?php
		///<tr>?> 
		
		<p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
    
   <p>&nbsp;</p>
   
   <table width="80%" height="92" border="1">
     <tr align="center">
       <td height="18" colspan="9"><strong>2.-PRODUCCION AREA DE HOJAS MADRES</strong></td>
     </tr>
     <tr>
       <td width="8%" rowspan="2" align="center"><strong>GRUPO</strong></td>
       <td width="14%" rowspan="2" align="center"><strong>PRODUCCION</strong></td>
       <td colspan="5" align="center"><strong>RECHAZO</strong></td>
       <td width="13%" colspan="2" align="center"><strong>RECUPERADO</strong></td>
     </tr>
     <tr>
       <td width="12%" align="center"><strong>DELGADAS</strong></td>
       <td width="14%" align="center"><strong>GRANULADAS</strong></td>
       <td width="10%" align="center"><strong>GRUESAS</strong></td>
       <td width="7%" align="center"><strong>TOTAL</strong></td>
       <td width="7%" align="center"><strong>%</strong></td>
       <td width="7%" align="center"><strong>TOTAL</strong></td>
       <td width="7%" align="center"><strong>%</strong></td>
     </tr>
     <?php
		$mostrar="S";
		if ($mostrar == "S")
		{		   
			$total_peso=0;
			$total_del=0;
			$total_gran=0;
			$total_grue=0;
			$total_recuperado=0;	 
			$total_unidades=0; 	
			$total2=0;
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
				echo "<td align='center'>$produccion&nbsp</td>\n";
				$Consulta5 = "select cod_grupo,ifnull(rechazo_delgadas,0) as rec_del,ifnull(rechazo_granuladas,0) as rec_gran,ifnull(rechazo_gruesas,0) as rec_grue from ref_web.produccion as t1 ";
				$Consulta5 = $Consulta5."inner join proyecto_modernizacion.sub_clase as t2  on t1.cod_grupo=t2.valor_subclase1 ";
				$Consulta5 = $Consulta5."where t1.fecha = '".$fecha."' and t1.cod_grupo = t2.valor_subclase1 and t1.cod_grupo= '".$row2["sub_clase1"]."' group by t1.cod_grupo";
				//echo $Consulta5;
       			$rs12 = mysqli_query($link, $Consulta5);
				$row12 = mysqli_fetch_array($rs12);
				$rec_del  = isset($row12["rec_del"])?$row12["rec_del"]:0;
				$rec_gran = isset($row12["rec_gran"])?$row12["rec_gran"]:0;
				$rec_grue = isset($row12["rec_grue"])?$row12["rec_grue"]:0;
	

				echo "<td align='center'>".$rec_del."&nbsp</td>\n";
				echo "<td align='center'>".$rec_gran."&nbsp</td>\n";
				echo "<td align='center'>".$rec_grue."&nbsp</td>\n";

				$total=$rec_del+$rec_gran+$rec_grue;

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
					//$porc_rech=(($total/$total_unidades)*100);
					$porc_rech=(($total/$produccion)*100);
				}
					//;
				$porc_rech2=number_format($porc_rech,"2",",","");
				echo "<td align='center'>$total&nbsp</td>\n";
				echo "<td align='center'>$porc_rech2&nbsp</td>\n";
				$Consulta7="select ifnull(recuperado,0) as recuperado from ref_web.recuperado as t1 "; 
				$Consulta7=$Consulta7."where t1.fecha ='".$fecha."' ";
				$rs13 = mysqli_query($link, $Consulta7);
				$row13 = mysqli_fetch_array($rs13);
				echo "<td align='center'>--&nbsp</td>\n";
				echo "<td align='center'>--&nbsp</td>\n";
				echo "</tr>\n";								
          	}    
            echo "<td align='right'><strong>TOTAL</strong></td>\n";	
			echo "<td align='center'><font color='blue'>$total_unidades&nbsp</font></td>\n";
			echo "<td align='center'><font color='blue'>$total_del&nbsp</font></td>\n";
			echo "<td align='center'><font color='blue'>$total_gran&nbsp</font></td>\n";
			echo "<td align='center'><font color='blue'>$total_grue&nbsp</font></td>\n";	
			echo "<td align='center'><font color='blue'>$total2&nbsp</font></td>\n";
			if (($total_unidades==0) or($total_unidades==0))
			{
				$porc_tot_rech=0;
			}
			else
			{
				 $porc_tot_rech=(($total2/$total_unidades)*100);
			}
			$recuperado = isset($row13["recuperado"])?$row13["recuperado"]:0;
			$porc_tot_rech=number_format($porc_tot_rech,"2",",","");
			echo "<td align='center'><font color='blue'>$porc_tot_rech&nbsp</font></td>\n";
			echo "<td align='center'><font color='blue'>".$recuperado."&nbsp</font></td>\n";
			if (($total_unidades==0) or ($total2==0))
			{
				$porc_tot_rec=0;
			}
			else
			{
				$porc_tot_rec=(($recuperado/$total_unidades)*100);
			}
			$porc_tot_rec=number_format($porc_tot_rec,"2",".","");
			echo "<td align='center'><font color='blue'>$porc_tot_rec&nbsp</font></td>\n";
		}
	?>
  </table>
   <p>&nbsp;</p>
   <!-- FINAL segunda TABLA -->
   

     	<table width="80%" border="1">
   		<tr align="center"> 
    		<td colspan="6">3.-CONFECCION CATODOS INICIALES</td>
    </tr>
    <tr> 
    	<td width="9%" rowspan="2" align="center">TURNO</td>
        <td width="17%" align="center">PRODUCCION</td>
        <td width="24%"  align="center">PRODUCCION</td>
        <td width="16%"  align="center">PRODUCCION</td>
        <td width="40%" rowspan="2" align="center">CONSUMO COMERCIAL</td>
		
        <td width="21%" rowspan="2" align="center">OBSERVACIONES</td>
	</tr>
    <tr> 
    	<td width="40%" rowspan="1" align="center">MFCI</td>
		<td  width="40%" rowspan="1"  align="center">MCB</td>
    	<td  width="40%" rowspan="1"  align="center">MCO</td>

   	</tr>

		
	<?php

	$Consulta =  "select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito from sec_web.produccion_catodo as t1 ";
	$Consulta = $Consulta." inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
	$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_producto='18'  and t1.cod_subproducto='1'   and t2.fecha <= '".$fecha."'group by t1.cod_grupo";
	$Respuesta = mysqli_query($link, $Consulta);
	$total_prod=0;
	$total_scrap=0;
	$total_rec=0;
	$total_rech=0;
	$total_cuba=0;
	$cont=0;
	$i=0;
	$p=0;
	
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
	        $cont=$cont+1;
			
			$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";
			$respuesta_turno= mysqli_query($link, $Consulta_turno);
			$row_turno = mysqli_fetch_array($respuesta_turno);
			$turno1=isset($row_turno["turno1"])?$row_turno["turno1"]:"";
			//aqui sacar dias de renovacion  del grupo  poly 2005-01-31
			$j=0;
			$anomes=substr($fecha,0,8);
			$fechita=$anomes.'01';
		
			$con="select dia_renovacion as dia_renovacion from  sec_web.renovacion_prog_prod";
			$con.=" where cod_grupo = '".$Fila["cod_grupo"]."' and cod_concepto = '".$turno1."'";
			$con.=" and fecha_renovacion ='".$fechita."'"; 	
			$Respuestap = mysqli_query($link, $con);
			$dia1=0;
			$dia2=0;	
			while ($Filap = mysqli_fetch_array($Respuestap))
			{
				if ($j ==0)
				{
					$dia1 = $Filap["dia_renovacion"];
				
					$j=$j+1;
				}
				elseif($j==1)
				{
					$dia2=$Filap["dia_renovacion"];
					$j=$j+1;
				}
				if ($j>1)
				{
					break;
				}
			}
			$diacambio = $dia1-$dia2;
			$var="D";
			$p1=0;
			$consulta_produccion="select sum(peso_produccion) as produccion from sec_web.produccion_catodo ";
			$consulta_produccion=$consulta_produccion."where fecha_produccion = '".$fecha."' and cod_producto='18'  and cod_subproducto='1'   and cod_grupo = '".$Fila["cod_grupo"]."' group by cod_grupo";
			$Respuesta_produccion = mysqli_query($link, $consulta_produccion);
			$Fila_produccion = mysqli_fetch_array($Respuesta_produccion);
			$produccion=number_format($Fila_produccion["produccion"],2,",",".");

			//aqui saca los grupos en un arreglo igual lo tengo que hacer yo
		
			$grupos[$i]=$Fila["cod_grupo"];
			if ($turno1=="")
			{ 
			 	$turno[$i]='N';
			}
			else
			{
				$turno[$i]=$row_turno["turno1"];
			}
			$i=$i+1;
	}		
		  
		  
		  	
		  	$mostrar="S";
			//$mostrar2="S";
			
		  	$total_mfci=0;
			$total_mdb=0;
			$total_mco=0;
			$total_consumo=0;
			$mostrar2='S';
			$total_dp=0; //WSO
			$total_ew=0;
			//$total_A=0;
			//$total_B=0;
			if ($mostrar=='S')
			 {
			 	reset ($grupos);
			 }
			$i=0;
			if ($mostrar=='S')
			{
				foreach($grupos as $a => $b)
				{ 
					$Dia_r=substr($fecha,8,2);
					$Mes_r=substr($fecha,5,2);
					$Ano_r=substr($fecha,0,4);
					$fecha_renovacion=$Ano_r.'-'.$Mes_r.'-01';
					$consulta_datos="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
					$consulta_datos.="where fecha_renovacion='".$fecha_renovacion."' ";
					$consulta_datos.="and dia_renovacion='".$Dia_r."' and cod_grupo=$b and (cod_concepto='A' or cod_concepto='B')";
					$Resp_datos = mysqli_query($link, $consulta_datos);
					$total_A=0;
					$total_B=0;
					if ($row_datos = mysqli_fetch_array($Resp_datos))
					{  
						$consulta_fecha= " select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <= '".$fecha."' and cod_grupo='$b'";
						$respuesta_fecha=mysqli_query($link, $consulta_fecha);
						$row_fecha = mysqli_fetch_array($respuesta_fecha);
						$consulta_datos_grupo="select fecha,num_cubas_tot,cubas_descobrizacion,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
						$consulta_datos_grupo.=" where fecha ='".$row_fecha["fecha"]."' and cod_grupo='$b'";
						$respuesta_datos_grupo=mysqli_query($link, $consulta_datos_grupo);
						$row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
						if ($row_datos["cod_concepto"]=='A')
						{
							$total_A=$total_A+((($row_datos_grupo["num_cubas_tot"]-$row_datos_grupo["hojas_madres"])-$row_datos_grupo["cubas_descobrizacion"])*$row_datos_grupo["num_catodos_celdas"]);
						}
						else if ($row_datos["cod_concepto"]=='B')
						{
							$total_B=$total_B + ((($row_datos_grupo["num_cubas_tot"]-$row_datos_grupo["hojas_madres"]) -$row_datos_grupo["cubas_descobrizacion"])*$row_datos_grupo["num_catodos_celdas"]);         
						}
							
					}
					$consulta_desc="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
					$consulta_desc.="where fecha_renovacion='".$fecha_renovacion."' ";
					$consulta_desc.="and dia_renovacion='".$Dia_r."' and cod_grupo=$b and desc_parcial<>'' ";
					$respuesta_desc=mysqli_query($link, $consulta_desc);
					if ($row_desc = mysqli_fetch_array($respuesta_desc))
					{
						$consulta_dp="select num_celdas_grupos,num_catodos_celda from ref_web.circuitos_especiales where cod_circuito='DP'";
						$respuesta_dp=mysqli_query($link, $consulta_dp);
						$row_dp = mysqli_fetch_array($respuesta_dp);
						$total_dp=$total_dp+($row_dp["num_celdas_grupos"]*$row_dp["num_catodos_celda"]);
					}
					$consulta_ew="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
					$consulta_ew.="where fecha_renovacion='".$fecha_renovacion."' ";
					$consulta_ew.="and dia_renovacion='".$Dia_r."' and cod_grupo=$b and electro_win<>'' ";
					$respuesta_ew=mysqli_query($link, $consulta_ew);
					if ($row_desc = mysqli_fetch_array($respuesta_ew))
					{
						$consulta_ew_d="select num_celdas_grupos,num_catodos_celda from ref_web.circuitos_especiales where cod_circuito='EW'";
						$respuesta_ew_d=mysqli_query($link, $consulta_ew_d);
						$row_ew_d = mysqli_fetch_array($respuesta_ew_d);
						$total_ew=$total_ew+($row_ew_d["num_celdas_grupos"]*$row_ew_d["num_catodos_celda"]);
					}
				}//fin del while
				$consulta_cat_ini="select turno as turno_cat_ini,ifnull(produccion_mfci,0) as prod_mfci,ifnull(produccion_mdb,0) as prod_mdb,ifnull(produccion_mco,0) as prod_mco,observacion as observacion,consumo as consumo_cat_inil from ref_web.iniciales as t1 ";
				$consulta_cat_ini=$consulta_cat_ini."where  t1.fecha = '".$fecha."' order by t1.turno";
				$Resp_cat_ini = mysqli_query($link, $consulta_cat_ini);
				$total_consumo_comercial=0;//WSO
				while ($row_cat_ini = mysqli_fetch_array($Resp_cat_ini))
				{
					echo "<tr>";
						echo "<td align='center'>".$row_cat_ini["turno_cat_ini"]."</td>";
						echo "<td align='center'>".$row_cat_ini["prod_mfci"]."</td>";
						$total_mfci=$total_mfci+$row_cat_ini["prod_mfci"];
						echo "<td align='center'>".$row_cat_ini["prod_mdb"]."</td>";
						$total_mdb=$total_mdb+$row_cat_ini["prod_mdb"];
						echo "<td align='center'>".$row_cat_ini["prod_mco"]."</td>";
						$total_mco=$total_mco+$row_cat_ini["prod_mco"];
						if ($mostrar2=='X')
						{
							echo "<td align='center'>&nbsp</td>";
							 echo "<td align='center'>".$row_cat_ini["observacion"]."</td>";
						}
						else if ($mostrar2=='S')
						{
							echo "<td align='center'>$total_A</td>";
							echo "<td align='center'>".$row_cat_ini["observacion"]."</td>";
						}
						else if ($mostrar2=='P')
						{
							echo "<td align='center'>$total_B</td>";
							echo "<td align='center'>".$row_cat_ini["observacion"]."</td>";
							$mostrar2='X';
						}
						if ($mostrar2=='S')
						{
							$mostrar2='P';
						}
						$total_consumo_comercial=$total_A + $total_B ;
					echo "</tr>";								
				} //fin del while
					echo "<td align='right'>Total</td>";
					echo "<td align='center'>$total_mfci</td>";
					echo "<td align='center'>$total_mdb</td>";
					echo "<td align='center'>$total_mco</td>";
					echo "<td align='center'>$total_consumo_comercial</td>";
					echo "<td align='center'>--</td>";
		   }		
	?>
    </table>
   	
  <table width="80%" border="1">
    <?php	if ($total_dp != 0)
		{
	?>
    		<tr>
        		<td width="60%"><strong>TOTAL CONSUMO DP</strong></td>
				<?php  echo "<td align='center'>".$total_dp."</td>";?>
			</tr>
		<?php 
		}
		 ?>
			<tr>
				<?php
				if  ($total_ew != 0) 
				{
				?>
                    <tr>
                    	<td width="60%"><strong>TOTAL CONSUMO EW</strong></td>
				         <?php  echo "<td align='center'>".$total_ew."</td>";?>
					</tr>
				<?php
				 }
				?> 
		        <?php       
			   		$consulta_desc="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
					$consulta_desc.="where fecha_renovacion='".$fecha_renovacion."' ";
					$consulta_desc.="and dia_renovacion='".$Dia_r."' and cod_concepto='D' and cod_grupo<>'' ";
					$respuesta_desc=mysqli_query($link, $consulta_desc);
					$total_normal_grupo=0;//WSO
					while ($row_desc = mysqli_fetch_array($respuesta_desc))
					{
						$consulta_fecha= " select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <= '".$fecha."' and cod_grupo='".$row_desc["cod_grupo"]."'";
						$respuesta_fecha=mysqli_query($link, $consulta_fecha);
						$row_fecha = mysqli_fetch_array($respuesta_fecha);
						$consulta_datos_grupo="select fecha,num_cubas_tot,cubas_descobrizacion,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
						$consulta_datos_grupo.=" where fecha ='".$row_fecha["fecha"]."' and cod_grupo='".$row_desc["cod_grupo"]."'";
						$respuesta_datos_grupo=mysqli_query($link, $consulta_datos_grupo);
						$row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
						$total_normal_grupo =$total_normal_grupo + ($row_datos_grupo["cubas_descobrizacion"] * $row_datos_grupo["num_catodos_celdas"]);
					}
					$total_consumo_total=$total_A + $total_B + $total_normal_grupo + $total_ew + $total_dp;
							  
				if ($total_normal_grupo !=0)
					{
				?>
						<tr>
							<td width="60%"><strong>TOTAL CONSUMO DESC. NORMAL</strong></td>
							<?php  echo "<td align='center'>".$total_normal_grupo."</td>";?>
						</tr>   
				<?php
					}
					if ($total_consumo_total !=0)
					{
				?>
						<tr>
							 <td width="60%"><strong>TOTAL CONSUMO </strong></td>
							
							 <?php  echo "<td align='center'>".$total_consumo_total."</td>";?>
						</tr>   
				<?php
					}
				?>
                <td width="60%"><strong>STOCK CATODOS (8:00) </strong></td>
                <?php 	
					$consulta_cat_ini_stock="select sum(stock) as stock1, sum(rechazo_cat_ini) as rechazo_ini_cat, catodos_en_renovacion from  ref_web.detalle_iniciales as t1 ";
					$consulta_cat_ini_stock=$consulta_cat_ini_stock."where  t1.fecha = '".$fecha."' group by t1.fecha";
					$Resp_cat_stock = mysqli_query($link, $consulta_cat_ini_stock);
					$row_cat_stock = mysqli_fetch_array($Resp_cat_stock);
					$stock1 = isset($row_cat_stock["stock1"])?$row_cat_stock["stock1"]:0;
					$rechazo_ini_cat       = isset($row_cat_stock["rechazo_ini_cat"])?$row_cat_stock["rechazo_ini_cat"]:0;
					$catodos_en_renovacion = isset($row_cat_stock["catodos_en_renovacion"])?$row_cat_stock["catodos_en_renovacion"]:0;
					echo "<td align='center'>".$stock1."</td>";
					
				?>
    		</tr>
			<td width="60%"><strong>STOCK LAMINAS (8:00) </strong></td>
            	<?php 
					$consulta_lam_ini_stock="select stock_dia from  ref_web.stock_diario as t1 ";
					$consulta_lam_ini_stock=$consulta_lam_ini_stock."where  t1.fecha = '".$fecha."' ";
					$Resp_lam_stock = mysqli_query($link, $consulta_lam_ini_stock);
					$row_lam_stock = mysqli_fetch_array($Resp_lam_stock);
					$stock_dia = isset($row_lam_stock["stock_dia"])?$row_lam_stock["stock_dia"]:0;
					echo "<td align='center'>".$stock_dia."</td>";
				?>
                </tr>

                <tr> 
                  <td width="80%"><strong>RECHAZO CATODOS INICIALES</strong></td>
                  <?php $rechazo_catodos= $rechazo_ini_cat + $catodos_en_renovacion;
				     echo "<td align='center'>".$rechazo_catodos."</td>";?>
                </tr>
								   
</table>
 <p>&nbsp;
</p>


<!-- FINAL tercera TABLA -->  

			       <table width="87%" border="1">
                <tr align="center"  class="ColorTabla01"> 
                  <td colspan="22"><strong>4.-CALIDAD FISICA Y QUIMICA CATODOS 
                    COMERCIALES </strong></td>
                </tr>
                <tr> 
                  <td width="90" align="center"><strong>GRUPO</strong></td>
                  <td width="48" align="center"><p><strong>Ag</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Au</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="58" align="center"><p><strong>As</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Sb</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Zn</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>S</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Bi</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Sn</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Fe</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Ni</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Pb</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Se</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>Te</strong></p>
                    <p><strong>ppm</strong></p></td>
                  <td width="48" align="center"><p><strong>O</strong></p>
                    <p><strong>ppm</strong></p></td>
                 
                </tr>
	<?php 
	
	
	 
		if ($Sig=='S')
	  	{
			$dia1=strval(intval($dia1+1));
	     	if ($dia1=='31')
	        { 
				$mes1=strval(intval($mes+1));
		       	$dia1='1';
			} 
	     	if  ($mes=='12')
	        { 
				$ano1=strval(intval($ano1+1));
		       	$mes1='1';
			   	$dia1='1';
			}      
	   	}
		
    	if ($Ant=='S')
	   	{
			$dia1=strval(intval($dia1-1));
			} 
			if (strlen($dia1) == 1)
			{
				$dia1 = '0'.$dia1;
		}
		if (strlen($mes1) ==1) 
  		{
			$mes1 = '0'.$mes1;
		}
	
		
		$fecha=$ano1."-".$mes1."-".$dia1;
		
		
		$Consulta =  "select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito from sec_web.produccion_catodo as t1 ";
		$Consulta = $Consulta." inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
		$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_producto='18'  and t1.cod_subproducto='1'   and t2.fecha <= '".$fecha."'group by t1.cod_grupo";
		$Respuesta = mysqli_query($link, $Consulta);
		$total_prod=0;
		$total_rec=0;
		$total_rech=0;
		$total_cuba=0;
		$cont=0;
		$i=0;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$cont=$cont+1;
			$grupos[$i]=$Fila["cod_grupo"];
			$i=$i+1;
		}
		$total = 0;
		
		$Consulta =  "select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito from sec_web.produccion_catodo as t1 ";
	    $Consulta = $Consulta." inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
		$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_producto='18'  and t1.cod_subproducto='1'   and t2.fecha <= '".$fecha."'group by t1.cod_grupo";
					//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			
			echo "<tr>\n";
		    echo "<td align='center'>".$Fila["cod_grupo"]."&nbsp</td>\n";
			if (($Fila["cod_grupo"]=='01') or ($Fila["cod_grupo"]=='02') or ($Fila["cod_grupo"]=='03') or ($Fila["cod_grupo"]=='04') or ($Fila["cod_grupo"]=='05') or ($Fila["cod_grupo"]=='06') or ($Fila["cod_grupo"]=='07') or ($Fila["cod_grupo"]=='08') or($Fila["cod_grupo"]=='09'))
			{
				$grupo_aux=substr($Fila["cod_grupo"],1,1);
				$Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                $Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and (id_muestra='".$Fila["cod_grupo"]."' or id_muestra='$grupo_aux') and cod_producto='18' and cod_subproducto='1' and cod_analisis='1' and cod_tipo_muestra='3'";
			}
			else
			{
				$Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                $Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and id_muestra='".$Fila["cod_grupo"]."' and cod_producto='18' and cod_subproducto='1' and cod_analisis='1' and cod_tipo_muestra='3'";} 
				$Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
				$Fila_fecha = mysqli_fetch_array($Respuesta_fecha);
				if (($Fila["cod_grupo"]=='01') or ($Fila["cod_grupo"]=='02') or ($Fila["cod_grupo"]=='03') or ($Fila["cod_grupo"]=='04') or ($Fila["cod_grupo"]=='05') or ($Fila["cod_grupo"]=='06') or ($Fila["cod_grupo"]=='07') or ($Fila["cod_grupo"]=='08') or($Fila["cod_grupo"]=='09'))
				{
    				$Consulta_electrolitos="select ifnull(t1.valor,0) as valor,t1.candado,t1.cod_unidad,t1.cod_leyes,signo from cal_web.leyes_por_solicitud as t1 ";
					$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
					$Consulta_electrolitos=$Consulta_electrolitos."where (t1.id_muestra='".$Fila["cod_grupo"]."' or t1.id_muestra='$grupo_aux') and t1.cod_producto='18' and left(t1.fecha_hora,10)='".$Fila_fecha["fecha2"]."' and t1.cod_leyes in ('04','05','08','09','10','26','27','30','31','36','39','40','44','48') and t1.cod_subproducto='1'";
	 			}
				else
				{
					$Consulta_electrolitos="select  ifnull(t1.valor,0) as valor,t1.candado,t1.cod_unidad,t1.cod_leyes,signo from cal_web.leyes_por_solicitud as t1 ";
					$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
					$Consulta_electrolitos=$Consulta_electrolitos."where t1.id_muestra='".$Fila["cod_grupo"]."'  and t1.cod_producto='18' and left(t1.fecha_hora,10)='".$Fila_fecha["fecha2"]."' and t1.cod_leyes in ('04','05','08','09','10','26','27','30','31','36','39','40','44','48') and t1.cod_subproducto='1'";
				}	
				$Respuesta_electrolitos = mysqli_query($link, $Consulta_electrolitos);
				//echo $Consulta_electrolitos;
				while ($Fila_electrolitos = mysqli_fetch_array($Respuesta_electrolitos))
				{  
					
					if ($Fila_electrolitos["valor"] < 0)
					{
						$total=number_format($Fila_electrolitos["valor"],"2","","");
						if ($Fila_electrolitos["signo"] !='=')
                        {
							echo "<td align='center'>".$Fila_electrolitos["signo"]."$total&nbsp</td>\n";
							$poly =($Fila_electrolitos["signo"].$total);

						
						}
						else 
						{
							
							
					    
							
							echo "<td align='center'>$total&nbsp</td>\n";
							$poly =($Fila_electrolitos["signo"].$total);

						} 
					}
					else
					{
						
						$total=number_format($Fila_electrolitos["valor"],"2","","");
					
						
					  
						
						echo "<td align='center'>&nbsp;".$Fila_electrolitos["signo"]."$total</td>";
						$poly =($Fila_electrolitos["signo"].$total);
						

					}
	
			}
				
	
				

				//echo "grupo:".$Fila["cod_grupo"];

				if ($total ==0)
				{
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
					echo "<td align='center'>&nbsp</td>\n";
				
				}
			
			$total = 0;		 
		echo "</tr>\n";
		}
	?>
    </table>
	<p>&nbsp;    </p>
    <p>&nbsp;</p>
	
	<!-- FINAL cuarta TABLA -->  
	<table width="87%" border="1" cellpadding="2">
    	<tr align="center"  class="ColorTabla01"> 
        	<td colspan="18"><strong>5.-RENOVACION ELECTRODOS</strong></td>
       	</tr>
    	<tr> 
        	<td width="12%" rowspan="2" align="center"><strong>CIRCUITO</strong></td>
            <td width="9%" rowspan="2" align="center"><strong>GRUPO</strong></td>
            <td colspan="2" align="center"><strong>TIPO DE ANODOS</strong></td>
            <td colspan="8" align="center">COMPOSICION ANODO NUEVO (PPM)</td>
     	</tr>
        <tr> 
        	<td width="8%" height="27" align="center"><strong>SEMI</strong></td>
            <td width="8%" align="center"><strong>NUEVO</strong></td>
            <td width="8%" align="center"><p><strong>As</strong></p>
            	<p><strong>&lt;1500</strong></p></td>
          	<td width="10%" align="center"><p><strong>Sb</strong></p>
            	<p><strong>&lt;500</strong></p></td>
            <td width="10%" align="center"><p><strong>Bi</strong></p>
            	<p><strong>&lt;15</strong></p></td>
			<td width="5%" align="center"><p><strong>Fe</strong></p>
            	<p><strong>&lt;30</strong></p></td>
			<td width="6%" align="center"><p><strong>Ni</strong></p>
                <p><strong>&lt;150</strong></p></td>
			<td width="9%" align="center"><p><strong>Se</strong></p>
            	<p><strong>&lt;300</strong></p></td>
        	<td width="7%" align="center"><p><strong>Te</strong></p>
            	<p><strong>&lt;50</strong></p></td>
            <td width="8%" align="center"><p><strong>O</strong></p>
                <p><strong>&lt;2000</strong></p></td>
    	</tr>
  <?php 
  
		if ($mostrar == "S")
		{
			$limites=array(1500,500,15,30,150,300,50,2000);
			reset ($grupos);
			foreach($grupos as $a => $b)
			{			 	
				$grupo= intval($b);
				$consulta2="select distinct cod_circuito from ref_web.grupo_electrolitico2 where cod_grupo='".$b."'";
				$Respuesta3 = mysqli_query($link, $consulta2);
				$Fila3 = mysqli_fetch_array($Respuesta3);
			echo "<tr>";
				echo "<td align='center'>".$Fila3["cod_circuito"]."&nbsp</td>\n";  
				echo "<td align='center'>$b&nbsp</td>\n";
				$arr_meses=array('Enero','Febrero_nor','Marzo','Abril','Mayo','Junio','Julio','Agosto','septiembre','Octubre','Noviembre','Diciembre');
				$arr_dias=array(31,28,31,30,31,30,31,31,30,31,30,31); 
				$ano_aux=intval($ano1);
				$mes_aux=intval($mes1);
				$calculo=$ano_aux/4;
				$calculo2=number_format($calculo,"0","","");
				$resto=$calculo2-$calculo;
				if ($resto==0)
				{
					$bisiesto='S';
					$mes_dia=28;
				}
				else
				{
					$bisiesto='N';}
					$dia_aux=intval($dia1);
					if ($dia_aux < 9)
					{
						$restantes= 8-$dia_aux;
						if ($mes_aux==1)
						{
							$mes_aux=strval(12);
							$ano_aux=strval($ano_aux-1);
							$dia_aux=$arr_dias[(intval($mes_aux))-1];
							$dia_aux=strval($dia_aux-$restantes);
						}
						else if (($mes_aux==3) and ($bisiesto=='N'))
						{
							$mes_aux=strval(2);
							$dia_aux=$arr_dias[intval($mes_aux)-1];
							$dia_aux=strval($dia_aux-$restantes);
						}
						else if (($mes_aux==3) and ($bisiesto=='S'))
						{
							$mes_aux=strval(2);
							$dia_aux=strval($mes_dia-$restantes);
					} 	  
					else
					{
						$mes_aux=strval(intval($mes_aux)-1);	
						$dia_aux=$arr_dias[intval($mes_aux)-1];
						$dia_aux=strval($dia_aux-$restantes);
					}
				}
				else
				{
					$dia_aux=strval($dia_aux-8);
					$mes_aux=strval($mes_aux);
					$ano_aux=strval($ano_aux);
				}		
				if (strlen($dia_aux)==1)
				{
					$dia_aux='0'.$dia_aux;
				}
				if (strlen($mes_aux)==1)
				{
					$mes_aux='0'.$mes_aux;
				}	
							
				$fecha_ant=$ano_aux."-".$mes_aux."-".$dia_aux;
				
				
				
				$cons_subp2="select distinct t1.cod_subproducto as producto from sea_web.movimientos as t1 ";
				$cons_subp2=$cons_subp2."where t1.tipo_movimiento='2' and t1.campo2=$grupo and t1.fecha_movimiento='".$fecha_ant."' and t1.cod_producto='17' and t1.cod_subproducto not in ('08') group by t1.hornada";
				$Resp_subp2 = mysqli_query($link, $cons_subp2);
				$Fila_subp2 = mysqli_fetch_array($Resp_subp2);
				$producto = isset($Fila_subp2["producto"])?$Fila_subp2["producto"]:"";
				if ($producto==1)
				{
					echo "<td align='center'>HVL&nbsp</td>\n";
				}
				else if ($producto==4)
				{
					echo "<td align='center'>Ventana&nbsp</td>\n";
				}
				else if ($producto==2)
				{
					echo "<td align='center'>Teniente&nbsp</td>\n";
				}
				else if ($producto==3)
				{
					echo "<td align='center'>Disputada&nbsp</td>\n";
				}
			else
			{
				echo "<td align='center'>&nbsp</td>\n";
			}
			$cons_subp="select distinct t1.cod_subproducto as producto from sea_web.movimientos as t1 ";
			$cons_subp=$cons_subp."where t1.tipo_movimiento='2' and t1.campo2=$grupo and t1.fecha_movimiento='".$fecha."' and t1.cod_producto='17' and t1.cod_subproducto not in ('08') group by t1.hornada";
			$Resp_subp = mysqli_query($link, $cons_subp);
			$Fila_subp = mysqli_fetch_array($Resp_subp);
			$producto = isset($Fila_subp["producto"])?$Fila_subp["producto"]:"";
			if ($producto==1)
			{
				echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
			    echo HVL."</td>\n";
			}
			else if ($producto==4)
			{
				echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
			    echo Ventana."</td>\n";}
			else if ($producto==2)
			{
				echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
			    echo Teniente."</td>\n";}
			else if ($producto==3)
			{
				echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
			    echo Disputada."</td>\n";
		}
		else
		{
			echo "<td align='center'>&nbsp</td>\n";
		}
			$i = 0;
			$a=array("08","09","27","31","36","40","44","48");
					
			
				$consulta="select sum(t1.peso) as peso_cargado from sea_web.movimientos as t1 ";
				$consulta=$consulta."where t1.tipo_movimiento='2' and t1.campo2=$grupo and t1.fecha_movimiento='".$fecha."' and t1.cod_producto='17' and t1.cod_subproducto not in ('08')  ";
				$Respuesta = mysqli_query($link, $consulta);
				$Fila = mysqli_fetch_array($Respuesta);
				$l=0;
				
		for ($i = 0;$i<8;$i++)
		{
			$codley=$a[$i];
				//echo "peso cargado".$Fila["peso_cargado"];
			$consulta2="select t1.peso as peso_cargado,t2.cod_leyes,t2.valor as ley,t1.cod_subproducto as subproducto ";
			$consulta2.=", sum(t1.peso * t2.valor / '".$Fila["peso_cargado"]."') as calculo ";
			$consulta2.="from sea_web.movimientos as t1  ";
			$consulta2.="inner join sea_web.leyes_por_hornada as t2 "; 
			$consulta2.="on t1.hornada=t2.hornada and t1.cod_producto=t2.cod_producto  ";
			$consulta2.="and t1.cod_subproducto=t2.cod_subproducto  ";
			$consulta2.="where t1.tipo_movimiento='2' and t1.campo2=$grupo and  ";
			$consulta2.="t1.fecha_movimiento='".$fecha."' and t1.cod_producto='17' and t1.cod_subproducto not in ('08') ";
			//$consulta2.="and t2.cod_leyes in ('08','09','27','44','48','40','31','36') group by t2.cod_leyes ";
			$consulta2.="and t2.cod_leyes = '".$codley."'  group by t2.cod_leyes ";

			$consulta2.="order by t2.cod_leyes ";
			$Respuesta2 = mysqli_query($link, $consulta2);
			$Fila2 = mysqli_fetch_array($Respuesta2);
			$cod_leyes = isset($Fila2["cod_leyes"])?$Fila2["cod_leyes"]:"";
			$total_total_ley=0;			
			//while ($Fila2 = mysqli_fetch_array($Respuesta2))			
				if ($cod_leyes== "")
				{
					echo "<td align='center'>&nbsp</td>\n";
				}
				else
				{
						
					if ($Fila2["calculo"] >= $limites[$l])
					{
						echo "<td align='center'><font color='red'><strong> ".number_format($Fila2["calculo"],2,",","")."&nbsp</strong></fornt></td>\n";
					}	 
					else
					{				
						echo "<td align='center'>".number_format($Fila2["calculo"],2,",","")."&nbsp</td>\n";
						
					}
				$l=$l+1;	
				}	 	
			}
			echo "</tr>\n";
			}
		}	
	?>
	</table>
	<p>&nbsp;    </p>

	<table width="87%" height="12" border="1" cellpadding="2">
		<tr align="center"  class="ColorTabla01"> 
    		<td colspan="22"><strong>6.- ELECTROLITO</strong></td>
        </tr>
    	<tr> 
        	<td width="40" align="center"><strong>CIRCUITO</strong></td>
            <td width="40" height="63" align="center"><p><strong>Cu</strong></p>
            	<p><strong>[g/l]</strong></p></td>
            <td width="40" align="center"><p><strong>H2SO4</strong></p>
            	<p><strong>[g/l]</strong></p></td>
          	<td width="40" align="center"><p><strong>As</strong></p>
         		<p><strong>[g/l]</strong></p></td>
          	<td width="40" align="center"><p><strong>Sb</strong></p>
          		<p><strong>[g/l]</strong></p></td>
           	<td width="40" align="center"><p><strong>Ca</strong></p>
                <p><strong>[g/l]</strong></p></td>
          	<td width="40" align="center"><p><strong>Fe</strong></p>
          		<p><strong>[g/l]</strong></p></td>
       		<td width="40" height="3" align="center"><p><strong>Mg</strong></p>
            	<p><strong>[g/l]</strong></p></td>
         	<td width="40" align="center"><p><strong>Ni</strong></p>
                <p><strong>[g/l]</strong></p></td>
          	<td width="40" align="center"><p><strong>Zn</strong></p>
             	<p><strong>[g/l]</strong></p></td>
       		<td width="40" align="center"><p><strong>Bi</strong></p>
         		<p><strong>[mg/l]</strong></p></td>
       		<td width="40" align="center"><p><strong>Pb</strong></p>
          		<p><strong>[g/l]</strong></p></td>
         	<td width="40" align="center"><p><strong>Cl</strong></p>
            	<p><strong>[mg/l]</strong></p></td>
        	<td width="40" align="center"><p><strong>Se</strong></p>
           		<p><strong>[mg/l]</strong></p></td>
         	<td width="19" align="center"><p><strong>Te</strong></p>
            	<p><strong>[mg/l]</strong></p></td>
      		<td width="19" align="center"><p><strong>SS</strong></p>
            	<p><strong>[mg/l]</strong></p></td>
      	</tr>
        <?php  
			if ($mostrar == "S")
					{
       					$cod_leyes=array('02','22','08','09','56','31','60','36','10','27','39','11','40','44','72');
						$circuitos=array('1','2','3','4','5','6','DP','DT','RETORNO');
						reset($circuitos);
						foreach($circuitos as $a => $b)
							{
							       $Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                                   $Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and id_muestra='$b' and cod_producto='41' "; 		
							       $Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
							       $Fila_fecha = mysqli_fetch_array($Respuesta_fecha);
								   //echo $Consulta_fecha;
				    		  echo "<td align='center'>$b&nbsp</td>\n";
							  reset($cod_leyes); 
							  foreach($cod_leyes as $c => $v)
								 {
    							    $Consulta_electrolitos="select  t2.valor as valor,t2.candado,t2.cod_unidad,t2.cod_leyes from cal_web.solicitud_analisis as t1 ";
									$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
									$Consulta_electrolitos=$Consulta_electrolitos."where t2.id_muestra='$b' and t2.cod_producto='41' and left(t1.fecha_muestra,10)='".$fecha."' and t2.cod_leyes='$v' and t2.candado='1'";
									$Consulta_electrolitos;
								    $Respuesta_electrolitos = mysqli_query($link, $Consulta_electrolitos);
									$Fila_electrolitos = mysqli_fetch_array($Respuesta_electrolitos);
									$valor = isset($Fila_electrolitos["valor"])?$Fila_electrolitos["valor"]:0;
									if ($valor <> 0)
									    {$total=number_format($Fila_electrolitos["valor"],"2","","");
										 if (($Fila_electrolitos["cod_unidad"]=='6') and ($Fila_electrolitos["cod_leyes"]=='27'))
										     {echo "<td align='center'>$total gr/lt&nbsp</td>\n";  }  
										 else { echo "<td align='center'>$total&nbsp</td>\n";}
										 }
									else{echo "<td align='center'>&nbsp</td>\n";}
								}
							    echo "</tr>\n";
							 }
						/****************************************************************************************************************************************/   						 
						 $HM=array('HM','H.M.','1HM','1-HM','H-M','HM.','-1HM');
						 reset($cod_leyes);
						 reset($HM);
						foreach($HM as $a => $b)
						 	{ 
							   //$Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                               //$Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and id_muestra='$b' and cod_producto='41' "; 		
							   //$Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
							   //$Fila_fecha = mysqli_fetch_array($Respuesta_fecha);
								$Consulta_hm="select  t2.id_muestra from cal_web.solicitud_analisis as t1 ";
								$Consulta_hm=$Consulta_hm."inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
								$Consulta_hm=$Consulta_hm."where t2.id_muestra='$b' and t2.cod_producto='41' and left(t1.fecha_muestra,10)='".$fecha."'";
								//echo $Consulta_hm;
								$Respuesta_hm = mysqli_query($link, $Consulta_hm);
								$Fila_hm = mysqli_fetch_array($Respuesta_hm);
								$id_muestra = isset($Fila_hm["id_muestra"])?$Fila_hm["id_muestra"]:"";
								if ($id_muestra==$b)
									{
										$idmuestra=$Fila_hm["id_muestra"];
										echo "<td align='center'>".$Fila_hm["id_muestra"]."&nbsp</td>\n";
										reset($cod_leyes);	
										 foreach($cod_leyes as $c => $v)
							   				{
								 				$Consulta_electrolitos="select  t1.valor as valor,t1.candado,t1.cod_unidad,t1.cod_leyes from cal_web.leyes_por_solicitud as t1 ";
												$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
												$Consulta_electrolitos=$Consulta_electrolitos."where t1.id_muestra='$idmuestra' and t1.cod_producto='41' and left(t2.fecha_muestra,10)='".$fecha."' and t1.cod_leyes='$v' and t1.candado='1'";
												$Respuesta_electrolitos = mysqli_query($link, $Consulta_electrolitos);
												$Fila_electrolitos = mysqli_fetch_array($Respuesta_electrolitos);
												if ($Fila_electrolitos["valor"] <> 0)
									    			{$total=number_format($Fila_electrolitos["valor"],"2","","");
										 			 if (($Fila_electrolitos["cod_unidad"]=='6') and ($Fila_electrolitos["cod_leyes"]=='27'))
										                {echo "<td align='center'>$total gr/lt&nbsp</td>\n";  }  
										             else { echo "<td align='center'>$total&nbsp</td>\n";}
										            }
												else{echo "<td align='center'>&nbsp</td>\n";}
											}
										echo "</tr>\n";
									}	
							}
							
						 							
						/*******************************************************************************************************************************************************/							
						 $e100=array('E-100','E100','TK-100');
						 reset($e100);
						 reset($cod_leyes);
						 foreach($e100 as $a => $b)
						 	{
								$Consulta_e="select  t2.id_muestra from cal_web.solicitud_analisis as t1 ";
								$Consulta_e=$Consulta_e."inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
								$Consulta_e=$Consulta_e."where t2.id_muestra='$b' and t2.cod_producto='41' and left(t1.fecha_muestra,10)='".$fecha."'";
								$Respuesta_e = mysqli_query($link, $Consulta_e);
								$Fila_e = mysqli_fetch_array($Respuesta_e);
								$id_muestra = isset($Fila_e["id_muestra"])?$Fila_e["id_muestra"]:"";
								if ($id_muestra<>"")
									{
										$idmuestra=$Fila_e["id_muestra"];
										echo "<td align='center'>".$Fila_e["id_muestra"]."&nbsp</td>\n";
    									reset($cod_leyes);	
										  foreach($cod_leyes as $c => $v)
							   				{
								 				$Consulta_v="select  t1.valor as valor,t1.candado from cal_web.leyes_por_solicitud as t1 ";
												$Consulta_v=$Consulta_v."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
												$Consulta_v=$Consulta_v."where t1.id_muestra='$idmuestra' and t1.cod_producto='41' and left(t2.fecha_muestra,10)='".$fecha."' and t1.cod_leyes='$v' and t1.candado='1'";
												$Respuesta_v = mysqli_query($link, $Consulta_v);
												$Fila_v = mysqli_fetch_array($Respuesta_v);
												if ($Fila_v["valor"] <> 0)
									    			{$total=number_format($Fila_v["valor"],"2","","");
										 		 	 echo "<td align='center'>$total&nbsp</td>\n";}
												else{echo "<td align='center'>&nbsp</td>\n";}
											}
										echo "</tr>\n";
									}	
							 }
						}
	?>
  
</table>
</table>




</form>
</body>
</html>
<?php
//para el lunes pegar las tablas individuales en excel?>
