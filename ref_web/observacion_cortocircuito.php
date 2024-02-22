<?php
	include("../principal/conectar_sec_web.php");
	
	
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



function Grabar(f)
{
    var f = document.FrmProceso;
	fecha=f.txtfecha.value;
	circuito=f.txtcircuito.value;
	grupo=f.txtgrupo.value;
	observacion=f.txt_observacion3.value;
	f.action = "ref_ingreso_observacion_proceso01.php?opcion=G"+"&circuito="+circuito+"&grupo="+grupo+"&fecha="+fecha+"&observacion="+observacion;
	f.submit();
	alert (observacion);
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
          <tr> 
            <td>Fecha</td>
             
              <?php echo '<td><input type="text" name="txtfecha" size="10" value="'.$fecha.'" readonly></td>';?>
           
          <tr> 
            <td>Circuito</td>
             <?php	echo '<td><input type="text" name="txtcircuito" size="10" value="'.$circuito.'" readonly></td>';	?>
           
          <tr> 
            <td>Grupo</td>
             <?php echo '<td><input type="text" name="txtgrupo" size="10" value="'.$codigo.'" readonly></td>';	?>
			
          <tr> 
            <td>Observacion</td>
           <?php echo "<td><textarea name='txt_observacion3' type='text' id='textarea3' cols='30' rows='5' value= '$txt_observacion3'>$txt_observacion3</textarea></td>"; ?>
          </tr>
          <tr> 
          
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
			
		echo 'window.opener.frmPrincipal.action = "cortes2_aux.php";';
		echo 'window.close();';		
		echo '</script>';
	}
?>  
</body>
</html>
