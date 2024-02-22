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
	
	f.action = "pmn_ing_ajuste_stock_popup.php?recargapag1=S";
	f.submit();
}
/*****************/
function Chequear(r)
{		
	var vector = r.value.split('~'); //0:cod_producto ,1:cod_subproducto, 2:tipo, 3:peso, 4:fecha, 5:turno.
	
	var linea = "producto=" + vector[0] +"&subproducto=" + vector[1] + "&tipo=" +vector[2]  + "&peso=" + vector[3] + "&fecha=" + vector[4] + "&turno=" + vector[5];
	window.opener.document.frmPrincipal.action = "pmn_ing_ajuste_stock01.php?proceso=B&" + linea;
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
<div style="position:absolute; left: 15px; top: 15px;" id="div0">
<table width="500" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
        <td align="center">Datos de Ajustes</td>
  </tr>
</table>
</div>

  <div style="position:absolute; left: 16px; top: 55px;" id="div3"> 
    <table width="500" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr> 
        <td width="156" align="left">Fecha</td>
        <td width="329" align="left"> 
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
			<select name="mes" size="1" id="select">
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
          </select>
          &nbsp;
          <input name="btnbuscar" type="button" value="Buscar" onClick="Recarga1()"></td>
      </tr>
    </table>
</div>

  <div style="position:absolute; left: 18px; top: 100; width: 520px; height: 195;OVERFLOW: auto;" id="div";> 
    <table width="500" height="25" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr class="ColorTabla01"> 
        <td width="250" align="center" height="25">SubProducto</td>
        <td width="250" align="center">Turno</td>
        <td width="231" align="center">Peso Ajustado</td>
      </tr>
      <?php
	 	if ($recargapag1 == "S")	
		{
			$fecha = $ano.'-'.$mes.'-'.$dia;
			
			$consulta = "SELECT t1.fecha,t1.cod_producto,t1.cod_subproducto,t2.descripcion,t1.tipo,t1.peso,t1.cod_turno FROM pmn_web.ajuste_stock AS t1";
			$consulta.= " INNER JOIN proyecto_modernizacion.subproducto AS t2";
			$consulta.= " ON t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
			$consulta.= " WHERE t1.fecha = '".$fecha."'";
			$consulta.= " ORDER BY t1.cod_producto, t1.cod_subproducto, t1.cod_turno";
						
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{			
				echo '<tr>';
				echo '<td align="left"><input type="radio" name="radiobutton" value="'.$row["cod_producto"].'~'.$row["cod_subproducto"].'~'.$row[tipo].'~'.$row["peso"].'~'.$row["fecha"].'~'.$row[cod_turno].'" onClick="Chequear(this)">'.$row["descripcion"].'</td>';
				
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";				
				$consulta.= " WHERE cod_clase = '1' AND cod_subclase = '".$row[cod_turno]."'";
				$rs1 = mysqli_query($link, $consulta);
				$row1 = mysqli_fetch_array($rs1);
								
				echo '<td align="center">'.$row1["nombre_subclase"].'</td>';
				echo '<td align="center">'.$row[tipo].$row["peso"].'</td>';
				echo '</tr>';
			}
		}
	?>
    </table>
</div>

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
