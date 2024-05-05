<?php
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 1;
	include("../principal/conectar_ref_web.php");
	$fecha=ltrim($fecha);
    $ano1=substr($fecha,0,4);
	$mes1=substr($fecha,5,2);
	$dia1=substr($fecha,8,2);
	
?>
<html>
<head>
<script language="JavaScript">
function Tabla1(fecha)
{
	var  f=document.form1;
	var fecha=fecha;
    document.location = "../ref_web/tabla1.php?fecha="+fecha;
}
function Imprimir()
{
	window.print();
}
function detalle(fecha,grupo,turno)
{
	var Frm=document.form1;
	window.open("detalle_rechazos.php?fecha="+ fecha+"&grupo="+grupo+"&turno="+turno,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
}
function detalle_produccion(fecha,grupo)
{
	var Frm=document.form1;
	window.open("ref_detalle_produccion_cubas.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}
function detalle_anodos(fecha,grupo)
{
	var Frm=document.form1;
	window.open("Detalle_carga_anodos.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}


</script>
<LINK href="archivos/petalos.css" type=text/css rel=stylesheet>
<title>Sistema Informacion Refineria Electrolitica Electrolitica</title>
<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="form1">
	<table width="747" height="175" border="1"  align="center" cellpadding="2" cellspacing="0"  class="TablaPrincipal">
          <tr align="center"  class="ColorTabla01"> 
            <td colspan="15"><strong>1.-</strong> <strong>RENOVACION ELECTRODOS 
              GRUPOS Y PRODUCCION CATODOS COMERCIALES</strong></td>
          </tr>
          <tr> 
            <td width="65" align="center"><strong>CIRCUITO</strong></td>
            <td width="93" align="center"><strong>GRUPO</strong></td>
            <td width="72" align="center"><strong>TURNO</strong></td>
            <td width="95" align="center"><strong>PRODUCCION</strong></td>
            <td width="61" align="center"><p><strong>DESC.</strong></p>
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
            <td width="47" align="center"><strong>N�</strong></td>
            <td width="46" align="center"><strong>%</strong></td>
            <td width="45" align="center"><strong>N�</strong></td>
            <td width="18" align="center"><strong>%</strong></td>
            <td width="16" align="center"><strong>NE</strong></td>
            <td width="18" align="center"><strong>ND</strong></td>
            <td width="17" align="center"><strong>RA</strong></td>
            <td width="16" align="center"><strong>CL</strong></td>
            <td width="17" align="center"><strong>CS</strong></td>
            <td width="29" align="center"><strong>OT</strong></td>
          </tr>
<?php
   
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
			echo "<tr>\n";
			$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";
			$respuesta_turno= mysqli_query($link, $Consulta_turno);
			$row_turno = mysqli_fetch_array($respuesta_turno);
			echo "<td align='center'>".$Fila["cod_circuito"]."&nbsp;</td>\n";
			echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle('".$fecha."','".$Fila["cod_grupo"]."','".$row_turno[turno1]."')\">\n";
			echo $Fila["cod_grupo"]."</td>\n";
			/*echo "<td align='center'>".$Fila["cod_grupo"]."&nbsp</td>\n";*/
			echo "<td align='center'>".$row_turno[turno1]."&nbsp</td>\n";
			$consulta_produccion="select sum(peso_produccion) as produccion from sec_web.produccion_catodo ";
			$consulta_produccion=$consulta_produccion."where fecha_produccion = '".$fecha."' and cod_producto='18'  and cod_subproducto='1'   and cod_grupo = '".$Fila["cod_grupo"]."' group by cod_grupo";
			$Respuesta_produccion = mysqli_query($link, $consulta_produccion);
			$Fila_produccion = mysqli_fetch_array($Respuesta_produccion);
			$produccion=number_format($Fila_produccion["produccion"],"",",",".");
			echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_produccion('".$fecha."','".$Fila["cod_grupo"]."')\">\n";
			echo $produccion."</td>\n";
			//echo "<td align='right'>$produccion&nbsp</td>\n";
			$grupos[$i]=$Fila["cod_grupo"];
			if ($row_turno[turno1]=="")
			   { $turno[$i]='N';}
			else {$turno[$i]=$row_turno[turno1];}
			$i=$i+1;
/****************************************************************************************************************************************/
			$Consulta20="select fecha as fecha_fila from ref_web.grupo_electrolitico2 where cod_grupo='".$Fila["cod_grupo"]."' order by fecha asc";
			$respuesta20=mysqli_query($link, $Consulta20);
			$sw=0;
			while ($fila20=mysqli_fetch_array($respuesta20) and ($sw==0))
				{
					if ($fila20[fecha_fila] <= $fecha) 
						{$fecha_aux=$fila20[fecha_fila];}
				 else {$sw=1;}
				 }
		/****************************************************************************************************************************************/		
		    
			$Consulta = "select ifnull(cubas_descobrizacion,0) as cant_cuba, ifnull(num_cubas_tot,0) as num_cubas, ifnull(num_catodos_celdas,1) as num_catodos from ref_web.grupo_electrolitico2 ";
			$Consulta = $Consulta."where cod_grupo = '".$Fila["cod_grupo"]."' and  fecha = '$fecha_aux'";
			$rs1 = mysqli_query($link, $Consulta);
			$row1 = mysqli_fetch_array($rs1);
			echo "<td align='center'>".$row1[cant_cuba]."&nbsp</td>\n";
			$Consulta ="select ifnull(sum(unid_recup),0) as recuperado_tot, ifnull(sum(estampa),0) as ne, ifnull(sum(dispersos),0) as nd, ifnull(sum(rayado),0) as ra, ";
			$Consulta =$Consulta."ifnull(sum(cordon_superior),0) as cs, ifnull(sum(cordon_lateral),0) as cl, ifnull(sum(otros),0) as ot from cal_web.rechazo_catodos as t1 " ;
			$Consulta = $Consulta."where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";
			$Respuesta2 = mysqli_query($link, $Consulta);
			$Fila2 = mysqli_fetch_array($Respuesta2);
			$total_prod=$total_prod+$Fila_produccion["produccion"];
			$total_rec=$total_rec+$Fila2["recuperado_tot"];
			$total_cuba=$total_cuba+$row1["cant_cuba"];
			echo "<td align='center'>".$Fila2["recuperado_tot"]."&nbsp</td>\n";
			$divisor=$row1[num_cubas]-$row1[cant_cuba];
			$porc_rec=(($Fila2["recuperado_tot"]/($divisor*$row1["num_catodos"]))*100);
     		$porc_rec2=number_format($porc_rec,"2",",","");
			/*$porc_rec2=$porc_rec2/100;*/
			$total_rechaza=$total_rechaza+$porc_rec2;
			if ($porc_rec2 > 20)
			   {echo "<td align='center'><font color='green'><strong>$porc_rec2&nbsp</strong></font></td>\n";}
			 else {echo "<td align='center'>$porc_rec2&nbsp</td>\n";}  
			/*$total_rechaza=$total_rechaza+$porc_rec;*/
			$rechazado_tot_fila=$Fila2["ne"]+$Fila2["nd"]+$Fila2["ra"]+$Fila2["cl"]+$Fila2["cs"]+$Fila2["ot"];
			$total_rech=$total_rech+$rechazado_tot_fila;
			echo "<td align='center'>$rechazado_tot_fila&nbsp</td>\n";
			$divisor2=$row1[num_cubas]-$row1[cant_cuba];
			$total_por_rechazado=(($rechazado_tot_fila/($divisor2*$row1["num_catodos"]))*100);
			$total_por_rechazado2=number_format($total_por_rechazado,"2",",","");
			$sum_porc_rech=$sum_porc_rech+$total_por_rechazado;
			if ($total_por_rechazado > 3.2)
				{echo "<td align='center'><font color='red'><strong>$total_por_rechazado2&nbsp</strong></font></td>\n";}
			else {echo "<td align='center'>$total_por_rechazado2&nbsp</td>\n";}	
			echo "<td>".$Fila2["ne"]."&nbsp</td>\n";
			$total_ne=$total_ne+$Fila2["ne"];
			echo "<td align='center'>".$Fila2["nd"]."&nbsp</td>\n";
			$total_nd=$total_nd+$Fila2["nd"];
			echo "<td align='center'>".$Fila2["ra"]."&nbsp</td>\n";
			$total_ra=$total_ra+$Fila2["ra"];
			echo "<td align='center'>".$Fila2["cl"]."&nbsp</td>\n";
			$total_cl=$total_cl+$Fila2["cl"];
			echo "<td align='center'>".$Fila2["cs"]."&nbsp</td>\n";
			$total_cs=$total_cs+$Fila2["cs"];
			echo "<td align='center'>".$Fila2["ot"]."&nbsp</td>\n";
			$total_ot=$total_ot+$Fila2["ot"];		
			echo "</tr>\n";
       }
$total_prod2=number_format($total_prod,"",".",".");
echo "<td align='right'><strong>TOTAL</strong></td>\n";
echo "<td align='center'>--</td>\n";
echo "<td align='center'>--</td>\n";	   
echo "<td align='right'><font color='blue'>$total_prod2&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_cuba &nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_rec</font></td>\n";
if ($cont==0)
    {$cont=1;}
$total_rechaza=($total_rechaza/$cont);
$porc_rechaza2=number_format($total_rechaza,"2",",","");
echo "<td align='center'><font color='blue'>$porc_rechaza2&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_rech&nbsp</font></td>\n";
$sum_porc_rech=($sum_porc_rech/$cont);
$sum_porc_rech2=number_format($sum_porc_rech,"2",",","");
echo "<td align='center'><font color='blue'>$sum_porc_rech2&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_ne&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_nd&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_ra&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_cl&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_cs&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_ot&nbsp</font></td>\n";
?>
          <tr align="center"> 
            <td height="59" colspan="15">
<p>

 <p>
     <input type="button" name="btnexcel34" value="Excel Tabla 1" style="width:80" onClick="Tabla1('<?php echo $fecha ?>')" title="Excel de tabla de Produccion de Catodos Comerciales">
 </p>
 
 </table>
</form>
</body>
</html>

