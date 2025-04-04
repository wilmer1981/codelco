<?php
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename="";
	if ( preg_match( '/MSIE/i', $userBrowser ) ) {
	$filename = urlencode($filename);
	}
	$filename = iconv('UTF-8', 'gb2312', $filename);
	$file_name = str_replace(".php", "", $file_name);
	header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
	header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
	
	header("content-disposition: attachment;filename={$file_name}");
	header( "Cache-Control: public" );
	header( "Pragma: public" );
	header( "Content-type: text/csv" ) ;
	header( "Content-Dis; filename={$file_name}" ) ;
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_principal.php");
	include("age_funciones.php");

	$TxtOrdenEns     = isset($_REQUEST["TxtOrdenEns"])?$_REQUEST["TxtOrdenEns"]:"";
	$TxtOrdenEnsaye  = isset($_REQUEST["TxtOrdenEnsaye"])?$_REQUEST["TxtOrdenEnsaye"]:"";
	$Calcular        = isset($_REQUEST["Calcular"])?$_REQUEST["Calcular"]:"";
	$EstadoInput     = isset($_REQUEST["EstadoInput"])?$_REQUEST["EstadoInput"]:"";
	$TxtFactura      = isset($_REQUEST["TxtFactura"])?$_REQUEST["TxtFactura"]:"";
	$TxtFechaFactura = isset($_REQUEST["TxtFechaFactura"])?$_REQUEST["TxtFechaFactura"]:"";
	$TxtFechaIni     = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:"";
	$TxtFechaFin     = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:"";
	$TxtValorMoneda  = isset($_REQUEST["TxtValorMoneda"])?$_REQUEST["TxtValorMoneda"]:"";
	$TipoMoneda      = isset($_REQUEST["TipoMoneda"])?$_REQUEST["TipoMoneda"]:"";
	$Petalo          = isset($_REQUEST["Petalo"])?$_REQUEST["Petalo"]:"";

	$Consulta ="select t2.nombre_subclase as nom_lab,t2.valor_subclase1,t2.valor_subclase2,t2.valor_subclase3,t2.valor_subclase4 from age_web.lotes t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='15009' and t1.laboratorio_externo=t2.cod_subclase ";
	$Consulta.="where t1.orden_ensaye='".$TxtOrdenEns."' order by t1.lote desc limit 1";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Resp);
	$NomLab=strtoupper($Fila["nom_lab"]);
	$CmbTipoMoneda=$Fila["valor_subclase1"];
	$PrecioCu=$Fila["valor_subclase2"];
	$PrecioAg=$Fila["valor_subclase3"];
	$PrecioAu=$Fila["valor_subclase4"];
	
	if($TxtOrdenEnsaye=="")
		$TxtOrdenEnsaye=$TxtOrdenEns;

	if($Calcular!='S')
	{	
		$Consulta="select * from age_web.facturacion_canje_leyes where orden_ensaye='".$TxtOrdenEns."'";
		$RespOrdenEns=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($RespOrdenEns))
		{
			$TxtFactura=$Fila["num_factura"];
			$TxtFechaFactura=$Fila["fecha_factura"];
			$TxtFechaIni=$Fila["fecha_moneda_desde"];
			$TxtFechaFin=$Fila["fecha_moneda_hasta"];
			$CmbTipoMoneda=$Fila["tipo_moneda"];
			$TxtValorMoneda=$Fila["valor_moneda"];
		}
	}	
