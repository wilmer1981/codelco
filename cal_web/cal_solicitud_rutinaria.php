<?php 	
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 48;
	include("../principal/conectar_principal.php");
	$Fecha_Hora = date("Y-m-d");
	if (isset($FechaBusqueda) and ($FechaBusqueda !=""))
	{
		$FechaHora = $FechaBusqueda;
		$FechaBusqueda="";
	}
?>
<html>
<head>
<script language="JavaScript">
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmSolicitudRutinaria;
	var teclaCodigo = event.keyCode; 
	
	if ((teclaCodigo == 186 )||(teclaCodigo == 222 ))
	{
		event.keyCode=46;
	}
} 

function ValidarDatos(Opcion,Modificar)
{
	var Frm = document.FrmSolicitudRutinaria;
	switch (Opcion)
	{
		case "N"://VALIDA EL INGRESO DE LA SOLICITUD
		    ValidaIngreso(Opcion);
			break;
		case "M1":
			ValidaModificar('1');
			break;
		case "M2":
			ValidaModificar('2');
			break;
		case "M3":
			ValidaModificar('3',Modificar);
			break;
		case "M4":
			ValidaModificar('4');
			break;
		case "E":
			ValidaEliminar();
			break;
		case "G":
			ValidaGenerar();
			break;
	}		
}

function ValidaIngreso(Valor)
{
	var Frm=document.FrmSolicitudRutinaria;
    if (Frm.CmbProductos.value == "-1")
	{
		alert ("Debe Ingresar Producto");
		Frm.CmbProductos.focus();
		return;
	}
    if (Frm.CmbSubProducto.value == "-1")
	{
		alert ("Debe Ingresar SubProducto");
		Frm.CmbSubProducto.focus();
		return;
	}
    if (Frm.CmbTipoAnalisis.value == "-1")
	{
		alert ("Debe Ingresar Tipo de Analisis");
		Frm.CmbTipoAnalisis.focus();
		return;
	}
    if ((Frm.CheckAnalisis.checked == false) && (Frm.CheckMuestreo.checked == false))
	{
		alert ("Debe Seleccionar Analisis o Muestreo");
		Frm.CheckAnalisis.focus();
		return;
	}
    if (Frm.TxtMuestra.value == "" )
	{
		alert ("Debe Ingresar Muestra");
		Frm.TxtMuestra.focus();
		return;
	}
	var Enabal=false;
	var V_1 = 0;
	var V_2 = 0;
	if (Frm.CheckAnalisis.checked==true)
	{
		V_1 = 1;
	}
	if (Frm.CheckMuestreo.checked==true)
	{
		V_2 = 1;
	}
	if (Frm.CheckEnabal.checked==true)
	{
		Enabal='S';
	}
	else
	{
		Enabal='N';
	}
	if (Frm.ValidarMuestra.value=='S')
	{
		if (Frm.TxtValTipo.value!='')
		{
			if ((Frm.TxtValTipo.value=='n')||(Frm.TxtValTipo.value=='N'))
			{
				if(!Number(Frm.TxtMuestra.value))
				{
					alert("Debe Ingresar Numero Valido");
					Frm.TxtMuestra.focus();
					return;
				}
				if(Frm.TxtMuestra.value.length>Frm.TxtValEntero.value)
				{
					alert("Largo de ID. Muestra no permitido");
					Frm.TxtMuestra.focus();
					return;
				}
				if ((Frm.TxtValRango1.value!='')&&(Frm.TxtValRango2.value!=''))
				{
					if ((Frm.TxtMuestra.value<Frm.TxtValRango1.value)||(Frm.TxtMuestra.value>Frm.TxtValRango2.value))
					{
						alert("Numero ID.Muestra Fuera de Rango("+Frm.TxtValRango1.value+"-"+Frm.TxtValRango2.value+")");
						Frm.TxtMuestra.focus();
						return;
					}
				}
			}
			else
			{
				if(Frm.TxtMuestra.value.length>Frm.TxtValEntero.value)
				{
					alert("Largo de ID. Muestra no permitido");
					Frm.TxtMuestra.focus();
					return;
				}
			}
		}
	}			
	Frm.action = "cal_solicitud_rutinaria01.php?proceso=" + Valor + "&ValorAnalisis=" + V_1 + "&ValorMuestreo=" + V_2+"&Enabal="+Enabal;
	Frm.submit();	
}

