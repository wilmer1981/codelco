
<? include("../principal/conectar_pcip_web.php");

	switch($Opc)
	{
		case "N":
			$TxNombre='';
			$Ano=date('Y');
			$Mes=date('m');
			$CmbOrigen='-1';
			$CmbMaterial='-1';
			$CmbDiv='-1';
			$CmbDiv2='-1';
		break;
		case "M":
			if (!isset($Ptl))
				$Ptl1='CM';	
			else
				$Ptl1=$Ptl;	
			$ContVi�etas=2;
			$Consulta="select * from pcip_eva_negocios where corr='".$Cod."'";
			//echo $Consulta;
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Resp);
			$TxNombre=$Fila[nom_archivo];
			$Ano=$Fila[ano];
			$Mes=$Fila[mes];
			$CmbOrigen=$Fila[tipo_origen];
			if($Fila[tipo_origen]=='2')
				$ContVi�etas++;
			$CmbMaterial=$Fila[cod_material];
			$Mes=$Fila[mes];
			$CheckAnal_1='';$CheckAnal_2='';$CheckAnal_3='';$CmbDiv='-1';$CmbDiv2='-1';$Cont=0;
			$Datos=explode('||',$Fila["analisis"]);
			while(list($c,$v)=each($Datos))
			{
				$Datos2=explode('~',$v);
				$TipoAnalisis=$Datos2[0];
				switch($TipoAnalisis)
				{
					case "2":
						$CheckAnal_1='checked';
						$ContVi�etas++;
					break;
					case "3":
						$CheckAnal_2='checked';
						$ContVi�etas++;
					break;
					case "4":
						$Cont++;
						if($Cont==1&&$Datos2[1]!='')
						{
							$CmbDiv=$Datos2[1];
							$ContVi�etas++;
						}
						if($Cont==2&&$Datos2[1]!='')
						{
							$CmbDiv2=$Datos2[1];
							$ContVi�etas++;
						}
						$CheckAnal_3='checked';
					break;
				}
				$Div=$Datos2[1];
			}
			$TxtTMH=$Fila[tmh];
			$TxtTMS=$Fila[tms];
			$TxtHum=$Fila[porc_hum];
		break;
	
	}
	if(!isset($Ano))
	{
		$Ano=date('Y');
		$Mes=date('m');
	}		
