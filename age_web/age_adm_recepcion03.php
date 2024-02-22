<?php
	include("../principal/conectar_principal.php"); 
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
			$TxtLote = $Fila["lote"];
			$CmbSubProducto = $Fila["cod_subproducto"];
			$CmbProveedor = $Fila["rut_proveedor"];
			$CmbCodFaena = $Fila["cod_faena"];
			$CmbCodRecepcion = $Fila["cod_recepcion"];
			$CmbClaseProducto = $Fila["clase_producto"];
			$TxtConjunto = $Fila["num_conjunto"];
			$ChkRemuestreo = $Fila["remuestreo"];
			$TxtLoteRemuestreo = $Fila["num_lote_remuestreo"];
			$CmbEstadoLote = $Fila["estado_lote"];
			$CmbEstadoRecargo = $Fila["estado_recargo"];
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
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "G":
			if (f.CmbEstadoRecargo.value=="S" && f.CmbAutorizado.value=="T" 
				&& f.CmbClaseProducto.value=="S" && f.CmbCodRecepcion.value=="S" && f.CmbCodRecepcionENM.value=="S")
			{
				alert("No ha seleccionado NADA para Modificar");
				return;
			}
			f.action = "age_adm_recepcion01.php?Proceso=OM";
			f.submit();
			break;
		case "S":
<?php
	if ($Pag=="Lotes")		
		echo "window.opener.document.frmPrincipal.action = 'age_adm_lotes.php'";
	else
		echo "window.opener.document.frmPrincipal.action = 'age_adm_recepcion.php?TipoCon='+f.TipoConsulta.value;";		
?>			
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
<form name="frmProceso" method="post" action="">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<input type="hidden" name="Pag" value="<?php echo $Pag; ?>">
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="2"><strong>OPERACIONES MASIVAS </strong></td>
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
  <tr class="Colum01">
    <td width="109" class="Colum01">Lote(s):</td>
    <td class="Colum01"><?php echo str_replace("//","; ",$TxtValores); ?><input name="TxtValores" type="hidden" value="<?php echo $TxtValores; ?>"></td>
    </tr>
  <tr class="ColorTabla02">
    <td colspan="2" class="Colum01"><strong>VALORES A MODIFICAR </strong></td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Estado de Recargo:</td>
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
  <tr class="Colum01">
    <td class="Colum01">Autorizado:</td>
    <td class="Colum01"><select name="CmbAutorizado"><?php
	switch ($CmbAutorizado)
	{
		case "S":
			echo "<option value='T' class='NoSelec'>SELECCIONAR</option>\n";
			echo "<option selected value='S'>SI</option>\n";
			echo "<option value='N'>NO</option>\n";
			echo "<option value='R'>REENVIO</option>\n";
			break;
		case "N":
			echo "<option value='T' class='NoSelec'>SELECCIONAR</option>\n";
			echo "<option value='S'>SI</option>\n";
			echo "<option selected value='N'>NO</option>\n";
			echo "<option value='R'>REENVIO</option>\n";
			break;
		case "R":
			echo "<option value='T' class='NoSelec'>SELECCIONAR</option>\n";
			echo "<option value='S'>SI</option>\n";
			echo "<option value='N'>NO</option>\n";
			echo "<option selected value='R'>REENVIO</option>\n";
			break;
		default:
			echo "<option selected value='T' class='NoSelec'>SELECCIONAR</option>\n";
			echo "<option value='S'>SI</option>\n";
			echo "<option value='N'>NO</option>\n";
			echo "<option value='R'>REENVIO</option>\n";
			break;
			break;
	}
?>
      </select></td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Clase Producto:</td>
    <td width="376" class="Colum01"><select name="CmbClaseProducto" class="Select01" onKeyDown="TeclaPulsada2('N',true,this.form,'CmbCodRecepcion');">
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
    <td class="Colum01">Cod.Recepcion:</td>
    <td class="Colum01"><select name="CmbCodRecepcion" class="Select01" onkeydown="TeclaPulsada2('N',true,this.form,'CmbCodRecepcionENM');">
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
    <td class="Colum01">Cod.Recep. ENM:</td>
    <td class="Colum01"><select name="CmbCodRecepcionENM" class="Select01" id="CmbCodRecepcionENM" onkeydown="TeclaPulsada2('N',true,this.form,'');">
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
  <tr align="center" class="Colum01">
    <td height="30" colspan="2" class="Colum01"><input name="BtnGuardar" type="button" id="BtnGuardar3" value="Guardar" style="width:70px " onClick="Proceso('G')">      
      <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
</table>
</form>
</body>
</html>
