<?Php
//---------------------------------  FUNCION msg_usuario  -------------------------------------//
// Esta Funcion me muestra  un mensaje al usuario si se inserto bien o no los datos en la BD  // 
function msg_usuario ($mensaje)
{
   if(isset($mensaje)&&($mensaje != "")){
		echo ' <script languaje = "Javascript">';
 		echo " alert('".$mensaje."')";
		$mensaje = "";
		echo ' </script>';
	}
}
//------------------------------  FIN FUNCION msg_usuario  -----------------------------------//
	include ("conectar.php");
	if ($grabar='s')
	//Grabar se refiere si se presiona el boton "Guardar" entonces me guarda los datos ingresados //
	{
		$fecha = $ano1."/0".$mes1."/01";
		$valor_uf = str_replace('.','', $valor_uf); // Elimina puntos
		$msg_error_uf="n";
		/*************************Guardar_Valor_UF***************************/		
		if(($guardar=="uf")||($guardar=="ui"))
		{
			$eliminar="DELETE FROM subs_web.mes_uf WHERE fecha = '".$fecha."'";
			mysql_query($eliminar);
			$insertar="INSERT INTO subs_web.mes_uf (fecha,valor) values ('".$fecha."','".$valor_uf."')";
			if($consulta = mysql_query($insertar)){
				$msg_error_uf="n";
			}else{			
				$msg_error_uf="s";
		   }
		}
		/*********************Guardar_Impuesto_Unico*************************/
		$msg_error_ui="n";
		if ((($guardar=="im")||($guardar=="ui")) && ($msg_error_uf=="n"))
		{
		   $consulta = "SELECT COUNT(*) FROM subs_web.detalle_mes WHERE fecha = '".$fecha."'";
		   $respuesta = mysql_query($consulta);
		   if ($respuesta!=0)
		   {	
			   for($puntero=0;$puntero<=7; $puntero++)
			   {	
				 $eliminar="DELETE FROM subs_web.detalle_mes WHERE fecha = '".$fecha."'";	
				 mysql_query($eliminar);
			   }// fin While ..   //  
		   }	   	   
		   while ((list($clave,$valor) = each($desde)) && ($msg_error_ui=="n"))
		   {
			 if($hasta[$clave] == "y M�s..."){
				$hasta[$clave] = "-1";
			 }// fin If...  ///
			 $hasta[$clave] = str_replace('.','', $hasta[$clave]);
 			 $desde[$clave] = str_replace('.','', $desde[$clave]);
			 $insertar="INSERT INTO subs_web.detalle_mes (fecha,desde,hasta,factor,rebaja) values ('".$fecha."','".$desde[$clave]."','".$hasta[$clave]."','".$factor[$clave]."','".$rebaja[$clave]."')";		
			 if($consulta = mysql_query($insertar)){
				$msg_error_ui="n";
			 }else{
				$msg_error_ui="s";
			 }// fin If...  ///
		 }// fin While ..   //
	   }// fin If...  ///		
	  //******************* Mensaje a mostrar  ****************//
	   if (($msg_error_uf=="s") && ($msg_error_ui=="n"))
	   {
		   msg_usuario("Error al Ingresar la U.F");		
	   } 
	   if (($msg_error_uf=="n") && ($msg_error_ui=="s"))
	   {
		   msg_usuario("Error al Ingresar Imp. Unico");		
	   }
	   if (($msg_error_ui=="s") &&($msg_error_uf=="s"))
	   {
		   msg_usuario("Error al Ingresar la U.F e Imp. Unico");		
	   }
/*	   if (($msg_error_ui=="n") &&($msg_error_uf=="n"))
	   {
		   msg_usuario("Los Datos se Ingresaron Correctamente ");		
	   }*/
	   if (($msg_error_ui="n") && ($guardar=="im")&&($msg_error_uf=="n"))
	   {
		   msg_usuario("Los Datos se Ingresaron Correctamente ");		
	   }
   }
 ?>
  
