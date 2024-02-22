<?php
	$CodigoDeSistema = 8;
	include("../principal/conectar_principal.php");
	include("../sipa_web/funciones.php");

	$DatosLeyes=array();
	$Consulta = "SELECT distinct cod_leyes, LPAD(cod_leyes,4,'0') as orden, abreviatura as ley,cod_unidad ";
	$Consulta.=" from proyecto_modernizacion.leyes ";
	$Consulta.= " where cod_leyes<>''";
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Resp))
	{
		$DatosLeyes[$Fila["cod_leyes"]]=$Fila["ley"];
	}
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
			{	
				$Consulta = "SELECT  t2.cod_subproducto,t2.descripcion as nom_subpro from  proyecto_modernizacion.subproducto t2 ";
				$Consulta.= "where t2.cod_producto='1' and t2.cod_subproducto='".$Producto."'";
			}	
			else
				echo "TODOS LOS PRODUCTOS";
			break;
		case "D":
			if ($Producto != "S")
			{
				$prod = split('[-]',$Producto);
				$Consulta = "SELECT t2.cod_subproducto, t2.descripcion as nom_subpro from proyecto_modernizacion.subproducto t2 ";
				$Consulta.= "where t2.cod_producto = '".$prod[0]."' and t2.cod_subproducto = '".$prod[1]."'";
			}	
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
			echo $Row[cod_subproducto]." - ".$Row[nom_subpro];
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
		  $RutProveedor=$RutProveedor;
	switch ($TipoConsulta)	
	{
		case "R":
			if ($RutProveedor != "S")
			{
				$Consulta = "SELECT t2.rut_prv, t2.nombre_prv from sipa_web.proveedores t2 ";
				$Consulta.= "where t2.rut_prv = '".$RutProveedor."'";
			}	
			else
				echo "TODOS LOS PROVEEDORES";
			break;
		case "D":
			if ($RutProveedor != "S")
			{
				$Consulta = "SELECT t2.rut_prv, t2.nombre_prv from sipa_web.proveedores t2 ";
				$Consulta.= "where t2.rut_prv = '".$RutProveedor."'";
			}
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
			echo $RutProveedorAux." - ".strtoupper($Row["nombre_prv"]);
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
					$Consulta = "SELECT t1.rut_prv, t3.nombre_prv, t1.cod_subproducto,t2.descripcion as nom_subpro,t1.cod_mina,t4.nombre_mina ";
					$Consulta.= " from sipa_web.recepciones t1 left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto =t2.cod_subproducto ";
					$Consulta.= " left join sipa_web.proveedores t3 on t1.rut_prv=t3.rut_prv left join sipa_web.minaprv t4 on t1.rut_prv=t4.rut_prv and t1.cod_mina=t4.cod_mina ";
					$Consulta.= " where lote = '".$TxtLote."'";
					$Consulta.= " order by fecha, hora_entrada";
					//TITULOS DIARIO POR LOTE
					echo "<table width='2400' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
					echo "<tr class='ColorTabla01'>\n";
					echo "<td>LOTE</td>\n";
					echo "<td>RECARGO</td>\n";					
					echo "<td>FECHA</td>\n";
					echo "<td>HORA ENTR.</td>\n";
					echo "<td>HORA SAL.</td>\n";
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
					echo "<td>GUIA</td>\n";
					echo "<td>PATENTE</td>\n";
					echo "<td>CONJUNTO</td>\n";
					echo "<td>S.A.</td>\n";
					echo "<td>MODIF.</td>\n";
					echo "<td>BASC.ENT</td>\n";
					echo "<td>BASC.SAL</td>\n";
					echo "</tr>\n";				
				}
				else
				{
					if ($OptAcumulado == "N")
					{							
						$Consulta = "SELECT t1.lote,t1.correlativo,t1.fecha,t1.hora_entrada,t1.hora_salida,t1.guia_despacho,t1.rut_prv, t3.nombre_prv,t1.recargo,peso_bruto,peso_tara,peso_neto, ";
						$Consulta.= "t1.cod_subproducto,t2.descripcion as nom_subpro,t1.cod_mina,t4.nombre_mina,t1.leyes,t1.impurezas,t1.conjunto,t1.humedad,t1.patente,t1.sa_asignada,bascula_entrada,bascula_salida,romana_entrada,romana_salida ";
						$Consulta.= " from sipa_web.recepciones t1 left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto =t2.cod_subproducto ";
						$Consulta.= " left join sipa_web.proveedores t3 on t1.rut_prv=t3.rut_prv left join sipa_web.minaprv t4 on t1.rut_prv=t4.rut_prv and t1.cod_mina=t4.cod_mina ";
						$Consulta.= " where t1.estado <> 'A' and t1.fecha between '".$FechaIni."' and '".$FechaFin."' ";
						if ($Producto != "S")
							$Consulta.= " and t1.cod_subproducto = ".$Producto."";
						if ($RutProveedor != "S")
							$Consulta.= " and t1.rut_prv = '".$RutProveedor."'";
						$Consulta.= " order by fecha, hora_entrada";
						//echo "hola",$Consulta;
						//TITULOS DIARIO
						echo "<table width='2400' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
						echo "<tr class='ColorTabla01'>\n";
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
						echo "<td>GUIA</td>\n";
						echo "<td>PATENTE</td>\n";
						echo "<td>CONJUNTO</td>\n";
						echo "<td>S.A.</td>\n";
						echo "<td>MODIF.</td>\n";
						echo "<td>BASC.ENT</td>\n";
						echo "<td>BASC.SAL</td>\n";
						echo "</tr>\n";
					}
					else
					{				
						$Consulta = "SELECT t1.rut_prv, t3.nombre_prv, t1.cod_subproducto,t2.descripcion as nom_subpro, sum(peso_bruto) as peso_bruto, sum(peso_tara) as peso_tara, sum(peso_neto) as peso_neto ";
						$Consulta.= " from sipa_web.recepciones t1 left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto =t2.cod_subproducto ";
						$Consulta.= " left join sipa_web.proveedores t3 on t1.rut_prv=t3.rut_prv left join sipa_web.minaprv t4 on t1.rut_prv=t4.rut_prv and t1.cod_mina=t4.cod_mina ";
						$Consulta.= " where t1.estado <> 'A' and t1.fecha between '".$FechaIni."' and '".$FechaFin."' ";
						if ($Producto != "S")
							$Consulta.= " and t1.cod_subproducto = ".$Producto."";
						if ($RutProveedor != "S")
							$Consulta.= " and t1.rut_prv = '".$RutProveedor."'";
						$Consulta.= " group by t1.rut_prv , t1.cod_subproducto";
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
				$Consulta = "SELECT t1.correlativo,t1.fecha,t1.hora_entrada,t1.hora_salida,t1.lote,t1.recargo,t1.peso_bruto,t1.peso_neto,t1.peso_tara, ";
				$Consulta.= " t1.guia_despacho,t1.patente,t1.rut_prv, t1.cod_subproducto,t2.descripcion as nom_subpro,bascula_entrada,bascula_salida,romana_entrada,romana_salida ";
				$Consulta.= " from sipa_web.despachos t1 left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto =t2.cod_subproducto ";
				$Consulta.= " where t1.estado<>'A' and t1.fecha between '".$FechaIni."' and '".$FechaFin."' ";
				if ($Producto != "S")
					$Consulta.= " and t1.cod_producto = '".$prod[0]."' and t1.cod_subproducto = '".$prod[1]."'";
				if ($RutProveedor != "S")
					$Consulta.= " and t1.rut_prv like  '%".substr($RutProveedor,5,3)."%'";
//					$Consulta.= " and t1.rut_prv = '".$RutProveedor."'";
				//TITULOS DIARIO
				echo "<table width='1500' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
				echo "<tr class='ColorTabla01'>\n";
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
				echo "<td>BASC.ENT</td>\n";
				echo "<td>BASC.SAL</td>\n";
				echo "</tr>\n";
			}
			else
			{
				$Consulta = "SELECT t1.rut_prv, t3.nombre_prv, t1.cod_subproducto,t2.descripcion as nom_subpro, sum(peso_bruto) as peso_bruto, sum(peso_tara) as peso_tara, sum(peso_neto) as peso_neto ";
				$Consulta.= " from sipa_web.despachos t1 left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto =t2.cod_subproducto ";
				$Consulta.= " left join sipa_web.proveedores t3 on t1.rut_prv=t3.rut_prv ";
				$Consulta.= " where t1.fecha between '".$FechaIni."' and '".$FechaFin."' ";
				if ($Producto != "S")
					$Consulta.= " and t1.cod_producto = '".$prod[0]."' and '".$prod[1]."'";
				if ($RutProveedor != "S")			
					$Consulta.= " and t1.rut_prv = '".$RutProveedor."'";
				$Consulta.= " group by t1.rut_prv, t3.nombre_prv, t1.cod_subproducto, nom_subpro";
				//echo $Consulta."<br>";
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
				$Consulta = "SELECT * from sipa_web.otros_pesaje where estado <> 'A' and ";
				$Consulta.= " fecha between '".$FechaIni."' and '".$FechaFin."' ";
				if ($IdProducto != "*")
					$Consulta.= " and nombre like '%".$IdProducto."%'";
				if ($IdProveedor != "*")
					$Consulta.= " and descripcion like '%".$IdProveedor."%'";
				//TITULOS DIARIO
				echo "<table width='1300' border='1' cellspacing='0' cellpadding='0' class='TablaDetalle'>\n";
				echo "<tr class='ColorTabla01'>\n";
				echo "<td>CORREL.</td>\n";
				echo "<td>FECHA</td>\n";
				echo "<td>HORA ENTR.</td>\n";
				echo "<td>HORA SAL.</td>\n";
				echo "<td>ENVIA</td>\n";
				echo "<td>PRODUCTO</td>\n";
				echo "<td>PESO BRUTO</td>\n";
				echo "<td>PESO TARA</td>\n";
				echo "<td>PESO NETO</td>\n";
				echo "<td>GUIA&nbsp;</td>\n";
				echo "<td>PATENTE</td>\n";
				echo "<td>BASC.ENT</td>\n";
				echo "<td>BASC.SAL</td>\n";
				echo "</tr>\n";
			}
			else
			{
				$Consulta = "SELECT nombre, descripcion, sum(peso_bruto) as peso_bruto, sum(peso_tara) as peso_tara, sum(peso_neto) as peso_neto ";
				$Consulta.= " from sipa_web.otros_pesaje where estado <> 'A' and ";
				$Consulta.= " fecha between '".$FechaIni."' and '".$FechaFin."' ";
				if ($IdProducto != "*")
					$Consulta.= " and descripcion like '%".$IdProducto."%'";
				if ($IdProveedor != "*")
					$Consulta.= " and nombre like '%".$IdProveedor."%'";				
				$Consulta.= " group by descripcion, nombre ";
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
	$Cont_reg=0;
//echo "hola", $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{	
		$ArrayRut = explode("~", $Row[rut_prv]);
		$Cont_reg++;
		$RutProveedorAux=$ArrayRut[0];
		switch ($TipoConsulta)
		{
			case "R": //DETALLE RECEPCIONES
				if ($Lote == "S")
				{
					if ($Row[ACTIVO] == "M")
							echo "<tr bgcolor='#FFFFFF'> \n";
						else
							echo "<tr> \n";
							echo "<td>".$Row[lote]."</td>\n";
						echo "<td>".$Row["recargo"]."</td>\n";
						echo "<td>".$Row["fecha"]."</td>\n";
						echo "<td>".$Row[hora_entrada]."</td>\n";
						echo "<td>".$Row[hora_salida]."</td>\n";
						echo "<td>".$Row[correlativo]."</td>\n";												
						echo "<td align='right'>".number_format($Row[peso_bruto],0,",",".")."</td>\n";
						echo "<td align='right'>".number_format($Row["peso_tara"],0,",",".")."</td>\n";
						echo "<td align='right'>".number_format($Row[peso_neto],0,",",".")."</td>\n";
						echo "<td>".$RutProveedorAux."</td>\n";
						echo "<td>".$Row["nombre_prv"]."</td>\n";
						echo "<td>".$Row["cod_mina"]."</td>\n";
						echo "<td>".$Row[nombre_mina]."</td>\n";
						echo "<td>".$Row[cod_subproducto]."</td>\n";
						echo "<td>".$Row[nom_subpro]."</td>\n";
						echo "<td>".str_replace("  ",", ",trim($Row[leyes]))."</td>\n";
						echo "<td>".str_replace("  ",", ",trim($Row[impurezas]))."</td>\n";
						echo "<td>".$Row[humedad]."</td>\n";
						echo "<td>".$Row[guia_despacho]."</td>\n";
						echo "<td>".$Row[petente]."</td>\n";
						echo "<td>".$Row[conjunto]."</td>\n";
						echo "<td>&nbsp;".$Row[sa_asignada]."</td>\n";
						if ($Row["activo"] == "M")
							echo "<td align='center'><strong>SI</strong></td>\n";
						else
							echo "<td>&nbsp;</td>\n";
						$BascEnt="";
						$BascSal="";	
						echo "<td align='Center'>".$Row[bascula_entrada]."&nbsp;</td>\n";
						echo "<td align='Center'>".$Row[bascula_salida]."&nbsp;</td>\n";						
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
							echo "<tr> \n";
						echo "<td>".$Row[correlativo]."</td>\n";
						echo "<td>".$Row["fecha"]."</td>\n";
						echo "<td>".$Row[hora_entrada]."</td>\n";
						echo "<td>".$Row[hora_salida]."</td>\n";
						echo "<td>".$Row[lote]."</td>\n";
						echo "<td>".$Row["recargo"]."</td>\n";
						echo "<td align='right'>".number_format($Row[peso_bruto],0,",",".")."</td>\n";
						echo "<td align='right'>".number_format($Row["peso_tara"],0,",",".")."</td>\n";
						echo "<td align='right'>".number_format($Row[peso_neto],0,",",".")."</td>\n";
						echo "<td>".$RutProveedorAux."</td>\n";
						echo "<td>".$Row["nombre_prv"]."</td>\n";
						echo "<td>".$Row["cod_mina"]."</td>\n";
						echo "<td>".$Row[nombre_mina]."</td>\n";
						echo "<td>".$Row[cod_subproducto]."</td>\n";
						echo "<td>".$Row[nom_subpro]."</td>\n";
						$Leyes=explode('~',$Row[leyes]);
						$StrLeyes='';
						while(list($c,$v)=each($Leyes))
						{
							$StrLeyes=$StrLeyes.$DatosLeyes[$v].",";
						}
						$StrLeyes=substr($StrLeyes,0,strlen($StrLeyes)-1);
						$Impurezas=explode('~',$Row[impurezas]);
						$StrImp='';
						while(list($c,$v)=each($Impurezas))
						{
							$StrImp=$StrImp.$DatosLeyes[$v].",";
						}
						$StrImp=substr($StrImp,0,strlen($StrImp)-1);
						echo "<td align='left'>".$StrLeyes."</td>";
						echo "<td align='left'>".$StrImp."</td>";
						echo "<td>".$Row[humedad]."</td>\n";
						echo "<td>".$Row[guia_despacho]."</td>\n";
						echo "<td>".$Row["patente"]."</td>\n";
						echo "<td>".$Row[conjunto]."</td>\n";
						echo "<td>&nbsp;".$Row[sa_asignada]."</td>\n";
						if ($Row["activo"] == "M")
							echo "<td align='center'><strong>SI</strong></td>\n";
						else
							echo "<td>&nbsp;</td>\n";
						$BascEnt="";
						$BascSal="";	
							echo "<td align='Center'>".$Row[bascula_entrada]."&nbsp;</td>\n";
						echo "<td align='Center'>".$Row[bascula_salida]."&nbsp;</td>\n";						
										
						echo "</tr>\n";
						$TotalBruto = $TotalBruto + $Row[peso_bruto];
						$TotalTara = $TotalTara + $Row["peso_tara"];
						$TotalNeto = $TotalNeto + $Row[peso_neto];
					}
					else
					{
						echo "<tr> \n";
						echo "<td align='left'>".$RutProveedorAux."</td>\n";
						echo "<td align='left'>".$Row["nombre_prv"]."</td>\n";
						echo "<td align='left'>".$Row[nom_subpro]."</td>\n";
						echo "<td align='right'>".number_format($Row[peso_bruto],0,",",".")."</td>\n";
						echo "<td align='right'>".number_format($Row["peso_tara"],0,",",".")."</td>\n";
						echo "<td align='right'>".number_format($Row[peso_neto],0,",",".")."</td>\n";
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
					echo "<tr> \n";
					echo "<td>".$Row[correlativo]."</td>\n";
					echo "<td>".$Row["fecha"]."</td>\n";
					echo "<td>".$Row[hora_entrada]."</td>\n";
					echo "<td>".$Row[hora_salida]."</td>\n";
					echo "<td>".$Row[lote]."</td>\n";
					echo "<td>".$Row["recargo"]."</td>\n";
					echo "<td align='right'>".number_format($Row[peso_bruto],0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($Row["peso_tara"],0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($Row[peso_neto],0,",",".")."</td>\n";
					echo "<td>".$RutProveedorAux."</td>\n";
					ObtenerProveedorDespacho('D',$Row[rut_prv],$Row[correlativo],$Row[guia_despacho],&$RutProved,&$NombreProved);
					$NomProv = strtoupper($NombreProved);
					echo "<td>".$NomProv."</td>\n";
					echo "<td>".$Row[cod_subproducto]."</td>\n";
					echo "<td>".$Row[nom_subpro]."</td>\n";
					echo "<td>".$Row[guia_despacho]."</td>\n";
					echo "<td>".$Row["patente"]."</td>\n";
					$BascEnt="";
					$BascSal="";	
						echo "<td align='Center'>".$Row[bascula_entrada]."&nbsp;</td>\n";
						echo "<td align='Center'>".$Row[bascula_salida]."&nbsp;</td>\n";						
					
					echo "</tr>\n";
					$TotalBruto = $TotalBruto + $Row[peso_bruto];
					$TotalTara = $TotalTara + $Row["peso_tara"];
					$TotalNeto = $TotalNeto + $Row[peso_neto];
				}
				else
				{
					echo "<tr> \n";
					echo "<td align='left'>".$RutProveedorAux."</td>\n";
					echo "<td align='left'>".$Row["nombre_prv"]."</td>\n";
					echo "<td align='left'>".$Row[nom_subpro]."</td>\n";
					echo "<td align='right'>".number_format($Row[peso_bruto],0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($Row["peso_tara"],0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($Row[peso_neto],0,",",".")."</td>\n";
					echo "</tr> \n";
					$TotalBruto = $TotalBruto + $Row[peso_bruto];
					$TotalTara = $TotalTara + $Row["peso_tara"];
					$TotalNeto = $TotalNeto + $Row[peso_neto];
				}
				break;
			case "O": // DETALLE OTROS PESAJES
				if ($OptAcumulado == "N")
				{
					echo "<tr> \n";
					echo "<td>".$Row[correlativo]."</td>\n";
					echo "<td>".$Row["fecha"]."</td>\n";
					echo "<td>".$Row[hora_entrada]."</td>\n";
					echo "<td>".$Row[hora_salida]."</td>\n";
					echo "<td>".$Row["nombre"]."</td>\n";
					echo "<td>".$Row["descripcion"]."</td>\n";
					echo "<td align='right'>".number_format($Row[peso_bruto],0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($Row["peso_tara"],0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($Row[peso_neto],0,",",".")."</td>\n";
					echo "<td>".$Row[guia_despacho]."</td>\n";
					echo "<td>".$Row["patente"]."</td>\n";
						echo "<td align='Center'>".$Row[bascula_entrada]."&nbsp;</td>\n";
						echo "<td align='Center'>".$Row[bascula_salida]."&nbsp;</td>\n";						
					
					echo "</tr>\n";
					$TotalBruto = $TotalBruto + $Row[peso_bruto];
					$TotalTara = $TotalTara + $Row["peso_tara"];
					$TotalNeto = $TotalNeto + $Row[peso_neto];
				}
				else
				{
					echo "<tr> \n";
					echo "<td align='left'>".$Row["nombre"]."</td>\n";
					echo "<td align='left'>".$Row["descripcion"]."</td>\n";
					echo "<td align='right'>".number_format($Row[peso_bruto],0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($Row["peso_tara"],0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($Row[peso_neto],0,",",".")."</td>\n";
					echo "</tr> \n";
					$TotalBruto = $TotalBruto + $Row[peso_bruto];
					$TotalTara = $TotalTara + $Row["peso_tara"];
					$TotalNeto = $TotalNeto + $Row[peso_neto];
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
				echo "<td colspan='6' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".number_format($TotalBruto,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($TotalTara,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($TotalNeto,0,",",".")."</td>\n";
				echo "<td align='right'><strong>Registros:</strong> ".number_format($Cont_reg,0,",",".")." </td>\n";
				echo "<td colspan='16'>&nbsp;</td>\n";
				echo "</tr>\n";
			}
			else
			{
				if ($OptAcumulado == "N")
				{
					echo "<tr>\n";
					echo "<td colspan='6' align='right'><strong>TOTALES</strong></td>\n";
					echo "<td align='right'>".number_format($TotalBruto,0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($TotalTara,0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($TotalNeto,0,",",".")."</td>\n";
				echo "<td align='right'><strong>Registros:</strong> ".number_format($Cont_reg,0,",",".")." </td>\n";
					echo "<td colspan='16'>&nbsp;</td>\n";
					echo "</tr>\n";
				}
				else
				{
					echo "<tr>\n";
					echo "<td colspan='3' align='right'><strong>TOTALES</strong></td>\n";
					echo "<td align='right'>".number_format($TotalBruto,0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($TotalTara,0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($TotalNeto,0,",",".")."</td>\n";
					echo "</tr>\n";
				}
			}
			break;
		case "D":  // TOTALES DESPACHOS
			if ($OptAcumulado == "N")
			{
				echo "<tr>\n";
				echo "<td colspan='6' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".number_format($TotalBruto,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($TotalTara,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($TotalNeto,0,",",".")."</td>\n";
				echo "<td align='right'><strong>Registros:</strong> ".number_format($Cont_reg,0,",",".")." </td>\n";
				echo "<td colspan='12'>&nbsp;</td>\n";
				echo "</tr>\n";
			}
			else
			{
				echo "<tr>\n";
				echo "<td colspan='3' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".number_format($TotalBruto,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($TotalTara,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($TotalNeto,0,",",".")."</td>\n";
				echo "</tr>\n";
			}
			break;
		case "O": // TOTALES OTROS PESAJES
			if ($OptAcumulado == "N")
			{
				echo "<tr>\n";
				echo "<td colspan='6' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".number_format($TotalBruto,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($TotalTara,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($TotalNeto,0,",",".")."</td>\n";
				echo "<td colspan='13'>&nbsp;</td>\n";
				echo "</tr>\n";
			}
			else
			{
				echo "<tr>\n";
				echo "<td colspan='2' align='right'><strong>TOTALES</strong></td>\n";
				echo "<td align='right'>".number_format($TotalBruto,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($TotalTara,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($TotalNeto,0,",",".")."</td>\n";
				echo "</tr>\n";
			}
			break;
	}
?></table>
</form>
</body>
</html>
