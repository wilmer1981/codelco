<?php
	include("../principal/conectar_principal.php");
	include("../age_web/age_funciones.php");
	include("funciones_interfaces_codelco.php");

	
	$FechaHora = str_replace(" ","_",date("Y_m_d H_i"));	

	switch($Proceso)
	{
		case "G"://TRASPASDO RECEPCIONES
			$FechaDesde=$Ano."-".$Mes."-01 00:00:00";
			$FechaHasta=$Ano."-".$Mes."-31 23:59:59";
			$Consulta="select distinct rut_proveedor from interfaces_codelco.asignaciones where rut_proveedor<>'99999999-9'";
			$RespAsig= mysqli_query($link, $Consulta);	
			$RutCompra="(";
			while ($FilaAsig=mysqli_fetch_array($RespAsig))
			{			
				$RutCompra=$RutCompra."'".$FilaAsig["rut_proveedor"]."',";
			}
			$RutCompra=substr($RutCompra,0,strlen($RutCompra)-1);
			$RutCompra=$RutCompra.")";
			$ArchivoR = fopen("archivos_recepcion/registro_recepcion_".$FechaHora.".doc","w+");
			$ArchivoL = fopen("archivos_recepcion/registro_leyes_".$FechaHora.".doc","w+");
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~~',$v);
				$Lote=$Datos2[0];
				$SubProducto=$Datos2[1];
				$RutPrv=$Datos2[2];
				$ClaseMov =$Datos2[3];
				$Consulta="select case when isnull(t4.materiales_sap) then '99' else t4.materiales_sap end as mat_sap,t3.materiales_sap,t3.pedido,t3.posicion,";
				$Consulta.="t3.clase_valorizacion as clase_valor_101,t1.cod_producto ,t1.cod_subproducto ,t1.rut_proveedor as rut,t1.lote,t1.fecha_recepcion,sum(peso_neto) as peso, "; 
				$Consulta.="t5.codigo_op,t5.cod_material_sap,t5.unidad_medida,t5.clase_valorizacion as clase_valor_921 from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote = t2.lote ";
				$Consulta.="left join interfaces_codelco.pedido_de_compra t3 on t1.rut_proveedor=t3.rut and t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
				$Consulta.="left join interfaces_codelco.homologacion t4 on t1.cod_producto=t4.cod_producto and t1.cod_subproducto=t4.cod_subproducto ";
				$Consulta.="left join interfaces_codelco.ordenes_produccion t5 on t1.cod_producto=t5.cod_producto and t1.cod_subproducto=t5.cod_subproducto ";
				$Consulta.="where t1.fecha_recepcion between '$FechaDesde' and '$FechaHasta' and t1.cod_producto='1' and t1.cod_subproducto='$SubProducto' ";
				if($RutPrv=='99999999-9')
				{	
					$Consulta.="and t1.rut_proveedor not in ".$RutCompra;
					$Consulta.="group by t1.cod_subproducto";	
				}	
				else
				{
					$Consulta.="and t1.rut_proveedor = '".$RutPrv."'";
					$Consulta.="group by t1.rut_proveedor";
				}	
				//echo $Consulta;
				$Resp = mysqli_query($link, $Consulta);	
				$Fila = mysqli_fetch_array($Resp);
				//PARA ARCHIVO DE RECEPCIONES
				$FechaDoc=substr($Fila[fecha_recepcion],8,2).".".substr($Fila[fecha_recepcion],5,2).".".substr($Fila[fecha_recepcion],0,4);
				$FechaCont=substr($Fila[fecha_recepcion],8,2).".".substr($Fila[fecha_recepcion],5,2).".".substr($Fila[fecha_recepcion],0,4);
				//$Pedido=str_pad($Fila[pedido],10,' ',STR_PAD_LEFT);
				//$Posicion=str_pad($Fila[posicion],5,' ',STR_PAD_LEFT);
				$Centro="FV01";
				$Almacen="0005";
				$OrdenProd=str_pad($Fila[codigo_op],12,' ',STR_PAD_LEFT);
				$CodMaterial=str_pad($Fila[cod_material_sap],18,' ',STR_PAD_LEFT);
				$Cantidad=str_pad(number_format($Fila["peso"],3,',',''),13,' ',STR_PAD_LEFT);
				$UnidadMedida=str_pad($Fila[unidad_medida],3,' ',STR_PAD_LEFT);
				$LoteT=substr($Fila[fecha_recepcion],0,4).$Fila["lote"];
				$Status=str_pad('',81,' ');
				$ClaseVal101=str_pad($Fila[clase_valor_101],10,' ',STR_PAD_LEFT);
				$ClaseVal921=str_pad($Fila[clase_valor_921],10,' ',STR_PAD_LEFT);
				if($ClaseMov=='101')
					$LineaR='5'.$FechaDoc.$FechaCont.$ClaseMov.$Centro.$Almacen.$Cantidad.$LoteT.$Status;
				else
					$LineaR='1'.$FechaDoc.$FechaCont.$ClaseMov.$Centro.$Almacen.$OrdenProd.$CodMaterial.$Cantidad.$UnidadMedida.$LoteT.$ClaseVal921.$Status;
				fwrite($ArchivoR,$LineaR."\r\n");
				$Insertar="INSERT INTO interfaces_codelco.registro_traspaso (tipo_registro,ano,mes,referencia,tipo_movimiento,registro) values(";
				$Insertar.="'5','$Ano','$Mes','$Lote','$ClaseMov','$LineaR')";
				mysqli_query($link, $Insertar);
				//PARA ARCHIVO LEYES DE RECEPCIONES
				$CodMaterial=str_pad($Fila[mat_sap],18,'0',STR_PAD_LEFT);
				$Centro="FV01";
				$LoteR=substr($Fila[fecha_recepcion],0,4).$Fila["lote"];
				$Almacen='0005';
				$LoteLibre='X';
				$FechaDisp=substr($Fila[fecha_recepcion],8,2).".".substr($Fila[fecha_recepcion],5,2).".".substr($Fila[fecha_recepcion],0,4);
				$LoteClasif='X';
				$ArrDatos=array();
				$ArregloLeyes=array();
				if($RutPrv=='99999999-9')
				{	
					$ArrLeyesProd=array();
					DefinirArregloLeyes('1',$SubProducto,&$ArrLeyesProd);
					LeyesProducto($RutCompra,'','','1',$SubProducto,&$ArrDatos,&$ArrLeyesProd,'N','S','S',$FechaDesde,$FechaHasta,"");
					reset($ArrLeyesProd);
					while(list($c,$v)=each($ArrLeyesProd))
					{
						if($c!='')
							$ArregloLeyes[$c]["valor"]=number_format($v[2],3,',','');
					}
				}	
				else
				{
					$ArrLeyesProv=array();
					DefinirArregloLeyes('1',$SubProducto,&$ArrLeyesProv);
					LeyesProveedor('',$RutPrv,'1',$SubProducto,&$ArrDatos,&$ArrLeyesProv,'N','S','S',$FechaDesde,$FechaHasta,"");
					reset($ArrLeyesProv);
					while(list($c,$v)=each($ArrLeyesProv))
					{
						if($c!='')
							$ArregloLeyes[$c]["valor"]=number_format($v[2],3,',','');
					}
				}	
				$ValorLeyes='';
				reset($ArregloLeyes);
				while(list($c,$v)=each($ArregloLeyes))
				{
					$ValorLeyes=$ValorLeyes.str_pad(strval($v["valor"]),15," ",STR_PAD_LEFT);
				}
				if($ArrDatos["peso_bruto"]==0)
					$PesoBruto=str_pad("0,000",15,' ',STR_PAD_LEFT);
				else
					$PesoBruto=str_pad(number_format($ArrDatos["peso_bruto"],3,',',''),15,' ',STR_PAD_LEFT);
				if($ArrDatos["peso_neto"]==0)
					$PesoNeto=str_pad("0,000",15,' ',STR_PAD_LEFT);
				else
					$PesoNeto=str_pad(number_format($ArrDatos["peso_neto"],3,',',''),15,' ',STR_PAD_LEFT);
				if($ArrDatos["peso_tara"]==0)
					$PesoTara=str_pad("0,000",15,' ',STR_PAD_LEFT);
				else	
					$PesoTara=str_pad(number_format($ArrDatos["peso_tara"],3,',',''),15,' ',STR_PAD_LEFT);
				$UnidPeso=str_pad('KG',15,' ',STR_PAD_RIGHT);
				$CantDesp1=str_pad('0',15,' ',STR_PAD_LEFT);
				$FormEmpaque1=str_pad('',15,' ',STR_PAD_RIGHT);
				$CantDesp2=str_pad('0',15,' ',STR_PAD_LEFT);
				$FormEmpaque2=str_pad('',15,' ',STR_PAD_RIGHT);
				$LoteProd=substr($Fila[fecha_recepcion],0,4).$Lote;
				$LineaL='3'.$CodMaterial.$Centro.$LoteR.$Almacen.$LoteLibre.$FechaDisp.$LoteClasif.$ValorLeyes;
				$LineaL=$LineaL.$PesoBruto.$PesoNeto.$PesoTara.$UnidPeso.$CantDesp1.$FormEmpaque1.$CantDesp2.$FormEmpaque2.$LoteProd;
				fwrite($ArchivoL,$LineaL."\r\n");
			}
			fclose($ArchivoR);
			fclose($ArchivoL);
			$Mensaje='Archivos Creados Existosamente';
			break;
	}
	header('location:traspaso_recepcion.php?Mostrar=S&Mes='.$Mes."&Ano=".$Ano."&CmbSubProducto=".$CmbSubProducto."&Mensaje=".$Mensaje);		
?>