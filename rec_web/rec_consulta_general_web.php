<?php
	//echo substr($TxtFechaIni,0,4)." / ".$TipoConsulta;
	if(substr($TxtFechaIni,0,4)>=2006)
	{
		switch($TipoConsulta)
		{
			case "D":
				$Param='TipoConsulta='.$TipoConsulta.'&TxtFechaIni='.$TxtFechaIni.'&TxtFechaFin='.$TxtFechaFin.'&Producto='.$Producto.'&RutProveedor='.$RutProveedor.'&OptAcumulado='.$OptAcumulado;
				header('location:rec_consulta_general_web_sipa.php?'.$Param);
				break;
			case "O":
				$Param='TipoConsulta='.$TipoConsulta.'&TxtFechaIni='.$TxtFechaIni.'&TxtFechaFin='.$TxtFechaFin.'&IdProducto='.$IdProducto.'&IdProveedor='.$IdProveedor.'&OptAcumulado='.$OptAcumulado;			
				header('location:rec_consulta_general_web_sipa.php?'.$Param);
				break;	
			case "R":	
				if ($Oficial!="S")
					header('location:rec_consulta_general_web_sipa.php?'.$Param);
				break;
		}		
	}
	
	$CodigoDeSistema = 8;
	include("../principal/conectar_rec_web.php");
?>
<html>
<head>
<title>Sistema de Recepci&oacute;n</title>
<link href="../principal/estilos/css_rec_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Ordenar(Tipo,TipoConsulta)
{
	var f = document.frmPrincipal;
	
	switch(Tipo)
	{
		case "F"://ORDENAR POR FOLIO
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "L"://ORDENAR POR LOTE
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "PB"://ORDENAR POR PESO BRUTO
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "PT"://ORDENAR POR PESO TARA
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "PN"://ORDENAR POR PESO NETO
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "NF"://ORDENAR POR NOMBRE FAENA
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "RP"://ORDENAR POR RUT PROVEEDOR
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "DPV"://ORDENAR POR NOMBRE PROVEEDOR
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "DPD"://ORDENAR POR NOMBRE SUBPRODUCTO
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "C"://ORDENAR POR CONJUNTO
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "G"://ORDENAR POR GUIA DESPACHO
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "RP2"://ORDENAR POR RUT PROVEEDOR
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "DPV2"://ORDENAR POR NOMBRE PROVEEDOR
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
		case "DPD2"://ORDENAR POR NOMBRE SUBPRODUCTO
			f.action="rec_consulta_general_web.php?Ordenado="+Tipo;
			break;
	}
	f.submit();
}
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "S":
			f.action='rec_consulta_general.php';
			f.submit();
			//window.history.back();
			break;
	}
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">
<input type="hidden" name="TxtFechaIni" value="<?php echo $TxtFechaIni; ?>">
<input type="hidden" name="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>">
<input type="hidden" name="Producto" value="<?php echo $Producto; ?>">
<input type="hidden" name="RutProveedor" value="<?php echo $RutProveedor; ?>">
<input type="hidden" name="OptAcumulado" value="<?php echo $OptAcumulado; ?>">
<input type="hidden" name="Lote" value="<?php echo $Lote; ?>">
<input type="hidden" name="TxtLote" value="<?php echo $TxtLote; ?>">
<table width="700" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000" class="TablaInterior">
  <tr bgcolor='#FFFFFF'> 
    <td width="110">Tipo Consulta:</td>
    <td width="456">
      <?php
	switch ($TipoConsulta)	
	{
		case "R":
			echo "Recepciones";
			break;
		case "D":
			echo "Despachos";
			break;
		case "O":
			echo "Otros Pesajes";
			break;
		default:
			echo "NO DEFINIDO";
			break;
	}
	?>
      &nbsp;</td>
    <td width="121" align="center">
