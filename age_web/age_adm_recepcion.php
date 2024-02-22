<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=11;
	include("../principal/conectar_principal.php");
	if (!isset($TxtFechaIni))
		$TxtFechaIni = date("Y-m-d");
	if (!isset($TxtFechaFin))
		$TxtFechaFin = date("Y-m-d");
	if (!isset($LimitIni))
		$LimitIni=0;
	if (!isset($LimitFin))
		$LimitFin=999;	
	if (!isset($CmbAutorizado))
		$CmbAutorizado="T";
	$ArrLeyes = array();
	$Consulta = "select * from proyecto_modernizacion.leyes ";
	$RespLeyes = mysqli_query($link, $Consulta);	
	while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
	{
		$ArrLeyes[$FilaLeyes["cod_leyes"]][0] = $FilaLeyes["cod_leyes"];
		$ArrLeyes[$FilaLeyes["cod_leyes"]][1] = $FilaLeyes["abreviatura"];
	}
?>
<html>
<head>
<title>AGE-Adm.Recepcion</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document.Txt" + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			//eval("Txt" + numero + ".style.left = 50 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}

function Proceso(opt,valor)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "BOL":
			var TxtLotes = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLote" &&f.elements[i].checked==true)
				{
					TxtLotes = TxtLotes + f.elements[i].value + "-" + f.elements[i + 1].value + "//";
				}
			}
			if (TxtLotes == "")
			{
				alert("No hay Nada Seleccionado");
				return;
			}
			TxtLotes = TxtLotes.substring(0,(TxtLotes.length-2));
			window.open("age_adm_recepcion_boleta.php?Valores="+TxtLotes,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
			break;
		case "XLS":
			f.action = "age_adm_recepcion_excel.php?TipoCon=<?php echo $TipoCon; ?>&Orden=<?php echo $Orden; ?>";
			f.submit();
			break;
		case "OM": //OPERACIONES MASIVAS
			var TxtLotes = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLote" &&f.elements[i].checked==true)//&&parseInt(f.elements[i + 2].value)!=0
				{
					TxtLotes = TxtLotes + f.elements[i].value + "-" + f.elements[i + 1].value + "//";
				}
			}
			if (TxtLotes == "")
			{
				alert("No hay Nada Seleccionado");
				return;
			}
			TxtLotes = TxtLotes.substring(0,(TxtLotes.length-2));
			window.open("age_adm_recepcion03.php?TipoConsulta=<?php echo $TipoCon; ?>&Proc=OM&TxtValores="+TxtLotes,"","top=100,left=50,width=650,height=300,scrollbars=yes,resizable=yes");
			break;
		case "NL":
			window.open("age_adm_recepcion02.php?TipoConsulta=<?php echo $TipoCon; ?>&Proc=N","","top=10,left=30,width=850,height=480,scrollbars=yes,resizable=yes");
			break;
		case "CF":
			f.TxtLoteIni.value = "";
			f.TxtLoteFin.value = "";
			f.action = "age_adm_recepcion.php?TipoCon=CF";
			f.submit();
			break;
		case "CL"://BUSQUEDA POR LOTE
			if (f.TxtLoteIni.value=="")
			{
				alert("Debe Ingresar Lote Inicial");
				f.TxtLoteIni.focus();
				return;
			}
			if (f.TxtLoteFin.value=="" && f.TxtLoteIni.value!="")
			{
				f.TxtLoteFin.value = f.TxtLoteIni.value;
			}
			f.CmbSubProducto.value="S";
			f.action = "age_adm_recepcion.php?TipoCon=CL&Orden=L";
			f.submit();
			break;
		case "M":
			var TxtLote = "";
			var TXtRecargo = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLote" &&f.elements[i].checked==true)
				{
					TxtLote = f.elements[i].value;
					TxtRecargo = f.elements[i + 1].value;
				}
			}
			if (TxtLote == "")
			{
				alert("No hay Nada Seleccionado");
				return;
			}
			window.open("age_adm_recepcion02.php?TipoConsulta=<?php echo $TipoCon; ?>&Proc=M&TxtLote="+TxtLote+"&TxtRecargo="+TxtRecargo,"","top=10,left=30,width=900,height=650,scrollbars=yes,resizable=yes");
			break;
		case "E":
			var TxtLotes = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLote" &&f.elements[i].checked==true)
				{
					TxtLotes = TxtLotes + f.elements[i].value + "-" + f.elements[i + 1].value + "//";
				}
			}
			if (TxtLotes == "")
			{
				alert("No hay Nada Seleccionado para Eliminar");
				return;
			}
			else
			{
				var msg = confirm("�Esta Seguro de Eliminar estos Registros Permanentemente?");
				if (msg==true)
				{
					TxtLotes = TxtLotes.substring(0,(TxtLotes.length-2));
					f.action = "age_adm_recepcion01.php?Proceso=E&TxtValores="+TxtLotes;
					f.submit();
				}
				else
				{
					return;
				}
			}
			break;
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=10";
			f.submit();
			break;
		case "O": //ORDENA
			f.action = "age_adm_recepcion.php?LimitIni=<?php echo $LimitIni; ?>&TipoCon=<?php echo $TipoCon; ?>&Orden=" + valor;
			f.submit();
			break;
		case "R": //RECARGA
			f.action = "age_adm_recepcion.php?LimitIni=<?php echo $LimitIni; ?>&TipoCon=<?php echo $TipoCon; ?>&Orden=<?php echo $Orden; ?>&"+valor;
			f.submit();
			break;
		case "MT": //MARCA TODO
			var ValorChk = false;
			if (f.ChkMarcaTodo.checked)
				ValorChk = true;
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLote")
				{
					f.elements[i].checked=ValorChk;
					CCA(f.elements[i],'CL03');
				}
			}
			break;
		case "I":
			window.print();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
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
</style></head>

