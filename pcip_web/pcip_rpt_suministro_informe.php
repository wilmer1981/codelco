<?
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

$Consulta = "select t1.cod_suministro,t2.nom_suministro,t3.nom_agrupacion from pcip_eec_suministros_por_grupos t1";
$Consulta.= " inner join pcip_eec_suministros t2 on t1.cod_suministro=t2.cod_suministro ";
$Consulta.= " inner join pcip_eec_suministros_grupos t3 on t1.cod_suministro_grupo=t3.cod_suministro_grupo ";
$Consulta.= "where t1.cod_suministro_grupo='".$CmbGrupoSuministro."'";
if($CmbSuministro!='T')
	$Consulta.= " and t1.cod_suministro='".$CmbSuministro."' ";	
$Consulta.= "order by t2.nom_suministro ";			
$Resp=mysqli_query($link, $Consulta);
//echo $Consulta."<br>";
while ($Fila=mysql_fetch_array($Resp))
{
	if($CmbSuministro!='T')
	{
		$CmbSuministro=$Fila[cod_suministro];
		$Sumi=explode('~',DatosSumistros($CmbSuministro));	
		$NomSuministro=$Sumi[1];
		$Unidad=$Sumi[2];
	}
	else
	{
		$CmbSuministro=$Fila[cod_suministro];
		$NomSuministro=$Fila[nom_agrupacion];
	}
	
	$ValorConv=Conversion($CmbSuministro);
	//REAL
	$CantReal=$CantReal+ObtieneCantidad($CmbSuministro,$Ano,$Mes,$ValorConv,'S','M');
	$PrecioReal=$PrecioReal+ObtienePrecioReal($CantReal,$CmbSuministro,$Ano,$Mes,'M');
	$ValorReal=	($CantReal*$PrecioReal)/1000;
	//PRESUPUESTADO
	$CantPpto=$CantPpto+ObtieneCantidad($CmbSuministro,$Ano,$Mes,$ValorConv,'P','M');
	$PrecioPpto=$PrecioPpto+ObtienePrecioPpto($CmbSuministro,$Ano,$Mes,'M');
	$ValorPpto=($CantPpto*$PrecioPpto)/1000;
	//VARIACIONES
	$VarCant=$CantReal-$CantPpto;
	$VarPrecio=$PrecioReal-$PrecioPpto;
	$VarValor=$ValorReal-$ValorPpto;
	//PORCENTAJE
	if($CantPpto>0)
		$PorcCant=((($CantReal-$CantPpto)/$CantPpto)*100);
	else
		$PorcCant=0;
	if($PrecioPpto>0)		
		$PorcPrecio=((($PrecioReal-$PrecioPpto)/$PrecioPpto)*100);
	else
		$PorcPrecio=0;
	if($ValorReal>0&&$ValorPpto>0)	
		$PorcValor=((($ValorReal-$ValorPpto)/$ValorPpto)*100);
	else
		$PorcValor=0;
	$EfectoCant=($VarCant*$PrecioPpto)/1000;
	$EfectoPrecio=($CantReal*$VarPrecio)/1000;
	$TotalVar=$EfectoCant+$EfectoPrecio;
	//REAL ACUMULADO
	$CantRealAcum=$CantRealAcum+ObtieneCantidad($CmbSuministro,$Ano,$Mes,$ValorConv,'S','A');
	$PrecioRealAcum=$PrecioRealAcum+ObtienePrecioReal($CantReal,$CmbSuministro,$Ano,$Mes,'A');
	$ValorRealAcum=	($CantRealAcum*$PrecioRealAcum)/1000;
	//PRESUPUESTADO ACUMULADO
	$CantPptoAcum=$CantPptoAcum+ObtieneCantidad($CmbSuministro,$Ano,$Mes,$ValorConv,'P','A');
	$PrecioPptoAcum=$PrecioPptoAcum+ObtienePrecioPpto($CmbSuministro,$Ano,$Mes,'A');
	$ValorPptoAcum=	($CantPptoAcum*$PrecioPptoAcum)/1000;
	//VARIACIONES
	$VarCantAcum=$CantRealAcum-$CantPptoAcum;
	$VarPrecioAcum=$PrecioRealAcum-$PrecioPptoAcum;
	$VarValorAcum=$ValorRealAcum-$ValorPptoAcum;
	//PORCENTAJE
	if($CantPptoAcum>0)
		$PorcCantAcum=((($CantRealAcum-$CantPptoAcum)/$CantPptoAcum)*100);
	else
		$PorcCantAcum=0;
	if($PrecioPptoAcum>0)		
		$PorcPrecioAcum=((($PrecioRealAcum-$PrecioPptoAcum)/$PrecioPptoAcum)*100);
	else
		$PorcPrecioAcum=0;
	if($ValorRealAcum>0&&$ValorPptoAcum>0)	
		$PorcValorAcum=((($ValorRealAcum-$ValorPptoAcum)/$ValorPptoAcum)*100);
	else
		$PorcValorAcum=0;
	$EfectoCantAcum=($VarCantAcum*$PrecioPptoAcum)/1000;
	$EfectoPrecioAcum=($CantRealAcum*$VarPrecioAcum)/1000;
	$TotalVarAcum=$EfectoCantAcum+$EfectoPrecioAcum;
	//CATODO GRADO A (TMF) REAL
	$ValorCatGradoATmfReal=$ValorCatGradoATmfReal+ObtieneCatodosGradoATMF('N','1',$Ano,$Mes,'M');
	$ValorCatGradoATmfRealAcum=$ValorCatGradoATmfRealAcum+ObtieneCatodosGradoATMF('N','1',$Ano,$Mes,'A');
	$ValorCatOtrosATmfReal=$ValorCatOtrosATmfReal+ObtieneCatodosGradoATMF('S','1',$Ano,$Mes,'M');
	$ValorCatOtrosATmfRealAcum=$ValorCatOtrosATmfRealAcum+ObtieneCatodosGradoATMF('S','1',$Ano,$Mes,'A');
	//CATODO GRADO A (TMF) PPTO
	$ValorCatGradoATmfPpto=$ValorCatGradoATmfPpto+ObtieneCatodosGradoATMFPpto('N','1',$Ano,$Mes,'M');
	$ValorCatGradoATmfPptoAcum=$ValorCatGradoATmfPptoAcum+ObtieneCatodosGradoATMFPpto('N','1',$Ano,$Mes,'A');
	$ValorCatOtrosATmfPpto=$ValorCatOtrosATmfPpto+ObtieneCatodosGradoATMFPpto('S','1',$Ano,$Mes,'M');
	$ValorCatOtrosATmfPptoAcum=$ValorCatOtrosATmfPptoAcum+ObtieneCatodosGradoATMFPpto('S','1',$Ano,$Mes,'A');
	//TOTAL CU ELECTRO 
	$TotCuElectroReal=$ValorCatGradoATmfReal+$ValorCatOtrosATmfReal;
	$TotCuElectroRealAcum=$ValorCatGradoATmfRealAcum+$ValorCatOtrosATmfRealAcum;
	$TotCuElectroPpto=$ValorCatGradoATmfPpto+$ValorCatOtrosATmfPpto;
	$TotCuElectroPptoAcum=$ValorCatGradoATmfPptoAcum+$ValorCatOtrosATmfPptoAcum;
	
	//Consumo KWH/TMF Cu Electro
	if($TotCuElectroReal<>0) 
		$ConsuCuElectroReal=$CantReal/$TotCuElectroReal*1000;
	if($TotCuElectroRealAcum<>0) 	
		$ConsuCuElectroRealAcum=$CantRealAcum/$TotCuElectroRealAcum*1000;
	if($TotCuElectroPpto<>0) 
		$ConsuCuElectroPpto=$CantPpto/$TotCuElectroPpto*1000;
	if($TotCuElectroPptoAcum<>0) 
		$ConsuCuElectroPptoAcum=$CantPptoAcum/$TotCuElectroPptoAcum*1000;
}
?>
<html>
<head>
<title>Reporte Informe Suministro</title>
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
		<td width="81%" align="center" class='formulario2 Estilo7'>Informe Suministros <? echo $Ano;?></td>
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
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20%">&nbsp;</td>
            <td width="40%" colspan="4" align="center" class="TituloTablaVerde">MES:&nbsp;<? echo strtoupper($Meses[$Mes-1]);?></td>
            <td width="40%" colspan="4" align="center" class="TituloTablaVerde">ACUMULADO A:&nbsp;<? echo strtoupper($Meses[$Mes-1]);?> </td>
          </tr>
          <tr>
            <td width="20%"class="TituloTablaVerde"><? echo $NomSuministro;?></td>
            <td width="10%" align="center" class="TituloTablaVerde">Real</td>
            <td width="10%" align="center" class="TituloTablaVerde">Ppto.</td>
            <td width="10%" align="center" class="TituloTablaVerde">Var</td>
			<td width="10%" align="center" class="TituloTablaVerde">%</td>
            <td width="10%" align="center" class="TituloTablaVerde">Real</td>
            <td width="10%" align="center" class="TituloTablaVerde">Ppto. </td>
            <td width="10%" align="center" class="TituloTablaVerde">Var.</td>
			<td width="10%" align="center" class="TituloTablaVerde">%</td>
          </tr>
          <tr>
            <td class="formulario2">Cantidad[<? echo $Unidad;?>]</td>
            <td align="right"><? echo number_format($CantReal,0,'','.');?></td>
            <td align="right"><? echo number_format($CantPpto,0,'','.');?></td>
            <td align="right"><? echo number_format($VarCant,0,'','.');?></td>
            <td align="center"><? echo number_format($PorcCant,2,',','.');?></td>
            <td align="right"><? echo number_format($CantRealAcum,0,'','.');?></td>
            <td align="right"><? echo number_format($CantPptoAcum,0,'','.');?></td>
            <td align="right"><? echo number_format($VarCantAcum,0,'','.');?></td>
            <td align="center"><? echo number_format($PorcCantAcum,2,',','.');?></td>
          </tr>
          <tr>
            <td class="formulario2">Precio [US$/<? echo $Unidad;?>] </td>
            <td align="right"><? echo number_format($PrecioReal,0,'','.');?></td>
            <td align="right"><? echo number_format($PrecioPpto,0,'','.');?></td>
            <td align="right"><? echo number_format($VarPrecio,0,'','.');?></td>
            <td align="center"><? echo number_format($PorcPrecio,2,',','.');?></td>
            <td align="right"><? echo number_format($PrecioRealAcum,0,'','.');?></td>
            <td align="right"><? echo number_format($PrecioPptoAcum,0,'','.');?></td>
            <td align="right"><? echo number_format($VarPrecioAcum,0,'','.');?></td>
            <td align="center"><? echo number_format($PorcPrecioAcum,2,',','.');?></td>
          </tr>
          <tr>
            <td class="formulario2">Valor [kUS$] </td>
            <td align="right"><? echo number_format($ValorReal,0,'','.');?></td>
            <td align="right"><? echo number_format($ValorPpto,0,'','.');?></td>
            <td align="right"><? echo number_format($VarValor,0,'','.');?></td>
            <td align="center"><? echo number_format($PorcValor,2,',','.');?></td>
            <td align="right"><? echo number_format($ValorRealAcum,0,'','.');?></td>
            <td align="right"><? echo number_format($ValorPptoAcum,0,'','.');?></td>
            <td align="right"><? echo number_format($VarValorAcum,0,'','.');?></td>
            <td align="center"><? echo number_format($PorcValorAcum,2,',','.');?></td>
          </tr>
        </table>
          <br>
          <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20%" class="formulario2">Efecto Cantidad [kUS$]</td>
              <td width="20%" colspan="2" rowspan="3">&nbsp;</td>
              <td width="10%" align="right"><? echo number_format($EfectoCant,0,'','.');?></td>
              <td width="10%" rowspan="3">&nbsp;</td>
              <td width="20%" colspan="2" rowspan="3">&nbsp;</td>
              <td width="10%" align="right"><? echo number_format($EfectoCant,0,'','.');?></td>
              <td width="10%" rowspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td class="formulario2">Efecto Precio [kUS$] </td>
              <td align="right"><? echo number_format($EfectoPrecio,0,'','.');?></td>
              <td align="right"><? echo number_format($EfectoPrecio,0,'','.');?></td>
              </tr>
            <tr>
              <td class="TituloTablaVerde">Total Variacion[Kus$] </td>
              <td align="right" class="TituloTablaVerde"><? echo number_format($TotalVar,0,'','.');?></td>
              <td align="right" class="TituloTablaVerde"><? echo number_format($TotalVar,0,'','.');?></td>
              </tr>
          </table>
          <br>
		<table width="100%" border="1" cellspacing="0" cellpadding="0">

          <tr>
            <td width="20%" class="TituloTablaVerde">Consumo KWH/TMF Cu Electro </td>
            <td width="10%" align="right" class="TituloTablaVerde"><? echo number_format($ConsuCuElectroReal,0,'','.');?></td>
            <td width="10%" align="right" class="TituloTablaVerde"><? echo number_format($ConsuCuElectroPpto,0,'','.');?></td>
            <td width="10%" class="TituloTablaVerde">&nbsp;</td>
            <td width="10%" class="TituloTablaVerde">&nbsp;</td>
            <td width="10%" align="right" class="TituloTablaVerde"><? echo number_format($ConsuCuElectroRealAcum,0,'','.');?></td>
            <td width="10%" align="right" class="TituloTablaVerde"><? echo number_format($ConsuCuElectroPptoAcum,0,'','.');?></td>
            <td width="10%" class="TituloTablaVerde">&nbsp;</td>
            <td width="10%" class="TituloTablaVerde">&nbsp;</td>			
          </tr>
          <tr>
            <td class="formulario2">TOTAL CU ELECTRO </td>
            <td align="right"><? echo number_format($TotCuElectroReal,0,'','.');?></td>
            <td align="right"><? echo number_format($TotCuElectroPpto,0,'','.');?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><? echo number_format($TotCuElectroRealAcum,0,'','.');?></td>
            <td align="right"><? echo number_format($TotCuElectroPptoAcum,0,'','.');?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="formulario2">Catodos Grado A (TMF) </td>
            <td align="right"><? echo number_format($ValorCatGradoATmfReal,0,'','.');?></td>
            <td align="right"><? echo number_format($ValorCatGradoATmfPpto,0,'','.');?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><? echo number_format($ValorCatGradoATmfRealAcum,0,'','.');?></td>
            <td align="right"><? echo number_format($ValorCatGradoATmfPptoAcum,0,'','.');?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="formulario2">Catodos Rechazo + desp y Laminas </td>
            <td align="right"><? echo number_format($ValorCatOtrosATmfReal,0,'','.');?></td>
            <td align="right"><? echo number_format($ValorCatOtrosATmfPpto,0,'','.');?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><? echo number_format($ValorCatOtrosATmfRealAcum,0,'','.');?></td>
            <td align="right"><? echo number_format($ValorCatOtrosATmfPptoAcum,0,'','.');?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
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
function ObtieneCantidad($CmbSuministro,$Ano,$Mes,$ValorConv,$TipoSumi,$TipoCalc)
{
	if($TipoCalc=='M')
		$MesIni=$Mes;
	else
		$MesIni=1;
	$MesFin=$Mes;
	$Cant=0;
	for($i=$MesIni;$i<=$MesFin;$i++)
	{		
		$Consulta = "select sum(valor) as cant from pcip_eec_suministros_detalle where tipo='".$TipoSumi."' and cod_suministro='".$CmbSuministro."' and ano='".$Ano."' and mes='".$i."' group by cod_suministro,ano,mes,tipo";
		//echo $Consulta."<br>";		
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			$Cant=$Cant+($Fila[cant])*$ValorConv;
			//echo "cant:".$Fila[cant]."<br>";
			//echo "conv:".$ValorConv."<br><br>";
		}
	}
	//echo $Cant."<br>";
	return($Cant);
}
function Conversion($CodSumi)
{
$Conversion=1;
/*$Consulta = "select nom_suministro,valor1,valor2,valor3,formula from pcip_eec_suministros where cod_suministro='".$CodSumi."'";
//echo $Consulta;		
$Resp=mysqli_query($link, $Consulta);
if ($Fila=mysql_fetch_array($Resp))
{
	//$NomSuministro=$Fila[nom_suministro];
	$valor1=$Fila["valor1"];
	$valor2=$Fila["valor2"];
	$valor3=$Fila["valor3"];
	$Conversion=1;
	switch($CodSumi)
	{
		case "1"://DIESEL
			$Conversion=($valor1/$valor2)*$valor3;
		break;
		case "2"://GAS NATURAL
			$Conversion=$valor1*$valor3;
		break;
		case "3"://FUEL OIL
			$Conversion=$valor1*$valor2;
		break;
	}
	return($Conversion);
	//echo $Conversion;
}*/
return($Conversion);
}
function ObtienePrecioReal($CantReal,$CmbSuministro,$Ano,$Mes,$TipoCalc)
{
	$PrecioReal=0;
	$Consulta = "select valor_total,precio from pcip_eec_facturas_suministros where cod_suministro='".$CmbSuministro."' and ano='".$Ano."' and mes='".$Mes."' group by cod_suministro,ano,mes ";
	//echo $Consulta;		
	$Resp=mysqli_query($link, $Consulta);
	if ($Fila=mysql_fetch_array($Resp))
	{
		if($Fila[valor_total]!=0)
			$PrecioReal=$Fila[valor_total]/$CantReal;
		else
			$PrecioReal=$Fila[precio];
	}
	return($PrecioReal);

}
function ObtienePrecioPpto($CmbSuministro,$Ano,$Mes,$TipoCalc)
{
	$Consulta = "select sum(valor) as valor,count(*) as cant from pcip_eec_suministros_detalle where tipo='V' and cod_suministro='".$CmbSuministro."' and ano='".$Ano."' and mes='".$Mes."' group by cod_suministro,ano,mes,tipo";
	//echo $Consulta;		
	$Resp=mysqli_query($link, $Consulta);
	if ($Fila=mysql_fetch_array($Resp))
	{
		$PrecioPpto=$Fila[valor]/$Fila[cant];
	}
	return($PrecioPpto);

}
function ObtieneCatodosGradoATMF($Excluir,$CodProd,$Ano,$Mes,$TipoCalc)
{
	if($TipoCalc=='M')
		$MesIni=$Mes;
	else
		$MesIni=1;
	$MesFin=$Mes;
	$Cantidad=0;
	$Consulta="select cod_producto from pcip_svp_asignaciones_productos ";
	$Consulta.=" where cod_asignacion='1' and mostrar_cu_elect='1' ";
	if($Excluir=='N'&&$CodProd!='')
		$Consulta.=" and cod_producto = ".$CodProd."";
	else
		$Consulta.=" and cod_producto <> ".$CodProd."";	
	$RespProd=mysqli_query($link, $Consulta);
	while($FilaProd=mysql_fetch_array($RespProd))
	{
		$Consulta="select t2.origen,t2.num_orden,t2.num_orden_relacionada,t2.cod_material,t2.consumo_interno,t2.vptm from pcip_svp_negocios t1 inner join pcip_svp_productos_procedencias t2 on t1.cod_negocio=t2.cod_negocio and t2.origen in ('SVP')";
		$Consulta.="where t2.cod_asignacion='1' and t2.ano='".$Ano."' and t2.cod_procedencia ='".$FilaProd["cod_producto"]."' and t1.vigente='1' and t1.cod_negocio<>'4' and t1.mostrar_asig='1' order by t1.orden";
		//if($Fila[nom_asignacion]=='CATODOS GRADO A')
		//echo $Consulta."<br>";
		$Resp2=mysqli_query($link, $Consulta);$Encontro='N';
		while($Fila2=mysql_fetch_array($Resp2))
		{
			$Consulta="select VPcantidad from pcip_svp_valorizacproduccion where VPorden='".$Fila2[num_orden]."' and VPa�o='".$Ano."' and VPmes>='".$MesIni."' and VPmes<='".$MesFin."'";
			if(!is_null($Fila2[num_orden_relacionada])&&$Fila2[num_orden_relacionada]!=0)
				$Consulta.=" and VPordenrel='".$Fila2[num_orden_relacionada]."'";
			if(!is_null($Fila2[cod_material]))
				$Consulta.=" and VPmaterial='".$Fila2[cod_material]."'";
			if(!is_null($Fila2[consumo_interno]))
				$Consulta.=" and VPordes='".$Fila2[consumo_interno]."'";
			if(!is_null($Fila2[vptm])&&$Fila2[vptm]<>0)
				$Consulta.=" and vptm='".$Fila2[vptm]."'";
			$Resp3=mysqli_query($link, $Consulta);
			while($Fila3=mysql_fetch_array($Resp3))
			{
				//if($TipoCalc=='M')
				//	echo $Cantidad."<br>";
				$Cantidad=$Cantidad+$Fila3[VPcantidad];
			}
		}
	}
	return($Cantidad);
}
function ObtieneCatodosGradoATMFPpto($Excluir,$CodProd,$Ano,$Mes,$TipoCalc)
{
	if($TipoCalc=='M')
		$MesIni=$Mes;
	else
		$MesIni=1;
	$MesFin=$Mes;
	$Valor=0;
	$Consulta="select max(version) as version from pcip_ppc_version where ano='".$Ano."'";
	//echo $Consulta."<br>";
	$Resp2=mysqli_query($link, $Consulta);
	$Fila2=mysql_fetch_array($Resp2);
	$Version=$Fila2[version];
	
	$Consulta="select cod_producto from pcip_svp_asignaciones_productos ";
	$Consulta.=" where cod_asignacion='1' and mostrar_cu_elect='1' ";
	if($Excluir=='N'&&$CodProd!='')
		$Consulta.=" and cod_producto = ".$CodProd."";
	else
		$Consulta.=" and cod_producto <> ".$CodProd."";	
	$RespProd=mysqli_query($link, $Consulta);
	//if($Excluir=='S'&&$TipoCalc=='M')
	//	echo $Consulta."<br>";
	while($FilaProd=mysql_fetch_array($RespProd))
	{
		$Consulta="select sum(valor) as valor from pcip_ppc_detalle ";
		$Consulta.="where version='".$Version."' and cod_asignacion='1' and cod_procedencia='".$FilaProd["cod_producto"]."' and (ano='".$Ano."' and mes between '".$Mes."' and '".$MesFin."')";
		//if($Excluir=='S'&&$TipoCalc=='M')
		//	echo $Consulta."<br>";
		$Resp2=mysqli_query($link, $Consulta);
		if($Fila2=mysql_fetch_array($Resp2))
		{
			$Valor=$Valor+$Fila2[valor];
		}
	}
	return($Valor);							
}

?>