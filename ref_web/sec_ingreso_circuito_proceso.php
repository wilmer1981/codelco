<?php
	include("../principal/conectar_sec_web.php");
	$opcion         = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$parametros     = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";
	$circuito   = isset($_REQUEST["circuito"])?$_REQUEST["circuito"]:"";
	$mostrar   = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	
	if ($opcion == "M")
	{
		$consulta = "SELECT * FROM sec_web.circuitos WHERE cod_circuito = '".$circuito."'";
		$rs1 = mysqli_query($link, $consulta);
		if ($row1 = mysqli_fetch_array($rs1))
			$mostrar = "S";
	}
	if ($opcion == "N")
	{
		$consulta = "SELECT CASE WHEN LENGTH(MAX(cod_circuito+1)) = 1 THEN CONCAT('0',(MAX(cod_circuito+1))) ELSE (MAX(cod_circuito+1)) END AS cod_circuito";
		$consulta.= " FROM sec_web.circuitos";
		$rs1 = mysqli_query($link, $consulta);
		$row1 = mysqli_fetch_array($rs1);
	}	
?>
<html>
<head>
<script language="JavaScript">
/*document.onkeydown = TeclaPulsada; 

function TeclaPulsada (tecla) 
{ 
var teclaCodigo = event.keyCode; 
var teclaReal = String.fromCharCode(teclaCodigo); 
alert("Cdigo de la tecla: " + teclaCodigo + "\nTecla pulsada: " + teclaReal); 
}*/ 


function ValidaCampos(f)
{	
	if (f.txtdescripcion.value == "")
	{
		alert("Debe Ingresar Descripcion");
		return false;
	}
	
	if (f.txtgrupos.value == "")
	{
		alert("Debe Ingresar El N� de Grupos");
		return false;
	}
	
	if (f.txtceldas.value == "")
	{	
		alert("Debe Ingresar las Celdas por Grupos");
		return false;
	}
	
	if (f.txtrectificador.value == "")
	{	
		alert("Debe Ingresar el Rectificador");
		return false;
	}
	
	if (f.txtnave.value == "")
	{	
		alert("Debe Ingresar Nave");
		return false;
	}
	
	return true;
}
/*****************/
function Grabar(f)
{
	if (ValidaCampos(f))
	{
		f.action = "sec_ingreso_circuito_proceso01.php?proceso=G&opcion=" + f.opcion.value;
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
            <td width="138">&nbsp;</td>
            <td width="247">&nbsp;</td>
          </tr>
		  <?php
		  $cod_circuito         = isset($row1["cod_circuito"])?$row1["cod_circuito"]:"";
		  $descripcion_circuito = isset($row1["descripcion_circuito"])?$row1["descripcion_circuito"]:"";
		  $cantidad_grupos   = isset($row1["cantidad_grupos"])?$row1["cantidad_grupos"]:"";
		  $num_celdas_grupos = isset($row1["num_celdas_grupos"])?$row1["num_celdas_grupos"]:"";
		  $rectificador      = isset($row1["rectificador"])?$row1["rectificador"]:"";
		  $nave              = isset($row1["nave"])?$row1["nave"]:"";

		  ?>
          <tr> 
            <td>Codigo</td>
            <td> 
              <?php
					if ($mostrar == "S")						
						echo '<input type="text" name="txtcodigo" size="10" value="'.$cod_circuito.'" readonly>';
					else 
						echo '<input type="text" name="txtcodigo" size="10" value="'.$cod_circuito.'">';
				?>
            </td>
          </tr>
          <tr> 
            <td>Descripcion</td>
            <td><input name="txtdescripcion" type="text" value="<?php echo $descripcion_circuito; ?>" size="50">
            </td>
          </tr>
          <tr> 
            <td>Nros de Grupo</td>
            <td><input name="txtgrupos" type="text" size="10" value="<?php echo $cantidad_grupos; ?>">
			</td>
          </tr>
          <tr> 
            <td>N&deg; de Celdas por Grupo</td>
            <td><input name="txtceldas" type="text" size="10" value="<?php echo $num_celdas_grupos; ?>"></td>
          </tr>
          <tr> 
            <td>Rectificador</td>
            <td><input name="txtrectificador" type="text" size="10" value="<?php echo $rectificador; ?>"></td>
          </tr>
          <tr>
            <td>Nave</td>
            <td><input name="txtnave" type="text" size="10" value="<?php echo $nave; ?>"></td>
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
		if (isset($mensaje))
			echo 'alert("'.$mensaje.'");';		
			
		echo 'window.opener.FrmIngCircuito.action = "sec_ingreso_circuito.php";';
		echo 'window.opener.FrmIngCircuito.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>  
</body>
</html>
