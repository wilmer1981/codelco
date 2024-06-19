<?php
	include("../principal/conectar_principal.php");
	$Proceso = isset($_REQUEST['Proceso']) ? $_REQUEST['Proceso'] : '';
	$TxtLoteRemuestreo = isset($_REQUEST['TxtLoteRemuestreo']) ? $_REQUEST['TxtLoteRemuestreo'] : '';
	$TxtLote = isset($_REQUEST['TxtLote']) ? $_REQUEST['TxtLote'] : '';
	$CmbSubProducto = isset($_REQUEST['CmbSubProducto']) ? $_REQUEST['CmbSubProducto'] : '';
	$CmbProveedor = isset($_REQUEST['CmbProveedor']) ? $_REQUEST['CmbProveedor'] : '';
	$CmbCodFaena = isset($_REQUEST['CmbCodFaena']) ? $_REQUEST['CmbCodFaena'] : '';
	$CmbCodRecepcion = isset($_REQUEST['CmbCodRecepcion']) ? $_REQUEST['CmbCodRecepcion'] : '';
	$CmbClaseProducto = isset($_REQUEST['CmbClaseProducto']) ? $_REQUEST['CmbClaseProducto'] : '';
	$TxtConjunto = isset($_REQUEST['TxtConjunto']) ? $_REQUEST['TxtConjunto'] : '';
	$CmbCodRecepcionENM = isset($_REQUEST['CmbCodRecepcionENM']) ? $_REQUEST['CmbCodRecepcionENM'] : '';
	$TxtMuestraParalela = isset($_REQUEST['TxtMuestraParalela']) ? $_REQUEST['TxtMuestraParalela'] : '';
	$CmbEstadoLote = isset($_REQUEST['CmbEstadoLote']) ? $_REQUEST['CmbEstadoLote'] : '';	
	$TxtRecargo   = isset($_REQUEST['TxtRecargo']) ? $_REQUEST['TxtRecargo'] : '';
	
	$ChkAutorizado  = isset($_REQUEST['ChkAutorizado']) ? $_REQUEST['ChkAutorizado'] : '';
    $ChkFinLote	    = isset($_REQUEST['ChkFinLote']) ? $_REQUEST['ChkFinLote'] : '';
	$Mensaje        = isset($_REQUEST['Mensaje']) ? $_REQUEST['Mensaje'] : '';
	$TxtFechaRecep  = isset($_REQUEST['TxtFechaRecep']) ? $_REQUEST['TxtFechaRecep'] : '';
	$TxtFolio       = isset($_REQUEST['TxtFolio']) ? $_REQUEST['TxtFolio'] : '';
	$TxtCorrelativo = isset($_REQUEST['TxtCorrelativo']) ? $_REQUEST['TxtCorrelativo'] : '';
	$TxtGuia        = isset($_REQUEST['TxtGuia']) ? $_REQUEST['TxtGuia'] : '';
	$TxtPatente     = isset($_REQUEST['TxtPatente']) ? $_REQUEST['TxtPatente'] : '';
	$TxtPesoBruto   = isset($_REQUEST['TxtPesoBruto']) ? $_REQUEST['TxtPesoBruto'] : '';
	$TxtPesoTara    = isset($_REQUEST['TxtPesoTara']) ? $_REQUEST['TxtPesoTara'] : '';
	$TxtPesoNeto    = isset($_REQUEST['TxtPesoNeto']) ? $_REQUEST['TxtPesoNeto'] : '';
    $CmbEstadoRecargo = isset($_REQUEST['CmbEstadoRecargo']) ? $_REQUEST['CmbEstadoRecargo'] : '';
	$CmbHoraEnt   = isset($_REQUEST['CmbHoraEnt']) ? $_REQUEST['CmbHoraEnt'] : '';
	$CmbHoraSal   = isset($_REQUEST['CmbHoraSal']) ? $_REQUEST['CmbHoraSal'] : '';
	$CmbMinEnt    = isset($_REQUEST['CmbMinEnt']) ? $_REQUEST['CmbMinEnt'] : '';
	$CmbMinSal    = isset($_REQUEST['CmbMinSal']) ? $_REQUEST['CmbMinSal'] : '';

	switch ($Proceso)
	{		
		case "ML": //MODIFICA LOTE
			$Remuestreo="N";
			if ($TxtLoteRemuestreo!="")
				$Remuestreo="S";	
			$EstOpe = "";
			$Mensaje = "";
			$Consulta = "select * from age_web.lotes where lote='".$TxtLote."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				//CONSULTA ESTADO ANTERIOR DEL LOTE
				$EstadoLoteAnt = "";
				$Consulta = "select estado_lote,modificado from age_web.lotes ";
				$Consulta.= " where lote='".$TxtLote."'";
				$Resp2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Resp2))
				{
					$EstadoLoteAnt = $Fila2["estado_lote"];
					$Modif= $Fila2["modificado"];
				} 
				//ACTUALIZA LOTE
				$Actualizar = "UPDATE age_web.lotes set ";
				$Actualizar.= " cod_subproducto='".$CmbSubProducto."'";
				$Actualizar.= " ,rut_proveedor='".$CmbProveedor."'";
				$Actualizar.= " ,cod_faena='".$CmbCodFaena."'";
				if ($TxtRecargo == "1")
					$Actualizar.= " ,fecha_recepcion='".$TxtFechaRecep."'";
				$Actualizar.= " ,cod_recepcion='".$CmbCodRecepcion."'";
				$Actualizar.= " ,cod_recepcion_enm='".$CmbCodRecepcionENM."'";
				$Actualizar.= " ,clase_producto='".$CmbClaseProducto."'";
				$Actualizar.= " ,num_conjunto='".$TxtConjunto."'";
				$Actualizar.= " ,muestra_paralela='".$TxtMuestraParalela."'";
				$Actualizar.= " ,remuestreo='".$Remuestreo."'";
				$Actualizar.= " ,num_lote_remuestreo='".$TxtLoteRemuestreo."'";
				if($Modif=='S')
					$Actualizar.= " , modificado = 'N'";
				else
					$Actualizar.= " , modificado = 'S'";
				$Actualizar.= " ,estado_lote='".$CmbEstadoLote."'";
				$Actualizar.= " where lote='".$TxtLote."'";
				mysqli_query($link, $Actualizar);	
				//Se agrega actualizacion de recepciones sipa solo actualizaba rec_web recepciones antigua
				$Actualizar="UPDATE sipa_web.recepciones set rut_prv = '".$CmbProveedor."', ";
				$Actualizar.=" cod_mina = '".$CmbCodFaena."', cod_subproducto = '".$CmbSubProducto."',";
				$Actualizar.=" conjunto='".$TxtConjunto."' where lote='".$TxtLote."'";
				mysqli_query($link, $Actualizar);
				//ACTUALIZA ESTADO DE LOS RECARGOS SEGUN ESTADO DE LOTE
				$EstadoActualizar = 0;				
				if ($EstadoLoteAnt != $CmbEstadoLote)
				{
					$EstadoActualizar = $CmbEstadoLote;
				}				
				if ($EstadoActualizar!=0)
				{
					//ACTUALIZA ESTADO DEL LOTE DEPENDIENDO DE LOS RECARGOS
					$Actualizar = "UPDATE age_web.detalle_lotes set ";				
					$Actualizar.= " estado_recargo='".$EstadoActualizar."'";
					$Actualizar.= " , modificado = 'S'";
					$Actualizar.= " where lote='".$TxtLote."'";
					mysqli_query($link, $Actualizar);
				}
				//ACTUALIZA ESTADO DEL LOTE SEGUN RECARGOS
				$EstadoActualizar=0;
				$ContEstados=0;				
				$Consulta = "select distinct estado_recargo from age_web.detalle_lotes ";
				$Consulta.= " where lote='".$TxtLote."'";
				$Resp2 = mysqli_query($link, $Consulta);
				while ($Fila2 = mysqli_fetch_array($Resp2))
				{					
					$EstadoActualizar = $Fila2["estado_recargo"];
					$ContEstados++;
				} 
				if ($ContEstados==1 && $EstadoActualizar!=0)
				{				
					//ACTUALIZA ESTADO DEL LOTE DEPENDIENDO DE LOS RECARGOS
					$Actualizar = "UPDATE age_web.lotes set ";				
					$Actualizar.= " estado_lote='".$EstadoActualizar."'";
					$Actualizar.= " , modificado = 'S'";
					$Actualizar.= " where lote='".$TxtLote."'";
					mysqli_query($link, $Actualizar);
				}								
			}
			else
			{
				$EstOpe = "N";
				$Mensaje = "ERROR, No se ha encontrado el Lote-Recargo";
			}
			header("location:age_adm_lotes.php?TxtLote=".$TxtLote."&EstOpe=".$EstOpe."&Mensaje=".$Mensaje);
			break;
	
		case "NR": //NUEVO RECARGO
			$HoraEntrada = str_pad($CmbHoraEnt,2,"0",STR_PAD_LEFT).":".str_pad($CmbMinEnt,2,"0",STR_PAD_LEFT);
			$HoraSalida = str_pad($CmbHoraSal,2,"0",STR_PAD_LEFT).":".str_pad($CmbMinSal,2,"0",STR_PAD_LEFT);				
			//INSERTA EN LA TABLA DETALLE_LOTE EL NUEVO RECARGO
			$Insertar = "insert into age_web.detalle_lotes (lote, recargo, folio, corr, fecha_recepcion, hora_entrada, hora_salida, ";
			$Insertar.= "fin_lote, peso_bruto, peso_tara, peso_neto, guia_despacho, patente, autorizado, estado_recargo,modificado) ";
			$Insertar.= " values('".$TxtLote."','".intval($TxtRecargo)."', '".$TxtFolio."','".$TxtCorrelativo."', '".$TxtFechaRecep."', '".$HoraEntrada."', ";
			$Insertar.= " '".$HoraSalida."', '".$ChkFinLote."', '".$TxtPesoBruto."', '".$TxtPesoTara."', '".$TxtPesoNeto."', '".$TxtGuia."', ";
			$Insertar.= " '".$TxtPatente."', '".$ChkAutorizado."', '".$CmbEstadoRecargo."','S')";
			mysqli_query ($link, $Insertar);	
			if (mysqli_errno($link)==0)
			{
				$EstOpe = "S";
				$Mensaje = "Operacion Realizada";
			}
			else
			{
				$EstOpe = "N";
				$Mensaje = "Error ".mysqli_errno($link);
				$Mensaje.= ", ".mysqli_error($link)."<br>";
			}	
			//INSERTA EN  SIPA_WEB.RECEPCIONES
			$control=0;
			$Consulta="Select * from sipa_web.recepciones where lote = '".$TxtLote."' and recargo != 0 order by recargo";
			$RespL=mysqli_query($link, $Consulta);
			//echo $Consulta;
			while($Fil=mysqli_fetch_array($RespL))
			{
				if($control==0)
				{
					$Insertar ="INSERT INTO sipa_web.recepciones ";
					$Insertar.="(correlativo,lote,recargo,ult_registro,rut_operador,bascula_entrada,bascula_salida,";
					$Insertar.="fecha,hora_entrada,hora_salida,peso_bruto,peso_tara,peso_neto,rut_prv,cod_mina,";
					$Insertar.="cod_producto,cod_subproducto,cod_pta_maq,leyes,impurezas,guia_despacho,patente,";
					$Insertar.="cod_clase,conjunto,observacion,activo,estado,humedad,cod_grupo,sa_asignada,romana_entrada,";
					$Insertar.="romana_salida,tipo) VALUES ";
					$Insertar.="('".$TxtCorrelativo."','".$TxtLote."','".$TxtRecargo."','".$ChkFinLote."',";
					$Insertar.="'".$Fil[rut_operador]."', '1','1','".$TxtFechaRecep."','".$HoraEntrada."','".$HoraSalida."',";
					$Insertar.="'".$TxtPesoBruto."','".$TxtPesoTara."','".$TxtPesoNeto."','".$Fil[rut_prv]."','".$Fil[cod_mina]."',";
			        $Insertar.="'1','".$Fil["cod_subproducto"]."','".$Fil[cod_pta_maq]."','".$Fil["leyes"]."','".$Fil["impurezas"]."',";
					$Insertar.="'".$TxtGuia."','".$TxtPatente."','".$Fil[cod_clase]."','".$Fil[conjunto]."','','".$Fil["activo"]."',";
					$Insertar.="'".$Fil[estado]."','".$Fil[humedad]."','".$Fil["cod_grupo"]."','".$Fil[sa_asignada]."','1','1',";
					$Insertar.="'".$Fil[tipo]."')";
					//echo $Insertar;
					mysqli_query($link, $Insertar);
					
				}
				$control = 9;
			}
			// FIN INSERTA RECARGO EN SIPA
			header("location:age_adm_lotes_recargos.php?Proc=M&TxtLote=".$TxtLote."&TxtRecargo=".$TxtRecargo."&EstOpe=".$EstOpe."&Mensaje=".$Mensaje);
			break;
		case "MR": //MODIFICA RECARGO
			$EstOpe = "";
			$Mensaje = "";
			$Consulta = "select * from age_web.detalle_lotes where lote='".$TxtLote."' and recargo='".$TxtRecargo."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{						
				$HoraEntrada = str_pad($CmbHoraEnt,2,"0",STR_PAD_LEFT).":".str_pad($CmbMinEnt,2,"0",STR_PAD_LEFT);
				$HoraSalida = str_pad($CmbHoraSal,2,"0",STR_PAD_LEFT).":".str_pad($CmbMinSal,2,"0",STR_PAD_LEFT);		
				//ACTUALIZA DETALLE_LOTES
				$Actualizar = "UPDATE age_web.detalle_lotes set ";
				$Actualizar.= " folio='".$TxtFolio."'";
				$Actualizar.= " ,corr='".$TxtCorrelativo."'";
				$Actualizar.= " ,fecha_recepcion='".$TxtFechaRecep."'";
				$Actualizar.= " ,hora_entrada='".$HoraEntrada."'";
				$Actualizar.= " ,hora_salida='".$HoraSalida."'";
				$Actualizar.= " ,fin_lote='".$ChkFinLote."'";
				$Actualizar.= " ,peso_bruto='".$TxtPesoBruto."'";
				$Actualizar.= " ,peso_tara='".$TxtPesoTara."'";
				$Actualizar.= " ,peso_neto='".$TxtPesoNeto."'";
				$Actualizar.= " ,guia_despacho='".$TxtGuia."'";
				$Actualizar.= " ,patente='".$TxtPatente."'";
				if($ChkAutorizado=='S')
				{
					$Actualizar.= " ,autorizado='".$ChkAutorizado."'";
					$Actualizar.= " ,estado_recargo='".$CmbEstadoRecargo."'";
					$Actualizar.= " , modificado = 'S'";
				}
				else
				{
					$Actualizar.= " ,autorizado='".$ChkAutorizado."'";
					$Actualizar.= " ,estado_recargo='".$CmbEstadoRecargo."'";
					$Actualizar.= " , modificado = 'N'";
				}	
				$Actualizar.= " where lote='".$TxtLote."' and recargo='".$TxtRecargo."'";
				mysqli_query($link, $Actualizar);	
				//ACTUALIZA BASE DATOS DEL LOTE/RECARGO SIPA_WEB.RECEPCIONES
				$Actualizar1= "Update sipa_web.recepciones set ";
				$Actualizar1.=" fecha = '".$TxtFechaRecep."', hora_entrada='".$HoraEntrada."',";
				$Actualizar1.=" hora_salida='".$HoraSalida."',ult_registro='".$ChkFinLote."', guia_despacho='".$TxtGuia."',";
				$Actualizar1.=" patente ='".$TxtPatente."' "; 
				$Actualizar1.= " where lote='".$TxtLote."' and recargo='".$TxtRecargo."'";
				mysqli_query($link, $Actualizar1);
				if (mysqli_errno($link)==0)
				{
					$EstOpe = "S";
					$Mensaje = "Operacion Realizada";
				}
				else
				{
					$EstOpe = "N";
					$Mensaje.= "Error ".mysqli_errno($link);
					$Mensaje.= ", ".mysqli_error($link);
				}					
					
				//ACTUALIZA ESTADO DEL LOTE SEGUN RECARGOS
				$EstadoActualizar=0;
				$ContEstados=0;				
				$Consulta = "select distinct estado_recargo from age_web.detalle_lotes ";
				$Consulta.= " where lote='".$TxtLote."'";
				$Resp2 = mysqli_query($link, $Consulta);
				while ($Fila2 = mysqli_fetch_array($Resp2))
				{					
					$EstadoActualizar = $Fila2["estado_recargo"];
					$ContEstados++;
				} 
				if ($ContEstados==1 && $EstadoActualizar!=0)
				{				
					//ACTUALIZA ESTADO DEL LOTE DEPENDIENDO DE LOS RECARGOS
					$Actualizar = "UPDATE age_web.lotes set ";				
					$Actualizar.= " estado_lote='".$EstadoActualizar."'";
					$Actualizar.= " , modificado = 'S'";
					$Actualizar.= " where lote='".$TxtLote."'";
					mysqli_query($link, $Actualizar);
				}
			}
			else
			{
				$EstOpe = "N";
				$Mensaje = "ERROR, No se ha encontrado el Lote-Recargo";
			}
			header("location:age_adm_lotes_recargos.php?Proc=M&TxtLote=".$TxtLote."&TxtRecargo=".$TxtRecargo."&EstOpe=".$EstOpe."&Mensaje=".$Mensaje);
			break;	
		case "OM": //OPERACIONES MASIVAS
			$Datos = explode("//",$TxtValores);
			foreach($Datos as $k => $v)
			{
				$Datos2 = explode("-",$v);
				if ($CmbEstadoRecargo != "S")
				{
					//ACTUALIZA ESTADO DEL RECARGO
					$Actualizar = "UPDATE age_web.detalle_lotes set ";				
					$Actualizar.= " estado_recargo='".$CmbEstadoRecargo."'";
					$Actualizar.= " , modificado = 'S'";
					$Actualizar.= " where lote='".$Datos2[0]."' and recargo='".$Datos2[1]."'";
					mysqli_query($link, $Actualizar);	
					$Actualizar="UPDATE sipa_web.recepciones set activo = 'M' ";
					$Actualizar.=" where lote = '".$Datos2[0]."' and recargo = '".$Datos2[1]."'";
					mysqli_query($link, $Actualizar);
					//ACTUALIZA ESTADO DEL LOTE SEGUN RECARGOS
					$EstadoActualizar=0;
					$ContEstados=0;				
					$Consulta = "select distinct estado_recargo from age_web.detalle_lotes ";
					$Consulta.= " where lote='".$Datos2[0]."'";
					$Resp2 = mysqli_query($link, $Consulta);
					while ($Fila2 = mysqli_fetch_array($Resp2))
					{					
						$EstadoActualizar = $Fila2["estado_recargo"];
						$ContEstados++;
					} 
					if ($ContEstados==1 && $EstadoActualizar!=0)
					{				
						//ACTUALIZA ESTADO DEL LOTE DEPENDIENDO DE LOS RECARGOS
						$Actualizar = "UPDATE age_web.lotes set ";				
						$Actualizar.= " estado_lote='".$EstadoActualizar."'";
						$Actualizar.= " , modificado = 'S'";
						$Actualizar.= " where lote='".$Datos2[0]."'";
						mysqli_query($link, $Actualizar);
						$Actualizar="UPDATE sipa_web.recepcioes set activo = 'M' ";
						$Actualizar.=" where lote = '".$Datos2[0]."' and recargo = '".$Datos2[1]."'";
						mysqli_query($link, $Actualizar);
						//echo $Actualizar."<br>";
					}
				}
				if ($CmbAutorizado != "T")
				{
					//ACTUALIZA ESTADO DEL RECARGO
					$Actualizar = "UPDATE age_web.detalle_lotes set ";				
					$Actualizar.= " autorizado='".$CmbAutorizado."'";
					$Actualizar.= " , modificado = 'S'";
					$Actualizar.= " where lote='".$Datos2[0]."' and recargo='".$Datos2[1]."'";
					mysqli_query($link, $Actualizar);	
					$Actualizar="UPDATE sipa_web.recepciones set activo = 'M' ";
					$Actualizar.=" where lote = '".$Datos2[0]."' and recargo = '".$Datos2[1]."'";
					mysqli_query($link, $Actualizar);
					//echo $Actualizar."<br>";
				}
				if ($CmbClaseProducto != "S")
				{
					//ACTUALIZA CLASE DE PRODUCTO DE LA TABLA LOTE
					$Actualizar = "UPDATE age_web.lotes set ";				
					$Actualizar.= " clase_producto = '".$CmbClaseProducto."'";
					$Actualizar.= " , modificado = 'S'";
					$Actualizar.= " where lote = '".$Datos2[0]."'";
					mysqli_query($link, $Actualizar);
					$Actualizar="UPDATE sipa_web.recepciones set cod_clase = '".$CmbClaseProducto."',";
					$Actualizar.=" activo = 'M'  where lote = '".$Datos2[0]."' ";
					mysqli_query($link, $Actualizar);
					//echo $Actualizar."<br>";
				}
				if ($CmbCodRecepcion != "S")
				{
					//ACTUALIZA COD RECEPCION DE LA TABLA LOTE
					$Actualizar = "UPDATE age_web.lotes set ";				
					$Actualizar.= " cod_recepcion = '".$CmbCodRecepcion."'";
					$Actualizar.= " , modificado = 'S'";
					$Actualizar.= " where lote = '".$Datos2[0]."'";
					mysqli_query($link, $Actualizar);
				}
				if ($CmbCodRecepcionENM != "S")
				{
					//ACTUALIZA COD RECEPCION DE LA TABLA LOTE
					$Actualizar = "UPDATE age_web.lotes set ";				
					$Actualizar.= " cod_recepcion_enm = '".$CmbCodRecepcionENM."'";
					$Actualizar.= " , modificado = 'S'";
					$Actualizar.= " where lote = '".$Datos2[0]."'";
					mysqli_query($link, $Actualizar);
				}
			}			
			echo "<script language='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='age_adm_recepcion.php?TipoCon=".$TipoConsulta."';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";
			echo "</script>";			
			break;
		case "ER"://ELIMINA RECARGOS
			$Datos = explode("//",$TxtValores);
			foreach($Datos as $k => $v)
			{
				$Datos2 = explode("-",$v);
				$Lote = $Datos2[0];
				$Recargo = $Datos2[1];
				//ELIMINA RECARGO
				$Eliminar = "delete from age_web.detalle_lotes ";
				$Eliminar.= " where lote='".$Lote."' and recargo='".$Recargo."'";
				mysqli_query($link, $Eliminar);
				// Elimina recargo de Sipa
				$EliminaS="delete from sipa_web.recepciones";
				$EliminaS.=" where lote = '".$Lote."' and recargo = '".$Recargo."'";
				mysqli_query($link, $EliminaS);
				//CONSULTA SI QUEDA ALGUN RECARGO DEL LOTE, SI NO QUEDAN ELIMINA EL LOTE DE LA TABLA LOTE
				$contador = 0;
				$Consulta = "select * from age_web.detalle_lotes where lote='".$Lote."'";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					$contador = $contador + 1;
				}
				if($contador==0)
				{
					$Eliminar = "delete from age_web.lotes ";
					$Eliminar.= " where lote='".$Lote."'";
					mysqli_query($link, $Eliminar);
				}
			}
			echo "<script language='JavaScript'>";
			echo "window.location='age_adm_lotes.php?TxtLote=".$TxtLote."';";			
			echo "</script>";		
			break;
			
	}
?>