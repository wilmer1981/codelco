<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 53;
	include("../principal/conectar_principal.php");
	$meses =array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
	$meses2 =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut=$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");	
?>
<html>
<head>
<script language="JavaScript">
function Proceso(Opt,f)
{
	var Frm=document.FrmIngreso;
	switch (Opt)
	{
		case "O":
			if (Frm.CmbCliente.value == -1 ) 
			{
				alert("Debe Seleccionar Cliente");
				Frm.CmbCliente.focus();
				return;
			}
			if (Frm.CmbContrato.value == -1 ) 
			{
				alert("Debe Seleccionar Contrato");
				Frm.CmbContrato.focus();
				return;
			}			
			Frm.action="sec_compromiso_venta01.php?Proceso="+Opt;
			Frm.submit();
		break;
		case "G": 
			var fila = 16; //Posicion Inicial de la Fila.	
			var col = 16;
			var Encontro=false;
			pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
			largo = f.elements.length;
			Frm.action= "sec_compromiso_venta01.php?Proceso="+Opt;
			Frm.submit();
			break;
		case "E":
		var mensaje=confirm("�Seguro que Desea Elimnar?");
		if (mensaje==true)
		{
			Frm.action= "sec_compromiso_venta01.php?Proceso="+Opt;
	 		Frm.submit();
			break;
		}
		else
		{
			return;
		}
		case "S":
			Frm.action="../principal/sistemas_usuario.php?CodSistema=3";
			Frm.submit();	
		break;
		case "I":
			window.print();	
		break;
		case "B":
			Frm.action= "sec_compromiso_venta.php?Proceso="+Opt;
	 		Frm.submit();
		break;
		case "EX"://EXCEL
			var msg = confirm("�Si desea ver todos los meses presione Aceptar\nPara ver solo el mes actual presione Cancelar?");
			if (msg==true)
				Frm.action= "sec_compromiso_venta_excel_todo.php";
			else
				Frm.action= "sec_compromiso_venta_excel_mes.php";
	 		Frm.submit();
		break;
		case "A":
			Frm.action= "sec_compromiso_venta.php";
	 		Frm.submit();
		break;
	}
}
function Calcula(J)
{
	var Frm=document.FrmIngreso;
	
	var Suma=Number(Frm.elements[J].value)+Number(Frm.elements[J+1].value)+Number(Frm.elements[J+2].value)+Number(Frm.elements[J+3].value)+Number(Frm.elements[J+4].value)+Number(Frm.elements[J+5].value)+Number(Frm.elements[J+6].value)+Number(Frm.elements[J+7].value)+Number(Frm.elements[J+8].value)+Number(Frm.elements[J+9].value)+Number(Frm.elements[J+10].value)+Number(Frm.elements[J+11].value);
	Frm.elements[J-1].value = Suma;
	if (Frm.elements[J-4].checked == false)
		Frm.elements[J-4].checked = true;
}
function Recarga()
{
	var Frm = document.FrmIngreso;
	Frm.action = "sec_compromiso_venta.php";
	Frm.submit();
}
var fila = 16; //Posicion Inicial de la Fila.
var col = 16;
function Activar(Frm)
{
	if (Frm.todos.checked == true)
		valor = true
	else valor = false;		
	pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = Frm.elements.length;
	for (i=pos; i<largo; i=i+col)
	{	
		if (Frm.elements[i].type != 'checkbox')
		{
			return;
		}
		else 
		{
			if (Frm.elements[i].name != "ChkMuestra")
				Frm.elements[i].checked = valor;
		}
	}	
}
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmIngreso;
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
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
<title>Compromiso Ventas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngreso" method="post" action="">
  <table width="770" height="230" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td width="233" height="32" align="center" valign="top"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
          <?php
					$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from proyecto_modernizacion.funcionarios where rut = '".$Rut."'";
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
          </strong></font></font></div></td>
      <td width="291" align="center" valign="top"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2"> 
        <select name="Tipo" onChange="Recarga();">
          <?php
	if ($Tipo == "C")
	{
		echo "<option value='E'>ENAMI</option>\n";
		echo "<option selected value='C'>CODELCO</option>\n";
	}
	else
	{
		echo "<option selected value='E'>ENAMI</option>\n";
		echo "<option value='C'>CODELCO</option>\n";
	}
