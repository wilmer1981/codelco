<?php
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');
	//1:PESTA�A PARA VALIDAR TAREAS.
	//2:ANALISIS DE OPERACIONES
	//2:
	$CODAREA=ObtenerCodParent($CodSelTarea);
	$CodNivel=ObtenerNivel($CODAREA);	
	if(!isset($TipoPestana))
		$TipoPestana='1';

	acceso($CookieRut,$Pantalla);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">

function SeleccionPestana(Opcion)
{

	top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value=Opcion;
	top.frames['Procesos'].location='procesos_operaciones.php?TipoPestana='+Opcion+'&MostrarCmb=S&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
	//top.frames['Organica'].BuscaItem2(top.frames['Organica'].document.FrmOrganica.SelTarea.value);	
	Cargando=top.frames['Procesos'].document.getElementById('load');
    Cargando.innerHTML= '<img src="imagenes/loading2xx.gif" border="0" >';
}
function ValidarTarea(Proceso)
{

	var ValPelCheck='';
	
/*	for (i=1;i<Mantenedor.elements.length;i++)
	{
		//alert(Mantenedor.elements[i].name);
		if (Mantenedor.elements[i].name=="CheckValPel")
		{	
			if(Mantenedor.elements[i].checked)
				ValPelCheck = ValPelCheck + Mantenedor.elements[i].value + "~1" +"//";
			else
				ValPelCheck = ValPelCheck + Mantenedor.elements[i].value + "~0" +"//";
		}	
	}
	//alert(ValPelCheck);
	if(ValPelCheck=='')
	{
		alert('Debe Seleccionar Peligro');
		return;
	}*/
	if(Proceso=='VT')
	{
		if(confirm('Esta Seguro de Validar la Tarea '))
		{	
			ValPelCheck = ValPelCheck.substring(0,(ValPelCheck.length-2));
			Cod='Proceso='+Proceso+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
			top.frames['Procesos'].location='procesos.php?'+Cod;
		}	
	}
	else
	{
		if(confirm('Esta Seguro de Desvalidar la Tarea '))
		{	
			ValPelCheck = ValPelCheck.substring(0,(ValPelCheck.length-2));
			Cod='Proceso='+Proceso+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
			top.frames['Procesos'].location='procesos.php?'+Cod;
		}	
	}
}
function Desvalida(Area,CodPeli)
{
	Cod='Proceso=DVP&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+"&CAREA="+Area+"&CodPeli="+CodPeli;
	top.frames['Procesos'].location='procesos.php?'+Cod;
}
function VerD(CodSelTarea)
{
var f=document.Mantenedor;
window.open("proceso_analisis_peligros_desglose.php?CodSelTarea="+CodSelTarea,"","top=120,left=120,width=1000,height=600,scrollbars=yes,resizable = yes");

}
</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>
<body>
<form name='Mantenedor'>
<input name="CodSelTarea" type="hidden" value="<?php echo $CodSelTarea;?>">
<input name="Salida" type="hidden" value="L">
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
		break;
		case "2":
			$Fondo1='imagenes/barra_medium.bmp';
			$LinkPestana1='LinkPestana';
			$Fondo2='imagenes/barra_medium_activa.bmp';
			$LinkPestana2='LinkPestanaActiva';
			$Fondo3='imagenes/barra_medium.bmp';
			$LinkPestana3='LinkPestana';			
		break;
		case "3":
			$Fondo1='imagenes/barra_medium.bmp';
			$LinkPestana1='LinkPestana';
			$Fondo2='imagenes/barra_medium.bmp';
			$LinkPestana2='LinkPestana';
			$Fondo3='imagenes/barra_medium_activa.bmp';
			$LinkPestana3='LinkPestanaActiva';
		break;
	}
?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	  <td width="1%" height="25"><img src="imagenes/tab_slide_hm_next.gif" ></td>
	  <td width="33%" align="center" background="<?php echo $Fondo1;?>"><a href="javascript:SeleccionPestana(1)"><?php echo '<span class="'.$LinkPestana1.'">';?>Validar Tarea</a></td>
	  <td width="1" ><img src="imagenes/tab_separator.gif"></td>
	  <td width="33%" align="center" background="<?php echo $Fondo2;?>"><a href="javascript:SeleccionPestana(2)"><?php echo "<span class='".$LinkPestana2."'>";?>Resumen<br>An�lisis de Operaciones Divisional</a></td>
	  <td width="1" align="right"><img src="imagenes/tab_separator.gif"></td>
	  <td width="33%" align="center" background="<?php echo $Fondo3;?>"><a href="javascript:SeleccionPestana(3)"><?php echo "<span class='".$LinkPestana3."'>";?>Resumen<br> An�lisis de Peligros </a></td>
	  <td width="1" align="right"><img src="imagenes/tab_separator.gif"></td>
	</tr>
    <tr class="estilos2">
      <td colspan="7" align="center" >
	    <?php
		switch($TipoPestana)
		{
			case "1":
				include('proceso_validar_tarea.php');
			break;
			case "2":
				include('proceso_analisis_operaciones.php');
			break;
			case "3":
				include('proceso_analisis_peligros.php');
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