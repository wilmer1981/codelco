<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 7;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut =$CookieRut;
	$HoraActual = date("H");
	$MinutoActual = date("i");
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
			$Consulta="select * from pac_web.movimientos where fecha_hora='".$FechaHora."' and tipo_movimiento=4";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Volumen=str_replace(".",",",$Fila["toneladas"]);
			$TxtMts=str_replace(".",",",$Fila["volumen_m3"]);
			$CodEKOrigen=$Fila["cod_estanque_origen"];
			$CodEKDestino=$Fila["cod_estanque_destino"];
			$RutF=$Fila["rut_funcionario"];
			break;	
	}	

?>
<html>
<head>
<script language="JavaScript">
function Calcula(Densidad)
{
	var Frm=document.FrmProceso;
	
	Frm.TxtVolumen.value=parseFloat(Frm.TxtMts.value)*parseFloat(Densidad.replace(',','.'));
	return;	
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
function Grabar(Proceso,Valores,FechaHora)
{
	var Frm=document.FrmProceso;
	
	if (Frm.CmbEstanqueOrigen.value == "-1")
	{
		alert("Debe Seleccionar Estanque Origen")
		Frm.CmbEstanqueOrigen.focus();
		return;
	}
	if (Frm.CmbEstanqueDestino.value == "-1")
	{
		alert("Debe Seleccionar Estanque estino")
		Frm.CmbEstanqueDestino.focus();
		return;
	}
	if (Frm.CmbEstanqueOrigen.value == Frm.CmbEstanqueDestino.value)
	{
		alert("Estanque Destino debe ser Distinto A Estanque Origen")
		Frm.CmbEstanqueDestino.focus();
		return;
	}
	if (Frm.TxtVolumen.value == "")
	{
		alert("Debe Ingresar Toneladas")
		Frm.TxtVolumen.focus();
		return;
	}
	if (Frm.CmbOperario.value == "-1")
	{
		alert("Debe Seleccionar Operario")
		Frm.CmbOperario.focus();
		return;
	}
	Frm.action="pac_ingreso_trasvasije_proceso01.php?Proceso="+Proceso+"&Valores="+Valores+"&FechaHora="+FechaHora;
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
		echo "<body onload='document.FrmProceso.CmbEstanqueOrigen.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
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
				echo "</select>";		
				}
				if ($Proceso!="M")
				{
					echo "<select name='CmbHora' id='select33'>";
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
				echo "</select>";
				}	
				?>
              </font></font></td>
          </tr>
          <tr> 
            <td>Estanque Origen</td>
            <td> 
              <?php	
				echo "<select name='CmbEstanqueOrigen' style='width:100'>";
				echo "<option value='-1' selected>Seleccionar</option>";
				$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase=9001 and cod_subclase <> 5";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($Fila["cod_subclase"]==$CodEKOrigen)
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
            <td>Estanque Destino</td>
            <td> 
              <?php	
				echo "<select name='CmbEstanqueDestino' style='width:100'>";
				echo "<option value='-1' selected>Seleccionar</option>";
				$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase=9001 and cod_subclase <> 5";
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
		    <?php
				$Consulta="select valor1 from pac_web.parametros where codigo=2";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Densidad=$Fila[valor1];						
			?> 
            <td>Toneladas</td>
            <td> 
              <input type="text" name="TxtVolumen" style="width:80" onKeyDown="TeclaPulsada()" maxlength="10" value="<?php echo $Volumen;?>"></td>
          </tr>
          <tr> 
            <td>Operario</td>
            <td> 
              <?php	
				echo "<select name='CmbOperario' style='width:150'>";
				echo "<option value='-1' selected>Seleccionar</option>";
				$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase=9002";
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
            <td  align="center" width="509"><input type="button"  name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>','<?php echo $FechaHora?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
