<?php 
	include("../principal/conectar_sec_web.php");
	header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>

<html>
<head>
<title>Programa de Renovacion</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
</script>
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  
  <table width="770" height="500" border="1" cellpadding="5" cellspacing="0" class="TablaPrincipal" align="center">
    <tr>
      <td width="762" align="center" valign="middle"> 
        <div style="position:absolute; left: 11px; top: 34px; width: 730px; height: 30px;" id="div1"> 
          <table width="730" border="1" cellspacing="0" cellpadding="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
			  <td width="65" align="center">Fecha</td>
              <td width="70" align="center">TA</td>
              <td width="85" align="center">TB</td>
			  <td width="85" align="center">TC</td> 
              <td width="72" align="center">Desc. Normal.</td>
              <td width="66" align="center">Desc. Parcial</td>
              <td width="77" align="center">Exper.</td>
          </tr>
          </table>
 
 </div>
 
		
        <div style="position:absolute; left: 10px; top: 74px; width: 751px; height: 423px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="1" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php	
	if ($opcion=="H")
	  {
			if (strlen($mes1)==1)
			{
				//$mes1 = strval($mes1);
				$mes1 = "0".$mes1;
			}
			$fecha = $ano1."-".$mes1;
			$fecha2 = $fecha;
			$consulta_fecha = "SELECT distinct fecha_renovacion, dia_renovacion ";
			$consulta_fecha.= " from sec_web.renovacion_prog_prod ";
			$consulta_fecha.= " where dia_renovacion between '1' ";
			$consulta_fecha.= " and '31' and fecha_renovacion = '".$fecha."-01' ";
			//$consulta_fecha.= " and cod_grupo <> ''";
			$consulta_fecha.= " order by fecha_renovacion, dia_renovacion ";
			$rss = mysqli_query($link, $consulta_fecha);
            $datos = 'F';
			while ($rows = mysqli_fetch_array($rss))		  
				{
                  if ($rows[fecha_renovacion]<>"")
					if (strlen($rows[dia_renovacion])==1)
						$rows[dia_renovacion]='0'.$rows[dia_renovacion];
					$fecha=	substr($rows[fecha_renovacion],0,8).$rows[dia_renovacion];

					echo '<tr>';
					echo '<td width="70" align="center">'.substr($fecha,0,7)."-".$rows[dia_renovacion].'</td>';

                    $consulta="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta=$consulta."where dia_renovacion=".$rows[dia_renovacion]." and fecha_renovacion like '".$fecha2."%' and cod_concepto='A' order by dia_renovacion,cod_grupo";
                    $respuesta = mysqli_query($link, $consulta);
                    $i=0;
                    while($row = mysqli_fetch_array($respuesta))
                       {$arreglo[$i]=$row["cod_grupo"];
                        $i++;}
                    echo '<td width="70" align="center">'.$arreglo[0].'-'.$arreglo[1].'-'.$arreglo[2].'&nbsp;</td>';
                    $consulta2="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta2=$consulta2."where dia_renovacion=".$rows[dia_renovacion]." and fecha_renovacion like '".$fecha2."%' and cod_concepto='B' order by dia_renovacion,cod_grupo";
                    $respuesta2 = mysqli_query($link, $consulta2);
                    $i=0;
                    while($row2 = mysqli_fetch_array($respuesta2))
                       {$arreglo2[$i]=$row2["cod_grupo"];
                        $i++;}
                    echo '<td width="70" align="center">'.$arreglo2[0].'-'.$arreglo2[1].'-'.$arreglo2[2].'&nbsp;</td>';
					//concepto =c
					$consulta22="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta22=$consulta22."where dia_renovacion=".$rows[dia_renovacion]." and fecha_renovacion like '".$fecha2."%' and cod_concepto='C' order by dia_renovacion,cod_grupo";
                    $respuesta22 = mysqli_query($link, $consulta22);
                    $i=0;
                    while($row22 = mysqli_fetch_array($respuesta22))
                       {$arreglo22[$i]=$row22["cod_grupo"];
                        $i++;}
                    echo '<td width="70" align="center">'.$arreglo22[0].'-'.$arreglo22[1].'-'.$arreglo22[2].'&nbsp;</td>';

					
					
                    $consulta3="select cod_grupo from sec_web.renovacion_prog_prod ";
                    $consulta3=$consulta3."where dia_renovacion='".$rows[dia_renovacion]."' and fecha_renovacion like '".$fecha2."%' and cod_concepto='D' order by dia_renovacion,fila_renovacion,cod_grupo";
                    $respuesta3 = mysqli_query($link, $consulta3);
					//echo "con".$consulta3;
                    $i=0;
                    while($row3 = mysqli_fetch_array($respuesta3))
                       {
                           if  ($row3["cod_grupo"]=="")
                             {$arreglo3[$i]=" ";}
                            else $arreglo3[$i]=$row3["cod_grupo"];
                        $i++;}
                    echo '<td width="70" align="center">'.$arreglo3[0].' '.$arreglo3[1].' '.$arreglo3[2].'&nbsp;</td>';
                    $consulta4="select distinct dia_renovacion,desc_parcial from sec_web.renovacion_prog_prod ";
                    $consulta4=$consulta4."where fila_renovacion='1' and dia_renovacion='".$rows[dia_renovacion]."' and fecha_renovacion like '".$fecha2."%'";
                    $respuesta = mysqli_query($link, $consulta4);
                    $rowe = mysqli_fetch_array($respuesta);
                    if ($rowe[desc_parcial]=="")
                       {$rowe[desc_parcial]='-';}
				    echo '<td width="70" align="center">'.$rowe[desc_parcial].'&nbsp;</td>';
                    $consulta5="select distinct dia_renovacion,electro_win from sec_web.renovacion_prog_prod ";
                    $consulta5=$consulta5."where fila_renovacion='1' and dia_renovacion='".$rows[dia_renovacion]."' and fecha_renovacion like '".$fecha2."%'";
                    $respuesta5 = mysqli_query($link, $consulta5);
                    $rowe = mysqli_fetch_array($respuesta5);
                    if ($rowe[electro_win]=="")
                       {$rowe[electro_win]='-';}
                    echo '<td width="70" align="center">'.$rowe[electro_win].'&nbsp;</td>';
                   	echo '</tr>';
                    $datos='V';
				}
		}		
?>
</table> 
</div>       
<div style="position:absolute; left: 12px; width: 730px; height: 26px; top: 515px;" id="div3">
<table width="730" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
</table>
</div>
</td>
</tr>
</table>
</form>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php"); ?>
