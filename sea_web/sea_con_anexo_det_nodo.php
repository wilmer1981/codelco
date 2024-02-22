<?php
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Nodo"])){
		$Nodo = $_REQUEST["Nodo"];
	}else{
		$Nodo = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}
	$Consulta = "select * from proyecto_modernizacion.nodos where sistema='SEA' and cod_nodo='".$Nodo."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomNodo = $Fila["descripcion"];
?>
<html>
<head>
<title>Detalle de Nodo - SEA</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<div align="center"><strong>NODO:&nbsp;<?php echo $Nodo." - ".strtoupper($NomNodo); ?>
  </strong><br>
  <br>
</div>
<table width="700" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr align="center" valign="middle" class="ColorTabla01">
    <td  rowspan="2">Hornada</td>
    <td  rowspan="2">SubProducto</td>
    <td  rowspan="2">Peso</td>
    <td colspan="3">Leyes</td>
    <td colspan="3">Fino</td>
  </tr>
  <tr class="ColorTabla01">
    <td width="47" align="center">Cu</td>
    <td width="46" align="center">Ag</td>
    <td width="40" align="center">Au</td>
    <td width="58" align="center">Cu</td>
    <td width="50" align="center">Ag</td>
    <td width="52" align="center">Au</td>
  </tr>
