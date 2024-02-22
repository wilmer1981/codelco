<?php
//echo $SA."<br>";
include("../principal/conectar_principal.php");
$Rut =$CookieRut;

?>
<html>
<head>
<script language="JavaScript">
function Anular(SA)
{
	var	frm=document.FrmAnularSolicitudes;
	frm.action="cal_historial_solicitudes01.php?SA="+SA;
	frm.submit(); 
}

</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0" onLoad="document.FrmAnularSolicitudes.TextObs.focus();">
<form name="FrmAnularSolicitudes" method="post" action="">
<input name="SA02" type="hidden" value="<?php echo $SA02  ?>">
  <table width="400" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td><div align="center"></div>
        <table width="380" border="0" cellpadding="5" class="ColorTabla01">
          <tr>
            <td><div align="center">Anular Solicitudes</div></td>
          </tr>
        </table>
<br>
        <table width="380" border="0" cellpadding="5" class="TablaInterior">
          <tr>
            <td>Usuario: 
              <?php  
				$Consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
				}
			?>
            </td>
          </tr>
        </table>
        <br>
        <table width="380" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="58" height="36">Obs</td>
            &nbsp; 
            <td width="322"><textarea name="TextObs" style="width:320"></textarea> 
            </td>
            <!--onFocus="Desbloquear('');"></td>-->
          </tr>
        </table> 
        <br>
        <table width="380" height="27" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><div align="center">
                <input name="BtnOk" type="button" style="width:50" value="Ok" onClick="Anular('<?php echo $SA; ?>');" >
                <!-- <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:50" onClick="Salir('');">-->
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:50" onClick="JavaScript:window.close();">
			  </div></td>
          </tr>
        </table> </td>
	</tr>
  </table>
  </td>
  </tr>
  </table>
 	<?php 
  		echo "<script languaje='JavaScript'>";
		if ($PWValida=='N')
		{
			echo "alert('Password Ingresada Invalida');";
		}
		if ($PWValida=='S')
		{
			echo "alert('Ud No esta autorizado para eliminar Solicitudes');";
		}		
		echo "</script>"
	
	
	?>

</form>
</body>
</html>
