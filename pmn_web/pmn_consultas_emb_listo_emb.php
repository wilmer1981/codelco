<?php
include("../principal/conectar_pmn_web.php");	
include("pmn_funciones.php");

$Pag    = isset($_REQUEST["Pag"])?$_REQUEST["Pag"]:"";
$Buscar = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
$xls = isset($_REQUEST["xls"])?$_REQUEST["xls"]:"";
$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date('Y');
$Mes = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date('m');
$EmbChk = isset($_REQUEST["EmbChk"])?$_REQUEST["EmbChk"]:'N';

if($xls=='')
{
?>
<title>Consultas</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="javascript">

var popup=0;
function Proceso(Proc,Pag)
{
	var f=document.PrinElectPLata;
	switch(Proc)
	{
		case "B":
			f.action="pmn_consultas_emb_listo_emb.php?Pag="+Pag+"&Buscar=S&Mes="+f.Mes.value;
			f.submit();
		break
		case "EX":
			var URL = "pmn_consultas_emb_listo_emb.php?&xls=S&Mes="+f.Mes.value;
			window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=162";
			f.submit();
		break;		
	}
}	
function DetalleLotePMN(Lote,Prod,SubProd)
{
	var URL = "pmn_detalle_leyes.php?xls=S&NumLote="+Lote+"&Producto="+Prod+"&SubProducto="+SubProd;
	window.open(URL,"","top=120,left=30,width=780,height=350,menubar=no,resizable=yes,scrollbars=yes");
}	
</script>
<style type="text/css">

.Estilo7 {font-size: 14px}

</style>
<?php
$Chk1='checked="checked"';
$Chk2='';
if($EmbChk=='S')
{
	$Chk1='';
	$Chk2='checked="checked"';
}	
?>
<form name="PrinElectPLata" method="post">
<table width="60%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="0" cellpadding="0"  cellspacing="2">
      <tr>
        <td width="98" height="35" align="left" class="formulario"   ><img src="archivos/LblCriterios.png" /> </td>
        <td colspan="4" align="center" valign="top" class="formulario Estilo7">Lotes listos para Embarcar / Embarcados </td>
        <td width="214" align="right" class="formulario">
		<a href="JavaScript:Proceso('B','3')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="javascript:Proceso('EX','3')"><img src="archivos/excel.png" alt='Excel' width="25" height="25" border="0" align="absmiddle" /></a> &nbsp;
		<a href="javascript:window.print()"><img src="archivos/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp; 
		<a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle" /></a></td>
        <td width="10" align="right" class="formulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="formulario">Mes</td>
        <td colspan="4" class="formulario"><span class="ColorTabla02">
          <select name="Mes">
            <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($Mes))
			{
				if ($Mes == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}/*
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}*/
		}
		?>
          </select>
        </span></td>
        </tr>
      <tr>
        <td colspan="6" class="formulario">
		<?php
		  $Consulto="select cod_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='6000' and cod_subclase in('1','2')";
		  $Resp=mysqli_query($link, $Consulto);	
		  while($Fila=mysqli_fetch_assoc($Resp))
		  {
			  if(strtolower($Fila["cod_subclase"])=='1')	
				  $ValorOro=str_replace('%','',$Fila['valor_subclase1']);
			  if(strtolower($Fila["cod_subclase"])=='2')	
				  $ValorPlata=str_replace('%','',$Fila['valor_subclase1']);
		  }	  
		  echo "Valores limite Oro: ".number_format($ValorOro,2,',','')."%, Plata: ".number_format($ValorPlata,2,',','')."%";				
		?>
		&nbsp;</td>
        </tr>
    </table></td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"></td>
  </tr>
