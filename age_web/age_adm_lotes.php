<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=12;
	include("../principal/conectar_principal.php");
	if (isset($TxtLote))
	{
		$EstadoInput = "";
		$Consulta = "select * ";
		$Consulta.= " from age_web.lotes t1 left join age_web.detalle_lotes t2 ";
		$Consulta.= " on t1.lote = t2.lote";
		$Consulta.= " where t1.lote = '".$TxtLote."'";
		//echo "ppp".$Consulta;
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$TxtLote = $Fila["lote"];
			$CmbSubProducto = $Fila["cod_subproducto"];
			$CmbProveedor = $Fila["rut_proveedor"];
			$CmbCodFaena = $Fila["cod_faena"];
			$CmbCodRecepcion = $Fila["cod_recepcion"];
			$CmbCodRecepcionENM = $Fila["cod_recepcion_enm"];
			$CmbClaseProducto = $Fila["clase_producto"];
			$TxtConjunto = $Fila["num_conjunto"];
			$TxtMuestraParalela = $Fila["muestra_paralela"];
			$TxtLoteRemuestreo = $Fila["num_lote_remuestreo"];
			$CmbEstadoLote = $Fila["estado_lote"];
			$CmbEstadoRecargo = $Fila["estado_recargo"];
			$ModifLote = $Fila["modificado"];
			//DATOS DEL DETALLE			
			$TxtRecargo = $Fila["recargo"];
			$TxtFolio = $Fila["folio"];
			$TxtCorrelativo = $Fila["corr"];
			if ($Fila["recargo"]==1)
				$TxtFechaRecep = $Fila["fecha_recepcion"];
			$ChkFinLote = $Fila["fin_lote"];
			$TxtPesoBruto = $Fila["peso_bruto"];
			$TxtPesoTara = $Fila["peso_tara"];
			$TxtPesoNeto = $Fila["peso_neto"];
			$TxtGuia = $Fila["guia_despacho"];
			$TxtPatente = $Fila["patente"];
			$ChkAutorizado = $Fila["autorizado"];
			$TotalPesoBruto = $TotalPesoBruto + $Fila["peso_bruto"];
			$TotalPesoTara = $TotalPesoTara + $Fila["peso_tara"];
			$TotalPesoNeto = $TotalPesoNeto + $Fila["peso_neto"];
		}
	}
