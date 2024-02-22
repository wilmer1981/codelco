<?php 
	/********************** Establecer Codigos ***********/
	$CodigoDeSistema=19;
	$CodigoDePantalla=3;
	/***************************************************/	
?>
<!----------------------------------------  Inicio de html  --------------------------------------------->
<html>
<head>
	<title>Datos Previcionales</title>
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<Script languaje = "Javascript" src="funciones.js"></script>
	<script language="JavaScript">
	<!---------------------------------  FUNCIONES  -------------------------------->
		<!--- guardar_prev --->
		function guardar_prev(salvar)
		// Funcion que me permite Guardar un tipo de previcio ya sea Afp, Isapre o Fonasa
		{
			var f=document.form1;
			 /************Salvar_Afp*************/
			if(salvar == 'A'){
			   if(f.combo_afp.value == "-1" || f.porcent_afp.value == ""){
				 alert("Existe un campo vacio\nIngrese un valor para continuar.");
			   }else{
			   f.action="proceso_prev.php?guardar=S"+"&combo_afp="+f.combo_afp.value+"&porcent="+f.porcent_afp.value+"&salvar="+salvar;
			   f.submit();
			  } 
			 } 
			 /**********Salvar_Isapre**********/
			 if(salvar == 'I'){
			  if((f.nombre_isa.value == "") || (f.rut_isa.value == "") || (f.dv.value == "")){
			  alert("Existe un campo vacio\nVerifique los valores para continuar");
			  }else{
				resp = (RutValido(f.rut_isa.value, f.dv.value));
				if(resp){
					if (f.convenio[0].checked){
						 var conv='S';
					}else if (f.convenio[1].checked){
							  var conv='N';
					}		
					f.action="proceso_prev.php?guardar=S"+"&nombre_isa="+f.nombre_isa.value+"&rut_isa="+f.rut_isa.value+"&dv="+f.dv.value+"&convenio="+conv+"&salvar="+salvar;
					f.submit();
				}else{
					f.nombre_isa.value = "";
					f.rut_isa.value = "";
					f.dv.value = "";
				}
			   }  
			 }		
			 /*********Salvar_Fonasa***********/
			  if(salvar == 'F'){
				  if(f.porc_fonasa.value != ""){
				  f.action="proceso_prev.php?guardar=S"+"&porc_fonasa="+f.porc_fonasa.value+"&fecha="+f.fecha.value+"&salvar="+salvar;
				  f.submit();
			   }else{
				  alert("El Porcentaje FONASA esta vac�o\nIngrese un valor para continuar.");
			   }
			  }  	
		}
		<!--- Limpiar --->
		function limpiar(opcion)
		// Funcion quer me permite Limpiar los Campos que se van a ingresar
		{
			var f= document.form1;
			//---------- AFP ------------//
			if(opcion == 'A')
			{
				f.combo_afp.value = -1; 
				f.porcent_afp.value = "";
			}
			//------------ Isapre -------//			
			if(opcion == 'I')
			{
				f.nombre_isa.value = "";
				f.rut_isa.value = "";
				f.dv.value = "";
			}
			//----------- Fonasa ---------//
			if(opcion == 'F')
			{			
				f.porc_fonasa.value = "";
			}
		}		
		<!--- Recarga --->
		function recarga(previcion)
		/// Funcion que me la pagina al selecionar el combo de Afp
		{
			var f = document.form1;
			if (f.combo_afp.SELECTedIndex==0)
			{
				f.porcent_afp.value="";
			}			
			f.action = "previcion.php?previcion="+previcion+"&combo_afp=" + f.combo_afp.value;
			f.submit();
		}
		<!--- Recarga_prev --------------->
		function recarga_prev(previcion)
		// Funcion que me recarga la pagina con el tipo de Previcion seleccionado
		{
			var f = document.form1;
			//---------- AFP ------------//
			if (f.tipo_prev.SELECTedIndex==1) 
			{
				previcion='1';
			}
			//---------- Isapre ------------//
			if (f.tipo_prev.SELECTedIndex==2) 
			{
				previcion='2';
			}
			if (f.tipo_prev.SELECTedIndex==3) 
			//---------- Fonasa ------------//
			{
				previcion='3';
			}
			f.action = "previcion.php?previcion="+previcion;
			f.submit();			
		}		
		<!----------- PopUp------------->
		function popup(letra)
		// Funcion que me permite abrir una ventana nueva para Listar los Valores (Afp o Isapre)
		{
			var f = document.form1;
			//-----------  AFP  -------------------//
			if (letra =="A"){
				window.open("popup_afp.php",""," fullscreen=no,left=165,top=100,width=330,height=370,scrollbars=yes,resizable = no");
			}
			//-----------  ISAPRE  -------------------//
			if (letra =="I"){
				window.open("popup_isapre.php",""," fullscreen=no,left=165,top=100,width=330,height=370,scrollbars=yes,resizable = no");
			}
		}
		<!-------- Proceso (Salir) ---------->
		function Proceso(opt)
		// Funcion que me permite salir e ir al menu principal
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
		<!----------------- FIN DE FUNCIONES --------------------------------------------------------->
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<!-----------------------------------  Cuerpo de Html  ------------------------------------------->
<body leftmargin="0" topmargin="0" marginwidth="3" marginheight="3">
	<form name="form1" method="post" action="">
		<? include("../principal/encabezado.php");?>
		<div align="left">
	    <!--------------------------------Tabla Principal ---------------------------------->
		<table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    	  <tr>
        	<td height="313" valign="top"> 
				<p align="center" class="Titulo1">
					<strong>
						<br>Datos Previcionales<br>
					</strong>
				</p>
				<input name="valor" type="hidden" value="previcion.php">
			  <!---------------- Seleccion de Previcion  ----------------------->
			  <p align="center">
				  <SELECT name="tipo_prev" onChange="recarga_prev('<? echo $previcion; ?>')">
						<option>Seleccionar...</option>
						<option> AFP </option>
						<option> Isapre </option>
						<option> Fonasa </option>					
				  </SELECT>
				  <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')">
				  <br><br>				
			  </p>
			  <p align="center"><strong> 
			  <!-----------------------  AFP  ------------------------------->
			  <? if($previcion=='1') { ?>
					</strong></p>
					<!-- Tabla del Formulario AFP -->  
				    <table width="328" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
						<tr> 
						<!-- ***************Combo AFP***********************/	-->
							<td width="84">Nombre AFP :</td>
							<td colspan="2">														
							 <SELECT name="combo_afp" onChange="recarga('<? echo $previcion; ?>')">
								<option value='-1'>Seleccionar...</option>
								<? 
								include("cerrar.php"); // Cerrar base de datos SUBSWEB
								include("conectar_rrhh.php");/** Conecta la Base de Dato de Redcursos Humanos **/			  
								/*--------------------------------------------------------------------------------------------/*/
								$consulta = "Select * from bd_rrhh.afp order by afp asc"; /** Selecciona todos los codigos de las AFP**/
								$var = mysql_query($consulta);
								while($row = mysql_fetch_array($var)){
									if($row[COD_AFP] == $combo_afp){
										echo '<option value ="'.$row[COD_AFP].'" SELECTed>'.$row[AFP].' </option>';
									}else{
										echo '<option value ="'.$row[COD_AFP].'">'.$row[AFP].' </option>';
									}
								}// fin : while...								
								include("cerrar_rrhh.php");// Cerrar base de datos RRHH
								include("conectar.php");
								/*--------------------------------------------------------------------------------------------/*/	
								$consulta = "Select porcent_afp from subs_web.afp where cod_afp = '".$combo_afp."'";
								$var = mysql_query($consulta,$link);
								$row = mysql_fetch_array($var); 
								$porcent_afp =$row[porcent_afp];						
							   ?>
						   </SELECT>
					  </td>
					</tr>
					<tr> 
					   <td>Porcentaje :</td>
					   <td width="74"><input name="porcent_afp" class="InputDer" value="<? echo $porcent_afp ; ?>" type="text" size="6" maxlength="5" onKeyDown="TeclaPulsada(true)">
						%					
					   </td>
					   <td align="center" width="149">
		   				  <input type="button" name="Submit" value="Guardar" style="width:65" onClick="guardar_prev('A')">
		        	      <input type="button" name="Submit22" value="Limpiar" style="width:65" onClick="limpiar('A') "> 
        		      </td>
					</tr>
			  </table>
			  <!-- Fin Tabla del Formulario AFP -->  
			  <br><center>
				 <input type="button" name="Submit3" value="Listar Valores AFP" style="width:150" onClick="popup('A') ">
			  </center>
			  <br>
			  <br>
			  <? } /**Cierro el if.. **/
			  //-----------------------  ISAPRE  -------------------------------//
			  if($previcion=='2')
			  { ?>				  
		  		<!-- Tabla del Formulario Isapre -->  
			  <table width="351" height="81" border="0" align="center" ellpadding="2" cellspacing="0" class="TablaInterior">
				<tr> 
					  <td width="96" height="26">Nombre Isapre:</td>
					  <td colspan="2"><input name="nombre_isa" class="InputCen" type="text" size="40" maxlength="25">
					  </td>
					</tr>
					<tr> 
					  <td height="26">Rut Isapre:</td>
					  <td colspan="2"><input name="rut_isa" type="text"  class="InputDer" size="10" maxlength="8" onKeyDown="TeclaPulsada('false')">
						- 
						<input name="dv"  class="InputCen" type="text" id="dv" size="1" maxlength="1" > </td>
					</tr>
					<tr> 
					  <td height="25">Convenio:</td>
					  <td width="98" colspan="1"><input type="radio" name="convenio" value="S">
						Si
						<input type="radio" name="convenio" value="N" checked>
						No
					  </td>
					  <td width="142" align="center">
		  					<input type="button" name="Submit" value="Guardar" style="width:65" onClick="guardar_prev('I')">
							<input type="button" name="Submit2" value="Limpiar" style="width:65" onClick="limpiar('I')">				  
					  </td>
					</tr>
				  </table>
  		  		<!-- Fin Tabla del Formulario Isapre -->  
				  <center>				
					<br>
					<input type="button" name="Submit32" value="Listar Valores Isapre" style="width:155" onClick="popup('I') ">
				  </center>
				  <br>
				  <br>
			 <? } 	   	  
			  //-----------------------  FONASA  -------------------------------//
				if ($previcion=='3'){ ?>
  		  		<!-- Tabla del Formulario Fonasa -->  
				  <table width="343" border="0" align="center" ellpadding="2" cellspacing="0" class="TablaInterior">
				  <tr> 
					  <td width="29%">Fonasa (Salud):</td>
					  <!-------------------- Realizo la Consulta de Porcentaje -------------------------------->
					  <?
						  $consulta = "SELECT porcent as mayor from subs_web.fonasa where fecha=(SELECT max(fecha) from subs_web.fonasa) and cod_fonasa=(SELECT max(cod_fonasa) from subs_web.fonasa)";
						  $respuesta = mysql_query($consulta);
						  $row=mysql_fetch_array($respuesta);
						  /*fecha*/
						  $fecha_ingreso = date("Y")."-".date("m")."-".date("d");
					  //----------------------------------------------------------------------------------------//
					  ?>			  					  
					  <td width="26%"> <input name="porc_fonasa" type="text"  class="InputDer" size="10" maxlength="6" value="<? echo $row["mayor"]; ?>" onKeyDown="TeclaPulsada(true)" >
							% 
							<input type="hidden" name="fecha" value="<? echo $fecha_ingreso;?>">
					  </td>
					  <td width="45%" align="center">
		   				<input type="button" name="Submit" value="Guardar" style="width:65" onClick="guardar_prev('F')">
						<input type="button" name="Submit2" value="Limpiar" style="width:65" onClick="limpiar('F')">					   
					  </td>
					</tr>
				  </table>
  		  		<!-- Fin Tabla del Formulario Fonasa -->  
				<? } ?>
			  <p>&nbsp;</p>
	  		</td>
		</table>
		<!----------------------------------------- Fin de la Tabla Principal  ------------------------------>		
	  <? include("../principal/pie_pagina.php");?>
	 </div>
  </form>
</body>
</html>
