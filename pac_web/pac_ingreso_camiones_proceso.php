<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 3;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$TipoTransp = isset($_REQUEST["TipoTransp"])?$_REQUEST["TipoTransp"]:"";	
	$CmbTransp = isset($_REQUEST["CmbTransp"])?$_REQUEST["CmbTransp"]:"";
	$Marca = isset($_REQUEST["Marca"])?$_REQUEST["Marca"]:"";
	$Modelo = isset($_REQUEST["Modelo"])?$_REQUEST["Modelo"]:"";
	$Carga = isset($_REQUEST["Carga"])?$_REQUEST["Carga"]:"";	
	$Tara = isset($_REQUEST["Tara"])?$_REQUEST["Tara"]:"";	
	$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";	
	$Patente = isset($_REQUEST["Patente"])?$_REQUEST["Patente"]:"";	

	$CmbDiaRT = isset($_REQUEST["CmbDiaRT"])?$_REQUEST["CmbDiaRT"]:date("d");	
	$CmbMesRT = isset($_REQUEST["CmbMesRT"])?$_REQUEST["CmbMesRT"]:date("m");	
	$CmbAnoRT = isset($_REQUEST["CmbAnoRT"])?$_REQUEST["CmbAnoRT"]:date("Y");
	$CmbDiaCE = isset($_REQUEST["CmbDiaCE"])?$_REQUEST["CmbDiaCE"]:date("d");	
	$CmbMesCE = isset($_REQUEST["CmbMesCE"])?$_REQUEST["CmbMesCE"]:date("m");	
	$CmbAnoCE = isset($_REQUEST["CmbAnoCE"])?$_REQUEST["CmbAnoCE"]:date("Y");
	
	$EncontroCoincidencia = isset($_REQUEST["EncontroCoincidencia"])?$_REQUEST["EncontroCoincidencia"]:"";		
	$Tipo2 = isset($_REQUEST["Tipo2"])?$_REQUEST["Tipo2"]:"";
	//$Patente="";
	//$Marca="";
	//$Modelo="";
	//$Ano="";
	//$Carga="";
	//$Tara="";
	switch($Proceso)
	{
		case "N":
			break;
		case "M":
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$Patente=substr($Datos,0,$i);
				}
			}
			$Consulta = "select t3.rut_transportista,t3.nombre as nombre_transp,t1.nro_patente,t1.marca,t1.modelo,t1.año,t1.carga,t1.tara,t1.fecha_rev_tecnica,t1.fecha_cert_estanque,t1.tipo,t1.tipo2 from pac_web.camiones_por_transportista t1 ";
			$Consulta = $Consulta." inner join pac_web.transportista t3 on t1.rut_transportista=t3.rut_transportista where nro_patente ='".$Patente."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Transportista=$Fila["nombre_transp"];
			$RutTransp=$Fila["rut_transportista"];
			$Marca=$Fila["marca"];
			$Modelo=$Fila["modelo"];
			$Ano=$Fila["año"];
			$Carga=$Fila["carga"];
			$Tara=$Fila["tara"];
			if (!is_null($Fila["fecha_rev_tecnica"]))
			{
				$AnoRT=substr($Fila["fecha_rev_tecnica"],0,4);
				$MesRT=substr($Fila["fecha_rev_tecnica"],5,2);
				$DiaRT=substr($Fila["fecha_rev_tecnica"],8,2);
			}
			else
			{
				$AnoRT=date("Y");
				$MesRT=date("n");
				$DiaRT=date("j");
			}
			if (!is_null($Fila["fecha_cert_estanque"]))
			{
				$AnoCE=substr($Fila["fecha_cert_estanque"],0,4);
				$MesCE=substr($Fila["fecha_cert_estanque"],5,2);
				$DiaCE=substr($Fila["fecha_cert_estanque"],8,2);
			}
			else
			{
				$AnoCE=date("Y");
				$MesCE=date("n");
				$DiaCE=date("j");
			}
			$TipoTransp=$Fila["tipo"];
			$Tipo2=$Fila["tipo2"];	
			break;	
	}	
