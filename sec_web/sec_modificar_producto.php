<?php 	
	include("../principal/conectar_sec_web.php");

	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";
	$Codigo  = isset($_REQUEST["Codigo"])?$_REQUEST["Codigo"]:"";
	$Numero  = isset($_REQUEST["Numero"])?$_REQUEST["Numero"]:"";
	$CmbProductos  = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:"";
	$cmbsubproducto  = isset($_REQUEST["cmbsubproducto"])?$_REQUEST["cmbsubproducto"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Valores,ano)
{
	var Frm=document.FrmModProd;
	
	if (Frm.CmbProductos.value=='-1')
	{
		alert('Debe Seleccionar Producto');
		Frm.CmbProductos.focus();
		return;
	}
	if (Frm.cmbsubproducto.value=='-1')
	{
		alert('Debe Seleccionar SubProducto');
		Frm.cmbsubproducto.focus();
		return;
	}
	if (confirm('Esta Seguro de Modificar los Datos'))
	{
		Frm.action="sec_modificar_producto01.php?Proceso=G&Valores="+Valores+"&Ano="+ano+"&CodigoLote="+Frm.Codigo.value+"&NumeroLote="+Frm.Numero.value;
		Frm.submit();
	}	
}
function Recarga(codigo, numero)
{
	var Frm=document.FrmModProd;
	
	Frm.action="sec_modificar_producto.php?Codigo="+codigo+"&Numero="+numero;
	Frm.submit();
}

function Salir()
{
	window.close();
	
}
</script>
<title>Modificar Producto Paquetes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
 <form name="FrmModProd" method="post" action="">
 <input name="Valores" type="hidden" value="<?php echo $Valores;?>">
 <input name="Ano" type="hidden" value="<?php echo $Ano;?>">
 <input name="Codigo" type="hidden" value="<?php echo $Codigo;?>">
  <input name="Numero" type="hidden" value="<?php echo $Numero;?>"> 
  <table width="375" height="185" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	<td align="center"><br>
		<table width="357" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
          <tr>
			  <td width="84" align="left" class="Detalle01">Lote</td>
			  <td colspan="2" align="left" class="Detalle01"><?php echo $Codigo;?>-<?php echo $Numero;?></td>
		  </tr>
          <tr>
            <td align="left" class="Detalle01">Sub-Lotes</td>
            <td colspan="2" align="left" class="Detalle01">
			<textarea name="textarea" readonly cols="35" rows="2"><?php echo $Valores;?></textarea>
			</td>
          </tr>
		</table>
		<br>
		<table width="352" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
		  <tr>
			  <td width="84">Producto</td>
			  <td><strong>
			    <select name="CmbProductos" onChange="Recarga('<?php echo $Codigo;?>','<?php echo $Numero;?>');" style="width:200">
                  <option value='-1' selected>Seleccionar</option>
                  <?php
					$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos order by descripcion"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbProductos==$Fila["cod_producto"])
							echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						else
							echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				?>
                </select>
			  </strong></td>
		  </tr>
		  <tr>
			  <td>SubProducto</td>
			  <td>	<select name="cmbsubproducto" style="width:200">
                <option value="-1" selected>Seleccionar</option>
                <?php	
				$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = '".$CmbProductos."'";
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
					if ($row["cod_subproducto"] == $cmbsubproducto)
						echo '<option value="'.$row["cod_subproducto"].'" selected>'.$row["descripcion"].'</option>';
					else
						echo '<option value="'.$row["cod_subproducto"].'">'.$row["descripcion"].'</option>';
				}						
			  ?>
              </select>	      </td>
	      </tr>
		</table>
        <br><br>
		<table width="350" border="0" class="tablainterior">
          <tr>
			<td width="491" align="center">
			<input type="button" name="BtnOK" value="Modificar" style="width:90" onClick="Grabar('<?php echo $Valores;?>','<?php echo $Ano;?>');">
			<input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();">
			</td>
		  </tr>
		</table>
	</td>
  </tr>
  </table>
</form>
</body>
</html>
