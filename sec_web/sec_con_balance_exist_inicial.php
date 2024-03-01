<?php
	$CodigoDeSistema = 3;
	$CodigoDePantalla =16; 
	include("../principal/conectar_principal.php");
	if (!isset($DiaIni))
	{
		$DiaFin = "31";
		$MesFin = str_pad($MesFin,2, "0", STR_PAD_LEFT);
		$AnoFin = $AnoFin;
		$DiaIni = "01";
		$MesIni = $MesFin;
		$AnoIni = $AnoFin;		
	}
	$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);	
	$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad($DiaFin,2, "0", STR_PAD_LEFT);
	$FechaInicio = $FechaAux;
	$Ano = $AnoFin;
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = frmPrincipal;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			f.action = "sec_con_balance.php";
			f.submit();
			break;
	}
}
function Detalle(prod,subprod,ano,cod_lote,num_lote)
{
	window.open("sec_con_balance_detalle_paquete.php?Producto=" + prod + "&SubProducto=" + subprod + "&Ano=" + ano + "&Codigo=" + cod_lote + "&Numero=" + num_lote,"","top=40,left=10,width=680,height=350,scrollbars=yes,resizable = yes");
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
  <table width="523" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr align="center"> 
      <td height="30" colspan="2"><strong>TIPO DE MOVIMIENTO EXISTENCIA FINAL</strong></td>
    </tr>
    <tr> 
      <td width="120"><strong>PRODUCTO</strong></td>
      <td width="387"> 
        <?php
		$Consulta = "SELECT * from proyecto_modernizacion.productos ";
		$Consulta.= " where cod_producto = '".$Producto."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			echo strtoupper($Fila["descripcion"]);
		}
?>
      </td>
    </tr>
    <tr> 
      <td><strong>SUBPRODUCTO</strong></td>
      <td> 
        <?php
		$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
		$Consulta.= " where cod_producto = '".$Producto."'";
		$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			echo strtoupper($Fila["descripcion"]);
		}
?>
      </td>
    </tr>
    <tr> 
      <td><strong>PERIODO</strong></td>
      <td> 
        <?php
		echo str_pad($DiaIni,2, "0", STR_PAD_LEFT)."/".str_pad($MesIni, 2, "0", STR_PAD_LEFT)."/".$AnoIni." AL ".str_pad($DiaFin, 2, "0", STR_PAD_LEFT)."/".str_pad($MesFin, 2, "0", STR_PAD_LEFT)."/".$AnoFin;
	?>
      </td>
    </tr>
    <tr> 
      <td colspan="2"><strong>
	  <?php
	switch ($FinoLeyes)
	{
		case "L":
			echo "LEYES";
			break;
		case "F":
			echo "FINOS";
			break;
	}
	?></strong></td>
    </tr>
    <tr align="center"> 
      <td colspan="2"> <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px;" onClick="Proceso('I')"> 
        <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="Proceso('S')"> 
      </td>
    </tr>
  </table>
