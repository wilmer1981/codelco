<?php
	include("../principal/conectar_principal.php"); 

	if(isset($_REQUEST["Proc"])){
		$Proc = $_REQUEST["Proc"];
	}else{
		$Proc = '';
	}
	$TipoConsulta  = isset($_REQUEST["TipoConsulta"])?$_REQUEST["TipoConsulta"]:"";

	if(isset($_REQUEST["TxtValores"])){
		$TxtValores = $_REQUEST["TxtValores"];
	}else{
		$TxtValores = '';
	}
	if(isset($_REQUEST["TipoRegistro"])){
		$TipoRegistro = $_REQUEST["TipoRegistro"];
	}else{
		$TipoRegistro = '';
	}

	if(isset($_REQUEST["TxtConjunto"])){
		$TxtConjunto = $_REQUEST["TxtConjunto"];
	}else{
		$TxtConjunto = '';
	}
	if(isset($_REQUEST["CmbEstadoLote"])){
		$CmbEstadoLote = $_REQUEST["CmbEstadoLote"];
	}else{
		$CmbEstadoLote = '';
	}
	if(isset($_REQUEST["CmbClaseProducto"])){
		$CmbClaseProducto = $_REQUEST["CmbClaseProducto"];
	}else{
		$CmbClaseProducto = '';
	}
	if(isset($_REQUEST["EstOpe"])){
		$EstOpe= $_REQUEST["EstOpe"];
	}else{
		$EstOpe = '';
	}
	if(isset($_REQUEST["Mensaje"])){
		$Mensaje = $_REQUEST["Mensaje"];
	}else{
		$Mensaje = '';
	}
	

	/*************************************************** */

	if ($Proc == "OM")
	{
		/*$EstadoInput = "readonly";
		$Datos=explode('-',$TxtValores);
		$Consulta = "SELECT * from sipa_web.recepciones where lote = '".$Datos[0]."'";
		//echo $Consulta;
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$TxtLote = $Fila["lote"];
			$CmbClaseProducto = $Fila["cod_clase"];
			$TxtConjunto = $Fila["conjunto"];
			$CmbEstadoLote = $Fila["estado"];
			$TxtCorrelativo = $Fila["correlativo"];
			$ChkFinLote = $Fila["ult_registro"];
		}*/
	}
?>
<html>
<head>
<title>Sistema de Recepciones</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "G":
			if (f.CmbEstadoLote.value=="S" && f.CmbClaseProducto.value=="S"&&f.TxtConjunto.value=='')
			{
				alert("No ha seleccionado NADA para Modificar");
				return;
			}
			f.action = "rec_adm_lote01.php?TipoConsulta=<?php echo $TipoConsulta; ?>&Proceso=OM";
			f.submit();
			break;
		case "S":
		    window.opener.document.frmPrincipal.action = "rec_adm_lote.php?TipoCon=<?php echo $TipoConsulta; ?>";
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<form name="frmProceso" method="post" action="">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="TipoRegistro" value="<?php echo $TipoRegistro; ?>">
<input type="hidden" name="TxtValores" value="<?php echo $TxtValores; ?>">
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
    <td class="Colum01"><SELECT name="CmbEstadoLote" class="Select01" id="CmbEstadoLote"  onkeydown="TeclaPulsada2('N',true,this.form,'CmbProveedor');">
      <option value="S" class="NoSelec">SELECCIONAR</option>
    	<?php
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase='24001' order by cod_subclase";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($Fila["valor_subclase1"]==$CmbEstadoLote)
				echo "<option SELECTed value='".$Fila["valor_subclase1"]."'>".$Fila["nombre_subclase"]."</option>\n";
			else
				echo "<option value='".$Fila["valor_subclase1"]."'>".$Fila["nombre_subclase"]."</option>\n";
		}
		?>
    </SELECT></td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Num. Conjunto:</td>
    <td class="Colum01"><input name="TxtConjunto" type="text" class="InputDer" id="TxtConjunto2" value="<?php echo $TxtConjunto; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbSubProducto');"></td>
  </tr>
  <tr class="Colum01">
    <?php
		if($TipoRegistro=='R')
		{
	?>
	<td class="Colum01">Clase Producto:</td>
    <td width="376" class="Colum01"><SELECT name="CmbClaseProducto" class="Select01" onKeyDown="TeclaPulsada2('N',true,this.form,'CmbCodRecepcion');">
	<option value="S" class="NoSelec">SELECCIONAR</option>
    <?php
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase='15001' order by nombre_subclase";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["nombre_subclase"]==$CmbClaseProducto)
			echo "<option SELECTed value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";
		else
			echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";
	}
    ?>
    </SELECT>
	</td>
	<?php
		}
		else
		{
	?>
	<td class="Colum01">&nbsp;</td>
	<td class="Colum01">&nbsp;</td>
	<?php
	}
	?>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">&nbsp;</td>
    <td class="Colum01">&nbsp;</td>
  </tr>
  <tr align="center" class="Colum01">
    <td height="30" colspan="2" class="Colum01"><input name="BtnGuardar" type="button" id="BtnGuardar3" value="Guardar" style="width:70px " onClick="Proceso('G')">      
      <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
</table>
</form>
</body>
</html>
