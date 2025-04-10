<?php
	$CodigoDeSistema = 3;
	$CodigoDePantalla =16; 
	include("../principal/conectar_principal.php");
	set_time_limit(2200);
	include("sec_con_balance_crea_cetif_virtual.php");
	$AnoFin  = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:"";
	$MesFin  = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:"";
	$DiaFin  = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:"31";
	$AnoIni  = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:$AnoFin;
	$MesIni  = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:$MesFin;
	$DiaIni  = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:"01";

	$Producto     = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$FinoLeyes    = isset($_REQUEST["FinoLeyes"])?$_REQUEST["FinoLeyes"]:"";
	if ($DiaIni=="")
	{
		//$DiaFin = "31";
		$MesFin = str_pad($MesFin,2, "0", STR_PAD_LEFT);
		$AnoFin = $AnoFin;
		//$DiaIni = "01";
		//$MesIni = $MesFin;
		//$AnoIni = $AnoFin;		
	}
	$Ano = $AnoFin;
	$FechaAux     = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);	
	$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad($DiaFin,2, "0", STR_PAD_LEFT);
	$FechaAux     = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
	$FechaInicio  = $FechaAux;
	$FechaTerminoReal = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),1-1,substr($FechaAux,0,4)));
	$FechaTermino     = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
	$FechaTermino     = date("Y-m-d", mktime(0,0,0,substr($FechaTermino,5,2),intval(substr($FechaTermino,8,2)) - 1,substr($FechaTermino,0,4)));	
	//echo "AnoFin: ".$AnoFin."<br>";
	//echo "FechaInicio: ".$FechaInicio."<br>";
	//echo "Fecha Termino: ".$FechaTerminoReal."<br>";
	//echo "Fecha Termino: ".$FechaTermino."<br>";
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
function Informacion(Mes,Lote, Ano)
{
	var URL = "sec_con_balance_cetif_virtual.php?Mes=" + Mes + "&Lote=" + Lote + "&Ano=" + Ano;
	window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
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
		if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
		{
			echo "SULFATO DE COBRE PTE Y PLAMEN";
		}
		else
		{
			$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto = '".$Producto."'";
			$Consulta.= " and cod_subproducto = '".$SubProducto."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				echo strtoupper($Fila["descripcion"]);
			}
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
	$Consulta = "SELECT STRAIGHT_JOIN distinct t3.cod_leyes, t3.abreviatura ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
	$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";
	$Consulta.= " where t1.estado_actual <> '16' and t1.estado_actual <> '7'";
	$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
	if ($Producto == "48")
		$Consulta.= " and t1.cod_periodo = '2'";
	else
		$Consulta.= " and t1.cod_periodo = '1'";
	if (($Producto == "48") || ($Producto == "18" && $SubProducto != "5"))
	{
		$Consulta.= " and t1.cod_producto = '18'";
		//if ((($Producto == "18") && (intval($Fila3["cod_grupo"]) < 50)) || ($Producto == "48"))
		if (($Producto == "18") || ($Producto == "48"))
		{
			$Consulta.= " and t1.cod_subproducto = '1'";
		}
	}
	else
	{
		if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
		{
			$Consulta.= " and t1.cod_producto = '64'";
			$Consulta.= " and (t1.cod_subproducto = '1' || t1.cod_subproducto = '5')";
		}
		else
		{				
			$Consulta.= " and t1.cod_producto = '".$Producto."'";
			$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";
		}
	}
	$Consulta.= " order by t3.cod_leyes ";
	//echo $Consulta."<br>"; //trae leyes
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
	$LargoTabla = 500 + (count($ArrLeyes) * 25);
?>
<table width="<?php echo $LargoTabla; ?>" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01"> 
    <td width="150" rowspan="2">LOTE</td>
    <td width="40" rowspan="2">N.ENVIO</td>	
	<td width="40" rowspan="2">#O.E./I.E.</td>
	<td width="40" rowspan="2">PAQ.</td>
	<td width="40" rowspan="2">MARCA</td>
	<td width="150" rowspan="2">ASIGNACION</td>
	<td width="40" rowspan="2">N.CERT</td>
	<td width="80" rowspan="2">PESO </td>
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
	<?php //echo "oooooo";
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
	$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaTerminoReal,5,2))."'"	;
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
		$MesConsulta = $Fila["nombre_subclase"];
	if ($MesConsulta == "A" || $MesConsulta=="M")
		$ano_7 =$AnoFin + 1;
	//echo "MesConsulta: ".$MesConsulta."<br>";	
	//echo "ano_7: ".$ano_7."<br>";	
	$Color = "";
	$TotalPeso = 0;
	if ($Color == "")
		$Color = "WHITE";
	else
		$Color = "";
	//ELIMINA TABLA tmp_stock_ini
	$Eliminar = "DROP TABLE `sec_web`.`tmp_stock_ini`";
	mysqli_query($link, $Eliminar);
	//CREA TEMPORAL tmp_stock_ini	
	$Consulta = " create table sec_web.tmp_stock_ini as ";
	$Consulta.= " SELECT STRAIGHT_JOIN t2.cod_bulto, t2.num_bulto, year(t2.fecha_creacion_lote) as ano_creacion, sum(t1.peso_paquetes) as peso,t2.corr_enm as ie, t2.cod_marca as marca, count(cod_bulto) as bulto ";
	$Consulta.= " from sec_web.paquete_catodo t1 inner join sec_web.lote_catodo t2 ";	
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
	$Consulta.= " where ";
	if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
	{
		$Consulta.= " t1.cod_producto = '64' and (t1.cod_subproducto = '1' || t1.cod_subproducto = '5')";
	}
	else
	{
		$Consulta.= " t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'  ";
	}
 
 	$Consulta.= "and "; 
	$Consulta.= "( ";
	$Consulta.= "(t1.cod_paquete='".$MesConsulta."' and t1.fecha_creacion_paquete <='".$FechaTerminoReal."' and ((t1.cod_estado='a' and t1.fecha_embarque = '0000-00-00') or (t1.cod_estado='c' and t1.fecha_embarque > '".$FechaTerminoReal."')))";
	$Consulta.= " or ";
	$Consulta.= "(t1.cod_paquete='".$MesConsulta."' and (t1.fecha_creacion_paquete between '".$FechaTerminoReal."' and '".$FechaTermino."') and ((t1.cod_estado='a' and t1.fecha_embarque = '0000-00-00') or (t1.cod_estado='c' and t1.fecha_embarque > '".$FechaTerminoReal."')))";
	$Consulta.= " or ";
	$Consulta.= "(t1.cod_paquete<>'".$MesConsulta."' and  t1.fecha_creacion_paquete <='".$FechaTerminoReal."' and ((t1.cod_estado='a' and t1.fecha_embarque = '0000-00-00') or (t1.cod_estado='c' and t1.fecha_embarque > '".$FechaTerminoReal."')))"; 
	$Consulta.= ")";	
	$Consulta.= " group by t2.cod_bulto, t2.num_bulto ";
	$Consulta.= " order by ano_creacion, t2.cod_bulto, t2.num_bulto";
	
    //echo "consulta".$Consulta; //solo muestra dos registros
	mysqli_query($link, $Consulta);

	//CONSULTA LO QUE SE TRASPASO
	$FechaIniAux = date("Y-m-d", mktime(0,0,0,substr($FechaInicio,5,2)-1,1,substr($FechaInicio,0,4)));
	$FechaFinAux = substr($FechaIniAux,0,4)."-".substr($FechaIniAux,5,2)."-31";
	$Consulta = "SELECT STRAIGHT_JOIN sum(t1.peso_paquetes) as peso,t3.cod_bulto,t3.num_bulto,";
	$Consulta.= " year(t3.fecha_creacion_lote) as ano_creacion, t5.hornada, t4.fecha_traspaso, t5.fecha_movimiento";
	$Consulta.= " from sec_web.paquete_catodo t1 ";
	$Consulta.= " inner join sec_web.lote_catodo t3 on t1.cod_paquete = t3.cod_paquete";
	$Consulta.= " and t1.num_paquete = t3.num_paquete and t1.fecha_creacion_paquete = t3.fecha_creacion_paquete";
	$Consulta.= " INNER join sec_web.traspaso t4 on t3.cod_bulto = t4.cod_bulto AND t3.num_bulto = t4.num_bulto and t3.fecha_creacion_lote=t4.fecha_creacion_lote";
	$Consulta.= " left join sea_web.movimientos t5 on t5.tipo_movimiento = 4 and t5.hornada = t4.hornada";
	$Consulta.= " left join sea_web.stock_piso_raf t6 on t5.hornada = t6.hornada";
	$Consulta.= " where t4.fecha_traspaso between '".$FechaIniAux."' and CURDATE() ";
	if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
	{
		$Consulta.= " and t1.cod_producto = '64' and (t1.cod_subproducto = '1' || t1.cod_subproducto = '5') ";
	}
	else
	{
		$Consulta.= " and t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."' ";
	}
	$Consulta.= " and (year(t1.fecha_creacion_paquete) = ".$AnoFin."  ";
	if (strtoupper($MesConsulta)=="A")
		$Consulta.= " and t1.cod_paquete <= 'M' ";
	else
		$Consulta.= " and t1.cod_paquete < '".$MesConsulta."' ";
	$Consulta.= " or year(t1.fecha_creacion_paquete) < ".$AnoFin.")  ";
	$Consulta.= " group by t3.cod_bulto,t3.num_bulto";
	//echo "traspaso".$Consulta."</br>";//no muestra nada
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Fila["fecha_traspaso"]>$FechaFinAux)
		{
			$Insertar = "insert into sec_web.tmp_stock_ini (cod_bulto, num_bulto, ano_creacion, peso) ";
			$Insertar.= "values('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Fila["ano_creacion"]."','".$Fila["peso"]."')";
			mysqli_query($link, $Insertar);
		}
	}
	//FIN TRASPASO		

	$Consulta = "SELECT * from sec_web.tmp_stock_ini order by ano_creacion, cod_bulto, num_bulto";
	
