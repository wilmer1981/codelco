<?php
    set_time_limit(500); 
	include("../principal/conectar_principal.php");
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

	
	  $DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	  $MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	  $AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	  $DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	  $MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	  $AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y"); 
	  $cmbcircuito = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:""; 
	  $opcion      = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	  $mostrar     = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";  

	  if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?>
<html>
<head>
<title>Informe Clasificacion Catodos Comerciales</title>
</head>
<body >
<form name="frmPrincipal" action="" method="post">
  <?php if ($cmbcircuito<>'99')
   {?>
<table width="850" border="2" cellspacing="1" align="center" cellpadding="1">
   <tr>
   	  <td colspan="13" align="center"><strong>INFORME DE CLASIFICACION FISICA 
        DE CATODOS COMERCIALES</strong></td>
    </tr> 
	<tr>
		<td colspan="6"><strong>Fecha Inicio : <?php echo $FechaInicio; ?></strong></td>
		
		<td colspan="7"><strong>Fecha Termino : <?php echo $FechaTermino; ?></strong></td>

	</tr>
	
	
   <tr>		
	<?php if ($opcion=='P') 
		{?>
      		<td colspan="7" align="center"><strong>Circuito <?php echo $cmbcircuito; ?></strong></td>
	<?php 
		}
	else   { ?>
				<td colspan="8" align="center"><strong>Circuito <?php echo $cmbcircuito; ?></strong></td>		
	    <?php } ?>
	<td colspan="6" align="center"><strong>totales</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td  rowspan="2" align="center"><strong>Fecha</strong><strong></strong></td>
      <td  rowspan="2" align="center"><strong>Grupo</strong><strong></strong></td>
      <td colspan="2" align="center"><strong>Lado</strong></td>
	  <?php if ($opcion=='P')
	        {?>
			  <td  rowspan="2" align="center"><strong>Seleccion Inicial (%)</strong></td>
			  <td  rowspan="2" align="center"><strong>Recuperado (%)</strong></td>
			  <td  rowspan="2" align="center"><strong>Estandar (%)</strong></td>
		<?php } 
		else if ($opcion=='L')
		        { ?> 
				<td  rowspan="2" align="center"><strong>Produccion (Unid.)</strong></td>
				 <td  rowspan="2" align="center"><strong>Seleccion Inicial (Unid.)</strong></td>
			     <td  rowspan="2" align="center"><strong>Recuperado (Unid.)</strong></td>
			     <td  rowspan="2" align="center"><strong>Estandar (Unid.)</strong></td>
			<?php } ?> 
		<td rowspan="2" align="center"><strong>NE</strong></td>
		<td  rowspan="2" align="center"><strong>ND</strong></td>
		<td  rowspan="2" align="center"><strong>RA</strong></td>
		<td  rowspan="2" align="center"><strong>CS</strong></td>
		<td  rowspan="2" align="center"><strong>CL</strong></td>
		<td  rowspan="2" align="center"><strong>QU</strong></td>
		<td  rowspan="2" align="center"><strong>RE</strong></td>
		<td  rowspan="2" align="center"><strong>AI</strong></td>
		<td  rowspan="2" align="center"><strong>OT</strong></td>	
    </tr>
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td  align="center"><strong>Mar</strong></td>
      <td  align="center"><strong>Tierra</strong></td>
    </tr>
	<?php
	   $consulta="SELECT t1.fecha_produccion as fecha,t2.cod_circuito as circuito,t1.cod_grupo as grupo ";
       $consulta.="from sec_web.produccion_catodo as t1 ";
       $consulta.="INNER JOIN ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo ";
       $consulta.="where t1.fecha_produccion BETWEEN '".$FechaInicio."' and '".$FechaTermino."' and t2.cod_circuito='".$cmbcircuito."' ";
       $consulta.="and t1.cod_producto='18' and t1.cod_subproducto='1' ";
       $consulta.="GROUP by t1.fecha_produccion,t2.cod_circuito,t1.cod_grupo ";
       $consulta.="ORDER by t1.fecha_produccion,t2.cod_grupo ";
	   $respuesta = mysqli_query($link, $consulta);
	   $produccion_total=0;
	   $seleccion_inicial_total=0;
	   $recuperado_total=0;
	   $rechazado_total=0;
	   $total_ne=0;
	   $total_nd=0;
	   $total_ra=0;
	   $total_cs=0;
	   $total_cl=0;
	   $total_qu=0;
	   $total_re=0;
	   $total_ai=0;
	   $total_ot=0;
	   $total_rechazo=0;	   
 	   while ($fila = mysqli_fetch_array($respuesta))
	         { ?>
			    <tr onMouseOver="if(!this.contains(event.fromElement)){this.bgColor='class=ColorTabla02';} if(!document.all){style.cursor='pointer'};style.cursor='hand';" onMouseOut="if(!this.contains(event.toElement)){this.bgColor=''; }" >
				<?php
				echo "<td align='center' class=detalle01>".$fila["fecha"]."&nbsp</td>\n";
				echo "<td align='center' class=detalle02>".$fila["grupo"]."&nbsp</td>\n";
				/******************saca rechazos de tabla rechazo catodos de control de calidad*****************************************/
				$consulta2="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,";
				$consulta2.="sum(cordon_superior) as cs,sum(cordon_lateral) as cl,sum(quemados) as qu,sum(redondos) as re,";
				$consulta2.="sum(aire) as ai,sum(otros) as ot ";
				$consulta2.="from cal_web.rechazo_catodos where fecha='".$fila["fecha"]."' and grupo='".$fila["grupo"]."'";
				$respuesta2= mysqli_query($link, $consulta2);
				$fila2 = mysqli_fetch_array($respuesta2);
				$suma_rechazo=$fila2["ne"]+$fila2["nd"]+$fila2["ra"]+$fila2["cs"]+$fila2["cl"]+$fila2["ot"]+$fila2["qu"]+$fila2["re"]+$fila2["ai"];
				/***********************************************************************************************************************/
				/******************obtiene datos del grupo electrolitico 2 **********************************************************/
				$consulta_max_fecha_ge="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where cod_grupo='".$fila["grupo"]."' and fecha<='".$fila["fecha"]."' ";
				$respuesta_max_fecha_ge= mysqli_query($link, $consulta_max_fecha_ge);
				$row_max_fecha_ge = mysqli_fetch_array($respuesta_max_fecha_ge);
				$consulta_det_grupo = "select ifnull(cubas_descobrizacion,0) as cant_cuba, ifnull(num_cubas_tot,0) as num_cubas, ifnull(num_catodos_celdas,1) as num_catodos,ifnull(hojas_madres,0) as hojas_madres  from ref_web.grupo_electrolitico2 ";
			    $consulta_det_grupo = $consulta_det_grupo."where cod_grupo = '".$fila["grupo"]."' and  fecha = '".$row_max_fecha_ge["fecha"]."'";
			    $respuesta_det_grupo = mysqli_query($link, $consulta_det_grupo);
				$row_det_grupo = mysqli_fetch_array($respuesta_det_grupo);
				/**********************************************************************************************************************/
				$divisor=$row_det_grupo["num_cubas"]-$row_det_grupo["cant_cuba"];
				$divisor2=$row_det_grupo["num_cubas"]-$row_det_grupo["cant_cuba"]-$row_det_grupo["hojas_madres"];
				$divisor2=$divisor2*$row_det_grupo["num_catodos"];
				if ($opcion=='P')
				   {
					$seleccion_inicial=(($suma_rechazo+$fila2["recuperado_tot"])/$divisor2)*100;
					$porc_recuperado=(($fila2["recuperado_tot"]/$divisor2)*100);
					$total_por_rechazado=(($suma_rechazo/$divisor2)*100);
				   }
				 else if ($opcion=='L')
				         {
						  $seleccion_inicial=$suma_rechazo+$fila2["recuperado_tot"];
					      $porc_recuperado=$fila2["recuperado_tot"];
					      $total_por_rechazado=$suma_rechazo;
						 }  
				/************************************************************************/
				/*****************************************************************************/
				$arr_meses=array('Enero','Febrero_nor','Marzo','Abril','Mayo','Junio','Julio','Agosto','septiembre','Octubre','Noviembre','Diciembre');
				$arr_dias=array(31,28,31,30,31,30,31,31,30,31,30,31); 
				$ano_aux=intval(substr($fila["fecha"],0,4));
				$mes_aux=intval(substr($fila["fecha"],5,2));
				$calculo=$ano_aux/4;
				$calculo2=number_format($calculo,"0","","");
				$resto=$calculo2-$calculo;
				if ($resto==0)
					{$bisiesto='S';
					 $mes_dia=28;}
				else {$bisiesto='N';}
				$dia_aux=intval(substr($fila["fecha"],8,2));
				if ($dia_aux < 9)
				   { $restantes= 8-$dia_aux;
					 if ($mes_aux==1)
						{$mes_aux=strval(12);
						  $ano_aux=strval($ano_aux-1);
						  $dia_aux=$arr_dias[(intval($mes_aux))-1];
						  $dia_aux=strval($dia_aux-$restantes);}
					 else if (($mes_aux==3) and ($bisiesto=='N'))
							{$mes_aux=strval(2);
							 $dia_aux=$arr_dias[intval($mes_aux)-1];
							 $dia_aux=strval($dia_aux-$restantes);}
							else if (($mes_aux==3) and ($bisiesto=='S'))
								{$mes_aux=strval(2);
								  $dia_aux=strval($mes_dia-$restantes);} 	  
					 else{$mes_aux=strval(intval($mes_aux)-1);	
						  $dia_aux=$arr_dias[intval($mes_aux)-1];
						  $dia_aux=strval($dia_aux-$restantes);}
					}
				else{$dia_aux=strval($dia_aux-8);
					  $mes_aux=strval($mes_aux);
					  $ano_aux=strval($ano_aux);}		
				if (strlen($dia_aux)==1)
					{$dia_aux='0'.$dia_aux;}
				if (strlen($mes_aux)==1)
					{$mes_aux='0'.$mes_aux;}	
				
				$fecha_ant=$ano_aux."-".$mes_aux."-".$dia_aux;
				$cons_subp2="select distinct t1.cod_subproducto as producto, campo1 from sea_web.movimientos as t1 ";
				$cons_subp2=$cons_subp2."where t1.tipo_movimiento='2' and t1.campo2='".$fila["grupo"]."' and t1.fecha_movimiento='".$fecha_ant."' and t1.cod_producto='17' AND campo1 IN ('M','T') and t1.cod_subproducto not in ('08') group by t1.hornada";
				//echo $cons_subp2;
				$Resp_subp2 = mysqli_query($link, $cons_subp2);
				$Fila_subp2 = mysqli_fetch_array($Resp_subp2);
				$cons_subp="select distinct t1.cod_subproducto as producto, campo1 from sea_web.movimientos as t1 ";
				$cons_subp=$cons_subp."where t1.tipo_movimiento='2' and t1.campo2='".$fila["grupo"]."' and t1.fecha_movimiento='".$fila["fecha"]."' and t1.cod_producto='17' AND campo1 IN ('M','T') and t1.cod_subproducto not in ('08') group by t1.hornada";
				$Resp_subp = mysqli_query($link, $cons_subp);
				$Fila_subp = mysqli_fetch_array($Resp_subp);
				$producto = isset($Fila_subp["producto"])?$Fila_subp["producto"]:0;
				if ($producto==1)
					{
					if ($Fila_subp["campo1"]=='M' )
					   {
						 echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
						 echo h."</td>\n";
						 if ($Fila_subp2["producto"]==1)
					        {echo "<td align='center'>h&nbsp</td>\n";}
				         else if ($Fila_subp2["producto"]==4)
					             {echo "<td align='center'>V&nbsp</td>\n";}
				              else if ($Fila_subp2["producto"]==2)
					                  {echo "<td align='center'>T&nbsp</td>\n";}
				                   else if ($Fila_subp2["producto"]==3)
					                        {echo "<td align='center'>D&nbsp</td>\n";}
					                    else  {echo "<td align='center'>&nbsp</td>\n";}
					   }
					else if ($Fila_subp["campo1"]=='T' )
					        {
   						     if ($Fila_subp2["producto"]==1)
					            {echo "<td align='center'>h&nbsp</td>\n";}
				            else if ($Fila_subp2["producto"]==4)
					                {echo "<td align='center'>V&nbsp</td>\n";}
				                 else if ($Fila_subp2["producto"]==2)
					                     {echo "<td align='center'>T&nbsp</td>\n";}
				                      else if ($Fila_subp2["producto"]==3)
					                        {echo "<td align='center'>D&nbsp</td>\n";}
					                      else  {echo "<td align='center'>&nbsp</td>\n";}

						     echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
							 echo h."</td>\n";
							 
                            }   	 
					}
					
				else if ($producto==4)
					{
					 if ($Fila_subp["campo1"]=='M' )
					   {
						  echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
						  echo V."</td>\n";
						  if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							 else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				
                       }
					 else if ($Fila_subp["campo1"]=='T' )
					        {
							 if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							 else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				  					
							 echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
						     echo V."</td>\n";				
					        }
					
					}
				else if ($producto==2)
					{
					  if ($Fila_subp["campo1"]=='M' )
					   {
					    echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
					    echo T."</td>\n";
						if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							 else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				
					   }
					  else if ($Fila_subp["campo1"]=='T' )
					        {
							  if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							 else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				
	  					    echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
	  				        echo T."</td>\n";
				
							} 
					}
				else if ($producto==3)
					{
					   if ($Fila_subp["campo1"]=='M' )
					   {
						 echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
					     echo D."</td>\n";
						 if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							 else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				
					   }
					   else if ($Fila_subp["campo1"]=='T' )
					          {
							    if ($Fila_subp2["producto"]==1)
								{echo "<td align='center'>h&nbsp</td>\n";}
							    else if ($Fila_subp2["producto"]==4)
									 {echo "<td align='center'>V&nbsp</td>\n";}
								  else if ($Fila_subp2["producto"]==2)
										  {echo "<td align='center'>T&nbsp</td>\n";}
									   else if ($Fila_subp2["producto"]==3)
												{echo "<td align='center'>D&nbsp</td>\n";}
											else  {echo "<td align='center'>&nbsp</td>\n";}				
								echo "<td align='center' class=detalle01><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">\n";
					            echo D."</td>\n";			
							  }  	 
					}
					else  {
					       echo "<td align='center'>&nbsp</td>\n";
						  
						  }

				/*******************************************************************************/
				/*******************************************************************************/
				if ($opcion=='P')
				   {
					echo "<td align='center'>".number_format($seleccion_inicial,"2",".",",")."&nbsp</td>\n";
					echo "<td align='center'>".number_format($porc_recuperado,"2",".",",")."&nbsp</td>\n";
					echo "<td align='center'>".number_format($total_por_rechazado,"2",".",",")."&nbsp</td>\n";
					$consulta_rechazo="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,";
					$consulta_rechazo.="sum(cordon_superior) as cs,sum(cordon_lateral) as cl,sum(quemados) as qu,sum(redondos) as re,";
					$consulta_rechazo.="sum(aire) as ai,sum(otros) as ot , fecha from cal_web.rechazo_catodos ";
					$consulta_rechazo.=" where fecha ='".$fila["fecha"]."'  and grupo='".intval($fila["grupo"])."' group by fecha";
					$respuesta_rechazo = mysqli_query($link, $consulta_rechazo);
					$row_rechazo=mysqli_fetch_array($respuesta_rechazo);
						$ne=isset($row_rechazo["ne"])?$row_rechazo["ne"]:0;
						$nd=isset($row_rechazo["nd"])?$row_rechazo["nd"]:0;
						$ra=isset($row_rechazo["ra"])?$row_rechazo["ra"]:0;
						$cs=isset($row_rechazo["cs"])?$row_rechazo["cs"]:0;
						$cl=isset($row_rechazo["cl"])?$row_rechazo["cl"]:0;
						$qu=isset($row_rechazo["qu"])?$row_rechazo["qu"]:0;
						$re=isset($row_rechazo["re"])?$row_rechazo["re"]:0;
						$ai=isset($row_rechazo["ai"])?$row_rechazo["ai"]:0;
						$ot=isset($row_rechazo["ot"])?$row_rechazo["ot"]:0;
						
					echo "<td align='center'>".$ne."&nbsp</td>\n";
					echo "<td align='center'>".$nd."&nbsp</td>\n";
					echo "<td align='center'>".$ra."&nbsp</td>\n";
					echo "<td align='center'>".$cs."&nbsp</td>\n";
					echo "<td align='center'>".$cl."&nbsp</td>\n";
					echo "<td align='center'>".$qu."&nbsp</td>\n";
					echo "<td align='center'>".$re."&nbsp</td>\n";
					echo "<td align='center'>".$ai."&nbsp</td>\n";
					echo "<td align='center'>".$ot."&nbsp</td>\n";
					$rechazo_dia=$ne + $nd+$ra+$cs+$cl+$ot;
					$rechazo_dia=$rechazo_dia+$qu+$re+$ai;
					$total_ne=$total_ne+$ne;
					$total_nd=$total_ne+$nd;
					$total_ra=$total_ne+$ra;
					$total_cs=$total_ne+$cs;
					$total_cl=$total_ne+$cl;
					$total_qu=$total_ne+$qu;
					$total_re=$total_ne+$re;
					$total_ai=$total_ne+$ai;
					$total_ot=$total_ne+$ot;
					
					/*
					$rechazo_dia=$row_rechazo["ne"]+$row_rechazo["nd"]+$row_rechazo["ra"]+$row_rechazo["cs"]+$row_rechazo["cl"]+$row_rechazo["ot"];
					$rechazo_dia=$rechazo_dia+$row_rechazo["qu"]+$row_rechazo["re"]+$row_rechazo["ai"];
					$total_ne=$total_ne+$row_rechazo["ne"];
					$total_nd=$total_ne+$row_rechazo["nd"];
					$total_ra=$total_ne+$row_rechazo["ra"];
					$total_cs=$total_ne+$row_rechazo["cs"];
					$total_cl=$total_ne+$row_rechazo["cl"];
					$total_qu=$total_ne+$row_rechazo["qu"];
					$total_re=$total_ne+$row_rechazo["re"];
					$total_ai=$total_ne+$row_rechazo["ai"];
					$total_ot=$total_ne+$row_rechazo["ot"];
					*/
				   }
			   else if ($opcion=='L')
			           {
					    echo "<td align='center'>".$divisor2."&nbsp</td>\n";
						$produccion_total=$produccion_total+$divisor2;
					    echo "<td align='center'>".$seleccion_inicial."&nbsp</td>\n";
						$seleccion_inicial_total=$seleccion_inicial_total+$seleccion_inicial;
					    echo "<td align='center'>".$porc_recuperado."&nbsp</td>\n";
						$recuperado_total=$recuperado_total+$porc_recuperado;
					    echo "<td align='center'>".$total_por_rechazado."&nbsp</td>\n";
						$rechazado_total=$rechazado_total+$total_por_rechazado;
						$consulta_rechazo="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,sum(rayado) as ra,sum(cordon_superior) as cs,sum(cordon_lateral) as cl,";
						$consulta_rechazo.="sum(quemados) as qu,sum(redondos) as re,sum(aire) as ai,sum(otros) as ot , fecha from cal_web.rechazo_catodos ";
		  				$consulta_rechazo.=" where fecha ='".$fila["fecha"]."'  and grupo='".intval($fila["grupo"])."' group by fecha";
		  				$respuesta_rechazo = mysqli_query($link, $consulta_rechazo);
						$row_rechazo=mysqli_fetch_array($respuesta_rechazo);
						$ne=isset($row_rechazo["ne"])?$row_rechazo["ne"]:0;
						$nd=isset($row_rechazo["nd"])?$row_rechazo["nd"]:0;
						$ra=isset($row_rechazo["ra"])?$row_rechazo["ra"]:0;
						$cs=isset($row_rechazo["cs"])?$row_rechazo["cs"]:0;
						$cl=isset($row_rechazo["cl"])?$row_rechazo["cl"]:0;
						$qu=isset($row_rechazo["qu"])?$row_rechazo["qu"]:0;
						$re=isset($row_rechazo["re"])?$row_rechazo["re"]:0;
						$ai=isset($row_rechazo["ai"])?$row_rechazo["ai"]:0;
						$ot=isset($row_rechazo["ot"])?$row_rechazo["ot"]:0;
						
						echo "<td align='center'>".$ne."&nbsp</td>\n";
						echo "<td align='center'>".$nd."&nbsp</td>\n";
						echo "<td align='center'>".$ra."&nbsp</td>\n";
						echo "<td align='center'>".$cs."&nbsp</td>\n";
						echo "<td align='center'>".$cl."&nbsp</td>\n";
						echo "<td align='center'>".$qu."&nbsp</td>\n";
						echo "<td align='center'>".$re."&nbsp</td>\n";
						echo "<td align='center'>".$ai."&nbsp</td>\n";
						echo "<td align='center'>".$ot."&nbsp</td>\n";
						$rechazo_dia=$ne + $nd+$ra+$cs+$cl+$ot;
						$rechazo_dia=$rechazo_dia+$qu+$re+$ai;
						$total_ne=$total_ne+$ne;
						$total_nd=$total_nd+$nd;
						$total_ra=$total_ra+$ra;
						$total_cs=$total_cs+$cs;
						$total_cl=$total_cl+$cl;
						$total_qu=$total_qu+$qu;
						$total_re=$total_re+$re;
						$total_ai=$total_ai+$ai;
						$total_ot=$total_ot+$ot;
						
						$total_rechazo=$total_rechazo+$rechazo_dia;
					   }
			  echo '</tr>';		     	
			 }
			if ($opcion=='L')
				{ 
					echo '<tr class="ColorTabla01">';
					echo '<td align="center" colspan="4"><strong>Totales&nbsp</strong></td>';
					echo "<td align='center'><strong>".$produccion_total."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$seleccion_inicial_total."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$recuperado_total."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$rechazado_total."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$total_ne."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$total_nd."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$total_ra."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$total_cs."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$total_cl."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$total_qu."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$total_re."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$total_ai."&nbsp</strong></td>\n";
					echo "<td align='center'><strong>".$total_ot."&nbsp</strong></td>\n";
					echo '</tr>'; 
			 	}
	?>
  </table>
  <?php } 
  else { ?>
 <?php 
		  $consulta_circuito="select * from sec_web.circuitos";
		  $respuesta_circuito=mysqli_query($link, $consulta_circuito);
		  $produccion_total=0;
		  $seleccion_inicial_total=0;
		  $recuperado_total=0;
		  $rechazado_total=0;
		  while ($row_circuito=mysqli_fetch_array($respuesta_circuito))
			  {
?>	
				<br><table border="1">
				<?php
					if ($row_circuito["cod_circuito"]=='01')
					{
					//si es todos los circuitos que coloque titulo cuando sea circuito=01
				?>	   	<tr>
   	  					<td colspan="7" align="center"><strong>INFORME DE CLASIFICACION FISICA DE CATODOS COMERCIALES</strong></td>
    					</tr> 
						<tr>
							<td colspan="3"><strong>Fecha Inicio : <?php echo $FechaInicio; ?></strong></td>
							<td colspan="4"><strong>Fecha Termino : <?php echo $FechaTermino; ?></strong></td>
						</tr>
				<?php
					}
				?>		
					
					
			<?php		echo '<tr>';
					if ($opcion=='P')
						{
							echo '<td colspan="7" align="center"><strong>'.$row_circuito["descripcion_circuito"].'</strong></td>';
						}
					else {echo '<td colspan="8" align="center"><strong>'.$row_circuito["descripcion_circuito"].'</strong></td>';}		
					echo '</tr>';
					echo '<tr>';
					echo '<td rowspan="2" align="center"><strong>Fecha</strong><strong></strong></td>';
					echo '<td rowspan="2" align="center"><strong>Grupo</strong><strong></strong></td>';
					echo '<td colspan="2" align="center"><strong>Lado</strong></td>';
					if ($opcion=='P')
					   {
						echo '<td rowspan="2" align="center"><strong>Seleccion Inicial (%)</strong></td>';
						echo '<td rowspan="2" align="center"><strong>Recuperado (%)</strong></td>';
						echo '<td rowspan="2" align="center"><strong>Estandar (%)</strong></td>';
					   }
					else if ($opcion=='L')
					        { 
							 echo '<td  rowspan="2" align="center"><strong>Produccion (Unid.)</strong></td>';
					          echo '<td rowspan="2" align="center"><strong>Seleccion Inicial (Unid.)</strong></td>';
						      echo '<td rowspan="2" align="center"><strong>Recuperado (Unid.)</strong></td>';
						      echo '<td  rowspan="2" align="center"><strong>Estandar (Unid.)</strong></td>';
						    }  
					echo '</tr>';
					echo '<tr>';
					echo '<td align="center"><strong>Mar</strong></td>';
					echo '<td align="center"><strong>Tierra</strong></td>';
					echo '</tr>';
					   $consulta="SELECT t1.fecha_produccion as fecha,t2.cod_circuito as circuito,t1.cod_grupo as grupo ";
					   $consulta.="from sec_web.produccion_catodo as t1 ";
					   $consulta.="INNER JOIN ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo ";
					   $consulta.="where t1.fecha_produccion BETWEEN '".$FechaInicio."' and '".$FechaTermino."' and t2.cod_circuito='".$row_circuito["cod_circuito"]."' ";
					   $consulta.="and t1.cod_producto='18' and t1.cod_subproducto='1' ";
					   $consulta.="GROUP by t1.fecha_produccion,t2.cod_circuito,t1.cod_grupo ";
					   $consulta.="ORDER by t1.fecha_produccion,t2.cod_grupo ";
					   $respuesta = mysqli_query($link, $consulta);
					   $produccion_total=0;
					   $seleccion_inicial_total=0;
					   $recuperado_total=0;
					   $rechazado_total=0;
					   while ($fila = mysqli_fetch_array($respuesta))
							 {
								echo "<tr>";
								echo '<td colspan="1">'.$fila["fecha"].'</td>';
								echo '<td  colspan="1">'.$fila["grupo"].'</td>';
								/******************saca rechazos de tabla rechazo catodos de control de calidad*****************************************/
								$consulta2="select sum(unid_recup) as recuperado_tot,sum(estampa) as ne,sum(dispersos) as nd,";
								$consulta2.="sum(rayado) as ra,sum(cordon_superior) as cs,sum(cordon_lateral) as cl,sum(quemados) as qu,";
								$consulta2.="sum(redondos) as re,sum(aire) as ai,sum(otros) as ot ";
								$consulta2.="from cal_web.rechazo_catodos where fecha='".$fila["fecha"]."' and grupo='".$fila["grupo"]."'";
								$respuesta2= mysqli_query($link, $consulta2);
								$fila2 = mysqli_fetch_array($respuesta2);
								$suma_rechazo=$fila2["ne"]+$fila2["nd"]+$fila2["ra"]+$fila2["cs"]+$fila2["cl"]+$fila2["qu"]+$fila2["re"]+$fila2["ai"]+$fila2["ot"];
								/***********************************************************************************************************************/
								/******************obtiene datos del grupo electrolitico 2 **********************************************************/
								$consulta_max_fecha_ge="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where cod_grupo='".$fila["grupo"]."' and fecha<='".$fila["fecha"]."' ";
								$respuesta_max_fecha_ge= mysqli_query($link, $consulta_max_fecha_ge);
								$row_max_fecha_ge = mysqli_fetch_array($respuesta_max_fecha_ge);
								$consulta_det_grupo = "select ifnull(cubas_descobrizacion,0) as cant_cuba, ifnull(num_cubas_tot,0) as num_cubas, ifnull(num_catodos_celdas,1) as num_catodos,ifnull(hojas_madres,0) as hojas_madres  from ref_web.grupo_electrolitico2 ";
								$consulta_det_grupo = $consulta_det_grupo."where cod_grupo = '".$fila["grupo"]."' and  fecha = '".$row_max_fecha_ge["fecha"]."'";
								$respuesta_det_grupo = mysqli_query($link, $consulta_det_grupo);
								$row_det_grupo = mysqli_fetch_array($respuesta_det_grupo);
								/**********************************************************************************************************************/
								$divisor=$row_det_grupo["num_cubas"]-$row_det_grupo["cant_cuba"];
								$divisor2=$row_det_grupo["num_cubas"]-$row_det_grupo["cant_cuba"]-$row_det_grupo["hojas_madres"];
								$divisor2=$divisor2*$row_det_grupo["num_catodos"];
								if ($opcion=='P')
								   {
									$seleccion_inicial=(($suma_rechazo+$fila2["recuperado_tot"])/$divisor2)*100;
									$porc_recuperado=(($fila2["recuperado_tot"]/($divisor*$row_det_grupo["num_catodos"]))*100);
									$total_por_rechazado=(($suma_rechazo/($divisor*$row_det_grupo["num_catodos"]))*100);
								   }
								 else if ($opcion=='L')
								         {
										   $seleccion_inicial=$suma_rechazo+$fila2["recuperado_tot"];
									       $porc_recuperado=$fila2["recuperado_tot"];
									       $total_por_rechazado=$suma_rechazo;
										 }  	
								/************************************************************************/
								/*****************************************************************************/
								$arr_meses=array('Enero','Febrero_nor','Marzo','Abril','Mayo','Junio','Julio','Agosto','septiembre','Octubre','Noviembre','Diciembre');
								$arr_dias=array(31,28,31,30,31,30,31,31,30,31,30,31); 
								$ano_aux=intval(substr($fila["fecha"],0,4));
								$mes_aux=intval(substr($fila["fecha"],5,2));
								$calculo=$ano_aux/4;
								$calculo2=number_format($calculo,"0","","");
								$resto=$calculo2-$calculo;
								if ($resto==0)
									{$bisiesto='S';
									 $mes_dia=28;}
								else {$bisiesto='N';}
								$dia_aux=intval(substr($fila["fecha"],8,2));
								if ($dia_aux < 9)
								   { $restantes= 8-$dia_aux;
									 if ($mes_aux==1)
										{$mes_aux=strval(12);
										  $ano_aux=strval($ano_aux-1);
										  $dia_aux=$arr_dias[(intval($mes_aux))-1];
										  $dia_aux=strval($dia_aux-$restantes);}
									 else if (($mes_aux==3) and ($bisiesto=='N'))
											{$mes_aux=strval(2);
											 $dia_aux=$arr_dias[intval($mes_aux)-1];
											 $dia_aux=strval($dia_aux-$restantes);}
											else if (($mes_aux==3) and ($bisiesto=='S'))
												{$mes_aux=strval(2);
												  $dia_aux=strval($mes_dia-$restantes);} 	  
									 else{$mes_aux=strval(intval($mes_aux)-1);	
										  $dia_aux=$arr_dias[intval($mes_aux)-1];
										  $dia_aux=strval($dia_aux-$restantes);}
									}
								else{$dia_aux=strval($dia_aux-8);
									  $mes_aux=strval($mes_aux);
									  $ano_aux=strval($ano_aux);}		
								if (strlen($dia_aux)==1)
									{$dia_aux='0'.$dia_aux;}
								if (strlen($mes_aux)==1)
									{$mes_aux='0'.$mes_aux;}	
								
								$fecha_ant=$ano_aux."-".$mes_aux."-".$dia_aux;
								$cons_subp2="select distinct t1.cod_subproducto as producto, campo1 from sea_web.movimientos as t1 ";
								$cons_subp2=$cons_subp2."where t1.tipo_movimiento='2' and t1.campo2='".$fila["grupo"]."' and t1.fecha_movimiento='".$fecha_ant."' and t1.cod_producto='17' AND campo1 IN ('M','T') and t1.cod_subproducto not in ('08') group by t1.hornada";
								//echo $cons_subp2;
								$Resp_subp2 = mysqli_query($link, $cons_subp2);
								$Fila_subp2 = mysqli_fetch_array($Resp_subp2);
								$cons_subp="select distinct t1.cod_subproducto as producto, campo1 from sea_web.movimientos as t1 ";
								$cons_subp=$cons_subp."where t1.tipo_movimiento='2' and t1.campo2='".$fila["grupo"]."' and t1.fecha_movimiento='".$fila["fecha"]."' and t1.cod_producto='17' AND campo1 IN ('M','T') and t1.cod_subproducto not in ('08') group by t1.hornada";
								$Resp_subp = mysqli_query($link, $cons_subp);
								$Fila_subp = mysqli_fetch_array($Resp_subp);
								if ($Fila_subp["producto"]==1)
									{
									if ($Fila_subp["campo1"]=='M' )
									   {
										 echo "<td><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">";
										 echo h."</td>";
										 if ($Fila_subp2["producto"]==1)
											{echo "<td >h&nbsp</td>";}
										 else if ($Fila_subp2["producto"]==4)
												 {echo "<td >V&nbsp</td>";}
											  else if ($Fila_subp2["producto"]==2)
													  {echo "<td >T&nbsp</td>";}
												   else if ($Fila_subp2["producto"]==3)
															{echo "<td >D&nbsp</td>";}
														else  {echo "<td>&nbsp</td>";}
									   }
									else if ($Fila_subp["campo1"]=='T' )
											{
											 if ($Fila_subp2["producto"]==1)
												{echo "<td >h&nbsp</td>";}
											else if ($Fila_subp2["producto"]==4)
													{echo "<td >V&nbsp</td>";}
												 else if ($Fila_subp2["producto"]==2)
														 {echo "<td>T&nbsp</td>";}
													  else if ($Fila_subp2["producto"]==3)
															{echo "<td>D&nbsp</td>";}
														  else  {echo "<td >&nbsp</td>";}
				
											 echo "<td><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">";
											 echo h."</td>\n";
											 
											}   	 
									}
									
								else if ($Fila_subp["producto"]==4)
									{
									 if ($Fila_subp["campo1"]=='M' )
									   {
										  echo "<td ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">";
										  echo V."</td>";
										  if ($Fila_subp2["producto"]==1)
												{echo "<td >h&nbsp</td>";}
											 else if ($Fila_subp2["producto"]==4)
													 {echo "<td>V&nbsp</td>";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td >T&nbsp</td>";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td >D&nbsp</td>";}
															else  {echo "<td >&nbsp</td>";}				
									   }
									 else if ($Fila_subp["campo1"]=='T' )
											{
											 if ($Fila_subp2["producto"]==1)
												{echo "<td >h&nbsp</td>";}
											 else if ($Fila_subp2["producto"]==4)
													 {echo "<td >V&nbsp</td>";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td >T&nbsp</td>";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td >D&nbsp</td>";}
															else  {echo "<td >&nbsp</td>";}				  					
											 echo "<td><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">";
											 echo V."</td>";				
											}
									
									}
								else if ($Fila_subp["producto"]==2)
									{
									  if ($Fila_subp["campo1"]=='M' )
									   {
										echo "<td ><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">";
										echo T."</td>\n";
										if ($Fila_subp2["producto"]==1)
												{echo "<td >h&nbsp</td>";}
											 else if ($Fila_subp2["producto"]==4)
													 {echo "<td>V&nbsp</td>";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td>T&nbsp</td>";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td >D&nbsp</td>";}
															else  {echo "<td >&nbsp</td>";}				
									   }
									  else if ($Fila_subp["campo1"]=='T' )
											{
											  if ($Fila_subp2["producto"]==1)
												{echo "<td >h&nbsp</td>";}
											 else if ($Fila_subp2["producto"]==4)
													 {echo "<td >V&nbsp</td>";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td >T&nbsp</td>";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td>D&nbsp</td>";}
															else  {echo "<td >&nbsp</td>";}				
											echo "<td><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">";
											echo T."</td>";
								
											} 
									}
								else if ($Fila_subp["producto"]==3)
									{
									   if ($Fila_subp["campo1"]=='M' )
									   {
										 echo "<td><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">";
										 echo D."</td>\n";
										 if ($Fila_subp2["producto"]==1)
												{echo "<td>h&nbsp</td>";}
											 else if ($Fila_subp2["producto"]==4)
													 {echo "<td>V&nbsp</td>";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td >T&nbsp</td>";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td >D&nbsp</td>";}
															else  {echo "<td>&nbsp</td>";}				
									   }
									   else if ($Fila_subp["campo1"]=='T' )
											  {
												if ($Fila_subp2["producto"]==1)
												{echo "<td>h&nbsp</td>";}
												else if ($Fila_subp2["producto"]==4)
													 {echo "<td>V&nbsp</td>";}
												  else if ($Fila_subp2["producto"]==2)
														  {echo "<td>T&nbsp</td>";}
													   else if ($Fila_subp2["producto"]==3)
																{echo "<td>D&nbsp</td>";}
															else  {echo "<td>&nbsp</td>";}				
												echo "<td><font color='blue'><a href=\"JavaScript:detalle_anodos('".$fila["fecha"]."','".$fila["grupo"]."')\">";
												echo D."</td>\n";			
											  }  	 
									}
									else  {
										   echo "<td>&nbsp</td>";
										  
										  }
				
								/*******************************************************************************/
								/*******************************************************************************/
								if ($opcion=='P')
								    {
									  echo "<td>".number_format($seleccion_inicial,"2",".",",")."&nbsp</td>";
									  echo "<td>".number_format($porc_recuperado,"2",".",",")."&nbsp</td>";
									  echo "<td>".number_format($total_por_rechazado,"2",".",",")."&nbsp</td>";
									}
							    else if ($opcion=='L')
								        {
										 	echo "<td>".$divisor2."&nbsp</td>";
											$produccion_total=$produccion_total+$divisor2;
											echo "<td>".$seleccion_inicial."&nbsp</td>";
											$seleccion_inicial_total=$seleccion_inicial_total+$seleccion_inicial;
											echo "<td>".$porc_recuperado."&nbsp</td>";
											$recuperado_total=$recuperado_total+$porc_recuperado;
											echo "<td>".$total_por_rechazado."&nbsp</td>";
											$rechazado_total=$rechazado_total+$total_por_rechazado;
										}
												  
							 }
							 if ($opcion=='L')
								{ 
									echo '<tr>';
									echo '<td colspan="4"><strong>Totales&nbsp</strong></td>';
									echo "<td><strong>".$produccion_total."&nbsp</strong></td>";
									echo "<td><strong>".$seleccion_inicial_total."&nbsp</strong></td>";
									echo "<td><strong>".$recuperado_total."&nbsp</strong></td>";
									echo "<td><strong>".$rechazado_total."&nbsp</strong></td>";
									echo '</tr>'; 
							   }
							
				  echo '</table>';

			 }		  
  }
  ?>
  
  
</form>
</body>
</html>
