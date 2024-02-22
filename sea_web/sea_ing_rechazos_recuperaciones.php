<?php 
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 16;
?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script  language="JavaScript">
function Recarga1(f)
{	
	f.action = "sea_ing_rechazos_recuperaciones.php?recargapag1=S";		
	f.submit();
}
/*******************/
function Limpiar()
{	
	document.location = "sea_ing_rechazos_recuperaciones.php";	
}
/*******************/
function Salir()
{	
	document.location = "../principal/sistemas_usuario.php?CodSistema=2"
}
/******************/
function Buscar(f)
{
	if (f.cmbhornada.value == -1)
		f.action = "sea_ing_rechazos_recuperaciones.php?recargapag1=S&mostrar=N";
	else
		f.action = "sea_ing_rechazos_recuperaciones01.php?proceso=B";
		
	f.submit();
}
/*****************/
function Grabar(f)
{
	if (ValidaCampos(f))
	{
		f.action = "sea_ing_rechazos_recuperaciones01.php?proceso=G";
		f.submit();
	}
}
/*****************/
function Verifica(f,pos)
{
	valor1 = parseInt(f.elements[pos].value);
	valor2 = parseInt(f.elements[pos-1].value);
	
	if ((valor1 > valor2) || (valor1 < 0))
	{
		alert("Valor Ingresado no es Valido");
		return;
	}		
}
/*****************/
function ValidaCampos(f)
{
	if (f.cmbsubprod.value == -1)
	{	
		alert("Debe Seleccionar el Sub-Producto");		
		return false;
	}
	
	if (f.cmbhornada.value == -1)
	{
		alert("Debe Seleccionar la Hornada");
		return false;
	}
	
	if (f.unid_2.value == "")
		f.unid_2.value = 0;
		
	if (f.unid_4.value == "")
		f.unid_4.value = 0;
		
	if ((parseInt(f.unid_2.value) > parseInt(f.unid_1.value)) || (parseInt(f.unid_2.value) < 0))
	{
		alert("Las Unidades Rechazadas a N.E no son Validas");
		return false;
	}
		
	if ((parseInt(f.unid_4.value) > parseInt(f.unid_3.value)) || (parseInt(f.unid_4.value) < 0))
	{
		alert("Las Unidades Aprobadas a RAF no son Validas");
		return false;
	}		
		
	return true;	
}
</script>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<?php
	if (isset($mensaje))
		echo '<script language="JavaScript"> alert("'.$mensaje.'") </script>'
?>

