<?php
	include("../principal/conectar_principal.php");
	$CodSistema=2;
	$CodPantalla=47;
	$Producto = 17;
	
	if(isset($_REQUEST["SubProducto"])) {
		$SubProducto = $_REQUEST["SubProducto"];
	}else{
		$SubProducto =  "";
	}
	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano =  date("Y");
	}

	if(isset($_REQUEST["Mostrar"])) {
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar =  "";
	}
	if(isset($_REQUEST["TipoCons"])) {
		$TipoCons = $_REQUEST["TipoCons"];
	}else{
		$TipoCons =  "";
	}
	if(isset($_REQUEST["TotalPorc"])) {
		$TotalPorc = $_REQUEST["TotalPorc"];
	}else{
		$TotalPorc =  "";
	}
	

?>
<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}

</style>
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action = "sea_resumen_inspeccion.php?Mostrar=S";
			f.submit();
			break;
		case "R":
			f.action = "sea_resumen_inspeccion.php";
			f.submit();
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=2&Nivel=0";
			f.submit();
			break;
		case "I":
			f.BtnConsulta.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnExcel.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnConsulta.style.visibility = "visible";
			f.BtnImprimir.style.visibility = "visible";
			f.BtnExcel.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;
		case "E":
			f.action = "sea_resumen_inspeccion_excel.php?Mostrar=S";
			f.submit();
			break;
	}
}

function DetalleInspeccion(ano, mes, prod, subprod, defec, horno)
{
	window.open("sea_resumen_inspeccion_detalle.php?Ano="+ano+"&Mes="+mes+"&Producto="+prod+"&SubProducto="+subprod+"&Defecto="+defec+"&Horno="+horno,"","top=50,left=50,width=550,height=400,scrollbars=yes,resizable = yes");
}
</script>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="800" height="77" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr align="center">
    <td colspan="2"><strong>CUADRO RESUMENDE INSPECCION DE ANODOS</strong></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>TIPO CONSULTA </td>
    <td><SELECT name="TipoCons">
      <?php
	switch ($TipoCons)
	{
		case "TD";
			echo "<option SELECTed value='TD'>RECUPERADOS + RECHAZADOS</option>";	
			echo "<option value='RC'>RECUPERADOS</option>";	
			echo "<option value='RZ'>RECHAZADOS</option>";	
			break;
		case "RC";
			echo "<option value='TD'>RECUPERADOS + RECHAZADOS</option>";	
			echo "<option SELECTed value='RC'>RECUPERADOS</option>";	
			echo "<option value='RZ'>RECHAZADOS</option>";	
			break;
		case "RZ";
			echo "<option value='TD'>RECUPERADOS + RECHAZADOS</option>";	
			echo "<option value='RC'>RECUPERADOS</option>";	
			echo "<option SELECTed value='RZ'>RECHAZADOS</option>";	
			break;
		default:
			echo "<option SELECTed value='TD'>RECUPERADOS + RECHAZADOS</option>";	
			echo "<option value='RC'>RECUPERADOS</option>";	
			echo "<option value='RZ'>RECHAZADOS</option>";	
			break;
	}
		
?>
    </SELECT></td>
    </tr>
  <tr>
    <td>SUBPRODUCTO      </td>
    <td><SELECT name="SubProducto" onChange="Proceso('R')">
	<option value="T">SELECCIONAR</option>
      <?php
	$Consulta = "SELECT t2.cod_subproducto,  t2.descripcion from proyecto_modernizacion.productos t1 inner join proyecto_modernizacion.subproducto t2";
	$Consulta.= " on t1.cod_producto = t2.cod_producto ";
	$Consulta.= " where t2.mostrar_sea='S' and t2.cod_producto=17";
	$Consulta.= " order by t2.cod_subproducto ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($SubProducto == $Fila["cod_subproducto"])
		{
			echo "<option SELECTed value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>";
		}
		else
		{
			echo "<option value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>";
		}
	}
?>
    </SELECT>
      &nbsp;&nbsp;A&Ntilde;O
      <SELECT name="Ano">
<?php
	for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++)
	{
		if (!isset($Ano))
		{
			if ($i==date("Y"))
				echo "<option SELECTed value='".$i."'>".$i."</option>";
			else
				echo "<option value='".$i."'>".$i."</option>";
		}
		else
		{
			if ($i==$Ano)
				echo "<option SELECTed value='".$i."'>".$i."</option>";
			else
				echo "<option value='".$i."'>".$i."</option>";
		}
	}
