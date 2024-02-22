<?php
ini_set('display_errors',0);

require_once("config/bd_mysqli.php");
require_once("config/template.inc.php");


$rootPath = "/proyecto/sistemas/";

$isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	$isSecure = true;
}
else if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
	$isSecure = true;
}

if ($isSecure)
	$config['url_principal'] = "https://".$_SERVER['SERVER_NAME'];
else
	$config['url_principal'] = "http://".$_SERVER['SERVER_NAME'];

$config['url_path'] = $config['url_principal'].$rootPath;

if($_SERVER['SERVER_NAME'] == '10.18.19.9')
{
	//FUNCIONAMIENTO PARA DESARROLLO ONLY, CUANDO SE PASE A PRODUCCIÃ“N, SE DEBE ELIMINAR LINEA 27
	$isSecure = true;	
}


$config['server_port']	= $_SERVER['SERVER_PORT'];
$config['dir_root'] 	= $_SERVER['DOCUMENT_ROOT'];
$config['dir_uri']		= $_SERVER["REQUEST_URI"];

$config['dir_requeridos'] = $config['dir_root'].$rootPath."config";
$config['dir_html'] = $config['dir_root'].$rootPath."html";
$config['dir_file'] = $config['dir_root'].$rootPath."file";
$config['dir_sict'] = $config['url_principal'].$rootPath."sict";

$pathServer 		= $config['url_principal'].$rootPath;
$pathServerAndPort	= $config['url_principal'].":".$config['server_port'].$rootPath;

//MYSQL
$hostname 	= "VEVMMYSQLP01";
$MysqlUserPHP   = "adm_web";
$MysqlPassPHP   = "codweb2015";
$dbMysql_schema = "cal_web";
?>