<?
include("../principal/conectar_pac_web.php");
if($Proceso == "G")
{
	$fecha = $Ano.'-'.$Mes.'-'.$Dia;

	if($BarroAnod != '' AND $BarroAnod != 0)
	{
		$Elimina = "DELETE FROM raf_web.circulantes WHERE fecha='$fecha'";
		$Elimina.= " AND cod_producto = 49 AND cod_subproducto = 4";
		mysql_query($Elimina);

		$Insertar = "INSERT INTO raf_web.circulantes (fecha,cod_producto,cod_subproducto,unidades,peso)";
		$Insertar.= " VALUES('$fecha',49,4,1,$BarroAnod)";
		mysql_query($Insertar);
	}

	if($BarridoCu != '' AND $BarridoCu != 0)
	{
		$Elimina = "DELETE FROM raf_web.circulantes WHERE fecha='$fecha'";
		$Elimina.= " AND cod_producto = 48 AND cod_subproducto = 10";
		mysql_query($Elimina);

		$Insertar = "INSERT INTO raf_web.circulantes (fecha,cod_producto,cod_subproducto,unidades,peso)";
		$Insertar.= " VALUES('$fecha',48,10,1,$BarridoCu)";
		mysql_query($Insertar);
	}

	if($GranaCu != '' AND $GranaCu != 0)
	{
		$Elimina = "DELETE FROM raf_web.circulantes WHERE fecha='$fecha'";
		$Elimina.= " AND cod_producto = 29 AND cod_subproducto = 1";
		mysql_query($Elimina);

		$Insertar = "INSERT INTO raf_web.circulantes (fecha,cod_producto,cod_subproducto,unidades,peso)";
		$Insertar.= " VALUES('$fecha',29,1,1,$GranaCu)";
		mysql_query($Insertar);
	}

}
	header("Location:raf_ingreso_circulantes_ref.php");
?>