<!-------------------------------------- Inicio de Html  -------------------------------------->
<html>
<head>
	<title>Ingreso de UF e Impuesto &Uacute;nico</title>
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
	<script javacript language="JavaScript" src="funciones.js">/* puntitos*/</script>
	<script javacript language="JavaScript">
	<!---------------------------------  FUNCIONES  -------------------------------->
		<!-----------  Recarga -------->		
		function RecargaPag ()
		// Funcion que se recarga la pagina
		{
			var f = document.FrmGuardar;
			f.action = "popup_ing_iu.php";
			f.submit();					
		}		
		<!-----------  Guardar -------->			
		function Guardar()
		// Funcion que me guarda los datos que ingrese, ya sea la UF o Imp. Unico //
		{
			var f = document.FrmGuardar;						
			for(i=5;i<=34;i++)
			{
				if(f.elements[i].value == "") // Valida dew que no exista valores en vlancos
				{
					alert("Existe un campo vacio, verifique e\ningrese un valor para continuar");
					f.elements[i].focus();
					return;
				}
			}	
			if(f.valor_uf.value == "") /* Guarda Im pero no Uf*/
			{
				var estado = confirm("El campo de la UF esta vac�o\n�Desea Continuar?\n\n(Solo se ingresara el impuesto unico, no la UF.)");
				if(estado){
					f.action = "popup_ing_iu.php?guardar=im&grabar=s";
					f.submit();		
				}else{
					f.valor_uf.focus();
				}
			}
			if(f.valor_uf.value != "") /* Guarda Im y Uf */
			{
				f.action = "popup_ing_iu.php?grabar=s&guardar=ui"+"&mes1="+f.mes1.value+"&ano1="+f.ano1.value+"&valor_uf="+f.valor_uf.value;
				f.submit();		
			}   	
		}	
		<!-----------  Limpiar Imp. Unico -------->		
		function LimpiarIu()
		// Funcion que me limpia los campos //
		{
			var f = document.FrmGuardar;
			f.valor_uf.value = "";
			var campo_factor=5;	
			f.elements[3].value = "0";
			var x = 6;
			for(i=4;i<=34;i++){
				if(i!=(6*i)){
					if (i!=campo_factor){
						f.elements[i].value = "";
					} else {
						campo_factor=campo_factor+4;
					}	
				}
			}
			f.elements[32].value = "y M�s...";
		}
		<!-----------  Copiar -------->		
		function copiar()
		// Funcion que me copia el valor Hasta en el campo Desde(Sumandole uno mas)  //
		{		
			var f = document.FrmGuardar;
			var col = 3;
			var texto="";
			f.elements[col].value = "0";
			f.elements[col+29].value = "y M�s...";
			if(f.elements[col+1].value != "")
			{
				texto=f.elements[col+1].value.replace(".",""); // Quita el punto
				texto=texto.replace(".","");// Quita el punto
				f.elements[col+4].value = parseInt(texto)+1; // Me suma uno mas
			}
			if((f.elements[col+5].value != "")&&(f.elements[col+5].value > f.elements[col+1].value))
			{
				texto=f.elements[col+5].value.replace(".","");// Quita el punto
				texto=texto.replace(".","");// Quita el punto
				f.elements[col+8].value = parseInt(texto)+1; // Me suma uno mas
			}
			if((f.elements[col+9].value != "")&&(f.elements[col+9].value > f.elements[col+5].value))
			{
				texto=f.elements[col+9].value.replace(".","");// Quita el punto
				texto=texto.replace(".","");// Quita el punto
				f.elements[col+12].value = parseInt(texto)+1;// Me suma uno mas
			}
			if((f.elements[col+13].value != "")&&(f.elements[col+13].value > f.elements[col+9].value))
			{
				texto=f.elements[col+13].value.replace(".","");// Quita el punto
				texto=texto.replace(".","");// Quita el punto
				f.elements[col+16].value = parseInt(texto)+1;// Me suma uno mas
			}
			if((f.elements[col+17].value != "")&&(f.elements[col+17].value > f.elements[col+13].value))
			{
				texto=f.elements[col+17].value.replace(".","");// Quita el punto
				texto=texto.replace(".","");// Quita el punto
				f.elements[col+20].value = parseInt(texto)+1;// Me suma uno mas
			}
			if((f.elements[col+21].value != "")&&(f.elements[col+21].value > f.elements[col+17].value))
			{
				texto=f.elements[col+21].value.replace(".","");// Quita el punto
				texto=texto.replace(".","");// Quita el punto			
				f.elements[col+24].value = parseInt(texto)+1;// Me suma uno mas
			}
			if((f.elements[col+25].value != "")&&(f.elements[col+25].value > f.elements[col+21].value))
			{
				texto=f.elements[col+25].value.replace(".","");// Quita el punto
				texto=texto.replace(".","");// Quita el punto			
				f.elements[col+28].value = parseInt(texto)+1;// Me suma uno mas
			}
		}
		<!-----------  Recargar -------->		
		function Recarga (grabar, pantalla_contra, mes1, ano1, valor_uf,rut)
		// Funcion que me recarga la pagina con parametros //
		{
			var f = document.FrmGuardar;
			f.action = "popup_ing_iu.php?grabar="+grabar+"&pantalla_contra="+pantalla_contra+"&mes1="+mes1+"&ano1="+ano1+"&valor_uf="+valor_uf+"&rut="+rut;
			f.submit();
		}
		<!-----------  CambiarContra -------->		
		function CambiarContra(grabar, pantalla_contra, mes1, ano1, valor_uf,rut)
		// Funcion que me permite cambiar la contrase�a de usuario //
		{
			var f = document.FrmGuardar;
			var modificar_contra="s";
			// validacion de los campos que esten correcto (Pantalla de cambio de contrasena)
			switch (modificar_contra)
			{
				case "s"	:
					if (f.contra_actual.value == "")
					{
						alert("Debe ingresar Contrase�a Actual");
						f.contra_actual.focus();
						return;
					}
					if (f.contra_nueva.value == "")
					{
						alert("Debe ingresar Nueva Contrase�a");
						f.contra_nueva.focus();
						return;
					}
					if (f.repita_contra_nueva.value == "")
					{
						alert("Debe ingresar Nuevamente la Nueva Contrase�a");
						f.repita_contra_nueva.focus();
						return;
					}
					if (f.contra_nueva.value != f.repita_contra_nueva.value)
					{
						alert("La Contrase�a Nueva con la Repeticion");
						f.repita_contra_nueva.focus();
						return;
					}
			}
			f.action = "popup_ing_iu.php?modificar_contra=s&grabar="+grabar+"&pantalla_contra="+pantalla_contra+"&mes1="+mes1+"&ano1="+ano1+"&valor_uf="+valor_uf+"&rut="+rut;
			f.submit();
		}

		<!---- Salir ------>
		function Salir()
		// Funcion que cierra la ventana //
		{
			var f = document.FrmGuardar;
			window.close();
		}
   <!---------------------------------- FIN FUNCIONES  --------------------------------------->	
	</script>

