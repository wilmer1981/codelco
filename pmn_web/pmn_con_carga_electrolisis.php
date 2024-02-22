<?php
	include("../principal/conectar_pmn_web.php");
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
	f.action="pmn_xls_carga_electrolisis.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
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
  <table width="732" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      <td width="429" align="center" valign="middle"><strong class="titulo_azul">CARGA ELECTROLISIS 
        MOVIMIENTO DE ANODOS CODELCO </strong></td>
      <td width="102" align="center" valign="middle"><div align="right">
          <input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');">
        </div></td>
      <td width="162" align="center" valign="middle"><div align="left">
          <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
          <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
        </div></td>
    </tr>
  </table>
<strong> <br>
<br>
</strong> 
  <table width="733" border="1" cellspacing="0" cellpadding="3" class="TituloCabeceraAzul">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="72">ELECTROLIS</td>	
      <td width="41" rowspan="2">TURNO</td>
      <td width="58">GRUPO</td>
      <td width="36" rowspan="2">FECHA</td>
      <td width="99">CORRELATIVO</td>
      <td colspan="3">ANODOS A CARGAR</td>
      <td width="81" rowspan="2">JEFE DE <br>
        TURNO</td>
      <td width="68" rowspan="2">OP E AG</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center" valign="middle">N&deg;.</td>	
      <td align="center" valign="middle">M</td>

      <td align="center" valign="middle">HOMOG</td>
      <td width="64"><div align="center">HORNADA</div></td>
      <td width="66">PESO</td>
      <td width="66">N&deg;</td>
    </tr>
    <?php 
	$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
	$Consulta.= " where fecha between '".$FechaIni."' and '".$FechaFin."' ";
	if ($Turno != "S")
		$Consulta.= " and turno = '".$Turno."'";
	$Consulta.= " order by num_electrolisis, turno ";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	$ElectrolisisAnt = "";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		if ($ElectrolisisAnt != $Row[num_electrolisis])	
		{	
			$Consulta = "select count(*) as total from pmn_web.carga_electrolisis_plata ";
			$Consulta.= " where num_electrolisis = '".$Row[num_electrolisis]."' ";
			if ($Turno != "S")
				$Consulta.= " and turno = '".$Turno."'";
			$Consulta.= " order by num_electrolisis, turno ";
			//echo $Consulta."<br>";
			$Resp2 = mysqli_query($link, $Consulta);
			$Row2 = mysqli_fetch_array($Resp2);
			$TotalFilas = $Row2["total"];
			echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[num_electrolisis]."</td>\n";
		}
		switch ($Row[turno])
		{
			case 1:
				echo "<td align='center'>A</td>\n";
				break;
			case 2:
				echo "<td align='center'>B</td>\n";
				break;
			case 3:
				echo "<td align='center'>C</td>\n";
				break;
			default:
				echo "<td align='center'>&nbsp;</td>\n";
				break;
		}		
		echo "<td align='center'>".$Row["grupo"]."</td>\n";
		echo "<td align='center'>".substr($Row["fecha"],8,2)."/".substr($Row["fecha"],5,2)."/".substr($Row["fecha"],0,4)."</td>\n";
		echo "<td align='center'>".$Row[correlativo]."</td>\n";
		echo "<td align='center'>".$Row["hornada"]."</td>\n";
		echo "<td align='center'>".number_format($Row[peso_anodos],3,",","")."</td>\n";
		echo "<td align='center'>".$Row[cant_anodos]."</td>\n";
		$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Row[jefe_turno]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp2))
			echo "<td align='left'>".strtoupper(substr($Row2["nombres"],0,1)).". ".ucwords(strtolower($Row2["apellido_paterno"]))."</td>\n";
		else
			echo "<td align='left'>&nbsp;</td>\n";
		/*$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Row[operador]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp2))
			echo "<td align='left'>".strtoupper(substr($Row2["nombres"],0,1)).". ".ucwords(strtolower($Row2["apellido_paterno"]))."</td>\n";
		else
			echo "<td align='left'>&nbsp;</td>\n";*/
		$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Row[operador]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp2))
			echo "<td align='left'>".strtoupper(substr($Row2["nombres"],0,1)).". ".ucwords(strtolower($Row2["apellido_paterno"]))."</td>\n";
		else
			echo "<td align='left'>&nbsp;</td>\n";
		echo "</tr>\n";
		$ElectrolisisAnt = $Row[num_electrolisis];
	}
?>
  </table>
</form>
</body>
</html>
