<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 2;
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
function ValidarDatos(Opcion,Valida_OK,BuscarDetalle,BuscarPrv,Modificar)
{
	var Frm = document.FrmSolicitudAut;
	switch (Opcion)
	{
		case "N"://VALIDA EL INGRESO DE LA SOLICITUD AUTOMATICA
		    ValidaIngreso(Opcion,Valida_OK);
			break;
		case "M1":
			ValidaModificar('1');
			break;
		case "M2":
			ValidaModificar('2');
			break;
		case "M3":
			ValidaModificar('3',BuscarDetalle,BuscarPrv,Modificar);
			break;
		case "E":
			ValidaEliminar();
			break;
		case "G":
			ValidaGenerar();
			break;
	}		
}

function ValidaIngreso(Valor,Valida_OK)
{
	var Frm=document.FrmSolicitudAut;
	var Resp="";
	var Pos ="";	
	
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
	if (Valida_OK == "S")
	{
		if (ExistenElementosLotesCheck())
		{
			var Muestras_Check="";
			Muestras_Check=RecuperarLotesCheckeados();
			Pos=Muestras_Check.search('S//');
			if ((Frm.CmbProductos.value==1)&&(Frm.CmbSubProducto.value==92)&&(Pos!=-1))
			{
				//Resp=confirm("Desea Considerar la Humedad del Cierre de Lote");
				//if (Resp==true)
				//{
					Frm.action = "cal_solicitud_automatica01.php?proceso=" + Valor + "&ValorAnalisis=" + V_1 + "&ValorMuestreo=" + V_2 + "&Muestras_Check=" + Muestras_Check +"&EsBusqueda=S&ConHum=S";
					Frm.submit();
				//}
				//else
				//{
				//	Frm.action = "cal_solicitud_automatica01.php?proceso=" + Valor + "&ValorAnalisis=" + V_1 + "&ValorMuestreo=" + V_2 + "&Muestras_Check=" + Muestras_Check +"&EsBusqueda=S&ConHum=N";
				//	Frm.submit();
				//}
			}
			else
			{
				Frm.action = "cal_solicitud_automatica01.php?proceso=" + Valor + "&ValorAnalisis=" + V_1 + "&ValorMuestreo=" + V_2 + "&Muestras_Check=" + Muestras_Check +"&EsBusqueda=S&ConHum=S";
				Frm.submit();
			}				
		}
		else
		{
			alert("No hay Lotes para Seleccionar");
			return;
		}
	}	
    else
		if (Frm.TxtMuestra.value == "" )
		{
			alert ("Debe Ingresar Muestra");
			Frm.TxtMuestra.focus();
			return;
		}
		else
		{
			Frm.action = "cal_solicitud_automatica01.php?proceso=" + Valor + "&ValorAnalisis=" + V_1 + "&ValorMuestreo=" + V_2 + "&Muestras_Check=" + Frm.TxtMuestra.value +"//" +"&EsBusqueda=N&ConHum=S";
			Frm.submit();	
		}	
}

function ValidaModificar(Valor,BuscarDetalle,BuscarPrv,Modificar)
{
	var Frm=document.FrmSolicitudAut;
    var Muestras = "";
	if (ExistenElementosSolicitudesCheck())
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
					Muestras=RecuperarSolicitudesCheckeados();
					Frm.action = "cal_solicitud_automatica01.php?proceso=M&Valor=" + Valor +"&Muestras=" + Muestras;
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
					Muestras=RecuperarSolicitudesCheckeados();
					Frm.action = "cal_solicitud_automatica01.php?proceso=M&Valor=" + Valor +"&Muestras=" + Muestras;
					Frm.submit();
					return;
					break;
				}
			case "3":
				if (Frm.CmbPeriodo.value == "-1")
				{
					alert ("Debe Seleccionar Periodo");
					Frm.CmbPeriodo.focus();
					break;
					return;
				}	
				else
				{
					MostrarPeriodo(BuscarDetalle,BuscarPrv,Modificar);
					return;
					break;
				}
		}
	}
	else
	{
		alert ("No hay elementos Seleccionados");	
	}
}

