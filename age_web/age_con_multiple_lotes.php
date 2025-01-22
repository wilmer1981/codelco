<?php 	
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 31;
	include("../principal/conectar_principal.php");

	$Busq = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
	$TxtFechaIni = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:date('Y-m')."-01";
	$TxtFechaFin = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:date('Y-m')."-".date('t');
	$TxtLoteIni = isset($_REQUEST["TxtLoteIni"])?$_REQUEST["TxtLoteIni"]:"";
	$TxtLoteFin = isset($_REQUEST["TxtLoteFin"])?$_REQUEST["TxtLoteFin"]:"";
	$TxtConjIni = isset($_REQUEST["TxtConjIni"])?$_REQUEST["TxtConjIni"]:"";
	$TxtConjFin = isset($_REQUEST["TxtConjFin"])?$_REQUEST["TxtConjFin"]:"";
	$OpcConsulta = isset($_REQUEST["OpcConsulta"])?$_REQUEST["OpcConsulta"]:"";
    $CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$Mes = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbFlujos      = isset($_REQUEST["CmbFlujos"])?$_REQUEST["CmbFlujos"]:"";	
	$CmbProveedor   = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";

	$TxtFiltroPrv    = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$OpcTR           = isset($_REQUEST["OpcTR"])?$_REQUEST["OpcTR"]:"";
	$OpcSF           = isset($_REQUEST["OpcSF"])?$_REQUEST["OpcSF"]:"";
	$OpcHLF          = isset($_REQUEST["OpcHLF"])?$_REQUEST["OpcHLF"]:"";
	$TxtLeyesMuestra = isset($_REQUEST["TxtLeyesMuestra"])?$_REQUEST["TxtLeyesMuestra"]:"";
	$TxtCodLeyes     = isset($_REQUEST["TxtCodLeyes"])?$_REQUEST["TxtCodLeyes"]:"";
	$TxtLimitesMuestra = isset($_REQUEST["TxtLimitesMuestra"])?$_REQUEST["TxtLimitesMuestra"]:"";
	$TxtCodLimites     = isset($_REQUEST["TxtCodLimites"])?$_REQUEST["TxtCodLimites"]:"";
	
