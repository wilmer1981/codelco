<?php
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$CodigoDeSistema = 6;
	include("../principal/conectar_pmn_web.php");
	if ($ConsultaMeDor == "S")
	{
		$Mostrar = "S";
		$Dia = $IdDiaMeDor;
		$Mes = $IdMesMeDor;
		$Ano = $IdAnoMeDor;
		$NumLote = $IdLoteMeDor;
	}
	if ($Mostrar == "S")
	{
		$Consulta = "select * from pmn_web.ingreso_metal_dore ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " and num_lote = '".$NumLote."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$NumLote =$Row[num_lote]; 
		}
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ProcesoMeDor(opt)
{
	var f = document.frmPrincipalDore;
	switch (opt)
	{
		case "R":
			f.action="pmn_carga_fusion_barro_aurifero.php";
			f.submit();
		break;
		case "G": //GRABAR			
			if (f.NumLote.value == "")
			{
				alert("Debe Ingresar Num. Lote");
				f.NumLote.focus();
				return;
			}
			if (f.TxtLoteVentana.value == "")
			{
				if (confirm("No ha ingresado el Lote asignado por el SIPA!!\n¿Desea Ingresarlo ahora?"))
				{
					f.TxtLoteVentana.focus();
					return;
				}
			}
			if (f.LimiteInicial.value =='')
			{
				alert("Debe Ingresar Limite Inicial");
				f.LimiteInicial.focus();
				return;
			}
			if (f.LimiteFinal.value =='')
			{
				alert("Debe Ingresar Limite Final");
				f.LimiteFinal.focus();
				return;
			}
			if ((f.LimiteInicial.value =='')&&(f.LimiteFinal.value ==''))
			{
				alert("Debe Ingresar Limite ");
				f.LimiteInicial.focus();
				return;
			}
			if (parseInt(f.LimiteInicial.value) > parseInt(f.LimiteFinal.value))
			{
				alert("El Limite Inicial no debe ser mayor que Limite Final");
				f.LimiteInicial.focus();
				return;
			}
			f.action= "pmn_ing_metal_dore01.php?Proceso=G";
	 		f.submit();
			break;
		case "G2": //GRABAR DETALLE			
			f.action= "pmn_ing_metal_dore01.php?Proceso=G2";
	 		f.submit();
			break;
		case "M2": //MODIFICAR DETALLE
			f.action= "pmn_carga_electrolito_cubas01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR TODO
			var mensaje = confirm("¿Seguro que desea Eliminar todos los registros asociados a este Lote ?");
			if (mensaje==true)
			{
				f.action= "pmn_ing_metal_dore01.php?Proceso=E";
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
				f.action= "pmn_ing_metal_dore01.php?Proceso=E2";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "C": //CANCELAR
			f.action= "pmn_ing_metal_dore01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //CANCELAR
			var URL = "pmn_ing_metal_dore02.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=100";
	 		f.submit();
			break;
	}

}
var fila = 13; //Posicion Inicial de la Fila.
var col = 3;
function ActivarMeDor(f)
{
	if (f.todos.checked == true)
		valor = true
	else valor = false;		

	pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = f.elements.length;
	for (i=pos; i<largo; i=i+col)
	{	
		if (f.elements[i].type != 'checkbox')
			return;
		else 
			f.elements[i].checked = valor;
	}	
}
function TeclaPulsada1MeDor(salto) 
{ 
	var f = document.frmPrincipalDore;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}

function ExcelMeDor()
{
	var f = document.frmPrincipalDore;
	f.action= "pmn_xls_ing_metal_dore.php?Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&Dia="+f.Dia.value+"&NumLote="+f.NumLote.value;
	f.submit();
	
}
</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
	<?php
		if ($Mostrar != S)
		{
			//echo '<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" onLoad="document.frmPrincipalRpt.NumLote.focus();">';
			echo '<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">';
	
		}
		else
		{
			//echo '<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" onLoad="document.frmPrincipalRpt.LimiteInicial.focus();">';
			echo '<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">';
		}
	?>	



<body leftmargin="3" topmargin="2">
<form name="frmPrincipalDore" method="post" action="">
<?php //include("../principal/encabezado.php")?>
  <table width="98%" border="0" class="TituloCabeceraOz">
    <tr>
      <td >
		<table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaInterior">
          <!--<tr> 
            <td width="79" align="right"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Usuario:</font></font></td>
            <td colspan="4"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php
					/*$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
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
					}*/
		  			?>
              </strong></font></font></td>
            <td colspan="3" align="right"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php /*echo $Fecha_Hora ?>
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
					}*/
				  ?>
              </strong></font></font></td>
          </tr>-->
          <tr> 
            <td width="94" align="right" class="titulo_azul">Fecha:</td>
            <td colspan="2"> 
              <?php 
				if ($Mostrar == "S")
				{
					echo "<input type='hidden' name='Dia' value='01'>\n";
					echo "<input type='hidden' name='Mes' value='".$Mes."'>\n";
					echo "<input type='hidden' name='Ano' value='".$Ano."'>\n";
					printf("%'02d",$Mes);
					echo "-";
					printf("%'04d",$Ano);
				}
				else
				{
					echo "<input type='hidden' name='Dia' value='01'>\n";
					echo "<select name='Mes' style='width:100px'>\n";
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
				  echo "</select> 
				  <select name='Ano' style='width:60px'>\n";
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
</td>
            <td><input name="ver" type="button" style="width:70" value="Consultar" onClick="ProcesoMeDor('B');"></td>
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
		  
            <td align="right" class="titulo_azul">Num Lote:</td>
            <td width="122"> 
			<?php
				if ($Mostrar == "S")
				{
					echo $NumLote;
					echo "<input name='NumLote' type='hidden' value='".$NumLote."'>\n";
				}
				else

				{																													
			?>
				
				 <input name="NumLote" type="text" class="InputDer" id="NumLote" onKeyDown="TeclaPulsada1MeDor('TxtLoteVentana')"  value="<?php echo $NumLote;?>" size='10' maxlength='15'>
		
              		
			<?php	
				}
			
			  ?>
            </td>
            <td width="94"><em class="titulo_azul"><strong>LOTE SIPA: </strong></em></td>
            <td width="92"><input name="TxtLoteVentana" type="text" class="InputDer" id="TxtLoteVentana" onKeyDown="TeclaPulsada1MeDor('LimiteInicial')"  value="<?php echo $TxtLoteVentana;?>" size='10' maxlength='6'></td>
            <td width="101" align="right" class="Detalle01"> Limite Inicial:</td>

            <td width="62" bgcolor="#FFFFFF"> </select> <input name="LimiteInicial"  type="text" class="InputDer" id="LimiteInicial" onKeyDown="TeclaPulsada1MeDor('LimiteFinal')" size="8"></td>
            <td width="99" align="left" class="Detalle01">Limite Final:</td>
            <td width="428" bgcolor="#FFFFFF"><input name="LimiteFinal" type="text" class="InputDer" id="LimiteFinal" onKeyDown="TeclaPulsada1MeDor('BtnGrabar')" size="8">
            &nbsp;&nbsp;</td>
          </tr>
        </table> 
        <br>
          <table width="100%" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td colspan="7"> <input name="BtnGrabar" type="button" id="BtnGrabar2" value="Grabar" style="width:70px;" onClick="ProcesoMeDor('G');">
              <input name="BtnEliminar" type="hidden" id="BtnEliminar2" value="Eliminar" style="width:70px;" onClick="ProcesoMeDor('E');"> 
            <input name="BtnCancelar" type="button" id="BtnCancelar2" value="Cancelar" style="width:70px;" onClick="ProcesoMeDor('C');"></td>
          </tr>
        </table>
        <br>
          <table width="230" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="TituloCabeceraAzul"> 
            <td width="30" height="15"><input type="hidden" name="todos" value="checkbox" onClick="ActivarMeDor(this.form)"></td>
            <td width="100"><strong>#Barra</strong></td>
            <td width="100"><strong>Peso Barra</strong></td>
          </tr>
          <?php	
		$Consulta = "select * from pmn_web.ingreso_metal_dore ";
		$Consulta= $Consulta." where fecha = '".$Ano."-".$Mes."-".$Dia."' and ";
		$Consulta= $Consulta." num_lote = '".$NumLote."'  order by num_barra ";
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>";
			echo "<td align='center'><input type='checkbox' class='SinBorde' name='ChkLote[".$i."]' value='".$Row[num_lote]."'></td>";
			echo "<td align='center'><input class='InputCen' type='text' style='width:60'  name='ChkBarra[".$i."]' readonly value='".$Row[num_barra]."'></td>";
			echo "<td align='center'><input class='InputDer' type='text' style='width:70' name='ChkPeso[".$i."]' value='".$Row[peso_barra]."'></td>";
			echo "</tr>";
			$i++;
			$Suma=$Suma+$Row[peso_barra];
		}
		echo "<tr>";
		echo "<td colspan='2' align='center' class='titulo_azul'><strong>TOTAL</strong></td>";
		echo "<td align='right'><strong>";
		echo number_format($Suma,4,".",",");
		echo "</strong></td>";
		echo "</tr>";
		?>
        </table>
        <br>
          <table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td align="center">
                <input name="BtnGrabar2" type="button" value="Grabar" style="width:70px;" onClick="ProcesoMeDor('G2');">
                <input name="BtnEliminar2" type="button" value="Eliminar" style="width:70px;" onClick="ProcesoMeDor('E2');">
                <input name="BtnExcel" type="button" style="width:70px;" value="Excel" onClick="ExcelMeDor('');"></td>
            </tr>
        </table>
  </td>
  </tr>
</table>
<?php //include("../principal/pie_pagina.php");
		echo "<script languaje='JavaScript'>";
		echo "var frm=document.frmPrincipal;";
		if ($Mensaje=='S')
		{
			
			echo "alert('Hay Barras ingresadas en rango inicial y final  ');";
			echo "frm.LimiteInicial.focus();";
		}
		if ($Mensaje2=='S')
		{
			echo "alert('No se puede Eliminar ya que el stock es menor al valor a Eliminar   ');";
		}
		echo "</script>";
?>
</form>
</body>
</html>
