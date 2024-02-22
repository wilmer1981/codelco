<?Php
	/*******************  Aplicaciones de Excel ************************/
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	/******************************************************************/
	include ("../principal/conectar_principal.php");		
	include("funcion.php");
	include("conectar_rrhh.php"); // Conectar a base de datos rrhh
	$rut_func = str_replace('.','',$rut_func_exc);
	$rut_func=colocar_cero_rut($rut_func);
	/* Consulta Nombre  */		
	$buscar="SELECT APELLIDO_PATERNO, APELLIDO_MATERNO, NOMBRES from bd_rrhh.antecedentes_personales where (RUT='".$rut_func."')";
  	$respuesta = mysql_query($buscar);
  	if($row=mysql_fetch_array($respuesta)){
		$nombre_trabajador = $row["nombres"]." ".$row["apellido_paterno"]." ".$row["apellido_materno"]; /* Coloco el nombre completo del trabajador en la variable "$nombre_trabajador" */								
	} else  {
		echo ' <script languaje = "Javascript">' ;
  		echo '    alert ("El trabajador buscado no se encuentra en la base de datos.");';
		echo '    history.back();';
  		echo ' </script>';
	}	  
	$rut_func=sacar_cero_rut($rut_func);	
	include("cerrar_rrhh.php");// Cierro la base de dato de rrhhh	
?>	
<!----------------------------  Inicio de  Html  ----------------------------------->
<html>
<head>
	<title>Informe Excel</title>	 
</head>
<!------------------------------------------  Cuerpo Principal ---------------------->
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0";>
		<form name="frmPrincipal" method="post" action="">		
			  <!------------------  Inicio Tabla de Informe   --------------------------------------------->
				<table width="784" border="0">
				  <tr>
				 <td width="29%" align="center">CODELCO CHILE
				 <br>
				Division Ventanas </td>

				  
					<td colspan="2">&nbsp;</td>
					<td width="16%">
						<div align="right">
							Fecha:<? echo $fecha = date("d-m-Y"); ?> 
						</div>
					</td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td colspan="2">&nbsp;</td>
					<td width="16%">&nbsp;</td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td colspan="2">
						<div>
							<p align="justify">El trabajador de nombre <b><? echo $nombre_trabajador; ?></b>, rut <b><? echo $rut_func; ?></b> se le cancelara por motivo de accidente laboral ocurrido el <? echo $fecha_accidente; ?>, la siguiente cantidad de acuerdo al calculo de subsidio e incapacidad laboral considerando las leyes laborales y los respectivos entes previcionales que el trabajador posee. </p>
							<p align="justify">El c&aacute;lculo se realizo con los siguiente valores que a continuaci&oacute;n se detallan:</p>
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
					<td width="26%">
						<div align="right"><br><br><br>
						</div>
					</td>
					<td width="29%"><div align="center">_______________________ <br>
						<b>Firma</b></div>
					</td>
					<td>&nbsp;</td>
				  </tr>
		  </table>	
		  <!------------------  Fin Tabla de Informe   --------------------------------------------->		  
	</form>
</body>
</html>
