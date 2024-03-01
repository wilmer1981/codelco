<?php
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["TipoProducto"])) {
		$TipoProducto = $_REQUEST["TipoProducto"];
	}else{
		$TipoProducto =  "";
	}
	if(isset($_REQUEST["TipoMovimiento"])) {
		$TipoMovimiento = $_REQUEST["TipoMovimiento"];
	}else{
		$TipoMovimiento =  "";
	}
	if(isset($_REQUEST["DiaIni"])) {
		$DiaIni = $_REQUEST["DiaIni"];
	}else{
		$DiaIni =  date("d");
	}
	if(isset($_REQUEST["MesIni"])) {
		$MesIni = $_REQUEST["MesIni"];
	}else{
		$MesIni =  date("m");
	}
	if(isset($_REQUEST["AnoIni"])) {
		$AnoIni = $_REQUEST["AnoIni"];
	}else{
		$AnoIni =  date("Y");
	}
	if(isset($_REQUEST["DiaFin"])) {
		$DiaFin = $_REQUEST["DiaFin"];
	}else{
		$DiaFin =  date("d");
	}
	if(isset($_REQUEST["MesFin"])) {
		$MesFin = $_REQUEST["MesFin"];
	}else{
		$MesFin =  date("m");
	}
	if(isset($_REQUEST["AnoFin"])) {
		$AnoFin = $_REQUEST["AnoFin"];
	}else{
		$AnoFin =  date("Y");
	}

	if(isset($_REQUEST["Valores"])) {
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores =  date("Y");
	}


	$Datos = explode("-",$TipoProducto);
	if(isset($Datos[0])){
		$Producto = $Datos[0];
	}else{
		$Producto = 0;
	}
	if(isset($Datos[1])){
		$SubProducto = $Datos[1];
	}else{
		$SubProducto = 0;
	}
	//$Producto = $Datos[0];
	//$SubProducto = $Datos[1];
	//PRODUCTO
	$Consulta = "SELECT * from proyecto_modernizacion.productos where cod_producto='".$Producto."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$NomProducto = $Fila["descripcion"];
	}
	//SUB-PRODUCTO
	$Consulta = "SELECT * from proyecto_modernizacion.subproducto where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
	$Respuesta = mysqli_query($link, $Consulta);
	$NomSubProducto="";
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$NomSubProducto = $Fila["descripcion"];
	}
	//TIPO MOVIMIENTO
	$NomTipoMov = "";
	if ($TipoMovimiento == "S")
	{
		$NomTipoMov = "STOCK";
	}
	else
	{	
		$Consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2001 and cod_subclase = '".$TipoMovimiento."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{			
			$NomTipoMov = strtoupper($Fila["nombre_subclase"]);
		}
	}
	//PERIODO
	$FechaIni = $AnoIni."-".str_pad($MesIni,2,0,STR_PAD_LEFT)."-".str_pad($DiaIni,2,0,STR_PAD_LEFT);
	$FechaFin = $AnoFin."-".str_pad($MesFin,2,0,STR_PAD_LEFT)."-".str_pad($DiaFin,2,0,STR_PAD_LEFT);
	if ($TipoMovimiento == "S")
	{
		$Periodo = str_pad($MesFin,2,0,STR_PAD_LEFT)."/".$AnoIni;
	}
	else
	{	
		$Periodo = str_pad($DiaIni,2,0,STR_PAD_LEFT)."-".str_pad($MesIni,2,0,STR_PAD_LEFT)."-".$AnoIni;
		$Periodo.= " AL ".str_pad($DiaFin,2,0,STR_PAD_LEFT)."-".str_pad($MesFin,2,0,STR_PAD_LEFT)."-".$AnoFin;
	}
	
	//LEYES
	$ArrLeyes = array();
	$ArrLimites = array();
	$Datos = explode("//",$Valores);
	$i=1;
	$LimitesCons = "";
	//foreach($Datos as $k => $v)
	foreach ($Datos as $k=>$v)
	{
		$Datos2 = explode("~~",$v);
		$Consulta = "SELECT * from proyecto_modernizacion.leyes where cod_leyes = '".$Datos2[0]."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Abrev = $Fila["abreviatura"];
		}		
		//ARREGLO LEYES
		$ArrLeyes[$Datos2[0]][0] = $Datos2[0]; //COD_LEYES
		if ($Datos2[2] > 0)
			$ArrLeyes[$Datos2[0]][1] = $Datos2[1]; //SIGNO
		else
			$ArrLeyes[$Datos2[0]][1] = ""; //SIGNO
		$ArrLeyes[$Datos2[0]][2] = str_replace(",",".",$Datos2[2]); //VALOR
		$ArrLeyes[$Datos2[0]][3] = $Abrev;     //ABREVIATURA 
		//ARREGLO LIMITES
		if ($Datos2[2] > 0)
		{
			$ArrLimites[$Datos2[0]][0] = $Datos2[0]; //COD_LEYES
			$ArrLimites[$Datos2[0]][1] = $Datos2[1]; //SIGNO
			$ArrLimites[$Datos2[0]][2] = str_replace(",",".",$Datos2[2]); //VALOR
			$ArrLimites[$Datos2[0]][3] = $Abrev;     //ABREVIATURA 
			$LimitesCons.= $Abrev.$Datos2[1].$Datos2[2]."; ";
		}		
		$i++;
	}
	$LimitesCons = substr($LimitesCons,0,strlen($LimitesCons)-2);
	$LargoTabla = 350 + ($i*40);
