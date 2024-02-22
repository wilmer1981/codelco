<?php 
	include("../principal/conectar_sea_web.php");

	$Procesa = $_REQUEST["Procesa"];
	$ano = $_REQUEST["ano"];
	$mes = $_REQUEST["mes"];
	$dia = $_REQUEST["dia"];
	$subproc = $_REQUEST["subproc"];
	$subprohm = $_REQUEST["subprohm"];
	$TxtHornada = $_REQUEST["TxtHornada"];
	$rechacp = $_REQUEST["rechacp"];
	$rechahp = $_REQUEST["rechahp"];
	$saldoc  = $_REQUEST["saldoc"];
	$saldoh  = $_REQUEST["saldoh"];


	$hora = date("h:i");
	if(strlen($mes)==1)
		$mes = "0".$mes;
	if(strlen($dia)==1)
		$dia = "0".$dia;
	$fecha  = $ano."-".$mes."-".$dia;
	$fecha2 = $ano."-".$mes."-".$dia." 23:50:50";
    
?>

<html>
<head>
<title>Sistema de Anodos</title>
<?php
	$tipo = 0;
	$Horno = substr($TxtHornada,6,1);
	if ($Horno==4)
	{
	 	$flujo_cor = 93;
	 	$flujo_esp = 99;
	 	$flujo_hm = 131;
	}
	if ($Horno==1 || $Horno==2)
	{
	 	$flujo_cor = 92;
	 	$flujo_esp = 95;
	 	$flujo_hm = 129;
	 }
	if ($Horno==5)
	{
	 	$flujo_cor = 142;
		$tipo = 1;
	}
	if ($Horno==6)
	{
	 	$flujo_cor = 277;
		$tipo = 1;
	}
	if ($Horno==7)
	{
	 	$flujo_cor = 137;
		$tipo= 1;
	}
	 
 if ($Procesa==9 && $tipo==0)
 {	 
 		$Promedio_c = 0;
		$Promedio_h = 0;
		$peso_c = 0;
		$peso_h= 0;
		$AnoC1 = substr($TxtHornada,0,4);
		$MesC1 = substr($TxtHornada,4,2);
		$MesC2 = $MesC1 + 1;
		$AnoC2 = $AnoC1;
		if ($MesC2==13)
		{
			$MesC2 = 01;
			$AnoC2 = $AnoC1 + 1;
		}
		
		$fechaC1 = $AnoC1."-".$MesC1."-01 08:00:00";
		$fechaC2 = $AnoC2."-".$MesC2."-01 07:59:00";
		if($mes!=$MesC1 || $ano!=$AnoC1)
		{
			$fecha = $AnoC1."-".$MesC1."-".$dia;
			$fecha2 = $fecha." 23:50:50";
		}
		if ($rechacp >0)
		{
	 		$Consulta ="Select peso_unidades as peso, unidades as unidades from sea_web.hornadas  where cod_producto = '17'";
			$Consulta.=" and hornada_ventana = '".$TxtHornada."' and cod_subproducto = '".$subproc."'";
			$Rsp = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Rsp))
			{
				$Promedio_c = ($Fila["peso"] * 1) / ( $Fila["unidades"] * 1);
				$peso_c = round($Promedio_c * $rechacp);
				$pesopas = 0;
				$unidadpas = 0;
				$consulta="SELECT * from sea_web.movimientos where hornada = '".$TxtHornada."' and cod_producto = '17' ";
				$consulta.=" and cod_subproducto = '".$subproc."'  and tipo_movimiento = '1' and sub_tipo_movim = 1 ";
				$consulta.=" and hora between '".$fechaC1."' and '".$fechaC2."'";
				$rsp1 = mysqli_query($link, $consulta);
				if ($Fila1 = mysqli_fetch_array($rsp1))
				{
					$pesopas = ($Fila1["peso"] * 1) - $peso_c;
					$unidadpas  = ($Fila1["unidades"] * 1) - $rechacp;
				}
				if ($pesopas >= 0)
				{
					$actualiza ="UPDATE sea_web.movimientos set peso = '".$pesopas."',unidades='".$unidadpas."'";
					$actualiza.=" where cod_producto = '17' and cod_subproducto = '".$subproc."' and hornada = '".$TxtHornada."'";
					$actualiza.=" and fecha_movimiento = '".$Fila1["fecha_movimiento"]."' and tipo_movimiento = '1' and sub_tipo_movim = 1";
					mysqli_query($link, $actualiza);
					
					$Inserta = "INSERT INTO sea_web.movimientos"; 
    				$Inserta.=" (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,";
					$Inserta.="campo1,campo2,fecha_benef,peso,estado,lote_ventana,peso_origen,zuncho,hora,sub_tipo_movim)";
    				$Inserta.=" VALUES (1,17,'".$subproc."','".$flujo_cor."','".$TxtHornada."','".$fecha."','".$rechacp."',0,'',";
					$Inserta.="'','1001-01-01','".$peso_c."',0,'',0,0,'".$fecha2."',4)";
	  				mysqli_query($link, $Inserta);
				}
			}										
		}
		if ($rechahp > 0)
		{	
			$pesopas = 0;
			$unidpas = 0;
			$Consulta ="Select peso_unidades as peso, unidades as unidades from sea_web.hornadas  where cod_producto = '17' and hornada_ventana = '".$TxtHornada."'";
			$Consulta.=" and cod_subproducto = '".$subprohm."'";
			$Rsp2 = mysqli_query($link, $Consulta);
			if ($Fila2=mysqli_fetch_array($Rsp2))
			{
				$promedio_h = ($Fila2["peso"] * 1) / ($Fila2["unidades"] * 1); 
				$peso_h = round($rechahp * $promedio_h);
				$consulta="SELECT * from sea_web.movimientos where hornada = '".$TxtHornada."' and cod_producto = '17' ";
				$consulta.=" and cod_subproducto = '".$subprohm."' and tipo_movimiento = '1' and sub_tipo_movim = 1";
				$consulta.=" and hora between '".$fechaC1."' and '".$fechaC2."'";
				$rsp3 = mysqli_query($link, $consulta);
				if ($Row = mysqli_fetch_array($rsp3))
				{
				
					$pesopas = $Row["peso"] - $peso_h;
					$unidpas = $Row["unidades"]  - $rechahp;
					if ($unidpas >=0)
					{						
						$Actualiza ="UPDATE sea_web.movimientos set unidades = '".$unidpas."', peso= '".$pesopas."' where ";
						$Actualiza.=" tipo_movimiento = '1' and cod_producto = '17' and cod_subproducto = '".$subprohm."'";
						$Actualiza.=" and hornada = '".$TxtHornada."' and fecha_movimiento = '".$Row["fecha_movimiento"]."'";
						$Actualiza.=" and sub_tipo_movim = 1";
						mysqli_query($link, $Actualiza);
		    			$Inserta = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,flujo,";
						$Inserta.=" hornada,fecha_movimiento,unidades,numero_recarga,campo1,campo2,fecha_benef,peso,estado,";
						$Inserta.=" lote_ventana,peso_origen,zuncho,hora,sub_tipo_movim)";
    					$Inserta.=" VALUES (1,17,'".$subprohm."','".$flujo_hm."','".$TxtHornada."','".$fecha."','".$rechahp."',";
						$Inserta.="0,'','','1001-01-01','".$peso_h."',0,'',0,0,'".$fecha2."',4)";
						mysqli_query($link, $Inserta);
					} 
				} 
			 }
			 $fechaHH = $fecha." 23:50:00";
			 $Consulta ="SELECT * from sea_web.inf_rechazos where fecha = '".$fecha."' ";
			 $resp1=mysqli_query($link, $Consulta);
			 if ($Linea=mysqli_fetch_array($resp1))
			 {
				$actualiza ="UPDATE sea_web.inf_rechazos set Fis_HMadres = Fis_HMadres + '".$rechahp."'";
				$actualiza.=" where fecha = '".$fecha."'";
				mysqli_query($link, $actualiza);
			}
			else
			{
				$insertar.="insert into sea_web.inf_rechazos (fecha,Fis_Vent,Quim_Vent,Calaf_vent,Ana_Vent,Fis_HMadres,";
				$insertar.="Quim_HMadres,Calaf_HMadres,Ana_HMadres,Fis_Teniente,Quim_Teniente,Calaf_Teniente,Ana_Teniente,";
				$insertar.="Fis_FHVL,Quim_FHVL,Calaf_FHVL,Ana_FHVL,Fis_Disputada,Quim_Disputada,Calaf_Disputada,Ana_Disputada,";
				$insertar.="Fis_Restos,Quim_Restos,Calaf_Restos,Ana_Restos,hora) values ('".$fecha."',0,0,0,0,'".$rechahp."',0,0,0,";
				$insertar.="0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'".$fechaHH."')";
				mysqli_query($link, $insertar);
			}	

		}
}	

