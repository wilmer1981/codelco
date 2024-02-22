<?php
 
$pagina->set_block($_GET["p"],"SISTEMAS","bSISTEMAS");
$Query = $fx->ObtieneSistemasAsociados();
$Resp = $dataBaseMysql->consulta($Query);
while($Fila = mysqli_fetch_array($Resp))
{
	$pagina->set_var("LINK",$config['url_path'].$Fila["link"]);
	$pagina->set_var("NOMSISTEMA",utf8_decode($Fila["descripcion"]));
	$pagina->set_var("IMAGEN",($Fila["imagen"]));
	$pagina->set_var("logo",($Fila["logo"]));


	$pagina->parse("bSISTEMAS","SISTEMAS",true);
}
?>