<br>
<?php
	$ArrLeyes = array();
	//-------------------------LEYES DE CALIDAD-----------------------------
	$Consulta = "SELECT distinct t3.cod_leyes, t3.abreviatura ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
	$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";
	$Consulta.= " where t1.estado_actual <> '16' and t1.estado_actual <> '7'";
	/*$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($FechaInicio,5,2),(substr($FechaInicio,8,2)-3),substr($FechaInicio,0,4)));
	$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($FechaTermino,5,2),(substr($FechaTermino,8,2)+3),substr($FechaTermino,0,4)));
	$Consulta.= " and t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";*/
	$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
	if ($Producto == "48")
		$Consulta.= " and t1.cod_periodo = '2'";
	else
		$Consulta.= " and t1.cod_periodo = '1'";
	if (($Producto == "48") || ($Producto == "18" && $SubProducto != "5"))
	{
		$Consulta.= " and t1.cod_producto = '18'";
		if ((($Producto == "18") && (intval($Fila3["cod_grupo"]) < 50)) || ($Producto == "48"))
		{
			$Consulta.= " and t1.cod_subproducto = '1'";
		}
	}
	else
	{
		$Consulta.= " and t1.cod_producto = '".$Producto."'";
		$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";
	}
	$Consulta.= " order by t3.cod_leyes ";
	$Respuesta2 = mysqli_query($link, $Consulta);
	$ArrLeyes["02"][0] = "02";
	$ArrLeyes["02"][1] = "Cu";
	$ArrLeyes["02"][2] = "";
	while ($Fila2 = mysqli_fetch_array($Respuesta2))
	{
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
		$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
		$Respuesta3 = mysqli_query($link, $Consulta);
		if ($Fila3 = mysqli_fetch_array($Respuesta3))
		{
			$ArrLeyes[$Fila2["cod_leyes"]][0] = $Fila2["cod_leyes"];
			$ArrLeyes[$Fila2["cod_leyes"]][1] = $Fila2["abreviatura"];
			$ArrLeyes[$Fila2["cod_leyes"]][2] = "";
		}
	}
	$LargoTabla = 300 + (count($ArrLeyes) * 25);
?>
<table width="<?php echo $LargoTabla; ?>" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td width="88" rowspan="2">LOTE</td>
    <td width="73" rowspan="2">N.ENVIO</td>
	<td width="73" rowspan="2">N.CERT</td>
	<td width="73" rowspan="2">PESO </td>
    <?php
	reset($ArrLeyes);
	foreach($ArrLeyes as $k => $v)
	{
		echo "<td width='25'>".$v[1]."<br>";
		if ($FinoLeyes == "F")
		{			
			switch ($v[0])
			{
				case "02":
					echo "kg";
					break;
				default:
					echo "grs";
					break;
			}
		}
		else
		{
			switch ($v[0])
			{
				case "02":
					echo "%";
					break;
				case "04":
					echo "gr/t";
					break;
				case "05":
					echo "gr/t";
					break;
				default:
					echo "ppm";
					break;
			}
		}
		echo "</td>\n";
	}
