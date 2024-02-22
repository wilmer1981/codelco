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
	$Hornada_new= $Ano."".$Mes."".$Hornada;
//	$Consulta = "SELECT * FROM raf_web.movimientos WHERE substring(hornada,7) = '".$Hornada."'";
//	$Consulta.=" and left(hornada,4) = '".$Ano."'";
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE hornada = '".$Hornada_new."'";
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
			$CodTurno = substr($cod_producto[$clave],0,1);
			$CodProducto = substr($cod_producto[$clave],1);
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
			$consulta.= " WHERE cod_proceso = 4 AND cod_producto = ".$CodProducto;
			$consulta.= " AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;
			$Insertar = "INSERT INTO raf_web.det_carga (fecha,turno,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$CodTurno','$encargado',1,$hornada,$hornada_sea[$clave],$flujo,$CodProducto,$cod_subproducto[$clave],'$grupo[$clave]',$unid_1[$clave],$peso_1[$clave])"; 					
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
			$CodTurno = substr($cod_producto[$clave],0,1);
			$CodProducto = substr($cod_producto[$clave],1);
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
			$consulta.= " WHERE cod_proceso = 4 AND cod_producto = ".$CodProducto;
			$consulta.= " AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;

			$Insertar = "INSERT INTO raf_web.det_carga (fecha,turno,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$CodTurno','$encargado',2,$hornada,$hornada_sea[$clave],$flujo,$CodProducto,$cod_subproducto[$clave],'$grupo[$clave]',$unid_2[$clave],$peso_2[$clave])"; 		
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
			$CodTurno = substr($cod_producto[$clave],0,1);
			$CodProducto = substr($cod_producto[$clave],1);
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
			$consulta.= " WHERE cod_proceso = 4 AND cod_producto = ".$CodProducto;
			$consulta.= " AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;

			$Insertar = "INSERT INTO raf_web.det_carga (fecha,turno,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$CodTurno','$encargado',3,$hornada,$hornada_sea[$clave],$flujo,$CodProducto,$cod_subproducto[$clave],'$grupo[$clave]',$unid_3[$clave],$peso_3[$clave])"; 		
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
			$CodTurno = substr($cod_producto[$clave],0,1);
			$CodProducto = substr($cod_producto[$clave],1);
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
			$consulta.= " WHERE cod_proceso = 4 AND cod_producto = ".$CodProducto;
			$consulta.= " AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;

			$Insertar = "INSERT INTO raf_web.det_carga (fecha,turno,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$CodTurno','$encargado',4,$hornada,$hornada_sea[$clave],$flujo,$CodProducto,$cod_subproducto[$clave],'$grupo[$clave]',$unid_4[$clave],$peso_4[$clave])"; 		
			mysql_query($Insertar);

		}

	}

}

//Modifica.
if($Proceso == "M")
{	
	$Hornada_new = $Ano."".$Mes."".$Hornada;
	//$Consulta = "SELECT * FROM raf_web.movimientos WHERE substring(hornada,7) = $Hornada";
	//$Consulta.=" and left(hornada,4) = '".$Ano."'";
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE hornada = '".$Hornada_new."'";
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
			$CodTurno = substr($cod_producto[$clave],0,1);
			$CodProducto = substr($cod_producto[$clave],1);
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
			$consulta.= " WHERE cod_proceso = 4 AND cod_producto = ".$CodProducto;
			$consulta.= " AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;
			$Insertar = "INSERT INTO raf_web.det_carga (fecha,turno,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$CodTurno','$encargado',1,$hornada,$hornada_sea[$clave],$flujo,$CodProducto,$cod_subproducto[$clave],'$grupo[$clave]',$unid_1[$clave],$peso_1[$clave])"; 		
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
			$CodTurno = substr($cod_producto[$clave],0,1);
			$CodProducto = substr($cod_producto[$clave],1);
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
			$consulta.= " WHERE cod_proceso = 4 AND cod_producto = ".$CodProducto;
			$consulta.= " AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;
			$Insertar = "INSERT INTO raf_web.det_carga (fecha,turno,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$CodTurno','$encargado',2,$hornada,$hornada_sea[$clave],$flujo,$CodProducto,$cod_subproducto[$clave],'$grupo[$clave]',$unid_2[$clave],$peso_2[$clave])"; 		
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
			$CodTurno = substr($cod_producto[$clave],0,1);
			$CodProducto = substr($cod_producto[$clave],1);
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
			$consulta.= " WHERE cod_proceso = 4 AND cod_producto = ".$CodProducto;
			$consulta.= " AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;
			$Insertar = "INSERT INTO raf_web.det_carga (fecha,turno,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$CodTurno','$encargado',3,$hornada,$hornada_sea[$clave],$flujo,$CodProducto,$cod_subproducto[$clave],'$grupo[$clave]',$unid_3[$clave],$peso_3[$clave])"; 		
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
			$CodTurno = substr($cod_producto[$clave],0,1);
			$CodProducto = substr($cod_producto[$clave],1);
			//consulta flujo
			$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
			$consulta.= " WHERE cod_proceso = 4 AND cod_producto = ".$CodProducto;
			$consulta.= " AND cod_subproducto = ".$cod_subproducto[$clave];
			$rs1 = mysql_query($consulta);
	
			if ($row1 = mysql_fetch_array($rs1))
			   $flujo = $row1["flujo"];
			else 
			   $flujo = 0;
			$Insertar = "INSERT INTO raf_web.det_carga (fecha,turno,encargado,nro_carga,hornada,hornada_sea,flujo,cod_producto,cod_subproducto,grupo,unidades,peso)";
			$Insertar.= " VALUES ('$fecha_carga','$CodTurno','$encargado',4,$hornada,$hornada_sea[$clave],$flujo,$CodProducto,$cod_subproducto[$clave],'$grupo[$clave]',$unid_4[$clave],$peso_4[$clave])"; 		
			mysql_query($Insertar);

		}

	}


}