<body><DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<input type="hidden" name="TipoBusqueda" value="<?php echo $TipoCon; ?>">
<table class="TablaPrincipal" width="770">
	<tr>
	  <td width="850" height="340" align="center" valign="top"><br>
		  <table width="850"  border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr>
              <td colspan="5"><strong>Ver Recepciones </strong></td>
            </tr>
            <tr>
              <td width="13%">Entre Fechas:</td>
              <td width="35%"><input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al 
              <input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"></td>
              <td width="11%">SubProducto:</td>
              <td colspan="2"><select name="CmbSubProducto" style="width:230px ">
<option value="S" class="NoSelec">VER TODOS LOS SUBPRODUCTOS</option>			  
<?php
	$Consulta = "select * from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='1' order by lpad(cod_subproducto,3,'0')";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($CmbSubProducto == $Fila["cod_subproducto"])
			echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
		else
			echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
	}
?>			  
              </select>                <input name="BtnConsultar" type="button" id="BtnConsultar3" style="width:40px " onClick="Proceso('CF')" value="OK"></td>
            </tr>
            <tr>
              <td>Por Lote: </td>
              <td><input name="TxtLoteIni" type="text" class="InputDer" id="TxtLoteIni" value="<?php echo $TxtLoteIni; ?>" size="15" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtLoteFin');"> 
                Al
                  <input name="TxtLoteFin" type="text" class="InputDer" id="TxtLoteFin" value="<?php echo $TxtLoteFin; ?>" size="15" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'');">
                  <input name="BtnConsultar2" type="button" id="BtnConsultar2" style="width:40px " onClick="Proceso('CL')" value="OK"></td>
              <td>&nbsp;</td>
              <td width="14%" align="right">Ver:</td>
              <td width="27%"><input name="LimitFin" type="text" class="InputCen" value="<?php echo $LimitFin; ?>" size="7" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');"> 
                lineas                </td>
            </tr>
            <tr>
              <td>Ver Solo:</td>
              <td><select name="CmbAutorizado" onChange="Proceso('R')">
                <option value="T">TODO</option>
                <?php
		switch ($CmbAutorizado)
		{
			case "T":
				echo "<option selected value='T' class='NoSelec'>TODO</option>";
				echo "<option value='S'>AUTORIZADO</option>";
				echo "<option value='N'>NO AUTORIZADO</option>";
				break;
			case "S":
				echo "<option value='T' class='NoSelec'>TODO</option>";
				echo "<option selected value='S'>AUTORIZADO</option>";
				echo "<option value='N'>NO AUTORIZADO</option>";
				break;
			case "N":
				echo "<option value='T' class='NoSelec'>TODO</option>";
				echo "<option value='S'>AUTORIZADO</option>";
				echo "<option selected value='N'>NO AUTORIZADO</option>";
				break;
		}
