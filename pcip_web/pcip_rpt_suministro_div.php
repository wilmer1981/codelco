<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
?>
<html>
<head>
<title>Reporte Suministro Total Divisi�n</title>
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
 <td width="958" valign="top"><table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
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
		<td width="81%" align="center" class='formulario2 Estilo7'>Informe Total Divisi&oacute;n <? echo $Ano;?></td>
	    <td width="19%" align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span></a><a href="JavaScript:Procesos('C')"></a><a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> <a href="JavaScript:Procesos('S')"><img src="archivos/Close2.png" alt="Volver" width="27" height="25" border="0" align="absmiddle"></a></td>
	</tr>
</table>
   </td>
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
        <td><br>
          <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td width="10%" rowspan="2" align="center" class="TituloTablaVerde">Suministro</td>
			  <td width="7%" rowspan="2" align="center" class="TituloTablaVerde">Unid.</td>
              <td colspan="4" align="center" class="TituloTablaVerde"><? echo strtoupper($Meses[$Mes-1]);?></td>
              <td colspan="4" align="center" class="TituloTablaVerde">ACUMULADO A&Ntilde;O </td>
              </tr>
            <tr>
              <td width="10%" align="center" class="TituloTablaVerde">Real</td>
              <td width="10%" align="center" class="TituloTablaVerde">Ppto. Aj </td>
              <td width="10%" align="center" class="TituloTablaVerde">Var.</td>
			  <td width="10%" align="center" class="TituloTablaVerde">Var[%].</td>
              <td width="10%" align="center" class="TituloTablaVerde">Real</td>
              <td width="10%" align="center" class="TituloTablaVerde">Ppto. Aj </td>
              <td width="10%" align="center" class="TituloTablaVerde">Var.</td>
			   <td width="10%" align="center" class="TituloTablaVerde">Var[%].</td>
            </tr>
            <?
			$Consulta="select * from pcip_eec_suministros_grupos ";
			if($CmbGrupoSuministro!='T')
				$Consulta.="where cod_suministro_grupo='".$CmbGrupoSuministro."'";	
			$Consulta.="order by nom_agrupacion";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				echo "<tr><td class='pie_tabla_bold' colspan='10'>".$Fila[nom_agrupacion]."</td></tr>";
				$Consulta = "select t1.cod_suministro,t2.nom_suministro,t2.cod_unidad from pcip_eec_suministros_por_grupos t1 inner join pcip_eec_suministros t2 on t1.cod_suministro=t2.cod_suministro ";
				$Consulta.= "where t1.cod_suministro_grupo='".$Fila[cod_suministro_grupo]."'";
				if($CmbSuministro!='T')
					$Consulta.= "and t2.cod_suministro='".$CmbSuministro."' ";				
				$Consulta.= " order by t2.nom_suministro ";			
				$RespS=mysqli_query($link, $Consulta);
				while ($FilaS=mysql_fetch_array($RespS))
				{
					echo "<tr>";
					echo "<td>".$FilaS[nom_suministro]."</td>";
					echo "<td>".$FilaS[cod_unidad]."</td>";
					$ValorReal=ConsumoMes('S',$FilaS[cod_suministro],$Ano,$Mes);
					echo "<td align='right'>".number_format($ValorReal,0,',','.')."</td>";
					$ValorPpto=ConsumoMes('P',$FilaS[cod_suministro],$Ano,$Mes);
					echo "<td align='right'>".number_format($ValorPpto,0,',','.')."</td>";
					$Var=$ValorReal-$ValorPpto;
					echo "<td align='right'>".number_format($Var,0,',','.')."</td>";
					if($ValorPpto>0)
						$VarPorc=(($ValorReal-$ValorPpto)/$ValorPpto)*100;
					else
						$VarPorc='';	
					echo "<td align='right'>".number_format($VarPorc,0,',','.')."</td>";
					$ValorReal=ConsumoAcumulado('S',$FilaS[cod_suministro],$Ano,$Mes);
					echo "<td align='right'>".number_format($ValorReal,0,',','.')."</td>";
					$ValorPpto=ConsumoAcumulado('P',$FilaS[cod_suministro],$Ano,$Mes);
					echo "<td align='right'>".number_format($ValorPpto,0,',','.')."</td>";
					$Var=$ValorReal-$ValorPpto;
					echo "<td align='right'>".number_format($Var,0,',','.')."</td>";
					if($ValorPpto>0)
						$VarPorc=(($ValorReal-$ValorPpto)/$ValorPpto)*100;
					else
						$VarPorc='';	
					echo "<td align='right'>".number_format($VarPorc,0,',','.')."</td>";
					echo "</tr>";				
				}				
			}
			?>
          </table>
          <br><br></td>
        <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
        <td height="15"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
        <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
      </tr>
    </table>
	<br></td>
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
	$Resp=mysqli_query($link, $Consulta);
	if ($Fila=mysql_fetch_array($Resp))
		$Consumo=$Fila[cantidad];
	return($Consumo);	
}
function ConsumoAcumulado($TipoSumi,$CmbSuministro,$Ano,$Mes)
{
	$Consulta = "select sum(valor) as cantidad from pcip_eec_suministros_detalle where tipo='".$TipoSumi."' and cod_suministro='".$CmbSuministro."' and ano='".$Ano."' and mes between 1 and ".($Mes)." group by tipo,cod_suministro,ano";
	//echo $Consulta;		
	$Resp=mysqli_query($link, $Consulta);
	if ($Fila=mysql_fetch_array($Resp))
		$Consumo=$Fila[cantidad];
	return($Consumo);	
}

?>