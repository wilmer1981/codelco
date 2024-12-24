<?php 
	include("../principal/conectar_principal.php");
	include("funciones_interfaces_codelco.php");
	set_time_limit(2000);

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
    $Orden   = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$Producto    = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$CodProducto    = isset($_REQUEST["CodProducto"])?$_REQUEST["CodProducto"]:"";
	
	switch ($Proceso)
	{
		case "G":
			$ProdAux = explode("~",$Valores);
			$ProdSel=$ProdAux[0];
			$FechaHora = str_replace(" ","_",date("Y_m_d H_i"));
			$Eliminar='delete from interfaces_codelco.tmp_archivo_embarque';
			mysqli_query($link, $Eliminar);
			$CorrIE=1;
			$Datos = explode("~~",$Valores);
			//echo $Valores."<br>";
			//while (list($k,$v)=each($Datos))
			foreach ($Datos as $k => $v)
			{
				$Datos2 = explode("~",$v);				
				$ArrResp = array();
				$ArrRespLeyes = array();
				$Prod = $Datos2[0];
				$SubProd = $Datos2[1];	
				$CodBulto = $Datos2[2];
				$NumBulto = $Datos2[3];
				$IE=$Datos2[4];
				$SAP_TipoMov = $Datos2[5];
				$SAP_OrdenProd_Manual = $Datos2[6];
				$SAP_ClaseValoriz_Manual = $Datos2[7];
				$SAP_Marca = isset($Datos2[8])?$Datos2[8]:"";
				$LoteAux = $CodBulto."/".$NumBulto."/".$SAP_Marca;
				//echo $Prod."-".$SubProd."-".$Ano."-".$Mes."-".$LoteAux."-".$Orden."<br>";
				$ArrResp = RescataCatodosGradoA($Prod, $SubProd, $Ano, $Mes, $ArrResp, $LoteAux, $ArrRespLeyes, $Orden,$link);
				$Archivo1 = fopen("archivos_embarque/CAT_REGISTRO_GRADOA_1.doc","w+");
				$Archivo2 = fopen("archivos_embarque/CAT_REGISTRO_GRADOA_3.doc","w+");
				$Archivo3 = "";
				CreaArchivoLotePqte($Prod, $SubProd, $Ano, $Mes,$LoteAux,$IE,$Orden,$Archivo1,$Archivo2,$Archivo3,$SAP_TipoMov,$SAP_OrdenProd_Manual,$SAP_ClaseValoriz_Manual,$CorrIE,$link);
				$CorrIE=$CorrIE+1;
				reset($ArrResp);
				//while (list($k,$Fila)=each($ArrResp))
				foreach ($ArrResp as $k => $Fila)
				{			
					$SAP_Tipo = "1";	
					$SAP_Almacen = $Fila["cod_almacen_codelco"];
					$SAP_Cantidad = $Fila["peso"];
					$SAP_Lote = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT).$Fila["corr_enm"];
					$SAP_OrdenProd = "";
					$SAP_CodMaterial = "";
					$SAP_Unidad = "";
					$SAP_ClaseValoriz = "";
					$SAP_Centro = "";
					$Lista = OrdenProduccionSap($Fila["asignacion"],$Fila["cod_producto"],$Fila["cod_subproducto"],$SAP_OrdenProd,$SAP_CodMaterial,$SAP_Unidad,$SAP_ClaseValoriz,$SAP_Centro,$link);								
					$valor = explode("**",$Lista);
					$SAP_OrdenProd    = $valor[0];
					$SAP_CodMaterial  = $valor[1];
					$SAP_Unidad       = $valor[2];
					$SAP_ClaseValoriz = $valor[3];
					$SAP_Centro       = $valor[4];	
					
					$L_SAP_CodMaterial    = "";
					$L_SAP_UnidadPeso     = "";
					$L_SAP_Centro         = "";
					$L_SAP_FormaEmpaque01 = "";
					$Lista = Homologar($Fila["cod_producto"], $Fila["cod_subproducto"], $L_SAP_CodMaterial, $L_SAP_UnidadPeso, $L_SAP_Centro, $L_SAP_FormaEmpaque01,$link);
					$valor = explode("**",$Lista);
					$L_SAP_CodMaterial    = $valor[0];
					$L_SAP_UnidadPeso     = $valor[1];
					$L_SAP_Centro         = $valor[2];
					$L_SAP_FormaEmpaque01 = $valor[3];
	
					$L_SAP_Tipo = "3";
					$L_SAP_Lote = $SAP_Lote;
					$L_SAP_Almacen = $SAP_Almacen;
					$Ini=1;    
					$Fin=1;
					for ($i=$Ini;$i<=$Fin;$i++)  
					{
						if ($Fin>1)
						{  
							$L_SAP_Lote=$i;
							$L_SAP_LoteProd=$i;
						}
						fwrite($Archivo2,$LineaLeyes."\r\n");
						//INSERTA O ACTUALIZA EN BASE DE DATOS
						$Consulta = "select * from interfaces_codelco.registro_traspaso ";
						$Consulta.= " where tipo_registro='".$SAP_Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
						$Consulta.= " and referencia='".$L_SAP_Lote."' ";
						//echo $Consulta."<br>";
						$Resp2 = mysqli_query($link, $Consulta);		
						$Fecha1=substr($SAP_FechaDoc,6,4)."-".substr($SAP_FechaDoc,3,2)."-".substr($SAP_FechaDoc,0,2);
						$Fecha2=substr($SAP_FechaCon,6,4)."-".substr($SAP_FechaCon,3,2)."-".substr($SAP_FechaCon,0,2);
						if($Fecha1=='--')
							$Fecha1='0000-00-00';
						if($Fecha2=='--')
							$Fecha2='0000-00-00';
						if ($Fila2 = mysqli_fetch_array($Resp2))
						{
							//ACTUALIZA REGISTRO EXISTENTE
							$Actualizar = "update interfaces_codelco.registro_traspaso set ";
							$Actualizar.= " tipo_movimiento='".$SAP_TipoMov."', registro='".$Linea."' ";
							$Actualizar.= " where tipo_registro='".$SAP_Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
							$Actualizar.= " and referencia='".$L_SAP_Lote."' ";
							mysqli_query($link, $Actualizar);
							//echo $Actualizar."<br>";
						}
						else
						{
							//INSERTA NUEVO REGISTRO
							$Insertar = "insert into interfaces_codelco.registro_traspaso(tipo_registro, ano, mes, referencia, tipo_movimiento, registro, ";
							$Insertar.= " fecha_guia, fecha_traspaso, cantidad_traspaso, cod_producto, cod_subproducto, orden_produccion, clase_valorizacion, almacen) ";
							$Insertar.= " values('".$SAP_Tipo."','".$Ano."','".$Mes."','".$L_SAP_Lote."','".$SAP_TipoMov."','".$Linea."', ";
							$Insertar.= " '".$Fecha1."', '".$Fecha2."', '".$CantTraspaso."', '".$Prod."', '".$SubProd."', '".$SAP_OrdenProd_Manual."', '".$SAP_ClaseValoriz_Manual."', '".$L_SAP_Almacen."')";
							mysqli_query($link, $Insertar);
							//echo $Insertar."<br>";
						}
					} //FINAL DEL CICLO FOR
				
				}
			}
			CreaArchivoTxt($Archivo1,$Archivo2,$link);
			fclose($Archivo1);							
			fclose($Archivo2);
			$Mensaje='Archivos Creados Existosamente';
	   		header("location:traspaso_embarque_catodo.php?Mes=".$Mes."&Ano=".$Ano."&Mostrar=S&CodProducto=".$CodProducto."&Producto=".$Producto."&Mensaje=".$Mensaje);
			
			break;
	}
?>