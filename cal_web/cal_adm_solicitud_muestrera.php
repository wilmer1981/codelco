<?php
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 3;
	include("../principal/conectar_principal.php");
	$Fecha_Hora = date("d-m-Y H:i");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$CookieRut=$_COOKIE["CookieRut"];
	$Rut =$CookieRut;

	if(isset($_REQUEST["CmbEstado"])) {
		$CmbEstado = $_REQUEST["CmbEstado"];
	}else{
		$CmbEstado = "";
	}
	if(isset($_REQUEST["CmbAnoSol"])) {
		$CmbAnoSol = $_REQUEST["CmbAnoSol"];
	}else{
		$CmbAnoSol = date("Y");
	}
	if(isset($_REQUEST["NSol"])) {
		$NSol = $_REQUEST["NSol"];
	}else{
		$NSol = "";
	}
	
	if(isset($_REQUEST["LimitIni"])) {
		$LimitIni = $_REQUEST["LimitIni"];
	}else{
		$LimitIni = 0;
	}
	if(isset($_REQUEST["LimitFin"])) {
		$LimitFin = $_REQUEST["LimitFin"];
	}else{
		$LimitFin = 30;
	}

	if(isset($_REQUEST["TxtFechaIni"])) {
		$TxtFechaIni = $_REQUEST["TxtFechaIni"];
	}else{
		$TxtFechaIni = date("Y-m-d");
	}
	if(isset($_REQUEST["TxtFechaFin"])) {
		$TxtFechaFin = $_REQUEST["TxtFechaFin"];
	}else{
		$TxtFechaFin = date("Y-m-d");
	}

	if(isset($_REQUEST["Mensaje"])) {
		$Mensaje = $_REQUEST["Mensaje"];
	}else{
		$Mensaje = "";
	}

	if(isset($_REQUEST["Proc"])) {
		$Proc = $_REQUEST["Proc"];
	}else{
		$Proc = "";
	}
	if(isset($_REQUEST["NewRec"])) {
		$NewRec = $_REQUEST["NewRec"];
	}else{
		$NewRec = "";
	}
	if(isset($_REQUEST["TipoConsulta"])) {
		$TipoConsulta = $_REQUEST["TipoConsulta"];
	}else{
		$TipoConsulta = "";
	}
	if(isset($_REQUEST["EstOpe"])) {
		$EstOpe = $_REQUEST["EstOpe"];
	}else{
		$EstOpe = "";
	}
	$Valores_Check = isset($_REQUEST["Valores_Check"])?$_REQUEST["Valores_Check"]:"";
	$FechaAtencion = isset($_REQUEST["FechaAtencion"])?$_REQUEST["FechaAtencion"]:"";		
