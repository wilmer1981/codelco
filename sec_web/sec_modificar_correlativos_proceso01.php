<?php
	include("../principal/conectar_principal.php");

	$TxtPatente = $_REQUEST["TxtPatente"];
	$TxtGuia  = $_REQUEST["TxtGuia"];
	$TxtCorr  = $_REQUEST["TxtCorr"];  
	$PatenteOri  = $_REQUEST["PatenteOri"];


	$Actualizar = "UPDATE sec_web.guia_despacho_emb SET ";
	$Actualizar.= " num_secuencia = '$TxtCorr' ,patente_guia='".trim($TxtPatente)."'";
	$Actualizar.= " where patente_guia = '".trim($PatenteOri)."' and num_guia='".$TxtGuia."'";
	//echo $Actualizar;
	mysqli_query($link, $Actualizar);
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.frmPrincipal.action='sec_modificar_correlativos.php?Buscar=S';";
	echo "window.opener.document.frmPrincipal.submit();";
	echo "window.close();";
	echo "</script>";

?>