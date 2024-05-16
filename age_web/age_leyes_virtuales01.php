<?php
	include("../principal/conectar_principal.php");

	$CookieRut   = $_COOKIE["CookieRut"];
	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$ValoresIng  = isset($_REQUEST["ValoresIng"])?$_REQUEST["ValoresIng"]:"";

	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor   = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";

	switch ($Proceso)
	{	
		case "G":
			//$Datos=$LotesOcultos;
			$Datos=explode("//",$ValoresIng);
			foreach($Datos as $k=>$v)
			{
				$Datos2=explode("~|",$v);//~| CARACTER QUE SEPARA LOS DATOS DE LA S.A. CON LAS LEYES
				$Datos3=explode("~~",$Datos2[0]);
				$Actualizar="UPDATE age_web.lotes set estado_lote='4' ";//4 CIERRE OPERACIONAL
				$Actualizar.="where lote='".$Datos3[0]."'";
				mysqli_query($link, $Actualizar);
				
				$SA= $Datos3[7];
				if (($Datos3[1]=="")||(is_null($Datos3[1])))
					$Recargo = "";						
				else
					$Recargo = $Datos3[1];
				$Datos4=explode("||",$Datos2[1]);//|| CARACTER QUE SEPARA CADA LEY 
				foreach($Datos4 as $k2=>$v2)
				{
					$Datos5=explode("~~",$v2);
					$Valor=$Datos5[0];
					$Virtual=$Datos5[1];
					$CodLey=$Datos5[2];
					if($Virtual=='S')
					{	
						$Consulta = "select * from cal_web.leyes_por_solicitud";
						$Consulta.= " where nro_solicitud = '".$SA."' ";
						$Consulta.= " and recargo = '".$Recargo."' ";
						$Consulta.= " and cod_leyes='$CodLey'";
						$Resp = mysqli_query($link, $Consulta);
						while($Fila = mysqli_fetch_array($Resp))
						{	
							$CodLey=$Fila["cod_leyes"];
							$FechaHora = date("Y-m-d H:i:s");
							//PREGUNTA ESTADO ACTUAL
							$Consulta = "select * from cal_web.solicitud_analisis ";
							$Consulta.= " where nro_solicitud = '".$SA."' ";
							$Consulta.= " and recargo = '".$Recargo."' ";					
							$Resp2 = mysqli_query($link, $Consulta);
							if ($Fila2 = mysqli_fetch_array($Resp2))
							{
								if ($Fila2["estado_actual"] == "6")
									$CambiaEstado = false;
								else
									$CambiaEstado = true;
							}
							//ACTUALIZA CON LEY VIRTUAL
							$Actualizar = "UPDATE cal_web.leyes_por_solicitud set ";
							$Actualizar.= " valor2=valor ";
							$Actualizar.= " where nro_solicitud='".$SA."' ";
							$Actualizar.= " and recargo = '".$Recargo."' ";
							$Actualizar.= " and cod_leyes = '".$CodLey."'";
							mysqli_query($link, $Actualizar);
							//ACTUALIZA CON LEY VIRTUAL
							$Actualizar = "UPDATE cal_web.leyes_por_solicitud set ";
							$Actualizar.= " virtual='S', ";
							$Actualizar.= " valor='".str_replace(",",".",$Valor)."', ";
							$Actualizar.= " candado='1', ";
							$Actualizar.= " proceso='99', ";
							$Actualizar.= " rut_quimico='".$CookieRut."' ";
							$Actualizar.= " where nro_solicitud='".$SA."' ";
							$Actualizar.= " and recargo = '".$Recargo."' ";
							$Actualizar.= " and cod_leyes = '".$CodLey."'";
							mysqli_query($link, $Actualizar);
							//INSERTA REGISTRO DE LEYES
							$Insertar = "INSERT INTO cal_web.`registro_leyes` (`rut_funcionario`, `fecha_hora`, `nro_solicitud`, `recargo`, ";
							$Insertar.= "`cod_leyes`, `valor`, `peso_humedo`, `peso_seco`, `cod_unidad`, `candado`, `signo`, `rut_proceso`) ";
							$Insertar.= " VALUES ('".$CookieRut."', '".$FechaHora."', '".$Fila["nro_solicitud"]."', ";
							$Insertar.= " '".$Fila["recargo"]."', '".$CodLey."', '".$Valor."', '".$Fila["peso_humedo"]."', '".$Fila["peso_seco"]."', ";
							$Insertar.= " '".$Fila["cod_unidad"]."', '1', '".$Fila["signo"]."', '".$CookieRut."')";
							mysqli_query($link, $Insertar);		
							if ($CambiaEstado==true)
							{
								$Consulta = "select t1.nro_solicitud, t1.recargo, t1.estado_actual, t1.id_muestra, t1.fecha_hora, t1.rut_funcionario ";
								$Consulta.= " ,count(t2.candado) as total_leyes,";
								$Consulta.= " sum(t2.candado) as cerrados,";
								$Consulta.= " case when count(t2.candado) = sum(t2.candado) then 'S' else 'N' end as finalizar ";
								$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2";
								$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo";
								$Consulta.= " where t1.nro_solicitud = '".$SA."' ";
								$Consulta.= " and t1.recargo = '".$Recargo."' ";	
								$Consulta.= " group by t1.nro_solicitud, t1.recargo";
								$Resp2 = mysqli_query($link, $Consulta);
								if ($Fila2 = mysqli_fetch_array($Resp2))
								{
									if ($Fila2["estado_actual"]!="6" && $Fila2["finalizar"]=="S")
									{
										//ESTADOS POR SOLICITUD
										$Insertar = "INSERT INTO cal_web.`estados_por_solicitud` (`rut_funcionario`, `nro_solicitud`, `recargo`, `cod_estado`, ";
										$Insertar.= "`fecha_hora`, `rut_proceso`) VALUES ";
										$Insertar.= "('".$Fila["rut_funcionario"]."', '".$Fila["nro_solicitud"]."', '".$Fila["recargo"]."', '6', '".$FechaHora."', '".$CookieRut."')";
										mysqli_query($link, $Insertar);	
										//ACTUALIZA ESTADO ACTUAL DE LA SOLICITUD A FINALIZADA
										$Actualizar = "UPDATE cal_web.solicitud_analisis set ";
										$Actualizar.= " estado_actual = '6' ";
										$Actualizar.= " where nro_solicitud = '".$SA."' ";
										$Actualizar.= " and recargo = '".$Recargo."' ";
										mysqli_query($link, $Actualizar);
									}
								}														
							}
						}
					}
				}				
			}
			//header("location:age_leyes_virtuales.php?Mostrar=S&Producto=".$Producto."&SubProducto=".$SubProducto."&Mes=".$Mes."&Ano=".$Ano);
			header("location:age_leyes_virtuales.php?Mostrar=S&Proveedor=".$Proveedor."&SubProducto=".$SubProducto."&Mes=".$Mes."&Ano=".$Ano);
			break;
	}
?>