<!------------------------------ Cuerpo Principal  -------------------------------------------->
<body leftmargin="0" topmargin="0" marginwidth="3" marginheight="3">
<form name="FrmGuardar" method="post">
  <!----------------------  Tabla Principal  ------------------------------------------->	
  <table width="397" height="409" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <?
	if ($pantalla_contra == 's') //Pantalla_contra se refiere a que si me muestra la pantalla de cambio de contrase�a //	
	// Si es asi entonce me muestra la panttalla //	
	{ ?>
	 <tr>			      
	   <td width="385" height="181" valign="top"> <br>
			<table width="97%" border="0" cellspacing="0" cellpadding="2" class="TablaInterior" align="center">
			  <tr align="center"> 					
				<td colspan="2"><strong>CAMBIO CONTRASE&Ntilde;A</strong></td>
			  </tr>
			  <tr> 
			    <td width="139">Password Actual</td>
			    <td width="67"><input name="contra_actual" type="password" value="" size="14" maxlength="8"></td>
			  </tr>
			  <tr> 
				<td>Nueva Password</td>
				<td><input name="contra_nueva" type="password" value="" size="14" maxlength="8"></td>
			  </tr>
			  <tr> 
				<td>Repetir Nueva Password</td>
				<td><input name="repita_contra_nueva" type="password" size="14" value="" maxlength="8"></td>
			  </tr>
			</table>
			<br>
			<table width="97%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior" align="center">
			  <tr align="center" valign="middle">
				<td><input type='button' name='BtnAceptar' value='Aceptar' onClick="JavaScript:CambiarContra('n','s','<? echo $mes1."','".$ano1."','".$valor_uf."','".$rut."'";?>);"  style='width:70px;'></td>
				<td><input type="button" name="BtnCancelar" value="Cancelar" onClick="JavaScript:Recarga('n','n','<? echo $mes1."','".$ano1."','".$valor_uf."','".$rut."'";?>);" style="width:70px;"></td>
			  </tr>
			</table>
			<? 
			 if ($modificar_contra=='s') // modificar_contra se refiere a que si presiona "aceptar" me modifica la cantrase�a ingresada por el usuario //
			 {
				include("conectar.php");
				$ConsSql="SELECT * FROM usuarios WHERE (rut='".$rut."')";
				$respuesta = mysql_query($ConsSql);
				if($row=mysql_fetch_array($respuesta))
				{
					if (trim($row["password"])== trim($contra_actual))
					{
						$eliminar="DELETE FROM subs_web.usuarios WHERE password = '".$contra_actual."'";
						mysql_query($eliminar);
					    $insertar="INSERT INTO subs_web.usuarios (rut, password) values ('".$rut."','".$contra_nueva."')";
						if($consulta = mysql_query($insertar)){
							msg_usuario("Su Contrase�a se ha Modificado Correctamente");		
							echo ' <script languaje = "Javascript">';
							echo "Recarga('n','n','".$mes1."','".$ano1."','".$valor_uf."','".$rut."')";
							echo ' </script>';
						}else{			
							msg_usuario("Error al Modificar su Contrase�a");								
					    } // fin : if($consulta = mysql_query($insertar))...
					}
					else
					{
						msg_usuario("Su Contrase�a Actual es Incorrecta");
					} // fin :  if (trim($row["password"])== trim($contra_actual))...
				} // fin : if($row=mysql_fetch_array($respuesta))...
			 } //fin : if ($modificar_contra=='s').. ?>
			<br><br>
      	  </td>
		</tr>		
	 <? } 
		else // si no se quiere mostrar la pantalla de cambio de contrase�a entonce me muestra la otra pantalla
		{ ?>
		<tr>		
	   	  <td width="385" height="0" valign="top"> <br>
  	     	 <table width="167" border="0" cellspacing="1" cellpadding="1" align="right">
			   <tr>
				<td width="148" align="center" valign="middle"><a href="JavaScript:Recarga('n','s','<? echo $mes1."','".$ano1."','".$valor_uf."','".$rut."'";?>);"><img src="../principal/imagenes/llave01.gif" width="16" height="16" border="0" align="absmiddle"></a><font>&nbsp;<strong><a href="JavaScript:Recarga('n','s','<? echo $mes1."','".$ano1."','".$valor_uf."','".$rut."'";?>);" style="text-decoration:none; color:#000099; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">Cambiar
						 Password&nbsp;</a></strong></font>
				</td>
			   </tr>
			</table>
		 </td>			
	 	</tr>
		<tr>		
     	  <td> 
		  <!---------   Tabla Interna_A (mes,año,uf)  -------------------->
		  <table width="350" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
    	      <tr class="Detalle02"> 
        	    <td width="126">
				   <strong>Mes:</strong> <SELECT name="mes1" size="1" id="SELECT" onChange="RecargaPag()">
    	            <?Php						  	
							$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
							for($i=1;$i<13;$i++)
							{
							   if (isset($mes1))
							   {
								 if ($i == $mes1)
									echo '<option SELECTed value="'.$i.'">'.$meses[$i-1].'</option>';
								 else
									echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
							   }else
							    {
									if ($i == date("n"))
									   echo '<option SELECTed value="'.$i.'">'.$meses[$i-1].'</option>';
									else
									   echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
								} // Fin If.. Else... //						
							 } // Fin For...  //							 
							include("conectar.php");
							/*--------------------------------------------------------------------------------------------/*/	
							if (($mes1 >= 1) && ($mes1 <= 9)){ //Antepone un cero entre los meses enero-septiembre para formatear la busqueda//
								$mes1="0".$mes1;
							}
							$fecha_ingreso = $ano1."-".$mes1."-01";
							$consulta = "Select valor from subs_web.mes_uf where fecha ='".$fecha_ingreso."'";							
							$variable = mysql_query($consulta,$link);
							$row = mysql_fetch_array($variable); 
							$valor_uf =$row["valor"];								 
						 ?>
        		      </SELECT>
				</td>
            	<td width="104"> <strong>A&ntilde;o: </strong> 
					<strong> 
              		<SELECT name="ano1" size="1" id="SELECT2" onChange="RecargaPag()">
                	<?Php
							  for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
							  {
								 if (isset($ano1))
								 {
									if ($i == $ano1)
									   echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
									else
									   echo '<option value="'.$i.'">'.$i.'</option>';
									}else
									 {
										if ($i == date("Y"))
											echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
										else
											echo '<option value="'.$i.'">'.$i.'</option>';
								     }// Fin If... Else...  //
							    }// Fin For.. //
							 ?>
             	   </SELECT>
                   </strong> 
			  </td>
              <td width="99"> 
			  	<strong>UF :</strong> <input name="valor_uf" type="text" id="valor_uf2" size="10" maxlength="6" style="text-align:right" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value="<? echo number_format($valor_uf,0,',','.');?>" class="InputDer" > 				
              </td>
          </tr>
        </table>
        <!------------------------------ Fin Tabla Interna_A (mes,año,uf) ------------>
        <br>
        <!------------------------------ Tabla Interna_B (desde, hasta, factor, cant.rebaja)  --->
        <table width="350" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td colspan="2"> <div align="center"> <strong> Monto de la Renta<br>
                Liquida Imponible </strong> </div></td>
            <td width="81" rowspan="2"> <div align="center"> <strong>Factor</strong> 
              </div></td>
            <td width="80" rowspan="2"> <div align="center"> <strong>Cantidad 
                a Rebajar</strong> </div></td>
          </tr>
          <tr class="ColorTabla01"> 
            <td width="79"> <div align="center"> <strong>Desde</strong> </div></td>
            <td width="82"> <div align="center"> <strong>Hasta</strong> </div></td>
          </tr>
          <tr> 
            <td colspan="4"> <div align="center"> 
                <?Php  
							  if(strlen($mes1) == '1'){
								$mes1 = '0'.$mes1;
							  } // end if...  //				
							  $fecha_min = $ano1."-".$mes1."-01";
							  $fecha_max = $ano1."-".$mes1."-31";	 
							  $consulta = "SELECT desde,hasta,factor,rebaja FROM subs_web.detalle_mes WHERE (fecha >= '".$fecha_min."') and (fecha <= '".$fecha_max."') GROUP BY fecha, posicion";
							  $respuesta = mysql_query($consulta);
							  $consulta = mysql_query($consulta);
							  if($fila=mysql_fetch_array($consulta)){
							   $i='0';
							   while($row=mysql_fetch_array($respuesta)){
								  echo '<tr align="center" >';
								  echo '<td><input type="text" name="desde['.$i.']" value="'.number_format($row[desde],0,',','.').'" size="10" maxlength="9" class="InputDer" readonly></td>';
								  if ($row[hasta]==-1){	
								  	echo '<td><input type="text" name="hasta['.$i.']" value="y M&aacute;s..." class="InputDer" size="10" maxlength="9" ></td>';
								  } else {
	 								  echo '<td><input type="text" name="hasta['.$i.']" value="'.number_format($row[hasta],0,',','.').'"  size="10" maxlength="9" class="InputDer" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"  onBlur="copiar()"></td>'; /* problema con: */
								  }								
								  echo '<td><input type="text" name="factor['.$i.']" value="'.$row[factor].'" size="10" class="InputDer" maxlength="6" value="'.$row[factor].'" onKeyDown="TeclaPulsada(true)"></td>';
								  echo '<td><input type="text" name="rebaja['.$i.']" value="'.$row[rebaja].'" size="10"  class="InputDer" maxlength="9" onKeyDown="TeclaPulsada(true)"></td>';
								  echo '</tr>';
								  $i++;
								}
							  }else{
								  $respuesta = mysql_query($consulta);
								  $consulta = "SELECT factor FROM subs_web.detalle_mes WHERE fecha = (SELECT max(fecha) from subs_web.detalle_mes) GROUP BY fecha, posicion";
								  $respuesta = mysql_query($consulta);
								  $i='0';
								  while($row=mysql_fetch_array($respuesta)){
									  echo '<tr align="center" >';
									  echo '<td><input type="text" name="desde['.$i.']" size="10" maxlength="9" readonly></td>';
									  echo '<td><input type="text" name="hasta['.$i.']" size="10" maxlength="9" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" onBlur="copiar()"></td>';
									  echo '<td><input type="text" name="factor['.$i.']"size="10" maxlength="6" value="'.$row[factor].'"></td>';
									  echo '<td><input type="text" name="rebaja['.$i.']" size="10" maxlength="9"></td>';
									  echo '</tr>';
									  $i++;
								  }	  	  
							 }				

						  ?>
              </div>
              <div align="center"> </div>
              <div align="center"> </div>
              <div align="center"> </div></td>
          </tr>
        </table> 
        <!------------------------------ Fin Tabla Interna_B (desde, hasta, factor, cant.rebaja)  --->
		<br>
        <table width="350" border="0" cellspacing="0" cellpadding="3" class="TablaInterior" align="center">
          <tr align="center" valign="middle"> 
            <td width="114"><input type="button" name="BtnGuardar" value="Guardar" style="width:75" onClick="Guardar(this.form)" ></td>
            <td width="106"><input type="button" name="BtnLimpiar" value="Limpiar" style="width:75" onClick="LimpiarIu()"></td>
            <td width="109"><input type="button" name="BtnSalir" value="Salir" style="width:75" onClick="Salir()"></td>
          </tr>
        </table> 
		<br><br>
   	  </td>
	</tr>		
	<? } // fin : if ($pantalla_contra == 's') ..?>
</table>
</form>	
</body>
</html>
