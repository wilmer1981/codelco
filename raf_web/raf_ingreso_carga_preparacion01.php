<?
include("../principal/conectar_raf_web.php");

if(strlen($Dia) == 1)
	$Dia = "0".$Dia;
if(strlen($Mes) == 1)
	$Mes = "0".$Mes;

//$fecha_carga = $Ano.'-'.$Mes.'-'.$Dia.' 00:00:00';
$fecha_carga = $Ano.'-'.$Mes.'-'.$Dia.' '.date("H:i:s");
$fecha_ini = $AnoIni.'-'.$MesIni.'-'.$DiaIni;
$fecha_ter = $AnoTer.'-'.$MesTer.'-'.$DiaTer;

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
/**************************************************/
if ($Proceso == "B")
{
	header ("location:raf_ingreso_carga_preparacion.php?Proceso=B&MesTer=$MesTer&AnoTer=$AnoTer&Dia=$Dia&Mes=$Mes&Ano=$Ano&Hornada=$Hornada");
	exit;
}

if($Proceso == "G")
{	
	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;
	
	if(strlen($Dia) == 1)
		$Dia = '0'.$Dia;

/*	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	$Eliminar = "DELETE FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$Fecha' AND right(hornada,4) = $Hornada";
	$Eliminar.= " AND turno = '$cmbturno'";
	mysql_query($Eliminar);
*/
	$Hornada = $Ano.$Mes.$Hornada;
	if(count($peso) != 0)
	{
		while (list($clave,$valor) = each($peso))
		{
			if($peso[$clave] != 0)		
			{
	
				//consulta flujo
				$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = ".$cod_producto[$clave];
				$consulta = $consulta." AND cod_subproducto = ".$cod_subproducto[$clave];
				$rs1 = mysql_query($consulta);
		
				if ($row1 = mysql_fetch_array($rs1))
				   $flujo = $row1["flujo"];
				else 
				   $flujo = 0;
	
				$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,grupo,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
				$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',$cod_producto[$clave],$cod_subproducto[$clave],$flujo,$Hornada,$Solera,'$grupo[$clave]',$unidades[$clave],$peso[$clave],$hornada_sea[$clave],'$fecha[$clave]','$fecha_ini','$fecha_ter','A')";
				mysql_query($Inserta);									
			}		
		}
	}	
		if($Peso_BlistCps != 0 AND $Peso_BlistCps != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',16,40,0,$Hornada,$Solera,$BlistCps,$Peso_BlistCps,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_BlistBasc != 0 AND $Peso_BlistBasc != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',16,41,0,$Hornada,$Solera,$BlistBasc,$Peso_BlistBasc,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_BlistReten != 0 AND $Peso_BlistReten != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',16,42,0,$Hornada,$Solera,$BlistReten,$Peso_BlistReten,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Tallarines != 0 AND $Peso_Tallarines != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,43,0,$Hornada,$Solera,$Tallarines,$Peso_Tallarines,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);
	 	}	

		if($Peso_Rebalses != 0 AND $Peso_Rebalses != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,69,0,$Hornada,$Solera,$Rebalses,$Peso_Rebalses,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Queques != 0 AND $Peso_Queques != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,39,0,$Hornada,$Solera,$Queques,$Peso_Queques,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Maceteros != 0 AND $Peso_Maceteros != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,31,0,$Hornada,$Solera,$Maceteros,$Peso_Maceteros,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_BoteOxid != 0 AND $Peso_BoteOxid != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,70,0,$Hornada,$Solera,$BoteOxid,$Peso_BoteOxid,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Chatarra != 0 AND $Peso_Chatarra != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,16,0,$Hornada,$Solera,$Chatarra,$Peso_Chatarra,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_CuRecup != 0 AND $Peso_CuRecup != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,75,0,$Hornada,$Solera,$CuRecup,$Peso_CuRecup,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_BoteAlb != 0 AND $Peso_BoteAlb != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,76,0,$Hornada,$Solera,$BoteAlb,$Peso_BoteAlb,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Moldes != 0 AND $Peso_Moldes != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,73,0,$Hornada,$Solera,$Moldes,$Peso_Moldes,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_AnodCirc != 0 AND $Peso_AnodCirc != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,74,0,$Hornada,$Solera,$AnodCirc,$Peso_AnodCirc,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Placas != 0 AND $Peso_Placas != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,77,0,$Hornada,$Solera,$Placas,$Peso_Placas,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_CuPiso != 0 AND $Peso_CuPiso != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,78,0,$Hornada,$Solera,$CuPiso,$Peso_CuPiso,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	
		//ref
		if($Peso_BarroAnod != 0 AND $Peso_BarroAnod != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',49,4,0,$Hornada,$Solera,$BarroAnod,$Peso_BarroAnod,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_BarridoCu != 0 AND $Peso_BarridoCu != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',48,10,0,$Hornada,$Solera,$BarridoCu,$Peso_BarridoCu,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_GranaCu != 0 AND $Peso_GranaCu != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',29,1,0,$Hornada,$Solera,$GranaCu,$Peso_GranaCu,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		//pmn
		if($Peso_EscFus != 0 AND $Peso_EscFus != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,21,0,$Hornada,$Solera,$EscFus,$Peso_EscFus,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_EscOxid != 0 AND $Peso_EscOxid != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',22,6,0,$Hornada,$Solera,$EscOxid,$Peso_EscOxid,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_LadrTrof != 0 AND $Peso_LadrTrof != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',39,6,0,$Hornada,$Solera,$LadrTrof,$Peso_LadrTrof,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	
}

if($Proceso == "M")
{	
	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;
	
	if(strlen($Dia) == 1)
		$Dia = '0'.$Dia;
	
	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	$Anomes= $Ano."".$Mes;
	$Eliminar = "DELETE FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$Fecha'";
	if(strlen($Hornada) == 4)
		$Eliminar.= " AND right(hornada,4) = $Hornada";
	else
		$Eliminar.= " AND right(hornada,5) = $Hornada";
	$Eliminar.= " and left(hornada,6) = '".$AnoMes."'";
	$Eliminar.= " AND turno = '$cmbturno'";
	mysql_query($Eliminar);

	$Hornada = $Ano.$Mes.$Hornada;
	if(count($peso) != 0)
	{
	
		while (list($clave,$valor) = each($peso))
		{
			if($peso[$clave] != 0)		
			{
	
				//consulta flujo
				$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = ".$cod_producto[$clave];
				$consulta = $consulta." AND cod_subproducto = ".$cod_subproducto[$clave];
				$rs1 = mysql_query($consulta);
		
				if ($row1 = mysql_fetch_array($rs1))
				   $flujo = $row1["flujo"];
				else 
				   $flujo = 0;
	
				$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,grupo,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
				$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',$cod_producto[$clave],$cod_subproducto[$clave],$flujo,$Hornada,$Solera,'$grupo[$clave]',$unidades[$clave],$peso[$clave],$hornada_sea[$clave],'$fecha[$clave]','$fecha_ini','$fecha_ter','A')";
				mysql_query($Inserta);									
			}		
		}
	}		

		if($Peso_BlistCps != 0 AND $Peso_BlistCps != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',16,40,0,$Hornada,$Solera,$BlistCps,$Peso_BlistCps,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_BlistBasc != 0 AND $Peso_BlistBasc != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',16,41,0,$Hornada,$Solera,$BlistBasc,$Peso_BlistBasc,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_BlistReten != 0 AND $Peso_BlistReten != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',16,42,0,$Hornada,$Solera,$BlistReten,$Peso_BlistReten,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Tallarines != 0 AND $Peso_Tallarines != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,43,0,$Hornada,$Solera,$Tallarines,$Peso_Tallarines,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);
	 	}	

		if($Peso_Rebalses != 0 AND $Peso_Rebalses != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,69,0,$Hornada,$Solera,$Rebalses,$Peso_Rebalses,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Queques != 0 AND $Peso_Queques != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,39,0,$Hornada,$Solera,$Queques,$Peso_Queques,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Maceteros != 0 AND $Peso_Maceteros != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,31,0,$Hornada,$Solera,$Maceteros,$Peso_Maceteros,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_BoteOxid != 0 AND $Peso_BoteOxid != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,70,0,$Hornada,$Solera,$BoteOxid,$Peso_BoteOxid,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Chatarra != 0 AND $Peso_Chatarra != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,16,0,$Hornada,$Solera,$Chatarra,$Peso_Chatarra,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_CuRecup != 0 AND $Peso_CuRecup != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,75,0,$Hornada,$Solera,$CuRecup,$Peso_CuRecup,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_BoteAlb != 0 AND $Peso_BoteAlb != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,76,0,$Hornada,$Solera,$BoteAlb,$Peso_BoteAlb,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Moldes != 0 AND $Peso_Moldes != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,73,0,$Hornada,$Solera,$Moldes,$Peso_Moldes,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_AnodCirc != 0 AND $Peso_AnodCirc != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,74,0,$Hornada,$Solera,$AnodCirc,$Peso_AnodCirc,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_Placas != 0 AND $Peso_Placas != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,77,0,$Hornada,$Solera,$Placas,$Peso_Placas,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_CuPiso != 0 AND $Peso_CuPiso != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,78,0,$Hornada,$Solera,$CuPiso,$Peso_CuPiso,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	
		//ref
		if($Peso_BarroAnod != 0 AND $Peso_BarroAnod != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',49,4,0,$Hornada,$Solera,$BarroAnod,$Peso_BarroAnod,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_BarridoCu != 0 AND $Peso_BarridoCu != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',48,10,0,$Hornada,$Solera,$BarridoCu,$Peso_BarridoCu,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_GranaCu != 0 AND $Peso_GranaCu != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',29,1,0,$Hornada,$Solera,$GranaCu,$Peso_GranaCu,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		//pmn
		if($Peso_EscFus != 0 AND $Peso_EscFus != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',42,21,0,$Hornada,$Solera,$EscFus,$Peso_EscFus,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_EscOxid != 0 AND $Peso_EscOxid != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',22,6,0,$Hornada,$Solera,$EscOxid,$Peso_EscOxid,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

		if($Peso_LadrTrof != 0 AND $Peso_LadrTrof != '')		
		{
			$Inserta = "INSERT INTO raf_web.movimientos (fecha_carga,turno,encargado,cod_producto,cod_subproducto,flujo,hornada,solera,unidades,peso,hornada_sea,fecha_sea,fecha_ini,fecha_ter,estado)";
			$Inserta.= " VALUES('$fecha_carga','$cmbturno','$encargado',39,6,0,$Hornada,$Solera,$LadrTrof,$Peso_LadrTrof,0,'$fecha_carga','$fecha_ini','$fecha_ter','A')";
			mysql_query($Inserta);									
	 	}	

}	

If($Proceso == "E")
{
	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;
	
	if(strlen($Dia) == 1)
		$Dia = '0'.$Dia;
	
	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	$Anomes=$Ano."".$Mes;
	$Eliminar = "DELETE FROM raf_web.movimientos WHERE left(fecha_carga,10) = '$Fecha'";
	if(strlen($Hornada) == 4)
		$Eliminar.= " AND right(hornada,4) = $Hornada";
	else
		$Eliminar.= " AND right(hornada,5) = $Hornada";
    $Eliminar.=" and left(hornada,6) = '".$Anomes."'";
	$Eliminar.= " AND turno = '$cmbturno'";
	mysql_query($Eliminar);


	$Eliminar2 = "DELETE FROM raf_web.det_carga";
	if(strlen($Hornada) == 4)
		$Eliminar2.= " WHERE right(hornada,4) = $Hornada";
	else
		$Eliminar2.= " WHERE right(hornada,5) = $Hornada";
	$Eliminar2.=" and left(hornada,6) = '".$Anomes."'";
	if($cmbturno != -1)
		$Eliminar2.= " AND turno = '$cmbturno'";
	mysql_query($Eliminar2);

}

	  //  $valores = "Proceso=B&DiaIni=".$DiaIni."&MesIni=".$MesIni."&AnoIni=".$AnoIni."&DiaTer=".$DiaTer."&MesTer=".$MesTer."&AnoTer=".$AnoTer;  

    //header("Location:raf_ingreso_carga_preparacion.php?".$valores);
	$Hornada = substr($Hornada,6,4); 
    header("Location:raf_ingreso_carga_preparacion.php?Hornada=".$Hornada); 


?>