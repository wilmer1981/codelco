<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
?>
<html>
<head>
<title>Reporte Suministro Total División Excel</title>
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
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.close();
		break;
	
	}
	
}

</script>
<style type="text/css">
<!--
.Estilo7 {font-size: 16px}
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
  <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
      <tr>
        <td align="center" class='formulario2'>Informe Total Divisi&oacute;n <? echo $Ano;?><a href="JavaScript:Procesos('C')"></a><a href="JavaScript:Procesos('C')"></a></td>
        </tr>
    </table>
    <br>
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="17%">&nbsp;</td>
        <td colspan="3" align="center" class="TituloTablaVerde"><? echo strtoupper($Meses[$Mes-1]);?></td>
        <td colspan="3" align="center" class="TituloTablaVerde">ACUMULADO A&Ntilde;O </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="14%" align="center" class="TituloTablaVerde">Real</td>
        <td width="16%" align="center" class="TituloTablaVerde">Ppto. Aj </td>
        <td width="13%" align="center" class="TituloTablaVerde">Var.</td>
        <td width="14%" align="center" class="TituloTablaVerde">Real</td>
        <td width="14%" align="center" class="TituloTablaVerde">Ppto. Aj </td>
        <td width="12%" align="center" class="TituloTablaVerde">Var.</td>
      </tr>
      <?
			$Consulta="select * from pcip_eec_suministros_grupos order by nom_agrupacion";
			$Resp=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				echo "<tr><td class='pie_tabla_bold' colspan='7'>".$Fila[nom_agrupacion]."</td></tr>";
				$Consulta = "select t1.cod_suministro,t2.nom_suministro from pcip_eec_suministros_por_grupos t1 inner join pcip_eec_suministros t2 on t1.cod_suministro=t2.cod_suministro ";
				$Consulta.= "where t1.cod_suministro_grupo='".$Fila[cod_suministro_grupo]."' order by t2.nom_suministro ";			
				$RespS=mysql_query($Consulta);
				while ($FilaS=mysql_fetch_array($RespS))
				{
					echo "<tr>";
					echo "<td>".$FilaS[nom_suministro]."</td>";
					$ValorReal=ConsumoMes('S',$FilaS[cod_suministro],$Ano,$Mes);
					echo "<td align='right'>".number_format($ValorReal,0,',','.')."</td>";
					$ValorPpto=ConsumoMes('P',$FilaS[cod_suministro],$Ano,$Mes);
					echo "<td align='right'>".number_format($ValorPpto,0,',','.')."</td>";
					$Var=$ValorPpto-$ValorReal;
					echo "<td align='right'>".number_format($Var,0,',','.')."</td>";
					$ValorReal=ConsumoAcumulado('S',$FilaS[cod_suministro],$Ano,$Mes);
					echo "<td align='right'>".number_format($ValorReal,0,',','.')."</td>";
					$ValorPpto=ConsumoAcumulado('P',$FilaS[cod_suministro],$Ano,$Mes);
					echo "<td align='right'>".number_format($ValorPpto,0,',','.')."</td>";
					$Var=$ValorPpto-$ValorReal;
					echo "<td align='right'>".number_format($Var,0,',','.')."</td>";
					echo "</tr>";				
				}				
			}
			?>
    </table></td>
 </tr>
  </table>
	</form>
</body>
</html>
<?
function ConsumoMes($TipoSumi,$CmbSuministro,$Ano,$Mes)
{
	$Consulta = "select sum(valor) as cantidad from pcip_eec_suministros_detalle where tipo='".$TipoSumi."' and cod_suministro='".$CmbSuministro."' and ano='".$Ano."' and mes='".$Mes."' group by tipo,cod_suministro,ano,mes";
	//echo $Consulta;		
	$Resp=mysql_query($Consulta);
	if ($Fila=mysql_fetch_array($Resp))
		$Consumo=$Fila[cantidad];
	return($Consumo);	
}
function ConsumoAcumulado($TipoSumi,$CmbSuministro,$Ano,$Mes)
{
	$Consulta = "select sum(valor) as cantidad from pcip_eec_suministros_detalle where tipo='".$TipoSumi."' and cod_suministro='".$CmbSuministro."' and ano='".$Ano."' and mes between 1 and ".($Mes)." group by tipo,cod_suministro,ano";
	//echo $Consulta;		
	$Resp=mysql_query($Consulta);
	if ($Fila=mysql_fetch_array($Resp))
		$Consumo=$Fila[cantidad];
	return($Consumo);	
}

?>