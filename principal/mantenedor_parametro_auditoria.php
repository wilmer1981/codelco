<?php 
	include("conectar_principal.php");
	$CodigoDeSistema = 99;
	$CodigoDePantalla = 14;

	if(isset($_GET["mensaje"])){
		$mensaje = $_GET["mensaje"];
	}else{
		$mensaje = "";
	}
	

?>
<html>
<head>
<title>Par�metros de Auditor�a</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<style>
#postit{
position:absolute;
width:330;
padding:5px;
background-color:#006699;
border:2px solid black;
visibility:hidden;
z-index:500;
cursor:hand;
}

</style>
<script language="javascript" src="funciones/funciones_java.js"></script>
<Script language="JavaScript">
function Proceso(opt)
{
	var f = document.FrmMantenedor;     
	var Valores = ""; 	
	switch (opt)
	{
		case "G":

			f.action = "mantenedor_parametro_auditoria01.php";
			f.submit();
			break;
		case "S":
			f.action = "sistemas_usuario.php?CodSistema=99&Nivel=0";
			f.submit();
			break;
	}	
}

//Junio 2017 Funcion que muestra feedback al usuario de su ingreso al sistema
//input: String
function verMensaje(Msj)
{	
	switch(Msj)
	{
		case "E":
			var msj='Datos modificados con �xito';
			alert(msj);
			break;
		case "I":
			var msj='Ingrese solo valores num�ricos';
			alert(msj);
			break;
	}
}

</script>
<style type="text/css">

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

</style></head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body onLoad="verMensaje('<?php echo $mensaje?>')">
<form name="FrmMantenedor" method="post" action="">
<?php include("encabezado.php");?>
  <div align="left"> 
    <table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
      <tr>
        <td height="313" valign="top"><table width="700" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr align="center" valign="middle"> 
              <td>                &nbsp; 
                <input name="BtnGuardar" type="button" value="Guardar" onClick="Proceso('G')" style="width:70px">     
                &nbsp; <input name="BtnSalir" type="button" value="Salir" style="width:70px" onClick="Proceso('S')">
            </td>
            </tr>
          </table>
          <br> 
        <table width="550" border="1" align="center" cellpadding="1" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="10%"><strong><label>C�digo</label></strong></td>
            <td width="50%"><strong><label>Descripci�n</label></strong></td>
            <td width="15%"><strong><label>Valor</label></strong></td>
          </tr>
<?php 
	$Consulta = "select  * from proyecto_modernizacion.parametros_auditoria";
	$Respuesta = mysqli_query($link, $Consulta);
	$ColorTabla = "ColorTabla02";
	while($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($ColorTabla=="ColorTabla02")
			$ColorTabla="";
		else	
			$ColorTabla="ColorTabla02";			
		echo "<tr>\n";
		echo "<td align='center'>".str_pad($Fila["codigo"],2,"0",STR_PAD_LEFT)."</td>\n";
		echo "<td align='center'>".$Fila["descripcion"]."</td>\n";
		echo "<td><input name='txt".$Fila['codigo']."' type='text' value='".$Fila['valor']."' size='15'></td>\n";
		echo "</tr>";
	}
?>
        </table></td>
      </tr>
    </table>
<?php include("pie_pagina.php");?>
</form>
</body>
</html>