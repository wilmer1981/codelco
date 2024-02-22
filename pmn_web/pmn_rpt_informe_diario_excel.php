<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");					
ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
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


if($VisibleDivProceso=='S')
$VisibleDiv='hidden';

if(!isset($FDesde))
	$FDesde=date('Y-m-d');
	
$SelTarea=$NivelOrg;
?>
<html>
<head>
<title>Consulta Histrica</title>
<form name="FrmPrincipal" method="post" action="">
<table width="100%" border="1" cellspacing="0" cellpadding="0">
<tr>
<td align="center" colspan="8" class="TituloCabecera2"> <strong>NOVEDADES JEFE DE TURNO</strong></td>
</tr>
<tr>
<td align="center" colspan="2" class="TituloCabecera2">Fecha</td>
<td align="center" class="TituloCabecera2"><?php echo $FDesde;?></td>
<td align="center" class="TituloCabecera2">Jefe de Turno</td>
<td align="center" class="TituloCabecera2"><?php echo $CookieRut?></td>
<td align="center" class="TituloCabecera2">Turno</td>
<td width="5%" align="center" class="TituloCabecera2"><?php if($cmbturno=='T') { echo "Todos"; } if($cmbturno=='1'){ echo "A";}if($cmbturno=='2'){ echo "B";} if($cmbturno=='3'){ echo "C";}?></td>
</tr>
</table>
<br>
		<table width="100%" border="1" cellspacing="0" cellpadding="0">
		  <tr>
			<td colspan="8" align="center" class="TituloCabecera2">LIXIVIACION</td>
		  </tr>
		  <tr>
			<td width="18%" rowspan="2" align="center" class="texto_bold">Lixiviadores</td>
			<td colspan="3" align="center" class="texto_bold">Carga de Lixiviadores </td>
			<td width="14%" align="center" class="texto_bold">Adici&oacute;n</td>
			<td width="17%" align="center" class="texto_bold">Hora</td>
			<td colspan="2" align="center" class="texto_bold">Producci&oacute;n</td>
		  </tr>
		  <tr>
			<td width="7%" align="center" class="texto_bold">N&ordm;</td>
			<td width="8%" align="center" class="texto_bold">Hora</td>
			<td width="17%" align="center" class="texto_bold">con TK N&ordm; </td>
			<td align="center" class="texto_bold">H2So4 lts </td>
			<td align="center" class="texto_bold">Filtrado</td>
			<td width="9%" align="center" class="texto_bold">Fecha</td>
			<td width="10%" align="center" class="texto_bold">Peso B.A.D</td>
		  </tr>
		  <?php
			  $ConLixi=" select * from lixiviacion_barro_anodico where fecha='".$FDesde."'";
			  if($cmbturno!='T')	  	
				  $ConLixi.=" and turno='".$cmbturno."' ";
			  $ConLixi.=" order by lixiviador,num_lixiviacion";	  
			  $RespLixi=mysqli_query($link, $ConLixi);
			  while($FilaLixi=mysqli_fetch_array($RespLixi))
			  {
			  ?>
				  <tr class="formulario" bgcolor="#CCCCCC">
					<td align="left"><?php echo "Lixiviador N&deg; ".$FilaLixi[lixiviador];?></td>
					<td align="right"><?php echo $FilaLixi[num_lixiviacion];?></td>
					<td align="right"><?php echo $FilaLixi[hora_carga];?></td>
					<td><?php echo "&nbsp;"?>&nbsp;</td>
					<td><?php echo "&nbsp;"?>&nbsp;</td>
					<td align="right"><?php echo $FilaLixi[hora_filtracion];?></td>
					<td align="right"><?php echo $FilaLixi[fecha_carga];?></td>
					<td align="right"><?php echo $FilaLixi[bad];?></td>
				  </tr>
				  <?php
			  }
			  ?>
  </table>
		<BR>
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="13" align="center" class="TituloCabecera2">PLANTA DE SELENIO </td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="texto_bold">Hornos en Proceso </td>
            <td colspan="4" align="center" class="texto_bold">Beneficio Barro </td>
            <td align="center" colspan="2" class="texto_bold">Producci&oacute;n Calcina </td>
            <td width="13%" rowspan="2" align="center" class="texto_bold"><p>Stock Calcina </p></td>
          </tr>
          <tr>
            <td width="14%" align="center" class="texto_bold">Carga N&ordm; </td>
            <td width="9%" align="center" class="texto_bold">Fecha</td>
            <td width="12%" align="center" class="texto_bold">BAD DV </td>
            <td width="12%" align="center" class="texto_bold">BAD CN </td>
            <td width="6%" align="center" class="texto_bold">Rep.</td>
            <td width="8%" align="center" class="texto_bold">Total</td>
	        <td width="15%" align="center" class="texto_bold">Fecha Filtrado</td>
            <td width="11%" align="center" class="texto_bold">KG.</td>
          </tr>
          <?php
	//  $ConSele="select * from deselenizacion t1 left join detalle_deselenizacion t2 on t1.num_horno=t2.num_horno and t1.num_funda=t2.num_funda and t1.hornada_total=t2.hornada_total and t1.hornada_parcial=t2.hornada_parcial where t1.fecha='".$FDesde."' ";
	  $ConSele="select * from deselenizacion t1 where t1.fecha='".$FDesde."' ";
	  if($cmbturno!='T')
	  	$ConSele.=" and turno='".$cmbturno."'";
	  $ConSele.=" group by t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial order by t1.num_horno";	
	  //echo $ConSele;
	  $RespSele=mysqli_query($link, $ConSele);	$Total=0;
	  while($FilaSele=mysqli_fetch_array($RespSele))
	  {
	  	$Hornada=$FilaSele[num_horno]."-".$FilaSele[num_funda]."-".$FilaSele[hornada_total]."-".$FilaSele[hornada_parcial];
		
			//----------CONSULTO SI HAY REPROCESOS
			$ConCal="select sum(bad) as valorBADRep from pmn_web.detalle_deselenizacion where";
			$ConCal.=" num_horno='".$FilaSele[num_horno]."' and num_funda='".$FilaSele[num_funda]."' and hornada_total='".$FilaSele[hornada_total]."' and hornada_parcial='".$FilaSele[hornada_parcial]."'";
			$ConCal.=" and referencia like '%r%'";
			$RespCal=mysqli_query($link, $ConCal);$BADREP=0;
			if($FilaCal=mysqli_fetch_array($RespCal))
				$BADREP=$FilaCal[valorBADRep];
			//----------CONSULTO BAD ventanas
			$ConCal="select sum(bad) as valorBADDV from pmn_web.detalle_deselenizacion where";
			$ConCal.=" num_horno='".$FilaSele[num_horno]."' and num_funda='".$FilaSele[num_funda]."' and hornada_total='".$FilaSele[hornada_total]."' and hornada_parcial='".$FilaSele[hornada_parcial]."'";
			$ConCal.=" and referencia not like '%r%' and cod_producto='' and cod_subproducto=''";
			//echo $ConCal;
			$RespCal=mysqli_query($link, $ConCal);$BADDV=0;
			if($FilaCal=mysqli_fetch_array($RespCal))
				$BADDV=$FilaCal[valorBADDV];
			//----------CONSULTO BAD CODELCO NORTE
			$ConCal="select sum(bad) as valorBADCN from pmn_web.detalle_deselenizacion where";
			$ConCal.=" num_horno='".$FilaSele[num_horno]."' and num_funda='".$FilaSele[num_funda]."' and hornada_total='".$FilaSele[hornada_total]."' and hornada_parcial='".$FilaSele[hornada_parcial]."'";
			$ConCal.=" and cod_producto='25' and cod_subproducto='5'";
			$RespCal=mysqli_query($link, $ConCal);$BADCN=0;
			if($FilaCal=mysqli_fetch_array($RespCal))
				$BADCN=$FilaCal[valorBADCN];

			$Total=$BADCN+$BADDV+$BADREP;
			
			$AnoMes=explode('-',$FDesde);
			$ConStock="select sf_p from stock_pmn where cod_producto='36' and cod_subproducto='1' and ano='".$AnoMes[0]."' and mes='".$AnoMes[1]."'";
			$RespStock=mysqli_query($link, $ConStock);
			$FilaStock=mysqli_fetch_array($RespStock);
			$StockCal=$FilaStock[sf_p];
	  ?>
          <tr bgcolor="#CCCCCC">
            <td align="center"><?php echo $Hornada;?></td>
            <td align="center"><?php echo $FilaSele["fecha"];?>&nbsp;</td>
            <td align="right"><?php echo number_format($BADDV,4,',','.');?></td>
            <td align="right"><?php echo number_format($BADCN,4,',','.');?></td>
            <td align="right"><?php echo number_format($BADREP,4,',','.');?></td>
            <td align="right"><?php echo number_format($Total,4,',','.');?></td>
			<td align="right"><?php echo $FilaSele[fecha_salida];?>&nbsp;</td>
			<td align="right"><?php echo number_format($FilaSele[prod_calcina],0,',','.');?></td>
            <td align="right"><?php echo number_format($StockCal,4,',','.');?></td>
          </tr>
          <?php
	  }
	  ?>
        </table>
		<br>
		<table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="9" align="center" class="TituloCabecera2">HORNO TROF </td>
          </tr>
          <tr>
            <td width="11%" align="center" class="texto_bold">Hornada</td>
            <td colspan="3" align="center" class="texto_bold">Fecha de Inicio Fusi&oacute;n </td>
            <td colspan="3" align="center" class="texto_bold">Fecha Inicio Oxidaci&oacute;n </td>
            <td colspan="2" align="center" class="texto_bold">Horas de </td>
          </tr>
          <tr>
            <td rowspan="2" align="center" class="texto_bold">N&ordm;</td>
            <td width="12%" rowspan="2" align="center" class="texto_bold">Fecha Hora </td>
            <td colspan="2" align="center" class="texto_bold">Carga Acumulada </td>
            <td width="13%" rowspan="2" align="center" class="texto_bold">Fecha Hora </td>
            <td colspan="2" align="center" class="texto_bold">Carga Acumulada </td>
            <td width="11%" rowspan="2" align="center" class="texto_bold">Fusi&oacute;n Acum. </td>
            <td width="10%" rowspan="2" align="center" class="texto_bold">Oxidac. Acum. </td>
          </tr>
          <tr>
            <td width="12%" align="center" class="texto_bold">Calcina (Kg) </td>
            <td width="12%" align="center" class="texto_bold">Otros (Kg) </td>
            <td width="10%" align="center" class="texto_bold">Restos (Kg) </td>
            <td width="9%" align="center" class="texto_bold">Otros (Kg) </td>
          </tr>
          <?php
		$AnoMes=explode('-',$FDesde);
		$Ano=$AnoMes[0];
		$Mes=$AnoMes[1];
		$Consulta = "select * from pmn_web.carga_horno_trof t1 left join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t1.turno = t2.cod_subclase left join proyecto_modernizacion.subproducto t3 on t1.cod_producto = t3.cod_producto ";
		$Consulta.= " and t1.cod_subproducto = t3.cod_subproducto ";
		$Consulta.= " where t2.cod_clase = 1 ";
		//$Consulta.= " and hornada = '581113'";
		$Consulta.= " and fecha = '".$FDesde."'";
		$Consulta.= " group by t1.hornada order by t1.turno, t1.cod_producto, t1.cod_subproducto";
		//echo $Consulta."<br>";		
		$Respuesta = mysqli_query($link, $Consulta);		

		$i=1;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			$Consulta = "select t1.cod_producto,t1.cod_subproducto,sum(cantidad) as cantidad from pmn_web.carga_horno_trof t1 left join proyecto_modernizacion.sub_clase t2 ";
			$Consulta.= " on t1.turno = t2.cod_subclase left join proyecto_modernizacion.subproducto t3 on t1.cod_producto = t3.cod_producto ";
			$Consulta.= " and t1.cod_subproducto = t3.cod_subproducto ";
			$Consulta.= " where t2.cod_clase = 1 ";
			$Consulta.= " and hornada = '".$Row[hornada]."'";
			//$Consulta.= " and t1.cod_producto='".$Row["cod_producto"]."' and t1.cod_subproducto='".$Row["cod_subproducto"]."'";
			$Consulta.= " and fecha = '".$FDesde."'";
			$Consulta.= " group by t1.cod_producto,t1.cod_subproducto order by t1.turno, t1.cod_producto, t1.cod_subproducto";
			//echo $Consulta."<br>";		
			$Respuesta2 = mysqli_query($link, $Consulta);$Calcina=0;$Restos=0;	$OtrosOxidos=0;	
			$i=1;
			while ($Row2 = mysqli_fetch_array($Respuesta2))
			{
				if($Row2["cod_producto"]=='36' && $Row2["cod_subproducto"]=='1')
					$Calcina=$Row2[cantidad];
				if($Row2["cod_producto"]=='19')//RESTOS DE ANODOS
					$Restos=$Row2[cantidad];				
					
				//----------------CIRCULANTES Y OXIDO PLATA COBRE-------------			
				if($Row2["cod_producto"]=='42'||$Row2["cod_producto"]=='39'||$Row2["cod_producto"]=='29'||$Row2["cod_producto"]=='28')
					$OtrosOxidos=$Row2[cantidad];						
			}
			
			
			$Consulta3 = "select * from pmn_web.produccion_horno_trof ";
			//$Consulta.= " where fecha = '".$FDesde."'";
			$Consulta3.= " where hornada = '".$Row[hornada]."'";
			//echo $Consulta3;
			$Respuesta3 = mysqli_query($link, $Consulta3);
			if ($Row3 = mysqli_fetch_array($Respuesta3))
			{
				$Hornada = $Row3[hornada];
				$Obs = $Row3["observacion"];
				$GasIni = $Row3[gas_natural_ini];
				$GasFin = $Row3[gas_natural_fin];
				$NumAnodos = $Row3[num_anodos];
				$Peso = $Row3["peso"];
				$Operador = $Row3[operador];
				$Color = $Row3[color];
				$FHMol=explode(' ',$Row3[fechaH_moldeo]);			
				$HoraMol=$FHMol[1];
				$FechaMol=$FHMol[0];
				$HFusion=$Row3[horas_fusion];
				$HOxida=$Row3[horas_oxidacion];
			}
			echo "<tr bgcolor='#CCCCCC'>";
			echo "<td align='center'>".$Row[hornada]."&nbsp;</td>\n";
			echo "<td align='center'>".$Row["fecha"]."&nbsp;</td>\n";
			echo "<td align='center'>".number_format($Calcina,4,',','.')."</td>\n";
			echo "<td align='center'>0</td>\n";
			echo "<td align='center'>".$Row["fecha"]."&nbsp;</td>\n";
			echo "<td align='center'>".number_format($Restos,4,',','.')."</td>\n";
			echo "<td align='center'>".number_format($OtrosOxidos,4,',','.')."</td>\n";
			echo "<td align='center'>".$HFusion."</td>\n";
			echo "<td align='center'>".$HOxida."</td>\n";
			echo "</tr>\n";
			$i++;
			$Hornada=$Row[hornada];
		}
		//----------------------CONSULTO DATOS EN PESTA&Ntilde;A PRODUCCI&Oacute;N---------------------------
		?>
        </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="center" class="texto_bold">Moldeo</td>
                  <td colspan="3" align="center" class="texto_bold">Muestra</td>
                </tr>
                <tr>
                  <td width="15%" align="center" class="texto_bold">Hora</td>
                  <td width="16%" align="center" class="texto_bold">Fecha</td>
                  <td width="12%" align="center" class="texto_bold">Te (Ppm) </td>
                  <td width="12%" align="center" class="texto_bold">Se (Ppm) </td>
                  <td width="13%" align="center" class="texto_bold">Cu (%) </td>
                </tr>
                <tr bgcolor="#CCCCCC">
                  <td align="center"><?php echo $HoraMol;?>&nbsp;</td>
                  <td align="center"><?php echo $FechaMol;?>&nbsp;</td>
                  <?php
				//------------------------------Muestras-------------------------------
				$Consulta = "select t1.cod_leyes, t2.abreviatura, t1.muestra01, t1.muestra02, t1.muestra03,t3.abreviatura as AbrevUni,hora01,hora02,hora03 ";
				$Consulta.= " from pmn_web.leyes_prod_horno_trof t1 inner join proyecto_modernizacion.leyes t2 on ";
				$Consulta.= " t1.cod_leyes = t2.cod_leyes ";
				$Consulta.=" inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad  ";
				//$Consulta.= " where fecha = '".$FDesde."'";
				$Consulta.= " and hornada = '".$Hornada."'";
				$Consulta.= " order by cod_leyes desc";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);
				$i=1;
				while ($Row = mysqli_fetch_array($Respuesta))
				{
				  ?>
                  <td align="right"><?php echo number_format($Row[muestra01],4,',','.');?></td>
                  <?php
				}
				?>
                </tr>
            </table></td>
            <td valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2" align="center" class="texto_bold">Producci&oacute;n</td>
                </tr>
                <tr>
                  <td align="center" class="texto_bold">N&ordm; Anodos </td>
                  <td align="center" class="texto_bold">Peso Kg. </td>
                </tr>
                <tr bgcolor="#CCCCCC">
                  <td align="right"><?php echo number_format($NumAnodos,4,',','.');?></td>
                  <td align="right"><?php echo number_format($Peso,4,',','.');?></td>
                </tr>
            </table></td>
            <td valign="top"><!--			  <table width="100%" border="1" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="55%" class="texto_bold">Anodos Acumulado </td>
				  <td width="45%" bgcolor="#CCCCCC">&nbsp;</td>
				</tr>
				<tr>
				  <td class="texto_bold">Peso Kg. </td>
				  <td bgcolor="#CCCCCC">&nbsp;</td>
				</tr>
			  </table>
