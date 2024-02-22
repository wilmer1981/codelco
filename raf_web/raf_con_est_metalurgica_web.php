<?
	include("../principal/conectar_principal.php");
?>
<html>
<head>
<title>Sistema RAF</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript">
function Proceso(opt,valor)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "I":
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;
		case "DH":
			window.open("raf_con_est_metalurgica_det_hornada.php?Hornada="+valor,"","left=30,top=30,width=500,height=400,scrollbars=yes,resizable=yes");
			break;
		case "DP":
			window.open("raf_con_est_metalurgica_det_procesos.php?Hornada="+valor,"","left=30,top=30,width=500,height=400,scrollbars=yes,resizable=yes");
			break;
		case "S":
			f.action = "raf_con_est_metalurgica.php";
			f.submit();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="900"  border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr align="center">
    <td colspan="24"><strong>ESTADISTICA METALURGICA H. BASCULANTE</strong></td>
  </tr>
  <tr align="right">
    <td colspan="24"><strong>BASCULANTE MES: <? echo $Meses[$Mes-1]." ".$Ano; ?> </strong></td>
  </tr>
  <tr align="center">
    <td colspan="14">&nbsp;</td>
    <td colspan="6" class="ColorTabla01">TIEMPOS (hrs.) </td>
    <td colspan="4" class="ColorTabla01">COMBUSTIBLES</td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td>Fecha</td>
    <td>N&ordm;</td>
    <td>&nbsp;</td>
    <td>Cu</td>
    <td>N&ordm;</td>
    <td rowspan="2">Otros<br>
      Solid.</td>
    <td colspan="3">Prod. Anodos </td>
    <td>Esc.</td>
    <td colspan="2">Moldes</td>
    <td>Producc</td>
    <td>N&ordm;</td>
    <td>Carga</td>
    <td>Oxid.</td>
    <td>Reducc.</td>
    <td>Moldeo</td>
    <td>Vacio</td>
    <td>Total</td>
    <td colspan="2">Gas Natural </td>
    <td colspan="2">Diesel</td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td>&nbsp;</td>
    <td>Horno</td>
    <td>&nbsp;</td>
    <td>Liquido</td>
    <td>Ollas</td>
    <td>Com.</td>
    <td>H.M.</td>
    <td>Total</td>
    <td>Anodica</td>
    <td>Vent.</td>
    <td>Chag.</td>
    <td>Total</td>
    <td>Hornada</td>
    <td>Fusion</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Quem.</td>
    <td>Tobe.</td>
    <td>Quem.</td>
    <td>Tobe.</td>
  </tr>
