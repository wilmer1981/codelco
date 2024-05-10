<?php
	include("../principal/conectar_principal.php");
	$Orden = isset($_REQUEST['Orden']) ? $_REQUEST['Orden'] : '';
?>
<html>
<head>
<title>Proveedores Sin Flujo</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt,opt2)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "I"://IMPRIMIR
			window.print();
			break;
		case "S"://SALIR
			window.close();
			break;
		case "O"://ORDENAMIENTO	
			f.action='age_prv_relaciones.php?Orden='+opt2;
			f.submit();		
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
<table width="450"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" >
    <td colspan="3" class="ColorTabla02">
	<input name="BtnImprimir" type="button" id="BtnSalir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
	<input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')">
	</td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td colspan="3"><strong>Proveedores Sin Flujo</strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td align="center" width="30"><a href="JavaScript:Proceso('O','R');">Rut</a></td>
    <td align="center" width="95"><a href="JavaScript:Proceso('O','P');">Proveedor</a></td>
	<td align="center" width="95"><a href="JavaScript:Proceso('O','E');">Estado</a></td>
  </tr>
	<?php
		$Consulta="select distinct RUTPRV_A,NOMPRV_A,case when flujo in('S','0') then 'SIN FLUJO' else 'NO RELACIONADO' end as estado_prv from rec_web.proved left join age_web.relaciones on rutprv_a=rut_proveedor ";
		$Consulta.="where flujo is null or flujo in('S','0') ";
		switch($Orden)
		{
			case "R"://ORDENAR POR RUT
				$Consulta.="order by lpad(RUTPRV_A,10,'0') ";
				break;
			case "P"://ORDENAR POR PROVEEDOR
				$Consulta.="order by trim(NOMPRV_A) ";
				break;
			case "E"://ORDENAR POR ESTADO PRV
				$Consulta.="order by estado_prv ";
				break;
			default:
				$Consulta.="order by trim(NOMPRV_A) ";
				break;
		}
		//echo $Consulta;
		$RespPrv=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($RespPrv))
		{
			echo "<tr>";
			echo "<td align='right'>".$Fila["RUTPRV_A"]."</td>";
			echo "<td>".$Fila["NOMPRV_A"]."</td>";
			echo "<td>".$Fila["estado_prv"]."</td>";
			echo "<tr>";
		}
	?>
</table>
</form>
</body>
</html>