?>
<html>
<head>
<title>AGE-Adm. Lotes</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
function Recarga3()
{
	var Frm=document.frmPrincipal;
	Frm.action="age_adm_lotes.php?TipoBusq=3";
	Frm.submit();	
}
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "ML":
			if (f.TxtLote.value==""){
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;}			
			if (f.CmbSubProducto.value=="S"){
				alert("Debe Seleccinar SubProducto");
				f.CmbSubProducto.focus();
				return;}			
			if (f.CmbProveedor.value=="S"){
				alert("Debe Seleccionar Proveedor");
				f.CmbProveedor.focus();
				return;}			
			if (f.CmbEstadoLote.value=="S"){
				alert("Debe Seleccinar Estado del Lote");
				f.CmbEstadoLote.focus();
				return;}
			/*if (f.TxtConjunto.value==""){
				alert("Debe Ingresar Num. Conjunto");
				f.TxtConjunto.focus();
				return;}*/
			if (f.CmbClaseProducto.value=="S"){
				alert("Debe Seleccionar Clase de Producto");
				f.CmbClaseProducto.focus();
				return;}
			if (f.CmbCodRecepcion.value=="S"){
				alert("Debe Tipo de Recepcion");
				f.CmbCodRecepcion.focus();
				return;}															
			f.action = "age_adm_lotes01.php?Proceso=ML";
			f.submit();
			break;
		case "I":			
			if (f.TxtLote.value==""){
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;}
			window.open("age_adm_lotes_imp_web.php?TxtLote="+f.TxtLote.value,"","top=30,left=30,width=700,heiht=500,scrollbars=yes,resizable=yes");
			break;
		case "NR":		//NUEVO RECARGO	
			if (f.TxtLote.value==""){
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;}
			window.open("age_adm_lotes_recargos.php?Proc=N&NewRec=S&TxtLote="+f.TxtLote.value,"","top=30,left=30,width=800,height=350,scrollbars=yes,resizable=yes");
			break;
		case "MR":			//MODIFICA RECARGO
			if (f.TxtLote.value==""){
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;}
			var TxtRecargo = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkRecargo" &&f.elements[i].checked==true)
				{
					TxtRecargo = f.elements[i].value;
					break;
				}
			}
			if (TxtRecargo == "")
			{
				alert("No hay Nada Seleccionado");
				return;
			}
			window.open("age_adm_lotes_recargos.php?Proc=M&NewRec=N&TxtLote="+f.TxtLote.value+"&TxtRecargo="+TxtRecargo,"","top=30,left=30,width=800,height=350,scrollbars=yes,resizable=yes");
			break;
		case "E":	
			if (f.TxtLote.value==""){
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;}
			f.action = "age_adm_lotes_imp_excel.php?TxtLote="+f.TxtLote.value;
			f.submit();	
			break;		
		case "R": //RECARGA					
			f.action = "age_adm_lotes.php";
			f.submit();
			break
		case "S":
			frmPrincipal.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=10";
			frmPrincipal.submit();
			break;			
		case "MT": //MARCA TODO
			var ValorChk = false;
			if (f.ChkMarcaTodo.checked)
				ValorChk = true;
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkRecargo")
				{
					f.elements[i].checked=ValorChk;
					CCA(f.elements[i],'CL03');
				}
			}
			break;
		case "O": //ORDENA
			f.action = "age_adm_recepcion.php?LimitIni=<?php echo $LimitIni; ?>&TipoCon=<?php echo $TipoCon; ?>&Orden=" + valor;
			f.submit();
			break;
		case "OM": //OPERACIONES MASIVAS
			var TxtLotes = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkRecargo" &&f.elements[i].checked==true)
				{
					TxtLotes = TxtLotes + f.TxtLote.value + "-" + f.elements[i].value + "//";
				}
			}
			if (TxtLotes == "")
			{
				alert("No hay Nada Seleccionado");
				return;
			}
			TxtLotes = TxtLotes.substring(0,(TxtLotes.length-2));
			window.open("age_adm_recepcion03.php?Pag=Lotes&Proc=OM&TxtValores="+TxtLotes,"","top=100,left=50,width=550,height=300,scrollbars=yes,resizable=yes");
			break;
		case "ER": //ELIMINA RECARGO
			var TxtLotes = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkRecargo" &&f.elements[i].checked==true)
				{
					TxtLotes = TxtLotes + f.TxtLote.value + "-" + f.elements[i].value + "//";
				}
			}
			if (TxtLotes == "")
			{
				alert("No hay Nada Seleccionado para Eliminar");
				return;
			}
			else
			{
				var msg=confirm("�Seguro que desea Eliminar estos Recargos?");
				if (msg==true)
				{
					TxtLotes = TxtLotes.substring(0,(TxtLotes.length-2));
					f.action = "age_adm_lotes01.php?Proceso=ER&TxtValores="+TxtLotes;
					f.submit();
				}
				else
				{
					return;
				}
			}
			break;
		case "L":
			if (f.TxtLote.value==""){
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;}
			window.open("age_adm_lotes_leyes.php?TxtLote="+f.TxtLote.value,"","top=10,left=70,width=550,height=500,scrollbars=yes,resizable=yes");
			break;
	}
}
</script>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #FFFFFF;
}
a:visited {
	color: #FFFFFF;
}
a:hover {
	color: #FFFFFF;
}
a:active {
	color: #FFFF00;
}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body onLoad="window.document.frmPrincipal.TxtLote.focus();">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="NewRec" value="<?php echo $NewRec; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<?php include("../principal/encabezado.php") ?>
<table class="TablaPrincipal" width="770">
	<tr>
	  <td width="780" height="340" align="center" valign="top"><br>
<table width="780"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02">
    <td colspan="6"><strong>DATOS DEL LOTE </strong></td>
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
    	echo "<td colspan='6' class='Colum01' align='center'><font class='".$Clase."'>".$Mensaje."</font></td>\n";
    	echo "</tr>\n";
	}
