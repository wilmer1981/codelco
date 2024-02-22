<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = $Ano."-".$Mes."-".$Dia;
	$FechaMovimiento=date("Y-m-d h:i");
	$Rut=$CookieRut;
	switch ($Proceso)
	{
		case "A":
			$Consulta = "select count(*) as existe from pmn_web.carga_horno_trof ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and hornada = '".$Hornada."'";
			$Consulta.= " and turno = '".$CmbTurno."'";
			$Consulta.= " and cod_producto = '".$Producto."'";
			$Consulta.= " and cod_subproducto = '".$SubProducto."'";
			$Respuesta = mysqli_query($link, $Consulta);
			$Row = mysqli_fetch_array($Respuesta);
			if ($Row[existe] > 0 )
			{
				//ACTUALIZA SOLO CABECERA
				$Actualizar = "UPDATE pmn_web.carga_horno_trof set ";
				$Actualizar.= " observacion = '".$Obs."'";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and hornada = '".$Hornada."'";
				mysqli_query($link, $Actualizar);

				//Movimientos_Pmn('',$Producto,$SubProducto,'3','0','1',$Hornada,'','4-1',$CookieRut,'M','Bene',$CmbTurno);

				header("location:pmn_principal_reportes.php?Buscar=S&DiaC=".$Dia."&MesC=".$Mes."&AnoC=".$Ano."&Hornada=".$Hornada."&Tab2=true&TabHorno1=true");				
			}
			else
			{
				//GRABA EL NUEVO PRODUCTO Y ACTUALIZA LA CABECERA
				//ACTUALIZA SOLO CABECERA
				$Actualizar = "UPDATE pmn_web.carga_horno_trof set ";
				$Actualizar.= " observacion = '".$Obs."'";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and hornada = '".$Hornada."'";
				mysqli_query($link, $Actualizar);
				//GRABA NUEVO REGISTRO
				$Insertar = "INSERT INTO pmn_web.carga_horno_trof ";
				$Insertar.= "(rut, hornada, fecha, turno, cod_producto, cod_subproducto, observacion) ";
				$Insertar.= " values('".$CookieRut."','".$Hornada."', '".$Fecha."', '".$CmbTurno."','".$Producto."','".$SubProducto."','".$Obs."')";
				mysqli_query($link, $Insertar);	
				
				//Movimientos_Pmn('',$Producto,$SubProducto,'3','0','1',$Hornada,'','4-1',$CookieRut,'I','Bene',$CmbTurno);
							
				header("location:pmn_principal_reportes.php?Buscar=S&DiaC=".$Dia."&MesC=".$Mes."&AnoC=".$Ano."&Hornada=".$Hornada."&Tab2=true&TabHorno1=true");
			}
			break;
		case "G":
			$Consulta = "select count(*) as existe from pmn_web.carga_horno_trof ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and hornada = '".$Hornada."'";
			$Consulta.= " and turno = '".$CmbTurno."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			$Row = mysqli_fetch_array($Respuesta);
			if ($Row[existe] > 0 )
			{
				//ACTUALIZA SOLO CABECERA
				$Actualizar = "UPDATE pmn_web.carga_horno_trof set ";
				$Actualizar.= " observacion = '".$Obs."'";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and hornada = '".$Hornada."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				// GRABA CABECERA
				$Insertar = "INSERT INTO pmn_web.carga_horno_trof(rut, fecha, hornada, observacion) ";
				$Insertar.= " values('".$CookieRut."', '".$Ano."-".$Mes."-".$Dia."', '".$Hornada."', '".$Obs."')";
				mysqli_query($link, $Insertar);
				// Inserta Plantilla de SubProductos
				$Consulta = "select t2.cod_producto, t2.cod_subproducto,t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.subproducto t2 ";
				$Consulta.= " on t1.valor_subclase1 = t2.cod_producto and t1.valor_subclase2 = t2.cod_subproducto and ";
				$Consulta.= " t1.cod_clase = '6004'";
				$Consulta.= " order by t2.descripcion";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);
				$i=2;
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					$Insertar = "INSERT INTO pmn_web.carga_horno_trof ";
					$Insertar.= "(rut, hornada, fecha, turno, cod_producto, cod_subproducto, observacion) ";
					$Insertar.= " values('".$CookieRut."','".$Hornada."', '".$Fecha."', '".$CmbTurno."', ";
					$Insertar.= "'".$Row["cod_producto"]."','".$Row["cod_subproducto"]."','".$Obs."')";
					//echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
				}
			}			
			
			if (count($IdTurno)>0)
			{
				$Pas='N';
				reset($IdTurno);
				while (list($i,$p) = each($IdTurno))
				{
					$TxtPesoDisp[$i]=str_replace(".","",$TxtPesoDisp[$i]);		
					$TxtPesoDisp[$i]=str_replace(",",".",$TxtPesoDisp[$i]);		
					$TxtCantidad[$i]=str_replace(".","",$TxtCantidad[$i]);		
					$TxtCantidad[$i]=str_replace(",",".",$TxtCantidad[$i]);		
					if($TxtCantidad[$i]>$TxtPesoDisp[$i])
					{
						$PesosExcede=$PesosExcede.$TxtCantidad[$i]." - ".$TxtPesoDisp[$i].", ";
						$Pas='S';
					}
					else
					{
						if($IdMostrar[$i]=="S")
						{
							if (($TxtPesoDisp[$i] < $TxtCantidad[$i]) and ($IdProducto[$i] != '39' and $IdSubProducto[$i] != '11') and ($IdProducto[$i] != '36' and $IdSubProducto[$i] != '1'))
							{
								$Mensaje="S";
							}
							else
							{	
								if (($IdProducto[$i] != '39' and $IdSubProducto[$i] != '11') and ($IdProducto[$i] != '36' and $IdSubProducto[$i] != '1'))
								{
	/*								$Actualizar="UPDATE pmn_web.stock set peso=(peso-".$TxtCantidad[$i].") ";
									$Actualizar.=" where cod_producto='".$IdProducto[$i]."' ";
									$Actualizar.="	and cod_subproducto='".$IdSubProducto[$i]."'";
									//echo $Actualizar."<br>";
									mysqli_query($link, $Actualizar);*/
								}
								$SelectAnt="select cantidad from pmn_web.carga_horno_trof where fecha = '".$Fecha."' and hornada = '".$Hornada."' and turno = '".$p."' and cod_producto = '".$IdProducto[$i]."' and cod_subproducto = '".$IdSubProducto[$i]."'";
								$RespAnt=mysqli_query($link, $SelectAnt);	
								if($FilaAnt=mysqli_fetch_assoc($RespAnt))	
								{
									if($FilaAnt[cantidad]=='')
										$CantAnterior=0;
									else
										$CantAnterior=$FilaAnt[cantidad];	
								}	
								//ACTUALIZA SOLO CABECERA
								$Actualizar = "UPDATE pmn_web.carga_horno_trof set ";
								//$Actualizar.= " cant_disponible = '".str_replace(",",".",$TxtCantDisp[$i])."',";
								$Actualizar.= " peso_disponible = '".$TxtPesoDisp[$i]."',";
								$Actualizar.= " cantidad = '".$TxtCantidad[$i]."'";
								$Actualizar.= " where fecha = '".$Fecha."'";
								$Actualizar.= " and hornada = '".$Hornada."'";
								$Actualizar.= " and turno = '".$p."'";
								$Actualizar.= " and cod_producto = '".$IdProducto[$i]."'";
								$Actualizar.= " and cod_subproducto = '".$IdSubProducto[$i]."'";
								//echo $Actualizar."<br>";
								mysqli_query($link, $Actualizar);
								$insertar="INSERT INTO pmn_web.movimientos (rut,fecha,tipo_movimiento,cantidad,hornada,cod_producto,cod_subproducto)values ";
								$insertar.="('".$Rut."','".$FechaMovimiento."','3','".$TxtCantidad[$i]."', ";
								$insertar.=" '".$Hornada."' ,'".$IdProducto[$i]."','".$IdSubProducto[$i]."')";							
								mysqli_query($link, $insertar);
								
								StockPmn_valor($IdProducto[$i],$IdSubProducto[$i],$Ano,$Mes,'E','B',$CantAnterior,'0');
								StockPmn_valor($IdProducto[$i],$IdSubProducto[$i],$Ano,$Mes,'I','B',$TxtCantidad[$i],'0');
							}
						}
						else
						{
							$SelectAnt="select cantidad from pmn_web.carga_horno_trof where fecha = '".$Fecha."' and hornada = '".$Hornada."' and turno = '".$p."' and cod_producto = '".$IdProducto[$i]."' and cod_subproducto = '".$IdSubProducto[$i]."'";
							$RespAnt=mysqli_query($link, $SelectAnt);	
							if($FilaAnt=mysqli_fetch_assoc($RespAnt))	
							{
								if($FilaAnt[cantidad]=='')
									$CantAnterior=0;
								else
									$CantAnterior=$FilaAnt[cantidad];	
							}						
							//ACTUALIZA SOLO CABECERA
							$Actualizar = "UPDATE pmn_web.carga_horno_trof set ";
							//$Actualizar.= " cant_disponible = '".str_replace(",",".",$TxtCantDisp[$i])."',";
							$Actualizar.= " peso_disponible = '".$TxtPesoDisp[$i]."',";
							$Actualizar.= " cantidad = '".$TxtCantidad[$i]."'";
							$Actualizar.= " where fecha = '".$Fecha."'";
							$Actualizar.= " and hornada = '".$Hornada."'";
							$Actualizar.= " and turno = '".$p."'";
							$Actualizar.= " and cod_producto = '".$IdProducto[$i]."'";
							$Actualizar.= " and cod_subproducto = '".$IdSubProducto[$i]."'";
							//echo $Actualizar."<br>";
							mysqli_query($link, $Actualizar);
							$insertar="INSERT INTO pmn_web.movimientos (rut,fecha,tipo_movimiento,cantidad,hornada,cod_producto,cod_subproducto)values ";
							$insertar.="('".$Rut."','".$FechaMovimiento."','3','".$TxtCantidad[$i]."', ";
							$insertar.=" '".$Hornada."' ,'".$IdProducto[$i]."','".$IdSubProducto[$i]."')";
							//echo $insertar."<br>";
							mysqli_query($link, $insertar);

							StockPmn_valor($IdProducto[$i],$IdSubProducto[$i],$Ano,$Mes,'E','B',$CantAnterior,'0');
							StockPmn_valor($IdProducto[$i],$IdSubProducto[$i],$Ano,$Mes,'I','B',$TxtCantidad[$i],'0');
						}
					}
				}
			}
			if($Pas=='S')
			{
				$PesosExcede=substr($PesosExcede,0,strlen($PesosExcede)-2);
				$Mensaje2="Peso(s) Beneficiado(s) - Excede(n) Stock: ".$PesosExcede;
			}
			header("location:pmn_principal_reportes.php?Buscar=S&DiaC=".$Dia."&MesC=".$Mes."&AnoC=".$Ano."&Hornada=".$Hornada."&Mensaje=".$Mensaje."&Mensaje2=".$Mensaje2."&Tab2=true&TabHorno1=true");
			break;
		case "C":
			header("location:pmn_principal_reportes.php?Tab2=true&TabHorno1=true");
			break;
		case "E":
			if (count($IdTurno)>0)
			{
				while (list($i,$p) = each($IdTurno))
				{
					if($IdMostrar[$i]=="S")
					{
						$Actualizar="UPDATE pmn_web.stock set peso=(peso +".$TxtCantidad[$i].") ";
						$Actualizar.=" where cod_producto='".$IdProducto[$i]."' and cod_subproducto='".$IdSubProducto[$i]."' ";
						mysqli_query($link, $Actualizar);
					}
					$SelectAnt="select cantidad from pmn_web.carga_horno_trof where fecha = '".$Fecha."' and hornada = '".$Hornada."' and turno = '".$p."' and cod_producto = '".$IdProducto[$i]."' and cod_subproducto = '".$IdSubProducto[$i]."'";
					$RespAnt=mysqli_query($link, $SelectAnt);	
					if($FilaAnt=mysqli_fetch_assoc($RespAnt))	
					{
						if($FilaAnt[cantidad]=='')
							$CantAnterior=0;
						else
							$CantAnterior=$FilaAnt[cantidad];	
					}	
										
					if($IdProducto[$i]=='')
						$IdProducto[$i]=0;
					if($IdSubProducto[$i]=='')
						$IdSubProducto[$i]=0;
					if($IdProducto[$i]==0 && $IdSubProducto[$i]==0)
					{
						$SelectAnt="select observacion_reproceso from pmn_web.carga_horno_trof where fecha = '".$Fecha."' and hornada = '".$Hornada."' and turno = '".$p."' and cod_producto = '".$IdProducto[$i]."' and cod_subproducto = '".$IdSubProducto[$i]."'";
						$RespRepr=mysqli_query($link, $SelectAnt);	
						if($FilaRepr=mysqli_fetch_assoc($RespRepr))	
						{
							$DatosReproceso=explode('//',$FilaRepr[observacion_reproceso]);
							$DatosReproceso=explode('~',$DatosReproceso[1]);
							$Actualiza="UPDATE pmn_web.produccion_horno_trof set num_anodos=num_anodos+'".$DatosReproceso[1]."',peso=peso+'".$DatosReproceso[2]."' where hornada = '".$DatosReproceso[3]."'";
							//echo $Actualiza."<br>";
							mysqli_query($link, $Actualiza);
						}	
					}

					$Eliminar = "delete from pmn_web.carga_horno_trof ";
					$Eliminar.= " where fecha = '".$Fecha."'";
					$Eliminar.= " and hornada = '".$Hornada."'";
					$Eliminar.= " and turno = '".$p."'";
					$Eliminar.= " and cod_producto = '".$IdProducto[$i]."'";
					$Eliminar.= " and cod_subproducto = '".$IdSubProducto[$i]."'";
					//echo $Eliminar;
					mysqli_query($link, $Eliminar);
					
					if($IdProducto[$i]!=0 && $IdSubProducto[$i]!=0)
						StockPmn_valor($IdProducto[$i],$IdSubProducto[$i],$Ano,$Mes,'E','B',$CantAnterior,'0');
				}
			}
			header("location:pmn_principal_reportes.php?DiaC=".$Dia."&MesC=".$Mes."&AnoC=".$Ano."&Hornada=".$Hornada."&Tab2=true&TabHorno1=true&Buscar=S&Mensaje=Elim");				
		break;	
		case "S":
			
			if (count($checkbox)>0)
			{
				$valores = explode("~",$parametros);
		        while(list($c,$v) = each($valores))
		           {  
				     $arreglo = explode("/", $v); //Fecha - revision.
			         $fecha = substr($arreglo[0],0,7);
					
					$v=substr($arreglo[0],0,6);
				    $Eliminar = "delete from pmn_web.carga_horno_trof ";
					$Eliminar.= " where hornada='".$v."' and fecha = '".$arreglo[1]."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
					
				}
				header("location:pmn_ing_carga_horno_trof02.php?Buscar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			else
			{
				// ELIMINA TODO EL REGISTRO
				/*$Eliminar = "delete from pmn_web.carga_horno_trof ";
				$Eliminar.= " where fecha = '".$Fecha."'";
				$Eliminar.= " and hornada = '".$Hornada."'";
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";
				header("location:pmn_ing_carga_horno_trof.php");*/
			}	
		break;		
		
		case "CargaHRepr":
			$PesoBeneRepr=str_replace(',','.',$PesoBeneRepr);
			//CONSULTO SI EXISTE HORNADA A LA CUAL SE LE CARGARAN LAS DE REPROCESO
			$SelectAnt="select cantidad from pmn_web.carga_horno_trof where fecha = '".$Fecha."' and hornada = '".$Hornada."'";
			$RespAnt=mysqli_query($link, $SelectAnt);	
			if($FilaAnt=mysqli_fetch_assoc($RespAnt))	
			{
				$SelectAnt="select cantidad from pmn_web.carga_horno_trof where fecha = '".$Fecha."' and hornada = '".$Hornada."' and cod_producto=0 and cod_subproducto=0 and turno='".$CmbTurno."'";
				$RespAnt=mysqli_query($link, $SelectAnt);	
				if(!$FilaAnt=mysqli_fetch_assoc($RespAnt))	
				{
					$HornadaRepr=explode('~',$HornadaElect);
	
					$Actualiza="UPDATE pmn_web.produccion_horno_trof set num_anodos=num_anodos-'".$CantAnRepr."',peso=peso-'".$PesoBeneRepr."' where hornada = '".$HornadaRepr[0]."'";
					//echo $Actualiza."<br>";
					mysqli_query($link, $Actualiza);

					$Insertar = "INSERT INTO pmn_web.carga_horno_trof ";
					$Insertar.= "(rut, hornada, fecha, turno, cod_producto, cod_subproducto, peso_disponible,cantidad) ";
					$Insertar.= " values('".$CookieRut."','".$Hornada."', '".$Fecha."', '".$CmbTurno."', ";
					$Insertar.= "'0','0','0','".$PesoBeneRepr."')";
					//echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
					
					$ObsReproceso2=$ObsRepr." Hornada Reproceso: ".$HornadaRepr[0].", Cant. Anodos: ".$CantAnRepr." y Peso Beneficiado: ".$PesoBeneRepr."//Reproceso~".$CantAnRepr."~".$PesoBeneRepr."~".$HornadaRepr[0];
					$Actualiza="UPDATE pmn_web.carga_horno_trof set observacion_reproceso='".$ObsReproceso2."' where fecha = '".$Fecha."' and turno='".$CmbTurno."' and hornada = '".$Hornada."' and cod_producto=0 and cod_subproducto=0";
					//echo $Actualiza."<br>";
					mysqli_query($link, $Actualiza);
					
					header("location:pmn_principal_reportes.php?Buscar=S&Hornada=".$Hornada."&FechaRepr=".$Fecha."&DiaC=".$Dia."&MesC=".$Mes."&AnoC=".$Ano."&Tab2=true&TabHorno1=true&GrabaReproc=S");
				}
				else
					header("location:pmn_principal_reportes.php?Mensaje=ExisEnT&Hornada=".$Hornada."&Tab2=true&TabHorno1=true&FechaRepr=".$Fecha."&DiaC=".$Dia."&MesC=".$Mes."&AnoC=".$Ano."&Buscar=S");
			}
			else
				header("location:pmn_principal_reportes.php?ErrorRepr=NoH&Hornada=".$Hornada."&Tab2=true&TabHorno1=true");
		break;
	}
	
?>