-->
            </td>
          </tr>
        </table>
		<br>
		<table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="11" align="center" class="TituloCabecera2">ELECTROLISIS DE PLATA </td>
          </tr>
          <tr>
            <td width="8%" rowspan="2" align="center" class="texto_bold">Grupos</td>
            <td width="14%" align="center" class="texto_bold">Electr&oacute;lisis</td>
            <td colspan="3" align="center" class="texto_bold">Carga de Anodos </td>
            <td colspan="3" align="center" class="texto_bold">Descarga</td>
            <td width="5%" rowspan="2" align="center" class="texto_bold">Barro Acum. </td>
          </tr>
          <tr>
            <td align="center" class="texto_bold">N&ordm;</td>
            <td width="7%" align="center" class="texto_bold">Cantidad</td>
            <td width="11%" align="center" class="texto_bold">Fecha</td>
            <td width="13%" align="center" class="texto_bold">Peso Kg.</td>
            <td width="17%" align="center" class="texto_bold">Fecha</td>
            <td width="18%" align="center" class="texto_bold">Restos (Kg) </td>
            <td width="7%" align="center" class="texto_bold">Barro (Kg) </td>
          </tr>
          <?php
				$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
				$Consulta.= " where fecha='".$FDesde."'";
				if($cmbturno!='T')
					$Consulta.= " where turno='".$cmbturno."'";	  
				$Consulta.= " group by grupo,fecha order by turno, grupo, num_electrolisis, hornada, correlativo";
				//echo $Consulta;
				$Respuesta = mysqli_query($link, $Consulta);
				$i=1;
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					?>
          <tr class="formulario" bgcolor="#CCCCCC">
            <td align="center"><?php echo "M - ".$Row["grupo"];?></td>
            <td align="center"><?php echo $Row[num_electrolisis];?></td>
            <?php
					 $SumaCant="select * from pmn_web.carga_electrolisis_plata where fecha='".$FDesde."' and grupo='".$Row["grupo"]."'";
					 $RespCant=mysqli_query($link, $SumaCant);$Cant='0';$Hornadas='';$Peso='0';
					 while($FilaCant=mysqli_fetch_array($RespCant))
					 {
						$Cant=$Cant+$FilaCant[cant_anodos];
						$Hornadas=$Hornadas.$FilaCant[hornada].", ";
						$Peso=$Peso+$FilaCant[peso_anodos];
					 }	
					 if($Hornadas !='')
						$Hornadas=substr($Hornadas,0,strlen($Hornadas)-2);		
					?>
            <td align="right"><?php echo $Cant;?></td>
            <td align="center"><?php echo $Row["fecha"];?></td>
            <td align="right"><?php echo number_format($Peso,4,',','.');?></td>
            <?php
					$ConDesc="select * from descarga_electrolisis_plata where num_electrolisis='".$Row[num_electrolisis]."'";
					$RespDesc=mysqli_query($link, $ConDesc);
					if($FilaDesc=mysqli_fetch_array($RespDesc))
					{
						$FechaDes=$FilaDesc["fecha"];
						$Restos=$FilaDesc[peso_resto];
						$Barro=$FilaDesc[peso_aurifero];
					}
					?>
            <td align="center"><?php echo $FechaDes;?>&nbsp;</td>
            <td align="right"><?php echo number_format($Restos,4,',','.');?></td>
            <td align="right"><?php echo number_format($Barro,4,',','.');?></td>
            <td align="right"><?php echo "&nbsp;";?></td>
          </tr>
          <?php	
					$i++;
				}
	   ?>
          <tr>
            <td colspan="11" class="formulario">&nbsp;</td>
          </tr>
        </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><table width="100%" border="1" cellspacing="0" cellpadding="0" style="vertical-align:top;">
			  <tr>
				<td colspan="6" align="center" class="TituloCabecera2">LIXIVIACION DE ORO </td>
			  </tr>
			<tr>
			  <td rowspan="2" align="center" class="formulario">Correlativo Cargado </td>
			  <td colspan="2" align="center" class="formulario">Fecha de Carga Bajando</td>
			</tr>
			<tr>
			  <td align="center" class="formulario">Fecha</td>
			  <td align="center" class="formulario">Peso (Kg) </td>
			</tr>
			<?php
			 $Consulta="select * from carga_lixiviacion_barro_aurifero where fecha='".$FDesde."'";
			 if($cmbturno!='T')
				$Consulta.= " where turno='".$cmbturno."'";	 
			 $Consulta.= " order by num_electrolisis";	 
			 $Resp=mysqli_query($link, $Consulta);	
			 while($Filas=mysqli_fetch_assoc($Resp))
			 { 
			?>
				<tr bgcolor="#CCCCCC">
					<td class="formulario"><?php echo $Filas[correlativo];?></td>
					<td class="formulario" align="center"><?php echo $Filas["fecha"];?></td>
					<td class="formulario" align="right"><?php echo number_format($Filas["peso"],2,',','.');?></td>
				</tr>
			<?php
			}
			?>
			</table></td>
			<td><table width="100%" border="1" cellspacing="0" cellpadding="0">
			  <tr>
				<td colspan="4" align="center" class="TituloCabecera2">ELECTROLISIS DE ORO </td>
			  </tr>
			  <tr>
				<td align="center" class="formulario">Elec.</td>
				<td align="center" class="formulario">N&ordm;</td>
				<td colspan="2" align="center" class="formulario">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="center" class="formulario">N&ordm;</td>
				<td align="center" class="formulario">Anodos</td>
				<td align="center" class="formulario">Fecha</td>
				<td align="center" class="formulario">Peso</td>
			  </tr>
			  <?php
					$Consulta="select * from carga_electrolisis_oro where fecha='".$FDesde."'";
					if($cmbturno!='T')
						$Consulta.=" and turno='".$cmbturno."'";
					$Resp=mysqli_query($link, $Consulta);	
					while($Filas=mysqli_fetch_array($Resp))
					{
					?>
			  <tr bgcolor="#CCCCCC">
				<td align="center" class="formulario"><?php echo $Filas[num_electrolisis];?></td>
				<td align="right" class="formulario"><?php echo $Filas[cant_anodos];?></td>
				<td align="center" class="formulario"><?php echo $Filas["fecha"];?></td>
				<td align="right" class="formulario"><?php echo number_format($Filas[peso_anodos],2,',','.');?></td>
			  </tr>
			  <?php
					}
					?>
			</table></td>
		  </tr>
		</table>	
</form>
</body>
</html>
<?php
echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";
?>

