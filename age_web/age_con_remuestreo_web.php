<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	$Mostrar       = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$SubProducto   = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor     = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$Mes        = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano        = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");

?>
<html>
<head>
<title>Sistema de Agencia</title>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "S":
			f.action = "age_con_remuestreo.php";
			f.submit();
			break;
		case "I":
			window.print();
			break;				
	}	
}

function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<table width="500" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="2" class="ColorTabla02"><strong>COMPARACION REMUESTREO</strong></td>
        </tr>
        <tr>
          <td height="23" align="right">Periodo:</td>
          <td width="401"><?php echo strtoupper($Meses[$Mes-1])."/".$Ano; ?></td>
    </tr>
        <tr>
          <td height="23" align="right">Producto:</td>
          <td height="23"><?php
		  	if ($SubProducto=="S")
			{
				echo "TODOS";
			}
			else
			{
				$Consulta = "select cod_subproducto, descripcion ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " and cod_subproducto='".$SubProducto."' ";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					echo str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"]);
				}
				else
				{
					echo "&nbsp;";
				}
			}
			  ?></td>
        </tr>
        <tr>
          <td height="23" align="right">Proveedor:</td>
          <td height="23"><?php
			if ($Proveedor=="S")
			{
				echo "TODOS";
			}
			else
			{
				$Consulta = "select * from rec_web.proved ";
				$Consulta.= " where rutprv_a='".$Proveedor."' ";
				$Consulta.= " order by nomprv_a";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					echo str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".strtoupper($Fila["NOMPRV_A"]);
				}
				else
				{
					echo "&nbsp;";
				}
			}
			?></td>
        </tr>
        <tr align="center">
          <td height="30" colspan="2">              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
                <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td></tr>
  </table>        
      <br>
        <br>
        <table width="864" border="1" align="center" cellpadding="2" cellspacing="0">
