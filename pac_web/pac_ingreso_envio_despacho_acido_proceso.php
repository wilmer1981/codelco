<?php 	
	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut =$CookieRut;
	
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$CmbDiaT = isset($_REQUEST["CmbDia"])?$_REQUEST["CmbDia"]:"";
	$CmbMesT = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	$CmbAnoT = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";
	$HoraAnalisis = isset($_REQUEST["CmbHora"])?$_REQUEST["CmbHora"]:"";
	$MinutosLixiv = isset($_REQUEST["CmbMinutos"])?$_REQUEST["CmbMinutos"]:"";

	$HoraInicio = isset($_REQUEST["CmbHoraInicio"])?$_REQUEST["CmbHoraInicio"]:"";
	$MinutoInicio = isset($_REQUEST["CmbMinutoInicio"])?$_REQUEST["CmbMinutoInicio"]:"";
	$HoraFinal   = isset($_REQUEST["CmbHoraFinal"])?$_REQUEST["CmbHoraFinal"]:"";
	$MinutoFinal = isset($_REQUEST["CmbMinutoFinal"])?$_REQUEST["CmbMinutoFinal"]:"";
	
	$CodEKOrigen  = isset($_REQUEST["CmbEstanque"])?$_REQUEST["CmbEstanque"]:"";
	$Volumen      = isset($_REQUEST["TxtVolumen"])?$_REQUEST["TxtVolumen"]:"";
	$CmbOperario  = isset($_REQUEST["CmbOperario"])?$_REQUEST["CmbOperario"]:"";
	$TxtMts       = isset($_REQUEST["TxtMts"])?$_REQUEST["TxtMts"]:"";
	$RutF       = isset($_REQUEST["RutF"])?$_REQUEST["RutF"]:"";

	$FechaHora = date("Y-m-d H:i:s");
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
			$Consulta="select * from pac_web.movimientos where fecha_hora='".$FechaHora."' and tipo_movimiento=3";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Volumen=str_replace(".",",",$Fila["toneladas"]);
			$TxtMts=str_replace(".",",",$Fila["volumen_m3"]);
			$HoraInicio=substr($Fila["hora_inicio"],0,2);
			$MinutoInicio=substr($Fila["hora_inicio"],3,2);
			$HoraFinal=substr($Fila["hora_final"],0,2);
			$MinutoFinal =substr($Fila["hora_final"],3,2);
			$CodEKOrigen=$Fila["cod_estanque_origen"];
			$RutF       =$Fila["rut_funcionario"];
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
	
	if (Frm.TxtVolumen.value == "")
	{
		alert("Debe Ingresar Volumen Enviado")
		Frm.TxtVolumen.focus();
		return;
	}
	if (Frm.CmbHoraInicio.value > Frm.CmbHoraFinal.value)
	{
		alert("Hora Inicial debe ser menor o igual a Hora Final")
		Frm.CmbHoraInicio.focus();
		return;
	}
	if (Frm.CmbHoraInicio.value == Frm.CmbHoraFinal.value)
	{
		if (Frm.CmbMinutoInicio.value>Frm.CmbMinutoFinal.value)
		{
			alert("Minuto Inicial debe ser menor o igual a Minuto Final")
			Frm.CmbMinutoInicio.focus();
			return;
		}	
	}
	if (Frm.CmbEstanque.value == "-1")
	{
		alert("Debe Ingresar Estanque")
		Frm.CmbEstanque.focus();
		return;
	}
	if (Frm.CmbOperario.value == "-1")
	{
		alert("Debe Ingresar Operario")
		Frm.CmbOperario.focus();
		return;
	}
	Frm.action="pac_ingreso_envio_despacho_acido_proceso01.php?Proceso="+Proceso+"&Valores="+Valores+"&FechaHora="+FechaHora;
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
		echo "<body onload='document.FrmProceso.TxtMts.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
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
						if ($CmbDiaT)
						{
							if ($i==$CmbDiaT)
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
						if ($CmbMesT)
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
						if ($CmbAnoT)
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
		    <?php
				$Consulta="select valor1 from pac_web.parametros where codigo=2";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Densidad=$Fila["valor1"];						
			?> 
            <td>Volumen Mts<sup>3</sup></td>
            <td>
				<input type="text" name="TxtMts" style="width:80" onBlur="Calcula('<?php echo $Densidad;?>');" onKeyDown="TeclaPulsada()" maxlength="10" value="<?php echo $TxtMts;?>">
				&nbsp;Toneladas&nbsp; 
				<input type="text" name="TxtVolumen" style="width:80" onKeyDown="TeclaPulsada();" maxlength="10" value="<?php echo $Volumen;?>">&nbsp;TON.
            </td>
          </tr>
          <tr> 
            <td>Hora Inicio</td>
            <td><font size="1"><font size="2"> 
              <select name="CmbHoraInicio" id="select">
                <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if ($HoraInicio)
					{	
						if ($HoraInicio == $Valor)
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
              <select name="CmbMinutoInicio">
                <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if ($MinutoInicio)
					{	
						if ($MinutoInicio == $Valor)
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
              </font></font> </td>
          </tr>
          <tr> 
            <td>Hora Final</td>
            <td><font size="1"><font size="2"> 
              <select name="CmbHoraFinal" id="select2">
                <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if ($HoraFinal)
					{	
						if ($HoraFinal == $Valor)
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
              <select name="CmbMinutoFinal">
                <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if ($MinutoFinal)
					{	
						if ($MinutoFinal == $Valor)
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
          </tr>
          <tr> 
            <td>Estanque</td>
            <td>
			<?php	
				echo "<select name='CmbEstanque' style='width:100'>";
				echo "<option value='-1' selected>Seleccionar</option>";
				$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase=9001 and cod_subclase = 5";
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
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>','<?php echo $FechaHora;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
