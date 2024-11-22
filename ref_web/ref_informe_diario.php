<?php
//include('../principal/conectar_principal.php');
include('../principal/conectar_ref_web.php');
//include('funciones/ref_funciones.php');
set_time_limit(15000);

$VisibleDivProceso = isset($_REQUEST["VisibleDivProceso"])?$_REQUEST["VisibleDivProceso"]:"";
$FDesde = isset($_REQUEST["FDesde"])?$_REQUEST["FDesde"]:"";
$FHasta = isset($_REQUEST["FHasta"])?$_REQUEST["FHasta"]:"";
$Buscar = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
$Mensaje = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";

if($VisibleDivProceso=='S')
	$VisibleDiv='hidden';

if($FDesde=="")
	$FDesde=date('Y-m-d');
if($FHasta=="")
	$FHasta=date('Y-m-d');

//$SelTarea=$NivelOrg;
?>
<html>
<head>
<title>Informe Diario Refiner&iacute;a Electrol&iacute;tica</title>

<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">

var popup=0;
 
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			document.getElementById('Cargando').style.visibility='visible';
			f.action='ref_informe_diario.php?Buscar=S';
			f.submit();		
		break;
		case "E":
				URL='ref_informe_diario_excel.php?Buscar=S&FDesde='+f.FDesde.value;
				window.open(URL,"","top=30,left=30,width=800,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "PA":
				URL='ref_informe_diario_parametros.php';
				window.open(URL,"","top=30,left=30,width=750,height=500,status=yes,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=10";
		break;
	}	
}
function CloseDiv()
{

	DivProceso.style.visibility='hidden';
	DivOCu.style.visibility='visible';
}
function compare_dates(fecha, fecha2)  
{  
	var xMonth=fecha.substring(3, 5);  
	var xDay=fecha.substring(0, 2);  
	var xYear=fecha.substring(6,10);  
	var yMonth=fecha2.substring(3, 5);  
	var yDay=fecha2.substring(0, 2);  
	var yYear=fecha2.substring(6,10);  
	if (xYear> yYear)  
   {  
	   return(true)  
   }  
  else  
   {  
	 if (xYear == yYear)  
	 {   
	   if (xMonth> yMonth)  
	   {  
		   return(true)  
	   }  
	   else  
	   {   
		 if (xMonth == yMonth)  
		 {  
		   if (xDay> yDay)  
			 return(true);  
		   else  
			 return(false);  
		 }  
		 else  
		   return(false);  
	   }  
	 }  
	 else  
	   return(false);  
  }  
}  

