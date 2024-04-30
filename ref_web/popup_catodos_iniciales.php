<?php 
include("../principal/conectar_ref_web.php");

$opcion      = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
$recargapag1 = isset($_REQUEST["recargapag1"])?$_REQUEST["recargapag1"]:"";
$recargapag2 = isset($_REQUEST["recargapag2"])?$_REQUEST["recargapag2"]:"";

$mostrar  = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
$dia1     = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:""; 
$mes1     = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";  
$ano1     = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:""; 
$fecha    = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";   
$txt_turno       = isset($_REQUEST["txt_turno"])?$_REQUEST["txt_turno"]:"";
$txt_produccion_mfci = isset($_REQUEST["txt_produccion_mfci"])?$_REQUEST["txt_produccion_mfci"]:"";
$txt_produccion_mdb = isset($_REQUEST["txt_produccion_mdb"])?$_REQUEST["txt_produccion_mdb"]:"";
$txt_produccion_mco = isset($_REQUEST["txt_produccion_mco"])?$_REQUEST["txt_produccion_mco"]:"";
$txt_consumo  = isset($_REQUEST["txt_consumo"])?$_REQUEST["txt_consumo"]:"";
$txt_observacion  = isset($_REQUEST["txt_observacion"])?$_REQUEST["txt_observacion"]:"";
$txt_stock  = isset($_REQUEST["txt_stock"])?$_REQUEST["txt_stock"]:"";
$txt_rechazo_cat_ini  = isset($_REQUEST["txt_rechazo_cat_ini"])?$_REQUEST["txt_rechazo_cat_ini"]:"";

$turno       = isset($_REQUEST["turno"])?$_REQUEST["turno"]:"";
$produccion_mfci = isset($_REQUEST["produccion_mfci"])?$_REQUEST["produccion_mfci"]:"";
$produccion_mdb = isset($_REQUEST["produccion_mdb"])?$_REQUEST["produccion_mdb"]:"";
$produccion_mco = isset($_REQUEST["produccion_mco"])?$_REQUEST["produccion_mco"]:"";
$consumo  = isset($_REQUEST["consumo"])?$_REQUEST["consumo"]:"";
$observacion  = isset($_REQUEST["observacion"])?$_REQUEST["observacion"]:"";
$stock  = isset($_REQUEST["stock"])?$_REQUEST["stock"]:"";
$rechazo_cat_ini  = isset($_REQUEST["rechazo_cat_ini"])?$_REQUEST["rechazo_cat_ini"]:"";


?>
<HTML>
<HEAD>
      <TITLE>=================Sistema Refineria=================Busqueda de Catodos Iniciales=================</TITLE>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">	  	  
<script language="JavaScript">

function Recarga1()
{	
	var f = document.frmPrincipal;
	f.action = "popup_catodos_iniciales.php?recargapag1=S";
	f.submit();
}
/**********/
function Recarga2()
{	
	var f = document.frmPrincipal;
	f.action = "popup_catodos_iniciales.php?recargapag2=S";
	f.submit();
}
/**********/
function Validaciones()
{
      var f = document.frmPrincipal;

    if (f.txt_turno.value == -1)
	{
		alert("Debe Seleccionar un Turno");
        f.txt_turno.focus();
		return false;
  	}
    if (f.txt_produccion_mfci.value == 0)	
	{
		alert("Debe Ingresar la produccion Correspondiente");
        f.txt_produccion_mfci.focus();
		return false;
	}
    if (f.txt_produccion_mdb == 0)
	{
        alert("Debe Ingresar la Produccion Correspondiente");
        f.txt_produccion_mdb.focus();
		return false;
	}
	if (f.txt_produccion_mco == 0)
	{
		alert("Debe Ingresar la Produccion Correspondiente");
        f.txt_produccion_mco.focus();
		return false;
	}
    if (f.txt_consumo == 0)
	{
        alert("Debe Ingresar el Consumo Correspondiente");
        f.txt_consumo.focus();
		return false;
	}
    if (f.txt_observacion == 0)
	{
		alert("Debe Ingresar Observaciones");
        f.txt_observacion.focus();
		return false;
	}

	if (f.txt_stock == 0)
	{
		alert("Debe Ingresar el un Stock");
        f.txt_stock.focus();
		return false;
	}

   if (f.txt_rechazo_cat_ini == 0)
	{
        alert("Debe Ingresar el Total de rechazos");
        f.txt_rechazo_cat_ini.focus();
		return false;
	}
    
   	return true;
}


/***************/
function Guardar()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_cat_ini01.php?proceso=G";
	f.submit();
}

/**********/
function Buscar()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_cat_ini01.php?proceso=B";
	f.submit();
}
/**********/

function Modificar()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_cat_ini01.php?proceso=M";
	f.submit();
}
function Limpiar()
{
	document.location = "popup_catodos_iniciales.php";
}
/**********/
function Salir()
{
	window.close();
}
/**********/
</script>
</HEAD>
<BODY >
<FORM name="frmPrincipal" action="" method="post">
  <?php
?>
<table width="554" height="243" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
  <tr> 
    <td width="766" align="center"> <table width="551" border="0" cellspacing="0" cellpadding="3" class="ColorTabla01">
        <tr> 
          <td width="256" height="20" align="center"><ur> <div align="center">Todos</div></td>
          <td width="256" align="center">Fecha</td>
          <td width="512" align="center">Turno</td>
          <td width="512" align="center">MFCI</td>
          <td width="512" align="center">MCB</td>
          <td width="512" align="center">MCO </td>
          <td width="512" align="center">Observaciones</td>
        </tr>
      </table>
      <p align="left"><font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;</font></p>
      <p align="left"><font face="Arial, Helvetica, sans-serif">&nbsp;</font></p>
      <p align="left"><font face="Arial, Helvetica, sans-serif"> </font></p>
      <div align="left"> </div>
      <div align="left"></div>
      <div align="left"> <font face="Arial, Helvetica, sans-serif"> </font> </div>
      <div align="left"><font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;</font></div>
      <div align="left"><font face="Arial, Helvetica, sans-serif"> </font></div>
      <div align="left"></div>
      <div align="left"></div>
      <div align="left"></div>
      <div align="left"></div>
      <div align="left"></div>
      <div align="left"><font face="Arial, Helvetica, sans-serif"> </font></div>
      <div align="left"></div>
      <div align="left"><font face="Arial, Helvetica, sans-serif"> </font></div>
      <div align="left"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif">&nbsp;</font></font></div>
      <div align="left"></div>
      <div align="left"></div>
      <div align="left"><font face="Arial, Helvetica, sans-serif"> </font></div></td>
  </tr>
  <tr> 
    <td height="34" align="center" valign="middle"> 
      <?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
      <div align="center"><font face="Arial, Helvetica, sans-serif"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input name ="btnModificar" type="button" style="width:70"onClick="Modificar()" value="Modificar">
        <input type="button" name="Submit" value="Limpiar" style="width:70" onClick="Limpiar();">
        </font> 
        <input name ="btnSalir" type="button" onClick="JavaScript:Salir();" style="width:70" value="Salir">
        <br>
      </div></td>
  </tr>
</table>