function ValidaModificar(Valor,Modificar)
{
	var Frm=document.FrmSolicitudRutinaria;
    var Muestras = "";
	if (CheckeoSolicitud())
	{
	   switch (Valor)
   		{
			case "1":
				if (Frm.CmbCCosto.value == "-1")
				{
					alert ("Debe Seleccionar Centro de Costo");
					Frm.CmbCCosto.focus();
					return;
					break;
					
				}
				else
				{
					Muestras=RecuperarDatosCheckeados();
					Frm.action = "cal_solicitud_rutinaria01.php?proceso=M&Valor=" + Valor +"&Muestras=" + Muestras+"&NombrePlantillaSA="+Frm.TxtNomPlantillaSA.value;
					Frm.submit();
					return;
					break;
				}
			case "2":
				if (Frm.CmbAreasProceso.value == "-1")
				{
					alert ("Debe Seleccionar Area");
					Frm.CmbAreasProceso.focus();
					return;
					break;
				}	
				else
				{
					Muestras=RecuperarDatosCheckeados();
					Frm.action = "cal_solicitud_rutinaria01.php?proceso=M&Valor=" + Valor +"&Muestras=" + Muestras+"&NombrePlantillaSA="+Frm.TxtNomPlantillaSA.value;
					Frm.submit();
					return;
					break;
				}
				
			case "3":
				MostrarPeriodo(Modificar);
				return;
				break;
			case "4":
				CambiarIDMuestra();
				return;
				break;
		}	
	}
	else
	{
		alert ("No hay elementos Seleccionados");	
	}
			
}

function ValidaEliminar()
{
	var Frm=document.FrmSolicitudRutinaria;
	var Muestras= "";
	var Resp = "";
	if (CheckeoSolicitud())
	{
		Resp=confirm("Desea Eliminar los Elementos Seleccionados");
		if (Resp==true)
		{
			Muestras=RecuperarDatosCheckeados();
			Frm.action = "cal_solicitud_rutinaria01.php?proceso=E&Muestras="+Muestras+"&NombrePlantillaSA="+Frm.TxtNomPlantillaSA.value;
			Frm.submit();
			return;
		}
		else
		{
			return;
		}	
	}
	else
	{
		alert ("No hay elementos Seleccionado");	
	}
}
function ValidaGenerar()
{
	var Frm=document.FrmSolicitudRutinaria;
    var Muestras = "";
	if (CheckeoSolicitud())
	{
	    for (i=13;i<=Frm.elements.length - 12;i++)
		{
			if ((Frm.elements[i].name == "CheckSA") && (Frm.elements[i].checked == true))
			{
				if (Frm.elements[i+7].value=="")
				{
					alert("Debe Ingresar Centro de Costo");
					Frm.CmbCCosto.focus();
					return;				
				}
				if (Frm.elements[i+6].value=="")
				{
					alert("Debe Ingresar Area Proceso");
					Frm.CmbAreasProceso.focus();
					return;				
				}
				if ((Frm.elements[i+8].value=="")&&(Frm.elements[i+9].value==""))
				{
					alert("Debe Ingresar Leyes");
					Frm.BtnLeyes.focus();
					return;				
				}
				if (Frm.elements[i+13].value=="")
				{
					alert("Debe Ingresar Periodo");
					Frm.BtnOk22.focus();
					return;				
				}
			}
		}
		Muestras=RecuperarDatosCheckeados();
		Frm.action = "cal_solicitud_rutinaria01.php?proceso=G&Muestras=" + Muestras;
		Frm.submit();	
	}
	else
	{
		alert ("No hay elementos Seleccionados");	
	}
}

