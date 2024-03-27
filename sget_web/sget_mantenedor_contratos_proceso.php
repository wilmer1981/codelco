<? include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");

if($Form!='')
{
	if($Contrato=='S')
		$Opcion='N';
	else
	{	
		$Opcion='M';
		$TxtContrato=$TxtContrato;
		$NewOpc = 'S';
	}
}
	
//echo "RRR".$TxtContrato.".--".$Opcdion;
if($Empresa)
	$CmbEmpresa=$Empresa;
if($Prevencionista!='')
	$CmbPrevencionista=$Prevencionista;

if (!isset($CmbAdmContratista))
	$CmbAdmContratista='-1';
if (!isset($CmbTipoModificacion))
	$CmbTipoModificacion='1';	
if (!isset($CmbAdmCtto))
	$CmbAdmCtto='-1';
if (!isset($Mensaje))
	$Mensaje='N';			
if (!isset($CmbTipoCtto))
	$CmbTipoCtto='-1';
if (!isset($CmbEmpresa))
	$CmbEmpresa='-1';
	
	
		
if (isset($TxtMontoCtto)&&$TxtMontoCtto!='')
	$TxtMontoCtto=str_replace('.','',$TxtMontoCtto);
	
if($Opcion=='M')
{
	$Titulo="MODIFICACION ";
	if($Contrato!='')
		$TxtContrato=$Contrato;
}
else
{
 	$Titulo="INGRESO ";
}

if(!isset($Recarga))
{
	if ($Opcion=='M')
	{
		
		$Consulta="SELECT * from sget_contratos where cod_contrato = '".$TxtContrato."'";
		//echo "WW".$Consulta;
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$TxtContrato=$Fila["cod_contrato"];
			$TxtDescripcion=$Fila["descripcion"];
			$CmbGerencias=$Fila["cod_gerencia"];
			$CmbAreas=$Fila["cod_area"];
			$TxtMontoCtto=$Fila["monto_ctto"];
			$TxtFechaInicio=$Fila["fecha_inicio"];
			$TxtFechaTermino=$Fila["fecha_termino"];
			$CmbEmpresa=$Fila["rut_empresa"];
			$CmbTipoCtto=$Fila["cod_tipo_contrato"];
			$CmbAdmCtto=$Fila["rut_adm_contrato"];
			$CmbAdmContratista=$Fila["rut_adm_contratista"];
			$TxtFechaGarantia=$Fila["fecha_venc_bol_garantia"];
			$TxtCelular=$Fila["celular"];
			$TxtFechaSolp=$Fila["fecha_solp"];	
			$CmbPrevencionista=$Fila["rut_prev"];	
			$CmbMoneda=$Fila["tipo_cambio"];
			$CmbFacturacion= $Fila["periodo_facturacion"];
			$CmbTipoCttoPers=$Fila["tipo_ctto"];
			$CmbAvisoVenc=$Fila["aviso_vencimiento"];
			$TxtPoliza=$Fila[poliza];
			$CmbEstado=$Fila["estado"];	
			//ACUERDOS MARCOS
			$CmbAcuerdo=$Fila["acuerdo_marco"];
			$CmbClasificacion=$Fila["clasificacion"];
			$CmbBono=$Fila["bono"];
			$CmbReaj=$Fila["reajuste"];
			$CmbSeg=$Fila["seguro"];
			$CmbEco4=$Fila["eco4"];
			$CmbSobreT=$Fila["sobretiempo"];
			$CmbGratif=$Fila["gratificacion"];
			$CmbIndem=$Fila["indemnizacion"];			
			$PostergarSN=$Fila["posterga"];
			$TxtJornada=$Fila["tipo_jornada"];
			$TxtFechaPosterga=$Fila["fecha_posterga"];
			if($PostergarSN=='S')
				$PostergarSN='checked=checked';
			else
				$PostergarSN='';	
		}
	}
	//echo "POLY".$CmbClasificacion;
	if($Opcion2=='SGC')
	{
		include("sgc_conectar.php");
		$Consulta="SELECT descrip_contrato,monto,fecha_inicio,fecha_termino,rut_empresa from sgc_contratos where cod_contrato='".$Ctto."'";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$TxtContrato=$Ctto;
			$TxtDescripcion=$Fila["descrip_contrato"];
			$TxtMontoCtto=$Fila["monto"];
			$TxtFechaInicio=$Fila["fecha_inicio"];
			$TxtFechaTermino=$Fila["fecha_termino"];
			$CmbEmpresa=strtoupper($Fila["rut_empresa"]);
		}
		else
		{
			//$TxtContrato='';$TxtDescripcion='';$TxtMontoCtto='';$TxtFechaInicio='';$TxtFechaTermino='';$CmbEmpresa='';
		}
		mysql_close();
		include("../principal/conectar_sget_web.php");
	}	
}	
if ($CmbAdmCtto2!='')
	$CmbAdmCtto=$CmbAdmCtto2;
if ($CmbAdmContratista2!='')
	$CmbAdmContratista=$CmbAdmContratista2;	
?>
<html>
<head>
<?
	if ($Opcion=='N')
		echo "<title>Nuevo Contrato</title>";
	else	
		echo "<title>Modifica Contrato</title>";
?>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function ModificaCont()
{
	var f = document.FrmPopupUsuario;
	if (confirm("Esta opci�n Reemplazar� N�mero Contrato por Nuevo Ingresado"))
	{
		f.ContAnt.value = f.TxtContrato.value;
		//alert (f.ContAnt.value);
		f.NewOpc.value = 'S';
		//alert(f.NewOpc.value);
		f.TxtContrato.value = '';
		f.action = "sget_mantenedor_contratos_proceso.php?NewOpc = f.NewOpc.value";
		f.submit();             
	}
	else
	{
		f.NewOpc.value = "N";
		return;
	}

}
function ModSub(Dato,Fecha)
{
	var f= document.FrmPopupUsuario;
	f.Opcion.value='MSubC';
	for(i=0;i<f.elements.length;i++)
	{
		if(f.elements[i].name==Fecha)
			var Valor=f.elements[i].value;
	}
	f.action = "sget_mantenedor_contratos01.php?Dato="+Dato+"&DFecha="+Valor;
	f.submit();
}
function Agregar(Tipo)
{
	var f= document.FrmPopupUsuario;
	switch(Tipo)
	{
		case "EmpSub":
			if(f.CmbSubEmpresa.value!='-1')
			{
				if(f.TxtReunnionASUB.value=='')
				{
					alert('Debe Seleccionar Fecha Arranque Sub-Contratista')
					f.TxtReunnionASUB.focus();
					return;
				}
				f.Opcion.value='GSC';
				f.action = "sget_mantenedor_contratos01.php";
				f.submit();
			}
			else
			{
				alert('Debe Selecionar  Empresa');
				f.CmbSubEmpresa.focus();
			}
		break;
		case "ReajCtto":
			if(f.TxtFechaReajuste.value=='')
			{
				alert('Debe Ingresar Fecha Reajuste');
				return;
			}	
			if(f.CmbReajuste.value=='S')
			{
				alert('Debe Seleccionar Periodo');
				return;
			}	
			if(f.TxtFechaTermino.value=='')
			{
				alert('Debe Ingresar Fecha Termino Contrato para Calcular Reajustes');
				return;
			}	
			if(f.CmbMoneda.value!='3')
			{
				alert('Reajustes Solo para Contratos en ($)Pesos');
				return;
			}
			f.Opcion.value='GRC';//GRABAR REAJUSTE MONTO CONTRATO
			f.action = "sget_mantenedor_contratos01.php";
			f.submit();
		
		break;
		case "ReajSueldo":
			if(f.TxtFechaReajuste2.value=='')
			{
				alert('Debe Ingresar Fecha Reajuste');
				return;
			}	
			if(f.CmbReajuste2.value=='S')
			{
				alert('Debe Seleccionar Periodo');
				return;
			}	
			if(f.TxtFechaTermino.value=='')
			{
				alert('Debe Ingresar Fecha Termino Contrato para Calcular Reajustes');
				return;
			}	

			f.Opcion.value='GRS';//GRABAR REAJUSTE MONTO SUELDO TRABAJADORES DEL CONTRATO 
			f.action = "sget_mantenedor_contratos01.php";
			f.submit();
		
		break;
	}		
}	
function Eliminar(Clv)
{
	var f= document.FrmPopupUsuario;
	mensaje=confirm("�Esta Seguro de Eliminar El Registro?");
	if(mensaje==true)
	{
		f.Opcion.value='ESC';
		f.action = "sget_mantenedor_contratos01.php?Opcion=ESC&Clave="+Clv;
		f.submit();
	}
}	

function Recarga(Seleccion)
{
	var f= document.FrmPopupUsuario;
	f.action = "sget_mantenedor_contratos_proceso.php?Opcion=M&CmbTipoModificacion="+Seleccion; 
	f.submit();
}
	
function ElimDF(Fecha,Contrato)
{
	var f= document.FrmPopupUsuario;
	mensaje=confirm("�Esta Seguro de Eliminar El Registro?");
	if(mensaje==true)
	{
		f.Opcion.value='EDF';
		f.action = "sget_mantenedor_contratos01.php?Opcion=EDF&Fecha="+Fecha;
		f.submit();

	}

}
function BuscarEnSGC()
{
	var f= document.FrmPopupUsuario;
	f.action = "sget_mantenedor_contratos_proceso.php?Opcion2=SGC&Ctto="+f.TxtContrato.value;
	f.submit();
}
function Reajuste(Tipo)
{

	var f= document.FrmPopupUsuario;
	if(Tipo==1)
	{
		var Fecha=f.TxtFechaReajuste.value;
		var Meses=f.CmbReajuste.value;
		var NuevaFecha;
		if(Fecha!='' && Fecha!='0000-00-00')
		{
			if(Meses!='S')
			{
				NuevaFecha= FechaReajuste(Fecha,Meses);
				f.TxtFechaReajusteResultado.value=NuevaFecha
			}
		}
	}
	if(Tipo==2)
	{
		var Fecha=f.TxtFechaReajuste2.value;
		var Meses=f.CmbReajuste2.value;
		var NuevaFecha;
		if(Fecha!='' && Fecha!='0000-00-00')
		{
			if(Meses!='S')
			{
				NuevaFecha= FechaReajuste(Fecha,Meses);
				f.TxtFechaReajusteResultado2.value=NuevaFecha
			}
		}
	}
}
	
