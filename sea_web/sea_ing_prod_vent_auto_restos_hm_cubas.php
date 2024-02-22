<?php
	include("../principal/conectar_principal.php");

	//GrupoProd=2&DiaProd=3&MesProd=1&AnoProd=2024&Cubas=
	if(isset($_REQUEST["GrupoProd"])) {
		$GrupoProd = $_REQUEST["GrupoProd"];
	}else{
		$GrupoProd = "";
	}
	if(isset($_REQUEST["DiaProd"])) {
		$DiaProd = $_REQUEST["DiaProd"];
	}else{
		$DiaProd = "";
	}
	if(isset($_REQUEST["MesProd"])) {
		$MesProd = $_REQUEST["MesProd"];
	}else{
		$MesProd = "";
	}
	if(isset($_REQUEST["AnoProd"])) {
		$AnoProd = $_REQUEST["AnoProd"];
	}else{
		$AnoProd = "";
	}
	if(isset($_REQUEST["Cubas"])) {
		$Cubas = $_REQUEST["Cubas"];
	}else{
		$Cubas = "";
	}

	$FechaProduccion = $AnoProd."-".str_pad($MesProd,2,"0",STR_PAD_LEFT)."-".str_pad($DiaProd,2,"0",STR_PAD_LEFT); 

	if(isset($_REQUEST["TipoPesaje"])) {
		$TipoPesaje = $_REQUEST["TipoPesaje"];
	}else{
		$TipoPesaje = "";
	}

	
?>
<html>
<head>
<title>Definir Cubas Para Pesaje</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style>
<script language="javascript">
function TeclaPulsada(salto) 
{ 
	var f = document.frmCubas;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}

function Proceso(opt)
{
	var f = document.frmCubas;
	switch (opt)
	{
		case "G_Cuba_RestosHM":
			
			if (f.Cuba.value == "")
			{
				f.Cuba.value = 0;				
			}
			f.Cuba.value = parseInt(f.Cuba.value);
			if (parseInt(f.Cuba.value) < 1 || parseInt(f.Cuba.value >48))
			{
				alert("Las Cubas deben ser de 1 a 48");
				f.Cuba.focus();
				return;
			}
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=" + opt;
			f.submit();
			break;
		case "E_Cuba_RestosHM":
			var FechaHoraElim = "";
			var FechaCarga = "";
			var GrupoElim = <?php echo $GrupoProd; ?>;
			var CubaElim = "";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name == "ChkCuba" && f.elements[i].checked)
				{										
					var CubaElim = f.elements[i].value;
					var Grupoelim = f.elements[i+1].value;
					var FechaHoraElim = f.elements[i+2].value;
					var FechaCarga = f.elements[i+3].value;
				}
			}
			if (CubaElim == "")
			{
				alert("No hay ninguna Cuba seleccionada para Eliminar");
				return;
			}
			else
			{
				var msg = confirm("�Seguro que desea Eliminar esta Cuba?");
				if (msg==true)
				{
					f.action = "sea_ing_prod_vent_auto01.php?Proceso=E_Cuba_RestosHM&GrupoElim=" + GrupoElim + "&CubaElim=" + CubaElim + "&FechaCarga=" + FechaCarga + "&FechaHoraElim=" + FechaHoraElim;
					f.submit();
				}
				else
				{
					return;
				}
			}
			break;
		case "S":
			window.opener.formulario.action = "sea_ing_prod_vent_auto.php?TipoPesaje=3";
			window.opener.formulario.submit();
			window.close();
			break;
		case "I":
			f.BtnGrabar.style.visibility = "hidden";
			f.BtnEliminar.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnGrabar.style.visibility = "";
			f.BtnEliminar.style.visibility = "";
			f.BtnImprimir.style.visibility = "";
			f.BtnSalir.style.visibility = "";
			break;
		case "E_Cuba_RestosHM":
			break;
			
	}
}
</script>
</head>