?>	  	  
      </SELECT>
      <input name="BtnConsulta" type="button" id="BtnConsulta" value="Consultar" onClick="Proceso('C')" style="width:70px ">
      <input name="BtnImprimir" type="button" id="BtnConsultar3" value="Imprimir" onClick="Proceso('I')" style="width:70px ">
      <input name="BtnExcel" type="button" id="BtnConsultar4" value="Excel" onClick="Proceso('E')" style="width:70px ">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" onClick="Proceso('S')" style="width:70px "></td>
    </tr>
<?php	
	//TOTAL DE RECEPCIONES
	$Consulta = "SELECT sum(peso) as peso, sum(unidades) as unidades ";
	$Consulta.= " from sea_web.movimientos ";
	$Consulta.= " where tipo_movimiento = '1' ";
	$Consulta.= " and cod_producto = '".$Producto."' and cod_subproducto='".$SubProducto."'";
	$Consulta.= " and fecha_movimiento between '".$Ano."-01-01' and '".$Ano."-12-31'";
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
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$TotalUnidades = $Fila["unidades"];
		$TotalPeso = $Fila["peso"];
	}
	else
	{
		$TotalUnidades = 0;
		$TotalPeso = 0;
	}
?>	
<?php
	if ($Producto == 17 && ($SubProducto==4 || $SubProducto==8))
	{
		echo "<tr align='center'>\n";
		echo "<td colspan='15'>\n";
		switch ($Horno)
		{
			case "T":
				echo " Todos<input name='Horno' type='radio' value='T' checked> \n";
				echo " Horno 1<input name='Horno' type='radio' value='1'> \n";
				echo " Horno 2<input name='Horno' type='radio' value='2'> \n";
				echo " Horno Basc.<input name='Horno' type='radio' value='4'>\n";
				break;
			case "1":
				echo " Todos<input name='Horno' type='radio' value='T'> \n";
				echo " Horno 1<input name='Horno' type='radio' value='1' checked> \n";
				echo " Horno 2<input name='Horno' type='radio' value='2'> \n";
				echo " Horno Basc.<input name='Horno' type='radio' value='4'>\n";
				break;
			case "2":
				echo " Todos<input name='Horno' type='radio' value='T'> \n";
				echo " Horno 1<input name='Horno' type='radio' value='1'> \n";
				echo " Horno 2<input name='Horno' type='radio' value='2' checked> \n";
				echo " Horno Basc.<input name='Horno' type='radio' value='4'>\n";
				break;
			case "4":
				echo " Todos<input name='Horno' type='radio' value='T'> \n";
				echo " Horno 1<input name='Horno' type='radio' value='1'> \n";
				echo " Horno 2<input name='Horno' type='radio' value='2'> \n";
				echo " Horno Basc.<input name='Horno' type='radio' value='4' checked>\n";
				break;
			default:
				echo " Todos<input name='Horno' type='radio' value='T' checked> \n";
				echo " Horno 1<input name='Horno' type='radio' value='1'> \n";
				echo " Horno 2<input name='Horno' type='radio' value='2'> \n";
				echo " Horno Basc.<input name='Horno' type='radio' value='4'>\n";
				break;
		}		
		echo "</td>\n";
		echo "</tr>\n";
	}
?>
  <tr align="center">
    <td colspan="2">PERIODO ENERO-DICIEMBRE <?php 
	if ($Producto == 17 && ($SubProducto == 4 || $SubProducto == 8))
		echo $Ano.", TOTAL PRODUCCION ";
	else
		echo $TotalPorc.", TOTAL RECEPCION ";
    echo number_format($TotalUnidades,0,",",".")." UNID., ".number_format($TotalPeso,0,",",".")." Kg.";
	?></td>
  </tr>
  </table>
  <br>
  <table width="800" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla02">
    <td colspan="15"><strong>ANODOS 
<?php
	switch ($TipoCons)
	{
		case "TD";
			echo "RECUPERADOS + RECHAZADOS";				
			break;
		case "RC";
			echo "RECUPERADOS";	
			break;
		case "RZ";
			echo "RECHAZADOS";	
			break;
		default:
			echo "RECUPERADOS + RECHAZADOS";	
			break;
	}
?> Y PORCENTAJE DE INCIDENCIA DE ACUERDO A DEFECTO </strong></td>
    </tr>
  <tr align="center" class="ColorTabla01">
    <td width="142">MES</td>
    <td width="44">ENE</td>
    <td width="39">FEB</td>
    <td width="39">MAR</td>
    <td width="39">ABR</td>
    <td width="39">MAY</td>
    <td width="39">JUN</td>
    <td width="39">JUL</td>
    <td width="39">AGO</td>
    <td width="39">SEP</td>
    <td width="39">OCT</td>
    <td width="39">NOV</td>
    <td width="39">DIC</td>
    <td width="43">TOTAL</td>
    <td width="48">PORC.</td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td>CAUSAS DE RECHAZO </td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>UNID.</td>
    <td>(%)</td>
  </tr>