function Proceso(Opcion)
{
	var f= document.FrmPopupUsuario;
	var Valida=true;
	var Veri="";
	var Adm="";
	var Check="";
	var CmbFacturacion = "";
	var CmbClasificacion = "";
	switch(Opcion)
	{
		
		case "GDF":	
		if(f.NFactura.value=='')
		{
			alert("Debe Ingresar Nro. Factura");
			f.NFactura.focus();
			return;
		}
		if (f.TxtFechaEmiDoc.value=='')
		{
			alert("Debe Ingresar Fecha Emisi�n de Documento");
			return;
		}
		if(f.TxtFechaIngDoc.value=='')
		{
			alert("Debe Ingresar Fecha Ingreso de Documento");
			return;
		}
		if(f.TxtFechaIngContabilidad.value=='')
		{
			alert("Debe Ingresar Fecha Ingreso Contabilidad");
			return;
		}
		if(f.TxtFechaIngLiberacion.value=='')
		{
			alert("Debe Ingresar Fecha Liberaci�n");
			return;
		}

		if(f.TxtDot.value=='')
		{
			alert("Debe Ingresar Dotaci�n");
			f.TxtDot.focus();
			return;
		}
		if (f.OptFactura.checked==true)
				MasFac = "S";
			else
				MasFac = "N";
		f.Opcion.value=Opcion;
	    f.action = "sget_mantenedor_contratos01.php?Opcion="+Opcion+"&MasFac="+MasFac;
		f.submit();
		break;
	
		case "GMC":	
			f.Opcion.value=Opcion;
			Veri=ValidaCampo();
			if (Veri==true)
			{
				f.action = "sget_mantenedor_contratos01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "MMC":	  
			f.Opcion.value=Opcion;
			Veri=ValidaCampo();   
			if (Veri==true)
			{
				f.action = "sget_mantenedor_contratos01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "N":
		
			f.Opcion.value=Opcion;
			Veri=ValidaCampos();
			if (Veri==true)
			{
				var posterga='N';
				if(f.Postegar.checked==true)
					posterga='S';
				f.action = "sget_mantenedor_contratos01.php?Opcion="+Opcion+'&PostCont='+posterga;
				f.submit();
			}
		break;
		case "M":
			f.Opcion.value=Opcion;
			//alert (Opcion);
			Veri=ValidaCampos();
		//	alert (f.CmbClasificacion.value);
			if (Veri==true)
			{
				var posterga='N';
				if(f.Postegar.checked==true)
					posterga='S';
				f.action = "sget_mantenedor_contratos01.php?Opcion="+Opcion+"&CmbFacturacion="+f.CmbFacturacion.value +"&CmbClasificacion="+f.CmbClasificacion.value+'&PostCont='+posterga;
				f.submit();
			}
		break;
		case "Ctto":	
			URL = "sget_ingreso_administradores.php?Opc=A&TxtContrato="+f.TxtContrato.value+"&TxtDescripcion="+f.TxtDescripcion.value+"&CmbGerencias="+f.CmbGerencias.value+"&CmbAreas="+f.CmbAreas.value+"&CmbEmpresa="+f.CmbEmpresa.value
		 	URL =URL+ "&TxtMontoCtto="+f.TxtMontoCtto.value+"&TxtFechaInicio="+f.TxtFechaInicio.value+"&TxtFechaTermino="+f.TxtFechaTermino.value+"&CmbTipoCtto="+f.CmbTipoCtto.value
		 	URL =URL+ "&CmbAdmCtto="+f.CmbAdmCtto.value+"&CmbAdmContratista="+f.CmbAdmContratista.value+"&CmbMoneda="+f.CmbMoneda.value+"&Opcion="+f.Opcion.value+"&CmbTipoCttoPers="+f.CmbTipoCttoPers.value
			//URL = "sget_ingreso_administradores.php?Opc=A";
			window.open(URL,"","top=30,left=30,width=660,height=300,menubar=no,status=1,resizable=yes,scrollbars=yes");
		break;
		case "Ctta":	
			var	URL = "sget_ingreso_administradores.php?Opc=B&TxtContrato="+f.TxtContrato.value+"&TxtDescripcion="+f.TxtDescripcion.value+"&CmbGerencias="+f.CmbGerencias.value+"&CmbAreas="+f.CmbAreas.value+"&CmbMoneda="+f.CmbMoneda.value+"&CmbEmpresa="+f.CmbEmpresa.value+"&CmbTipoCttoPers="+f.CmbTipoCttoPers.value
		 	URL =URL+ "&TxtMontoCtto="+f.TxtMontoCtto.value+"&TxtFechaInicio="+f.TxtFechaInicio.value+"&TxtFechaTermino="+f.TxtFechaTermino.value+"&CmbTipoCtto="+f.CmbTipoCtto.value
			URL =URL+ "&CmbAdmCtto="+f.CmbAdmCtto.value+"&CmbAdmContratista="+f.CmbAdmContratista.value+"&Opcion="+f.Opcion.value
			//var	URL = "sget_ingreso_administradores.php?Opc=B";
			window.open(URL,"","top=30,left=30,width=660,height=300,menubar=no,status=1,resizable=yes,scrollbars=yes");
		break;
		case "Prev":	
			var	URL = "sget_mantenedor_prevencionista_proceso.php?Opc=N&Volver=S&CmbPrevencionista="+f.CmbPrevencionista.value;		//var	URL = "sget_ingreso_administradores.php?Opc=B";
			window.open(URL,"","top=30,left=30,width=800,height=500,menubar=no,status=1,resizable=yes,scrollbars=yes");
		break;
		case "Emp":	
			var	URL = "sget_mantenedor_empresas_proceso.php?Volver=S&RutReq="+f.CmbEmpresa.value+"&Form="+f.name+"&Pagina=sget_mantenedor_contratos_proceso.php";		
			window.open(URL,"","top=30,left=30,width=800,height=500,menubar=no,status=1,resizable=yes,scrollbars=yes");;
		break;

		case "Clas":	
			var	URL = "sget_mantenedor_clasificacion_proceso.php?Opc=N&Volver=S"; 			// &CmbPrevencionista="+f.CmbPrevencionista.value;		
			window.open(URL,"","top=30,left=30,width=800,height=300,menubar=no,status=1,resizable=yes,scrollbars=yes");
		break;
		
		
		
		
		
		case "R":	
			f.action = "sget_mantenedor_contratos_proceso.php?Recarga=S";
			f.submit();
		break;
		Recarga
	}
}
function Salir()
{
	
	var f= document.FrmPopupUsuario;
	if (f.Opcion.value == 'M')
	{
		var Ctto = f.TxtContrato.value;
		var Descripcion = f.TxtDescripcion.value;
		var Empresa = f.CmbEmpresa.value;
		var TxtContrato = f.TxtContrato.value;
		window.opener.document.frmPrincipal.action='sget_mantenedor_contratos.php?Buscar=S&TxtContrato2='+TxtContrato+'&TxtDescripcion2='+Descripcion+'&CmbEmpresa2='+Empresa;
		window.opener.document.frmPrincipal.submit();  		
		window.close();
	}				
	else
	{
		window.close();
	}	
}
function TeclaPulsada1(tecla) 
{ 
	var Frm=document.FrmPopupUsuario;
	var teclaCodigo = event.keyCode; 


		if ((teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
			   		event.keyCode=46;
			   }		
			}   
		}
		
} 
function ValidaCampo()
{
	var f= document.FrmPopupUsuario;
	var Res=true;
	if(f.CmbMoneda.value=='-1')
	{
		alert("Debe seleccionar Tipo Moneda ");
		f.CmbMoneda.focus();
		Res=false;
		return;
	}
	
	if(f.CmbTipoModificacion.value=='1')
	{
		
		if(f.TxtFechaModCtto.value=='')
		{	
			alert("Debe Ingresar Fecha Modificaci�n Contrato");
			f.TxtFechaModCtto.focus();
			Res=false;
			return;
		}
			if(f.TxtMontoModCtto.value=='')
		{	
			alert("Debe Ingresar Monto Modificaci�n Contrato");
			f.TxtMontoModCtto.focus();
			Res=false;
			return;
		}
	}
	if(f.CmbTipoModificacion.value=='2')
	{
		if(f.TxtFechaModCtto.value=='')
		{	
			alert("Debe Ingresar Fecha Modificaci�n Contrato");
			f.TxtFechaModCtto.focus();
			Res=false;
			return;
		}
	}
	if(f.CmbTipoModificacion.value=='3')
	{
		if(f.TxtMontoModCtto.value=='')
		{	
			alert("Debe Ingresar Fecha Modificaci�n Contrato");
			f.TxtMontoModCtto.focus();
			Res=false;
			return;
		}
	}
	return(Res);
}

function ValidaCampos()
{
	var f= document.FrmPopupUsuario;
	var Res=true;
	if (f.TxtContrato.value=="")
	{
		alert("Debe Ingresar Contrato");
		f.TxtContrato.focus();
		Res=false;
		return;
	}
	if (f.TxtDescripcion.value=="")
	{
		alert("Debe Ingresar Descripci�n");
		f.TxtDescripcion.focus();
		Res=false;
		return;
	}
	if(f.CmbFacturacion.value=='-1')
	{
		alert('Debe Seleccionar Periodo Facturaci�n');
		f.CmbFacturacion.focus();
		return;
	}
/*	if(f.CmbAreas.value=='-1')
	{
		alert('Debe Seleccionar Area');
		f.CmbAreas.focus();
		return;
	}*/
	if (f.TxtMontoCtto.value=="")
	{
		alert("Debe Ingresar Monto Contrato");
		f.TxtMontoCtto.focus();
		Res=false;
		return;
	}
	if(f.CmbMoneda.value=='-1')
	{
		alert("Debe seleccionar Tipo Moneda ");
		f.CmbMoneda.focus();
		Res=false;
		return;
	}
	
	
		if(f.CmbFacturacion.value=='-1')
	{
		alert("Debe seleccionar Periodo Facturaci�n ");
		f.CmbFacturacion.focus();
		Res=false;
		return;
	}
	if (f.CmbEmpresa.value=="-1")
	{
		alert("Debe Seleccionar Empresa");
		f.CmbEmpresa.focus();
		Res=false;
		return;
	}
	if (f.TxtFechaInicio.value=="")
	{
		alert("Debe Ingresar Fecha Inicio");
		f.TxtFechaInicio.focus();
		Res=false;
		return;
	}
	if (f.TxtFechaTermino.value=="")
	{
		alert("Debe Ingresar Fecha Termino");
		f.TxtFechaTermino.focus();
		Res=false;
		return;
	}
	if (f.CmbTipoCtto.value=="-1")
	{
		alert("Debe Ingresar Tipo Contrato");
		f.CmbTipoCtto.focus();
		Res=false;
		return;
	}
	if (f.CmbAdmCtto.value=="-1")
	{
		alert("Debe Ingresar Adm. Contrato");
		f.CmbAdmCtto.focus();
		Res=false;
		return;
	}
	if (f.CmbAdmContratista.value=="-1")
	{
		alert("Debe Ingresar Adm. Contratista");
		f.CmbAdmContratista.focus();
		Res=false;
		return;
	}
	if (f.CmbAvisoVenc.value=="-1")
	{
		alert("Debe Seleccionar Aviso Vencimiento de Contrato");
		f.CmbAvisoVenc.focus();
		Res=false;
		return;
	}
	if(f.Postegar.checked==true && f.TxtFechaPosterga.value=='')
	{
		alert('Debe Ingresar Fecha Posterga')
		f.TxtFechaPosterga.focus();
		Res=false;
		return;
	}
	return(Res);
}
function ElimDetMod(num)
{	
	var f=document.FrmPopupUsuario;
	if (confirm("�Desea Eliminar la Modificaci�n de Contrato"))
	{
		f.Opcion.value='EMC';
		f.action = "sget_mantenedor_contratos01.php?num="+num;
		f.submit();
	}
}
function ElimReajCtto(num)
{	
	var f=document.FrmPopupUsuario;
	if (confirm("�Desea Eliminar Reajuste de Contrato"))
	{
		f.Opcion.value='ERC';
		f.action = "sget_mantenedor_contratos01.php?Corr="+num;
		f.submit();
	}
}
function ElimReajSueldo(num)
{	
	var f=document.FrmPopupUsuario;
	if (confirm("�Desea Eliminar Reajuste de Sueldos Trabajadores"))
	{
		f.Opcion.value='ERS';
		f.action = "sget_mantenedor_contratos01.php?Corr="+num;
		f.submit();
	}
}
function ModDetMod(num)
{
	var f=document.FrmPopupUsuario;
	f.OpMC.value='MMC';
	f.action = "sget_mantenedor_contratos_proceso.php?Opcion=M&OpMC=MMC&Clave="+num;
	f.submit();
}


</script>

<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #F9F9F9;
}
-->
</style></head>

