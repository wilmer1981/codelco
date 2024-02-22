<?php
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
			f.action = "ram_obtiene_leyes2.php?Procesar=S&TxtFechaIni="+f.TxtFechaIni.value+"&TxtFechaFin="+f.TxtFechaFin.value;
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
<?php include("../principal/encabezado.php") ?>
<input type="hidden" name="TipoBusqueda" value="<?php echo $TipoCon; ?>">
<table class="TablaPrincipal" width="770">
	<tr>
	  <td width="770" height="340" align="center" valign="top"><br>
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr>
              <td colspan="4"></td>
            </tr>
            <tr>
              <td width="13%">Entre Fechas:</td>
              <td colspan="3"><input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al 
              <input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"></td>
            </tr>
            <tr align="center" class="ColorTabla02">
              <td colspan="4"><input name="BtnProcesar" type="button" id="Procesar" style="width:100px " onClick="Proceso('P')" value="Procesar">
                <input name="Salir" type="button" id="Salir" style="width:70px " onClick="Proceso('S')" value="Salir"></td>				
            </tr>
        </table>

<?php
if($Procesar=='S')
{
	echo "<BR><br><br><strong>OBTENIENDO LEYES DE NI</strong>";
	$ConNi=0;
	$SinNi=0;
	$FechaIni=date('Y-m-d',mktime(0,0,0,-1,date('d'),date('Y')));
	$FechaFin=date('Y-m-d');
	$Consulta = "SELECT cod_existencia,cod_conjunto,num_conjunto,rut_proveedor,peso_seco,fecha_movimiento FROM ram_web.movimiento_proveedor WHERE fecha_movimiento BETWEEN '".$TxtFechaIni."' AND '".$TxtFechaFin."'";
	//$Consulta.= " and num_conjunto='3010' and trim(rut_proveedor)='40000-9' and cod_existencia='13'";
	//echo $Consulta."<br><br>";
	$RespPrv = mysqli_query($link, $Consulta);	
	while ($FilaPrv = mysqli_fetch_array($RespPrv))
	{
		$PesoSeco = $FilaPrv['peso_seco'];
		$NumConj = trim($FilaPrv['num_conjunto']);
		ActualizaLey($FilaPrv['rut_proveedor'],$FilaPrv['cod_existencia'],$FilaPrv['cod_conjunto'],$FilaPrv['fecha_movimiento'],$PesoSeco,$NumConj,$FechaIni,$FechaFin,'34');
		ActualizaLey($FilaPrv['rut_proveedor'],$FilaPrv['cod_existencia'],$FilaPrv['cod_conjunto'],$FilaPrv['fecha_movimiento'],$PesoSeco,$NumConj,$FechaIni,$FechaFin,'36');
		ActualizaLey($FilaPrv['rut_proveedor'],$FilaPrv['cod_existencia'],$FilaPrv['cod_conjunto'],$FilaPrv['fecha_movimiento'],$PesoSeco,$NumConj,$FechaIni,$FechaFin,'58');

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
<?php
include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
<?php
function ActualizaLey($Prv,$CodExis,$CodConj,$FecMov,$PesoSeco,$NumConj,$FechaIni,$FechaFin,$CodLey)
{
	$Consulta="select t2.valor,t2.cod_unidad,t2.cod_leyes ";
	$Consulta.=" from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.id_muestra=t2.id_muestra ";
	$Consulta.=" where t2.cod_leyes ='".$CodLey."' and t1.agrupacion in ('2','99')";
	$Consulta.=" and trim(t1.id_muestra) = '".$NumConj."' and t2.candado='1' and t1.fecha_hora between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' order by t1.fecha_hora DESC limit 1";
	$RespPond = mysqli_query($link, $Consulta);
	//echo $Consulta."<br>";	
	if($FilaPond = mysqli_fetch_array($RespPond))
	{
		$Valor=$FilaPond['valor'];
		$Unidad=$FilaPond['cod_unidad'];
		$Fino=0;
		if($PesoSeco>0)
		{
			//echo "$Fino_Ni=((".$Por_Ni." * ".$PesoSeco.")/1000000)<br>";
			switch($Unidad)
			{
				case "1"://PORCENTAJE
					$Fino=(($Valor * $PesoSeco)/100);
				break;	
				case "2"://PPM
					$Fino=(($Valor * $PesoSeco)/1000000);
				break;	

			}
			if($Fino>0)
			{
				//$Fino=0;
				$Actualizar="UPDATE ram_web.movimiento_proveedor set ";
				switch($CodLey)
				{
					case "34"://HG
						$Actualizar.="fino_hg='".$Fino."'";
					break;
					case "36"://NI
						$Actualizar.="fino_ni='".$Fino."'";
					break;
					case "58"://CD
						$Actualizar.="fino_cd='".$Fino."'";
					break;
				}
				$Actualizar.="where cod_existencia='".$CodExis."' and cod_conjunto='".$CodConj."' and num_conjunto='".$NumConj."' and rut_proveedor='".$Prv."'";
				$Actualizar.=" and fecha_movimiento = '".$FecMov."'";
				mysqli_query($link, $Actualizar);
				//echo "CON NI :".$Actualizar."<br><br><br>";
				$ConNi++;
			}
		}
	}
}
?>