//	echo "<br> TERASD ".$Consulta."<br><br>";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Color == "")
			$Color = "WHITE";
		else
			$Color = "";
		echo "<tr bgcolor = '".$Color."'>\n";
		//LIMPIA ARREGLO DE LEYES
		reset($ArrLeyes);
		foreach($ArrLeyes as $key => $values)
		{
			$ArrLeyes[$key][2] = "";
		}
		echo "<td align='center'><a href=\"JavaScript:Detalle('".$Producto."','".$SubProducto."','".$Fila["ano_creacion"]."','".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."');\">";				
		echo strtoupper($Fila["cod_bulto"])."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT)."</a></td>\n";
		$Consulta = "SELECT num_envio from sec_web.embarque_ventana where cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto = '".$Fila["num_bulto"]."' and (year(fecha_programacion) >= '".$AnoFin."')";
		
		//echo "con  FF22 ".$Consulta;
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			echo "<td align='center'>".str_pad($Fila2["num_envio"],5, "0", STR_PAD_LEFT)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		
	    $num_envio = isset($Fila2["num_envio"])?$Fila2["num_envio"]:""; //agregado por WSO
		//--------------------------NUM. ORDEN DE EMBARQUE--------------------------------------------
		$Consulta = "SELECT * from sec_web.embarque_ventana ";
		//$Consulta.= " where num_envio='".$Fila2["num_envio"]."' ";
		$Consulta.= " where num_envio='".$num_envio."' ";
		$Consulta.= " and cod_bulto='".$Fila["cod_bulto"]."' ";
		$Consulta.= " and num_bulto='".$Fila["num_bulto"]."' ";
		//echo "con ".$Consulta;
		$RespAux=mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			echo "<td align=\"center\">".$FilaAux["corr_enm"]."</td>\n";
			$Consulta = "SELECT * from sec_web.programa_codelco where corr_codelco='".$FilaAux["corr_enm"]."'";

			$bulto_paquetes2 = $FilaAux["bulto_paquetes"]- $FilaAux["despacho_paquetes"];
	
			echo "<td>".$bulto_paquetes2."</td>\n";
			echo "<td>".$FilaAux["cod_marca"]."</td>\n";
		}	
		else
		{
			echo "<td>".$Fila["ie"]."</td>\n";
			$Consulta = "SELECT * from sec_web.programa_codelco where corr_codelco='".$Fila["ie"]."'";
			echo "<td>".$Fila["bulto"]."</td>\n";
			echo "<td>".$Fila["marca"]."</td>\n";
		}

		//-------------------------------------------------------------------------------------------
		$RespAux=mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
			echo "<td align=\"center\">".$FilaAux["cod_contrato_maquila"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		//-----------------------
		$NumCertificado = "";
		$Certif = false;
		//-----------------------BUSCA LEYES EN CERTIFICADO---------------------
		$Consulta = "SELECT STRAIGHT_JOIN t2.cod_leyes, t2.valor, t2.fecha, ";
		$Consulta.= " t2.signo, t3.abreviatura, t2.num_certificado, t2.version ";
		$Consulta.= " from sec_web.solicitud_certificado t1 inner join sec_web.certificacion_catodos t2 ";
		$Consulta.= " on t1.corr_enm = t2.corr_enm inner join proyecto_modernizacion.leyes t3";
		$Consulta.= " on t2.cod_leyes = t3.cod_leyes";
		$Consulta.= " where t1.cod_bulto = '".$Fila["cod_bulto"]."' and t1.num_bulto = '".$Fila["num_bulto"]."'";
		$Consulta.= " and t1.corr_enm = '".$Fila["ie"]."'";
		$Consulta.= " and t2.version = (SELECT max(t2.version) from sec_web.solicitud_certificado t1 ";
		$Consulta.= " inner join sec_web.certificacion_catodos t2 ";
		$Consulta.= " on t1.corr_enm = t2.corr_enm ";
		$Consulta.= " where t1.cod_bulto = '".$Fila["cod_bulto"]."' and t1.num_bulto = '".$Fila["num_bulto"]."')";
		$Consulta.= " and t2.corr_enm = '".$Fila["ie"]."'";
		$Consulta.= " order by t2.cod_leyes";
		//echo "LEYES CERTIF ".$Consulta."<br><br>";
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
		//---------------------CREA CERTIFICADO VIRTUAL---------------------------
		
		
		
		if ($Encontro == false)
		{
			//CREA CERTIFICADO VIRTUAL			
			CertifVirtual($Fila["cod_bulto"],$Fila["num_bulto"],$Fila["ano_creacion"],$link);			
			//CONSULTA LA TABLA TEMPORAL
			$Consulta = "SELECT t1.cod_leyes, t1.valor, t1.signo ";
			$Consulta.= " from sec_web.tmp_certificacion_catodos t1";
			$Consulta.= " where t1.cod_lote = '".$Fila["cod_bulto"]."' ";
			$Consulta.= " and t1.num_lote = '".$Fila["num_bulto"]."'";
			$Consulta.= " order by t1.cod_leyes";
			echo "<br><br>TEMPORAL ".$Consulta."<br>";
			$Respuesta2 = mysqli_query($link, $Consulta);
			$Encontro = false;
			while ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
			//	echo $Fila["cod_bulto"]." - ".$Fila["num_bulto"]."<br>";
				$Certif == true;
				$Encontro = true;
				$ArrLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];									
			}	
			if ($Encontro)		
				$NumCertificado = "Virtual";						
			else
				$NumCertificado = "No Creado";
			$Eliminar = "delete from `sec_web`.`tmp_certificacion_catodos`";
			mysqli_query($link, $Eliminar);		
		}
		if ($Producto == 18 && $SubProducto==57)
			{
				if($NumCertificado = "Virtual")
				{
					$Consulta="SELECT cal_web.certificados.nro_certificado,cal_web.certificados.nro_solicitud FROM";
					$Consulta.=" cal_web.solicitud_analisis Inner Join cal_web.certificados ON cal_web.solicitud_analisis.nro_solicitud = cal_web.certificados.nro_solicitud";
					$Consulta.=" WHERE cal_web.solicitud_analisis.id_muestra = '".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."'";
					$Respuesta2 = mysqli_query($link, $Consulta);
					$Encontro = false;
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$NumCertificado=$Fila2["nro_certificado"];
					}
				}
			}
		//--------------------------------------------------------------
		if (($NumCertificado == "Virtual") || ($NumCertificado == "No Creado"))
		{
			echo "<td align='center' bgcolor='yellow'><a href=\"JavaScript:Informacion('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Ano."');\">";				
			echo $NumCertificado."</a></td>\n";						
		}
		else
		{
			echo "<td align='center'><a href=\"JavaScript:Informacion('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Ano."');\">";
			echo str_pad($NumCertificado,5, "0", STR_PAD_LEFT)."</a></td>\n";
		}
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";
		if ($Certif == true)
		{
			$SumaImpurezas = 0;
			reset($ArrLeyes);
			foreach($ArrLeyes as $k => $v)
			{
				if ($v[0] != "48")
				{
					if ($v[0] != "04" || $v[0] != "05")			
						$SumaImpurezas = $SumaImpurezas + ((int)$v[2] / 10000);
					else
						$SumaImpurezas = $SumaImpurezas + ((int)$v[2] / 10000);
				}
			}
			if ((100 - $SumaImpurezas) > 99.980)
				$ArrLeyes["02"][2] = "99.99";
			else
				$ArrLeyes["02"][2] = 100 - $SumaImpurezas;			
		}	
		if (($Producto == "18" && $SubProducto != "5") || ($Producto == "48"))
		{			
			$ArrLeyes["02"][2] = 99.99;
		}						
		reset($ArrLeyes);
		foreach($ArrLeyes as $k => $v)
		{   $ArrTotal01 = isset($ArrTotal[$v[0]][1])?$ArrTotal[$v[0]][1]:0; //agregado por WSO
			if ($FinoLeyes == "L")
			{
				$Valor = $v[2];
				switch ($v[0])
				{
					case "02":
						$ValorAux = ((float)$v[2] * (float)$Fila["peso"]) / 100;
						break;
					case "04":
						$ValorAux = ((float)$v[2] * (float)$Fila["peso"]) / 1000;
						break;
					case "05":
						$ValorAux = ((float)$v[2] * (float)$Fila["peso"]) / 1000;
						break;
					default:
						$ValorAux = ((float)$v[2] * (float)$Fila["peso"]) / 1000000;
						break;
				}
				$ArrTotal[$v[0]][0] = $v[0];				
				//$ArrTotal[$v[0]][1] = $ArrTotal[$v[0]][1] + $ValorAux;
				$ArrTotal[$v[0]][1] = $ArrTotal01 + $ValorAux;
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
				//$ArrTotal[$v[0]][1] = $ArrTotal[$v[0]][1] + $Valor;
				$ArrTotal[$v[0]][1] = $ArrTotal01 + $Valor;
			}					
			if ($v[0] == "02") 
				echo "<td align='right'>".number_format((float)$Valor,2,",",".")."</td>";
			else
				echo "<td align='right'>".number_format((float)$Valor,1,",",".")."</td>";
		}			
		//------------------------------------------------------------------------------------------------					
		echo "</tr>\n";

		$TotalPeso = $TotalPeso + $Fila["peso"];		
	}
?>
  <tr> 
    <td colspan="7">TOTAL</td>
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