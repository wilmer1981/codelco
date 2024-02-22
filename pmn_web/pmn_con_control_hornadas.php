<?php
	include("../principal/conectar_pmn_web.php");

set_time_limit('1000');
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f= document.frmPrincipal;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			window.history.back();
			break;
	}
}
function Excel(FechaI,FechaT,T)
{
	var f=document.frmPrincipal;
	f.action="pmn_xls_control_hornadas.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
	f.submit();
}

</script>
</head>

<body class="TituloCabeceraOz" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form action="" method="post" name="frmPrincipal">
<?php
 	$FechaIni = $AnoIniCon."-".$MesIniCon."-".$DiaIniCon;
	$FechaFin = $AnoFinCon."-".$MesFinCon."-".$DiaFinCon;
?>
  <table width="691" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      <td width="427" align="center" valign="middle"><strong class="titulo_azul">CONTROL HORNADAS 
        PLANTA DE SELENIO</strong> </td>
      <td width="74" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');"></td>
      <td width="172" align="center" valign="middle"><input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
        &nbsp; 
        <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
    </tr>
  </table>
<strong> <br>
<br>
</strong> 
  <table width="1060" border="1" cellspacing="0" cellpadding="3" class="TituloCabeceraAzul">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td colspan="14">ENTRADAS</td>
      <td colspan="3">SALIDAS</td>
    </tr>
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td colspan="4"><center>
          HORNADA </center></td>
      <td width="42">LIXIV.</td>
      <td width="58">B.A.D.(H)</td>
      <td width="8%">Id.</td>
      <td width="58">B.A.D.(C)</td>
      <td width="43">TOTAL</td>
      <?php //<td width="51">POLVO</td> ?>
      <td width="74" rowspan="2">CONSUMO E&ordm; ELECT. kw h</td>
      <td width="47">ACIDO</td>
      <td width="63">PETRACEL</td>
      <td width="46" rowspan="2">FECHA</td>
      <td width="69" rowspan="2">OPERADOR</td>
      <td width="57">CALCINA</td>
      <td width="46" rowspan="2">FECHA</td>
      <td width="101" rowspan="2">OPERADOR</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="46" align="center" valign="middle">#Horno</td>
      <td width="47" align="center" valign="middle">#Funda</td>
      <td width="29" align="center" valign="middle">#HT</td>
      <td width="29" align="center" valign="middle">#HP</td>
      <td align="center" valign="middle">N&ordm;</td>
      <td align="center" valign="middle">Kgs.</td>
      <td align="center" valign="middle">&nbsp;</td>
      <td align="center" valign="middle">Kgs.</td>
      <td align="center" valign="middle">CARGA</td>
      <?php //<td width="51">F.MANGA</td> ?>
      <td align="center" valign="middle">Kg.</td>
      <td align="center" valign="middle">Kg.</td>
      <td width="57" align="center" valign="middle">Kg</td>
    </tr>
    <?php 
	$Consulta = "select t2.tipo,t1.fecha,t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial, t2.referencia, t2.bad, t1.acidc, t1.petracel, ";
	$Consulta.= " t1.operador, t1.prod_calcina, t1.fecha_salida, t1.operador_02 ";
	$Consulta.= " from pmn_web.deselenizacion t1 inner join pmn_web.detalle_deselenizacion t2 on ";
	$Consulta.= " t1.fecha = t2.fecha and  t1.num_horno = t2.num_horno and t1.num_funda=t2.num_funda and ";
	$Consulta.="  t1.hornada_total=t2.hornada_total and t1.hornada_parcial=t2.hornada_parcial			";
	$Consulta.= " where t1.fecha between '".$FechaIni."' and '".$FechaFin."' ";
	$Consulta.=" group by t1.fecha, t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial";
	$Consulta.= " order by t1.fecha, t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial,t2.tipo";
	//echo $Consulta."<br>";
	
	$Respuesta = mysqli_query($link, $Consulta);
	$FechaAnt = "";
	$HornadaAnt = "";
	$NumHornoAnt="";
	$NumFundaAnt="";
	$HornadaTotalAnt="";
	$HornadaParcialAnt="";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		$filas_L = 0;
		$filas_P = 0;	
		//CUENTO REGISTROS POR HORNADA
		$Consulta = "select count(*) as total ";
		$Consulta.= " from pmn_web.deselenizacion t1 inner join pmn_web.detalle_deselenizacion t2 on ";
		$Consulta.= " t1.fecha = t2.fecha and t1.num_horno = t2.num_horno and t1.num_funda=t2.num_funda and ";
		$Consulta.=" t1.hornada_total=t2.hornada_total and t1.hornada_parcial=t2.hornada_parcial											";
		$Consulta.= " where t1.fecha ='".$Row["fecha"]."' ";
		$Consulta.= " and t1.num_horno ='".$Row[num_horno]."' ";
		$Consulta.=" and t1.num_funda='".$Row[num_funda]."'	";
		$Consulta.=" and t1.hornada_total='".$Row[hornada_total]."'	";
		$Consulta.=" and t1.hornada_parcial='".$Row[hornada_parcial]."'	";
		$Consulta.=" and t2.tipo = 'L'";			
		//echo $Consulta."<br>";
		$rs = mysqli_query($link, $Consulta);
		$row = mysqli_fetch_array($rs);
		$filas_L = $row["total"];
		
		$Consulta = "select count(*) as total ";
		$Consulta.= " from pmn_web.deselenizacion t1 inner join pmn_web.detalle_deselenizacion t2 on ";
		$Consulta.= " t1.fecha = t2.fecha and t1.num_horno = t2.num_horno and t1.num_funda=t2.num_funda and ";
		$Consulta.=" t1.hornada_total=t2.hornada_total and t1.hornada_parcial=t2.hornada_parcial											";
		$Consulta.= " where t1.fecha ='".$Row["fecha"]."' ";
		$Consulta.= " and t1.num_horno ='".$Row[num_horno]."' ";
		$Consulta.=" and t1.num_funda='".$Row[num_funda]."'	";
		$Consulta.=" and t1.hornada_total='".$Row[hornada_total]."'	";
		$Consulta.=" and t1.hornada_parcial='".$Row[hornada_parcial]."'	";
		$Consulta.=" and t2.tipo = 'P'";			
		//echo $Consulta."<br>";
		$rs = mysqli_query($link, $Consulta);
		$row = mysqli_fetch_array($rs);
		$filas_P = $row["total"];			
		
		if ($filas_P > $filas_L)
			$TotalFilas = $filas_P;
		else 
			$TotalFilas = $filas_L;		
		$prueba=1;
		for ($i=0; $i<$TotalFilas; $i++)
		{
		
			echo "<tr>\n";
			if (($FechaAnt != $Row["fecha"]) || ($NumHornoAnt != $Row[num_horno])||($NumFundaAnt != $Row[num_funda])|| ($HornadaTotalAnt != $Row[hornada_total])|| ($HornadaParcialAnt != $Row[hornada_parcial]))
			{
				//$TotalFilas = 5;	
				echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[num_horno]."</td>\n";
				echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[num_funda]."</td>\n";
				echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[hornada_total]."</td>\n";
				echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[hornada_parcial]."</td>\n";
				$cont = 0;
				
				//--------
				$Consulta = "select * ";
				$Consulta.= " from pmn_web.deselenizacion t1 inner join pmn_web.detalle_deselenizacion t2 on ";
				$Consulta.= " t1.fecha = t2.fecha and t1.num_horno = t2.num_horno and t1.num_funda=t2.num_funda and ";
				$Consulta.=" t1.hornada_total=t2.hornada_total and t1.hornada_parcial=t2.hornada_parcial											";
				$Consulta.= " where t1.fecha ='".$Row["fecha"]."' ";
				$Consulta.= " and t1.num_horno ='".$Row[num_horno]."' ";
				$Consulta.=" and t1.num_funda='".$Row[num_funda]."'	";
				$Consulta.=" and t1.hornada_total='".$Row[hornada_total]."'	";
				$Consulta.=" and t1.hornada_parcial='".$Row[hornada_parcial]."'	";
				$Consulta.=" and t2.tipo = 'L'";
				$rs = mysqli_query($link, $Consulta);
				$cont_L = mysql_num_rows($rs);
				
				$Consulta = "select * ";
				$Consulta.= " from pmn_web.deselenizacion t1 inner join pmn_web.detalle_deselenizacion t2 on ";
				$Consulta.= " t1.fecha = t2.fecha and t1.num_horno = t2.num_horno and t1.num_funda=t2.num_funda and ";
				$Consulta.=" t1.hornada_total=t2.hornada_total and t1.hornada_parcial=t2.hornada_parcial											";
				$Consulta.= " where t1.fecha ='".$Row["fecha"]."' ";
				$Consulta.= " and t1.num_horno ='".$Row[num_horno]."' ";
				$Consulta.=" and t1.num_funda='".$Row[num_funda]."'	";
				$Consulta.=" and t1.hornada_total='".$Row[hornada_total]."'	";
				$Consulta.=" and t1.hornada_parcial='".$Row[hornada_parcial]."'	";
				$Consulta.=" and t2.cod_producto = '25' and t2.cod_subproducto = '5'";
				$Consulta.=" and t2.tipo = 'P'";
				$rs4 = mysqli_query($link, $Consulta);			
				$cont_P = mysql_num_rows($rs4);			
			}
			//---------------------------
			if ($cont_L != 0)
			{
				mysql_field_seek($rs,$cont_L);
				if(!($row = mysql_fetch_object ($rs)))
					continue;
				
				echo "<td>".$row->referencia."</td>";		
				echo "<td>".number_format($row->bad,3,",",".")."</td>";
				$cont_L--;
				$TotalBADH=$TotalBADH+$row->bad;
			}
			else
			{
				echo "<td>&nbsp;</td>";		
				echo "<td>&nbsp;</td>";		
			}				
		
			if ($cont_P != 0)
			{
				mysql_field_seek($rs4,$cont_P);
				
				if(!($row4 = mysql_fetch_object ($rs4)))
					continue;
				
				echo "<td>".$row4->id_producto.'-'.$row4->referencia."</td>";		
				echo "<td>".number_format($row4->bad,3,",",".")."</td>";
				$cont_P--;			
				$TotalBADC=$TotalBADC+$row4->bad;
			}
			else
			{
				echo "<td>&nbsp;</td>";		
				echo "<td>&nbsp;</td>";		
			}		
			//------------
			
			if (($FechaAnt != $Row["fecha"]) || ($NumHornoAnt != $Row[num_horno])||($NumFundaAnt != $Row[num_funda])|| ($HornadaTotalAnt != $Row[hornada_total])|| ($HornadaParcialAnt != $Row[hornada_parcial]))
			{									
				//Consulta el total de la carga
				$Consulta = "select ifnull(sum(bad),0) as total ";
				$Consulta.= " from pmn_web.deselenizacion t1 inner join pmn_web.detalle_deselenizacion t2 on ";
				$Consulta.= " t1.fecha = t2.fecha and t1.num_horno = t2.num_horno and t1.num_funda=t2.num_funda and ";
				$Consulta.=" t1.hornada_total=t2.hornada_total and t1.hornada_parcial=t2.hornada_parcial											";
				$Consulta.= " where t1.fecha ='".$Row["fecha"]."' ";
				$Consulta.= " and t1.num_horno ='".$Row[num_horno]."' ";
				$Consulta.=" and t1.num_funda='".$Row[num_funda]."'	";
				$Consulta.=" and t1.hornada_total='".$Row[hornada_total]."'	";
				$Consulta.=" and t1.hornada_parcial='".$Row[hornada_parcial]."'	";
		
				$rs1 = mysqli_query($link, $Consulta);
				$row1 =  mysqli_fetch_array($rs1);
				
				echo "<td align='center' rowspan='".$TotalFilas."'>".number_format($row1["total"],3,",",".")."</td>\n";				
				$Total1=$Total1+$row1["total"];			
				//echo "<td align='center' rowspan='".$TotalFilas."'>aaaa&nbsp;</td>\n";
				
				//CONSUMO ENERGIA ELECTRICA.
				$consulta = "SELECT (kwh_fin - kwh_ini) AS energia FROM pmn_web.deselenizacion";
				$consulta.= " where fecha ='".$Row["fecha"]."'";
				$consulta.= " and num_horno ='".$Row[num_horno]."'";
				$consulta.=" and num_funda='".$Row[num_funda]."'";
				$consulta.=" and hornada_total='".$Row[hornada_total]."'";
				$consulta.=" and hornada_parcial='".$Row[hornada_parcial]."'";
				$rs2 = mysqli_query($link, $consulta);
				$row2 = mysqli_fetch_array($rs2);
				
				echo "<td align='right' rowspan='".$TotalFilas."'>".number_format($row2[energia],4,",","")."</td>\n";
				
				echo "<td align='right' rowspan='".$TotalFilas."'>".round($Row[acidc],0)."</td>\n";
				$TotalACID=$TotalACID+$Row[acidc];	
				echo "<td align='right' rowspan='".$TotalFilas."'>".round($Row[petracel],0)."</td>\n";
				$TotalPETRA=$TotalPETRA+$Row[petracel];	
				echo "<td align='center' rowspan='".$TotalFilas."'>".substr($Row["fecha"],8,2)."/".substr($Row["fecha"],5,2)."/".substr($Row["fecha"],0,4)."</td>\n";
				$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Row[operador]."'";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Row2 = mysqli_fetch_array($Resp2))
					echo "<td align='left' rowspan='".$TotalFilas."'>".strtoupper(substr($Row2["nombres"],0,1)).". ".ucwords(strtolower($Row2["apellido_paterno"]))."</td>\n";
				else
					echo "<td align='left' rowspan='".$TotalFilas."'>&nbsp;</td>\n";
				echo "<td align='right' rowspan='".$TotalFilas."'>".round($Row[prod_calcina],0)."</td>\n";
				$TotalCAL=$TotalCAL+$Row[prod_calcina];	
				echo "<td align='center' rowspan='".$TotalFilas."'>".substr($Row[fecha_salida],8,2)."/".substr($Row[fecha_salida],5,2)."/".substr($Row[fecha_salida],0,4)."</td>\n";
				$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Row[operador_02]."'";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Row2 = mysqli_fetch_array($Resp2))
					echo "<td align='left' rowspan='".$TotalFilas."'>".strtoupper(substr($Row2["nombres"],0,1)).". ".ucwords(strtolower($Row2["apellido_paterno"]))."</td>\n";
				else
					echo "<td align='left' rowspan='".$TotalFilas."'>&nbsp;</td>\n";
			}
			
			echo "</tr>\n";
			$FechaAnt = $Row["fecha"];
			$HornadaAnt = $Row["hornada"];
			$NumHornoAnt=$Row[num_horno];
			$NumFundaAnt=$Row[num_funda];
			$HornadaTotalAnt=$Row[hornada_total];
			$HornadaParcialAnt=$Row[hornada_parcial];
		}
	}
