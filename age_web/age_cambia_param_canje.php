<?php 	
	include("../principal/conectar_principal.php");	
	$Consulta = "Select valor_subclase1 as orden from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='1'";
	$Rsp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Rsp))
	{
		$TxtOrden = $Fila[orden];
	}
	$Consulta1 = "Select valor_subclase1 as nombre from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='2'";
	$Rsp1 = mysqli_query($link, $Consulta1);
	if ($Fila1 = mysqli_fetch_array($Rsp1))
	{
		$TxtNombre = $Fila1["NOMBRE"];
	}
	$Consulta2 = "Select valor_subclase1 as fechac from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='3'";
	$Rsp2 = mysqli_query($link, $Consulta2);
	if ($Fila2 = mysqli_fetch_array($Rsp2))
	{
		$TxtFechaCanje = $Fila2[fechac];
	}
	$Consulta3 = "Select valor_subclase1 as fechasol from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='4'";
	$Rsp3 = mysqli_query($link, $Consulta3);
	if ($Fila3 = mysqli_fetch_array($Rsp3))
	{
		$TxtFechaSolicitud = $Fila3[fechasol];
	}
	$Datos=explode('//',$Valores);
	while(list($c,$v)=each($Datos))
	{
			
		$Lote = $v;
		if ($Lote!="")
		{
			$Consultar = "Select * from age_web.lotes where lote = '".$Lote."'";
			//echo "uno".$Consultar."</br>";
			$Resp = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Resp))
			{
				$Actualiza = "Update age_web.lotes set fecha_canje = '".$TxtFechaCanje."',orden_ensaye = '".$TxtOrden."',";
				$Actualiza.=" fecha_sol_pqts = '".$TxtFechaSolicitud."', laboratorio_externo = '".$TxtNombre."' where lote = '".$Lote."'";
				//echo "dos".$Actualiza."</br>";
				mysqli_query($link, $Actualiza);
			}
		}
		 
	}	
	//echo $VTipo."--".$VParam1."--".$VParam2;
	switch($Tipo)
	{
		case "BL":
			header("location:age_con_resultados_pqts_arbitrales_res.php?&Recarga=S&TipoBusqueda=BL&Buscar=S&TxtLoteIni=".$Param1."&TxtLoteFin=".$Param2);
		break;
		case "BOE":
			header("location:age_con_resultados_pqts_arbitrales_res.php?Recarga=S&TipoBusqueda=BOE&Buscar=S&TxtOrdenEnsaye=".$Param1);
		break;
		case "BM":
			if (strlen($Param1)==1)
				$Param1= "0".$Param1;
			header("location:age_con_resultados_pqts_arbitrales_res.php?Recarga=S&TipoBusqueda=BM&Buscar=S&CmbMes=".$Param1."&CmbAno=".$Param2);
		break;
	}
?>