?>
  </tr>
  <tr class="ColorTabla01">
	<?php
		switch ($FinoLeyes)
		{
			case "F":
      			echo "<td colspan='".count($ArrLeyes)."' align='center'>Finos</td>\n";
				break;
			case "L":
      			echo "<td colspan='".count($ArrLeyes)."' align='center'>Leyes</td>\n";
				break;
		}
	 ?>
    </tr>
  <?php
  	$ArrTotal = array();
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaAux,5,2))."'"	;
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$MesConsulta = $Fila["nombre_subclase"];
	}
	$Color = "";
	$TotalPeso = 0;
	if ($Color == "")
		$Color = "WHITE";
	else
		$Color = "";
	$Eliminar = "DROP TABLE `sec_web`.`tmp_stock_ini`";
	mysqli_query($link, $Eliminar);
	$Consulta = " create table sec_web.tmp_stock_ini as ";
	$Consulta.= " SELECT t2.cod_bulto, t2.num_bulto, year(t2.fecha_creacion_lote) as ano_creacion, sum(t1.peso_paquetes) as peso ";
	$Consulta.= " from sec_web.paquete_catodo t1 inner join sec_web.lote_catodo t2 ";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
	$Consulta.= " where ";
	$Consulta.= " t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."' ";
	$Consulta.= " and t1.cod_estado = 'a' ";
	$Consulta.= " and (year(t1.fecha_creacion_paquete) <= ".$AnoFin." and t1.cod_paquete < '".$MesConsulta."' ";
	$Consulta.= " or year(t1.fecha_creacion_paquete) < ".$AnoFin.") ";
	//$Consulta.= " and t1.fecha_creacion_paquete < '".$AnoFin."-".$MesFin."-01 00:00:00' ";
	$Consulta.= " group by t2.cod_bulto, t2.num_bulto ";
	$Consulta.= " order by ano_creacion, t2.cod_bulto, t2.num_bulto";
	//echo $Consulta."<br><br>";
	mysqli_query($link, $Consulta);
	$Consulta = " SELECT sum(t1.peso_paquetes) as peso,t2.cod_bulto,t2.num_bulto ";
	$Consulta.= " from sec_web.paquete_catodo t1  ";
	$Consulta.= " inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia ";
	$Consulta.= " where t2.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."' ";
	$Consulta.= " and t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."' ";
	$Consulta.= " and (year(t1.fecha_creacion_paquete) = ".$AnoFin."  ";
	$Consulta.= " and t1.cod_paquete < '".$MesConsulta."' or year(t1.fecha_creacion_paquete) < ".$AnoFin.")  ";
	//$Consulta.= " and t1.cod_paquete = '".$MesConsulta."' ";
	$Consulta.= " group by t2.cod_bulto,t2.num_bulto ";
	//echo $Consulta."<br><br>";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Insertar = "insert into sec_web.tmp_stock_ini (cod_bulto, num_bulto, ano_creacion, peso) ";
		$Insertar.= "values('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','','".$Fila["peso"]."')";
		mysqli_query($link, $Insertar);
	}
	$Consulta = "SELECT * from sec_web.tmp_stock_ini order by cod_bulto, num_bulto";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Color == "")
			$Color = "WHITE";
		else
			$Color = "";
		echo "<tr bgcolor = '".$Color."'>\n";
		reset($ArrLeyes);
		foreach($ArrLeyes as $k => $v)
		{
			$v[2] = "";
		}
		/*$Consulta = "SELECT cod_bulto, num_bulto, fecha_creacion_lote ";
		$Consulta.= "from sec_web.lote_catodo ";
		$Consulta.= " where cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$FechaCreacionLote = $Fila2["fecha_creacion_lote"];
		}*/
		echo "<td align='center'><a href=\"JavaScript:Detalle('".$Producto."','".$SubProducto."','".$Fila["ano_creacion"]."','".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."');\">";				
		echo strtoupper($Fila["cod_bulto"])."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT)."</a></td>\n";
		$Consulta = "SELECT num_envio from sec_web.embarque_ventana where cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto = '".$Fila["num_bulto"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			echo "<td align='center'>".str_pad($Fila2["num_envio"],5, "0", STR_PAD_LEFT)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";

		$NumCertificado = "";
		$Certif = false;
		//-----------------------BUSCA LEYES EN CERTIFICADO---------------------
		$Consulta = "SELECT t2.cod_leyes, t2.valor, t2.fecha, ";
		$Consulta.= " t2.signo, t3.abreviatura, t2.num_certificado, t2.version ";
		$Consulta.= " from sec_web.solicitud_certificado t1 inner join sec_web.certificacion_catodos t2 ";
		$Consulta.= " on t1.corr_enm = t2.corr_enm inner join proyecto_modernizacion.leyes t3";
		$Consulta.= " on t2.cod_leyes = t3.cod_leyes";
		$Consulta.= " where t1.cod_bulto = '".$Fila["cod_bulto"]."' and t1.num_bulto = '".$Fila["num_bulto"]."'";
		$Consulta.= " and t2.version = (SELECT max(t2.version) from sec_web.solicitud_certificado t1 ";
		$Consulta.= " inner join sec_web.certificacion_catodos t2 ";
		$Consulta.= " on t1.corr_enm = t2.corr_enm ";
		$Consulta.= " where t1.cod_bulto = '".$Fila["cod_bulto"]."' and t1.num_bulto = '".$Fila["num_bulto"]."')";
		$Consulta.= " order by t2.cod_leyes";
		$Respuesta2 = mysqli_query($link, $Consulta);
		$Encontro = false;
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$Certif = true;
			$Encontro = true;
			$ArrLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];
			$NumCertificado = $Fila2["num_certificado"];
		}
		//----------------------------------------------------------------------
		//---------------------BUSCA LEYES EN CALIDAD---------------------------
		if ($Encontro == false)
		{
			if ($Producto == "18" && ($SubProducto == 6 || $SubProducto == 8 || $SubProducto == 9 || $SubProducto == 10 || $SubProducto == 12))
			{//LOTE EXTERNO
				$Consulta = "SELECT distinct t1.lote_origen as cod_grupo, sum(t1.peso_paquete) as peso_paquetes, fecha_creacion_paquete";
				$Consulta.= " from sec_web.paquete_catodo_externo t1 inner join sec_web.lote_catodo t2 ";
				$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
				$Consulta.= " where t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'";
				$Consulta.= " and t2.cod_bulto = '".$Fila["cod_bulto"]."' and t2.num_bulto = '".$Fila["num_bulto"]."' ";
				$Consulta.= " group by t1.lote_origen";
			}
			else
			{//LOTE VENTANA
				$Consulta = "SELECT distinct t1.cod_grupo, sum(t1.peso_paquetes) as peso_paquetes, fecha_creacion_paquete";
				$Consulta.= " from sec_web.paquete_catodo t1 inner join sec_web.lote_catodo t2 ";
				$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
				$Consulta.= " where t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'";
				$Consulta.= " and t2.cod_bulto = '".$Fila["cod_bulto"]."' and t2.num_bulto = '".$Fila["num_bulto"]."' ";
				$Consulta.= " group by t1.cod_grupo";
			}
			$Respuesta3 = mysqli_query($link, $Consulta);
			$ArrGrupos = array();
			$i = 0;
			while ($Fila3 = mysqli_fetch_array($Respuesta3))
			{
				//-------------------------LEYES DE CALIDAD-----------------------------
				$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
				$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
				$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
				$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
				$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
				$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";
				$Consulta.= " where t1.estado_actual <> '16' and t1.estado_actual <> '7'";
				if (($Producto == "18") && ($SubProducto != "5"))
				{
					$Consulta.= " and ((t1.tipo = 1 and (t1.id_muestra = '".$Fila3["cod_grupo"]."' or t1.id_muestra = '".intval($Fila3["cod_grupo"])."')) ";
					$Consulta.= " or (tipo = '2' and (t1.id_muestra = '".$Fila3["cod_grupo"]."-R' or t1.id_muestra = '".intval($Fila3["cod_grupo"])."-R'))) ";
				}
				if (($Producto == "18") && (intval($Fila3["cod_grupo"]) >= 50))
				{
					$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($Fila3["fecha_creacion_paquete"],5,2),(substr($Fila3["fecha_creacion_paquete"],8,2)+15),substr($Fila3["fecha_creacion_paquete"],0,4)));
					$ConsFechaMax = "SELECT max(fecha_muestra) as fecha_muestra from cal_web.solicitud_analisis t1";
					$ConsFechaMax.= " where  ((t1.tipo = 1 and (t1.id_muestra = '".$Fila3["cod_grupo"]."' or t1.id_muestra = '".intval($Fila3["cod_grupo"])."')) ";
					$ConsFechaMax.= " or (tipo = '2' and (t1.id_muestra = '".$Fila3["cod_grupo"]."-R' or t1.id_muestra = '".intval($Fila3["cod_grupo"])."-R'))) ";
					$ConsFechaMax.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
					$ConsFechaMax.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
					$ConsFechaMax.= " and t1.cod_periodo = '1'";
					$ConsFechaMax.= " and t1.cod_producto = '18'";
					$ConsFechaMax.= " and t1.fecha_muestra <= '".$Fecha1."'";
					$ConsFechaMax.= " order by t1.fecha_muestra desc ";
					$RespFechaMax = mysqli_query($link, $ConsFechaMax);
					if ($FilaF = mysqli_fetch_array($RespFechaMax))
					{
						$Fecha1 = substr($FilaF["fecha_muestra"],0,10);
						$Fecha2 = substr($FilaF["fecha_muestra"],0,10);
					}
					else
					{
						$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($Fila3["fecha_creacion_paquete"],5,2),(substr($Fila3["fecha_creacion_paquete"],8,2)-4),substr($Fila3["fecha_creacion_paquete"],0,4)));
						$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($Fila3["fecha_creacion_paquete"],5,2),(substr($Fila3["fecha_creacion_paquete"],8,2)+4),substr($Fila3["fecha_creacion_paquete"],0,4)));
					}
				}
				else
				{
					if ($Producto == "48") //LEY SEMANAL
					{
						if (intval(substr($Fila3["fecha_creacion_paquete"],8,2)) <= 7)
						{
							$Fecha1 = substr($FechaAux,0,7)."-01";
							$Fecha2 = substr($FechaAux,0,7)."-07";
						}
						else
						{
							if ((intval(substr($Fila3["fecha_creacion_paquete"],8,2)) >= 8) && (intval(substr($Fila3["fecha_creacion_paquete"],8,2)) <= 14))
							{
								$Fecha1 = substr($FechaAux,0,7)."-08";
								$Fecha2 = substr($FechaAux,0,7)."-14";
							}
							else
							{
								if ((intval(substr($Fila3["fecha_creacion_paquete"],8,2)) >= 22) && (intval(substr($Fila3["fecha_creacion_paquete"],8,2)) <= 31))
								{
									$Fecha1 = substr($FechaAux,0,7)."-22";
									$Fecha2 = substr($FechaAux,0,7)."-31";
								}
							}
						}
					}
					else
					{
						$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($Fila3["fecha_creacion_paquete"],5,2),(substr($Fila3["fecha_creacion_paquete"],8,2)-4),substr($Fila3["fecha_creacion_paquete"],0,4)));
						$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($Fila3["fecha_creacion_paquete"],5,2),(substr($Fila3["fecha_creacion_paquete"],8,2)+4),substr($Fila3["fecha_creacion_paquete"],0,4)));
					}
				}
				$Consulta.= " and t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";
				$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
				if ($Producto == "48")
					$Consulta.= " and t1.cod_periodo = '2'";
				else
					$Consulta.= " and t1.cod_periodo = '1'";
				if (($Producto == "48") || ($Producto == "18" && $SubProducto != "5"))
				{
					$Consulta.= " and t1.cod_producto = '18'";
					if ((($Producto == "18") && (intval($Fila3["cod_grupo"]) < 50)) || ($Producto == "48"))
					{
						$Consulta.= " and t1.cod_subproducto = '1'";
					}
				}
				else
				{
					$Consulta.= " and t1.cod_producto = '".$Producto."'";
					$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";
				}
				$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
				$Respuesta2 = mysqli_query($link, $Consulta);
				while ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					reset($ArrLeyes);
					foreach($ArrLeyes as $k => $v)
					{
						if ($v[0] == $Fila2["cod_leyes"])
						{
							$ArrGrupos[$Fila2["cod_leyes"]][0] = strtoupper($Fila["cod_bulto"])."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT);
							$ArrGrupos[$Fila2["cod_leyes"]][1] = $ArrGrupos[$Fila2["cod_leyes"]][1] + $Fila3["peso_paquetes"];
							$ArrGrupos[$Fila2["cod_leyes"]][2] = $Fila2["cod_leyes"];
							$ArrGrupos[$Fila2["cod_leyes"]][3] = $ArrGrupos[$Fila2["cod_leyes"]][3] + $Fila2["valor"];
							$ArrGrupos[$Fila2["cod_leyes"]][4] = $ArrGrupos[$Fila2["cod_leyes"]][4] + ($Fila2["valor"] * $Fila3["peso_paquetes"]);
						}
					}
				}
				reset($ArrGrupos);
				while (list($k,$v)=each($ArrGrupos))
				{
					$ArrLeyes[$v[2]][2] = $v[4] / $v[1];
				}
			}
		}
		//----------------------------------------------------------------------
		if ($NumCertificado == "" || $NumCertificado == "0")
			echo "<td align='right'>&nbsp;</td>\n";
		else
			echo "<td align='right'>".str_pad($NumCertificado,5, "0", STR_PAD_LEFT)."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";
		if ($Certif == true)
		{
			$SumaImpurezas = "";
			reset($ArrLeyes);
			foreach($ArrLeyes as $k => $v)
			{
				if ($v[0] != "48")
				{
					if ($v[0] != "04" || $v[0] != "05")
						$SumaImpurezas = $SumaImpurezas + ($v[2] / 10000);
					else
						$SumaImpurezas = $SumaImpurezas + ($v[2] / 10000);
				}
			}
			if ((100 - $SumaImpurezas) > 99.980)
				$ArrLeyes["02"][2] = "99.99";
			else
				$ArrLeyes["02"][2] = 100 - $SumaImpurezas;
		}
		/*if (($Producto == "18" && $SubProducto != "5") || ($Producto == "48"))
		{
			$ArrLeyes["02"][2] = 99.99;
		}*/
		reset($ArrLeyes);
		foreach($ArrLeyes as $k => $v)
		{
			if ($FinoLeyes == "L")
			{
				$Valor = $v[2];
				switch ($v[0])
				{
					case "02":
						$ValorAux = ($v[2] * $Fila["peso"]) / 100;
						break;
					case "04":
						$ValorAux = ($v[2] * $Fila["peso"]) / 1000;
						break;
					case "05":
						$ValorAux = ($v[2] * $Fila["peso"]) / 1000;
						break;
					default:
						$ValorAux = ($v[2] * $Fila["peso"]) / 1000000;
						break;
				}
				$ArrTotal[$v[0]][0] = $v[0];
				$ArrTotal[$v[0]][1] = $ArrTotal[$v[0]][1] + $ValorAux;
			}
			else
			{
				switch ($v[0])
				{
					case "02":
						$Valor = ($v[2] * $Fila["peso"]) / 100;
						break;
					case "04":
						$Valor = ($v[2] * $Fila["peso"]) / 1000;
						break;
					case "05":
						$Valor = ($v[2] * $Fila["peso"]) / 1000;
						break;
					default:
						$Valor = ($v[2] * $Fila["peso"]) / 1000000;
						break;
				}
				$ArrTotal[$v[0]][0] = $v[0];
				$ArrTotal[$v[0]][1] = $ArrTotal[$v[0]][1] + $Valor;
			}
			if ($v[0] == "02")
				echo "<td align='right'>".number_format($Valor,2,",",".")."</td>";
			else
				echo "<td align='right'>".number_format($Valor,1,",",".")."</td>";
		}
		//------------------------------------------------------------------------------------------------
		echo "</tr>\n";
		$TotalPeso = $TotalPeso + $Fila["peso"];
	}
?>
  <tr>
    <td colspan="3">TOTAL</td>
    <td align="right"><?php echo number_format($TotalPeso,0,",","."); ?></td>
<?php
   foreach($ArrTotal as $k => $v)
{
	echo "<td align='right'>\n";
	switch ($FinoLeyes)
	{
		case "L":
			switch ($v[0])
			{
				case "02":
					echo number_format(($v[1] / $TotalPeso)*100,2,",",".");
					break;
				case "04":
					echo number_format(($v[1] / $TotalPeso)*1000,1,",",".");
					break;
				case "05":
					echo number_format(($v[1] / $TotalPeso)*1000,1,",",".");
					break;
				default:
					echo number_format(($v[1] / $TotalPeso)*1000000,1,",",".");
					break;
			}
			break;
		case "F":
			echo number_format($v[1],0,",",".");
			break;
	}
	echo "</td>\n";
}

?>
  </tr>
</table>
</form>
</body>
</html>
