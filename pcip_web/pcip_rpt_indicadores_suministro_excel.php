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
<title>Reporte Indicadores</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td rowspan="2">&nbsp;&nbsp;MES CONSULTADO:&nbsp;<? echo strtoupper($Meses[$Mes-1]);?>&nbsp;</td>
      <td align="center"><? echo intval($Ano)-1;?></td>
      <td colspan="2" align="center" ><? echo $Ano;?></td>
    </tr>
    <tr>
      <td align="center" >REAL</td>
      <td align="center" >REAL </td>
      <td align="center" >PTTO</td>
    </tr>
    <?
		  if($Buscar=='S')
		  {
			switch($CmbGrupoSuministro)
			{
				case "2";//GRUPO ES COMBUSTIBLES
					$Unidad='MBTU';
				break;
				case "3";//GRUPO ES ENERGIA ELECTRICA
					$Unidad='Mwh';
				break;
				case "4";//GRUPO VAPOR
					$Unidad='Ton';
				break;
				default:
					$Sumi=explode('~',DatosSumistros($CmbSuministro));
					$Unidad=$Sumi[2];
				break;	
		  	}
			$ConsumoRealAnt=Consumo(intval($Ano)-1,$Mes,$CmbMostrar,$CmbGrupoSuministro,$CmbSuministro,'S');
			$ConsumoReal=Consumo($Ano,$Mes,$CmbMostrar,$CmbGrupoSuministro,$CmbSuministro,'S');
			$ConsumoPpto=Consumo($Ano,$Mes,$CmbMostrar,$CmbGrupoSuministro,$CmbSuministro,'P');
			$ProdCuElectRealAnt=ProdCobreElect(intval($Ano)-1,$Mes,$CmbMostrar);
			$ProdCuElectReal=ProdCobreElect($Ano,$Mes,$CmbMostrar);
			$ProdCuElectPpto=ProdCobreElectPpto($Ano,$Mes,$CmbMostrar);
			$CargaNURealAnt=CargaNuevaUtil(intval($Ano)-1,$Mes,$CmbMostrar,'R');
			$CargaNUReal=CargaNuevaUtil($Ano,$Mes,$CmbMostrar,'R');
			$CargaNURealPpto=CargaNuevaUtilPpto($Ano,$Mes,$CmbMostrar,'P');
		  	$ConsumoOxiRealAnt=Consumo(intval($Ano)-1,$Mes,$CmbMostrar,5,10,'S');
			$ConsumoOxiReal=Consumo($Ano,$Mes,$CmbMostrar,5,10,'S');
			$ConsumoOxiPpto=Consumo($Ano,$Mes,$CmbMostrar,5,10,'P');
		  	$ConsumoVaporTermRealAnt=Consumo(intval($Ano)-1,$Mes,$CmbMostrar,4,9,'S');
			$ConsumoVaporTermReal=Consumo($Ano,$Mes,$CmbMostrar,4,9,'S');
			$ConsumoVaporTermPpto=Consumo($Ano,$Mes,$CmbMostrar,4,9,'P');
			if($ProdCuElectRealAnt>0)
		  		$ConsumoTotRealAnt=$ConsumoRealAnt/$ProdCuElectRealAnt;
			else
				$ConsumoTotRealAnt=0;
			if($ProdCuElectReal>0)
				$ConsumoTotReal=$ConsumoReal/$ProdCuElectReal;
			else
				$ConsumoTotReal=0;	
			if($ProdCuElectPpto>0)
				$ConsumoTotPpto=$ConsumoPpto/$ProdCuElectPpto;
			else
				$ConsumoTotPpto=0;	
			
		  ?>
    <tr>
      <td >CONSUMO [<? echo $Unidad;?>/mes] </td>
      <td align="right"><? echo number_format($ConsumoRealAnt,0,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($ConsumoReal,0,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($ConsumoPpto,0,',','.');?>&nbsp;</td>
    </tr>
    <tr>
      <td >Prod. Cobre Elect (TMF) </td>
      <td align="right"><? echo number_format($ProdCuElectRealAnt,0,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($ProdCuElectReal,0,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($ProdCuElectPpto,0,',','.');?>&nbsp;</td>
    </tr>
    <tr>
      <td >Carga Nueva Util a Fundir (TMS)</td>
      <td align="right"><? echo number_format($CargaNURealAnt,0,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($CargaNUReal,0,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($CargaNURealPpto,0,',','.');?>&nbsp;</td>
    </tr>
    <tr>
      <td >Producci&oacute;n de Oxigeno (Ton) </td>
      <td align="right"><? echo number_format($ConsumoOxiRealAnt,0,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($ConsumoOxiReal,0,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($ConsumoOxiPpto,0,',','.');?>&nbsp;</td>
    </tr>
    <tr>
      <td >Producci&oacute;n de Vapor (Ton) </td>
      <td align="right"><? echo number_format($ConsumoVaporTermRealAnt,0,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($ConsumoVaporTermReal,0,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($ConsumoVaporTermPpto,0,',','.');?>&nbsp;</td>
    </tr>
    <tr>
      <td >Consumo Total <? echo $Unidad;?>/TmF Cu elect. </td>
      <td align="right"><? echo number_format($ConsumoTotRealAnt,3,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($ConsumoTotReal,3,',','.');?>&nbsp;</td>
      <td align="right"><? echo number_format($ConsumoTotPpto,3,',','.');?>&nbsp;</td>
    </tr>
    <?
		  $Consulta="select t1.cod_sistema,t1.cod_divisor,t2.descripcion from pcip_eec_sistemas_por_indicadores t1 inner join pcip_eec_sistemas t2 on t1.cod_sistema=t2.cod_sistema where t1.cod_indicador='".$CmbIndicador."'";
		  $Resp=mysql_query($Consulta);
		  //echo $Consulta;
		  while($Fila=mysql_fetch_array($Resp))
		  {
				$NomIndicador=$Fila["descripcion"];
				$ConsumoIndRealAnt=ConsumoIndicadores(intval($Ano)-1,$Mes,$CmbMostrar,$CmbGrupoSuministro,$CmbSuministro,'S',$Fila[cod_sistema],$Fila[cod_divisor]);
				$ConsumoIndReal=ConsumoIndicadores($Ano,$Mes,$CmbMostrar,$CmbGrupoSuministro,$CmbSuministro,'S',$Fila[cod_sistema],$Fila[cod_divisor]);
				$ConsumoIndPpto=ConsumoIndicadores($Ano,$Mes,$CmbMostrar,$CmbGrupoSuministro,$CmbSuministro,'P',$Fila[cod_sistema],$Fila[cod_divisor]);
				if($ProdCuElectRealAnt>0)
					$ValorIndicadorRealAnt=$ConsumoIndRealAnt/($ProdCuElectRealAnt*1000);
				else
					$ValorIndicadorRealAnt=$ConsumoIndRealAnt;
					
				if($ProdCuElectReal>0)	
					$ValorIndicadorReal=$ConsumoIndReal/($ProdCuElectReal*1000);
				else
					$ValorIndicadorReal=$ConsumoIndReal;
					
				if($ProdCuElectPpto>0)	
					$ValorIndicadorPPto=$ConsumoIndPpto/($ProdCuElectPpto*1000);
				else
					$ValorIndicadorPPto=$ConsumoIndPpto;	
			?>
    <tr>
				<td ><? echo $NomIndicador;?>&nbsp;[<? echo $Unidad;?>/Ton] / TMF</td>
				<td align="right"><? echo number_format($ValorIndicadorRealAnt,3,',','.');?>&nbsp;</td>
				<td align="right"><? echo number_format($ValorIndicadorReal,3,',','.');?>&nbsp;</td>
				<td align="right"><? echo number_format($ValorIndicadorPPto,3,',','.');?>&nbsp;</td>
    </tr>
    <?
			}
		  }
		  ?>
  </table>
</form>
</body>
</html>
<?
function Consumo($Ano,$Mes,$Mostrar,$GrupoSuministro,$Sumistro,$TipoSumi)
{
	$Consumo=0;
	$Consulta = "select t1.cod_suministro from pcip_eec_suministros_por_grupos t1 inner join pcip_eec_suministros t2 on t1.cod_suministro=t2.cod_suministro ";
	$Consulta.= "where t1.cod_suministro_grupo='".$GrupoSuministro."' ";
	if($Sumistro!='T')
		$Consulta.= " and t1.cod_suministro='".$Sumistro."'";			
	$RespSumi=mysql_query($Consulta);
	//echo $Consulta."<br>"; 
	while ($FilaSumi=mysql_fetch_array($RespSumi))
	{
		$Sumistro=$FilaSumi[cod_suministro];
		$Consulta = "select sum(valor) as cantidad from pcip_eec_suministros_detalle where tipo='".$TipoSumi."' and cod_suministro='".$Sumistro."' and ano='".$Ano."'";
		if($Mostrar=='M')
			$Consulta.= " and mes = ".($Mes)." group by tipo,cod_suministro,ano,mes";
		else
			$Consulta.= " and mes between 1 and ".($Mes)." group by tipo,cod_suministro,ano";
		//echo $Consulta."<br>";		
		$Resp=mysql_query($Consulta);
		if ($Fila=mysql_fetch_array($Resp))
		{
			//if($Sumistro!='10'&&$Sumistro!='8'&&$Sumistro!='9')
			//	$Consumo=$Fila[cantidad]/10000;
			//else
			switch($Sumistro)
			{
				case "1"://DIESEL
					$Consumo=$Consumo+($Fila[cantidad]*8670*0.000003986);
				break;
				case "2"://FUEL OIL
					$Consumo=$Consumo+($Fila[cantidad]*9550*0.000003986);
				break;
				case "3"://GAS NATURAL
					$Consumo=$Consumo+($Fila[cantidad]*9300*0.000003986);
				break;
				default:
					$Consumo=$Consumo+$Fila[cantidad];
				break;
			}
		}
	}
	return($Consumo);	
}
function ConsumoIndicadores($Ano,$Mes,$Mostrar,$GrupoSuministro,$Sumistro,$TipoSumi,$Sistema,$CodDivisor)
{
	$ConsumoAux=0;
	$Consulta = "select t1.cod_suministro from pcip_eec_suministros_por_grupos t1 inner join pcip_eec_suministros t2 on t1.cod_suministro=t2.cod_suministro ";
	$Consulta.= "where t1.cod_suministro_grupo='".$GrupoSuministro."' ";
	if($Sumistro!='T')
		$Consulta.= " and t1.cod_suministro='".$Sumistro."'";			
	$RespSumi=mysql_query($Consulta);
	//echo $Consulta."<br>"; 
	while ($FilaSumi=mysql_fetch_array($RespSumi))
	{
		$Sumistro=$FilaSumi[cod_suministro];
		$Consulta="select cod_cc from pcip_eec_centros_costos_por_sistema where cod_sistema='".$Sistema."'";
		//echo $Consulta."<br>";
		$RespRel=mysql_query($Consulta);$Consumo=0;
		while($FilaRel=mysql_fetch_array($RespRel))
		{
			$Consulta = "select valor as cantidad from pcip_eec_suministros_detalle where tipo='".$TipoSumi."' and cod_suministro='".$Sumistro."' and ano='".$Ano."' and cod_cc='".$FilaRel[cod_cc]."'";
			if($Mostrar=='M')
				$Consulta.= " and mes = ".($Mes)." group by tipo,cod_suministro,ano,mes";
			else
				$Consulta.= " and mes between 1 and ".($Mes)." group by tipo,cod_suministro,ano";
			//echo $Consulta."<br>";		
			$Resp=mysql_query($Consulta);
			if ($Fila=mysql_fetch_array($Resp))
			{
				$Consumo=$Consumo+$Fila[cantidad];
			}
		}
		//if($Consumo>0)
		//	$Consumo=$Consumo/1000;
		switch($CodDivisor)
		{
			case "1":
				$ConsumoAux=$ConsumoAux+ProdCobreElect($Ano,$Mes,$Mostrar);
				break;
			case "2":
				if($TipoSumi=='S')
					$Tipo2='R';
				else
					$Tipo2='P';	
				$ConsumoAux=$ConsumoAux+CargaNuevaUtil($Ano,$Mes,$Mostrar,$Tipo2);
				break;
			case "3":
			case "4":
			case "6":
				$Consulta="select valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='31011' and cod_subclase='".$CodDivisor."'";
				$Resp=mysql_query($Consulta);
				$Fila=mysql_fetch_array($Resp);
				$SumiDiv=$Fila["valor_subclase1"];
				$ConsumoAux=$ConsumoAux+Consumo($Ano,$Mes,$Mostrar,$GrupoSuministro,$SumiDiv,$TipoSumi);
				break;
			case "5":
				if($TipoSumi=='S')
					$ConsumoAux=$ConsumoAux+ObtieneAcidoSvp($Ano,$Mes,$Mostrar);
				else
					$ConsumoAux=$ConsumoAux+ObtieneAcidoSvpPpto($Ano,$Mes,$Mostrar);
				break;
		}
	}
	/*echo "Indicador:".$Sistema."<br>";
	echo "Consumo:".$Consumo."<br>";
	echo "Consumo Aux:".$ConsumoAux."<br><br>";*/
	$Transformacion=1;
	if($Sumistro=='4')//PARA ENERGIA ELECTRICA SE DIVIDE POR MIL PARA TRANSFORMAR de Kwh A Mwh
		$Transformacion=1000;
	if($ConsumoAux>0)
		$Consumo=$Consumo/($Transformacion*$ConsumoAux);
	//echo "Consumo DIVID:".$Consumo."<br><br>";
	return($Consumo);	
}

function ProdCobreElect($Ano,$Mes,$Mostrar)
{
	if($Mostrar=='M')
	{
		$MesIni=$Mes;
		$MesFin=$Mes;
	}
	else
	{
		$MesIni=1;
		$MesFin=$Mes;
	}

	//OBTIENE DATOS SVP
	$Consulta="select cod_producto from pcip_svp_asignaciones_productos ";
	$Consulta.=" where cod_asignacion='1' and mostrar_cu_elect='1' ";
	
	$RespProd=mysql_query($Consulta);
	while($FilaProd=mysql_fetch_array($RespProd))
	{
		$Consulta="select t2.origen,t2.num_orden,t2.num_orden_relacionada,t2.cod_material,t2.consumo_interno,t2.vptm from pcip_svp_negocios t1 ";
		$Consulta.="inner join pcip_svp_productos_procedencias t2 on t1.cod_negocio=t2.cod_negocio ";
		$Consulta.="where t2.cod_asignacion='1' and t1.vigente='1'";
		$Consulta.=" and t2.cod_procedencia='".$FilaProd["cod_producto"]."' and ano='".$Ano."' ";
		$Consulta.="order by t1.orden,t2.orden";
		//echo $Consulta."<br>";
		$Resp2=mysql_query($Consulta);$Cantidad=0;
		while($Fila2=mysql_fetch_array($Resp2))
		{
			$Consulta="select VPcantidad from pcip_svp_valorizacproduccion where VPorden='".$Fila2[num_orden]."' and VPa�o='".$Ano."' and VPmes between '".$MesIni."' and '".$MesFin."' ";
			if(!is_null($Fila2[num_orden_relacionada])&&$Fila2[num_orden_relacionada]!=0)
				$Consulta.=" and VPordenrel='".$Fila2[num_orden_relacionada]."'";
			if(!is_null($Fila2[cod_material]))
				$Consulta.=" and VPmaterial='".$Fila2[cod_material]."'";
			if(!is_null($Fila2[consumo_interno]))
				$Consulta.=" and VPordes='".$Fila2[consumo_interno]."'";
			if(!is_null($Fila2[vptm])&&$Fila2[vptm]!=0)
				$Consulta.=" and vptm='".$Fila2[vptm]."'";
			$Resp3=mysql_query($Consulta);
			//echo $Consulta."<br>";
			while($Fila3=mysql_fetch_array($Resp3))
			{
				$ProdCu=$ProdCu+$Fila3[VPcantidad];
			}
		}
	}
	if($ProdCu!=0)
		return($ProdCu);	
	else
		return(0);	
	
	
		
	/*$Consulta="select * from pcip_svp_asignaciones_productos where cod_asignacion='1' and cod_producto in('1','2','3','4','5','12','13')";
	//echo $Consulta;
	$Resp=mysql_query($Consulta);$ProdCu=0;
	while($Fila=mysql_fetch_array($Resp))
	{
		$Consulta="select cod_titulo as cod_tit,orden from pcip_svp_asignaciones_titulos where vigente='1' and cod_asignacion='1' order by orden";
		$RespTit=mysql_query($Consulta);
		while($FilaTit=mysql_fetch_array($RespTit))
		{
			$Consulta="select t2.origen,t2.num_orden,t2.num_orden_relacionada,t2.cod_material,t2.consumo_interno,t2.vptm from pcip_svp_negocios t1 inner join pcip_svp_productos_procedencias t2 on t1.cod_negocio=t2.cod_negocio ";
			$Consulta.="where t2.cod_asignacion='1' and t2.cod_procedencia ='".$Fila["cod_producto"]."' and t2.cod_titulo='".$FilaTit[cod_tit]."' and t1.vigente='1' order by t1.orden,t2.orden";
			$Resp2=mysql_query($Consulta);
			while($Fila2=mysql_fetch_array($Resp2))
			{
				if($Fila2[origen]=='SVP')
				{
					$Consulta="select VPcantidad from pcip_svp_valorizacproduccion where VPorden='".$Fila2[num_orden]."' and VPa�o='".$Ano."' and VPmes>='".$MesIni."' and VPmes<='".$MesFin."'";
					if(!is_null($Fila2[num_orden_relacionada])&&$Fila2[num_orden_relacionada]!=0)
						$Consulta.=" and VPordenrel='".$Fila2[num_orden_relacionada]."'";
					if(!is_null($Fila2[cod_material]))
						$Consulta.=" and VPmaterial='".$Fila2[cod_material]."'";
					if(!is_null($Fila2[consumo_interno]))
						$Consulta.=" and VPordes='".$Fila2[consumo_interno]."'";
					if(!is_null($Fila2[vptm]))
						$Consulta.=" and vptm='".$Fila2[vptm]."'";
					$Resp3=mysql_query($Consulta);
					while($Fila3=mysql_fetch_array($Resp3))
					{
						$ProdCu=$ProdCu+$Fila3[VPcantidad];
					}
				}
			}
		}
	}*/
	//return($ProdCu);
}
function ProdCobreElectPpto($Ano,$Mes,$Mostrar)
{
	if($Mostrar=='M')
	{
		$MesIni=$Mes;
		$MesFin=$Mes;
	}
	else
	{
		$MesIni=1;
		$MesFin=$Mes;
	}
	$ProdCu=0;
	$Consulta="select max(version) as version from pcip_ppc_version where ano='".$Ano."'";
	//echo $Consulta."<br>";
	$Resp2=mysql_query($Consulta);$Cantidad=0;
	$Fila2=mysql_fetch_array($Resp2);
	$Version=$Fila2[version];
	$Consulta="select cod_producto from pcip_svp_asignaciones_productos ";
	$Consulta.=" where cod_asignacion='1' and mostrar_cu_elect='1' ";
	$RespProd=mysql_query($Consulta);
	while($FilaProd=mysql_fetch_array($RespProd))
	{
		$Consulta="select sum(valor) as valor from pcip_ppc_detalle ";
		$Consulta.="where version='".$Version."' and cod_asignacion='1' and cod_procedencia='".$FilaProd["cod_producto"]."' and (ano='".$Ano."' and mes between '".$MesIni."' and '".$MesFin."') ";
		//echo $Consulta."<br>";
		$Resp2=mysql_query($Consulta);$Cantidad=0;
		if($Fila2=mysql_fetch_array($Resp2))
		{
			$ProdCu=$ProdCu+$Fila2[valor];
			//return($Fila2[valor]);							
		}
		/*else
		{
			return(0);		
		}*/
	}
	return($ProdCu);
}

function ObtieneAcidoSvp($Ano,$Mes,$Mostrar)
{
	if($Mostrar=='M')
	{
		$MesIni=$Mes;
		$MesFin=$Mes;
	}
	else
	{
		$MesIni=1;
		$MesFin=$Mes;
	}
	$Acido=0;
	$Consulta="SELECT VPcantidad FROM pcip_svp_valorizacproduccion WHERE VPa�o = '".$Ano."' ";
	if($Mostrar=='M')
		$Consulta.= " and VPmes = ".($MesIni)." group by VPa�o,VPmes,VPorden";
	else
		$Consulta.= " and VPmes between '".$MesIni."' and ".($MesFin)." group by VPa�o,VPorden";
	$Consulta.=" AND `VPorden` = '5810' AND ((`VPtm` = '11' AND `VPordenrel` = '6810') OR (`VPtm` = '11' AND `VPordenrel` = '6811') OR (`VPtm` = '21'))";
	//echo $Consulta."<br>";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$Acido=$Acido+$Fila[VPcantidad];
	}
	return($Acido);
}
function ObtieneAcidoPpto($Ano,$Mes,$Mostrar)
{
	if($Mostrar=='M')
	{
		$MesIni=$Mes;
		$MesFin=$Mes;
	}
	else
	{
		$MesIni=1;
		$MesFin=$Mes;
	}
	$Consulta="select max(version) as version from pcip_ppc_version where ano='".$Ano."'";
	//echo $Consulta."<br>";
	$Resp2=mysql_query($Consulta);$Cantidad=0;
	$Fila2=mysql_fetch_array($Resp2);
	$Version=$Fila2[version];
	$Consulta="select sum(valor) as valor from pcip_ppc_detalle ";
	$Consulta.="where version='".$Version."' and cod_asignacion='4' and cod_procedencia='18' and (ano='".$Ano."' and mes between '".$MesIni."' and '".$MesFin."') ";
	//echo $Consulta."<br>";
	$Resp2=mysql_query($Consulta);$Cantidad=0;
	if($Fila2=mysql_fetch_array($Resp2))
	{
		return($Fila2[valor]);							
	}
	else
	{
		return(0);		
	}
}

function CargaNuevaUtil($Ano,$Mes,$Mostrar,$Tipo)
{
	if($Mostrar=='M')
	{
		$MesIni=$Mes;
		$MesFin=$Mes;
	}
	else
	{
		$MesIni=1;
		$MesFin=$Mes;
	}
	$CargaUtil=0;
	$Consulta="select sum(peso) as peso from pcip_ena_datos_enabal where ano='".$Ano."' and cod_flujo='24' and tipo_dato='F' and tipo='".$Tipo."' and origen = 'ENA' ";
	if($Mostrar=='M')
		$Consulta.= " and mes = '".$MesIni."' group by ano,mes,cod_flujo";
	else
		$Consulta.= " and mes between '".$MesIni."' and '".$MesFin."' group by ano,cod_flujo";
	//echo $Consulta."<br>"; 
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$CargaUtil=$CargaUtil+$Fila["peso"];
	}
	if($CargaUtil>0)
		$CargaUtil=$CargaUtil/1000;
	return($CargaUtil);
}
function CargaNuevaUtilPpto($Ano,$Mes,$Mostrar,$Tipo)
{
	if($Mostrar=='M')
	{
		$MesIni=$Mes;
		$MesFin=$Mes;
	}
	else
	{
		$MesIni=1;
		$MesFin=$Mes;
	}
	$CargaUtil=0;
	$Consulta="SELECT valor_presupuestado FROM pcip_inp_tratam WHERE ano = '".$Ano."' and nom_area='1' and nom_division='6' and cod_producto='TMS'";
	if($Mostrar=='M')
		$Consulta.= " and mes = '".$MesIni."' ";
	else
		$Consulta.= " and mes between '".$MesFin."' and '".$MesFin."'";
	//echo $Consulta."<br>"; 
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$CargaUtil=$CargaUtil+$Fila[valor_presupuestado];
	}
	//if($CargaUtil>0)
	//	$CargaUtil=$CargaUtil/1000;
	return($CargaUtil);
}

?>