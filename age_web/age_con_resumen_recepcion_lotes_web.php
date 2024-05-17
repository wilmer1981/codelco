<?php
	include("../principal/conectar_principal.php");
	include("../age_web/age_funciones.php");	
	$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
?>
<html>
<head>
<title>AGE-Resumen Recepcion Lotes</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "I":
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;	
		case "S":
			f.action = "age_con_resumen_recepcion_lotes.php";
			f.submit();
			break;
	}
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="620" border="0" align="center">
    <tr>
      <td width="294">CODELCO CHILE<br>
        DIVISION VENTANAS       <br> </td>
      <td width="296" align="right">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><strong><u>INFORME RECEPCION POR LOTES </u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="2">MES: <?php echo $CmbMes."-".$CmbAno; ?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  </table>
  <br>
	<?php
$ColSpan=3;
if ($OptLeyes=="S")
	$ColSpan=$ColSpan+4;
if ($OptFinos=="S")
	$ColSpan=$ColSpan+4;	
	echo "<table width=\"600\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,4,'0') as orden ,recepcion ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
	if ($CmbRecepcion != "S")
		$Consulta.= " and t1.cod_recepcion = '".$CmbRecepcion."' ";
	if ($CmbSubProducto != "S")
	{
		$Consulta.= " and t1.cod_producto = '1' ";
		$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
	}
	if ($CmbProveedor != "S")
		$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
	$Consulta.= " order by t1.cod_producto, orden ";
	//echo $Consulta."<br>";
	$Resp01 = mysqli_query($link, $Consulta);
	while ($Fila01 = mysqli_fetch_array($Resp01))	
	{			
		echo "<tr class=\"ColorTabla01\">\n";			
		$Consulta = "select * from proyecto_modernizacion.subproducto ";
		$Consulta.= "where cod_producto = '".$Fila01["cod_producto"]."' and cod_subproducto='".$Fila01["cod_subproducto"]."'";		
		$RespAux2 = mysqli_query($link, $Consulta);
		if ($FilaAux2 = mysqli_fetch_array($RespAux2))
		{
			$NomSubProd = $FilaAux2["descripcion"];
		}
		else
			$NomSubProd = "SIN IDENTIFICACION";		
		echo "<td align=\"left\" colspan=\"".$ColSpan."\">".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>";					
		echo "</tr>\n";
		//TITULO						
		echo "<tr class=\"ColorTabla02\">\n";		
		echo "<td align=\"center\" rowspan=\"2\">Lote</td>\n";
		echo "<td align=\"center\" rowspan=\"2\">F.Cierre</td>\n";		
		echo "<td align=\"center\" rowspan=\"2\">P.Hum.<br>(Kg)</td>\n";
		echo "<td align=\"center\" colspan=\"4\">Leyes</td>\n";		
		if ($OptFinos=="S")
			echo "<td align=\"center\" colspan=\"4\">Finos</td>\n";
		echo "</tr>";
		echo "<tr class=\"ColorTabla02\">\n";
		if ($OptLeyes=="S")
		{
			echo "<td align=\"center\">Hum<br>(%)</td>\n";
			echo "<td align=\"center\">Cu<br>(%)</td>\n";
			echo "<td align=\"center\">Ag<br>(g/T)</td>\n";
			echo "<td align=\"center\">Au<br>(g/T)</td>\n";
		}
		if ($OptFinos=="S")
		{
			echo "<td align=\"center\">P.Seco<br>(Kg)</td>\n";
			echo "<td align=\"center\">Cu<br>(Kg)</td>\n";
			echo "<td align=\"center\">Ag<br>(Gr)</td>\n";
			echo "<td align=\"center\">Au<br>(Gr)</td>\n";
			
		}	
		echo "</tr>\n";
		//CONSULTA LOS TIPOS DE RECEPCION
		$Consulta = "select distinct t1.cod_recepcion, t3.nombre_subclase as desc_a";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase ='3104' and t1.cod_recepcion=t3.nombre_subclase ";
		$Consulta.= " where t1.lote<>'' ";
		$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
		if ($CmbRecepcion != "S")
			$Consulta.= " and t1.cod_recepcion = '".$CmbRecepcion."' ";
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		$Consulta.= " order by t1.cod_recepcion ";
		//echo $Consulta."<br>";
		$RespTipoRecep = mysqli_query($link, $Consulta);
		while ($FilaTipoRecep = mysqli_fetch_array($RespTipoRecep))
		{					
			//TITULO COD RECEPCION
			echo "<tr bgcolor=\"#CCCCCC\">\n";	
			if ($FilaTipoRecep["desc_a"] == "" || is_null($FilaTipoRecep["desc_a"]))
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">&nbsp;</td>\n";				
			else
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";		
			echo "</tr>\n";
			//CONSULTA LOS PROVEEDOR DE UN PRODUCTO Y UN TIPO DE RECEPCION
			$Consulta = "select distinct t1.rut_proveedor, t1.cod_recepcion  ";
			$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
			$Consulta.= " on t1.lote = t2.lote ";
			$Consulta.= " where t1.lote<>'' ";
			$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
			$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
			$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
			if ($CmbProveedor != "S")
				$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
			$Consulta.= " and t1.cod_recepcion = '".$FilaTipoRecep["cod_recepcion"]."' ";
			$Consulta.= " order by t1.cod_recepcion, t1.rut_proveedor ";
			//echo $Consulta."<br>";
			$RutPrv='';
			$RespAux = mysqli_query($link, $Consulta);
			while ($FilaAux = mysqli_fetch_array($RespAux))
			{		
				$Datos = explode("-",$FilaAux["rut_proveedor"]);
				//$RutAux = ($Datos[0]*1)."-".$Datos[1];
				$RutAux = $FilaAux["rut_proveedor"];
				$NomProveedor = "";
				$Consulta = "select * ";
				$Consulta.= " from rec_web.proved ";
				$Consulta.= " where rutprv_a = '".$RutAux."'";
				$RespProv = mysqli_query($link, $Consulta);	
				//echo $Consulta."<br>";
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$NomProveedor = $FilaProv["NOMPRV_A"];
				}				
				echo "<tr class=\"Detalle01\">\n";
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">".$FilaAux["rut_proveedor"]."&nbsp;&nbsp;".substr(strtoupper($NomProveedor),0,30)."</td>\n";
				echo "</tr>\n";	
				$CodLoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."000";
				$CodLoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";		
				$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
				$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion ";		
				$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
				$Consulta.= " on t1.lote = t2.lote ";			
				$Consulta.= " where t1.cod_producto = '".$Fila01["cod_producto"]."' ";
				$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
				$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
				$Consulta.= " and t1.rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
				$Consulta.= " and t1.cod_recepcion = '".$FilaAux["cod_recepcion"]."' ";					
				$Consulta.= " and (t1.estado_lote <>'6'  or (t1.estado_lote='6' and t1.mostrar_lote='S')) ";
				$Consulta.= " and (t1.tipo_remuestreo <>'A'  or (t1.tipo_remuestreo='A' and substring(t1.lote,1,3)='".substr($CodLoteIni,0,3)."'))";				
				$Consulta.= " group by t1.lote order by t1.lote, orden";
				$RespLote = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				$EsPlamen=false;
				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					echo "<tr>";
					echo "<td align=\"center\">".$FilaLote["lote"]."</td>";
					echo "<td align=\"center\">".substr($FilaLote[fecha_recepcion],8,2)."/".substr($FilaLote[fecha_recepcion],5,2)."/".substr($FilaLote[fecha_recepcion],0,4)."</td>";
					$DatosLote= array();
					$ArrLeyes=array();
					$DatosLote["lote"]=$FilaLote["lote"];
					$ArrLeyes["01"][0]="01";$ArrLeyes["02"][0]="02";$ArrLeyes["04"][0]="04";$ArrLeyes["05"][0]="05";
					LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
					$PesoLoteS=$DatosLote["peso_seco2"];
					$PesoLoteH=$DatosLote["peso_humedo"];
					$CantDecPeso=0;$CantDecLF=0;
					if($Fila01["recepcion"]=='PMN')
					{
						$EsPlamen=true;
						$CantDecPeso=4;$CantDecLF=4;
						$PesoLoteS=$DatosLote["peso_seco"];
					}
					echo "<td align=\"right\">".number_format($PesoLoteH,$CantDecPeso,',','.')."</td>";
					//LEYES
					reset($ArrLeyes);
					while(list($c,$v)=each($ArrLeyes))
					{
						$Decimales=0;
						switch ($c)
						{
							case "01":
								$Decimales=2;
								break;
							case "02":
								$Decimales=2;
								break;
							case "04":
								$Decimales=0;
								break;
							case "05":
								$Decimales=1;
								break;
						}
						if($c!='')
						{
							if ($OptLeyes == "S"&&$DatosLote["tipo_remuestreo"]!="A")						
								echo "<td align=\"right\">".number_format($v[2],$Decimales,',','.')."</td>\n";
							else
								echo "<td align=\"right\">".number_format(0,0,',','.')."</td>\n";
						}		
					}
					if ($OptFinos == "S")		
						echo "<td align=\"right\">".number_format($PesoLoteS,$CantDecPeso,',','.')."</td>";		
					//FINOS
					reset($ArrLeyes);
					while(list($c,$v)=each($ArrLeyes))
					{
						if($c!='')
						{
							if ($OptFinos == "S")
							{	
								if($c!='01')
									echo "<td align=\"right\">".number_format($v[23],$CantDecLF,',','.')."</td>\n";
							}
						}		
					}
					
					echo "</tr>";						
				}
				//TOTAL PROVEEDOR
				echo "<tr class=\"Detalle01\">\n";
				echo "<td align=\"left\" colspan=\"2\">TOTAL ".$FilaAux["rut_proveedor"]."</td>";
				$ArrDatos=array();
				$ArrLeyesProv=array();
				$ArrLeyesProv["01"][0]="01";$ArrLeyesProv["02"][0]="02";$ArrLeyesProv["04"][0]="04";$ArrLeyesProv["05"][0]="05";
				LeyesProveedor($FilaAux["cod_recepcion"],$FilaAux["rut_proveedor"],'1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProv,'N','S','S',$TxtFechaIni,$TxtFechaFin,"");
				$CantDecPeso=0;$CantDecLF=0;
				$PesoS=$ArrDatos[peso_seco3];
				if($EsPlamen==true)
				{
					$CantDecPeso=4;$CantDecLF=4;
					$PesoS=$ArrDatos["peso_seco"];
				}
				echo "<td align=\"right\">".number_format($ArrDatos["peso_humedo"],$CantDecPeso,',','.')."</td>";
				//LEYES
				reset($ArrLeyesProv);
				while(list($c,$v)=each($ArrLeyesProv))
				{
					$Decimales=0;
					switch ($c)
					{
						case "01":
							$Decimales=2;
							break;
						case "02":
							$Decimales=2;
							break;
						case "04":
							$Decimales=0;
							break;
						case "05":
							$Decimales=1;
							break;
					}
					if($c!='')
						if ($OptLeyes == "S")						
							echo "<td align=\"right\">".number_format($v[2],$Decimales,',','.')."</td>\n";
				}
				//FINOS
				if ($OptFinos == "S")				
						echo "<td align=\"right\">".number_format($PesoS,$CantDecPeso,',','.')."</td>";				
				reset($ArrLeyesProv);
				while(list($c,$v)=each($ArrLeyesProv))
				{					
					if($c!='')
					{
						if ($OptFinos == "S")						
						{
							if($c!='01')
								echo "<td align=\"right\">".number_format($v[23],$CantDecLF,',','.')."</td>\n";
						}
					}
				}
				echo "</tr>\n";
				$RutPrv=$RutPrv."'".$FilaAux["rut_proveedor"]."',";
			}
			//TOTAL TIPO RECEPCION
			echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"2\">TOTAL&nbsp;".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
			$RutPrv=substr($RutPrv,0,strlen($RutPrv)-1);
			$RutPrv="(".$RutPrv.")";
			$ArrDatos=array();
			$ArrLeyesProd=array();
			$ArrLeyesProd["01"][0]="01";$ArrLeyesProd["02"][0]="02";$ArrLeyesProd["04"][0]="04";$ArrLeyesProd["05"][0]="05";
			LeyesProducto('',$RutPrv,$FilaTipoRecep["cod_recepcion"],'1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProd,'N','S','S',$TxtFechaIni,$TxtFechaFin,"");
			$CantDecPeso=0;$CantDecLF=0;
			$PesoS=$ArrDatos[peso_seco3];
			if($EsPlamen==true)
			{
				$CantDecPeso=4;$CantDecLF=4;
				$PesoS=$ArrDatos["peso_seco"];
			}
			echo "<td align=\"right\">".number_format($ArrDatos["peso_humedo"],$CantDecPeso,',','.')."</td>";
			//LEYES
			reset($ArrLeyesProd);
			while(list($c,$v)=each($ArrLeyesProd))
			{
				$Decimales=0;
				switch ($c)
				{
					case "01":
						$Decimales=2;
						break;
					case "02":
						$Decimales=2;
						break;
					case "04":
						$Decimales=0;
						break;
					case "05":
						$Decimales=1;
						break;
				}
				if($c!='')
					if ($OptLeyes == "S")						
						echo "<td align=\"right\">".number_format($v[2],$Decimales,',','.')."</td>\n";
			}
			//FINOS
			if ($OptFinos == "S")
				echo "<td align=\"right\">".number_format($PesoS,$CantDecPeso,',','.')."</td>";			
			reset($ArrLeyesProd);
			while(list($c,$v)=each($ArrLeyesProd))
			{
				if($c!='')
				{
					if ($OptFinos == "S")						
					{
						if($c!='01')
							echo "<td align=\"right\">".number_format($v[23],$CantDecLF,',','.')."</td>\n";
					}
				}
			}
			echo "</tr>\n";
		}//FIN TIPO RECEPCION
		//TOTAL PRODUCTO
		echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"2\">TOTAL: ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($NomSubProd)."</td>\n";
		$ArrDatos=array();
		$ArrLeyesProd=array();
		$ArrLeyesProd["01"][0]="01";$ArrLeyesProd["02"][0]="02";$ArrLeyesProd["04"][0]="04";$ArrLeyesProd["05"][0]="05";
		$RutPrv='';$CodRecep='';
		if($CmbProveedor!='S')
			$RutPrv="('".$CmbProveedor."')";
		if ($CmbRecepcion != "S")
			$CodRecep=$CmbRecepcion;
		LeyesProducto('',$RutPrv,$CodRecep,'1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProd,'N','S','S',$TxtFechaIni,$TxtFechaFin,"");
		$CantDecPeso=0;$CantDecLF=0;
		$PesoS=$ArrDatos[peso_seco3];
		if($EsPlamen==true)
		{
			$CantDecPeso=4;$CantDecLF=4;
			$PesoS=$ArrDatos["peso_seco"];
		}
		echo "<td align=\"right\">".number_format($ArrDatos["peso_humedo"],$CantDecPeso,',','.')."</td>";
		//LEYES
		reset($ArrLeyesProd);
		while(list($c,$v)=each($ArrLeyesProd))
		{
			$Decimales=0;
			switch ($c)
			{
				case "01":
					$Decimales=2;
					break;
				case "02":
					$Decimales=2;
					break;
				case "04":
					$Decimales=0;
					break;
				case "05":
					$Decimales=1;
					break;
			}
			if($c!='')
				if ($OptLeyes == "S")						
					echo "<td align=\"right\">".number_format($v[2],$Decimales,',','.')."</td>\n";
		}
		reset($ArrLeyesProd);		
		//FINOS
		if ($OptFinos == "S")
			echo "<td align=\"right\">".number_format($PesoS,$CantDecPeso,',','.')."</td>";		
		while(list($c,$v)=each($ArrLeyesProd))
		{
			if($c!='')
			{
				if($c!='01')
				{
					$ArrLeyesInf[$c][23]=$ArrLeyesInf[$c][23] + $v[23];
					if ($OptFinos == "S")
					{
						echo "<td align=\"right\">".number_format($v[23],$CantDecLF,',','.')."</td>\n";
					}
				}							
			}
		}
		$TotInfPesoHum=$TotInfPesoHum + $ArrDatos["peso_humedo"];
		$TotInfPesoSeco=$TotInfPesoSeco + $PesoS;
		echo "</tr>\n";				
	}//FIN PRODUCTOS
	//TOTAL INFORME	
	echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"2\">TOTAL INFORME</td>\n";		
	echo "<td align=\"right\">".number_format($TotInfPesoHum,0,',','.')."</td>";
	if (round($TotInfPesoHum)!=round($TotInfPesoSeco))
		$TotInfPorcHum=100-($TotInfPesoSeco/$TotInfPesoHum*100);
	else
		$TotInfPorcHum=0;
	echo "<td align=\"right\">".number_format($TotInfPorcHum,2,',','.')."</td>";
	
	//LEYES
	reset($ArrLeyesInf);
	while(list($c,$v)=each($ArrLeyesInf))
	{
		$Decimales=0;		
		if($c!='')
		{		
			if ($OptLeyes == "S")		
			{
				switch ($c)
				{			
					case "02":
						$Decimales=2;
						$Valor=$v[23]/$TotInfPesoSeco*100;
						break;
					case "04":
						$Decimales=0;
						$Valor=$v[23]/$TotInfPesoSeco*1000;
						break;
					case "05":
						$Decimales=1;
						$Valor=$v[23]/$TotInfPesoSeco*1000;
						break;
				}
				
				echo "<td align=\"right\">".number_format($Valor,$Decimales,',','.')."</td>\n";
			}
		}
	}
	reset($ArrLeyesInf);		
	//FINOS
	if ($OptFinos == "S")
		echo "<td align=\"right\">".number_format($TotInfPesoSeco,0,',','.')."</td>";		
	while(list($c,$v)=each($ArrLeyesInf))
	{
		if($c!='')
		{
			if ($OptFinos == "S")
			{
				if($c!='01')
					echo "<td align=\"right\">".number_format($v[23],$CantDecLF,',','.')."</td>\n";
			}
		}
	}
	echo "</tr>\n";
	echo "</table>\n";
	?>  
</form>
</body>
</html>