?>
  <tr class="Colum01">
    <td width="68" class="Colum01">Lote:</td>
    <td colspan="3" class="Colum01"><input <?php echo $EstadoInput; ?> name="TxtLote" type="text" class="InputCen" id="TxtLote" value="<?php echo $TxtLote; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');">
      <input name="BtnOK" type="button" id="BtnOK" value="OK" onClick="Proceso('R')"  onFocus="Proceso('R')"></td>
    <td width="94" align="right" class="Colum01">Num.Conjunto:</td>
    <td width="154" class="Colum01"><input name="TxtConjunto" type="text" class="InputDer" id="TxtConjunto2" value="<?php echo $TxtConjunto; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbClaseProducto');"></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">SubProducto:</td>
    <td colspan="3" class="Colum01"><select name="CmbSubProducto" style="width:280px " class="Select01" id="CmbSubProducto" onKeyDown="TeclaPulsada2('N',true,this.form,'CmbProveedor');">
	<option value="S" class="NoSelec">SELECCIONAR</option>
<?php
	$Consulta = "select cod_subproducto, descripcion, abreviatura, LPAD(cod_subproducto,2,'0') as orden ";
	$Consulta.= " from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='1' order by orden";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($CmbSubProducto == $Fila["cod_subproducto"])
			echo  "<option selected value='".$Fila["cod_subproducto"]."'>".$Fila["orden"]." - ".$Fila["descripcion"]."</option>\n";
		else
			echo  "<option value='".$Fila["cod_subproducto"]."'>".$Fila["orden"]." - ".$Fila["descripcion"]."</option>\n";
	}
?>	
    </select>      </td>
    <td align="right" class="Colum01">Clase Producto:</td>
    <td class="Colum01"><select name="CmbClaseProducto" style="width: 150px" class="Select01" onkeydown="TeclaPulsada2('N',true,this.form,'CmbCodRecepcion');">
      <option value="S" class="NoSelec">SELECCIONAR</option>
      <?php
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15001' order by nombre_subclase";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["nombre_subclase"]==$CmbClaseProducto)
			echo "<option selected value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";
		else
			echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";
	}
?>
    </select></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Proveedor: </td>
    <td colspan="3" class="Colum01"><select name="CmbProveedor" style="width:280px " class="Select01" onKeyDown="TeclaPulsada2('N',true,this.form,'CmbCodFaena');">
	<option value="S" class="NoSelec">SELECCIONAR</option>
<?php
	$Consulta = "select * ";
	$Consulta.= " from sipa_web.proveedores ";
	if($TipoBusq=='3'&&$TxtFiltroPrv!='')
	   $Consulta.= " where nombre_prv like '%".$TxtFiltroPrv."%'";  	
	$Consulta.= " order by TRIM(nombre_prv) ";
	
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{		
		if ($CmbProveedor == $Fila["rut_prv"])
			echo  "<option selected value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre_prv"]."</option>\n";
		else
			echo  "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre_prv"]."</option>\n";
	}
?>	
    </select>
      Filtro
      <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
      <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()"></td>
    <td align="right" class="Colum01">Cod.Recepcion:</td>
    <td class="Colum01"><select name="CmbCodRecepcion" style="width: 150px" class="Select01" onkeydown="TeclaPulsada2('N',true,this.form,'TxtMuestraParalela');">
      <option value="S" class="NoSelec">SELECCIONAR</option>
      <?php
	
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='3104' ";
	$Consulta.= " order by cod_subclase ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($CmbCodRecepcion==$Fila["nombre_subclase"])
			echo "<option selected value='".$Fila["nombre_subclase"]."'>".strtoupper($Fila["nombre_subclase"])."</option>\n";
		else
			echo "<option value='".$Fila["nombre_subclase"]."'>".strtoupper($Fila["nombre_subclase"])."</option>\n";
	}
?>
    </select></td>
  </tr>
  <tr class="Colum01">
    <td height="26" class="Colum01">Cod Faena: </td>
    <td colspan="3" class="Colum01"><select name="CmbCodFaena" style="width:280px " class="Select01" onKeyDown="TeclaPulsada2('N',true,this.form,'CmbEstadoLote');">
	<option value="S" class="NoSelec">SELECCIONAR</option>
