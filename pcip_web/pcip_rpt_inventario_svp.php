<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
if(!isset($CmbMostrar))
	$CmbMostrar='P';			
?>
<html>
<head>
<title>Reporte Inventario Svp</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">

function GenerarExcel(ctto,emp)
{
		var URL = "../sget_web/sget_genera_excel.php?Ctto="+ctto+"&Empresa="+emp;
			window.open(URL,"","top=30,left=30,width=550,height=180,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				
}

function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "C"://BUSCA DISPONIBILIDAD EQUIPOS
			/*if(f.CmbOrdenProd.value=='-1')
			{
				alert('Debe Seleccionar Orden de Producci�n');
				f.CmbOrdenProd.focus();
				return;
			}*/
			f.action = "pcip_rpt_inventario_svp.php?Buscar=S";
			f.submit();
		break;
		case "E":
			URL='pcip_rpt_inventario_svp_excel.php?CmbOrdenProd='+f.CmbOrdenProd.value+'&CmbMaterial='+f.CmbMaterial.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&CmbMostrar";
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;
		case "R":
			f.action = "pcip_rpt_inventario_svp.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=8";
		break;
	
	}
	
}

</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 11px}
-->
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'inventario.png')
?>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
   <td  width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
   <td>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
	<tr>
		<td width="81%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td width="19%" align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span></a><a href="JavaScript:Procesos('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Procesos('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> <a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a></td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
    <td width="16%" height="17" class='formulario2'>Ordenes de Producci&oacute;n </td>
    <td class="formulario2" >    
      <select name="CmbOrdenProd" onChange="Procesos('R')">
        <option value="-1" selected="selected">Todas</option>
        <?
	  $Consulta = "select OPorden,OPdescripcion from pcip_svp_ordenesproduccion order by OPorden ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbOrdenProd==$FilaTC["OPorden"])
				echo "<option selected value='".$FilaTC["OPorden"]."'>".$FilaTC["OPorden"]."&nbsp;&nbsp;".ucfirst($FilaTC["OPdescripcion"])."</option>\n";
			else
				echo "<option value='".$FilaTC["OPorden"]."'>".$FilaTC["OPorden"]."&nbsp;&nbsp;".ucfirst($FilaTC["OPdescripcion"])."</option>\n";
		}
			?>
      </select>    </td>
  </tr>
  <tr>
    <td width="16%" height="17" class='formulario2'>Material</td>
    <td class="formulario2" >    
      <select name="CmbMaterial">
        <option value="T" selected="selected">Todos</option>
        <?
	  $Consulta = "select * from pcip_svp_tiposinventarios where TIorden='".$CmbOrdenProd."' order by TIcodigo ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbMaterial==$FilaTC["TIcodigo"])
				echo "<option selected value='".$FilaTC["TIcodigo"]."'>".str_pad($FilaTC["TIcodigo"],3,'0',STR_PAD_LEFT)."&nbsp;&nbsp;".ucfirst($FilaTC["TIdescripcion"])."</option>\n";
			else
				echo "<option value='".$FilaTC["TIcodigo"]."'>".str_pad($FilaTC["TIcodigo"],3,'0',STR_PAD_LEFT)."&nbsp;&nbsp;".ucfirst($FilaTC["TIdescripcion"])."</option>\n";
		}
			?>
      </select>    </tr>	  
  <tr>

    <td height="25" class='formulario2'>Periodo</td>
    <td class='formulario2'>
			  <?
	  if($CmbMostrar!='M')
	  {
	  ?>

	Desde 
      <?
	  }
	  ?>
	  <select name="Ano" id="Ano">
      <?
	for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
    </select>
		  <?
	  if($CmbMostrar!='M')
	  {
	  ?>

      <select name="Mes" id="Mes">
        <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$Mes)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
