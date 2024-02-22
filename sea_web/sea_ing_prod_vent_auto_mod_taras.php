<?php

if(isset($_REQUEST["TipoTara"])) {
	$TipoTara = $_REQUEST["TipoTara"];
}else{
	$TipoTara = '';
}
if(isset($_REQUEST["Numero"])) {
	$Numero = $_REQUEST["Numero"];
}else{
	$Numero = '';
}

if(isset($_REQUEST["Recarga"])) {
	$Recarga = $_REQUEST["Recarga"];
}else{
	$Recarga = '';
}
if(isset($_REQUEST["Modif"])) {
	$Modif = $_REQUEST["Modif"];
}else{
	$Modif = '';
}
if(isset($_REQUEST["TipoM"])) {
	$TipoM = $_REQUEST["TipoM"];
}else{
	$TipoM = '';
}
if(isset($_REQUEST["NumeroM"])) {
	$NumeroM = $_REQUEST["NumeroM"];
}else{
	$NumeroM = '';
}
if(isset($_REQUEST["TaraM"])) {
	$TaraM = $_REQUEST["TaraM"];
}else{
	$TaraM = '';
}



	$Dia = date("d");
	$Mes = date("m");
	$Ano = date("Y");
	if ($Dia < 10)
		$Dia = "0".$Dia;
	if ($Mes < 10)
		$Mes = "0".$Mes;
 	$FechaH = $Ano."-".$Mes."-".$Dia;

	include("../principal/conectar_principal.php");
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '2013'";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		switch ($Fila["cod_subclase"])
		{
			case "1":
				$PesoCtte = $Fila["valor_subclase1"];
				break;
			case "2":
				$PesoHM = $Fila["valor_subclase1"];
				break;
		}
	}
	
	if ($TipoTara=="C") 
	{
		$Nombre = "CARROS";
	}
	else
	{
		$Nombre = "RACKS";
	}
	
	$Sacar ="SELECT * from sea_web.taras where tipo_tara = '".$TipoTara."' and numero = '".$Numero."'";
	//echo $Sacar;
	$Respuesta = mysqli_query($link, $Sacar);
	if ($Row = mysqli_fetch_array($Respuesta))
	{
		$Tara = $Row["peso"];
	}	
?>	

<html>
<head>
<title>Modifica Taras</title>
<input name="tipo" type="hidden" value="<?php echo $TipoTara; ?>">
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPesos;
	switch (opt)
	{
		case "G":	
			if (f.Tara.value == "")
			{
				alert("Debe Ingresar Tara");
				f.Tara.focus();
				return;
			}
			var TipoM = f.TipoTara.value;
			var NumeroM = f.Numero.value;
			var TaraM = f.Tara.value;
			f.action = "sea_ing_prod_vent_auto_mod_taras.php?Recarga=S&Modif=M&TipoM=" + TipoM + "&NumeroM=" + NumeroM + "&TaraM=" + TaraM;
			f.submit();
			break;
		case "S":
			window.close();
			break;
	}
}
function TeclaPulsada(salto) 
{ 
	var f = document.formulario;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{
		eval("f." + salto + ".focus();");
	}	
}

</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmPesos" action="" method="post">
<table width="406" border="0" align="center" cellpadding="4" cellspacing="2" class="TablaInterior">
  <tr align="center">
    <td colspan="2"><strong>MODIFICA TARAS DE <?php echo $Nombre; ?> </strong></td>
  </tr>
  <tr>
    <td width="146">&nbsp;</td>
    <td width="235">&nbsp;</td>
  </tr>
  <tr>
  	<input name="TipoTara" type="hidden" id="TipoTara" value="<?php echo $TipoTara; ?>">
    <td>NUMERO: </td>
    <td><input name="Numero" type="text" id="Numero" value="<?php echo $Numero; ?>" size="10" maxlength="10"></td>
  </tr>
  <tr>
    <td>TARA:</td>
    <td><input name="Tara" type="text" id="Tara"  value="<?php echo $Tara; ?>" size="10"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  	if ($Recarga=="S" && $Modif=="M")
	{
		$Consulta1 = "SELECT * from sea_web.taras where tipo_tara = '".$TipoM."' and numero = '".$NumeroM."'";
		//echo $Consulta1;
		$Resp1 = mysqli_query($link, $Consulta1);
		if ($Row2= mysqli_fetch_array($Resp1))
		{
			$actualiza="UPDATE sea_web.taras set peso = '".$TaraM."', fecha_pesaje = '".$FechaH."'";
			$actualiza.=" where tipo_tara = '".$TipoM."' and numero = '".$NumeroM."'";
			//echo $actualiza;
			mysqli_query($link, $actualiza);
		}
		$Numero="";
		$Tara="";
	}  
  ?>
  <tr align="center">
    <td colspan="2">   
	 <input type="button" name="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
    <input type="button" name="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
</form>
</body>
</html>
