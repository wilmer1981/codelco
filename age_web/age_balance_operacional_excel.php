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
	include("age_funciones.php");	
?>
<html>
<head>
<title>Sistema de Agencia</title>
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form name="FrmPrincipal" action="" method="post">
      <table width="1000" border="1" align="center">
        <tr align="center">
		<td rowspan="2">&nbsp;</td>
		<td colspan="3">Leyes(Pqte1)</td>
		<td colspan="3">Leyes Provisionales/Canje</td>
		<td colspan="2">Pesos(Kg)</td>
		<td colspan="3">Fino/Ajuste</td>
		</tr>
		<tr align="center">
		  <td width="60">Cu(%)</td>
		  <td width="60">Ag(g/t)</td>
		  <td width="60">Au(g/t)</td>
		  <td width="60">Cu(%)</td>
		  <td width="60">Ag(g/t)</td>
		  <td width="60">Au(g/t)</td>
		  <td width="60">Hum.</td>
		  <td width="60">Seco</td>
		  <td width="60">Cu(Kg)</td>
		  <td width="60">Ag(Gr)</td>
		  <td width="60">Au(Gr)</td>
        </tr>
        <?php
		if($Mes=='1')
		{
			$MesAux='12';
			$AnoAux=$Ano-1;
		}
		else
		{
			$MesAux=$Mes-1;
			$AnoAux=$Ano;
		}
		$FechaIniMesAnt = $AnoAux."-".$MesAux."-01";
		$FechaFinMesAnt = $AnoAux."-".$MesAux."-31";
		$FechaIni = $Ano."-".$Mes."-01";
		$FechaFin = $Ano."-".$Mes."-31";
		$AnoMes=substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT);
		if ($Mostrar=="S")
		{ 		
			$TotalPesoHumFinal=0;$TotalPesoSecoFinal=0;$TotalAjusteCuFinal=0;$TotalAjusteAgFinal=0;$TotalAjusteAuFinal=0;
			$Consulta="select t1.cod_producto,t1.cod_subproducto,t2.descripcion as nom_subprod from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 ";
			$Consulta.="on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta.="where t1.cod_producto='1' ";
			if($SubProducto!='S')
				 $Consulta.="and t1.cod_subproducto='".$SubProducto."'";
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
			$Consulta.="group by t1.cod_producto,t1.cod_subproducto";
			$RespProd=mysqli_query($link, $Consulta);
			while($FilaProd=mysqli_fetch_array($RespProd))
			{
				$ArrayFinalPrv=array();
				$SubTotalPesoHumProd=0;$SubTotalPesoSecoProd=0;$SubTotalAjusteCuProd=0;$SubTotalAjusteAgProd=0;$SubTotalAjusteAuProd=0;
				$SubTotalPesoHumProv0;$SubTotalPesoSecoProv=0;$SubTotalAjusteCuProv=0;$SubTotalAjusteAgProv=0;$SubTotalAjusteAuProv=0;
				$Consulta="select distinct t1.rut_proveedor,t2.NOMPRV_A as nom_prv from age_web.lotes t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A ";				
				$Consulta.="where t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
				$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
				$Consulta.= "order by t2.NOMPRV_A ";
				//echo $Consulta."<br>";
				$RespProv = mysqli_query($link, $Consulta);
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$SubTotalPesoHumProv=0;$SubTotalPesoSecoProv=0;$SubTotalAjusteCuProv=0;$SubTotalAjusteAgProv=0;$SubTotalAjusteAuProv=0;
					//PROVISIONALES MES ANTERIOR
					$Consulta="select distinct t1.lote from age_web.lotes t1 inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional = 'S' ";				
					$Consulta.="where t1.estado_lote <>'6' and t1.rut_proveedor ='".$FilaProv["rut_proveedor"]."' and t1.fecha_recepcion between '$FechaIniMesAnt' and '$FechaFinMesAnt' ";
					$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
					//echo $Consulta."<br>";
					$RespLotes = mysqli_query($link, $Consulta);
					$EncontroDatos=false;
					$Cu_Fino_Ajuste=0;$Ag_Fino_Ajuste=0;$Au_Fino_Ajuste=0;$Cu_Fino_Pqt1=0;$Ag_Fino_Pqt1=0;$Au_Fino_Pqt1=0;$Cu_Fino_Ajus=0;$Ag_Fino_Ajus=0;$Au_Fino_Ajus=0;$PesoHumProv=0;$PesoSecoProv=0;
					while ($FilaLote=mysqli_fetch_array($RespLotes))
					{
						$EncontroDatos=true;
						$DatosLote= array();
						$ArrLeyes=array();
						$DatosLote["lote"]=$FilaLote["lote"];
						LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
						$Cu_Fino_Ajuste=$Cu_Fino_Ajuste+(($ArrLeyes["02"][2]-$ArrLeyes["02"][7])*$DatosLote["peso_seco"])/100;
						$Cu_Fino_Pqt1=$Cu_Fino_Pqt1+($ArrLeyes["02"][2]*$DatosLote["peso_seco"])/100;
						$Cu_Fino_Ajus=$Cu_Fino_Ajus+($ArrLeyes["02"][7]*$DatosLote["peso_seco"])/100;
						$Ag_Fino_Ajuste=$Ag_Fino_Ajuste+(($ArrLeyes["04"][2]-$ArrLeyes["04"][7])*$DatosLote["peso_seco"])/1000;
						$Ag_Fino_Pqt1=$Ag_Fino_Pqt1+($ArrLeyes["04"][2]*$DatosLote["peso_seco"])/1000;
						$Ag_Fino_Ajus=$Ag_Fino_Ajus+($ArrLeyes["04"][7]*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Ajuste=$Au_Fino_Ajuste+(($ArrLeyes["05"][2]-$ArrLeyes["05"][7])*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Pqt1=$Au_Fino_Pqt1+($ArrLeyes["05"][2]*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Ajus=$Au_Fino_Ajus+($ArrLeyes["05"][7]*$DatosLote["peso_seco"])/1000;
						$PesoHumProv=$PesoHumProv+$DatosLote["peso_humedo"];
						$PesoSecoProv=$PesoSecoProv+$DatosLote["peso_seco"];
					}
					echo "<tr>\n";
					echo "<td>PROVISIONALES MES ANTERIOR</td>\n";		
					if($EncontroDatos==true)
					{
						echo "<td align='center'>".number_format(($Cu_Fino_Pqt1*100)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format(($Ag_Fino_Pqt1*1000)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format(($Au_Fino_Pqt1*1000)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format(($Cu_Fino_Ajus*100)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format(($Ag_Fino_Ajus*1000)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format(($Au_Fino_Ajus*1000)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($PesoHumProv,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($PesoSecoProv,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($Cu_Fino_Ajuste,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($Ag_Fino_Ajuste,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($Au_Fino_Ajuste,0,'','.')."</td>\n";
						
					}
					else
					{
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
					}
					echo "</tr>\n";	
					$SubTotalPesoHumProv=$SubTotalPesoHumProv+$PesoHumProv;
					$SubTotalPesoSecoProv=$SubTotalPesoSecoProv+$PesoSecoProv;
					$SubTotalAjusteCuProv=$SubTotalAjusteCuProv+$Cu_Fino_Ajuste;
					$SubTotalAjusteAgProv=$SubTotalAjusteAgProv+$Ag_Fino_Ajuste;
					$SubTotalAjusteAuProv=$SubTotalAjusteAuProv+$Au_Fino_Ajuste;
					//PAQUETE PRIMERO
					$Consulta="select distinct t1.lote from age_web.lotes t1 left join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional <> 'S' ";				
					$Consulta.="where t1.estado_lote <>'6' and t1.rut_proveedor ='".$FilaProv["rut_proveedor"]."' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
					$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
					//echo $Consulta."<br>";
					$EncontroDatos=false;
					$RespLotes = mysqli_query($link, $Consulta);
					$Cu_Fino_Ajuste=0;$Ag_Fino_Ajuste=0;$Au_Fino_Ajuste=0;$Cu_Fino_Pqt1=0;$Ag_Fino_Pqt1=0;$Au_Fino_Pqt1=0;$Cu_Fino_Ajus=0;$Ag_Fino_Ajus=0;$Au_Fino_Ajus=0;$PesoHumProv=0;$PesoSecoProv=0;
					while ($FilaLote=mysqli_fetch_array($RespLotes))
					{
						$EncontroDatos=true;
						$DatosLote= array();
						$ArrLeyes=array();
						$DatosLote["lote"]=$FilaLote["lote"];
						LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
						$Cu_Fino_Ajuste=$Cu_Fino_Ajuste+($ArrLeyes["02"][2]*$DatosLote["peso_seco"])/100;
						$Cu_Fino_Pqt1=$Cu_Fino_Pqt1+($ArrLeyes["02"][2]*$DatosLote["peso_seco"])/100;
						$Cu_Fino_Ajus='-';
						$Ag_Fino_Ajuste=$Ag_Fino_Ajuste+($ArrLeyes["04"][2]*$DatosLote["peso_seco"])/1000;
						$Ag_Fino_Pqt1=$Ag_Fino_Pqt1+($ArrLeyes["04"][2]*$DatosLote["peso_seco"])/1000;
						$Ag_Fino_Ajus='-';
						$Au_Fino_Ajuste=$Au_Fino_Ajuste+($ArrLeyes["05"][2]*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Pqt1=$Au_Fino_Pqt1+($ArrLeyes["05"][2]*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Ajus='-';
						$PesoHumProv=$PesoHumProv+$DatosLote["peso_humedo"];
						$PesoSecoProv=$PesoSecoProv+$DatosLote["peso_seco"];
					}
					echo "<tr>\n";
					echo "<td>PAQUETE PRIMERO</td>\n";	
					if($EncontroDatos==true)
					{
						echo "<td align='center'>".number_format(($Cu_Fino_Pqt1*100)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format(($Ag_Fino_Pqt1*1000)/$PesoSecoProv,3,',','.')."</td>\n";
						echo "<td align='center'>".number_format(($Au_Fino_Pqt1*1000)/$PesoSecoProv,3,',','.')."</td>\n";
						echo "<td align='center'>".$Cu_Fino_Ajus."</td>\n";
						echo "<td align='center'>".$Ag_Fino_Ajus."</td>\n";
						echo "<td align='center'>".$Au_Fino_Ajus."</td>\n";
						echo "<td align='center'>".number_format($PesoHumProv,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($PesoSecoProv,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($Cu_Fino_Ajuste,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($Ag_Fino_Ajuste,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($Au_Fino_Ajuste,0,'','.')."</td>\n";
					}
					else
					{
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
					}	
					echo "</tr>\n";
					$SubTotalPesoHumProv=$SubTotalPesoHumProv+$PesoHumProv;
					$SubTotalPesoSecoProv=$SubTotalPesoSecoProv+$PesoSecoProv;
					$SubTotalAjusteCuProv=$SubTotalAjusteCuProv+$Cu_Fino_Ajuste;
					$SubTotalAjusteAgProv=$SubTotalAjusteAgProv+$Ag_Fino_Ajuste;
					$SubTotalAjusteAuProv=$SubTotalAjusteAuProv+$Au_Fino_Ajuste;
					//PROVISIONALES DEL MES
					$Consulta="select distinct t1.lote from age_web.lotes t1 inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional = 'S' ";				
					$Consulta.="where t1.estado_lote <>'6' and t1.rut_proveedor ='".$FilaProv["rut_proveedor"]."' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
					$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
					//echo $Consulta."<br>";
					$EncontroDatos=false;
					$RespLotes = mysqli_query($link, $Consulta);
					$Cu_Fino_Ajuste=0;$Ag_Fino_Ajuste=0;$Au_Fino_Ajuste=0;$Cu_Fino_Pqt1=0;$Ag_Fino_Pqt1=0;$Au_Fino_Pqt1=0;$Cu_Fino_Ajus=0;$Ag_Fino_Ajus=0;$Au_Fino_Ajus=0;$PesoHumProv=0;$PesoSecoProv=0;
					while ($FilaLote=mysqli_fetch_array($RespLotes))
					{
						$EncontroDatos=true;
						$DatosLote= array();
						$ArrLeyes=array();
						$DatosLote["lote"]=$FilaLote["lote"];
						LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
						$Cu_Fino_Ajuste=$Cu_Fino_Ajuste+(($ArrLeyes["02"][2]-$ArrLeyes["02"][7])*$DatosLote["peso_seco"])/100;
						$Cu_Fino_Pqt1=$Cu_Fino_Pqt1+($ArrLeyes["02"][2]*$DatosLote["peso_seco"])/100;
						$Cu_Fino_Ajus=$Cu_Fino_Ajus+($ArrLeyes["02"][7]*$DatosLote["peso_seco"])/100;
						$Ag_Fino_Ajuste=$Ag_Fino_Ajuste+(($ArrLeyes["04"][2]-$ArrLeyes["04"][7])*$DatosLote["peso_seco"])/1000;
						$Ag_Fino_Pqt1=$Ag_Fino_Pqt1+($ArrLeyes["04"][2]*$DatosLote["peso_seco"])/1000;
						$Ag_Fino_Ajus=$Ag_Fino_Ajus+($ArrLeyes["04"][7]*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Ajuste=$Au_Fino_Ajuste+(($ArrLeyes["05"][2]-$ArrLeyes["05"][7])*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Pqt1=$Au_Fino_Pqt1+($ArrLeyes["05"][2]*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Ajus=$Au_Fino_Ajus+($ArrLeyes["05"][7]*$DatosLote["peso_seco"])/1000;
						$PesoHumProv=$PesoHumProv+$DatosLote["peso_humedo"];
						$PesoSecoProv=$PesoSecoProv+$DatosLote["peso_seco"];
					}
					echo "<tr>\n";
					echo "<td>PROVISIONALES DEL MES</td>\n";	
					if($EncontroDatos==true)
					{
						echo "<td align='center'>".number_format(($Cu_Fino_Pqt1*100)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format(($Ag_Fino_Pqt1*1000)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format(($Au_Fino_Pqt1*1000)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format(($Cu_Fino_Ajus*100)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format(($Ag_Fino_Ajus*1000)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format(($Au_Fino_Ajus*1000)/$PesoSecoProv,2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($PesoHumProv,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($PesoSecoProv,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($Cu_Fino_Ajuste,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($Ag_Fino_Ajuste,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($Au_Fino_Ajuste,0,'','.')."</td>\n";
					}
					else
					{
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
						echo "<td align='center'>0</td>\n";
					}	
					echo "</tr>\n";
					$SubTotalPesoHumProv=$SubTotalPesoHumProv+$PesoHumProv;
					$SubTotalPesoSecoProv=$SubTotalPesoSecoProv+$PesoSecoProv;
					$SubTotalAjusteCuProv=$SubTotalAjusteCuProv+$Cu_Fino_Ajuste;
					$SubTotalAjusteAgProv=$SubTotalAjusteAgProv+$Ag_Fino_Ajuste;
					$SubTotalAjusteAuProv=$SubTotalAjusteAuProv+$Au_Fino_Ajuste;
					echo "</tr>\n";
					echo "<tr>\n";
					echo "<td colspan=\"7\">PROVEEDOR:&nbsp;".strtoupper(substr($FilaProv["nom_prv"],0,20))."</td>\n";	
					echo "<td align='center'>".number_format($SubTotalPesoHumProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalPesoSecoProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalAjusteCuProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalAjusteAgProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalAjusteAuProv,0,'','.')."</td>\n";
					echo "</tr>\n";
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PRV"]=strtoupper(substr($FilaProv["nom_prv"],0,40));
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PH"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PH"]+$SubTotalPesoHumProv;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PS"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PS"]+$SubTotalPesoSecoProv;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["02"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["02"]+$SubTotalAjusteCuProv;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["04"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["04"]+$SubTotalAjusteAgProv;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["05"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["05"]+$SubTotalAjusteAuProv;
					$SubTotalPesoHumProd=$SubTotalPesoHumProd+$SubTotalPesoHumProv;
					$SubTotalPesoSecoProd=$SubTotalPesoSecoProd+$SubTotalPesoSecoProv;
					$SubTotalAjusteCuProd=$SubTotalAjusteCuProd+$SubTotalAjusteCuProv;
					$SubTotalAjusteAgProd=$SubTotalAjusteAgProd+$SubTotalAjusteAgProv;
					$SubTotalAjusteAuProd=$SubTotalAjusteAuProd+$SubTotalAjusteAuProv;
				}
				reset($ArrayFinalPrv);
				while(list($c,$v)=each($ArrayFinalPrv))
				{
					echo "<tr>\n";
					echo "<td colspan=\"7\">RESUMEN PROVEEDOR&nbsp;&nbsp;".$v["PRV"]."</td>\n";	
					echo "<td align='center'>".number_format($v["PH"],0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($v["PS"],0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($v["02"],0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($v["04"],0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($v["05"],0,'','.')."</td>\n";
					echo "</tr>\n";
				}
				echo "<tr>\n";
				echo "<td colspan=\"7\">PRODUCTO&nbsp;&nbsp;".strtoupper($FilaProd["nom_subprod"])."</td>\n";	
				echo "<td align='center'>".number_format($SubTotalPesoHumProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalPesoSecoProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteCuProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteAgProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteAuProd,0,'','.')."</td>\n";
				echo "</tr>\n";
				$TotalPesoHumFinal=$TotalPesoHumFinal+$SubTotalPesoHumProd;
				$TotalPesoSecoFinal=$TotalPesoSecoFinal+$SubTotalPesoSecoProd;
				$TotalAjusteCuFinal=$TotalAjusteCuFinal+$SubTotalAjusteCuProd;
				$TotalAjusteAgFinal=$TotalAjusteAgFinal+$SubTotalAjusteAgProd;
				$TotalAjusteAuFinal=$TotalAjusteAuFinal+$SubTotalAjusteAuProd;
			}
			//TOTAL MES PRODUCTO
			echo "<tr>\n";
			echo "<td colspan=\"7\">TOTAL&nbsp;&nbsp;".strtoupper($FilaProd["nom_subprod"])."</td>\n";	
			echo "<td align='center'>".number_format($TotalPesoHumFinal,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalPesoSecoFinal,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteCuFinal,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteAgFinal,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteAuFinal,0,'','.')."</td>\n";
			echo "</tr>\n";
		}
		?>
      </table>
</form>
</body>
</html>