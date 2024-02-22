<?php
include("../principal/conectar_pmn_web.php");	

if(isset($_REQUEST["xls"])){
	$xls = $_REQUEST["xls"];
}else{
	$xls = "";
}
if(isset($_REQUEST["Buscar"])){
	$Buscar = $_REQUEST["Buscar"];
}else{
	$Buscar = "";
}

if(isset($_REQUEST["Ano"])){
	$Ano = $_REQUEST["Ano"];
}else{
	$Ano = date('Y');
}
if(isset($_REQUEST["Mes"])){
	$Mes = $_REQUEST["Mes"];
}else{
	$Mes = date('m');
}
if(isset($_REQUEST["Dia"])){
	$Dia = $_REQUEST["Dia"];
}else{
	$Dia = 1;
}

if(isset($_REQUEST["AnoH"])){
	$AnoH = $_REQUEST["AnoH"];
}else{
	$AnoH = date('Y');
}

if(isset($_REQUEST["MesH"])){
	$MesH = $_REQUEST["MesH"];
}else{
	$MesH = date('m');
}

if(isset($_REQUEST["DiaH"])){
	$DiaH = $_REQUEST["DiaH"];
}else{
	$DiaH = date('d');
}


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
			f.action="pmn_consultas_lotes_correlativo.php?Pag="+Pag+"&Buscar=S&Ano="+f.Ano.value+"&Mes="+f.Mes.value;
			f.submit();
		break
		case "EX":
			var URL = "pmn_consultas_lotes_correlativo.php?xls=S&Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&Dia="+f.Dia.value+"&AnoH="+f.AnoH.value+"&MesH="+f.MesH.value+"&DiaH="+f.DiaH.value;
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
/*
if(!isset($Mes))
	$MesActual=date('m');
if(!isset($Ano))
	$AnoActual=date('Y');
*/
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
        <td colspan="4" align="center" valign="top" class="formulario Estilo7">Lotes con correlativo Sipa </td>
        <td width="214" align="right" class="formulario">
		<a href="JavaScript:Proceso('B','3')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="javascript:Proceso('EX','3')"><img src="archivos/excel.png" alt='Excel' width="25" height="25" border="0" align="absmiddle" /></a> &nbsp;
		<a href="javascript:window.print()"><img src="archivos/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp; 
		<a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle" /></a></td>
        <td width="10" align="right" class="formulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="formulario">Fecha Embarque desde</td>
        <td colspan="4" class="formulario"><span class="ColorTabla02">
          <select name="Dia">
            <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($Dia))
			{
				if ($Dia == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}/*
			else
			{
				if ($i == 1)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}*/
		}
	  ?>
          </select>
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
          <select name="Ano">
            <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($Ano))
			{
				if ($Ano == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}/*
			else
			{
				if ($i == $AnoActual)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}*/
		}
		?>
          </select>
        </span></td>
        </tr>
      <tr>
        <td colspan="2" align="left" class="formulario">Fecha Embarque hasta</td>
        <td colspan="4" class="formulario"><span class="ColorTabla02">
          <select name="DiaH">
            <?php
			for ($i = 1;$i <= 31; $i++)
			{
				if (isset($DiaH))
				{
					if ($DiaH == $i)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				/*
				else
				{
					if ($i == $DiaActual)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}*/
			}
		?>
          </select>
          <select name="MesH">
            <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesH))
			{
				if ($MesH == $i)
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
          <select name="AnoH">
            <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoH))
			{
				if ($AnoH == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}/*
			else
			{
				if ($i == $AnoActual)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
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
<table width="60%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
      <?php	
				$Consulta = "SELECT * from pmn_web.pmn_pesa_bad_cabecera t1 inner join pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote";
				$Consulta.= " where t2.fecha_embarque between '".$Ano."-".$Mes."-".$Dia." 00:00:00' and '".$AnoH."-".$MesH."-".$DiaH." 23:59:59'";
				$Consulta.= " group by t2.correlativo_sipa";
				//echo "Consulta:<br>".$Consulta;

				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					echo "<tr class='TituloCabeceraAzul'>\n";
					echo "<td align='left' colspan='2'>Correlativo Sipa</td>\n";
					echo "<td align='left' colspan='6'>".$Row["correlativo_sipa"]."</td>\n";
					echo "</tr>\n";
					?>
				  <tr align="center" class="TituloCabeceraAzul">
					<td width="41" height="15" class="TituloCabeceraAzul">Lote</td>
					<td width="95">Tambor</td>
					<td width="149">Peso Bruto</td>
					<td width="149">Peso Tara</td>
					<td width="149">Peso Neto</td>
					<td width="149">Sello interno</td>
					<td width="149">Sello externo</td>
				  </tr>
				  <?php
					$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote";
					$Consulta.= " where t2.correlativo_sipa='".$Row["correlativo_sipa"]."'";
					$Consulta.= " order by t2.lote,t2.recargo";
					echo "<input type='hidden' name='selec'>";
					$Respuesta2 = mysqli_query($link, $Consulta);
					$Total02=0;$Total03=0;$Total04=0;$i=1;$TotalSub02=0;$TotalSub03=0;$TotalSub04=0;
					while ($Row2 = mysqli_fetch_array($Respuesta2))
					{
						echo "<tr>\n";
						echo "<td align='center'>".$Row2["lote"]."</td>\n";
						echo "<td align='center'>".$Row2["recargo"]."</td>\n";
						echo "<td align='right'>".number_format($Row2["pbruto"],2,',','.')."</td>\n";
						echo "<td align='right'>".number_format($Row2["ptara"],2,',','.')."</td>\n";
						echo "<td align='right'>".number_format($Row2["pneto"],2,',','.')."</td>\n";
						echo "<td align='right'>".$Row2["sint"]."</td>\n";
						echo "<td align='right'>".$Row2["sext"]."</td>\n";
						echo "</tr>\n";
						
						$Total02 = $Total02 + $Row2["pbruto"];
						$Total03 = $Total03 + $Row2["ptara"];
						$Total04 = $Total04 + $Row2["pneto"];
						
							$TotalSub02 = $TotalSub02 + $Row2["pbruto"];
							$TotalSub03 = $TotalSub03 + $Row2["ptara"];
							$TotalSub04 = $TotalSub04 + $Row2["pneto"];
						if($Row2["recargo"]==4)
						{
							if($Row2["palet_a_b"]=='B')
								$Consulta="select peso_palet_b as peso_palet";
							if($Row2["palet_a_b"]=='A')	
								$Consulta="select peso_palet_a as peso_palet";
							$Consulta.=" from pmn_pesa_bad_cabecera where lote='".$Row2["lote"]."'";
							$RESP=mysqli_query($link, $Consulta);
							if($Fila=mysqli_fetch_assoc($RESP))
								$pesoPatel=$Fila["peso_palet"];
							$PesoFinal=	$TotalSub04+$pesoPatel;
						  ?>
						  <tr align="center" class="TituloCabecera">
							<td height="15" colspan="2" align="right"><strong >Sub-TOTAL</strong></td>
							<td align="right"><?php echo number_format($TotalSub02,2,',','.'); ?></td>
							<td align="right"><?php echo number_format($TotalSub03,2,',','.'); ?></td>
							<td align="right"><?php echo number_format($TotalSub04,2,',','.'); ?></td>
							<td align="right">+ Peso palet (<?php echo number_format($pesoPatel,2,',','.'); ?>)</td>
							<td align="right"><?php echo number_format($PesoFinal,2,',','.');?>&nbsp;</td>
						  </tr>
						  <?php
						  $TotalSub02=0;$TotalSub03=0;$TotalSub04=0;
						}
						if($Row2["recargo"]==8)
						{
							if($Row2["palet_a_b"]=='B')
								$Consulta="select peso_palet_b as peso_palet";
							if($Row2["palet_a_b"]=='A')	
								$Consulta="select peso_palet_a as peso_palet";
							$Consulta.=" from pmn_pesa_bad_cabecera where lote='".$Row2["lote"]."'";
							$RESP=mysqli_query($link, $Consulta);
							if($Fila=mysqli_fetch_assoc($RESP))
								$pesoPatel=$Fila["peso_palet"];
							$PesoFinal=	$TotalSub04+$pesoPatel;
						  ?>
						  <tr align="center" class="TituloCabecera">
							<td height="15" colspan="2" align="right"><strong >Sub-TOTAL</strong></td>
							<td align="right"><?php echo number_format($TotalSub02,2,',','.'); ?></td>
							<td align="right"><?php echo number_format($TotalSub03,2,',','.'); ?></td>
							<td align="right"><?php echo number_format($TotalSub04,2,',','.'); ?></td>
							<td align="right">+ Peso palet (<?php echo number_format($pesoPatel,2,',','.'); ?>)</td>
							<td align="right"><?php echo number_format($PesoFinal,2,',','.');?>&nbsp;</td>
						  </tr>
						  <?php
						  $TotalSub02=0;$TotalSub03=0;$TotalSub04=0;
						}
						$LoteAux=$Row2["lote"];	
						$i++;
					}					
					?>
				  <tr align="center" class="TituloTablaNaranja">
					<td height="15" colspan="2" align="right"><strong>TOTAL</strong></td>
					<td align="right"><?php echo number_format($Total02,2,',','.'); ?></td>
					<td align="right"><?php echo number_format($Total03,2,',','.'); ?></td>
					<td align="right"><?php echo number_format($Total04,2,',','.'); ?></td>
					<td align="right">&nbsp;</td>
					<td align="right">&nbsp;</td>
				  </tr>
				  <?php
				}
				?>
    </table>�	</td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"></td>
  </tr>
</table>
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
        <td colspan="2" align="left" class="TituloCabeceraAzul">Fecha Embarque desde </td>
        <td colspan="5" class="formulario"><span class="ColorTabla02">
            <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($Dia))
			{
				if ($Dia == $i)
					echo $i;
			}
		}
	  ?>
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
            <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($Ano))
			{
				if ($Ano == $i)
					echo $i;
			}
		}
		?>
        </span></td>
        </tr>
      <tr>
        <td colspan="2" align="left" class="TituloCabeceraAzul">Fecha Embarque hasta </td>
        <td colspan="5" class="formulario"><span class="ColorTabla02">
            <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaH))
			{
				if ($DiaH == $i)
					echo $i;
			}
		}
	  ?>
            <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesH))
			{
				if ($MesH == $i)
					echo ucwords(strtolower($Meses[$i - 1]));
			}
		}
		?>
            <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoH))
			{
				if ($AnoH == $i)
					echo $i;
			}
		}
		?>
        </span></td>
        </tr>
    </table>
	<br />
<table width="60%" border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
      <?php	
				$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote";
				$Consulta.= " where t2.fecha_embarque between '".$Ano."-".$Mes."-".$Dia." 00:00:00' and '".$AnoH."-".$MesH."-".$DiaH." 23:59:59'";
				$Consulta.= " group by t2.correlativo_sipa";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					echo "<tr class='TituloCabeceraAzul'>\n";
					echo "<td align='left' colspan='2'>Correlativo Sipa</td>\n";
					echo "<td align='left' colspan='5'>".$Row["correlativo_sipa"]."</td>\n";
					echo "</tr>\n";
					?>
      <tr align="center" class="TituloCabeceraAzul">
        <td width="41" height="15" class="TituloCabeceraAzul">Lote</td>
        <td width="95">Recargo</td>
        <td width="149">Peso Bruto</td>
        <td width="149">Peso Tara</td>
        <td width="149">Peso Neto</td>
        <td width="149">Sello interno</td>
        <td width="149">Sello externo</td>
      </tr>
      <?php
					$Consulta = "select * from pmn_web.pmn_pesa_bad_cabecera t1 inner join pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote";
					$Consulta.= " where t2.correlativo_sipa='".$Row["correlativo_sipa"]."'";
					$Consulta.= " order by t2.lote,t2.recargo";
					echo "<input type='hidden' name='selec'>";
					$Respuesta2 = mysqli_query($link, $Consulta);
					$Total02=0;$Total03=0;$Total04=0;$i=1;$TotalSub02=0;$TotalSub03=0;$TotalSub04=0;
					while ($Row2 = mysqli_fetch_array($Respuesta2))
					{
						echo "<tr>\n";
						echo "<td align='center'>".$Row2["lote"]."</td>\n";
						echo "<td align='center'>".$Row2["recargo"]."</td>\n";
						echo "<td align='right'>".number_format($Row2["pbruto"],2,',','.')."</td>\n";
						echo "<td align='right'>".number_format($Row2["ptara"],2,',','.')."</td>\n";
						echo "<td align='right'>".number_format($Row2["pneto"],2,',','.')."</td>\n";
						echo "<td align='right'>".$Row2["sint"]."</td>\n";
						echo "<td align='right'>".$Row2["sext"]."</td>\n";
						echo "</tr>\n";
						
						$Total02 = $Total02 + $Row2["pbruto"];
						$Total03 = $Total03 + $Row2["ptara"];
						$Total04 = $Total04 + $Row2["pneto"];
						
							$TotalSub02 = $TotalSub02 + $Row2["pbruto"];
							$TotalSub03 = $TotalSub03 + $Row2["ptara"];
							$TotalSub04 = $TotalSub04 + $Row2["pneto"];
						if($Row2["recargo"]==4)
						{
							if($Row2["palet_a_b"]=='B')
								$Consulta="select peso_palet_b as peso_palet";
							if($Row2["palet_a_b"]=='A')	
								$Consulta="select peso_palet_a as peso_palet";
							$Consulta.=" from pmn_pesa_bad_cabecera where lote='".$Row2["lote"]."'";
							$RESP=mysqli_query($link, $Consulta);
							if($Fila=mysqli_fetch_assoc($RESP))
								$pesoPatel=$Fila["peso_palet"];
							$PesoFinal=	$TotalSub04+$pesoPatel;
						  ?>
						  <tr align="center" class="TituloCabecera">
							<td height="15" colspan="2" align="right"><strong >Sub-TOTAL</strong></td>
							<td align="right"><?php echo number_format($TotalSub02,2,',','.'); ?></td>
							<td align="right"><?php echo number_format($TotalSub03,2,',','.'); ?></td>
							<td align="right"><?php echo number_format($TotalSub04,2,',','.'); ?></td>
							<td align="right">+ Peso palet (<?php echo number_format($pesoPatel,2,',','.'); ?>)</td>
							<td align="right"><?php echo number_format($PesoFinal,2,',','.');?>&nbsp;</td>
						  </tr>
						  <?php
						  $TotalSub02=0;$TotalSub03=0;$TotalSub04=0;
						}
						if($Row2["recargo"]==8)
						{
							if($Row2["palet_a_b"]=='B')
								$Consulta="select peso_palet_b as peso_palet";
							if($Row2["palet_a_b"]=='A')	
								$Consulta="select peso_palet_a as peso_palet";
							$Consulta.=" from pmn_pesa_bad_cabecera where lote='".$Row2["lote"]."'";
							$RESP=mysqli_query($link, $Consulta);
							if($Fila=mysqli_fetch_assoc($RESP))
								$pesoPatel=$Fila["peso_palet"];
							$PesoFinal=	$TotalSub04+$pesoPatel;
						  ?>
						  <tr align="center" class="TituloCabecera">
							<td height="15" colspan="2" align="right"><strong >Sub-TOTAL</strong></td>
							<td align="right"><?php echo number_format($TotalSub02,2,',','.'); ?></td>
							<td align="right"><?php echo number_format($TotalSub03,2,',','.'); ?></td>
							<td align="right"><?php echo number_format($TotalSub04,2,',','.'); ?></td>
							<td align="right">+ Peso palet (<?php echo number_format($pesoPatel,2,',','.'); ?>)</td>
							<td align="right"><?php echo number_format($PesoFinal,2,',','.');?>&nbsp;</td>
						  </tr>
						  <?php
						  $TotalSub02=0;$TotalSub03=0;$TotalSub04=0;
						}
						$LoteAux=$Row2["lote"];	
						$i++;
					}					
					?>
      <tr align="center" class="TituloTablaNaranja">
        <td height="15" colspan="2" align="right"><strong>TOTAL</strong></td>
        <td align="right"><?php echo number_format($Total02,2,',','.'); ?></td>
        <td align="right"><?php echo number_format($Total03,2,',','.'); ?></td>
        <td align="right"><?php echo number_format($Total04,2,',','.'); ?></td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <?php
				}
				?>
    </table>      �	</td>
    <td width="1%"></td>
  </tr>
</table>
<?php	
}
?>