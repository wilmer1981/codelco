<html>
<head>
<title>Sistema Calculo Subsidio e Incapacidad Laboral</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function cerrar_popup(){
  var f = document.form1;
	window.close();
	submit();
}
</script>
</head>
 
<body>
<div align="center"></div>
<form name="form1" method="post" action="">
  <div align="center">
    <table border="1" align="center" background="../principal/imagenes/fondo3.gif" class="Borde">
      <tr> 
        <td height="23" class="ColorTabla01" colspan="3"><strong>Isapres</strong></td>
      </tr>
      <tr> 
        <td width="10">&nbsp;</td>
        <td width="25"><strong>Cod</strong></td>
        <td><strong>Nombre</strong></td>
      </tr>
	    <?
	  /********Consulta en servidor 50***********/
	  include ("conectar_rrhh.php");
	  
//	  $consulta_rrhh = "SELECT COD_AFP, AFP from bd_rrhh.afp group by COD_AFP, AFP order by COD_AFP asc";	
//	  $var_rrhh = mysql_query($consulta_rrhh);
	//  $row_rrhh = mysql_fetch_array($var_rrhh);

	//  include("cerrar_rrhh.php");
	  /********Consulta en servidor 139**********/
//  include("conectar.php");
			$consulta_subs = "SELECT COD_ISAPRE, ISAPRE from bd_rrhh.ISAPRE group by COD_ISAPRE, ISAPRE order by COD_ISAPRE asc";
			$var_subs = mysql_query($consulta_subs);
	
		 while($row_subs = mysql_fetch_array($var_subs)){
		  echo '<tr align="center">';
		  echo '<td><input type="radio" name="boton" value="'.$valor.'"></td>';
		  echo '<td>'.$row_subs[COD_ISAPRE].'</td>';
		  echo '<td>'.$row_subs[ISAPRE].'</td>';
		  echo '</tr>';
		}
	  ?>
    </table>
  </div>
  <p align="center">Si desea modificar una Isapre elija una opci&oacute;n y presione 
    continuar.<br>
    <br>
    <input name="botton" type="submit" id="botton" style="width:75" value="Continuar">
    <input name="botton2" type="submit" id="botton2" style="width:75" value="Salir" onClick="cerrar_popup()">
  </p>
  
</form>
</body>
</html>
