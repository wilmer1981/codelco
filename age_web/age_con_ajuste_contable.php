<?php
	if(!isset($Opcion))
	{
		$CheckedLey='checked';
		$CheckedFino='';
	}	
	else
		if($Opcion=='L')
		{
			$CheckedLey='checked';
			$CheckedFino='';
		}
		else
		{
			$CheckedLey='';
			$CheckedFino='checked';
		}		
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 82;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");	
?>
<html>
<head>
<title>AGE-Ajuste Contable</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script> 
<script language="JavaScript">
function Detalle(Valores)
{
	window.open("age_leyes_virtuales_detalle.php?Valores="+Valores,"","top=60,left=100,width=580,height=385,scrollbars=yes,resizable = no");
}
function Recarga3()
{
	var Frm=document.FrmPrincipal;
	Frm.action="age_con_ajuste_contable.php?Busq=S";
	Frm.submit();	
}
function Proceso(Proceso)
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var Resp="";
	var Opcion="";
	
	switch (Proceso)
	{
		case "B"://CONSULTAR
			if(Frm.OptLeyFino[0].checked==true)
				Opcion='L';
			else
				Opcion='F';
			Frm.action='age_con_ajuste_contable.php?Proceso=B&Mostrar=S&Opcion='+Opcion;
			Frm.submit();		
			break;
		case "E"://EXCEL
			Frm.action='age_con_ajuste_contable_excel.php?Proceso=B&Mostrar=S';
			Frm.submit();		
			break;
		case "I"://IMPRIMIR			
			window.print();
			break;
		case "R"://RECARGA
			Frm.action='age_con_ajuste_contable.php';
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
<body>
<form name="FrmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<input type="hidden" name="Valores" value="">
<table width="770" height="330" border="0" cellpadding="2" cellspacing="0" class="TablaPrincipal">
  <tr>
    <td align="center" valign="top">
    <table width="750" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr align="center">
        <td height="23" colspan="6" class="Detalle02"><strong>CONSULTA AJUSTE CONTABLE </strong></td>
      </tr>
      <tr>
        <td width="94" height="23" class="Colum01">SubProducto:</td>
        <td width="637" height="23" colspan="3"><select name="SubProducto" style="width:300" onChange="Proceso('R')">
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
        <td width="94" height="23" class="Colum01">Proveedor:</td>
        <td width="637" height="23" colspan="3"><select name="Proveedor" style="width:300">
          <option class='NoSelec' value='S'>TODOS</option>
          <?php
				if (isset($SubProducto) && $SubProducto != "S")
				{
					$Consulta = "select STRAIGHT_JOIN t1.rut_prv as RUTPRV_A, t1.nombre_prv as NOMPRV_A ";
					$Consulta.= " from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rut_prv = t2.rut_proveedor inner join proyecto_modernizacion.subproducto t3 ";
					$Consulta.= " on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
					$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";
					if($Busq=='S'&&$TxtFiltroPrv!='')
					   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%' ";  														
					$Consulta.= " order by trim(t1.nombre_prv)";		
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
        </select>
          ---> Filtro Prv&nbsp;
          <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
          <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">
          </td>
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
        </select>&nbsp;&nbsp;&nbsp;&nbsp;Leyes
        <input name="OptLeyFino" type="radio" value="radiobutton" value="L" <?php echo $CheckedLey; ?> >
		&nbsp;&nbsp;&nbsp;Finos
        <input name="OptLeyFino" type="radio" value="radiobutton" value="F" <?php echo $CheckedFino; ?> >
		</td>
      </tr>
      <tr>
        <td height="23" colspan="6" align="center" class="Detalle02">
		<input name="BtnConsultar" type="button" style="width:70px;" onClick="Proceso('B')" value="Consultar">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:80px " onClick="Proceso('I')">
        <input name="BtnGrabar" type="button" style="width:70px;" onClick="Proceso('E')" value="Excel">
		<input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="JavaScript:Proceso('S')"></td>
      </tr>
    </table>
    <br>
      <table width="750" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr align="center" class="ColorTabla01">
		<td colspan="1">&nbsp;</td>
		<td colspan="3">Pqte. 1 ero </td>
		<td colspan="3">Leyes Canje </td>
		<td colspan="2">Pesos(Kg)</td>
		<td colspan="3">Ajuste Mes</td>
		</tr>
		<tr align="center" class="ColorTabla01">
          <td width="30">Lote</td>
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
			$MesAux=$Mes;
			$AnoAux=$Ano;
		}
		$FechaIni = $Ano."-".$Mes."-01";
		$FechaFin = $Ano."-".$Mes."-31";		
		$AnoMes=substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT);
		if ($Mostrar=="S")
		{ 		
			$TotalPesoHum=0;$TotalPesoSeco=0;$TotalAjusteCu=0;$TotalAjusteAg=0;$TotalAjusteAu=0;
			$Consulta="select STRAIGHT_JOIN t1.cod_producto,t1.cod_subproducto, t4.descripcion as nom_subprod ";
			$Consulta.="from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t4 on t1.cod_producto=t4.cod_producto and t1.cod_subproducto=t4.cod_subproducto ";
			$Consulta.="where t1.cod_producto='1' and t1.canjeable='S' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
			if (isset($SubProducto) && $SubProducto != "S")
			{
				$Consulta.= " and t1.cod_subproducto='".$SubProducto."' ";	
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
			}
			$Consulta.=" group by t1.cod_producto,t1.cod_subproducto order by t1.cod_producto, t1.cod_subproducto";
			$RespProd = mysqli_query($link, $Consulta);
			while ($FilaProd = mysqli_fetch_array($RespProd))
			{
				
				$SubTotalPesoHumProd=0;$SubTotalPesoSecoProd=0;$SubTotalAjusteCuProd=0;$SubTotalAjusteAgProd=0;$SubTotalAjusteAuProd=0;
				$Consulta="select STRAIGHT_JOIN distinct t1.rut_proveedor,t2.nombre_prv as nom_prv ";
				$Consulta.= "from age_web.lotes t1 inner join sipa_web.proveedores t2 on t1.rut_proveedor=t2.rut_prv ";
				$Consulta.="where t1.canjeable='S' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
				$Consulta.="and t1.cod_producto='1' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
				$Consulta.="group by t1.cod_producto,t1.cod_subproducto order by t1.cod_producto, t1.cod_subproducto";
				$RespProv = mysqli_query($link, $Consulta);
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$Consulta ="select * from age_web.lotes t1 ";
					$Consulta.="where t1.rut_proveedor='$FilaProv["rut_proveedor"]' and t1.canjeable='S' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
					$Consulta.="and t1.cod_producto='1' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' order by t1.lote";
					$SubTotalPesoHumProv=0;$SubTotalPesoSecoProv=0;$SubTotalAjusteCuProv=0;$SubTotalAjusteAgProv=0;$SubTotalAjusteAuProv=0;
					$RespLote = mysqli_query($link, $Consulta);
					while ($FilaLote = mysqli_fetch_array($RespLote))
					{
						echo "<tr align='center'>\n";
						echo "<td>$FilaLote["lote"]</td>\n";
						$DatosLote= array();
						$ArrLeyes=array();
						$DatosLote["lote"]=$FilaLote["lote"];
						LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","N","","","");
						echo "<td>".number_format($ArrLeyes["02"][2],2,',','')."</td>\n";
						echo "<td>".number_format($ArrLeyes["04"][2],2,',','')."</td>\n";
						echo "<td>".number_format($ArrLeyes["05"][2],2,',','')."</td>\n";
						echo "<td>".number_format($ArrLeyes["02"][8],2,',','')."</td>\n";
						echo "<td>".number_format($ArrLeyes["04"][8],2,',','')."</td>\n";
						echo "<td>".number_format($ArrLeyes["05"][8],2,',','')."</td>\n";
						echo "<td>".number_format($DatosLote[peso_humedo],0,'','.')."</td>\n";
						echo "<td>".number_format($DatosLote[peso_seco],0,'','.')."</td>\n";
						if ($ArrLeyes["02"][8]>0 && $ArrLeyes["02"][2]>0 && $DatosLote[peso_seco]>0)
							$Dif_Cu=(($ArrLeyes["02"][8]-$ArrLeyes["02"][2])*$DatosLote[peso_seco])/$ArrLeyes["02"][5];
						else
							$Dif_Cu=0;
						if ($ArrLeyes["04"][8]>0 && $ArrLeyes["04"][2]>0 && $DatosLote[peso_seco]>0)
							$Dif_Ag=(($ArrLeyes["04"][8]-$ArrLeyes["04"][2])*$DatosLote[peso_seco])/$ArrLeyes["04"][5];
						else
							$Dif_Ag=0;
						if ($ArrLeyes["05"][8]>0 && $ArrLeyes["05"][2]>0 && $DatosLote[peso_seco]>0)
							$Dif_Au=(($ArrLeyes["05"][8]-$ArrLeyes["05"][2])*$DatosLote[peso_seco])/$ArrLeyes["05"][5];
						else
							$Dif_Au=0;
						echo "<td>".number_format($Dif_Cu,0,',','.')."</td>\n";
						echo "<td>".number_format($Dif_Ag,0,',','.')."</td>\n";
						echo "<td>".number_format($Dif_Au,0,',','.')."</td>\n";
						$SubTotalAjusteCuProv=$SubTotalAjusteCuProv+$Dif_Cu;
						$SubTotalAjusteAgProv=$SubTotalAjusteAgProv+$Dif_Ag;
						$SubTotalAjusteAuProv=$SubTotalAjusteAuProv+$Dif_Au;
						echo "</tr>\n";
					}
					$SubTotalPesoHumProd=$SubTotalPesoHumProd+$SubTotalPesoHumProv;
					$SubTotalPesoSecoProd=$SubTotalPesoSecoProd+$SubTotalPesoSecoProv;
					$SubTotalAjusteCuProd=$SubTotalAjusteCuProd+$SubTotalAjusteCuProv;
					$SubTotalAjusteAgProd=$SubTotalAjusteAgProd+$SubTotalAjusteAgProv;
					$SubTotalAjusteAuProd=$SubTotalAjusteAuProd+$SubTotalAjusteAuProv;
					echo "<tr class='Detalle02'>\n";
					echo "<td colspan='7'>PROVEEDOR&nbsp;&nbsp;".strtoupper($FilaProv["nom_prv"])."</td>\n";	
					echo "<td align='center'>".number_format($SubTotalPesoHumProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalPesoSecoProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalAjusteCuProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalAjusteAgProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($SubTotalAjusteAuProv,0,'','.')."</td>\n";
					echo "</tr>\n";
				}
				$TotalPesoHum=$TotalPesoHum+$SubTotalPesoHumProd;
				$TotalPesoSeco=$TotalPesoSeco+$SubTotalPesoSecoProd;
				$TotalAjusteCu=$TotalAjusteCu+$SubTotalAjusteCuProd;
				$TotalAjusteAg=$TotalAjusteAg+$SubTotalAjusteAgProd;
				$TotalAjusteAu=$TotalAjusteAu+$SubTotalAjusteAuProd;
				echo "<tr class='Detalle01'>\n";
				echo "<td colspan='7'>PRODUCTO&nbsp;&nbsp;".strtoupper($FilaProd["nom_subprod"])."</td>\n";	
				echo "<td align='center'>".number_format($SubTotalPesoHumProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalPesoSecoProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteCuProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteAgProd,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteAuProd,0,'','.')."</td>\n";
				echo "</tr>\n";
			}
			echo "<tr class='Detalle03'>\n";
			echo "<td colspan='7'><strong>TOTAL</strong></td>\n";
			echo "<td align='center'>".number_format($TotalPesoHum,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalPesoSeco,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteCu,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteAg,0,'','.')."</td>\n";
			echo "<td align='center'>".number_format($TotalAjusteAu,0,'','.')."</td>\n";
			echo "</tr>\n";
		}
		?>
      </table>
    </td>
  </tr>
</table> 
</table>
<?php include ("../principal/pie_pagina.php") ?>     
</form>
</body>
</html>