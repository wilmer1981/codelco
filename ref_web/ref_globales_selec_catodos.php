<?php
	include("../principal/conectar_principal.php");

	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y"); 
	$cmbcircuito = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:""; 
	$opcion      = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:""; 

	if (strlen($DiaIni)==1)
		$DiaIni = "0".$DiaIni;
	if (strlen($MesIni)==1)
		$MesIni = "0".$MesIni;
	if (strlen($DiaFin)==1)
		$DiaFin = "0".$DiaFin;
	if (strlen($MesFin)==1)
		$MesFin = "0".$MesFin;

 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;

	$NumCir=$cmbcircuito;
?>
<html>
<head>
<title>Informe Clasificacion Catodos Conerciales</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	if (opcion=='S')
	  // {f.action = "cortes2_aux.php?recarga=S"+"&dia1="+f.dia1.value+"&mes1="+f.mes1.value+"&ano1="+f.ano1.value+"&circuito="+f.cmbcircuito.value+"&mostrar=S&Buscar=N";}
	   {f.action = "ref_clasificacion_catodos_comerciales.php?cmbcircuito="+f.cmbcircuito.value+"&Buscar=S"+"&DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value;}
	f.submit();
}
function Imprimir(f)
{
	window.print();
}
function Salir(f)
{
 window.close();
}
function Grafico(f)
{
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	
	var URL ="../ref_web/ref_grafico_clasificacion_cat_com_global.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=930 height=650 scrollbars=no");
}	
function Excel(f,opcion)

