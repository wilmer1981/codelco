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
		 <table width="800" height="175" border="1"  align="center" cellpadding="2" cellspacing="0">
          <tr align="center"  class="ColorTabla01"> 
            <td colspan="21"><strong>1.-</strong> <strong>RENOVACION ELECTRODOS 
              GRUPOS Y PRODUCCION CATODOS COMERCIALES</strong></td>
          </tr>
          <tr> 
		  <td width="40" align="center"><strong>CIRCUITO</strong></td>
            <td width="70" align="center"><strong>GRUPO</strong></td>
            <td width="40" align="center"><strong>TURNO</strong></td>
			<td width="50" align="center"><p><strong>PESO</strong></p>
            	<p><strong>PRODUCCION</strong></p></td>
			<td width="50" align="center"><p><strong>PESO</strong></p>
            	<p><strong>ANODOS</strong></p></td>
			<td width="50" align="center"><p><strong>PESO</strong></p>
				<p><strong>SCRAP</strong></p></td>
			<td width="30" align="center"><p><strong>%</strong></p>
				<p><strong>SCRAP</strong></p></td>
		    <td width="50" align="center"><p><strong>DESC.</strong></p>
              	<p><strong>NORMAL</strong></p></td>
            <td colspan="2" align="center"><strong>RECUPERADO</strong></td>
            <td colspan="2" align="center"><strong>ESTANDAR</strong></td>
            <td colspan="9" align="center"><strong>DETALLE ESTANDAR</strong></td>
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
			<td width="47" align="center"><strong>N�</strong></td>
            <td width="46" align="center"><strong>%</strong></td>
            <td width="45" align="center"><strong>N�</strong></td>
            <td width="18" align="center"><strong>%</strong></td>
            <td width="16" align="center"><strong>NE</strong></td>
            <td width="18" align="center"><strong>ND</strong></td>
            <td width="17" align="center"><strong>RA</strong></td>
            <td width="16" align="center"><strong>CL</strong></td>
            <td width="17" align="center"><strong>CS</strong></td>
            <td width="17" align="center"><strong>QU</strong></td>
            <td width="17" align="center"><strong>RE</strong></td>
            <td width="17" align="center"><strong>AI</strong></td>
            <td width="5" align="center"><strong>OT</strong></td>
          </tr>