?>
              </select></td>
              <td>&nbsp;</td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr align="center" class="ColorTabla02">
              <td colspan="2">              <input name="BtnOpemasiva" type="button" id="BtnOpemasiva" style="width:100px " onClick="Proceso('OM')" value="Ope. Masiva">
                <input name="BtnNuevoLote" type="button" id="BtnNuevoLote" style="width:80px " onClick="Proceso('NL')" value="Nuevo Lote">
                <input name="BtnModificar" type="button" id="BtnModificar" style="width:70px " onClick="Proceso('M')" value="Modificar">
                <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70px " onClick="Proceso('E')" value="Eliminar">              </td>
              <td colspan="3"><input name="BtnImprimir2" type="button" id="BtnImprimir3" style="width:100px " onClick="Proceso('BOL')" value="Imprimir Boleta">
                <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px " onClick="Proceso('I')" value="Imprimir">
                <input name="BtnExcel" type="button" id="BtnExcel" style="width:70px " onClick="Proceso('XLS')" value="Excel">
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
            </tr>
        </table>
		  <br>
		  <table width="850"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
            <tr class="ColorTabla01">
              <td width="4%"><input type="checkbox" name="ChkMarcaTodo" value="" onClick="Proceso('MT')"></td>
              <td width="5%"><a href="JavaScript:Proceso('O','F');">Fecha</a></td>
              <td width="7%"><a href="JavaScript:Proceso('O','O');">Correl.</a></td>
              <td width="4%"><a href="JavaScript:Proceso('O','L');">Lote</a></td>
              <td width="4%">R</td>
              <td width="4%">U</td>
              <td width="6%">P.Bruto</td>
              <td width="9%">P.Tara</td>
              <td width="8%">P.Neto</td>
              <td width="6%"><a href="JavaScript:Proceso('O','G');">Guia</a></td>
              <td width="11%"><a href="JavaScript:Proceso('O','T');">Producto</a></td>
              <td width="21%"><a href="JavaScript:Proceso('O','P');">Proveedor</a></td>
              <td width="4%"><a href="JavaScript:Proceso('O','C');">Conj</a></td>
              <td width="3%">Cls</td>
              <td width="4%">Aut</td>
            </tr>