?>
      </select>
      
	  Hasta
	  <?
	  }
	  if($CmbMostrar!='M')
	  {
	  ?>
	        <select name="AnoFin">
        <?
	for ($i=2003;$i<=date("Y");$i++)
	{
		if ($i==$AnoFin)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
      </select>
	  <?
	  }
	  if($CmbMostrar!='M')
	  {
	  ?>

      <select name="MesFin">
        <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$MesFin)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
?>
      </select>
	  <?
	  }
	  ?>	    </tr>
 </table>  </td>
  <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" ><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" ><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br>
    <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
        <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
        <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
        <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
      </tr>
      <tr>
        <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0" >
		  <?
 				if($CmbMostrar=='P')
				{
		  ?>
          <tr class="TituloTablaVerde">
            <td width="7%" rowspan="2" align="center"><span class="Estilo9">Orden de Producci&oacute;n </span></td>
            <td width="25%" rowspan="2" align="center"><span class="Estilo9">Descripcion Orden Co </span></td>
            <td width="21%" colspan="3" align="center"><span class="Estilo9">Cantidad [TMF]</span></td>
            <td width="21%" colspan="3" align="center"><span class="Estilo9">Valor [US$] </span></td>
            <td width="21%" colspan="3" align="center"><span class="Estilo9">Costo Unitario [US$/TMF] </span></td>
          </tr>
          <tr class="TituloTablaVerde">
            <td width="7%" align="center"><span class="Estilo9">Inicial</span></td>
            <td width="7%" align="center"><span class="Estilo9">Final</span></td>
            <td width="7%" align="center"><span class="Estilo9">Variaci&oacute;n</span></td>
            <td width="7%" align="center"><span class="Estilo9">Inicial</span></td>
            <td width="7%" align="center"><span class="Estilo9">Final</span></td>
            <td width="7%" align="center"><span class="Estilo9">Variaci&oacute;n</span></td>
            <td width="7%" align="center"><span class="Estilo9">Inicial</span></td>
            <td width="7%" align="center"><span class="Estilo9">Final</span></td>
            <td width="7%" align="center"><span class="Estilo9">Variaci&oacute;n</span></td>
          </tr>
		  <?
		  }
		  if($CmbMostrar=='M')
		  {
		  ?>
          <tr class="TituloTablaVerde">
            <td width="7%" rowspan="2" align="center"><span class="Estilo9">Orden de Producci&oacute;n </span></td>
            <td width="25%" rowspan="2" align="center"><span class="Estilo9">Descripcion Orden Co </span></td>
           
			<?
			for($i=1;$i<=12;$i++)
			{
		       	echo "<td width='21%' colspan='3' align='center'><span class='Estilo9'>".$Meses[$i-1]." ".$Ano."</span></td>";
			}
			?>
		  </tr>
          <tr class="TituloTablaVerde">
		  	<?
 			for($i=1;$i<=12;$i++)
			{
			?>           
			<td width="7%" align="center"><span class="Estilo9">Inventario</span></td>
            <td width="7%" align="center"><span class="Estilo9">Valor</span></td>
            <td width="7%" align="center"><span class="Estilo9">C.Unitario</span></td>
          	<?
			}
			?>
			
		  </tr>
		  
		  <?
		  }
		  
		  ?>
		  <?
		  	if($Buscar=='S')
			{
				$CmbMostrar='P';
				if($CmbMostrar=='P')
				{
					$MesAux=$Mes;
					$AnoAux=$Ano;
					if($Mes==1)
					{
						$MesAnt=12;
						$AnoAnt=$Ano-1;
					}
					else
					{	
						$MesAnt=$Mes-1;
						$AnoAnt=$Ano;
					}
					if($Mes==1)
					{
						$MesAux=12;
						$AnoAux=$Ano-1;
					}
					else
						$MesAux=$Mes-1;
					
					$Consulta="SELECT t1.VPorden,t2.OPdescripcion FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_ordenesproduccion t2 on t1.VPorden=t2.OPorden WHERE t1.VPtm='25' and ((t1.VPa�o = '".$Ano."' and t1.VPmes='".$Mes."') or (t1.VPa�o = '".$AnoFin."' and t1.VPmes='".$MesFin."')or (t1.VPa�o = '".$AnoAnt."' and t1.VPmes='".$MesAnt."'))";
					if($CmbOrdenProd!='-1')
						$Consulta.=" AND t1.VPorden = '".$CmbOrdenProd."'";
					if($CmbMaterial!='T')
						$Consulta.=" AND t1.VPtipinv='".$CmbMaterial."'";
					$Consulta.=" group by t1.VPorden";
					//echo $Consulta;
					$Resp=mysql_query($Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						$TotCantIni=0;$TotCantFin=0;$TotValorIni=0;$TotValorFin=0;
						echo "<tr class='FilaAbeja2'>";
						echo "<td>".$Fila[VPorden]."</td>";
						echo "<td colspan='10'>".$Fila[OPdescripcion]."</td>";
						echo "</tr>";
						$Consulta="SELECT t1.VPorden,t2.OPdescripcion,t1.VPtipinv FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_ordenesproduccion t2 on t1.VPorden=t2.OPorden WHERE t1.VPtm='25' and ((t1.VPa�o = '".$Ano."' and t1.VPmes='".$Mes."') or (t1.VPa�o = '".$AnoFin."' and t1.VPmes='".$MesFin."') or (t1.VPa�o = '".$AnoAnt."' and t1.VPmes='".$MesAnt."'))";
						//if($CmbOrdenProd!='-1')
							$Consulta.=" AND t1.VPorden = '".$Fila[VPorden]."'";
						if($CmbMaterial!='T')
							$Consulta.=" AND t1.VPtipinv='".$CmbMaterial."'";
						$Consulta.=" group by t1.VPorden,t1.VPtipinv";
						//echo $Consulta;
						$RespO=mysql_query($Consulta);
						while($FilaO=mysql_fetch_array($RespO))
						{
							echo "<tr>";
							echo "<td>&nbsp;</td>";
							$Consulta="SELECT TIdescripcion FROM pcip_svp_tiposinventarios WHERE TIcodigo='".$FilaO[VPtipinv]."'";
							$RespTipoInv=mysql_query($Consulta);
							$FilaTipoInv=mysql_fetch_array($RespTipoInv);

							$Consulta="SELECT t1.VPcantidad,t1.VPvalor FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_tiposinventarios t2 on t1.VPtipinv=t2.TIcodigo WHERE t1.VPtm='25' and (t1.VPa�o = '".$AnoAux."' and t1.VPmes='".$MesAux."')";
							$Consulta.=" AND VPorden = '".$FilaO[VPorden]."'";
							$Consulta.=" AND VPtipinv='".$FilaO[VPtipinv]."'";
							//echo $Consulta."<br>";
							$RespIni=mysql_query($Consulta);
							$FilaIni=mysql_fetch_array($RespIni);
							echo "<td>".str_pad($FilaO[VPtipinv],3,'0',STR_PAD_LEFT)." ".$FilaTipoInv[TIdescripcion]."</td>";
							$Consulta="SELECT VPcantidad,VPvalor FROM pcip_svp_valorizacproduccion WHERE VPtm='25' and (VPa�o = '".$AnoFin."' and VPmes='".$MesFin."')";
							$Consulta.=" AND VPorden = '".$FilaO[VPorden]."'";
							$Consulta.=" AND VPtipinv='".$FilaO[VPtipinv]."'";
							$RespFin=mysql_query($Consulta);
							$FilaFin=mysql_fetch_array($RespFin);
							echo "<td align='right'>".number_format($FilaIni[VPcantidad],3,',','.')."</td>";
							echo "<td align='right'>".number_format($FilaFin[VPcantidad],3,',','.')."</td>";
							echo "<td align='right'>".number_format(($FilaFin[VPcantidad]-$FilaIni[VPcantidad]),3,',','.')."</td>";
							echo "<td align='right'>".number_format($FilaIni[VPvalor],2,',','.')."</td>";
							echo "<td align='right'>".number_format($FilaFin[VPvalor],2,',','.')."</td>";
							echo "<td align='right'>".number_format(($FilaFin[VPvalor]-$FilaIni[VPvalor]),2,',','.')."</td>";
							$CantCostoIni=$FilaIni[VPcantidad];
							$ValorCostoIni=$FilaIni[VPvalor];
							if($CantCostoIni>0)
								$CostoIni=$ValorCostoIni/$CantCostoIni;
							else
								$CostoIni=0;
							echo "<td align='right'>".number_format($CostoIni,5,',','.')."</td>";
							$CantCostoFin=$FilaFin[VPcantidad];
							$ValorCostoFin=$FilaFin[VPvalor];
							if($CantCostoFin>0)
								$CostoFin=$ValorCostoFin/$CantCostoFin;
							else
								$CostoFin=0;	
							echo "<td align='right'>".number_format($CostoFin,5,',','.')."</td>";
							echo "<td align='right'>".number_format($CostoFin-$CostoIni,5,',','.')."</td>";
							echo "</tr>";
							$TotCantIni=$TotCantIni+$FilaIni[VPcantidad];
							$TotCantFin=$TotCantFin+$FilaFin[VPcantidad];
							$TotValorIni=$TotValorIni+$FilaIni[VPvalor];
							$TotValorFin=$TotValorFin+$FilaFin[VPvalor];
						}
						echo "<tr class='FilaAbeja2'>";
						echo "<td colspan='2' align='right'>Totales</td>";
						echo "<td align='right'>".number_format($TotCantIni,3,',','.')."</td>";
						echo "<td align='right'>".number_format($TotCantFin,3,',','.')."</td>";
						echo "<td align='right'>".number_format($TotCantFin-$TotCantIni,3,',','.')."</td>";
						echo "<td align='right'>".number_format($TotValorIni,2,',','.')."</td>";
						echo "<td align='right'>".number_format($TotValorFin,2,',','.')."</td>";
						echo "<td align='right'>".number_format($TotValorFin-$TotValorIni,2,',','.')."</td>";
						if($TotCantIni>0)
							$CostoUniIni=$TotValorIni/$TotCantIni;
						else
							$CostoUniIni=0;
						if($TotCantFin>0)
							$CostoUniFin=$TotValorFin/$TotCantFin;
						else
							$CostoUniFin=0;
						if($TotCantIni>0&&$TotCantFin>0)
							$CostoVar=($TotValorFin/$TotCantFin)-($TotValorIni/$TotCantIni);
						else
							$CostoVar=0;
						echo "<td align='right'>".number_format($CostoUniIni,5,',','.')."</td>";
						echo "<td align='right'>".number_format($CostoUniFin,5,',','.')."</td>";
						echo "<td align='right'>".number_format($CostoVar,5,',','.')."</td>";
						echo "</tr>";
					}
				}
				/*if($CmbMostrar=='M')
				{
					$Consulta="SELECT t1.VPorden,t2.OPdescripcion FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_ordenesproduccion t2 on t1.VPorden=t2.OPorden WHERE t1.VPtm='25' and t1.VPa�o = '".$Ano."'";
					if($CmbOrdenProd!='-1')
						$Consulta.=" AND t1.VPorden = '".$CmbOrdenProd."'";
					if($CmbMaterial!='T')
						$Consulta.=" AND t1.VPtipinv='".$CmbMaterial."'";
					$Consulta.=" group by t1.VPorden";
					//echo $Consulta;
					$Resp=mysql_query($Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						echo "<tr class='FilaAbeja2'>";
						echo "<td>".$Fila[VPorden]."</td>";
						echo "<td colspan='39'>".$Fila[OPdescripcion]."</td>";
						echo "</tr>";
						$Consulta="SELECT t1.VPorden,t2.OPdescripcion,t1.VPtipinv FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_ordenesproduccion t2 on t1.VPorden=t2.OPorden WHERE t1.VPtm='25' and t1.VPa�o = '".$Ano."'";
						if($CmbOrdenProd!='-1')
							$Consulta.=" AND t1.VPorden = '".$Fila[VPorden]."'";
						if($CmbMaterial!='T')
							$Consulta.=" AND t1.VPtipinv='".$CmbMaterial."'";
						$Consulta.=" group by t1.VPorden,t1.VPtipinv";
						//echo $Consulta;
						array($ArrayTot);
						for($i=1;$i<=12;$i++)
						{
							$ArrayTot[$i][0]='';
							$ArrayTot[$i][1]='';
						}
						//reset($ArrayTot);
						$RespO=mysql_query($Consulta);
						while($FilaO=mysql_fetch_array($RespO))
						{
							echo "<tr>";
							echo "<td>&nbsp;</td>";
							$Consulta="SELECT t2.TIdescripcion FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_tiposinventarios t2 on t1.VPtipinv=t2.TIcodigo WHERE t1.VPtm='25' and t1.VPa�o = '".$Ano."'";
							$Consulta.=" AND VPorden = '".$FilaO[VPorden]."'";
							$Consulta.=" AND VPtipinv='".$FilaO[VPtipinv]."'";
							$Consulta.=" group by t1.VPa�o,t1.VPmes";
							//echo $Consulta;
							$RespMat=mysql_query($Consulta);
							$FilaMat=mysql_fetch_array($RespMat);
							echo "<td>".str_pad($FilaO[VPtipinv],3,'0',STR_PAD_LEFT)." ".$FilaMat[TIdescripcion]."</td>";
							echo "<td>TMS</td>";
							for($i=1;$i<=12;$i++)
							{
								$Consulta="SELECT t1.VPcantidad,t1.VPvalor,t2.TIdescripcion FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_tiposinventarios t2 on t1.VPtipinv=t2.TIcodigo WHERE t1.VPtm='25' and t1.VPa�o = '".$Ano."' and t1.VPmes='".$i."'";
								$Consulta.=" AND VPorden = '".$FilaO[VPorden]."'";
								$Consulta.=" AND VPtipinv='".$FilaO[VPtipinv]."'";
								$Consulta.=" group by t1.VPa�o,t1.VPmes";
								//echo $Consulta."<BR>";
								$RespMeses=mysql_query($Consulta);
								if($FilaMeses=mysql_fetch_array($RespMeses))
								{
									echo "<td align='right'>".number_format($FilaMeses[VPcantidad],3,',','.')."</td>";
									echo "<td align='right'>".number_format($FilaMeses[VPvalor],2,',','.')."</td>";
									echo "<td align='right'>".number_format(($FilaMeses[VPvalor]/$FilaMeses[VPcantidad]),2,',','.')."</td>";
									//echo $ArrayTot[$i][0]."<br>";
									$ArrayTot[$i][0]=$ArrayTot[$i][0]+$FilaMeses[VPcantidad];
									$ArrayTot[$i][1]=$ArrayTot[$i][1]+$FilaMeses[VPvalor];
								}
								else
								{
									echo "<td>&nbsp;</td>";
									echo "<td>&nbsp;</td>";
									echo "<td>&nbsp;</td>";
								}
							}	
							echo "</tr>";	
						}
						echo "<tr class='FilaAbeja2'>";
						echo "<td colspan='2' align='right'>Totales</td>";
						echo "<td>TMS</td>";
						reset($ArrayTot);
						for($i=1;$i<=12;$i++)
						{
							if($ArrayTot[$i][0]!=''&&$ArrayTot[$i][0]!=0)
								$Var=$ArrayTot[$i][1]/$ArrayTot[$i][0];
							else
								$Var='';	
							echo "<td align='right'>".number_format($ArrayTot[$i][0],5,',','.')."</td>";
							echo "<td align='right'>".number_format($ArrayTot[$i][1],5,',','.')."</td>";
							echo "<td align='right'>".number_format($Var,5,',','.')."</td>";
							//echo "<td align='right'>".number_format(0,3,',','.')."</td>";
							//echo "<td align='right'>".number_format(0,3,',','.')."</td>";
							//echo "<td align='right'>".number_format(0,3,',','.')."</td>";
							$ArrayTot[$i][0]='';
							$ArrayTot[$i][1]='';
						}
						echo "</tr>";
					}
				}
				*/
			}
		  ?>
        </table></td>
        <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
        <td height="15"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
        <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
      </tr>
    </table></td>
 </tr>
  </table>
	<? include("pie_pagina.php")?>

</form>
</body>
</html>