<?php
	include("../principal/conectar_principal.php");
	$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Mes        = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano        = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor    = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$Valores          = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	switch ($Proceso)
	{
		case "G":
			$Datos1=explode("//",$Valores);
			foreach($Datos1 as $k=>$v)
			{
				$Datos2=explode("~~",$v);
				$Lote = $Datos2[0];
				$Recargo = $Datos2[1];
				$Remuestreo = $Datos2[2];
				if ($Remuestreo=="")
				{
					$Actualizar = "UPDATE age_web.lotes set ";
					$Actualizar.= " remuestreo='N' ";
					$Actualizar.= " , num_lote_remuestreo='' ";
					$Actualizar.= " where lote='".$Lote."'";
					mysqli_query($link, $Actualizar);	
				}
				else
				{
					$Ajuste="";
					if (substr($Lote,0,3)==substr($Remuestreo,0,3))
						$Ajuste="";
					else
						$Ajuste="A";
					$Ok=false;
					$Consulta = "select * from age_web.lotes where num_lote_remuestreo='".$Lote."'";
					$Consulta.= " order by lote ";
					//echo $Consulta;
					$Resp=mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Resp))
					{
						if ($Fila["lote"]==$Remuestreo)
							$Ok=true;
						else
						{
							$Ok=false;
							//CAMBIA EL ESTADO DEL EX_LOTE
							$Actualizar = "UPDATE age_web.lotes set ";
							$Actualizar.= " estado_lote='6' ";//ANULADO POR REMUESTREO
							if ($Ajuste=="A")
								$Actualizar.= " , mostrar_lote='S' ";//SE MUESTRA EN EL MES QUE CORRESPONDE
							$Actualizar.= " where lote='".$Fila["lote"]."'";
							mysqli_query($link, $Actualizar);
							//CAMBIA EL ESTADO DEL EX_LOTE
							$Actualizar = "UPDATE age_web.detalle_lotes set ";
							$Actualizar.= " estado_recargo='6' ";//ANULADO POR REMUESTREO
							if ($Ajuste=="A")
								$Actualizar.= " , mostrar_recargo='S' ";//SE MUESTRA EN EL MES QUE CORRESPONDE
							$Actualizar.= " where lote='".$Fila["lote"]."'";
							mysqli_query($link, $Actualizar);
						}
					}
					//CAMBIA EL ESTADO DEL EX_LOTE
					$Actualizar = "UPDATE age_web.lotes set ";
					$Actualizar.= " estado_lote='6' ";//ANULADO POR REMUESTREO
					if ($Ajuste=="A")
						$Actualizar.= " , mostrar_lote='N' ";//SE MUESTRA EN EL MES QUE CORRESPONDE
					$Actualizar.= " where lote='".$Lote."'";
					mysqli_query($link, $Actualizar);
					//CAMBIA EL ESTADO DE LOS RECARGOS DEL EX_LOTE
					$Actualizar = "UPDATE age_web.detalle_lotes set ";
					$Actualizar.= " estado_recargo='6' ";//ANULADO POR REMUESTREO
					if ($Ajuste=="A")
						$Actualizar.= " , mostrar_recargo='N' ";//SE MUESTRA EN EL MES QUE CORRESPONDE
					$Actualizar.= " where lote='".$Lote."'";
					mysqli_query($link, $Actualizar);
					//DUPLICA LOS DATOS DEL EX-LOTE
					$Consulta = "Select * from age_web.lotes ";
					$Consulta.= " where lote ='".$Lote."'";
					$RespAux=mysqli_query($link, $Consulta);
					if ($FilaAux=mysqli_fetch_array($RespAux))
					{
						if ($Ajuste=="A")
							$FechaRecep=date("Y-m-d", mktime(0,0,0,substr($FilaAux["fecha_recepcion"],5,2)+1,substr($FilaAux["fecha_recepcion"],8,2),substr($FilaAux["fecha_recepcion"],0,4)));
						else
							$FechaRecep=$FilaAux["fecha_recepcion"];
						$Insertar = "INSERT INTO age_web.lotes (`lote`, `cod_producto`, `cod_subproducto`, `rut_proveedor`, `fecha_recepcion`, ";
						$Insertar.= " `cod_faena`, `cod_recepcion`, `clase_producto`, `num_conjunto`, `remuestreo`, `num_lote_remuestreo`, ";
						$Insertar.= " `estado_lote`, `modificado`, `fin_canje`, `cancha`, `fecha_vence_padron`, `canjeable`, `contrato`, `muestra_paralela`,";
						$Insertar.= " `cod_recepcion_enm`,`tipo_remuestreo`) ";
						$Insertar.= " VALUES ('".$Remuestreo."', '".$FilaAux["cod_producto"]."', '".$FilaAux["cod_subproducto"]."', '".$FilaAux["rut_proveedor"]."',";
						$Insertar.= " '".$FechaRecep."', '".$FilaAux["cod_faena"]."', '".$FilaAux["cod_recepcion"]."', '".$FilaAux["clase_producto"]."',";
						$Insertar.= " '".$FilaAux["num_conjunto"]."', 'S', '".$Lote."', '1', 'S', '', '".$FilaAux["cancha"]."', '".$FilaAux["fecha_vence_padron"]."', '',";
						$Insertar.= " '".$FilaAux["contrato"]."', '', '".$FilaAux["cod_recepcion_enm"]."', '".$Ajuste."')";						
						mysqli_query($link, $Insertar);
					}
					//ASIGNA LAS HUMEDADES AL NUEVO LOTE
					$Consulta = "Select * from  age_web.leyes_por_lote ";
					$Consulta.= " where lote ='".$Lote."' and cod_leyes='01' and recargo<>'0'";
					$RespAux=mysqli_query($link, $Consulta);
					while ($FilaAux=mysqli_fetch_array($RespAux))
					{
						if ($FilaAux["provisional"]=="" || is_null($FilaAux["provisional"]))
						{
							$Provisional="N";
						}
						else
						{
							$Provisional=$FilaAux["provisional"];
						}
						$Insertar = "INSERT INTO age_web.leyes_por_lote (lote, recargo, cod_leyes, valor, cod_unidad, valor2, provisional,modificado,ano) ";
						$Insertar.= " values('".$Remuestreo."','".$FilaAux["recargo"]."','".$FilaAux["cod_leyes"]."','".$FilaAux["valor"]."','".$FilaAux["cod_unidad"]."','".$FilaAux["valor2"]."',";
						$Insertar.="'".$Provisional."','S','".$FilaAux["ano"]."')";
						mysqli_query($link, $Insertar);
					}
					//ASIGNA LOS RECARGOS AL NUEVO LOTE
					$Consulta = "Select * from  age_web.detalle_lotes ";
					$Consulta.= " where lote ='".$Lote."'";
					$RespAux=mysqli_query($link, $Consulta);
					while ($FilaAux=mysqli_fetch_array($RespAux))
					{
						if ($Ajuste=="A")
							$FechaRecep=date("Y-m-d", mktime(0,0,0,substr($FilaAux["fecha_recepcion"],5,2)+1,substr($FilaAux["fecha_recepcion"],8,2),substr($FilaAux["fecha_recepcion"],0,4)));
						else
							$FechaRecep=$FilaAux["fecha_recepcion"];
						$Insertar = "INSERT INTO age_web.detalle_lotes (`lote`, `recargo`, `folio`, `corr`, `fecha_recepcion`, ";
						$Insertar.= " `hora_entrada`, `hora_salida`, `peso_bruto`, `peso_tara`, `peso_neto`, `guia_despacho`, `patente`,";
						$Insertar.= " `modificado`, `rut_romanero`, `bascula1`, `bascula`, `cod_descarga`, `observacion`, `pastas`, `impurezas`) ";
						$Insertar.= " VALUES ('".$Remuestreo."', '".$FilaAux["recargo"]."', '".$FilaAux["folio"]."', '".$FilaAux["corr"]."', '".$FechaRecep."',";
						$Insertar.= " '".$FilaAux["hora_entrada"]."', '".$FilaAux["hora_salida"]."', '".$FilaAux["peso_bruto"]."', '".$FilaAux["peso_tara"]."', ";
						$Insertar.= " '".$FilaAux["peso_neto"]."', '".$FilaAux["guia_despacho"]."', '".$FilaAux["patente"]."', 'S', '".$FilaAux["rut_romanero"]."', ";
						$Insertar.= " '".$FilaAux["bascula1"]."', '".$FilaAux["bascula"]."', '".$FilaAux["cod_descarga"]."', '".$FilaAux["observacion"]."', '".$FilaAux["pastas"]."', '".$FilaAux["impurezas"]."')";						
						mysqli_query($link, $Insertar);
					}
				}								

			}
			header("location:age_con_muestra_paralela.php?Mostrar=S&Ano=".$Ano."&Mes=".$Mes."&SubProducto=".$SubProducto."&Proveedor=".$Proveedor);
			break;
	}
?>