<?php
	$Consulta = "select distinct cod_mina, nombre_mina from sipa_web.minaprv order by nombre_mina ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($CmbCodFaena == $Fila["cod_mina"])
			echo "<option selected value='".$Fila["cod_mina"]."'>".$Fila["cod_mina"]." - ".$Fila["nombre_mina"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_mina"]."'>".$Fila["cod_mina"]." - ".$Fila["nombre_mina"]."</option>\n";
	}
?>	
    </select></td>
    <td align="right" class="Colum01">Cod.Recep.ENM:</td>
    <td class="Colum01"><select name="CmbCodRecepcionENM" style="width: 150px" class="Select01" id="CmbCodRecepcionENM" onkeydown="TeclaPulsada2('N',true,this.form,'TxtMuestraParalela');">
      <option value="S" class="NoSelec">SELECCIONAR</option>
      <?php
	$Consulta = "select COD_C, DESC_A from rec_web.tipos  where indica='R' order by DESC_A ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["COD_C"]==$CmbCodRecepcionENM)
			echo "<option selected value='".$Fila["COD_C"]."'>".$Fila["DESC_A"]."</option>\n";
		else
			echo "<option value='".$Fila["COD_C"]."'>".$Fila["DESC_A"]."</option>\n";
	}
?>
    </select></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Estado Lote:</td>
    <td width="238" class="Colum01"><select name="CmbEstadoLote" class="Select01" id="select2"  onkeydown="TeclaPulsada2('N',true,this.form,'TxtConjunto');">
      <option value="S" class="NoSelec">SELECCIONAR</option>
      <?php
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15003' order by cod_subclase";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["cod_subclase"]==$CmbEstadoLote)
			echo "<option selected value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
	}
?>
    </select></td>
    <td width="82" class="Colum01">Lote Remues.:</td>
    <td width="75" class="Colum01"><input name="TxtLoteRemuestreo" type="text" class="InputDer" id="TxtLoteRemuestreo4" value="<?php echo $TxtLoteRemuestreo; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'');"></td>
    <td align="right" class="Colum01">Muestra Paralela :</td>
    <td class="Colum01"><input name="TxtMuestraParalela" type="text" class="InputDer" id="TxtMuestraParalela2" value="<?php echo $TxtMuestraParalela; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtLoteRemuestreo');"></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td colspan="3" class="Colum01">Operaciones Comunes </td>
    <td colspan="3" class="Colum01">Operaciones de Recargo </td>
  </tr>
  <tr align="center" class="Colum01">
    <td height="30" colspan="3" class="Colum01"><input name="BtnModificar" type="button" id="BtnModificar3" value="Modif. Lote" style="width:70px " onClick="Proceso('ML')">
      <input name="BtnImprimir" type="button" id="BtnImprimir2" value="Imprimir" style="width:60px " onClick="Proceso('I')">
      <input name="BtnExcel" type="button" id="BtnExcel2" value="Excel" style="width:60px " onClick="Proceso('E')">
      <!--<input name="BtnLeyes" type="button" id="BtnLeyes2" value="Leyes" style="width:60px " onClick="Proceso('L')">-->
      <input name="BtnSalir" type="button" id="BtnSalir3" value="Salir" style="width:60px " onClick="Proceso('S')">            </td>
    <td height="30" colspan="3" class="Colum01"><input name="BtnOpemasiva" type="button" id="BtnOpemasiva2" style="width890px " onClick="Proceso('OM')" value="Ope. Masiva">
      <input name="BtnNuevoRec" type="button" id="BtnNuevoRec3" value="Nuevo" style="width:60px " onClick="Proceso('NR')">
      <input name="BtnModificaRec" type="button" id="BtnModificaRec2" value="Modifica" style="width:60px " onClick="Proceso('MR')">
      <input name="BtnModificaRec2" type="button" id="BtnModificaRec" value="Elimina" style="width:60px " onClick="Proceso('ER')"></td>
    </tr>
