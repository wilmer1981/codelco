<?php
//echo $SA."<br>";
include("../principal/conectar_principal.php");
$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;

if(isset($_REQUEST["ProSubPro"])) {
	$ProSubPro = $_REQUEST["ProSubPro"];
}else{
	$ProSubPro =  "";
}
if(isset($_REQUEST["Enabal"])) {
	$Enabal = $_REQUEST["Enabal"];
}else{
	$Enabal =  "";
}


?>
<html>
<head>
<script language="JavaScript">
function Guardar(PsP,E)
{
	var	frm=document.FrmAnularSolicitudes;
	frm.action="cal_con_leyes_producto01.php?ProSubPro="+PsP + "&Salir=3&Enabal="+E;
	frm.submit();
}

</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0" >
<form name="FrmAnularSolicitudes" method="post" action="">
  <table width="400" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td><div align="center"></div>
        <table width="380" border="0" cellpadding="5" class="ColorTabla01">
          <tr>
            <td><div align="center">Consulta</div></td>
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
            <td width="58" height="30">Nombre</td>
            &nbsp; 
            <td width="322"><input name="TxtConsulta" type="text" id="TxtConsulta" style="width:150"> </td>
            <!--onFocus="Desbloquear('');"></td>-->
          </tr>
        </table> 
        <br>
        <table width="380" height="27" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><div align="center">
                <input name="BtnOk" type="button" style="width:50" value="Ok" onClick="Guardar('<?php echo $ProSubPro; ?>','<?php echo $Enabal; ?> ');" >
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
 
</form>
</body>
</html>
