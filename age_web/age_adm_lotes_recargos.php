<?php
	include("../principal/conectar_principal.php"); 
	$Proc        = isset($_REQUEST['Proc']) ? $_REQUEST['Proc'] : '';
	$EstOpe      = isset($_REQUEST['EstOpe']) ? $_REQUEST['EstOpe'] : '';
	$TxtLote     = isset($_REQUEST['TxtLote']) ? $_REQUEST['TxtLote'] : '';
	$NewRec      = isset($_REQUEST['NewRec']) ? $_REQUEST['NewRec'] : '';
	$EstadoInput = isset($_REQUEST['EstadoInput']) ? $_REQUEST['EstadoInput'] : '';
	$TxtRecargo  = isset($_REQUEST['TxtRecargo']) ? $_REQUEST['TxtRecargo'] : '';
	$TipoConsulta = isset($_REQUEST['TipoConsulta']) ? $_REQUEST['TipoConsulta'] : '';
	$CmbHoraEnt   = isset($_REQUEST['CmbHoraEnt']) ? $_REQUEST['CmbHoraEnt'] : '';
	$CmbMinEnt    = isset($_REQUEST['CmbMinEnt']) ? $_REQUEST['CmbMinEnt'] : '';
	$CmbMinSal    = isset($_REQUEST['CmbMinSal']) ? $_REQUEST['CmbMinSal'] : '';
	$CmbHoraSal   = isset($_REQUEST['CmbHoraSal']) ? $_REQUEST['CmbHoraSal'] : '';
	$CmbEstadoRecargo = isset($_REQUEST['CmbEstadoRecargo']) ? $_REQUEST['CmbEstadoRecargo'] : '';
	
	$ChkAutorizado  = isset($_REQUEST['ChkAutorizado']) ? $_REQUEST['ChkAutorizado'] : '';
    $ChkFinLote	    = isset($_REQUEST['ChkFinLote']) ? $_REQUEST['ChkFinLote'] : '';
	$Mensaje        = isset($_REQUEST['Mensaje']) ? $_REQUEST['Mensaje'] : '';
	$TxtFechaRecep  = isset($_REQUEST['TxtFechaRecep']) ? $_REQUEST['TxtFechaRecep'] : '';
	$TxtFolio       = isset($_REQUEST['TxtFolio']) ? $_REQUEST['TxtFolio'] : '';
	$TxtCorrelativo = isset($_REQUEST['TxtCorrelativo']) ? $_REQUEST['TxtCorrelativo'] : '';
	$TxtGuia        = isset($_REQUEST['TxtGuia']) ? $_REQUEST['TxtGuia'] : '';
	$TxtPatente     = isset($_REQUEST['TxtPatente']) ? $_REQUEST['TxtPatente'] : '';
	$TxtPesoBruto   = isset($_REQUEST['TxtPesoBruto']) ? $_REQUEST['TxtPesoBruto'] : '';
	$TxtPesoTara    = isset($_REQUEST['TxtPesoTara']) ? $_REQUEST['TxtPesoTara'] : '';
	$TxtPesoNeto    = isset($_REQUEST['TxtPesoNeto']) ? $_REQUEST['TxtPesoNeto'] : '';
	
	if ($Proc == "M")
	{
		$EstadoInput = "readonly";
		$Consulta = "select * ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 ";
		$Consulta.= " on t1.lote = t2.lote";
		$Consulta.= " where t1.lote = '".$TxtLote."'";
		$Consulta.= " and t2.recargo = '".$TxtRecargo."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$TxtLote = $Fila["lote"];			
			$CmbEstadoRecargo = $Fila["estado_recargo"];
			$CmbHoraEnt = intval(substr($Fila["hora_entrada"],0,2));
			$CmbMinEnt = intval(substr($Fila["hora_entrada"],3,2));
			$CmbHoraSal = intval(substr($Fila["hora_salida"],0,2));
			$CmbMinSal = intval(substr($Fila["hora_salida"],3,2));
			//DATOS DEL DETALLE
			$TxtRecargo = $Fila["recargo"];
			$TxtFolio = $Fila["folio"];
			$TxtCorrelativo = $Fila["corr"];
			$TxtFechaRecep = $Fila["fecha_recepcion"];
			$ChkFinLote = $Fila["fin_lote"];
			$TxtPesoBruto = $Fila["peso_bruto"];
			$TxtPesoTara = $Fila["peso_tara"];
			$TxtPesoNeto = $Fila["peso_neto"];
			$TxtGuia = $Fila["guia_despacho"];
			$TxtPatente = $Fila["patente"];
			$ChkAutorizado = $Fila["autorizado"];
		}
	}
	else
	{
		if ($Proc=="N")//NUEVO RECARGO
		{
			$Consulta = "select ifnull(max(recargo*1),0) as ult_recargo from age_web.detalle_lotes ";
			$Consulta.= " where lote='".$TxtLote."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
				$TxtRecargo = $Fila2["ult_recargo"] + 1;
			else
				$TxtRecargo = 1;
			$TxtFolio = "";
			$TxtCorrelativo = "";
			$TxtFechaRecep = date("Y-m-d");
			$ChkFinLote = "N";
			$TxtPesoBruto = 0;
			$TxtPesoTara = 0;
			$TxtPesoNeto = 0;
			$TxtGuia = "";
			$TxtPatente = "";
			$ChkAutorizado = "N";
		}
	}
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "G":
			if (f.TxtLote.value==""){
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;}			
			if (f.TxtRecargo.value=="" || f.TxtRecargo.value=="0"){
				alert("Debe Ingresar Num. de Recargo");
				f.TxtRecargo.focus();
				return;}
			if (f.TxtFolio.value==""){
				alert("Debe Ingresar Num. de Folio");
				f.TxtFolio.focus();
				return;}
			if (f.TxtCorrelativo.value==""){
				alert("Debe Ingresar Correlativo");
				f.TxtCorrelativo.focus();
				return;}
			if (f.TxtFechaRecep.value==""){
				alert("Debe Ingresar Fecha de Recepcion");
				f.TxtFechaRecep.focus();
				return;}
			if (f.TxtGuia.value==""){
				alert("Debe Ingresar Num. de Guia de Despacho");
				f.TxtGuia.focus();
				return;}
			if (f.TxtPesoBruto.value==""){
				alert("Debe Ingresar Peso Bruto");
				f.TxtPesoBruto.focus();
				return;}
			if (f.TxtPesoTara.value==""){
				alert("Debe Ingresar Peso Tara");
				f.TxtPesoTara.focus();
				return;}
			if (f.TxtPesoNeto.value==""){
				alert("Debe Ingresar Peso Neto");
				f.TxtPesoNeto.focus();
				return;}
			if (f.TxtPatente.value==""){
				alert("Debe Ingresar Patente del Camion");
				f.TxtPatente.focus();
				return;}
			else{
				f.TxtPatente.value=f.TxtPatente.value.toUpperCase();
			}
			if (f.CmbEstadoRecargo.value=="S"){
				alert("Debe Seleccinar Estado del Recargo");
				f.CmbEstadoRecargo.focus();
				return;}
			if (f.NewRec.value=="S") 
				f.action = "age_adm_lotes01.php?Proceso=NR";
			else
				f.action = "age_adm_lotes01.php?Proceso=MR";
			f.submit();
			break;
		case "I":
			f.BtnGuardar.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnGuardar.style.visibility = "visible";
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;		
		case "R": //RECARGA		
			if (f.CmbRecargo.value!="S")
			{
				f.TxtRecargo.value = f.CmbRecargo.value;
				f.action = "age_adm_lotes_recargos.php";
				f.submit();
			}
			break
		case "S":
			window.opener.document.frmPrincipal.action = "age_adm_lotes.php";
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
	}
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmProceso" method="post" action="">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="NewRec" value="<?php echo $NewRec; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td width="473" colspan="4"><strong>OPERACION:
	<?php
	switch ($Proc)
	{
		case "M":
			echo "Modificando Lote-Recargo";
			break;
		case "N":
			echo "Insertando Nuevo Lote-Recargo";
			break;
		default:
			echo "Operacion. No Identificada";
		}
	?></strong></td>
  </tr>
  <tr class="ColorTabla02">
    <td colspan="4"><strong> LOTE: <?php echo $TxtLote; ?>
      <input name="TxtLote" type="hidden" value="<?php echo $TxtLote; ?>">
    </strong></td>
  </tr>
