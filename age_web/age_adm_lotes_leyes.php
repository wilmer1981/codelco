<?php
	include("../principal/conectar_principal.php");
	if (isset($TxtLote))
	{
		$EstadoInput = "";
		$Consulta = "select * ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 ";
		$Consulta.= " on t1.lote = t2.lote";
		$Consulta.= " where t1.lote = '".$TxtLote."'";
		$Resp = mysqli_query($link, $Consulta);
		$CantRecargos = 0;
		while ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$CmbSubProducto = $Fila["cod_subproducto"];
			$CmbProveedor = $Fila["rut_proveedor"];		
			$LoteReMuestreo = $Fila["num_lote_remuestreo"];		
			$CantRecargos++;	
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
	var f = document.frmPopUp;
	switch (opt)
	{
		case "I":	
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;		
		case "S":
			window.close();
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
	background-image: url(../principal/imagenes/fondo3.gif);
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

<body>
<form name="frmPopUp" action="" method="post">
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td colspan="2"><strong>LOTE:&nbsp;<?php echo $TxtLote; ?></strong></td>
  </tr>
  <tr>
    <td width="16%">SubProducto:</td>
    <td width="84%">
      <?php
	$Consulta = "select cod_subproducto, descripcion, abreviatura, LPAD(cod_subproducto,2,'0') as orden ";
	$Consulta.= " from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' order by orden";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{		
		echo  $Fila["orden"]." - ".$Fila["abreviatura"]."\n";
	}
?>    </td>
  </tr>
  <tr>
    <td>proveedor:</td>
    <td>
    <?php
	$Datos = explode("-",$CmbProveedor);
	$RutAux = ($Datos[0]*1)."-".$Datos[1];
	$Consulta = "select * ";
	$Consulta.= " from rec_web.proved ";
	$Consulta.= " where RUTPRV_A='".$RutAux."'";
	$Consulta.= " order by TRIM(nomprv_a) ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Datos = explode("-",$Fila["RUTPRV_A"]);
		$RutAux = ($Datos[0]*1)."-".$Datos[1];
		echo  $Fila["RUTPRV_A"]." - ".$Fila["NOMPRV_A"]."\n";
	}
?>    </td>
  </tr>
  <tr align="center">
    <td colspan="2">
      <input name="BtnImprimir" type="button" value="Imprimir" style="width:70px " onClick="Proceso('I')">
    <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px " onClick="Proceso('S')">   </td>
  </tr>
</table>
<br>
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td colspan="8"><strong>Humedades</strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
  </tr>
<?php
	$RegPorColum = round($CantRecargos/4);
	$Consulta = "select t1.lote, t1.recargo, t2.valor, t2.cod_unidad, LPAD(t1.recargo,2,'0') as orden, t3.abreviatura as unidad ";
	$Consulta.=" from age_web.detalle_lotes t1 left join age_web.leyes_por_lote t2 on ";
	$Consulta.= " t1.lote=t2.lote and t1.recargo=t2.recargo left join proyecto_modernizacion.unidades t3 on ";
	$Consulta.= " t2.cod_unidad=t3.cod_unidad ";
	$Consulta.= " where t1.lote='".$TxtLote."'";
	$Consulta.= " and t2.cod_leyes='01'";
	$Consulta.= " order by orden";
	$Resp = mysqli_query($link, $Consulta);
	$ContColum = 1;
	echo "<tr>\n";
	while ($Fila = mysqli_fetch_array($Resp))
	{  		
		echo "<td class='ColorTabla02' align='center'>".$Fila["recargo"]."</td>\n";
		echo "<td align='right'>".number_format($Fila["valor"],2,",",".")."&nbsp;".$Fila["unidad"]."</td>\n";	
		if ($ContColum == 4)
		{		
			echo "</tr>\n";
			echo "<tr>\n";
			$ContColum = 1;
		}
		else
		{
			$ContColum++;
		}
		
	}
	echo "</tr>\n";
?>  
</table>
<br>
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td colspan="8"><strong>Analitos</strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
  </tr>
  <?php
	$RegPorColum = round($CantRecargos/4);
	$Consulta = "select t1.lote, t1.recargo, t1.valor, t1.cod_unidad, LPAD(t1.recargo,2,'0') as orden, t2.abreviatura as unidad, t3.abreviatura as ley ";
	$Consulta.=" from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on ";
	$Consulta.= " t1.cod_leyes=t3.cod_leyes";
	$Consulta.= " where t1.lote='".$TxtLote."'";
	$Consulta.= " and t1.recargo='0'";
	$Consulta.= " and t1.cod_leyes<>'01'";
	$Consulta.= " order by orden";
	$Resp = mysqli_query($link, $Consulta);
	$ContColum = 1;
	echo "<tr>\n";
	while ($Fila = mysqli_fetch_array($Resp))
	{  		
		echo "<td class='ColorTabla02' align='center'>".$Fila["ley"]."</td>\n";
		echo "<td align='right'>".number_format($Fila["valor"],3,",",".")."&nbsp;".$Fila["unidad"]."</td>\n";	
		if ($ContColum == 4)
		{		
			echo "</tr>\n";
			echo "<tr>\n";
			$ContColum = 1;
		}
		else
		{
			$ContColum++;
		}
		
	}
	echo "</tr>\n";
?>
</table>
<?php
	$Consulta = "select ifnull(count(*),0) as cant ";
	$Consulta.=" from age_web.leyes_por_lote  ";
	$Consulta.= " where lote='".$TxtLote."'";
	$Consulta.= " and recargo='R'";
	$Resp = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Resp);
	if ($Fila["cant"] != 0)
	{  		
?>
<br>
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td colspan="8"><strong>Retalla</strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
  </tr>
  <?php
	$RegPorColum = round($CantRecargos/4);
	$Consulta = "select t1.lote, t1.recargo, t1.valor, t1.cod_unidad, LPAD(t1.recargo,2,'0') as orden, t2.abreviatura as unidad, t3.abreviatura as ley ";
	$Consulta.=" from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on ";
	$Consulta.= " t1.cod_leyes=t3.cod_leyes";
	$Consulta.= " where t1.lote='".$TxtLote."'";
	$Consulta.= " and t1.recargo='R'";
	$Consulta.= " order by orden";
	$Resp = mysqli_query($link, $Consulta);
	$ContColum = 1;
	echo "<tr>\n";
	while ($Fila = mysqli_fetch_array($Resp))
	{  		
		echo "<td class='ColorTabla02' align='center'>".$Fila["ley"]."</td>\n";
		echo "<td align='right'>".number_format($Fila["valor"],3,",",".")."&nbsp;".$Fila["unidad"]."</td>\n";	
		if ($ContColum == 4)
		{		
			echo "</tr>\n";
			echo "<tr>\n";
			$ContColum = 1;
		}
		else
		{
			$ContColum++;
		}
		
	}
	echo "</tr>\n";
?>
</table>
<?php
	}