<?

/*if ($Opcion=='N')
{
	echo '<body onLoad="document.FrmPopupUsuario.TxtContrato.focus();">';
}
else if ($Opcion=="M")
{ 
	if ($NewOpc=="S")
		echo '<body onLoad="document.FrmPopupUsuario.TxtContrato.focus();">';
	else
		echo '<body onLoad="document.FrmPopupUsuario.TxtDescripcion.focus();">';
}*/
?>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>

<?
/*el archivo del calendario esta en src="archivos/popcjs.htm para cambiar la cantidad de años 
write("&nbsp;<SELECT style='font-size=11px;font-family=Verdana' name='tbSelYear' onChange='fUpdateCal(tbSelYear.value, tbSelMonth.value)'>");
 aqui cambiar el for  for(i=(giYear-4);i<=(giYear+10);i++)*/

?>
<form name="FrmPopupUsuario" method="post" action="" onClick="Reajuste('')">
  <input type="hidden" name="Opcion" value="<? echo $Opcion;?>">
  <input name="NewOpc" type="hidden" value="<? echo $NewOpc; ?>">
  <input name="ContAnt" type="hidden" value="<? echo $ContAnt; ?>"> 
 <input name="Form" type="hidden" value="<? echo $Form; ?>">
<input name="Pagina" type="hidden" value="<? echo $Pagina; ?>">
<input name="Contrato" type="hidden" value="<? echo $Contrato; ?>">

  <table align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="955" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2x.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opcion=='N'){?><img src="archivos/sub_tit_ctto_n.png"><? }else{?><img src="archivos/sub_tit_ctto_m.png"><? }?></td>
            <td align="right"><a href="JavaScript:Proceso('<? echo $Opcion;?>')"><img src="archivos/btn_guardar.png" alt="Guardar" width="24" height="22"  border="0" align="absmiddle" /></a> 
              <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> 
            </td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="ColorTabla02" >
         <tr>
           <td class="formulario2">Nro.Contrato </td>
           <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
                  <td colspan="3" class="FilaAbeja2"> 
                    <?
				//	echo "WWWW".$Opcion;
			 if ($Opcion=='N')
			 {
			 	echo "<input name='TxtContrato' type='text'   value='".$TxtContrato."' size='20' maxlength='20' onblur='BuscarEnSGC()'>";//Numerico,Decimales,formulario2,Salto
			 ?>
                    <span class="InputRojo">(*)</span> 
             <?
			 }
				// echo "TTT".$Opcion."--".$NewOpc;
			if ($Opcion == 'M')
			{
				if ($NewOpc != 'S')
				{
					echo '<input name="TxtContrato" type="text"   readonly  value="'.$TxtContrato.'" size="20" maxlength="20">';
				}	
				else
				{
					$TxtContrato = '';
			 		echo '<input name="TxtContrato" type="text"  value="'.$TxtContrato.'" size="20" maxlength="20">';
				}
			?>
				&nbsp;&nbsp;&nbsp;<input name="ModCont" type="button"  value="Mod.Cont" onClick="ModificaCont()" > 
			<?
			}
			 ?>                </tr>
         <tr>
           <td width="180" class="formulario2">Descripci&oacute;n</td>
           <td colspan="3" class="FilaAbeja2">
		   <input name="TxtDescripcion" type="text" id="TxtDescripcion"  maxlength="200" style="width:350" value="<? echo $TxtDescripcion; ?>" >
               <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td height="33" class="formulario2">Gerencia </td>
           <td class="FilaAbeja2"><SELECT name="CmbGerencias" onChange="Proceso('R');">
               <option value="-1">Seleccionar</option>
               <?
			  $Consulta = "SELECT cod_gerencia,descrip_gerencias from sget_gerencias order by descrip_gerencias ";			
			  $Resp4=mysqli_query($link, $Consulta);
			  while ($Fila4=mysql_fetch_array($Resp4))
			  {
				if ($CmbGerencias==$Fila4["cod_gerencia"])
					echo "<option SELECTed value='".$Fila4["cod_gerencia"]."'>".$Fila4["descrip_gerencias"]."</option>\n";
				else
					echo "<option value='".$Fila4["cod_gerencia"]."'>".$Fila4["descrip_gerencias"]."</option>\n";
			  }
			 ?>
           </SELECT></td>
           <td colspan="2" class="FilaAbeja2" >Areas&nbsp;&nbsp;
               <SELECT name="CmbAreas" >
                 <option value="-1" >Seleccionar</option>
                 <?
			  $Consulta = "SELECT cod_area,descrip_area,cod_cc from sget_areas where cod_gerencia=".$CmbGerencias." order by descrip_area,cod_cc ";			
			  $Resp4=mysqli_query($link, $Consulta);
			  while ($Fila4=mysql_fetch_array($Resp4))
			  {
				if ($CmbAreas==$Fila4["cod_area"])
																							//'".strtoupper($TxtNom)."'						
					echo "<option SELECTed value='".$Fila4["cod_area"]."'>".$Fila4["cod_cc"]." - ".strtoupper($Fila4["descrip_area"])."</option>\n";
				else
					echo "<option value='".$Fila4["cod_area"]."'>".$Fila4["cod_cc"]." - ".strtoupper($Fila4["descrip_area"])."</option>\n";
			  }
			 ?>
             </SELECT></td>
         </tr>
         <tr>
           <td height="25" class="formulario2">Monto&nbsp;Contrato </td>
           <td colspan="3" class="FilaAbeja2"><input name="TxtMontoCtto" type="text" id="TxtMontoCtto" maxlength="20" size="20"  class="InputIzq" value="<? echo  number_format($TxtMontoCtto,0,'','.'); ?>"    onkeydown="TeclaPulsada1()" onKeyUp="PoneMiles(this,this.value.charAt(this.value.length-1))">
                    &nbsp; <SELECT name="CmbMoneda" id="CmbMoneda" >
                      <option value="-1" class="NoSelec">Seleccionar</option>
                      <?
	  	$Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30002' ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbMoneda==$FilaTC["cod_subclase"])
				echo "<option SELECTed value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
                    </SELECT>
					
					
                    <span class="InputRojo">(*)</span> Periodo de Facturaci&oacute;n 
                    <SELECT name="CmbFacturacion" id="CmbFacturacion" >
					  <option value="-1" class="NoSelec">Seleccionar</option>
					  
                      <?
	 		$Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase ";
	 		$Consulta.= "where cod_clase = '30019' ";	
			$RespF=mysqli_query($link, $Consulta);
			while ($FilaF=mysql_fetch_array($RespF))
			{
				if ($CmbFacturacion==$FilaF["cod_subclase"])
					echo "<option SELECTed value='".$FilaF["cod_subclase"]."'>".ucfirst($FilaF["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$FilaF["cod_subclase"]."'>".ucfirst($FilaF["nombre_subclase"])."</option>\n";
			}
			?>
                    </SELECT> <span class="InputRojo">(*)</span></td>
         </tr>
         <tr>
           <td class='formulario2'>Empresa</td>
           <td colspan="3" class="FilaAbeja2" ><input name="TxtEmpresa" type="text" id="TxtEmpresa" maxlength="20"  size="6" value="<? echo $TxtEmpresa; ?>" >
               <a href="JavaScript:Proceso('R')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>
               <SELECT name="CmbEmpresa" id="CmbEmpresa" >
                 <option value="-1" class="NoSelec">Seleccionar / Agregar</option>
                 <?
	  $Consulta = "SELECT * from sget_contratistas where estado='1' ";
	  if($TxtEmpresa!='')
	  	 $Consulta.= "and  upper(razon_social) like '%".strtoupper($TxtEmpresa)."%' ";
	 	$Consulta.= " order by razon_social ";
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if (strtoupper($CmbEmpresa)==strtoupper($FilaTC["rut_empresa"]))
				echo "<option SELECTed value='".$FilaTC["rut_empresa"]."'>".$FilaTC["rut_empresa"]." - ".ucfirst($FilaTC["razon_social"])."</option>\n";
			else
				echo "<option value='".$FilaTC["rut_empresa"]."'>".$FilaTC["rut_empresa"]." - ".ucfirst($FilaTC["razon_social"])."</option>\n";
		}
			?>
               </SELECT>               &nbsp;<a href="JavaScript:Proceso('Emp')"><img src="archivos/btn_agregar2.png" height="20" width="20" alt="Agregar "align="absmiddle" border="0"></a>
             <span class="InputRojo">(*)</span>         </tr>
         <tr>
           <td width="180"class='formulario2'>Fecha&nbsp;Inicio </td>
           <td width="387" class='FilaAbeja2' ><input name="TxtFechaInicio" type="text" readonly   size="10" value="<? echo $TxtFechaInicio; ?>" >
             &nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaInicio,TxtFechaInicio,popCal);return false"> <span class="InputRojo">(*)</span>
           <td width="223" class='FilaAbeja2' >Fecha&nbsp;Termino     
           <td width="239" class="FilaAbeja2"><input name="TxtFechaTermino" type="text" readonly   size="10"  value="<? echo $TxtFechaTermino; ?>" >
             &nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaTermino,TxtFechaTermino,popCal);return false"> <span class="InputRojo">(*)</span> </tr>
         <tr>
           <td height="25" class="formulario2">Tipo Contrato </td>
           <td class="FilaAbeja2"><SELECT name="CmbTipoCtto" id="CmbTipoCtto"   onchange="Proceso('R');" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
		 $Consulta = "SELECT * from sget_tipo_contrato ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoCtto==$FilaTC["cod_tipo_contrato"])
				echo "<option SELECTed value='".$FilaTC["cod_tipo_contrato"]."'>".ucfirst($FilaTC["descrip_tipo_contrato"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_tipo_contrato"]."'>".ucfirst($FilaTC["descrip_tipo_contrato"])."</option>\n";
		}
			?>
             </SELECT>
               <span class="InputRojo">(*)</span>
               <? 
	if($CmbTipoCtto=='P' || $CmbTipoCtto=='N' )
	{
	?>
               <SELECT name="CmbTipoCttoPers" id="CmbTipoCttoPers" >
                 <?
	 $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase ";
	if ($CmbTipoCtto=='P')
	 $Consulta.= "where cod_clase='30003' ";	
	if ($CmbTipoCtto=='N')
	 $Consulta.= "where cod_clase='30004' ";	
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoCttoPers==$FilaTC["cod_subclase"])
				echo "<option SELECTed value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
               </SELECT>
                    <? }
		else
		{
			echo "<input type='hidden' name='CmbTipoCttoPers'>";
		}
	?>                  </td>
          <td class='FilaAbeja2' >Fecha Reuni&oacute;n de Arranque</td>
				  <?
		//por pedido de usuario Gazmuri se modifica titulo de fecha vencimiento boleta garantia por Fecha Reuni�n de Arranque 03-08-2010
				  ?>
           <td class="FilaAbeja2"><input name="TxtFechaGarantia" type="text" readonly   size="10"  value="<? echo $TxtFechaGarantia; ?>" >
             &nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaGarantia,TxtFechaGarantia,popCal);return false"> </td>
         </tr>
         <tr>
                  <td height="28" class="formulario2">Adm. Codelco</td>
           <td class="FilaAbeja2"><SELECT name="CmbAdmCtto" id="CmbAdmCtto" >
               <option value="-1" class="NoSelec">Seleccionar / Agregar</option>
               <?
	  $Consulta = "SELECT * from sget_administrador_contratos order by ape_paterno ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbAdmCtto==$FilaTC["rut_adm_contrato"])
					echo "<option SELECTed value='".$FilaTC["rut_adm_contrato"]."'>".ucfirst(strtolower($FilaTC["ape_paterno"]))." ".ucfirst(strtolower($FilaTC["ape_materno"]))."  ".ucfirst(strtolower($FilaTC["nombres"]))."</option>\n";
			else
				echo "<option value='".$FilaTC["rut_adm_contrato"]."'>".ucfirst(strtolower($FilaTC["ape_paterno"]))." ".ucfirst(strtolower($FilaTC["ape_materno"]))."  ".ucfirst(strtolower($FilaTC["nombres"]))."</option>\n";
		}
			?>
             </SELECT>
               <span class="InputRojo">(*)</span>&nbsp;<a href="JavaScript:Proceso('Ctto')"><img src="archivos/btn_agregar2.png" height="20" width="20" alt="Agregar "align="absmiddle" border="0"></a></td>
           <td class="FilaAbeja2">Tipo Jornada (Prevencionista) </td>
           <td class="FilaAbeja2"><label>
             <input type="text" name="TxtJornada" value="<? echo $TxtJornada;?>" size="40" maxlength="43">
           </label></td>
         </tr>
         <tr>
           <td height="14" class="formulario2">Prevencionista</td>
           <td colspan="3" class="FilaAbeja2"><SELECT name="CmbPrevencionista" >
               <option value="-1" class="NoSelec">Seleccionar / Agregar</option>
               <?
			  
			  $Consulta = "SELECT * from sget_prevencionistas where rut_prev<>'' ";//t1 left join proyecto_modernizacion.clase t2 on t1.cod_clase=t2.cod_clase  left join proyecto_modernizacion.sub_clase t3 on t1.cod_subclase=t3.cod_subclase and t1.cod_clase=t3.cod_clase 
			  $Consulta.= " order by apellido_paterno ";	//where t2.cod_clase in ('30000','30001')		
			  $Resp4=mysqli_query($link, $Consulta);
			  while ($Fila4=mysql_fetch_array($Resp4))
			  {
				  $ConsultaPrv="SELECT count(cod_contrato) as cantContra from sget_contratos where rut_prev='".$Fila4["rut_prev"]."' and fecha_termino > '".date('Y-m-d')."'";				  	
				  $RespPrv=mysql_query($ConsultaPrv);$CantContratos=0;
				  $FilasPrv=mysql_fetch_array($RespPrv);
				  $CantContratos=$FilasPrv[cantContra];	
				  
				  $Class='';
				  if($CantContratos >= '6')
				  	$Class='class=InputRojo';
					
					if ($CmbPrevencionista==$Fila4["rut_prev"])				
					{
						//echo "<option SELECTed value='".$Fila4["rut_prev"]."' ".$Class."> ".ucfirst($Fila4["apellido_paterno"])." ".ucfirst($Fila4["nombres"])."  | ".$Fila4["nombre_clase"]."&nbsp;&nbsp;".$Fila4["nombre_subclase"]."</option>\n";
						echo "<option SELECTed value='".$Fila4["rut_prev"]."' ".$Class."> ".ucfirst($Fila4["apellido_paterno"])." ".ucfirst($Fila4["nombres"])."</option>\n";
					}
					else
					{
						echo "<option value='".$Fila4["rut_prev"]."' ".$Class."> ".ucfirst($Fila4["apellido_paterno"])."  ".ucfirst($Fila4["nombres"])."</option>\n";
					}	
			  }
			 ?>
             </SELECT>
             &nbsp;<a href="JavaScript:Proceso('Prev')"><img src="archivos/btn_agregar2.png" height="20" width="20" alt="Agregar "align="absmiddle" border="0"></a><br><span class='InputRojo'><? echo "(en texto Rojo). Prevenc. con 6 � m�s Contratos asociados.";?></span> </td>
         </tr>
         <tr>
           <td height="14" class="formulario2">Adm. Contratista </td>
           <td class="FilaAbeja2"><SELECT name="CmbAdmContratista" id="CmbAdmContratista" >
               <option value="-1" class="NoSelec">Seleccionar / Agregar</option>
               <?
	   $Consulta = "SELECT * from sget_administrador_contratistas order by ape_paterno ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbAdmContratista==$FilaTC["rut_adm_contratista"])
				echo "<option SELECTed value='".$FilaTC["rut_adm_contratista"]."'>".ucfirst(strtolower($FilaTC["ape_paterno"]))." ".ucfirst(strtolower($FilaTC["ape_materno"]))."  ".ucfirst(strtolower($FilaTC["nombres"]))."</option>\n";
			else
				echo "<option value='".$FilaTC["rut_adm_contratista"]."'>".ucfirst(strtolower($FilaTC["ape_paterno"]))." ".ucfirst(strtolower($FilaTC["ape_materno"]))."  ".ucfirst(strtolower($FilaTC["nombres"]))."</option>\n";
		}
			?>
             </SELECT>
               <span class="InputRojo">(*)</span>&nbsp;<a href="JavaScript:Proceso('Ctta')"><img src="archivos/btn_agregar2.png"  height="20" width="20"  alt="Agregar " align="absmiddle" border="0"></a></td>
           <td class="FilaAbeja2">Postergar Contrato </td>
           <td class="FilaAbeja2">
		   <label>
             <input type="checkbox" name="Postegar" value="checkbox" class="SinBorde" <? echo $PostergarSN;?>>
           Fecha Posterga 
           <input name="TxtFechaPosterga" type="text" readonly   size="10"  value="<? echo $TxtFechaPosterga; ?>" >
			&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaPosterga,TxtFechaPosterga,popCal);return false"> </label></td>
         </tr>
         <tr>
           <td height="14" class="formulario2">Aviso Vencimiento </td>
           <td height="14" class="formulario2"><span class="formulariosimple">
             <SELECT name="CmbAvisoVenc" >
               <option value="-1" class="NoSelec">Seleccionar</option>
               <?
	    $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30016' order by cod_subclase";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbAvisoVenc==$FilaTC["nombre_subclase"])
				echo "<option SELECTed value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])." Meses</option>\n";
			else
				echo "<option value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])." Meses</option>\n";
		}?>
             </SELECT>
             <span class="FilaAbeja2"> <span class="InputRojo">(*)</span></span></span></td>
                  <td height="14" class="formulario2">Seguro Salud Compl. N&ordm; Poliza</td>
           <td height="14" class="formulario2"><input name="TxtPoliza" type="text" value="<? echo $TxtPoliza;?>" size="18" maxlength="15"></td>
         </tr>
         <tr>
           <td height="14" colspan="4" align="center" class="TituloTablaVerde">Control Acuerdos Marcos </td>
           </tr>
         <tr>
           <td height="14" colspan="4" class="formulario2"><table width="100%" border="0" cellspacing="2" cellpadding="0">
             <tr>
               <td class="formulario2">Con Acuerdo Marco </td>
               <td><span class="formulariosimple">
                 <SELECT name="CmbAcuerdo" >
                   <?
					switch($CmbAcuerdo)
					{
						case "S":
							echo "<option value='S' SELECTed>Si</option>";
							echo "<option value='N' >No</option>";
							echo "<option value='E' >Ex</option>";
							echo "<option value='T' >Todos</option>";
							break;
						case "N":
							echo "<option value='S' >Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							echo "<option value='E' >Ex</option>";
							echo "<option value='T' >Todos</option>";
							break;
							
							case "E":
							echo "<option value='S' >Si</option>";
							echo "<option value='N' >No</option>";
							echo "<option value='E' SELECTed>Ex</option>";
							echo "<option value='T' >Todos</option>";
							break;
						default:
							echo "<option value='S'>Si</option>";
							echo "<option value='N'>No</option>";
							echo "<option value='E' >Ex</option>";
							echo "<option value='T' SELECTed>Todos</option>";
							break;
					}
				   ?>
                 </SELECT>
               </span></td>
                <td class="formulario2">Clasificaci&oacute;n</td>
                        <td>
                          <SELECT name="CmbClasificacion" >
                            <?
					 		$Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase ";
	 						$Consulta.= "where cod_clase = '30020'  order by cod_subclase";	
							$RespC=mysqli_query($link, $Consulta);
							while ($FilaC=mysql_fetch_array($RespC))
							{
								if ($CmbClasificacion==$FilaC["cod_subclase"])
									echo "<option SELECTed value='".$FilaC["cod_subclase"]."'>".ucfirst($FilaC["nombre_subclase"])."</option>\n";
								else
									echo "<option value='".$FilaC["cod_subclase"]."'>".ucfirst($FilaC["nombre_subclase"])."</option>\n";
							}
				   ?>
                          </SELECT>
						  &nbsp;<a href="JavaScript:Proceso('Clas')"><img src="archivos/btn_agregar2.png" height="20" width="20" alt="Agregar "align="absmiddle" border="0"></a> </td>
               <td class="formulario2">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td width="19%" class="formulario2">Bono Anual </td>
               <td width="18%"><span class="formulariosimple">
                 <SELECT name="CmbBono" >
                   <?
					switch($CmbBono)
					{
						case "S":
							echo "<option value='S' SELECTed>Si</option>";
							echo "<option value='N' >No</option>";
							break;
						case "N":
							echo "<option value='S' >Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
						default:
							echo "<option value='S'>Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
					}
					
				   ?>
                 </SELECT>
               </span></td>
               <td width="9%" class="formulario2">Eco4</td>
               <td width="17%"><span class="formulariosimple">
                 <SELECT name="CmbEco4" >
                   <?
					switch($CmbEco4)
					{
						case "S":
							echo "<option value='S' SELECTed>Si</option>";
							echo "<option value='N'>No</option>";
							break;
						case "N":
							echo "<option value='S' >Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
						default:
							echo "<option value='S'>Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
					}
					
				   ?>
                 </SELECT>
               </span></td>
               <td width="9%" class="formulario2">Gratificaci&oacute;n</td>
               <td width="28%"><span class="formulariosimple">
                 <SELECT name="CmbGratif" >
                   <?
					switch($CmbGratif)
					{
						case "S":
							echo "<option value='S' SELECTed>Si</option>";
							echo "<option value='N'>No</option>";
							break;
						case "N":
							echo "<option value='S' >Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
						default:
							echo "<option value='S'>Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
					}
				   ?>
                 </SELECT>
               </span></td>
             </tr>
             <tr>
               <td class="formulario2">Reajustabilidad</td>
               <td><span class="formulariosimple">
                 <SELECT name="CmbReaj" >
                   <?
					switch($CmbReaj)
					{
						case "S":
							echo "<option value='S' SELECTed>Si</option>";
							echo "<option value='N' >No</option>";
							break;
						case "N":
							echo "<option value='S' >Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
						default:
							echo "<option value='S'>Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
					}
				   ?>
                 </SELECT>
               </span></td>
               <td class="formulario2">SobreTiempo</td>
               <td><span class="formulariosimple">
                 <SELECT name="CmbSobreT" >
                   <?
					switch($CmbSobreT)
					{
						case "S":
							echo "<option value='S' SELECTed>Si</option>";
							echo "<option value='N' >No</option>";
							break;
						case "N":
							echo "<option value='S' >Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
						default:
							echo "<option value='S'>Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
					}
				   ?>
                 </SELECT>
               </span></td>
               <td class="formulario2">Indemnizaci&oacute;n</td>
               <td><span class="formulariosimple">
                 <SELECT name="CmbIndem" >
                   <?
					switch($CmbIndem)
					{
						case "S":
							echo "<option value='S' SELECTed>Si</option>";
							echo "<option value='N' >No</option>";
							break;
						case "N":
							echo "<option value='S' >Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
						default:
							echo "<option value='S'>Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
					}
					
				   ?>
                 </SELECT>
               </span></td>
             </tr>
             <tr>
               <td class="formulario2">Seguro Complementario de Salud </td>
               <td><span class="formulariosimple">
                 <SELECT name="CmbSeg" >
                   <?
					switch($CmbSeg)
					{
						case "S":
							echo "<option value='S' SELECTed>Si</option>";
							echo "<option value='N' >No</option>";
							break;
						case "N":
							echo "<option value='S' >Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
						default:
							echo "<option value='S'>Si</option>";
							echo "<option value='N' SELECTed>No</option>";
							break;
					}
					
				   ?>
                 </SELECT>
               </span></td>
               <td class="formulario2">&nbsp;</td>
               <td>&nbsp;</td>
               <td class="formulario2">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
           </table></td>
           </tr>
		 
         <tr>
           <td height="14" colspan="4" class="formulario2"><span class="InputRojo">(*) Datos Obligatorios</span></td>
         </tr>
       </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   <br></td>
   <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>

