<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y H:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;
$CodigoDeSistema = 1;
$CodigoDePantalla = 5;

$CmbDias            = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:date("d");
$CmbMes             = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
$CmbAno             = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
$CmbDiasT           = isset($_REQUEST["CmbDiasT"])?$_REQUEST["CmbDiasT"]:date("d");
$CmbMesT            = isset($_REQUEST["CmbMesT"])?$_REQUEST["CmbMesT"]:date("m");
$CmbAnoT            = isset($_REQUEST["CmbAnoT"])?$_REQUEST["CmbAnoT"]:date("Y");
$CmbEstado          = isset($_REQUEST["CmbEstado"])?$_REQUEST["CmbEstado"]:"";
$Mostrar            = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
$LimitIni           = isset($_REQUEST["LimitIni"])?$_REQUEST["LimitIni"]:0;
$LimitFin           = isset($_REQUEST["LimitFin"])?$_REQUEST["LimitFin"]:10;
$Nivel              = isset($_REQUEST["Nivel"])?$_REQUEST["Nivel"]:0;

$Consulta = "SELECT * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '1'  ";
$Respuesta =mysqli_query($link, $Consulta);
if($Fila =mysqli_fetch_array($Respuesta))
{
	$Nivel = $Fila["nivel"];	
}

?>
<html>
<head>
<title></title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
//function Proceso(Opcion,FechaAtencion)
function Proceso(Opcion)
{
	var frm=document.FrmConsultaRecepcion;
	switch (Opcion)
	{
		case "B": 
			if (frm.CmbEstado.value=='-1')
			{
				alert ("seleccione un estado");
				return;
			}
			else
			{
				var TotalDiasT=0;
				var CantDiasI=0;
				var CantDiasT=0;
				var TotalDiasI=0;
				var DifDias=0;
				var Mostrar =1;
				CantDiasI=365*parseInt(frm.CmbAno.value);
				TotalDiasI=parseInt(CantDiasI)+(31*parseInt(frm.CmbMes.value))+parseInt(frm.CmbDias.value);
				CantDiasT=365*parseInt(frm.CmbAno.value);
				TotalDiasT=CantDiasT+(31*parseInt(frm.CmbMesT.value))+parseInt(frm.CmbDiasT.value);
				DifDias=TotalDiasT-TotalDiasI;
				if (DifDias > 65)
				{
					alert("Rango de busqueda debe ser 2 meses aprox.")
					Mostrar=2;
					return;
				}
				if (frm.CmbAnoT.value==frm.CmbAno.value)
				{
					if ((frm.CmbMesT.value-frm.CmbMes.value)>2)
					{
						alert("El rango de fecha debe ser menor o igual a 2 meses");
						Mostrar=2;
						return;
					}
				}
				if (Mostrar == 1)
				{
					frm.action ="cal_con_recepcion_control_calidad.php?Mostrar=S";  
					frm.submit();
				}
			}
			break;	
		
		case "S":
			Salir();
			break;	
	}	
}
function Excel()
{
	var frm =document.FrmConsultaRecepcion;
	if (frm.CmbEstado.value=='-1')
	{
		alert ("seleccione un estado");
		return;
	}
	else
	{
		frm.action ="cal_con_recepcion_control_calidad_excel.php?Mostrar=S";  
		//frm.action ="prueba.php?Mostrar=S";
		frm.submit();
		return;
	}
	
}
function Salir()
{
	var frm =document.FrmConsultaRecepcion;
	frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	frm.submit(); 
}
function Historial(SA,Rec,N)
{
	if ((N=='13')||(N=='1')||(N=='2')||(N=='3')||(N=='5'))
	{	
		window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
	}
	else
	{
		window.open("cal_con_registro_leyes_sin_leyes.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");						
	}
}
function Recarga(URL,LimiteIni,CmbEstado,Mostrar,Nivel)
{
	var frm=document.FrmConsultaRecepcion;
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "?LimitIni=" + LimiteIni+"&CmbEstado="+CmbEstado+"&Mostrar="+Mostrar+"&Nivel="+Nivel;
	frm.submit(); 
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body background="../principal/imagenes/fondo3.gif">
<form name="FrmConsultaRecepcion" method="post" action="">
 <?php
	/*if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 10;*/
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <tr> <td width="756"></tr>
  <tr> 
    <table width="761" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr> 
        <td width="90"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            Usuario:</font></font></div></td>
        <td width="232"><strong> 
          <?php
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
	  	$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
		{	
			echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
		}	  
	  	else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
					}
		
			}
		  ?>
          </strong></td>
        <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha:<strong> 
          </strong></font></font></td>
        <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
          <?php echo $Fecha_Hora ?>
          </strong>&nbsp; <strong> 
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
		  ?>
          </strong></font></font></td>
      </tr>
      <tr> 
        <td height="31">Fecha Inicio<font size="2">:&nbsp; </font></td>
        <td><font size="2"> 
          <select name="CmbDias" style="width:40px;">
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
          <select name="CmbMes" style="width:90px;">
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
          </font> <select name="CmbAno" style="width:70px;">
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
          </select> </td>
        <td width="99">Fecha Termino:</td>
        <td width="313"> <select name="CmbDiasT" style="width:40px;">
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
          </select> <select name="CmbMesT" style="width:90px;">
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
          </select> <select name="CmbAnoT" style="width:70px;">
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
      </tr>
      <tr> 
        <td height="31">Estado: </td>
        <td><select name="CmbEstado" style="width:220"  >
            <option value="-1" selected>Seleccionar</option>
            <?php
				
				 $CmbEstadoAux=$CmbEstado;
				 if ($Mostrar=="S")
				 {
					//if (($Nivel=="1")||($Nivel=="2")||($Nivel=="3")||($Nivel=="6"))
					if (($Nivel >= '1')&& ($Nivel <='20')) 
					{
						if (($CmbEstado !="-1") &&  ($CmbEstado !="1") &&  ($CmbEstado !="2")&&  ($CmbEstado !="13")&&  ($CmbEstado !="16")&&  ($CmbEstado !="7")&&  ($CmbEstado !="8")&&($CmbEstado !='31') &&($CmbEstado != '32'))
						{
							$CmbEstado=substr($CmbEstado,0,strlen($CmbEstado)-1);
						}
					}
				 }
				 $Consulta ="select * from sub_clase where cod_clase = 1002 and (cod_subclase ='3'  or cod_subclase ='13' ";
				 $Consulta = $Consulta." or cod_subclase ='6' or cod_subclase ='5' or cod_subclase = '12' or cod_subclase = '1' ";
				 $Consulta = $Consulta." or cod_subclase = '2' or cod_subclase = '16' or cod_subclase = '7'  or cod_subclase = '8' or cod_subclase = '31'or cod_subclase = '32') " ;
     			 $Consulta = $Consulta."order by valor_subclase5";	
				 $Resultado = mysqli_query($link, $Consulta);
				 while ($Fila =mysqli_fetch_array ($Resultado))
				 {
					if ($CmbEstado == $Fila["cod_subclase"])
					{
						//estado creadas
						if ($Fila["cod_subclase"]=="1")
						{
							echo"<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
						}
						//estado recepcionado en muestrera
						if ($Fila["cod_subclase"]=="2")
						{
							echo"<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
						}
						//estado atendido en muestrera
						if ($Fila["cod_subclase"]=="13")
						{
							echo"<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
						}
						//estado Anuladas por el jefe de area de control de calidad 
						if ($Fila["cod_subclase"]=="16")
						{
							echo"<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
						}
						//estado Eliminadas por el encargado de muestrera o jefe de muestrera
						if ($Fila["cod_subclase"]=="7")
						{
							echo"<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
						}
						//pendinte por el jefe de muestrera
						if ($Fila["cod_subclase"]=="8")
						{
							echo"<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
						}
						if ($Fila["cod_subclase"]=="3")
						{
							switch ($Nivel)
							{
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Enviada a Laboratorio</option>";
									break;
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Enviada a Laboratorio</option>";
									break;
								case "30":
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
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Recepcionado Laboratorio Quimico</option>";
									break;
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Recepcionado Laboratorio Quimico</option>";
									break;
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Recepcionado Ensayo Fisico</option>";
									break;
								default:
									if ((substr($CmbEstadoAux,strlen($CmbEstadoAux)-1,1))=="Q")
									{
										echo"<option value='".$Fila["cod_subclase"]."Q' selected>Recepcionado Laboratorio Quimico</option>";
										echo"<option value='".$Fila["cod_subclase"]."F'>Recepcionado Ensayo Fisico</option>";
									}
									else
									{	
										echo"<option value='".$Fila["cod_subclase"]."Q'>Recepcionado Laboratorio Quimico</option>";
										echo"<option value='".$Fila["cod_subclase"]."F' selected>Recepcionado Ensayo Fisico</option>";
									}	
									break;
							}		
						}
						if ($Fila["cod_subclase"]=="5")
						{
							switch ($Nivel)
							{
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Atendidoo por Quimico</option>";
									break;
								
								default:
									if ((substr($CmbEstadoAux,strlen($CmbEstadoAux)-1,1))=="Q")
									{
										echo"<option value='".$Fila["cod_subclase"]."Q' selected>Atendido por Quimico Analitico</option>";
										echo"<option value='".$Fila["cod_subclase"]."F'>Atendido por Quimico Fisico</option>";
									}
									else
									{	
										echo"<option value='".$Fila["cod_subclase"]."Q'>Atendidoo por Quimico Analitico</option>";
										echo"<option value='".$Fila["cod_subclase"]."F' selected>Atendidoo por Quimico Fisico</option>";
									}	
									break;
							}		
						}
						if ($Fila["cod_subclase"]=="6")
						{
							switch ($Nivel)
							{
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Finalizado por Quimico</option>";
									break;
								
								default:
									if ((substr($CmbEstadoAux,strlen($CmbEstadoAux)-1,1))=="Q")
									{
										echo"<option value='".$Fila["cod_subclase"]."Q' selected>Finalizado por Quimico Analitico</option>";
										echo"<option value='".$Fila["cod_subclase"]."F'>Finalizado por Quimico Fisico</option>";
									}
									else
									{	
										echo"<option value='".$Fila["cod_subclase"]."Q'>Finalizado por Quimico Analitico</option>";
										echo"<option value='".$Fila["cod_subclase"]."F' selected>Finalizado por Quimico Fisico</option>";
									}	
									break;
							}		
						}
						if ($Fila["cod_subclase"]=="12")
						{
							switch ($Nivel)
							{
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."' selected>Directo a Laboratorio</option>";
									break;
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'selected>Directo a Laboratorio</option>";
									break;
								case "30":
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
						//atendido por Quimico FRX
						if ($Fila["cod_subclase"]=="31")
						{
							echo"<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
						}
						//finalizado  por Quimico FRX
						if ($Fila["cod_subclase"]=="32")
						{
							echo"<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
						}
					}	
					else////else de la primera vuelta del combo 
					{
						//creado
						if ($Fila["cod_subclase"]=="1")
						{
							echo"<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
						}
						//recepcionado
						if ($Fila["cod_subclase"]=="2")
						{
							echo"<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
						}
						//atendido en muetrera
						if ($Fila["cod_subclase"]=="13")
						{
							echo"<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
						}
						//Anuladas
						if ($Fila["cod_subclase"]=="16")
						{
							echo"<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
						}
						//Elimnada por el jefe de muestrera o encargado de muestrera
						if ($Fila["cod_subclase"]=="7")
						{
							echo"<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
						}
						//Pendiente  por el jefe de muestrera 
						if ($Fila["cod_subclase"]=="8")
						{
							echo"<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
						}
						//enviado a laboratorio
						if ($Fila["cod_subclase"]=="3")
						{
							switch ($Nivel)
							{
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'>Enviado a Laboratorio</option>";
									break;
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'>Enviado a Laboratorio</option>";
									break;
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'>Enviado a Ensayo Fisico</option>";
									break;
								default:
									echo"<option value='".$Fila["cod_subclase"]."Q'>Enviado a Laboratorio</option>";
									echo"<option value='".$Fila["cod_subclase"]."F'>Enviado a Ensayo Fisico</option>";
									break;
							}	
						}
						//recpcionado en laboratorio quimico o fisico 
						if ($Fila["cod_subclase"]=="4")
						{
							switch ($Nivel)
							{
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'>Recepcionado en Laboratorio</option>";
									break;
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'>Recepcionado en Laboratorio</option>";
									break;
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'>Recepcionado en Ensayo Fisico</option>";
									break;
								default:
									echo"<option value='".$Fila["cod_subclase"]."Q'>Recepcionado en Laboratorio</option>";
									echo"<option value='".$Fila["cod_subclase"]."F'>Recepcionado en Ensayo Fisico</option>";
									break;
							}		
						}
						//atendido por quimico
						if ($Fila["cod_subclase"]=="5")
						{
							switch ($Nivel)
							{
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'>Atendido  por quimico</option>";
									break;
								
								default:
									echo"<option value='".$Fila["cod_subclase"]."Q'>Atendido por Qumico Analitico</option>";
									echo"<option value='".$Fila["cod_subclase"]."F'>Atendido por Quimico Fisico</option>";
									break;
							}		
						}
						//finalizado
						if ($Fila["cod_subclase"]=="6")
						{
							switch ($Nivel)
							{
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'>Finalizado  por quimico</option>";
									break;
								
								default:
									echo"<option value='".$Fila["cod_subclase"]."Q'>Finalizado por Qumico Analitico</option>";
									echo"<option value='".$Fila["cod_subclase"]."F'>Finalizado por Quimico Fisico</option>";
									break;
							}		
						}
						//directo 
						if ($Fila["cod_subclase"]=="12")
						{
							switch ($Nivel)
							{
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'>Directo a Laboratorio</option>";
									break;
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'>Directo a Laboratorio</option>";
									break;
								case "30":
									echo"<option value='".$Fila["cod_subclase"]."'>Directo a Ensayo Fisico</option>";
									break;
								default:
									 
									echo"<option value='".$Fila["cod_subclase"]."Q'>Directo a Laboratorio</option>";
									echo"<option value='".$Fila["cod_subclase"]."F'>Directo a Ensayo Fisico</option>";
									break;
							}		
						}
						//atendido por Quimico FRX
						if ($Fila["cod_subclase"]=="31")
						{
							echo"<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
						}
						//finalizado  por Quimico FRX
						if ($Fila["cod_subclase"]=="32")
						{
							echo"<option value='".$Fila["cod_subclase"]."' >".$Fila["nombre_subclase"]."</option>";
						}
					}
				 }
				$CmbEstado=$CmbEstadoAux; 
			 ?>
          </select></td>
        <td align="center" valign="middle"><div align="left">Lineas por P&aacute;g.</div></td>
        <td align="center" valign="middle"><div align="left">
            <input name="LimitFin" type="text" id="LimitFin" value="<?php echo $LimitFin;?>" size="12" maxlength="12">
          </div></td>
      </tr>
      <tr> 
        <td height="31">&nbsp;</td>
        <td colspan="3"> <div align="center"> 
            <input name="BtnBuscar" type="button" id="BtnBuscar" style="width:70"value="Buscar" onClick="Proceso('B');">
            &nbsp; 
            <input name="BtnExcel" type="button" id="BtnSalir2" value="Excel" style="width:70" onClick="Excel('');">
            &nbsp; 
            <input name="BtnSalir2" type="button" id="BtnSalir22" value="Salir" style="width:70" onClick="Proceso('S');">
          </div></td>
      </tr>
    </table>
    <br>
    <table width="990" border="1" cellpadding="0" cellspacing="0" >
      <tr class="ColorTabla01"> 
        <td width="96" height="20"><div align="center">S.A</div></td>
        <td width="114" height="20">Id Muestra</td>
        <td width="135" height="20"><div align="center">F Muestra</div></td>
        <td width="74"><div align="left"> 
            <div align="center"></div>
            <div align="center">Producto</div>
          </div></td>
        <td width="101"><div align="center">Originador</div></td>
        <td width="154"><div align="center">Obs</div></td>
        <td width="135"><div align="center">F.Creacion</div></td>
        <td width="135"> <div align="center">F.Estado</div>
          <div align="center"></div></td>
      </tr>
      <?php
	 	include ("../Principal/conectar_cal_web.php");	
		$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.' 00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.' 23:59';
		$CmbEstado=$CmbEstadoAux;
		$Letra="";
		if (($CmbEstado !='1') && ($CmbEstado !='2')&& ($CmbEstado !='3')&& ($CmbEstado !='13')&& ($CmbEstado !='7')&& ($CmbEstado !='8')&& ($CmbEstado !='16')&& ($CmbEstado!='31') && ($CmbEstado != '32'))
		{
			//if (($Nivel=="1")||($Nivel=="2")||($Nivel=="3")||($Nivel=="6"))
			if (($Nivel >= '1')&& ($Nivel <='20')) 
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
				case "30":
					if ($Letra=='F')
					{
						$TipoAnalisis = " and (t1.cod_analisis = '2')  ";
						
					}
					if ($Letra=='Q')
					{
						$TipoAnalisis = " and (t1.cod_analisis = '1' )   ";
					}
					break;
				
				default: 
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
		}	
		switch ($CmbEstado) 
		{
			//Todos
			case "-1":
				//$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '3') or (t1.estado_actual = '4') or (t1.estado_actual = '12') ";		 		
				break;
			case "1":
				//estado creadas
				//if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				//{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '1')"; 
				//}
				//else
				//{
					//$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '1') and t1.cod_producto <> 1 "; 
				//}
				break;		 
			case "2":
				//Estado Recepcionada
				//if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				//{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '2')";
				//}
				//else
				//{
				//	$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '2') and t1.cod_producto <> 1 ";
				//}	
				break;
			case "3":
				//enviado a laboratorio por el jefe
				//if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				//{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '3')".$TipoAnalisis ;
				//}
				//else
				//{
				//	$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '3') and t1.cod_producto <> 1 ".$TipoAnalisis ;
				//}
				break;		 
		 	case "4": 
		 		//Recepcionado en control de calidad
				//if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				//{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '4')".$TipoAnalisis ;
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '4') and t1.cod_producto <> 1 ".$TipoAnalisis ;
				}*/
				break;
			//Atendido por quimico
			case "5":
				//if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				//{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '5')".$TipoAnalisis;
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '5') and t1.cod_producto <> 1 ".$TipoAnalisis;
				}*/
				break;
			//Estado finalizado 
			case "6":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '6')".$TipoAnalisis;
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '6') and t1.cod_producto <> 1 ".$TipoAnalisis;
				}*/
				break;	
			//directos de control de calidad
			case "12":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '12') ".$TipoAnalisis ;
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '12') and t1.cod_producto <> 1 ".$TipoAnalisis ;
				}*/
				break;
			//eliminado
			case "7":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '7') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '7') and t1.cod_producto <> 1 ";
				}*/
				break;
			//Pendien
			case "8":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '8') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '8') and t1.cod_producto <> 1 ";
				}*/
				break;
			//atendido en muestrera
			case "13":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '13') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '13') and t1.cod_producto <> 1 ";
				}*/
				break;
			//Anuladas
			case "16":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '16') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '16') and t1.cod_producto <> 1 ";
				}*/
				break;
			//atendido por quimico FRX
			case "31":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '31') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '31') and t1.cod_producto <> 1 ";
				}*/
				break;
			//atendido por quimico FRX
			case "32":
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '32') ";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')   and (t1.estado_actual = '32') and t1.cod_producto <> 1 ";
				}*/
				break;	
			default:
				//Todos
				/*if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
				{*/
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and ((t1.estado_actual = '3')or (t1.estado_actual = '4')or(t1.estado_actual = '12'))  and ((t1.cod_analisis = '1') or (t1.cod_analisis = '2'))";
				/*}
				else
				{
					$Estado = "where (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."') and ((t1.estado_actual = '3')or (t1.estado_actual = '4')or(t1.estado_actual = '12'))  and ((t1.cod_analisis = '1') or (t1.cod_analisis = '2')) and t1.cod_producto <> 1 ";
				}*/
				break;
		}
		$Consulta = "SELECT t1.cod_tipo_muestra,t2.descripcion as nomproducto,t3.abreviatura as nomsubproducto,";
		$Consulta = $Consulta."t1.rut_funcionario,t1.recargo,t1.fecha_hora,if(length(t1.recargo)=1,concat('0',t1.recargo),t1.recargo) as recargo_ordenado, ";
		$Consulta = $Consulta."concat(t4.nombres,' ',t4.apellido_paterno,' ',t4.apellido_materno) as nombreapellido, ";
		$Consulta = $Consulta."t4.apellido_paterno as ap_paterno,t1.observacion,t1.fecha_muestra, ";
		$Consulta =	$Consulta."t1.nro_solicitud,t1.nro_sa_lims,t1.id_muestra,t1.cod_analisis,t1.tipo_solicitud,t1.fecha_hora as Fecha_Creacion ,t7.nombre_subclase,t6.fecha_hora as FechaAtencion,t6.cod_estado,t7.cod_subclase ";
		$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
		$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
		$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
		$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
		$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual =t6.cod_estado )";
		$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1002'";
		$Consulta = $Consulta.$Estado."order by nro_solicitud,recargo_ordenado";
		$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin." ";
		$Respuesta= mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Respuesta))
	  	{
	  	  	if ($CmbEstado=='1')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and (fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '1')";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$TxtFechaEstado = $Fila2["fecha_hora"];
					
				}	
			}
			if ($CmbEstado=='2')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and (fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '1')";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$TxtFechaEstado = $Fila2["fecha_hora"];
					
				}	
			}
			if ($CmbEstado=='3')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and (fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '3')";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$TxtFechaEstado = $Fila2["fecha_hora"];
					
				}	
			}
			if ($CmbEstado=='4')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '4') ";
				$Respuesta3 = mysqli_query($link, $Consulta);
				if ($Fila3 = mysqli_fetch_array($Respuesta3))
				{
					$TxtFechaEstado = $Fila3["fecha_hora"];
					
				}	
			}			
			if ($CmbEstado=='5')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '5') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='6')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '6') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='7')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '7') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='8')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '8') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='12')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '12') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='13')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '13') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='16')
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '16') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='31')//atendido por Finalizado FRX
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '31') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			if ($CmbEstado=='32')//Finalizado por Finalizado FRX
			{
				$Consulta ="select fecha_hora from estados_por_solicitud  where (rut_funcionario = '".$Fila["rut_funcionario"]."') and (nro_solicitud = '".$Fila["nro_solicitud"]."') and(fecha_hora between  '".$FechaI."' and '".$FechaT."') and (cod_estado = '32') ";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta4))
				{
					$TxtFechaEstado = $Fila4["fecha_hora"];
					
				}
			}
			echo "<tr>";
				if ($Fila["tipo_solicitud"] == 'R') 
				{					
					$Rec='N';

					if ($Fila["nro_sa_lims"]=='') {
              			echo "<td width='95'><div align='center'>
              			<a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Rec."','".$Nivel."')\">".$TxtSA = $Fila["nro_solicitud"]."</a>
              			<input type = 'hidden' value =".$Fila["nro_solicitud"].">
              			<input type = 'hidden' value =".$Fila["rut_funcionario"].">
              			<input type = 'hidden' value ='N'><input name ='TxtLotes' type='hidden' value =''></div></td>";

              		}else{

              			echo "<td width='95'><div align='center'><a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Rec."','".$Nivel."')\">".$TxtSA = $Fila["nro_sa_lims"]."</a>
              			<input type = 'hidden' value =".$Fila["nro_solicitud"].">
              			<input type = 'hidden' value =".$Fila["rut_funcionario"].">
              			<input type = 'hidden' value ='N'><input name ='TxtLotes' type='hidden' value =''>
              			<input type = 'hidden' value =".$Fila["nro_sa_lims"].">
              			</div></td>";	
              		}

								
				}
				if ($Fila["tipo_solicitud"] == 'A') 
				{
					if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
					{
						if ($Fila["nro_sa_lims"]=='') {
              					$Rec='N';
						echo "<td width='95'><div align='center'>
						<a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Rec."','".$Nivel."')\">".$TxtSA = $Fila["nro_solicitud"]."</a>
						<input type = 'hidden' value =".$Fila["nro_solicitud"].">
						<input type = 'hidden' value =".$Fila["rut_funcionario"].">
						<input type = 'hidden' value ='N'>
						<input name ='TxtLotes' type='hidden' value =".$TxtLotes =$Fila["id_muestra"].">
						<input type = 'hidden' value =".$Fila["nro_sa_lims"]."></div></td>";
          				}else{
              					$Rec='N';
						echo "<td width='95'><div align='center'>
						<a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Rec."','".$Nivel."')\">".$TxtSA = $Fila["nro_sa_lims"]."</a>
						<input type = 'hidden' value =".$Fila["nro_solicitud"].">
						<input type = 'hidden' value =".$Fila["rut_funcionario"].">
						<input type = 'hidden' value ='N'>
						<input name ='TxtLotes' type='hidden' value =".$TxtLotes =$Fila["id_muestra"].">
						<input type = 'hidden' value =".$Fila["nro_sa_lims"]."></div></td>";
          				}

										
					}
					else
					{
						if ($Fila["nro_sa_lims"]=='') {
              					echo "<td width='95'><div align='center'>
						<a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Fila["recargo"]."','".$Nivel."')\">".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."</a>
						<input type = 'hidden' value =".$Fila["nro_solicitud"].">
						<input type = 'hidden' value =".$Fila["rut_funcionario"].">
						<input type = 'hidden' value =".$Fila["recargo"].">
						<input name ='TxtLotes' type='hidden' value =".$TxtLotes =$Fila["id_muestra"].">
						<input type = 'hidden' value =".$Fila["nro_sa_lims"].">
						</div></td>";
              				}else{
              					echo "<td width='95'><div align='center'>
						<a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'".$Fila["recargo"]."','".$Nivel."')\">".$TxtSA = $Fila["nro_sa_lims"].'-'.$Fila["recargo"]."</a>
						<input type = 'hidden' value =".$Fila["nro_solicitud"].">
						<input type = 'hidden' value =".$Fila["rut_funcionario"].">
						<input type = 'hidden' value =".$Fila["recargo"].">
						<input name ='TxtLotes' type='hidden' value =".$TxtLotes =$Fila["id_muestra"].">
						<input type = 'hidden' value =".$Fila["nro_sa_lims"].">
						</div></td>";
              				}

									
					} 
				}				
				echo "<td width='110'><div align='left'>".$TxtIdMuestra = $Fila["id_muestra"]."<input  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
				echo "<td width ='130'><div align ='left'>".$Fila["fecha_muestra"]."&nbsp;</div></td>";		
				echo "<td width ='51'><div align ='left'>".$TxtProducto= ucwords(strtolower($Fila["nomsubproducto"]))."&nbsp;</div></td>";
				echo "<td width ='110'><div align ='left'>".$TxtFuncionario=substr(ucwords(strtolower($Fila["nombreapellido"])),0,1).".".ucwords(strtolower($Fila["ap_paterno"]))."</div></td>";
				if ((is_null($Fila["observacion"])) || ($Fila["observacion"]==''))	
				{
					echo "<td width ='85'><div align ='left'>".$Fila["observacion"]."&nbsp;</div></td>";
				}
				else
				{			
					echo "<td width ='85'><div align ='left'>".$Fila["observacion"]."&nbsp;</div></td>";
				}
				echo "<td width ='135'><div align ='left'>".$TxtFechaCreacion=$Fila["Fecha_Creacion"]."</div></td>";		
				echo "<td width ='135'><div align ='left'>".$TxtFechaEstado."</div></td>";
				echo "</tr>";
	   }
	   ?>
    </table>
  </tr>
  <table width="760" border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td height="25" align="center" valign="middle">Paginas &gt;&gt; <?php		
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
					$StrPaginas.=  "<a href=JavaScript:Recarga('cal_con_recepcion_control_calidad.php','".($i * $LimitFin)."','$CmbEstado','$Mostrar','$Nivel');>";
					$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
				}
			}
			echo substr($StrPaginas,0,-15);
			?>
      </td>
    </tr>
  </table>
  <tr><br>
    <table width="761" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
      <tr> 
        <td width="314"><div align="right"> </div></td>
        <td width="160"><div align="center"> </div>
          <div align="center"> 
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');">
          </div></td>
        <td width="116">&nbsp;</td>
        <td width="144">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  <!--</table>-->
</form>
</body>
</html>
