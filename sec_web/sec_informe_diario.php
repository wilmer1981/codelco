<?php  //$link = mysql_connect('10.56.11.7','adm_bd','672312');
 include("../principal/conectar_principal.php");
 //mysql_SELECT_db("sec_web",$link);
	set_time_limit(2000);

	$Dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S�bado");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	$Ano = $_REQUEST["Ano"];
	$Mes = $_REQUEST["Mes"];
	$Dia = $_REQUEST["Dia"];

	$str_dia = date("w", mktime(0,0,0,$Mes,$Dia,$Ano));
	$EnPreparacion =0;
	$FechaInf = $Ano."-".str_pad($Mes,2, "0", STR_PAD_LEFT)."-".str_pad($Dia,2, "0", STR_PAD_LEFT);
	$Fecha1 = $Ano."-".str_pad($Mes,2, "0", STR_PAD_LEFT)."-01";
	$DiaAuxSig=$Dia+1;
	$Fecha2 = date("Y-m-d", mktime(1,0,0,$Mes,$DiaAuxSig,$Ano));
	$AnoAnt = date("Y",mktime(0,0,0,$Mes-1,01,$Ano));
	$MesAnt = date("n",mktime(0,0,0,$Mes-1,01,$Ano));
	$SinPreparar = 0;
	$Consulta = "SELECT * from sec_web.informe_diario ";
	$Consulta.= " where fecha = '".$FechaInf."'";
	$Resp = mysqli_query($link, $Consulta);
	$Genera = false;
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$Genera = true;
		
		$PaqLavar = $Fila["peso_paquete_lavar"];
		$PaqPesar = $Fila["peso_paquete_pesar"];
		$PaqStandard = $Fila["peso_paquete_standard"];
		$PaqCatodosGranel = $Fila["peso_catodos_granel"];
		$PaqStandardGranel = $Fila["peso_standard_granel"];
		$ConfecGranel = $Fila["peso_confec_paquetes"];
		$Observacion = $Fila["observacion"];
		$Validacion = 0;
		$RecDiario = $Fila["recuperado_diario"];
		$RecAcumulado = $Fila["recuperado_acumulado"];
		$StDiario = $Fila["standard_diario"];
		$StAcumulado = $Fila["standard_acumulado"];
		$EnPreparacion = $Fila["sin_preparar_arrastre"];
	}
	
	if ($ConsultaGeneral=="S")
	{
		if (!$Genera)
			header("location:sec_informe_diario_general.php?Generado=N");
	}
	$StockIniComercial = 0;
	$StockIniGradoA = 0;
	$StockIni1ER = 0;
	
	$TotalExistencia = 0;
	$PreparadosGradoA = 0;
	$PreparadosStd1ER = 0;
	$PreparadosStd2ER = 0;
	$PreparadosStd3ER = 0;
	
	$NodulosRecuperados = 0;
	$RechazoQco = 0;
	$StockIni1ER = 0; 
	$StockIni2ER = 0; 
	$StockIni3ER= 0;
	
	
	
	$EnPqtes = 0;
	$ParaPesaje = 0;
	$GradoA = 0;
	$PesadoEmbarque = 0;
	$PqtesSinPesarGranel = 0;
	$StandardAcumulado = 0;
	$PorcStandard = 0;	
	$ComercialDiario = 0;
	$ComercialAcumulado = 0;
	$DescNormalDiario = 0;
	$DescNormalAcumulado = 0;
	$DescParcialDiario = 0;
	$DescParcialAcumulado = 0;
	$DespLamDiario = 0;
	$DespLamAcumulado = 0;
	$FaenasDiario = 0;
	$FaenasAcumulado = 0;
	$TotalCuElecDiario = 0;
	$TotalCuElecAcumulado = 0;
	$Embarque = 0;
	$Pesaje = 0;
	//LETRA MES
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaInf,5,2))."'"	;
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{	
		$MesConsulta = $Fila["nombre_subclase"];
		$Letra = $Fila["nombre_subclase"];
	}
	
	//STOCK INICIAL COMERCIALES(PESO PRODUCCION)
	
	$Consulta = "SELECT sum(peso_produccion) as peso_prod from sec_web.produccion_catodo";
	$Consulta.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
	$Consulta.= " and cod_producto = '18'";
	$Consulta.= " and cod_subproducto = '1'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$SinPreparar = $SinPreparar + $Fila["peso_prod"];
		$TotalProdComerciales = $Fila["peso_prod"];
	}
	$TotalExistencia = 0;
	//STOCK INICIAL
	$Consulta = "SELECT cod_producto,cod_subproducto,sum(peso) as peso from sec_web.stock_final";
	$Consulta.= " where year(fecha) = ".$AnoAnt." and month(fecha) = ".$MesAnt."";
	$Consulta.= " and cod_producto = '18'";
	$Consulta.= " and (cod_subproducto = '40' or cod_subproducto = '46' or cod_subproducto = '2' or cod_subproducto = '18')";
	$Consulta.= " group by cod_producto,cod_subproducto"; 
	$Respuesta2 = mysqli_query($link, $Consulta);
	while ($Fila2 = mysqli_fetch_array($Respuesta2))
	{
		if ($Fila2["cod_subproducto"] == 40)
			$StockIniGradoA = $StockIniGradoA + $Fila2["peso"];
		if 	($Fila2["cod_subproducto"] == 46)
			$StockIni1ER = $StockIni1ER + $Fila2["peso"];
		if 	($Fila2["cod_subproducto"] == 2)
			$StockIni2ER = $StockIni2ER + $Fila2["peso"];
		if ($Fila2["cod_subproducto"] == 18)	
			$StockIni3ER = $StockIni3ER + $Fila2["peso"];
		$TotalExistencia = $TotalExistencia + $Fila2["peso"];
	}			
	//STOCK PAQUETES
	$Consulta = "SELECT cod_producto,cod_subproducto,sum(peso_paquetes) as peso_paquetes from sec_web.paquete_catodo ";
	$Consulta.= " where cod_producto='18'";
	$Consulta.= " and (cod_subproducto = '40' or cod_subproducto = '46' or cod_subproducto = '2' or cod_subproducto = '18')";
	$Consulta.= " and cod_paquete='".$Letra."' ";
	$Consulta.= " and CONCAT(fecha_creacion_paquete,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
	$Consulta.= " group by cod_producto,cod_subproducto"; 
	$Respuesta2=mysqli_query($link, $Consulta);
	while ($Fila2=mysqli_fetch_array($Respuesta2))
	{
		if ($Fila2["cod_subproducto"] == 40)
			$StockIniGradoA = $StockIniGradoA + $Fila2["peso_paquetes"];
			
		if  ($Fila2["cod_subproducto"] == 46)
	
			$StockIni1ER = $StockIni1ER + $Fila2["peso_paquetes"];
		
		if ($Fila2["cod_subproducto"] == 2)
		
			$StockIni2ER  = $StockIni2ER  + $Fila2["peso_paquetes"];
		if ($Fila2["cod_subproducto"] == 18)
			$StockIni3ER = $StockIni3ER + $Fila2["peso_paquetes"];
		$SinPreparar = abs($SinPreparar - $Fila2["peso_paquetes"]);

		$TotalExistencia = $TotalExistencia + $Fila2["peso_paquetes"];
	}
	
	//STOCK TRASPASO XXX
	$Consulta = "SELECT cod_producto,cod_subproducto,sum(peso) as peso_traspaso  from sec_web.traspaso ";
	$Consulta.= " where cod_producto='18'";
	$Consulta.= " and (cod_subproducto = '40' or cod_subproducto = '46' or cod_subproducto = '2' or cod_subproducto = '18') ";
	$Consulta.= " and fecha_traspaso between '".$Fecha1."' and '".$Fecha2."'";
	$Consulta.= " group by cod_producto,cod_subproducto"; 
	$Respuesta2=mysqli_query($link, $Consulta);
	while ($Fila2=mysqli_fetch_array($Respuesta2))
	{
		if ($Fila2["cod_subproducto"] == 40)
			$StockIniGradoA = abs($StockIniGradoA - $Fila2["peso_traspaso"]);
		if 	($Fila2["cod_subproducto"] == 46)
			$StockIni1ER  = abs($StockIni1ER  - $Fila2["peso_traspaso"]);
		if 	($Fila2["cod_subproducto"] == 2)
			$StockIni2ER = abs($StockIni2ER - $Fila2["peso_traspaso"]);

		if ($Fila2["cod_subproducto"] == 18)	
			$StockIni3ER = $StockIni3ER- $Fila2["peso_traspaso"];
		$TotalExistencia = abs($TotalExistencia - $Fila2["peso_traspaso"]);
	}
	//STOCK EMBARQUE
	$Consulta = "SELECT cod_producto,cod_subproducto,sum(t2.peso_paquetes) as peso_embarque  ";
	$Consulta.= " from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2  ";
	$Consulta.= " on t1.num_guia=t2.num_guia ";
	$Consulta.= " where (t1.cod_estado <>'A') ";
	$Consulta.= " and CONCAT(fecha_guia,' ',hora_guia) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
	$Consulta.= " and (t2.cod_estado = 'c') and (t2.cod_producto='18' and (cod_subproducto = '40' or cod_subproducto = '46' or cod_subproducto = '2' or cod_subproducto = '18'))";
	$Consulta.= " group by t2.cod_producto, t2.cod_subproducto ";
	$Respuesta2=mysqli_query($link, $Consulta);
	while ($Fila2=mysqli_fetch_array($Respuesta2))
	{
		if ($Fila2["cod_subproducto"] == 40)
			$StockIniGradoA = abs($StockIniGradoA - $Fila2["peso_embarque"]);
		
		if ($Fila2["cod_subproducto"] == 46)	
			$StockIni1ER = abs($StockIni1ER - $Fila2["peso_embarque"]);
		if ($Fila2["cod_subproducto"] == 2)	
			$StockIni2ER  = abs($StockIni2ER  - $Fila2["peso_embarque"]);
		if ($Fila2["cod_subproducto"] == 18)	
			$StockIni3ER = $StockIni3ER - $Fila2["peso_embarque"];
		$TotalExistencia = abs($TotalExistencia - $Fila2["peso_embarque"]);
	}
	
	$TotalExistencia = ($TotalExistencia + Validacion) / 1000;
	$TotalProdComerciales =  $TotalProdComerciales / 1000;
	//PREPARADOS
	$PreparadosGradoA = $StockIniGradoA / 1000;
	$PreparadosStd1ER = $StockIni1ER / 1000;
	$PreparadosStd2ER = $StockIni2ER /1000;
	$PreparadosStd3ER = $StockIni3ER /1000;
	//SIN PREPARAR

	$SinPreparar = $SinPreparar / 1000;
	//EN PQTES
	$EnPqtes = $SinPreparar - $PaqStandardGranel;
	//PARA PESAJE 
	$ParaPesaje = $EnPqtes - ($PaqStandard + $PaqLavar);
	//GRADO A
	$GradoA = abs($PaqCatodosGranel - $PaqStandardGranel);
	
	//DIARIO COMERCIAL
	$ComercialDiario=0;$ComercialAcumulado=0;$DescNormalDiario=0;$DescNormalAcumulado=0;$DescParcialDiario=0;$DescParcialAcumulado=0;
	//$Consulta = "SELECT  sum(peso_produccion) as peso from sec_web.produccion_catodo";
	$Consulta="SELECT cod_subproducto as subprod,fecha_produccion as fecha, hour(hora) as horita, sum(peso_produccion) as peso";
	$Consulta.=" from sec_web.produccion_catodo";
	$Consulta.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
	$Consulta.= " and cod_producto = '18' and cod_subproducto in (1,4,5) ";
	$Consulta.= " group by cod_subproducto,fecha_produccion, hour(hora)";
    //echo "comercial".$Consulta."</br>";
	$Respuesta = mysqli_query($link, $Consulta);
	//if ($Fila = mysqli_fetch_array($Respuesta))
	while($Fila = mysqli_fetch_array($Respuesta))
	{
		if($Fila["subprod"]==1)
		{
			if(($Fila["fecha"]==$FechaInf && $Fila["horita"]>=8) || ($Fila["fecha"]==$Fecha2 && $Fila["horita"] < 8))
				$ComercialDiario = $ComercialDiario + $Fila["peso"];
			$ComercialAcumulado = $ComercialAcumulado + $Fila["peso"];
		}
		else if($Fila["subprod"]==4)
		{
				if(($Fila["fecha"]==$FechaInf && $Fila["horita"]>=8) || ($Fila["fecha"]==$Fecha2 && $Fila["horita"] < 8))
					$DescParcialDiario = $DescParcialDiario + $Fila["peso"];
				$DescParcialAcumulado = $DescParcialAcumulado + $Fila["peso"];
		}
		else if($Fila["subprod"]==5)
		{
				if(($Fila["fecha"]==$FechaInf && $Fila["horita"]>=8) || ($Fila["fecha"]==$Fecha2 && $Fila["horita"] < 8))
					$DescNormalDiario = $DescNormalDiario + $Fila["peso"] ;
				$DescNormalAcumulado = $DescNormalAcumulado + $Fila["peso"];			
		}
	}
	//ACUMULADO COMERCIAL

		//$Consulta = "SELECT sum(peso_produccion) as peso from sec_web.produccion_catodo";
		//$Consulta.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
		//$Consulta.= " and cod_producto = '18'";
		//$Consulta.= " and cod_subproducto in ('1')";
		//$Respuesta = mysqli_query($link, $Consulta);
		//if ($Fila = mysqli_fetch_array($Respuesta))
		//{
		//$ComercialAcumulado = $Fila["peso"];
		//}
	
		//DIARIO Electo. Wining VentanasL
		//$DescNormalDiario=0;$DescNormalDiario=0;
		//$Consulta = "SELECT sum(peso_produccion) as peso from sec_web.produccion_catodo";
		//$Consulta="SELECT fecha_produccion as fecha,hour(hora) as horita,sum(peso_produccion) as peso from sec_web.produccion_catodo";
		//$Consulta.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
		//$Consulta.= " and cod_producto = '18'";
		//$Consulta.= " and cod_subproducto = '5' group by fecha_produccion, hour(hora)";
		//$Respuesta = mysqli_query($link, $Consulta);
		//if($Fila = mysqli_fetch_array($Respuesta))
		//while($Fila = mysqli_fetch_array($Respuesta))
		//{
			//if(($Fila["fecha"]==$FechaInf && $Fila["horita"]>=8) || ($Fila["fecha"]==$Fecha2 && $Fila["horita"] < 8))
			//{		
		//$DescNormalDiario = $DescNormalDiario + $Fila["peso"];
		//}
		//$DescNormalAcumulado = $DescNormalAcumulado + $Fila["peso"];		
		//}
	//ACUMULADO Electro. Wining Ventanas
	
		//$Consulta = "SELECT sum(peso_produccion) as peso from sec_web.produccion_catodo";
		//$Consulta.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
		//$Consulta.= " and cod_producto = '18'";
		//$Consulta.= " and cod_subproducto = '5'";
		//$Respuesta = mysqli_query($link, $Consulta);
		//if ($Fila = mysqli_fetch_array($Respuesta))
		//{
			//$DescNormalAcumulado = $Fila["peso"];
		//}
	
	//DIARIO DESC. PARCIAL
		//$DescParcialDiario=0;$DescParcialAcumulado=0;
		//$Consulta = "SELECT sum(peso_produccion) as peso from sec_web.produccion_catodo";
		//$Consulta = "SELECT fecha_produccion as fecha,hour(hora) as horita, sum(peso_produccion) as peso from sec_web.produccion_catodo";
    	//$Consulta.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
		//$Consulta.= " and cod_producto = '18'";
		//$Consulta.= " and cod_subproducto = '4' group by fecha, hour(hora)";
		//$Respuesta = mysqli_query($link, $Consulta);
		//if ($Fila = mysqli_fetch_array($Respuesta))
		//while($Fila = mysqli_fetch_array($Respuesta))
		//{
		//if(($Fila["fecha"]==$FechaInf && $Fila["horita"]>=8) || ($Fila["fecha"]==$Fecha2 && $Fila["horita"] < 8))
		//{
			//$DescParcialDiario = $DescParcialDiario + $Fila["peso"];
		//}
		//$DescParcialAcumulado = $DescParcialAcumulado + $Fila["peso"];
		//}
	//ACUMULADO DESC. PARCIAL
	
		//$Consulta = "SELECT sum(peso_produccion) as peso from sec_web.produccion_catodo";
		//$Consulta.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
		//$Consulta.= " and cod_producto = '18'";
		//$Consulta.= " and cod_subproducto = '4'";
		//$Respuesta = mysqli_query($link, $Consulta);
	
		//if ($Fila = mysqli_fetch_array($Respuesta))
		//{
			//$DescParcialAcumulado = $Fila["peso"];
		//}
	//DIARIO DESP. LAM.
	$DespLamDiario=0;$DespLamAcumulado=0;
	//$Consulta = "SELECT sum(peso_produccion) as peso from sec_web.produccion_catodo";
	$Consulta = "SELECT fecha_produccion as fecha,hour(hora) as horita, sum(peso_produccion) as peso from sec_web.produccion_catodo";
	$Consulta.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
	$Consulta.= " and cod_producto = '48' group by fecha_produccion, hour(hora)";
    //echo "desp".$Consulta."</br>";
	$Respuesta = mysqli_query($link, $Consulta);
	//if ($Fila = mysqli_fetch_array($Respuesta))
	while($Fila = mysqli_fetch_array($Respuesta))
	{
		if(($Fila["fecha"]==$FechaInf && $Fila["horita"]>=8) || ($Fila["fecha"]==$Fecha2 && $Fila["horita"] < 8))
			$DespLamDiario = $DespLamDiario + $Fila["peso"];
		$DespLamAcumulado = $DespLamAcumulado + $Fila["peso"];
	}
	//ACUMULADO DESP. LAM.
		//$Consulta = "SELECT sum(peso_produccion) as peso from sec_web.produccion_catodo";
		//$Consulta.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
		//$Consulta.= " and cod_producto = '48'";
		//$Respuesta = mysqli_query($link, $Consulta);
		//if ($Fila = mysqli_fetch_array($Respuesta))
		//{
			//	$DespLamAcumulado = $Fila["peso"];
		//}
	//DIARIO FAENAS EXTERNAS
	$FaenasDiario=0;$FaenasAcumulado=0;
	//$Consulta = "SELECT sum(peso_paquetes) as peso from sec_web.paquete_catodo";
	$Consulta = "SELECT fecha_creacion_paquete as fecha,hour(hora) as horita, sum(peso_paquetes) as peso from sec_web.paquete_catodo";
	$Consulta.= " where CONCAT(fecha_creacion_paquete,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
	$Consulta.= " and cod_producto = '18'";
	$Consulta.= " and (cod_subproducto in(6,8,9,10,12,7,48)) group by fecha_creacion_paquete,hour(hora)";
	//echo "faenas".$Consulta."</br>";
	$Respuesta = mysqli_query($link, $Consulta);
	//if ($Fila = mysqli_fetch_array($Respuesta))
	while($Fila = mysqli_fetch_array($Respuesta))
	{
		if(($Fila["fecha"]==$FechaInf && $Fila["horita"]>=8) || ($Fila["fecha"]==$Fecha2 && $Fila["horita"] < 8))
			$FaenasDiario = $FaenasDiario + $Fila["peso"];
		$FaenasAcumulado = $FaenasAcumulado + $Fila["peso"];
	}
	//ACUMULADO FAENAS EXTERNAS
		//$Consulta = "SELECT sum(peso_paquetes) as peso from sec_web.paquete_catodo";
		//$Consulta.= " where CONCAT(fecha_creacion_paquete,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
		//$Consulta.= " and cod_producto = '18'";
		//$Consulta.= " and (cod_subproducto in(6,8,9,10,12,7,48))";
		//$Respuesta = mysqli_query($link, $Consulta);
		//if ($Fila = mysqli_fetch_array($Respuesta))
		//{
			//$FaenasAcumulado = $Fila["peso"];
		//}
	$TotalCuElecDiario = $ComercialDiario + $DescNormalDiario + $DespLamDiario;
	$TotalCuElecAcumulado = $ComercialAcumulado + $DescNormalAcumulado + $DespLamAcumulado;
	//PESADO A EMBARQUE STANDARD
	$Consulta = " SELECT sum(peso_paquetes) as peso FROM sec_web.paquete_catodo ";
	$Consulta.= " where CONCAT(fecha_creacion_paquete,' ',hora) BETWEEN '".$Fecha1." 08:00:00' AND '".$Fecha2." 07:59:59'";
	$Consulta.= " and cod_producto = '18'";
	$Consulta.= " and cod_paquete = '".$Letra."'";
	$Consulta.= " and cod_subproducto in  ('46','2','18')";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$PesadoEmbarque = $Fila["peso"];
	}
	$PqtesSinPesarGranel = ($PaqStandard + $PaqStandardGranel) * 1000;
	$StandardAcumulado = $PesadoEmbarque + $PqtesSinPesarGranel;
	//PORCENTAJE DE STANDARD
	$PorcStandard = 100 * ($StandardAcumulado/$ComercialAcumulado);	
	//PESAJE
	$Consulta = " SELECT sum(peso_paquetes) as peso FROM sec_web.paquete_catodo ";
	$Consulta.= " where CONCAT(fecha_creacion_paquete,' ',hora) BETWEEN '".$FechaInf." 08:00:00' AND '".$Fecha2." 07:59:59'";
	$Consulta.= " and cod_producto = '18' and cod_subproducto in('40','46','2','18')";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Pesaje = $Fila["peso"]/1000;
	}
	//EMBARQUE DEL DIA
	$Consulta = "SELECT sum(peso_bruto) as peso FROM sec_web.guia_despacho_emb ";
	$Consulta.= " where cod_estado != 'A' and CONCAT(fecha_guia,' ',hora_guia) BETWEEN '".$FechaInf." 08:00:00' AND '".$Fecha2." 07:59:59'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Embarque = $Fila["peso"]/1000;
	}