</table>
<br />
<br />
<table width="60%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td height="1%" background="archivos/images/interior/izquierdo.png">&nbsp;</td>
    <td width="98%" align="center" height="15"><h5><strong>Lotes BAD listos para Embarcar y Embarcados</strong></h5></td>
    <td height="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"> </td>
    <td align="center">
	<table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
      <tr align="center" class="TituloCabeceraAzul">
        <td align="center" colspan="13">Listos para Embarcar</td>
        <td align="center" colspan="2">Embarcados</td>
	</tr>
      <tr align="center" class="TituloCabeceraAzul">
        <td width="17" height="30" align="center">S.A</td>
        <td width="25" height="15" class="TituloCabeceraAzul">Lote</td>
        <td width="37">Hdo Kg</td>
        <td width="70">Seco Kg</td>
        <td width="67">H2O %</td>
        <td width="48">Cu %</td>
        <td width="60">Ag %</td>
        <td width="60">Ag Kg/Ton</td>
        <td width="62">Au %</td>
        <td width="62">Au Kg/Ton</td>
        <td width="59">Cu Kg</td>
        <td width="54">Ag Gr</td>
        <td width="53">Au Gr</td>
        <td width="94">Palet Embarcados</td>
        <td width="72">Lote Camion</td>
      </tr>
      <?php
		$Mes = str_pad($Mes,2,'0',STR_PAD_LEFT);
		$FinoTotCu=0;$FinoTotAg=0;$FinoTotAu=0;$TotalFinoCu=0;$TotalFinoAg=0;$TotalFinoAu=0;
		$Consulta = "SELECT * from pmn_web.pmn_pesa_bad_cabecera ";
		$Consulta.= " where month(fecha_hora)='".$Mes."' group by lote";
		$Respuesta = mysqli_query($link, $Consulta);
		$Total02=0;
		$Total03=0;

	    while ($Row = mysqli_fetch_array($Respuesta))
	    {
			$Consulta = "SELECT * from pmn_web.pmn_pesa_bad_cabecera t1 inner join pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote";
			$Consulta.= " where t1.lote='".$Row["lote"]."'";
			$Consulta.= " order by t2.lote,t2.recargo";
			echo "<input type='hidden' name='selec'>";
			$Respuesta2 = mysqli_query($link, $Consulta);
			$PesoHdo=0;
			while ($Row2 = mysqli_fetch_array($Respuesta2))
				$PesoHdo=$PesoHdo+$Row2["pneto"];
				
			$Consulta = "SELECT palet_a_b,correlativo_sipa from pmn_web.pmn_pesa_bad_detalle";
			$Consulta.= " where lote='".$Row["lote"]."'";
			$Consulta.= " group by palet_a_b";
			//echo $Consulta."<br>";
			$Respuesta2 = mysqli_query($link, $Consulta);
			$EmbarcadosPalet='';$CorrSipas='';
			while ($Row2 = mysqli_fetch_array($Respuesta2))
			{	
			$EmbarcadosPalet=$EmbarcadosPalet.$Row2["palet_a_b"].", ";
			$CorrSipas=$CorrSipas.$Row2["correlativo_sipa"].", ";
			}
			$EmbarcadosPalet=substr($EmbarcadosPalet,0,strlen($EmbarcadosPalet)-2);
			$CorrSipas=substr($CorrSipas,0,strlen($CorrSipas)-2);
				
			$RespSa=mysqli_query($link, "SELECT nro_solicitud, nro_sa_lims from cal_web.solicitud_analisis where id_muestra='".$Row["lote"]."' and recargo in('0','') and nro_solicitud is not null");
			//echo "select nro_solicitud from cal_web.solicitud_analisis where id_muestra='".$Row["lote"]."' and recargo='0' and nro_solicitud is not null<br>";
			$FilaSa=mysqli_fetch_assoc($RespSa);
			//echo "Nro.Soli:".$FilaSa["nro_solicitud"];
			if(isset($FilaSa["nro_solicitud"])){
				$NumSol=$FilaSa["nro_solicitud"];
			}else{
				$NumSol=0;
			}
			//$Retorno=ObtenerLeyesH20yCuAgAu($FilaSa["nro_solicitud"],$link);	
			$Retorno=ObtenerLeyesH20yCuAgAu($NumSol,$link);
			//var_dump($Retorno);
			//if($Retorno!=""){
			if(isset($Retorno) && $Retorno!=""){
				$Retorno=explode('//',$Retorno);
				
				$H20 = isset($Retorno[0])?$Retorno[0]:0;
				$Cu  = isset($Retorno[1])?$Retorno[1]:0;
				$Ag  = isset($Retorno[2])?$Retorno[2]:0;
				$Au  = isset($Retorno[3])?$Retorno[3]:0;

			}else{
				$H20=0;
				$Cu=0;
				$Ag=0;
				$Au=0;

			}
 			//echo "PesoHdo:".$PesoHdo." H20:".$H20;

			$ValorSeco=$PesoHdo-($PesoHdo*str_replace(',','.',$H20)/100);
			
			$CuFino=$ValorSeco*str_replace(',','.',$Cu)/100;
			$AGFino=$ValorSeco*str_replace(',','.',$Ag)/1000;
			$AuFino=$ValorSeco*str_replace(',','.',$Au)/1000;
			
			$SA='SinSA.';

			if(isset($FilaSa["nro_sa_lims"]) && $FilaSa["nro_sa_lims"]=='') {
				$SA = $FilaSa["nro_solicitud"];
 			}else{
				if(isset($FilaSa["nro_sa_lims"]))
 				   $SA = $FilaSa["nro_sa_lims"];
			}
			/*
			if ($FilaSa["nro_sa_lims"]=='') {
				$SA = $FilaSa["nro_solicitud"];
 
			}else{
 
				$SA =$FilaSa["nro_sa_lims"];
			}*/

			//if($FilaSa["nro_solicitud"]!='')
				//$SA=$FilaSa["nro_solicitud"];
			
			
			$AuP=(int)$Au/1000;	
			if($ValorSeco!=0)
				$AuP=($AuP*100)/$ValorSeco;
			$ColorAu="";
			if($Au < $ValorOro  && $AuP!='0')
				$ColorAu="#FF0000";
				
			$AgP=(int)$Ag/1000;	
			if($ValorSeco!=0)
				$AgP=($AgP*100)/$ValorSeco;
			$ColorAg="";
			if($Ag < $ValorPlata && $AgP!='0')
				$ColorAg="#FF0000";
			
				
		?>
      <tr align="center" class="TituloCabecera">


        <td height="15" align="right"><?php echo $SA;?></td>
        <td align="right"><?php echo "<a href=\"JavaScript:DetalleLotePMN('".$Row["lote"]."','25','1')\">".$Row["lote"]."</a>"; ?></td>
        <td align="right"><?php echo number_format($PesoHdo,2,',',''); ?></td>
        <td align="right"><?php echo number_format($ValorSeco,2,',',''); ?></td>
        <td align="right"><?php echo $H20; ?>&nbsp;</td>
        <td align="right"><?php echo $Cu;?>&nbsp;</td>
        <td align="right" style="color:<?php echo $ColorAg;?>;"><?php echo number_format($AgP,2,',','');?>&nbsp;</td>
        <td align="right"><?php echo number_format((float)$Ag,2,',','');?>&nbsp;</td>
        <td align="right" style="color:<?php echo $ColorAu;?>;"><?php echo number_format($AuP,2,',','');?>&nbsp;</td>
        <td align="right"><?php echo number_format((float)$Au,2,',','');?>&nbsp;</td>
        <td align="right"><?php echo number_format($CuFino,2,',','');?>&nbsp;</td>
        <td align="right"><?php echo number_format($AGFino,2,',','');?>&nbsp;</td>
        <td align="right"><?php echo number_format($AuFino,2,',','');?>&nbsp;</td>
        <td align="center"><?php echo str_replace(',','<br>',$EmbarcadosPalet);?></td>
        <td align="right"><?php echo str_replace(',','<br>',$CorrSipas);?></td>
      </tr>
      	<?php
			$Total02 = $Total02 + $PesoHdo;
			$Total03 = $Total03 + $ValorSeco;

			$TotalFinoCu = $TotalFinoCu + $CuFino;
			$TotalFinoAg = $TotalFinoAg + $AGFino;
			$TotalFinoAu = $TotalFinoAu + $AuFino;
		}
		if($Total03!='')
		{
			$FinoTotCu=$TotalFinoCu/$Total03*100;
			$FinoTotAg=$TotalFinoAg/$Total03*1000;
			$FinoTotAu=$TotalFinoAu/$Total03*1000;

			$FinoTotAuPorc=$FinoTotAu/1000;	
			if($Total03!=0)
				$FinoTotAuPorc=($FinoTotAuPorc*100)/$Total03;
				
			$FinoTotAgPorc=$FinoTotAg/1000;	
			if($Total03!=0)
				$FinoTotAgPorc=($FinoTotAgPorc*100)/$Total03;
		}
		?>
      <tr align="center" class="TituloTablaNaranja">
        <td height="15" colspan="2" align="right"><strong>TOTAL</strong></td>
        <td align="right"><?php echo number_format($Total02,2,',','.'); ?></td>
        <td align="right"><?php echo number_format($Total03,2,',','.'); ?></td>
        <td align="right">&nbsp;</td>
        <td align="right"><?php echo number_format($FinoTotCu,2,',','.');?></td>
        <td align="right"><?php echo number_format($FinoTotAgPorc,2,',','.');?></td>
        <td align="right"><?php echo number_format($FinoTotAg,2,',','.');?></td>
        <td align="right"><?php echo number_format($FinoTotAuPorc,2,',','.');?></td>
        <td align="right"><?php echo number_format($FinoTotAu,2,',','.');?></td>
        <td align="right"><?php echo number_format($TotalFinoCu,2,',','.');?></td>
        <td align="right"><?php echo number_format($TotalFinoAg,2,',','.');?></td>
        <td align="right"><?php echo number_format($TotalFinoAu,2,',','.');?></td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>
       </td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png" /></td>
  </tr>
