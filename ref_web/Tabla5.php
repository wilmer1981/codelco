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

$mostrar = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$grupo   = isset($_REQUEST["grupo"])?$_REQUEST["grupo"]:"";
$dia1    = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:"";
$mes1    = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
$ano1    = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";

?>

<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="form1">
	<table width="87%" border="1" cellpadding="2">
    	<tr align="center"  class="ColorTabla01"> 
        	<td colspan="12"><strong>5.-RENOVACION ELECTRODOS</strong></td>
       	</tr>
    	<tr> 
        	<td width="12%" rowspan="2" align="center"><strong>CIRCUITO</strong></td>
            <td width="9%" rowspan="2" align="center"><strong>GRUPO</strong></td>
            <td colspan="2" align="center"><strong>TIPO DE ANODOS</strong></td>
            <td colspan="8" align="center"><strong>COMPOSICION ANODO NUEVO (PPM)</strong></td>
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
  	$mostrar="S";
		if ($mostrar == "S")
		{
			$limites=array(1500,500,15,30,150,300,50,2000);
			
			
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
			$grupos=array(); //WSO
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				$grupos[$i]=$Fila["cod_grupo"];
				$i=$i+1;
			}			
			
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
				}else{
						
					if ($Fila2["calculo"] >= $limites[$l])
					{
						echo "<td align='center'><font color='red'><strong> ".number_format($Fila2["calculo"],"",",","")."&nbsp</strong></fornt></td>\n";
					}	 
					else
					{				
						echo "<td align='center'>".number_format($Fila2["calculo"],"",",","")."&nbsp</td>\n";
						
					}
					$l=$l+1;	
				}	 	
			}
			echo "</tr>\n";
			}
		}	
	?>
	</table>

</form>
</body>
</html>
			  
