<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut =$CookieRut;

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$CmbDia = isset($_REQUEST["CmbDia"])?$_REQUEST["CmbDia"]:date("d");
	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$HoraAnalisis = isset($_REQUEST["CmbHora"])?$_REQUEST["CmbHora"]:date("H");
	$MinutosLixiv = isset($_REQUEST["CmbMinutos"])?$_REQUEST["CmbMinutos"]:date("i");

	$TxtNumGuia = isset($_REQUEST["TxtNumGuia"])?$_REQUEST["TxtNumGuia"]:"";
	$CmbTransportista = isset($_REQUEST["CmbTransportista"])?$_REQUEST["CmbTransportista"]:"";
	$CmbPatentes = isset($_REQUEST["CmbPatentes"])?$_REQUEST["CmbPatentes"]:"";
	$Volumen = isset($_REQUEST["TxtVolumen"])?$_REQUEST["TxtVolumen"]:"";
	$CodEKDestino = isset($_REQUEST["CmbEstanqueDestino"])?$_REQUEST["CmbEstanqueDestino"]:"";
	$CmbOperario = isset($_REQUEST["CmbOperario"])?$_REQUEST["CmbOperario"]:"";
	$TipoRecep = isset($_REQUEST["TipoRecep"])?$_REQUEST["TipoRecep"]:"";
	$RutF = isset($_REQUEST["RutF"])?$_REQUEST["RutF"]:"";

	$HoraActual = date("H");
	$MinutoActual = date("i");
	$FechaHora = date("Y-m-d H:i:s");

	//echo "CmbTransportista:".$CmbTransportista;
	//echo "<br>CmbPatentes:".$CmbPatentes;
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
					$FechaHora=substr($Datos,0,$i);
					break;
				}
			}
			$Consulta  = "SELECT * from pac_web.recepcion_camiones where fecha_hora='".$FechaHora."' and tipo_movimiento=6";
			echo $Consulta;

			$Respuesta = mysqli_query($link, $Consulta);
			$Fila      = mysqli_fetch_array($Respuesta);
			var_dump($Fila);

			$TipoRecep = $Fila["tipo_recepcion"];
			if ($CmbTransportista=="")
			{
				$CmbTransportista=$Fila["rut_transportista"];	
			}
			if ($CmbPatentes=="")
			{
				$CmbPatentes=$Fila["nro_patente"];
			}
			$Volumen     = str_replace(".",",",$Fila["volumen"]);
			$CodEKDestino= $Fila["cod_estanque"];
			$TxtNumGuia  = $Fila["num_guia"];
			$RutF        = $Fila["rut_funcionario"];
			break;	
	}

    //echo "<br>CmbTransportista:".$CmbTransportista;
	//echo "<br>CmbPatentes:".$CmbPatentes;
?>
<html>
<head>
<script language="JavaScript">
function SoloNumeros (tecla) 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	
	if (teclaCodigo == 13)
	{
		Frm.CmbTransportista.focus();
	}
	else
	{
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
} 

function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	var CantComas =0;
	
	if (teclaCodigo == 13)
	{
		Frm.CmbHoraInicio.focus();
	}
	else
	{
		if ((teclaCodigo != 188 )&&(teclaCodigo != 110 )&&(teclaCodigo != 190 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
			   		event.keyCode=46;
			   }		
			}   
		}
		else
		{
			CantComas=Frm.TxtVolumen.value.search(',');
			if (CantComas!=-1)
			{
				event.keyCode=46;
				return;
			}
			if ((Frm.TxtVolumen.value.substr(Frm.TxtVolumen.value.length-1,1)==",")||(Frm.TxtVolumen.value.substr(Frm.TxtVolumen.value.length-1,1)==""))
			{
				if ((teclaCodigo != 37)&&(teclaCodigo != 39))
				{
					event.keyCode=46;
				}	
			}
		}
	}	
} 