<?php	
	if ($Ano<2006)
	{	
		$LoteIni = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."000";
		$LoteFin = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."999";
	}
	else
	{
		$LoteIni = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."0000";
		$LoteFin = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."9999";
	}
	//CONSULTA LOS DISTINTOS PRODUCTOS Y PROVEEDORES CON REMUESTREO="S"
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t1.rut_proveedor, t2.descripcion, t3.nomprv_a ";
	$Consulta.= " from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a";
	$Consulta.= " where t1.lote between '".$LoteIni."' and '".$LoteFin."' ";
	$Consulta.= " and t1.remuestreo ='S' ";
	if ($SubProducto!="S")
		$Consulta.= " and t1.cod_producto='1' and t1.cod_subproducto='".$SubProducto."'";
	if ($Proveedor!="S")
		$Consulta.= " and t1.rut_proveedor='".$Proveedor."'";		
	$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		Titulo($Fila["cod_subproducto"],$Fila["descripcion"],$Fila["rut_proveedor"],$Fila["nomprv_a"]);
		//CONSULTA RECARGOS CON REMUESTREO
		$Consulta = "select distinct t1.lote, t1.muestra_paralela, t1.remuestreo, t1.num_lote_remuestreo ";
		$Consulta.= " from age_web.lotes t1  ";
		$Consulta.= " where t1.lote  between '".$LoteIni."' and '".$LoteFin."' ";		
		$Consulta.= " and t1.remuestreo ='S' and t1.cod_producto='".$Fila["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto='".$Fila["cod_subproducto"]."' and t1.rut_proveedor='".$Fila["rut_proveedor"]."'";
		$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{			
			$Lote = $Fila2["num_lote_remuestreo"];
			$LoteNuevo = $Fila2["lote"];
			$Consulta = "select * ";
			$Consulta.= " from age_web.lotes ";
			$Consulta.= " where lote='".$Lote."' ";		
			$Resp3 = mysqli_query($link, $Consulta);			
			$M_Paralela="";
			if ($Fila3 = mysqli_fetch_array($Resp3))
				$M_Paralela=$Fila3["muestra_paralela"];
			$Cu_Pri=0;
			$Ag_Pri=0;
			$Au_Pri=0;
			$Cu_Par=0;
			$Ag_Par=0;
			$Au_Par=0;
			$SA_Pri="";
			$RecPri="";
			$SA_Par="";
			$Rec_Par="";
			//echo $Lote." - ".$M_Paralela."<br>";
			Leyes($Lote,$M_Paralela,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Par,$Ag_Par,$Au_Par,$SA_Pri,$Rec_Pri,$SA_Par,$Rec_Par,$Ano,$link);						
			$Cu_Dif=0;
			$Ag_Dif=0;
			$Au_Dif=0;
			$Cu_Dif=$Cu_Pri-$Cu_Par;
			$Ag_Dif=$Ag_Pri-$Ag_Par;
			$Au_Dif=$Au_Pri-$Au_Par;
			$Valores = $Fila2["lote"]."~~".$Fila2["recargo"];
			echo "<tr align=\"center\">\n";
			echo "<td><a href=\"JavaScript:Historial('".$SA_Pri."','".$Rec_Pri."')\">".$Fila2["num_lote_remuestreo"]."</a></td>\n";
			echo "<td align=\"right\">".number_format($Cu_Pri,2,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($Ag_Pri,2,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($Au_Pri,2,",",".")."</td>\n";
			echo "<td><a href=\"JavaScript:Historial('".$SA_Par."','".$Rec_Par."')\">".$M_Paralela."</a></td>\n";
			if ($Cu_Par!="")
				echo "<td align=\"right\">".number_format($Cu_Par,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Ag_Par!="")
				echo "<td align=\"right\">".number_format($Ag_Par,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Au_Par!="")
				echo "<td align=\"right\">".number_format($Au_Par,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Cu_Par!="")
				echo "<td align=\"right\">".number_format(abs($Cu_Dif),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Ag_Par!="")
				echo "<td align=\"right\">".number_format(abs($Ag_Dif),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Au_Par!="")
				echo "<td align=\"right\">".number_format(abs($Au_Dif),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			$Cu_Rem=0;
			$Ag_Rem=0;
			$Au_Rem=0;
			$SA_Rem="";
			$Rec_Rem="";
			//echo $Lote." - ".$M_Paralela."<br>";
			Leyes($LoteNuevo,"",$Cu_Rem,$Ag_Rem,$Au_Rem,$Cu_Par,$Ag_Par,$Au_Par,$SA_Rem,$Rec_Rem,$SA_Par,$Rec_Par,$Ano,$link);						
			$Cu_Dif_Rem=0;
			$Ag_Dif_Rem=0;
			$Au_Dif_Rem=0;
			$Cu_Dif_Rem=$Cu_Rem-$Cu_Pri;
			$Ag_Dif_Rem=$Ag_Rem-$Ag_Pri;
			$Au_Dif_Rem=$Au_Rem-$Au_Pri;

			echo "<td><a href=\"JavaScript:Historial('".$SA_Rem."','".$Rec_Rem."')\">".$LoteNuevo."</a></td>\n";
			if ($Cu_Rem!="")
				echo "<td align=\"right\">".number_format($Cu_Rem,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Ag_Rem!="")
				echo "<td align=\"right\">".number_format($Ag_Rem,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Au_Rem!="")
				echo "<td align=\"right\">".number_format($Au_Rem,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Cu_Pri!="" && $Cu_Rem!="")
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">".number_format(abs($Cu_Dif_Rem),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
			if ($Ag_Pri!="" && $Ag_Rem!="")
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">".number_format(abs($Ag_Dif_Rem),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
			if ($Au_Pri!="" && $Au_Rem!="")
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">".number_format(abs($Au_Dif_Rem),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
			echo "</tr>\n";
		}
	}


function Titulo($Prod, $NomProd, $Proved, $NomProved)
{
	echo "<tr class=\"ColorTabla02\">\n";
	echo "<td colspan=\"6\">Producto:&nbsp;".str_pad($Prod,2,'0',STR_PAD_LEFT)."-".strtoupper($NomProd)."</td>\n";
	echo "<td colspan=\"12\">Proveedor:&nbsp;".str_pad($Proved,10,'0',STR_PAD_LEFT)."-".strtoupper($NomProved)."</td>\n";
	echo "</tr>\n";
	echo "<tr align=\"center\" class=\"ColorTabla01\">\n";
	echo "<td width=\"40\" rowspan=\"2\">Lote</td> \n";
	echo "<td colspan=\"3\">Paquete Primero</td>\n";
	echo "<td width=\"57\" rowspan=\"2\">Paralela</td>\n";
	echo "<td colspan=\"3\">Muestra Paralela</td>\n";
	echo "<td colspan=\"3\">Diferencia</td>\n";
	echo "<td width=\"57\" rowspan=\"2\">Remuestreo</td>\n";
	echo "<td colspan=\"3\">Remuestreo</td>\n";
	echo "<td colspan=\"3\">Paq.Pri v/s Rem.</td>\n";
	echo "</tr>\n";
	echo "<tr class=\"ColorTabla01\" align=\"center\">\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "</tr>\n";
}//FIN FUNCION TITULO
function Leyes($Lote,$MuestraParalela,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Par,$Ag_Par,$Au_Par,$SA_Pri,$Rec_Pri,$SA_Par,$Rec_Par,$Ano,$link)
{
	//LEYES DEL PAQUETE PRIMERO
	$DatosLote= array();
	$ArrLeyes=array();
	$DatosLote["lote"]=$Lote;
	LeyesLote($DatosLote,$ArrLeyes,"N","S","S","","","",$link);
	$PesoLote=$DatosLote["peso_seco"];
	$Cu_Pri=$ArrLeyes["02"][2];
	$Ag_Pri=$ArrLeyes["04"][2];
	$Au_Pri=$ArrLeyes["05"][2];
	//BUSCA DATOS MUESTRA PARALELA
	$Consulta="select * from cal_web.solicitud_analisis where id_muestra='".$MuestraParalela."' and tipo=4 and recargo='R' and year(fecha_muestra)='".$Ano."'";
	//echo $Consulta;
	$Respuesta=mysqli_query($link, $Consulta);
	if($FilaLeyes=mysqli_fetch_array($Respuesta))
	{
		$PesoMuestra=$FilaLeyes["peso_muestra"];
		$PesoRetalla=$FilaLeyes["peso_retalla"];
	}
	$Consulta="select * from age_web.leyes_por_lote where lote='".$MuestraParalela."' and recargo='0' and cod_leyes in('02','04','05') and ano='".$Ano."'";
	$Cu_Par=0;
	$Ag_Par=0;
	$Au_Par=0;
	$Respuesta=mysqli_query($link, $Consulta);
	while($FilaLeyes=mysqli_fetch_array($Respuesta))
	{
		switch ($FilaLeyes["cod_leyes"])
		{
			case "02":
				$Cu_Par=$FilaLeyes["valor"];
				break;
			case "04":
				$Ag_Par=$FilaLeyes["valor"];
				break;
			case "05":
				$Au_Par=$FilaLeyes["valor"];
				break;
		}						
	}
	$Consulta = "select distinct t1.cod_leyes, t1.valor, t2.abreviatura as nom_unidad, t2.conversion";
	$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad ";
	$Consulta.= " where t1.lote='".$MuestraParalela."' ";
	$Consulta.= " and t1.recargo='R' and ano='".$Ano."'";	
	$Consulta.= " order by t1.cod_leyes";
	//echo $Consulta."<br>";
	$RespLeyes = mysqli_query($link, $Consulta);
	while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
	{									
		//CALCULA LA LEY INCLUYENDO INCIDENCIA DE LA RETALLA
		switch ($FilaLeyes["cod_leyes"])
		{
			case "02":
				if ($PesoRetalla>0 && $PesoMuestra>0 && $FilaLeyes["valor"]>0)
					$IncRetalla = ($FilaLeyes["valor"] - $Cu_Par) * ($PesoRetalla/$PesoMuestra);  //VALOR
				else
					$IncRetalla = 0;  //VALOR					
				$Cu_Par=$Cu_Par + $IncRetalla;
				break;
			case "04":
				if ($PesoRetalla>0 && $PesoMuestra>0 && $FilaLeyes["valor"]>0)
					$IncRetalla = ($FilaLeyes["valor"] - $Ag_Par) * ($PesoRetalla/$PesoMuestra);  //VALOR
				else
					$IncRetalla = 0;  //VALOR
				$Ag_Par=$Ag_Par + $IncRetalla;
				break;
			case "05":
				if ($PesoRetalla>0 && $PesoMuestra>0 && $FilaLeyes["valor"]>0)
					$IncRetalla = ($FilaLeyes["valor"] - $Au_Par) * ($PesoRetalla/$PesoMuestra);  //VALOR
				else
					$IncRetalla = 0;  //VALOR						
				$Au_Par=$Au_Par + $IncRetalla;
				break;
		}						
	}
	
	//CONSULTA LA S.A. PAQUETE PRIMERO
	$Consulta = "select distinct t1.id_muestra,t1.nro_solicitud, t1.recargo ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.id_muestra='".$Lote."' and t1.agrupacion in(1,3,6,99)";// and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProducto'";
	if($Recargo=='')
		$Consulta.= " and (t1.recargo='0' or t1.recargo='')";
	else
		$Consulta.= " and t1.recargo='".$Recargo."'";	
	//echo $Consulta;
	$RespSA=mysqli_query($link, $Consulta);
	if($FilaSA=mysqli_fetch_array($RespSA))
	{
		$SA_Pri=$FilaSA["nro_solicitud"];
		$Rec_Pri=$FilaSA["recargo"];
	}
	//CONSULTA LA S.A. MUESTRA PARALELA
	$Consulta = "select distinct t1.id_muestra,t1.nro_solicitud, t1.recargo ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.id_muestra='".$MuestraParalela."' and t1.agrupacion in(1,3,6,99) and tipo='4' and year(fecha_muestra)='".$Ano."'";// and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProducto'";
	if($Recargo=='')
		$Consulta.= " and (t1.recargo='0' or t1.recargo='')";
	else
		$Consulta.= " and t1.recargo='".$Recargo."'";	
	//echo $Consulta;
	$RespSA=mysqli_query($link, $Consulta);
	if($FilaSA=mysqli_fetch_array($RespSA))
	{
		$SA_Par=$FilaSA["nro_solicitud"];
		$Rec_Par=$FilaSA["recargo"];
	}
	
}

?>
</table>
</form>
</body>
</html>