function Recarga(Generar)
{
 var Frm=document.FrmSolicitudRutinaria;

     Frm.action= "cal_solicitud_rutinaria.php?GenerarValidacion="+Generar;
	 Frm.submit();
}
function MostrarPeriodo(Modificar)
{
   	var Frm=document.FrmSolicitudRutinaria;
	var Muestras= "";
 	Muestras=RecuperarDatosCheckeados();
	switch (Frm.PeriodoO.value)
   	{
 	 case "1":
		window.open("cal_ing_periodo_rutinaria.php?Muestras=" + Muestras + "&Periodo=1&Modificar="+Modificar+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&NombrePlantillaSA="+Frm.TxtNomPlantillaSA.value,"","top=200,left=10,width=700,height=240,scrollbars=no,resizable = yes");		
		break;
 	 case "2":
		window.open("cal_ing_periodo_rutinaria.php?Muestras=" + Muestras + "&Periodo=2&Modificar="+Modificar+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&NombrePlantillaSA="+Frm.TxtNomPlantillaSA.value,"","top=200,left=10,width=700,height=240,scrollbars=no,resizable = yes");		
		break;
 	 case "3":
		window.open("cal_ing_periodo_rutinaria.php?Muestras=" + Muestras + "&Periodo=3&Modificar="+Modificar+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&NombrePlantillaSA="+Frm.TxtNomPlantillaSA.value,"","top=200,left=10,width=700,height=240,scrollbars=no,resizable = yes");		
		break;
    case "4":
		window.open("cal_ing_periodo_rutinaria.php?Muestras=" + Muestras + "&Periodo=4&Modificar="+Modificar+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&NombrePlantillaSA="+Frm.TxtNomPlantillaSA.value,"","top=200,left=10,width=700,height=240,scrollbars=no,resizable = yes");				
		break;
	case "5":
		window.open("cal_ing_periodo_rutinaria.php?Muestras=" + Muestras + "&Periodo=5&Modificar="+Modificar+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&NombrePlantillaSA="+Frm.TxtNomPlantillaSA.value,"","top=200,left=10,width=700,height=240,scrollbars=no,resizable = yes");				
		break;
	}
}
function CambiarIDMuestra()
{
   	var Frm=document.FrmSolicitudRutinaria;
	var Muestras= "";
	var Tiene
	
	if (Frm.TxtCambiaID.value!='')
	{
	 	if (SoloUnElementoCheck())
		{	
			Muestras=RecuperarDatosCheckeados();
			Frm.action = "cal_solicitud_rutinaria01.php?proceso=C&Muestras="+Muestras+"&NombrePlantillaSA="+Frm.TxtNomPlantillaSA.value;
			Frm.submit();	
		}
	}
	else
	{
		alert('Debe Ingresar ID.Muestra Nueva');
		Frm.TxtCambiaID.focus();
		return;
	}
}
function MostrarPlantilla(CmbProductos,CmbSubProducto,Modificando)
{
	var Frm=document.FrmSolicitudRutinaria;
	var Muestras = "";
	
	if (CheckeoSolicitud())
	{
		Muestras=RecuperarDatosCheckeados();
		window.open("cal_plantillas.php?Valores="+Muestras+"&SolEsp=S&CmbProductos="+CmbProductos+"&CmbSubProducto="+CmbSubProducto+"&Productos="+CmbProductos+"&SubProducto="+CmbSubProducto+"&Modificando="+Modificando,"","top=150,left=20,width=640,height=400,scrollbars=yes,resizable = yes");
	}
	else
	{
		alert ("No hay elementos Seleccionados");	
	}
}

function MostrarIngresoSubProducto()
{
	var Frm=document.FrmSolicitudRutinaria;
	var Producto="";
	if (Frm.CmbProductos.value =="-1")
	{
		alert("Debe Ingresar Producto");
		Frm.CmbProductos.focus();
		return;
	}
	Producto=Frm.CmbProductos.options[Frm.CmbProductos.selectedIndex].text;
	window.open("cal_ingreso_subproducto.php?TipoSA=E&Producto="+Producto+"&CmbProductos="+Frm.CmbProductos.value,"","top=160,left=150,width=485,height=230,scrollbars=no,resizable = no");
}

function MostrarLeyes(Modificando,Productos,SubProducto)
{
	var Frm=document.FrmSolicitudRutinaria;
	var TipoAnalisisQ="";
	var TipoAnalisisF="";
	Muestras = "";
	if (CheckeoSolicitud())
	{
	    for (i=13;i<=Frm.elements.length - 12;i++)
		{
			if ((Frm.elements[i].name == "CheckSA") && (Frm.elements[i].checked == true))
			{
				if (Frm.elements[i+4].value=="1")
				{
					TipoAnalisisQ=Frm.elements[i+4].value;
				}
				else
				{
					TipoAnalisisF=Frm.elements[i+4].value;
				}
			}
		}
		if ((TipoAnalisisQ=="1") && (TipoAnalisisF=="2"))
		{
			alert("Debe seleccionar solo Leyes con S.A con Analisis Quimico o Analisis F�sicos");
			return;
		}
		Muestras=RecuperarDatosCheckeados();
		if (EncontroRecargo())
		{
			window.open("cal_leyes_por_plantilla_solicitud.php?Valores="+Muestras+"&Opcion=Rutinaria&Modificando="+Modificando+"&Productos="+Productos+"&SubProducto="+SubProducto,""," fullscreen=yes,width=800,height=600,scrollbars=yes,resizable = yes");		
		}
		else
		{
			window.open("cal_leyes_por_plantilla_solicitud.php?Valores="+Muestras+"&Opcion=Rutinaria&Modificando="+Modificando+"&Productos="+Productos+"&SubProducto="+SubProducto,""," fullscreen=yes,width=800,height=600,scrollbars=yes,resizable = yes");				
		}
	}
	else
	{
		alert ("No hay elementos Seleccionados");	
	}
}

function EncontroRecargo()
{
 	var Frm = document.FrmSolicitudRutinaria;
	var Respuesta=false;
	
    for (i=13;i<=Frm.elements.length - 12;i++)
	{
		if ((Frm.elements[i].name == "CheckSA") && (Frm.elements[i].checked == true))
		{
			if (Frm.elements[i+5].value!='N')
			{
				Respuesta=true;
				return(Respuesta);			
				break;
			}
		}
	}
	return(Respuesta);
}
 
function RecuperarDatosCheckeados()
{
 	var Frm = document.FrmSolicitudRutinaria;
	var Muestras = "";
	var IdMuestra="";
	
    for (i=13;i<=Frm.elements.length - 12;i++)
	{
		if ((Frm.elements[i].name == "CheckSA") && (Frm.elements[i].checked == true))
		{
			Muestras = Muestras + Frm.elements[i+1].value + "~~" + Frm.elements[i+2].value + " " + Frm.elements[i+3].value + Frm.elements[i+5].value +"//" ;
		}
	}
	return(Muestras);
		
}
function RecuperarDatosCheckeados2()
{
 	var Frm = document.FrmSolicitudRutinaria;
	var Muestras = "";
	var IdMuestra="";
	
    for (i=13;i<=Frm.elements.length - 12;i++)
	{
		if ((Frm.elements[i].name == "CheckSA") && (Frm.elements[i].checked == true))
		{
			if ((Frm.elements[i+10].value=="")||(Frm.elements[i+12].value!=""))
			{
				alert("No se puede Generar Recargos");
				break;
			}
			else
			{
				Muestras = Muestras + Frm.elements[i+1].value + "~~" + Frm.elements[i+2].value + " " + Frm.elements[i+3].value + "//" ;
			}
		}
	}
	return(Muestras);
}

function CheckeoSolicitud()
{
//ESTA FUNCION DEVUELVE VERDADERO SI ENCUENTRA A LO MENOS UNA SOLICITUD CHECKEADA
	var Frm=document.FrmSolicitudRutinaria;
    for (i=13;i<=Frm.elements.length - 12;i++)
	{
		if ((Frm.elements[i].name == "CheckSA") && (Frm.elements[i].checked == true))
		{
            return(true);	
		 	break;
		}
	}
}
function ChequearTodo()
{
	var Frm=document.FrmSolicitudRutinaria;
	for (i=13;i<=Frm.elements.length - 12;i++)
	{
		if (Frm.elements[i].name == "CheckSA")
		{
			if (Frm.CheckTodos.checked == true)
			{
				Frm.elements[i].checked = true;
			}
			else
			{
				Frm.elements[i].checked = false;
			}
		}
	}
}	
function MostrarBuscar()
{
	window.open("cal_buscar_solicitud.php?Sol_Aut=N","","top=150,left=10,width=750,height=380,scrollbars=yes,resizable = no");
}
function Salir()
{
	var Frm=document.FrmSolicitudRutinaria;
	Frm.action = "cal_solicitud_rutinaria01.php?proceso=S";
	Frm.submit();	
}

function Nuevo()
{
	var Frm=document.FrmSolicitudRutinaria;
	Frm.action = "cal_solicitud_rutinaria01.php?proceso=L";
	Frm.submit();	
}
function AsignarRecargos()
{
	var Frm=document.FrmSolicitudRutinaria;
	var Muestras ="";
	
	if (SoloUnElementoCheck())
	{
		Muestras=RecuperarDatosCheckeados2();
		if (Muestras !="")
		{
			window.open("cal_asignar_recargo.php?Muestras="+Muestras,"","top=285,left=200,width=390,height=130,scrollbars=no,resizable = no");			
		}	
	}
}
function BuscarSubProducto()
{
	var Frm=document.FrmSolicitudRutinaria;
	window.open("cal_buscar_subproducto.php","","top=80,left=10,width=750,height=460,scrollbars=yes,resizable = no");	
}
function SoloUnElementoCheck()
{
 	var Frm = document.FrmSolicitudRutinaria;
	var Cont=0;

    for (i=13;i<=Frm.elements.length - 12;i++)
	{
		if ((Frm.elements[i].name == "CheckSA") && (Frm.elements[i].checked == true))
		{
			Cont=Cont+1;
			if (Cont==2)
			{
				break;
			}
		}
	}
	switch (Cont)
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
function MostrarPlantillaSA(FechaHora)
{
	var Frm = document.FrmSolicitudRutinaria;
	
    if (Frm.CmbProductos.value == "-1")
	{
		alert ("Debe Ingresar Producto");
		Frm.CmbProductos.focus();
		return;
	}
    if (Frm.CmbSubProducto.value == "-1")
	{
		alert ("Debe Ingresar SubProducto");
		Frm.CmbSubProducto.focus();
		return;
	}
	window.open("cal_plantilla_sa.php?CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value+"&FechaHora="+FechaHora,"","top=150,left=10,width=750,height=350,scrollbars=yes,resizable = no");	
	
}
</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmSolicitudRutinaria" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td align="center" valign="middle">
	  <table width="730" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr> 
       <td height="27"><div align="left"><strong><?php echo $Fecha_Hora ?> 
       <?php
		if (!isset($FechaHora))
		{
			echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
			$FechaHora=date('Y-m-d H:i');
		}
		else
		{ 
			echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
		}
		if (isset($PeriodoX))
		{
			echo "<input name='PeriodoO' type='hidden' value='".$PeriodoX."'>";
		}
		else
		{
			echo "<input name='PeriodoO' type='hidden' value='".$Periodo."'>";
		}
		$PeriodoO=$Periodo;
	   ?>
        </strong></div></td>
        <td height="27" colspan="3"><div align="left"><strong> 
       <?php
			if ($Modificar!='S')
			{
				echo "<input name='BtnBuscarSP' type='submit' value='Buscar SubProd' style='width:100' onClick='BuscarSubProducto();'>";
			}
		?>
         </strong></div></td>
            <td height="27"><div align="center"><strong> 
                <input name="BtnNuevo" type="submit" value="Nuevo" style="width:60" onClick="Nuevo();">
                &nbsp; 
                <!--<input name="BtnModificar" type="button" value="Modificar" style="width:60" onClick="MostrarBuscar();">-->
                </strong></div></td>
          </tr>
          <tr> 
            <td width="20%" height="23">Tipo Producto</td>
            <td width="33%" height="23"><div align="left"><strong> 
            <?php          
			if($Modificar!='S')
			{
				echo "<select name='CmbProductos' style='width:250 'id='select' onChange=Recarga('N');>";
				echo "<option value='-1' selected>Seleccionar</option>";
				if (isset($FechaBuscar))
				{
					$CmbProductos = $Productos;
				}
				$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos order by descripcion"; 
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbProductos==$Fila["cod_producto"])
					{
						echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
					else
					{
						echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				}
				echo "</select>";
			}
			else	
			{
				$Consulta = "select descripcion from productos where cod_producto =".$Productos;
				$Respuesta = mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				echo ucwords(strtolower($Fila["descripcion"]));
			}
		?>
            </strong></div></td>
            <td width="7%" height="23">
			<?php
				if ((isset($CmbSubProducto))&&($CmbSubProducto!='-1'))
				{
				}	
			?>	
			</td>
            <td width="19%" height="23">&nbsp;</td>
            <td width="21%" height="23">&nbsp;</td>
          </tr>
          <tr> 
            <td height="23">Tipo SubProducto</td>
            <td height="23"><strong> 
            <?php
   		  	if($Modificar!='S')
			{
				echo "<select name='CmbSubProducto' style='width:250' onChange=Recarga('N')>";
				echo "<option value='-1' selected>Seleccionar</option>";
				if (isset($FechaBuscar))
				{
					$CmbSubProducto = $CmbSubProducto;
				}
				$Consulta="select cod_subproducto,descripcion,flujos from subproducto where cod_producto = '".$CmbProductos."'"; 
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
					{
						echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
					else
					{
						echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}	
				}
				echo "</select></strong>";
			}
			else	
			{
				$Consulta = "select descripcion from Subproducto where cod_producto =".$Productos." and cod_subproducto=".$SubProducto;
				$Respuesta = mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				echo ucwords(strtolower($Fila["descripcion"]));
			}
	 	   ?>
           </strong> </td>
            <td height="23">&nbsp;</td>
            <td height="23">&nbsp;</td> 
            <td height="23"></tr>
          <tr> 
            <td height="23">Plantilla</td>
            <td height="23" colspan="4"><input type="button" name="BtnPlantillaSA" value="Plantilla SA" width="80" onClick="MostrarPlantillaSA('<?php echo $FechaHora;?>');">&nbsp;&nbsp;
			<?php
				echo "<input type='hidden' name='TxtNomPlantillaSA' value='$NombrePlantillaSA'>";
				echo "<strong>Nombre de Plantilla: ".$NombrePlantillaSA."</strong>";
			?>
			</td>
          </tr>
        </table>
  		<br>
	  <table width="730" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="68" rowspan="2"> <strong> 
              <input name="CheckTodos" type="checkbox" id="CheckTodos3" value="checkbox" onClick="ChequearTodo();">
              </strong>Todos</td>
            <td width="33">C.C.</td>
            <td width="368"><strong> 
              <select name="CmbCCosto" style="width:330">
                <option value ='-1' selected>Seleccionar</option>
                <?php
				$Consulta = "select centro_costo,descripcion from proyecto_modernizacion.centro_costo where mostrar_calidad='S' order by centro_costo";
				$Respuesta = mysqli_query ($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo "<option value = '".$Fila[centro_costo]."'>".$Fila[centro_costo]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
				}
				echo "<option value ='-1'>____________________________________________________</option>\n";
				$Consulta = "select centro_costo,descripcion from proyecto_modernizacion.centro_costo where mostrar_calidad<>'S' order by centro_costo";
				$Respuesta = mysqli_query ($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo "<option value = '".$Fila[centro_costo]."'>".$Fila[centro_costo]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
				}
			?>
              </select>
              <input name="BtnOk1" type="button" id="BtnOk1" value="Ok" onClick="ValidarDatos('M1');">
              </strong></td>
            <td> <div align="left"></div>
              <div align="right"> </div>
              <strong> </strong> <div align="right"><strong> </strong></div>
              <div align="center"><strong> </strong><strong> 
                <?php
			if ($Modificar!='S')
			{
				//echo "<input name='BtnPlantillas' type='Button' id='BtnPlantillas' style='width:70' onClick=MostrarPlantilla('$CmbProductos','$CmbSubProducto','N'); value='Plantillas'>&nbsp";
 	         	echo "<input name='BtnLeyes' type='Button' value='Leyes' style='width:70' onClick=\"MostrarLeyes('N','$CmbProductos','$CmbSubProducto');\">";
			} 
			else
			{
				//echo "<input name='BtnPlantillas' type='Button' id='BtnPlantillas' style='width:70' onClick=MostrarPlantilla('$Productos','$SubProducto','S'); value='Plantillas'>&nbsp";	
				echo "<input name='BtnLeyes' type='Button' value='Leyes' style='width:70' onClick=\"MostrarLeyes('S','$Productos','$SubProducto');\">";				
			}
			if($Modificar=='S')
			{
			  echo "<input name='BtnOk22' type='button' value='Ok' onClick=\"ValidarDatos('M3','S');\">";
			}
			else
			{
			  echo "&nbsp;<input name='BtnOk22' type='button' value='Fecha Muestra' onClick=\"ValidarDatos('M3');\">";
			}
 		?>
                </strong></div></td>
          </tr>
          <tr> 
            <td>Area</td>
            <td><strong> 
              <select name="CmbAreasProceso" style="width:330">
                <option value ='-1' selected>Seleccionar</option>\n;
                <?php
			$Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase = 3 order by valor_subclase1 ";
			$Respuesta = mysqli_query ($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbAreasProceso == $Fila["cod_subclase"])
				{
					echo "<option value = '".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 				
				}
				else
				{
					echo "<option value = '".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
				}	
			}
		?>
              </select>
              <input name="BtnOk2" type="button" id="BtnOk2" value="Ok" onClick="ValidarDatos('M2');">
              </strong></td>
            <td>ID.Muestra 
              <input type="text" name="TxtCambiaID">&nbsp;<input name="BtnOk3" type="button" value="Ok" onClick="ValidarDatos('M4');"></td>
          </tr>
        </table>
  <strong> </strong><br>
  <table width="730" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
    <tr class="ColorTabla01">
      <td width="2%">&nbsp;</td>
      <td width="8%"><div align="center"><strong> Muestra</strong></div></td>
      <td width="6%"><div align="center"><strong>Areas</strong></div></td>
      <td width="10%"><div align="center"><strong>C.Costo</strong></div></td>
      <td width="17%"><div align="center"><strong>Leyes</strong></div></td>
      <td width="18%"><div align="center"><strong>Impurezas</strong></div></td>
      <td width="15%"><div align="center"><strong>S.A</strong></div></td>
      <td width="24%"><div align="center"><strong>Periodo</strong></div></td>
    </tr>
    <?php  
		include ("../Principal/conectar_cal_web.php");	   
	    if (isset($CmbSubProducto) or (isset($Modificar)))
		{
			if ((!isset($Modificar)) or ($Modificar!='S'))
			{
				$ValorProducto=$CmbProductos;
				$ValorSubProducto=$CmbSubProducto;
			}
			else
			{
				$ValorProducto=$Productos;
				$ValorSubProducto=$SubProducto;
				echo "<input type=hidden name='CmbProductos' value =".$ValorProducto.">";
				echo "<input type=hidden name='CmbSubProducto' value =".$ValorSubProducto.">";
				echo "<input type=hidden name='Modificando' value ='S'>";
			}
			$Consulta = "select distinct(t1.nro_solicitud),t1.recargo,t1.cod_ccosto,t1.cod_area,t1.cod_periodo, ";
			$Consulta.=" t1.cod_tipo_muestra,t1.rut_funcionario,t1.id_muestra,t1.cod_producto,t1.cod_subproducto, ";
			$Consulta.=" t1.cod_tipo_muestra,t1.leyes,t1.impurezas,t1.tipo_solicitud,t1.estado_actual ";
			$Consulta.=" ,t1.fecha_hora as fecha_hora,t1.agrupacion,t1.tipo, ";
			$Consulta.=" t1.cod_analisis as cod_analisis,t1.fecha_muestra from solicitud_analisis t1 left join estados_por_solicitud t2 on ";
			$Consulta =$Consulta."t1.rut_funcionario = t2.rut_funcionario and t1.nro_solicitud= t2.nro_solicitud "; 
			$Consulta =$Consulta."and t2.cod_estado = 1 where (t1.rut_funcionario ='".$CookieRut."') and ";
			$Consulta =$Consulta."(t1.fecha_hora ='".$FechaHora."' and cod_producto = '".$ValorProducto."' and cod_subproducto = '".$ValorSubProducto."') order by t1.rut_funcionario,t1.fecha_hora";
			$Respuesta =mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				$pos = strpos($ValorCheck, $Fila["id_muestra"]."~~");
				if ($pos === false)
				{ 
					echo "<td width='3%'><input name='CheckSA' type='checkbox' value='checkbox'></td>";
				}
				else
				{
					echo "<td width='3%'><input name='CheckSA' type='checkbox' value='checkbox' checked ></td>";
				}	
				echo "<td width='8%'><div align='center'>";
				if ($Fila["cod_tipo_muestra"]==1)
				{
					if ((is_null($Fila["recargo"]))||($Fila["recargo"]==''))
					{
						echo "<input name='TxtIdMuestra' type='text' readonly style ='background:#66CCFF' style='width:110' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."><input type = 'hidden' value ='".$Fila["cod_analisis"]."'><input type ='hidden' value='N'></div></td>";
					}
					else
					{
						echo "<input name='TxtIdMuestra' type='text' readonly style ='background:#66CCFF' style='width:110' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."><input type = 'hidden' value ='".$Fila["cod_analisis"]."'><input type ='hidden' value='".$Fila["recargo"]."'></div></td>";					
					}	
				}
				else
				{
					if ($Fila["cod_tipo_muestra"]==2)
					{
						if ((is_null($Fila["recargo"]))||($Fila["recargo"]==''))
						{
							echo "<input name='TxtIdMuestra' type='text' readonly style ='background:#FFFFCC' style='width:110' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."><input type = 'hidden' value ='".$Fila["cod_analisis"]."'><input type ='hidden' value='N'></div></td>";
						}
						else
						{
							echo "<input name='TxtIdMuestra' type='text' readonly style ='background:#FFFFCC' style='width:110' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."><input type = 'hidden' value ='".$Fila["cod_analisis"]."'><input type ='hidden' value='".$Fila["recargo"]."'></div></td>";					
						}
					}
					else
					{
						if ((is_null($Fila["recargo"]))||($Fila["recargo"]==''))
						{
							echo "<input name='TxtIdMuestra' type='text' readonly  style='width:110' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."><input type = 'hidden' value ='".$Fila["cod_analisis"]."'><input type ='hidden' value='N'></div></td>";
						}
						else
						{
							echo "<input name='TxtIdMuestra' type='text' readonly  style='width:110' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."><input type = 'hidden' value ='".$Fila["cod_analisis"]."'><input type ='hidden' value='".$Fila["recargo"]."'></div></td>";					
						}
					}
				}
				if (!is_null($Fila["cod_area"]))
				{
					$Consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase=3 and cod_subclase =".$Fila["cod_area"];
					$RespArea=mysqli_query($link, $Consulta);
					$FilaArea =mysqli_fetch_array($RespArea);
					echo "<td><div align='center'><input name='TxtArea' type='text' maxlength='10' readonly  style='width:75' value = ".$TxtArea = $Fila["cod_area"]."-".$FilaArea["valor_subclase1"].">";
				}	
				else
				{
					echo "<td><div align='center'><input name='TxtArea' type='text' maxlength='10' readonly  style='width:75' value = ".$TxtArea = $Fila["cod_area"].">";				
				}
				echo "</div></td><td> <div align='left'>&nbsp;<input name='TxtCCosto' type='text' maxlength='6' readonly style='width:40' value = ".$TxtCCosto = $Fila["cod_ccosto"]."></div></td>";
				$StrLeyes = $Fila["leyes"];
				$Leyes= "";
				for ($j = 0;$j <= strlen($StrLeyes); $j++)
				{
					if (substr($StrLeyes,$j,2) == "//")
					{
						$LeyesUnidad = substr($StrLeyes,0,$j);
						for ($x=0;$x<=strlen($LeyesUnidad);$x++)
						{
							if (substr($LeyesUnidad,$x,2) == "~~")
							{
								$CodLeyes = substr($StrLeyes,0,$x);			
								$Consulta = "select abreviatura from proyecto_modernizacion.leyes where cod_leyes ='".$CodLeyes."'";
								$Resultado= mysqli_query($link, $Consulta);
								while ($Fila2=mysqli_fetch_array($Resultado))
								{
									$Leyes=$Leyes.$Fila2["abreviatura"]."-";
								}
							}
						}
						$StrLeyes = substr($StrLeyes,$j + 2);
						$j = 0;
					}
				}			
				$Leyes = substr($Leyes,0,strlen($Leyes)-1);
				echo "<td><div align='center'><input name='TxtLeyes' type='text' readonly style='color:red;width:120' value = '".$Leyes."'></div></td>";
				$StrImpurezas = $Fila["impurezas"];
				$Impurezas= "";
				for ($j = 0;$j <= strlen($StrImpurezas); $j++)
				{
					if (substr($StrImpurezas,$j,2) == "//")
					{
						$ImpurezaUnidad = substr($StrImpurezas,0,$j);
						for ($x=0;$x<=strlen($ImpurezaUnidad);$x++)
						{
							if (substr($ImpurezaUnidad,$x,2) == "~~")
							{
								$CodImpureza = substr($StrImpurezas,0,$x);			
								$Consulta = "select abreviatura from proyecto_modernizacion.leyes where cod_leyes ='".$CodImpureza."'";
								$Resultado= mysqli_query($link, $Consulta);
								while ($Fila2=mysqli_fetch_array($Resultado))
								{
									$Impurezas=$Impurezas.$Fila2["abreviatura"]."-";
								}
							}
						}
					$StrImpurezas = substr($StrImpurezas,$j + 2);
					$j = 0;
					}
				}
				$Impurezas = substr($Impurezas,0,strlen($Impurezas)-1);
				echo "<td><div align='center'><input name='TxtImpurezas' type='text' readonly style='width:120' value = '".$Impurezas."'></div></td>";
				if ($Fila["tipo_solicitud"] == 'R')
				{
					echo "<td><input name='TxtSA' type='text' readonly style='width:90' maxlength='20' value = ".$Fila["nro_solicitud"]."></td>";
				}
				else
				{
					echo "<td><input name='TxtSA' type='text' readonly style='width:90' maxlength='20' value = ".$Fila["nro_solicitud"].'-'.$Fila["recargo"]."></td>";
				}
				if ((is_null($Fila["cod_periodo"])) or ($Fila["cod_periodo"] == ""))
				{
					echo "<td><input type='Text' name='TxtPeriodo' readonly style='width:100'><input type ='hidden' value='".$Fila["recargo"]."'><input type='hidden' value='".$Fila[fecha_muestra]."'></td>";											
				}	
				else
				{
					$Consulta = "select valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase = 2 and cod_subclase =".$Fila["cod_periodo"];
					$Resultado2 = mysqli_query($link, $Consulta);
					$Fila2 = mysqli_fetch_array($Resultado2);
					$FechaDMA=substr($Fila["fecha_muestra"],8,2)."-".substr($Fila["fecha_muestra"],5,2)."-".substr($Fila["fecha_muestra"],0,4);						
					echo "<td><input type='Text' name='TxtPeriodo' readonly style='width:100' value = '".$Fila2["valor_subclase3"]." ".$FechaDMA."'><input type ='hidden' value='".$Fila["recargo"]."'><input type='hidden' value='".$Fila[fecha_muestra]."'></td>";					
				}
				echo "</tr>";
			}
		}
	?>
    <tr> 
      <td colspan="8"> <div align="center"><strong> 
          <input name="BtnEliminar" type="Button" id="BtnEliminar2" value="Eliminar" style="width:70" onClick="ValidarDatos('E');">
          </strong>&nbsp;<strong> </strong> </div></td>
    </tr>
  </table>
  <br>
  <table width="730" border="0">
    <tr> 
      <td height="66"> <div align="left"><strong> 
          <textarea name="TxtObs" id="TxtObs" style="width:720">
		  </textarea>
          </strong> </div></td>
    </tr>
    <tr>
            <td>Responsable:
              <?php  echo "<strong>";
		  	$Consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$CookieRut."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
			}
			else
				{
			  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$CookieRut."'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
					}
				
				}
				echo "</strong>";
		  ?>
            </td>
    </tr>
    <tr> 
      <td>
	  	<div align="center"><strong>
	<?php	
		if ($Modificar!=='S')
		{
			echo "<input name='BtnGenerar' type='Button' id='BtnGenerar' value='Generar S.A' style='width:80' onClick=ValidarDatos('G');>&nbsp;";
			//echo "<input name='BtnRecargo' type='Button' value='Recargo' style='width:80' onClick=AsignarRecargos();>&nbsp;";
			//echo "<input name='BtnCambiarId' type='Button' value='Mod.Id.Muestra' style='width:100' onClick=AsignarRecargos();>&nbsp;";
		}
		else
		{
			echo "<input name='BtnGrabar' type='Button' value='Generar S.A' style='width:80' onClick=ValidarDatos('G');>&nbsp;";
		}
	?>	  
		</strong>
		<input name='BtnSalir' type='button' value='Salir' style='width:80' onClick='Salir();'>
		</div></td>
    </tr>
  </table>	  
	  </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
