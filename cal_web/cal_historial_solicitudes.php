<?php 
	$CodigoDeSistema  = 1;
	$CodigoDePantalla = 19;
	include("../principal/conectar_principal.php");
	$CookieRut  = $_COOKIE["CookieRut"];
	$Fecha_Hora = date("d-m-Y h:i");
	$meses = array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut   = $CookieRut;
	$HoraActual   = date("H");
	$MinutoActual = date("i");
	$Consulta     = "select * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '1'  ";
	$Respuesta    = mysqli_query($link, $Consulta);
	if($Fila = mysqli_fetch_array($Respuesta))
	{
		$Nivel = $Fila["nivel"];
	}
	
	$CmbProductos = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:"";
	$CmbAno       = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbMes       = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbDias      = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:date("d");
	$CmbAnoT      = isset($_REQUEST["CmbAnoT"])?$_REQUEST["CmbAnoT"]:date("Y");
	$CmbMesT      = isset($_REQUEST["CmbMesT"])?$_REQUEST["CmbMesT"]:date("m");
	$CmbDiasT     = isset($_REQUEST["CmbDiasT"])?$_REQUEST["CmbDiasT"]:date("d");
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$NumIni       = isset($_REQUEST["NumIni"])?$_REQUEST["NumIni"]:"";
	$NumFin       = isset($_REQUEST["NumFin"])?$_REQUEST["NumFin"]:"";
	$AnoIni2      = isset($_REQUEST["AnoIni2"])?$_REQUEST["AnoIni2"]:date("Y");
	$AnoFin2      = isset($_REQUEST["AnoFin2"])?$_REQUEST["AnoFin2"]:date("Y");
	$Mostrar      = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$SA           = isset($_REQUEST["SA"])?$_REQUEST["SA"]:"";
	$TxtSA        = isset($_REQUEST["TxtSA"])?$_REQUEST["TxtSA"]:"";
	$TxtEstadoO   = isset($_REQUEST["TxtEstadoO"])?$_REQUEST["TxtEstadoO"]:"";
	$CmbRutProveedor = isset($_REQUEST["CmbRutProveedor"])?$_REQUEST["CmbRutProveedor"]:"";
	$FechaHora       = isset($_REQUEST["FechaHora"])?$_REQUEST["FechaHora"]:"";
	
