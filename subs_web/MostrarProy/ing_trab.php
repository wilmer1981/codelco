<?php 
	/********************** Establecer Codigos ***********/
	$CodigoDeSistema=19;
	$CodigoDePantalla=2	;
	/***************************************************/
	include ("funcion.php");// Incluye  la pag funcion
	include("conectar_rrhh.php"); // Conectar a base de datos rrhh	
	if ($rut_func) // Si hay dato en rut_funcionario entonces..
	{	
		$rut_func = str_replace('.','',$rut_func); // reemplaza todos los puntos por blanco			
		$rut_func=colocar_cero_rut($rut_func);
		/**************  Busqueda en la Base de Dato  **********/
		/*****Consulta Nombre********/	
		$buscar="SELECT APELLIDO_PATERNO, APELLIDO_MATERNO, NOMBRES, COD_CENTRO_COSTO, COD_ISAPRE, COD_AFP  from bd_rrhh.antecedentes_personales where (RUT='".$rut_func."')";
	  	$respuesta = mysql_query($buscar);
	  	if($row=mysql_fetch_array($respuesta))
		{
			$ap_paterno = $row["apellido_paterno"];
		  	$ap_materno = $row["apellido_materno"];
		  	$nombres = $row["nombres"];		  
		 	$c_costo = $row[COD_CENTRO_COSTO];
		  	$c_centro_costo = $row[COD_CENTRO_COSTO];
  		    $c_costo = str_replace('.','', $c_costo); // Elimina puntos
		 	$c_costo = substr($c_costo,3,6); // Corta los 3 primeros caracteres
			$codigo_isapre=$row[COD_ISAPRE];
			$codigo_afp=$row[COD_AFP];			
				
		/*****Consulta Centro Costo****/
	  		$buscar_cc="SELECT NOMBRE_CENTRO_COSTO from bd_rrhh.centros where (COD_CENTRO_COSTO='".$c_centro_costo."')";
	  	    $respuesta_cc = mysql_query($buscar_cc);
	        $row=mysql_fetch_array($respuesta_cc);
	        $descrip = $row[NOMBRE_CENTRO_COSTO];

		/********Consulta Previcion****************/
			$buscar_afp = "SELECT AFP from bd_rrhh.afp as t1 inner join antecedentes_personales as t2 on t1.COD_AFP = t2.COD_AFP where RUT = ('".$rut_func."')";
	  	    $respuesta_afp = mysql_query($buscar_afp);
	  	    $row = mysql_fetch_array($respuesta_afp);
	  	    $nom_afp = strtoupper($row[AFP]);
		   
		/********Consulta Isapre****************/	
		    $buscar_isa= "SELECT ISAPRE from bd_rrhh.isapre as t1 inner join antecedentes_personales as t2 on t1.COD_ISAPRE = t2.COD_ISAPRE where (RUT='".$rut_func."')";
		    $respuesta_isa = mysql_query($buscar_isa);
	  	    $row = mysql_fetch_array($respuesta_isa);
	  	    $nom_isapre = strtoupper($row[ISAPRE]);
		/***----------------------------------------***/		   
            include("cerrar_rrhh.php"); // Cerrar base de datos RRHH
  	  /*********************  Termino de la busqueda en B.D  ************/ 
	   	    include("conectar.php") ; //Conecta la Base de Dato de Subs_web//
			$buscar_afp = "SELECT porcent_afp from subs_web.afp where COD_AFP = '".$codigo_afp."'";
			//"SELECT AFP from bd_rrhh.afp as t1 inner join antecedentes_personales as t2 on t1.COD_AFP = t2.COD_AFP where RUT = ('".$rut_func."')";			
			$respuesta = mysql_query($buscar_afp);
			$row = mysql_fetch_array($respuesta);
			$porc_afp = $row[porcent_afp];

	 /*****************************************/
		    if($Mes >'3'){
				$fecha1 = $Meses[$Mes-2];
				$fecha2 = $Meses[$Mes-3];
				$fecha3 = $Meses[$Mes-4];
			}
			if($Mes =='1'){
				$fecha1 = $Meses['11'];
				$fecha2 = $Meses['10'];
				$fecha3 = $Meses['9'];
			}
			if($Mes =='2'){
				$fecha1 = $Meses['0'];
				$fecha2 = $Meses['11'];
				$fecha3 = $Meses['10'];
			}
			if($Mes =='3'){
				$fecha1 = $Meses['1'];
				$fecha2 = $Meses['0'];
				$fecha3 = $Meses['11'];
			}
	    }else{
			echo ' <script languaje = "Javascript">' ;
	  		echo ' alert ("El trabajador buscado no se encuentra en la base de datos.");';
			echo 'history.back();';
	  		echo ' </script>';
	 	}// Fin : if($row=mysql_fetch_array($respuesta))... //
		//    Ajuste del rut //		
		$rut_trab=substr(sacar_cero_rut($rut_func),0,strpos (sacar_cero_rut($rut_func), "-"));
		$rut_trab_dv=$rut_func[strlen($rut_func)-1];
		//-----------------------------------------------------//
	}// Fin: if ($rut_func)..
