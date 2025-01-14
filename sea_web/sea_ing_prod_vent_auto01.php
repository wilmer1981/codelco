<?php
	//include("../principal/conectar_sea_web.php"); 	
	include("../principal/conectar_principal.php");
	//$IpPc = $REMOTE_ADDR;	
	$IpPc = $IP_USER;	

	$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase ";
	$Consulta.= " WHERE cod_clase = '2014' and nombre_subclase = '".$IpPc."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$IpPc = $Fila["valor_subclase1"];
	}

	if(isset($_REQUEST["Proceso"])) {
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = '';
	}
	if(isset($_REQUEST["Reiniciar"])) {
		$Reiniciar = $_REQUEST["Reiniciar"];
	}else{
		$Reiniciar = '';
	}

	if(isset($_REQUEST["TipoPesaje"])) {
		$TipoPesaje = $_REQUEST["TipoPesaje"];
	}else{
		$TipoPesaje = "";
	}
	if(isset($_REQUEST["TipoTara"])) {
		$TipoTara = $_REQUEST["TipoTara"];
	}else{
		$TipoTara = "";
	}
	if(isset($_REQUEST["Numero"])) {
		$Numero = $_REQUEST["Numero"];
	}else{
		$Numero = "";
	}

	if(isset($_REQUEST["ano"])) {
		$ano = $_REQUEST["ano"];
	}else{
		$ano = "";
	}
	if(isset($_REQUEST["mes"])) {
		$mes = $_REQUEST["mes"];
	}else{
		$mes = "";
	}
	if(isset($_REQUEST["dia"])) {
		$dia = $_REQUEST["dia"];
	}else{
		$dia = "";
	}
	/*
	if(isset($_REQUEST["FechaElim"])) {
		$FechaElim = $_REQUEST["FechaElim"];
	}else{
		$FechaElim = "";
	}*/
	if(isset($_REQUEST["HornadaElim"])) {
		$HornadaElim = $_REQUEST["HornadaElim"];
	}else{
		$HornadaElim = "";
	}


/************************** Guardar ******************************** */

if(isset($_REQUEST["FechaPesajeAnt"])) {
	$FechaPesajeAnt = $_REQUEST["FechaPesajeAnt"];
}else{
	$FechaPesajeAnt = "";
}
if(isset($_REQUEST["PesoAnt"])) {
	$PesoAnt = $_REQUEST["PesoAnt"];
}else{
	$PesoAnt = "";
}

if(isset($_REQUEST["ChkTipoAnodo"])) {
	$ChkTipoAnodo = $_REQUEST["ChkTipoAnodo"];
}else{
	$ChkTipoAnodo = "";
}
if(isset($_REQUEST["PesoBruto"])) {
	$PesoBruto = $_REQUEST["PesoBruto"];
}else{
	$PesoBruto = "";
}
if(isset($_REQUEST["TotalTara"])) {
	$TotalTara = $_REQUEST["TotalTara"];
}else{
	$TotalTara = "";
}
if(isset($_REQUEST["UnidCorrientes"])) {
	$UnidCorrientes = $_REQUEST["UnidCorrientes"];
}else{
	$UnidCorrientes = "";
}
if(isset($_REQUEST["UnidEspeciales"])) {
	$UnidEspeciales = $_REQUEST["UnidEspeciales"];
}else{
	$UnidEspeciales = "";
}
if(isset($_REQUEST["UnidHM"])) {
	$UnidHM = $_REQUEST["UnidHM"];
}else{
	$UnidHM = "";
}
if(isset($_REQUEST["Hora"])) {
	$Hora = $_REQUEST["Hora"];
}else{
	$Hora = "";
}
if(isset($_REQUEST["num_hornada"])) {
	$num_hornada = $_REQUEST["num_hornada"];
}else{
	$num_hornada = "";
}
if(isset($_REQUEST["Hornos"])) {
	$Hornos = $_REQUEST["Hornos"];
}else{
	$Hornos = "";
}
if(isset($_REQUEST["NumRueda"])) {
	$NumRueda = $_REQUEST["NumRueda"];
}else{
	$NumRueda = 0;
}
if(isset($_REQUEST["NumCarro"])) {
	$NumCarro = $_REQUEST["NumCarro"];
}else{
	$NumCarro = 0;
}
if(isset($_REQUEST["NumRack"])) {
	$NumRack = $_REQUEST["NumRack"];
}else{
	$NumRack = 0;
}
if(isset($_REQUEST["NumCubas"])) {
	$NumCubas = $_REQUEST["NumCubas"];
}else{
	$NumCubas = 0;
}

if(isset($_REQUEST["PesoRack"])) {
	$PesoRack = $_REQUEST["PesoRack"];
}else{
	$PesoRack = "";
}
if(isset($_REQUEST["NuevoRack"])) {
	$NuevoRack = $_REQUEST["NuevoRack"];
}else{
	$NuevoRack= "";
}
if(isset($_REQUEST["NuevoCarro"])) {
	$NuevoCarro = $_REQUEST["NuevoCarro"];
}else{
	$NuevoCarro = "";
}
if(isset($_REQUEST["PesoCarro"])) {
	$PesoCarro = $_REQUEST["PesoCarro"];
}else{
	$PesoCarro = "";
}
if(isset($_REQUEST["Grupo"])) {
	$Grupo = $_REQUEST["Grupo"];
}else{
	$Grupo = "";
}
if(isset($_REQUEST["Lado"])) {
	$Lado = $_REQUEST["Lado"];
}else{
	$Lado = "";
}
if(isset($_REQUEST["ChkFin"])) {
	$ChkFin = $_REQUEST["ChkFin"];
}else{
	$ChkFin = "";
}
if(isset($_REQUEST["checkpeso"])) {
	$checkpeso = $_REQUEST["checkpeso"];
}else{
	$checkpeso = "";
}

/*************** GRABAR PESOS PROMEDIO ****************************** */
if(isset($_REQUEST["PesoCtte"])) {
	$PesoCtte = $_REQUEST["PesoCtte"];
}else{
	$PesoCtte = "";
}
if(isset($_REQUEST["PesoHM"])) {
	$PesoHM = $_REQUEST["PesoHM"];
}else{
	$PesoHM = "";
}

/********************************** ELIMINAR ************************************* */

//Proceso=E_RestosAnodos&FechaElim=" + FechaElim + "&GrupoElim=" + GrupoElim + "&LadoElim=" + LadoElim + "&FechaCargaElim=" + FechaCargaElim;

if(isset($_REQUEST["FechaElim"])) {
	$FechaElim = $_REQUEST["FechaElim"];
}else{
	$FechaElim = "";
}
if(isset($_REQUEST["GrupoElim"])) {
	$GrupoElim = $_REQUEST["GrupoElim"];
}else{
	$GrupoElim = "";
}
if(isset($_REQUEST["LadoElim"])) {
	$LadoElim = $_REQUEST["LadoElim"];
}else{
	$LadoElim = "";
}
if(isset($_REQUEST["FechaCargaElim"])) {
	$FechaCargaElim = $_REQUEST["FechaCargaElim"];
}else{
	$FechaCargaElim = "";
}

if(isset($_REQUEST["Ano"])) {
	$Ano = $_REQUEST["Ano"];
}else{
	$Ano = "";
}
if(isset($_REQUEST["Mes"])) {
	$Mes = $_REQUEST["Mes"];
}else{
	$Mes = "";
}
if(isset($_REQUEST["Dia"])) {
	$Dia = $_REQUEST["Dia"];
}else{
	$Dia = "";
}

if(isset($_REQUEST["Periodo"])) {
	$Periodo = $_REQUEST["Periodo"];
}else{
	$Periodo = "";
}
/****************** CUBAS ****************************** */
if(isset($_REQUEST["GrupoProd"])) {
	$GrupoProd = $_REQUEST["GrupoProd"];
}else{
	$GrupoProd = "";
}
if(isset($_REQUEST["Cuba"])) {
	$Cuba = $_REQUEST["Cuba"];
}else{
	$Cuba = "";
}
if(isset($_REQUEST["FechaProduccion"])) {
	$FechaProduccion = $_REQUEST["FechaProduccion"];
}else{
	$FechaProduccion = "";
}

if(isset($_REQUEST["GrupoElim"])) {
	$GrupoElim = $_REQUEST["GrupoElim"];
}else{
	$GrupoElim = "";
}
if(isset($_REQUEST["CubaElim"])) {
	$CubaElim = $_REQUEST["CubaElim"];
}else{
	$CubaElim = "";
}
if(isset($_REQUEST["CubaElim"])) {
	$CubaElim = $_REQUEST["CubaElim"];
}else{
	$CubaElim = "";
}
if(isset($_REQUEST["FechaCarga"])) {
	$FechaCarga = $_REQUEST["FechaCarga"];
}else{
	$FechaCarga = "";
}
if(isset($_REQUEST["FechaHoraElim"])) {
	$FechaHoraElim = $_REQUEST["FechaHoraElim"];
}else{
	$FechaHoraElim = "";
}
if(isset($_REQUEST["FechaG"])) {
	$FechaG = $_REQUEST["FechaG"];
}else{
	$FechaG = "";
}

	//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	$valida_fecha_movimiento = $ano."-".$mes."-".$dia;
	include("sea_valida_mes.php");
	//*******************************************************************************//
	$fecha = $ano."-".$mes."-".$dia;
	$mes = str_pad($mes,2,"0",STR_PAD_LEFT);	
	
