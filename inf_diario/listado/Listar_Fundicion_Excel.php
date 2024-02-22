<?
$Fecha=$ano."-".$mes."-".$dia;
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	color: #000000;
	font-weight: bold;
}
.Estilo2 {color: #000000}
-->
</style>
</head>

<body>

<div align="center"><strong><font color="#000000">Informe Diario  Divisi�n Ventanas</font></font></strong>
  <? include("List_Fundicion.php"); ?>
  <table width="81%" border="1" cellspacing="1" cellpadding="1">
    <tr>
      <td width="32%"><div align="left"><strong>FUNDICI&Oacute;N</strong></div></td>
      <td colspan="2"><div align="center"><font size="2" color="#FFFFFF"><? echo $Fecha ?></font></div>
      <div align="right"></div></td>
      <td width="55%" colspan="3"> <div align="left"><font size="2" color="#FFFFFF"><? echo $Nombre1 ?></font></div></td>
    </tr>
    <tr>
      <td colspan="6"><font size="2"><strong>Convertidor Teniente</strong></font></td>
    </tr>
</table>
	
  <table width="81%" border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td width="32%"><font size="1">Carga Total</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo1 ?></font></div></td>
      <td colspan="2"><font size="1">TMS.</font></td>
      <td colspan="2"><font size="1"><? echo $Campo6 ?></font></td>
    </tr>
    <tr> 
      <td><font size="1">Carga N.U.INY</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo2 ?></font></div></td>
      <td colspan="4"><font size="1">TMS.</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Circulante</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo3 ?></font></div></td>
      <td colspan="4"><font size="1">TMS.</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Tiempo Soplado</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo4 ?></font></div></td>
      <td colspan="2"><font size="1">Hrs.</font><font size="1">&nbsp;</font></td>
      <td width="16%">Acumulado</td>
      <td width="25%"> 
        <? include("Acum_Tiempo_Soplado.php"); ?>
        %</td>
    </tr>
    <tr> 
      <td><font size="1">Tiempo Soplado c/Iny</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo5 ?></font></div></td>
      <td colspan="4"><font size="1">Hrs</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Metal Blanco</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo7 ?></font></div></td>
      <td colspan="4"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Leyes CU M.Blanco</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo8 ?></font></div></td>
      <td colspan="4"><font size="1">%</font><font size="1">&nbsp;</font></td>
    </tr>
</table>
	<table width="81%"  border="1" cellspacing="1" cellpadding="1">
    <tr>
      <td colspan="6"><font size="2"><strong>Horno El&eacute;ctrico</strong> </font>
        <div align="right"></div></td>
    </tr>
</table>
	<table width="81%" border="0" cellspacing="1" cellpadding="1"">
    <tr>
      <td width="32%"><font size="1">Escoria CT Tratada</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo25 ?></font></div></td>
      <td width="55%" colspan="3"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">Circulante</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo26 ?></font></div></td>
      <td colspan="3"><font size="1">T/d&iacute;a</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">Metal Blanco</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo27 ?></font></div></td>
      <td colspan="3"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">Ley CU M. Blanco</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo28 ?></font></div></td>
      <td colspan="3"><font size="1">%</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">Ley CU Escoria</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo29 ?></font></div></td>
      <td colspan="3"><font size="1">%</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">Ley Fe3o4 Escoria</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo30 ?></font></div></td>
      <td colspan="3"><font size="1">%</font><font size="1">&nbsp;</font></td>
    </tr>
</table>
	<table width="81%" border="1" cellspacing="1" cellpadding="1">
    <tr>
      <td colspan="6"><font size="2"><strong>Planta Secado</strong> </font> <div align="right"></div></td>
    </tr>
    </table>
	<table width="81%" border="0" cellspacing="1" cellpadding="1"">
    <tr>
      <td width="32%"><font size="1">Alimentaci&oacute;n Secado</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo9 ?></font></div></td>
      <td colspan="2"><font size="1">TMH</font></td>
      <td width="42%"><font size="1"><? echo $Campo10 ?></font></td>
    </tr>
    <tr>
      <td><font size="1">Tiempo Operaci&oacute;n</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo11 ?></font></div></td>
      <td colspan="3"><font size="1">Hrs.</font><font size="1">&nbsp;</font></td>
    </tr>
</table>
	<table width="81%"  border="1" cellspacing="1" cellpadding="1">
    <tr>
      <td colspan="6"><font size="2"><strong>Convertidores Tradicionales</strong>
        </font> <div align="right"></div></td>
    </tr>
	</table>
	
  <table width="81%" border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td width="32%"><font size="1">Carga Fr&iacute;a (S/Precipitado)</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo12 ?></font></div></td>
      <td colspan="2"><font size="1">TMS</font></td>
      <td width="42%"><font size="1"><? echo $Campo16 ?></font></td>
    </tr>
    <tr> 
      <td><font size="1">Precipitado</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo13 ?></font></div></td>
      <td colspan="3"><font size="1">TMS</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">N&uacute;mero carga C_1</font></td>
      <td width="9%"><div align="right"><font size="1"><? echo $Campo14 ?></font></div></td>
      <td width="4%"><font size="1">D</font></td>
      <td width="4%"><font size="1"><? echo $Campo15 ?></font></td>
      <td width="9%"><font size="1">AC</font></td>
      <td><font size="1"><? echo $Campo17 ?></font></td>
    </tr>
    <tr> 
      <td><font size="1">N&uacute;mero carga C_2</font></td>
      <td><div align="right"><font size="1"><? echo $Campo18 ?></font></div></td>
      <td><font size="1">D</font></td>
      <td><font size="1"><? echo $Campo19 ?></font></td>
      <td><font size="1">AC</font></td>
      <td><font size="1"><? echo $Campo23 ?></font></td>
    </tr>
    <tr> 
      <td><font size="1">N&uacute;mero carga C_3</font></td>
      <td><div align="right"><font size="1"><? echo $Campo20 ?></font></div></td>
      <td><font size="1">D</font></td>
      <td><font size="1"><? echo $Campo21 ?></font></td>
      <td><font size="1">AC</font></td>
      <td><font size="1"><? echo $Campo24 ?></font></td>
    </tr>
    <tr> 
      <td><font size="1">Blister Total Trasp.</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo22 ?></font></div></td>
      <td colspan="3"><font size="1">T/d</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Ollas MB a Pozo</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo31 ?></font></div></td>
      <td colspan="3"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td>Ollas &Oacute;xido a CT</td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo32 ?></font></div></td>
      <td colspan="3">Ollas</td>
    </tr>
    <tr> 
      <td><font size="1">Ollas ox. CPS. a Pozo</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo33 ?></font></div></td>
      <td colspan="3"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Ollas Fund. + Raf a Pozo</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo34 ?></font></div></td>
      <td colspan="3"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
	
		<tr>
	  <td><font size="1">Ollas Scrap</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo37 ?></font></div></td>
	  
    <td colspan="3"><font size="1">Ollas</font><font size="1">/d&nbsp;</font></td>
 	</tr>
	<tr> 
      	  
    <td><font size="1">Tonelaje</font></td>

      <td colspan="2"><div align="right"><font size="1"><? echo $Campo38 ?></font></div></td>
	  
    <td colspan="3"><font size="1">T/d</font></td>

</tr>
</table>
  <? include("List_Refino.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td width="29%"><strong>Refino 
        A Fuego</strong></td>
      <td width="13%"><div align="center"><font size="2" color="#FFFFFF"><? echo $Fecha ?></font></div></td>
      <td colspan="5"><font size="2" color="#FFFFFF"><? echo $Nombre_r ?></font></td>
    </tr>
    <tr> 
      <td colspan="7"><font size="1">Produccion de Vapor</font></td>
    </tr>
    <tr> 
      <td><font size="1">Caldera RAF-1 </font></td>
      <td><div align="right"><font size="1"><? echo $Campo1_r ?></font></div></td>
      <td width="12%"><font size="1">T/Ds</font></td>
      <td><font size="1"><? echo $Campo3_r ?></font></td>
      <td>Acumulado</td>
      <td colspan="2"> 
        <? include("Acum_Calderas_Raf.php"); ?>
        Tons.</td>
    </tr>
    <tr> 
      <td><font size="1">Caldera RAF-2</font></td>
      <td><div align="right"><font size="1"><? echo $Campo2_r ?></font></div></td>
      <td><font size="1">T/ds</font></td>
      <td><font size="1"><? echo $Campo4_r ?></font></td>
      <td>Acumulado</td>
      <td colspan="2"><? echo "$Acum_Raf2"; ?> Tons.</td>
    </tr>
    <tr> 
      <td><div align="center"><font size="1">Programaci&oacute;n de Moldeo</font></div></td>
      <td><div align="center"><font size="1">Hornada/Sol</font></div></td>
      <td><div align="center"><font size="1">Prog.Hrs</font></div></td>
      <td width="11%"><div align="center"><font size="1">Real Hrs</font></div></td>
      <td width="12%"><div align="center"><font size="1">Retraso Hrs</font></div></td>
      <td width="11%"><div align="center"><font size="1">As(PPM)</font></div></td>
      <td width="12%"><div align="center"><font size="1">Sb(PPM)</font></div></td>
    </tr>
    <tr> 
      <td><font size="1">Horno 1</font></td>
      <td><div align="center"><font size="1"><? echo $Campo5_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo9_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo13_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo17_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo21_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo25_r ?></font></div></td>
    </tr>
    <tr> 
      <td><font size="1">Horno 2</font></td>
      <td><div align="center"><font size="1"><? echo $Campo6_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo10_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo14_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo18_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo22_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo26_r ?></font></div></td>
    </tr>
    <tr> 
      <td><font size="1">H. Basculante 1</font></td>
      <td><div align="center"><font size="1"><? echo $Campo7_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo11_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo15_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo19_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo23_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo27_r ?></font></div></td>
    </tr>
    <tr> 
      <td><font size="1">H. Basculante 2</font></td>
      <td><div align="center"><font size="1"><? echo $Campo8_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo12_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo16_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo20_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo24_r ?></font></div></td>
      <td><div align="center"><font size="1"><? echo $Campo28_r ?></font></div></td>
    </tr>
    <tr> 
      <td><font size="1">Ollas Escoria Horno Retenci&oacute;n</font></td>
      <td><div align="right"><font size="1"><? echo $Campo29_r ?></font></div></td>
      <td colspan="5"><font size="1">Ollas</font><font size="1">&nbsp;</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Ollas Escoria Horno Basculante</font></td>
      <td><div align="right"><font size="1"><? echo $Campo30_r ?></font></div></td>
      <td colspan="5"><font size="1">Ollas</font><font size="1">&nbsp;</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td align="center"><font size="1">Producto en proceso RAF</font></td>
      <td><div align="right"></div></td>
      <td colspan="5"><font size="1">&nbsp;</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Horno Ret&eacute;n </font></td>
      <td><div align="right"><font size="1"><? echo $Campo31_r ?></font></div></td>
      <td colspan="5"><font size="1">Ollas</font><font size="1">&nbsp;</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Horno Baculante </font></td>
      <td><div align="right"><font size="1"><? echo $Campo32_r ?></font></div></td>
      <td colspan="5"><font size="1">Ollas</font><font size="1">&nbsp;</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Horno1</font></td>
      <td><div align="right"><font size="1"><? echo $Campo33_r ?></font></div></td>
      <td colspan="5"><font size="1">Ton.</font></td>
    </tr>
    <tr> 
      <td><font size="1">Horno2</font></td>
      <td><div align="right"><font size="1"><? echo $Campo34_r ?></font></div></td>
      <td colspan="5"><font size="1">Ton.</font></td>
    </tr>
    <tr> 
      <td><font size="1">Blister, Restos y Rechazos </font></td>
      <td><div align="right"><font size="1"><? echo $Campo35_r ?></font></div></td>
      <td colspan="5"><font size="1">Ton.</font></td>
    </tr>
	
</table>
  <? include("List_PlantaAcid.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="20%"><span class="Estilo2"><strong><font size="2">Planta de &Aacute;cido</font></strong></span></td>
      <td width="12%"><div align="center" class="Estilo2"><font size="2"><? echo $Fecha ?></font></div></td>
      <td colspan = 3 width="50%"><span class="Estilo2"><font size="2"><? echo $Nombre_a ?></font></span></td>
    </tr>
    <tr>
      <td><span class="Estilo2"><font size="1">Tiempo de Operaci&oacute;n</font></span></td>
      <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo1_a ?></font></div></td>
      <td colspan = 3><span class="Estilo2"><font size="1">Hrs/d&iacute;a</font></span></td>
    </tr>
    <tr>
      <td><span class="Estilo2"><font size="1">Producci&oacute;n</font></span></td>
      <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo2_a ?></font></div></td>
      <td width="15%"><span class="Estilo2"><font size="1">Ton/d&iacute;a</font></span></td>
      <td width="7%">Acumulado</td>
      <td width="17%">
          <? include("Acum_Prod_Acido.php"); ?>
          <? echo number_format($Acum_prod,1,',','')?> Tons.</td>
    </tr>
    <tr>
      <td><span class="Estilo2"><font size="1">Flujo Gases Prom.</font></span></td>
      <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo3_a ?></font></div></td>
      <td><span class="Estilo2"><font size="1">M3/Hrs</font></span></td>
    </tr>
    <tr>
      <td><span class="Estilo2"><font size="1">Conc. SO2 Prom.</font></span></td>
      <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo4_a ?></font></div></td>
      <td><span class="Estilo2"><font size="1">%</font></span></td>
    </tr>
    <tr>
      <td><span class="Estilo2"><font size="1">Conc. &Aacute;cido Prom.(Ayer)</font></span></td>
      <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo5_a ?></font></div></td>
      <td><span class="Estilo2"><font size="1">%</font></span></td>
    </tr>
    <tr>
      <td colspan="3"><div align="left" class="Estilo2"><font size="1">Temperaturas</font></div>
        <div align="right" class="Estilo2"></div></td>
    </tr>
    <tr>
      <td colspan="3"><span class="Estilo2"><font size="1">Descanso Axial </font> </span>        <div align="right" class="Estilo2"></div></td>
    </tr>
    <tr>
      <td><span class="Estilo2"><font size="1">Minima</font></span></td>
      <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo6_a ?></font></div></td>
      <td><span class="Estilo2"><font size="1">&ordm;C</font></span></td>
    </tr>
    <tr>
      <td><span class="Estilo2"><font size="1">M&aacute;xima</font></span></td>
      <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo7_a ?></font></div></td>
      <td><span class="Estilo2"><font size="1">&ordm;C</font></span></td>
    </tr>
    <tr>
      <td><span class="Estilo2"><font size="1">K3 (59.4)</font></span></td>
      <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo8_a ?></font></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span class="Estilo2"><font size="1">K5 (83.8)</font></span></td>
      <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo9_a ?></font></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span class="Estilo2"><font size="1">K6 (89.7)</font></span></td>
      <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo10_a ?></font></div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span class="Estilo2"><font size="1">Purgas &Aacute;cido</font></span></td>
      <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo11_a ?></font></div></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <? include("List_TermOxig.php"); ?>
  <div align="center">
    <table width="81%" border="0" cellspacing="1" cellpadding="1">
      <tr> 
        <td width="32%"><span class="Estilo2"><strong><font size="2">C. 
          T&eacute;rmica y Pta. Oxigeno</font></strong></span></td>
        <td width="12%"><div align="center" class="Estilo2"><font size="2"><? echo $Fecha ?></font></div></td>
        <td colspan="5"><span class="Estilo2"><font size="2"><? echo $Nombre_t ?></font></span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">Producci&oacute;n LOX</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo1_t ?></font></div></td>
        <td colspan="5"><span class="Estilo2"><font size="1">Ton/d&iacute;a</font></span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">Producci&oacute;n GOX</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo2_t ?></font></div></td>
        <td colspan="5"><span class="Estilo2"><font size="1">Ton/d&iacute;a</font></span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">Consumo Real (FQI 165-B)</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo3_t ?></font></div></td>
        <td colspan="5"><span class="Estilo2"><font size="1">Ton/d&iacute;a</font></span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">Nivel BO1</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo4_t ?></font></div></td>
        <td colspan="5"><span class="Estilo2"><font size="1">Lts.</font></span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">Consignas Planta GOX</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo5_t ?></font></div></td>
        <td colspan="5"><span class="Estilo2"><font size="1">KNm3/Hr</font></span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">Consignas Planta LOX</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo6_t ?></font></div></td>
        <td colspan="5"><span class="Estilo2"><font size="1">KNm3/Hr</font></span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">Flujo Turbina (FIC 540)</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo7_t ?></font></div></td>
        <td colspan="5"><span class="Estilo2"><font size="1">KNm3/Hr</font></span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">PDI (540/542)</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo8_t ?></font></div></td>
        <td colspan="5"><span class="Estilo2"><font size="1">Kpa-g</font></span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">Caldera K-3</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo9_t ?></font></div></td>
        <td width="15%"><span class="Estilo2"><font size="1">Ton/d&iacute;a</font></span></td>
        <td width="7%"><span class="Estilo2"><font size="1"><? echo $Campo12_t ?></font></span></td>
        <td width="17%"><span class="Estilo2">Acumulado</span></td>
        <td width="8%"> 
          <span class="Estilo2">
<? include("Acum_Calderas_K.php"); ?>
          <? echo number_format($Acum_K3,1,',','')?></span></td>
        <td width="9%"><span class="Estilo2">Tons.</span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">Caldera K-4</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo10_t ?></font></div></td>
        <td><span class="Estilo2"><font size="1">Ton/d&iacute;a</font></span></td>
        <td><span class="Estilo2"><font size="1"><? echo $Campo13_t ?></font></span></td>
        <td><span class="Estilo2">Acumulado</span></td>
         <td><span class="Estilo2"><? echo number_format($Acum_K4,1,',','') ?></span></td>
        <td><span class="Estilo2">Tons.</span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">Caldera K-5</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo11_t ?></font></div></td>
        <td><span class="Estilo2"><font size="1">Ton/d&iacute;a</font></span></td>
        <td><span class="Estilo2"><font size="1"><? echo $Campo14_t ?></font></span></td>
        <td><span class="Estilo2">Acumulado</span></td>
         <td><span class="Estilo2"><? echo number_format($Acum_K5,1,',','') ?></span></td>
        <td><span class="Estilo2">Tons.</span></td>
      </tr>
      <tr> 
        <td><span class="Estilo2"><font size="1">Factor de Potencia (COSPI) Acum.</font></span></td>
        <td><div align="right" class="Estilo2"><font size="1"><? echo $Campo15_t ?></font></div></td>
        <td colspan="5">&nbsp;</td>
      </tr>
</table>
	<br>
    <table width="81%" border="0" cellspacing="1" cellpadding="1">
      <tr> 
        <td width="32%"><div align="left" class="Estilo2"> 
            <strong><font size="2">Producci&oacute;n/Recepci&oacute;n 
        de &Aacute;nodos</font></strong></div></td>
        <td width="33%"><span class="Estilo2"></span></td>
        <td width="33%"><span class="Estilo2"><strong><font size="2">* 
          Nuevo Sistema </font></strong></span></td>
      </tr>
      <tr> 
        <td width="32%" height="20"><div align="center" class="Estilo2">PRODUCTO</div></td>
        <td width="33%"><div align="center" class="Estilo2">UNIDADES</div></td>
        <td width="33%"><div align="center" class="Estilo2">PESO KG</div></td>
      </tr>
      <?
	  include("conectar48.php");  
	  
	  $consulta = "SELECT distinct flujo FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento = '$Fecha'"; 
      $rs = mysql_query($consulta);	  

	  while($row = mysql_fetch_array($rs))
	  {
            $consulta = "SELECT descripcion FROM proyecto_modernizacion.flujos WHERE cod_flujo = $row["flujo"]";
            $consulta.=" and sistema = 'SEA'";
			$rs1 = mysql_query($consulta);		
				
			if($row1 = mysql_fetch_array($rs1))
			{
				echo'<tr>'; 
					echo'<td height="20">'.$row1["descripcion"].'</td>';

				    $consulta = "SELECT SUM(unidades) as unidades, SUM(peso) as peso FROM sea_web.movimientos WHERE flujo = $row["flujo"] AND fecha_movimiento = '$Fecha'";
	  				$rs2 = mysql_query($consulta);

					if($row2 = mysql_fetch_array($rs2))
					{					
						echo'<td height="20"><center>'.number_format($row2["unidades"],0,",",".").'</center></td>';
						echo'<td height="20"><center>'.number_format($row2["peso"],0,",",".").'</center></td>';
					}

				echo'</tr>';
			}	
			$Total_Unidades_Produccion = $Total_Unidades_Produccion + $row2["unidades"];
			$Total_Peso_Produccion = $Total_Peso_Produccion + $row2["peso"];

	  }
      echo'<tr>';
        echo'<td width="32%"><strong>TOTAL PRODUCCION DE ANODOS</strong></td>';
        echo'<td width="33%"><strong><div align="center">'.number_format($Total_Unidades_Produccion,0,",",".").'</div></strong></td>';
        echo'<td width="35%"><strong><div align="center">'.number_format($Total_Peso_Produccion,0,",",".").'</div></strong></td>';
      echo'</tr>';

	?>
</table>
   <br>
   <table width="81%" border="0" cellspacing="1" cellpadding="1">
      <tr> 
        <td height="17" colspan="5"><div align="left" class="Estilo2"> 
        <strong><font size="2">EXISTENCIA DE ANODOS</font></strong></div></td>
      </tr>
      <tr> 
        <td width="32%" height="20"><div align="center" class="Estilo2">NODO</div></td>
        <td width="17%"><div align="center" class="Estilo2">UNIDADES</div></td>
        <td width="18%"><div align="center" class="Estilo2">PESO PROMEDIO</div></td>
        <td width="33%"><div align="center" class="Estilo2">PESO KG</div></td>
      </tr>
<?
$FechaInicio = $ano."-".$mes."-01";
$FechaConsulta = $ano."-".$mes."-".$dia;

		    
//Corrientes Ventana
	echo'<tr>'; 
		echo'<td height="20">�nodos Corrientes Ventana</td>';

				//STOCK INICIAL
				$consulta = "SELECT sum(unid_fin) as unidades, sum(peso_fin) as peso ";
				$consulta.= " FROM sea_web.stock ";
				$consulta.= " WHERE cod_producto = 17";
				$consulta.= " AND cod_subproducto = 4";
				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
				$consulta.= " AND unid_fin > 0";				
				
				$rs1 = mysql_query($consulta);								
				if ($row1 = mysql_fetch_array($rs1))
				{
					$unidades_aux = $row1["unidades"];
					$peso_aux = $row1["peso"];
				}
				//-------------
				//RECEPCION
					$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 4";
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '1'";
					$rs1 = mysql_query($consulta);
					if ($row1 = mysql_fetch_array($rs1))
					{
						$unidades_aux = $unidades_aux + $row1["unidades"];
						$peso_aux = $peso_aux + $row1["peso"];					
					}
				//-----------------
				///BENEFICIO - RECHAZO
				$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 4";
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in (2,4)";
				$rs1 = mysql_query($consulta);						

				if ($row1 = mysql_fetch_array($rs1))
				{
					$unidades_aux = $unidades_aux - $row1["unidades"];
					$peso_aux = $peso_aux - $row1["peso"];					
				}

				//STOCK FINAL A LA FECHA DE CONSULTA
				echo '<td align="center">'.number_format($unidades_aux,0,",",".").'</td>';
                $peso_prom = $peso_aux / $unidades_aux; 
				echo '<td align="center">'.number_format($peso_prom,0,'','').'</td>';
				echo '<td align="center">'.number_format($peso_aux,0,",",".").'</td>';
				$Acum_peso = $Acum_peso + $peso_aux;
				$Acum_unid = $Acum_unid + $unidades_aux;
				$Acum_prom = $Acum_prom + $peso_prom;
		echo'</tr>';             

//H. Madres Ventana
	$peso_aux = 0;
	$unidades_aux = 0;
	$peso_prom = 0;
	echo'<tr>'; 
		echo'<td height="20">�nodos Hojas Madres Ventana</td>';

				//STOCK INICIAL
				$consulta = "SELECT sum(unid_fin) as unidades, sum(peso_fin) as peso ";
				$consulta.= " FROM sea_web.stock ";
				$consulta.= " WHERE cod_producto = 17";
				$consulta.= " AND cod_subproducto = 8";
				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
				$consulta.= " AND unid_fin > 0";				
				
				$rs1 = mysql_query($consulta);								
				if ($row1 = mysql_fetch_array($rs1))
				{
					$unidades_aux = $row1["unidades"];
					$peso_aux = $row1["peso"];
				}
				//-------------
				//RECEPCION
					$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 8";
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '1'";
					$rs1 = mysql_query($consulta);
					if ($row1 = mysql_fetch_array($rs1))
					{
						$unidades_aux = $unidades_aux + $row1["unidades"];
						$peso_aux = $peso_aux + $row1["peso"];					
					}
				//-----------------
				///BENEFICIO - RECHAZO
				$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 8";
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in (2,4)";
				$rs1 = mysql_query($consulta);						

				if ($row1 = mysql_fetch_array($rs1))
				{
					$unidades_aux = $unidades_aux - $row1["unidades"];
					$peso_aux = $peso_aux - $row1["peso"];					
				}

				//STOCK FINAL A LA FECHA DE CONSULTA
				echo '<td align="center">'.number_format($unidades_aux,0,",",".").'</td>';
                $peso_prom = $peso_aux / $unidades_aux; 
				echo '<td align="center">'.number_format($peso_prom,0,'','').'</td>';
				echo '<td align="center">'.number_format($peso_aux,0,",",".").'</td>';
				$Acum_peso = $Acum_peso + $peso_aux;
				$Acum_unid = $Acum_unid + $unidades_aux;
				$Acum_prom = $Acum_prom + $peso_prom;
		echo'</tr>';             

//Anodos Teniente
	$peso_aux = 0;
	$unidades_aux = 0;
	$peso_prom = 0;
	echo'<tr>'; 
		echo'<td height="20">�nodos Teniente</td>';

				//STOCK INICIAL
				$consulta = "SELECT sum(unid_fin) as unidades, sum(peso_fin) as peso ";
				$consulta.= " FROM sea_web.stock ";
				$consulta.= " WHERE cod_producto = 17";
				$consulta.= " AND cod_subproducto = 2";
				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
				$consulta.= " AND unid_fin > 0";				
				
				$rs1 = mysql_query($consulta);								
				if ($row1 = mysql_fetch_array($rs1))
				{
					$unidades_aux = $row1["unidades"];
					$peso_aux = $row1["peso"];
				}
				//-------------
				//RECEPCION
					$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 2";
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '1'";
					$rs1 = mysql_query($consulta);
					if ($row1 = mysql_fetch_array($rs1))
					{
						$unidades_aux = $unidades_aux + $row1["unidades"];
						$peso_aux = $peso_aux + $row1["peso"];					
					}
				//-----------------
				///BENEFICIO - RECHAZO
				$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 2";
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in (2,4)";
				$rs1 = mysql_query($consulta);						

				if ($row1 = mysql_fetch_array($rs1))
				{
					$unidades_aux = $unidades_aux - $row1["unidades"];
					$peso_aux = $peso_aux - $row1["peso"];					
				}

				//STOCK FINAL A LA FECHA DE CONSULTA*/
				echo '<td align="center">'.number_format($unidades_aux,0,",",".").'</td>';
                $peso_prom = $peso_aux / $unidades_aux; 
				echo '<td align="center">'.number_format($peso_prom,0,'','').'</td>';
				echo '<td align="center">'.number_format($peso_aux,0,",",".").'</td>';
				$Acum_peso = $Acum_peso + $peso_aux;
				$Acum_unid = $Acum_unid + $unidades_aux;
				$Acum_prom = $Acum_prom + $peso_prom;
		echo'</tr>';             

//Anodos Chagres
	$peso_aux = 0;
	$unidades_aux = 0;
	$peso_prom = 0;
	echo'<tr>'; 
		echo'<td height="20">�nodos Chagres</td>';

				//STOCK INICIAL
				$consulta = "SELECT sum(unid_fin) as unidades, sum(peso_fin) as peso ";
				$consulta.= " FROM sea_web.stock ";
				$consulta.= " WHERE cod_producto = 17";
				$consulta.= " AND cod_subproducto = 3";
				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
				$consulta.= " AND unid_fin > 0";				
				
				$rs1 = mysql_query($consulta);								
				if ($row1 = mysql_fetch_array($rs1))
				{
					$unidades_aux = $row1["unidades"];
					$peso_aux = $row1["peso"];
				}
				//-------------
				//RECEPCION
					$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 3";
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '1'";
					$rs1 = mysql_query($consulta);
					if ($row1 = mysql_fetch_array($rs1))
					{
						$unidades_aux = $unidades_aux + $row1["unidades"];
						$peso_aux = $peso_aux + $row1["peso"];					
					}
				//-----------------
				///BENEFICIO - RECHAZO
				$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 3";
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in (2,4)";
				$rs1 = mysql_query($consulta);						

				if ($row1 = mysql_fetch_array($rs1))
				{
					$unidades_aux = $unidades_aux - $row1["unidades"];
					$peso_aux = $peso_aux - $row1["peso"];					
				}

				//STOCK FINAL A LA FECHA DE CONSULTA
				echo '<td align="center">'.number_format($unidades_aux,0,",",".").'</td>';
                $peso_prom = $peso_aux / $unidades_aux; 
				echo '<td align="center">'.number_format($peso_prom,0,'','').'</td>';
				echo '<td align="center">'.number_format($peso_aux,0,",",".").'</td>';
				$Acum_peso = $Acum_peso + $peso_aux;
				$Acum_unid = $Acum_unid + $unidades_aux;
				$Acum_prom = $Acum_prom + $peso_prom;

		echo'</tr>';             

//Anodos HVL
	$peso_aux = 0;
	$unidades_aux = 0;
	$peso_prom = 0;
	echo'<tr>'; 
		echo'<td height="20">�nodos HVL</td>';

				//STOCK INICIAL
				$consulta = "SELECT sum(unid_fin) as unidades, sum(peso_fin) as peso ";
				$consulta.= " FROM sea_web.stock ";
				$consulta.= " WHERE cod_producto = 17";
				$consulta.= " AND cod_subproducto = 1";
				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
				$consulta.= " AND unid_fin > 0";				
				//echo $consulta;
				
				$rs1 = mysql_query($consulta);								
				if ($row1 = mysql_fetch_array($rs1))
				{
					$unidades_aux = $row1["unidades"];
					$peso_aux = $row1["peso"];
				}
				//-------------
				//RECEPCION
					$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 1";
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '1'";
					$rs1 = mysql_query($consulta);
					if ($row1 = mysql_fetch_array($rs1))
					{
						$unidades_aux = $unidades_aux + $row1["unidades"];
						$peso_aux = $peso_aux + $row1["peso"];					
					}
				//-----------------
				///BENEFICIO - RECHAZO
				$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 1";
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in (2,4)";
				$rs1 = mysql_query($consulta);						

				if ($row1 = mysql_fetch_array($rs1))
				{
					$unidades_aux = $unidades_aux - $row1["unidades"];
					$peso_aux = $peso_aux - $row1["peso"];					
				}

				//STOCK FINAL A LA FECHA DE CONSULTA
				echo '<td align="center">'.number_format($unidades_aux,0,",",".").'</td>';
                $peso_prom = $peso_aux / $unidades_aux; 
				echo '<td align="center">'.number_format($peso_prom,0,'','').'</td>';
				echo '<td align="center">'.number_format($peso_aux,0,",",".").'</td>';
				$Acum_peso = $Acum_peso + $peso_aux;
				$Acum_unid = $Acum_unid + $unidades_aux;
				$Acum_prom = $Acum_peso / $Acum_unid;
		echo'</tr>';             
             	        
      echo'<tr>';
        echo'<td width="32%"><strong>Total Existencia</strong></td>';
        echo'<td width="17%"><strong><div align="center">'.number_format($Acum_unid,0,",",".").'</div></strong></td>';
        echo'<td width="18%"><strong><div align="center">'.number_format($Acum_prom,0,",",".").'</div></strong></td>';
        echo'<td width="32%"><strong><div align="center">'.number_format($Acum_peso,0,",",".").'</div></strong></td>';
      echo'</tr>';

	?>
</table>
	<br>
   <table  width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#F4D284">
  <tr >
    <td height="100%" colspan="5" bgcolor="#6666CC"><div align="left"><strong></strong>
            <strong><font color="#FFFFFF" size="2">PRODUCCION DE CATODOS</font></strong></div></td>
  <td width="150"   height="20" bgcolor="#6666CC"><div align="LEFT"></td>
</tr>

    <td width="12%" height="20" bgcolor="#33ccff"><div align="LEFT">DIA</td>
    <td width="64"  height="20" bgcolor="#33ccff"><div align="LEFT" >PROD.</td>
    <td width="80"  height="20" bgcolor="#33ccff"><div align="LEFT">DESCRIPCION</td>
    <td width="52"  height="20" bgcolor="#33ccff"><div align="LEFT">GRUPO</td>
  <td width="74"   height="20" bgcolor="#33ccff"><div align="LEFT">TOT-PESO</td>
  <td width="100"   height="20" bgcolor="#33ccff"><div align="LEFT"></td>
  </tr>
<?
  $Consulta = " select distinct t1.fecha_produccion, t1.cod_producto, t2.cod_subproducto, t2.descripcion, t1.cod_grupo ";
	$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2 ";
	$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto  ";
	$Consulta.= " where t1.fecha_produccion BETWEEN '".$FechaConsulta."' and '".$FechaConsulta."' ";
	$Consulta.= " group by  t1.fecha_produccion, t1.cod_producto, t2.cod_subproducto, t1.cod_grupo ";
	$Consulta.= " order by  t1.fecha_produccion, t1.cod_producto, t2.cod_subproducto, t1.cod_grupo  ";
	$Respuesta = mysql_query($Consulta);
		$TotPesoGrupo = 0;
	while ($Fila = mysql_fetch_array($Respuesta))
  	{
		echo "<tr>\n";
		echo "<td>".substr($Fila["fecha_produccion"],8,2)."/".substr($Fila["fecha_produccion"],5,2)."/".substr($Fila["fecha_produccion"],0,4)."</td>\n";
		echo "<td>".$Fila["cod_producto"]."</td>\n";
		echo "<td>".$Fila["descripcion"]."</td>\n";
		echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n" ;
          $producto=$Fila["cod_producto"];
   		$Consulta = " select t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, ";
		$Consulta.= " ifnull(sum(t1.peso_produccion),0) as peso ";
		$Consulta.= " from sec_web.produccion_catodo t1 ";
		$Consulta.= " where t1.fecha_produccion = '".$Fila["fecha_produccion"]."' ";
		$Consulta.= " and t1.cod_producto = '".$Fila["cod_producto"]."' and t1.cod_subproducto = '".$Fila["cod_subproducto"]."' ";
		$Consulta.= " and t1.cod_grupo = '".$Fila["cod_grupo"]."'";
        $Consulta.= " group by  t1.fecha_produccion, t1.cod_producto, t1.cod_subproducto, t1.cod_grupo ";
		$Respuesta2 = mysql_query($Consulta);
		if ($Fila2 = mysql_fetch_array($Respuesta2))
		{
			echo "<td align='right'>".number_format($Fila2["peso"],0,",",".")."</td>\n";
     		$TotPesoGrupo = $TotPesoGrupo + $Fila2["peso"];

	}
		else
		{
			echo "<td>&nbsp;</td>\n";

 	}  		echo "</tr>\n";
}         	echo "</tr>";
   		echo "<td width=600'><STRONG>TOTAL PRODUCCION</TD>  ";
 			echo "<td >&nbsp;</td>\n";
    		echo "<td >&nbsp;</td>\n";
  		echo "<td >&nbsp;</td>\n";
    echo "<td align='right'>".number_format($TotPesoGrupo,0,",",".")."</td>\n";

?>

<div align="center">
  <? include("List_Novedades_Fund.php"); ?>
   <table width="81%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="32%"><span class="Estilo2"><strong><font size="2">Novedades
        Fundici&oacute;n </font></strong></span></td>
      <td width="12%"><div align="center" class="Estilo2"><font size="2"><? echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2"><span class="Estilo2"><font size="2"><? echo $Nombre_f ?></font></span></td>
    </tr>
    <tr>
      <td height="20" colspan="3"><div align="left" class="Estilo2"><font size="2"><? echo nl2br($Texto_f) ?></font></div></td>
    </tr>
  </table>
  <? include("List_Novedades_Refino.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="32%"><span class="Estilo2"><strong><font size="2">Novedades
        Refino a Fuego</font></strong></span></td>
      <td width="12%"><div align="center" class="Estilo2"><font size="2"><? echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2"><span class="Estilo2"><font size="2"><? echo $Nombre_r ?></font></span></td>
    </tr>
    <tr>
      <td height="20" colspan="3"><div align="left" class="Estilo2"><font size="2"><? echo nl2br($Texto_r) ?></font></div></td>
    </tr>
  </table>
  <? include("List_Novedades_PlantaAcid.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="32%"><span class="Estilo2"><strong><font size="2">Novedades
        Planta de &Aacute;cido</font></strong></span></td>
      <td width="12%"><div align="center" class="Estilo2"><font size="2"><? echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2"><span class="Estilo2"><font size="2"><? echo $Nombre_a ?></font></span></td>
    </tr>
    <tr>
      <td height="20" colspan="3"><div align="left" class="Estilo2"><font size="2"><? echo nl2br($Texto_a) ?></font></div></td>
    </tr>
  </table>

<? include("List_Novedades_TermOxig.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="32%"><span class="Estilo2"><strong><font size="2">Novedades
        C. T&eacute;rmica y Pta Oxig</font></strong></span></td>
      <td width="12%"><div align="center" class="Estilo2"><font size="2"><? echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2"><span class="Estilo2"><font size="2"><? echo $Nombre_t ?></font></span></td>
    </tr>
    <tr>
      <td height="22" colspan="3"><div align="left" class="Estilo2"><font size="2"><? echo nl2br($Texto_t) ?></font></div></td>
    </tr>
  </table>
  <? include("List_Novedades_Refineria.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td width="32%"><span class="Estilo2"><strong><font size="2">Novedades 
        Refineria Electrolitica</font></strong></span></td>
      <td width="12%"><div align="center" class="Estilo2"><font size="2"><? echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2"><span class="Estilo2"><font size="2"><? echo $Nombre_ref ?></font></span></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><div align="left" class="Estilo2"><font size="2"><? echo nl2br($Texto_ref) ?></font></div></td>
    </tr>
  </table>
  
  <? include("List_Novedades_Prod_Met.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr> 
      <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Novedades 
        Productos Metal�rgicos</font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><? echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><? echo $Nombre_Prod_Met ?></font></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><div align="left"><font size="2"><? echo nl2br($Texto_Prod_Met) ?></font></div></td>
    </tr>
  </table>

  
   <? include("List_Novedades_Prod_Finales.php"); ?>
   <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr> 
      <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Novedades 
        Productos Finales</font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><? echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><? echo $Nombre_Prod_Finales ?></font></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><div align="left"><font size="2"><? echo nl2br($Texto_Prod_Finales) ?></font></div></td>
    </tr>
  </table>

  
  
  
  
  
  
  
  <? include("List_Novedades_seguridad.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td width="32%"><span class="Estilo2"><strong><font size="2">Novedades 
        Seguridad Industrial y Emergencia</font></strong></span></td>
      <td width="12%"><div align="center" class="Estilo2"><font size="2"><? echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2"><span class="Estilo2"><font size="2"><? echo $Nombre_seg ?></font></span></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><div align="left" class="Estilo2"><font size="2"><? echo nl2br($Texto_seg) ?></font></div></td>
    </tr>
  </table>
   <? include("List_Novedades_policlinico.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td width="32%"><span class="Estilo2"><strong><font size="2">Novedades
        Policlinico</font></strong></span></td>
      <td width="12%"><div align="center" class="Estilo2"><font size="2"><? echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2"><span class="Estilo2"><font size="2"><? echo $Nombre_pol ?></font></span></td>
    </tr>
    <tr>
      <td height="20" colspan="3"><div align="left" class="Estilo2"><font size="2"><? echo nl2br($Texto_pol) ?></font></div></td>
    </tr>
  </table>
  
  <? include("List_Observaciones_Mant.php"); ?>
  <table width="81%"  border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td width="32%"><span class="Estilo1"><font size="2">Novedades 
        de Mantenci&oacute;n </font></span></td>
      <td width="12%"><div align="center" class="Estilo2"><font size="2"><? echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2"><span class="Estilo2"></span></td>
    </tr>
    <tr> 
      <td height="20"><span class="Estilo2"><strong>Turno A</strong></span></td>
      <td height="20"><span class="Estilo2"></span></td>
      <td height="20"><span class="Estilo2"><font size="2">
        <? include("conectar47.php");  
	  
	  $Rut_bus = $Rut_A; 
	  
	  	 $sql2 = "SELECT * FROM funcionarios WHERE rut LIKE '$Rut_bus' ";
        $result2 = mysql_query($sql2);
		 if($row = mysql_fetch_array($result2))
		 {
		  $apellido_p = $row["apellido_paterno"]; 
		  $apellido_m = $row["apellido_materno"]; 
  		  $nombres = $row["nombres"]; 
		  $Nombre_A= "$apellido_p $apellido_m $nombres"; 
		 } 
		  echo strtoupper($Nombre_A);
	  ?>
        </font></span></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><span class="Estilo2"><font size="2"><? echo nl2br($Observacion_A) ?></font></span></td>
    </tr>
    <tr> 
      <td height="20"><span class="Estilo2"><strong>Turno B</strong></span></td>
      <td height="20"><span class="Estilo2"></span></td>
      <td height="20"><span class="Estilo2"><font size="2">
        <? 
	  
	  $Rut_bus = $Rut_B; 
	  
	  	 $sql2 = "SELECT * FROM funcionarios WHERE rut LIKE '$Rut_bus' ";
        $result2 = mysql_query($sql2);
		 if($row = mysql_fetch_array($result2))
		 {
		  $apellido_p = $row["apellido_paterno"]; 
		  $apellido_m = $row["apellido_materno"]; 
  		  $nombres = $row["nombres"]; 
		  $Nombre_B= "$apellido_p $apellido_m $nombres"; 
		 } 
		  echo strtoupper($Nombre_B);
	  ?>
        </font></span></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><span class="Estilo2"><font size="2"><? echo nl2br($Observacion_B) ?></font></span></td>
    </tr>
    <tr> 
      <td height="20"><span class="Estilo2"><strong>Turno C</strong></span></td>
      <td height="20"><span class="Estilo2"></span></td>
      <td height="20"><span class="Estilo2"><font size="2">
        <? 
	  
	  $Rut_bus = $Rut_C; 
	  
	  	 $sql2 = "SELECT * FROM funcionarios WHERE rut LIKE '$Rut_bus' ";
        $result2 = mysql_query($sql2);
		 if($row = mysql_fetch_array($result2))
		 {
		  $apellido_p = $row["apellido_paterno"]; 
		  $apellido_m = $row["apellido_materno"]; 
  		  $nombres = $row["nombres"]; 
		  $Nombre_C= "$apellido_p $apellido_m $nombres"; 
		 }
		  echo strtoupper($Nombre_C);
	  ?>
        </font></span></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><span class="Estilo2"><font size="2"><? echo nl2br($Observacion_C) ?></font></span></td>
    </tr>
    <tr> 
      <td height="20"><span class="Estilo2"><strong>Turno V</strong></span></td>
      <td height="20"><span class="Estilo2"></span></td>
      <td height="20"><span class="Estilo2"><font size="2">
        <? 
	  
	  $Rut_bus = $Rut_V; 
	  
	  	 $sql2 = "SELECT * FROM funcionarios WHERE rut LIKE '$Rut_bus' ";
        $result2 = mysql_query($sql2);
		 if($row = mysql_fetch_array($result2))
		 {
		  $apellido_p = $row["apellido_paterno"]; 
		  $apellido_m = $row["apellido_materno"]; 
  		  $nombres = $row["nombres"]; 
		  $Nombre_V= "$apellido_p $apellido_m $nombres"; 
		 } 
		  echo "$Nombre_V";
	  ?>
        </font></span></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><div align="left" class="Estilo2"><font size="2"><? echo nl2br($Observacion_V) ?></font></div></td>
    </tr>
  </table>
</div>
</body>
</html>