<input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="Proceso('S')">
    </td>
  </tr>
  <tr bgcolor='#FFFFFF'> 
    <td>Producto: </td>
    <td colspan="2">
      <?php
	switch ($TipoConsulta)	
	{
		case "R":
			if ($Producto != "S")
				$Consulta = "SELECT distinct(C_PROD_A), D_PROD_A from rec_web.recepciones where C_PROD_A = '".$Producto."'";
				
			else
				echo "TODOS LOS PRODUCTOS";
			break;
		case "D":
			if ($Producto != "S")
				$Consulta = "SELECT distinct(C_PROD_A), D_PROD_A from rec_web.despachos where C_PROD_A = '".$Producto."'";
			else
				echo "TODOS LOS PRODUCTOS";
			break;
		case "O":
			if (($IdProducto == "*") || ($IdProducto == ""))
				echo "TODOS";
			else
				echo $IdProducto;
			break;		
	}	
	if ((($TipoConsulta == "R") || ($TipoConsulta == "D")) && ($Producto != "S"))
	{
		$Respuesta = mysqli_query($link, $Consulta);
		
		if ($Row = mysqli_fetch_array($Respuesta))
			echo $Row[C_PROD_A]." - ".$Row[D_PROD_A];
		else
			echo "NO DEFINIDO";
	}
	?>
      &nbsp;</td>
  </tr>
  <tr bgcolor='#FFFFFF'> 
    <td>Proveedor:</td>
    <td colspan="2">
      <?php
	switch ($TipoConsulta)	
	{
		case "R":
			if ($RutProveedor != "S")
				$Consulta = "SELECT distinct(R_PROV_A), D_PROV_A from rec_web.recepciones where R_PROV_A = '".$RutProveedor."'";
			else
				echo "TODOS LOS PROVEEDORES";
			break;
		case "D":
			if ($RutProveedor != "S")
				$Consulta = "SELECT distinct(R_PROV_A), D_PROV_A from rec_web.despachos where R_PROV_A = '".$RutProveedor."'";
			else
				echo "TODOS LOS PROVEEDORES";
			break;
		case "O":
			if (($IdProveedor == "*") || ($IdProveedor == ""))
				echo "TODOS";
			else
				echo $IdProveedor;
			break;		
	}	
	if ((($TipoConsulta == "R") || ($TipoConsulta == "D"))  && ($RutProveedor != "S"))
	{
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
			echo $Row[R_PROV_A]." - ".$Row[D_PROV_A];
		else
			echo "NO DEFINIDO";
	}
	?>
      &nbsp;</td>
  </tr>
  <tr bgcolor='#FFFFFF'> 
    <td>Fecha Consulta:</td>
    <td colspan="2">
      <?php
	echo $TxtFechaIni." AL ";
	echo $TxtFechaFin;
	?>
      &nbsp;</td>
  </tr>