switch ($Proceso)
{
	case "RN":
		header("location:sea_ing_prod_vent_auto.php?PesoAuto=checked&TipoPesaje=".$TipoPesaje);
		break;
	//****************************************************************************************//
	//****************PRODUCCION ANODOS CORRIENTES Y HOJAS MADRE******************************//
	//****************************************************************************************//	
	case "G_ProdAnodos":
		if ($ChkTipoAnodo == "HM")			
			$Prom = "S";	
		else
			$Prom = "N";
		$PesoNeto = (int)$PesoBruto - (int)$TotalTara;		
		if (trim($UnidCorrientes) == "")
			$UnidCorrientes = "0";
		if (trim($UnidEspeciales) == "")
			$UnidEspeciales = "0";
		if (trim($UnidHM) == "")
			$UnidHM = "0";
		//ANODOS CORRIENTES		
		if ($UnidCorrientes != "")
		{			
			$Consulta = "select * from sea_web.detalle_pesaje ";
			//$Consulta.= " where fecha = '".$fecha." ".$Hora."'";
			$Consulta.= " where fecha = '".$FechaG."'";
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " and hornada = '".$num_hornada."'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '4'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				//ACTUALIZA DATOS				
				$Actualizar = "UPDATE sea_web.`detalle_pesaje` SET ";
				$Actualizar.= " rueda = '".$NumRueda."'";
				$Actualizar.= " , num_carro = '".$NumCarro."'";
				$Actualizar.= " , num_rack = '".$NumRack."'";
				$Actualizar.= " , unidades = '".$UnidCorrientes."'";
				$Actualizar.= " , peso = '0'";
				$Actualizar.= " , peso_total = '".$PesoNeto."'";
				$Actualizar.= " , promedio = '".$Prom."' ";
				$Actualizar.= " , bascula = '".$IpPc."' ";
				$Actualizar.= " where fecha = '".$fecha." ".$Hora."'";
				$Actualizar.= " and tipo_pesaje = 'PA'";
				$Actualizar.= " and hornada = '".$num_hornada."'";
				$Actualizar.= " and cod_producto = '17'";
				$Actualizar.= " and cod_subproducto = '4'";								
				mysqli_query($link, $Actualizar);
			}
			else
			{			
				//INSERTA DATOS
				$Consulta ="Select * from sea_web.detalle_pesaje where cod_producto = '17' and cod_subproducto  = '4' and fecha  = '".$fecha." ".$Hora."' ";
				$resp = mysqli_query($link, $Consulta);
				$cont = mysqli_num_rows($resp);
				if($cont==0){
					$Insertar = "INSERT INTO sea_web.`detalle_pesaje` (`fecha`, `cod_producto`,`cod_subproducto`,`tipo_pesaje`, `horno`, `rueda`, `hornada`, ";
					$Insertar.= " `num_carro`, `num_rack`, `unidades`, `peso`, `peso_total`, `estado`, `promedio`, `bascula`) ";
					$Insertar.= " VALUES ('".$fecha." ".$Hora."', '17', '4', 'PA', '".$Hornos."', '".$NumRueda."', '".$num_hornada."', ";
					$Insertar.= " '".$NumCarro."', '".$NumRack."', '".$UnidCorrientes."', '0', '".$PesoNeto."', 'P', '".$Prom."', '".$IpPc."')";
					mysqli_query($link, $Insertar);	
				}
			}
		}
		//ANODOS ESPECIALES
		if ($UnidEspeciales != "")
		{
			$Consulta = "select * from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$fecha." ".$Hora."'";
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " and hornada = '".$num_hornada."'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '11'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				//ACTUALIZA DATOS
				$Actualizar = "UPDATE sea_web.`detalle_pesaje` SET ";
				$Actualizar.= " rueda = '".$NumRueda."'";
				$Actualizar.= " , num_carro = '".$NumCarro."'";
				$Actualizar.= " , num_rack = '".$NumRack."'";
				$Actualizar.= " , unidades = '".$UnidEspeciales."'";
				$Actualizar.= " , peso = '0'";
				$Actualizar.= " , peso_total = '".$PesoNeto."'";
				$Actualizar.= " , promedio = '".$Prom."' ";
				$Actualizar.= " , bascula = '".$IpPc."' ";
				$Actualizar.= " where fecha = '".$fecha." ".$Hora."'";
				$Actualizar.= " and tipo_pesaje = 'PA'";
				$Actualizar.= " and hornada = '".$num_hornada."'";
				$Actualizar.= " and cod_producto = '17'";
				$Actualizar.= " and cod_subproducto = '11'";								
				mysqli_query($link, $Actualizar);
			}
			else
			{			
				//INSERTA DATOS
				$Consulta ="Select * from sea_web.detalle_pesaje where cod_producto = '17' and cod_subproducto  = '11' and fecha  = '".$fecha." ".$Hora."' ";
				$resp = mysqli_query($link, $Consulta);
				$cont = mysqli_num_rows($resp);
				if($cont==0){
					$Insertar = "INSERT INTO sea_web.`detalle_pesaje` (`fecha`, `cod_producto`,`cod_subproducto`,`tipo_pesaje`, `horno`, `rueda`, `hornada`, ";
					$Insertar.= " `num_carro`, `num_rack`, `unidades`, `peso`, `peso_total`, `estado`, `promedio`, `bascula`) ";
					$Insertar.= " VALUES ('".$fecha." ".$Hora."', '17', '11', 'PA', '".$Hornos."', '".$NumRueda."', '".$num_hornada."', ";
					$Insertar.= " '".$NumCarro."', '".$NumRack."', '".$UnidEspeciales."', '0', '".$PesoNeto."', 'P', '".$Prom."', '".$IpPc."')";
					mysqli_query($link, $Insertar);
				}
			}
		}
		//ANODOS HOJAS MADRE
		if ($UnidHM != "")
		{
			$Consulta = "select * from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$fecha." ".$Hora."'";
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " and hornada = '".$num_hornada."'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '8'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				//ACTUALIZA DATOS
				$Actualizar = "UPDATE sea_web.`detalle_pesaje` SET ";
				$Actualizar.= " rueda = '".$NumRueda."'";
				$Actualizar.= " , num_carro = '".$NumCarro."'";
				$Actualizar.= " , num_rack = '".$NumRack."'";
				$Actualizar.= " , unidades = '".$UnidHM."'";
				$Actualizar.= " , peso = '0'";
				$Actualizar.= " , peso_total = '".$PesoNeto."'";
				$Actualizar.= " , promedio = '".$Prom."' ";
				$Actualizar.= " , bascula = '".$IpPc."' ";
				$Actualizar.= " where fecha = '".$fecha." ".$Hora."'";
				$Actualizar.= " and tipo_pesaje = 'PA'";
				$Actualizar.= " and hornada = '".$num_hornada."'";
				$Actualizar.= " and cod_producto = '17'";
				$Actualizar.= " and cod_subproducto = '8'";								
				mysqli_query($link, $Actualizar);
			}
			else
			{			
				//INSERTA DATOS
				$Consulta ="Select * from sea_web.detalle_pesaje where cod_producto = '17' and cod_subproducto  = '8' and fecha  = '".$fecha." ".$Hora."' ";
			    $resp = mysqli_query($link, $Consulta);
				$cont = mysqli_num_rows($resp);
				if($cont==0){
					$Insertar = "INSERT INTO sea_web.`detalle_pesaje` (`fecha`, `cod_producto`,`cod_subproducto`,`tipo_pesaje`, `horno`, `rueda`, `hornada`, ";
					$Insertar.= " `num_carro`, `num_rack`, `unidades`, `peso`, `peso_total`, `estado`, `promedio`, `bascula`) ";
					$Insertar.= " VALUES ('".$fecha." ".$Hora."', '17', '8', 'PA', '".$Hornos."', '".$NumRueda."', '".$num_hornada."', ";
					$Insertar.= " '".$NumCarro."', '".$NumRack."', '".$UnidHM."', '0', '".$PesoNeto."', 'P', '".$Prom."', '".$IpPc."')";
					mysqli_query($link, $Insertar);
				}
			}
		}
		//ELIMINA REGISTROS CON UNIDADES EN 0 CERO DE LA HORNADA
		$Eliminar = "delete from sea_web.detalle_pesaje ";
		$Eliminar.= " where hornada = '".$num_hornada."'";		
		$Eliminar.= " and horno = '".$Hornos."'";
		$Eliminar.= " and tipo_pesaje = 'PA'";
		$Eliminar.= " and unidades = 0";
		mysqli_query($link, $Eliminar);
		//ELIMINA REGISTRO TEMPORAL DE CREACION DE LA HORNADA
		$Eliminar = "delete from sea_web.detalle_pesaje ";
		$Eliminar.= " where hornada = '".$num_hornada."'";		
		$Eliminar.= " and horno = '".$Hornos."'";
		$Eliminar.= " and tipo_pesaje = 'PA'";
		$Eliminar.= " and estado = 'C'";
		mysqli_query($link, $Eliminar);
		//OTRAS OPCIONES
		if ($NuevoCarro == "S") //INSERTA NUEVO CARRO
		{
			$Insertar = "insert into sea_web.taras(tipo_tara, numero, peso, fecha_pesaje) VALUES";
			$Insertar.= " ('C','".intval($NumCarro)."','".str_replace(",",".",$PesoCarro)."','".$fecha."')";
			mysqli_query($link, $Insertar);
		}
		if ($NuevoRack == "S") //INSERTA NUEVO RACK
		{
			$Insertar = "insert into sea_web.taras(tipo_tara, numero, peso, fecha_pesaje) VALUES";
			$Insertar.= " ('R','".intval($NumRack)."','".str_replace(",",".",$PesoRack)."','".$fecha."')";
			mysqli_query($link, $Insertar);
		}		
		//CALCULAR PROMEDIOS
		$Consulta = "SELECT sum(peso_total) as peso_total, sum(unidades) as unidades,";
		$Consulta.= " (sum(peso_total)/sum(unidades)) as promedio ";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where hornada = '".$num_hornada."'";		
		$Consulta.= " and horno = '".$Hornos."'";
		$Consulta.= " and tipo_pesaje = 'PA'";
		//$Consulta.= " and promedio = 'S'"; //H.M.
		//echo "SQL:".$Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		$Fila = mysqli_fetch_array($Respuesta);
		//echo "<br>Consulta:";
		//var_dump($Fila);
		//exit();
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			//ACTUALIZA LAS UNIDADES DEL PRODUCTO QUE SACA EL PROMEDIO (H.M.)
			$Actualizar = "UPDATE sea_web.detalle_pesaje set ";
			$Actualizar.= " peso = (unidades * ".str_replace(",",".",$Fila["promedio"]).")";
			$Actualizar.= " where hornada = '".$num_hornada."'";		
			$Actualizar.= " and horno = '".$Hornos."'";
			$Actualizar.= " and tipo_pesaje = 'PA'";
			$Actualizar.= " and cod_producto = '17'";
			$Actualizar.= " and cod_subproducto = '8'";
			$Actualizar.= " and promedio <> 'S'";
			mysqli_query($link, $Actualizar);
			//CONSULTO EL PESO DE LAS H.M.
			$Consulta = "SELECT sum(peso) as peso ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where hornada = '".$num_hornada."'";		
			$Consulta.= " and horno = '".$Hornos."'";
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '8'";
			$Consulta.= " and promedio <> 'S'";
			$Resp2 = mysqli_query($link, $Consulta);			
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				//CONSULTO EL PESO TOTAL DE LAS PESADAS
				$Consulta = "select DISTINCT fecha, peso_total ";
				$Consulta.= " from sea_web.detalle_pesaje ";
				$Consulta.= " where hornada = '".$num_hornada."'";		
				$Consulta.= " and horno = '".$Hornos."'";
				$Consulta.= " and tipo_pesaje = 'PA'";	
				$Consulta.= " and promedio <> 'S'";
				$Resp3 = mysqli_query($link, $Consulta);
				while ($Fila3 = mysqli_fetch_array($Resp3))
				{
					$PesoTotal = $PesoTotal + $Fila3["peso_total"];
				}				
				$PesoHM = $Fila2["peso"];
				$PesoRestante = $PesoTotal - $PesoHM;				
				//TOTAL DE UNIDADES DE LOS OTROS PRODUCTOS
				$Consulta = "select sum(unidades) as unidades ";
				$Consulta.= " from sea_web.detalle_pesaje ";
				$Consulta.= " where hornada = '".$num_hornada."'";
				$Consulta.= " and horno = '".$Hornos."'";
				$Consulta.= " and tipo_pesaje = 'PA'";
				$Consulta.= " and cod_producto = '17' and cod_subproducto <> '8'";
				$Consulta.= " and promedio <> 'S'";
				$Resp3 = mysqli_query($link, $Consulta);
				if ($Fila3 = mysqli_fetch_array($Resp3))
				{
					if ($PesoRestante > 0 && $Fila3["unidades"] > 0)
						$PromedioCtte = $PesoRestante/$Fila3["unidades"];
					else
						$PromedioCtte = 0;
				}
				//echo "PESO TOTAL=".$PesoTotal." PROMEDIO H.M.=".$Fila["promedio"]." PESO H.M.=".$PesoHM." PESO RESTANTE=".$PesoRestante." PROM. RESTANTE=".$PromedioCtte."<br>";
				//TOTAL DE UNIDADES POR CADA UNO DE LOS OTROS PRODUCTOS
				$Consulta = "select cod_producto, cod_subproducto, sum(unidades) as unidades ";
				$Consulta.= " from sea_web.detalle_pesaje ";
				$Consulta.= " where hornada = '".$num_hornada."'";
				$Consulta.= " and horno = '".$Hornos."'";
				$Consulta.= " and tipo_pesaje = 'PA'";
				$Consulta.= " and cod_producto = '17' and cod_subproducto <> '8'";
				$Consulta.= " and promedio <> 'S'";
				$Consulta.= " group by cod_producto, cod_subproducto ";
				$Resp3 = mysqli_query($link, $Consulta);
				while ($Fila3 = mysqli_fetch_array($Resp3))
				{
					//ACTUALIZA LAS UNIDADES DEL RESTO DE LOS PRODUCTO
					$Actualizar = "update sea_web.detalle_pesaje set ";
					$Actualizar.= " peso = (unidades * ".str_replace(",",".",$PromedioCtte).")";
					$Actualizar.= " where hornada = '".$num_hornada."'";		
					$Actualizar.= " and horno = '".$Hornos."'";
					$Actualizar.= " and tipo_pesaje = 'PA'";
					$Actualizar.= " and cod_producto = '".$Fila3["cod_producto"]."'";
					$Actualizar.= " and cod_subproducto = '".$Fila3["cod_subproducto"]."'";
					$Actualizar.= " and promedio <> 'S'";
					mysqli_query($link, $Actualizar);
				}
				//CONSULTO EL PESO TOTAL DE LAS UNIDADES Y LO COMPARO CON EL PESO TOTAL
				$Consulta = "select sum(peso) as peso ";
				$Consulta.= " from sea_web.detalle_pesaje ";
				$Consulta.= " where hornada = '".$num_hornada."'";		
				$Consulta.= " and horno = '".$Hornos."'";
				$Consulta.= " and tipo_pesaje = 'PA'";	
				$Consulta.= " and promedio <> 'S'";
				$Resp3 = mysqli_query($link, $Consulta);
				if ($Fila3 = mysqli_fetch_array($Resp3))
				{					
					if ($Fila3["peso"] > $PesoTotal)
					{
						//LE QUITO LA DIF. DE MAS A LAS H.M.
						$Diferencia = $Fila3["peso"] - $PesoTotal;
						//CONSULTO LA PESADA DE LA HORNADA DE H.M. CON MAS PESO
						$Consulta = "select * ";
						$Consulta.= " from sea_web.detalle_pesaje ";
						$Consulta.= " where hornada = '".$num_hornada."'";
						$Consulta.= " and horno = '".$Hornos."'";
						$Consulta.= " and tipo_pesaje = 'PA'";
						$Consulta.= " and cod_producto = '17'";
						$Consulta.= " and cod_subproducto = '8'";
						$Consulta.= " and promedio <> 'S'";
						$Consulta.= " order by peso desc";
						$Resp4 = mysqli_query($link, $Consulta);
						if ($Fila4 = mysqli_fetch_array($Resp4))
						{
							//ACTUALIZA LA PESADA DE LA HORNADA CON MAS PESO
							$Actualizar = "update sea_web.detalle_pesaje set ";
							$Actualizar.= " peso = (peso - ".str_replace(",",".",$Diferencia).")";
							$Actualizar.= " where hornada = '".$num_hornada."'";		
							$Actualizar.= " and horno = '".$Hornos."'";
							$Actualizar.= " and tipo_pesaje = 'PA'";
							$Actualizar.= " and fecha = '".$Fila4["fecha"]."'";
							$Actualizar.= " and cod_producto = '17'";
							$Actualizar.= " and cod_subproducto = '8'";
							$Actualizar.= " and num_carro = '".$Fila4["num_carro"]."'";
							$Actualizar.= " and num_rack = '".$Fila4["num_rack"]."'";
							$Actualizar.= " and promedio <> 'S'";
							mysqli_query($link, $Actualizar);
						}						
					}
					else
					{
						if ($Fila3["peso"] < $PesoTotal)
						{
							//LE DOY LA DIF. DE MAS A LAS H.M.
							$Diferencia =  $PesoTotal - $Fila3["peso"];
							//CONSULTO LA PESADA DE LA HORNADA DE H.M. CON MAS PESO
							$Consulta = "select * ";
							$Consulta.= " from sea_web.detalle_pesaje ";
							$Consulta.= " where hornada = '".$num_hornada."'";
							$Consulta.= " and horno = '".$Hornos."'";
							$Consulta.= " and tipo_pesaje = 'PA'";	
							$Consulta.= " and cod_producto = '17'";
							$Consulta.= " and cod_subproducto = '8'";
							$Consulta.= " and promedio <> 'S'";
							$Consulta.= " order by peso desc";
							$Resp4 = mysqli_query($link, $Consulta);
							if ($Fila4 = mysqli_fetch_array($Resp4))
							{
								//ACTUALIZA LA PESADA DE LA HORNADA CON MAS PESO
								$Actualizar = "update sea_web.detalle_pesaje set ";
								$Actualizar.= " peso = (peso + ".str_replace(",",".",$Diferencia).")";
								$Actualizar.= " where hornada = '".$num_hornada."'";		
								$Actualizar.= " and horno = '".$Hornos."'";
								$Actualizar.= " and tipo_pesaje = 'PA'";
								$Actualizar.= " and fecha = '".$Fila4["fecha"]."'";
								$Actualizar.= " and cod_producto = '17'";
								$Actualizar.= " and cod_subproducto = '8'";
								$Actualizar.= " and num_carro = '".$Fila4["num_carro"]."'";
								$Actualizar.= " and num_rack = '".$Fila4["num_rack"]."'";
								$Actualizar.= " and promedio <> 'S'";
								mysqli_query($link, $Actualizar);
							}						
						}
					}
				}
			}
		}
		if ($ChkFin == "S")	
		{
			//ACTUALIZA CAMPO DE FINALIZADA
			$Actualizar = "UPDATE sea_web.detalle_pesaje SET "; 
			$Actualizar.= " estado = 'F'";
			$Actualizar.= " where hornada = '".$num_hornada."'";
			$Actualizar.= " and tipo_pesaje = 'PA'";	
			$Actualizar.= " and horno = '".$Hornos."'";	
			mysqli_query($link, $Actualizar);
			//FINALIZAR HORNADA Graba datos a tablas principales
			// ASIGNA FLUJOS SEGUN HORNO	 
			if($Hornos == 1 || $Hornos == 2)
			{
				$FlujoCtte = 92;
				$FlujoEsp = 95;
				$FlujoHM = 129;
			}		
			if($Hornos == 4)
			{
				$FlujoCtte = 93;
				$FlujoEsp = 99;
				$FlujoHM = 131;
			}		 
			//LOS COMENTARIOS SON PARA TODOS IGUALES
			/************* Hojas Madres *********/	
			$Consulta = "select sum(peso) as peso, sum(unidades) as unidades ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where hornada = '".$num_hornada."'";
			$Consulta.= " and horno = '".$Hornos."'";
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '8'";
			$Consulta.= " and promedio <> 'S'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{ 
				if($Fila["unidades"] != 0)
				{	
					//CONSULTA SI EL MOV. YA FUE CREADO
					$Consulta = "select * from sea_web.movimientos ";
					$Consulta.= " where tipo_movimiento = '1'";
					$Consulta.= " and cod_producto = '17'";
					$Consulta.= " and cod_subproducto = '8'";
					$Consulta.= " and hornada = '".$num_hornada."'";
					$Consulta.= " and fecha_movimiento = '".$fecha."'";
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
					{
						//ACTUALIZA EL MOV. YA CREADO
						$Actualizar = "UPDATE sea_web.movimientos SET "; 
						$Actualizar.= " unidades = '".$Fila["unidades"]."'";
						$Actualizar.= " , peso = '".$Fila["peso"]."'";
						$Actualizar.= " where tipo_movimiento = '1'";
						$Actualizar.= " and cod_producto = '17'";
						$Actualizar.= " and cod_subproducto = '8'";
						$Actualizar.= " and hornada = '".$num_hornada."'";
						$Actualizar.= " and fecha_movimiento = '".$fecha."'";						
						mysqli_query($link, $Actualizar);
					}
					else
					{
						//INSERTA NUEVO MOV.
						$Insertar = "INSERT INTO sea_web.movimientos"; 
						$Insertar.= " (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,campo1,campo2,fecha_benef,peso,hora)";
						$Insertar.= " VALUES (1,17,8,'".$FlujoHM."','".$num_hornada."','".$fecha."', ".$Fila["unidades"].",0,'','','','".$Fila["peso"]."','".$fecha." ".$Hora."')";
						mysqli_query($link, $Insertar);		
					}
					//ACTUALIZA LA TABLA HORNADAS O CREA SI NO EXISTE
					$Consulta = "SELECT * FROM sea_web.hornadas ";
					$Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 8 AND hornada_ventana = '".$num_hornada."'"; 	
					$Resp2 = mysqli_query($link, $Consulta);
					if($Fila2 = mysqli_fetch_array($Resp2))
					{			
						$Actualizar = "UPDATE sea_web.hornadas SET unidades = '".$Fila["unidades"]."', peso_unidades = '".$Fila["peso"]."' ";
						$Actualizar.= " WHERE cod_producto = 17 AND cod_subproducto = 8 AND hornada_ventana = '".$num_hornada."'";
						mysqli_query($link, $Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO sea_web.hornadas "; 
						$Insertar.= " (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades,estado)";
						$Insertar.= " VALUES (17,8,'".$num_hornada."', '".$Fila["unidades"]."', '".$Fila["peso"]."',1)";
						mysqli_query($link, $Insertar);
					}		
				}			
			}
			/********************** Corrientes ********************/			
			$Consulta = "select sum(peso) as peso, sum(unidades) as unidades ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where hornada = '".$num_hornada."'";
			$Consulta.= " and horno = '".$Hornos."'";
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '4'";
			$Consulta.= " and promedio <> 'S'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{ 
				if($Fila["unidades"] != 0)
				{			
					$Consulta = "select * from sea_web.movimientos ";
					$Consulta.= " where tipo_movimiento = '1'";
					$Consulta.= " and cod_producto = '17'";
					$Consulta.= " and cod_subproducto = '4'";
					$Consulta.= " and hornada = '".$num_hornada."'";
					$Consulta.= " and fecha_movimiento = '".$fecha."'";
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET "; 
						$Actualizar.= " unidades = '".$Fila["unidades"]."'";
						$Actualizar.= " , peso = '".$Fila["peso"]."'";
						$Actualizar.= " where tipo_movimiento = '1'";
						$Actualizar.= " and cod_producto = '17'";
						$Actualizar.= " and cod_subproducto = '4'";
						$Actualizar.= " and hornada = '".$num_hornada."'";
						$Actualizar.= " and fecha_movimiento = '".$fecha."'";						
						mysqli_query($link, $Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO sea_web.movimientos"; 
						$Insertar.= " (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,campo1,campo2,fecha_benef,peso,hora)";
						$Insertar.= " VALUES (1,17,4,'".$FlujoCtte."','".$num_hornada."','".$fecha."', '".$Fila["unidades"]."',0,'','','','".$Fila["peso"]."','".$fecha." ".$Hora."')";
						mysqli_query($link, $Insertar);				
					}
					$Consulta = "SELECT unidades,peso_unidades FROM sea_web.hornadas WHERE cod_producto = 17 AND cod_subproducto = 4 AND hornada_ventana = '".$num_hornada."'"; 	
					$Resp2 = mysqli_query($link, $Consulta);
					if($Fila2 = mysqli_fetch_array($Resp2))
					{		
						$Actualizar = "UPDATE sea_web.hornadas SET unidades = '".$Fila["unidades"]."', peso_unidades = '".$Fila["peso"]."' ";
						$Actualizar.= " WHERE cod_producto = 17 AND cod_subproducto = 4 AND hornada_ventana = '".$num_hornada."'";
						mysqli_query($link, $Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO sea_web.hornadas"; 
						$Insertar.= " (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades,estado)";
						$Insertar.= " VALUES (17,4,'".$num_hornada."', '".$Fila["unidades"]."', '".$Fila["peso"]."',0)";
						mysqli_query($link, $Insertar);
					}
				}	
			}		
			/***************** Especiales **************/	  
			$Consulta = "select sum(peso) as peso, sum(unidades) as unidades ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where hornada = '".$num_hornada."'";
			$Consulta.= " and horno = '".$Hornos."'";
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '11'";
			$Consulta.= " and promedio <> 'S'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{ 
				if($Fila["unidades"] != 0)
				{	
					//CONSULTA SI EL MOV. YA FUE CREADO
					$Consulta = "select * from sea_web.movimientos ";
					$Consulta.= " where tipo_movimiento = '1'";
					$Consulta.= " and cod_producto = '17'";
					$Consulta.= " and cod_subproducto = '11'";
					$Consulta.= " and hornada = '".$num_hornada."'";
					$Consulta.= " and fecha_movimiento = '".$fecha."'";
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
					{
						//ACTUALIZA EL MOV. YA CREADO
						$Actualizar = "UPDATE sea_web.movimientos SET "; 
						$Actualizar.= " unidades = '".$Fila["unidades"]."'";
						$Actualizar.= " , peso = '".$Fila["peso"]."'";
						$Actualizar.= " where tipo_movimiento = '1'";
						$Actualizar.= " and cod_producto = '17'";
						$Actualizar.= " and cod_subproducto = '11'";
						$Actualizar.= " and hornada = '".$num_hornada."'";
						$Actualizar.= " and fecha_movimiento = '".$fecha."'";						
						mysqli_query($link, $Actualizar);
					}
					else
					{		 
						$Insertar = "INSERT INTO sea_web.movimientos"; 
						$Insertar.= " (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,campo1,campo2,fecha_benef,peso,hora)";
						$Insertar.= " VALUES (1,17,11,'".$FlujoEsp."','".$num_hornada."','".$fecha."', '".$Fila["unidades"]."',0,'','','','".$Fila["peso"]."','".$fecha." ".$Hora."')";
						mysqli_query($link, $Insertar);				
					}
					$Consulta = "SELECT * FROM sea_web.hornadas ";
					$Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 11 AND hornada_ventana = '".$num_hornada."'"; 	
					$Resp2 = mysqli_query($link, $Consulta);
					if($Fila2 = mysqli_fetch_array($Resp2))
					{						
						$Actualizar = "UPDATE sea_web.hornadas SET unidades = '".$Fila["unidades"]."', peso_unidades = '".$Fila["peso"]."' ";
						$Actualizar.= " WHERE cod_producto = 17 AND cod_subproducto = 11 AND hornada_ventana = '".$num_hornada."'";
						mysqli_query($link, $Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO sea_web.hornadas"; 
						$Insertar.= " (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades,estado)";
						$Insertar.= " VALUES (17,11,'".$num_hornada."', '".$Fila["unidades"]."', '".$Fila["peso"]."',0)";
						mysqli_query($link, $Insertar);
					}
				}
			}
		}
		header("location:sea_ing_prod_vent_auto.php?TipoPesaje=1&Hornos=".$Hornos."&num_hornada=".$num_hornada."&dia=".$dia."&mes=".$mes."&ano=".$ano."&Mensaje=".$Mensaje);			
		break;
	case "E_ProdAnodos":
		$Eliminar = "delete from sea_web.detalle_pesaje ";
		$Eliminar.= " where fecha = '".$FechaElim."'";
		$Eliminar.= " and hornada = '".$HornadaElim."'";
		mysqli_query($link, $Eliminar);
		$num_hornada = $HornadaElim;
		//CALCULAR PROMEDIOS
		$Consulta = "select sum(peso_total) as peso_total, sum(unidades) as unidades,";
		$Consulta.= " (sum(peso_total)/sum(unidades)) as promedio ";
		$Consulta.= " from sea_web.detalle_pesaje ";
		$Consulta.= " where hornada = '".$num_hornada."'";		
		$Consulta.= " and tipo_pesaje = 'PA'";
		$Consulta.= " and promedio = 'S'"; //H.M.
		echo "Consulta:".$Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		$Fila = mysqli_fetch_array($Respuesta);
		//echo "<br>Resultado:".$Fila;
		//exit();
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			//ACTUALIZA LAS UNIDADES DEL PRODUCTO QUE SACA EL PROMEDIO (H.M.)
			//$promedio = str_replace(",",".",$Fila["promedio"]);
				        
			$Actualizar = "UPDATE sea_web.detalle_pesaje SET ";
			$Actualizar.= " peso = (unidades * ".str_replace(",",".",$Fila["promedio"]).")";
			//$Actualizar.= " peso = (unidades * '".$promedio."' ";
			$Actualizar.= " where hornada = '".$num_hornada."'";	
			$Actualizar.= " and tipo_pesaje = 'PA'";
			$Actualizar.= " and cod_producto = '17'";
			$Actualizar.= " and cod_subproducto = '8'";
			$Actualizar.= " and promedio <> 'S'";
			mysqli_query($link, $Actualizar);
			//CONSULTO EL PESO DE LAS H.M.
			$Consulta = "select sum(peso) as peso ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where hornada = '".$num_hornada."'";		
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '8'";
			$Consulta.= " and promedio <> 'S'";
			$Resp2 = mysqli_query($link, $Consulta);			
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				//CONSULTO EL PESO TOTAL DE LAS PESADAS
				$Consulta = "select DISTINCT fecha, peso_total ";
				$Consulta.= " from sea_web.detalle_pesaje ";
				$Consulta.= " where hornada = '".$num_hornada."'";	
				$Consulta.= " and tipo_pesaje = 'PA'";
				$Consulta.= " and promedio <> 'S'";	
				$Resp3 = mysqli_query($link, $Consulta);
				while ($Fila3 = mysqli_fetch_array($Resp3))
				{
					$PesoTotal = $PesoTotal + $Fila3["peso_total"];
				}				
				$PesoHM = $Fila2["peso"];
				$PesoRestante = $PesoTotal - $PesoHM;				
				//TOTAL DE UNIDADES DE LOS OTROS PRODUCTOS
				$Consulta = "select sum(unidades) as unidades ";
				$Consulta.= " from sea_web.detalle_pesaje ";
				$Consulta.= " where hornada = '".$num_hornada."'";
				$Consulta.= " and tipo_pesaje = 'PA'";
				$Consulta.= " and cod_producto = '17' and cod_subproducto <> '8'";
				$Consulta.= " and promedio <> 'S'";
				$Resp3 = mysqli_query($link, $Consulta);
				if ($Fila3 = mysqli_fetch_array($Resp3))
				{
					if ($PesoRestante > 0 && $Fila3["unidades"] > 0)
						$PromedioCtte = $PesoRestante/$Fila3["unidades"];
					else
						$PromedioCtte = 0;
				}
				//echo "PESO TOTAL=".$PesoTotal." PROMEDIO H.M.=".$Fila["promedio"]." PESO H.M.=".$PesoHM." PESO RESTANTE=".$PesoRestante." PROM. RESTANTE=".$PromedioCtte."<br>";
				//TOTAL DE UNIDADES POR CADA UNO DE LOS OTROS PRODUCTOS
				$Consulta = "select cod_producto, cod_subproducto, sum(unidades) as unidades ";
				$Consulta.= " from sea_web.detalle_pesaje ";
				$Consulta.= " where hornada = '".$num_hornada."'";
				$Consulta.= " and tipo_pesaje = 'PA'";
				$Consulta.= " and cod_producto = '17' and cod_subproducto <> '8'";
				$Consulta.= " and promedio <> 'S'";
				$Consulta.= " group by cod_producto, cod_subproducto ";
				$Resp3 = mysqli_query($link, $Consulta);
				while ($Fila3 = mysqli_fetch_array($Resp3))
				{
					//ACTUALIZA LAS UNIDADES DEL RESTO DE LOS PRODUCTO
					$Actualizar = "update sea_web.detalle_pesaje set ";
					$Actualizar.= " peso = (unidades * ".str_replace(",",".",$PromedioCtte).")";
					$Actualizar.= " where hornada = '".$num_hornada."'";	
					$Actualizar.= " and tipo_pesaje = 'PA'";
					$Actualizar.= " and cod_producto = '".$Fila3["cod_producto"]."'";
					$Actualizar.= " and cod_subproducto = '".$Fila3["cod_subproducto"]."'";
					$Actualizar.= " and promedio <> 'S'";
					mysqli_query($link, $Actualizar);
				}
				//CONSULTO EL PESO TOTAL DE LAS UNIDADES Y LO COMPARO CON EL PESO TOTAL
				$Consulta = "select sum(peso) as peso ";
				$Consulta.= " from sea_web.detalle_pesaje ";
				$Consulta.= " where hornada = '".$num_hornada."'";		
				$Consulta.= " and tipo_pesaje = 'PA'";	
				$Consulta.= " and promedio <> 'S'";
				$Resp3 = mysqli_query($link, $Consulta);
				if ($Fila3 = mysqli_fetch_array($Resp3))
				{					
					if ($Fila3["peso"] > $PesoTotal)
					{
						//LE QUITO LA DIF. DE MAS A LAS H.M.
						$Diferencia = $Fila3["peso"] - $PesoTotal;
						//CONSULTO LA PESADA DE LA HORNADA DE H.M. CON MAS PESO
						$Consulta = "select * ";
						$Consulta.= " from sea_web.detalle_pesaje ";
						$Consulta.= " where hornada = '".$num_hornada."'";
						$Consulta.= " and tipo_pesaje = 'PA'";
						$Consulta.= " and cod_producto = '17'";
						$Consulta.= " and cod_subproducto = '8'";
						$Consulta.= " and promedio <> 'S'";
						$Consulta.= " order by peso desc";
						$Resp4 = mysqli_query($link, $Consulta);
						if ($Fila4 = mysqli_fetch_array($Resp4))
						{
							//ACTUALIZA LA PESADA DE LA HORNADA CON MAS PESO
							$Actualizar = "update sea_web.detalle_pesaje set ";
							$Actualizar.= " peso = (peso - ".str_replace(",",".",$Diferencia).")";
							$Actualizar.= " where hornada = '".$num_hornada."'";	
							$Actualizar.= " and tipo_pesaje = 'PA'";
							$Actualizar.= " and fecha = '".$Fila4["fecha"]."'";
							$Actualizar.= " and cod_producto = '17'";
							$Actualizar.= " and cod_subproducto = '8'";
							$Actualizar.= " and num_carro = '".$Fila4["num_carro"]."'";
							$Actualizar.= " and num_rack = '".$Fila4["num_rack"]."'";
							$Actualizar.= " and promedio <> 'S'";
							mysqli_query($link, $Actualizar);
						}						
					}
					else
					{
						if ($Fila3["peso"] < $PesoTotal)
						{
							//LE DOY LA DIF. DE MAS A LAS H.M.
							$Diferencia =  $PesoTotal - $Fila3["peso"];
							//CONSULTO LA PESADA DE LA HORNADA DE H.M. CON MAS PESO
							$Consulta = "select * ";
							$Consulta.= " from sea_web.detalle_pesaje ";
							$Consulta.= " where hornada = '".$num_hornada."'";
							$Consulta.= " and tipo_pesaje = 'PA'";	
							$Consulta.= " and cod_producto = '17'";
							$Consulta.= " and cod_subproducto = '8'";
							$Consulta.= " and promedio <> 'S'";
							$Consulta.= " order by peso desc";
							$Resp4 = mysqli_query($link, $Consulta);
							if ($Fila4 = mysqli_fetch_array($Resp4))
							{
								//ACTUALIZA LA PESADA DE LA HORNADA CON MAS PESO
								$Actualizar = "update sea_web.detalle_pesaje set ";
								$Actualizar.= " peso = (peso + ".str_replace(",",".",$Diferencia).")";
								$Actualizar.= " where hornada = '".$num_hornada."'";	
								$Actualizar.= " and tipo_pesaje = 'PA'";
								$Actualizar.= " and fecha = '".$Fila4["fecha"]."'";
								$Actualizar.= " and cod_producto = '17'";
								$Actualizar.= " and cod_subproducto = '8'";
								$Actualizar.= " and num_carro = '".$Fila4["num_carro"]."'";
								$Actualizar.= " and num_rack = '".$Fila4["num_rack"]."'";
								$Actualizar.= " and promedio <> 'S'";
								mysqli_query($link, $Actualizar);
							}						
						}
					}
				}
			}
		}
		//FINALIZAR HORNADA
		$Consulta = "select distinct estado from sea_web.detalle_pesaje "; 
		$Consulta.= " where hornada = '".$num_hornada."'";
		$Consulta.= " and tipo_pesaje = 'PA'";	
		$Respuesta = mysqli_query($link, $Consulta);
		$Finalizada = false;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["estado"]=="F")
				$Finalizada = true;
		}
		if ($Finalizada)
		{
			//ACTUALIZA CAMPO DE FINALIZADA	
			$Actualizar = "UPDATE sea_web.detalle_pesaje SET "; 
			$Actualizar.= " estado = 'F'";
			$Actualizar.= " where hornada = '".$num_hornada."'";
			$Actualizar.= " and tipo_pesaje = 'PA'";	
			mysqli_query($link, $Actualizar);
			/************* Hojas Madres *********/	
			$Consulta = "select sum(peso) as peso, sum(unidades) as unidades ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where hornada = '".$num_hornada."'";
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '8'";
			$Consulta.= " and promedio <> 'S'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{ 
				if($Fila["unidades"] != 0)
				{	
					//CONSULTA SI EL MOV. YA FUE CREADO
					$Consulta = "select * from sea_web.movimientos ";
					$Consulta.= " where tipo_movimiento = '1'";
					$Consulta.= " and cod_producto = '17'";
					$Consulta.= " and cod_subproducto = '8'";
					$Consulta.= " and hornada = '".$num_hornada."'";
					$Consulta.= " and fecha_movimiento = '".$fecha."'";
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
					{
						//ACTUALIZA EL MOV. YA CREADO
						$Actualizar = "UPDATE sea_web.movimientos SET "; 
						$Actualizar.= " unidades = '".$Fila["unidades"]."'";
						$Actualizar.= " , peso = '".$Fila["peso"]."'";
						$Actualizar.= " where tipo_movimiento = '1'";
						$Actualizar.= " and cod_producto = '17'";
						$Actualizar.= " and cod_subproducto = '8'";
						$Actualizar.= " and hornada = '".$num_hornada."'";
						$Actualizar.= " and fecha_movimiento = '".$fecha."'";						
						mysqli_query($link, $Actualizar);
					}
					else
					{
						//INSERTA NUEVO MOV.
						$Insertar = "INSERT INTO sea_web.movimientos"; 
						$Insertar.= " (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,campo1,campo2,fecha_benef,peso,hora)";
						$Insertar.= " VALUES (1,17,8,'".$FlujoHM."','".$num_hornada."','".$fecha."', ".$Fila["unidades"].",0,'','','','".$Fila["peso"]."','".$fecha." ".$Hora."')";
						mysqli_query($link, $Insertar);		
					}
					//ACTUALIZA LA TABLA HORNADAS O CREA SI NO EXISTE
					$Consulta = "SELECT * FROM sea_web.hornadas ";
					$Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 8 AND hornada_ventana = '".$num_hornada."'"; 	
					$Resp2 = mysqli_query($link, $Consulta);
					if($Fila2 = mysqli_fetch_array($Resp2))
					{			
						$Actualizar = "UPDATE sea_web.hornadas SET unidades = '".$Fila["unidades"]."', peso_unidades = '".$Fila["peso"]."' ";
						$Actualizar.= " WHERE cod_producto = 17 AND cod_subproducto = 8 AND hornada_ventana = '".$num_hornada."'";
						mysqli_query($link, $Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO sea_web.hornadas "; 
						$Insertar.= " (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades,estado)";
						$Insertar.= " VALUES (17,8,'".$num_hornada."', '".$Fila["unidades"]."', '".$Fila["peso"]."',0)";
						mysqli_query($link, $Insertar);
					}		
				}			
			}
			/********************** Corrientes ********************/			
			$Consulta = "select sum(peso) as peso, sum(unidades) as unidades ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where hornada = '".$num_hornada."'";
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '4'";
			$Consulta.= " and promedio <> 'S'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{ 
				if($Fila["unidades"] != 0)
				{			
					$Consulta = "select * from sea_web.movimientos ";
					$Consulta.= " where tipo_movimiento = '1'";
					$Consulta.= " and cod_producto = '17'";
					$Consulta.= " and cod_subproducto = '4'";
					$Consulta.= " and hornada = '".$num_hornada."'";
					$Consulta.= " and fecha_movimiento = '".$fecha."'";
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET "; 
						$Actualizar.= " unidades = '".$Fila["unidades"]."'";
						$Actualizar.= " , peso = '".$Fila["peso"]."'";
						$Actualizar.= " where tipo_movimiento = '1'";
						$Actualizar.= " and cod_producto = '17'";
						$Actualizar.= " and cod_subproducto = '4'";
						$Actualizar.= " and hornada = '".$num_hornada."'";
						$Actualizar.= " and fecha_movimiento = '".$fecha."'";						
						mysqli_query($link, $Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO sea_web.movimientos"; 
						$Insertar.= " (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,campo1,campo2,fecha_benef,peso,hora)";
						$Insertar.= " VALUES (1,17,4,'".$FlujoCtte."','".$num_hornada."','".$fecha."', '".$Fila["unidades"]."',0,'','','','".$Fila["peso"]."','".$fecha." ".$Hora."')";
						mysqli_query($link, $Insertar);				
					}
					$Consulta = "SELECT unidades,peso_unidades FROM sea_web.hornadas WHERE cod_producto = 17 AND cod_subproducto = 4 AND hornada_ventana = '".$num_hornada."'"; 	
					$Resp2 = mysqli_query($link, $Consulta);
					if($Fila2 = mysqli_fetch_array($Resp2))
					{		
						$Actualizar = "UPDATE sea_web.hornadas SET unidades = '".$Fila["unidades"]."', peso_unidades = '".$Fila["peso"]."' ";
						$Actualizar.= " WHERE cod_producto = 17 AND cod_subproducto = 4 AND hornada_ventana = '".$num_hornada."'";
						mysqli_query($link, $Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO sea_web.hornadas"; 
						$Insertar.= " (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades,estado)";
						$Insertar.= " VALUES (17,4,'".$num_hornada."', '".$Fila["unidades"]."', '".$Fila["peso"]."',0)";
						mysqli_query($link, $Insertar);
					}
				}	
			}		
			/***************** Especiales **************/	  
			$Consulta = "select sum(peso) as peso, sum(unidades) as unidades ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where hornada = '".$num_hornada."'";
			$Consulta.= " and tipo_pesaje = 'PA'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '11'";
			$Consulta.= " and promedio <> 'S'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{ 
				if($Fila["unidades"] != 0)
				{	
					//CONSULTA SI EL MOV. YA FUE CREADO
					$Consulta = "select * from sea_web.movimientos ";
					$Consulta.= " where tipo_movimiento = '1'";
					$Consulta.= " and cod_producto = '17'";
					$Consulta.= " and cod_subproducto = '11'";
					$Consulta.= " and hornada = '".$num_hornada."'";
					$Consulta.= " and fecha_movimiento = '".$fecha."'";
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Fila2 = mysqli_fetch_array($Resp2))
					{
						//ACTUALIZA EL MOV. YA CREADO
						$Actualizar = "UPDATE sea_web.movimientos SET "; 
						$Actualizar.= " unidades = '".$Fila["unidades"]."'";
						$Actualizar.= " , peso = '".$Fila["peso"]."'";
						$Actualizar.= " where tipo_movimiento = '1'";
						$Actualizar.= " and cod_producto = '17'";
						$Actualizar.= " and cod_subproducto = '11'";
						$Actualizar.= " and hornada = '".$num_hornada."'";
						$Actualizar.= " and fecha_movimiento = '".$fecha."'";						
						mysqli_query($link, $Actualizar);
					}
					else
					{		 
						$Insertar = "INSERT INTO sea_web.movimientos"; 
						$Insertar.= " (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,campo1,campo2,fecha_benef,peso,hora)";
						$Insertar.= " VALUES (1,17,11,'".$FlujoEsp."','".$num_hornada."','".$fecha."', '".$Fila["unidades"]."',0,'','','','".$Fila["peso"]."','".$fecha." ".$Hora."')";
						mysqli_query($link, $Insertar);				
					}
					$Consulta = "SELECT * FROM sea_web.hornadas ";
					$Consulta.= " WHERE cod_producto = 17 AND cod_subproducto = 11 AND hornada_ventana = '".$num_hornada."'"; 	
					$Resp2 = mysqli_query($link, $Consulta);
					if($Fila2 = mysqli_fetch_array($Resp2))
					{						
						$Actualizar = "UPDATE sea_web.hornadas SET unidades = '".$Fila["unidades"]."', peso_unidades = '".$Fila["peso"]."' ";
						$Actualizar.= " WHERE cod_producto = 17 AND cod_subproducto = 11 AND hornada_ventana = '".$num_hornada."'";
						mysqli_query($link, $Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO sea_web.hornadas"; 
						$Insertar.= " (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades,estado)";
						$Insertar.= " VALUES (17,11,'".$num_hornada."', '".$Fila["unidades"]."', '".$Fila["peso"]."',0)";
						mysqli_query($link, $Insertar);
					}
				}
			}
		}
		header("location:sea_ing_prod_vent_auto_anodos_det2.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Hornada=".$Hornada);
		break;
	case "Genera_Hornada":	
		$num_hornada = $ano.$mes.$num_hornada;								
		$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2005 and cod_subclase=4";
		$rs = mysqli_query($link, $Consulta);
		if($row = mysqli_fetch_array($rs))
		{
			$horno1=$row['valor_subclase1'];
			$horno2=$row['valor_subclase2'];
			$horno3=$row['valor_subclase3'];		
			$mes = str_pad($mes,2,"0",STR_PAD_LEFT);			
			$horno1 = $ano.$mes.$horno1;
			$horno2 = $ano.$mes.$horno2;
			$horno3 = $ano.$mes.$horno3;		
		}
		$num_hornada = "";
		$Consulta = "Select MAX(hornada_ventana) AS hornada_max FROM sea_web.hornadas ";
		$Consulta.= " WHERE cod_producto=17 AND cod_subproducto IN (4,8,11) AND right(hornada_ventana,4) LIKE '".$Hornos."%'";
		$rs= mysqli_query($link, $Consulta);
		if($row = mysqli_fetch_array($rs))
		{	                
			if($Hornos == 1)
			{
				if (is_null($row["hornada_max"]))			  
					$num_hornada = substr($horno1,6,6); 	
				elseif($Reiniciar == "S")
					$num_hornada = substr($horno1,6,6);
				else
					$num_hornada = substr($row["hornada_max"]+1,6,6);
			}		
			if($Hornos == 2)
			{
				if (is_null($row["hornada_max"]))			  
					$num_hornada = substr($horno2,6,6); 	
				elseif($Reiniciar == "S")
					$num_hornada = substr($horno2,6,6);
				else  
					$num_hornada = substr($row["hornada_max"]+1,6,6);						   
			}		
			if($Hornos == 4)
			{
				if (is_null($row["hornada_max"]))			  
					$num_hornada = substr($horno3,6,6); 	
				elseif($Reiniciar == "S")
					$num_hornada = substr($horno3,6,6);
				else  
					$num_hornada = substr($row["hornada_max"]+1,6,6);
			}
			//GRABA REGISTRO PROVISORIO DE LA HORNADA (TIPO PESAJE = "N")
			$num_hornada = $ano.str_pad($mes,2,"0",STR_PAD_LEFT).$num_hornada; 
			if ($num_hornada != "")
			{
				$Consulta = "select * from sea_web.detalle_pesaje ";
				$Consulta.= " where hornada = '".$num_hornada."'";
				$Consulta.= " and fecha between '".$fecha." 00:00:00' and '".$fecha." 23:59:59'";
				$Consulta.= " and horno = '".$Hornos."'";
				$Consulta.= " and tipo_pesaje='PA'";
				$Respuesta = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				if ($Fila = mysqli_fetch_array($Respuesta))
				{
					//YA EXISTE O YA HAY UNA HORNAD EN PROCESO;
					$Mensaje = "YA EXISTE UNA HORNADA EN PROCESO";
				}
				else
				{
					$Consulta = "select * from sea_web.detalle_pesaje ";
					$Consulta.= " where estado <> 'F'";
					$Consulta.= " and fecha between '".$fecha." 00:00:00' and '".$fecha." 23:59:59'";
					$Consulta.= " and horno = '".$Hornos."'";
					$Consulta.= " and tipo_pesaje='PA'";
					$Respuesta = mysqli_query($link, $Consulta);
					//echo $Consulta."<br>";
					if ($Fila = mysqli_fetch_array($Respuesta))	
					{
						//ALGUNA HORNADA DE ESE HORNO ESTA EN PROCESO Y NO SE HA FINALIZADO;
						$Mensaje = "YA EXISTE UNA HORNADA EN PROCESO";
					}
					else
					{				
						$Insertar = "INSERT INTO sea_web.detalle_pesaje ";
						$Insertar.= " (`tipo_pesaje`, `cod_producto`, `cod_subproducto`, `horno`, `fecha`, `hornada`, `estado`, `bascula`) ";
						$Insertar.= " VALUES ('PA', '17', '4', '".$Hornos."', '".$fecha." ".date("H:i:s")."', '".$num_hornada."', 'C', '".$IpPc."');";
						mysqli_query($link, $Insertar);
						$Mensaje = "";
					}
				}
			}
		} 	
		header("location:sea_ing_prod_vent_auto.php?TipoPesaje=1&Hornos=".$Hornos."&num_hornada=".$num_hornada."&Mensaje=".$Mensaje);	 
		break;	
	//****************************************************************************************//
	//*********************************TARA DE RACKS Y CARROS*********************************//
	//****************************************************************************************//			
	case "G_Tara":
		$FechaPesaje = $ano."-".$mes."-".$dia;
		$Numero = intval($Numero);
		$Consulta = "SELECT * from sea_web.taras ";
		$Consulta.= " where tipo_tara = '".$TipoTara."' and numero = '".$Numero."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			//ACTUALIZA DATOS
			$Actualizar = "UPDATE sea_web.taras set ";
			$Actualizar.= " peso = '".str_replace(",",".",$PesoBruto)."'";
			$Actualizar.= " , fecha_pesaje = '".$FechaPesaje."'";
			$Actualizar.= " where tipo_tara = '".$TipoTara."' and numero = '".$Numero."'";
			mysqli_query($link, $Actualizar);
		}
		else
		{
			$Insertar = "INSERT INTO sea_web.taras(tipo_tara, numero, peso, fecha_pesaje) VALUES";
			$Insertar.= " ('".$TipoTara."','".$Numero."','".str_replace(",",".",$PesoBruto)."','".$FechaPesaje."')";
			mysqli_query($link, $Insertar);
		}
		header("location:sea_ing_prod_vent_auto.php?TipoPesaje=4&TipoTara=".$TipoTara);
		break;
	case "E_Tara":
		$Numero = intval($Numero);
		$Eliminar = "DELETE from sea_web.taras ";
		$Eliminar.= " where tipo_tara = '".$TipoTara."' and numero = '".$Numero."'";
		mysqli_query($link, $Eliminar);
		header("location:sea_ing_prod_vent_auto.php?TipoPesaje=4&TipoTara=".$TipoTara);
		//header("location:sea_ing_prod_vent_auto_taras_det.php?Tipo=".$TipoTara);
		break;
	case "G_Periodo";
		$FechaPesaje = $ano."-".$mes."-".$dia;
		$Periodo = intval($Periodo);
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '2012' and cod_subclase = '1'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			//ACTUALIZA DATOS
			$Actualizar = "update proyecto_modernizacion.sub_clase set ";
			$Actualizar.= " valor_subclase1 = '".$Periodo."'";
			$Actualizar.= " where cod_clase = '2012' and cod_subclase = '1'";
			mysqli_query($link, $Actualizar);
		}
		else
		{
			$Insertar = "insert into proyecto_modernizacion.sub_clase(cod_clase, cod_subclase, nombre_subclase, valor_subclase1) VALUES";
			$Insertar.= " ('2012','1','Periodo de Pesaje de Racks y Carros','".$Periodo."')";
			mysqli_query($link, $Insertar);
		}
		header("location:sea_ing_prod_vent_auto.php?TipoPesaje=4&TipoTara=".$TipoTara);
		break;
	//****************************************************************************************//
	//****PRODUCCION RESTOS DE ANODOS CORRIENTES Y RESTOS DE RESTOS HOJAS MADRE***************//
	//****************************************************************************************//			
	case "B_RestosAnodos": //BUSCA GRUPO, LADO Y FECHA DE CARGA
			$Grupo = intval($Grupo);
			$FechaProd = $ano."-".$mes."-".$dia;	
			//BUSCA PRIMERO DENTRO DEL DIA SI HAY PESADAS PARA ESE GRUPO, SI LAS HAY LE ASIGNA EL MISMO GRUPO/LADO
			//YA QUE NO PUEDE ESTAR EL MISMO GRUPO 2 VECES EN EL DIA
			$Consulta = "select * from sea_web.detalle_pesaje ";
			$Consulta.= " where tipo_pesaje = 'RA'";
			$Consulta.= " and fecha between '".$FechaProd." 00:00:00' and '".$FechaProd." 23:59:59'";
			$Consulta.= " and cod_producto = '".$Grupo."' and estado = 'F'";
			//echo "uno".$Consulta;
			$RespAux = mysqli_query($link, $Consulta);
			if ($FilaAux = mysqli_fetch_array($RespAux))
			{
				$Lado = $FilaAux["cod_subproducto"];
				$FechaCarga = $FilaAux["fecha_carga"];	
				$Linea = "&Modif=S&GrupoModif=".$Grupo."&LadoModif=".$Lado."&FechaHora=".$ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($dia,2,"0",STR_PAD_LEFT)." ".date("H:i:s");
			}
			else
			{
				//SI NO ESTA SIGUE POR EL CONDUCTO REGULAR DE BUSCA EN DIAS PARA ATRAS
				//Obtiene el lado cargado (Mar, Tierra, Norte, Sur) del grupo seleccionado. (el mas antiguo).
				$Consulta = "SELECT campo1, fecha_movimiento ";
				$Consulta.= " FROM sea_web.movimientos ";
				$Consulta.= " WHERE tipo_movimiento = 2  and cod_producto = '17'";
				$Consulta.= " AND numero_recarga = 0 AND campo1 IN ('M','T','S','N')";
				$Consulta.= " AND campo2 = '".$Grupo."' ";
				$Consulta.= " ORDER BY fecha_movimiento ASC";
				//echo "dos".$Consulta;
				$Resp = mysqli_query($link, $Consulta);
				$Fila = mysqli_fetch_array($Resp);			
				$Lado = $Fila["campo1"];
				$FechaCarga = $Fila["fecha_movimiento"];																
			}//FIN IF LADO, FECHA CARGA
			//Obtiene los codigos que representan a los Anodos Ctes.
			$Parametros = "";
			$TotalUnidCorr = 0;
			$TotalPesoCorr = 0;
			$Consulta = "SELECT valor_subclase1 AS valor ";
			$Consulta.= " FROM proyecto_modernizacion.sub_clase ";
			$Consulta.= " WHERE cod_clase = 2002";			
			$Resp = mysqli_query($link, $Consulta);						
			while ($Fila = mysqli_fetch_array($Resp))
			{
				//Obtiene las unidades de los Anodos Ctes y su peso.
				$Consulta = "SELECT IFNULL(SUM(unidades),0) AS unidadesmov, IFNULL(SUM(peso),0) AS peso ";
				$Consulta.= " FROM sea_web.movimientos ";
				$Consulta.= " WHERE tipo_movimiento = 2 ";
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."' AND cod_subproducto = ".$Fila["valor"];
				$Consulta.= " AND fecha_movimiento = '".$FechaCarga."'";
				//echo "tres".$Consulta;
				$Resp1 = mysqli_query($link, $Consulta);
				$Fila1 = mysqli_fetch_array($Resp1);						
				//Genera los parametros.
				$Parametros = $Parametros.$Fila["valor"]."-".$Fila1["unidadesmov"]."-".$Fila1["peso"]."/";			
				$TotalPesoCorr = $TotalPesoCorr + $Fila1["peso"];
				$TotalUnidCorr = $TotalUnidCorr + $Fila1["unidadesmov"];		
			}		
			//Saco el FACTOR asociado al grupo.		
			$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase ";
			$Consulta.= " WHERE cod_clase = 2004 AND cod_subclase = '".$Grupo."'";
			$Resp = mysqli_query($link, $Consulta);			
			$Fila = mysqli_fetch_array($Resp);			
			$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase ";
			$Consulta.= " WHERE cod_clase = 2003 AND cod_subclase = ".$Fila["valor_subclase1"];
			$Resp = mysqli_query($link, $Consulta);
			$Fila = mysqli_fetch_array($Resp);		
			$ValorFactor = $Fila["valor_subclase1"];
			//CODIGOS H.M.
			$Consulta = "SELECT valor_subclase2 FROM proyecto_modernizacion.sub_clase ";
			$Consulta.= " WHERE cod_clase = 2002"; //Colunma de H.M.
			$Resp = mysqli_query($link, $Consulta);					
			$ValoresHM = "";
			while ($Fila = mysqli_fetch_array($Resp))
			{
				$ValoresHM = $ValoresHM.$Fila["valor_subclase2"].","; 
			}
			$ValoresHM = substr($ValoresHM,0,strlen($ValoresHM)-1);					
			//Obtiene la hornada y las unidades de los Anodos Restos H.M.
			$TotalUnidHM = 0;
			$TotalPesoHM = 0;
			$Consulta = "SELECT IFNULL(SUM(unidades),0) AS unidadesmov, IFNULL(SUM(peso),0) AS peso ";
			$Consulta.= " FROM sea_web.movimientos ";
			$Consulta.= " WHERE tipo_movimiento = 2 AND cod_producto = 19";
			$Consulta.= " AND cod_subproducto in (".$ValoresHM.") AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
			$Consulta.= " AND fecha_movimiento = '".$FechaCarga."'";			
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				$TotalUnidHM = $Fila["unidadesmov"];
				$TotalPesoHM = $Fila["peso"];
			}
			$Linea.="&NumCarro=".$NumCarro."&NumRack=".$NumRack."&Parametros=".$Parametros."&UnidCorr=".$TotalUnidCorr."&PesoCorr=".$TotalPesoCorr."&Factor=".$ValorFactor;
			$Linea.= "&Grupo=".$Grupo."&Lado=".$Lado."&FechaCarga=".$FechaCarga;
			$Linea.= "&UnidHM=".$TotalUnidHM."&PesoHM=".$TotalPesoHM;
			$Linea.= "&dia=".$dia."&mes=".$mes."&ano=".$ano;
			header("Location:sea_ing_prod_vent_auto.php?PesoAuto=checked&TipoPesaje=2".$Linea);
			break;
		case "G_RestosAnodos":		
			$HoraAux=date('G');
			$MinAux=date('i');
			$SegAux=date('s');
			$Hora=$HoraAux.":".$MinAux.":".$SegAux;		
			$PesoNeto = $PesoBruto - $TotalTara;									
			$Consulta = "select * from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$fecha." ".$Hora."'";
			$Consulta.= " and tipo_pesaje = 'RA'";
			$Consulta.= " and cod_producto = '".$Grupo."'";
			$Consulta.= " and cod_subproducto = '".$Lado."'";
			$Consulta.= " and fecha_carga = '".$FechaCarga."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				//ACTUALIZA DATOS				
				$Actualizar = "UPDATE sea_web.`detalle_pesaje` SET ";
				$Actualizar.= " horno= '".$NumCubas."'";
				$Actualizar.= " , num_carro = '".$NumCarro."'";
				$Actualizar.= " , num_rack = '".$NumRack."'";
				$Actualizar.= " , peso_total = '".$PesoNeto."' ";
				$Actualizar.= " , bascula = '".$IpPc."' ";
				$Actualizar.= " where fecha = '".$fecha." ".$Hora."'";
				$Actualizar.= " and tipo_pesaje = 'RA'";
				$Actualizar.= " and cod_producto = '".$Grupo."'";
				$Actualizar.= " and cod_subproducto = '".$Lado."'";			
				$CActualizar.= " and fecha_carga = '".$FechaCarga."'";					
				mysqli_query($link, $Actualizar);
			}
			else
			{			
				//INSERTA DATOS
				$Insertar = "INSERT INTO sea_web.`detalle_pesaje` (`fecha`, `cod_producto`,`cod_subproducto`,`tipo_pesaje`, `horno`, `rueda`, `hornada`, ";
				$Insertar.= " `num_carro`, `num_rack`, `unidades`, `peso`, `peso_total`, `estado`, `promedio`, `fecha_carga`, `bascula`) ";
				$Insertar.= " VALUES ('".$fecha." ".$Hora."', '".$Grupo."', '".$Lado."', 'RA', '".$NumCubas."', '0', '0', ";
				$Insertar.= " '".$NumCarro."', '".$NumRack."', '0', '0', '".$PesoNeto."', 'P', '', '".$FechaCarga."', '".$IpPc."')";
				//echo $Insertar;
				//exit();
				mysqli_query($link, $Insertar);	
			}
			//OTRAS OPCIONES
			if ($NuevoCarro == "S") //INSERTA NUEVO CARRO
			{
				$Insertar = "insert into sea_web.taras(tipo_tara, numero, peso, fecha_pesaje) VALUES";
				$Insertar.= " ('C','".intval($NumCarro)."','".str_replace(",",".",$PesoCarro)."','".$fecha."')";
				mysqli_query($link, $Insertar);
			}
			if ($NuevoRack == "S") //INSERTA NUEVO RACK
			{
				$Insertar = "insert into sea_web.taras(tipo_tara, numero, peso, fecha_pesaje) VALUES";
				$Insertar.= " ('R','".intval($NumRack)."','".str_replace(",",".",$PesoRack)."','".$fecha."')";
				mysqli_query($link, $Insertar);
			}					
			if ($ChkFin == "S") //GENERA HORNADAS	
			{
				$Fecha = $ano."-".$mes."-".$dia;
				//ACTUALIZA CAMPO DE FINALIZADA
				$Actualizar = "UPDATE sea_web.detalle_pesaje SET "; 
				$Actualizar.= " estado = 'F'";
				$Actualizar.= " where cod_producto = '".$Grupo."'";
				$Actualizar.= " and cod_subproducto = '".$Lado."'";
				$Actualizar.= " and fecha_carga = '".$FechaCarga."'";
				$Actualizar.= " and tipo_pesaje = 'RA'";	
				mysqli_query($link, $Actualizar);
				//FINALIZAR HORNADA Graba datos a tablas principales													
				//CALCULA EL PESO PRODUCCION
				$Consulta = "select sum(peso_total) as peso_prod from sea_web.detalle_pesaje ";
				$Consulta.= " where tipo_pesaje = 'RA'";
				$Consulta.= " and cod_producto = '".$Grupo."'";
				$Consulta.= " and cod_subproducto = '".$Lado."'";
				$Consulta.= " and fecha_carga = '".$FechaCarga."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Respuesta))				
					$PesoProduccion = $Fila["peso_prod"];								
				if ($UnidCorr == 0)
				{
					$PesoCorr = 0;	
					$PesoHM = round($PesoProduccion);	
				}	
				else 
				{
					if ($UnidHM == 0)
					{		
						$PesoHM = 0;
						$PesoCorr = round($PesoProduccion);	
					}
					else 
					{
						$PesoCorr = round($PesoProduccion * ((100-$Factor)/100));
						$PesoHM = round($PesoProduccion - $PesoCorr);
					}
				}
				//echo $Factor."UNID".$UnidCorr."pesop".$PesoProduccion."pesoC".$PesoCorr;
				//Valida que no se haga produccion el mismo dia de un grupo.
				$HornadaCtte = "";
				$HornadaHM = "";
				$Consulta = "SELECT * FROM sea_web.movimientos ";
				$Consulta.= " WHERE tipo_movimiento = 3 ";
				$Consulta.= " AND cod_producto = 19 ";
				$Consulta.= " AND fecha_movimiento = '".$Fecha."'";
				$Consulta.=" and campo1 = '".$Lado."' and campo2 = '".$Grupo."'";
				//$Consulta.= " AND campo1 IN ('M','T','S','M') AND campo2 = '".$Grupo."'";
				$Resp = mysqli_query($link, $Consulta);								
				if ($Fila = mysqli_fetch_array($Resp))
				{
					//Ya existe produccion.					
					$Mensaje = "Ya existe Produccion del Grupo en este dia";
					header("Location:sea_ing_prod_vent_auto.php?PesoAuto=checked&TipoPesaje=2&Mensaje=".$Mensaje."&dia=".$dia."&mes=".$mes."&ano=".$ano);
					break;
				} 
				//Se concatena con la hornada, lo cual genera una hornada unica en la tabla.
				$ano_mes = $ano.str_pad($mes,2,"0",STR_PAD_LEFT);															
				//GENERA LA HORNADA RESTOS CTES.						
				$Parametros = "";						
				if ($UnidCorr != 0)
				{	$promedio = $PesoCorr / $UnidCorr;
					$PromCtte = number_format($promedio, 3 ,".", "");
				} 
				if ($PesoHM != 0)
				{
					$promediohm = $PesoHM / $UnidHM;
					$PromHM = number_format($promediohm, 3 ,".", "");
				}
				//echo $PromCtte."--".$UnidCorr."==".$PesoCorr; 									
				//Busca los productos que son Anodos Ctes.
				$Consulta = "SELECT valor_subclase1 AS valor FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002";	
				$Resp = mysqli_query($link, $Consulta);		
				while ($Fila = mysqli_fetch_array($Resp))
				{					
					//Bucsca la hornada + 1, de Restos Ctes.
					$Consulta = "SELECT MAX(case when length(substring(hornada_ventana,7,6))=4 then concat('00',substring(hornada_ventana,7,6)) else substring(hornada_ventana,7,6) end) AS hornada_max";
					$Consulta.= " FROM sea_web.hornadas";
					$Consulta.= " WHERE cod_producto = 19 AND cod_subproducto = ".$Fila["valor"];
					$Resp2 = mysqli_query($link, $Consulta);
					$Fila2 = mysqli_fetch_array($Resp2);
					if (is_null($Fila2["hornada_max"]))
					{
						//Busca la Horndada de inicio, Restos Ctes.
						$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase ";
						$Consulta.= " WHERE cod_clase = 2007 AND cod_subclase = ".$Fila["valor"];
						$Resp3 = mysqli_query($link, $Consulta);
						$Fila3 = mysqli_fetch_array($Resp3);
						$HornadaCtte = $ano_mes.$Fila3["valor_subclase1"];			
					}
					else 
					{
						$HornadaCtte = $ano_mes.$Fila2["hornada_max"] + 1;						
					}
					//Suma Unidades de los movimientos asociados.
					$Consulta = "SELECT SUM(unidades) AS unidmov ";
					$Consulta.= " FROM sea_web.movimientos ";
					$Consulta.= " WHERE tipo_movimiento = 2 AND cod_producto = 17 ";
					$Consulta.= " AND numero_recarga = 0" ;
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."' AND cod_subproducto = ".$Fila["valor"];
					$Consulta.= " AND fecha_movimiento = '".$FechaCarga."'";
					$Resp2 = mysqli_query($link, $Consulta);			
					$Fila2 = mysqli_fetch_array($Resp2);
					if (!is_null($Fila2["unidmov"]))
					{				
						//Busca los movimientos asociados.
						$Consulta = "SELECT * FROM sea_web.movimientos ";
						$Consulta.= " WHERE tipo_movimiento = 2 AND cod_producto = 17 ";
						$Consulta.= " AND numero_recarga = 0" ;
						$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."' ";
						$Consulta.= " AND cod_subproducto = ".$Fila["valor"];
						$Consulta.= " AND fecha_movimiento = '".$FechaCarga."'";										
						$Resp3 = mysqli_query($link, $Consulta);
						while ($Fila3 = mysqli_fetch_array($Resp3))
						{
							//Busca el flujo Asociado al producto y proceso.
							$Consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
							$Consulta.= " WHERE cod_proceso = 3 AND cod_producto = 19";
							$Consulta.= " AND cod_subproducto = ".$Fila["valor"];
							$Resp4 = mysqli_query($link, $Consulta);
							if ($Fila4 = mysqli_fetch_array($Resp4))
								$Flujo = $Fila4["flujo"];
							else 
								$Flujo = 0;													
							//Asocia los Beneficios a Produccion( Crea los movimientos de Produccion ).	
							$Insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,";
							$Insertar.= " hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
							$Insertar.= " VALUES (3,19,".$Fila["valor"].",".$HornadaCtte.",".$Fila3["hornada"].",'".$Fecha."','".$Lado."'";
							$Insertar.= ",'".$Grupo."',".$Fila3["unidades"].",".$Flujo.",'".$Fila3["fecha_movimiento"]."'";
							$Insertar.= ",".($Fila3["unidades"] * $PromCtte).",'".$fecha." ".$Hora."')";					
							mysqli_query($link, $Insertar);							
							//Actualiza los Beneficio para que no los vuelva a tomar.
							$Actualizar = "UPDATE sea_web.movimientos SET numero_recarga = 1 WHERE tipo_movimiento = 2 AND cod_producto = 17 AND numero_recarga = 0";
							$Actualizar.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."' AND cod_subproducto = ".$Fila["valor"];
							$Actualizar.= " AND hornada = ".$Fila3["hornada"]." AND unidades = ".$Fila3["unidades"];
							$Actualizar.= " AND fecha_movimiento = '".$Fila3["fecha_movimiento"]."'";
							mysqli_query($link, $Actualizar);					
						}						
					}
				}	
				//Agrega � Resta la diferencia a un registo, el con mas unidades en la produccion.
				$Consulta = "SELECT SUM(peso) AS peso_mov, fecha_benef FROM sea_web.movimientos";
				$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND cod_subproducto <> 30";
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
				$Consulta.= " GROUP BY fecha_benef";				
				$Resp = mysqli_query($link, $Consulta);
				$Fila = mysqli_fetch_array($Resp);
				$Diferencia = ($PesoCorr - $Fila["peso_mov"]);
				if ($Diferencia<>0)
				{
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND fecha_benef = '".$Fila["fecha_benef"]."'";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."' AND cod_subproducto <> 30";		 
					$Consulta.= " ORDER BY peso DESC";				
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Resp))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND numero_recarga = ".$Fila["numero_recarga"];
						$Actualizar.= " AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
						$Actualizar.= " AND campo1 = '".$Fila["campo1"]."' AND campo2 = '".$Fila["campo2"]."' AND unidades = ".$Fila["unidades"];
						$Actualizar.= " AND fecha_benef = '".$Fila["fecha_benef"]."' AND peso = '".$Fila["peso"]."'";
						mysqli_query($link, $Actualizar);						
					}
				}					
				//SUMA UNIDADES Y PESO DEL GRUPO PARA CREACION DE HORNADA DE RESTOS CTES EN LA TABLA HORNADAS.
				$Consulta = "SELECT cod_subproducto, hornada, SUM(unidades) AS unidades, SUM(peso) AS peso FROM sea_web.movimientos";
				$Consulta.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
				$Consulta.= " AND fecha_movimiento = '".$Fecha."' AND cod_subproducto <> 30";
				$Consulta.= " GROUP BY hornada";
				$Fila = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					//Crea la Hornada en la tabla Hornadas (Restos Ctes.).
					$Insertar = "INSERT INTO sea_web.hornadas (cod_producto, cod_subproducto, hornada_ventana, unidades, peso_unidades,estado)"; 
					$Insertar.= " VALUES (19,".$Fila["cod_subproducto"].",'".$Fila["hornada"]."',".$Fila["unidades"].",".$Fila["peso"].",0)";
					mysqli_query($link, $Insertar);
					//Crea parametros para mostrar en el popup.
					$Parametros = $Parametros.$Fila["hornada"]."-".$Fila["unidades"]."-".$Fila["peso"]."/";				
				}	
				//GENERA LA HORNADA RESTOS DE RESTOS DE HOJAS MADRES.
				if ($UnidHM != 0)
				{
					//Bucsca la hornada + 1, de Restos de Restos H.M.
					$Consulta = "SELECT MAX(case when length(substring(hornada_ventana,7,6))=4 then concat('00',substring(hornada_ventana,7,6)) else substring(hornada_ventana,7,6) end) AS hornada_max";
					$Consulta.= " FROM sea_web.hornadas";
					$Consulta.= " WHERE cod_producto = 19 AND cod_subproducto = 30";
					$Resp = mysqli_query($link, $Consulta);
					$Fila = mysqli_fetch_array($Resp);
					if (is_null($Fila["hornada_max"]))
					{
						//Busca la Horndada de inicio, Restos Ctes.		
						$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2007 AND cod_subclase = 30";
						$Resp1 = mysqli_query($link, $Consulta);
						$Fila1 = mysqli_fetch_array($Resp1);
						$HornadaHM = $ano_mes.$Fila1["valor_subclase1"];
					}
					else 
					{
						$HornadaHM = $ano_mes.$Fila["hornada_max"] + 1;	
					}			
					//Buscar los codigos de H.M.
					$Valores = "";
					$Consulta = "SELECT valor_subclase2 AS hm FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002";
					$Resp = mysqli_query($link, $Consulta);						
					while ($Fila = mysqli_fetch_array($Resp)) 
					{
						$Valores = $Valores.$Fila["hm"].",";
					}
					$Valores = substr($Valores,0,strlen($Valores)-1);			
					$Consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 19 AND numero_recarga = 0" ;
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."' AND cod_subproducto in (".$Valores.")";
					$Consulta.= " AND fecha_movimiento = '".$FechaCarga."'";
					//echo $Consulta."<br>";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						//Busca el flujo Asociado al producto y proceso.
						$Consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
						$Consulta.= " WHERE cod_proceso = 3 AND cod_producto = 19";
						$Consulta.= " AND cod_subproducto = 30";
						$Resp1 = mysqli_query($link, $Consulta);
						if ($Fila1 = mysqli_fetch_array($Resp1))
							$Flujo = $Fila1["flujo"];
						else 
							$Flujo = 0;											
						//Asocia los Beneficios a Produccion( Crea los movimientos de Produccion ).	
						$Insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
						$Insertar.= " VALUES (3,19,30,'".$HornadaHM."','".$Fila["hornada"]."','".$Fecha."','".$Lado;
						$Insertar.= "','".$Grupo."','".$Fila["unidades"]."','".$Flujo."','".$Fila["fecha_movimiento"]."','".($Fila["unidades"] * $PromHM)."','".$fecha." ".$Hora."')";
						mysqli_query($link, $Insertar);	
						//echo $Insertar."<br>";					
						//Actualiza los Beneficio para que no los vuelva a tomar.
						$Actualizar = "UPDATE sea_web.movimientos SET numero_recarga = 1 WHERE tipo_movimiento = 2 AND cod_producto = 19 AND numero_recarga = 0";
						$Actualizar.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."' AND cod_subproducto = '".$Fila["cod_subproducto"]."'";						
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND unidades = '".$Fila["unidades"]."'";
						$Actualizar.= " AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
						mysqli_query($link, $Actualizar);		
						//echo $Actualizar."<br>";	
					}		
					//Crea la Hornada en la tabla Hornadas (Restos de Restos H.M.).
					$Insertar = "INSERT INTO sea_web.hornadas (cod_producto, cod_subproducto, hornada_ventana, unidades, peso_unidades,estado)";
					$Insertar.= " VALUES (19,30,".$HornadaHM.",".$UnidHM.",".$PesoHM.",0)";
					mysqli_query($link, $Insertar);
					//Agrega � Resta la diferencia a un registo, el con mas unidades en la produccion.
					$Consulta = "SELECT SUM(peso) AS peso_mov FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$HornadaHM;
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
					$Resp = mysqli_query($link, $Consulta);
					$Fila = mysqli_fetch_array($Resp);
					$Diferencia = $PesoHM - $Fila["peso_mov"];
					if ($Diferencia<>0)
					{					
						$Consulta = "SELECT * FROM sea_web.movimientos";
						$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$HornadaHM;
						$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";		 					
						$Resp = mysqli_query($link, $Consulta);
						if ($Fila = mysqli_fetch_array($Resp))
						{
							$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
							$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
							$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND numero_recarga = ".$Fila["numero_recarga"];
							$Actualizar.= " AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
							$Actualizar.= " AND campo1 = '".$Fila["campo1"]."' AND campo2 = '".$Fila["campo2"]."' AND unidades = ".$Fila["unidades"];
							$Actualizar.= " AND fecha_benef = '".$Fila["fecha_benef"]."' AND peso = '".$Fila["peso"]."'";
							mysqli_query($link, $Actualizar);						
						}
					}					
					$Parametros = $Parametros.$HornadaHM."-".$UnidHM."-".$PesoHM."/";	
					//echo "<br>PARAMETROS=".$parametros;		
					$LineaAux = "&activar=S&valores=".$Parametros;				
				}
			}
			//Obtiene los codigos que representan a los Anodos Ctes.
			$Parametros = "";			
			$Consulta = "SELECT valor_subclase1 AS valor ";
			$Consulta.= " FROM proyecto_modernizacion.sub_clase ";
			$Consulta.= " WHERE cod_clase = 2002";			
			$Resp = mysqli_query($link, $Consulta);						
			while ($Fila = mysqli_fetch_array($Resp))
			{
				//Obtiene las unidades de los Anodos Ctes y su peso.
				$Consulta = "SELECT IFNULL(SUM(unidades),0) AS unidadesmov, IFNULL(SUM(peso),0) AS peso ";
				$Consulta.= " FROM sea_web.movimientos ";
				$Consulta.= " WHERE tipo_movimiento = 2 AND cod_producto = 17";
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."' AND cod_subproducto = ".$Fila["valor"];
				$Consulta.= " AND numero_recarga = 0 AND fecha_movimiento = '".$FechaCarga."'";
				$Resp1 = mysqli_query($link, $Consulta);
				$Fila1 = mysqli_fetch_array($Resp1);						
				//Genera los parametros.
				$Parametros = $Parametros.$Fila["valor"]."-".$Fila1["unidadesmov"]."-".$Fila1["peso"]."/";								
			}		
			$Linea.="&Parametros=".$Parametros."&UnidCorr=".$UnidCorr."&PesoCorr=".$PesoCorr."&Factor=".$Factor;
			$Linea.= "&Grupo=".$Grupo."&Lado=".$Lado."&FechaCarga=".$FechaCarga;
			$Linea.= "&UnidHM=".$UnidHM."&PesoHM=".$PesoHM;
			header("location:sea_ing_prod_vent_auto.php?PesoAuto=checked&TipoPesaje=2&dia=".$dia."&mes=".$mes."&ano=".$ano."&Mensaje=".$Mensaje.$LineaAux.$Linea);			
			break;
		case "E_RestosAnodos":
			$Eliminar = "DELETE from sea_web.detalle_pesaje ";
			$Eliminar.= " where fecha = '".$FechaElim."'";
			$Eliminar.= " and cod_producto = '".$GrupoElim."'";
			$Eliminar.= " and cod_subproducto = '".$LadoElim."'";
			$Eliminar.= " and fecha_carga = '".$FechaCargaElim."'";
			$Eliminar.= " and tipo_pesaje = 'RA'";			
			mysqli_query($link, $Eliminar);	
			$Fecha = substr($FechaElim,0,10);
			$FechaCarga = $FechaCargaElim;
			$Grupo = $GrupoElim;
			$Lado = $LadoElim;
			//SI ELIMINA UN REGISTRO Y NO TODA LA PROD.
			$Consulta = "SELECT distinct estado from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
			$Consulta.= " and cod_producto = '".$Grupo."'";
			$Consulta.= " and cod_subproducto = '".$Lado."'";
			$Consulta.= " and fecha_carga = '".$FechaCarga."'";
			$Consulta.= " and tipo_pesaje = 'RA'";
			$Resp = mysqli_query($link, $Consulta);	
			//echo $Consulta;
			if ($Fila = mysqli_fetch_array($Resp))
			{
				if ($Fila["estado"] == "F") //YA FUE FINALIZADO EL GRUPO Y HAY QUE MODIFICAR LA HORNADA
				{		
					//SACA LAS UNIDADES CORRIENTES Y HOJAS MADRE
					//Obtiene los codigos que representan a los Anodos Ctes.					
					$UnidCorr = 0;
					$Consulta = "SELECT valor_subclase1 AS valor ";
					$Consulta.= " FROM proyecto_modernizacion.sub_clase ";
					$Consulta.= " WHERE cod_clase = 2002";			
					$Resp = mysqli_query($link, $Consulta);						
					while ($Fila = mysqli_fetch_array($Resp))
					{
						//Obtiene las unidades de los Anodos Ctes y su peso.
						$Consulta = "SELECT IFNULL(SUM(unidades),0) AS unidadesmov, IFNULL(SUM(peso),0) AS peso ";
						$Consulta.= " FROM sea_web.movimientos ";
						$Consulta.= " WHERE tipo_movimiento = 2 ";
						$Consulta.= " AND cod_producto = 17";
						$Consulta.= " AND campo2 = '".$Grupo."' ";
						$Consulta.= " AND campo1 = '".$Lado."' ";
						$Consulta.= " AND cod_subproducto = ".$Fila["valor"];			
						$Consulta.= " AND fecha_movimiento = '".$FechaCarga."'";
						$Resp1 = mysqli_query($link, $Consulta);
						$Fila1 = mysqli_fetch_array($Resp1);						
						//Genera los parametros.
						$UnidCorr = $UnidCorr + $Fila1["unidadesmov"];		
					}		
					//Saco el FACTOR asociado al grupo.		
					$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase ";
					$Consulta.= " WHERE cod_clase = 2004 AND cod_subclase = '".$Grupo."'";
					$Resp = mysqli_query($link, $Consulta);			
					$Fila = mysqli_fetch_array($Resp);			
					$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase ";
					$Consulta.= " WHERE cod_clase = 2003 AND cod_subclase = ".$Fila["valor_subclase1"];
					$Resp = mysqli_query($link, $Consulta);
					$Fila = mysqli_fetch_array($Resp);		
					$Factor = $Fila["valor_subclase1"];
					//CODIGOS H.M.
					$Consulta = "SELECT valor_subclase2 FROM proyecto_modernizacion.sub_clase ";
					$Consulta.= " WHERE cod_clase = 2002"; //Colunma de H.M.
					$Resp = mysqli_query($link, $Consulta);					
					$ValoresHM = "";
					while ($Fila = mysqli_fetch_array($Resp))
					{
						$ValoresHM = $ValoresHM.$Fila["valor_subclase2"].","; 
					}
					$ValoresHM = substr($ValoresHM,0,strlen($ValoresHM)-1);					
					//Obtiene la hornada y las unidades de los Anodos Restos H.M.
					$UnidHM = 0;
					$Consulta = "SELECT IFNULL(SUM(unidades),0) AS unidadesmov, IFNULL(SUM(peso),0) AS peso ";
					$Consulta.= " FROM sea_web.movimientos ";
					$Consulta.= " WHERE tipo_movimiento = 2 ";
					$Consulta.= " AND cod_producto = 19";
					$Consulta.= " AND cod_subproducto in (".$ValoresHM.") ";
					$Consulta.= " AND campo2 = '".$Grupo."' ";
					$Consulta.= " AND campo1 = '".$Lado."'";
					$Consulta.= " AND fecha_movimiento = '".$FechaCarga."'";	
					//echo $Consulta;		
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Resp))
					{
						$UnidHM = $Fila["unidadesmov"];
					}								
					//SE RECALCULA lA HORNADA (= QUE UN MODIFICAR)
					//CALCULA EL PESO PRODUCCION
					$Consulta = "select sum(peso_total) as peso_prod from sea_web.detalle_pesaje ";
					$Consulta.= " where tipo_pesaje = 'RA'";
					$Consulta.= " and cod_producto = '".$Grupo."'";
					$Consulta.= " and cod_subproducto = '".$Lado."'";
					$Consulta.= " and fecha_carga = '".$FechaCarga."'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))				
						$PesoProduccion = $Fila["peso_prod"];								
					if ($UnidCorr == 0)
					{
						$PesoCorr = 0;	
						$PesoHM = round($PesoProduccion);	
					}	
					else 
					{
						if ($UnidHM == 0)
						{		
							$PesoHM = 0;
							$PesoCorr = round($PesoProduccion);	
						}
						else 
						{
							$PesoCorr = round($PesoProduccion * ((100-$Factor)/100));
							$PesoHM = round($PesoProduccion - $PesoCorr);
						}
					}
					//MODIFICA LAS HORNADAS QUE YA FUERON CREADAS													
					$PromCtte = 0;
					$PromHM = 0;				
					if ($UnidCorr != 0)
						$PromCtte = number_format($PesoCorr / $UnidCorr, 3 ,".", ""); 
					if ($UnidHM != 0)
						$PromHM = number_format($PesoHM / $UnidHM, 3 ,".", "");
					//echo "UNID CORR=".$UnidCorr." UNID HM=".$UnidHM."<br> ";
					//echo "PROM CTTE=".$PromCtte." PROM HM=".$PromHM." PESO PROD=".$PesoProduccion."<br>";
					//Actualiza los pesos y fecha_movimiento en los movimientos de produccion.
					$Consulta = "SELECT * ";
					$Consulta.= " FROM sea_web.movimientos ";
					$Consulta.= " WHERE tipo_movimiento = 3 AND cod_producto = 19";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
					$Consulta.= " AND fecha_movimiento = '".$Fecha."'";		
					$Resp = mysqli_query($link, $Consulta);						
					while ($Fila = mysqli_fetch_array($Resp))
					{
						if ($Fila["cod_subproducto"] != 30)
						{
							$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PromCtte."), fecha_movimiento = '".$Fecha."'";
							$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
							$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
							$Actualizar.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
							mysqli_query($link, $Actualizar);							
						}
						else 
						{
							$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PromHM."), fecha_movimiento = '".$Fecha."'";
							$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
							$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";				
							$Actualizar.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";				
							mysqli_query($link, $Actualizar);			
						}
					}
					//Agrega � Resta la diferencia a un registo, el con mas unidades en la produccion.
					$Consulta = "SELECT SUM(peso) AS peso_mov, fecha_benef FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND cod_subproducto <> 30";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
					$Consulta.= " GROUP BY fecha_benef";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Resp))
					{
						$Diferencia = $PesoCorr - $Fila["peso_mov"];					
						$Consulta = "SELECT * FROM sea_web.movimientos";
						$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' and fecha_benef = '".$Fila["fecha_benef"]."'";
						$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."' AND cod_subproducto <> 30";
						$Consulta.= " ORDER BY peso DESC";
						$Resp1 = mysqli_query($link, $Consulta);
						if ($Fila1 = mysqli_fetch_array($Resp1))
						{
							$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
							$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila1["cod_subproducto"];
							$Actualizar.= " AND hornada = ".$Fila1["hornada"]." AND numero_recarga = ".$Fila1["numero_recarga"];
							$Actualizar.= " AND fecha_movimiento = '".$Fila1["fecha_movimiento"]."'";
							$Actualizar.= " AND campo1 = '".$Fila1["campo1"]."' AND campo2 = '".$Fila1["campo2"]."' AND unidades = ".$Fila1["unidades"];
							$Actualizar.= " AND fecha_benef = '".$Fila1["fecha_benef"]."' AND peso = '".$Fila1["peso"]."'";
							mysqli_query($link, $Actualizar);						
						}					
					}
					//Para Resto de Resto.
					$Consulta = "SELECT SUM(peso) AS peso_mov, hornada FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND cod_subproducto = 30";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
					$Consulta.= " GROUP BY hornada";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Resp))
					{
						$Diferencia = $PesoHM - $Fila["peso_mov"];					
						$Consulta = "SELECT * FROM sea_web.movimientos";
						$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$Fila["hornada"];
						$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";		 					
						$Resp1 = mysqli_query($link, $Consulta);
						if ($Fila1 = mysqli_fetch_array($Resp1))
						{
							$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
							$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila1["cod_subproducto"];
							$Actualizar.= " AND hornada = ".$Fila1["hornada"]." AND numero_recarga = ".$Fila1["numero_recarga"];
							$Actualizar.= " AND fecha_movimiento = '".$Fila1["fecha_movimiento"]."'";
							$Actualizar.= " AND campo1 = '".$Fila1["campo1"]."' AND campo2 = '".$Fila1["campo2"]."' AND unidades = ".$Fila1["unidades"];
							$Actualizar.= " AND fecha_benef = '".$Fila1["fecha_benef"]."' AND peso = '".$Fila1["peso"]."'";						
							mysqli_query($link, $Actualizar);
						}					
					}		
					//Actualiza los pesos y fecha_benef en los movimientos de traspaso.
					$Consulta = "SELECT * ";
					$Consulta.= " FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 19";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
					$Consulta.= " AND fecha_benef = '".$Fecha."'";		
					$Resp = mysqli_query($link, $Consulta);				
					while ($Fila = mysqli_fetch_array($Resp))
					{
						if ($Fila["cod_subproducto"] != 30)
						{		
							$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PromCtte."), fecha_benef = '".$Fecha."'";
							$Actualizar.= " WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
							$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
							$Actualizar.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";				
							mysqli_query($link, $Actualizar);
						}
						else
						{
							$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PromHM."), fecha_benef = '".$Fecha."'";
							$Actualizar.= " WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
							$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
							$Actualizar.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";				
							mysqli_query($link, $Actualizar);			
						}
					}
					//Agrega � Resta la diferencia a un registo, el con mas unidades en los traspasos.
					$Consulta = "SELECT SUM(peso) AS peso_mov, hornada FROM sea_web.movimientos ";
					$Consulta.= " WHERE tipo_movimiento = 4 AND fecha_benef = '".$Fecha."' AND cod_subproducto <> 30 ";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
					$Consulta.= " group by hornada ";
					$Resp = mysqli_query($link, $Consulta);				
					if ($Fila = mysqli_fetch_array($Resp))
					{
						$Diferencia = $PesoCorr - $Fila["peso_mov"];					
						$Consulta = "SELECT * FROM sea_web.movimientos";
						$Consulta.= " WHERE tipo_movimiento = 4 AND fecha_benef = '".$Fecha."' AND hornada = ".$Fila["hornada"];
						$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";		 
						$Consulta.= " ORDER BY unidades DESC";
						$Consulta.= " LIMIT 0,1";
						$Resp1 = mysqli_query($link, $Consulta);
						if ($Fila1 = mysqli_fetch_array($Resp1))
						{
							$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
							$Actualizar.= " WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$Fila1["cod_subproducto"];
							$Actualizar.= " AND hornada = ".$Fila1["hornada"]." AND numero_recarga = ".$Fila1["numero_recarga"];
							$Actualizar.= " AND fecha_movimiento = '".$Fila1["fecha_movimiento"]."'";
							$Actualizar.= " AND campo1 = '".$Fila1["campo1"]."' AND campo2 = '".$Fila1["campo2"]."' AND unidades = ".$Fila1["unidades"];
							$Actualizar.= " AND fecha_benef = '".$Fila1["fecha_benef"]."' AND peso = '".$Fila1["peso"]."'";
							mysqli_query($link, $Actualizar);						
						}					
					}
					//Para Resto de Resto.
					$Consulta = "SELECT SUM(peso) AS peso_mov, hornada FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND cod_subproducto = 30";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
					$Consulta.= " group by hornada ";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Resp))
					{
						$Diferencia = $PesoHM - $Fila["peso_mov"];					
						$Consulta = "SELECT * FROM sea_web.movimientos";
						$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$Fila["hornada"];
						$Consulta.= " AND campo2 = '".Grupo."' AND campo1 = '".$Lado."'";		 
						$Consulta.= " ORDER BY unidades DESC";					
						$Resp1 = mysqli_query($link, $Consulta);
						if ($Fila1 = mysqli_fetch_array($Resp1))
						{
							$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
							$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila1["cod_subproducto"];
							$Actualizar.= " AND hornada = ".$Fila1["hornada"]." AND numero_recarga = ".$Fila1["numero_recarga"];
							$Actualizar.= " AND fecha_movimiento = '".$Fila1["fecha_movimiento"]."'";
							$Actualizar.= " AND campo1 = '".$Fila1["campo1"]."' AND campo2 = '".$Fila1["campo2"]."' AND unidades = ".$Fila1["unidades"];
							$Actualizar.= " AND fecha_benef = '".$Fila1["fecha_benef"]."' AND peso = '".$Fila1["peso"]."'";
							mysqli_query($link, $Actualizar);						
						}					
					}		
					//Actualiza unidades y peso en la tabla hornada.
					$Consulta = "SELECT cod_subproducto, hornada, SUM(unidades) AS unidades, SUM(peso) AS peso";
					$Consulta.= " FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
					$Consulta.= " AND fecha_movimiento = '".$Fecha."'";
					$Consulta.= " GROUP BY cod_subproducto, hornada";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						$Actualizar = "UPDATE sea_web.hornadas SET unidades = ".$Fila["unidades"].", peso_unidades = ".$Fila["peso"]; 
						$Actualizar.= " WHERE cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada_ventana = ".$Fila["hornada"];
						mysqli_query($link, $Actualizar);
					}												
				}
			}
			else
			{
				//SE ELIMINA TODA LA PRODUCCION	POR QUE NO QUEDA NADA EN PESAJE	
				//Borrar en la tabla Hornadas.
				$Consulta = "SELECT DISTINCT cod_producto, cod_subproducto, hornada";
				$Consulta.= " FROM sea_web.movimientos ";
				$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' ";
				$Consulta.= " AND campo2 =  '".$Grupo."' AND campo1 = '".$Lado."' ";
				$Consulta.= " AND fecha_benef = '".$FechaCarga."'";
				$Resp1 = mysqli_query($link, $Consulta);
				while ($Fila1 = mysqli_fetch_array($Resp1))
				{
					$Eliminar = "DELETE FROM sea_web.hornadas";
					$Eliminar.= " WHERE cod_producto = ".$Fila1["cod_producto"];
					$Eliminar.= " AND cod_subproducto = ".$Fila1["cod_subproducto"]." ";
					$Eliminar.= " AND hornada_ventana = ".$Fila1["hornada"];
					mysqli_query($link, $Eliminar);
				}		
				//Actualiza Movimientos de Benefio.
				$Actualizar = "UPDATE sea_web.movimientos ";
				$Actualizar.= " SET numero_recarga = 0";
				$Actualizar.= " WHERE tipo_movimiento = 2 AND fecha_movimiento = '".$FechaCarga."' ";
				$Actualizar.= " AND campo2 = '".$Grupo."'";
				$Actualizar.= " AND campo1 = '".$Lado."' AND numero_recarga = 1";
				mysqli_query($link, $Actualizar);
				//Elimina Movimientos de Produccion.
				$Eliminar = "DELETE FROM sea_web.movimientos";
				$Eliminar.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' ";
				$Eliminar.= " AND campo2 =  '".$Grupo."'";
				$Eliminar.= " AND campo1 = '".$Lado."' AND fecha_benef = '".$FechaCarga."'";
				mysqli_query($link, $Eliminar);
				//Elimina Movimientos de Traspaso.
				$Eliminar = "DELETE FROM sea_web.movimientos";
				$Eliminar.= " WHERE tipo_movimiento = 4 AND fecha_benef = '".$Fecha."'";
				$Eliminar.= " AND campo2 = '".$Grupo."'";	
				$Eliminar.= " AND campo1 = '".$Lado."'";
				mysqli_query($link, $Eliminar);		
			}
			header("location:sea_ing_prod_vent_auto_restos_ctte_det2.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&GrupoLado=".str_pad($GrupoElim,2,"0",STR_PAD_LEFT)."-".strtoupper($LadoElim));
			break;
		case "M_RestosAnodos":
			$HoraAux=date('G');
			$MinAux=date('i');
			$SegAux=date('s');
			$Hora = $HoraAux.":".$MinAux.":".$SegAux;
			$Fecha = $ano."-".$mes."-".$dia;
			$PesoNeto = $PesoBruto - $TotalTara;									
			$Consulta = "select * from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$FechaG."'";
			$Consulta.= " and tipo_pesaje = 'RA'";
			$Consulta.= " and cod_producto = '".$Grupo."'";
			$Consulta.= " and cod_subproducto = '".$Lado."'";
			$Consulta.= " and fecha_carga = '".$FechaCarga."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{				
				//ACTUALIZA DATOS				
				$Actualizar = "UPDATE sea_web.`detalle_pesaje` SET ";
				$Actualizar.= " horno= '".$NumCubas."'";
				$Actualizar.= " , num_carro = '".$NumCarro."'";
				$Actualizar.= " , num_rack = '".$NumRack."'";
				$Actualizar.= " , peso_total = '".$PesoNeto."'";
				$Actualizar.= " , bascula = '".$IpPc."' ";
				$Actualizar.= " where fecha = '".$FechaG."'";
				$Actualizar.= " and tipo_pesaje = 'RA'";
				$Actualizar.= " and cod_producto = '".$Grupo."'";
				$Actualizar.= " and cod_subproducto = '".$Lado."'";			
				$Actualizar.= " and fecha_carga = '".$FechaCarga."'";					
				mysqli_query($link, $Actualizar);
			}
			else
			{								
				//$Mensaje = "NO se encuentra la La Pesada del Grupo";
				//header("Location:sea_ing_prod_vent_auto.php?TipoPesaje=2&Mensaje=".$Mensaje."&dia=".$dia."&mes=".$mes."&ano=".$ano);
				//break;
				//INSERTA DATOS CUANDO EL DATO NO SE ENCUENTRA
				$Insertar = "INSERT INTO sea_web.`detalle_pesaje` (`fecha`, `cod_producto`,`cod_subproducto`,`tipo_pesaje`, `horno`, `rueda`, `hornada`, ";
				$Insertar.= " `num_carro`, `num_rack`, `unidades`, `peso`, `peso_total`, `estado`, `promedio`, `fecha_carga`, `bascula`) ";
				$Insertar.= " VALUES ('".$Fecha." ".$Hora."', '".$Grupo."', '".$Lado."', 'RA', '".$NumCubas."', '0', '0', ";
				$Insertar.= " '".$NumCarro."', '".$NumRack."', '0', '0', '".$PesoNeto."', 'P', '', '".$FechaCarga."', '".$IpPc."')";
				mysqli_query($link, $Insertar);	
			}
			//OTRAS OPCIONES
			if ($NuevoCarro == "S") //INSERTA NUEVO CARRO
			{
				$Insertar = "insert into sea_web.taras(tipo_tara, numero, peso, fecha_pesaje) VALUES";
				$Insertar.= " ('C','".intval($NumCarro)."','".str_replace(",",".",$PesoCarro)."','".$fecha."')";
				mysqli_query($link, $Insertar);
			}
			if ($NuevoRack == "S") //INSERTA NUEVO RACK
			{
				$Insertar = "insert into sea_web.taras(tipo_tara, numero, peso, fecha_pesaje) VALUES";
				$Insertar.= " ('R','".intval($NumRack)."','".str_replace(",",".",$PesoRack)."','".$fecha."')";
				mysqli_query($link, $Insertar);
			}					
			if ($ChkFin == "S")//FINALIZA GRUPO
			{				
				//ACTUALIZA CAMPO DE FINALIZADA
				$Actualizar = "UPDATE sea_web.detalle_pesaje SET "; 
				$Actualizar.= " estado = 'F'";
				$Actualizar.= " where cod_producto = '".$Grupo."'";
				$Actualizar.= " and cod_subproducto = '".$Lado."'";
				$Actualizar.= " and fecha_carga = '".$FechaCarga."'";
				$Actualizar.= " and tipo_pesaje = 'RA'";	
				mysqli_query($link, $Actualizar);
				//CALCULA EL PESO PRODUCCION
				$Consulta = "select sum(peso_total) as peso_prod from sea_web.detalle_pesaje ";
				$Consulta.= " where tipo_pesaje = 'RA'";
				$Consulta.= " and cod_producto = '".$Grupo."'";
				$Consulta.= " and cod_subproducto = '".$Lado."'";
				$Consulta.= " and fecha_carga = '".$FechaCarga."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Respuesta))				
					$PesoProduccion = $Fila["peso_prod"];								
				if ($UnidCorr == 0)
				{
					$PesoCorr = 0;	
					$PesoHM = round($PesoProduccion);	
				}	
				else 
				{
					if ($UnidHM == 0)
					{		
						$PesoHM = 0;
						$PesoCorr = round($PesoProduccion);	
					}
					else 
					{
						$PesoCorr = round($PesoProduccion * ((100-$Factor)/100));
						$PesoHM = round($PesoProduccion - $PesoCorr);
					}
				}
				//MODIFICA LAS HORNADAS QUE YA FUERON CREADAS								
				$Fecha = $ano."-".$mes."-".$dia;
				$PromCtte = 0;
				$PromHM = 0;				
				if ($UnidCorr != 0)
					$PromCtte = number_format($PesoCorr / $UnidCorr, 3 ,".", ""); 
				if ($UnidHM != 0)
					$PromHM = number_format($PesoHM / $UnidHM, 3 ,".", ""); 					
				//Actualiza los pesos y fecha_movimiento en los movimientos de produccion.
				$Consulta = "SELECT * ";
				$Consulta.= " FROM sea_web.movimientos ";
				$Consulta.= " WHERE tipo_movimiento = 3 AND cod_producto = 19";
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
				$Consulta.= " AND fecha_movimiento = '".$Fecha."'";		
				$Resp = mysqli_query($link, $Consulta);						
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Fila["cod_subproducto"] != 30)
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PromCtte."), fecha_movimiento = '".$Fecha."'";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
						$Actualizar.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
						mysqli_query($link, $Actualizar);							
					}
					else 
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PromHM."), fecha_movimiento = '".$Fecha."'";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";				
						$Actualizar.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";				
						mysqli_query($link, $Actualizar);			
					}
				}
				//Agrega � Resta la diferencia a un registo, el con mas unidades en la produccion.
				$Consulta = "SELECT SUM(peso) AS peso_mov, fecha_benef FROM sea_web.movimientos";
				$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND cod_subproducto <> 30";
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
				$Consulta.= " GROUP BY fecha_benef";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					$Diferencia = $PesoCorr - $Fila["peso_mov"];					
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' and fecha_benef = '".$Fila["fecha_benef"]."'";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."' AND cod_subproducto <> 30";
					$Consulta.= " ORDER BY peso DESC";
					$Resp1 = mysqli_query($link, $Consulta);
					if ($Fila1 = mysqli_fetch_array($Resp1))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila1["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila1["hornada"]." AND numero_recarga = ".$Fila1["numero_recarga"];
						$Actualizar.= " AND fecha_movimiento = '".$Fila1["fecha_movimiento"]."'";
						$Actualizar.= " AND campo1 = '".$Fila1["campo1"]."' AND campo2 = '".$Fila1["campo2"]."' AND unidades = ".$Fila1["unidades"];
						$Actualizar.= " AND fecha_benef = '".$Fila1["fecha_benef"]."' AND peso = '".$Fila1["peso"]."'";
						mysqli_query($link, $Actualizar);						
					}					
				}
				//Para Resto de Resto.
				$Consulta = "SELECT SUM(peso) AS peso_mov, hornada FROM sea_web.movimientos";
				$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND cod_subproducto = 30";
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
				$Consulta.= " GROUP BY hornada";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					$Diferencia = $PesoHM - $Fila["peso_mov"];					
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$Fila["hornada"];
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";		 					
					$Resp1 = mysqli_query($link, $Consulta);
					if ($Fila1 = mysqli_fetch_array($Resp1))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila1["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila1["hornada"]." AND numero_recarga = ".$Fila1["numero_recarga"];
						$Actualizar.= " AND fecha_movimiento = '".$Fila1["fecha_movimiento"]."'";
						$Actualizar.= " AND campo1 = '".$Fila1["campo1"]."' AND campo2 = '".$Fila1["campo2"]."' AND unidades = ".$Fila1["unidades"];
						$Actualizar.= " AND fecha_benef = '".$Fila1["fecha_benef"]."' AND peso = '".$Fila1["peso"]."'";						
						mysqli_query($link, $Actualizar);						
					}					
				}		
				//Actualiza los pesos y fecha_benef en los movimientos de traspaso.
				$Consulta = "SELECT * ";
				$Consulta.= " FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 19";
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
				$Consulta.= " AND fecha_benef = '".$Fecha."'";		
				$Resp = mysqli_query($link, $Consulta);				
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Fila["cod_subproducto"] != 30)
					{		
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PromCtte."), fecha_benef = '".$Fecha."'";
						$Actualizar.= " WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
						$Actualizar.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";				
						mysqli_query($link, $Actualizar);
					}
					else
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PromHM."), fecha_benef = '".$Fecha."'";
						$Actualizar.= " WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
						$Actualizar.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";				
						mysqli_query($link, $Actualizar);			
					}
				}
				//Agrega � Resta la diferencia a un registo, el con mas unidades en los traspasos.
				$Consulta = "SELECT SUM(peso) AS peso_mov, hornada FROM sea_web.movimientos ";
				$Consulta.= " WHERE tipo_movimiento = 4 AND fecha_benef = '".$Fecha."' AND cod_subproducto <> 30 ";
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
				$Consulta.= " group by hornada ";
				$Resp = mysqli_query($link, $Consulta);				
				if ($Fila = mysqli_fetch_array($Resp))
				{
					$Diferencia = $PesoCorr - $Fila["peso_mov"];					
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 4 AND fecha_benef = '".$Fecha."' AND hornada = ".$Fila["hornada"];
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";		 
					$Consulta.= " ORDER BY unidades DESC";
					$Consulta.= " LIMIT 0,1";
					$Resp1 = mysqli_query($link, $Consulta);
					if ($Fila1 = mysqli_fetch_array($Resp1))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
						$Actualizar.= " WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$Fila1["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila1["hornada"]." AND numero_recarga = ".$Fila1["numero_recarga"];
						$Actualizar.= " AND fecha_movimiento = '".$Fila1["fecha_movimiento"]."'";
						$Actualizar.= " AND campo1 = '".$Fila1["campo1"]."' AND campo2 = '".$Fila1["campo2"]."' AND unidades = ".$Fila1["unidades"];
						$Actualizar.= " AND fecha_benef = '".$Fila1["fecha_benef"]."' AND peso = '".$Fila1["peso"]."'";
						mysqli_query($link, $Actualizar);						
					}					
				}
				//Para Resto de Resto.
				$Consulta = "SELECT SUM(peso) AS peso_mov, hornada FROM sea_web.movimientos";
				$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND cod_subproducto = 30";
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
				$Consulta.= " group by hornada ";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					$Diferencia = $PesoHM - $Fila["peso_mov"];					
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$Fila["hornada"];
					$Consulta.= " AND campo2 = '".Grupo."' AND campo1 = '".$Lado."'";		 
					$Consulta.= " ORDER BY unidades DESC";					
					$Resp1 = mysqli_query($link, $Consulta);
					if ($Fila1 = mysqli_fetch_array($Resp1))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila1["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila1["hornada"]." AND numero_recarga = ".$Fila1["numero_recarga"];
						$Actualizar.= " AND fecha_movimiento = '".$Fila1["fecha_movimiento"]."'";
						$Actualizar.= " AND campo1 = '".$Fila1["campo1"]."' AND campo2 = '".$Fila1["campo2"]."' AND unidades = ".$Fila1["unidades"];
						$Actualizar.= " AND fecha_benef = '".$Fila1["fecha_benef"]."' AND peso = '".$Fila1["peso"]."'";
						mysqli_query($link, $Actualizar);						
					}					
				}		
				//Actualiza unidades y peso en la tabla hornada.
				$Consulta = "SELECT cod_subproducto, hornada, SUM(unidades) AS unidades, SUM(peso) AS peso";
				$Consulta.= " FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19";
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Lado."'";
				$Consulta.= " AND fecha_movimiento = '".$Fecha."'";
				$Consulta.= " GROUP BY cod_subproducto, hornada";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Actualizar = "UPDATE sea_web.hornadas SET unidades = ".$Fila["unidades"].", peso_unidades = ".$Fila["peso"]; 
					$Actualizar.= " WHERE cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
					$Actualizar.= " AND hornada_ventana = ".$Fila["hornada"];
					mysqli_query($link, $Actualizar);
				}												
			}
			header("location:sea_ing_prod_vent_auto.php?PesoAuto=checked&TipoPesaje=2&dia=".$dia."&mes=".$mes."&ano=".$ano);						
			break;
	//****************************************************************************************//
	//****************PRODUCCION ANODOS CORRIENTES Y HOJAS MADRE******************************//
	//****************************************************************************************//		
		case "G_Cuba_RestosHM": //GRABA CUBA
			$FechaHora = $FechaProduccion." ".date("H:i:s");
			$Dia = substr($FechaProduccion,8,2);
			$Mes = substr($FechaProduccion,5,2);
			$Ano = substr($FechaProduccion,0,4);
			$Fecha = $FechaProduccion;
			$Grupo = $GrupoProd;
			//BUSCA FECHA_CARGA, UNIDADES, PESO DEL GRUPO CUBA INGRESADOS
			//Buscar los productos H.M.		
			$Consulta = "SELECT valor_subclase2 FROM proyecto_modernizacion.sub_clase ";
			$Consulta.= " WHERE cod_clase = 2002"; //Colunma de H.M.	
			$Resp = mysqli_query($link, $Consulta);
			$ValoresHM = "";
			while ($Fila = mysqli_fetch_array($Resp))
			{
				$ValoresHM = $ValoresHM.$Fila["valor_subclase2"].","; 
			}
			$ValoresHM = substr($ValoresHM,0,strlen($ValoresHM)-1);								
			$Consulta = "SELECT campo1, MIN(fecha_movimiento) AS fecha_movimiento, cod_subproducto ";
			$Consulta.= " FROM sea_web.movimientos ";
			$Consulta.= " WHERE tipo_movimiento = 2 AND cod_producto = 17";
			$Consulta.= " AND cod_subproducto in (".$ValoresHM.") ";
			$Consulta.= " AND numero_recarga = 0 ";
			$Consulta.= " AND campo1 = '".$Cuba."' ";
			$Consulta.= " AND campo2 = '".$GrupoProd."' ";
			$Consulta.= " GROUP BY campo1";
			$Resp = mysqli_query($link, $Consulta);	
			$Parametros = "";
			while ($Fila = mysqli_fetch_array($Resp))
			{		
				$Consulta = "SELECT SUM(unidades) AS unidadesmov, SUM(peso) AS peso FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17";
				$Consulta.= " AND cod_subproducto = ".$Fila["cod_subproducto"]." AND numero_recarga = 0 AND campo2 = '".$GrupoProd."'";
				$Consulta.= " AND campo1 = '".$Cuba."' AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
				$Resp2 = mysqli_query($link, $Consulta);
				$Fila2 = mysqli_fetch_array($Resp2);				
				$Unidades = $Fila2["unidadesmov"];
				$Peso = $Fila2["peso"];
				$FechaCarga = $Fila["fecha_movimiento"];		
			}
			//RESCATA HORNADA CREADA EN LA PRODUCCION SI LA UBIERA
			$Consulta = "select distinct hornada ";
			$Consulta.= " from sea_web.detalle_pesaje ";
			$Consulta.= " where tipo_pesaje = 'RHM'";
			$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
			$Consulta.= " and cod_producto = '".$Grupo."'";
			$Consulta.= " and estado='C'";
			$Consulta.= " and hornada<>'' and hornada<>'0'";
			$Resp2 = mysqli_query($link, $Consulta);
			$Fila2 = mysqli_fetch_array($Resp2);
			$hornada = isset($Fila2["hornada"])?$Fila2["hornada"]:"";
			if ($hornada!="" && !is_null($hornada) && $hornada!="0")
				$Hornada = $Fila2["hornada"];
			else
				$Hornada = 0;									
			$Insertar = "INSERT INTO sea_web.`detalle_pesaje` (`cod_producto`, `cod_subproducto`, ";
			$Insertar.= " `fecha`, `tipo_pesaje`, `horno`, `rueda`, `hornada`, `num_carro`, `num_rack`, ";
			$Insertar.= " `unidades`, `peso`, `peso_total`, `estado`, `promedio`, `fecha_carga`, `bascula`) VALUES (";
			$Insertar.= " '".$GrupoProd."', '".$Cuba."', '".$FechaHora."', 'RHM', '0', '0', '".$Hornada."', '0', '0', '".$Unidades."', '".$Peso."', '0', 'C', '0', '".$FechaCarga."', '".$IpPc."')";
			mysqli_query($link, $Insertar);
			//CONSULTA ESTADO DEL GRUPO.
			$Consulta = "select distinct estado from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
			$Consulta.= " and cod_producto = '".$Grupo."'";
			$Consulta.= " and tipo_pesaje = 'RHM'";
			$Consulta.= " and estado <> 'C'";			
			$Resp = mysqli_query($link, $Consulta);	
			if ($Fila = mysqli_fetch_array($Resp))
			{
				if ($Fila["estado"] == "F") //YA FUE FINALIZADO EL GRUPO Y HAY QUE MODIFICAR LA HORNADA Y LA CUBA
				{	
					//ACTUALIZA CAMPO DE FINALIZADA
					$Actualizar = "UPDATE sea_web.detalle_pesaje SET "; 
					$Actualizar.= " estado = 'F'";
					$Actualizar.= " where cod_producto = '".$Grupo."'";
					$Actualizar.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
					$Actualizar.= " and tipo_pesaje = 'RHM'";
					$Actualizar.= " and estado <> 'C'";
					mysqli_query($link, $Actualizar);
					//FINALIZAR HORNADA Graba datos a tablas principales													
					//CALCULA EL PESO PRODUCCION
					$Consulta = "select sum(peso_total) as peso_prod from sea_web.detalle_pesaje ";
					$Consulta.= " where tipo_pesaje = 'RHM'";
					$Consulta.= " and cod_producto = '".$Grupo."'";
					$Consulta.= " and estado <> 'C'"; //NO LAS CUBAS
					$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))				
						$PesoProduccion = $Fila["peso_prod"];		
					//CALCULA EL PESO Y UNIDADES CARGADAS
					$Consulta = "select hornada, sum(unidades) as unid_carga, sum(peso) as peso_carga ";
					$Consulta.= " from sea_web.detalle_pesaje ";
					$Consulta.= " where tipo_pesaje = 'RHM'";
					$Consulta.= " and cod_producto = '".$Grupo."'";
					$Consulta.= " and estado = 'C'"; //SOLO CUBAS
					$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
					$Consulta.= " group by cod_producto ";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))
					{				
						$PesoCarga = $Fila["peso_carga"];	
						$PesoUnid = $Fila["unid_carga"];						
					}
					//PESO PROMEDIO
					if ($PesoProduccion>0 && $PesoUnid>0)
						$PesoPromedio = ($PesoProduccion / $PesoUnid); //peso produccion por unidad.															
					else	$PesoPromedio = 0;																						
					//Busca los movimientos para la cuba involucrada.
					$Consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17";
					$Consulta.= " AND numero_recarga = 0 AND campo1 = '".$Cuba."' AND campo2 = '".$Grupo."'";
					$Consulta.= " AND fecha_movimiento = '".$FechaCarga."'";
					//echo $Consulta."<br>";
					$Resp2 = mysqli_query($link, $Consulta);
					while ($Fila2 = mysqli_fetch_array($Resp2))
					{	
						//Busca el flujo Asociado al producto y proceso.					
						$Consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
						$Consulta.= " WHERE cod_proceso = 3 AND cod_producto = 19";
						$Consulta.= " AND cod_subproducto = ".$Fila2["cod_subproducto"];
						$Resp3 = mysqli_query($link, $Consulta);
						if ($Fila3 = mysqli_fetch_array($Resp3))
							$Flujo = $Fila3["flujo"];
						else 
							$Flujo = 0;													
						$Insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
						$Insertar.= " VALUES (3,19,".$Fila2["cod_subproducto"].",".$Hornada.",".$Fila2["hornada"].",'".$Fecha."'";
						$Insertar.= ",'".$Fila2["campo1"]."','".$Fila2["campo2"]."',".$Fila2["unidades"].",".$Flujo.",'".$Fila2["fecha_movimiento"]."',".($Fila2["unidades"] * $PesoPromedio).",'".$fecha." ".$Hora."')";
						//echo $Insertar."<br>";
						mysqli_query($link, $Insertar);						
						//Actualiza Movimiento.
						$Actualizar = "UPDATE sea_web.movimientos SET numero_recarga = 1";
						$Actualizar.= " WHERE tipo_movimiento = 2 AND cod_producto = 17 AND cod_subproducto = ".$Fila2["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila2["hornada"]." AND numero_recarga = 0 AND fecha_movimiento = '".$Fila2["fecha_movimiento"]."'";
						$Actualizar.= " AND campo1 = '".$Fila2["campo1"]."' AND campo2 = '".$Fila2["campo2"]."' AND unidades = ".$Fila2["unidades"];
						$Actualizar.= " AND peso = ".$Fila2["peso"]." AND flujo = ".$Fila2["flujo"];
						mysqli_query($link, $Actualizar); 
					}	
					//Actualiza los pesos de la produccion.		
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = '".$Hornada."'";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";
					$Resp = mysqli_query($link, $Consulta);				
					while ($Fila = mysqli_fetch_array($Resp))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = ROUND(unidades * ".$PesoPromedio."), fecha_movimiento = '".$Fecha."'";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND numero_recarga = ".$Fila["numero_recarga"];
						$Actualizar.= " AND campo1 = ".$Fila["campo1"]." AND campo2 = ".$Fila["campo2"]." AND unidades = ".$Fila["unidades"];
						mysqli_query($link, $Actualizar);			
					}
					//Agrega la diferencia a un registo, con mas unidades en la produccion.
					$Consulta = "SELECT SUM(peso) AS peso_mov FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$Hornada;
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";		 
					$Resp = mysqli_query($link, $Consulta);
					$Fila = mysqli_fetch_array($Resp);
					$Diferencia = $PesoProduccion - $Fila["peso_mov"];				
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$Hornada;
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";		 
					$Consulta.= " ORDER BY unidades DESC";
					$Consulta.= " LIMIT 0,1";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Resp))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND numero_recarga = ".$Fila["numero_recarga"];
						$Actualizar.= " AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
						$Actualizar.= " AND campo1 = '".$Fila["campo1"]."' AND campo2 = '".$Fila["campo2"]."' AND unidades = ".$Fila["unidades"];
						$Actualizar.= " AND fecha_benef = '".$Fila["fecha_benef"]."' AND peso = '".$Fila["peso"]."'";
						mysqli_query($link, $Actualizar);						
					}
					//Actualiza la hornada.
					$Actualizar = "UPDATE sea_web.hornadas SET unidades = ".$PesoUnid.", peso_unidades = ".$PesoProduccion;
					$Actualizar.= " WHERE hornada_ventana = ".$Hornada;
					mysqli_query($link, $Actualizar);				
					//Actualiza los pesos de los beneficios ya realizados y traspaso.
					$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PesoPromedio.")";
					$Actualizar.= " WHERE tipo_movimiento IN (2,4) AND cod_producto = 19 AND hornada = '".$Hornada."'";
					mysqli_query($link, $Actualizar);						
					//Cambia la fecha_benef de los traspasos.
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 4 AND fecha_benef= '".$Fecha."' AND hornada = '".$Hornada."'";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET fecha_benef = '".$Fecha."'";
						$Actualizar.= " WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND campo1 = ".$Fila["campo1"]." AND campo2 = ".$Fila["campo2"]." AND unidades = ".$Fila["unidades"];
						mysqli_query($link, $Actualizar);
					}					
				}//FIN ESTADO DE FINALIZADO
			}//FIN CONSULTA ESTADO GRUPO
			header("location:sea_ing_prod_vent_auto_restos_hm_cubas.php?GrupoProd=".$GrupoProd."&DiaProd=".$Dia."&MesProd=".$Mes."&AnoProd=".$Ano."&TipoPesaje=2");
			break;
		case "E_Cuba_RestosHM": //ELIMINA CUBA
			$Eliminar = "delete from sea_web.detalle_pesaje ";
			$Eliminar.= " where fecha = '".$FechaHoraElim."'";
			$Eliminar.= " and cod_producto = '".$GrupoElim."'";
			$Eliminar.= " and cod_subproducto = '".$CubaElim."'";
			$Eliminar.= " and tipo_pesaje = 'RHM'";	
			$Eliminar.= " and estado = 'C'";
			mysqli_query($link, $Eliminar);
			$Dia = substr($FechaHoraElim,8,2);
			$Mes = substr($FechaHoraElim,5,2);
			$Ano = substr($FechaHoraElim,0,4);
			$Fecha = substr($FechaHoraElim,0,10);
			$Grupo = $GrupoElim;
			$Cuba = $CubaElim;					
			//CONSULTA ESTADO DEL GRUPO.
			$Consulta = "select distinct estado from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
			$Consulta.= " and cod_producto = '".$Grupo."'";
			$Consulta.= " and tipo_pesaje = 'RHM'";
			$Consulta.= " and estado <> 'C'";
			$Resp = mysqli_query($link, $Consulta);	
			if ($Fila = mysqli_fetch_array($Resp))
			{
				if ($Fila["estado"] == "F") //YA FUE FINALIZADO EL GRUPO Y HAY QUE MODIFICAR LA HORNADA
				{
					$Consulta = "select distinct hornada from sea_web.detalle_pesaje ";
					$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
					$Consulta.= " and cod_producto = '".$Grupo."'";
					$Consulta.= " and tipo_pesaje = 'RHM'";
					$Consulta.= " and estado = 'C'";
					$Resp2 = mysqli_query($link, $Consulta);	
					$Hornada = "";
					if ($Fila2 = mysqli_fetch_array($Resp2))
					{
						$Hornada = $Fila2["hornada"];
					}
					//Actualiza Movimientos de Benefio.
					$Actualizar = "UPDATE sea_web.movimientos SET numero_recarga = 0";
					$Actualizar.= " WHERE tipo_movimiento = 2 AND campo2='".$Grupo."' and campo1='".$Cuba."'";
					$Actualizar.= " AND fecha_movimiento = '".$FechaCarga."'";
					$Actualizar.= " AND cod_producto = 17 AND numero_recarga = 1";
					mysqli_query($link, $Actualizar);
					//Elimina Movimientos de Produccion.
					$Eliminar = "DELETE FROM sea_web.movimientos ";
					$Eliminar.= " WHERE tipo_movimiento = 3 AND hornada = '".$Hornada."'";
					$Eliminar.= " AND fecha_movimiento = '".$Fecha."'";
					$Eliminar.= " AND fecha_benef = '".$FechaCarga."'";
					$Eliminar.= " AND campo2 = '".$Grupo."' AND campo1 = '".$Cuba."' ";
					mysqli_query($link, $Eliminar);
					//HACE UNA MODIFICACION EN LA HORNADA Y LOS MOVIMIENTOS DE ELLA
					//CALCULA EL PESO PRODUCCION
					$Consulta = "select sum(peso_total) as peso_prod from sea_web.detalle_pesaje ";
					$Consulta.= " where tipo_pesaje = 'RHM'";
					$Consulta.= " and cod_producto = '".$Grupo."'";
					$Consulta.= " and estado <> 'C'"; //NO LAS CUBAS
					$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))				
						$PesoProduccion = $Fila["peso_prod"];		
					//CALCULA EL PESO Y UNIDADES CARGADAS
					$Consulta = "select hornada, sum(unidades) as unid_carga, sum(peso) as peso_carga ";
					$Consulta.= " from sea_web.detalle_pesaje ";
					$Consulta.= " where tipo_pesaje = 'RHM'";
					$Consulta.= " and cod_producto = '".$Grupo."'";
					$Consulta.= " and estado = 'C'"; //SOLO CUBAS
					$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
					$Consulta.= " group by cod_producto ";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))
					{				
						$PesoCarga = $Fila["peso_carga"];	
						$PesoUnid = $Fila["unid_carga"];
						$Hornada = 	$Fila["hornada"]; //Hornada Creada para el Grupo de Restos que se Produce
					}
					if ($PesoProduccion>0 && $PesoUnid>0)
						$PesoPromedio = ($PesoProduccion / $PesoUnid); //peso produccion por unidad.															
					else	$PesoPromedio = 0;
					//Actualiza los pesos de la produccion.		
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = '".$Hornada."'";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";
					//echo $Consulta."<br>";
					$Resp = mysqli_query($link, $Consulta);				
					while ($Fila = mysqli_fetch_array($Resp))
					{	
						$Actualizar = "UPDATE sea_web.movimientos SET peso = ROUND(unidades * ".$PesoPromedio."), fecha_movimiento = '".$Fecha."'";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND numero_recarga = ".$Fila["numero_recarga"];
						$Actualizar.= " AND campo1 = ".$Fila["campo1"]." AND campo2 = ".$Fila["campo2"]." AND unidades = ".$Fila["unidades"];
						mysqli_query($link, $Actualizar);	
						//echo $Actualizar."<br>";		
					}				
					//Agrega la diferencia a un registo, con mas unidades en la produccion.
					$Consulta = "SELECT SUM(peso) AS peso_mov FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = '".$Hornada."'";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";		 
					$Resp = mysqli_query($link, $Consulta);
					$Fila = mysqli_fetch_array($Resp);
					$Diferencia = $PesoProduccion - $Fila["peso_mov"];				
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = '".$Hornada."'";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";		 
					$Consulta.= " ORDER BY unidades DESC";
					$Consulta.= " LIMIT 0,1";
					//echo $Consulta."<br>";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Resp))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND numero_recarga = ".$Fila["numero_recarga"];
						$Actualizar.= " AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
						$Actualizar.= " AND campo1 = '".$Fila["campo1"]."' AND campo2 = '".$Fila["campo2"]."' AND unidades = ".$Fila["unidades"];
						$Actualizar.= " AND fecha_benef = '".$Fila["fecha_benef"]."' AND peso = '".$Fila["peso"]."'";
						//echo $actualizar."<br>";
						mysqli_query($link, $Actualizar);						
					}
					//Actualiza la hornada.
					$Actualizar = "UPDATE sea_web.hornadas SET unidades = ".$PesoUnid.", peso_unidades = ".$PesoProduccion;
					$Actualizar.= " WHERE hornada_ventana = '".$Hornada."'";
					mysqli_query($link, $Actualizar);
					//echo $Actualizar."<br>";				
					//Actualiza los pesos de los beneficios ya realizados y traspaso.
					$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PesoPromedio.")";
					$Actualizar.= " WHERE tipo_movimiento IN (2,4) AND cod_producto = 19 AND hornada = '".$Hornada."'";
					mysqli_query($link, $Actualizar);			
					//echo $Actualizar."<br>";				
					//Cambia la fecha_benef de los traspasos.
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 4 AND fecha_benef= '".$Fecha."' AND hornada = '".$Hornada."'";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET fecha_benef = '".$Fecha."'";
						$Actualizar.= " WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND campo1 = ".$Fila["campo1"]." AND campo2 = ".$Fila["campo2"]." AND unidades = ".$Fila["unidades"];
						mysqli_query($link, $Actualizar);
						//echo $Actualizar."<br>";	
					}								
				}//FIN ACTUALIZA HORNADA
			}				
			header("location:sea_ing_prod_vent_auto_restos_hm_cubas.php?GrupoProd=".$GrupoProd."&DiaProd=".$Dia."&MesProd=".$Mes."&AnoProd=".$Ano);
			break;
		case "G_RestosHM":
			$Fecha = $ano."-".$mes."-".$dia;
			$PesoNeto = $PesoBruto - $TotalTara;						
			$Consulta = "select * from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$Fecha." ".$Hora."'";
			$Consulta.= " and tipo_pesaje = 'RHM'";
			$Consulta.= " and cod_producto = '".$Grupo."'";
			$Consulta.= " and cod_subproducto = '".$Corr."'";
			$Respuesta = mysqli_query($link, $Consulta);
			//echo $Consulta;
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				//ACTUALIZA DATOS				
				$Actualizar = "UPDATE sea_web.`detalle_pesaje` SET ";
				$Actualizar.= " horno= '".$NumCubas."'";
				$Actualizar.= " , num_carro = '".$NumCarro."'";
				$Actualizar.= " , num_rack = '".$NumRack."'";
				$Actualizar.= " , peso_total = '".$PesoNeto."'";
				$Actualizar.= " , bascula = '".$IpPc."'";
				$Actualizar.= " where fecha = '".$Fecha." ".$Hora."'";
				$Actualizar.= " and tipo_pesaje = 'RHM'";
				$Actualizar.= " and cod_producto = '".$Grupo."'";
				$Actualizar.= " and cod_subproducto = '".$Corr."'";						
				mysqli_query($link, $Actualizar);
			}
			else
			{			
				//INSERTA DATOS
				$Insertar = "INSERT INTO sea_web.`detalle_pesaje` (`fecha`, `cod_producto`,`cod_subproducto`,`tipo_pesaje`, `horno`, `rueda`, `hornada`, ";
				$Insertar.= " `num_carro`, `num_rack`, `unidades`, `peso`, `peso_total`, `estado`, `promedio`, `fecha_carga`, `bascula`) ";
				$Insertar.= " VALUES ('".$fecha." ".$Hora."', '".$Grupo."', '".$Corr."', 'RHM', '".$NumCubas."', '', '', ";
				$Insertar.= " '".$NumCarro."', '".$NumRack."', '', '', '".$PesoNeto."', 'P', '', '', '".$IpPc."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar;	
			}
			//OTRAS OPCIONES
			if ($NuevoCarro == "S") //INSERTA NUEVO CARRO
			{
				$Insertar = "insert into sea_web.taras(tipo_tara, numero, peso, fecha_pesaje) VALUES";
				$Insertar.= " ('C','".intval($NumCarro)."','".str_replace(",",".",$PesoCarro)."','".$fecha."')";
				mysqli_query($link, $Insertar);
			}
			if ($NuevoRack == "S") //INSERTA NUEVO RACK
			{
				$Insertar = "insert into sea_web.taras(tipo_tara, numero, peso, fecha_pesaje) VALUES";
				$Insertar.= " ('R','".intval($NumRack)."','".str_replace(",",".",$PesoRack)."','".$fecha."')";
				mysqli_query($link, $Insertar);
			}					
			if ($ChkFin == "S") //GENERA HORNADAS	
			{				
				//ACTUALIZA CAMPO DE FINALIZADA
				$Actualizar = "UPDATE sea_web.detalle_pesaje SET "; 
				$Actualizar.= " estado = 'F'";
				$Actualizar.= " where cod_producto = '".$Grupo."'";
				$Actualizar.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
				$Actualizar.= " and tipo_pesaje = 'RHM'";
				$Actualizar.= " and estado <> 'C'"; //NO LAS CUBAS
				mysqli_query($link, $Actualizar);
				//FINALIZAR HORNADA Graba datos a tablas principales									
				//Se le concatena a la hornada para que sea unica en la tabla.
				if (strlen($mes) == 1)
					$mes = "0".$mes;
				$ano_mes = $ano.$mes;
				//CALCULA EL PESO PRODUCCION
				$Consulta = "select sum(peso_total) as peso_prod from sea_web.detalle_pesaje ";
				$Consulta.= " where tipo_pesaje = 'RHM'";
				$Consulta.= " and cod_producto = '".$Grupo."'";
				$Consulta.= " and estado <> 'C'"; //NO LAS CUBAS
				$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Respuesta))				
					$PesoProduccion = $Fila["peso_prod"];		
				//CALCULA EL PESO Y UNIDADES CARGADAS
				$Consulta = "select sum(unidades) as unid_carga, sum(peso) as peso_carga from sea_web.detalle_pesaje ";
				$Consulta.= " where tipo_pesaje = 'RHM'";
				$Consulta.= " and cod_producto = '".$Grupo."'";
				$Consulta.= " and estado = 'C'"; //SOLO CUBAS
				$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Respuesta))
				{				
					$PesoCarga = $Fila["peso_carga"];	
					$PesoUnid = $Fila["unid_carga"];															
				}				
				$PesoPromedio = ($PesoProduccion / $PesoUnid); //peso produccion por unidad.		
				//Busca la Hornada de los diferentes productos H.M.		
				$Hornadas = array();
				$Consulta = "SELECT valor_subclase2 FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002"; //Colunma de H.M.
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					$Consulta = "SELECT MAX(case when length(substring(hornada_ventana,7,6))=4 then concat('00',substring(hornada_ventana,7,6)) else substring(hornada_ventana,7,6) end) AS hornada_max";
					$Consulta.= " FROM sea_web.hornadas";
					$Consulta.= " WHERE cod_producto = 19 AND cod_subproducto = ".$Fila["valor_subclase2"];			
					$Resp2 = mysqli_query($link, $Consulta);
					$Fila2 = mysqli_fetch_array($Resp2);
					if (is_null($Fila2["hornada_max"]))
					{
						$Consulta = "SELECT valor_subclase1 FROM proyecto_modernizacion.sub_clase ";
						$Consulta.= " WHERE cod_clase = 2007 AND cod_subclase = ".$Fila["valor_subclase2"];					
						$Resp3 = mysqli_query($link, $Consulta);						
						$Fila3 = mysqli_fetch_array($Resp3);
						$Hornadas[$Fila["valor_subclase2"]] = $ano_mes.$Fila3["valor_subclase1"];
					}
					else 
						$Hornadas[$Fila["valor_subclase2"]] = $ano_mes.$Fila2["hornada_max"] + 1;					
				}								
				//Arreglo de totales por hornada.
				$Totales = array();
				reset($Hornadas);
				while(list($c,$v) = each($Hornadas))
				{
					$Totales[$c][0] = 0; //unidades.
					$Totales[$c][1] = 0; //peso.
				}									
				$Consulta = "select cod_producto, cod_subproducto, unidades, peso, fecha_carga from sea_web.detalle_pesaje ";
				$Consulta.= " where tipo_pesaje = 'RHM'";
				$Consulta.= " and cod_producto = '".$Grupo."'";
				$Consulta.= " and estado = 'C'"; //SOLO CUBAS
				$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
				$Consulta.= " ORDER by cod_producto, cod_subproducto";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{				
					//Busca los movimientos para la cuba involucrada.
					$Consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17";
					$Consulta.= " AND numero_recarga = 0 AND campo1 = '".$Fila["cod_subproducto"]."' AND campo2 = '".$Grupo."'";
					$Consulta.= " AND fecha_movimiento = '".$Fila["fecha_carga"]."'";
					//echo $Consulta."<br>";
					$Resp2 = mysqli_query($link, $Consulta);
					while ($Fila2 = mysqli_fetch_array($Resp2))
					{	
						//Busca el flujo Asociado al producto y proceso.					
						$Consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
						$Consulta.= " WHERE cod_proceso = 3 AND cod_producto = 19";
						$Consulta.= " AND cod_subproducto = ".$Fila2["cod_subproducto"];
						$Resp3 = mysqli_query($link, $Consulta);
						if ($Fila3 = mysqli_fetch_array($Resp3))
							$Flujo = $Fila3["flujo"];
						else 
							$Flujo = 0;													
						$Insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
						$Insertar.= " VALUES (3,19,".$Fila2["cod_subproducto"].",".$Hornadas[$Fila2["cod_subproducto"]].",".$Fila2["hornada"].",'".$Fecha."'";
						$Insertar.= ",'".$Fila2["campo1"]."','".$Fila2["campo2"]."',".$Fila2["unidades"].",".$Flujo.",'".$Fila2["fecha_movimiento"]."',".($Fila2["unidades"] * $PesoPromedio).",'".$fecha." ".$Hora."')";
						//echo $Insertar."<br>";
						mysqli_query($link, $Insertar);						
						//Actualiza Movimiento.
						$Actualizar = "UPDATE sea_web.movimientos SET numero_recarga = 1";
						$Actualizar.= " WHERE tipo_movimiento = 2 AND cod_producto = 17 AND cod_subproducto = ".$Fila2["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila2["hornada"]." AND numero_recarga = 0 AND fecha_movimiento = '".$Fila2["fecha_movimiento"]."'";
						$Actualizar.= " AND campo1 = '".$Fila2["campo1"]."' AND campo2 = '".$Fila2["campo2"]."' AND unidades = ".$Fila2["unidades"];
						$Actualizar.= " AND peso = ".$Fila2["peso"]." AND flujo = ".$Fila2["flujo"];
						mysqli_query($link, $Actualizar); 																			
						$Totales[$Fila2["cod_subproducto"]][0] = $Totales[$Fila2["cod_subproducto"]][0] + $Fila2["unidades"]; //unidades cargadas.
						$Totales[$Fila2["cod_subproducto"]][1] = $Totales[$Fila2["cod_subproducto"]][1] + $Fila2["peso"];    //peso carga.
					}														
				}		
				//Graba las hornadas en la tabla Hornadas.
				reset($Hornadas);
				while(list($c,$v) = each($Hornadas))
				{	
					if ($Totales[$c][0] != 0)
					{
						$Insertar = "INSERT INTO sea_web.hornadas (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades,estado)";
						$Insertar.= " VALUES (19,".$c.",".$v.",".$Totales[$c][0].",".$PesoProduccion.",0)";
						mysqli_query($link, $Insertar);
						//echo $Insertar."<br>";		
						//Actualiza el Campo Hornada de la Tabla de Detalle de Pesaje
						$Actualizar = "UPDATE sea_web.detalle_pesaje SET "; 
						$Actualizar.= " hornada = '".$v."'";
						$Actualizar.= " where cod_producto = '".$Grupo."'";
						$Actualizar.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
						$Actualizar.= " and tipo_pesaje = 'RHM'";
						$Actualizar.= " and estado = 'C'"; //NO LAS CUBAS
						mysqli_query($link, $Actualizar);				
						//Agrega la diferencia a un registo, con mas unidades en la produccion.
						$Consulta = "SELECT SUM(peso) AS peso_mov FROM sea_web.movimientos";
						$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = '".$v."'";
						$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";		 
						$Resp = mysqli_query($link, $Consulta);
						$Fila = mysqli_fetch_array($Resp);
						$Diferencia = $PesoProduccion - $Fila["peso_mov"];
						
						$Consulta = "SELECT * FROM sea_web.movimientos";
						$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = '".$v."'";
						$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";		 
						$Consulta.= " ORDER BY unidades DESC";
						$Consulta.= " LIMIT 0,1";
						//echo $Consulta."<br>";
						$Resp = mysqli_query($link, $Consulta);
						if ($Fila = mysqli_fetch_array($Resp))
						{
							$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
							$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
							$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND numero_recarga = ".$Fila["numero_recarga"];
							$Actualizar.= " AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
							$Actualizar.= " AND campo1 = '".$Fila["campo1"]."' AND campo2 = '".$Fila["campo2"]."' AND unidades = ".$Fila["unidades"];
							$Actualizar.= " AND fecha_benef = '".$Fila["fecha_benef"]."' AND peso = '".$Fila["peso"]."'";
							//echo $Actualizar."<br>";
							mysqli_query($link, $Actualizar);						
						}
					}
				}																				
			}
			header("location:sea_ing_prod_vent_auto.php?TipoPesaje=3&Grupo=".$Grupo."&dia=".$dia."&mes=".$mes."&ano=".$ano."&Mensaje=".$Mensaje.$LineaAux);			
			break;
		case "M_RestosHM":
			$Fecha = $ano."-".$mes."-".$dia;
			$PesoNeto = $PesoBruto - $TotalTara;						
			$Consulta = "select * from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha = '".$Fecha." ".$Hora."'";
			$Consulta.= " and tipo_pesaje = 'RHM'";
			$Consulta.= " and cod_producto = '".$Grupo."'";
			$Consulta.= " and cod_subproducto = '".$Corr."'";
			$Respuesta = mysqli_query($link, $Consulta);
			//echo $Consulta;
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				//ACTUALIZA DATOS				
				$Actualizar = "UPDATE sea_web.`detalle_pesaje` SET ";
				$Actualizar.= " horno= '".$NumCubas."'";
				$Actualizar.= " , num_carro = '".$NumCarro."'";
				$Actualizar.= " , num_rack = '".$NumRack."'";
				$Actualizar.= " , peso_total = '".$PesoNeto."'";
				$Actualizar.= " , bascula = '".$IpPc."'";
				$Actualizar.= " where fecha = '".$Fecha." ".$Hora."'";
				$Actualizar.= " and tipo_pesaje = 'RHM'";
				$Actualizar.= " and cod_producto = '".$Grupo."'";
				$Actualizar.= " and cod_subproducto = '".$Corr."'";						
				mysqli_query($link, $Actualizar);
			}
			else
			{			
				/*$Mensaje = "NO se encuentra la La Pesada del Grupo";
				header("Location:sea_ing_prod_vent_auto.php?TipoPesaje=2&Mensaje=".$Mensaje."&dia=".$dia."&mes=".$mes."&ano=".$ano);
				break;*/
				//INSERTA DATOS
				$Insertar = "INSERT INTO sea_web.`detalle_pesaje` (`fecha`, `cod_producto`,`cod_subproducto`,`tipo_pesaje`, `horno`, `rueda`, `hornada`, ";
				$Insertar.= " `num_carro`, `num_rack`, `unidades`, `peso`, `peso_total`, `estado`, `promedio`, `fecha_carga`, `bascula`) ";
				$Insertar.= " VALUES ('".$Fecha." ".$Hora."', '".$Grupo."', '".$Corr."', 'RHM', '".$NumCubas."', '', '', ";
				$Insertar.= " '".$NumCarro."', '".$NumRack."', '', '', '".$PesoNeto."', 'P', '', '', '".$IpPc."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar;	
				
			}
			//OTRAS OPCIONES
			if ($NuevoCarro == "S") //INSERTA NUEVO CARRO
			{
				$Insertar = "insert into sea_web.taras(tipo_tara, numero, peso, fecha_pesaje) VALUES";
				$Insertar.= " ('C','".intval($NumCarro)."','".str_replace(",",".",$PesoCarro)."','".$fecha."')";
				mysqli_query($link, $Insertar);
			}
			if ($NuevoRack == "S") //INSERTA NUEVO RACK
			{
				$Insertar = "insert into sea_web.taras(tipo_tara, numero, peso, fecha_pesaje) VALUES";
				$Insertar.= " ('R','".intval($NumRack)."','".str_replace(",",".",$PesoRack)."','".$fecha."')";
				mysqli_query($link, $Insertar);
			}			
			if ($ChkFin == "S") //GENERA HORNADAS	
			{				
				//ACTUALIZA CAMPO DE FINALIZADA
				$Actualizar = "UPDATE sea_web.detalle_pesaje SET "; 
				$Actualizar.= " estado = 'F'";
				$Actualizar.= " where cod_producto = '".$Grupo."'";
				$Actualizar.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
				$Actualizar.= " and tipo_pesaje = 'RHM'";
				$Actualizar.= " and estado <> 'C'";
				mysqli_query($link, $Actualizar);
				//FINALIZAR HORNADA Graba datos a tablas principales													
				//CALCULA EL PESO PRODUCCION
				$Consulta = "select sum(peso_total) as peso_prod from sea_web.detalle_pesaje ";
				$Consulta.= " where tipo_pesaje = 'RHM'";
				$Consulta.= " and cod_producto = '".$Grupo."'";
				$Consulta.= " and estado <> 'C'"; //NO LAS CUBAS
				$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Respuesta))				
					$PesoProduccion = $Fila["peso_prod"];		
				//CALCULA EL PESO Y UNIDADES CARGADAS
				$Consulta = "select hornada, sum(unidades) as unid_carga, sum(peso) as peso_carga ";
				$Consulta.= " from sea_web.detalle_pesaje ";
				$Consulta.= " where tipo_pesaje = 'RHM'";
				$Consulta.= " and cod_producto = '".$Grupo."'";
				$Consulta.= " and estado = 'C'"; //SOLO CUBAS
				$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
				$Consulta.= " group by cod_producto ";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Respuesta))
				{				
					$PesoCarga = $Fila["peso_carga"];	
					$PesoUnid = $Fila["unid_carga"];
					$Hornada = 	$Fila["hornada"]; //Hornada Creada para el Grupo de Restos que se Produce
				}
				if ($PesoProduccion>0 && $PesoUnid>0)
					$PesoPromedio = ($PesoProduccion / $PesoUnid); //peso produccion por unidad.															
				else	$PesoPromedio = 0;
				//Actualiza los pesos de la produccion.		
				$Consulta = "SELECT * FROM sea_web.movimientos";
				$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = '".$Hornada."'";
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";
				//echo $consulta."<br>";
				$Resp = mysqli_query($link, $Consulta);				
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Actualizar = "UPDATE sea_web.movimientos SET peso = ROUND(unidades * ".$PesoPromedio."), fecha_movimiento = '".$Fecha."'";
					$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
					$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND numero_recarga = ".$Fila["numero_recarga"];
					$Actualizar.= " AND campo1 = ".$Fila["campo1"]." AND campo2 = ".$Fila["campo2"]." AND unidades = ".$Fila["unidades"];
					mysqli_query($link, $Actualizar);			
				}
				//Agrega la diferencia a un registo, con mas unidades en la produccion.
				$Consulta = "SELECT SUM(peso) AS peso_mov FROM sea_web.movimientos";
				$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$Hornada;
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";		 
				$Resp = mysqli_query($link, $Consulta);
				$Fila = mysqli_fetch_array($Resp);
				$Diferencia = $PesoProduccion - $Fila["peso_mov"];				
				$Consulta = "SELECT * FROM sea_web.movimientos";
				$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$Hornada;
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";		 
				$Consulta.= " ORDER BY unidades DESC";
				$Consulta.= " LIMIT 0,1";
				//echo $consulta."<br>";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
					$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
					$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND numero_recarga = ".$Fila["numero_recarga"];
					$Actualizar.= " AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
					$Actualizar.= " AND campo1 = '".$Fila["campo1"]."' AND campo2 = '".$Fila["campo2"]."' AND unidades = ".$Fila["unidades"];
					$Actualizar.= " AND fecha_benef = '".$Fila["fecha_benef"]."' AND peso = '".$Fila["peso"]."'";
					//echo $actualizar."<br>";
					mysqli_query($link, $Actualizar);						
				}
				//Actualiza la hornada.
				$Actualizar = "UPDATE sea_web.hornadas SET unidades = ".$PesoUnid.", peso_unidades = ".$PesoProduccion;
				$Actualizar.= " WHERE hornada_ventana = ".$Hornada;
				mysqli_query($link, $Actualizar);				
				//Actualiza los pesos de los beneficios ya realizados y traspaso.
				$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PesoPromedio.")";
				$Actualizar.= " WHERE tipo_movimiento IN (2,4) AND cod_producto = 19 AND hornada = ".$Hornada;
				mysqli_query($link, $Actualizar);						
				//Cambia la fecha_benef de los traspasos.
				$Consulta = "SELECT * FROM sea_web.movimientos";
				$Consulta.= " WHERE tipo_movimiento = 4 AND fecha_benef= '".$Fecha."' AND hornada = ".$Hornada;
				$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Actualizar = "UPDATE sea_web.movimientos SET fecha_benef = '".$Fecha."'";
					$Actualizar.= " WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
					$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND campo1 = ".$Fila["campo1"]." AND campo2 = ".$Fila["campo2"]." AND unidades = ".$Fila["unidades"];
					mysqli_query($link, $Actualizar);
				}								
			}
			header("location:sea_ing_prod_vent_auto.php?TipoPesaje=3&Grupo=".$Grupo."&dia=".$dia."&mes=".$mes."&ano=".$ano."&Mensaje=".$Mensaje.$LineaAux);			
			break;
		case "E_RestosHM":
			$Eliminar = "delete from sea_web.detalle_pesaje ";
			$Eliminar.= " where fecha = '".$FechaHoraElim."'";
			$Eliminar.= " and cod_producto = '".$GrupoElim."'";
			$Eliminar.= " and cod_subproducto = '".$CorrElim."'";
			$Eliminar.= " and tipo_pesaje = 'RHM'";			
			//echo $Eliminar."<br>";
			mysqli_query($link, $Eliminar);	
			$Fecha = substr($FechaHoraElim,0,10);
			$Grupo = $GrupoElim;
			$Corr = $CorrElim;
			//SI ELIMINA UN REGISTRO Y NO TODA LA PROD.
			$Consulta = "select distinct estado from sea_web.detalle_pesaje ";
			$Consulta.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
			$Consulta.= " and cod_producto = '".$Grupo."'";
			$Consulta.= " and tipo_pesaje = 'RHM'";
			$Consulta.= " and estado <> 'C'";
			//echo $Consulta."<br>";
			$Resp = mysqli_query($link, $Consulta);	
			if ($Fila = mysqli_fetch_array($Resp))
			{
				if ($Fila["estado"] == "F") //YA FUE FINALIZADO EL GRUPO Y HAY QUE MODIFICAR LA HORNADA
				{
					//HACE UNA MODIFICACION EN LA HORNADA Y LOS MOVIMIENTOS DE ELLA
					//CALCULA EL PESO PRODUCCION
					$Consulta = "select sum(peso_total) as peso_prod from sea_web.detalle_pesaje ";
					$Consulta.= " where tipo_pesaje = 'RHM'";
					$Consulta.= " and cod_producto = '".$Grupo."'";
					$Consulta.= " and estado <> 'C'"; //NO LAS CUBAS
					$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))				
						$PesoProduccion = $Fila["peso_prod"];		
					//CALCULA EL PESO Y UNIDADES CARGADAS
					$Consulta = "select hornada, sum(unidades) as unid_carga, sum(peso) as peso_carga ";
					$Consulta.= " from sea_web.detalle_pesaje ";
					$Consulta.= " where tipo_pesaje = 'RHM'";
					$Consulta.= " and cod_producto = '".$Grupo."'";
					$Consulta.= " and estado = 'C'"; //SOLO CUBAS
					$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
					$Consulta.= " group by cod_producto ";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))
					{				
						$PesoCarga = $Fila["peso_carga"];	
						$PesoUnid = $Fila["unid_carga"];
						$Hornada = 	$Fila["hornada"]; //Hornada Creada para el Grupo de Restos que se Produce
					}
					if ($PesoProduccion>0 && $PesoUnid>0)
						$PesoPromedio = ($PesoProduccion / $PesoUnid); //peso produccion por unidad.															
					else	$PesoPromedio = 0;
					//Actualiza los pesos de la produccion.		
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = '".$Hornada."'";
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";
					//echo $consulta."<br>";
					$Resp = mysqli_query($link, $Consulta);				
					while ($Fila = mysqli_fetch_array($Resp))
					{	
						$Actualizar = "UPDATE sea_web.movimientos SET peso = ROUND(unidades * ".$PesoPromedio."), fecha_movimiento = '".$Fecha."'";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND numero_recarga = ".$Fila["numero_recarga"];
						$Actualizar.= " AND campo1 = ".$Fila["campo1"]." AND campo2 = ".$Fila["campo2"]." AND unidades = ".$Fila["unidades"];
						mysqli_query($link, $Actualizar);			
					}				
					//Agrega la diferencia a un registo, con mas unidades en la produccion.
					$Consulta = "SELECT SUM(peso) AS peso_mov FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$Hornada;
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";		 
					$Resp = mysqli_query($link, $Consulta);
					$Fila = mysqli_fetch_array($Resp);
					$Diferencia = $PesoProduccion - $Fila["peso_mov"];				
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$Fecha."' AND hornada = ".$Hornada;
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";		 
					$Consulta.= " ORDER BY unidades DESC";
					$Consulta.= " LIMIT 0,1";
					//echo $consulta."<br>";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Resp))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$Diferencia.")";
						$Actualizar.= " WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND numero_recarga = ".$Fila["numero_recarga"];
						$Actualizar.= " AND fecha_movimiento = '".$Fila["fecha_movimiento"]."'";
						$Actualizar.= " AND campo1 = '".$Fila["campo1"]."' AND campo2 = '".$Fila["campo2"]."' AND unidades = ".$Fila["unidades"];
						$Actualizar.= " AND fecha_benef = '".$Fila["fecha_benef"]."' AND peso = '".$Fila["peso"]."'";
						//echo $actualizar."<br>";
						mysqli_query($link, $Actualizar);						
					}
					//Actualiza la hornada.
					$Actualizar = "UPDATE sea_web.hornadas SET unidades = ".$PesoUnid.", peso_unidades = ".$PesoProduccion;
					$Actualizar.= " WHERE hornada_ventana = ".$Hornada;
					mysqli_query($link, $Actualizar);				
					//Actualiza los pesos de los beneficios ya realizados y traspaso.
					$Actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$PesoPromedio.")";
					$Actualizar.= " WHERE tipo_movimiento IN (2,4) AND cod_producto = 19 AND hornada = ".$Hornada;
					mysqli_query($link, $Actualizar);						
					//Cambia la fecha_benef de los traspasos.
					$Consulta = "SELECT * FROM sea_web.movimientos";
					$Consulta.= " WHERE tipo_movimiento = 4 AND fecha_benef= '".$Fecha."' AND hornada = ".$Hornada;
					$Consulta.= " AND campo2 = '".$Grupo."' AND campo1 NOT IN ('T','M')";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						$Actualizar = "UPDATE sea_web.movimientos SET fecha_benef = '".$Fecha."'";
						$Actualizar.= " WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$Fila["cod_subproducto"];
						$Actualizar.= " AND hornada = ".$Fila["hornada"]." AND campo1 = ".$Fila["campo1"]." AND campo2 = ".$Fila["campo2"]." AND unidades = ".$Fila["unidades"];
						mysqli_query($link, $Actualizar);
					}								
				}//FIN ACTUALIZA HORNADA
			}
			else
			{		
				//RESCATO LA HORNADA QUE SE HABIA CREADO
				$Hornada = "";
				$Consulta = "select distinct hornada";
				$Consulta.= " from sea_web.detalle_pesaje ";
				$Consulta.= " where tipo_pesaje = 'RHM'";
				$Consulta.= " and fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
				$Consulta.= " and cod_producto = '".$Grupo."'";
				$Consulta.= " and estado = 'C'";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					$Hornada = $Fila["hornada"];
				}
				//BORRO TODO REGISTRO QUE QUEDE DEL GRUPO EN LA TABLA DETALLE PESAJE
				$Eliminar = "delete from sea_web.detalle_pesaje ";
				$Eliminar.= " where fecha between '".$Fecha." 00:00:00' and '".$Fecha." 23:59:59'";
				$Eliminar.= " and cod_producto = '".$Grupo."'";
				$Eliminar.= " and tipo_pesaje = 'RHM'";			
				mysqli_query($link, $Eliminar);	
				//Consulta las cubas que pertenece a esta produccion.
				$Consulta = "SELECT DISTINCT cod_subproducto, campo1, campo2, fecha_benef";
				$Consulta.= " FROM sea_web.movimientos";
				$Consulta.= " WHERE tipo_movimiento = 3 AND hornada = '".$Hornada."'";
				$Consulta.= " AND fecha_movimiento = '".$Fecha."' AND campo2 = '".$Grupo."'";				
				//echo $Consulta."<br>";				
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					//Actualiza Movimientos de Benefio.
					$Actualizar = "UPDATE sea_web.movimientos SET numero_recarga = 0";
					$Actualizar.= " WHERE tipo_movimiento = 2 AND campo2='".$Fila["campo2"]."' and campo1='".$Fila["campo1"]."'";
					$Actualizar.= " AND cod_subproducto = '".$Fila["cod_subproducto"]."' and fecha_movimiento = '".$Fila["fecha_benef"]."'";
					$Actualizar.= " AND cod_producto = 17 AND numero_recarga = 1";
					mysqli_query($link, $Actualizar);
					//echo $Actualizar."<br>";			
				}				
				//Elimina Movimientos de Produccion.
				$Eliminar = "DELETE FROM sea_web.movimientos ";
				$Eliminar.= " WHERE tipo_movimiento = 3 AND hornada = ".$Hornada;
				$Eliminar.= " AND fecha_movimiento = '".$Fecha."' AND campo2 = '".$Grupo."'";
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";
				//Elimina Movimientos de Traspaso.
				$Eliminar = "DELETE FROM sea_web.movimientos";
				$Eliminar.= " WHERE tipo_movimiento = 4 AND fecha_benef = '".$Fecha."'";
				$Eliminar.= " AND hornada = ".$Hornada." AND campo2 = '".$Grupo."'"; 
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";		
				//Elimina los Beneficios Realizados.
				$Eliminar = "DELETE FROM sea_web.movimientos";
				$Eliminar.= " WHERE tipo_movimiento = 2 AND cod_producto = 19 AND hornada = ".$Hornada;
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";		
				//Elimina ne la tabla Hornadas.
				$Eliminar = "DELETE FROM sea_web.hornadas";
				$Eliminar.= " WHERE cod_producto = 19 AND hornada_ventana = ".$Hornada;
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";		
			}
			header("location:sea_ing_prod_vent_auto_restos_hm_det2.php?Proceso=B&Grupo=-1&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);			
			break;
		case "G_PromAnodos":		
			//ELIMINA PROMEDIOS 
			$Eliminar = "DELETE from proyecto_modernizacion.sub_clase where cod_clase = '2013'";
			mysqli_query($link, $Eliminar);
			//GRABA PROMEDIO ANODOS CTTE
			$Insertar = "INSERT INTO proyecto_modernizacion.sub_clase ";
			$Insertar.= " (cod_clase, cod_subclase, nombre_subclase, valor_subclase1)";
			$Insertar.= " VALUES('2013', '1', 'Promedio Anodos Ctte', '".$PesoCtte."')";
			mysqli_query($link, $Insertar);
			//GRABA PROMEDIO ANODOS HM
			$Insertar = "INSERT INTO proyecto_modernizacion.sub_clase ";
			$Insertar.= " (cod_clase, cod_subclase, nombre_subclase, valor_subclase1)";
			$Insertar.= " VALUES('2013', '2', 'Promedio Anodos HM', '".$PesoHM."')";
			mysqli_query($link, $Insertar);
			header("location:sea_ing_prod_vent_auto_promedios.php");
			break;
}
	include("../principal/cerrar_sea_web.php"); 
?>