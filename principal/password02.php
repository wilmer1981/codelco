<?php 
	$CodigoDeSistema = 99;
	$CodigoDePantalla = 8;
	include("conectar_index.php");
	
	//////// agregado por WSO //////////
	if(isset($_REQUEST["Titulo2"])){
		$Titulo2 = $_REQUEST["Titulo2"];
	}else{
		$Titulo2 = "";
	}
	if(isset($_REQUEST["codigo"])){
		$codigo = $_REQUEST["codigo"];
	}else{
		$codigo = "";
	}

	$CookieRut = $_COOKIE["CookieRut"]; 
	$P_Actual = '';
	$P_Nueva = '';
	$P_RNueva = '';	
	
	///////////////////////////////////

	$sql = "select * from funcionarios where rut='".$CookieRut."'";
	$result = mysqli_query($link, $sql);

	$Usuario=false;
	if ($row = mysqli_fetch_array($result))
	{	  
		$ExisteUser="S";
		$Nombre = $row["apellido_paterno"]." ".$row["apellido_materno"]." ".$row["nombres"];
		$Titulo = "SU CONTRASE&Ntilde;A A CADUCADO DEBE INGRESAR UNA NUEVA";
		$NombreUsuario = ucwords(strtolower($Nombre));
		$Usuario = true;
	}
	else
	{
		$Titulo = "";
		$NombreUsuario = "NO REGISTRADO";
		$Usuario = false;
	}

	//Junio 2017 Consulta el parametro de cantidad minima de caracteres
	$ConsulCarac="select codigo, valor from parametros_auditoria where codigo=3";
	$RespCarac=mysqli_query($link, $ConsulCarac);
	if($Fila=mysqli_fetch_assoc($RespCarac))
			$caractMin = $Fila["valor"];
			//$codigo    = $Fila["codigo"]; //AGREGADO POR WSO
?>	
<html>
<head>
<title>Administrador de Sistemas</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "G":	
			switch(alfanumerico(f.P_Nueva.value))
			{
				case "simbolo":
					alert("La contrase\xF1a solo permite n\xFAmeros y letras.");
					document.getElementById("titulo").innerHTML = "";
					f.P_Nueva.value = "";
					f.P_RNueva.value="";
					f.P_Nueva.focus();
					return;
					break;
				case "incorrecta":
					alert("La nueva contrase\xF1a debe contener letras y n\xFAmeros.");
					document.getElementById("titulo").innerHTML = "";
					f.P_Nueva.value = "";
					f.P_RNueva.value="";
					f.P_Nueva.focus();
					return;
					break;
				case "correcta":
					document.getElementById("titulo").innerHTML = "";
					if (f.P_Actual.value == "")
					{
						alert("Debe ingresar la contrase\xF1a actual.");
						f.P_Nueva.value = "";
						f.P_RNueva.value="";
						f.P_Actual.focus();
						return;
					}
					if (f.P_Nueva.value == "")
					{
						alert("Debe ingresar una nueva contrase\xF1a.");
						f.P_Nueva.value = "";
						f.P_RNueva.value="";
						f.P_Nueva.focus();
						return;
					}
					var caracMin = <?php echo json_encode($caractMin);?>;
					if (f.P_Nueva.value.length<caracMin)
					{
						alert("La nueva contrase\xF1a debe tener un largo m\xEDnimo de "+caracMin+".");
						f.P_Nueva.value = "";
						f.P_RNueva.value="";
						f.P_Nueva.focus();
						return;
					}
					if (f.P_RNueva.value == "")
					{
						alert("Repita nuevamente la contrase\xF1a.");
						f.P_RNueva.focus();
						return;
					}
					if (f.P_Actual.value == f.P_Nueva.value)
					{
						alert("La contrase\xF1a nueva no puede ser igual a la actual.");
						f.P_Nueva.value = "";
						f.P_RNueva.value="";
						f.P_Nueva.focus();
						return;
					}
					if (f.P_Nueva.value != f.P_RNueva.value)
					{
						alert("La Password nueva y la repetici\xF3n no coinciden.");
						f.P_Nueva.value = "";
						f.P_RNueva.value="";
						f.P_RNueva.focus();
						return;
					}			
					f.action = "password01.php?Proceso=G&Pag=pass02";
					f.submit();
					break;
			}
			break;
		case "S":
			f.action = "../index.php";
			f.submit();
			break;
	}
}
//Junio 2017 Valida que la contraseña contenga letras y numeros y que no contenga simbolos
//input: String output:String
function alfanumerico(pwd)  
{ 
 var letras = /[A-Za-z]/;
 var numeros = /[0-9]/;
 var simbolo = /[^A-Za-z0-9]/;  
 if(pwd.match(letras) && pwd.match(numeros) && pwd.match(simbolo)==null){
 	return "correcta";  
 }else{
	if(pwd.match(simbolo)!=null){ 
		return "simbolo";   
	}else{
		return "incorrecta";
	}
 }
} 
//Junio 2017 Toda el codigo de respuesta del cambio de contraseña
//input: integer
function accion(cod)
{	
	if(cod==1)
	{
		alert('<?php echo $Titulo;?>');
		Proceso('S');	
	}
}

