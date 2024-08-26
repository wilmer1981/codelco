<?php
function ToleranciaPesaje($link)
{
	$Tolerancia=0;
	$Consulta = "Select valor1 from proyecto_modernizacion.clase where cod_clase='24007'  ";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		$Tolerancia=$Fila["valor1"];
	} 
	return ($Tolerancia);
	
}
	function ImprimirRecepcion($Correlativo,$Romana,$OpeSalida,$link)
	//function ImprimirRecepcion($Correlativo,$Romana,$link)
	{
		$Consulta = "SELECT t1.correlativo,t1.bascula_entrada , t1.bascula_salida, t1.rut_operador, t1.lote, t1.Correlativo, t1.peso_bruto, ";
		$Consulta.= "t1.hora_entrada , t1.fecha, t1.recargo, t1.ult_registro, t1.conjunto, ";
		$Consulta.= "t1.peso_tara, t1.hora_salida, t1.peso_neto, t3.nombre_prv as nom_proveedor, t1.rut_prv, ";
		$Consulta.= "t1.cod_producto, t1.cod_subproducto, t8.abast_minero, ";
		$Consulta.= "t5.descripcion as nom_subproducto, t1.conjunto,t9.apellido_paterno,t9.apellido_materno,t9.nombres, ";
		$Consulta.= "t6.fecha_padron,t6.nombre_mina as nom_faena, t6.sierra,t6.comuna,t6.comuna,t1.cod_mina,t1.cod_clase,t1.romana_entrada,t1.romana_salida,";
		$Consulta.= "t1.leyes, t1.impurezas, t1.observacion, t1.patente, t1.guia_despacho,case when t7.asignacion is null then 'MAQ_ENM' else t7.asignacion end as asig ";
		$Consulta.= "from sipa_web.recepciones t1 left join sipa_web.proveedores t3 on t1.rut_prv=t3.rut_prv ";
		$Consulta.= "left join sipa_web.minaprv t6 on t1.cod_mina=t6.cod_mina and t1.rut_prv=t6.rut_prv ";
		$Consulta.= "inner join proyecto_modernizacion.subproducto t5 on t1.cod_producto=t5.cod_producto and t1.cod_subproducto=t5.cod_subproducto ";
		$Consulta.= "left join sipa_web.rut_asignacion t7 on t1.rut_prv=t7.rut_prv ";
		$Consulta.= "left join sipa_web.grupos_productos t8 on t1.cod_grupo=t8.cod_grupo ";
		$Consulta.= "left join proyecto_modernizacion.funcionarios t9 on t1.rut_operador=t9.rut ";
		$Consulta.= "where correlativo='".$Correlativo."' and t1.tipo<>'A'";//TIPO=A SON LOTES AUTOMATICOS DE TENIENTES
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Resp))
		{
			//$NomArchivo = "R".$Romana."_CorrImprimir.txt";
			$NomArchivo = "sipaweb\R".$Romana."_CorrImprimir.txt";
			$Archivo = fopen($NomArchivo,"w+");
			fwrite($Archivo,"02"."\r\n");
			fwrite($Archivo,"FUNDICION Y REFINERIA VENTANAS"."\r\n");
			//	fwrite($Archivo,"E- ".$Fila[romana_entrada]." - ".$Fila["bascula_entrada"]."\r\n");
			//Valor cambiado para que solo aparezca el numero de la bascula   LUIS ADAN CASTILLO 19-01-2015
			fwrite($Archivo,"0".$Fila["bascula_entrada"]."\r\n");
			//fwrite($Archivo,$Romana."\r\n");
			//fwrite($Archivo,"S- ".$Fila[romana_salida]." - ".$Fila["bascula_salida"]."\r\n");
			fwrite($Archivo,"0".$Fila["bascula_salida"]."\r\n");
			fwrite($Archivo,strtoupper(substr($Fila["nombres"],0,1)).strtoupper(substr($Fila["apellido_paterno"],0,1)).strtoupper(substr($Fila["apellido_materno"],0,1))." - ".$OpeSalida."\r\n");
			fwrite($Archivo,$Fila["lote"]."\r\n");
			fwrite($Archivo,$Fila["correlativo"]."\r\n");
			fwrite($Archivo,$Fila["peso_bruto"]."\r\n");
			fwrite($Archivo,$Fila["hora_entrada"]."\r\n");
			fwrite($Archivo,$Fila["fecha"]."\r\n");
			fwrite($Archivo,$Fila["recargo"]."\r\n");
			fwrite($Archivo,$Fila["ult_registro"]."\r\n");
			fwrite($Archivo,$Fila["fecha_padron"]."\r\n");
			fwrite($Archivo,$Fila["peso_tara"]."\r\n");
			fwrite($Archivo,$Fila["hora_salida"]."\r\n");
			fwrite($Archivo,$Fila["peso_neto"]."\r\n");
			if($Fila["ult_registro"]=='S')//ACUMULAR PESO TOTAL LOTE
			{
				$Consulta = "SELECT sum(peso_neto) as tot_peso_lote from sipa_web.recepciones  where lote='".$Fila["lote"]."' group by lote";
				//echo $Consulta."<br>";
				$Resp2 = mysqli_query($link, $Consulta);
				$Fila2 = mysqli_fetch_array($Resp2);
				fwrite($Archivo,"PESO TOTAL LOTE:".$Fila2["tot_peso_lote"]."\r\n");
			}
			else
				fwrite($Archivo,""."\r\n");
			fwrite($Archivo,$Fila["nom_proveedor"]."\r\n");
			if($Fila["rut_prv"]=='90132000-5')
				fwrite($Archivo,'90132000-4'."\r\n");
			else
				fwrite($Archivo,$Fila["rut_prv"]."\r\n");
			fwrite($Archivo,$Fila["nom_faena"]."\r\n");
			fwrite($Archivo,$Fila["sierra"]."/".$Fila["comuna"]."\r\n");
			fwrite($Archivo,$Fila["cod_mina"]."\r\n");
			fwrite($Archivo,$Fila["cod_subproducto"]."\r\n");
			fwrite($Archivo,$Fila["nom_subproducto"]."\r\n");
			if($Fila["abast_minero"]=='S')
				fwrite($Archivo,$Fila["asig"]."\r\n");
			else
				fwrite($Archivo,""."\r\n");
			fwrite($Archivo,$Fila["cod_clase"]."\r\n");
			$Leyes='';$Impurezas='';
			$Datos=explode('~',$Fila["leyes"]);
			foreach($Datos as $c => $v)
			{
				$Consulta="SELECT * from proyecto_modernizacion.leyes where cod_leyes ='".$v."'";
				$RespLeyes=mysqli_query($link, $Consulta);
				if($FilaLeyes=mysqli_fetch_array($RespLeyes))
					$Leyes=$Leyes.$FilaLeyes["abreviatura"]."~";
			}
			if($Leyes!='')
				$Leyes=substr($Leyes,0,strlen($Leyes)-1);
			fwrite($Archivo,$Leyes."\r\n");
			$Datos=explode('~',$Fila["impurezas"]);
			foreach($Datos as $c => $v)
			{
				$Consulta="SELECT * from proyecto_modernizacion.leyes where cod_leyes ='".$v."'";
				$RespLeyes=mysqli_query($link, $Consulta);
				if($FilaLeyes=mysqli_fetch_array($RespLeyes))
					$Impurezas=$Impurezas.$FilaLeyes["abreviatura"]."~";
			}
			if($Impurezas!='')
				$Impurezas=substr($Impurezas,0,strlen($Impurezas)-1);
			fwrite($Archivo,$Impurezas."\r\n");
			fwrite($Archivo,$Fila["observacion"]."\r\n");
			fwrite($Archivo,$Fila["patente"]."\r\n");
			fwrite($Archivo,$Fila["guia_despacho"]."\r\n");
			fwrite($Archivo,$Fila["conjunto"]."\r\n");
			fclose($Archivo);	
		}
	}	
	
	function ImprimirDespachos($Correlativo,$Romana,$OpeSalida,$link)
	{
		$Consulta = "SELECT t1.correlativo,t1.bascula_entrada , t1.bascula_salida, t1.rut_operador, t1.lote, t1.correlativo, t1.peso_bruto, ";
		$Consulta.= "t1.hora_entrada , t1.fecha, t1.recargo, t1.ult_registro, t1.peso_tara, t1.hora_salida, t1.peso_neto, t1.rut_prv, t3.nombre_prv, ";
		$Consulta.= "t1.cod_producto, t1.cod_subproducto, t5.descripcion as nom_subproducto, t1.conjunto,";
		$Consulta.= "t1.observacion, t1.patente, t1.guia_despacho,t6.nombre_subclase as tipo_despacho,t9.apellido_paterno,t9.apellido_materno,t9.nombres, t1.romana_entrada, t1.romana_salida ";
		$Consulta.= "from sipa_web.despachos t1 ";
		$Consulta.= "left join proyecto_modernizacion.subproducto t5 on t1.cod_producto=t5.cod_producto and t1.cod_subproducto=t5.cod_subproducto ";
		$Consulta.= "left join proyecto_modernizacion.sub_clase t6 on t6.valor_subclase1= t1.cod_despacho ";
		$Consulta.= "left join proyecto_modernizacion.funcionarios t9 on t1.rut_operador=t9.rut ";
		$Consulta.= "left join sipa_web.proveedores t3 on t1.rut_prv = t3.rut_prv  ";
		
		$Consulta.= "where correlativo='".$Correlativo."'";
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Resp))
		{
			//$NomArchivo = "R".$Romana."_CorrImprimir.txt";
			$NomArchivo = "sipaweb/R".$Romana."_CorrImprimir.txt";
			$Archivo = fopen($NomArchivo,"w+");
			fwrite($Archivo,"02"."\r\n");
			fwrite($Archivo,"FUNDICION Y REFINERIA VENTANAS"."\r\n");
			//fwrite($Archivo,$Fila[rom_entra]." - ".$Romana."\r\n");
			fwrite($Archivo,"0".$Fila["bascula_entrada"]."\r\n");
			fwrite($Archivo,"0".$Fila["bascula_salida"]."\r\n");
			fwrite($Archivo,strtoupper(substr($Fila["nombres"],0,1)).strtoupper(substr($Fila["apellido_paterno"],0,1)).strtoupper(substr($Fila["apellido_materno"],0,1))." - ".$OpeSalida."\r\n");
			fwrite($Archivo,$Fila["lote"]."\r\n");
			fwrite($Archivo,$Fila["correlativo"]."\r\n");
			fwrite($Archivo,$Fila["peso_bruto"]."\r\n");
			fwrite($Archivo,$Fila["hora_entrada"]."\r\n");
			fwrite($Archivo,$Fila["fecha"]."\r\n");
			fwrite($Archivo,$Fila["recargo"]."\r\n");
			fwrite($Archivo,$Fila["ult_registro"]."\r\n");
			//fwrite($Archivo,$Fila["fecha_padron"]."\r\n");
			fwrite($Archivo,$Fila["peso_tara"]."\r\n");
			fwrite($Archivo,$Fila["hora_salida"]."\r\n");
			fwrite($Archivo,$Fila["peso_neto"]."\r\n");
			if($Fila["ult_registro"]=='S')//ACUMULAR PESO TOTAL LOTE
			{
				$Consulta = "SELECT sum(peso_neto) as tot_peso_lote from sipa_web.despachos  where lote='".$Fila["lote"]."' group by lote";
				//echo $Consulta."<br>";
				$Resp2 = mysqli_query($link, $Consulta);
				$Fila2 = mysqli_fetch_array($Resp2);
				fwrite($Archivo,"PESO TOTAL LOTE:".$Fila2["tot_peso_lote"]."\r\n");
			}
			else
				fwrite($Archivo,""."\r\n");
			
			$RutPrv=$Fila["rut_prv"];
			$NomPrv=$Fila["nombre_prv"];
			ObtenerProveedorDespacho('D',$Fila["rut_prv"],$Fila["correlativo"],$Fila["guia_despacho"],$RutPrv,$NomPrv,$link);
			fwrite($Archivo,$NomPrv."\r\n");
			fwrite($Archivo,$RutPrv."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,$Fila["cod_subproducto"]."\r\n");
			fwrite($Archivo,$Fila["nom_subproducto"]."\r\n");
			fwrite($Archivo,$Fila["tipo_despacho"]."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,$Fila["observacion"]."\r\n");
			fwrite($Archivo,$Fila["patente"]."\r\n");
			fwrite($Archivo,$Fila["guia_despacho"]."\r\n");
			fwrite($Archivo,""."\r\n");
			fclose($Archivo);	
		}
	}	
	function ImprimirOtrosPesajes($Correlativo,$Romana,$OpeSalida,$link)
	{
		$Consulta = "SELECT t1.nombre,t1.descripcion,t1.correlativo,t1.bascula_entrada , t1.bascula_salida, t1.rut_operador, t1.Correlativo, t1.peso_bruto, ";
		$Consulta.= "t1.hora_entrada , t1.fecha, t1.peso_tara, t1.hora_salida, t1.peso_neto, t1.conjunto, t1.romana_entrada, t1.romana_salida, ";
		$Consulta.= "t1.observacion, t1.patente, t1.guia_despacho,t2.apellido_paterno,t2.apellido_materno,t2.nombres ";
		$Consulta.= "from sipa_web.otros_pesaje t1 ";
		$Consulta.= "left join proyecto_modernizacion.funcionarios t2 on t1.rut_operador=t2.rut ";		
		$Consulta.= "where correlativo='".$Correlativo."'";
		//echo $Consulta;
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Resp))
		{
			//$NomArchivo = "R".$Romana."_CorrImprimir.txt";
			$NomArchivo = "sipaweb/R".$Romana."_CorrImprimir.txt";
			$Archivo = fopen($NomArchivo,"w+");
			fwrite($Archivo,"02"."\r\n");
			fwrite($Archivo,"FUNDICION Y REFINERIA VENTANAS"."\r\n");
			//fwrite($Archivo,$Romana."\r\n");
			fwrite($Archivo,"0".$Fila["bascula_entrada"]."\r\n");
			fwrite($Archivo,"0".$Fila["bascula_salida"]."\r\n");
			fwrite($Archivo,strtoupper(substr($Fila["nombres"],0,1)).strtoupper(substr($Fila["apellido_paterno"],0,1)).strtoupper(substr($Fila["apellido_materno"],0,1))." - ".$OpeSalida."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,$Fila["correlativo"]."\r\n");
			fwrite($Archivo,$Fila["peso_bruto"]."\r\n");
			fwrite($Archivo,$Fila["hora_entrada"]."\r\n");
			fwrite($Archivo,$Fila["fecha"]."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,$Fila["peso_tara"]."\r\n");
			fwrite($Archivo,$Fila["hora_salida"]."\r\n");
			fwrite($Archivo,$Fila["peso_neto"]."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,strtoupper($Fila["nombre"])."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,strtoupper($Fila["descripcion"])."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,""."\r\n");
			fwrite($Archivo,$Fila["observacion"]."\r\n");
			fwrite($Archivo,$Fila["patente"]."\r\n");
			fwrite($Archivo,$Fila["guia_despacho"]."\r\n");
			fwrite($Archivo,""."\r\n");
			fclose($Archivo);	
		}
	}
	function CrearArchivoEjes($Corr,$Patente,$CodMop,$CodSubProd,$DescripSubPro,$NomPrv,$Guia)
	{
		//$NomArchivo = "entrada/".$Corr.".txt";
		$NomArchivo = "sipaweb/entrada/".$Corr.".txt";
		$Archivo = fopen($NomArchivo,"w+");
		fwrite($Archivo,strtoupper($Patente)."\r\n");
		fwrite($Archivo,""."\r\n");
		fwrite($Archivo,$CodMop."\r\n");
		fwrite($Archivo,$CodSubProd."\r\n");
		fwrite($Archivo,$DescripSubPro."\r\n");
		fwrite($Archivo,$NomPrv."\r\n");
		fwrite($Archivo,$Guia."\r\n");
		fclose($Archivo);	
	}
	function CrearArchivoResp($Origen,$Proceso,$Corr,$Lote,$Rec,$UltReg,$RutOpe,$Basc1,$Basc2,$Fecha,$HE,$HS,$PB,$PT,$PN,$Prv,$CMina,$CGrupo,$CProd,$CSubProd,$Guia,$Patente,$CClase,$CConj,$Obs,$CVenta,$Leyes,$Impurezas,$Hum,$CMop)
	{
		switch($Origen)
		{
			case "R":
				$NomArchivo = "RespRecepcion/".$Proceso.$Corr.".txt";
				break;
			case "D":
				$NomArchivo = "RespDespachos/".$Proceso.$Corr.".txt";
				break;
			case "O":
				$NomArchivo = "RespOtrosPesajes/".$Proceso.$Corr.".txt";
				break;
		}
		$Archivo = fopen($NomArchivo,"w+");
		fwrite($Archivo,$Corr."\r\n");
		fwrite($Archivo,$Lote."\r\n");
		fwrite($Archivo,$Rec."\r\n");
		fwrite($Archivo,$UltReg."\r\n");
		fwrite($Archivo,$RutOpe."\r\n");
		fwrite($Archivo,$Basc1."\r\n");
		fwrite($Archivo,$Basc2."\r\n");
		fwrite($Archivo,$Fecha."\r\n");
		fwrite($Archivo,$HE."\r\n");
		fwrite($Archivo,$HS."\r\n");
		fwrite($Archivo,intval($PB)."\r\n");
		fwrite($Archivo,intval($PT)."\r\n");
		fwrite($Archivo,intval($PN)."\r\n");
		fwrite($Archivo,$Prv."\r\n");
		fwrite($Archivo,$CGrupo."\r\n");
		fwrite($Archivo,$CProd."\r\n");
		fwrite($Archivo,$CSubProd."\r\n");
		fwrite($Archivo,$Guia."\r\n");
		fwrite($Archivo,strtoupper($Patente)."\r\n");
		fwrite($Archivo,$CClase."\r\n");
		fwrite($Archivo,$CMop."\r\n");
		fwrite($Archivo,$CConj."\r\n");
		fwrite($Archivo,strtoupper($Obs)."\r\n");
		fwrite($Archivo,$CVenta."\r\n");
		fwrite($Archivo,$Leyes."\r\n");
		fwrite($Archivo,$Impurezas."\r\n");
		fwrite($Archivo,$Hum."\r\n");
		fwrite($Archivo,$CMop."\r\n");
		fclose($Archivo);	
	}
	function ObtenerProveedorDespacho($TipoProceso,$RutPrv,$Corr,$Guia,$RutProved,$NombreProved,$link)			
	{
		switch($TipoProceso)
		{
			case "R":
				break;
			case "D":
				$Consulta = "SELECT distinct rut as rut_cliente,sigla_cliente from sec_web.cliente_venta ";
				$Consulta.= "where rut='".$RutPrv."'";
				//echo "uno".$Consulta."<br>";
				$Resp2 = mysqli_query($link, $Consulta);
				if($Fila2 = mysqli_fetch_array($Resp2))
				{
					$RutProved=$Fila2["rut_cliente"];
					$NombreProved=$Fila2["sigla_cliente"];
				}
				else
				{
					$Consulta = "SELECT distinct t2.rut_cliente,nombre_nave as sigla_cliente from sec_web.nave t1 inner join ";
					$Consulta.= "sec_web.sub_cliente_vta t2 on t1.cod_nave=t2.cod_cliente where rut_cliente ='".$RutPrv."' group by rut_cliente";
					$Resp2 = mysqli_query($link, $Consulta);
					//echo "dosssss".$Consulta."<br>";				
					if($Fila2 = mysqli_fetch_array($Resp2))
					{
						$RutProved=$Fila2["rut_cliente"];
						$NombreProved=$Fila2["sigla_cliente"];
					}
					else
					{
						$Consulta ="SELECT t3.cod_acopio,t3.cod_estiba,t3.tipo_embarque from sec_web.guia_despacho_emb t1 ";
						$Consulta.="inner join sec_web.embarque_ventana t3 on t3.num_envio=t1.num_envio and year (t3.fecha_embarque)='".date('Y')."'";
						$Consulta.="where t1.num_secuencia='".$Corr."' and t1.num_guia='".$Guia."' and t1.cod_estado <> 'A'";
						$Consulta.="group by t3.cod_producto,t3.cod_subproducto	";
						//echo "tres".$Consulta."<br>";
						$RespSec=mysqli_query($link, $Consulta);
						$FilaSec=mysqli_fetch_array($RespSec);
						$CodPrestador="";
						$tipo_embarque = isset($FilaSec["tipo_embarque"])?$FilaSec["tipo_embarque"]:"";
						//switch($FilaSec["tipo_embarque"])
						switch($tipo_embarque)
						{
							case "A":
								if($FilaSec["cod_acopio"]!='')
									$CodPrestador=$FilaSec["cod_acopio"];
								else
									$CodPrestador=$FilaSec["cod_estiba"];
								break;	
							case "E":
								if($FilaSec["cod_estiba"]!='')
									$CodPrestador=$FilaSec["cod_estiba"];
								else
									$CodPrestador=$FilaSec["cod_acopio"];
								break;	
						}	
						$Consulta= "SELECT distinct rut as rut_cliente,sigla as sigla_cliente from sec_web.prestador ";
						$Consulta.= "where cod_prestador_servicio='".$CodPrestador."' and rut ='".$RutPrv."' group by rut";
						//echo "cuatro".$Consulta."<br>";
						$Resp2 = mysqli_query($link, $Consulta);
						if($Fila2 = mysqli_fetch_array($Resp2))
						{
							$RutProved=$Fila2["rut_cliente"];
							$NombreProved=$Fila2["sigla_cliente"];
						}
						else
						{
							$Consulta = "SELECT distinct rut_cliente,nombre from pac_web.clientes where rut_cliente='".$RutPrv."'";
							$Resp2 = mysqli_query($link, $Consulta);
							//echo "cinco".$Consulta."<br>";				
							if($Fila2 = mysqli_fetch_array($Resp2))
							{
								$RutProved=$Fila2["rut_cliente"];
								$NombreProved=$Fila2["nombre"];
							}
							else
							{
								$Consulta = "SELECT distinct rut_prv,nombre_prv from sipa_web.proveedores where rut_prv='".$RutPrv."'";
								$Resp2 = mysqli_query($link, $Consulta);
								//echo "seis".$Consulta."<br>";					
								if ($Fila2 = mysqli_fetch_array($Resp2))
								{
									$RutProved=$Fila2["rut_prv"];
									$NombreProved=$Fila2["nombre_prv"];
									
								}
								else
								{
									if(strpos($RutPrv,'~'))
									{
										$PROV=explode('~',$RutPrv);
										$Consulta = "SELECT distinct rut_cliente,nombre from pac_web.clientes where rut_cliente='".$PROV[0]."' and corr_interno_cliente='".$PROV[1]."'";
										$Resp2 = mysqli_query($link, $Consulta);
										if ($Fila2 = mysqli_fetch_array($Resp2))
										{
											$RutProved=$Fila2["rut_cliente"];
											$NombreProved=$Fila2["nombre"];
											
										}else
										{//echo "siete";
											$RutProved=$RutPrv;
											$NombreProved='';
										}
									
									}
								}
							}
						}					
					}	
				}
				break;
		}		
	}
	//FUNCION PARA CREAR S.A
	function CrearSA($Lote,$Recargo,$Proveedor,$UltRec,$Producto,$SubProducto,$Leyes,$Impurezas,$RutOperador,$link)
	{
		$FechaHora=date('Y-m-d H:i');
		$Datos=explode('~',$ProdSubProd);
		$Consulta="SELECT * from sipa_web.proveedores where rut_prv='$Proveedor' and hum_ult_rec<>'S'";
		//echo $Consulta."<br>";
		$RespPrv=mysqli_query($link, $Consulta);
		if($FilaPrv=mysqli_fetch_array($RespPrv))
		{
			$Consulta2 = "SELECT valor1, valor2 from proyecto_modernizacion.clase where cod_clase = '1012' ";
			$Respuesta2 = mysqli_query($link, $Consulta2);
			if ($Fila2=mysqli_fetch_array($Respuesta2))
			{
				$CC=$Fila2["valor1"];
				$Area=$Fila2["valor2"];	
			}
			//VERIFICA SI EXISTE OTRO RECARGO CON NRO DE SOLICITUD PARA TOMAR SUS VALORES E INSERTARLO EN FORMA AUTOMATICA
			$Consulta ="SELECT * from cal_web.solicitud_analisis where id_muestra = '".$Lote."' and cod_producto ='".$Producto."' ";
			$Consulta.="and cod_subproducto='".$SubProducto."' and tipo_solicitud = 'A' and ((nro_solicitud is not null) or (nro_solicitud <> ''))";
			//echo $Consulta."<br><BR>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sipa_web.recepciones set sa_asignada=".$Fila["nro_solicitud"].",activo = 'N' where lote='".$Lote."' and recargo='".$Recargo."'";
				mysqli_query($link, $Actualizar);
				$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
				$Insertar.="leyes,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
				$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
				$Insertar.= "'".$Fila["rut_funcionario"]."','".$Fila["FECHA_HORA"]."','$Lote','".$Recargo."','$Producto','$SubProducto','01~~1//','1',";			
				$Insertar.= "'3','A','".$Fila["nro_solicitud"]."','$Area','$CC','1','1','$Proveedor','','1','$FechaHora')";
				//echo $Insertar."<br><BR>";
				mysqli_query($link, $Insertar);
				$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
				$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["nro_solicitud"]."','".$Recargo."','1','".$Fila["FECHA_HORA"]."','N','".$Fila["rut_funcionario"]."')";
				//echo $Insertar2."<br><BR>";
				mysqli_query($link, $Insertar2);
				$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values (";
				$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["FECHA_HORA"]."','".$Fila["nro_solicitud"]."','".$Recargo."','01','1','$Producto','$SubProducto','$Lote')";
				//echo $Insertar2."<br><BR><BR><BR>";
				mysqli_query($link, $Insertar2);
				if($UltRec=='S')
				{
					$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
					$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["nro_solicitud"]."','0','1','".$Fila["FECHA_HORA"]."','N','".$Fila["rut_funcionario"]."')";
					//echo $Insertar2."<br><BR>";
					mysqli_query($link, $Insertar2);
					$LeyesSA='';$LeyesImp='';					
					$CodLeyes=$Leyes."~".$Impurezas;
					$Leyes=explode('~',$CodLeyes);
					//echo $CodLeyes."<br>";
					foreach($Leyes as  $c =>$v)
					{
						$Consulta="SELECT cod_unidad from proyecto_modernizacion.leyes where cod_leyes='$v'";
						$RespUnidad=mysqli_query($link, $Consulta);
						$FilaUnidad=mysqli_fetch_array($RespUnidad);
						if($v!='01')
						{
							$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values (";
							$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["FECHA_HORA"]."','".$Fila["nro_solicitud"]."','0','$v','".$FilaUnidad["cod_unidad"]."','$Producto','$SubProducto','$Lote')";
							//echo $Insertar2."<br><BR>";
							mysqli_query($link, $Insertar2);
						}
						if(($v=='02')||($v=='03')||($v=='04')||($v=='05'))
							$LeyesSA=$LeyesSA.$v."~~".$FilaUnidad["cod_unidad"]."//";
						else
						{
							if($v!='01')
								$LeyesImp=$LeyesImp.$v."~~".$FilaUnidad["cod_unidad"]."//";
						}
					}
					$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
					$Insertar.="leyes,impurezas,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
					$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
					$Insertar.= "'".$Fila["rut_funcionario"]."','".$Fila["FECHA_HORA"]."','$Lote','0','$Producto','$SubProducto','$LeyesSA','$LeyesImp','1',";			
					$Insertar.= "'3','A','".$Fila["nro_solicitud"]."','$Area','$CC','1','1','$Proveedor','','1','$FechaHora')";
					//echo $Insertar."<br><BR>";
					mysqli_query($link, $Insertar);
				}
			}	
			else
			{
				//echo "PRIMERA SOLICITUD RECARGO 1<br><br>";
				//SE OBTIENE EL NUMERO MAYOR DE LAS SOLICITUDES
				$Consulta = "SELECT max(nro_solicitud) as NroMayor from cal_web.solicitud_analisis";
				$RespSA = mysqli_query($link, $Consulta);
				if ($FilaSA = mysqli_fetch_array($RespSA))
				{
					if ((substr($FilaSA["NroMayor"],0,4)) == (date("Y")))
						$NroSA =$FilaSA["NroMayor"]+1;										
					else
						$NroSA=date("Y")."000001";	
				}
				else
					$NroSA=date("Y")."000001";	
				$Actualizar = "UPDATE sipa_web.recepciones set sa_asignada=".$NroSA.",activo = 'N' where lote='".$Lote."' and recargo='".$Recargo."'";
				mysqli_query($link, $Actualizar);
				$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
				$Insertar.="leyes,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
				$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
				$Insertar.= "'$RutOperador','$FechaHora','$Lote','".$Recargo."','$Producto','$SubProducto','01~~1//','1',";			
				$Insertar.= "'3','A','$NroSA','$Area','$CC','1','1','$Proveedor','','1','$FechaHora')";
				//echo $Insertar."<br><BR>";
				mysqli_query($link, $Insertar);
				$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
				$Insertar2.="'$RutOperador','$NroSA','".$Recargo."','1','$FechaHora','N','$RutOperador')";
				//echo $Insertar2."<br><BR>";
				mysqli_query($link, $Insertar2);
				$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values (";
				$Insertar2.="'$RutOperador','$FechaHora','$NroSA','".$Recargo."','01','1','$Producto','$SubProducto','$Lote')";
				//echo $Insertar2."<br><BR>";
				mysqli_query($link, $Insertar2);
				if($UltRec=='S')
				{
					$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
					$Insertar2.="'$RutOperador','$NroSA','0','1','$FechaHora','N','$RutOperador')";
					//echo $Insertar2."<br><BR>";
					mysqli_query($link, $Insertar2);
					$LeyesSA='';$LeyesImp='';
					$CodLeyes=$Leyes."~".$Impurezas;
					$Leyes=explode('~',$CodLeyes);
					foreach($Leyes as  $c =>$v)
					{
						$Consulta="SELECT cod_unidad from proyecto_modernizacion.leyes where cod_leyes='$v'";
						$RespUnidad=mysqli_query($link, $Consulta);
						$FilaUnidad=mysqli_fetch_array($RespUnidad);
						if($v!='01')
						{
							$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values (";
							$Insertar2.="'$RutOperador','$FechaHora','$NroSA','0','$v','".$FilaUnidad["cod_unidad"]."','$Producto','$SubProducto','$Lote')";
							//echo $Insertar2."<br><BR>";
							mysqli_query($link, $Insertar2);
						}
						if(($v=='02')||($v=='03')||($v=='04')||($v=='05'))
							$LeyesSA=$LeyesSA.$v."~~".$FilaUnidad["cod_unidad"]."//";
						else
						{
							if($v!='01')
								$LeyesImp=$LeyesImp.$v."~~".$FilaUnidad["cod_unidad"]."//";
						}
					}	
					$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
					$Insertar.="leyes,impurezas,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
					$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
					$Insertar.= "'$RutOperador','$FechaHora','$Lote','0','$Producto','$SubProducto','$LeyesSA','$LeyesImp','1',";			
					$Insertar.= "'3','A','$NroSA','$Area','$CC','1','1','$Proveedor','','1','$FechaHora')";
					//echo $Insertar."<br><BR>";
					mysqli_query($link, $Insertar);
				}
			}
		}
		else
		{
			if($UltRec=='S')
			{
				$Consulta = "SELECT max(nro_solicitud) as NroMayor from cal_web.solicitud_analisis";
				$RespSA = mysqli_query($link, $Consulta);
				if ($FilaSA = mysqli_fetch_array($RespSA))
				{
					if ((substr($FilaSA["NroMayor"],0,4)) == (date("Y")))
						$NroSA =$FilaSA["NroMayor"]+1;										
					else
						$NroSA=date("Y")."000001";	
				}
				else
					$NroSA=date("Y")."000001";	
				$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
				$Insertar.="leyes,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
				$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
				$Insertar.= "'$RutOperador','$FechaHora','$Lote','".$Recargo."','$Producto','$SubProducto','01~~1//','1',";			
				$Insertar.= "'3','A','$NroSA','$Area','$CC','1','1','$Proveedor','','1','$FechaHora')";
				//echo $Insertar."<br><BR>";
				mysqli_query($link, $Insertar);
				$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
				$Insertar2.="'$RutOperador','$NroSA','".$Recargo."','1','$FechaHora','N','$RutOperador')";
				//echo $Insertar2."<br><BR>";				
				mysqli_query($link, $Insertar2);
				$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values (";
				$Insertar2.="'$RutOperador','$FechaHora','$NroSA','".$Recargo."','01','1','$Producto','$SubProducto','$Lote')";
				//echo $Insertar2."<br><BR>";
				mysqli_query($link, $Insertar2);
				$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
				$Insertar2.="'$RutOperador','$NroSA','0','1','$FechaHora','N','$RutOperador')";
				//echo $Insertar2."<br><BR>";
				mysqli_query($link, $Insertar2);
				$LeyesSA='';$LeyesImp='';
				$CodLeyes=$Leyes."~".$Impurezas;
				$Leyes=explode('~',$CodLeyes);
				foreach($Leyes as  $c =>$v)
				{
					$Consulta="SELECT cod_unidad from proyecto_modernizacion.leyes where cod_leyes='$v'";
					$RespUnidad=mysqli_query($link, $Consulta);
					$FilaUnidad=mysqli_fetch_array($RespUnidad);
					if($v!='01')					
					{
						$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values (";
						$Insertar2.="'$RutOperador','$FechaHora','$NroSA','0','$v','".$FilaUnidad["cod_unidad"]."','$Producto','$SubProducto','$Lote')";
						//echo $Insertar2."<br><BR>";
						mysqli_query($link, $Insertar2);
					}
					if(($v=='02')||($v=='03')||($v=='04')||($v=='05'))
						$LeyesSA=$LeyesSA.$v."~~".$FilaUnidad["cod_unidad"]."//";
					else
					{
						if($v!='01')
							$LeyesImp=$LeyesImp.$v."~~".$FilaUnidad["cod_unidad"]."//";
					}
				}	
				$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
				$Insertar.="leyes,impurezas,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
				$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
				$Insertar.= "'$RutOperador','$FechaHora','$Lote','0','$Producto','$SubProducto','$LeyesSA','$LeyesImp','1',";			
				$Insertar.= "'3','A','$NroSA','$Area','$CC','1','1','$Proveedor','','1','$FechaHora')";
				//echo $Insertar."<br><BR>";
				mysqli_query($link, $Insertar);
			}
		}
	}
	function CerrarLotesMensuales($TipoRegistro,$link)
	{
		if(intval(date("m"))>1)
			$FechaAnt=date("Y")."-".str_pad((intval(date("m"))-1),2,"0",STR_PAD_LEFT)."-31";
		else
			$FechaAnt=(intval(date("Y"))-1)."-12-31";
		//$FechaAnt = date('Y-m-d',mktime(0,0,0,date("m")-1,date("d"),  date("Y")));
		//echo $FechaAnt."<br>";
		$Consulta="SELECT * from sipa_web.cierre_lotes_mensual where substring(fecha,1,7)='".substr($FechaAnt,0,7)."' and tipo='$TipoRegistro'";
		//echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);
		if(!$Fila=mysqli_fetch_array($Resp))
		{
			$UltDiaMes=date('d',mktime(0,0,0,date("m"),1-1,  date("Y")));
			//$UltDiaMes=substr($UltDiaMes,9,2);
			$TxtFechaIni=substr($FechaAnt,0,7)."-01";
			$TxtFechaFin=substr($FechaAnt,0,7)."-".$UltDiaMes;
			
			$Cont=0;
			$Consulta = "SELECT lote ,recargo,fecha,correlativo,ult_registro from sipa_web.recepciones t1 ";
			$Consulta.= " where t1.fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."' and ";
			$Consulta.= " lpad(recargo,2,'0')=(SELECT max(lpad(recargo,2,'0')) from sipa_web.recepciones where lote=t1.lote) and ult_registro='N' "; 
			$Consulta.= " group by lote ";
			//echo $Consulta;
			$RespLote=mysqli_query($link, $Consulta);
			while($FilaLote=mysqli_fetch_array($RespLote))
			{
				$Actualizar="UPDATE sipa_web.recepciones set ult_registro='S' ";
				$Actualizar.="where lote='".$FilaLote["lote"]."' and recargo='".$FilaLote["recargo"]."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				$Cont=$Cont+1;
			}
			$Insertar="INSERT INTO sipa_web.cierre_lotes_mensual(fecha,cant_cerrados,tipo) values('$TxtFechaFin','$Cont','R')";
			//echo $Insertar;
			mysqli_query($link, $Insertar);
			$Cont=0;
			$Consulta = "SELECT lote ,recargo,fecha,correlativo,ult_registro from sipa_web.despachos t1 ";
			$Consulta.= " where t1.fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."' and ";
			$Consulta.= " lpad(recargo,2,'0')=(SELECT max(lpad(recargo,2,'0')) from sipa_web.despachos where lote=t1.lote) and ult_registro='N' "; 
			$Consulta.= " group by lote ";
			//echo $Consulta."<br>";
			$RespLote=mysqli_query($link, $Consulta);
			while($FilaLote=mysqli_fetch_array($RespLote))
			{
				$Actualizar="UPDATE sipa_web.despachos set ult_registro='S' ";
				$Actualizar.="where lote='".$FilaLote["lote"]."' and recargo='".$FilaLote["recargo"]."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				$Cont=$Cont+1;
			}
			$Insertar="INSERT INTO sipa_web.cierre_lotes_mensual(fecha,cant_cerrados,tipo) values('$TxtFechaFin','$Cont','D')";
			//echo $Insertar;
			mysqli_query($link, $Insertar);
			/*ELIMINA LOS ARCHIVOS DE RESPALDO DEL MES ANTERIOR*/
			if($TipoRegistro=='R')
				$Dir = 'RespRecepcion';
			else
				$Dir = 'RespDespachos';
			$Directorio=opendir($Dir);
			$i=0;
			while ($ArchivoElim = readdir($Directorio)) 
			{
				if($ArchivoElim != '..' && $ArchivoElim !='.' && $ArchivoElim !='')
				{ 		
					if (file_exists($Dir."/".$ArchivoElim))
						unlink($Dir."/".$ArchivoElim);
				}
				$i++;
			}
			closedir($Directorio);
			if($TipoRegistro=='R')//BORRA ARCHIVOS RESPALDO DE OTROS PESAJES
			{
				$Dir = 'RespOtrosPesajes';
				$Directorio=opendir($Dir);
				$i=0;
				while ($ArchivoElim = readdir($Directorio)) 
				{
					if($ArchivoElim != '..' && $ArchivoElim !='.' && $ArchivoElim !='')
					{ 		
						if (file_exists($Dir."/".$ArchivoElim))
							unlink($Dir."/".$ArchivoElim);
					}
					$i++;
				}
				closedir($Directorio);
			}			
		}	
	}
function PesoHistorico($TipoProceso,$Patente,$TxtPesoHistorico,$TxtPorcRango,$Proc,$Prod,$SubProd,$link)
{
	$TxtPorcRango=0;
	$Consulta="SELECT * from proyecto_modernizacion.clase where cod_clase='24002'";
	$RespPorc=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($RespPorc))
		$TxtPorcRango=$Fila["valor1"];
	$TxtPesoHistorico=0;	
	switch($TipoProceso)
	{
		case "R":
			$Consulta="SELECT max(correlativo) as corr from sipa_web.recepciones where patente='".$Patente."' and peso_tara <> 0 ";
			$Consulta.="and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Resp));
			{
				$Consulta="SELECT peso_tara from sipa_web.recepciones where correlativo='".$Fila["corr"]."' ";
				$RespPeso=mysqli_query($link, $Consulta);
				$FilaPeso=mysqli_fetch_array($RespPeso);
				$TxtPesoHistorico= isset($FilaPeso["peso_tara"])?$FilaPeso["peso_tara"]:"";
			}
			break;
		case "D":
			$Consulta="SELECT max(correlativo) as corr from sipa_web.despachos where patente='".$Patente."' and peso_tara <> 0 ";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Resp));
			{
				$Consulta="SELECT peso_tara from sipa_web.despachos where correlativo='".$Fila["corr"]."' ";
				$RespPeso=mysqli_query($link, $Consulta);
				$FilaPeso=mysqli_fetch_array($RespPeso);
				$TxtPesoHistorico=isset($FilaPeso["peso_tara"])?$FilaPeso["peso_tara"]:"";
			}
			break;	
	}
}
function PesoHistorico2($TipoProceso,$Patente,$TxtPesoHistorico,$TxtPorcRango,$Proc,$Prod,$SubProd,$link)
{
	$TxtPorcRango=0;
	$Consulta="SELECT * from proyecto_modernizacion.clase where cod_clase='24002'";
	$RespPorc=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($RespPorc))
		$TxtPorcRango=$Fila["valor1"];
	$TxtPesoHistorico=0;	
	switch($TipoProceso)
	{
		case "R":
			$PesoBrutoAcum=0;$ContPesos=0;
			$Consulta="SELECT peso_bruto from sipa_web.recepciones where patente='".$Patente."' and peso_bruto <> 0 ";
			$Consulta.="and cod_producto='$Prod' and cod_subproducto='".$SubProd."' order by correlativo desc LIMIT 5";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Resp))
			{
				//$PesoBrutoAcum = $PesoBrutoAcum + $FilaPeso["peso_bruto"];
				$PesoBrutoAcum = $PesoBrutoAcum + $Fila["peso_bruto"];
				$ContPesos++;
				/*$Consulta="SELECT peso_bruto from sipa_web.recepciones where correlativo='".$Fila["corr"]."' ";
				$RespPeso=mysqli_query($link, $Consulta);
				$FilaPeso=mysqli_fetch_array($RespPeso);
				$TxtPesoHistorico=$FilaPeso["peso_bruto"];*/
			}
			if($PesoBrutoAcum!=0)
				$TxtPesoHistorico=round($PesoBrutoAcum/$ContPesos);
			break;
		case "D":
			$Consulta="SELECT max(correlativo) as corr from sipa_web.despachos where patente='".$Patente."' and peso_bruto <> 0 ";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Resp))
			{
				$Consulta="SELECT peso_bruto from sipa_web.despachos where correlativo='".$Fila["corr"]."' ";
				$RespPeso=mysqli_query($link, $Consulta);
				$FilaPeso=mysqli_fetch_array($RespPeso);
				$TxtPesoHistorico=$FilaPeso["peso_bruto"];
			}
			break;	
	}
}
function RespConsDespSal($Corr,$str)
{
	$NomArchivo = "sipaweb/salida/".$Corr.".txt";
	$Archivo = fopen($NomArchivo,"w+");
	fwrite($Archivo,$str."\r\n");
	fclose($Archivo);	
}
				