?>
		<tr align="center" valign="middle" class="ColorTabla01">
<td colspan="5">&nbsp;</td>
<td align="right"><?php echo number_format($TotalBADH,3,",",".");?></td>
<td>&nbsp;</td>
<td align="right"><?php echo number_format($TotalBADC,3,",",".");?></td>
<td align="right"><?php echo number_format($Total1,3,",",".");?></td>
<td>&nbsp;</td>
<td align="right"><?php echo round($TotalACID,0);?></td>
<td align="right"><?php echo round($TotalPETRA,0);?></td>
<td colspan="2">&nbsp;</td>
<td align="right"><?php echo round($TotalCAL,0);?></td>
<td colspan="2">&nbsp;</td>
</tr>
  </table>
  <br>
    <table width="1060" border="1" cellspacing="0" cellpadding="3" class="TablaDetalle">
    <tr align="center" valign="middle" class="TituloCabeceraAzul"> 
		<td colspan="10">OTROS PRODUCTOS</td>
  	</tr>
    <tr align="center" valign="middle" class="TituloCabeceraAzul"> 
      <td colspan="4"><center>HORNADA </center></td>
      <td width="383" rowspan="2">OBSERVACION</td>
	  <td width="159" rowspan="2">FECHA</td>
	  <td width="121" rowspan="2">OPERADOR</td>
	  <td width="125" rowspan="2">PRODUCTO</td>
	</tr>
    <tr class="TituloCabeceraAzul"> 
      <td width="40" align="center" valign="middle">#Horno</td>
      <td width="41" align="center" valign="middle">#Funda</td>
      <td width="32" align="center" valign="middle">#HT</td>
      <td width="32" align="center" valign="middle">#HP</td>
    </tr>
		<?php
			$Consulta1 = "select t1.cod_producto,t1.cod_subproducto,t1.rut, t1.fecha, t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial,t1.observacion,t1.turno,concat(left(t2.nombres,1),'. ',t2.apellido_paterno) as nombre";
			$Consulta1.= " from pmn_web.observaciones t1 left join proyecto_modernizacion.funcionarios t2 on t1.rut = t2.rut";
			$Consulta1.= " where t1.fecha between '".$FechaIni."' and '".$FechaFin."' ";
			$Consulta1.= " order by t1.fecha,t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial";
			$Respuesta1 = mysqli_query($link, $Consulta1);
			while($Row1 = mysqli_fetch_array($Respuesta1))
			{
					echo "<tr>";
					echo "<td align='center'>".$Row1[num_horno]."</td>\n";
					echo "<td align='center'>".$Row1[num_funda]."</td>\n";
					echo "<td align='center'>".$Row1[hornada_total]."</td>\n";
					echo "<td align='center'>".$Row1[hornada_parcial]."</td>\n";
					echo "<td align='left'>".$Row1["observacion"]."</td>\n";
					echo "<td align='left'>".$Row1["fecha"]."</td>\n";
					echo "<td align='left'>".$Row1["nombre"]."</td>\n";
					if ($Row1["cod_subproducto"]=='23')
					{
						echo "<td align='center'>REMANENTE</td>\n";
					}
					else
					{
						echo "<td align='center'>REPROCESO</td>\n";
					}	
				echo "</tr>";
			
			}
		?>	

</TABLE>
</form>
</body>
</html>