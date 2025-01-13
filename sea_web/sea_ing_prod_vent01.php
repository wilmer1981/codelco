<?php
	include("../principal/conectar_sea_web.php"); 

		$proceso = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
		$ano     = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";
		$mes     = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
		$dia     = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";
		$hora    = isset($_REQUEST["hora"])?$_REQUEST["hora"]:"";
		$minuto  = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:"";

		$num_hornada        = isset($_REQUEST["num_hornada"])?$_REQUEST["num_hornada"]:"";
		$uni_hojas_madres  	= isset($_REQUEST["uni_hojas_madres"])?$_REQUEST["uni_hojas_madres"]:"";
		$peso_hojas_madres 	= isset($_REQUEST["peso_hojas_madres"])?$_REQUEST["peso_hojas_madres"]:"";
		$uni_rechazo_hm 	= isset($_REQUEST["uni_rechazo_hm"])?$_REQUEST["uni_rechazo_hm"]:"";
		$uni_corrientes 	= isset($_REQUEST["uni_corrientes"])?$_REQUEST["uni_corrientes"]:"";
		$peso_corrientes 	= isset($_REQUEST["peso_corrientes"])?$_REQUEST["peso_corrientes"]:"";
		$uni_rechazo_cte 	= isset($_REQUEST["uni_rechazo_cte"])?$_REQUEST["uni_rechazo_cte"]:"";
		$peso_rechazo_cte 	= isset($_REQUEST["peso_rechazo_cte"])?$_REQUEST["peso_rechazo_cte"]:"";
		$uni_hornada    	= isset($_REQUEST["uni_hornada"])?$_REQUEST["uni_hornada"]:"";
		$peso_hornada   	= isset($_REQUEST["peso_hornada"])?$_REQUEST["peso_hornada"]:"";

		$peso_rechazo_hm   	= isset($_REQUEST["peso_rechazo_hm"])?$_REQUEST["peso_rechazo_hm"]:"";
		$cmbhornos   		= isset($_REQUEST["cmbhornos"])?$_REQUEST["cmbhornos"]:"";
		//$flujo_hm   		= isset($_REQUEST["flujo_hm"])?$_REQUEST["flujo_hm"]:"";
			
//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	$valida_fecha_movimiento = $ano."-".$mes."-".$dia;
	include("sea_valida_mes.php");
//*******************************************************************************//
if (strlen($mes)== 1)
	$mes ="0".$mes;
if (strlen($dia)== 1)
	$dia ="0".$dia;
if (strlen($hora)==1)
    $hora="0".$hora;
if (strlen($minuto)==1)
	$minuto = "0".$minuto;		

$fecha = $ano."-".$mes."-".$dia;
$fecha_hora = $ano."-".$mes."-".$dia." ".$hora.":".$minuto;

if (strlen($mes) == 1)
$mes = "0".$mes;

$num_hornada = $ano.$mes.$num_hornada;
if($uni_hojas_madres=='')
	$uni_hojas_madres=0;
if($peso_hojas_madres=='')
	$peso_hojas_madres=0;
if($uni_rechazo_hm=='')
	$uni_rechazo_hm=0;
if($peso_rechazo_hm=='')
	$peso_rechazo_hm=0;
if($uni_corrientes=='')
	$uni_corrientes=0;
if($peso_corrientes=='')
	$peso_corrientes=0;
if($uni_rechazo_cte=='')
	$uni_rechazo_cte=0;
if($peso_rechazo_cte=='')
	$peso_rechazo_cte=0;
if($uni_hornada=='')
	$uni_hornada=0;
if($peso_hornada=='')
	$peso_hornada=0;

	function RegistrarHornada($num_hornada,$link)
	{
		$HornadaCorr=substr($num_hornada,6,1);
		$actualizar = "UPDATE proyecto_modernizacion.sub_clase set valor_subclase3=valor_subclase3+1 where  cod_clase = '2006' and cod_subclase='".$HornadaCorr."'";
		mysqli_query($link, $actualizar);
	}
