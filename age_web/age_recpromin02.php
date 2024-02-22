<?php
	include("../principal/conectar_principal.php");
	if($Proceso=='M')
	{
		$Datos=explode('~~',$Valores);
		$SubProducto=$Datos[0];
		$Rut=$Datos[1];
		$Flujos=$Datos[2];
	}
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style>
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmRegistros;
	switch (opt)
	{
		case "G":
			f.action = "age_recpromin01.php?Proceso=G&SubProducto="+f.SubProducto.value+"&Rut=" + f.Rut.value + "&Flujos=" + f.Flujos.value;
			f.submit();
			break;
		case "S":
			window.opener.document.frmPrincipal.action = "age_recpromin.php?Mostrar=S";
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
	}
}
</script></head>

<body>
<form name="frmRegistros" action="" method="post">
  <table width="400" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr align="center" class="ColorTabla01"> 
      <td colspan="2"><strong>
        <?php
	if ($Proceso == "N")
		echo "Nuevo ";
	if ($Proceso == "M")
		echo "Modificacion de ";
	?>
        Registro</strong></td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td width="61">SubProducto:</td>
      <td width="320"> <select name="SubProducto" style="width:300">
          <option value="S">SELECCIONAR</option>
          <?php
		$Consulta = "select cod_subproducto, descripcion, ";
		$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
		$Consulta.= " from proyecto_modernizacion.subproducto ";
		$Consulta.= " where cod_producto='1' ";
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
      <td>Proveedor:</td>
      <td><select name="Rut" style="width:300">
          <option value='S'>SELECCIONAR</option>
          <?php
			$Consulta = "select * from ram_web.proveedor ";
			$Consulta.= " order by nombre";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{
				if (trim($Rut) == trim($Fila["rut_proveedor"]))
					echo "<option selected value='".trim($Fila["rut_proveedor"])."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre"]."</option>\n";
				else
					echo "<option value='".trim($Fila["rut_proveedor"])."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre"]."</option>\n";
			}
		?>
        </select></td>
    </tr>
    <tr> 
      <td>Flujo:</td>
      <td>
        <select name="Flujos" style="width:300">
		<option value="S">SELECCIONAR</option>
		<?php
			$Consulta ="select cod_flujo,descripcion,lpad(cod_flujo,3,'0') as orden ";
			$Consulta.="from proyecto_modernizacion.flujos where esflujo<>'N' and sistema='RAM' and tipo='E' order by orden";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{
				if ($Flujos == $Fila["cod_flujo"])
					echo "<option selected value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],0,3,STR_PAD_LEFT)."-".$Fila["descripcion"]."</option>";
				else
					echo "<option value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],3,'0',STR_PAD_LEFT)."-".$Fila["descripcion"]."</option>";
			}
		?>
		</select></td>			
    </tr>
    <tr align="center"> 
      <td colspan="2"><input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')"> 
        <input name="BtnSalir" type="submit" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  </table>
</form>
</body>
</html>
