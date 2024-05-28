<?php

$CodigoDeSistema = 1;
$CodigoDePantalla = 6;
include("../principal/conectar_principal.php");
$CookieRut=$_COOKIE["CookieRut"];
$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];
$Fecha_Hora = date("d-m-Y H:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =  $CookieRut;
$HoraActual   = date("H");
$MinutoActual = date("i");

$CmbAno   = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
$CmbMes   = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
$CmbDias  = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:date("d");
$CmbAnoT  = isset($_REQUEST["CmbAnoT"])?$_REQUEST["CmbAnoT"]:date("Y");
$CmbMesT  = isset($_REQUEST["CmbMesT"])?$_REQUEST["CmbMesT"]:date("m");
$CmbDiasT = isset($_REQUEST["CmbDiasT"])?$_REQUEST["CmbDiasT"]:date("d");
$Mostrar  = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
$CmbEstado      = isset($_REQUEST["CmbEstado"])?$_REQUEST["CmbEstado"]:"";
$CmbProductos   = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:"";
$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
$AnoBuscadoIni  = isset($_REQUEST["AnoBuscadoIni"])?$_REQUEST["AnoBuscadoIni"]:date("Y");
$AnoBuscadoFin  = isset($_REQUEST["AnoBuscadoFin"])?$_REQUEST["AnoBuscadoFin"]:date("Y");
$TxtSa          = isset($_REQUEST["TxtSa"])?$_REQUEST["TxtSa"]:0;
$TxtSaFin       = isset($_REQUEST["TxtSaFin"])?$_REQUEST["TxtSaFin"]:0;
$checkTodos     = isset($_REQUEST["checkTodos"])?$_REQUEST["checkTodos"]:"";
$LimitIni       = isset($_REQUEST["LimitIni"])?$_REQUEST["LimitIni"]:0;
$LimitFin       = isset($_REQUEST["LimitFin"])?$_REQUEST["LimitFin"]:30;
$Valores_Check  = isset($_REQUEST["Valores_Check"])?$_REQUEST["Valores_Check"]:"";

?>
<html>
<head>
<title>Administracion de Solicitudes de Muestreo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
<!--LAYERS
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false

function muestra(numero) 
{
	//alert(numero);
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 130 ");
			//eval("Txt" + numero + ".style.top = document.checkTodos.top ");
			//eval("Txt" + numero + ".style.top = window.event.y ");
		}
	}
}

function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
// FIN LAYERS-->
function Proceso(Opcion)
{
	var frm=document.FrmIngLeyes;
	switch (Opcion)
	{
		case "R":
			frm.action="cal_adm_ingreso_leyes.php";
			frm.submit();
			break;
		case "B": 
			if (isNaN(parseInt(frm.LimitFin.value)))
			{
				alert("Valor Ingresado Invalido");
				frm.LimitFin.focus();
				return;
			}
			if (parseInt(frm.LimitFin.value)<=0)
			{
				alert("Valor mayor que Cero");
				frm.LimitFin.focus();				
				return;
			}
			Buscar();
			break;	
		case "I":
			RecuperarSA();
			break;
	
		case "S":
			Salir();
			break;	
		case "O":
			frm.action="cal_adm_ingreso_leyes.php?Mostrar=O";
			frm.submit();
			break;
	}	
}
function Activar()
{
	
	var frm=document.FrmIngLeyes;
	var LargoForm = frm.elements.length;
	for (i=0; i< LargoForm; i++ )
	{
	if (frm.elements[i].name == "checkAtender") 
		{
			if (frm.checkTodos.checked == true)
			{
				frm.elements[i].checked = true;
			}
			else 
			{
				frm.elements[i].checked = false;		
			}
		}
	}
}
//funcion que recupera la solicitud de analisis y el rut del funcionario que creo la solicitud para enviarlas a ingreso de leyes
function RecuperarSA()
{
	var frm=document.FrmIngLeyes;
	var LargoForm = frm.elements.length;
	var ValoresSA="";
	var CheckeoAtencion="";
	var Solicitudes ="";
	var Producto ="";
	var SubProducto ="";
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
		{
			//Contiene la SA y RutF
			ValoresSA = ValoresSA + frm.elements[i+2].value + "~~" + frm.elements[i+3].value + "||" + frm.elements[i+4].value  + "//" ;
			CheckeoAtencion = true;
		}
	}
	if (CheckeoAtencion == false)
	{
		alert ("No Hay Elementos Seleccionados");
	}
	else
	{
		window.open("cal_ingreso_leyes.php?ValoresSA="+ ValoresSA + "&Producto="+frm.CmbProductos.value + "&SubProducto="+frm.CmbSubProducto.value,"","top=200,left=35,width=640,height=300,scrollbars=no,resizable = yes");					
	}
}
function Salir()
{
	var frm =document.FrmIngLeyes;
	frm.action="cal_adm_ingreso_leyes01.php?Opcion=S";
	frm.submit(); 
}
function PorAtender()
{
	var frm =document.FrmIngLeyes;
	var ValoresSA="";
	
	ValoresSA=RecuperarSolicitudCheckeadas();
	frm.action="cal_adm_ingreso_leyes01.php?Opcion=P&ValoresSA="+ValoresSA;
	frm.submit(); 
}

function Buscar()
{
	var frm=document.FrmIngLeyes;
	frm.action ="cal_adm_ingreso_leyes.php?Mostrar=S";  
	frm.submit();
		
}
function Mostrar(Pantalla)
{
	var Frm=document.FrmIngLeyes;
	var ValoresSA="";
	if (CheckeoSolicitud())
	{
		switch (Pantalla)
		{
			case "L":
				if(!EncontroSAconRecargo())			
				{
					ValoresSA=RecuperarSolicitudCheckeadas();
					window.open("cal_ingreso_valor_leyes.php?ValoresSA="+ValoresSA,"","top=130,left=120,width=533,height=480,scrollbars=yes,resizable = no");
				}
				else
				{
					alert ("Valores de Leyes solo al Recargo Nro.0 ");
				}	
				break;
			case "I":		
				if(!EncontroSAconRecargo())			
				{
					ValoresSA=RecuperarSolicitudCheckeadas();		
					window.open("cal_ingreso_valor_impurezas.php?ValoresSA="+ValoresSA,"","top=130,left=120,width=533,height=380,scrollbars=yes,resizable = no");
				}	
				else
				{
					alert ("Valores de Leyes solo al Recargo Nro.0 ");
				}	
				break;
			case "H":
				ValoresSA=RecuperarSolicitudCheckeadas();		
				window.open("cal_ingreso_valor_humedad.php?ValoresSA="+ValoresSA,"","top=130,left=15,width=750,height=380,scrollbars=yes,resizable = no");
				break;						
			case "R":
				//if(SoloUnoSeleccionado())
				//{
					//if(EncontroRetalla())
					//{	
						ValoresSA=RecuperarSolicitudRetallaCheckeadas();		
						if (ValoresSA!="")
						{
							window.open("cal_ingreso_valor_retalla.php?ValoresSA="+ValoresSA,"","top=130,left=120,width=533,height=380,scrollbars=yes,resizable = no");
						}
					//}
					//else
					//{
					//	alert ("Ingreso valor solo para el recargo 'R'");
					//}
				//}
				//else
				//{
				//	alert ("Debe seleccionar solo una Solicitud");
				//}	
				break;
			case "A":
				if(!EncontroSAconRecargo())			
				{
					ValoresSA=RecuperarSolicitudCheckeadas();
					window.open("cal_ingreso_valor_leyes.php?ValoresSA="+ValoresSA,"","top=130,left=120,width=533,height=320,scrollbars=yes,resizable = no");
				}
				else
				{
					alert ("Valores de Leyes solo al Recargo Nro.0 ");
				}	
				break;
		}
	}
	else
	{
		alert ("Debe Seleccionar Solicitud");
	}
		
}
function CheckeoSolicitud()
{
//ESTA FUNCION DEVUELVE VERDADERO SI ENCUENTRA A LO MENOS UNA SOLICITUD CHECKEADA
	var Frm=document.FrmIngLeyes;
    for (i=0;i<Frm.elements.length;i++)
	{
		if ((Frm.elements[i].name == "checkAtender") && (Frm.elements[i].checked == true))
		{
            return(true);	
		 	break;
		}
	}
}
function RecuperarSolicitudCheckeadas()
{
	var Frm=document.FrmIngLeyes;
	var ValoresSA ="";
	for (i=1;i<Frm.checkAtender.length;i++)
	{
		if (Frm.checkAtender[i].checked == true)
		{
			ValoresSA = ValoresSA + Frm.TxtSAO[i].value + "~~" + Frm.TxtRutO[i].value + "||" + Frm.TxtRecargoO[i].value  + "//";
		}
	}
	return(ValoresSA);	
}