</script>
<link href="estilos/ref_style.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<body onLoad="document.getElementById('Cargando').style.visibility='hidden';">
<form name="FrmPrincipal" method="post" action="">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
	<td height="1%"><img src="archivos/interior2/esq1.gif" width="15" height="15"></td>
	<td width="98%" height="15" background="archivos/interior2/form_arriba.gif"></td>
	<td height="1%"><img src="archivos/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="1%" background="archivos/interior2/form_izq.gif"></td>
   <td align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
       <tr>
         <td colspan="3" align="center"><span class="TituloCabecera2">Informe Diario Refiner&iacute;a Electrol&iacute;tica</span></td>
         </tr>
       <tr>
         <td width="34%"><img id="Cargando" src="archivos/loading.gif">&nbsp;</td>
         <td width="26%"><span class="formulario">Seleccionar Fecha&nbsp;&nbsp;&nbsp;
             <input type="text" size="9" readonly maxlength="10" name="FDesde" id="FDesde"  class="InputDer" value='<?php echo $FDesde?>' />
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onClick="popFrame.fPopCalendar(FDesde,FDesde,popCal);return false" /></span><a href="JavaScript:Proceso('R')"></a></td>
         <td width="40%" align="right"><div id="DivOCu" style="visibility:<?php echo $VisibleDiv;?>">
	   <a href="JavaScript:Proceso('C')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;<a href="JavaScript:Proceso('PA')"><img src="archivos/llaves.png"   alt="Par�metros" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;<a href="javascript:Proceso('E')"><img src="archivos/btn_excel.png" width="28" height="28" border="0" alt="Excel"></a>&nbsp; <a href="javascript:window.print()"><img src="archivos/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp;<a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle"></a></div></td>
       </tr>
     </table>
     </td>
   <td width="1%" background="archivos/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="archivos/interior2/form_abajo.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="archivos/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
  </table><br>	
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td height="1%"><img src="archivos/interior2/esq1.gif" width="15" height="15"></td>
    <td width="98%" height="15" background="archivos/interior2/form_arriba.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15"></td>
    <td height="1%"><img src="archivos/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/interior2/form_izq.gif"></td>
    <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
  	  <tr>
  	    <td colspan="9" align="center" class="TituloCabecera">&nbsp;</td>
  	  </tr>
	  <tr>
	     <td width="20%" rowspan="2" align="center" class="TituloCabecera">PROD.ACUMULADA (t)</td>
         <td width="10%" colspan="2" align="center" class="TituloCabecera">REAL</td>
		 <td width="15%" rowspan="2" align="center" class="TituloCabecera">PGM. REV.<br>0perativo </td>
		 <td width="10%" rowspan="2" align="center" class="TituloCabecera">DIF.</td>
		 <td width="10%" rowspan="2" align="center" class="TituloCabecera">CUMPL.%</td>
		 <td width="15%" rowspan="2" align="center" class="TituloCabecera">PGM. REV.<br>Operativo ACUM.</td>
		 <td width="10%" rowspan="2" align="center" class="TituloCabecera">DIF. ACUM</td>
		 <td width="10%" rowspan="2" align="center" class="TituloCabecera">CUMPL. ACUM.</td>
        </tr>
	  <tr>
	    <td align="center" class="TituloCabecera">D&iacute;a.</td>
	    <td align="center" class="TituloCabecera">Acum.</td>
	    </tr>
	  <tr>
	  <?php
	  	//$Buscar='N';
		$CC_ProdRealD = 0;
		$CC_ProdRealA = 0;
		$CC_ProdRev_0 = 0;
		$Dif_0 = 0;
		$Cumpli_0=0;
		$CC_ProdRev_1=0;
		$Dif_1=0;
		$Cumpli_1=0;
		$TOT_ProdRealD=0;
		$TOT_ProdRealA=0;
		$TOT_ProdRev_0=0;
		$TOT_ProdRev_1=0;
		if($Buscar=='S')
		{	
			$CC_ProdRealD=ProdAcumReal(18,1,'D',$FDesde,$link);
			$CC_ProdRealA=ProdAcumReal(18,1,'A',$FDesde,$link);
			$CC_ProdRev_0=ProdRev('d_catodo_comercial',$FDesde,'D',0,$link);
			$Dif_0=$CC_ProdRealD-$CC_ProdRev_0;
			//$Cumpli_0=0;
			if($CC_ProdRev_0!=0)
	  			$Cumpli_0=($CC_ProdRealD*100)/$CC_ProdRev_0;
			$CC_ProdRev_1=ProdRev('d_catodo_comercial',$FDesde,'A',1,$link);
			$Dif_1=$CC_ProdRealA-$CC_ProdRev_1;
			//$Cumpli_1=0;
			if($CC_ProdRev_1!=0)
	  			$Cumpli_1=($CC_ProdRealA*100)/$CC_ProdRev_1;
			
			$TOT_ProdRealD=$CC_ProdRealD;
			$TOT_ProdRealA=$CC_ProdRealA;
			$TOT_ProdRev_0=$CC_ProdRev_0;
			$TOT_ProdRev_1=$CC_ProdRev_1;
		}	
	  ?>
	    <td align="left" class="titulo_azul">C&aacute;todos Comerciales</td>
	    <td align="right"><?php echo number_format($CC_ProdRealD,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($CC_ProdRealA,1,',','.');?></td>
	    <td align="right"><?php echo number_format($CC_ProdRev_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($Dif_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($Cumpli_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($CC_ProdRev_1,1,',','.');?></td>
	    <td align="right"><?php echo number_format($Dif_1,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($Cumpli_1,1,',','.');?>&nbsp;</td>
	    </tr>
	  <tr>
	  <?php
	  $DN_ProdRealD=0;
	  $DN_ProdRealA=0;
	  $DN_ProdRev_0=0;
	  $DN_Dif_0=0;
	  $DN_Cumpli_0=0;
	  $DN_ProdRev_1=0;
	  $DN_Dif_1=0;
	  $DN_Cumpli_1=0;
	  	if($Buscar=='S')
		{	
	  		$DN_ProdRealD=round(ProdAcumReal(18,5,'D',$FDesde,$link),1);
			$DN_ProdRealA=round(ProdAcumReal(18,5,'A',$FDesde,$link),1);
			$DN_ProdRev_0=round(ProdRev('a_catodo_comercial',$FDesde,'D',0,$link),1);
			//echo $DN_ProdRealD."-".$DN_ProdRev_0."<br>";
			$DN_Dif_0=$DN_ProdRealD-$DN_ProdRev_0;
			$DN_Cumpli_0=0;
			if($DN_ProdRev_0!=0)
	  			$DN_Cumpli_0=($DN_ProdRealD*100)/$DN_ProdRev_0;
			$DN_ProdRev_1=round(ProdRev('a_catodo_comercial',$FDesde,'A',1,$link),1);
			//echo $DN_ProdRealD."-".$DN_ProdRev_1."<br>";
			$DN_Dif_1=$DN_ProdRealA-$DN_ProdRev_1;
			$DN_Cumpli_1=0;
			if($DN_ProdRev_1!=0)
	  			$DN_Cumpli_1=($DN_ProdRealA*100)/$DN_ProdRev_1;

			$TOT_ProdRealD=$TOT_ProdRealD+$DN_ProdRealD;
			$TOT_ProdRealA=$TOT_ProdRealA+$DN_ProdRealA;
			$TOT_ProdRev_0=$TOT_ProdRev_0+$DN_ProdRev_0;
			$TOT_ProdRev_1=$TOT_ProdRev_1+$DN_ProdRev_1;
		}		
	  ?>
	    <td align="left" class="titulo_azul">Descobrizaci&oacute;n Normal</td>
	    <td align="right"><?php echo number_format($DN_ProdRealD,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($DN_ProdRealA,1,',','.');?></td>
	    <td align="right"><?php echo number_format($DN_ProdRev_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($DN_Dif_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($DN_Cumpli_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($DN_ProdRev_1,1,',','.');?></td>
	    <td align="right"><?php echo number_format($DN_Dif_1,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($DN_Cumpli_1,1,',','.');?>&nbsp;</td>
	    </tr>
	  <tr>
	  <?php
	  $LD_ProdRealD=0;
	  $LD_ProdRealA=0;
	  $LD_ProdRev_0=0;
	  $LD_ProdRev_1=0;
	  $LD_Dif_0=0;
	  $LD_Dif_1=0;
	  $LD_Cumpli_0=0;
	  $LD_Cumpli_1=0;  
	  
	  	if($Buscar=='S')
		{	
	  		$LD_ProdRealD=round(ProdAcumReal(48,'','D',$FDesde,$link),1);
			$LD_ProdRealA=round(ProdAcumReal(48,'','A',$FDesde,$link),1);
			$LD_ProdRev_0=round(ProdRev('desp_lamina',$FDesde,'D',0,$link),1);
			//echo $DN_ProdRealD."-".$DN_ProdRev_0."<br>";
			$LD_Dif_0=$LD_ProdRealD-$LD_ProdRev_0;
			$LD_Cumpli_0=0;
			if($LD_ProdRev_0!=0)
	  			$LD_Cumpli_0=($LD_ProdRealD*100)/$LD_ProdRev_0;
			$LD_ProdRev_1=round(ProdRev('desp_lamina',$FDesde,'A',1,$link),1);
			//echo $DN_ProdRealD."-".$DN_ProdRev_1."<br>";
			$LD_Dif_1=$LD_ProdRealA-$LD_ProdRev_1;
			$LD_Cumpli_1=0;
			if($LD_ProdRev_1!=0)
	  			$LD_Cumpli_1=($LD_ProdRealA*100)/$LD_ProdRev_1;

			$TOT_ProdRealD=$TOT_ProdRealD+$LD_ProdRealD;
			$TOT_ProdRealA=$TOT_ProdRealA+$LD_ProdRealA;
			$TOT_ProdRev_0=$TOT_ProdRev_0+$LD_ProdRev_0;
			$TOT_ProdRev_1=$TOT_ProdRev_1+$LD_ProdRev_1;
		}		
	  ?>
	    <td align="left" class="titulo_azul">L&aacute;minas y Despuntes</td>
	    <td align="right"><?php echo number_format($LD_ProdRealD,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($LD_ProdRealA,1,',','.');?></td>
	    <td align="right"><?php echo number_format($LD_ProdRev_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($LD_Dif_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($LD_Cumpli_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($LD_ProdRev_1,1,',','.');?></td>
	    <td align="right"><?php echo number_format($LD_Dif_1,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($LD_Cumpli_1,1,',','.');?>&nbsp;</td>
	    </tr>
	  <tr class="TituloCabecera">
	  <?php
	  $TOT_Dif_0=0;
	  $TOT_Dif_1=0;
	  $TOT_Cumpli_0=0;
	  $TOT_Cumpli_1=0;
	  	if($Buscar=='S')
		{	
	  		$TOT_Dif_0=$TOT_ProdRealD-$TOT_ProdRev_0;			
			if($TOT_ProdRev_0!=0)
				$TOT_Cumpli_0=($TOT_ProdRealD*100)/$TOT_ProdRev_0;
			
			$TOT_Dif_1=$TOT_ProdRealA-$TOT_ProdRev_1;
			
			if($TOT_ProdRev_1!=0)
				$TOT_Cumpli_1=($TOT_ProdRealA*100)/$TOT_ProdRev_1;
		}		
	  ?>
	    <td align="left" class="TituloCabecera">Total Cu Efectivo</td>
	    <td align="right"><?php echo number_format($TOT_ProdRealD,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($TOT_ProdRealA,1,',','.');?></td>
	    <td align="right"><?php echo number_format($TOT_ProdRev_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($TOT_Dif_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($TOT_Cumpli_0,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($TOT_ProdRev_1,1,',','.');?></td>
	    <td align="right"><?php echo number_format($TOT_Dif_1,1,',','.');?>&nbsp;</td>
	    <td align="right"><?php echo number_format($TOT_Cumpli_1,1,',','.');?>&nbsp;</td>
	    </tr>
    </table>
      </td>
    <td width="1%" background="archivos/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="archivos/interior2/form_abajo.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="archivos/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
</table><br>
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td height="1%"><img src="archivos/interior2/esq1.gif" width="15" height="15"></td>
    <td width="98%" height="15" background="archivos/interior2/form_arriba.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15"></td>
    <td height="1%"><img src="archivos/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/interior2/form_izq.gif"></td>
    <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
     <tr><td colspan="16" align="center" class="TituloCabecera">INFORME DIARIO</td></tr>
	  <tr>
        <td width="20%" rowspan="2" align="center" class="TituloCabecera">CTO.</td>
        <td width="20%" rowspan="2" align="center" class="TituloCabecera">GRUPO</td>
        <td width="20%" rowspan="2" align="center" class="TituloCabecera">PROD. CAT.COM. </td>
        <td width="20%" rowspan="2" align="center" class="TituloCabecera">PROD.DESCOB.</td>
        <td colspan="2" align="center" class="TituloCabecera">N&ordm; CUBAS </td>
        <td width="15%" rowspan="2" align="center" class="TituloCabecera">% RESTOS ANODOS </td>
        <td width="10%" rowspan="2" align="center" class="TituloCabecera">CORRIENTE KAH </td>
        <td width="15%" rowspan="2" align="center" class="TituloCabecera">K.A. Efectivo </td>
        <td width="10%" rowspan="2" align="center" class="TituloCabecera">EFICTE CTE. </td>
        <td width="10%" rowspan="2" align="center" class="TituloCabecera">EFIC. TPO. </td>
        <td width="10%" rowspan="2" align="center" class="TituloCabecera">TPO.DESC.X RENOV</td>
        <td width="10%" rowspan="2" align="center" class="TituloCabecera">TPO. DESC. PARCIAL </td>
        <td width="10%" rowspan="2" align="center" class="TituloCabecera">TPO.DESC.X RECTIF. </td>
        <td width="10%" rowspan="2" align="center" class="TituloCabecera">TPO.REAL CONEXION </td>
      </tr>
      <tr>
        <td align="center" class="TituloCabecera">COMERC.</td>
        <td align="center" class="TituloCabecera">DESCOB.</td>
      </tr>
	  <?php
	  //$Buscar='N';
	  $AcumTpoRealConex=0; //WSO
	  $AcumKAHEfect=0; //WSO
	  $TOTPesoGrupoCom=0;//WSO
	  $TOTPesoGrupoDes=0;//WSO
	  $AcumCubasCom=0;
	  $AcumCorrKAH=0;
	  $AcumEfiCte=0;
	  $AcumEfiTpo=0;
	  $EfiCte=0;
	  if($Buscar=='S')
	  {	
  		 $Consulta="select cod_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase = '10005'";
		 $Resp=mysqli_query($link, $Consulta);
		 while($Fila=mysqli_fetch_array($Resp))
		 {
		 	switch ($Fila["cod_subclase"])
			{
				case "1":
					$Param1=$Fila["valor_subclase1"];
					break;
				case "2":
					$Param2=$Fila["valor_subclase1"];
					break;
				case "3":
					$Param3=$Fila["valor_subclase1"];
					break;
			}
		 }
		 $FechaSep=explode('-',$FDesde);
		 $FechaAM=$FechaSep[0]."-".$FechaSep[1]."-01";
		 $Dia=intval($FechaSep[2]);
		 
	     $FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2],$FechaSep[0]));	
	     $FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]+1,$FechaSep[0]));
		
		$ArrCircGrup=array();
		
	    $Consulta = " select t1.cod_grupo from sec_web.produccion_catodo t1 "; 
		$Consulta.= " where t1.cod_producto='18' and (t1.fecha_produccion between '".$FechaIniTurno."' and '".$FechaFinTurno."') and CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".$FechaIniTurno." 08:00:00' and '".$FechaFinTurno." 07:59:59'";
		//$Consulta.= " AND t1.cod_grupo='07' ";
		$Consulta.= " group by t1.cod_producto, t1.cod_subproducto, t1.cod_grupo ";
		$Consulta.= " order by t1.cod_grupo  ";
		$Resp=mysqli_query($link, $Consulta);
		 while($Fila=mysqli_fetch_assoc($Resp))
		 {
		 	$Circuito=ObtieneCircuito($Fila["cod_grupo"],$link);
			$ArrCircGrup[$Fila["cod_grupo"]]=$Circuito;
		 }
		 reset($ArrCircGrup);
		 ksort($ArrCircGrup);
		 foreach($ArrCircGrup as $Grupo=>$Circuito)
		 {
			$Circuito=$Circuito;
			//echo "Circuito: ".$Circuito."<br>";
			$Grupo=$Grupo;
			$PesoGrupoCom=ObtienePesoProdGrupoCom(18,1,$Grupo,$FDesde,$link);
		 	$TOTPesoGrupoCom=$TOTPesoGrupoCom+$PesoGrupoCom;
			$PesoGrupoDes=ObtienePesoProdGrupoCom(18,5,$Grupo,$FDesde,$link);
		 	$TOTPesoGrupoDes=$TOTPesoGrupoDes+$PesoGrupoDes;
			if($PesoGrupoCom!=0)
			{
				$CubasCom=ObtieneNumCubas2(18,1,$Grupo,$FDesde,$link);
				$CubasDes=ObtieneNumCubas2(18,5,$Grupo,$FDesde,$link);
				$AcumCubasCom=$AcumCubasCom+$CubasCom;
			}
			else
			{
				$CubasCom=0;
				$CubasDes=ObtieneNumCubas2(18,5,$Grupo,$FDesde,$link);
			}
			if(intval($PesoGrupoCom)!=0)
			{
				$PorcRestos=ObtenerPorcRestos($FDesde,$Grupo,$link);
				if($Grupo!='08'&&$Grupo!='49')
					$KAHEfect=ObtenerKAHEfect($Grupo,$FDesde,$link);
				if(intval($Circuito)==4&&$KAHEfect>0)
					$KAHEfect=$KAHEfect/10;
				if($Grupo!='08'&&$Grupo!='49')
					$AcumKAHEfect=$AcumKAHEfect+$KAHEfect;
				//echo "AcumKAHEfect: ".$AcumKAHEfect."<br>";	
				//$EfiCte=0;
				$Valor1=($PesoGrupoCom*1000)-($Param2*$Param3*$CubasCom);
				$Valor2=$Param1*$KAHEfect*$CubasCom;
				if($Valor2>0)
				{
					$EfiCte=($Valor1/$Valor2)*100;
					if($EfiCte>98.5)
						$EfiCte=98.5;
				}
				$TpoDescXRenovAnt=ObtenerTpoDescXRenov($Grupo,$FDesde,'B',$link);
				$TpoDescXRenov=ObtenerTpoDescXRenov($Grupo,$FDesde,'A',$link);
				$TpoDescXParcial=ObtenerTpoDescXParcial($Grupo,$FDesde,$link);
				$TpoDescXRectif=ObtenerTpoDescXRectif($Grupo,$FDesde,$link);
				if($Grupo!='08'&&$Grupo!='49')
					$TpoRealConex=ObtenerTpoRealConex($Grupo,$FDesde,$link);
				else
					$TpoRealConex=0;	
				if($Grupo!='08'&&$Grupo!='49')
					$AcumTpoRealConex=$AcumTpoRealConex+$TpoRealConex;
				$CorrKAH=0;
				if($TpoRealConex>0)
					$CorrKAH=$KAHEfect/$TpoRealConex;
				else
					$CorrKAH=0;
				$EficTpo=0;	
				if($TpoDescXRenovAnt+$TpoDescXRectif+$TpoRealConex+$TpoDescXParcial>0)	
					$EficTpo=($TpoRealConex/($TpoDescXRenovAnt+$TpoDescXParcial+$TpoDescXRectif+$TpoRealConex))*100;
				
				$Pond_KAH_EFIC=0;
				if($Valor2!=''&&$Grupo!='08'&&$Grupo!='49')	
					//$Pond_KAH_EFIC=$Pond_KAH_EFIC+($KAHEfect*(($Valor1/$Valor2)*100));
					$Pond_KAH_EFIC=$Pond_KAH_EFIC+($KAHEfect*($EfiCte));
					
				//echo "Pond_KAH_EFIC: ".$Pond_KAH_EFIC."<br><BR>";
				//if($Grupo!='07'&&$Grupo!='08'&&$Grupo!='49')
				$Pond_KAH_EFIC_TPO=0;
				if($Grupo!='08'&&$Grupo!='49')	
					$Pond_KAH_EFIC_TPO=$Pond_KAH_EFIC_TPO+($KAHEfect*$EficTpo);
			  }
			  else
			  {
			  	$PorcRestos=0;$CorrKAH=0;$KAHEfect=0;$EfiCte=0;$EficTpo=0;$TpoDescXRenov=0;$TpoDescXParcial=0;$TpoDescXRectif=0;$TpoRealConex=0;
			  }	
			  ?>	
			  <tr>
				<td align="right" class="titulo_azul"><?php echo $Circuito;?>&nbsp;</td>
				<td align="right" class="titulo_azul"><?php echo $Grupo;?>&nbsp;</td>
				<td align="right"><?php echo number_format($PesoGrupoCom,3,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($PesoGrupoDes,3,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($CubasCom,0,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($CubasDes,0,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($PorcRestos,1,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($CorrKAH,2,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($KAHEfect,1,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($EfiCte,2,',','.');?></td>
				<td align="right"><?php echo number_format($EficTpo,1,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($TpoDescXRenov,1,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($TpoDescXParcial,1,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($TpoDescXRectif,1,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($TpoRealConex,1,',','.');?>&nbsp;</td>
			  </tr>
			  <?php

	  	}
	  }	  
		if($AcumTpoRealConex>0)
			$AcumCorrKAH=$AcumKAHEfect/$AcumTpoRealConex;
		if($AcumKAHEfect!=0)	
			$AcumEfiCte=1/$AcumKAHEfect*($Pond_KAH_EFIC);
		if($AcumKAHEfect!=0)
			$AcumEfiTpo=1/$AcumKAHEfect*($Pond_KAH_EFIC_TPO);
	  ?>
      <tr class="TituloCabecera">
        <td colspan="2" align="left" class="TituloCabecera">Diario</td>
        <td align="right" class="TituloCabecera"><?php echo number_format($TOTPesoGrupoCom,3,',','.');?>&nbsp;</td>
        <td align="right" class="TituloCabecera"><?php echo number_format($TOTPesoGrupoDes,3,',','.');?>&nbsp;</td>
        <td align="right" class="TituloCabecera"><?php echo number_format($AcumCubasCom,0,',','.');?>&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right" class="TituloCabecera"><?php echo number_format($AcumCorrKAH,2,',','.');?>&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right" class="TituloCabecera"><?php echo number_format($AcumEfiCte,2,',','.');?>&nbsp;</td>
        <td align="right" class="TituloCabecera"><?php echo number_format($AcumEfiTpo,2,',','.');?>&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
    <td width="1%" background="archivos/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="archivos/interior2/form_abajo.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="archivos/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
</table><BR>
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td height="1%"><img src="archivos/interior2/esq1.gif" width="15" height="15"></td>
    <td width="98%" height="15" background="archivos/interior2/form_arriba.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15"></td>
    <td height="1%"><img src="archivos/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/interior2/form_izq.gif"></td>
    <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td colspan="13" align="center" class="TituloCabecera">INFORME ACUMULADO </td>
        </tr>
      <tr>
        <td width="9%" rowspan="2" align="center" class="TituloCabecera">CTO.</td>
        <td width="12%" rowspan="2" align="center" class="TituloCabecera">PROD. CAT.COM. </td>
        <td width="12%" rowspan="2" align="center" class="TituloCabecera">PROD.DESCOB.</td>
        <td colspan="2" align="center" class="TituloCabecera">N&ordm; CUBAS </td>
        <td width="7%" rowspan="2" align="center" class="TituloCabecera">CORRIENTE KAH </td>
        <td width="9%" rowspan="2" align="center" class="TituloCabecera">K.A. Efectivo </td>
        <td width="5%" rowspan="2" align="center" class="TituloCabecera">EFICTE CTE. </td>
        <td width="5%" rowspan="2" align="center" class="TituloCabecera">EFIC. TPO. </td>
        <td colspan="3" align="center" class="TituloCabecera">TIEMPOS DESCONEXION (Hrs)</td>
        <td width="10%" rowspan="2" align="center" class="TituloCabecera">TPO.REAL<br>CONEXION </td>
      </tr>
      <tr>
        <td width="6%" align="center" class="TituloCabecera">COMERC.</td>
        <td width="5%" align="center" class="TituloCabecera">DESCOB.</td>
        <td width="5%" align="center" class="TituloCabecera">X RENOV.</td>
        <td width="5%" align="center" class="TituloCabecera">PARCIAL</td>
        <td width="9%" align="center" class="TituloCabecera">X RECTIF. </td>
      </tr>
      <?php
	  //$Buscar='N';
	  //INFORME ACUMULADO
	  $AcumTOTKAHEfect=0;
	  $AcumTOTPesoGrupoCom=0;
	  $AcumTOTPesoGrupoDes=0;
	  $AcumTOTCubasCom=0;
	  $AcumTOTCubasDes=0;
	  $AcumTOTEfiCte=0;
	  $AcumTOTEfiTpo=0;
	  $AcumTOTTpoDescXRenov=0;
	  $AcumTOTTpoDescXParcial=0;
	  $AcumTOTDescXRectif=0;
	  $AcumTOTRealConex=0;
	    if($Buscar=='S')
		{	
			 $Consulta="select cod_subclase,valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase = '10005'";
			 $Resp=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Resp))
			{
				switch ($Fila["cod_subclase"])
				{
					case "1":
						$Param1=$Fila["valor_subclase1"];
						break;
					case "2":
						$Param2=$Fila["valor_subclase1"];
						break;
					case "3":
						$Param3=$Fila["valor_subclase1"];
						break;
				}
			}
			 $FechaSep=explode('-',$FDesde);
			 $FechaAM=$FechaSep[0]."-".$FechaSep[1]."-01";
			 $Dia=intval($FechaSep[2]);
			 $Consulta="select cod_circuito from ref_web.grupo_electrolitico2 ";
			 //$Consulta.="where cod_circuito='05'";
			 $Consulta.="group by cod_circuito order by cod_circuito ";
			 //echo $Consulta."<br>";
			 $AcumTOTPesoGrupoCom=0;$AcumTOTPesoGrupoDes=0;$AcumTOTCubasCom=0;$AcumTOTCubasDes=0;$AcumTOTKAHEfect=0;$AcumTOTEfiCte=0;
			 $AcumTOTEfiTpo=0;$AcumTOTTpoDescXRenov=0;$AcumTOTTpoDescXParcial=0;$AcumTOTDescXRectif=0;$AcumTOTRealConex=0;
			 $PondTOT_KAH_EFIC=0;$PondTOT_KAH_EFIC_TPO=0;
			 $RespCircuito=mysqli_query($link, $Consulta);$TOTPesoGrupoCom=0;
			while($FilaCircuito=mysqli_fetch_array($RespCircuito))
			{
				$AcumPesoGrupoCom=0;$AcumPesoGrupoDes=0;$AcumCubasCom=0;$AcumCubasDes=0;$AcumKAHEfect=0;$AcumCorrKAH=0;$AcumEfiCte=0;$AcumEfiTpo=0;
				$AcumTpoDescXRenov=0;$AcumTpoDescXParcial=0;$AcumTpoDescXRectif=0;$AcumTpoRealConex=0;$Pond_KAH_EFIC=0;$Pond_KAH_EFIC_TPO=0;
				$Circuito=$FilaCircuito["cod_circuito"];
				?>
				<tr>
					<td align="right" class="titulo_azul"><?php echo $Circuito;?>&nbsp;</td>
				<?php
					 //echo "Circuito: ".$Circuito."<BR>";
					 //echo "Inicio: ".date('Y-m-d G:i:s')."<br>";
					for($i=1;$i<=$Dia;$i++)
					{
						 //echo "----------------------DIA: ".$i."<BR>";
						 $FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$i,$FechaSep[0]));	
	     				 $FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$i+1,$FechaSep[0]));
						 $ArrCircGrup=array();
						 $Consulta = " select t1.cod_grupo from sec_web.produccion_catodo t1 "; 
						 $Consulta.= " where t1.cod_producto='18' and (t1.fecha_produccion between '".$FechaIniTurno."' and '".$FechaFinTurno."') and (CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".$FechaIniTurno." 08:00:00' and '".$FechaFinTurno." 07:59:59')";
						 $Consulta.= " group by t1.cod_producto, t1.cod_subproducto, t1.cod_grupo ";
						 $Consulta.= " order by t1.cod_grupo  ";
						 //echo $Consulta."<br>";
						 $Resp=mysqli_query($link, $Consulta);
						while($Fila=mysqli_fetch_assoc($Resp))
						{
							$CircuitoObt=ObtieneCircuito($Fila["cod_grupo"],$link);
							if($Circuito==$CircuitoObt)
							{
								$ArrCircGrup[$Fila["cod_grupo"]]=$Circuito;
							}
						}
						 reset($ArrCircGrup);
						 ksort($ArrCircGrup);
						foreach ($ArrCircGrup as $Grupo => $CircuitoAux)
						{	
							$FDesdeAux=substr($FDesde,0,7)."-".$i;
							$PesoGrupoCom=ObtienePesoProdGrupoCom(18,1,$Grupo,$FDesdeAux,$link);
							$AcumPesoGrupoCom=$AcumPesoGrupoCom+$PesoGrupoCom;
							$AcumTOTPesoGrupoCom=$AcumTOTPesoGrupoCom+$PesoGrupoCom;
							//echo "Grupo: ".$Grupo."<br>";
							//echo "Inicio Obtiene Peso Prod. Grupo Comercial: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
							$PesoGrupoDes=ObtienePesoProdGrupoCom(18,5,$Grupo,$FDesdeAux,$link);
							//echo "Fin Obtiene Peso Prod. Grupo Comercial: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR><br>";
							$AcumPesoGrupoDes=$AcumPesoGrupoDes+$PesoGrupoDes;
							$AcumTOTPesoGrupoDes=$AcumTOTPesoGrupoDes+$PesoGrupoDes;
							if($PesoGrupoCom!=0)
							{
								$CubasCom=ObtieneNumCubas2(18,1,$Grupo,$FDesdeAux,$link);
								$CubasDes=ObtieneNumCubas2(18,5,$Grupo,$FDesdeAux,$link);
								$AcumCubasCom=$AcumCubasCom+$CubasCom;
								$AcumCubasDes=$AcumCubasDes+$CubasDes;
								$AcumTOTCubasCom=$AcumTOTCubasCom+$CubasCom;
								$AcumTOTCubasDes=$AcumTOTCubasDes+$CubasDes;
							}
							else
							{
								$CubasCom=0;
								$CubasDes=ObtieneNumCubas2(18,5,$Grupo,$FDesdeAux,$link);
								$AcumCubasDes=$AcumCubasDes+$CubasDes;
								$AcumTOTCubasDes=$AcumTOTCubasDes+$CubasDes;
							}
							if(intval($PesoGrupoCom)!=0)
							{
								//echo "Inicio ObtenerKAHEfect: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
								$KAHEfect=ObtenerKAHEfect($Grupo,$FDesdeAux,$link);
								//echo "Fin ObtenerKAHEfect: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
								if(intval($Circuito)==4&&$KAHEfect>0)
									$KAHEfect=$KAHEfect/10;
								if($Grupo!='08'&&$Grupo!='49')
								{	
									//echo $KAHEfect."<br>";
									$AcumKAHEfect=$AcumKAHEfect+$KAHEfect;
									$AcumTOTKAHEfect=$AcumTOTKAHEfect+$KAHEfect;
								}
								$Valor1=($PesoGrupoCom*1000)-($Param2*$Param3*$CubasCom);
								$Valor2=$Param1*$KAHEfect*$CubasCom;
								if($Valor2>0)
								{
									$EfiCte=($Valor1/$Valor2)*100;
									if($EfiCte>98.5)
										$EfiCte=98.5;
								}

								//echo $AcumKAHEfect."<br>";	
								//echo "Inicio ObtenerTpoDescXRenovAnt: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
								$TpoDescXRenovAnt=ObtenerTpoDescXRenov($Grupo,$FDesdeAux,'B',$link);
								//echo "Fin ObtenerTpoDescXRenovAnt: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
								//echo "Inicio ObtenerTpoDescXRenov: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
								$TpoDescXRenov=ObtenerTpoDescXRenov($Grupo,$FDesdeAux,'A',$link);
								//echo "Fin ObtenerTpoDescXRenov: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
								
								$AcumTpoDescXRenov=$AcumTpoDescXRenov+$TpoDescXRenov;
								if($Grupo!='08'&&$Grupo!='49')
									$AcumTOTTpoDescXRenov=$AcumTOTTpoDescXRenov+$TpoDescXRenov;
								//echo "Inicio ObtenerTpoDescXParcial: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
								$TpoDescXParcial=ObtenerTpoDescXParcial($Grupo,$FDesdeAux,$link);
								//echo "Fin ObtenerTpoDescXParcial: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
								$AcumTpoDescXParcial=$AcumTpoDescXParcial+$TpoDescXParcial;
								if($Grupo!='08'&&$Grupo!='49')
									$AcumTOTTpoDescXParcial=$AcumTOTTpoDescXParcial+$TpoDescXParcial;
								//echo "Inicio ObtenerTpoDescXRectif: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
								$TpoDescXRectif=ObtenerTpoDescXRectif($Grupo,$FDesdeAux,$link);
								//echo "Fin ObtenerTpoDescXRectif: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
								$AcumTpoDescXRectif=$AcumTpoDescXRectif+$TpoDescXRectif;
								if($Grupo!='08'&&$Grupo!='49')
									$AcumTOTDescXRectif=$AcumTOTDescXRectif+$TpoDescXRectif;
								//echo "Inicio ObtenerTpoRealConex: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR>";
								$TpoRealConex=ObtenerTpoRealConex($Grupo,$FDesdeAux,$link);
								//echo "Fin ObtenerTpoRealConex: ".$Grupo."   Fecha Hora: ".date('Y-m-d G:i:s')."<BR><br><br>";
								if($Grupo!='08'&&$Grupo!='49')
								{
									$AcumTpoRealConex=$AcumTpoRealConex+$TpoRealConex;
									$AcumTOTRealConex=$AcumTOTRealConex+$TpoRealConex;
								}
								$EficTpo=0;	
								if($TpoDescXRenovAnt+$TpoDescXRectif+$TpoRealConex+$TpoDescXParcial>0)	
									$EficTpo=($TpoRealConex/($TpoDescXRenovAnt+$TpoDescXParcial+$TpoDescXRectif+$TpoRealConex))*100;
								if($Valor2!=''&&$Grupo!='08'&&$Grupo!='49')
								{	
									//$Pond_KAH_EFIC=$Pond_KAH_EFIC+($KAHEfect*(($Valor1/$Valor2)*100));
									$Pond_KAH_EFIC=$Pond_KAH_EFIC+($KAHEfect*($EfiCte));
									//$PondTOT_KAH_EFIC=$PondTOT_KAH_EFIC+($KAHEfect*(($Valor1/$Valor2)*100));
									$PondTOT_KAH_EFIC=$PondTOT_KAH_EFIC+($KAHEfect*($EfiCte));
									
								}
								if($Grupo!='08'&&$Grupo!='49')
								{	
									$Pond_KAH_EFIC_TPO=$Pond_KAH_EFIC_TPO+($KAHEfect*$EficTpo);
									$PondTOT_KAH_EFIC_TPO=$PondTOT_KAH_EFIC_TPO+($KAHEfect*$EficTpo);
								}
							}
							else
							{
								
							}
						}//FIN ARREGLO
					}//FIN FOR								
					if($AcumTpoRealConex>0)
						$AcumCorrKAH=$AcumKAHEfect/$AcumTpoRealConex;
					if($AcumKAHEfect!=0)	
						$AcumEfiCte=1/$AcumKAHEfect*($Pond_KAH_EFIC);
					if($AcumKAHEfect!=0)
						$AcumEfiTpo=1/$AcumKAHEfect*($Pond_KAH_EFIC_TPO);
				?>
				<td align="right"><?php echo number_format($AcumPesoGrupoCom,3,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($AcumPesoGrupoDes,3,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($AcumCubasCom,0,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($AcumCubasDes,0,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($AcumCorrKAH,2,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($AcumKAHEfect,1,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($AcumEfiCte,2,',','.');?></td>
				<td align="right"><?php echo number_format($AcumEfiTpo,1,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($AcumTpoDescXRenov,1,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($AcumTpoDescXParcial,1,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($AcumTpoDescXRectif,1,',','.');?>&nbsp;</td>
				<td align="right"><?php echo number_format($AcumTpoRealConex,1,',','.');?>&nbsp;</td>
			  </tr>
			  <?php
			}//FIN WHILE

	    }//FIN IF BUSCAR	  
	if($AcumTOTKAHEfect!=0)	
		$AcumTOTEfiCte=1/$AcumTOTKAHEfect*($PondTOT_KAH_EFIC);
	if($AcumTOTKAHEfect!=0)
		$AcumTOTEfiTpo=1/$AcumTOTKAHEfect*($PondTOT_KAH_EFIC_TPO);
	?>
	  <tr class="TituloCabecera">
		<td align="left" class="TituloCabecera">Total</td>
		<td align="right" class="TituloCabecera"><?php echo number_format($AcumTOTPesoGrupoCom,3,',','.');?>&nbsp;</td>
		<td align="right" class="TituloCabecera"><?php echo number_format($AcumTOTPesoGrupoDes,1,',','.');?>&nbsp;</td>
		<td align="right" class="TituloCabecera"><?php echo number_format($AcumTOTCubasCom,0,',','.');?>&nbsp;</td>
		<td align="right" class="TituloCabecera"><?php echo number_format($AcumTOTCubasDes,0,',','.');?>&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right" class="TituloCabecera"><?php echo number_format($AcumTOTKAHEfect,1,',','.');?>&nbsp;</td>
		<td align="right" class="TituloCabecera"><?php echo number_format($AcumTOTEfiCte,2,',','.');?>&nbsp;</td>
		<td align="right" class="TituloCabecera"><?php echo number_format($AcumTOTEfiTpo,2,',','.');?>&nbsp;</td>
		<td align="right" class="TituloCabecera"><?php echo number_format($AcumTOTTpoDescXRenov,1,',','.');?>&nbsp;</td>
		<td align="right" class="TituloCabecera"><?php echo number_format($AcumTOTTpoDescXParcial,2,',','.');?>&nbsp;</td>
		<td align="right" class="TituloCabecera"><?php echo number_format($AcumTOTDescXRectif,2,',','.');?>&nbsp;</td>
		<td align="right" class="TituloCabecera"><?php echo number_format($AcumTOTRealConex,2,',','.');?>&nbsp;</td>
	  </tr>
	  </table>
	  </td>
    <td width="1%" background="archivos/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="archivos/interior2/form_abajo.gif"><img src="archivos/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="archivos/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
function ProdAcumReal($CodProd,$CodSubProd,$Tipo,$FechaCons,$link)
{
	$FechaSep=explode('-',$FechaCons);
	
	if($Tipo=='D')
	{
		$FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2] ,$FechaSep[0]));	
		$FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],($FechaSep[2] +1),$FechaSep[0]));
	}
	else
	{
		$FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],1,$FechaSep[0]));	
		$FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],($FechaSep[2] +1),$FechaSep[0]));
	}
	$Consulta = "select ifnull(sum(peso_produccion),0) as peso_prod from sec_web.produccion_catodo t1 ";
	$Consulta.=" where (fecha_produccion between '".$FechaIniTurno."' and '".$FechaFinTurno."') and CONCAT(t1.fecha_produccion,' ',t1.hora) BETWEEN '".$FechaIniTurno." 08:00:00' and '".$FechaFinTurno." 07:59:59'";
	$Consulta.=" and cod_producto='".$CodProd."' ";
	if($CodSubProd!='')
		$Consulta.="and cod_subproducto='".$CodSubProd."' group by cod_producto,cod_subproducto ";
	else
		$Consulta.="group by cod_producto ";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Resp);
	$peso_prod =isset($Fila["peso_prod"])?$Fila["peso_prod"]:0;
	return($peso_prod/1000);
}
function ProdRev($NomSubProd,$FechaCons,$Tipo,$Rev,$link)
{
	$Consulta = "select ".$NomSubProd." as peso_rev from sec_web.det_programa_produccion where fecha_programa='".$FechaCons."' and cod_revision='".$Rev."' ";

	/*if($Tipo=='D')
	{
		$Consulta = "select ".$NomSubProd." as peso_rev from sec_web.det_programa_produccion where fecha_programa='".$FechaCons."' and cod_revision='".$Rev."' ";
	}
	else
	{
		$FechaSep=explode('-',$FechaCons);
		$FechaConsIni=date("Y-m-d", mktime(1,0,0,$FechaSep[1],1,$FechaSep[0]));	
		$Consulta = "select sum(".$NomSubProd.") as peso_rev from sec_web.det_programa_produccion where fecha_programa between '".$FechaConsIni."' and '".$FechaCons."' and cod_revision='".$Rev."' ";
		//echo $Consulta."<br>";
	}*/
	//echo $Consulta."<br>";

	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Resp);
	$peso_rev =isset($Fila["peso_rev"])?$Fila["peso_rev"]:0;
	return($peso_rev);
}
function ObtieneCircuito($Grupo,$link)
{
	if($Grupo=='03'||$Grupo=='04'||$Grupo=='05'||$Grupo=='06')//CASO ESPECIAL CIRCUITO 1 PROVEE LA ENERGIA
	{
		return('04');
	}
	else
	{
		$Consulta = "select cod_circuito from ref_web.grupo_electrolitico2 where cod_grupo='".$Grupo."' order by fecha desc";
		//echo $Consulta."<br>";
		$RespCir = mysqli_query($link, $Consulta);
		if($FilaCir=mysqli_fetch_array($RespCir))
			return($FilaCir["cod_circuito"]);
		else
			return(0);
	}
}
function ObtienePesoProdGrupoCom($CodProd,$CodSubProd,$Grupo,$FechaCons,$link)
{

	$FechaSep=explode('-',$FechaCons);
	$FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2] ,$FechaSep[0]));	
	$FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],($FechaSep[2] +1),$FechaSep[0]));
	$Consulta = "select ifnull(sum(peso_produccion),0) as peso_prod from sec_web.produccion_catodo ";
	$Consulta.=" where (fecha_produccion between '".$FechaIniTurno."' and '".$FechaFinTurno."') and CONCAT(fecha_produccion,' ',hora) BETWEEN '".$FechaIniTurno." 08:00:00' and '".$FechaFinTurno." 07:59:59'";
	$Consulta.=" and cod_producto='".$CodProd."' and cod_subproducto='".$CodSubProd."' and cod_grupo='".$Grupo."' group by cod_producto,cod_subproducto,cod_grupo ";
	//if($Grupo=='33')
	//	echo $Consulta."<br>";
	$RespPeso=mysqli_query($link, $Consulta);
	$FilaPeso=mysqli_fetch_array($RespPeso);
	//echo "PesoProd:".$FilaPeso[peso_prod]."<br>"; 
	$peso_prod = isset($FilaPeso["peso_prod"])?$FilaPeso["peso_prod"]:'';
	if($peso_prod!='')
		return($FilaPeso["peso_prod"]/1000);
	else
		return(0);
}
function ObtieneNumCubas2($CodProd,$CodSubProd,$Grupo,$FechaCons,$link)
{

	$FechaSep=explode('-',$FechaCons);
	$FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2] ,$FechaSep[0]));	
	$FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],($FechaSep[2] +1),$FechaSep[0]));
	$Consulta = "select count(*) as cubas_parcial from sec_web.produccion_catodo ";
	$Consulta.=" where (fecha_produccion between '".$FechaIniTurno."' and '".$FechaFinTurno."') and CONCAT(fecha_produccion,' ',hora) BETWEEN '".$FechaIniTurno." 08:00:00' and '".$FechaFinTurno." 07:59:59'";
	$Consulta.=" and cod_producto='".$CodProd."' and cod_subproducto='".$CodSubProd."' and cod_grupo='".$Grupo."' and cod_lado = 'P' group by cod_producto,cod_subproducto,cod_grupo ";
	//if($Grupo=='33')
	//	echo $Consulta."<br>";
	$RespCuba=mysqli_query($link, $Consulta);
	$FilaCuba=mysqli_fetch_assoc($RespCuba);
	$cubas_parcial = isset($FilaCuba["cubas_parcial"])?$FilaCuba["cubas_parcial"]:'';
	if($cubas_parcial!='')
		$CubasParcial=$FilaCuba["cubas_parcial"];
	else
		$CubasParcial=0;
	$Consulta = "select count(*) as cubas_total from sec_web.produccion_catodo ";
	$Consulta.=" where (fecha_produccion between '".$FechaIniTurno."' and '".$FechaFinTurno."') and CONCAT(fecha_produccion,' ',hora) BETWEEN '".$FechaIniTurno." 08:00:00' and '".$FechaFinTurno." 07:59:59'";
	$Consulta.=" and cod_producto='".$CodProd."' and cod_subproducto='".$CodSubProd."' and cod_grupo='".$Grupo."' and cod_lado = 'T' group by cod_producto,cod_subproducto,cod_grupo ";
	//if($Grupo=='33')
	//	echo $Consulta."<br>";
	$RespCuba=mysqli_query($link, $Consulta);
	$FilaCuba=mysqli_fetch_assoc($RespCuba);
	$cubas_total = isset($FilaCuba["cubas_total"])?$FilaCuba["cubas_total"]:'';
	if($cubas_total!='')
		$CubasTotal=$FilaCuba["cubas_total"];
	else
		$CubasTotal=0;
	return($CubasParcial+$CubasTotal);
}
function ObtieneNumCubas($FechaCons,$Grupo,$Tipo,$link)
{
	$Cubas=0;
	$FechaSep=explode('-',$FechaCons);
	$Fecha=$FechaSep[0]."-".$FechaSep[1]."-01";
	//echo "<br>";
	$Consulta = "select num_catodos_celdas,num_cubas_tot,cubas_descobrizacion from ref_web.grupo_electrolitico2 where fecha='".$Fecha."' and cod_grupo='".$Grupo."'";
	//if($Grupo=='49')
	//	echo $Consulta."  ".$Tipo."<br>";
	$RespCubas=mysqli_query($link, $Consulta);
	if($FilaCubas=mysqli_fetch_array($RespCubas))
	{
		switch($Tipo)
		{
			case 1:
				$Cubas=$FilaCubas["num_catodos_celdas"];
			break;
			case 2:
				$Cubas=$FilaCubas["num_cubas_tot"]-$FilaCubas["fecha_desconexion"];
			break;
			case 3:
				$Cubas=$FilaCubas["fecha_desconexion"];
			break;
		}
	}
	else
	{
		
		$Consulta = "select num_catodos_celdas,num_cubas_tot,cubas_descobrizacion from ref_web.grupo_electrolitico2 where fecha<'".$Fecha."' and cod_grupo='".$Grupo."' order by fecha desc";
		$RespCubas=mysqli_query($link, $Consulta);
		$RespCubas=mysqli_query($link, $Consulta);
		//echo "2 ".$Consulta."<br>";
		if($FilaCubas=mysqli_fetch_array($RespCubas))
		{
			switch($Tipo)
			{
				case 1:
					$Cubas=$FilaCubas["num_catodos_celdas"];
				break;
				case 2:
					$Cubas=$FilaCubas["num_cubas_tot"]-$FilaCubas["fecha_desconexion"];
				break;
				case 3:
					$Cubas=$FilaCubas["fecha_desconexion"];
				break;
			}
			//echo "CUBAS: ".$Cubas."<br>";
		}
	}
	//echo $Grupo."  Cubas: ".$Cubas."<br>";
	return($Cubas);
}
function ObtenerPorcRestos($FechaCons,$Grupo,$link)
{
	$FechaSep=explode('-',$FechaCons);
	$FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-1,$FechaSep[0]));	
	$FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],($FechaSep[2] +1),$FechaSep[0]));
	$FechaIniTurnoHora =$FechaIniTurno." 08:00:00";	
	$FechaFinTurnoHora =$FechaFinTurno." 07:59:59";

	$PorcRestos=0;$ProdRestos=0;$CargaAnod=0;
	
	$Consulta="SELECT ifnull(SUM(peso),0) as peso FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo2=".$Grupo." AND "; 
	$Consulta.="fecha_movimiento BETWEEN '".$FechaIniTurno."' AND '".$FechaFinTurno."' and ";
	$Consulta.="hora between '".$FechaIniTurnoHora."' and '".$FechaFinTurnoHora."' ";
	//echo $Consulta."<br>";
	$RespProdRestos=mysqli_query($link, $Consulta);
	if($FilaProdRestos=mysqli_fetch_array($RespProdRestos))
		$ProdRestos=$FilaProdRestos["peso"];
		
		
	$FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],($FechaSep[2]-17),$FechaSep[0]));	
	$FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],($FechaSep[2]-14),$FechaSep[0]));
	$FechaIniTurnoHora =$FechaIniTurno." 08:00:00";	
	$FechaFinTurnoHora =$FechaFinTurno." 07:59:59";
		
    $Consulta="SELECT ifnull(sum(peso),0) as peso FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17 and campo2 =".$Grupo." AND ";
	$Consulta.="(fecha_movimiento BETWEEN '".$FechaIniTurno."' AND '".$FechaFinTurno."' OR (fecha_benef BETWEEN '".$FechaIniTurno."' AND '".$FechaFinTurno."')) ";
	$Consulta.="and hora between '".$FechaIniTurnoHora."' and '".$FechaFinTurnoHora."'"; 		
	//echo $Consulta."<br>";
	$RespCargaAnod=mysqli_query($link, $Consulta);
	if($FilaCargaAnod=mysqli_fetch_array($RespCargaAnod))
		$CargaAnod=$FilaCargaAnod["peso"];
	
	if($CargaAnod<>0)
		$PorcRestos=($ProdRestos/$CargaAnod) * 100;
	//echo $Grupo."   PorcRestos=(".$ProdRestos."/".$CargaAnod.") * 100<br>"; 	

	return($PorcRestos);
}
function ObtenerKAHEfect($Grupo,$FechaCons,$link)
{
	//echo $FechaCons."<br>";
	$FechaSep=explode('-',$FechaCons);
	$FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-11,$FechaSep[0]));
	$FechaIniTurno2 =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-11,$FechaSep[0]));	
	$FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-1,$FechaSep[0]));
	//$FechaIniTurno='2010-07-25';
	//$FechaFinTurno='2010-07-26';
    $ObtenerKAHEfect=0;$Conect1=0;$Conect2=0;$Parciales=0;
	$Conect5=0;
    $Consulta = "select kahdirc,fecha_conexion from sec_web.cortes_refineria where tipo_desconexion='C' and cod_grupo='".$Grupo."' and fecha_desconexion between '".$FechaIniTurno." 00:00:00' and '".$FechaFinTurno." 07:59:59'";
 	//if($Grupo=='48')   
	//	echo $Consulta."<br>";
	$RespKAH=mysqli_query($link, $Consulta);
    if($FilaKAH=mysqli_fetch_array($RespKAH))
	{
        $Conect1 = $FilaKAH["kahdirc"]/10;
		$FechaIniTurno2=$FilaKAH["fecha_conexion"];
	}
	$FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-1,$FechaSep[0]));	
	$FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]+1,$FechaSep[0]));
	//$FechaIniTurno='2010-08-01';
	//$FechaFinTurno='2010-08-02';
    $Consulta = "select kahdird from sec_web.cortes_refineria where tipo_desconexion='C' and cod_grupo='".$Grupo."' and fecha_desconexion between '".$FechaIniTurno." 07:59:59' and '".$FechaFinTurno." 07:59:59'";
    //if($Grupo=='15')
    //	echo $Consulta."<br>";
	$RespKAH=mysqli_query($link, $Consulta);
    if($FilaKAH=mysqli_fetch_array($RespKAH))
        $Conect2 = $FilaKAH["kahdird"]/10;
    $Consulta = "select kahdird,kahdirc from sec_web.cortes_refineria where tipo_desconexion in ('P','R') and cod_grupo='".$Grupo."' and fecha_desconexion between '".$FechaIniTurno2."'  and '".$FechaFinTurno." 23:59:59'";
    //if($Grupo=='48')
	//	echo $Consulta."<br>";
	$RespKAH=mysqli_query($link, $Consulta);$Parciales=0;
    while($FilaKAH=mysqli_fetch_array($RespKAH))
    {
		//if($Grupo=='07')
		//	echo $Conect3." - ".$Conect4."==".abs($Conect3 - $Conect4)."<br>";
		$Conect3 = $FilaKAH["kahdird"]/10;
		$Conect4 = $FilaKAH["kahdirc"]/10;
		$Parciales = $Parciales + abs($Conect3 - $Conect4);
    }
	 if($Grupo=='07')
	 {
		$FechaIni =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-7,$FechaSep[0]));
		$FechaFin =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-1,$FechaSep[0]));
		
		$Consulta = "select kahdird,kahdirc from sec_web.cortes_refineria where tipo_desconexion='C' and cod_grupo='".$Grupo."' and fecha_desconexion between '".$FechaIni." 00:00:00' and '".$FechaFin." 07:59:59'";
		//echo $Consulta."<br>";
		$RespKAH=mysqli_query($link, $Consulta);
		$Conect5=0;
		if($FilaKAH=mysqli_fetch_array($RespKAH))
		{
			$Conect3 = $FilaKAH["kahdird"]/10;
	 		$Conect4 = $FilaKAH["kahdirc"]/10;
			$Conect5=$Conect4-$Conect3;
	 	}
	 }
	 //if($Grupo=='48')
	 //	echo $Conect2." < ".$Conect1." Parciales ".$Parciales."<br>";
	if($Conect2<$Conect1)
	{
	  	if($Conect1>100000)
		{
			$ObtenerKAHEfect=abs((1000000-abs($Conect1))- abs($Parciales) - abs($Conect5) + $Conect2);		
			//echo ">100000<br>";
		}
		else
		{
			//echo "KAHEfect: abs(".(100000-abs($Conect1)).")- abs(".$Conect1.")- abs(".$Parciales.") - abs(".$Conect5.")<br>";
			$ObtenerKAHEfect=abs((100000-abs($Conect1))- abs($Parciales) - abs($Conect5) + $Conect2);
		}
		//if($Grupo=='48')
		 //echo "KAHEfect: abs(abs(".$Conect2.")- abs(".$Conect1.")- abs(".$Parciales.") - abs(".$Conect5.")<br>";
	 
	}
    else
	 	$ObtenerKAHEfect = abs(abs($Conect2) - abs($Conect1) - abs($Parciales) - abs($Conect5));

	 //echo $ObtenerKAHEfect."<br>";
  	 //PARA LOS GRUPOS ESPECIALES DEL RECTIFICADOR 4 MULTIPLICAR VALOR X 10
	 $Multiplicar='N';
	 $Consulta="select valor_subclase1 as grupos from proyecto_modernizacion.sub_clase where cod_clase = '10006' and cod_subclase='1'";
	 //echo $Consulta."<br>";
	 $RespGE=mysqli_query($link, $Consulta);
	 while($FilaGE=mysqli_fetch_array($RespGE))
	 {
	 	$Valores=explode(',',$FilaGE["grupos"]);
		foreach($Valores as $c => $GE)
	 	{
			//echo "if(intval(".$GE.")==intval(".$Grupo."))<br>";
			if(intval($GE)==intval($Grupo))
			{
				$Multiplicar='S';
				break;
			}
		}
	 }
	 if($Multiplicar=='S')
	 	$ObtenerKAHEfect =$ObtenerKAHEfect * 10;
	 //echo "KAHEfect: ".$ObtenerKAHEfect."<br>";
	 return($ObtenerKAHEfect);
}
function ObtenerTpoDescXRenov($Grupo,$FechaCons,$Tipo,$link)//TIPO:A FECHA ACTUAL , B 8 DIAS ANTES
{
	$Valor=0;
	$FechaSep=explode('-',$FechaCons);
	if($Tipo=='A')
	{
		$FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-1,$FechaSep[0]));	
		$FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]+1,$FechaSep[0]));
	}
	else
	{
		$FechaIniTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-11,$FechaSep[0]));	
		$FechaFinTurno =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-6,$FechaSep[0]));
	}	
	$Consulta="select timediff(fecha_conexion,fecha_desconexion) as hora from sec_web.cortes_refineria ";
	$Consulta.="where fecha_desconexion between '".$FechaIniTurno." 00:00:00' and '".$FechaFinTurno." 07:59:59' and cod_grupo='".$Grupo."' and tipo_desconexion = 'C'";
	//if($Grupo=="20")
	//	echo $Consulta."<br>";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		//echo "TIEMPO:".$Fila["hora"]."<br>";
		$HoraMin=explode(':',$Fila["hora"]);
		$Hora=$HoraMin[0];
		$Min=$HoraMin[1];
		//$Valor=$Hora.".".round((($Min*100)/60)/10);
		$Valor=intval($Hora)+($Min/60);
		
		/*if($Grupo=="20")
		{
			echo "Hora:".$Hora."<br>";
			echo "Min:".$Min."<br>";
			echo "MIN A HORA:".((($Min*100)/60)/10)."<br>";
			echo "Redondeo:".round((($Min*100)/60)/10)."<br>";
			echo "Rs: ".$Valor."<br>";
		}*/
	}
	//if($Tipo=='B')
	//	echo $Valor."<br>"; 
	return($Valor);
}
function ObtenerTpoRealConex($Grupo,$FechaCons,$link)
{
	$Valor=0;
	$timestamp1 = mktime(8, 15, 0, 8, 1, 2010);
	$timestamp2 = mktime(17, 50, 0, 7, 25, 2010);
	// Fecha de Ejemplo 21:00:00 del 14-02-2008
	$diferencia = $timestamp1 - $timestamp2;
	$resultado = diferencia_fechas($diferencia);
	
	$FechaSep=explode('-',$FechaCons);
	$FechaIniTurnoD =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-11,$FechaSep[0]));	
	$FechaFinTurnoD =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-5,$FechaSep[0]));
	$FechaIniTurnoH =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2],$FechaSep[0]));	
	$FechaFinTurnoH =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]+1,$FechaSep[0]));

    $Consulta = "select fecha_conexion from sec_web.cortes_refineria where tipo_desconexion='C' and cod_grupo='".$Grupo."' and fecha_desconexion between '".$FechaIniTurnoD." 00:00:00' and '".$FechaFinTurnoD." 23:59:59' order by fecha_conexion asc";
    //echo $Consulta."<br>";
	$RespFecha=mysqli_query($link, $Consulta);
    if($FilaFecha=mysqli_fetch_array($RespFecha))
	{	
        $FechaIniProc = $FilaFecha["fecha_conexion"];
		$FechaHora=explode(' ',$FechaIniProc);
		$Fecha1=explode('-',$FechaHora[0]);
		$Hora1=explode(':',$FechaHora[1]);
		$timestamp1 = mktime($Hora1[0], $Hora1[1], 0, $Fecha1[1], $Fecha1[2], $Fecha1[0]);
		//if($Grupo=='20')	
		//	echo "FECHA INICIO PROCESO: ".$FechaIniProc."<BR>";
		$Consulta = "select fecha_desconexion from sec_web.cortes_refineria where tipo_desconexion='C' and cod_grupo='".$Grupo."' and fecha_desconexion between '".$FechaIniTurnoH." 00:00:00' and '".$FechaFinTurnoH." 23:59:59' order by fecha_conexion asc";
		//echo $Consulta."<br>";
		$RespFecha=mysqli_query($link, $Consulta);
		$timestamp2=0;
		$FechaFinProc="";
		if($FilaFecha=mysqli_fetch_array($RespFecha))
		{
			$FechaFinProc = $FilaFecha["fecha_desconexion"];
			$FechaHora=explode(' ',$FechaFinProc);
			$Fecha2=explode('-',$FechaHora[0]);
			$Hora2=explode(':',$FechaHora[1]);
			//echo "Fecha:".$Hora2[0]." ".$Hora2[1]." ".$Fecha2[1]." ". $Fecha2[2]." ".$Fecha2[0]."<br>";
			$timestamp2 = mktime($Hora2[0], $Hora2[1], 0, $Fecha2[1], $Fecha2[2], $Fecha2[0]);
		
		}
		//if($Grupo=='20')	
		//	echo "FECHA FIN PROCESO: ".$FechaFinProc."<BR>";

		//echo $timestamp1." - ".$timestamp2."<br>";
		$diferencia = abs($timestamp1 - $timestamp2);
		$resultado = diferencia_fechas($diferencia);
		//if($Grupo=='20')
		//	echo "RESULTADO: ".$resultado."<BR>";
			
		$Hora3=explode(':',$resultado);	
		$CantMin=intval($Hora3[0])*60 + intval($Hora3[1]);
		
			
		//$timestamp3 = mktime($Hora3[0], $Hora3[1], 0, $Fecha2[1], $Fecha2[2], $Fecha2[0]);
		
		
		$Consulta="select fecha_conexion,fecha_desconexion,timediff(fecha_conexion,fecha_desconexion) as hora from sec_web.cortes_refineria ";
		$Consulta.="where fecha_desconexion between '".$FechaIniProc."' and '".$FechaFinProc."' and cod_grupo='".$Grupo."' and tipo_desconexion in ('R','P')";
		//if($Grupo=='40')
		//	echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);$SumHora=0;$SumMin=0;
		while($Fila=mysqli_fetch_array($Resp))
		{
			$HoraMin=explode(':',$Fila["hora"]);
			$Hora=$HoraMin[0];
			$Min=$HoraMin[1];
			$SumHora=$SumHora+$Hora;
			$SumMin=$SumMin+$Min;
		}
		$CantMin2=intval($SumHora)*60 + intval($SumMin);
		$SumHora2=0;//WSO
		$SumMin2=0;//WSO
		if($Grupo=='07')
		{
			$FechaHora=explode(' ',$FechaIniTurnoH);
			$Fecha1=explode('-',$FechaHora[0]);
			$FechaFin=date("Y-m-d", mktime(1,0,0,$Fecha1[1],$Fecha1[2]-1,$Fecha1[0]));
			$FechaHora=explode(' ',$FechaFinTurnoH);
			$Fecha1=explode('-',$FechaHora[0]);
			$FechaIni=date("Y-m-d", mktime(1,0,0,$Fecha1[1],$Fecha1[2]-7,$Fecha1[0]));

			$Consulta="select fecha_conexion,fecha_desconexion,timediff(fecha_conexion,fecha_desconexion) as hora from sec_web.cortes_refineria ";
			$Consulta.="where fecha_desconexion between '".$FechaIni." 00:00:00' and '".$FechaFin." 07:59:59' and cod_grupo='".$Grupo."' and tipo_desconexion in ('C')";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			$SumHora2=0;$SumMin2=0;
			while($Fila=mysqli_fetch_array($Resp))
			{
				$HoraMin=explode(':',$Fila["hora"]);
				$Hora=$HoraMin[0];
				$Min=$HoraMin[1];
				$SumHora2=$SumHora2+$Hora;
				$SumMin2=$SumMin2+$Min;
			}
		}
		$CantMin3=intval($SumHora2)*60 + intval($SumMin2);
		//echo $CantMin3."<br>";
		/*if($Grupo=='34')
		{
			echo "ACUM HORA: ".$SumHora."<br>";
			echo "MIN CAMBIO: ".$CantMin."<br>";
			echo "PARCIAL RECT: ".$CantMin2."<br>";
		}
		
		if($Grupo=='34')
		{
			echo "TOTAL MINUTOS TPO.REAL CONEXION:".$CantMin."<br>";
			echo "TOTAL MINUTOS TPO.DESC.X RECTIF:".$CantMin2."<br>";
			echo "TOTAL MINUTOS:".(($CantMin-$CantMin2)/60)." : ".(($CantMin-$CantMin2)%60)."<br>";
		}*/
		$Valor=(($CantMin-$CantMin2-$CantMin3)/60);
		//if($Grupo=='34')
		//	echo "GRUPO:".$Grupo." - CANT. MIN. ".$SumMin."  ----  ".($SumMin/60)."<BR><br>";
	}
	return($Valor);
}
function restaHoras($horaIni, $horaFin)
{
    return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
}
function RestarHoras($horaini,$horafin)
{
    $horai=substr($horaini,0,2);
    $mini=substr($horaini,3,2);
    //$segi=substr($horaini,6,2);
 
    $horaf=substr($horafin,0,2);
    $minf=substr($horafin,3,2);
    //$segf=substr($horafin,6,2);
 
    $ini=((($horai*60)*60)+($mini*60)/*+$segi*/);
    $fin=((($horaf*60)*60)+($minf*60)/*+$segf*/);
 
    $dif=$fin-$ini;
 
    $difh=floor($dif/3600);
    $difm=floor(($dif-($difh*3600))/60);
    //$difs=$dif-($difm*60)-($difh*3600);
    return date("H:i",mktime($difh,$difm));
    //return date("H-i-s",mktime($difh,$difm,$difs));
}

