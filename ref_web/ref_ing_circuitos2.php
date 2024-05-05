<?php
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 1;
	include("../principal/conectar_ref_web.php");
	include("funciones_administrador.php");
	//fecha = "2004-11-08";
		if (strlen($dia1) == 1)
		{$dia1 = '0'.$dia1;}
	if (strlen($mes1) ==1) 
  		{$mes1 = '0'.$mes1;}

	$fecha=$ano1.'-'.$mes1.'-'.$dia1;
	//echo "poly ".$fecha;
	if ($siguiente=='S')
      {
       $fecha=aumentar_dias($fecha,1);
	   $mes1=substr($fecha,5,2);
	   $ano1=substr($fecha,0,4);
	   $dia1=substr($fecha,8,2);
	  }
    if ($anterior=='S')
     {
      $fecha=restar_dias($fecha,1);
	  $mes1=substr($fecha,5,2);
	  $ano1=substr($fecha,0,4);
	  $dia1=substr($fecha,8,2);
	 }
	
	
?>
<html>
<head>
<script language="JavaScript">
function Buscar()
{
	var  f=document.form1;

	f.action='ref_ing_circuitos2.php?mostrar=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Buscarant()
{
	var  f=document.form1;

	f.action='ref_ing_circuitos2.php?mostrar=S&anterior=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Buscarsig()
{
	var  f=document.form1;

	f.action='ref_ing_circuitos2.php?mostrar=S&siguiente=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}
function Excel()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	
	var ano1=f.ano1.value;
	var mes1=f.mes1.value;
	var dia1=f.dia1.value;


	document.location = "../ref_web/ref_web_xls.php?fecha="+fecha+"&ano="+ano1+"&mes="+mes1+"&dia="+dia1;
}
function Tabla1()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano1=f.ano1.value;
	var mes1=f.mes1.value;
	var dia1=f.dia1.value;
	
	document.location = "../ref_web/tabla1.php?fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1+"&dia1="+dia1;


}
function Tabla2()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano1=f.ano1.value;
	var mes1=f.mes1.value;
	var dia1=f.dia1.value;
	
	document.location = "../ref_web/tabla2.php?fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1+"&dia1="+dia1;

}
function Tabla3()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano1=f.ano1.value;
	var mes1=f.mes1.value;
	var dia1=f.dia1.value;

	document.location = "../ref_web/tabla3.php?fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1+"&dia1="+dia1;

}
function Tabla4()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano1=f.ano1.value;
	var mes1=f.mes1.value;
	var dia1=f.dia1.value;
	
	document.location = "../ref_web/tabla4.php?fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1+"&dia1="+dia1;
}
function Tabla5()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano1=f.ano1.value;
	var mes1=f.mes1.value;
	var dia1=f.dia1.value;
	document.location = "../ref_web/tabla5.php?fecha="+fecha+"&ano1="+ano1+"&mes1="+mes1+"&dia1="+dia1;
}

function Tabla6()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;


	document.location = "../ref_web/Tabla6.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
}


function Grafico()
{
    var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	var URL ="../ref_web/ejemplo_grafico.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=770 height=550 scrollbars=no");
}
function Grafico2()
{
    var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	var URL ="../ref_web/Grafico2.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=770 height=550 scrollbars=no");
}
function Grafico3()
{
    var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	var URL ="../ref_web/Grafico3.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=770 height=550 scrollbars=no");

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

 <table class="TablaPrincipal" width="772" border="0" cellpadding="5" cellspacing="0" >
 <tr>
 <td width="760" align="center" valign="middle">
          <?php
		  /*<table width="750" border="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td width="168"><input name="buscar2" type="button" value="&lt;&lt; Anterior" onClick="Buscarant('<?php echo $fecha;?>')" > 
            </td>
            <td width="95"> <strong>Informe del: </strong></td>
            <td width="322"> <select name="dia1" size="1" >
                <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{   
					    if (($mostrar == "S") && ($i == $dia1))
						   {  if (($mostrar == "S") && ($Sig == "S"))
						         { 
								   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
								   $i=$i+1;
								   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
							     }
							  else if  (($mostrar == "S") && ($Ant == "S"))
							          {
									   $i=$i-1;
									   echo '<option selected value="'.$i.'">'.$i.'</option>'; 
									   $i=$i+1;
									   
									  }
								 
								 
							       else echo '<option selected value="'.$i.'">'.$i.'</option>';
					       }  
						else if (($i == date("j")) and ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
							
					}
				?>
              </select> <select name="mes1" size="1" id="mes1">
                <?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes1))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else if (($i == date("n")) && ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';
					}
				?>
              </select> <select name="ano1" size="1" id="select4">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($mostrar == "S") && ($i == $ano1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("Y")) && ($mostrar != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select> &nbsp;&nbsp; <input name="buscar" type="button" value="buscar" onClick="Buscar()" > 
            </td>
            <td width="128"> 
              <input name="buscar22" type="button" value="Siguiente &gt;&gt;" onClick="Buscarsig('<?php echo $fecha;?>')" ></td>
          </tr>
        </table>
		*/?>
				<?php 
		//$fecha=$ano1."-".$mes1."-".$dia1;
			if (strlen($dia1) == 1)
			{
				$dia1 = '0'.$dia1;
			}
			if (strlen($mes1) ==1) 
  			{
				$mes1 = '0'.$mes1;
			}
			$fecha=$ano1."-".$mes1."-".$dia1;

			$fecha_poly=date("d-m-Y");
			$dia_poly =substr($fecha_poly,0,2);
			$mes_poly =substr($fecha_poly,3,2);
			$year_poly =substr($fecha_poly,6,4);
			$cheq_fecha=$year_poly."-".$mes_poly."-".$dia_poly;
				
		?>
	<TABLE cellSpacing=0 cellPadding=0 width="750" border=0>
  	<TBODY>
    <TR vAlign=bottom> 
       <TD>
  </TBODY>
