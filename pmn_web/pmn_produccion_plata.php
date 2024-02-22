<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 126;
	include("../principal/conectar_pmn_web.php");
	if(!isset($DiaPPlata))
		$DiaPPlata=date('d');
	if(!isset($MesPPlata))
		$MesPPlata=date('m');
	if(!isset($AnoPPlata))
		$AnoPPlata=date('Y');
	if ($ConsultaPPlata == "S")
	{
		$MostrarPPlata = "S";
		$DiaPPlata = $IdDiaPPlata;
		$MesPPlata = $IdMesPPlata;
		$AnoPPlata = $IdAnoPPlata;
		$CmbTipoPlata=$T;
	}
	if ($MostrarPSub == "S")
	{
		$MostrarPPlata = "S";
		$DiaPPlata = $DiaPPlata;
		$MesPPlata = $MesPPlata;
		$AnoPPlata = $AnoPPlata;
		//$CmbTipoPlata=$T;
	}
	if ($Mostrar == "S")
	{
		$Consulta = "select * from pmn_web.produccion_plata ";
		$Consulta.= " where fecha = '".$AnoPPlata."-".$MesPPlata."-".$DiaPPlata."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$Obs = $Row["observacion"];
		}
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ProcesoPPlata(opt)
{
	var f = document.frmPrincipalRpt;
	switch (opt)
	{
		case "G": //GRABAR CABECERA				
			f.action= "pmn_embarque01.php?Proceso=G";
	 		f.submit();
			break;
		case "G1": //GRABAR CAJA			
			
			if (f.NumElectrolisis.value == "")
			{
				alert("Debe Ingresar Numero de Electrolisis");
				f.NumElectrolisis.focus();
				return;
			}
			if (f.CmbTipoPPlata.value!=4)
			{
				if (f.NumCaja.value == "")
				{
					alert("Debe Ingresar Numero de Caja");
					f.NumCaja.focus();
					return;
				}
			}
			if (f.PesoCaja.value == "")
			{
				alert("Debe Ingresar Peso");
				f.PesoCaja.focus();
				return;
			}		
			//alert(f.CmbTipoPSub.value)			
			f.action= "pmn_produccion_plata01.php?Proceso=G1";
	 		f.submit();
			break;
		case "M1": //MODIFICAR 
			if(SoloUnElementoPP(f.name,'CheckTipo','M'))
			{
				Datos=RecuperarPP(f.name,'CheckTipo');
				//alert(Datos)
				f.action= "pmn_produccion_plata01.php?Proceso=M1&Datos="+Datos;
				f.submit();
			}
			break;
		case "E1": //ELIMINAR
			if(SoloUnElementoPP(f.name,'CheckTipo','E'))
			{
				var mensaje = confirm("Seguro que desea Eliminar?");
				if (mensaje==true)
				{
					Datos=RecuperarPP(f.name,'CheckTipo');
					f.action= "pmn_produccion_plata01.php?Proceso=E1&Datos="+Datos;
					f.submit();
				}
				else
				{
					return;
				}
			}
			break;
		case "R": //CANCELAR
			var URL = "pmn_produccion_plata02.php?DiaIniCon=" + f.DiaPPlata.value + "&MesIniCon=" + f.MesPPlata.value + "&AnoIniCon=" + f.AnoPPlata.value + "&DiaFinCon=" + f.DiaPPlata.value + "&MesFinCon=" + f.MesPPlata.value + "&AnoFinCon=" + f.AnoPPlata.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "C": //CANCELAR
			f.action= "pmn_produccion_plata01.php?Proceso=C";
	 		f.submit();
			break;
		/*case "B": //CANCELAR
			var URL = "pmn_embarque02.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;*/
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=105";
	 		f.submit();
			break;
	}

}
var fila = 18; //Posicion Inicial de la Fila.
var col = 8;
function ActivarPPlata(f)
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
function RecargaPPlata()
{
	var Frm=document.frmPrincipalRpt;
	if (Frm.CmbTipoPPlata.value == "4")
	{
		Frm.action="pmn_principal_reportes.php?Tab11=true";
		Frm.submit();
	}
	else
	{
		Frm.action="pmn_principal_reportes.php?Tab11=true";
		Frm.submit();
	}
}
function TeclaPulsada1PPlata(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}
function CheckearTodoPP(f,nomchk,nomchkT)
{
	var Check=new Object();
	var CheckT=new Object();
	
	try
	{
		eval("document."+f.name+"."+nomchk+"[0]");
		Check=eval("document."+f.name+"."+nomchk);
		CheckT=eval("document."+f.name+"."+nomchkT);
		for (i=1;i<Check.length;i++)
		{
			if (CheckT.checked==true){
				if(Check[i].disabled==false)
					Check[i].checked=true;
			}
			else{
				if(Check[i].disabled==false)
					Check[i].checked=false;
			}
		}
	}
	catch (e)
	{
	}
}

