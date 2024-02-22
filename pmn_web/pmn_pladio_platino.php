<?php
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 19;
	include("../principal/conectar_pmn_web.php");
	if ($Consulta == "S")
	{
		$Mostrar = "S";
		$Dia = $IdDia;
		$Mes = $IdMes;
		$Ano = $IdAno;
		$NumProceso = $IdProceso;
	}
	if ($Mostrar == "S")
	{
		$Consulta = "select * from pmn_web.ingreso_platino_paladio ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " and num_proceso = '".$NumProceso."'";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$NumProceso =$Row[num_proceso]; 
			$Recepcion = $Row[recepcion_ag_cl];
			$Paladio= $Row[paladio];
			$Oro=$Row[oro];
			$Platino=$Row[cant_platino];
			$TotalRecuperado=$Row[total_recuperado];
		}
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "R":
			f.action="pmn_carga_fusion_barro_aurifero.php";
			f.submit();
		break;
		case "G": //GRABAR			
			if (f.NumProceso.value == "")
			{
				alert("Debe Ingresar Num. Proceso");
				f.NumProceso.focus();
				return;
			}
			if (f.Recepcion.value == "")
			{
				alert("Debe Ingresar Recepcion Ag/Cl");
				f.Recepcion.focus();
				return;
			}
			if (f.Platino.value == "")
			{
				alert("Debe Ingreasr Platino Paladio");
				f.Platino.focus();
				return;
			}
			if (f.Oro.value == "")
			{
				alert("Debe Ingresar Oro");
				f.Platino.focus();
				return;
			}
			if (f.Paladio.value == "")
			{
				alert("Debe Ingresar Paladio");
				f.Paladio.focus();
				return;
			}
			f.action= "pmn_pladio_platino01.php?Proceso=G";
	 		f.submit();
			break;
		case "G2": //GRABAR DETALLE			
			if (f.NumElectrolisis.value == "")
			{
				alert("Debe Ingresar Num. Electrolisis");
				f.NumElectrolisis.focus();
				return;
			}
			f.action= "pmn_pladio_platino01.php?Proceso=G2";
	 		f.submit();
			break;
		case "M2": //MODIFICAR DETALLE
			f.action= "pmn_pladio_platino01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR TODO
			var mensaje = confirm("¿Seguro que desea Eliminar Todos los Registros asociados al Proceso?");
			if (mensaje==true)
			{
				f.action= "pmn_pladio_platino01.php?Proceso=E";
	 			f.submit();
			}
			else
			{
				return;
			}
			break;
		case "E2": //ELIMINAR
			var mensaje = confirm("¿Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				f.action= "pmn_pladio_platino01.php?Proceso=E2";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "C": //CANCELAR
			f.action= "pmn_pladio_platino01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //CANCELAR
			var URL = "pmn_pladio_platino02.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=108";
	 		f.submit();
			break;
	}

}
function TeclaPulsada (tecla) 
{ 
	var Frm=document.frmPrincipal;
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo != 110))
	{
		if (((teclaCodigo != 8)&&(teclaCodigo !=9 )) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" border="0" class="TablaPrincipal">
    <tr>
      <td> 
        <table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Usuario:<strong> 
              </strong></font></font></td>
            <td colspan="2"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
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
              </strong></font></font></td>
            <td colspan="2" align="right"> <font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
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
            <td width="115">Fecha:</td>
            <td colspan="3"> 
              <?php 
				if ($Mostrar == "S")
				{
					echo "<input type='hidden' name='Dia' value='".$Dia."'>\n";
					echo "<input type='hidden' name='Mes' value='".$Mes."'>\n";
					echo "<input type='hidden' name='Ano' value='".$Ano."'>\n";
					printf("%'02d",$Dia);
					echo "-";
					printf("%'02d",$Mes);
					echo "-";
					printf("%'04d",$Ano);
				}
				else
				{
					echo "<select name='Dia' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($Dia))
						{
							if ($i == $Dia)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $DiaActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
				  echo "</select> <select name='Mes' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($Mes))
						{
							if ($i == $Mes)
								echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
						else
						{
							if ($i == $MesActual)
								echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
					}
				  echo "</select> <select name='Ano' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($Ano))
						{
							if ($i == $Ano)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $AnoActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
					echo "</select>\n";
				}
			?>
              <input name="ver" type="button" style="width:70" value="Consultar" onClick="Proceso('B');"> 
            </td>
            <td width="140"><div align="center"> </div></td>
          </tr>
          <tr> 
            <td width="115" height="23">Num. Proceso:</td>
            <td width="258"> 
              <?php
				if ($Mostrar == "S")
				{
					echo $NumProceso;
					echo "<input name='NumProceso' type='hidden' value='".$NumProceso."'>\n";
				}
				else
				{
              		echo "<input name='NumProceso' type='text' value='".$NumProceso."'>\n";
				}
			  ?>
            </td>
            <td width="118">Cc.Platino:</td>
            <td colspan="2"> </select> <input name="Platino" type="text" onKeyDown="TeclaPulsada()" value="<?php  echo $Platino;  ?>">
              Kg</td>
          </tr>
          <tr> 
            <td>Recepcion Ag/CL:</td>
            <td><input name="Recepcion" type="text" onKeyDown="TeclaPulsada()" value="<?php echo $Recepcion; ?>">
              Kg</td>
            <td>Au:</td>
            <td colspan="2"><input name="Oro" type="text" onKeyDown="TeclaPulsada()" value="<?php  echo $Oro;?>">
              Kg</td>
          </tr>
          <tr> 
            <td>Paladio:</td>
            <td><input name="Paladio" type="text" onKeyDown="TeclaPulsada()" value="<?php echo $Paladio ;?>">
              Kg </td>
            <td>Total Recuperado:</td>
            <td colspan="2"><div align="left"> 
                <input name="TotalRecuperado" type="text" onKeyDown="TeclaPulsada()" value="<?php echo $TotalRecuperado;  ?>">
                Kg</div></td>
          </tr>
        </table>
		  
        <br>
        <table width="761" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"> <input name="BtnGrabar" type="button" id="BtnGrabar2" value="Grabar" style="width:60px;" onClick="Proceso('G');">
              <input name="BtnEliminar" type="button" id="BtnEliminar2" value="Eliminar" style="width:60px;" onClick="Proceso('E');"> 
              <input name="BtnCancelar" type="button" id="BtnCancelar2" value="Cancelar" style="width:60px;" onClick="Proceso('C');"> 
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60px;" onClick="Proceso('S');"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="98">&nbsp;</td>
            <td width="75"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2"><strong> 
              </strong></font></font></font></font></font></td>
            <td width="31">&nbsp;</td>
            <td colspan="2"><font size="1"><font size="1"><font size="2"><strong> 
              </strong></font></font></font></td>
          </tr>
          <tr> 
            <td height="26">N&deg; Electrolisis:</td>
            <td height="26" colspan="2"><input name="NumElectrolisis" type="text" id="NumElectrolisis" value="<?php echo $NumElectrolisis;?>" size="15" maxlength="15"></td>
            <td width="95">Fecha Proceso:</td>
            <td height="29"><font size="2"> 
            <select name="CmbDiasP" size="1" id="CmbDiasP" style="width:40px;">
                <?php
				for ($i=1;$i<=31;$i++)
				{
					if (isset($CmbDiasP))
					{
						if ($i==$CmbDiasP)
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
              <select name="CmbMesP" size="1" id="CmbMesP" style="width:90px;">
              <?php
			  for($i=1;$i<13;$i++)
			  {
					if (isset($CmbMesP))
					{
						if ($i==$CmbMesP)
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
						if ($i==date("m"))
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
              <select name="CmbAnoP" size="1" id="CmbAnoP" style="width:70px;">
                <?php
				for ($i=date("Y");$i<=date("Y");$i++)
				{
					if (isset($CmbAnoP))
					{
						if ($i==$CmbAnoP)
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
            <td width="203" align="center"><input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="Proceso('G2');"> 
              <input name="BtnModificar2" type="button" value="Modificar" style="width:60px;" onClick="Proceso('M2');"> 
              <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="Proceso('E2');"> 
            </td>
          </tr>
        </table>
        <br> 
        <table width="496" height="18" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="39" height="15">&nbsp;</td>
            <td><strong># Electrolisis Plata</strong></td>
            <td width="219"><strong>Fecha Proceso</strong></td>
          </tr>
          <?php	
		$Consulta = "select * from pmn_web.detalle_ingreso_platino_paladio ";
		$Consulta= $Consulta." where fecha = '".$Ano."-".$Mes."-".$Dia."' and num_proceso = '".$NumProceso."' ";
		$Consulta= $Consulta." order by num_electrolisis_plata,fecha_proceso ";
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
			echo "<td align='center'><input type='checkbox' name='ChkProceso[".$i."]' value='".$Row[num_proceso]."'>\n";
			echo "<input type='hidden' name='ChkElectrolisis[".$i."]' value='".$Row[num_electrolisis_plata]."'>\n";
			echo "<input type='hidden' name='ChKDia[".$i."]' value='".substr($Row[fecha_proceso],8,2)."'>\n";
			echo "<input type='hidden' name='ChKMes[".$i."]' value='".substr($Row[fecha_proceso],5,2)."'>\n";
			echo "<input type='hidden' name='ChKAno[".$i."]' value='".substr($Row[fecha_proceso],0,4)."'>\n";
			//echo "Año".$ChKAno."<br>";
			//echo "mes".$ChKMes."<br>";
			//echo "dia".$ChKDia."<br>";
			echo "</td>\n";
		//	echo "<td align='center'>".$Row[num_proceso]."</td>\n";
			echo "<input type='hidden'  value='".$Row[num_proceso]."'>\n";
			echo "<td align='center'>".$Row[num_electrolisis_plata]."</td>\n";
			echo "<td align='center'>".$Row[fecha_proceso]."</td>\n";
			echo "</tr>\n";
			$i++;
		}
?>
        </table></td>
  </tr>
</table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
