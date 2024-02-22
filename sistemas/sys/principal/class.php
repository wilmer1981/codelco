<?php
session_start();
//print_r($_SESSION);
if(!isset($_GET["p"]))
	$_GET["p"] = "index";	

require("conf.php");
require('conn.php');
require('php/functions.php');


$pagina = new Template($config['dir_html'], "keep");
$pagina->set_file(array("index" => "index.html",
	"gen_solicitud_analisis" => "gen_solicitud_analisis.html",
	"gen_solicitud_analisis01" => "gen_solicitud_analisis01.html",
	"plantilla_solicitud_analisis" => "plantilla_solicitud_analisis.html",
	"modal" => "modal.html"
		));


$fx = new functions();

include("php/".$_GET["p"].".php");

if(!isset($_GET["Process"]))
	$_GET["Process"] = '';
//echo $_GET["p"];
if($_GET["Process"] == '')
{
	$pagina->parse("RENDER",array($_GET["p"]));
	$pagina->p("RENDER");	
}
?>