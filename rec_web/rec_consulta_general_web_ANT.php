<?php
	//echo "fecha:".$TxtFechaIni."<br>";
	if(substr($TxtFechaIni,0,4)>='2006')
	{
		$Param='TipoConsulta='.$TipoConsulta.'&TxtFechaIni='.$TxtFechaIni.'&TxtFechaFin='.$TxtFechaFin.'&Producto='.$Producto.'&RutProveedor='.$RutProveedor.'&OptAcumulado='.$OptAcumulado;
		if($Destino=='W')
			header('location:rec_consulta_general_web_sipa.php?'.$Param);
		else
			header('location:rec_consulta_general_web_sipa_excel.php?'.$Param);
	}
	$CodigoDeSistema = 8;
	include("../principal/conectar_principal.php");
?>
<html>
<head>
<title>Sistema de Recepci&oacute;n</title>
<link href="../principal/estilos/css_rec_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "S":
			f.action='rec_consulta_general.php';
			f.submit();
			break;
	}
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
<table width="700" border="0" cellspacing="1" cellpadding="1" class="TablaInterior">
  <tr> 
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
  <tr> 
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
  <tr> 
    <td>Proveedor:</td>
    <td colspan="2">
      <?php
	  if ($RutProveedor!="S")
		  $RutProveedor=str_pad($RutProveedor,10,'0',STR_PAD_LEFT);
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
  <tr> 
    <td>Fecha Consulta:</td>
    <td colspan="2">
      <?php
	echo substr($TxtFechaIni,8,2)."/".substr($TxtFechaIni,5,2)."/".substr($TxtFechaIni,0,4)." AL ";
	echo substr($TxtFechaFin,8,2)."/".substr($TxtFechaFin,5,2)."/".substr($TxtFechaFin,0,4);
	?>
      &nbsp;</td>
  </tr>
