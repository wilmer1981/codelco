<?php
session_start();

if(!isset($_GET["p"]))
	$_GET["p"] = "index";	

require("conf.php");
require('conn.php');
//require('php/functions.php');

$pagina = new Template($config['dir_html'], "keep");
$pagina->set_file(array("index" => "index.html",
	"menu" => "menu.html",
	"changepass" => "changepass.html"
	
		));


$fx = new functions();

include("php/".$_GET["p"].".php");

if(!isset($_GET["Process"]))
	$_GET["Process"] = '';

if($_GET["Process"] == '')
{
	$pagina->parse("RENDER",array($_GET["p"]));
	$pagina->p("RENDER");	
}
?>