?>
<html>
<head>
<title>AGE-Consulta Resultado Paquetes Arbitrales Excel</title>
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name='TxtOrdenEns' value="<?php echo $TxtOrdenEns;?>">
<table width="544"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02" align="center">
    <td colspan="4"><strong>FACTURACION CANJE LABORATORIO "<?php echo $NomLab;?>"</strong></td>
  </tr>
  <tr class="Colum01">
    <td width="91" class="Colum01">Factura N&deg;:</td>
    <td class="Colum01"><?php echo $TxtFactura; ?></td>
  </tr>
   <tr class="Colum01">
    <td width="91" class="Colum01">Orden Ensaye :</td>
    <td width="438" class="Colum01"><?php echo $TxtOrdenEnsaye; ?></tr>
  <tr class="Colum01">
    <td width="91" class="Colum01">Fecha Factura:</td>
    <td width="438" class="Colum01"><?php echo $TxtFechaFactura; ?></tr>
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
    <td width="438" class="Colum01"><?php echo str_replace('.',',',$TxtValorMoneda); ?><input name="TxtValorMoneda" type="hidden" class="InputCen" value="<?php echo str_replace('.',',',$TxtValorMoneda); ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');">      </tr>
  <tr align="center" class="Colum01">
	  <td height="30" colspan="4" class="Colum01">Del <?php echo $TxtFechaIni; ?>
	    Al
      <?php echo $TxtFechaFin; ?></td>
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
			$Consulta="select * from age_web.leyes_por_lote_canje where lote='".$Fila["lote"]."' and paquete_canje='3'";
			$RespLeyes=mysqli_query($link, $Consulta);
			while($FilaLeyes=mysqli_fetch_array($RespLeyes))
			{
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][2]=$FilaLeyes["valor1"];
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][3]=$FilaLeyes["valor2"];
				$ArrLeyesCanje[$FilaLeyes["cod_leyes"]][4]=$FilaLeyes["valor3"];
			}
			reset($ArrLeyesCanje);
			foreach($ArrLeyesCanje as $c=>$v)
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
			foreach($ArrLeyesCanje as $c=>$v)
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
	  <td align="right"><?php echo ((float)$CantGanaE_CU*(float)$PrecioCu);?></td>
	  <td align="right"><?php echo number_format(((float)$CantGanaE_CU*(float)$PrecioCu)*(float)$TxtValorMoneda,'0',',','.');?></td>
	  <td align="center" class="Detalle04">&nbsp;</td>
	  <td align="center">COBRE</td>
	  <td align="right"><?php echo $CantGanaC_CU;?></td>
	  <td align="right"><?php echo $PrecioCu;?></td>
	  <td align="right"><?php echo ((float)$CantGanaC_CU*(float)$PrecioCu);?></td>
	  <td align="right"><?php echo number_format(((float)$CantGanaC_CU*(float)$PrecioCu)*(float)$TxtValorMoneda,'0',',','.');?></td>
	  </tr>
	<tr align="center" class="ColorTabla02">
	  <td align="center">PLATA</td>
	  <td align="right"><?php echo $CantGanaE_AG;?></td>
	  <td align="right"><?php echo $PrecioAg;?></td>
	  <td align="right"><?php echo ((float)$CantGanaE_AG*(float)$PrecioAg);?></td>
	  <td align="right"><?php echo number_format(((float)$CantGanaE_AG*(float)$PrecioAg)*(float)$TxtValorMoneda,'0',',','.');?></td>
	  <td align="center" class="Detalle04">&nbsp;</td>
	  <td align="center">PLATA</td>
	  <td align="right"><?php echo $CantGanaC_AG;?></td>
	  <td align="right"><?php echo $PrecioAg;?></td>
	  <td align="right"><?php echo ((float)$CantGanaC_AG*(float)$PrecioAg);?></td>
	  <td align="right"><?php echo number_format(((float)$CantGanaC_AG*(float)$PrecioAg)*(float)$TxtValorMoneda,'0',',','.');?></td>
	  </tr>
	<tr align="center" class="ColorTabla02">
	  <td align="center">ORO</td>
	  <td align="right"><?php echo $CantGanaE_AU;?></td>
	  <td align="right"><?php echo $PrecioAu;?></td>
	  <td align="right"><?php echo ((float)$CantGanaE_AU*(float)$PrecioAu);?></td>
	  <td align="right"><?php echo number_format(((float)$CantGanaE_AU*(float)$PrecioAu)*(float)$TxtValorMoneda,'0',',','.');?></td>
	  <td align="center" class="Detalle04">&nbsp;</td>
	  <td align="center">ORO</td>
	  <td align="right"><?php echo $CantGanaC_AU;?></td>
	  <td align="right"><?php echo $PrecioAu;?></td>
	  <td align="right"><?php echo ((float)$CantGanaC_AU*(float)$PrecioAu);?></td>
	  <td align="right"><?php echo number_format(((float)$CantGanaC_AU*(float)$PrecioAu)*(float)$TxtValorMoneda,'0',',','.');?></td>
	  </tr>
	<tr align="center" class="detalle01">
	  <td colspan="3" align="right">Valor Neto </td>
	  <?php $ValorNeto=((float)$CantGanaE_CU*(float)$PrecioCu)+((float)$CantGanaE_AG*(float)$PrecioAg)+((float)$CantGanaE_AU*(float)$PrecioAu);?>
	  <td align="right"><?php echo number_format($ValorNeto,1,',','.');?></td>
	  <?php $ValorNetoPeso=(((float)$CantGanaE_CU*(float)$PrecioCu)*(float)$TxtValorMoneda)+(((float)$CantGanaE_AG*(float)$PrecioAg)*(float)$TxtValorMoneda)+(((float)$CantGanaE_AU*(float)$PrecioAu)*(float)$TxtValorMoneda);?>
	  <td align="right"><?php echo number_format($ValorNetoPeso,0,',','.');?></td>
	  <td align="center" class="Detalle04">&nbsp;</td>
	  <td colspan="3" align="right">Valor Neto</td>
	  <?php $ValorNetoC=((float)$CantGanaC_CU*(float)$PrecioCu)+((float)$CantGanaC_AG*(float)$PrecioAg)+((float)$CantGanaC_AU*(float)$PrecioAu);?>
	  <td align="right"><?php echo number_format($ValorNetoC,1,',','.');?></td>
	  <?php $ValorNetoPesoC=(((float)$CantGanaC_CU*(float)$PrecioCu)*(float)$TxtValorMoneda)+(((float)$CantGanaC_AG*(float)$PrecioAg)*(float)$TxtValorMoneda)+(((float)$CantGanaC_AU*(float)$PrecioAu)*(float)$TxtValorMoneda);?>
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
