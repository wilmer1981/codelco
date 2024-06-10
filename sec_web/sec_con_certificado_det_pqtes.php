<?php 
	include("../principal/conectar_principal.php");

	$Corr  = isset($_REQUEST["Corr"])?$_REQUEST["Corr"]:"";
	$Lote   = isset($_REQUEST["Lote"])?$_REQUEST["Lote"]:"";
	$Ano    = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes    = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:"";
	$Grupo            = isset($_REQUEST["Grupo"])?$_REQUEST["Grupo"]:"";
	$CodGrupo         = isset($_REQUEST["CodGrupo"])?$_REQUEST["CodGrupo"]:"";
	$CodProducto      = isset($_REQUEST["CodProducto"])?$_REQUEST["CodProducto"]:"";
	$CodSubProducto   = isset($_REQUEST["CodSubProducto"])?$_REQUEST["CodSubProducto"]:"";
	
	//$Ano=$_GET['Ano'];
	//$Ano=2015;
    //	echo "Ano ".$Ano."<br>";
	/*		if ($Mes=='A' && $Lote==25000)
		{
			$Ano =2007;
	
		}
		else
		{
		$Ano = '2007';  
		}
	*/
	$Consulta = "SELECT distinct ifnull(t2.cod_grupo,'00') as cod_grupo";
	$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
	$Consulta.= " where t1.cod_bulto = '".$Mes."'";
	$Consulta.= " and t1.num_bulto = '".$Lote."'";	
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";
	$Consulta.= " order by t2.cod_grupo";

	$Respuesta = mysqli_query($link, $Consulta);
	
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$CodGrupo = $Fila["cod_grupo"];		
	}
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPaquetes" action="" method="post">
  <table width="428" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="85">PAQUETE</td>
      <td width="85">PESO</td>
<?php 
	if (($CodGrupo == "00") || ($CodGrupo == "0") || ($CodGrupo == ""))
     	echo "<td width='64'>LOTE</td>\n";
	else
		echo "<td width='64'>GRUPO</td>\n";
?>	  
      <td width="119">F. PRODUCCION</td>
      <td width="119">F. CREACION</td>
    </tr>    
    <?php  
	if (($CodGrupo == "00") || ($CodGrupo == "0") || ($CodGrupo == ""))
	{
		$Consulta = "SELECT t2.cod_paquete, t2.num_paquete, t2.fecha_creacion_paquete, t2.lote_origen as cod_grupo, t2.peso_paquete as peso_paquetes ";
		$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo_externo t2 ";
		$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
		
		$Consulta.= " where t1.cod_bulto = '".$Mes."'";
		$Consulta.= " and t1.num_bulto = '".$Lote."'";
		$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

		if ($Grupo != "T")	
		{
				$Consulta.= " and t2.lote_origen = '".$Grupo."'";			
		}
		else
		{
			$Consulta.= " order by t2.cod_paquete, t2.num_paquete, t2.lote_origen,t2.fecha_creacion_paquete";
		}
	}
	else
	{
		
		$Consulta = "SELECT t2.cod_paquete, t2.num_paquete, t2.fecha_creacion_paquete, t2.cod_grupo, t2.peso_paquetes, t2.cod_subproducto";
		$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
		$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
		$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and ";


		$Consulta.= " t1.cod_bulto = '".$Mes."' and t1.num_bulto = '".$Lote."'";
		$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

		if ($Grupo != "T")	
		{
				$Consulta.= " and t2.cod_grupo = '".$Grupo."'";			
		}
		else
		{
			$Consulta.= " order by t2.cod_paquete, t2.num_paquete, t2.cod_grupo,t2.fecha_creacion_paquete,cod_subproducto";
		}
	}
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPaquetes = 0;
	$TotalPeso = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr> \n";
		echo "<td align='center'>".strtoupper($Fila["cod_paquete"])."-".str_pad($Fila["num_paquete"], 6, "0", STR_PAD_LEFT)."</td>\n";
		echo "<td align='center'>".number_format($Fila["peso_paquetes"],0,",",".")."</td>\n";
		if (strlen($Grupo) > 2)	
			echo "<td align='center'>".$Grupo."</td>\n";
		else
			echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
		//FECHA PRODUCCION
		$Consulta = "SELECT max(fecha_produccion) as fecha_produccion";
		$Consulta.= " from sec_web.produccion_catodo ";
		$Consulta.= " where cod_grupo = '".$Fila["cod_grupo"]."'";
		$Consulta.= " and fecha_produccion <= '".$Fila["fecha_creacion_paquete"]."'";
	
		$Respuesta2 = mysqli_query($link, $Consulta);
		
		if ($Fila["cod_subproducto"]=="44")
		{
		
			echo "<td align='center'>".substr($Fila["fecha_creacion_paquete"],8,2).".".substr($Fila["fecha_creacion_paquete"],5,2).".".substr($Fila["fecha_creacion_paquete"],0,4)."</td>\n";
		}
		else
		{
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
				
				echo "<td align='center'>".substr($Fila2["fecha_produccion"],8,2).".".substr($Fila2["fecha_produccion"],5,2).".".substr($Fila2["fecha_produccion"],0,4)."</td>\n";
		}
		else
		{
			echo "<td align='center'>&nbsp;</td>";
		}
	}
		//-----------------
		echo "<td align='center'>".substr($Fila["fecha_creacion_paquete"],8,2).".".substr($Fila["fecha_creacion_paquete"],5,2).".".substr($Fila["fecha_creacion_paquete"],0,4)."</td>\n";		
		echo "</tr>\n";
		
		$TotalPaquetes++;
		$TotalPeso = $TotalPeso + $Fila["peso_paquetes"];
	}
?>
	<tr> 
      <td colspan="5"><strong>TOTAL: <?php echo $TotalPaquetes; ?> Pqtes. con <?php echo number_format($TotalPeso,0,",","."); ?> Kg.</strong></td>
    </tr>
  </table>
  <div align="center"><br>
    <input name="BtnVolver" type="button" value="Volver" onClick="window.history.back();" style="width:70px">
    <input name="BtnImprimir" type="button" value="Imprimir" onClick="window.print();" style="width:70px">
    <input name="BtnSalir" type="button" value="Salir" onClick="window.close();" style="width:70px">
  </div>
</form>
</body>
</html>
