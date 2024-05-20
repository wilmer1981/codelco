<?php
	include("../principal/conectar_principal.php");
	include("../age_web/age_funciones.php");	
	
	$CmbMes         = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date('m');
	$CmbAno         = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbRecepcion   = isset($_REQUEST["CmbRecepcion"])?$_REQUEST["CmbRecepcion"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor   = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$ChkDetalle     = isset($_REQUEST["ChkDetalle"])?$_REQUEST["ChkDetalle"]:"";
	$TxtCodLeyes    = isset($_REQUEST["TxtCodLeyes"])?$_REQUEST["TxtCodLeyes"]:""; 

	$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	
	$var1 =0;
	$var2=0;
	$var3=0;
	$var4=0;
	$var5=0;
    $varseco = 0;
	$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
	$ContLeyes=0;
		
	$ArrLeyes=array();
	$ArrLeyesAux=array();
	$ArrTotalesPrv=array();
	$ArrTotalesAsig=array();
	$ArrTotalesProd=array();
	$Datos=explode('//',$TxtCodLeyes);
	$ExisteAgua="N";
	foreach($Datos as $c => $v)
	{
		$Datos2=explode('~',$v);
		if($Datos2[0]!='')
		{
			//echo $Datos2[0]." / ".$Datos2[1]." / ".$Datos2[3]." / ".$Datos2[4]."<br>";
			$ArrLeyesAux[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
			$ArrLeyesAux[$Datos2[0]][1]=$Datos2[1];//NOMBRE LEY
			$ArrLeyesAux[$Datos2[0]][2]=$Datos2[2];//LIMITE MINIMO
			$ArrLeyesAux[$Datos2[0]][3]=$Datos2[3];//LIMITE MEDIO
			$ArrLeyesAux[$Datos2[0]][4]=$Datos2[4];//LIMITE MAXIMO
			$ArrLeyesAux[$Datos2[0]][5]=$Datos2[5];//COD UNIDAD
		    $ArrLeyesAux[$Datos2[0]][6]=$Datos2[6];//CONVERSION
			$ArrLeyesAux[$Datos2[0]][7]=$Datos2[7];//NOMBRE UNIDAD
			$ArrLeyesAux[$Datos2[0]][8]=$Datos2[8];//DECIMALES
			
			$ArrLeyes[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
			$ArrLeyes[$Datos2[0]][1]=$Datos2[1];//NOMBRE LEY
			if($Datos2[0]=="01")
				$ExisteAgua="S";
			$ArrTotalesPrv[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
			$ArrTotalesPrv[$Datos2[0]][1]=0;//SUMA DOLARES
			$ArrTotalesAsig[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
			$ArrTotalesAsig[$Datos2[0]][1]=0;//SUMA DOLARES
			
			$ArrTotalesAsig[$Datos2[0]][2]=0;//SUMA peso seco poly
			
			$ArrTotalesProd[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
			$ArrTotalesProd[$Datos2[0]][1]=0;//SUMA DOLARES
			$ArrTotalesProd[$Datos2[0]][2]=0;//SUMA (PESO*LEY)
			$ArrTotalesProd[$Datos2[0]][3]=0;//SUMA PESO
			$ContLeyes=$ContLeyes+1;
		}	
	}
	if($ExisteAgua=="N")
	{
		$ArrLeyes["01"][0]="01";//CODIGO LEY
		$ArrLeyes["01"][1]="H2O";//NOMBRE LEY
	}

?>
<html>
<head>
<title>AGE-Penalidades</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
	
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 100 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
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
			f.action = "age_con_penalidades.php";
			f.submit();
			break;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
</style></head>


<body>
<form  name="frmPrincipal" action="" method="post">

  <table width="900" border="0" align="center">
    <tr>
      <td width="294">CODELCO CHILE<br>
        DIVISION VENTANAS       <br> </td>
      <td width="296" align="right">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><strong><u>INFORME PENALIDADES</u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="2">MES: <?php echo $CmbMes."-".$CmbAno; ?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir"   type="button"  id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  </table>  

  <br>
	<?php
	$ColSpan=3;
	reset($ArrLeyesAux);
	foreach($ArrLeyesAux as $c=>$v)
	{
		if($c!='')
			$ColSpan=$ColSpan+2;
	}
	echo "<table width=\"900\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
	//CONSULTA LOS TIPOS DE RECEPCION
	$Consulta = "select distinct t1.cod_recepcion, t3.nombre_subclase as desc_a";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase ='3104' and t1.cod_recepcion=t3.nombre_subclase ";
	$Consulta.= " where t1.lote<>'' ";
	$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
	if ($CmbRecepcion!='S')
		$Consulta.= " and t1.cod_recepcion= '".$CmbRecepcion."' ";
	if ($CmbSubProducto != "S")
	{
		$Consulta.= " and t1.cod_producto = '1' ";
		$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
	}
	if ($CmbProveedor != "S")
		$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
	$Consulta.= " order by t1.cod_recepcion ";
	//echo $Consulta."<br>";
	$RutPrv2='';
	$RespTipoRecep = mysqli_query($link, $Consulta);
	while ($FilaTipoRecep = mysqli_fetch_array($RespTipoRecep))
	{					
		//TITULO COD RECEPCION
		echo "<tr class='ColorTabla01' >\n";	
		if ($FilaTipoRecep["desc_a"] == "" || is_null($FilaTipoRecep["desc_a"]))
			echo "<td align=\"left\" colspan=\"".$ColSpan."\">&nbsp;</td>\n";				
		else
			echo "<td align=\"left\" colspan=\"".$ColSpan."\">".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";		
		echo "</tr>\n";
		reset($ArrTotalesAsig);
		do {			 
			$key = key ($ArrTotalesAsig);
			$ArrTotalesAsig[$key][1] = 0;
		} while (next($ArrTotalesAsig));	
		//TITULO						
		echo "<tr class=\"ColorTabla02\">\n";		
		if ($ChkDetalle=="L")
		{							
			echo "<td align=\"center\" rowspan=\"2\">Lote</td>\n";
			echo "<td align=\"center\" rowspan=\"2\">F.Recep.</td>\n";		
			echo "<td align=\"center\" rowspan=\"2\">P.Seco.<br>(Kg)</td>\n";
		}
		else
		{
			echo "<td align=\"center\" rowspan=\"2\" colspan=\"3\">Proveedor</td>\n";
		}
		echo "<td align=\"center\" colspan=\"".($ContLeyes*2)."\">Penalidades</td>\n";
		echo "</tr>";
		echo "<tr class=\"ColorTabla02\">\n";
		reset($ArrLeyesAux);
		foreach($ArrLeyesAux as $c=>$v)
		{
			if($c!='')
			{
				echo "<td align=\"center\">".$v[1]."(".$v[7].")</td>\n";
				echo "<td align=\"center\">(US$)</td>\n";
			}	
		}
		echo "</tr>\n";
		$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,4,'0') as orden ,recepcion ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto ";
		$Consulta.= " and t1.cod_subproducto=t3.cod_subproducto ";
		$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
		if ($CmbRecepcion!='S')
			$Consulta.= " and t1.cod_recepcion= '".$FilaTipoRecep["cod_recepcion"]."' ";
		if ($CmbSubProducto!="S")
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



                  $ResultadoH2O =0;
                   $TotalHumedo = 0;
                   $ResultadoAs = 0;
                   $TotalSeco1  = 0;
                   $TotalSeco = 0;
                   $ResultadoSb = 0;
                   $TotalSeco2  = 0;
                   $ResultadoZn =  0;
                   $TotalSeco3  =  0;
                   $ResultadoPb =  0;
                   $TotalSeco4  =  0;
                   $ResultadoCd =  0;
                   $TotalSeco6  =  0;
                   $ResultadoHg =  0;
                   $TotalSeco5  =  0;
                   $a=0;
                   $B=0;

			echo "<tr bgcolor=\"#CCCCCC\">\n";			
			$Consulta = "select * from proyecto_modernizacion.subproducto ";
			$Consulta.= "where cod_producto = '".$Fila01["cod_producto"]."' and cod_subproducto='".$Fila01["cod_subproducto"]."'";		
			$RespAux2 = mysqli_query($link, $Consulta);
			if ($FilaAux2 = mysqli_fetch_array($RespAux2))
				$NomSubProd = $FilaAux2["descripcion"];
			else
				$NomSubProd = "SIN IDENTIFICACION";		
			echo "<td align=\"left\" colspan=\"".$ColSpan."\">".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>";					
			echo "</tr>\n";
			reset($ArrTotalesProd);
			do {			 
				$key = key ($ArrTotalesProd);
				$ArrTotalesProd[$key][1] = 0;
				$ArrTotalesProd[$key][2] = 0;
				$ArrTotalesProd[$key][3] = 0;
			} while (next($ArrTotalesProd));
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
				$Consulta = "select rut_prv as RUTPRV_A, nombre_prv as NOMPRV_A";
				$Consulta.= " from sipa_web.proveedores ";
				$Consulta.= " where rut_prv = '".$RutAux."'";
				$RespProv = mysqli_query($link, $Consulta);	
				//echo $Consulta."<br>";ptoveedores
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$NomProveedor = $FilaProv["NOMPRV_A"];
				}		
				if ($ChkDetalle=="L")
				{		
					echo "<tr class=\"Detalle01\">\n";
					echo "<td align=\"left\" colspan=\"".$ColSpan."\">".$FilaAux["rut_proveedor"]."&nbsp;&nbsp;".substr(strtoupper($NomProveedor),0,30)."</td>\n";
					echo "</tr>\n";				
				}
				reset($ArrTotalesPrv);
				do {			 
					$key = key ($ArrTotalesPrv);
					$ArrTotalesPrv[$key][1] = 0;
				} while (next($ArrTotalesPrv));	
				//if ($CmbAno<2006)
				//{
					$CodLoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."000";
					$CodLoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";	
				/*}
				else
				{
					$CodLoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0000";
					$CodLoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";	
				}	*/
				//CONSULTA LOS LOTES
				$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
				$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion, t1.tipo_remuestreo ";		
				$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
				$Consulta.= " on t1.lote = t2.lote ";			
				$Consulta.= " where t1.cod_producto = '".$Fila01["cod_producto"]."' ";
				$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
				$Consulta.= " and t1.rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
				$Consulta.= " and t1.cod_recepcion = '".$FilaAux["cod_recepcion"]."' ";					
				//$Consulta.= " and (t1.estado_lote <>'6'  or (t1.estado_lote='6' and t1.mostrar_lote='S')) ";
				//$Consulta.= " and ((t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' and t1.tipo_remuestreo <>'A')  or (t1.tipo_remuestreo='A' and substring(t1.num_lote_remuestreo,1,3)='".substr($CodLoteIni,0,3)."'))";	
				$Consulta.= " and (t1.estado_lote <>'6'  or (t1.estado_lote='6' and t1.mostrar_lote='S')) ";
				$Consulta.= " and (t1.tipo_remuestreo <>'A'  or (t1.tipo_remuestreo='A' ";
				//if ($CmbAno<2006)
				$Consulta.= " and substring(t1.num_lote_remuestreo,1,3)='".substr($CodLoteIni,0,3)."'))";
				//else
					//$Consulta.= " and substring(t1.num_lote_remuestreo,1,4)='".substr($CodLoteIni,0,4)."'))";
				$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
				//$Consulta.= " and t1.lote='07040376'";
				$Consulta.= " group by t1.lote order by t1.lote, orden";
				
				$RespLote = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
    //$TotalSeco = 0;
				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					if ($ChkDetalle=="L")
					{
						echo "<tr>";
						echo "<td align=\"center\">".$FilaLote["lote"]."</td>";
						

						echo "<td align=\"center\">".substr($FilaLote["fecha_recepcion"],8,2)."/".substr($FilaLote["fecha_recepcion"],5,2)."/".substr($FilaLote["fecha_recepcion"],0,4)."</td>";
					}
					$DatosLote= array();
					
					reset($ArrLeyes);
					do {			 
						$key = key ($ArrLeyes);
						$ArrLeyes[$key][2] = "";	
						$ArrLeyes[$key][23] = "";					
					} while (next($ArrLeyes));
				
					reset($ArrLeyes);
					if ($FilaLote["tipo_remuestreo"]=="A")
					{						
						$TxtFechaIniAux=substr($FilaLote["fecha_recepcion"],0,4)."-".substr($FilaLote["fecha_recepcion"],5,2)."-01";
						$TxtFechaFinAux=substr($FilaLote["fecha_recepcion"],0,4)."-".substr($FilaLote["fecha_recepcion"],5,2)."-31";;
						$DatosLote["penalidades"]="S"; 
					}
					else
					{
						$TxtFechaIniAux=$TxtFechaIni;
						$TxtFechaFinAux=$TxtFechaFin;
					}
					//echo $TxtFechaIniAux." / ".$TxtFechaFinAux."<br>";
					 $DatosLote["lote"]=$FilaLote["lote"];
					
               // echo "lote original ".$DatosLote["lote"]."  ";	
         		    // print_r($ArrLeyes);
					// print_r($DatosLote);
					LeyesLote($DatosLote,$ArrLeyes,"N","S","S",$TxtFechaIniAux,$TxtFechaFinAux,"",$link);
					//print_r($ArrLeyes);
					//print_r($DatosLote);
					//echo "--".$ArrLeyes[08][2];
					//echo "--".$ArrLeyes[34][2];
					//echo "--".$ArrLeyes[58][2];
					//echo "lote".$DatosLote["lote"]."--".$ArrLeyes[08][2]." / ".$ArrLeyes[09][2];
					$PesoLoteS=$DatosLote["peso_seco"];
					//echo "Primer lote".$PesoLoteS;
					//echo $DatosLote["lote"]."-".$DatosLote["peso_seco"];
					$PesoLoteS2=$DatosLote["peso_seco2"];
					$PesoLoteH=$DatosLote["peso_humedo"];
     
					//$TotalSeco= 0;
					//echo "EE".$DatosLote["peso_humedo"];
					
					$CantDecPeso=0;$CantDecLF=0;
					if($Fila01["recepcion"]=='PMN')
					{
						$CantDecPeso=4;$CantDecLF=0;
					}	
					if ($ChkDetalle=="L")
					{
						echo "<td align=\"right\">".number_format($PesoLoteS,0,',','.')."</td>";
					}
						//echo "<br>s";
						//print_r($ArrLeyes);
					reset($ArrLeyes);
					foreach($ArrLeyes as $c=>$v)
					{			
				      
						if($c!=''&&$v[1]!=''&&$PesoLoteS>0)
						{							
							$Mostrar=true;

							if ($c=="01"&&$ExisteAgua=='N')
								$Mostrar=false;
							if($Mostrar==true)
							{	
								//echo "c".$c."<br>";
								if ($c=="01")
								{
									
									$FinoAux=$v[20]*$PesoLoteS/100;
									// COMENTADO POR INTELLEGO 31-07-2015
								//	$ValorPorc=round(($FinoAux*$ArrLeyesAux[$v[0]][6])/$PesoLoteS,4);
									$ValorPorc=($FinoAux*$ArrLeyesAux[$v[0]][6])/$PesoLoteS;
									$ValorPorcAux=($FinoAux*$ArrLeyesAux[$v[0]][6])/$PesoLoteS2;
								}
								else
								{
									//echo "entreeeee"."<br>";
									//echo $FilaLote["lote"]."<br>";
									//echo $v[23]."<br>";
									//echo $ArrLeyesAux[$v[0]][6]."<br>";
									//echo "Pesolote".$PesoLoteS."<br>";
									// COMENTADO POR INTELLEGO 31-07-2015
									$ValorPorc=($v[23]*$ArrLeyesAux[$v[0]][6])/$PesoLoteS;
									//echo "v23  ".$v[23]."<br>";
									//echo "arrleyesaux  ".$ArrLeyesAux[$v[0]][6]."<br>";
									//echo "pesolotes  ".$PesoLoteS."<br>";
									//echo "valor porc para diferencia  ".$ValorPorc."<br>";
									$ValorPorcAux=($v[23]*$ArrLeyesAux[$v[0]][6])/$PesoLoteS2;
								}
								if ($ChkDetalle=="L")
								{

									if ($c=="01")
										echo "<td align=\"right\">".number_format($v[20],4,',','.')."</td>\n";
									else
										echo "<td align=\"right\">".number_format($v[2],4,',','.')."</td>\n";
								}
								$Dif=$ValorPorc-$ArrLeyesAux[$v[0]][3];
								//echo "valorPOrc".$ValorPorc."<br>";
								//echo "Diferencia".$Dif."<br>";
								//echo "dato x".$ArrLeyesAux[$v[0]][3]."<br><br>";							
								if($ValorPorc>$ArrLeyesAux[$v[0]][3]&&$Dif>0)
								{
									if ($c=="01")
									{
										$PesoAux=$PesoLoteH; //PESO HUMEDO
									}
									else
									{
										$PesoAux=$PesoLoteS; //PESO SECO
										//echo "secodato ".$PesoAux.", ";
									}
									if($ArrLeyesAux[$v[0]][2]!='0')
										$Cant=$Dif/$ArrLeyesAux[$v[0]][2];
									$PesoSecoTon=$PesoAux/1000;
									//echo $Cant."*".$ArrLeyesAux[$v[0]][4]."*".$PesoSecoTon."<br>";
									 $ValorDolar=$Cant * $ArrLeyesAux[$v[0]][4]*$PesoSecoTon;
                                     
									if ($ChkDetalle=="L")
									{
										
											/*EXCEPCION DEBIDO QUE EL ARSENICO SE DISPARA Y GENERA PENALIDAD, 19-02-2016
										  Luis Adan Castillo - Intellego
											*/
										if($FilaLote["lote"]=='15120527' && $v[0]=='08') 
										{
											echo "<td align=\"right\">0</td>\n";
											$ValorDolar=0;
											
										}else
										{
										
										
										echo "<td align=\"right\" bgcolor='FFFF00' onMouseOver=\"JavaScript:muestra('".$Cont."');\" onMouseOut=\"JavaScript:oculta('".$Cont."');\">";
										echo "<div id='Txt".$Cont."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:140px'>\n";
										echo "<table width='240' border='1' cellpadding='2' cellspacing='0' class='TablaInterior'>";
										echo "<tr class='ColorTabla01'><td colspan=\"3\" align='center'><strong>".$v[1]."</strong></td></tr>";
										echo "<tr align='center'><td width='70'>Por Cada(".$ArrLeyesAux[$v[0]][7].")</td><td width='70'>Sobre(".$ArrLeyesAux[$v[0]][7].")</td><td width='70'>Penalidad(US$)</td></tr>";
										echo "<tr align='center' class='Detalle01'><td>".$ArrLeyesAux[$v[0]][2]."</td><td>".$ArrLeyesAux[$v[0]][3]."</td><td>".$ArrLeyesAux[$v[0]][4]."</td></tr>";
										echo "<tr align='center' class='Detalle01'><td>Cant:".$Cant."</td><td>PSeco(Ton):</td><td>".$PesoSecoTon."</td></tr>";
										echo "</table></div>".number_format($ValorDolar,2,",",".")."</td>\n";
										}
									}
									//echo $DatosLote["lote"]."-".$DatosLote["peso_seco"];
					  				//poly ver aqui lo repite echo $PesoLoteH;


                                       if ($ValorDolar > 0 && $v[1]=="H2O")
                                         {

                                       //  echo "prod".$Fila01["cod_subproducto"];
                                         //   echo  "---------".  $B = $B + ($DatosLote["peso_seco"] * $v[20]);"</br>";
                                           //  echo "----------".$a=$a + $DatosLote["peso_seco"];
                                          // echo "--".($DatosLote["peso_seco"]."--".$PesoLoteH);// * $v[20]);
                                         //  $ResultadoH2O = $ResultadoH2O + (($PesoLoteH * $v[20])/100);
                                             $ResultadoH2O = $ResultadoH2O + ($DatosLote["peso_seco"] * $v[20]);
                                           $TotalHumedo = $TotalHumedo + $DatosLote["peso_seco"];
                                           $TotalSeco = $TotalSeco +  $DatosLote["peso_seco"];

                                         }
                                          if ($ValorDolar > 0 && $v[1]=="As")
                                         {
                                           $ResultadoAs = $ResultadoAs + ($DatosLote["peso_seco"] * $v[2])/100;
                                           $TotalSeco1  =   $TotalSeco1 + $DatosLote["peso_seco"];
                                         }
                                         if ($ValorDolar > 0 && $v[1]=="Sb")
                                         {
                                           $ResultadoSb = $ResultadoSb + ($DatosLote["peso_seco"] * $v[2])/100;
                                           $TotalSeco2  =   $TotalSeco2 + $DatosLote["peso_seco"];
                                         }
                                         if ($ValorDolar > 0 && $v[1]=="Zn")
                                         {
                                            $ResultadoZn = $ResultadoZn + ($DatosLote["peso_seco"] * $v[2])/100;
                                            $TotalSeco3  =   $TotalSeco3 + $DatosLote["peso_seco"];
                                         }

                                        if ($ValorDolar > 0 && $v[1]=="Pb")
                                         {
                                           $ResultadoPb = $ResultadoPb + ($DatosLote["peso_seco"] * $v[2])/100;
                                           $TotalSeco4  =   $TotalSeco4 + $DatosLote["peso_seco"];
                                         }
                                        //echo $ValorDolar." ".$v[1]."<br>"; 
										if ($ValorDolar > 0 && $v[1]=="Cd")
                                         {
                                           $ResultadoCd = $ResultadoCd + ($DatosLote["peso_seco"] * $v[2])/100;
                                           $TotalSeco6  =   $TotalSeco6 + $DatosLote["peso_seco"];
                                         }
                                        if ($ValorDolar > 0 && $v[1]=="Hg")
                                         {
                                           $ResultadoHg = $ResultadoHg + ($DatosLote["peso_seco"] * $v[2])/100;
                                           $TotalSeco5  =   $TotalSeco5 + $DatosLote["peso_seco"];
                                         }
                                                       
									$Cont++;
									$ArrTotalesPrv[$v[0]][1]=$ArrTotalesPrv[$v[0]][1]+($ValorDolar);//SUMA DE DOLARES
									$ArrTotalesAsig[$v[0]][1]=$ArrTotalesAsig[$v[0]][1]+($ValorDolar);//SUMA DE DOLARES
									$ArrTotalesProd[$v[0]][1]=$ArrTotalesProd[$v[0]][1]+($ValorDolar);//SUMA DE DOLARES
									$ArrTotalesProd[$v[0]][2]=$ArrTotalesProd[$v[0]][2]+($PesoLoteS);//SUMA DE DOLARES
									//Yo
									$ArrTotalesProd[$v[0]][3]=$ArrTotalesProd[$v[0]][3]+($PesoLoteH);//SUMA PESO HUMEDO
									//yo
									$ArrTotalesAsig[$v[0]][2]=$ArrTotalesAsig[$v[0]][2]+($PesoLoteS);//SUMA PESO SECO
									$ArrTotalesAsig[$v[0]][3]=$ArrTotalesAsig[$v[0]][3]+($PesoLoteH);//SUMA PESO HUMEDO
									if ($c=="01")
										$ArrTotalesProd[$v[0]][3]=$ArrTotalesProd[$v[0]][3]+(round($PesoLoteS)*round($v[20],4));//SUMA DE DOLARES
									else
										$ArrTotalesProd[$v[0]][3]=$ArrTotalesProd[$v[0]][3]+(round($PesoLoteS)*round($v[2],4));//SUMA DE DOLARES
								}	
								else
								{
									if ($ChkDetalle=="L")
									{
										echo "<td align=\"right\">0</td>\n";
									}
								}
							}
						}	
					}
					if ($ChkDetalle=="L")
					{
						echo "</tr>";						
					}
				}
				if ($ChkDetalle=="L")
				{
					echo "<tr class=\"Detalle01\">\n";				
					echo "<td align=\"left\" colspan=\"3\">TOTAL US$  :".$NomProveedor."</td>";
				}
				else
				{	
					echo "<tr>\n";				
					echo "<td align=\"left\" colspan=\"3\">".$NomProveedor."</td>";
				}
				reset($ArrTotalesPrv);
				foreach($ArrTotalesPrv as $c=>$v)
				{
					if($c!=''&&$v[0]!='')
					{

						echo "<td align=\"right\">&nbsp;</td>\n";
						//echo "<td align=\"right\">".number_format($v[1],2,",",".")."</td>\n";
						echo "<td align=\"right\">".number_format($v[1],2,",",".")."</td>\n";
					}				
				}
				echo "</tr>\n";
			}

			echo "<tr bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"3\">TOTAL US$ ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($NomSubProd)."</td>\n";

			reset($ArrTotalesProd);
			foreach($ArrTotalesProd as $c=>$v)			
			{
				if($c!=''&&$v[0]!='')
				{

					  if($v[1]!=0)
                      {
                        //    echo "####".$TotalSeco."#####".$TotalSeco2;
                           if($v[0] =="01")
                           {
                              $var1 =  ($ResultadoH2O / $TotalHumedo);//* 100;
                              $varseco =  $TotalSeco;
                           }
                           if($v[0] =="08")
                           {
                              $var1 = ($ResultadoAs / $TotalSeco1)* 100;
                              $varseco = $TotalSeco1;
                           }
                           if($v[0] =="09")
                           {
                              $var1 = ($ResultadoSb / $TotalSeco2)* 100;
                               $varseco = $TotalSeco2;
                           }
                           if($v[0] =="10")
                           {
                              $var1 =  ($ResultadoZn / $TotalSeco3)* 100;
                             $varseco = $TotalSeco3;
                           }
						   if ($v[0] =="34")
						   {
						   		$var1 = ($ResultadoHg / $TotalSeco5)* 100;
								$varseco = $TotalSeco5;
						   }
                           if($v[0] =="39")
                           {
                              $var1 = ($ResultadoPb /  $TotalSeco4)* 100;
                              $varseco = $TotalSeco4;
                           }
						   if ($v[0] =="58")
						   {
						   	  	$var1 = ($ResultadoCd / $TotalSeco6)* 100;
								$varseco = $TotalSeco6;
						   }

                          echo "<td align=\"center\"><strong>  Ley   ".number_format($var1,3,",",".")."</strong></td>\n";



                      }
			          else
                      {
                       	echo "<td align=\"right\">&nbsp;</td>\n";

                      }
                      

                      
                  echo "<td align=\"center\"><strong>  Dolar ".number_format($v[1],2,",",".")."</td>\n";   //dolar

				}
    

			}
			echo "</tr>\n";	

            echo "<tr bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"3\">PESO SECO </td>\n";
                    echo "<td align=\"center\"><strong>".number_format($TotalSeco,0,",",".")."</strong></td>\n";  //peso  seco
                 	if ($TotalSeco1 > 0)
					{
				    	echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco1,0,",",".")."</strong></td>\n";  //peso  seco
					}
					if ($TotalSeco2 > 0)
					{
                    	echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco2,0,",",".")."</strong></td>\n";  //peso  seco
					}
					if ($TotalSeco3 > 0)
					{
                    	echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco3,0,",",".")."</strong></td>\n";  //peso  seco
					}
					if ($TotalSeco5 > 0)
					{
	                    echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco5,0,",",".")."</strong></td>\n";  //peso  seco
					}
					if ($TotalSeco4 > 0)
					{
                    	echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco4,0,",",".")."</strong></td>\n";  //peso  seco
					}
					if ($TotalSeco6 > 0)
					{
	                    echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco6,0,",",".")."</strong></td>\n";  //peso  seco
					}
	                 echo "<td align=\"right\">&nbsp;</td>\n";
           echo "</tr>\n";

    }
		//FIN PRODUCTOS

		echo "<tr class=\"ColorTabla01\"><td align=\"left\" colspan=\"3\">TOTAL PESO VS VALOR US$ :".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
		
		
		reset($ArrTotalesAsig);
		foreach($ArrTotalesAsig as $c=>$v)
		{
			if($c!=''&&$v[0]!='')
			{
			
				//echo "<td align=\"right\">&nbsp;</td>\n";
				if ($c== 01)
				{
					echo "<td align=\"center\"><strong>P. Seco ".number_format($v[2])."</td>\n";
					echo "<td align=\"center\"><strong>  Dolar ".number_format($v[1],2,",",".")."</td>\n";

					//echo "<td align=\"right\">".number_format($v[1],2,",",".")."</td>\n";
				}
				else
				{
					
					echo "<td align=\"center\"><strong>P. Seco ".number_format($v[2])."</td>\n";
					echo "<td align=\"center\"><strong>  Dolar ".number_format($v[1],2,",",".")."</td>\n";
					//echo "<td align=\"right\">".number_format($v[1],2,",",".")."</td>\n";
				}

			}				
		}
		echo "</tr>\n";
		//echo $var1."--".$var2."--".$var3."--".$var4;
	}//FIN TIPO RECEPCION
	echo "</table>\n";

	?>  
</form>
</body>
</html>