?>
<html>
<head>
<title>Informe Diario de Productos Finales</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "I":
			f.BtnImprimir.style.visibility = 'hidden';
			f.BtnSalir.style.visibility = 'hidden';
			window.print();
			f.BtnImprimir.style.visibility = '';
			f.BtnSalir.style.visibility = '';
			break;
		case "S":
<?php	
	if ($ConsultaGeneral=="S")			
		echo "f.action = 'sec_informe_diario_general.php';";
	else
		echo "f.action = 'sec_informe_diario_ing.php';";
?>
			f.submit();
			break;
	}
}
</script> 
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
<strong><center>INFORME DIARIO PRODUCTOS FINALES</center></strong><br>
<br>
<strong>FECHA: <?php echo $Dias[$str_dia]." ".$Dia." de ".$Meses[$Mes-1]." del ".$Ano; ?></strong><br>
<br>
<strong>1.-EXISTENCIA CATODOS COMERCIALES. (TONS.)</strong> <br>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="2">
  <tr align="center" class="ColorTabla01"> 
    <td>Total Existencias</td>
    <td>Preparados Grado &quot;A&quot;</td>
      <td>C&aacute;todos STD 1 ER</td>
      <td>C&aacute;todos STD 2 ER</td>
      <td>C&aacute;todos STD 3 ER</td>
    <td>Sin Preparar Acumulado</td>

  </tr>
  <tr align="center"> 
	<?php
 
		$SinPreparar = $SinPreparar + $EnPreparacion;
	?>
    <td><?php echo number_format(($TotalExistencia + $SinPreparar),0,",","."); ?></td>
    <td><?php echo number_format($PreparadosGradoA,0,",","."); ?></td>
    <td><?php echo number_format($PreparadosStd1ER,0,",","."); ?></td>
    <td><?php echo number_format($PreparadosStd2ER,0,",","."); ?></td>
    <td><?php echo number_format($PreparadosStd3ER,0,",","."); ?></td>
      <td><?php echo number_format($SinPreparar,0,",","."); ?></td>
  </tr>
