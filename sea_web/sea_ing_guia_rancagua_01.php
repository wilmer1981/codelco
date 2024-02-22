<?php
include("../principal/conectar_rec_web.php");

	$arreglo = split("/")
if (Proceso=='GO')
{
	$seleccionar = "Select * From tabla_rancagua where guia_rancagua = '".$guia_origen."'  and  ......";
	$resultado = mysqli_query($link, $seleccionar);
	if ($Fila = mysqli_fetch_array($resultado))
	{
		$guia_origen =  $Fila[guia_origen];
		$lote_origen =  $Fila[lote_origen];
		$patente_tren = $Fila[patente_tren];
		$peso_origen =  $Fila[peso_origen];
	}
				
} 			

if($Proceso == "G")
{
	if(strlen($dia) == 1)
		$dia = "0".$dia;

	if(strlen($mes) == 1)
		$mes = "0".$mes;

	$fecha = $ano.'-'.$mes.'-'.$dia;

	$patente = strtoupper($patente);
	
	
		gra
	$Insertar = "INSERT INTO sipa_web.recepciones (FECHA, RUT_PRV, GUIA_DESPACHO, PATENTE, LOTE, RECARGO, COD_PRODUCTO,COD_SUBPRODUCTO, PESO_NETO)";
	$Insertar = "$Insertar VALUES('$fecha','$cmbproveedor',$guia,'$patente',$lote_ventana,$recargo,'1','17',$peso_recepcion)";
	mysqli_query($link, $Insertar);
}
?>
