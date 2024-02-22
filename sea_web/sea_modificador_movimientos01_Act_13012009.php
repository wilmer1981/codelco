<?php	
	include ("../principal/conectar_sea_web.php");

	if ($proceso == "B")
	{
		if ($ok != "S")
			$txtbuscar = $txthornada;
			
		if ($tipo_mov == 1)
		{
			$consulta = "SELECT DISTINCT hornada FROM sea_web.movimientos";
 			$consulta = $consulta." WHERE cod_producto = 17 AND cod_subproducto = ".$cmbsubprod;
			$consulta = $consulta." AND tipo_movimiento = 1 AND SUBSTRING(hornada,7,6) = '".$txtbuscar."'";
			$consulta = $consulta." ORDER BY hornada DESC"; 							
			$consulta = $consulta." LIMIT 0,1";						
		}
		else if ($tipo_mov == 2)
			{
				$consulta = "SELECT DISTINCT hornada FROM sea_web.movimientos";
				$consulta = $consulta." WHERE cod_producto = 19 AND cod_subproducto = ".$cmbsubprod;
				$consulta = $consulta." AND tipo_movimiento = 3 AND SUBSTRING(hornada,7,6) = '".$txtbuscar."'";
				$consulta = $consulta." ORDER BY hornada DESC"; 
				$consulta = $consulta." LIMIT 0,1";								
			}
		else if ($tipo_mov == 3)
			{
				$consulta = "SELECT DISTINCT hornada FROM sea_web.movimientos";
				$consulta = $consulta." WHERE cod_producto = 17 AND cod_subproducto = ".$cmbsubprod;
				$consulta = $consulta." AND tipo_movimiento = 4 AND SUBSTRING(hornada,7,6) = '".$txtbuscar."'";
				$consulta = $consulta." ORDER BY hornada DESC"; 
				$consulta = $consulta." LIMIT 0,1";
			}
		else if ($tipo_mov == 4)
			{
				$consulta = "SELECT DISTINCT hornada FROM sea_web.movimientos";
				$consulta = $consulta." WHERE cod_producto = 19 AND cod_subproducto = ".$cmbsubprod;
				$consulta = $consulta." AND tipo_movimiento = 4 AND SUBSTRING(hornada,7,6) = '".$txtbuscar."'";
				$consulta = $consulta." ORDER BY hornada DESC";
				$consulta = $consulta." LIMIT 0,1";
				//echo $consulta;
			}	
				
		$rs1 = mysqli_query($link, $consulta);
		$row1 = mysqli_fetch_array($rs1);
		if (!is_null($row1[hornada]))
		{
			$cmbhornada = $row1[hornada];
		}
		else 
		{	
			$linea1 = "recargapag1=S&radio1=".$tipo_mov."&cmbsubprod=".$cmbsubprod;	
			header("Location:sea_modificador_movimientos.php?".$linea1);
			break;		
		}
				
		//Busca el peso promedio de la Hornada.
		if ($tipo_mov == 1 or $tipo_mov == 3)
			$producto = 17;
		else 
			$producto = 19;
		
		$consulta = "SELECT ROUND((peso_unidades / unidades),9) AS peso_promedio FROM sea_web.hornadas WHERE cod_producto = ".$producto." AND cod_subproducto = ".$cmbsubprod;
		$consulta = $consulta." AND hornada_ventana = ".$cmbhornada;
		//echo $consulta."<br>";
		
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		
		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002 AND valor_subclase2 = '".$cmbsubprod."'";
		$rs5 = mysqli_query($link, $consulta);
		if ($row5 = mysqli_fetch_array($rs5))
			$tipo_prod ="H";
		else
			$tipo_prod ="C";
		
		$linea = "recargapag3=S&recargapag2=S&recargapag1=S&radio1=".$tipo_mov."&cmbsubprod=".$cmbsubprod."&peso_prom=".$row[peso_promedio];
		$linea = $linea."&cmbhornada=".$cmbhornada."&txtbuscar=".$txtbuscar."&mostrar=S&tipo_prod=".$tipo_prod;
		header("Location:sea_modificador_movimientos.php?".$linea);
	}


	if ($proceso == "G")	
	{
//		echo $parametros."<br>";
		$HoraAux=date('G');
		$MinAux=date('i');
		if ($tipo_mov == 1 or $tipo_mov == 3)
			$producto = 17;
		else 
			$producto = 19;
		
		$arreglo = explode('~',$parametros);
		$valor[0] = explode('/',$arreglo[0]); //Movimiento Original. (0: fecha, 1: tipo mov, 2: unidades, 3:campo2, 4: campo1, 5: flujo, 6: numero_recarga, 7: cod_producto, 8: fecha_benef, 9: peso).
		$valor[1] = explode('/',$arreglo[1]); //Movmiento Modificado.(0: fecha, 1: tipo mov, 2: unidades, 3:campo2, 4: campo1, 5: flujo, 6: numero_recarga, 7: peso).		
		

//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	$valida_fecha_movimiento = $valor[0][0];
	include("sea_valida_mes.php");
//*******************************************************************************//


//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	$valida_fecha_movimiento = $valor[1][0];
	include("sea_valida_mes.php");
//*******************************************************************************//

		if ($tipo_mov == 4) //Resto a RAF.
		{
			$FechaHora=$valor[1][0]." ".$HoraAux.":".$MinAux;
			$actualizar = "UPDATE sea_web.movimientos SET fecha_movimiento = '".$valor[1][0]."',hora='".$FechaHora."'";
			$actualizar = $actualizar." WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$cmbsubprod;
			$actualizar = $actualizar." AND hornada = ".$cmbhornada." AND fecha_movimiento = '".$valor[0][0]."'";
			$actualizar = $actualizar." AND campo2 = '".$valor[0][3]."' AND fecha_benef = '".$valor[0][8]."'";
			mysqli_query($link, $actualizar);
			//echo $actualizar."<br>";			
		}
		else if ($tipo_mov == 3) //Anodos a RAF.
		{
			$FechaHora=$valor[1][0]." ".$HoraAux.":".$MinAux;
			//Modifica el tipo 4.
			$actualizar = "UPDATE sea_web.movimientos SET unidades = '".$valor[1][2]."', peso = '".$valor[1][7]."', fecha_movimiento = '".$valor[1][0]."',hora='".$FechaHora."'";
			$actualizar = $actualizar." WHERE tipo_movimiento = 4 AND cod_producto = 17 AND cod_subproducto = ".$cmbsubprod;
			$actualizar = $actualizar." AND hornada = ".$cmbhornada." AND fecha_movimiento = '".$valor[0][0]."' AND unidades = ".$valor[0][2]." AND peso = ".$valor[0][9];
			mysqli_query($link, $actualizar);
			//echo $actualizar."<br>";
						
			//Modifica el tipo 7.
			$actualizar = "UPDATE sea_web.movimientos SET unidades = '".$valor[1][2]."', peso = '".$valor[1][7]."', fecha_movimiento = '".$valor[1][0]."',hora='".$FechaHora."'";
			$actualizar = $actualizar." WHERE tipo_movimiento = 7 AND cod_producto = 17 AND cod_subproducto = ".$cmbsubprod;
			$actualizar = $actualizar." AND hornada = ".$cmbhornada." AND fecha_movimiento = '".$valor[0][0]."' AND unidades = ".$valor[0][2]." AND peso = ".$valor[0][9];			
			mysqli_query($link, $actualizar);			
			//echo $actualizar."<br>";			
		}
		else
		{			
			$FechaHora=$valor[1][0]." ".$HoraAux.":".$MinAux;
			$actualizar = "UPDATE sea_web.movimientos SET unidades = ".$valor[1][2].", campo1 = '".$valor[1][4]."', campo2 = '".$valor[1][3]."',";
			$actualizar = $actualizar." fecha_movimiento = '".$valor[1][0]."',hora='".$FechaHora."', peso = ".$valor[1][7];
			$actualizar = $actualizar." WHERE tipo_movimiento = ".$valor[0][1]." AND cod_producto = ".$producto." AND cod_subproducto = ".$cmbsubprod;
			$actualizar = $actualizar." AND hornada = ".$cmbhornada." AND numero_recarga = '".$valor[0][6]."' AND fecha_movimiento = '".$valor[0][0]."'";
			$actualizar = $actualizar." AND campo1 = '".$valor[0][4]."' AND campo2 = '".$valor[0][3]."' AND unidades = ".$valor[0][2];
			$actualizar = $actualizar." AND peso = ".$valor[0][9];
			mysqli_query($link, $actualizar);
			//echo $actualizar;
	 
							
			//Actualiza en Hornada.	
			if ($valor[0][1] == 1) //para Recepciones.
			{
				//Consulta el total de las Unidades con su Peso, para Actualizar la Hornada.
				$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidades, IFNULL(SUM(peso),0) AS peso";
				$consulta = $consulta." FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND cod_producto = 17";
				$consulta = $consulta." AND cod_subproducto = ".$cmbsubprod." AND hornada = ".$cmbhornada;
				$rs = mysqli_query($link, $consulta);
				$row = mysqli_fetch_array($rs);
								
				if ($row["unidades"] != 0)
				{
					//Actualiza las Unidades y Peso en la Tabla hornadas.
					$actualizar = "UPDATE sea_web.hornadas SET unidades = ".$row["unidades"].", peso_unidades = ".$row["peso"];
					$actualizar = $actualizar." WHERE cod_producto = ".$producto." AND cod_subproducto = ".$cmbsubprod." AND hornada_ventana = ".$cmbhornada;
					//echo $actualizar;
					mysqli_query($link, $actualizar);
				}
				else 
				{
					$eliminar = "DELETE FROM sea_web.hornadas";
					$eliminar = $eliminar." WHERE cod_producto = 17 AND cod_subproducto = ".$cmbsubprod." AND hornada_ventana = ".$cmbhornada;
					mysqli_query($link, $eliminar);
				}
			}
			else if ($valor[0][1] == 3) //para Producciones.
				{
					//Consulta el total de las Unidades con su Peso, para Actualizar la Hornada.
					$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidades, IFNULL(SUM(peso),0) AS peso";
					$consulta = $consulta." FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19";
					$consulta = $consulta." AND cod_subproducto = ".$cmbsubprod." AND hornada = ".$cmbhornada;
					$rs = mysqli_query($link, $consulta);
					$row = mysqli_fetch_array($rs);
						
					//Actualiza las Unidades y Peso en la Tabla hornadas.
					$actualizar = "UPDATE sea_web.hornadas SET unidades = ".$row["unidades"].", peso_unidades = ".$row["peso"];
					$actualizar = $actualizar." WHERE cod_producto = ".$producto." AND cod_subproducto = ".$cmbsubprod." AND hornada_ventana = ".$cmbhornada;
	//				echo $actualizar;
					mysqli_query($link, $actualizar);							
				}
				
				
			//Actualiza los pesos de Beneficio.
			if (($valor[0][1] == 1) or (($valor[0][1] == 3) and ($tipo_prod == "H")))
			{
				$consulta = "SELECT ROUND((peso_unidades / unidades),9) AS peso_promedio FROM sea_web.hornadas";
				$consulta = $consulta." WHERE cod_producto = ".$producto." AND cod_subproducto = ".$cmbsubprod." AND hornada_ventana = ".$cmbhornada;
				//echo $consulta."<br>";
				
				$rs1 = mysqli_query($link, $consulta);
				$row1 = mysqli_fetch_array($rs1);

				$actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$row1[peso_promedio].")";
				$actualizar = $actualizar." WHERE tipo_movimiento = 2 AND cod_producto = ".$producto;
				$actualizar = $actualizar." AND cod_subproducto = ".$cmbsubprod." AND hornada = ".$cmbhornada;
				mysqli_query($link, $actualizar);
				//echo $actualizar."<br>";
			}
			
			//Actualiza los pesos de Traspaso.
			if ($valor[0][1] == 3)
			{
				$consulta = "SELECT ROUND((peso_unidades / unidades),9) AS peso_promedio FROM sea_web.hornadas";
				$consulta = $consulta." WHERE cod_producto = ".$producto." AND cod_subproducto = ".$cmbsubprod." AND hornada_ventana = ".$cmbhornada;
				//echo $consulta."<br>";
				
				$rs1 = mysqli_query($link, $consulta);
				$row1 = mysqli_fetch_array($rs1);
							
				$actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$row1[peso_promedio].")";
				$actualizar = $actualizar." WHERE tipo_movimiento = 4 AND cod_producto = ".$producto;
				$actualizar = $actualizar." AND cod_subproducto = ".$cmbsubprod." AND hornada = ".$cmbhornada;
				mysqli_query($link, $actualizar);							
			}
			
	
				
			//ACTUALIZA EL MOVIMIENTO RELACIONADO, YA SEA BENEFICIO O PRODUCCION.
			
			//Beneficio.
	//		echo $valor[0][1]."<br>";
	//		echo $valor[0][7]."<br>";
	//		echo $valor[0][6]."<br>";
			
			if (($valor[0][1] == 2) and ($valor[0][7] == 19) and ($valor[0][6] == 1)) //Tipo_movimiento - cod_producto - numero_recarga.
			{
				$actualizar = "UPDATE sea_web.movimientos SET unidades = ".$valor[1][2].",campo2 = '".$valor[1][3]."',campo1 = '".$valor[1][4]."',";
				$actualizar = $actualizar." fecha_benef = '".$valor[1][0]."'";
				$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = 30 AND numero_recarga = ".$cmbhornada;
				$actualizar = $actualizar." AND campo2 = '".$valor[0][3]."' AND campo1 = '".$valor[0][4]."'";
				$actualizar = $actualizar." AND unidades = ".$valor[0][2]." AND fecha_benef = '".$valor[0][0]."'";
				mysqli_query($link, $actualizar);
			}
			else if (($valor[0][1] == 2) and ($valor[0][7] == 17) and ($valor[0][6] == 1))
				{
					$actualizar = "UPDATE sea_web.movimientos SET unidades = ".$valor[1][2].",campo2 = '".$valor[1][3]."',campo1 = '".$valor[1][4]."',";
					$actualizar = $actualizar." fecha_benef = '".$valor[1][0]."'";
					$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$cmbsubprod." AND numero_recarga = ".$cmbhornada;
					$actualizar = $actualizar." AND campo2 = '".$valor[0][3]."' AND campo1 = '".$valor[0][4]."'";
					$actualizar = $actualizar." AND unidades = ".$valor[0][2]." AND fecha_benef = '".$valor[0][0]."'";
					mysqli_query($link, $actualizar);
				}
			else if (($valor[0][1] == 3) and ($cmbsubprod != 30))
				{
					$actualizar = "UPDATE sea_web.movimientos SET unidades = ".$valor[1][2].",campo2 = '".$valor[1][3]."',campo1 = '".$valor[1][4]."'";
					$actualizar = $actualizar." WHERE tipo_movimiento = 2 AND cod_producto = 17 AND cod_subproducto = ".$cmbsubprod." AND numero_recarga = 1";				
					$actualizar = $actualizar." AND campo2 = '".$valor[0][3]."' AND campo1 = '".$valor[0][4]."'";
					$actualizar = $actualizar." AND unidades = ".$valor[0][2];
					mysqli_query($link, $actualizar);
				}
			else if (($valor[0][1] == 3) and ($cmbsubprod == 30))
				{
					$actualizar = "UPDATE sea_web.movimientos SET unidades = ".$valor[1][2].",campo2 = '".$valor[1][3]."',campo1 = '".$valor[1][4]."'";
					$actualizar = $actualizar." WHERE tipo_movimiento = 2 AND cod_producto = 19 AND numero_recarga = 1";				
					$actualizar = $actualizar." AND campo2 = '".$valor[0][3]."' AND campo1 = '".$valor[0][4]."' AND hornada = ".$valor[0][6];
					$actualizar = $actualizar." AND unidades = ".$valor[0][2]." AND fecha_movimiento = '".$valor[0][8]."'";
					mysqli_query($link, $actualizar);
	//				echo $actualizar;			
				}
		}			

		$linea = "recargapag3=S&recargapag2=S&recargapag1=S&radio1=".$tipo_mov."&cmbsubprod=".$cmbsubprod."&cmbhornada=".$cmbhornada;
		$linea = $linea."&txtbuscar=".$txthornada."&mostrar=S&activar=S";
		//echo $linea."<br>";
		header("Location:sea_modificador_movimientos.php?".$linea);
	}
	
	
	if ($proceso == "E")
	{
		//Elimina el movimiento.
		$valor = explode('/',$parametros); //Movimiento Original. (0: fecha, 1: tipo mov, 2: unidades, 3:campo2, 4: campo1, 5: flujo, 6: numero_recarga, 7: cod_producto, 8: fecha_benef, 9: peso).

        //*******************************************************************************//
	        //Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	        $valida_fecha_movimiento = $valor[0];
	        include("sea_valida_mes.php");
        //*******************************************************************************//

		$eliminar = "DELETE FROM sea_web.movimientos";
		$eliminar = $eliminar." WHERE tipo_movimiento = ".$valor[1]." AND cod_producto = ".$valor[7]." AND cod_subproducto = ".$cmbsubprod;
		$eliminar = $eliminar." AND hornada = ".$cmbhornada." AND numero_recarga = ".$valor[6]." AND fecha_movimiento = '".$valor[0]."'";
		$eliminar = $eliminar." AND campo1 = '".$valor[4]."' AND campo2 = '".$valor[3]."' AND unidades = ".$valor[2];
		mysqli_query($link, $eliminar);
		//echo $eliminar."<br>";

/*		
		//Actualiza el estado, si es que la hornada no tenia stock, ahora vuelve a tener.
		$actualizar = "UPDATE sea_web.hornadas SET estado = 0";
		$actualizar = $actualizar." WHERE cod_producto = ".$valor[7]." AND cod_subproducto = ".$cmbsubprod." AND hornada_ventana = ".$cmbhornada; 
		mysqli_query($link, $actualizar);
		echo $actualizar."<br>";
*/		
		if (($valor[1] == 4) and ($valor[7] == 17))
		{
			$eliminar = "DELETE FROM sea_web.movimientos";
			$eliminar = $eliminar." WHERE tipo_movimiento = 7 AND cod_producto = ".$valor[7]." AND cod_subproducto = ".$cmbsubprod;
			$eliminar = $eliminar." AND hornada = ".$cmbhornada." AND numero_recarga = ".$valor[6]." AND fecha_movimiento = '".$valor[0]."'";
			$eliminar = $eliminar." AND campo1 = '".$valor[4]."' AND campo2 = '".$valor[3]."' AND unidades = ".$valor[2];
			mysqli_query($link, $eliminar);
			//echo $eliminar."<br>";
		}

		if (($valor[1] == 4) and ($valor[7] == 19))
		{
			$eliminar = "DELETE FROM sea_web.movimientos";
			$eliminar = $eliminar." WHERE tipo_movimiento = 4 AND cod_producto = ".$valor[7]." AND cod_subproducto = ".$cmbsubprod;
			$eliminar = $eliminar." AND hornada = ".$cmbhornada." AND fecha_movimiento = '".$valor[0]."'";
			$eliminar = $eliminar." AND campo2 = '".$valor[3]."'";
			mysqli_query($link, $eliminar);
			//echo $eliminar;
		}


		if ($valor[1] == 1)
		{
			//Actualiza el Stock de unidades y peso. 
			$actualizar = "UPDATE sea_web.hornadas SET unidades = (unidades - '".$valor[2]."'), peso_unidades = (peso_unidades - '".$valor[9]."')";
			$actualizar = $actualizar." WHERE cod_producto = '".$valor[7]."' AND cod_subproducto = '".$cmbsubprod."' AND hornada_ventana = '".$cmbhornada."'"; 
			mysqli_query($link, $actualizar);
			//echo $actualizar."<br>";
			//Actualiza los pesos de Beneficio.
			$consulta = "SELECT * FROM sea_web.hornadas";
			$consulta = $consulta." WHERE cod_producto = '".$valor[7]."' AND cod_subproducto = '".$cmbsubprod."' AND hornada_ventana = '".$cmbhornada."'";
			//echo $consulta."<br>";
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			if ($row1["unidades"] > 0)
			{
				$promedio = round(($row1[peso_unidades] / $row1["unidades"]),9);
				$actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * '".$promedio."')";
				$actualizar = $actualizar." WHERE tipo_movimiento = 2 AND cod_producto = ".$valor[7];
				$actualizar = $actualizar." AND cod_subproducto = ".$cmbsubprod." AND hornada = ".$cmbhornada;
				mysqli_query($link, $actualizar);
				//echo $actualizar."<br>";			
			}
			else
			{
				//Eliminar Hornada.
				$eliminar = "DELETE FROM sea_web.hornadas";
				$eliminar = $eliminar." WHERE cod_producto = 17 AND cod_subproducto = ".$cmbsubprod." AND hornada_ventana = ".$cmbhornada;
				//echo "hola";
				mysqli_query($link, $eliminar);
			}
			if($valor[7]=='17'&&$cmbsubprod=='2')//MODIFICA EN RECEPCION_EXTERNA TTE
			{
				$Consulta="SELECT * from sea_web.relaciones where hornada_ventana = '".$cmbhornada."'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Consulta2="SELECT guia_despacho from sipa_web.recepciones where lote = '".$Fila[lote_ventana]."' and recargo='".$valor[6]."'";
				$Respuesta2=mysqli_query($link, $Consulta2);
				$Fila2=mysqli_fetch_array($Respuesta2);
				$GuiaOrigen=$Fila2["guia_despacho"];
				$Consulta="SELECT piezas_recep,peso_recep from sea_web.recepcion_externa ";
				$Consulta = $Consulta." WHERE cod_producto = '".$valor[7]."' AND cod_subproducto = '".$cmbsubprod."' AND lote_ventana = '".$Fila[lote_ventana]."' and guia='".$GuiaOrigen."'"; 
				$RespRecep=mysqli_query($link, $Consulta);
				$FilaRecep=mysqli_fetch_array($RespRecep);
				$Piezas=$FilaRecep[piezas_recep]-intval($valor[2]);
				$Peso=$FilaRecep[peso_recep]-intval($valor[9]);
				$actualizar = "UPDATE sea_web.recepcion_externa SET piezas_recep = ".$Piezas.", peso_recep = ".$Peso."";
				$actualizar = $actualizar." WHERE cod_producto = '".$valor[7]."' AND cod_subproducto = '".$cmbsubprod."' AND lote_ventana = '".$Fila[lote_ventana]."' and guia='".$GuiaOrigen."'"; 
				mysqli_query($link, $actualizar);
				$Actualizar="UPDATE sipa_web.recepciones set peso_neto='0',observacion='' where tipo='A' and lote='".$Fila[lote_ventana]."' and recargo='".$valor[6]."'";
				mysqli_query($link, $actualizar);
			}
		}
		$linea = "recargapag3=S&recargapag2=S&recargapag1=S&radio1=".$tipo_mov."&cmbsubprod=".$cmbsubprod."&cmbhornada=".$cmbhornada;
		$linea = $linea."&txtbuscar=".$txthornada."&mostrar=S&activar=S";
		header("Location:sea_modificador_movimientos.php?".$linea);
	}

	include ("../principal/cerrar_sea_web.php");
?>