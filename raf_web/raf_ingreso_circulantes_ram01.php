<?
include("../principal/conectar_pac_web.php");
if($Proceso == "G")
{
	$fecha = $Ano.'-'.$Mes.'-'.$Dia;
	if($PrecipitadoCu != '' AND $PrecipitadoCu != 0)
	{
		$Elimina = "DELETE FROM raf_web.circulantes WHERE fecha='$fecha'";
		$Elimina.= " AND cod_producto = 50 AND cod_subproducto = 5";
		mysql_query($Elimina);

		$Insertar = "INSERT INTO raf_web.circulantes (fecha,cod_producto,cod_subproducto,unidades,peso)";
		$Insertar.= " VALUES('$fecha',50,5,1,$PrecipitadoCu)";
		mysql_query($Insertar);
	}

}
	header("Location:raf_ingreso_circulantes_ram.php");
?>