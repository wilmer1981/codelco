<?php
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');
	//1:PESTAÑA CONSULTA MEDICIONES PERSONALES.
	//2:PESTAÑA CONSULTA MEDICIONES AMBIENTALES
	//3:PESTAÑA CONSULTA EXAMENES DE LABORATORIO.
	//4:CONSULTAS.
	$CODAREA=ObtenerCodParent($CodSelTarea);
	$CodNivel=ObtenerNivel($CODAREA);	
	if(!isset($TipoPestana))
		$TipoPestana='1';
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script  language="JavaScript" src="funciones/siper_funciones.js"></script>
<script language="javascript">
function Salir()
{
	var f=document.Mantenedor;
	
	f.action= "../principal/sistemas_usuario.php?CodSistema=29";
	f.submit();

}
function SeleccionPestana(Opcion)
{
	var f=document.Mantenedor;
	
	f.PestanaActiva.value=Opcion;
	f.Buscar.value='';
	f.SelTarea.value='';
	f.Navega.value='';
	f.Estado.value='';
	f.action='consultas_hi.php?TipoPestana='+Opcion;
	f.submit();
}
function BuscaHijos(Codigo,Filtro)
{
	var f=document.Mantenedor;
	var Estados='';
	
	f.Buscar.value="";
	f.Navega.value=Codigo;
	f.Estado.value=Codigo;
	if(Filtro!='S')
	  f.SelTarea.value='';
	var EstadoItem='';
	
	EstadoItem=f.Estado.value.split(",");
	for (var i=0;i<EstadoItem.length;i++)
	{
		if(EstadoItem[i]!='')
			Estados=Estados+"A,";
	}
	f.Estado.value=Estados.substr(Estados,Estados.length-2,2);
	f.Estado.value=f.Estado.value+"C";
	
	f.action='consultas_hi.php?TipoPestana='+f.PestanaActiva.value;
	f.submit();
}
function ItemSelec(Codigo)
{
	var f=document.Mantenedor;
	
	f.SelTarea.value=Codigo;
	f.action='consultas_hi.php?TipoPestana='+f.PestanaActiva.value;
	f.submit();

}
function ValidaDifFecha()
{
		var f=document.Mantenedor;
		var dif=CalculaDias(f.TxtFechaIni.value,f.TxtFechaFin.value)
		if(f.TxtFechaIni.value!=''&&f.TxtFechaFin.value!='')
		{
			dif=(dif);
			if(dif<0)
			{
				alert('Fecha Termino no puede ser Menor a Fecha Inicio');
				f.TxtFechaFin.focus();
			}
		}
}

</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consultas Higiene Industrial</title>
</head>
<body>
<form name='Mantenedor'  method="post">
<input type="hidden" name="PestanaActiva"  value="<?php echo $TipoPestana;?>">
<input type="hidden" value="<?php echo $Navega;?>" name="Navega">
<input type="hidden" value="<?php echo $Estado;?>" name="Estado">
<input type="hidden" value="<?php echo $SelTarea;?>" name="SelTarea">
<input type="hidden" name="Buscar"  value="<?php echo $Buscar;?>">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td colspan="9" align="center"><img src="imagenes/cab_hi.jpg" alt="" height="52" border="0"></td>
		</tr>
		<tr>
		<td colspan="9" background="imagenes/bg_sup.gif" class="BordeTop" align="right">
		<font style="FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #9c3031; FONT-FAMILY: Arial, Helvetica, sans-serif">
		<?php 
		ObtieneUsuario($CookieRut,&$NombreUser);
		echo "Usuario: ".$NombreUser;?>	</font>
		<a href="Manual_Usuario_hi.pdf" target="_blank">
		</font><img src="imagenes/acrobat.png" alt='Manual de Usuario' width="25" height="25" border="0"></a><a href="javascript:Salir();"><img src="imagenes/btn_volver3.png" alt='Salir' width="25" height="25" border="0"></a>&nbsp;&nbsp;</td>
		</tr>
		<tr><td colspan="9">&nbsp;</td></tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	  	  <td width="1%"><img src="imagenes/tab_slide_hm_next.gif" ></td>
		  <td width="32%" align="center" background="<?php echo $Fondo1;?>"><a href="javascript:SeleccionPestana(1)"><?php echo '<span class="'.$LinkPestana1.'">';?>Consulta Mediciones Personales</a></td>
		  <td width="1%" ><img src="imagenes/tab_separator.gif"></td>
		  <td width="32%" align="center" background="<?php echo $Fondo2;?>"><a href="javascript:SeleccionPestana(2)"><?php echo "<span class='".$LinkPestana2."'>";?>Consulta Mediciones Ambientales</a></td>
		  <td width="1%" ><img src="imagenes/tab_separator.gif"></td>
		  <td width="32%" align="center" background="<?php echo $Fondo3;?>"><a href="javascript:SeleccionPestana(3)"><?php echo '<span class="'.$LinkPestana3.'">';?>Consulta Examenes de Laboratorio</a></td>
	  	  <td width="1%" align="right"><img src="imagenes/tab_separator.gif"></td>
	</tr>
    <tr class="estilos2">
      <td colspan="9" align="center" >
	    <?php
		switch($TipoPestana)
		{
			case "1":
				include('consulta_mediciones_personales.php');
			break;
			case "2":
				include('consulta_mediciones_ambientales.php');
			break;
			case "3":
				include('consulta_examenes_laboratorio.php');
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