<?php
	include("../principal/conectar_principal.php");
		$Consulta = "CREATE TABLE sipa_web.sipa_carga_puerto_ventana (
  PATENTE varchar(15) DEFAULT NULL,
  FECHA varchar(255) DEFAULT NULL,
  GUIA varchar(10) DEFAULT NULL,
  PESO_BRUTO int(10) DEFAULT NULL,
  PESO_TARA int(10) DEFAULT NULL,
  PESO_NETO int(10) DEFAULT NULL,
  LOTE_VENTANA varchar(10) DEFAULT NULL,
  RUT_MINERA varchar(255) DEFAULT NULL,
  COD_CLASE varchar(255) DEFAULT NULL,
  COD_CONJUNTO varchar(255) DEFAULT NULL,
  COD_GRUPO varchar(255) DEFAULT NULL,
  COD_MINA varchar(255) DEFAULT NULL,
	SA bigint(10) DEFAULT NULL,
  SQL_INSERT varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
";
$Resp = mysqli_query($link, $Consulta);
	
	