<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;

?>



<html>
<head>
<title>Administracion de Solicitudes de Muestreo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion,FechaAtencion)
{
	var frm=document.FrmRecepcion;
	switch (Opcion)
	{
		case "B": 
			frm.action ="cal_adm_solicitud_muestreo.php";  
			frm.submit();
			break;	
		case "A":
			RecuperarSA(FechaAtencion);
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
			CambiarEstado();
			break; 
	}	

}
function Activar()
{
	
	var frm=document.FrmRecepcion;
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
function RecuperarSA(FechaA)
{
	var frm=document.FrmRecepcion;
	var LargoForm = frm.elements.length;
	var ValoresSA="";
	var CheckeoAtencion="";
	var Solicitudes ="";
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
		{
			ValoresSA = ValoresSA + frm.elements[i+2].value + "~~" + frm.elements[i+3].value + "||" + frm.elements[i+4].value + "//" ;
			Solicitudes =Solicitudes + frm.elements[i+1].value + " , " ;
			CheckeoAtencion = true;
		}
	}
	if (CheckeoAtencion == false)
	{
		alert ("No Hay Elemntos Seleccionados");
	}
	else
	{
		
		window.open("cal_atencion_solicitud_muestreo.php?ValoresSA="+ ValoresSA + "&FechaA="+ FechaA + "&Solicitudes="+ Solicitudes,"","top=200,left=35,width=640,height=300,scrollbars=no,resizable = yes");					
	}
}
function ValidarModificar()
{
var frm =document.FrmRecepcion;
var LargoForm =frm.elements.length;
var SolA="";
var cont =0;
var CheckeoModifica=false;
var Fecha="";
var RutF="";
for (i=0;i < LargoForm;i++)
{
	if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
	cont =cont + 1;
}
if ((cont > 1)||(frm.elements[9].checked==true))
{
	alert ("Debe seleccionar solo una Solicitud");
	return;
} 
for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
		{
			SolA = frm.elements[i+2].value ;
			Recargo=frm.elements[i+4].value ;
			RutF=  frm.elements[i+3].value;
			Fecha = frm.elements[i+6].value + ' ' + frm.elements[i+7].value;
			
			CheckeoModifica = true;
			break;
		}
	}
if (CheckeoModifica == false)
	{
		alert ("No Hay Elemntos Seleccionados");
	}
	else
	{
		window.open("cal_modificacion_leyes.php?SolA="+ SolA +"&Recargo="+Recargo + "&Fecha="+ Fecha +"&RutF="+ RutF,"","top=200,left=35,width=640,height=300,scrollbars=no,resizable = yes");					
	}
}
function Salir()
{
	var frm =document.FrmRecepcion;
	frm.action="cal_atencion_solicitud_muestreo01?Opcion=S";
	frm.submit(); 
}
//funcion validar detalle
function ValidarDetalle()
{
var frm =document.FrmRecepcion;
var LargoForm =frm.elements.length;
var SA="";
var RutF="";
var Recargo ="";
var Muestra="";
var Lotes="";
var Productos="";
var NombreF="";
var Estado="";
var FechaC="";
var FechaAt="";
var cont =0;
var CheckeoDetalle=false;
for (i=0;i < LargoForm;i++)
{
	if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
	cont =cont + 1;
}

if ((cont > 1)||(frm.elements[9].checked==true))
{
	alert ("Debe seleccionar solo una Solicitud");
	return;
} 

for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
		{
			SA = frm.elements[i+2].value ;
			RutF =frm.elements[i+3].value ;
			Recargo = frm.elements[i+4].value
			Muestra =frm.elements[i+5].value ;			
			Lotes =frm.elements[i+8].value ; 
			Productos =frm.elements[i+9].value ;
			NombreF =frm.elements[i+10].value ;
			Estado = frm.elements[i+11].value ;
			FechaC = frm.elements[i+12].value ;
			FechaAt = frm.elements[i+13].value ;
			CheckeoDetalle = true;
			break;
		}
	}
if (CheckeoDetalle == false)
	{
		alert ("No Hay Elemntos Seleccionados");
	}
	else
	{
		window.open("cal_detalle_solicitud_muestreo.php?SA="+ SA + "&RutF="+ RutF + "&Muestra="+ Muestra + "&Lotes="+ Lotes + "&Productos="+ Productos + "&NombreF="+ NombreF + "&Estado="+ Estado + "&FechaC="+ FechaC + "&FechaAt="+ FechaAt + "&Recargo="+Recargo,"","top=200,left=35,width=780,height=300,scrollbars=no,resizable = yes");					
	}
}
function CambiarEstado()
{
	var frm=document.FrmRecepcion;
	var LargoForm = frm.elements.length;
	var TSaRutFecha="";
	var CheckeoEstado="";
	var Estado="E";
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
		{
			TSaRutFecha = TSaRutFecha + frm.elements[i+2].value + "~~" + frm.elements[i+3].value + "//" + frm.elements[i+6].value + ' ' + frm.elements[i+7].value + frm.elements[i+4].value + "||" ;
			CheckeoEstado = true;
		}
	}
	if (CheckeoEstado == false)
	{
		alert ("No Hay Elemntos Seleccionados");
	}
	else
	{

		window.open("cal_atencion_solicitud_muestreo01.php?TSaRutFecha="+ TSaRutFecha + "&Opcion=E","","top=200,left=35,width=640,height=300,scrollbars=no,resizable = yes");					
	}
}