?>
<html>
<head>
<title>Administraci&oacute;n de Solicitudes de Muestreo</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
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
			ValidarDetalle(FechaAtencion);
			break;			
		case "E":
			ValidarCambiarEstado();
			break; 
		case "As":
			ValidarRecuperacionAutomatica(FechaAtencion);
			break;

		case "FP"://clickeo fecha Proceso
			Recepcionar();
			break;
		case "R":
			ValidarRetalla();
			break;	
		case "Arec":		
			LevantaPant();
			break;
	}	

}
function LevantaPant()
{	
	window.open("cal_adm_solicitud_muestrera_popup.php?","","top=200,left=120,width=500,height=300,scrollbars=yes,resizable = yes");	
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
		frm.action ="cal_adm_solicitud_muestrera.php";  
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
	//try 
	//{
		frm.checkAtender[0];
		for (i=1;i<frm.checkAtender.length;i++)
		{
			if (frm.checkAtender[i].checked==true)
			{
				SARutRecargo = SARutRecargo + frm.TxtSAO[i].value + "~~" + frm.TxtRutO[i].value + "||" + frm.TxtRecargoO[i].value + "//" ;
				Encontro=true;
			}
		}
	//}	
	//catch (e)
	//{
	 	// alert("No hay Elementos para Seleccionar");
	//}
	if (Encontro==false)
	{
		alert("No hay Elementos Seleccionar");
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
function ValidarRetalla()
{
	var frm =document.FrmMuestras;
	var LargoForm =frm.elements.length;
	var ValoresSA="";
	var Valor= "";
	var SARutRec ="";
	var SA ="";
	var RutRec="";
	var Rut="";
	var Recargo="";
	var CheckeoAtencion="";
	var Solicitudes ="";
	var cont ="";
	if (SoloUnElementoSolicitudesCheck())
	{
		var ValoresSA="";	
		//Asigna a ValoresSA los valores recuperados de la funcion donde recupera la SA,rut,recargo para atenderlos
		ValoresSA=RecuperarSolRecepcionar();
		Valor= ValoresSA;
		for (j = 0;j <= Valor.length; j++)
		{
			if (Valor.substr(j,2) == "//")
			{
				SARutRec=(Valor.substr(0,j));
				for(x=0;x<= SARutRec.length;x++)
				{
					if (SARutRec.substr(x,2) == "~~")
					{
						SA = SARutRec.substr(0,x);			
						RutRec =SARutRec.substr(x+2,(SARutRec.length));
						for (y = 0 ; y <=RutRec.length; y++ )
						{
							if (RutRec.substr(y,2)=="||")
							{
								Rut = RutRec.substr(0,y);
								Recargo =RutRec.substr(y+2,(RutRec.length));
							}
						}
					 }		
				  }
				Valor = Valor.substr(j + 2);
				j = 0;
			  }	
		   }
		
		//if (Recargo != 0)
		if ((Recargo !='N')&&(Recargo!='0'))
		{
			alert("Retalla es solo para Recargos 0"); 
		}	
		else
		{
				window.open("cal_retalla.php?ValoresSA="+ ValoresSA,"","top=200,left=0,width=430,height=200,scrollbars=no,resizable = yes");						
		}
	}
}	



function Salir()
{
	var frm =document.FrmMuestras;
	frm.action="cal_atencion_solicitud_muestreo01.php?Opcion=S";
	frm.submit(); 
}
function ValidarDetalle(Datos)
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
	
	var Detalle=Datos.split('~');
	//if (SoloUnElementoSolicitudesCheck())
	//{
		/*for (i=1;i<frm.checkAtender.length;i++)
		{
			if (frm.checkAtender[i].checked==true)
			{
				SA = frm.TxtSA[i].value ;
				RutF =frm.TxtRutO[i].value ;
				Recargo = frm.TxtRecargoO[i].value
				Muestra =frm.TxtIdMuestra[i].value ;			
				Lotes =frm.TxtLotes[i].value ; 
				Productos =frm.TxtProducto[i].value ;
				alert(Productos)*/
				SA = Detalle[0];
				RutF =Detalle[1];
				Recargo = Detalle[2];
				Muestra =Detalle[3].replace(/_/gi,' ');			
				Lotes =Detalle[4].replace(/_/gi,' ');
				Productos =Detalle[5].replace(/_/gi,' ');
				window.open("cal_detalle_solicitud_muestreo.php?SA="+ SA + "&RutF="+ RutF + "&Muestra="+ Muestra + "&Lotes="+ Lotes + "&Productos="+ Productos + "&Recargo="+Recargo,"","top=200,left=0,width=770,height=380,scrollbars=no,resizable = yes");					
				//break;
			//}	
		//}
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

//*******************************
//funcion para la fecha de proceso 
function Recepcionar() 
{
	var frm=document.FrmMuestras;
	var ValoresSA="";	
	if (frm.CmbTipo.value == -1)
	{
		alert("Debe Seleccionar Tipo Muestra");
		return;
	}
	//Asigna a ValoresSA los valores recuperados de la funcion donde recupera la SA,rut,recargo 
	ValoresSA=RecuperarSolRecepcionar();
	if (ValoresSA!="")
	{
		if (frm.CmbTipo.value=='7')
		{
			var mensaje = confirm("¿Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				frm.action="cal_adm_solicitud_muestreo_jefe01.php?ValoresSA="+ ValoresSA ;
				frm.submit(); 
			}
			else
			{
				return;
			}
		
		}
		else
		{
			frm.action="cal_adm_solicitud_muestreo_jefe01.php?ValoresSA="+ ValoresSA ;
			frm.submit(); 
		}
	}
}

function Impresion(txtnro_solicitud, recargo,impres)
{
		if(impres != "")
			var mensaje = confirm("¿Esta seguro de Reimprimir la Plantilla?");
		else
			var mensaje = confirm("¿Esta seguro de Generar una Plantilla?");
		if (mensaje==true)
		{
			window.open("cal_muestrera_impresion.php?txtnro_solicitud="+txtnro_solicitud+"&recargo="+recargo,"","scrollbars=yes,top=60px,left=50px,width=800px,height=640px, align=center");		
		}
		else
		{
			return;
		}

}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style></head>
<body ><!--onLoad="window.document.frmPrincipal.TxtLote.focus();"-->
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmMuestras" action="" method="post">

<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="NewRec" value="<?php echo $NewRec; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<?php include("../principal/encabezado.php")?>
<table class="TablaPrincipal" width="1024px" height="500px" cellpadding="0" cellspacing="0" >
	<tr>
	  <td width="100%" align="center" valign="top"><br>
<table width="95%"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02">
    <td colspan="6"><STRONG>ADMINISTRACION  MUESTRERA</STRONG></td>
  </tr>
<?php
	if ($EstOpe != "")
	{  
		switch ($EstOpe)
		{
			case "S":
				$Clase="ErrorSI";
				break;
			case "N":
				$Clase="ErrorNO";
				break;
		}
		echo "<tr class='ColorTabla02'>\n";
    	echo "<td colspan='4' class='Colum01' align='center'><font class='".$Clase."'>".$Mensaje."</font></td>\n";
    	echo "</tr>\n";
	}
?>
  <tr class="Colum01">
    <td width="140" class="Colum01">Usuario:</td>
    <td width="224" class="Colum01"><strong>
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
    </strong>
    <td width="103" align="right" class="Colum01">Fecha:</td>
    <td class="Colum01" colspan="3"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $Fecha_Hora ?> </strong>&nbsp; <strong>
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
  <tr class="Colum01">
    <td class="Colum01">Fecha Inicio:</td>
    <td class="Colum01"><input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
      <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"></td>
    <td align="right" class="Colum01">Fecha T&eacute;rmino:</td>
    <td class="Colum01" colspan="3"><input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
      <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Estado:</td>
    <td class="Colum01"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
      <select name="CmbEstado" style="width:170" >
        <option value = "-1" selected >Seleccionar</option>
        <?php
		$Consulta =  "select cod_subclase,nombre_subclase,ceiling(valor_subclase6) as orden from sub_clase where (cod_clase = 1002 and cod_subclase in(1,3)) order by orden ";
		$Resultado = mysqli_query($link, $Consulta);
		while ($Fila =mysqli_fetch_assoc ($Resultado))
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
    </font></font></strong></font></font></td>
<td align="right" class="Colum01"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">N° Solicitud</font></td>
    <td width="280" align="left" class="Colum01">
    <font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
    <select name="CmbAnoSol" size="1" style="width:70px;">
    <?php
    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
    {
    if (isset($CmbAnoSol))
    {
        if ($i==$CmbAnoSol)
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
				$CmbAnoSol=$i;
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
    <input name="NSol" type="text" value="<?php echo $NSol; ?>" maxlength="6" style="width:47">
    </font></font></strong></font></font></font></font></font></strong></font></font><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
    <input name="BtnBuscar" type="submit" id="BtnBuscar4" value="Buscar" onClick="Proceso('B');">
    </font></font></font></font></strong></font></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></font></td>    
    <td width="119" align="right" class="Colum01"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Lineas por P&aacute;gina</font></td>
    <td width="67" class="Colum01"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
      <input name="LimitFin" type="text" value="<?php echo $LimitFin; ?>" size="12" maxlength="3" style="width:30">
    </font></font></strong></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
    <!--<input name="BtnBuscar" type="submit" id="BtnBuscar4" value="Buscar" onClick="Proceso('B');">-->
    </font></font></font></font></strong></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></font></td>
  </tr>
  
	<tr align="center" class="Colum01">
	  <td height="30" colspan="6" class="Colum01">
      <?php 
	  //if($CmbEstado!='13' && $CmbEstado!='3')
	  //{//atendida por muestrera?>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
	    <tr>
	      <td width="104" align="left"><div align="center"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Todos</font></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
	        <input name="checkTodos" type="checkbox" onClick="JavaScript:Activar();" value="checkbox">
	        </font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font></font></div></td>
	      <td width="90" align="center"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
	        <input name="BtnImprimir2" type="button" id="BtnImprimir2" value="Etiqueta" onClick="ImprimirEtiqueta();">
	        </font></font></td>
	      <td width="7"><div align="left">
	        <!--<input name="BtnDetalle" type="button" id="BtnDetalle" value="Detalle" onClick="Proceso('D');">-->
            <?php
			if ($CmbEstado == '1')
				echo "<input name='BtnModificar' type='button'  value='Modificar' onClick=\"Proceso('M');\">";
			?>
	        </div></td>
            <td width="67">
              <?php
			   if ($CmbEstado == '1')
			    {
					echo "<input name='BtnRetalla' type='button'  value='Retalla' onClick=\"Proceso('R');\">";
					//echo "<input type='button' name='Button' value='Fech-Pro' onClick=\"Proceso('A');\">";
               	}
			   ?>
            </td>
            
	      <?php
			if ($CmbEstado != '3')
			{
				echo "<td width='75' align='left'><input name='BtnEliminar' type='button' value='Eliminar' onClick=\"Proceso('E',' ',' ');\"></td>";
            }
			?>
	      <td width="111" align="left"><input name="BtnActualizar" type="submit" id="BtnActualizar3" value="Actualizar"></td>
	      <td width="298">
		    <?php
			//if ($CmbEstado == '1')
				//echo "<input name='BtnRecepcionar' type='button'  value='Recepcionar' onClick=\"Proceso('R');\">";
		    if ($CmbEstado == '1')
			{
				echo "<input name='CmbTipo' type='hidden' value='3' >";
				echo "<input type='button' name='Button' value='Enviar Lab.' onClick=\"Proceso('FP','$LimitIni');\">";
			}
			?>
            <input name="BtnAgregar" type="button" onClick="Proceso('Arec');" style="width:100px;" id="BtnAgregar" value="Agregar Recargo">
            </td>
            <td width="313"><input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60" onClick="Proceso('S');">&nbsp;</td>
	      </tr>
	    </table>
      <?php
	 // }
	  /*else{
	  ?>
		<table width="100%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="71"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input name="checkTodos" type="checkbox" onClick="JavaScript:Activar();" value="checkbox">
              </font><font size="2">Todos</font></font></td>
            <td width="73"><input name="BtnActualizar" type="submit" id="BtnActualizar4" value="Actualizar"></td>
            <td width="109"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
              <?php
			  //Si CmbEstado es igual a 13 "At muestrera o activar"
			  if (($CmbEstado == '13') || ($CmbEstado == '14')) 
			  {
			  	echo "<select name='CmbTipo' style='width:100' >";
                echo "<option value='-1' selected>Seleccionar</option>";
                
				$Consulta ="select * from sub_clase where cod_clase = 1002 and valor_subclase1 = 'atender' ";
				$Consulta =$Consulta." or (cod_clase = 1002 and cod_subclase = 3)";
				$Consulta =$Consulta." or (cod_clase = 1002 and cod_subclase = 7 )  ";
				$Consulta =$Consulta." or (cod_clase = 1002 and cod_subclase = 8 ) ";
				$Consulta =$Consulta." or (cod_clase = 1002 and cod_subclase = 14 ) or (cod_clase = 1002 and cod_subclase = 6 ) order by valor_subclase3 ";
				$Resultado = mysqli_query($link, $Consulta);
				while ($Fila =mysqli_fetch_array ($Resultado))
		 		{
		    		if ($CmbTipo == $Fila["cod_subclase"])
		  			{
		  				if ($Fila["cod_subclase"]== '3')
						{
							$Fila["nombre_subclase"]='Env a Laborat';
						
						}
						echo"<option value='".$Fila["cod_subclase"]."'selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>";
					}	
		 			else 
		 			{
		 				if ($Fila["cod_subclase"]== '3')
						{
							$Fila["nombre_subclase"]='Env a Laborat';
						
						}
						echo"<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
		    		}
		 		}
		 	 	
              echo "</select>";
			  }
			  //si es estado pendiente
			    if ($CmbEstado == '8')
			  	{
					echo "<select name='CmbTipo' style='width:100' >";
					echo "<option value='-1' selected>Seleccionar</option>";
					
					$Consulta ="select * from sub_clase where cod_clase = 1002 and cod_subclase = '14' ";
					//$Consulta =$Consulta." or (cod_clase = 1001 and cod_subclase = 3) or (cod_clase = 1002 and valor_subclase2 =1 ) ";
					$Resultado = mysqli_query($link, $Consulta);
					while ($Fila =mysqli_fetch_array ($Resultado))
					{
						if ($CmbTipo == $Fila["cod_subclase"])
						{
							echo"<option value='".$Fila["cod_subclase"]."'selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>";
						}	
						else 
						{
							echo"<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
						}
					}
		 	 	    echo "</select>";
			  	}
              ?>
              </font></font></font></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></font></font></font></td>
            <td width="390"><font size="1"><font size="2">Fecha Proceso </font><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
              </font><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2">
              <select name="CmbDiaP" id="select7" size="1" style="width:40px;">
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
              <select name="CmbMesP" size="1" style="width:90px;">
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
              <select name="CmbAnoP" size="1" style="width:70px;">
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
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><font size="2"> 
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><font size="2"> 
              <select name="HoraAnalisis" id="select33">
                <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($HoraAnalisis))
					{	
						if ($HoraAnalisis == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
              </select>
              <strong>:</strong> 
              <select name="MinutosLixiv">
                <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($MinutosLixiv))
					{	
						if ($MinutosLixiv == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
              </select>
              </font></font></td>
            <td width="80"><div align="center"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
               <?php
			   if (($CmbEstado != '7') && ($CmbEstado !='3'))
			    {
					echo "<input type='button' name='Button' value='Fech-Pro' onClick=\"Proceso('FP','$LimitIni');\">";
               	}
			   ?>
			    </font></font></div></td>
          </tr>
        </table>
      <?php	  
	  }*/
	  ?>  
        </td>
	  </tr>
	</table>
	<br>
	<table width="95%"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
	  <tr class="ColorTabla01" align="center">
		<td align="center" width="28"><br></td>
		<td align="center" width="28">S.A</td>
		<td align="center" width="29">Id.Muestra</td>
		<td align="center" width="71">Producto</td>
		<td align="center" width="75">Originador</td>
		<td align="center" width="75">Estado</td>
		<td align="center" width="71">F.Creacion</td>
        <td align="center" width="28">Imp.</td>
		<!--<td align="center" width="71">F.Recepcion</td>-->
        <?php //echo $CmbEstado; 
		/*if($CmbEstado=='13' || $CmbEstado=='3'){?>
		<td align="center" width="73">F.Atencion</td>
		<td align="center" width="74">F.Ult.Aten</td>
        <?php }*/?>
	  </tr>
        <?php
	 	include ("../Principal/conectar_cal_web.php");	
		$FechaI = $TxtFechaIni.' 00:01';
		$FechaT = $TxtFechaFin.' 23:59';
		//echo $CmbEstado."<br>";
		$Entrar = true;
		if($NSol=='')
		{
			switch ($CmbEstado) 
			{
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
				case "3":
					$Estado ="where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and  (t6.cod_estado = '3') ";
					break;
				case "7": 
					//Estado Eliminado 
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t6.cod_estado = '7')";
					break;
				default:
					$Entrar= false;
					break;
			}
		}
		else
			$Estado = " where t1.nro_solicitud='".$CmbAnoSol.str_pad($NSol,6,0,STR_PAD_LEFT)."' and t6.cod_estado='".$CmbEstado."'";
		
		//$ConsultaPag="";
		if ($Entrar == true)
		{
			$Consulta = "select t1.tipo_solicitud,t2.descripcion as nomproducto,t3.descripcion as nomsubproducto,";
			$Consulta = $Consulta."t1.rut_funcionario,t1.recargo,t1.fecha_hora, t6.fecha_hora as FechaAtencion,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado, ";
			$Consulta = $Consulta."concat(t4.nombres,' ',t4.apellido_paterno,' ',t4.apellido_materno) as nombreapellido, ";
			$Consulta = $Consulta."t4.apellido_paterno as ap_paterno, ";
			$Consulta = $Consulta."t4.apellido_materno as ap_materno, ";
			$Consulta =	$Consulta."t1.nro_solicitud,t1.id_muestra,t1.fecha_hora as FechaCreacion,t7.cod_subclase,t7.nombre_subclase,t6.cod_estado,t1.estado_actual,t1.corr_impresion ";
			$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
			$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
			$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
			$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
			$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual = t6.cod_estado)";
			$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002' ";
			$Consulta = $Consulta.$Estado." order by t1.nro_solicitud,recargo_ordenado   ";
			$ConsultaPag=$Consulta;
			$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
			//echo $Consulta;
			echo "<input type='hidden' name='checkAtender'><input name ='TxtSA' type='hidden'><input name ='TxtSAO' type='hidden'><input name ='TxtRutO' type='hidden'><input name='TxtFechaO' type='hidden'><input name='TxtHoraO' type='hidden'><input name ='TxtRecargoO' type='hidden'><input name ='TxtIdMuestra' type='hidden'><input name ='TxtLotes' type='hidden'><input name ='TxtProducto' type='hidden'>";
			$Respuesta= mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{	//var_dump($Fila);
				if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))
					$Recargo='N';
				else
					$Recargo=$Fila["recargo"];	
				$Datos=$Fila["nro_solicitud"].'~'.$Recargo.'~'.$Fila["rut_funcionario"];

				$Detalle=$Fila["nro_solicitud"].'~'.$Fila["rut_funcionario"].'~'.$Recargo.'~'.str_replace(' ','_',$Fila["id_muestra"]).'~'.str_replace(' ','_',$Fila["id_muestra"]).'~'.str_replace(' ','_',ucwords(strtolower($Fila["nomsubproducto"])));
				
				echo "<tr bgcolor='#FFFFFF'>";
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
					echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value='$Datos'></td>"; 
				}
				else
				{
					echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value='$Datos' checked></td>"; 
				}
					//echo "<input name='SolictudesO' type='hidden' value='".$Fila["nro_solicitud"].'-'.$Fila["recargo"]."'>";
				//fin de pregunta para que quede checkeado
				//Pregunta si la  Solicitud es especial y esta en estado creada(1) o  recepcionada en muestrera color verde
				if (($Fila["tipo_solicitud"] == 'R') && (($Fila["estado_actual"] == '1') || ($Fila["estado_actual"] == '2') || ($Fila["estado_actual"] == '3')))
				{
					echo "<td width='110'  ><div align='left'><a href=javascript:Proceso('D','".$Detalle."')>".$TxtSA = $Fila["nro_solicitud"]."</a><input name='TxtSA' style= 'background:#F4F5BA'  type='hidden' readonly style='width:110' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name = 'TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type='hidden'  value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type='hidden' value='N'></div></td>";
				}
				//�Pregunta si la Solicitud es especial esta en estado  atendida  en muestrera color verde
				if (($Fila["tipo_solicitud"] == 'R') && ($Fila["estado_actual"] == '13'))
				{
					echo "<td width='110'  ><div align='left'><a href=javascript:Proceso('D','".$Detalle."')>".$TxtSA = $Fila["nro_solicitud"]."</a><input name='TxtSA' style= 'background:#BAC8CD'  type='hidden' readonly style='width:110' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name = 'TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name = 'TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name='TxtRecargoO' type='hidden' value='N'></div></td>";
				}
				//Pregunta si la  Solicitud es automatica y esta en estado creada(1) o  recepcionada en muestrera amarillo
				if (($Fila["tipo_solicitud"] == 'A') && (($Fila["estado_actual"] == '1') || ($Fila["estado_actual"] == '2') || ($Fila["estado_actual"] == '3')))
				{
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]=="")) 
					{
						echo "<td width='110'><div align='left'><a href=javascript:Proceso('D','".$Detalle."')>".$TxtSA = $Fila["nro_solicitud"]."</a><input name='TxtSA'  style= 'background:#F4F5BA'  type='hidden' readonly style='width:110' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"]."><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type ='hidden' value ='N'></div></td>";			
					}
					else
					{
						echo "<td width='110'><div align='left'><a href=javascript:Proceso('D','".$Detalle."')>".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."</a><input name='TxtSA'  style= 'background:#F4F5BA'  type='hidden' readonly style='width:110' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type ='hidden' value ='".$Fila["recargo"]."'></div></td>";			
					}
				}
				//�Pregunta si la Solicitud es automatica y  esta en estado  atendida  en muestrera color plomo
				if (($Fila["tipo_solicitud"] == 'A') && ($Fila["estado_actual"] == '13')) 
				{
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]=="")) 
					{
						echo "<td width='110'><div align='left'><a href=javascript:Proceso('D','".$Detalle."')>".$TxtSA = $Fila["nro_solicitud"]."</a><input name='TxtSA'  style= 'background:#BAC8CD' type='hidden' readonly style='width:110' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name = 'TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type ='hidden' value ='N'></div></td>";			
					}
					else
					{
						echo "<td width='110'><div align='left'><a href=javascript:Proceso('D','".$Detalle."')>".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."</a><input name='TxtSA'  style= 'background:#BAC8CD' type='hidden' readonly style='width:110' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input  name ='TxtRecargoO' type ='hidden' value ='".$Fila["recargo"]."'></div></td>";								
					}
				}	
				//�Pregunta si la Solicitud es automatica y  esta en estado  eliminado
				if (($Fila["tipo_solicitud"] == 'A') && ($Fila["estado_actual"] == '7'))
				{
					//pregunta por si es automatica pero sin recargo
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]=="")) 
					{
						echo "<td width='110'><div align='left'><a href=javascript:Proceso('D','".$Detalle."')>".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."</a><input name='TxtSA 'style= 'background:#F4F5BA' type='hidden' readonly style='width:110' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type ='hidden' value ='N'></div></td>";			
					}
					else 
					{
						echo "<td width='110'><div align='left'><a href=javascript:Proceso('D','".$Detalle."')>".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."</a><input name='TxtSA' style= 'background:#F4F5BA'  type='hidden' readonly style='width:110' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type = 'hidden' value ='".$Fila["recargo"]."'></div></td>";			
					}				
				}
				//�Pregunta si la Solicitud es especial y  esta en estado  elimnado
				if (($Fila["tipo_solicitud"] == 'R') && ($Fila["estado_actual"] == '7')) 
				{
					echo "<td width='110'  ><div align='left'><a href=javascript:Proceso('D','".$Detalle."')>".$TxtSA = $Fila["nro_solicitud"]."</a><input name='TxtSA' style= 'background:#F4F5BA'   type='hidden' readonly style='width:110' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name ='TxtSAO' type = 'hidden' value ='".$Fila["nro_solicitud"]."'><input name ='TxtRutO' type = 'hidden' value ='".$Fila["rut_funcionario"]."'><input name ='TxtRecargoO' type = 'hidden' value ='N'></div></td>";
				}
				//Pregunta si  no tiene recargo crea campo oculto lotes con valor N o vacio 
				if ((is_null($Fila["recargo"])) || ($Fila["recargo"] ==''))	
				{
					echo "<td width='103'><div align='left'>".$TxtIdMuestra = $Fila["id_muestra"]."<input name='TxtIdMuestra' type='hidden' readonly style='width:103' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input name='TxtFechaO' type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input name='TxtHoraO' type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."><input name ='TxtLotes' type='hidden' value =''></div></td>";							
				}
				else				
				{//Si tiene recargo crea campo oculto lotes con valor del lote para poder mostrarlo en el detalle de  muestreo
					echo "<td width='103'><div align='left'>".$TxtIdMuestra = $Fila["id_muestra"]."<input name='TxtIdMuestra' type='hidden' readonly style='width:103' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input name='TxtFechaO' type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input name='TxtHoraO'  type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."><input name ='TxtLotes' type='hidden' value ='".$TxtLotes =$Fila["id_muestra"]."'></div></td>";						
				}	
				
				echo "<td width ='150'><div align ='left'>".$TxtProducto=ucwords(strtolower($Fila["nomsubproducto"]))."<input name ='TxtProducto' type='hidden' readonly style='width:150' maxlength='110' value ='".$TxtProducto=ucwords(strtolower($Fila["nomsubproducto"]))."'></div></td>";
				
				echo "<td width ='75'><div align ='left'>".$TxtFuncionario=substr(ucwords(strtolower($Fila["nombreapellido"])),0,1).".".ucwords(strtolower($Fila["ap_paterno"]))." ".substr(ucwords(strtolower($Fila["ap_materno"])),0,1)."."."<input name ='TxtFuncionario' type='hidden' readonly style='width:75' maxlength='120' value ='".$TxtFuncionario=substr(ucwords(strtolower($Fila["nombreapellido"])),0,1).".".ucwords(strtolower($Fila["ap_paterno"]))." ".substr(ucwords(strtolower($Fila["ap_materno"])),0,1)."."." '></div></td>";

				//echo "<td width ='75'><div align ='left'><input name ='TxtFuncionario' type='text' readonly style='width:75' maxlength='120' value ='".$TxtFuncionario=substr(ucwords(strtolower($Fila["nombreapellido"])),0,1)." ".ucwords(strtolower($Fila["ap_paterno"]))."'></div></td>";
				if ($Fila["cod_subclase"]=='2')
					{
						$Fila["nombre_subclase"]='Recep Muestrera';
					
					}
					if ($Fila["cod_subclase"]=='13')
					{
						$Fila["nombre_subclase"]='Aten Muestrera';
					
					}							
				echo "<td width ='90'><div align ='left'>".$TxtEstado= $Fila["nombre_subclase"]."<input name ='TxtEstados' type='hidden' readonly style='width:90' maxlength='70'value ='".$TxtEstado= $Fila["nombre_subclase"]."'></div></td>";
				//Consulta que devuelve la fecha si el estado es Recepcionado en Muestrera o 2   
				$Consulta ="select fecha_hora from estados_por_solicitud  ";
				$Consulta = $Consulta." where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') ";
				$Consulta = $Consulta." and (cod_estado = '1') and recargo = '".$Fila["recargo"]."' "; 
				$Respuesta1 = mysqli_query($link, $Consulta);
				if ($Fila1 = mysqli_fetch_array($Respuesta1))
				{
					//asigna el valor encontrado a fecha de recepcion en caso de que no encuentre nada asigna nulo a FechaRecepcion
					$FechaCreacion = $Fila1["fecha_hora"];		
					echo "<td width ='70'><divalign ='left'>".substr($FechaCreacion,0,10)."<input name ='TxtFechaC' type='hidden' readonly style='width:70' maxlength='70'value ='".$FechaCreacion."'><input name ='TxtHoraR' type='hidden' value =".$TxtHoraR= substr($Fila["FechaAtencion"],11,8)."></div></td>";		
				}
				else
				{ 				
					echo "<td width ='70'><divalign ='left'><input name ='TxtFechaC' type='hidden' readonly style='width:70' maxlength='70'value =''><input name ='TxtHoraR' type='hidden' value =''></div></td>";		
				}
				//Consulta que devuelve la fecha si el estado es Recepcionado en Muestrera o 2   
				/*$Consulta ="select fecha_hora from estados_por_solicitud  ";
				$Consulta = $Consulta." where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') ";
				$Consulta = $Consulta." and (cod_estado = '2') and recargo = '".$Fila["recargo"]."' ";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					//asigna el valor encontrado a fecha de recepcion en caso de que no encuentre nada asigna nulo a FechaRecepcion
					$FechaRecepcion = $Fila2["fecha_hora"];		
					echo "<td width ='70'><divalign ='left'>".substr($FechaRecepcion,0,10)."<input name ='TxtFechaR' type='hidden' readonly style='width:70' maxlength='70'value ='".$FechaRecepcion."'><input name ='TxtHoraR' type='hidden' value =".$TxtHoraR= substr($Fila["FechaAtencion"],11,8)."></div></td>";		
				}
				else
				{ 				
					echo "<td width ='70'><divalign ='left'><input name ='TxtFechaR' type='hidden' readonly style='width:70' maxlength='70'value =''><input name ='TxtHoraR' type='hidden' value =''></div></td>";		
				}

				$Consulta = "select fecha_hora as FechaUltAtencion,ult_atencion from cal_web.estados_por_solicitud where rut_funcionario ='".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and ult_atencion = 'S' and recargo ='".$Fila["recargo"]."'";
				$Respuesta2=mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta2))
					$FechaUltAtencion = $Fila2["FechaUltAtencion"];
				else	
					$FechaUltAtencion ="";
				$Consulta = "select fecha_hora as FechaAtencion from cal_web.estados_por_solicitud where rut_funcionario ='".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and cod_estado ='13' and recargo ='".$Fila["recargo"]."' order by fecha_hora";
				$Respuesta2=mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta2))
						$FechaAtencion = $Fila2["FechaAtencion"];						
				if($CmbEstado=='13' || $CmbEstado=='3')
				{
					echo "<td width ='70'><div align ='left'>".substr($FechaAtencion,0,10)."<input name ='TxtFechaAt' type='hidden' readonly style='width:70' maxlength='70'value ='".$FechaAtencion."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($FechaAtencion,11,8).">&nbsp;</div></td>";
					echo "<td width ='70'><div align ='left'>".substr($FechaUltAtencion,0,10)."<input name ='TxtFechaUlAt' type='hidden' readonly style='width:70' maxlength='70'value ='".$FechaUltAtencion."'>&nbsp;</div></td>";		
				}*/
				/* MFSB - 26-09-2014*/
				//echo "<td width ='70'><div align='left'><a href=JavaScript:Impresion('".$Fila["id_muestra"]."')><img src='../principal/imagenes/img_listado.gif'  align='absmiddle'></a> </div></td>";	
				echo "<td width ='70'><div align='left'><a style='text-decoration:none;border:0;outline:none;' href=JavaScript:Impresion('".$Fila["nro_solicitud"]."','".$Fila["recargo"]."','".$Fila["corr_impresion"]."')>";
				if (is_null($Fila["corr_impresion"]))
					echo "<img src='../principal/imagenes/img_listado.gif' style='border:0'  align='absmiddle'>";
				else
					echo "<img src='../principal/imagenes/ico_ok2.gif' style='border:0' align='absmiddle'>";
				echo "</a>";
				echo " </div></td>";	
				
				echo "</tr>";
		   }
		}	   
	   ?>  	</table>
  	<BR>
		<table width="760" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="25" align="center" valign="middle">Paginas &gt;&gt; 
		    <?php
			if ($Entrar == true){
				//echo $ConsultaPag;
				$Respuesta = mysqli_query($link, $ConsultaPag);
				$Coincidencias=0; //WSO
				while($Row = mysqli_fetch_array($Respuesta))
					$Coincidencias = $Coincidencias+1;
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
						$StrPaginas.=  "<a href=JavaScript:Recarga('cal_adm_solicitud_muestrera.php?CmbEstado=".$CmbEstado."','".($i * $LimitFin)."');>";
						$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
					}
				}
				echo substr($StrPaginas,0,-15);
			}
			?>
    	</td>
		</tr>
        </table>
	<?php
    //if($CmbEstado!='13' && $CmbEstado!='3')//CUANDO ES DISTINTO A ATENDIDA POR MUESTRERA y distinto a laboratorio
	//{
	?>
	<table width="95%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
	  <tr>
	    <td width="104" align="left"><div align="center"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font></font></div></td>
	    <td width="90" align="center"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
	      <input name="BtnImprimir" type="button" id="BtnImprimir" value="Etiqueta" onClick="ImprimirEtiqueta();">
	      </font></font></td>
	    <td width="7"><div align="left">
	      <!--<input name="BtnDetalle" type="button" id="BtnDetalle" value="Detalle" onClick="Proceso('D');">-->
	      <?php
			if ($CmbEstado == '1')
				echo "<input name='BtnModificar' type='button'  value='Modificar' onClick=\"Proceso('M');\">";
			?>
	      </div></td>
	    <td width="67"><?php
			   if ($CmbEstado == '1')
			    {
					echo "<input name='BtnRetalla' type='button'  value='Retalla' onClick=\"Proceso('R');\">";
					//echo "<input type='button' name='Button' value='Fech-Pro' onClick=\"Proceso('A');\">";
               	}
			   ?></td>
	    <?php
			if ($CmbEstado != '3')
			{
				echo "<td width='75' align='left'><input name='BtnEliminar' type='button' value='Eliminar' onClick=\"Proceso('E',' ',' ');\"></td>";
            }
			?>
	    <td width="111" align="left"><input name="BtnActualizar2" type="submit" id="BtnActualizar" value="Actualizar"></td>
	    <td width="298"><?php
			//if ($CmbEstado == '1')
				//echo "<input name='BtnRecepcionar' type='button'  value='Recepcionar' onClick=\"Proceso('R');\">";
		    if ($CmbEstado == '1')
			{
				echo "<input name='CmbTipo' type='hidden' value='3' >";
				echo "<input type='button' name='Button' value='Enviar Lab.' onClick=\"Proceso('FP','$LimitIni');\">";
			}
			?></td>
	    <td width="313"><input name="BtnSalir2" type="button" id="BtnSalir" value="Salir" style="width:60" onClick="Proceso('S');">
	      &nbsp;</td>
	    </tr>
	  </table>	<?php
	/*}
	else//CUANDO ES ATENDIDA POR LA MUESTRERA
	{
	?>
		<table width="95%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >         
		  <tr> 
            <td width="117" align="right">
                <input name="BtnImprimir" type="button" id="BtnImprimir" value="Etiqueta" onClick="ImprimirEtiqueta();"></td>
            <td width="67">
              <?php
			   if (($CmbEstado != '7') && ($CmbEstado !='3')&& ($CmbEstado !='8'))
			    {
					echo "<input name='BtnRetalla' type='button'  value='Retalla' onClick=\"Proceso('R');\">";
					//echo "<input type='button' name='Button' value='Fech-Pro' onClick=\"Proceso('A');\">";
               	}
			   ?>
            </td>
            <td width="375" align="left"><div align="left"> 
               <!--<input name="BtnDetalle" type="button" id="BtnDetalle" value="Detalle" onClick="Proceso('D');">-->
              </div></td>
            <td width="385"><input name="BtnSalir" type="button" id="BtnSalir3" value="Salir" style="width:60" onClick="Proceso('S');"></td>
          </tr>
        </table>      
    <?php
	}*/
	?>      
    </td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje')";
	echo "</script>";
}
?>