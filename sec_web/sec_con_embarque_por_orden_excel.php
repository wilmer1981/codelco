<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");


	include("../principal/conectar_principal.php"); 
	if (!isset($MesIni))
	{
		$MesIni = date("m");
		$AnoIni = date("Y");
	}
	$MesIni = str_pad($MesIni,2,"0",STR_PAD_LEFT);
 	$FechaInicio = $AnoIni."-".$MesIni."-01";
	$FechaTermino = $AnoIni."-".$MesIni."-31";
?>
<html>
<head>
<title>Sistema Estadistico de Catodo</title>

</head>

<body class="TablaPrincipal">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><strong>CONSULTA ORDEN DE EMBARQUE </strong></td>
    </tr>
  </table>
  <br>
  <br>
 
  <table width="1000" height="14"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="63" align="center">#O.E.</a></td>
	  <td width="100" align="center">ASIGNACION</a></td>
      <td width="35" align="center">SUBPRODUCTO</a></td>
      <td width="224" align="center">MARCA</td>
	  <td width="65" align="center">ATAD.</td>
      <td width="45" align="center">PIEZAS</td>     
      <td width="73" align="center">PESO NETO </td>
	  <td width="82" align="center">PESO BRUTO </td> 
	  <td width="61" align="center">F.DISP.</a></td>
	  <td width="61" align="center">F.RETIRO</a></td>  
	  <td width="50" align="center">CON/CUO/PAR</td>      
      <td width="25" align="center">EST.</td>
      <td width="25" align="center">SAP</td>
	  <td width="50" align="center">SUBPRODUCTO PESAJE</td>
    </tr>
    <?php  
	
		//$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);
		$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT);
		