<br>	 
<? if($Opcion=='M')
{
?>
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="16"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1057" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="1"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td  width="16" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" >
	<tr>
	<td align="right" class="ColorTabla02">
<? if($Clave!='')
	$Num=$Clave;
	if($OpMC=='MMC')
	{
		$Consulta="Select * from sget_modificaciones_contrato ";
		$Consulta.=" where cod_contrato='".$TxtContrato."' and num_modificacion='".$Clave."' ";
		$RespModDet=mysqli_query($link, $Consulta);
			if($FilaModDet=mysql_fetch_array($RespModDet))
			{
			$CmbTipoModificacion=$FilaModDet[cod_tipo_modificacion];
			$TxtFechaModCtto=$FilaModDet["fecha"];
			$TxtMontoModCtto=$FilaModDet[monto];
			$Obs=$FilaModDet["observacion"];
			}
	}
	else
		$OpMC='GMC';
?>
   <input type="hidden" name="Num" value="<? echo $Num;?>">
     <input type="hidden" name="OpMC" value="<? echo $OpMC;?>">
	  <a href="JavaScript:Proceso('<? echo $OpMC;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a>&nbsp;	

</tr>
	<tr>
		<td class="TituloTablaVerde" align="center">Modificaciones Contrato </td>
	</tr>
</table>
    <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
      <tr>
        <td width="30"   colspan="2" class='formulario2'>Tipo&nbsp;Modificaci�n </td>
        <td width="20" class="formulario2"  ><SELECT name="CmbTipoModificacion" id="CmbTipoModificacion" onChange="Recarga('<? echo $CmbTipoModificacion;?>')" >
            <?
	  $Consulta = "SELECT * from sget_tipo_modificacion  ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoModificacion==$FilaTC["cod_tipo_modificacion"])
				echo "<option SELECTed value='".$FilaTC["cod_tipo_modificacion"]."'>".ucfirst($FilaTC["descrip_modificacion"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_tipo_modificacion"]."'>".ucfirst($FilaTC["descrip_modificacion"])."</option>\n";
		}
			?>
          </SELECT>
            <? 
	if($CmbTipoModificacion=='2')  
	{
		?>
        <td width="20" class='formulario2' >Fecha </td>
        <td colspan="3" class="formulario2"><input name="TxtFechaModCtto" type="text" readonly   size="10" value="<? echo $TxtFechaModCtto; ?>" >
            <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaModCtto,TxtFechaModCtto,popCal);return false"> <span class="FilaAbeja2"> <span class="InputRojo">(*)</span></span></td>
        <? 
	}
	if($CmbTipoModificacion=='3')  
	{
	?>
        <td width="20" class='formulario2' >Monto </td>
        <td colspan="3" class='formulario2'><input name="TxtMontoModCtto" type="text" id="TxtMontoModCtto" maxlength="20" size="20" value="<? echo  number_format($TxtMontoModCtto,0,'',''); ?>"  class="InputIzq"  onKeyDown="TeclaPulsada1()"><span class="InputRojo">(*)</span></td>
        <? 
	}
	if($CmbTipoModificacion=='1')
	{
	?>
        <td width="20" class='formulario2' >Fecha </td>
        <td class="formulario2"  ><input name="TxtFechaModCtto" type="text" readonly   size="10" value="<? echo $TxtFechaModCtto; ?>" >
            <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaModCtto,TxtFechaModCtto,popCal);return false"> <span class="FilaAbeja2"> <span class="InputRojo">(*)</span></span></td>
        <td width="20" class='formulario2'>Monto </td>
        <td class='formulario2'><input name="TxtMontoModCtto" type="text" id="TxtMontoModCtto" maxlength="20" size="20" value="<? echo  number_format($TxtMontoModCtto,0,'',''); ?>"  class="InputIzq"  onKeyDown="TeclaPulsada1()"><span class="InputRojo">(*)</span>        </td>
        <?
	}
