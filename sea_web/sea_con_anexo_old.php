<?php 
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 14;
?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2";
}
/***************/
function Consultar(f)
{
	f.action = "sea_con_anexo.php?mostrar=S";
	f.submit(); 
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" align="center" valign="middle">
	  
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="123" height="23">Fecha </td>
            <td width="191"> <SELECT name="mes" size="1" id="SELECT7">
                <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes))
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($mostrar != "S"))
						echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
              </SELECT> <SELECT name="ano" size="1">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano))
					echo "<option SELECTed value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo "<option SELECTed value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
              </SELECT> </td>
            <td width="365"><input name="btnconsultar" type="button" value="Consultar" onClick="Consultar(this.form)"></td>
          </tr>
        </table>
        <br>

	<?php
		if ($mostrar == "S")
		{
        	echo '<table width="650" height="25" border="0" cellpadding="0" cellspacing="0" class="ColorTabla01">';
          	echo '<tr>';
            echo '<td width="100" align="center">Flujo</td>';
            echo '<td width="100" align="center">Peso</td>';
            echo '<td width="100" align="center">Fino Cu</td>';
            echo '<td width="100" align="center">Fino Ag</td>';
            echo '<td width="100" align="center">Fino Au</td>';
            echo '<td width="50" align="center">% Cu</td>';
            echo '<td width="50" align="center">g/t Ag</td>';
            echo '<td width="50" align="center">g/t Au</td>';			
    	    echo '</tr>';
	        echo '</table>';
 		
			echo '<table width="650" border="1" cellspacing="0" cellpadding="0">';
			
			$consulta = "SELECT * FROM sea_web.stock_anexo WHERE ano = ".$ano." AND mes = ".$mes;
			$consulta = $consulta." ORDER BY flujo";
			
			$rs = mysqli_query($link, $consulta);
			
			while ($row = mysqli_fetch_array($rs))
			{			
				if ($row["peso"] != 0)
				{
					echo '<tr>';
					echo '<td width="100" height="20" align="center">'.$row["flujo"].'</td>';
					echo '<td width="100" align="center">'.number_format($row["peso"],0,'','').'</td>';
					echo '<td width="100" align="center">'.number_format($row[fino_cu],0,'','').'</td>';
					echo '<td width="100" align="center">'.number_format($row["fino_ag"],0,'','').'</td>';
					echo '<td width="100" align="center">'.number_format($row[fino_au],0,'','').'</td>';				
					echo '<td width="50" align="center">'.round(($row[fino_cu] / $row["peso"] * 100),2).'</td>';
					echo '<td width="50" align="center">'.round(($row["fino_ag"] / $row["peso"] * 1000),2).'</td>';
					echo '<td width="50" align="center">'.round(($row[fino_au] / $row["peso"] * 1000),2).'</td>';				
					echo '</tr>';
				}
			}
			echo '</table><br><br>';
			
			//nodos
        	echo '<table width="650" height="25" border="0" cellpadding="0" cellspacing="0" class="ColorTabla01">';
          	echo '<tr>';
            echo '<td width="100" align="center">Flujo</td>';
            echo '<td width="100" align="center">Peso</td>';
            echo '<td width="100" align="center">Fino Cu</td>';
            echo '<td width="100" align="center">Fino Ag</td>';
            echo '<td width="100" align="center">Fino Au</td>';
            echo '<td width="50" align="center">% Cu</td>';
            echo '<td width="50" align="center">g/t Ag</td>';
            echo '<td width="50" align="center">g/t Au</td>';			
    	    echo '</tr>';
	        echo '</table>';
 		
			echo '<table width="650" border="1" cellspacing="0" cellpadding="0">';
			
			$consulta = "SELECT * FROM sea_web.existencia_nodo WHERE ano = ".$ano." AND mes = ".$mes;
			$consulta = $consulta." ORDER BY nodo";
			
			$rs = mysqli_query($link, $consulta);
			
			while ($row = mysqli_fetch_array($rs))
			{			
				if ($row["peso"] != 0)
				{
					echo '<tr>';
					echo '<td width="100" height="20" align="center">'.$row[nodo].'</td>';
					echo '<td width="100" align="center">'.number_format($row["peso"],0,'','').'</td>';
					echo '<td width="100" align="center">'.number_format($row[fino_cu],0,'','').'</td>';
					echo '<td width="100" align="center">'.number_format($row["fino_ag"],0,'','').'</td>';
					echo '<td width="100" align="center">'.number_format($row[fino_au],0,'','').'</td>';				
					echo '<td width="50" align="center">'.round(($row[fino_cu] / $row["peso"] * 100),2).'</td>';
					echo '<td width="50" align="center">'.round(($row["fino_ag"] / $row["peso"] * 1000),2).'</td>';
					echo '<td width="50" align="center">'.round(($row[fino_au] / $row["peso"] * 1000),2).'</td>';				
					echo '</tr>';
				}
			}
			echo '</table><br><br>';			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
/*			
			
			//Saca los Nodos.
			echo '<table width="650" height="25" border="0" cellpadding="0" cellspacing="0" class="ColorTabla01">';
			echo '<tr>';
            echo '<td width="100" align="center">Nodo</td>';
            echo '<td width="100" align="center">Peso</td>';
            echo '<td width="100" align="center">Fino Cu</td>';
            echo '<td width="100" align="center">Fino Ag</td>';
            echo '<td width="100" align="center">Fino Au</td>';
            echo '<td width="50" align="center">% Cu</td>';
            echo '<td width="50" align="center">g/t Ag</td>';
            echo '<td width="50" align="center">g/t Au</td>';			
          	echo '</tr>';
       		echo '</table>';
													
			
			echo '<table width="650" border="1" cellspacing="0" cellpadding="0">';
			
			$consulta = "SELECT DISTINCT nodo FROM proyecto_modernizacion.flujos WHERE sistema = 'SEA' ORDER BY nodo";
			$rs1 = mysqli_query($link, $consulta);
			
			while ($row1 = mysqli_fetch_array($rs1))
			{	
				$mes_aux = $mes - 1;
				$ano_aux = $ano;
			
				if ($mes == 0)
				{
					$mes_aux = 12;
					$ano_aux = $ano - 1;
				}
				
				//Existencias del Mes Pasado
				$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, IFNULL(SUM(fino_cu),0) AS fino_cu, IFNULL(SUM(fino_ag),0) AS fino_ag, IFNULL(SUM(fino_au),0) AS fino_au";
				$consulta = $consulta."	FROM sea_web.existencia_nodo";
				$consulta = $consulta." WHERE nodo = ".$row1[nodo]." AND ano = ".$ano_aux." AND mes = ".$mes_aux;
				$rs2 = mysqli_query($link, $consulta);
				$row2 = mysqli_fetch_array($rs2);
			
				//Entradas.
				$consulta = "SELECT SUM(peso) AS peso, SUM(fino_cu) AS fino_cu, SUM(fino_ag) AS fino_ag, SUM(fino_au) AS fino_au";
				$consulta = $consulta." FROM sea_web.stock_anexo AS t1";
				$consulta = $consulta." INNER JOIN proyecto_modernizacion.flujos AS t2";
				$consulta = $consulta." ON t1.flujo = t2.cod_flujo";
				$consulta = $consulta." WHERE mes = ".$mes." AND ano = ".$ano." AND t2.nodo = ".$row1[nodo]." AND tipo = 'E'";
				$rs3 = mysqli_query($link, $consulta);
				$row3 = mysqli_fetch_array($rs3);	
				
				//Salidas.
				$consulta = "SELECT SUM(peso) AS peso, SUM(fino_cu) AS fino_cu, SUM(fino_ag) AS fino_ag, SUM(fino_au) AS fino_au";
				$consulta = $consulta." FROM sea_web.stock_anexo AS t1";
				$consulta = $consulta." INNER JOIN proyecto_modernizacion.flujos AS t2";
				$consulta = $consulta." ON t1.flujo = t2.cod_flujo";
				$consulta = $consulta." WHERE mes = ".$mes." AND ano = ".$ano." AND t2.nodo = ".$row1[nodo]." AND tipo = 'S'";
				$rs4 = mysqli_query($link, $consulta);				 
				$row4 = mysqli_fetch_array($rs4);
				
				
				$peso = ($row2["peso"] + $row3["peso"] - $row4["peso"]);
				$fino_cu = ($row2[fino_cu] + $row3[fino_cu] - $row4[fino_cu]);
				$fino_ag = ($row2["fino_ag"] + $row3["fino_ag"] - $row4["fino_ag"]);
				$fino_au = ($row2[fino_au] + $row3[fino_au] - $row4[fino_au]);
			
				if ($peso != 0)
				{
					echo '<tr>';
					echo '<td width="100" height="20" align="center">'.$row1[nodo].'</td>';
					echo '<td width="100" align="center">'.$peso.'</td>';
					echo '<td width="100" align="center">'.$fino_cu.'</td>';
					echo '<td width="100" align="center">'.$fino_ag.'</td>';
					echo '<td width="100" align="center">'.$fino_au.'</td>';
					echo '<td width="50" align="center">'.round(($fino_cu / $peso * 100),2).'</td>';
					echo '<td width="50" align="center">'.round(($fino_ag / $peso * 1000),2).'</td>';
					echo '<td width="50" align="center">'.round(($fino_au / $peso * 1000),2).'</td>';				
					echo '</tr>';				
				}
			}
			echo '</table>';
*/			
		}
	?>

        <br>
  <table width="400" border="0" cellspacing="0" cellpadding="3">
    <tr>
            <td height="29" align="center"> 
              <input name="btnsalir" type="button" value="Salir" style="width=70;" onClick="JavaScript:Salir()"></td>
    </tr>
  </table>
</td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>