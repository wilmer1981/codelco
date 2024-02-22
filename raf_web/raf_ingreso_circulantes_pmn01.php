<?
include("../principal/conectar_pac_web.php");
if($Proceso == "G")
{
	$fecha = $Ano.'-'.$Mes.'-'.$Dia;

	if($EscoriaOxid != '' AND $EscoriaOxid != 0)
	{
		$Elimina = "DELETE FROM raf_web.circulantes WHERE fecha='$fecha'";
		$Elimina.= " AND cod_producto = 42 AND cod_subproducto = 25";
		mysql_query($Elimina);

		$Insertar = "INSERT INTO raf_web.circulantes (fecha,cod_producto,cod_subproducto,unidades,peso)";
		$Insertar.= " VALUES('$fecha',42,25,1,$EscoriaOxid)";
		mysql_query($Insertar);
	}

	if($EscoriaFus != '' AND $EscoriaFus != 0)
	{
		$Elimina = "DELETE FROM raf_web.circulantes WHERE fecha='$fecha'";
		$Elimina.= " AND cod_producto = 42 AND cod_subproducto = 21";
		mysql_query($Elimina);

		$Insertar = "INSERT INTO raf_web.circulantes (fecha,cod_producto,cod_subproducto,unidades,peso)";
		$Insertar.= " VALUES('$fecha',42,21,1,$EscoriaFus)";
		mysql_query($Insertar);
	}
}
	header("Location:raf_ingreso_circulantes_pmn.php");
?>