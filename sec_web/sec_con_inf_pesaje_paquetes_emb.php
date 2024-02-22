<?php
	include("../principal/conectar_principal.php"); 
	if (!isset($DiaIni))
	{
		$DiaIni = date("j");
		$MesIni = date("n");
		$AnoIni = date("Y");
		$DiaFin = date("j");
		$MesFin = date("n");
		$AnoFin = date("Y");
	}
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
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link rel="stylesheet" type="text/css" href="../Principal/estilos/css_principal.css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sec_con_inf_pesaje_paquetes_emb.php";
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
&nbsp;
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><strong>INFORME PESAJE PAQUESTES DE EMBARQUE</strong></td>
  </tr>
</table>
<br>
<table width="750" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
  <tr> 
    <td width="86">Fecha Inicio: </td>
    <td width="259"><SELECT name="DiaIni" style="width:50px;">
        <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
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
      </SELECT> <SELECT name="MesIni" style="width:90px;">
        <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
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
      </SELECT> <SELECT name="AnoIni" style="width:60px;">
        <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
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
    <td width="119">Fecha Termino:</td>
    <td width="265"><SELECT name="DiaFin" style="width:50px;">
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
  <tr> 
    <td colspan="4" align="center"> <input type="submit" name="Submit" value="Consultar"> 
      <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')"> 
      <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"> 
    </td>
  </tr>
</table>
<br>
  <?php
  	$FechaAux = $FechaInicio;
  	while (date($FechaAux) <= date($FechaTermino))
	{		
		$Consulta = "SELECT ifnull(count(*),0) as total_reg from sec_web.paquete_catodo ";
		$Consulta.= " where fecha_creacion_paquete between '".$FechaAux." 00:00:00' and '".$FechaAux." 23:59:59' ";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["total_reg"] != 0)
			{
				echo "<br><table width='500' border='0' align='center' cellpadding='2' cellspacing='1' class='TablaInterior'>\n";
				echo "<tr> \n";
				echo "<td align='center'><strong>DIA: ".substr($FechaAux,5,2)."/".substr($FechaAux,8,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
				echo "</tr>\n";
				echo "</table>\n";
				echo "<br>\n";		
			}
		}
		$Consulta = "SELECT * from sec_web.paquete_catodo ";
		$Consulta.= " where fecha_creacion_paquete between '".$FechaAux." 00:00:00' and '".$FechaAux." 23:59:59' ";
		$Consulta.= " order by fecha_creacion_paquete, cod_grupo";
		$Respuesta = mysqli_query($link, $Consulta);
		$SubTotalDia = 0;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{			
			$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto = '".$Fila["cod_producto"]."' ";
			$Consulta.= " and cod_subproducto = '".$Fila["cod_subproducto"]."'";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				echo "</table>\n";
				echo "<table width='500' border='1' align='center' cellpadding='0' cellspacing='0' class='TablaDetalle'>\n";
				echo "<tr align='center' class='ColorTabla01'>\n";
				echo "<td><strong>".$Fila2["cod_producto"]."</strong></td>\n";
				echo "<td colspan='6'><strong>".$Fila2["descripcion"]."</strong></td>\n";
				echo "</tr>\n";				
				echo "<tr align='center' class='ColorTabla01'> \n";
				echo "<td width='57'>GRUPO</td>\n";
				echo "<td width='89'>PESO</td>\n";
				echo "<td width='98'>PESO ACUM.</td>\n";
				echo "<td width='94'>SERIE</td>\n";
				echo "</tr>\n";				
			}
			echo "<tr>\n";
			echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
			echo "<td align='right'>".number_format($Fila["peso_paquetes"],0,",",".")."</td>\n";
			$TotalPesoProd = $TotalPesoProd + $Fila["peso_paquetes"];
			$SubTotalDia = $SubTotalDia + $Fila["peso_paquetes"];
			echo "<td align='right'>".number_format($TotalPesoProd,0,",",".")."</td>\n";
			echo "<td align='center'>".$Fila["cod_paquete"]."-".$Fila["num_paquete"]."</td>\n";
			echo "</tr>\n";
		}
		echo "<tr> \n";
		echo "<td colspan='3'><strong>SUB-TOTALES\n";
		echo "</strong></td>\n";
		echo "<td align='right'>".number_format($SubTotalDia,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($TotalPesoProd,0,",",".")."</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "</tr>\n";
		echo "</table><br>\n";
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),(intval(substr($FechaAux,8,2)) + 1),substr($FechaAux,0,4)));
	}
	?>
<br>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"> <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"></td>
  </tr>
</table>
</body>
</html>
