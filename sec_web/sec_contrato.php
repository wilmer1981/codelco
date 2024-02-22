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
		$DiaIni = substr($Fila["fecha_inicio"],8,2);
		$MesIni = substr($Fila["fecha_inicio"],5,2);
		$AnoIni = substr($Fila["fecha_inicio"],0,4);
		$DiaFin = substr($Fila["fecha_termino"],8,2);
		$MesFin = substr($Fila["fecha_termino"],5,2);
		$AnoFin = substr($Fila["fecha_termino"],0,4);
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
			if (f.Contrato.value == "")
			{
				alert("Debe ingresar Cod. Contrato");
				f.Contrato.focus();
				return;
			}
			if (f.Peso.value == "")
			{
				alert("Debe ingresar Peso");
				f.Peso.focus();
				return;
			}
			if (f.Cuotas.value == "")
			{
				alert("Debe ingresar Num. de Cuotas");
				f.Cuotas.focus();
				return;
			}
			f.action = "sec_contrato01.php?Proceso=G&CodPais=" + f.Pais.value + "&CodCliente=" + f.Cliente.value + "&CodContrato=" + f.Contrato.value + "&AnoContrato=" + f.AnoContrato.value;
			f.submit();
			break;
		case "E":
			if (f.Contrato.value == "")
			{
				alert("No hay Cod. Contrato para eliminar");
				f.Contrato.focus();
				return;
			}
			var msg = confirm("�Seguro que desea Eliminar este Contrato?");
			if (msg==true)
			{
				f.action = "sec_contrato01.php?Proceso=E&CodPais=" + f.Pais.value + "&CodCliente=" + f.Cliente.value + "&CodContrato=" + f.Contrato.value + "&AnoContrato=" + f.AnoContrato.value;
				f.submit();
			}
			else
			{
				return;
			}
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
  <table width="485" height="251" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td height="18" colspan="3" class="ColorTabla01"><strong><em>CONTRATOS</em></strong></td>
    </tr>
    <tr> 
      <td height="18">Mercado</td>
      <td colspan="2"><?php echo $NomPais; ?> <input type="hidden" name="Pais" value="<?php echo $CodPais; ?>"></td>
    </tr>
    <tr> 
      <td height="24">Cliente</td>
      <td colspan="2"><?php echo strtoupper($CodCliente." - ".$NomCliente);?> <input type="hidden" name="Cliente" value="<?php echo $CodCliente; ?>"></td>
    </tr>
    <tr> 
      <td width="115" height="26">Cod. Contrato</td>
      <td width="355" colspan="2"> <input name="Contrato" type="text" id="Contrato" value="<?php echo $CodContrato; ?>"> 
        <SELECT name="AnoContrato">
          <?php
	  	for ($i=2000;$i<=date("Y")+1;$i++)
		{
			if (isset($AnoContrato))
			{
				if ($AnoContrato == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if (date("Y") == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </SELECT></td>
    </tr>
    <tr> 
      <td height="26">Fecha Inicio</td>
      <td colspan="2"><SELECT name="DiaIni" id="DiaIni">
          <?php
	  	for ($i=1;$i<=31;$i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if (date("j") == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </SELECT> <SELECT name="MesIni" id="MesIni">
          <?php
	  	for ($i=1;$i<=12;$i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
				else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
			else
			{
				if (date("n") == $i)
					echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
				else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
		}
	  ?>
        </SELECT> <SELECT name="AnoIni">
          <?php
	  	for ($i=2000;$i<=date("Y")+1;$i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if (date("Y") == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </SELECT></td>
    </tr>
    <tr> 
      <td height="26">Fecha Termino</td>
      <td><SELECT name="DiaFin" id="DiaFin">
          <?php
	  	for ($i=1;$i<=31;$i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if (date("j") == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </SELECT> <SELECT name="MesFin" id="MesFin">
          <?php
	  	for ($i=1;$i<=12;$i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
				else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
			else
			{
				if (date("n") == $i)
					echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
				else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
		}
	  ?>
        </SELECT> <SELECT name="AnoFin">
          <?php
	  	for ($i=2000;$i<=date("Y")+1;$i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if (date("Y") == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </SELECT>
      </td>
      <td>
        <?php
			if ($Abierto == "S")
				echo "<input name='ChkAbierto' checked type='checkbox' value='S'>\n";
			else	echo "<input name='ChkAbierto' type='checkbox' value='S'>\n";
		 ?>
        Abierto</td>
    </tr>
    <tr> 
      <td height="23">Peso Total</td>
      <td colspan="2"><input name="Peso" type="text" id="Peso" value="<?php echo $Peso; ?>">
        Kg</td>
    </tr>
    <tr> 
      <td height="23">Cuotas</td>
      <td colspan="2"><input name="Cuotas" type="text" id="Cuotas" value="<?php echo $Cuotas; ?>"></td>
    </tr>
    <tr> 
      <td height="23">Observacion</td>
      <td colspan="2"><textarea name="Observacion" cols="30" rows="3" wrap="VIRTUAL" id="Observacion"><?php echo $Observacion; ?></textarea></td>
    </tr>
    <tr> 
      <td height="18" colspan="3">&nbsp;</td>
    </tr>
    <tr align="center"> 
      <td height="26" colspan="3"> <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px" onClick="Proceso('G');"> 
        <input name="BtnEliminar" type="button" id="BtnEliminar2" value="Eliminar" style="width:70px" onClick="Proceso('E');"> 
        <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"> 
      </td>
    </tr>
  </table>
</form>
</body>
</html>