?>
<html>
<head>
<title>Sistema de Anodos</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<style type="text/css">

body {
	background-image: url(../Principal/imagenes/fondo3.gif);
}

</style>
<script language="javascript">
function Proceso(o)
{	
	var f = document.frmPrincipal;
	switch (o)
	{
		case "I":
			f.BtnImprimir.style.visibility = 'hidden';
			f.BtnSalir.style.visibility = 'hidden';
			f.BtnImprimir.style.visibility = '';
			f.BtnSalir.style.visibility = '';
			window.print();
			break;
		case "S":
			f.action = "sea_con_limites.php";
			f.submit();
			break;
	}
}
</script>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="600" border="1" cellspacing="0" cellpadding="3">
  <tr>
    <td width="124">Tipo de Producto</td>
    <td width="458"><?php echo $NomSubProducto; ?></td>
  </tr>
  <tr>
    <td>Tipo de Movimiento</td>
    <td><?php echo $NomTipoMov; ?></td>
  </tr>
  <tr>
    <td>Periodo</td>
    <td><?php echo $Periodo; ?></td>
  </tr>
  <tr>
    <td>Limites Consultados</td>
    <td><?php echo $LimitesCons; ?></td>
  </tr>
  <tr align="center">
    <td colspan="2"><input name="BtnImprimir" type="button" value="Imprimir" style="width:70px" onClick="Proceso('I')">
    <input name="BtnSalir" type="button" id="BtnSalir" style="width:70px" onClick="Proceso('S')" value="Salir"></td>
  </tr>
</table>
<BR><BR>
<table width="<?php echo $LargoTabla; ?>" border="1" cellspacing="0" cellpadding="2">
  <tr align="center" class="ColorTabla01">
  	<td width="100">FECHA</td>
    <td width="60">HORNADA</td>
<?php
	
	switch ($TipoMovimiento)
	{	
		case 1:
			echo "<td width='60'>LOTE</td>\n";
			echo "<td width='60'>ORIGEN</td>\n";
			break;
		case 2:
			echo "<td width='60'>GRUPO</td>\n";
			echo "<td width='60'>LADO</td>\n";
			break;
		case 3:
			echo "<td width='60'>GRUPO</td>\n";
			echo "<td width='60'>LADO</td>\n";
			break;
		case 4:
			if ($Producto!=17)
			{
				echo "<td width='60'>GRUPO</td>\n";
				echo "<td width='60'>LADO</td>\n";
			}
			break;
	}	
	
?>
    <td width="35">CANT.</td>
    <td width="35">PESO</td>
    <?php	
	//foreach($ArrLeyes as $k => $v)
	foreach ($ArrLeyes as $k=>$v)
	{
		if ($v[1]!="")
	    	echo "<td width='35'>".$v[3]."<br>".$v[1]."".$v[2]."</td>\n";
		else
			echo "<td width='35'>".$v[3]."</td>\n";
	}
?>
  </tr>
