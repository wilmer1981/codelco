<?php
	include("../principal/conectar_principal.php");
	include("../age_web/age_funciones.php");	
	$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
	$ArrLeyes=array();
	$ArrLeyesAux=array();
	$ArrLeyesAux["01"][0]="01";
	$ArrLeyesAux["01"][1]="H2O";
	$ArrLeyesAux["01"][2]="1";
	$ArrLeyesAux["01"][3]="100";
	$ArrLeyesAux["01"][5]=2;
	$ArrLeyes["01"][0]="01";
	$Datos=explode('//',$TxtCodLeyes);
	$ContLeyes=0;
	foreach($Datos as $c => $v)
	{
		$ContLeyes++;
		$Datos2=explode('~',$v);
		$ArrLeyesAux[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
		$ArrLeyesAux[$Datos2[0]][1]=$Datos2[1];//NOMBRE LEY
		$ArrLeyesAux[$Datos2[0]][2]=$Datos2[2];//CODIGO UNIDAD
		$ArrLeyesAux[$Datos2[0]][3]=$Datos2[3];//CONVERSION	
		$ArrLeyesAux[$Datos2[0]][4]=$Datos2[4];//NOMBRE UNIDAD
		if ($ArrLeyesAux[$Datos2[0]][2]==1)
			$ArrLeyesAux[$Datos2[0]][5]=2;// 02 DECIMALES a los porcentajes (%)
		else
			$ArrLeyesAux[$Datos2[0]][5]=$Datos2[5];//DECIMALES
		$ArrLeyes[$Datos2[0]][0]=$Datos2[0];
		if(intval($Datos2[0])>5)
			$HayImpurezas=true;
	}
?>
<html>
<head>
<title>AGE-Resumen Recepcion Lotes Comercial</title>
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
			f.action = "age_con_resumen_recepcion_lotes_comercial.php";
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
      <td height="30" colspan="2"><strong><u>INFORME RECEPCION POR LOTES COMERCIAL</u></strong></td>
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
	$ColSpan=3+($ContLeyes*2);
	reset($ArrLeyes);
	foreach($ArrLeyes as $c=>$v)
	{
		if($c!='01')
			$ColSpan=$ColSpan+1;
	}
	echo "<table width=\"600\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,4,'0') as orden ,recepcion ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
	if ($CmbRecepcion!='S')
		$Consulta.= " and t1.cod_recepcion= '$CmbRecepcion' ";
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
		echo "<td align=\"center\" rowspan=\"2\">F.Recep.</td>\n";		
		echo "<td align=\"center\" rowspan=\"2\">P.Seco.<br>(Kg)</td>\n";
		echo "<td align=\"center\" rowspan=\"2\">N.Anodos</td>\n";
		echo "<td align=\"center\" rowspan=\"2\">Objetados</td>\n";
		echo "<td align=\"center\" rowspan=\"2\">Rechazados</td>\n";
		if ($OptLeyes=="S")
			echo "<td align=\"center\" colspan=\"4\">Leyes</td>\n";
		if($OptLeyes=="S" && $HayImpurezas==true)		
			echo "<td align=\"center\" colspan=\"".($ContLeyes-3)."\">Impurezas</td>\n";
		if ($OptFinos=="S")
			echo "<td align=\"center\" colspan=\"3\">Fino Ley</td>\n";
		if($OptFinos=="S" && $HayImpurezas==true)		
			echo "<td align=\"center\" colspan=\"".($ContLeyes-3)."\">Fino Impurezas</td>\n";
		echo "</tr>";
		echo "<tr class=\"ColorTabla02\">\n";
		if ($OptLeyes=="S")
		{
			echo "<td align=\"center\">Hum<br>(%)</td>\n";
			reset($ArrLeyesAux);
			foreach($ArrLeyesAux as $c=>$v)
			{
				if($c!='01')
					echo "<td align=\"center\">".$v[1]."<br>(".$v[4].")</td>\n";
			}
		}
		//echo "<td align=\"center\">P.Seco<br>(Kg)</td>\n";
		if ($OptFinos=="S")
		{
			
			reset($ArrLeyesAux);
			foreach($ArrLeyesAux as $c=>$v)
			{
				switch ($c)
				{
					case "02":
						$Unidad="Kg";
						break;
					case "04":
						$Unidad="g/t";
						break;
					case "05":
						$Unidad="g/t";
						break;
					default:
						$Unidad="Kg";
						break;
				}
				if($c!='01')
					echo "<td align=\"center\">".$v[1]."<br>(".$Unidad.")</td>\n";
			}
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
		if ($CmbRecepcion!='S')
			$Consulta.= " and t1.cod_recepcion= '".$CmbRecepcion."' ";
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		$Consulta.= " order by t1.cod_recepcion ";
		//echo $Consulta."<br>";
		$RutPrv2='';
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
				$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
				$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion ";		
				$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
				$Consulta.= " on t1.lote = t2.lote ";			
				$Consulta.= " where t1.cod_producto = '".$Fila01["cod_producto"]."' ";
				$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
				$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
				$Consulta.= " and t1.rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
				$Consulta.= " and t1.cod_recepcion = '".$FilaAux["cod_recepcion"]."' ";					
				$Consulta.= " and t1.estado_lote <>'6' group by t1.lote order by t1.lote, orden";
				$RespLote = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					echo "<tr>";
					echo "<td align=\"center\">".$FilaLote["lote"]."</td>";
					echo "<td align=\"center\">".substr($FilaLote["fecha_recepcion"],8,2)."/".substr($FilaLote["fecha_recepcion"],5,2)."/".substr($FilaLote["fecha_recepcion"],0,4)."</td>";
					$DatosLote= array();
					reset($ArrLeyes);
					$DatosLote["lote"]=$FilaLote["lote"];
					LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S",$TxtFechaIni,$TxtFechaFin,"");
					$PesoLoteS=$DatosLote["peso_seco"];
					$PesoLoteH=$DatosLote["peso_humedo"];
					$CantDecPeso=0;$CantDecLF=0;
					if($Fila01["recepcion"]=='PMN')
					{
						$CantDecPeso=4;$CantDecLF=0;
					}
					echo "<td align=\"right\">".number_format($PesoLoteS,0,',','.')."</td>";
					echo "<td align=\"right\">".number_format($NumAnodos,0,',','.')."</td>";
					echo "<td align=\"right\">".number_format($Objetados,0,',','.')."</td>";
					echo "<td align=\"right\">".number_format($Rechazados,0,',','.')."</td>";
					//LEYES
					if ($OptLeyes == "S")
					{
						reset($ArrLeyes);
						foreach($ArrLeyes as $c=>$v)
						{
							if($c!='')
							{
								if($c!='01')
									if($v[10]=='S')
										echo "<td align=\"right\">".number_format((($v[9]*$ArrLeyesAux[$c][3])/$PesoLoteS),$ArrLeyesAux[$c][5],',','.')."</td>\n";
									else
										echo "<td align=\"right\">".number_format((($v[23]*$ArrLeyesAux[$c][3])/$PesoLoteS),$ArrLeyesAux[$c][5],',','.')."</td>\n";
								else
									echo "<td align=\"right\">".number_format($v[2],$ArrLeyesAux[$c][5],',','.')."</td>\n";
							}		
						}
					}										
					if ($OptFinos == "S")
					{
						//FINOS
						reset($ArrLeyes);
						foreach($ArrLeyes as $c=>$v)
						{
							if($c!='')
							{
								if ($OptFinos == "S")
									if($c!='01')
										if($v[10]=='S')
											echo "<td align=\"right\">".number_format((($v[8]/$ArrLeyesAux[$c][3])*$PesoLoteS),0,',','.')."</td>\n";
										else
											echo "<td align=\"right\">".number_format($v[23],0,',','.')."</td>\n";										
							}		
						}
					}
					reset($ArrLeyes);
					do {			 
						$key = key ($ArrLeyes);
						$ArrLeyes[$key][9] = "";
						$ArrLeyes[$key][10] = "";
						$ArrLeyes[$key][8] = "";
					} while (next($ArrLeyes));	
					echo "</tr>";						
				}
				//TOTAL PROVEEDOR
				echo "<tr class=\"Detalle01\">\n";
				echo "<td align=\"left\" colspan=\"2\">TOTAL ".$FilaAux["rut_proveedor"]."</td>";
				$ArrDatos=array();
				$ArrLeyesProv=array();
				reset($ArrLeyes);
				foreach($ArrLeyes as $c=>$v)
				{
					$ArrLeyesProv[$c][0]=$c;
				}
				reset($ArrLeyesProv);
				LeyesProveedor($FilaAux["cod_recepcion"],$FilaAux["rut_proveedor"],'1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProv,'N','S','S',$TxtFechaIni,$TxtFechaFin,"");
				$CantDecPeso=0;$CantDecLF=0;
				if($Fila01["recepcion"]=='PMN')
				{
					$CantDecPeso=4;$CantDecLF=0;
				}
				echo "<td align=\"right\">".number_format($ArrDatos["peso_seco"],0,',','.')."</td>";
				echo "<td align=\"right\">".number_format($NumAnodos,0,',','.')."</td>";
				echo "<td align=\"right\">".number_format($Objetados,0,',','.')."</td>";
				echo "<td align=\"right\">".number_format($Rechazados,0,',','.')."</td>";
				//LEYES
				if ($OptLeyes == "S")
				{
					reset($ArrLeyesProv);
					while(list($c,$v)=each($ArrLeyesProv))
					{
						if($c!='')
						{							
							if ($c=="01")
							{
								echo "<td align=\"right\">".number_format($v[2],2,',','.')."</td>\n";
							}
							else							
							{
								if ($c=="02" || $c=="04" || $c=="05")
									echo "<td align=\"right\">".number_format((($v[8]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
								else
									echo "<td align=\"right\">".number_format((($v[23]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
							}
						}														
					}
				}																
				//FINOS
				if ($OptFinos == "S")
				{
					reset($ArrLeyesProv);
					while(list($c,$v)=each($ArrLeyesProv))
					{
						if($c!='')
						{
							if ($OptFinos == "S")
								if($c!='01')
									echo "<td align=\"right\">".number_format($v[8],0,',','.')."</td>\n";
						}		
					}
				}
				reset($ArrLeyesProv);
				do {			 
					$key = key ($ArrLeyesProv);
					$ArrLeyesProv[$key][9] = "";
					$ArrLeyesProv[$key][10] = "";
					$ArrLeyesProv[$key][8] = "";
				} while (next($ArrLeyesProv));	
				
				echo "</tr>\n";
				$RutPrv=$RutPrv."'".$FilaAux["rut_proveedor"]."',";
				$RutPrv2=$RutPrv2."'".$FilaAux["rut_proveedor"]."',";
			}
			//TOTAL TIPO RECEPCION
			echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"2\">TOTAL&nbsp;".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
			$RutPrv=substr($RutPrv,0,strlen($RutPrv)-1);
			$RutPrv="(".$RutPrv.")";
			$ArrDatos=array();
			$ArrLeyesProd=array();
			reset($ArrLeyes);
			foreach($ArrLeyes as $c=>$v)
			{
				$ArrLeyesProd[$c][0]=$c;
			}
			reset($ArrLeyesProd);
			LeyesProducto('',$RutPrv,$FilaTipoRecep["cod_recepcion"],'1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProd,'N','S','S',$TxtFechaIni,$TxtFechaFin,"");
			$CantDecPeso=0;$CantDecLF=0;
			if($Fila01["recepcion"]=='PMN')
			{
				$CantDecPeso=4;$CantDecLF=0;
			}
			echo "<td align=\"right\">".number_format($ArrDatos["peso_seco"],0,',','.')."</td>";	
			echo "<td align=\"right\">".number_format($NumAnodos,0,',','.')."</td>";	
			echo "<td align=\"right\">".number_format($Objetados,0,',','.')."</td>";	
			echo "<td align=\"right\">".number_format($Rechazados,0,',','.')."</td>";	
			//LEYES
			if ($OptLeyes == "S")
			{
				reset($ArrLeyesProd);
				foreach($ArrLeyesProd as $c=>$v)
				{
					if($c!='')
					{					
						if ($c=="01")
						{
							echo "<td align=\"right\">".number_format($v[2],2,',','.')."</td>\n";
						}
						else							
						{
							if ($c=="02" || $c=="04" || $c=="05")
								echo "<td align=\"right\">".number_format((($v[8]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
							else
								echo "<td align=\"right\">".number_format((($v[23]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
						}
					}
				}
			}					
			//FINOS
			if ($OptFinos == "S")
			{
				reset($ArrLeyesProd);
				foreach($ArrLeyesProd as $c=>$v)
				{
					if($c!='')
					{
						if ($OptFinos == "S")
							if($c!='01')
								echo "<td align=\"right\">".number_format($v[8],0,',','.')."</td>\n";
					}		
				}
			}
			echo "</tr>\n";
		}//FIN TIPO RECEPCION
		//TOTAL PRODUCTO
		echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"2\">TOTAL: ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($NomSubProd)."</td>\n";
		reset($ArrLeyes);
		do {			 
			$k = key ($ArrLeyes);			
			$ArrLeyes[$k][2] = "";
			$ArrLeyes[$k][8] = "";
			$ArrLeyes[$k][9] = "";
			$ArrLeyes[$k][10] = "";
		} while (next($ArrLeyes));	
		$ArrDatos=array();
		$RutPrv2=substr($RutPrv2,0,strlen($RutPrv2)-1);
		$RutPrv2="(".$RutPrv2.")";
		$ArrDatos=array();
		$ArrLeyesProd2=array();
		reset($ArrLeyes);
		foreach($ArrLeyes as $c=>$v)
		{
			$ArrLeyesProd2[$c][0]=$c;
		}
		reset($ArrLeyesProd2);
		LeyesProducto('',$RutPrv2,'','1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProd2,'N','S','S',$TxtFechaIni,$TxtFechaFin,"");
		$CantDecPeso=0;$CantDecLF=0;
		if($Fila01["recepcion"]=='PMN')
		{
			$CantDecPeso=4;$CantDecLF=0;
		}
		echo "<td align=\"right\">".number_format($ArrDatos["peso_seco"],0,',','.')."</td>";
		echo "<td align=\"right\">".number_format($NumAnodos,0,',','.')."</td>";
		echo "<td align=\"right\">".number_format($Objetados,0,',','.')."</td>";
		echo "<td align=\"right\">".number_format($Rechazados,0,',','.')."</td>";
		//LEYES
		if ($OptLeyes == "S")
		{
			reset($ArrLeyesProd2);
			while(list($c,$v)=each($ArrLeyesProd2))
			{
				if($c!='')
				{					
					if ($c=="01")
					{
						echo "<td align=\"right\">".number_format($v[2],2,',','.')."</td>\n";
					}
					else							
					{
						if ($c=="02" || $c=="04" || $c=="05")
							echo "<td align=\"right\">".number_format((($v[8]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
						else
							echo "<td align=\"right\">".number_format((($v[23]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
					}
				}
			}
		}		
		//FINOS
		if ($OptFinos == "S")
		{
			reset($ArrLeyesProd2);
			while(list($c,$v)=each($ArrLeyesProd2))
			{
				if($c!='')
				{
					if ($OptFinos == "S")
						if($c!='01')
							echo "<td align=\"right\">".number_format($v[8],0,',','.')."</td>\n";
				}		
			}
		}
		echo "</tr>\n";	
	}//FIN PRODUCTOS
	echo "</table>\n";
	?>  
</form>
</body>
</html>