?>
      <tr>
        <td  width="30"  colspan="2" class='formulario2'>Observaci&oacute;n</td>
        <td colspan="5" class="formulario2"><textarea name="Obs" cols="90" rows="2" wrap="VIRTUAL"  ><? echo $Obs;?></textarea>        </td>
      </tr>
      <? 	$Contador=0;	$encontro="N";
 	$Consulta=" SELECT * from sget_modificaciones_contrato t1 left join sget_tipo_modificacion t2 on t1.cod_tipo_modificacion=t2.cod_tipo_modificacion";
	$Consulta.="  where t1.cod_contrato ='".$TxtContrato."'";
 	$RespModificaciones=mysqli_query($link, $Consulta);
	while($FilaModificaciones=mysql_fetch_array($RespModificaciones))
	{
		$Contador=$Contador+1;
		if($Contador==1)
		{		?>
		  <tr> 
	  <td colspan="7">
      <table width="100%" align="center" cellpadding="0" border="1" cellspacing="0">
        <tr>
          <td class="TituloTablaVerde" colspan="7" align="center">Modificaciones Ingresadas </td>
        </tr>
        <tr><td width="45" align="center" class="TituloCabecera">E/M</td>
          <td align="center" class="TituloCabecera">Tipo</td>
          <td width="78" align="center" class="TituloCabecera">Fecha</td>
          <td width="59" align="center" class="TituloCabecera">Monto</td>
          <td width="178" colspan="3"align="center" class="TituloCabecera">Observaci�n</td>
        </tr>
        <? 
		}?>
        <tr>
          <td width="45" ><? echo $Contador;?>&nbsp;<a href="JavaScript:ElimDetMod('<? echo $FilaModificaciones[num_modificacion];?>')"><img src="archivos/elim_hito.png"  alt="Eliminar " height="15" width="15" align="absmiddle" border="0"></a><a href="JavaScript:ModDetMod('<? echo $FilaModificaciones[num_modificacion];?>')"><img src="archivos/btn_modificar.png"  alt="Modificar " height="15" width="15"  align="absmiddle" border="0"></a>                 </td>
          <td > <? echo $FilaModificaciones[descrip_modificacion];?></td>
          <td  align="center"><? 
			if($FilaModificaciones["fecha"]=='0000-00-00')
				$fecha='';
			else
				$fecha=$FilaModificaciones["fecha"];	
			echo $fecha;?>
            &nbsp;</td>
          <td align="right" ><? echo number_format($FilaModificaciones[monto],0,'','.');?>&nbsp;</td>
          <td colspan="3" align="center"><textarea cols="90" rows="2" readonly="readonly"><? echo $FilaModificaciones["observacion"];?>&nbsp;</textarea></td>
        </tr>
        <?
	$encontro="S";
	}
	if(	$encontro=="S")
	{
	?>
      </table>
     </td>
	 </tr> <?
	}
	?>
    </table></td>
   <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="16" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td width="1057" height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>	
  
