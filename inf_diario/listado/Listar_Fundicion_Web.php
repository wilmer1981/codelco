<?php
	$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";
	$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
	$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";	
	
	$Fecha =$ano."-".$mes."-".$dia;
?>
	
<html>
<head>
<title>Informe Diario</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-size: 12;
	font-weight: bold;
	color: #FF6600;
}
-->
</style>
</head>

<body background="../imagenes/fondo3.gif">

<div align="center"><span class="Estilo1"></font></span>
<table width="81%" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td align="center"> <span class="Estilo1">INFORME DIARIO DIVISI&Oacute;N VENTANAS</span></td>
  </tr>
  <tr>
    <td align="center"><a href="JavaScript:window.print();"></a>
      <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="window.print()">
      <?php include("List_Fundicion.php"); ?>
<input name="BtnVolver2" type="button" id="BtnVolver2" value="Volver" style="width:70px " onClick="history.back();"></td>
  </tr>
</table>  
<br>
<br>
<table width="81%" bgcolor="#CCCCCC" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td width="32%" bgcolor="#b26c4a"><div align="left"><strong><font color="#FFFFFF" size="2">FUNDICI&Oacute;N</font></strong></div></td>
      <td colspan="2" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha; ?></font></div>
        <div align="right"></div></td>
      <td width="55%" colspan="3" bgcolor="#b26c4a"> <div align="left"><font size="2" color="#FFFFFF"><?php echo $Nombre1 ?></font></div></td>
    </tr>
    <tr>
      <td colspan="6"><font size="2"><strong>Convertidor Teniente</strong></font></td>
    </tr>
</table>
	
  <table width="81%" border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
    <tr> 
      <td width="32%"><font size="1">Carga Total</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo1; ?></font></div></td>
      <td colspan="2"><font size="1">TMS.</font></td>
      <td colspan="2"><font size="1"><?php echo $Campo6 ?></font></td>
    </tr>
    <tr> 
      <td><font size="1">Carga N.U.INY</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo2 ?></font></div></td>
      <td colspan="4"><font size="1">TMS.</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Circulante</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo3 ?></font></div></td>
      <td colspan="4"><font size="1">TMS.</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Tiempo Soplado</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo4 ?></font></div></td>
      <td colspan="2"><font size="1">Hrs.</font><font size="1">&nbsp;</font></td>
      <td width="16%">Acumulado</td>
      <td width="25%"> 
        <?php include("Acum_Tiempo_Soplado.php"); ?>
        %</td>
    </tr>
    <tr> 
      <td><font size="1">Tiempo Soplado c/Iny</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo5 ?></font></div></td>
      <td colspan="4"><font size="1">Hrs</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Metal Blanco</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo7 ?></font></div></td>
      <td colspan="4"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Escoria CT</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo35 ?></font></div></td>
      <td colspan="4"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Leyes CU M.Blanco</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo8 ?></font></div></td>
      <td colspan="4"><font size="1">%</font><font size="1">&nbsp;</font></td>
    </tr>
</table>
	<table width="81%" bgcolor="#CCCCCC"  border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td colspan="6"><font size="2"><strong>Horno El&eacute;ctrico</strong> </font>
        <div align="right"></div></td>
    </tr>
</table>
	<table width="81%" border="0" cellspacing="1" cellpadding="1" bgcolor="#FFFFFF"">
    <tr>
      <td width="32%"><font size="1">Escoria CT Tratada</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo25 ?></font></div></td>
      <td width="55%" colspan="3"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">Circulante</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo26 ?></font></div></td>
      <td colspan="3"><font size="1">T/d&iacute;a</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">Metal Blanco</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo27 ?></font></div></td>
      <td colspan="3"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">Ley CU M. Blanco</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo28 ?></font></div></td>
      <td colspan="3"><font size="1">%</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">Ley CU Escoria</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo29 ?></font></div></td>
      <td colspan="3"><font size="1">%</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">Ley Fe3o4 Escoria</font></td>
      <td colspan="2" align="right"><font size="1"><?php echo $Campo30 ?></font></td>
      <td colspan="3"><font size="1">%</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td>Escoria HETE </td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo36 ?></font></div></td>
      <td colspan="3">Ollas</td>
    </tr>
</table>
	<table width="81%" bgcolor="#CCCCCC" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td colspan="6"><font size="2"><strong>Planta Secado</strong> </font> <div align="right"></div></td>
    </tr>
</table>
	<table width="81%" border="0" cellspacing="1" cellpadding="1" bgcolor="#FFFFFF"">
    <tr>
      <td width="32%"><font size="1">Alimentaci&oacute;n Secado</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo9 ?></font></div></td>
      <td colspan="2"><font size="1">TMH</font></td>
      <td width="42%"><font size="1"><?php echo $Campo10 ?></font></td>
    </tr>
    <tr>
      <td><font size="1">Tiempo Operaci&oacute;n</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo11 ?></font></div></td>
      <td colspan="3"><font size="1">Hrs.</font><font size="1">&nbsp;</font></td>
    </tr>