<?php
   /* if ($Sig=='S')
	  { $dia1=strval(intval($dia1+1));
	     if ($dia1=='31')
	        {  $mes1=strval(intval($mes+1));
		       $dia1='1';} 
	     if  ($mes=='12')
	         { $ano1=strval(intval($ano1+1));
		       $mes1='1';
			   $dia1='1';}      
	   }
    if ($Ant=='S')
	   {$dia1=strval(intval($dia1-1));} 
	if (strlen($dia1) == 1)
		{$dia1 = '0'.$dia1;}
	if (strlen($mes1) ==1) 
  		{$mes1 = '0'.$mes1;}
	$fecha=$ano1."-".$mes1."-".$dia1;*/
	if (strlen($dia1) == 1)
	{
		$dia1 = '0'.$dia1;
	}
	if (strlen($mes1) ==1) 
  	{
		$mes1 = '0'.$mes1;
	}
	$fecha=$ano1.'-'.$mes1.'-'.$dia1;

	$FechaInicio =date("Y-m-d", mktime(0,0,0,$mes1,$dia1 ,$ano1));	
	$Fechainiturno =$FechaInicio;
	$Fechafturno = date("Y-m-d", mktime(0,0,0,intval(substr($Fechainiturno, 5, 2)) ,intval(substr($Fechainiturno, 8, 2)) + 1,intval(substr($Fechainiturno, 0, 4))));

	
	$Consulta =  "select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito,t1.fecha_produccion as fechaprod,t1.hora as horita from sec_web.produccion_catodo as t1 ";
	$Consulta = $Consulta." inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
	$Consulta.= " where CONCAT(t1.fecha_produccion,' ',t1.hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
	$Consulta = $Consulta." and t1.cod_producto='18'  and t1.cod_subproducto='1' group by t1.cod_grupo order by t1.fecha_produccion,t1.hora";

	
	//$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_producto='18'  and t1.cod_subproducto='1'   and t2.fecha <= '".$fecha."'group by t1.cod_grupo";
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
	
	$total_rechaza=0;//WSO
	$sum_porc_rech=0;
	$total_ne=0;
	$total_nd=0;
    $total_ra=0;
	$total_cl=0;
	$total_cs=0;
	$total_qu=0;
	$total_re=0;
	$total_ai=0;
	$total_ot=0; //WSO
	while ($Fila = mysqli_fetch_array($Respuesta))
	  {
	        $cont=$cont+1;
			echo "<tr>\n";
			
			if ($Fila["fechaprod"]== $Fechainiturno && $Fila["horita"] >= '08:00:00' && $Fila["horita"] < '16:00:00')
			{
				$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$Fila["fechaprod"]."' and t1.turno ='A' and t1.grupo = '".$Fila["cod_grupo"]."'";
				//echo "conb".$Consulta_turno;
				$respuesta_turno= mysqli_query($link, $Consulta_turno);
				$row_turno = mysqli_fetch_array($respuesta_turno);
				$turno1 = isset($row_turno["turno1"])?$row_turno["turno1"]:"";
				if ($turno1== '')
					$row_turno["turno1"] = 'A';
			}	
			if ($Fila["fechaprod"]== $Fechainiturno and $Fila["horita"] >= '16:00:00')
			{
				$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$Fila["fechaprod"]."' and t1.turno ='B' and t1.grupo = '".$Fila["cod_grupo"]."'";
				$respuesta_turno= mysqli_query($link, $Consulta_turno);
				$row_turno = mysqli_fetch_array($respuesta_turno);
				$turno1 = isset($row_turno["turno1"])?$row_turno["turno1"]:"";
				if ($turno1== '')
					$row_turno["turno1"] = 'B';
			}
			if ($Fila["fechaprod"]== $Fechafturno)
			{
				$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$Fila["fechaprod"]."' and t1.turno ='C' and t1.grupo = '".$Fila["cod_grupo"]."'";
				$respuesta_turno= mysqli_query($link, $Consulta_turno);
				$row_turno = mysqli_fetch_array($respuesta_turno);
				$turno1 = isset($row_turno["turno1"])?$row_turno["turno1"]:"";
				if ($turno1== '')
					$row_turno["turno1"] = 'C';

			}			
			
			/*$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";
			$respuesta_turno= mysqli_query($link, $Consulta_turno);
			$row_turno = mysqli_fetch_array($respuesta_turno);*/
			echo "<td align='center'>".$Fila["cod_circuito"]."&nbsp;</td>\n";
			echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle('".$fecha."','".$Fila["cod_grupo"]."','".$row_turno["turno1"]."')\">\n";
				//aqui sacar dias de renovacion  del grupo  poly 2005-01-31
			$j=0;
			$anomes=substr($fecha,0,8);
			$fechita=$anomes.'01';
		
			$con="select dia_renovacion as dia_renovacion from  sec_web.renovacion_prog_prod";
			$con.=" where cod_grupo = '".$Fila["cod_grupo"]."' and cod_concepto = '".$row_turno["turno1"]."'";
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
			echo $Fila["cod_grupo"]."-".$diacambio." ".$var."</td>\n";
			echo "<td align='center'>".$turno1."&nbsp</td>\n";
			$consulta_produccion="select sum(peso_produccion) as produccion from sec_web.produccion_catodo ";
			$consulta_produccion.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
			$consulta_produccion=$consulta_produccion." and cod_producto='18'  and cod_subproducto='1'   and cod_grupo = '".$Fila["cod_grupo"]."' group by cod_grupo";

			
			//$consulta_produccion=$consulta_produccion."where fecha_produccion = '".$fecha."' and cod_producto='18'  and cod_subproducto='1'   and cod_grupo = '".$Fila["cod_grupo"]."' group by cod_grupo";
			$Respuesta_produccion = mysqli_query($link, $consulta_produccion);
			$Fila_produccion = mysqli_fetch_array($Respuesta_produccion);
			$produccion=number_format($Fila_produccion["produccion"],2,",",".");

			echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_produccion('".$fecha."','".$Fila["cod_grupo"]."')\">\n";
			echo $produccion."</td>\n";
			//aqui saca los grupos en un arreglo igual lo tengo que hacer yo
		
			$grupos[$i]=$Fila["cod_grupo"];
			if ($row_turno["turno1"]=="")
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
			$consultap.=" and CONCAT(fecha_movimiento,' ',hora) between  '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59' and cod_producto != '19' and campo2 = '".$grup."' group by campo2";

			//$consultap.=" and fecha_movimiento = '".$fecha."' and cod_producto != '19' and campo2 = '".$grup."' group by campo2";
			//echo "con".$consultap;
			$pj=mysqli_query($link, $consultap);
			$ppj=mysqli_fetch_array($pj);	
			$peso_anodos = isset($ppj["peso_anodos"])?$ppj["peso_anodos"]:0;
			$p1=number_format($peso_anodos,2,".","");
			
			//saca peso del produccin del resto de ese frupo	
			$consultaj="select campo2,sum(peso) as peso,sum(unidades) as unidades from sea_web.movimientos where tipo_movimiento = '3'";
			$consultaj.=" and CONCAT(fecha_movimiento,' ',hora) between '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59' and campo2 ='".$grup."' group by campo2";

			//$consultaj.=" and fecha_movimiento = '".$fecha."' and campo2 ='".$grup."' group by campo2";
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
			
			
			echo "<td align='center'>$peso_anodos&nbsp;</td>\n";
			
			echo"<td align='center'>$pp&nbsp;</td>\n";
 			echo"<td align='center'>$scrap&nbsp;</td>\n";
			$Consulta = "select ifnull(cubas_descobrizacion,0) as cant_cuba, ifnull(num_cubas_tot,0) as num_cubas, ifnull(num_catodos_celdas,1) as num_catodos from ref_web.grupo_electrolitico2 ";
			$Consulta = $Consulta."where cod_grupo = '".$Fila["cod_grupo"]."' and  fecha = '$fecha_aux'";
			$rs1 = mysqli_query($link, $Consulta);
			$row1 = mysqli_fetch_array($rs1);
			echo "<td align='center'>".$row1["cant_cuba"]."&nbsp</td>\n";
			$Consulta ="select ifnull(sum(unid_recup),0) as recuperado_tot, ifnull(sum(estampa),0) as ne, ifnull(sum(dispersos),0) as nd, ifnull(sum(rayado),0) as ra, ";
			$Consulta =$Consulta."ifnull(sum(cordon_superior),0) as cs, ifnull(sum(cordon_lateral),0) as cl, ifnull(sum(quemados),0) as qu,ifnull(sum(redondos),0) as re,";
			$Consulta.=" ifnull(sum(aire),0) as ai,ifnull(sum(otros),0) as ot from cal_web.rechazo_catodos as t1 " ;
			$Consulta = $Consulta."where t1.fecha between '".$Fechainiturno."' and '".$Fechafturno."' and t1.grupo = '".$Fila["cod_grupo"]."'";

			//$Consulta = $Consulta."where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";
			$Respuesta2 = mysqli_query($link, $Consulta);
			$Fila2 = mysqli_fetch_array($Respuesta2);
			$total_prod=$total_prod+$Fila_produccion["produccion"];
			$total_scrap=$total_scrap+$p;
			
			$total_peso_anodos = $total_peso_anodos +$p1;
			
			$total_rec=$total_rec+$Fila2["recuperado_tot"];
			$total_cuba=$total_cuba+$row1["cant_cuba"];
			echo "<td align='center'>".$Fila2["recuperado_tot"]."&nbsp</td>\n";
			$divisor=$row1["num_cubas"]-$row1["cant_cuba"];
			$porc_rec=(($Fila2["recuperado_tot"]/($divisor*$row1["num_catodos"]))*100);
     		$porc_rec2=number_format($porc_rec,"2",".","");

			$total_rechaza=$total_rechaza+$porc_rec2;
			if ($porc_rec2 > 20)
			   {echo "<td align='center'><font color='green'><strong>$porc_rec2&nbsp</strong></font></td>\n";}
			 else {echo "<td align='center'>$porc_rec2&nbsp</td>\n";}  
		
			$rechazado_tot_fila=$Fila2["ne"]+$Fila2["nd"]+$Fila2["ra"]+$Fila2["cl"]+$Fila2["cs"]+$Fila2["ot"];
			$rechazado_tot_fila=$rechazado_tot_fila + $Fila2["qu"] + $Fila2["re"] + $Fila2["ai"];
			$total_rech=$total_rech+$rechazado_tot_fila;
			echo "<td align='center'>$rechazado_tot_fila&nbsp</td>\n";
			$divisor2=$row1["num_cubas"]-$row1["cant_cuba"];
			$total_por_rechazado=(($rechazado_tot_fila/($divisor2*$row1["num_catodos"]))*100);
			$total_por_rechazado2=number_format($total_por_rechazado,"2",".","");
			$sum_porc_rech=$sum_porc_rech+$total_por_rechazado;
			if ($total_por_rechazado > 3.2)
				{echo "<td align='center'><font color='red'><strong>$total_por_rechazado2&nbsp</strong></font></td>\n";}
			else {echo "<td align='center'>$total_por_rechazado2&nbsp</td>\n";}	
			echo "<td align='center'>".$Fila2["ne"]."&nbsp</td>\n";
			$total_ne=$total_ne+$Fila2["ne"];
			echo "<td align='center'>".$Fila2["nd"]."&nbsp</td>\n";
			$total_nd=$total_nd+$Fila2["nd"];
			echo "<td align='center'>".$Fila2["ra"]."&nbsp</td>\n";
			$total_ra=$total_ra+$Fila2["ra"];
			echo "<td align='center'>".$Fila2["cl"]."&nbsp</td>\n";
			$total_cl=$total_cl+$Fila2["cl"];
			echo "<td align='center'>".$Fila2["cs"]."&nbsp</td>\n";
			$total_cs=$total_cs+$Fila2["cs"];
			echo "<td align='center'>".$Fila2["qu"]."&nbsp</td>\n";
			$total_qu=$total_qu+$Fila2["qu"];
			echo "<td align='center'>".$Fila2["re"]."&nbsp</td>\n";
			$total_re=$total_re+$Fila2["re"];
			echo "<td align='center'>".$Fila2["ai"]."&nbsp</td>\n";
			$total_ai=$total_ai+$Fila2["ai"];
			echo "<td align='center'>".$Fila2["ot"]."&nbsp</td>\n";
			$total_ot=$total_ot+$Fila2["ot"];		
			echo "</tr>\n";
       }
	  
	  
