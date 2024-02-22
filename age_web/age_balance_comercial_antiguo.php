<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 83;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");	
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script> 
<script language="JavaScript">
function DetallePrv(Opcion,Prod,SubPro,RutPrv,FechaIni,FechaFin)
{
	window.open("age_detalle_balance_prv.php?Opcion="+Opcion+"&Producto="+Prod+"&SubProducto="+SubPro+"&RutPrv="+RutPrv+"&FechaIni="+FechaIni+"&FechaFin="+FechaFin,"","top=60,left=0,width=770,height=385,scrollbars=yes,resizable = yes");			
}
function Proceso(Proceso)
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var Resp="";
	
	switch (Proceso)
	{
		case "B"://CONSULTAR
			Frm.action='age_balance_comercial.php?Proceso=B&Mostrar=S';
			Frm.submit();		
			break;
		case "E"://EXCEL
			Frm.action='age_balance_comercial_excel.php?Proceso=B&Mostrar=S';
			Frm.submit();		
			break;
		case "I"://IMPRIMIR			
			window.print();
			break;
		case "R"://RECARGA
			Frm.action='age_balance_comercial.php';
			Frm.submit();		
			break;
		case "S"://SALIR
			Frm.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=80&Nivel=1";
			Frm.submit();
			break;
	} 
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmPrincipal" action="" method="post">
<?php //include("../principal/encabezado.php") ?>
<input type="hidden" name="Valores" value="">
    <table width="1000" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr align="center">
        <td height="23" colspan="6" class="Detalle02"><strong>BALANCE COMERCIAL</strong></td>
      </tr>
      <tr>
        <td width="102" height="23" class="Colum01">SubProducto:</td>
        <td width="879" height="23"><select name="SubProducto" style="width:300" onChange="Proceso('R')">
          <option class="NoSelec" value="S">TODOS</option>
          <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($SubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
        </select></td>
      </tr>
      <tr>
        <td width="102" height="23" class="Colum01">Proveedor:</td>
        <td width="879" height="23"><select name="Proveedor" style="width:300">
          <option class='NoSelec' value='S'>TODOS</option>
          <?php
				if (isset($SubProducto) && $SubProducto != "S")
				{
					$Consulta = "select t1.RUTPRV_A, t1.NOMPRV_A ";
					$Consulta.= " from rec_web.proved t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rutprv_a = t2.rut_proveedor inner join proyecto_modernizacion.subproducto t3 ";
					$Consulta.= " on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
					$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";								
					$Consulta.= " order by trim(t1.nomprv_a)";		
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						if ($Proveedor == $Fila["RUTPRV_A"])
							echo "<option selected value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
						else
							echo "<option value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
					}
				}
			?>
        </select></td>
      </tr>
      <tr>
        <td height="23" class="Colum01">Periodo:</td>
        <td height="23" colspan="3"><select name="Mes" id="Mes">
		<?php
		for ($i=1;$i<=12;$i++)
		{
			if (!isset($Mes))
			{
				if ($i==date("n"))
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
			else
			{
				if ($i==$Mes)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
		}
		?>
        </select>
        <select name="Ano" id="Ano">
		<?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (!isset($Ano))
			{
				if ($i==date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i==$Ano)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select></td>
      </tr>
      <tr>
        <td height="23" colspan="6" align="center" class="Detalle02">
		<input name="BtnConsultar" type="button" style="width:70px;" onClick="Proceso('B')" value="Consultar">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:80px " onClick="Proceso('I')">
        <input name="BtnGrabar" type="button" style="width:70px;" onClick="Proceso('E')" value="Excel" disabled>
		<input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="JavaScript:Proceso('S')"></td>
      </tr>
    </table>
    <br>
      <table width="1000" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr align="center" class="ColorTabla01">
		<td>&nbsp;</td>
		<td colspan="3">Leyes(Pqte1)</td>
		<td colspan="3">Leyes Provisionales/Canje</td>
		<td colspan="2">Pesos(Kg)</td>
		<td colspan="3">Ajuste</td>
		</tr>
		<tr align="center" class="ColorTabla01">
          <td width="200">Proveedor</td>
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
		$FechaFinAnoAnt = $AnoAux."-".$MesAux."-31";
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
				//PROVISIONALES MES ANTERIOR
				echo "<tr class='Detalle02'>\n";
				echo "<td colspan='12' align='center'>PROVISIONALES MES ANTERIOR</td>\n";	
				echo "</tr>\n";
				$Consulta="select distinct t1.rut_proveedor,t2.NOMPRV_A as nom_prv from age_web.lotes t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A ";				
				$Consulta.="inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional = 'S' where t1.fecha_recepcion between '$FechaIniMesAnt' and '$FechaFinAnoAnt' ";
				$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
				$Consulta.= "order by t2.NOMPRV_A ";
				//echo $Consulta."<br>";
				$RespProv = mysqli_query($link, $Consulta);
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$Consulta="select distinct t1.lote from age_web.lotes t1 inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional = 'S' ";				
					$Consulta.="where t1.rut_proveedor ='".$FilaProv["rut_proveedor"]."' and t1.fecha_recepcion between '$FechaIniMesAnt' and '$FechaFinAnoAnt' ";
					$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
					//echo $Consulta."<br>";
					$RespLotes = mysqli_query($link, $Consulta);
					$Cu_Fino_Ajuste=0;$Ag_Fino_Ajuste=0;$Au_Fino_Ajuste=0;$Cu_Ley_Pqt1=0;$Ag_Ley_Pqt1=0;$Au_Ley_Pqt1=0;$Cu_Ley_Ajus=0;$Ag_Ley_Ajus=0;$Au_Ley_Ajus=0;$PesoHumProv=0;$PesoSecoProv=0;
					while ($FilaLote=mysqli_fetch_array($RespLotes))
					{
						$DatosLote= array();
						$ArrLeyes=array();
						$DatosLote["lote"]=$FilaLote[lote];
						LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
						$Cu_Fino_Ajuste=$Cu_Fino_Ajuste+(($ArrLeyes["02"][2]-$ArrLeyes["02"][7])*$DatosLote["peso_seco"])/100;
						$Cu_Ley_Pqt1=$Cu_Ley_Pqt1+($ArrLeyes["02"][2]*$DatosLote["peso_seco"])/100;
						$Cu_Ley_Ajus=$Cu_Ley_Ajus+($ArrLeyes["02"][7]*$DatosLote["peso_seco"])/100;
						$Ag_Fino_Ajuste=$Ag_Fino_Ajuste+(($ArrLeyes["04"][2]-$ArrLeyes["04"][7])*$DatosLote["peso_seco"])/1000;
						$Ag_Ley_Pqt1=$Ag_Ley_Pqt1+($ArrLeyes["04"][2]*$DatosLote["peso_seco"])/1000;
						$Ag_Ley_Ajus=$Ag_Ley_Ajus+($ArrLeyes["04"][7]*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Ajuste=$Au_Fino_Ajuste+(($ArrLeyes["05"][2]-$ArrLeyes["05"][7])*$DatosLote["peso_seco"])/1000;
						$Au_Ley_Pqt1=$Au_Ley_Pqt1+($ArrLeyes["05"][2]*$DatosLote["peso_seco"])/1000;
						$Au_Ley_Ajus=$Au_Ley_Ajus+($ArrLeyes["05"][7]*$DatosLote["peso_seco"])/1000;
						$PesoHumProv=$PesoHumProv+$DatosLote["peso_humedo"];
						$PesoSecoProv=$PesoSecoProv+$DatosLote["peso_seco"];
					}
					echo "<tr>\n";
					echo "<td><a href=JavaScript:DetallePrv('PMA','$FilaProd["cod_producto"]','$FilaProd["cod_subproducto"]','$FilaProv["rut_proveedor"]','$FechaIniMesAnt','$FechaFinAnoAnt')>".strtoupper(substr($FilaProv["nom_prv"],0,20))."</a></td>\n";		
					echo "<td align='center'>".number_format(($Cu_Ley_Pqt1*100)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Ag_Ley_Pqt1*1000)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Au_Ley_Pqt1*1000)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Cu_Ley_Ajus*100)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Ag_Ley_Ajus*1000)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Au_Ley_Ajus*1000)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format($PesoHumProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($PesoSecoProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Cu_Fino_Ajuste,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Ag_Fino_Ajuste,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Au_Fino_Ajuste,0,'','.')."</td>\n";
					echo "</tr>\n";
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PRV"]=strtoupper(substr($FilaProv["nom_prv"],0,40));
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PH"]=$PesoHumProv;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PS"]=$PesoSecoProv;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["02"]=$Cu_Fino_Ajuste;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["04"]=$Ag_Fino_Ajuste;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["05"]=$Au_Fino_Ajuste;
					$SubTotalPesoHumProd=$SubTotalPesoHumProd+$PesoHumProv;
					$SubTotalPesoSecoProd=$SubTotalPesoSecoProd+$PesoSecoProv;
					$SubTotalAjusteCuProd=$SubTotalAjusteCuProd+$Cu_Fino_Ajuste;
					$SubTotalAjusteAgProd=$SubTotalAjusteAgProd+$Ag_Fino_Ajuste;
					$SubTotalAjusteAuProd=$SubTotalAjusteAuProd+$Au_Fino_Ajuste;
				}
				//PAQUETE PRIMERO
				echo "<tr class='Detalle02' align='center'>\n";
				echo "<td colspan='12' align='center'>PAQUETE PRIMERO</td>\n";	
				echo "</tr>\n";
				$Consulta="select distinct t1.rut_proveedor,t2.NOMPRV_A as nom_prv from age_web.lotes t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A ";				
				$Consulta.="left join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional <> 'S' where t1.canjeable<>'S' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
				$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
				$Consulta.= "order by t2.NOMPRV_A ";
				//echo $Consulta."<br>";
				$RespProv = mysqli_query($link, $Consulta);
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$Consulta="select distinct t1.lote from age_web.lotes t1 left join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional <> 'S' ";				
					$Consulta.="where t1.canjeable<>'S' and t1.rut_proveedor ='".$FilaProv["rut_proveedor"]."' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
					$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
					//echo $Consulta."<br>";
					$RespLotes = mysqli_query($link, $Consulta);
					$PesoHumProv=0;$PesoSecoProv=0;$Cu_Fino_Ajuste=0;$Ag_Fino_Ajuste=0;$Au_Fino_Ajuste=0;$Cu_Fino_Pqte1=0;$Ag_Fino_Pqte1=0;$Au_Fino_Pqte1=0;$Cu_Ley_Ajus=0;$Ag_Ley_Ajus=0;$Au_Ley_Ajus=0;
					while ($FilaLote=mysqli_fetch_array($RespLotes))
					{
						$DatosLote= array();
						$ArrLeyes=array();
						$DatosLote["lote"]=$FilaLote[lote];
						LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
						$Cu_Fino_Ajuste='-';
						$Cu_Ley_Pqte1=$Cu_Fino_Pqte1+($ArrLeyes["02"][2]*$DatosLote["peso_seco"])/100;
						$Cu_Ley_Ajus='-';
						$Ag_Fino_Ajuste='-';
						$Ag_Ley_Pqte1=$Ag_Fino_Pqte1+($ArrLeyes["04"][2]*$DatosLote["peso_seco"])/1000;
						$Ag_Ley_Ajus='-';
						$Au_Fino_Ajuste='-';
						$Au_Ley_Pqte1=$Au_Fino_Pqte1+($ArrLeyes["05"][2]*$DatosLote["peso_seco"])/1000;
						$Au_Ley_Ajus='-';
						$PesoHumProv=$PesoHumProv+$DatosLote["peso_humedo"];
						$PesoSecoProv=$PesoSecoProv+$DatosLote["peso_seco"];
					}
					echo "<tr>\n";
					echo "<td><a href=JavaScript:DetallePrv('PQ1','$FilaProd["cod_producto"]','$FilaProd["cod_subproducto"]','$FilaProv["rut_proveedor"]','$FechaIni','$FechaFin')>".strtoupper(substr($FilaProv["nom_prv"],0,20))."</a></td>\n";	
					echo "<td align='center'>".number_format(($Cu_Ley_Pqte1*100)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Ag_Ley_Pqte1*1000)/$PesoSecoProv,3,',','.')."</td>\n";
					echo "<td align='center'>".number_format(($Au_Ley_Pqte1*1000)/$PesoSecoProv,3,',','.')."</td>\n";
					echo "<td align='center'>".$Cu_Ley_Ajus."</td>\n";
					echo "<td align='center'>".$Ag_Ley_Ajus."</td>\n";
					echo "<td align='center'>".$Au_Ley_Ajus."</td>\n";
					echo "<td align='center'>".number_format($PesoHumProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($PesoSecoProv,0,'','.')."</td>\n";
					echo "<td align='center'>".$Cu_Fino_Ajuste."</td>\n";
					echo "<td align='center'>".$Ag_Fino_Ajuste."</td>\n";
					echo "<td align='center'>".$Au_Fino_Ajuste."</td>\n";
					echo "</tr>\n";
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PRV"]=strtoupper(substr($FilaProv["nom_prv"],0,40));	
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PH"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PH"]+$PesoHumProv;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PS"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PS"]+$PesoSecoProv;
					$SubTotalPesoHumProd=$SubTotalPesoHumProd+$PesoHumProv;
					$SubTotalPesoSecoProd=$SubTotalPesoSecoProd+$PesoSecoProv;
					$SubTotalAjusteCuProd=$SubTotalAjusteCuProd+$Cu_Fino_Ajuste;
					$SubTotalAjusteAgProd=$SubTotalAjusteAgProd+$Ag_Fino_Ajuste;
					$SubTotalAjusteAuProd=$SubTotalAjusteAuProd+$Au_Fino_Ajuste;
				}
				//PROVISIONALES DEL MES
				echo "<tr class='Detalle02'>\n";
				echo "<td colspan='12' align='center'>PROVISIONALES DEL MES</td>\n";	
				echo "</tr>\n";
				$Consulta="select distinct t1.rut_proveedor,t2.NOMPRV_A as nom_prv from age_web.lotes t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A ";				
				$Consulta.="inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional = 'S' where t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
				$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
				$Consulta.= "order by t2.NOMPRV_A ";
				//echo $Consulta."<br>";
				$RespProv = mysqli_query($link, $Consulta);
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$Consulta="select distinct t1.lote from age_web.lotes t1 inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and provisional = 'S' ";				
					$Consulta.="where t1.rut_proveedor ='".$FilaProv["rut_proveedor"]."' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
					$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
					//echo $Consulta."<br>";
					$RespLotes = mysqli_query($link, $Consulta);
					$Cu_Fino_Ajuste=0;$Ag_Fino_Ajuste=0;$Au_Fino_Ajuste=0;$Cu_Ley_Pqt1=0;$Ag_Ley_Pqt1=0;$Au_Ley_Pqt1=0;$Cu_Ley_Ajus=0;$Ag_Ley_Ajus=0;$Au_Ley_Ajus=0;$PesoHumProv=0;$PesoSecoProv=0;
					while ($FilaLote=mysqli_fetch_array($RespLotes))
					{
						$DatosLote= array();
						$ArrLeyes=array();
						$DatosLote["lote"]=$FilaLote[lote];
						LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
						$Cu_Fino_Ajuste=$Cu_Fino_Ajuste+(($ArrLeyes["02"][2]-$ArrLeyes["02"][7])*$DatosLote["peso_seco"])/100;
						$Cu_Ley_Pqt1=$Cu_Ley_Pqt1+($ArrLeyes["02"][2]*$DatosLote["peso_seco"])/100;
						$Cu_Ley_Ajus=$Cu_Ley_Ajus+($ArrLeyes["02"][7]*$DatosLote["peso_seco"])/100;
						$Ag_Fino_Ajuste=$Ag_Fino_Ajuste+(($ArrLeyes["04"][2]-$ArrLeyes["04"][7])*$DatosLote["peso_seco"])/1000;
						$Ag_Ley_Pqt1=$Ag_Ley_Pqt1+($ArrLeyes["04"][2]*$DatosLote["peso_seco"])/1000;
						$Ag_Ley_Ajus=$Ag_Ley_Ajus+($ArrLeyes["04"][7]*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Ajuste=$Au_Fino_Ajuste+(($ArrLeyes["05"][2]-$ArrLeyes["05"][7])*$DatosLote["peso_seco"])/1000;
						$Au_Ley_Pqt1=$Au_Ley_Pqt1+($ArrLeyes["05"][2]*$DatosLote["peso_seco"])/1000;
						$Au_Ley_Ajus=$Au_Ley_Ajus+($ArrLeyes["05"][7]*$DatosLote["peso_seco"])/1000;
						$PesoHumProv=$PesoHumProv+$DatosLote["peso_humedo"];
						$PesoSecoProv=$PesoSecoProv+$DatosLote["peso_seco"];
					}
					echo "<tr>\n";
					echo "<td><a href=JavaScript:DetallePrv('PDM','$FilaProd["cod_producto"]','$FilaProd["cod_subproducto"]','$FilaProv["rut_proveedor"]','$FechaIni','$FechaFin')>".strtoupper(substr($FilaProv["nom_prv"],0,20))."</a></td>\n";	
					echo "<td align='center'>".number_format(($Cu_Ley_Pqt1*100)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Ag_Ley_Pqt1*1000)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Au_Ley_Pqt1*1000)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Cu_Ley_Ajus*100)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Ag_Ley_Ajus*1000)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Au_Ley_Ajus*1000)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format($PesoHumProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($PesoSecoProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Cu_Fino_Ajuste,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Ag_Fino_Ajuste,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Au_Fino_Ajuste,0,'','.')."</td>\n";
					echo "</tr>\n";
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PRV"]=strtoupper(substr($FilaProv["nom_prv"],0,40));
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PH"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PH"]+$PesoHumProv;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PS"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PS"]+$PesoSecoProv;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["02"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["02"]+$Cu_Fino_Ajuste;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["04"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["04"]+$Ag_Fino_Ajuste;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["05"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["05"]+$Au_Fino_Ajuste;
					$SubTotalPesoHumProd=$SubTotalPesoHumProd+$PesoHumProv;
					$SubTotalPesoSecoProd=$SubTotalPesoSecoProd+$PesoSecoProv;
					$SubTotalAjusteCuProd=$SubTotalAjusteCuProd+$Cu_Fino_Ajuste;
					$SubTotalAjusteAgProd=$SubTotalAjusteAgProd+$Ag_Fino_Ajuste;
					$SubTotalAjusteAuProd=$SubTotalAjusteAuProd+$Au_Fino_Ajuste;
				}
				//CANJE
				echo "<tr class='Detalle02'>\n";
				echo "<td colspan='12' align='center'>CANJE</td>\n";	
				echo "</tr>\n";
				$Consulta="select distinct t1.rut_proveedor,t2.NOMPRV_A as nom_prv from age_web.lotes t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A ";				
				$Consulta.="left join age_web.leyes_por_lote_canje t3 on t1.lote=t3.lote where t1.canjeable='S' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
				$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
				$Consulta.= "order by t2.NOMPRV_A ";
				//echo $Consulta."<br>";
				$RespProv = mysqli_query($link, $Consulta);
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$Consulta="select distinct t1.lote from age_web.lotes t1 left join age_web.leyes_por_lote_canje t3 on t1.lote=t3.lote ";				
					$Consulta.="where t1.rut_proveedor ='".$FilaProv["rut_proveedor"]."' and t1.canjeable='S' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
					$Consulta.="and t1.cod_producto='".$FilaProd["cod_producto"]."' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
					//echo $Consulta."<br>";
					$RespLotes = mysqli_query($link, $Consulta);
					$PesoHumProv=0;$PesoSecoProv=0;$Cu_Fino_Ajuste=0;$Ag_Fino_Ajuste=0;$Au_Fino_Ajuste=0;$Cu_Fino_Pqte1=0;$Ag_Fino_Pqte1=0;$Au_Fino_Pqte1=0;$Cu_Ley_Ajus=0;$Ag_Ley_Ajus=0;$Au_Ley_Ajus=0;
					while ($FilaLote=mysqli_fetch_array($RespLotes))
					{
						$DatosLote= array();
						$ArrLeyes=array();
						$DatosLote["lote"]=$FilaLote[lote];
						LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","N","","","");
						$Cu_Fino_Ajuste=$Cu_Fino_Ajuste+(($ArrLeyes["02"][8]-$ArrLeyes["02"][2])*$DatosLote["peso_seco"])/100;
						$Cu_Fino_Pqte1=$Cu_Fino_Pqte1+($ArrLeyes["02"][2]*$DatosLote["peso_seco"])/100;
						$Cu_Ley_Ajus=$Cu_Ley_Ajus+($ArrLeyes["02"][8]*$DatosLote["peso_seco"])/100;
						$Ag_Fino_Ajuste=$Ag_Fino_Ajuste+(($ArrLeyes["04"][8]-$ArrLeyes["04"][2])*$DatosLote["peso_seco"])/1000;
						$Ag_Fino_Pqte1=$Ag_Fino_Pqte1+($ArrLeyes["04"][2]*$DatosLote["peso_seco"])/1000;
						$Ag_Ley_Ajus=$Ag_Ley_Ajus+($ArrLeyes["04"][8]*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Ajuste=$Au_Fino_Ajuste+(($ArrLeyes["05"][8]-$ArrLeyes["05"][2])*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Pqte1=$Au_Fino_Pqte1+($ArrLeyes["05"][2]*$DatosLote["peso_seco"])/1000;
						$Au_Ley_Ajus=$Au_Ley_Ajus+($ArrLeyes["05"][8]*$DatosLote["peso_seco"])/1000;
						$PesoHumProv=$PesoHumProv+$DatosLote["peso_humedo"];
						$PesoSecoProv=$PesoSecoProv+$DatosLote["peso_seco"];
					}
					echo "<tr>\n";
					echo "<td><a href=JavaScript:DetallePrv('CAN','$FilaProd["cod_producto"]','$FilaProd["cod_subproducto"]','$FilaProv["rut_proveedor"]','$FechaIni','$FechaFin')>".strtoupper(substr($FilaProv["nom_prv"],0,20))."</a></td>\n";	
					echo "<td align='center'>".number_format(($Cu_Fino_Pqte1*100)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Ag_Fino_Pqte1*1000)/$PesoSecoProv,3,',','.')."</td>\n";
					echo "<td align='center'>".number_format(($Au_Fino_Pqte1*1000)/$PesoSecoProv,3,',','.')."</td>\n";
					echo "<td align='center'>".number_format(($Cu_Ley_Ajus*100)/$PesoSecoProv,2,'','.')."</td>\n";
					echo "<td align='center'>".number_format(($Ag_Ley_Ajus*1000)/$PesoSecoProv,3,',','.')."</td>\n";
					echo "<td align='center'>".number_format(($Au_Ley_Ajus*1000)/$PesoSecoProv,3,',','.')."</td>\n";
					echo "<td align='center'>".number_format($PesoHumProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($PesoSecoProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Cu_Fino_Ajuste,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Ag_Fino_Ajuste,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Au_Fino_Ajuste,0,'','.')."</td>\n";
					echo "</tr>\n";
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PRV"]=strtoupper(substr($FilaProv["nom_prv"],0,40));
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PH"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PH"]+$PesoHumProv;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PS"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["PS"]+$PesoSecoProv;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["02"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["02"]+$Cu_Fino_Ajuste;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["04"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["04"]+$Ag_Fino_Ajuste;
					$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["05"]=$ArrayFinalPrv[$FilaProv["rut_proveedor"]]["05"]+$Au_Fino_Ajuste;
					$SubTotalPesoHumProd=$SubTotalPesoHumProd+$PesoHumProv;
					$SubTotalPesoSecoProd=$SubTotalPesoSecoProd+$PesoSecoProv;
					$SubTotalAjusteCuProd=$SubTotalAjusteCuProd+$Cu_Fino_Ajuste;
					$SubTotalAjusteAgProd=$SubTotalAjusteAgProd+$Ag_Fino_Ajuste;
					$SubTotalAjusteAuProd=$SubTotalAjusteAuProd+$Au_Fino_Ajuste;
				}
				//FINAL
				echo "<tr class='Detalle02'>\n";
				echo "<td colspan='12' align='center'>FINAL PROVEEDOR PRODUCTO</td>\n";	
				echo "</tr>\n";
				reset($ArrayFinalPrv);
				while(list($c,$v)=each($ArrayFinalPrv))
				{
					echo "<tr class='Detalle04'>\n";
					echo "<td colspan='7'>RESUMEN PROVEEDOR&nbsp;&nbsp;".$v["PRV"]."</td>\n";	
					echo "<td align='center'>".number_format($v["PH"],0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($v["PS"],0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($v["02"],0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($v["04"],0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($v["05"],0,'','.')."</td>\n";
					echo "</tr>\n";
				}
				echo "<tr class='Detalle01'>\n";
				echo "<td colspan='7'>PRODUCTO&nbsp;&nbsp;".strtoupper($FilaProd["nom_subprod"])."</td>\n";	
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
			echo "<tr class='Detalle03'>\n";
			echo "<td colspan='7'>TOTAL&nbsp;&nbsp;".strtoupper($FilaProd["nom_subprod"])."</td>\n";	
			echo "<td align='center'>".number_format($TotalPesoHumFinal,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalPesoSecoFinal,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteCuFinal,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteAgFinal,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteAuFinal,0,'','.')."</td>\n";
			echo "</tr>\n";
		}
		?>
      </table>
<?php //include ("../principal/pie_pagina.php") ?>     
</form>
</body>
</html>