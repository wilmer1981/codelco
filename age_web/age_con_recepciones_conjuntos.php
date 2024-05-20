<?php 	
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 74;
	include("../principal/conectar_principal.php");

	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor   = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$OptLeyes = isset($_REQUEST["OptLeyes"])?$_REQUEST["OptLeyes"]:"";
	$OptFinos = isset($_REQUEST["OptFinos"])?$_REQUEST["OptFinos"]:"";
	$TxtFiltroPrv  = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$TxtConjIni = isset($_REQUEST["TxtConjIni"])?$_REQUEST["TxtConjIni"]:"";
	$TxtConjFin = isset($_REQUEST["TxtConjFin"])?$_REQUEST["TxtConjFin"]:"";
	$TxtFechaIni = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:date('Y-m')."-01";
	$TxtFechaFin = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:date('Y-m')."-".date('t');


?>
<html>
<head>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Recarga3()
{
	var Frm = frmPrincipal;
	Frm.action="age_con_recepciones_conjuntos.php?Busq=S";
	Frm.submit();	
}
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			if (f.TxtConjIni.value != "" && f.TxtConjFin.value=="")
				f.TxtConjFin.value =f.TxtConjIni.value;
			f.action="age_con_recepciones_conjuntos_web.php";
			f.submit();
			break;
		case "E":
			if (f.TxtConjIni.value != "" && f.TxtConjFin.value=="")
				f.TxtConjFin.value =f.TxtConjIni.value;
			f.action="age_con_recepciones_conjuntos_excel.php";
			f.submit();
			break;
		case "R":
			f.action="age_con_recepciones_conjuntos.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=70&Nivel=1";
			f.submit();
			break;
	}
}
</script>
<title>Agencia Ventanas</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="middle">
	  <table width="650" border="1" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr>
            <td class="Detalle02">&gt;&gt;Periodo:</td>
            <td align="left">
              <input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="13" maxlength="10" readonly >
              <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al
              <input name="TxtFechaFin" type="text" class="InputCen" value="<?php echo $TxtFechaFin; ?>" size="13" maxlength="10" readonly >
              <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"> </td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;SubProducto:</td>
            <td align="left"><select name="CmbSubProducto" style="width:300" onKeyDown="TeclaPulsada2('N',false,this.form,'CmbFlujos');" onChange="Proceso('R')">
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
            <td class="Detalle02">&gt;&gt;Proveedor:</td>
            <td align="left"><select name="CmbProveedor" style="width:300" onkeydown="TeclaPulsada2('N',false,this.form,'BtnConsulta');">
              <option class="NoSelec" value="S">TODOS</option>
              <?php
				$Consulta = "select distinct t1.rut_proveedor, t2.nombre_prv as nomprv_a ";
				$Consulta.= " from age_web.relaciones t1 left join sipa_web.proveedores t2 on t1.rut_proveedor = t2.rut_prv ";
				$Consulta.= " where t1.cod_producto='1' ";	
				if (isset($CmbSubProducto) && $CmbSubProducto!="S")
				{
					$Consulta.= " and t1.cod_subproducto= '".$CmbSubProducto."' ";
				}
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t2.nombre_prv like '%".$TxtFiltroPrv."%' ";					
				$Consulta.= " order by t2.nombre_prv";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["rut_proveedor"])
						echo "<option selected value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
					else
						echo "<option value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
				}
			?>
            </select>
              ---> Filtro Prv&nbsp;
              <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
              <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">
            </td>
          </tr>
          <tr>
            <td class="Detalle02">&gt;&gt;Conjunto:</td>
            <td align="left"><input name="TxtConjIni" type="text"  class="InputCen" value="<?php echo $TxtConjIni;?>" size="10" maxlength="6" onKeyDown="TeclaPulsada2('S',false,this.form,'TxtConjFin');">
 al
   <input name="TxtConjFin" type="text" class="InputCen" value="<?php echo $TxtConjFin;?>" size="10" maxlength="6" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbMes');"></td>
          </tr>
          <tr> 
            <td width="109" class="Detalle02">&gt;&gt;Ver:</td>
            <td width="481" align="left">
<?php
	if ($OptLeyes=="S")
	{
		echo '<input name="OptLeyes" type="checkbox" id="OptLeyes" value="S" checked>Leyes&nbsp;&nbsp;';
	}
	else
	{
		if (!isset($OptLeyes)) 
			echo '<input name="OptLeyes" type="checkbox" id="OptLeyes" value="S" checked>Leyes&nbsp;&nbsp;';
		else
			echo '<input name="OptLeyes" type="checkbox" id="OptLeyes" value="S">Leyes&nbsp;&nbsp;';
	}
	if ($OptFinos=="S")
	{
		echo '<input name="OptFinos" type="checkbox" id="OptFinos" value="S" checked>Finos';
	}
	else
	{
		if (!isset($OptFinos))
			echo '<input name="OptFinos" type="checkbox" id="OptFinos" value="S" checked>Finos';
		else
			echo '<input name="OptFinos" type="checkbox" id="OptFinos" value="S">Finos';
	}
?>
</td></tr>
          <tr align="center"> 
            <td height="30" colspan="2">   
              <input type="button" name="BtnConsulta" value="Consulta" style="width:70" onClick="Proceso('C');">
			  <input type="button" name="BtnExcel" value="Excel" style="width:70" onClick="Proceso('E');">
		    <input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');"></td>
          </tr>
        </table>
        <br> 
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if ($EncontroRelacion==true)
	{
		echo "<script languaje='javascript'>";
		echo "alert('Algunos Elementos No Fueron Eliminados por Tener SubClases Asociadas');";
		echo "</script>";
	}
?>