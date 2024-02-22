<?Php	
		include("funcion.php");
		include("conectar_rrhh.php"); // Conectar a base de datos rrhh
		$rut_func = str_replace('.','',$rut_func);	
		$rut_func=colocar_cero_rut($rut_func);	
		/* Consulta Nombre  */		
		$buscar="SELECT APELLIDO_PATERNO, APELLIDO_MATERNO, NOMBRES from bd_rrhh.antecedentes_personales where (RUT='".$rut_func."')";
	  	$respuesta = mysql_query($buscar);	
	  	if($row=mysql_fetch_array($respuesta)){
			$nombre_trabajador = $row["nombres"]." ".$row["apellido_paterno"]." ".$row["apellido_materno"]; /* Coloco el nombre completo del trabajador en la variable "$nombre_trabajador" */								
		} else  {
			echo ' <script languaje = "Javascript">' ;
	  		echo ' 	alert ("El trabajador buscado no se encuentra en la base de datos.");';
			echo ' 	history.back();';
			echo ' 	window.close();';
	  		echo ' </script>';
		}	  
	include("cerrar_rrhh.php");// Cierro la base de dato de rrhhh	
	$rut_func=sacar_cero_rut($rut_func);	
?>
<!---------------------------------------- Inicio de Html  ------------------------------------------------>
<html>
<head>
	<title>Informe Accidentado</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<script language="JavaScript">
	<!---------------------------------  FUNCIONES  -------------------------------->
		<!-------  Cerrar PopUp  --------->
		function CerrarPopUp ()
		// Funcion que me permite cerrar la ventana
		{
		  window.close();
		}
	/*	function imprimir()
		{
				form1.BtnExportar.style.visibility='hidden';
				form1.BtnSalir.style.visibility='hidden';
				form1.BtnImprimir.style.visibility='hidden';
				window.print();
				form1.BtnSalir.style.visibility='';
				form1.BtnImprimir.style.visibility='';
				form1.BtnExportar.style.visibility='';
				break;  
		} */
		<!----------------- FIN DE FUNCIONES --------------------------------------------------------->		
	</script>
</head>
<!---------------------- Cuerpo de Html  ----------------------------------------------------------------->  
<body>
  <!------------------  Inicio Tabla de Informe   --------------------------------------------->
	  <table  align="center" width="95%" border="0" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
		<tr> 
		  <td width="12%">Enami.<br>
			V region </td>
		  <td colspan="3"> <div align="right">Fecha: <? echo $fecha = date("d-m-Y"); ?> 
		  </div></td>
		</tr>
		<tr> 
		  <td>&nbsp;</td>
		  <td colspan="2">&nbsp;</td>
		  <td width="17%">&nbsp;</td>
		</tr>
		<tr> 
		  <td>&nbsp;</td>
		  <td colspan="2">
			<div>
						<p align="justify">El trabajador de nombre <b><? echo $nombre_trabajador ?></b>, 
						  rut <b><? echo $rut_func;?></b> se le cancelara por motivo 
						  de accidente laboral ocurrido el <? echo $fecha_accidente; ?>, 
						  la siguiente cantidad de acuerdo al calculo de subsidio e incapacidad 
						  laboral considerando las leyes laborales y los respectivos entes 
						  previcionales que el trabajador posee. </p>
						<p align="justify">El c&aacute;lculo se realizo con los siguiente valores que 
						  a continuaci&oacute;n se detallan:</p>
			</div>						  
		  </td>
		  <td>&nbsp;</td>
		</tr>
		<tr> 
		  <td>&nbsp;</td>
		  <td colspan="2">&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		<tr> 
		  <td>&nbsp;</td>
		  <td colspan="2">Dias Licencia : </td>
		  <td>&nbsp;</td>
		</tr>
		<tr> 
		  <td>&nbsp;</td>
		  <td colspan="2">Valor Por Dia : </td>
		  <td>&nbsp;</td>
		</tr>
		<tr> 
		  <td>&nbsp;</td>
		  <td colspan="2">Total A Cancelar:</td>
		  <td>&nbsp;</td>
		</tr>
		<tr> 
		  <td>&nbsp;</td>
		  <td colspan="2">&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		<tr> 
		  <td>&nbsp;</td>
		  <td colspan="2">&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		<tr> 
		  <td>&nbsp;</td>
		  <td width="38%"> <div align="right"><br>
			<br>
			<br>
			</div></td>
		  <td width="33%"><div align="center">_______________________ <br>
			  <b>Firma</b></div></td>
		  <td>&nbsp;</td>
		</tr>
	  </table>
	  <!------------------  Fin Tabla de Informe   --------------------------------------------->
	  <br><br>
	  <form	 method="post" action="" name="form1">
	  <p align="center">
		<input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:100px" onClick="CerrarPopUp()">
		<input type="button" name="BtnImprimir" style="width:100" value="Imprimir"> <!-- onClick="imprimir()"> --->
	  </p>
	  </form>	
</body>
</html>
