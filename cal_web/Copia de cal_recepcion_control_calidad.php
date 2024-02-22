<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;
$CodigoDeSistema = 1;
$CodigoDePantalla = 5;
$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '1'  ";
$Respuesta =mysqli_query($link, $Consulta);
if($Fila =mysqli_fetch_array($Respuesta))
{
	$Nivel = $Fila["nivel"];
}
?>
<html>
<head>
<title>Administracion de Solicitudes de Muestreo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion)
{
	var frm=document.FrmRecepcion;
	switch (Opcion)
	{
		case "B": 
			frm.LimitIni.value=0;
			frm.action ="cal_recepcion_control_calidad.php?Mostrar=S";  
			frm.submit();
			break;	
		case "R":
			//RecuperarSA(FechaAtencion);
			Recepcionar();
			break;
			case "S":
			Salir();
			break;	
		case "D":
			ValidarDetalle();
			break;			
		case "E":
			ValidarCambiarEstado();
			break; 
	}	

}
function Activar()
{
	var frm=document.FrmRecepcion;
	try
	{
		frm.checkAtender[0];
		for (i=0;i<frm.checkAtender.length;i++)
		{
			if (frm.checkTodos.checked == true)
			{
				frm.checkAtender[i].checked = true;
			}
			else 
			{
				frm.checkAtender[i].checked = false;		
			}
		}
	}
	//si encuentra algun error no hace nada
	catch(e)
	{
	}
}
function Recepcionar() 
{
	var frm=document.FrmRecepcion;
	var ValoresSA="";	
	//Asigna a ValoresSA los valores recuperados de la funcion donde recupera la SA,rut,recargo 
	ValoresSA=RecuperarSolRecepcionar();
	if (ValoresSA=="")
	{
	}
	else
	{
		frm.action="cal_recepcion_control_calidad01.php?ValoresSA="+ ValoresSA + "&Opcion=R";
		frm.submit(); 
	}
}
function RecuperarSolRecepcionar()
{
	var frm=document.FrmRecepcion;
	var Encontro=false;
	var SARutRecargo ="";
	try 
	{
		frm.checkAtender[0];
		for (i=1;i<frm.checkAtender.length;i++)
		{
			if (frm.checkAtender[i].checked==true)
			{
				SARutRecargo = SARutRecargo + frm.TxtSAO[i].value + "~~" + frm.TxtRutO[i].value + "||" + frm.TxtRecargoO[i].value + "//" ;
				Encontro=true;
			}
		}
	}	
	catch (e)
	{
	 	 alert("No hay Elementos para Seleccionar");
	}
	if (Encontro==false)
	{
		alert("No hay Elementos para Seleccionar");
		return(SARutRecargo);
	}
	else
	{
		return(SARutRecargo);
	}
}
//**********************************************
function ExistenElementosCheck()
{
	var frm=document.FrmRecepcion;
	var EncontroCheck=false;
	
	try 
	{
		frm.checkAtender[0];
		for (i=1;i<frm.checkAtender.length;i++)
		{
			if (frm.checkAtender[i].checked==true)
			{
				EncontroCheck=true;
				break;
			}
		}
		if (EncontroCheck==true)
		{
			return(true);
		}
		else
		{
			return(false);					
		}
	}	
	catch (e)
	 {
	 	 alert("No hay Elementos para Seleccionar");
		 return(false);
	 }
}
function RecuperarSolRecepcionar()
{
	var frm=document.FrmRecepcion;
	var SARutRecargo="";
	var Solicitudes="";
	var CheckeoAtencion="";
	for (i=1;i<frm.checkAtender.length;i++)
	{ 
		
		if (frm.checkAtender[i].checked == true)
		{
			//concatena el campo oculto TxtSAO,el campo oculto TxtRutO,el campo oculto TxtrecargoO
			SARutRecargo = SARutRecargo + frm.TxtSAO[i].value + "~~" + frm.TxtRutO[i].value + "||" + frm.TxtRecargoO[i].value + "//" ;
			//Solicitudes =Solicitudes + frm.TxtSolicitudesO[i].value + " , " ;
		}
	}
	return(SARutRecargo);
}
function Salir()
{
	var frm =document.FrmRecepcion;
	frm.action="cal_adm_ingreso_leyes01.php?Opcion=S";
	frm.submit(); 
}
//funcion validar detalle
function ValidarDetalle()
{
	var frm =document.FrmRecepcion;
	var LargoForm =frm.elements.length;
	var SA="";
	var RutF="";
	var Recargo ="";
	var Muestra="";
	var Lotes="";
	var Productos="";
	var cont =0;
	var CheckeoDetalle=false;
	for (i=1;i<frm.checkAtender.length;i++)
	{
		if (frm.checkAtender[i].checked==true)
		{
			SA = frm.TxtSAO[i].value ;
			RutF =frm.TxtRutO[i].value ;
			Recargo = frm.TxtRecargoO[i].value
			Muestra =frm.TxtIdMuestra[i].value ;			
			Lotes =frm.TxtLotes[i].value ; 
			Productos =frm.TxtProducto[i].value ;
			window.open("cal_detalle_recepcion_calidad.php?SA="+ SA + "&RutF="+ RutF + "&Muestra="+ Muestra + "&Lotes="+ Lotes + "&Productos="+ Productos  + "&Recargo="+Recargo,"","top=200,left=35,width=780,height=300,scrollbars=no,resizable = yes");					
			break;
		}	
	}
}
//************************
function ValidarCambiarEstado()
{
	var frm=document.FrmRecepcion;
	var Estado="E";
	var TSaRutFecha="";	
	//Asigna a ValoresSA los valores recuperados de la funcion donde recupera la SA,rut,recargo para atenderlos
	TSaRutFecha=RecuperarSolEliminar();
	if (TSaRutFecha!="")
	{
		var mensaje = confirm("¿Seguro que desea Eliminar?");
		if (mensaje==true)
		{
			frm.action="cal_recepcion_control_calidad01.php?TSaRutFecha="+ TSaRutFecha + "&Opcion=E";
			frm.submit(); 
		}
		else
		{
			return;
		}
	}
}
function RecuperarSolEliminar()
{
	var frm=document.FrmRecepcion;
	var SaRutFechaHoraRecargo="";
	var Encontro=false;
	for (i=1;i<frm.checkAtender.length;i++)
	{ 
		if (frm.checkAtender[i].checked == true)
		{
			//concatena el campo oculto TxtSAO,el campo oculto TxtRutO,el campo oculto fecha,hora,TxtrecargoO
			SaRutFechaHoraRecargo = SaRutFechaHoraRecargo + frm.TxtSAO[i].value + "~~" + frm.TxtRutO[i].value + "//" + frm.TxtFechaO[i].value + ' ' + frm.TxtHoraO[i].value + frm.TxtRecargoO[i].value + "||" ;
			Encontro=true;
		}
	}
	if (Encontro==false)
	{
		alert("No Hay Elementos Seleccionados")
		return(SaRutFechaHoraRecargo);
	}
	else
	{
		return(SaRutFechaHoraRecargo);
	}
}