function Grabar(Proceso,Valores,FechaHora,TipoRecep,Ok)
{
	var Frm=document.FrmProceso;
	var NumGuia="";
	
	if (Frm.TxtNumGuia.value == "")
	{
		alert("Debe Ingresar Guia")
		Frm.TxtNumGuia.focus();
		return;
	}
	else
	{
		NumGuia=Frm.TxtNumGuia.value;
	}
	if (Frm.CmbTransportista.value ==-1)
	{
		alert("Debe Seleccionar Transportista")
		Frm.CmbTransportista.focus();
		return;
	}
	if (Frm.CmbPatentes.value==-1)
	{
		alert("Debe Seleccionar la Patente")
		Frm.CmbPatentes.focus();
		return;
	}
	if (Frm.TxtVolumen.value == "")
	{
		alert("Debe Ingresar Peso Recepcionado")
		Frm.TxtVolumen.focus();
		return;
	}
	if (Frm.CmbEstanqueDestino.value == "-1")
	{
		alert("Debe Seleccionar Estanque estino")
		Frm.CmbEstanqueDestino.focus();
		return;
	}
	if (Frm.CmbOperario.value == "-1")
	{
		alert("Debe Seleccionar Operario")
		Frm.CmbOperario.focus();
		return;
	}
	Frm.action="pac_ingreso_recepcion_camiones_proceso01.php?Proceso="+Proceso+"&Valores="+Valores+"&FechaHora="+FechaHora+"&TipoRecep=1&NumGuia="+NumGuia;
	Frm.submit();						
	
}
function Recarga(Tipo,Proceso,Valores,FechaHora)
{
	var Frm=document.FrmProceso;
	
	switch (Tipo)
	{
		case "1":
			Frm.action="pac_ingreso_recepcion_camiones_ser_proceso.php?Proceso="+Proceso+"&Valores="+Valores+"&FechaHora="+FechaHora+"&TxtNumGuia="+Frm.TxtNumGuia.value;
			break;
	}
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
		echo "<body onload='document.FrmProceso.CmbDia.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
	else
	{
		echo "<body onload='document.FrmProceso.TxtVolumen.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
?>

<form name="FrmProceso" method="post" action="">
  <table width="510" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="500" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td width="113">Fecha Ingreso</td>
            <td width="361"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
              <?php
				if ($Proceso=="M")
				{
					echo $FechaHora;
				}
				if ($Proceso!="M")
				{	
					echo "<select name='CmbDia' id='select7' size='1' style='width:40px;'>";
					for ($i=1;$i<=31;$i++)
					{
						if ($CmbDia)
						{
							if ($i==$CmbDia)
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
				}	
					
			?>
              </font> <font size="1"><font size="2"> 
              <?php
				if ($Proceso!="M")
				{	
				  echo "<select name='CmbMes' size='1' style='width:90px;'>";
				  for($i=1;$i<13;$i++)
				  {
						if ($CmbMes)
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
				}   
		  	 ?>
              </font></font> <font size="2"> 
              <?php
				if ($Proceso!="M")
				{
					echo "<select name='CmbAno' size='1' style='width:70px;'>";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if ($CmbAno)
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
				echo "</select>";
			}	
			?>
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><font size="2"> 
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font><font size="2"> 
              <?php
				if ($Proceso!="M")
				{
					echo "<select name='CmbHora' id='select33'>";
					for ($i=0;$i<=23;$i++)
					{
						if ($i<10)
							$Valor = "0".$i;
						else	$Valor = $i;
						if ($HoraAnalisis)
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
					echo "</select>";
					echo "<strong>:</strong>";		
				 }
				if ($Proceso!="M")
				{ 	
					echo "<select name='CmbMinutos'>";
					for ($i=0;$i<=59;$i++)
					{
					if ($i<10)
						$Valor = "0".$i;
					else
						$Valor = $i;
						if ($MinutosLixiv)
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
					echo "</select>"; 
				 }	
				?>
              </font></font></td>
          </tr>
          <tr> 
            <td>Nro. Guia</td>
            <td><input type='text' name ='TxtNumGuia' maxlenght='15' style='width:100' maxlength="10" value='<?php echo $TxtNumGuia;?>' onKeyDown="SoloNumeros();">
            </td>
          </tr>
          <tr> 
            <td>Transportista</td>
            <td> 
              <?php
					echo "<select name='CmbTransportista' style='width:180' onchange=\"Recarga('1','$Proceso','$Valores','$FechaHora');\">";
					echo "<option value='-1' selected>Seleccionar</option>";
					$Consulta="SELECT * FROM pac_web.transportista order by rut_transportista";
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($Fila["rut_transportista"]==$CmbTransportista)
						{
							echo "<option value='".$Fila["rut_transportista"]."' selected>".$Fila["rut_transportista"]."-".$Fila["nombre"]."</option>";
						}
						else
						{
							echo "<option value='".$Fila["rut_transportista"]."'>".$Fila["rut_transportista"]."-".$Fila["nombre"]."</option>";					
						}	
					}
					echo "</select>";
			  ?>
            </td>
          </tr>
          <tr> 
            <td>Patente</td>
            <td> 
              <?php
					echo "<select name='CmbPatentes' style='width:120' onchange=\"Recarga('4','$Proceso','$Valores','$FechaHora','$TipoRecep');\">";
					echo "<option value='-1' selected>Seleccionar</option>";
					$Consulta="SELECT distinct nro_patente FROM pac_web.camiones_por_transportista where rut_transportista='".$CmbTransportista."'";
					$Respuesta=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbPatentes==$Fila["nro_patente"])
						{
							echo "<option value='".$Fila["nro_patente"]."' selected>".$Fila["nro_patente"]."</option>";
						}
						else
						{
							echo "<option value='".$Fila["nro_patente"]."'>".$Fila["nro_patente"]."</option>";
						}	
					}
					echo "</select>";
			  ?>
            </td>
          </tr>
          <tr> 
            <td>Toneladas Recep.</td>
            <td><input type="text" name="TxtVolumen" style="width:80" onKeyDown="TeclaPulsada();" maxlength="10" value="<?php echo $Volumen;?>"> 
              &nbsp;TON. </td>
          </tr>
          <tr> 
            <td>Estanque Destino</td>
            <td> 
              <?php	
				echo "<select name='CmbEstanqueDestino' style='width:100'>";
				echo "<option value='-1' selected>Seleccionar</option>";
				$Consulta ="SELECT * from proyecto_modernizacion.sub_clase where cod_clase=9001 and cod_subclase <> 5";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($Fila["cod_subclase"]==$CodEKDestino)
					{
						echo "<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
					}
					else
					{
						 echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
					}	 
				}
              	echo "</select>"
			?>
            </td>
          </tr>
          <tr> 
            <td>Operario</td>
            <td> 
              <?php	
				echo "<select name='CmbOperario' style='width:150'>";
				echo "<option value='-1' selected>Seleccionar</option>";
				$Consulta ="SELECT * from proyecto_modernizacion.sub_clase where cod_clase=9002";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($Fila["nombre_subclase"]==$RutF)
					{
						echo "<option value='".$Fila["nombre_subclase"]."' selected>".$Fila["valor_subclase1"]."</option>";
					}
					else
					{
						echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>";
					}	
				}
              	echo "</select>";
			?>
            </td>
          </tr>
        </table>
        <br>
        <table width="500" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509">
				<!--<input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php //echo $Proceso;?>','<?php //echo $Valores;?>','<?php //echo $FechaHora;?>','<?php //echo $TipoRecep;?>','<?php //echo $Ok;?>')">-->
			<input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>','<?php echo $FechaHora;?>','<?php echo $TipoRecep;?>','')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