$total_prod2=number_format($total_prod,"2",".",".");
$total_porcentaje_scrap=0;
if ($total_scrap != 0)
{
	$total_por_scrap =($total_scrap/$total_peso_anodos)*100;
	$total_porcentaje_scrap =number_format($total_por_scrap,"2",".","");
}	
$total_anodos2=number_format($total_peso_anodos,"2",",",".");
$total_scrap2=number_format($total_scrap,"2",",",".");
echo "<td align='right'><strong>TOTAL</strong></td>\n";
echo "<td align='center'>--</td>\n";
echo "<td align='center'>--</td>\n";	   
echo "<td align='center'><font color='blue'>$total_prod2&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_anodos2&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_scrap2&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_porcentaje_scrap&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_cuba &nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_rec</font></td>\n";
if ($cont==0)
    {$cont=1;}
	
//echo $total_rechaza;
$total_rechaza=($total_rechaza/$cont);
//echo $total_rechaza.'=('.$total_rechaza.'/'.$cont.')';
$porc_rechaza2=number_format($total_rechaza,"2",".","");
echo "<td align='center'><font color='blue'>$porc_rechaza2&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_rech&nbsp</font></td>\n";

//echo $porc_rechaza2;
$sum_porc_rech=($sum_porc_rech/$cont);
$sum_porc_rech2=number_format($sum_porc_rech,"2",".","");
echo "<td align='center'><font color='blue'>$sum_porc_rech2&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_ne&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_nd&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_ra&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_cl&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_cs&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_qu&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_re&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_ai&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_ot&nbsp</font></td>\n";
//hasta aqui copio lo de consulta produccion
?>

</form>
</body>
</html>