function EnviaCorreo($Patente,$Dif,$Guia,$PesoBruto,$PesoNetoSec,$SubProd,$NumRomana,$RutOpera,$link)
{
//session_start();
//include("lib.inc.php");
//Conexion();
//RestringePagina($_SESSION["MR_Sesion_Usuario"] , $_SESSION["MR_Sesion_Privilegio"], 9);

//$NombArch = $FechaP." ".$TurnoP;

//$Fecha = getdate();
//$Fecha = $Fecha[mday]."-".$Fecha[mon]."-".$Fecha[year];

//echo $Patente. "<br>";

//echo "ANTES ***************: " . $Patente;

//echo '<script language="javascript">alert("VAAAA"); 					
				
// Obtenemos datos de Tabla Parametros de Correo
$Consulta = "SELECT * FROM sipa_web.PARAM_CORREO where tipo_usu='de'";
$Resultado = mysqli_query($link, $Consulta);
//if (!$Resultado) {
//    die('Consulta no válida: ' . mysql_error());
//}
$Resultado = mysqli_fetch_array($Resultado);	
$DE = $Resultado[0];
//echo "DEEEEEE: " . $DE;
$DirCorreos ="";

// Obtenemos datos de Tabla Correo de Usuarios a Enviar Correo
$Consulta = "SELECT tcorreo FROM sipa_web.PARAM_CORREO where tipo_usu='pa'";

// Sacamos los datos que deseamos mostrar de los Usuarios
$Resultado = mysqli_query($link, $Consulta);
// Ahora mostramos el resultado en una tabla en HTML pero solo dentro de objetos <tr>
while ($DatosUsuarios = mysqli_fetch_array($Resultado))
{
  	
	if ($DirCorreos == "" )
	   {
       $DirCorreos = $DatosUsuarios[0];
	   // $DirCorreos = "mfuentes@contratistas.codelco.cl";
	   }
	else
	   {
		   $DirCorreos .= ";".$DatosUsuarios[0];
	   }
	
}

//echo "usuario a enviar = " .$DirCorreos;

// Obtenemos datos de Tabla Mensaje id = 1 Primera Parte del mensaje 
$Consulta = "SELECT cmens_asunto, cmens_mensaje from sipa_web.mensaje where cmens_id =1";
$Resultado = mysqli_query($link, $Consulta);
$Resultado = mysqli_fetch_row($Resultado);
			
$ASUNTO = $Resultado[0];

$MENSAJE = $Resultado[1] . "<BR>" . "<BR>" .
" Patente        : " .$Patente . "<BR>" .
" Guia           : " .$Guia . "<BR>" .
" Peso Bruto     : " .$PesoBruto . "<BR>" .
" Peso Bruto Sec : " .$PesoNetoSec . "<BR>" ;

$DiferenciaReal  = $Dif ;
$DifRea = explode("~", $DiferenciaReal);

$MENSAJE = $MENSAJE . 
" Diferencia     : " .$DifRea[1] . "<BR>" ;

$prosub  = $SubProd ;
$ps = explode("~", $prosub);
$prod =  $ps[0]; // producto
$subprodu = $ps[1]; // subproducto

// Obtenemos datos de Tabla Productos 
$Consulta = "SELECT descripcion from proyecto_modernizacion.subproducto where cod_producto=".$prod." and cod_subproducto=" . $subprodu;
$Resultado = mysqli_query($link, $Consulta);
$Resultado = mysqli_fetch_row($Resultado);

$MENSAJE = $MENSAJE . 
" Producto       : " .$Resultado[0]  . "<BR>" .        	
" Romana         : " .$NumRomana  . "<BR>" ;

$RutOper  = $RutOpera ;
$Rutsndv = explode("-", $RutOper);

// Obtenemos datos Operador 
$Consulta = "SELECT apellido_paterno, apellido_materno, nombres FROM proyecto_modernizacion.funcionarios where rut =".$Rutsndv[0];
$Resultado = mysqli_query($link, $Consulta);
$Resultado = mysqli_fetch_row($Resultado);

$MENSAJE = $MENSAJE . 
" Operador       : " .$RutOpera.' '.strtoupper($Resultado[0]).' '.strtoupper($Resultado[1]).' '.strtoupper($Resultado[2])."<BR>" ;

// Obtenemos datos de Tabla Mensaje id =2 SegundaParte del mensaje 
$Consulta = "SELECT cmens_asunto, cmens_mensaje from sipa_web.mensaje where cmens_id =2";
$Resultado = mysqli_query($link, $Consulta);
$Resultado = mysqli_fetch_row($Resultado);

$MENSAJE = $MENSAJE . "<BR>" . $Resultado[1];

//Incluimos la clase de PHPMailer
require_once('phpmailer/class.phpmailer.php');
 
$correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()
 
//Usamos el SetFrom para decirle al script quien envia el correo
//$correo->SetFrom("mfuentes@codelco.cl", "Persona");
$correo->SetFrom($DE, "");
 
//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
$correo->AddReplyTo($DE,"");
 
//Usamos el AddAddress para agregar un destinatario
//$correo->AddAddress("mfuentes@codelco.cl", "");

$EnvCorreos = explode( ";", $DirCorreos );
foreach( $EnvCorreos as $destino ) {
	  //echo " correoss = " . $destino;
      $correo->AddAddress($destino,"" );
}  

//$correo->AddCC("mfuentes@codelco.cl");
//$correo->AddCC($DirCorreos);
 
//Ponemos el asunto del mensaje
$correo->Subject = $ASUNTO; //." ".$NombArch;
 
/*
 * Si deseamos enviar un correo con formato HTML utilizaremos MsgHTML:
 * $correo->MsgHTML("<strong>Mi Mensaje en HTML</strong>");
 * Si deseamos enviarlo en texto plano, haremos lo siguiente:
 * $correo->IsHTML(false);
 * $correo->Body = "Mi mensaje en Texto Plano";
 */
//$correo->MsgHTML("Mensaje en <strong>HTML</strong>");
$correo->MsgHTML($MENSAJE);
 
//Si deseamos agregar un archivo adjunto utilizamos AddAttachment
// ----- $correo->AddAttachment("GenSalida/DetSIMM-".$NombArch.".xls");
 
//Enviamos el correo
if(!$correo->Send()) {
  echo "Hubo un error: " . $correo->ErrorInfo;
} 

//else {
//  echo "Mensaje enviado con exito.";
//}
             
}