<?php
	if ($Lote == "S")
	{
		echo "<tr bgcolor='#FFFFFF'>\n"; 
		echo "<td>Lote Consulta:</td>\n";
		echo "<td colspan='2'>".$TxtLote."&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>  
</table>
<br>
<?php
	
	switch($Ordenado)
	{
		case "F":
			$OrderBy=" order by t2.folio";
			break;
		case "L":
			$OrderBy=" order by t1.Lote,recargo2";
			break;
		case "PB":
			$OrderBy=" order by t2.peso_bruto";
			break;
		case "PT":
			$OrderBy=" order by t2.peso_tara";
			break;
		case "PN":
			$OrderBy=" order by t2.peso_neto";
			break;
		case "PN":
			$OrderBy=" order by t2.peso_neto";
			break;
		case "RP":
			$OrderBy=" order by t1.rut_proveedor,t1.Lote,recargo2";
			break;
		case "NF":
			$OrderBy=" order by nom_faena,t1.Lote,recargo2";
			break;
		case "DPV":
			$OrderBy=" order by nom_proveedor,t1.Lote,recargo2";
			break;
		case "DPD":
			$OrderBy=" order by nom_subproducto,t1.Lote,recargo2";
			break;
		case "C":
			$OrderBy=" order by t1.num_conjunto,t1.Lote,recargo2";
			break;
		case "G":
			$OrderBy=" order by guia_despacho2,t1.Lote,recargo2";
			break;
		case "RP2":
			$OrderBy=" order by rut_proveedor2";
			break;
		case "DPV2":
			$OrderBy=" order by nom_proveedor";
			break;
		case "DPD2":
			$OrderBy=" order by nom_subproducto";
			break;
		default:
			if($OptAcumulado=='N'||$Lote=='S')
				$OrderBy=" order by t2.fecha_recepcion, t2.hora_entrada";
			else
				$OrderBy=" order by rut_proveedor2";
			break;	
	}
	$FechaIni = $TxtFechaIni;
	$FechaFin = $TxtFechaFin;
	switch ($TipoConsulta)
	{
		case "R": // CONSULTA RECEPCIONES
				if ($Lote == "S")
				{
				
				
					$ConsLote = "S";
					$Consulta = "SELECT distinct t1.lote,t5.nommin_a as nom_faena,t1.num_conjunto,t1.cod_faena,t2.recargo,t2.folio,t2.corr,t2.fecha_recepcion,t2.hora_entrada,t2.hora_salida,t2.peso_bruto,t2.peso_tara, ";
					$Consulta.= "t2.peso_neto,t1.rut_proveedor,t3.nomprv_a as nom_proveedor,t1.cod_subproducto,t4.descripcion as nom_subproducto,t2.guia_despacho,lpad(t2.guia_despacho,7,'0')as guia_despacho2,t2.patente,t2.cod_descarga ";
					$Consulta.= "from age_web.lotes t1 inner join age_web.detalle_lotes t2  on t1.lote=t2.lote inner join rec_web.proved t3 on t1.rut_proveedor =t3.rutprv_a ";
					$Consulta.= "inner join proyecto_modernizacion.subproducto t4 on t4.cod_producto='1' and t1.cod_subproducto=t4.cod_subproducto left join rec_web.minaprv t5 on t1.cod_faena=t5.codmin_a where t1.lote = '".$TxtLote."' ";
					$Consulta.= $OrderBy;
					//echo "...".$Consulta."<br>";
					//TITULOS DIARIO POR LOTE
					echo "<table width='1500' border='0' cellpadding='1' cellspacing='1' bgcolor='#000000' class='TablaInterior'>\n";
					echo "<tr class='ColorTabla01' align='center'>\n";
					echo "<td>LOTE</td>\n";
					echo "<td>REC</td>\n";					
					echo "<td>FECHA</td>\n";
					echo "<td>HORA ENTR.</td>\n";
					echo "<td>HORA SAL.</td>\n";
					echo "<td>FOLIO</td>\n";
					echo "<td>CORREL.</td>\n";					
					echo "<td>PESO BRUTO</td>\n";
					echo "<td>PESO TARA</td>\n";
					echo "<td>PESO NETO</td>\n";
					echo "<td>RUT PROV.</td>\n";
					echo "<td>DECR. PROV</td>\n";
					echo "<td>FAENA</td>\n";
					echo "<td>NOM. FAENA</td>\n";
					echo "<td>C_PROD</td>\n";
					echo "<td>DEC. PROD.</td>\n";
					echo "<td>GUIA</td>\n";
					echo "<td>PATENTE</td>\n";
					echo "<td>CONJ.</td>\n";
					echo "</tr>\n";				
				}
				else
				{
					if ($OptAcumulado == "N")
					{							
					
					
						$Consulta = "SELECT distinct t1.lote,t5.nommin_a as nom_faena,t1.num_conjunto,t1.cod_faena,t2.recargo,lpad(t2.recargo,2,'0')as recargo2,t2.folio,t2.corr,t2.fecha_recepcion,t2.hora_entrada,t2.hora_salida,t2.peso_bruto,t2.peso_tara, ";
						$Consulta.= "t2.peso_neto,t1.rut_proveedor,t3.nomprv_a as nom_proveedor,t1.cod_subproducto,t4.descripcion as nom_subproducto,t2.guia_despacho,lpad(t2.guia_despacho,7,'0')as guia_despacho2,t2.patente,t2.cod_descarga ";
						$Consulta.= "from age_web.lotes t1 inner join age_web.detalle_lotes t2  on t1.lote=t2.lote inner join rec_web.proved t3 on t1.rut_proveedor =t3.rutprv_a ";
						$Consulta.= "inner join proyecto_modernizacion.subproducto t4 on t4.cod_producto='1' and t1.cod_subproducto=t4.cod_subproducto left join rec_web.minaprv t5 on t1.cod_faena=t5.codmin_a where ";
						$Consulta.= "t2.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' ";
						if ($Producto != "S")
							$Consulta.= " and t1.cod_subproducto = ".$Producto."";
						if ($RutProveedor != "S")
							$Consulta.= " and t1.rut_proveedor = '".$RutProveedor."'";
						$Consulta.= $OrderBy;
						//echo "xxxx".$Consulta."<br>";
						//TITULOS DIARIO
						echo "<table width='1500'  border='0' cellpadding='1' cellspacing='1' bgcolor='#000000' class='TablaInterior'>\n";
						echo "<tr class='ColorTabla01' align='center'>\n";
						echo "<td><a href=JavaScript:Ordenar('F')>FOLIO</td>\n";
						echo "<td>CORREL.</a></td>\n";
						echo "<td>FECHA</td>\n";
						echo "<td>HORA ENTR.</td>\n";
						echo "<td>HORA SAL.</td>\n";
						echo "<td><a href=JavaScript:Ordenar('L')>LOTE</a></td>\n";
						echo "<td>REC</td>\n";
						echo "<td><a href=JavaScript:Ordenar('PB')>PESO BRUTO</a></td>\n";
						echo "<td><a href=JavaScript:Ordenar('PT')>PESO TARA</a></td>\n";
						echo "<td><a href=JavaScript:Ordenar('PN')>PESO NETO</a></td>\n";
						echo "<td><a href=JavaScript:Ordenar('RP')>RUT PROV.</a></td>\n";
						echo "<td><a href=JavaScript:Ordenar('DPV')>DECR. PROV</a></td>\n";
						echo "<td>FAENA</td>\n";
						echo "<td><a href=JavaScript:Ordenar('NF')>NOM. FAENA</a></td>\n";
						echo "<td>PROD.</td>\n";
						echo "<td><a href=JavaScript:Ordenar('DPD')>DEC. PROD.</a></td>\n";
						echo "<td><a href=JavaScript:Ordenar('G')>GUIA</a></td>\n";
						echo "<td>PATENTE</td>\n";
						echo "<td><a href=JavaScript:Ordenar('C')>CONJ</a></td>\n";
						echo "</tr>\n";
					}
					else
					{				
						$Consulta = "SELECT t1.rut_proveedor,lpad(t1.rut_proveedor,10,'0') as rut_proveedor2,t3.nomprv_a as nom_proveedor,t4.descripcion as nom_subproducto,SUM(peso_bruto) AS peso_bruto, SUM(peso_tara) AS peso_tara, SUM(peso_neto) AS peso_neto ";
						$Consulta.= "from age_web.lotes t1 inner join age_web.detalle_lotes t2  on t1.lote=t2.lote inner join rec_web.proved t3 on t1.rut_proveedor =t3.rutprv_a ";
						$Consulta.= "inner join proyecto_modernizacion.subproducto t4 on t4.cod_producto='1' and t1.cod_subproducto=t4.cod_subproducto ";
						$Consulta.= "and t2.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' ";
						if ($Producto != "S")
							$Consulta.= " and t1.cod_subproducto = ".$Producto."";
						if ($RutProveedor != "S")
							$Consulta.= " and t1.rut_proveedor = '".$RutProveedor."'";
						$Consulta.= " group by t1.rut_proveedor,t1.cod_subproducto";
						$Consulta.=$OrderBy;
						//echo "lll".$consulta;
						//TITULOS ACUMULADO
						echo "<table width='700' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
						echo "<tr class='ColorTabla01' align='center'>\n";
						echo "<td><a href=JavaScript:Ordenar('RP2')>RUT PROV.<a/></td>\n";
						echo "<td><a href=JavaScript:Ordenar('DPV2')>NOM. PROV.<a/></td>\n";
						echo "<td><a href=JavaScript:Ordenar('DPD2')>PRODUCTO<a/></td>\n";
						echo "<td>PESO BRUTO</td>\n";
						echo "<td>PESO TARA</td>\n";
						echo "<td>PESO NETO</td>\n";
						echo "</tr>\n";
					}
				}
			break;
		case "D": // CONSULTA DESPACHOS
			if ($OptAcumulado == "N")
			{
				$Consulta = "SELECT * from rec_web.despachos where ";
				$Consulta.= " fecha_a between '".$FechaIni."' and '".$FechaFin."' ";
				if ($Producto != "S")
					$Consulta.= " and c_prod_a = ".$Producto."";
				if ($RutProveedor != "S")
					$Consulta.= " and r_prov_a = '".$RutProveedor."'";
				$Consulta.= " order by folios_a";				
				//TITULOS DIARIO
				echo "<table width='1500'border='0' cellpadding='1' cellspacing='1' bgcolor='#000000' class='TablaInterior'>\n";
				echo "<tr class='ColorTabla01'>\n";
				echo "<td>FOLIO</td>\n";
				echo "<td>CORREL.</td>\n";
				echo "<td>FECHA</td>\n";
				echo "<td>HORA ENTR.</td>\n";
				echo "<td>HORA SAL.</td>\n";
				echo "<td>LOTE</td>\n";
				echo "<td>RECARGO</td>\n";
				echo "<td>PESO BRUTO</td>\n";
				echo "<td>PESO TARA</td>\n";
				echo "<td>PESO NETO</td>\n";
				echo "<td>RUT PROV.</td>\n";
				echo "<td>DECR. PROV</td>\n";
				echo "<td>COD. PROD.</td>\n";
				echo "<td>DEC. PROD.</td>\n";
				echo "<td>GUIA</td>\n";
				echo "<td>PATENTE</td>\n";
				echo "</tr>\n";
			}
			else
			{
				$Consulta = "SELECT R_PROV_A, D_PROV_A, C_PROD_A, D_PROD_A, SUM(PESOBR_A) AS PESOBR_A, SUM(PESOTR_A) AS PESOTR_A, SUM(PESONT_A) AS PESONT_A ";
				$Consulta.= " from rec_web.despachos where ";
				$Consulta.= " fecha_a between '".$FechaIni."' and '".$FechaFin."' ";
				if ($Producto != "S")
					$Consulta.= " and c_prod_a = ".$Producto."";
				if ($RutProveedor != "S")
					$Consulta.= " and r_prov_a = '".$RutProveedor."'";
				$Consulta.= " group by R_PROV_A, C_PROD_A ";
				$Consulta.= " order by folios_a";
				//TITULOS ACUMULADO
				echo "<table width='700' border='0' cellpadding='1' cellspacing='1' bgcolor='#000000' class='TablaInterior'>\n";
				echo "<tr class='ColorTabla01'>\n";
				echo "<td>RUT PROV.</td>\n";
				echo "<td>NOM. PROV.</td>\n";
				echo "<td>PRODUCTO</td>\n";
				echo "<td>PESO BRUTO</td>\n";
				echo "<td>PESO TARA</td>\n";
				echo "<td>PESO NETO</td>\n";
				echo "</tr>\n";
			}
			break;
		case "O": // CONSULTA OTROS PESAJES
			if ($OptAcumulado == "N")
			{
				$Consulta = "SELECT * from rec_web.otros_pesajes where ";
				$Consulta.= " fecha_a between '".$FechaIni."' and '".$FechaFin."' ";
				if ($IdProducto != "*")
					$Consulta.= " and DESPRD_A like '%".$IdProducto."%'";
				if ($IdProveedor != "*")
					$Consulta.= " and IDENVI_A like '%".$IdProveedor."%'";
				$Consulta.= " order by FOLIOS_A ";				
				//TITULOS DIARIO
				echo "<table width='1300' border='0' cellpadding='1' cellspacing='1' bgcolor='#000000' class='TablaInterior'>\n";
				echo "<tr class='ColorTabla01'>\n";
				echo "<td>FOLIO</td>\n";
				echo "<td>CORREL.</td>\n";
				echo "<td>FECHA</td>\n";
				echo "<td>HORA ENTR.</td>\n";
				echo "<td>HORA SAL.</td>\n";
				echo "<td>ENVIA</td>\n";
				echo "<td>PRODUCTO</td>\n";
				echo "<td>PESO BRUTO</td>\n";
				echo "<td>PESO TARA</td>\n";
				echo "<td>PESO NETO</td>\n";
				echo "<td>GUIA</td>\n";
				echo "<td>PATENTE</td>\n";
				echo "</tr>\n";
			}
			else
			{
				$Consulta = "SELECT IDENVI_A, DESPRD_A, SUM(PESOBR_A) AS PESOBR_A, SUM(PESOTR_A) AS PESOTR_A, SUM(PESONT_A) AS PESONT_A ";
				$Consulta.= " from rec_web.otros_pesajes where ";
				$Consulta.= " fecha_a between '".$FechaIni."' and '".$FechaFin."' ";
				if ($IdProducto != "*")
					$Consulta.= " and DESPRD_A like '%".$IdProducto."%'";
				if ($IdProveedor != "*")
					$Consulta.= " and IDENVI_A like '%".$IdProveedor."%'";				
				$Consulta.= " group by IDENVI_A, DESPRD_A ";
				$Consulta.= " order by FOLIOS_A ";
				//TITULOS ACUMULADO
				echo "<table width='700' border='0' cellpadding='1' cellspacing='1' bgcolor='#000000' class='TablaInterior'>\n";
				echo "<tr class='ColorTabla01'>\n";
				echo "<td>ENVIA</td>\n";
				echo "<td>PRODUCTO</td>\n";
				echo "<td>PESO BRUTO</td>\n";
				echo "<td>PESO TARA</td>\n";
				echo "<td>PESO NETO</td>\n";
				echo "</tr>\n";
			}
			break;
	}
	$TotalBruto=0;
	$TotalTara=0;
	$TotalNeto=0;
	//echo "-----".$Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		//echo $Row[folio]."--".$Row["corr"];
		switch ($TipoConsulta)
		{
			case "R": //DETALLE RECEPCIONES
				if ($Lote == "S")
				{
					if ($Row[ACTIVO] == "M")
							echo "<tr bgcolor='#FFFFFF'> \n";
						else
							echo "<tr bgcolor='#FFFFFF'> \n";
							echo "<td>".$Row[lote]."</td>\n";
						echo "<td>".$Row["recargo"]."</td>\n";
						echo "<td>".$Row[fecha_recepcion]."</td>\n";
						echo "<td>".$Row[hora_entrada]."</td>\n";
						echo "<td>".$Row[hora_salida]."</td>\n";
						echo "<td>".$Row[folio]."</td>\n";
						echo "<td>".$Row["corr"]."</td>\n";												
						echo "<td align='right'>".$Row[peso_bruto]."</td>\n";
						echo "<td align='right'>".$Row["peso_tara"]."</td>\n";
						echo "<td align='right'>".$Row[peso_neto]."</td>\n";
						echo "<td>".$Row["rut_proveedor"]."</td>\n";
						echo "<td>".$Row[nom_proveedor]."</td>\n";
						echo "<td>".$Row[cod_faena]."&nbsp;</td>\n";
						echo "<td>".$Row[nom_faena]."&nbsp;</td>\n";
						echo "<td>".$Row[cod_subproducto]."</td>\n";
						echo "<td>".$Row["nom_subproducto"]."</td>\n";
						echo "<td>".$Row[guia_despacho]."</td>\n";
						echo "<td>".$Row["patente"]."</td>\n";
						echo "<td>".$Row[num_conjunto]."&nbsp;</td>\n";
						echo "</tr>\n";
						$TotalBruto = $TotalBruto + $Row[peso_bruto];
						$TotalTara = $TotalTara + $Row["peso_tara"];
						$TotalNeto = $TotalNeto + $Row[peso_neto];
				}
				else
				{
					if ($OptAcumulado == "N")
					{
						if ($Row[ACTIVO] == "M")
							echo "<tr bgcolor='#FFFFFF'> \n";
						else
							echo "<tr bgcolor='#FFFFFF'> \n";
						echo "<td>".$Row[folio]."</td>\n";
						echo "<td>".$Row["corr"]."</td>\n";
						echo "<td>".$Row[fecha_recepcion]."</td>\n";
						echo "<td>".$Row[hora_entrada]."</td>\n";
						echo "<td>".$Row[hora_salida]."</td>\n";
						echo "<td>".$Row[lote]."</td>\n";
						echo "<td>".$Row["recargo"]."</td>\n";
						echo "<td align='right'>".$Row[peso_bruto]."</td>\n";
						echo "<td align='right'>".$Row["peso_tara"]."</td>\n";
						echo "<td align='right'>".$Row[peso_neto]."</td>\n";
						echo "<td>".$Row["rut_proveedor"]."</td>\n";
						echo "<td>".$Row[nom_proveedor]."</td>\n";
						echo "<td>".$Row[cod_faena]."&nbsp;</td>\n";
						echo "<td>".$Row[nom_faena]."&nbsp;</td>\n";
						echo "<td>".$Row[cod_subproducto]."</td>\n";
						echo "<td>".$Row["nom_subproducto"]."</td>\n";
						echo "<td>".$Row[guia_despacho]."</td>\n";
						echo "<td>".$Row["patente"]."</td>\n";
						echo "<td>".$Row[num_conjunto]."&nbsp;</td>\n";
						echo "</tr>\n";
						$TotalBruto = $TotalBruto + $Row[peso_bruto];
						$TotalTara = $TotalTara + $Row["peso_tara"];
						$TotalNeto = $TotalNeto + $Row[peso_neto];
					}
					else
					{
						echo "<tr bgcolor='#FFFFFF'> \n";
						echo "<td align='left'>".$Row["rut_proveedor"]."</td>\n";
						echo "<td align='left'>".$Row[nom_proveedor]."</td>\n";
						echo "<td align='left'>".$Row["nom_subproducto"]."</td>\n";
						echo "<td align='right'>".$Row[peso_bruto]."</td>\n";
						echo "<td align='right'>".$Row["peso_tara"]."</td>\n";
						echo "<td align='right'>".$Row[peso_neto]."</td>\n";
						echo "</tr> \n";
						$TotalBruto = $TotalBruto + $Row[peso_bruto];
						$TotalTara = $TotalTara + $Row["peso_tara"];
						$TotalNeto = $TotalNeto + $Row[peso_neto];
					}
				}
				break;
			case "D": // DETALLE DESPACHOS
				if ($OptAcumulado == "N")
				{
					echo "<tr bgcolor='#FFFFFF'> \n";
					echo "<td>".$Row[FOLIOS_A]."</td>\n";
					echo "<td>".$Row[CORDES_A]."</td>\n";
					echo "<td>".$Row["FECHA_A"]."</td>\n";
					echo "<td>".$Row[HORA_A]."</td>\n";
					echo "<td>".$Row[HORA2_A]."</td>\n";
					echo "<td>".$Row[LOTE_A]."</td>\n";
					echo "<td>".$Row["RECARG_A"]."</td>\n";
					echo "<td align='right'>".$Row[PESOBR_A]."</td>\n";
					echo "<td align='right'>".$Row[PESOTR_A]."</td>\n";
					echo "<td align='right'>".$Row[PESONT_A]."</td>\n";
					echo "<td>".$Row[R_PROV_A]."</td>\n";
					echo "<td>".$Row[D_PROV_A]."</td>\n";
					echo "<td>".$Row[C_PROD_A]."</td>\n";
					echo "<td>".$Row[D_PROD_A]."</td>\n";
					echo "<td>".$Row[GUIADP_A]."</td>\n";
					echo "<td>".$Row[PATENT_A]."</td>\n";
					echo "</tr>\n";
					$TotalBruto = $TotalBruto + $Row[PESOBR_A];
					$TotalTara = $TotalTara + $Row[PESOTR_A];
					$TotalNeto = $TotalNeto + $Row[PESONT_A];
				}
				else
				{
					echo "<tr bgcolor='#FFFFFF'> \n";
					echo "<td align='left'>".$Row[R_PROV_A]."</td>\n";
					echo "<td align='left'>".$Row[D_PROV_A]."</td>\n";
					echo "<td align='left'>".$Row[D_PROD_A]."</td>\n";
					echo "<td align='right'>".$Row[PESOBR_A]."</td>\n";
					echo "<td align='right'>".$Row[PESOTR_A]."</td>\n";
					echo "<td align='right'>".$Row[PESONT_A]."</td>\n";
					echo "</tr> \n";
					$TotalBruto = $TotalBruto + $Row[PESOBR_A];
					$TotalTara = $TotalTara + $Row[PESOTR_A];
					$TotalNeto = $TotalNeto + $Row[PESONT_A];
				}
				break;
			case "O": // DETALLE OTROS PESAJES
				if ($OptAcumulado == "N")
				{
					echo "<tr bgcolor='#FFFFFF'> \n";
					echo "<td>".$Row[FOLIOS_A]."</td>\n";
					echo "<td>".$Row[COROTR_A]."</td>\n";
					echo "<td>".$Row["FECHA_A"]."</td>\n";
					echo "<td>".$Row[HORA_A]."</td>\n";
					echo "<td>".$Row[HORA2_A]."</td>\n";
					echo "<td>".$Row[IDENVI_A]."</td>\n";
					echo "<td>".$Row[DESPRD_A]."</td>\n";
					echo "<td align='right'>".$Row[PESOBR_A]."</td>\n";
					echo "<td align='right'>".$Row[PESOTR_A]."</td>\n";
					echo "<td align='right'>".$Row[PESONT_A]."</td>\n";
					echo "<td>".$Row[NUMGUI_A]."</td>\n";
					echo "<td>".$Row[PATENT_A]."</td>\n";
					echo "</tr>\n";
					$TotalBruto = $TotalBruto + $Row[PESOBR_A];
					$TotalTara = $TotalTara + $Row[PESOTR_A];
					$TotalNeto = $TotalNeto + $Row[PESONT_A];
				}
				else
				{
					echo "<tr bgcolor='#FFFFFF'> \n";
					echo "<td align='left'>".$Row[IDENVI_A]."</td>\n";
					echo "<td align='left'>".$Row[DESPRD_A]."</td>\n";
					echo "<td align='right'>".$Row[PESOBR_A]."</td>\n";
					echo "<td align='right'>".$Row[PESOTR_A]."</td>\n";
					echo "<td align='right'>".$Row[PESONT_A]."</td>\n";
					echo "</tr> \n";
					$TotalBruto = $TotalBruto + $Row[PESOBR_A];
					$TotalTara = $TotalTara + $Row[PESOTR_A];
					$TotalNeto = $TotalNeto + $Row[PESONT_A];
				}
				break;
		}
	}
	//TOTALES
	switch ($TipoConsulta)
	{
		case "R": // TOTALES RECEPCIONES
			if ($Lote == "S")
			{
				echo "<tr class='ColorTabla01' bgcolor='#FFFFFF'>\n";
				echo "<td colspan='7' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".$TotalBruto."</td>\n";
				echo "<td align='right'>".$TotalTara."</td>\n";
				echo "<td align='right'>".$TotalNeto."</td>\n";
				echo "<td colspan='15'>&nbsp;</td>\n";
				echo "</tr>\n";
			}
			else
			{
				if ($OptAcumulado == "N")
				{
					echo "<tr class='ColorTabla01' bgcolor='#FFFFFF'>\n";
					echo "<td colspan='7' align='right'><strong>TOTALES</strong></td>\n";
					echo "<td align='right'>".$TotalBruto."</td>\n";
					echo "<td align='right'>".$TotalTara."</td>\n";
					echo "<td align='right'>".$TotalNeto."</td>\n";
					echo "<td colspan='15'>&nbsp;</td>\n";
					echo "</tr>\n";
				}
				else
				{
					echo "<tr class='ColorTabla01' bgcolor='#FFFFFF'>\n";
					echo "<td colspan='3' align='right'><strong>TOTALES</strong></td>\n";
					echo "<td align='right'>".$TotalBruto."</td>\n";
					echo "<td align='right'>".$TotalTara."</td>\n";
					echo "<td align='right'>".$TotalNeto."</td>\n";
					echo "</tr>\n";
				}
			}
			break;
		case "D":  // TOTALES DESPACHOS
			if ($OptAcumulado == "N")
			{
				echo "<tr class='ColorTabla01' bgcolor='#FFFFFF'>\n";
				echo "<td colspan='7' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".$TotalBruto."</td>\n";
				echo "<td align='right'>".$TotalTara."</td>\n";
				echo "<td align='right'>".$TotalNeto."</td>\n";
				echo "<td colspan='13'>&nbsp;</td>\n";
				echo "</tr>\n";
			}
			else
			{
				echo "<tr class='ColorTabla01' bgcolor='#FFFFFF'>\n";
				echo "<td colspan='3' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".$TotalBruto."</td>\n";
				echo "<td align='right'>".$TotalTara."</td>\n";
				echo "<td align='right'>".$TotalNeto."</td>\n";
				echo "</tr>\n";
			}
			break;
		case "O": // TOTALES OTROS PESAJES
			if ($OptAcumulado == "N")
			{
				echo "<tr class='ColorTabla01' bgcolor='#FFFFFF'>\n";
				echo "<td colspan='7' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".$TotalBruto."</td>\n";
				echo "<td align='right'>".$TotalTara."</td>\n";
				echo "<td align='right'>".$TotalNeto."</td>\n";
				echo "<td colspan='13'>&nbsp;</td>\n";
				echo "</tr>\n";
			}
			else
			{
				echo "<tr class='ColorTabla01' bgcolor='#FFFFFF'>\n";
				echo "<td colspan='2' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".$TotalBruto."</td>\n";
				echo "<td align='right'>".$TotalTara."</td>\n";
				echo "<td align='right'>".$TotalNeto."</td>\n";
				echo "</tr>\n";
			}
			break;
	}
?></table>
</form>
</body>
</html>
