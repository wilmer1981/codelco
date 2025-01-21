<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=81;
	$CmbMes     = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	$CmbAno     = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";
	$Recarga    = isset($_REQUEST["Recarga"])?$_REQUEST["Recarga"]:"";
	$EstadoInput = isset($_REQUEST["EstadoInput"])?$_REQUEST["EstadoInput"]:"";
	$Buscar      = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$TipoBusqueda = isset($_REQUEST["TipoBusqueda"])?$_REQUEST["TipoBusqueda"]:"";
	$TxtLoteIni  = isset($_REQUEST["TxtLoteIni"])?$_REQUEST["TxtLoteIni"]:"";
	$TxtLoteFin  = isset($_REQUEST["TxtLoteFin"])?$_REQUEST["TxtLoteFin"]:"";
	$Petalo      = isset($_REQUEST["Petalo"])?$_REQUEST["Petalo"]:"";

	if($CmbMes=="")
	{
		$LoteIni=substr(date('Y'),2,2).str_pad(date('n'),2,'0',STR_PAD_LEFT)."0001";
		$LoteFin=substr(date('Y'),2,2).str_pad(date('n'),2,'0',STR_PAD_LEFT)."9999";
	}
	else
	{
		if (substr($CmbAno,0,4)<2006)
		{
			$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
			$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
		}
		else
		{
			$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
			$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";;
		}
	}	
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	$Consulta="select count(*) as cant from age_web.lotes where lote between '$LoteIni' and '$LoteFin' and canjeable='S'";
	$Respuesta=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Respuesta))
	{
		$CantLotesCanjeados=$Fila["cant"];
	}
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");		
?>
<html>
<head>
<title>AGE-Consulta Lotes Canjeados</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt,opt2)
{
	var f = document.frmPrincipal;
	var Valores='';
	switch (opt)
	{
		case "B"://BUSCAR
			if(f.TxtLoteIni.value=='')
			{
				//BUSQUEDA POR MES(BM)
				f.action = "age_con_lotes_canjeados.php?Recarga=S&TipoBusqueda=BM&Buscar=S";
			}
			else
			{
				//BUSQUEDA POR LOTE(BL)
				if(f.TxtLoteFin.value=='')
					f.TxtLoteFin.value=f.TxtLoteIni.value;
				f.action = "age_con_lotes_canjeados.php?Recarga=S&TipoBusqueda=BL&Buscar=S";
			}
			f.submit();		
			break;		
		case "I"://IMPRIMIR			
			window.print();
			break;
		case "E"://EXCEL	
			if(f.TxtLoteIni.value=='')
			{
				f.action = "age_con_lotes_canjeados_excel.php?Recarga=S&TipoBusqueda=BM&Buscar=S";			}
			else
			{
				if(f.TxtLoteFin.value=='')
					f.TxtLoteFin.value=f.TxtLoteIni.value;
				f.action = "age_con_lotes_canjeados_excel.php?Recarga=S&TipoBusqueda=BL&Buscar=S";
			}
			f.submit();	
			break;		
		case "S"://SALIR
			frmPrincipal.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=80";
			frmPrincipal.submit();
			break;			
	}
}
function DetalleLote(Lote)
{
	window.open("../age_web/age_adm_canje_leyes.php?EsPopup=S&TxtLote="+Lote,"","top=0,left=0,width=800,height=600,scrollbars=yes,resizable = yes");					
}
function DetalleLeyes(Lote)
{
	window.open("../age_web/age_certificado_leyes_canje.php?Valores="+Lote,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body onLoad="window.document.frmPrincipal.TxtLoteIni.focus();">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<table class="TablaPrincipal" width="770">
	<tr>
	  <td width="770" height="340" align="center" valign="top"><br>
<table width="750"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02" align="center">
    <td colspan="4"><strong>LOTES CANJEADOS </strong></td>
  </tr>
  <tr class="Colum01">
    <td width="88" class="Colum01">Mes:</td>
    <td class="Colum01"><?php
			echo "<select name='CmbMes' size='1' style='width:90px;'>";
			for($i=1;$i<13;$i++)
			{
				if ($i==$CmbMes&&$Recarga=='S')
					echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
				else if ($i==date("n")&&$Recarga!='S')	
					echo "<option selected value ='$i'>".$meses[$i-1]."</option>";
				else	
					echo "<option value='".$i."'>".$meses[$i-1]."</option>";
			}
			echo "</select>";
			echo "<select name='CmbAno' size='1' style='width:70px;'>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if ($i==$CmbAno&&$Recarga=='S')
					echo "<option selected value ='$i'>$i</option>";
				else if ($i==date('Y')&&$Recarga!='S')
					echo "<option selected value ='$i'>$i</option>";
				else		
					echo "<option value='".$i."'>".$i."</option>";
			}
			echo "</select>";
			?>&nbsp;&nbsp;&nbsp;&nbsp;<strong><font color="#FF0000">Lotes Canjeados en el Mes:</font></strong>&nbsp;&nbsp;
      <input name="textfield" type="text" class='InputColor' value='<?php echo $CantLotesCanjeados;?>' size="8" readonly="true"></td>
  </tr>
  <tr class="Colum01">
    <td width="71" class="Colum01">Lote Inicio:</td>
    <td width="664" class="Colum01"><input <?php echo $EstadoInput; ?> name="TxtLoteIni" type="text" class="InputCen" value="<?php echo $TxtLoteIni; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');">
      &nbsp;&nbsp;&nbsp;
      Lote Final: 
        <input <?php echo $EstadoInput; ?> name="TxtLoteFin" type="text" class="InputCen" id="TxtLote2" value="<?php echo $TxtLoteFin; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');">
        &nbsp;&nbsp;&nbsp;
  </tr>
  <tr align="center" class="Colum01">
	  <td height="30" colspan="4" class="Colum01">
		<input name="BtnOK" type="button" value="Buscar" style="width:80px " onClick="Proceso('B')">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:80px " onClick="Proceso('I','<?php echo $Petalo?>')">
		<input name="BtnExcel" type="button" value="Excel" style="width:80px " onClick="Proceso('E','<?php echo $Petalo?>')">
		<input name="BtnSalir" type="button" value="Salir" style="width:80px " onClick="Proceso('S')">
	  </td>
	</tr>
	</table>
	<br>
	<table width='750'  border='1' align='center' cellpadding='2' cellspacing='0' class='TablaInterior'>
	<tr align="center" class="ColorTabla01">
	<td>Lote</td>
	<td>SubProducto</td>
	<td>Proveedor</td>
	<td>Leyes</td>
	<td>Cod.Recep</td>
	<td>Peso Hum.</td>
	<td>Peso Seco</td>
	</tr>
	<?php
	if($Buscar=='S')
	{
		$Consulta ="select distinct t1.cod_subproducto,t2.descripcion as nom_subproducto from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto='1' and t1.cod_subproducto=t2.cod_subproducto ";
		switch($TipoBusqueda)
		{
			case "BL"://POR LOTE
				$Consulta.= "where lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
				break;
			case "BM"://POR MES
				if ($CmbAno<2006)
				{
					$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
					$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
				}
				else
				{
					$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
					$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
				}
				$Consulta.= "where t1.cod_producto='1' and lote between '".$LoteIni."' and '".$LoteFin."'";
				break;
		}	
		$Consulta.=" and canjeable='S'";
		//echo $Consulta."<br>";
		$RespProd = mysqli_query($link, $Consulta);
		while($FilaProd = mysqli_fetch_array($RespProd))
		{
			$TotPHumProd=0;
			$TotPSecoProd=0;
			$Consulta ="select distinct t1.rut_proveedor,t2.NOMPRV_A as nom_prv from age_web.lotes t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.RUTPRV_A ";
			switch($TipoBusqueda)
			{
				case "BL"://POR LOTE
					$Consulta.= "where lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
					break;
				case "BM"://POR MES
					if ($CmbAno<2006)
					{
						$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
						$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
					}
					else
					{
						$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
						$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
					}
					$Consulta.= "where t1.cod_producto='1' and t1.lote between '".$LoteIni."' and '".$LoteFin."'";
					break;
			}	
			$Consulta.=" and t1.canjeable='S' and t1.cod_producto=1 and t1.cod_subproducto='".$FilaProd["cod_subproducto"]."'";
			//echo $Consulta."<br>";
			$RespProv = mysqli_query($link, $Consulta);
			while($FilaProv = mysqli_fetch_array($RespProv))
			{
				$TotPHumProv=0;
				$TotPSecoProv=0;
				$Consulta ="select t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.abreviatura as nom_subproducto,t1.rut_proveedor,t4.nombre_prv as nom_prv,t1.num_conjunto, t1.cod_recepcion,";
				$Consulta.="t1.cod_faena,t5.descripcion as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.valor_subclase1 as nom_recepcion ";
				$Consulta.="from age_web.lotes t1 left join ";
				$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
				$Consulta.="sipa_web.proveedores t4 on t1.rut_proveedor=t4.rut_prv left join ";
				$Consulta.="age_web.mina t5 on t1.cod_faena=t5.cod_faena left join ";
				$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
				$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
				$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='15002' and t1.cod_recepcion=t8.nombre_subclase ";
				switch($TipoBusqueda)
				{
					case "BL"://POR LOTE
						$Consulta.= "where t1.lote between '".$TxtLoteIni."' and '".$TxtLoteFin."'";
						break;
					case "BM"://POR MES
						if ($CmbAno<2006)
						{
							$LoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."001";
							$LoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
						}
						else
						{	
							$LoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0001";
							$LoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
						}
						$Consulta.= "where t1.lote between '".$LoteIni."' and '".$LoteFin."'";
						break;
				}	
				$Consulta.=" and t1.canjeable='S' and t1.rut_proveedor='".$FilaProv["rut_proveedor"]."'";
				//echo $Consulta."<br>";
				$Resp = mysqli_query($link, $Consulta);
				while($Fila = mysqli_fetch_array($Resp))
				{
					$DatosLote= array();
					$ArrLeyes=array();
					$DatosLote["lote"]=$Fila["lote"];
					$DatosLote = LeyesLote($DatosLote,$ArrLeyes,"N","S","N","","","","",$link);
					$ArrLeyes = LeyesLote($DatosLote,$ArrLeyes,"N","S","N","","","","L",$link);
					echo "<tr>";
					echo "<td><a href=\"JavaScript:DetalleLote('".$Fila["lote"]."')\">".$Fila["lote"]."</a></td>";
					echo "<td>".$Fila["nom_subproducto"]."</td>";
					echo "<td>".$Fila["rut_proveedor"]." ".$Fila["nom_prv"]."</td>";
					echo "<td align='center'><a href=\"JavaScript:DetalleLeyes('".$Fila["lote"]."')\"><img src='../Principal/imagenes/ico_pag.gif' width='18' height='9' border='0'></a></td>";
					echo "<td>";
					if ($Fila["cod_recepcion"]=="")
						echo "&nbsp;";
					else
						echo $Fila["cod_recepcion"];
					echo "</td>";
					$peso_humedo = isset($DatosLote["peso_humedo"])?$DatosLote["peso_humedo"]:0;
					$peso_seco   = isset($DatosLote["peso_seco"])?$DatosLote["peso_seco"]:0;

					echo "<td align='right'>".number_format($peso_humedo,0,'','.')."</td>";
					echo "<td align='right'>".number_format($peso_seco,0,'','.')."</td>";
					echo "</tr>";
					$TotPHumProv=$TotPHumProv + $peso_humedo;
					$TotPSecoProv=$TotPSecoProv + $peso_seco;
				}
				$TotPHumProd=$TotPHumProd+$TotPHumProv;
				$TotPSecoProd=$TotPSecoProd+$TotPSecoProv;
				echo "<tr class='Detalle02'>";
				echo "<td>&nbsp;</td>";
				echo "<td colspan='4'>PROVEEDOR:&nbsp;".$FilaProv["rut_proveedor"]." - ".$FilaProv["nom_prv"]."</td>";
				echo "<td align='right'>".number_format($TotPHumProv,0,'','.')."</td>";
				echo "<td align='right'>".number_format($TotPSecoProv,0,'','.')."</td>";
				echo "</tr>";
			}
			echo "<tr class='Detalle01'>";
			echo "<td>&nbsp;</td>";
			echo "<td colspan='4'>SUB-PRODUCTO:&nbsp;".$FilaProd["cod_subproducto"]." - ".$FilaProd["nom_subproducto"]."</td>";
			echo "<td align='right'>".number_format($TotPHumProd,0,'','.')."</td>";
			echo "<td align='right'>".number_format($TotPSecoProd,0,'','.')."</td>";
			echo "</tr>";
		}
	}
	?>
	</table>	
</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