?>
<html>
<head>
<?
	if ($Opc=='N')
		echo "<title>Nueva Evaluaci�n de Negocio</title>";
		else	
			echo "<title>Modificar Evaluaci�n de Negocio</title>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../pcip_web/estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	var Valida=true;
	var Veri="";
	var Check="";
	switch(Opcion)
	{
		case "N":	
				if(f.TxtNombre.value=='')
				{
					alert("Debe Ingresar Nombre");
					f.TxtNombre.focus();
					return;
				}	
				if(f.CmbMaterial.value=='-1')
				{
					alert("Debe Seleccionar Material");
					f.CmbMaterial.focus();
					return;
				}		
				if(f.CmbOrigen.value=='-1')
				{
					alert("Debe Seleccionar Origen");
					f.CmbOrigen.focus();
					return;
				}
				Check=false;
				if(f.OptAnalisis1.checked==true)
					Check=true;			
				if(f.OptAnalisis2.checked==true)
					Check=true;			
				if(f.OptAnalisis3.checked==true)
				{
					Check=true;
					if(f.CmbDiv.value=='-1')
					{
						alert('Debe Seleccionar Divisi�n');
						f.CmbDiv.focus();
						return;
					}	
				}
				if(Check==false)
				{
					alert('Debe Seleccionar Analisis');				
					return;
				}
				f.action= "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opcion;
				f.submit();
				break;				   							
		case "M":
				if(f.TxtNombre.value=='')
				{
					alert("Debe Ingresar Nombre");
					f.TxtNombre.focus();
					return;
				}	
				if(f.CmbMaterial.value=='-1')
				{
					alert("Debe Seleccionar Material");
					f.CmbMaterial.focus();
					return;
				}		
				if(f.CmbOrigen.value=='-1')
				{
					alert("Debe Seleccionar Origen");
					f.CmbOrigen.focus();
					return;
				}
				Check=false;
				if(f.OptAnalisis1.checked==true)
					Check=true;			
				if(f.OptAnalisis2.checked==true)
					Check=true;			
				if(f.OptAnalisis3.checked==true)
				{
					Check=true;
					if(f.CmbDiv.value=='-1')
					{
						alert('Debe Seleccionar Divisi�n');
						f.CmbDiv.focus();
						return;
					}	
				}
				if(Check==false)
				{
					alert('Debe Seleccionar Analisis');				
					return;
				}
				f.action= "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opcion;
				f.submit();
        		break;
		case "R":
				var Valores2='';
				for (i=1;i<f.elements.length;i++)
				{
					if (f.elements[i].name=="CheckTipoProc" && f.elements[i].checked==true)
					{
						Valores2 = Valores2+f.elements[i].value+"~";
					}	
				}	
		        f.action="pcip_evaluacion_negocio_proceso.php?Recarga=S&TipoProc="+Valores2;
				f.submit();
			    break;	
		case "R1":
				var Valores2='';
				for (i=1;i<f.elements.length;i++)
				{
					if (f.elements[i].name=="CheckTipoProc" && f.elements[i].checked==true)
					{
						Valores2 = Valores2+f.elements[i].value+"~";
					}	
				}	
		        f.action="pcip_evaluacion_negocio_proceso.php?Recarga=S&ValoresCadena="+Valores2;
				f.submit();
			    break;	
		case "R2":
		        f.action="pcip_evaluacion_negocio_proceso.php?Recarga=S";
				f.submit();
			    break;					
		case "NI":
				f.Opc.value='N';
			    f.action = "pcip_evaluacion_negocio_proceso.php?Opc=N";
			    f.submit();
		        break;
		case "GN"://GUARDAR COMO NUEVO;
				if(confirm('Esta Seguro de Crear Una Copia del Analisis'))
				{
					if(f.TxtNombre.value=='')
					{
						alert("Debe Ingresar Nombre");
						f.TxtNombre.focus();
						return;
					}	
					f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opcion;
					f.submit();
		        }
				break;
	}
}
function SeleccionCombo(Ptl,Pre)
{
	var f= document.FrmPopupProceso;
	f.action = "pcip_evaluacion_negocio_proceso.php?Ptl="+Ptl+"&MostrarPre="+Pre;
	f.submit();
}
function ProcesoMaterial(Opc,valor)
{
	var f= document.FrmPopupProceso;

	switch(Opc)
	{
		case "NMAT"://NUEVO MATERIAL
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "MMAT"://MODIFICAR MATERIAL TMH- TMS
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "EMAT"://ELIMINAR MATERIAL
			if(confirm('Esta Seguro de Eliminar El Registro'))
			{
				f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc+"&Valores="+valor;
				f.submit();
			}
			break;
		case "NMATCONS"://NUEVO MATERIAL CONCENTRADOS
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break; 
		case "MMATCONS"://MODIFICAR MATERIAL TMH- TMS - HUM CONCENTRADOS
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "EMATCONS"://ELIMINAR MATERIAL CONCENTRADOS
			if(confirm('Esta Seguro de Eliminar El Registro'))
			{
				f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc+"&Valores="+valor;
				f.submit();
			}
			break;

	}
}
function ProcesoVenta(Opc,valor)
{
	var f= document.FrmPopupProceso;

	switch(Opc)
	{
		case "NVEMERM"://NUEVA MERMA
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "EVEMERM"://ELIMINAR MERMA
			if(confirm('Esta Seguro de Eliminar El Registro'))
			{
				f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc+"&Valores="+valor;
				f.submit();
			}
			break;
		case "NVER"://NUEVO VENTA RECUPERACION
			if(f.CmbMaterial.value=='2')
			{
				if(f.CmbRecup.value=='3')
				{
					if(f.TxtDes.value=='')
					{
						alert("Debe Ingresar Descuento");
						f.TxtDes.focus();
						return;
					}
				}
			}
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "EVER"://ELIMINAR VENTA RECUPERACION
			if(confirm('Esta Seguro de Eliminar El Registro'))
			{
				f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc+"&Valores="+valor;
				f.submit();
			}
			break;
		case "NVECCA"://NUEVO VENTA COSTO CARGO
			if(f.CmbMaterial.value=='2')
			{
				if(f.CmbUnidad2.value=='5')
				{
					if(f.Lote1TMS.value=='')
					{
						alert("Debe Ingresar Valor Lote por TMS ");
						f.Lote1TMS.focus();
						return;
					}
				}
				if(f.CmbCargo.value=='8'||f.CmbCargo.value=='9')
				{
					if(f.Observacion.value=='')
					{
						alert("Debe Ingresar Observaci�n para Otros (2)");
						f.Observacion.focus();
						return;
					}
				}
			}
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "EVECCA"://ELIMINAR VENTA COSTO CARGO
			if(confirm('Esta Seguro de Eliminar El Registro'))
			{
				f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc+"&Valores="+valor;
				f.submit();
			}
			break;
		case "NVECC0"://NUEVO VENTA COSTO CONTABLE
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "EVECC0"://ELIMINAR VENTA COSTO CONTABLE
			if(confirm('Esta Seguro de Eliminar El Registro'))
			{
				f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc+"&Valores="+valor;
				f.submit();
			}
			break;
		case "NVECAS"://NUEVO VENTA CASTIGO
			if(f.CmbMaterial.value=='2')
			{
				if(f.CmbCastigo.value=='5')
				{
					if(f.ObservacionCas.value=='')
					{
						alert("Debe Ingresar Observaci�n para Otros");
						f.ObservacionCas.focus();
						return;
					}
				}
				if(f.Cada.value=='')
				{
					alert("Debe Ingresar Por Cada %");
					f.Cada.focus();
					return;
				}
				if(f.Sobre.value=='')
				{
					alert("Debe Ingresar Sobre %");
					f.Sobre.focus();
					return;
				}
			}
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "EVECAS"://ELIMINAR VENTA CASTIGO
			if(confirm('Esta Seguro de Eliminar El Registro'))
			{
				f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc+"&Valores="+valor;
				f.submit();
			}
			break;
		case "NVEFAC"://NUEVO FACTOR
			if(f.CmbMaterial.value=='2')
			{
				if(f.CmbUnidad7.value!=1&&f.CmbUnidad7.value!=6)
				{
					if(f.TxtEuro.value=='')
					{	
						alert("Debe Ingresar Ingresar Cantidad de EUROS");
						f.TxtEuro.focus();
						return;
					}
				}
			}
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "EVEFAC"://ELIMINAR FACTOR
			if(confirm('Esta Seguro de Eliminar El Registro'))
			{
				f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc+"&Valores="+valor;
				f.submit();
			}
			break;
		case "NVEPREM"://NUEVO VENTA PREMIO			
			if(f.CmbMaterial.value=='2')
			{
				if(f.CmbUnidad8.value==17)
				{
					if(f.TxtEuroPre.value=='')
					{
						alert("Debe Ingresar Ingresar Cantidad de EUROS");
						f.TxtEuroPre.focus();
						return;
					}
				}
			}
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "EVEPREM"://ELIMINAR VENTA PREMIO
			if(confirm('Esta Seguro de Eliminar El Registro'))
			{
				f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc+"&Valores="+valor;
				f.submit();
			}
			break;
		case "NVETRANS"://NUEVO VENTA TRANSPORTE
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "EVETRANS"://ELIMINAR VENTA TRANSPORTE
			if(confirm('Esta Seguro de Eliminar El Registro'))
			{
				f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc+"&Valores="+valor;
				f.submit();
			}
			break;
		case "NVEPRE"://NUEVO VENTA PRECIO
			if(f.CmbMaterial.value=='2')
			{
				if(f.CmbDatosBuscar.value=='1')
				{
					if(f.CmbQP.value=='-1')
					{
						alert("Debe Seleccionar QP");
						f.CmbQP.focus();
						return;
					}	
					if(f.CmbFino.value=='T')
					{
						alert("Debe Seleccionar Fino de Base");
						f.CmbFino.focus();
						return;
					}	
				}
			}
			f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc;
			f.submit();
			break;
		case "EVEPRE"://ELIMINAR VENTA PRECIO
			if(confirm('Esta Seguro de Eliminar El Registro'))
			{
				f.action = "pcip_evaluacion_negocio_proceso01.php?Opcion="+Opc+"&Valores="+valor;
				f.submit();
			}
			break;

	}
}
var popup=0;
function ProcesoNuevo(Opt,Ptl,ProcesoAbierto)
{
	var f=document.FrmPopupProceso;
	switch(Opt)
	{
		case "NREC"://NUEVO RECUPERACI�N
			//alert(Opc);
			URL="pcip_evaluacion_negocio_proceso_nuevo.php?Opcion="+Opt+"&Ptl="+Ptl+'&ProcesoAbierto='+ProcesoAbierto;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=700,height=350,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
		case "NCAR"://NUEVO CARGO
			URL="pcip_evaluacion_negocio_proceso_nuevo.php?Opcion="+Opt+"&Ptl="+Ptl+'&ProcesoAbierto='+ProcesoAbierto;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=700,height=350,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
		case "NCAS"://NUEVO CASTIGOS
			URL="pcip_evaluacion_negocio_proceso_nuevo.php?Opcion="+Opt+"&Ptl="+Ptl+'&ProcesoAbierto='+ProcesoAbierto;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=700,height=350,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
		case "NDES"://NUEVO DESTINOS
			URL="pcip_evaluacion_negocio_proceso_nuevo.php?Opcion="+Opt+"&Ptl="+Ptl+'&ProcesoAbierto='+ProcesoAbierto;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=700,height=350,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
		case "NLEY"://NUEVO LEYES Y CONTABLES
			URL="pcip_evaluacion_negocio_proceso_nuevo.php?Opcion="+Opt+"&Ptl="+Ptl+'&ProcesoAbierto='+ProcesoAbierto;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=700,height=350,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
		case "NPREM"://NUEVO PREMIO
			URL="pcip_evaluacion_negocio_proceso_nuevo.php?Opcion="+Opt+"&Ptl="+Ptl+'&ProcesoAbierto='+ProcesoAbierto;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=700,height=350,scrollbars=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
			break;
	}	
}
function Aparece(Ptl,Cos)
{
	var f=document.FrmPopupProceso;
	f.action="pcip_evaluacion_negocio_proceso.php?Ptl="+Ptl+"&MostrarCosto="+Cos;
	f.submit();
}
function Aparece2(Ptl,Cos)//APARECE CUADRO DE OBSERVACI�N
{
	var f=document.FrmPopupProceso;
	f.action="pcip_evaluacion_negocio_proceso.php?Ptl="+Ptl+"&MostrarCosto="+Cos;
	f.submit();
}

