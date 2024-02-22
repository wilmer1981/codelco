<?php
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Grupo"])){
		$Grupo=$_REQUEST["Grupo"];
	}else{
		$Grupo="";
	}
?>
<html>
<head>
<title>Proveedores Asociados al Grupo</title>
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
 <table width="611" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
 <tr class="ColorTabla01">
 <td width="80" align="center" >Rut</td>
 <td width="237" align="center" >Nombre Proveedor</td>
 <td width="273" align="center" >Mina/Planta</td>
 </tr>
 <?php
	$Consulta="SELECT  t2.nombre_prv,t1.rut_prv,t3.cod_mina,t3.nombre_mina from sipa_web.grupos_prod_prv t1 inner join sipa_web.proveedores t2 on t1.rut_prv =t2.rut_prv ";
	$Consulta.="left join sipa_web.minaprv t3 on t1.rut_prv=t3.rut_prv and t3.cod_mina=t1.cod_mina ";
	$Consulta.="where t1.cod_grupo='$Grupo' order by t2.nombre_prv";
	//echo $Consulta;
	$RespPrv=mysqli_query($link, $Consulta);
	while($FilaPrv=mysqli_fetch_array($RespPrv))
	{
		echo "<tr bgcolor='#FFFFFF'>";
		echo "<td align='right'>".str_pad($FilaPrv["rut_prv"],10,0,STR_PAD_LEFT)."&nbsp;</td>";
		echo "<td align='left'>".$FilaPrv["nombre_prv"]."</td>";
		echo "<td align='left'>".$FilaPrv["cod_mina"]." - ".$FilaPrv["nombre_mina"]."</td>";
		echo "</tr>";
	}
 ?>
 </table>
</td>
</form>
</body>
</html>