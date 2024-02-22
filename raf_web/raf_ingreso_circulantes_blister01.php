<?
include("../principal/conectar_pac_web.php");
if($Proceso == "G")
{
	$fecha = $Ano.'-'.$Mes.'-'.$Dia;

	if($BlisterBasc != '' AND $BlisterBasc != 0)
	{
		$Elimina = "DELETE FROM raf_web.circulantes WHERE fecha='$fecha'";
		$Elimina.= " AND cod_producto = 16 AND cod_subproducto = 41";
		mysql_query($Elimina);

		$Insertar = "INSERT INTO raf_web.circulantes (fecha,cod_producto,cod_subproducto,unidades,peso)";
		$Insertar.= " VALUES('$fecha',16,41,1,$BlisterBasc)";
		mysql_query($Insertar);
	}

	if($BlisterRet1 != '' AND $BlisterRet1 != 0)
	{
		$Elimina = "DELETE FROM raf_web.circulantes WHERE fecha='$fecha'";
		$Elimina.= " AND cod_producto = 16 AND cod_subproducto = 42";
		mysql_query($Elimina);

		$Insertar = "INSERT INTO raf_web.circulantes (fecha,cod_producto,cod_subproducto,unidades,peso)";
		$Insertar.= " VALUES('$fecha',16,42,1,$BlisterRet1)";
		mysql_query($Insertar);
	}

	if($BlisterCPS != '' AND $BlisterCPS != 0)
	{
		$Elimina = "DELETE FROM raf_web.circulantes WHERE fecha='$fecha'";
		$Elimina.= " AND cod_producto = 16 AND cod_subproducto = 40";
		mysql_query($Elimina);

		$Insertar = "INSERT INTO raf_web.circulantes (fecha,cod_producto,cod_subproducto,unidades,peso)";
		$Insertar.= " VALUES('$fecha',16,40,1,$BlisterCPS)";
		mysql_query($Insertar);
	}

}
	header("Location:raf_ingreso_circulantes_blister.php");
?>