function Recuperaciones(Ptl,Rec)
{
	var f=document.FrmPopupProceso;
	f.action="pcip_evaluacion_negocio_proceso.php?Ptl="+Ptl+"&MostrarRec="+Rec;
	f.submit();
}
//function Recuperaciones(Ptl,Rec)
//{
//	var f=document.FrmPopupProceso;
//	if(f.CmbRecup.value==3)
//	{
//		f.action="pcip_evaluacion_negocio_proceso.php?Ptl="+Ptl+"&MostrarRec="+Rec;
//		f.submit();
//		f.Des.style.visibility='';
//		f.TxtDes.style.visibility='';
//	}
//	else
//	{
//		f.Des.style.visibility='hidden';	
//		f.TxtDes.style.visibility='hidden';	
//		f.action="pcip_evaluacion_negocio_proceso.php?Ptl="+Ptl+"&MostrarRec="+Rec;
//		f.submit();
//	}
//}
function Castigos(Ptl,Cast)
{
	var f=document.FrmPopupProceso;
	f.action="pcip_evaluacion_negocio_proceso.php?Ptl="+Ptl+"&MostrarCast="+Cast;
	f.submit();
}
function Factor()
{
	var f=document.FrmPopupProceso;
	if(f.CmbUnidad7.value!=1&&f.CmbUnidad7.value!=6&&f.CmbUnidad7.value!='T')
	{
		f.NomDolar.style.visibility='';
		f.TxtEuro.style.visibility='';
		f.EURO.style.visibility='';
	}
	else
	{
		f.NomDolar.style.visibility='hidden';	
		f.TxtEuro.style.visibility='hidden';	
		f.EURO.style.visibility='hidden';	
	}
}
function Premio()
{
	var f=document.FrmPopupProceso;
	if(f.CmbUnidad8.value==17)
	{
		f.NomDolarPre.style.visibility='';
		f.TxtEuroPre.style.visibility='';
		f.EUROPre.style.visibility='';
	}
	else
	{
		f.NomDolarPre.style.visibility='hidden';	
		f.TxtEuroPre.style.visibility='hidden';	
		f.EUROPre.style.visibility='hidden';	
	}
}
function Recarga(Opt,CmbLey)
{
	var f=document.FrmPopupProceso;
	f.action="pcip_evaluacion_negocio_proceso.php?Ptl="+Opt+"&CmbLey="+CmbLey;
	f.submit();
}
function RecargaUni(Ptl)
{
	var f=document.FrmPopupProceso;
	f.action="pcip_evaluacion_negocio_proceso.php?Ptl="+Ptl;
	f.submit();
}
//function RecargaUnidad()
//{
//	var f=document.FrmPopupProceso;
//	alert(f.CmbLey.value)
//	if(f.CmbLey.value=='0')
//		f.ValoresUnidad.value="12,14";
//	else
//		f.ValoresUnidad.value="14,20,21,12,9,22,10";	
//}
function ProcesoExpCont(Opt,NomVar,Opc)
{
	var f=document.FrmPopupProceso;

	f.action="pcip_evaluacion_negocio_proceso.php?Ptl="+Opt+"&"+NomVar+"="+Opc;
	f.submit();
	
}
function Salir()
{
	window.close();
}
</script>
</head>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="Cod" value="<? echo $Cod;?>">
<input type="hidden" name="Opc" value="<? echo $Opc;?>">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="../pcip_web/archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="818" height="15"background="../pcip_web/archivos/images/interior/form_arriba.gif"><img src="../sget_web/archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="../pcip_web/archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="../pcip_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><br>
     <table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><?	if($Opc=='N'){?><img src="../pcip_web/archivos/sub_tit_eva_negocio_n.png"><? }else{?>
         <img src="../pcip_web/archivos/sub_tit_eva_negocio_m.png"><?	}?></td>
       <td align="right">
	   <a href="JavaScript:Proceso('NI')"><img src="archivos/nuevo.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
	   <a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="../pcip_web/archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a>
	   <?
	   if($Opc=='M')
	   {
	   ?>
	   <a href="JavaScript:Proceso('GN')"><img src="../pcip_web/archivos/info2.png" alt="Renombrar"  border="0" align="absmiddle" /></a>
	   <?
	   }
	   ?>
	   <a href="JavaScript:Salir()"><img src="../pcip_web/archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a></td>
     </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
       <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="ColorTabla02">
         <tr>
           <td width="163" height="17" class='formulario2'>Nombre del Archivo</td>
           <td class="formulario2">
            <input name="TxtNombre"  maxlength= "50" type="text" id="TxtNombre" style="width:250" value="<? echo $TxNombre; ?>" >
           <td class="formulario2">A&ntilde;o           
           <td class="formulario2"><select name="Ano" id="Ano">
             <?
				for ($i=2003;$i<=date("Y");$i++)
				{
					if ($i==$Ano)
						echo "<option selected value=\"".$i."\">".$i."</option>\n";
					else
						echo "<option value=\"".$i."\">".$i."</option>\n";
				}
			?>
           </select>           
           <td class="formulario2">Mes&nbsp;&nbsp;&nbsp;
             <select name="Mes" id="Mes">
               <?
				for ($i=1;$i<=12;$i++)
				{
					if ($i==$Mes)
						echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
					else
						echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
				}
			?>
             </select>         </tr>
         <tr>
           <td height="17" class='formulario2'>Material</td>
           <td class='formulario2'><select name="CmbMaterial">
               <option value="-1" class="Selected">Seleccionar</option>
               <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31033' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbMaterial==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
             
              
				   ?>
             </select>
               <? //echo	$Consulta;	?>
           <td width="60" class='formulario2'>Origen                  
           <td width="262" class='formulario2'><select name="CmbOrigen">
                    <option value="-1" class="Selected">Seleccionar</option>
                    <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31035' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbOrigen==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
                  </select>
                <td width="261" class='formulario2'>         </tr>
         <tr>
           <td height="17" class='formulario2'> An&agrave;lisis </td>
           <td colspan="4" class='formulario2'><label>
             <input name="OptAnalisis1" type="checkbox" class="SinBorde" value="2" <? echo $CheckAnal_1;?>>
             Procesamiento Ventana </label>                </tr>
         <tr>
           <td height="17" class='formulario2'>&nbsp;</td>
           <td colspan="4" class='formulario2'><input name="OptAnalisis2" type="checkbox" class="SinBorde" value="3" <? echo $CheckAnal_2;?>>
             Venta           </tr>
         <tr>
           <td height="17" class='formulario2'>&nbsp;</td>
           <td width="286" class='formulario2'><input name="OptAnalisis3" type="checkbox" class="SinBorde" value="4" <? echo $CheckAnal_3;?>>
             Procesamiento en Otra Divisi&oacute;n                      			    
           <td colspan="3" class='formulario2'><select name="CmbDiv">
                    <option value="-1" class="Selected">Selecci�n Divisi&oacute;n 1</option>
                    <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31060' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbDiv==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
                  </select>
                    <select name="CmbDiv2">
                      <option value="-1" class="Selected">Selecci�n Divisi&oacute;n 2</option>
                      <?
					$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31060' ";			
					$Resp=mysqli_query($link, $Consulta);		
					while ($Fila=mysql_fetch_array($Resp))
					{
						if ($CmbDiv2==$Fila["cod_subclase"])
							echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					?>
                    </select>                </tr>
       </table>
       <br></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   <?
   //$Opc='M';
   if($Opc=='M')
   {
	   if($ContVi�etas>0)
	   {
		   $TamVi�eta=round((100-$ContVi�etas)/$ContVi�etas);
		   $TamExtra=100-($ContVi�etas*$TamVi�eta);
	   }
	   //echo $TamVi�eta."<br>";
	   //echo $TamExtra."<br>";
   ?>
   <table width="101%"  border="0" align="center" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
     <tr>
        <td width="1%" align="center" class="TituloTablaVerde"></td>
       <?
		if ($Ptl1=='CM') 
			$Fondo="archivos/barra_medium_activa2.png"; 
		else 
			$Fondo="archivos/barra_medium2.png";
		?>
       <td width="<? echo $TamVi�eta;?>%"  height="25"  align="center" background="<? echo $Fondo;?>"><a href="JavaScript:Recarga('CM','T');">
         <?  
		if ($Ptl1=='CM') 
			echo "<span class='TituloTablaVerdeActiva'>"; 
		else 
			echo "<span class='TituloTablaVerde'>"; ?>
         Caracteristicas del Material </span></a></td>
       <td width="0%" ><img src="archivos/tab_separator.gif"></td>
       <?
		if($CmbOrigen=='2')
		{
		if ($Ptl=='CO') 
			$Fondo="archivos/barra_medium_activa2.png"; 
		else 
			$Fondo="archivos/barra_medium2.png";
		?>
       <td width="<? echo $TamVi�eta;?>%" height="25"  align="center" background="<? echo $Fondo;?>"><a href="JavaScript:Recarga('CO','');">
         <?
			if ($Ptl=='CO')  
				echo '<span class="TituloTablaVerdeActiva">';  
			else
				echo '<span class="TituloTablaVerde">';?> 
			Compra </span></a></td>
       <td width="0%" ><img src="archivos/tab_separator.gif"  ></td>
       <? 	 
	   }
		if($CheckAnal_1!='')
		{
	   if ($Ptl=="PP") 
				$Fondo="archivos/barra_medium_activa2.png"; 
			else 
				$Fondo="archivos/barra_medium2.png";
		?>
       <td width="<? echo $TamVi�eta;?>%"  height="25"  align="center" background="<? echo $Fondo;?>"><a href="JavaScript:Recarga('PP','');">
         <?
			if ($Ptl=="PP")  
				echo '<span class="TituloTablaVerdeActiva">';  
			else 
				echo '<span class="TituloTablaVerde">'; ?>
			 Procesamiento Ventana </span></a></td>
		  <td width="0%" ><img src="archivos/tab_separator.gif"  ></td>
		   <? 
		}
		if($CheckAnal_2!='')
		{
		 if ($Ptl=="VE") 
				$Fondo="archivos/barra_medium_activa2.png"; 
			else 
				$Fondo="archivos/barra_medium2.png";
		?>
		   <td width="<? echo $TamVi�eta;?>%"  height="25"  align="center" background="<? echo $Fondo;?>"><a href="JavaScript:Recarga('VE','');">
        <?
		if ($Ptl=="VE")  
			echo '<span class="TituloTablaVerdeActiva">';  
		else 
			echo '<span class="TituloTablaVerde">'; ?>
         Venta </span></a></td>
      <td width="0%" ><img src="archivos/tab_separator.gif"  ></td>
       <? 
		}
		if($CheckAnal_3!=''&&$CmbDiv!='-1')
		{
	   	 $Div=DatosSubClase('31060',$CmbDiv);
		 $CodPet="MA".$CmbDiv;
		 if ($Ptl==$CodPet) 
				$Fondo="archivos/barra_medium_activa2.png"; 
			else 
				$Fondo="archivos/barra_medium2.png";
		?>
       <td width="<? echo $TamVi�eta;?>%"  height="25"  align="center" background="<? echo $Fondo;?>"><a href="JavaScript:Recarga('<? echo $CodPet;?>','');">
         <?
		if ($Ptl==$CodPet)  
			echo '<span class="TituloTablaVerdeActiva">';  
		else 
			echo '<span class="TituloTablaVerde">'; ?>
         Maquila(<? echo $Div;?>) </span></a></td>
      <td width="0%" ><img src="archivos/tab_separator.gif"  ></td>
       <?
	   }
		if($CheckAnal_3!=''&&$CmbDiv2!='-1')
		{
	   	 $Div=DatosSubClase('31060',$CmbDiv2);
		 $CodPet="MA".$CmbDiv2;
		 if ($Ptl==$CodPet) 
				$Fondo="archivos/barra_medium_activa2.png"; 
			else 
				$Fondo="archivos/barra_medium2.png";
		?>
       <td width="<? echo $TamVi�eta;?>%"  height="25"  align="center" background="<? echo $Fondo;?>"><a href="JavaScript:Recarga('<? echo $CodPet;?>','');">
         <?
		if ($Ptl==$CodPet)  
			echo '<span class="TituloTablaVerdeActiva">';  
		else 
			echo '<span class="TituloTablaVerde">'; ?>
         Maquila(<? echo $Div;?>) </span></a></td>
      <td width="0%" ><img src="archivos/tab_separator.gif"  ></td>
		<?
		}	    
			 if ($Ptl=="AN") 
				$Fondo="archivos/barra_medium_activa2.png"; 
			else 
				$Fondo="archivos/barra_medium2.png";
		
		?>
       <td width="<? echo ($TamVi�eta+$TamExtra);?>%"  height="25"  align="center" background="<? echo $Fondo;?>"><a href="JavaScript:Recarga('AN','');">
         <?
		if ($Ptl=="AN")  
			echo '<span class="TituloTablaVerdeActiva">';  
		else 
			echo '<span class="TituloTablaVerde">'; ?>
         An�lisis</span></a></td>

		 </tr>
     </table>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="1%" align="center" class="TituloTablaVerde"></td>
        <td align="center" width="99%">
		
		<?
		switch (substr(trim($Ptl1),0,2))
		{
			case "CM"://CARACTERISTICAS DEL MATERIAL
				if($CmbMaterial=='2')
					include("pcip_evaluacion_negocio_proceso_cm_conc.php");
				else
					include("pcip_evaluacion_negocio_proceso_cm.php");	
				break;
			case "CO"://ANALISIS COMPRA
				if($CmbMaterial=='2')		
					include("pcip_evaluacion_negocio_proceso_co_conc.php");
				else
					include("pcip_evaluacion_negocio_proceso_co.php");
				break;
			case "PP"://ANALISIS PROPIO
				if($CmbMaterial=='2')
					include("pcip_evaluacion_negocio_proceso_pp_conc.php");
				else
					include("pcip_evaluacion_negocio_proceso_pp.php");
				break;
			case "VE"://ANALISIS VENTA
				if($CmbMaterial=='2')
					include("pcip_evaluacion_negocio_proceso_ve_conc.php");
				else
					include("pcip_evaluacion_negocio_proceso_ve.php");
				break;
			case "MA"://ANALISIS MAQUILA
				$CodTipoAnalisis='4'.substr(trim($Ptl1),2);
				if($CmbMaterial=='2')
					include("pcip_evaluacion_negocio_proceso_ma_conc.php");
				else
					include("pcip_evaluacion_negocio_proceso_ma.php");
				break;
			case "AN"://ANALISIS
				if($CmbMaterial=='2')
					include("pcip_evaluacion_negocio_proceso_an_conc.php");
				else							
					include("pcip_evaluacion_negocio_proceso_an.php");
				break;
		}
		?></td>
		<td width="0%" align="center" class="TituloTablaVerde"></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="TituloTablaVerde"></td>
      </tr>
  </table>
  <?
  }
  ?>
   </td>
   <td width="16" background="../pcip_web/archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="../pcip_web/archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="../pcip_web/archivos/images/interior/form_abajo.gif"><img src="../pcip_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="16" height="15"><img src="../pcip_web/archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>	  		
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje!='')
		echo "alert('".$Mensaje."');";
	echo "</script>";
	function DatosSubClase($CodClase,$CodSubClase)
	{
		$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='".$CodClase."' and cod_subclase='".$CodSubClase."' ";			
		$Resp=mysqli_query($link, $Consulta);		
		if($Fila=mysql_fetch_array($Resp))
			$Datos=$Fila["nombre_subclase"];
		else
			$Datos='';
		return($Datos);	
	}
?>