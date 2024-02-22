<?php
	include("../principal/conectar_principal.php");
	$Fecha=date('Y-m-d h:i:s');
	switch ($Proceso)
	{
		case "G"://CERRAR MES INDIVIDUAL
			$Actualizar="UPDATE age_web.lotes set fecha_cierre_op='$Fecha',canjeable='$OptCanje',estado_lote='4' ";//4 CIERRE OPERACIONAL
			$Actualizar.="where lote='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			header("location:age_adm_cierre_lote.php?TxtLote=".$TxtLote."&TxtEsPopup=".$TxtEsPopup);
			break;
		case "GC"://GRABAR CANJE(CON O SIN CANJE)
			$Actualizar="UPDATE age_web.lotes set canjeable='$OptCanje' ";
			$Actualizar.="where lote='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			header("location:age_adm_cierre_lote.php?TxtLote=".$TxtLote."&TxtEsPopup=".$TxtEsPopup);
			break;
		case "M"://CERRAR MES MASIVO
			$Datos=explode('//',$Valores);
			while(list($c,$v)=each($Datos))
			{
				$Actualizar="UPDATE age_web.lotes set  fecha_cierre_op='$Fecha',estado_lote='4' ";//4 CIERRE OPERACIONAL
				$Actualizar.="where lote='".$v."'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar;
			}
			if($Opt=='C')
			{
				$Chequeado1='checked';
				$Chequeado2='';
			}	
			else
			{	
				$Chequeado1='';
				$Chequeado2='checked';
			}
			if($TxtLoteIni=='')
				$TipoBusqueda='BM';
			else
				$TipoBusqueda='BL';
			header("location:age_adm_cierre_lote_masivo.php?Recarga=S&Buscar=S&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Chequeado1=".$Chequeado1."&Chequeado2=".$Chequeado2."&TipoBusqueda=".$TipoBusqueda."&TxtLoteIni=".$TxtLoteIni."&TxtLoteFin=".$TxtLoteFin);
			break;	
		case "MC"://GRABAR CANJE(CON O SIN CANJE)
			$Datos=explode('//',$Valores);
			while(list($c,$v)=each($Datos))
			{
				$Actualizar="UPDATE age_web.lotes set canjeable='$OptCanje' ";
				$Actualizar.="where lote='".$v."'";
				mysqli_query($link, $Actualizar);
			}	
			if($Opt=='C')
			{
				$Chequeado1='checked';
				$Chequeado2='';
			}	
			else
			{	
				$Chequeado1='';
				$Chequeado2='checked';
			}
			if($TxtLoteIni=='')
				$TipoBusqueda='BM';
			else
				$TipoBusqueda='BL';
			header("location:age_adm_cierre_lote_masivo.php?Recarga=S&Buscar=S&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Chequeado1=".$Chequeado1."&Chequeado2=".$Chequeado2."&TipoBusqueda=".$TipoBusqueda."&TxtLoteIni=".$TxtLoteIni."&TxtLoteFin=".$TxtLoteFin);
			break;
		case "ELI"://ELIMINMAR LOTES ERRRONEOS SIN SA
			$Eliminar="delete from age_web.lotes where lote = '".$Lote."' ";
			//echo $Eliminar;
			mysqli_query($link, $Eliminar);
			if($Opt=='C')
			{
				$Chequeado1='checked';
				$Chequeado2='';
			}	
			else
			{	
				$Chequeado1='';
				$Chequeado2='checked';
			}
			if($TxtLoteIni=='')
				$TipoBusqueda='BM';
			else
				$TipoBusqueda='BL';
			header("location:age_adm_cierre_lote_masivo.php?Recarga=S&Buscar=S&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&Chequeado1=".$Chequeado1."&Chequeado2=".$Chequeado2."&TipoBusqueda=".$TipoBusqueda."&TxtLoteIni=".$TxtLoteIni."&TxtLoteFin=".$TxtLoteFin);
			break;

	}
?>