<?php 
if ($Mostrar == "S")
{
	//TOTAL DEFECTOS ANUAL
	$Consulta = "SELECT sum(recuperables) as recuperables, sum(rechazados) as rechazados ";
	$Consulta.= " from sea_web.rechazos ";
	$Consulta.= " where cod_producto = '".$Producto."' and cod_subproducto='".$SubProducto."'";
	$Consulta.= " and fecha_ini between '".$Ano."-01-01 00:00:00' and '".$Ano."-12-31 23:59:59'";
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
	$Consulta.= " and cod_defecto <> '0'";
	$Consulta.= " group by cod_producto, cod_subproducto";
	$Resp2 = mysqli_query($link, $Consulta);
	if ($Fila2 = mysqli_fetch_array($Resp2))
	{
		$TotalDefectoAnual = ($Fila2["recuperables"] + $Fila2["rechazados"]);
	}
	else
	{
		$TotalDefectoAnual = 0;
	}
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='2008' order by cod_subclase "; 
	
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		
		$TotalInspec = 0;	
		$TotalPorcAno =0;	
		echo "<tr>\n";
		echo "<td align='left'>".$Fila["nombre_subclase"]."</td>\n";
		for ($i=1;$i<=12;$i++)
		{	
			$FechaIni = $Ano."-".$i."-01";
			$FechaTer = $Ano."-".$i."-31";						
			$Consulta = "SELECT sum(recuperables) as recuperables, sum(rechazados) as rechazados ";
			$Consulta.= " from sea_web.rechazos ";
			$Consulta.= " where cod_producto = '".$Producto."' and cod_subproducto='".$SubProducto."'";
			$Consulta.= " and cod_defecto='".$Fila["cod_subclase"]."'";
			$Consulta.= " and fecha_ini between '".$FechaIni." 00:00:00' and '".$FechaTer." 23:59:59'";
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
			$Consulta.= " and cod_defecto <> '0'";
			$Consulta.= " group by cod_producto, cod_subproducto";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				echo "<td align='right'><a href=\"JavaScript:DetalleInspeccion(".$Ano.",".$i.",".$Producto.",".$SubProducto.",".$Fila["cod_subclase"].",'".$Horno."')\">";
				switch ($TipoCons)
				{
					case "TD":
						echo number_format($Fila2["recuperables"] + $Fila2["rechazados"],0,",",".");
						$TotalInspec = $TotalInspec + ($Fila2["recuperables"] + $Fila2["rechazados"]);		
						break;
					case "RC":
						echo number_format($Fila2["recuperables"],0,",",".");
						$TotalInspec = $TotalInspec + $Fila2["recuperables"];		
						break;
					case "RZ":
						echo number_format($Fila2["rechazados"],0,",",".");
						$TotalInspec = $TotalInspec + $Fila2["rechazados"];		
						break;
				}		
				echo "</a></td>\n";				
			}
			else
			{
				echo "<td align='right'>0</td>\n";
			}
		}
		if ($TotalInspec > 0 && $TotalDefectoAnual > 0)
			$TotalPorc = ($TotalInspec*100)/$TotalDefectoAnual;
		else	$TotalPorc=0;

		$TotalPorcAno = $TotalPorcAno + $TotalPorc;
		echo "<td class='ColorTabla02' align='right'>".number_format($TotalInspec,0,",",".")."</td>\n";
		echo "<td class='ColorTabla02' align='right'>".number_format($TotalPorc,2,",",".")."</td>\n";
		echo "</tr>\n";
	}
	$TotalAno = 0;
	//TOTAL INCIDENCIAS
	$ArrIncRecep = array();
	echo "<tr class='ColorTabla02'>\n";
    echo "<td>TOTAL INCIDENCIAS</td>\n";
    for ($i=1;$i<=12;$i++)
	{	
		$FechaIni = $Ano."-".$i."-01";
		$FechaTer = $Ano."-".$i."-31";						
		$Consulta = "SELECT sum(recuperables) as recuperables, sum(rechazados) as rechazados ";
		$Consulta.= " from sea_web.rechazos ";
		$Consulta.= " where cod_producto = '".$Producto."' and cod_subproducto='".$SubProducto."'";
		$Consulta.= " and fecha_ini between '".$FechaIni." 00:00.00' and '".$FechaTer." 23:59:59'";
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
		$Consulta.= " and cod_defecto <> '0'";
		$Consulta.= " group by cod_producto, cod_subproducto";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{								
			switch ($TipoCons)
			{
				case "TD":
					echo "<td align='right'>".number_format($Fila2["recuperables"] + $Fila2["rechazados"],0,",",".")."</td>\n";	
					$TotalAno = $TotalAno + ($Fila2["recuperables"] + $Fila2["rechazados"]);		
					$ArrIncRecep[$i][0] = ($Fila2["recuperables"] + $Fila2["rechazados"]);
					break;
				case "RC":
					echo "<td align='right'>".number_format($Fila2["recuperables"],0,",",".")."</td>\n";	
					$TotalAno = $TotalAno + $Fila2["recuperables"];	
					$ArrIncRecep[$i][0] = $Fila2["recuperables"];
					break;
				case "RZ":
					echo "<td align='right'>".number_format($Fila2["rechazados"],0,",",".")."</td>\n";	
					$TotalAno = $TotalAno + $Fila2["rechazados"];	
					$ArrIncRecep[$i][0] = $Fila2["rechazados"];
					break;
			}				
		}
		else
		{
			echo "<td align='right'>0</td>\n";
		}
	}
    echo "<td align='right'>".number_format($TotalAno,0,",",".")."</td>\n";
    echo "<td align='right'>".number_format($TotalPorcAno,0,",",".")."</td>\n";
  	echo "</tr>\n";
	//TOTAL PROD POR MES
	echo "<tr class='ColorTabla02'>\n";
    echo "<td>TOTAL UNID. MES</td>\n";
    for ($i=1;$i<=12;$i++)
	{	
		$FechaIni = $Ano."-".$i."-01";
		$FechaTer = $Ano."-".$i."-31";						
		//TOTAL DE RECEPCIONES POR MES
		$Consulta = "SELECT sum(peso) as peso, sum(unidades) as unidades ";
		$Consulta.= " from sea_web.movimientos ";
		$Consulta.= " where tipo_movimiento = '1' ";
		$Consulta.= " and cod_producto = '".$Producto."' and cod_subproducto='".$SubProducto."'";
		$Consulta.= " and fecha_movimiento between '".$Ano."-".$i."-01' and '".$Ano."-".$i."-31'";
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
		$Resp = mysqli_query($link, $Consulta);
		$TotalUnidadesAno=0; // WSO
		$TotalPesoAno=0; // WSO
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$TotalUnidades = $Fila["unidades"];
			$TotalPeso = $Fila["peso"];
			$TotalUnidadesAno = $TotalUnidadesAno + $TotalUnidades;
			$TotalPesoAno = $TotalPesoAno + $TotalPeso;
		}
		else
		{
			$TotalUnidades = 0;
			$TotalPeso = 0;
		}
		$ArrIncRecep[$i][1] = $TotalUnidades;
		echo "<td align='right'>".number_format($TotalUnidades,0,",",".")."</td>\n";
	}
    echo "<td align='right'>".number_format($TotalUnidadesAno,0,",",".")."</td>\n";
    echo "<td align='right'>".number_format(100,0,",",".")."</td>\n";
  	echo "</tr>\n";
	//PORC. INCIDENCIAS v/s RECEP.MES
	echo "<tr class='ColorTabla02'>\n";
    echo "<td>INCID. MES</td>\n";
	reset($ArrIncRecep);
    for ($i=1;$i<=12;$i++)
	{	
		if(isset($ArrIncRecep[$i][0])){
			$ArrIncRecep1 =$ArrIncRecep[$i][0];
		}else{
			$ArrIncRecep1 =0;
		}
		if(isset($ArrIncRecep[$i][1])){
			$ArrIncRecep2 =$ArrIncRecep[$i][1];
		}else{
			$ArrIncRecep2 =0;
		}
		//if ($ArrIncRecep[$i][0]>0 && $ArrIncRecep[$i][1]>0)
		if ($ArrIncRecep1>0 && $ArrIncRecep2>0)
			$PorcMes=($ArrIncRecep[$i][0]*100)/$ArrIncRecep[$i][1];
		else
			$PorcMes=0;
		echo "<td align='right'>".number_format($PorcMes,2,",",".")."</td>\n";
	}
	if ($TotalAno>0 && $TotalUnidadesAno>0)
		$PorcAno=($TotalAno*100)/$TotalUnidadesAno;
	else
		$PorcAno=0;
    echo "<td align='right'>".number_format($PorcAno,2,",",".")."</td>\n";
    echo "<td align='right'>&nbsp;</td>\n";
  	echo "</tr>\n";
}
?>  
</table>
</form>
</body>
</html>