<!-- COMIENZO PRIMERA TABLA -->
		 <table width="750" height="175" border="1"  align="center" cellpadding="2" cellspacing="0">
          <tr align="center"  class="ColorTabla01"> 
            <td colspan="18"><strong>1.-</strong> <strong>RENOVACION ELECTRODOS 
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
			<td width="47" align="center"><strong>N�</strong></td>
            <td width="46" align="center"><strong>%</strong></td>
            <td width="45" align="center"><strong>N�</strong></td>
            <td width="18" align="center"><strong>%</strong></td>
            <td width="16" align="center"><strong>NE</strong></td>
            <td width="18" align="center"><strong>ND</strong></td>
            <td width="17" align="center"><strong>RA</strong></td>
            <td width="16" align="center"><strong>CL</strong></td>
            <td width="17" align="center"><strong>CS</strong></td>
            <td width="5" align="center"><strong>OT</strong></td>
          </tr>
<?php
    if ($Sig=='S')
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
	$fecha=$ano1."-".$mes1."-".$dia1;
	
	$Consulta =  "select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito from sec_web.produccion_catodo as t1 ";
	$Consulta = $Consulta." inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
	$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_producto='18'  and t1.cod_subproducto='1'   and t2.fecha <= '".$fecha."'group by t1.cod_grupo";
	//echo $Consulta;
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
	
	while ($Fila = mysqli_fetch_array($Respuesta))
	  {
	        $cont=$cont+1;
			echo "<tr>\n";
			$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";

			$respuesta_turno= mysqli_query($link, $Consulta_turno);
			$row_turno = mysqli_fetch_array($respuesta_turno);
			echo "<td align='center'>".$Fila["cod_circuito"]."&nbsp;</td>\n";
			echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle('".$fecha."','".$Fila["cod_grupo"]."','".$row_turno[turno1]."')\">\n";
				//aqui sacar dias de renovacion  del grupo  poly 2005-01-31
			$j=0;
			$anomes=substr($fecha,0,8);
			$fechita=$anomes.'01';
		
			$con="select dia_renovacion as dia_renovacion from  sec_web.renovacion_prog_prod";
			$con.=" where cod_grupo = '".$Fila["cod_grupo"]."' and cod_concepto = '".$row_turno[turno1]."'";
			$con.=" and fecha_renovacion ='".$fechita."'"; 
			//echo $con;
			$Respuestap = mysqli_query($link, $con);
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
			echo "<td align='center'>".$row_turno[turno1]."&nbsp</td>\n";
			$consulta_produccion="select sum(peso_produccion) as produccion from sec_web.produccion_catodo ";
			$consulta_produccion=$consulta_produccion."where fecha_produccion = '".$fecha."' and cod_producto='18'  and cod_subproducto='1'   and cod_grupo = '".$Fila["cod_grupo"]."' group by cod_grupo";
			//echo "PRO".$consulta_produccion;
			$Respuesta_produccion = mysqli_query($link, $consulta_produccion);
			$Fila_produccion = mysqli_fetch_array($Respuesta_produccion);
			$produccion=number_format($Fila_produccion["produccion"],"",",",".");

			echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_produccion('".$fecha."','".$Fila["cod_grupo"]."')\">\n";
			echo $produccion."</td>\n";
			//aqui saca los grupos en un arreglo igual lo tengo que hacer yo
		
			$grupos[$i]=$Fila["cod_grupo"];
			if ($row_turno[turno1]=="")
			{ 
			 	$turno[$i]='N';
			}
			else
			{
				$turno[$i]=$row_turno[turno1];
			}
			$i=$i+1;
/****************************************************************************************************************************************/
			$Consulta20="select fecha as fecha_fila from ref_web.grupo_electrolitico2 where cod_grupo='".$Fila["cod_grupo"]."' order by fecha asc";
			//echo $Consulta20;
			$respuesta20=mysqli_query($link, $Consulta20);
			$sw=0;
			$total_por_scrap=0;
			
			while ($fila20=mysqli_fetch_array($respuesta20) and ($sw==0))
			{
				if ($fila20[fecha_fila] <= $fecha) 
				{
					$fecha_aux=$fila20[fecha_fila];
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
			$p1=number_format($ppj["peso_anodos"],2,".","");
			
			//saca peso del produccin del resto de ese frupo	
			$consultaj="select campo2,sum(peso) as peso,sum(unidades) as unidades from sea_web.movimientos where tipo_movimiento = '3'";
			$consultaj.=" and fecha_movimiento = '".$fecha."' and campo2 ='".$grup."' group by campo2";
			$rp=mysqli_query($link, $consultaj);
			$rpp=mysqli_fetch_array($rp); 
			$scrap=0;
			$p=0;
			$pp=0;
			$p=number_format($rpp["peso"],2,".","");
			if ($p1 != 0)
			{
				$scrap = ($p/$p1) * 100;
			}	
			$scrap=number_format($scrap,2,",",".");
			$pp=number_format($p,"",",",".");
			$peso_anodos=number_format($p1,"",",",".");
			
			
			echo "<td align='center'>$peso_anodos&nbsp;</td>\n";
			
			echo"<td align='center'>$pp&nbsp;</td>\n";
 			echo"<td align='center'>$scrap&nbsp;</td>\n";
			$Consulta = "select ifnull(cubas_descobrizacion,0) as cant_cuba, ifnull(num_cubas_tot,0) as num_cubas, ifnull(num_catodos_celdas,1) as num_catodos from ref_web.grupo_electrolitico2 ";
			$Consulta = $Consulta."where cod_grupo = '".$Fila["cod_grupo"]."' and  fecha = '$fecha_aux'";
			$rs1 = mysqli_query($link, $Consulta);
			//echo $Consulta;
			$row1 = mysqli_fetch_array($rs1);
			echo "<td align='center'>".$row1[cant_cuba]."&nbsp</td>\n";
			$Consulta ="select ifnull(sum(unid_recup),0) as recuperado_tot, ifnull(sum(estampa),0) as ne, ifnull(sum(dispersos),0) as nd, ifnull(sum(rayado),0) as ra, ";
			$Consulta =$Consulta."ifnull(sum(cordon_superior),0) as cs, ifnull(sum(cordon_lateral),0) as cl, ifnull(sum(otros),0) as ot from cal_web.rechazo_catodos as t1 " ;
			$Consulta = $Consulta."where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";
			//echo $Consulta;
			$Respuesta2 = mysqli_query($link, $Consulta);
			$Fila2 = mysqli_fetch_array($Respuesta2);
			$total_prod=$total_prod+$Fila_produccion["produccion"];
			$total_scrap=$total_scrap+$p;
			
			$total_peso_anodos = $total_peso_anodos +$p1;
			
			$total_rec=$total_rec+$Fila2["recuperado_tot"];
			$total_cuba=$total_cuba+$row1["cant_cuba"];
			echo "<td align='center'>".$Fila2["recuperado_tot"]."&nbsp</td>\n";
			
			$divisor=$row1[num_cubas]-$row1[cant_cuba];
			$porc_rec=(($Fila2["recuperado_tot"]/($divisor*$row1["num_catodos"]))*100);
     		$porc_rec2=number_format($porc_rec,"2",".","");

			$total_rechaza=$total_rechaza+$porc_rec2;
			if ($porc_rec2 > 20)
			   {echo "<td align='center'><font color='green'><strong>$porc_rec2&nbsp</strong></font></td>\n";}
			 else {echo "<td align='center'>$porc_rec2&nbsp</td>\n";}  

			$rechazado_tot_fila=$Fila2["ne"]+$Fila2["nd"]+$Fila2["ra"]+$Fila2["cl"]+$Fila2["cs"]+$Fila2["ot"];
			$total_rech=$total_rech+$rechazado_tot_fila;
			echo "<td align='center'>$rechazado_tot_fila&nbsp</td>\n";
			$divisor2=$row1[num_cubas]-$row1[cant_cuba];
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
			echo "<td align='center'>".$Fila2["ot"]."&nbsp</td>\n";
			$total_ot=$total_ot+$Fila2["ot"];		
			echo "</tr>\n";
       }
	  
	  
$total_prod2=number_format($total_prod,"",".",".");
if ($total_scrap != 0)
{
	$total_por_scrap =($total_scrap/$total_peso_anodos)*100;
	$total_porcentaje_scrap =number_format($total_por_scrap,"2",".","");
}	
$total_anodos2=number_format($total_peso_anodos,"",",",".");
$total_scrap2=number_format($total_scrap,"",",",".");
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
echo "<td align='center'><font color='blue'>$total_ot&nbsp</font></td>\n";
//hasta aqui copio lo de consulta produccion
?>
	<tr align="center"> 
    <td height="59" colspan="18">
		<p>
		<p>
			<input type="button" name="btnexcel34" value="Excel Tabla 1" style="width:80" onClick="Tabla1()" title="Excel de tabla de Produccion de Catodos Comerciales">
		</p>
		<table width="80%" height="92" border="1">
    		<tr align="center"  class="ColorTabla01"> 
    			<td height="18" colspan="17"><strong>2.-PRODUCCION AREA DE HOJAS MADRES</strong></td>
            </tr>
            <tr> 
            	<td width="15%" rowspan="2" align="center"><strong>GRUPO</strong></td>
                <td width="1%" rowspan="2" align="center"><strong>PRODUCCION</strong></td>
                <td colspan="5" align="center"><strong>RECHAZO</strong></td>
                <td colspan="2" align="center"><strong>RECUPERADO</strong></td>
           	</tr>
            <tr> 
            	<td width="7%" align="center"><strong>DELGADAS</strong></td>
                <td width="7%" align="center"><strong>GRANULADAS</strong></td>
                <td width="7%" align="center"><strong>GRUESAS</strong></td>
                <td width="7%" align="center"><strong>TOTAL</strong></td>
                <td width="7%" align="center"><strong>%</strong></td>
                <td width="7%" align="center"><strong>TOTAL</strong></td>
                <td width="7%" align="center"><strong>%</strong></td>
         	</tr>
	<?php
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
				$produccion=(($row3["hojas_madres"]*$row3[num_catodos_celdas])*2);         
				echo "<td align='center'>$produccion&nbsp</td>\n";
				$Consulta5 = "select cod_grupo,ifnull(rechazo_delgadas,0) as rec_del,ifnull(rechazo_granuladas,0) as rec_gran,ifnull(rechazo_gruesas,0) as rec_grue from ref_web.produccion as t1 ";
				$Consulta5 = $Consulta5."inner join proyecto_modernizacion.sub_clase as t2  on t1.cod_grupo=t2.valor_subclase1 ";
				$Consulta5 = $Consulta5."where t1.fecha = '".$fecha."' and t1.cod_grupo = t2.valor_subclase1 and t1.cod_grupo= '".$row2[sub_clase1]."' group by t1.cod_grupo";
				//echo $Consulta5;
       			$rs12 = mysqli_query($link, $Consulta5);
				$row12 = mysqli_fetch_array($rs12);
				echo "<td align='center'>".$row12[rec_del]."&nbsp</td>\n";
				echo "<td align='center'>".$row12[rec_gran]."&nbsp</td>\n";
				echo "<td align='center'>".$row12[rec_grue]."&nbsp</td>\n";
				$total=$row12[rec_del]+$row12[rec_gran]+$row12[rec_grue];
				$total_unidades=$total_unidades+$produccion;
				$total_del=$total_del+$row12[rec_del];
		    	$total_gran=$total_gran+$row12[rec_gran];
		    	$total_grue=$total_grue+$row12[rec_grue];
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
			};
				$porc_tot_rech=number_format($porc_tot_rech,"2",",","");
				echo "<td align='center'><font color='blue'>$porc_tot_rech&nbsp</font></td>\n";
				echo "<td align='center'><font color='blue'>".$row13[recuperado]."&nbsp</font></td>\n";
			if (($total_unidades==0) or ($total2==0))
			{
				$porc_tot_rec=0;
			}
			else
			{
				$porc_tot_rec=(($row13[recuperado]/$total_unidades)*100);
			}
			$porc_tot_rec=number_format($porc_tot_rec,"2",".","");
			echo "<td align='center'><font color='blue'>$porc_tot_rec&nbsp</font></td>\n";
		}
	?>
            </table>
			  <p> 
                <input type="button" name="btnexcel323" value="Excel Tabla 2" style="width:80" onClick="Tabla2()" title="Excel de Tabla Produccion de Area Hojas Madres">
              </p>			  

