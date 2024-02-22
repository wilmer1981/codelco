<!---------------------------------------- Inicio de Html  ------------------------------------------------>
<html>
<head>
	<title>Valor UF</title>
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<script language="JavaScript">
	<!---------------------------------  FUNCIONES  -------------------------------->
		<!-------  Cerrar PopUp  --------->
		function cerrar_popup()
		// Funcion que me cierra la ventana //
		{
			window.close();
		}
   <!---------------------------------- FIN FUNCIONES  --------------------------------------->			
	</script>
</head>
<!---------------------- Cuerpo de Html  ----------------------------------------------------------------->  
<body background="../principal/imagenes/fondo3.gif">
	<div align="center" ></div>
	<form name="form2" method="post" action="">
	  <div align="center"> 
		<!-------------  Tabla Principal   -------------->
		<table border="0" align="center" class="Borde" background="../principal/imagenes/fondo3.gif">
		  <tr> 
			<td height="23" class="ColorTabla01" colspan="2">
				<strong> Valor UF</strong>
			</td>
		  </tr>
		  <tr class="ColorTabla02"> 
			<td width="70"><strong>Fecha</strong></td>
			<td width="70"><strong>Valor</strong></td>
		  </tr>
		  <tr> 
  		 <? include("conectar.php"); // Conecta con la Base de Dato Subs_web //
		    $consulta = "SELECT * from subs_web.mes_uf group by fecha, valor order by fecha asc";
			$var = mysql_query($consulta);		
  		 	// Rellena los datos de UF en la tabla //
		    while($row = mysql_fetch_array($var)){
			    echo '<tr align="center" class="Detalle03">';
				$cadena = explode("-", $row["fecha"]); // Poner fecha en formato normal.
				$row["fecha"] = $cadena[1]."-".$cadena[0];
			    echo '<td>'.$row["fecha"].'</td>';
			    echo '<td>'.number_format($row["valor"],0,',','.').'</td>';
			    echo '</tr>';
			} // Fin : While...  //
		  ?>
	  </table>
	  <!---------------   Fin Tabla Principal  ----------------------------->
	  <br>
  	   <input name="botton2" type="button" id="botton22" style="width:75" value="Salir" onClick="cerrar_popup()">
	  <br>
	</div>
  </form>
</body>
</html>