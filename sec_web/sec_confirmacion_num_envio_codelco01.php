<?php

	include("../principal/conectar_sec_web.php");
	$FechaEnvio = date("Y-m-d");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Tipo    = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
	$Envio         = isset($_REQUEST["Envio"])?$_REQUEST["Envio"]:"";
	$TipoEmbarque  = isset($_REQUEST["TipoEmbarque"])?$_REQUEST["TipoEmbarque"]:"";
	$ValoresAux    = isset($_REQUEST["ValoresAux"])?$_REQUEST["ValoresAux"]:"";
	$CodNave       = isset($_REQUEST["CodNave"])?$_REQUEST["CodNave"]:"";
	$CodPuerto     = isset($_REQUEST["CodPuerto"])?$_REQUEST["CodPuerto"]:"";
	$NumOrden      = isset($_REQUEST["NumOrden"])?$_REQUEST["NumOrden"]:"";
	$NumPaqueteI01 = isset($_REQUEST["NumPaqueteI01"])?$_REQUEST["NumPaqueteI01"]:"";
	$NumPaqueteF01 = isset($_REQUEST["NumPaqueteF01"])?$_REQUEST["NumPaqueteF01"]:"";
	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";
	$cod_cliente = isset($_REQUEST["cod_cliente"])?$_REQUEST["cod_cliente"]:"";
	$Var1=0;
	switch ($Proceso)
	{
		case "G":
			$Datos=explode('//',$ValoresAux);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$corr_enm=$Datos2[0];
				$cod_bulto=$Datos2[1];				
				$num_bulto=$Datos2[2];
				$fecha_embarque=$Datos2[3];
				$fecha_programacion=$Datos2[4];
				$bulto_peso=$Datos2[5];
				$bulto_paquetes=$Datos2[6];
				$cod_marca=$Datos2[7];
				$cod_producto=$Datos2[8];
				$cod_subproducto=$Datos2[9];
				$cod_cliente=$Datos2[10];
				$Var1 = 0;
				$largo_nv = strlen($cod_cliente);
				switch ($largo_nv)
				{
					case 1: $cod_cliente="000$cod_cliente";
					break;
					case 2: $cod_cliente="00$cod_cliente";
					break;
					case 3: $cod_cliente="0$cod_cliente";
					break;
				}
				$Consulta="SELECT * from sec_web.programa_codelco where corr_codelco='".$corr_enm."'";
				$Respuesta1=mysqli_query($link, $Consulta);
				$Fila1=mysqli_fetch_array($Respuesta1);
				if ($Fila1["cod_contrato_maquila"] == 'MAQ ENM')
				{
					$enami_codelco = 'E';
				}
				else
				{
					$enami_codelco = 'C';
				} 
				$insertar="insert into sec_web.embarque_ventana ";
				$insertar.=" (num_envio,corr_enm,cod_bulto,num_bulto,fecha_embarque,fecha_programacion, ";
				$insertar.=" bulto_paquetes,bulto_peso,cod_marca,cod_producto,cod_subproducto,cod_cliente ";
				$insertar.=" ,tipo_enm_code,cod_puerto,cod_nave,tipo_embarque,fecha_envio,cod_confirmado,orden_compra) values ";
				$insertar.="('".$Envio."','".$corr_enm."','".$cod_bulto."','".$num_bulto."','".$fecha_embarque."', ";
				$insertar.=" '".$fecha_programacion."','".$bulto_paquetes."','".$bulto_peso."','".$cod_marca."','".$cod_producto."', ";
				$insertar.=" '".$cod_subproducto."','".$cod_cliente."','".$enami_codelco."','".$CodPuerto."','".$CodNave."','".$TipoEmbarque."','".$FechaEnvio."','C'";
				if ($cod_cliente == '45')
					$insertar.=" ,'".$NumOrden."') ";
				else
					$insertar.=" ,'".$Var1."')";
				//echo "EE".$insertar;
				mysqli_query($link, $insertar);
				$Actualizar="UPDATE sec_web.programa_codelco set estado2='C' where  ";
				$Actualizar.=" corr_codelco='".$Datos2[0]."'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmConfirmacion.action='sec_confirmacion_num_envio_codelco.php?NumPaqueteI01=".$NumPaqueteI01."&NumPaqueteF01=".$NumPaqueteF01."&Tipo=".$Tipo."&Ver=N';";
			echo "window.opener.document.FrmConfirmacion.submit();";
			echo "window.close();";
			echo "</script>";
			break;
			case "E":
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~',$Valor);
				$Consulta="SELECT * from sec_web.embarque_ventana where ";
				$Consulta.=" num_envio='".$Datos2[0]."' and corr_enm='".$Datos2[1]."' and cod_confirmado='C'";
				$Respuesta1=mysqli_query($link, $Consulta);
				if($Fila1=mysqli_fetch_array($Respuesta1))
				{
					$Envios=$Envios.$Datos2[1].",";
					$Mensaje="La Inst.Embarque ".$Envios." No se Elimino por que ha sido confirmada ";
				}
				else
				{
					$Eliminar="DELETE FROM sec_web.embarque_ventana where ";
					$Eliminar.=" num_envio='".$Datos2[0]."' and corr_enm='".$Datos2[1]."'";
					mysqli_query($link, $Eliminar);
					$Consulta="SELECT * from sec_web.relacion_transporte_inst_embarque ";
					$Consulta.=" where corr_enm='".$Datos[1]."'";
					$Respuesta=mysqli_query($link, $Consulta);
					if($Fila=mysqli_fetch_array($Respuesta));
					{
						$Eliminar="DELETE FROM sec_web.relacion_transporte_inst_embarque ";
						$Eliminar.=" where corr_enm='".$Datos2[1]."' 			";
						mysqli_query($link, $Eliminar);
					}
					$Actualizar="UPDATE sec_web.programa_codelco set estado2='T' where  ";
					$Actualizar.="  corr_codelco='".$Datos2[1]."'";
					mysqli_query($link, $Actualizar);
				}
			}
			header("location:sec_confirmacion_num_envio_codelco.php?Tipo=".$Tipo."&Mensaje=".$Mensaje."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno);	
			break;
			case"Asignar":
				
				$peso1 = 0;
				$peso2 = 0;
				$Fecha1 = date("Y-m-d");	
				$Fecha2 = date("Y-m-d", mktime(1,0,0,intval(substr($Fecha1, 5, 2)) ,intval(substr($Fecha1, 8, 2)) - 10,intval(substr($Fecha1, 0, 4))));
				$Existe = 0;
				$proceso="SELECT * from sec_web.embarque_ventana  where num_envio='".$Envio."'and fecha_envio >= '".$Fecha2."'";
			//	echo "EE ".$proceso;
				$proceso1=mysqli_query($link, $proceso);
				while ($linea=mysqli_fetch_array($proceso1))
				{
					$Existe = $Existe + 1;
									
				}
				if ($Existe == 0)  
				{
					$Mensaje="No se puede asignar Instrucción Embarque, Envio no Existe,Revise..... ";
				}
				else
				{	
					$Consulta="SELECT * from sec_web.embarque_ventana where num_envio='".$Envio."'and fecha_envio >= '".$Fecha2."'";
					//echo "Dos ".$Consulta;
					$Respuesta=mysqli_query($link, $Consulta);					
					if($Fila=mysqli_fetch_array($Respuesta))
					{
						$Consulta="SELECT t1.cod_bulto,t1.num_bulto,t1.cod_marca, ";
						$Consulta.=" sum(t2.peso_paquetes) as peso_preparado,count(t1.num_paquete) as unidades from sec_web.lote_catodo   ";
						$Consulta.=" t1 inner join sec_web.paquete_catodo t2 on ";
						$Consulta.=" t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
						$Consulta.=" where corr_enm='".$Valores."' and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_estado = 'a' and t2.cod_estado = 'a' ";
						$Consulta.=" and year(t1.fecha_creacion_lote) >=  year('".$Fecha2."') group by corr_enm	";
						
						$Respuesta0=mysqli_query($link, $Consulta);
						
						$Fila0=mysqli_fetch_array($Respuesta0);
						$Consulta="SELECT * from sec_web.programa_codelco where corr_codelco='".$Valores."'";
						//echo $Consulta."<br><br>";
                        $Respuesta1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Respuesta1);
						 if ($Fila1["cod_contrato_maquila"] =='MAQ ENM')
						 {
						 	$enami_codelco = 'E';
						 }
						 else
						 {
						 	$enami_codelco = 'C';
						 } 
						$Consulta="SELECT * from sec_web.nave where cod_nave='".$Fila1["cod_cliente"]."' ";
						$Respuesta2=mysqli_query($link, $Consulta);
					//	echo $Consulta."<br><br>";
						if($Fila2=mysqli_fetch_array($Respuesta2))
						{
							$largo_nave = strlen($Fila1["cod_cliente"]);
							
							switch ($largo_nave)
							{
								case 1: $Fila1["cod_cliente"]="000'".$Fila1["cod_cliente"]."'";
									break;
								case 2: $Fila1["cod_cliente"]="00'".$Fila1["cod_cliente"]."'";
									break;
								case 3: $Fila1["cod_cliente"]="0'".$Fila1["cod_cliente"]."'";
									break;
							}
					//	echo "fila2: ".$Fila2["cod_via_transporte"]."<br><br>";
									
							switch ($Fila2["cod_via_transporte"])
							{
							
							
								case "01"://Naves
									
									//if($Fila["fecha_programacion"]==$Fila1["fecha_disponible"])
									//{
										$consulta= "SELECT * FROM sec_web.embarque_ventana WHERE num_envio='$Envio' and corr_enm='$Valores' and cod_bulto='".$Fila0["cod_bulto"]."' and num_bulto='".$Fila0["num_bulto"]."' ";
										$resp= mysqli_query($link, $consulta);
										$cont = mysqli_num_rows($resp);
										//echo "Cont:".$cont;
										if($cont==0){
											$insertar="INSERT INTO sec_web.embarque_ventana ";
											$insertar.=" (num_envio,corr_enm,cod_bulto,num_bulto,fecha_embarque,fecha_programacion, ";
											$insertar.=" bulto_paquetes,bulto_peso,cod_marca,cod_producto,cod_subproducto,cod_cliente ";
											$insertar.=" ,tipo_enm_code,cod_puerto,cod_nave,tipo_embarque,fecha_envio,cod_confirmado,rut_cliente,cod_sub_cliente,orden_compra) values ";
											$insertar.="('".$Envio."','".$Valores."','".$Fila0["cod_bulto"]."','".$Fila0["num_bulto"]."', ";
											$insertar.=" '".$Fila1["fecha_disponible"]."','".$Fila1["fecha_programacion"]."','".$Fila0["unidades"]."' ";
											$insertar.=" ,'".$Fila0["peso_preparado"]."','".$Fila0["cod_marca"]."','".$Fila1["cod_producto"]."', ";
											$insertar.="'".$Fila1["cod_subproducto"]."','".$Fila1["cod_cliente"]."','".$enami_codelco."','".$Fila["cod_puerto"]."','".$Fila["cod_nave"]."',";
											$insertar.="'".$Fila["tipo_embarque"]."','".$Fila["fecha_envio"]."','C','".$Fila["rut_cliente"]."','".$Fila["cod_sub_cliente"]."' ";
											if ($cod_cliente == '45')
												$insertar.=" ,'".$NumOrden."') ";
											else
												$insertar.=" ,'".$Var1."')";
											
											mysqli_query($link, $insertar);
										}
										//	echo "II".$insertar."<br>";
									//}
									//else
									/*{
										$fe1=$fila["fecha_programacion"];
										$fe2=$fila1["fecha_disponible"];
										$Mensaje="Aviso..envio N. ".$Envio.", tiene I.E. con  fecha programacion diferentes ";
									}*/
								break;
									
								case "07"://Terrestre
									if($Fila["cod_cliente"]==$Fila1["cod_cliente"])
									{
										$insertar="insert into sec_web.embarque_ventana ";
										$insertar.=" (num_envio,corr_enm,cod_bulto,num_bulto,fecha_embarque,fecha_programacion, ";
										$insertar.=" bulto_paquetes,bulto_peso,cod_marca,cod_producto,cod_subproducto,cod_cliente ";
										$insertar.=" ,tipo_enm_code,cod_puerto,cod_nave,tipo_embarque,fecha_envio,cod_confirmado,rut_cliente,cod_sub_cliente,orden_compra) values ";
										$insertar.="('".$Envio."','".$Valores."','".$Fila0["cod_bulto"]."','".$Fila0["num_bulto"]."', ";
										$insertar.=" '".$Fila1["fecha_disponible"]."','".$Fila1["fecha_programacion"]."','".$Fila0["unidades"]."' ";
										$insertar.=" ,'".$Fila0["peso_preparado"]."','".$Fila0["cod_marca"]."','".$Fila1["cod_producto"]."', ";
										$insertar.="'".$Fila1["cod_subproducto"]."','".$Fila1["cod_cliente"]."','".$enami_codelco."','".$Fila["cod_puerto"]."','".$Fila["cod_nave"]."',";
										$insertar.="'".$Fila["tipo_embarque"]."','".$Fila["fecha_envio"]."','C','".$Fila["rut_cliente"]."','".$Fila["cod_sub_cliente"]."' ";
										if ($cod_cliente == '45')
											$insertar.=" ,'".$NumOrden."') ";
										else
											$insertar.=" ,'".$Var1."')";
										mysqli_query($link, $insertar);
										//	echo "ttt".$insertar."<br>";
									} 
									else
									{
										$Mensaje="No se puede asignar el envio ".$Envio." ,por tener cliente diferentes,revise ";
									}
								break;
							}					
						}
						else
						{
							if($Fila["cod_cliente"]==$Fila1["cod_cliente"])
							{
								$insertar="insert into sec_web.embarque_ventana ";
								$insertar.=" (num_envio,corr_enm,cod_bulto,num_bulto,fecha_embarque,fecha_programacion, ";
								$insertar.=" bulto_paquetes,bulto_peso,cod_marca,cod_producto,cod_subproducto,cod_cliente ";
								$insertar.=" ,tipo_enm_code,cod_puerto,cod_nave,tipo_embarque,fecha_envio,cod_confirmado,rut_cliente,cod_sub_cliente,orden_compra) values ";
								$insertar.="('".$Envio."','".$Valores."','".$Fila0["cod_bulto"]."','".$Fila0["num_bulto"]."', ";
								$insertar.=" '".$Fila1["fecha_disponible"]."','".$Fila1["fecha_programacion"]."','".$Fila0["unidades"]."' ";
								$insertar.=" ,'".$Fila0["peso_preparado"]."','".$Fila0["cod_marca"]."','".$Fila1["cod_producto"]."', ";
								$insertar.="'".$Fila1["cod_subproducto"]."','".$Fila1["cod_cliente"]."','".$enami_codelco."','".$Fila["cod_puerto"]."','".$Fila["cod_nave"]."',";
								$insertar.="'".$Fila["tipo_embarque"]."','".$Fila["fecha_envio"]."','C','".$Fila["rut_cliente"]."','".$Fila["cod_sub_cliente"]."' ";
								if ($cod_cliente == '45')
									$insertar.=" ,'".$NumOrden."') ";
								else
									$insertar.=" ,'".$Var1."')";
							//		echo "II2".$insertar;
								mysqli_query($link, $insertar);
							} 
							else
							{
								$Mensaje="No se puede asignar el envio ".$Envio." ,por tener clientes diferentes ";
							}
						}
					}
				}			
		echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmConfirmacion.action='sec_confirmacion_num_envio_codelco.php?Mensaje=".$Mensaje."&Tipo=".$Tipo."&Ver=N';";
				echo "window.opener.document.FrmConfirmacion.submit();";
				echo "window.close();";
				echo "</script>";
			break;
	}
?>