?>
<html>
<head>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Recarga3()
{
	var Frm = document.FrmPrincipal;
	Frm.action="age_con_multiple_lotes.php?Busq=S";
	Frm.submit();	
}
function Recarga(TipoBusq)
{
	var Frm=document.FrmPrincipal;
	switch(TipoBusq)
	{
		case "1"://POR FECHA		
			Frm.TxtLoteIni.value = "";
			Frm.TxtLoteFin.value = "";
			Frm.TxtConjIni.value = "";
			Frm.TxtConjFin.value = "";
			Frm.TxtFechaIni.focus();
			break;
		case "2"://POR LOTE
			Frm.TxtConjIni.value = "";
			Frm.TxtConjFin.value = "";
			Frm.TxtLoteIni.focus();
			break;
		case "3"://POR CONJUNTO
			Frm.TxtLoteIni.value = "";
			Frm.TxtLoteFin.value = "";
			Frm.TxtConjIni.focus();
			break;
	}
	Frm.TipoBusqueda.value=TipoBusq;
}
function Consulta(opt)
{
	var f=document.FrmPrincipal;
	switch (f.TipoBusqueda.value)
	{
		case "2":
			if (f.TxtLoteIni.value=="")
			{
				alert("Debe Ingresar Rango de Lotes");
				f.TxtLoteIni.focus();
				return;
			}
			if (f.TxtLoteIni.value!="" && f.TxtLoteFin.value=="")
			{
				f.TxtLoteFin.value = f.TxtLoteIni.value;
			}			
			break;
		case "3":
			if (f.TxtConjIni.value=="")
			{
				alert("Debe Ingresar Rango de Conjuntos");
				f.TxtConjIni.focus();
				return;
			}
			if (f.TxtConjIni.value!="" && f.TxtConjFin.value=="")
			{
				f.TxtConjFin.value = f.TxtConjIni.value;
			}		
			break;
	}
	switch (opt)
	{
		case "W":
			f.action = "age_con_multiple_lotes_web.php";
			break;
		case "E":
			f.action = "age_con_multiple_lotes_excel.php";
			break;
	}	
	f.submit();
	
}
function CargaParametros(opt)
{
	var f=document.FrmPrincipal;
	switch (opt)
	{
		case "LEY":
			URL="age_con_multiple_lotes_leyes.php?TipoConsulta=" + f.TipoBusqueda.value;
			break;
		case "LIM":
			URL="age_con_multiple_lotes_limites.php?TipoConsulta=" + f.TipoBusqueda.value;
			break;
	}	
	window.open(URL,"","top=30,left=30,width=650,height=500,scrollbars=yes,resizable=yes");
}
function Salir()
{
	var Frm=document.FrmPrincipal;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=30&Nivel=1";
	Frm.submit();
}
</script>
<title>AGE-Consulta Multiple Lotes</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style type="text/css">
.Estilo1 {color: #0000ff}
</style>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmPrincipal" method="post" action="">
<input type="hidden" name="TipoBusqueda" value="">
<?php include("../principal/encabezado.php")?>
  <table width="800" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top">
	    <table width="800" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr>
            <td width="26" class="Detalle02">
              <input name="OpcConsulta" type="radio" onClick="Recarga('1')" value="F" checked></td>
            <td width="225" align="left" class="Detalle02"><div align="left">Fecha</div></td>
            <td align="right" bgcolor="#FFFFFF"><div align="left">&nbsp;</div></td>
            <td colspan="6" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">Del&nbsp;
                <input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="12" maxlength="10" readonly >
                <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al 
                <input name="TxtFechaFin" type="text" class="InputCen" value="<?php echo $TxtFechaFin; ?>" size="12" maxlength="10" readonly >
                <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"> </td>
            <td width="76" align="right" bgcolor="#FFFFFF"><div align="left"><span class="Detalle01">Periodo:</span></div></td>
            <td align="right">&nbsp;</td>
          <td colspan="5"><select name="CmbMes" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbAno');">
            <?php
	for ($i=1;$i<=12;$i++)
	{
		if (!isset($Mes))
		{
			if ($i == date("n"))
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}	
		else
		{
			if ($i == $Mes)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
	}
?>
          </select>
            <select name="CmbAno" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbSubProducto');">
              <?php
	for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
	{
		if (!isset($Ano))
		{
			if ($i == date("Y"))
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}	
		else
		{
			if ($i == $Ano)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
?>
            </select>
(Solo Conjunto y Proveedor)</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right" bgcolor="#FFFFFF" class="Detalle01"><div align="left">SubProd.:</div></td>
            <td><input name="OpcSF" type="radio"  value="S" checked></td>
          <td colspan="5"><select name="CmbSubProducto" style="width:300" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbFlujos');">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
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
          </tr>
          <tr>
            <td class="Detalle02">
              <input name="OpcConsulta" type="radio" value="L" onClick="Recarga('2')">
            </td>
            <td class="Detalle02"><div align="left">Lotes</div></td>
            <td align="right" bgcolor="#FFFFFF" class="Detalle01"><div align="left">Flujos:</div></td>
            <td width="62"><input name="OpcSF" type="radio"  value="F"></td>
          <td colspan="5"><select name="CmbFlujos" style="width:300"  onKeyDown="TeclaPulsada2('N',false,this.form,'CmbProveedor');">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$Consulta = "select distinct t1.cod_flujo,t1.descripcion,lpad(t1.cod_flujo,3,'0') as orden ";
				$Consulta.= " from age_web.relaciones t0 inner join proyecto_modernizacion.flujos t1 on t0.flujo=t1.cod_flujo";
				$Consulta.= " where t1.esflujo<>'N' and t1.sistema='RAM' ";				
				$Consulta.= " order by orden";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbFlujos == $Fila["cod_flujo"])
						echo "<option selected value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],0,3,STR_PAD_LEFT)."-".$Fila["descripcion"]."</option>";
					else
						echo "<option value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],3,'0',STR_PAD_LEFT)."-".$Fila["descripcion"]."</option>";
				}
			?>
          </select></td>
          </tr>
          <tr>
            <td colspan="2">N&deg; Inicio
                <input name="TxtLoteIni" type="text" class="InputCen" value="<?php echo $TxtLoteIni;?>" size="10" maxlength="6" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtLoteFin');">
&nbsp; N&deg; Final
      <input name="TxtLoteFin" type="text"  class="InputCen" value="<?php echo $TxtLoteFin;?>" size="10" maxlength="6" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbSubProducto');">
            </td>
            <td align="right" bgcolor="#FFFFFF" class="Detalle01"><div align="left">Proveedor:</div></td>
            <td colspan="6"><select name="CmbProveedor" style="width:260" onKeyDown="TeclaPulsada2('N',false,this.form,'BtnConsulta');">
              <option class="NoSelec" value="S">TODOS</option>
              <?php
				$Consulta = "select * from sipa_web.proveedores ";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " where nombre_prv like '%".$TxtFiltroPrv."%' ";  					
				$Consulta.= "order by trim(nombre_prv)";   
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["rut_prv"])
						echo "<option selected value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>";
					else
						echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>";
				}
			?>
            </select>
              Filtro
              <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
              <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">
            </td>
          </tr>
          <tr>
            <td>&nbsp; </td>
            <td>&nbsp;</td>
            <td align="right" bgcolor="#FFFFFF"><div align="left"><span class="Estilo1">Ver Datos por:</span></div></td>
            <td align="right">Lote: </td>
          <td><input name="OpcTR" type="radio" value="T" checked></td>
          <td>Recargos:</td>
          <td><input name="OpcTR" type="radio" value="R"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="Detalle02"><input name="OpcConsulta" type="radio" value="C" onClick="Recarga('3')"></td>
            <td class="Detalle02">Conjuntos</td>
            <td align="right" bgcolor="#FFFFFF"><div align="left"><span class="Estilo1">Detalle Por:</span></div></td>
            <td align="right">Peso:</td>
          <td width="22"><input name="OpcHLF" type="radio" value="P" checked></td>
            <td width="60" align="right">Leyes:</td>
            <td width="24"><input name="OpcHLF" type="radio" value="L"></td>
          <td width="37" align="right">Finos:</td>
          <td width="143"><input name="OpcHLF" type="radio" value="F"></td>
          </tr>
          <tr>
            <td colspan="2">N&deg; Inicio
                <input name="TxtConjIni" type="text"  class="InputCen" value="<?php echo $TxtConjIni;?>" size="10" maxlength="6" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtConjFin');">