<? 
}
?><br>
<? if($Opcion=='M')
{
?>
		<table width="90%"  border="0" align="center" cellpadding="0"  cellspacing="0" class="ColorTabla02">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1056" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
			<td class="TituloTablaVerde" colspan="4" align="center">Relaci&oacute;n Empresas SubContratistas </td>
		</tr>
		 <tr>
				<td width="161" class='formulario2'>Empresa&nbsp;SubContratista </td>
				<td width="650" class="formulario2"  > <input name="TxtEmpresa2" type="text" id="TxtEmpresa2" maxlength="20"  size="6" value="<? echo $TxtEmpresa2; ?>" >
				<a href="JavaScript:Proceso('R')"><img src="archivos/Find2.png"   alt="Buscar" width="29" height="25"  border="0" align="absmiddle" /></a>
	<SELECT name="CmbSubEmpresa" id="CmbSubEmpresa" >
		  <option value="-1" class="NoSelec">Seleccionar</option>
		  <?
		  $Consulta = "SELECT * from sget_contratistas where rut_empresa <> '".$CmbEmpresa."' ";
		  if($TxtEmpresa2!='')
			 $Consulta.= " and upper(razon_social) like '%".strtoupper($TxtEmpresa2)."%'";
		  $Consulta.= " order by razon_social";	
		  $Resp=mysqli_query($link, $Consulta);
		  while ($FilaTC=mysql_fetch_array($Resp))
		  {
				if ($CmbSubEmpresa==$FilaTC["rut_empresa"])
					echo "<option SELECTed value='".$FilaTC["rut_empresa"]."'>".$FilaTC["rut_empresa"]." - ".substr(ucfirst($FilaTC["razon_social"]),0,60)."</option>\n";
				else
					echo "<option value='".$FilaTC["rut_empresa"]."'>".$FilaTC["rut_empresa"]." - ".substr(ucfirst($FilaTC["razon_social"]),0,60)."</option>\n";
		  }
		  ?>
		</SELECT><span class="InputRojo">(*)</span>  
        <td width="107" class='formulario2' >Reuni&oacute;n Arranque </td>
        <td width="190" class="formulario2"><input name="TxtReunnionASUB" type="text" readonly   size="10" value="<? echo $TxtReunnionASUB; ?>" >
            <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtReunnionASUB,TxtReunnionASUB,popCal);return false"> <span class="FilaAbeja2"> <span class="InputRojo">(*)</span></span>
		 <a href="JavaScript:Agregar('EmpSub','G')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a>			  </td>
		</tr>
          <tr><td colspan="4">

  <? 	$Contador=0;	$encontro="N";
 	$Consulta=" SELECT t1.*,t2.razon_social from sget_sub_contratistas t1 left join sget_contratistas t2 on t1.rut_empresa=t2.rut_empresa";
	$Consulta.="  where t1.cod_contrato ='".$TxtContrato."'";
 	
	$RespModificaciones=mysqli_query($link, $Consulta);
	while($FilaModificaciones=mysql_fetch_array($RespModificaciones))
	{
	$Contador=$Contador+1;
		$Nom='F'.$Contador;
		if($Contador==1)
		{ ?>
		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
		<td   align="center" class="TituloCabecera">Info.Ctto.</td>
		<td   align="center" class="TituloCabecera">Rut Empresa</td>
		<td   align="center" class="TituloCabecera">Raz�n Social</td>
		<td   align="center" class="TituloCabecera">Reuni&oacute;n Arranque</td>
		<td width="3%"   align="center" class="TituloCabecera">Elim.</td>
        </tr>
		<? }?>
        <tr>
		 <td width="5%" colspan="1"  align="center"><a  href="sget_info_ctto_ac.php?Ctto=<? echo $FilaModificaciones["cod_contrato"];?>&Emp=<? echo $FilaModificaciones[rut_empresa];?>"  target="_blank"><img src="archivos/info2.png"   alt="Detalle Contrato  y Personal"  border="0" align="absmiddle" /></a></td>
		 <td width="11%" colspan="1"  align="center"><? echo $FilaModificaciones[rut_empresa];?>&nbsp;</td>
          <td width="65%" colspan="1"  align="left"><? echo $FilaModificaciones[razon_social];?>&nbsp;</td>
          <td width="16%" colspan="1"  align="center"><input name="<? echo $Nom;?>" type="text" readonly   size="10" value="<? echo $FilaModificaciones[reunion_arranque]; ?>" >
		  <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(<? echo $Nom;?>,<? echo $Nom;?>,popCal);return false">&nbsp;<a href="JavaScript:ModSub('<? echo $FilaModificaciones[rut_empresa]."~".$FilaModificaciones["cod_contrato"];?>','<? echo $Nom?>')"><img src="archivos/btn_modificar2.png" width="20" height="20" border="0" alt="Modifica Fecha Reunion Arranque"></a></td>
		  <td width="3%" colspan="1"  align="center">
		  <a href="JavaScript:Eliminar('<? echo $FilaModificaciones[rut_empresa];?>')"><img src="archivos/elim_hito.png"  alt="Eliminar Relaci&oacute;n Empresa Sub-Contratista" align="absmiddle" border="0"></a>&nbsp;		</td>
 </tr>
        <?
	$Entro='S';
	}
	if($Entro=='S')
	{ 
	?>
	 </table></td></tr> <? 
	
	}
	?>
  
  </table>