<? 
	$FechaIni = $Ano."-".str_pad($Mes,2,"00",STR_PAD_LEFT)."-01";
	$FechaFin = $Ano."-".str_pad($Mes,2,"00",STR_PAD_LEFT)."-31";
	$Consulta = "select DISTINCT fecha_movimiento, hornada from sea_web.movimientos";
	$Consulta.= " where fecha_movimiento between '".$FechaIni."' and '".$FechaFin."' ";
	$Consulta.= " and hornada BETWEEN '".$Ano.str_pad($Mes,2,"00",STR_PAD_LEFT)."4000' and '".$Ano.str_pad($Mes,2,"00",STR_PAD_LEFT)."4999'";
	$Consulta.= " and tipo_movimiento='1'";
	$Consulta.= " order by fecha_movimiento, hornada";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{ 		
		//PRODUCCIONES
		//COMERCIALES
		$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 3";
		$Consulta.= " AND hornada = '".$Fila["hornada"]."'"; 
		$Consulta.= " AND campo1 <> ''"; 
		$Consulta.= " AND campo2 = '1'"; 
		$Resp2 = mysql_query($Consulta);			
		if($Fila2 = mysql_fetch_array($Resp2))
		{			
			$ProdCom = $Fila2["campo4"]; 
		}
		else
		{
			$ProdCom = 0; 
		}
		//HM
		$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 3";
		$Consulta.= " AND hornada = '".$Fila["hornada"]."'"; 
		$Consulta.= " AND campo1 <> ''"; 
		$Consulta.= " AND campo2 = '3'"; 
		$Resp2 = mysql_query($Consulta);			
		if($Fila2 = mysql_fetch_array($Resp2))
		{						
			$ProdHM = $Fila2["campo4"]; 
		}
		else
		{
			$ProdHM = 0; 
		}
		//ESC
		$Consulta = "SELECT SUM(campo5) as campo5, sum(campo6) as campo6 FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 5";
		$Consulta.= " AND hornada = '".$Fila["hornada"]."'"; 
		$Consulta.= " AND campo1 <> ''"; 
		$Consulta.= " AND campo2 = '1'"; 
		$Resp2 = mysql_query($Consulta);			
		if($Fila2 = mysql_fetch_array($Resp2))
		{			
			$ProdEsc = $Fila2["campo6"];
		}			
		
		$SubTotalProd = $ProdCom + $ProdHM;
		$ProdTotal = $SubTotalProd + $ProdEsc;
		$AcumProdCom = $AcumProdCom + $ProdCom;
		$AcumProdHM = $AcumProdHM + $ProdHM;
		$AcumProdEsc = $AcumProdEsc + $ProdEsc;			
		$AcumSubTotalProd = $AcumSubTotalProd + $SubTotalProd;	
		$AcumTotalProd = $AcumTotalProd + $ProdTotal;
		//Cu LIQUIDO
		//DATOS DE CARGA DEL H.BASC
		$PesoCuLiq = 0;
		$OllasCuLiq = 0;
		$Consulta = "select hornada, sum(campo2) as ollas ";
		$Consulta.= " from raf_web.datos_operacionales ";
		$Consulta.= " where hornada = '".$Fila["hornada"]."'";			
		$Consulta.= " and tipo_report='1' and seccion_report='1' ";
		$Consulta.= " and (ISNULL(campo4) or campo4<>'S' or campo4='')"; 
		$Consulta.= " and campo1 <> ''";
		$Consulta.= " group by hornada ";		
		$Resp2 = mysql_query($Consulta);
		if ($Fila2=mysql_fetch_array($Resp2))
		{
			$PesoCuLiq = $Fila2["ollas"] * 30000;//Cu Liquido
			$OllasCuLiq = $Fila2["ollas"];//N� Ollas			
		}		
		//SE LE RESTA A LA CARGA LOS TRASVASIJES
		$Consulta = "select hornada, sum(campo2) as ollas ";
		$Consulta.= " from raf_web.datos_operacionales ";
		$Consulta.= " where hornada = '".$Fila["hornada"]."'";			
		$Consulta.= " and tipo_report='1' and seccion_report='6' ";//TRASVASE H.BASC
		$Consulta.= " and campo1 <> ''";
		$Consulta.= " group by hornada ";
		$Resp2 = mysql_query($Consulta);
		if ($Fila2=mysql_fetch_array($Resp2))
		{
			$PesoCuLiq = $PesoCuLiq - ($Fila2["ollas"] * 30000);//Cu Liquido
			$OllasCuLiq = $OllasCuLiq - $Fila2["ollas"];//N� Ollas			
		}		
		//FIN Cu LIQUIDO
		$AcumPesoCuLiq = $AcumPesoCuLiq + $PesoCuLiq;
		$AcumOllasCuLiq = $AcumOllasCuLiq + $OllasCuLiq;
		//PRODUCCION DE MOLDES VENTANAS
		$ProdMoldesVent = 0;
		$Consulta = "select sum(campo3) as unid_moldes, sum(campo4) as peso_moldes ";
		$Consulta.= " from raf_web.datos_operacionales t1 inner join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t1.campo2 = t2.cod_subclase and t2.cod_clase='12006'";
		$Consulta.= " where t1.hornada='".$Fila["hornada"]."'";
		$Consulta.= " and t1.tipo_report='1'";
		$Consulta.= " and t1.seccion_report='10'";
		$Consulta.= " and (t2.cod_subclase!='3')"; //Moldes Chagres
		$Resp2 = mysql_query($Consulta);
		if ($Fila2 = mysql_fetch_array($Resp2))
			$ProdMoldesVent = $Fila2["peso_moldes"];
		$AcumProdMoldesVent = $AcumProdMoldesVent + $ProdMoldesVent; 
		//PRODUCCION DE MOLDES CHAGRES
		$ProdMoldesChag = 0;
		$Consulta = "select sum(campo3) as unid_moldes, sum(campo4) as peso_moldes ";
		$Consulta.= " from raf_web.datos_operacionales t1 inner join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t1.campo2 = t2.cod_subclase and t2.cod_clase='12006'";
		$Consulta.= " where t1.hornada='".$Fila["hornada"]."'";
		$Consulta.= " and t1.tipo_report='1'";
		$Consulta.= " and t1.seccion_report='10'";
		$Consulta.= " and t2.cod_subclase='3'"; //Moldes Chagres
		$Resp2 = mysql_query($Consulta);
		if ($Fila2 = mysql_fetch_array($Resp2))
			$ProdMoldesChag = $Fila2["peso_moldes"];
		$AcumProdMoldesChag = $AcumProdMoldesChag + $ProdMoldesChag; 
		//OTROS SOLIDOS
		$OtrosSolidos = 0;
		/*$Consulta = "select sum(campo3) as unid_moldes, sum(campo4) as peso_moldes ";
		$Consulta.= " from raf_web.datos_operacionales t1 inner join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t1.campo2 = t2.cod_subclase and t2.cod_clase='12006'";
		$Consulta.= " where t1.hornada='".$Fila["hornada"]."'";
		$Consulta.= " and t1.tipo_report='1'";
		$Consulta.= " and t1.seccion_report='10'";
		$Consulta.= " and t2.cod_subclase='10'"; //Otros Solidos
		$Resp2 = mysql_query($Consulta);
		if ($Fila2 = mysql_fetch_array($Resp2))
			$OtrosSolidos = $Fila2["peso_moldes"];
		$AcumOtrosSolidos = $AcumOtrosSolidos + $OtrosSolidos;*/ 
		//CARGA FUSION
		$AcumHora=0;
		$AcumMin=0;
		$TimeCarga = 0;
		$FH_IniCarga = "";
		$FH_FinCarga = "";
		$Consulta = "select distinct hornada, campo1 from raf_web.datos_operacionales ";
		$Consulta.= " where hornada = '".$Fila["hornada"]."'";
		$Consulta.= " order by hornada, campo1";
		$RespAux = mysql_query($Consulta);
		while ($FilaAux = mysql_fetch_array($RespAux))
		{
			$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
			$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 1";
			$Consulta.= " AND hornada = '".$Fila["hornada"]."'";
			$Consulta.= " AND campo1 = '".$FilaAux["campo1"]."'"; 
			$Consulta.= " and tipo_report='1' and seccion_report='1' ";
			$Consulta.= " and (ISNULL(campo4) or campo4<>'S' or campo4='')"; 
			$Consulta.= " and campo1 <> ''";
			$Consulta.= " order by fecha_ini, hora_ini, hora_ter ";
			$Resp2 = mysql_query($Consulta);
			$Cont = 1;
			while ($Fila2 = mysql_fetch_array($Resp2))
			{
				$FechaIniAux = $Fila2["fecha_ini"];
				if (substr($Fila2["hora_ter"],0,2) < substr($Fila2["hora_ini"],0,2))
					$FechaFinAux = date("Y-m-d", mktime(0,0,0,substr($Fila2["fecha_ini"],5,2),intval(substr($Fila2["fecha_ini"],8,2))+1,substr($Fila2["fecha_ini"],0,4)));
				else
					$FechaFinAux = $Fila2["fecha_ini"];
				if ($Cont == 1)
					$FH_IniCarga = $Fila2["fecha_ini"]." ".$Fila2["hora_ini"];
				else
					$FH_FinCarga = $FechaFinAux." ".$Fila2["hora_ter"];
				$Cont++;
			}
			$Consulta = "select TIMEDIFF('".$FH_FinCarga."', '".$FH_IniCarga."') as diferencia ";				
			$Resp3 = mysql_query($Consulta);
			if ($Fila3 = mysql_fetch_array($Resp3))
			{				
				$AcumHora = $AcumHora + intval(substr($Fila3["diferencia"],0,2));
				$AcumMin = $AcumMin + (intval(substr($Fila3["diferencia"],3,2)) / 60);
			}				
		}
		$TimeCarga = $AcumHora + $AcumMin;
		$AcumTimeCarga = $AcumTimeCarga + $TimeCarga;
		//OXIDACION
		$AcumHora=0;
		$AcumMin=0;
		$TimeOxid=0;
		$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 5";
		$Consulta.= " AND hornada = '".$Fila["hornada"]."'"; 
		$Consulta.= " AND campo2 = '2'";
		$Consulta.= " order by fecha_ini, hora_ini, hora_ter ";
		$Resp2 = mysql_query($Consulta);		
		while($Fila2 = mysql_fetch_array($Resp2))
		{	
			$FechaIniAux = $Fila2["fecha_ini"];
			if (substr($Fila2["hora_ter"],0,2) < substr($Fila2["hora_ini"],0,2))
				$FechaFinAux = date("Y-m-d", mktime(0,0,0,substr($Fila2["fecha_ini"],5,2),intval(substr($Fila2["fecha_ini"],8,2))+1,substr($Fila2["fecha_ini"],0,4)));
			else
				$FechaFinAux = $Fila2["fecha_ini"];
			$Consulta = "select TIMEDIFF('".$FechaFinAux." ".$Fila2["hora_ter"]."', '".$FechaIniAux." ".$Fila2["hora_ini"]."') as diferencia ";			
			$Resp3 = mysql_query($Consulta);
			if ($Fila3 = mysql_fetch_array($Resp3))
			{				
				$AcumHora = $AcumHora + intval(substr($Fila3["diferencia"],0,2));
				$AcumMin = $AcumMin + (intval(substr($Fila3["diferencia"],3,2)) / 60);
			}		
		}	
		$TimeOxid = $AcumHora + $AcumMin;
		$AcumTimeOxid = $AcumTimeOxid + $TimeOxid;
		//REDUCCION Q. y T.
		$AcumHora=0;
		$AcumMin=0;
		$TimeReduc=0;
		$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 5";
		$Consulta.= " AND hornada = '".$Fila["hornada"]."'"; 
		$Consulta.= " AND campo2 in(3,4)";
		$Consulta.= " order by fecha_ini, hora_ini, hora_ter ";
		$Resp2 = mysql_query($Consulta);		
		while($Fila2 = mysql_fetch_array($Resp2))
		{	
			$FechaIniAux = $Fila2["fecha_ini"];
			if (substr($Fila2["hora_ter"],0,2) < substr($Fila2["hora_ini"],0,2))
				$FechaFinAux = date("Y-m-d", mktime(0,0,0,substr($Fila2["fecha_ini"],5,2),intval(substr($Fila2["fecha_ini"],8,2))+1,substr($Fila2["fecha_ini"],0,4)));
			else
				$FechaFinAux = $Fila2["fecha_ini"];
			$Consulta = "select TIMEDIFF('".$FechaFinAux." ".$Fila2["hora_ter"]."', '".$FechaIniAux." ".$Fila2["hora_ini"]."') as diferencia ";			
			$Resp3 = mysql_query($Consulta);
			if ($Fila3 = mysql_fetch_array($Resp3))
			{				
				$AcumHora = $AcumHora + intval(substr($Fila3["diferencia"],0,2));
				$AcumMin = $AcumMin + (intval(substr($Fila3["diferencia"],3,2)) / 60);
			}		
		}	
		$TimeReduc = $AcumHora + $AcumMin;
		$AcumTimeReduc = $AcumTimeReduc + $TimeReduc;
		//MOLDEO
		$AcumHora=0;
		$AcumMin=0;
		$TimeMoldeo=0;
		$FH_FinMoldeo = "";		
		$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 5";
		$Consulta.= " AND hornada = '".$Fila["hornada"]."'"; 
		$Consulta.= " AND campo2 = '5'";
		$Consulta.= " order by fecha_ini, hora_ini, hora_ter ";
		$Resp2 = mysql_query($Consulta);		
		while($Fila2 = mysql_fetch_array($Resp2))
		{	
			$FechaIniAux = $Fila2["fecha_ini"];
			if (substr($Fila2["hora_ter"],0,2) < substr($Fila2["hora_ini"],0,2))
				$FechaFinAux = date("Y-m-d", mktime(0,0,0,substr($Fila2["fecha_ini"],5,2),intval(substr($Fila2["fecha_ini"],8,2))+1,substr($Fila2["fecha_ini"],0,4)));
			else
				$FechaFinAux = $Fila2["fecha_ini"];
			$Consulta = "select TIMEDIFF('".$FechaFinAux." ".$Fila2["hora_ter"]."', '".$FechaIniAux." ".$Fila2["hora_ini"]."') as diferencia ";			
			$Resp3 = mysql_query($Consulta);
			if ($Fila3 = mysql_fetch_array($Resp3))
			{				
				$AcumHora = $AcumHora + intval(substr($Fila3["diferencia"],0,2));
				$AcumMin = $AcumMin + (intval(substr($Fila3["diferencia"],3,2)) / 60);
			}		
			$FH_FinMoldeo = $FechaFinAux." ".$Fila2["hora_ter"];
		}	
		$TimeMoldeo = $AcumHora + $AcumMin;
		$AcumTimeMoldeo = $AcumTimeMoldeo + $TimeMoldeo;
		//VACIO
		$FH_IniSgteCarga = "";
		$TimeVacio="";
		$SgteHornada = ($Fila["hornada"] + 1);
		$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 1";
		$Consulta.= " AND hornada = '".$SgteHornada."'"; 
		$Consulta.= " and tipo_report='1' and seccion_report='1' ";
		$Consulta.= " and (ISNULL(campo4) or campo4<>'S' or campo4='')"; 
		$Consulta.= " and campo1 <> ''";
		$Consulta.= " order by fecha_ini, hora_ini, hora_ter ";
		$Resp2 = mysql_query($Consulta);		
		if ($Fila2 = mysql_fetch_array($Resp2))
		{
			$FH_IniSgteCarga = $Fila2["fecha_ini"]." ".$Fila2["hora_ini"];
			if ($FH_FinMoldeo<>"" && $FH_IniSgteCarga<>"")
			{
				$Consulta = "select TIMEDIFF('".$FH_IniSgteCarga."', '".$FH_FinMoldeo."') as diferencia ";							
				$Resp3 = mysql_query($Consulta);
				if ($Fila3 = mysql_fetch_array($Resp3))
				{				
					$AcumHora = intval(substr($Fila3["diferencia"],0,2));
					$AcumMin = (intval(substr($Fila3["diferencia"],3,2)) / 60);
				}		
			}			
		}		
		$TimeVacio = $AcumHora + $AcumMin;
		$AcumTimeVacio = $AcumTimeVacio + $TimeVacio;
		//TOTAL
		$TimeTotal = $TimeCarga + $TimeOxid + $TimeReduc + $TimeMoldeo + $TimeVacio;
		$AcumTimeTotal = $AcumTimeTotal + $TimeTotal;
		//COMBUSTIBLES
		$Q_Gas = 0;
		$Q_Die = 0;
		$T_Gas = 0;
		$T_Die = 0;
		$Consulta = "select campo2, sum(campo5 - campo3) as dif from raf_web.datos_operacionales ";
		$Consulta.= " WHERE hornada = '".$Fila["hornada"]."' ";
		//$Consulta.= " AND campo1 = '".$Letra."' ";
		$Consulta.= " AND tipo_report = 1 ";
		$Consulta.= " AND seccion_report = '11'";
		$Consulta.= " group by campo2";
		$Resp2 = mysql_query($Consulta);
		while ($Fila2 = mysql_fetch_array($Resp2))
		{
			switch ($Fila2["campo2"])
			{
				case "QGI":
					$Q_Gas = $Fila2["dif"];
					break;
				case "QDI":
					$Q_Die = $Fila2["dif"];
					break;
				case "TGI":
					$T_Gas = $Fila2["dif"];
					break;
				case "TDI":
					$T_Die = $Fila2["dif"];
					break;
			}
		}
		$AcumQ_Gas = $AcumQ_Gas + $Q_Gas;
		$AcumQ_Die = $AcumQ_Die + $Q_Die;
		$AcumT_Gas = $AcumT_Gas + $T_Gas;
		$AcumT_Die = $AcumT_Die + $T_Die;
		//ESCRIBE TABLA
		echo "<tr>\n";
		echo "<td align='center'>".substr($Fila["fecha_movimiento"],8,2)."-".substr($Fila["fecha_movimiento"],5,2)."</td>\n";
		echo "<td align='center' class='ColorTabla02'><a href=\"JavaScript:Proceso('DH','".$Fila["hornada"]."')\" title=\"Pulse Aqui Para Ver Detalle de la Carga\">";
		echo substr($Fila["hornada"],-4)."</a></td>\n";
		echo "<td align='center'>1</td>\n";				
		echo "<td align='right'>".number_format($PesoCuLiq,0,",",".")."</td>\n";//Cu Liquido
		echo "<td align='right'>".number_format($OllasCuLiq,2,",",".")."</td>\n";//N� Ollas	
		echo "<td align='right'>".number_format($OtrosSolidos,0,",",".")."</td>\n";//Otros Solidos
		echo "<td align='right'>".number_format($ProdCom,0,",",".")."</td>\n";//Prod Comerciales
		echo "<td align='right'>".number_format($ProdHM,0,",",".")."</td>\n";//Prod. H.M.
		echo "<td align='right'>".number_format($SubTotalProd,0,",",".")."</td>\n";//Sub. Total Prod.
		echo "<td align='right'>".number_format($ProdEsc,0,",",".")."</td>\n";//Esc. Anodica
		echo "<td align='right'>".number_format($ProdMoldesVent,0,",",".")."</td>\n";//Moldes Ventana
		echo "<td align='right'>".number_format($ProdMoldesChag,0,",",".")."</td>\n";//Moldes Chagres
		echo "<td align='right'>".number_format($ProdTotal,0,",",".")."</td>\n";//Prod. Total
		echo "<td align='center' class='ColorTabla02'><a href=\"JavaScript:Proceso('DP','".$Fila["hornada"]."')\" title=\"Pulse Aqui Para Ver Detalle de los Procesos\">";
		echo substr($Fila["hornada"],-4)."</td>\n";
		echo "<td align='right'>".number_format($TimeCarga,2,",",".")."</td>\n";//carga fusion		
		echo "<td align='right'>".number_format($TimeOxid,2,",",".")."</td>\n";//Oxidacion
		echo "<td align='right'>".number_format($TimeReduc,2,",",".")."</td>\n";//Reduccion
		echo "<td align='right'>".number_format($TimeMoldeo,2,",",".")."</td>\n";//Moldeo
		echo "<td align='right'>".number_format($TimeVacio,2,",",".")."</td>\n";//Vacio
		echo "<td align='right'>".number_format($TimeTotal,2,",",".")."</td>\n";//Total
		echo "<td align='right'>".number_format($Q_Gas,1,",",".")."</td>\n";//Quemador->Gas Natural
		echo "<td align='right'>".number_format($T_Gas,1,",",".")."</td>\n";//Toberas->Gas Natural
		echo "<td align='right'>".number_format($Q_Die,1,",",".")."</td>\n";//Quemador->Diesel
		echo "<td align='right'>".number_format($T_Die,1,",",".")."</td>\n";//Toberas->Diesel
		echo "</tr>\n";
	}