<?php  	
	if ($TipoMovimiento == "S")//STOCK
	{
		$Consulta = "SELECT distinct t1.ano, t1.mes, t1.hornada, t1.unid_fin as unidades, t1.peso_fin as peso";
		$Consulta.= " from sea_web.stock t1 inner join sea_web.leyes_por_hornada t2 on t1.hornada=t2.hornada";
		$Consulta.= " where t1.ano = '".$AnoFin."' and t1.mes = '".$MesFin."'";	
		$i=1;
		//while (list($k,$v)=each($ArrLimites))
		foreach ($ArrLimites as $k=>$v)
		{
			if ($i==1)
				$Consulta.= " and (";
			$Consulta.= "(t2.cod_leyes = '".$v[0]."' and t2.valor ".$v[1]." '".$v[2]."') or ";
			$i++;
		}
		$Consulta = substr($Consulta,0,strlen($Consulta)-4);
		if ($i>1)
			$Consulta.= ")";
		if ($Producto != 0)
		{
			$Consulta.= " and t1.cod_producto = '".$Producto."'";
			if ($SubProducto != 0)
				$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";
		}
		$Consulta.= " order by t1.ano, t1.mes , t1.hornada ";
	}
	else
	{
		$Consulta = "SELECT distinct t1.fecha_movimiento, t1.hornada, t1.campo1, t1.campo2, t1.unidades, t1.peso";
		$Consulta.= " from sea_web.movimientos t1 inner join sea_web.leyes_por_hornada t2 on t1.hornada=t2.hornada";
		$Consulta.= " where t1.tipo_movimiento = '".$TipoMovimiento."' ";
		$Consulta.= " and t1.fecha_movimiento between '".$FechaIni."' and '".$FechaFin."'";	
		$i=1;
		//while (list($k,$v)=each($ArrLimites))
		foreach ($ArrLimites as $k=>$v)
		{
			if ($i==1)
				$Consulta.= " and (";
			$Consulta.= "(t2.cod_leyes = '".$v[0]."' and t2.valor ".$v[1]." '".$v[2]."') or ";
			$i++;
		}
		$Consulta = substr($Consulta,0,strlen($Consulta)-4);
		if ($i>1)
			$Consulta.= ")";
		if ($Producto != 0)
		{
			$Consulta.= " and t1.cod_producto = '".$Producto."'";
			if ($SubProducto != 0)
				$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";
		}
		$Consulta.= " order by t1.fecha_movimiento, t1.hornada ";
	}
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	
	{
		echo "<tr>\n";
		if ($TipoMovimiento == "S")
			echo "<td align='center'>".str_pad($Fila["mes"],2,0,STR_PAD_LEFT)."/".$Fila["ano"]."</td>\n";
		else
			echo "<td align='center'>".substr($Fila["fecha_movimiento"],8,2)."/".substr($Fila["fecha_movimiento"],5,2)."/".substr($Fila["fecha_movimiento"],0,4)."</td>\n";		
		echo "<td align='center'>".substr($Fila["hornada"],-4)."</td>\n";
		$Consulta = "SELECT * from sea_web.relaciones where hornada_ventana = '".$Fila["hornada"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$LoteVentana = $Fila2["lote_ventana"];			
			$LoteOrigen = $Fila2["lote_origen"];
		}			
		switch ($TipoMovimiento)
		{	
			case 1:
				echo "<td align='center'>".$LoteVentana."</td>\n";
				echo "<td align='center'>".$LoteOrigen."</td>\n";
				break;
			case 2:
				echo "<td align='center'>".$Fila["campo2"]."</td>\n";
				echo "<td align='center'>".$Fila["campo1"]."</td>\n";
				break;
			case 3:
				echo "<td align='center'>".$Fila["campo2"]."</td>\n";
				echo "<td align='center'>".$Fila["campo1"]."</td>\n";
				break;
			case 4:
				if ($Producto!=17)
				{
					echo "<td align='center'>".$Fila["campo2"]."</td>\n";
					echo "<td align='center'>".$Fila["campo1"]."</td>\n";
				}
				break;
		}			
		echo "<td align='right'>".$Fila["unidades"]."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";				
		$Consulta = "SELECT * from sea_web.leyes_por_hornada ";
		$Consulta.= " where cod_producto = '".$Producto."'";
		$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		$Consulta.= " and hornada = '".$Fila["hornada"]."'";
		$Consulta.= " order by cod_leyes";
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			if( $ArrLeyes[$Fila2["cod_leyes"]][0]!="")
				$ArrLeyes[$Fila2["cod_leyes"]][4] = $Fila2["valor"];
		}
		reset($ArrLeyes);
		//foreach($ArrLeyes as $k => $v)
		foreach ($ArrLeyes as $k=>$v)
		{
			$Color = "";
			if ($v[1] != "")
			{
				switch ($v[1])
				{
					case ">":
						if ($v[4]>$v[2])
							$Color="YELLOW";
						break;
					case "<":
						if ($v[4]<$v[2])
							$Color="YELLOW";
						break;
					case "=":
						if ($v[4]==$v[2])
							$Color="YELLOW";
						break;
				}
											
			}
			echo "<td align='right' bgcolor='".$Color."'>".number_format($v[4],2,",",".")."</td>\n";	
		}
		echo "</tr>\n";
	}
?>   
</table>
</form>
</body>
</html>
