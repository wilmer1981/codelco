<?
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../principal/conectar_scop_web.php");
include("funciones/scop_funciones.php");
$KoolControlsFolder="KoolPHPSuite/KoolControls";
require $KoolControlsFolder."/KoolAjax/koolajax.php";
$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

if($koolajax->isCallback)
{
	sleep(0); //Slow down 1s to see loading effect
}

echo $koolajax->Render();

if(!isset($Ano))
	$Ano=date('Y');
?>
<html>
<head>
<title>Imputaci�n CC</title>	
<form name="FrmPrincipal" method="post" action="">
<table width="930" border="1" cellpadding="4" cellspacing="0" >
  <?
  	$Buscar='S';
		 if($Buscar=='S')
		 {
		 ?>
  <tr align="center" class="TituloTablaVerde">
    <td width="7%" rowspan="2">A&ntilde;o/Mes</td>
    <td colspan="3">Resultado</td>
  </tr>
  <tr align="center" class='TituloTablaVerde' >
    <td width="10%"><? echo "Cobre [USD]";?></td>
    <td width="12%"><? echo "PLata [USD]";?></td>
    <td width="11%"><? echo "Oro [USD]";?></td>
  </tr>
  <?			  
			   $ArrInventario=array();$ArrCarry=array();$ArrPrecios=array();$ArrPrecios2=array();
			   for($i=1;$i<=3;$i++)
			   {
					$ArrInventario[$i][Cu]='';$ArrInventario[$i][Au]='';$ArrInventario[$i][Ag]='';
					$ArrCarry[$i][Cu]='';$ArrCarry[$i][Au]='';$ArrCarry[$i][Ag]='';
					$ArrPrecios[$i][Cu]='';$ArrPrecios[$i][Au]='';$ArrPrecios[$i][Ag]='';
					$ArrPrecios2[$i][Cu]='';$ArrPrecios2[$i][Au]='';$ArrPrecios2[$i][Ag]='';
			   }						   					 
				echo "<tr>";
				$Consulta="select t1.acuerdo_contractual,t1.corr,t1.parcializacion,t1.ano,t1.mes,t1.estado,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
				$Consulta.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where t1.ano='".$Ano."' and t3.vigente='1'";				
				if($Mes!='T')
					$Consulta.=" and t1.mes='".$Mes."'";	
				$Consulta.="  and t1.estado in ('5','6') group by corr,parcializacion order by ano,mes";	
				$Resp = mysql_query($Consulta);$ED=0;
				while($Fila=mysql_fetch_assoc($Resp))
				{	
					$Correlativo=$Fila["corr"];
					$Parcializacion=$Fila[parcializacion];
					if($Fila["estado"]=='5')
						$Clase="class='BordeFecha'";
					else	
						$Clase="bgcolor='#FFFFFF'";
					$ConsultaRows="select distinct t1.corr,t1.parcializacion,t1.ano,t1.mes,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
					$ConsultaRows.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where t1.corr='".$Correlativo."' and t1.parcializacion='".$Parcializacion."' and t1.ano='".$Ano."' and t3.vigente='1'";				
					$ConsultaRows.="  and t1.estado in ('5','6') group by corr,parcializacion";	
					$RespRows = mysql_query($ConsultaRows);$Rowspan=0;
					while($FilaRows=mysql_fetch_assoc($RespRows))
					{
						$Rowspan=$Rowspan+1;
						$Abrircandado=$Abrircandado.$FilaRows["corr"]."~".$Rowspan."~".$FilaRows["ano"]."~".$FilaRows["mes"]."//";
						$Imputar2=$Imputar2.$FilaRows["corr"]."~".$Rowspan."~".$FilaRows["ano"]."~".$FilaRows["mes"]."//";
					}
					$Consulta2="select t1.corr,t1.parcializacion,t1.ano,t1.mes,t1.estado,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
					$Consulta2.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where t1.ano='".$Ano."' and t3.vigente='1'";				
					if($Mes!='T')
						$Consulta2.=" and t1.mes='".$Mes."'";	
					$Consulta2.="  and t1.estado in ('5','6') group by ano,mes";	
					$Resp2 = mysql_query($Consulta2);$ED=0;
					while($Fila2=mysql_fetch_assoc($Resp2))
					{
							$Ano2=$Fila2["ano"];$Mes2=$Fila2["mes"];
					}
					
					ValoresInventarioValidado($Fila["corr"],$Fila["ano"],$Fila["mes"],$Fila[parcializacion],$CmbAcuerdo,$TipoEst,&$ArrInventario);
					ValoresCarryCost($Fila["corr"],$Fila[parcializacion],$Fila["ano"],$Fila["mes"],$CmbAcuerdo,$TipoEst,&$ArrCarry);
					ValorPreciosOperacionesAcuerdoQp($Fila["corr"],$Fila[parcializacion],$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios);	
					ValorPreciosOperacionesAcuerdo($Fila["corr"],$Fila[parcializacion],$CmbAcuerdo,$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios2);	
		
							reset($ArrPrecios);	reset($ArrInventario);reset($ArrCarry);	reset($ArrPrecios2);
							if($ArrPrecios[1][Cu]!='0')
							{
								$ImputarCu=$Fila["ano"]."~".$Fila["mes"];
								$CarryCostTotalCu=$ArrInventario[1][Cu]*$ArrCarry[1][Cu];		
								$ResultadoPrecioCVCobre=$ArrPrecios2[1][Cu]-$ArrPrecios[1][Cu];										
								$ResultadoCu=($ArrInventario[1][Cu]*$ResultadoPrecioCVCobre)+$CarryCostTotalCu;
								$SumaCu=$SumaCu+$ResultadoCu;
							}	
							else
								$SumaCu=0;
							if($ArrPrecios[2][Ag]!='0')
							{
								$ImputarAg=$Fila["ano"]."~".$Fila["mes"];
								$CarryCostTotalAg=$ArrInventario[2][Ag]*$ArrCarry[2][Ag]/100;
								$ResultadoPrecioCVPlata=$ArrPrecios2[2][Ag]-$ArrPrecios[2][Ag];										
								$ResultadoAg=($ArrInventario[2][Ag]*$ResultadoPrecioCVPlata)+$CarryCostTotalAg;
								$SumaAg=$SumaAg+$ResultadoAg;
							}	
							else
								$SumaAg=0;
							if($ArrPrecios[3][Au]!='0')
							{
								$ImputarAu=$Fila["ano"]."~".$Fila["mes"];
								$CarryCostTotalAu=$ArrInventario[3][Au]*$ArrCarry[3][Au];
								$ResultadoPrecioCVOro=$ArrPrecios2[3][Au]-$ArrPrecios[3][Au];					
								$ResultadoAu=($ArrInventario[3][Au]*$ResultadoPrecioCVOro)+$CarryCostTotalAu;
								$SumaAu=$SumaAu+$ResultadoAu;
							}
							else
								$SumaAu=0;
							
					$NumParcial++;	
					$Corr=$Fila["corr"];$Ano=$Fila["ano"];$Mes=$Fila["mes"];$Parc=$Fila[parcializacion];$Estado=$Fila["estado"];
					$Detalle=$Fila["ano"]."~".$Mes=$Fila["mes"];
				}
				if($Abrircandado!='')
					$Abrircandado=substr($Abrircandado,0,strlen($Abrircandado)-2);
				if($Imputar2!='')
					$Imputar2=substr($Imputar2,0,strlen($Imputar2)-2);
				
				$Consulta1="select distinct t1.corr,t1.ano,t1.mes,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
				$Consulta1.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where ano='".$Ano."' and mes='".$Mes."' and t3.vigente='1'";				
				$Resp1 = mysql_query($Consulta1);$Contratos='';
				while($Fila1=mysql_fetch_assoc($Resp1))
					$Contratos=$Contratos.$Fila1[cod_contratos]."~";
					
				if($Contratos!='')
					$Contratos=substr($Contratos,0,strlen($Contratos)-1);	
				echo "<input type='hidden' name='Contratos' value=".$Contratos.">";
				
				?>
  <td rowspan=".$Rowspan." <? echo $Clase;?>><? echo $Ano2."/".substr($Meses[$Mes2-1],0,3);?></td>
      <?
				$Imputar=$Imputar.$Ano."~".$Mes."//";
				if($Imputar!='')
					$Imputar=substr($Imputar,0,strlen($Imputar)-2);
				if($SumaCu!=0)
				{
					?>
    <td align='right' <? echo $Clase;?>><? echo number_format($SumaCu,0,',','.');	
				}
				else
				{
					?>
    <td align='center' <? echo $Clase;?>>- - -
        <?	
				}
				if($SumaAg!=0)
				{
					?>
    <td align='right' <? echo $Clase;?>><? echo number_format($SumaAg,0,',','.');	
				}
				else
				{
					?>
    <td align='center' <? echo $Clase;?>>- - -
        <?	
				}
				if($SumaAu!=0)
				{
					?>
    <td align='right' <? echo $Clase;?>><? echo number_format($SumaAu,0,',','.');	
				}
				else
				{
					?>
    <td width="40%" align='center' <? echo $Clase;?>>- - -
        <?	
				}
				//SABER QUE ESTADO TIENE EL CARRY COST SI ES CANDADO O GUARDAR NUEVO CARRY
				echo "</tr>";
		}	
		?>
  </table>