&nbsp; N&deg; Final
      <input name="TxtConjFin" type="text" class="InputCen" value="<?php echo $TxtConjFin;?>" size="10" maxlength="6" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbMes');">
            </td>
            <td colspan="7" align="center" bgcolor="#FFFFFF" class="Detalle01"><strong>Secci&oacute;n Opcional (Por Defecto se Muestra Todo) </strong></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
            <td align="right" bgcolor="#FFFFFF" class="Detalle01"><div align="left">
              <div align="left" class="Detalle01">Definir Leyes:</div>
            </div></td>
            <td colspan="6" class="Detalle01"><input name="BtnLeyes" type="button" id="BtnLeyes2" value="Definir" readonly="true" onClick="CargaParametros('LEY')">
              <input name="TxtLeyesMuestra" type="text" class="InputColor" size="50" readonly="true"><input name="TxtCodLeyes" type="hidden" value=""></td>
          </tr>
          <tr>
            <td class="Detalle02"><input name="OpcConsulta" type="radio" value="P" onClick="Recarga('4')"></td>
            <td class="Detalle02">Proveedor</td>
            <td align="right" bgcolor="#FFFFFF" class="Detalle01"><div align="left">Limites:</div></td>
            <td colspan="6" class="Detalle01">
			  <input name="BtnLimites" type="button" id="BtnLimites2" value="Definir" onClick="CargaParametros('LIM')">
              <input name="TxtLimitesMuestra" type="text" class="InputColor" size="50"><input name="TxtCodLimites" type="hidden" value=""></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="7" align="right" bgcolor="#FFFFFF" class="Detalle01"><div align="left">&nbsp;</div></td>
          </tr>
        </table>
	    <br>
	  <table width="800" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
        <tr>
          <td align="center"><input name="BtnConsulta" type="button" value="Consultar" onClick="Consulta('W')">
            <input name="BtnExcel" type="button" value="Excel"style="width:70" onClick="Consulta('E')">
            <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();"></td>
        </tr>
      </table>	  <br>  </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>