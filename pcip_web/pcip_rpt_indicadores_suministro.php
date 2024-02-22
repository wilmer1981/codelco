<?
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
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "C"://BUSCA
			if(f.CmbIndicador.value=='-1')
			{
				alert('Debe Seleccionar Indicador');
				f.CmbIndicador.focus();
				return;
			}	
			if(f.CmbGrupoSuministro.value=='-1')
			{
				alert('Debe Seleccionar Grupo Suministro');
				f.CmbGrupoSuministro.focus();
				return;
			}	
			if(f.CmbSuministro.value=='-1')
			{
				alert('Debe Seleccionar Suministro');
				f.CmbSuministro.focus();
				return;
			}	
			f.action = "pcip_rpt_indicadores_suministro.php?Buscar=S";
			f.submit();
		break;
		case "E"://ELIMINAR
			URL='pcip_rpt_indicadores_suministro_excel.php?Buscar=S&CmbIndicador='+f.CmbIndicador.value+'&CmbGrupoSuministro='+f.CmbGrupoSuministro.value+'&CmbSuministro='+f.CmbSuministro.value+'&Ano='+f.Ano.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&CmbMostrar="+f.CmbMostrar.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
			f.submit();
			break;
		case "R":
			f.action = "pcip_rpt_indicadores_suministro.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=7";
		break;
	
	}
	
}

