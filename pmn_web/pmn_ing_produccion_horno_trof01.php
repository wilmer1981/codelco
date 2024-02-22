<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = $Ano."-".$Mes."-".$Dia;
	if($HD_fusion=='')
		$HD_fusion=0;
	if($HD_oxida=='')
		$HD_oxida=0;
	if($HD_moldeo=='')
		$HD_moldeo=0;
	if($HD_tmoldeo=='')
		$HD_tmoldeo=0;
	$Peso=str_replace(".","",$Peso);	
	$Peso=str_replace(",",".",$Peso);	
	switch ($Proceso)
	{
		case "C":
			header("location:pmn_principal_reportes.php?Tab2=true&TabHorno2=true");
			break;
		case "GC":
			$Consulta = "select * from pmn_web.produccion_horno_trof ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and hornada = '".$Hornada."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				if($Row["peso"]=='')
					$ValorPesoAnt=0;
				else
					$ValorPesoAnt=$Row["peso"];	
				if($Row[num_anodos]=='')
					$ValorCantAnt=0;
				else
					$ValorCantAnt=$Row[num_anodos];	
					
					
				//echo $Operador;
				$Actualizar = "UPDATE pmn_web.produccion_horno_trof set ";
				$Actualizar.= " observacion = '".$Obs."',";
				$Actualizar.= " gas_natural_ini = '".str_replace(",",".",$GasIni)."',";
				$Actualizar.= " gas_natural_fin = '".str_replace(",",".",$GasFin)."',";
				$Actualizar.= " operador = '".$Operador."',";
				$Actualizar.= " color = '".$Color."',";
				$Actualizar.= " num_anodos = '".str_replace(",",".",$NumAnodos)."',";
				$Actualizar.= " peso = '".$Peso."',";
				$Actualizar.= " inicio_fusion = '".$AnoCarga."-".$MesCarga."-".$DiaCarga." ".$HCarga.":".$MinCarga."',";
				$Actualizar.= " inicio_oxida = '".$AnoOxida."-".$MesOxida."-".$DiaOxida." ".$HOxida.":".$MinOxida."',";
				$Actualizar.= " inicio_moldeo = '".$AnoMol."-".$MesMol."-".$DiaMol." ".$HMol.":".$MinMol."',";
				$Actualizar.= " termino_moldeo = '".$AnoTMol."-".$MesTMol."-".$DiaTMol." ".$HTMol.":".$MinTMol."',";
				$Actualizar.= " HD_fusion = '".$HD_fusion."',";
				$Actualizar.= " HD_oxida = '".$HD_oxida."',";
				$Actualizar.= " HD_moldeo = '".$HD_moldeo."',";
				$Actualizar.= " HD_tmoldeo = '".$HD_tmoldeo."'";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and hornada = '".$Hornada."'";
				//echo "Actualiza:    ".$Actualizar."<br>";
				mysqli_query($link, $Actualizar);	
				
				//Movimientos_Pmn('','65','33','2',str_replace(",",".",$NumAnodos),str_replace(",",".",$Peso),$Hornada,'','4-2',$CookieRut,'M',$Color,'1');
				StockPmn_valor('44','1',$Ano,$Mes,'E','P',$ValorPesoAnt,$ValorCantAnt);
				StockPmn_valor('44','1',$Ano,$Mes,'I','P',$Peso,str_replace(",",".",$NumAnodos));
							
				header("location:pmn_principal_reportes.php?MostrarHornoProd=S&Hornada=".$Hornada."&DiaHP=".$Dia."&MesHP=".$Mes."&AnoHP=".$Ano."&Tab2=true&TabHorno2=true");
			}
			else
			{
				if ($Operador == "S")
					$Operador = "";
				if ($Color == "S")
					$Color = "";

				$Insertar = "INSERT INTO pmn_web.produccion_horno_trof";
				$Insertar.= "(rut,fecha,hornada,observacion, gas_natural_ini,";
				$Insertar.= "gas_natural_fin,operador,color,num_anodos,peso,inicio_fusion,inicio_oxida,inicio_moldeo,termino_moldeo,HD_fusion,HD_oxida,HD_moldeo,HD_tmoldeo)";
				$Insertar.= " values('".$CookieRut."','".$Fecha."','".$Hornada."','".$Obs."','".str_replace(",",".",$GasIni)."',";
				$Insertar.= " '".str_replace(",",".",$GasFin)."','".$Operador."','".$Color."','".str_replace(",",".",$NumAnodos)."','".$Peso."'";
				$Insertar.= " ,'".$AnoCarga."-".$MesCarga."-".$DiaCarga." ".$HCarga.":".$MinCarga."'";
				$Insertar.= " ,'".$AnoOxida."-".$MesOxida."-".$DiaOxida." ".$HOxida.":".$MinOxida."'";
				$Insertar.= " ,'".$AnoMol."-".$MesMol."-".$DiaMol." ".$HMol.":".$MinMol."'";
				$Insertar.= " ,'".$AnoTMol."-".$MesTMol."-".$DiaTMol." ".$HTMol.":".$MinTMol."'";
				$Insertar.= ",'".$HD_fusion."','".$HD_oxida."','".$HD_moldeo."','".$HD_tmoldeo."')";
				//echo "Inserta:    ".$Insertar."<br>";
				mysqli_query($link, $Insertar);
				
				StockPmn_valor('44','1',$Ano,$Mes,'I','P',$Peso,str_replace(",",".",$NumAnodos));
				
				header("location:pmn_principal_reportes.php?MostrarHornoProd=S&Hornada=".$Hornada."&DiaHP=".$Dia."&MesHP=".$Mes."&AnoHP=".$Ano."&Tab2=true&TabHorno2=true");
				
			}
			break;
		case "EC":
			$Consulta = "select * from pmn_web.produccion_horno_trof ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and hornada = '".$Hornada."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				if($Row["peso"]=='')
					$ValorPesoAnt=0;
				else
					$ValorPesoAnt=$Row["peso"];	
				if($Row[num_anodos]=='')
					$ValorCantAnt=0;
				else
					$ValorCantAnt=$Row[num_anodos];	
			}
			StockPmn_valor('44','1',$Ano,$Mes,'E','P',$ValorPesoAnt,$ValorCantAnt);							
			//ELIMINO LEYES
			$Eliminar = "delete from leyes_prod_horno_trof ";
			$Eliminar.= " where fecha = '".$Fecha."'";
			$Eliminar.= " and hornada = '".$Hornada."'";
			mysqli_query($link, $Eliminar);
			//ELIMINO DETALLE
			$Eliminar = "delete from detalle_prod_horno_trof ";
			$Eliminar.= " where fecha = '".$Fecha."'";
			$Eliminar.= " and hornada = '".$Hornada."'";
			mysqli_query($link, $Eliminar);			
			//ELIMINO CABECERA
			$Eliminar = "delete from produccion_horno_trof ";
			$Eliminar.= " where fecha = '".$Fecha."'";
			$Eliminar.= " and hornada = '".$Hornada."'";
			mysqli_query($link, $Eliminar);
			
			
			header("location:pmn_principal_reportes.php?Tab2=true&TabHorno2=true");
			break;
		case "GP": // GRABA PRODUCTO
			$Consulta = "select * from pmn_web.produccion_horno_trof ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and hornada = '".$Hornada."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE pmn_web.produccion_horno_trof set ";
				$Actualizar.= " observacion = '".$Obs."',";
				$Actualizar.= " gas_natural_ini = '".str_replace(",",".",$GasIni)."',";
				$Actualizar.= " gas_natural_fin = '".str_replace(",",".",$GasFin)."',";
				$Actualizar.= " operador = '".$Operador."',";
				$Actualizar.= " color = '".$Color."',";
				$Actualizar.= " num_anodos = '".str_replace(",",".",$NumAnodos)."',";
				$Actualizar.= " peso = '".$Peso."',";
				$Actualizar.= " inicio_fusion = '".$AnoCarga."-".$MesCarga."-".$DiaCarga." ".$HCarga.":".$MinCarga."',";
				$Actualizar.= " inicio_oxida = '".$AnoOxida."-".$MesOxida."-".$DiaOxida." ".$HOxida.":".$MinOxida."',";
				$Actualizar.= " inicio_moldeo = '".$AnoMol."-".$MesMol."-".$DiaMol." ".$HMol.":".$MinMol."',";
				$Actualizar.= " termino_moldeo = '".$AnoTMol."-".$MesTMol."-".$DiaTMol." ".$HTMol.":".$MinTMol."',";
				$Actualizar.= " HD_fusion = '".$HD_fusion."',";
				$Actualizar.= " HD_oxida = '".$HD_oxida."',";
				$Actualizar.= " HD_moldeo = '".$HD_moldeo."',";
				$Actualizar.= " HD_tmoldeo = '".$HD_tmoldeo."'";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and hornada = '".$Hornada."'";
				mysqli_query($link, $Actualizar);	
				
				//Movimientos_Pmn('','65','33','2',str_replace(",",".",$NumAnodos),str_replace(",",".",$Peso),$Hornada,'','4-2',$CookieRut,'M',$Color,'1');							
			}
			else
			{
				if ($Operador == "S")
					$Operador = "";
				if ($Color == "S")
					$Color = "";
				$Insertar = "INSERT INTO pmn_web.produccion_horno_trof";
				$Insertar.= "(rut,fecha,hornada,observacion, gas_natural_ini,";
				$Insertar.= "gas_natural_fin,operador,color,num_anodos,peso,inicio_fusion,inicio_oxida,inicio_moldeo,termino_moldeo,HD_fusion,HD_oxida,HD_moldeo,HD_tmoldeo)";
				$Insertar.= " values('".$CookieRut."','".$Fecha."','".$Hornada."','".$Obs."','".str_replace(",",".",$GasIni)."',";
				$Insertar.= " '".str_replace(",",".",$GasFin)."','".$Operador."','".$Color."','".str_replace(",",".",$NumAnodos)."','".$Peso."'";
				$Insertar.= " ,'".$AnoCarga."-".$MesCarga."-".$DiaCarga." ".$HCarga.":".$MinCarga."'";
				$Insertar.= " ,'".$AnoOxida."-".$MesOxida."-".$DiaOxida." ".$HOxida.":".$MinOxida."'";
				$Insertar.= " ,'".$AnoMol."-".$MesMol."-".$DiaMol." ".$HMol.":".$MinMol."'";
				$Insertar.= " ,'".$AnoTMol."-".$MesTMol."-".$DiaTMol." ".$HTMol.":".$MinTMol."'";
				$Insertar.= ",'".$HD_fusion."','".$HD_oxida."','".$HD_moldeo."','".$HD_tmoldeo."')";
				mysqli_query($link, $Insertar);	

				//Movimientos_Pmn('','65','33','2',str_replace(",",".",$NumAnodos),str_replace(",",".",$Peso),$Hornada,'','4-2',$CookieRut,'I',$Color,'1');							
			}
			$Consulta = "select * from pmn_web.detalle_prod_horno_trof ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and hornada = '".$Hornada."'";
			$Consulta.= " and turno = '".$CmbTurno."'";
			$Consulta.= " and cod_producto = '".$Producto."' ";
			$Consulta.= " and cod_subproducto = '".$Subproducto."'";
			//echo "Consulta:   ".$Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE pmn_web.detalle_prod_horno_trof set ";				
				$Actualizar.= " num_ollas='".str_replace(",",".",$NumOllas)."'";
				$Actualizar.= " where hornada = '".$Hornada."'";
				$Actualizar.= " and fecha = '".$Fecha."'";
				$Actualizar.= " and turno = '".$CmbTurno."'";
				$Actualizar.= " and cod_producto = '".$Producto."' ";
				$Actualizar.= " and cod_subproducto = '".$Subproducto."'";
				//echo "Actualiza:   ".$Actualizar."<br>";
				mysqli_query($link, $Actualizar);

				StockPmn_valor($Producto,$Subproducto,$Ano,$Mes,'E','P',$Row[num_ollas],'0');				
				StockPmn_valor($Producto,$Subproducto,$Ano,$Mes,'I','P',str_replace(",",".",$NumOllas),'0');				

				header("location:pmn_principal_reportes.php?MostrarHornoProd=S&Hornada=".$Hornada."&DiaHP=".$Dia."&MesHP=".$Mes."&AnoHP=".$Ano."&Tab2=true&TabHorno2=true");				
			}
			else
			{
				$Insertar = "INSERT INTO pmn_web.detalle_prod_horno_trof";
				$Insertar.= "(rut,hornada,fecha,turno,cod_producto,cod_subproducto,num_ollas)";
				$Insertar.= " values('".$CookieRut."','".$Hornada."','".$Fecha."','".$CmbTurno."','".$Producto."','".$Subproducto."','".str_replace(",",".",$NumOllas)."')";
				//echo "Iinserta:   ".$Insertar."<br>";
				mysqli_query($link, $Insertar);

				StockPmn_valor($Producto,$Subproducto,$Ano,$Mes,'I','P',str_replace(",",".",$NumOllas),'0');				
				header("location:pmn_principal_reportes.php?MostrarHornoProd=S&Hornada=".$Hornada."&DiaHP=".$Dia."&MesHP=".$Mes."&AnoHP=".$Ano."&Tab2=true&TabHorno2=true");				
			}
			break;
		case "EP":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					//ELIMINO DETALLE
					$Consulta = "select * from pmn_web.detalle_prod_horno_trof ";
					$Consulta.= " where fecha = '".$Fecha."'";
					$Consulta.= " and hornada = '".$Hornada."'";
					$Consulta.= " and turno = '".$p."'";
					$Consulta.= " and cod_producto = '".$ChkProducto[$i]."' ";
					$Consulta.= " and cod_subproducto = '".$ChkSubProducto[$i]."'";
					//echo "Consulta:   ".$Consulta."<br>";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Row = mysqli_fetch_array($Respuesta))
						$NumOllaAnt=$Row[num_ollas];
					StockPmn_valor($ChkProducto[$i],$ChkSubProducto[$i],$Ano,$Mes,'E','P',$NumOllaAnt,'0');				
						
					$Eliminar = "delete from pmn_web.detalle_prod_horno_trof ";
					$Eliminar.= " where fecha = '".$Fecha."'";
					$Eliminar.= " and hornada = '".$Hornada."'";
					$Eliminar.= " and turno = '".$p."'";
					$Eliminar.= " and cod_producto = '".$ChkProducto[$i]."'";
					$Eliminar.= " and cod_subproducto = '".$ChkSubProducto[$i]."'";
					mysqli_query($link, $Eliminar);				
				}
			}
			header("location:pmn_principal_reportes.php?MostrarHornoProd=S&Hornada=".$Hornada."&DiaHP=".$Dia."&MesHP=".$Mes."&AnoHP=".$Ano."&Tab2=true&TabHorno2=true");
		case "GL": //GRABA LEY
			$Consulta = "select * from pmn_web.produccion_horno_trof ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and hornada = '".$Hornada."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE pmn_web.produccion_horno_trof set ";
				$Actualizar.= " observacion = '".$Obs."',";
				$Actualizar.= " gas_natural_ini = '".str_replace(",",".",$GasIni)."',";
				$Actualizar.= " gas_natural_fin = '".str_replace(",",".",$GasFin)."',";
				$Actualizar.= " operador = '".$Operador."',";
				$Actualizar.= " color = '".$Color."',";
				$Actualizar.= " num_anodos = '".str_replace(",",".",$NumAnodos)."',";
				$Actualizar.= " peso = '".$Peso."',";
				$Actualizar.= " inicio_fusion = '".$AnoCarga."-".$MesCarga."-".$DiaCarga." ".$HCarga.":".$MinCarga."',";
				$Actualizar.= " inicio_oxida = '".$AnoOxida."-".$MesOxida."-".$DiaOxida." ".$HOxida.":".$MinOxida."',";
				$Actualizar.= " inicio_moldeo = '".$AnoMol."-".$MesMol."-".$DiaMol." ".$HMol.":".$MinMol."',";
				$Actualizar.= " termino_moldeo = '".$AnoTMol."-".$MesTMol."-".$DiaTMol." ".$HTMol.":".$MinTMol."',";
				$Actualizar.= " HD_fusion = '".$HD_fusion."',";
				$Actualizar.= " HD_oxida = '".$HD_oxida."',";
				$Actualizar.= " HD_moldeo = '".$HD_moldeo."',";
				$Actualizar.= " HD_tmoldeo = '".$HD_tmoldeo."'";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and hornada = '".$Hornada."'";
				//echo $Actualizar;
				mysqli_query($link, $Actualizar);	
				
				//Movimientos_Pmn('','65','33','2',str_replace(",",".",$NumAnodos),str_replace(",",".",$Peso),$Hornada,'','4-2',$CookieRut,'M',$Color,'1');							
											
			}
			else
			{
				if ($Operador == "S")
					$Operador = "";
				if ($Color == "S")
					$Color = "";
				$Insertar = "INSERT INTO pmn_web.produccion_horno_trof";
				$Insertar.= "(rut,fecha,hornada,observacion, gas_natural_ini,";
				$Insertar.= "gas_natural_fin,operador,color,num_anodos,peso,inicio_fusion,inicio_oxida,inicio_moldeo,termino_moldeo,HD_fusion,HD_oxida,HD_moldeo,HD_tmoldeo)";
				$Insertar.= " values('".$CookieRut."','".$Fecha."','".$Hornada."','".$Obs."','".str_replace(",",".",$GasIni)."',";
				$Insertar.= " '".str_replace(",",".",$GasFin)."','".$Operador."','".$Color."','".str_replace(",",".",$NumAnodos)."','".$Peso."'";
				$Insertar.= " ,'".$AnoCarga."-".$MesCarga."-".$DiaCarga." ".$HCarga.":".$MinCarga."'";
				$Insertar.= " ,'".$AnoOxida."-".$MesOxida."-".$DiaOxida." ".$HOxida.":".$MinOxida."'";
				$Insertar.= " ,'".$AnoMol."-".$MesMol."-".$DiaMol." ".$HMol.":".$MinMol."'";
				$Insertar.= " ,'".$AnoTMol."-".$MesTMol."-".$DiaTMol." ".$HTMol.":".$MinTMol."'";
				$Insertar.= ",'".$HD_fusion."','".$HD_oxida."','".$HD_moldeo."','".$HD_tmoldeo."')";
				mysqli_query($link, $Insertar);		
				
				//Movimientos_Pmn('','65','33','2',str_replace(",",".",$NumAnodos),str_replace(",",".",$Peso),$Hornada,'','4-2',$CookieRut,'I',$Color,'1');							
						
			}
			$Muestra01=str_replace(".","",$Muestra01);
			$Muestra01=str_replace(",",".",$Muestra01);
			$Muestra02=str_replace(".","",$Muestra02);
			$Muestra02=str_replace(",",".",$Muestra02);
			$Muestra03=str_replace(".","",$Muestra03);
			$Muestra03=str_replace(",",".",$Muestra03);
			$Consulta = "select * from pmn_web.leyes_prod_horno_trof ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and hornada = '".$Hornada."'";
			$Consulta.= " and cod_leyes = '".$CmbLeyes."' ";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//if (((is_null($Muestra01)) || ($Muestra01==''))&& ((is_null($Muestra02)) || ($Muestra02==''))&&((is_null($Muestra03)) || ($Muestra03=='')))
				if (($Muestra01=="")&& ($Muestra02=="")&&($Muestra03==""))
				{
					//Nada
				}
				else
				{
					$Actualizar = "UPDATE pmn_web.leyes_prod_horno_trof set ";				
					if ($Muestra01!="")
					{
						$Actualizar.=" muestra01='".$Muestra01."', hora01='".$Hora01.":".$Minutos01.":00',";
					}
					if ($Muestra02!="")
					{
						$Actualizar.=" muestra02='".$Muestra02."',hora02='".$Hora02.":".$Minutos02.":00',";
					}
					if ($Muestra03!="")
					{
						$Actualizar.=" muestra03='".$Muestra03."',hora03='".$Hora03.":".$Minutos03.":00',";
					}
					$Actualizar = substr($Actualizar,0,strlen($Actualizar)-1);
					$Actualizar.$Actualizar;
					$Actualizar.= " where hornada = '".$Hornada."' ";
					$Actualizar.= " and fecha = '".$Fecha."'";
					$Actualizar.= " and cod_leyes = '".$CmbLeyes."' ";
					mysqli_query($link, $Actualizar);
					//echo $Actualizar."<br>";
				}
				header("location:pmn_principal_reportes.php?MostrarHornoProd=S&Hornada=".$Hornada."&DiaHP=".$Dia."&MesHP=".$Mes."&AnoHP=".$Ano."&Tab2=true&TabHorno2=true");				
			}
			else
			{
				if (($Muestra01=="")&& ($Muestra02=="")&&($Muestra03==""))
				{
					//echo "nada";
				}
				else
				{
					if (($Muestra01!="")&& ($Muestra02!="")&&($Muestra03!=""))
					{
						//echo "todos";
						$Insertar = "INSERT INTO pmn_web.leyes_prod_horno_trof";
						$Insertar.= "(rut,hornada,fecha,cod_leyes,muestra01,muestra02,muestra03,hora01,hora02,hora03)";
						$Insertar.= " values('".$CookieRut."','".$Hornada."','".$Fecha."','".$CmbLeyes."','".$Muestra01."','".$Muestra02."','".$Muestra03."',";
						$Insertar.= " '".$Hora01.":".$Minutos01.":00','".$Hora02.":".$Minutos02.":00','".$Hora03.":".$Minutos03.":00')";
						//echo $Insertar."<br>"; 
						mysqli_query($link, $Insertar);
					}
					else
					{
						if ($Muestra01!="")
						{
							$Insertar = "INSERT INTO pmn_web.leyes_prod_horno_trof";
							$Insertar.= "(rut,hornada,fecha,cod_leyes,muestra01,hora01)";
							$Insertar.= " values('".$CookieRut."','".$Hornada."','".$Fecha."','".$CmbLeyes."','".$Muestra01."',";
							$Insertar.= " '".$Hora01.":".$Minutos01.":00')";
							//echo $Insertar."<br>"; 
							mysqli_query($link, $Insertar);
						}
						if ($Muestra02!="")
						{
							$Insertar = "INSERT INTO pmn_web.leyes_prod_horno_trof";
							$Insertar.= "(rut,hornada,fecha,cod_leyes,muestra02,hora02)";
							$Insertar.= " values('".$CookieRut."','".$Hornada."','".$Fecha."','".$CmbLeyes."','".$Muestra02."',";
							$Insertar.= " '".$Hora02.":".$Minutos02.":00')";
							//echo $Insertar."<br>"; 
							mysqli_query($link, $Insertar);
						}
						if ($Muestra03!="")
						{
							$Insertar = "INSERT INTO pmn_web.leyes_prod_horno_trof";
							$Insertar.= "(rut,hornada,fecha,cod_leyes,muestra03,hora03)";
							$Insertar.= " values('".$CookieRut."','".$Hornada."','".$Fecha."','".$CmbLeyes."','".$Muestra03."',";
							$Insertar.= " '".$Hora03.":".$Minutos03.":00')";
							//echo $Insertar."<br>"; 
							mysqli_query($link, $Insertar);
						}
					}
				}
				header("location:pmn_principal_reportes.php?MostrarHornoProd=S&Hornada=".$Hornada."&DiaHP=".$Dia."&MesHP=".$Mes."&AnoHP=".$Ano."&Tab2=true&TabHorno2=true");				
			}
			break;
		case "EL":
			if (count($ChkLey)>0)
			{
				while (list($i,$p) = each($ChkLey))
				{
					//ELIMINO DETALLE
					$Eliminar = "delete from pmn_web.leyes_prod_horno_trof ";
					$Eliminar.= " where fecha = '".$Fecha."'";
					$Eliminar.= " and hornada = '".$Hornada."'";
					$Eliminar.= " and cod_leyes = '".$p."'";
					mysqli_query($link, $Eliminar);				
				}
			}
			header("location:pmn_principal_reportes.php?MostrarHornoProd=S&Hornada=".$Hornada."&DiaHP=".$Dia."&MesHP=".$Mes."&AnoHP=".$Ano."&Tab2=true&TabHorno2=true");
	}
?>