?>
<?php
	if ($LoteReMuestreo)
	{
?>
<br>
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td colspan="8"><strong>ReMuestreo</strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
    <td width="30">Rec.</td>
    <td width="95">Valor</td>
  </tr>
  <?php
	$RegPorColum = round($CantRecargos/4);
	$Consulta = "select t1.lote, t1.recargo, t1.valor, t1.cod_unidad, LPAD(t1.recargo,2,'0') as orden, t2.abreviatura as unidad, t3.abreviatura as ley ";
	$Consulta.=" from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on ";
	$Consulta.= " t1.cod_leyes=t3.cod_leyes";
	$Consulta.= " where t1.lote='".$LoteReMuestreo."'";
	$Consulta.= " and t1.recargo='0'";
	$Consulta.= " and t1.cod_leyes<>'01'";
	$Consulta.= " order by orden";
	$Resp = mysqli_query($link, $Consulta);
	$ContColum = 1;
	echo "<tr>\n";
	while ($Fila = mysqli_fetch_array($Resp))
	{  		
		echo "<td class='ColorTabla02' align='center'>".$Fila["ley"]."</td>\n";
		echo "<td align='right'>".number_format($Fila["valor"],3,",",".")."&nbsp;".$Fila["unidad"]."</td>\n";	
		if ($ContColum == 4)
		{		
			echo "</tr>\n";
			echo "<tr>\n";
			$ContColum = 1;
		}
		else
		{
			$ContColum++;
		}
		
	}
	echo "</tr>\n";
?>
</table>
<?php
	}
?>
</form>
</body>
</html>