?>
<html>
<head>
<script language="JavaScript">
function SoloNumeros() 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	
	if ((teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo !=9))
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
function SoloNumerosComas() 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	var CantComas =0;
	
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo !=9))
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

function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	var Tipo='';
	var Validar='S';
	
	if (Frm.RadioTransp[2].checked)
	{
		Validar='N';
	}
	if (Proceso=='N')
	{
		if (Frm.CmbTransp.value == "-1")
		{
			alert("Debe Seleccionar Transportista")
			Frm.CmbTransp.focus();
			return;
		}
		if (Validar=='S')
		{
			if (Frm.TxtPatente.value == "")
			{
				alert("Debe Ingresar Patente")
				Frm.TxtPatente.focus();
				return;
			}
		}	
	}
	if (Validar=='S')
	{
		if (Frm.OptTipo[0].checked)//PARTICULAR
		{
			Tipo=Frm.OptTipo[0].value;
		}
		else
		{
			Tipo=Frm.OptTipo[1].value;//ENAMI
		}
		Frm.action="pac_ingreso_camiones_proceso01.php?Proceso="+Proceso+"&TxtPatente="+Frm.TxtPatente.value+"&Valores="+Valores+"&Tipo="+Tipo;
	}	
	else
	{
		Frm.action="pac_ingreso_camiones_proceso01.php?Proceso="+Proceso+"&Valores="+Valores+"&Tipo="+Tipo;
	}
	Frm.submit();
	
}
function Recarga(Opcion,Proceso)
{
	var Frm=document.FrmProceso;
	Frm.action="pac_ingreso_camiones_proceso.php?TipoTransp="+Opcion+"&Proceso="+Proceso;
	Frm.submit();
	
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	if ($Proceso=='N')
	{
		echo "<body onload='document.FrmProceso.CmbTransp.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
	else
	{
		if ($TipoTransp!='B')
		{
			echo "<body onload='document.FrmProceso.TxtMarca.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
		}	
	}
?>

<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="140">Tipo Transporte</td>
            <td width="229"> 
              <?php
			  	if ($Proceso=='N')
				{
					if ($TipoTransp)
					{
						switch ($TipoTransp)
						{
							case "C":
								echo "<input type='radio' name='RadioTransp' value='C' checked onClick=Recarga('C','$Proceso');>Camion&nbsp;";
								echo "<input type='radio' name='RadioTransp' value='R' onClick=Recarga('R','$Proceso');>Rampla&nbsp;";
								echo "<input type='radio' name='RadioTransp' value='B' onClick=Recarga('B','$Proceso');>Buque&nbsp;";
								break;
							case "B":
								echo "<input type='radio' name='RadioTransp' value='C' onClick=Recarga('C','$Proceso');>Camion&nbsp;";
								echo "<input type='radio' name='RadioTransp' value='R' onClick=Recarga('R','$Proceso');>Rampla&nbsp;";
								echo "<input type='radio' name='RadioTransp' value='B' checked onClick=Recarga('B','$Proceso');>Buque&nbsp;";
								break;
							case "R":
								echo "<input type='radio' name='RadioTransp' value='C' onClick=Recarga('C','$Proceso');>Camion&nbsp;";
								echo "<input type='radio' name='RadioTransp' value='R' checked onClick=Recarga('R','$Proceso');>Rampla&nbsp;";
								echo "<input type='radio' name='RadioTransp' value='B' onClick=Recarga('B','$Proceso');>Buque&nbsp;";
								break;
						}
					}
					else
					{
						echo "<input type='radio' name='RadioTransp'  checked value='C' onClick=Recarga('C','$Proceso');>Camion&nbsp;";
						echo "<input type='radio' name='RadioTransp' value='R' onClick=Recarga('R','$Proceso');>Rampla&nbsp;";
						echo "<input type='radio' name='RadioTransp' value='B' onClick=Recarga('B','$Proceso');>Buque&nbsp;";
					}	
				}
				else
				{
					switch ($TipoTransp)
					{
						case "C":
							echo "<input type='radio' name='RadioTransp' value='radiobutton' checked disabled>Camion&nbsp;";
							echo "<input type='radio' name='RadioTransp' value='radiobutton' disabled>Rampla&nbsp;";
							echo "<input type='radio' name='RadioTransp' value='radiobutton' disabled>Buque&nbsp;";
							break;
						case "B":
							echo "<input type='radio' name='RadioTransp' value='radiobutton' disabled>Camion&nbsp;";
							echo "<input type='radio' name='RadioTransp' value='radiobutton' disabled>Rampla&nbsp;";
						    echo "<input type='radio' name='RadioTransp' value='radiobutton' checked disabled>Buque&nbsp;";
							break;
						case "R":
							echo "<input type='radio' name='RadioTransp' value='radiobutton' disabled>Camion&nbsp;";
						    echo "<input type='radio' name='RadioTransp' value='radiobutton' checked disabled>Rampla&nbsp;";
							echo "<input type='radio' name='RadioTransp' value='radiobutton'  disabled>Buque&nbsp;";
							break;
					}
				}
					
			  ?>
            </td>
          </tr>
          <tr> 
            <td>Transp.</td>
            <td> 
              <?php
					if ($Proceso=='M')
					{
						echo "<input type='hidden' name ='TxtRutTransp' value =".$RutTransp.">";
						echo $RutTransp."  ".strtoupper($Transportista);
					}
					else
					{
						echo "<select name='CmbTransp'>";
						echo "<option value ='-1' selected>Seleccionar</option> ";
						$Consulta="select rut_transportista,nombre from transportista order by nombre";
						$Respuesta=mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo "<option value ='".$Fila["rut_transportista"]."'>".$Fila["rut_transportista"]."&nbsp;-&nbsp;".$Fila["nombre"]."</option>";
						}
						echo "</select></td>";
					}	
				?>
          </tr>
          <tr>
		    <?php 
				if ($TipoTransp!='B')
				{
					echo "<td>Patente</td>";
					echo "<td>";
					if ($Proceso=='M')
					{
						echo "<input type='text' name='TxtPatente' style='width:100' maxlength='10' value='$Patente' disabled>"; 
					}
					else
					{
						echo "<input type='text' name='TxtPatente' style='width:100' maxlength='10' value='$Patente'>"; 
					}	
 	  			    echo "&nbsp;</td>";
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";					
				}	
			 ?> 
          </tr>
          <tr>
		    <?php
				if ($TipoTransp!='B')
				{
					echo "<td>Marca</td>";
					echo "<td><input type='text' name='TxtMarca' style='width:100' maxlength='30' value='$Marca'></td>";			
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
				}
			?> 
          </tr>
          <tr>
		    <?php
				if ($TipoTransp!='B')
				{
					echo "<td>Modelo</td>";
					echo "<td><input type='text' name='TxtModelo' style='width:100' maxlength='30' value='$Modelo'>";
					echo "A&ntilde;o <input type='text' name='TxtAno' style='width:40' maxlength='4' value='$Ano' onKeyDown='SoloNumeros();'></td>";			
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
				}
			?> 
          <tr> 
		    <?php
				if ($TipoTransp!='B')
				{
					echo "<td>Carga</td>";
					echo "<td><input type='text' name='TxtCarga' style='width:70' maxlength='10' value='$Carga' onKeyDown='SoloNumerosComas()'>TON.</td>";
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
				}
			?> 
          </tr>
          <tr> 
		    <?php
   				if ($TipoTransp!='B')
				{
					echo "<td>Venc. Rev. Tecnica</td>";
					echo "<td>";
					echo "<select name='CmbDiaRT' id='select' size='1' style='width:40px;'>";
					for ($i=1;$i<=31;$i++)
					{
						if ($Proceso=='M')
						{
							if ($i==$DiaRT)
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
							if (isset($CmbDiaRT))
							{
								if ($i==$CmbDiaRT)
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
					}
					echo "</select>";
					echo "<select name='CmbMesRT' size='1' style='width:90px;'>";
					 for($i=1;$i<13;$i++)
					 {
						if ($Proceso=='M')
						{
							if ($i==$MesRT)
							{
								echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
							}
							else	
							{
								echo "<option value='".$i."'>".$meses[$i-1]."</option>";
							}
						}
						else
						{
							if (isset($CmbMesRT))
							{
								if ($i==$CmbMesRT)
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
					 }
					echo "</select>";
					echo "<select name='CmbAnoRT' size='1' style='width:70px;'>";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if ($Proceso=='M')
						{
							if ($i==$AnoRT)
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
							if (isset($CmbAnoRT))
							{
								if ($i==$CmbAnoRT)
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
					}
				  echo "</select>";
				  echo "</td>";
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
				}  
			?>
          <tr> 
		  	<?php
   				if ($TipoTransp=='R')
				{
					echo "<td>Venc. Cert. Estanque</td>";
					echo "<td> ";
					echo "<select name='CmbDiaCE' id='select7' size='1' style='width:40px;'>";
					for ($i=1;$i<=31;$i++)
					{
						if ($Proceso=="M")
						{
							if ($i==$DiaCE)
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
							if ($CmbDiaCE)
							{
							if ($i==$CmbDiaCE)
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
					}
					  echo "</select>";
					  echo "<select name='CmbMesCE' size='1' style='width:90px;'>";
					  for($i=1;$i<13;$i++)
					  {
						if ($Proceso=="M")
						{
							if ($i==$MesCE)
							{
								echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
							}
							else	
							{
								echo "<option value='".$i."'>".$meses[$i-1]."</option>";
							}
						}
						else
						{
							if ($CmbMesCE)
							{
								if ($i==$CmbMesCE)
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
					   }
				  echo "</select>";
				  echo "<select name='CmbAnoCE' size='1' style='width:70px;'>";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if ($Proceso=="M")
						{
							if ($i==$AnoCE)
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
							if ($CmbAnoCE)
							{
								if ($i==$CmbAnoCE)
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
					}
					echo "</select>";
					echo "</td>";
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
				}	
			?>
          <tr> 
            <?php
   				if ($TipoTransp!='B')
				{
					echo "<td>Tara</td>";
					echo "<td><input type='text' name='TxtTara' style='width:70' maxlength='10' value='$Tara' onKeyDown='SoloNumerosComas()'>TON</td>";
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
				}	
			?> 
          </tr>
          <tr>
            <?php
   				if ($TipoTransp!='B')
				{
					echo "<td>Tipo</td>";
					echo "<td>";
					if ($Proceso=='N')
					{
						echo "<input type='radio' name='OptTipo' value='P' checked>Particular";
						echo "<input type='radio' name='OptTipo' value='E' >Enami";
					}
					else
					{
						switch ($Tipo2)
						{
							case "P":
								echo "<input type='radio' name='OptTipo' value='P' checked>Particular";
								echo "<input type='radio' name='OptTipo' value='E'>Enami";
								break;
							case "E":
								echo "<input type='radio' name='OptTipo' value='P'>Particular";
								echo "<input type='radio' name='OptTipo' value='E' checked>Enami";
								break;
							default:	
								echo "<input type='radio' name='OptTipo' value='P' checked>Particular";
								echo "<input type='radio' name='OptTipo' value='E'>Enami";
								break;
						}
					}
					echo "</td>";
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
				}	
			?>
          </tr>
        </table>
        <br>
        <table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr>
		  <td  align='center' width='509'>
		  <?php
				echo "<input type='button' name='BtnGrabar' value='Grabar' style='width:60' onClick=Grabar('$Proceso','$Valores');>";
		  ?> 
		  <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">&nbsp;</td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
<?php
	if (isset($EncontroCoincidencia))
	{
		if ($EncontroCoincidencia==true)
		{
			echo "<script languaje='javascript'>";
			echo "var Frm=document.FrmProceso;";
			echo "alert('El Camion ya fue asignado al Cliente');";
			echo "Frm.TxtPatente.focus();";
			echo "</script>";
		}
	}
?>
