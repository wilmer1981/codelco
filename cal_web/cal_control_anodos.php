<?php
	$CodigoDeSistema = 1;
	$CodigoDePantalla=93;
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["TipoProducto"])) {
		$TipoProducto = $_REQUEST["TipoProducto"];
	}else{
		$TipoProducto ="";
	}
	if(isset($_REQUEST["CmbPlantilla"])) {
		$CmbPlantilla = $_REQUEST["CmbPlantilla"];
	}else{
		$CmbPlantilla ="";
	}
	if(isset($_REQUEST["TxtFechaIni"])) {
		$TxtFechaIni = $_REQUEST["TxtFechaIni"];
	}else{
		$TxtFechaIni=date("Y-m")."-01";
	}
	if(isset($_REQUEST["TxtFechaFin"])) {
		$TxtFechaFin = $_REQUEST["TxtFechaFin"];
	}else{
		$TxtFechaFin=date("Y-m-d");
	}

	
?>
<html>
<head>
<title>CAL-Control de Anodos</title>
<link href="../principal/estilos/css_rec_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "E":			
			var Valores = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked)
				{					
					//COD_LEY,SIGNO,VALOR
					var Valores = Valores + f.elements[i].value + "~~" + f.elements[i+1].value + "~~" + f.elements[i+2].value + "//";
				}	
			}
			var Largo = Valores.length;
			Valores = Valores.substring(0,Largo-2);
			f.action = "cal_control_anodos_excel.php?Valores=" + Valores;
			f.submit();
			break;
		case "R":
			f.action = "cal_control_anodos.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
			f.submit(); 
			break;
		case "W":			
			var Valores = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked)
				{					
					//COD_LEY,SIGNO,VALOR
					var Valores = Valores + f.elements[i].value + "~~" + f.elements[i+1].value + "~~" + f.elements[i+2].value + "//";
				}	
			}
			var Largo = Valores.length;
			Valores = Valores.substring(0,Largo-2);
			f.action = "cal_control_anodos_web.php?Valores=" + Valores;
			f.submit();
			break;
		case "GP": //GUARDA PLANTILLA
			var Valores = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked)
				{					
					//COD_LEY,SIGNO,VALOR
					var Valores = Valores + f.elements[i].value + "~~" + f.elements[i+1].value + "~~" + f.elements[i+2].value + "//";
				}
			}
			var Largo = Valores.length;
			Valores = Valores.substring(0,Largo-2);
			if (f.CmbPlantilla.value=="S")
			{
				window.open("cal_control_anodos02.php?TipoProducto="+ f.TipoProducto.value+"&Valores="+Valores,"","top=70,left=50,width=450,height=250,scrollbars=yes,resizable = yes");
			}
			else
			{
				if (confirm("¿Desea reemplazar la Plantilla Existente?"))
				{
					f.action="cal_control_anodos01.php?TxtCodigo="+f.CmbPlantilla.value+"&Proceso=G&Modif=S&TipoProducto="+ f.TipoProducto.value+"&Valores="+Valores;
					f.submit();
				}
				else
				{
					window.open("cal_control_anodos02.php?TipoProducto="+ f.TipoProducto.value+"&Valores="+Valores,"","top=70,left=50,width=450,height=250,scrollbars=yes,resizable = yes");
				}
			}
			break;
		case "EP": //ELIMINA PLANTILLA
			var msg = confirm("¿onfirma que desea eliminar esta Plantilla?");
			if (msg==true)
			{
				f.action = "cal_control_anodos01.php?Proceso=E";
				f.submit();
			}
			else
			{
				return;
			}
			break;
	}
}

function MarcaTodos()
{
	var f=document.frmPrincipal;
	for (i=1;i<f.elements.length;i++)
	{
		if (f.elements[i].name=="ChkLeyes")
		{
			if (f.ChkMarcaTodos.checked == false)
				f.elements[i].checked = false;
			else 	f.elements[i].checked = true;
		}
	}
}

