<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 54;
	include("../principal/conectar_principal.php");	
	include("age_funciones.php");	
?>
<html>
<head>
<title>AGE-Consulta Leyes Virtuales</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../principal/funciones/funciones_java.js"></script> 
<script language="JavaScript">
function Detalle(Valores)
{
	window.open("age_leyes_virtuales_detalle.php?Valores="+Valores,"","top=60,left=100,width=580,height=385,scrollbars=yes,resizable = no");
}
function Proceso(Proceso)
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var Resp="";
	
	switch (Proceso)
	{
		case "B"://CONSULTAR
			Frm.action='age_consulta_leyes_virtuales.php?Proceso=B&Mostrar=S';
			Frm.submit();		
			break;
		case "E"://EXCEL
			Frm.action='age_consulta_leyes_virtuales_excel.php?Mostrar=S';
			Frm.submit();		
			break;
		case "R"://RECARGA
			Frm.action='age_consulta_leyes_virtuales.php';
			Frm.submit();		
			break;
		case "S"://SALIR
			Frm.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=50&Nivel=1";
			Frm.submit();
			break;
	} 
}
function Recarga3()
{
	var Frm=document.FrmPrincipal;
	Frm.action="age_consulta_leyes_virtuales.php?Busq=S";
	Frm.submit();	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmPrincipal" action="" method="post">
<?php //include("../principal/encabezado.php") ?>
<input type="hidden" name="Valores" value="">
    <table width="900" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr align="center">
        <td height="23" colspan="6" class="Detalle02"><strong>CONSULTA LEYES PROVISIONALES</strong></td>
      <tr>
        <td width="93" height="23" class="Colum01">SubProducto:</td>
        <td height="23" colspan="3"><select name="SubProducto" style="width:300" onChange="Proceso('R')">
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
        <td width="93" height="23" class="Colum01">Proveedor:</td>
        <td height="23" colspan="3"><select name="Proveedor" style="width:300">
          <option class='NoSelec' value='S'>TODOS</option>
          <?php
				if (isset($SubProducto) && $SubProducto != "S")
				{
					$Consulta = "select t1.rut_prv as RUTPRV_A, t1.nombre_prv as NOMPRV_A ";
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
        </select></td>
      </tr>
      <tr>
        <td height="23" colspan="6" align="center" class="Detalle02">
		<input name="BtnConsultar" type="button" style="width:70px;" onClick="Proceso('B')" value="Consultar">
        <input name="BtnGrabar" type="button" style="width:70px;" onClick="Proceso('E')" value="Excel">
        <input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="JavaScript:Proceso('S')"></td>
      </tr>
    </table>
    <br>
      <table width="900" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr align="center" class="ColorTabla01">
		<td>&nbsp;</td>
		<td colspan="3">Leyes Provisionales </td>
		<td colspan="3">Leyes Reales</td>
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
			$Consulta="select t1.cod_producto,t1.cod_subproducto,t2.descripcion as nom_subprod from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 ";
			$Consulta.="on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and t3.provisional = 'S' ";
			$Consulta.="where t1.cod_producto='1' ";
			if($SubProducto!='S')
				$Consulta.=" and t1.cod_subproducto='".$SubProducto."' ";
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
			$Consulta.="group by t1.cod_producto,t1.cod_subproducto order by t1.cod_producto,t1.cod_subproducto";
			//echo $Consulta;
			$RespProd=mysqli_query($link, $Consulta);
			while($FilaProd=mysqli_fetch_array($RespProd))
			{
				$SubTotalPesoHum=0;$SubTotalPesoSeco=0;$SubTotalAjusteCu=0;$SubTotalAjusteAg=0;$SubTotalAjusteAu=0;
				$Consulta="select distinct t1.rut_proveedor,t2.NOMPRV_A as nom_prv from age_web.lotes t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A ";				
				$Consulta.="inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and t3.provisional = 'S' where t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
				$Consulta.="and t1.cod_producto='1' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' ";	
				if (isset($Proveedor) && $Proveedor != "S")
					$Consulta.= " and t1.rut_proveedor='".$Proveedor."' ";	
				$Consulta.= "order by t2.NOMPRV_a";
				//echo $Consulta."<br>";
				$RespProv = mysqli_query($link, $Consulta);
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$Consulta="select distinct t1.lote from age_web.lotes t1 inner join age_web.leyes_por_lote t3 on t1.lote=t3.lote and t3.provisional = 'S' ";				
					$Consulta.="where t1.rut_proveedor ='".$FilaProv["rut_proveedor"]."' and t1.fecha_recepcion between '$FechaIni' and '$FechaFin' ";
					$Consulta.="and t1.cod_producto='1' and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."' order by t1.lote ";	
					//echo $Consulta."<br>";
					$RespLotes = mysqli_query($link, $Consulta);
					$Cu_Fino_Ajuste=0;$Ag_Fino_Ajuste=0;$Au_Fino_Ajuste=0;$Cu_Fino_Pro=0;$Ag_Fino_Pro=0;$Au_Fino_Pro=0;$Cu_Fino_Real=0;$Ag_Fino_Real=0;$Au_Fino_Real=0;
					while ($FilaLote=mysqli_fetch_array($RespLotes))
					{
						$DatosLote= array();
						$ArrLeyes=array();
						$DatosLote["lote"]=$FilaLote["lote"];
						LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
						echo "<td>".$FilaLote["lote"]."</td>\n";	
						echo "<td align='center'>".number_format($ArrLeyes["02"][2],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($ArrLeyes["04"][2],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($ArrLeyes["05"][2],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($ArrLeyes["02"][7],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($ArrLeyes["04"][7],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($ArrLeyes["05"][7],2,'','.')."</td>\n";
						echo "<td align='center'>".number_format($DatosLote["peso_humedo"],0,'','.')."</td>\n";
						echo "<td align='center'>".number_format($DatosLote["peso_seco"],0,'','.')."</td>\n";
						echo "<td align='center'>".number_format((($ArrLeyes["02"][7]-$ArrLeyes["02"][2])*$DatosLote["peso_seco"])/100,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format((($ArrLeyes["04"][7]-$ArrLeyes["04"][2])*$DatosLote["peso_seco"])/1000,0,'','.')."</td>\n";
						echo "<td align='center'>".number_format((($ArrLeyes["05"][7]-$ArrLeyes["05"][2])*$DatosLote["peso_seco"])/1000,0,'','.')."</td>\n";
						echo "</tr>\n";
						$Cu_Fino_Ajuste=$Cu_Fino_Ajuste+(($ArrLeyes["02"][7]-$ArrLeyes["02"][2])*$DatosLote["peso_seco"])/100;
						$Cu_Fino_Pro=$Cu_Fino_Pro+($ArrLeyes["02"][2]*$DatosLote["peso_seco"])/100;
						$Ag_Fino_Ajuste=$Ag_Fino_Ajuste+(($ArrLeyes["04"][7]-$ArrLeyes["04"][2])*$DatosLote["peso_seco"])/1000;
						$Ag_Fino_Pro=$Ag_Fino_Pro+($ArrLeyes["04"][2]*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Ajuste=$Au_Fino_Ajuste+(($ArrLeyes["05"][7]-$ArrLeyes["05"][2])*$DatosLote["peso_seco"])/1000;
						$Au_Fino_Pro=$Au_Fino_Pro+($ArrLeyes["05"][2]*$DatosLote["peso_seco"])/1000;
						$PesoHumProv=$PesoHumProv+$DatosLote["peso_humedo"];
						$PesoSecoProv=$PesoSecoProv+$DatosLote["peso_seco"];
					}
					echo "<tr class='Detalle02'>\n";
					echo "<td colspan='7'>".strtoupper(substr($FilaProv["nom_prv"],0,20))."</td>\n";	
					echo "<td align='center'>".number_format($PesoHumProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($PesoSecoProv,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Cu_Fino_Ajuste,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Ag_Fino_Ajuste,0,'','.')."</td>\n";
					echo "<td align='center'>".number_format($Au_Fino_Ajuste,0,'','.')."</td>\n";
					echo "</tr>\n";
					$SubTotalPesoHum=$SubTotalPesoHum+$PesoHumProv;
					$SubTotalPesoSeco=$SubTotalPesoSeco+$PesoSecoProv;
					$SubTotalAjusteCu=$SubTotalAjusteCu+$Cu_Fino_Ajuste;
					$SubTotalAjusteAg=$SubTotalAjusteAg+$Ag_Fino_Ajuste;
					$SubTotalAjusteAu=$SubTotalAjusteAu+$Au_Fino_Ajuste;
				}
				echo "<tr class='Detalle01'>\n";
				echo "<td colspan='7'>SUBTOTAL&nbsp;&nbsp;".strtoupper($FilaProd["nom_subprod"])."</td>\n";	
				echo "<td align='center'>".number_format($SubTotalPesoHum,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalPesoSeco,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteCu,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteAg,0,'','.')."</td>\n";
				echo "<td align='center'>".number_format($SubTotalAjusteAu,0,'','.')."</td>\n";
				echo "</tr>\n";
				$TotalPesoHum=$TotalPesoHum+$SubTotalPesoHum;
				$TotalPesoSeco=$TotalPesoSeco+$SubTotalPesoSeco;
				$TotalAjusteCu=$TotalAjusteCu+$SubTotalAjusteCu;
				$TotalAjusteAg=$TotalAjusteAg+$SubTotalAjusteAg;
				$TotalAjusteAu=$TotalAjusteAu+$SubTotalAjusteAu;
			}
			echo "<tr class='Detalle03'>\n";
			echo "<td>TOTAL</td>\n";	
			echo "<td colspan='6'>&nbsp;</td>\n";
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
<?php //include ("../principal/pie_pagina.php") ?>     
</form>
</body>
</html>
<?php
/*$Consulta= "select t2.abreviatura as unidad from proyecto_modernizacion.leyes t1 left join proyecto_modernizacion.unidades t2 on t1.cod_unidad=t2.cod_unidad where cod_leyes='05'";
$RespUnidad=mysqli_query($link, $Consulta);
$FilaUnidad=mysqli_fetch_array($RespUnidad);*/
?>
