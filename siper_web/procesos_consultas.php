<?phpphp
	include('conectar_consulta.php');
	include('funciones/siper_funciones.php');
	//1:PESTAÑA PARA VALIDAR TAREAS.
	//2:ANALISIS DE OPERACIONES
	$CookieRut   = isset($_COOKIE['CookieRut'])?$_COOKIE['CookieRut']:"";
	$CodSelTarea = isset($_REQUEST["CodSelTarea"])?$_REQUEST["CodSelTarea"]:"";
	$TipoPestana = isset($_REQUEST["TipoPestana"])?$_REQUEST["TipoPestana"]:"";
	$Pantalla    = isset($_REQUEST["Pantalla"])?$_REQUEST["Pantalla"]:0;
	$MostrarCmb  = isset($_REQUEST["MostrarCmb"])?$_REQUEST["MostrarCmb"]:"";
	$Msj         = isset($_REQUEST["Msj"])?$_REQUEST["Msj"]:"";
	$Consulta    = isset($_REQUEST["Consulta"])?$_REQUEST["Consulta"]:"";
	$CmbRut      = isset($_REQUEST["CmbRut"])?$_REQUEST["CmbRut"]:"";
	$CmbIdent    = isset($_REQUEST["CmbIdent"])?$_REQUEST["CmbIdent"]:"";
	$CmbValidado = isset($_REQUEST["CmbValidado"])?$_REQUEST["CmbValidado"]:"";	
	$OptSoloTareaNivel  = isset($_REQUEST["OptSoloTareaNivel"])?$_REQUEST["OptSoloTareaNivel"]:"";
	$CmbPeligros = isset($_REQUEST["CmbPeligros"])?$_REQUEST["CmbPeligros"]:"";

	
	$CODAREA  = ObtenerCodParent($CodSelTarea);
	$CodNivel = ObtenerNivel($CODAREA,$link);	
	if($TipoPestana=="")
		$TipoPestana='1';
	
	set_time_limit('3000');
		
	if($Pantalla!="" && $CookieRut!="")
		acceso($CookieRut,$Pantalla,$link);
	else
		acceso('9999999-9',$Pantalla,$link);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">

function SeleccionPestana(Opcion)
{

	top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value=Opcion;
	top.frames['Procesos'].location='procesos_consultas.php?TipoPestana='+Opcion+'&MostrarCmb=S&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
	//top.frames['Organica'].BuscaItem2(top.frames['Organica'].document.FrmOrganica.SelTarea.value);
	
}
function ValidarTarea(Proceso)
{

	var ValPelCheck='';
	
	for (i=1;i<Mantenedor.elements.length;i++)
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
	}
	if(confirm('Esta Seguro de Validar la Tarea y Peligros Asociados'))
	{	
		ValPelCheck = ValPelCheck.substring(0,(ValPelCheck.length-2));
		Cod='Proceso='+Proceso+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+"&DatosPel="+ValPelCheck;
		top.frames['Procesos'].location='procesos.php?'+Cod;
	}	
}
</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>
<body>
<form name='Mantenedor'>
<input name="CodSelTarea" type="hidden" size="100" value="<?php echo $CodSelTarea;?>">
<input name="Salida" type="hidden" value="L">
<?phpphp
	
	switch($TipoPestana)
	{
		case "1":
			$Fondo1='imagenes/barra_medium_activa.bmp';
			$LinkPestana1='LinkPestanaActiva';
			$Fondo2='imagenes/barra_medium.bmp';
			$LinkPestana2='LinkPestana';
		break;
		case "2":
			$Fondo1='imagenes/barra_medium.bmp';
			$LinkPestana1='LinkPestana';
			$Fondo2='imagenes/barra_medium_activa.bmp';
			$LinkPestana2='LinkPestanaActiva';
		break;
	}
?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	  <td width="9%" height="25"><img src="imagenes/tab_slide_hm_next.gif" ></td>
	  <td width="45%" align="center" background="<?phpphp echo $Fondo1;?>"><a href="javascript:SeleccionPestana(1)"><?phpphp echo '<span class="'.$LinkPestana1.'">';?>Consulta Tareas </a></td>
	  <td width="1" ><img src="imagenes/tab_separator.gif"></td>
	  <td width="45%" align="center" background="<?phpphp echo $Fondo2;?>"><a href="javascript:SeleccionPestana(2)"><?phpphp echo "<span class='".$LinkPestana2."'>";?>Consulta Peligros  </a></td>
	  <td width="1" align="right"><img src="imagenes/tab_separator.gif"></td>
	</tr>
    <tr class="estilos2">
      <td colspan="9" align="center" >
	    <?phpphp
		switch($TipoPestana)
		{
			case "1":
				include('proceso_consulta_tareas.php');
			break;
			case "2":
				include('proceso_consulta_peligros.php');
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
<?phpphp
if($Msj!='')
{
	echo "<script languaje='javascript'>";
	echo "alert('".$Msj."');";
	echo "</script>";
}
?>