<?php
	include("../principal/conectar_principal.php"); 

	$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date('d');
	$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date('m');
	$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date('Y');
	$DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date('d');
	$MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date('m');
	$AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date('Y');

	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
	
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;

?><html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link rel="stylesheet" href="../Principal/estilos/css_principal.css" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sec_con_inf_grupos_paquetes.php";
			f.submit();
			break;
		case "E":
			f.action ="sec_con_inf_grupos_paquetes_excel.php";
			f.submit();
			break;
		case "S":
			f.action ="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><strong>INFORME DE GRUPOS DE PAQUETES</strong></td>
    </tr>
  </table>
  <br>
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
    <tr> 
      <td width="93">Fecha Inicio: </td>
      <td width="272"><strong> 
        <SELECT name="DiaIni" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}/*
			else
			{
				if ($i == date("j"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}*/
		}
	  ?>
        </SELECT>
        <SELECT name="MesIni" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}/*
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}*/
		}
		?>
        </SELECT>
        <SELECT name="AnoIni" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}/*
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}*/
		}
		?>
        </SELECT>
        </strong></td>
      <td width="124">Fecha Termino:</td>
      <td width="240"><SELECT name="DiaFin" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </SELECT> <SELECT name="MesFin" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </SELECT> <SELECT name="AnoFin" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </SELECT></td>
    </tr>
    <tr align="center"> 
      <td colspan="4"> <input type="submit" name="Submit" value="Consultar" style="width:70" onClick="JavaScript:Proceso('C')"> 
	  	<input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')">
        <input name="btnExcel" type="button" id="btnExcel" style="width:70" onClick="JavaScript:Proceso('E')" value="Excel">
        <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"> 
      </td>
    </tr>
  </table>
<br>
<table width="555" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01"> 
    <td width="53">COD.</td>
    <td width="71">LOTE</td>
    <td width="85">GRUPO</td>
    <td width="130">FECHA</td>
    <td width="91">UNIDADES</td>
    <td width="110">CANT. PAQUETES</td>
  </tr>
  <?php
	$Consulta = "SELECT distinct t1.cod_bulto, t1.num_bulto, t2.cod_grupo, ";
	$Consulta.= " t1.fecha_creacion_lote, sum(t2.num_unidades) as unidades, count(*) as cant_paquetes";
	$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
	$Consulta.= " where t1.fecha_creacion_lote between '".$FechaInicio."' and '".$FechaTermino."'";
	$Consulta.= " group by t1.cod_bulto, t1.num_bulto";
	$Consulta.= " order by t1.fecha_creacion_lote, t1.cod_bulto, t1.num_bulto";
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalUnidades = 0;
	$TotalPaquetes = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["cod_bulto"]."</td>\n";
		echo "<td align='center'>".$Fila["num_bulto"]."</td>\n";
		echo "<td align='center'>";
		if ($Fila["cod_grupo"])
			echo $Fila["cod_grupo"];
		else
			echo "&nbsp;";
		echo "</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_creacion_lote"],8,2)."/".substr($Fila["fecha_creacion_lote"],5,2)."/".substr($Fila["fecha_creacion_lote"],0,4)."</td>\n";
		echo "<td align='right'>".number_format($Fila["unidades"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["cant_paquetes"],0,",",".")."</td>\n";		
		echo "</tr>\n";
		$TotalUnidades = $TotalUnidades + $Fila["unidades"];
		$TotalPaquetes = $TotalPaquetes + $Fila["cant_paquetes"];
	}
	?>
  <tr> 
    <td colspan="4"><strong>TOTALES EN PERIODO <?php echo $DiaIni."/".$MesIni."/".$AnoFin." al ".$DiaFin."/".$MesFin."/".$AnoFin ?> </strong></td>
    <td align="right"> <?php echo number_format($TotalUnidades,0,",",".") ?></td>
    <td align="right"> <?php echo number_format($TotalPaquetes,0,",",".") ?></td>
  </tr>
</table>
<br>
<br>
</form>
</body>
</html>