<?php
	if ($EstOpe != "")
	{  
		switch ($EstOpe)
		{
			case "S":
				$Clase="ErrorSI";
				break;
			case "N":
				$Clase="ErrorNO";
				break;
		}
		echo "<tr class='ColorTabla02'>\n";
    	echo "<td colspan='4' class='Colum01' align='center'><font class='".$Clase."'>".$Mensaje."</font></td>\n";
    	echo "</tr>\n";
	}
?>
</table>
<br>
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02">
    <td colspan="5"><strong>
<?php
	if ($NewRec == "S")
		echo "<font style='color=#FF0000'>INGRESAR DATOS DEL NUEVO RECARGO</font>";
	else
		echo "DATOS DEL RECARGO";
?>	 </strong></td>
  </tr>
  <tr>
    <td width="97" class="Colum01">Num.Recargo:</td>
    <td width="74" class="Colum01"><input <?php if ($NewRec!="S"){echo $EstadoInput;} ?> name="TxtRecargo" type="text" class="InputDer" id="TxtRecargo" value="<?php echo $TxtRecargo; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtFechaRecep');"></td>
    <td width="80" class="Colum01"><select name="CmbRecargo" onChange="Proceso('R')">
      <option value="S">Recargos</option>
      <?php
	$Consulta = "select recargo, LPAD(recargo,2,'0') as orden from age_web.detalle_lotes ";
	$Consulta.= " where lote='".$TxtLote."' order by orden";
	$Resp= mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["recargo"]==$TxtRecargo)
			echo "<option selected value='".$Fila["recargo"]."'>".$Fila["orden"]."</option>\n";
		else
			echo "<option value='".$Fila["recargo"]."'>".$Fila["orden"]."</option>\n";
	}
	
