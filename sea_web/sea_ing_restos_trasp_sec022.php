<?php 
include("../principal/conectar_sea_web.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$dia = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
	$mes = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
	$ano = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");

?>

<html>
<head>
<title>Busqueda de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function buscar_datos()
{
var f = frmPoPup;

    f.action="sea_ing_restos_trasp_sec022.php?Proceso=B";
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
          <select name="dia" size="1" style="font-face:verdana;font-size:10">
            <?php
			if($Proceso=='B')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option selected value= '".$i."'>".$i."</option>";
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
						echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
          </select>
          </font> <font color="#000000" size="2"> 
          <select name="mes" size="1" id="select7" style="FONT-FACE:verdana;FONT-SIZE:10">
            <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
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
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
          </select>
          <select name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
            <?php
	if($Proceso=='B')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano)
			{
			echo "<option selected value ='$i'>$i</option>";
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
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
          </select>
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
	$consulta ="select hornada,grupo,fecha_movimiento,sum(unidades) as unidades, sum(peso) as peso";
	$consulta.=" from sea_web.restos_a_sec where cod_producto = 19 and fecha_movimiento = '".$fecha."'";
	$consulta.=" group by hornada,grupo,fecha_movimiento,cod_subproducto";
	$rs2 = mysqli_query($link, $consulta);	
	//echo mysql_num_rows($rs2);

	while ($row2 = mysqli_fetch_array($rs2))
	{			
		echo '<tr>';									 
		echo '<td width="100"><center>'.$row2["fecha_movimiento"].'</center></td>';
		echo '<td width="100"><center>'.$row2["hornada"].'</center></td>';
		echo '<td width="100" align="center">'.$row2["grupo"].'</td>';
		echo '<td width="100" align="center">'.$row2["unidades"].'</td>';
		echo '<td width="100" align="center">'.$row2["peso"].'</td>';
		echo '</tr>';
		$TotalPeso = $TotalPeso + $row2["peso"];
		$TotalCantidad = $TotalCantidad + $row2["unidades"];
	
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