?>  
  <tr class="ColorTabla02">
    <td>TOTAL</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><? echo number_format($AcumPesoCuLiq,0,",","."); ?></td>
    <td align="right"><? echo number_format($AcumOllasCuLiq,2,",","."); ?></td>
    <td align="right"><? echo number_format($AcumOtrosSolidos,0,",","."); ?></td>
    <td align="right"><? echo number_format($AcumProdCom,0,",","."); ?></td>
    <td align="right"><? echo number_format($AcumProdHM,0,",","."); ?></td>
    <td align="right"><? echo number_format($AcumSubTotalProd,0,",","."); ?></td>
    <td align="right"><? echo number_format($AcumProdEsc,0,",","."); ?></td>
    <td align="right"><? echo number_format($AcumProdMoldesVent,0,",","."); ?></td>
     <td align="right"><? echo number_format($AcumProdMoldesChag,0,",","."); ?></td>
    <td align="right"><? echo number_format($AcumTotalProd,0,",","."); ?></td>
    <td>&nbsp;</td>
    <td align="right"><? echo number_format($AcumTimeCarga,2,",","."); ?></td>
    <td align="right"><? echo number_format($AcumTimeOxid,2,",","."); ?></td>
    <td align="right"><? echo number_format($AcumTimeReduc,2,",","."); ?></td>
    <td align="right"><? echo number_format($AcumTimeMoldeo,2,",","."); ?></td>
    <td align="right"><? echo number_format($AcumTimeVacio,2,",","."); ?></td>
    <td align="right"><? echo number_format($AcumTimeTotal,2,",","."); ?></td>
    <td align="right"><? echo number_format($AcumQ_Gas,1,",","."); ?></td>
    <td align="right"><? echo number_format($AcumT_Gas,1,",","."); ?></td>
    <td align="right"><? echo number_format($AcumQ_Die,1,",","."); ?></td>
    <td align="right"><? echo number_format($AcumT_Die,1,",","."); ?></td>
  </tr>
</table>
<br>
<table width="750"  border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td width="691" align="center">	<input name="BtnImprimir" type="button" value="Imprimir" style="width:70px " onClick="Proceso('I')">
    <input name="BtnSalir" type="button" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
</form>
</body>
</html>
