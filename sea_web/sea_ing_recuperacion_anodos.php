<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 18;
?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
</head>
<script language="JavaScript">
function Recarga1(f)
{	
	f.action = "sea_ing_recuperacion_anodos.php?recargapag=S&cmbsubprod=" + f.cmbsubprod.value;
	f.submit();
}
/**********************/
function ValidaCampos(f)
{	
	if (f.cmbsubprod.value == -1)
	{
		alert("Debe Seleccionar Sub-Producto");
		return false;
	}
	
	if (f.txtrecuperados.value == "")
	{
		alert("Debe Ingresar las Unidades a Recuperar");
		return false;
	}
	
	if ((parseInt(f.txtrecuperados.value) > parseInt(f.txtrechazos.value)) || (parseInt(f.txtrecuperados.value) <= 0))
	{
		alert("La Cantidad de Anodos a Recuperar No es Valida");
		return false;
	}
		
	return true;
}	
/****************/
function Grabar(f)
{
	if (ValidaCampos(f))	
	{	
		f.action = "sea_ing_recuperacion_anodos01.php?proceso=G";
		f.submit();
	}
}
/*****************/
function Buscar(f)
{
	if (f.cmbsubprod.value == -1)
	{
		alert("Debe Seleccionar Sub-Producto");
		return;
	}
	else 
	{
		f.action = "sea_ing_recuperacion_anodos.php?recargapag=S&buscar=S&cmbsubprod=" + f.cmbsubprod.value + "&txtbuscar=" + f.txtbuscar.value;
		f.submit()
	}
}
/****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=15";
}
/****************/
function Limpiar()
{	
	document.location = "sea_ing_recuperacion_anodos.php";
}
</script>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<?php
	if (isset($mensaje))
		echo '<script langueage="JavaScript"> alert("'.$mensaje.'") </script>';
?>
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>

  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">

<table width="700" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="101">Fecha </td>
    <td width="267"><font size="2">
      <SELECT name="dia" size="1">
        <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($recargapag == "S") && ($i == $dia))			
					echo "<option SELECTed value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($recargapag != "S")) 
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
				if (($recargapag == "S") && ($i == $mes))
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($recargapag != "S"))
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
				if (($recargapag == "S") && ($i == $ano))
					echo "<option SELECTed value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($recargapag != "S"))
					echo "<option SELECTed value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
      </SELECT>
      </font></td>
    <td width="90">Sub-Producto</td>
    <td width="233"><SELECT name="cmbsubprod" id="cmbsubprod" onChange="JavaScript:Recarga1(this.form)">
        <?php
			include("../principal/conectar_principal.php"); 
			
        	echo '<option value="-1">SELECCIONAR</option>';
			$consulta = "SELECT * FROM subproducto WHERE cod_producto = 17 ORDER BY cod_producto";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if ($row["cod_subproducto"] == $cmbsubprod) 
					echo '<option value="'.$row["cod_subproducto"].'" SELECTed>'.$row["descripcion"].'</option>';
				else
					echo '<option value="'.$row["cod_subproducto"].'">'.$row["descripcion"].'</option>';
			}
			
			include("../principal/cerrar_principal.php");
		?>
      </SELECT></td>
  </tr>
</table>
<br>
        <br>
<table width="700" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
            <td>Total Recuperables</td>
    <td>
	<?php
		include("../principal/conectar_sea_web.php");
		
		if (($recargapag == "S") and ($cmbsubprod != -1))
		{
			$consulta = "SELECT SUM(recuperables) AS unid FROM rechazos WHERE cod_subproducto = ".$cmbsubprod;
			$consulta = $consulta." AND cod_tipo = 6 AND cod_defecto = 0";
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			if (!is_null($row[unid]))
			{		
				$unidades = $row[unid];
				
				$consulta = "SELECT SUM(recuperables) AS unid FROM rechazos WHERE cod_subproducto = ".$cmbsubprod;
				$consulta = $consulta." AND cod_tipo = 9 AND cod_defecto = 0";
				
				$rs1 = mysqli_query($link, $consulta);
				$row1 = mysqli_fetch_array($rs1); 
				if (!is_null($row1[unid]))
					$unidades = $unidades - $row1[unid]; 
			}
			else
				$unidades = 0;
					
			echo '<input name="txtrechazos" type="text" value="'.$unidades.'" size="10" disabled>';				
		}	
		else 
			echo '<input name="txtrechazos" type="text" value="" size="10" disabled>';
			
		include("../principal/cerrar_sea_web.php");
	?>
	</td>
    <td>Unidades a Recuperar</td>
    <td><input name="txtrecuperados" type="text" id="txtrecuperados" size="10"></td>
  </tr>
</table>
  <br>
  <table width="700" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td align="center"><input name="btngrabar" type="button" value="Grabar" style="width:60" onClick="JavaScript:Grabar(this.form)">
              <input name="btnlimpiar" type="button" style="width:60" value="Limpiar" onClick="JavaScript:Limpiar()"> 
              <input name="btnsalir" type="button" style="width:60" value="Salir" onClick="JavaScript:Salir()"></td>
    </tr>
  </table>
<?php
	echo '<input type="hidden" name="producto" value="17">';
?> 

</td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
   
</form>
</body>
</html>