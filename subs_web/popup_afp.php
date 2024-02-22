<!---------------------------------------- Inicio de Html  ------------------------------------------------>
<html>
<head>
	<title>Listado de AFP </title>
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<script language="JavaScript">
	
	/*					COMO MANDAR PARAMETROS DE UNA VENTANA A UNA PAGINA WEB	
		<!---------  Funci�n Continuar  -------------->
		function continuar()
		{
			var f = document.form2;
			window.opener.document.form1.action ="previcion.php?combo_afp=" + "&valor=previcion.php";
			window.opener.document.form1.submit();
		}
	*/
		<!---------------------------------  FUNCIONES  -------------------------------->
		<!--- Cerrar PopUp --->
		function cerrar_popup()
		// Funcion que me cierra la ventana Afp
		{
			window.close();
		}
	<!----------------- FIN DE FUNCIONES --------------------------------------------------------->
	</script>
</head>
<!---------------------- Cuerpo de Html  ----------------------------------------------------------------->
<body background="../principal/imagenes/fondo3.gif">
	<form name="form2" method="post" action="">	
 	  <div align="center">	  	  
	  <!----   TABLA PRINCIPAL  --->
	  <table border="0" align="center" background="../principal/imagenes/fondo3.gif" class="Borde">
		  <tr> 
			<td height="23" class="ColorTabla01" colspan="5">
				<strong> AFP's</strong>
			</td>
		  </tr>
		  <tr class="ColorTabla02"> 
			<td width="25" align="center"><strong>Cod.</strong></td>
			<td width="95" align="left"><strong>Nombre Afp</strong></td>			
	        <td width="39" align="center"><strong>%</strong></td>			
    	    <td width="70" align="center"><strong>Fecha<br>Modificaci&oacute;n</strong></td>
		  </tr>
			<?php		  
			  /********Consulta en servidor 50***********/
			  include ("conectar_rrhh.php");		  
			  $consulta_rrhh = "SELECT COD_AFP, AFP from bd_rrhh.afp group by COD_AFP, AFP order by COD_AFP asc";	
			  $var_rrhh = mysql_query($consulta_rrhh);
			//  $row_rrhh = mysql_fetch_array($var_rrhh);	
			  include("cerrar_rrhh.php");
			  /*------------------------------------------*/
			  
			  /********Consulta en servidor 139**********/
			  include("conectar.php");
			  $consulta_subs = "SELECT * from subs_web.afp order by cod_afp asc";
			  $var_subs = mysql_query($consulta_subs);		
			  while($row_subs = mysql_fetch_array($var_subs)){
				  echo '<tr align="center" class="Detalle03">';				
				  echo '<td>'.$row_subs[COD_AFP].'</td>';
				  if($row_rrhh = mysql_fetch_array($var_rrhh)){
					echo '<td align="left">'.$row_rrhh[AFP].'</td>';
				  }/* Fin if....*/
				  $row_subs[porcent_afp] = str_replace('.',',', $row_subs[porcent_afp]);// Me reemplaza el punto por una coma
				  if($row_subs[porcent_afp] == ""){
					  echo '<td>&nbsp;</td>';  
				  }else{
					  echo '<td>'.$row_subs[porcent_afp].'</td>' ;
				  }/* Fin if....*/
				  echo '<td>'.$row_subs["fecha"].'</td>';
				  echo '</tr>';
			   }/* Fin While... */
  		     ?>
	  </table>
	  <!---- FIN TABLA PRINCIPAL  --->	
	  </div>
	  <p align="center">
		<input name="botton2" type="button" id="botton2" style="width:75" value="Salir" onClick="cerrar_popup()">
	  </p>	  
   </form>
   <!--------------------------------- Fin Form  ------------------------------------------------------>
</body>
</html>
