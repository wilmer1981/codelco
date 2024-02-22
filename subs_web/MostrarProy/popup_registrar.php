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
//*************************************************************************//
?>
<!-------------------------------------- Inicio de Html  -------------------------------------->
<html>
<head>
	<title>Control de Ingreso</title>
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<script language="JavaScript">
	<!---------------------------------  FUNCIONES  -------------------------------->
		<!----- PopUp_Ingreso_ui ------->
		function PopUp_ingreso_iu (rut,mes1, ano1, valor_uf)
		{
		// Funcion que me abre la ventana de ingreso de I.U //
			f = document.ingreso;
			window.close(); // Cierra la ventana actual 
			window.open("popup_ing_iu.php?rut="+rut+"&mes1="+mes1+"&ano1="+ano1+"&valor_uf="+valor_uf,""," fullscreen=no,left=190,top=100,width=412,height=410,scrollbars=yes,resizable = no");					
		}
		<!----- PosicionarRut ------->		
		function PosicionarRut()
		// Funcion que me posiciona el raton en el campo rut //
		{
			f=document.ingreso;
		  	f.rut.focus();
		}
		<!----- Buscar ------->		
		function Buscar(buscar,mes1, ano1, valor_uf)
		// Funcion que me valida los datos y luego buscar el rut y su contrase�a //
		{
			f = document.ingreso;
			var opc = "s";
			// Verifica que se ingrese bien los datos //
			switch (opc)
			{
				case "s" :
					if (f.rut.value=="")
					{
						alert("Debe Ingresar el Rut");
						PosicionarRut();
						return;
					}
					if (f.contrasena.value=="")
					{
						alert("Debe Ingresar su Contrase�a");
						f.contrasena.focus();
						return;
					}
			}
			// si los datos estan correcto entonces recarga la pagina para la busqueda de los datos //
			f.action = "popup_registrar.php?buscar="+buscar+"&mes1="+mes1+"&ano1="+ano1+"&valor_uf="+valor_uf;
			f.submit();
		}
		<!----- Salir ------->		
		function Salir ()
		// Funcion que me cierra la ventana de aceso de control //
		{
			f = document.ingreso;
			window.close();
		}
   <!---------------------------------- FIN FUNCIONES  --------------------------------------->			
	</script>
</head>
<!---------------------- Cuerpo de Html  ----------------------------------------------------------------->  
<body leftmargin="0" topmargin="0" marginwidth="3" marginheight="3">
<?
	if ($buscar=='s') // buscar se refiere a la busqueda en la Base de Dato  del rut y contrase�a que el usuariuo ingreso //
	{
		include("conectar.php");
		$ConsSql="SELECT * FROM usuarios WHERE (rut='".$rut."')";
		$respuesta = mysql_query($ConsSql);
	  	if($row=mysql_fetch_array($respuesta)) // si se encontro el rut entonces..		
		{
			if (trim($row["password"])== trim($contrasena)) // Me realiza la comparacion de la contrase�a que ingrese 
			{ 
				echo ' <script languaje = "Javascript">';
				echo " PopUp_ingreso_iu ('".$rut."','".$mes1."','".$ano1."','".$valor_uf."')"; // voy a la funcion que me abre otra ventanba de ingreso IU
				echo ' </script>';
			} else {
				$contrasena ="";
				msg_usuario("Contrase�a Incorrecta");				
			} //fin : if (trim($row["password"])== trim($contrasena)) ..
		}
		 else
		{				
			msg_usuario("Rut Incorrecto");
			$rut="";
		} // fin : if($row=mysql_fetch_array($respuesta))..
	} // fin : if ($buscar=='s')..
?>
<form name="ingreso" method="post">
  <!----------------------  Tabla Principal  ------------------------------------------->	
	<table width="236" height="207" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
	  <tr>
		<td width="252" height="147" valign="top"> <br><br>		
		   		<!-------   Tabla de Control de Ingreso  ----------------->				
			  <table width="195" border="1" align="center" class="Detalle02">
					<tr class="ColorTabla01">					
						<td colspan="2"><b>Control de Ingreso I.U</b></td>
					</tr>
					<tr >
						<td width="94"><b> RUT :</b></td>
						<td width="85" align="center">	
							<input align="left" type="text" name="rut"   size="13" value="<? echo $rut;?>"  class="InputDer" maxlength="10">
							<input type="hidden" name="rut_func" value="<? echo $rut;?>">  <!-- Mando el rut escondido -->					 
	
						</td>
					</tr>		
					<tr >
						<td><b> CONTRASE&Ntilde;A :</b></td>						
			            <td align="center">
							  <input type="password" name="contrasena" value="<? echo $contrasena; ?>" size="13" maxlength="8" class="InputIzq"> 
            				  <input type="hidden" name="contrasena_func" value="<? echo  $contrasena; ?>"> <!-- Mando la contrasena escondido -->					 
						</td>
					</tr>		
			</table>
			<p align="center">
				 <input type="button" name="BtnAceptar" value="Aceptar"  class="boton" style="width:75" onClick="Buscar('s','<? echo $mes1."','".$ano1."','".$valor_uf."'";?>)">
				 <input type="button" name="BtnSalir" value="Salir" style="width:75" class="boton" onClick="Salir()">
			</p>
			<script>		
				PosicionarRut(); //Me permite posicionar el mouse en el campo rut (1� vez que entra)
			</script>			
 	  </td>
	 </tr>
   </table> 
</form>  	
</body>
</html>
