<?php
	$CodigoDeSistema=24;
	$CodigoDePantalla=9;
	//$Mensaje='';
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Mensaje"])){
		$Mensaje = $_REQUEST["Mensaje"];
	}else{
		$Mensaje = "";
	}
	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["TxtCorrRecep"])){
		$TxtCorrRecep = $_REQUEST["TxtCorrRecep"];
	}else{
		$TxtCorrRecep = "";
	}
	if(isset($_REQUEST["TxtCorrDesp"])){
		$TxtCorrDesp = $_REQUEST["TxtCorrDesp"];
	}else{
		$TxtCorrDesp = "";
	}
	if(isset($_REQUEST["TxtMes"])){
		$TxtMes = $_REQUEST["TxtMes"];
	}else{
		$TxtMes = "";
	}
	if(isset($_REQUEST["TxtAno"])){
		$TxtAno = $_REQUEST["TxtAno"];
	}else{
		$TxtAno = "";
	}
	
		
	//if(isset($Proceso))
	if($Proceso !=""){
		switch($Proceso)
		{
			case "GR":
				$Consulta="SELECT lote from sipa_web.correlativo_lote where cod_proceso='R'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$LoteRecActual=intval(substr($Fila["lote"],4,4));
				$LoteRecIng=intval($TxtCorrRecep);
				/*if($LoteRecActual>=$LoteRecIng)
				{
					$Mensaje='Correlativo de Recepcion debe ser Mayor al Actual';
					$TxtCorrRecep=str_pad($LoteRecActual,4,'0',STR_PAD_LEFT);	
				}	
				else
				{*/	
					$LoteMod=str_pad($TxtAno,2,'0',STR_PAD_LEFT).str_pad($TxtMes,2,'0',STR_PAD_LEFT).str_pad($TxtCorrRecep,4,'0',STR_PAD_LEFT);
					$Actualizar="UPDATE sipa_web.correlativo_lote set lote='$LoteMod' where cod_proceso='R'";
					mysqli_query($link, $Actualizar);
				//}
				break;
			case "GD":
				$Consulta="SELECT lote from sipa_web.correlativo_lote where cod_proceso='D'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$LoteDespActual=intval(substr($Fila["lote"],4,4));
				$LoteDespIng=intval($TxtCorrDesp);
				/*if($LoteDespActual>=$LoteDespIng)
				{
					$Mensaje='Correlativo de Despacho debe ser Mayor al Actual';
					$TxtCorrDesp=str_pad($LoteDespActual,4,'0',STR_PAD_LEFT);	
				}	
				else
				{	*/
					$LoteMod=str_pad($TxtAno,2,'0',STR_PAD_LEFT).str_pad($TxtMes,2,'0',STR_PAD_LEFT).str_pad($TxtCorrDesp,4,'0',STR_PAD_LEFT);
					$Actualizar="UPDATE sipa_web.correlativo_lote set lote='$LoteMod' where cod_proceso='D'";
					mysqli_query($link, $Actualizar);
				//}
				break;
		}
	}else{
		$Consulta="SELECT * from sipa_web.correlativo_lote where cod_proceso='R'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$TxtAno=substr($Fila["lote"],0,2);
		$TxtMes=substr($Fila["lote"],2,2);
		//$TxtAno='06';
		//$TxtMes='02';
		$TxtCorrRecep=substr($Fila["lote"],4,4);
		$Consulta="SELECT * from sipa_web.correlativo_lote where cod_proceso='D'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$TxtCorrDesp=substr($Fila["lote"],4,4);
	}	

?>	
<html><head>
<title>Recepcion</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
<!--
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
var digitos=20 //cantidad de digitos buscados 
var puntero=0 
var buffer=new Array(digitos) //declaraci�n del array Buffer 
var cadena="" 
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 450 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function Proceso(opt)
{
	var f = document.frmPrincipal;

	switch (opt)
	{
		case "GR"://ACTUALIZAR RECEPCION
			f.action = "rec_correlativo_lote.php?Proceso=GR";
			f.submit();	
			break;
		case "GD"://ACTUALIZAR RECEPCION
			f.action = "rec_correlativo_lote.php?Proceso=GD";
			f.submit();	
			break;
		case "S"://SALIR
			frmPrincipal.action = "../principal/sistemas_usuario.php?CodSistema=24";
			frmPrincipal.submit();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form action="" method="post" name="frmPrincipal" >
<?php include("../principal/encabezado.php") ?>
<table width="770" height="330" cellpadding="0" cellspacing="0" class="TablaPrincipal" >
<tr>
<td height="330" align="center" valign="middle">
  <table width="281"  border="0" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="2"><strong>Mantenedor de Correlativo Lote:</strong></td>
  </tr>
  <tr>
    <td width="87" align="right" class="ColorTabla02">Mes/A�o</td>
    <td width="180" class="ColorTabla02" >
	<input name="TxtMes" type="text" class="InputIzq" value="<?php echo strtoupper($TxtMes); ?>" size="2" readonly>
	<input name="TxtAno" type="text" class="InputIzq" value="<?php echo strtoupper($TxtAno); ?>" size="2" readonly>
	</td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Lote Recepcion:</td>
	<td class="ColorTabla02">
	<input name="TxtCorrRecep" type="text" class="InputIzq" value="<?php echo strtoupper($TxtCorrRecep); ?>" size="6" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');">
	<input name="BtnGrabar" type="button" value="Grabar" style="width:70px " onClick="Proceso('GR')">
	</td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Lote Despacho:</td>
	<td class="ColorTabla02">
	<input name="TxtCorrDesp" type="text" class="InputIzq" value="<?php echo strtoupper($TxtCorrDesp); ?>" size="6" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');">
	<input name="BtnGrabar2" type="button" value="Grabar" style="width:70px " onClick="Proceso('GD')">
	</td>
  </tr>
    <td width="87" align="right" class="ColorTabla02">&nbsp;</td>
    <td width="180" class="ColorTabla02" ></td>
  </tr>
 </table>
	<br>
	<table width="281" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
	  <tr bgcolor="#FFFFFF">
	  <td align="center" class="ColorTabla02">
		<input name="BtnSalir" type="button" value="Salir" style="width:70px " onClick="Proceso('S')"> 	  </td>
	</table>
	</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
<?php
if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje');";
	echo "var f = document.frmPrincipal;";
	echo "</script>";
}
?>