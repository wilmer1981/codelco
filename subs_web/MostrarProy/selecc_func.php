<?Php
	/********************** Establecer Codigos ***********/
	$CodigoDeSistema=19;
	$CodigoDePantalla=2;
?>
<!--------------------------------- Inicio de Html  -------------------------------------------------------->
<html>
<head>
	<title>Ingreso de Funcionario</title>	
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">	
	<script language="JavaScript" src="funciones.js"></script> <!-- Inserta las funciones de JavaScript -->
	<script language="JavaScript">
	<!---------------------------------  FUNCIONES  -------------------------------->
		<!-----------  Validar -------->		
		function Validar (opc)
		// Funcion que valida las opciones (Rut o Funcionario)
		{ 
			var f = document.form1;
			var rut_completo="";
			<!---------------------  Valida de que ingrese una Opcion  ---------------->
			if (( f.opc_user[0].checked == false) && (f.opc_user[1].checked == false)){
				window.alert("Seleccione una Opcion");
				return;
			}
			<!----------------------  Opcion RUT ------------------------------->			
			if (f.opc_user[0].checked == true)
			{
				if ((f.rut.value!="") && (f.dv.value!=""))
				{
					if(f.dv.value =='k')
					{
						f.dv.value = f.dv.value.toUpperCase();											
					}
					rut_completo=f.rut.value+"-"+f.dv.value;						
				}
				else
				{
					alert("Ingrese un Rut");
					f.rut.focus();
					return;
				}
			} 
			<!-----------------------  Valida de que seleccione un funcionario -------->

			if ((f.opc_user[1].checked == true) && (f.cmb_funcionario.value =='-1'))
			{
				window.alert("Seleccione un Funcionario");
				f.cmb_funcionario.focus();
				return;
		    }
			else
			{
				if ((f.opc_user[1].checked == true) && (f.cmb_funcionario.value !='-1'))
				{
					rut_completo = f.cmb_funcionario.value;
				}
			}			
			f.action = "ing_trab.php?rut_func="+rut_completo; <!-- Ir a la pafina ingreso trabajador ->
			f.submit();		
		}
		<!---- Proceso (Salir) ------->
		function Proceso(opt)
		// Funcion que me permite salir e ir a la pantalla principal //
		{
			var f = document.form1;
			switch (opt)
			{
				case "S":
					f.action = "../principal/sistemas_usuario.php?CodSistema=19";
					f.submit();
					break;
			}		
		}	
		<!------ Inhabilitar Opcion ------->
		function Inhabilitar (opt)
		// Funcion que me permite habilita o desabilitar las opciones (Rut o funcionario)
		{
			var f = document.form1;
			switch (opt)
			{
				case "R": // Eligio Opcion "Rut"
					f.rut.disabled=false;//Habilita texto rut
					f.dv.disabled=false;// Habilita texto dv
					f.cmb_funcionario.value='-1';//coloco en la "seleccion"					
					f.cmb_funcionario.disabled=true; // Inhabilita Combo Funcinario					
					f.rut.focus();
					break;
				case "F": // Eligio Opcion "Funcionario"
					f.rut.disabled=true; //Inhabilita texto rut
					f.dv.disabled=true; // Inhabilita texto dv
					f.cmb_funcionario.disabled=false; // Habilita Combo Funcinario
					f.rut.value="";//---> Limpia Textos rut
					f.dv.value="";//----> Limpia texto dv
					f.cmb_funcionario.focus();
					break;

			}
		}
	<!----------------- FIN DE FUNCIONES --------------------------------------------------------->		
	</script>
</head>
<!---------------------------------------  Cuerpo Principal   ------------------------------------------>
<body leftmargin="0" topmargin="0" marginwidth="3" marginheight="3">
	<form name="form1" method="post" action="">
		<? include("../principal/encabezado.php");?>	
	    <!--------------------------------Tabla Principal ---------------------------------->		
		<table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
		  <tr> 
			<td height="313" valign="top">
			  <p align="center" class="Titulo1"><br>
				<b>Accidente Laboral</b>
			  </p>
			  <!---------------- Tabla Interior -------------------------------------------------------->			  
			  <table width="400" border="0" align="center" ellpadding="2" cellspacing="0" class="TablaInterior">
			    <tr> 
				  <td width="20"> 				  	
				  	<input type="radio"  name="opc_user" value="R" onClick="Inhabilitar('R')" >				  	
				  	</td>
			      <td width="73">Rut:</td>
				  <td width="226">
				  	<input name="rut" type="text" id="rut2" size="11" maxlength="10" class="InputDer" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" onKeyDown="TeclaPulsada('false')">
					-
					<input name="dv" type="text" id="dv2" size="1" class="InputCen" maxlength="1">
				  </td>
			   </tr>
			   <tr>
			     <td> 
			       <input type="radio" name="opc_user" value="F" onClick="Inhabilitar('F')">
				 </td>
				 <td>Funcionario:</td>
				 <td>
				 	<SELECT name="cmb_funcionario" class="Select01">
					  <option value='-1' > Seleccionar...</option>
					  <?Php
							include("conectar_rrhh.php");/** Conecta con la Base de Dato de Recursos Humanos (SERVIDOR 50) **/			  
							$consulta ="SELECT rut, nombres, apellido_paterno, apellido_materno FROM bd_rrhh.antecedentes_personales ORDER BY apellido_paterno ASC";								
							$resultado= mysql_query($consulta);	
							while ($row = mysql_fetch_array($resultado))
							{
								echo '<option value="'.$row["rut"].'">'.$row["apellido_paterno"].' '.$row["apellido_materno"].' '.$row["nombres"].'</option>';
							}	
							include("cerrar_rrhh.php");// Cerrar base de datos RRHH		
						?>
    	            </SELECT>
				</td>
			  </tr>				
		    </table> 	
			<!---------------------  Fin de la Tabla Interior   ----------------------------------------->
		    <br>
	        <table width="400" border="0" cellspacing="0" cellpadding="3" class="TablaInterior" align="center">
	          <tr align="center" valign="middle">
				<td><input type="button" name="BtnEnviar" value="Aceptar" style="width:70px" onClick="Validar()"></td>
				<td><input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S')"></td>
			  </tr>
			</table>
		</td>
	  </tr>
	</table> 					
	<!----------------------------  Fin de la Tabla Principal  ------------------------------------>
	<?  		include("../principal/pie_pagina.php");?>		 
    </form>
</body>
</html>