<?php	
if (isset($TipoCon) && $TipoCon!="")	
{
	$Consulta = "select t2.fecha_recepcion, t2.corr, t2.lote, t2.recargo, t2.fin_lote, t5.nombre_prv as nom_proveedor, ";
	$Consulta.= " t1.cod_producto, t1.cod_subproducto, t2.peso_bruto, t2.peso_tara, t2.peso_neto, t2.guia_despacho, ";
	$Consulta.= " t2.guia_despacho, t2.patente, t1.rut_proveedor, LPAD(t2.recargo,2,'0') as orden, t2.pastas, t2.impurezas, ";
	$Consulta.= " t3.valor_subclase1 as est_rec, t2.autorizado, t1.num_conjunto, t4.abreviatura, t1.clase_producto, ";
	$Consulta.= " t2.hora_entrada, t2.hora_salida, t2.patente, t4.recepcion ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote=t2.lote ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='15003' and t2.estado_recargo=t3.cod_subclase ";
	$Consulta.= " inner join proyecto_modernizacion.subproducto t4 on t1.cod_producto=t4.cod_producto and t1.cod_subproducto=t4.cod_subproducto ";
	$Consulta.= " left join sipa_web.proveedores t5 on t1.rut_proveedor=t5.rut_prv  ";		
	switch ($TipoCon)
	{
		case "CF":
			$Consulta.= " where t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";		
			$Consulta.= " and t1.cod_producto='1' ";
			if ($CmbSubProducto!= "S")
				$Consulta.= " and t1.cod_subproducto='".$CmbSubProducto."'";		
			break;
		case "CL":				
			$Consulta.= " where t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";		
			break;
		case "CB":				
			$Consulta.= " where t2.folio between '".$TxtBoletaIni."' and '".$TxtBoletaFin."'";		
			break;
	}
	$Consulta.= "and t1.estado_lote<>'6' ";
	if ($CmbAutorizado!="T")
			$Consulta.= " and t2.autorizado='".$CmbAutorizado."'";		
	switch ($Orden)
	{
		case "F"://FECHA RECEPCION
			$Consulta.= " order by t2.fecha_recepcion, t2.lote, orden ";
			break;
		case "O"://CORRELATIVO
			$Consulta.= " order by t2.corr, t2.lote, orden ";
			break;
		case "L"://LOTE
			$Consulta.= " order by t2.lote, orden ";
			break;
		case "G"://GUIA DESPACHO
			$Consulta.= " order by t2.guia_despacho, t2.lote, orden ";
			break;
		case "T"://PRODUCTO
			$Consulta.= " order by lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'), t1.rut_proveedor, t2.lote, orden ";
			break;
		case "P"://PROVEEDOR
			$Consulta.= " order by t1.rut_proveedor, lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'), t2.lote, orden ";
			break;
		case "C"://CONJUNTO
			$Consulta.= " order by t1.num_conjunto, t2.lote, orden ";
			break;
		default://POR PROVEEDOR
			$Consulta.= " order by t1.rut_proveedor, lpad(t1.cod_producto,3,'0'),lpad(t1.cod_subproducto,3,'0'), t2.lote, orden ";
			break;
	}	
	$ConsultaAux = $Consulta;	
	$Consulta.= " limit ".$LimitIni.", ".$LimitFin."";	
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	//PARA SABER EL TOTAL DE REGISTROS
	$Respuesta = mysqli_query($link, $ConsultaAux);
	$Coincidencias =  mysqli_num_rows($Respuesta);
	//------------------------------
	$TotPesoBr = 0;
	$TotPesoTr = 0;
	$TotPesoNt = 0;
	$ContReg = 0;
	$Reg = 0;
	$ProdAnt="";
	$SubProdAnt="";
	$RutAnt="";
	$Tipo_Recep="";
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Tipo_Recep=$Fila["recepcion"];
		$Decimales=0;
		if ($Tipo_Recep=="PMN")
			$Decimales=3;
		if ($Orden=="T")
		{
			if (($ProdAnt!="" && $SubProdAnt!="") && ($ProdAnt!=$Fila["cod_producto"] || $SubProdAnt!=$Fila["cod_subproducto"]))
			{
				if ($RutAnt!=$Fila["rut_proveedor"])
					EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, &$TotPesoBrAnt, &$TotPesoTrAnt, &$TotPesoNtAnt, &$Reg, $Decimales);
				EscribeSubTotal("P", $NomProdAnt, $NomRutAnt, &$TotPesoBrAntSubProd, &$TotPesoTrAntSubProd, &$TotPesoNtAntSubProd, &$RegSubProd, $Decimales);
			}
			else
			{
				if (($ProdAnt!="" && $SubProdAnt!="" && $RutAnt!="") && 
				($ProdAnt==$Fila["cod_producto"] && $SubProdAnt==$Fila["cod_subproducto"] && $RutAnt!=$Fila["rut_proveedor"]))
				{
					EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, &$TotPesoBrAnt, &$TotPesoTrAnt, &$TotPesoNtAnt, &$Reg, $Decimales);
				}
			}
		}
		//RESCATA PASTAS E IMPUREZAS
		$Pastas = $Fila["pastas"];
		$Impurezas = $Fila["impurezas"];
		$ArrPastas=array();
		$ArrImpurezas=array();
		if (strlen($Pastas)>1)
		{
			for ($i=0;$i<strlen($Pastas);$i+2)
			{
				$CodLey = substr($Pastas,0,2);
				$ArrPastas[$CodLey][0]=$CodLey;
				$ArrPastas[$CodLey][1]="S";
				$Pastas = substr($Pastas,2);
			}
		}
		if (strlen($Impurezas)>1)
		{
			for ($i=0;$i<strlen($Impurezas);$i+2)
			{
				$CodLey = substr($Impurezas,0,2);
				$ArrImpurezas[$CodLey][0]=$CodLey;
				$ArrImpurezas[$CodLey][1]="S";
				$Impurezas = substr($Impurezas,2);
			}
		}			
		//NOMBRE_PROV			
		if ($Fila2["nom_proveedor"]=="")
			$NomProv = $Fila["nom_proveedor"];
		else
			$NomProv = $Fila["rut_proveedor"];
		echo "<tr >\n";
		echo "<td align='center'><input type='checkbox' name='ChkLote' value='".$Fila["lote"]."' onClick=\"CCA(this,'CL03')\">";
		echo "<input type='hidden' name='ChkRecargo' value='".$Fila["recargo"]."'><input type='hidden' name='ChkPesoNeto' value='".$Fila["peso_neto"]."'></td>\n";
		echo "<td align='center'>".substr($Fila["fecha_recepcion"],8,2)."/".substr($Fila["fecha_recepcion"],5,2)."</td>\n";
		echo "<td align='center'>".$Fila["corr"]."</td>\n";
		echo "<td onMouseOver=\"JavaScript:muestra('".$Fila["lote"].$Fila["recargo"]."');\" onMouseOut=\"JavaScript:oculta('".$Fila["lote"].$Fila["recargo"]."');\" class='Detalle02'>";
		echo "<div id='Txt".$Fila["lote"].$Fila["recargo"]."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:400px'>\n";
		echo "<table width='400' border='1' cellpadding='2' cellspacing='1'>";
		echo "<tr><td width='100'>PATENTE:</td><td>".$Fila["patente"]."</td></tr>";
		echo "<tr><td>HORA ENTRADA:</td><td>".$Fila["hora_entrada"]."</td></tr>";
		echo "<tr><td>HORA SALIDA:</td><td>".$Fila["hora_salida"]."</td></tr>";
		//PASTAS
		echo "<tr><td>PASTAS:</td><td>";
		reset($ArrPastas);
		$StrLeyes = "";
		while (list($k,$v)=each($ArrPastas))
		{
			$StrLeyes = $StrLeyes.$ArrLeyes[$v[0]][1].", ";
		}
		if ($StrLeyes!="")
		{
			$StrLeyes=substr($StrLeyes,0,strlen($StrLeyes)-2);
			echo $StrLeyes."</td></tr>";
		}
		else
		{
			echo "&nbsp;</td></tr>";
		}
		//IMPUREZAS
		echo "<tr><td>IMPUREZAS:</td><td>";
		reset($ArrImpurezas);
		$StrLeyes = "";
		while (list($k,$v)=each($ArrImpurezas))
		{
			$StrLeyes = $StrLeyes.$ArrLeyes[$v[0]][1].", ";
		}
		if ($StrLeyes!="")
		{
			$StrLeyes=substr($StrLeyes,0,strlen($StrLeyes)-2);
			echo $StrLeyes."</td></tr>";
		}
		else
		{
			echo "&nbsp;</td></tr>";
		}
		echo "</table></div>".$Fila["lote"]."</td>";
		echo "<td align='center'>".$Fila["recargo"]."</td>\n";
		if ($Fila["fin_lote"]!="" && !is_null($Fila["fin_lote"]))
			echo "<td align='center'>".$Fila["fin_lote"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_bruto"],$Decimales,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_tara"],$Decimales,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_neto"],$Decimales,",",".")."</td>\n";
		if ($Fila["guia_despacho"]!="" && !is_null($Fila["guia_despacho"]))
			echo "<td align='center'>".$Fila["guia_despacho"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		if ($Fila["abreviatura"]!="" && !is_null($Fila["abreviatura"]))
			echo "<td>".$Fila["abreviatura"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		if ($NomProv!="")
			echo "<td>".substr($NomProv,0,18)."</td>\n";
		else
			echo "<td>".$Fila["rut_proveedor"]."</td>\n";
		if ($Fila["num_conjunto"]!="")
			echo "<td align='center'>".$Fila["num_conjunto"]."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		echo "<td align='center'>".strtoupper($Fila["clase_producto"])."</td>\n";
		echo "<td align='center'>".strtoupper($Fila["autorizado"])."</td>\n";
		echo "</tr>\n";
		$TotPesoBr = $TotPesoBr + $Fila["peso_bruto"];
		$TotPesoTr = $TotPesoTr + $Fila["peso_tara"];
		$TotPesoNt = $TotPesoNt + $Fila["peso_neto"];
		$TotPesoBrAnt = $TotPesoBrAnt + $Fila["peso_bruto"];
		$TotPesoTrAnt = $TotPesoTrAnt + $Fila["peso_tara"];
		$TotPesoNtAnt = $TotPesoNtAnt + $Fila["peso_neto"];
		$TotPesoBrAntSubProd = $TotPesoBrAntSubProd + $Fila["peso_bruto"];
		$TotPesoTrAntSubProd = $TotPesoTrAntSubProd + $Fila["peso_tara"];
		$TotPesoNtAntSubProd = $TotPesoNtAntSubProd + $Fila["peso_neto"];
		$NomProdAnt = $Fila["abreviatura"];
		$NomRutAnt = $NomProv;
		$ProdAnt = $Fila["cod_producto"];
		$SubProdAnt =$Fila["cod_subproducto"];
		$RutAnt = $Fila["rut_proveedor"];
		$ContReg++;
		$Reg++;
		$RegSubProd++;
	}
	if ($Orden=="T")
	{
		EscribeSubTotal("R", $NomProdAnt, $NomRutAnt, &$TotPesoBrAnt, &$TotPesoTrAnt, &$TotPesoNtAnt, &$Reg, $Decimales);
		EscribeSubTotal("P", $NomProdAnt, $NomRutAnt, &$TotPesoBrAntSubProd, &$TotPesoTrAntSubProd, &$TotPesoNtAntSubProd, &$RegSubProd, $Decimales);
	}
	//TOTAL POR CONSULTA
	$Consulta = "select sum(t2.peso_bruto) as peso_bruto, sum(t2.peso_tara) as peso_tara, sum(t2.peso_neto) as peso_neto ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 ";
	$Consulta.= " on t1.lote=t2.lote left join rec_web.proved t3 on ";
	$Consulta.= " t3.RUTPRV_A=t1.rut_proveedor ";
	switch ($TipoCon)
	{
		case "CF":
			$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";		
			$Consulta.= " and t1.cod_producto='1' ";
			if ($CmbSubProducto!="S")
				$Consulta.= "  and t1.cod_subproducto='".$CmbSubProducto."'";		
			break;
		case "CL":				
			$Consulta.= " where t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";		
			break;
	}	
	$Consulta.= " and t1.estado_lote<>'6' ";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$TotConPesoBr = $Fila["peso_bruto"];
		$TotConPesoTr = $Fila["peso_tara"];
		$TotConPesoNt = $Fila["peso_neto"];		
	}
	//FIN TOTAL POR CONSULTA	
}	
function EscribeSubTotal($Opt, $NomProd, $NomRut, $PesoBr, $PesoTr, $PesoNt, $RegAux, $Decimales)
{	
	switch ($Opt)
	{
		case "P":
			echo '<tr class="Detalle03">';
			echo '<td colspan="4" align="left"><strong>TOTAL SUBPRODUCTO</strong></td>';
			break;
		case "R":
			echo '<tr class="Detalle01">';
			echo '<td colspan="4" align="left"><strong>TOTAL PROVEEDOR</strong></td>';
			break;
	}
	echo '<td colspan="2" align="center"><strong>'.$RegAux.'</strong></td>';	
	echo '<td align="right"><strong>'.number_format($PesoBr,$Decimales,",",".").'</strong></td>';
	echo '<td align="right"><strong>'.number_format($PesoTr,$Decimales,",",".").'</strong></td>';
	echo '<td align="right"><strong>'.number_format($PesoNt,$Decimales,",",".").'</strong></td>';
	switch ($Opt)
	{
		case "P":
			echo '<td colspan="1" align="left">&nbsp;</td>';
			echo '<td colspan="5" align="left"><strong>'.$NomProd.'</strong></td>';
			break;
		case "R":
			echo '<td colspan="2" align="left">&nbsp;</td>';
			echo '<td colspan="4" align="left"><strong>'.$NomRut.'</strong></td>';
			break;
	}
	echo '</tr>';
	$NomProd = "";
	$NomRut = "";
	$PesoBr = 0;
	$PesoTr = 0;
	$PesoNt = 0;
	$RegAux = 0;
}
?>			
            <tr class="ColorTabla02">
              <td colspan="4"><strong>TOTAL PAGINA </strong></td>
              <td colspan="2" align="center"><strong><?php echo number_format($ContReg,0,",",".");?> </strong></td>
              <td align="right"><?php echo number_format($TotPesoBr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotPesoTr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotPesoNt,0,",",".");?></td>
              <td colspan="6">&nbsp;</td>
            </tr>
		</table>	
