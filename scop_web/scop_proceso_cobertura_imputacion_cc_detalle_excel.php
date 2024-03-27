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
<title>Detalle Imputacion de Valores</title>
<body>
<form name="FrmPrincipal" method="post" action="">
<table width="100%" border="1" cellpadding="4" cellspacing="0" >
  <?
			$Buscar='S';
		 if($Buscar=='S')
		 {
		 ?>
  <tr align="center" class="TituloTablaVerde">
    <td width="6%" rowspan="2">A&ntilde;o/Mes</td>
    <td width="6%" rowspan="2">Acuerdo</td>
    <td width="10%" colspan="3">Inventario</td>
    <td width="10%" colspan="3">Carry Cost </td>
    <td width="10%" colspan="3">Precio Compra </td>
    <td width="10%" colspan="3">Precio Venta </td>
    <td width="10%" colspan="3">Carry Cost </td>
    <td width="11%" colspan="3">Resultado</td>
    <td width="11%" rowspan="2">Tipo Cobert.</td>
  </tr>
  <tr align="center" class='TituloTablaVerde' >
    <? 
				for($i=0;$i<=5;$i++)
				{
					if($i==0)
					{
						$Cobre="[OZ]";$Plata="[OZ]";$Oro="[OZ]";
					}
					if($i==1)
					{
						$Cobre="[cUSD/lb]";$Plata="[cUSD/oz]";$Oro="[USD/oz]";
					}
					if($i==4)
					{
						$Cobre="[USD]";$Plata="[USD]";$Oro="[USD]";
					}
					if($i==3||$i==2)
					{
						$Cobre="[USD/lb]";$Plata="[USD/OZ]";$Oro="[USD/OZ]";
					}
					if($i==0||$i==1||$i==4||$i==5)
					{
						 echo "<td>Cobre ".$Cobre."</td>";
						 echo "<td>PLata ".$Plata."</td>";
						 echo "<td>Oro ".$Oro."</td>";
					}
					if($i==2||$i==3)
					{
						 echo "<td>Cobre ".$Cobre."</td>";
						 echo "<td>PLata ".$Plata."</td>";
						 echo "<td>Oro ".$Oro."</td>";
					}
				}
				?>
  </tr>
  <?			  
			   $ArrInventario=array();$ArrCarry=array();$ArrPrecios=array();
			   for($i=1;$i<=3;$i++)
			   {
					$ArrInventario[$i][Cu]='';$ArrInventario[$i][Au]='';$ArrInventario[$i][Ag]='';
					$ArrCarry[$i][Cu]='';$ArrCarry[$i][Au]='';$ArrCarry[$i][Ag]='';
					$ArrPrecios[$i][Cu]='';$ArrPrecios[$i][Au]='';$ArrPrecios[$i][Ag]='';
					$ArrPrecios2[$i][Cu]='';$ArrPrecios2[$i][Au]='';$ArrPrecios2[$i][Ag]='';
			   }	
			    $ResultadoAu=0;$ResultadoAg=0;$ResultadoCu=0;					   					 
				$Consulta="select t1.acuerdo_contractual,t1.corr,t1.parcializacion,t1.ano,t1.mes,t1.tipo_cobertura,t2.cod_contratos,t3.cod_tipo_contr,t1.estado from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
				$Consulta.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where ano='".$Ano."' and mes='".$Mes."' and t1.estado in ('5','6') and t3.vigente='1' group by corr,parcializacion order by corr,ano,mes";				
				$Resp = mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{		
					if($Fila[acuerdo_contractual]=='-1')
						$Mes="Mes";
					else
						$Mes="Mes +";	
					$Correlativo=$Fila["corr"];
					$Parcializacion=$Fila[parcializacion];
					$ConsultaRows="select distinct t1.corr,t1.parcializacion,t1.ano,t1.mes,t1.tipo_cobertura,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
					$ConsultaRows.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where t1.ano='".$Ano."' and t1.acuerdo_contractual='".$Fila[acuerdo_contractual]."' and t1.corr='".$Fila["corr"]."' and t1.estado in ('5','6') and t3.vigente='1' group by corr,parcializacion";				
					$RespRows = mysql_query($ConsultaRows);$Rowspan=0;$NomTxtCCost='';$Abrircandado='';$Guardar='';$Guardar2='';
					while($FilaRows=mysql_fetch_array($RespRows))
					{
						$TipoCobertura=$FilaRows[tipo_cobertura];
						$Rowspan=$Rowspan+1;
						$NomTxtCCost=$NomTxtCCost.$Fila["corr"]."_".$Rowspan."//";
						$Guardar=$Guardar.$FilaRows["corr"]."~".$Rowspan."~".$FilaRows["ano"]."~".$FilaRows["mes"]."~".$FilaRows[tipo_cobertura]."//";
						$Guardar2=$Guardar2.$FilaRows["corr"]."~".$Rowspan."~".$FilaRows["ano"]."~".$FilaRows["mes"]."~3//";
						$Abrircandado=$Abrircandado.$FilaRows["corr"]."~".$Rowspan."~".$FilaRows["ano"]."~".$FilaRows["mes"]."//";					
					}
					$Rowspan=$Rowspan;
					if($NomTxtCCost!='')
						$NomTxtCCost=substr($NomTxtCCost,0,strlen($NomTxtCCost)-2);
					if($Abrircandado!='')
						$Abrircandado=substr($Abrircandado,0,strlen($Abrircandado)-2);
					if($Guardar!='')
						$Guardar=substr($Guardar,0,strlen($Guardar)-2);
						
					$Consulta1="select distinct t1.corr,t1.ano,t1.mes,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
					$Consulta1.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato where t1.corr='".$Fila["corr"]."' and t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."' and t1.parcializacion='".$Fila[parcializacion]."' and acuerdo_contractual='".$CmbAcuerdo."' and t3.vigente='1'";				
					//echo $Consulta1."<br>";
					$Resp1 = mysql_query($Consulta1);$Contratos='';
					while($Fila1=mysql_fetch_array($Resp1))
						$Contratos=$Contratos.$Fila1[cod_contratos]."~";
						
					if($Contratos!='')
						$Contratos=substr($Contratos,0,strlen($Contratos)-1);	
					echo "<input type='hidden' name='Contratos' value=".$Contratos.">";
					echo "<tr bgcolor='#FFFFFF'>";
					if($Parcializacion==1)
					{	echo "<td rowspan=".$Rowspan.">".substr($Fila["ano"],2)."/".substr($Meses[$Fila["mes"]-1],0,3)."</td>";
						echo "<input type='hidden' name='Mes' value=".$Fila["mes"].">";
						echo "<td rowspan=".$Rowspan.">".$Mes."&nbsp;".$Fila[acuerdo_contractual]."</td>";
					}
					for($k=0;$k<=5;$k++)
					{
						if($k==0)
							ValoresInventarioValidado($Fila["corr"],$Fila["ano"],$Fila["mes"],$Parcializacion,$CmbAcuerdo,$TipoEst,&$ArrInventario);
						if($k==1)
							ValoresCarryCost($Fila["corr"],$Parcializacion,$Fila["ano"],$Fila["mes"],$CmbAcuerdo,$TipoEst,&$ArrCarry);
						if($k==2)
							ValorPreciosOperacionesAcuerdoQp($Fila["corr"],$Parcializacion,$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios);	
						if($k==3)
							ValorPreciosOperacionesAcuerdo($Fila["corr"],$Parcializacion,$CmbAcuerdo,$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios2);	
						if($k==4)//Calculo de VALORES CARRY COST DE LA GRILLA
						{
							reset($ArrPrecios);reset($ArrInventario);reset($ArrCarry);								
							if($ArrPrecios[1][Cu]!='0')
							{
								$CarryCostTotalCu=($ArrInventario[1][Cu]*$ArrCarry[1][Cu])/100;	
								echo "<td align='right' $Clase>".number_format($CarryCostTotalCu,3,',','.')."</td>";
								$CarryCostTotalCu=0;	
							}
							else
								echo "<td align='center' $Clase>- - -</td>";							
							if($ArrPrecios[2][Ag]!='0')
							{
								$CarryCostTotalAg=$ArrInventario[2][Ag]*$ArrCarry[2][Ag]/100;
								echo "<td align='right' $Clase>".number_format($CarryCostTotalAg,3,',','.')."</td>";
								$CarryCostTotalAg=0;	
							}
							else
								echo "<td align='center' $Clase>- - -</td>";							
							if($ArrPrecios[3][Au]!='0')
							{
								$CarryCostTotalAu=$ArrInventario[3][Au]*$ArrCarry[3][Au];
								echo "<td align='right' $Clase>".number_format($CarryCostTotalAu,3,',','.')."</td>";
								$CarryCostTotalAu=0;	
							}
							else
								echo "<td align='center' $Clase>- - -</td>";							
						}	
						if($k==5)// CALCULO DE LOS VALORES DEL RESULTADO DE LA GRILLAA
						{
							reset($ArrPrecios);reset($ArrPrecios2);	reset($ArrInventario);reset($ArrCarry);	
							if($ArrPrecios[1][Cu]!='0')
							{
								if($ArrCarry[1][Cu]!=0)
								{
									$CarryCostTotalCu=($ArrInventario[1][Cu]*$ArrCarry[1][Cu])/100;	
									$ResultadoPrecioCVCobre=$ArrPrecios2[1][Cu]-$ArrPrecios[1][Cu];										
									$ResultadoCu=($ArrInventario[1][Cu]*($ResultadoPrecioCVCobre)/100)+$CarryCostTotalCu;
									if($ResultadoCu!=0)
										echo "<td align='right' $Clase>".number_format($ResultadoCu,0,',','.')."</td>";	
									else
										echo "<td align='center' $Clase>- - -</td>";	
								}
								else
									echo "<td align='center' $Clase>- - -</td>";	
							}
							else
								echo "<td align='center' $Clase>- - -</td>";							
							if($ArrPrecios[2][Ag]!='0')
							{
								if($ArrCarry[2][Ag]!=0)
								{
									$CarryCostTotalAg=$ArrInventario[2][Ag]*$ArrCarry[2][Ag]/100;
									$ResultadoPrecioCVPlata=$ArrPrecios2[2][Ag]-$ArrPrecios[2][Ag];										
									$ResultadoAg=($ArrInventario[2][Ag]*$ResultadoPrecioCVPlata)+$CarryCostTotalAg;
									if($ResultadoAg!=0)
										echo "<td align='right' $Clase>".number_format($ResultadoAg,0,',','.')."</td>";	
									else
										echo "<td align='center' $Clase>- - -</td>";	
								}
								else
									echo "<td align='center' $Clase>- - -</td>";	
							}
							else
								echo "<td align='center' $Clase>- - -</td>";							
							if($ArrPrecios[3][Au]!='0')
							{
								if($ArrCarry[3][Au]!=0)
								{
									$CarryCostTotalAu=$ArrInventario[3][Au]*$ArrCarry[3][Au];
									$ResultadoPrecioCVOro=$ArrPrecios2[3][Au]-$ArrPrecios[3][Au];					
									$ResultadoAu=($ArrInventario[3][Au]*$ResultadoPrecioCVOro)+$CarryCostTotalAu;
									if($ResultadoAu!=0)
										echo "<td align='right' $Clase>".number_format($ResultadoAu,0,',','.')."</td>";	
									else
										echo "<td align='center' $Clase>- - -</td>";	
								}
								else
									echo "<td align='center' $Clase>- - -</td>";	
							}
							else
								echo "<td align='center' $Clase>- - -</td>";							
						}	
					}
					//SABER QUE ESTADO TIENE EL CARRY COST SI ES CANDADO O GUARDAR NUEVO CARRY
					$ConsultaCarry="select distinct t1.acuerdo_contractual,t1.corr,t1.precio_fijo_cu,t1.precio_fijo_ag,t1.precio_fijo_au,t1.estado,t2.cod_subclase,t2.nombre_subclase as nom_cobertura,t1.tipo_cobertura,t1.acuerdo_contractual_qp_cu,t1.acuerdo_contractual_qp_ag,t1.acuerdo_contractual_qp_au,t1.parcializacion from scop_carry_cost t1 ";
					$ConsultaCarry.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33005' and t1.tipo_cobertura=t2.cod_subclase";
					$ConsultaCarry.=" inner join scop_carry_cost_proceso t3 on t1.corr=t3.corr";
					$ConsultaCarry.=" where t1.corr='".$Fila["corr"]."' and t1.parcializacion='".$Fila[parcializacion]."' and  t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."'";
					//echo $ConsultaCarry."<br>";
					$RespCarry=mysql_query($ConsultaCarry);
					if ($FilaCarry=mysql_fetch_array($RespCarry))
					{
						echo "<input type='hidden' name='CmbTipoCobertura' value='".$FilaCarry[tipo_cobertura]."'>";						
						if($FilaCarry[acuerdo_contractual]=='P'||$FilaCarry[acuerdo_contractual]!='P')
						{
							if($FilaCarry[tipo_cobertura]=='1')//PARA VER QP O PRECIO FIJO
							{
								$ConsultaQp="select t1.* from scop_carry_cost t1 where t1.corr='".$Fila["corr"]."' and t1.parcializacion='".$Fila[parcializacion]."' and  t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."'";
								$RespQp=mysql_query($ConsultaQp);$QP='';
								while($FilaQp=mysql_fetch_array($RespQp))
								{								
										if($FilaQp[acuerdo_contractual_qp_cu]=='-1'||$FilaQp[acuerdo_contractual_qp_ag]=='-1'||$FilaQp[acuerdo_contractual_qp_au]=='-1')
											$Mes='M&nbsp;';
										else
											$Mes='M&nbsp;+';
										if($FilaQp[acuerdo_contractual_qp_cu]!=0)	
											$QP="Cu&nbsp;".$Mes.$FilaQp[acuerdo_contractual_qp_cu]."&nbsp;,";
										if($FilaQp[acuerdo_contractual_qp_ag]!=0)	
											$QP=$QP."Ag&nbsp;".$Mes.$FilaQp[acuerdo_contractual_qp_ag]."&nbsp;,";
										if($FilaQp[acuerdo_contractual_qp_au]!=0)	
											$QP=$QP."Au&nbsp;".$Mes.$FilaQp[acuerdo_contractual_qp_au]."&nbsp;,";
								}					
								if($QP!='')
									$QP=substr($QP,0,strlen($QP)-1);								
								echo "<td align='center'>".$FilaCarry[nom_cobertura]."&nbsp;".$QP."</td>";
							}
							if($FilaCarry[tipo_cobertura]=='2')//PRECIO FIJO
							{
								//CONSULTO LOS VALORES PRECIO FIJO PARA CADA CORRELATIVO QUE VENGA
								$ConsultaQp="select t1.* from scop_carry_cost t1 where t1.corr='".$Fila["corr"]."' and t1.parcializacion='".$Fila[parcializacion]."' and  t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."'";
								$RespQp=mysql_query($ConsultaQp);$QP='';
								while($FilaQp=mysql_fetch_array($RespQp))
								{
									$QP="Cu&nbsp;".number_format($FilaQp[precio_fijo_cu],3,',','.')."&nbsp;,";						
									$QP=$QP."Ag&nbsp;".number_format($FilaQp[precio_fijo_ag],3,',','.')."&nbsp;,";
									$QP=$QP."Au&nbsp;".number_format($FilaQp[precio_fijo_au],3,',','.')."&nbsp;,";
								}	
								if($QP!='')
									$QP=substr($QP,0,strlen($QP)-1);								
								echo "<td align='center'>".$FilaCarry[nom_cobertura]."<br>&nbsp;".$QP."</td>";
							}
						}
					}	
					$NumParcial++;	
				}
					
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
<? 
}

