<?
include("../principal/conectar_raf_web.php");

if(strlen($Dia) == 1)
	$Dia = "0".$Dia;
if(strlen($Mes) == 1)
	$Mes = "0".$Mes;

$fecha_carga = $Ano.'-'.$Mes.'-'.$Dia.' '.date("H:i:s");

/************** Valida Cierre De Mes ***************/
$fecha_val = $Ano.'-'.$Mes;
$consulta = "SELECT * FROM raf_web.cierre_mes";
$consulta = $consulta." WHERE left(fecha,7) = '$fecha_val' AND estado = 'C'";
$rs = mysql_query($consulta);
if ($row  = mysql_fetch_array($rs))
{
	$meses = array (1=>"Enero", 2=>"Febrero", 3=>"Marzo", 4=>"Abril", 5=>"Mayo", 6=>"Junio", 7=>"Julio", 8=>"Agosto", 9=>"Septiembre", 10=>"Octubre", 11=>"Noviembre", 12=>"Diciembre");
	$array_fecha = explode("-",$fecha_val);
			
	echo '<script language="JavaScript">';
	echo 'alert("El Mes de '.$meses[intval($array_fecha[1])].' Fue Cerrado,\n Ya No Se Puede Realizar Ningun Movimiento");';
	echo 'window.history.back()';
	echo '</script>';
	break;
}	

//Guarda Cargas
if($Proceso == "G")
{
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE right(hornada,4) = $Hornada";
	$resp = mysql_query($Consulta);
	$Row = mysql_fetch_array($resp);
	$hornada = $Row["hornada"];

	$Elimina = "DELETE FROM raf_web.det_carga WHERE hornada = $hornada";
	$Elimina.= " AND nro_carga = 1";
	mysql_query($Elimina);

	while (list($clave,$valor) = each($peso_1))
	{
		if($peso_1[$clave] != 0)
		{
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = ".$cod_producto[$clave];
			$consulta = $consulta." AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;

			$Insertar = "INSERT INTO raf_web.det_carga (fecha,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$encargado',1,$hornada,$hornada_sea[$clave],$flujo,$cod_producto[$clave],$cod_subproducto[$clave],'$grupo[$clave]',$unid_1[$clave],$peso_1[$clave])"; 		
			mysql_query($Insertar);
		}

	}

	$Elimina = "DELETE FROM raf_web.det_carga WHERE hornada = $hornada";
	$Elimina.= " AND nro_carga = 2";
	mysql_query($Elimina);

	while (list($clave,$valor) = each($peso_2))
	{
		if($peso_2[$clave] != 0)
		{
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = ".$cod_producto[$clave];
			$consulta = $consulta." AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;

			$Insertar = "INSERT INTO raf_web.det_carga (fecha,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$encargado',2,$hornada,$hornada_sea[$clave],$flujo,$cod_producto[$clave],$cod_subproducto[$clave],'$grupo[$clave]',$unid_2[$clave],$peso_2[$clave])"; 		
			mysql_query($Insertar);		
		}

	}

	$Elimina = "DELETE FROM raf_web.det_carga WHERE hornada = $hornada";
	$Elimina.= " AND nro_carga = 3";
	mysql_query($Elimina);

	while (list($clave,$valor) = each($peso_3))
	{
		if($peso_3[$clave] != 0)
		{
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = ".$cod_producto[$clave];
			$consulta = $consulta." AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;

			$Insertar = "INSERT INTO raf_web.det_carga (fecha,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$encargado',3,$hornada,$hornada_sea[$clave],$flujo,$cod_producto[$clave],$cod_subproducto[$clave],'$grupo[$clave]',$unid_3[$clave],$peso_3[$clave])"; 		
			mysql_query($Insertar);		
		}

	}

	$Elimina = "DELETE FROM raf_web.det_carga WHERE hornada = $hornada";
	$Elimina.= " AND nro_carga = 4";
	mysql_query($Elimina);

	while (list($clave,$valor) = each($peso_4))
	{
		if($peso_4[$clave] != 0)
		{
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = ".$cod_producto[$clave];
			$consulta = $consulta." AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;

			$Insertar = "INSERT INTO raf_web.det_carga (fecha,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$encargado',4,$hornada,$hornada_sea[$clave],$flujo,$cod_producto[$clave],$cod_subproducto[$clave],'$grupo[$clave]',$unid_4[$clave],$peso_4[$clave])"; 		
			mysql_query($Insertar);

		}

	}

}

