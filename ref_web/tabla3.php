<?php 
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename="";
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

	$dia1     = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");
	$mes1     = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
	$ano1     = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");
	$fecha    = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
?>

<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="form1">   
	<table width="80%" border="1">
   		<tr align="center"> 
    		<td colspan="6"><strong>3.-CONFECCION CATODOS INICIALES</strong></td>
    </tr>
    <tr> 
    	<td width="9%" rowspan="2" align="center"><strong>TURNO</strong></td>
        <td width="17%" align="center"><strong>PRODUCCION</strong></td>
        <td width="24%"  align="center"><strong>PRODUCCION</strong></td>
        <td width="16%"  align="center"><strong>PRODUCCION</strong></td>
        <td width="40%" rowspan="2" align="center"><strong>CONSUMO COMERCIAL</strong></td>
		
        <td width="21%" rowspan="2" align="center"><strong>OBSERVACIONES</strong></td>
	</tr>
    <tr> 
    	<td width="40%" rowspan="1" align="center"><strong>MFCI</strong></td>
		<td  width="40%" rowspan="1"  align="center"><strong>MCB</strong></td>
    	<td  width="40%" rowspan="1"  align="center"><strong>MCO</strong></td>

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

	$total_consumo_comercial=0;
	$Consulta =  "select max(t2.fecha) as fecha,t2.cod_grupo,t2.cod_circuito from sec_web.produccion_catodo as t1 ";
	$Consulta = $Consulta." inner join ref_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
	$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_producto='18'  and t1.cod_subproducto='1'   and t2.fecha <= '".$fecha."'group by t1.cod_grupo";
	$Respuesta = mysqli_query($link,$Consulta);
	$total_prod=0;
	$total_scrap=0;
	$total_rec=0;
	$total_rech=0;
	$total_cuba=0;
	$cont=0;
	$i=0;
	$p=0;
	$grupos=array();
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
	        $cont=$cont+1;
			$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";
			$respuesta_turno= mysqli_query($link,$Consulta_turno);
			$row_turno = mysqli_fetch_array($respuesta_turno);
				//aqui sacar dias de renovacion  del grupo  poly 2005-01-31
			$j=0;
			$anomes=substr($fecha,0,8);
			$fechita=$anomes.'01';
			$cod_grupo = isset($Fila["cod_grupo"])?$Fila["cod_grupo"]:"";
			$turno1    = isset($row_turno["turno1"])?$row_turno["turno1"]:"";
			$con="select dia_renovacion as dia_renovacion from  sec_web.renovacion_prog_prod";
			$con.=" where cod_grupo = '".$cod_grupo."' and cod_concepto = '".$turno1."'";
			$con.=" and fecha_renovacion ='".$fechita."'"; 	
			$Respuestap = mysqli_query($link,$con);
			$dia1=0;$dia2=0;
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
			$Respuesta_produccion = mysqli_query($link,$consulta_produccion);
			$Fila_produccion = mysqli_fetch_array($Respuesta_produccion);
			$produccion=number_format($Fila_produccion["produccion"],2,",",".");

			//aqui saca los grupos en un arreglo igual lo tengo que hacer yo
		
			$grupos[$i]=$Fila["cod_grupo"];
			$turno1 = isset($row_turno["turno1"])?$row_turno["turno1"]:"";
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
			$total_dp=0;
			$total_ew=0;
			$total_A=0;$total_B=0;
			$fecha_renovacion="0000-00-00";
			$Dia_r="00";
			$mostrar2='S';
			if ($mostrar=='S')
			 {
			 	reset ($grupos);
			 }
			$i=0;
			if ($mostrar=='S')
			{
				foreach($grupos as $a=>$b)
				{ 
					
						
					$Dia_r=substr($fecha,8,2);
					$Mes_r=substr($fecha,5,2);
					$Ano_r=substr($fecha,0,4);
					$fecha_renovacion=$Ano_r.'-'.$Mes_r.'-01';
					$consulta_datos="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
					$consulta_datos.="where fecha_renovacion='".$fecha_renovacion."' ";
					$consulta_datos.="and dia_renovacion='".$Dia_r."' and cod_grupo=$b and (cod_concepto='A' or cod_concepto='B')";
					$Resp_datos = mysqli_query($link,$consulta_datos);
					if ($row_datos = mysqli_fetch_array($Resp_datos))
					{
						 
						$consulta_fecha= " select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <= '".$fecha."' and cod_grupo='$b'";
						$respuesta_fecha=mysqli_query($link,$consulta_fecha);
						$row_fecha = mysqli_fetch_array($respuesta_fecha);
						$consulta_datos_grupo="select fecha,num_cubas_tot,cubas_descobrizacion,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
						$consulta_datos_grupo.=" where fecha ='".$row_fecha[fecha]."' and cod_grupo='$b'";
						$respuesta_datos_grupo=mysqli_query($link,$consulta_datos_grupo);
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
					$respuesta_desc=mysqli_query($link,$consulta_desc);
					if ($row_desc = mysqli_fetch_array($respuesta_desc))
					{
						$consulta_dp="select num_celdas_grupos,num_catodos_celda from ref_web.circuitos_especiales where cod_circuito='DP'";
						$respuesta_dp=mysqli_query($link,$consulta_dp);
						$row_dp = mysqli_fetch_array($respuesta_dp);
						$total_dp=$total_dp+($row_dp["num_celdas_grupos"]*$row_dp["num_catodos_celda"]);
					}
					
					$consulta_ew="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
					$consulta_ew.="where fecha_renovacion='".$fecha_renovacion."' ";
					$consulta_ew.="and dia_renovacion='".$Dia_r."' and cod_grupo=$b and electro_win<>'' ";
					$respuesta_ew=mysqli_query($link,$consulta_ew);
					if ($row_desc = mysqli_fetch_array($respuesta_ew))
					{
						$consulta_ew_d="select num_celdas_grupos,num_catodos_celda from ref_web.circuitos_especiales where cod_circuito='EW'";
						$respuesta_ew_d=mysqli_query($link,$consulta_ew_d);
						$row_ew_d = mysqli_fetch_array($respuesta_ew_d);
						$total_ew=$total_ew+($row_ew_d["num_celdas_grupos"]*$row_ew_d["num_catodos_celda"]);
					}
				}//fin del while
				$consulta_cat_ini="select turno as turno_cat_ini,ifnull(produccion_mfci,0) as prod_mfci,ifnull(produccion_mdb,0) as prod_mdb,ifnull(produccion_mco,0) as prod_mco,observacion as observacion,consumo as consumo_cat_inil from ref_web.iniciales as t1 ";
				$consulta_cat_ini=$consulta_cat_ini."where  t1.fecha = '".$fecha."' order by t1.turno";
				$Resp_cat_ini = mysqli_query($link,$consulta_cat_ini);
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
							echo "<td align='center'>&nbsp;</td>";
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
					echo "<td align='right'><strong>Total</strong></td>";
					echo "<td align='center'>$total_mfci</td>";
					echo "<td align='center'>$total_mdb</td>";
					echo "<td align='center'>$total_mco</td>";
					echo "<td align='center'>$total_consumo_comercial</td>";
					echo "<td align='center'>--</td>";
		}		
	?>
    </table>
   	
  <table width="80%" border="1">
  
    <?php
		
		if ($total_dp != 0)
		{
	?>
    		<tr>
        		<td width="30%"><strong>TOTAL CONSUMO DP</strong></td>
				<?php
						
					  echo "<td width='30%' align='center'>".$total_dp."</td>";
				?>
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
            	<td colspan="5" width="30%"><strong>TOTAL CONSUMO EW</strong></td>
				<?php
						echo "<td width='30% align='center'>".$total_ew."</td>";
				?>
			</tr>
	<?php
		}
	?> 
	<?php       
		
		$consulta_desc="select cod_grupo, cod_concepto from sec_web.renovacion_prog_prod ";
		$consulta_desc.="where fecha_renovacion='".$fecha_renovacion."' ";
		$consulta_desc.="and dia_renovacion='".$Dia_r."' and cod_concepto='D' and cod_grupo<>'' ";
		$respuesta_desc=mysqli_query($link,$consulta_desc);
		$total_normal_grupo=0;
		while ($row_desc = mysqli_fetch_array($respuesta_desc))
		{
			$consulta_fecha= " select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <= '".$fecha."' and cod_grupo='".$row_desc["cod_grupo"]."'";
			$respuesta_fecha=mysqli_query($link,$consulta_fecha);
			$row_fecha = mysqli_fetch_array($respuesta_fecha);
			$consulta_datos_grupo="select fecha,num_cubas_tot,cubas_descobrizacion,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
			$consulta_datos_grupo.=" where fecha ='".$row_fecha["fecha"]."' and cod_grupo='".$row_desc["cod_grupo"]."'";
			$respuesta_datos_grupo=mysqli_query($link,$consulta_datos_grupo);
			$row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
			$total_normal_grupo=$total_normal_grupo+($row_datos_grupo["cubas_descobrizacion"] * $row_datos_grupo["num_catodos_celdas"]);
		}
			$total_consumo_total=$total_A + $total_B + $total_normal_grupo + $total_ew + $total_dp;
			
			
		if ($total_normal_grupo !=0)
		{
		?>
			<tr>
				<td width="30%"><strong>TOTAL CONSUMO DESC. NORMAL</strong></td>
					 <?php
					  		echo "<td colspan='1' width='30%' align='center'>".$total_normal_grupo."</td>";
					?>
			</tr>   
		<?php
		}
		if ($total_consumo_total !=0)
		{
		?>
			<tr>
				<td colspan="1" width="30%"><strong>TOTAL CONSUMO  </strong></td>
				
				<?php
				  		echo "<td width='30%' align='center'>".$total_consumo_total."</td>";
				?>
			</tr>   
		<?php
		}
		?>
        <tr><td width="30%"><strong>STOCK CATODOS (8:00) </strong></td>
        
          <?php 	
			$consulta_cat_ini_stock="select sum(stock) as stock1, sum(rechazo_cat_ini) as rechazo_ini_cat, catodos_en_renovacion from  ref_web.detalle_iniciales as t1 ";
			$consulta_cat_ini_stock=$consulta_cat_ini_stock."where  t1.fecha = '".$fecha."' group by t1.fecha";
			$Resp_cat_stock = mysqli_query($link,$consulta_cat_ini_stock);
			$row_cat_stock = mysqli_fetch_array($Resp_cat_stock);
			$stock1 = isset($row_cat_stock["stock1"])?$row_cat_stock["stock1"]:0;
			if ($stock1 >0)
			{
				echo "<td width='30%' align='center'>".$row_cat_stock["stock1"]."</td>";
			}
			else
			{
				echo "<td width='30%' align='center'>0</td>";
			}	
		?>
    		</tr>
			<tr><td width="30%"><strong>STOCK LAMINAS (8:00) </strong></td>
            	
            	<?php 
				$rechazo_ini_cat =isset($row_cat_stock["rechazo_ini_cat"])?$row_cat_stock["rechazo_ini_cat"]:0;
				$catodos_en_renovacion =isset($row_cat_stock["catodos_en_renovacion"])?$row_cat_stock["catodos_en_renovacion"]:0;
				
					$consulta_lam_ini_stock="select stock_dia from  ref_web.stock_diario as t1 ";
					$consulta_lam_ini_stock=$consulta_lam_ini_stock."where  t1.fecha = '".$fecha."' ";
					$Resp_lam_stock = mysqli_query($link,$consulta_lam_ini_stock);
					$row_lam_stock = mysqli_fetch_array($Resp_lam_stock);
					$stock_dia = isset($row_lam_stock["stock_dia"])?$row_lam_stock["stock_dia"]:0;
					if ($stock_dia >0)
					{
						echo "<td width='30%' align='center'>".$row_lam_stock["stock_dia"]."</td>";
					}
					else
					{
						echo "<td width='30%' align='center'>0</td>";
					}	
				?>
                </tr>

                <tr> 
                  <td width="30%"><strong>RECHAZO CATODOS INICIALES</strong></td>                
					<?php $rechazo_catodos= $rechazo_ini_cat + $catodos_en_renovacion;
					 	echo "<td width='30%' align='center'>".$rechazo_catodos."</td>";
					?> 	
                </tr>
								   
</table>
</form>
</body>
</html>
