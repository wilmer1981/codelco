<?php
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Grupo"])){
		$Grupo = $_REQUEST["Grupo"];
	}else{
		$Grupo = "";
	}

?>
<html>
<head>
<title>Productos y SubProductos Asociados al Grupo</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Datos="";
	
	switch(TipoProceso)
	{
		case 'S'://SALIR
			window.close();
			break;
	}
	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
 <table width="461" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
 <tr class="ColorTabla01">
 <td align="center" >Cod</td>
 <td align="center" >Producto</td>
 <td align="center" >Cod</td>
 <td align="center" >Sub-Producto</td>
 </tr>
 <?php
	$Consulta="SELECT  t1.cod_producto,t1.cod_subproducto,t2.abreviatura as nom_prod,t3.descripcion as nom_subprod ";
	$Consulta.="from sipa_web.grupos_prod_subprod t1 inner join proyecto_modernizacion.productos t2 on ";
	$Consulta.="t1.cod_producto =t2.cod_producto inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto =t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.="where t1.cod_grupo='$Grupo' order by t2.abreviatura,t3.descripcion";
	$RespProd=mysqli_query($link, $Consulta);
	while($FilaProd=mysqli_fetch_array($RespProd))
	{
		echo "<tr bgcolor='#FFFFFF'>";
		echo "<td align='right'>".str_pad($FilaProd["cod_producto"],2,0,STR_PAD_LEFT)."&nbsp;</td>";
		echo "<td align='left'>".$FilaProd["nom_prod"]."</td>";
		echo "<td align='right'>".str_pad($FilaProd["cod_subproducto"],2,0,STR_PAD_LEFT)."&nbsp;</td>";
		echo "<td align='left'>".$FilaProd["nom_subprod"]."</td>";
		echo "</tr>";
	}
 ?>
 </table>
</td>
</form>
</body>
</html>