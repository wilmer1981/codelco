<?
	$CodigoDeSistema=7;
	$CodigoDePantalla=27;
	include("../principal/conectar_principal.php");
	if(!isset($TxtFechaIni))
		$TxtFechaIni=date('Y-m-d');
	if(!isset($TxtFechaFin))
		$TxtFechaFin=date('Y-m-d');
	set_time_limit(3000);
?>
<html>
<head>
<title>Sistema RAM</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "P"://PROCESAR
			f.action = "ram_obtiene_leyes.php?Procesar=S&TxtFechaIni="+f.TxtFechaIni.value+"&TxtFechaFin="+f.TxtFechaFin.value;
			f.submit();
			break;
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=7&Nivel=1";
			f.submit();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #FFFFFF;
}
a:visited {
	color: #FFFFFF;
}
a:hover {
	color: #FFFFFF;
}
a:active {
	color: #FFFF00;
}
-->
</style></head>

<body><DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<? include("../principal/encabezado.php") ?>
<input type="hidden" name="TipoBusqueda" value="<? echo $TipoCon; ?>">
<table class="TablaPrincipal" width="770">
	<tr>
	  <td width="770" height="340" align="center" valign="top"><br>
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr>
              <td colspan="4"></td>
            </tr>
            <tr>
              <td width="13%">Entre Fechas:</td>
              <td colspan="3"><input name="TxtFechaIni" type="text" class="InputCen" value="<? echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al 
              <input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<? echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"></td>
            </tr>
            <tr align="center" class="ColorTabla02">
              <td colspan="4"><input name="BtnProcesar" type="button" id="Procesar" style="width:100px " onClick="Proceso('P')" value="Procesar">
                <input name="Salir" type="button" id="Salir" style="width:70px " onClick="Proceso('S')" value="Salir"></td>				
            </tr>
        </table>