$RegistroHornada=false;
/*****************************************GUARDAR****************************************/
$flujo_hm=0;
if ($proceso == 'G')
{
// asign flujo según horno	 
	 if($cmbhornos == 1 || $cmbhornos == 2)
	 {
	 $flujo_cor = 92;
	 $flujo_esp = 95;
	 $flujo_hm = 129;
	 }
	 
	 if($cmbhornos == 4)
	 {
	 $flujo_cor = 93;
	 $flujo_esp = 99;
	 $flujo_hm = 131;
	 }
	 $control = 0;
/************* Hojas Madres *********/	 

	 if($uni_hojas_madres !=0 && $uni_hojas_madres != '')
	 {
    	$Insertar_m = "INSERT INTO sea_web.movimientos"; 
    	$Insertar_m.=" (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,campo1,campo2,fecha_benef,peso,estado,lote_ventana,peso_origen,zuncho,hora,sub_tipo_movim)";
    	$Insertar_m.=" VALUES (1,17,8,'".$flujo_hm."','".$num_hornada."','".$fecha."', '".$uni_hojas_madres."',0,null,null,null,'".$peso_hojas_madres."',0,null,0,0,'".$fecha_hora."',1)";
		mysqli_query($link, $Insertar_m);
		//echo "uno".$Insertar_m."</br>";
	 	if($uni_rechazo_hm !=0 && $uni_rechazo_hm != '')
        {
			$control = 1;
			$Insertar_rm = "INSERT INTO sea_web.movimientos"; 
    		$Insertar_rm.=" (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,campo1,campo2,fecha_benef,peso,estado,lote_ventana,peso_origen,zuncho,hora,sub_tipo_movim)";
    		$Insertar_rm.=" VALUES (1,17,8,'".$flujo_hm."','".$num_hornada."','".$fecha."', '".$uni_rechazo_hm."',0,null,null,null,'".$peso_rechazo_hm."',0,null,0,0,'".$fecha_hora."',2)";
		//	echo "dos".$Insertar_rm."</br>";
			mysqli_query($link, $Insertar_rm);
        }
        $Consulta = "SELECT unidades,peso_unidades FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = 8 AND hornada_ventana = '".$num_hornada."'"; 	
		$rs = mysqli_query($link, $Consulta);
		if($row = mysqli_fetch_array($rs))
		{
   			$unidades_total = $row["unidades"] + ($uni_hojas_madres * 1)  + ($uni_rechazo_hm * 1);
   			$peso_total = $row["peso_unidades"] + ($peso_hojas_madres * 1) + ($peso_rechazo_hm * 1);

			$Actualizar = "UPDATE hornadas SET unidades = '".$unidades_total."', peso_unidades = '".$peso_total."' WHERE cod_producto = 17 AND cod_subproducto = 8 AND hornada_ventana = '".$num_hornada."'";
            mysqli_query($link, $Actualizar);
		}
		else
		{
			$unidades_total = ($uni_hojas_madres * 1) + ($uni_rechazo_hm * 1);
   			$peso_total = ($peso_hojas_madres * 1) + ($peso_rechazo_hm * 1);
			$Insertar_h = "INSERT INTO hornadas"; 
			$Insertar_h.= " (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades)";
			$Insertar_h.= " VALUES (17,8,'".$num_hornada."','".$unidades_total."','".$peso_total."')";
			mysqli_query($link, $Insertar_h);
			
			RegistrarHornada($num_hornada,$link);
			$RegistroHornada=true;
		}
					
     }	

/******** Corrientes ********************/	

	 if($uni_corrientes !=0 && $uni_corrientes != '') 
	 { 
    	$Insertar_m = "INSERT INTO movimientos"; 																													
    	$Insertar_m.= " (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,campo1,campo2,fecha_benef,peso,estado,lote_ventana,peso_origen,zuncho,hora,sub_tipo_movim)";
    	$Insertar_m.= " VALUES (1,17,4,'".$flujo_cor."','".$num_hornada."','".$fecha."', '".$uni_corrientes."',0,null,null,null,'".$peso_corrientes."',0,null,0,0,'".$fecha_hora."',1)";
	//	echo "tres".$Insertar_m."</br>";
		mysqli_query($link, $Insertar_m);
	 	if($uni_rechazo_cte !=0 && $uni_rechazo_cte != '') 
		{
			$control = 2;
		 	$Insertar_rm = "INSERT INTO movimientos"; 																													
    		$Insertar_rm.= " (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,fecha_movimiento,unidades,numero_recarga,campo1,campo2,fecha_benef,peso,estado,lote_ventana,peso_origen,zuncho,hora,sub_tipo_movim)";
    		$Insertar_rm.= " VALUES (1,17,4,'".$flujo_cor."','".$num_hornada."','".$fecha."', '".$uni_rechazo_cte."',0,null,null,null,'".$peso_rechazo_cte."',0,null,0,0,'".$fecha_hora."',2)";
	//		echo "tres".$Insertar_rm."</br>";
			mysqli_query($link, $Insertar_rm);

		}
        $Consulta = "SELECT unidades,peso_unidades FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = 4 AND hornada_ventana = '".$num_hornada."'"; 	
		$rs = mysqli_query($link, $Consulta);
		if($row = mysqli_fetch_array($rs))
		{
   			$unidades_total = $row["unidades"] + ($uni_corrientes  * 1) + ($uni_rechazo_cte * 1); 
   			$peso_total = $row["peso_unidades"] + ($peso_corrientes * 1) + ($peso_rechazo_cte * 1);

			$Actualizar = "UPDATE hornadas SET unidades = '".$unidades_total."', peso_unidades = '".$peso_total."' WHERE cod_producto = 17 AND cod_subproducto = 4 AND hornada_ventana = '".$num_hornada."'";
            mysqli_query($link, $Actualizar);
		}
		else
		{
   			$unidades_total = ($uni_corrientes  * 1) + ($uni_rechazo_cte * 1); 
   			$peso_total = ($peso_corrientes * 1) + ($peso_rechazo_cte * 1);
		
			$Insertar_h = "INSERT INTO hornadas"; 
			$Insertar_h = "$Insertar_h (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades)";
			$Insertar_h = "$Insertar_h VALUES (17,4,'".$num_hornada."', '".$unidades_total."', '".$peso_total."')";
			mysqli_query($link, $Insertar_h);
			if($RegistroHornada==false)
			{
				RegistrarHornada($num_hornada,$link);
			
			}
		
		}
    }

	if($control > 0)
	{
		$rechazo_cte = 0;
		$rechazo_hm = 0;
		$Consulta ="SELECT max(fecha) as fechita  from sea_web.inf_rechazos  where fecha <= '".$fecha."'";
		//echo "--".$Consulta."</br>";
		$Resp=mysqli_query($link, $Consulta);
		if($Row=mysqli_fetch_array($Resp))
		{
			$ConsultaN="SELECT * from sea_web.inf_rechazos where fecha ='".$Row["fechita"]."'";
			$RespN=mysqli_query($link, $ConsultaN);
			//echo "--".$ConsultaN."</br>";
			if ($Fila=mysqli_fetch_array($RespN))
			{
				$rechazo_cte = $Fila["Fis_Vent"] * 1000;
				$rechazo_hm = $Fila["Fis_HMadres"] * 1000;
			}
		}
		if ($uni_rechazo_cte > 0 || $rechazo_cte > 0)
		{
			$rechazo_cte = round($rechazo_cte + $peso_rechazo_cte) / 1000;
			$rechazo_cte = number_format($rechazo_cte,0,'','');
		}
		if ($uni_rechazo_hm > 0 || $rechazo_hm > 0)
		{
			$rechazo_hm = round($rechazo_hm + $peso_rechazo_hm) / 1000;
			$rechazo_hm = number_format($rechazo_hm,0,'','');
		}
		
		$consulta="SELECT * from  sea_web.inf_rechazos where fecha = '".$fecha."'";
		$Rsp=mysqli_query($link, $consulta);
		if ($Linea=mysqli_fetch_array($Rsp))
		{		 			
			$actualiza="UPDATE sea_web.inf_rechazos set Fis_Vent = '".$rechazo_cte."',Fis_HMadres = '".$rechazo_hm."'";
			$actualiza.=" where fecha = '".$fecha."'";
			mysqli_query($link, $actualiza);
		}
		else
		{
			$Inserta = "INSERT INTO sea_web.inf_rechazos (Fecha,Fis_Vent,Quim_Vent,Calaf_Vent,Ana_Vent,";
			$Inserta.= "Fis_HMadres,Quim_HMadres,Calaf_HMadres,Ana_HMadres,Fis_Teniente,Quim_Teniente,Calaf_Teniente,Ana_Teniente,";
			$Inserta.= "Fis_FHVL,Quim_FHVL,Calaf_FHVL,Ana_FHVL,Fis_Disputada,Quim_Disputada,Calaf_Disputada,Ana_Disputada,";
			$Inserta.= "Fis_Restos,Quim_Restos,Calaf_Restos,Ana_Restos,Fis_Expo,Quim_Expo,Calaf_Expo,Ana_Expo,hora)";
			$Inserta.= " VALUES('".$fecha."','".$rechazo_cte."',0,0,0,";
			$Inserta.= "'".$rechazo_hm."',0,0,0,0,0,0,0,";
			$Inserta.= "0,0,0,0,0,0,0,0,";
			$Inserta.= "0,0,0,0,0,0,0,0,'$fecha_hora')";
			mysqli_query($link, $Inserta);
	//		echo "insr ".$Inserta."<br>";	
	 	}	
	}
	
	echo "<script>JavaScript:window.location = 'sea_ing_prod_vent.php';</script>"; 

}
	include("../principal/cerrar_sea_web.php"); 
?>