</table>
	<table width="81%" bgcolor="#CCCCCC"  border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td colspan="6"><font size="2"><strong>Convertidores Tradicionales</strong>
        </font> <div align="right"></div></td>
    </tr>
</table>
	
  <table width="81%" border="0" cellspacing="1" cellpadding="1" bgcolor="#FFFFFF">
    <tr> 
      <td width="32%"><font size="1">Carga Fr&iacute;a (S/Precipitado)</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo12 ?></font></div></td>
      <td colspan="2"><font size="1">TMS</font></td>
      <td width="42%"><font size="1"><?php echo $Campo16 ?></font></td>
    </tr>
    <tr> 
      <td><font size="1">Precipitado</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo13 ?></font></div></td>
      <td colspan="3"><font size="1">TMS</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">N&uacute;mero carga C_1</font></td>
      <td width="9%"><div align="right"><font size="1"><?php echo $Campo14 ?></font></div></td>
      <td width="4%"><font size="1">D</font></td>
      <td width="4%"><font size="1"><?php echo $Campo15 ?></font></td>
      <td width="9%"><font size="1">AC</font></td>
      <td><font size="1"><? echo $Campo17 ?></font></td>
    </tr>
    <tr>   
      <td><font size="1">N&uacute;mero carga C_2</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo18 ?></font></div></td>
      <td><font size="1">D</font></td>
      <td><font size="1"><?php echo $Campo19 ?></font></td>
      <td><font size="1">AC</font></td>
      <td><font size="1"><?php echo $Campo23 ?></font></td>
    </tr>
    <tr> 
      <td><font size="1">N&uacute;mero carga C_3</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo20 ?></font></div></td>
      <td><font size="1">D</font></td>
      <td><font size="1"><?php echo $Campo21 ?></font></td>
      <td><font size="1">AC</font></td>
      <td><font size="1"><?php echo $Campo24 ?></font></td>
    </tr>
    <tr> 
      <td><font size="1">Blister Total Trasp.</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo22 ?></font></div></td>
      <td colspan="3"><font size="1">T/d</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Ollas MB a Pozo</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo31 ?></font></div></td>
      <td colspan="3"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td>Ollas &Oacute;xido a CT</td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo32 ?></font></div></td>
      <td colspan="3">Ollas</td>
    </tr>
    <tr> 
      <td><font size="1">Ollas ox. CPS. a Pozo</font></td>
      <td colspan="2"><div align="right"><font size="1"><? echo $Campo33 ?></font></div></td>
      <td colspan="3"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Ollas Fund. + Raf a Pozo</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo34 ?></font></div></td>
      <td colspan="3"><font size="1">Ollas</font><font size="1">&nbsp;</font></td>
    </tr>
	
		<tr>
	  <td><font size="1">Ollas Scrap</font></td>
      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo37 ?></font></div></td>
	  
    <td colspan="3"><font size="1">Ollas</font><font size="1">/d&nbsp;</font></td>
 	</tr>
	<tr> 
      	  
    <td><font size="1">Tonelaje</font></td>

      <td colspan="2"><div align="right"><font size="1"><?php echo $Campo38 ?></font></div></td>
	  
    <td colspan="3"><font size="1">T/d</font></td>

