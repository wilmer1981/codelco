<!---------------------------------------- Inicio de Html  ------------------------------------------------>
<html>
<head>
	<title>Isapres</title>
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<script language="JavaScript">	
	<!---------------------------------  FUNCIONES  -------------------------------->
		<!-------  Cerrar PopUp  --------->
		function cerrar_popup()
		// Funcion que me permite cerrar la ventana
		{
		  var f = document.form1;
		  window.close();				
		}
   <!---------------------------------- FIN FUNCIONES  --------------------------------------->			
	</script>
</head>
 <!---------------------- Cuerpo de Html  -----------------------------------------------------------------> 
<body class="TablaPrincipal">
	<div align="center"></div>
	<form name="form1" method="post" action="">
	  <div align="center">
		  <!----   TABLA PRINCIPAL  --->
		<table border="0" align="center" background="../principal/imagenes/fondo3.gif" class="Borde">
		  <tr> 
			<td height="23" class="ColorTabla01" colspan="3"><strong>Isapres</strong></td>
		  </tr>
		  <tr class="ColorTabla02" > 		
			<td width="25"><strong>Cod</strong></td>
			<td><strong>Nombre</strong></td>
		  </tr>
		  <?
		  /********Consulta en servidor 50***********/
		  include ("conectar_rrhh.php"); // Conecta con la Base de dato RRHH //	  
		  $consulta_subs = "SELECT COD_ISAPRE, ISAPRE from bd_rrhh.ISAPRE group by COD_ISAPRE, ISAPRE order by COD_ISAPRE asc";
		  $var_subs = mysql_query($consulta_subs);
 		  while($row_subs = mysql_fetch_array($var_subs)){
			  echo '<tr align="center" class="Detalle03">';		
			  echo '<td>'.$row_subs[COD_ISAPRE].'</td>';
			  echo '<td align="left">'.$row_subs[ISAPRE].'</td>';
			  echo '</tr>';
		  } /* Fin : While.. */
		  include("cerrar_rrhh.php");// Cierra la Conexion con la Base de Dato RRHH //
		  /*--------------------------------------------------------------------------*/
		  ?>		  
		</table>
		<!------------------------------------  Fin Tabla  Principal ------------------------------------->
	    </div>
	    <p align="center">
		    <input name="botton2" type="submit" id="botton2" style="width:75" value="Salir" onClick="cerrar_popup()">
	    </p>  
	</form>
</body>
</html>