function ValoresInventarioValidado($Corr,$Ano,$Mes,$Parci,$Acuerdo,$TipoEst,$ArrInventario)
{
	$Parcializar=$Corr."~".$Parci."~".$Ano."~".$Mes;
	$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp = mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila["estado"]=='2')
			$Datos='S';
		else	
			$Datos='N';
		$Consulta="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='1'";
		$Resp = mysqli_query($link, $Consulta);
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
	if($ValorCobre!=0||$ValorCobre!='')
	{
		echo "<td align='right'>".number_format($ValorCobre,3,',','.')."";
		echo "<input type='hidden' size='10' class='SinBorde' name='InventarioCu' value=".number_format($ValorCobre,2,',','.').">";				
		$ArrInventario[1][Cu]=$ValorCobre;
	}
	else
		echo "<td align='center' $Clase>- - -</td>";	
	if($ValorPLata!=0||$ValorPLata!='')
	{		
		echo "<td align='right'>".number_format($ValorPLata,3,',','.')."";
		echo "<input type='hidden' size='10' class='SinBorde' name='InventarioAg' value=".number_format($ValorPLata,2,',','.').">";	
		$ArrInventario[2][Ag]=$ValorPLata;
	}
	else
		echo "<td align='center' $Clase>- - -</td>";	
	if($ValorOro!=0||$ValorOro!='')
	{		
		echo "<td align='right'>".number_format($ValorOro,3,',','.')."";
		echo "<input type='hidden' size='10' class='SinBorde' name='InventarioAu' value=".number_format($ValorOro,2,',','.').">";	
		$ArrInventario[3][Au]=$ValorOro;
	}
	else
		echo "<td align='center' $Clase>- - -</td>";	
}
function ValoresCarryCost($Corr,$Parci,$Ano,$Mes,$Acuerdo,$TipoEst,$ArrCarry)
{
	for($s=1;$s<=3;$s++)
	{
		$ArrCarry[1][Cu]=0;$ArrCarry[2][Ag]=0;$ArrCarry[3][Au]=0;
	}
	$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{				
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
		if($Fila["estado"]=='5'||$Fila["estado"]=='6')
		{
			if($ValorCobre!=0&&$ValorCobre!='')
			{
				echo "<td align='right'>".number_format($ValorCobre,3,',','.')."&nbsp;";
				$ArrCarry[1][Cu]=$ValorCobre;
			}
			else
				echo "<td align='center' $Clase>- - -</td>";	
			if($ValorPLata!=0&&$ValorPLata!='')
			{
				echo "<td align='right'>".number_format($ValorPLata,3,',','.')."&nbsp;";
				$ArrCarry[2][Ag]=$ValorPLata;
			}
			else
				echo "<td align='center' $Clase>- - -</td>";	
			if($ValorOro!=0&&$ValorOro!='')
			{				
				echo "<td align='right'>".number_format($ValorOro,3,',','.')."&nbsp;";
				$ArrCarry[3][Au]=$ValorOro;
			}
			else
				echo "<td align='center' $Clase>- - -</td>";	
		}
	}
}
function ValorPreciosOperacionesAcuerdo($Corr,$Parci,$CmbAcuerdo,$Ano,$Mes,$TipoEst,$ArrPrecios2)
{
	$Consulta="select corr,acuerdo_contractual,tipo_cobertura,precio_fijo_cu,precio_fijo_ag,precio_fijo_au,estado from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		$Corr=$Fila["corr"];
		if($Fila[acuerdo_contractual]=='P')
		{
			if($Fila[tipo_cobertura]==1||$Fila[tipo_cobertura]==2)//PRECIO FIJO
			{
				$Consulta="select t2.acuerdo_cu from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_cu='2' and t2.vigente='1'";
				$Resp=mysqli_query($link, $Consulta);$CantidadCu=0;
				while($Fila=mysql_fetch_array($Resp))
						$CantidadCu=$CantidadCu+$Fila[acuerdo_cu];
				$ValorCobre=$CantidadCu;
				
				$Consulta="select t2.acuerdo_ag from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_ag='2' and t2.vigente='1'";
				$Resp=mysqli_query($link, $Consulta);$CantidadAg=0;
				while($Fila=mysql_fetch_array($Resp))
						$CantidadAg=$CantidadAg+$Fila[acuerdo_ag];
				$ValorPLata=$CantidadAg;
				
				$Consulta="select t2.acuerdo_au from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Corr."' and tipo_au='2' and t2.vigente='1'";
				$Resp=mysqli_query($link, $Consulta);$CantidadAu=0;
				while($Fila=mysql_fetch_array($Resp))
						$CantidadAu=$CantidadAu+$Fila[acuerdo_au];
				$ValorOro=$CantidadAu;
			}
		}
		if($Fila[acuerdo_contractual]!='P')
		{
			if($Fila[tipo_cobertura]==1||$Fila[tipo_cobertura]==2)//CAMBIO QP
			{
				$MesSuma=$Fila[acuerdo_contractual]+$Mes;	
				if($MesSuma>12)
				{	
					$MesDeEntregaValor=$MesSuma-12;
					$AnoAux=$Ano+1;
				}
				if($MesSuma<=0)
				{
					$MesDeEntregaValor=12-$MesSuma;
					$AnoAux=$Ano-1;
				}
				if($MesSuma<12&&$MesSuma>0)
				{
					$MesDeEntregaValor=$Fila[acuerdo_contractual]+$Mes;		
					$AnoAux=$Ano; 
				}
				//CONSULTO EL VALOR CON EL QP INGRESADO
				$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValor."'";
				$Resp=mysqli_query($link, $Consulta);
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
		}
	}	
	if($ValorCobre!=0&&$ValorCobre!='')
	{
		echo "<td align='right'>".number_format($ValorCobre,3,',','.')."&nbsp;</td>";	
		$ArrPrecios2[1][Cu]=$ValorCobre;
	}
	else
		echo "<td align='center'>- - -</td>";		
	if($ValorPLata!=0&&$ValorPLata!='')
	{
		echo "<td align='right'>".number_format($ValorPLata,3,',','.')."&nbsp;</td>";	
		$ArrPrecios2[2][Ag]=$ValorPLata;
	}
	else
		echo "<td align='center'>- - -</td>";
	if($ValorOro!=0&&$ValorOro!='')
	{
		echo "<td align='right'>".number_format($ValorOro,3,',','.')."&nbsp;</td>";	
		$ArrPrecios2[3][Au]=$ValorOro;
	}
	else
		echo "<td align='center' $Clase>- - -</td>";
}
function ValorPreciosOperacionesAcuerdoQp($Corr,$Parci,$Ano,$Mes,$TipoEst,$ArrPrecios)
{
	for($s=1;$s<=3;$s++)
	{
		$ArrPrecios[1][Cu]=0;$ArrPrecios[2][Ag]=0;$ArrPrecios[3][Au]=0;
	}
	$Consulta="select corr,acuerdo_contractual,tipo_cobertura,acuerdo_contractual_qp_cu,acuerdo_contractual_qp_ag,acuerdo_contractual_qp_au,precio_fijo_cu,precio_fijo_ag,precio_fijo_au,estado from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		$MesSumaCu=$Fila[acuerdo_contractual_qp_cu]+$Mes;
		if($MesSumaCu>12)
		{	
			$MesDeEntregaValorCu=$MesSumaCu-12;
			$AnoAux=$Ano+1;
		}
		if($MesSumaCu<=0)
		{
			$MesDeEntregaValorCu=12-$MesSumaCu;
			$AnoAux=$Ano-1;
		}
		if($MesSumaCu<12&&$MesSumaCu>0)
		{
			$MesDeEntregaValorCu=$Fila[acuerdo_contractual_qp_cu]+$Mes;		
			$AnoAux=$Ano;
		}		
		$MesSumaAg=$Fila[acuerdo_contractual_qp_ag]+$Mes;
		if($MesSumaAg>12)
		{	
			$MesDeEntregaValorAg=$MesSumaAg-12;
			$AnoAux=$Ano+1;
		}
		if($MesSumaAg<=0)
		{
			$MesDeEntregaValorAg=12-$MesSumaAg;
			$AnoAux=$Ano-1;
		}
		if($MesSumaAg<12&&$MesSumaAg>0)
		{
			$MesDeEntregaValorAg=$Fila[acuerdo_contractual_qp_ag]+$Mes;		
			$AnoAux=$Ano;
		}		
		
		$MesSumaAu=$Fila[acuerdo_contractual_qp_au]+$Mes;
		if($MesSumaAu>12)
		{	
			$MesDeEntregaValorAu=$MesSumaAu-12;
			$AnoAux=$Ano+1;
		}
		if($MesSumaAu<=0)
		{
			$MesDeEntregaValorAu=12-$MesSumaAu;
			$AnoAux=$Ano-1;
		}
		if($MesSumaAu<12&&$MesSumaAu>0)
		{
			$MesDeEntregaValorAu=$Fila[acuerdo_contractual_qp_au]+$Mes;		
			$AnoAux=$Ano;
		}		
		if($Fila[acuerdo_contractual]=='P'||$Fila[acuerdo_contractual]!='P')
		{
			if($Fila[tipo_cobertura]==1)//CAMBIO QP
			{		
				//CONSULTO EL VALOR CON EL QP INGRESADO
				$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorCu."' and cod_ley='1'";
				$Resp=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorCobre=$Fila["valor"];
				else
					$ValorCobre=0;
				$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorAg."' and cod_ley='2'";
				//echo $Consulta."<br>";
				$Resp=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorPLata=$Fila["valor"];
				else
					$ValorPLata=0;	
				$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorAu."' and cod_ley='3'";
				$Resp=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resp))
					$ValorOro=$Fila["valor"];
				else
					$ValorOro=0;	
			}	
			if($Fila[tipo_cobertura]==2)//PRECIO FIJO
			{
				$ValorCobre=$Fila[precio_fijo_cu];
				$ValorPLata=$Fila[precio_fijo_ag];
				$ValorOro=$Fila[precio_fijo_au];
			}
		}
	}	
	if($ValorCobre!=0&&$ValorCobre!='')
	{
		echo "<td align='right'>".number_format($ValorCobre,3,',','.')."&nbsp;</td>";	
		$ArrPrecios[1][Cu]=$ValorCobre;
	}
	else
		echo "<td align='center'>- - -</td>";
	if($ValorPLata!=0&&$ValorPLata!='')
	{
		echo "<td align='right'>".number_format($ValorPLata,3,',','.')."&nbsp;</td>";	
		$ArrPrecios[2][Ag]=$ValorPLata;
	}
	else
		echo "<td align='center'>- - -</td>";
	if($ValorOro!=0&&$ValorOro!='')
	{
		echo "<td align='right'>".number_format($ValorOro,3,',','.')."&nbsp;</td>";	
		$ArrPrecios[3][Au]=$ValorOro;
	}
	else
		echo "<td align='center'>- - -</td>";
}
?>

