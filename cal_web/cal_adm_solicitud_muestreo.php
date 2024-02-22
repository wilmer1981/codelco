<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 3;
	include("../principal/conectar_principal.php");
	$Fecha_Hora = date("d-m-Y h:i");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut =$CookieRut;
	//echo $Valores_Check;
?>
<html>
<head>
<title>Administracion de Solicitudes de Muestreo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion,FechaAtencion)
{
	var frm=document.FrmMuestras;
	switch (Opcion)
	{
		case "B": 
			ValidarBuscar();
			break;	
		case "A":
			//llama a funcion para que la atiendan
			ValidarRecuperarSA(FechaAtencion);
			break;
		case "M":
			ValidarModificar();
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
		case "R":
			ValidarRecepcionar();
			break;
		case "As":
			ValidarRecuperacionAutomatica(FechaAtencion);
			break;
	}	

}
function  ValidarBuscar()
{
	var frm=document.FrmMuestras;
	if (frm.elements[7].value == "-1")
	{
		alert ("Seleccione un Estado");
		frm.CmbEstado.focus;
		return;
	}
	else
	{
		frm.LimitIni.value = 0;
		frm.action ="cal_adm_solicitud_muestreo.php";  
		frm.submit();
	}

}
 
function Activar()
{
	var frm=document.FrmMuestras;
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

//funcion que recupera nro_solicitud y rut y recargo para atenderlo automaticamete
//con la asignacion de estados automaticos
function ValidarRecuperacionAutomatica(FechaA)
{
	var frm=document.FrmMuestras;
	var ValoresSA="";	
	//Asigna a ValoresSA los valores recuperados de la funcion donde recupera la SA,rut,recargo para atenderlos
	ValoresSA=RecuperarSolRecepcionar();
	if (ValoresSA=="")
	{
	}
	else
	{
	frm.action="cal_atencion_solicitud_muestreo01.php?ValoresSA="+ValoresSA + "&FechaA="+ frm.FechaHora.value +"&Opcion=AS";
	frm.submit();
	}
}
function ImprimirEtiqueta()
{
	var frm=document.FrmMuestras;
	var ValoresSA="";	
	//Asigna a ValoresSA los valores recuperados de la funcion donde recupera la SA,rut,recargo para atenderlos
	ValoresSA=RecuperarSolRecepcionar();
	if (ValoresSA=="")
	{
	}
	else
	{
		window.open("cal_imprimir_etiqueta.php?SA="+ ValoresSA,"","top=50px,left=50px,width=500px,height=400px,scrollbars=yes,resizable = yes");					
	}
}
//funcion que recupera el nro_de_solicitud , el rut del funcionario y el recargo para 
//envuar dichos elementos para que sean atendidos con muestreo, humedad ,etc.  
function ValidarRecuperarSA(FechaA)
{
	var frm=document.FrmMuestras;
	var Solicitudes="";
	var ValoresSA="";	
	//Asigna a ValoresSA los valores recuperados de la funcion donde recupera la SA,rut,recargo para atenderlos
	ValoresSA=RecuperarSolRecepcionar();
	if (ValoresSA=="")
	{
	}
	else
	{
		window.open("cal_atencion_solicitud_muestreo.php?ValoresSA="+ ValoresSA + "&FechaA="+ FechaA + "&Solicitudes="+ Solicitudes,"","top=200,left=35,width=650,height=270,scrollbars=no,resizable = yes");							
	}
}
//para recepcionar
function ValidarRecepcionar() 
{
	var frm=document.FrmMuestras;
	var ValoresSA="";	
	//Asigna a ValoresSA los valores recuperados de la funcion donde recupera la SA,rut,recargo 
	ValoresSA=RecuperarSolRecepcionar();
	if (ValoresSA=="")
	{
	}
	else
	{
		frm.action="cal_atencion_solicitud_muestreo01.php?ValoresSA="+ValoresSA + "&FechaHora="+frm.FechaHora.value +"&Opcion=R";
		frm.submit();
	}
}
function RecuperarSolRecepcionar()
{
	var frm=document.FrmMuestras;
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
function ValidarModificar()
{
	var frm=document.FrmMuestras;
	var Cont=0;
	Encontro=false;
	//if (SoloUnElementoSolicitudesCheck())
	//{
		for (i=1;i<frm.checkAtender.length;i++)
		{
			if (frm.checkAtender[i].checked==true)
			{
				Cont=Cont+1;
				//alert(Cont);
				if (Cont >1)
				{
					//nada
				}
				else
				{ 
					SolA = frm.TxtSAO[i].value;
					Recargo = frm.TxtRecargoO[i].value;
					RutF=frm.TxtRutO[i].value;
					Fecha= frm.TxtFechaO[i].value +' '+frm.TxtHoraO[i].value;
					
				}
				Encontro=true;
			}
			
		}	
	//}	
	if (Cont > 1)
	{
		alert("Debe Seleccionar solo un elemento");
		return;
	}
	if (Encontro == false)
	{
		alert("No hay Elementos para seleccionar");
		return;
	}
	window.open("cal_modificacion_leyes.php?SolA="+ SolA +"&Recargo="+Recargo + "&Fecha="+ Fecha +"&RutF="+ RutF,"","top=200,left=35,width=580,height=300,scrollbars=no,resizable = yes");					
	
}	




function Salir()
{
	var frm =document.FrmMuestras;
	frm.action="cal_atencion_solicitud_muestreo01.php?Opcion=S";
	frm.submit(); 
}
function ValidarDetalle()
{
	var frm =document.FrmMuestras;
	var LargoForm =frm.elements.length;
	var SA="";
	var RutF="";
	var Recargo ="";
	var Muestra="";
	var Lotes="";
	var Productos="";
	var cont =0;
	var CheckeoDetalle=false;
	//if (SoloUnElementoSolicitudesCheck())
	//{
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
				window.open("cal_detalle_solicitud_muestreo.php?SA="+ SA + "&RutF="+ RutF + "&Muestra="+ Muestra + "&Lotes="+ Lotes + "&Productos="+ Productos + "&Recargo="+Recargo,"","top=200,left=0,width=770,height=380,scrollbars=no,resizable = yes");					
				break;
			}	
		}
	//}
}
function SoloUnElementoSolicitudesCheck()
{
	var frm=document.FrmMuestras;
	var CantCheck=0;
	try 
	{
		frm.checkAtender[0];
		for (i=1;i<frm.checkAtender.length;i++)
		{
			if (frm.checkAtender[i].checked==true)
			{
				CantCheck=CantCheck + 1;
				if (CantCheck==2)
				{
					break;
				}	
			}
		}
		switch (CantCheck)
		{
		 	case 0:
				alert("No hay Elementos Seleccionados");
				return(false)
				break;
			case 1:	
				return(true)
				break;
			case 2:
				alert("Debe Seleccionar solo un Elemento");
				return(false)
				break;
		}
	}	
	catch (e)
	 {
	 	 alert("No hay Solicitudes para Seleccionar");
		 return(false);
	 } 

}
function ValidarCambiarEstado()
{
	var frm=document.FrmMuestras;
	var Estado="E";
	var TSaRutFecha="";	
	//Asigna a ValoresSA los valores recuperados de la funcion donde recupera la SA,rut,recargo para atenderlos
	TSaRutFecha=RecuperarSolEliminar();
	if (TSaRutFecha!="")
	{
		var mensaje = confirm("¿Seguro que desea Eliminar?");
		if (mensaje==true)
		{
			frm.action="cal_atencion_solicitud_muestreo01.php?TSaRutFecha="+ TSaRutFecha + "&Opcion=E";
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
	var frm=document.FrmMuestras;
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
	{
		return(SaRutFechaHoraRecargo);
	}
}

function Recarga(URL,LimiteIni)
{
	var frm=document.FrmMuestras;
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "&LimitIni=" + LimiteIni;
	frm.submit(); 
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmMuestras" method="post" action="">
<?php
	if (!isset($LimitIni))
		$LimitIni = 0;
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5"  >
    <tr> 
      <td valign="top"><table width="760"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="78"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                Usuario: </font></font></div></td>
            <td width="274"><strong> 
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
              </strong></td>
            <td>Fecha:</td>
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php echo $Fecha_Hora ?>
              </strong>&nbsp; <strong> 
              <?php
			if (!isset($FechaHora))
  			{
				echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i:s')."'>";
				$FechaHora=date('Y-m-d H:i:s');
 			}
  			else
  			{ 
				echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
  			}
		  ?>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td height="31">Fecha Inicio<font size="2">: </font></td>
            <td height="31"><font size="2"> 
              <select name="CmbDias" size="1" style="width:40px;">
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
              <select name="CmbMes" size="1" id="select8" style="width:90px;">
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
              <select name="CmbAno" size="1" id="select9" style="width:70px;">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
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
              </font></td>
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha 
              Termino:<strong> </strong></font></font></font></font></td>
            <td><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
              <select name="CmbDiasT" id="select" size="1" style="width:40px;">
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
              <select name="CmbMesT" size="1" id="select2" style="width:90px;">
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
              <select name="CmbAnoT" size="1" id="select3" style="width:70px;">
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
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></font></td>
          </tr>
          <tr> 
            <td height="31"> <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              Estado: </font></font></font></font></td>
            <td height="31"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="CmbEstado" style="width:170" >
                <option value = "-1" selected >Seleccionar</option>
                <?php
		 			$Consulta =  "select * from sub_clase where (cod_clase = 1002 and valor_subclase1 = 'm')  ";
		 			$Resultado = mysqli_query($link, $Consulta);
		 			while ($Fila =mysqli_fetch_array ($Resultado))
		 			{
		    			if ($CmbEstado == $Fila["cod_subclase"])
		  				{
		  					echo"<option value='".$Fila["cod_subclase"]."'selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>";
						}	
		 				else 
		 				{
		 					echo"<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
		    			}
		 			}
		 		  ?>
              </select>
              </font><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></font></font></strong></font></font></td>
            <td width="94"> 
              <div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Lineas 
                por Pág. </font></font></div></td>
            <td width="287"> <font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input name="LimitFin" type="text" value="<?php echo $LimitFin; ?>" size="12" maxlength="12">
              </font></font></strong></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input name="BtnBuscar" type="submit" id="BtnBuscar4" value="Buscar" onClick="Proceso('B');">
              </font></font></font></font></strong></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></td>
          </tr>
        </table>
		<br>
        <table width="759" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="91"><div align="center"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Todos</font></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <input name="checkTodos" type="checkbox" onClick="JavaScript:Activar();" value="checkbox">
                </font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></div></td>
            <td width="92" align="center"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input name="BtnImprimir2" type="button" id="BtnImprimir2" value="Etiqueta" onClick="ImprimirEtiqueta();">
              </font></font></td>
            <td width="92"><div align="center"> 
                <input name="BtnDetalle" type="button" id="BtnDetalle" value="Detalle" onClick="Proceso('D');">
              </div></td>
            <?php
			if ($CmbEstado != '7')
			{
				echo "<td width='92'><input name='BtnEliminar' type='button' value='Eliminar' onClick=\"Proceso('E',' ',' ');\"></td>";
            }
			?>
            <td width="92"><input name="BtnActualizar" type="submit" id="BtnActualizar3" value="Actualizar"></td>
            <td width="93"> 
              <?php
			if ($CmbEstado == '1')
			{
				echo "<input name='BtnRecepcionar' type='button'  value='Recepcionar' onClick=\"Proceso('R');\">";

			}			
			?>
            </td>
            <td width="185">&nbsp;</td>
          </tr>
        </table>
        <br> <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        </font></font> <table width="760" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" >
          <tr class="ColorTabla01"> 
            <td colspan="2"><div align="center">S.A</div></td>
            <td width="103"><div align="left">Id Muestra</div></td>
            <td width="184"><div align="center"></div>
              <div align="center">Producto</div></td>
            <td width="75"><div align="center">Originador</div></td>
            <td width="92"><div align="center">Estado</div></td> 
            <td width="68"><div align="center">F.Creacion</div></td>
            <td width="83"><div align="center">F.Recepcion</div></td>
          </tr>
          <?php
	 	include ("../Principal/conectar_cal_web.php");	
		$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
		//echo $CmbEstado."<br>";
		$Entrar = true;
		switch ($CmbEstado) 
		{
			/*case "-1":
				//Estado Todos
				
				//$Estado ="where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."') or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and (t1.estado_actual = '1' or t1.estado_actual = '13' or t1.estado_actual = '2' )";
				break;*/
		 
			case "1":
				//Estado Creadas
				$Estado = "where (t1.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '1')";
				break;		 
		 	case "2": 
		 		//Estado Recepcion Muestrera		
				$Estado = "where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."')  or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and (t1.estado_actual = '2')";
				break;
			case "13": 
		 		//Estado Atencion Muestrera 
				$Estado = "where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."')  or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and (t1.estado_actual = '13')";
				break;
		
			case "7": 
		 		//Estado Eliminado 
				$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t6.cod_estado = '7')";
				break;
			default:
				$Entrar= false;
				//$Estado ="where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."') or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and (t1.estado_actual = '1' or t1.estado_actual = '2')";
				break;
		}
		if ($Entrar == true)
		{
			$Consulta = "select t1.tipo_solicitud,t2.descripcion as nomproducto,t3.descripcion as nomsubproducto,";
			$Consulta = $Consulta."t1.rut_funcionario,t1.recargo,t1.fecha_hora,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado, ";
			$Consulta = $Consulta."concat(t4.nombres,' ',t4.apellido_paterno,' ',t4.apellido_materno) as nombreapellido, ";
			$Consulta = $Consulta."t4.apellido_paterno as ap_paterno, ";
			$Consulta = $Consulta."t4.apellido_materno as ap_materno, ";
			$Consulta =	$Consulta."t1.nro_solicitud,t1.id_muestra,t1.fecha_hora as FechaCreacion,t7.cod_subclase,t7.nombre_subclase,t6.cod_estado,t1.estado_actual ";
			$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
			$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
			$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
			$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
			$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual = t6.cod_estado)";
			$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002' ";
			$Consulta = $Consulta.$Estado." order by t1.nro_solicitud,recargo_ordenado   ";
			$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
			echo "<input type='hidden' name='checkAtender'><input name ='TxtSAO' type='hidden'><input name ='TxtRutO' type='hidden'><input name ='TxtRecargoO' type='hidden'><input name='SolictudesO' type='hidden'><input name='TxtFechaO' type='hidden'><input name='TxtHoraO' type='hidden'><input name='TxtLotes' type='hidden'><input name='TxtIdMuestra' type='hidden'><input name='TxtProducto' type='hidden'>";
			$Respuesta= mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				//pregunta para que quede chequeado
				if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))
					{
						$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."//N";
					}
					else
					{
						$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."//".$Fila["recargo"];
						//echo "Entreee"."<br>";
					}
					$pos = strpos($Valores_Check, $SAChequear);
					if ($pos === false)
					{ 
						echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value=''></td>"; 
					}
					else
					{
						echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value='' checked></td>"; 
					}
					echo "<input name='SolictudesO' type='hidden' value='".$Fila["nro_solicitud"].'-'.$Fila["recargo"]."'>";
				//fin de pregunta para que quede checkeado
				//Pregunta si la  Solicitud es especial y esta en estado creada(1) o  recepcionada en muestrera color verde
				if (($Fila["tipo_solicitud"] == 'R') && (($Fila["estado_actual"] == '1') || ($Fila["estado_actual"] == '2')))
				{
					echo "<td width='110'  ><div align='center'><input name='TxtSA' style= 'background:#F4F5BA'  type='text' readonly style='width:110' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name='TxtSAO' type='hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type='hidden'  value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type='hidden' value='N'></div></td>";
				}
				//´Pregunta si la Solicitud es especial esta en estado  atendida  en muestrera color verde
				if (($Fila["tipo_solicitud"] == 'R') && ($Fila["estado_actual"] == '13'))
				{
					echo "<td width='110'  ><div align='center'><input name='TxtSA' style= 'background:#BAC8CD'  type='text' readonly style='width:110' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name = 'TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name = 'TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name='TxtRecargoO' type='hidden' value='N'></div></td>";
				}
				//Pregunta si la  Solicitud es automatica y esta en estado creada(1) o  recepcionada en muestrera amarillo
				if (($Fila["tipo_solicitud"] == 'A') && (($Fila["estado_actual"] == '1') || ($Fila["estado_actual"] == '2')))
				{
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]=="")) 
					{
						echo "<td width='110'><div align='center'><input name='TxtSA'  style= 'background:#F4F5BA'  type='text' readonly style='width:110' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"]."><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type ='hidden' value ='N'></div></td>";			
					}
					else
					{
						echo "<td width='110'><div align='center'><input name='TxtSA'  style= 'background:#F4F5BA'  type='text' readonly style='width:110' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type ='hidden' value ='".$Fila["recargo"]."'></div></td>";			
					}
				}
				//´Pregunta si la Solicitud es automatica y  esta en estado  atendida  en muestrera color plomo
				if (($Fila["tipo_solicitud"] == 'A') && ($Fila["estado_actual"] == '13')) 
				{
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]=="")) 
					{
						echo "<td width='110'><div align='center'><input name='TxtSA'  style= 'background:#BAC8CD' type='text' readonly style='width:110' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type ='hidden' value ='N'></div></td>";			
					}
					else
					{
						echo "<td width='110'><div align='center'><input name='TxtSA'  style= 'background:#BAC8CD' type='text' readonly style='width:110' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input  name ='TxtRecargoO' type ='hidden' value ='".$Fila["recargo"]."'></div></td>";								
					}
				}	
				//´Pregunta si la Solicitud es automatica y  esta en estado  elimnado
				if (($Fila["tipo_solicitud"] == 'A') && ($Fila["estado_actual"] == '7'))
				{
					//pregunta por si es automatica pero sin recargo
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]=="")) 
					{
						echo "<td width='110'><div align='center'><input name='TxtSA 'style= 'background:#F4F5BA' type='text' readonly style='width:110' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type ='hidden' value ='N'></div></td>";			
					}
					else 
					{
						echo "<td width='110'><div align='center'><input name='TxtSA' style= 'background:#F4F5BA'  type='text' readonly style='width:110' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type = 'hidden' value ='".$Fila["recargo"]."'></div></td>";			
					}				
				}
				//´Pregunta si la Solicitud es especial y  esta en estado  elimnado
				if (($Fila["tipo_solicitud"] == 'R') && ($Fila["estado_actual"] == '7')) 
				{
					echo "<td width='110'  ><div align='center'><input name='TxtSA' style= 'background:#F4F5BA'   type='text' readonly style='width:110' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type = 'hidden' value ='N'></div></td>";
				}
				//Pregunta si  no tiene recargo crea campo oculto lotes con valor N o vacio 
				if ((is_null($Fila["recargo"])) || ($Fila["recargo"] ==''))	
				{
					echo "<td width='103'><div align='left'><input name='TxtIdMuestra' type='text' readonly style='width:103' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input name='TxtFechaO' type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input name='TxtHoraO' type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."><input name ='TxtLotes' type='hidden' value =''></div></td>";							
				}
				else
				//Si tiene recargo crea campo oculto lotes con valor del lote para poder mostrarlo en el detalle de  muestreo
				{
					echo "<td width='103'><div align='left'><input name='TxtIdMuestra' type='text' readonly style='width:103' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input name='TxtFechaO' type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input name='TxtHoraO'  type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."><input name ='TxtLotes' type='hidden' value ='".$TxtLotes =$Fila["id_muestra"]."'></div></td>";						
				}	
				echo "<td width ='150'><div align ='left'><input name ='TxtProducto' type='text' readonly style='width:150' maxlength='110' value ='".$TxtProducto=ucwords(strtolower($Fila["nomsubproducto"]))."'></div></td>";
				
				echo "<td width ='75'><div align ='left'><input name ='TxtFuncionario' type='text' readonly style='width:75' maxlength='120' value ='".$TxtFuncionario=substr(ucwords(strtolower($Fila["nombreapellido"])),0,1).".".ucwords(strtolower($Fila["ap_paterno"]))." ".substr(ucwords(strtolower($Fila["ap_materno"])),0,1)."."." '></div></td>";

				//echo "<td width ='75'><div align ='left'><input name ='TxtFuncionario' type='text' readonly style='width:75' maxlength='120' value ='".$TxtFuncionario=substr(ucwords(strtolower($Fila["nombreapellido"])),0,1)." ".ucwords(strtolower($Fila["ap_paterno"]))."'></div></td>";
				if ($Fila["cod_subclase"]=='2')
					{
						$Fila["nombre_subclase"]='Recep Muestrera';
					
					}
					if ($Fila["cod_subclase"]=='13')
					{
						$Fila["nombre_subclase"]='Aten Muestrera';
					
					}							
				echo "<td width ='90'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:90' maxlength='70'value ='".$TxtEstado= $Fila["nombre_subclase"]."'></div></td>";
				//Consulta que devuelve la fecha si el estado es Recepcionado en Muestrera o 2   
				$Consulta ="select fecha_hora from estados_por_solicitud  ";
				$Consulta = $Consulta." where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') ";
				$Consulta = $Consulta." and (cod_estado = '1') and recargo = '".$Fila["recargo"]."' "; 
				$Respuesta1 = mysqli_query($link, $Consulta);
				if ($Fila1 = mysqli_fetch_array($Respuesta1))
				{
					//asigna el valor encontrado a fecha de recepcion en caso de que no encuentre nada asigna nulo a FechaRecepcion
					$FechaCreacion = $Fila1["fecha_hora"];		
					echo "<td width ='70'><divalign ='left'><input name ='TxtFechaC' type='text' readonly style='width:70' maxlength='70'value ='".$FechaCreacion."'><input name ='TxtHoraR' type='hidden' value =".$TxtHoraR= substr($Fila["FechaAtencion"],11,8)."></div></td>";		
				}
				else
				{ 				
					echo "<td width ='70'><divalign ='left'><input name ='TxtFechaC' type='text' readonly style='width:70' maxlength='70'value =''><input name ='TxtHoraR' type='hidden' value =''></div></td>";		
				}
				//Consulta que devuelve la fecha si el estado es Recepcionado en Muestrera o 2   
				$Consulta ="select fecha_hora from estados_por_solicitud  ";
				$Consulta = $Consulta." where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') ";
				$Consulta = $Consulta." and (cod_estado = '2') and recargo = '".$Fila["recargo"]."' "; 
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					//asigna el valor encontrado a fecha de recepcion en caso de que no encuentre nada asigna nulo a FechaRecepcion
					$FechaRecepcion = $Fila2["fecha_hora"];		
					echo "<td width ='70'><divalign ='left'><input name ='TxtFechaR' type='text' readonly style='width:70' maxlength='70'value ='".$FechaRecepcion."'><input name ='TxtHoraR' type='hidden' value =".$TxtHoraR= substr($Fila["FechaAtencion"],11,8)."></div></td>";		
				}
				else
				{ 				
					echo "<td width ='70'><divalign ='left'><input name ='TxtFechaR' type='text' readonly style='width:70' maxlength='70'value =''><input name ='TxtHoraR' type='hidden' value =''></div></td>";		
				}
				echo "</tr>";
		   }
		}	   
	   ?>
        </table>
		<table width="760" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="25" align="center" valign="middle">Paginas &gt;&gt; 
            <?php
			if ($Entrar == true)
			{
				$Consulta = "select count(*) as total_registros ";
				$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
				$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
				$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
				$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
				$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual = t6.cod_estado)";
				$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002' ";
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
						$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
					else
					{
						$StrPaginas.=  "<a href=JavaScript:Recarga('cal_adm_solicitud_muestreo.php?CmbEstado=".$CmbEstado."','".($i * $LimitFin)."');>";
						$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
					}
				}
				echo substr($StrPaginas,0,-15);
			}	
			?>
            </td>
          </tr>
        </table>
        <table width="760" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="100"><div align="right"><font size="1"><font size="1"></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <input name="BtnImprimir" type="button" id="BtnImprimir" value="Etiqueta" onClick="ImprimirEtiqueta();">
                </font></font> </div></td>
            <td width="100"><div align="center">
				<?php              
				if (($CmbEstado !='7') && ($CmbEstado !='1'))
				{
					echo "<input name='BtnAsignar' type='button'  value='Asignar' onClick=\"Proceso('As','$FechaHora');\">";
                }
				?>
			  </div></td>
            <td width="151"><div align="center"> 
                <?php
				if (($CmbEstado !='7') && ($CmbEstado !='1'))
				{
					echo "<input name='BtnAtender' type='button' value='Atender' onClick=\"Proceso('A','$FechaHora');\">";
              	}	
				?>
			  </div></td>
            <td width="99">
			<?php
			if (($CmbEstado !='7') && ($CmbEstado !='1'))
				{
					echo "<input name='BtnModificar' type='button'  value='Modificar' onClick=\"Proceso('M');\">";
				}		
			?>
			</td>
            <td width="100"><input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60" onClick="Proceso('S');"></td>
            <td width="163">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
