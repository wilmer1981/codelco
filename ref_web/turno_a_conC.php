<?php
/*select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito
from sec_web.produccion_catodo as t1 
inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo
where ((t1.fecha_produccion= '2006-04-04' and t1.hora >' 07:59:59')
 or  (t1.fecha_produccion = '2006-04-05' and t1.hora < ' 08:00:00'))
and t1.cod_producto='18'  and t1.cod_subproducto='1'  

and t1.cod_producto='18'  and t1.cod_subproducto='1'  group by t1.cod_grupo
*/
?>


<?php
	$CodigoDeSistema = 10;
	$CodigoDePantalla = 1;
	include("../principal/conectar_ref_web.php");
	include("funciones_administrador.php");
	
	if (strlen($dia1) == 1)
	{
		$dia1 = '0'.$dia1;
	}
	if (strlen($mes1) ==1) 
  	{
		$mes1 = '0'.$mes1;
	}
	$fecha=$ano1.'-'.$mes1.'-'.$dia1;

	
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

	f.action='turno_a.php?mostrar=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Buscarant()
{
	var  f=document.form1;

	f.action='turno_a.php?mostrar=S&anterior=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Buscarsig()
{
	var  f=document.form1;

	f.action='turno_a.php?mostrar=S&siguiente=S';
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
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;


	document.location = "../ref_web/ref_web_xls.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
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
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;


	document.location = "../ref_web/tabla4.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
}
function Tabla5()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;


	document.location = "../ref_web/tabla5.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
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
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=770 height=550 scrollbars=yes");
}
function Grafico3()
{
    var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	var ano=f.ano1.value;
	var mes=f.mes1.value;
	var dia=f.dia1.value;
	var URL ="../ref_web/Grafico3.php?fecha="+fecha+"&ano="+ano+"&mes="+mes+"&dia="+dia;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=770 height=550 scrollbars=yes");

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
<?php include("../principal/encabezado.php");?>

 <table width="772" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
 <tr>
 <td width="760" align="center" valign="middle">
          <table width="750" border="0" cellpadding="3" class="TablaInterior">
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
              </select>
            &nbsp;&nbsp; <input name="buscar" type="button" value="buscar" onClick="Buscar()" ></td>
            <td width="128"> 
              <input name="buscar22" type="button" value="Siguiente &gt;&gt;" onClick="Buscarsig('<?php echo $fecha;?>')" ></td>
          </tr>
        </table>
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
          	<TBODY>
            	<TR> 
              		<TD width="105"   class=tabson     align=middle><img height=40 alt=""  src="archivos/tabFrontOn.gif" width=52 border=0></TD>
              		<TD width="353"  class=tabsonline  align=middle><B class=tabstext>Produccion</B></TD>
              		<TD width="44"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tabMidOn.gif" width=22 border=0></TD>
                  		<?php echo '<TD width="113"  class=tabsoffline align=middle><A class=tabstext href="turno_b.php?fecha='.$fecha.'&ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&mostrar='.$mostrar.' "><B>Leyes</B></A></TD>'; ?>
			  		<TD width="44"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tabMidOn.gif" width=22 border=0></TD>
                  		<?php echo '<TD width="113"  class=tabsoffline align=middle><A class=tabstext href="ref_ing_circuitos.php?fecha='.$fecha.'&ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&mostrar='.$mostrar.' "><B>Informe Completo </B></A></TD>'; ?>	
             		<TD width="44"   class=tabsoff     align=middle><IMG height=40 alt="" src="archivos/tabMidOn.gif" width=22 border=0></TD>
			  			<?php echo '<TD width="113"  class=tabsoffline align=middle><A class=tabstext href="ref_graficos_inf_diario.php?ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&fecha='.$fecha.'"><B>Graficos</B></A></TD>'; ?>	
			  		<TD width="20"   class=tabsoff     align=middle> <IMG height=40 alt="" src="archivos/tabEndOff.gif" width=10 border=0></TD>
              		<TD width="139"   class=tabsline   align=middle><SPAN class=dMSNME_1></SPAN></TD>
              			<?php echo '<TD width="600%" class=tabsoffline  align=center><B><A style="COLOR: #ffffff" href="ref_ing_circuitos.php?fecha='.$fecha.'&ano1='.$ano1.'&mes1='.$mes1.'&dia1='.$dia1.'&mostrar='.$mostrar.'" target=_top><SPAN style="COLOR: #ffffcc"><font size="4"></font></SPAN></A></B></TD>'; ?>
           		</TR>
         </TBODY>
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

	$FechaInicio =date("Y-m-d", mktime(0,0,0,$mes1,$dia1 ,$ano1));	

	$Fechainiturno =$FechaInicio;
	$Fechafturno = date("Y-m-d", mktime(0,0,0,intval(substr($Fechainiturno, 5, 2)) ,intval(substr($Fechainiturno, 8, 2)) + 1,intval(substr($Fechainiturno, 0, 4))));

	//echo "fecha".$Fechainiturno."-".$Fechafturno;
	$Consulta =  "select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito,t1.fecha_produccion as fechaprod,t1.hora as horita from sec_web.produccion_catodo as t1 ";
	$Consulta = $Consulta." inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
	$Consulta.= " where CONCAT(t1.fecha_produccion,' ',t1.hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
	$Consulta = $Consulta." and t1.cod_producto='18'  and t1.cod_subproducto='1' group by t1.cod_grupo order by t1.fecha_produccion,t1.hora";

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
			
			if ($Fila["fechaprod"]== $Fechainiturno && $Fila["horita"] >= '08:00:00' && $Fila[horita] < '16:00:00')
			{
				
				$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$Fila[fechaprod]."' and t1.turno ='A' and t1.grupo = '".$Fila["cod_grupo"]."'";
				//echo "conb".$Consulta_turno;
				
				$respuesta_turno= mysqli_query($link, $Consulta_turno);
				
				$row_turno = mysqli_fetch_array($respuesta_turno);
				
				if ($row_turno[turno1]== '')
					$row_turno[turno1] = 'A';

			}	
			if ($Fila[fechaprod]== $Fechainiturno and $Fila[horita] >= '16:00:00')
			{
				$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$Fila[fechaprod]."' and t1.turno ='B' and t1.grupo = '".$Fila["cod_grupo"]."'";
				
				$respuesta_turno= mysqli_query($link, $Consulta_turno);
				$row_turno = mysqli_fetch_array($respuesta_turno);
				if ($row_turno[turno1]== '')
					$row_turno[turno1] = 'B';

				}
			if ($Fila[fechaprod]== $Fechafturno)
			{
				$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$Fila[fechaprod]."' and t1.turno ='C' and t1.grupo = '".$Fila["cod_grupo"]."'";
				$respuesta_turno= mysqli_query($link, $Consulta_turno);
				$row_turno = mysqli_fetch_array($respuesta_turno);
				if ($row_turno[turno1]== '')
					$row_turno[turno1] = 'C';

			}
			//echo "turno".$Consulta_turno;
			/*$respuesta_turno= mysqli_query($link, $Consulta_turno);
			$row_turno = mysqli_fetch_array($respuesta_turno);*/
			echo "<td align='center'>".$Fila["cod_circuito"]."&nbsp;</td>\n";
			echo "<td align='center' ><font color='blue'><a href=\"JavaScript:detalle('".$fecha."','".$Fila["cod_grupo"]."','".$row_turno[turno1]."')\">\n";
				//aqui sacar dias de renovacion  del grupo  poly 2005-01-31
			$j=0;
			$anomes=substr($fecha,0,8);
			$fechita=$anomes.'01';
			
				
			$con="select dia_renovacion as dia_renovacion from  sec_web.renovacion_prog_prod";
			$con.=" where cod_grupo = '".$Fila["cod_grupo"]."' and cod_concepto = '".$row_turno[turno1]."'";
			$con.=" and fecha_renovacion ='".$fechita."'"; 
		//echo "con".$con;
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
			
			$consulta_produccion.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
			$consulta_produccion=$consulta_produccion." and cod_producto='18'  and cod_subproducto='1'   and cod_grupo = '".$Fila["cod_grupo"]."' group by cod_grupo";
			//echo "consulta_pro".$consulta_produccion;
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
			$consultap.=" and CONCAT(fecha_movimiento,' ',hora) between  '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59' and cod_producto != '19' and campo2 = '".$grup."' group by campo2";
			//echo "con".$consultap;
			$pj=mysqli_query($link, $consultap);
			$ppj=mysqli_fetch_array($pj);	
			$p1=number_format($ppj["peso_anodos"],2,".","");
			
			//saca peso del produccin del resto de ese frupo	
			$consultaj="select campo2,sum(peso) as peso,sum(unidades) as unidades from sea_web.movimientos where tipo_movimiento = '3'";
			$consultaj.=" and CONCAT(fecha_movimiento,' ',hora) between '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59' and campo2 ='".$grup."' group by campo2";
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
			//echo "s".$scrap;
			$pp=number_format($p,"",",",".");
			$peso_anodos=number_format($p1,"",",",".");
			
			
			echo "<td align='center'>$peso_anodos&nbsp;</td>\n";
			
			echo"<td align='center'>$pp&nbsp;</td>\n";
			
 			echo"<td align='center'>$scrap&nbsp;</td>\n";
			$Consulta = "select ifnull(cubas_descobrizacion,0) as cant_cuba, ifnull(num_cubas_tot,0) as num_cubas, ifnull(num_catodos_celdas,1) as num_catodos from ref_web.grupo_electrolitico2 ";
			$Consulta = $Consulta."where cod_grupo = '".$Fila["cod_grupo"]."' and  fecha = '$fecha_aux'";
			//echo "con".$Consulta;
			$rs1 = mysqli_query($link, $Consulta);
			$row1 = mysqli_fetch_array($rs1);
			//echo "con".$Fila["cod_grupo"];
			echo "<td align='center'>".$row1[cant_cuba]."&nbsp</td>\n";
			if ($row_turno[turno1] == 'C')
				$fecha11= $Fechafturno;
			else
				$fecha11 = $Fechainiturno;	
			$Consulta ="select ifnull(sum(unid_recup),0) as recuperado_tot, ifnull(sum(estampa),0) as ne, ifnull(sum(dispersos),0) as nd, ifnull(sum(rayado),0) as ra, ";
			$Consulta =$Consulta."ifnull(sum(cordon_superior),0) as cs, ifnull(sum(cordon_lateral),0) as cl, ifnull(sum(quemados),0) as qu, ifnull(sum(redondos),0) as re,";
			$Consulta.=" ifnull(sum(aire),0) as ai, ifnull(sum(otros),0) as ot from cal_web.rechazo_catodos as t1 " ;
			$Consulta = $Consulta."where t1.fecha = '".$fecha11."' and t1.grupo = '".$Fila["cod_grupo"]."'";
			//echo "otro".$Consulta;
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
			$rechazado_tot_fila=$rechazado_tot_fila+$Fila2["qu"]+$Fila2["re"]+$Fila2["ai"];
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
	  
	  
$total_prod2=number_format($total_prod,"",".",".");
;
if ($total_scrap != 0)
{
	$total_por_scrap =($total_scrap/$total_peso_anodos)*100;
	//echo "total".$total_scrap."-".$total_peso_anodos;
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
echo "<td align='center'><font color='blue'>$total_qu&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_re&nbsp</font></td>\n";
echo "<td align='center'><font color='blue'>$total_ai&nbsp</font></td>\n";
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
				{
					$Dia_r=substr($fecha,8,2);
					$Mes_r=substr($fecha,5,2);
					$Ano_r=substr($fecha,0,4);
					$fecha_renovacion=$Ano_r.'-'.$Mes_r.'-01';
					$consulta_datos="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
					$consulta_datos.="where fecha_renovacion='".$fecha_renovacion."' ";
					$consulta_datos.="and dia_renovacion='".$Dia_r."' and cod_grupo=$b and (cod_concepto='A' or cod_concepto='B' or cod_concepto='C')";
					$Resp_datos = mysqli_query($link, $consulta_datos);
					if ( $row_datos = mysqli_fetch_array($Resp_datos))
					{  
						$consulta_fecha= " select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <= '".$fecha."' and cod_grupo='$b'";
						$respuesta_fecha=mysqli_query($link, $consulta_fecha);
						$row_fecha = mysqli_fetch_array($respuesta_fecha);
						$consulta_datos_grupo="select fecha,num_cubas_tot,cubas_descobrizacion,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
						$consulta_datos_grupo.=" where fecha ='".$row_fecha["fecha"]."' and cod_grupo='$b'";
						$respuesta_datos_grupo=mysqli_query($link, $consulta_datos_grupo);
						$row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
						if ($row_datos[cod_concepto]=='A')
						{
							$total_A=$total_A+((($row_datos_grupo[num_cubas_tot]-$row_datos_grupo["hojas_madres"])-$row_datos_grupo[cubas_descobrizacion])*$row_datos_grupo[num_catodos_celdas]);
						}
						else if ($row_datos[cod_concepto]=='B')
						{
							$total_B=$total_B + ((($row_datos_grupo[num_cubas_tot]-$row_datos_grupo["hojas_madres"]) -$row_datos_grupo[cubas_descobrizacion])*$row_datos_grupo[num_catodos_celdas]);         
						}
						else if ($row_datos[cod_concepto]=='C')
						{
							$total_C=$total_C + ((($row_datos_grupo[num_cubas_tot]-$row_datos_grupo["hojas_madres"]) -$row_datos_grupo[cubas_descobrizacion])*$row_datos_grupo[num_catodos_celdas]);         
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
						$total_dp=$total_dp+($row_dp[num_celdas_grupos]*$row_dp[num_catodos_celda]);
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
					}
				}
				$consulta_cat_ini="select turno as turno_cat_ini,ifnull(produccion_mfci,0) as prod_mfci,ifnull(produccion_mdb,0) as prod_mdb,ifnull(produccion_mco,0) as prod_mco,observacion as observacion,consumo as consumo_cat_inil from ref_web.iniciales as t1 ";
				$consulta_cat_ini=$consulta_cat_ini."where  t1.fecha = '".$fecha."' order by t1.turno";
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
					{
						echo "<td align='center'>&nbsp</td>\n";
						echo "<td align='center'>".$row_cat_ini["observacion"]."&nbsp</td>\n";
					}
					else if ($mostrar2=='S')
					{
						echo "<td align='center'>$total_A&nbsp</td>\n";
						echo "<td align='center'>".$row_cat_ini["observacion"]."&nbsp</td>\n";
					}
					else if ($mostrar2=='P')
					{
						echo "<td align='center'>$total_B&nbsp</td>\n";
						echo "<td align='center'>".$row_cat_ini["observacion"]."&nbsp</td>\n";
						$mostrar2='X';
					}
					if ($mostrar2=='S')
					{
						$mostrar2='P';
					}
					$total_consumo_comercial=$total_A + $total_B ;
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
				
				<?php
				
				 if ($total_dp != 0)
				   { 
				 
				?>
					
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
				<?php }
				
				?> 
		            		
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
					?> 
				    <?php 
					
					 if ($total_normal_grupo !=0)
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
			  <?php
			  //aqui incluir tabla de jefe turno pte. des.electrolitio solicitado por luis farias
				if (!isset($fecha))
   			  	{
				  	$consulta_fecha_ter="SELECT LEFT(sysdate(),10) as fecha_fin";
				  	$respuesta_fecha_ter = mysqli_query($link, $consulta_fecha_ter);
				  	$Fila_fecha_ter=mysqli_fetch_array($respuesta_fecha_ter);
				  	$FechaTermino = $Fila_fecha_ter[fecha_fin];
	 			} 
			  	else 
			  	{
        			$FechaTermino = $fecha;
       			}
  				$consulta_fecha_ini="SELECT  SUBDATE('$FechaTermino',INTERVAL 7 DAY) as fecha_inicio";
  				$resultado_fecha_ini=mysqli_query($link, $consulta_fecha_ini);
  				$Fila_fecha_ini = mysqli_fetch_array($resultado_fecha_ini);
  				$FechaInicio = $Fila_fecha_ini[fecha_inicio];
  				$txt_turno='C';
  				$txt_turno1='B';  
  				$proceso='C';	

			  	//esto lo tome del otro prog
			  
			  ?>
			 
			 
          <table width="80%" border="1">
            <tr> 
              <?php
		   		$consulta_circuito="select valor_subclase1,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='3100' and valor_subclase1<='6' "; 
				$respuesta_circuito= mysqli_query($link, $consulta_circuito);
				$total_electrolito=0;
				$total_dp=0;
				while ($row_c= mysqli_fetch_array($respuesta_circuito))
				{
					$consulta_elect_total="select sum(volumen_pte) as volumen_pte_total from ref_web.tratamiento_electrolito";
					$consulta_elect_total.= " where fecha  between '".$FechaInicio."' and '".$FechaTermino."' and turno  in ('C','A','B')";
					$consulta_elect_total.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
					$respuesta_elect_total = mysqli_query($link, $consulta_elect_total);
		           	$row_elect_total= mysqli_fetch_array($respuesta_elect_total);
								//echo $consulta_elect_total."<br>";
					$consulto='S';
					if ($txt_turno=='A')
					{
						$turnos_desc_inicio="C";
					}
					else if ($txt_turno=='B')
					{
						$turnos_desc_inicio="C','A";
					}  
					else
					{
						$consulto='N';
					}
					if ($consulto!='N')
					{		   	 
						$consulta_elect_descuento_inicio="select sum(volumen_pte) as volumen_pte_inicio from ref_web.tratamiento_electrolito";
						$consulta_elect_descuento_inicio.= " where fecha ='".$FechaInicio."' and turno  in ('".$turnos_desc_inicio."')";
						$consulta_elect_descuento_inicio.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
						$respuesta_elect_descuento_inicio = mysqli_query($link, $consulta_elect_descuento_inicio);
						$row_elect_descuento_inicio= mysqli_fetch_array($respuesta_elect_descuento_inicio);
									  //echo $consulta_elect_descuento_inicio."<br>";
					}
					$consulto='S';		
					if ($txt_turno1=='A')
					{
						$turnos_desc_fin="B";
					}
					else if ($txt_turno1=='C')
					{
						$turnos_desc_fin="A','B";
					}
					else
					{
						$consulto='N';
					}
					if ($consulto!='N')
					{		   
						$consulta_elect_descuento_ter="select sum(volumen_pte) as volumen_pte_ter from ref_web.tratamiento_electrolito";
						$consulta_elect_descuento_ter.= " where fecha ='".$FechaTermino."' and turno  in ('".$turnos_desc_fin."')";
						$consulta_elect_descuento_ter.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
						$respuesta_elect_descuento_ter = mysqli_query($link, $consulta_elect_descuento_ter);
						$row_elect_descuento_ter= mysqli_fetch_array($respuesta_elect_descuento_ter);
									 //echo $consulta_elect_descuento_ter."<br>";
									} 
						$total_electrolito=0;			   
						$total_electrolito=$row_elect_total[volumen_pte_total]-$row_elect_descuento_inicio[volumen_pte_inicio]-$row_elect_descuento_ter[volumen_pte_ter];
							/***************************************************************************************************************/
						$consulta_dp_total="select sum(volumen_dp) as total_desc_parcial from ref_web.desc_parcial";
						$consulta_dp_total.= " where fecha  between '".$FechaInicio."' and '".$FechaTermino."' and turno  in ('C','A','B')";
					            $consulta_dp_total.= " and circuito_dp='".$row_c["nombre_subclase"]."'";
								//echo $consulta_dp_total."<br>";
						$respuesta_dp_total = mysqli_query($link, $consulta_dp_total);
         				$row_dp_total= mysqli_fetch_array($respuesta_dp_total);
						$consulto='S';
						if ($txt_turno=='A')
						{
							$turnos_desc_inicio="C";
						}
						else if ($txt_turno=='B')
						{
							$turnos_desc_inicio="C','A";
						}  
						else
						{
							$consulto='N';
						}
						if ($consulto!='N')
						{		   	 
							$consulta_dp_total_ini="select sum(volumen_dp) as total_desc_parcial_ini from ref_web.desc_parcial";
							$consulta_dp_total_ini.= " where fecha = '".$FechaInicio."' and turno  in ('".$turnos_desc_inicio."')";
					        $consulta_dp_total_ini.= " and circuito_dp='".$row_c["nombre_subclase"]."'";
									 //echo $consulta_dp_total_ini."<br>";
							$respuesta_dp_total_ini = mysqli_query($link, $consulta_dp_total_ini);
         					$row_dp_total_ini= mysqli_fetch_array($respuesta_dp_total_ini);
						} 
						$consulto='S';	
						if ($txt_turno1=='A')
						{
							$turnos_desc_fin="B";
						}
						else if ($txt_turno1=='C')
						{
							$turnos_desc_fin="A','B";
						}
						else 
						{
							$consulto='N';
						}	
						if ($consulto!='N')
						{		   	 
							$consulta_dp_total_fin="select sum(volumen_dp) as total_desc_parcial_fin from ref_web.desc_parcial";
						    $consulta_dp_total_fin.= " where fecha = '".$FechaTermino."' and turno in ('".$turnos_desc_fin."')";
					        $consulta_dp_total_fin.= " and circuito_dp='".$row_c["nombre_subclase"]."'";
							$respuesta_dp_total_fin = mysqli_query($link, $consulta_dp_total_fin);
         					$row_dp_total_fin= mysqli_fetch_array($respuesta_dp_total_fin);
								      //echo $consulta_dp_total_fin."<br>";
						}
						$total_dp=0;	
						$total_dp=$row_dp_total[total_desc_parcial]-$row_dp_total_ini[total_desc_parcial_ini]-$row_dp_total_fin[total_desc_parcial_fin];
							/***************************************************************************************************************/
						if ($row_c["nombre_subclase"]=='Circuito1')
						{
							$total_c1=$total_c1+($total_electrolito + $total_dp);
						}
						else if ($row_c["nombre_subclase"]=='Circuito2')
							{$total_c2=$total_c2+($total_electrolito + $total_dp);
						}
						else if ($row_c["nombre_subclase"]=='Circuito3')
						{
							$total_c3=$total_c3+($total_electrolito + $total_dp);
						}
						else if ($row_c["nombre_subclase"]=='Circuito4')
						{
							$total_c4=$total_c4+($total_electrolito + $total_dp);
						}
						else if ($row_c["nombre_subclase"]=='Circuito5')
						{
							$total_c5=$total_c5+($total_electrolito + $total_dp);
						}	
						else if ($row_c["nombre_subclase"]=='Circuito6')
						{
							$total_c6=$total_c6+($total_electrolito + $total_dp);
						}    
						   
			}
			?>
              <td height="17"><strong>Descarte electrolito (m3)</strong></td>
            <?php
            	echo "<td><strong>TOTAL</strong>";
				$total=$total_c1+$total_c2+$total_c3+$total_c4+$total_c5+$total_c6;
				echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total</strong></font></td>";
			 	echo "<td>C1";    
				echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c1</strong></font></td>";	
				echo "<td>C2";   
				echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c2</strong></font></td>";
            	echo "<td>C3";
				echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c3</strong></font></td>";
            	echo "<td>C4";
				echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c4</strong></font></td>";
            	echo "<td>C5";
				echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c5</strong></font></td>";
            	echo "<td>C6";
				echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c6</strong></font></td>";
			?>
          </tr>
      		</table>
			 
			 <br>
			  
			  <input type="button" name="btnimprimir" value="Imprimir" style="width:70" onClick="Imprimir()" title="Imprime informe diario">
                <input type="button" name="btnsalir" value="Salir" style="width:80" onClick="Salir()">

</table>
</table>
<?php include("../principal/pie_pagina.php");?>
</form>
</body>
</html>
