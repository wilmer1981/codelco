<?php
	/********************** Establecer Codigos ***********/
	$CodigoDeSistema = 19;
	$CodigoDePantalla = 1;
?>
<!-------------------------------------- Inicio de Html  -------------------------------------->
<html>
<head>
	<title>UF - Impuesto Unico</title>
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<script javacript language="JavaScript" src="funciones.js">/* puntitos*/</script>
	<script javacript language="JavaScript">
	<!---------------------------------  FUNCIONES  -------------------------------->
		<!-----------  Recarga -------->		
		function Recarga ()
		// Me Recarga la Pagina  //
		{
			var f = document.form1;
			f.action = "info_mensual.php";
			f.submit();					
		}		
		<!-----------  Detalles -------->		
		function detalles (fecha)
		// Funcion que me permite mostrar o no los detalles de los Impuesto Unico  //
		{
			var f = document.form1;
			if (f.boton_iu.value == "Mostrar Imp. Unico") // Muestra I.U //
			{
			   f.action="info_mensual.php?valor=info_mensual.php&var=2&opciones=N&valor_uf="+f.valor_uf.value+"&mes1="+f.mes1.value+"&ano1="+f.ano1.value;
			   f.submit();
			}
			if (f.boton_iu.value == "Ocultar Imp. Unico") // Oculta I.U //
			{
			   f.action="info_mensual.php?valor=info_mensual.php&var=1&opciones=S";
			   f.submit();
			}
		}
		<!-----------  Admministracion I.U -------->		
		function Adm_Imp_Un()
		// Funcion que me permite abrir la ventana de control de acceso  //
		{
			var f = document.form1;
			window.open("popup_registrar.php?&mes1="+f.mes1.value+"&ano1="+f.ano1.value+"&valor_uf="+f.valor_uf.value,"contrasena"," fullscreen=no,left=250,top=200,width=250,height=208,scrollbars=yes,resizable = no");			
		}		
		<!-----------  Guardar U.F -------->		
		function guardar_uf()
		// Funcion que me permite guardar la UF sin restriccion //
		{
			var f = document.form1;			
			if(f.valor_uf.value != "") // Si valor uf es distinto de vacio entonces me almacena el valor UF //
			{
			  f.action="proceso_im.php?guardar=uf"+"&mes1="+f.mes1.value+"&ano1="+f.ano1.value+"&valor_uf="+f.valor_uf.value;
			  f.submit();
			}
			else // sino me manda un mensaje //
			{
			  alert("El campo de la UF esta vacio\nIngrese un valor para continuar");
			  return;				  
			}
		}	
		<!----------- PopUp  -------->		
		function popup()
		// Funcion que me permite abrir una ventana con todos los valores de la UF  //
		{
			var f = document.form1;			
			window.open("popup_valor_uf.php","valor_uf"," fullscreen=no,left=165,top=100,width=200,height=350,scrollbars=yes,resizable = no");	
		}
		<!----------- Proceso (Salir) -------->		
		function Proceso(opt)
		// Funcion que me permite salir al menu principal //
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
   <!---------------------------------- FIN FUNCIONES  --------------------------------------->	
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<!------------------------------ Cuerpo Principal  -------------------------------------------->
<body>
	<form name="form1" method="post" action="">
		<? include("../principal/encabezado.php");?>
		 <!----------------------  Tabla Principal  ------------------------------------------->	
         <table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal" >
              <tr>
				<td height="313" valign="top">
				  <p align="center" class="Titulo1">
				  	<strong><br>
						 Valores Mensuales UF - Impuesto Unico
				 	</strong>
				  </p>
		  		  <!---------   Tabla Interna_A (mes,año,uf)  -------------------->
				  <table width="350" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior"	>
					<tr> 
					  <td width="75">
					  	Mes:
					  </td>
			  		  <td width="86">
					  	<SELECT name="mes1" size="1" id="SELECT" onChange="Recarga()">			  
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
						 ?>			
						</SELECT> 			  
						<?
						if (date( "w", mktime(0,0,0,date("m"),24,date("Y"))) == 0)
						{
							 $dia=23;
						} else {
							$dia=24;
						}
					    if ($muestra_fec_ini=='s'){// me muestra el mes actual con su valor para la primera vez que entra //
							$fecha_ingreso=date("Y")."-".date("m")."-".$dia;							
							$muestra_fec_ini='n';
						} else {	
							if (($mes1 >= 1) && ($mes1 <= 9)){ //Antepone un cero entre los meses enero-septiembre para formatear la busqueda//
								$mes1="0".$mes1;
							}
							if (date( "w", mktime(0,0,0,$mes1,24,$ano1)) == 0)
							{
								 $dia=23;
							} else {
								$dia=24;
							}
							$fecha_ingreso= $ano1."-".$mes1."-".$dia;	
						 }						 						
						$consulta = "Select valor from subs_web.mes_uf where fecha ='".$fecha_ingreso."'";					
						$variable = mysql_query($consulta,$link);
						$row = mysql_fetch_array($variable); 
						$valor_uf =$row["valor"];								 
						?>
						<input type="hidden" name="muestra_fec_ini" value="<? echo muestra_fec_ini; ?>">
					  </td>
					  <td width="67" align="right">
					  	A&ntilde;o:
					  </td>
			  		  <td width="94">
					  	<strong> 
						 <SELECT name="ano1" size="1" id="SELECT2" onChange="Recarga()">
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
				   </tr>
				   <tr> 			  		 
		             <td> Valor UF : ($)</td>
			  		 <td>
						<input name="valor_uf" class="InputDer" type="text" id="valor_uf2" size="10" maxlength="6" style="text-align:right" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))" value="<? echo number_format($valor_uf,0,',','.');?>" >
					 </td>
				     <td colspan="2">
						<div align="center">				
						  <input type="button" name="Submit" value="Guardar" style="width:75" onClick="guardar_uf(this.form);">			  
					      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')">
						</div>
					 </td>
			       </tr>
			  </table>		  		 
			  <!------------------------------ Fin Tabla Interna_A (mes,año,uf)  ---------------------------------------------->
			<br>
			<center>
				<hr width="50%" class="Borde">			
			   <?Php		       
			   // Me permite Mostrar u Ocultar el I.U (Se refiere al nombre del boton y su funcion)  //
				 if(($opciones == "S") || ($opciones == "")){
			   ?>
					<input type="button" name="boton_iu" value="Mostrar Imp. Unico" onClick="detalles('<? echo $fecha_ingreso; ?>')"> 					
			   <?
				 }else{
					echo '<input type="button" name="boton_iu" value="Ocultar Imp. Unico" onClick="detalles()"> ';
				 }
			   ?>
				  <input type="button" name="Submit3" value="Listar Valores UF" style="width:155" onClick="popup() ">
				<hr align="center" color="#000000" width="50%">			
		  </center>
		  <br>
		  <!-- Carga los detalles de Impuesto Mensual  -->
		  <? if(($var=='2') && ($var !="")){ ?>
				  <!------------------------------ Tabla Interna_B (desde, hasta, factor, cant.rebaja)  --->
				  <table width="350" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
					<tr class="ColorTabla01"> 
					  <td colspan="2">
						<div align="center">
							<strong>
								Monto de la Renta<br>
								Liquida Imponible
							</strong>
						</div>
					  </td>
					  <td width="81" rowspan="2">
						<div align="center">
							<strong>Factor</strong>
						</div>
					  </td>
					  <td width="80" rowspan="2">
						<div align="center">
							<strong>Cantidad a Rebajar</strong>
						</div>
					  </td>
					</tr>
					<tr class="ColorTabla01"> 
					  <td width="79">
						<div align="center">
							<strong>Desde</strong>
						</div>
					  </td>
					  <td width="82">
						<div align="center">
							<strong>Hasta</strong>
						</div>
					  </td>
					</tr>
					<tr  class="Detalle03"> 
					  <td colspan="4">
						<div align="center"> 
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
							   // Si existe datos para esa fecha entonces que muestre los valores //
							   while($row=mysql_fetch_array($respuesta)){
								  echo '<tr align="center"  class="Detalle03">';
								  echo '<td>'.number_format($row[desde],0,',','.').'</td>';
								  if ($row[hasta]==-1){
								  	echo '<td>y M&aacute;s...</td>';
								  } else {
	 								  echo '<td>'.number_format($row[hasta],0,',','.').'</td>';
								  }								
								  echo '<td>'.$row[factor].'</td>';
								  echo '<td>'.$row[rebaja].'</td>';
								  echo '</tr>';
								  $i++;
								} // fin while.. //
							    $nom_IU="Modificar Imp. Unico";
							  }else{ // de caso contrario, que me muestre solamente el factor
								  $respuesta = mysql_query($consulta);
								  $consulta = "SELECT factor FROM subs_web.detalle_mes WHERE fecha = (SELECT max(fecha) from subs_web.detalle_mes) GROUP BY fecha, posicion";
								  $respuesta = mysql_query($consulta);
								  $i='0';
								  while($row=mysql_fetch_array($respuesta)){
									  echo '<tr align="center"  class="Detalle03">';
									  echo '<td>----------</td>';
									  echo '<td>----------</td>';
									  echo '<td>'.$row[factor].'</td>';
									  echo '<td>----------</td>';
									  echo '</tr>';
									  $i++;									  
								  }	 // fin while.. 	  
								  $nom_IU="Ingresar Imp. Unico";
							 } // Fin If.. else..			
						  ?>
					    </div>
						 <div align="center"> </div>
						 <div align="center"> </div>
						 <div align="center"> </div>
				      </td>
					</tr>
				 </table>
				<p align="center">
					<input type="button" name="AdmIU" value="<? echo $nom_IU;?>" onClick="Adm_Imp_Un(this.form)">
				</p>
				 <!------------------------------ Fin Tabla Interna_B (desde, hasta, factor, cant.rebaja)  --->
			     <p align="center">
			<? }// Fin  Sentencia : if(($var=='2') && ($var !=""))... //?>
		         </p>
	         </td>
           </tr>
         </table>
		 <!------------------- Fin Tabla Principal  ------------------------------>	
		 <? include("../principal/pie_pagina.php");?>
	</form>
</body>
</html>	