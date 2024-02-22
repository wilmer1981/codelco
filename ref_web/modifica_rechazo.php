<?php
	include("../principal/conectar_sec_web.php");
	
	
		$consulta = "SELECT * FROM ref_web.produccion where cod_grupo='".$grupo."' and fecha='".$fecha."'";
		$rs1 = mysqli_query($link, $consulta);
		if ($row1 = mysqli_fetch_array($rs1))
			$mostrar = "S";
			
	
?>
<html>
<head>
<script language="JavaScript">


function ValidaCampos(f)
{	
	if (f.txtgruesas.value == "")
	{
		alert("Debe Ingresar valor para gruesas");
		return false;
	}
	
	if (f.txtdelgadas.value == "")
	{
		alert("Debe Ingresar valor para delgadas");
		return false;
	}
	
	if (f.txtgranuladas.value == "")
	{	
		alert("Debe Ingresar valor para granuladas");
		return false;
	}
	
	
	
	return true;
}
/*****************/
function Grabar(fecha,grupo)

{
    var f=document.FrmProceso;
	if (ValidaCampos(f))
	{
		f.action = "proceso01.php?proceso=GC&fecha="+f.txtfecha.value+"&grupo="+f.txtgrupo.value+"&gruesas="+f.txtgruesas.value+"&delgadas="+f.txtdelgadas.value+"&granuladas="+f.txtgranuladas.value;
		f.submit();
	}
}
/****************/
function Salir()
{
	window.close();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body  background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" >
            <tr> 
            <td>Fecha</td>
            <td>
              <?php
						if ($mostrar == "S")						
						echo '<input type="text" name="txtfecha" size="12" value="'.$row1["fecha"].'" readonly>';
					else 
						echo '<input type="text" name="txtfecha" size="12" value="'.$row1["fecha"].'">';
				?>
            </td>
          </tr>
          <tr> 
            <td>Grupo</td>
            <td>
              <?php
					if ($mostrar == "S")						
						echo '<input type="text" name="txtgrupo" size="10" value="'.$row1["cod_grupo"].'" readonly>';
					else 
						echo '<input type="text" name="txtgrupo" size="10" value="'.$row1["cod_grupo"].'">';
				?>
            </td>
          </tr>
          <tr> 
            <td>Gruesas</td>
            <td><input name="txtgruesas" type="text" size="10" value="<?php echo $row1[rechazo_gruesas] ?>"> 
            </td>
          </tr>
          <tr> 
            <td>Delgadas</td>
            <td><input name="txtdelgadas" type="text" size="10" value="<?php echo $row1[rechazo_delgadas] ?>"> 
            </td>
          </tr>
          <tr> 
            <td height="20">Granuladas</td>
            <td><input name="txtgranuladas" type="text" size="10" value="<?php echo $row1[rechazo_granuladas] ?>"></td>
          </tr>
        </table>
        <br>
        <table width="395" border="0">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="JavaScrip:Grabar(this.form)">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
	  	<?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
  </form>
<?php
	if (isset($activar))
	{
		echo '<script language="JavaScript">';		
		if (isset($fecha))
			echo 'alert("Modificaciones realizadas correctamente");';		
			
		echo 'window.opener.frmPopup.action = "Detalle_hojas_madres_rechazo_proceso.php?opcion=M&fecha='.$fecha.'  ";';
		echo 'window.opener.frmPopup.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>  
</body>
</html>