</table>
<br>
<table width="780"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td width="4%"><input type="checkbox" name="ChkMarcaTodo" value="" onClick="Proceso('MT')"></td>
    <td width="4%">Rec.</td>
    <td width="4%">Ult.</td>
    <td width="5%">Folio</td>
    <td width="7%">Corr.</td>
    <td width="7%">Fecha.</td>
    <td width="8%">H.Ent</td>
    <td width="7%">H.Sal</td>
    <td width="10%">P.Bruto</td>
    <td width="8%">P.Tara</td>
    <td width="9%">P.Neto</td>
    <td width="9%">Guia</td>
    <td width="10%">Patente</td>
    <td width="4%">Est.</td>
    <td width="4%">Aut.</td>
  </tr>
  <?php	
if (isset($TxtLote) && $TxtLote!="")	
{
	$Consulta = "select t2.fecha_recepcion, t2.hora_entrada, t2.hora_salida, t2.folio, t2.corr, t2.lote, t2.recargo, t2.fin_lote, ";
	$Consulta.= " t1.cod_subproducto, t2.peso_bruto, t2.peso_tara, t2.peso_neto, t2.guia_despacho, ";
	$Consulta.= " t2.guia_despacho, t2.patente, t1.rut_proveedor, LPAD(t2.recargo,2,'0') as orden, ";
	$Consulta.= " t3.valor_subclase1 as est_rec, t2.autorizado ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote=t2.lote ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='15003' and t2.estado_recargo=t3.cod_subclase ";				
	$Consulta.= " where t1.lote = '".$TxtLote."' order by t2.lote, orden, t2.fecha_recepcion ";
	$Resp = mysqli_query($link, $Consulta);	
	$TotPesoBr = 0;
	$TotPesoTr = 0;
	$TotPesoNt = 0;
	$ContReg = 0;
	while ($Fila = mysqli_fetch_array($Resp))
	{		
		echo "<tr >\n";
		echo "<td align='center'><input type='checkbox' name='ChkRecargo' value='".$Fila["recargo"]."' onClick=\"CCA(this,'CL03')\">";
		echo "</td>\n";
		echo "<td align='center'>".$Fila["recargo"]."</td>\n";
		if ($Fila["fin_lote"]!="" && !is_null($Fila["fin_lote"]))
			echo "<td align='center'>".$Fila["fin_lote"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "<td align='center'>".$Fila["folio"]."</td>\n";		
		echo "<td align='center'>".$Fila["corr"]."</td>\n";		
		echo "<td align='center'>".substr($Fila["fecha_recepcion"],8,2)."/".substr($Fila["fecha_recepcion"],5,2)."</td>\n";		
		echo "<td align='right'>".substr($Fila["hora_entrada"],0,5)."</td>\n";
		echo "<td align='right'>".substr($Fila["hora_salida"],0,5)."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_bruto"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_tara"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_neto"],0,",",".")."</td>\n";
		if ($Fila["guia_despacho"]!="" && !is_null($Fila["guia_despacho"]))
			echo "<td align='center'>".$Fila["guia_despacho"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		if ($Fila["patente"]!="" && !is_null($Fila["patente"]))
			echo "<td align='center'>".$Fila["patente"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";		
		echo "<td align='center'>".strtoupper($Fila["est_rec"])."</td>\n";
		echo "<td align='center'>".strtoupper($Fila["autorizado"])."</td>\n";
		echo "</tr>\n";
		$TotPesoBr = $TotPesoBr + $Fila["peso_bruto"];
		$TotPesoTr = $TotPesoTr + $Fila["peso_tara"];
		$TotPesoNt = $TotPesoNt + $Fila["peso_neto"];
		$ContReg++;
	}
}	
?>
  <tr class="ColorTabla02">
    <td colspan="5"><strong>Total Lote: </strong></td>
    <td colspan="3"><strong><?php echo number_format($ContReg,0,",",".");?> Rec.</strong></td>
    <td align="right"><?php echo number_format($TotPesoBr,0,",",".");?></td>
    <td align="right"><?php echo number_format($TotPesoTr,0,",",".");?></td>
    <td align="right"><?php echo number_format($TotPesoNt,0,",",".");?></td>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>
      </td>
	</tr>
</table>
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
