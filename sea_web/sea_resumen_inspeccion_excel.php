<?php
	    ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_principal.php");
	$CodSistema=2;
	$CodPantalla=47;
	$Producto = 17;


	if(isset($_REQUEST["SubProducto"])) {
		$SubProducto = $_REQUEST["SubProducto"];
	}else{
		$SubProducto =  "";
	}
	if(isset($_REQUEST["Horno"])) {
		$Horno = $_REQUEST["Horno"];
	}else{
		$Horno =  "";
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
		$TotalPorc =  0;
	}


	//NOMBRE SUBPRODUCTO
	$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomSubProducto = $Fila["descripcion"];
	else	$NomSubProducto = "&nbsp;";
?>
<html>
<head>
<title>Sistema de Anodos</title>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="800" height="77" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr align="center">
    <td colspan="15"><strong>CUADRO RESUMENDE INSPECCION DE ANODOS <?php echo $NomSubProducto; ?></strong></td>
  </tr>
  <tr>
    <td colspan="15">&nbsp;</td>
  </tr>
  <tr>
    <td width="141" colspan="15">TIPO CONSULTA:     
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
		
?></td>
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
  <tr align="center">
    <td colspan="15">PERIODO ENERO-DICIEMBRE <?php 
	if ($Producto == 17 && ($SubProducto == 4 || $SubProducto == 8))
		echo $Ano.", TOTAL PRODUCCION ";
	else
		echo $TotalPorc.", TOTAL RECEPCION ";
    echo number_format($TotalUnidades,0,",",".")." UNID., ".number_format($TotalPeso,0,",",".")." Kg.";
	?></td>
  </tr>
<?php
	if ($Producto == 17 && ($SubProducto==4 || $SubProducto==8))
	{
		echo "<tr align='center'>\n";
		echo "<td colspan='15'>\n";
		switch ($Horno)
		{
			case "T":
				echo " HORNO = TODOS";
				break;
			case "1":
				echo " HORNO 1";
				break;
			case "2":
				echo " HORNO 2";
				break;
			case "4":
				echo " HORNO BASC.";
				break;
			default:
				echo " HORNO = TODOS";
				break;
		}		
		echo "</td>\n";
		echo "</tr>\n";
	}
?>  
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
		$TotalPorcAno=0;
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
				echo "<td align='right'>";
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
				echo "</td>\n";				
			}
			else
			{
				echo "<td align='right'>0</td>\n";
			}
		}
		if ($TotalInspec > 0 && $TotalDefectoAnual > 0)
			$TotalPorc = ($TotalInspec*100)/$TotalDefectoAnual;
		else	
			$TotalPorc=0;
		$TotalPorcAno = $TotalPorcAno + $TotalPorc;
		echo "<td class='ColorTabla02' align='right'>".number_format($TotalInspec,0,",",".")."</td>\n";
		echo "<td class='ColorTabla02' align='right'>".number_format($TotalPorc,2,",",".")."</td>\n";
		echo "</tr>\n";
	}
	$TotalAno = 0;
	//TOTAL INCIDENCIAS
	$ArrIncRecep = array();
	echo "<tr>\n";
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
	echo "<tr>\n";
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
		$TotalUnidadesAno=0; //WSO
		$TotalPesoAno=0;
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
	echo "<tr>\n";
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
