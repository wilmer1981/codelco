<?php
	include("../principal/conectar_principal.php");
	include("funciones_interfaces_codelco.php");

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else {
		$Proceso = "";
	}
	if(isset($_REQUEST["Mostrar"])){
		$Mostrar = $_REQUEST["Mostrar"];
	}else {
		$Mostrar = "";
	}
	if(isset($_REQUEST["Orden"])){
		$Orden = $_REQUEST["Orden"];
	}else {
		$Orden = "";
	}

	if(isset($_REQUEST["Valor"])){
		$Valor = $_REQUEST["Valor"];
	}else {
		$Valor = "";
	}

	if(isset($_REQUEST["TxtFechaCon"])){
		$TxtFechaCon = $_REQUEST["TxtFechaCon"];
	}else {
		$TxtFechaCon = "";
	}
	if(isset($_REQUEST["Producto"])){
		$Producto = $_REQUEST["Producto"];
	}else {
		$Producto = "";
	}
	if(isset($_REQUEST["TxtTonelaje"])){
		$TxtTonelaje = $_REQUEST["TxtTonelaje"];
	}else {
		$TxtTonelaje = "";
	}
	if(isset($_REQUEST["TxtLote"])){
		$TxtLote = $_REQUEST["TxtLote"];
	}else {
		$TxtLote = "";
	}
	if(isset($_REQUEST["CmbMovimiento"])){
		$CmbMovimiento = $_REQUEST["CmbMovimiento"];
	}else {
		$CmbMovimiento = "";
	}
	if(isset($_REQUEST["CmbOrden"])){
		$CmbOrden = $_REQUEST["CmbOrden"];
	}else {
		$CmbOrden = "";
	}
	if(isset($_REQUEST["CmbAlmacen"])){
		$CmbAlmacen = $_REQUEST["CmbAlmacen"];
	}else {
		$CmbAlmacen = "";
	}