?>

<!--------------------------  Inicio de Html  ------------------------------->
<html>
<head>
	<title>Trabajador Accidentado</title>	
	<Script languaje = "Javascript" src="funciones.js">/* Validador Puntitos */</script>
	<Script languaje = "Javascript" src="script_fecha.js">/* Validador fechas ##/##/#### */</script>
	<Script languaje = "Javascript">
	<!---------------------------------  FUNCIONES  -------------------------------->
		<!--- Recarga --->
		function recargar(numero)
		// Funcion que me permite Recargar la pagina (Agrego o elimino una fila de licencias)	
		{
			f = document.form1;
			f.action = "ing_trab.php?porc_salud="+f.pac_uf.value+"&opcion=AF&n=" + numero +"#punto" ;
			f.submit();			
		}
		<!--- Detalle --->		
		function Detalle()
		//  Funcion que me abre la ventana que me muestra los detalle de una licecia dada
		{
			f = document.form1;
			var F_Desde = "";
			var F_Hasta = "";
			var valor_licencia=0;
			var num_dias=0;
			// Validacion del campo
			for (i=1;i<f.elements.length;i++)
				{
					if (f.elements[i].name=="opt_detalle" && f.elements[i].checked)
					{
						if (f.elements[i-1].value!="")	
						{
							F_Desde = f.elements[i-5].value;
							F_Hasta = f.elements[i-4].value;
							num_dias=f.elements[i-3].value;
							valor_licencia=f.elements[i-1].value;
							window.open("detalle_licencia.php?num_dias="+num_dias+"&valor_licencia="+valor_licencia+"&FechaDesde="+F_Desde+"&FechaHasta="+F_Hasta ,""," fullscreen=no,left=0,top=10,width=375,height=315,scrollbars=yes,resizable = no");			
						} else {						
							alert ("Debe Realizar el Calculo Primero");
							f.elements[i].checked=false;
							
						}
					}
				}			
		}
		<!--- Calcular --->
		function Calcular (numfila,filaselec)
		// Funcion que me Abre la ventana de Valor Diario para realixar el calculo
		{
			f = document.form1;
			var F_Desde = "";
			var F_Hasta = "";
			var dias_licencias=0;
			var punt =0;
			// Recorro los elemento 
			for (i=1;i<f.elements.length;i++)			
			{
				// Si el radio seleccionado es verdadero entonces capturos sus datos 
				if (f.elements[i].name=="opt_calcular" && f.elements[i].checked)
				{					
					F_Desde = f.elements[i-3].value;
					F_Hasta = f.elements[i-2].value;
					dias_licencias = f.elements[i-1].value;
					punt=i;
				}
			}// fin : for...
			// Validacion de ingreso de lo valores //
			if (F_Desde == "" && F_Hasta == "")
			{
				alert("Debe Ingresar las 2 fechas");
				f.elements[punt].checked=false;
				return;
			}
			if (F_Desde == "")
			{
				alert("Debe Ingresar la  fecha Desde");
				f.elements[punt].checked=false;
				return;
			}
			if (F_Hasta == "")
			{
				alert("Debe Ingresar la fecha hasta");
				f.elements[punt].checked=false;
				return;
			}
			if (f.pac_uf.value=="")
			{
				alert("Debe Igresar Monto Isapre");
				f.elements[punt].checked=false;				
				return;				
			}		
			if (dias_licencias<=0)
			{
				alert("Fechas Incorrectas\nDebe ingresar las fechas");
				f.elements[punt].checked=false;
				f.elements[punt-3].value=""								
				f.elements[punt-2].value=""								
				f.elements[punt-1].value=""								
				return;				
			}
			//  Si todos los datos entan correcto entonces procedo a ir al calculo					
			window.open("valor_diario.php?inicializa_var=s&opcion=AF&numfila="+numfila+"&filaselec="+filaselec+"&dias_licencias="+dias_licencias+"&esfonasa="+f.EsFonasa.value+"&rut_completo="+ f.rut.value + "-" + f.dv.value + "&fecha_acc=" +f.fecha_acc.value+"&FechaDesde="+F_Desde+"&FechaHasta="+F_Hasta +"&porc_afp=" + f.porc_afp.value + "&pac_uf=" + f.pac_uf.value,""," fullscreen=no,left=0,top=20,width=783,height=470,scrollbars=yes,resizable = no");
		}
		<!--- Agregar --->
		function agregar(numero)
		// Funcion que Agrega una Fila Licencia 
		{ 
		   var f = document.form1;	
		   numero = numero + 1;
		   f.action = "ing_trab.php?porc_salud="+f.pac_uf.value+"&opcion=AF&n=" + numero + "#punto";
	       f.submit();
		}
		<!--- Borrar --->
		function borrar(numero)
		// Funcion que Borra una  Fila Licencia
		{ 
			var f = document.form1;
			if (numero >= 1)
			{
				numero = numero - 1;
				f.action = "ing_trab.php?porc_salud="+f.pac_uf.value+"&opcion=AF&n=" + numero +"#punto" ;
				f.submit();
			}
		}
		<!------- Proceso (Salir) ---------->
		function Volver()
		// Funcion que vuelve a la seleccion de funcionario
		{
			var f = document.form1;
			f.action = "selecc_func.php";
			f.submit();
		}	
   <!---------------------------------- FIN FUNCIONES  --------------------------------------->	
	</script>
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<!-------------------------------	Cuerpo Principal  ----------------------------->	
<body leftmargin="0" topmargin="0" marginwidth="3" marginheight="3">
 <form action="" method="post" name="form1" id="form1">
	<? include("../principal/encabezado.php");?>
    <!--------------------------------Tabla Principal ---------------------------------->
	<table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
      <tr>
        <td height="313" valign="top">  		 
		  <input type="hidden" name="valor" value="ing_trab.php" ><!--- recarga la misma pagina ---->   		 
		  <input type="hidden" name="rut_func" value="<? echo $rut_func; ?>">		  
		  <br>
   	      <!------------------ Sub-Tabla_A "Informacion del Accidentado"  ---->
  		  <table width="608" border="1" align="center" cellpadding="2" id="dv" cellspacing="0" class="TablaInterior">
				<tr  class="ColorTabla01"> 
					<td colspan="8">
						<strong>Informaci&oacute;n Del Accidentado</strong>
					</td>
				</tr>
				<tr>					
            	   <td width="124">Rut:</td>
				   <td colspan="3">
						&nbsp;&nbsp;<input name="rut" type="text" id="rut" size="10" align="top" class="InputColor"  readonly maxlength="9" value="<? echo number_format($rut_trab,0,',','.'); ?>"> 
						- 
						<input name="dv" type="text" id="dv" size="1" maxlength="1" align="top" class="InputColor" readonly value="<? echo $rut_trab_dv; ?>">
					</td>
				</tr> 
				<tr>					
              		<td width="124">Fecha Accidente:</td>
					<td colspan="3">
						&nbsp;&nbsp;<SELECT name="dia" class="Select01">
						<? for ($i=1;$i<=31;$i++){
						   if (isset($dia)){
							   if ($i == $dia)
								 echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
							   else
								 echo '<option value="'.$i.'">'.$i.'</option>';
							}else{
								if ($i == date("j"))
									echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
								else
									echo '<option value="'.$i.'">'.$i.'</option>';
							 }
						  } /**** Fin de For...  ***/
						?>
						</SELECT> 
						<SELECT name="Mes">
						<? for ($i=1;$i<=12;$i++){
							if (isset($Mes)){
								if ($i == $Mes)
									echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
								else
									echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
							}else{
								if ($i == date("n"))
								   echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
								else
									echo "<option value='".$i."'>".$Meses[$i-1]."</option>";
							}
						 }/*** Fin del For...   **/
					   ?>
					   </SELECT>
					   <SELECT name="ano">
					   <?   for ($i=date("Y");$i<=date("Y")+1;$i++){
								if (isset($Mes)){
									if ($i == $ano)
										echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
									else
										echo '<option value="'.$i.'">'.$i.'</option>';
								}else{
									if ($i == date("Y"))
										echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
									else
										echo '<option value="'.$i.'">'.$i.'</option>';
								}
							}/*** Fin del For...  **/
					   ?>
					   </SELECT>
					   <input name="fecha_acc" type="hidden" value="<? echo $ano.'-'.$Mes.'-'.$dia;?> "> 					   
				     </td>
				  </tr>			
				  <tr> 
					  <td width="124">Nombres:</td>
					  <td width="125">&nbsp;&nbsp;<input name="nombres" type="text" value="<? echo $nombres ;?>" class="InputColor" size="20" maxlength="50" readonly></td>
					  <td width="61">Apellidos:</td>
					  <td width="171">&nbsp;&nbsp; <input name="apellidos" type="text" value="<? echo $ap_paterno." ".$ap_materno; ?>" class="InputColor" size="25" maxlength="50" readonly></td>
	  			 </tr>
				 <tr> 
				 	 <td width="124">Centro Costo:</td>
				 	 <td colspan="3">
						&nbsp;&nbsp;<input name="c_costo" class="InputColor" type="text" value="<? echo $c_costo ;?>" size="4" maxlength="6" readonly>
						 - 
						<input type="text" name="descrip" class="InputColor" value="<? echo $descrip; ?>" size="50" maxlength="100" readonly>
					 </td>
				 </tr>
				 <tr> 
					<td>AFP:</td>
					<td colspan="2">&nbsp;&nbsp;<input name="nom_afp"  class="InputColor"type="text" value="<? echo $nom_afp;?>" size="40" maxlength="45" readonly></td>
					<td>&nbsp;&nbsp;<input type="text" class="InputDer" name="porc_afp" value="<? echo $porc_afp; ?>" size="8"> % </td>
				</tr>
				<tr> 
				<? 				    
					if ($codigo_isapre == 50) // me pregunta si el cod. isapre es "fonasa"
					{		
					    $consulta = "SELECT porcent from subs_web.fonasa where fecha=(SELECT max(fecha) from subs_web.fonasa)";
					    $respuesta = mysql_query($consulta);
					    $row = mysql_fetch_array($respuesta);
					    $porc_salud = $row[porcent];
						$fonasa='s';
						$nom_salud = "%";
					} else {
						//$porc_salud = "";//para el caso de tener pactacion entonces se procedera a su busqueda			
						$fonasa='n';
						$nom_salud = "U.F";
					}
				?>			
					<td>Isapre:</td>
					<td colspan="2">
						&nbsp;&nbsp;<input name="nom_isapre"  class="InputColor" type="text" value="<? echo $nom_isapre = substr($nom_isapre,1,40);?>" size="40" maxlength="45" readonly>
					</td>
					<td>
						&nbsp;&nbsp;<input type="text" class="InputDer" name="pac_uf" value="<? echo $porc_salud; ?>" size="8">
						<label><? echo $nom_salud; ?></label> 
						<!--   Trarar de solucionar para que me pesque solo el rut en la otra pagina (valor_diario)  -->
							<input type="text" name="EsFonasa" value="<? echo $fonasa; ?>" size="1"> 
							<script>
								form1.EsFonasa.style.visibility='hidden';
							</script>
						<!--------------------------------------------------------------------------------------------->
					</td>
				</tr>
		   </table>
		   <!------------------ Fin Sub-Tabla_A "Informacion del Accidentado"  -->
		  <br>
		  <!--  Sub-Tabla_B "Dias de Licencias" (desde, hasta, dias, valor)  -->
		  <table width="608" border="1" align="center" cellpadding="2"  cellspacing="0" class="TablaInterior">
			<tr class="ColorTabla01">
			  <td colspan="7" ><strong>Licencias</strong></td>
			</tr>
			<tr class="ColorTabla02" align="center"> 
			  <td width="25%"><b>Desde&nbsp;<em>(dd/mm/aaaa)</em></b></td>
			  <td width="25%"><b>Hasta&nbsp;<em>(dd/mm/aaaa)</em></b></td>
			  <td width="16%" ><b>D&iacute;as de Licencias</b></td>
  			  <td width="10%"><b>Calcular</b></td>			  
			  <td width="26%"><b>Valor Licencias</b></td>  
   			  <td width="10%"><b>Detalle</b></td>			  
			  
			</tr>
			<tr> 
			  <td colspan="4"> 
			  <? if($opcion=='AF'){// Si opcion es AF agregar Fila
			  	 $numero=$filasel; //filesel corresponde a la fila seleccinada por el usuario
				 $pagado_lic[$numero]= $colocar_valor;
				   for($i=0;$i<$n;$i++){
					  $punt = "puntitos(this,this.value.charAt(this.value.length-1))";
					  $df1 = "DateFormat(this,this.value,event,true, 3)";
						  $df2 = "DateFormat(this,this.value,event,false, 3)";
					  $js = "javascript:vDateType=3";				  
					  echo '<tr align="center">';
						  echo '<td><input type="text" class="InputDer" name="desde_lic['.$i.']" value="'.$desde_lic[$i].'" size="11" maxlength="10" onblur="'.$df1.'" onkeyup="'.$df2.'" onfocus="'.$js.'"></td>';
						  echo '<td><input type="text" class="InputDer" name="hasta_lic['.$i.']" value="'.$hasta_lic[$i].'"size="11" maxlength="10" onblur="'.$df1.'" onkeyup="'.$df2.'" onfocus="'.$js.'"  onChange="recargar('.$n.')"></td>';						  
					      $dias_lic[$i]=resta_fechas($hasta_lic[$i],$desde_lic[$i]);
						  $fecha_hasta=$hasta_lic[$i];
						  $ano_hasta=$fecha_hasta[6]."".$fecha_hasta[7]."".$fecha_hasta[8]."".$fecha_hasta[9];
						  $mes_hasta=$fecha_hasta[3]."".$fecha_hasta[4];
						  $dia_hasta=$fecha_hasta[0]."".$fecha_hasta[1];
						  if (($ano_hasta<=999) || ($mes_hasta >13) || ($dia_hasta>=32)){
						  	$dias_lic[$i]=0; //inicializa el numero de dias en cero cuando no esta en el rango correspondiente
						  }
						  if ($dias_lic[$i]==10) // Si la licencia tiene 10 dias entonces se le descuenta 3 dias
						  {
							$dias_lic[$i]=$dias_lic[$i]-3;	
						  }	
						  echo '<td><input type="text" class="InputColor" name="dias_lic['.$i.']" value="'.$dias_lic[$i].'" size="4" maxlength="3" readonly></td>';						  						  				
						  ?><td><input type="radio" name="opt_calcular" value="<? echo $i; ?>" onClick="Calcular(<? echo $n.",".$i; ?>)"  ></td><?						   
						  echo '<td><input type="text"  class="InputColor" name="pagado_lic['.$i.']" value="'.$pagado_lic[$i].'" size="11" maxlength="10" onKeyUp="'.$punt.'" readonly > </td>';						  
						  ?><td><input type="radio" name="opt_detalle" value="<? echo $i ?>" onClick="Detalle()" ></td><?
					  echo '</tr>'; 						    
					  $num = $n;
					  $valor = "";
				   }/*** Fin del For...   ***/
				}	
			  ?>
			  </td>
			</tr>
			<tr class="ColorTabla02"> 
			  <td colspan="6" >
				<div align="center">
					<div align="left"><font face="Arial, Helvetica, sans-serif"> </font></div>
					<div align="left"></div>
					<div align="left"> <font face="Arial, Helvetica, sans-serif"> </font></div>
					<div align="left"></div>
					<div align="center"><font face="Arial, Helvetica, sans-serif"> 
						<? if ($num=='')
							{$num=0;} ?>
						<input name="boton_agregar" class="ErrorSI"type="button" value="Agregar Fila" style="width:100" onClick="agregar(<? echo $num;?>)">
						<input name="boton_borrar" class="ErrorSI" type="button" value="Eliminar Fila" style="width:100" onClick="borrar(<? echo $num;?>)">
					</font></div>
				</div>
			  </td>
			</tr>
		</table>
	  <!--  Fin Sub-Tabla_B "Dias de Licencias" (desde, hasta, dias, valor)  --->
	  <br><br>
        <table width="400" border="0" cellspacing="0" cellpadding="3" class="TablaInterior" align="center">
          <tr align="center" valign="middle">
				<td><input type="button" name="Guardar" value="Guardar" style="width:70px"></td>
    	        <td><input name="BtnSalir" type="button" id="BtnSalir" value="Volver" style="width:70px" onClick="Volver()"></td>
			  </tr>
		 </table>			
	     <p>&nbsp; </p>  	
	   </center>
      </td> 
	</tr>
  </table>
 <!------------------------------Fin Tabla Principal ---------------------------------->
 <? include("../principal/pie_pagina.php");?>
 </form>  
</body>
</html>
<!--------------------------------------- FIN DE CODIGO  ------------------------------>
