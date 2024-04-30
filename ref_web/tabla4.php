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
$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";
$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";

?>

<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="form1">
	             <table width="100%" border="1">
                <tr align="center"> 
                  <td colspan="15"><strong>4.-CALIDAD FISICA Y QUIMICA CATODOS COMERCIALES </strong></td>
                </tr>
                <tr> 
                  <td width="60" align="center"><p><strong>GRUPO</strong></p>
				  <p><strong><&nbsp;</strong></p></td>
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
		/*if ($Sig=='S')
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
		$fecha=$ano1."-".$mes1."-".$dia1;*/
		if (strlen($dia) == 1)
		{
			$dia = '0'.$dia;
		}
		if (strlen($mes) ==1) 
  		{
			$mes = '0'.$mes;
		}
		$fecha=$ano.'-'.$mes.'-'.$dia;

		
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
		$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_producto='18'  and t1.cod_subproducto='1' and t2.fecha <= '".$fecha."'group by t1.cod_grupo";
					
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>";
		    echo "<td align='left'>".$Fila["cod_grupo"]."&nbsp</td>";
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
				$fecha2 = isset($Fila_fecha["fecha2"])?$Fila_fecha["fecha2"]:"";
				if (($Fila["cod_grupo"]=='01') or ($Fila["cod_grupo"]=='02') or ($Fila["cod_grupo"]=='03') or ($Fila["cod_grupo"]=='04') or ($Fila["cod_grupo"]=='05') or ($Fila["cod_grupo"]=='06') or ($Fila["cod_grupo"]=='07') or ($Fila["cod_grupo"]=='08') or($Fila["cod_grupo"]=='09'))
				{
    				$Consulta_electrolitos="select ifnull(t1.valor,0) as valor,t1.candado,t1.cod_unidad,t1.cod_leyes,signo from cal_web.leyes_por_solicitud as t1 ";
					$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
					$Consulta_electrolitos=$Consulta_electrolitos."where (t1.id_muestra='".$Fila["cod_grupo"]."' or t1.id_muestra='$grupo_aux') and t1.cod_producto='18' and left(t1.fecha_hora,10)='".$fecha2."' and t1.cod_leyes in ('04','05','08','09','10','26','27','30','31','36','39','40','44','48') and t1.cod_subproducto='1'";
	 			}
				
				else
				{
					$Consulta_electrolitos="select  ifnull(t1.valor,0) as valor,t1.candado,t1.cod_unidad,t1.cod_leyes,signo from cal_web.leyes_por_solicitud as t1 ";
					$Consulta_electrolitos=$Consulta_electrolitos."inner join cal_web.solicitud_analisis as t2 on  t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_funcionario=t2.rut_funcionario ";
					$Consulta_electrolitos=$Consulta_electrolitos."where t1.id_muestra='".$Fila["cod_grupo"]."'  and t1.cod_producto='18' and left(t1.fecha_hora,10)='".$fecha2."' and t1.cod_leyes in ('04','05','08','09','10','26','27','30','31','36','39','40','44','48') and t1.cod_subproducto='1'";
				}	
				$Respuesta_electrolitos = mysqli_query($link, $Consulta_electrolitos);
				//echo "con".$Consulta_electrolitos;
				while ($Fila_electrolitos = mysqli_fetch_array($Respuesta_electrolitos))
				{  
					
					if ($Fila_electrolitos["valor"] < 0)
					{
					
						$total=number_format($Fila_electrolitos["valor"],"2","","");
						
						if ($Fila_electrolitos["signo"] !='=')
                        {
							
							echo "<td align='center'>".$Fila_electrolitos["signo"]."$total&nbsp</td>";
							$poly =($Fila_electrolitos["signo"].$total);
						}
						else 
						{
							
							echo "<td align='center'>$total&nbsp</td>";
							$poly =($Fila_electrolitos["signo"].$total);

						} 
					}
					else
					{
						
						
						$total=number_format($Fila_electrolitos["valor"],"2","","");
						if ($Fila_electrolitos["signo"]=="<")
						{
							$s="- ";	
							
						//echo "siii".$s;
						}
						else
						{
							$s=$Fila_electrolitos["signo"];
						}	
						//echo "<td align='left'>".$Fila_electrolitos["signo"].".$s</td>";
						echo "<td align='center'>".$s.$total."</td>";
						$poly =($Fila_electrolitos["signo"]."-".$total);
					
						
					}
				}
				//echo "grupo:".$Fila["cod_grupo"];

				if ($total ==0)
				{
					
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
					echo "<td align='center'>&nbsp</td>";
				
				}
			$total = 0;		
			
		echo "</tr>\n";
		}
	?>
	</table>
	<table align="center" width="100%" border="1">
    	<tr> 
			<td colspan="15" align="center">&nbsp;Nota : Signo - (= Menor que)</td>
		</tr>
	</table>		

</form>
</body>
</html>
			  