<br>
</form>
</body>
</html>
<?
	if($Mensaje=='S')
   {
?>
	<script language="javascript">
	alert("No se pueden Eliminar el dato, existen relaciones ")
	</script>
<? }
	if($Buscar=='S'&&$ED==0)
   {
?>
	<script language="javascript">
	alert("No Hay Registros validados por la VCO, para Ingreso de Valores Imputaci�n")
	</script>
<? }

function ValoresInventarioValidado($Corr,$Ano,$Mes,$Parci,$Acuerdo,$TipoEst,$ArrInventario)
{
	$Parcializar=$Corr."~".$Parci."~".$Ano."~".$Mes;
	$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp = mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila["estado"]=='2')
			$Datos='S';
		else	
			$Datos='N';
		if($Fila["estado"]=='5')
			$Clase="class='BordeFecha'";
		else	
			$Clase="bgcolor='#FFFFFF'";
		$Consulta="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='1'";
		$Resp = mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($Fila["cod_ley"]==1)
				$ValorCobre=$Fila["valor"];
			if($Fila["cod_ley"]==2)
				$ValorPLata=$Fila["valor"];
			if($Fila["cod_ley"]==3)
				$ValorOro=$Fila["valor"];
		}
	}
	$ArrInventario[1][Cu]=$ValorCobre;
	$ArrInventario[2][Ag]=$ValorPLata;
	$ArrInventario[3][Au]=$ValorOro;
}
function ValoresCarryCost($Corr,$Parci,$Ano,$Mes,$Acuerdo,$TipoEst,$ArrCarry)
{
	$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{				
		if($Fila["estado"]=='5')
			$Clase="class='BordeFecha'";
		else	
			$Clase="bgcolor='#FFFFFF'";
		$NomTxt="Cu_".$Fila["corr"]."_".$Fila[parcializacion];
		$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='2'";
		$RespPro=mysql_query($ConsultaPro);
		while($FilaPro=mysql_fetch_array($RespPro))
		{
			if($FilaPro["cod_ley"]==1)
				$ValorCobre=$FilaPro["valor"];
			if($FilaPro["cod_ley"]==2)
				$ValorPLata=$FilaPro["valor"];
			if($FilaPro["cod_ley"]==3)
				$ValorOro=$FilaPro["valor"];
		}
	}
	$ArrCarry[1][Cu]=$ValorCobre;
	$ArrCarry[2][Ag]=$ValorPLata;
	$ArrCarry[3][Au]=$ValorOro;
}
function ValorPreciosOperacionesAcuerdo($Corr,$Parci,$CmbAcuerdo,$Ano,$Mes,$TipoEst,$ArrPrecios2)
{
	
	$Consulta="select corr,acuerdo_contractual,tipo_cobertura,precio_fijo_cu,precio_fijo_ag,precio_fijo_au,estado from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila[acuerdo_contractual]=='P'||$Fila[acuerdo_contractual]!='P')
		{
			if($Fila[tipo_cobertura]==1)//CAMBIO QP
			{
				$MesDeEntregaValor=$Fila[acuerdo_contractual]+$Mes;		
				//CONSULTO EL VALOR CON EL QP INGRESADO
				$Consulta="select * from scop_precios_metales where ano='".$Ano."' and mes='".$MesDeEntregaValor."'";
				//echo $Consulta."<br>";
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					if($Fila["cod_ley"]==1)
						$ValorCobre=$Fila["valor"];
					if($Fila["cod_ley"]==2)
						$ValorPLata=$Fila["valor"];
					if($Fila["cod_ley"]==3)
						$ValorOro=$Fila["valor"];
				}
			$ArrPrecios2[1][Cu]=$ValorCobre;
			$ArrPrecios2[2][Ag]=$ValorPLata;
			$ArrPrecios2[3][Au]=$ValorOro;
			}	
			if($Fila[tipo_cobertura]==2)//PRECIO FIJO
			{
				$Consulta="select t2.acuerdo_cu from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Fila["corr"]."' and tipo_cu='2' and t2.vigente='1'";
				$Resp=mysql_query($Consulta);$CantidadCu=0;
				while($Fila=mysql_fetch_array($Resp))
						$CantidadCu=$CantidadCu+$Fila[acuerdo_cu];
				$ValorCobre=$CantidadCu;
				
				$Consulta="select t2.acuerdo_ag from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Fila["corr"]."' and tipo_ag='2' and t2.vigente='1'";
				$Resp=mysql_query($Consulta);$CantidadAg=0;
				while($Fila=mysql_fetch_array($Resp))
						$CantidadAg=$CantidadAg+$Fila[acuerdo_cu];
				$ValorPLata=$CantidadAg;
				
				$Consulta="select t2.acuerdo_au from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Fila["corr"]."' and tipo_au='2' and t2.vigente='1'";
				$Resp=mysql_query($Consulta);$CantidadAu=0;
				while($Fila=mysql_fetch_array($Resp))
						$CantidadAu=$CantidadAu+$Fila[acuerdo_cu];
				$ValorOro=$CantidadAu;

			$ArrPrecios2[1][Cu]=$ValorCobre;
			$ArrPrecios2[2][Ag]=$ValorPLata;
			$ArrPrecios2[3][Au]=$ValorOro;
			}
		}
	}	
}
function ValorPreciosOperacionesAcuerdoQp($Corr,$Parci,$Ano,$Mes,$TipoEst,$ArrPrecios)
{
	$Consulta="select corr,acuerdo_contractual,tipo_cobertura,acuerdo_contractual_qp_cu,acuerdo_contractual_qp_ag,acuerdo_contractual_qp_au,precio_fijo_cu,precio_fijo_ag,precio_fijo_au,estado from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		$MesDeEntregaValorCu=$Fila[acuerdo_contractual_qp_cu]+$Mes;		
		$MesDeEntregaValorAg=$Fila[acuerdo_contractual_qp_ag]+$Mes;		
		$MesDeEntregaValorAu=$Fila[acuerdo_contractual_qp_au]+$Mes;		
		if($Fila[acuerdo_contractual]=='P'||$Fila[acuerdo_contractual]!='P')
		{
			if($Fila[tipo_cobertura]==1)//CAMBIO QP
			{				
				//CONSULTO EL VALOR CON EL QP INGRESADO
				$Consulta="select * from scop_precios_metales where ano='".$Ano."' and mes='".$MesDeEntregaValorCu."' and cod_ley='1'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorCobre=$Fila["valor"];
				else
					$ValorCobre=0;
				$Consulta="select * from scop_precios_metales where ano='".$Ano."' and mes='".$MesDeEntregaValorAg."' and cod_ley='2'";
				//echo $Consulta."<br>";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorPLata=$Fila["valor"];
				else
					$ValorPLata=0;	
				$Consulta="select * from scop_precios_metales where ano='".$Ano."' and mes='".$MesDeEntregaValorAu."' and cod_ley='3'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorOro=$Fila["valor"];
				else
					$ValorOro=0;	

			$ArrPrecios[1][Cu]=$ValorCobre;
			$ArrPrecios[2][Ag]=$ValorPLata;
			$ArrPrecios[3][Au]=$ValorOro;
			}	
			if($Fila[tipo_cobertura]==2)//PRECIO FIJO
			{
				$ArrPrecios[1][Cu]=$Fila[precio_fijo_cu];
				$ArrPrecios[2][Ag]=$Fila[precio_fijo_ag];
				$ArrPrecios[3][Au]=$Fila[precio_fijo_au];
			}
		}
	}	
}
function ValorEstados($Corr,$Parci,$Ano,$Mes,$TipoEst)
{
	$Consulta="select ano,mes,acuerdo_contractual_qp from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{	
			$Acuerdo_contractual_qp=$Fila[acuerdo_contractual_qp];	
			$MesDeEntregaValor=$Mes+$Acuerdo_contractual_qp;
			$Consulta="select * from scop_precios_metales where ano='".$Fila["ano"]."' and mes='".$MesDeEntregaValor."'";
			//echo $Consulta."<br>";
			$Resp=mysql_query($Consulta);$Existe='';
			if($Fila=mysql_fetch_array($Resp))
					$Existe=1;
	}
	return($Existe);
}
?>
