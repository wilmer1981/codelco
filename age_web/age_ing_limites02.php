<?php
	include("../principal/conectar_principal.php");

	$Accion = isset($_REQUEST["Accion"])?$_REQUEST["Accion"]:"";
	$Tipo   = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
	$CmbSubProducto  = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor    = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$TxtCodigo       = isset($_REQUEST["TxtCodigo"])?$_REQUEST["TxtCodigo"]:"";
	$TxtDescripcion  = isset($_REQUEST["TxtDescripcion"])?$_REQUEST["TxtDescripcion"]:"";
	

	if ($Accion=="N")
	{
		$Consulta = "select ifnull(max(lpad(cod_plantilla,4,'0')),0) as codigo from age_web.limites ";
		$Resp=mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
			$TxtCodigo=$Fila["codigo"]+1;
		else
			$TxtCodigo=1;
	}
	if ($Accion=="M")
	{
		$Consulta = "select * from age_web.limites where cod_plantilla='".$TxtCodigo."' ";
		$Resp=mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
			$TxtDescripcion=$Fila["descripcion"];
	}
		
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript">
function Proceso(opt)
{
	var f=frmPopUp
	switch (opt)
	{
		case "R":
			f.action="age_ing_limites02.php";
			f.submit();
			break;
		case "S":
			window.opener.document.frmPrincipal.action="age_ing_limites.php";
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
		case "G":
			if (f.TxtCodigo.value=="")
			{
				alert("No hay Codigo Asignado");
				return;
			}
			if (f.TxtDescripcion.value=="")
			{
				alert("Debe Ingresar una Descripcion");
				f.TxtDescripcion.focus();
				return;
			}
			f.TxtDescripcion.value=f.TxtDescripcion.value.toUpperCase();
			f.action="age_ing_limites01.php?Proceso=G";
			f.submit();
			break;
		case "E":
			if (f.TxtCodigo.value=="")
			{
				alert("No hay Codigo Asignado");
				return;
			}		
			if (confirm("¿Seguro que desea eliminar esta Plantilla y todos sus Datos?"))	
			{
				f.action="age_ing_limites01.php?Proceso=E";
				f.submit();
			}
			break;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<form name="frmPopUp" action="" method="post">
<input type="hidden" name="Accion" value="<?php echo $Accion; ?>">
<table width="450"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" >
    <td colspan="3" class="Detalle01"><strong>Ingreso de Nueva Plantilla </strong></td>
  </tr>
  <tr align="center">
    <td colspan="3"><?php
	switch ($Tipo)
	{
		case "L":		
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='L' checked><strong>Limite de Control &nbsp;&nbsp;&nbsp;&nbsp;</strong>\n";
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='P'>Penalidad\n";
			break;
		case "P":
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='L'>Limite de Control &nbsp;&nbsp;&nbsp;&nbsp;\n";
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='P' checked><strong>Penalidad</strong>\n";
			break;
		default:
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='L' checked><strong>Limite de Control &nbsp;&nbsp;&nbsp;&nbsp;</strong>\n";
			echo "<input onClick=\"Proceso('R')\" name='Tipo' type='radio' value='P'>Penalidad\n";
			break;
	}
?></td>
    </tr>
  <tr>
    <td>SubProducto:</td>
    <td width="397">
        
        <?php
			if ($Accion=="N")
			{			
				echo "<select name='CmbSubProducto' style='width:300' onChange=\"Proceso('R')\">\n";
				echo "<option class='NoSelec' value='S'>GENERICA</option>\n";
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
				echo "</select>\n";
			}
			else
			{
				if ($CmbSubProducto=="S")
				{
					echo "GENERICA";
				}
				else
				{
					$Consulta = "select cod_subproducto, descripcion, ";
					$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
					$Consulta.= " from proyecto_modernizacion.subproducto ";
					$Consulta.= " where cod_producto='1' ";
					$Consulta.= " and cod_subproducto='".$CmbSubProducto."' ";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Resp))
					{					
						echo str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"]);
					}
				}
				echo "<input name='CmbSubProducto' type='hidden' value='".$CmbSubProducto."'>\n";
			}
			  ?>			 
    </td>
  </tr>
  <tr>
    <td>Proveedor:</td>
    <td>
        <?php
			if ($Accion=="N")
			{		
				echo "<select name='CmbProveedor' style='width:300'>\n";
       			echo "<option class='NoSelec' value='S'>GENERICA</option>\n";
				$Consulta = "select * from rec_web.proved t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rutprv_a=t2.rut_proveedor ";
				$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$CmbSubProducto."'";
				$Consulta.= " order by t1.nomprv_a";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["RUTPRV_A"])
						echo "<option selected value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
					else
						echo "<option value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
				}
				echo "</select>\n";
			}
			else
			{
				if ($CmbProveedor=="S")
				{
					echo "GENERICA";
				}
				else
				{
					
					$Consulta = "select * from rec_web.proved t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rutprv_a=t2.rut_proveedor ";
					$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$CmbSubProducto."'";
					$Consulta.= " and t2.rut_proveedor='".$CmbProveedor."'";
					$Consulta.= " order by t1.nomprv_a";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Resp))
					{
						echo str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".strtoupper($Fila["NOMPRV_A"]);
					}
				}
				echo "<input name='CmbProveedor' type='hidden' value='".$CmbProveedor."'>\n";
			}
			?>
  </td>
  </tr>
  <tr class="Detalle01">
    <td>Codigo:</td>
    <td><input name="TxtCodigo" type="text" class="InputCen" id="TxtCodigo" value="<?php echo $TxtCodigo; ?>" size="10" maxlength="10" readonly></td>
  </tr>
  <tr class="Detalle01">
    <td>Descripcion: </td>
    <td>    <input name="TxtDescripcion" type="text" class="InputIzq" id="TxtDescripcion" value="<?php echo $TxtDescripcion; ?>" size="50" maxlength="60"></td>
  </tr>
  <tr align="center">
    <td height="35" colspan="3">
      <input name="BtnGuardar" type="button" id="BtnOK3" value="Guardar" style="width:70px " onClick="Proceso('G')">
      <input name="BtnEliminar" type="button" id="BtnGuardar" value="Eliminar" style="width:70px " onClick="Proceso('E')">
    <input name="BtnCerrar" type="button" id="BtnSalir2" value="Cerrar" style="width:70px " onClick="Proceso('S')">    </td>
  </tr>
</table>
</form>
</body>
</html>