<!-- FINAL segunda TABLA -->
              <table width="80%" border="1">
                <tr align="center"  class="ColorTabla01"> 
                  <td colspan="12"><strong>3.-CONFECCION CATODOS INICIALES</strong></td>
                </tr>
                <tr> 
                  <td width="9%" rowspan="3" align="center"><strong>TURNO</strong></td>
                  <td width="17%" align="center"><strong>PRODUCCION</strong></td>
                  <td width="24%" rowspan="2" align="center"><strong>PRODUCCION</strong></td>
                  <td width="16%" rowspan="2" align="center"><strong>PRODUCCION</strong></td>
                  <td width="13%" rowspan="3" align="center"><strong>CONSUMO COMERCIAL</strong></td>
                  <td width="21%" rowspan="3" align="center"><strong>OBSERVACIONES</strong></td>
                </tr>
                <tr> 
                  <td rowspan="2" align="center"><strong>MFCI</strong></td>
                </tr>
                <tr> 
                  <td align="center"><strong>MCB</strong></td>
                  <td width="16%" align="center"><strong>MCO</strong></td>
                </tr>
          <?php
		  	$total_mfci=0;
			$total_mdb=0;
			$total_mco=0;
			$total_consumo=0;
			$mostrar2='S';
			
			if ($mostrar=='S')
			{
				if ($fecha < $cheq_fecha)
				{
					
					reset ($grupos);
				}
				else
				{
					$mostrar="N";		
				}	
			}
			$i=0;
			if ($mostrar=='S')
			  {
			 
					 while (list($a,$b)=each($grupos))
					  { $Dia_r=substr($fecha,8,2);
						$Mes_r=substr($fecha,5,2);
						$Ano_r=substr($fecha,0,4);

						$fecha_renovacion=$Ano_r.'-'.$Mes_r.'-01';
						$consulta_datos="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
						$consulta_datos.="where fecha_renovacion='".$fecha_renovacion."' ";
						$consulta_datos.="and dia_renovacion='".$Dia_r."' and cod_grupo=$b and (cod_concepto='A' or cod_concepto='B')";
						$Resp_datos = mysqli_query($link, $consulta_datos);
						if ( $row_datos = mysqli_fetch_array($Resp_datos))
						   {  
							  $consulta_fecha= " select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <= '".$fecha."' and cod_grupo='$b'";
							  $respuesta_fecha=mysqli_query($link, $consulta_fecha);
							  $row_fecha = mysqli_fetch_array($respuesta_fecha);
							  $consulta_datos_grupo="select fecha,num_cubas_tot,cubas_descobrizacion,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
							  $consulta_datos_grupo.=" where fecha ='".$row_fecha["fecha"]."' and cod_grupo='$b'";
							  /*echo $consulta_datos_grupo;*/
							  $respuesta_datos_grupo=mysqli_query($link, $consulta_datos_grupo);
							  $row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
							  if ($row_datos[cod_concepto]=='A')
								{
								  //echo grupo.$b."<br>"   ;
								  $total_A=$total_A+((($row_datos_grupo[num_cubas_tot]-$row_datos_grupo["hojas_madres"])-$row_datos_grupo[cubas_descobrizacion])*$row_datos_grupo[num_catodos_celdas]);
								  //echo "total turno a ".$total_A.'+((('.$row_datos_grupo[num_cubas_tot].'-'.$row_datos_grupo["hojas_madres"].')-'.$row_datos_grupo[cubas_descobrizacion].')*'.$row_datos_grupo[num_catodos_celdas].')'."<br>";
								 }
							  else if ($row_datos[cod_concepto]=='B')
									  {
								        //echo grupo.$b."<br>"   ;
										$total_B=$total_B + ((($row_datos_grupo[num_cubas_tot]-$row_datos_grupo["hojas_madres"]) -$row_datos_grupo[cubas_descobrizacion])*$row_datos_grupo[num_catodos_celdas]);         
										//echo "total turno b".$total_B.'+((('.$row_datos_grupo[num_cubas_tot].'-'.$row_datos_grupo["hojas_madres"].')-'.$row_datos_grupo[cubas_descobrizacion].')*'.$row_datos_grupo[num_catodos_celdas].')'."<br>";
									  }
							
						   }
						$consulta_desc="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
						$consulta_desc.="where fecha_renovacion='".$fecha_renovacion."' ";
						$consulta_desc.="and dia_renovacion='".$Dia_r."' and cod_grupo=$b and desc_parcial<>'' ";
						//echo $consulta_desc;
						$respuesta_desc=mysqli_query($link, $consulta_desc);
						if ($row_desc = mysqli_fetch_array($respuesta_desc))
							{
							  $consulta_dp="select num_celdas_grupos,num_catodos_celda from ref_web.circuitos_especiales where cod_circuito='DP'";
							  /*echo $consulta_dp;*/
							  $respuesta_dp=mysqli_query($link, $consulta_dp);
							  $row_dp = mysqli_fetch_array($respuesta_dp);
							  $total_dp=$total_dp+($row_dp[num_celdas_grupos]*$row_dp[num_catodos_celda]);
							  //echo "total parcial ".$total_dp.'='.$total_dp.'+('.$row_dp[num_celdas_grupos].'*'.$row_dp[num_catodos_celda].')';
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
							  $total_ew=$total_ew+($row_ew_d[num_celdas_grupos]*$row_ew_d[num_catodos_celda]);
							  //echo "total electrowin ".$total_ew.'='.$total_ew.'+('.$row_ew_d[num_celdas_grupos].'*'.$row_ew_d[num_catodos_celda].')';
							}
					}
					$consulta_cat_ini="select turno as turno_cat_ini,ifnull(produccion_mfci,0) as prod_mfci,ifnull(produccion_mdb,0) as prod_mdb,ifnull(produccion_mco,0) as prod_mco,observacion as observacion,consumo as consumo_cat_inil from ref_web.iniciales as t1 ";
					$consulta_cat_ini=$consulta_cat_ini."where  t1.fecha = '".$fecha."' order by t1.turno";
					/*echo $consulta_cat_ini;*/
					$Resp_cat_ini = mysqli_query($link, $consulta_cat_ini);
					while ($row_cat_ini = mysqli_fetch_array($Resp_cat_ini))
					{
						echo "<tr>\n";
						echo "<td align='center'>".$row_cat_ini[turno_cat_ini]."&nbsp</td>\n";
						echo "<td align='center'>".$row_cat_ini[prod_mfci]."&nbsp</td>\n";
						$total_mfci=$total_mfci+$row_cat_ini[prod_mfci];
						echo "<td align='center'>".$row_cat_ini[prod_mdb]."&nbsp</td>\n";
						$total_mdb=$total_mdb+$row_cat_ini[prod_mdb];
						echo "<td align='center'>".$row_cat_ini[prod_mco]."&nbsp</td>\n";
						$total_mco=$total_mco+$row_cat_ini[prod_mco];
						if ($mostrar2=='X')
							 {echo "<td align='center'>&nbsp</td>\n";
							 echo "<td align='center'>".$row_cat_ini["observacion"]."&nbsp</td>\n";}
						else if ($mostrar2=='S')
								{echo "<td align='center'>$total_A&nbsp</td>\n";
								echo "<td align='center'>".$row_cat_ini["observacion"]."&nbsp</td>\n";}
							 else if ($mostrar2=='P')
									 {echo "<td align='center'>$total_B&nbsp</td>\n";
									   echo "<td align='center'>".$row_cat_ini["observacion"]."&nbsp</td>\n";
									  $mostrar2='X';}
						if ($mostrar2=='S')
						{$mostrar2='P';}
					$total_consumo_comercial=$total_A + $total_B ;
					//echo "cosumo comercial dia ta y tb ".$total_consumo_comercial.'='.$total_A.'+'.$total_B ;
					echo "</tr>\n";								
					} 
					echo "<td align='right'>Total</td>\n";
					echo "<td align='center'><font color='blue'>$total_mfci&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>$total_mdb&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>$total_mco&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>$total_consumo_comercial&nbsp</font></td>\n";
					echo "<td align='center'>--</td>\n";
		}		
	?>
               </table>
              <table width="80%" border="1">
                <!--<tr> --> 
				<?php if ($total_dp != 0)
				   { ?>
	                 <tr>
                     <td width="79%"><strong>TOTAL CONSUMO DP</strong></td>
				     <?php  echo "<td align='center' class=detalle01>".$total_dp."&nbsp</td>\n";?>
                     </tr>
			        <?php } ?>
					<tr>
				<?php if  ($total_ew != 0) 
				    { ?>
                      <tr>
                         <td><strong>TOTAL CONSUMO EW</strong></td>
				         <?php  echo "<td align='center' class=detalle01>".$total_ew."&nbsp</td>\n";?>
                      </tr>
				<?php } ?> 
		            		
                      <!-- <td><strong>TOTAL CONSUMO </strong></td> -->
				       <?php       $consulta_desc="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
								$consulta_desc.="where fecha_renovacion='".$fecha_renovacion."' ";
								$consulta_desc.="and dia_renovacion='".$Dia_r."' and cod_concepto='D' and cod_grupo<>'' ";
								$respuesta_desc=mysqli_query($link, $consulta_desc);
								while ($row_desc = mysqli_fetch_array($respuesta_desc))
									{
										$consulta_fecha= " select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <= '".$fecha."' and cod_grupo='".$row_desc["cod_grupo"]."'";
										$respuesta_fecha=mysqli_query($link, $consulta_fecha);
										$row_fecha = mysqli_fetch_array($respuesta_fecha);
										$consulta_datos_grupo="select fecha,num_cubas_tot,cubas_descobrizacion,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
										$consulta_datos_grupo.=" where fecha ='".$row_fecha["fecha"]."' and cod_grupo='".$row_desc["cod_grupo"]."'";
										//echo $consulta_datos_grupo;
										$respuesta_datos_grupo=mysqli_query($link, $consulta_datos_grupo);
										$row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
										$total_normal_grupo=$total_normal_grupo+($row_datos_grupo[cubas_descobrizacion] * $row_datos_grupo[num_catodos_celdas]);
										//echo "consumo normal ".$total_normal_grupo.'='.$total_normal_grupo.'+('.$row_datos_grupo[cubas_descobrizacion].' *'.$row_datos_grupo[num_catodos_celdas].')'."<br>";
									}
						  
							   $total_consumo_total=$total_A + $total_B + $total_normal_grupo + $total_ew + $total_dp;
							   //echo "consumo total de laminas".'  '. $total_consumo_total.'='.$total_A. '+' .$total_B. '+' .$total_normal_grupo. '+' .$total_ew. '+' .$total_dp;
							   //echo "<td align='center' class=detalle01>".$total_consumo_total."&nbsp</td>\n";?> 
				      <!-- </tr> -->
					 <?php if ($total_normal_grupo !=0)
					     { ?>
						 <tr>
							 <td><strong>TOTAL CONSUMO DESC. NORMAL</strong></td>
							 <?php  echo "<td align='center' class=detalle01>".$total_normal_grupo."&nbsp</td>\n";?>
						  </tr>   
			          <?php } ?>
					 <?php if ($total_consumo_total !=0)
					     { ?>
						 <tr>
							 <td><strong>TOTAL CONSUMO </strong></td>
							 <?php  echo "<td align='center' class=detalle01>".$total_consumo_total."&nbsp</td>\n";?>
						  </tr>   
			        <?php } ?>
                <td><strong>STOCK CATODOS (8:00) </strong></td>
                  <?php 
					$consulta_cat_ini_stock="select sum(stock) as stock1, sum(rechazo_cat_ini) as rechazo_ini_cat, catodos_en_renovacion from  ref_web.detalle_iniciales as t1 ";
					$consulta_cat_ini_stock=$consulta_cat_ini_stock."where  t1.fecha = '".$fecha."' group by t1.fecha";
					$Resp_cat_stock = mysqli_query($link, $consulta_cat_ini_stock);
					$row_cat_stock = mysqli_fetch_array($Resp_cat_stock);
					echo "<td align='center' class=detalle01>".$row_cat_stock[stock1]."&nbsp</td>\n";
				?>
                </tr>
				 <td><strong>STOCK LAMINAS (8:00) </strong></td>
                  <?php 
					$consulta_lam_ini_stock="select stock_dia from  ref_web.stock_diario as t1 ";
					$consulta_lam_ini_stock=$consulta_lam_ini_stock."where  t1.fecha = '".$fecha."' ";
					$Resp_lam_stock = mysqli_query($link, $consulta_lam_ini_stock);
					$row_lam_stock = mysqli_fetch_array($Resp_lam_stock);
					echo "<td align='center' class=detalle01>".$row_lam_stock[stock_dia]."&nbsp</td>\n";
				?>
                </tr>

                <tr> 
                  <td><strong>RECHAZO CATODOS INICIALES</strong></td>
                  <?php $rechazo_catodos= $row_cat_stock[rechazo_ini_cat]+$row_cat_stock[catodos_en_renovacion];
				     echo "<td align='center' class=detalle01>".$rechazo_catodos."&nbsp</td>\n";?>
                </tr>
								   
              </table>
               <p>
                <input type="button" name="btnexcel360" value="Excel Tabla 3" style="width:80" onClick="Tabla3()" title="Excel de Confeccion Catodos Iniciales">
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
					$Consulta_electrolitos=$Consulta_electrolitos."where (t1.id_muestra='".$Fila["cod_grupo"]."' or t1.id_muestra='$grupo_aux') and t1.cod_producto='18' and left(t1.fecha_hora,10)='".$Fila_fecha[fecha2]."' and t1.cod_leyes in ('04','05','08','09','10','26','27','30','31','36','39','40','44','48') and t1.cod_subproducto='1'";
	 			}
				else
				{
					$Consulta_electrolitos="select  ifnull(t1.valor,0) as valor,t1.candado,t1.cod_unidad,t1.cod_leyes,signo from cal_web.leyes_por_solicitud as t1 ";
					$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
					$Consulta_electrolitos=$Consulta_electrolitos."where t1.id_muestra='".$Fila["cod_grupo"]."'  and t1.cod_producto='18' and left(t1.fecha_hora,10)='".$Fila_fecha[fecha2]."' and t1.cod_leyes in ('04','05','08','09','10','26','27','30','31','36','39','40','44','48') and t1.cod_subproducto='1'";
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
	<p>
    	<input type="button" name="btnexcel359" value="Excel Tabla 4" style="width:80" onClick="Tabla4()" title="Excel de Renovacion Anodos Hojas Madres">
    </p>
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
			while (list($a,$b)=each($grupos))
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
				if ($Fila_subp2["producto"]==1)
				{
					echo "<td align='center'>HVL&nbsp</td>\n";
				}
				else if ($Fila_subp2["producto"]==4)
				{
					echo "<td align='center'>Ventana&nbsp</td>\n";
				}
				else if ($Fila_subp2["producto"]==2)
				{
					echo "<td align='center'>Teniente&nbsp</td>\n";
				}
				else if ($Fila_subp2["producto"]==3)
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
			if ($Fila_subp["producto"]==1)
			{
				echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
			    echo HVL."</td>\n";
			}
			else if ($Fila_subp["producto"]==4)
			{
				echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
			    echo Ventana."</td>\n";}
			else if ($Fila_subp["producto"]==2)
			{
				echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fecha."','".$grupo."')\">\n";
			    echo Teniente."</td>\n";}
			else if ($Fila_subp["producto"]==3)
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
				//echo "peso cargado".$Fila[peso_cargado];
			$consulta2="select t1.peso as peso_cargado,t2.cod_leyes,t2.valor as ley,t1.cod_subproducto as subproducto ";
			$consulta2.=", sum(t1.peso * t2.valor / '".$Fila[peso_cargado]."') as calculo ";
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
			$total_total_ley=0;
			
			//while ($Fila2 = mysqli_fetch_array($Respuesta2))
			
				if ($Fila2["cod_leyes"]== "")
				{
					echo "<td align='center'>&nbsp</td>\n";
				}
				else
				{
						
					if ($Fila2[calculo] >= $limites[$l])
					{
						echo "<td align='center'><font color='red'><strong> ".number_format($Fila2[calculo],"",",","")."&nbsp</strong></fornt></td>\n";
					}	 
					else
					{				
						echo "<td align='center'>".number_format($Fila2[calculo],"",",","")."&nbsp</td>\n";
						
					}
				$l=$l+1;	
				}	 	
			}
			echo "</tr>\n";
			}
		}	
	?>
	</table>
	<p>
    	<input type="button" name="btnexcel3592" value="Excel Tabla 5" style="width:80" onClick="Tabla5()" title="Excel de Renovacion de Electrodos">
    </p>

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
						$circuitos=array('1','2','3','4','5','6','7','DP','DT','RETORNO');
						reset($circuitos);
						while (list($a,$b)=each($circuitos))
							{
							       $Consulta_fecha="select left(fecha_hora,10) as fecha2 from cal_web.solicitud_analisis ";
                                   $Consulta_fecha=$Consulta_fecha." where left(fecha_muestra,10)='".$fecha."' and id_muestra='$b' and cod_producto='41' "; 		
							       $Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
							       $Fila_fecha = mysqli_fetch_array($Respuesta_fecha);
								   //echo $Consulta_fecha;
				    		  echo "<td align='center'>$b&nbsp</td>\n";
							  reset($cod_leyes); 
							  while (list($c,$v)=each($cod_leyes))
								 {
    							    $Consulta_electrolitos="select  t2.valor as valor,t2.candado,t2.cod_unidad,t2.cod_leyes from cal_web.solicitud_analisis as t1 ";
									$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
									$Consulta_electrolitos=$Consulta_electrolitos."where t2.id_muestra='$b' and t2.cod_producto='41' and left(t1.fecha_muestra,10)='".$fecha."' and t2.cod_leyes='$v' and t2.candado='1'";
									$Consulta_electrolitos;
								    $Respuesta_electrolitos = mysqli_query($link, $Consulta_electrolitos);
									$Fila_electrolitos = mysqli_fetch_array($Respuesta_electrolitos);
									if ($Fila_electrolitos["valor"] <> 0)
									    {$total=number_format($Fila_electrolitos["valor"],"2","","");
										 if (($Fila_electrolitos[cod_unidad]=='6') and ($Fila_electrolitos["cod_leyes"]=='27'))
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
						 while (list($a,$b)=each($HM))
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
								if ($Fila_hm["id_muestra"]==$b)
									{
										$idmuestra=$Fila_hm["id_muestra"];
										echo "<td align='center'>".$Fila_hm["id_muestra"]."&nbsp</td>\n";
										reset($cod_leyes);	
						 				while (list($c,$v)=each($cod_leyes))
							   				{
								 				$Consulta_electrolitos="select  t1.valor as valor,t1.candado,t1.cod_unidad,t1.cod_leyes from cal_web.leyes_por_solicitud as t1 ";
												$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
												$Consulta_electrolitos=$Consulta_electrolitos."where t1.id_muestra='$idmuestra' and t1.cod_producto='41' and left(t2.fecha_muestra,10)='".$fecha."' and t1.cod_leyes='$v' and t1.candado='1'";
												$Respuesta_electrolitos = mysqli_query($link, $Consulta_electrolitos);
												$Fila_electrolitos = mysqli_fetch_array($Respuesta_electrolitos);
												if ($Fila_electrolitos["valor"] <> 0)
									    			{$total=number_format($Fila_electrolitos["valor"],"2","","");
										 			 if (($Fila_electrolitos[cod_unidad]=='6') and ($Fila_electrolitos["cod_leyes"]=='27'))
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
						 while (list($a,$b)=each($e100))
						 	{
								$Consulta_e="select  t2.id_muestra from cal_web.solicitud_analisis as t1 ";
								$Consulta_e=$Consulta_e."inner join cal_web.leyes_por_solicitud as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
								$Consulta_e=$Consulta_e."where t2.id_muestra='$b' and t2.cod_producto='41' and left(t1.fecha_muestra,10)='".$fecha."'";
								$Respuesta_e = mysqli_query($link, $Consulta_e);
								$Fila_e = mysqli_fetch_array($Respuesta_e);
								if ($Fila_e["id_muestra"]<>"")
									{
										$idmuestra=$Fila_e["id_muestra"];
										echo "<td align='center'>".$Fila_e["id_muestra"]."&nbsp</td>\n";
    									reset($cod_leyes);	
						      			while (list($c,$v)=each($cod_leyes))
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

	
	
		  
              <p>
                <input type="button" name="btnexcel35922" value="Excel Tabla 6" style="width:80" onClick="Tabla6()" title="Excel de Tabla Electrolitos">
              </p>
              <p> 
                <input type="button" name="btnexcel3" value="Excel" style="width:70" onClick="Excel()" title="Ejecutar Planilla Excel con datos de informes">
				<input type="button" name="btnimprimir" value="Imprimir" style="width:70" onClick="Imprimir()" title="Imprime informe diario">
                <input type="button" name="btnsalir" value="Salir" style="width:70" onClick="Salir()">
              </p>
              <p>&nbsp; </p></td>
  </tr>
</table>
</table>
</table>
</form>
</body>
</html>
