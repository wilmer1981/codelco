<?php 	
	include("../principal/conectar_sec_web.php");
	$FechaEnvio=date('Y-m-d');

	$Proceso = $_REQUEST["Proceso"];
	$Valores = $_REQUEST["Valores"];
		
	switch ($Proceso)
	{
		
		case "G":
			$Datos=explode('//',$Valores);
			
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2		=explode('~~',$Valor);
				$corr_enm	=$Datos2[0];
				$cod_bulto	=$Datos2[1];				
				$num_bulto	=$Datos2[2];
				$fecha_embarque	   =$Datos2[3];
				$fecha_programacion=$Datos2[4];
				$bulto_peso    =$Datos2[5];
				$bulto_paquetes=$Datos2[6];
				$cod_marca=$Datos2[7];
				$cod_producto=$Datos2[8];
				$cod_subproducto=$Datos2[9];
				$cod_cliente=$Datos2[10];
				$cod_puerto=$Datos2[11];
				$cod_agente=$Datos2[12];
				$cod_estiba=$Datos2[13];
				$cod_acopio=$Datos2[14];
				$cod_nave=$Datos2[15];
				$num_viaje=$Datos2[16];
				$Insertar="insert into sec_web.embarque_ventana (num_envio,corr_enm,cod_bulto,num_bulto, ";
				$Insertar.=" fecha_embarque,fecha_programacion,bulto_paquetes,bulto_peso,cod_marca,cod_producto";
				$Insertar.=",cod_subproducto,cod_cliente,cod_puerto,cod_agente,cod_estiba,cod_acopio,cod_confirmado,";
				$Insertar.=" tipo_embarque,tipo_enm_code,cod_nave,num_viaje,fecha_envio) values(";
				$Insertar.="'".$TxtNumEnvio."','".$corr_enm."','".$cod_bulto."','".$num_bulto."','".$fecha_embarque."','".$fecha_programacion."', ";
				$Insertar.=" '".$bulto_paquetes."','".$bulto_peso."','".$cod_marca."','".$cod_producto."','".$cod_subproducto."','".$cod_cliente."' ";
				$Insertar.=",'".$cod_puerto."','".$cod_agente."','".$cod_estiba."','".$cod_acopio."','C','".$CmbTipoEmb."','E','".$cod_nave."','".$num_viaje."','$FechaEnvio')";
				mysqli_query($link, $Insertar);
				$Actualizar="UPDATE sec_web.programa_enami set estado2='C' where corr_enm=".$corr_enm;
				mysqli_query($link, $Actualizar);
			}
			break;
		case "E"://ELIMINAR RELACION IE CON LOTE	
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2 = explode('~~',$Valor);
				$ie       = $Datos2[0];
				$CodBulto = $Datos2[1];				
				$NumBulto = $Datos2[2];
			}	
			$Consulta = "SELECT DISTINCT cod_paquete,num_paquete ";
			$Consulta.=" FROM sec_web.lote_catodo ";
			$Consulta.=" WHERE cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and corr_enm=".$ie;
			$Consulta.=" ORDER BY fecha_creacion_lote desc,cod_paquete,num_paquete ";
			$Respuesta = mysqli_query($link, $Consulta);
			$cont=1;
			$arreglo=array();
			$i=0;
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				$arreglo[$i]=	array($Fila["cod_paquete"],$Fila["num_paquete"]);
				$i++;
			}
			reset($arreglo);
			$sw=0;
			$vector=array();
			$a=0;
			$i=0;
			while ($i < count($arreglo))
			{
				if ($arreglo[$i][0]==$arreglo[$i+1][0])
				{
					if($arreglo[$i][1]==($arreglo[$i+1][1]-1))
					{
						if($sw==0)
						{
							$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
							$sw=1;
						}
						else
						{
							if ($arreglo[$i+1][1]!=($arreglo[$i+2][1]-1))
							{
								$vector[$a][1]=$arreglo[$i+1][0]."-".$arreglo[$i+1][1];//final
								$sw=0;
								$a++;
								$i++;
							}
						}
					}
					else
					{
						if ($sw==0)
						{	
							$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
							$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
							$a++;
						}
						else
						{
							$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
							$sw=0;
							$a++;
						}
					}
				}
				else
				{
					if ((count($arreglo)-$i)<=1)//fin del arreglo
					{
						if ($vector[$a][0]=="")
						{
							$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
						}
						$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
					}		
					else
					{
						if ($sw==1)
						{
							$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
							$a++;
							$sw=0;
						}
						else
						{
							$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
							$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
							$a++;
						}
					}
				}
				$i++;
			}		
			reset($vector);
			foreach($vector as $Clave => $Valor)
			{
				$Inicial=explode("-",$Valor[0]);
				$Final=explode("-",$Valor[1]);
				echo $Inicial[0]."-".$Inicial[1]."<br>";
				echo $Final[0]."-".$Final[1]."<br>";
				$AnoActual=date("Y");
				$Consulta="SELECT MAX(corr_virtual) as numero from sec_web.instruccion_virtual ";
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
				$arreglo=explode("~",$valor);
				$Consulta="SELECT t2.cod_producto,t2.cod_subproducto,sum(peso_paquetes) as suma_paquetes,t1.corr_enm,t1.cod_bulto,t1.num_bulto,t1.fecha_creacion_lote from sec_web.lote_catodo t1";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
				$Consulta.=" and t1.cod_estado=t2.cod_estado ";
				$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and corr_enm=".$ie;
				$Consulta.=" and t2.cod_paquete='".$Inicial[0]."' and t2.num_paquete between '".$Inicial[1]."'	and '".$Final[1]."'";
				$Consulta.=" group by t2.cod_producto,t2.cod_subproducto";
				$Respuesta1=mysqli_query($link, $Consulta);
				$Fila1=mysqli_fetch_array($Respuesta1);
				$Suma=($Fila1["suma_paquetes"]);
				$IE  =$Fila1["corr_enm"];
				$Consulta="SELECT * from sec_web.programa_enami where corr_enm='".$IE."'";
				$Respuesta2=mysqli_query($link, $Consulta);
				if($Fila2=mysqli_fetch_array($Respuesta2))
				{
					$Actualizar="UPDATE sec_web.programa_enami SET estado2='N',estado1='' WHERE corr_enm='".$IE." '";
					mysqli_query($link, $Actualizar);
					
				}
				$insertar="INSERT INTO sec_web.instruccion_virtual ";
				$insertar.="(corr_virtual,fecha_embarque,cod_producto,cod_subproducto,peso_programado,descripcion)  ";
				$insertar.= " values ('".$IEVirtual."','".$AnoActual."-12-31','".$Fila1["cod_producto"]."','".$Fila1["cod_subproducto"]."',";
				$insertar.=" '".$Suma."','ADM') ";
				mysqli_query($link, $insertar);
				$Actualizar="UPDATE sec_web.lote_catodo set corr_enm ='".$IEVirtual."',cod_bulto='".$Inicial[0]."',num_bulto='".$Inicial[1]."'  "; 
				$Actualizar.=" WHERE cod_bulto='".$Fila1["cod_bulto"]."' and num_bulto=".$Fila1["num_bulto"]."	";
				$Actualizar.=" AND fecha_creacion_lote='".$Fila1["fecha_creacion_lote"]."' and corr_enm='".$IE."'	";
				$Actualizar.=" AND cod_paquete='".$Inicial[0]."' AND num_paquete between '".$Inicial[1]."'	AND '".$Final[1]."'		";
				mysqli_query($link, $Actualizar);
			}			
			break;
		case "A":
			$Datos=explode('//',$Valores);
			
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
					
				$Consulta="SELECT corr_enm FROM sec_web.embarque_ventana WHERE ";
				$Consulta.=" num_envio='".$Datos2[0]."' and fecha_envio='".$Datos2[1]."' and sw<>'2'";
				$Respuesta=mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					$Consulta="SELECT corr_enm from sec_web.embarque_ventana where ";
					$Consulta.=" num_envio='".$Datos2[0]."' and fecha_envio='".$Datos2[1]."'";
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						$Eliminar="DELETE FROM sec_web.relacion_transporte_inst_embarque ";
						$Eliminar.=" WHERE corr_enm='".$Fila["corr_enm"]."'";
						mysqli_query($link, $Eliminar);
						$Actualizar="UPDATE sec_web.programa_enami set estado2='T' where  ";
						$Actualizar.="corr_enm='".$Fila["corr_enm"]."'";
						mysqli_query($link, $Actualizar);
					}
					$Eliminar="DELETE FROM sec_web.embarque_ventana WHERE ";
					$Eliminar.=" num_envio='".$Datos2[0]."' and fecha_envio='".$Datos2[1]."'					  ";
					mysqli_query($link, $Eliminar);
				}
				else
				{
					$Mensaje="Uno o mas Envios no fueron eliminados por tener paquetes despachados";
				}
			}
			break;
			case "Asignar":
				$Fecha_menor = date("Y-m-d", mktime(0,0,0,substr($FechaEnvio,5,2)-1,substr($FechaEnvio,8,2),substr($FechaEnvio,0,4)));
			
				$Consulta="SELECT * FROM sec_web.embarque_ventana WHERE num_envio='".$Envio."'and fecha_envio between '".$Fecha_menor."' and '".$FechaEnvio."'";
				echo $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				if($Fila=mysqli_fetch_array($Respuesta))  
				{
					$Consulta="SELECT corr_enm FROM sec_web.programa_enami WHERE corr_enm='".$Fila["corr_enm"]."' ";
					echo $Consulta."<br>";
					$Respuesta3=mysqli_query($link, $Consulta);
					if ($Fila3=mysqli_fetch_array($Respuesta3))
					{
						$Consulta="SELECT t1.cod_bulto,t1.num_bulto,t1.cod_marca, ";
						$Consulta.=" sum(t2.peso_paquetes) as peso_preparado,count(t1.num_paquete) as unidades from sec_web.lote_catodo   ";
						$Consulta.=" t1 inner join sec_web.paquete_catodo t2 on ";
						$Consulta.=" t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
						$Consulta.=" where corr_enm='".$Instruccion."' and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete group by corr_enm	";
						echo $Consulta."<br>";
						$Respuesta0=mysqli_query($link, $Consulta);
						$Fila0=mysqli_fetch_array($Respuesta0);
						$Consulta="SELECT * FROM sec_web.programa_enami WHERE corr_enm='".$Instruccion."'";
						echo $Consulta."<br>";
						$Respuesta1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Respuesta1);
						if ($Fila1["cod_v_transp"]=='1')//Naves
						{
								
								$insertar="INSERT INTO sec_web.embarque_ventana ";
								$insertar.=" (num_envio,corr_enm,cod_bulto,num_bulto,fecha_embarque,fecha_programacion, ";
								$insertar.=" bulto_paquetes,bulto_peso,cod_marca,cod_producto,cod_subproducto,cod_cliente ";
								$insertar.=" ,tipo_enm_code,cod_puerto,cod_nave,tipo_embarque,fecha_envio,cod_confirmado, ";
								$insertar.=" rut_cliente,cod_sub_cliente,cod_estado,cod_agente,cod_estiba,cod_acopio,num_viaje) values ";
								$insertar.="('".$Envio."','".$Instruccion."','".$Fila0["cod_bulto"]."','".$Fila0["num_bulto"]."', ";
								$insertar.=" '".$Fila1["fecha_disponible"]."','".$Fila1["eta_programada"]."','".$Fila0["unidades"]."', ";
								$insertar.=" '".$Fila0["peso_preparado"]."','".$Fila0["cod_marca"]."','".$Fila1["cod_producto"]."', ";
								$insertar.=" '".$Fila1["cod_subproducto"]."','".$Fila1["cod_cliente"]."','E','".$Fila1["cod_puerto"]."','".$Fila1["cod_nave"]."',";
								$insertar.=" '".$Fila["tipo_embarque"]."','".$Fila["fecha_envio"]."','C','".$Fila["rut_cliente"]."','".$Fila["cod_sub_cliente"]."', ";
								$insertar.=" '".$Fila["cod_estado"]."','".$Fila1["cod_prestador_servicio"]."','".$Fila1["cod_prestador_servicio2"]."', ";
								$insertar.=" '".$Fila1["cod_servicio"]."','".$Fila1["num_viaje"]."' ) ";
								echo $insertar."<br>";
								//mysqli_query($link, $insertar);
								$Actualizar="UPDATE sec_web.programa_enami SET estado2='C' WHERE corr_enm='".$Instruccion."' ";
								echo $Actualizar."<br>";
								//mysqli_query($link, $Actualizar);
							/*}
							else
							{
								$Mensaje2="No se puede asignar el envio ".$Envio." ,por tener fecha programacion diferentes ";
							}*/	
						}
						else//Terrestres
						{
							if($Fila["cod_cliente"]==$Fila1["cod_cliente"])
							{
								if (($Fila["cod_producto"]==$Fila1["cod_producto"])&&($Fila["cod_subproducto"]==$Fila1["cod_subproducto"]))
								{
									$insertar="INSERT INTO sec_web.embarque_ventana ";
									$insertar.=" (num_envio,corr_enm,cod_bulto,num_bulto,fecha_embarque,fecha_programacion, ";
									$insertar.=" bulto_paquetes,bulto_peso,cod_marca,cod_producto,cod_subproducto,cod_cliente ";
									$insertar.=" ,tipo_enm_code,cod_puerto,cod_nave,tipo_embarque,fecha_envio,cod_confirmado, ";
									$insertar.=" rut_cliente,cod_sub_cliente,cod_estado,cod_agente,cod_estiba,cod_acopio,num_viaje) values ";
									$insertar.="('".$Envio."','".$Instruccion."','".$Fila0["cod_bulto"]."','".$Fila0["num_bulto"]."', ";
									$insertar.=" '".$Fila1["fecha_disponible"]."','".$Fila1["eta_programada"]."','".$Fila0["unidades"]."' ";
									$insertar.=" ,'".$Fila0["peso_preparado"]."','".$Fila0["cod_marca"]."','".$Fila1["cod_producto"]."', ";
									$insertar.="'".$Fila1["cod_subproducto"]."','".$Fila1["cod_cliente"]."','E','".$Fila1["cod_puerto"]."','".$Fila1["cod_nave"]."',";
									$insertar.="'".$Fila["tipo_embarque"]."','".$Fila["fecha_envio"]."','C','".$Fila["rut_cliente"]."','".$Fila["cod_sub_cliente"]."', ";
									$insertar.=" '".$Fila["cod_estado"]."','".$Fila1["cod_prestador_servicio"]."','".$Fila1["cod_prestador_servicio2"]."', ";
									$insertar.=" '".$Fila1["cod_servicio"]."','".$Fila1["num_viaje"]."' ) ";
									echo $insertar."<br>";
									//mysqli_query($link, $insertar);
									$Actualizar="UPDATE sec_web.programa_enami set estado2='C' where corr_enm='".$Instruccion."' ";
									//mysqli_query($link, $Actualizar);
									echo $Actualizar."<br>";
								}
								else
								{
									$Mensaje2="No se puede asignar el envio ".$Envio." ,por tener producto diferentes ";
								}
							}
							else
							{
								$Mensaje2="No se puede asignar el envio ".$Envio." ,por tener clientes diferentes ";
							}	
						}
					}
					else
					{
						
						$Mensaje2="No se puede asignar el envio ".$Envio." ,ya que el envio pertenece a codelco";
					}
				}	
			break;	
	}
	switch ($Proceso)
	{
		case "G":
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmConfEnvio.action='sec_seleccion_num_envio_despacho.php?CmbDias=".$CmbDias."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."';";
			echo "window.opener.document.FrmConfEnvio.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "E":
			header('location:sec_confirmacion_num_envio.php?Valores='.$Valores2);
			break;
		case "A":
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmConfEnvio.action='sec_seleccion_num_envio_despacho.php?Mensaje=".$Mensaje."&Envio=S';";
			echo "window.opener.document.FrmConfEnvio.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "Asignar":
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmConfEnvio.action='sec_confirmacion_num_envio.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Mensaje2=".$Mensaje2."&Ver=S';";
			echo "window.opener.document.FrmConfEnvio.submit();";
			echo "window.close();";
			echo "</script>";
			break;
	}			
?>
