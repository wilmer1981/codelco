<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	$Consulta ="select t2.nombre_subclase as nom_lab,t2.valor_subclase1,t2.valor_subclase2,t2.valor_subclase3,t2.valor_subclase4 from age_web.lotes t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='15009' and t1.laboratorio_externo=t2.cod_subclase ";
	$Consulta.="where t1.orden_ensaye='".$TxtOrdenEns."' order by t1.lote desc limit 1";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Resp);
	$NomLab=strtoupper($Fila[nom_lab]);
	$CmbTipoMoneda=$Fila["valor_subclase1"];
	$PrecioCu=$Fila["valor_subclase2"];
	$PrecioAg=$Fila["valor_subclase3"];
	$PrecioAu=$Fila[valor_subclase4];
	
	if(!isset($TxtOrdenEnsaye))
		$TxtOrdenEnsaye=$TxtOrdenEns;
	if($Calcular!='S')
	{	
		$Consulta="select * from age_web.facturacion_canje_leyes where orden_ensaye='".$TxtOrdenEns."'";
		$RespOrdenEns=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($RespOrdenEns))
		{
			$TxtFactura=$Fila[num_factura];
			$TxtFechaFactura=$Fila[fecha_factura];
			$TxtFechaIni=$Fila[fecha_moneda_desde];
			$TxtFechaFin=$Fila[fecha_moneda_hasta];
			$CmbTipoMoneda=$Fila[tipo_moneda];
			$TxtValorMoneda=$Fila[valor_moneda];
		}
	}	
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");		
?>
<html>
<head>
<title>AGE-Consulta Resultado Paquetes Arbitrales</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt,opt2)
{
	var f = document.frmPrincipal;
	var Valores='';var TipoMoneda='';
	switch (opt)
	{
		case "G"://BUSCAR
			if(f.TxtFactura.value=='')
			{
				alert('Debe Ingresar Numero de Factura');
				return;
			}
			if(f.TxtFechaFactura.value=='')
			{
				alert('Debe Ingresar Fecha de Factura');
				return;
			}
			if(f.TxtValorMoneda.value=='')
			{
				alert('Debe Ingresar Moneda')
				return;
			}
			if(f.TxtFechaIni.value=='')
			{
				alert('Debe Ingresar Fecha Inicio Valor Dolar');
				return;
			}
			if(f.TxtFechaFin.value=='')
			{
				alert('Debe Ingresar Fecha Fin Valor Dolar');
				return;
			}
			f.action = "age_con_resultados_pqts_arbitrales_factura01.php";
			f.submit();		
			break;
		case "C"://CALCULAR
			if(f.TxtTipoMoneda.value=='UF')
				TipoMoneda='UF';
			if(f.TxtTipoMoneda.value=='US')
				TipoMoneda='US$';
			if(f.TxtValorMoneda.value=='')
			{
				alert('Debe Ingresar Valor Cambio');	
				return;
			}	
			f.action = "age_con_resultados_pqts_arbitrales_factura.php?TipoMoneda="+TipoMoneda+"&Calcular=S";
			f.submit();		
			break;
		case "I"://IMPRIMIR			
			window.print();
			break;
		case "E"://EXCEL
			window.open("age_con_resultados_pqts_arbitrales_factura_excel.php?TxtOrdenEns="+f.TxtOrdenEnsaye.value,"","top=0,left=0,width=800,height=600,scrollbars=yes,resizable = yes,menubar=yes");								
			//f.action = "age_con_resultados_pqts_arbitrales_factura_excel.php??TxtOrdenEns="+f.TxtOrdenEnsaye.value;
			//f.submit();	
			break;		
		case "S"://SALIR
			window.close();
			break;			
	}
}