function ValidaEliminar()
{
	var Frm=document.FrmSolicitudAut;
	var Muestras= "";
	var Resp = "";
	if (ExistenElementosSolicitudesCheck())
	{
		Resp=confirm("Desea Eliminar los Elementos Seleccionados");
		if (Resp==true)
		{
			Muestras=RecuperarSolicitudesCheckeados();
			Frm.action = "cal_solicitud_automatica01.php?proceso=E&Muestras=" + Muestras;
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
	var Frm=document.FrmSolicitudAut;
    var Muestras = "";
	if (ExistenElementosSolicitudesCheck())
	{
		for (i=1;i<Frm.CheckSA.length;i++)
		{
			if (Frm.CheckSA[i].checked==true)
			{
				if (Frm.TxtCCosto[i].value=="")
				{
					alert("Debe Ingresar Centro de Costo");
					Frm.CmbCCosto.focus();
					return;
				}
				if (Frm.TxtArea[i].value=="")
				{
					alert("Debe Ingresar Area Proceso");
					Frm.CmbAreasProceso.focus();
					return;
				}
				if ((Frm.TxtLeyes[i].value=="")&&(Frm.TxtImpurezas[i].value==""))
				{
					alert("Debe Ingresar Leyes");
					Frm.BtnLeyes.focus();
					return;
				}
			}
		}
		Muestras=RecuperarSolicitudesCheckeados();
		Frm.action = "cal_solicitud_automatica01.php?proceso=G&Muestras=" + Muestras;
		Frm.submit();	
	}
	else
	{
		alert ("No hay elementos Seleccionados");	
	}
}
function Recarga()
{
 var Frm=document.FrmSolicitudAut;
     Frm.action= "cal_solicitud_automatica.php";
	 Frm.submit();
}
function MostrarPeriodo(BuscarDetalle,BuscarPrv,Modificar)
{
   	var Frm=document.FrmSolicitudAut;
	var Muestras= "";

	Muestras=RecuperarSolicitudesCheckeados();
	switch (Frm.CmbPeriodo.value)
   	{
	 case "1":
		window.open("cal_ing_periodo.php?Muestras=" + Muestras + "&Periodo=1" + "&SolAut=S&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&Modificar="+Modificar+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value,"","top=200,left=10,width=700,height=240,scrollbars=no,resizable = yes");		
		break;
	 case "2":
		window.open("cal_ing_periodo.php?Muestras=" + Muestras + "&Periodo=2" + "&SolAut=S&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&Modificar="+Modificar+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value,"","top=200,left=10,width=700,height=240,scrollbars=no,resizable = yes");		
		break;
	 case "3":
		window.open("cal_ing_periodo.php?Muestras=" + Muestras + "&Periodo=3" + "&SolAut=S&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&Modificar="+Modificar+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value,"","top=200,left=10,width=700,height=240,scrollbars=no,resizable = yes");		
		break;
     case "4":
		window.open("cal_ing_periodo.php?Muestras=" + Muestras + "&Periodo=4" + "&SolAut=S&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&Modificar="+Modificar+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value,"","top=200,left=10,width=700,height=240,scrollbars=no,resizable = yes");		
		break;
	 case "5":
		window.open("cal_ing_periodo.php?Muestras=" + Muestras + "&Periodo=5" + "&SolAut=S&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&Modificar="+Modificar+"&CmbProductos="+Frm.CmbProductos.value+"&CmbSubProducto="+Frm.CmbSubProducto.value,"","top=200,left=10,width=700,height=240,scrollbars=no,resizable = yes");		
		break;
	
	}
}
function MostrarBuscar()
{
	window.open("cal_buscar_solicitud.php?Sol_Aut=S","","top=150,left=10,width=750,height=380,scrollbars=yes,resizable = no");
}
function MostrarPlantilla(Opcion,CmbProductos,CmbSubProducto,BuscarDetalle,BuscarPrv,CmbRutPrv,Modificando)
{
	var Frm=document.FrmSolicitudAut;
	var Muestras = "";
	if (ExistenElementosSolicitudesCheck())
	{
		switch (Opcion)
		{
			case "P":
				Muestras=RecuperarSolicitudesCheckeados();
				window.open("cal_plantillas.php?Valores="+Muestras+"&SolAut=S"+"&CmbProductos="+CmbProductos+"&CmbSubProducto="+CmbSubProducto+"&Productos="+CmbProductos+"&SubProducto="+CmbSubProducto+"&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&CmbRutPrv="+CmbRutPrv+"&Modificando="+Modificando,"","top=150,left=20,width=640,height=400,scrollbars=yes,resizable = yes");
				break;						
		}
	}
	else
	{
		alert ("No hay elementos Seleccionados");	
	}
}
function MostrarLeyes(CmbProductos,CmbSubProducto,BuscarDetalle,BuscarPrv,CmbRutPrv,Modificando)
{
	var Frm=document.FrmSolicitudAut;
	var TipoAnalisisQ="";
	var TipoAnalisisF="";
	var Muestras = "";
	if (ExistenElementosSolicitudesCheck())
	{
		for (i=1;i<Frm.CheckSA.length;i++)
		{
			if (Frm.CheckSA[i].checked==true)
			{
				if (Frm.TxtCodAnalisisO[i].value=="1")
				{
					TipoAnalisisQ="1";
				}
				else
				{
					TipoAnalisisF="2";
				}
			}	
		}
		if ((TipoAnalisisQ=="1") && (TipoAnalisisF=="2"))
		{
			alert("Debe seleccionar solo Leyes con S.A con Analisis Quimico o Analisis Físicos");
			return;
		}
		Muestras=RecuperarSolicitudesCheckeados();
		if (TipoAnalisisQ=="1")
		{
			window.open("cal_leyes_por_solicitud.php?Valores="+Muestras+"&SolAut=S"+"&Productos="+CmbProductos+"&SubProducto="+CmbSubProducto+"&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&CmbRutPrv="+CmbRutPrv+"&Modificando="+Modificando,"","fullscreen=yes,width=800,height=600,scrollbars=yes,resizable = yes");
		}
		else
		{
			window.open("cal_leyes_por_solicitud_fisico.php?Valores="+Muestras+"&SolAut=S"+"&Productos="+CmbProductos+"&SubProducto="+CmbSubProducto+"&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&CmbRutPrv="+CmbRutPrv+"&Modificando="+Modificando,"","top=20,left=20,width=800,height=600,scrollbars=yes,resizable = yes");
		}	
	}
	else
	{
		alert ("No hay elementos Seleccionados");	
	}
} 
 
function MostrarDetalleLote()
{
 	var Frm = document.FrmSolicitudAut;
	var Muestra ="";
	var ContMuestras=0;
	if (SoloUnElementoLotesCheck())
	{
		for (i=1;i<Frm.CheckMuestra.length;i++)
		{
			if (Frm.CheckMuestra[i].checked==true)
			{
				Muestra=Frm.TxtLote[i].value;
				break;
			}	
		}
		window.open("cal_detalle_lote.php?Muestra="+Muestra+"&RutPrv="+Frm.CmbRutPrv.value+"&Producto="+Frm.CmbProductos.value+"&SubProducto="+Frm.CmbSubProducto.value,"","top=150,left=140,width=485,height=280,scrollbars=no,resizable = no");
	}
}
function MostrarIngresoSubProducto()
{
	var Frm = document.FrmSolicitudAut;
	var Producto="";
	if (Frm.CmbProductos.value =="-1")
	{
		alert("Debe Ingresar Producto");
		Frm.CmbProductos.focus();
		return;
	}
	Producto=Frm.CmbProductos.options[Frm.CmbProductos.selectedIndex].text;
	window.open("cal_ingreso_subproducto.php?TipoSA=A&Producto="+Producto+"&CmbProductos="+Frm.CmbProductos.value,"","top=160,left=150,width=485,height=230,scrollbars=no,resizable = no");
}

function MostrarDetalleSolicitudLote()
{
	var Frm = document.FrmSolicitudAut;
	var Muestra="";
	var ValorRecargo="";
	var ContMuestras=0;
	
	if (SoloUnElementoSolicitudesCheck())
	{
		for (i=1;i<Frm.CheckSA.length;i++)
		{
			if (Frm.CheckSA[i].checked==true)
			{
				Muestra=Frm.TxtIdMuestraO[i].value;
				ValorRecargo = Frm.TxtRecargoO[i].value;
				break;
			}	
		}
		if (ValorRecargo=='N')
		{
			alert ("Esta opcion detalle es Solo para Lotes");
			return;
		}
		window.open("cal_detalle_solicitud_recargo.php?Muestra="+Muestra+"&RutPrv="+Frm.CmbRutPrv.value+"&Producto="+Frm.CmbProductos.value+"&SubProducto="+Frm.CmbSubProducto.value,"","top=150,left=140,width=485,height=280,scrollbars=no,resizable = no");
	}
}

function ChequearTodo()
{
	var Frm=document.FrmSolicitudAut;
	try
	{
		Frm.CheckSA[0];
		for (i=1;i<Frm.CheckSA.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckSA[i].checked=true;
			}
			else
			{
				Frm.CheckSA[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}	
function Salir()
{
	var Frm=document.FrmSolicitudAut;
	Frm.action = "cal_solicitud_automatica01.php?proceso=S";
	Frm.submit();	
}

function Nuevo()
{
	var Frm=document.FrmSolicitudAut;
	Frm.action = "cal_solicitud_automatica01.php?proceso=L";
	Frm.submit();	
}
function Buscar()
{
	var Frm=document.FrmSolicitudAut;
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
	if (Frm.CmbProductos.value =="1")	
	{
		if (Frm.TxtNomPrv.value == "")
		{
			alert ("Debe Ingresar Nombre del Proveedor");
			Frm.TxtNomPrv.focus();
			return;
		}
		else
		{
			if (Frm.CmbRutPrv.value == "-1")
			{
				alert ("Debe Seleccionar Rut del Proveedor");
				Frm.CmbRutPrv.focus();
				return;
			}
		}
	    Frm.action= "cal_solicitud_automatica.php?Buscar=S&BuscarPrv=S&CmbRutPrv="+Frm.CmbRutPrv.value;		
	}		
    else
	{
		Frm.action= "cal_solicitud_automatica.php?Buscar=S";
	}	
	Frm.submit();
	
}
function BuscarPrv()
{
	var Frm=document.FrmSolicitudAut;
    Frm.action= "cal_solicitud_automatica.php?BuscarPrv=S";
	Frm.submit();
	
}
function ExistenElementosLotes()
{
	var Frm=document.FrmSolicitudAut;
	try 
	{
		Frm.CheckMuestra[0];
		return(true)
	}	
	catch (e)
	{
		alert("No hay Elementos Seleccionados");
		return(false);
	} 
}
function ExistenElementosLotesCheck()
{
	var Frm=document.FrmSolicitudAut;
	var EncontroCheck=false;
	try 
	{
		Frm.CheckMuestra[0];
		for (i=1;i<Frm.CheckMuestra.length;i++)
		{
			if (Frm.CheckMuestra[i].checked==true)
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
	 	 alert("No hay Lotes para Seleccionar");
		 return(false);
	 } 
}

function SoloUnElementoLotesCheck()
{
	var Frm=document.FrmSolicitudAut;
	var CantCheck=0;
	try 
	{
		Frm.CheckMuestra[0];
		for (i=1;i<Frm.CheckMuestra.length;i++)
		{
			if (Frm.CheckMuestra[i].checked==true)
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
	 	 alert("No hay Lotes para Seleccionar");
		 return(false);
	 } 

}

function RecuperarLotesCheckeados()
{
	var Frm=document.FrmSolicitudAut;
	var ValoresLotes="";
	for (i=1;i<Frm.CheckMuestra.length;i++)
	{
		if (Frm.CheckMuestra[i].checked==true)
		{
			ValoresLotes=ValoresLotes + Frm.TxtLote[i].value + "~~" + Frm.TxtRecargo[i].value + Frm.TxtFin[i].value + "//";
		}
	}
	return(ValoresLotes);	
}
function ExistenElementosSolicitudes()
{
	var Frm=document.FrmSolicitudAut;
	try 
	{
		Frm.CheckSA[0];
		return(true)
	}	
	catch (e)
	{
		alert("No hay Elementos Seleccionados");
		return(false);
	} 
}
function ExistenElementosSolicitudesCheck()
{
	var Frm=document.FrmSolicitudAut;
	var EncontroCheck=false;
	try 
	{
		Frm.CheckSA[0];
		for (i=1;i<Frm.CheckSA.length;i++)
		{
			if (Frm.CheckSA[i].checked==true)
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
		 return(false);
	 } 
}

function SoloUnElementoSolicitudesCheck()
{
	var Frm=document.FrmSolicitudAut;
	var CantCheck=0;
	try 
	{
		Frm.CheckSA[0];
		for (i=1;i<Frm.CheckSA.length;i++)
		{
			if (Frm.CheckSA[i].checked==true)
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

function RecuperarSolicitudesCheckeados()
{
	var Frm=document.FrmSolicitudAut;
	var ValoresSA="";
	for (i=1;i<Frm.CheckSA.length;i++)
	{
		if (Frm.CheckSA[i].checked==true)
		{
			ValoresSA=ValoresSA + Frm.TxtIdMuestraO[i].value + "~~" + Frm.TxtFechaO[i].value + " " + Frm.TxtHoraO[i].value + Frm.TxtRecargoO[i].value + "//";
		}
	}
	return(ValoresSA);	
}
function BuscarSubProducto()
{
	var Frm=document.FrmSolicitudAut;
	window.open("cal_buscar_subproducto.php","","top=80,left=10,width=750,height=460,scrollbars=yes,resizable = no");	
}
function EliminarLote()
{
	var Frm=document.FrmSolicitudAut;
	var ValoresLotes="";
	var Resp ="";
	
	Resp=confirm("Esta seguro de eliminar los lotes seleccionados");
	if (Resp==true)
	{
		for (i=1;i<Frm.CheckMuestra.length;i++)
		{
			if (Frm.CheckMuestra[i].checked==true)
			{
				//if (Frm.TxtFin[i].value=="N")
				//{
					ValoresLotes=ValoresLotes + Frm.TxtLote[i].value + "~~" + Frm.TxtRecargo[i].value + "~~" + Frm.TxtFin[i].value + "//";
				//}
				//else
				//{
				//	alert("Lote con Fin='S' no se puede eliminar");
				//	Frm.BtnEliminarLote.focus();
				//	return;
				//}			
			}
		}
	}
	Frm.action="cal_solicitud_automatica01.php?proceso=B&Muestras_Check=" + ValoresLotes +"&EsBusqueda=S";
	Frm.submit();
}
function CerrarLote()
{
	var Frm=document.FrmSolicitudAut;
	
	var Muestra ="";
	var Recargo = "";
	var ContMuestras=0;

	if (SoloUnElementoLotesCheck())
	{
		for (i=1;i<Frm.CheckMuestra.length;i++)
		{
			if (Frm.CheckMuestra[i].checked==true)
			{
				Muestra=Frm.TxtLote[i].value;
				Recargo=Frm.TxtRecargo[i].value;
				break;
			}	
		}
		Frm.action="cal_solicitud_automatica01.php?proceso=C&Lote_a="+Muestra+"&Recarg_a="+Recargo+"&EsBusqueda=S";
		Frm.submit();
	}
}
</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmSolicitudAut" method="post" action="">
<?php include("../principal/encabezado.php");?>
  <table width="770" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td><strong> </strong> <table width="760" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td height="27"><div align="left"><strong> 
                <?php echo $Fecha_Hora ?>
                <input name='TxtMuestrasOculta' type='hidden'>
                <input name='TxtSolicitudOculta' type='hidden' value="<?php echo $TxtSolicitudOculta;?>">
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
				if ((isset($CmbSubProducto))&&(isset($Buscar)))
				{	
					echo "<div style='position:absolute; overflow:auto; left: 475px; top: 136px; width: 270px; height: 117px;'>";
					echo "<table width='0' border='1' align='left' cellpadding='2' cellspacing='0' bordercolor='#b26c4a'>";
					if ($CmbProductos==1)
					{
						$Consulta = "select lote,recargo,ult_registro,if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado from sipa_web.recepciones where cod_subproducto='".$CmbSubProducto."' and rut_prv ='".$CmbRutPrv."' and activo in ('S','M') and (sa_asignada ='' or isnull(sa_asignada)) order by lote,recargo_ordenado";
						$NomCampo="lote_a";
					}
					else
					{
						$Consulta = "select hornada_ventana from sea_web.hornadas where cod_producto =".$CmbProductos." and cod_subproducto=".$CmbSubProducto." and analizada='N' order by hornada_ventana";
						$NomCampo="hornada_ventana";			
					}
					$Respuesta = mysqli_query($link, $Consulta);
					$CantDetLote=0;
					//echo $Consulta;
					echo "<input type='hidden' name='CheckMuestra'><input type='hidden' name='TxtLote'><input type='hidden' name='TxtRecargo'><input type='hidden' name='TxtFin'>";
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo "<tr>";
						$CantDetLote=$CantDetLote+4;
						switch ($CmbProductos)
						{	
							case 1://PARA LOS LOTES
								echo "<td><center><input type='CheckBox' name='CheckMuestra' style='width:21' value = ".$Fila["lote"]."~~".$Fila["recargo"].$Fila["ult_registro"]."></center></td>";
								echo "<td><input type='text' name ='TxtLote' readonly style='width:75' value=".$Fila["lote"]."></td>";
								echo "<td><input type='text' name ='TxtRecargo' readonly style='width:75' value=".$Fila["recargo"]."></td>";
								echo "<td><input type='text' name ='TxtFin' readonly style='width:55' value=".$Fila["ult_registro"]."></td>";
								break;
							default://PARA LAS HORNADAS
								echo "<td><center><input type='CheckBox' name='CheckMuestra' style='width:21' value = ".$Fila["hornada_ventana"]."></center></td>";
								echo "<td><input type='text' name ='TxtLote' readonly style='width:75' value=".$Fila["hornada_ventana"]."></td>";			
								echo "<td><input type='text' name ='TxtRecargo' readonly style='width:75'></td>";
								echo "<td><input type='text' name ='TxtFin' readonly style='width:55'></td>";
								break;
						}
						echo "</tr>";					
					}
					echo "</table>";
					echo "</div>";
				}
				echo "<input name='TxtCantDetLote' type='hidden' value='$CantDetLote'>";				
				if ((isset($CmbSubProducto)) and (!isset($Modificar)))	
				{
					echo "<div style='position:absolute; overflow:auto; top: 112px; left:475px; width: 265px; height: 30px;'>"; 
					echo "<table width='0' border='1' align='left' class='ColorTabla01' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
					echo "<tr>"; 
					echo "<td style='width:21'>&nbsp;</td>";
					switch ($CmbProductos)
					{
						case 1:
							echo "<td style='width:76'>Lote</td>";
							echo "<td style='width:75'>Recargo</td>";
							echo "<td style='width:54'>Fin</td>";
							break;
						default:
							echo "<td style='width:76'>Id.Muestras</td>";	
							echo "<td style='width:75'></td>";
							echo "<td style='width:54'></td>";
							break;
					}	
					echo "</tr>";
					echo "</table>";
					echo "</div>";
				}	
			?>
                </strong></div></td>
            <td height="27" colspan="3"><div align="left"> 
                <?php
					if ($Modificar!='S')
					{
						echo "<input name='BtnBuscarSP' type='submit' value='Buscar SubProd' style='width:100' onClick='BuscarSubProducto();'>";
					}
                ?>
              </div></td>
            <td width="224" height="27"><div align="center"><strong> 
                <input name="BtnNuevo" type="submit" value="Nuevo" style="width:60" onClick="Nuevo();">
                &nbsp; 
                <input name="BtnModificar" type="button" value="Modificar" style="width:60" onClick="MostrarBuscar();">
                <?php
					if ($Modificar!='S')
					{
						if (isset($Buscar))	
						{
							echo "<input type='button' name='BtnCerrarLote' value='Cerrar Lote' style='width:75' onClick=CerrarLote();>";					
						}
					}	
				?>
                </strong></div></td>
          </tr>
          <tr> 
            <td width="132" height="23">Tipo Producto</td>
            <td width="293" height="23"><div align="left"><strong> 
                <?php          
				if($Modificar!='S')
				{
					echo "<select name='CmbProductos' style='width:250' onChange=Recarga();>";
					echo "<option value='-1' selected>Seleccionar</option>";
					if (isset($FechaBuscar))
					{
						$CmbProductos = $Productos;
					}
					$Consulta="select cod_producto,descripcion from productos where mostrar = 'S' order by descripcion"; 
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
            <td width="1" height="23">&nbsp;</td>
            <td colspan="2" align="left">&nbsp; 
              <?php
				if (!isset($Modificar))
				{
					echo "<input name='BtnBusqueda' type='button' id='BtnBusqueda' style='width:75' onClick='Buscar();' value='Busqueda'>"; 
					if ($CmbProductos==1)
					{
						echo "<input type='button' name='BtnDetMuestra' value='Detalle' style='width:75' onClick=MostrarDetalleLote();>";
					}
					if (isset($Buscar))	
					{
						echo "<input type='button' name='BtnOkDetalle' value='Ok' style='width:75' onClick=ValidarDatos('N','S');>";
						echo "<input type='button' name='BtnEliminarLote' value='Ocultar Lote' style='width:75' onClick=EliminarLote();>";						
					}	
				}
			?>
            </td>
          </tr>
          <tr> 
            <td height="23">Tipo SubProducto</td>
            <td height="23"><strong> 
              <?php
				if($Modificar!='S')
				{
					echo "<select name='CmbSubProducto' style='width:250' onChange=Recarga();>";
					echo "<option value='-1' selected>Seleccionar</option>";
					if (isset($FechaBuscar))
					{
						$CmbSubProducto = $CmbSubProducto;
					}
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' and mostrar = ".$CmbProductos; 
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
					echo "</select>";
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
            <td align="center">&nbsp;</td>
            <td colspan="2" align="left">&nbsp; </td>
          </tr>
          <tr> 
            <?php
				if($Modificar!='S')
				{
					if ($CmbProductos==1)
					{
            			echo "<td height='23'>Busqueda Proveedor</td>";
						echo "<td height='23'><input type='text' name='TxtNomPrv' style='width:130' value ='$TxtNomPrv'>&nbsp;&nbsp;<input type='Button' name='BtnOKPrv' value='Ok' onclick='BuscarPrv();'>";
					}
					else
					{
            			echo "<td colspan=2>&nbsp;</td>";
					}
				}
				else
				{
					echo "<td height='23'>Proveedor</td>";
					$Consulta = "select distinct(id_muestra),cod_tipo_muestra from cal_web.solicitud_analisis where (rut_funcionario ='".$CookieRut."') and ";
					$Consulta = $Consulta."(fecha_hora ='".$FechaHora."' and cod_producto = '".$Productos."' and cod_subproducto = '".$SubProducto."')";
					$Respuesta = mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Consulta ="select t1.rut_prv_a,t2.nombre_prv from sipa_web.recepciones t1 inner join t2.proveedores on t1.rut_prv=t2.rut_prv ";
					$Consulta.="where t1.lote='".$Fila["id_muestra"]."'";
					if (strlen(trim($SubProducto))==1)
					{
						 $Consulta=$Consulta." and t1.cod_subproducto='0".$SubProducto."'"; 
					}
					else
					{
						 $Consulta=$Consulta." and t1.cod_subproducto='".$SubProducto."'"; 						
					}	 
					echo $Consulta;
					$Respuesta2 = mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Respuesta2);
					echo "<td height='23'><strong>".$Fila2["rut_prv"]."  ".$Fila2["nombre_prv"]."</strong></td>";
					echo "<input type='hidden' name='CmbRutPrv' value='".$Fila2[rut_prv]."'>";
					$CmbRutPrv=$Fila2["rut_prv"];
				}	
			?>
          </tr>
          <tr> 
            <?php
				if($Modificar!='S')
				{
					if ($CmbProductos==1)
					{
						if ($BuscarPrv=='S') 
						{
							echo "<td>Nombre Proveedor</td>";
							echo "<td colspan=2>";
							echo "<select name='CmbRutPrv' style='width:300px' value='$CmbRutPrv'>";
							echo "<option value='-1' selected>Seleccionar</option>";
							$Consulta = "select distinct t1.rut_prv,t2.nombre_prv from sipa_web.recepciones t1 inner join sipa_web.proveedores t2 on t1.rut_prv = t2.rut_prv where t2.nombre_prv like '%".strtolower($TxtNomPrv)."%' and t1.cod_subproducto ='".$CmbSubProducto."'"; 
							$Respuesta=mysqli_query($link, $Consulta);
							//echo $Consulta;
							while ($Fila=mysqli_fetch_array($Respuesta))
							{
								if ($Fila["rut_prv"]==$CmbRutPrv)
								{
									echo "<option value ='".$Fila["rut_prv"]."' selected>".$Fila["rut_prv"]." - ".$Fila["nombre_prv"]."</option>";							
								}
								else
								{
									echo "<option value ='".$Fila["rut_prv"]."'>".$Fila["rut_prv"]." - ".$Fila["nombre_prv"]."</option>";
								}	
							}
							echo "</select></td>";
						}					
					}
					else
					{
            			echo "<td height='23' colspan=2></strong></td>";
					}
				}
			  ?>
          <tr> 
            <td height="23">Tipo Analisis</td>
            <td height="23"> 
              <?php
				if($Modificar!='S')
				{
				  echo "<select name='CmbTipoAnalisis' style='width:110'>";
				  $Consulta= "select * from sub_clase where cod_clase = 1000";
				  $Respuesta= mysqli_query($link, $Consulta);
				  while ($Fila=mysqli_fetch_array($Respuesta))
				  {
					if ($CmbTipoAnalisis == $Fila["cod_subclase"])
					{
						echo "<option value ='".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 			
					}
					else			
					{	
						if ($Fila["cod_subclase"]=='1')
						{
							echo "<option value ='".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
						}
						else
						{
							echo "<option value ='".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
						}
					}
				  }
				 } 
				else	
				{
					echo "<strong>";
					$Consulta = "select distinct(id_muestra),nombre_subclase from cal_web.solicitud_analisis inner join proyecto_modernizacion.sub_clase on cod_clase='1000' and cod_analisis=cod_subclase  where (rut_funcionario ='".$CookieRut."') and ";
					$Consulta = $Consulta."(fecha_hora ='".$FechaHora."' and cod_producto = '".$Productos."' and cod_subproducto = '".$SubProducto."')";
					$Respuesta = mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					echo ucwords(strtolower($Fila["nombre_subclase"]));
				}
			
				echo "</strong>"
			?>
              &nbsp;&nbsp;&nbsp; 
              <?php 
				if (isset($ValorMuestreo))
				{
					if ($ValorMuestreo == 1)
						{
					echo "<input type='checkbox' name='CheckMuestreo' value='' Checked>Muestreo";		
						}
					else
						{
						echo "<input type='checkbox' name='CheckMuestreo' value=''>Muestreo";		
						}				
				}
				else
				{
					if (isset($Modificar))
					{
						$Consulta = "select distinct(id_muestra),cod_tipo_muestra from cal_web.solicitud_analisis where (rut_funcionario ='".$CookieRut."') and ";
						$Consulta = $Consulta."(fecha_hora ='".$FechaHora."' and cod_producto = '".$Productos."' and cod_subproducto = '".$SubProducto."')";
						$Respuesta = mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						if (($Fila["cod_tipo_muestra"]=='2') or ($Fila["cod_tipo_muestra"]=='3'))
						{
							echo "<input type='checkbox' name='CheckMuestreo' value='' disabled checked><strong>Muestreo<strong>";		
						}
						else
						{
							echo "<input type='checkbox' name='CheckMuestreo' value='' disabled ><strong>Muestreo<strong>";						
						}	
					}
					else
					{
						echo "<input type='checkbox' name='CheckMuestreo' value='' checked>Muestreo";		
					}	
				}
		  ?>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <?php 
				if (isset($ValorAnalisis))
				{
					if ($ValorAnalisis == 1)
						{
							echo "<input type='checkbox' name='CheckAnalisis' value='' checked>Analisis</td>";
						}
					else
						{
							echo "<input type='checkbox' name='CheckAnalisis' value=''>Analisis</td>";				
						}				
				}
				else
				{
					if (isset($Modificar))
					{
						$Consulta = "select distinct(id_muestra),cod_tipo_muestra from cal_web.solicitud_analisis where (rut_funcionario ='".$CookieRut."') and ";
						$Consulta = $Consulta."(fecha_hora ='".$FechaHora."' and cod_producto = '".$Productos."' and cod_subproducto = '".$SubProducto."')";
						$Respuesta = mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						if (($Fila["cod_tipo_muestra"]=='1') or ($Fila["cod_tipo_muestra"]=='3'))
						{
							echo "<input type='checkbox' name='CheckAnalisis' value='' disabled checked>Analisis</td>";
						}	
						else
						{
							echo "<input type='checkbox' name='CheckAnalisis' value='' disabled >Analisis</td>";				
						}
					}
					else
					{
						echo "<input type='checkbox' name='CheckAnalisis' value='' checked>Analisis</td>";		
					}	
				}
		  ?>
              <strong> </strong> 
            <td height="23"> 
            <td colspan="2">&nbsp; </td>
          </tr>
          <tr> 
            <?php
				if ($Modificar!='S')
				{
					echo "<td height='23'>&nbsp;</td>";
					echo "<td height='23'>&nbsp;</td>";
				}
				else
				{
				  echo "<td height='23'>&nbsp;</td>";
				  echo "<td height='23'>&nbsp;</td>";
				}	
			?>
            <td height="23">&nbsp;</td>
            <td colspan="2" height="23">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
        </table>
        <br> <table width="760" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="68" rowspan="2"> <strong> 
              <input name="CheckTodos" type="checkbox" id="CheckTodos3" value="checkbox" onClick="ChequearTodo();">
              Todos</strong></td>
            <td width="33"><strong>C.C</strong></td>
            <td width="391"><strong> 
              <select name="CmbCCosto" style="width:280">
              <option value ='-1' selected>Seleccionar</option>\n;
              <?php
					$Consulta = "select centro_costo,descripcion from proyecto_modernizacion.centro_costo  where mostrar_calidad='S' order by centro_costo";
					$Respuesta = mysql_query ($Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo "<option value = '".$Fila[centro_costo]."'>".$Fila[centro_costo]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
					}
					echo "<option value ='-1'>____________________________________________________</option>\n";
					$Consulta = "select centro_costo,descripcion from proyecto_modernizacion.centro_costo where mostrar_calidad<>'S' order by centro_costo";
					$Respuesta = mysql_query ($Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo "<option value = '".$Fila[centro_costo]."'>".$Fila[centro_costo]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
					}
			  ?>
              </select>
              <input name="BtnOk1" type="button" id="BtnOk1" value="Ok" onClick="ValidarDatos('M1');">
              </strong></td>
            <td width="47"><div align="left"><strong>Periodo</strong> </div>
              <div align="right"> </div></td>
            <td width="142"><strong> 
              <select name="CmbPeriodo" style="width:130">
              <option value ='-1' selected>Seleccionar</option>\n";
              <?php  
				$Consulta = "select * from sub_clase where cod_clase = 2 order by valor_subclase1";
				$Respuesta= mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					echo "<option value = '".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";
				}
		      ?>
              </select>
              </strong></td>
            <td width="39"><div align="right"><strong> 
              <?php
					if ($CmbProductos==1)
					{
						if ($Modificar=="S")
						{
							echo "<input name='BtnOk22' type='button' value='Ok' onClick=\"ValidarDatos('M3','','$Buscar','$BuscarPrv','$Modificar');\">";
						}
						else
						{
							echo "<input name='BtnOk22' type='button' value='Ok' onClick=\"ValidarDatos('M3','','$Buscar','$BuscarPrv');\">";
						}	
					}
					else
					{
						if ($Modificar=="S")
						{
							echo "<input name='BtnOk22' type='button' value='Ok' onClick=\"ValidarDatos('M3','','$Buscar','-1','$Modificar');\">";
						}
						else
						{
							echo "<input name='BtnOk22' type='button' value='Ok' onClick=\"ValidarDatos('M3','','$Buscar','-1');\">";
						}	
					}	
                ?>
				</strong></div></td>
          </tr>
          <tr> 
            <td><strong>Area</strong></td>
            <td><strong> 
              <select name="CmbAreasProceso" style="width:280">
              <option value ='-1' selected>Seleccionar</option>\n;
	        <?php
				$Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase = 3 order by valor_subclase1";
				$Respuesta = mysql_query ($Consulta);
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
            <td colspan="3"><div align="center"><strong> </strong><strong> 
            <?php
				  if (isset($Modificar))
				  {
					echo "<input name='BtnPlantillas' type='Button' id='BtnPlantillas' style='width:70' onClick=MostrarPlantilla('P','$Productos','$SubProducto','','','','S'); value='Plantillas'>&nbsp";
					echo "<input name='BtnLeyes' type='Button' style='width:80' onClick=MostrarLeyes('$Productos','$SubProducto','','','','S'); value='Leyes'>&nbsp;";
				  }
				  else
				  {
					echo "<input name='BtnPlantillas' type='Button' id='BtnPlantillas' style='width:70' onClick=MostrarPlantilla('P','$CmbProductos','$CmbSubProducto','$Buscar','$BuscarPrv','$CmbRutPrv','N'); value='Plantillas'>&nbsp";
					echo "<input name='BtnLeyes' type='Button' style='width:80' onClick=MostrarLeyes('$Productos','$SubProducto','$Buscar','$BuscarPrv','$CmbRutPrv','N'); value='Leyes'>&nbsp;";		  
				  }
           ?>
           <input name="BtnDetalle" type="Button" id="BtnDetalle" style="width:70" onClick="MostrarDetalleSolicitudLote();" value="Detalle">
           </strong> <strong> </strong></div></td>
           </tr>
        </table>
        <strong> </strong><br> <table width="760" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
          <tr class="ColorTabla01"> 
            <td width="2%">&nbsp;</td>
            <td width="8%"><div align="right"><strong> Muestra</strong></div></td>
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
					$Consulta = "select *,t1.nro_solicitud as SA,t1.fecha_hora as fecha_hora,t1.cod_analisis as cod_analisis,t1.recargo as recargo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado from solicitud_analisis t1 left join estados_por_solicitud t2 on ";
					$Consulta =$Consulta."t1.rut_funcionario = t2.rut_funcionario and t1.nro_solicitud= t2.nro_solicitud and t1.recargo = t2.recargo "; 
					$Consulta =$Consulta."and t2.cod_estado = 1 where (t1.rut_funcionario ='".$CookieRut."') and ";
					$Consulta =$Consulta."(t1.fecha_hora ='".$FechaHora."' and cod_producto = '".$ValorProducto."' and cod_subproducto = '".$ValorSubProducto."' and tipo_solicitud='A') order by id_muestra,recargo_ordenado";
					$Respuesta =mysqli_query($link, $Consulta);
					echo "<input type='hidden' name='CheckSA'><input type='hidden' name='TxtIdMuestraO'><input type='hidden' name='TxtFechaO'><input type='hidden' name='TxtHoraO'><input type='hidden' name='TxtRecargoO'><input type = 'hidden' name ='TxtCodAnalisisO'><input type='hidden' name='TxtCCosto'><input type='hidden' name='TxtArea'><input type='hidden' name='TxtLeyes'><input type='hidden' name='TxtImpurezas'>";
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo "<tr>";
						$Entrar=true;
						if ((!isset($Modificar)) or ($Modificar!='S'))
						{
							if ((!is_null($Fila["recargo"])) or ($Fila["recargo"]!=''))
							{
								if ($Fila["recargo"]!='0')
								{
									if ((!is_null($Fila["nro_solicitud"])) || ($Fila["nro_solicitud"]!=''))
									{
										$Entrar=false;						
									}
								}
							}
						}
						if ($Entrar==true)
						{
						if ((is_null($Fila["recargo"])) or ($Fila["recargo"]==''))
						{
							$MuestraAChequear=$Fila["id_muestra"];
						}
						else
						{
							$MuestraAChequear=$Fila["id_muestra"]."~~".$Fila["fecha_hora"].$Fila["recargo"];
						}
						$pos = strpos($ValorCheck, $MuestraAChequear);
						if ($pos === false)
						{ 
							if ((is_null($Fila["recargo"])) or ($Fila["recargo"]==''))
							{
								echo "<td width='3%'><input name='CheckSA' type='checkbox'></td>";
							}
							else
							{
								echo "<td width='3%'><input name='CheckSA' type='checkbox'></td>";
							}	
						}
						else
						{
							if ((is_null($Fila["recargo"])) or ($Fila["recargo"]==''))
							{
								echo "<td width='3%'><input name='CheckSA' type='checkbox' checked></td>";
							}
							else
							{
								echo "<td width='3%'><input name='CheckSA' type='checkbox' checked></td>";
							}	
						}	
						
						if ((is_null($Fila["recargo"])) or ($Fila["recargo"]==''))
						{
							if ($Fila["cod_analisis"]==1)
							{
								echo "<td width='8%'><div align='center'><input name='TxtIdMuestra' type='text' style ='background:#97BBCE' readonly style='width:90' maxlength='10' value ='".$Fila["id_muestra"]."'><input type='hidden' name='TxtIdMuestraO' value ='".$Fila["id_muestra"]."'><input type = 'hidden' name='TxtFechaO' value ='".substr($Fila["fecha_hora"],0,10)."'><input type = 'hidden' name='TxtHoraO' value ='".substr($Fila["fecha_hora"],11,8)."'><input type='hidden' name = 'TxtRecargoO' value ='N'>";
								echo "<input type = 'hidden' name = 'TxtCodAnalisisO' value ='".$Fila["cod_analisis"]."'></div></td>\n";
							}
							else
							{
								echo "<td width='8%'><div align='center'><input name='TxtIdMuestra' type='text' style ='background:#C6C5AE' readonly style='width:90' maxlength='10' value ='".$Fila["id_muestra"]."'><input type='hidden' name='TxtIdMuestraO' value ='".$Fila["id_muestra"]."'><input type = 'hidden' name='TxtFechaO' value ='".substr($Fila["fecha_hora"],0,10)."'><input type = 'hidden' name='TxtHoraO' value ='".substr($Fila["fecha_hora"],11,8)."'><input type='hidden' name = 'TxtRecargoO' value ='N'>";
								echo "<input type = 'hidden' name = 'TxtCodAnalisisO' value ='".$Fila["cod_analisis"]."'></div></td>\n";
							}	
						}
						else
						{
							if ($Fila["cod_analisis"]==1)
							{
								echo "<td width='8%'><div align='center'><input name='TxtIdMuestra' type='text' style ='background:#97BBCE' readonly style='width:90' maxlength='10' value ='".$Fila["id_muestra"]."-".$Fila["recargo"]."'><input type='hidden' name='TxtIdMuestraO' value ='".$Fila["id_muestra"]."'><input type = 'hidden' name='TxtFechaO' value ='".substr($Fila["fecha_hora"],0,10)."'><input type = 'hidden' name='TxtHoraO' value ='".substr($Fila["fecha_hora"],11,8)."'>";
								echo "<input type='hidden' name = 'TxtRecargoO' value = '".$Fila["recargo"]."'><input type = 'hidden' name = 'TxtCodAnalisisO' value ='".$Fila["cod_analisis"]."'></div></td>\n";
							}
							else
							{
								echo "<td width='8%'><div align='center'><input name='TxtIdMuestra' type='text' style ='background:#C6C5AE' readonly style='width:90' maxlength='10' value ='".$Fila["id_muestra"]."-".$Fila["recargo"]."'><input type='hidden' name='TxtIdMuestraO' value ='".$Fila["id_muestra"]."'><input type = 'hidden' name='TxtFechaO' value ='".substr($Fila["fecha_hora"],0,10)."'><input type = 'hidden' name='TxtHoraO' value ='".substr($Fila["fecha_hora"],11,8)."'>";
								echo "<input type='hidden' name = 'TxtRecargoO' value = '".$Fila["recargo"]."'><input type = 'hidden' name = 'TxtCodAnalisisO' value ='".$Fila["cod_analisis"]."'></div></td>\n";
							}	
						}
						if(!is_null($Fila["cod_area"]))
						{
							$Consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase=3 and cod_subclase =".$Fila["cod_area"];
							$RespArea=mysqli_query($link, $Consulta);
							$FilaArea =mysqli_fetch_array($RespArea);
							echo "<td><div align='center'><input name='TxtArea' type='text' maxlength='10' readonly  style='width:80' value ='".$Fila["cod_area"]."-".$FilaArea["valor_subclase1"]."'>";
						}
						else
						{
							echo "<td><div align='center'><input name='TxtArea' type='text' maxlength='10' readonly  style='width:80' value = '".$Fila["cod_area"]."'>";					
						}	
						echo "</div></td><td class='TD'> <div align='left'>&nbsp;<input name='TxtCCosto' type='text' maxlength='6' readonly style='width:50' value = '".$Fila["cod_ccosto"]."'></div></td>";
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
						echo "<td class='TD'><div align='center'><input name='TxtLeyes' type='text' readonly style='color:red;width:120' value = '".$Leyes."'></div></td>";
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
						echo "<td class='TD'><div align='center'><input name='TxtImpurezas' type='text' readonly style='width:120' value = '".$Impurezas."'></div></td>";
						if ((is_null($Fila["SA"])) or ($Fila["SA"]==""))
						{
							$NroSolicitud="";//$Fila["SA"];
						}
						else
						{
							if ((is_null($Fila["recargo"])) or ($Fila["recargo"]==""))
							{
								$NroSolicitud=$Fila["SA"];
							}	
							else
							{
								$NroSolicitud=$Fila["SA"]."-".$Fila["recargo"];					
							}
						}	
						echo "<td class='TD'><input name='TxtSA' type='text' readonly style='width:110' maxlength='20' value = '".$NroSolicitud."'></td>";
						if ((is_null($Fila["cod_periodo"])) or ($Fila["cod_periodo"] == ""))
						{
							echo "<td class='TD'><input type='Text' name='TxtPeriodo' readonly style='width:100'></td>";											
						}	
						else
						{
							$Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase = 2 and cod_subclase =".$Fila["cod_periodo"];
							$Resultado2 = mysqli_query($link, $Consulta);
							$Fila2 = mysqli_fetch_array($Resultado2);
							if ($Fila["cod_periodo"]=='1')
							{
								echo "<td class='TD'><input type='Text' name='TxtPeriodo' readonly style='width:100' value = '".$Fila2["nombre_subclase"]."'></td>";					
							}
							else
							{
								echo "<td class='TD'><input type='Text' name='TxtPeriodo' readonly style='width:100' value = '".$Fila2["nombre_subclase"]."'></td>";
							}					
						}
						}	
						echo "</tr>";
					}
				}
	      ?>
          <tr> 
            <td height="25" colspan="8"> <div align="center"><strong> 
                <input name="BtnEliminar" type="Button" id="BtnEliminar2" value="Eliminar" style="width:70" onClick="ValidarDatos('E');">
                </strong>&nbsp;<strong> </strong> </div></td>
          </tr>
        </table>
        <br> <table width="760" border="0" align="center" class="TablaInterior">
          <tr> 
            <td height="66"> <div align="left"><strong> 
                <textarea name="TxtObs" id="TxtObs" style="width:740">
				</textarea>
                </strong> </div></td>
          </tr>
          <tr> 
            <td><strong>Responsable:</strong> 
            <?php
				echo "<strong>";
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
            <td> <div align="center"><strong> 
          <?php	
				if ($Modificar!=='S')
				{
					echo "<input name='BtnGenerar' type='Button' id='BtnGenerar' value='Generar' style='width:70' onClick=ValidarDatos('G');>";
				}
				else
				{
					echo "<input name='BtnGrabar' type='Button' value='Grabar' style='width:70' onClick=ValidarDatos('G');>";				
				}

			?>
                </strong> 
                <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70" onClick="Salir();">
              </div></td>
          </tr>
        </table>
		</td>
    </tr>
  </table>
<?php include ("../principal/cerrar_cal_web.php");?>  
<?php include("../principal/pie_pagina.php");?>
</form>
</body>
</html>
