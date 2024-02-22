<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = $AnoDese."-".$MesDese."-".$DiaDese;
	$FechaSalida = $AnoSalida."-".$MesSalida."-".$DiaSalida;
	$FechaMovimiento=date("Y-m-d h:i");
	$Rut=$CookieRut;
	
	$KwhIni=str_replace(".","",$KwhIni);
	$KwhIni=str_replace(",",".",$KwhIni);
	$KwhFin=str_replace(".","",$KwhFin);
	$KwhFin=str_replace(",",".",$KwhFin);
	$SacosCarbon=str_replace(".","",$SacosCarbon);
	$SacosCarbon=str_replace(",",".",$SacosCarbon);
	$Acidc=str_replace(".","",$Acidc);
	$Acidc=str_replace(",",".",$Acidc);
	$Petracel=str_replace(".","",$Petracel);
	$Petracel=str_replace(",",".",$Petracel);
	$ProdCalcina=str_replace(".","",$ProdCalcina);
	$ProdCalcina=str_replace(",",".",$ProdCalcina);
	switch ($Proceso)
	{
		case "GL": //GRABA LIXIVIACION
			// ACTUALIZA O GRABA DATOS DE CABECERA
			$Consulta = "Select * from pmn_web.deselenizacion ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and num_horno = '".$NumHorno."'";
			$Consulta.=" and num_funda='".$NumFunda."'";
			$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
			$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
			$Consulta.= " and turno = '".$Turno."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//CONSULTA DATOS EN BD				
				if ($Row[prod_calcina] == 0)
					$CalcinaAnterior = "";
				else
					$CalcinaAnterior = $Row[prod_calcina];
				//GRABA EN REGISTRO CAMBIOS SI HAY MODIG. EN CALCINA
				if (($CalcinaAnterior != "") && ($CalcinaAnterior != $ProdCalcina))
				{
					$Insertar = "INSERT INTO pmn_web.registro_cambios (rut, fecha_hora, cod_pantalla, campo, valor_ant, valor_nuevo) ";
					$Insertar.= " values('".$CookieRut."','".date("Y-m-d H:i:s")."','2','CALCINA','".$CalcinaAnterior."','".$ProdCalcina."')";
					//echo "1: ".$Insertar."<br>";
					mysqli_query($link, $Insertar);
				}
				$Hornada=$NumHorno.$NumFunda.$HornadaTotal.$HornadaParcial;
				$HornadaIU=$NumHorno."-".$NumFunda."-".$HornadaTotal."-".$HornadaParcial;
				//---------------------------------------------------
				$Consulta="select prod_calcina from pmn_web.deselenizacion ";
				$Consulta.=" where fecha = '".$Fecha."'";
				$Consulta.= " and num_horno = '".$NumHorno."'";
				$Consulta.= " and num_funda = '".$NumFunda."'";
				$Consulta.= " and hornada_total = '".$HornadaTotal."'";
				$Consulta.= " and hornada_parcial = '".$HornadaParcial."'";
				$Consulta.= " and turno = '".$Turno."'";
				//echo "consulta:     ".$Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Menor=$Fila[prod_calcina];
				$Mayor=$ProdCalcina;
				$Diferencia=$Mayor-$Menor;
				$Actualizar="UPDATE pmn_web.stock set peso=(peso +".$Diferencia.") ";
				$Actualizar.=" where cod_producto='36' and cod_subproducto='1' ";				
				//echo "2: ".$Actualizar."<br>";
				mysqli_query($link, $Actualizar);				
				//-------------------------------------------
				$Actualizar = "UPDATE pmn_web.deselenizacion set ";
				$Actualizar.= " kwh_ini = '".$KwhIni."', ";
				$Actualizar.= " kwh_fin = '".$KwhFin."', ";
				$Actualizar.= " sacos_carbon = '".$SacosCarbon."', ";
				$Actualizar.= " operador = '".$Operador01."', ";
				$Actualizar.= " acidc = '".$Acidc."', ";
				$Actualizar.= " petracel = '".$Petracel."', ";
				$Actualizar.= " fecha_salida = '".$FechaSalida."',";
				$Actualizar.= " prod_calcina = '".$ProdCalcina."', ";
				$Actualizar.= " operador_02 = '".$Operador02."', ";
				$Actualizar.= " hornada = '".$HornadaIU."', ";
				$Actualizar.= " observacion = '".$ObsDese."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and num_horno = '".$NumHorno."'";
				$Actualizar.= " and num_funda = '".$NumFunda."'";
				$Actualizar.= " and hornada_total = '".$HornadaTotal."'";
				$Actualizar.= " and hornada_parcial = '".$HornadaParcial."'";
				$Actualizar.= " and turno = '".$Turno."'";
				//echo "3: ".$Actualizar."<br>";
				mysqli_query($link, $Actualizar);

				//Movimientos_Pmn('','36','1','2',str_replace(",",".",$ProdCalcina),'1',$Hornada,'','3',$CookieRut,'M','',$Turno);
								
				//CONSULTO SI EXISTE
				$Consulta = "Select * from pmn_web.detalle_deselenizacion ";
				$Consulta.= " where tipo = 'L'";
				$Consulta.= " and fecha = '".$Fecha."'";
				$Consulta.= " and num_horno = '".$NumHorno."'";
				$Consulta.=" and num_funda='".$NumFunda."'";
				$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
				$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
				$Consulta.= " and turno = '".$Turno."'";
				$Consulta.= " and referencia = '".$Lixiviacion."'";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Row = mysqli_fetch_array($Respuesta))
				{
					//NADA
				}
				else
				{
					//INSERTO DETALLE
					$Insertar = "INSERT INTO pmn_web.detalle_deselenizacion ";
					$Insertar.= "(tipo, fecha,num_horno,num_funda,hornada_total,hornada_parcial,turno, cod_producto, cod_subproducto, ";
					$Insertar.= "id_producto, referencia, bad,hornada) ";
					$Insertar.= " values('L','".$Fecha."','".$NumHorno."','".$NumFunda."','".$HornadaTotal."','".$HornadaParcial."','".$Turno."','','','','".$Lixiviacion."','0','".$HornadaIU."')";
					//echo "4: ".$Insertar."<br>";
					mysqli_query($link, $Insertar);
					
				}
			}
			else
			{
				//----------------------------------------------------------
				$Consulta="select prod_calcina from pmn_web.deselenizacion ";
				$Consulta.=" where fecha = '".$Fecha."'";
				$Consulta.= " and num_horno = '".$NumHorno."'";
				$Consulta.= " and num_funda = '".$NumFunda."'";
				$Consulta.= " and hornada_total = '".$HornadaTotal."'";
				$Consulta.= " and hornada_parcial = '".$HornadaParcial."'";
				$Consulta.= " and turno = '".$Turno."'";
				//echo $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Menor=$Fila[prod_calcina];
				$Mayor=$ProdCalcina;
				$Diferencia=$Mayor-$Menor;
				$Actualizar="UPDATE pmn_web.stock set peso=(peso +".$Diferencia.") ";
				$Actualizar.=" where cod_producto='36' and cod_subproducto='1' ";
				//echo "5: ".$Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				//INSERTO CABECERA
				if($Acidc!='')
					$Acidc=str_replace(",",".",$Acidc);
				else
					$Acidc='0';	
				if($Petracel!='')
					$Petracel=str_replace(",",".",$Petracel);	
				else
					$Petracel='0';	
				if($ProdCalcina!='')
					$ProdCalcina=str_replace(",",".",$ProdCalcina);	
				else
					$ProdCalcina='0';	
					
				$Hornada=$NumHorno.$NumFunda.$HornadaTotal.$HornadaParcial;
				$HornadaIU=$NumHorno."-".$NumFunda."-".$HornadaTotal."-".$HornadaParcial;
					
				if($KwhIni=='')	
					$KwhIni=0;
				if($KwhFin=='')	
					$KwhFin=0;
				$Insertar = "INSERT INTO pmn_web.deselenizacion ";
				$Insertar.= "(rut, fecha, num_horno,num_funda,hornada_total,hornada_parcial, kwh_ini, kwh_fin, sacos_carbon, ";
				$Insertar.= " operador, acidc, petracel, fecha_salida, prod_calcina, operador_02,turno,hornada,observacion) ";
				$Insertar.= " values('".$CookieRut."','".$Fecha."','".$NumHorno."','".$NumFunda."','".$HornadaTotal."','".$HornadaParcial."','".$KwhIni."','".$KwhFin."',";
				$Insertar.= "'".$SacosCarbon."','".$Operador01."','".$Acidc."','".$Petracel."',";
				$Insertar.= "'".$FechaSalida."','".$ProdCalcina."','".$Operador02."','".$Turno."','".$HornadaIU."','".$ObsDese."')";
				//echo "6: ".$Insertar."<br>";
				mysqli_query($link, $Insertar);
				
				
				//CONSULTO SI EXISTE
				$Consulta = "Select * from pmn_web.detalle_deselenizacion ";
				$Consulta.= " where tipo = 'L'";
				$Consulta.= " and fecha = '".$Fecha."'";
				$Consulta.= " and num_horno = '".$NumHorno."'";
				$Consulta.=" and num_funda='".$NumFunda."'";
				$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
				$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
				$Consulta.= " and referencia = '".$Lixiviacion."'";
				$Consulta.= " and turno = '".$Turno."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Row = mysqli_fetch_array($Respuesta))
				{
					//NADA
				}
				else
				{
					//INSERTO DETALLE
					$Insertar = "INSERT INTO pmn_web.detalle_deselenizacion ";
					$Insertar.= "(tipo, fecha,num_horno,num_funda,hornada_total,hornada_parcial,turno, cod_producto, cod_subproducto, ";
					$Insertar.= "id_producto, referencia, bad,hornada) ";
					$Insertar.= " values('L','".$Fecha."','".$NumHorno."','".$NumFunda."','".$HornadaTotal."','".$HornadaParcial."','".$Turno."','','','','".$Lixiviacion."','0','".$HornadaIU."')";
					//echo "7: ".$Insertar."<br>"; 
					mysqli_query($link, $Insertar);
				}
			}
			//---------------------------------------
			header ("Location:pmn_principal_reportes.php?ModifDese=S&DiaDese=".$DiaDese."&MesDese=".$MesDese."&AnoDese=".$AnoDese."&NumHorno=".$NumHorno."&NumFunda=".$NumFunda."&HornadaTotal=".$HornadaTotal."&HornadaParcial=".$HornadaParcial."&Turno=".$Turno."&Tab8=true");
			break;
		case "GP":
			$Fecha = $Ano."-".$Mes."-".$Dia;
			$HornadaIU=$NumHorno."-".$NumFunda."-".$HornadaTotal."-".$HornadaParcial;
			for ($i = 0;$i < strlen($Marcados);$i++)
			{
				if (substr($Marcados,$i,1) == "-")
				{
					$Valor = substr($Marcados,0,$i);
					$Marcados = substr($Marcados,$i + 1);
					// ACTUALIZA O GRABA DATOS DE CABECERA
					$Consulta = "Select * from pmn_web.deselenizacion ";
					$Consulta.= " where fecha = '".$Fecha."'";
					$Consulta.= " and num_horno = '".$NumHorno."'";
					$Consulta.=" and num_funda='".$NumFunda."'";
					$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
					$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
					$Consulta.= " and turno = '".$Turno."'";
					//echo $Consulta."<br>";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Row = mysqli_fetch_array($Respuesta))
					{
						//CONSULTA DATOS EN BD				
						if ($Row[prod_calcina] == 0)
							$CalcinaAnterior = "";
						else
							$CalcinaAnterior = $Row[prod_calcina];
						//GRABA EN REGISTRO CAMBIOS SI HAY MODIG. EN CALCINA
						if (($CalcinaAnterior != "") && ($CalcinaAnterior != $ProdCalcina))
						{
							$Insertar = "INSERT INTO pmn_web.registro_cambios (rut, fecha_hora, cod_pantalla, campo, valor_ant, valor_nuevo) ";
							$Insertar.= " values('".$CookieRut."','".date("Y-m-d H:i:s")."','2','CALCINA','".$CalcinaAnterior."','".$ProdCalcina."')";
							//echo "8: ".$Insertar."<br>";
							mysqli_query($link, $Insertar);
						}
						//-------------------------------------------
						$Actualizar = "UPDATE pmn_web.deselenizacion set ";
						$Actualizar.= " kwh_ini = '".$KwhIni."', ";
						$Actualizar.= " kwh_fin = '".$KwhFin."', ";
						$Actualizar.= " sacos_carbon = '".$SacosCarbon."', ";
						$Actualizar.= " operador = '".$Operador01."', ";
						$Actualizar.= " acidc = '".$Acidc."', ";
						$Actualizar.= " petracel = '".$Petracel."', ";
						$Actualizar.= " fecha_salida = '".$FechaSalida."',";
						$Actualizar.= " prod_calcina = '".$ProdCalcina."', ";
						$Actualizar.= " operador_02 = '".$Operador02."' ";
						$Actualizar.= " where fecha = '".$Fecha."'";
						$Actualizar.= " and num_horno = '".$NumHorno."'";
						$Actualizar.= " and num_funda = '".$NumFunda."'";
						$Actualizar.= " and hornada_total = '".$HornadaTotal."'";
						$Actualizar.= " and hornada_parcial = '".$HornadaParcial."'";
						$Actualizar.= " and turno = '".$Turno."'";
						//echo "9: ".$Actualizar."<br>";
						mysqli_query($link, $Actualizar);
						
						$Hornada=$NumHorno.$NumFunda.$HornadaTotal.$HornadaParcial;
						//Movimientos_Pmn('','36','1','2',str_replace(",",".",$ProdCalcina),'1',$Hornada,'','3',$CookieRut,'M','',$Turno);
										
						//CONSULTO SI EXISTE
						$Consulta = "Select * from pmn_web.detalle_deselenizacion ";
						$Consulta.= " where tipo = 'P'";
						$Consulta.= " and fecha = '".$Fecha."'";  
						//$Consulta.= " and hornada = '".$Hornada."'";
						$Consulta.= " and num_horno = '".$NumHorno."'";
						$Consulta.=" and num_funda='".$NumFunda."'";
						$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
						$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
						$Consulta.= " and turno = '".$Turno."'";
						$Consulta.= " and cod_producto = '".$Prod."'";
						$Consulta.= " and cod_subproducto = '".$SubProd."'";
						$Consulta.= " and id_producto = '".$IdProd."'";
						$Consulta.= " and referencia = '".$Valor."'";
						//echo $Consulta."<br>";
						$Respuesta = mysqli_query($link, $Consulta);
						if ($Row = mysqli_fetch_array($Respuesta))
						{
							//NADA
						}
						else
						{
							//INSERTO DETALLE
							$Insertar = "INSERT INTO pmn_web.detalle_deselenizacion ";
							$Insertar.= "(tipo, fecha,num_horno,num_funda,hornada_total,hornada_parcial,cod_producto, cod_subproducto, ";
							$Insertar.= "id_producto, referencia, bad,turno) ";
							$Insertar.= " values('P','".$Fecha."','".$NumHorno."','".$NumFunda."','".$HornadaTotal."','".$HornadaParcial."','".$Prod."','".$SubProd."','".$IdProd."','".$Valor."','0','".$Turno."')";
							//echo "insert del else detalle ".$Insertar."<br>";
							//echo "10: ".$Insertar."<br>";
							mysqli_query($link, $Insertar);
						}
					}
					else
					{
						//INSERTO CABECERA
						if($Acidc!='')
							$Acidc=str_replace(",",".",$Acidc);
						else
							$Acidc='0';	
						if($Petracel!='')
							$Petracel=str_replace(",",".",$Petracel);
						else
							$Petracel='0';	
						if($ProdCalcina!='')
							$ProdCalcina=str_replace(",",".",$ProdCalcina);
						else
							$ProdCalcina='0';	
						$Insertar = "INSERT INTO pmn_web.deselenizacion ";
						$Insertar.= "(rut, fecha,num_horno,num_funda,hornada_total,hornada_parcial, kwh_ini, kwh_fin, sacos_carbon, ";
						$Insertar.= "operador, acidc, petracel, fecha_salida, prod_calcina, operador_02,turno,hornada) ";
						$Insertar.= " values('".$CookieRut."','".$Fecha."','".$NumHorno."','".$NumFunda."','".$HornadaTotal."','".$HornadaParcial."','".$KwhIni."','".$KwhFin."',";
						$Insertar.= "'".$SacosCarbon."','".$Operador."','".$Acidc."','".$Petracel."',";
						$Insertar.= "'".$FechaSalida."','".$ProdCalcina."','".$Operador02."','".$Turno."','".$HornadaIU."')";
						//echo "11: ".$Insertar."<br>";
						//echo "cabezera    ".$Insertar."<br>";
						mysqli_query($link, $Insertar);
						
						$Hornada=$NumHorno.$NumFunda.$HornadaTotal.$HornadaParcial;
						//Movimientos_Pmn('','36','1','2',str_replace(",",".",$ProdCalcina),'1',$Hornada,'','3',$CookieRut,'I','',$Turno);
						
						//CONSULTO SI EXISTE
						$Consulta = "Select * from pmn_web.detalle_deselenizacion ";
						$Consulta.= " where tipo = 'P'";
						$Consulta.= " and fecha = '".$Fecha."'";
						//$Consulta.= " and hornada = '".$Hornada."'";
						$Consulta.= " and num_horno = '".$NumHorno."'";
						$Consulta.=" and num_funda='".$NumFunda."'";
						$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
						$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
						$Consulta.= " and turno = '".$Turno."'";
						$Consulta.= " and cod_producto = '".$Prod."'";
						$Consulta.= " and cod_subproducto = '".$SubProd."'";
						$Consulta.= " and referencia = '".$Valor."'";
						$Respuesta = mysqli_query($link, $Consulta);
						if ($Row = mysqli_fetch_array($Respuesta))
						{
							//NADA
						}
						else
						{
							//INSERTO DETALLE
							$Insertar = "INSERT INTO pmn_web.detalle_deselenizacion ";
							$Insertar.= "(tipo, fecha,num_horno,num_funda,hornada_total,hornada_parcial,turno, cod_producto, cod_subproducto, ";
							$Insertar.= "id_producto, referencia, bad) ";
							$Insertar.= " values('P','".$Fecha."','".$NumHorno."','".$NumFunda."','".$HornadaTotal."','".$HornadaParcial."','".$Turno."','".$Prod."','".$SubProd."','".$IdProd."','".$Valor."','0')";
							//echo "ultimo detalle ".$Insertar."<br>";
							//echo "12: ".$Insertar."<br>";
							mysqli_query($link, $Insertar);
						}
					}
					//---------------------------------------
					$i = 0;
				}
			}
			
			echo "<script language='JavaScript'>\n";
			echo "window.opener.document.frmPrincipalRpt.action='pmn_principal_reportes.php?ModifDese=S&DiaDese=".$Dia."&MesDese=".$Mes."&AnoDese=".$Ano."&NumHorno=".$NumHorno."&NumFunda=".$NumFunda."&HornadaTotal=".$HornadaTotal."&HornadaParcial=".$HornadaParcial."&Turno=".$Turno."&Tab8=true';\n";
			echo "window.opener.document.frmPrincipalRpt.submit();\n";			
			echo "window.close();\n";
			echo "</script>\n";
			break;
		case "E":
		
			$ArrayTipos = explode("~",$MarcadosTipos);
			$ArrayProductos = explode("~",$MarcadosProductos);
			$ArraySubproductos = explode("~",$MarcadosSubproductos);
			$ArrayIdProductos = explode("~",$MarcadosIdProductos);
			$ArrayReferencias = explode("~",$MarcadosReferencias);
			$ArrayValores = explode("~",$MarcadosValores);
			$LargoArray = count($ArrayProductos);
			for ($i = 0; $i < $LargoArray-1; $i++)
			{
				
				if ($ArrayTipos[$i]=="L")
				{
					$Consulta="select * from pmn_web.lixiviacion_barro_anodico  ";
					$Consulta.=" where num_lixiviacion = '".$ArrayReferencias[$i]."' and YEAR(fecha) = year(now()) ";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Row2 = mysqli_fetch_array($Respuesta2))
						$ValorAterior=	$Row2[bad]-$Row2[stock_bad];
						
					$Consulta="select * from pmn_web.lixiviacion_barro_anodico  ";
					$Consulta.=" where num_lixiviacion = '".$ArrayReferencias[$i]."' and YEAR(fecha) = year(now()) ";
					//echo $Consulta."<br>";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Row2 = mysqli_fetch_array($Respuesta2))
					{
						$Actualizar="UPDATE pmn_web.lixiviacion_barro_anodico set stock_bad=(stock_bad + '".$ArrayValores[$i]."') ";
						$Actualizar.=" where num_lixiviacion='".$Row2[num_lixiviacion]."'   ";
						//echo "13: ".$Actualizar."<br>";
						mysqli_query($link, $Actualizar);
					}
					else
					{
						$Consulta="select * from pmn_web.lixiviacion_barro_anodico  ";
						$Consulta.=" where num_lixiviacion = '".$ArrayReferencias[$i]."' and YEAR(fecha) = year(subdate(now(), interval 1 year)) ";
						//echo $Consulta."<BR>";
						$Respuesta2 = mysqli_query($link, $Consulta);
						if ($Row2 = mysqli_fetch_array($Respuesta2))
						{
							$Actualizar="UPDATE pmn_web.lixiviacion_barro_anodico set stock_bad=(stock_bad + '".$ArrayValores[$i]."') ";
							$Actualizar.=" where num_lixiviacion='".$Row2[num_lixiviacion]."'   ";
							//echo "14: ".$Actualizar."<br>";
							mysqli_query($link, $Actualizar);
						}					
					}
					StockPmn_valor('25','1',$AnoDese,$MesDese,'E','B',$ValorAterior,'0');//TIPOMOV: SI ES PRODUCCION O BENEFICIO (P - B), TIPOOPE: SI ES INGRESAR Y ELIMINAR (I - E).

				}
				else//Para los Productos externos
				{
					$Actualizar="UPDATE pmn_web.detalle_productos_externos set stock_bad=(stock_bad + '".str_replace(',','.',$ArrayValores[$i])."') ";
					$Actualizar.=" where cod_producto='".$ArrayProductos[$i]."' and cod_subproducto='".$ArraySubproductos[$i]."' ";
					$Actualizar.=" and id_producto='".$ArrayIdProductos[$i]."' and referencia = '".$ArrayReferencias[$i]."'";
					//echo "15: ".$Actualizar."<br>";
					mysqli_query($link, $Actualizar);					
				}
				
				$Consulta = "Select * from pmn_web.deselenizacion ";
				$Consulta.= " where fecha = '".$Fecha."'";
				$Consulta.= " and num_horno = '".$NumHorno."'";
				$Consulta.=" and num_funda='".$NumFunda."'";
				$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
				$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
				$Consulta.= " and turno = '".$Turno."'";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Row = mysqli_fetch_array($Respuesta))
				{
					//CONSULTA DATOS EN BD				
					if ($Row[prod_calcina] == 0)
						$CalcElimina = 0;
					else
						$CalcElimina = $Row[prod_calcina];
				}		
				StockPmn_valor('36','1',$AnoSalida,$MesSalida,'E','P',$CalcElimina,'0');					

				$Eliminar = "delete from pmn_web.detalle_deselenizacion where ";
				$Eliminar.= " tipo = '".$ArrayTipos[$i]."'";
				$Eliminar.= " and cod_producto = '".$ArrayProductos[$i]."'";
				$Eliminar.= " and cod_subproducto = '".$ArraySubproductos[$i]."'";
				$Eliminar.= " and id_producto = '".$ArrayIdProductos[$i]."'";
				$Eliminar.= " and referencia = '".$ArrayReferencias[$i]."'";
				$Eliminar.= " and fecha = '".$Fecha."'";
				$Eliminar.= " and num_horno = '".$NumHorno."'";
				$Eliminar.=" and num_funda='".$NumFunda."'";
				$Eliminar.=" and hornada_total ='".$HornadaTotal."'	";
				$Eliminar.=" and hornada_parcial='".$HornadaParcial."'		";
				$Eliminar.= " and turno = '".$Turno."'";				
				mysqli_query($link, $Eliminar);
				//echo "16: ".$Eliminar."<br>";	
				
			}		
			//CONSULTO SI SE ELIMINARON TODOS LOS DETALLES DEL SUBPRODUCTO, SI ES ASI SE BORRA EL REGISTRO IDENTIFICADOR
			$Consulta = "select count(*) as total_detalles from pmn_web.detalle_deselenizacion where ";
			$Consulta.= " fecha = '".$Fecha."'";
			//$Consulta.= " and hornada = '".$Hornada."'";
			$Consulta.= " and num_horno = '".$NumHorno."'";
			$Consulta.=" and num_funda='".$NumFunda."'";
			$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
			$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
			$Consulta.= " and turno = '".$Turno."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				if ($Row[total_detalles] == 0)
				{
					$Eliminar = "delete from pmn_web.deselenizacion where ";
					$Eliminar.= " fecha = '".$Fecha."'";
					$Eliminar.= " and num_horno = '".$NumHorno."'";
					$Eliminar.=" and num_funda='".$NumFunda."'";
					$Eliminar.=" and hornada_total ='".$HornadaTotal."'	";
					$Eliminar.=" and hornada_parcial='".$HornadaParcial."'		";
					$Eliminar.= " and turno = '".$Turno."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);

					$Hornada=$NumHorno.$NumFunda.$HornadaTotal.$HornadaParcial;
					//Movimientos_Pmn('','36','1','2','0','1',$Hornada,'','3',$CookieRut,'E','',$Turno);
					
					//echo "17: ".$Eliminar."<br>";
					header ("Location:pmn_principal_reportes.php?Tab8=true");
				}
				else
				{
					//header ("Location:pmn_ing_deselenizacion.php?Modif=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Hornada=".$Hornada."&Turno=".$Turno);
					header ("Location:pmn_principal_reportes.php?ModifDese=S&DiaDese=".$DiaDese."&MesDese=".$MesDese."&AnoDese=".$AnoDese."&NumHorno=".$NumHorno."&NumFunda=".$NumFunda."&HornadaTotal=".$HornadaTotal."&HornadaParcial=".$HornadaParcial."&Turno=".$Turno."&Tab8=true");
				}
			}
			break;
		case "Eli"://Elimina de observaciones
		
				$Eliminar = "delete from pmn_web.observaciones where ";
				$Eliminar.= " cod_producto = '".$Prod."' and cod_subproducto = '".$SubProd."' and fecha = '".$Fecha."'";
				$Eliminar.= " and num_horno = '".$NumHorno."'";
				$Eliminar.=" and num_funda='".$NumFunda."'";
				$Eliminar.=" and hornada_total ='".$HornadaTotal."'	";
				$Eliminar.=" and hornada_parcial='".$HornadaParcial."'		";
				$Eliminar.= " and turno = '".$Turno."'";				
				mysqli_query($link, $Eliminar);
				header ("Location:pmn_principal_reportes.php?Tab8=true");
				break;	
				
		case "GD":
			//CONSULTA DATOS EN BD
			$Hornada=$NumHorno.$NumFunda.$HornadaTotal.$HornadaParcial;
			$Consulta = "Select * from pmn_web.deselenizacion ";
			$Consulta.= " where fecha = '".$AnoDese."-".$MesDese."-".$DiaDese."'";
			//$Consulta.= " and hornada = '".$Hornada."'";
			$Consulta.= " and num_horno = '".$NumHorno."'";
			$Consulta.=" and num_funda='".$NumFunda."'";
			$Consulta.=" and hornada_total ='".$HornadaTotal."'	";
			$Consulta.=" and hornada_parcial='".$HornadaParcial."'		";
			$Consulta.= " and turno = '".$Turno."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				if ($Row[prod_calcina] == 0)
					$CalcinaAnterior = "";
				else
					$CalcinaAnterior = $Row[prod_calcina];
				//GRABA EN REGISTRO CAMBIOS SI HAY MODIG. EN CALCINA
				if (($CalcinaAnterior != "") && ($CalcinaAnterior != $ProdCalcina))
				{
					$Insertar = "INSERT INTO pmn_web.registro_cambios (rut, fecha_hora, cod_pantalla, campo, valor_ant, valor_nuevo) ";
					$Insertar.= " values('".$CookieRut."','".date("Y-m-d H:i:s")."','2','CALCINA','".$CalcinaAnterior."','".$ProdCalcina."')";
					//echo "18: ".$Insertar."<br>";
					mysqli_query($link, $Insertar);
				}
			}
			StockPmn_valor('36','1',$AnoSalida,$MesSalida,'E','P',$CalcinaAnterior,'0');//TIPOMOV: SI ES PRODUCCION O BENEFICIO (P - B), TIPOOPE: SI ES INGRESAR Y ELIMINAR (I - E).
			StockPmn_valor('36','1',$AnoSalida,$MesSalida,'I','P',$ProdCalcina,'0');
			//PRODUCTO=36 Y SUBPRODUCTO=1 CALCINA.

			//-------------------------------------------
			/*
			echo "MarcadosTipos:".$MarcadosTipos."<br>";
			echo "MarcadosProductos".$MarcadosProductos."<br>";
			echo "MarcadosSubproductos".$MarcadosSubproductos."<br>";
			echo "MarcadosIdProductos".$MarcadosIdProductos."<br>";
			echo "MarcadosReferencias".$MarcadosReferencias."<br>";
			echo "MarcadosValores".$MarcadosValores."<br>";
			echo "MarcadosValAux".$MarcadosValAux."<br>";
			*/
			//echo "marca dos tipos:      ".$MarcadosTipos."<br>";
			$ArrayTipos = explode("~",$MarcadosTipos);
			$ArrayProductos = explode("~",$MarcadosProductos);
			$ArraySubproductos = explode("~",$MarcadosSubproductos);
			$ArrayIdProductos = explode("~",$MarcadosIdProductos);
			$ArrayReferencias = explode("~",$MarcadosReferencias);
			$ArrayValores = explode("~",$MarcadosValores);
			$ArrayValAux = explode("~", $MarcadosValAux);
			
			$LargoArray = count($ArrayTipos);
			for ($i = 0; $i < $LargoArray-1 ; $i++)
			{
				//echo  "arreglo:     ".$ArrayTipos[$i]."<br>";
				if ($ArrayTipos[$i]=="L")//si es lixiviacion actualiza el stock en barro_anodico_descobrizado 
				{
					$Consulta="select * from pmn_web.lixiviacion_barro_anodico  ";
					$Consulta.=" where num_lixiviacion = '".$ArrayReferencias[$i]."' and YEAR(fecha) = year(now()) ";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Row2 = mysqli_fetch_array($Respuesta2))
					{	
						$ValorAterior=	$Row2[bad]-$Row2[stock_bad];				
						if(($Row2[stock_bad] + $ArrayValAux[$i]) >= $ArrayValores[$i])
						{
							$consulta = " SELECT bad AS valor FROM pmn_web.detalle_deselenizacion";
							$consulta.= " where tipo = '".$ArrayTipos[$i]."'";
							$consulta.= " and cod_producto = '".$ArrayProductos[$i]."'";
							$consulta.= " and cod_subproducto = '".$ArraySubproductos[$i]."'";
							$consulta.= " and id_producto = '".$ArrayIdProductos[$i]."'";
							$consulta.= " and referencia = '".$ArrayReferencias[$i]."'";
							$consulta.= " and fecha = '".$Fecha."'";
							$consulta.= " and num_horno = '".$NumHorno."'";
							$consulta.= " and num_funda = '".$NumFunda."'";
							$consulta.= " and hornada_total = '".$HornadaTotal."'";
							$consulta.= " and hornada_parcial = '".$HornadaParcial."'";
							$consulta.= " and turno = '".$Turno."'";
							//echo "detalle deselenizacion:    ".$consulta."<br>";
							$rs10 = mysqli_query($link, $consulta);
							if ($row10 = mysqli_fetch_array($rs10))
								$valor = $row10["valor"];
							else
								$valor = 0;
						
							$Actualizar="UPDATE pmn_web.lixiviacion_barro_anodico set stock_bad=(stock_bad-".str_replace(",",".",($ArrayValores[$i]))."+".($valor).")";
							$Actualizar.=" where num_lixiviacion = '".$Row2[num_lixiviacion]."'	";
							//echo "19: ".$Actualizar."<br>";
							mysqli_query($link, $Actualizar);
							
							
							//ACTUALIZA EL PESO B.A.D.
							$ArrayValores[$i]=str_replace(".","",$ArrayValores[$i]);
							$ArrayValores[$i]=str_replace(",",".",$ArrayValores[$i]);
							$Actualizar = "UPDATE pmn_web.detalle_deselenizacion set ";
							$Actualizar.= " bad = '".$ArrayValores[$i]."' ";
							$Actualizar.= " where ";
							$Actualizar.= " tipo = '".$ArrayTipos[$i]."'";
							$Actualizar.= " and cod_producto = '".$ArrayProductos[$i]."'";
							$Actualizar.= " and cod_subproducto = '".$ArraySubproductos[$i]."'";
							$Actualizar.= " and id_producto = '".$ArrayIdProductos[$i]."'";
							$Actualizar.= " and referencia = '".$ArrayReferencias[$i]."'";
							$Actualizar.= " and fecha = '".$Fecha."'";
							//$Actualizar.= " and hornada = '".$Hornada."'";
							$Actualizar.= " and num_horno = '".$NumHorno."'";
							$Actualizar.= " and num_funda = '".$NumFunda."'";
							$Actualizar.= " and hornada_total = '".$HornadaTotal."'";
							$Actualizar.= " and hornada_parcial = '".$HornadaParcial."'";
							$Actualizar.= " and turno = '".$Turno."'";
							//echo "20: ".$Actualizar."<br>";
							mysqli_query($link, $Actualizar);
							
							$insertar="INSERT INTO pmn_web.movimientos (rut,fecha,tipo_movimiento,cantidad,hornada,lixiviacion)values ";
							$insertar.="('".$Rut."','".$FechaMovimiento."','1','".$ArrayValores[$i]."', ";
							$insertar.=" '".$NumHorno.$NumFunda.$HornadaTotal.$HornadaParcial."' ,'".$ArrayReferencias[$i]."')";
							mysqli_query($link, $insertar);
							//echo "21: ".$insertar."<br>";							
						}
					}
					else
					{
						$Consulta="select * from pmn_web.lixiviacion_barro_anodico  ";
						$Consulta.=" where num_lixiviacion = '".$ArrayReferencias[$i]."' and YEAR(fecha) = year(subdate(now(), interval 1 year)) ";
						//echo "con 2:   ".$Consulta."<br>";
						$Respuesta2 = mysqli_query($link, $Consulta);
						if ($Row2 = mysqli_fetch_array($Respuesta2))
						{
							if($Row2[stock_bad] >= $ArrayValores[$i] )
							{
								$ArrayValores[$i]=str_replace(".","",$ArrayValores[$i]);
								$ArrayValores[$i]=str_replace(",",".",$ArrayValores[$i]);
								$Actualizar="UPDATE pmn_web.lixiviacion_barro_anodico set stock_bad=(stock_bad-".$ArrayValores[$i].") ";
								$Actualizar.=" where num_lixiviacion = '".$Row2[num_lixiviacion]."'	";
								//echo "22: ".$Actualizar."<br>";
								mysqli_query($link, $Actualizar);
								//ACTUALIZA EL PESO B.A.D.
								$Actualizar = "UPDATE pmn_web.detalle_deselenizacion set ";
								$Actualizar.= " bad = '".$ArrayValores[$i]."' ";
								$Actualizar.= " where ";
								$Actualizar.= " tipo = '".$ArrayTipos[$i]."'";
								$Actualizar.= " and cod_producto = '".$ArrayProductos[$i]."'";
								$Actualizar.= " and cod_subproducto = '".$ArraySubproductos[$i]."'";
								$Actualizar.= " and id_producto = '".$ArrayIdProductos[$i]."'";
								$Actualizar.= " and referencia = '".$ArrayReferencias[$i]."'";
								$Actualizar.= " and fecha = '".$Fecha."'";
								//$Actualizar.= " and hornada = '".$Hornada."'";
								$Actualizar.= " and num_horno = '".$NumHorno."'";
								$Actualizar.= " and num_funda = '".$NumFunda."'";
								$Actualizar.= " and hornada_total = '".$HornadaTotal."'";
								$Actualizar.= " and hornada_parcial = '".$HornadaParcial."'";
								$Actualizar.= " and turno = '".$Turno."'";
								//echo "23: ".$Actualizar."<br>";
								mysqli_query($link, $Actualizar);
								$insertar="INSERT INTO pmn_web.movimientos (rut,fecha,tipo_movimiento,bad,hornada,lixiviacion)values ";
								$insertar.="('".$Rut."','".$FechaMovimiento."','1','".$ArrayValores[$i]."', ";
								$insertar.=" '".$NumHorno.$NumFunda.$HornadaTotal.$HornadaParcial."' ,'".$ArrayReferencias[$i]."')";
								//echo "24: ".$insertar."<br>";
								mysqli_query($link, $insertar);
							}
						}
					}
					StockPmn_valor('25','1',$AnoDese,$MesDese,'E','B',$ValorAterior,'0');//TIPOMOV: SI ES PRODUCCION O BENEFICIO (P - B), TIPOOPE: SI ES INGRESAR Y ELIMINAR (I - E).
					StockPmn_valor('25','1',$AnoDese,$MesDese,'I','B',str_replace(",",".",($ArrayValores[$i])),'0');						
				}
				else//si es producto externo actualiza el stock en detalle productos externos
				{
					$Consulta="select * from pmn_web.detalle_productos_externos  where ";
					$Consulta.= " cod_producto = '".$ArrayProductos[$i]."'";
					$Consulta.= " and cod_subproducto = '".$ArraySubproductos[$i]."'";
					$Consulta.= " and id_producto = '".$ArrayIdProductos[$i]."'";
					$Consulta.= " and referencia = '".$ArrayReferencias[$i]."'";
					//echo "con externo:     ".$Consulta."<br>";
					$Respuesta2 = mysqli_query($link, $Consulta);
					$Row2 = mysqli_fetch_array($Respuesta2);
					if($Row2[stock_bad] >= $ArrayValores[$i] )
					{
						$ArrayValores[$i]=str_replace(".","",$ArrayValores[$i]);
						$ArrayValores[$i]=str_replace(",",".",$ArrayValores[$i]);
						$Actualizar="UPDATE pmn_web.detalle_productos_externos set stock_bad=(stock_bad-".$ArrayValores[$i].") ";
						$Actualizar.= " WHERE cod_producto = '".$ArrayProductos[$i]."'";
						$Actualizar.= " and cod_subproducto = '".$ArraySubproductos[$i]."'";
						$Actualizar.= " and id_producto = '".$ArrayIdProductos[$i]."'";
						$Actualizar.= " and referencia = '".$ArrayReferencias[$i]."'";
						//echo "25: ".$Actualizar."<br>";
						mysqli_query($link, $Actualizar);
						//ACTUALIZA EL PESO B.A.D.
						$Actualizar = "UPDATE pmn_web.detalle_deselenizacion set ";
						$Actualizar.= " bad = '".$ArrayValores[$i]."' ";
						$Actualizar.= " where ";
						$Actualizar.= " tipo = '".$ArrayTipos[$i]."'";
						$Actualizar.= " and cod_producto = '".$ArrayProductos[$i]."'";
						$Actualizar.= " and cod_subproducto = '".$ArraySubproductos[$i]."'";
						$Actualizar.= " and id_producto = '".$ArrayIdProductos[$i]."'";
						$Actualizar.= " and referencia = '".$ArrayReferencias[$i]."'";
						$Actualizar.= " and fecha = '".$Fecha."'";
						//$Actualizar.= " and hornada = '".$Hornada."'";
						$Actualizar.= " and num_horno = '".$NumHorno."'";
						$Actualizar.= " and num_funda = '".$NumFunda."'";
						$Actualizar.= " and hornada_total = '".$HornadaTotal."'";
						$Actualizar.= " and hornada_parcial = '".$HornadaParcial."'";
						$Actualizar.= " and turno = '".$Turno."'";
						//echo "26: ".$Actualizar."<br>";
						mysqli_query($link, $Actualizar);
						$insertar="INSERT INTO pmn_web.movimientos (rut,fecha,tipo_movimiento,cantidad,hornada,lixiviacion,cod_producto,cod_subproducto)values ";
						$insertar.="('".$Rut."','".$FechaMovimiento."','2','".$ArrayValores[$i]."', ";
						$insertar.=" '".$NumHorno.$NumFunda.$HornadaTotal.$HornadaParcial."' ,'".$ArrayIdProductos[$i].$ArrayReferencias[$i]."','".$ArrayProductos[$i]."','".$ArraySubproductos[$i]."' )			";
						mysqli_query($link, $insertar);
						//echo "27: ".$insertar."<br>";
					}
				}
			//aqui estaba el cacho	
			}
			//-----------------------------------------------------
			
				$Consulta="select prod_calcina from pmn_web.deselenizacion ";
				$Consulta.=" where fecha = '".$Fecha."'";
				$Consulta.= " and num_horno = '".$NumHorno."'";
				$Consulta.= " and num_funda = '".$NumFunda."'";
				$Consulta.= " and hornada_total = '".$HornadaTotal."'";
				$Consulta.= " and hornada_parcial = '".$HornadaParcial."'";
				$Consulta.= " and turno = '".$Turno."'";
				//echo $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Menor=$Fila[prod_calcina];
				$Mayor=$ProdCalcina;
				$Diferencia=$Mayor-$Menor;
				$Actualizar="UPDATE pmn_web.stock set peso=(peso +".$Diferencia.") ";
				$Actualizar.=" where cod_producto='36' and cod_subproducto='1' ";
				//echo "28: ".$Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				//ACTUALIZA CABECERA	
				if($Hornada=='')
					$Hornada='0';
				else
					$Hornada=$Hornada;				
				$Actualizar = "UPDATE pmn_web.deselenizacion set ";

				$Actualizar.= " kwh_ini = '".$KwhIni."', ";
				$Actualizar.= " kwh_fin = '".$KwhFin."', ";
				$Actualizar.= " sacos_carbon = '".$SacosCarbon."', ";
				$Actualizar.= " operador = '".$Operador01."', ";
				$Actualizar.= " acidc = '".$Acidc."', ";
				$Actualizar.= " petracel = '".$Petracel."', ";
				$Actualizar.= " fecha_salida = '".$FechaSalida."',";
				$Actualizar.= " prod_calcina = '".$ProdCalcina."', ";
				$Actualizar.= " operador_02 = '".$Operador02."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				//$Actualizar.= " and hornada = '".$Hornada."'";
				$Actualizar.= " and num_horno = '".$NumHorno."'";
				$Actualizar.= " and num_funda = '".$NumFunda."'";
				$Actualizar.= " and hornada_total = '".$HornadaTotal."'";
				$Actualizar.= " and hornada_parcial = '".$HornadaParcial."'";
				$Actualizar.= " and turno = '".$Turno."'";
				//echo "29: ".$Actualizar."<br>";
				mysqli_query($link, $Actualizar);

				
				//Movimientos_Pmn('','36','1','2',str_replace(",",".",$ProdCalcina),'1',$Hornada,'','3',$CookieRut,'M','',$Turno);
				//StockPmn_valor('36','1',$AnoSalida,$MesSalida,'I','P',$ProdCalcina);
				
			header ("Location:pmn_principal_reportes.php?ModifDese=S&DiaDese=".$DiaDese."&MesDese=".$MesDese."&AnoDese=".$AnoDese."&NumHorno=".$NumHorno."&NumFunda=".$NumFunda."&HornadaTotal=".$HornadaTotal."&HornadaParcial=".$HornadaParcial."&Turno=".$Turno."&Tab8=true");
			break;
		case "CAN":
			header("location:pmn_principal_reportes.php?Tab8=true");
			break;
	}
?>