function ObtenerTpoDescXParcial($Grupo,$FechaCons,$link)
{
	$Valor=0;
	$FechaSep=explode('-',$FechaCons);
	$FechaIniTurnoD =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-11,$FechaSep[0]));	
	$FechaFinTurnoD =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-7,$FechaSep[0]));
	$FechaIniTurnoH =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2],$FechaSep[0]));	
	$FechaFinTurnoH =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]+1,$FechaSep[0]));

    $Consulta = "select fecha_conexion from sec_web.cortes_refineria where tipo_desconexion='C' and cod_grupo='".$Grupo."' and fecha_desconexion between '".$FechaIniTurnoD." 00:00:00' and '".$FechaFinTurnoD." 23:59:59' order by fecha_conexion asc";
    //if($Grupo=='20')
    //	echo $Consulta."<br>";
    $RespFecha=mysqli_query($link, $Consulta);
	$FechaIniProc="";
    if($FilaFecha=mysqli_fetch_array($RespFecha))
        $FechaIniProc = $FilaFecha["fecha_conexion"];
    $Consulta = "select fecha_desconexion from sec_web.cortes_refineria where tipo_desconexion='C' and cod_grupo='".$Grupo."' and fecha_desconexion between '".$FechaIniTurnoH." 00:00:00' and '".$FechaFinTurnoH." 23:59:59' order by fecha_conexion asc";
    //if($Grupo=='40')
    //		echo $Consulta."<br>";
	$RespFecha=mysqli_query($link, $Consulta);
	$FechaFinProc="";
    if($FilaFecha=mysqli_fetch_array($RespFecha))
        $FechaFinProc = $FilaFecha["fecha_desconexion"];
	if($FechaIniProc!=''&&$FechaFinProc!='')
	{	
		$Consulta="select fecha_conexion,fecha_desconexion,timediff(fecha_conexion,fecha_desconexion) as hora from sec_web.cortes_refineria ";
		$Consulta.="where fecha_desconexion between '".$FechaIniProc."' and '".$FechaFinProc."' and cod_grupo='".$Grupo."' and tipo_desconexion = 'P'";
		/*if($Grupo=='04')
		{
			echo "fecha inicio: ".$FechaIniProc."<br>";
			echo "fecha termino: ".$FechaFinProc."<br><br>"; 
		}*/
		//echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);$SumMin=0;
		while($Fila=mysqli_fetch_array($Resp))
		{
			$HoraMin=explode(':',$Fila["hora"]);
			$Hora=$HoraMin[0]*60;
			$Min=$HoraMin[1];
			$SumMin=$SumMin+$Hora+$Min;
		}
		if($SumMin>0)
			$Valor=$SumMin/60;
	}
	return($Valor);
}

