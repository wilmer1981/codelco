<?php
	include("../principal/conectar_principal.php");
	error_reporting(E_ALL ^ E_STRICT);
// to turn error reporting off 
error_reporting(0);
	$BasculaEntrada=1;
	$BasculaSalida=1;
	$RutOperador='1234-3';
	
	$OBSERVACION_REG="CARGA_MANUAL ".date('Y-m-d');
	$Consulta = "Select * from sipa_web.sipa_carga_puerto_ventana order by LOTE_VENTANA";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{ $Cont= $Cont+1;
		$CodProducto=0;
		$CodSubproducto=0;
		$Leyes="";
		$Impurezas="";
		$SA="0";
		$COD_CLASE=$Fila[COD_CLASE];
		if($COD_CLASE=="")
		{
			$COD_CLASE='O';
		}
			$CONJUNTO=$Fila[CONJUNTO];
		if($CONJUNTO=="")
		{
			$CONJUNTO='7005';
		}
		
		
		$RECARGO=1;
		$ULTIMO_REG='S';
		$FechaArray=explode(' ',$Fila["fecha"]);
	//	$FechaAux=explode('-',$FechaArray[0]);
		$FECHA=$FechaArray[0];
		$HoraEntrada=$FechaArray[1];
		$HoraSalida=$FechaArray[1];
		$ConsultaCal = "Select cod_producto,cod_subproducto,leyes,impurezas,nro_solicitud from cal_web.solicitud_analisis where id_muestra='".$Fila["lote_ventana"]."' and recargo=0";
		$RespCal = mysqli_query($link, $ConsultaCal);
		if ($FilaCal = mysqli_fetch_array($RespCal))
		{
			$CodProducto=$FilaCal["cod_producto"];
			$CodSubproducto=$FilaCal["cod_subproducto"];
			//$Leyes=""$FilaCal["leyes"];
			//$Impurezas=$FilaCal["impurezas"];
			$SA=$FilaCal["nro_solicitud"];
			$Update = "UPDATE sipa_web.sipa_carga_puerto_ventana set nro_solicitud='".$SA."' where id_muestra='".$Fila["lote_ventana"]."';";
			mysqli_query($link, $Update);
		}
		else
		{		
			echo"NO EXISTE SOLICITUD ANALISIS LOTE ".$Fila["lote_ventana"]."<br>";		
		}

		
		
		$ConsultaAGe = "Select recargo,fin_lote from age_web.detalle_lotes where lote='".$Fila["lote_ventana"]."' and peso_neto='".$Fila["peso_neto"]."'";
		$RespAge = mysqli_query($link, $ConsultaAGe);
		if ($FilaAge = mysqli_fetch_array($RespAge))
		{
			$RECARGO=$FilaAge["recargo"];
			$ULTIMO_REG=$FilaAge[fin_lote];
		}
		
		
		$ConsultaSipa = "Select MAX(correlativo)+1 as Correlativo_Sipa from sipa_web.recepciones ";
		$RespSipa = mysqli_query($link, $ConsultaSipa);
		if ($FilaSipa = mysqli_fetch_array($RespSipa))
		{
				$CORRELATIVO=$FilaSipa["correlativo_sipa"];
		}
		$Insertar="INSERT INTO sipa_web.RECEPCIONES(correlativo,lote,recargo,ult_registro,rut_operador,bascula_entrada,bascula_salida,fecha,hora_entrada,hora_salida,";
		$Insertar.="peso_bruto,peso_tara,peso_neto,rut_prv,cod_mina,cod_producto,cod_subproducto,cod_pta_maq,leyes,impurezas,guia_despacho,patente,cod_clase,conjunto,";
		$Insertar.="observacion,activo,estado,humedad,cod_grupo,sa_asignada,romana_entrada,romana_salida,tipo)VALUES";
		$Insertar.="(".$CORRELATIVO.",'".$Fila["lote_ventana"]."','".$RECARGO."','".$ULTIMO_REG."','".$RutOperador."',".$BasculaEntrada.",".$BasculaSalida.",'".$FECHA."','".$HoraEntrada."','".$HoraSalida."',";
		$Insertar.=$Fila[PESO_BRUTO].",".$Fila["peso_tara"].",".$Fila["peso_neto"].",'".$Fila[RUT_MINERA]."','".$Fila[COD_MINA]."','".$CodProducto."','".$CodSubproducto."',' ' ,'".$Leyes."','".$Impurezas."','".$Fila["guia"]."','".$Fila["patente"]."','".$COD_CLASE."','".$CONJUNTO."',";
		$Insertar.="'".$OBSERVACION_REG."','N','C','S','1','".$SA."','".$BasculaEntrada."','".$BasculaSalida."',' ')";
		echo $Cont." ".$Insertar."<br>";
		mysqli_query($link, $Insertar);
		echo "Result ".$result3."<br>";
		echo "******************************************<br><br>";
	}
	
	
	echo "<br><br>Fin Proceso";