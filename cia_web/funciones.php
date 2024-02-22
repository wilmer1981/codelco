<?php
//esta pagina contiene algunas funciones basicas para el funcionamiento del sitio

//esta funcion calcula y entrega un nuevo codigo para un determinado tipo de equipo
//requiere que exista una conexion abierta con la base de datos
function genera_codigo($tipo,$link)
{
	//se obtiene la cantidad actual de ese tipo de equipos
	$query="select max(right(codigo,5)*1) as cant from";
	if($tipo=="SWF")
		$query.=" software";
	else
		$query.=" hardware";
	$query.=" where codigo like '".$tipo."%';";
	$result=mysql_db_query("cia_web",$query,$link);
	$resp=mysql_fetch_array($result);
	//se construye el string con el nuevo codigo
	$codigo=$tipo;
	$new_number=$resp["cant"]+1;
	$var=5-strlen($new_number);
	for($i=0;$i<$var;$i++)
		$codigo.="0";
	$codigo.=$new_number;
	return $codigo;
}
?>