</script>
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
 EncabezadoPagina($IP_SERV,'indicadores.png')
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
    <td width="16%" height="17" class='formulario2'>Indicador</td>
    <td class="formulario2" ><label>
      <select name="CmbIndicador" style="width:250">
	  <option value="-1" selected="selected">Seleccionar</option>
        <?
	    $Consulta = "select cod_indicador,nom_indicador from pcip_eec_indicadores order by nom_indicador ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbIndicador==$FilaTC["cod_indicador"])
				echo "<option selected value='".$FilaTC["cod_indicador"]."'>".ucfirst($FilaTC["nom_indicador"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_indicador"]."'>".ucfirst($FilaTC["nom_indicador"])."</option>\n";
		}
		?>
      </select>
    </label>    </tr>
  <tr>
    <td height="25" class='formulario2'>Grupo Suministro </td>
    <td class='formulario2'><select name="CmbGrupoSuministro" onChange="Procesos('R')">
      <option value="-1" class="NoSelec">Seleccionar</option>
      <?
	    $Consulta = "select * from pcip_eec_suministros_grupos where cod_suministro_grupo not in ('4','5') order by nom_agrupacion ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbGrupoSuministro==$FilaTC["cod_suministro_grupo"])
				echo "<option selected value='".$FilaTC["cod_suministro_grupo"]."'>".ucfirst($FilaTC["nom_agrupacion"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_suministro_grupo"]."'>".ucfirst($FilaTC["nom_agrupacion"])."</option>\n";
		}
			?>
    </select>
      Suministro
      <select name="CmbSuministro" >
        <?
		if(isset($CmbGrupoSuministro)&&($CmbGrupoSuministro=='2'||$CmbGrupoSuministro=='4'))
			echo "<option value='T' class='NoSelec'>Todos</option>";
		else
			echo "<option value='-1' class='NoSelec'>Seleccionar</option>";	
	    $Consulta = "select t1.cod_suministro,t2.nom_suministro from pcip_eec_suministros_por_grupos t1 inner join pcip_eec_suministros t2 on t1.cod_suministro=t2.cod_suministro ";
	    $Consulta.= "where t1.cod_suministro_grupo='".$CmbGrupoSuministro."' order by t2.nom_suministro ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbSuministro==$FilaTC["cod_suministro"])
				echo "<option selected value='".$FilaTC["cod_suministro"]."'>".ucfirst($FilaTC["nom_suministro"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_suministro"]."'>".ucfirst($FilaTC["nom_suministro"])."</option>\n";
		}
			?>
      </select>    </tr>
  <tr>
    <td height="25" class='formulario2'>A&ntilde;o</td>
    <td class='formulario2'><select name="Ano" id="Ano">
      <?
	for ($i=2003;$i<=date("Y");$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
    </select>      </tr>
  <tr>
    <td height="25" class='formulario2'>Mes </td>
    <td class='formulario2'><select name="Mes" id="Mes">
      <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$Mes)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
?>
    </select>      </tr>
  <tr>
    <td height="25" class='formulario2'>Mostrar por</td>
    <td class='formulario2'>
	<select name="CmbMostrar" style="width:250">
    <option value="S" selected="selected">Seleccionar</option>
	<?
	switch($CmbMostrar)
	{
		case "A":
			echo "<option value='A' selected>Acumulado</option>";	
			echo "<option value='M'>Mensual</option>";	
		break;
		case "M":
			echo "<option value='A'>Acumulado</option>";	
			echo "<option value='M' selected>Mensual</option>";	
		break;
		default:
			echo "<option value='A' selected>Acumulado</option>";	
			echo "<option value='M'>Mensual</option>";	
		break;
	}
	?>
    </select>
	</tr>
 </table></td>
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
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr class="TituloTablaVerde">
            <td rowspan="2"><span class="TituloTablaVerde">&nbsp;&nbsp;MES CONSULTADO:&nbsp;<? echo strtoupper($Meses[$Mes-1]);?> </span></td>
            <td align="center" class="TituloTablaVerde"><? echo intval($Ano)-1;?></td>
            <td colspan="2" align="center" class="TituloTablaVerde"><? echo $Ano;?></td>
            </tr>
          <tr>
            <td align="center" class="TituloTablaVerde">REAL</td>
            <td align="center" class="TituloTablaVerde">REAL</td>
            <td align="center" class="TituloTablaVerde">PTTO</td>
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
            <td class="formulario2">CONSUMO [<? echo $Unidad;?>/mes] </td>
            <td align="right"><? echo number_format($ConsumoRealAnt,0,',','.');?>&nbsp;</td>
            <td align="right"><? echo number_format($ConsumoReal,0,',','.');?>&nbsp;</td>
            <td align="right"><? echo number_format($ConsumoPpto,0,',','.');?>&nbsp;</td>
          </tr>
          <tr>
            <td class="formulario2">Prod. Cobre Elect (TMF) </td>
            <td align="right"><? echo number_format($ProdCuElectRealAnt,0,',','.');?>&nbsp;</td>
            <td align="right"><? echo number_format($ProdCuElectReal,0,',','.');?>&nbsp;</td>
            <td align="right"><? echo number_format($ProdCuElectPpto,0,',','.');?>&nbsp;</td>
          </tr>
          <tr>
            <td class="formulario2">Carga Nueva Util a Fundir (TMS)</td>
            <td align="right"><? echo number_format($CargaNURealAnt,0,',','.');?>&nbsp;</td>
            <td align="right"><? echo number_format($CargaNUReal,0,',','.');?>&nbsp;</td>
            <td align="right"><? echo number_format($CargaNURealPpto,0,',','.');?>&nbsp;</td>
          </tr>
          <tr>
            <td class="formulario2">Producci&oacute;n de Oxigeno (Ton) </td>
            <td align="right"><? echo number_format($ConsumoOxiRealAnt,0,',','.');?>&nbsp;</td>
            <td align="right"><? echo number_format($ConsumoOxiReal,0,',','.');?>&nbsp;</td>
            <td align="right"><? echo number_format($ConsumoOxiPpto,0,',','.');?>&nbsp;</td>
          </tr>
          <tr>
            <td class="formulario2">Producci&oacute;n de Vapor (Ton) </td>
            <td align="right"><? echo number_format($ConsumoVaporTermRealAnt,0,',','.');?>&nbsp;</td>
            <td align="right"><? echo number_format($ConsumoVaporTermReal,0,',','.');?>&nbsp;</td>
            <td align="right"><? echo number_format($ConsumoVaporTermPpto,0,',','.');?>&nbsp;</td>
          </tr>
          <tr>
            <td class="TituloTablaNaranja">Consumo Total <? echo $Unidad;?>/TmF Cu elect. </td>
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
				<td class="TituloTablaNaranja"><? echo $NomIndicador;?>&nbsp;[<? echo $Unidad;?>/Ton] / TMF</td>
				<td align="right"><? echo number_format($ValorIndicadorRealAnt,3,',','.');?>&nbsp;</td>
				<td align="right"><? echo number_format($ValorIndicadorReal,3,',','.');?>&nbsp;</td>
				<td align="right"><? echo number_format($ValorIndicadorPPto,3,',','.');?>&nbsp;</td>
			  </tr>
			<?
			}
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