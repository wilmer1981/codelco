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

	/************************************************************************* */
	if(isset($_REQUEST["TipoConsulta"])){
		$TipoConsulta = $_REQUEST["TipoConsulta"];
	}else{
		$TipoConsulta = "";
	}
	if(isset($_REQUEST["TxtFechaIni"])){
		$TxtFechaIni = $_REQUEST["TxtFechaIni"];
	}else{
		$TxtFechaIni = "";
	}
	if(isset($_REQUEST["TxtFechaFin"])){
		$TxtFechaFin = $_REQUEST["TxtFechaFin"];
	}else{
		$TxtFechaFin = "";
	}
	if(isset($_REQUEST["Producto"])){
		$Producto = $_REQUEST["Producto"];
	}else{
		$Producto = "";
	}
	if(isset($_REQUEST["IdProducto"])){
		$IdProducto = $_REQUEST["IdProducto"];
	}else{
		$IdProducto = "";
	}
	if(isset($_REQUEST["RutProveedor"])){
		$RutProveedor = $_REQUEST["RutProveedor"];
	}else{
		$RutProveedor = "";
	}
	if(isset($_REQUEST["OptAcumulado"])){
		$OptAcumulado = $_REQUEST["OptAcumulado"];
	}else{
		$OptAcumulado = "";
	}
	if(isset($_REQUEST["Lote"])){
		$Lote = $_REQUEST["Lote"];
	}else{
		$Lote = "";
	}
	if(isset($_REQUEST["TxtLote"])){
		$TxtLote=$_REQUEST["TxtLote"];
	}else{
		$TxtLote="";
	}

	/********************************************************************** */
