<?php 	
	include("../principal/conectar_sec_web.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Tipo    = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";

	$TxtCodBultoIni    = isset($_REQUEST["TxtCodBultoIni"])?$_REQUEST["TxtCodBultoIni"]:"";
	$TxtNumBultoIni    = isset($_REQUEST["TxtNumBultoIni"])?$_REQUEST["TxtNumBultoIni"]:0;
	$TxtCodBultoFin    = isset($_REQUEST["TxtCodBultoFin"])?$_REQUEST["TxtCodBultoFin"]:"";
	$TxtNumBultoFin    = isset($_REQUEST["TxtNumBultoFin"])?$_REQUEST["TxtNumBultoFin"]:0;
	
	switch ($Proceso)
	{
		case "G":
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$IE=$Datos2[0];
				$CodProducto=$Datos2[3];
		     	$CodSubProducto=$Datos2[4];
				$PesoLote=$Datos2[7];
				$CodBulto=$Datos2[8];
				$NumBulto=$Datos2[9];
				$CodMarca=$Datos2[10];
			}
			$Consulta="SELECT max(corr_virtual) as numero from sec_web.instruccion_virtual ";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			if($Fila["numero"]=='')
			{
				$IEVirtual=900000;	
			}
			else
			{
				$IEVirtual=$Fila["numero"]+1;
			}
			$TxtNumBultoFin = $TxtNumBultoFin + 1;
			$Consulta="SELECT sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner";
			$Consulta=$Consulta." join sec_web.paquete_catodo t2 on ";
			$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
			$Consulta=$Consulta." where t1.corr_enm=".$IE." and t1.num_paquete<".$TxtNumBultoFin." and t1.cod_estado='a' and t2.cod_estado='a'"; 
			$Consulta=$Consulta."group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";
			$Respuesta2=mysqli_query($link, $Consulta);
			$Fila2=mysqli_fetch_array($Respuesta2);
			$Peso=$Fila2["peso_preparado"];
			$Actualizar="UPDATE sec_web.instruccion_virtual set peso_programado=".$Peso.",estado='T' where corr_virtual=".$IE;
			mysqli_query($link, $Actualizar);
			$Peso=0;
			$Consulta="SELECT * from sec_web.lote_catodo where cod_bulto='".$CodBulto."'";
			$Consulta=$Consulta." and num_bulto=".$NumBulto." and corr_enm=".$IE." and num_paquete>=".$TxtNumBultoFin;
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				$Consulta="SELECT sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner";
				$Consulta=$Consulta." join sec_web.paquete_catodo t2 on ";
				$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
				$Consulta=$Consulta." where t1.corr_enm=".$IE." and t1.num_paquete=".$Fila["num_paquete"]." and t1.cod_estado='a' and t2.cod_estado='a'"; 
				$Consulta=$Consulta."group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2);
				$Peso=$Peso+$Fila2["peso_preparado"];
				$Actualizar="UPDATE sec_web.lote_catodo set num_bulto=".$TxtNumBultoFin.",corr_enm=".$IEVirtual." where cod_bulto='".$CodBulto."'";
				$Actualizar=$Actualizar." and num_bulto=".$NumBulto." and corr_enm=".$IE." and num_paquete=".$Fila["num_paquete"];
				mysqli_query($link, $Actualizar);		
			}
			$Fecha=date('Y-m-d');
			$Insertar="INSERT INTO sec_web.instruccion_virtual(corr_virtual,peso_programado,fecha_embarque,cod_producto,cod_subproducto,descripcion,estado) values (";
			$Insertar=$Insertar."$IEVirtual,$Peso,'$Fecha','$CodProducto','$CodSubProducto','ADM','T')";
			mysqli_query($link, $Insertar); 
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProgLoteo.action='sec_programa_adm_loteo.php?TipoIE=Virtual';";
			echo "window.opener.document.FrmProgLoteo.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "C":
			//$TxtCodBultoIni;
			//$TxtNumBultoIni;
			//$TxtCodBultoFin;
			//$TxtNumBultoFin;
			$Consulta="SELECT sum(t2.peso_paquetes) as peso from sec_web.lote_catodo t1 inner join paquete_catodo t2 on";
			$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete where t1.cod_bulto='".$TxtCodBultoIni."' and t1.num_bulto=".$TxtNumBultoIni;
			$Consulta=$Consulta." and t1.num_paquete between ".$TxtNumBultoIni." and ".$TxtNumBultoFin;
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$PesoCalculado=$Fila["peso"];
			header('location:sec_distribuir_lote.php?PesoCalculado='.$PesoCalculado."&Valores=".$Valores."&TxtNumBultoFin=".$TxtNumBultoFin);
			break;
		case "T":
		    if ($Tipo=='R')
			{
			    	$Tipo=1;
			 }
			 if ($Tipo=='P')
			 {
			 	$Tipo=2;
			 }
			 if ($Tipo=='V') 
			 {
			 	$Tipo=3;
			 }	
			$FechaTraspaso=date('Y-m-d');
			$Anot = date('Y');
			$Mest = date('m');
			$Diat = date('d');
			//echo $FechaTraspaso;
			if (strlen($Mest==1))
			{
			    $Mest="0".$Mest;
			}
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$IE=$Datos2[0];
				$CodProducto=$Datos2[3];
				$CodSubProducto=$Datos2[4];
				$PesoLote=$Datos2[7];
				$CodBulto=strtoupper($Datos2[8]);
				$NumBulto=$Datos2[9];
			}
			if ($PesoLote!='')
			{
				$Consulta="SELECT cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='3004' and nombre_subclase='".$CodBulto."'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				//$CodLetra=$Fila["cod_subclase"];
				$CodLetra=isset($Fila["cod_subclase"])?$Fila["cod_subclase"]:"";
				if (strlen($CodLetra)==1)
				{
					$CodLetra="0".$CodLetra;
				}
			    if (($CodLetra=='01') || ($CodLetra=='03') || ($CodLetra=='05') ||
				    ($CodLetra=='07') || ($CodLetra=='08') || ($CodLetra=='10') ||
					($CodLetra=='12'))
				{
						$Diat=31;
				}
				if (($CodLetra=='04') || ($CodLetra=='06') || ($CodLetra=='09') ||
				    ($CodLetra=='11'))
				{
						$Diat=30;
				}
				if  ($CodLetra=='02')
				{
				        $Diat=28;
				}
			 //	if ($Mest!=$CodLetra)
			//	{
			//	   $FechaTraspaso = $Anot."-".$CodLetra."-".$Diat;
			//	 }
			//	echo $FechaTraspaso;	   		   		   		   
				$Consulta="SELECT fecha_creacion_lote from sec_web.lote_catodo ";
				$Consulta=$Consulta." where corr_enm=".$IE." and cod_estado='a'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$FechaCreacionLote=$Fila["fecha_creacion_lote"];
				$Consulta="SELECT count(*) as cant_paquetes from sec_web.lote_catodo ";
				$Consulta=$Consulta." where corr_enm=".$IE." and cod_estado='a'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Paquetes=$Fila["cant_paquetes"];
				$Hornada=date('Y').$CodLetra.$NumBulto.$CodLetra;

				$Insertar="INSERT INTO sec_web.traspaso (hornada,fecha_traspaso,peso,unidades,fecha_creacion_lote,cod_producto,cod_subproducto,cod_bulto,num_bulto,sw) values (";
				$Insertar.="'$Hornada','$FechaTraspaso','$PesoLote','$Paquetes','$FechaCreacionLote','$CodProducto','$CodSubProducto','$CodBulto','$NumBulto','$Tipo')";
				//echo $Insertar;
				mysqli_query($link, $Insertar);
				//INSERTA EN TABLA sea_web.movimientos
				if ($Tipo==1)
				{
					//consulta flujo
                    $flujo = 0;
					$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 1 AND cod_producto = ".$CodProducto;
					$consulta = $consulta." AND cod_subproducto = ".$CodSubProducto;		
					$rs1 = mysqli_query($link, $consulta);
					if ($row1 = mysqli_fetch_array($rs1))
                    {
					   $flujo = $row1["flujo"];
                     }

					$HoraActual = date("H:i:s");
					$FechaHoraActual = $FechaTraspaso." ".$HoraActual;
//aca inserta en SEA
					$InsertMov="INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso,hora)";
					$InsertMov=$InsertMov."values(1,'$CodProducto','$CodSubProducto','$Hornada',0,'$FechaTraspaso','9999','9999','$Paquetes','$flujo','$PesoLote','$FechaHoraActual')";
					//echo "INSERT".$InsertMov;
                	mysqli_query($link, $InsertMov);

					//INSERTA EN TABLA sea_web.hornadas     
					$InsertHor="INSERT INTO sea_web.hornadas (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades,Analizada,estado)";
					$InsertHor=$InsertHor." values('$CodProducto','$CodSubProducto','$Hornada','$Paquetes','$PesoLote','N',0)";
					 mysqli_query($link, $InsertHor);
			}
				//UPDATE DE CORR_ENM,COD_ESTADO DE LOTE Y COD_ESTADO PAQUETES
				$Consulta="SELECT cod_bulto,num_bulto,cod_paquete,num_paquete from sec_web.lote_catodo ";
				$Consulta=$Consulta." where corr_enm='".$IE."' and cod_estado='a'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Actualizar="UPDATE sec_web.lote_catodo set corr_enm='".$Hornada."',cod_estado='c' where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and corr_enm='".$IE."' ";
				mysqli_query($link, $Actualizar);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					$Consulta="SELECT cod_paquete,num_paquete,fecha_creacion_paquete,peso_paquetes from sec_web.paquete_catodo  where cod_paquete='".$Fila["cod_paquete"]."' and num_paquete=".$Fila["num_paquete"]." and cod_estado='a'";
					$Respuesta2=mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Respuesta2);
					$cod_paquete= isset($Fila2["cod_paquete"])?$Fila2["cod_paquete"]:"";
					$num_paquete= isset($Fila2["num_paquete"])?$Fila2["num_paquete"]:"";
					$fecha_creacion_paquete= isset($Fila2["fecha_creacion_paquete"])?$Fila2["fecha_creacion_paquete"]:"";
					$peso_paquetes= isset($Fila2["peso_paquetes"])?$Fila2["peso_paquetes"]:"";
					
					$Insertar="INSERT INTO sec_web.det_traspaso (hornada,cod_paquete,num_paquete,fecha_creacion_paquete,peso_paquete)";
					$Insertar=$Insertar." values('$Hornada','$cod_paquete','$num_paquete','$fecha_creacion_paquete','$peso_paquetes')";	
					mysqli_query($link, $Insertar);
					$Actualizar="UPDATE sec_web.paquete_catodo set cod_estado='c' where cod_paquete='".$Fila["cod_paquete"]."' and num_paquete='".$Fila["num_paquete"]."' and cod_estado='a'";
					mysqli_query($link, $Actualizar);
				}
				$Eliminar="delete from sec_web.instruccion_virtual where corr_virtual=".$IE;
				mysqli_query($link, $Eliminar);
			}
			header('location:sec_programa_adm_loteo.php?TipoIE=Virtual');
			break;  
		case "E":
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$corr_enm=$Datos2[0];
				$cod_producto=$Datos2[3];
				$cod_subproducto=$Datos2[4];
				$bulto_peso=$Datos2[7];
				$cod_bulto=$Datos2[8];				
				$num_bulto=$Datos2[9];
				$cod_marca=$Datos2[10];
				$Consulta="SELECT count(*) as cantpaquetes from sec_web.lote_catodo";
				$Consulta=$Consulta." where cod_bulto='".$cod_bulto."' and num_bulto=".$num_bulto." and corr_enm=".$corr_enm." and cod_estado='a'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$bulto_paquetes=$Fila["cantpaquetes"];
				$Consulta="SELECT t3.cod_cliente,t3.eta_programada,t3.fecha_disponible,t3.cod_contrato,t4.rut from sec_web.det_contrato t1 inner join  sec_web.det_contrato_por_ie t2 on ";
				$Consulta.=" t1.num_contrato=t2.num_contrato and t1.num_subcontrato=t2.num_subcontrato and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.=" inner join sec_web.programa_enami t3 on t2.corr_ie=t3.corr_enm and t3.tipo='V'";
				$Consulta.=" left join sec_web.cliente_venta t4 on t3.cod_cliente=t4.cod_cliente"; 
				$Consulta.=" where t2.corr_ie='".$corr_enm."'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$fecha_embarque=$Fila["fecha_disponible"];
				$fecha_programacion=$Fila["eta_programada"];
				$cod_cliente=$Fila["cod_cliente"];
				$Rut=$Fila["rut"];
				$Consulta="SELECT cod_sub_cliente from sec_web.det_contrato_por_ie where corr_ie='".$corr_enm."'";
				$Respuesta2=mysqli_query($link, $Consulta);
				$CodSubCliente='';
				if ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					$CodSubCliente=$Fila2["cod_sub_cliente"];	
				}
				$cod_puerto='';
				$cod_agente='';
				$cod_estiba='';
				$cod_acopio='';
				$cod_nave='';
				$num_viaje='';
				//PARA EL CASO DE LODO DE PROCESO, PARA ASIGNAR EL ENVIO NECESITA LA SEGUNDA PESADA
				$Mensaje='';
				if ($cod_producto=='57')
				{
					$Consulta="SELECT count(*) as total from sec_web.pesaje_lodos ";
					$Consulta=$Consulta." where corr_ie=".$corr_enm." and cod_bulto='".$cod_bulto."' and num_bulto=".$num_bulto;
					$Consulta=$Consulta." group by corr_ie,cod_bulto,num_bulto,cod_paquete,num_paquete having count(*)=1";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					if ($Fila["total"]==1)
					{
						$Mensaje="No se puede Enviar, Falta Segunda Pesada ";
					}
				}
				if ($Mensaje=='')
				{
			        if ($CodSubCliente=='')
					{
						$CodSubCliente='*';
					}
					$Consulta = "SELECT ifnull(max(num_envio),0)+1 as mayor  from sec_web.embarque_ventana where tipo='V'";
					$Resultado = mysqli_query($link, $Consulta);
			        $Fila=mysqli_fetch_array($Resultado);
					$TxtNumEnvio=$Fila["mayor"];
					$FechaEnvio=date('Y-m-d');
					$Insertar="INSERT INTO sec_web.embarque_ventana (num_envio,corr_enm,cod_bulto,num_bulto, ";
					$Insertar.=" fecha_embarque,fecha_programacion,bulto_paquetes,bulto_peso,cod_marca,cod_producto";
					$Insertar.=",cod_subproducto,cod_cliente,cod_puerto,cod_agente,cod_estiba,cod_acopio,cod_confirmado,";
					$Insertar.=" tipo_embarque,tipo_enm_code,cod_nave,num_viaje,cod_sub_cliente,rut_cliente,fecha_envio,tipo) values(";
					$Insertar.="'".$TxtNumEnvio."','".$corr_enm."','".$cod_bulto."','".$num_bulto."','".$fecha_embarque."','".$fecha_programacion."', ";
					$Insertar.=" '".$bulto_paquetes."','".$bulto_peso."','".$cod_marca."','".$cod_producto."','".$cod_subproducto."','".$cod_cliente."' ";
					$Insertar.=",'".$cod_puerto."','".$cod_agente."','".$cod_estiba."','".$cod_acopio."','C','T','E','".$cod_nave."','".$num_viaje."','".$CodSubCliente."','".$Rut."','".$FechaEnvio."','V')";
					mysqli_query($link, $Insertar);
					$Actualizar="UPDATE sec_web.programa_enami set estado2='C' where corr_enm=".$corr_enm;
					mysqli_query($link, $Actualizar);
					$Fecha3 = date("Y-m-d");
					$Datos3=explode('//',$Valores2);
					foreach($Datos3 as $Clave1 => $Valor3)
					{
						$RutTrasp=$Valor3[0];
						$Insertar="INSERT INTO relacion_transporte_inst_embarque ";	
						$Insertar.="(rut_transportista,corr_enm,fecha)  ";
						$Insertar.= " values ('".$RutTrasp."','".$corr_enm."','".$Fecha3."')";
						mysqli_query($link, $Insertar);
					}	
					echo "<script languaje='JavaScript'>";
					echo "window.opener.document.FrmProgLoteo.action='sec_programa_adm_loteo.php?TipoIE=Ventanas';";
					echo "window.opener.document.FrmProgLoteo.submit();";
					echo "window.close();";
					echo "</script>";
					//header('location:sec_programa_adm_loteo.php?TipoIE=Ventanas');
				}
				else
				{
					echo "<script languaje='JavaScript'>";
					echo "window.opener.document.FrmProgLoteo.action='sec_programa_adm_loteo.php?TipoIE=Ventanas&Mensaje='".$Mensaje.";";
					echo "window.opener.document.FrmProgLoteo.submit();";
					echo "window.close();";
					echo "</script>";
					//header('location:sec_programa_adm_loteo.php?TipoIE=Ventanas&Mensaje='.$Mensaje);
				}
			}	
			break;	
	}	
?>