<?php
	//******************************* NODOS *********************************************			
	$FechaIni = $Ano."-".$Mes."-01";
	$FechaFin = $Ano."-".$Mes."-31";
			
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t2.descripcion ";
	$Consulta.= " from proyecto_modernizacion.relacion_prod_flujo_nodo t1 inner join ";
	$Consulta.= " proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and ";
	$Consulta.= " t1.cod_subproducto=t2.cod_subproducto ";	
	$Consulta.= " where t1.nodo='".$Nodo."'";
	//echo $Consulta;
	$RespAux = mysqli_query($link, $Consulta);
	$PesoNodo = 0;
	$Fino_Cu = 0;
	$Fino_Ag = 0;
	$Fino_Au = 0;
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{
		$Consulta = "select t1.hornada, t1.peso_fin as peso, t2.cod_leyes, t2.valor";
		$Consulta.= " from sea_web.stock t1 inner join sea_web.leyes_por_hornada t2 ";
		$Consulta.= " on t1.hornada=t2.hornada and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
		$Consulta.= " where t1.ano='".$Ano."' and t1.mes='".$Mes."'";
		$Consulta.= " and t1.cod_producto='".$FilaAux["cod_producto"]."' and t1.cod_subproducto='".$FilaAux["cod_subproducto"]."'";
		$Consulta.= " and t2.cod_leyes in('02','04','05')";
		$Consulta.= " order by t1.hornada, t2.cod_leyes";
		$RespAux2 = mysqli_query($link, $Consulta);	
		//echo  $Consulta;
		$HornadaAnt	= "";		
		while ($FilaAux2=mysqli_fetch_array($RespAux2))
		{
			if ($HornadaAnt != $FilaAux2["hornada"])
			{
				$PesoNodo = $PesoNodo + $FilaAux2["peso"];
				//echo $PesoNodo." = ".$PesoNodo." + ".$FilaAux2["peso"]."<br>";
				if ($HornadaAnt!="")
					EscribeLinea($HornadaAnt,$DescripcionAnt,$PesoAnt,$Fino_Cu_Ant,$Fino_Ag_Ant,$Fino_Au_Ant);					
			}
			switch ($FilaAux2["cod_leyes"])
			{
				case "02":
					$Fino_Cu = $Fino_Cu + (($FilaAux2["peso"]*$FilaAux2["valor"])/100);
					$Fino_Cu_Ant = (($FilaAux2["peso"]*$FilaAux2["valor"])/100);
					break;
				case "04":
					$Fino_Ag = $Fino_Ag + (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
					$Fino_Ag_Ant = (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
					break;
				case "05":
					$Fino_Au = $Fino_Au + (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
					$Fino_Au_Ant = (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
					break;														
			}														
			$HornadaAnt = $FilaAux2["hornada"];
			$DescripcionAnt = $FilaAux["descripcion"];
			$PesoAnt = $FilaAux2["peso"];						
		}//FIN HORNADAS DEL NODO
		if ($HornadaAnt!="")
			EscribeLinea($HornadaAnt,$DescripcionAnt,$PesoAnt,$Fino_Cu_Ant,$Fino_Ag_Ant,$Fino_Au_Ant);		

		// + STOCK EN PISO POR PRODUCTO - SUBPRODUCTO
		$Consulta = "SELECT t1.hornada, sum(t1.peso) as peso , t2.cod_leyes, t2.valor";
		$Consulta.= " FROM sea_web.stock_piso_raf t1  inner join sea_web.leyes_por_hornada t2";
		$Consulta.= " on t1.hornada=t2.hornada and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
		$Consulta.= " WHERE t1.cod_producto = '".$FilaAux["cod_producto"]."'";
		$Consulta.= " AND t1.cod_subproducto = '".$FilaAux["cod_subproducto"]."'";
		$Consulta.= " AND t1.fecha between '".$FechaIni."' AND '".$FechaFin."' ";
		$Consulta.= " and t2.cod_leyes in('02','04','05')";
		$Consulta.= " group by t1.hornada, t2.cod_leyes";
		$Consulta.= " order by t1.hornada, t2.cod_leyes";
		$RespAux2 = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		$HornadaAnt	= "";	
		while ($FilaAux2 = mysqli_fetch_array($RespAux2))
		{
			if ($HornadaAnt != $FilaAux2["hornada"])
			{
				$PesoNodo = $PesoNodo + $FilaAux2["peso"];						
				//echo $PesoNodo." = ".$PesoNodo." + ".$FilaAux2["peso"]."<br>";
				if ($HornadaAnt!="")
				{
					//echo $HornadaAnt.",".$DescripcionAnt.",".$PesoAnt.", ".$Fino_Cu_Ant.", ".$Fino_Ag_Ant.", ".$Fino_Au_Ant."<br>";
					EscribeLinea($HornadaAnt,$DescripcionAnt,$PesoAnt,$Fino_Cu_Ant,$Fino_Ag_Ant,$Fino_Au_Ant);											
				}
			}
			switch ($FilaAux2["cod_leyes"])
			{
				case "02":
					$Fino_Cu = $Fino_Cu + (($FilaAux2["peso"]*$FilaAux2["valor"])/100);
					$Fino_Cu_Ant = (($FilaAux2["peso"]*$FilaAux2["valor"])/100);
					break;
				case "04":
					$Fino_Ag = $Fino_Ag + (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
					$Fino_Ag_Ant = (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
					break;
				case "05":
					$Fino_Au = $Fino_Au + (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
					$Fino_Au_Ant = (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
					break;														
			}											
			$HornadaAnt = $FilaAux2["hornada"];
			$DescripcionAnt = $FilaAux["descripcion"];	
			$PesoAnt = $FilaAux2["peso"];				
		}						
		if ($HornadaAnt!="")
			EscribeLinea($HornadaAnt,$DescripcionAnt,$PesoAnt,$Fino_Cu_Ant,$Fino_Ag_Ant,$Fino_Au_Ant);
	}//FIN ACUMULA NODO
//TOTALES PONDERADOS
echo "<tr align='right'>\n";
echo "<td colspan='2' align='left'><strong>AL TERMINO DE MES </strong></td>\n";
echo "<td align='right'>".number_format($PesoNodo,0,",",".")."</td>\n";
echo "<td align='right'>";
if ($Fino_Cu>0 && $PesoNodo>0) echo number_format(($Fino_Cu/$PesoNodo)*100,2,",","."); else echo "0"; 
echo "</td>\n";
echo "<td align='right'>";
if ($Fino_Ag>0 && $PesoNodo>0) echo number_format(($Fino_Ag/$PesoNodo)*1000,2,",","."); else echo "0";
echo "</td>\n";
echo "<td align='right'>";
if ($Fino_Au>0 && $PesoNodo>0) echo number_format(($Fino_Au/$PesoNodo)*1000,2,",","."); else echo "0";
echo "</td>\n";
echo "<td align='right'>".number_format($Fino_Cu,0,",",".")."</td>\n";
echo "<td align='right'>".number_format($Fino_Ag,0,",",".")."</td>\n";
echo "<td align='right'>".number_format($Fino_Au,0,",",".")."</td>\n";
echo "</tr>\n";
	

function EscribeLinea($Hor, $Descr, $Peso, $Cu, $Ag, $Au)
{
	echo "<tr>\n";
	echo "<td align='center'>".$Hor."</td>\n";
	echo "<td>".strtoupper($Descr)."</td>\n";
	echo "<td align='right'>".number_format($Peso,0,",",".")."</td>\n";
	echo "<td align='right'>";
	if ($Cu>0 && $Peso>0) echo number_format(($Cu/$Peso)*100,2,",","."); else echo "0"; 
	echo "</td>\n";
	echo "<td align='right'>";
	if ($Ag>0 && $Peso>0) echo number_format(($Ag/$Peso)*1000,2,",","."); else echo "0";
	echo "</td>\n";
	echo "<td align='right'>";
	if ($Au>0 && $Peso>0) echo number_format(($Au/$Peso)*1000,2,",","."); else echo "0";
	echo "</td>\n";
	echo "<td align='right'>".number_format($Cu,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Ag,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Au,0,",",".")."</td>\n";
	echo "</tr>\n";
	$Peso=0; $Cu=0; $Ag=0; $Au=0;
}							
?>  
</table>
</body>
</html>