</tr>
	
	
	
	
</table>
  <?php include("List_Refino.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr> 
      <td width="29%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Refino 
        A Fuego</font></strong></td>
      <td width="13%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td colspan="5" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><?php echo $Nombre_r ?></font></td>
    </tr>
    <tr> 
      <td colspan="7"><font size="1">Produccion de Vapor</font></td>
    </tr>
    <tr> 
      <td><font size="1">Caldera RAF-1 </font></td>
      <td><div align="right"><font size="1"><?php echo $Campo1_r ?></font></div></td>
      <td width="12%"><font size="1">T/Ds</font></td>
      <td><font size="1"><?php echo $Campo3_r ?></font></td>
      <td>Acumulado</td>
      <td colspan="2"> 
        <?php include("Acum_Calderas_Raf.php"); ?>
        Tons.</td>
    </tr>
    <tr> 
      <td><font size="1">Caldera RAF-2</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo2_r ?></font></div></td>
      <td><font size="1">T/ds</font></td>
      <td><font size="1"><?php echo $Campo4_r ?></font></td>
      <td>Acumulado</td>
      <td colspan="2"><?php echo "$Acum_Raf2"; ?> Tons.</td>
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
      <td><div align="center"><font size="1"><?php echo $Campo5_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo9_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo13_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo17_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo21_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo25_r ?></font></div></td>
    </tr>
    <tr> 
      <td><font size="1">Horno 2</font></td>
      <td><div align="center"><font size="1"><?php echo $Campo6_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo10_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo14_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo18_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo22_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo26_r ?></font></div></td>
    </tr>
    <tr> 
      <td><font size="1">H. Basculante 1</font></td>
      <td><div align="center"><font size="1"><?php echo $Campo7_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo11_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo15_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo19_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo23_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo27_r ?></font></div></td>
    </tr>
    <tr> 
      <td><font size="1">H. Basculante 2</font></td>
      <td><div align="center"><font size="1"><?php echo $Campo8_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo12_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo16_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo20_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo24_r ?></font></div></td>
      <td><div align="center"><font size="1"><?php echo $Campo28_r ?></font></div></td>
    </tr>
    <tr> 
      <td><font size="1">Ollas Escoria Horno Retenci&oacute;n</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo29_r ?></font></div></td>
      <td colspan="5"><font size="1">Ollas</font><font size="1">&nbsp;</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Ollas Escoria Horno Basculante</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo30_r ?></font></div></td>
      <td colspan="5"><font size="1">Ollas</font><font size="1">&nbsp;</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td align="center"><font size="1">Producto en proceso RAF</font></td>
      <td><div align="right"></div></td>
      <td colspan="5"><font size="1">&nbsp;</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Horno Ret&eacute;n </font></td>
      <td><div align="right"><font size="1"><?php echo $Campo31_r ?></font></div></td>
      <td colspan="5"><font size="1">Ollas</font><font size="1">&nbsp;</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Horno Baculante </font></td>
      <td><div align="right"><font size="1"><?php echo $Campo32_r ?></font></div></td>
      <td colspan="5"><font size="1">Ollas</font><font size="1">&nbsp;</font><font size="1">&nbsp;</font></td>
    </tr>
    <tr> 
      <td><font size="1">Horno1</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo33_r ?></font></div></td>
      <td colspan="5"><font size="1">Ton.</font></td>
    </tr>
    <tr> 
      <td><font size="1">Horno2</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo34_r ?></font></div></td>
      <td colspan="5"><font size="1">Ton.</font></td>
    </tr>
    <tr> 
      <td><font size="1">Blister, Restos y Rechazos </font></td>
      <td><div align="right"><font size="1"><?php echo $Campo35_r ?></font></div></td>
      <td colspan="5"><font size="1">Ton.</font></td>
    </tr>
	
</table>
  <?php include("List_PlantaAcid.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr>
      <td width="20%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Planta de
        &Aacute;cido</font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td colspan = 3 width="50%" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><?php echo $Nombre_a ?></font></td>
    </tr>
    <tr>
      <td><font size="1">Tiempo de Operaci&oacute;n</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo1_a ?></font></div></td>
      <td colspan = 3><font size="1">Hrs/d&iacute;a</font></td>
    </tr>
    <tr>   
      <td><font size="1">Producci&oacute;n</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo2_a ?></font></div></td>
      <td width="15%"><font size="1">Ton/d&iacute;a</font></td>
      <td width="7%">Acumulado</td>
      <td width="17%">
          <?php include("Acum_Prod_Acido.php"); ?>
          <?php echo number_format($Acum_prod,1,',','')?> Tons.</td>
    </tr>
    <tr>
      <td><font size="1">Flujo Gases Prom.</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo3_a ?></font></div></td>
      <td><font size="1">M3/Hrs</font></td>
    </tr>
    <tr>
      <td><font size="1">Conc. SO2 Prom.</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo4_a ?></font></div></td>
      <td><font size="1">%</font></td>
    </tr>
    <tr>
      <td><font size="1">Conc. &Aacute;cido Prom.(Ayer)</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo5_a ?></font></div></td>
      <td><font size="1">%</font></td>
    </tr>
    <tr>
      <td colspan="3"><div align="left"><font size="1">Temperaturas</font></div>
        <div align="right"></div></td>
    </tr>
    <tr>
      <td colspan="3"><font size="1">Descanso Axial </font> <div align="right"></div></td>
    </tr>
    <tr>
      <td><font size="1">Minima</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo6_a ?></font></div></td>
      <td><font size="1">&ordm;C</font></td>
    </tr>
    <tr>
      <td><font size="1">M&aacute;xima</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo7_a ?></font></div></td>
      <td><font size="1">&ordm;C</font></td>
    </tr>
    <tr>
      <td><font size="1">K3 (59.4)</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo8_a ?></font></div></td>
      <td><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">K5 (83.8)</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo9_a ?></font></div></td>
      <td><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">K6 (89.7)</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo10_a ?></font></div></td>
      <td><font size="1">&nbsp;</font></td>
    </tr>
    <tr>
      <td><font size="1">Purgas &Aacute;cido</font></td>
      <td><div align="right"><font size="1"><?php echo $Campo11_a ?></font></div></td>
      <td><font size="1">&nbsp;</font></td>
    </tr>
</table>
  <?php include("List_TermOxig.php"); ?>
  <div align="center">
    <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
      <tr> 
        <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">C. 
          T&eacute;rmica y Pta. Oxigeno</font></strong></td>
        <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
        <td colspan="5" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><?php echo $Nombre_t ?></font></td>
      </tr>
      <tr> 
        <td><font size="1">Producci&oacute;n LOX</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo1_t ?></font></div></td>
        <td colspan="5"><font size="1">Ton/d&iacute;a</font></td>
      </tr>
      <tr> 
        <td><font size="1">Producci&oacute;n GOX</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo2_t ?></font></div></td>
        <td colspan="5"><font size="1">Ton/d&iacute;a</font></td>
      </tr>
      <tr> 
        <td><font size="1">Consumo Real (FQI 165-B)</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo3_t ?></font></div></td>
        <td colspan="5"><font size="1">Ton/d&iacute;a</font></td>
      </tr>
      <tr> 
        <td><font size="1">Nivel BO1</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo4_t ?></font></div></td>
        <td colspan="5"><font size="1">Lts.</font></td>
      </tr>
      <tr> 
        <td><font size="1">Consignas Planta GOX</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo5_t ?></font></div></td>
        <td colspan="5"><font size="1">KNm3/Hr</font></td>
      </tr>
      <tr> 
        <td><font size="1">Consignas Planta LOX</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo6_t ?></font></div></td>
        <td colspan="5"><font size="1">KNm3/Hr</font></td>
      </tr>
      <tr> 
        <td><font size="1">Flujo Turbina (FIC 540)</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo7_t ?></font></div></td>
        <td colspan="5"><font size="1">KNm3/Hr</font></td>
      </tr>
      <tr> 
        <td><font size="1">PDI (540/542)</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo8_t ?></font></div></td>
        <td colspan="5"><font size="1">Kpa-g</font></td>
      </tr>
      <tr> 
        <td><font size="1">Caldera K-3</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo9_t ?></font></div></td>
        <td width="15%"><font size="1">Ton/d&iacute;a</font></td>
        <td width="7%"><font size="1"><?php echo $Campo12_t ?></font></td>
        <td width="17%">Acumulado</td>
        <td width="8%"> 
          <?php include("Acum_Calderas_K.php"); ?>
          <?php echo number_format($Acum_K3,1,',','')?></td>
        <td width="9%">Tons.</td>
      </tr>
      <tr> 
        <td><font size="1">Caldera K-4</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo10_t ?></font></div></td>
        <td><font size="1">Ton/d&iacute;a</font></td>
        <td><font size="1"><?php echo $Campo13_t ?></font></td>
        <td>Acumulado</td>
         <td><?php echo number_format($Acum_K4,1,',','') ?></td>
        <td>Tons.</td>
      </tr>
      <tr> 
        <td><font size="1">Caldera K-5</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo11_t ?></font></div></td>
        <td><font size="1">Ton/d&iacute;a</font></td>
        <td><font size="1"><?php echo $Campo14_t ?></font></td>
        <td>Acumulado</td>
         <td><?php echo number_format($Acum_K5,1,',','') ?></td>
        <td>Tons.</td>
      </tr>
      <tr> 
        <td><font size="1">Factor de Potencia (COSPI) Acum.</font></td>
        <td><div align="right"><font size="1"><?php echo $Campo15_t ?></font></div></td>
        <td colspan="5"><font size="1">&nbsp;</font></td>
      </tr>
</table>
	<br>
    <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
      <tr> 
        <td width="32%" bgcolor="#b26c4a"><div align="center"><strong></strong> 
            <strong><font color="#FFFFFF" size="2">Producci&oacute;n/Recepci&oacute;n 
            de &Aacute;nodos (Versi&oacute;n 1) </font></strong></div></td>
          </font></strong></td>
      </tr>
      <?php
	include("conectar_7.php");  
	include("List_anodos.php"); 
	
	/*  $consulta = "SELECT distinct flujo FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento = '$Fecha'"; 
      $rs = mysqli_query($consulta);	  
	  //echo $consulta;
	  while($row = mysqli_fetch_array($rs))
	  {
			//echo "entro";
            $consulta = "SELECT descripcion FROM proyecto_modernizacion.flujos WHERE cod_flujo = $row[flujo]";
            $consulta.=" and sistema = 'SEA'";
			$rs1 = mysqli_query($consulta);		
			//echo $consulta;	
			if($row1 = mysqli_fetch_array($rs1))
			{
				echo'<tr>'; 
					echo'<td height="20">'.$row1[descripcion].'</td>';

				    $consulta = "SELECT SUM(unidades) as unidades, SUM(peso) as peso FROM sea_web.movimientos WHERE flujo = $row[flujo] AND fecha_movimiento = '$Fecha'";
	  				//echo $consulta."<br>";
					$rs2 = mysqli_query($consulta);

					if($row2 = mysqli_fetch_array($rs2))
					{					
						echo'<td height="20"><center>'.number_format($row2[unidades],0,",",".").'</center></td>';
						echo'<td height="20"><center>'.number_format($row2[peso],0,",",".").'</center></td>';
					}

				echo'</tr>';
			}	
			$Total_Unidades_Produccion = $Total_Unidades_Produccion + $row2[unidades];
			$Total_Peso_Produccion = $Total_Peso_Produccion + $row2[peso];

	  }
      echo'<tr>';
        echo'<td width="32%"><strong>TOTAL PRODUCCION DE ANODOS</strong></td>';
        echo'<td width="33%"><strong><div align="center">'.number_format($Total_Unidades_Produccion,0,",",".").'</div></strong></td>';
        echo'<td width="35%"><strong><div align="center">'.number_format($Total_Peso_Produccion,0,",",".").'</div></strong></td>';
      echo'</tr>';

	?>
</table>
   <br>      
   <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
      <tr> 
        <td height="17" colspan="5" bgcolor="#b26c4a"><div align="left"><strong></strong> 
            <strong><font color="#FFFFFF" size="2">EXISTENCIA DE ANODOS</font></strong></div></td>
      </tr>
      <tr> 
        <td width="32%" height="20" bgcolor="#CCCCCC"><div align="LEFT">PRODUCTO</div></td>
        <td width="17%" bgcolor="#CCCCCC"><div align="center">UNIDADES</div></td>
        <td width="18%" bgcolor="#CCCCCC"><div align="center">PESO PROMEDIO</div></td>
        <td width="33%" bgcolor="#CCCCCC"><div align="center">PESO KG</div></td>
      </tr>
<?php



$FechaInicio = $ano."-".$mes."-01";
$FechaConsulta = $ano."-".$mes."-".$dia;
//Corrientes Ventana
	echo'<tr>'; 
		echo'<td height="20">Ánodos Corrientes Ventana</td>';

				//STOCK INICIAL
				$consulta = "SELECT sum(unid_fin) as unidades, sum(peso_fin) as peso ";
				$consulta.= " FROM sea_web.stock ";
				$consulta.= " WHERE cod_producto = 17";
				$consulta.= " AND cod_subproducto = 4";
				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
				$consulta.= " AND unid_fin > 0";				
				
				$rs1 = mysqli_query($consulta);								
				if ($row1 = mysqli_fetch_array($rs1))
				{
					$unidades_aux = $row1[unidades];
					$peso_aux = $row1[peso];
				}
				//-------------
				//RECEPCION
					$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 4";
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '1'";
					//echo $consulta."<br>";
					$rs1 = mysqli_query($consulta);
					if ($row1 = mysqli_fetch_array($rs1))
					{
						$unidades_aux = $unidades_aux + $row1[unidades];
						$peso_aux = $peso_aux + $row1[peso];					
					}
				//-----------------
				///BENEFICIO - RECHAZO
				$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 4";
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in (2,4)";
				$rs1 = mysqli_query($consulta);						

				if ($row1 = mysqli_fetch_array($rs1))
				{
					$unidades_aux = $unidades_aux - $row1[unidades];
					$peso_aux = $peso_aux - $row1[peso];					
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
		echo'<td height="20">Ánodos Hojas Madres Ventana</td>';

				//STOCK INICIAL
				$consulta = "SELECT sum(unid_fin) as unidades, sum(peso_fin) as peso ";
				$consulta.= " FROM sea_web.stock ";
				$consulta.= " WHERE cod_producto = 17";
				$consulta.= " AND cod_subproducto = 8";
				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
				$consulta.= " AND unid_fin > 0";				
				
				$rs1 = mysqli_query($consulta);								
				if ($row1 = mysqli_fetch_array($rs1))
				{
					$unidades_aux = $row1[unidades];
					$peso_aux = $row1[peso];
				}
				//-------------
				//RECEPCION
					$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 8";
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '1'";
					$rs1 = mysqli_query($consulta);
					if ($row1 = mysqli_fetch_array($rs1))
					{
						$unidades_aux = $unidades_aux + $row1[unidades];
						$peso_aux = $peso_aux + $row1[peso];					
					}
				//-----------------
				///BENEFICIO - RECHAZO
				$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 8";
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in (2,4)";
				$rs1 = mysqli_query($consulta);						

				if ($row1 = mysqli_fetch_array($rs1))
				{
					$unidades_aux = $unidades_aux - $row1[unidades];
					$peso_aux = $peso_aux - $row1[peso];					
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
		echo'<td height="20">Ánodos Teniente</td>';

				//STOCK INICIAL
				$consulta = "SELECT sum(unid_fin) as unidades, sum(peso_fin) as peso ";
				$consulta.= " FROM sea_web.stock ";
				$consulta.= " WHERE cod_producto = 17";
				$consulta.= " AND cod_subproducto = 2";
				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
				$consulta.= " AND unid_fin > 0";				
				
				$rs1 = mysqli_query($consulta);								
				if ($row1 = mysqli_fetch_array($rs1))
				{
					$unidades_aux = $row1[unidades];
					$peso_aux = $row1[peso];
				}
				//-------------
				//RECEPCION
					$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 2";
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '1'";
					$rs1 = mysqli_query($consulta);
					if ($row1 = mysqli_fetch_array($rs1))
					{
						$unidades_aux = $unidades_aux + $row1[unidades];
						$peso_aux = $peso_aux + $row1[peso];					
					}
				//-----------------
				///BENEFICIO - RECHAZO
				$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 2";
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in (2,4)";
				$rs1 = mysqli_query($consulta);						

				if ($row1 = mysqli_fetch_array($rs1))
				{
					$unidades_aux = $unidades_aux - $row1[unidades];
					$peso_aux = $peso_aux - $row1[peso];					
				}

				//STOCK FINAL A LA FECHA DE CONSULTA*/
		/*		
				echo '<td align="center">'.number_format($unidades_aux,0,",",".").'</td>';
                 if   ($unidades_aux == 0 )
                   {
                       $unidades_aux = 1 ;
                       }
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
		echo'<td height="20">Ánodos Chagres</td>';

				//STOCK INICIAL
				$consulta = "SELECT sum(unid_fin) as unidades, sum(peso_fin) as peso ";
				$consulta.= " FROM sea_web.stock ";
				$consulta.= " WHERE cod_producto = 17";
				$consulta.= " AND cod_subproducto = 3";
				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
				$consulta.= " AND unid_fin > 0";				
				
				$rs1 = mysqli_query($consulta);								
				if ($row1 = mysqli_fetch_array($rs1))
				{
					$unidades_aux = $row1[unidades];
					$peso_aux = $row1[peso];
				}
				//-------------
				//RECEPCION
					$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 3";
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '1'";
					$rs1 = mysqli_query($consulta);
					if ($row1 = mysqli_fetch_array($rs1))
					{
						$unidades_aux = $unidades_aux + $row1[unidades];
						$peso_aux = $peso_aux + $row1[peso];					
					}
				//-----------------
				///BENEFICIO - RECHAZO
				$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 3";
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in (2,4)";
				$rs1 = mysqli_query($consulta);						

				if ($row1 = mysqli_fetch_array($rs1))
				{
					$unidades_aux = $unidades_aux - $row1[unidades];
					$peso_aux = $peso_aux - $row1[peso];					
				}

				//STOCK FINAL A LA FECHA DE CONSULTA
				echo '<td align="center">'.number_format($unidades_aux,0,",",".").'</td>';
                if ($unidades_aux == 0)
				{
                   $unidades_aux = 1   ;
                   $peso_aux = 0;
                   }
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
		echo'<td height="20">Ánodos HVL</td>';

				//STOCK INICIAL
				$consulta = "SELECT sum(unid_fin) as unidades, sum(peso_fin) as peso ";
				$consulta.= " FROM sea_web.stock ";
				$consulta.= " WHERE cod_producto = 17";
				$consulta.= " AND cod_subproducto = 1";
				$consulta.= " AND ano = YEAR(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH)) and mes = MONTH(SUBDATE('".$FechaInicio."', INTERVAL 1 MONTH))";				
				$consulta.= " AND unid_fin > 0";				
				//echo $consulta;
				
				$rs1 = mysqli_query($consulta);								
				if ($row1 = mysqli_fetch_array($rs1))
				{
					$unidades_aux = $row1[unidades];
					$peso_aux = $row1[peso];
				}
				//-------------
				//RECEPCION
					$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
					$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 1";
					$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
					$consulta.= " AND tipo_movimiento = '1'";
					$rs1 = mysqli_query($consulta);
					if ($row1 = mysqli_fetch_array($rs1))
					{
						$unidades_aux = $unidades_aux + $row1[unidades];
						$peso_aux = $peso_aux + $row1[peso];					
					}
				//-----------------
				///BENEFICIO - RECHAZO
				$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso FROM sea_web.movimientos ";
				$consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 1";
				$consulta.= " AND fecha_movimiento between '".$FechaInicio."' and '".$FechaConsulta."' ";
				$consulta.= " AND tipo_movimiento in (2,4)";
				$rs1 = mysqli_query($consulta);						

				if ($row1 = mysqli_fetch_array($rs1))
				{
					$unidades_aux = $unidades_aux - $row1[unidades];
					$peso_aux = $peso_aux - $row1[peso];					
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
*/
	?>
	
		<br>
    <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
      <tr> 
        <td width="32%" bgcolor="#b26c4a"><div align="center"><strong></strong> 
            <strong><font color="#FFFFFF" size="2">Producción De Cátodos (Versión 1) </font></strong></div></td>
          </font></strong></td>
      </tr>
</table>
	
	
	
		<?php include("List_catodos.php"); ?>

	
<?php
/*
	
</table>

	<br>
   <table  width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
  <tr >
    <td height="100%" colspan="5" bgcolor="#b26c4a"><div align="left"><strong></strong>
            <strong><font color="#FFFFFF" size="2">PRODUCCION DE CATODOS</font></strong></div></td>
  <td width="150"   height="20" bgcolor="#b26c4a"><div align="LEFT"></td>
</tr>

    <td width="12%" height="20" bgcolor="#CCCCCC"><div align="LEFT">DIA</td>
    <td width="64"  height="20" bgcolor="#CCCCCC"><div align="LEFT" >PROD.</td>
    <td width="80"  height="20" bgcolor="#CCCCCC"><div align="LEFT">DESCRIPCION</td>
    <td width="52"  height="20" bgcolor="#CCCCCC"><div align="LEFT">GRUPO</td>
  <td width="74"   height="20" bgcolor="#CCCCCC"><div align="LEFT">TOT-PESO</td>
  <td width="100"   height="20" bgcolor="#CCCCCC"><div align="LEFT"></td>
  </tr>
<?php 
/*
  $Consulta = " select distinct t1.fecha_produccion, t1.cod_producto, t2.cod_subproducto, t2.descripcion, t1.cod_grupo ";
	$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2 ";
	$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto  ";
	$Consulta.= " where t1.fecha_produccion BETWEEN '".$FechaConsulta."' and '".$FechaConsulta."' ";
	$Consulta.= " group by  t1.fecha_produccion, t1.cod_producto, t2.cod_subproducto, t1.cod_grupo ";
	$Consulta.= " order by  t1.fecha_produccion, t1.cod_producto, t2.cod_subproducto, t1.cod_grupo  ";
	$Respuesta = mysqli_query($Consulta);
	$TotPesoGrupo = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
  	{
       if ($Fila["cod_grupo"]<>"0")
       
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
		$Respuesta2 = mysqli_query($Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{

            echo "<td align='right'>".number_format($Fila2["peso"],0,",",".")."</td>\n";
            if ($producto== 18)
                {
     		$TotPesoGrupo = $TotPesoGrupo + $Fila2["peso"];
              }
       }
		else
		    {
			echo "<td>&nbsp;</td>\n";
 	      }
        	echo "</tr>\n";
        }


*/?>

<div align="center">  	<br>
  <?php include("List_Novedades_Fund.php"); ?>
   <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr>
      <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Novedades
        Fundici&oacute;n </font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><?php echo $Nombre_f ?></font></td>
    </tr>
    <tr>
      <td height="20" colspan="3"><div align="left"><font size="2"><?php echo nl2br($Texto_f) ?></font></div></td>
    </tr>
  </table>
  <?php include("List_Novedades_Refino.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr>
      <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Novedades
        Refino a Fuego</font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><?php echo $Nombre_r ?></font></td>
    </tr>
    <tr>
      <td height="20" colspan="3"><div align="left"><font size="2"><?php echo nl2br($Texto_r) ?></font></div></td>
    </tr>
  </table>
  <?php include("List_Novedades_PlantaAcid.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr>
      <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Novedades
        Planta de &Aacute;cido</font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><?php echo $Nombre_a ?></font></td>
    </tr>
    <tr>
      <td height="20" colspan="3"><div align="left"><font size="2"><?php echo nl2br($Texto_a) ?></font></div></td>
    </tr>
  </table>

<?php include("List_Novedades_TermOxig.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr>
      <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Novedades
        C. T&eacute;rmica y Pta Oxig</font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><?php echo $Nombre_t ?></font></td>
    </tr>
    <tr>
      <td height="22" colspan="3"><div align="left"><font size="2"><?php echo nl2br($Texto_t) ?></font></div></td>
    </tr>
  </table>
  
  <?php include("List_Novedades_Refineria.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr> 
      <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Novedades 
        Refineria Electrolitica</font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><?php echo $Nombre_ref ?></font></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><div align="left"><font size="2"><?php echo nl2br($Texto_ref) ?></font></div></td>
    </tr>
  </table>
  
    <?php include("List_Novedades_Prod_Met.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr> 
      <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Novedades 
        Productos Intermedios</font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><?php echo $Nombre_Prod_Met ?></font></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><div align="left"><font size="2"><?php echo nl2br($Texto_Prod_Met) ?></font></div></td>
    </tr>
  </table>

      <?php include("List_Novedades_Prod_Finales.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr> 
      <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Novedades 
        Productos Finales</font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><?php echo $Nombre_Prod_Finales ?></font></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><div align="left"><font size="2"><?php echo nl2br($Texto_Prod_Finales) ?></font></div></td>
    </tr>
  </table>

  
  
  <?php include("List_Novedades_seguridad.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr> 
      <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Novedades 
        Seguridad Indust. y Emerg.</font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><? echo $Nombre_seg ?></font></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><div align="left"><font size="2"><?php echo nl2br($Texto_seg) ?></font></div></td>
    </tr>
  </table>
    <?php include("List_Novedades_seguridadi.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr>
      <td width="32%" bgcolor="#b26c4a"><strong><font color="#FFFFFF" size="2">Novedades
        Seguridad Integral</font></strong></td>
      <td width="12%" bgcolor="#b26c4a"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2" bgcolor="#b26c4a"><font size="2" color="#FFFFFF"><?php echo $Nombre_segi ?></font></td>
    </tr>
    <tr>
      <td height="20" colspan="3"><div align="left"><font size="2"><?php echo nl2br($Texto_segi) ?></font></div></td>
    </tr>
  </table>
   <?php include("List_Novedades_policlinico.php"); ?>
  <table width="81%" border="0" cellspacing="1" cellpadding="1"  bgcolor="#FFFFFF">
    <tr bgcolor="#b26c4a">
      <td width="32%"><strong><font color="#FFFFFF" size="2">Novedades
        Policlinico</font></strong></td>
      <td width="12%"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2"><font size="2" color="#FFFFFF"><?php echo $Nombre_pol ?></font></td>
    </tr>
    <tr>
      <td height="20" colspan="3"><div align="left"><font size="2"><?php echo nl2br($Texto_pol) ?></font></div></td>
    </tr>
  </table>
  
  <?php include("List_Observaciones_Mant.php"); ?>
  <table width="81%"  border="0" cellpadding="1" cellspacing="1"  bordercolor="#6060b0" bgcolor="#FFFFFF">
    <tr bgcolor="#b26c4a"> 
      <td width="32%"><strong><font color="#FFFFFF" size="2">Novedades 
        de Mantenci&oacute;n </font></strong></td>
      <td width="12%"><div align="center"><font size="2" color="#FFFFFF"><?php echo $Fecha ?></font></div></td>
      <td width="56%" colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td height="20" bgcolor="#CCCCCC"><strong>Turno A</strong></td>
      <td height="20" bgcolor="#CCCCCC">&nbsp;</td>
      <td height="20" bgcolor="#CCCCCC"><font size="2">
        <?php include("conectar47.php");  
	  
	    $Rut_bus = $Rut_A; 
	  
	  	$sql2 = "SELECT * FROM funcionarios WHERE rut LIKE '$Rut_bus' ";
        $result2 = mysqli_query($link,$sql2);
		$Nombre_A="";
		 if($row = mysqli_fetch_array($result2))
		 {
		  $apellido_p = $row["apellido_paterno"]; 
		  $apellido_m = $row["apellido_materno"]; 
  		  $nombres = $row["nombres"]; 
		  $Nombre_A= "$apellido_p $apellido_m $nombres"; 
		 } 
		  echo strtoupper($Nombre_A);
	  ?>
        </font></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><font size="2"><?php echo nl2br($Observacion_A) ?></font></td>
    </tr>
    <tr> 
      <td height="20" bgcolor="#CCCCCC"><strong>Turno B</strong></td>
      <td height="20" bgcolor="#CCCCCC">&nbsp;</td>
      <td height="20" bgcolor="#CCCCCC"><font size="2">
        <?php 
	  
	  $Rut_bus = $Rut_B; 
	  
	  	 $sql2 = "SELECT * FROM funcionarios WHERE rut LIKE '$Rut_bus' ";
        $result2 = mysqli_query($link,$sql2);
		$Nombre_B="";
		 if($row = mysqli_fetch_array($result2))
		 {
		  $apellido_p = $row["apellido_paterno"]; 
		  $apellido_m = $row["apellido_materno"]; 
  		  $nombres = $row["nombres"]; 
		  $Nombre_B= "$apellido_p $apellido_m $nombres"; 
		 } 
		  echo strtoupper($Nombre_B);
	  ?>
        </font></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><font size="2"><?php echo nl2br($Observacion_B) ?></font></td>
    </tr>
    <tr> 
      <td height="20" bgcolor="#CCCCCC"><strong>Turno C</strong></td>
      <td height="20" bgcolor="#CCCCCC">&nbsp;</td>
      <td height="20" bgcolor="#CCCCCC"><font size="2">
        <?php 
	  
	  $Rut_bus = $Rut_C; 
	  
	  	 $sql2 = "SELECT * FROM funcionarios WHERE rut LIKE '$Rut_bus' ";
        $result2 = mysqli_query($link,$sql2);
		$Nombre_C="";
		 if($row = mysqli_fetch_array($result2))
		 {
		  $apellido_p = $row["apellido_paterno"]; 
		  $apellido_m = $row["apellido_materno"]; 
  		  $nombres = $row["nombres"]; 
		  $Nombre_C= "$apellido_p $apellido_m $nombres"; 
		 }
		  echo strtoupper($Nombre_C);
	  ?>
        </font></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><font size="2"><?php echo nl2br($Observacion_C) ?></font></td>
    </tr>
    <tr> 
      <td height="20"  bgcolor="#CCCCCC"><strong>Turno V</strong></td>
      <td height="20" bgcolor="#CCCCCC">&nbsp;</td>
      <td height="20" bgcolor="#CCCCCC"><font size="2">
        <?php 
	  
	  $Rut_bus = $Rut_V; 
	  
	  	 $sql2 = "SELECT * FROM funcionarios WHERE rut LIKE '$Rut_bus' ";
        $result2 = mysqli_query($link,$sql2);
		$Nombre_V="";
		 if($row = mysqli_fetch_array($result2))
		 {
		  $apellido_p = $row["apellido_paterno"]; 
		  $apellido_m = $row["apellido_materno"]; 
  		  $nombres = $row["nombres"]; 
		  $Nombre_V= "$apellido_p $apellido_m $nombres"; 
		 } 
		  echo "$Nombre_V";
	  ?>
        </font></td>
    </tr>
    <tr> 
      <td height="20" colspan="3"><div align="left"><font size="2"><?php echo nl2br($Observacion_V) ?></font></div></td>
    </tr>
  </table>
</div>
<p align="center">
  <input name="BtnVolver" type="button" id="BtnVolver" value="Volver" style="width:70px " onClick="history.back();">
</p>
<p align="center">&nbsp;</p>

</body>
</html>