//echo "FECHA".$FechaAux;
     $FechaControl = $FechaAux - 1;
     // echo "FECHA".$FechaControl;
	 $Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaAux,5,2))."'"	;
	//echo "Con".$Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	if ($FilaMes = mysqli_fetch_array($Respuesta))
	{
		$MesConsulta = $FilaMes["nombre_subclase"];
	}
	
	
	//$CrearTmp = "create temporary table if not exists sec_web.tmp_orden "; 
	
	$Borra ="drop table sec_web.tmp_orden";
	mysqli_query($link, $Borra);
	$CrearTmp = "create table sec_web.tmp_orden "; 
	//$CrearTmp = "create  table if not exists sec_web.tmp_orden "; 
	$CrearTmp.= "(corr_enm bigint(8), ";
	$CrearTmp.= " cod_producto varchar(10), ";
	$CrearTmp.= " cod_subproducto varchar(10), ";
	$CrearTmp.= " cod_cliente varchar(30), ";
	$CrearTmp.= " fecha_disponible date, ";    
	$CrearTmp.= " fecha_embarque date, ";
	$CrearTmp.= " estado char(1), ";
	$CrearTmp.= " nom_subprod varchar(50), ";
	$CrearTmp.= " asignacion varchar(20))";
	mysqli_query($link, $CrearTmp);
	//CONSULTA TABLA PROGRAMA ENAMI
	$Consulta="SELECT t1.corr_enm,t1.cod_producto, t1.cod_subproducto, t1.fecha_disponible, t1.fecha_embarque,t1.cod_cliente, t1.estado2  ";
	$Consulta.= " from sec_web.programa_enami t1 ";
	$Consulta.= " where  t1.fecha_embarque between '".$FechaInicio."' and '".$FechaTermino."' ";
	if ($CodProducto!="S")
		$Consulta.= " and  t1.cod_producto='".$CodProducto."' ";
	if ($SubProducto!="S")
		$Consulta.= " and  t1.cod_subproducto='".$SubProducto."' ";
	$Resultado=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resultado))
	{
		$Insertar = "insert into sec_web.tmp_orden (corr_enm,cod_producto, cod_subproducto,cod_cliente,fecha_disponible, fecha_embarque, estado, asignacion, nom_subprod) values(";
		$Insertar.= "'".$Fila["corr_enm"]."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','".$Fila["cod_cliente"]."','".$Fila["fecha_disponible"]."','".$Fila["fecha_embarque"]."','".$Fila["estado2"]."','','')";
		mysqli_query($link, $Insertar);
	}
	//CONSULTA TABLA PROGRAMA CODELCO
	$Consulta = " SELECT t1.corr_codelco, t1.cod_producto, t1.cod_subproducto, t1.cod_cliente, t1.fecha_disponible, t1.estado2, t1.cod_contrato_maquila, t2.abreviatura ";
	$Consulta.= " from sec_web.programa_codelco  t1 left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
	$Consulta.= " where  t1.fecha_disponible between '".$FechaInicio."' and '".$FechaTermino."' ";
	if ($CodProducto!="S")
		$Consulta.= " and  t1.cod_producto='".$CodProducto."' ";
	if ($SubProducto!="S")
		$Consulta.= " and  t1.cod_subproducto='".$SubProducto."' ";
	$Resultado=mysqli_query($link, $Consulta);
	//echo "WW".$Consulta;
	while ($Fila=mysqli_fetch_array($Resultado))
	{
		$Insertar = "insert into sec_web.tmp_orden (corr_enm,cod_producto, cod_subproducto, cod_cliente,fecha_disponible, fecha_embarque, estado, asignacion, nom_subprod) values(";
		$Insertar.= "'".$Fila["corr_codelco"]."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','".$Fila["cod_cliente"]."','".$Fila["fecha_disponible"]."', '".$Fila["fecha_disponible"]."', '".$Fila["estado2"]."', '".$Fila["cod_contrato_maquila"]."', '".$Fila["abreviatura"]."')";
		/*if ($Fila["corr_codelco"]=='9061')
		
			echo $Insertar;*/
		mysqli_query($link, $Insertar);
	}
	//aqui poner un SELECT para 18 y otros  *******if ($CodProducto == '18')
	
		$Consulta = "SELECT t0.corr_enm, t0.fecha_embarque, t0.fecha_disponible, count(*) as num_paquetes, sum(t2.num_unidades) as unidades, ";
		$Consulta.= " t0.cod_cliente, ifnull(sum(t2.peso_paquetes),0) as peso, t3.descripcion, t0.estado, t0.asignacion, t0.nom_subprod ";
		$Consulta.= " from sec_web.tmp_orden t0 left join sec_web.lote_catodo t1 on t0.corr_enm=t1.corr_enm";
		$Consulta.= " left join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete and t1.fecha_creacion_paquete=t2.fecha_creacion_paquete ";
		$Consulta.= " left join sec_web.marca_catodos t3 on t1.cod_marca=t3.cod_marca ";
		//$Consulta.= " inner join proyecto_modernizacion.subproducto t4 on t2.cod_producto=t4.cod_producto and t2.cod_subproducto=t4.cod_subproducto ";
 		$Consulta.= " where t0.corr_enm <80000 and t0.estado<>'A' and t0.fecha_embarque between '".$FechaInicio."' and '".$FechaTermino."' ";
	
		$Consulta.= " and year(t1.fecha_creacion_lote)  >= '".$FechaControl."'";
		
	
	
	if ($CodProducto!="S")
		$Consulta.= " and  t0.cod_producto='".$CodProducto."' ";
	if ($SubProducto!="S")
		$Consulta.= " and  t0.cod_subproducto='".$SubProducto."' ";
	$Consulta.= " group by t0.corr_enm ";
	switch ($Orden)
	{
		case "Or_01":
			$Consulta.= "order by t0.corr_enm";
			break;
		case "Or_02":
			$Consulta.= "order by t0.fecha_disponible, t0.corr_enm ";
			break;
		case "Or_03":
			$Consulta.= "order by t0.fecha_embarque, t0.corr_enm ";
			break;
		case "Or_04":
			$Consulta.= "order by t0.nom_subprod, t0.fecha_embarque, t0.corr_enm ";
			break;
		case "Or_05":
			$Consulta.= "order by t0.asignacion, t0.corr_enm ";
			break;
	}


	//echo "RR".$Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPesoBr = 0;
	$TotalPeso = 0;
	$TotalPaquetes = 0;
	$TotalUnidades = 0;
	$MaqAnt=""; 
	//echo $Consulta."<br>";
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		//CONSULTA ASIGNACION Y FECHA DISPONIBILIDAD		
		$Asignacion="";
		$FechaDisp = "";
		$FechaEmb = "";	
		$Consulta = "SELECT * from sec_web.programa_codelco t1 inner join ";
		$Consulta.= " proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
		$Consulta.= " where t1.corr_codelco='".$Fila["corr_enm"]."'";
		//echo $Consulta;
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$Asignacion= $FilaAux["cod_contrato_maquila"];
			$NomSubProducto=$FilaAux["abreviatura"];
			//$FechaDisp = $FilaAux["fecha_disponible"];
		}
		else
		{
			$Consulta = "SELECT * from sec_web.programa_enami t1 inner join proyecto_modernizacion.subproducto t2 ";
			$Consulta.= " on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta.= " where t1.corr_enm='".$Fila["corr_enm"]."'";
			$RespAux = mysqli_query($link, $Consulta);
			if ($FilaAux=mysqli_fetch_array($RespAux))
			{
				$Asignacion="MAQ ENM";
				$NomSubProducto=$FilaAux["abreviatura"];
				//$FechaDisp = $FilaAux["fecha_disponible"];
			}
		}		
		$ClienteNave = "";
		$Contrato    = $FilaAux["cod_contrato"];
		$Cuota		 = $FilaAux["mes_cuota"];
		$Partida	 = $FilaAux["partida"];
		$ClienteNave = $Contrato."/".$Cuota."/".$Partida;
				 		
		$FechaEmb = $Fila["fecha_embarque"];	
		$FechaDisp = $Fila["fecha_disponible"];
		if ($Fila["peso"]=="0")
		{
			$Paquetes=0;
			$Unidades=0;
		}
		else
		{
			$Paquetes=$Fila["num_paquetes"];
			$Unidades=$Fila["unidades"];
		}
		//-------------------------
		if ($MaqAnt != $Fila["asignacion"] && $MaqAnt!="" && $Orden=="Or_05")
		{	
			echo "<tr class=\"Detalle02\">\n";
			echo "<td align=\"center\" colspan=\"4\"><b>TOTAL&nbsp;&nbsp;".strtoupper($MaqAnt)."</b></td>\n";
			echo "<td align=\"right\">".number_format($TotalAsigPaquetes,0,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($TotalAsigUnidades,0,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($TotalAsigPeso,0,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format(($TotalAsigPeso+$TotalAsigPaquetes),0,",",".")."</td>\n";
			echo "<td>&nbsp;</td>\n";		
			echo "<td>&nbsp;</td>\n";		
			echo "<td align=\"center\">&nbsp;</td>\n";
			echo "<td align='center'>&nbsp;</td>\n";	
			echo "</tr>\n";
			$TotalAsigPesoBr = 0;
			$TotalAsigPeso = 0;
			$TotalAsigPaquetes = 0;
			$TotalAsigUnidades = 0;
		}
		//CONSULTA SI YA FUE TRASPASADO A SAP
		$LoteCons=substr($AnoIni,2,2).str_pad($MesIni,2,"0",STR_PAD_LEFT).$Fila["corr_enm"];
		//echo $LoteCons." ".$Fila["corr_enm"]."<br>";
		$Consulta = "SELECT * from interfaces_codelco.registro_traspaso ";
		$Consulta.= " where (referencia='".$LoteCons."' )";// or referencia='".$Fila["corr_enm"]."') ";
		$Consulta.= " and tipo_movimiento='921'";
		$RespSap=mysqli_query($link, $Consulta);
		$Traspasado=false;
		if ($FilaSap=mysqli_fetch_array($RespSap))
		{
			/*echo substr($FilaSap["registro"],44,18)."<br>";
			if (intval(substr($FilaSap["registro"],44,18))==3)*/
				$Traspasado=true; 
		}
		//-----------------------------------		
		if ($Traspasado==true)
			echo "<tr class=\"Detalle01\">\n";
		else
			echo "<tr bgcolor=\"white\">\n";
		echo "<td align='center'>";
		$Consulta = "SELECT * from sec_web.embarque_ventana where corr_enm='".$Fila["corr_enm"]."'";
		$RespAux=mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
			echo "<font class=\"LinksAzulRaya\">".$Fila["corr_enm"]."</font>";
		else
			echo $Fila["corr_enm"];
		echo "</td>\n";
		echo "<td align=\"center\">".strtoupper($Asignacion)."&nbsp;</td>\n";
		echo "<td>".strtoupper($NomSubProducto)."&nbsp;</td>\n";	
		echo "<td>".strtoupper($Fila["descripcion"])."&nbsp;</td>\n";						
		echo "<td align=\"right\">".number_format($Paquetes,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format($Unidades,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format($Fila["peso"],0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format(($Fila["peso"]+$Paquetes),0,",",".")."</td>\n";
		echo "<td>".substr($FechaDisp,8,2)."/".substr($FechaDisp,5,2)."/".substr($FechaDisp,2,2)."</td>\n";		
		echo "<td>".substr($FechaEmb,8,2)."/".substr($FechaEmb,5,2)."/".substr($FechaEmb,2,2)."</td>\n";		
		echo "<td align=\"center\">".strtoupper($ClienteNave)."</td>\n";
		if ($Fila["estado"]=="")
			echo "<td align=\"center\">&nbsp;</td>\n";	
		else
			echo "<td align=\"center\">".strtoupper($Fila["estado"])."</td>\n";	
		if ($Traspasado)
			echo "<td align=\"center\">SI</td>\n";
		else
			echo "<td align=\"center\">NO</td>\n";
		//BUSCA EL SUBPRODUCTO CUANDO SE A PESADO	
		$Consulta="SELECT distinct t3.abreviatura as nom_subproducto from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete and t1.fecha_creacion_paquete=t2.fecha_creacion_paquete ";
		$Consulta.="left join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
		$Consulta.="where corr_enm='".$Fila["corr_enm"]."'";
		$RespSubProd=mysqli_query($link, $Consulta);
		if($FilaSubProd=mysqli_fetch_array($RespSubProd))
			echo "<td align=\"center\">".$FilaSubProd[nom_subproducto]."</td>\n";	
		else
			echo "<td align=\"center\">&nbsp;</td>\n";	
		echo "</tr>\n";
		$TotalPesoBr = $TotalPesoBr + ($Fila["peso"]+$Fila["num_paquetes"]);
		$TotalPeso = $TotalPeso + $Fila["peso"];
		$TotalPaquetes = $TotalPaquetes + $Fila["num_paquetes"];
		$TotalUnidades = $TotalUnidades + $Fila["unidades"];
		//TOTALES ASIGANCION
		$TotalAsigPesoBr = $TotalAsigPesoBr + ($Fila["peso"]+$Fila["num_paquetes"]);
		$TotalAsigPeso = $TotalAsigPeso + $Fila["peso"];
		$TotalAsigPaquetes = $TotalAsigPaquetes + $Fila["num_paquetes"];
		$TotalAsigUnidades = $TotalAsigUnidades + $Fila["unidades"];
		//-----------------------------------------------------
		$MaqAnt=$Fila["asignacion"]; 
	}
	if ($MaqAnt != $Fila["asignacion"] && $MaqAnt!="" && $Orden=="Or_05")
	{	
		echo "<tr class=\"Detalle02\">\n";
		echo "<td align=\"center\" colspan=\"4\"><b>TOTAL&nbsp;&nbsp;".strtoupper($MaqAnt)."</b></td>\n";
		echo "<td align=\"right\">".number_format($TotalAsigPaquetes,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format($TotalAsigUnidades,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format($TotalAsigPeso,0,",",".")."</td>\n";
		echo "<td align=\"right\">".number_format(($TotalAsigPeso+$TotalAsigPaquetes),0,",",".")."</td>\n";
		echo "<td>&nbsp;</td>\n";		
		echo "<td>&nbsp;</td>\n";		
		echo "<td align=\"center\">&nbsp;</td>\n";
		echo "<td align='center'>&nbsp;</td>\n";	
		echo "</tr>\n";
		$TotalAsigPesoBr = 0;
		$TotalAsigPeso = 0;
		$TotalAsigPaquetes = 0;
		$TotalAsigUnidades = 0;
	}
	/*$BorrarTmp="drop table sec_web.tmp_orden";
	mysqli_query($link, $BorrarTmp);*/
?>
    <tr class="ColorTabla02"> 
      <td colspan="4" align="left"><strong>TOTALES</strong></td>
      <td align="right"><strong><?php echo number_format($TotalPaquetes,0,",","."); ?></strong></td>
      <td align="right"><strong><?php echo number_format($TotalUnidades,0,",","."); ?></strong></td>
      <td align="right"><strong><?php echo number_format($TotalPeso,0,",","."); ?></strong></td>
	  <td align="right"><strong><?php echo number_format($TotalPesoBr,0,",","."); ?></strong></td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td colspan="4" align="right">&nbsp;</td>
    </tr>
  </table>  
  <br>
</form>
</body>
</html>
<?php include("../principal/cerrar_ram_web.php") ?>
