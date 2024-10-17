<?php
	include("../principal/conectar_principal.php");
	//CODIGO PROD. SUBPROD.
	$SA          = isset($_REQUEST["SA"])?$_REQUEST["SA"]:"";
	$Producto    = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	
	$Consulta = "select * from cal_web.solicitud_analisis ";
	$Consulta.= " where nro_solicitud='".$SA."'";
	$Consulta.= " order by recargo";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$Producto = $Fila["cod_producto"];
		$SubProducto = $Fila["cod_subproducto"];
	}
	//DESCRIPCION PROD Y SUBPROD
	$Consulta = "select t1.descripcion as nom_prod, t2.descripcion as nom_subprod ";
	$Consulta.= " from proyecto_modernizacion.productos t1 inner join proyecto_modernizacion.subproducto t2";
	$Consulta.= " on t1.cod_producto = t2.cod_producto ";
	$Consulta.= " where t2.cod_producto = '".$Producto."' and t2.cod_subproducto='".$SubProducto."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$NomProd = $Fila["nom_prod"];
		$NomSubProd = $Fila["nom_subprod"];
	}
?>
<html>
<head>
<title>Sistema de C. Calidad</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmPopUp;
	switch (opt)
	{
		case "C":
			var Valores="";			
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkRecargo" && f.elements[i].checked==true)
				{					
					var Valores = Valores + f.SA.value + "//" + f.elements[i].value + "//" + f.elements[i+1].value + "//" + f.elements[i+2].value + "//" + f.elements[i+3].value + "~~";
				}
			}
			if (Valores=="")
			{
				alert("Debe seleccionar un elemento a lo menos para Cambiar de Estado");
				return;
			}
			else
			{
				f.action = "cal_historial_solicitudes01.php?Proceso=EA&Valores=" + Valores;
				f.submit();
			}
			break;
		case "S":
			window.opener.document.FrmGeneracion.action="cal_historial_solicitudes.php?SA=//"+f.SA.value+"//&Mostrar=I";
			window.opener.document.FrmGeneracion.submit();
			window.close();
			break;
	}
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<form name="frmPopUp" action="" method="post">
<table width="450" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr>
    <td colspan="2">Nro. S.A.: </td>
    <td colspan="2"><?php echo substr($SA,4);?><input type="hidden" name="SA" value="<?php echo $SA; ?>"></td>
    </tr>
  <tr>
    <td colspan="2">Producto:</td>
    <td colspan="2"><?php echo strtoupper($NomProd); ?></td>
    </tr>
  <tr>
    <td colspan="2">SubProducto:</td>
    <td colspan="2"><?php echo strtoupper($NomSubProd); ?></td>
    </tr>
  <tr align="center">
    <td colspan="4"><input type="button" name="BtnCambiar" value="Cambiar" style="width:60px " onClick="Proceso('C')">
    <input type="button" name="BtnSalir" value="Salir" style="width:60px " onClick="Proceso('S')"></td>
  </tr>
  <tr class="ColorTabla01">
    <td width="19">Cambiar</td>
    <td width="19">Rec.</td>
    <td width="88">Estado Actual </td>
    <td width="197">Estado Anterior </td>
  </tr>
<?php
	$Consulta = "select t1.nro_solicitud, t1.recargo, t1.estado_actual, t2.nombre_subclase, t3.fecha_hora as fecha_hora_est_actual";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t2";
	$Consulta.= " on t2.cod_clase='1002' and t1.estado_actual = t2.cod_subclase inner join cal_web.estados_por_solicitud t3 ";
	$Consulta.= " on t1.nro_solicitud=t3.nro_solicitud and t1.recargo = t3.recargo and t1.estado_actual=t3.cod_estado ";
	$Consulta.= " where t1.nro_solicitud='".$SA."'";
	$Consulta.= " order by recargo";
 //echo "CC".$Consulta;
	$Resp = mysqli_query($link, $Consulta);
	$i=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr>\n";
		echo "<td align='center'><input type='checkbox' name='ChkRecargo' value='".$Fila["recargo"]."'>";
		echo "<input type='hidden' name='EstActual' value='".$Fila["estado_actual"]."'>";
		echo "<input type='hidden' name='FechaHoraEstActual' value='".$Fila["fecha_hora_est_actual"]."'>";
		echo "</td>\n";
    	echo "<td align='center'>".$Fila["recargo"]."</td>\n";
		echo "<td>".$Fila["nombre_subclase"]."</td>\n";
		//CONSULTA ESTADOS POR LOS QUE HA PASADO EL RECARGO
		$Consulta = "select t1.cod_estado, t1.fecha_hora, t2.nombre_subclase";
		$Consulta.= " from cal_web.estados_por_solicitud t1";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t2";
		$Consulta.= " on t2.cod_clase='1002' and t1.cod_estado = t2.cod_subclase";
		$Consulta.= " where t1.nro_solicitud='".$SA."'";
		$Consulta.= " and t1.recargo='".$Fila["recargo"]."'";
		$Consulta.= " and t1.cod_estado < 50";
		$Consulta.= " order by fecha_hora";
  //echo "RR".$Consulta;
		$Resp2 = mysqli_query($link, $Consulta);
		echo "<td align='center'><select name='EstNuevo[$i]'>";
		echo "<option value='S'>SELECCIONAR</option>";
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{			
    		echo "<option selected value='".$Fila2["cod_estado"]."'>".$Fila2["nombre_subclase"]." | ".$Fila2["fecha_hora"]."</option>\n";			
		}
		echo "</select></td>";
  		echo "</tr>\n";
		$i++;
	}
?>    
</table>
</form>
</body></html>
