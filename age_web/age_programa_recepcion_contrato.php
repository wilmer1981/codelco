<?php
	include("../principal/conectar_principal.php");

	$Modif = isset($_REQUEST['Modif'])?$_REQUEST['Modif'] : '';
	$EstadoContrato = isset($_REQUEST['EstadoContrato'])?$_REQUEST['EstadoContrato'] : 1;
	$SubProducto    = isset($_REQUEST['SubProducto'])?$_REQUEST['SubProducto'] : '';
	$TxtNumContrato = isset($_REQUEST['TxtNumContrato'])?$_REQUEST['TxtNumContrato'] : '';
	$TxtDescripContrato = isset($_REQUEST['TxtDescripContrato'])?$_REQUEST['TxtDescripContrato'] : '';
	$TxtFechaIni = isset($_REQUEST['TxtFechaIni'])?$_REQUEST['TxtFechaIni'] : '';
	$TxtFechaFin = isset($_REQUEST['TxtFechaFin'])?$_REQUEST['TxtFechaFin'] : '';

	if ($Modif=="S")
	{
		$Consulta = "select * from age_web.contratos where cod_producto='1' and cod_subproducto='".$SubProducto."' ";
		$Consulta.= " and cod_contrato='".$TxtNumContrato."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$TxtDescripContrato=$Fila["descripcion"];
			$TxtFechaIni=$Fila["fecha_inicio"];
			$TxtFechaFin=$Fila["fecha_termino"];
			$EstadoContrato=$Fila["cod_estado"];
		}
	}
?>
<html>
<head>
<title>Sistema de Agencia</title>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript">
function Proceso(opt)
{
	var f  = document.frmContrato;
	switch (opt)
	{
		case "G":
			if (f.SubProducto.value=="S")
			{
				alert("Debe Seleccionar SubProducto");
				f.SubProducto.focus();
				return;
			}
			if (f.TxtNumContrato.value=="")
			{
				alert("Debe Ingresar Num. Contrato");
				f.TxtNumContrato.focus();
				return;
			}
			if (f.EstadoContrato.value=="S")
			{
				alert("Debe Seleccionar Estado del Contrato");
				f.EstadoContrato.focus();
				return;
			}
			if (f.TxtDescripContrato.value=="")
			{
				alert("Debe Ingresar Descrip. del Contrato");
				f.TxtDescripContrato.focus();
				return;
			}
			if (f.TxtFechaIni.value=="")
			{
				alert("Debe Seleccionar Fecha de Inicio");
				f.TxtFechaIni.focus();
				return;
			}
			if (f.TxtFechaFin.value=="")
			{
				alert("Debe Seleccionar Fecha de Termino");
				f.TxtFechaFin.focus();
				return;
			}
			f.TxtNumContrato.value=f.TxtNumContrato.value.toUpperCase();
			f.TxtDescripContrato.value=f.TxtDescripContrato.value.toUpperCase();
<?php			
			if ($Modif=="S")
			{
				echo "f.action = 'age_programa_recepcion01.php?Proceso=MC';";
				echo "f.submit();";
			}
			else
			{
				echo "f.action = 'age_programa_recepcion01.php?Proceso=GC';";
				echo "f.submit();";
			}
?>						
			break;
		case "R":
			f.action = "age_programa_recepcion_contrato.php";
			f.submit();
			break;
		case "E":
			var msg=confirm("¿Seguro que  desea Eliminar Este Contrato Se Eliminaran Todos los Proveedores Ya Ingresados?");
			if (msg==true)
			{
				f.action = "age_programa_recepcion01.php?Proceso=EC";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "L":
			f.action = "age_programa_recepcion01.php?Proceso=LC";
			f.submit();
			break;
		case "S":
			window.opener.document.frmPrincipal.action="age_programa_recepcion.php?CmbContrato="+f.TxtNumContrato.value;
			window.opener.document.frmPrincipal.submit();
			window.close();
			break
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmContrato" action="" method="post">
<table width="650" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr align="center" class="Detalle01">
    <td colspan="4">MODULO DE CONTRATOS </td>
  </tr>
  <tr>
    <td>SubProducto:</td>
    <td colspan="3"><select name="SubProducto" style="width:300" onChange="Proceso('R')">
      <option class="NoSelec" value="S">SELECCIONAR</option>
      <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' and recepcion<>'PMN'";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($SubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
    </select></td>
  </tr>
  <tr>
    <td width="104">Cod. Contrato:</td>
    <td><input name="TxtNumContrato" type="text" id="TxtNumContrato" value="<?php echo $TxtNumContrato; ?>" size="40" maxlength="50"></td>
    <td>Estado:</td>
    <td><select name="EstadoContrato">
	<option class="NoSelec" value="S">SELECCIONAR</option>
<?php
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15006' order by cod_subclase";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($EstadoContrato==$Fila["cod_subclase"])
			echo "<option selected value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
	}
?>	
    </select></td>
  </tr>
  <tr>
    <td>Descripcion:</td>
    <td colspan="3"><input name="TxtDescripContrato" type="text" id="TxtDescripContrato" value="<?php echo $TxtDescripContrato; ?>" size="70" maxlength="255"></td>
  </tr>
  <tr>
    <td>F.Inicio</td>
    <td width="209"><input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="13" maxlength="10" readonly >
      <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> </td>
    <td width="61">F.Termino:</td>
    <td width="111"><input name="TxtFechaFin" type="text" class="InputCen" value="<?php echo $TxtFechaFin; ?>" size="13" maxlength="10" readonly >
      <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"> </td>
  </tr>
  <tr align="center">
    <td height="30" colspan="4"><input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
      <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:70px " onClick="Proceso('E')">
    <input name="BtnLimpiar" type="button" id="BtnLimpiar" value="Limpiar" style="width:70px " onClick="Proceso('L')">
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
</form>
</body>
</html>
