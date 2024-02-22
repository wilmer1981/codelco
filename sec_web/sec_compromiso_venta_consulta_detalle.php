<?php 
	include("../principal/conectar_principal.php"); 	  				
	if ($Tipo == "E")
	{
		$Consulta = "SELECT * from sec_web.cliente_venta where cod_cliente = '".$Cliente."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_assoc($Resp2))
			$NomCliente = $Fila2["sigla_cliente"];
		else
			$NomCliente = "";
	}
	else
	{
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '3016' and nombre_subclase = '".$Cliente."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_assoc($Resp2))
			$NomCliente = $Fila2["valor_subclase1"];
		else
			$NomCliente = "";
	}	
	//PESO
	if ($Tipo == "E")
	{
		$Consulta = "SELECT month(t2.fecha_guia) as mes,sum(t1.peso_paquetes) as peso,t3.cod_cliente,t3.cod_contrato ";
		$Consulta.= "from sec_web.paquete_catodo t1 ";
		$Consulta.=" inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia and t1.fecha_embarque=t2.fecha_guia	";
		$Consulta.= " inner join sec_web.programa_enami t3 on t3.corr_enm = t2.corr_enm ";		
		$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto = '40'"; //GRADO A
		$Consulta.= " and t3.cod_cliente = '".$Cliente."'";
		$Consulta.= " and t3.cod_contrato = '".$Contrato."'";
		$Consulta.= " and t3.mes_cuota = '".$Mes."'";
		$Consulta.= " group by t3.cod_cliente,t3.cod_contrato ";
	}
	else
	{
		if ($Tipo == "C")
		{
			$Consulta = "SELECT month(t2.fecha_guia) as mes,sum(t1.peso_paquetes) as peso,t3.cod_cliente,t3.cod_contrato ";
			$Consulta.= "from sec_web.paquete_catodo t1 ";
			$Consulta.=" inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia	and t1.fecha_embarque=t2.fecha_guia";
			$Consulta.= " inner join sec_web.programa_codelco t3 on t3.corr_codelco = t2.corr_enm ";		
			$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto = '40'"; //GRADO A
			$Consulta.= " and t3.cod_contrato_maquila = '".$Cliente."'";
			$Consulta.= " and month(fecha_guia)='".$Mes."'";
			$Consulta.= " group by t3.cod_contrato_maquila";
		}
	}
	$Resp2 = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	if ($Fila2 = mysqli_fetch_array($Resp2))
	{
		$TotalPeso = $Fila2["peso"];
	}		
?>
<html>
<head>
<title>Detalle</title>
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
  <table width="400" border="1" align="center" cellpadding="3" cellspacing="0">
    <tr class="ColorTabla01"> 
      <td colspan="6" align="center"><em><strong>EMBARQUE REAL MES DE <?php echo strtoupper($Meses[$Mes-1]); ?></strong></em></td>
    </tr>
    <tr> 
      <td colspan="2">Cliente</td>
      <td colspan="4"><?php echo $NomCliente; ?></td>
    </tr>
    <tr> 
      <td colspan="2">Contrato</td>
      <td colspan="4"><?php echo $Contrato; ?></td>
    </tr>
    <tr> 
      <td colspan="2">Total Peso</td>
      <td colspan="4"><?php echo number_format($TotalPeso,0,",","."); ?></td>
    </tr>
    <tr class="ColorTabla01"> 
      <td colspan="6">DESPACHOS</td>
    </tr>
    <tr align="center" class="ColorTabla01"> 
      <td width="35">I.E.</td>
      <td width="43">Guia</td>
      <td width="72">Fecha Guia</td>
	  <td width="44">Cuota</td>
      <td width="68">Peso</td>
      <td width="88">Patente</td>
    </tr>
    <?php	
	$Consulta = "SELECT MONTH(fecha_guia) as mes, t2.corr_enm, t2.fecha_guia,t2.num_guia,sum(t1.peso_paquetes) as peso, t2.patente_guia, t3.mes_cuota";
	$Consulta.= " from sec_web.paquete_catodo t1 inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia and t1.fecha_embarque=t2.fecha_guia";
	$Consulta.= " inner join sec_web.programa_enami t3 on t3.corr_enm = t2.corr_enm";
	$Consulta.= " where  t1.cod_producto = '18'";
	$Consulta.= " and t1.cod_subproducto = '40'";
	$Consulta.= " and t3.cod_cliente = '".$Cliente."'";
	$Consulta.= " and t3.cod_contrato = '".$Contrato."'";
	$Consulta.= " and t3.mes_cuota = '".$Mes."'";
	$Consulta.= " group by t2.num_guia";
	$Consulta.= " order by t2.corr_enm,t2.fecha_guia, t2.num_guia, peso, t2.patente_guia";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["corr_enm"]."</td>\n";
		echo "<td align='center'>".$Fila["num_guia"]."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_guia"],8,2)."-".substr($Fila["fecha_guia"],5,2)."-".substr($Fila["fecha_guia"],0,4)."</td>\n";
		echo "<td align='center'>".$Fila["mes_cuota"]."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";
		echo "<td align='center'>".strtoupper($Fila["patente_guia"])."</td>\n";
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
