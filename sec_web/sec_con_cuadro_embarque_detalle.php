<?php 
	include("../principal/conectar_principal.php"); 	
	$IE  = isset($_REQUEST["IE"])?$_REQUEST["IE"]:"";  				
	$Consulta = "SELECT * from sec_web.embarque_ventana where corr_enm = '".$IE."'";
	$Resp = mysqli_query($link, $Consulta);			
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$IE = $Fila["corr_enm"];
		$NumEnvio = $Fila["num_envio"];				
		$CodLote = $Fila["cod_bulto"];
		$NumLote = $Fila["num_bulto"];
		$PqtesDespachado = $Fila["despacho_paquetes"];
		$PesoDespachado = $Fila["despacho_peso"];
	}
	//A�O DEL LOTE
	$Consulta = "SELECT distinct fecha_creacion_lote from sec_web.lote_catodo ";
	$Consulta.= " where corr_enm = '".$IE."' and cod_bulto = '".$CodLote."' and num_bulto = '".$NumLote."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$Ano = substr($Fila["fecha_creacion_lote"],0,4);
	}
	//CUOTA
	$Consulta = "SELECT * from sec_web.programa_enami where corr_enm = '".$IE."'";
	$Resp = mysqli_query($link, $Consulta);			
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$Cuota = $Fila["mes_cuota"];		
	}	
	else
	{
		$Consulta = "SELECT * from sec_web.programa_codelco where corr_codelco = '".$IE."'";
		$Resp = mysqli_query($link, $Consulta);			
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Cuota = $Fila["mes_cuota"];		
		}	
	}
	//TOTAL PQTES
	$Consulta="SELECT count(num_paquete) as numero from sec_web.lote_catodo ";
	$Consulta.=" where cod_bulto='".$CodLote."' and num_bulto='".$NumLote."' and substring(fecha_creacion_lote,1,4)='".$Ano."'	";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);	
	$TotalPqtes = $Fila["numero"];
	//TOTAL PESO
	$Consulta="SELECT sum(num_unidades) as suma_unidades,sum(peso_paquetes) as suma_paquetes from sec_web.lote_catodo t1 ";
	$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
	$Consulta.=" and t1.num_paquete=t2.num_paquete ";
	$Consulta.=" where cod_bulto='".$CodLote."' and num_bulto='".$NumLote."' and LEFT(fecha_creacion_lote,4)='".$Ano."'	";
	$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  and t1.cod_estado=t2.cod_estado 	";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$SumaUnidades=$Fila["suma_unidades"];
	$SumaPeso=$Fila["suma_paquetes"];				
	//SERIE DE PAQUETES
	$SeriePaquetes = "";
	$Consulta = "SELECT t1.cod_paquete, t1.num_paquete ";
	$Consulta.= " from sec_web.lote_catodo t1 ";	
	$Consulta.= " where t1.cod_bulto = '".$CodLote."' ";
	$Consulta.= " and t1.num_bulto = '".$NumLote."' ";
	$Consulta.= " order by t1.cod_bulto, t1.num_bulto, t1.cod_paquete, t1.num_paquete ";
	$Respuesta = mysqli_query($link, $Consulta);
	$CodPaquete = "";
	$NumPaquete = "";
	$CodPaqueteAnt = "";
	$NumPaqueteAnt = "";
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$CodPaquete = $Fila["cod_paquete"];
		$NumPaquete = $Fila["num_paquete"];
		if (($CodPaqueteAnt != $CodPaquete) || (($NumPaqueteAnt + 1) != $NumPaquete))
		{
			if ($SeriePaquetes == "")
				$SeriePaquetes = $Fila["cod_paquete"]."-".str_pad($Fila["num_paquete"], 6, "0", STR_PAD_LEFT);
			else
				$SeriePaquetes = $SeriePaquetes."/".$CodPaqueteAnt."-".str_pad($NumPaqueteAnt, 6, "0", STR_PAD_LEFT)."&nbsp; ".$Fila["cod_paquete"]."-".str_pad($Fila["num_paquete"], 6, "0", STR_PAD_LEFT);
		}
		$CodPaqueteAnt = $Fila["cod_paquete"];
		$NumPaqueteAnt = $Fila["num_paquete"];
	}
	if (($CodPaqueteAnt != $CodPaquete) || (($NumPaqueteAnt) != $NumPaquete))
		$SeriePaquetes = $SeriePaquetes."&nbsp;&nbsp;".$CodPaquete."-".str_pad($NumPaquete, 6, "0", STR_PAD_LEFT);
	else
		$SeriePaquetes = $SeriePaquetes."/".$CodPaquete."-".str_pad($NumPaquete, 6, "0", STR_PAD_LEFT);	 		
?>
<html>
<head>
<title>Detalle IE</title>
<link href="../Principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(o)
{
	switch (o)
	{
		case "S":
			window.close();
			break;
	}
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmDetalle" action="" method="post">
  <table width="450" border="1" align="center" cellpadding="3" cellspacing="0">
    <tr class="ColorTabla01"> 
      <td colspan="4" align="center">INSTRUCCION DE EMBARQUE </td>
    </tr>
    <tr> 
      <td width="30%">I.E. </td>
      <td colspan="3"><?php echo $IE; ?></td>
    </tr>
    <tr> 
      <td>Cuota</td>
      <td colspan="3"><?php echo $Cuota; ?></td>
    </tr>
    <tr> 
      <td>N. Envio</td>
      <td colspan="3"><?php echo $NumEnvio; ?></td>
    </tr>
    <tr> 
      <td>Lote</td>
      <td colspan="3"><?php echo $CodLote."-".$NumLote; ?></td>
    </tr>
    <tr> 
      <td>Sub-Lotes</td>
      <td colspan="3"><?php echo $SeriePaquetes; ?></td>
    </tr>
    <tr> 
      <td>Pqtes Despachados</td>
      <td width="25%"><?php echo number_format($PqtesDespachado,0,",",".");?></td>
      <td width="31%">Peso Despachado</td>
      <td width="14%"><?php echo number_format($PesoDespachado,0,",",".");?></td>
    </tr>
    <tr> 
      <td>Pqtes Total </td>
      <td><?php echo number_format($TotalPqtes,0,",",".");?></td>
      <td>Peso total</td>
      <td><?php echo number_format($SumaPeso,0,",",".");?></td>
    </tr>
    <tr class="ColorTabla01"> 
      <td colspan="4">DESPACHOS</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td>Guia</td>
      <td>Fecha Guia</td>
      <td colspan="2">Patente</td>
    </tr>
<?php	
	$Consulta = "SELECT * from sec_web.guia_despacho_emb where corr_enm = '".$IE."' and cod_estado = 'I' order by fecha_guia, num_guia, patente_guia";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["num_guia"]."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_guia"],8,2)."-".substr($Fila["fecha_guia"],5,2)."-".substr($Fila["fecha_guia"],0,4)."</td>\n";
		echo "<td colspan='2' align='center'>".strtoupper($Fila["patente_guia"])."</td>\n";
		echo "</tr>\n";
	}
?>	
  </table>
<div align="center"><br>
  <input name="BtnCerrar" type="button" value="Cerrar" onClick="Proceso('S');">
</div>
</form>
</body>
</html>
