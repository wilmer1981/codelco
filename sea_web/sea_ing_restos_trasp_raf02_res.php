<?php include("../principal/conectar_sea_web.php")?>

<html>
<head>
<title>Busqueda de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function buscar_datos()
{
var f = frmPoPup;

    f.action="sea_ing_restos_trasp_raf02.php?Proceso=B";
	f.submit();
}


</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <div align="left"> 
    <table cellpadding="3" cellspacing="0" width="500" border="0" bordercolor="#b26c4a" class="TablaPrincipal" >
      <tr class="ColorTabla02"> 
        <td colspan="3"><div align="center">Busqueda de Datos</div></td>
      </tr>
      <tr> 
        <td width="108" height="32">Fecha Busqueda</td>
        <td width="213"><font color="#000000" size="2">&nbsp; </font><font color="#000000" size="2"> 
          <SELECT name="dia" size="1" style="font-face:verdana;font-size:10">
            <?php
			if($Proceso=='B')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
			}
			else
			{
				for ($i=1;$i<=31;$i++)
				{
	   				   if ($i==date("j"))
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
          </SELECT>
          </font> <font color="#000000" size="2"> 
          <SELECT name="mes" size="1" id="SELECT7" style="FONT-FACE:verdana;FONT-SIZE:10">
            <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==date("n"))
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
          </SELECT>
          <SELECT name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
            <?php
	if($Proceso=='B')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
          </SELECT>
          </font><font color="#000000" size="2">&nbsp; </font></td>
        <td width="159"><input name="buscar" type="button" style="width:70" value="Buscar" onClick="buscar_datos();"></td>
      </tr>
    </table>
<?php
if($Proceso == 'B')
{
$fecha = $ano.'-'.$mes.'-'.$dia;
$fecha2 = date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano));
$FechaInicio=$ano.'-'.$mes.'-'.$dia." 08:00:00";
$FechaTermino =date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano))." 07:59:59";

echo '<table width="500"  border="1" cellspacing="0" cellpadding="0" align="center"><tr class="ColorTabla01">';
echo '<td width="100" align="center">FECHA</td>';
echo '<td width="100" align="center">HORNADA</td>';
echo '<td width="100" align="center">GRUPO</td>';
echo '<td width="100"align="center">CANTIDAD</td>';
echo '<td width="100" align="center">PESO<br>KGS.</td></tr>';

	$TotalCantidad = 0;
	$TotalPeso = 0;
/*		
	$consulta = "SELECT DISTINCT CASE WHEN LENGTH(campo2)=1 THEN CONCAT('0',campo2) ELSE campo2 END AS grupo , campo2,fecha_benef";
	$consulta = $consulta." FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 19";
	$consulta = $consulta." AND fecha_movimiento = '".$fecha."'";
    $consulta = $consulta." ORDER BY grupo";
*/
	$consulta = "SELECT campo2,fecha_benef, hornada, CASE WHEN LENGTH(campo2)=1 THEN CONCAT('0',campo2) ELSE campo2 END AS grupo";
	$consulta.= " FROM sea_web.movimientos";
	$consulta.= " WHERE tipo_movimiento = 4 AND cod_producto = 19 AND fecha_movimiento between '".$fecha."' and '".$fecha2."'";
	$consulta.= " and hora between '".$FechaInicio."' and '".$FechaTermino."' ";
	$consulta.= " GROUP BY campo2, fecha_benef, hornada";
	$consulta.= " ORDER BY grupo";	
	//echo $consulta."<br>";
	$rs2 = mysqli_query($link, $consulta);		
						

			//Crea el detalle.					
			while ($row2 = mysqli_fetch_array($rs2))
			{												 

				echo '<tr><td width="100"><center>'.$fecha.'</center></td>';
				echo '<td width="100"><center>'.substr($row2[hornada],6,6).'</center>';
				echo '<td width="100" align="center">'.$row2[campo2].'</td>';

				echo '<td width="100" align="center">';

				$consulta = "SELECT SUM(unidades) as unidades FROM movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 19";
				$consulta = $consulta." AND campo2 = '".$row2[campo2]."' and hornada = '".$row2[hornada]."' AND fecha_movimiento between '".$fecha."' and '".$fecha2."' AND fecha_benef = '".$row2[fecha_benef]."'";
				$consulta = $consulta." and hora between '".$FechaInicio."' and '".$FechaTermino."'";
				//echo $consulta."<br>";
				$rs_u = mysqli_query($link, $consulta);
				if($row_u = mysqli_fetch_array($rs_u))
				{ 
					echo $row_u["unidades"].'</td>';
					$TotalCantidad = $TotalCantidad + $row_u["unidades"];
                }

				echo '<td width="100" align="center">';

				$consulta = "SELECT SUM(peso) as peso FROM movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 19";
				$consulta = $consulta." AND campo2 = '".$row2[campo2]."' and hornada = '".$row2[hornada]."'  AND fecha_movimiento between '".$fecha."' and '".$fecha2."' AND fecha_benef = '".$row2[fecha_benef]."'";
				$consulta = $consulta." and hora between '".$FechaInicio."' and '".$FechaTermino."'";
				$rs_p = mysqli_query($link, $consulta);
				
				if($row_p = mysqli_fetch_array($rs_p))
				{ 
					echo $row_p["peso"].'</td>';
					$TotalPeso = $TotalPeso + $row_p["peso"];
				}
			}
			echo '<tr class="ColorTabla02">';
			echo '<td width="300" align="left" colspan="3">&nbsp;TOTAL DIA </td>';
			echo '<td width="100" align="center">'.$TotalCantidad.'</td>';
			echo '<td width="100" align="center">'.$TotalPeso.'</td></tr>';
	     	echo '</table><br>';
			
}
?>	
  </table>
  </div>
  
  <div align="left" style="position:absolute; top: 475px; left: 24px;">
    <table cellpadding="3" cellspacing="0" width="500" border="0" align="center">
      <tr>
        <td> <div align="center"> 
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="self.close()">
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