</td>
  <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
  <br>
  <table width="90%"  border="0" align="center" cellpadding="0"  cellspacing="0" class="ColorTabla02">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1056" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
			<td class="TituloTablaVerde" colspan="2" align="center">Fecha Reajustabilidad Monto Contrato</td>
		</tr>
		 <tr>
				<td width="22%" class='formulario2'>&nbsp;</td>
				<td width="78%" class="formulario2"  ><span class="InputRojo"><span class="formulario2">Fecha Reajustabilidad</span>
				  <input name="TxtFechaReajuste" type="text" readonly   size="10"  value="<? echo $TxtFechaReajuste; ?>" >
                  <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaReajuste,TxtFechaReajuste,popCal);return false">
                  <span class="formulario2">Periodo</span>&nbsp;<SELECT name="CmbReajuste">
				  <option value="-1" class="NoSelec">Seleccionar</option>
				  <?
				  $Consulta = "SELECT cod_subclase,nombre_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='30006' ";			
					$Resp=mysqli_query($link, $Consulta);
					while ($FilaTC=mysql_fetch_array($Resp))
					{
						if ($CmbReajuste==$FilaTC["cod_subclase"])
							echo "<option SELECTed value='".$FilaTC["valor_subclase1"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
						else
							echo "<option value='".$FilaTC["valor_subclase1"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					}
						?>
                  </SELECT>
            (*)&nbsp;&nbsp;&nbsp;</span> <a href="JavaScript:Agregar('ReajCtto')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> </td>
		</tr>
          <tr><td colspan="2">

  <? 
    $Contador=0;$encontro="N";$Entro='N';
 	$Consulta="SELECT t1.corr,t1.fecha_reajuste,t2.nombre_subclase as periodo,t1.fecha_reajustada,t1.monto,t1.monto_reajustado,t3.nombre_subclase as cambio,t1.estado from sget_reajustes_contratos t1 left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='30006' and t1.tipo_reajuste=t2.valor_subclase1 ";
	$Consulta.="left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='30002' and t1.tipo_cambio=t3.cod_subclase where t1.tipo='C' and t1.cod_contrato ='".$TxtContrato."' order by t1.fecha_reajuste";
	//echo $Consulta;
	$RespReaj=mysqli_query($link, $Consulta);
	while($FilaReaj=mysql_fetch_array($RespReaj))
	{
	    $Contador=$Contador+1;
		if($Contador==1)
		{ ?>
		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
		<td width="5%" align="center" class="TituloCabecera">Elim.</td>
		<td width="20%" align="center" class="TituloCabecera">Fecha Reajustibilidad</td>
		<td width="15%" align="center" class="TituloCabecera">Periodo</td>
		<td width="20%" align="center" class="TituloCabecera">Fecha Real Reajuste</td>
		<td width="15%" align="center" class="TituloCabecera">Monto</td>
		<td width="20%" align="center" class="TituloCabecera">Monto Reajustado</td>
		<td width="15%" align="center" class="TituloCabecera">Cambio</td>
		<td width="15%" align="center" class="TituloCabecera">Estado</td>
        </tr>
		<? }?>
        <tr>
		  <td align="center">
		  <? 
			if($FilaReaj["estado"]!='L')
			{	
		  ?>	
		  <a href="JavaScript:ElimReajCtto('<? echo $FilaReaj["corr"];?>')"><img src="archivos/elim_hito.png"  alt="Eliminar " align="absmiddle" border="0" width='15' height='15'></a>&nbsp;
		  	<? }
				else
				echo "&nbsp;";
			 ?>
		  </td>
		  <td align="center"><? echo $FilaReaj[fecha_reajuste];?>&nbsp;</td>
          <td align="center"><? echo $FilaReaj[periodo];?>&nbsp;	  
		  </td>
		  <td align="center"><? echo $FilaReaj[fecha_reajustada];?>&nbsp;</td>
		  <td align="center"><? echo number_format($FilaReaj[monto],0,'','.');?>&nbsp;</td>
		  <td align="center"><? echo number_format($FilaReaj[monto_reajustado],0,'','.');?>&nbsp;</td>
		  <td align="center"><? echo $FilaReaj[cambio];?>&nbsp;</td>
		  <td align="center">
		  <? 
			if($FilaReaj["estado"]=='L')	
				echo "<img src='archivos/btn_activo.png'   border='0' align='absmiddle' width='15' height='15'>";
			else
				echo "<img src='archivos/btn_inactivo.png'   border='0' align='absmiddle' width='15' height='15'>";
			
		  ?>&nbsp;</td>
        </tr>
        <?
	    $Entro='S';
	}
	if($Entro=='S')
	{ 
	?>
	 </table></td></tr> <? 
	
	}
	?>
  
  </table>
</td>
  <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table><br>
 <table width="90%"  border="0" align="center" cellpadding="0"  cellspacing="0" class="ColorTabla02">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1056" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
			<td class="TituloTablaVerde" colspan="2" align="center">Fecha Reajustabilidad Monto Sueldos</td>
		</tr>
		 <tr>
				<td width="22%" class='formulario2'>&nbsp;</td>
				<td width="78%" class="formulario2"  ><span class="InputRojo"><span class="formulario2">Fecha Reajustabilidad</span>
				  <input name="TxtFechaReajuste2" type="text" readonly   size="10"  value="<? echo $TxtFechaReajuste2; ?>" >
                  <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaReajuste2,TxtFechaReajuste2,popCal);return false">
                  <span class="formulario2">Periodo</span>&nbsp;<SELECT name="CmbReajuste2">
                    <option value="-1" class="NoSelec">Seleccionar</option>
                    <?
				  $Consulta = "SELECT cod_subclase,nombre_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='30006' ";			
					$Resp=mysqli_query($link, $Consulta);
					while ($FilaTC=mysql_fetch_array($Resp))
					{
						if ($CmbReajuste2==$FilaTC["cod_subclase"])
							echo "<option SELECTed value='".$FilaTC["valor_subclase1"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
						else
							echo "<option value='".$FilaTC["valor_subclase1"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
					}
						?>
                  </SELECT>
            (*)&nbsp;&nbsp;&nbsp;</span><a href="JavaScript:Agregar('ReajSueldo')"><img src="archivos/btn_agregar2.png" alt="Agregar" width="25" height="25"  border="0" align="absmiddle" /></a> </td>
		</tr>
          <tr><td colspan="2">

  <? 
    $Contador=0;$encontro="N";$Entro='N';
 	$Consulta="SELECT t1.corr,t1.fecha_reajuste,t2.nombre_subclase as periodo,t1.fecha_reajustada,t1.monto,t1.monto_reajustado,t3.nombre_subclase as cambio,t1.estado from sget_reajustes_contratos t1 left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='30006' and t1.tipo_reajuste=t2.valor_subclase1 ";
	$Consulta.="left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='30002' and t1.tipo_cambio=t3.cod_subclase where t1.tipo='S' and t1.cod_contrato ='".$TxtContrato."' order by t1.fecha_reajuste";
	//echo $Consulta;
	$RespReaj=mysqli_query($link, $Consulta);
	while($FilaReaj=mysql_fetch_array($RespReaj))
	{
	    $Contador=$Contador+1;
		if($Contador==1)
		{ ?>
		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
		<td width="5%" align="center" class="TituloCabecera">Elim.</td>
		<td width="20%" align="center" class="TituloCabecera">Fecha Reajustibilidad</td>
		<td width="15%" align="center" class="TituloCabecera">Periodo</td>
		<td width="20%" align="center" class="TituloCabecera">Fecha Real Reajuste</td>
		<td width="15%" align="center" class="TituloCabecera">Estado</td>
        </tr>
		<? }?>
        <tr>
		  <td align="center">
		  <? 
			if($FilaReaj["estado"]!='L')
			{	
		  ?>	
		  <a href="JavaScript:ElimReajSueldo('<? echo $FilaReaj["corr"];?>')"><img src="archivos/elim_hito.png"  alt="Eliminar " align="absmiddle" border="0" width='15' height='15'></a>&nbsp;
		  	<? }
				else
				echo "&nbsp;";
			 ?>		  </td>
		  <td align="center"><? echo $FilaReaj[fecha_reajuste];?>&nbsp;</td>
          <td align="center"><? echo $FilaReaj[periodo];?>&nbsp;		  </td>
		  <td align="center"><? echo $FilaReaj[fecha_reajustada];?>&nbsp;</td>
		  <td align="center">
		  <? 
			if($FilaReaj["estado"]=='L')	
				echo "<img src='archivos/btn_activo.png'   border='0' align='absmiddle' width='15' height='15'>";
			else
				echo "<img src='archivos/btn_inactivo.png'   border='0' align='absmiddle' width='15' height='15'>";
			
		  ?>&nbsp;</td>
        </tr>
        <?
	    $Entro='S';
	}
	if($Entro=='S')
	{ 
	?>
	 </table></td></tr> <? 
	
	}
	?>
  </table>
</td>
  <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table> 
  
  <br><? 
  	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

  ?>
<table width="90%"  border="0" align="center" cellpadding="0"  cellspacing="0" class="ColorTabla02">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1056" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
   <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" > <tr>
		  <td class="ColorTabla02" colspan="4" align="right"><a href="JavaScript:Proceso('GDF')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> </td>
		</tr>
   </table>
   <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
			<td class="TituloTablaVerde" colspan="4" align="center">Control Facturas </td>
		</tr>
		 <tr>
		   <td width="25%" class='formulario2'>A&ntilde;o</td>
		   <td width="22%" class="formulario2"  ><span class="InputRojo">
		  
	    <SELECT name="CmbAnoDF" id="CmbAnoDF" >
          <?
		for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
	{
		if (isset($CmbAnoDF))
		{
			if ($i==$CmbAnoDF)
			{
				echo "<option SELECTed value ='$i'>$i</option>";
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
				echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
				echo "<option value='".$i."'>".$i."</option>";
			}
		}
	}
		?>
        </SELECT>
		   </span></td>
	       <td width="21%" class="formulario2"  >Mes</td>
	       <td width="32%" class="formulario2"  > <SELECT name="CmbMesDF" id="CmbMesDF" >
        <?
		 for($i=1;$i<13;$i++)
		{
			if (isset($CmbMesDF))
			{
				if ($i==$CmbMesDF)
				{
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
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
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}
				else
				{
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
			}
		}
		?>
      </SELECT>  </td>
		 </tr>
		 <tr>
		   <td class='formulario2'>Nro.&nbsp;Factura </td>
		   <td class="formulario2"  >  <input name="NFactura" type="text" id="NFactura"  maxlength="100" style="width:100" value="<? echo $NFactura; ?>" ><span class="InputRojo">(*)</span>	   </td>
	       
		   	<td class="formulario2"  >Fecha&nbsp;Emisi&oacute;n&nbsp;Documento </td>
	        <td class="formulario2"  > <input name="TxtFechaEmiDoc" type="text" readonly   size="10"  value="<? echo $TxtFechaEmiDoc; ?>" >
              <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaEmiDoc,TxtFechaEmiDoc,popCal);return false">&nbsp;<span class="InputRojo">(*)</span></td>
        </tr>
		<tr>
		   <td class="formulario2"  >Fecha&nbsp;Ingreso&nbsp;Documento </td>
	       <td class="formulario2"  >
	         <input name="TxtFechaIngDoc" type="text" readonly   size="10"  value="<? echo $TxtFechaIngDoc; ?>" >
             <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIngDoc,TxtFechaIngDoc,popCal);return false">&nbsp;<span class="InputRojo">(*)</span></td>
		   <td class='formulario2'>Fecha&nbsp;Ingreso&nbsp;Contabilidad </td>
		    <td class="formulario2"  > <input name="TxtFechaIngContabilidad" type="text" readonly   size="10"  value="<? echo $TxtFechaIngContabilidad; ?>" >
              <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIngContabilidad,TxtFechaIngContabilidad,popCal);return false">&nbsp;<span class="InputRojo">(*)</span> 
            </td>
		  </tr>
		  <tr>
	       <td class="formulario2"  >Fecha&nbsp;Liberaci&oacute;n </td>
	       <td class="formulario2"  >
	         <input name="TxtFechaIngLiberacion" type="text" readonly   size="10"  value="<? echo $TxtFechaIngLiberacion; ?>" >
             <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIngLiberacion,TxtFechaIngLiberacion,popCal);return false">&nbsp;<span class="InputRojo">(*)
			 </td>
			 <td class="formulario2">Dotaci&oacute;n&nbsp;&nbsp;&nbsp;
			 <?
			$Consulta="SELECT count(rut) as Cantidad from sget_personal where cod_contrato='".$TxtContrato."' and estado='A' and tipo='1'";
			$RespCant=mysqli_query($link, $Consulta);
			if($FilaCant=mysql_fetch_array($RespCant))
			{
				$TxtDot= $FilaCant[Cantidad];
			}
			else
			{
				$TxtDot=0;
			}
			 ?>
			 <input name="TxtDot" type="text" value="<? echo $TxtDot;?>" size="1" maxlength="3" onKeyDown="TeclaPulsada(true)">&nbsp;<span class="InputRojo">(*)</span>
			 </td>
			 <td class="formulario2">Mas facturas&nbsp;&nbsp;
			 <input type="checkbox" name="OptFactura" value="checkbox" <? echo $OptFactura; ?> > </td>
		 </tr>
          <tr><td colspan="4">

  <? 
    $Contador=0;$encontro="N";$Entro='N';
 	$Consulta="SELECT * from sget_facturas_contrato where cod_contrato='".$TxtContrato."' order by ano, mes,fecha_hora";

	$RespDF=mysqli_query($link, $Consulta);
	while($FilaDF=mysql_fetch_array($RespDF))
	{
	    $Contador=$Contador+1;
		if($Contador==1)
		{ ?>
		<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
		<td width="4%" align="center" class="TituloCabecera">&nbsp;</td>
		<td width="5%" align="center" class="TituloCabecera">A&ntilde;o</td>
		<td width="7%" align="center" class="TituloCabecera">Mes</td>
		<td width="15%" align="center" class="TituloCabecera">Nro. Factura </td>
		<td width="12%" align="center" class="TituloCabecera">Dotaci&oacute;n</td>
		<td width="15%" align="center" class="TituloCabecera">Fec. Emi. Docto.</td>
		<td width="15%" align="center" class="TituloCabecera">Fec. Ing. Contabilidad</td>
		<td width="15%" align="center" class="TituloCabecera">Fec. Ing. Docto. </td>
		<td width="16%" align="center" class="TituloCabecera">Fec. Liberaci&oacute;n </td>
        </tr>
		<? }?>
        <tr>
		  <td align="center"><a href="JavaScript:ElimDF('<? echo $FilaDF["fecha_hora"];?>','<? echo $TxtContrato; ?>')"><img src="archivos/elim_hito.png"  alt="Eliminar " align="absmiddle" border="0" width='15' height='15'></a>&nbsp;</td>
		  <td align="center"><? echo $FilaDF["ano"];?></td>
		  <td align="center"><? echo $meses[($FilaDF["mes"]                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           -1)];?></td>
		  <td align="center"><? echo $FilaDF[nro_factura];?>&nbsp;</td>
          <td align="center"><? echo $FilaDF[dotacion];?>&nbsp;</td>
		  <td align="center"><? echo $FilaDF[fecha_emi_doc];?>&nbsp;</td>
		  <td align="center"><? echo $FilaDF[fecha_ing_cont];?>&nbsp;</td>
		  <td align="center"><? echo $FilaDF[fecha_ing_doc];?>&nbsp; </td>
		  <td align="center"><? echo $FilaDF[fecha_liber];?>&nbsp;</td>
        </tr>
        <?
	    $Entro='S';
	}
	if($Entro=='S')
	{ 
	?>
	 </table></td></tr> <? 
	
	}
	?>
  </table>