function Recarga(URL,LimiteIni)
{
	var frm=document.FrmRecepcion;
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "&LimitIni=" + LimiteIni;
	frm.submit(); 
}

</script>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmRecepcion" method="post" action="">
<?php
	if (!isset($LimitIni))
		$LimitIni = 0;
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <?php include("../principal/encabezado.php")?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="756"><table width="761" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="93"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              </strong>Usuario: </font></font></td>
            <td width="235"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
	  	$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
		{	
			echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
		}	  
	  	else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
					}
			}
		  ?>
              </strong></font></font></td>
            <td width="97">Fecha:</td>
            <td width="309"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php echo $Fecha_Hora ?>
              </strong>&nbsp; <strong> <?php
			if (!isset($FechaHora))
  			{
				echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
				$FechaHora=date('Y-m-d H:i');
 			}
  			else
  			{ 
				echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
  			}
		  ?>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td height="31">Fecha Inicio<font size="2">:&nbsp;&nbsp; </font> </td>
            <td height="31"><font size="2"> 
              <select name="CmbDias" id="select9" size="1" style="font-face:verdana;font-size:10">
                <?php
				for ($i=1;$i<=31;$i++)
				{
					if (isset($CmbDias))
					{
						if ($i==$CmbDias)
						{
							echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{
						  echo "<option value='".$i."'>".$i."</option>";
						}
					}
					else
					{
						if ($i==date("j"))
						{
							echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{
						  echo "<option value='".$i."'>".$i."</option>";
						}
					}	
				  }
				?>
              </select>
              </font> <font size="2"> 
              <select name="CmbMes" size="1" id="select10" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
			  for($i=1;$i<13;$i++)
			  {
					if (isset($CmbMes))
					{
						if ($i==$CmbMes)
						{
							echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
						}
						else
						{
							echo "<option value='$i'>".$meses[$i-1]."</option>\n";
						}
					
					}	
					else
					{
						if ($i==date("n"))
						{
							echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
						}
						else
						{
							echo "<option value='$i'>".$meses[$i-1]."</option>\n";
						}
					}	
				}
				?>
              </select>
              </font> <font size="2"> 
              <select name="CmbAno" size="1" id="select11" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
				for ($i=date("Y");$i<=date("Y");$i++)
				{
					if (isset($CmbAno))
					{
						if ($i==$CmbAno)
							{
								echo "<option selected value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}
					else
					{
						if ($i==date("Y"))
							{
								echo "<option selected value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}		
				}
				?>
              </select>
              </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha 
              Termino<font size="1"><font size="2"> </font><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              : </font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></td>
            <td><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
              <select name="CmbDiasT" id="select3" size="1" style="font-face:verdana;font-size:10">
                <?php
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDiasT))
				{
					if ($i==$CmbDiasT)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}
				else
				{
					if ($i==date("j"))
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}	
			}
			?>
              </select>
              </font> <font size="1"><font size="2"> 
              <select name="CmbMesT" size="1" id="select4" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
		  for($i=1;$i<13;$i++)
		  {
				if (isset($CmbMesT))
				{
					if ($i==$CmbMesT)
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				
				}	
				else
				{
					if ($i==date("n"))
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				}	
		   }
		   ?>
              </select>
              </font></font> <font size="2"> 
              <select name="CmbAnoT" size="1" id="select5" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAnoT))
				{
					if ($i==$CmbAnoT)
						{
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}
				else
				{
					if ($i==date("Y"))
						{
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}		
			}
			?>
              </select>
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font>&nbsp;&nbsp;&nbsp;&nbsp;<font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></font></font></font></td>
          </tr>
          <tr> 
            <td height="31"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Estado: 
              </font></td>
            <td height="31">
              <select name="CmbEstado" style="width:220"  >
                <option value="-1" selected>Todas</option>
                <?php
				 $CmbEstadoAux=$CmbEstado;
				 if ($Mostrar=="S")
				 {
					if (($Nivel=="1")||($Nivel=="2")||($Nivel=="3")||($Nivel=="12"))
					{
						if ($CmbEstado !="-1")
						{
							$CmbEstado=substr($CmbEstado,0,strlen($CmbEstado)-1);
						}
					}
				 }
				 $Consulta =  "select * from sub_clase where cod_clase = 1002 and (cod_subclase ='3' or cod_subclase ='4' or cod_subclase = '12')";
				 $Resultado = mysqli_query($link, $Consulta);
				 while ($Fila =mysqli_fetch_array ($Resultado))
				 {
					if ($CmbEstado == $Fila["cod_subclase"])
					{
						//echo"<option value=''>'entre'</option>";
						if ($Fila["cod_subclase"]=="3")
						{
							switch ($Nivel)
							{
								case "5":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Enviada a Laboratorio</option>";
									break;
								case "6":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Enviada a Laboratorio</option>";
									break;
								case "10":
									echo"<option value='".$Fila["cod_subclase"]."'selected>Enviada a  Ensayo Fisico</option>";
									break;
								default:
									if ((substr($CmbEstadoAux,strlen($CmbEstadoAux)-1,1))=="Q")
									{
										echo"<option value='".$Fila["cod_subclase"]."Q' selected>Enviada  a Laboratorio</option>";
										echo"<option value='".$Fila["cod_subclase"]."F'>Enviada a  Ensayo Fisico</option>";
									}
									else
									{	
										
										echo"<option value='".$Fila["cod_subclase"]."Q' >Enviada a Laboratorio</option>";
										echo"<option value='".$Fila["cod_subclase"]."F' selected>Enviadad a  Ensayo Fisico</option>";
									}	
									break;
							}	
						}
						if ($Fila["cod_subclase"]=="4")
						{
							switch ($Nivel)
							{
								case "5":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Recepcionado Laboratorio Quimico</option>";
									break;
								case "6":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Recepcionado Laboratorio Quimico</option>";
									break;
								case "10":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Recepcionado Ensayo Fisico</option>";
									break;
								default:
									if ($Mostrar=='N')
									{
										//echo"<option value=''>'Mostrar = N'</option>";	
										$CmbEstadoAux=$CmbEstadoAux.'Q';
									}
									if ((substr($CmbEstadoAux,strlen($CmbEstadoAux)-1,1))=="Q")
									{
										//echo"<option value=''>'entre AL IFF'</option>";
										echo"<option value='".$Fila["cod_subclase"]."Q' selected>Recepcionado Laboratorio Quimico</option>";
										echo"<option value='".$Fila["cod_subclase"]."F'>Recepcionado Ensayo Fisico</option>";
									}
									else
									{	
										//echo"<option value=''>'entre AL ELSE'</option>";
										echo"<option value='".$Fila["cod_subclase"]."Q'>Recepcionado Laboratorio Quimico</option>";
										echo"<option value='".$Fila["cod_subclase"]."F' selected>Recepcionado Ensayo Fisico</option>";
									}	
									break;
							}		
						}
						if ($Fila["cod_subclase"]=="12")
						{
							switch ($Nivel)
							{
								case "5":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Directo a Laboratorio</option>";
									break;
								case "6":
									echo"<option value='".$Fila["cod_subclase"]."'selected>Directo a Laboratorio</option>";
									break;
								case "10":
									echo"<option value='".$Fila["cod_subclase"]."'selected>Directo a Ensayo Fisico</option>";
									break;
								default:
									if ((substr($CmbEstadoAux,strlen($CmbEstadoAux)-1,1))=="Q")
									{
										echo"<option value='".$Fila["cod_subclase"]."Q' selected>Directo a Laboratorio</option>";
										echo"<option value='".$Fila["cod_subclase"]."F'>Directo a Ensayo Fisico</option>";
									}	
									else
									{
										echo"<option value='".$Fila["cod_subclase"]."Q'>Directo a Laboratorio</option>";
										echo"<option value='".$Fila["cod_subclase"]."F' selected>Directo a Ensayo Fisico</option>";
									}	
									break;
							}		
						}
					}	
					else 
					{
						if ($Fila["cod_subclase"]=="3")
						{
							switch ($Nivel)
							{
								case "5":
									echo"<option value='".$Fila["cod_subclase"]."'>Enviado a Laboratorio</option>";
									break;
								case "6":
									echo"<option value='".$Fila["cod_subclase"]."'>Enviado a Laboratorio</option>";
									break;
								case "10":
									echo"<option value='".$Fila["cod_subclase"]."'>Enviado a Ensayo Fisico</option>";
									break;
								default:
									echo"<option value='".$Fila["cod_subclase"]."Q'>Enviado a Laboratorio</option>";
									echo"<option value='".$Fila["cod_subclase"]."F'>Enviado a Ensayo Fisico</option>";
									break;
							}	
						}
						if ($Fila["cod_subclase"]=="4")
						{
							switch ($Nivel)
							{
								case "5":
									echo"<option value='".$Fila["cod_subclase"]."'>Recepcionado en Laboratorio</option>";
									break;
								case "6":
									echo"<option value='".$Fila["cod_subclase"]."'>Recepcionado en Laboratorio</option>";
									break;
								case "10":
									echo"<option value='".$Fila["cod_subclase"]."'>Recepcionado en Ensayo Fisico</option>";
									break;
								default:
									echo"<option value='".$Fila["cod_subclase"]."Q'>Recepcionado en Laboratorio</option>";
									echo"<option value='".$Fila["cod_subclase"]."F'>Recepcionado en Ensayo Fisico</option>";
									break;
							}		
						}
						if ($Fila["cod_subclase"]=="12")
						{
							switch ($Nivel)
							{
								case "5":
									echo"<option value='".$Fila["cod_subclase"]."'>Directo a Laboratorio</option>";
									break;
								case "6":
									echo"<option value='".$Fila["cod_subclase"]."'>Directo a Laboratorio</option>";
									break;
								case "10":
									echo"<option value='".$Fila["cod_subclase"]."'>Directo a Ensayo Fisico</option>";
									break;
								default:
									 
									echo"<option value='".$Fila["cod_subclase"]."Q'>Directo a Laboratorio</option>";
									echo"<option value='".$Fila["cod_subclase"]."F'>Directo a Ensayo Fisico</option>";
									break;
							}		
						}
					}
				 }
				$CmbEstado=$CmbEstadoAux; 
			 ?>
              </select></td>
            <td>Lineas por Pág.:</td>
            <td> <div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></strong> </font></font></strong> </font></font></div>
              <div align="left"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font><font size="1"><font size="2"> 
                <input name="LimitFin" type="text" value="<?php echo $LimitFin; ?>" size="12" maxlength="12">
                </font><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <input name="BtnBuscar" type="submit" id="BtnBuscar3" style="width:60"value="Buscar" onClick="Proceso('B');">
                </font></font></font></font></font><font size="2"> </font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></div></td>
          </tr>
        </table>
        <br>
        <table width="761" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="87"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input name="checkTodos" type="checkbox" onClick="JavaScript:Activar();" value="checkbox">
              Todos</font></font></font></td>
            <td width="154"><div align="center">
                <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70"value="Eliminar" onClick="Proceso('E');">
              </div></td>
            <td width="136"><div align="center">
                <input name="BtnActualizar2" type="submit" id="BtnActualizar22"style="width:70" value="Actualizar">
              </div></td>
            <td width="187"><div align="center"><strong> 
               <?php
			  //echo $CmbEstado."<br>";
			   if (($CmbEstado != '4F')&&($CmbEstado != '4Q')&& ($CmbEstado != '4'))
			   {
			    	echo "<input name='BtnRecepcionar' type='button' style='width:80' value='Recepcionar' onClick=\"Proceso('R');\">";
               }
			   ?>
			    </strong></div></td>
            <td width="122">&nbsp;</td>
            <td width="36">&nbsp;</td>
          </tr>
        </table>
        <br>
        <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        </font></font> 
        <table width="760" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" >
          <tr class="ColorTabla01"> 
            <td height="20" colspan="2"><div align="center">S.A</div></td>
            <td width="103"><div align="left">Id Muestra</div></td>
            <td width="194"><div align="center"></div>
              <div align="center">Producto</div></td>
            <td width="75"><div align="center">Originador</div></td>
            <td width="96"><div align="center">Estado</div></td>
            <td width="77"><div align="center">F.Muestreo</div></td>
            <td width="66"><div align="center">F.Recep</div></td>
          </tr>
          <?php
	 	include ("../Principal/conectar_cal_web.php");	
		$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
		$CmbEstado=$CmbEstadoAux;
		if (($Nivel=="1")||($Nivel=="2")||($Nivel=="3")||($Nivel=="12"))
		{
			$Letra=substr($CmbEstado,strlen($CmbEstado)-1,1);
			if ($CmbEstado!="-1")
			{
				$CmbEstado=substr($CmbEstado,0,strlen($CmbEstado)-1);
			}
		}	
		switch ($Nivel) 
		{
			//si es el jefe laboratorio
			case "1":
				if ($Letra=='F')
				{
					$TipoAnalisis = " and (t1.cod_analisis = '2')  ";
					
				}
				if ($Letra=='Q')
				{
					$TipoAnalisis = " and (t1.cod_analisis = '1' )   ";
				}
				break;
			case "2":
				if ($Letra=='F')
				{
					$TipoAnalisis = " and (t1.cod_analisis = '2')  ";
					
				}
				if ($Letra=='Q')
				{
					$TipoAnalisis = " and (t1.cod_analisis = '1' )   ";
				}
				break;
			case "3":
				if ($Letra=='F')
				{
					$TipoAnalisis = " and (t1.cod_analisis = '2')  ";
				}
				if ($Letra=='Q')
				{
					$TipoAnalisis = " and (t1.cod_analisis = '1' )   ";
				}
				break;
			case "5": 
				$TipoAnalisis = " and (t1.cod_analisis = '1' ) ";
				break;
			case "6": 
				$TipoAnalisis = " and (t1.cod_analisis = '1' ) ";
				break;
			case "10": 
				$TipoAnalisis = " and (t1.cod_analisis = '2' ) ";
				break;
			case "12":
				if ($Letra=='F')
				{
					$TipoAnalisis = " and (t1.cod_analisis = '2')  ";
					
				}
				if ($Letra=='Q')
				{
					$TipoAnalisis = " and (t1.cod_analisis = '1' )   ";
				}
				break;
		}
		
		switch ($CmbEstado) 
		{
			//Todos
			case "-1":
				$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and ((t1.estado_actual = '3')or (t1.estado_actual = '4')or(t1.estado_actual = '12'))  and ((t1.cod_analisis = '1') or (t1.cod_analisis = '2'))";
				//$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and   (t1.estado_actual = '3') or(t1.estado_actual = '4') or (t1.estado_actual = '12') ";		 		
				break;
			case "3":
				//enviado a laboratorio por el jefe
				$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '3')".$TipoAnalisis ;
				break;		 
		 	case "4": 
		 		//Recepcionado en control de calidad
				$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '5')".$TipoAnalisis ;
				break;
			//directos de control de calidad
			case "12":
				$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '12') ".$TipoAnalisis ;
				break;
			default:
				//Todos
				//echo "Todos"."<br>";
				$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and ((t1.estado_actual = '3')or (t1.estado_actual = '4')or(t1.estado_actual = '12'))  and ((t1.cod_analisis = '1') or (t1.cod_analisis = '2'))";
				break;
		}
		$Consulta = "select t1.cod_tipo_muestra,t2.descripcion as nomproducto,t3.descripcion as nomsubproducto,";
		$Consulta = $Consulta."t1.rut_funcionario,t1.recargo,t1.fecha_hora,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado, ";
		$Consulta = $Consulta."concat(t4.nombres,' ',t4.apellido_paterno,' ',t4.apellido_materno) as nombreapellido, ";
		$Consulta = $Consulta."t4.apellido_paterno as ap_paterno, ";
		$Consulta =	$Consulta."t1.nro_solicitud,t1.id_muestra,t1.cod_analisis,t1.tipo_solicitud,t7.nombre_subclase,t6.cod_estado,t7.cod_subclase ";
		$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
		$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
		$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
		$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
		$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual =t6.cod_estado )";
		$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002'";
		$Consulta = $Consulta.$Estado."order by nro_solicitud,recargo_ordenado";
		$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
		echo "<input type='hidden' name='checkAtender'><input name ='TxtSAO' type = 'hidden'><input name ='TxtRutO' type = 'hidden'><input name ='TxtRecargoO' type = 'hidden'><input name ='TxtIdMuestra' type = 'hidden'><input name ='TxtLotes' type = 'hidden'><input name ='TxtFechaO' type = 'hidden'><input name ='TxtProducto' type = 'hidden'><input name ='TxtHoraO' type = 'hidden'>";
		//echo $Consulta."<br>";
		$Respuesta= mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Respuesta))
	  	{
			$TxtFechaMuestreo="";
			$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and (cod_estado = '13') ";
			//echo $Consulta."<br>";
			$Respuesta3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Respuesta3))
			{
				$TxtFechaMuestreo = $Fila3["fecha_hora"];
				//echo "FechaMuestreo".$TxtFechaMuestreo."<br>";
			}
			$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."')  and (cod_estado = '4') ";
			//echo $Consulta."<br>";
			$Respuesta3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Respuesta3))
			{
				$TxtFechaRecepcion = $Fila3["fecha_hora"];
				//echo "fechaRecepcion".$TxtFechaRecepcion."<br>";
			}
			echo "<tr>";
			echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value=''></td>"; 
			//solicitud especial
			if ($Fila["tipo_solicitud"] == 'R') 
			{
				echo "<td width='95'><div align='center'><input name='TxtSA' type='text' style= 'background:#F4F5BA' readonly style='width:95' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name ='TxtSAO' type = 'hidden' value =".$Fila["nro_solicitud"]."><input name ='TxtRutO' type = 'hidden' value =".$Fila["rut_funcionario"]."><input name ='TxtRecargoO' type = 'hidden' value ='N'><input name ='TxtLotes' type='hidden' value =''></div></td>";
			}
			if ($Fila["tipo_solicitud"] == 'A') 
			{
				if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
				{
					//solicitud automatica sin recargo
					echo "<td width='95'><div align='center'><input name='TxtSA' type='text' style= 'background:#F4F5BA' readonly style='width:95' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name ='TxtSAO' type = 'hidden' value =".$Fila["nro_solicitud"]."><input name ='TxtRutO' type = 'hidden' value =".$Fila["rut_funcionario"]."><input name ='TxtRecargoO' type = 'hidden' value ='N'><input name ='TxtLotes' type='hidden' value =".$TxtLotes =$Fila["id_muestra"]."></div></td>";				
				}
				else
				{
					//solicitud automatica
					echo "<td width='95'><div align='center'><input name='TxtSA' type='text' style= 'background:#F4F5BA' readonly style='width:95' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."'><input name ='TxtSAO' type = 'hidden' value =".$Fila["nro_solicitud"]."><input name ='TxtRutO' type = 'hidden' value =".$Fila["rut_funcionario"]."><input name ='TxtRecargoO'  type = 'hidden' value =".$Fila["recargo"]."><input name ='TxtLotes' type='hidden' value =".$TxtLotes =$Fila["id_muestra"]."></div></td>";			
				} 
			}				
      		echo "<td width='103'><div align='left'><input name='TxtIdMuestra' type='text' readonly style='width:103' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input name='TxtFechaO'  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input name ='TxtHoraO' type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
			echo "<td width ='170'><div align ='left'><input name ='TxtProducto' type='text' readonly style='width:170' maxlength='180' value ='".$TxtProducto= ucwords(strtolower($Fila["nomsubproducto"]))."'></div></td>";
      		echo "<td width ='75'><div align ='left'><input name ='TxtFuncionario' type='text' readonly style='width:75' maxlength='120' value ='".$TxtFuncionario=substr(ucwords(strtolower($Fila["nombreapellido"])),0,1).".".ucwords(strtolower($Fila["ap_paterno"]))."'></div></td>";
			if ($Fila["cod_analisis"]==1)
			{
				echo "<td width ='85'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:85' maxlength='85'value ='".$TxtEstado= $Fila["nombre_subclase"]." Lab Quim'><input name ='TxtFuncionario' type='hidden' readonly style='width:120' maxlength='120' value ='".$TxtFuncionario=ucwords(strtolower($Fila["nombreapellido"]))."'></div></td>";
			}
			else
			{
				echo "<td width ='85'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:85' maxlength='85'value ='".$TxtEstado= $Fila["nombre_subclase"]." Ens Fis'><input name ='TxtFuncionario' type='hidden' readonly style='width:120' maxlength='120' value ='".$TxtFuncionario=ucwords(strtolower($Fila["nombreapellido"]))."'></div></td>";					
			}	
			echo "<td width ='70'><div align ='left'><input name ='TxtFechaMuestreo' type='text' readonly style='width:70' maxlength='70'value ='".$TxtFechaMuestreo."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($TxtFechaMuestreo,11,8)."></div></td>";
			if ($Fila["cod_estado"]== '5') 
			{
     			echo "<td width ='70'><div align ='left'><input name ='TxtFechaRecepcion' type='text' readonly style='width:70' maxlength='70'value ='".$TxtFechaRecepcion."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraR= substr($TxtFechaRecepcion,11,8)."></div></td>";		

			}
			else
			{
				echo "<td width ='70'><div align ='left'><input name ='TxtFechaRecepcion' type='text' readonly style='width:70' maxlength='70'value =''><input name ='TxtHoraM' type='hidden' value =''></div></td>";		
			}
			echo "</tr>";
	   }
	   ?>
        </table>
        <table width="760" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="25" align="center" valign="middle">Paginas &gt;&gt; 
              <?php		
		$Consulta = "select count(*) as total_registros ";
		$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
		$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
		$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
		$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
		$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual =t6.cod_estado )";
		$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002'";
		$Consulta = $Consulta.$Estado;
		$Respuesta = mysqli_query($link, $Consulta);
		$Row = mysqli_fetch_array($Respuesta);
		$Coincidencias = $Row["total_registros"];
		$NumPaginas = ($Coincidencias / $LimitFin);
		$LimitFinAnt = $LimitIni;
		$StrPaginas = "";
		for ($i = 0; $i <= $NumPaginas; $i++)
		{
			$LimitIni = ($i * $LimitFin);
			if ($LimitIni == $LimitFinAnt)
			{
				$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
			}
			else
			{
				$StrPaginas.=  "<a href=JavaScript:Recarga('cal_recepcion_control_calidad.php?CmbEstado=".$CmbEstado."&Mostrar=S','".($i * $LimitFin)."');>";
				$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
			}
		}
		echo substr($StrPaginas,0,-15);
?>
            </td>
          </tr></table>
        <table width="761" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
          <tr> 
            <td width="314"><div align="right"> 
                <input name="BtnDetalle" type="button" id="BtnDetalle" style="width:70" value="Detalle" onClick="Proceso('D');">
              </div></td>
            <td width="160"><div align="center"> </div>
              <div align="center"> 
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');">
              </div></td>
            <td width="116">&nbsp;</td>
            <td width="144">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
 <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