?>
<html>
<head>
<title>Historial de Solicitudes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion)
{
	var frm=document.FrmGeneracion;
	switch (Opcion)
	{
		case "R":
			frm.action="cal_historial_solicitudes.php";
			frm.submit();
			break;
		case "S":
			Salir();
			break;
		case "B":
			frm.action="cal_historial_solicitudes.php?Mostrar=S";
			frm.submit();
			break;
		case "I":
			ValidarSA();	
			break;
		case "O":
			frm.action ="cal_historial_solicitudes.php?Mostrar=O";
			frm.submit();
			break;
		case "E":
			EmisionCert();
			break;
		case "D":
			frm.action ="cal_historial_solicitudes.php?Mostrar=D";
			frm.submit(); 
			break;
		case "H":
			Historial();
			break;
		case "A":
			ValidarAnular();	
			break;		
	}
}
function ValidarSA()
{
	var frm=document.FrmGeneracion;
	var SolA="";
	SolA=RecuperarSA();
	if (SolA=="")
	{
		frm.action="cal_historial_solicitudes.php?Mostrar=D";
		frm.submit();
	}	
	else
	{
		//alert(SolA);
		frm.action="cal_historial_solicitudes.php?SA="+ SolA + "&Mostrar=I";
		frm.submit();
	}
}
function RecuperarSA()
{
	var frm=document.FrmGeneracion;
	var Encontro=false;
	var Solicitud ="";
	var cont=0; 
	try 
	{
		frm.checkSA[0];
		for (i=0;i<frm.checkSA.length;i++)
		{
			if (frm.checkSA[i].checked==true)
			{
				Solicitud = Solicitud + frm.TxtSA[i].value + "//" ;
				Encontro=true;
				cont=cont + 1; 
				if (cont > 300)
				{
					alert("Debe Seleccionar Hasta 300 Solicitudes");
					Solicitud="";
					break;
				}
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
		return(Solicitud);
	}
	else
	{
		/*if (cont >300)
		{
			alert("Debe Seleccionar hasta 300 Solicitudes")
			Solicitud="";
			return(Solicitud);
		}
		else
		{*/
			return(Solicitud);
		//}
	}
}
function Historial()
{
	var frm=document.FrmGeneracion;
	var Cont=0;
	for (i=1;i<frm.checkAtender.length;i++)
	{
		if (frm.checkAtender[i].checked==true)
		{
			Cont=Cont+1;
			//alert(Cont);
			if (Cont >1)
			{}
			else
			{ 
			SA = frm.TxtSAO[i].value;
			//SolA = frm.TxtSAO[i].value   ;
			}
		}
	}	
	if (Cont > 1)
	{
	alert("Debe Seleccionar solo un elemento");
	}
	else
	{
		window.open("cal_con_registro_leyes.php?SA="+ SA,"","top=200,left=5,width=800,height=400,scrollbars=yes,resizable = yes");						
	}
}	
function EstAnterior()
{
	var frm=document.FrmGeneracion;
	var Cont=0;
	var SA="";
	for (i=1;i<frm.checkAtender.length;i++)
	{
		if (frm.checkAtender[i].checked==true)
		{
			Cont=Cont+1;
			//alert(Cont);
			if (Cont >1)
			{}
			else
			{ 
			SA = frm.TxtSAO[i].value;
			//SolA = frm.TxtSAO[i].value   ;
			}
		}
	}	
	if (SA == "")
	{
	alert("Debe Seleccionar solo un elemento");
	}
	else
	{
		window.open("cal_historial_solicitudes02.php?SA="+ SA,"","top=100,left=30,width=500,height=400,scrollbars=yes,resizable = yes");						
	}
}
function RecEstReg()
{
	var frm=document.FrmGeneracion;
	var Cont=0;
	var SA="";
	for (i=1;i<frm.checkAtender.length;i++)
	{
		if (frm.checkAtender[i].checked==true)
		{
			Cont=Cont+1;
			//alert(Cont);
			if (Cont >1)
			{}
			else
				SA = frm.TxtSAO[i].value;
		}
	}	
	if (SA == "")
		alert("Debe Seleccionar solo un elemento");
	else
	{
		if(confirm('Esta seguro de Recuperar Estado SA Actual'))
		{
			frm.action="cal_historial_solicitudes01.php?Proceso=RE&SA="+SA;
			frm.submit();
		}	
	}
}	
function Activar()//Activa los checkbox de las sol pra ingresar 
{
	var frm=document.FrmGeneracion;
	try
	{
		frm.checkSA[0];
		for (i=0;i<frm.checkSA.length;i++)
		{
			if (frm.CheckTodosA.checked == true)
			{
				frm.checkSA[i].checked = true;
			}
			else 
			{
				frm.checkSA[i].checked = false;		
			}
		}
	}
	//si encuentra algun error no hace nada
	catch(e)
	{
	}
}
function Salir()
{
	var frm =document.FrmGeneracion;
	frm.action="cal_adm_ingreso_leyes01.php?Opcion=S";
	frm.submit(); 
}
function ValidarAnular()
{
	var frm=document.FrmGeneracion;
	var SolA="";
	SolA=RecuperarAnularSA();
	if (SolA!="")
	{
		window.open("cal_anular_solicitudes.php?SA02="+ frm.SA01.value + "&SA="+SolA,"","top=200,left=175,width=410,height=230,scrollbars=no,resizable = no");	
//		frm.action="cal_historial_solicitudes.php?SA="+ SolA + "&Mostrar=I";
//		frm.submit();
	}
	
} 
function RecuperarAnularSA()
{
	var frm=document.FrmGeneracion;
	var Encontro=false;
	var Solicitud ="";
	var cont=0; 
	try 
	{
		frm.checkAtender[0];
		for (i=0;i<frm.checkAtender.length;i++)
		{
			if (frm.checkAtender[i].checked==true)
			{
				Solicitud = Solicitud + frm.TxtSAO[i].value + "//" ;
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
		return(Solicitud);
	}
	else
	{
		return(Solicitud);
	}
}



/*
function Anular()
{
	var frm=document.FrmGeneracion;
	var LargoForm = frm.elements.length;
	var SA="";
	var CheckeoSolicitud ="";
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
		{
			//SA = SA + frm.elements[i+1].value + "~~" + frm.elements[i+5].value + "//";
			SA = SA + frm.elements[i+1].value + "//";
			CheckeoSolicitud = true;
		}
	}
	if (CheckeoSolicitud == false)
	{
		alert ("No Hay Elementos Seleccionados");
	}
	else
	{
		window.open("cal_anular_solicitudes.php?SA02="+ frm.SA01.value + "&SA="+SA,"","top=200,left=175,width=410,height=230,scrollbars=no,resizable = no");	
	}
}
*/		
function Activar2()//Activa los checkbox de las sol anular o ver el historial
{
	var frm=document.FrmGeneracion;
	try
	{
		frm.checkAtender[0];
		for (i=0;i<frm.checkAtender.length;i++)
		{
			if (frm.CheckTodos.checked == true)
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
</script>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form  method="post" name="FrmGeneracion" action="" >
 <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal"  left="5">
  	<input name="SA01" type="hidden" value="<?php echo $SA  ?>">
    <tr> 
      <td width="421"><table width="419" border="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="165"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php echo $Fecha_Hora ?> </strong>&nbsp; <strong> 
              <?php
			//creacion de campo oculto para almacenar la fecha y hora si no existe lo crea en caso contraria le asigana la feha hora del sistema 
			if ($FechaHora=="")
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
            <td width="226"><div align="right"></div></td>
            <td width="0"><div align="left"> </div></td>
          </tr>
          <tr> 
            <td colspan="3">Fecha Inicio<font size="2">&nbsp;&nbsp;&nbsp;&nbsp; 
              <select name="CmbDias" id="select24" size="1" style="font-face:verdana;font-size:10">
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
              <select name="CmbMes" size="1" id="select25" style="FONT-FACE:verdana;FONT-SIZE:10">
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
              <select name="CmbAno" size="1" id="select26" style="FONT-FACE:verdana;FONT-SIZE:10">
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
          </tr>
          <tr> 
            <td colspan="3"><font size="1"><font size="1"><font size="2">Fecha 
              Termino </font><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
              <select name="CmbDiasT" id="select4" size="1" style="font-face:verdana;font-size:10">
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
              <select name="CmbMesT" size="1" id="select5" style="FONT-FACE:verdana;FONT-SIZE:10">
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
              <select name="CmbAnoT" size="1" id="select6" style="FONT-FACE:verdana;FONT-SIZE:10">
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
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><font size="2"><strong><br>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="1"><font size="2">Producto&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><font size="1"><font size="2"><strong>&nbsp;&nbsp; 
              <select name="CmbProductos" style="width:280" onChange="Proceso('R');">
                <option value='-1' selected>Seleccionar</option>
                <?php 
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
					//echo $CmbProductos."<br>";
				?>
              </select>
              </strong></font></font><font size="2"><strong></strong></font></font></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="1"><font size="2">Sub Producto&nbsp;<strong> 
              &nbsp; 
              <select name="CmbSubProducto" style="width:280"  onChange="Proceso('R');" >
                <option value="-1" selected>Seleccionar</option>
                <?php
				//Pregunta si el valor del Combo es 1 osea Productos mineros si es 1 despliega como proveedor
				if ($CmbProductos == '1')
				{
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' and ((mostrar <> 16) or (mostrar <> 17)) "; 
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
				}
				else
				{
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'"; 
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
				}
				?>
              </select>
              </strong>&nbsp;&nbsp;&nbsp;&nbsp;</font></font></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></font> 
              <?php
			  if ($CmbProductos =='1')
			  {
			  	echo"<font size='1'>Rut Proveedor </font>";	
				echo "<select name='CmbRutProveedor' style='width:280'>";
              	echo "<option value='-1' selected>Seleccionar</option>";
				switch (strlen($CmbSubProducto))
				{
					case "1":
						$Estado ="inner join proyecto_modernizacion.subproducto t2 on right(t1.tipo_producto,1) = t2.cod_subproducto and t2.cod_producto = 1" ; 
						break;
					case "2":
						$Estado ="inner join proyecto_modernizacion.subproducto t2 on right(t1.tipo_producto,2) = t2.cod_subproducto and t2.cod_producto = 1" ; 
						break;
					case "3":
						$Estado ="inner join proyecto_modernizacion.subproducto t2 on t1.tipo_producto = t2.cod_subproducto and t2.cod_producto = 1" ; 
						break;
				}
				$Consulta = "select t1.rut_proveedor,t1.nombre from imp_web.proveedores t1 ";
			  	$Consulta = $Consulta.$Estado;
			  	$Consulta = $Consulta." where t2.cod_subproducto = '".$CmbSubProducto."' order by t1.rut_proveedor ";			  
			  	$Respuesta=mysqli_query($link, $Consulta);			
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbRutProveedor == $Fila["rut_proveedor"])
					{
						echo "<option value = '".$Fila["rut_proveedor"]."' selected>".$Fila["rut_proveedor"]."   ".ucwords(strtolower($Fila["nombre"]))."</option>\n";				
					}
					else
					{
						echo "<option value = '".$Fila["rut_proveedor"]."'>".$Fila["rut_proveedor"]."   ".ucwords(strtolower($Fila["nombre"]))."</option>\n";
					}	
				}
			    echo "</select>";
              }
			  ?>
            </td>
          </tr>
        </table>
        <div style='position:absolute; overflow:auto; left: 488px; top: 78px; width: 250px; height: 114px; border:solid 0px'> 
          <?php
			echo  "<table width='200' border='0' cellpadding='3' cellspacing='0'>";
			echo "<tr>";
			echo "<td><input name='CheckTodosA' type='checkbox' id='CheckTodosA3' value='checkbox' onClick=\"Activar();\">Todos <td>";
			echo "<td ><input name='BtnBusqueda' type='button'  value='Busqueda' onClick=\"Proceso('B');\"></td>";
			echo "<td><input name='BtnIngresar' type='button'  value='Ingresar' onClick=\"Proceso('I');\"></td>";
			echo "</tr>";
			echo "</table>";
		?>
        </div>
        <div style='position:absolute; overflow:auto; left: 527px; top: 107px; width: 203px; height: 127px; border:solid 0px'> 
          <table width="170" border="1"  class="ColorTabla01" cellpadding="3" cellspacing="0" >
            <?php
					$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
					$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
					//Entra si a clickeado el boton busqueda y valor del combo es producto mineros  y realizo la busqueda por el proveedor
					if (($Mostrar == 'S' ) && ($CmbProductos == 1)) 
					{
						switch (strlen($CmbSubProducto))
						{	
							case "1":
								$Estado = " inner join proyecto_modernizacion.subproducto t2 on right(t1.tipo_producto,1) = t2.cod_subproducto  ";
							break; 	
							case "2":
								$Estado = " inner join proyecto_modernizacion.subproducto t2 on right(t1.tipo_producto,2) = t2.cod_subproducto   ";
							break;
							case "3":
								$Estado = " inner join proyecto_modernizacion.subproducto t2 on t2.cod_subproducto = t1.tipo_producto ";
							break;					
						}
						$Consulta ="select distinct t3.nro_solicitud,nombre_subclase  from imp_web.proveedores t1 ";
						$Consulta = $Consulta.$Estado ; 
						$Consulta = $Consulta." inner join cal_web.solicitud_analisis t3 on t3.cod_producto = t2.cod_producto ";
						$Consulta = $Consulta." and t3.cod_subproducto = t2.cod_subproducto ";//and t3.estado_actual = '6' "; 
						$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t4 on t4.cod_subclase = t3.estado_actual and t4.cod_clase = '1002' "; 
						$Consulta = $Consulta." where (t2.cod_producto = ".$CmbProductos.") and (t2.cod_subproducto = ".$CmbSubProducto.") ";
						if ($CmbRutProveedor == -1)
						{
							$Consulta = $Consulta." and (t3.fecha_hora between '".$FechaI."' and '".$FechaT ."') and (isnull(t3.rut_proveedor)) ";							
						}
						else
						{
							$RutP=substr($CmbRutProveedor,0,strlen($CmbRutProveedor)-1).'-'.substr($CmbRutProveedor,strlen($CmbRutProveedor)-1,1);
							$Consulta = $Consulta." and (t3.fecha_hora between '".$FechaI."' and '".$FechaT ."') and(t3.rut_proveedor = '".$RutP."')  ";
						}
						echo "<input type='hidden' name ='checkSA' ><input type='hidden' name ='TxtSA' >";
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							$nro_solicitud   = isset($Fila["nro_solicitud"])?$Fila["nro_solicitud"]:"";
							$nombre_subclase = isset($Fila["nombre_subclase"])?$Fila["nombre_subclase"]:"";
							echo "<tr>";
							echo "<td width='20'><input type='checkbox' name ='checkSA' value=''></td>"; 
              				echo "<td width='100'><input name='TxtSA' type='text' readonly style='width:100' maxlength='100' value =".$TxtSA = $nro_solicitud."><input name = 'TxtRecargo' type = 'hidden' value ='N'><input name='TxtEstadoO' type = 'hidden' value =".$TxtEstadoO = $nombre_subclase."></td>";
          					echo "</tr>";		
						}
					}
					//Entra si a clickeado el boton busqueda y valor del combo es distinto de producto mineros  por el producto y subproducto 
					if (($Mostrar =='S') && ($CmbProductos != 1))
					{
						$Consulta = " select  distinct t1.nro_solicitud,t1.tipo_solicitud ";
						$Consulta = $Consulta." from cal_web.solicitud_analisis t1 ";
						$Consulta = $Consulta." inner join cal_web.estados_por_solicitud t2 ";
						$Consulta = $Consulta." on (t1.estado_actual = t2.cod_estado) and  (t1.nro_solicitud = t2.nro_solicitud) "; 
						$Consulta = $Consulta." and (t1.rut_funcionario = t1.rut_funcionario) "; 
						$Consulta = $Consulta." where (t1.cod_producto = ".$CmbProductos.") and (t1.cod_subproducto = ".$CmbSubProducto.") ";
						$Consulta = $Consulta." and (t2.fecha_hora between '".$FechaI."' and '".$FechaT."') ";//and (t1.estado_actual = '6') "; 					
						//echo $Consulta."<br>";
						echo "<input type='hidden' name ='checkSA' ><input type='hidden' name ='TxtSA' >";
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo "<tr>";
							echo "<td width='2'><input type='checkbox' name ='checkSA' value=''></td>"; 
							echo "<td width='100'><input name='TxtSA' type='text' readonly style='width:80' maxlength='80' value =".$TxtSA = $Fila["nro_solicitud"]."><input name = 'TxtRecargo' type = 'hidden' value ='N'><input name = 'TxtEstadoO' type = 'hidden' value =".$TxtEstadoO = $Fila["nombre_subclase"]."></td>";
							echo "</tr>";		
						}
					}				
					//Pregunta si la busqueda se hace mostrando todas las solicitudes o en forma directa
					if ($Mostrar == 'D' )
					{
						if($AnoIni2=="")
							$AnoIni2 = 0;
						if($NumIni=="")
							$NumIni = 0;
						if($AnoFin2=="")
							$AnoFin2 = 0;
						if($NumFin=="")
							$NumFin = 0;
						$SolIni = $AnoIni2."000000";
						$SolFin = $AnoFin2."000000";
						$SolIni = $SolIni + $NumIni;
						$SolFin = $SolFin + $NumFin;
						if ($NumFin=="")
							$SolFin = $SolIni;
						$Consulta ="select  distinct t1.nro_solicitud ";
						$Consulta = $Consulta." from cal_web.solicitud_analisis t1 ";	
						$Consulta = $Consulta."	inner join proyecto_modernizacion.subproducto t2 ";
			 			$Consulta = $Consulta."	on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
						$Consulta = $Consulta. " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_subclase = t1.estado_actual and t3.cod_clase = '1002'"; 
						$Consulta = $Consulta. " inner join proyecto_modernizacion.productos t4 on t4.cod_producto = t1.cod_producto "; 
						$Consulta = $Consulta. " where (t1.nro_solicitud between '".$SolIni."' and '".$SolFin."'  )";
						$Consulta = $Consulta. " order by t1.nro_solicitud "; 
						//echo $Consulta;
						echo "<input type='hidden' name ='checkSA' ><input type='hidden' name ='TxtSA' >";
						$Respuesta = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							$nro_solicitud   = isset($Fila["nro_solicitud"])?$Fila["nro_solicitud"]:"";
							$nombre_subclase = isset($Fila["nombre_subclase"])?$Fila["nombre_subclase"]:"";
							echo "<tr>";
							echo "<td width='2'><input type='checkbox' name ='checkSA' value=''></td>"; 
							echo "<td width='100'><input name='TxtSA' type='text' readonly style='width:80' maxlength='80' value =".$TxtSA = $nro_solicitud."><input name = 'TxtRecargo' type = 'hidden' value ='N'><input name = 'TxtEstadoO' type = 'hidden' value =".$TxtEstadoO = $nombre_subclase."></td>";
							echo "</tr>";		
						}
					 }
					?>
          </table>
        </div>
        <br> 
        <table width="428" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="28" height="30">#SolI</td>
            <td width="144"><font size="1"><font size="1"><font size="2">
              <select name="AnoIni2" style="width:60px;">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoIni2))
				{
					if ($i == $AnoIni2)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		?>
              </select>
              <input name="NumIni" type="text" id="NumIni2" value="<?php echo $NumIni; ?>" size="10" maxlength="15">
              </font></font></font> </td>
            <td width="175"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font><font size="1"><font size="2">#SolF&nbsp;<font size="1">&nbsp; 
              <select name="AnoFin2" style="width:50px;">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoFin2))
				{
					if ($i == $AnoFin2)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		?>
              </select>
              <input name="NumFin" type="text" id="NumFin2" value="<?php echo $NumFin; ?>" size="10" maxlength="15">
              </font></font></font></td>
            <td width="34"> <div align="center"> </div>
              <div align="left"> </div>
              <div align="center"><font size="1"><font size="1"><font size="2"> 
                <input name="BtnOk2" type="button" id="BtnOk22" value="Ok" onClick="Proceso('D');">
                </font></font></font> </div></td>
          </tr>
        </table>
        <br>
      </td>
      <td width="322"><table width="322" height="182" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="193">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td colspan="2"><table width="754" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="89"><input name="CheckTodos" type="checkbox" id="CheckTodosD2" value="checkbox" onClick="Activar2();">
              Todos</td>
            <td width="182"><div align="center"> 
                <input name="BtnHistorial" type="button" id="BtnHistorial" value="Ver Historial" onClick="Historial('H');">
              </div></td>
            <td width="294"> <div align="center"> 
                <?php
				if (($Nivel=='2')||($Nivel=='3')||($Nivel=='1')||($Nivel=='6')||($Nivel=='36') || ($Nivel=='28') || ($Nivel=='38'))
				{
					echo "<input name='BtnEstAnterior' type='button'  value='Estado Anterior' style='width:100' onClick=\"EstAnterior();\">&nbsp;&nbsp;&nbsp;";
					echo "<input name='BtnEstActual' type='button'  value='Rec.Est Reg' style='width:80' onClick=\"RecEstReg();\">&nbsp;&nbsp;&nbsp;";
					echo "<input name='BtnAnular' type='button'  value='Anular' style='width:60' onClick=\"Proceso('A');\">";
             	}
			  ?>
			  </div></td>
            <td width="162"><input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60" onClick="Proceso('S');"></td>
          </tr>
        </table>
        <br> 
        <table width="753" border="0" cellpadding="0" class="TablaInterior" bordercolor="#b26c4a">
          <tr class="ColorTabla01"> 
            <td width="747"><div align="center"></div></td>
            <?php
		   if ($Mostrar =='O')
		   {
		   //		echo  "<td width='30'><div align='left'></div></td>";
           
		   		echo  "<td width='100'><div align='center'>#SA</div></td>";
           		echo "<td width='130'><div align='center'>ESTADO SA</div></td>";
				echo "<td width='130'><div align='center'>ESTADO REG</div></td>";
           		echo "<td width='230'><div align='center'>PRODUCTO</div></td>";
           		echo "<td width='250'><div align='center'>SUBPRODUCTO</div></td>";
           }
		   if ($Mostrar =='I')
		   {		
				echo  "<td width='100'><div align='center'>#SA</div></td>";
           		echo "<td width='130'><div align='center'>ESTADO SA</div></td>";
				echo "<td width='130'><div align='center'>ESTADO REG</div></td>";
           		echo "<td width='230'><div align='center'>PRODUCTO</div></td>";
           		echo "<td width='250'><div align='center'>SUBPRODUCTO</div></td>";
		   }
			//la busqueda se realizo por busqueda de producto y subproducto es decir si clickeo busqueda e ingresar
			if ($Mostrar == 'I' )
			{
				//echo "SA:".$SA."<br>";
				for ($j = 0;$j <= strlen($SA); $j++)
				{
					if (substr($SA,$j,2) == "//")
					{	
						$Solicitud = substr($SA,0,$j);
						$Consulta ="select   distinct t1.nro_solicitud,t1.tipo_solicitud,t4.descripcion as DesProducto,t2.descripcion as DesSubProducto,t4.cod_producto   from cal_web.solicitud_analisis t1";	
						$Consulta = $Consulta."	inner join proyecto_modernizacion.subproducto t2 ";
						$Consulta = $Consulta."	on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
						$Consulta = $Consulta. " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_subclase = t1.estado_actual and t3.cod_clase = '1002'"; 
						$Consulta = $Consulta. " inner join proyecto_modernizacion.productos t4 on t4.cod_producto = t1.cod_producto "; 
						$Consulta = $Consulta. " where (nro_solicitud = '".$Solicitud."' and nro_solicitud <> '0' and nro_solicitud<>'') ";
						echo "<input type='hidden' name ='checkAtender' ><input type='hidden' name ='checkSA' ><input type='hidden' name ='TxtSAO' >";
						//echo $Consulta."<br>";
						$Respuesta = mysqli_query($link, $Consulta);
						if ($Fila = mysqli_fetch_array($Respuesta))
						{
								echo "<tr>";
								echo "<td width='5' align='rigth'><input type='checkbox' name ='checkAtender' value=''></td>"; 
								echo "<td width='110'><div align='rigth'><input name='TxtSAO' type='text' readonly style='width:100' maxlength='100' value =".$TxtSA = $Fila["nro_solicitud"]."><input name = 'TxtRecargo' type = 'hidden' value ='N'></div></td>";
								$Consulta = "select  t1.estado_actual,t2.nombre_subclase from cal_web.solicitud_analisis t1 "; 
								$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t2 ";
								$Consulta = $Consulta." on t1.estado_actual = t2.cod_subclase and t2.cod_clase = '1002'  ";
								$Consulta = $Consulta." where nro_solicitud = '".$Solicitud."' order by t2.valor_subclase4";
								//echo $Consulta."<br>";
								$Respuesta0 = mysqli_query($link, $Consulta);
								while ($Fila0 = mysqli_fetch_array($Respuesta0))
								{	
									//pregunta para saber cual es el ultimo estado de la solicitud 
									switch ($Fila0["estado_actual"]) 
									{
										//creadas
										case "1":
											$EstadoActual= $Fila0["estado_actual"];
											break;
										//directo a calidad
										case "12":
											$EstadoActual= $Fila0["estado_actual"];
											break;
										//recepcionado
										case "2":
											$EstadoActual= $Fila0["estado_actual"];
											break;
										//atendido en muestrera
										case "13":
											$EstadoActual= $Fila0["estado_actual"];
											break;
										//eliminado
										case "7":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//pendiente
										case "8":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//activados
										case "14":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Enviados a laboratorio
										case "3":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Recepcionados en Contro calidad
										case "4":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Atendidos por quimico
										case "5":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Anulados
										case "16":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Finalizados
										case "6":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Certificados
										case "15":
											$EstadoActual= $Fila0["estado_actual"];
											break;	
										//Atendidos en lab frx
										case "31":
											$EstadoActual= $Fila0["estado_actual"];
										break;
										//Finalizado en lab frx
										case "32":
											$EstadoActual= $Fila0["estado_actual"];
										break;
									}
								}
								//consulta que rescata el nombre del estado 
								$Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase = '1002' and cod_subclase = '".$EstadoActual."' ";
								//echo $Consulta."<br>";
								$Respuesta9 = mysqli_query($link, $Consulta);
								$Fila9 = mysqli_fetch_array($Respuesta9);
								if ($EstadoActual=='4')
								{
									$Fila9["nombre_subclase"]=$Fila9["nombre_subclase"].""."Calidad";								
								}
								echo "<td width='130'><div align='rigth'><input name='TxtEstado' type='text' readonly style='width:130' maxlength='10' value ='".$Fila9["nombre_subclase"]."'></div></td>";
								$Consulta="select t2.nombre_subclase as estado_reg,ceiling(t2.valor_subclase4) as cod_est from cal_web.estados_por_solicitud t1 ";
								$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t2 ";
								$Consulta = $Consulta." on t1.cod_estado = t2.cod_subclase and t2.cod_clase = '1002'  ";
								$Consulta = $Consulta." where t1.nro_solicitud='".$Solicitud."' order by t1.fecha_hora desc,cod_est desc";
								//echo $Consulta."<br>";
								$RespEst=mysqli_query($link, $Consulta);
								$EstReg='';
								if($FilaEst=mysqli_fetch_assoc($RespEst))
									$EstReg=$FilaEst["estado_reg"];
								echo "<td width='100'><div align='rigth'><input name='TxtEstado2' type='text' readonly style='width:130' maxlength='10' value ='".$EstReg."'></div></td>";
								echo "<td width='180'><div align='rigth'><input name='TxtProducto' type='text' readonly style='width:250' maxlength='10' value ='".$TxtProducto = $Fila["DesProducto"]."'><input type='hidden' value='".$Fila["cod_producto"]."'></div></td>";				
								echo "<td width='180'><div align='rigth'><input name='TxtSubProducto' type='text' readonly style='width:250' maxlength='10' value ='".$TxtSubProducto = $Fila["DesSubProducto"]."'></div></td>";				
								echo "</tr>";
						}
					 	$SA = substr($SA,$j + 2);
						$j = 0;
					 }		
				}		
			}
			?>
		  </tr>
        </table></td>
    </tr>
  </table>
 <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