?>
    </select></td>
    <td width="103" align="right" class="Colum01">Fin Lote:</td>
    <td width="113" class="Colum01">
      <?php
	switch ($ChkFinLote)
	{
		case "S":
			echo "<input checked name='ChkFinLote' type='radio' value='S'>Si&nbsp;\n";
			echo "<input name='ChkFinLote' type='radio' value='N'>No</td>\n";
			break;
		default:
			echo "<input name='ChkFinLote' type='radio' value='S'>Si&nbsp;\n";
			echo "<input checked name='ChkFinLote' type='radio' value='N'>No</td>\n";
			break;
	}
?>  
  </tr>
  <tr>
    <td class="Colum01">Fecha Recep:</td>
    <td colspan="2" class="Colum01">      <input name="TxtFechaRecep" type="text" class="InputCen" id="TxtFechaRecep2" value="<?php echo $TxtFechaRecep; ?>" size="15" maxlength="10" readonly onKeyDown="TeclaPulsada2('S',false,this.form,'CmbHoraEnt');">
      <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaRecep,TxtFechaRecep,popCal);return false"></td>
    <td align="right" class="Colum01">Patente:</td>
    <td class="Colum01"><input name="TxtPatente" type="text" class="InputCen" id="TxtPatente" value="<?php echo $TxtPatente; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbHoraSal');"></td>
  </tr>
  <tr>
    <td class="Colum01">Hora Entrada: </td>
    <td colspan="2" class="Colum01"><select name="CmbHoraEnt" onkeydown="TeclaPulsada2('N',false,this.form,'CmbMinEnt');">
<?php
	for ($i=0;$i<=24;$i++)
	{
		if ($CmbHoraEnt==$i)
			echo "<option selected value='".$i."'>".$i."</option>\n";
		else
			echo "<option value='".$i."'>".$i."</option>\n";
	}
?>	
    </select>
      <select name="CmbMinEnt" onkeydown="TeclaPulsada2('N',false,this.form,'TxtFolio');">
<?php	  
	for ($i=0;$i<=59;$i++)
	{
		if ($CmbMinEnt==$i)
			echo "<option selected value='".$i."'>".$i."</option>\n";
		else
			echo "<option value='".$i."'>".$i."</option>\n";
	}	
