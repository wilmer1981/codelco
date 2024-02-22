<?php
	$CodigoDeSistema = 3;
	include("../principal/conectar_principal.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Consulta = "SELECT * from sec_web.paises ";
	$Consulta.= " where cod_pais = '".$CodPais."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$NomPais = $Fila["nombre_pais"];
	}
	$Consulta = "SELECT * from sec_web.cliente_venta ";
	$Consulta.= " where cod_cliente = '".$CodCliente."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{		
		$NomCliente = $Fila["nombre_cliente"];
	}
	$Consulta = "SELECT * from sec_web.contratos_comp_venta ";
	$Consulta.= " where cod_contrato = '".$CodContrato."'";
	$Consulta.= " and cod_cliente = '".$CodCliente."'";
	$Consulta.= " and ano_contrato = '".$AnoContrato."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Observacion = $Fila["observacion"];
		$Peso = $Fila["peso"];
		$Cuotas = $Fila["cuotas"];
		$FechaIni = substr($Fila["fecha_inicio"],8,2)."-".substr($Fila["fecha_inicio"],5,2)."-".substr($Fila["fecha_inicio"],0,4);
		$FechaFin = substr($Fila["fecha_termino"],8,2)."-".substr($Fila["fecha_termino"],5,2)."-".substr($Fila["fecha_termino"],0,4);
		$FechaAuxIni = substr($Fila["fecha_inicio"],0,4)."-".substr($Fila["fecha_inicio"],5,2)."-".substr($Fila["fecha_inicio"],8,2);
		$FechaAuxFin = substr($Fila["fecha_termino"],0,4)."-".substr($Fila["fecha_termino"],5,2)."-".substr($Fila["fecha_termino"],8,2);
		$Abierto = $Fila["abierto"];
	}
?>
<html>
<head>
<title>Contratos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmContrato;
	switch (opt)
	{
		case "G":			
			break;
		case "E":			
			break;
		case "S":
			window.opener.document.frmPrincipal.action = "sec_compromiso_venta.php";
		    window.opener.document.frmPrincipal.submit();
			window.close();			
			break;
	}
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmContrato" action="" method="post">
  <table width="488" height="158" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td height="18" colspan="4" class="ColorTabla01"><strong><em>DETALLE COMPROMISO 
        DE VENTA</em></strong></td>
    </tr>
    <tr> 
      <td height="18">Mercado</td>
      <td colspan="3"><?php echo $NomPais; ?> <input type="hidden" name="Pais" value="<?php echo $CodPais; ?>"></td>
    </tr>
    <tr> 
      <td height="24">Cliente</td>
      <td colspan="3"><?php echo strtoupper($CodCliente." - ".$NomCliente);?> <input type="hidden" name="Cliente" value="<?php echo $CodCliente; ?>"></td>
    </tr>
    <tr> 
      <td width="114" height="26">Cod. Contrato</td>
      <td colspan="3"><?php echo $CodContrato; ?> <input name="Contrato" type="hidden" id="Contrato" value="<?php echo $CodContrato; ?>">
        A&ntilde;o <?php echo $CodContrato; ?> </td>
    </tr>
    <tr> 
      <td height="26">Fecha</td>
      <td colspan="3"><?php echo $FechaIni; ?> al <?php echo $FechaFin; ?></td>
    </tr>
    <tr> 
      <td height="23">Peso Total</td>
      <td width="178"><?php echo number_format($Peso,0,",","."); ?> <input name="Peso" type="hidden" id="Peso" value="<?php echo $Peso; ?>">
        Kg</td>
      <td width="48">Cuotas</td>
      <td width="121"><?php echo number_format($Cuotas,0,",","."); ?> <input name="Cuotas" type="hidden" value="<?php echo $Cuotas; ?>"></td>
    </tr>
    <tr align="center"> 
      <td height="23" colspan="4"> 
        <input name="BtnGrabar" type="button" id="BtnGrabar3" value="Grabar" style="width:70px" onClick="Proceso('G');"> 
        <input name="BtnEliminar" type="button" id="BtnEliminar3" value="Eliminar" style="width:70px" onClick="Proceso('E');"> 
        <input name="BtnSalir" type="button" id="BtnSalir3" value="Salir" style="width:70px" onClick="Proceso('S');"> 
      </td>
    </tr>
  </table>
  <br>
  <br>
  <?php  
	echo "<table width='17%' border='1' cellpadding='3' cellspacing='0'>\n";				
	echo "<tr align='center' class='ColorTabla01'> \n";
	echo "<td colspan='".($Cuotas + 1)."'><strong><em>DISTRIBUCION DE PESO</em></strong></td>\n";
	echo "</tr>\n";
	echo "<tr align='center' class='ColorTabla01'> \n";
	$FechaAux = $FechaAuxIni;
	while (date($FechaAux) <= date($FechaAuxFin))
	{
		echo "<td width='31%'><strong>".$Meses[substr($FechaAux,5,2)-1]."</strong></td>\n";		
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2)+1, 01,substr($FechaAux,0,4)));
	}
	echo "<td width='69%'><strong>TOTAL<br>Kg</strong></td>\n";
	echo "</tr>\n";
	echo "<tr> \n";
	$FechaAux = $FechaAuxIni;
	while (date($FechaAux) <= date($FechaAuxFin))
	{
		echo "<td><input name='textfield' type='text' size='15'></td>\n";		
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2)+1, 01,substr($FechaAux,0,4)));
	}	
	echo "<td>&nbsp;</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
?>
  <br>
  <br>
</form>
</body>
</html>
