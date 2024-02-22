<?php 	
 	$CodigoDeSistema = 3;
	$CodigoDePantalla =67;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$Encontro=false;
	$Encontro1=false;
	if($Actualizar=='S')
	{
		$TxtGrupo="";
		$TxtFecha="";
		$TxtFechaNueva="";
		$TxtHora="";
		$TxtMinuto="";
		$Lado="";
		$Peso="";
		$Producto="";
	}
	if($Buscar=="S")
	{
		$Encontro="N";
		$Consulta = "select sum(peso_produccion) as peso,cod_lado,descripcion from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= "on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto where cod_grupo= '".$TxtGrupo."' and fecha_produccion='".$TxtFecha."' group by fecha_produccion,cod_grupo";
		//echo $Consulta;
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			$TxtFechaNueva=$TxtFecha;
			$Lado=$Fila[cod_lado];
			$Peso=$Fila["peso"];
			$Producto=$Fila["descripcion"];
			$Encontro="S";
		}
	}
?>
<html>
<head>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="JavaScript">
function Salir()
{
	var Frm=document.FrmProceso;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
}
function Proceso(Opcion)
{
	var Frm=document.FrmProceso;
	
	switch(Opcion)
	{
		case "B":
			if(Frm.TxtGrupo.value == "")
			{
				alert("Ingrese Grupo");
				Frm.TxtGrupo.focus();
				return;
			}
			if(Frm.TxtFecha.value == "")
			{
				alert("Seleccionar Fecha");
				return;
			}
			Frm.action="sec_modifica_fecha_hora_prod.php?Buscar=S";
			Frm.submit();
			break;
		case "G":
			if(parseInt(Frm.TxtHora.value)>23||Frm.TxtHora.value=="")
			{
				alert('Rango Hora 00-23');
				Frm.TxtHora.focus();
				return;
			}
			if(parseInt(Frm.TxtMinuto.value)>59||Frm.TxtMinuto.value=="")
			{
				alert('Rango Minutos 00-59');
				Frm.TxtMinuto.focus();
				return;
			}
			Frm.action="sec_modifica_fecha_hora_prod01.php?Grabar=S";
			Frm.submit();
			break;
		case "R":
			Frm.action="sec_modifica_fecha_hora_prod.php?Actualizar=S";
			Frm.submit();
			break;
		case "S":
			Frm.action= "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=65";
			Frm.submit();		
			break;
	}
}

</script>
<title>Modificacion Fecha Hora Produccion Catodo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="776" align="center" valign="top"
	><table width="490" border="0" class="TablaInterior">
          <tr> 
            <td width="49"><font size="2">&nbsp; </font></td>
            <td width="69"><font size="2">Grupo</font></td>
            <td width="111"><input type="text" name="TxtGrupo" value="<?php echo $TxtGrupo;?>" size="4" maxlength="2"></td>
            <td width="71" rowspan="2" align="center"><input type="button" name="TxtBuscar" size="10" value="Buscar" onClick=Proceso('B')></td>
            <td width="165"><font size="2">&nbsp;
</font> </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Fecha</td>
            <td><input name="TxtFecha" type="text" class="InputCen" value="<?php echo $TxtFecha; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false"></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      <br>
	  <table width="490" border="0" class="TablaInterior">
        <tr>
          <td width="49">&nbsp;</td>
          <td width="69">Nueva Fecha</td>
          <td width="111"><input name="TxtFechaNueva" type="text" class="InputCen" value="<?php echo $TxtFechaNueva; ?>" size="15" maxlength="10" readOnly>
            <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaNueva,TxtFechaNueva,popCal);return false"></td>
          <td width="71">&nbsp;</td>
          <td width="165">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Nueva Hora</td>
          <td colspan="3"><input type="text" name="TxtHora" value="<?php echo $Hora;?>" size="4" maxlength="2">
            :
            <input type="text" name="TxtMinuto" value="<?php echo $Minuto;?>" size="4" maxlength="2"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Producto</td>
          <td colspan="3"><?php echo $Producto;?>&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Lado</td>
          <td><?php echo $Lado;?>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Peso</td>
          <td><?php echo $Peso;?>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
	  <br>	  
	  <table width="490" border="0" class="TablaInterior">
        <tr>
          <td align="center">
		    <?php 
				if($Encontro=="S")
				{
			?>
			<input type="button" name="TxtModif" style="width:80" value="Modificar" onClick="Proceso('G')">
			<?php
				}
			?>
            <input type="button" name="TxtActualizar" style="width:80" value="Actualizar" onClick="Proceso('R')">
			<input type="button" name="TxtSalir" style="width:80" value="Salir" onClick="Proceso('S')"></td>
          </tr>
      </table>	  
	  <p>&nbsp;</p></td>
    </tr>
</table>
 <?php include("../principal/pie_pagina.php");
 
  		echo "<script languaje='JavaScript'>";
		echo "var frm=document.FrmProceso;";
		if($Mensaje <> "")
		{
			echo "alert('Datos Modificados');";
		}
		echo "</script>"
  ?>
</form>
</body>
</html>
