<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');	
?>
<html>
<head>
<title>Reporte Disponibilidad</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td width="9%">&nbsp;</td>
      <td colspan="5" align="center" >MES <? echo strtoupper($Meses[$Mes-1])." ".$Ano;?></td>
      <td colspan="5" align="center">ACUMULADO <? echo strtoupper($Meses[$Mes-1])." ".$Ano;?></td>
      <td width="8%">&nbsp;</td>
    </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3" align="center" >REAL</td>
            <td width="10%" align="center" >PROYECTADA</td>
			<td rowspan="2" align="center" ><p>% Variacion</p><p>Disponibilidad</p></td>
            <td colspan="3" align="center" >REAL</td>
            <td width="10%" align="center" >PROYECTADA</td>
            <td rowspan="2" align="center" ><p>% Variacion</p><p>Disponibilidad</p></td>
          </tr>
          <tr>
            <td align="center" >EQUIPO</td>
            <td width="10%" align="center" >HORAS DISPONIBLES </td>
            <td width="10%" align="center" >HORAS REALES </td>
            <td width="10%" align="center" >DISPONIBILIDAD</td>
            <td align="center" >DISPONIBILIDAD</td>
            <td width="13%" align="center" >HORAS DISPONIBLES </td>
            <td width="10%" align="center">HORAS REALES </td>
            <td width="10%" align="center" >DISPONIBILIDAD</td>
            <td align="center" >DISPONIBILIDAD</td>
            </tr>
		  <?
			$Consulta="select t1.cod_equipo,t2.nom_equipo from pcip_eec_equipos_por_sistema t1 inner join pcip_eec_equipos t2 on t1.cod_equipo=t2.cod_equipo where t1.cod_sistema='".$CmbSistema."' ";
			if($CmbEquipos!='T')
				$Consulta.=" and t1.cod_equipo ='".$CmbEquipos."' ";
			$Resp=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				echo "<tr>";
				echo "<td >".$Fila[nom_equipo]."</td>";
				$DatosVal=explode('~',ValoresDisponibilidad('R',$Ano,$Mes,$CmbSistema,$Fila[cod_equipo],'M'));
				echo "<td align='right'>".number_format($DatosVal[0],0,'','.')."</td>";
				echo "<td align='right'>".number_format($DatosVal[1],0,'','.')."</td>";
				echo "<td align='right'>".number_format(($DatosVal[0]-$DatosVal[1]),0,'','.')."</td>";
				$Disp=$DatosVal[0]-$DatosVal[1];
				$DatosVal=explode('~',ValoresDisponibilidad('P',$Ano,$Mes,$CmbSistema,$Fila[cod_equipo],'M'));
				echo "<td align='right'>".number_format($DatosVal[0],0,'','.')."</td>";
				if($DatosVal[0]>0)
					$Porc=($Disp*100)/$DatosVal[0];
				else
					$Porc='';	
				echo "<td align='right'>".number_format($Porc,2,',','.')."</td>";
				$DatosVal=explode('~',ValoresDisponibilidad('R',$Ano,$Mes,$CmbSistema,$Fila[cod_equipo],'A'));
				echo "<td align='right'>".number_format($DatosVal[0],0,'','.')."</td>";
				echo "<td align='right'>".number_format($DatosVal[1],0,'','.')."</td>";
				echo "<td align='right'>".number_format(($DatosVal[0]-$DatosVal[1]),0,'','.')."</td>";
				$Disp=$DatosVal[0]-$DatosVal[1];
				$DatosVal=explode('~',ValoresDisponibilidad('P',$Ano,$Mes,$CmbSistema,$Fila[cod_equipo],'A'));
				echo "<td align='right'>".number_format($DatosVal[0],0,'','.')."</td>";
				if($DatosVal[0]>0)
					$Porc=($Disp*100)/$DatosVal[0];
				else
					$Porc='';	
				echo "<td align='right'>".number_format($Porc,2,',','.')."</td>";
				echo "</tr>";
			}
		  ?>	
        </table>
</form>
</body>
</html>
<?
function ValoresDisponibilidad($Tipo,$Ano,$Mes,$CmbSistema,$CodEquipo,$Opcion)
{
	if($Opcion=='A')
		$MesIni=1;
	else
		$MesIni=$Mes;
	$MesFin=$Mes;		
	$Consulta="select sum(t1.valor) as valor,sum(t1.valor_real) as valor_real from pcip_eec_disponibilidades t1 where t1.tipo_disponibilidad='".$Tipo."' and t1.ano='".$Ano."' and t1.mes between '".$MesIni."' and '".$MesFin."' ";
	$Consulta.= " and t1.cod_sistema='".$CmbSistema."' ";
	$Consulta.= " and t1.cod_equipo='".$CodEquipo."'";
	if($Opcion=='A')
		$Consulta.= " group by t1.cod_sistema,t1.cod_equipo,t1.tipo_disponibilidad,t1.ano ";
	else
		$Consulta.= " group by t1.cod_sistema,t1.cod_equipo,t1.tipo_disponibilidad,t1.ano,t1.mes ";	
	//echo $Consulta;
	$Resp2=mysql_query($Consulta);
	if($Fila2=mysql_fetch_array($Resp2))
	{
		$Valor=$Fila2[valor]."~".$Fila2[valor_real];
	}
	return($Valor);
}

?>