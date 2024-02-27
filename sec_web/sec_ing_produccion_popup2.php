<?php	include("../principal/conectar_sec_web.php"); ?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Buscar1()
{	
	var f = document.frmPopUp;	
	
	f.action = "sec_ing_produccion_popup2.php?mostrar=S";
	f.submit();
}

function Chequear(r)
{
	
	
	window.opener.document.frm1.action = "sec_ing_produccion01.php?proceso=B10&parametros=" + r.value;
	window.opener.document.frm1.submit();	
	window.close();
}

function Salir()
{	
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frmPopUp" action="" method="post">
<div style="position:absolute; left: 15px; top: 15px;" id="div0">
<table width="500" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
        <td align="center">Datos de Produccion</td>
  </tr>
</table>
</div>

 
 <div style="position:absolute; left: 15px; top: 50px;" id="div1">  
  <table width="500" height="25" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
    <tr>
      <td width="154">Fecha Recepcion</td>
      <td width="328"><select name="dia" size="1">
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
        </select> <select name="mes" size="1" id="select">
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
        </select> <select name="ano" size="1">
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
        &nbsp; &nbsp; 
        <input name="btnbuscar" type="button" id="btnbuscar" value="Buscar" onClick="Buscar1()"></td>
    </tr>
  </table>
  </div>

<?php 
	//Campos Ocultos.
	echo '<input name="cmbproducto" type="hidden" value="'.$cmbproducto.'">';
	echo '<input name="cmbsubproducto" type="hidden" value="'.$cmbsubproducto.'">';
	
		if ($dia < 10)
		$dia = "0".$dia;
	if ($mes < 10)
		$mes = "0".$mes;

	
	$fecha = $ano."-".$mes."-".$dia;
	$dia_1 = "13";
	//echo "dia".$dia."<br>";
	$fecha = "$fecha 08:00:00"; 
	
	$Fecha2 =date("Y-m-d", mktime(1,0,0,$mes,($dia + 1),$ano));	
		
	
		
	//echo "FE2".$Fecha2."<br>";
	$Fecha2 = "$Fecha2 07:59:59"; 
	//echo "fe1".$fecha;
	//echo "Prod".$Fecha2;
	if ((($cmbproducto != 57) and ($cmbproducto != 64) and ($cmbproducto != 66)) and !($cmbproducto == 48 and ($cmbsubproducto == 8 or $cmbsubproducto == 9 or $cmbsubproducto == 3 or $cmbsubproducto == 6 or $cmbsubproducto == 10)))
	{
	 
		echo '<div style="position:absolute; left: 15px; top: 90px; width:518px; height:200px; OVERFLOW: auto;" id="div2">';
		echo '<table width="500" height="25" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">';
		echo '<tr>';
		echo '<td width="250" align="center">Grupo</td>';
		echo '<td width="250" align="center">Peso</td>';
		echo '</tr>';	 
		echo '</table>';
		echo '</div>';
	
		echo '<div style="position:absolute; left: 15px; top: 115px; width:518px; height:200px; OVERFLOW: auto;" id="div5">';
		echo '<table width="500" height="25" border="1" height="25" cellspacing="0" cellpadding="0">';
		$a= date("Y-m-d");
		
		$a = "$a 08:00:00";
		//echo "a".$a;
		//De produccion_catodo.
		
		$consulta = "SELECT cod_grupo, SUM(peso_produccion) AS peso, fecha_produccion,hora FROM sec_web.produccion_catodo";
		$consulta.= " WHERE CONCAT(fecha_produccion,' ',hora)  between '".$fecha."' and '".$Fecha2."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " GROUP BY cod_grupo";
		//	echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			
			echo '<tr>';
			
			echo '<td width="250" height="25" align="center"><a href="sec_ing_produccion_popup22.php?grupo='.$row["cod_grupo"].'&cmbproducto='.$cmbproducto.'&cmbsubproducto='.$cmbsubproducto.'&fecha='.$fecha.'&Fecha2='.$Fecha2.'">'.$row["cod_grupo"].'</a></td>';			
			//echo "entro".$row[fecha_produccion]."-".$row[hora];
			//echo '<td width="250" height="25" align="center"><a href="sec_ing_produccion_popup22.php?grupo='.$row["cod_grupo"].'&cmbproducto='.$cmbproducto.'&cmbsubproducto='.$cmbsubproducto.'&fecha='.$row[fecha_produccion].'&Fecha2='.$row[hora].'">'.$row["cod_grupo"].'</a></td>';			

			//echo '<td width="250" height="25" align="center">'.$row["peso"].'&nbsp;&nbsp;&nbsp;&nbsp;<a href="sec_ing_produccion_popup2_2.php?cod_grupo='.$row["cod_grupo"].'&cmbproducto='.$cmbproducto.'&cmbsubproducto='.$cmbsubproducto.'&fecha='.$fecha.'&Fecha2='.$Fecha2.'"><img src="../principal/imagenes/eliminar.png" align="absmiddle"></img></a></td>';
			
			echo '<td width="250" height="25" align="center"><a href="sec_ing_produccion_popup2_2.php?cod_grupo='.$row["cod_grupo"].'&cmbproducto='.$cmbproducto.'&cmbsubproducto='.$cmbsubproducto.'&fecha='.$fecha.'&Fecha2='.$Fecha2.'">'.$row["peso"].'</a></td>';
			echo '</tr>';
		}
		
		//De produccoin_desc_normal.
		$consulta = "SELECT cod_grupo, SUM(peso_produccion) AS peso FROM sec_web.produccion_desc_normal";
		$consulta.= " WHERE CONCAT(fecha_produccion,' ',hora) between '".$fecha."' and '".$Fecha2."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " GROUP BY cod_grupo";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			echo '<tr>';
			echo '<td width="250" height="25" align="center"><a href="sec_ing_produccion_popup22.php?grupo='.$row["cod_grupo"].'&cmbproducto='.$cmbproducto.'&cmbsubproducto='.$cmbsubproducto.'&fecha='.$fecha.'&Fecha2='.$Fecha2.'">'.$row["cod_grupo"].'</a></td>';			
			//echo '<td width="250" height="25" align="center"><a href="sec_ing_produccion_popup22.php?grupo='.$row["cod_grupo"].'&cmbproducto='.$cmbproducto.'&cmbsubproducto='.$cmbsubproducto.'&fecha='.$row[fecha_produccion].'&Fecha2='.$row[hora].'">'.$row["cod_grupo"].'</a></td>';			

			echo '<td width="250" height="25" align="center">'.$row["peso"].'&nbsp;&nbsp;&nbsp;&nbsp;<a href="sec_ing_produccion_popup2_2.php?cod_grupo='.$row["cod_grupo"].'&cmbproducto='.$cmbproducto.'&cmbsubproducto='.$cmbsubproducto.'&fecha='.$fecha.'&Fecha2='.$Fecha2.'"><img src="../principal/imagenes/eliminar.png" align="absmiddle"></img></a></td>';
			echo '</tr>';
		}		
		
		
		echo '</table>';
		echo '</div>';
	}
	else
	{
		echo '<div style="position:absolute; left: 15px; top: 90px; width:518px; height:200px; OVERFLOW: auto;" id="div2">';
		echo '<table width="500" height="25" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">';
		echo '<tr>';
		echo '<td width="250" align="center">Nº Pesada</td>';
		echo '<td width="250" align="center">Peso Bruto</td>';
		echo '<td width="250" align="center">Tara</td>';
		echo '<td width="250" align="center">Peso Neto</td>';
		echo '</tr>';	 
		echo '</table>';
		echo '</div>';		
		
		echo '<div style="position:absolute; left: 15px; top: 115px; width:518px; height:200px; OVERFLOW: auto;" id="div5">';
		echo '<table width="500" height="25" border="1" height="25" cellspacing="0" cellpadding="0">';		
		
		$consulta = "SELECT cod_producto,cod_subproducto,fecha_produccion,hora,peso_produccion,peso_tara FROM sec_web.produccion_catodo";
		$consulta.= " WHERE CONCAT(fecha_produccion,' ',hora) between '".$fecha."' and '".$Fecha2."'AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$suma = 0;
		$tara = 0;
		$neto = 0;
		$cont = 1;
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			echo '<tr>';
			//echo '<td width="250" height="25" align="left"><input type="radio" name="radio" value="'.$fecha.'/'.$row[hora].'" onClick="Chequear(this)">'.$cont.'</td>';		
			echo '<td width="250" height="25" align="left"><input type="radio" name="radio" value="'.$row[fecha_produccion].'/'.$row[hora].'" onClick="Chequear(this)">'.$cont.'</td>';			

			echo '<td width="250" height="25" align="center">'.$row["peso_produccion"].'</td>';
			echo '<td width="250" height="25" align="center">'.$row["peso_tara"].'</td>';
			echo '<td width="250" height="25" align="center">'.($row["peso_produccion"]-$row["peso_tara"]).'</td>';
			echo '</tr>';
			$suma = $suma + $row["peso_produccion"];
			$tara = $tara + $row["peso_tara"];
			$neto = $neto + ($row["peso_produccion"]-$row["peso_tara"]);
			$cont++;
		}
		
		echo '<tr class="ColorTabla02">';
		echo '<td height="25" width="250" align="left">Total</td>';
		echo '<td align="center" width="250">'.$suma.'</td>';
		echo '<td align="center" width="250">'.$tara.'</td>';
		echo '<td align="center" width="250">'.$neto.'</td>';						
		echo '</tr>';		
		echo '</table>';
		echo '</div>';		
	}
?>
<br>

<div style="position:absolute; left: 15px; top: 310px;" id="div5">
<table width="501" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
    <td width="491" align="center"><input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
  </tr>
</table>
</div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>