/*
Valores: 
TxtFechaCon: 2023-11-30
Producto: ACID
TxtTonelaje: 
TxtLote: 
CmbMovimiento: 921
CmbOrden: 
CmbAlmacen:
*/


	$Ano=substr($TxtFechaCon,0,4);
	$Mes=substr($TxtFechaCon,5,2);
	switch($Proceso)
	{
		case "CA"://CREAR ARCHIVO
			$FechaHora = str_replace(" ","_",date("Y_m_d H_i"));
			$Archivo = fopen("archivos_embarque/".$Producto."_embarque_".$FechaHora.".doc","w+");
			$ArchivoLeyes = fopen("archivos_embarque/".$Producto."_leyes_embarque_".$FechaHora.".doc","w+");
			$Datos=explode('//',$Valor);
			//while(list($c,$v)=each($Datos))
			foreach ($Datos as $c => $v)
			{
				$Datos2=explode('~',$v);
				$SAP_Tipo = "1";
				$SAP_FechaDoc = $Datos2[0];
				$SAP_FechaCon = $Datos2[0];
				$SAP_TipoMov = $Datos2[5];
				$SAP_Centro="FV01";
				$SAP_OrdenProd_Manual = $Datos2[6];
				$SAP_Almacen= $Datos2[8];	
				$SAP_CodMaterial=$Datos2[1];
				$SAP_Cantidad=$Datos2[2];
				$SAP_Unidad=$Datos2[3];
				$SAP_Lote=$Datos2[4];
				$SAP_ClaseValoriz_Manual = $Datos2[7];
				$SAP_Status="";
				$SAP_Msg="";
				$Linea = str_pad($SAP_Tipo,1," ",STR_PAD_LEFT);
				$Linea.= str_pad($SAP_FechaDoc,10," ",STR_PAD_LEFT);
				$Linea.= str_pad($SAP_FechaCon,10," ",STR_PAD_LEFT);
				$Linea.= str_pad($SAP_TipoMov,3,"0",STR_PAD_LEFT);
				$Linea.= str_pad($SAP_Centro,4," ",STR_PAD_LEFT);
				$Linea.= str_pad($SAP_Almacen,4,"0",STR_PAD_LEFT);
				$Linea.= str_pad($SAP_OrdenProd_Manual,12," ");
				$Linea.= str_pad($SAP_CodMaterial,18,"0",STR_PAD_LEFT);					
				$Linea.= str_pad(number_format($SAP_Cantidad,3,",",""),15," ",STR_PAD_LEFT)." ";
				$Linea.= str_pad($SAP_Unidad,3," ");
				$Linea.= str_pad($SAP_Lote,10," ");
				$Linea.= str_pad($SAP_ClaseValoriz_Manual,10," ");
				$Linea.= str_pad($SAP_Status,1," ",STR_PAD_LEFT);
				$Linea.= str_pad($SAP_Msg,80," ",STR_PAD_LEFT);
				fwrite($Archivo,$Linea."\r\n");
				$Insertar="INSERT INTO interfaces_codelco.registro_traspaso (tipo_registro,ano,mes,referencia,tipo_movimiento,registro) values(";
				$Insertar.="'1','$Ano','$Mes','$SAP_Lote','$SAP_TipoMov','$Linea')";
				mysqli_query($link, $Insertar);
				$L_SAP_CodMaterial = "";
				$L_SAP_UnidadPeso = "";
				$L_SAP_Centro = "";
				$L_SAP_FormaEmpaque01 = "";
				Homologar("46","1", $L_SAP_CodMaterial, $L_SAP_UnidadPeso, $L_SAP_Centro, $L_SAP_FormaEmpaque01, $link);
				$L_SAP_Tipo = "3";
				$L_SAP_CodMaterial = $SAP_CodMaterial;
				$L_SAP_Centro = $SAP_Centro;
				$L_SAP_Lote = $SAP_Lote;
				$L_SAP_Almacen = $SAP_Almacen;
				$L_SAP_IndActivo = "X";
				$L_SAP_FechaDisp = $SAP_FechaDoc;
				$L_SAP_LoteClasif = "X";
				$L_SAP_Leyes = "";					
				$L_SAP_PesoNeto =$Datos2[2];
				$L_SAP_PesoTara = 0;
				$L_SAP_PesoBruto =$Datos2[2];
				$L_SAP_CantDesp01 = 0;
				$L_SAP_CantDesp02 = "0";
				$L_SAP_FormaEmpaque02 = "";
				$L_SAP_LoteProd = $L_SAP_Lote;
				$L_SAP_Sello = "";
				$L_SAP_FechaProd = "";
				$L_SAP_TipoTransporte = "";
				$L_SAP_MarcaLote = "";
				$ArregloLeyes = array();
				DefinirArregloLeyes("46","1",$ArregloLeyes);		
				reset($ArregloLeyes);					
				//while (list($k,$Valor)=each($ArregloLeyes))
				foreach ($ArregloLeyes as $k => $Valores)
				{
					$L_SAP_Leyes = $L_SAP_Leyes.str_pad(number_format($Valor["valor"],3,',',''),15," ",STR_PAD_LEFT);
				}
				$LineaLeyes = str_pad($L_SAP_Tipo,1," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad($L_SAP_CodMaterial,18,"0",STR_PAD_LEFT);
				$LineaLeyes.= str_pad($L_SAP_Centro,4," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad($L_SAP_Lote,10," ");
				$LineaLeyes.= str_pad($L_SAP_Almacen,4," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad($L_SAP_IndActivo,1," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad($L_SAP_FechaDisp,10," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad($L_SAP_LoteClasif,1," ",STR_PAD_LEFT);
				$LineaLeyes.= $L_SAP_Leyes;
				$LineaLeyes.= str_pad(number_format($L_SAP_PesoBruto,3,",",""),15," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad(number_format($L_SAP_PesoNeto,3,",",""),15," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad(number_format($L_SAP_PesoTara,3,",",""),15," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad($L_SAP_UnidadPeso,15," ");
				$LineaLeyes.= str_pad($L_SAP_CantDesp01,15," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad($L_SAP_FormaEmpaque01,15," ");
				$LineaLeyes.= str_pad($L_SAP_CantDesp02,15," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad($L_SAP_FormaEmpaque02 ,15," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad($L_SAP_LoteProd,15," ");
				$LineaLeyes.= str_pad($L_SAP_FechaProd,15," ",STR_PAD_LEFT);							
				$LineaLeyes.= str_pad($L_SAP_TipoTransporte,15," ",STR_PAD_LEFT);
				$LineaLeyes.= str_pad($L_SAP_MarcaLote,15," ",STR_PAD_LEFT);			
				fwrite($ArchivoLeyes,$LineaLeyes."\r\n");
			}
			fclose($Archivo);
			fclose($ArchivoLeyes);
			$Mensaje='Archivos Creados Existosamente';
			break;
		case "CR"://GENERAR REGISTRO
			$SAP_FechaDoc = substr($TxtFechaCon,8,2).".".substr($TxtFechaCon,5,2).".".substr($TxtFechaCon,0,4);
			$SAP_TipoMov = $CmbMovimiento;
			$Valores=explode('~',$CmbOrden);
			$SAP_OrdenProd_Manual = $Valores[0];
			$SAP_Almacen= $CmbAlmacen;	
			$SAP_CodMaterial="425";
			$SAP_Cantidad=$TxtTonelaje;
			$SAP_Unidad="TO";
			$SAP_Lote=strtoupper(substr($Meses[(substr($TxtFechaCon,5,2))-1],0,4).substr($TxtFechaCon,3,1).$TxtLote);
			$SAP_ClaseValoriz_Manual = $Valores[1];
			
			$Linea = $SAP_FechaDoc."~~";
			$Linea.= $SAP_TipoMov."~~";
			$Linea.= $SAP_CodMaterial."~~";					
			$Linea.= $SAP_Cantidad."~~";
			$Linea.= $SAP_Unidad."~~";
			$Linea.= $SAP_Lote."~~";
			$Linea.= $SAP_OrdenProd_Manual."~~";
			$Linea.= $SAP_ClaseValoriz_Manual."~~";
			$Linea.= $SAP_Almacen;
			$Insertar="INSERT into interfaces_codelco.registro_traspaso (tipo_registro,ano,mes,referencia,tipo_movimiento,registro) values(";
			$Insertar.="'99','$Ano','$Mes','$SAP_Lote','$SAP_TipoMov','$Linea')";
			mysqli_query($link, $Insertar);
			$Mensaje='Archivos Creados Existosamente';
			break;
	}
	header("location:traspaso_embarque_acid_manual.php?Mostrar=S&Mensaje=".$Mensaje);
?>
