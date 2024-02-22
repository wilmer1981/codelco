<?php include("../principal/conectar_principal.php"); ?>
<html>
<head>
<title>Sistema de Agencia</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmPopUp;
	switch (opt)
	{
		case "S":
			window.close();
			break;
		case "R":
			f.action="age_ing_limites03.php";
			f.submit();
			break;
		case "I":
			f.BtnImprimir.style.visibility="hidden";
			f.BtnSalir.style.visibility="hidden";
			window.print();
			f.BtnImprimir.style.visibility="visible";
			f.BtnSalir.style.visibility="visible";
			break;
	}
}

function Recarga(tip, subprod, rutprov, plantilla)
{
	var f=document.frmPrincipal;
	window.opener.document.location="age_ing_limites.php?ChkTipo="+tip+"&SubProducto="+subprod+"&Proveedor="+rutprov+"&Plantilla="+plantilla;
	//window.opener.document.frmPrincipal.submit();
	window.close();
}

</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<form name="frmPopUp" action="" method="post">
<div align="center">
  <?php
	switch ($Tipo)
	{
		case "L":		
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='L' checked><strong>Limite de Control &nbsp;&nbsp;&nbsp;&nbsp;</strong>\n";
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='P'>Penalidad\n";
			break;
		case "P":
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='L'>Limite de Control &nbsp;&nbsp;&nbsp;&nbsp;\n";
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='P' checked><strong>Penalidad</strong>\n";
			break;
		default:
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='L' checked><strong>Limite de Control &nbsp;&nbsp;&nbsp;&nbsp;</strong>\n";
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='P'>Penalidad\n";
			break;
	}
?>
  <br>
  <br>
  <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
  <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')">
  <br>
  <br>
</div>
<?php
	$ArrLeyes = array();
	$Consulta = "select distinct t1.cod_leyes, t2.abreviatura ";
	$Consulta.= " from age_web.limites t1 inner join proyecto_modernizacion.leyes t2 ";	
	$Consulta.= " on t1.cod_leyes=t2.cod_leyes ";
	if (isset($CodPlantilla) && $CodPlantilla!="S")
		$Consulta.= " where t1.cod_plantilla='".$CodPlantilla."'";
	$Consulta.= " order by t1.cod_leyes";
	$Resp = mysqli_query($link, $Consulta);
	$CantLeyes=0;
	while ($Fila =mysqli_fetch_array($Resp))
	{
		$ArrLeyes[$Fila["cod_leyes"]]["cod_leyes"] = $Fila["cod_leyes"];
		$ArrLeyes[$Fila["cod_leyes"]]["abreviatura"] = $Fila["abreviatura"];
		$ArrLeyes[$Fila["cod_leyes"]]["minimo"] = "";
		$ArrLeyes[$Fila["cod_leyes"]]["medio"] = "";
		$ArrLeyes[$Fila["cod_leyes"]]["maximo"] = "";
		$CantLeyes++;
	}
	$LargoTabla=450+($CantLeyes*150)
?>
<table width="<?php echo $LargoTabla; ?>" border="1" align="center" cellpadding="1" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01">
<?php  
	if ($SoloVer!="S")
    	echo "<td width='31' rowspan='2'>Selec.</td>\n";
?>	
    <td width="88" rowspan="2">SubProducto</td>
    <td width="150" rowspan="2">Proveedor</td>
    <td width="200" rowspan="2">Plantilla</td>
    
<?php  	
	reset($ArrLeyes);
	while (list($k,$v)=each($ArrLeyes))
	{
		echo "<td colspan='3' align='center'>".$v["abreviatura"]."</td>\n";  		
	}
	echo "</tr>\n";
	echo "<tr class='ColorTabla01'>\n";
	for ($i=1;$i<=count($ArrLeyes);$i++)
	{		
		echo "<td width='50' align='center'>Min</td>\n";
		echo "<td width='50' align='center'>Prom</td>\n";
		echo "<td width='50' align='center'>Max</td>\n";
	}
	echo "</tr>\n";
	$Consulta = "select distinct t1.cod_plantilla, t1.descripcion, t1.cod_producto, t1.cod_subproducto, t2.abreviatura as nom_subprod, t1.rut_proveedor, t3.nomprv_a as nom_prov ";
	$Consulta.= " from age_web.limites t1 left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto left join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a ";
	$Consulta.= " where t1.tipo='".$Tipo."' ";
	if (isset($CodPlantilla) && $CodPlantilla!="S")
		$Consulta.= " and t1.cod_plantilla='".$CodPlantilla."'";
	$Consulta.= " order by t1.cod_producto, lpad(t1.cod_subproducto,3,'0'), t1.descripcion";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr>\n";
		if ($Fila["cod_subproducto"]=="0")
			$CodSubProd="S";
		else
			$CodSubProd=$Fila["cod_subproducto"];
		if ($Fila["rut_proveedor"]=="99999999-9")
			$RutProv="S";
		else
			$RutProv=$Fila["rut_proveedor"];
		if ($SoloVer!="S")
			echo "<td align='center'><input type='radio' name='ChkPlantilla' value='' onClick=\"Recarga('".$Tipo."','".$CodSubProd."','".$RutProv."','".$Fila["cod_plantilla"]."')\"></td>\n";
		if ($Fila["cod_subproducto"]!="0")
			echo "<td >".$Fila["nom_subprod"]."</td>\n";
		else
			echo "<td >GENERICA</td>\n";
		if ($Fila["rut_proveedor"]!= "99999999-9")
			echo "<td >".substr($Fila["nom_prov"],0,20)."</td>\n";
		else
			echo "<td >GENERICA</td>\n";
		echo "<td >".$Fila["descripcion"]."</td>\n";
		reset($ArrLeyes);
		$Color="";
		while (list($k,$v)=each($ArrLeyes))
		{
			if ($Color=="#FFFFFF")
				$Color="";
			else
				$Color="#FFFFFF";
			$LimiteMin = "";
			$LimiteMed = "";
			$LimiteMax = "";
			$Consulta = "select  * from age_web.limites ";
			$Consulta.= " where cod_plantilla = '".$Fila["cod_plantilla"]."'";
			$Consulta.= " and cod_leyes = '".$v["cod_leyes"]."'";
			$RespAux = mysqli_query($link, $Consulta);
			if ($FilaAux = mysqli_fetch_array($RespAux))
			{
				$LimiteMin = $FilaAux["limite_minimo"];
				$LimiteMed = $FilaAux["limite_medio"];
				$LimiteMax = $FilaAux["limite_maximo"];
			}
			if ($LimiteMin!="")
				echo "<td align='right' bgcolor='".$Color."'>".number_format($LimiteMin,2,',','.')."</td>\n";
			else
				echo "<td align='right' bgcolor='".$Color."'>&nbsp;</td>\n";
			if ($LimiteMed!="")
				echo "<td align='right' bgcolor='".$Color."'>".number_format($LimiteMed,2,',','.')."</td>\n";
			else
				echo "<td align='right' bgcolor='".$Color."'>&nbsp;</td>\n";
			if ($LimiteMax!="")
				echo "<td align='right' bgcolor='".$Color."'>".number_format($LimiteMax,2,',','.')."</td>\n";
			else
				echo "<td align='right' bgcolor='".$Color."'>&nbsp;</td>\n";
		}
		echo "</tr>\n";
	}
?>  
</table>
</form>
</body>
</html>
