<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y H:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut=$_COOKIE["CookieRut"];
$Rut =$CookieRut;
$HoraActual = date("H");
$MinutoActual = date("i");
$CodigoDeSistema = 1;
$CodigoDePantalla = 4;

if(isset($_REQUEST["CmbEstado"])) {
	$CmbEstado = $_REQUEST["CmbEstado"];
}else{
	$CmbEstado = "";
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
if(isset($_REQUEST["CmbAno"])) {
	$CmbAno = $_REQUEST["CmbAno"];
}else{
	$CmbAno =  date("Y");
}
if(isset($_REQUEST["CmbMes"])) {
	$CmbMes = $_REQUEST["CmbMes"];
}else{
	$CmbMes = date("m");
}
if(isset($_REQUEST["CmbDias"])) {
	$CmbDias = $_REQUEST["CmbDias"];
}else{
	$CmbDias =  date("d");
}
if(isset($_REQUEST["CmbAnoT"])) {
	$CmbAnoT = $_REQUEST["CmbAnoT"];
}else{
	$CmbAnoT =  date("Y");
}
if(isset($_REQUEST["CmbMesT"])) {
	$CmbMesT = $_REQUEST["CmbMesT"];
}else{
	$CmbMesT = date("m");
}
if(isset($_REQUEST["CmbDiasT"])) {
	$CmbDiasT = $_REQUEST["CmbDiasT"];
}else{
	$CmbDiasT =  date("d");
}
if(isset($_REQUEST["CmbEstado"])) {
	$CmbEstado = $_REQUEST["CmbEstado"];
}else{
	$CmbEstado = "";
}
if(isset($_REQUEST["CmbTipo"])) {
	$CmbTipo = $_REQUEST["CmbTipo"];
}else{
	$CmbTipo = "";
}
if(isset($_REQUEST["CmbAnoP"])) {
	$CmbAnoP = $_REQUEST["CmbAnoP"];
}else{
	$CmbAnoP =  date("Y");
}
if(isset($_REQUEST["CmbMesP"])) {
	$CmbMesP = $_REQUEST["CmbMesP"];
}else{
	$CmbMesP = date("m");
}
if(isset($_REQUEST["CmbDiasP"])) {
	$CmbDiasP = $_REQUEST["CmbDiasP"];
}else{
	$CmbDiasP =  date("d");
}
if(isset($_REQUEST["HoraAnalisis"])) {
	$HoraAnalisis = $_REQUEST["HoraAnalisis"];
}else{
	$HoraAnalisis =  date("H");
}
if(isset($_REQUEST["MinutosLixiv"])) {
	$MinutosLixiv = $_REQUEST["MinutosLixiv"];
}else{
	$MinutosLixiv =  date("i");
}

$Valores_Check = isset($_REQUEST["Valores_Check"])?$_REQUEST["Valores_Check"]:"";
$FechaAtencion = isset($_REQUEST["FechaAtencion"])?$_REQUEST["FechaAtencion"]:"";
?>
<html>
<head>
<title>Administracion de Solicitudes de Muestreo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion)
{
	var frm=document.FrmMuestrasJefe;
	switch (Opcion)
	{
		case "B": 
			ValidarBuscar();
			break;	
		case "A"://clickeo fecha Proceso
			Recepcionar();
			break;
		case "S":
			Salir();
			break;	
		case "D":
			ValidarDetalle();
			break; 
		case "R":
			ValidarRetalla();
			break;
	
	}	

}
function ImprimirEtiqueta()
{
	var frm=document.FrmMuestrasJefe;
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
function ValidarBuscar()
{
	var frm=document.FrmMuestrasJefe;
	//alert(frm.elements[7].value);
	//alert(frm.elements[4].name);
	if (frm.elements[4].value == "-1")
	{
		alert ("Seleccione un Estado");
		frm.CmbEstado.focus;
		return;
	}
	else
	{
		frm.LimitIni.value=0;
		frm.action ="cal_adm_solicitud_muestreo_jefe.php";  
		frm.submit();
	}
}
function Activar()
{
	var frm=document.FrmMuestrasJefe;
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

//*******************************
//funcion para la fecha de proceso 
function Recepcionar() 
{
	var frm=document.FrmMuestrasJefe;
	var ValoresSA="";	
	if (frm.elements[11].value == -1)
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
function RecuperarSolRecepcionar()
{
	var frm=document.FrmMuestrasJefe;
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

function Salir()
{
	var frm =document.FrmMuestrasJefe;
	frm.action="cal_atencion_solicitud_muestreo01.php?Opcion=S";
	frm.submit(); 
}
//function ValidarDetalle()
function ValidarDetalle()
{
	var frm =document.FrmMuestrasJefe;
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
	var frm=document.FrmMuestrasJefe;
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
function ValidarRetalla()
{
	var frm =document.FrmMuestrasJefe;
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
function Recarga(URL,LimiteIni)
{
	var frm=document.FrmMuestrasJefe;
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "&LimitIni=" + LimiteIni;
	frm.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmMuestrasJefe" method="post" action="">
<?php
/*
	if (!isset($LimitIni))
		$LimitIni = 0;
	*/
?>
 <input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330"  border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="759"><table width="756"border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="75"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
                </strong> </font></font></div>
              Usuario:</td>
            <td width="248"> <strong> 
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
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha: 
              </font></font></font></font></font></font></font></font></font></td>
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>
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
              </strong></font></font></font></strong></font></font></font></font></font></strong></font></font></td>
          </tr>
          <tr> 
            <td height="29"><font size="2">Fecha Inicio: </font></td>
            <td height="29"><font size="2"> 
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
				}/*
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
				}	*/
			  }
			?>
              </select>
              </font> <font size="2"> 
              <select name="CmbMes" size="1" style="width:90px;">
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
              <select name="CmbAno" size="1" style="width:70px;">
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
				}/*
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
				}	*/	
			}
			?>
              </select>
              </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td width="99" height="29">Fecha Termino:</td>
            <td width="307" height="29"> 
              <select name="CmbDiasT" size="1" style="width:40px;">
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
				}/*
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
				}*/	
			}
			?>
              </select>
              <select name="CmbMesT" size="1" style="width:90px;">
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
				
				}	/*
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
				}	*/
		   }
		   ?>
              </select>
              </font></font> <font size="2"> 
              <select name="CmbAnoT" size="1" style="width:70px;">
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
				}/*
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
				}	*/	
			}
			?>
              </select>
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><font size="2">&nbsp;&nbsp;&nbsp;&nbsp;</font></font> 
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; </font></font></font></td>
          </tr>
          <tr> 
            <td height="29"><div align="left"> <font size="1"><font size="2">Estado: 
                </font><font size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font><font size="2"> 
                </font><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></strong></font></font></font></font></font> </div>
              <div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></strong> </font></font></div>
              <div align="right"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></strong></font></font></font></font></font></strong></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></strong></font></font></font></font></font></strong></div>
              <div align="center"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></strong></font></font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></div>
              <div align="center"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></font></div></td>
            <td height="29"><font size="1"><font size="2"> 
              <select name="CmbEstado" style="width:200"  >
                <option value="-1" selected>Seleccionar</option>
                <?php
					$Consulta =  "select * from sub_clase where( cod_clase = 1002 and valor_subclase2 = 1) and (cod_subclase <> 14)  ";
					$Resultado = mysqli_query($link, $Consulta);
					while ($Fila =mysqli_fetch_array ($Resultado))
					{
						if ($CmbEstado == $Fila["cod_subclase"])
						{
							if ($CmbEstado=='3')
							{
								$Fila["nombre_subclase"]= $Fila["nombre_subclase"]." a Laboratorio";
							}
							echo"<option value='".$Fila["cod_subclase"]."'selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>";
						}	
						else 
						{
							if ($Fila["cod_subclase"]=='3')
							{
								$Fila["nombre_subclase"]= $Fila["nombre_subclase"]." a Laboratorio";
							}
							echo"<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
						}
					}
					?>
              </select>
              </font></font></td>
            <td height="29">Lineas por Pág.</td>
            <td height="29"><input name="LimitFin" type="text" value="<?php echo $LimitFin; ?>" size="12" maxlength="12">
              <input name="BtnBuscar" type="button" id="BtnBuscar4" value="Buscar" onClick="Proceso('B');"></td>
          </tr>
        </table>
        <br>
        <table width="756" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
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
					echo "<input type='button' name='Button' value='Fech-Pro' onClick=\"Proceso('A','$LimitIni');\">";
               	}
			   ?>
			    </font></font></div></td>
          </tr>
        </table>
        <br>
        <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        </font></font> 
        <table width="758" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a"  >
          <tr class="ColorTabla01"> 
            <td colspan="2"><div align="center">S.A</div></td>
            <td width="103"><div align="left">Id Muestra</div></td>
            <td width="204"><div align="center"></div>
              <div align="center">Producto</div></td>
            <td width="75"><div align="center">Originador</div></td>
            <td width="113"><div align="center">Estado</div></td>
            <td width="70"><div align="center">F.Atencion</div></td>
            <td width="70"><div align="center">F.Ult.Aten</div></td>
          </tr>
          <?php
	 		include ("../Principal/conectar_cal_web.php");	
			 if(strlen($CmbMes)==1){
				$CmbMes = "0".$CmbMes;
			}
			if(strlen($CmbDias)==1){
				$CmbDias = "0".$CmbDias;
			}
			if(strlen($CmbMesT)==1){
				$CmbMesT = "0".$CmbMesT;
			}
			if(strlen($CmbDiasT)==1){
				$CmbDiasT = "0".$CmbDiasT;
			}
			$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
			$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
			$Entrar = true;
			//echo $CmbEstado."<br>";
			//$Estado="";
			switch ($CmbEstado) 
			{
				//enviado a laboratorio 
				case "3":
					$Estado ="where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and  (t6.cod_estado = '3') ";
					break;
				//eliminado
				case "7":
					$Estado ="where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."') or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and  (t1.estado_actual = '7') ";
					break;
		  		//atendido en muestrera
				case "13": 
		 			$Estado ="where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."')  or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and (t1.estado_actual = '13') ";
					break;
				//pendiente
				case "8":
					$Estado ="where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."') or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and  (t1.estado_actual = '8') ";
					break;
				//activadas
				case "14": 
		 			$Estado ="where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."')  or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and (t1.estado_actual = '13') ";
					break;
				default:
					//$Estado ="where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."')  or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and (t1.estado_actual = '13') ";
					$Entrar = false;
					break;
			}
			if ($Entrar == true)
			{
				$Consulta = "select distinct t1.nro_solicitud,t2.descripcion as nomproducto,t3.descripcion as nomsubproducto,";
				$Consulta = $Consulta."t1.rut_funcionario,t1.recargo,t1.fecha_hora,t1.recargo,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado, ";
				$Consulta = $Consulta."concat(t4.nombres,' ',t4.apellido_paterno,' ',t4.apellido_materno) as nombreapellido, ";
				$Consulta = $Consulta."t4.apellido_paterno as ap_paterno, ";
				$Consulta = $Consulta."t4.apellido_materno as ap_materno, ";
				$Consulta =	$Consulta."t1.nro_solicitud,t1.tipo_solicitud,t1.id_muestra,t1.fecha_hora as FechaCreacion,t7.cod_subclase,t7.nombre_subclase,t6.fecha_hora as FechaAtencion,t6.cod_estado,t6.ult_atencion,t1.recargo ";
				$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
				$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
				$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
				$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
				$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.estado_actual = t6.cod_estado) and (t1.recargo = t6.recargo)";
				$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002'";
				$Consulta = $Consulta.$Estado." order by t1.nro_solicitud,recargo_ordenado";
				$ConsultaPag=$Consulta;
				$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
				//echo $Consulta."<br>";
				echo "<input type='hidden' name='checkAtender'><input name ='TxtSAO' type='hidden'><input name ='TxtRutO' type='hidden'><input name ='TxtRecargoO' type='hidden'><input name ='TxtIdMuestra' type='hidden'><input name ='TxtLotes' type='hidden'><input name ='TxtProducto' type='hidden'>";
				$Respuesta= mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo "<tr>";
					//pregunta para que quede chequeado
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))
						{
							$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."||N"."//";
						}
						else
						{
							$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."||".$Fila["recargo"]."//";
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
						//fin de pregunta para que quede checkeado
					//echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value=''></td>"; 
					if ($Fila["tipo_solicitud"] == 'R') 
					{
						echo "<td width='110'><div align='center'><input name='TxtSA' style= 'background:#F4F5BA' type='text' readonly style='width:110' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name='TxtSAO'  type = 'hidden' value =".$Fila["nro_solicitud"]."><input name='TxtRutO' type = 'hidden' value =".$Fila["rut_funcionario"]."><input name='TxtRecargoO' type = 'hidden' value ='N'><input name ='TxtLotes' type='hidden' value =''></div></td>";
					}
					if ($Fila["tipo_solicitud"] == 'A') 
					{
						if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
						{
							echo "<td width='110'><div align='center'><input name='TxtSA' style= 'background:#F4F5BA' type='text' readonly style='width:110' maxlength='10' value ='".$TxtSA = $Fila["nro_solicitud"]."'><input name='TxtSAO' type = 'hidden' value =".$Fila["nro_solicitud"]."><input name='TxtRutO' type = 'hidden' value =".$Fila["rut_funcionario"]."><input name='TxtRecargoO' type = 'hidden' value ='N'><input   name ='TxtLotes' type='hidden' value =".$TxtLotes =$Fila["id_muestra"]."></div></td>";			
						}	
						else
						{
							echo "<td width='110'><div align='center'><input name='TxtSA' style= 'background:#F4F5BA' type='text' readonly style='width:110' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."><input name='TxtSAO' type = 'hidden' value =".$Fila["nro_solicitud"]."><input name='TxtRutO' type = 'hidden' value =".$Fila["rut_funcionario"]."><input  name='TxtRecargoO' type = 'hidden' value =".$Fila["recargo"]."><input name ='TxtLotes' type='hidden' value =".$TxtLotes =$Fila["id_muestra"]."></div></td>";									
						} 
					}
					echo "<td width='103'><div align='left'><input name='TxtIdMuestra' type='text' readonly style='width:103' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'><input  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
					echo "<td width ='150'><div align ='left'><input name ='TxtProducto' type='text' readonly style='width:150' maxlength='110' value ='".$TxtProducto= ucwords(strtolower($Fila["nomsubproducto"]))."'></div></td>";
					echo "<td width ='75'><div align ='left'><input name ='TxtFuncionario' type='text' readonly style='width:75' maxlength='120' value ='".$TxtFuncionario=substr(ucwords(strtolower($Fila["nombreapellido"])),0,1).".".ucwords(strtolower($Fila["ap_paterno"]))." ".substr(ucwords(strtolower($Fila["ap_materno"])),0,1)."."." '></div></td>";
					if ($Fila["cod_subclase"]=='3')
					{
						$Fila["nombre_subclase"]='Env a Laborat';
					
					}
					if ($Fila["cod_subclase"]=='13')
					{
						$Fila["nombre_subclase"]='Aten Muestrera';
					
					}							
					 
					echo "<td width ='90'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:90' maxlength='70'value ='".$TxtEstado= $Fila["nombre_subclase"]."'><input name ='TxtFuncionario' type='hidden' readonly style='width:120' maxlength='120' value ='".$TxtFuncionario=ucwords(strtolower($Fila["nombreapellido"]))."'></div></td>";
					
					$Consulta = "select fecha_hora as FechaUltAtencion,ult_atencion from cal_web.estados_por_solicitud where rut_funcionario ='".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and ult_atencion = 'S' and recargo ='".$Fila["recargo"]."'";
					$Respuesta2=mysqli_query($link, $Consulta);
					if ($Fila2=mysqli_fetch_array($Respuesta2))
						{
							
							$FechaUltAtencion = $Fila2["FechaUltAtencion"];
							
						}	
						else	
						{
							$FechaUltAtencion ="";
							
						}
					$Consulta = "select fecha_hora as FechaAtencion from cal_web.estados_por_solicitud where rut_funcionario ='".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and cod_estado ='13' and recargo ='".$Fila["recargo"]."' order by fecha_hora";
					$Respuesta2=mysqli_query($link, $Consulta);
					if ($Fila2=mysqli_fetch_array($Respuesta2))
						{
							$FechaAtencion = $Fila2["FechaAtencion"];						
						}
					//echo "<td width ='80'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:80' maxlength='70'value ='".$FechaAtencion=substr($FechaAtencion,0,11)."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($FechaAtencion,11,8)."></div></td>";
					echo "<td width ='70'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:70' maxlength='70'value ='".$FechaAtencion."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($FechaAtencion,11,8)."></div></td>";
					echo "<td width ='70'><div align ='left'><input name ='TxtFechaUlAt' type='text' readonly style='width:70' maxlength='70'value ='".$FechaUltAtencion."'></div></td>";		
					echo "</tr>";
				 }
	   }
	   ?>
        </table>
        <table width="758" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="25" align="center" valign="middle">Paginas &gt;&gt; >
			<?php 
			//echo "Estado:".$Estado."<br>";

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
					{
						$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
					}
					else
					{
						$StrPaginas.=  "<a href=JavaScript:Recarga('cal_adm_solicitud_muestreo_jefe.php?CmbEstado=".$CmbEstado."','".($i * $LimitFin)."');>";
						$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
					}
				}
				echo substr($StrPaginas,0,-15);	
		    }		
			?>
			</td>
          </tr>
        </table>
        <table width="759" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >         
		  <tr> 
            <td width="93">
                <input name="BtnImprimir" type="button" id="BtnImprimir" value="Etiqueta" onClick="ImprimirEtiqueta();"></td>
            <td width="94">
              <?php
			   if (($CmbEstado != '7') && ($CmbEstado !='3')&& ($CmbEstado !='8'))
			    {
					echo "<input name='BtnRetalla' type='button'  value='Retalla' onClick=\"Proceso('R');\">";
					//echo "<input type='button' name='Button' value='Fech-Pro' onClick=\"Proceso('A');\">";
               	}
			   ?>
            </td>
            <td width="188"><div align="center"> 
                <input name="BtnDetalle" type="button" id="BtnDetalle" value="Detalle" onClick="Proceso('D');">
              </div></td>
            <td width="375"><input name="BtnSalir" type="button" id="BtnSalir3" value="Salir" style="width:60" onClick="Proceso('S');"></td>
          </tr>
        </table></td>
    </tr>
  </table>
 <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
