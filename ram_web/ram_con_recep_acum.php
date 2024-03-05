<?php include("../principal/conectar_rec_web.php")?>

<html>
<head>
<title>Detalle Conjunto</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function Imprimir()
{
	window.print();
}


</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <div align="center"> 
    
  <table cellpadding="3" cellspacing="0" width="470" border="0" bordercolor="#b26c4a" class="TablaPrincipal" >
    <tr class="ColorTabla01"> 
      <td colspan="2" align="center"> 
        <?php	

		if($cod_exist == 2 || $cod_exist == 22)
			  echo "Recepci�n Conjunto";
		if($cod_exist == 6)
		      echo "Traspaso Conjunto";
		if($cod_exist == 17)
		      echo "Traspaso desde Conjunto";
		if($cod_exist == 5)
		      echo "Embarque";
		if($cod_exist == 15)
		      echo "Traspaso a Conjunto";
	  ?>
      </td>
    </tr>
    <tr> 
      <td width="108" height="26">N&uacute;mero Conjunto :</td>
      <td width="328"> <strong> 
        <?php
	     echo $Conjunto;
	  ?>
        </strong> </td>
    </tr>
  </table>
  <br>
  <table cellpadding="3" cellspacing="0" width="470" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
  	<tr class="ColorTabla01">

  <?php
	if($cod_exist == 2)
	{
	  echo'
  	    <tr class="ColorTabla01">
        <td width="70" align="center">Fecha</td>
	    <td width="120" align="center">Guia</td>
	    <td width="53" align="center">Patente</td>
	    <td width="44" align="center">Lote</td>
	    <td width="45" align="center">Recargo</td>
	    <td width="44" align="center">Peso</td>';
    }
	elseif($cod_exist == 17 || $cod_exist == 6)
	{
	echo'
		<td width="71" align="center">Fecha</td>	
		<td width="56" align="center">Cod Exist</td>';
		if($cod_exist == 17)
			echo'<td width="63" align="center">Conj. Origen</td>';
		else
		{
			echo'<td width="63" align="center">Conj. Dest</td>';
 		    echo'<td width="68" align="center">Lugar Dest.</td>';
		}	
		echo'<td width="50" align="center">Peso </td>	
		<td width="50" align="center">Validacion</td>';	
	}		

	elseif($cod_exist == 22 || $cod_exist == 5 || $cod_exist == 15)
	{
	echo'
		<td width="140" align="center">Fecha</td>	
		<td width="60" align="center">Cod Exist</td>	
		<td width="80" align="center">Conj. Dest.</td>
		<td width="80" align="center">Peso </td>';	
	}		

  ?>		
	</tr>
  <?php
  	//Recepciones
	if($cod_exist == 2)
	{
		$Fecha_ini = substr($Fecha_ini,0,10);
		$Fecha_ter = substr($Fecha_ter,0,10);

		$Consulta = "SELECT * FROM sipa_web.recepciones WHERE CONJUNTO = $Conjunto AND FECHA BETWEEN '$Fecha_ini' AND '$Fecha_ter' ORDER BY FECHA,HORA_ENTRADA";
		$rs = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		while($row = mysqli_fetch_array($rs))
		{
			echo'<tr>';
			echo'<td align="center">'.$row["fecha"].'</td>';
			echo'<td align="center">'.$row[guia_despacho].'</td>';
			echo'<td align="center">'.$row[patente].'</td>';
			echo'<td align="center">'.$row[lote].'</td>';
			echo'<td align="center">'.$row["recargo"].'</td>';
			echo'<td align="center">'.$row["peso_neto"].'</td>';
			echo'</tr>';
			$Peso_Total = $Peso_Total + $row[peso_neto];
		}

		echo '<tr class="ColorTabla02">';
			echo '<td colspan="5"><strong>Total</strong></td>';
			echo '<td align="center">'.$Peso_Total.'</td>';
		echo '</tr>';
	}

	if($cod_exist == 22)
	{
		$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$Fecha_ini' AND '$Fecha_ter' AND cod_existencia = 02 AND num_conjunto = $Conjunto ORDER BY fecha_movimiento";
		$rs = mysqli_query($link, $Consulta);
		
		while($row = mysqli_fetch_array($rs))
		{
			echo'<tr>';
			echo'<td align="center">'.$row[fecha_movimiento].'</td>';
			echo'<td align="center">'.$row["cod_existencia"].'</td>';
			echo'<td align="center">'.$row[conjunto_destino].'</td>';
			echo'<td align="center">'.$row["peso_humedo_movido"].'</td>';
			echo'</tr>';
			$Peso_Total = $Peso_Total + $row["peso_humedo_movido"];
		}


		echo '<tr class="ColorTabla02">';
			echo '<td colspan="3"><strong>Total</strong></td>';
			echo '<td align="center">'.$Peso_Total.'</td>';
		echo '</tr>';
	}

    //Traspasos
	if($cod_exist == 6)
	{
		if($cod_exist == 6)
			$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$Fecha_ini' AND '$Fecha_ter' AND cod_existencia = 06 AND num_conjunto = $Conjunto ORDER BY fecha_movimiento";

		$rs = mysqli_query($link, $Consulta);
		
		while($row = mysqli_fetch_array($rs))
		{
			echo'<tr>';
			echo'<td align="center">'.$row[fecha_movimiento].'</td>';
			echo'<td align="center">'.$row["cod_existencia"].'</td>';
			echo'<td align="center">'.$row[conjunto_destino].'</td>';
			echo'<td align="center">'.$row[lugar_destino].'</td>';
			$peso = $row["peso_humedo_movido"] + $row["estado_validacion"];
			echo'<td align="center">'.$row["peso_humedo_movido"].'</td>';
			echo'<td align="center">'.$row["estado_validacion"].'</td>';
			echo'</tr>';
			$Peso_Total = $Peso_Total + $row["peso_humedo_movido"] + $row["estado_validacion"];
		}


		echo '<tr class="ColorTabla02">';
			echo '<td colspan="4"><strong>Total</strong></td>';
			echo '<td align="center" colspan="2">'.$Peso_Total.'</td>';
		echo '</tr>';
	}

	//Traspaso desde Conj.
	if($cod_exist == 17)
	{
		$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$Fecha_ini' AND '$Fecha_ter' AND cod_existencia = 15 AND conjunto_destino = $Conjunto ORDER BY fecha_movimiento";
		$rs = mysqli_query($link, $Consulta);
		
		while($row = mysqli_fetch_array($rs))
		{
			echo'<tr>';
			echo'<td align="center">'.$row[fecha_movimiento].'</td>';
			echo'<td align="center">'.$row["cod_existencia"].'</td>';
			echo'<td align="center">'.$row[num_conjunto].'</td>';
			$peso = $row["peso_humedo_movido"] + $row["estado_validacion"];
			echo'<td align="center">'.$row["peso_humedo_movido"].'</td>';
			echo'<td align="center">'.$row["estado_validacion"].'</td>';
			echo'</tr>';
			$Peso_Total = $Peso_Total + $row["peso_humedo_movido"] + $row["estado_validacion"];
		}


		echo '<tr class="ColorTabla02">';
			echo '<td colspan="3"><strong>Total</strong></td>';
			echo '<td align="center" colspan="2">'.$Peso_Total.'</td>';
		echo '</tr>';
	}

	//Traspaso a Conj.
	if($cod_exist == 15)
	{
		$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$Fecha_ini' AND '$Fecha_ter' AND cod_existencia = 15 AND num_conjunto = $Conjunto ORDER BY fecha_movimiento";
		$rs = mysqli_query($link, $Consulta);
		
		while($row = mysqli_fetch_array($rs))
		{
			echo'<tr>';
			echo'<td align="center">'.$row[fecha_movimiento].'</td>';
			echo'<td align="center">'.$row["cod_existencia"].'</td>';
			echo'<td align="center">'.$row[conjunto_destino].'</td>';
			echo'<td align="center">'.$row["peso_humedo_movido"].'</td>';
			echo'</tr>';
			$Peso_Total = $Peso_Total + $row["peso_humedo_movido"];
		}


		echo '<tr class="ColorTabla02">';
			echo '<td colspan="3"><strong>Total</strong></td>';
			echo '<td align="center">'.$Peso_Total.'</td>';
		echo '</tr>';
	}

	//Embarque.
	if($cod_exist == 5)
	{
		$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$Fecha_ini' AND '$Fecha_ter' AND cod_existencia = '05' AND num_conjunto = $Conjunto ORDER BY fecha_movimiento";
		$rs = mysqli_query($link, $Consulta);
		
		while($row = mysqli_fetch_array($rs))
		{
			echo'<tr>';
			echo'<td align="center">'.$row[fecha_movimiento].'</td>';
			echo'<td align="center">'.$row["cod_existencia"].'</td>';
			echo'<td align="center">'.$row[conjunto_destino].'</td>';
			echo'<td align="center">'.$row["peso_humedo_movido"].'</td>';
			echo'</tr>';
			$Peso_Total = $Peso_Total + $row["peso_humedo_movido"];
		}


		echo '<tr class="ColorTabla02">';
			echo '<td colspan="3"><strong>Total</strong></td>';
			echo '<td align="center">'.$Peso_Total.'</td>';
		echo '</tr>';
	}

	
  ?>	
  </table>
	<p><p>
	<p><p>
    <table cellpadding="3" cellspacing="0" width="500" border="0" align="center">
      <tr>
        <td> <div align="center"> 
            <input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()"> 
            <input name="btnsalir" type="button" style="width:100" value="Cerrar Ventana" onClick="self.close()">
        	</div>
		</td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php include("../principal/cerrar_rec_web.php") ?>
