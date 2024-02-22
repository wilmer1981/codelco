<?php	include("../principal/conectar_sec_web.php"); ?>
<html>
<head>
<title>Detalle de Recepción</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Buscar1()
{	
	var f = document.frmPopUp;	
	
	f.action = "sec_ing_produccion_popup1.php?mostrar=S";
	f.submit();
}
function ModificarLote(Lote,Rec)
{	
	var f = document.frmPopUp;	
	
	window.open("sec_ing_produccion_popup1_mod_lote.php?Lote="+Lote+"&Rec="+Rec,"","top=100,left=100,width=400,height=320,scrollbars=yes,resizable = yes");	
}

/***************/
function Chequear(r)    
{
	var vector = r.value.split('-') //0:lote, 1:recargo.
	
	window.opener.document.frm1.txtlote.value = vector[0];
	window.opener.document.frm1.txtrecargo.value = vector[1];
	window.opener.document.frm1.action = "sec_ing_produccion01.php?proceso=B2";
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
<table width="500" height="25" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
    
    <td align="center">(Versión 2) Datos de Recepcion</td>

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
	echo '<input type="hidden" name="cmbproducto" value="'.$cmbproducto.'">';
	echo '<input type="hidden" name="cmbsubproducto" value="'.$cmbsubproducto.'">';	

	$fecha = $ano.'-'.$mes.'-'.$dia;
	
	echo '<div style="position:absolute; left: 15px; top: 90px; width:518px; height:200px; OVERFLOW: auto;" id="div2">';
	echo '<table width="500" height="25" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">';
	echo '<tr>';
	echo '<td width="125" align="center">Lote Origen</td>';
	echo '<td width="125" align="center">N&deg; Guia</td>';
	echo '<td width="125" align="center">Peso Origen</td>';
	echo '<td width="125" align="center">Peso Zuncho</td>';
	echo '</tr>';	 
	echo '</table>';
	echo '</div>';

	echo '<div style="position:absolute; left: 15px; top: 115px; width:518px; height:200px; OVERFLOW: auto;" id="div5">';
	echo '<table width="500" height="25" border="1" height="25" cellspacing="0" cellpadding="0">';

	$consulta = "SELECT * FROM sec_web.recepcion_catodo_externo";
	$consulta.= " WHERE fecha_recepcion = '".$fecha."'";
	$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
		
		$row[lote_origen] =str_pad($row[lote_origen],8,'0',STR_PAD_LEFT); 
		//  echo "EE".$row[lote_origen]."--".$row["recargo"];   
		   
		echo '<td width="125"><input type="radio" name="radiobutton" value="'.$row[lote_origen].'-'.$row["recargo"].'" onClick="Chequear(this)"><a href="sec_ing_produccion_popup11.php?lote='.$row[lote_origen].'&recargo='.$row["recargo"].'&producto='.$row["cod_producto"].'&subproducto='.$row["cod_subproducto"].'">'.$row[lote_origen].'-'.$row["recargo"].'</a>&nbsp;&nbsp;&nbsp;<a href="JavaScript:ModificarLote('.$row[lote_origen].','.$row["recargo"].')"><img src="../principal/imagenes/modificar_sea.png" class="SinBorde" alt="Modificar Lote"></a></td>';
                                                                                                                                                                                                                                                                                                                                 
		//echo '<td width="125"><input type="radio" name="radiobutton" value="'.$row[lote_origen].'-'.$row["recargo"].'" onClick="Chequear(this)"><a href="sec_ing_produccion_popup11.php?lote='.$row[lote_origen].'&recargo='.$row["recargo"].'&producto='.$row["cod_producto"].'&subproducto='.$row["cod_subproducto"].'">'.$row[lote_origen].'-'.$row["recargo"].'</a></td>';
		echo '<td width="125" align="center">'.$row["num_guia"].'</td>';
		echo '<td width="125" align="center">'.$row[peso_recepcion].'</td>';
		echo '<td width="125" align="center">'.$row[peso_zuncho].'</td>';
		echo '</tr>';
	}
	
	echo '</table>';
	echo '</div>';
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
