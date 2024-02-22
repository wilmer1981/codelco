<?php	include("../principal/conectar_sec_web.php"); ?>
<html>
<head>
<title>Ver Datos Pesaje</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Buscar1()
{	
	var f = document.frmPopUp;	
	
	f.action = "sec_ing_produccion_popup3_0809.php?mostrar=S";
	f.submit();
}
/***************/
function Chequear(r,estado)
{
	var f = document.frmPopUp;

	if (estado == "c")
	{
		alert("El Paquete Esta Cerrado");
		r.checked = false;
		return;		
	}

	var vector = r.value.split('/'); //0:cod_paquete, 1:num_paquete, 2:fecha, 3:ie, 4:cod_bulto, 5:num_bulto, 6:marca, 7:cod_grupo, 8:cod_cuba, 9:unidades, 10:peso_paquete, 11:peso_proogramado, 12:tipo_ie, 13:unidad.
	var fecha = vector[2].split('-'); //0:año, 1:mes, 2:dia.

//&agrega_paq=S&&hh=15&mm=25&&listar_ie=V&recargapag4=S

	linea = 'recargapag1=S&recargapag2=S&recargapag3=S&recargapag4=S&cmbmovimiento=3&cmbproducto=' + f.cmbproducto.value + '&cmbsubproducto=' + f.cmbsubproducto.value; 
	linea = linea + '&mostrar=S&opcion=M&encontro_ie=S&tipo_ie=' + vector[12] + '&listar_ie=' + vector[12];	
	linea = linea + '&codlote=' + vector[4] + '&numlote=' + vector[5] + '&codpaq=' + vector[0];
	linea = linea + '&numpaq=' + vector[1] + '&marca=' + vector[6] + '&instruccion=' + vector[3]; 
	linea = linea + '&ano2=' + fecha[0] + '&mes2=' + fecha[1] + '&dia2=' + fecha[2] + '&cmbcodlote=' + vector[4];
	
	if (f.cmbproducto.value == 57)
		linea = linea + '&unidades=' + vector[7] + '&pesotara=' + vector[9] + '&pesoneto=' + vector[10] + '&peso=' + vector[8];
	else
		linea = linea + '&unidades=' + vector[9] + '&grupo=' + vector[7] + '&cuba=' + vector[8] + '&peso=' + vector[10]; 
		
	if (f.cmbproducto.value == 64 && (f.cmbsubproducto.value == 8 || f.cmbsubproducto.value == 7))
	{
		linea = linea + '&medida=' + vector[13];
	}
	
	window.opener.document.frm1.action = "sec_ing_produccion_0809.php?" + linea;
	window.opener.document.frm1.submit();
	
	window.close();	
}
/***************/
function Salir()
{	
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frmPopUp" action="" method="post">
  <div style="position:absolute; left: 15px; top: 15px;" id="div0">
<table width="590" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
    <td align="center">Datos de Paquetes</td>
  </tr>
</table>
</div>

 
<div style="position:absolute; left: 15px; top: 50px;" id="div1">
  <table width="590" height="25" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
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
		for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
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
	
	$fecha = $ano.'-'.$mes.'-'.$dia;
	
	echo '<div style="position:absolute; left: 15px; top: 85px; width:590px; height:220px; OVERFLOW: auto;" id="div2">';
	echo '<table width="590" height="25" border="1" cellspacing="0" cellpadding="7" class="ColorTabla01">';
	echo '<tr>';
	echo '<td width="70" align="center">Cod. Serie</td>';
	echo '<td width="70" align="center">N° Serie</td>';

	if ($cmbproducto == 18)	
		echo '<td width="70" align="center">Unidades</td>';
	
	if ($cmbproducto == 57)	
	{
		echo '<td width="70" align="center">Peso Neto</td>';		
		echo '<td width="70" align="center">Peso Tara</td>';		
		echo '<td width="70" align="center">Peso Bruto</td>';
	}
	else	
		echo '<td width="70" align="center">Peso</td>';
		
	echo '<td width="50" align="center">Estado</td>';
	echo '<td width="70" align="center">Control Peso</td>';
	echo '<td width="70" align="center">Diff. Peso</td>';
	echo '</tr>';	 
	echo '</table>';
	echo '</div>';

	echo '<div style="position:absolute; left: 15px; top: 110px; width:590px; height:220px; OVERFLOW: auto;" id="div7">';
	echo '<table width="590" height="25" border="1" height="25" cellspacing="0" cellpadding="7">';

	if ($cmbproducto != 57)
	{
		$consulta = "SELECT * FROM sec_web.paquete_catodo";
		$consulta.= " WHERE fecha_creacion_paquete = '".$fecha."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " ORDER BY cod_paquete ASC, num_paquete ASC";
	}
	else
	{
		$consulta = "SELECT t1.cod_paquete, t1.num_paquete, t1.fecha_pesaje, t2.corr_enm, t1.cod_bulto, t2.num_bulto, t1.marca, t2.cod_estado,";
		$consulta.= " t1.unidades, t1.peso_neto  AS peso_paquetes, t1.peso_bruto, t1.peso_tara";
		$consulta.= " FROM sec_web.pesaje_lodos AS t1";
		$consulta.= " INNER JOIN sec_web.lote_catodo AS t2 ";
		$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete";
		$consulta.= " AND t1.corr_ie = t2.corr_enm";		
		$consulta.= " WHERE fecha_pesaje = '".$fecha."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";	

		if ($cmbsubproducto == 11)
			$consulta.= " AND num_pesada = '1'";			
		else
			$consulta.= " AND num_pesada = '2'";
			
		$consulta.= " ORDER BY cod_paquete ASC, num_paquete ASC";
	}
	//echo $consulta."<br>";
	
	$cant_paquetes = 0;
	$total_unidades = 0;
	$total_bruto = 0;
	$total_tara = 0;
	$total_neto = 0;
	
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
		if ($row["cod_estado"] == 'a')
		{
			if ($cmbproducto != 57)
			{
				//Consulta en lote catodo.
				$consulta = "SELECT * FROM sec_web.lote_catodo";
				$consulta.= " WHERE cod_paquete = '".$row["cod_paquete"]."' AND num_paquete = '".$row["num_paquete"]."' AND cod_estado = 'a'";
				$rs1 = mysqli_query($link, $consulta);
				$row1 = mysqli_fetch_array($rs1);
				
				$linea = $row["cod_paquete"].'/'.$row["num_paquete"].'/'.$row[fecha_creacion_paquete].'/';
				$linea.= $row1["corr_enm"].'/'.$row1["cod_bulto"].'/'.$row1["num_bulto"].'/'.$row1["cod_marca"].'/';
				$linea.= $row["cod_grupo"].'/'.$row[cod_cuba].'/'.$row["num_unidades"].'/'.$row["peso_paquetes"].'/';
				
				$instruccion = $row1["corr_enm"];
			}
			else
			{
				$linea = $row["cod_paquete"].'/'.$row["num_paquete"].'/'.$row[fecha_pesaje].'/';
				$linea.= $row["corr_enm"].'/'.$row["cod_bulto"].'/'.$row["num_bulto"].'/'.$row["marca"].'/';
				$linea.= $row["unidades"].'/'.$row[peso_bruto].'/'.$row["peso_tara"].'/'.$row["peso_paquetes"].'/';
				
				$instruccion = $row["corr_enm"];
			}
			
			//Consulta el peso programado de la Instruccion.
			$consulta = "SELECT * FROM sec_web.programa_codelco";
			$consulta.= " WHERE corr_codelco = '".$instruccion."' AND estado1 = 'R'"; //****** Falta condicion, para saber si esta activo ó no la Instruccion.			
			
			$rs2 = mysqli_query($link, $consulta);
			if ($row2 = mysqli_fetch_array($rs2)) //Codelco.
			{
				$linea.= ($row2["cantidad_programada"] * 1000).'/P';
			}
			else 
			{	
				$consulta = "SELECT * FROM sec_web.programa_enami";
				$consulta.= " WHERE corr_enm = '".$instruccion."' AND estado1 = 'R'"; //****** Falta condicion, para saber si esta activo ó no la Instruccion.
				//echo $consulta."<br>";

				$rs3 = mysqli_query($link, $consulta);
				
				if ($row3 = mysqli_fetch_array($rs3)) //Enami.
					$linea.= ($row3[cantidad_embarque] * 1000).'/P';
				else
				{	
					$consulta = "SELECT * FROM sec_web.instruccion_virtual";
					$consulta.= " WHERE corr_virtual = '".$instruccion."'";
					//echo $consulta."<br>";
					$rs4 = mysqli_query($link, $consulta);
					$row4 = mysqli_fetch_array($rs4);
					
					$linea.= $row4["peso_programado"].'/V';
				}
			}				
			
			if ($cmbproducto != 57)
				$linea.= "/".$row1[unidad];
				//echo "DD".$linea;
				echo '<td width="70"><input type="radio" name="radiobutton" value="'.$linea.'" onClick="Chequear(this,\''.$row["cod_estado"].'\')">'.$row["cod_paquete"].'</td>';
		}
		else
			echo '<td width="70"><input type="radio" name="radiobutton" value="" onClick="Chequear(this,\''.$row["cod_estado"].'\')">'.$row["cod_paquete"].'</td>';
			
		echo '<td width="70" align="center">'.$row["num_paquete"].'</td>';
		
		if ($cmbproducto == 18)
			echo '<td width="70" align="center">'.$row["num_unidades"].'</td>';
			
		echo '<td width="70" align="center">'.$row["peso_paquetes"].'</td>';
		if ($cmbproducto ==18)
		{
			$valor1 = 0;
			$valor2 = 0;
			$diferencia = 0;
			$consulta="select * from sec_web.sec_control_pesada where cod_paquete = '".$row["cod_paquete"]."' and ";
			$consulta.=" num_paquete = '".$row["num_paquete"]."' and fecha  = '".$row[fecha_creacion_paquete]."'";
			$respuesta=mysqli_query($link, $consulta);
			//echo $consulta;
			if ($fila=mysqli_fetch_array($respuesta))
			{
				$valor1 = $fila[bascula5];
				$valor2 = $fila[bascula6];
				$diferencia = abs($valor1 - $valor2);
			}
			
		}
		if ($cmbproducto == 57)
		{
			echo '<td width="70" align="center">'.$row["peso_tara"].'</td>';		
			echo '<td width="70" align="center">'.$row[peso_bruto].'</td>';					
		}
		echo '<td width="50" align="center">'.$row["cod_estado"].'</td>';
		if ($diferencia==0)
		{
			echo '<td width="70"  align="center">'.$valor2.'</td>';
			echo '<td width="70"  align="center">'.$diferencia.'</td>';
		}
		else
		{
			if ($row["peso_paquetes"]	== $valor1)						
				echo '<td width="70"  align="center">(B-6)&nbsp; '.$valor2.'</td>';
				else
				echo '<td width="70"  align="center">(B-5)&nbsp;'.$valor1.'</td>';
			if ($diferencia > 2 || $diferencia < -2 )
				echo '<td width="70" bgcolor="#ff0000" align="center">'.$diferencia.'</td>';
				else
				echo '<td width="70" bgcolor="#fff000" align="center">'.$diferencia.'</td>';
				
		}
		echo '</tr>';
		
		$cant_paquetes++;
		$total_unidades = $total_unidades + $row["num_unidades"];
		$total_neto = $total_neto + $row["peso_paquetes"];
		$total_tara = $total_tara + $row["peso_tara"];
		$total_bruto = $total_bruto + $row[peso_bruto];
	}
	
	echo '<tr class="ColorTabla02">';
	echo '<td width="70" height="20">Total Paq.</td>';
	echo '<td width="70" align="center">'.$cant_paquetes.'</td>';
	if ($cmbproducto == 18)
	{
		echo '<td width="70" align="center">'.$total_unidades.'</td>';
		echo '<td width="70" align="center">'.$total_neto.'</td>';
		echo '<td width="50" align="center">&nbsp;</td>';
		echo '<td width="70" align="center">&nbsp;</td>';
		echo '<td width="70" align="center">&nbsp;</td>';
		
	}
	if ($cmbproducto == 48)
		echo '<td width="70" align="center">'.$total_neto.'</td>';
		
	if ($cmbproducto == 57)
	{
		echo '<td width="70" align="center">'.$total_neto.'</td>';
		echo '<td width="70" align="center">'.$total_tara.'</td>';	
		echo '<td width="70" align="center">'.$total_bruto.'</td>';		
	}
	
	//echo '<td width="70" align="center">&nbsp;</td>';				
	echo '</tr>';
	
	echo '</table>';
	echo '</div>';
?>
<td bgcolor=""
<br>

 <div style="position:absolute; left: 15px; top: 320px;" id="div5">'
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