if ($Procesa==9 && $tipo==1)
{	 
 		$Promedio_c = 0;
		$Promedio_h = 0;
		$peso_c = 0;
		$peso_h= 0;
		$AnoC1 = substr($TxtHornada,0,4);
		$MesC1 = substr($TxtHornada,4,2);
		$MesC2 = $MesC1 + 1;
		$AnoC2 = $AnoC1;
		if ($MesC2==13)
		{
			$MesC2 = 01;
			$AnoC2 = $AnoC1 + 1;
		}
		$fechaC1 = $AnoC1."-".$MesC1."-01 08:00:00";
		$fechaC2 = $AnoC2."-".$MesC2."-01 07:59:00";
		if($mes!=$MesC1 || $ano!=$AnoC1)
		{
			$fecha = $AnoC1."-".$MesC1."-".$dia;
			$fecha2 = $fecha." 23:50:50";
		}
		if ($rechacp >0)
		{
	 		$Consulta ="Select peso_unidades as peso, unidades as unidades from sea_web.hornadas  where cod_producto = '17'";
			$Consulta.=" and hornada_ventana = '".$TxtHornada."' and cod_subproducto = '".$subproc."'";
			$Rsp = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Rsp))
			{
				$Promedio_c = ($Fila["peso"] * 1) / ( $Fila["unidades"] * 1);
				$peso_c = round($Promedio_c * $rechacp);
				$pesopas =  $peso_c;
				$unidadpas = $rechacp;
				$control = 0;
				$consulta="SELECT * from sea_web.movimientos where hornada = '".$TxtHornada."' and cod_producto = '17' ";
				$consulta.=" and cod_subproducto = '".$subproc."'  and tipo_movimiento = '1' and sub_tipo_movim = 1 ";
				$consulta.=" and hora between '".$fechaC1."' and '".$fechaC2."'";
				$rsp1 = mysqli_query($link, $consulta);
				while($Fila1 = mysqli_fetch_array($rsp1))
				{
					$peso1=0;
					$unidad1=0;
					if($unidadpas > 0)
					{
						$actualiza="UPDATE sea_web.movimientos ";
						if($Fila1["unidades"] > $unidadpas)
						{
							$peso1 = ($Fila1["peso"] * 1) - $pesopas;
							$unidad1 = ($Fila1["unidades"] * 1) - $unidadpas;
							$actualiza.=" set peso = '".$peso1."',unidades='".$unidad1."'";
							$pesopas=0;$unidadpas=0;
						}
						else if($Fila1["unidades"]==$unidadpas)
						{
							$actualiza.=" set peso = 0, unidades=0";
							$pesopas=0;$unidadpas=0;
						}
						else if($Fila1["unidades"] < $unidadpas)
						{
							$unidadpas = $unidadpas - ($Fila1["unidades"] * 1);
							$pesopas   = $pesopas - ($Fila1["peso"] * 1);
							$actualiza.=" set peso=0, unidades=0";
						}
						$actualiza.=" where cod_producto = '17' and cod_subproducto = '".$subproc."' and hornada = '".$TxtHornada."'";
						$actualiza.=" and numero_recarga = '".$Fila1["numero_recarga"]."' and fecha_movimiento = '".$Fila1["fecha_movimiento"]."'";
						$actualiza.=" and tipo_movimiento = '1' and sub_tipo_movim = 1";
						mysqli_query($link, $actualiza);
					}
					if($control==0)
					{
						$Inserta = "INSERT INTO sea_web.movimientos"; 
    					$Inserta.=" (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,";
						$Inserta.="campo1,campo2,fecha_benef,peso,estado,lote_ventana,peso_origen,zuncho,hora,sub_tipo_movim)";
    					$Inserta.=" VALUES (1,17,'".$subproc."','".$flujo_cor."','".$TxtHornada."','".$fecha."','".$rechacp."',0,'',";
						$Inserta.="'','1001-01-01','".$peso_c."',0,'',0,0,'".$fecha2."',4)";
	 					mysqli_query($link, $Inserta);
						$control=1;
					}
				}
			}
										
		}
}
if ($rechac >0)
{	
	$fechaHH = $fecha." 23:50:00";
	$Consulta ="SELECT * from sea_web.inf_rechazos where fecha = '".$fecha."' ";
	$resp1=mysqli_query($link, $Consulta);
	if ($Linea=mysqli_fetch_array($resp1))
	{
		$actualiza ="UPDATE sea_web.inf_rechazos set ";
		if ($subproc=='1')
			$actualiza.="Fis_FHVL = Fis_FHVL + '".$rechacp."' where fecha = '".$fecha."' ";
		if ($subproc=='2')
			$actualiza.="Fis_Teniente = Fis_Teniente + '".$rechacp."' where fecha = '".$fecha."' ";
		if ($subproc=='3')
			$actualiza.="Fis_Disputada = Fis_Disputada + '".$rechacp."' where fecha = '".$fecha."' ";
		if ($subproc=='4')
			$actualiza.="Fis_Vent = Fis_Vent + '".$rechacp."' where fecha = '".$fecha."' ";
		mysqli_query($link, $actualiza);
	}
	else
	{
		$fhvl=0; $fvent =0; $ften=0; $fdis=0;
		if ($subproc=='1')
			$fhvl = $rechacp;
		if ($subproc=='2')
			$ften = $rechacp;
		if ($subproc=='3')
			$fdis = $rechacp;
		if ($subproc=='4')
			$fvent = $rechacp;
		$insertar.="insert into sea_web.inf_rechazos (fecha,Fis_Vent,Quim_Vent,Calaf_vent,Ana_Vent,Fis_HMadres,";
		$insertar.="Quim_HMadres,Calaf_HMadres,Ana_HMadres,Fis_Teniente,Quim_Teniente,Calaf_Teniente,Ana_Teniente,";
		$insertar.="Fis_FHVL,Quim_FHVL,Calaf_FHVL,Ana_FHVL,Fis_Disputada,Quim_Disputada,Calaf_Disputada,Ana_Disputada,";
		$insertar.="Fis_Restos,Quim_Restos,Calaf_Restos,Ana_Restos,hora) values ('".$fecha."','".$fvent."',0,0,0,0,0,0,0,";
		$insertar.="'".$ften."',0,0,0,'".$fhvl."',0,0,0,'".$fdis."',0,0,0,0,0,0,0,'".$fechaHH."')";
		mysqli_query($link, $insertar); 
	}	
}
	$rechacp = 0;
	$rechahp = 0;
	$TxtHornada = "";


	echo "<Script>JavaScript:window.location = 'sea_util_ing_rechazos.php';
	</Script>"; 


?>
</head>
</html>