function RecuperarSolicitudRetallaCheckeadas()
{
	var Frm=document.FrmIngLeyes;
	var ValoresSA ="";
	for (i=1;i<Frm.checkAtender.length;i++)
	{
		if (Frm.checkAtender[i].checked == true)
		{
			if (Frm.TxtRecargoO[i].value=="R")
			{
				ValoresSA = ValoresSA + Frm.TxtSAO[i].value + "~~" + Frm.TxtRutO[i].value + "||" + Frm.TxtRecargoO[i].value  + "//";
			}	
		}
	}
	return(ValoresSA);	
}

function EncontroSAconRecargo()
{
	var Frm=document.FrmIngLeyes;
	var Resultado=false;
    for (i=1;i<Frm.checkAtender.length;i++)
	{
		if (Frm.checkAtender[i].checked == true)
		{
			if ((Frm.TxtRecargoO[i].value != "N") && (Frm.TxtRecargoO[i].value != "0"))
			{
				Resultado=true;
				break;
			}
		}
	}
	return(Resultado);	
}
function EncontroRetalla()
{
	var Frm=document.FrmIngLeyes;
	var Resultado=true;
    for (i=1;i<Frm.checkAtender.length;i++)
	{
		if (Frm.checkAtender[i].checked == true)
		{
			if (Frm.TxtRecargoO[i].value != "R")
			{
				Resultado=false;
				break;
			}
		}
	}
	return(Resultado);	
}
function SoloUnoSeleccionado()
{
	var Frm=document.FrmIngLeyes;
	var Cont=0;
    for (i=1;i<Frm.checkAtender.length;i++)
	{
		if (Frm.checkAtender[i].checked == true)
		{
			Cont=Cont+1;
		}
	}
	if (Cont>1)
	{
		return(false);
	}
	else
	{
		return(true);
	}		
}
function Detalle()
{
	var frm =document.FrmIngLeyes;
	var Checkeada = "";
	var Recargo = "";
	for (i=1;i<frm.checkAtender.length;i++)
	{
		if (frm.checkAtender[i].checked==true)
		{
			Checkeada = frm.TxtSAO[i].value ;
			Recargo=frm.TxtRecargoO[i].value ;
			var URL = "cal_con_registro_leyes_solo.php?SA="+ Checkeada+"&Recargo="+Recargo;
			window.open(URL,'',"top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
			break;
		}	
	}
}
function Recarga(URL)
{
	var frm=document.FrmIngLeyes;
	frm.action=URL;
	frm.submit(); 
}
function ValidarModificar()
{
	var frm=document.FrmIngLeyes;
	var Cont=0;
	Encontro=false;

	for (i=1;i<frm.checkAtender.length;i++)
	{
		if (frm.checkAtender[i].checked==true)
		{
			Cont=Cont+1;
			if (Cont >1)
			{
				//nada
			}
			else
			{ 
				Sol=frm.TxtSAO[i].value;
				Rec=frm.TxtRecargoO[i].value;
			}
			Encontro=true;
		}
	}	
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
	window.open("cal_leyes_por_solicitud_modificar.php?Sol="+Sol+"&Rec="+Rec,""," fullscreen=yes,width=800,height=600,scrollbars=yes,resizable = yes");		
}	

</script></head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmIngLeyes" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770"  border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="759"> <table width="756"border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td>Usuario: </td>
            <td> 
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
            </td>
            <td>Fecha: </td>
            <td> 
              <?php echo $Fecha_Hora ?>
              <?php
			//creacion de campo oculto para almacenar la fecha y hora si no existe lo crea en caso contraria le asigana la feha hora del sistema 
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
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="97" height="32">Fecha Inicio: </td>
            <td width="233" height="32"><select name="CmbDias" size="1" style="width:42px;">
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
				}*/	
			  }
			?>
              </select> <select name="CmbMes" size="1" style="width:100px;">
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
				
				}/*	
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
				}*/	
			}
		    ?>
              </select> <select name="CmbAno" size="1" style="width:70px;">
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
				}*/		
			}
			
			?>
              </select></td>
            <?php 
			   /*echo "Nivel:".$Nivel."<br>";
			   echo "Estado:".$CmbEstado."<br>";
			   $Letra=substr($CmbEstado,strlen($CmbEstado)-1,1);
			   echo "Letra:".$Letra."<BR>";
			   /*$CmbEstado=substr($CmbEstado,0,strlen($CmbEstado)-1);
			   echo "Estado:".$CmbEstado."<BR>";*/
			 ?>
            <td width="96" height="32">Fecha Termino: </td>
            <td width="220" height="32"><select name="CmbDiasT" size="1" style="width:42px;">
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
              </select> <select name="CmbMesT" size="1" style="width:100px;">
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
              </select> <select name="CmbAnoT" size="1" style="width:70px;">
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
              </select></td>
            <td width="77">&nbsp;</td>
          </tr>
          <tr> 
            <td height="29">Producto: </td>
            <td height="29"><select name="CmbProductos" style="width:220" onChange="Proceso('R');">
                <option value='-1' selected>Todos</option>
                <?php
				$Consulta="SELECT cod_producto,descripcion from productos order by descripcion"; 
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
			?>
              </select></td>
            <td height="29">Sub Producto: </td>
            <td height="29"><select name="CmbSubProducto" style="width:220" >
                <option value="-1" selected>Seleccionar</option>
                <?php
			$Consulta="SELECT cod_subproducto,descripcion from proyecto_modernizacion.subproducto where cod_producto = '".$CmbProductos."'"; 
			//echo $Consulta."<br>";
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
		?>
              </select></td>
            <td height="29">&nbsp;</td>
          </tr>
          <tr> 
            <td height="26"> Estado: </td>
            <td height="26"> <select name="CmbEstado" style="width:220"  >
                <option value="-1" selected>Todas</option>
                <?php
				 $CmbEstadoAux=$CmbEstado;
				 if ($Mostrar=="S")
				 {
					if (($Nivel=="1")||($Nivel=="2")||($Nivel=="3")||($Nivel=="12"))
					{
						if ($CmbEstado!="-1")
						{
							$CmbEstado=substr($CmbEstado,0,strlen($CmbEstado)-1);
						}	
					}
				 }
				 $Consulta =  "select * from sub_clase where cod_clase = 1002 and (cod_subclase ='5' or cod_subclase = '6')";
				 $Resultado = mysqli_query($link, $Consulta);
				 while ($Fila =mysqli_fetch_array ($Resultado))
				 {
					if ($CmbEstado == $Fila["cod_subclase"])
					{
						if ($Fila["cod_subclase"]=="5")
						{
							switch ($Nivel)
							{
								case "5":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Atendido Quimico Analitico</option>";
									break;
								case "6":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Atendido Quimico Analitico</option>";
									break;
								
								case "10":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Atendido Quimico Fisico</option>";
									
									break;
								default:
									if ((substr($CmbEstadoAux,strlen($CmbEstadoAux)-1,1))=="Q")
									{
										echo"<option value='".$Fila["cod_subclase"]."Q' selected>Atendido Quimico Analitico</option>";
										echo"<option value='".$Fila["cod_subclase"]."F'>Atendido Quimico Fisico</option>";
									}
									else
									{	
										echo"<option value='".$Fila["cod_subclase"]."Q'>Atendido Quimico Analitico</option>";
										echo"<option value='".$Fila["cod_subclase"]."F' selected>Atendido Quimico Fisico</option>";
									}	
									break;
							}		
						}
						if ($Fila["cod_subclase"]=="6")
						{
							switch ($Nivel)
							{
								case "5":
									echo"<option value='".$Fila["cod_subclase"]."'>Finalizada en Laboratorio</option>";
									break;
								case "6":
									echo"<option value='".$Fila["cod_subclase"]."'>Finalizada en Laboratorio</option>";
									break;
									
									
								case "10":
									echo"<option value='".$Fila["cod_subclase"]."'>Finalizada en Ensayo Fisico</option>";
									
									break;
								default:
									if ((substr($CmbEstadoAux,strlen($CmbEstadoAux)-1,1))=="Q")
									{
										echo"<option value='".$Fila["cod_subclase"]."Q' selected>Finalizada en Laboratorio</option>";
										echo"<option value='".$Fila["cod_subclase"]."F'>Finalizada en Ensayo Fisico</option>";
									}	
									else
									{
										echo"<option value='".$Fila["cod_subclase"]."Q'>Finalizada en Laboratorio</option>";
										echo"<option value='".$Fila["cod_subclase"]."F' selected>Finalizada en Ensayo Fisico</option>";
									}	
									break;
							}		
						}
					}	
					else 
					{
						if ($Fila["cod_subclase"]=="5")
						{
							switch ($Nivel)
							{
								case "5":
									echo"<option value='".$Fila["cod_subclase"]."'>Atendido Quimico Analitico</option>";
									break;
								case "6":
									echo"<option value='".$Fila["cod_subclase"]."'>Atendido Quimico Analitico</option>";
									break;
								
								case "10":
									echo"<option value='".$Fila["cod_subclase"]."'>Atendido Quimico Fisico</option>";
									
									break;
								default:
									echo"<option value='".$Fila["cod_subclase"]."Q'>Atendido Quimico Analitico</option>";
									echo"<option value='".$Fila["cod_subclase"]."F'>Atendido Quimico Fisico</option>";
									break;
							}		
						}
						if ($Fila["cod_subclase"]=="6")
						{
							switch ($Nivel)
							{
								case "5":
									echo"<option value='".$Fila["cod_subclase"]."'>Finalizada en Laboratorio</option>";
									break;
								case "6":
									echo"<option value='".$Fila["cod_subclase"]."'>Finalizada en Laboratorio</option>";
									break;
									
								case "10":
									echo"<option value='".$Fila["cod_subclase"]."'>Finalizada en Ensayo Fisico</option>";
									
									break;
								default:
									echo"<option value='".$Fila["cod_subclase"]."Q'>Finalizada en Laboratorio</option>";
									echo"<option value='".$Fila["cod_subclase"]."F'>Finalizada en Ensayo Fisico</option>";
									break;
							}		
						}
					}
				 }
				 $CmbEstado= $CmbEstadoAux;
			 ?>
              </select></td>
            <td height="26">Lineas por Pág.:</td>
            <td><input name="LimitFin" type="text" value="<?php echo $LimitFin; ?>" size="15" maxlength="15"></td>
            <td><input name="BtnBuscar" type="Button" style="width:70" value="Buscar" onClick="Proceso('B');"></td>
          </tr>
        </table>
		  
        <br>
        <table width="756"border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="97" height="29">#Solicitud Inicial: </td>
            <td width="155" height="29"> <select name="AnoBuscadoIni" id="AnoBuscadoIni" style="width:70px;">
                <?php
			for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoBuscadoIni))
				{
					if ($i==$AnoBuscadoIni)
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
              </select> <input name="TxtSa" type="text"  size="12" maxlength="12" value="<?php echo $TxtSa; ?>"> 
            </td>
            <td width="116">#Solicitud Termino:</td>
            <td width="151"><select name="AnoBuscadoFin" id="AnoBuscadoFin" style="width:70px;">
                <?php
			for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoBuscadoFin))
				{
					if ($i==$AnoBuscadoFin)
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
              <input name="TxtSaFin" type="text" id="TxtSaFin" value="<?php echo $TxtSaFin; ?>"  size="12" maxlength="12"></td>
            <td width="204"><input name="BtnOk" type="button" value="Buscar" onClick="Proceso('O');"  ></td>
          </tr>
        </table>
        <br>
        <table width="756" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="41">
              <input name="checkTodos" type="checkbox" onClick="JavaScript:Activar();" value="checkbox">
              Todos</td>
            <td width="111">
              <input name="BtnActualizar" type="submit" id="BtnActualizar2" value="Actualizar" style="width:110">
            </td>
            <?php
				if ($Mostrar=="O")
				{
						echo "<td width='111'><input name='BtnLeyesHum' type='button' value='Valor Leyes Hum.' style='width:110' onClick=\"Mostrar('H');\"></td>";
						echo "<td width='113'><input name='BtnLeyes' type='button' id='BtnLeyes' value='Elementos Analizar' style='width:130' onClick=\"Mostrar('L');\"></td>";
						//echo "<td width='115'><input name='BtnImpureza' type='button' id='BtnImpureza' value='Valor Impurezas' style='width:110' onClick=\"Mostrar('I');\"></td>";
						echo "<td width='226'><input name='BtnRetalla' type='button' value='Valor Retalla' style='width:110' onClick=\"Mostrar('R');\"></td>";
						echo "<td width='226'><input name='BtnModLeyes' type='button' value='Modificar Leyes' style='width:110' onclick=\"ValidarModificar();\"'></td>";
				}	
				else
				{
					$Letra="";
					$CmbEstado=$CmbEstadoAux;
					if (($Nivel=="1")||($Nivel=="2")||($Nivel=="3")||($Nivel=="12"))
					{
						$Letra=substr($CmbEstado,strlen($CmbEstado)-1,1);
						if ($CmbEstado!="-1")
						{
							$CmbEstado=substr($CmbEstado,0,strlen($CmbEstado)-1);
						}	
					}
					if(($CmbEstado=="5")||($CmbEstado=="6"))
					{
						if (($Letra=="Q") ||($Letra==""))
						{
							echo "<td width='111'><input name='BtnLeyesHum' type='button' value='Valor Leyes Hum.' style='width:110' onClick=\"Mostrar('H');\"></td>";
							echo "<td width='113'><input name='BtnLeyes' type='button' id='BtnLeyes' value='Elementos Analizar' style='width:130' onClick=\"Mostrar('L');\"></td>";
							//echo "<td width='115'><input name='BtnImpureza' type='button' id='BtnImpureza' value='Valor Impurezas' style='width:110' onClick=\"Mostrar('I');\"></td>";
							echo "<td width='226'><input name='BtnRetalla' type='button' value='Valor Retalla' style='width:110' onClick=\"Mostrar('R');\"></td>";
							echo "<td width='226'><input name='BtnModLeyes' type='button' value='Modificar Leyes' style='width:110' onclick=\"ValidarModificar();\"'></td>";
						}
						else
						{
							echo "<td width='113'><input name='BtnLeyes' type='button' id='BtnLeyes' value='Elementos Analizar' style='width:130' onClick=\"Mostrar('L');\"></td>";						
							echo "<td width='113'></td>";
							echo "<td width='115'></td>";
							echo "<td width='226'></td>";
							echo "<td width='226'><input name='BtnModLeyes' type='button' value='Modificar Leyes' style='width:110' onclick=\"ValidarModificar();\"'></td>";
						}	
					}
					else
					{
						if(($CmbEstado=="-1") && (($Nivel=="1")||($Nivel=="2")||($Nivel=="3")||($Nivel=="12")||($Nivel=="5")|| ($Nivel=='6')))
						{
							echo "<td width='111'><input name='BtnLeyesHum' type='button' value='Valor Leyes Hum.' style='width:110' onClick=\"Mostrar('H');\"></td>";
							echo "<td width='113'><input name='BtnLeyes' type='button' id='BtnLeyes' value='Elementos Analizar' style='width:130' onClick=\"Mostrar('L');\"></td>";
							//echo "<td width='115'><input name='BtnImpureza' type='button' id='BtnImpureza' value='Valor Impurezas' style='width:110' onClick=\"Mostrar('I');\"></td>";
							echo "<td width='226'><input name='BtnRetalla' type='button' value='Valor Retalla' style='width:110' onClick=\"Mostrar('R');\"></td>";
							echo "<td width='226'><input name='BtnModLeyes' type='button' value='Modificar Leyes' style='width:110' onclick=\"ValidarModificar();\"'></td>";
						}
						else
						{
						/*	echo "<td width='111'><input name='BtnAtender' type='button' value='Por Atender' style='width:110' onClick=\"PorAtender();\"></td>";
							echo "<td width='113'></td>";
							echo "<td width='115'></td>";
							echo "<td width='226'></td>";*/
						}	
					}
				}	
			?>
              <!--<input name='BtnFinalizar' type='hidden' style='width:110' value='Finalizar S.A' onClick='FinalizarProcesoSA();'>-->
          </tr>
        </table>
        <br>
        <table width="758" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
          <tr class="ColorTabla01"> 
            <td colspan="2"><div align="center">S.A</div></td>
            <td width="92">Id Muestra</td>
            <td width="80"><div align="center">SubProducto</div></td>
            <td width="118"><div align="center">Estado </div></td>
            <td width="75"><div align="center">F.Recepcion</div></td>
            <td width="82"><div align="center">F.Quimico</div></td>
            <td width="52"><div align="center">Leyes</div></td>
            <td width="75"><div align="center">Candado</div></td>
          </tr>
          <?php
	 	include ("../Principal/conectar_cal_web.php");	
		$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
		$ValoresOk = true;
		$CmbEstado=$CmbEstadoAux;
		if (($Nivel=="1")||($Nivel=="2")||($Nivel=="3")||($Nivel=="12"))
		{
			$Letra=substr($CmbEstado,strlen($CmbEstado)-1,1);
			if ($CmbEstado!="-1")
			{
				$CmbEstado=substr($CmbEstado,0,strlen($CmbEstado)-1);
			}	
		}	
		$TipoAnalisis=""; //WSO
		switch ($Nivel)
		{
			case "1":
				if ($Letra == 'F')
				{
					//$TipoAnalisis=" and (t1.cod_analisis='1' or t1.cod_analisis='2')";
					$TipoAnalisis=" and (t1.cod_analisis='2')";
				}
				if ($Letra == 'Q')
				{
					$TipoAnalisis=" and (t1.cod_analisis='1')";
				}
				break;
			case "2":
				if ($Letra == 'F')
				{
					$TipoAnalisis=" and (t1.cod_analisis='2')";
				}
				if ($Letra == 'Q')
				{
					$TipoAnalisis=" and (t1.cod_analisis='1')";
				}
				break;
			case "3":
				if ($Letra == 'F')
				{
					$TipoAnalisis=" and (t1.cod_analisis='2')";
				}
				if ($Letra == 'Q')
				{
					$TipoAnalisis=" and (t1.cod_analisis='1')";
				}
				break;
			case "5":
				$TipoAnalisis=" and (t1.cod_analisis='1')";
				break;				
			case "6":
				if ($Letra =='Q')
				{
					$TipoAnalisis=" and (t1.cod_analisis='1')";
				}
				
				break;				
			case "10":
				$TipoAnalisis=" and (t1.cod_analisis='2')";
				break;
			case "12":
				if ($Letra =="Q")
				{
					$TipoAnalisis=" and (t1.cod_analisis='1')";
				}
				else
				{
					$TipoAnalisis=" and (t1.cod_analisis='2')";
				}	
				break;
		}
		$Estado="";
		if ($Mostrar=='S')
		{
			//BUSCAR POR PRODUCTO Y SUBPRODUCTO Y FECHA
			
			if (($CmbProductos!=-1) && ($CmbSubProducto!= -1))
			{
				switch ($CmbEstado) 
				{
					case "-1":
						$Estado ="where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '4' or t1.estado_actual = '5' or estado_actual = '6') and (t1.cod_producto = '".$CmbProductos."' and t1.cod_subproducto = '".$CmbSubProducto."')";
						break;
					case "4":
						$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '4') and (t1.cod_producto = '".$CmbProductos."' and t1.cod_subproducto = '".$CmbSubProducto."')".$TipoAnalisis;
						break;		 
					case "5": 
						$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '5') and (t1.cod_producto = '".$CmbProductos."' and t1.cod_subproducto = '".$CmbSubProducto."')".$TipoAnalisis;
						break;
					case "6": 
						$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '6') and (t1.cod_producto = '".$CmbProductos."' and t1.cod_subproducto = '".$CmbSubProducto."')".$TipoAnalisis;
						break;
						
					default:
						$Estado ="where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '4' or t1.estado_actual = '5') and (t1.cod_producto = '".$CmbProductos."' and t1.cod_subproducto = '".$CmbSubProducto."')";
						break;
				}
				$Consulta = "select t1.fecha_hora,t1.estado_actual,t2.descripcion as nomproducto,t3.abreviatura as nomsubproducto, ";
				$Consulta = $Consulta."t1.rut_funcionario,t1.recargo,t1.cod_analisis,t1.id_muestra, ";
				$Consulta =	$Consulta."t1.nro_solicitud,t1.tipo_solicitud,t6.fecha_hora as FechaRecepcion,t7.nombre_subclase,t6.cod_estado,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
				$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
				$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
				$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
				$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
				$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual = t6.cod_estado)";
				$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002'";
				$Consulta = $Consulta.$Estado." order by t1.nro_solicitud,recargo_ordenado";
				$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
				$Respuesta= mysqli_query($link, $Consulta);
				$Cont=1;
				$EncontroValor= false;
				$EncontroCandado=false;
				echo "<input type='hidden' name ='checkAtender'><input type = 'hidden' name = 'TxtSAO'><input type = 'hidden' name ='TxtRutO'><input type = 'hidden' name = 'TxtRecargoO' value ='N'><input type = 'hidden' name = 'TxtCandado'><input type = 'hidden' name = 'TxtLeyes'></div></td>";
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					//ANALITOS
					$Analitos="";
					$Consulta ="select t0.agrupacion, t0.tipo, t2.abreviatura ";
					$Consulta.= " from cal_web.solicitud_analisis t0 inner join cal_web.leyes_por_solicitud t1 ";
					$Consulta.= " on t0.nro_solicitud = t1.nro_solicitud and t0.recargo = t1.recargo ";
					$Consulta.= " inner join proyecto_modernizacion.leyes t2 ";
					$Consulta.= " on t1.cod_leyes = t2.cod_leyes ";
					$Consulta.= " where t0.nro_solicitud = '".$Fila["nro_solicitud"]."' and t0.recargo = '".$Fila["recargo"]."' ";
					$Consulta.= " order by t1.cod_leyes";
					//echo $Consulta."<br>";
					$Respuesta3 = mysqli_query($link, $Consulta);
					while ($Fila3 = mysqli_fetch_array($Respuesta3))
					{
						$Analitos = $Analitos."".$Fila3["abreviatura"].", ";
						$CodAgrupacion = $Fila3["agrupacion"];
						$CodTipo = $Fila3["tipo"];
						//echo "FechaMuestreo".$TxtFechaMuestreo."<br>";
					}
					//AGRUPACION
					$Consulta ="select distinct t2.nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
					$Consulta =$Consulta." where t2.cod_clase = '1004' and t2.cod_subclase = '".$CodAgrupacion."'  "; 
					$Resp = mysqli_query($link, $Consulta); 
					$Fila25=mysqli_fetch_array($Resp);
					$Agrupacion = $Fila25["nombre_subclase"];
					//TIPO
					$Consulta ="select distinct t2.nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
					$Consulta =$Consulta." where t2.cod_clase = '1005' and t2.cod_subclase = '".$CodTipo."' ";
					$Res = mysqli_query($link, $Consulta); 
					$Fil26=mysqli_fetch_array($Res);
					$Tipo = $Fil26["nombre_subclase"];
					//FECHA RECEPCION
					$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = ".$Fila["nro_solicitud"].") and (cod_estado = '4')";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$TxtFechaRecepcion = $Fila2["fecha_hora"];
					}	
					$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and (cod_estado = '5') ";
					$Respuesta3 = mysqli_query($link, $Consulta);
					if ($Fila3 = mysqli_fetch_array($Respuesta3))
					{
						$TxtFechaAtencion = $Fila3["fecha_hora"];
					}	
					echo "<tr>";
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))
					{
						$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."||N";
					}
					else
					{
						$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."||".$Fila["recargo"];
					}
					$pos = strpos($Valores_Check, $SAChequear);
					if ($pos === false)
					{ 
						echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value='".$Cont."'></td>"; 
					}
					else
					{
						echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value='".$Cont."' checked></td>"; 
					}	
					$Cont=$Cont+1;
					//if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
					//{
					//solicitud especial
					if ($Fila["tipo_solicitud"] == 'R') 
					{	
						echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
						echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
						echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
						echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
						echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
						echo "</div>\n";
						echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA' readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"]."'>".$Fila["nro_solicitud"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='N'></div></td>";
					}
					//solicitud automatica
					if ($Fila["tipo_solicitud"] == 'A') 
					{	
						if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
						{	
							echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
							echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
							echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
							echo "</div>\n";
							echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA' readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"]."'>".$Fila["nro_solicitud"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='N'></div></td>";								
						}	
						else
						{
							echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
							echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
							echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"].'-'.$Fila["recargo"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
							echo "</div>\n";
							echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA' readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."'>".$Fila["nro_solicitud"].'-'.$Fila["recargo"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='".$Fila["recargo"]."'></div></td>";														
						}
					}
					//echo "<td width='100'><div align='center'><input name='TxtSA' type='text' style='background:#F4F5BA' readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."'><input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='".$Fila["recargo"]."'></div></td>";			
					//}	
					
					echo "<td width='92'><div align='left'><input name='TxtIdMuestra' type='text' readonly style='width:103' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'></td>";
					echo "<td width ='80'><div align ='left'><input name ='TxtProducto' type='text' readonly style='width:80' maxlength='250' value ='".$TxtProducto=ucwords(strtolower($Fila["nomsubproducto"]))."'><input  type = 'hidden' value ='".substr($Fila["fecha_hora"],0,10)."'><input type = 'hidden' value ='".substr($Fila["fecha_hora"],11,8)."'></div></td>";
					if ($Fila["cod_analisis"]==1)
					{
						echo "<td width ='118'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:118' maxlength='85'value ='".$TxtEstado= $Fila["nombre_subclase"]." Quimico'></div></td>";
					}
					else
					{
						echo "<td width ='85'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:85' maxlength='85'value ='".$TxtEstado= $Fila["nombre_subclase"]." Fisico'></div></td>";					
					}	
					echo "<td width ='80'><div align ='left'><input name ='TxtFechaR' type='text' readonly style='width:80' maxlength='80'value ='".$TxtFechaRecepcion=substr($TxtFechaRecepcion,0,11)."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($TxtFechaRecepcion,11,8)."></div></td>";
					if (($Fila["cod_estado"]== '5') || ($Fila["cod_estado"]== '6') )
					{
						echo "<td width ='80'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:80' maxlength='80'value ='".$TxtFechaAtencion=substr($TxtFechaAtencion,0,11)."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($TxtFechaAtencion,11,8)."></div></td>";		
					}
					else
					{
						echo "<td width ='80'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:80' maxlength='80'value =''><input name ='TxtHoraAt' type='hidden' value =''></div></td>";		
					}
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
					{
						//$Consulta ="select valor,candado from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and fecha_hora ='".$Fila["fecha_hora"]."' and signo <> 'N'";
						$Consulta ="select valor,candado,signo from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and fecha_hora ='".$Fila["fecha_hora"]."'";
					}
					else
					{
						//$Consulta ="select valor,candado from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and recargo ='".$Fila["recargo"]."' and fecha_hora ='".$Fila["fecha_hora"]."' and signo <> 'N'";				
						$Consulta ="select valor,candado,signo from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and recargo ='".$Fila["recargo"]."' and fecha_hora ='".$Fila["fecha_hora"]."'";
      
					}
                         
					$Respuesta4 = mysqli_query($link, $Consulta);
					while ($Fila4 = mysqli_fetch_array($Respuesta4))
					{
						if ((!is_null($Fila4["valor"])) || ($Fila4["valor"] != "")||($Fila4["signo"] == "N"))
						{
							$EncontroValor=true;
						}
						else
						{
							$EncontroValor=false;
							break;
						}
					}
					$Respuesta5 = mysqli_query($link, $Consulta);
					while ($Fila5 = mysqli_fetch_array($Respuesta5))
					{
						if ($Fila5["candado"]=='1')
						{
							$EncontroCandado=true;
						}
						else
						{
							$EncontroCandado=false;
							break;
						}
					}
					if ($EncontroValor)
					{
						$TxtLeyes = 'OK';						
					}
					else
					{
						$TxtLeyes = '';			
					} 
					echo "<td width ='45'><div align ='left'><input name ='TxtLeyes' type='text' readonly style='width:45' maxlength='45'value ='".$TxtLeyes."'></div></td>";					
					if ($EncontroCandado==true)
					{
						echo "<td width ='50'><div align ='left'><center><img src='../principal/imagenes/cand_cerrado.gif'><input type='hidden' name='TxtCandado' value='SI'></center></div></td>";												
					}
					else
					{
						echo "<td width ='50'><div align ='left'><center><img src='../principal/imagenes/cand_abierto.gif'><input type='hidden' name='TxtCandado' value=''></center></div></td>";									
					}	
					echo "</tr>";
		   		}//cierre del while
	  }//cierre del if si producto es distinto de -1 producto y - subproducto  
	   //POR TODOS Y SELECCIONAR
	  if (($CmbProductos== -1) && ($CmbSubProducto == -1))
	   {
			switch ($CmbEstado) 
				{
					case "-1":
						$Estado ="where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '4' or t1.estado_actual = '5' or t1.estado_actual = '6')";
						break;
					case "4":
						$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '4')".$TipoAnalisis;
						break;		 
					case "5": 
						$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '5')".$TipoAnalisis;
						break;
					case "6": 
						$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '6')".$TipoAnalisis;
						break;
					default:
						$Estado ="where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '4' or t1.estado_actual = '5')";
					break;
				}
				$Consulta = "select distinct t1.fecha_hora,t1.estado_actual,t2.descripcion as nomproducto,t3.abreviatura as nomsubproducto, ";
				$Consulta = $Consulta."t1.rut_funcionario,t1.tipo_solicitud,t1.recargo,t1.cod_analisis,t1.id_muestra, ";
				$Consulta =	$Consulta."t1.nro_solicitud,t6.fecha_hora as FechaRecepcion,t7.nombre_subclase,t6.cod_estado,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
				$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
				$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
				$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
				$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
				$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual = t6.cod_estado)";
				$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002'";
				$Consulta = $Consulta.$Estado." order by t1.nro_solicitud,recargo_ordenado";
				$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
				$Respuesta= mysqli_query($link, $Consulta);
				//echo $Consulta;
				$Cont=1;
				$EncontroValor= false;
				$EncontroCandado=false;
				echo "<input type='hidden' name ='checkAtender'><input type = 'hidden' name = 'TxtSAO'><input type = 'hidden' name ='TxtRutO'><input type = 'hidden' name = 'TxtRecargoO' value ='N'><input type = 'hidden' name = 'TxtCandado'><input type = 'hidden' name = 'TxtLeyes'></div></td>";
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					//ANALITOS
					$Analitos="";
					$Consulta ="select t0.agrupacion, t0.tipo, t2.abreviatura ";
					$Consulta.= " from cal_web.solicitud_analisis t0 inner join cal_web.leyes_por_solicitud t1 ";
					$Consulta.= " on t0.nro_solicitud = t1.nro_solicitud and t0.recargo = t1.recargo ";
					$Consulta.= " inner join proyecto_modernizacion.leyes t2 ";
					$Consulta.= " on t1.cod_leyes = t2.cod_leyes ";
					$Consulta.= " where t0.nro_solicitud = '".$Fila["nro_solicitud"]."' and t0.recargo = '".$Fila["recargo"]."' ";
					$Consulta.= " order by t1.cod_leyes";
					//echo $Consulta."<br>";
					$Respuesta3 = mysqli_query($link, $Consulta);
					while ($Fila3 = mysqli_fetch_array($Respuesta3))
					{
						$Analitos = $Analitos."".$Fila3["abreviatura"].", ";
						$CodAgrupacion = $Fila3["agrupacion"];
						$CodTipo = $Fila3["tipo"];
						//echo "FechaMuestreo".$TxtFechaMuestreo."<br>";
					}
					//AGRUPACION
					$Consulta ="select distinct t2.nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
					$Consulta =$Consulta." where t2.cod_clase = '1004' and t2.cod_subclase = '".$CodAgrupacion."'  "; 
					$Resp = mysqli_query($link, $Consulta); 
					$Fila25=mysqli_fetch_array($Resp);
					$Agrupacion = $Fila25["nombre_subclase"];
					//TIPO
					$Consulta ="select distinct t2.nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
					$Consulta =$Consulta." where t2.cod_clase = '1005' and t2.cod_subclase = '".$CodTipo."' ";
					$Res = mysqli_query($link, $Consulta); 
					$Fil26=mysqli_fetch_array($Res);
					$Tipo = $Fil26["nombre_subclase"];
					//FECHA RECEPCION
					$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = ".$Fila["nro_solicitud"].") and (cod_estado = '4')";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$TxtFechaRecepcion = $Fila2["fecha_hora"];
					}	
					$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and (cod_estado = '5') ";
					$Respuesta3 = mysqli_query($link, $Consulta);
					if ($Fila3 = mysqli_fetch_array($Respuesta3))
					{
						$TxtFechaAtencion = $Fila3["fecha_hora"];
					}	
					echo "<tr>";
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))
					{
						$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."||N";
					}
					else
					{
						$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."||".$Fila["recargo"];
					}
					$pos = strpos($Valores_Check, $SAChequear);
					if ($pos === false)
					{ 
						echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value='".$Cont."'></td>"; 
					}
					else
					{
						echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value='".$Cont."' checked></td>"; 
					}	
					$Cont=$Cont+1;
					//if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
					//{
					if ($Fila["tipo_solicitud"] == 'R') 
					{	
						echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
						echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
						echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
						echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
						echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
						echo "</div>\n";
						echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA' readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"]."'>".$Fila["nro_solicitud"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='N'></div></td>";
					}
					if ($Fila["tipo_solicitud"] == 'A') 
					{	
						if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
						{
							echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
							echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
							echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
							echo "</div>\n";
							echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA'readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"]."'>".$Fila["nro_solicitud"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='N'></div></td>";			
						}	
						else
						{
							echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
							echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
							echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"].'-'.$Fila["recargo"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
							echo "</div>\n";
							echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA'readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."'>".$Fila["nro_solicitud"].'-'.$Fila["recargo"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='".$Fila["recargo"]."'></div></td>";			
						}
					}
					echo "<td width='92'><div align='left'><input name='TxtIdMuestra' type='text' readonly style='width:103' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'></td>";					
					echo "<td width ='80'><div align ='left'><input name ='TxtProducto' type='text' readonly style='width:80' maxlength='250' value ='".$TxtProducto=ucwords(strtolower($Fila["nomsubproducto"]))."'><input  type = 'hidden' value ='".substr($Fila["fecha_hora"],0,10)."'><input type = 'hidden' value ='".substr($Fila["fecha_hora"],11,8)."'></div></td>";
					if ($Fila["cod_analisis"]==1)
					{
						echo "<td width ='118'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:118' maxlength='85'value ='".$TxtEstado= $Fila["nombre_subclase"]." Quimico'></div></td>";
					}
					else
					{
						echo "<td width ='118'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:118' maxlength='85'value ='".$TxtEstado= $Fila["nombre_subclase"]." Fisico'></div></td>";					
					}	

					echo "<td width ='80'><div align ='left'><input name ='TxtFechaR' type='text' readonly style='width:80' maxlength='80'value ='".$TxtFechaRecepcion=substr($TxtFechaRecepcion,0,11)."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($TxtFechaRecepcion,11,8)."></div></td>";
					if (($Fila["cod_estado"]== '5') || ($Fila["cod_estado"]== '6') )
					{
						echo "<td width ='80'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:80' maxlength='80'value ='".$TxtFechaAtencion=substr($TxtFechaAtencion,0,11)."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($TxtFechaAtencion,11,8)."></div></td>";		
					}
					else
					{
						echo "<td width ='80'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:80' maxlength='80'value =''><input name ='TxtHoraAt' type='hidden' value =''></div></td>";		
					}
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
					{
						//$Consulta ="select valor,candado from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and fecha_hora ='".$Fila["fecha_hora"]."' and signo <> 'N'";
						$Consulta ="select valor,candado,signo from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and fecha_hora ='".$Fila["fecha_hora"]."'";
					}
					else
					{
						//$Consulta ="select valor,candado from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and recargo ='".$Fila["recargo"]."' and fecha_hora ='".$Fila["fecha_hora"]."' and signo <> 'N'";				
						$Consulta ="select valor,candado,signo from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and recargo ='".$Fila["recargo"]."' and fecha_hora ='".$Fila["fecha_hora"]."'";				
					}
					$Respuesta4 = mysqli_query($link, $Consulta);
					while ($Fila4 = mysqli_fetch_array($Respuesta4))
					{
						if ((!is_null($Fila4["valor"])) || ($Fila4["valor"] != "")||($Fila4["signo"] == "N"))
						{
							$EncontroValor=true;
						}
						else
						{
							$EncontroValor=false;
							break;
						}
					}
					$Respuesta5 = mysqli_query($link, $Consulta);
					while ($Fila5 = mysqli_fetch_array($Respuesta5))
					{
						if ($Fila5["candado"]=='1')
						{
							$EncontroCandado=true;
						}
						else
						{
							$EncontroCandado=false;
							break;
						}
					}
					if ($EncontroValor)
					{
						$TxtLeyes = 'OK';						
					}
					else
					{
						$TxtLeyes = '';			
					} 
					echo "<td width ='45'><div align ='left'><input name ='TxtLeyes' type='text' readonly style='width:45' maxlength='45'value ='".$TxtLeyes."'></div></td>";					
					if ($EncontroCandado==true)
					{
						echo "<td width ='50'><div align ='left'><center><img src='../principal/imagenes/cand_cerrado.gif'><input type='hidden' name='TxtCandado' value='SI'></center></div></td>";												
					}
					else
					{
						echo "<td width ='50'><div align ='left'><center><img src='../principal/imagenes/cand_abierto.gif'><input type='hidden' name='TxtCandado' value=''></center></div></td>";									
					}	
					echo "</tr>";
		   		}//cierre del while
	  	 }
	 //BUSCA SOLO POR PRODUCTOS
	 if (($CmbProductos!=-1) && ($CmbSubProducto== -1))
			{
				switch ($CmbEstado) 
				{
					case "-1":
						$Estado ="where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '4' or t1.estado_actual = '5' or estado_actual = '6') and (t1.cod_producto = '".$CmbProductos."')";
						break;
					case "4":
						$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '4') and (t1.cod_producto = '".$CmbProductos."')".$TipoAnalisis;
						break;		 
					case "5": 
						$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '5') and (t1.cod_producto = '".$CmbProductos."')".$TipoAnalisis;
						break;
					case "6": 
						$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '6') and (t1.cod_producto = '".$CmbProductos."' )".$TipoAnalisis;
						break;
						
					default:
						$Estado ="where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '4' or t1.estado_actual = '5') and (t1.cod_producto = '".$CmbProductos."')";
					break;
				}
				$Consulta = "select distinct t1.fecha_hora,t1.estado_actual,t2.descripcion as nomproducto,t3.descripcion as nomsubproducto, ";
				$Consulta = $Consulta."t1.rut_funcionario,t1.recargo,t1.tipo_solicitud,t1.cod_analisis,t1.id_muestra, ";
				$Consulta =	$Consulta."t1.nro_solicitud,t6.fecha_hora as FechaRecepcion,t7.nombre_subclase,t6.cod_estado,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
				$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
				$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
				$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
				$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
				$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual = t6.cod_estado)";
				$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002'";
				$Consulta = $Consulta.$Estado." order by t1.nro_solicitud,recargo_ordenado";
				$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
				$Respuesta= mysqli_query($link, $Consulta);
				$Cont=1;
				$EncontroValor= false;
				$EncontroCandado=false;
				echo "<input type='hidden' name ='checkAtender'><input type = 'hidden' name = 'TxtSAO'><input type = 'hidden' name ='TxtRutO'><input type = 'hidden' name = 'TxtRecargoO' value ='N'><input type = 'hidden' name = 'TxtCandado'><input type = 'hidden' name = 'TxtLeyes'></div></td>";
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					//ANALITOS
					$Analitos="";
					$Consulta ="select t0.agrupacion, t0.tipo, t2.abreviatura ";
					$Consulta.= " from cal_web.solicitud_analisis t0 inner join cal_web.leyes_por_solicitud t1 ";
					$Consulta.= " on t0.nro_solicitud = t1.nro_solicitud and t0.recargo = t1.recargo ";
					$Consulta.= " inner join proyecto_modernizacion.leyes t2 ";
					$Consulta.= " on t1.cod_leyes = t2.cod_leyes ";
					$Consulta.= " where t0.nro_solicitud = '".$Fila["nro_solicitud"]."' and t0.recargo = '".$Fila["recargo"]."' ";
					$Consulta.= " order by t1.cod_leyes";
					//echo $Consulta."<br>";
					$Respuesta3 = mysqli_query($link, $Consulta);
					while ($Fila3 = mysqli_fetch_array($Respuesta3))
					{
						$Analitos = $Analitos."".$Fila3["abreviatura"].", ";
						$CodAgrupacion = $Fila3["agrupacion"];
						$CodTipo = $Fila3["tipo"];
						//echo "FechaMuestreo".$TxtFechaMuestreo."<br>";
					}
					//AGRUPACION
					$Consulta ="select distinct t2.nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
					$Consulta =$Consulta." where t2.cod_clase = '1004' and t2.cod_subclase = '".$CodAgrupacion."'  "; 
					$Resp = mysqli_query($link, $Consulta); 
					$Fila25=mysqli_fetch_array($Resp);
					$Agrupacion = $Fila25["nombre_subclase"];
					//TIPO
					$Consulta ="select distinct t2.nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
					$Consulta =$Consulta." where t2.cod_clase = '1005' and t2.cod_subclase = '".$CodTipo."' ";
					$Res = mysqli_query($link, $Consulta); 
					$Fil26=mysqli_fetch_array($Res);
					$Tipo = $Fil26["nombre_subclase"];
					//FECHA RECEPCION
					$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = ".$Fila["nro_solicitud"].") and (cod_estado = '4')";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$TxtFechaRecepcion = $Fila2["fecha_hora"];
					}	
					$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and (cod_estado = '5') ";
					$Respuesta3 = mysqli_query($link, $Consulta);
					if ($Fila3 = mysqli_fetch_array($Respuesta3))
					{
						$TxtFechaAtencion = $Fila3["fecha_hora"];
					}	
					echo "<tr>";
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))
					{
						$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."||N";
					}
					else
					{
						$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."||".$Fila["recargo"];
					}
					$pos = strpos($Valores_Check, $SAChequear);
					if ($pos === false)
					{ 
						echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value='".$Cont."'></td>"; 
					}
					else
					{
						echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value='".$Cont."' checked></td>"; 
					}	
					$Cont=$Cont+1;
					if ($Fila["tipo_solicitud"] == 'R') 
					{
						echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
						echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
						echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
						echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
						echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
						echo "</div>\n";
						echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA' readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"]."'>".$Fila["nro_solicitud"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='N'></div></td>";					
					}	
					if ($Fila["tipo_solicitud"] == 'A') 
					{
						if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
						{
							echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
							echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
							echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
							echo "</div>\n";
							echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA' readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"]."'>".$Fila["nro_solicitud"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='N'></div></td>";			
						}		
						else
						{					
							echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
							echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
							echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"].'-'.$Fila["recargo"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
							echo "</div>\n";
							echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA' readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."'>".$Fila["nro_solicitud"].'-'.$Fila["recargo"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='".$Fila["recargo"]."'></div></td>";			
						}
					}	
					echo "<td width='92'><div align='left'><input name='TxtIdMuestra' type='text' readonly style='width:103' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'></td>";
					echo "<td width ='80'><div align ='left'><input name ='TxtProducto' type='text' readonly style='width:80' maxlength='250' value ='".$TxtProducto=ucwords(strtolower($Fila["nomsubproducto"]))."'><input  type = 'hidden' value ='".substr($Fila["fecha_hora"],0,10)."'><input type = 'hidden' value ='".substr($Fila["fecha_hora"],11,8)."'></div></td>";
					if ($Fila["cod_analisis"]==1)
					{
						echo "<td width ='118'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:118' maxlength='85'value ='".$TxtEstado= $Fila["nombre_subclase"]." Quimico'></div></td>";
					}
					else
					{
						echo "<td width ='118'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:118' maxlength='85'value ='".$TxtEstado= $Fila["nombre_subclase"]." Fisico'></div></td>";					
					}	
					echo "<td width ='80'><div align ='left'><input name ='TxtFechaR' type='text' readonly style='width:80' maxlength='80'value ='".$TxtFechaRecepcion=substr($TxtFechaRecepcion,0,11)."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($TxtFechaRecepcion,11,8)."></div></td>";
					if (($Fila["cod_estado"]== '5') || ($Fila["cod_estado"]== '6') )
					{
						echo "<td width ='80'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:80' maxlength='80'value ='".$TxtFechaAtencion=substr($TxtFechaAtencion,0,11)."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($TxtFechaAtencion,11,8)."></div></td>";		
					}
					else
					{
						echo "<td width ='80'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:80' maxlength='80'value =''><input name ='TxtHoraAt' type='hidden' value =''></div></td>";		
					}
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
					{
						//$Consulta ="select valor,candado from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and fecha_hora ='".$Fila["fecha_hora"]."' and signo <> 'N'";
						$Consulta ="select valor,candado,signo from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and fecha_hora ='".$Fila["fecha_hora"]."'";
					}
					else
					{
						//$Consulta ="select valor,candado from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and recargo ='".$Fila["recargo"]."' and fecha_hora ='".$Fila["fecha_hora"]."' and signo <> 'N'";				
						$Consulta ="select valor,candado,signo from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and recargo ='".$Fila["recargo"]."' and fecha_hora ='".$Fila["fecha_hora"]."'";				
					}
					$Respuesta4 = mysqli_query($link, $Consulta);
					while ($Fila4 = mysqli_fetch_array($Respuesta4))
					{
						if ((!is_null($Fila4["valor"])) || ($Fila4["valor"] != "") ||($Fila4["signo"] == "N"))
						{
							$EncontroValor=true;
						}
						else
						{
							$EncontroValor=false;
							break;
						}
					}
					$Respuesta5 = mysqli_query($link, $Consulta);
					while ($Fila5 = mysqli_fetch_array($Respuesta5))
					{
						if ($Fila5["candado"]=='1')
						{
							$EncontroCandado=true;
						}
						else
						{
							$EncontroCandado=false;
							break;
						}
					}
					if ($EncontroValor)
					{
						$TxtLeyes = 'OK';						
					}
					else
					{
						$TxtLeyes = '';			
					} 
					echo "<td width ='45'><div align ='left'><input name ='TxtLeyes' type='text' readonly style='width:45' maxlength='45'value ='".$TxtLeyes."'></div></td>";					
					if ($EncontroCandado==true)
					{
						echo "<td width ='50'><div align ='left'><center><img src='../principal/imagenes/cand_cerrado.gif'><input type='hidden' name='TxtCandado' value='SI'></center></div></td>";												
					}
					else
					{
						echo "<td width ='50'><div align ='left'><center><img src='../principal/imagenes/cand_abierto.gif'><input type='hidden' name='TxtCandado' value=''></center></div></td>";									
					}	
					echo "</tr>";
		   		}//cierre del while
	  }//cierre del if si producto es distinto de -1 
	   ///////////////////
  }//cierre del if mostrar = S
	   if ($Mostrar== 'O')  //BUSQUEDA DIRECTA
	   {
	   			if (!isset($AnoBuscadoIni))
					$AnoBuscadoIni = 0;
				if (!isset($TxtSa))
					$TxtSa = 0;
				if (!isset($AnoBuscadoFin))
					$AnoBuscadoFin = 0;
				if (!isset($TxtSaFin))
					$TxtSaFin = 0;
				$SolIni = $AnoBuscadoIni."000000";
				$SolFin = $AnoBuscadoFin."000000";
				$SolIni = $SolIni + $TxtSa;
				$SolFin = $SolFin + $TxtSaFin;
	
				$Consulta = "select distinct t1.fecha_hora,t1.tipo_solicitud,t1.estado_actual,t2.descripcion as nomproducto,t3.descripcion as nomsubproducto, ";
				$Consulta = $Consulta." t1.rut_funcionario,t1.recargo,t1.id_muestra, ";
				$Consulta =	$Consulta." t1.nro_solicitud,t6.fecha_hora as FechaRecepcion,t7.nombre_subclase,t6.cod_estado,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado ";
				$Consulta = $Consulta." from cal_web.solicitud_analisis t1 " ;
				$Consulta = $Consulta." inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
				$Consulta = $Consulta." inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
				$Consulta = $Consulta." inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
				$Consulta = $Consulta." left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual = t6.cod_estado)";
				$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002'";
				$Consulta = $Consulta." where (t1.nro_solicitud between '".$SolIni."' and '".$SolFin."') and (t1.estado_actual = '4' or t1.estado_actual = '5' or t1.estado_actual = '6')".$TipoAnalisis;
				$Consulta = $Consulta." order by t1.nro_solicitud,recargo_ordenado";
				$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
				$Respuesta= mysqli_query($link, $Consulta);
			//	echo $Consulta;
				$Cont=1;
				$EncontroValor= false;
				$EncontroCandado=false;
				echo "<input type='hidden' name ='checkAtender'><input type = 'hidden' name = 'TxtSAO'><input type = 'hidden' name ='TxtRutO'><input type = 'hidden' name = 'TxtRecargoO' value ='N'><input type = 'hidden' name = 'TxtCandado'><input type = 'hidden' name = 'TxtLeyes'></div></td>";
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					//ANALITOS
					$Analitos="";
					$Consulta ="select t0.agrupacion, t0.tipo, t2.abreviatura ";
					$Consulta.= " from cal_web.solicitud_analisis t0 inner join cal_web.leyes_por_solicitud t1 ";
					$Consulta.= " on t0.nro_solicitud = t1.nro_solicitud and t0.recargo = t1.recargo ";
					$Consulta.= " inner join proyecto_modernizacion.leyes t2 ";
					$Consulta.= " on t1.cod_leyes = t2.cod_leyes ";
					$Consulta.= " where t0.nro_solicitud = '".$Fila["nro_solicitud"]."' and t0.recargo = '".$Fila["recargo"]."' ";
					$Consulta.= " order by t1.cod_leyes";
					//echo $Consulta."<br>";
					$Respuesta3 = mysqli_query($link, $Consulta);
					while ($Fila3 = mysqli_fetch_array($Respuesta3))
					{
						$Analitos = $Analitos."".$Fila3["abreviatura"].", ";
						$CodAgrupacion = $Fila3["agrupacion"];
						$CodTipo = $Fila3["tipo"];
						//echo "FechaMuestreo".$TxtFechaMuestreo."<br>";
					}
					//AGRUPACION
					$Consulta ="select distinct t2.nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
					$Consulta =$Consulta." where t2.cod_clase = '1004' and t2.cod_subclase = '".$CodAgrupacion."'  "; 
					$Resp = mysqli_query($link, $Consulta); 
					$Fila25=mysqli_fetch_array($Resp);
					$Agrupacion = $Fila25["nombre_subclase"];
					//TIPO
					$Consulta ="select distinct t2.nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
					$Consulta =$Consulta." where t2.cod_clase = '1005' and t2.cod_subclase = '".$CodTipo."' ";
					$Res = mysqli_query($link, $Consulta); 
					$Fil26=mysqli_fetch_array($Res);
					$Tipo = $Fil26["nombre_subclase"];
					//FECHA RECEPCION
					$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = ".$Fila["nro_solicitud"].") and (cod_estado = '4')";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$TxtFechaRecepcion = $Fila2["fecha_hora"];
					}	
					$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and (cod_estado = '5') ";
					$Respuesta3 = mysqli_query($link, $Consulta);
					if ($Fila3 = mysqli_fetch_array($Respuesta3))
					{
						$TxtFechaAtencion = $Fila3["fecha_hora"];
					}	
					echo "<tr>";
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))
					{
						$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."||N";
					}
					else
					{
						$SAChequear=$Fila["nro_solicitud"]."~~".$Fila["rut_funcionario"]."||".$Fila["recargo"];
					}
					$pos = strpos($Valores_Check, $SAChequear);
				
					if ($pos === false)
					{ 
						echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value='".$Cont."'></td>"; 
					}
					else
					{
						echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value='".$Cont."' checked></td>"; 
					}	
					$Cont=$Cont+1;
					if ($Fila["tipo_solicitud"] == 'R') 
					{
						echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
						echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
						echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
						echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
						echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
						echo "</div>\n";
						echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA' readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"]."'>".$Fila["nro_solicitud"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='N'></div></td>";
					}
					if ($Fila["tipo_solicitud"] == 'A') 
					{
						if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
						{
							echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
							echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
							echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
							echo "</div>\n";
							echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA' readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"]."'>".$Fila["nro_solicitud"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='N'></div></td>";			
						}
						else
						{
							echo "<td width='95'  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");'>";
							echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:450px'>\n";
							echo "<font face='courier' color='#000000' size=1><b>Nro S.A.&nbsp;&nbsp;: </b>".$Fila["nro_solicitud"].'-'.$Fila["recargo"]." <b>ID. Muestra: </b>".$Fila["id_muestra"]."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Agrupacion: </b>".$Agrupacion."        <b>Tipo: </b>".$Tipo."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Analitos&nbsp;&nbsp;: </b>".$Analitos."</font>";
							echo "</div>\n";
							echo "<div align='center'><input name='TxtSA' type='hidden' style='background:#F4F5BA' readonly style='width:100' maxlength='15' value ='".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."'>".$Fila["nro_solicitud"].'-'.$Fila["recargo"]."<input type = 'hidden' name = 'TxtSAO' value ='".$Fila["nro_solicitud"]."'><input type = 'hidden' name ='TxtRutO' value ='".$Fila["rut_funcionario"]."'><input type = 'hidden' name = 'TxtRecargoO' value ='".$Fila["recargo"]."'></div></td>";			
						}	
					}
					echo "<td width='92'><div align='left'><input name='TxtIdMuestra' type='text' readonly style='width:103' maxlength='10' value ='".$TxtIdMuestra = $Fila["id_muestra"]."'></td>";
					echo "<td width ='80'><div align ='left'><input name ='TxtProducto' type='text' readonly style='width:80' maxlength='250' value ='".$TxtProducto=ucwords(strtolower($Fila["nomsubproducto"]))."'><input  type = 'hidden' value ='".substr($Fila["fecha_hora"],0,10)."'><input type = 'hidden' value ='".substr($Fila["fecha_hora"],11,8)."'></div></td>";
					echo "<td width ='118'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:118' maxlength='85'value ='".$TxtEstado= $Fila["nombre_subclase"]."'></div></td>";
					echo "<td width ='80'><div align ='left'><input name ='TxtFechaR' type='text' readonly style='width:80' maxlength='80'value ='".$TxtFechaRecepcion=substr($TxtFechaRecepcion,0,11)."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($TxtFechaRecepcion,11,8)."></div></td>";
					if (($Fila["cod_estado"]== '5') || ($Fila["cod_estado"]== '6') )
					{
						echo "<td width ='80'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:80' maxlength='80'value ='".$TxtFechaAtencion=substr($TxtFechaAtencion,0,11)."'><input name ='TxtHoraM' type='hidden' value =".$TxtHoraM= substr($TxtFechaAtencion,11,8)."></div></td>";		
					}
					else
					{
						echo "<td width ='80'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:80' maxlength='80'value =''><input name ='TxtHoraAt' type='hidden' value =''></div></td>";		
					}
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
					{
						//$Consulta ="select valor,candado from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and fecha_hora ='".$Fila["fecha_hora"]."' and signo <> 'N'";
						$Consulta ="select valor,candado,signo from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and fecha_hora ='".$Fila["fecha_hora"]."'";
					}
					else
					{
						//$Consulta ="select valor,candado from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and recargo ='".$Fila["recargo"]."' and fecha_hora ='".$Fila["fecha_hora"]."' and signo <> 'N'";				
						$Consulta ="select valor,candado,signo from leyes_por_solicitud  t1 where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud =".$Fila["nro_solicitud"]." and recargo ='".$Fila["recargo"]."' and fecha_hora ='".$Fila["fecha_hora"]."'";				
					}
					//echo $Consulta;
					$Respuesta4 = mysqli_query($link, $Consulta);
					while ($Fila4 = mysqli_fetch_array($Respuesta4))
					{
						if ((!is_null($Fila4["valor"])) || ($Fila4["valor"] != "") ||($Fila4["signo"] == "N"))
						{
							$EncontroValor=true;
						}
						else
						{
							$EncontroValor=false;
							break;
						}
					}
					$Respuesta5 = mysqli_query($link, $Consulta);
					while ($Fila5 = mysqli_fetch_array($Respuesta5))
					{
						if ($Fila5["candado"]=='1')
						{
							$EncontroCandado=true;
						}
						else
						{
							$EncontroCandado=false;
							break;
						}
					}
					if ($EncontroValor)
					{
						$TxtLeyes = 'OK';						
					}
					else
					{
						$TxtLeyes = '';			
					} 
					echo "<td width ='45'><div align ='left'><input name ='TxtLeyes' type='text' readonly style='width:45' maxlength='45'value ='".$TxtLeyes."'></div></td>";					
					if ($EncontroCandado==true)
					{
						echo "<td width ='50'><div align ='left'><center><img src='../principal/imagenes/cand_cerrado.gif'><input type='hidden' name='TxtCandado' value='SI'></center></div></td>";												
					}
					else
					{
						echo "<td width ='50'><div align ='left'><center><img src='../principal/imagenes/cand_abierto.gif'><input type='hidden' name='TxtCandado' value=''></center></div></td>";									
					}	
					echo "</tr>";
		   		}//cierre del while
 	 }//cierre del if mostrar = O
	 ?>
        </table>
		<br>
		<table width="760" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="25" align="center" valign="middle">Paginas &gt;&gt;
				<?php
					if ($Mostrar=='S')
					{	
						$Consulta = "select count(*) as total_registros from cal_web.solicitud_analisis t1 " ;
						$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
						$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
						$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
						$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual = t6.cod_estado)";
						$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002'";
						$Consulta = $Consulta.$Estado;
					}
					if ($Mostrar=='O')
					{	
						$Consulta = "select count(*) as total_registros from cal_web.solicitud_analisis t1 " ;
						$Consulta = $Consulta." inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
						$Consulta = $Consulta." inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
						$Consulta = $Consulta." inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
						$Consulta = $Consulta." left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual = t6.cod_estado)";
						$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002'";
						$Consulta = $Consulta." where (t1.nro_solicitud between '".$SolIni."' and '".$SolFin."') and (t1.estado_actual = '4' or t1.estado_actual = '5' or t1.estado_actual = '6')".$TipoAnalisis;
					}
					if (($Mostrar=='S')||($Mostrar=='O'))
					{	
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
								$StrPaginas.=  "<a href=JavaScript:Recarga('cal_adm_ingreso_leyes.php?LimitIni=".($i * $LimitFin)."&CmbEstado=".$CmbEstado."&Mostrar=".$Mostrar."');>";
								$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
							}
						}
						echo substr($StrPaginas,0,-15);
					}	
				?>
			</td>
		  </tr>
		</table>
        <br>
        <table width="759" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
          <tr> 
            <td align="center"><input name="BtnDetalle" type="button" value="Detalle" style="width:70" onClick="Detalle();">
              &nbsp; 
              <input name="BtnSalir" type="button" value="Salir" style="width:70" onClick="Proceso('S');">
            </td>
          </tr>
        </table> </td>
    </tr>
  </table>
  
 <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
