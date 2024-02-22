<?php 
	include("../principal/conectar_sec_web.php");
	
	$movimientos = array(1=>"RECEPCION", 2=> "PRODUCCION");
	
?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1(f)
{
	if (f.cmbmovimiento.value == -1)
		f.action = "sec_ing_produccion.php";
	else 
		f.action = "sec_ing_produccion.php?recargapag1=S";
		
	f.submit();
}
/***************/
function Recarga2(f)
{
	linea = "recargapag1=S&recargapag2=S";
	f.action = "sec_ing_produccion.php?" + linea;
	f.submit();	
}
/***************/
function Grabar(f)
{
}
/***************/
function Limpiar()
{
	document.location = "sec_ing_produccion.php";	
}
/***************/
function Salir()
{	
	document.location = "../principal/sistemas_usuario.php?CodSistema=3";
}
</script>
</head>

<body>
<form name="" action="" method="post">
  <table width="700" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2">Tipo Movimiento</td>
      <td colspan="2"><select name="cmbmovimiento" id="cmbmovimiento" onChange="Recarga1(this.form)">
          <option value="-1">SELECCIONAR</option>
		<?php		  
		  	foreach($movimientos as $clave => $valor)
		  	{
          		if ($clave == $cmbmovimiento)
					echo '<option value="'.$clave.'" selected>'.$valor.'</option>';
				else 
					echo '<option value="'.$clave.'">'.$valor.'</option>';
			}		
		?>
        </select>
      </td>
    </tr>
    <tr> 
      <td colspan="2">Fceha Produccion</td>
      <td colspan="2"><font size="2"> 
        <select name="dia" size="1">
          <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($recargapag2 == "S") && ($i == $dia))			
					echo "<option selected value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($recargapag2 != "S")) 
						echo "<option selected value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
        </select>
        </font> <font size="2"> 
        <select name="mes" size="1" id="select7">
          <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($recargapag2 == "S") && ($i == $mes))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($recargapag2 != "S"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
        </select>
        <select name="ano" size="1">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($recargapag2 == "S") && ($i == $ano))
					echo "<option selected value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($recargapag2 != "S"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
        </select>
        </font></td>
    </tr>
    <tr> 
      <td colspan="2">Producto</td>
      <td colspan="2"><select name="cmbproducto" id="cmbproducto">
          <option value="-1">SELECCIONAR</option>
     	<?php	
			$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = 18";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if (($row["cod_subproducto"] == $cmbproducto) and ($recargapag2 == "S"))
					echo '<option value="'.$row["cod_subproducto"].'" selected>'.$row["descripcion"].'</option>';
				else
					echo '<option value="'.$row["cod_subproducto"].'">'.$row["descripcion"].'</option>';
			}						
		?>
        </select></td>
    </tr>
	
<?php
	if ($cmbmovimiento == 2)
	{
?>	
    <tr> 
      <td width="112">Grupo</td>
      <td width="197"><select name="cmbgrupo" id="cmbgrupo" onChange="Recarga2(this.form)">
          <option value="-1">SELECCIONAR</option>
          <?php
			$consulta = "SELECT * FROM sec_web.grupo_electrolitico ORDER BY cod_grupo";  	
			$rs1 = mysqli_query($link, $consulta);
			while ($row1 = mysqli_fetch_array($rs1))
			{	
				if ($row1["cod_grupo"] == $cmbgrupo)
					echo '<option value="'.$row1["cod_grupo"].'" selected>N° '.$row1["cod_grupo"].'</option>';
				else 
					echo '<option value="'.$row1["cod_grupo"].'">N° '.$row1["cod_grupo"].'</option>';
			}
		?>
        </select></td>
      <td width="103">Muesra</td>
      <td width="278"> 
        <select name="cmbmuestra" id="cmbmuestra">
          <option value="-1">SELECCIONAR</option>		
          <option value="S">SI</option>
          <option value="N">NO</option>
        </select></td>
    </tr>
    <tr> 
      <td>Lado</td>
      <td><select name="cmblado" id="cmblado">
          <option value="-1">SELECCIONAR</option>
          <option value="P">PARCIAL</option>
          <option value="T">TOTAL</option>
        </select></td>
      <td>Cuba</td>
      <td><select name="cmbcuba" id="cmbcuba">
	  <option value="-1">SELECCIONAR</option>
	  	<?php
          	$consulta = "SELECT total_cubas FROM sec_web.grupo_electrolitico WHERE cod_producto = ".$cmbgrupo;
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			for($i=1; $i<= $row2[total_cubas]; $i++)
			{
				echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
        </select></td>
    </tr>

<?php
	}
?>
    
	
	<tr> 
      <td>Peso Produccion</td>
      <td><input name="txtpeso" type="text" id="txtpeso" size="10"></td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
  <br>
  <table width="700" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">
	  <input name="btngrabar" type="button"  value="Grabar" onClick="Grabar(this.form)">
      <input name="btnlimpiar" type="button" value="Limpiar" onClick="Limpiar()"> 
      <input name="btnsalir" type="button"   value="Salir" onClick="Salir()"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>