?>
<html>
<head>
<title>Sistema de Recepci&oacute;n</title>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<table width="700" border="0" cellspacing="1" cellpadding="1">
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
				$Consulta = "SELECT t2.cod_subproducto, t2.descripcion as nom_subpro from proyecto_modernizacion.subproducto t2 ";
				$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto= '".$Producto."'";
			}	
			else
				echo "TODOS LOS PRODUCTOS";
			break;
		case "D":
			if ($Producto != "S")
			{			
				//echo $Producto;
				$prod1 = substr($Producto,0,2);
				$prod2 = substr($Producto,3,2);
					
				//echo $prod1."x".$prod2;
				$Consulta = "SELECT t2.cod_subproducto, t2.descripcion as nom_subpro from proyecto_modernizacion.subproducto t2 ";
				$Consulta.= "where t2.cod_subproducto = '".$prod2."' and t2.cod_producto = '".$prod1."'";
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
			echo $Row["cod_subproducto"]." - ".$Row["nom_subpro"];
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
				$Consulta = "SELECT t2.rut_prv, t2.nombre_prv from sipa_web.proveedores t2  ";
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
			echo $Row["rut_prv"]." - ".$Row["nombre_prv"];
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
						//echo $Consulta;
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
				$prod1 = substr($Producto,0,2);
				$prod2 = substr($Producto,3,2);
				$Consulta = "SELECT t1.correlativo,t1.fecha,t1.hora_entrada,t1.hora_salida,t1.lote,t1.recargo,t1.peso_bruto,t1.peso_neto,t1.peso_tara, ";
				$Consulta.= " t1.guia_despacho,t1.patente,t1.rut_prv, t1.cod_subproducto,t2.descripcion as nom_subpro,bascula_salida,bascula_entrada,romana_entrada,romana_salida  ";
				$Consulta.= " from sipa_web.despachos t1 left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto =t2.cod_subproducto ";
				$Consulta.= " where t1.estado<>'A' and t1.fecha between '".$FechaIni."' and '".$FechaFin."' ";
				if ($Producto != "S")
					$Consulta.= " and t1.cod_subproducto = '".$prod2."' and t1.cod_producto = '".$prod1."'";
				if ($RutProveedor != "S")
					$Consulta.= " and t1.rut_prv = '".$RutProveedor."'";
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
				$prod1 = substr($Producto,0,2);
				$prod2 = substr($Producto,3,2);
				$Consulta = "SELECT t1.rut_prv, t3.nombre_prv, t1.cod_subproducto,t2.descripcion as nom_subpro, sum(peso_bruto) as peso_bruto, sum(peso_tara) as peso_tara, sum(peso_neto) as peso_neto";
				$Consulta.= " from sipa_web.despachos t1 left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto =t2.cod_subproducto ";
				$Consulta.= " left join sipa_web.proveedores t3 on t1.rut_prv=t3.rut_prv ";
				$Consulta.= " where t1.fecha between '".$FechaIni."' and '".$FechaFin."' ";
				if ($Producto != "S")
					$Consulta.= " and t1.cod_producto = '".$prod1."' and '".$prod2."'";
				if ($RutProveedor != "S")
					$Consulta.= " and t1.rut_prv = '".$RutProveedor."'";
				$Consulta.= " group by t1.rut_prv, t3.nombre_prv, t1.cod_subproducto, t2.descripcion";
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
//	echo "consulta:".$Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		switch ($TipoConsulta)
		{
			case "R": //DETALLE RECEPCIONES
				if ($Lote == "S")
				{
					if ($Row["ACTIVO"] == "M")
							echo "<tr bgcolor='#FFFFFF'> \n";
						else
							echo "<tr> \n";
							echo "<td>".$Row["lote"]."</td>\n";
						echo "<td>".$Row["recargo"]."</td>\n";
						echo "<td>".$Row["fecha"]."</td>\n";
						echo "<td>".$Row["hora_entrada"]."</td>\n";
						echo "<td>".$Row["hora_salida"]."</td>\n";
						echo "<td>".$Row["correlativo"]."</td>\n";												
						echo "<td align='right'>".$Row["peso_bruto"]."</td>\n";
						echo "<td align='right'>".$Row["peso_tara"]."</td>\n";
						echo "<td align='right'>".$Row["peso_neto"]."</td>\n";
						echo "<td>".$Row["rut_prv"]."</td>\n";
						echo "<td>".$Row["nombre_prv"]."</td>\n";
						echo "<td>".$Row["cod_mina"]."</td>\n";
						echo "<td>".$Row["nombre_mina"]."</td>\n";
						echo "<td>".$Row["cod_subproducto"]."</td>\n";
						echo "<td>".$Row["nom_subpro"]."</td>\n";
						echo "<td>".str_replace("  ",", ",trim($Row["leyes"]))."</td>\n";
						echo "<td>".str_replace("  ",", ",trim($Row["impurezas"]))."</td>\n";
						echo "<td>".$Row["humedad"]."</td>\n";
						echo "<td>".$Row["guia_despacho"]."</td>\n";
						echo "<td>".$Row[petente]."</td>\n";
						echo "<td>".$Row["conjunto"]."</td>\n";
						echo "<td>&nbsp;".$Row["sa_asignada"]."</td>\n";
						if ($Row["activo"] == "M")
							echo "<td align='center'><strong>SI</strong></td>\n";
						else
							echo "<td>&nbsp;</td>\n";					
						echo "</tr>\n";
						$TotalBruto = $TotalBruto + $Row["peso_bruto"];
						$TotalTara = $TotalTara + $Row["peso_tara"];
						$TotalNeto = $TotalNeto + $Row["peso_neto"];
				}
				else
				{
					if ($OptAcumulado == "N")
					{
						if ($Row["ACTIVO"] == "M")
							echo "<tr bgcolor='#FFFFFF'> \n";
						else
							echo "<tr> \n";
						echo "<td>".$Row["correlativo"]."</td>\n";
						echo "<td>".$Row["fecha"]."</td>\n";
						echo "<td>".$Row["hora_entrada"]."</td>\n";
						echo "<td>".$Row["hora_salida"]."</td>\n";
						echo "<td>".$Row["lote"]."</td>\n";
						echo "<td>".$Row["recargo"]."</td>\n";
						echo "<td align='right'>".$Row["peso_bruto"]."</td>\n";
						echo "<td align='right'>".$Row["peso_tara"]."</td>\n";
						echo "<td align='right'>".$Row["peso_neto"]."</td>\n";
						echo "<td>".$Row["rut_prv"]."</td>\n";
						echo "<td>".$Row["nombre_prv"]."</td>\n";
						echo "<td>".$Row["cod_mina"]."</td>\n";
						echo "<td>".$Row["nombre_mina"]."</td>\n";
						echo "<td>".$Row["cod_subproducto"]."</td>\n";
						echo "<td>".$Row["nom_subpro"]."</td>\n";
						$Leyes=explode('~',$Row["leyes"]);
						$StrLeyes='';
						//foreach($Leyes as  $c =>$v)
						foreach($Leyes as $c => $v)
						{
							$StrLeyes=$StrLeyes.$DatosLeyes[$v].",";
						}
						$StrLeyes=substr($StrLeyes,0,strlen($StrLeyes)-1);
						$Impurezas=explode('~',$Row["impurezas"]);
						$StrImp='';
						//foreach($Impurezas as $c => $v)
						foreach($Impurezas as $c => $v)
						{
							$StrImp=$StrImp.$DatosLeyes[$v].",";
						}
						$StrImp=substr($StrImp,0,strlen($StrImp)-1);
						echo "<td align='left'>".$StrLeyes."</td>";
						echo "<td align='left'>".$StrImp."</td>";
						echo "<td>".$Row["humedad"]."</td>\n";
						echo "<td>".$Row["guia_despacho"]."</td>\n";
						echo "<td>".$Row["patente"]."</td>\n";
						echo "<td>".$Row["conjunto"]."</td>\n";
						echo "<td>&nbsp;".$Row["sa_asignada"]."</td>\n";
						if ($Row["activo"] == "M")
							echo "<td align='center'><strong>SI</strong></td>\n";
						else
							echo "<td>&nbsp;</td>\n";					
						echo "<td align='Center'>".$Row["bascula_entrada"]."&nbsp;</td>\n";
						echo "<td align='Center'>".$Row["bascula_salida"]."&nbsp;</td>\n";						
					
						echo "</tr>\n";						
						$TotalBruto = $TotalBruto + $Row["peso_bruto"];
						$TotalTara = $TotalTara + $Row["peso_tara"];
						$TotalNeto = $TotalNeto + $Row["peso_neto"];
					}
					else
					{
						echo "<tr> \n";
						echo "<td align='left'>".$Row["rut_prv"]."</td>\n";
						echo "<td align='left'>".$Row["nombre_prv"]."</td>\n";
						echo "<td align='left'>".$Row["nom_subpro"]."</td>\n";
						echo "<td align='right'>".$Row["peso_bruto"]."</td>\n";
						echo "<td align='right'>".$Row["peso_tara"]."</td>\n";
						echo "<td align='right'>".$Row["peso_neto"]."</td>\n";
						echo "</tr> \n";
						$TotalBruto = $TotalBruto + $Row["peso_bruto"];
						$TotalTara = $TotalTara + $Row["peso_tara"];
						$TotalNeto = $TotalNeto + $Row["peso_neto"];
					}
				}
				break;
			case "D": // DETALLE DESPACHOS
				if ($OptAcumulado == "N")
				{
					echo "<tr> \n";
					echo "<td>".$Row["correlativo"]."</td>\n";
					echo "<td>".$Row["fecha"]."</td>\n";
					echo "<td>".$Row["hora_entrada"]."</td>\n";
					echo "<td>".$Row["hora_salida"]."</td>\n";
					echo "<td>".$Row["lote"]."</td>\n";
					echo "<td>".$Row["recargo"]."</td>\n";
					echo "<td align='right'>".$Row["peso_bruto"]."</td>\n";
					echo "<td align='right'>".$Row["peso_tara"]."</td>\n";
					echo "<td align='right'>".$Row["peso_neto"]."</td>\n";
					echo "<td>".$Row["rut_prv"]."</td>\n";
					ObtenerProveedorDespacho('D',$Row["rut_prv"],$Row["correlativo"],$Row["guia_despacho"],$RutProved,$NombreProved,$link);
					$NomProv = $NombreProved;
					echo "<td>".$NomProv."</td>\n";
					echo "<td>".$Row["cod_subproducto"]."</td>\n";
					echo "<td>".$Row["nom_subpro"]."</td>\n";
					echo "<td>".$Row["guia_despacho"]."</td>\n";
					echo "<td>".$Row["patente"]."</td>\n";
						echo "<td align='Center'>".$Row["bascula_entrada"]."&nbsp;</td>\n";
						echo "<td align='Center'>".$Row["bascula_salida"]."&nbsp;</td>\n";						
					
					echo "</tr>\n";
					$TotalBruto = $TotalBruto + $Row["peso_bruto"];
					$TotalTara = $TotalTara + $Row["peso_tara"];
					$TotalNeto = $TotalNeto + $Row["peso_neto"];
				}
				else
				{
					echo "<tr> \n";
					echo "<td align='left'>".$Row["rut_prv"]."</td>\n";
					echo "<td align='left'>".$Row["nombre_prv"]."</td>\n";
					echo "<td align='left'>".$Row["nom_subpro"]."</td>\n";
					echo "<td align='right'>".$Row["peso_bruto"]."</td>\n";
					echo "<td align='right'>".$Row["peso_tara"]."</td>\n";
					echo "<td align='right'>".$Row["peso_neto"]."</td>\n";
					echo "</tr> \n";
					$TotalBruto = $TotalBruto + $Row["peso_bruto"];
					$TotalTara = $TotalTara + $Row["peso_tara"];
					$TotalNeto = $TotalNeto + $Row["peso_neto"];
				}
				break;
			case "O": // DETALLE OTROS PESAJES
				if ($OptAcumulado == "N")
				{
					echo "<tr> \n";
					echo "<td>".$Row["correlativo"]."</td>\n";
					echo "<td>".$Row["fecha"]."</td>\n";
					echo "<td>".$Row["hora_entrada"]."</td>\n";
					echo "<td>".$Row["hora_salida"]."</td>\n";
					echo "<td>".$Row["nombre"]."</td>\n";
					echo "<td>".$Row["descripcion"]."</td>\n";
					echo "<td align='right'>".$Row["peso_bruto"]."</td>\n";
					echo "<td align='right'>".$Row["peso_tara"]."</td>\n";
					echo "<td align='right'>".$Row["peso_neto"]."</td>\n";
					echo "<td>".$Row["guia_despacho"]."</td>\n";
					echo "<td>".$Row["patente"]."</td>\n";
					$BascEnt="";
					$BascSal="";	
						echo "<td align='Center'>".$Row["bascula_entrada"]."&nbsp;</td>\n";
						echo "<td align='Center'>".$Row["bascula_salida"]."&nbsp;</td>\n";						
					
					echo "</tr>\n";
					$TotalBruto = $TotalBruto + $Row["peso_bruto"];
					$TotalTara = $TotalTara + $Row["peso_tara"];
					$TotalNeto = $TotalNeto + $Row["peso_neto"];
				}
				else
				{
					echo "<tr> \n";
					echo "<td align='left'>".$Row["nombre"]."</td>\n";
					echo "<td align='left'>".$Row["descripcion"]."</td>\n";
					echo "<td align='right'>".$Row["peso_bruto"]."</td>\n";
					echo "<td align='right'>".$Row["peso_tara"]."</td>\n";
					echo "<td align='right'>".$Row["peso_neto"]."</td>\n";
					echo "</tr> \n";
					$TotalBruto = $TotalBruto + $Row["peso_bruto"];
					$TotalTara = $TotalTara + $Row["peso_tara"];
					$TotalNeto = $TotalNeto + $Row["peso_neto"];
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
					echo "<td colspan='7'>&nbsp;</td>\n";
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
				echo "<td colspan='7'>&nbsp;</td>\n";
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
				echo "<td colspan='15'>&nbsp;</td>\n";
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
