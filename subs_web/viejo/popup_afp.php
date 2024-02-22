<html>
<head>
<title>Sistema Calculo Subsidio e Incapacidad Laboral</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function continuar(){
	var f = document.form2;
	window.opener.document.form1.action ="main.php?combo_afp=" + "&valor=previcion.php";
	window.opener.document.form1.submit();
}
/**************************/
function cerrar_popup(){
	window.close();
}
</script>
</head>
 
<body>
<div align="center"></div>
<form name="form2" method="post" action="">
  <div align="center">
    <table border="1" align="center" background="../principal/imagenes/fondo3.gif" class="Borde">
      <tr> 
        <td height="23" class="ColorTabla01" colspan="5"><strong> AFP's</strong></td>
      </tr>
      <tr> 
        <td width="10">&nbsp;</td>
        <td width="25"><strong>Cod.</strong></td>
        <td width="95"><strong>Nombre</strong></td>
        <td width="39"><strong>Porc.</strong></td>
        <td width="70"><strong>Fecha<br>
          Modificaci&oacute;n</strong></td>
      </tr>
      <tr> 
        <?
	  /********Consulta en servidor 50***********/
	  include ("conectar_rrhh.php");
	  
	  $consulta_rrhh = "SELECT COD_AFP, AFP from bd_rrhh.afp group by COD_AFP, AFP order by COD_AFP asc";	
	  $var_rrhh = mysql_query($consulta_rrhh);
	//  $row_rrhh = mysql_fetch_array($var_rrhh);

	  include("cerrar_rrhh.php");
	  /********Consulta en servidor 139**********/
	  include("conectar.php");
			$consulta_subs = "SELECT * from subs_web.afp order by cod_afp asc";
			$var_subs = mysql_query($consulta_subs);
	
		 while($row_subs = mysql_fetch_array($var_subs)){
		  echo '<tr align="center">';
		  echo '<td><input type="radio" name="boton" value="'.$row_subs[COD_AFP].'"></td>';
		  echo '<td>'.$row_subs[COD_AFP].'</td>';
		  if($row_rrhh = mysql_fetch_array($var_rrhh)){
		  	echo '<td>'.$row_rrhh[AFP].'</td>';
		  }
		  	  $row_subs[porcent_afp] = str_replace('.',',', $row_subs[porcent_afp]);
			  if($row_subs[porcent_afp] == ""){
		          echo '<td>&nbsp;</td>';  
			  }else{
		  echo '<td>'.$row_subs[porcent_afp].'</td>' ;}
		  echo '<td>'.$row_subs["fecha"].'</td>';
		  echo '</tr>';
		}
	  ?>
    </table>
  </div>
  <p align="center">Si desea modificar una afp elija una opci&oacute;n y presione 
    continuar.<br>
    <br>
    <input name="botton" type="button" id="botton"  style="width:75" value="Continuar" onClick="continuar()">
    <input name="botton2" type="button" id="botton2" style="width:75" value="Salir" onClick="cerrar_popup()">
  </p>
  
</form>
</body>
</html>
