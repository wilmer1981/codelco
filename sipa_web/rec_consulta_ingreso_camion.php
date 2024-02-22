<?php
	$CodigoDeSistema = 8;
	$CodigoDePantalla = 1;
	include("../principal/conectar_sipa_web.php");
	if(!isset($TxtFechaIni))
		$TxtFechaIni=date('Y-m-d');
	if(!isset($TxtFechaFin))
		$TxtFechaFin=date('Y-m-d');
?>
<html>
<head>
<title>Sistema de Recepci&oacute;n</title>
<link href="../principal/estilos/css_sipa_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "W":
			f.action = "rec_consulta_ingreso_camion.php?opcion=W";
			f.submit();
			break;
		case "E":
			f.action = "rec_consulta_ingreso_camion_ex.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=8";
			f.submit(); 
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form action="" method="post" name="frmPrincipal">
<?php include("../principal/encabezado.php")?>
  <table width="771" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td width="757" height="316" valign="top"> 
        <table width="748" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
          <tr class="ColorTabla01">
            <td colspan="4" align="center">CONSULTA INGRESO/SALIDA DE CAMIONES</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td width="142">Fecha Inicio:</td>
            <td width="206"><input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readonly>
                <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> </td>
            <td width="167">Fecha Termino:</td>
            <td width="209"><input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readonly>
                <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"> </td>
          </tr>
        </table>
		*******************************************************************
		<?php
		 if ($opcion=="W")
		 {
		 	echo "<table width='1500' border='0' cellpadding='1' cellspacing='1' bgcolor='#000000' class='TablaInterior'>\n";
		 		echo "<tr class='ColorTabla01' align='center'>\n";
					echo "<td>CORREL.</td>\n";
					echo "<td>PATENTE</td>\n";		
					echo "<td>FECHA</td>\n";
					echo "<td>HORA ENTR.</td>\n";
					echo "<td>HORA SAL.</td>\n";
					echo "<td>T.PLANTA</td>\n";
					echo "<td>PESO BRUTO</td>\n";
					echo "<td>PESO TARA</td>\n";
					echo "<td>DECR. PROV</td>\n";
					echo "<td>NOM. FAENA</td>\n";
					echo "<td>DEC. PROD.</td>\n";
					echo "</tr>\n";				
					$Consulta=
			$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		switch ($TipoConsulta)
		{
			case "R": //DETALLE RECEPCIONES
				if ($Lote == "S")
				{
					if ($Row[ACTIVO] == "M")
							echo "<tr bgcolor='#FFFFFF'> \n";
						else
							echo "<tr bgcolor='#FFFFFF'> \n";
							echo "<td>".$Row["lote"]."</td>\n";
						echo "<td>".$Row["recargo"]."</td>\n";
						echo "<td>".$Row[fecha_recepcion]."</td>\n";
						echo "<td>".$Row["hora_entrada"]."</td>\n";
						echo "<td>".$Row["hora_salida"]."</td>\n";
						echo "<td>".$Row[folio]."</td>\n";
						echo "<td>".$Row["corr"]."</td>\n";												
						echo "<td align='right'>".$Row["peso_bruto"]."</td>\n";
						echo "<td align='right'>".$Row["peso_tara"]."</td>\n";
						echo "<td align='right'>".$Row["peso_neto"]."</td>\n";
						echo "<td>".$Row["rut_proveedor"]."</td>\n";
						echo "<td>".$Row["nom_proveedor"]."</td>\n";
						echo "<td>".$Row[cod_faena]."&nbsp;</td>\n";
						echo "<td>".$Row["nom_faena"]."&nbsp;</td>\n";
						echo "<td>".$Row["cod_subproducto"]."</td>\n";
						echo "<td>".$Row["nom_subproducto"]."</td>\n";
						echo "<td>".$Row["guia_despacho"]."</td>\n";
						echo "<td>".$Row["patente"]."</td>\n";
						echo "<td>".$Row[num_conjunto]."&nbsp;</td>\n";
						echo "</tr>\n";

		*********************************************************************
        <br>
        <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
          <tr>
            <td align="center" bgcolor="#FFFFFF">
              <span class="Estilo1">
              <input type="button" name="btnWeb" value="Consulta Web" onClick="Proceso('W');" style="width:90px">
              <input type="button" name="btnExcel" value="Consulta Excel" onClick="Proceso('E');" style="width:90px">
              <input type="button" name="btnsalir" value="Salir" onClick="Proceso('S');" style="width:90px">
              </span></td>
          </tr>
      </table>      </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
