<?php 	
	include("../principal/conectar_sec_web.php");

	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$PesoCalculado  = isset($_REQUEST["PesoCalculado"])?$_REQUEST["PesoCalculado"]:0;
	$TxtNumBultoFin = isset($_REQUEST["TxtNumBultoFin"])?$_REQUEST["TxtNumBultoFin"]:"";

	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$IE=$Datos2[0];
		$PesoLote=$Datos2[7];
		$CodBulto=$Datos2[8];
		$NumBulto=$Datos2[9];
		$CodMarca=$Datos2[10];
	}
	if ($CodBulto=='')
	{
		echo "<script languaje='JavaScript'>";
		echo "alert('La IE Virtual no tiene Asignado Lote para Distribuir');";
		echo "window.close();";
		echo "</script>";
	}
	$Consulta="SELECT max(num_paquete) as numbultofin from sec_web.lote_catodo where cod_bulto='".$CodBulto."' and num_bulto=".$NumBulto." and corr_enm=".$IE;
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$NumBultoFinal=$Fila["numbultofin"];
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Valores,NumBultoInicial,NumBultoFinal)
{
	var Frm=document.FrmDistLote;
	
	if (Frm.TxtNumBultoFin.value=='')
	{
		alert('Debe Ingresar Lote');
		Frm.TxtNumBultoFin.focus();
		return;
	}
	if ((parseInt(Frm.TxtNumBultoFin.value)<parseInt(NumBultoInicial))||(parseInt(Frm.TxtNumBultoFin.value)>parseInt(NumBultoFinal)))
	//if ((Frm.TxtNumBultoFin.value<NumBultoInicial)||(Frm.TxtNumBultoFin.value>NumBultoFinal))
	{
		alert('Lote Ingresado Fuera del Rango');
		Frm.TxtNumBultoFin.focus();
		return;
	}
	if (parseInt(Frm.TxtNumBultoFin.value)==parseInt(NumBultoFinal))
	{
		alert('Lote Ingresado no puede ser Fin del Lote Origen');
		Frm.TxtNumBultoFin.focus();
		return;
	}
	if (confirm('Esta Seguro de Grabar los Datos'))
	{
		Frm.action="sec_distribuir_lote01.php?Proceso=G&Valores="+Valores;
		Frm.submit();
	}	
}

function CalcularPeso(Valores,NumBultoInicial,NumBultoFinal)
{
	var Frm=document.FrmDistLote;
	
	if (Frm.TxtNumBultoFin.value=='')
	{
		alert('Debe Ingresar Lote');
		Frm.TxtNumBultoFin.focus();
		return;
	}
	if ((parseInt(Frm.TxtNumBultoFin.value)<parseInt(NumBultoInicial))||(parseInt(Frm.TxtNumBultoFin.value)>parseInt(NumBultoFinal)))
	{
		alert('Lote Ingresado Fuera del Rango');
		Frm.TxtNumBultoFin.focus();
		return;
	}
	Frm.action="sec_distribuir_lote01.php?Proceso=C&Valores="+Valores;
	Frm.submit();
}

function Salir()
{
	window.close();
	
}
</script>
<title>Distribuir Lote</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
 <form name="FrmDistLote" method="post" action="">
  <table width="375" height="185" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	<td align="center"><br>
		<table width="290" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
          <tr>
			  <td width="84" align="left" class="Detalle01">Lote Inicio</td>
			  <td colspan="2" align="left" class="Detalle01"><?php echo $CodBulto;?>-<?php echo $NumBulto;?>&nbsp;&nbsp;Peso Lote:&nbsp;<?php echo $PesoLote;?></td>
		  </tr>
		  <tr>
			  <td width="84" align="left" class="Detalle01">Lote Final</td>
			  <td colspan="2" align="left" class="Detalle01"><?php echo $CodBulto;?>-<?php echo $NumBultoFinal;?></td>
		  </tr>
		</table><br>
		<table width="290" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
		  <tr>
			  <td width="84">N&deg; Bulto Inicial</td>
			  <td width="23"><input type='text' name='TxtCodBultoIni' value='<?php echo $CodBulto;?>' readonly style="width:20"></td>
			  <td width="162"><input type="text" name="TxtNumBultoIni" value='<?php echo $NumBulto;?>' readonly style="width:60" maxlength="8"></td>
		  </tr>
		  <tr>
			  <td>N&deg; Bulto Final</td>
			  <td><input type='text' name='TxtCodBultoIni' value='<?php echo $CodBulto;?>' readonly style="width:20"></td>
			  <td><input type="text" name="TxtNumBultoFin" value='<?php echo $TxtNumBultoFin;?>'style="width:60" maxlength="8">&nbsp;&nbsp;&nbsp;<input type='button' name='BtnCalcular' value="Calcular" style="width:70" onClick="CalcularPeso('<?php echo $Valores;?>','<?php echo $NumBulto;?>','<?php echo $NumBultoFinal;?>');"></td>
		  </tr>
		  <tr>
			  <td>Peso Estimado</td>
			  <td>&nbsp;</td>
			  <td class="Detalle01"><?php echo $PesoCalculado; ?>&nbsp;</td>
		  </tr>
		</table>
        <br><br>
		<table width="290" border="0" class="tablainterior">
          <tr>
			<td width="491" align="center">
			<input type="button" name="BtnOK" value="OK" style="width:70" onClick="Grabar('<?php echo $Valores;?>','<?php echo $NumBulto;?>','<?php echo $NumBultoFinal;?>');">
			<input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();">
			</td>
		  </tr>
		</table>
	</td>
  </tr>
  </table>
</form>
</body>
</html>
