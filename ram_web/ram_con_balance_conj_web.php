<?php
	include("../principal/conectar_principal.php");
	if (!isset($ChkCodConjunto) || $ChkCodConjunto=="")
		$ChkCodConjunto="A";
		
?>
<html>
<head>
<title>Balance RAM</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style>
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action = "ram_con_balance_conj_web.php?Mostrar=S";
			f.submit();
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=7&Nivel=1&CodPantalla=19";
			f.submit();
			break;
		case "I":
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;
	}
}
</script></head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="400" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaInterior">
  <tr align="center" class="ColorTabla01">
    <td colspan="2"><strong>
	Comparacion de Pesos </strong></td>
  </tr>
  <tr>
    <td>Periodo: </td>
    <td><select name="Mes" id="select2" style="width:110px">
      <?php
			  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				for ($i = 1; $i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($i == $Mes)
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
			?>
    </select>
      <select name="Ano" style="width:70px">
        <?php
				for ($i = (date("Y")-1); $i <= (date("Y")+1); $i++)
				{
					if (isset($Ano))
					{
						if ($i == $Ano)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
      </select></td>
  </tr>
  <tr>
    <td>Num Conjunto:</td>
    <td><input name="TxtConjunto" type="text" id="TxtConjunto" value="<?php echo $TxtConjunto; ?>" size="15" maxlength="10">
(Opcional) </td>
  </tr>
  <tr>
    <td width="148">Marcar Cuando Dif. sea &quot;&gt;&quot;</td>
    <td width="241"><input name="TxtDif" type="text" id="TxtDif" value="<?php echo $TxtDif; ?>" size="15" maxlength="10">
      (Opcional)</td>
    </tr>
  <tr align="center">
    <td colspan="2">
<?php
	switch ($ChkCodConjunto)
	{
		case "M":
			echo '<input checked name="ChkCodConjunto" type="radio" value="M">P.Mineros&nbsp;&nbsp;';
			echo '<input name="ChkCodConjunto" type="radio" value="C">Circulantes&nbsp;&nbsp;';
			echo '<input name="ChkCodConjunto" type="radio" value="A">Ambos';
			break;
		case "C":
			echo '<input name="ChkCodConjunto" type="radio" value="M">P.Mineros&nbsp;&nbsp;';
			echo '<input checked name="ChkCodConjunto" type="radio" value="C">Circulantes&nbsp;&nbsp;';
			echo '<input name="ChkCodConjunto" type="radio" value="A">Ambos';
			break;
		case "A":
			echo '<input name="ChkCodConjunto" type="radio" value="M">P.Mineros&nbsp;&nbsp;';
			echo '<input name="ChkCodConjunto" type="radio" value="C">Circulantes&nbsp;&nbsp;';
			echo '<input checked name="ChkCodConjunto" type="radio" value="A">Ambos';
			break;
		default:
			echo '<input name="ChkCodConjunto" type="radio" value="M">P.Mineros&nbsp;&nbsp;';
			echo '<input name="ChkCodConjunto" type="radio" value="C">Circulantes&nbsp;&nbsp;';
			echo '<input checked name="ChkCodConjunto" type="radio" value="A">Ambos';
			break;
	}
?></td>
    </tr>
  <tr align="center">
    <td colspan="2"><input name="BtnConsultar2" type="button" value="Consultar" style="width:70px" onClick="Proceso('C');">     
	 <input name="BtnImprimir" type="button" value="Imprimir" style="width:70px;" onClick="Proceso('I')">
      <input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
    </tr>  
</table>
<br>
<br>
<?php
switch ($ChkCodConjunto)
{
	case "M":
		$CodConjunto = "in(01)";
		break;
	case "C":
		$CodConjunto = "in(03)";
		break;
	case "A":
		$CodConjunto = "in(01,03)";
		break;
	
}

if ($Mostrar=="S")
{
	$FechaIni=$Ano."-".str_pad($Mes,2,'0',STR_PAD_LEFT)."-01";
	$FechaFin=date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
	$FechaFin=date("Y-m-d", mktime(0,0,0,substr($FechaFin,5,2),1-1,substr($FechaFin,0,4)));
	echo "<table width='450' border='1' align='center' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>\n";
	echo "<tr align='center' class='ColorTabla01'>\n";
	echo "<td width='50' rowspan='2'>Corr.</td>\n";
	echo "<td width='50' rowspan='2'>Conjunto</td>\n";
	echo "<td colspan='2' align='center'>ST_FIN_AUTO.</td>";    
	echo "<td colspan='2' align='center'>ST_FIN_CALC.</td>";    
	echo "</tr>\n";
	echo "<tr align='center' class='ColorTabla01'>\n";
	echo "<td width='80'>P.Hum</td>\n";    
	echo "<td width='80'>P.Sec</td>\n";    
	echo "<td width='80'>P.Hum</td>\n";    
	echo "<td width='80'>P.Sec</td>\n";
	echo "</tr>\n";
	$ArrConjunto=array();
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '7002'";
	$Consulta.= " order by cod_subclase";
	$Resp1 = mysqli_query($link, $Consulta);
	while ($Fila1 = mysqli_fetch_array($Resp1))
	{				
		switch ($Fila1["cod_subclase"])	
		{
			case 3://BENEFICIO DIRECTO
				$Consulta = " SELECT t2.cod_producto, t2.cod_subproducto,t1.cod_conjunto, t1.num_conjunto,";
				$Consulta.= " t2.descripcion,Sum(t1.peso_humedo) AS peso_humedo,Sum(t1.peso_seco) AS peso_seco, Sum(t1.fino_cu) AS fino_cu, Sum(t1.fino_ag) AS fino_ag,";
				$Consulta.= " Sum(t1.fino_au) AS fino_au, Sum(t1.fino_as) AS fino_as, Sum(t1.fino_s) AS fino_s, Sum(t1.fino_pb) AS fino_pb, Sum(t1.fino_sb) AS fino_sb, Sum(t1.fino_fe) AS fino_fe";
				$Consulta.= " FROM ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram_bd t2 ON (t1.num_conjunto = t2.num_conjunto)";
				$Consulta.= " AND (t1.cod_conjunto = t2.cod_conjunto) INNER JOIN ram_web.movimiento_conjunto t3 ON (t1.num_conjunto = t3.num_conjunto) ";
				$Consulta.= " AND (t1.conjunto_destino = t3.conjunto_destino) AND (t1.fecha_movimiento = t3.fecha_movimiento)";
				$Consulta.= " AND case when t1.cod_conjunto='03' then (t3.cod_existencia = 5 OR t3.cod_existencia = 6 OR t3.cod_existencia = 16) ";
				$Consulta.= " else (t3.cod_existencia <> 5 AND t3.cod_existencia <> 6 AND t3.cod_existencia <> 16) end ";					
				$Consulta.= " WHERE t1.cod_conjunto ".$CodConjunto;
				if ($TxtConjunto!="")
					$Consulta.= " and t1.num_conjunto =".$TxtConjunto;			
				$Consulta.= " and t1.peso_humedo > 0";
				$Consulta.= " and (t1.cod_existencia in(12,15,16))";					
				$FechaFinAux = date("Y-m-d", mktime(0,0,0,substr($FechaFin,5,2),substr($FechaFin,8,2)+1,substr($FechaFin,0,4)));
				$Consulta.= " and t1.fecha_movimiento BETWEEN '".$FechaIni." 08:00:00' and '".$FechaFinAux." 07:59:59'";						
				$Consulta.= " GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto";
				$Consulta.= " ORDER BY t1.cod_conjunto, t1.num_conjunto";
				break;
			case 4://TRASPASO
				$Consulta = " SELECT t2.cod_producto, t2.cod_subproducto,t1.cod_conjunto, t1.num_conjunto,";
				$Consulta.= " t2.descripcion,Sum(t1.peso_humedo) AS peso_humedo,Sum(t1.peso_seco) AS peso_seco, Sum(t1.fino_cu) AS fino_cu, Sum(t1.fino_ag) AS fino_ag,";
				$Consulta.= " Sum(t1.fino_au) AS fino_au, Sum(t1.fino_as) AS fino_as, Sum(t1.fino_s) AS fino_s, Sum(t1.fino_pb) AS fino_pb, Sum(t1.fino_sb) AS fino_sb, Sum(t1.fino_fe) AS fino_fe";
				$Consulta.= " FROM ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram_bd t2 ON (t1.num_conjunto = t2.num_conjunto)";
				$Consulta.= " AND (t1.cod_conjunto = t2.cod_conjunto) INNER JOIN ram_web.movimiento_conjunto t3 ON (t1.num_conjunto = t3.num_conjunto) ";
				$Consulta.= " AND (t1.conjunto_destino = t3.conjunto_destino) AND (t1.fecha_movimiento = t3.fecha_movimiento)";
				$Consulta.= " AND case when t1.cod_conjunto='03' then (t3.cod_lugar_destino <= 12 OR t3.cod_lugar_destino >= 26) AND (t3.cod_existencia = 6 OR t3.cod_existencia = 15) ";
				$Consulta.= " else (t3.cod_lugar_destino > 12 OR t3.cod_lugar_destino < 26) AND (t3.cod_existencia = 6 OR t3.cod_existencia = 15) end ";					
				$Consulta.= " WHERE t1.cod_conjunto ".$CodConjunto;
				if ($TxtConjunto!="")
					$Consulta.= " and t1.num_conjunto =".$TxtConjunto;	
				$Consulta.= " and t1.peso_humedo > 0";
				$Consulta.= " and (t1.cod_existencia in(05,12,15,16))";	
				$FechaFinAux = date("Y-m-d", mktime(0,0,0,substr($FechaFin,5,2),substr($FechaFin,8,2)+1,substr($FechaFin,0,4)));
				$Consulta.= " and t1.fecha_movimiento BETWEEN '".$FechaIni." 08:00:00' and '".$FechaFinAux." 07:59:59'";						
				$Consulta.= " GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto";
				$Consulta.= " ORDER BY t1.cod_conjunto, t1.num_conjunto";
				//echo $Consulta;
				break;
			default:
				$Consulta = " SELECT t2.cod_producto, t2.cod_subproducto,t1.cod_conjunto, t1.num_conjunto,";
				$Consulta.= " t2.descripcion,Sum(t1.peso_humedo) AS peso_humedo,Sum(t1.peso_seco) AS peso_seco, Sum(t1.fino_cu) AS fino_cu, Sum(t1.fino_ag) AS fino_ag,";
				$Consulta.= " Sum(t1.fino_au) AS fino_au, Sum(t1.fino_as) AS fino_as, Sum(t1.fino_s) AS fino_s, Sum(t1.fino_pb) AS fino_pb, Sum(t1.fino_sb) AS fino_sb, Sum(t1.fino_fe) AS fino_fe";
				$Consulta.= " FROM ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram_bd t2 ON (t1.num_conjunto = t2.num_conjunto)";
				$Consulta.= " AND (t1.cod_conjunto = t2.cod_conjunto)";
				$Consulta.= " WHERE t1.cod_conjunto ".$CodConjunto;
				if ($TxtConjunto!="")
					$Consulta.= " and t1.num_conjunto =".$TxtConjunto;	
				$Consulta.= " and t1.peso_humedo > 0";
				$Consulta.= " and (t1.cod_existencia ".$Fila1["valor_subclase1"].")";
				if ($Fila1["cod_subclase"] == 1 || $Fila1["cod_subclase"] == 6) //STOCK INICIAL Y FINAL
				{
					if ($Fila1["cod_subclase"] == 1)//STOCK INICIAL
							$Consulta.= " and t1.fecha_movimiento BETWEEN '".$FechaIni."' and '".$FechaIni."'";					
					if ($Fila1["cod_subclase"] == 6)//STOCK FINAL
						$Consulta.= " and t1.fecha_movimiento BETWEEN '".$FechaFin."' and '".$FechaFin."'";
				}
				else
				{
					if ($Fila1["cod_subclase"] == 2) //RECEPCION
					{
						$Consulta.= " and t1.fecha_movimiento BETWEEN '".$FechaIni."' and '".$FechaFin."'";
					}
					else //EL RESTO DE LOS MOVIMIENTOS QUE ES POR TURNO
					{
						$FechaFinAux = date("Y-m-d", mktime(0,0,0,substr($FechaFin,5,2),substr($FechaFin,8,2)+1,substr($FechaFin,0,4)));
						$Consulta.= " and t1.fecha_movimiento BETWEEN '".$FechaIni." 08:00:00' and '".$FechaFinAux." 07:59:59'";
					}
				}
				$Consulta.= " GROUP BY t2.cod_producto, t2.cod_subproducto, t1.cod_conjunto, t1.num_conjunto";
				$Consulta.= " ORDER BY t1.cod_conjunto, t1.num_conjunto";
				//echo $Consulta."<br>";
				break;
		}			
		//echo $Consulta;	
		//TOTALES
		$TotalHum = 0;
		$TotalSeco = 0;
		$TotalHumCal = 0;
		$TotalSecoCal = 0;
		$Respuesta = mysqli_query($link, $Consulta);
		/*if ($Fila1["cod_subclase"]==5)
			echo $Consulta."<br><br>";*/
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Clave = $Fila["cod_conjunto"]."-".$Fila["num_conjunto"];
			$ArrConjunto[$Clave]["cod_conjunto"]= $Fila["cod_conjunto"];
			$ArrConjunto[$Clave]["num_conjunto"]= $Fila["num_conjunto"];	
			//if ($Fila["num_conjunto"]==109)
				//echo "CONJUNTO = ".$Fila["cod_conjunto"]."-".$Fila["num_conjunto"]." MOV=".$Fila1["cod_subclase"]." PH=".$Fila["peso_humedo"].", PS=".$Fila["peso_seco"]."<br>";
			switch ($Fila1["cod_subclase"])
			{
				case 1:
					$ArrConjunto[$Clave]["peso_hume_st_ini"]= $Fila["peso_humedo"];
					$ArrConjunto[$Clave]["peso_seco_st_ini"]= $Fila["peso_seco"];
					break;
				case 2:
					$ArrConjunto[$Clave]["peso_hume_recep"]= $Fila["peso_humedo"];
					$ArrConjunto[$Clave]["peso_seco_recep"]= $Fila["peso_seco"];
					break;
				case 3:
					$ArrConjunto[$Clave]["peso_hume_benef_dir"]= $Fila["peso_humedo"];
					$ArrConjunto[$Clave]["peso_seco_benef_dir"]= $Fila["peso_seco"];
					break;
				case 4:
					$ArrConjunto[$Clave]["peso_hume_benef"]= $Fila["peso_humedo"];
					$ArrConjunto[$Clave]["peso_seco_benef"]= $Fila["peso_seco"];
					break;
				case 5:
					$ArrConjunto[$Clave]["peso_hume_emb"]= $Fila["peso_humedo"];
					$ArrConjunto[$Clave]["peso_seco_emb"]= $Fila["peso_seco"];
					break;
				case 6:
					$ArrConjunto[$Clave]["peso_hume_st_fin"]= $Fila["peso_humedo"];
					$ArrConjunto[$Clave]["peso_seco_st_fin"]= $Fila["peso_seco"];
					break;
			}
	
		}			
	}	
	$i=1;
	ksort($ArrConjunto);
	reset($ArrConjunto);
	while (list($k,$FilaPri)=each($ArrConjunto))
	{
		$Color = "";
		$TxtDif=str_replace(",",".",$TxtDif);
		$TotalHumCal = ($FilaPri["peso_hume_st_ini"] + $FilaPri["peso_hume_recep"]) - ($FilaPri["peso_hume_benef_dir"]+$FilaPri["peso_hume_benef"]+$FilaPri["peso_hume_emb"]);
		$TotalSecoCal = ($FilaPri["peso_seco_st_ini"] + $FilaPri["peso_seco_recep"]) - ($FilaPri["peso_seco_benef_dir"]+$FilaPri["peso_seco_benef"]+$FilaPri["peso_seco_emb"]);
		if ($TxtDif!="")
		{
			if (abs($FilaPri["peso_hume_st_fin"]-$TotalHumCal)>$TxtDif)
				$Color="yellow";
			if (abs($FilaPri["peso_seco_st_fin"]-$TotalSecoCal)>$TxtDif)
				$Color="yellow";
		}		
		echo "<tr align='center' class='ColorTabla02'>\n";
		echo "<td align='center'>".$i."</td>\n";
		echo "<td bgcolor='".$Color."' align='left'>".$FilaPri["cod_conjunto"]."-".$FilaPri["num_conjunto"]."</td>\n";
		echo "<td align='right'>".number_format($FilaPri["peso_hume_st_fin"],2,",",".")."</td>";    
		echo "<td align='right'>".number_format($FilaPri["peso_seco_st_fin"],2,",",".")."</td>\n";
		echo "<td align='right'>".number_format($TotalHumCal,2,",",".")."</td>";    
		echo "<td align='right'>".number_format($TotalSecoCal,2,",",".")."</td>\n";
		echo "</tr>\n";
		$i++;
	}	
}//FIN MOSTRAR = "S"	
echo "</table>\n";
?>	
</form>
</body>
</html>
