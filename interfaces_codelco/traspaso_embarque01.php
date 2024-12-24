<?php
	include("../principal/conectar_principal.php");
	include("funciones_interfaces_codelco.php");
	set_time_limit(2000);
	
	$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");

	$CmbMovimiento  = isset($_REQUEST["CmbMovimiento"])?$_REQUEST["CmbMovimiento"]:"921";
	$CmbOrden  = isset($_REQUEST["CmbOrden"])?$_REQUEST["CmbOrden"]:"";
	$CmbAlmacen  = isset($_REQUEST["CmbAlmacen"])?$_REQUEST["CmbAlmacen"]:"";
	$Orden        = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"L";
	$Producto     = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$CodProducto  = isset($_REQUEST["CodProducto"])?$_REQUEST["CodProducto"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Valores      = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	
	$ProdAux   = explode("~",$Valores);
	$ProdSel   = $ProdAux[0];
	$FechaHora = str_replace(" ","_",date("Y_m_d H_i"));
	$Eliminar  = 'delete from interfaces_codelco.tmp_archivo_embarque';
	
	switch ($Proceso)
	{
		case "G":
			
			mysqli_query($link, $Eliminar);$CorrIE=1;
			$Datos = explode("~~",$Valores);
			foreach($Datos as $k=>$v)
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
				$ArrResp =  RescataCatodos($Prod, $SubProd, $Ano, $Mes, $ArrResp, $LoteAux, $ArrRespLeyes, $Orden, $link);
				$Archivo1 = fopen("archivos_embarque/CAT_REGISTRO_1.doc","w+");
				$Archivo2 = fopen("archivos_embarque/CAT_REGISTRO_3.doc","w+");
				$Archivo3 = "";
				CreaArchivoLotePqte($Prod, $SubProd, $Ano, $Mes,$LoteAux,$IE,$Orden,$Archivo1,$Archivo2,$Archivo3,$SAP_TipoMov,$SAP_OrdenProd_Manual,$SAP_ClaseValoriz_Manual,$CorrIE,$link);
				$CorrIE=$CorrIE+1;
				reset($ArrResp);
				foreach($ArrResp as $k=>$Fila)
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
		
					$Lista = Homologar($Fila["cod_producto"], $Fila["cod_subproducto"], $L_SAP_CodMaterial, $L_SAP_UnidadPeso, $L_SAP_Centro, $L_SAP_FormaEmpaque01,$link);
					$valor = explode("**",$Lista);
					$L_SAP_CodMaterial    = $valor[0];
					$L_SAP_UnidadPeso     = $valor[1];
					$L_SAP_Centro         = $valor[2];
					$L_SAP_FormaEmpaque01 = $valor[3];
		
					$SAP_FechaDoc = substr($Fila["fecha_embarque"],8,2).".".substr($Fila["fecha_embarque"],5,2).".".substr($Fila["fecha_embarque"],0,4);
					$SAP_FechaCon = substr($Fila["fecha_embarque"],8,2).".".substr($Fila["fecha_embarque"],5,2).".".substr($Fila["fecha_embarque"],0,4);					
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
						$LineaLeyes=$LineaLeyes."\r\n";

						fwrite($Archivo2,$LineaLeyes);
						//INSERTA O ACTUALIZA EN BASE DE DATOS
						$Consulta = "select * from interfaces_codelco.registro_traspaso ";
						$Consulta.= " where tipo_registro='".$SAP_Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
						$Consulta.= " and referencia='".$L_SAP_Lote."' ";
						//echo $Consulta."<br>";
						$Resp2 = mysqli_query($link, $Consulta);		
						$Fecha1=substr($SAP_FechaDoc,6,4)."-".substr($SAP_FechaDoc,3,2)."-".substr($SAP_FechaDoc,0,2);
						$Fecha2=substr($SAP_FechaCon,6,4)."-".substr($SAP_FechaCon,3,2)."-".substr($SAP_FechaCon,0,2);
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
			header("location:traspaso_embarque_".strtolower($Producto).".php?Mes=".$Mes."&Ano=".$Ano."&Mostrar=S&CodProducto=".$CodProducto."&Producto=".$Producto."&Mensaje=".$Mensaje);
			break;			
			
		case "PMN":
				case "ACID":
			
			$ProdAux = explode("~",$Valores);
			$ProdSel=$ProdAux[0];
			$FechaHora = str_replace(" ","_",date("Y_m_d H_i"));
			$Archivo = fopen("archivos_embarque/".$Producto."_embarque_".$FechaHora.".doc","w+");
			$ArchivoLeyes = fopen("archivos_embarque/".$Producto."_leyes_embarque_".$FechaHora.".doc","w+");
			
			//$Archivo3 = fopen("archivos_embarque/CAT_embarque_leyes_".$FechaHora."_NEW.doc","w+");			
			$Datos = explode("~~",$Valores);
		//	echo "VALORES ".$Valores."<br>";
			foreach($Datos as $k=>$v)
			{
				$Linea = "";
				$Datos2 = explode("~",$v);				
				$ArrResp = array();
				$ArrRespLeyes = array();
				switch ($Producto)
				{
					case "CAT":
						$Prod = $Datos2[0];
						$SubProd = $Datos2[1];	
						$CodBulto = $Datos2[2];
						$NumBulto = $Datos2[3];
						$IE=$Datos2[4];
						$SAP_TipoMov = $Datos2[5];
						$SAP_OrdenProd_Manual = $Datos2[6];
						$SAP_ClaseValoriz_Manual = $Datos2[7];
						$SAP_Marca = $Datos2[8];
						$LoteAux = $CodBulto."/".$NumBulto."/".$SAP_Marca;
						//echo $Prod."-".$SubProd."-".$Ano."-".$Mes."-".$LoteAux."-".$Orden."<br>";
						$ArrResp = RescataCatodos($Prod, $SubProd, $Ano, $Mes, $ArrResp, $LoteAux, $ArrRespLeyes, $Orden,$link);
						break;
					case "PMN":
						$Prod = $Datos2[0];
						$SubProd = $Datos2[1];	
						$LoteAux = $Datos2[2];
						$SAP_TipoMov = $Datos2[3];
						$SAP_OrdenProd_Manual = $Datos2[4];
						$SAP_ClaseValoriz_Manual = $Datos2[5];		
						$SAP_Almacen_Manual= $Datos2[6];	
						$CEnvio=$Datos2[7];
						$CDisp=$Datos2[8];
						$CTotal=$Datos2[9];
						//echo $Valores."<br>";
						//echo $CEnvio." / ".$CDisp." / ".$CTotal."<BR>";
						$ArrResp = RescataPlamen($Prod, $SubProd, $Ano, $Mes, $ArrResp, $LoteAux, $ArrRespLeyes, $link);						
						break;
					case "ACID":
						$Prod = $Datos2[0];
						$SubProd = $Datos2[1];
						$NumBulto = $Datos2[2];
						$SAP_TipoMov = $Datos2[3];
						$SAP_OrdenProd_Manual = $Datos2[4];
						$SAP_ClaseValoriz_Manual = $Datos2[5];
						$SAP_Almacen_Manual= $Datos2[6];	
						$LoteAux = $NumBulto;		
						//echo $NumBulto."<br>";	
						$ArrResp = RescataAcido($Prod, $SubProd, $Ano, $Mes, $ArrResp, $LoteAux, $ArrRespLeyes, $Orden, $link);		
						break;
						
				}
				reset($ArrResp);
				foreach($ArrResp as $k=>$Fila)
				{			
					$SAP_Tipo = "1";	
					$SAP_FechaDoc = substr($Fila["fecha_embarque"],8,2).".".substr($Fila["fecha_embarque"],5,2).".".substr($Fila["fecha_embarque"],0,4);
					$SAP_FechaCon = substr($Fila["fecha_embarque"],8,2).".".substr($Fila["fecha_embarque"],5,2).".".substr($Fila["fecha_embarque"],0,4);					
 					
					$SAP_Centro = "";
					switch ($Producto)		
					{	
						case "CAT":
							$SAP_Almacen = $Fila["cod_almacen_codelco"];
							break;
						case "PMN":
						
							if ($SAP_Almacen_Manual!="")
								$SAP_Almacen = $SAP_Almacen_Manual;
							else
								$SAP_Almacen = "0203";
							break;
						case "ACID":
							if ($SAP_Almacen_Manual!="")
								$SAP_Almacen = $SAP_Almacen_Manual;
							else
								$SAP_Almacen = "0005";
							break;					
					}
					
					$SAP_OrdenProd = $SAP_OrdenProd_Manual;						
					$SAP_CodMaterial = "";
					$SAP_Cantidad = $Fila["peso"];
					$SAP_Unidad = "";
					switch ($Producto)
					{
						case "CAT":
							$SAP_Lote = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT).$Fila["corr_enm"];
							break;
						case "ACID":
							$SAP_Lote = $Fila["cod_bulto"].$Fila["corr_enm"];
							break;
						case "PMN":
							$SAP_Lote = $Fila["lote"];
							break;
					}
					$SAP_ClaseValoriz = "";
					$SAP_Status = "";
					$SAP_Msg = "";				
					
					$Lista = OrdenProduccionSap($Fila["asignacion"],$Fila["cod_producto"],$Fila["cod_subproducto"],$SAP_OrdenProd,$SAP_CodMaterial,$SAP_Unidad,$SAP_ClaseValoriz,$SAP_Centro,$link);								
					$valor = explode("**",$Lista);
					$SAP_OrdenProd    = $valor[0];
					$SAP_CodMaterial  = $valor[1];
					$SAP_Unidad       = $valor[2];
					$SAP_ClaseValoriz = $valor[3];
					$SAP_Centro       = $valor[4];
					if ($Prod=="29" && $SubProd=="4")//EMBARQUE PLATA
					{
						$can =0;$pes=0;
						$Ini=$Fila["caja_ini"];
						$Fin=$Fila["caja_fin"];
						$can = ($Fin - $Ini) + 1;
						$pes = $Fila["peso"] / $can;
						//echo "CAJAS=".$Ini." / ".$Fin;
						//$SAP_Cantidad=25;
						$SAP_Cantidad = $pes;
					}
					else
					{
						$Ini=1;
						$Fin=1;
					}
					for ($i=$Ini;$i<=$Fin;$i++)
					{
						if ($Fin>1)
							$SAP_Lote=$i;
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
					//	echo $Linea."<br>";
					}
					
					//ESCRIBE LEYES DEL LOTE
					$L_SAP_CodMaterial = "";
					$L_SAP_UnidadPeso = "";
					$L_SAP_Centro = "";
					$L_SAP_FormaEmpaque01 = "";
					$Lista = Homologar($Fila["cod_producto"], $Fila["cod_subproducto"], $L_SAP_CodMaterial, $L_SAP_UnidadPeso, $L_SAP_Centro, $L_SAP_FormaEmpaque01, $link);
					$valor = explode("**",$Lista);
					$L_SAP_CodMaterial    = $valor[0];
					$L_SAP_UnidadPeso     = $valor[1];
					$L_SAP_Centro         = $valor[2];
					$L_SAP_FormaEmpaque01 = $valor[3];
					//echo "aquiiiiiiiiiiiiiiiiii".$Prod;
					$L_SAP_Tipo = "3";
					$L_SAP_CodMaterial = $SAP_CodMaterial;
					$L_SAP_Centro = $SAP_Centro;
					$L_SAP_Lote = $SAP_Lote;
					$L_SAP_Almacen = $SAP_Almacen;
					$L_SAP_IndActivo = "X";
					$L_SAP_FechaDisp = $SAP_FechaDoc;
					$L_SAP_LoteClasif = "X";
					$L_SAP_Leyes = "";
					$L_SAP_PesoNeto = $Fila["peso"];
					$L_SAP_PesoTara = $Fila["num_paquetes"];
                    // todos los restos  if ($Prod=="19" && $SubProd=="22")
					 if ($Prod=="19")
                     {
                        $L_SAP_PesoBruto = ($Fila["peso"] + $Fila["num_paquetes"]);//* 2);
                     }
                     else
                     {
                         $L_SAP_PesoBruto = ($Fila["peso"] + $Fila["num_paquetes"]);
                      }
					//echo $L_SAP_PesoBruto."-".$L_SAP_PesoTara."-".$L_SAP_PesoNeto."<br>";
					//$L_SAP_UnidadPeso = "";					
					//$L_SAP_FormaEmpaque01 = "";
					if ($Producto=="CAT")
					{
						$L_SAP_CantDesp01 = $Fila["num_paquetes"]*1000;
						$L_SAP_CantDesp02 = $Fila["num_unidades"];
						$L_SAP_FormaEmpaque02 = "06";
					}
					else
					{
						$L_SAP_CantDesp01 = $Fila["num_unidades"];
						$L_SAP_CantDesp02 = "0";
						$L_SAP_FormaEmpaque02 = "";
					}
					$L_SAP_LoteProd = $L_SAP_Lote;
					$L_SAP_Sello = $Fila["sello"];
					$L_SAP_FechaProd = "";  
					$L_SAP_TipoTransporte = "";
					$L_SAP_MarcaLote = $Fila["descrip_marca"];
					reset($ArrRespLeyes);
					$pesoseco=0;
					foreach($ArrRespLeyes as $k=>$Valor)
					{
					   if ($Valor["cod_leyes"]=="01")
					   {
					   		$pesoseco = $L_SAP_PesoNeto - (($L_SAP_PesoNeto * $Valor["valor"]) / 100);
					   }
						if ($Prod=="19" && ($Valor["cod_leyes"] == '08' || $Valor["cod_leyes"] == '39' || $Valor["cod_leyes"] == '40'))
					   		$Valor["valor"] = $Valor["valor"] / 10000;
						$L_SAP_Leyes = $L_SAP_Leyes.str_pad(number_format($Valor["valor"],3,',',''),15," ",STR_PAD_LEFT);	
						//echo "leyes".$L_SAP_Leyes."--".$Valor["cod_leyes"]."</br>";
					}
					
					if ($Prod=="29" && $SubProd=="4")//EMBARQUE PLATA
					{
						$can=0;$pes=0;
						$Ini=$Fila["caja_ini"];
						$Fin=$Fila["caja_fin"];
						$can = ($Fin - $Ini) + 1;
						$pes = $Fila["peso"] / $can;
						if ($pes<>25)
						{
							$L_SAP_PesoBruto = 2.2;
							$L_SAP_PesoNeto = $pes;
							$L_SAP_PesoTara = 0.2;
						}
						else
						{
							$L_SAP_PesoBruto = 26.4;
							$L_SAP_PesoNeto = $pes;
							$L_SAP_PesoTara = 1.4;
						}
					}					
					else
					{
						$Ini=1;    
						$Fin=1;
					}
					
					//poly 11-06-2009 no estaba subproducto 6 de la escoria plamen solo trof
					if (($Prod=="28"  && ($SubProd=="1" || $SubProd=="6")) || ($Prod=="31" && $SubProd=="1") || ($Prod=="33" && $SubProd=="2"))
					{
						//echo "EE".$L_SAP_Leyes;
						$L_SAP_PesoBruto = (($Fila["peso"] * 1) + ($Fila["peso_tara"] * 1 ));
						$L_SAP_PesoNeto = $Fila["peso"] * 1;
						$L_SAP_PesoTara = $Fila["peso_tara"];
					}
				//echo $Ini." / ".$Fin."<br>";
					for ($i=$Ini;$i<=$Fin;$i++)  
					{
						//echo "acaca<br>";
						if ($Fin>1)
						{  
							$L_SAP_Lote=$i;
							$L_SAP_LoteProd=$i;
						}
					//	echo "LOTE".$L_SAP_Lote."<br>";
					//	echo "POLY".$L_SAP_Leyes."<br>";
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
						$LineaLeyes.= str_pad(number_format($L_SAP_Leyes,3,",",""),15," ",STR_PAD_LEFT);
						
					
						
			//peso seco	
	//	echo "seco-leyes".$pesoseco."--".$L_SAP_Leyes."<br>";
						if ($Fila["cod_producto"]=="33" || $Fila["cod_producto"]=="28" || $Fila["cod_producto"]=="31" || $Fila["cod_producto"]=="47")
							$LineaLeyes.= str_pad(number_format($pesoseco,3,",",""),15," ",STR_PAD_LEFT);
							
							// AGREGADO POR ADAN 22/07/2013
					/*		if($Fila["cod_producto"]==25)
							{			
								$ConsultaTARROS="select count(*) as Cantidad from pmn_web.pmn_pesa_bad_detalle where lote='".$L_SAP_Lote."' and palet_a_b is not null and MONTH(fecha_embarque)='".$Mes."' and year(fecha_embarque)='".$Ano."'";
								//echo $ConsultaTARROS."<br>";
								$RespCantTambor=mysqli_query($link, $ConsultaTARROS);
								if($FilaCantTambor=mysqli_fetch_array($RespCantTambor))
								{
								$DESCUENTO_PESO_TAMBOR=intval($FilaCantTambor["Cantidad"])*9.5;
								}
								$PESO_SECO=$L_SAP_PesoNeto-$DESCUENTO_PESO_TAMBOR;
								$LineaLeyes.= str_pad(number_format($PESO_SECO,3,",",""),15," ",STR_PAD_LEFT);
								/*echo "PESO NETO ".$L_SAP_PesoNeto."<br>";
								echo "DESCUENTO_PESO_TAMBOR ".$DESCUENTO_PESO_TAMBOR."<br>";
								echo "PESO_SECO".$PESO_SECO."<br>";
							}*/
							
						$LineaLeyes.= str_pad($L_SAP_UnidadPeso,15," ");
						$LineaLeyes.= str_pad($L_SAP_CantDesp01,15," ",STR_PAD_LEFT);
						$LineaLeyes.= str_pad($L_SAP_FormaEmpaque01,15," ");
						//aquiii esta la onda echo $L_SAP_UnidadPeso;
						if ($Fila["cod_producto"]=="48")
						{
						//echo "uno";"<br>";
							$LineaLeyes.= str_pad(" ",15," ",STR_PAD_LEFT);
							$LineaLeyes.= str_pad(" ",15," ",STR_PAD_LEFT);
						}
						else
						{
						//echo "dos";"<br>";
							$LineaLeyes.= str_pad($L_SAP_CantDesp02,15," ",STR_PAD_LEFT);
							$LineaLeyes.= str_pad($L_SAP_FormaEmpaque02 ,15," ",STR_PAD_LEFT);
							
						}
						$LineaLeyes.= str_pad($L_SAP_LoteProd,15," ");
						//echo "lote".$L_SAP_LoteProd;
						if ($Prod=="34" )//EMBARQUE SELLO SOLO PARA EL ORO
						{
					//	echo "tres";"<br>";
							//$LineaLeyes.= str_pad($L_SAP_MarcaLote,3," ",STR_PAD_LEFT);	
							//$LineaLeyes.= str_pad($L_SAP_Sello,30," ",STR_PAD_LEFT);								
							$LineaLeyes.= str_pad($L_SAP_LoteProd,15," ");	
							$LineaLeyes.= str_pad(str_replace(" ","",$L_SAP_Sello),18," ",STR_PAD_LEFT);
						}
						else
						{
					//	echo "cuatro";"<br>";
							$LineaLeyes.= str_pad($L_SAP_FechaProd,15," ",STR_PAD_LEFT);							
							$LineaLeyes.= str_pad($L_SAP_TipoTransporte,15," ",STR_PAD_LEFT);
							$LineaLeyes.= str_pad($L_SAP_MarcaLote,15," ",STR_PAD_LEFT);			
						}
						//echo "Archivo Leyes  ".$LineaLeyes."<br>";
						fwrite($ArchivoLeyes,$LineaLeyes."\r\n");
						
						//INSERTA O ACTUALIZA EN BASE DE DATOS
						$Consulta = "select * from interfaces_codelco.registro_traspaso ";
						$Consulta.= " where tipo_registro='".$SAP_Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
						$Consulta.= " and referencia='".$L_SAP_Lote."' ";
						//echo $Consulta."<br>";
						$Resp2 = mysqli_query($link, $Consulta);		
						$Fecha1=substr($SAP_FechaDoc,6,4)."-".substr($SAP_FechaDoc,3,2)."-".substr($SAP_FechaDoc,0,2);
						$Fecha2=substr($SAP_FechaCon,6,4)."-".substr($SAP_FechaCon,3,2)."-".substr($SAP_FechaCon,0,2);
						if ($Fila2 = mysqli_fetch_array($Resp2))
						{
							if ($Prod=="29")
							{
								//INSERTA NUEVO REGISTRO
								$Actualizar = "update interfaces_codelco.registro_traspaso SET ";
								$Actualizar.= " tipo_registro='".$SAP_Tipo."', ano='".$Ano."', mes='".$Mes."', ";
								$Actualizar.= " referencia='".$L_SAP_Lote."', tipo_movimiento='".$SAP_TipoMov."', registro='".$Linea."',";
								$Actualizar.= " fecha_traspaso='".$Fecha2."', cantidad_traspaso='".$CantTraspaso."', ";
								$Actualizar.= " orden_produccion='".$SAP_OrdenProd_Manual."', ";
								$Actualizar.= " clase_valorizacion='".$SAP_ClaseValoriz_Manual."', almacen='".$L_SAP_Almacen."' ";
								$Actualizar.= " where tipo_registro='".$SAP_Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
								$Actualizar.= " and referencia='".$L_SAP_Lote."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."' ";
								$Actualizar.= " and fecha_guia='".$Fecha1."'";
								mysqli_query($link, $Actualizar);
								//echo $Actualizar;
							}
							else
							{
								//ACTUALIZA REGISTRO EXISTENTE
								$Actualizar = "update interfaces_codelco.registro_traspaso set ";
								$Actualizar.= " tipo_movimiento='".$SAP_TipoMov."', registro='".$Linea."' ";
								$Actualizar.= " where tipo_registro='".$SAP_Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
								$Actualizar.= " and referencia='".$L_SAP_Lote."' ";
								mysqli_query($link, $Actualizar);
								//echo $Actualizar."<br>";
							}
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
			fclose($Archivo);
			fclose($ArchivoLeyes);   
			$Mensaje='Archivos Creados Existosamente'; //WSO
			header("location:traspaso_embarque_".strtolower($Producto).".php?Mes=".$Mes."&Ano=".$Ano."&Mostrar=S&CodProducto=".$CodProducto."&Producto=".$Producto."&Mensaje=".$Mensaje);
			break;
	}

			$ProdAux = explode("~",$Valores);
			$ProdSel=$ProdAux[0];
			$FechaHora = str_replace(" ","_",date("Y_m_d H_i"));
			$Archivo = fopen("archivos_embarque/".$Producto."_embarque_".$FechaHora.".doc","w+");
			$ArchivoLeyes = fopen("archivos_embarque/".$Producto."_leyes_embarque_".$FechaHora.".doc","w+");
			
			//$Archivo3 = fopen("archivos_embarque/CAT_embarque_leyes_".$FechaHora."_NEW.doc","w+");			
			$Datos = explode("~~",$Valores);
		//	echo $Valores."<br>";
			foreach($Datos as $k=>$v)
			{
				$Linea = "";
				$Datos2 = explode("~",$v);				
				$ArrResp = array();
				$ArrRespLeyes = array();
				switch ($Producto)
				{
					case "CAT":
						$Prod = $Datos2[0];
						$SubProd = $Datos2[1];	
						$CodBulto = $Datos2[2];
						$NumBulto = $Datos2[3];
						$IE=$Datos2[4];
						$SAP_TipoMov = $Datos2[5];
						$SAP_OrdenProd_Manual = $Datos2[6];
						$SAP_ClaseValoriz_Manual = $Datos2[7];
						$SAP_Marca = $Datos2[8];
						$LoteAux = $CodBulto."/".$NumBulto."/".$SAP_Marca;
						//echo $Prod."-".$SubProd."-".$Ano."-".$Mes."-".$LoteAux."-".$Orden."<br>";
						$ArrResp = RescataCatodos($Prod, $SubProd, $Ano, $Mes, $ArrResp, $LoteAux, $ArrRespLeyes, $Orden, $link);
						break;
					case "PMN":
						$Prod = $Datos2[0];
						$SubProd = $Datos2[1];	
						$LoteAux = $Datos2[2];
						$SAP_TipoMov = $Datos2[3];
						$SAP_OrdenProd_Manual = $Datos2[4];
						$SAP_ClaseValoriz_Manual = $Datos2[5];		
						$SAP_Almacen_Manual= $Datos2[6];	
						$CEnvio=$Datos2[7];
						$CDisp=$Datos2[8];
						$CTotal=$Datos2[9];
						//echo $Valores."<br>";
						//echo $CEnvio." / ".$CDisp." / ".$CTotal."<BR>";
						$ArrResp = RescataPlamen($Prod, $SubProd, $Ano, $Mes, $ArrResp, $LoteAux, $ArrRespLeyes, $link);						
						break;
					case "ACID":
						$Prod = $Datos2[0];
						$SubProd = $Datos2[1];
						$NumBulto = $Datos2[2];
						$SAP_TipoMov = $Datos2[3];
						$SAP_OrdenProd_Manual = $Datos2[4];
						$SAP_ClaseValoriz_Manual = $Datos2[5];
						$SAP_Almacen_Manual= $Datos2[6];	
						$LoteAux = $NumBulto;		
						//echo $NumBulto."<br>";	
						$ArrResp = RescataAcido($Prod, $SubProd, $Ano, $Mes, $ArrResp, $LoteAux, $ArrRespLeyes, $Orden, $link);		
						break;
						
				}
				reset($ArrResp);
				foreach($ArrResp as $k=>$Fila)
				{			
					$SAP_Tipo = "1";	
					$SAP_FechaDoc = substr($Fila["fecha_embarque"],8,2).".".substr($Fila["fecha_embarque"],5,2).".".substr($Fila["fecha_embarque"],0,4);
					$SAP_FechaCon = substr($Fila["fecha_embarque"],8,2).".".substr($Fila["fecha_embarque"],5,2).".".substr($Fila["fecha_embarque"],0,4);					
 					
					$SAP_Centro = "";
					switch ($Producto)		
					{	
						case "CAT":
							$SAP_Almacen = $Fila["cod_almacen_codelco"];
							break;
						case "PMN":
						
							if ($SAP_Almacen_Manual!="")
								$SAP_Almacen = $SAP_Almacen_Manual;
							else
								$SAP_Almacen = "0203";
							break;
						case "ACID":
							if ($SAP_Almacen_Manual!="")
								$SAP_Almacen = $SAP_Almacen_Manual;
							else
								$SAP_Almacen = "0005";
							break;					
					}
					
					$SAP_OrdenProd = $SAP_OrdenProd_Manual;						
					$SAP_CodMaterial = "";
					$SAP_Cantidad = $Fila["peso"];
					$SAP_Unidad = "";
					switch ($Producto)
					{
						case "CAT":
							$SAP_Lote = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT).$Fila["corr_enm"];
							break;
						case "ACID":
							$SAP_Lote = $Fila["cod_bulto"].$Fila["corr_enm"];
							break;
						case "PMN":
							$SAP_Lote = $Fila["lote"];
							break;
					}
					$SAP_ClaseValoriz = "";
					$SAP_Status = "";
					$SAP_Msg = "";				
					
					$Lista = OrdenProduccionSap($Fila["asignacion"],$Fila["cod_producto"],$Fila["cod_subproducto"],$SAP_OrdenProd,$SAP_CodMaterial,$SAP_Unidad,$SAP_ClaseValoriz,$SAP_Centro,$link);								
					$valor = explode("**",$Lista);
					$SAP_OrdenProd    = $valor[0];
					$SAP_CodMaterial  = $valor[1];
					$SAP_Unidad       = $valor[2];
					$SAP_ClaseValoriz = $valor[3];
					$SAP_Centro       = $valor[4];
		
					if ($Prod=="29" && $SubProd=="4")//EMBARQUE PLATA
					{
						$can =0;$pes=0;
						$Ini=$Fila["caja_ini"];
						$Fin=$Fila["caja_fin"];
						$can = ($Fin - $Ini) + 1;
						$pes = $Fila["peso"] / $can;
						//echo "CAJAS=".$Ini." / ".$Fin;
						//$SAP_Cantidad=25;
						$SAP_Cantidad = $pes;
					}
					else
					{
						$Ini=1;
						$Fin=1;
					}
					for ($i=$Ini;$i<=$Fin;$i++)
					{
						if ($Fin>1)
							$SAP_Lote=$i;
							
				/*			echo $SAP_Tipo."<br>";
							echo $SAP_FechaDoc."<br>";
							echo $SAP_FechaCon."<br>";
							echo $SAP_TipoMov."<br>";
							echo $SAP_Centro."<br>";
							echo $SAP_Almacen."<br>";
							echo $SAP_OrdenProd_Manual."<br>";
							echo $SAP_CodMaterial."<br>";
							echo $SAP_Cantidad."<br>";
							echo $SAP_Unidad."<br>";
							echo $SAP_Lote."<br>";
							echo $SAP_ClaseValoriz_Manual."<br>";
							echo $SAP_Status."<br>";
							echo $SAP_Msg."<br>";
							
					
							*/
							
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
				//		echo "1 archivo:   ".$Linea."<br>";
					}
					
					//ESCRIBE LEYES DEL LOTE
					$L_SAP_CodMaterial = "";
					$L_SAP_UnidadPeso = "";
					$L_SAP_Centro = "";
					$L_SAP_FormaEmpaque01 = "";
					$Lista = Homologar($Fila["cod_producto"], $Fila["cod_subproducto"], $L_SAP_CodMaterial, $L_SAP_UnidadPeso, $L_SAP_Centro, $L_SAP_FormaEmpaque01, $link);
					$valor = explode("**",$Lista);
					$L_SAP_CodMaterial    = $valor[0];
					$L_SAP_UnidadPeso     = $valor[1];
					$L_SAP_Centro         = $valor[2];
					$L_SAP_FormaEmpaque01 = $valor[3];
	
					//echo "aquiiiiiiiiiiiiiiiiii".$Prod;
					$L_SAP_Tipo = "3";
					$L_SAP_CodMaterial = $SAP_CodMaterial;
					$L_SAP_Centro = $SAP_Centro;
					$L_SAP_Lote = $SAP_Lote;
					$L_SAP_Almacen = $SAP_Almacen;
					$L_SAP_IndActivo = "X";
					$L_SAP_FechaDisp = $SAP_FechaDoc;
					$L_SAP_LoteClasif = "X";
					$L_SAP_Leyes = "";
					$L_SAP_PesoNeto = $Fila["peso"];
					$L_SAP_PesoTara = $Fila["num_paquetes"];
                    // todos los restos  if ($Prod=="19" && $SubProd=="22")
					 if ($Prod=="19")
                     {
                        $L_SAP_PesoBruto = ($Fila["peso"] + $Fila["num_paquetes"]);//* 2);
                     }
                     else
                     {
                         $L_SAP_PesoBruto = ($Fila["peso"] + $Fila["num_paquetes"]);
                      }
					//echo $L_SAP_PesoBruto."-".$L_SAP_PesoTara."-".$L_SAP_PesoNeto."<br>";
					//$L_SAP_UnidadPeso = "";					
					//$L_SAP_FormaEmpaque01 = "";
					if ($Producto=="CAT")
					{
						$L_SAP_CantDesp01 = $Fila["num_paquetes"]*1000;
						$L_SAP_CantDesp02 = $Fila["num_unidades"];
						$L_SAP_FormaEmpaque02 = "06";
					}
					else
					{
						$L_SAP_CantDesp01 = $Fila["num_unidades"];
						$L_SAP_CantDesp02 = "0";
						$L_SAP_FormaEmpaque02 = "";
					}
					$L_SAP_LoteProd = $L_SAP_Lote;
					$L_SAP_Sello = $Fila["sello"];
					$L_SAP_FechaProd = "";  
					$L_SAP_TipoTransporte = "";
					$L_SAP_MarcaLote = $Fila["descrip_marca"];
					reset($ArrRespLeyes);
					$pesoseco=0;
					foreach($ArrRespLeyes as $k=>$Valor)
					{
					   if ($Valor["cod_leyes"]=="01")
					   {
						   $VALOR_HUMEDAD=$Valor["valor"];
					   		$pesoseco = $L_SAP_PesoNeto - (($L_SAP_PesoNeto * $Valor["valor"]) / 100);
					   }
						if ($Prod=="19" && ($Valor["cod_leyes"] == '08' || $Valor["cod_leyes"] == '39' || $Valor["cod_leyes"] == '40'))
					   		$Valor["valor"] = $Valor["valor"] / 10000;
						if ($Prod=="25" && ($Valor["cod_leyes"] == '27' || $Valor["cod_leyes"] == '44' || $Valor["cod_leyes"] == '50'))
					   		$Valor["valor"] = $Valor["valor"] * 10000;
							
						$L_SAP_Leyes = $L_SAP_Leyes.str_pad(number_format($Valor["valor"],3,',',''),15," ",STR_PAD_LEFT);	
						//echo "leyes".$L_SAP_Leyes."--".$Valor["cod_leyes"]."</br>";
					}
					
					if ($Prod=="29" && $SubProd=="4")//EMBARQUE PLATA
					{
						$can=0;$pes=0;
						$Ini=$Fila["caja_ini"];
						$Fin=$Fila["caja_fin"];
						$can = ($Fin - $Ini) + 1;
						$pes = $Fila["peso"] / $can;
						if ($pes<>25)
						{
							$L_SAP_PesoBruto = 2.2;
							$L_SAP_PesoNeto = $pes;
							$L_SAP_PesoTara = 0.2;
						}
						else
						{
							$L_SAP_PesoBruto = 26.4;
							$L_SAP_PesoNeto = $pes;
							$L_SAP_PesoTara = 1.4;
						}
					}					
					else
					{
						$Ini=1;    
						$Fin=1;
					}
					
					//poly 11-06-2009 no estaba subproducto 6 de la escoria plamen solo trof
					if (($Prod=="28"  && ($SubProd=="1" || $SubProd=="6")) || ($Prod=="31" && $SubProd=="1") || ($Prod=="33" && $SubProd=="2"))
					//if (($Prod=="28" && $SubProd=="1")  || (($Prod=="31" && $SubProd=="1"))
					{
						//echo "EE".$L_SAP_Leyes;
						$L_SAP_PesoBruto = (($Fila["peso"] * 1) + ($Fila["peso_tara"] * 1 ));
						$L_SAP_PesoNeto = $Fila["peso"] * 1;
						$L_SAP_PesoTara = $Fila["peso_tara"];
					}
	//				echo $Ini." / ".$Fin."<br>";
					for ($i=$Ini;$i<=$Fin;$i++)  
					{
						if ($Fin>1)
						{  
							$L_SAP_Lote=$i;
							$L_SAP_LoteProd=$i;
						}
					//	echo "LOTE".$L_SAP_Lote."<br>";
					//	echo "POLY".$L_SAP_Leyes."<br>";
						$LineaLeyes = str_pad($L_SAP_Tipo,1," ",STR_PAD_LEFT);
						$LineaLeyes.= str_pad($L_SAP_CodMaterial,18,"0",STR_PAD_LEFT);
						$LineaLeyes.= str_pad($L_SAP_Centro,4," ",STR_PAD_LEFT);
						$LineaLeyes.= str_pad($L_SAP_Lote,10," ");
						$LineaLeyes.= str_pad($L_SAP_Almacen,4," ",STR_PAD_LEFT);
						$LineaLeyes.= str_pad($L_SAP_IndActivo,1," ",STR_PAD_LEFT);
						$LineaLeyes.= str_pad($L_SAP_FechaDisp,10," ",STR_PAD_LEFT);
						$LineaLeyes.= str_pad($L_SAP_LoteClasif,1," ",STR_PAD_LEFT);
						$LineaLeyes.= $L_SAP_Leyes;
						//agregado por rene 27-08-2013
						if($Fila["cod_producto"]==25)
						{
								$CantidadTarros=0;
							$PESO_TAMBOR=0;
							$DESCUENTO_PESO_TAMBOR=0;
								$ConsultaTARROS="select count(*) as Cantidad from pmn_web.pmn_pesa_bad_detalle where lote='".$L_SAP_Lote."' and palet_a_b is not null and MONTH(fecha_embarque)='".$Mes."' and year(fecha_embarque)='".$Ano."'";
								//echo $ConsultaTARROS."<br>";
								$RespCantTambor=mysqli_query($link, $ConsultaTARROS);
								if($FilaCantTambor=mysqli_fetch_array($RespCantTambor))
								{
									$CantidadTarros=$FilaCantTambor["Cantidad"];
									$PESO_TAMBOR=intval($FilaCantTambor["Cantidad"])*9.5;
									$DESCUENTO_PESO_TAMBOR=intval($FilaCantTambor["Cantidad"])*9.5;
								}
								$PESO_SECO = (((100 - $VALOR_HUMEDAD) * $L_SAP_PesoNeto ) / 100);
								/*echo "PESO NETO ".$L_SAP_PesoNeto."<br>";
								echo "DESCUENTO_PESO_TAMBOR ".$DESCUENTO_PESO_TAMBOR."<br>";
								echo "PESO_SECO".$PESO_SECO."<br>";*/	
								$CPesoPalets="select peso_palet_a,peso_palet_b from pmn_web.pmn_pesa_bad_cabecera where lote='".$L_SAP_Lote."'";
								$RespPesoPalets=mysqli_query($link, $CPesoPalets);
								if($FilaPesoPalets=mysqli_fetch_array($RespPesoPalets))
								{
									
										$PESO_TOTAL_PALETS_A_B=$FilaPesoPalets["peso_palet_a"]+$FilaPesoPalets["peso_palet_b"];
								}
								if($PESO_TOTAL_PALETS_A_B>=0)
								{
									$Consulta="SELECT * FROM proyecto_modernizacion.clase WHERE cod_clase = '6005'";
									$RESPESO=mysqli_query($link, $Consulta);
									if($FPalets=mysqli_fetch_array($RESPESO))
									{
										$PESO_TOTAL_PALETS_A_B=$FPalets["valor1"];
									}
									else
									{
										$PESO_TOTAL_PALETS_A_B=27.5;
									}
									$NRO_PALET=1;	
									if($CantidadTarros>=5)
									{
										$NRO_PALET=2;	
									}	
									$PESO_TOTAL_PALETS_A_B=$PESO_TOTAL_PALETS_A_B*$NRO_PALET;
								}
								$NRO_PALET=1;	
								if($CantidadTarros>=5)
								{
									$NRO_PALET=2;	
								}
							
					   		$L_SAP_PesoTara=$PESO_TOTAL_PALETS_A_B+$PESO_TAMBOR;
								$L_SAP_PesoBruto=$L_SAP_PesoNeto+$PESO_TOTAL_PALETS_A_B+$PESO_TAMBOR;
								$L_SAP_UnidadPeso='KG';// UNIDAD DE PESO EN DURO
								$L_SAP_CantDesp01=$CantidadTarros; //CANTIDAD DE TARROS
								$L_SAP_FormaEmpaque01='21';// FORMAMA TAMBOR  VALOR EN DURO 21
								$L_SAP_CantDesp02=$NRO_PALET; //NRO DE PALET 
								$L_SAP_FormaEmpaque02='24';//FORMA DE EMPAQUE EN PALET VALOR EN DURO 24/
							$LineaLeyes.= str_pad(number_format($L_SAP_PesoBruto,3,",",""),15," ",STR_PAD_LEFT);
							$LineaLeyes.= str_pad(number_format($L_SAP_PesoNeto,3,",",""),15," ",STR_PAD_LEFT);
							$LineaLeyes.= str_pad(number_format($L_SAP_PesoTara,3,",",""),15," ",STR_PAD_LEFT);
							$LineaLeyes.= str_pad(number_format($PESO_SECO,3,",",""),15," ",STR_PAD_LEFT);
						}
						else						
						{	
						
						$LineaLeyes.= str_pad(number_format($L_SAP_PesoBruto,3,",",""),15," ",STR_PAD_LEFT);
						$LineaLeyes.= str_pad(number_format($L_SAP_PesoNeto,3,",",""),15," ",STR_PAD_LEFT);
						$LineaLeyes.= str_pad(number_format($L_SAP_PesoTara,3,",",""),15," ",STR_PAD_LEFT);
						}
					
						
			//peso seco	
		//	echo "seco-leyes".$pesoseco."--".$L_SAP_Leyes."<br>";
						if ($Fila["cod_producto"]=="33" || $Fila["cod_producto"]=="28" || $Fila["cod_producto"]=="31" || $Fila["cod_producto"]=="47" )
							$LineaLeyes.= str_pad(number_format($pesoseco,3,",",""),15," ",STR_PAD_LEFT);
						
						
						
						$LineaLeyes.= str_pad($L_SAP_UnidadPeso,15," ");
						$LineaLeyes.= str_pad($L_SAP_CantDesp01,15," ",STR_PAD_LEFT);
						$LineaLeyes.= str_pad($L_SAP_FormaEmpaque01,15," ");
						//aquiii esta la onda echo $L_SAP_UnidadPeso;
						if ($Fila["cod_producto"]=="48")
						{
						//echo "uno";"<br>";
							$LineaLeyes.= str_pad(" ",15," ",STR_PAD_LEFT);
							$LineaLeyes.= str_pad(" ",15," ",STR_PAD_LEFT);
						}
						else
						{
						//echo "dos";"<br>";
							$LineaLeyes.= str_pad($L_SAP_CantDesp02,15," ",STR_PAD_LEFT);
							$LineaLeyes.= str_pad($L_SAP_FormaEmpaque02 ,15," ",STR_PAD_LEFT);
							
						}
						$LineaLeyes.= str_pad($L_SAP_LoteProd,15," ");
						//echo "lote".$L_SAP_LoteProd;
						if ($Prod=="34" )//EMBARQUE SELLO SOLO PARA EL ORO
						{
					//	echo "tres";"<br>";
							//$LineaLeyes.= str_pad($L_SAP_MarcaLote,3," ",STR_PAD_LEFT);	
							//$LineaLeyes.= str_pad($L_SAP_Sello,30," ",STR_PAD_LEFT);								
							$LineaLeyes.= str_pad($L_SAP_LoteProd,15," ");	
							$LineaLeyes.= str_pad(str_replace(" ","",$L_SAP_Sello),18," ",STR_PAD_LEFT);
						}
						else
						{
					//	echo "cuatro";"<br>";
							$LineaLeyes.= str_pad($L_SAP_FechaProd,15," ",STR_PAD_LEFT);							
							$LineaLeyes.= str_pad($L_SAP_TipoTransporte,15," ",STR_PAD_LEFT);
							$LineaLeyes.= str_pad($L_SAP_MarcaLote,15," ",STR_PAD_LEFT);			
						}
						//echo "Linea".$LineaLeyes."<br>";
						fwrite($ArchivoLeyes,$LineaLeyes."\r\n");
						
						//INSERTA O ACTUALIZA EN BASE DE DATOS
						$Consulta = "select * from interfaces_codelco.registro_traspaso ";
						$Consulta.= " where tipo_registro='".$SAP_Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
						$Consulta.= " and referencia='".$L_SAP_Lote."' ";
						//echo $Consulta."<br>";
						$Resp2 = mysqli_query($link, $Consulta);		
						$Fecha1=substr($SAP_FechaDoc,6,4)."-".substr($SAP_FechaDoc,3,2)."-".substr($SAP_FechaDoc,0,2);
						$Fecha2=substr($SAP_FechaCon,6,4)."-".substr($SAP_FechaCon,3,2)."-".substr($SAP_FechaCon,0,2);
						if ($Fila2 = mysqli_fetch_array($Resp2))
						{
							if ($Prod=="29")
							{
								//INSERTA NUEVO REGISTRO
								$Actualizar = "update interfaces_codelco.registro_traspaso SET ";
								$Actualizar.= " tipo_registro='".$SAP_Tipo."', ano='".$Ano."', mes='".$Mes."', ";
								$Actualizar.= " referencia='".$L_SAP_Lote."', tipo_movimiento='".$SAP_TipoMov."', registro='".$Linea."',";
								$Actualizar.= " fecha_traspaso='".$Fecha2."', cantidad_traspaso='".$CantTraspaso."', ";
								$Actualizar.= " orden_produccion='".$SAP_OrdenProd_Manual."', ";
								$Actualizar.= " clase_valorizacion='".$SAP_ClaseValoriz_Manual."', almacen='".$L_SAP_Almacen."' ";
								$Actualizar.= " where tipo_registro='".$SAP_Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
								$Actualizar.= " and referencia='".$L_SAP_Lote."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."' ";
								$Actualizar.= " and fecha_guia='".$Fecha1."'";
								mysqli_query($link, $Actualizar);
								//echo $Actualizar;
							}
							else
							{
								//ACTUALIZA REGISTRO EXISTENTE
								$Actualizar = "update interfaces_codelco.registro_traspaso set ";
								$Actualizar.= " tipo_movimiento='".$SAP_TipoMov."', registro='".$Linea."' ";
								$Actualizar.= " where tipo_registro='".$SAP_Tipo."' and ano='".$Ano."' and mes='".$Mes."' ";
								$Actualizar.= " and referencia='".$L_SAP_Lote."' ";
								mysqli_query($link, $Actualizar);
								//echo $Actualizar."<br>";
							}
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
			fclose($Archivo);
			fclose($ArchivoLeyes);   


?>