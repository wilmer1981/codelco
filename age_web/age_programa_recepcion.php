<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=3;
	include("../principal/conectar_principal.php");
	if (!isset($Ano))
		$Ano = date("Y");
	if (!isset($ChkTipoProg))
		$ChkTipoProg = "00";
?>	
<html>
<head>
<title>AGE-Programa Recepcion</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
var Meses = new Array(13) 
Meses[0] = "Tot" ;
Meses[1] = "Ene";
Meses[2] = "Feb";
Meses[3] = "Mar";
Meses[4] = "Abr";
Meses[5] = "May";
Meses[6] = "Jun";
Meses[7] = "Jul";
Meses[8] = "Ago";
Meses[9] = "Sep";
Meses[10] = "Oct";
Meses[11] = "Nov";
Meses[12] = "Dic";
function Proceso(opt,opt1)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "G":
			if (f.CmbSubProducto.value == "S")
			{
				alert("Debe Seleccionar un SubProducto");
				f.CmbSubProducto.focus();
				return;
			}
			if (f.CmbContrato.value == "S")
			{
				alert("Debe Seleccionar o Ingresar un Contrato");
				f.CmbContrato.focus();
				return;
			}
			f.action = "age_programa_recepcion01.php?Proceso=G";
			f.submit();
			break;
		case "AP": //AGREGA PROVEEDOR
			if (f.CmbSubProducto.value == "S")
			{
				alert("Debe Seleccionar un SubProducto");
				f.CmbSubProducto.focus();
				return;
			}
			if (f.CmbContrato.value == "S")
			{
				alert("Debe Seleccionar o Ingresar un Contrato");
				f.CmbContrato.focus();
				return;
			}
			if (f.CmbProveedor.value == "S")
			{
				alert("Debe Seleccionar Proveedor");
				f.CmbProveedor.focus();
				return;
			}
			f.action = "age_programa_recepcion01.php?Proceso=AP";
			f.submit();
			break;
		case "R":
			f.action = "age_programa_recepcion.php";
			f.submit();
			break;
		case "NC"://NUEVO CONTRATO
			if (f.CmbSubProducto.value == "S")
			{
				alert("Debe Seleccionar un SubProducto");
				f.CmbSubProducto.focus();
				return;
			}
			window.open("age_programa_recepcion_contrato.php?SubProducto="+f.CmbSubProducto.value,"","top=80,left=50,width=850px,height=380px,scrollbars=yes,resizable=yes");
			break;
		case "MC":
			if (f.CmbSubProducto.value=="S")
			{
				alert("Debe Seleccionar un SubProducto para Modificar");
				f.CmbSubProducto.focus();
				return;
			}
			if (f.CmbContrato.value=="S")
			{
				alert("Debe Seleccionar un Contrato para Modificar");
				f.CmbContrato.focus();
				return;
			}
			window.open("age_programa_recepcion_contrato.php?Modif=S&SubProducto="+f.CmbSubProducto.value+"&TxtNumContrato="+f.CmbContrato.value,"","top=80,left=50,width=850px,height=380px,scrollbars=yes,resizable=yes");
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=2&Nivel=1";
			f.submit();
			break;
		case "RS":
			f.ChkSelec.value=opt1.value;
			break;
		case "E":
			if (f.ChkSelec.value!="")
			{
				var msg=confirm("�Seguro que desea Eliminar este Proveedor?");
				if (msg==true)
				{
					f.action = "age_programa_recepcion01.php?Proceso=E";
					f.submit();
				}
				else
				{
					return;
				}
			}
			else
			{
				alert("No hay ning�n registro seleccionado");
				return;
			}
			break;
		case "I":
			window.print();
			break;
	}
}
function Calcula(obj,valor)
{
	var f=document.frmPrincipal;	
	valor = valor.replace("-","");
	if (obj.name.substring(0,10)=="ChkPesoTot")
	{
		if (obj.value==0 || obj.value=="")
		{
			for (i=0;i<=12;i++)
			{	//INICIALIZA EN CERO
				eval("f.ChkPeso"+Meses[i]+"_"+valor+".value=0;");
			}
		}
		else
		{
			if (confirm("�Desea Dividir el Total (" + obj.value + ") en los 12 Meses?"))
			{
				var TotPeso=0;
				for (i=1;i<=12;i++)
				{	//INICIALIZA EN CERO
					eval("f.ChkPeso"+Meses[i]+"_"+valor+".value=Math.round(obj.value/12);");
				}
				TotPeso = Math.round(obj.value/12) *12;
				if (TotPeso>obj.value)
				{
					eval("f.ChkPesoDic_"+valor+".value = parseInt(f.ChkPesoDic_"+valor+".value) - (parseInt(TotPeso) - parseInt(obj.value));")
				}
				else
				{
					if (TotPeso<obj.value)
						eval("f.ChkPesoDic_"+valor+".value = parseInt(f.ChkPesoDic_"+valor+".value) + (parseInt(obj.value) - parseInt(TotPeso));")
				}
			}
		}
	}
	else
	{		
		eval("f.ChkPesoTot_"+valor+".value=0;");
		for (i=0;i<=12;i++)
		{	//INICIALIZA EN CERO
			eval("if (f.ChkPeso"+Meses[i]+"_"+valor+".value=='')f.ChkPeso"+Meses[i]+"_"+valor+".value=0;");
			eval("f.ChkPesoTot_"+valor+".value=parseInt(f.ChkPesoTot_"+valor+".value) + parseInt(f.ChkPeso"+Meses[i]+"_"+valor+".value);");
		}		
	}
	//CALCULA TOTALES
	for (i=0;i<=12;i++)
	{	//INICIALIZA EN CERO
		eval("if (f.ChkPesoTotal"+Meses[i]+".value==''){ f.ChkPesoTotal"+Meses[i]+".value=0; }");
	}
	for (i=0;i<=12;i++)
	{	//CALCULA TOTALES
		eval("if (parseInt(f.ChkPesoAnt"+Meses[i]+".value) > parseInt(f.ChkPeso"+Meses[i]+"_"+valor+".value)){ f.ChkPesoTotal"+Meses[i]+".value = parseInt(f.ChkPesoTotal"+Meses[i]+".value) - (parseInt(f.ChkPesoAnt"+Meses[i]+".value) - parseInt(f.ChkPeso"+Meses[i]+"_"+valor+".value)); }else{ if (parseInt(f.ChkPesoAnt"+Meses[i]+".value) < parseInt(f.ChkPeso"+Meses[i]+"_"+valor+".value)){ f.ChkPesoTotal"+Meses[i]+".value = parseInt(f.ChkPesoTotal"+Meses[i]+".value) + (parseInt(f.ChkPeso"+Meses[i]+"_"+valor+".value) - parseInt(f.ChkPesoAnt"+Meses[i]+".value));}}");
	}
}		
function RescataValores(obj,valor)
{
	var f=document.frmPrincipal;
	valor = valor.replace("-","");
	//alert(valor);
	for (i=0;i<=12;i++)
	{	//INICIALIZA EN CERO
		eval("if (f.ChkPeso"+Meses[i]+"_"+valor+".value=='') f.ChkPesoAnt"+Meses[i]+".value=0; else f.ChkPesoAnt"+Meses[i]+".value=f.ChkPeso"+Meses[i]+"_"+valor+".value;");
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
-->
</style></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<input type="hidden" name="ChkSelec" value="">
<input type='hidden' name='ChkPesoAntTot' value=''>
<input type='hidden' name='ChkPesoAntEne' value=''>
<input type='hidden' name='ChkPesoAntFeb' value=''>
<input type='hidden' name='ChkPesoAntMar' value=''>
<input type='hidden' name='ChkPesoAntAbr' value=''>
<input type='hidden' name='ChkPesoAntMay' value=''>
<input type='hidden' name='ChkPesoAntJun' value=''>
<input type='hidden' name='ChkPesoAntJul' value=''>
<input type='hidden' name='ChkPesoAntAgo' value=''>
<input type='hidden' name='ChkPesoAntSep' value=''>
<input type='hidden' name='ChkPesoAntOct' value=''>
<input type='hidden' name='ChkPesoAntNov' value=''>
<input type='hidden' name='ChkPesoAntDic' value=''>

<input type='hidden' name='TipoProg' value='<?php echo $TipoProg; ?>'>
<table class="TablaPrincipal" width="791">
	<tr>
	  <td width="770" height="330" align="center" valign="top"><br>
	    <table width="600" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr class="Detalle02">
            <td width="97">&gt;&gt;A&ntilde;o:</td>
            <td width="237" ><select name="Ano" onChange="Proceso('R')">
<?php
	for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
	{
		if (isset($Ano))
		{
			if ($Ano==$i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if (date("Y")==$i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";			
		}
	}
?>			
            </select>            </td>
            <td width="158" >&nbsp;</td>
          </tr>
          <tr class="Detalle02">
            <td height="28">&gt;&gt;SubProducto:</td>
            <td height="28"><select name="CmbSubProducto" style="width:300" onChange="Proceso('R')">
              <option class="NoSelec" value="S">SELECCIONAR</option>
              <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " cod_subproducto as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";//and recepcion<>'PMN'";
				$Consulta.= " order by lpad(cod_subproducto,3,'0') ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
            </select></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="Detalle02">
            <td height="20">&gt;&gt;Contrato:</td>
            <td height="20"><select name="CmbContrato" style="width:300" onChange="Proceso('R')">
			<option class="NoSelec" value="S">SELECCIONAR</option>
<?php
	$Consulta = "select * from age_web.contratos ";
	//if ($CmbSubProducto!="S" && isset($CmbSubProducto))
		$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."'";
	$Consulta.= " order by cod_producto, cod_subproducto, cod_contrato ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($CmbContrato==$Fila["cod_contrato"])
			echo "<option selected value='".$Fila["cod_contrato"]."'>".$Fila["cod_contrato"]." - ".$Fila["descripcion"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_contrato"]."'>".$Fila["cod_contrato"]." - ".$Fila["descripcion"]."</option>\n";
	}
?>			
            </select>              </td>
            <td><input name="BtnNuevo" type="button" id="BtnNuevo" value="Nuevo" onClick="Proceso('NC')" style="width:70px ">
            <input name="BtnModifContrato" type="button" id="BtnModifContrato" value="Modificar" onClick="Proceso('MC')" style="width:70px "></td>
          </tr>
          <tr class="Detalle02">
            <td height="30">&gt;&gt;Proveedor:</td>
            <td height="30"><select name="CmbProveedor" style="width:300">
              <option class="NoSelec" value="S" >SELECCIONAR</option>
              <?php
				$Consulta = "select t1.rut_proveedor, t2.nomprv_a ";
				$Consulta.= " from age_web.relaciones t1 left join rec_web.proved t2 on t1.rut_proveedor = t2.rutprv_a ";
				$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto= '".$CmbSubProducto."' ";
				$Consulta.= " and t1.grupo= 'P' ";
				$Consulta.= " order by t2.nomprv_a";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["rut_proveedor"])
						echo "<option selected value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
					else
						echo "<option value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
				}
				//BUSCA SI TIENE VARIOS
				$Consulta = "select * ";
				$Consulta.= " from age_web.relaciones t1 left join rec_web.proved t2 on t1.rut_proveedor = t2.rutprv_a ";
				$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto= '".$CmbSubProducto."' ";
				$Consulta.= " and t1.grupo= 'V' ";
				$Consulta.= " order by t2.nomprv_a";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					echo "<option value='V'>*********&nbsp;&nbsp;&nbsp;&nbsp;PROVEEDORES VARIOS&nbsp;&nbsp;*********</option>";
				}
				echo "<option value='D'>****&nbsp;&nbsp;CONSIDERAR PROVEEDORES SIN GRUPO&nbsp;&nbsp;*****</option>";
			?>
            </select>            </td>
            <td><input name="BtnAgregarProv" type="button" id="BtnAgregarProv" value="Agregar" onClick="Proceso('AP')" style="width:70px "></td>
          </tr>
          <tr>
            <td colspan="3" align="center"><input name="BtnGrabarPeso" type="button" value="Grabar Pesos" onClick="Proceso('G')" style="width:100px ">
              <input name="BtnImprimir" type="button" id="BtnEliminar" value="Imprimir" onClick="Proceso('I')" style="width:70px ">
              <input name="BtnEliminar" type="button" id="BtnModificar" value="Eliminar" onClick="Proceso('E')" style="width:70px ">
              <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" onClick="Proceso('S')" style="width:70px "></td>
          </tr>
          
<?php		
$Consulta = "select * from age_web.programa_recepcion t1 left join rec_web.proved t2 on t1.rut_proveedor = t2.rutprv_a ";
$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto='".$CmbSubProducto."' ";
$Consulta.= " and t1.ano='".$Ano."' and t1.cod_contrato='".$CmbContrato."' ";
$Consulta.= " and t1.tipo_programa='00'";
//echo $Consulta;
$Resp = mysqli_query($link, $Consulta);
if ($Fila = mysqli_fetch_array($Resp))  	
{	
	echo "<tr valign='middle' class='Detalle01'>\n";
	echo "<td height='30'>Trabajando Con: </td>\n";
	echo "<td height='30' colspan='2'>\n";
	switch ($ChkTipoProg)
	{
		case "00":
			echo "<input checked name='ChkTipoProg' type='radio' value='00' onClick=\"Proceso('R')\">Peso (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='02' onClick=\"Proceso('R')\">Cu (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='04' onClick=\"Proceso('R')\">Ag (Kg)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='05' onClick=\"Proceso('R')\">Au (Kg)";
			break;
		case "02":
			echo "<input name='ChkTipoProg' type='radio' value='00' onClick=\"Proceso('R')\">Peso (Ton)&nbsp;&nbsp;";
			echo "<input checked name='ChkTipoProg' type='radio' value='02' onClick=\"Proceso('R')\">Cu (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='04' onClick=\"Proceso('R')\">Ag (Kg)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='05' onClick=\"Proceso('R')\">Au (Kg)";
			break;
		case "04":
			echo "<input name='ChkTipoProg' type='radio' value='00' onClick=\"Proceso('R')\">Peso (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='02' onClick=\"Proceso('R')\">Cu (Ton)&nbsp;&nbsp;";
			echo "<input checked name='ChkTipoProg' type='radio' value='04' onClick=\"Proceso('R')\">Ag (Kg)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='05' onClick=\"Proceso('R')\">Au (Kg)";
			break;
		case "05":
			echo "<input name='ChkTipoProg' type='radio' value='00' onClick=\"Proceso('R')\">Peso (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='02' onClick=\"Proceso('R')\">Cu (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='04' onClick=\"Proceso('R')\">Ag (Kg)&nbsp;&nbsp;";
			echo "<input checked name='ChkTipoProg' type='radio' value='05' onClick=\"Proceso('R')\">Au (Kg)";
			break;
	}
	echo "</td>\n";
    echo "</tr>\n";
}
?>			
        </table>
        <br>
        <table width="760" border="0" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01">
            <td >&nbsp;</td>
            <td width="100">Proveedor</td>
			<td >Total</td>
            <td >Ene</td>
            <td >Feb</td>
            <td >Mar</td>
            <td >Abr</td>
            <td >May</td>
            <td >Jun</td>
            <td >Jul</td>
            <td >Ago</td>
            <td >Sep</td>
            <td >Oct</td>
            <td >Nov</td>
            <td >Dic</td>
          </tr>
<?php		
	$ChkPesoTotalTot = 0;
	$ChkPesoTotalEne = 0;
	$ChkPesoTotalFeb = 0;
	$ChkPesoTotalMar = 0;
	$ChkPesoTotalAbr = 0;
	$ChkPesoTotalMay = 0;
	$ChkPesoTotalJun = 0;
	$ChkPesoTotalJul = 0;
	$ChkPesoTotalAgo = 0;
	$ChkPesoTotalSep = 0;
	$ChkPesoTotalOct = 0;
	$ChkPesoTotalNov = 0;
	$ChkPesoTotalDic = 0;
	for ($Cont=1;$Cont<=3;$Cont++)
	{
		switch ($Cont)
		{
			case 1:
				$Titulo="PROVEEDORES PRINCIPALES";
				$Grupo="P";
				break;
			case 2:
				$Titulo="PROVEEDORES VARIOS";
				$Grupo="V";
				break;
			case 3:
				$Titulo="PROVEEDORES SIN GRUPO";
				$Grupo="";
				break;
		}
		$Consulta = "select * ";
		$Consulta.= " from age_web.programa_recepcion t1 left join rec_web.proved t2 on ";
		$Consulta.= " t1.rut_proveedor = t2.rutprv_a left join age_web.relaciones t3 on ";
		$Consulta.= " t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
		$Consulta.= " and t1.rut_proveedor=t3.rut_proveedor ";
		$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto='".$CmbSubProducto."' ";
		$Consulta.= " and t1.ano='".$Ano."' and t1.cod_contrato='".$CmbContrato."' ";
		$Consulta.= " and t1.tipo_programa='00' ";
		if ($Grupo=="")
			$Consulta.= " and (t3.grupo='".$Grupo."' or isnull(t3.grupo)) ";
		else
			$Consulta.= " and t3.grupo='".$Grupo."'";
		$Consulta.= " order by t2.nomprv_a";
		$j=1;
		$RespAux = mysqli_query($link, $Consulta);
		while ($FilaAux = mysqli_fetch_array($RespAux))  	
		{	
			if ($j==1)
				echo "<tr class=\"Detalle01\" align=\"left\"><td colspan=\"15\">>>>&nbsp;&nbsp;".$Titulo."</td></tr>";
			$Consulta = "select * from age_web.programa_recepcion t1 left join rec_web.proved t2 on t1.rut_proveedor = t2.rutprv_a ";
			$Consulta.= " where t1.cod_producto='".$FilaAux["cod_producto"]."' and t1.cod_subproducto='".$FilaAux["cod_subproducto"]."' ";
			$Consulta.= " and t1.rut_proveedor='".$FilaAux["rut_proveedor"]."'";
			$Consulta.= " and t1.ano='".$FilaAux["ano"]."' and t1.cod_contrato='".$FilaAux["cod_contrato"]."' ";
			$Consulta.= " and t1.tipo_programa='".$ChkTipoProg."'";
			$Consulta.= " order by t2.nomprv_a";
			$Resp = mysqli_query($link, $Consulta);
			$i=1;
			$Fila = mysqli_fetch_array($Resp);
			$ValorTot= $Fila["ene"]+$Fila["feb"]+$Fila["mar"]+$Fila["abr"]+$Fila["may"]+$Fila["jun"]+$Fila["jul"]+$Fila["ago"]+$Fila["sep"]+$Fila["oct"]+$Fila["nov"]+$Fila["dic"];
			echo "<tr align='center'>\n";
			echo "<td><input name='ChkProv' type='radio' value='".$FilaAux["rut_proveedor"]."' onClick=\"Proceso('RS',this)\"></td>\n";
			echo "<td align='left' ><font style='font-family:Verdana;font-size:9px'>";
			if ($Grupo=="" && $FilaAux["NOMPRV_A"]=="")
				echo "DIFERENCIA";
			else
				echo substr($FilaAux["NOMPRV_A"],0,20);
			echo "</font></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoTot_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$ValorTot."'    onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" style='width50px;background:yellow' onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";		
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoEne_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["ene"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoFeb_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["feb"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoMar_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["mar"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoAbr_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["abr"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoMay_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["may"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoJun_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["jun"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoJul_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["jul"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoAgo_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["ago"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoSep_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["sep"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoOct_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["oct"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoNov_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["nov"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "<td><input type='text' class='InputPrograma' name='ChkPesoDic_".str_replace("-","",$FilaAux["rut_proveedor"])."' value='".$Fila["dic"]."' onBlur=\"Calcula(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\" onKeyDown=\"TeclaPulsada('S',false);\" onFocus=\"RescataValores(this,'".str_replace("-","",$FilaAux["rut_proveedor"])."')\"></td>\n";
			echo "</tr>\n";
			$ChkPesoTotalTot = $ChkPesoTotalTot + $ValorTot;
			$ChkPesoTotalEne = $ChkPesoTotalEne + $Fila["ene"];
			$ChkPesoTotalFeb = $ChkPesoTotalFeb + $Fila["feb"];
			$ChkPesoTotalMar = $ChkPesoTotalMar + $Fila["mar"];
			$ChkPesoTotalAbr = $ChkPesoTotalAbr + $Fila["abr"];
			$ChkPesoTotalMay = $ChkPesoTotalMay + $Fila["may"];
			$ChkPesoTotalJun = $ChkPesoTotalJun + $Fila["jun"];
			$ChkPesoTotalJul = $ChkPesoTotalJul + $Fila["jul"];
			$ChkPesoTotalAgo = $ChkPesoTotalAgo + $Fila["ago"];
			$ChkPesoTotalSep = $ChkPesoTotalSep + $Fila["sep"];
			$ChkPesoTotalOct = $ChkPesoTotalOct + $Fila["oct"];
			$ChkPesoTotalNov = $ChkPesoTotalNov + $Fila["nov"];
			$ChkPesoTotalDic = $ChkPesoTotalDic + $Fila["dic"];
			$i++;
			$j++;
		}
	}
?>		  
          <tr class="Detalle01" align="center">
            <td colspan="2">Total Contrato: </td>
			<td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalTot' value='<?php echo $ChkPesoTotalTot;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalEne' value='<?php echo $ChkPesoTotalEne;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalFeb' value='<?php echo $ChkPesoTotalFeb;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalMar' value='<?php echo $ChkPesoTotalMar;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalAbr' value='<?php echo $ChkPesoTotalAbr;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalMay' value='<?php echo $ChkPesoTotalMay;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalJun' value='<?php echo $ChkPesoTotalJun;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalJul' value='<?php echo $ChkPesoTotalJul;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalAgo' value='<?php echo $ChkPesoTotalAgo;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalSep' value='<?php echo $ChkPesoTotalSep;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalOct' value='<?php echo $ChkPesoTotalOct;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalNov' value='<?php echo $ChkPesoTotalNov;?>' style='width50px;background:#DDDDDD'></td>
            <td><input type='text' class='InputPrograma' readonly name='ChkPesoTotalDic' value='<?php echo $ChkPesoTotalDic;?>' style='width50px;background:#DDDDDD'></td>
          </tr>
        </table></td>
	</tr>
</table>
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
