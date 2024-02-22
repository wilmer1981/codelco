<?php
	include("../principal/conectar_principal.php");
	window.open("sea_resumen_inspeccion_detalle.php?Defecto="+defec+"&Horno="+horno,"","top=50,left=50,width=550,height=400,scrollbars=yes,resizable = yes");


	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano =  date("Y");
	}
	if(isset($_REQUEST["Mes"])) {
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes =  date("m");
	}
	if(isset($_REQUEST["Producto"])) {
		$Producto = $_REQUEST["Producto"];
	}else{
		$Producto =  "";
	}
	if(isset($_REQUEST["SubProducto"])) {
		$SubProducto = $_REQUEST["SubProducto"];
	}else{
		$SubProducto =  "";
	}
	if(isset($_REQUEST["Defecto"])) {
		$Defecto = $_REQUEST["Defecto"];
	}else{
		$Defecto =  "";
	}
	if(isset($_REQUEST["Horno"])) {
		$Horno = $_REQUEST["Horno"];
	}else{
		$Horno =  "";
	}


	//NOMBRE SUBPRODUCTO
	$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomSubProducto = $Fila["descripcion"];
	else	$NomSubProducto = "&nbsp;";
	//NOMBRE DEFECTO
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='2008' and cod_subclase='".$Defecto."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomDefecto = $Fila["nombre_subclase"];
	else	$NomDefecto = "&nbsp;";	
?>
<html>
<head>
<title>Detalle Inspeccion</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style>
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmDetalle;
	switch (opt)
	{
		case "I":
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnExcel.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnImprimir.style.visibility = "visible";
			f.BtnExcel.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break
		case "S":
			window.close();
			break;
		case "E":
			f.action = "sea_resumen_inspeccion_detalle_excel.php?Ano=<?php echo $Ano ?>&Mes=<?php echo $Mes ?>&Producto=<?php echo $Producto ?>&SubProducto=<?php echo $SubProducto ?>&Defecto=<?php echo $Defecto ?>&Horno=<?php echo $Horno ?>";
			f.submit();
			break;
	}
}
</script>
</head>

<body>
<form name="frmDetalle" action="" method="post">
<table width="450" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr align="center">
    <td colspan="2"><strong>DETALLE INSPECCION DE ACUERDO A DEFECTO </strong></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="105">SUBPRODUCTO</td>
    <td width="327"><?php echo $NomSubProducto; ?></td>
  </tr>
  <tr>
    <td>DEFECTO</td>
    <td><?php echo $NomDefecto; ?></td>
  </tr>
<?php  
	if ($Producto == 17 && ($SubProducto==4 || $SubProducto==8))
	{
		echo "<tr>\n";
		echo "<td>HORNO</td>\n";
		echo "<td>";
		switch ($Horno)
		{
			case 1:
				echo "HORNO 1";
				break;
			case 2:
				echo "HORNO 2";
				break;
			case 4:
				echo "HORNO BASC.";
				break;
			case "T":
				echo "TODOS";
				break;
		}
		echo "</td>\n";
		echo "</tr>\n";
	}
?> 
  <tr align="center">
    <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnExcel" type="button" id="BtnExcel" value="Excel" style="width:70px " onClick="Proceso('E')">
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
<br>
<br>
<table width="470" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td width="63">Hornada</td>
    <td width="83">Recuperables</td>
    <td width="67">Rechazados</td>
    <td width="67">Total</td>
    <td width="114">Fecha</td>
<?php	
	if ($Producto == 17 && ($SubProducto==4 || $SubProducto==8))
   		echo "<td width='91'>Rueda</td>\n";
?>	
  </tr>
<?php  
	$Consulta = "SELECT * from sea_web.rechazos ";
	$Consulta.= " where fecha_ini between '".$Ano."-".$Mes."-01 00:00:00' and '".$Ano."-".$Mes."-31 23:59:59'";
	$Consulta.= " and cod_defecto = '".$Defecto."'";
	$Consulta.= " and cod_producto = '".$Producto."' and cod_subproducto='".$SubProducto."' ";
	if (($Producto == 17 && ($SubProducto==4 || $SubProducto==8)) && ($Horno<>"T"))
		{
			switch ($Horno)
			{
				case "1":
					$Consulta.= " and substring(hornada,7) between '1000' and '1999'";		
					break;
				case "2":
					$Consulta.= " and substring(hornada,7) between '2000' and '2999'";		
					break;
				case "4":
					$Consulta.= " and substring(hornada,7) between '4000' and '4999'";		
					break;
			}
		}
	$Consulta.= " and (recuperables<>0 or rechazados<>0)";
	$Consulta.= " order by rueda, fecha_ini, hornada";
	$Resp = mysqli_query($link, $Consulta);
	$TotalRecu=0;
	$TotalRech=0;
	$Total=0;	
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr align='right'>\n";
		echo "<td align='center'>".substr($Fila["hornada"],6)."</td>\n";
		echo "<td>".$Fila["recuperables"]."</td>\n";
		echo "<td>".$Fila["rechazados"]."</td>\n";
		echo "<td>".($Fila["recuperables"] + $Fila["rechazados"])."</td>\n";
		echo "<td>".substr($Fila["fecha_ini"],8,2)."-".substr($Fila["fecha_ini"],5,2)."-".substr($Fila["fecha_ini"],0,4)."</td>\n";
		if ($Producto == 17 && ($SubProducto==4 || $SubProducto==8))
			echo "<td>".$Fila["rueda"]."</td>\n";
		echo "</tr>\n";
		$TotalRecu=$TotalRecu + $Fila["recuperables"];
		$TotalRech=$TotalRech + $Fila["rechazados"];
		$Total=$Total + ($Fila["recuperables"] + $Fila["rechazados"]);		
	}
?>
  <tr align="right" class="ColorTabla02">
    <td align="center">TOTAL</td>
    <td><?php echo number_format($TotalRecu,0,",","."); ?></td>
    <td><?php echo number_format($TotalRech,0,",","."); ?></td>
    <td><?php echo number_format($Total,0,",","."); ?></td>
<?php	
	if ($Producto == 17 && ($SubProducto==4 || $SubProducto==8))
    	echo "<td colspan='2'>&nbsp;</td>\n";
	else
		echo "<td colspan='1'>&nbsp;</td>\n";
?>
  </tr>
</table>
</form>
</body>
</html>
