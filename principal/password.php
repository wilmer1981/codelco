<?php include("conectar_principal.php");

//////// agregado por WSO //////////
if(isset($_REQUEST["mensaje"])){
	$mensaje = $_REQUEST["mensaje"];
}else{
	$mensaje = "";
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

//Junio 2017 Consulta el parametro de cantidad minima de caracteres
$ConsulCarac="select valor from parametros_auditoria where codigo=3";
$RespCarac=mysqli_query($link, $ConsulCarac);
if($Fila=mysqli_fetch_assoc($RespCarac))
		$caractMin = $Fila["valor"];
?>
<html>
<head>
<title>Cambio de Contrase&ntilde;a</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">

function Proceso(opt)
{
	var f = document.frmPrincipal;
	if(f.P_Actual.value=='' && opt!='S')
	{
		alert("Debe ingresar la contrase�a actual");
		f.P_Actual.focus();
		return;
	}else
	{
		switch (opt)
		{
			case "G":
				switch(alfanumerico(f.P_Nueva.value))
				{
					case "simbolo":
						alert("La contrase\xF1a solo permite n\xFAmeros y letras.");
						f.P_Nueva.value = "";
						f.P_RNueva.value="";
						f.P_Nueva.focus();
						return;
						break;
					case "incorrecta":
						alert("La nueva contrase\xF1a debe contener letras y n\xFAmeros.");
						f.P_Nueva.value = "";
						f.P_RNueva.value="";
						f.P_Nueva.focus();
						return;
						break;
					case "correcta":		
						if (f.P_Actual.value == "")
						{
							alert("Debe ingresar la contrase\xF1a actual.");
							f.P_Nueva.value = "";
							f.P_RNueva.value="";
							f.P_Actual.focus();
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
						if (f.P_Nueva.value == "")
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
						if (f.P_RNueva.value == "")
						{
							alert("Repita nuevamente la contrase\xF1a.");
							f.P_Nueva.value = "";
							f.P_RNueva.value="";
							f.P_Nueva.focus();
							return;
						}
						if (f.P_Nueva.value != f.P_RNueva.value)
						{
							alert("La password nueva y la repetici\xF3n no coinciden.");
							f.P_Nueva.value = "";
							f.P_RNueva.value="";
							f.P_Nueva.focus();
							return;
						}
						document.getElementById("BtnAceptar").style.visibility = 'hidden';
						f.action = "password01.php?Proceso=G";
						f.submit();
						break;
				}
				break;
			case "S":
				window.close();
				break;
		}
	}
}
//Junio 2017 Valida que la contrase�a contenga letras y numeros y que no contenga simbolos
//input: String output:String
function alfanumerico(pwd)  
{ 
 var letras = /[A-Za-z]/;
 var numeros = /[0-9]/;
 var simbolo = /[^A-Za-z0-9]/;  
    if(pwd.match(letras)&&pwd.match(numeros)&&pwd.match(simbolo)==null){
 		return "correcta";  
    }else{
		if (pwd.match(simbolo)!=null)    
			return "simbolo";   
		else
			return "incorrecta";
	}
}    
//Junio 2017 Toda el codigo de respuesta del cambio de contrase�a
//input: integer
function accion(cod)
{	
	document.getElementById("BtnAceptar").style.visibility = 'visible';
	if(cod==1)	//cambio exitoso
	{
		window.close();
		alert('<?php echo $mensaje;?>');
		window.opener.location.href = "sistemas_usuario01.php?Proceso=CS";		
	}
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body background="imagenes/fondo3.gif" onLoad="accion(<?php echo $codigo;?>)">
<form name="frmPrincipal" action="" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="2" class="TablaInterior">
    <tr><td></td><td><strong><span style="color:red;font-size:10px"><?php if (isset($mensaje))echo $mensaje; ?></span></strong><br></td></tr>
      <tr>      
      <td width="100">Usuario</td>
    <td>
	<?php
	$sql = "select * from funcionarios where rut='".$CookieRut."'";
	$result = mysqli_query($link, $sql);
	$ExisteUser="N";
	if ($row = mysqli_fetch_array($result))
	{
		$ExisteUser="S";
		$Nombre = $row["apellido_paterno"]." ".$row["apellido_materno"]." ".$row["nombres"];
		echo ucwords(strtolower($Nombre));
	}
	else
	{
		echo "Usuario no Encontrado";
	}
	?></td>
  </tr>
</table>
    
  <br>
  <table width="100%" border="0" cellspacing="0" cellpadding="2" class="TablaInterior">
      <tr align="center"> 
        <td colspan="2"><strong>CLAVE DE ACCESO</strong></td>
      </tr>
      <tr> 
        <td width="183">Password Actual</td>
        <td width="205"><input name="P_Actual" type="password" id="P_Actual" value="<?php echo $P_Actual;?>"></td>
      </tr>
      <tr> 
        <td>Nueva Password</td>
        <td><input name="P_Nueva" type="password" id="P_Nueva" value="<?php echo $P_Nueva; ?>"><label>(*)</label></td>
      </tr>
      <tr> 
        <td>Repetir Nueva Password</td>
        <td><input name="P_RNueva" type="password" id="P_RNueva" value="<?php echo $P_RNueva; ?>"><label>(*)</label></td>
      </tr>
      <tr>
      <td colspan="2" style="padding-top:15px;font-weight:100">(*)Nota: La contrase&ntilde;a debe tener una combinaci&oacute;n de letras y n&uacute;mero con un m&iacute;nimo de <?php echo $caractMin; ?> caracteres.</td>
      </tr>
    </table>
  <br>
  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr align="center" valign="middle">
    <td><?php if($ExisteUser=="S"){ echo "<input type='button' id='BtnAceptar' name='BtnAceptar' value='Aceptar' onClick=\"JavaScript:Proceso('G');\"  style='width:70px;'>";} ?></td>
    <td><input type="button" name="BtnCancelar" value="Cancelar" onClick="JavaScript:Proceso('S');" style="width:70px;"></td>
  </tr>
  <tr>
  <td><div id="retorno" class="Estilo1"></div></td>
  </tr>
</table>
</form>
</body>
</html>
