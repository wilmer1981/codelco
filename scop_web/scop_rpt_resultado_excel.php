<?
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    include("../principal/conectar_scop_web.php");
    include("funciones/scop_funciones.php");

?>
<html>
<head>
<title>Consulta Resultado Excel</title>
<form name="FrmPrincipal" method="post" action="">
  <table width="100%" border="1" cellpadding="4" cellspacing="0" >
    <tr align="center">
      <td width="10%">A�o</td>
      <td width="10%" align="left"><? echo $Ano;?></td>
      <td width="10%">&nbsp;</td>
      <td width="10%">&nbsp;</td>
      <td width="10%">&nbsp;</td>
      <td width="10%">&nbsp;</td>
    </tr>
    <tr align="center">
      <td width="10%" rowspan="2">Mes</td>
      <td width="10%" rowspan="2">Divisi&oacute;n</td>
      <td width="10%" colspan="3">Resultado</td>
      <td width="10%" rowspan="2">Total</td>
    </tr>
    <tr>
      <td width="20%" align="center">Cobre [USD]</td>
      <td width="20%" align="center">Plata [USD]</td>
      <td width="20%" align="center">Oro [USD]</td>
    </tr>
    <?
	$HayDatos='N';
	$Datos=explode('~',$DivChecked);
	while(list($c,$v)=each($Datos))
	{
		$DatoDiv=$DatoDiv."'".$v."',";
	}	
	if($DatoDiv!='')
		$DatoDiv=substr($DatoDiv,0,strlen($DatoDiv)-1);	
	$Consulta="select * from scop_imputacion where ano='".$Ano."'";
	if($Mes!='T')
		$Consulta.=" and mes='".$Mes."'";
	$Consulta.=" and cod_division in ($DatoDiv)";
	$Consulta.=" group by ano,mes";	
	$Resp=mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		$HayDatos='S';
		$ConsultaDiv="select * from scop_imputacion t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33006' and t1.cod_division=t2.cod_subclase";
		$ConsultaDiv.=" where ano='".$Fila["ano"]."' and mes='".$Fila["mes"]."'";
		$ConsultaDiv.=" and cod_division in ($DatoDiv)";
		$ConsultaDiv.=" group by cod_division";
		$Resp1=mysql_query($ConsultaDiv);$Cont=0;$Cant=0;
		while ($Fila1=mysql_fetch_array($Resp1))
		{
			$ConsultaFilas="select distinct * from scop_imputacion t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33006' and t1.cod_division=t2.cod_subclase";
			$ConsultaFilas.=" where t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."' and cod_division='".$Fila1[cod_division]."' group by ano,mes,cod_division";
			$RespFilas=mysql_query($ConsultaFilas);
			while ($FilaFilas=mysql_fetch_array($RespFilas))
				$Cant=$Cant+1;	
		}
	?>
    <tr> <? echo "<td class='formulario' rowspan=".$Cant." align='center'>".$Meses[$Fila["mes"]-1]."</td>";?>
        <?
			$ConsultaDiv="select * from scop_imputacion t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33006' and t1.cod_division=t2.cod_subclase";
			$ConsultaDiv.=" where ano='".$Fila["ano"]."' and mes='".$Fila["mes"]."'";
			$ConsultaDiv.=" and cod_division in ($DatoDiv)";
			$ConsultaDiv.=" group by t1.cod_division";
			$Resp1=mysql_query($ConsultaDiv);$Cont=0;
			while ($Fila1=mysql_fetch_array($Resp1))
			{
				$Cont=$Cont+1;
			?>
        <td align="left"><? echo $Fila1["nombre_subclase"]; ?></td>
      <?
					$ConsultaRes="select * from scop_imputacion t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33006' and t1.cod_division=t2.cod_subclase";
					$ConsultaRes.=" where ano='".$Fila["ano"]."' and mes='".$Fila["mes"]."'";
					$ConsultaRes.=" and cod_division='".$Fila1[cod_division]."'";
					$RespRes=mysql_query($ConsultaRes);$Cu=0;$Ag=0;$Au=0;$ValorCu='- - -';$ValorAg='- - -';$ValorAu='- - -';$Total=0;
					while ($FilaRes=mysql_fetch_array($RespRes))
					{
						if($FilaRes["cod_ley"]==1)
						{
							$Cu=$FilaRes[valor_imputado];
							if($Cu==0)
								$ValorCu='- - -';	
							else
							{
								$ValorCu=number_format($FilaRes[valor_imputado],0,',','.');
								$Total=$Total+$FilaRes[valor_imputado];
								$TotalCu=$TotalCu+$FilaRes[valor_imputado];
							}
						}
						if($FilaRes["cod_ley"]==2)
						{
							$Ag=$FilaRes[valor_imputado];
							if($Ag==0)
								$ValorAg='- - -';	
							else
							{
								$ValorAg=number_format($FilaRes[valor_imputado],0,',','.');
								$Total=$Total+$FilaRes[valor_imputado];
								$TotalAg=$TotalAg+$FilaRes[valor_imputado];
							}
						}
						if($FilaRes["cod_ley"]==3)
						{
							$Au=$FilaRes[valor_imputado];
							if($Au==0)
								$ValorAu='- - -';
							else
							{
								$ValorAu=number_format($FilaRes[valor_imputado],0,',','.');
								$Total=$Total+$FilaRes[valor_imputado];
								$TotalAu=$TotalAu+$FilaRes[valor_imputado];
							}
						}
					}
					echo "<td align='right'>".$ValorCu."</td>";
					echo "<td align='right'>".$ValorAg."</td>";
					echo "<td align='right'>".$ValorAu."</td>";
					echo "<td align='right' >".number_format($Total,0,',','.')."</td>";
					$Total2=$Total2+$Total;
					?>
    </tr>
    <?
			}	
	}
	echo "<tr>";
		echo "<td colspan='2' align='right'>Total</td>";
		echo "<td align='right'>".number_format($TotalCu,0,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalAg,0,',','.')."</td>";
		echo "<td align='right'>".number_format($TotalAu,0,',','.')."</td>";
		echo "<td align='right'>".number_format($Total2,0,',','.')."</td>";
	echo "</tr>";
?>
  </table>
</form>
</body>
</html>
<?
function Filas($Ano,$Mes)
{
	$ConsultaFilas="select ifnull(count(*),0) as cant from scop_imputacion where ano='".$Ano."' and mes='".$Mes."' group by ano,mes";
	$RespFilas=mysql_query($ConsultaFilas);$Cant=0;
	while ($FilaFilas=mysql_fetch_array($RespFilas))
	  $Cant=$FilaFilas["cant"];
	  
	return($Cant);  
}
?>