function ObtenerTpoDescXRectif($Grupo,$FechaCons,$link)
{
	$Valor=0;
	$FechaSep=explode('-',$FechaCons);
	$FechaIniTurnoD =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-11,$FechaSep[0]));	
	$FechaFinTurnoD =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]-5,$FechaSep[0]));
	$FechaIniTurnoH =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2],$FechaSep[0]));	
	$FechaFinTurnoH =date("Y-m-d", mktime(1,0,0,$FechaSep[1],$FechaSep[2]+1,$FechaSep[0]));

    $Consulta = "select fecha_conexion from sec_web.cortes_refineria where tipo_desconexion='C' and cod_grupo='".$Grupo."' and fecha_desconexion between '".$FechaIniTurnoD." 00:00:00' and '".$FechaFinTurnoD." 23:59:59' order by fecha_conexion asc";
    //echo $Consulta."<br>";
	$RespFecha=mysqli_query($link, $Consulta);
	$FechaIniProc="";
    if($FilaFecha=mysqli_fetch_array($RespFecha))
        $FechaIniProc = $FilaFecha["fecha_conexion"];
    $Consulta = "select fecha_desconexion from sec_web.cortes_refineria where tipo_desconexion='C' and cod_grupo='".$Grupo."' and fecha_desconexion between '".$FechaIniTurnoH." 00:00:00' and '".$FechaFinTurnoH." 23:59:59' order by fecha_conexion asc";
    //echo $Consulta."<br>";
	$RespFecha=mysqli_query($link, $Consulta);
	$FechaFinProc="";
    if($FilaFecha=mysqli_fetch_array($RespFecha))
        $FechaFinProc = $FilaFecha["fecha_desconexion"];
	if($FechaIniProc!=''&&$FechaFinProc!='')
	{	
		$Consulta="select fecha_conexion,fecha_desconexion,timediff(fecha_conexion,fecha_desconexion) as hora from sec_web.cortes_refineria ";
		$Consulta.="where fecha_desconexion between '".$FechaIniProc."' and '".$FechaFinProc."' and cod_grupo='".$Grupo."' and tipo_desconexion = 'R'";
		//if($Grupo=='40')
		//	echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);$SumMin=0;
		while($Fila=mysqli_fetch_array($Resp))
		{
			$HoraMin=explode(':',$Fila["hora"]);
			$Hora=$HoraMin[0]*60;
			$Min=$HoraMin[1];
			$SumMin=$SumMin+$Hora+$Min;
		}
		//if($Grupo=='03')
		//	echo "GRUPO:".$Grupo." - CANT. MIN. ".$SumMin."  ----  ".($SumMin/60)."<BR><br>";
		if($SumMin>0)
			$Valor=$SumMin/60;
	}
	return($Valor);
}
function diferencia_fechas($diferencia)
{
 $segundos = $diferencia % 60;
 $segundos = str_pad($segundos, 2, "0", STR_PAD_LEFT);
 $diferencia = floor($diferencia / 60);
 $minutos = abs($diferencia % 60);
 $minutos = str_pad($minutos, 2, "0", STR_PAD_LEFT);
 $diferencia = floor($diferencia / 60);
 $horas = $diferencia;
 $cadena = $horas.":".$minutos.":".$segundos;
 return $cadena;
}


echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";
?>

