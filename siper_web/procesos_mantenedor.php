<?php
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');
	//1:PESTAÑA PARA AGREGAR, MODIFICAR O ELIMINAR ITEM DE LA ORGANICA.
	$CODAREA=ObtenerCodParent($CodSelTarea);
	$CodNivel=ObtenerNivel($CODAREA);	
	if(!isset($TipoPestana)||$CodNivel!='8')
		$TipoPestana='1';

if(isset($Pantalla))
	acceso($CookieRut,$Pantalla);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">

function SeleccionPestana(Opcion)
{

	top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value=Opcion;
	top.frames['Procesos'].location='procesos_mantenedor.php?TipoPestana='+Opcion+'&MostrarCmb=S&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
	//top.frames['Organica'].BuscaItem2(top.frames['Organica'].document.FrmOrganica.SelTarea.value);	
}
</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>
<body>
<form name='Mantenedor' method="post">
<input name="CodSelTarea" type="hidden" value="<?php echo $CodSelTarea;?>">
<input name="Salida" type="hidden" value="C">
<?php
	switch($TipoPestana)
	{
		case "1":
			$Fondo1='imagenes/barra_medium_activa.bmp';
			$LinkPestana1='LinkPestanaActiva';
			$Fondo2='imagenes/barra_medium.bmp';
			$LinkPestana2='LinkPestana';
			$Fondo3='imagenes/barra_medium.bmp';
			$LinkPestana3='LinkPestana';
			$Fondo4='imagenes/barra_medium.bmp';
			$LinkPestana4='LinkPestana';				
		break;
	}
?>
  <table border="0" cellpadding="0" cellspacing="0">
	<tr>
	  <td width="100" height="25"><img src="imagenes/tab_slide_hm_next.gif" ></td>
	  <td width="886" align="center" background="<?php echo $Fondo1;?>"><a href="javascript:SeleccionPestana(1)"><?php echo '<span class="'.$LinkPestana1.'">';?> Mantenedor Área Organizacional</a></td>
	  <td width="5" align="right"><img src="imagenes/tab_separator.gif"></td>
	</tr>
    <tr>
      <td colspan="3" align="center">
	    <?php
		switch($TipoPestana)
		{
			case "1":
				include('proceso_mant_organica.php');
			break;
		}	  
	  ?></td>
    </tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#EBEBEB">
    <tr class="estilos2">
      <td width="15" background="imagenes/interior/form_izq.gif"></td>
      <td align="center" valign="top"></td>
      <td width="15" align="center" background="imagenes/interior/form_der.gif"></td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="imagenes/interior/esq3.gif" width="15" height="15"></td>
      <td  height="15" background="imagenes/interior/form_abajo.gif"><img src="imagenes/interior/transparent.gif" width="4" height="15"></td>
      <td width="15" height="15"><img src="imagenes/interior/esq4.gif" width="15" height="15"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
if($Msj!='')
{
	echo "<script languaje='javascript'>";
	echo "alert('".$Msj."');";
	echo "</script>";
}
?>