</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
-->
</style>
</head>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name='TxtOrdenEns' value="<?php echo $TxtOrdenEns;?>">
<table width="544"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02" align="center">
    <td colspan="4"><strong>FACTURACION CANJE LABORATORIO "<?php echo $NomLab;?>"</strong></td>
  </tr>
  <tr class="Colum01">
    <td width="91" class="Colum01">Factura N&deg;:</td>
    <td class="Colum01"><input <?php echo $EstadoInput; ?> name="TxtFactura" type="text" class="InputCen" value="<?php echo $TxtFactura; ?>" size="15" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');"></td>
  </tr>
   <tr class="Colum01">
    <td width="91" class="Colum01">Orden Ensaye :</td>
    <td width="438" class="Colum01"><input <?php echo $EstadoInput; ?> name="TxtOrdenEnsaye" type="text" class="InputCen" value="<?php echo $TxtOrdenEnsaye; ?>" size="15" maxlength="15" onKeyDown="TeclaPulsada2('N',true,this.form,'BtnOK');" readonly="true">&nbsp;  </tr>
  <tr class="Colum01">
    <td width="91" class="Colum01">Fecha Factura:</td>
    <td width="438" class="Colum01"><input <?php echo $EstadoInput; ?> name="TxtFechaFactura" type="text" class="InputCen" value="<?php echo $TxtFechaFactura; ?>" size="15" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');">
      <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaFactura,TxtFechaFactura,popCal);return false">  </tr>
  <tr class="Colum01">
    <td width="91" class="Colum01">Tipo Moneda:</td>
    <td width="438" class="Colum01">
        <?php
		switch($CmbTipoMoneda)
		{
			case "UF":
				echo "<strong>UF</strong>";
				echo "<input type='hidden' name='TxtTipoMoneda' value='UF'>";
				break;
			case "US":
				echo "<strong>US$</strong>";
				echo "<input type='hidden' name='TxtTipoMoneda' value='US'>";
				break;
		}
	
	?>
    </tr>
  <tr class="Colum01">
    <td width="91" class="Colum01">Valor Moneda:</td>
    <td width="438" class="Colum01"><input <?php echo $EstadoInput; ?> name="TxtValorMoneda" type="text" class="InputCen" value="<?php echo $TxtValorMoneda; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK2');">
      &nbsp;&nbsp;&nbsp;Del&nbsp;
      <input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
      <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al
      <input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
      <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false">  </tr>
  <tr align="center" class="Colum01">
	  <td height="30" colspan="4" class="Colum01">
		<input name="BtnOK2" type="button" value="Calcular" style="width:80px " onClick="Proceso('C')">
		<input name="BtnOK" type="button" value="Grabar" style="width:80px " onClick="Proceso('G')">
		
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:80px " onClick="Proceso('I','<?php echo $Petalo?>')">
		<input name="BtnExcel" type="button" value="Excel" style="width:80px " onClick="Proceso('E','<?php echo $Petalo?>')">
	  <input name="BtnSalir" type="button" value="Salir" style="width:80px " onClick="Proceso('S')">	  </td>
	</tr>
  </table>
	<br>
	<table width='693' border='1' align='center' cellpadding='1' cellspacing='0' class='TablaInterior'>
	<tr>
	<td colspan="5" align="center" class="Detalle03"><strong>PAGA CODELCO</strong></td>
	<td>&nbsp;</td>
	<td colspan="5" align="center" class="Detalle03"><strong>PAGA ENAMI</strong></td>
	</tr>
	<tr align="center" class="ColorTabla01">
	<td align="center">PASTA</td>
	<td align="center">CANTIDAD</td>
	<td align="center">PRECIO</td>
	<td align="center">VALOR(<?php echo $TipoMoneda;?>)</td>
	<td align="center">VALOR($)</td>
	<td align="center" class="Detalle04">&nbsp;</td>
	<td align="center">PASTA</td>
	<td align="center">CANTIDAD</td>
	<td align="center">PRECIO</td>
	<td align="center">VALOR(<?php echo $TipoMoneda;?>)</td>
	<td align="center">VALOR($)</td>
	</tr>
	<?php
		$CantGanaC_CU=0;$CantGanaC_AG=0;$CantGanaC_AU=0;$CantGanaE_CU=0;$CantGanaE_AG=0;$CantGanaE_AU=0;
		$Consulta ="select t1.fecha_canje,t1.fecha_recepcion,t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.abreviatura as nom_subproducto,t1.rut_proveedor,t4.nombre_prv as nom_prv,t1.num_conjunto, t1.cod_recepcion,";
		$Consulta.="t1.cod_faena,t5.descripcion as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.valor_subclase1 as nom_recepcion,t9.nombre_subclase as nom_lab,t1.orden_ensaye ";
		$Consulta.="from age_web.lotes t1 inner join age_web.leyes_por_lote_canje t9 on t1.lote=t9.lote and t9.paquete_canje='3' left join ";
		$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
		$Consulta.="sipa_web.proveedores t4 on t1.rut_proveedor=t4.rut_prv left join ";
		$Consulta.="age_web.mina t5 on t1.cod_faena=t5.cod_faena left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='15002' and t1.cod_recepcion=t8.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t9 on t9.cod_clase='15009' and t1.laboratorio_externo=t9.cod_subclase ";
		$Consulta.= "where t1.orden_ensaye='".$TxtOrdenEnsaye."'";
		$Consulta.=" and t1.canjeable='S' group by t1.lote";
		//echo $Consulta."<br>";
		$Resp = mysqli_query($link, $Consulta);
		while($Fila = mysqli_fetch_array($Resp))
		{
			$ArrLeyesCanje=array();
			$ArrLeyesCanje["02"][0]="02";
			$ArrLeyesCanje["02"][1]="Cu";
			$ArrLeyesCanje["02"][2]=0;
			$ArrLeyesCanje["02"][3]=0;
			$ArrLeyesCanje["02"][4]=0;
			$ArrLeyesCanje["04"][0]="04";
			$ArrLeyesCanje["04"][1]="Ag";
			$ArrLeyesCanje["04"][2]=0;
			$ArrLeyesCanje["04"][3]=0;
			$ArrLeyesCanje["04"][4]=0;
			$ArrLeyesCanje["05"][0]="05";
			$ArrLeyesCanje["05"][1]="Au";
			$ArrLeyesCanje["05"][2]=0;
			$ArrLeyesCanje["05"][3]=0;
			$ArrLeyesCanje["05"][4]=0;
			$Consulta="select * from age_web.leyes_por_lote_canje where lote='".$Fila[lote]."' and paquete_canje='3'";
			$RespLeyes=mysqli_query($link, $Consulta);
			while($FilaLeyes=mysqli_fetch_array($RespLeyes))
			{
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][2]=$FilaLeyes[valor1];
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][3]=$FilaLeyes[valor2];
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][4]=$FilaLeyes[valor3];
			}
			reset($ArrLeyesCanje);
			while(list($c,$v)=each($ArrLeyesCanje))
			{
				if($v[2]!=0)
				{
					$GanaC=0;
					if(abs($v[2]-$v[4]+1000-1000)<abs($v[3]-$v[4]+1000-1000))
						$GanaC=1;
					else
						if(abs($v[2]-$v[4]+1000-1000)==abs($v[3]-$v[4]+1000-1000))
							$GanaC=0.5;
					switch($v[0])
					{
						case "02":
							$CantGanaC_CU=$CantGanaC_CU+$GanaC;
							break;
						case "04":
							$CantGanaC_AG=$CantGanaC_AG+$GanaC;
							break;
						case "05":
							$CantGanaC_AU=$CantGanaC_AU+$GanaC;
							break;
					}		
				}	
			}
			reset($ArrLeyesCanje);			
			while(list($c,$v)=each($ArrLeyesCanje))
			{
				if($v[2]!=0)
				{
					$GanaE=0;
					if(abs($v[2]-$v[4]+1000-1000)>abs($v[3]-$v[4]+1000-1000))
						$GanaE=1;
					else
						if(abs($v[2]-$v[4]+1000-1000)==abs($v[3]-$v[4]+1000-1000))
							$GanaE=0.5;
					switch($v[0])
					{
						case "02":
							$CantGanaE_CU=$CantGanaE_CU+$GanaE;
							break;
						case "04":
							$CantGanaE_AG=$CantGanaE_AG+$GanaE;
							break;
						case "05":
							$CantGanaE_AU=$CantGanaE_AU+$GanaE;
							break;
					}
				}			
			}		
		}
	?>
	<?php $TxtValorMoneda=str_replace(',','.',$TxtValorMoneda);?>
	<tr align="center" class="ColorTabla02">
	  <td align="center">COBRE</td>
	  <td align="right"><?php echo $CantGanaE_CU;?></td>
	  <td align="right"><?php echo $PrecioCu;?></td>
	  <td align="right"><?php echo ($CantGanaE_CU*$PrecioCu);?></td>
	  <td align="right"><?php echo number_format(($CantGanaE_CU*$PrecioCu)*$TxtValorMoneda,'0',',','.');?></td>
	  <td align="center" class="Detalle04">&nbsp;</td>
	  <td align="center">COBRE</td>
	  <td align="right"><?php echo $CantGanaC_CU;?></td>
	  <td align="right"><?php echo $PrecioCu;?></td>
	  <td align="right"><?php echo ($CantGanaC_CU*$PrecioCu);?></td>
	  <td align="right"><?php echo number_format(($CantGanaC_CU*$PrecioCu)*$TxtValorMoneda,'0',',','.');?></td>
	  </tr>
	<tr align="center" class="ColorTabla02">
	  <td align="center">PLATA</td>
	  <td align="right"><?php echo $CantGanaE_AG;?></td>
	  <td align="right"><?php echo $PrecioAg;?></td>
	  <td align="right"><?php echo ($CantGanaE_AG*$PrecioAg);?></td>
	  <td align="right"><?php echo number_format(($CantGanaE_AG*$PrecioAg)*$TxtValorMoneda,'0',',','.');?></td>
	  <td align="center" class="Detalle04">&nbsp;</td>
	  <td align="center">PLATA</td>
	  <td align="right"><?php echo $CantGanaC_AG;?></td>
	  <td align="right"><?php echo $PrecioAg;?></td>
	  <td align="right"><?php echo ($CantGanaC_AG*$PrecioAg);?></td>
	  <td align="right"><?php echo number_format(($CantGanaC_AG*$PrecioAg)*$TxtValorMoneda,'0',',','.');?></td>
	  </tr>
	<tr align="center" class="ColorTabla02">
	  <td align="center">ORO</td>
	  <td align="right"><?php echo $CantGanaE_AU;?></td>
	  <td align="right"><?php echo $PrecioAu;?></td>
	  <td align="right"><?php echo ($CantGanaE_AU*$PrecioAu);?></td>
	  <td align="right"><?php echo number_format(($CantGanaE_AU*$PrecioAu)*$TxtValorMoneda,'0',',','.');?></td>
	  <td align="center" class="Detalle04">&nbsp;</td>
	  <td align="center">ORO</td>
	  <td align="right"><?php echo $CantGanaC_AU;?></td>
	  <td align="right"><?php echo $PrecioAu;?></td>
	  <td align="right"><?php echo ($CantGanaC_AU*$PrecioAu);?></td>
	  <td align="right"><?php echo number_format(($CantGanaC_AU*$PrecioAu)*$TxtValorMoneda,'0',',','.');?></td>
	  </tr>
	<tr align="center" class="detalle01">
	  <td colspan="3" align="right">Valor Neto </td>
	  <?php $ValorNeto=($CantGanaE_CU*$PrecioCu)+($CantGanaE_AG*$PrecioAg)+($CantGanaE_AU*$PrecioAu);?>
	  <td align="right"><?php echo number_format($ValorNeto,1,',','.');?></td>
	  <?php $ValorNetoPeso=(($CantGanaE_CU*$PrecioCu)*$TxtValorMoneda)+(($CantGanaE_AG*$PrecioAg)*$TxtValorMoneda)+(($CantGanaE_AU*$PrecioAu)*$TxtValorMoneda);?>
	  <td align="right"><?php echo number_format($ValorNetoPeso,0,',','.');?></td>
	  <td align="center" class="Detalle04">&nbsp;</td>
	  <td colspan="3" align="right">Valor Neto</td>
	  <?php $ValorNetoC=($CantGanaC_CU*$PrecioCu)+($CantGanaC_AG*$PrecioAg)+($CantGanaC_AU*$PrecioAu);?>
	  <td align="right"><?php echo number_format($ValorNetoC,1,',','.');?></td>
	  <?php $ValorNetoPesoC=(($CantGanaC_CU*$PrecioCu)*$TxtValorMoneda)+(($CantGanaC_AG*$PrecioAg)*$TxtValorMoneda)+(($CantGanaC_AU*$PrecioAu)*$TxtValorMoneda);?>
	  <td align="right"><?php echo number_format($ValorNetoPesoC,0,',','.');?></td>
	  </tr>
	<tr align="center" class="Detalle01">
	  <td colspan="3" align="right">19 % IVA</td>
	  <?php $IVA=($ValorNeto*0.19);?>
	  <td align="right"><?php echo number_format($IVA,1,',','.');?></td>
	  <?php $IVA2=($ValorNetoPeso*0.19);?>
	  <td align="right"><?php echo number_format($IVA2,0,',','.');?></td>
	  <td align="center" class="Detalle04">&nbsp;</td>
	  <td colspan="3" align="right">19 % IVA</td>
	  <?php $IVAC=($ValorNetoC*0.19);?>
	  <td align="right"><?php echo number_format($IVAC,1,',','.');?></td>
	  <?php $IVA2C=($ValorNetoPesoC*0.19);?>
	  <td align="right"><?php echo number_format($IVA2C,0,',','.');?></td>
	  </tr>
	<tr align="center" class="Detalle01">
	  <td colspan="3" align="right">TOTAL</td>
	  <td align="right"><?php echo number_format($ValorNeto+$IVA,1,',','.');?></td>
	  <td align="right"><?php echo number_format($ValorNetoPeso+$IVA2,0,',','.');?></td>
	  <td align="center" class="Detalle04">&nbsp;</td>
	  <td colspan="3" align="right">TOTAL</td>
	  <td align="right"><?php echo number_format($ValorNetoC+$IVAC,1,',','.');?></td>
	  <td align="right"><?php echo number_format($ValorNetoPesoC+$IVA2C,0,',','.');?></td>
	  </tr>
  </table>
	
</form>
</body>
</html>