{
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	document.location = "ref_globales_selec_catodos_xls.php?DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value+"&DiaFin="+f.DiaFin.value+"&MesFin="+f.MesFin.value+"&AnoFin="+f.AnoFin.value+"&opcion="+opcion+"&cmbcircuito="+f.NumCir.value;
}
function detalle_anodos(fecha,grupo)
{
	var Frm=document.form1;
	window.open("Detalle_carga_anodos.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="632" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="7" class="ColorTabla01"><strong>INFORME DE CLASIFICACION FISICA 
        DE CATODOS COMERCIALES (Global / Dia)</strong></td>
    </tr>
    <tr> 
      <td width="90" class="Detalle02"><strong>Fecha Inicio:</strong></td>
      <td width="84" class="detalle01"><strong><?php echo $FechaInicio;?></strong>
	  <input name="AnoIni" type="hidden" value="<?php echo $AnoIni;?>">
	  <input name="MesIni" type="hidden" value="<?php echo $MesIni;?>">
	  <input name="DiaIni" type="hidden" value="<?php echo $DiaIni;?>"></td>
      <td width="51">&nbsp;</td>
      <td width="89" class="Detalle02"><strong>Fecha Termino:</strong></td>
      <td width="78" class="detalle01"><strong><?php echo $FechaTermino;?></strong>
	  <input name="AnoFin" type="hidden" value="<?php echo $AnoFin;?>">
	  <input name="MesFin" type="hidden" value="<?php echo $MesFin;?>">
	  <input name="DiaFin" type="hidden" value="<?php echo $DiaFin;?>"></td>
      <td width="47" >&nbsp; <input name="NumCir" type="hidden" value="<?php echo $NumCir; ?>"></td>
      <td width="162"><input name="graficar" type="button" value="Grafico" onClick="Grafico(this.form)" ></td>
    </tr>
  </table>
  <table width="729" border="2" align="center" cellpadding="1" cellspacing="1" bordercolor="#b26c4a" class="TablaDetalle">
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td width="131" rowspan="2" align="center"><strong>Fecha</strong><strong></strong></td>
	  <?php if ($opcion=='P')
	  		{?>
			  <td width="142" rowspan="2" align="center"><strong>Seleccion Inicial (%)</strong></td>
			  <td width="103" rowspan="2" align="center"><strong>Recuperado (%)</strong></td>
			  <td width="93" rowspan="2" align="center"><strong>Estandar (%)</strong></td>
		<?php }
		else { ?> 
				<td width="142" rowspan="2" align="center"><strong>Produccion(Unid.)</strong></td>
				<td width="142" rowspan="2" align="center"><strong>Seleccion Inicial (Unid.)</strong></td>
			    <td width="103" rowspan="2" align="center"><strong>Recuperado (Unid.)</strong></td>
			    <td width="93" rowspan="2" align="center"><strong>Estandar (Unid.)</strong></td>
		  <?php }?>	
      <td colspan="6" align="center"><strong>Detalle (Unidades)</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td width="33" align="center"><div align="center"><strong>NE</strong></div></td>
      <td width="33" align="center"><div align="center"><strong>ND</strong></div></td>
      <td width="33" align="center"><div align="center"><strong>RA</strong></div></td>
      <td width="33" align="center"><div align="center"><strong>CS</strong></div></td>
      <td width="33" align="center"><div align="center"><strong>CL</strong></div></td>
      <td width="33" align="center"><div align="center"><strong>QU</strong></div></td>
      <td width="33" align="center"><div align="center"><strong>RE</strong></div></td>
      <td width="33" align="center"><div align="center"><strong>AI</strong></div></td>
      <td width="33" align="center"><div align="center"><strong>OT</strong></div></td>
    </tr>
    <?php

			$total_a_la_fecha=0;
			$seleccion_inicial_total=0;
			$recuperado_total_total=0;
			$rechazo_total_total=0;
			$total_rango_ne=0;
			$total_rango_nd=0;
			$total_rango_ra=0;
			$total_rango_cs=0;
			$total_rango_cl=0;
			$total_rango_qu=0;
			$total_rango_re=0;
			$total_rango_ai=0;
			$total_rango_ot=0;

	  	   $consulta="SELECT distinct (t1.fecha_produccion) as fecha ";
		   $consulta.="from sec_web.produccion_catodo as t1 ";
		   $consulta.="INNER JOIN ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo ";
		   $consulta.="where t1.fecha_produccion BETWEEN '".$FechaInicio."' and '".$FechaTermino."' and t2.cod_circuito in ('01','02','03','04','05','06') ";
		   $consulta.="and t1.cod_producto='18' and t1.cod_subproducto='1' ";
		   $consulta.="GROUP by t1.fecha_produccion ";
		   $consulta.="ORDER by t1.fecha_produccion";
		   $respuesta = mysqli_query($link, $consulta);
		        while ($fila = mysqli_fetch_array($respuesta))
			    { 
?>
                   <tr onMouseOver="if(!this.contains(event.fromElement)){this.bgColor='class=ColorTabla02';} if(!document.all){style.cursor='pointer'};style.cursor='hand';" onMouseOut="if(!this.contains(event.toElement)){this.bgColor=''; }" > 
      				<?php
				   echo "<td align='center' class=detalle01>".$fila["fecha"]."&nbsp</td>\n";
				   $consulta_grupos_dia="SELECT t1.cod_grupo as cod_grupo ";
				   $consulta_grupos_dia.="from sec_web.produccion_catodo as t1 ";
				   $consulta_grupos_dia.="INNER JOIN ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo ";
				   $consulta_grupos_dia.="where t1.fecha_produccion ='".$fila["fecha"]."' and t2.cod_circuito in ('01','02','03','04','05','06') ";
				   $consulta_grupos_dia.="and t1.cod_producto='18' and t1.cod_subproducto='1' ";
				   $consulta_grupos_dia.="GROUP by t1.fecha_produccion,t1.cod_grupo ";
				   $consulta_grupos_dia.="ORDER by t1.fecha_produccion";
				   $respuesta_grupos_dia=mysqli_query($link, $consulta_grupos_dia);
				   $total_grupo=0;
				   $rechazo_total_dias=0;
				   $recuperado_total_dias=0;
				   $total_ne=0;
				   $total_nd=0;
				   $total_ra=0;
				   $total_cs=0;
				   $total_cl=0;
				   $total_qu=0;
				   $total_re=0;
				   $total_ai=0;
				   $total_ot=0;
				    while ($row_grupos_dia=mysqli_fetch_array($respuesta_grupos_dia))
				    {
					      $consulta_t_rechazo_catodos="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,";
						  $consulta_t_rechazo_catodos.="sum(cordon_superior) as cs,sum(cordon_lateral) as cl,sum(quemados) as qu,sum(redondos) as re,";
						  $consulta_t_rechazo_catodos.="sum(aire) as ai,sum(otros) as ot ";
						  $consulta_t_rechazo_catodos.="from cal_web.rechazo_catodos where fecha='".$fila["fecha"]."' and grupo='".$row_grupos_dia["cod_grupo"]."'";
						  $respuesta_t_rechazo_catodos= mysqli_query($link, $consulta_t_rechazo_catodos);
				          $fila_t_rechazo_catodos = mysqli_fetch_array($respuesta_t_rechazo_catodos);
				          $suma_rechazo=$fila_t_rechazo_catodos["ne"]+$fila_t_rechazo_catodos["nd"]+$fila_t_rechazo_catodos["ra"]+$fila_t_rechazo_catodos["cs"];
						  $suma_rechazo=$suma_rechazo+$fila_t_rechazo_catodos["cl"]+$fila_t_rechazo_catodos["qu"]+$fila_t_rechazo_catodos["re"]+$fila_t_rechazo_catodos["ai"]+$fila_t_rechazo_catodos["ot"];	
						  $total_ne=$total_ne+$fila_t_rechazo_catodos["ne"];
						  $total_nd=$total_nd+$fila_t_rechazo_catodos["nd"];
						  $total_ra=$total_ra+$fila_t_rechazo_catodos["ra"];
						  $total_cs=$total_cs+$fila_t_rechazo_catodos["cs"];
						  $total_cl=$total_cl+$fila_t_rechazo_catodos["cl"];
						  $total_qu=$total_qu+$fila_t_rechazo_catodos["qu"];
						  $total_re=$total_re+$fila_t_rechazo_catodos["re"];
						  $total_ai=$total_ai+$fila_t_rechazo_catodos["ai"];
						  $total_ot=$total_ot+$fila_t_rechazo_catodos["ot"];
						  $consulta_max_fecha_ge="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where cod_grupo='".$row_grupos_dia["cod_grupo"]."' and fecha<='".$fila["fecha"]."' ";
						  $respuesta_max_fecha_ge= mysqli_query($link, $consulta_max_fecha_ge);
						  $row_max_fecha_ge = mysqli_fetch_array($respuesta_max_fecha_ge);
						  $consulta_det_grupo = "select ifnull(cubas_descobrizacion,0) as cant_cuba, ifnull(num_cubas_tot,0) as num_cubas, ifnull(num_catodos_celdas,1) as num_catodos,ifnull(hojas_madres,0) as hojas_madres  from ref_web.grupo_electrolitico2 ";
						  $consulta_det_grupo = $consulta_det_grupo."where cod_grupo = '".$row_grupos_dia["cod_grupo"]."' and  fecha = '".$row_max_fecha_ge["fecha"]."'";
						  $respuesta_det_grupo = mysqli_query($link, $consulta_det_grupo);
						  $row_det_grupo = mysqli_fetch_array($respuesta_det_grupo);
						  
						  $total_grupo=$total_grupo+($row_det_grupo["num_catodos"]*($row_det_grupo["num_cubas"]-$row_det_grupo["hojas_madres"]));
						  $rechazo_total_dias=$rechazo_total_dias+$suma_rechazo;
						  $recuperado_total_dias=$recuperado_total_dias+$fila_t_rechazo_catodos["recuperado_tot"];
						  //echo 'fecha:'.$fila["fecha"].'--->grupo='.$row_grupos_dia["cod_grupo"].'--->total grupos='.$total_grupo.'--->total_rechazos='.$rechazo_total_dias.'--->recuperado dias='.$recuperado_total_dias."<br>";
					}
					if ($opcion=='P'){
						if($total_grupo>0){		
						    $seleccion_inicial=((($rechazo_total_dias+$recuperado_total_dias))/$total_grupo)*100;
							$recuperado_total=($recuperado_total_dias/$total_grupo)*100;	
							$rechazo_total=($rechazo_total_dias/$total_grupo)*100; 	
						}else{
							$seleccion_inicial=0;	
							$recuperado_total=0;
							$rechazo_total=0;
						}
						   echo "<td align='center' >".number_format($seleccion_inicial,"2",",",".")."&nbsp</td>\n";
						  
						   echo "<td align='center' >".number_format($recuperado_total,"2",",",".")."&nbsp</td>\n";
						   
						   echo "<td align='center' >".number_format($rechazo_total,"2",",",".")."&nbsp</td>\n";
					}else{
				    	   echo "<td align='center' >".$total_grupo."&nbsp</td>\n";
						   $total_a_la_fecha=$total_a_la_fecha+$total_grupo;
			   			   $seleccion_inicial=$rechazo_total_dias+$recuperado_total_dias;
						   $seleccion_inicial_total=$seleccion_inicial_total+$seleccion_inicial;
						   echo "<td align='center' >".$seleccion_inicial."&nbsp</td>\n";
						   $recuperado_total=$recuperado_total_dias;
						   $recuperado_total_total=$recuperado_total_total+$recuperado_total;
						   echo "<td align='center' >".$recuperado_total."&nbsp</td>\n";
						   $rechazo_total=$rechazo_total_dias;
						   $rechazo_total_total=$rechazo_total_total+$rechazo_total;
						   echo "<td align='center' >".$rechazo_total."&nbsp</td>\n";
				   	}   
				   echo "<td align='center' >".$total_ne."&nbsp</td>\n";
				   echo "<td align='center' >".$total_nd."&nbsp</td>\n";
				   echo "<td align='center' >".$total_ra."&nbsp</td>\n";
				   echo "<td align='center' >".$total_cs."&nbsp</td>\n";
				   echo "<td align='center' >".$total_cl."&nbsp</td>\n";
				   echo "<td align='center' >".$total_qu."&nbsp</td>\n";
				   echo "<td align='center' >".$total_re."&nbsp</td>\n";
				   echo "<td align='center' >".$total_ai."&nbsp</td>\n";
				   echo "<td align='center' >".$total_ot."&nbsp</td>\n";
				   echo '</tr>';
				   $total_rango_ne=$total_rango_ne+$total_ne;
				   $total_rango_nd=$total_rango_nd+$total_nd;
				   $total_rango_ra=$total_rango_ra+$total_ra;
				   $total_rango_cs=$total_rango_cs+$total_cs;
				   $total_rango_cl=$total_rango_cl+$total_cl;
				   $total_rango_qu=$total_rango_qu+$total_qu;
				   $total_rango_re=$total_rango_re+$total_re;
				   $total_rango_ai=$total_rango_ai+$total_ai;
				   $total_rango_ot=$total_rango_ot+$total_ot;

			    }
				if ($opcion=='L')
				{
					 echo '<tr class="ColorTabla01">';
					 echo "<td align='center' ><strong>Totales&nbsp</strong></td>\n";
					 echo "<td align='center' >".$total_a_la_fecha."&nbsp</td>\n";
					 echo "<td align='center' >".$seleccion_inicial_total."&nbsp</td>\n";
					 echo "<td align='center' >".$recuperado_total_total."&nbsp</td>\n";
					 echo "<td align='center' >".$rechazo_total_total."&nbsp</td>\n";
					 echo "<td align='center' >".$total_rango_ne."&nbsp</td>\n";
					 echo "<td align='center' >".$total_rango_nd."&nbsp</td>\n";
					 echo "<td align='center' >".$total_rango_ra."&nbsp</td>\n";
					 echo "<td align='center' >".$total_rango_cs."&nbsp</td>\n";
					 echo "<td align='center' >".$total_rango_cl."&nbsp</td>\n";
					 echo "<td align='center' >".$total_rango_qu."&nbsp</td>\n";
					 echo "<td align='center' >".$total_rango_re."&nbsp</td>\n";
					 echo "<td align='center' >".$total_rango_ai."&nbsp</td>\n";
					 echo "<td align='center' >".$total_rango_ot."&nbsp</td>\n";
					 echo '</tr>';
				} 
				 	   				 
		
           echo '</table>';
         
	?>
  </table>
  <p>&nbsp;</p>
  <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"><input name="btnimprimir2" type="button" value="Excel" style="width:70;" onClick="JavaScript:Excel(this.form,'<?php echo $opcion;?>')"> 
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir(this.form)" value="Salir"></td>
  </tr>
</table>
</form>
</body>
</html>