function Marca(J)
{
	var f=document.frmPrincipal;
	if (f.elements[J].value != "")
	{
		f.elements[J-2].checked = true;
	}
	else
	{
		f.elements[J-2].checked = false;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form action="" method="post" name="frmPrincipal">
<?php include("../principal/encabezado.php")?>
  <table width="771" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td width="757" height="316" valign="top"> 
        <table width="600" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF" class="ColorTabla01">
            <td colspan="3">CONTROL DE ANODOS </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="88" height="24">SubProducto:</td>
            <td width="343"><font color="#FFFFFF">
              <select name="TipoProducto" style="width:220px" onChange="Proceso('R');">
                <option value="0-0">SELECCIONAR</option>
                <?php					

                	$consulta = "SELECT DISTINCT * FROM proyecto_modernizacion.subproducto ";
					$consulta.= " WHERE cod_producto IN(17,19) AND mostrar_sea = 'S' ORDER BY cod_producto";
					$rs3 = mysqli_query($link, $consulta);
					while ($row3 = mysqli_fetch_array($rs3))
					{
						$prod = $row3["cod_producto"].'-'.$row3["cod_subproducto"];
						
						if ($prod == $TipoProducto)
							echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'" selected>'.$row3["descripcion"].'</option>';
						else 
							echo '<option value="'.$row3["cod_producto"].'-'.$row3["cod_subproducto"].'">'.$row3["descripcion"].'</option>';
					}

				?>
              </select>
            </font><font color="#FFFFFF">&nbsp;</font></td>
            <td width="150" rowspan="3" align="center" valign="middle">		      <input name="BtnGuardar" type="button" id="BtnGuardar3" style="width:110px" onClick="Proceso('GP');" value="Guardar Plantilla">              <br>              <br>              <input name="BtnEliminar" type="button" id="BtnEliminar4" style="width:110px" onClick="Proceso('EP');" value="Eliminar Plantilla"></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>Plantilla:</td>
            <td><font color="#FFFFFF">
              <select name="CmbPlantilla" style="width:220px" onChange="Proceso('R');">
                <option value="S">NINGUNA</option>
                <?php					
					$Datos = explode("-",$TipoProducto);
					$Producto = $Datos[0];
					$SubProducto = $Datos[1];
                	$Consulta = "SELECT DISTINCT corr, descripcion FROM sea_web.limites ";
					$Consulta.= " WHERE sistema='CAL' and cod_producto = '".$Producto."' ";
					$Consulta.= " AND cod_subproducto = '".$SubProducto."' ORDER BY corr";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						if ($CmbPlantilla == $Fila["corr"])
							echo '<option value="'.$Fila["corr"].'" selected>'.$Fila["descripcion"]."</option>\n";
						else 
							echo "<option value=\"".$Fila["corr"]."\">".$Fila["descripcion"]."</option>\n";
					}

				?>
              </select>
            </font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>Fecha:</td>
            <td><input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al
              <input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"></td>
          </tr>
          <tr valign="middle" bgcolor="#FFFFFF"> 
            <td height="18" colspan="3" align="center" class="Detalle02">              <input type="button" name="btnWeb" value="Consulta Web" onClick="Proceso('W');" style="width:90px">
                <input type="button" name="btnExcel" value="Consulta Excel" onClick="Proceso('E');" style="width:90px">                            
            <input type="button" name="btnsalir" value="Salir" onClick="Proceso('S');" style="width:90px">            </td>
          </tr>          
        </table>
		<br>
        <table width="730" border="0" align="center" cellpadding="3" cellspacing="3" class="TablaInterior">
          <tr>
            <td align="center"><strong>MOSTRAR HORNADAS CUYAS LEYES SEAN:</strong>              <table width="250" border="1" cellpadding="1" cellspacing="0" class="TablaInterior">
              <tr align="center" class="ColorTabla01">
                <th width="18" scope="row">Ver				
                  <input type="checkbox" name="ChkMarcaTodos" value="" onClick="MarcaTodos();"></th>
                <td width="52">Ley</td>
                <td width="70">Signo</td>
                <td width="91">Valor</td>
              </tr>
<?php		
	$Consulta = "select distinct t1.cod_leyes, t2.abreviatura ";
	$Consulta.= " from sea_web.leyes_por_hornada t1 ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t2 ";
	$Consulta.= " on t1.cod_leyes = t2.cod_leyes ";
	$Consulta.= " where t1.cod_producto = '".$Producto."'";
	$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";	
	$Consulta.= " order by t1.cod_leyes"; 
	$Respuesta = mysqli_query($link, $Consulta); 
	$i=10;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$ValorA = "";
		$Signo = "";
		$Consulta = "select * from sea_web.limites ";
		$Consulta.= " where cod_producto = '".$Producto."'";
		$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		$Consulta.= " and cod_leyes = '".$Fila["cod_leyes"]."'";
		$Consulta.= " and sistema = 'CAL'";
		$Consulta.= " and corr = '".$CmbPlantilla."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{			
			$ValorA = $Fila2["limite"];
			$Signo = $Fila2["signo"];
		}
		if ($ValorA > "")
		{
			echo "<tr bgcolor=\"white\">\n";
			echo "<td >";		
			echo "<input type='checkbox' checked name='ChkLeyes' value='".$Fila["cod_leyes"]."'>";
		}
		else
		{
			echo "<tr>\n";
			echo "<td >";		
			echo "<input type='checkbox' name='ChkLeyes' value='".$Fila["cod_leyes"]."'>";
		}
		echo "</td>\n";
		echo "<td align='center'>".$Fila["abreviatura"]."</td>\n";
		echo "<td align='center'>";
		echo "<select name='Signo[".$i."]'>";
		switch ($Signo)
		{
			case ">":
				echo "<option selected value='>'>></option>";
				echo "<option value='<'><</option>";
				echo "<option value='='>=</option>";	
				break;
			case "<":
				echo "<option value='>'>></option>";
				echo "<option selected value='<'><</option>";
				echo "<option value='='>=</option>";	
				break;
			case "=":
				echo "<option value='>'>></option>";
				echo "<option value='<'><</option>";
				echo "<option selected value='='>=</option>";	
				break;
			default:
				echo "<option value='>'>></option>";
				echo "<option value='<'><</option>";
				echo "<option value='='>=</option>";	
				break;						
		}
		echo "</select>";
		echo "</td>\n";
		echo "<td align='center'><input name='Valor[".$i."]' type='text' size='15' maxlength='10' value='".$ValorA."' onFocus='Marca(".($i+2).");' onBlur='Marca(".($i+2).");'></td>\n";
		echo "</tr>\n";
		$i=$i+3;
	}
	//----------------------AS/SB----------------------------
	$ValorA = "";
	$Signo = "";
	$Consulta = "select * from sea_web.limites ";
	$Consulta.= " where cod_producto = '".$Producto."'";
	$Consulta.= " and cod_subproducto = '".$SubProducto."'";
	$Consulta.= " and cod_leyes = 'AS/SB'";
	$Consulta.= " and sistema = 'CAL'";
	$Consulta.= " and corr = '".$CmbPlantilla."'";
	$Resp2 = mysqli_query($link, $Consulta);
	if ($Fila2 = mysqli_fetch_array($Resp2))
	{			
		$ValorA = $Fila2["limite"];
		$Signo = $Fila2["signo"];
	}
	if ($ValorA > "")
	{
		echo "<tr bgcolor=\"white\">\n";
		echo "<td >";		
		echo "<input type='checkbox' checked name='ChkLeyes' value='AS/SB'>";
	}
	else
	{
		echo "<tr>\n";
		echo "<td >";		
		echo "<input type='checkbox' name='ChkLeyes' value='AS/SB'>";
	}
	echo "</td>\n";
	echo "<td align='center'>As/Sb</td>\n";
	echo "<td align='center'>";
	echo "<select name='Signo[".$i."]'>";
	switch ($Signo)
	{
		case ">":
			echo "<option selected value='>'>></option>";
			echo "<option value='<'><</option>";
			echo "<option value='='>=</option>";	
			break;
		case "<":
			echo "<option value='>'>></option>";
			echo "<option selected value='<'><</option>";
			echo "<option value='='>=</option>";	
			break;
		case "=":
			echo "<option value='>'>></option>";
			echo "<option value='<'><</option>";
			echo "<option selected value='='>=</option>";	
			break;
		default:
			echo "<option value='>'>></option>";
			echo "<option value='<'><</option>";
			echo "<option value='='>=</option>";	
			break;						
	}
	echo "</select>";
	echo "</td>\n";
	echo "<td align='center'><input name='Valor[".$i."]' type='text' size='15' maxlength='10' value='".$ValorA."' onFocus='Marca(".($i+2).");' onBlur='Marca(".($i+2).");'></td>\n";
	echo "</tr>\n";

?>		</table></td>
		</tr>
        </table> 
      </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