<?php
	if ($Lote == "S")
	{
		echo "<tr>\n"; 
		echo "<td>Lote Consulta:</td>\n";
		echo "<td colspan='2'>".$TxtLote."&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>  
</table>
<br>
<?php
	$FechaIni = $TxtFechaIni;
	$FechaFin = $TxtFechaFin;
	switch ($TipoConsulta)
	{
		case "R": // CONSULTA RECEPCIONES
				if ($Lote == "S")
				{
					$ConsLote = "S";
					$Consulta = "SELECT * from rec_web.recepciones where ";
					$Consulta.= " lote_a = '".$TxtLote."'";
					$Consulta.= " order by fecha_a, hora_a";
					//TITULOS DIARIO POR LOTE
					echo "<table width='2400' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
					echo "<tr class='ColorTabla01'>\n";
					echo "<td>LOTE</td>\n";
					echo "<td>RECARGO</td>\n";					
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
					echo "<td>COD. PROD.</td>\n";
					echo "<td>DEC. PROD.</td>\n";
					echo "<td>PASTAS</td>\n";
					echo "<td>IMPUREZAS</td>\n";
					echo "<td>HUMEDAD</td>\n";
					echo "<td>ACIDOS</td>\n";
					echo "<td>DESCARGA</td>\n";
					echo "<td>GUIA</td>\n";
					echo "<td>PATENTE</td>\n";
					echo "<td>CONJUNTO</td>\n";
					echo "<td>S.A.</td>\n";
					echo "<td>MODIF.</td>\n";
					echo "</tr>\n";				
				}
				else
				{
					if ($OptAcumulado == "N")
					{							
						$Consulta = "SELECT * from rec_web.recepciones where ";
						$Consulta.= " fecha_a between '".$FechaIni."' and '".$FechaFin."' ";
						if ($Producto != "S")
							$Consulta.= " and c_prod_a = ".$Producto."";
						if ($RutProveedor != "S")
							$Consulta.= " and r_prov_a = '".$RutProveedor."'";
						$Consulta.= " order by fecha_a, hora_a";
						//echo $Consulta;
						//TITULOS DIARIO
						echo "<table width='2400' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
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
						echo "<td>FAENA</td>\n";
						echo "<td>NOM. FAENA</td>\n";
						echo "<td>COD. PROD.</td>\n";
						echo "<td>DEC. PROD.</td>\n";
						echo "<td>PASTAS</td>\n";
						echo "<td>IMPUREZAS</td>\n";
						echo "<td>HUMEDAD</td>\n";
						echo "<td>ACIDOS</td>\n";
						echo "<td>DESCARGA</td>\n";
						echo "<td>GUIA</td>\n";
						echo "<td>PATENTE</td>\n";
						echo "<td>CONJUNTO</td>\n";
						echo "<td>S.A.</td>\n";
						echo "<td>MODIF.</td>\n";
						echo "</tr>\n";
					}
					else
					{				
						$Consulta = "SELECT R_PROV_A, D_PROV_A, C_PROD_A, D_PROD_A, SUM(PESOBR_A) AS PESOBR_A, SUM(PESOTR_A) AS PESOTR_A, SUM(PESONT_A) AS PESONT_A ";
						$Consulta.= " from rec_web.recepciones where ";
						$Consulta.= " fecha_a between '".$FechaIni."' and '".$FechaFin."' ";
						if ($Producto != "S")
							$Consulta.= " and c_prod_a = ".$Producto."";
						if ($RutProveedor != "S")
							$Consulta.= " and r_prov_a = '".$RutProveedor."'";
						$Consulta.= " group by R_PROV_A , C_PROD_A";
						$Consulta.= " order by folios_a";
						//TITULOS ACUMULADO
						echo "<table width='700' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
						echo "<tr class='ColorTabla01'>\n";
						echo "<td>RUT PROV.</td>\n";
						echo "<td>NOM. PROV.</td>\n";
						echo "<td>PRODUCTO</td>\n";
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
				echo "<table width='1500' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
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
				echo "<table width='700' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
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
				echo "<table width='1300' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
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
				echo "<table width='700' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
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
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		switch ($TipoConsulta)
		{
			case "R": //DETALLE RECEPCIONES
				if ($Lote == "S")
				{
					if ($Row[ACTIVO] == "M")
							echo "<tr bgcolor='#FFFFFF'> \n";
						else
							echo "<tr> \n";
							echo "<td>".$Row[LOTE_A]."</td>\n";
						echo "<td>".$Row["RECARG_A"]."</td>\n";
						echo "<td>".$Row["FECHA_A"]."</td>\n";
						echo "<td>".$Row[HORA_A]."</td>\n";
						echo "<td>".$Row[HORA2_A]."</td>\n";
						echo "<td>".$Row[FOLIOS_A]."</td>\n";
						echo "<td>".$Row[CORREC_A]."</td>\n";												
						echo "<td align='right'>".$Row[PESOBR_A]."</td>\n";
						echo "<td align='right'>".$Row[PESOTR_A]."</td>\n";
						echo "<td align='right'>".$Row[PESONT_A]."</td>\n";
						echo "<td>".$Row[R_PROV_A]."</td>\n";
						echo "<td>".$Row[D_PROV_A]."</td>\n";
						echo "<td>".$Row[C_FAEN_A]."</td>\n";
						echo "<td>".$Row[N_FAEN_A]."</td>\n";
						echo "<td>".$Row[C_PROD_A]."</td>\n";
						echo "<td>".$Row[D_PROD_A]."</td>\n";
						echo "<td>".str_replace("  ",", ",trim($Row[D_PAST_A]))."</td>\n";
						echo "<td>".str_replace("  ",", ",trim($Row[D_IMPU_A]))."</td>\n";
						echo "<td>".$Row[HUMEDA_A]."</td>\n";
						echo "<td>".$Row[ACIDOS_A]."</td>\n";
						echo "<td>".$Row[DESCGA_A]."</td>\n";
						echo "<td>".$Row[GUIADP_A]."</td>\n";
						echo "<td>".$Row[PATENT_A]."</td>\n";
						echo "<td>".$Row[CONJTO_A]."</td>\n";
						echo "<td>&nbsp;".$Row[SA_ASIGNADA]."</td>\n";
						if ($Row[ACTIVO] == "M")
							echo "<td align='center'><strong>SI</strong></td>\n";
						else
							echo "<td>&nbsp;</td>\n";					
						echo "</tr>\n";
						$TotalBruto = $TotalBruto + $Row[PESOBR_A];
						$TotalTara = $TotalTara + $Row[PESOTR_A];
						$TotalNeto = $TotalNeto + $Row[PESONT_A];
				}
				else
				{
					if ($OptAcumulado == "N")
					{
						if ($Row[ACTIVO] == "M")
							echo "<tr bgcolor='#FFFFFF'> \n";
						else
							echo "<tr> \n";
						echo "<td>".$Row[FOLIOS_A]."</td>\n";
						echo "<td>".$Row[CORREC_A]."</td>\n";
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
						echo "<td>".$Row[C_FAEN_A]."</td>\n";
						echo "<td>".$Row[N_FAEN_A]."</td>\n";
						echo "<td>".$Row[C_PROD_A]."</td>\n";
						echo "<td>".$Row[D_PROD_A]."</td>\n";
						echo "<td>".str_replace("  ",", ",trim($Row[D_PAST_A]))."</td>\n";
						echo "<td>".str_replace("  ",", ",trim($Row[D_IMPU_A]))."</td>\n";
						echo "<td>".$Row[HUMEDA_A]."</td>\n";
						echo "<td>".$Row[ACIDOS_A]."</td>\n";
						echo "<td>".$Row[DESCGA_A]."</td>\n";
						echo "<td>".$Row[GUIADP_A]."</td>\n";
						echo "<td>".$Row[PATENT_A]."</td>\n";
						echo "<td>".$Row[CONJTO_A]."</td>\n";
						echo "<td>&nbsp;".$Row[SA_ASIGNADA]."</td>\n";
						if ($Row[ACTIVO] == "M")
							echo "<td align='center'><strong>SI</strong></td>\n";
						else
							echo "<td>&nbsp;</td>\n";					
						echo "</tr>\n";
						$TotalBruto = $TotalBruto + $Row[PESOBR_A];
						$TotalTara = $TotalTara + $Row[PESOTR_A];
						$TotalNeto = $TotalNeto + $Row[PESONT_A];
					}
					else
					{
						echo "<tr> \n";
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
				}
				break;
			case "D": // DETALLE DESPACHOS
				if ($OptAcumulado == "N")
				{
					echo "<tr> \n";
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
					echo "<tr> \n";
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
					echo "<tr> \n";
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
					echo "<tr> \n";
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
				echo "<tr>\n";
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
					echo "<tr>\n";
					echo "<td colspan='7' align='right'><strong>TOTALES</strong></td>\n";
					echo "<td align='right'>".$TotalBruto."</td>\n";
					echo "<td align='right'>".$TotalTara."</td>\n";
					echo "<td align='right'>".$TotalNeto."</td>\n";
					echo "<td colspan='15'>&nbsp;</td>\n";
					echo "</tr>\n";
				}
				else
				{
					echo "<tr>\n";
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
				echo "<tr>\n";
				echo "<td colspan='7' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".$TotalBruto."</td>\n";
				echo "<td align='right'>".$TotalTara."</td>\n";
				echo "<td align='right'>".$TotalNeto."</td>\n";
				echo "<td colspan='13'>&nbsp;</td>\n";
				echo "</tr>\n";
			}
			else
			{
				echo "<tr>\n";
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
				echo "<tr>\n";
				echo "<td colspan='7' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".$TotalBruto."</td>\n";
				echo "<td align='right'>".$TotalTara."</td>\n";
				echo "<td align='right'>".$TotalNeto."</td>\n";
				echo "<td colspan='13'>&nbsp;</td>\n";
				echo "</tr>\n";
			}
			else
			{
				echo "<tr>\n";
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