</td>
  <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table> 

  
<? 
}
?>

</form>		
<? 

echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Ingresado Contrato Correctamente');";
	if ($Mensaje=='2')
		echo "alert('El Contrato Se Encuentra Ingresado ');";
	if ($Mensaje=='3')
		echo "alert('El Contrato Se Modific� Correctamente');";
	if ($Mensaje=='4')
		echo "alert('Modificaci�n Ingresada Correctamente');";
	if ($Mensaje=='5')
		echo "alert(' Modificacion de Contrato Eliminada');";
	if ($Mensaje=='MSC')
		echo "alert(' Modificacion Fecha Reunion Arranque');";
	
	echo "</script>";


function sumarmeses ($fechaini, $meses)
{
 //recortamos la cadena separandola en 
 //tres variables de dia, mes y año
 $dia=substr($fechaini,0,2);
 $mes=substr($fechaini,3,2);
 $anio=substr($fechaini,6,4);
 
 //Sumamos los meses requeridos
 $tmpanio=floor($meses/12);
 $tmpmes=$meses%12;
 $anionew=$anio+$tmpanio;
 $mesnew=$mes+$tmpmes;
 
 //Comprobamos que al sumar no nos hayamos
 //pasado del año, si es as� incrementamos
 //el año
 if ($mesnew>12)
 {
  $mesnew=$mesnew-12;
  if ($mesnew<10)
   $mesnew="0".$mesnew;
  $anionew=$anionew+1;
 }
 
 //Ponemos la fecha en formato americano y la devolvemos
 $fecha=date( "Y/m/d", mktime(0,0,0,$mesnew,$dia,$anionew) );
 return $fecha;
}
//CalculaReajuste();
?>

</body>
</html>