</table>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="2">
  <tr align="center" class="ColorTabla01"> 
    <td width="161">Total Sin Preparar</td>
    <td width="318">En Paquetes (por pesar y lavar)</td>
    <td width="151">C&aacute;todos Granel</td>
  </tr>
  <tr align="center"> 
    <td><?php echo number_format($SinPreparar,0,",","."); ?></td>
    <td><?php echo number_format(($PaqLavar + $PaqPesar + $PaqStandard),0,",","."); ?></td>
    <td><?php echo number_format(($PaqCatodosGranel + $PaqStandardGranel),0,",","."); ?></td>
  </tr>
</table>
<br>
<strong>1.1.- Detalle Paquete</strong><br>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="2">
  <tr class="ColorTabla01"> 
    <td width="161" rowspan="2">Detalle de Paquetes</td>
    <td width="213" align="center">Para Lavado</td>
    <td width="138" align="center">Para Pesaje</td>
      <td width="112" align="center"> STD 1ER,2ER,3ER</td>
  </tr>
  <tr> 
    <td align="center"><?php echo number_format($PaqLavar,0,",","."); ?></td>
    <td align="center"><?php echo number_format($PaqPesar,0,",","."); ?></td>
      <td align="center"><?php echo number_format($PaqStandard,0,",","."); ?></td>
  </tr>