//Modifica.
if($Proceso == "M")
{	
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE right(hornada,4) = $Hornada";
	$resp = mysql_query($Consulta);
	$Row = mysql_fetch_array($resp);
	$hornada = $Row["hornada"];

	$Elimina = "DELETE FROM raf_web.det_carga WHERE hornada = $hornada";
	$Elimina.= " AND nro_carga = 1";
	mysql_query($Elimina);

	while (list($clave,$valor) = each($peso_1))
	{
		if($peso_1[$clave] != 0)
		{
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = ".$cod_producto[$clave];
			$consulta = $consulta." AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;

			$Insertar = "INSERT INTO raf_web.det_carga (fecha,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$encargado',1,$hornada,$hornada_sea[$clave],$flujo,$cod_producto[$clave],$cod_subproducto[$clave],'$grupo[$clave]',$unid_1[$clave],$peso_1[$clave])"; 		
			mysql_query($Insertar);
		}

	}

	$Elimina = "DELETE FROM raf_web.det_carga WHERE hornada = $hornada";
	$Elimina.= " AND nro_carga = 2";
	mysql_query($Elimina);

	while (list($clave,$valor) = each($peso_2))
	{
		if($peso_2[$clave] != 0)
		{
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = ".$cod_producto[$clave];
			$consulta = $consulta." AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;

			$Insertar = "INSERT INTO raf_web.det_carga (fecha,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$encargado',2,$hornada,$hornada_sea[$clave],$flujo,$cod_producto[$clave],$cod_subproducto[$clave],'$grupo[$clave]',$unid_2[$clave],$peso_2[$clave])"; 		
			mysql_query($Insertar);		
		}

	}

	$Elimina = "DELETE FROM raf_web.det_carga WHERE hornada = $hornada";
	$Elimina.= " AND nro_carga = 3";
	mysql_query($Elimina);

	while (list($clave,$valor) = each($peso_3))
	{
		if($peso_3[$clave] != 0)
		{
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = ".$cod_producto[$clave];
			$consulta = $consulta." AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;

			$Insertar = "INSERT INTO raf_web.det_carga (fecha,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$encargado',3,$hornada,$hornada_sea[$clave],$flujo,$cod_producto[$clave],$cod_subproducto[$clave],'$grupo[$clave]',$unid_3[$clave],$peso_3[$clave])"; 		
			mysql_query($Insertar);		
		}

	}

	$Elimina = "DELETE FROM raf_web.det_carga WHERE hornada = $hornada";
	$Elimina.= " AND nro_carga = 4";
	mysql_query($Elimina);

	while (list($clave,$valor) = each($peso_4))
	{
		if($peso_4[$clave] != 0)
		{
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = ".$cod_producto[$clave];
			$consulta = $consulta." AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;

			$Insertar = "INSERT INTO raf_web.det_carga (fecha,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$encargado',4,$hornada,$hornada_sea[$clave],$flujo,$cod_producto[$clave],$cod_subproducto[$clave],'$grupo[$clave]',$unid_4[$clave],$peso_4[$clave])"; 		
			mysql_query($Insertar);

		}

	}


}

//Cierra Hornada(Traspasa Saldos)
/**************************************************/
if($Proceso == "C")
{
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE right(hornada,4) = $Hornada"; 
	$Consulta.= " ORDER BY cod_producto,cod_subproducto";
	$resp = mysql_query($Consulta);
	while($fila = mysql_fetch_array($resp))
	{

		$Consulta = "SELECT * FROM raf_web.det_carga"; 
		$Consulta.= " WHERE right(hornada,4) = $Hornada";
		$Consulta.= " AND cod_producto = $fila["cod_producto"]";
		$Consulta.= " AND cod_subproducto = $fila[cod_subproducto]";
		$Consulta.= " AND hornada_sea = $fila[hornada_sea]";
		$rs = mysql_query($Consulta);
		if($Fila = mysql_fetch_array($rs)) 
		{
			$Actualiza = "UPDATE raf_web.movimientos SET unidades = $Fila["unidades"], peso = $Fila["peso"]";
			$Actualiza.= " WHERE right(hornada,4) = $Hornada";
			$Actualiza.= " AND cod_producto = $Fila["cod_producto"]";
			$Actualiza.= " AND cod_subproducto = $Fila[cod_subproducto]";
			$Actualiza.= " AND hornada_sea = $Fila[hornada_sea]";
			mysql_query($Actualiza);	
		
		}
		else
		{
			$Elimina = "DELETE FROM raf_web.movimientos";
			$Elimina.= " WHERE right(hornada,4) = $Hornada";
			$Elimina.= " AND cod_producto = $fila["cod_producto"]";
			$Elimina.= " AND cod_subproducto = $fila[cod_subproducto]";
			$Elimina.= " AND hornada_sea = $fila[hornada_sea]";
			mysql_query($Elimina);	
					
		}
	}

	$Consulta = "SELECT estado FROM raf_web.movimientos WHERE right(hornada,4) = $Hornada"; 
	$rs = mysql_query($Consulta);
	$Fil = mysql_fetch_array($rs);
	
	if($Fil[estado] == "A")
	{
		$Actualiza = "UPDATE raf_web.movimientos SET estado = 'C'";
		$Actualiza.= " WHERE right(hornada,4) = $Hornada";
		mysql_query($Actualiza);
	}
	if($Fil[estado] == "C")
	{
		$Actualiza = "UPDATE raf_web.movimientos SET estado = 'A'";
		$Actualiza.= " WHERE right(hornada,4) = $Hornada";
		mysql_query($Actualiza);	
	}
}
    $Valores = "?Proceso=H&Hornada=".$Hornada;  
    header("Location:raf_ingreso_carga_parcial.php".$Valores); 


?>