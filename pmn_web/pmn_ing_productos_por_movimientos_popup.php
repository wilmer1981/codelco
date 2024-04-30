<?php
 	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1()
{
	var f = document.frmPopUp;
	
	f.action = "pmn_ing_productos_por_movimientos_popup.php?recargapag1=S";
	f.submit();
}
/*****************/
function Chequear(r)
{		
	var f = document.frmPopUp;
	var vector = r.value.split('~'); //0:tipo, 1:cod_producto ,2:cod_subproducto, 3:id, 4:fecha.

	var linea = "recargapag1=S&recargapag2=S&recargapag3=S&bloquea=disabled&id=" + vector[3] + "&fecha=" + vector[4] + "&signo=" + vector[5]; 
	linea = linea + "&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	window.opener.document.frmPrincipal.action = "pmn_ing_productos_por_movimientos.php?opc=B&" + linea;
	window.opener.document.frmPrincipal.submit();
	window.close();
}
/*****************/
function Salir()
{
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frmPopUp" action="" method="post">
<?php	
	echo '<input name="cmbmovimiento" type="hidden" value="'.$cmbmovimiento.'">';
	echo '<input name="cmbproducto" type="hidden" value="'.$cmbproducto.'">';
	echo '<input name="cmbsubproducto" type="hidden" value="'.$cmbsubproducto.'">';	
?>
  <div style="position:absolute; left: 10px; top: 15px; width: 758px; height: 25px;" id="div0"> 
    <table width="750" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr>
        <td align="center">Datos de Productos Por Movimientos</td>
  </tr>
</table>
</div>

  <div style="position:absolute; left: 10px; top: 55px; width: 761px; height: 29px;" id="div3"> 
    <table width="750" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr> 
        <td width="78" align="left">Fecha Inicio</td>
        <td width="229" align="left"> 
          <?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		echo '<select name="dia" size="1">';
		for ($i=1;$i<=31;$i++)
		{	
			if (($recargapag1 == "S") && ($i == $dia))			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($recargapag1 != "S")) 
					echo "<option selected value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}
        echo '</select>';

	?>
          <select name="mes" size="1">
            <?php
		for($i=1;$i<13;$i++)
		{
			if (($recargapag1 == "S") && ($i == $mes))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($recargapag1 != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
          </select> <select name="ano" size="1">
            <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($recargapag1 == "S") && ($i == $ano))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($recargapag1 != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
          </select> &nbsp; </td>
        <td width="92" align="left">Fecha Termino</td>
        <td width="209" align="left">
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
          <select name="mes2" size="1">
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
        <td width="109" align="left"><input name="btnbuscar" type="button" value="Buscar" onClick="Recarga1()"></td>
      </tr>
    </table>
</div>

  <div style="position:absolute; left: 10px; top: 95px; width: 774px; height: 235px;OVERFLOW: auto;" id="div";> 
    <table width="750" border="1" cellspacing="0" cellpadding="0" class="TablaInterior">
      <tr class="ColorTabla01"> 
        <td width="93" rowspan="2" align="center">Fecha</td>
        <td width="241" rowspan="2" align="center">Identificacion</td>
        <td width="112" rowspan="2" align="center">Peso Seco</td>
        <td height="20" colspan="3" align="center">Finos</td>
      </tr>
      <tr class="ColorTabla01"> 
        <td width="91" align="center">Cu</td>
        <td width="102" align="center">Ag</td>
        <td width="96" align="center">Au</td>
      </tr>
      <?php
	 	if ($recargapag1 == "S")	
		{
			$FechaIni = $ano.'-'.$mes.'-'.$dia;
			$FechaTer = $ano2.'-'.$mes2.'-'.$dia2;
			
			$consulta = "SELECT tipo_mov, cod_producto, cod_subproducto, id, fecha, peso_seco, fino_cu, fino_ag, fino_au, ";
			$consulta.= " CASE WHEN unid_cu = 100 THEN '%' ELSE 'K/T' END AS unid_cu,";
			$consulta.= " CASE WHEN unid_ag = 100 THEN '%' ELSE 'K/T' END AS unid_ag,";
			$consulta.= " CASE WHEN unid_au = 100 THEN '%' ELSE 'K/T' END AS unid_au,";
			$consulta.= " signo_cu, signo_ag, signo_au, signo,";
			$consulta.= " CASE WHEN signo = '+' THEN 1 ELSE CASE WHEN signo = '-' THEN 2 ELSE 0 END END AS cod_signo";
			$consulta.= " FROM pmn_web.productos_por_movimientos";			
			$consulta.= " WHERE tipo_mov = '".$cmbmovimiento."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			$consulta.= " AND fecha BETWEEN '".$FechaIni."' AND '".$FechaTer."'";
			//echo $consulta."<br>";
						
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{			
				echo '<tr>';
				echo '<td align="left"><input type="radio" name="radiobutton" value="'.$row[tipo_mov].'~'.$row["cod_producto"].'~'.$row["cod_subproducto"].'~'.$row[id].'~'.$row["fecha"].'~'.$row[cod_signo].'" onClick="Chequear(this)">'.$row["fecha"].'</td>';												
				echo '<td align="left">'.$row[id].'</td>';
				echo '<td align="center">'.$row["signo"].number_format($row[peso_seco],3,",","").'</td>';				
				echo '<td align="center">'.$row[signo_cu].number_format($row[fino_cu],3,",","").' '.$row[unid_cu].'</td>';
				echo '<td align="center">'.$row[signo_ag].number_format($row[fino_ag],3,",","").' '.$row[unid_ag].'</td>';
				echo '<td align="center">'.$row[signo_au].number_format($row[fino_au],3,",","").' '.$row[unid_au].'</td>';												
				echo '</tr>';
			}
		}
	?>
    </table>
</div>

  <div style="position:absolute; left: 10px; top: 345px; width: 755px; height: 29px;" id="div5"> 
    <table width="750" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr>
    <td align="center"><input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
  </tr>
</table>
</div>
</form>
</body>
</html>