</table>
<br />
<?php
/*
?>
<table width="60%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td height="1%" background="archivos/images/interior/izquierdo.png">&nbsp;</td>
    <td width="98%" align="center" height="15"><h5><strong>Lotes BAD embarcados</strong></h5></td>
    <td height="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
   <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
      <tr align="center" class="TituloCabeceraAzul">
        <td width="41" height="15" class="TituloCabeceraAzul">Palet</td>
        <td height="30" align="center">Lote Camion</td>
        <td width="41" height="15" class="TituloCabeceraAzul">Lote</td>
        <td width="95">Hdo Kg</td>
        <td width="149">Seco Kg</td>
        <td width="149">H2O %</td>
        <td width="149">Cu %</td>
        <td width="149">Ag Kg/Ton</td>
        <td width="149">Au Kg/Ton</td>
        <td width="149">Cu Kg</td>
        <td width="149">Ag Gr</td>
        <td width="149">Au Gr</td>
      </tr>
      <?php	
	  $FinoTotCu=0;$FinoTotAg=0;$FinoTotAu=0;$TotalFinoCu=0;$TotalFinoAg=0;$TotalFinoAu=0;$PesoHdo=0;$Total02=0;$Total03=0;
	  $Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra and t2.recargo='0'";
  	  $Consulta.= " where month(t1.fecha_hora)='".$Mes."' and fecha_embarque is not null group by t1.lote";	
	  $Respuesta = mysqli_query($link, $Consulta);
	  while ($Row = mysqli_fetch_array($Respuesta))
	  {
			$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote";
			$Consulta.= " where t1.lote='".$Row["lote"]."'";
			$Consulta.= " order by t2.lote,t2.recargo";
			echo "<input type='hidden' name='selec'>";
			$Respuesta2 = mysqli_query($link, $Consulta);$PesoHdo=0;
			while ($Row2 = mysqli_fetch_array($Respuesta2))
				$PesoHdo=$PesoHdo+$Row2["pneto"];
				
			$Retorno=ObtenerLeyesH20yCuAgAu($Row["nro_solicitud"]);	
			$Retorno=explode('//',$Retorno);
			$H20=$Retorno[0];
			$Cu=$Retorno[1];
			$Ag=$Retorno[2];
			$Au=$Retorno[3];
			$ValorSeco=$PesoHdo-($PesoHdo*str_replace(',','.',$H20)/100);
			
			$CuFino=$ValorSeco*str_replace(',','.',$Cu)/100;
			$AGFino=$ValorSeco*str_replace(',','.',$Ag)/100;
			$AuFino=$ValorSeco*str_replace(',','.',$Au)/100;

			$PaletA=ObtengoDatosPaletAB($Row["lote"],'A','N');
			$PaletA=explode('-:-',$PaletA);
			$ValorA=$PaletA[0];
			$TmbA=$PaletA[1];
			$SIPA_a=$PaletA[2];
			$PaletB=ObtengoDatosPaletAB($Row["lote"],'B','N');
			$PaletB=explode('-:-',$PaletB);
			$ValorB=$PaletB[0];
			$TmbB=$PaletB[1];
			$SIPA_b=$PaletB[2];
			$Rows='1';
			if($SIPA_a!='' && $SIPA_b!='')
				$Rows='2';
			  ?>
			  <tr align="center" class="TituloCabecera">
					  <?php
					  if($SIPA_a!='')
					  {
					  ?>
							<td align="right"><?php echo "A"?></td>
							<td align="right"><?php echo $SIPA_a;?></td>
					  <?php
					  }
					  ?>		
					<td align="right" rowspan="<?php echo $Rows;?>"><?php echo $Row["lote"]; ?></td>
					<td align="right" rowspan="<?php echo $Rows;?>"><?php echo number_format($PesoHdo,2,',',''); ?></td>
					<td align="right" rowspan="<?php echo $Rows;?>"><?php echo number_format($ValorSeco,2,',',''); ?></td>
					<td align="right" rowspan="<?php echo $Rows;?>"><?php echo $H20; ?>&nbsp;</td>
					<td align="right" rowspan="<?php echo $Rows;?>"><?php echo $Cu;?>&nbsp;</td>
					<td align="right" rowspan="<?php echo $Rows;?>"><?php echo $Ag;?>&nbsp;</td>
					<td align="right" rowspan="<?php echo $Rows;?>"><?php echo $Au;?>&nbsp;</td>
					<td align="right" rowspan="<?php echo $Rows;?>"><?php echo number_format($CuFino,2,',','');?>&nbsp;</td>
					<td align="right" rowspan="<?php echo $Rows;?>"><?php echo number_format($AGFino,2,',','');?>&nbsp;</td>
					<td align="right" rowspan="<?php echo $Rows;?>"><?php echo number_format($AuFino,2,',','');?>&nbsp;</td>
			  </tr>
			  <?php
			  if($SIPA_b!='')
			  {
			  ?>
			  <tr align="center" class="TituloCabecera">
					<td align="right"><?php echo "B"?></td>
					<td align="right"><?php echo $SIPA_b;?></td>
			  </tr>
			  <?php
			  }
			$Total02 = $Total02 + $PesoHdo;
			$Total03 = $Total03 + $ValorSeco;

			$TotalFinoCu = $TotalFinoCu + $CuFino;
			$TotalFinoAg = $TotalFinoAg + $AGFino;
			$TotalFinoAu = $TotalFinoAu + $AuFino;

			
		}
		if($Total03!='')
		{
			$FinoTotCu=$TotalFinoCu/$Total03*100;
			$FinoTotAg=$TotalFinoAg/$Total03*1000;
			$FinoTotAu=$TotalFinoAu/$Total03*1000;
		}
		?>
      <tr align="center" class="TituloTablaNaranja">
        <td height="15" colspan="3" align="right"><strong>TOTAL</strong></td>
        <td align="right"><?php echo number_format($Total02,2,',','.'); ?></td>
        <td align="right"><?php echo number_format($Total03,2,',','.'); ?></td>
        <td align="right">&nbsp;</td>
        <td align="right"><?php echo number_format($FinoTotCu,2,',','.');?></td>
        <td align="right"><?php echo number_format($FinoTotAg,2,',','.');?></td>
        <td align="right"><?php echo number_format($FinoTotAu,2,',','.');?></td>
        <td align="right"><?php echo number_format($TotalFinoCu,2,',','.');?></td>
        <td align="right"><?php echo number_format($TotalFinoAg,2,',','.');?></td>
        <td align="right"><?php echo number_format($TotalFinoAu,2,',','.');?></td>
      </tr>
    </table>
       </td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png" /></td>
  </tr>
</table>
<?php
*/
?>
<p>&nbsp;</p>
</form>
<?php
}
else
{
//ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename="";
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
//header("Expires: 0");
//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
?>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<table width="100%" border="1" cellpadding="0"  cellspacing="0">
      <tr>
        <td colspan="7" align="center" valign="top" class="TituloCabeceraAzul">Lotes por correlativos </td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="TituloCabeceraAzul">Mes</td>
        <td colspan="5" class="formulario"><span class="ColorTabla02">
            <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($Mes))
			{
				if ($Mes == $i)
					echo ucwords(strtolower($Meses[$i - 1]));
			}
		}
		?>
        </span></td>
  </tr>
