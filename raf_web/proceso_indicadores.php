<?
	$CodigoDeSistema=99;
	$CodigoDePantalla=0;
	include("../principal/conectar_principal.php");
	mysql_select_db("raf_web",$link);
	if (!isset($TxtFechaIni))
		$TxtFechaIni = date("Y-m-d");
	//recupero de las clases sistema RAF dias de reproceso
	$consulta = "select IFNULL(valor1,0) as dias from proyecto_modernizacion.clase where cod_clase=12007";
	$Resp=mysql_query($consulta);
	//echo $consulta."<br>";
	if($Fila = mysql_fetch_array($Resp))
	{
		$DiasRepro=$Fila["dias"];	
	}		
?>
<html>
	<head>
	<title>Proceso Indicadores</title>
	<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
	<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
	<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>

	<script language="javascript">

	function Proceso(opt,valor)
	{
		var f=document.frmPrincipal;
		switch (opt)
		{
			case "PR":
				f.action = "proceso_indicadores_calc.php?Opcion=WEB";
				f.submit();
				break;
			case "CO":
				f.action = "proceso_indicadores.php?TxtFechaIni="+f.TxtFechaIni.value;
				f.submit();
				break;	
			case "S"://SALIR
				f.action = "../principal/sistemas_usuario.php?CodSistema=99";
				f.submit();
				break;
		}
	}
	</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body><DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<? include("../principal/encabezado.php") ?>
<input type="hidden" name="TipoBusqueda" value="<? echo $TipoCon; ?>">
<table class="TablaPrincipal" width="770">
	<tr>
	  <td width="770" height="340" align="center" valign="top"><br>
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr>
              <td width="13%">Fecha:</td>
              <td width="35%"><input name="TxtFechaIni" type="text" class="InputCen" value="<? echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> 
              </td>
            </tr>
			<tr><td colspan="2" align='left' class="ColorTabla02"><strong>Acci&oacute;n Procesar ==> El sistema procesara el dia seleccionado y reprocesara <? echo $DiasRepro;?> Dias hacia atras a partir de esta fecha</strong></td></tr>
			<tr>
			<td colspan="2" align='center' class="ColorTabla02"><input name="BtnConsultar" type="button" style="width:70px" onClick="Proceso('CO')"  value="Consultar">
			<input name="BtnProcesar" type="button" style="width:70px" onClick="Proceso('PR')"  value="Procesar"> 
                &nbsp;<input name="BtnSalir" type="button" value="Salir" style="width:70px" onClick="Proceso('S')">
            </td>
			</tr>
		  </table><br>
		  <?
		 	if(isset($Msj))
			 { 
		  ?>
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr>
              <td align='center'><strong><h2><? echo $Msj." para la fecha ".$TxtFechaIni;?></strong></h1></td>
             </tr>
		  </table><?}?>
		  <table width="750"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
            <tr class="ColorTabla01" align='center'>
			  <td width="50%">Proceso</td>
			  <td width="15%">Fecha Reporte</td>
              <td width="15%">Valor</td>
              <td width="20%">Fecha Hora Proceso</td>
			</tr>
			<?
				$Consulta="Select * from raf_web.ti_indicadores where fecha_reporte between '".$TxtFechaIni." 00:00:00' and '".$TxtFechaIni." 23:59:59' order by cod_proceso";
				$Resp=mysqli_query($link, $Consulta);
				while ($Fila = mysql_fetch_array($Resp))
				{
					echo "<tr>";
					echo "<td>".str_pad($Fila["cod_proceso"],2,"0",STR_PAD_LEFT)." - ".$Fila["observacion"]."</br>";
					echo "<td align='center'>".substr($Fila["Fecha_reporte"],0,10)."</br>";
					echo "<td align='right'>".$Fila["valor"]."</br>";
					echo "<td align='center'>".$Fila["fecha_hora"]."</br>";
					echo "</tr>";	
				}
				//echo $Eliminar."<br>";
			?>
			</table>  
		</td>
	</tr>		  
</table>
</body>
</html>