</table>
<br>
<strong>1.2.- Detalle Granel</strong><br>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="2">
  <tr class="ColorTabla01"> 
    <td width="160" rowspan="2">Detalle de Granel </td>
    <td width="313" align="center">Grado A</td>
      <td width="157" align="center">STD 1ER,2ER,3ER</td>
  </tr>
  <tr> 
    <td align="center"><?php echo number_format($PaqCatodosGranel,0,",","."); ?></td>
      <td align="center"><?php echo number_format($PaqStandardGranel,0,",","."); ?></td>
  </tr>
</table>
<br>
  <strong>2.- GENERACION DE RECHAZO ENM</strong><br>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="2">
  <tr  class="ColorTabla01">
    <td>Pesado a Embarque</td>
    <td>Paquetes Sin Pesar/Granel</td>
    <td>Rechazo ENM Acumulado</td>
      <td>% STD 1ER,2ER,3ER</td>
  </tr>
  <tr align="center"> 
    <td><?php echo number_format(($PesadoEmbarque/1000),0,",","."); ?></td>
    <td><?php echo number_format(($PaqStandard + $PaqStandardGranel),0,",","."); ?></td>
    <td><?php echo number_format(($StandardAcumulado/1000),0,",","."); ?></td>
      <td><?php echo number_format($PorcStandard,2,",","."); ?></td>
  </tr>
