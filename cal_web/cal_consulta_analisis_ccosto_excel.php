<?php   
		ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
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

	//Frm.action= "cal_consulta_analisis_ccosto_excel.php?Buscar=S&LimitIni="+LimitIni+"&LimitFin="+LimitFin;
	/*$Buscar = $_REQUEST["Buscar"];
	$LimitIni = $_REQUEST["LimitIni"];
	$LimitFin = $_REQUEST["LimitFin"];
	$CmbAno = $_REQUEST["CmbAno"];
	$CmbMes = $_REQUEST["CmbMes"];
	$CmbDias = $_REQUEST["CmbDias"];
	$CmbAnoT = $_REQUEST["CmbAnoT"];
	$CmbMesT = $_REQUEST["CmbMesT"];
	$CmbDiasT = $_REQUEST["CmbDiasT"];
	$CmbCCosto = $_REQUEST["CmbCCosto"];*/

	if(isset($_REQUEST["Buscar"])) {
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar =  "";
	}
	if(isset($_REQUEST["Limite"])) {
		$Limite = $_REQUEST["Limite"];
	}else{
		$Limite =  "";
	}
	if(isset($_REQUEST["CmbCCosto"])) {
		$CmbCCosto = $_REQUEST["CmbCCosto"];
	}else{
		$CmbCCosto =  "";
	}
	if(isset($_REQUEST["CmbAno"])) {
		$CmbAno = $_REQUEST["CmbAno"];
	}else{
		$CmbAno =  date("Y");
	}
	if(isset($_REQUEST["CmbMes"])) {
		$CmbMes = $_REQUEST["CmbMes"];
	}else{
		$CmbMes = date("m");
	}
	if(isset($_REQUEST["CmbDias"])) {
		$CmbDias = $_REQUEST["CmbDias"];
	}else{
		$CmbDias =  date("d");
	}
	if(isset($_REQUEST["CmbAnoT"])) {
		$CmbAnoT = $_REQUEST["CmbAnoT"];
	}else{
		$CmbAnoT =  date("Y");
	}
	if(isset($_REQUEST["CmbMesT"])) {
		$CmbMesT = $_REQUEST["CmbMesT"];
	}else{
		$CmbMesT = date("m");
	}
	if(isset($_REQUEST["CmbDiasT"])) {
		$CmbDiasT = $_REQUEST["CmbDiasT"];
	}else{
		$CmbDiasT =  date("d");
	}
	
	if(isset($_REQUEST["LimitIni"])) {
		$LimitIni = $_REQUEST["LimitIni"];
		//$LimitIni=$Limite;
	}else{
		$LimitIni =  0;
	}
	if(isset($_REQUEST["LimitFin"])) {
		$LimitFin = $_REQUEST["LimitFin"];
	}else{
		$LimitFin =  99;
	}