/***************Lee archivos TXT********************** */
function LeerArchivo($ruta,$archivo)
{
	//$nombre="archivo.txt";//$archivo;
	$nombre=$archivo;
	if($ruta!=""){
		$ubicacion = 'D:/'.$ruta.'/'.$nombre;
	}else{
		$ubicacion = 'D:/'.$nombre;
	}	
	if(file_exists($ubicacion)){
		$arc = fopen($ubicacion,"r");
		while(! feof($arc))  {
			$valor = fgets($arc);
		}
		fclose($arc);
	}else{
		$valor="";
	}
	return($valor); 
}
/*
function LeerArchivo($ruta, $archivo)
{
	$nombre=$archivo;
	if($ruta!=""){
		//$ubicacion = $ruta."\\".$nombre;
		$ubicacion = "xampp\\htdocs\\proyecto\\".$ruta."\\".$nombre;
	}else{
		$ubicacion = $nombre;
	}
	//$arc = fopen('C:/PesaMatic/'.$nombre,"r");
	$arc = fopen("D:\\".$ubicacion,"r");
	//$arc = fopen($ubicacion,"r");
	while(! feof($arc))  {
		$linea = fgets($arc);
	}
	fclose($arc);

	return($linea); 
}*/

/******* Consulta el numero de ROMANA *******/
function LeerRomana($REMOTE_ADDR,$link)
{
	$Consulta = " SELECT * FROM proyecto_modernizacion.sub_clase 
				  WHERE cod_clase= 24011 AND valor_subclase1 = '".$REMOTE_ADDR."' ";
	$Resp=mysqli_query($link, $Consulta);
	$Romana="";
	if($Fila=mysqli_fetch_array($Resp))
	{
		$Romana=$Fila["valor_subclase2"];
	} 
	return ($Romana);
}

	// Function to get the user IP address
	function getUserIP(){
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	function getRealIP(){

        if (isset($_SERVER["HTTP_CLIENT_IP"])){

            return $_SERVER["HTTP_CLIENT_IP"];

        }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){

            return $_SERVER["HTTP_X_FORWARDED_FOR"];

        }elseif (isset($_SERVER["HTTP_X_FORWARDED"])){

            return $_SERVER["HTTP_X_FORWARDED"];

        }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){

            return $_SERVER["HTTP_FORWARDED_FOR"];

        }elseif (isset($_SERVER["HTTP_FORWARDED"])){

            return $_SERVER["HTTP_FORWARDED"];

        }else{
            return $_SERVER["REMOTE_ADDR"];
        }
    }  
	
?>