<?php include("../principal/encabezado.php") ?>
<?php include("../principal/conectar_principal.php") ?> 

  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">


  <table width="650" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr> 
      <td colspan="2">Fecha </td>
      <td colspan="2"><font size="2">
        <SELECT name="dia" size="1">
          <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($recargapag1 == "S") && ($i == $dia))			
					echo "<option SELECTed value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($recargapag1 != "S")) 
						echo "<option SELECTed value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
        </SELECT>
        </font> <font size="2"> 
        <SELECT name="mes" size="1" id="SELECT7">
          <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($recargapag1 == "S") && ($i == $mes))
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($recargapag1 != "S"))
						echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
        </SELECT>
        <SELECT name="ano" size="1">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($recargapag1 == "S") && ($i == $ano))
					echo "<option SELECTed value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($recargapag1 != "S"))
					echo "<option SELECTed value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
        </SELECT>
        </font></td>
    </tr>
    <tr> 
      <td colspan="2">Sub-Producto</td>
            <td colspan="2"><SELECT name="cmbsubprod" id="cmbsubprod" onChange="JavaScript:Recarga1(this.form)">
		<?php
          	echo '<option value="-1">SELECCIONAR</option>';
			$consulta = "SELECT * FROM subproducto WHERE cod_producto = 17 ORDER BY cod_subproducto";
			
			include("../principal/conectar_principal.php");
			$rs = mysqli_query($link, $consulta);
			include("../principal/cerrar_principal.php");
			
			while ($row = mysqli_fetch_array($rs))
			{				
	          	if ($row["cod_subproducto"] == $cmbsubprod)
					echo '<option value="'.$row["cod_subproducto"].'" SELECTed>'.$row["descripcion"].'</option>';
				else 
					echo '<option value="'.$row["cod_subproducto"].'">'.$row["descripcion"].'</option>';
			}			
		?>
              </SELECT></td>
    </tr>
    <tr> 
      <td width="89">N° Hornada </td>
      <td width="176"><SELECT name="cmbhornada" id="cmbhornada" onChange="JavaScript:Buscar(this.form)">
                <option value="-1">SELECCIONAR</option>
				<?php
					if ($recargapag1 == "S")
					{						
						$consulta = "SELECT DISTINCT hornada FROM rechazos WHERE cod_tipo = 1 AND cod_subproducto = ".$cmbsubprod;						
						include("../principal/conectar_sea_web.php");
						$rs1 = mysqli_query($link, $consulta);
						include("../principal/cerrar_sea_web.php");
						
						while ($row = mysqli_fetch_array($rs1))
						{
							if ($row[hornada] == $cmbhornada)
								echo '<option value="'.$row[hornada].'" SELECTed>'.substr($row[hornada],6,4).'</option>';
							else
								echo '<option value="'.$row[hornada].'">'.substr($row[hornada],6,4).'</option>';
						}						
					}
				?>
              </SELECT>
              	<?php
			  		if ($mostrar == "S")
						echo '<input name="fecha_creacion" type="text" size="10" value="'.substr($cmbhornada,4,2).'/'.substr($cmbhornada,0,4).'" disabled>';
					else 
						echo '<input name="fecha_creacion" type="text" size="10" disables>';
				?>
				  </td>
				  
      <td width="174">Produccion(Unidades)</td>
      <td width="134">
	  	<?php
			if ($mostrar == "S")
		  		echo '<input name="total" type="text" value="'.$total.'" size="10" disabled>';
			else 
				echo '<input name="total" type="text" value="" size="10" disabled>';
		?>
	  </td>
    </tr>
  </table>
  <br>
  <table width="650" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr> 
            <td width="142">Unidades Rechazadas</td>
      <td width="131">
	  	<?php
	  		if ($mostrar == "S")
				echo '<input name="unid_1" type="text" value="'.$unid_1.'" size="10" disabled>';
			else 
				echo '<input name="unid_1" type="text" value="" size="10" disabled>';
		?>
	  </td>
            <td width="180">Unidades Rechazadas a N.E.</td>
      <td width="137">
	  	<?php
			if ($mostrar == "S")
	  			echo '<input name="unid_2" type="text" value="'.$unid_2.'" size="10" onBlur="JavaScript:Verifica(this.form,7)">';
			else
				echo '<input name="unid_2" type="text" value="" size="10">';
		?>
	  </td>
    </tr>
    <tr> 
            <td>Unidades Aprobadas</td>
      <td>
	  	<?php
	  	  	if ($mostrar == "S")
				echo '<input name="unid_3" type="text" value="'.$unid_3.'" size="10" disabled>';
			else
				echo '<input name="unid_3" type="text" value="" size="10" disabled>';
		?>
	  </td>
            <td>Unidades Aprobadas a RAF</td>
      <td>
	  	<?php
			if ($mostrar == "S")
				echo '<input name="unid_4" type="text" value="'.$unid_4.'" size="10" onBlur="JavaScript:Verifica(this.form,9)">';
			else
				echo '<input name="unid_4" type="text" value="" size="10">';
		?>
			
	</td>
    </tr>
  </table>
  <br>
  <table width="650" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td align="center"><input name="btngrabar" type="button" value="Grabar" style="width=60" onClick="JavaScript:Grabar(this.form)">
        <input name="btnlimpiar" type="button" value="Limpiar" style="width=60" onClick="JavaScript:Limpiar()">
        <input name="btnsalir" type="button" value="Salir" style="width=60" onClick="JavaScript:Salir()"></td>
    </tr>
  </table>
  
</td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>  
</form>
</body>
</html>