</script>






</head>

<body>
<form name="FrmRecepcion" method="post" action="">
  <table width="780" border="1">
    <tr> 
      <td colspan="2"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;<?php echo $Fecha_Hora ?></strong>&nbsp; 
          <strong>
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
          </strong> </font></font></div></td>
      <td width="335"><div align="center"><strong>RECEPCION DE SOLICITUDES DE 
          ANALISIS</strong></div></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td height="38" colspan="5"> &nbsp;&nbsp; <strong>
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
	  </td>
    </tr>
    <tr> 
      <td height="31" colspan="2">Fecha Inicio<font size="2"> 
        <select name="CmbDias" id="select22" size="1" style="font-face:verdana;font-size:10">
          <?php
			for ($i=1;$i<=31;$i++)
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
			?>
        </select>
        </font> <font size="2"> 
        <select name="CmbMes" size="1" id="select23" style="FONT-FACE:verdana;FONT-SIZE:10">
          <?php
		  for($i=1;$i<13;$i++)
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
		    ?>
        </select>
        </font> <font size="2"> 
        <select name="CmbAno" size="1" id="select24" style="FONT-FACE:verdana;FONT-SIZE:10">
          <?php
			for ($i=date("Y");$i<=date("Y");$i++)
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
			?>
        </select>
        </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
      </td>
      <td>Fecha Termino<font size="1"><font size="2"><font size="1"><font size="2"> 
        </font></font> 
        <select name="CmbDiasT" id="select25" size="1" style="font-face:verdana;font-size:10">
          <?php
			for ($i=1;$i<=31;$i++)
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
			?>
        </select>
        </font> <font size="2"> 
        <select name="CmbMesT" size="1" id="select26" style="FONT-FACE:verdana;FONT-SIZE:10">
          <?php
		  for($i=1;$i<13;$i++)
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
		   ?>
        </select>
        </font> <font size="2"> 
        <select name="CmbAnoT" size="1" id="select27" style="FONT-FACE:verdana;FONT-SIZE:10">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
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
			?>
        </select>
        </font></font></td>
      <td width="57"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
          <select name="CmbEstado" id="CmbEstado">
            <option value="-1" selected>Todas</option>
            <?php
		 $Consulta =  "select * from sub_clase where cod_clase = 1002 and cod_subclase = 3 or cod_subclase = 4 ";
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
          </font></font></strong> </font></font></div></td>
      <td width="75"><div align="center"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
          <input name="BtnBuscar" type="submit" id="BtnBuscar2" value="Buscar" onClick="Proceso('B');">
          </font></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
          </font></font></div></td>
    </tr>
    <tr> 
      <td width="109" height="34"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name="checkTodos" type="checkbox" onClick="JavaScript:Activar();" value="checkbox">
        Todos</font></font></td>
      <td width="170"> <div align="center">
          <input name="BtnEliminar" type="button" id="BtnActualizar2" value="Eliminar" onClick="Proceso('E');">
        </div></td>
      <td><input name="BtnRecepcionar" type="button" id="BtnEliminar" value="Recepcionar">
        &nbsp;&nbsp; 
        <input name="BtnActualizar2" type="submit" id="BtnActualizar" value="Actualizar"></td>
      <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        </font></font></td>
      <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        </font></font></td>
    </tr>
  </table>
  <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
  </font></font> 
  <table width="780" border="1" >
    <tr> 
      <td height="28" colspan="2"><div align="center">S.A</div></td>
      <td width="68"><div align="left">Id Muestra</div></td>
      <td width="198"><div align="center"></div>
        <div align="center">Producto</div></td>
      <td width="133"><div align="center">Originador</div></td>
      <td width="75"><div align="center">Estado</div></td>
      <td width="78"><div align="center">F.Muestreo</div></td>
      <td width="83"><div align="center">F.Recep-Lab</div></td>
    </tr>
    <?php
	 	include ("../Principal/conectar_cal_web.php");	
		$FechaI = $CmbAno."-".$CmbMes."-".$CmbDias.'00:01';
		$FechaT = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT.'23:59';
		switch ($CmbEstado) 
		{
			case "-1":
				$Estado ="where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."') or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and (t1.estado_actual = '1' or t1.estado_actual = '2')";
				break;
		 
			case "1":
				$Estado = "where (t1.fecha_hora between  '".$FechaI."' and '".$FechaT."') and (t1.estado_actual = '1')";
				break;		 
		 	case "2": 
		 		$Estado = "where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."')  or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and (t1.estado_actual = '2')";
				break;
			default:
				$Estado ="where ((t1.fecha_hora between  '".$FechaI."' and '".$FechaT."') or (t6.fecha_hora between  '".$FechaI."' and '".$FechaT."')) and (t1.estado_actual = '1' or t1.estado_actual = '2')";
				break;
		}
		$Consulta = "select t2.descripcion as nomproducto,t3.descripcion as nomsubproducto,";
		$Consulta = $Consulta."t1.rut_funcionario,t1.recargo,t1.fecha_hora, ";
		$Consulta = $Consulta."concat(t4.nombres,' ',t4.apellido_paterno,' ',t4.apellido_materno) as nombreapellido, ";
		$Consulta =	$Consulta."t1.nro_solicitud,t1.id_muestra,t1.fecha_hora as FechaCreacion,t7.nombre_subclase,t6.fecha_hora as FechaAtencion,t6.cod_estado ";
		$Consulta = $Consulta."from cal_web.solicitud_analisis t1 " ;
		$Consulta = $Consulta."inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
		$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
		$Consulta = $Consulta."inner join proyecto_modernizacion.funcionarios t4 on t4.rut=t1.rut_funcionario ";
		$Consulta = $Consulta."left join cal_web.estados_por_solicitud t6 on (t1.rut_funcionario=t6.rut_funcionario) and (t1.nro_solicitud = t6.nro_solicitud) and (t1.recargo = t6.recargo) and (t1.estado_actual = t6.cod_estado)";
		$Consulta = $Consulta."inner join proyecto_modernizacion.sub_clase t7 on t1.estado_actual = t7.cod_subclase  and t7.cod_clase = '1001'";
		$Consulta = $Consulta.$Estado;
		$Respuesta= mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Respuesta))
	  	{
	  		echo "<tr>";
			echo "<td width='25' align='rigth'><input type='checkbox' name ='checkAtender' value=''></td>"; 
			if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))	
			{
				echo "<td width='80'><div align='center'><input name='TxtSA' type='text' readonly style='width:80' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"]."><input type = 'hidden' value =".$Fila["nro_solicitud"]."><input type = 'hidden' value =".$Fila["rut_funcionario"]."><input type = 'hidden' value ='N'></div></td>";
			}
			else
			{
				echo "<td width='80'><div align='center'><input name='TxtSA' type='text' readonly style='width:80' maxlength='10' value =".$TxtSA = $Fila["nro_solicitud"].'-'.$Fila["recargo"]."><input type = 'hidden' value =".$Fila["nro_solicitud"]."><input type = 'hidden' value =".$Fila["rut_funcionario"]."><input type = 'hidden' value =".$Fila["recargo"]."></div></td>";			
			}	
      		echo "<td width='68'><div align='left'><input name='TxtIdMuestra' type='text' readonly style='width:67' maxlength='10' value =".$TxtIdMuestra = $Fila["id_muestra"]."><input  type = 'hidden' value =".substr($Fila["fecha_hora"],0,10)."><input type = 'hidden' value =".substr($Fila["fecha_hora"],11,8)."></div></td>";				
			
			/*if ((is_null($Fila["recargo"])) || ($Fila["recargo"] ==''))	
			{
	    		echo "<td width ='80'><div align ='left'><input name ='TxtLotes' type='text' readonly style='width:80' maxlength='20'value =''></div></td>";			
			}
			else
			{
				echo "<td width ='80'><div align ='left'><input name ='TxtLotes' type='text' readonly style='width:80' maxlength='20'value =".$TxtLotes =$Fila["id_muestra"]."></div></td>";		
			}*/	
			echo "<td width ='110'><div align ='left'><input name ='TxtProducto' type='text' readonly style='width:110' maxlength='110' value ='".$TxtProducto= ucwords(strtolower($Fila["nomproducto"]))." ".ucwords(strtolower($Fila["nomsubproducto"]))."'></div></td>";
      		echo "<td width ='120'><div align ='left'><input name ='TxtFuncionario' type='text' readonly style='width:120' maxlength='120' value ='".$TxtFuncionario=ucwords(strtolower($Fila["nombreapellido"]))."'></div></td>";
      		echo "<td width ='70'><div align ='left'><input name ='TxtEstados' type='text' readonly style='width:80' maxlength='70'value =".$TxtEstado= $Fila["nombre_subclase"]."></div></td>";
      		echo "<td width ='70'><div align ='left'><input name ='TxtFecha' type='text' readonly style='width:70' maxlength='70'value =".$TxtFecha= $Fila["FechaCreacion"]."></div></td>";
			if ($Fila["cod_estado"]== '2')
			{
     			echo "<td width ='70'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:70' maxlength='70'value =".$TxtFechaAt= $Fila["FechaAtencion"]."></div></td>";		
			}
			else
			{
				echo "<td width ='70'><div align ='left'><input name ='TxtFechaAt' type='text' readonly style='width:70' maxlength='70'value =''></div></td>";		
			}
			echo "</tr>";
	   }
	   ?>
  </table>
  <table width="780" border="1" >
    <tr> 
      <td width="200"><div align="right"> 
          <input name="BtnDetalle" type="button" id="BtnDetalle" value="Detalle" onClick="Proceso('D');">
        </div></td>
      <td><div align="center"> </div>
        <div align="center">
          <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60" onClick="Proceso('S');">
        </div></td>
      <td width="163">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>
