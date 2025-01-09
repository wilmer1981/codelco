<?php	
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');
	//1:PESTAÑA PARA AGREGAR, MODIFICAR O ELIMINAR ITEM DE LA ORGANICA.
	//2:AGREGAR O QUITAR PELIGROS ASOCIADOS A LAS TAREAS (CODIGO BD CTAREA=8)
	//3:ASIGNAR CONTROLES A LOS PELIGROS DE LA TAREA SELECCIONADA.
	//4:RESUMEN DE LA TAREA SELECCIONADA.
	$CODAREA=ObtenerCodParent($CodSelTarea);
	$CodNivel=ObtenerNivel($CODAREA);	
	if(!isset($TipoPestana))
		$TipoPestana='1';

if(isset($Pantalla))
	acceso($CookieRut,$Pantalla);
?>
<head>
<script language="javascript">
function SeleccionPestana(Opcion)
{

	top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value=Opcion;
	top.frames['Procesos'].location='procesos_organica.php?TipoPestana='+Opcion+'&MostrarCmb=S&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;
	//top.frames['Organica'].BuscaItem2(top.frames['Organica'].document.FrmOrganica.SelTarea.value);	
}
function ValidarFinIdentPel(Proceso)
{

	if(top.frames['Organica'].document.FrmOrganica.SelTarea.value=='')
	{
		alert('Debe Seleccionar Tarea');
		return;
	}	
	if(confirm('Esta Seguro de Finalizar La Identificación de Peligros'))
	{	
		Cod='Proceso='+Proceso+'&Parent='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&CODCONT='+top.frames['Procesos'].document.Mantenedor.CODCONTACTO.value;
		top.frames['Procesos'].location='procesos.php?'+Cod;
	}	
}


</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>
<body>
<form name='Mantenedor' method="post">
<input name="CodSelTarea" type="hidden" value="<?php echo $CodSelTarea;?>">
<input name="Salida" type="hidden" value="L">
 <input type="hidden" name="DatosObsPel" size="200" />

<?php

	switch($TipoPestana)
	{
		/*case "1":
			$Fondo1='imagenes/barra_medium_activa.bmp';
			$LinkPestana1='LinkPestanaActiva';
			$Fondo2='imagenes/barra_medium.bmp';
			$LinkPestana2='LinkPestana';
			$Fondo3='imagenes/barra_medium.bmp';
			$LinkPestana3='LinkPestana';
			$Fondo4='imagenes/barra_medium.bmp';
			$LinkPestana4='LinkPestana';				
		break;*/
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
		case "2":
			$Fondo1='imagenes/barra_medium.bmp';
			$LinkPestana1='LinkPestana';
			$Fondo2='imagenes/barra_medium_activa.bmp';
			$LinkPestana2='LinkPestanaActiva';
			$Fondo3='imagenes/barra_medium.bmp';
			$LinkPestana3='LinkPestana';
			$Fondo4='imagenes/barra_medium.bmp';
			$LinkPestana4='LinkPestana';			
		break;
		case "3":
			$Fondo1='imagenes/barra_medium.bmp';
			$LinkPestana1='LinkPestana';
			$Fondo2='imagenes/barra_medium.bmp';
			$LinkPestana2='LinkPestana';
			$Fondo3='imagenes/barra_medium_activa.bmp';
			$LinkPestana3='LinkPestanaActiva';
			$Fondo4='imagenes/barra_medium.bmp';
			$LinkPestana4='LinkPestana';			
		break;
		case "4":
			$Fondo1='imagenes/barra_medium.bmp';
			$LinkPestana1='LinkPestana';
			$Fondo2='imagenes/barra_medium.bmp';
			$LinkPestana2='LinkPestana';
			$Fondo3='imagenes/barra_medium.bmp';
			$LinkPestana3='LinkPestana';
			$Fondo4='imagenes/barra_medium_activa.bmp';
			$LinkPestana4='LinkPestanaActiva';
		break;
	}
?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	  <td width="1%" height="25"><img src="imagenes/tab_slide_hm_next.gif" ></td>
	  <td width="24%" align="center" background="<?php echo $Fondo1;?>"><a href="javascript:SeleccionPestana(1)"><?php echo "<span class='".$LinkPestana1."'>";?>Identificación de Peligros</a></td>
	  <td width="1" ><img src="imagenes/tab_separator.gif"></td>
	  <td width="24%" align="center" background="<?php echo $Fondo3;?>"><a href="javascript:SeleccionPestana(3)"><?php echo '<span class="'.$LinkPestana3.'">';?>Asignación de Controles</a></td>
	  <td width="1" ><img src="imagenes/tab_separator.gif"></td>
	  <td width="24%" align="center" background="<?php echo $Fondo2;?>"><a href="javascript:SeleccionPestana(2)"><?php echo '<span class="'.$LinkPestana2.'">';?>Asignación de Verificadores</a></td>
	  <td width="1" ><img src="imagenes/tab_separator.gif"></td>
	  <td width="24%" align="center" background="<?php echo $Fondo4;?>"><a href="javascript:SeleccionPestana(4)"><?php echo '<span class="'.$LinkPestana4.'">';?>Resumen</a></td>
	  <td width="1" align="right"><img src="imagenes/tab_separator.gif"></td>
	</tr>
    <tr class="estilos2">
      <td colspan="9" align="center" >
	    <?php
		switch($TipoPestana)
		{
			case "1":
				include('proceso_ident_peligros.php');
			break;
			case "2":
				include('proceso_asigna_verificador.php');
			break;
			case "3":
				include('proceso_asigna_controles.php');
			break;		
			case "4":
				include('proceso_resumen_tarea.php');
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
	echo "<script languaje='javascript'>";
	if($MsjN=='1'&&isset($MsjN))
		echo "alert('No se puede validar, Existen Peligros sin Controles Asociados.');";
	echo "</script>";

?>