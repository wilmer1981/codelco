<?php
 	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1()
{
	var f = document.frmPopUp;
	
	f.action = "pmn_ing_produccion_subproductos_popup.php?recargapag1=S";
	f.submit();
}
/*****************/
function Chequear(r)
{		
	var vector = r.value.split('~'); //0:cod_producto, 1:cod_subproducto, 2:identificacion, 3:numero, 4:peso, 5:fecha_prod, 6:fecha_ven, 7:id_analisis,8:peso_tara. 

	var linea = "producto=" + vector[0] +"&subproducto=" + vector[1] + "&id=" +vector[2]  + "&num=" + vector[3] + "&peso=" + vector[4] + "&fecha_prod=" + vector[5] + "&fecha_ven=" + vector[6] + "&id_analisis=" + vector[7] + "&peso_tara=" + vector[8];
	var f=document.frmPopUp;
	f.action = "pmn_ing_produccion_subproductos01.php?proceso=B&" + linea;
	f.submit();
	//window.opener.document.frmPrincipal.submit();
	//window.close();
}
/*****************/
function Salir()
{
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TituloCabeceraOz">
<form name="frmPopUp" action="" method="post">
<?php
	//Campos Ocultos.
	echo '<input name="cmbproducto" type="hidden" value="'.$cmbproducto.'">';
	echo '<input name="cmbsubproducto" type="hidden" value="'.$cmbsubproducto.'">';
?>
  <div style="position:absolute; left: 15px; top: 15px; width: 521px; height: 26px;" id="div0"> 
    <table width="720" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr>
        <td align="center" class="TituloCabeceraAzul">Consulta De Datos</td>
  </tr>
</table>
</div>

  <div style="position:absolute; left: 16px; top: 55px; width: 727px; height: 33px;" id="div3"> 
    <table width="720" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr> 
        <td width="72" align="left" class="titulo_azul">Fecha Inicio</td>
        <td width="230" align="left"> 
          <?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		echo '<select name="dia1" size="1">';
		for ($i=1;$i<=31;$i++)
		{	
			if (($recargapag1 == "S") && ($i == $dia1))			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($recargapag1 != "S")) 
					echo "<option selected value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}
        echo '</select>';

	?>
          <select name="mes1" size="1" id="select">
            <?php
		for($i=1;$i<13;$i++)
		{
			if (($recargapag1 == "S") && ($i == $mes1))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($recargapag1 != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
          </select> <select name="ano1" size="1">
            <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($recargapag1 == "S") && ($i == $ano1))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($recargapag1 != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
          </select> &nbsp; </td>
        <td width="84" align="left" class="titulo_azul">Fecha Termino</td>
        <td width="224" align="left">
          <?php
		echo '<select name="dia2" size="1">';
		for ($i=1;$i<=31;$i++)
		{	
			if (($recargapag1 == "S") && ($i == $dia2))			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($recargapag1 != "S")) 
					echo "<option selected value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}
        echo '</select>';

	?>
          <select name="mes2" size="1" id="select2">
            <?php
		for($i=1;$i<13;$i++)
		{
			if (($recargapag1 == "S") && ($i == $mes2))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($recargapag1 != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
          </select> <select name="ano2" size="1">
            <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($recargapag1 == "S") && ($i == $ano2))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($recargapag1 != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
          </select></td>
        <td width="77" align="left"><input name="btnbuscar" type="button" value="Buscar" onClick="Recarga1()"></td>
      </tr>
    </table>
</div>

  <div style="position:absolute; left: 80px; top: 100px; width: 623px; height: 198px;OVERFLOW: auto;" id="div";> 
    <table width="600" height="25" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr class="TituloCabeceraAzul"> 
        <td width="120" align="center" height="25">N&ordm;</td>
		<?php
        	if ($cmbproducto == '28')
			{
				echo '<td width="120" align="center">Id. Analisis</td>';
			}
		?>
        <td width="120" align="center">Fecha Prod.</td>
        <td width="120" align="center">Identificacion</td>
        <td width="120" align="center">Peso Neto</td>
		<td width="120" align="center">Peso Tara</td>

      </tr>
      <?php
	 	if ($recargapag1 == "S")	
		{
			$fecha_ini = $ano1.'-'.$mes1.'-'.$dia1;
			$fecha_ter = $ano2.'-'.$mes2.'-'.$dia2;
			
			$consulta = "SELECT * FROM pmn_web.produccion_subproductos AS t1";
			$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
			$consulta.= " ON t1.identificacion = t2.cod_subclase AND t2.cod_clase = '6008'";
			$consulta.= " WHERE t1.fecha_produccion BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."'";
			$consulta.= " ORDER BY CEILING(t1.numero)";
			//echo $consulta."<br>";
						
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{			
				echo '<tr>';
				
				echo '<td align="left"><input type="radio" name="radiobutton" value="'.$row["cod_producto"].'~'.$row["cod_subproducto"].'~'.$row[identificacion].'~'.$row["numero"].'~'.number_format($row["peso"],4,",",".").'~'.$row[fecha_produccion].'~'.$row[fecha_venta].'~'.$row[id_analisis].'~'.number_format($row["peso_tara"],4,",",".").'" onClick="Chequear(this)">'.$row["numero"].'</td>';
				
				if ($cmbproducto == '28')
				{
					echo '<td align="center">'.$row[id_analisis].'</td>';
				}
				echo '<td align="center">'.$row[fecha_produccion].'</td>';						
				echo '<td align="center">'.$row["nombre_subclase"].'</td>';
				echo '<td align="center">'.number_format($row["peso"],4,",",".").'</td>';
				echo '<td align="center">'.number_format($row["peso_tara"],4,",",".").'</td>';
				echo '</tr>';
			}
		}
	?>
    </table>
</div>

  <div style="position:absolute; left: 15px; top: 310px; width: 742px; height: 33px;" id="div5"> 
    <table width="720" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr>
    <td align="center"><input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
  </tr>
</table>
</div>
</form>
</body>
</html>