</table>
<br>
<strong>3.- % GENERACION RECUPERADO Y RECHAZO ENM EN UNIDADES</strong><br>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="2">
  <tr class="ColorTabla01">
    <td width="157">&nbsp;</td>
    <td width="233" align="center">Diario</td>
    <td width="240" align="center">Acumulado</td>
  </tr>
  <tr>
    <td class="ColorTabla01">Recuperado (%) </td>
    <td align="center"><?php echo number_format($RecDiario,2,",","."); ?></td>
    <td align="center"><?php echo number_format($RecAcumulado,2,",","."); ?></td>
  </tr>
  <tr>
    <td class="ColorTabla01">STD 1 ER,2 ER,3 ER(%) </td>
    <td align="center"><?php echo number_format($StDiario,2,",","."); ?></td>
    <td align="center"><?php echo number_format($StAcumulado,2,",","."); ?></td>
  </tr>
</table>
<br>
<strong>4.- RECEPCION DE PRODUCCION. (Kg.) </strong><br>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="2">
  <tr align="center" class="ColorTabla01"> 
    <td width="81">Producto</td>
    <td width="68">Comercial</td>
    <td width="79">Elect.Wining Venetanas</td>
    <td width="89">Lam. y Desp.</td>
	<td width="124">Total Cu Electrol&iacute;tico</td>
	<td width="84">Desc. Parcial</td>
    <td width="81">Otra Faena</td>
  </tr>
  <tr> 
    <td class="ColorTabla01">Diario</td>
    <td align="center"><?php echo number_format($ComercialDiario,0,",","."); ?></td>
    <td align="center"><?php echo number_format($DescNormalDiario,0,",","."); ?></td>
	 <td align="center"><?php echo number_format($DespLamDiario,0,",","."); ?></td>
	  <td align="center"><?php echo number_format($TotalCuElecDiario,0,",","."); ?></td>
    <td align="center"><?php echo number_format($DescParcialDiario,0,",","."); ?></td>
    <td align="center"><?php echo number_format($FaenasDiario,0,",","."); ?></td>
  </tr>
  <tr> 
    <td class="ColorTabla01">Acumulado</td>
    <td align="center"><?php echo number_format($ComercialAcumulado,0,",","."); ?></td>
    <td align="center"><?php echo number_format($DescNormalAcumulado,0,",","."); ?></td>
	<td align="center"><?php echo number_format($DespLamAcumulado,0,",","."); ?></td>
	<td align="center"><?php echo number_format($TotalCuElecAcumulado,0,",","."); ?></td> 
    <td align="center"><?php echo number_format($DescParcialAcumulado,0,",","."); ?></td>
    <td align="center"><?php echo number_format($FaenasAcumulado,0,",","."); ?></td>
    
  </tr>
</table>
<br>
<strong>5.- MOVIMIENTO Y PREPARACION DIARIA</strong><br>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="2">
  <tr align="center" class="ColorTabla01"> 
    <td width="156">Embarque</td>
    <td width="217">Pesaje</td>
    <td width="257">Confecci&oacute;n de Paquetes</td>
  </tr>
  <tr align="center"> 
    <td><?php echo number_format($Embarque,0,",","."); ?></td>
    <td><?php echo number_format($Pesaje,0,",","."); ?></td>
    <td><?php echo number_format($ConfecGranel,0,",","."); ?></td>
  </tr>
</table>
<br>
<strong>6.- OBSERVACION </strong><br>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="5">
  <tr> 
    <td><?php echo $Observacion; ?></td>
  </tr> 
</table>
<br>
<center><input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso('I');">
    <input name="BtnSalir" type="button" id="BtnSalir" style="width:70px" onClick="Proceso('S');" value="Salir">
  </center>
</form>
</body>
</html>