?>	  
      </select></td>
    <td align="right" class="Colum01">Hora Salida:</td>
    <td class="Colum01"><select name="CmbHoraSal" onkeydown="TeclaPulsada2('N',false,this.form,'CmbMinSal');">
      <?php
	for ($i=0;$i<=24;$i++)
	{
		if ($CmbHoraSal==$i)
			echo "<option selected value='".$i."'>".$i."</option>\n";
		else
			echo "<option value='".$i."'>".$i."</option>\n";
	}
?>
            </select>
      <select name="CmbMinSal" onkeydown="TeclaPulsada2('N',false,this.form,'TxtPesoBruto');">
        <?php	  
	for ($i=0;$i<=59;$i++)
	{
		if ($CmbMinSal==$i)
			echo "<option selected value='".$i."'>".$i."</option>\n";
		else
			echo "<option value='".$i."'>".$i."</option>\n";
	}	
?>
                  </select></td>
  </tr>
  <tr>
    <td class="Colum01">Folio:</td>
    <td colspan="2" class="Colum01"><input name="TxtFolio" type="text" class="InputDer" id="TxtFolio2" value="<?php echo $TxtFolio; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtCorrelativo');"></td>
    <td align="right" class="Colum01">Peso Bruto:</td>
    <td class="Colum01"><input name="TxtPesoBruto" type="text" id="TxtPesoBruto3" value="<?php echo $TxtPesoBruto;?>" size="10" maxlength="10" class="InputDer" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtPesoTara');"></td>
  </tr>
  <tr>
    <td class="Colum01">Correlativo: </td>
    <td colspan="2" class="Colum01"><input name="TxtCorrelativo" type="text" class="InputDer" id="TxtCorrelativo2" value="<?php echo $TxtCorrelativo; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtGuia');"></td>
    <td align="right" class="Colum01">Peso Tara:</td>
    <td class="Colum01"><input name="TxtPesoTara" type="text" class="InputDer" id="TxtPesoTara2" value="<?php echo $TxtPesoTara; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtPesoNeto');"></td>
  </tr>
  <tr>
    <td class="Colum01">Guia Despacho:</td>
    <td colspan="2" class="Colum01">      <input name="TxtGuia" type="text" class="InputCen" id="TxtGuia2" value="<?php echo $TxtGuia; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtPatente');"></td>
    <td align="right" class="Colum01">Peso Neto:</td>
    <td class="Colum01"><input name="TxtPesoNeto" type="text" class="InputDer" id="TxtPesoNeto2" value="<?php echo $TxtPesoNeto;?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbEstadoRecargo');"></td>
  </tr>
  <tr>
    <td class="Colum01">Autorizado:</td>
    <td colspan="2" class="Colum01"><?php
	switch ($ChkAutorizado)
	{
		case "S":
			echo "<input checked name='ChkAutorizado' type='radio' value='S'>Si&nbsp;\n";
			echo "<input name='ChkAutorizado' type='radio' value='N'>No</td>\n";
			break;
		default:
			echo "<input name='ChkAutorizado' type='radio' value='S'>Si&nbsp;\n";
			echo "<input checked name='ChkAutorizado' type='radio' value='N'>No</td>\n";
			break;
	}
?></td>
    <td align="right" class="Colum01">Estado de Recargo:</td>
    <td class="Colum01"><select name="CmbEstadoRecargo" class="Select01" id="CmbEstadoRecargo"  onkeydown="TeclaPulsada2('N',true,this.form,'');">
      <option value="S" class="NoSelec">SELECCIONAR</option>
      <?php
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15003' order by cod_subclase";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["cod_subclase"]==$CmbEstadoRecargo)
			echo "<option selected value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
	}
?>
    </select></td>
  </tr>
  <tr align="center" valign="middle">
    <td height="30" colspan="5" class="Colum01"><input name="BtnGuardar" type="button" id="BtnGuardar" value="Guardar" style="width:70px " onClick="Proceso('G')"> 
      <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
</table>
</form>
</body>
</html>