<body onLoad="document.frmCubas.Cuba.focus();">
<form name="frmCubas" action="" method="post">
  <table width="400" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr align="center">
      <td colspan="5"><strong>CUBAS A PRODUCIR EN EL DIA</strong></td>
    </tr>
    <tr>
      <td colspan="5"><input type="hidden" name="GrupoProd" value="<?php echo $GrupoProd; ?>">
      <input type="hidden" name="FechaProduccion" value="<?php echo $FechaProduccion; ?>">
      &nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">Fecha Produccion: <?php echo $FechaProduccion; ?> </td>
    </tr>
    <tr>
      <td colspan="5">Grupo: <?php echo str_pad($GrupoProd,2,"0",STR_PAD_LEFT); ?> </td>
    </tr>
    <tr>
      <td colspan="5">Numero de Cuba:
      <input name="Cuba" type="text" id="Cuba" size="10" maxlength="3" onKeyDown="TeclaPulsada('BtnGrabar')">      </td>
    </tr>
    <tr align="center">
      <td colspan="5"><input name="BtnGrabar" type="button" id="BtnGrabar4" value="Grabar" style="width:70px " onClick="Proceso('G_Cuba_RestosHM')">
        <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:70px " onClick="Proceso('E_Cuba_RestosHM')">
        <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
        <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
    <tr class="ColorTabla01" align="center">
      <td width="29"><div align="center">&nbsp;</div></td>
      <td width="29">Cuba</td>
      <td width="110"><div align="center">Fecha Carga </div></td>
      <td width="74"><div align="center">Unidades</div></td>
      <td width="104"><div align="center">Peso</div></td>
    </tr>
<?php	
	$Consulta = "SELECT distinct cod_producto, cod_subproducto, fecha, unidades, peso, fecha_carga, ";
	$Consulta.= " case when length(cod_subproducto)=1 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
	$Consulta.= " from sea_web.detalle_pesaje ";
	$Consulta.= " where tipo_pesaje = 'RHM'";
	$Consulta.= " and cod_producto = '".$GrupoProd."'";
	$Consulta.= " and estado = 'C'";
	$Consulta.= " and fecha between '".$FechaProduccion." 00:00:00' and '".$FechaProduccion." 23:59:59'";
	$Consulta.= " order by orden ";
	$Resp = mysqli_query($link, $Consulta);
	$TotalUnidades=0;
	$TotalPeso=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr align='center'>\n";
		echo "<td align='center'><input type='radio' name='ChkCuba' value='".$Fila["cod_subproducto"]."'>\n";
		echo "<input type='hidden' name='ChkGrupo' value='".$Fila["cod_producto"]."'>\n";
		echo "<input type='hidden' name='ChkFechaHora' value='".$Fila["fecha"]."'></td>\n";
		echo "<input type='hidden' name='ChkFechaCarga' value='".$Fila["fecha_carga"]."'></td>\n";
		echo "<td align='center'>".$Fila["cod_subproducto"]."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_carga"],8,2)."-".substr($Fila["fecha_carga"],5,2)."-".substr($Fila["fecha_carga"],0,4)."</td>\n";
		echo "<td align='center'>".number_format($Fila["unidades"],0,",",".")."</td>\n";
		echo "<td align='center'>".number_format($Fila["peso"],0,",",".")."</td>\n";
		echo "</tr>\n";
		$TotalUnidades = $TotalUnidades + $Fila["unidades"];
		$TotalPeso = $TotalPeso + $Fila["peso"];
	}
	echo "<tr>\n";
	echo "<td colspan='3'><strong>TOTAL</strong></td>\n";
	echo "<td align='center'>".number_format($TotalUnidades,0,",",".")."</td>\n";
	echo "<td align='center'>".number_format($TotalPeso,0,",",".")."</td>\n";
	echo "</tr>\n";
?>	
  </table>

</form>
</body>
</html>