?>
<html>
<head>
<title>Consulta General Excel</title>
</head>
<body>
<?php
	if ($Buscar=='S')
	{
		$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
		$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
		if ($CmbCCosto=="-1")
		{
			$CodCCosto=" and ";
		}
		else
		{
			$CodCCosto="and t1.cod_ccosto ='".$CmbCCosto."' and ";				
		}
		$CentroCosto='(';
		$Consulta="select distinct t1.cod_ccosto,t3.descripcion,count(t1.nro_solicitud) as total ";
		if($CmbAno<2009 && $CmbAno>0)
			$Consulta.=" from cal_histo.solicitud_analisis_a_".$CmbAno." t1 ";
			else
			$Consulta.=" from cal_web.solicitud_analisis t1 ";
		$Consulta.=" inner join proyecto_modernizacion.centro_costo t3 on t1.cod_ccosto=t3.centro_costo ";
		$Consulta.=" where not isnull(t1.cod_ccosto) ".$CodCCosto." t1.fecha_hora between '".$FechaI."' and '".$FechaT."' group by t1.cod_ccosto LIMIT ".$LimitIni.", ".$LimitFin;
		$Respuesta=mysqli_query($link, $Consulta);
		$Encontro=false;
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			$Encontro=true;
			$CentroCosto=$CentroCosto." t1.cod_ccosto='".$Fila["cod_ccosto"]."' or ";	
		}
		if ($Encontro==true)
		{
			$CentroCosto=substr($CentroCosto,0,strlen($CentroCosto)-3).")";	
			$Consulta="select distinct t2.cod_leyes,t3.abreviatura ";
			if($CmbAno<2009 && $CmbAno>0)
				$Consulta.=" from cal_histo.solicitud_analisis_a_".$CmbAno." t1 inner join cal_histo.leyes_por_solicitud_a_".$CmbAno." t2 on ";
				else
				$Consulta.=" from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on ";
			$Consulta.=" t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo";
			$Consulta.=" inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes=t3.cod_leyes ";
			$Consulta.=" where ".$CentroCosto." and (t1.fecha_hora between '".$FechaI."' and '".$FechaT."') group by t1.cod_ccosto,t2.cod_leyes order by t1.cod_ccosto,t2.cod_leyes";
			$Respuesta=mysqli_query($link, $Consulta);
			$Arreglo=array();
			$ArregloTot=array();		
			while($Fila1=mysqli_fetch_array($Respuesta))
			{
				$Arreglo[$Fila1["cod_Leyes"]][0]=$Fila1["abreviatura"];
				$Arreglo[$Fila1["cod_leyes"]][1]=$Fila1["abreviatura"];
				$Arreglo[$Fila1["cod_leyes"]][2]="";
				$Arreglo[$Fila1["cod_leyes"]][3]="";
				$AnchoTabla=$AnchoTabla	+ 50;
				$Cont=$Cont+1;	
			}
			$AnchoTabla=$AnchoTabla	+ 600;	
			if (count($Arreglo))
			{				
				echo "<table width='$AnchoTabla' border='0' cellpadding='3' cellspacing='0' class='ColorTabla01'>";
				echo "<tr align='center'>";
				echo "<td width='270'>C.Costo</td>";
				echo "<td width='50' align='center'>Total S.A</td>";
				reset($Arreglo);
				ksort($Arreglo);
				//while(list($Clave,$Valor)=each($Arreglo))
				foreach ($Arreglo as $Clave => $Valor)
				{
					echo "<td width='50' align='center'>";
					if ($Valor[1]!='')
					{
						echo $Valor[1];
					}
					else
					{
						echo "&nbsp;";
					}	
					echo "</td>";
				}
				reset($ArregloTot);
				//while(list($Clave,$Valor)=each($ArregloTot))
				foreach ($ArregloTot as $Clave => $Valor)
				{
					$ArregloTot[$Clave][0]=0;
				}
				echo "<td width='50'>TOTAL</td>";
				echo "</tr>";
				echo "</table>";
				echo "<table width='$AnchoTabla' border='1'>";
				$ConsultaLimit="select count(distinct t1.cod_ccosto) as total_registros from ";
				if($CmbAno<2009 && $CmbAno>0)
					 $ConsultaLimit.=" cal_histo.solicitud_analisis_a_".$CmbAno." t1 ";
					 $ConsultaLimit.=" cal_web.solicitud_analisis t1 ";
				$ConsultaLimit.=" inner join proyecto_modernizacion.centro_costo t3 on t1.cod_ccosto=t3.centro_costo ";
				$ConsultaLimit.=" where not isnull(t1.cod_ccosto) ".$CodCCosto." t1.fecha_hora between '".$FechaI."' and '".$FechaT."'";
				$Consulta="select distinct t1.cod_ccosto,t3.descripcion,count(t1.nro_solicitud) as total ";
				if($CmbAno<2009 && $CmbAno>0)
					$Consulta.=" from cal_histo.solicitud_analisis_a_".$CmbAno." t1 ";
					else
					$Consulta.=" from cal_web.solicitud_analisis t1 ";
				$Consulta=$Consulta." inner join proyecto_modernizacion.centro_costo t3 on t1.cod_ccosto=t3.centro_costo ";
				$Consulta=$Consulta." where not isnull(t1.cod_ccosto) ".$CodCCosto." t1.fecha_hora between '".$FechaI."' and '".$FechaT."' group by t1.cod_ccosto LIMIT ".$LimitIni.", ".$LimitFin;
				$Respuesta2=mysqli_query($link, $Consulta);
				$TotGeneral=0;
				$TotSA=0;
				while ($Fila=mysqli_fetch_array($Respuesta2))
				{
					$CantLeyesCCosto=0;
					echo "<tr>";
					echo "<td width='250' align='left'>".$Fila["cod_ccosto"]."-".$Fila["descripcion"]."</td>";
					echo "<td width='50'align='right' class='detalle01'>".$Fila["total"]."</td>";
					$TotSA=$TotSA+$Fila["total"];
					$Consulta = "select t2.cod_leyes,count(t2.cod_leyes)as total ";
					if($CmbAno<2009 && $CmbAno>0)
						$Consulta.= " from cal_histo.solicitud_analisis_a_".$CmbAno." t1 inner join cal_histo.leyes_por_solicitud_a_".$CmbAno." t2 on ";
						else
						$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on ";
					$Consulta.= " t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo";
					$Consulta.= " where t1.cod_ccosto='".$Fila["cod_ccosto"]."' ";
					$Consulta.= " and t1.fecha_hora between '".$FechaI."' and '".$FechaT."' ";
					$Consulta.= " group by t2.cod_leyes";
					$Respuesta3=mysqli_query($link, $Consulta);							
					//echo $Consulta."<br>";
					$Respuesta3=mysqli_query($link, $Consulta);
					reset($Arreglo);
					//while(list($Clave,$Valor)=each($Arreglo))
					foreach ($Arreglo as $Clave => $Valor)
					{
						$Arreglo[$Clave][1]="&nbsp;";
						$Arreglo[$Clave][3]="&nbsp;";				
					}
					while($FilaLeyes=mysqli_fetch_array($Respuesta3))
					{
						$Arreglo[$FilaLeyes["cod_leyes"]][2]=$FilaLeyes["total"];
						$Arreglo[$FilaLeyes["cod_leyes"]][3]=$FilaLeyes["total"];
						$ArregloTot[$FilaLeyes["cod_leyes"]][0]=$ArregloTot[$FilaLeyes["cod_leyes"]][0] + $FilaLeyes["total"];
						$CantLeyesCCosto=$CantLeyesCCosto+$FilaLeyes["total"];
						$TotGeneral=$TotGeneral+$FilaLeyes["total"];
					}	
					reset($Arreglo);
					ksort($Arreglo);
					//while(list($Clave,$Valor)=each($Arreglo))
					foreach ($Arreglo as $Clave => $Valor)
					{
						echo "<td width='50' align='center'>";
						echo $Valor[3];
						echo "</td>";
					}
					echo "<td width='50' align='right' class='detalle01'>".$CantLeyesCCosto."</td>";
					echo "</tr>";
				}
				echo "<tr class='detalle01'>";
				echo "<td width='250'>TOTAL</td>";
				echo "<td width='50' align='right'>".$TotSA."</td>";
				echo "<td width='50'>&nbsp;</td>";
				reset($ArregloTot);
				ksort($ArregloTot);
				//while(list($Clave,$Valor)=each($ArregloTot))
				foreach ($ArregloTot as $Clave => $Valor)
				{
					echo "<td width='50' align='center'>";
					echo $Valor[0];
					echo "</td>";
				}
				echo "<td width='50' align='right'>".$TotGeneral."</td>";
				echo "</tr>";
				echo "</table>";
			}	
		}	
	}	
	?>
</body>
</html>