<?php
	if ($Coincidencias>$LimitFin)			
	{
?>	<br>	
<table width="377"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01">
              <td><strong>TOTAL CONSULTA</strong></td>
              <td width="17%"><strong>P.Bruto</strong></td>
              <td width="16%"><strong>P.Tara</strong></td>
              <td width="16%"><strong>P.Neto</strong></td>
          </tr>
			<tr class="ColorTabla02">
              <td><strong><?php echo number_format($Coincidencias,0,",",".");?> Reg.</strong></td>
              <td align="right"><?php echo number_format($TotConPesoBr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotConPesoTr,0,",",".");?></td>
              <td align="right"><?php echo number_format($TotConPesoNt,0,",",".");?></td>
            </tr>
		</table>
<br>
<?php
	}
?>			
        	              
<?php
if (isset($TipoCon))
{
	if ($Coincidencias > $LimitFin)
	{
		$NumPaginas = ($Coincidencias / $LimitFin);	
		echo "<table border='0' cellpadding='0' cellspacing='0'><tr>\n";
		echo "<td width='14' align='center' valign='middle'>\n";
		if (($LimitIni-$LimitFin) >= 0)
		{
			echo "<a href=\"JavaScript:Proceso('R','LimitIni=".($LimitIni-$LimitFin)."')\">";
			echo "<img src='../principal/imagenes/ico_atras_ano.gif' width='14' height='18' border='0' align='absmiddle'></td>\n";
			echo "</a>";
		}	
		$LimitIniAnt = $LimitIni;
		$LimitFinAnt = $LimitIni;
		$StrPaginas = "";
		echo "<td align='center' valign='middle' bgcolor='#004584'>&nbsp;&nbsp;\n";
		for ($i = 0; $i <= $NumPaginas; $i++)
		{
			$LimitIni = ($i * $LimitFin);
			if ($LimitIni == $LimitFinAnt)
			{
				$StrPaginas.= "<strong><font color='yellow'>".($i + 1)."</strong>&nbsp;-&nbsp;</font>\n";
			}
			else
			{
				$StrPaginas.=  "<a href=\"JavaScript:Proceso('R','LimitIni=".($i * $LimitFin)."')\">";
				$StrPaginas.= "".($i + 1)."</a>&nbsp;<font color='#FFFFFF'>-</font>&nbsp;\n";
			}
		}
		echo substr($StrPaginas,0,-15);
		echo "&nbsp;&nbsp;</td>\n";
		echo "<td width='15' align='center' valign='middle'>\n";
		if (($LimitIniAnt+$LimitFin) <= $Coincidencias)
		{
			echo "<a href=\"JavaScript:Proceso('R','LimitIni=".($LimitIniAnt+$LimitFin)."')\">";
			echo "<img src='../principal/imagenes/ico_ade_mes.gif' width='15' height='18' border='0' align='absmiddle'></td>\n";
			echo "</a>";
		}	
		echo "</tr>\n";
		echo "</table>\n";
	}	
}	
?>	  </td>
	</tr>
</table>
<input type="hidden" name="LimitFinAnt" value="<?php echo $LimitFinAnt; ?>">
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
