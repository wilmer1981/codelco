<?php include("../principal/conectar_sea_web.php") ?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Consultar(f)
{
	linea = "mostrar=S&fecha=" + f.ano.value + "-" + f.mes.value + "-" + f.dia.value;
	f.action = "sea_con_encina.php?" + linea;
	f.submit();
}
</script>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">
	  
	  <table width="700" border="0" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="142">Fecha</td>
            <td width="246"><font size="2"> 
              <select name="dia" size="1">
                <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia))			
					echo "<option selected value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo "<option selected value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
              </select>
              </font> <font size="2"> 
              <select name="mes" size="1" id="select7">
                <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($mostrar != "S"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
              </select>
              <select name="ano" size="1">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano))
					echo "<option selected value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
              </select>
              </font></td>
            <td width="312"><input name="btnconsultar" type="button" value="Consultar" onClick="Consultar(this.form)"></td>
          </tr>
        </table>
        <br>
        <table width="290" border="1" cellspacing="0" cellpadding="3">
          <tr>
            <td width="50">Grupo</td>
            <td width="80">Hornada</td>
            <td width="80">Lado</td>
            <td width="80">Unidades</td>
            <td width="80">Peso</td>
          </tr>
          </table> 
	<?php        	
		if ($mostrar == "S")
		{
		
			$grupos1 = array(); //numero_recarga = 0, (Todavia no se realiza produccion).
			$grupos2 = array(); //numero_recarga = 1, (Se hizo produccion).
			
			$consulta = "SELECT cod_subclase AS grupo FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2009 ORDER BY cod_subclase";
			$rs = mysqli_query($link, $consulta);
			
			while ($row = mysqli_fetch_array($rs))
			{
				$dias = 0;
				$sw = false;		
				while ($sw == false)
				{
					$consulta = "SELECT campo2,fecha_movimiento,numero_recarga FROM sea_web.movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 2 AND";
					$consulta = $consulta." fecha_movimiento = SUBDATE('".$fecha."', INTERVAL ".$dias." DAY) AND campo2 = '".$row["grupo"]."'";
					$consulta = $consulta." GROUP BY campo2";
					//echo $consulta."<br>";
					
					$rs1 = mysqli_query($link, $consulta);
					
					if ($row1 = mysqli_fetch_array($rs1))					
					{
						if ($row1[numero_recarga] == 0)
							$grupos1[$row1[campo2]] = $row1["fecha_movimiento"];						
						else						
							$grupos2[$row1[campo2]] = $row1["fecha_movimiento"];
						
						
						$sw = true; //Encntro el primer registo, ya sea, si fue producido ó no.
					}
					$dias++;
				}
			}
			
			echo '<table width="700" border="0" cellspacing="0" cellpadding="3">';			
			echo '<tr>';
            echo '<td>DATOS QUE NO HAN SIDO PRODUCIDOS</td>';
          	echo '</tr>';
			echo '</table>';			
			
			reset($grupos1);
			while (list($c,$v) = each($grupos1))
			{
				$consulta = "SELECT * FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 2 AND fecha_movimiento = '".$v."' AND numero_recarga = 0";
				$consulta = $consulta." AND campo2 = '".$c."'";
				$consulta = $consulta." ORDER BY SUBSTRING(hornada,6,6)";				
				//echo $consulta."<br>";
				$rs3 = mysqli_query($link, $consulta);

				echo '<br><table width="290" border="1" cellspacing="0" cellpadding="3">';							
				while ($row3 = mysqli_fetch_array($rs3))
				{						
					echo '<tr>';
    		        echo '<td width="50">'.$row3[campo2].'</td>';
        		    echo '<td width="80">'.substr($row3["hornada"],6,6).'</td>';
            		echo '<td width="80">'.$row3[campo1].'</td>';
	            	echo '<td width="80">'.$row3["unidades"].'</td>';
	    	        echo '<td width="80">'.$row3["peso"].'</td>';
    	    	  	echo '</tr>';
				}
				echo '</table>';			
			}
			
			
			
			echo '<table width="700" border="0" cellspacing="0" cellpadding="3">';			
			echo '<tr>';
            echo '<td>DATOS QUE HAN SIDO PRODUCIDOS</td>';
          	echo '</tr>';
			echo '</table>';			
			
			reset($grupos2);
			while (list($c,$v) = each($grupos2))
			{
				$consulta = "SELECT * FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 2 AND fecha_movimiento = '".$v."' AND numero_recarga = 0";
				$consulta = $consulta." AND campo2 = '".$c."'";
				$consulta = $consulta." ORDER BY SUBSTRING(hornada,6,6)";
				//echo $consulta."<br>";
				$rs4 = mysqli_query($link, $consulta);

				echo '<br><table width="290" border="1" cellspacing="0" cellpadding="3">';							
				while ($row4 = mysqli_fetch_array($rs4))
				{						
					echo '<tr>';
    		        echo '<td width="50">'.$row4[campo2].'</td>';
        		    echo '<td width="80">'.substr($row4["hornada"],6,6).'</td>';
            		echo '<td width="80">'.$row4[campo1].'</td>';
	            	echo '<td width="80">'.$row4["unidades"].'</td>';
	    	        echo '<td width="80">'.$row4["peso"].'</td>';
    	    	  	echo '</tr>';
				}
				echo '</table>';			
			}
		}
	?>

        <br>
        <table width="700" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="center"><input name="btnsalir" type="button" id="btnsalir" value="Salir"></td>
          </tr>
        </table> </td>
</tr>
</table>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>