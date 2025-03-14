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
<title>Proceso Carry Cost</title>
<body>
<form name="FrmPrincipal" method="post" action="">
<table width="100%" border="1" cellpadding="4" cellspacing="0" >
  <?
			$arreglo=array();
			$Datos = explode("~",$TipoEst);
			$x=0;
			foreach($Datos as $clave => $Codigo)
			{
				$arreglo[$x][0]=$Codigo;
				$x=$x+1; 
			}	
			for($i=0;$i<=$x;$i++)
			{
				if('Cu'==$arreglo[$i][0])
				{
					$Cu=1;$Colspan=1;	
				}
				if('Ag'==$arreglo[$i][0])
				{
					$Ag=2;$Colspan=$Colspan+1;	
				}
				if('Au'==$arreglo[$i][0])
				{
					$Au=3;$Colspan=$Colspan+1;	
				}
			}
			$Buscar='S';
		 if($Buscar=='S')
		 {
		 ?>
  <tr align="center" class="TituloTablaVerde">
    <td width="6%" rowspan="2">A&ntilde;o/Mes</td>
    <td width="10%" colspan="<? echo $Colspan;?>">Inventario</td>
    <td width="10%" colspan="<? echo $Colspan;?>">Carry Cost </td>
    <td width="10%" colspan="<? echo $Colspan;?>">Precio Compra </td>
    <td width="10%" colspan="<? echo $Colspan;?>">Precio Venta </td>
    <td width="10%" colspan="<? echo $Colspan;?>">Carry Cost </td>
    <td width="11%" colspan="<? echo $Colspan;?>">Resultado</td>
    <td width="11%" rowspan="2">Tipo Cobert.</td>
  </tr>
  <tr align="center" class='TituloTablaVerde' >
    <? 
				for($i=0;$i<=5;$i++)
				{
					if($i==0)
					{
						$Cobre="[LB]";$Plata="[OZ]";$Oro="[OZ]";
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
						if($Cu==1)
							 echo "<td>Cobre ".$Cobre."</td>";
						if($Ag==2)
							 echo "<td>PLata ".$Plata."</td>";
						if($Au==3)
							 echo "<td>Oro ".$Oro."</td>";
					}
					if($i==2||$i==3)
					{
						if($Cu==1)
							 echo "<td>Cobre ".$Cobre."</td>";
						if($Ag==2)
							 echo "<td>PLata ".$Plata."</td>";
						if($Au==3)
							 echo "<td>Oro ".$Oro."</td>";
					}
				}
				?>
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
				$arreglo=array();
				$Datos = explode("~",$TipoEst);
				$x=0;
				foreach($Datos as $clave => $Codigo)
				{
					$arreglo[$x][0]=$Codigo;
					$x=$x+1; 
				}	
				for($i=0;$i<=$x;$i++)
				{
					if('Cu'==$arreglo[$i][0])
						$Datos1=$Datos1."'1',";
					if('Ag'==$arreglo[$i][0])
						$Datos1=$Datos1."'2',";
					if('Au'==$arreglo[$i][0])
						$Datos1=$Datos1."'3',";
				}
				if($Datos1!='')
					$Datos1=substr($Datos1,0,strlen($Datos1)-1);
				$In="(".$Datos1.")";
				$Consulta="select t1.corr,t1.parcializacion,t1.ano,t1.mes,t1.acuerdo_contractual,t1.tipo_cobertura,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
				$Consulta.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato inner join scop_carry_cost_proceso t4 on t1.corr=t4.corr and  t1.parcializacion=t4.parcializacion and t4.cod_ley in $In and t4.cod_tipo_titulo='1'";
				$Consulta.=" where ano='".$Ano."' and acuerdo_contractual='".$CmbAcuerdo."' and t3.vigente='1' group by corr,parcializacion order by ano,mes";				
				$Resp = mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{		
					$Correlativo=$Fila["corr"];
					$Parcializacion=$Fila[parcializacion];
					$ConsultaRows="select distinct t1.corr,t1.parcializacion,t1.ano,t1.mes,t1.tipo_cobertura,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
					$ConsultaRows.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato inner join scop_carry_cost_proceso t4 on t1.corr=t4.corr and  t1.parcializacion=t4.parcializacion and t4.cod_ley in $In and t4.cod_tipo_titulo='1'";
					$ConsultaRows.=" where t1.ano='".$Ano."' and t1.acuerdo_contractual='".$CmbAcuerdo."' and t1.corr='".$Fila["corr"]."' and t3.vigente='1' group by corr,parcializacion";				
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
					if($NomTxtCCost!='')
						$NomTxtCCost=substr($NomTxtCCost,0,strlen($NomTxtCCost)-2);
					if($Abrircandado!='')
						$Abrircandado=substr($Abrircandado,0,strlen($Abrircandado)-2);
					if($Guardar!='')
						$Guardar=substr($Guardar,0,strlen($Guardar)-2);
						
					$Consulta1="select distinct t1.corr,t1.ano,t1.mes,t2.cod_contratos,t3.cod_tipo_contr from scop_carry_cost t1 inner join scop_carry_cost_por_contratos t2 on t1.corr=t2.corr";
					$Consulta1.=" inner join scop_contratos t3 on t2.cod_contratos=t3.cod_contrato inner join scop_carry_cost_proceso t4 on t1.corr=t4.corr and  t1.parcializacion=t4.parcializacion and t4.cod_ley in $In and t4.cod_tipo_titulo='1'";
					$Consulta1.=" where t1.corr='".$Fila["corr"]."' and t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."' and t1.parcializacion='".$Fila[parcializacion]."' and acuerdo_contractual='".$CmbAcuerdo."' and t3.vigente='1'";				
					//echo $Consulta1."<br>";
					$Resp1 = mysql_query($Consulta1);$Contratos='';
					while($Fila1=mysql_fetch_array($Resp1))
						$Contratos=$Contratos.$Fila1[cod_contratos]."~";
						
					if($Contratos!='')
						$Contratos=substr($Contratos,0,strlen($Contratos)-1);	
					echo "<input type='hidden' name='Contratos' value=".$Contratos.">";
					echo "<tr bgcolor='#FFFFFF'>";
					if($Parcializacion==1)						
					{
						$Datos=$Fila["ano"]."~".$Fila["mes"]."~".$Fila[acuerdo_contractual];
						echo "<td rowspan=".$Rowspan.">".substr($Fila["ano"],2)."/".substr($Meses[$Fila["mes"]-1],0,3)."</td>";
						echo "<input type='hidden' name='Mes' value=".$Fila["mes"].">";
					}
					for($k=0;$k<=5;$k++)
					{
						if($k==0)
							ValoresInventarioValidado($Fila["corr"],$Fila["ano"],$Fila["mes"],$Parcializacion,$CmbAcuerdo,$TipoEst,&$ArrInventario);
						if($k==1)
							ValoresCarryCost($Fila["corr"],$Parcializacion,$Fila["ano"],$Fila["mes"],$CmbAcuerdo,$TipoEst,&$ArrCarry);
						if($k==2)//compra
							ValorPreciosOperacionesAcuerdoQp($Fila["corr"],$Parcializacion,$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios);	
						if($k==3)//Venta
							ValorPreciosOperacionesAcuerdo($Fila["corr"],$Parcializacion,$CmbAcuerdo,$Fila["ano"],$Fila["mes"],$TipoEst,&$ArrPrecios2);	
						if($k==4)//Calculo de VALORES CARRY COST DE LA GRILLA
						{
							for($i=0;$i<=$x;$i++)
							{
								reset($ArrPrecios);reset($ArrInventario);reset($ArrCarry);								
								if('Cu'==$arreglo[$i][0])
								{
									if($ArrPrecios[1][Cu]!='0')
									{
										$CarryCostTotalCu=($ArrInventario[1][Cu]*$ArrCarry[1][Cu])/100;							
										echo "<td align='right' $Clase>".number_format($CarryCostTotalCu,2,',','.')."</td>";
										$CarryCostTotalCu=0;	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,2,',','.')."</td>";
								}
								if('Ag'==$arreglo[$i][0])
								{
									if($ArrPrecios[2][Ag]!='0')
									{
										$CarryCostTotalAg=$ArrInventario[2][Ag]*$ArrCarry[2][Ag]/100;
										echo "<td align='right' $Clase>".number_format($CarryCostTotalAg,2,',','.')."</td>";
										$CarryCostTotalAg=0;	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,2,',','.')."</td>";
								}
								if('Au'==$arreglo[$i][0])
								{
									if($ArrPrecios[3][Au]!='0')
									{
										$CarryCostTotalAu=$ArrInventario[3][Au]*$ArrCarry[3][Au];
										echo "<td align='right' $Clase>".number_format($CarryCostTotalAu,2,',','.')."</td>";
										$CarryCostTotalAu=0;	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,2,',','.')."</td>";
								}
							}						
						}	
						if($k==5)// CALCULO DE LOS VALORES DEL RESULTADO DE LA GRILLAA
						{
							for($i=0;$i<=$x;$i++)
							{
								reset($ArrPrecios);reset($ArrPrecios2);	reset($ArrInventario);reset($ArrCarry);	
								if('Cu'==$arreglo[$i][0])
								{
									if($ArrPrecios[1][Cu]!='0')
									{ 	$Marcados=$Marcados+1;
										$CarryCostTotalCu=($ArrInventario[1][Cu]*$ArrCarry[1][Cu])/100;	
										$ResultadoPrecioCVCobre=$ArrPrecios2[1][Cu]-$ArrPrecios[1][Cu];										
										$ResultadoCu=($ArrInventario[1][Cu]*($ResultadoPrecioCVCobre)/100)+$CarryCostTotalCu;
										if($ResultadoCu!=0)
										{
											$Existe=$Existe+1;
											echo "<td align='right' $Clase>".number_format($ResultadoCu,2,',','.')."</td>";	
										}
										else
											echo "<td align='right' $Clase>- - -</td>";	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,0,',','.')."</td>";
								}
								if('Ag'==$arreglo[$i][0])
								{	$Marcados=$Marcados+1;
									if($ArrPrecios[2][Ag]!='0')
									{
										$CarryCostTotalAg=$ArrInventario[2][Ag]*$ArrCarry[2][Ag]/100;
										$ResultadoPrecioCVPlata=$ArrPrecios2[2][Ag]-$ArrPrecios[2][Ag];										
										$ResultadoAg=($ArrInventario[2][Ag]*$ResultadoPrecioCVPlata)+$CarryCostTotalAg;
										if($ResultadoAg!=0)
										{	$Existe=$Existe+1;
											echo "<td align='right' $Clase>".number_format($ResultadoAg,2,',','.')."</td>";	
										}
										else
											echo "<td align='right' $Clase>- - -</td>";	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,0,',','.')."</td>";
								}
								if('Au'==$arreglo[$i][0])
								{	$Marcados=$Marcados+1;
									if($ArrPrecios[3][Au]!='0')
									{
										$CarryCostTotalAu=$ArrInventario[3][Au]*$ArrCarry[3][Au];
										$ResultadoPrecioCVOro=$ArrPrecios2[3][Au]-$ArrPrecios[3][Au];	
										$ResultadoAu=($ArrInventario[3][Au]*$ResultadoPrecioCVOro)+$CarryCostTotalAu;
										if($ResultadoAu!=0)
										{	
											$Existe=$Existe+1;
											echo "<td align='right' $Clase>".number_format($ResultadoAu,2,',','.')."</td>";	
										}
										else
											echo "<td align='right' $Clase>- - -</td>";	
									}
									else
										echo "<td align='right' $Clase>".number_format(0,0,',','.')."</td>";	
								}
							}																																					
						}	
					}
					
					//SABER QUE ESTADO TIENE EL CARRY COST SI ES CANDADO O GUARDAR NUEVO CARRY
					for($i=0;$i<=$x;$i++)
					{
						if('Cu'==$arreglo[$i][0])
							$Datos=1;
						if('Ag'==$arreglo[$i][0])
							$Datos=2;
						if('Au'==$arreglo[$i][0])
							$Datos=3;
					}					
					$ConsultaExValor="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_ley in $In and cod_tipo_titulo='1'";
					$RespExValor = mysql_query($ConsultaExValor);$DatosExValor='';
					while($FilaExValor=mysql_fetch_array($RespExValor))
					{
						if($FilaExValor["cod_ley"]==1)
							$DatosExValor=$DatosExValor."Cu~";
						if($FilaExValor["cod_ley"]==2)
							$DatosExValor=$DatosExValor."Ag~";
						if($FilaExValor["cod_ley"]==3)
							$DatosExValor=$DatosExValor."Au~";
					}
					$ConsultaCarry="select distinct t1.acuerdo_contractual,t1.corr,t1.precio_fijo_cu,t1.precio_fijo_ag,t1.precio_fijo_au,t1.estado,t2.cod_subclase,t2.nombre_subclase as nom_cobertura,t1.tipo_cobertura,t1.parcializacion from scop_carry_cost t1 ";
					$ConsultaCarry.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33005' and t1.tipo_cobertura=t2.cod_subclase";
					$ConsultaCarry.=" inner join scop_carry_cost_proceso t3 on t1.corr=t3.corr and  t1.parcializacion=t3.parcializacion and t3.cod_ley in $In and t3.cod_tipo_titulo='1'";
					$ConsultaCarry.=" where t1.corr='".$Fila["corr"]."' and t1.parcializacion='".$Fila[parcializacion]."' and  t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."'";
					//echo $ConsultaCarry."<br>";
					$RespCarry=mysql_query($ConsultaCarry);
					if ($FilaCarry=mysql_fetch_array($RespCarry))
					{
						echo "<input type='hidden' name='CmbTipoCobertura' value='".$FilaCarry[tipo_cobertura]."'>";						
						if($FilaCarry[acuerdo_contractual]=='P'||$FilaCarry[acuerdo_contractual]!='P')
						{
							if($FilaCarry[tipo_cobertura]=='1')//para ver si es QP o Precio Fijo
							{
								$ConsultaQp="select t1.* from scop_carry_cost t1 where t1.corr='".$Fila["corr"]."' and t1.parcializacion='".$Fila[parcializacion]."' and  t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."'";
								$RespQp=mysql_query($ConsultaQp);$QP='';
								while($FilaQp=mysql_fetch_array($RespQp))
								{
									for($i=0;$i<=$x;$i++)
									{
										if($FilaQp[acuerdo_contractual_qp_cu]=='-1'||$FilaQp[acuerdo_contractual_qp_ag]=='-1'||$FilaQp[acuerdo_contractual_qp_au]=='-1')
											$Mes='Mes&nbsp;';
										else
											$Mes='Mes&nbsp;+';	
										if('Cu'==$arreglo[$i][0])
											$QP="Cu&nbsp;".$Mes.$FilaQp[acuerdo_contractual_qp_cu]."&nbsp;,";						
										if('Ag'==$arreglo[$i][0])
											$QP=$QP."Ag&nbsp;".$Mes.$FilaQp[acuerdo_contractual_qp_ag]."&nbsp;,";
										if('Au'==$arreglo[$i][0])
											$QP=$QP."Au&nbsp;".$Mes.$FilaQp[acuerdo_contractual_qp_au]."&nbsp;,";
									}					
								}					
								if($QP!='')
									$QP=substr($QP,0,strlen($QP)-1);								
								echo "<td align='center'>".$FilaCarry[nom_cobertura]."&nbsp;".$QP."</td>";
							}	
							if($FilaCarry[tipo_cobertura]=='2')//Precio Fijo
							{
								$ConsultaQp="select t1.* from scop_carry_cost t1 where t1.corr='".$Fila["corr"]."' and t1.parcializacion='".$Fila[parcializacion]."' and  t1.ano='".$Fila["ano"]."' and t1.mes='".$Fila["mes"]."'";
								$RespQp=mysql_query($ConsultaQp);$QP='';
								while($FilaQp=mysql_fetch_array($RespQp))
								{
									for($i=0;$i<=$x;$i++)
									{
										if('Cu'==$arreglo[$i][0])
											$QP="Cu&nbsp;".$FilaQp[precio_fijo_cu]."&nbsp;,";						
										if('Ag'==$arreglo[$i][0])
											$QP=$QP."Ag&nbsp;".$FilaQp[precio_fijo_ag]."&nbsp;,";
										if('Au'==$arreglo[$i][0])
											$QP=$QP."Au&nbsp;".$FilaQp[precio_fijo_au]."&nbsp;,";
									}	
								}	
								if($QP!='')
									$QP=substr($QP,0,strlen($QP)-1);								
								echo "<td align='center'>".$FilaCarry[nom_cobertura]."&nbsp;".$QP."</td>";
							}
						}
					}	
					else
							echo "<td align='center' rowspan='".$Rowspan."' colspan='2'>&nbsp;</td>";
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
?>
<?
	if($Buscar=='S')
   {
?>
	<script type="text/javascript">
	select_customer('');
	</script>
<? 
}

function ValoresInventarioValidado($Corr,$Ano,$Mes,$Parci,$Acuerdo,$TipoEst,$ArrInventario)
{
		$arreglo=array();
		$Datos = explode("~",$TipoEst);
		$x=0;
		foreach($Datos as $clave => $Codigo)
		{
			$arreglo[$x][0]=$Codigo;
			$x=$x+1; 
		}	
	for($i=0;$i<=$x;$i++)
	{
		if('Cu'==$arreglo[$i][0])
			$Datos1=$Datos1."'1',";
		if('Ag'==$arreglo[$i][0])
			$Datos1=$Datos1."'2',";
		if('Au'==$arreglo[$i][0])
			$Datos1=$Datos1."'3',";
	}
	if($Datos1!='')
		$Datos1=substr($Datos1,0,strlen($Datos1)-1);
	$In="(".$Datos1.")";
	$Parcializar=$Corr."~".$Parci."~".$Ano."~".$Mes;
	$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";	
	$Resp = mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila["estado"]=='2')
			$Datos='S';
		else	
			$Datos='N';
		$Consulta="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_ley in $In and cod_tipo_titulo='1'";
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
		for($i=0;$i<=$x;$i++)
		{
			if('Cu'==$arreglo[$i][0])
			{	
				echo "<td align='right'>".number_format($ValorCobre,2,',','.')."</td>";
				$ArrInventario[1][Cu]=$ValorCobre;
			}
			if('Ag'==$arreglo[$i][0])
			{	
				echo "<td align='right'>".number_format($ValorPLata,2,',','.')."</td>";
				$ArrInventario[2][Ag]=$ValorPLata;
			}
			if('Au'==$arreglo[$i][0])
			{			
				echo "<td align='right'>".number_format($ValorOro,2,',','.')."</td>";
				$ArrInventario[3][Au]=$ValorOro;
			}
		}
	}
}
function ValoresCarryCost($Corr,$Parci,$Ano,$Mes,$Acuerdo,$TipoEst,$ArrCarry)
{
	$arreglo=array();
	$Datos = explode("~",$TipoEst);
	$x=0;
	foreach($Datos as $clave => $Codigo)
	{
		$arreglo[$x][0]=$Codigo;
		$x=$x+1; 
	}
	$Datos='';	
	for($i=0;$i<=$x;$i++)
	{
		if('Cu'==$arreglo[$i][0])
			$Datos=$Datos."'1',";
		if('Ag'==$arreglo[$i][0])
			$Datos=$Datos."'2',";
		if('Au'==$arreglo[$i][0])
			$Datos=$Datos."'3',";
	}
	if($Datos!='')
		$Datos=substr($Datos,0,strlen($Datos)-1);
	$In="(".$Datos.")";
	for($s=1;$s<=3;$s++)
	{
		$ArrCarry[1][Cu]=0;$ArrCarry[2][Ag]=0;$ArrCarry[3][Au]=0;
	}
	for($i=0;$i<=$x;$i++)
	{
		if('Cu'==$arreglo[$i][0])
		{
			$Datos=1;
			$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{				
				$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='1' and cod_ley='".$Datos."'";
				$RespPro=mysql_query($ConsultaPro);
				if($FilaPro=mysql_fetch_array($RespPro))
				{
					$NomTxt="Cu_".$Fila["corr"]."_".$Fila[parcializacion];
					$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='2' and cod_ley='".$Datos."'";
					$RespPro=mysql_query($ConsultaPro);
					if($FilaPro=mysql_fetch_array($RespPro))
					{
						$Cod=$FilaPro["corr"]."~".$FilaPro[parcializacion]."~".$FilaPro["cod_ley"];
						if($Fila["estado"]=='3')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							$ArrCarry[1][Cu]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='4'||$Fila["estado"]=='5'||$Fila["estado"]=='6')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							$ArrCarry[1][Cu]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='1'||$Fila["estado"]=='2')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."</td>";
						}
					}
					else
					{
						if($Fila["estado"]==2)
						{
							echo "<input type='hidden' name='EstadoCu' value='1'>";echo "<input type='hidden' name='Estado' value='1'>";
							echo "<td align='right'>&nbsp;</td>";
						}
						else
							echo "<td align='right'>&nbsp;</td>";
					}
				}
				else
					echo "<td align='right'>&nbsp;</td>";
			}
		}
		if('Ag'==$arreglo[$i][0])
		{
			$Datos=2;
			$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{				
				$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='1' and cod_ley='".$Datos."'";
				$RespPro=mysql_query($ConsultaPro);
				if($FilaPro=mysql_fetch_array($RespPro))
				{
					$NomTxt="Ag_".$Fila["corr"]."_".$Fila[parcializacion];
					$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='2' and cod_ley='".$Datos."'";
					$RespPro=mysql_query($ConsultaPro);
					if($FilaPro=mysql_fetch_array($RespPro))
					{
						$Cod=$FilaPro["corr"]."~".$FilaPro[parcializacion]."~".$FilaPro["cod_ley"];
						if($Fila["estado"]=='3')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							$ArrCarry[2][Ag]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='4'||$Fila["estado"]=='5'||$Fila["estado"]=='6')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							$ArrCarry[2][Ag]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='1'||$Fila["estado"]=='2')
						{
							echo "<input type='hidden' name='EstadoCu' value='2'>";
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."</td>";
						}
					}
					else
					{
						if($Fila["estado"]==2)
						{
							echo "<input type='hidden' name='EstadoCu' value='1'>";echo "<input type='hidden' name='Estado' value='1'>";
							echo "<td align='right'>&nbsp;</td>";
						}
						else
							echo "<td align='right'>&nbsp;</td>";
					}
				}
				else
					echo "<td align='right'>&nbsp;</td>";
			}
		}			
		if('Au'==$arreglo[$i][0])
		{
			$Datos=3;
			$Consulta="select * from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{				
				$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='1' and cod_ley='".$Datos."'";
				$RespPro=mysql_query($ConsultaPro);
				if($FilaPro=mysql_fetch_array($RespPro))
				{
					$NomTxt="Au_".$Fila["corr"]."_".$Fila[parcializacion];
					$ConsultaPro="select * from scop_carry_cost_proceso where corr='".$Fila["corr"]."' and parcializacion='".$Fila[parcializacion]."' and cod_tipo_titulo='2' and cod_ley='".$Datos."'";
					$RespPro=mysql_query($ConsultaPro);
					if($FilaPro=mysql_fetch_array($RespPro))
					{
						$Cod=$FilaPro["corr"]."~".$FilaPro[parcializacion]."~".$FilaPro["cod_ley"];
						if($Fila["estado"]=='3')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							$ArrCarry[3][Au]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='4'||$Fila["estado"]=='5'||$Fila["estado"]=='6')
						{
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."&nbsp;";
							$ArrCarry[3][Au]=$FilaPro["valor"];
						}
						if($Fila["estado"]=='1'||$Fila["estado"]=='2')
						{
							echo "<input type='hidden' name='EstadoCu' value='2'>";
							echo "<td align='right'>".number_format($FilaPro["valor"],3,',','.')."</td>";
						}
					}
					else
					{
						if($Fila["estado"]==2)
						{
							echo "<input type='hidden' name='EstadoCu' value='1'>";echo "<input type='hidden' name='Estado' value='1'>";
							echo "<td align='right'>&nbsp;</td>";
						}
						else
							echo "<td align='right'>&nbsp;</td>";
					}
				}
				else
					echo "<td align='right'>&nbsp;</td>";
			}
		}	
	}		
}
function ValorPreciosOperacionesAcuerdo($Corr,$Parci,$CmbAcuerdo,$Ano,$Mes,$TipoEst,$ArrPrecios2)
{
	$arreglo=array();
	$Datos = explode("~",$TipoEst);
	$x=0;
	foreach($Datos as $clave => $Codigo)
	{
		$arreglo[$x][0]=$Codigo;
		$x=$x+1; 
	}
	$Consulta="select corr,acuerdo_contractual,tipo_precio,tipo_cobertura,acuerdo_contractual_qp_cu,acuerdo_contractual_qp_ag,acuerdo_contractual_qp_au,precio_fijo_cu,precio_fijo_ag,precio_fijo_au from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila[acuerdo_contractual]=='P')
		{
			if($Fila[tipo_cobertura]==1||$Fila[tipo_cobertura]==2)//PRECIO FIJO
			{
				for($i=0;$i<=$x;$i++)
				{
					if('Cu'==$arreglo[$i][0])
					{
						$Consulta="select t2.cod_contrato,t2.acuerdo_cu from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Fila["corr"]."' and tipo_cu='2'";
						$Resp=mysqli_query($link, $Consulta);$CantidadCu=0;
						while($Fila=mysql_fetch_array($Resp))
								$CantidadCu=$CantidadCu+$Fila[acuerdo_cu];
						echo "<td align='right'>".number_format($CantidadCu,3,',','.')."&nbsp;</td>";	
						$ArrPrecios2[1][Cu]=$CantidadCu;
					}
					if('Ag'==$arreglo[$i][0])
					{
						$Consulta="select t2.acuerdo_ag from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Fila["corr"]."' and tipo_ag='2'";
						$Resp=mysqli_query($link, $Consulta);$CantidadAg=0;
						while($Fila=mysql_fetch_array($Resp))
								$CantidadAg=$CantidadAg+$Fila[acuerdo_cu];
						echo "<td align='right'>".number_format($CantidadAg,3,',','.')."&nbsp;</td>";	
						$ArrPrecios2[2][Ag]=$CantidadAg;
					}
					if('Au'==$arreglo[$i][0])
					{
						$Consulta="select t2.acuerdo_au from scop_carry_cost_por_contratos t1 inner join scop_contratos t2 on t1.cod_contratos=t2.cod_contrato where corr='".$Fila["corr"]."' and tipo_au='2'";
						$Resp=mysqli_query($link, $Consulta);$CantidadAu=0;
						while($Fila=mysql_fetch_array($Resp))
								$CantidadAu=$CantidadAu+$Fila[acuerdo_cu];
						echo "<td align='right'>".number_format($CantidadAu,3,',','.')."&nbsp;</td>";	
						$ArrPrecios2[3][Ag]=$CantidadAu;
					}
				}			
			}
		}
		if($Fila[acuerdo_contractual]!='P')
		{
			if($Fila[tipo_cobertura]==1||$Fila[tipo_cobertura]==2)//CAMBIO QP
			{
				$MesSuma=$CmbAcuerdo+$Mes;		
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
					$MesDeEntregaValor=$CmbAcuerdo+$Mes;		
					$AnoAux=$Ano; 
				}
				for($i=0;$i<=$x;$i++)
				{
					if('Cu'==$arreglo[$i][0])
					{
						$Ley=1;
						//CONSULTO EL VALOR CON EL QP INGRESADO
						$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValor."' and cod_ley='".$Ley."'";
						$Resp=mysqli_query($link, $Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."&nbsp;</td>";	
							$ArrPrecios2[1][Cu]=$Fila["valor"];

						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
					if('Ag'==$arreglo[$i][0])
					{
						$Ley=2;
						$Consulta="select * from scop_precios_metales where ano='".$Ano."' and mes='".$MesDeEntregaValor."' and cod_ley='".$Ley."'";
						//echo $Consulta."<br>";
						$Resp=mysqli_query($link, $Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."&nbsp;</td>";	
							$ArrPrecios2[2][Ag]=$Fila["valor"];
						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
					if('Au'==$arreglo[$i][0])
					{
						$Ley=3;
						$Consulta="select * from scop_precios_metales where ano='".$Ano."' and mes='".$MesDeEntregaValor."' and cod_ley='".$Ley."'";
						//echo $Consulta."<br>";
						$Resp=mysqli_query($link, $Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."&nbsp;</td>";	
							$ArrPrecios2[3][Au]=$Fila["valor"];
						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
				}	
			}		
		}
	}	
}
function ValorPreciosOperacionesAcuerdoQp($Corr,$Parci,$Ano,$Mes,$TipoEst,$ArrPrecios)
{
	$arreglo=array();
	$Datos = explode("~",$TipoEst);
	$x=0;
	foreach($Datos as $clave => $Codigo)
	{
		$arreglo[$x][0]=$Codigo;
		$x=$x+1; 
	}
	$Consulta="select acuerdo_contractual,tipo_precio,tipo_cobertura,acuerdo_contractual_qp_cu,acuerdo_contractual_qp_ag,acuerdo_contractual_qp_au,precio_fijo_cu,precio_fijo_ag,precio_fijo_au from scop_carry_cost where corr='".$Corr."' and parcializacion='".$Parci."' and ano='".$Ano."' and mes='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);$MesDeEntregaValor=0;
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
				for($i=0;$i<=$x;$i++)
				{
					if('Cu'==$arreglo[$i][0])
					{
						$Ley=1;
						//CONSULTO EL VALOR CON EL QP INGRESADO
						$Consulta="select * from scop_precios_metales where ano='".$AnoAux."' and mes='".$MesDeEntregaValorCu."' and cod_ley='".$Ley."'";
						$Resp=mysqli_query($link, $Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."&nbsp;</td>";	
							$ArrPrecios[1][Cu]=$Fila["valor"];
						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
					if('Ag'==$arreglo[$i][0])
					{
						$Ley=2;
						$Consulta="select * from scop_precios_metales where ano='".$Ano."' and mes='".$MesDeEntregaValorAg."' and cod_ley='".$Ley."'";
						//echo $Consulta."<br>";
						$Resp=mysqli_query($link, $Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."&nbsp;</td>";	
							$ArrPrecios[2][Ag]=$Fila["valor"];
						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
					if('Au'==$arreglo[$i][0])
					{
						$Ley=3;
						$Consulta="select * from scop_precios_metales where ano='".$Ano."' and mes='".$MesDeEntregaValorAu."' and cod_ley='".$Ley."'";
						$Resp=mysqli_query($link, $Consulta);
						if($Fila=mysql_fetch_array($Resp))
						{
							echo "<td align='right'>".number_format($Fila["valor"],3,',','.')."&nbsp;</td>";	
							$ArrPrecios[3][Au]=$Fila["valor"];
						}
						else
							echo "<td align='right'>".number_format(0,2,',','.')."&nbsp;</td>";					
					}
				}	
			}	
			if($Fila[tipo_cobertura]==2)//PRECIO FIJO
			{
				for($i=0;$i<=$x;$i++)
				{
					if('Cu'==$arreglo[$i][0])
					{
						echo "<td align='right'>".number_format($Fila[precio_fijo_cu],3,',','.')."&nbsp;</td>";	
						$ArrPrecios[1][Cu]=$Fila[precio_fijo_cu];
					}
					if('Ag'==$arreglo[$i][0])
					{
						echo "<td align='right'>".number_format($Fila[precio_fijo_ag],3,',','.')."&nbsp;</td>";	
						$ArrPrecios[2][Ag]=$Fila[precio_fijo_ag];
					}
					if('Au'==$arreglo[$i][0])
					{
						echo "<td align='right'>".number_format($Fila[precio_fijo_au],3,',','.')."&nbsp;</td>";	
						$ArrPrecios[3][Au]=$Fila[precio_fijo_au];
					}
				}			
			}
		}
	}	
}
?>