//Cierra Hornada(Traspasa Saldos)
/**************************************************/
if($Proceso == "C")
{
	$Hornada_new = $Ano."".$Mes."".$Hornada;
	//$Consulta = "SELECT * FROM raf_web.movimientos WHERE substring(hornada,7) = ".$Hornada."";
	//$Consulta.=" and left(hornada,4) = '".$Ano."'";
	$Consulta = "SELECT * FROM raf_web.movimientos WHERE hornada = '".$Hornada_new."'";
	$Consulta.= " ORDER BY turno, cod_producto,cod_subproducto";
	$resp = mysql_query($Consulta);
	while($fila = mysql_fetch_array($resp))
	{
		$Consulta = "SELECT * FROM raf_web.det_carga";
		//$Consulta.= " WHERE substring(hornada,7) = ".$Hornada."";
		$Consulta.=" Where hornada = ".$Hornada_new."";
		$Consulta.= " AND cod_producto = ".$fila["cod_producto"]."";
		$Consulta.= " AND cod_subproducto = ".$fila[cod_subproducto]."";
		$Consulta.= " AND hornada_sea = ".$fila[hornada_sea]."";
		$Consulta.= " AND turno = '".$fila[turno]."' and left(hornada,4) = '".$Ano."'";
		$Consulta.= " ORDER BY turno ";
		$rs = mysql_query($Consulta);
		$AcumUnid = 0;
		$AcumPeso = 0;
		$Encontro = false;
		while ($Fila = mysql_fetch_array($rs))
		{
			$Encontro = true;
			$AcumUnid = $AcumUnid + $Fila["unidades"];
			$AcumPeso = $AcumPeso + $Fila["peso"];
		}
		if ($Encontro==true)
		{
			$Actualiza = "UPDATE raf_web.movimientos SET unidades = '".$AcumUnid."', peso = '".$AcumPeso."'";
			//$Actualiza.= " WHERE substring(hornada,7) = ".$Hornada."";
			$Actualiza.= " Where hornada = ".$Hornada_new."";
			$Actualiza.= " AND cod_producto = ".$fila["cod_producto"]."";
			$Actualiza.= " AND cod_subproducto = ".$fila[cod_subproducto]."";
			$Actualiza.= " AND hornada_sea = ".$fila[hornada_sea]."";
			$Actualiza.= " AND turno = '".$fila[turno]."' and left(hornada,4) = '".$Ano."'";
			mysql_query($Actualiza);
		}
		else
		{
			$Elimina = "DELETE FROM raf_web.movimientos";
			//$Elimina.= " WHERE substring(hornada,7) = ".$Hornada."";
			$Elimina.= " Where hornada = ".$Hornada_new."";
			$Elimina.= " AND cod_producto = ".$fila["cod_producto"]."";
			$Elimina.= " AND cod_subproducto = ".$fila[cod_subproducto]."";
			$Elimina.= " AND hornada_sea = ".$fila[hornada_sea]."";
			$Elimina.= " AND turno = '".$fila[turno]."' and left(hornada,4) = '".$Ano."'";
			mysql_query($Elimina);	
		}
	}
	$Hornada_new = $Ano."".$Mes."".$Hornada;
	//$Consulta = "SELECT cod_producto, cod_subproducto, hornada, estado FROM raf_web.movimientos WHERE substring(hornada,7) = ".$Hornada.""; 
	//$Consulta.=" and left(hornada,4) = '".$Ano."'";
	$Consulta = "SELECT cod_producto, cod_subproducto, hornada, estado FROM raf_web.movimientos WHERE hornada = '".$Hornada_new."'";
	$rs = mysql_query($Consulta);
	$Fil = mysql_fetch_array($rs);
	$ProductoAux = $Fil["cod_producto"];
	$SubProductoAux = $Fil[cod_subproducto];
	$HornadaAux = $Fil["hornada"];
	if($Fil["estado"] == "A")
	{
		$Actualiza = "UPDATE raf_web.movimientos SET estado = 'C'";
		//$Actualiza.= " WHERE substring(hornada,7) = '".$Hornada."' and left(hornada,4) = '".$Ano."'";
		$Actualiza.= " WHERE hornada = '".$Hornada_new."'";
		mysql_query($Actualiza);
		$Insertar = "insert into raf_web.estados_hornada (cod_producto, cod_subproducto, hornada, fecha_hora, cod_estado, rut_funcionario) ";
		$Insertar.=" values('".$ProductoAux ."','".$SubProductoAux."','".$HornadaAux."','".date("Y-m-d H:i:s")."','C','".$CookieRut."')";
		mysql_query($Insertar);
	}
	if($Fil[estado] == "C")
	{
		$Actualiza = "UPDATE raf_web.movimientos SET estado = 'A'";
		//$Actualiza.= " WHERE substring(hornada,7) = '".$Hornada."' and left(hornada,4) = '".$Ano."'";
		$Actualiza.= " WHERE hornada = '".$Hornada_new."'";
		mysql_query($Actualiza);	
		$Insertar = "insert into raf_web.estados_hornada (cod_producto, cod_subproducto, hornada, fecha_hora, cod_estado, rut_funcionario) ";
		$Insertar.=" values('".$ProductoAux ."','".$SubProductoAux."','".$HornadaAux."','".date("Y-m-d H:i:s")."','A','".$CookieRut."')";
		mysql_query($Insertar);
	}
}
    $Valores = "?Proceso=H&Hornada=".$Hornada;  
    header("Location:raf_ingreso_carga_parcial.php".$Valores); 


?>