?>
        </select>
        </font></font></font></font></font><font size="1"><font size="1"><font size="1"><font size="1"><font size="2"> 
        <select name="MesIni2">
          <option value='T'>TODOS</option>
          <?php
			for ($i=1;$i<=12;$i++)
			{
				if (isset($MesIni2))
				{
					if ($i == $MesIni2)
						echo "<option selected value='".$i."'>".$meses2[$i-1]."</option>\n";
					else	echo "<option value='".$i."'>".$meses2[$i-1]."</option>\n";
				}
				else
				{
					echo "<option value='".$i."'>".$meses2[$i-1]."</option>\n";
					/*if ($i == date("n"))
						echo "<option selected value='".$i."'>".$meses2[$i-1]."</option>\n";
					else	echo "<option value='".$i."'>".$meses2[$i-1]."</option>\n";*/
				}
			}
		?>
        </select>
        </font></font></font><font size="2"> 
        <select name="AnoIni2" style="width:60px;">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoIni2))
				{
					if ($i == $AnoIni2)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
			}
		?>
        </select>
        <input name="BtnBuscar" type="button" id="BtnBuscar2" value="Ver" onClick="Proceso('B');">
        </font></font></font></td>
      <td width="218" align="center" valign="top"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
        <?php echo $Fecha_Hora ?> </strong>&nbsp; <strong> 
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
      <td height="313" colspan="3" align="center" valign="top"> 
	  
	  <table border="0" class="TablaInterior">
          <tr> 
            <td height="23" align="right"><?php 
			if ($Tipo != "C")
				echo "Mercado";
			else echo "Asignacion"; 
			?></td>
            <td width="377"><?php 
			if ($Tipo != "C")
			{
				echo "<select name='Pais' onChange='Recarga();' style='width:200px'>\n";
                echo "<option value='S'>Seleccionar</option>\n";
				$Consulta = "select * from sec_web.paises ";
				$Consulta.= " order by nombre_pais";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					if ($Pais == $Fila["cod_pais"])
						echo "<option value='".$Fila["cod_pais"]."' selected>".ucwords(strtolower($Fila["nombre_pais"]))."</option>\n";
					else
						echo "<option value='".$Fila["cod_pais"]."'>".ucwords(strtolower($Fila["nombre_pais"]))."</option>\n";
				}
				echo "</select>\n";
			}
			else
			{
				echo "<select name='Pais' style='width:200px'>\n";
                echo "<option value='S'>Seleccionar</option>\n";
				$Consulta = "select * from proyecto_modernizacion.sub_clase ";
				$Consulta.= " where cod_clase = '3016'";
				$Consulta.= " order by cod_subclase";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					if ($Pais == $Fila["nombre_subclase"])
						echo "<option value='".$Fila["nombre_subclase"]."' selected>".$Fila["valor_subclase1"]."</option>\n";
					else
						echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";
				}
				echo "</select><input name='BtnOk' type='button' id='BtnOk4' value='Ok' onClick=\"Proceso('O');\">\n";
			}
			?>
               </td>
            <td width="83" align="right">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="70"><?php 
			if ($Tipo != "C")
				echo "<div align='right'>Cliente</div>\n";
			?></td>
            <td>
              <?php 
			if ($Tipo != "C")
			{
				echo "<select name='CmbCliente' onChange='Recarga();' style='width:330px'>\n";
                echo "<option value='S'>Seleccionar</option>\n";
				if ($Pais == "001")
				{
					$Consulta = "select * from sec_web.cliente_venta ";
					$Consulta.= " where substring(cod_cliente,1,2) = 'ZU' ";
					$Consulta.= " and substring(cod_cliente,1,2) <> 'VD'";//VENTA DIRECTA 
					$Consulta.= " order by sigla_cliente";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						if ($CmbCliente == $Fila["cod_cliente"])
							echo "<option value='".$Fila["cod_cliente"]."' selected>".strtoupper($Fila["cod_cliente"])." - ".ucwords(strtolower($Fila["sigla_cliente"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_cliente"]."'>".strtoupper($Fila["cod_cliente"])." - ".ucwords(strtolower($Fila["sigla_cliente"]))."</option>\n";
					}
				}
				else
				{
					$Consulta = "select * from sec_web.cliente_venta ";
					$Consulta.= " where cod_pais = '".$Pais."'";
					$Consulta.= " and substring(cod_cliente,1,2) <> 'ZU'";
					$Consulta.= " and substring(cod_cliente,1,2) <> 'VD'";//VENTA DIRECTA
					$Consulta.= " order by sigla_cliente";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						if ($CmbCliente == $Fila["cod_cliente"])
							echo "<option value='".$Fila["cod_cliente"]."' selected>".strtoupper($Fila["cod_cliente"])." - ".ucwords(strtolower($Fila["sigla_cliente"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_cliente"]."'>".strtoupper($Fila["cod_cliente"])." - ".ucwords(strtolower($Fila["sigla_cliente"]))."</option>\n";
					}
				}
				echo "</select>\n";
			}
			else //CODELCO
			{
				echo "<input type='hidden' name='CmbCliente'>\n";
			}
              ?>
            </td>
            <td align="right"><?php 
			if ($Tipo != "C")
				echo "N&deg;Contrato\n";
			?>
              </td>
            <td width="210"><?php 
			if ($Tipo != "C")
			{
				echo "<select name='CmbContrato' style='width:90' >\n";
                echo "<option value='-1'>Seleccionar</option>\n";
				if ($Tipo == "E")
					$EnmCode = "enami";
				if ($Tipo == "C")
					$EnmCode = "codelco";
				$Consulta="select distinct cod_contrato from sec_web.programa_".$EnmCode." where cod_cliente = '".$CmbCliente."' ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbContrato==$Fila["cod_contrato"])
					{
						echo "<option value = '".$Fila["cod_contrato"]."' selected>".$Fila["cod_contrato"]."</option>";	
					}
					else
					{
						echo "<option value = '".$Fila["cod_contrato"]."'>".$Fila["cod_contrato"]."</option>";	
					}
				}
				echo "</select> <input name='BtnOk' type='button' value='Ok' onClick=\"Proceso('O');\">\n";
			}
			else //CODELCO
			{
				echo "<input type='hidden' name='CmbContrato'>\n";
			}
				?>
              </td>
          </tr>
          <tr align="center">
            <td colspan="4"><input name="BtnActualizar2" type="button" id="BtnActualizar2" style="width:60px;" onClick="Proceso('A');" value="Actualizar">
              <input name="BtnGrabar22" type="button" value="Grabar" style="width:60px;" onClick="Proceso('G',this.form);">
              <input name="BtnEliminar22" type="button" value="Eliminar" style="width:60px;" onClick="Proceso('E');">
              <input name="BtnImprimir2" type="button" id="BtnImprimir2" style="width:60px;" onClick="Proceso('I');"  value="Imprimir">
              <input name="BtnExcel2" type="button"  value="Excel" style="width:60px;" onClick="Proceso('EX');">
              <input name="BtnSalir22" type="button" id="BtnSalir2" value="Salir" style="width:60px;" onClick="Proceso('S');"></td>
          </tr>
          <tr>
            <td colspan="4"><strong>NOTA:</strong> LOS VALORES DEBEN SER INGRESADOS EN KILOGRAMOS
              (Kg) </td>
          </tr>
        </table>
        <br> 
<?php
	if (!isset($Tipo))
	{
		$AnoIni2 = date("Y");
		$Tipo = "E";
		$MesIni2 = "T";
	}	
	if ($Tipo != "C") //ENAMI
	{
		echo "<table width='762' height='20' border='1' align='center' cellpadding='0' cellspacing='0' class='TablaDetalle'>\n";
		echo "<tr align='center' class='ColorTabla01'>\n"; 
		echo "<td width='15' height='15'><input type='checkbox' name='todos' value='checkbox' onClick='Activar(this.form)'></td>\n";
		echo "<td width='60'><strong>#Contrato</strong></td>\n";
		echo "<td width='80'><strong>Cliente</strong></td>\n";
		echo "<td width='55'><strong>Total</strong></td>\n";
		for($i=1;$i<13;$i++)
		{
			echo "<td width='40'>".$meses[$i-1]."</td>";
		}
		echo "</tr>\n";	
		$Consulta = "select * from sec_web.programa_ventas t1 inner join sec_web.cliente_venta t2 ";
		$Consulta.= " on t1.cod_cliente = t2.cod_cliente ";
		if (isset($AnoIni2))
			$Consulta.= " where t1.ano = '".$AnoIni2."'";
		else
			$Consulta.= " where t1.ano = '".date("Y")."'";
		if (($MesIni2 != "T") && (isset($MesIni2)))			
			$Consulta.= " and (".$meses[$MesIni2-1]." <> '' or ".$meses[$MesIni2-1]." != NULL)";
		$Consulta.= " and enm_code = 'E'";
		$Consulta.= " order by substring(t1.cod_cliente,1,2),t1.cod_contrato,t1.cod_cliente";	
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		$J=16;
		$CodPaisAnt = 0;
		$CodPais = 0;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$CodPais = substr($Fila["cod_cliente"],0,2);
			if ($CodPaisAnt != $CodPais)
			{
				if ($i != 1)
				{
					$Consulta = "select * from sec_web.paises where abreviatura = '".$CodPaisAnt."'";
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
						$NomPais = $Fila2["nombre_pais"];
					echo "<tr>";
					echo "<td align='left' colspan='3'><strong>TOTAL ".strtoupper($NomPais)."</strong></td>";
					echo "<td align='right'>".number_format($Total,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalEne,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalFeb,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalMar,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalAbr,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalMay,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalJun,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalJul,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalAgo,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalSep,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalOct,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalNov,0,",",".")."</td>";
					echo "<td align='right'>".number_format($TotalDic,0,",",".")."</td>";				
					echo "</tr>";
					$Total = 0;
					$TotalEne = 0;
					$TotalFeb = 0;
					$TotalMar = 0;
					$TotalAbr = 0;
					$TotalMay = 0;
					$TotalJun = 0;
					$TotalJul = 0;
					$TotalAgo = 0;
					$TotalSep = 0;
					$TotalOct = 0;
					$TotalNov = 0;
					$TotalDic = 0;
				}
			}			
			$Sigla = $Fila["sigla_cliente"];
			$V_Ene = "";
			$V_Feb = "";
			$V_Mar = "";
			$V_Abr = "";
			$V_May = "";
			$V_Jun = "";
			$V_Jul = "";
			$V_Ago = "";
			$V_Sep = "";
			$V_Oct = "";
			$V_Nov = "";
			$V_Dic = "";
			if ($Fila[ene]!=0)
				$V_Ene = $Fila[ene];
			if ($Fila[feb]!=0)
				$V_Feb = $Fila[feb];
			if ($Fila[mar]!=0)
				$V_Mar = $Fila[mar];
			if ($Fila[abr]!=0)
				$V_Abr = $Fila[abr];
			if ($Fila[may]!=0)
				$V_May = $Fila[may];
			if ($Fila[jun]!=0)
				$V_Jun = $Fila[jun];
			if ($Fila[jul]!=0)
				$V_Jul = $Fila[jul];
			if ($Fila[ago]!=0)
				$V_Ago = $Fila[ago];
			if ($Fila[sep]!=0)
				$V_Sep = $Fila[sep];
			if ($Fila[oct]!=0)
				$V_Oct = $Fila[oct];
			if ($Fila[nov]!=0)
				$V_Nov = $Fila[nov];
			if ($Fila[dic]!=0)
				$V_Dic = $Fila[dic];
			echo "<tr>";
			echo "<td align='center'><input type='checkbox' name='ChkContrato1[".$i."]' value='".$Fila["cod_contrato"]."'></td>";
			echo "<td align='center'><input type='hidden' style='width:60' readonly name='ChkContrato[".$i."]' value='".$Fila["cod_contrato"]."'>".$Fila["cod_contrato"]."</td>";
			echo "<td align='center'><input type='hidden' style='width:80' readonly name='ChkCliente[".$i."]' value='".$Fila["cod_cliente"]."'>".$Sigla."</td>";
			echo "<td align='center'><input type='text' style='width:55' readonly name='ChkTonelajeTotal[".$i."]' value='".$Fila[tonelaje_total]."'></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje1[".$i."]' value='".$V_Ene."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje2[".$i."]' value='".$V_Feb."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje3[".$i."]' value='".$V_Mar."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje4[".$i."]' value='".$V_Abr."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje5[".$i."]' value='".$V_May."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje6[".$i."]' value='".$V_Jun."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje7[".$i."]' value='".$V_Jul."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje8[".$i."]' value='".$V_Ago."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje9[".$i."]' value='".$V_Sep."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje10[".$i."]' value='".$V_Oct."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje11[".$i."]' value='".$V_Nov."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje12[".$i."]' value='".$V_Dic."' onBlur=\"Calcula(".($J+4).");\"></td>";			
			echo "</tr>";
			//TOTAL POR PAIS
			$Total = $Total + $Fila[tonelaje_total];
			$TotalEne = $TotalEne + $Fila[ene];
			$TotalFeb = $TotalFeb + $Fila[feb];
			$TotalMar = $TotalMar + $Fila[mar];
			$TotalAbr = $TotalAbr + $Fila[abr];
			$TotalMay = $TotalMay + $Fila[may];
			$TotalJun = $TotalJun + $Fila[jun];
			$TotalJul = $TotalJul + $Fila[jul];
			$TotalAgo = $TotalAgo + $Fila[ago];
			$TotalSep = $TotalSep + $Fila[sep];
			$TotalOct = $TotalOct + $Fila[oct];
			$TotalNov = $TotalNov + $Fila[nov];
			$TotalDic = $TotalDic + $Fila[dic];
			//TOTAL TOTAL
			$Total2 = $Total2 + $Fila[tonelaje_total];
			$TotalEne2 = $TotalEne2 + $Fila[ene];
			$TotalFeb2 = $TotalFeb2 + $Fila[feb];
			$TotalMar2 = $TotalMar2 + $Fila[mar];
			$TotalAbr2 = $TotalAbr2 + $Fila[abr];
			$TotalMay2 = $TotalMay2 + $Fila[may];
			$TotalJun2 = $TotalJun2 + $Fila[jun];
			$TotalJul2 = $TotalJul2 + $Fila[jul];
			$TotalAgo2 = $TotalAgo2 + $Fila[ago];
			$TotalSep2 = $TotalSep2 + $Fila[sep];
			$TotalOct2 = $TotalOct2 + $Fila[oct];
			$TotalNov2 = $TotalNov2 + $Fila[nov];
			$TotalDic2 = $TotalDic2 + $Fila[dic];
			$i++;
			$J=$J+16;
			$CodPaisAnt = substr($Fila["cod_cliente"],0,2);
		}
		$Consulta = "select * from sec_web.paises where abreviatura = '".$CodPaisAnt."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			$NomPais = $Fila2["nombre_pais"];
		echo "<tr>";
		echo "<td align='left' colspan='3'><strong>TOTAL ".strtoupper($NomPais)."</strong></td>";
		echo "<td align='right'>".number_format($Total,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalEne,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalFeb,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMar,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAbr,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMay,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJun,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJul,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAgo,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalSep,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalOct,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalNov,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalDic,0,",",".")."</td>";				
		echo "</tr>";
		//TOTAL TOTAL
		echo "<tr>";
		echo "<td align='left' colspan='3'><strong>TOTAL</strong></td>";
		echo "<td align='right'>".number_format($Total2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalEne2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalFeb2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMar2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAbr2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMay2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJun2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJul2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAgo2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalSep2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalOct2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalNov2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalDic2,0,",",".")."</td>";				
		echo "</tr></table>";
	}
	else //CODELCO
	{
		echo "<table width='762' height='20' border='1' align='center' cellpadding='0' cellspacing='0' class='TablaDetalle'>\n";
		echo "<tr align='center' class='ColorTabla01'>\n"; 
		echo "<td width='15' height='15'><input type='checkbox' name='todos' value='checkbox' onClick='Activar(this.form)'></td>\n";
		echo "<td width='60' align='center'><strong>Asignacion</strong></td>\n";
		echo "<td width='55'><strong>Total</strong></td>\n";
		for($i=1;$i<13;$i++)
		{
			echo "<td width='40'>".$meses[$i-1]."</td>";
		}
		echo "</tr>\n";	
		$Consulta = "select * from sec_web.programa_ventas t1 ";
		if (isset($AnoIni2))
			$Consulta.= " where t1.ano = '".$AnoIni2."'";
		else
			$Consulta.= " where t1.ano = '".date("Y")."'";
		if (($MesIni2 != "T") && (isset($MesIni2)))			
			$Consulta.= " and (".$meses[$MesIni2-1]." <> '' or ".$meses[$MesIni2-1]." != NULL)";
		$Consulta.= " and t1.enm_code = 'C'";
		$Consulta.= " order by substring(t1.cod_cliente,1,2),t1.cod_contrato,t1.cod_cliente";	
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		$J=10;
		$CodPaisAnt = 0;
		$CodPais = 0;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{										
			$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3016' and nombre_subclase = '".$Fila["cod_cliente"]."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
				$Sigla = $Fila2["valor_subclase1"];			
			echo "<tr>";
			echo "<td align='center'><input type='checkbox' name='ChkContrato1[".$i."]' value='".$Fila["cod_contrato"]."'><input type='hidden' style='width:60' readonly name='ChkContrato[".$i."]' value='".$Fila["cod_contrato"]."'></td>";
			//echo "<td align='center'><input type='hidden' style='width:60' readonly name='ChkContrato[".$i."]' value='".$Fila["cod_contrato"]."'>".$Fila["cod_contrato"]."</td>";
			echo "<td><input type='hidden' style='width:80' readonly name='ChkCliente[".$i."]' value='".$Fila["cod_cliente"]."'>".$Sigla."</td>";
			echo "<td align='center'><input type='text' style='width:55' readonly name='ChkTonelajeTotal[".$i."]' value='".$Fila[tonelaje_total]."'></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje1[".$i."]' value='".$Fila[ene]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje2[".$i."]' value='".$Fila[feb]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje3[".$i."]' value='".$Fila[mar]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje4[".$i."]' value='".$Fila[abr]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje5[".$i."]' value='".$Fila[may]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje6[".$i."]' value='".$Fila[jun]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje7[".$i."]' value='".$Fila[jul]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje8[".$i."]' value='".$Fila[ago]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje9[".$i."]' value='".$Fila[sep]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje10[".$i."]' value='".$Fila[oct]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje11[".$i."]' value='".$Fila[nov]."' onBlur=\"Calcula(".($J+4).");\"></td>";
			echo "<td align='center'><input type='text' style='width:55' name='ChkTonelaje12[".$i."]' value='".$Fila[dic]."' onBlur=\"Calcula(".($J+4).");\"></td>";			
			echo "</tr>";
			//TOTAL POR PAIS
			$Total = $Total + $Fila[tonelaje_total];
			$TotalEne = $TotalEne + $Fila[ene];
			$TotalFeb = $TotalFeb + $Fila[feb];
			$TotalMar = $TotalMar + $Fila[mar];
			$TotalAbr = $TotalAbr + $Fila[abr];
			$TotalMay = $TotalMay + $Fila[may];
			$TotalJun = $TotalJun + $Fila[jun];
			$TotalJul = $TotalJul + $Fila[jul];
			$TotalAgo = $TotalAgo + $Fila[ago];
			$TotalSep = $TotalSep + $Fila[sep];
			$TotalOct = $TotalOct + $Fila[oct];
			$TotalNov = $TotalNov + $Fila[nov];
			$TotalDic = $TotalDic + $Fila[dic];
			//TOTAL TOTAL
			$Total2 = $Total2 + $Fila[tonelaje_total];
			$TotalEne2 = $TotalEne2 + $Fila[ene];
			$TotalFeb2 = $TotalFeb2 + $Fila[feb];
			$TotalMar2 = $TotalMar2 + $Fila[mar];
			$TotalAbr2 = $TotalAbr2 + $Fila[abr];
			$TotalMay2 = $TotalMay2 + $Fila[may];
			$TotalJun2 = $TotalJun2 + $Fila[jun];
			$TotalJul2 = $TotalJul2 + $Fila[jul];
			$TotalAgo2 = $TotalAgo2 + $Fila[ago];
			$TotalSep2 = $TotalSep2 + $Fila[sep];
			$TotalOct2 = $TotalOct2 + $Fila[oct];
			$TotalNov2 = $TotalNov2 + $Fila[nov];
			$TotalDic2 = $TotalDic2 + $Fila[dic];
			$i++;
			$J=$J+16;
			$CodPaisAnt = substr($Fila["cod_cliente"],0,2);
		}
		$Consulta = "select * from sec_web.paises where abreviatura = '".$CodPaisAnt."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			$NomPais = $Fila2["nombre_pais"];
		echo "<tr>";
		echo "<td align='left' colspan='2'><strong>TOTAL ".strtoupper($NomPais)."</strong></td>";
		echo "<td align='right'>".number_format($Total,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalEne,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalFeb,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMar,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAbr,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMay,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJun,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJul,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAgo,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalSep,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalOct,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalNov,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalDic,0,",",".")."</td>";				
		echo "</tr>";
		//TOTAL TOTAL
		echo "<tr>";
		echo "<td align='left' colspan='2'><strong>TOTAL</strong></td>";
		echo "<td align='right'>".number_format($Total2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalEne2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalFeb2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMar2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAbr2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalMay2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJun2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalJul2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalAgo2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalSep2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalOct2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalNov2,0,",",".")."</td>";
		echo "<td align='right'>".number_format($TotalDic2,0,",",".")."</td>";				
		echo "</tr></table>";		
	}
		?>
        
        <br> <table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td> <div align="center"> 
                <input name="BtnActualizar" type="button" id="BtnActualizar" style="width:60px;" onClick="Proceso('A');" value="Actualizar">
                <input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="Proceso('G',this.form);">
                <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="Proceso('E');">
                <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:60px;" onClick="Proceso('I');"  value="Imprimir">
                <input name="BtnExcel" type="button"  value="Excel" style="width:60px;" onClick="Proceso('EX');">
                <input name="BtnSalir2" type="button" id="BtnSalir" value="Salir" style="width:60px;" onClick="Proceso('S');">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
	if ($Mostrar=='S')
	{
		echo "<script language='JavaScript'>";
		echo "var Frm=document.FrmIngreso;";
		echo "alert('Este Contrato Ya existe');";
		echo "Frm.CmbContrato.focus();";
		echo "</script>";
	}
?>