</table>
	<br />
	<table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
      <tr align="center" class="TituloCabeceraAzul">
        <td align="center" colspan="13">Listos para Embarcar</td>
        <td align="center" colspan="2">Embarcados</td>
      </tr>
      <tr align="center" class="TituloCabeceraAzul">
        <td width="17" height="30" align="center">S.A</td>
        <td width="25" height="15" class="TituloCabeceraAzul">Lote</td>
        <td width="37">Hdo Kg</td>
        <td width="70">Seco Kg</td>
        <td width="67">H2O %</td>
        <td width="48">Cu %</td>
        <td width="60">Ag %</td>
        <td width="60">Ag Kg/Ton</td>
        <td width="62">Au %</td>
        <td width="62">Au Kg/Ton</td>
        <td width="59">Cu Kg</td>
        <td width="54">Ag Gr</td>
        <td width="53">Au Gr</td>
        <td width="94">Palet Embarcados</td>
        <td width="72">Lote Camion</td>
      </tr>
      <?php
	  
		$Consulto="select cod_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='6000' and cod_subclase in('1','2')";
		$Resp=mysqli_query($link, $Consulto);	
		while($Fila=mysqli_fetch_assoc($Resp))
		{
			if(strtolower($Fila["cod_subclase"])=='1')	
				$ValorOro=str_replace('%','',$Fila['valor_subclase1']);
			if(strtolower($Fila["cod_subclase"])=='2')	
				$ValorPlata=str_replace('%','',$Fila['valor_subclase1']);
		}	

		$FinoTotCu=0;$FinoTotAg=0;$FinoTotAu=0;$TotalFinoCu=0;$TotalFinoAg=0;$TotalFinoAu=0;
		$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera ";
		$Consulta.= " where month(fecha_hora)='".$Mes."' group by lote";
		$Respuesta = mysqli_query($link, $Consulta);

		$Total02=0;
		$Total03=0;
		
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote";
			$Consulta.= " where t1.lote='".$Row["lote"]."'";
			$Consulta.= " order by t2.lote,t2.recargo";
			echo "<input type='hidden' name='selec'>";
			$Respuesta2 = mysqli_query($link, $Consulta);
			$PesoHdo=0;
			while ($Row2 = mysqli_fetch_array($Respuesta2))
				$PesoHdo=$PesoHdo+$Row2["pneto"];
				
			$Consulta = "select palet_a_b,correlativo_sipa from pmn_web.pmn_pesa_bad_detalle";
			$Consulta.= " where lote='".$Row["lote"]."'";
			$Consulta.= " group by palet_a_b";
			//echo $Consulta."<br>";
			$Respuesta2 = mysqli_query($link, $Consulta);$EmbarcadosPalet='';$CorrSipas='';
			while ($Row2 = mysqli_fetch_array($Respuesta2))
			{	
			$EmbarcadosPalet=$EmbarcadosPalet.$Row2["palet_a_b"].", ";
			$CorrSipas=$CorrSipas.$Row2["correlativo_sipa"].", ";
			}
			$EmbarcadosPalet=substr($EmbarcadosPalet,0,strlen($EmbarcadosPalet)-2);
			$CorrSipas=substr($CorrSipas,0,strlen($CorrSipas)-2);
				
			$RespSa=mysqli_query($link, "select nro_solicitud, nro_sa_lims from cal_web.solicitud_analisis where id_muestra='".$Row["lote"]."' and recargo='0' and nro_solicitud is not null");
			//echo "select nro_solicitud from cal_web.solicitud_analisis where id_muestra='".$Row["lote"]."' and recargo='0' and nro_solicitud is not null<br>";
			$FilaSa=mysqli_fetch_assoc($RespSa);
			if(isset($FilaSa["nro_solicitud"])){
				$NumSol=$FilaSa["nro_solicitud"];
			}else{
				$NumSol=0;
			}
			$Retorno=ObtenerLeyesH20yCuAgAu($NumSol,$link);	
			$Retorno=explode('//',$Retorno);
			
			$H20=isset($Retorno[0])?$Retorno[0]:0;
			$Cu=isset($Retorno[1])?$Retorno[1]:0;
			$Ag=isset($Retorno[2])?$Retorno[2]:0;
			$Au=isset($Retorno[3])?$Retorno[3]:0;

			$ValorSeco=$PesoHdo-($PesoHdo * str_replace(',','.',(float)$H20)/100);
			
			$CuFino = $ValorSeco*str_replace(',','.',$Cu)/100;
			$AGFino = $ValorSeco*str_replace(',','.',$Ag)/1000;
			$AuFino = $ValorSeco*str_replace(',','.',$Au)/1000;
			
			$SA='SinSA.'; 

			if(isset($FilaSa["nro_sa_lims"]) && $FilaSa["nro_sa_lims"]=='') {
				$SA = $FilaSa["nro_solicitud"];
 			}else{
				if(isset($FilaSa["nro_sa_lims"]))
 				   $SA = $FilaSa["nro_sa_lims"];
			}
			/*
			if ($FilaSa["nro_sa_lims"]=='') {
				$SA = $FilaSa["nro_solicitud"];
			}else{
				$SA =$FilaSa["nro_sa_lims"];
			}*/
			
			$AuP=$Au/1000;	
			if($ValorSeco!=0)
				$AuP=($AuP*100)/$ValorSeco;
			$ColorAu="";
			if($Au < $ValorOro  && $AuP!='0')
				$ColorAu="#FF0000";
				
			$AgP=$Ag/1000;	
			if($ValorSeco!=0)
				$AgP=($AgP*100)/$ValorSeco;
			$ColorAg="";
			if($Ag < $ValorPlata && $AgP!='0')
				$ColorAg="#FF0000";
			
				
			?>
      <tr align="center" class="TituloCabecera">
        <td height="15" align="right"><?php echo $SA;?></td>
        <td align="right"><?php echo $Row["lote"]; ?></td>
        <td align="right"><?php echo number_format($PesoHdo,2,',',''); ?></td>
        <td align="right"><?php echo number_format($ValorSeco,2,',',''); ?></td>
        <td align="right"><?php echo $H20; ?>&nbsp;</td>
        <td align="right"><?php echo $Cu;?>&nbsp;</td>
        <td align="right" style="color:<?php echo $ColorAg;?>;"><?php echo number_format($AgP,2,',','');?>&nbsp;</td>
        <td align="right"><?php echo number_format($Ag,2,',','');?>&nbsp;</td>
        <td align="right" style="color:<?php echo $ColorAu;?>;"><?php echo number_format($AuP,2,',','');?>&nbsp;</td>
        <td align="right"><?php echo number_format($Au,2,',','');?>&nbsp;</td>
        <td align="right"><?php echo number_format($CuFino,2,',','');?>&nbsp;</td>
        <td align="right"><?php echo number_format($AGFino,2,',','');?>&nbsp;</td>
        <td align="right"><?php echo number_format($AuFino,2,',','');?>&nbsp;</td>
        <td align="center"><?php echo str_replace(',','<br>',$EmbarcadosPalet);?></td>
        <td align="right"><?php echo str_replace(',','<br>',$CorrSipas);?></td>
      </tr>
      <?php
			$Total02 = $Total02 + $PesoHdo;
			$Total03 = $Total03 + $ValorSeco;

			$TotalFinoCu = $TotalFinoCu + $CuFino;
			$TotalFinoAg = $TotalFinoAg + $AGFino;
			$TotalFinoAu = $TotalFinoAu + $AuFino;
		}
		if($Total03!='')
		{
			$FinoTotCu=$TotalFinoCu/$Total03*100;
			$FinoTotAg=$TotalFinoAg/$Total03*1000;
			$FinoTotAu=$TotalFinoAu/$Total03*1000;

			$FinoTotAuPorc=$FinoTotAu/1000;	
			if($Total03!=0)
				$FinoTotAuPorc=($FinoTotAuPorc*100)/$Total03;
				
			$FinoTotAgPorc=$FinoTotAg/1000;	
			if($Total03!=0)
				$FinoTotAgPorc=($FinoTotAgPorc*100)/$Total03;
		}
		?>
      <tr align="center" class="TituloTablaNaranja">
        <td height="15" colspan="2" align="right"><strong>TOTAL</strong></td>
        <td align="right"><?php echo number_format($Total02,2,',','.'); ?></td>
        <td align="right"><?php echo number_format($Total03,2,',','.'); ?></td>
        <td align="right">&nbsp;</td>
        <td align="right"><?php echo number_format($FinoTotCu,2,',','.');?></td>
        <td align="right"><?php echo number_format($FinoTotAgPorc,2,',','.');?></td>
        <td align="right"><?php echo number_format($FinoTotAg,2,',','.');?></td>
        <td align="right"><?php echo number_format($FinoTotAuPorc,2,',','.');?></td>
        <td align="right"><?php echo number_format($FinoTotAu,2,',','.');?></td>
        <td align="right"><?php echo number_format($TotalFinoCu,2,',','.');?></td>
        <td align="right"><?php echo number_format($TotalFinoAg,2,',','.');?></td>
        <td align="right"><?php echo number_format($TotalFinoAu,2,',','.');?></td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>
	<br />
	<?php	
}
?>
