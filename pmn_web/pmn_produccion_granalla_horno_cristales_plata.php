<?php
include("../principal/conectar_pmn_web.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;
$CodigoDeSistema = 6;
$CodigoDePantalla = 6;
if (!isset($TxtElectrolisis2))
{
	echo "<input name='TxtElectrolisis2' type='hidden' value='<?php echo $TxtElectrolisis; ?>'>";
 	$TxtElectrolisis2=$TxtElectrolisis;
}
else
{ 
	echo "<input name='TxtElectrolisis2' type='hidden' value='<?php echo $TxtElectrolisis2; ?>'>";
}
if ($Mostrar=='V')
{
$Consulta ="select cant_electrolisis,promedio_cajas from pmn_web.produccion_granalla where fecha = '".$Fecha."'";
$Respuesta =mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$TxtCantElectrolisis=$Fila["cant_electrolisis"];	
$ProCajas=$Fila[promedio_cajas];
}
?>
<html>
<head>
<title></title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(Opcion,Bloquear)
{
	var frm= document.FrmProduccionGranalla;
	switch(Opcion)
	{
		case "O"://presiono boton Ok para ingresar  
		Validar();
		break;
		case "E":
			var mensaje = confirm("¿Seguro que desea Eliminar Todos los Registros Asociados a esta fecha?");
			if (mensaje==true)
			{
				frm.action="pmn_produccion_granalla_horno_cristales_plata01.php?CmbDias="+frm.CmbDias.value +"&CmbAno="+frm.CmbAno.value +"&CmbMes="+frm.CmbMes.value + "&Bloquear="+Bloquear +"&Opcion=E"; 
				frm.submit(); 
			}
			else
			{
				return;
			}
		break;
		case "E2":
		ValidarEliminar(Bloquear);
		break;
	}
}
//**************
function Cancelar()
{
	var frm=document.FrmProduccionGranalla;
	frm.action="pmn_produccion_granalla_horno_cristales_plata.php?Canc=S"; 
	frm.submit(); 
			
}
function ValidarGrabar(Bloquear) 
{
	var frm=document.FrmProduccionGranalla;
	var ValoresElectrolito="";	
	ValoresElectrolito=RecuperarElectrolito();
	if (ValoresElectrolito!="")
	{
		frm.action="pmn_produccion_granalla_horno_cristales_plata01.php?ValoresElectrolito="+ValoresElectrolito +"&CmbDias="+frm.CmbDias.value +"&CmbAno="+frm.CmbAno.value +"&CmbMes="+frm.CmbMes.value + "&Bloquear="+Bloquear +"&Opcion=M"; 
		frm.submit(); 
	}
}
function ValidarEliminar(Bloquear) 
{
	var frm=document.FrmProduccionGranalla;
	var ValoresElectrolito="";	
	//Asigna a ValoresSA los valores recuperados de la funcion donde recupera la SA,rut,recargo 
	ValoresElectrolito=RecuperarElectrolitoEliminar();
	if (ValoresElectrolito!="")
	{
		frm.action="pmn_produccion_granalla_horno_cristales_plata01.php?ValoresElectrolito="+ValoresElectrolito +"&CmbDias="+frm.CmbDias.value +"&CmbAno="+frm.CmbAno.value +"&CmbMes="+frm.CmbMes.value + "&Bloquear="+Bloquear +"&Opcion=E2"; 
		frm.submit(); 
	}
}
function RecuperarElectrolitoEliminar()
{
	var frm=document.FrmProduccionGranalla;
	var Encontro=false;
	var ElectrolitosCajasPesoT ="";
	try 
	{
		frm.CheckElectrolisis[0];
		for (i=1;i<frm.CheckElectrolisis.length;i++)
		{
			if (frm.CheckElectrolisis[i].checked==true)
			{
				ElectrolitosCajasPesoT = ElectrolitosCajasPesoT + frm.TxtElectrolisis[i].value + "~~" + frm.TxtCajas2[i].value + "||" + frm.TxtPeso[i].value + "//" ;
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
		return(ElectrolitosCajasPesoT);
	}
	else
	{
		return(ElectrolitosCajasPesoT);
	}
}

function RecuperarElectrolito()
{
	var frm=document.FrmProduccionGranalla;
	var Encontro=false;
	var ElectrolitosCajasPesoT ="";
	try 
	{
		frm.CheckElectrolisis[0];
		for (i=1;i<frm.CheckElectrolisis.length;i++)
		{
			ElectrolitosCajasPesoT = ElectrolitosCajasPesoT + frm.TxtElectrolisis[i].value + "~~" + frm.TxtCajas2[i].value + "||" + frm.TxtPeso[i].value  + "@@" + frm.TxtSello[i].value+ "//" ;
				Encontro=true;
		}
	}	
	catch (e)
	{
	 	 alert("No hay Elementos para Seleccionar");
	}
	if (Encontro==false)
	{
		alert("No hay Elementos para Seleccionar");
		return(ElectrolitosCajasPesoT);
	}
	else
	{
		return(ElectrolitosCajasPesoT);
	}
}
//*************
function Validar()
{
	var frm =document.FrmProduccionGranalla;
	CmbDias=frm.CmbDias.value;
	CmbMes=frm.CmbMes.value;
	CmbAno=frm.CmbAno.value;  
	if (frm.NumCaja.value=="")
	{
		alert("Debe ingresar N° de Caja");
		frm.NumCaja.focus();
		return;
	}
	if (frm.Sello.value=="")
	{
		alert("Debe ingresar N° de Sello");
		frm.Sello.focus();
		return;
	}
	if (frm.NumElectrolisis.value=="")
	{
		alert("Debe ingresar N° de Electrolisis");
		frm.NumElectrolisis.focus();
		return;
	}
	if (frm.PesoBruto.value=="")
	{
		alert("Debe ingresar Peso Bruto");
		frm.PesoBruto.focus();
		return;
	}
	if (frm.ValorDec.value=="")
	{
		alert("Debe ingresar Valor Declarado");
		frm.ValorDec.focus();
		return;	}
	if (frm.ProCajas.value=="")
	{
		alert("Debe ingresar Peso de Caja");
		frm.ProCajas.focus();
		return;
	}
	frm.action="pmn_produccion_granalla_horno_cristales_plata01.php?CmbAno="+CmbAno + "&CmbDias="+CmbDias + "&CmbMes="+CmbMes +"&Opcion=O"; 
	frm.submit(); 
}
function Ver(Mostrar,Bloquear)
{
	var frm =document.FrmProduccionGranalla;
	var Fecha="";
	Fecha=frm.CmbAno.value +"-"+ frm.CmbMes.value +"-" + frm.CmbDias.value;
	//frm.action="pmn_produccion_granalla_horno_cristales_plata.php?Fecha="+Fecha +"&Mostrar=V" +"&Bloquear=B"; 
	frm.action="pmn_produccion_granalla_horno_cristales_plata.php?Fecha="+Fecha +"&Mostrar=V" +"&Bloquear=B"; 
	frm.submit(); 
}
function Activar()
{
	var frm=document.FrmProduccionGranalla;
	try
	{
		frm.CheckElectrolisis[0];
		for (i=0;i<frm.CheckElectrolisis.length;i++)
		{
			if (frm.CheckTodos.checked == true)
			{
				frm.CheckElectrolisis[i].checked = true;
			}
			else 
			{
				frm.CheckElectrolisis[i].checked = false;		
			}
		}
	}
	//si encuentra algun error no hace nada
	catch(e)
	{
	//Nada
	}
}
function Salir()
{
	var frm =document.FrmProduccionGranalla;
	frm.action="../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=105";
	frm.submit(); 
}
function TeclaPulsada (tecla) 
{ 
	var frm=document.FrmProduccionGranalla;
	var teclaCodigo = event.keyCode;
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo!=109))
	{
		if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<form name="FrmProduccionGranalla" method="post" action="">
   <?php include("../principal/encabezado.php")?> 
	<tr>
    <td width="613">
      <table width="769" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
        <tr>
          <td width="757"><table width="754" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
              <tr> 
                <td>Usuario: </td>
                <td width="309"> 
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
                <td width="148" align="right"> 
                  <?php echo $Fecha_Hora ?>
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
                </td>
                <td width="152" align="right">&nbsp;</td>
              </tr>
              <tr> 
                <td width="118" height="35"> Fecha:</td>
                <td colspan="3"> 
                  <?php
				    if ($Bloquear=='B')
					{
						echo "<input type='hidden' name='CmbDias' value='".$CmbDias."'>\n";
						echo "<input type='hidden' name='CmbMes' value='".$CmbMes."'>\n";
						echo "<input type='hidden' name='CmbAno' value='".$CmbAno."'>\n";
						printf("%'02d",$CmbDias);
						echo "-";
						printf("%'02d",$CmbMes);
						echo "-";
						printf("%'04d",$CmbAno);
                    }
					else
					{
						echo "<select name='CmbDias'  size='1' style='font-face:verdana;font-size:10'>";	
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
					echo "</select>";
					 echo "<select name='CmbMes' size='1'  style='FONT-FACE:verdana;FONT-SIZE:10'>";
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
						echo "</select>";
						echo "<select name='CmbAno' size='1'  style='FONT-FACE:verdana;FONT-SIZE:10'>";
						for ($i=date("Y");$i<=date("Y");$i++)
						{
							if (isset($CmbAno))
							{
								if ($i==$CmbAno)
									{
										echo "<option selected value ='".$i."'>".$i."</option>";
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
										echo "<option selected value ='".$i."'>".$i."</option>";
									}
								else	
									{
										echo "<option value='".$i."'>".$i."</option>";
									}
							}		
						}
						echo "</select>";
					}	
					?>
                  <input name="BtnVer" type="button" style="width:60" value="Consultar" onClick="Ver('<?php echo $Mostrar; ?>','<?php echo $Bloquear; ?>');"></td>
              </tr>
            </table>
			  
            <br>
            <table width="754" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
              <tr> 
                <td width="62" height="26">&nbsp;&nbsp;</td>
                <td width="51" height="26">&nbsp; </td>
                <td width="63" height="26">N° Caja:</td>
                <td width="109"><input name="NumCaja" type="text" id="NumCaja2" style="width:60" onKeyDown="TeclaPulsada();" value="<?php echo $NumCaja ; ?>"></td>
                <td width="73" height="26">N° Sello</td>
                <td width="68"><input name="Sello" type="text" id="Sello2" style="width:60" onKeyDown="TeclaPulsada();" value="<?php echo $Sello; ?>"></td>
                <td width="57">N°Elect:</td>
                <td width="80"><input name="NumElectrolisis" type="text" id="NumElectrolisis"  style="width:80" value="<?php  echo  $NumElectrolisis;?>"></td>
                <td width="35" height="26"><input name="BtnOk" type="button" id="BtnOk3" value="Ok" onClick="Proceso('O');"></td>
                <td width="93" height="26">&nbsp; </td>
              </tr>
              <tr> 
                <td height="26">&nbsp;</td>
                <td height="26">&nbsp;</td>
                <td height="26">Peso Bruto</td>
                <td><input name="PesoBruto" type="text" id="PesoBruto" style="width:60" onKeyDown="TeclaPulsada();" value="<?php  echo $PesoBruto; ?>"></td>
                <td height="26">Valor Decla</td>
                <td><input name="ValorDec" type="text" id="ValorDec2" style="width:60" onKeyDown="TeclaPulsada();" value="<?php  echo $ValorDec;  ?>"></td>
                <td>Prom:</td>
                <td><input name="ProCajas" type="text" id="ProCajas" style="width:60" value="<?php echo $ProCajas; ?>" >
                  KG</td>
                <td height="26">&nbsp;</td>
                <td height="26">&nbsp;</td>
              </tr>
            </table>
            <br>
            <table width="752" border="1" cellpadding="0" cellspacing="0">
              <tr align="center"  class="ColorTabla01"> 
                <td width="23" height="22" align="center"> <input name="CheckTodos" type="checkbox" id="CheckTodos" onClick="JavaScript:Activar();" value="checkbox"></td>
                <td width="120"> <div align="center"><strong>N° Caja</strong></div></td>
                <td width="120"> <div align="center"><strong>N°Sello</strong></div></td>
                <td width="120"> <div align="center"><strong>Peso Neto</strong></div></td>
                <td width="120"><strong>Peso Bruto</strong></td>
                <td width="120" ><strong>Valor Declar</strong></td>
                <td width="120" ><strong>N° Electrolisis</strong></td>
              </tr>
              <?php
				$Fecha = $CmbAno."-".$CmbMes."-".$CmbDias; 
				//consulta que devuelve las electrolisis que se ingrersaon al clickera OK 
				
				if (($Mostrar=='C')|| ($Mostrar =='V'))
				{
					$Consulta="select num_electrolisis,num_caja,peso_bruto,promedio_cajas,num_sello,valor_declarado from pmn_web.produccion_granalla  ";
					$Consulta =$Consulta." where (fecha = '".$Fecha."') order by num_caja";
					echo "<td><input type='hidden' name ='CheckElectrolisis' value=''><input name='TxtElectrolisis' type='hidden'><input name='TxtNumCaja' type='hidden'><input name='TxtPesoBruto' type='hidden'><input name='TxtSello' type='hidden'>";
					$Cont=0;
					$SumaPeso=0;
					$SumaSobrante=0;
					$i=1;
					$Resultado=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resultado))
					{
						echo "<tr>";
						echo "<td align='center'><input type='checkbox' name='ChkCaja[".$i."]' value='".$Fila[num_caja]."'>\n";
						echo "<input type='hidden' name='ChkCaja[".$i."]' value='".$Fila[num_caja]."'>\n";
						echo "<input type='hidden' name='ChkSello[".$i."]' value='".$Fila[num_sello]."'>\n";
						echo "<input type='hidden' name='ChkPromCaja[".$i."]' value='".$Fila[promedio_cajas]."'>\n";
						echo "<input type='hidden' name='ChkPesoBruto[".$i."]' value='".$Fila[peso_bruto]."'>\n";
						echo "<input type='hidden' name='ChkValor[".$i."]' value='".$Fila[valor_declarado]."'>\n";
						echo "<input type='hidden' name='ChkElectrolisis[".$i."]' value='".$Fila[num_electrolisis]."'>\n";
						echo "<td><div align='left'>".$Fila["num_caja"]."</div></td>";
						echo "<td><div align='left'>".str_replace(".",",",$Fila["num_sello"])."</div></td>";		
						echo "<td><div align='left'>".str_replace(".",",",$Fila["promedio_cajas"])."</div></td>";		
						echo "<td><div align='left'>".str_replace(".",",",$Fila["peso_bruto"])."</div></td>";		
						echo "<td><div align='left'>".str_replace(".",",",$Fila["valor_declarado"])."</div></td>";		
						echo "<td><div align='left'>".$Fila["num_electrolisis"]."</div></td>";
						echo "</tr>";
						$Cont++;
						$SumaPeso=$SumaPeso + $Fila["peso"];
						$SumaSobrante=$SumaSobrante + $Fila[peso_sobrante];
					}
					echo "<tr>";
					echo "<td colspan='2' align='center'>";
					echo "#Cajas : $Cont";
					echo "</td>";						
					echo "<td  colspan='2'  align='center'>";
					echo "#Peso Total : ".str_replace(".",",",$SumaPeso)."";
					echo "</td>";						
					echo "<td  colspan='2' align='center'>";
					echo "#Peso Sobrante : ".str_replace(".",",",$SumaSobrante)."";
					echo "</td>";						
					echo "</tr>";
				}
				?>
            </table>
            <br> 
            <table width="754"  border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
              <tr> 
                <td align="center" valign="middle"> 
                  <input name="FechaHorita" type="hidden" value="<?php echo $Fecha;?>"> 
                  <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" onClick="ValidarGrabar('<?php echo $Bloquear;  ?>');"> 
                  <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" onClick="Proceso('E2','<?php echo $Bloquear; ?>');">
                  <input name="BtnCancelar" type="button" style="width:60" value="Cancelar" onClick="Cancelar('');">
                  <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
                  <input name="BtnEliminar2" type="button" id="BtnEliminar22" value="Eliminar" onClick="Proceso('E');"></td>
              </tr>
            </table></td>
        </tr>
      </table>
 <?php include("../principal/pie_pagina.php")?>
  </form>
<p>&nbsp;</p>
</body>
</html>