</script>
<style type="text/css">
.Estilo1 {
	color: #FF0000;
	font-weight: bold;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body leftmargin="3" topmargin="2" onLoad="accion(<?php echo $codigo;?>)">
<form name="frmPrincipal" method="post" action="">
<?php include("encabezado.php");?> 
<table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td height="313" align="center" valign="top">
	  
        <br>
        <table width="80%" border="0" cellspacing="0" cellpadding="2" class="TablaInterior">
      <tr align="center">
        <td height="30" colspan="2"><span class="Estilo1" id="titulo"><?php if(isset($Titulo2))echo $Titulo2; else echo $Titulo; ?></span>
        </td>
        </tr>
      <tr> 
      <td width="67">Usuario:</td>
    <td width="528"><?php echo $NombreUsuario;?></td>
  </tr>
</table>
    
  <br>
  <table width="531" border="0" cellspacing="0" cellpadding="2" class="TablaInterior">
      <tr align="center"> 
        <td colspan="2"><strong>CLAVE DE ACCESO</strong></td>
      </tr>
      <tr> 
        <td width="166">Contrase&ntilde;a Actual:</td>
        <td width="354"><input name="P_Actual" type="password" id="P_Actual" value="<?php echo $P_Actual;?>"></td>
      </tr>
      <tr> 
        <td>Nueva Contrase&ntilde;a:</td>
        <td><input name="P_Nueva" type="password" id="P_Nueva" value="<?php echo $P_Nueva; ?>"><label>(*)</label></td>
      </tr>
      <tr> 
        <td>Repetir Nueva Contrase&ntilde;a:</td>
        <td><input name="P_RNueva" type="password" id="P_RNueva" value="<?php echo $P_RNueva; ?>"><label>(*)</label></td>
      </tr>
      <tr>
      <td colspan="2" style="padding-top:15px;font-weight:100">(*)Nota: La contrase&ntilde;a debe tener una combinaci&oacute;n de letras y n&uacute;mero con un m&iacute;nimo de <?php echo $caractMin; ?> caracteres.</td>
      </tr>
    </table>
  <br>
  <table width="70%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr align="center" valign="middle">
    <td width="50%"><?php if ($Usuario==true){ echo "<input type='button' name='BtnAceptar' value='Aceptar' onClick=\"Proceso('G')\"  style='width:70px'>";} ?></td>
    <td width="50%"><input name="BtnSalir" type="button" id="BtnSalir" style="width:70px" onClick="Proceso('S')" value="Salir"></td>
  </tr>
</table>      </td>
    </tr>
  </table>
<?php include("pie_pagina.php");?>
</form>
</body>
</html>
<?php include ("cerrar_principal.php") ?>
