<?
	$CodigoDeSistema = 12;
	$CodigoDePantalla = 10;
?>
<html>
<head>
<title>Consultas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">


<script language="JavaScript">
function Recarga()
{ 
	var f = formulario;
    f.action = "raf_lista_general.php";
	f.submit();
}

function Ejecutar_Web()
{ 
var f = formulario;
	
	if(f.Hornada.value != '')
	{
		f.action = "raf_con_carga_programada.php";
		f.submit();
	}
	else
	{
		alert("Debe Ingresar Hornada A Buscar");
		f.Hornada.focus();
		return	
	}

}
function Ejecutar_Excel()
{ 
var f = formulario;
	
	if(f.Hornada.value != '')
	{
		f.action = "raf_con_carga_programada_xls.php";
		f.submit();
	}
	else
	{
		alert("Debe Ingresar Hornada A Buscar");
		f.Hornada.focus();
		return	
	}

}


function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=12&Nivel=1&CodPantalla=9";
	f.submit();
}

</script>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<form name="formulario" method="post" action="">
  <? include("../principal/encabezado.php")?>
  <? include("../principal/conectar_principal.php") ?> 
  
<table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
  <tr>
  	  <td height="313" align="center" valign="top"><p><b>C O N F O R M A C I O N&nbsp;&nbsp; 
          H O R N A D A&nbsp;&nbsp; C A R G A &nbsp;&nbsp;P R O G R A M A D A</b></p>
        <table width="412" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
          <tr> 
            <td width="132"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Hornada 
              A Buscar</td>
            <td width="269">&nbsp; 
			<input type="text" name="Hornada" sise="10">
			</td>
        </table>  
		<p>&nbsp;</p>
        <p><br>
        </p>
        <table width="700" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
		  <tr> 
            <td><div align="center">
                <input name="ejecutar_web" type="button"  value="Listar Web" style="width:80" onClick="Ejecutar_Web();">
                <input name="ejecutar_excel" type="button"  value="Listar Excel" style="width:80" onClick="Ejecutar_Excel();">
                <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">			
              </div></td>
          </tr>
      </table>     </td>
  </tr>
</table>
 <? include("../principal/pie_pagina.php")?>  
		
</form>
</body>
</html>