function SoloUnElementoPP(f,inputchk,Opc)
{
	var CantCheck=0;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
			CantCheck++;
	}
	if (Opc=='M')
	{
		if (CantCheck > 1 ||CantCheck==0)
		{
			if(CantCheck==0)
				alert("Debe Seleccionar un Elemento");
			else
				alert("Debe Seleccionar solo un Elemento");
			return(false);
		}
		else
			return(true);
	}
	else
	{
		if(CantCheck==0)
			alert("Debe Seleccionar un Elemento");
		else
			return(true);			
	}
}
function RecuperarPP(f,inputchk,niv,rutc)
{
		
	var Valores="";
	var Encontro=false;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
		{
			if(niv=='4')
			{
				if(eval("document."+f+".elements["+i+2+"].value")==rutc)
				{
					Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
					Encontro=true;
//				alert(eval("document."+f+".elements["+i+2+"].value"));
				}
				else
				{
					alert("Ud No tiene Acceso a Modificar el Requerimiento");
					Valores="";
				}
			}
			else
			{
				Valores =Valores + (eval("document."+f+"."+inputchk+"["+i+"].value")) +  "//" ;
				Encontro=true;
				
			}
			
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipalPPlata" method="post" action="">
<?php //include("../principal/encabezado.php")?>
  <table width="100%" height="330" border="0" class="TituloCabeceraOz">
    <tr>
    <td align="center" valign="top"><table width="50%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="106" height="30" class="titulo_azul">Fecha:</td>
            <td width="321"> 
              <?php 
				if ($MostrarPPlata == "S")
				{
					echo "<input type='hidden' name='DiaPPlata' value='".$DiaPPlata."'>\n";
					echo "<input type='hidden' name='MesPPlata' value='".$MesPPlata."'>\n";
					echo "<input type='hidden' name='AnoPPlata' value='".$AnoPPlata."'>\n";
					printf("%'02d",$DiaPPlata);
					echo "-";
					printf("%'02d",$MesPPlata);
					echo "-";
					printf("%'04d",$AnoPPlata);
				}
				else
				{
					echo "<select name='DiaPPlata' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaPPlata))
						{
							if ($i == $DiaPPlata)
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
				  echo "</select> <select name='MesPPlata' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesPPlata))
						{
							if ($i == $MesPPlata)
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
				  echo "</select> <select name='AnoPPlata' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($AnoPPlata))
						{
							if ($i == $AnoPPlata)
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
            <td> <input name="ver" type="button" style="width:70" value="Consultar" onClick="ProcesoPPlata('R');"></td>
          </tr>
          <!--<tr> 
            <td>Observaci&oacute;n:</td>
            <td colspan="2"><input name="Obs" type="text" id="Obs" value="<?php echo $Obs;?>" size="80" maxlength="80"></td>
          </tr>-->
        </table>
		  
        <br>
        <table width="50%" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"><input type="hidden" style="width:20" name="CorrelativoPlata" value="<?php echo $CorrelativoPlata;  ?>">
              <input name="BtnGrabar1" type="button" style="width:60px;" onClick="ProcesoPPlata('G1');" value="Grabar"> 
              <input name="BtnModificar1" type="button" style="width:60px;" onClick="ProcesoPPlata('M1');" value="Modificar"> 
              <input name="BtnEliminar1" type="button" style="width:60px;" onClick="ProcesoPPlata('E1');" value="Eliminar"> 
            <input name="BtnCancelar" type="button" value="Cancelar" style="width:60px;" onClick="ProcesoPPlata('C');"></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" class="TablaInterior">
          <tr valign="middle"> 
            <td height="20" align="center" class="titulo_azul">Tipo</td>
            <td align="center"> 
              <select name="CmbTipoPPlata" onChange="RecargaPPlata();">
                <?php
			$Consulta="select * from proyecto_modernizacion.sub_clase";
			$Consulta.=" where cod_clase ='6006' and (cod_subclase='4' or cod_subclase='5') order by valor_subclase1";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta)) 
			{
				if ($CmbTipoPPlata==$Fila["cod_subclase"])
				{
					echo "<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
				}
				else
				{
					echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
				}
			}
			?>
              </select>
            </td>
            <td align="center" class="titulo_azul">#Elec </td>
            <td align="center"> <input name="NumElectrolisis" type="text" id="NumElectrolisis" onKeyDown="TeclaPulsada1PPlata('NumCaja')" value="<?php echo $NumElectrolisis;?>" size="12" maxlength="15"></td>

			<td width='51' align="center" class="titulo_azul">
			<?php
				if ($Opcion!="S")
					echo 'Cajas';
			?>			</td>
        	<td width='73'> 
              <?php
			if ($Opcion!="S")
			{
			?>				
				<input name="NumCaja" type="text" id="NumCaja" value="<?php echo $NumCaja?>" onKeyDown="TeclaPulsada1PPlata('PesoCaja')" size='12' maxlength='15'></td>
			<?php 	
            }
			else
			{
				echo "<input name='NumCaja' type='hidden' value=''>";
			}
			?>
            <td align="center" class="titulo_azul">Peso</td>
            <td align="center"> 
              <input name="PesoCaja" type="text" id="PesoCaja" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($PesoCaja,2,',','.');?>" size="12" maxlength="15">
   			</td>				
		    <td class="titulo_azul">Sob Rep</td>
		    <td> 
              <?php
			if  ($Opcion!="S")
            {
			?>				
				<input name="Sobrante" type="text" id="Sobrante" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($Sobrante,2,',','.');?>" size='12' maxlength='15'></td>
			<?php	
			 }
			 else
			 {
			 	echo "<input name='Sobrante' type='hidden' value=''>";
			 }
			 ?>
          </tr>
          <tr valign="middle"> 
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>						
            <td align="center" class="titulo_azul">N&ordm; de Caja</td>
            <td align="center" class="titulo_azul">Desde</td>
            <td align="center">
<input name="txtdesde" type="text" id="txtdesde" onKeyDown="TeclaPulsada1PPlata('txthasta')" size="12" maxlength="12" value="<?php echo $txtdesde ?>"></td>
            <td width="52" align="center" class="titulo_azul">Hasta</td>
            <td align="center"> 
              <input name="txthasta" type="text" id="txthasta" onKeyDown="TeclaPulsada1PPlata('BtnGrabar1')" size="12" value="<?php echo $txthasta ?>"></td>
          </tr>
        </table> 
        <br>
        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="TituloCabeceraAzul"> 
            <td width="43" rowspan="2"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodoPP(this.form,'CheckTipo','ChkTodos');"></td>
            <td width="80" rowspan="2"><strong>#Elect</strong></td>
            <td width="87" rowspan="2"><strong>#Cajas</strong></td>
            <td width="97" rowspan="2"><strong>Peso</strong></td>
            <td width="97" rowspan="2"><strong>Sobrante Rep</strong></td>
            <!-- <td width="113"><strong>Granalla Reproceso</strong></td>-->
            <td width="113" rowspan="2"><strong>Tipo</strong></td>
            <td height="15" colspan="2"><strong>N&ordm; de Caja</strong></td>
          </tr>
          <tr align="center" class="TituloCabeceraAzul"> 
            <td width="113" height="15"><strong>Desde</strong></td>
            <td width="113"><strong>Hasta</strong></td>
          </tr>
          <?php	
				$Consulta = "select * from pmn_web.produccion_plata ";
				$Consulta.= " where fecha = '".$AnoPPlata."-".$MesPPlata."-".$DiaPPlata."'";
				$Consulta.= " order by num_electrolisis ";
				$Respuesta = mysqli_query($link, $Consulta);
				$i=1;
				$Peso=0;
				$CantCajas=0;
				$cont = 19;
				//echo $Consulta;
				echo "<input name='CheckTipo' type='hidden' value=''>";
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					$Clave=$Row[num_electrolisis]."~".$Row[num_caja]."~".$Row[tipo]."~".$Row["peso"]."~".$Row[sobrante]."~".$Row[granalla_reproceso]."~".$Row[correlativo]."~".$Row[desde]."~".$Row[hasta];
					//echo $Clave."<br>";
					echo "<tr>\n";
					echo "<td align='center'><input type='checkbox' name='CheckTipo' value='".$Clave."'>\n";
					//echo "<input type='checkbox' class='SinBorde' name='ChkNumCaja[".$i."]' value='".$Row[num_caja]."'>\n";
					//echo "<input type='hidden' name='ChkNumElectrolisis[".$i."]' value='".$Row[num_electrolisis]."'>\n";
					//echo "<input type='hidden' name='ChkPesoCaja[".$i."]' value='".$Row["peso"]."'>\n";
					//echo "<input type='hidden' name='ChkSobrante[".$i."]' value='".$Row[sobrante]."'>\n";
					//echo "<input type='hidden' name='ChkGranalla[".$i."]' value='".$Row[granalla_reproceso]."'>\n";
					//echo "<input type='hidden' name='ChkTipo[".$i."]' value='".$Row[tipo]."'>\n";
					//echo "<input type='hidden' name='ChkCorrelativo[".$i."]' value='".$Row[correlativo]."'>\n";
					//echo "<input type='hidden' name='ChkDesde[".$i."]' value='".$Row[desde]."'>\n";
					//echo "<input type='hidden' name='ChkHasta[".$i."]' value='".$Row[hasta]."'>\n";										
					echo "</td>\n";
					echo "<td align='right'>".$Row[num_electrolisis]."</td>\n";
					echo "<td align='center'>".$Row[num_caja]."&nbsp;</td>\n";
					echo "<td align='center'>".number_format($Row["peso"],4,',','.')."&nbsp;</td>\n";
					echo "<td align='center'>".number_format($Row[sobrante],4,',','.')."&nbsp;</td>\n";
					//echo "<td align='center'>".$Row[granalla_reproceso]."&nbsp;</td>\n";
					$Consulta="select * from proyecto_modernizacion.sub_clase";
					$Consulta.=" where cod_clase ='6006' and cod_subclase='".$Row[tipo]."'   ";
					$Resp=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Resp);
					echo "<td align='center'>".$Fila["nombre_subclase"]."</td>\n";
					echo '<td align="center">'.$Row[desde].'</td>';
            		echo '<td align="center">'.$Row[hasta].'</td>';
					echo "</tr>\n";
					$i++;
					$Peso = $Peso + $Row["peso"];
					$CantCajas=$CantCajas + $Row[num_caja];
					$cont = $cont +  6;
				}
				?>
          <tr align="center"> 
            <td height="15" colspan="2" align="right"class="TituloCabeceraAzul">TOTAL</td>
            <td align="center"><?php echo $CantCajas;  ?></td>
            <td align="center"><?php echo $Peso; ?></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
        </table>      </td>
  </tr>
</table>

<?php //include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
