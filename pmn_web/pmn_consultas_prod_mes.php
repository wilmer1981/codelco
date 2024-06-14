<?php
include("../principal/conectar_pmn_web.php");	
include("pmn_funciones.php");

$Pag    = isset($_REQUEST["Pag"])?$_REQUEST["Pag"]:"";
$Buscar = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
$xls = isset($_REQUEST["xls"])?$_REQUEST["xls"]:"";
$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date('Y');
$Mes = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date('m');
$EmbChk = isset($_REQUEST["EmbChk"])?$_REQUEST["EmbChk"]:'N';


/**************************************************************************** */
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
			f.action="pmn_consultas_prod_mes.php?Pag="+Pag+"&Buscar=S&Mes="+f.Mes.value;
			f.submit();
		break
		case "EX":
			var URL = "pmn_consultas_prod_mes.php?&xls=S&Mes="+f.Mes.value;
			window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=162";
			f.submit();
		break;		
	}
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
        <td colspan="4" align="center" valign="top" class="formulario Estilo7">Resumen Produccin</td>
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
        <td colspan="6" class="formulario">&nbsp;</td>
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
<table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"> </td>
    <td align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
      <tr align="center" class="TituloCabeceraAzul">
        <td width="38" height="15" class="TituloCabeceraAzul">Lote</td>
        <td width="76">Peso Bruto</td>
        <td width="114">Peso Tara</td>
        <td width="114">Peso Neto</td>
        <td width="114">Peso Seco</td>
        <td width="92">S.A</td>
        <td width="9%">Fecha S.A</td>
		<?php
		$valores=ObtenerLeyesProy($link);	
		$valores=explode('//',$valores);
		//while(list($c,$v)=each($valores))
		foreach ($valores as $c => $v)
		{
			$Dato=explode('~',$v);
		?>
			<td width="17"><?php echo $Dato[1];?></td>
			<td width="19">Uni.</td>
			<!--<td>Sig.</td>-->
		<?php
		}
		?>
      </tr>
      <?php	
	  $FinoTotCu=0;$FinoTotAg=0;$FinoTotAu=0;$TotalFinoCu=0;$TotalFinoAg=0;$TotalFinoAu=0;
	  $Consulta = "select *,t2.fecha_hora as fecha_hora_SA from pmn_web.pmn_pesa_bad_cabecera t1 inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  and t2.recargo in('0','') and t2.nro_solicitud is not null";
	  $Consulta.= " where month(t1.fecha_hora)='".$Mes."'";
	  $Respuesta = mysqli_query($link,$Consulta);
	  $Total02=0;$Total03=0;$Total04=0;$Total05=0;
	  while ($Row = mysqli_fetch_array($Respuesta))
	  {
			$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote";
			$Consulta.= " where t1.lote='".$Row["lote"]."'";
			$Consulta.= " order by t2.lote,t2.recargo";
			echo "<input type='hidden' name='selec'>";$PesoNeto=0;$PesoBruto=0;$PesoTara=0;
			$Respuesta2 = mysqli_query($link,$Consulta);$PesoHdo=0;
			while ($Row2 = mysqli_fetch_array($Respuesta2))
			{
				$PesoNeto=$PesoNeto+$Row2["pneto"];
				$PesoBruto=$PesoBruto+$Row2["pbruto"];
				$PesoTara=$PesoTara+$Row2["ptara"];
			}	
			$nro_solicitud=isset($Row["nro_solicitud"])?$Row["nro_solicitud"]:0;
			$Retorno=ObtenerLeyesH20yCuAgAu($nro_solicitud,$link);	
			$Retorno=explode('//',$Retorno);
			/*
			$H20=$Retorno[0];
			$Cu=$Retorno[1];
			$Ag=$Retorno[2];
			$Au=$Retorno[3];
			*/
			$H20 = isset($Retorno[0])?$Retorno[0]:0;
			$Cu  = isset($Retorno[1])?$Retorno[1]:0;
			$Ag  = isset($Retorno[2])?$Retorno[2]:0;
			$Au  = isset($Retorno[3])?$Retorno[3]:0;

			$ValorSeco=$PesoNeto-($PesoNeto*str_replace(',','.',$H20)/100);
		    $nro_sa_lims = isset($Row["nro_sa_lims"])?$Row["nro_sa_lims"]:"";			
			if ($nro_sa_lims=='') {
				$SA = $nro_solicitud;
			}else{
				$SA = $nro_sa_lims;
			}
						
			/*
				if ($Row["nro_sa_lims"]=='') {
					$SA = $Row["nro_solicitud"];
				}else{
					$SA = $Row["nro_sa_lims"];
				}
				*/

			?>
			  <tr align="center" class="TituloCabecera">
				<td align="right" class="TituloCabeceraSalmon"><?php echo $Row["lote"]; ?></td>
				<td align="right"><?php echo number_format($PesoBruto,2,',',''); ?></td>
				<td align="right"><?php echo number_format($PesoTara,2,',',''); ?></td>
				<td align="right"><?php echo number_format($PesoNeto,2,',',''); ?></td>
				<td align="right"><?php echo number_format($ValorSeco,2,',',''); ?></td>


				<td align="right" class="TituloCabeceraSalmon"><?php echo $SA; ?></td>


				<td align="right" class="TituloCabeceraAmarillo"><?php echo $Row["fecha_hora_SA"]; ?></td>
				<?php
				$Total02 = $Total02 + $PesoBruto;
				$Total03 = $Total03 + $PesoTara;
				$Total04 = $Total04 + $PesoNeto;
				$Total05 = $Total05 + $ValorSeco;
				
				$valores=ObtenerLeyesProy($link);	
				$valores=explode('//',$valores);
				//while(list($c,$v)=each($valores))
				foreach ($valores as $c => $v)
				{
					$Dato=explode('~',$v);
					$Datos=ObtenerLeyes2($nro_solicitud,$Dato[0],$link);
					$Datos3=explode('~',$Datos);
					$Datos30 = isset($Datos3[0])?$Datos3[0]:0;
					$Datos32 = isset($Datos3[2])?$Datos3[2]:"";
					?>
					<td><?php echo number_format($Datos30,2,',','');?>&nbsp;</td>
					<td><?php echo $Datos32;?>&nbsp;</td>
					<!--<td><?php //echo $Datos3[1];?>&nbsp;</td>-->
					<?php
				}
				?>
			  </tr>
		<?php
		}
		if($Total04!='')
			$TotalH2O=100*(1-+$Total05/$Total04);
		?>
      <tr align="center" class="TituloTablaNaranja">
        <td height="15" align="right"><strong>TOTAL</strong></td>
        <td align="right"><?php echo number_format($Total02,2,',','.'); ?></td>
        <td align="right"><?php echo number_format($Total03,2,',','.'); ?></td>
        <td align="right"><?php echo number_format($Total04,2,',','.'); ?></td>
        <td align="right"><?php echo number_format($Total05,2,',','.'); ?></td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right"><?php echo number_format($TotalH2O,2,',','.');?></td>
        <td align="right" colspan="41">&nbsp;</td>
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
<p>&nbsp;</p>
</form>
<?php
}
else
{
ob_end_clean();
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
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
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
        <td width="41" height="15" class="TituloCabeceraAzul">Lote</td>
        <td width="95">Peso Bruto</td>
        <td width="149">Peso Tara</td>
        <td width="149">Peso Neto</td>
        <td width="149">Peso Seco</td>
        <td width="149">S.A</td>
        <td width="9%">Fecha S.A</td>
        <?php
		$valores=ObtenerLeyesProy($link);	
		$valores=explode('//',$valores);
		//while(list($c,$v)=each($valores))
		foreach ($valores as $c => $v)
		{
			$Dato=explode('~',$v);
		?>
        <td><?php echo $Dato[1];?></td>
        <td>Uni.</td>
        <!--<td>Sig.</td>-->
        <?php
		}
		?>
      </tr>
      <?php	
	  $FinoTotCu=0;$FinoTotAg=0;$FinoTotAu=0;$TotalFinoCu=0;$TotalFinoAg=0;$TotalFinoAu=0;
	  $Consulta = "select *,t2.fecha_hora as fecha_hora_SA from pmn_web.pmn_pesa_bad_cabecera t1 inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  and t2.recargo in('0','') and t2.nro_solicitud is not null";
	  $Consulta.= " where month(t1.fecha_hora)='".$Mes."'";
	  $Respuesta = mysqli_query($link,$Consulta);
	  $Total02=0;$Total03=0;$Total04=0;$Total05=0;$Total03=0;
	  while ($Row = mysqli_fetch_array($Respuesta))
	  {
			$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote";
			$Consulta.= " where t1.lote='".$Row["lote"]."'";
			$Consulta.= " order by t2.lote,t2.recargo";
			echo "<input type='hidden' name='selec'>";$PesoNeto=0;$PesoBruto=0;$PesoTara=0;
			$Respuesta2 = mysqli_query($link,$Consulta);$PesoHdo=0;
			while ($Row2 = mysqli_fetch_array($Respuesta2))
			{
				$PesoNeto=$PesoNeto+$Row2["pneto"];
				$PesoBruto=$PesoBruto+$Row2["pbruto"];
				$PesoTara=$PesoTara+$Row2["ptara"];
			}	
			$nro_solicitud = isset($Row["nro_solicitud"])?$Row["nro_solicitud"]:"";
			$Retorno=ObtenerLeyesH20yCuAgAu($nro_solicitud,$link);	
			$Retorno=explode('//',$Retorno);
			/*
			$H20=$Retorno[0];
			$Cu=$Retorno[1];
			$Ag=$Retorno[2];
			$Au=$Retorno[3];
			*/
			$H20 = isset($Retorno[0])?$Retorno[0]:0;
			$Cu  = isset($Retorno[1])?$Retorno[1]:0;
			$Ag  = isset($Retorno[2])?$Retorno[2]:0;
			$Au  = isset($Retorno[3])?$Retorno[3]:0;
			$ValorSeco=$PesoNeto-($PesoNeto*str_replace(',','.',$H20)/100);
				
				if ($Row["nro_sa_lims"]=='') {
					$SA = $Row["nro_solicitud"];
				 
				}else{
					$SA = $Row["nro_sa_lims"];
				 
				}		
		?>
      <tr align="center" class="TituloCabecera">
        <td align="right"><?php echo $Row["lote"]; ?></td>
        <td align="right"><?php echo number_format($PesoBruto,2,',',''); ?></td>
        <td align="right"><?php echo number_format($PesoTara,2,',',''); ?></td>
        <td align="right"><?php echo number_format($PesoNeto,2,',',''); ?></td>
        <td align="right"><?php echo number_format($ValorSeco,2,',',''); ?></td>
		<td align="right" class="TituloCabeceraSalmon"><?php echo $SA; ?></td>
		<td align="right" class="TituloCabeceraAmarillo"><?php echo $Row["fecha_hora_SA"]; ?></td>
        <?php
				$Total02 = $Total02 + $PesoBruto;
				$Total03 = $Total03 + $PesoTara;
				$Total04 = $Total04 + $PesoNeto;
				$Total05 = $Total05 + $ValorSeco;
				
				$valores=ObtenerLeyesProy($link);	
				$valores=explode('//',$valores);
				//while(list($c,$v)=each($valores))
				foreach ($valores as $c => $v)
				{
					$Dato=explode('~',$v);
					$Datos=ObtenerLeyes2($Row["nro_solicitud"],$Dato[0],$link);
					$Datos3=explode('~',$Datos);
					$Datos30 = isset($Datos3[0])?$Datos3[0]:0;
					$Datos32 = isset($Datos3[2])?$Datos3[2]:"";
					?>
        <td><?php echo number_format($Datos30,2,',','');?>&nbsp;</td>
        <td><?php echo $Datos32;?>&nbsp;</td>
        <!--<td><? //echo $Datos3[1];?>&nbsp;</td>-->
        <?php
				}
				?>
      </tr>
      <?php
		}
		$TotalH2O=100*(1-+$Total05/$Total04);
		?>
      <tr align="center" class="TituloTablaNaranja">
        <td height="15" align="right"><strong>TOTAL</strong></td>
        <td align="right"><?php echo number_format($Total02,2,',','.'); ?></td>
        <td align="right"><?php echo number_format($Total03,2,',','.'); ?></td>
        <td align="right"><?php echo number_format($Total04,2,',','.'); ?></td>
        <td align="right"><?php echo number_format($Total05,2,',','.'); ?></td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right"><?php echo number_format($TotalH2O,2,',','.');?></td>
        <td align="right" colspan="41">&nbsp;</td>
      </tr>
    </table>
	<br />
	<?php	
}
?>