<?
if($Procesar=='S')
{
	echo "<BR><br><br><strong>OBTENIENDO LEYES DE NI</strong>";
	$ConNi=0;
	$SinNi=0;
	$Consulta = "SELECT cod_existencia,cod_conjunto,num_conjunto,rut_proveedor,peso_seco FROM ram_web.movimiento_proveedor WHERE fecha_movimiento BETWEEN '".$TxtFechaIni."' AND '".$TxtFechaFin."'";
	$Consulta.= " and num_conjunto='3010' and trim(rut_proveedor)='40000-9' and cod_existencia='13'";
	//echo $Consulta."<br><br>";
	$RespPrv = mysql_query($Consulta);	
	while ($FilaPrv = mysql_fetch_array($RespPrv))
	{
		$PesoSeco = $FilaPrv['peso_seco'];
		$VENDED_FORMAT=str_replace('-','',$FilaPrv['rut_proveedor']);
		$VENDED_FORMAT=str_pad(trim($VENDED_FORMAT),9,0,STR_PAD_LEFT);
		$Trecep='';
		$Consulta="select cod_subproducto from ram_web.conjunto_ram where cod_conjunto='".$FilaPrv['cod_conjunto']."' and num_conjunto='".$FilaPrv['num_conjunto']."' limit 1";
		//echo $Consulta."<br><br>";
		$RespProd=mysql_query($Consulta);
		if($FilaProd=mysql_fetch_array($RespProd))
		{
			$Trecep=$FilaProd['cod_subproducto'];
		}
    	$NumConj=$FilaPrv['num_conjunto'];
		if($Trecep=='')
			$Trecep='007';
		else
    		$Trecep = intval(str_pad($Trecep,2,"0",STR_PAD_LEFT));
    	$Tipos = 3;
    	$TiposProds = str_pad($Trecep,2,"0",STR_PAD_LEFT);
    	$cont = 0;

    	//Fecha_aux = RestaFecha(CDate(Date), 5, "MONTH");
    	//Fecha_aux = Mid(Fecha_aux, 1, 4) + Mid(Fecha_aux, 6, 2);
    	//Fecha_AUX2 = Format(Year(Date), "00") + Format(Month(Date), "00");
        $Fecha_aux=date('Y-m-d',mktime(0,0,0,-5,date('d'),date('Y')));
		$Fecha_aux=substr($Fecha_aux,0,7);
		$Fecha_AUX2=date('Y-m');
    	if ($NumConj>=7601&&$NumConj<=7612)
		{
        	$Trecep = 99;
        	$Tipos = 2;
        	$TiposProds = 22;
        	$Lotes = "000000";
        	$VENDED = "00000000-0";
        	$VENDED = "00000".substr($NumConj,2,3)."-".substr($NumConj,5,1);
        	$VENDED1 = substr($NumConj,2,3)."%";
        	//$Fecha_aux = RestaFecha(CDate(Date), 2, "YEAR")
        	//$Fecha_aux = Mid(Fecha_aux, 1, 4) + Mid(Fecha_aux, 6, 2)
        	$Fecha_aux=date('Y-m-d',mktime(0,0,0,date('m'),date('d'),-5));
			$Fecha_aux=substr($Fecha_aux,0,7);			
		}
    	if ($NumConj = 7202)
        	$VENDED = "79963260-8";
		$Fecha_aux=str_replace('-','',$Fecha_aux);
		$Fecha_AUX2=str_replace('-','',$Fecha_AUX2);
		$Consulta="select ifnull(AVG(C_36),0) as Por_Ni ";
    	$Consulta.=" from imp_web.ponderados_lotes ";
    	$Consulta.=" where tipo_reg = '".$Tipos."'";
    	$Consulta.=" and tipo_producto = '".str_pad($TiposProds,3,"0",STR_PAD_LEFT)."'";
     	$Consulta.=" and rut_proveedor ='".$VENDED_FORMAT."'";
    	$Consulta.=" and fecha_aamm >= ".$Fecha_aux." and fecha_aamm < ".$Fecha_AUX2;
		$RespPond = mysql_query($Consulta);
		echo $Consulta."<br>";	
		if($FilaPond = mysql_fetch_array($RespPond))
		{
			$Por_Ni=$FilaPond['Por_Ni'];
		}
		if($PesoSeco>0)
		{
			echo "$Fino_Ni=((".$Por_Ni." * ".$PesoSeco.")/1000000)<br>";
			$Fino_Ni=(($Por_Ni * $PesoSeco)/1000000);
			if($Fino_Ni>0)
			{
				$Actualizar="update ram_web.movimiento_proveedor set fino_ni='".$Fino_Ni."' where cod_existencia='".$FilaPrv['cod_existencia']."' and cod_conjunto='".$FilaPrv['cod_conjunto']."' and num_conjunto='".$FilaPrv['num_conjunto']."' and rut_proveedor='".$FilaPrv['rut_proveedor']."'";
				$Actualizar.=" and fecha_movimiento between '".$TxtFechaIni." 00:00:00' and '".$TxtFechaFin." 23:59:59' ";
				mysql_query($Actualizar);
				//echo "CON NI :".$Actualizar."<br><br><br>";
				$ConNi++;
			}
			else
			{
				$Actualizar="update ram_web.movimiento_proveedor set fino_ni='".$Fino_Ni."' where cod_existencia='".$FilaPrv['cod_existencia']."' and cod_conjunto='".$FilaPrv['cod_conjunto']."' and num_conjunto='".$FilaPrv['num_conjunto']."' and rut_proveedor='".$FilaPrv['rut_proveedor']."'";
				$Actualizar.=" and fecha_movimiento between '".$TxtFechaIni." 00:00:00' and '".$TxtFechaFin." 23:59:59' ";
				//echo "SIN NI :".$Actualizar."<br><br><br>";
				$SinNi++;	
			}
		}
	}
	echo "<br><br><br><br><br><br><br>";
	echo "<strong>PROCESO TERMINADO</strong>";
}
//echo "CON NI: ".$ConNi."<br>";
//echo "SIN NI: ".$SinNi."<br>";

?>
	  <br></td>
	</tr>
</table>
<?
include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>