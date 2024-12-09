<?php 
	include("../principal/conectar_principal.php");
	$FechaCreacion = "";
	$Emisor = "";
	$Error00 = "";
	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Mes      = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Lote     = isset($_REQUEST["Lote"])?$_REQUEST["Lote"]:"";
	$Corr     = isset($_REQUEST["Corr"])?$_REQUEST["Corr"]:"";
	$NumPaquetes = isset($_REQUEST["NumPaquetes"])?$_REQUEST["NumPaquetes"]:"";
	$PesoLote = isset($_REQUEST["PesoLote"])?$_REQUEST["PesoLote"]:"";
	$Idioma   = isset($_REQUEST["Idioma"])?$_REQUEST["Idioma"]:"";
	$Virtual   = isset($_REQUEST["Virtual"])?$_REQUEST["Virtual"]:"";
	$Reescribir = isset($_REQUEST["Reescribir"])?$_REQUEST["Reescribir"]:"";

	if ($Proceso != "P")
	{		
		if ($Reescribir == "S") // REESCRIBE EL CERTIFICADO EN CERTIFICION CATODO
		{
			$Consulta = "select * from sec_web.lote_catodo where cod_bulto = '".$Mes."' and num_bulto = '".$Lote."' and corr_enm='".$Corr."'";

			$Respuesta = mysqli_query($link,$Consulta);				
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				//VERSION DEL CERTIFICADO
				$Consulta2 = "select ifnull(max(version),0) as version from sec_web.certificacion_catodos ";
				$Consulta2.= " where corr_enm = '".$Corr."'";
				$Respuesta2 = mysqli_query($link,$Consulta2);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{									
					$Version = $Fila2["version"];
				}
				//-----------------------
				$Consulta = "select * from sec_web.certificacion_catodos ";
				$Consulta.= " where corr_enm = '".$Corr."'";
				$Consulta.= " and version = '".$Version."'";
				$Respuesta2 = mysqli_query($link,$Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$Emisor = $Fila2["rut"];
					$FechaCreacion = $Fila2["fecha"];
					$NumCertificado = $Fila2["num_certificado"];
				}
			}			
		}
		else
		{					
		
			$Consulta = "select * from sec_web.lote_catodo where cod_bulto = '".$Mes."' and num_bulto = '".$Lote."' and corr_enm='".$Corr."'";
			$Respuesta = mysqli_query($link,$Consulta);		
							
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$CorrENM = $Corr;
				$Consulta = "select * from sec_web.certificacion_catodos where corr_enm = '".$CorrENM."'";
				$Respuesta2 = mysqli_query($link,$Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$Error00 = "E"; //YA EXISTE
				}		
			}
			else
			{
				$CorrENM = "";
				$Error00 = "B"; //NO TIENE INSTRUCCION
			}		
		}
		if ($Error00 == "")
		{
			if (!isset($NumCertificado))
			{
				$Consulta = "select * from sec_web.lote_catodo where cod_bulto = '".$Mes."' and num_bulto = '".$Lote."' and corr_enm='".$Corr."'";
				$Respuesta = mysqli_query($link,$Consulta);
				
				if ($Fila = mysqli_fetch_array($Respuesta))
				{
					$Consulta = "select (ifnull(max(num_certificado),0) + 1) as numero from sec_web.certificacion_catodos ";
					$Respuesta = mysqli_query($link,$Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))
					{
						$NumCertificado = $Fila["numero"];				
					}
				}
			}
		}
		else
		{
			header("location:sec_con_certificado02.php?Error=".$Error00."&CorrENM=".$CorrENM."&Idioma=".$Idioma);
			exit;
		}
	}
	$Consulta = "select * from sec_web.lote_catodo where cod_bulto = '".$Mes."' and num_bulto = '".$Lote."' and corr_enm='".$Corr."'";
	
	$Respuesta = mysqli_query($link,$Consulta);
	$EnmCode = "";
	
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Consulta2 = "select * from sec_web.programa_enami where corr_enm = '".$Corr."'";
		$Respuesta2 = mysqli_query($link,$Consulta2);
			
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$EnmCode = "E";
		}
		else
		{
			$Consulta2 = "select * from sec_web.programa_codelco where corr_codelco = '".$Corr."'";
			$Respuesta2 = mysqli_query($link,$Consulta2);
			
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				if ($Fila2["cod_contrato_maquila"]=="MAQ ENM")
				{
					$EnmCode ="E";
				}
				else
				{	
					$EnmCode = "C";
				}	
			}
						
		}		 		 
	}
	
	$CodMarcaAux  = $Fila["cod_marca"];	

	//RESCATA PRODUCTO y SUBPRODUCTO
	$Consulta = "select distinct t2.cod_producto, t2.cod_subproducto ";
	$Consulta.= " from sec_web.lote_catodo t1	inner join";
	$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
	$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
	$Consulta.= " and t1.num_bulto = '".$Lote."' and t1.corr_enm='".$Corr."'";
	$Consulta.= " order by t2.cod_producto, t2.cod_subproducto";

	$Respuesta = mysqli_query($link,$Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$CodProducto = $Fila["cod_producto"];
		$CodSubProducto = $Fila["cod_subproducto"];
	}	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action = "sec_con_certificado.php";
			f.submit();
			break;
		case "I":  
			f.BtnImprimir.style.visibility = 'hidden';
			window.print();
			break;
		case "S":
			f.action = "sec_con_certificado00.php";
			f.submit();
			break;
	}
}
</script>
</head>

<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php
	$ArrGrupo = array();
	$ArrProd = array();
	$Error = "";
	if (isset($Lote))
	{
		$Eliminar = "delete from sec_web.tmp_leyes_grupos";
		mysqli_query($link,$Eliminar);
		if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
		{
			//PARA DESCOBRIZADOS
			//TABLA PAQUETE_CATODO
			$Consulta = "select distinct ifnull(t1.grupo,'00') as cod_grupo, t1.fecha_produccion, peso_produccion ";
			$Consulta.= " from sec_web.catodos_desc_normal t1";
			$Consulta.= " where t1.cod_bulto = '".$Mes."'";
			$Consulta.= " and t1.num_bulto = '".$Lote."'";
			$Consulta.= " order by t1.fecha_produccion, t1.grupo ";
			$Respuesta = mysqli_query($link,$Consulta);
			//echo $Consulta."<br>";
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
			

			
				//aqui ver funtion para F-20000
				//if($CodSubProducto != "44") //aqui saca 44 18-12-2006
				if($CodSubProducto != "44") //aqui saca 44 18-12-2006

				
				{
					$Consulta = "select * from sec_web.produccion_catodo ";
					$Consulta.= " where cod_grupo = '".$Fila["cod_grupo"]."'";
					$Consulta.= " and fecha_produccion = '".$Fila["fecha_produccion"]."'";
					$Consulta.= " and cod_muestra <> 'S' "; 
					$Consulta.= " and cod_producto = '18' "; 
					$Consulta.= " and cod_subproducto in (3,42,43,44) "; 
					$Consulta.= " order by fecha_produccion, cod_grupo, cod_cuba ";
					$Respuesta2 = mysqli_query($link,$Consulta);
					//echo $Consulta."<br>";
					while ($Fila2 = mysqli_fetch_array($Respuesta2))
					{					
						$Consulta = " SELECT t2.nro_solicitud,t2.cod_leyes, t2.valor, t2.signo, t2.cod_unidad, t1.estado_actual from cal_web.solicitud_analisis as t1";
						$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2"; 
						$Consulta.= " ON t1.nro_solicitud = t2.nro_solicitud ";
						$Consulta.= " AND t1.fecha_hora = t2.fecha_hora ";
						$Consulta.= " AND t1.rut_funcionario = t2.rut_funcionario ";
						$Consulta.= " AND t1.id_muestra = t2.id_muestra ";
						$Consulta.= " AND t1.recargo = t2.recargo ";
						$Consulta.= " AND left(t2.id_muestra,5) like '%".intval($Fila2["cod_grupo"])."%'";
						$Consulta.= " WHERE t1.cod_producto = 18 AND left(t1.fecha_muestra,10) = '".$Fila2["fecha_produccion"]."'";
						$Consulta.= " AND left(t1.id_muestra,5) like '%".intval($Fila2["cod_grupo"])."%' AND right(t1.id_muestra,2) like '%".intval($Fila2["cod_cuba"])."%'";
						$Consulta.= " AND t2.valor != '' "; //AND t2.cod_leyes != 48";
						$Consulta.= " AND t1.cod_periodo='1' ";
						$Consulta.= " AND t1.tipo='1' ";
						$Consulta.= " AND t1.cod_analisis='1' ";
						$Consulta.= " AND t1.estado_actual <> '7'";	
						$Respuesta3 = mysqli_query($link,$Consulta);
						//echo $Consulta."<br>";								
						while($Fila3 = mysqli_fetch_array($Respuesta3))
						{						
							$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, ";
							$Insertar.= " fecha_creacion_paquete, nro_solicitud, cod_cuba, peso_produccion) ";
							$Insertar.= " values('".$Fila["cod_grupo"]."','".$Fila["fecha_produccion"]."','".$Fila3["cod_leyes"]."','".$Fila3["valor"]."', ";
							$Insertar.= " '".$Fila3["signo"]."', '".$Fila["fecha_produccion"]."', '".$Fila3["nro_solicitud"]."', '".$Fila2["cod_cuba"]."', '".$Fila["peso_produccion"]."')";
							mysqli_query($link,$Insertar);
						}
					
					
					}
				}	
				else
				{
						$Consulta = " SELECT t2.nro_solicitud,t2.cod_leyes, t2.valor, t2.signo, t2.cod_unidad, t1.estado_actual from cal_web.solicitud_analisis as t1";
						$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2"; 
						$Consulta.= " ON t1.nro_solicitud = t2.nro_solicitud ";
						$Consulta.= " AND t1.fecha_hora = t2.fecha_hora ";
						$Consulta.= " AND t1.rut_funcionario = t2.rut_funcionario ";
						$Consulta.= " AND t1.id_muestra = t2.id_muestra ";
						$Consulta.= " AND t1.recargo = t2.recargo ";
						if ($Mes=='E' && $Lote==20440)
						{
							$Consulta.= " AND t2.id_muestra = '".$Fila["cod_grupo"]."'";
						}
						else
						{
							$Consulta.= " AND left(t2.id_muestra,5) like '%".intval($Fila["cod_grupo"])."%'";
						}
						$Consulta.= " WHERE t1.cod_producto = 18 AND left(t1.fecha_muestra,10) = '".$Fila["fecha_produccion"]."'";
							if ($Mes=='E' && $Lote==20440)
							{
								$Consulta.= " AND t1.id_muestra = '".$Fila["cod_grupo"]."'";
							}
							else
							{
								$Consulta.= " AND left(t1.id_muestra,5) like '%".intval($Fila["cod_grupo"])."%'";
							}	

						
						/*$Consulta.= " AND left(t2.id_muestra,5) like '%".intval($Fila["cod_grupo"])."%'";
						$Consulta.= " WHERE t1.cod_producto = 18 AND left(t1.fecha_muestra,10) = '".$Fila["fecha_produccion"]."'";
						$Consulta.= " AND left(t1.id_muestra,5) like '%".intval($Fila["cod_grupo"])."%'";*/
						$Consulta.= " AND t2.valor != '' "; //AND t2.cod_leyes != 48";
						$Consulta.= " AND t1.cod_periodo='1' ";
						$Consulta.= " AND t1.tipo='1' ";
						$Consulta.= " AND t1.cod_analisis='1' ";
						$Consulta.= " AND t1.estado_actual <> '7'";	
						$Respuesta3 = mysqli_query($link,$Consulta);
						//echo $Consulta."<br>";								
						while($Fila3 = mysqli_fetch_array($Respuesta3))
						{						
							$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, ";
							$Insertar.= " fecha_creacion_paquete, nro_solicitud, peso_produccion) ";
							$Insertar.= " values('".$Fila["cod_grupo"]."','".$Fila["fecha_produccion"]."','".$Fila3["cod_leyes"]."','".$Fila3["valor"]."', ";
							$Insertar.= " '".$Fila3["signo"]."', '".$Fila["fecha_produccion"]."', '".$Fila3["nro_solicitud"]."','".$Fila["peso_produccion"]."')";
							mysqli_query($link,$Insertar);
						}

				}									
			}
			
		}
		else
		{			
			//TABLA PAQUETE_CATODO
			$Consulta = "select distinct ifnull(t2.cod_grupo,'00') as cod_grupo, t2.fecha_creacion_paquete,t2.cod_subproducto";
			$Consulta.= " from sec_web.lote_catodo t1	inner join";
			$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
			$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
			$Consulta.= " and t1.num_bulto = '".$Lote."' and t1.corr_enm='".$Corr."'";
			//$Consulta.= " and t2.cod_grupo <> 0";
			
			$Consulta.= " order by t2.cod_grupo";
			//echo $Consulta."<br>";		
			$Respuesta = mysqli_query($link,$Consulta);
			$i = 0;
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				//2004-08-24 se agrega la condicion if cod_subproducto != para que no tome descobrizado//
				if ($CodProducto == "18" && ($CodSubProducto != "3" && $CodSubProducto != "42" && $CodSubProducto != "43" && $CodSubProducto !="44"))  
				{
					
					$subproducto_prod = 1;
					
					$Consulta = "select max(fecha_produccion) as fecha_produccion";
					$Consulta.= " from sec_web.produccion_catodo ";
					$Consulta.= " where cod_grupo = '".$Fila["cod_grupo"]."' and cod_subproducto = '".$subproducto_prod."'";
					$Consulta.= " and fecha_produccion <= '".$Fila["fecha_creacion_paquete"]."'";
					$Respuesta2 = mysqli_query($link,$Consulta);
					// echo $Consulta."<br>";	
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$ArrProd[$i][0] = $Fila["cod_grupo"];
						if (($Fila2["fecha_produccion"] == "") || is_null($Fila2["fecha_produccion"]))
							$ArrProd[$i][1] = $Fila["fecha_creacion_paquete"];
						else
							$ArrProd[$i][1] = $Fila2["fecha_produccion"];
							$ArrProd[$i][2] = $Fila["fecha_creacion_paquete"];
						$i++;
					}
				}
			}		
			reset($ArrProd);		
			$SeriePaquetes = "";
			$CodPaqueteAnt = "";
			$NumPaqueteAnt = 0;
			foreach($ArrProd as $k => $v)
			{	
				if (($v[0] == "00") || ($v[0] == "0") || ($v[0] == ""))
				{
					//CONSULTA LOTE EXTERNO
					$Consulta = "SELECT distinct t2.lote_origen ";
					$Consulta.= "FROM sec_web.lote_catodo t1 inner join sec_web.paquete_catodo_externo t2 ";
					$Consulta.= "on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
					$Consulta.= " WHERE t1.cod_bulto = '".$Mes."'  ";
					$Consulta.= " and t1.num_bulto = '".$Lote."'  and t1.corr_enm='".$Corr."'";
					$Consulta.= " order by t2.cod_paquete, t2.num_paquete, t2.lote_origen ";
					//echo $Consulta."<br>";
					$Respuesta = mysqli_query($link,$Consulta);
					$j = 0;
					$ArrProd = array();
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						$ArrProd[$j][0] = $Fila["lote_origen"];
						$ArrProd[$j][1] = "";
						$ArrProd[$j][2] = $v[2];
						$j++;			
						//---------------------
						$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
						$Consulta.= " t2.signo, t1.nro_solicitud ";
						$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
						$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
						$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
						$Consulta.= " where ((t1.tipo = 1 and t1.id_muestra = '".$Fila["lote_origen"]."') ";
						$Consulta.= " or (tipo = '2' and t1.id_muestra = '".$Fila["lote_origen"]."-R')) ";				
						$Consulta.= " and t1.estado_actual = '6' ";
						$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
						$Consulta.= " and t1.cod_producto = '18'";
						$Consulta.= "order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
						//echo $Consulta."<br>";
						$Respuesta2 = mysqli_query($link,$Consulta);
						$Encontro = false;
						while ($Fila2 = mysqli_fetch_array($Respuesta2))
						{
							$Encontro = true;
							$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
							$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
							$Respuesta3 = mysqli_query($link,$Consulta);				
							if ($Fila3 = mysqli_fetch_array($Respuesta3))
							{
								$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, ";
								$Insertar.= " fecha_creacion_paquete, nro_solicitud) ";
								$Insertar.= " values('".$Fila["lote_origen"]."', '".$v[1]."',";
								$Insertar.= " '".$Fila2["cod_leyes"]."','".$Fila2["valor"]."','".$Fila2["signo"]."', '".$v[2]."',";
								$Insertar.= " '".$Fila2["nro_solicitud"]."')";
								mysqli_query($link,$Insertar);			
							}
						}
					}
					break;
				}
				else
				{	
					//-------------------------LEYES DE CALIDAD-----------------------------
					$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
					$Consulta.= " t2.signo ";
					$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
					$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
					$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
					$Consulta.= " where ((t1.tipo = 1 and (t1.id_muestra = '".$v[0]."' or t1.id_muestra = '".intval($v[0])."')) ";
					$Consulta.= " or (tipo = '2' and (t1.id_muestra = '".$v[0]."-R' or t1.id_muestra = '".intval($v[0])."-R'))) ";
					if ($v[0] >= 50)
					{
						//CUANDO SON VIRTUALES TRABAJO CON LA FECHA CREACION PAQUETE				
						/*$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($v[2],5,2),substr($v[2],8,2),substr($v[2],0,4)));
						//ingreso algo para validar rango de fecha mas grande
						$dia_2 = substr ($Fecha1,8,2);
						$mes_2 = substr ($Fecha1,5,2);
					    $ano_2 = substr($Fecha1,0,4);
						switch($mes_2) 
							{
								case 01: $dia = 31; break;  	
								case 02: $dia = 28; break; 
								case 03: $dia = 31; break; 
								case 04: $dia = 30; break; 
								case 05: $dia = 31; break; 
								case 06: $dia = 30; break; 
								case 07: $dia = 31; break; 
								case 08: $dia = 31; break; 
								case 09: $dia = 30; break; 
								case 10: $dia = 31; break; 
								case 11: $dia = 30; break; 
								case 12: $dia = 31; break; 
							}
						$diap = $dia_2 + 15;
						if ($diap > $dia)	
							{
								$dia_2 = $diap - $dia;
								$mes_2 = $mes_2 + 1;
								if ($mes_2 == 13)
								{
									$ano_2 = $ano_2 + 1;
									$mes_2 = 1;
								} 
								$largodia = strlen($dia_2);
								$largomes = strlen($mes_2);
								if ($largodia == 1)
									{
										$dia_2 = "0$dia_2";
									}
								if ($largomes == 1) 
									{
										$mes_2 = "0$mes_2";
									}	
								$Fecha_pj = "$ano_2-$mes_2-$dia_2 23:59:59";
								$Consulta.= " and t1.fecha_muestra between '".substr($Fecha1,0,7)."-01 00:00:00' and '".$Fecha_pj."'";
							}
						else
							{            
							$Consulta.= " and t1.fecha_muestra between '".substr($Fecha1,0,7)."-01 00:00:00' and '".substr($Fecha1,0,7)."-31 23:59:59'";
							}*/
						$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($v[2],5,2),substr($v[2],8,2)-15,substr($v[2],0,4)));
						$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($Fecha1,5,2),substr($Fecha1,8,2) + 15,substr($Fecha1,0,4)));
						if ((intval(substr($Fecha1,5,2)) == intval(substr($Fecha2,5,2))) && (intval(substr($Fecha2,8,2)) < 31))
							$Fecha2 = substr($Fecha1,0,7)."-31";
						$Consulta.= " and t1.fecha_muestra between '".substr($Fecha1,0,7)."-01 00:00:00' and '".$Fecha2." 23:59:59'";
					}
					else
 					{
						$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($v[1],5,2),(substr($v[1],8,2)-4),substr($v[1],0,4)));
						$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($v[1],5,2),(substr($v[1],8,2)+3),substr($v[1],0,4)));
	
						$Consulta.= " and t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";
					}
					$Consulta.= " and t1.estado_actual = '6' ";
					$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
					$Consulta.= " and t1.cod_producto = '18'";
					$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
					//echo "con".$Consulta;
					$Respuesta2 = mysqli_query($link,$Consulta);
					$Encontro = false;
					while ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$Encontro = true;
						$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
						$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
						$Respuesta3 = mysqli_query($link,$Consulta);				
						if ($Fila3 = mysqli_fetch_array($Respuesta3))
						{
							$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete) ";
							$Insertar.= " values('".$v[0]."',";
							if ($v[0] >= 50)
								$Insertar.= "'".$v[2]."',";
							else
								$Insertar.= "'".$v[1]."',";
							$Insertar.= "'".$Fila2["cod_leyes"]."','".$Fila2["valor"]."','".$Fila2["signo"]."', '".$v[2]."')";
							mysqli_query($link,$Insertar);				
						}
					}
					if (($v[0] >= 50) && ($Encontro == false))
					{
						$Consulta = "select max(t1.fecha_muestra) as fecha_muestra";
						$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
						$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
						$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
						$Consulta.= " where ((t1.tipo = 1 and (t1.id_muestra = '".$v[0]."' or t1.id_muestra = '".intval($v[0])."')) ";
						$Consulta.= " or (tipo = '2' and (t1.id_muestra = '".$v[0]."-R' or t1.id_muestra = '".intval($v[0])."-R'))) ";				
						$Consulta.= " and t1.estado_actual = '6' ";
						$Consulta.= " and t1.fecha_muestra < '".substr($Fecha1,0,7)."-01 00:00:00' ";
						$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
						$Consulta.= " and t1.cod_producto = '18'";
						
						$Respuesta3 = mysqli_query($link,$Consulta);
						while ($Fila3 = mysqli_fetch_array($Respuesta3))
						{
							$Consulta = "select max(t1.fecha_muestra) ";
							$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
							$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
							$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
							$Consulta.= " where ((t1.tipo = 1 and (t1.id_muestra = '".$v[0]."' or t1.id_muestra = '".intval($v[0])."')) ";
							$Consulta.= " or (tipo = '2' and (t1.id_muestra = '".$v[0]."-R' or t1.id_muestra = '".intval($v[0])."-R'))) ";				
							$Consulta.= " and t1.estado_actual = '6' ";
							$Consulta.= " and t1.fecha_muestra < '".$Fila["fecha_muestra"]."' "; //FECHA MAXIMA ENCONTRADA (DESDE LA FECHA QUE NO ENCONTRO)
							$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
							$Consulta.= " and t1.cod_producto = '18'";
							$Consulta.= " order by t2.cod_leyes";
							
							$Respuesta4 = mysqli_query($link,$Consulta);
							while ($Fila4 = mysqli_fetch_array($Respuesta4))
							{
								$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
								$Consulta.= " and nombre_subclase = '".$Fila4["cod_leyes"]."'";
								$Respuesta5 = mysqli_query($link,$Consulta);				
								if ($Fila5 = mysqli_fetch_array($Respuesta5))
								{
									$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete) ";
									$Insertar.= " values('".$v[0]."','".$v[2]."','".$Fila4["cod_leyes"]."','".$Fila4["valor"]."','".$Fila4["signo"]."', '".$v[2]."')";
									mysqli_query($link,$Insertar);				
								}
							}
						}
					}
				}
			}//END WHILE			
		}//END IF
	}//END IF
	
	reset($ArrProd);
	foreach($ArrProd as $k => $v)
	{				
		$Encontro = false;		
		$Consulta2 = "select * from sec_web.tmp_leyes_grupos ";
		$Consulta2.= " where cod_grupo = '".$v[0]."' ";
		$Consulta.= " and fecha = '".$v[1]."'";
		//echo $Consulta2."<br>";
		$Respuesta2 = mysqli_query($link,$Consulta2);
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$Encontro = true;			
		}		
		if ($Encontro == false)
		{
			$Encontro = false;
			$Consulta2 = "select * from sec_web.tmp_leyes_grupos ";
			$Consulta2.= " where cod_grupo = '".$v[0]."'";
			$Respuesta2 = mysqli_query($link,$Consulta2);
			while ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				$Encontro = true;
				$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete) ";
				$Insertar.= " values('".$v[0]."','".$v[1]."','".$Fila2["cod_leyes"]."','".$Fila2["valor"]."','".$Fila2["signo"]."', '".$v[2]."')";
				mysqli_query($link,$Insertar);
			}
			if ($Encontro == false)
			{
				if (($v[0] == "00") || ($v[0] == "0") || ($v[0] == ""))
				{
					$Error = $Error."<font color='RED'>ERROR...NO SE ENCUENTRAN LAS LEYES DEL LOTE: ".$v[0];
					$Error.= " PARA LOS PAQUETES CREADOS EN LA FECHA:".$v[2]."</font>";
				}
				else
				{							
					$Error = $Error."<font color='RED'>ERROR...NO SE ENCUENTRAN LAS LEYES DEL GRUPO: ".$v[0];
					$Error.= " PARA LOS PAQUETES CREADOS EN LA FECHA:".$v[2]."<br>PRODUCIDOS EN LA FECHA: ".$v[1]."</font>";
				}
				if ($Proceso != "P")
				{
					echo "<script languaje='JavaScript'>\n";
					echo "document.frmPrincipal.action = 'sec_con_certificado02.php?Error=G';";
					echo "document.frmPrincipal.submit();";
					echo "</script>\n";
					exit;
				}
			}
		}
	}		
	//---------------------------------------------------------------------------------------------------
	//CONSULTA SI YA FUE CREADO Y ANULADO
	$Consulta = "select * from sec_web.solicitud_certificado ";
	$Consulta.= " where cod_bulto = '".$Mes."' and num_bulto = '".$Lote."' and corr_enm='".$Corr."'";
	$Respuesta = mysqli_query($link,$Consulta);
	$Anulado="N";
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Fila["estado_certificado"] == "A")
		{
			if ($Proceso != "P")
			{
				echo "<script languaje='JavaScript'>\n";
				echo "document.frmPrincipal.action = 'sec_con_certificado02.php?Error=A';";
				echo "document.frmPrincipal.submit();";
				echo "</script>\n";
				exit;
			}
			else
			{
				$Anulado = "S";
			}
		}
	}
	//--------------------------------------------
	if ($Lote!="")
	{
		//TABLA EMBARQUE_VENTANA
		$Consulta = "select * from sec_web.embarque_ventana where cod_bulto = '".$Mes."' and num_bulto = '".$Lote."' and corr_enm='".$Corr."'";
		//echo "SSSS".$Consulta;
		
		$Respuesta = mysqli_query($link,$Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{	
			/*if (strtoupper($Fila["tipo_enm_code"]) == "E") 
			{
				$Consulta2 = "select * from sec_web.programa_enami where corr_enm = '".$Corr."'";
				$Respuesta2 = mysqli_query($link,$Consulta2);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
					$CodCliente = $Fila2["cod_cliente"];
				else
					$CodCliente = "";
			}
			else
			{
				$Consulta2 = "select * from sec_web.programa_codelco where corr_codelco = '".$Corr."'";
				$Respuesta2 = mysqli_query($link,$Consulta2);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
					$CodCliente = $Fila2["cod_cliente"];
				else
					$CodCliente = "";			
			}*/
			$Consulta2 = "select * from sec_web.programa_enami where corr_enm = '".$Corr."'";
			$Respuesta2 = mysqli_query($link,$Consulta2);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				$CodCliente = $Fila2["cod_cliente"];
			}
			else
			{
				$Consulta2 = "select * from sec_web.programa_codelco where corr_codelco = '".$Corr."'";
				$Respuesta2 = mysqli_query($link,$Consulta2);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
					$CodCliente = $Fila2["cod_cliente"];
				else
					$CodCliente = "";		
			}
			$NumPaquetes = $Fila["bulto_paquetes"];
			$PesoLote = $Fila["bulto_peso"];				
			$FechaDisp = $Fila["fecha_envio"];			
			$NumEnvio = $Corr;
				
			if ($Fila["cod_marca"]== '')
			{
				$MarcaCatodo =$CodMarcaAux;
			}
			else
			{	
				$MarcaCatodo = $Fila["cod_marca"];					
			}	
			$TipoEmbarque = $Fila["tipo_embarque"];
		}
		//CONSULTA SI TIENE CLIENTE POR CANJE
			if ($Fila["cod_marca"]== '')
			{
				$MarcaCatodo =$CodMarcaAux;
			}
			else
			{	
				$MarcaCatodo = $Fila["cod_marca"];					
			}	

		
		$Consulta = "select * from sec_web.solicitud_certificado ";
		$Consulta.= " where cod_bulto = '".$Mes."' and num_bulto='".$Lote."' and corr_enm = '".$Corr."'";
		$Respuesta = mysqli_query($link,$Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["cod_cliente2"] != "")
				$CodCliente = $Fila["cod_cliente2"];
		}
		//FIN CLIENTE POR CANJE
		//MARCA CATODO
		$Consulta = "select * from sec_web.marca_catodos where cod_marca = '".$MarcaCatodo."'";
		$Respuesta = mysqli_query($link,$Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Idioma == "E")
				$MarcaCatodo = $Fila["descripcion"];
			else
				$MarcaCatodo = $Fila["descripcion_ingles"];
		}
		//TABLA PAQUETE_CATODO
		$Consulta = "SHOW TABLES FROM `sec_web`";
		$Respuesta = mysqli_query($link,$Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["Tables_in_sec_web"] == "tmp_leyes_catodos")
			{
				$Eliminar = "DROP TABLE `sec_web`.`tmp_leyes_catodos`";
				mysqli_query($link,$Eliminar);
			}
		}
		//VERIFICA SI ES GRUPO 00 o NO O SI ES CAT. DESC. NORMAL
		if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
		{	
			$Consulta = "create table `sec_web`.`tmp_leyes_catodos`  (key ind01(cod_paquete,num_paquete)) as ";
			$Consulta.= " select t1.cod_grupo as cod_paquete, t1.fecha as num_paquete, t1.peso_produccion as peso_paquete, ";
			$Consulta.= " t1.cod_leyes, t1.valor, t1.signo ";
			$Consulta.= " from sec_web.tmp_leyes_grupos t1 ";
			mysqli_query($link,$Consulta);
		}
		else
		{
			$Consulta = "select distinct ifnull(t2.cod_grupo,'00') as cod_grupo ";
			$Consulta.= " from sec_web.lote_catodo t1	inner join";
			$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
			$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
			$Consulta.= " and t1.num_bulto = '".$Lote."' and t1.corr_enm='".$Corr."'";
			$Consulta.= " order by t2.cod_grupo";
			$Respuesta = mysqli_query($link,$Consulta);
			$Grupo = 0;
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Grupo = $Fila["cod_grupo"];
			}
			if (($Grupo == "00") || ($Grupo == "0") || ($Grupo == ""))
			{
				$Consulta = "create table `sec_web`.`tmp_leyes_catodos`  (key ind01(cod_paquete,num_paquete)) as ";
				$Consulta.= " select t1.cod_paquete, t1.num_paquete, t2.peso_paquete as peso_paquete, ";
				$Consulta.= " t3.cod_leyes, t3.valor, t2.cod_grupo, t3.signo ";
				$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo_externo t2  ";
				$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete  ";
				$Consulta.= " inner join sec_web.tmp_leyes_grupos t3 on t2.lote_origen = t3.cod_grupo ";
				//$Consulta.= " and t2.fecha_creacion_paquete = t3.fecha_creacion_paquete ";
				$Consulta.= " where t1.cod_bulto = '".$Mes."' and t1.num_bulto = '".$Lote."' and t1.corr_enm='".$Corr."'";
				$Consulta.= " order by t1.cod_paquete, t1.num_paquete, t3.cod_leyes ";
				mysqli_query($link,$Consulta);
			}
			else
			{		
				$Consulta = "create table `sec_web`.`tmp_leyes_catodos`  (key ind01(cod_paquete,num_paquete)) as ";
				$Consulta.= " select t1.cod_paquete, t1.num_paquete, t2.peso_paquetes as peso_paquete, ";
				$Consulta.= " t3.cod_leyes, t3.valor, t2.cod_grupo, t3.signo ";
				$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2  ";
				$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete  ";
				$Consulta.= " inner join sec_web.tmp_leyes_grupos t3 on t2.cod_grupo = t3.cod_grupo ";
				$Consulta.= " and t2.fecha_creacion_paquete = t3.fecha_creacion_paquete ";
				$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."' and t1.num_bulto = '".$Lote."' and t1.corr_enm='".$Corr."'";
				$Consulta.= " order by t1.cod_paquete, t1.num_paquete, t3.cod_leyes ";
				mysqli_query($link,$Consulta);
			}
		}			
	}
?>
        
  <table width="600" height="476" border="0" align="center">
    <tr> 
      <td width="29%" height="42" align="center"> 
        <?php
	  	if ($Idioma!="") 
		{
	  		if ($Idioma == "E")
				echo "DEPTO. CONTROL CALIDAD<br>LABORATORIO ANALITICO";				
			else
				echo "QUALITY CONTROL DEPARTMENT<br>ANALYTICAL LABORATORY";
		}
		else
		{
			echo "DEPTO. CONTROL CALIDAD<br>LABORATORIO ANALITICO";
		}			
		?>
      </td>
      <td width="52%" align="center"><img src="../principal/imagenes/letras_codelco_2.jpg" width="170" height="50"></td>
      <td width="19%" align="center"><strong> 
        <?php		
		if ($Anulado == "S")
		{
			echo "CERTIFICADO<br>ANULADO";
		}
		else
		{
			if ($Proceso != "P")
			{
				echo "N&deg;&nbsp;";
				printf("%06d",$NumCertificado); 	  
			}
			else
			{
				echo "VISTA PREVIA<br>COPIA NO VALIDA";
			}
		}
	  ?>
        </strong></td>
    </tr>
    <tr> 
      <td height="20" colspan="3" align="center"><font style="font-size=12px"><?php echo $Error; ?></font></td>	  
    </tr>
    <tr> 
      <td height="20" colspan="3" align="center"><strong><font style="font-size=12px"><strong> 
        <font style="font-size=12px"><strong> 
        <?php 			
				if ($Idioma!="")
				{
					if ($Idioma == "I")					
						echo "CUSTOMER:&nbsp;&nbsp;";
					else
						echo "<font style='font-size=14px'>EMBARQUE DE PRODUCTOS VENTANAS</font>";		
				}
				else
				{
					echo "<font style='font-size=14px'>EMBARQUE DE PRODUCTOS VENTANAS</font>";	
				}
	  ?>
        </strong></font>&nbsp;&nbsp;&nbsp; 
        <font style="font-size=12px"><strong>
        <?php
			if ($Idioma == "I")
			{
				$Consulta = "select  * from sec_web.cliente_venta where cod_cliente = '".$CodCliente."'";
				//echo $Consulta;
				$Respuesta = mysqli_query($link,$Consulta);
				if ($Fila = mysqli_fetch_array($Respuesta))
				{
					echo $Fila["sigla_cliente"];
				}
				else
				{
					$Consulta = "select  * from sec_web.nave where cod_nave = '".intval($CodCliente)."'";
					$Respuesta = mysqli_query($link,$Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))
					{
						echo $Fila["nombre_nave"];
					}
					else
					{
						echo "&nbsp;";
					}
				}
			}										
			 ?>
        </strong></font> </strong></font></strong></td>
    </tr>
    <tr> 
      <td height="14" colspan="3" align="center"> 
        <?php
	  	if ($Proceso == "P")
	  	{
			$NumCertificado = "";
	  		$Consulta = "select * from sec_web.lote_catodo where cod_bulto = '".$Mes."' and num_bulto = '".$Lote."' and corr_enm='".$Corr."'";
			$Respuesta = mysqli_query($link,$Consulta);				
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				//VERSION DEL CERTIFICADO
				$Consulta2 = "select ifnull(max(version),0) as version from sec_web.certificacion_catodos ";
				$Consulta2.= " where corr_enm = '".$Fila["corr_enm"]."'";
				$Respuesta2 = mysqli_query($link,$Consulta2);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{									
					$Version = $Fila2["version"];
				}
				//-----------------------
				$Consulta = "select * from sec_web.certificacion_catodos ";
				$Consulta.= " where corr_enm = '".$Fila["corr_enm"]."'";
				$Consulta.= " and version = '".$Version."'";
				$Respuesta2 = mysqli_query($link,$Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$Emisor = $Fila2["rut"];
					$FechaCreacion = $Fila2["fecha"];
					$NumCertificado = $Fila2["num_certificado"];
				}
			}
			if ($NumCertificado != "")
				echo "<font color='RED'>ESTE LOTE TIENE ASIGNADO EL CERTIFICADO N&deg;&nbsp;".$NumCertificado."</font>"; 	
	  	}		
	  ?>
        &nbsp;</td>
    </tr>
    <tr> 
      <td height="20" colspan="3" align="center"><font style="font-size=12px"><strong> 
      <?php
			$Consulta = "select distinct t3.cod_producto, t3.cod_subproducto, t3.descripcion ";
			$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
			$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
			$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto = t2.cod_producto ";
			$Consulta.= " and t3.cod_subproducto = t2.cod_subproducto ";
			$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."' and t1.num_bulto = '".$Lote."' and t1.corr_enm='".$Corr."'";
			$Respuesta = mysqli_query($link,$Consulta);				
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Producto = $Fila["cod_producto"];
				$SubProducto = $Fila["cod_subproducto"];
				$Descripcion = $Fila["descripcion"];
			}
			else
			{
				$Producto = "";
				$SubProducto = "";
				$Descripcion = "";
			}
			if (($Producto == "18") && (($SubProducto == "14") || ($SubProducto == "15")))			
			{
				if ($Idioma == "E")
				{
					echo "CATODO STANDARD";
				}
				else
				{
					if ($Idioma!="")
					{
						echo "STANDARD CATHODE";
					}
					else
					{
						echo "&nbsp;";
					}
				}
			}
			else
			{
				if (($Producto == "18") && ($SubProducto == "40"))
				{
					if ($Idioma == "E")
					{
						echo "CATODO GRADO A";
					}
					else
					{
						if ($Idioma!="")
						{
							echo "GRADE A COPPER CATHODES";	
						}
						else
						{
							echo "&nbsp;";
						}
					}
				}
				else
				{
					if (($Producto == "18") && (($SubProducto == "5")||($SubProducto == "6")||($SubProducto == "8")||($SubProducto == "9")||($SubProducto == "10")))
					{
						if ($Idioma == "E")
						{
							echo "CATODOS ELECTROWINING";
						}
						else
						{
							if ($Idioma!="")
							{
								echo "ELECTROWINING CATHODES";	
							}
							else
							{
								echo "&nbsp;";
							}
						}
					}
					else	
						echo strtoupper($Descripcion);
				}
			}				
			?>
</strong></font></td>
    </tr>
    <tr> 
      <td height="14" colspan="3" align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td height="14" colspan="3" align="center"><strong><font style="font-size=12px"> 
        <?php
			$NomCliente = "";
			if ($Idioma == "E")	
			{
				$Consulta = "select  * from sec_web.cliente_venta where cod_cliente = '".$CodCliente."'";
				//echo $Consulta;
				$Respuesta = mysqli_query($link,$Consulta);
				if ($Fila = mysqli_fetch_array($Respuesta))
				{
					$NomCliente =  $Fila["sigla_cliente"];
				}
				else
				{
					$Consulta = "select  * from sec_web.nave where cod_nave = '".intval($CodCliente)."'";
					$Respuesta = mysqli_query($link,$Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))
					{
						$NomCliente =  $Fila["nombre_nave"];
					}
					else
					{
						echo "&nbsp;";
					}
				}
				if ($EnmCode == "E")
					echo strtoupper($NomCliente);
				else
					echo "CODELCO &nbsp;&nbsp;&nbsp;".strtoupper($NomCliente);
			}
?>
        </font></strong></td>
    </tr>
    <tr> 
      <td height="14" colspan="3" align="center"><font style="font-size=12px">&nbsp; 
        </font></td>
    </tr>
    <tr> 
      <td height="29" colspan="3"> <table width="100%" border="0" class="TablaInterior">
          <tr> 
            <td width="18%" height="14"> 
              <?php
			 
				if ($Idioma!="") 
				{
					if ($Idioma == "E")
						echo "LOTE:&nbsp;";				
					else
						echo "LOT:&nbsp;";
				}
				else
				{
					echo "LOTE:&nbsp;";
				}
			?>
            </td>
            <td> <?php echo strtoupper($Mes)."-".str_pad($Lote, 6, "0", STR_PAD_LEFT); ?> 
            </td>
          </tr>
          <tr> 
            <td> 
              <?php
				if ($Idioma!="") 
				{
					if ($Idioma == "E")
						echo "N&deg; SERIE PAQ.:&nbsp;";				
					else
						echo "BUNDLE SERIES:&nbsp;";
				}
				else
				{
					echo "N&deg; SERIE PAQ.:&nbsp;";
				}
			?>
            </td>
            <td> 
              <?php 
			  
					$SeriePaquetes = "";
					$Consulta = "select t1.cod_paquete, t1.num_paquete ";
					$Consulta.= " from sec_web.lote_catodo t1 ";	
					$Consulta.= " where t1.cod_bulto = '".$Mes."' ";
					$Consulta.= " and t1.num_bulto = '".$Lote."' and t1.corr_enm='".$Corr."'";
					$Consulta.= " order by t1.cod_bulto, t1.num_bulto, t1.cod_paquete, t1.num_paquete ";
					$Respuesta = mysqli_query($link,$Consulta);
					$CodPaquete = "";
					$NumPaquete = "";
					$CodPaqueteAnt = "";
					$NumPaqueteAnt = "";
					
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						$CodPaquete = $Fila["cod_paquete"];
						$NumPaquete = $Fila["num_paquete"];
						if (($CodPaqueteAnt != $CodPaquete) || (($NumPaqueteAnt + 1) != $NumPaquete))
						{
							if ($SeriePaquetes == "")
								$SeriePaquetes = $Fila["cod_paquete"]."-".str_pad($Fila["num_paquete"], 6, "0", STR_PAD_LEFT);
							else
								$SeriePaquetes = $SeriePaquetes."/".$CodPaqueteAnt."-".str_pad($NumPaqueteAnt, 6, "0", STR_PAD_LEFT)."&nbsp;&nbsp;".$Fila["cod_paquete"]."-".str_pad($Fila["num_paquete"], 6, "0", STR_PAD_LEFT);
						}
						$CodPaqueteAnt = $Fila["cod_paquete"];
						$NumPaqueteAnt = $Fila["num_paquete"];
						
					}
					if (($CodPaqueteAnt != $CodPaquete) || (($NumPaqueteAnt) != $NumPaquete))
						$SeriePaquetes = $SeriePaquetes."&nbsp;&nbsp;".$CodPaquete."-".str_pad($NumPaquete, 6, "0", STR_PAD_LEFT);
					else
						$SeriePaquetes = $SeriePaquetes."/".$CodPaquete."-".str_pad($NumPaquete, 6, "0", STR_PAD_LEFT);
				  	echo $SeriePaquetes; 
				  ?>
              &nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="51" colspan="3" align="center"> <table width="84%" border="0" class="TablaInterior">
          <tr> 
            <td width="32%"> 
              <?php
				if ($Idioma!="") 
				{
					if ($Idioma == "E")
						echo "PAQUETES:&nbsp;";				
					else
						echo "BUNDLES:&nbsp;";
				}
				else
				{
					echo "PAQUETES:&nbsp;";
				}
			?>
            </td>
            <td width="25%"><?php echo number_format($NumPaquetes,0,",",".") ?>&nbsp;</td>
			<?php // echo "paq".$NumPaquetes;?>
            <td width="24%"> 
              <?php
				if ($Idioma!="") 
				{
					if ($Idioma == "E")
						echo "PESO LOTE:&nbsp;";				
					else
						echo "NET WEIGHT:&nbsp;";
				}
				else
				{
					echo "PESO LOTE:&nbsp;";
				}
			?>
            </td>
            <td width="19%"><?php echo number_format($PesoLote,0,",",".") ?>&nbsp;</td>
          </tr>
          <tr> 
            <td> 
              <?php
				if ($Idioma!="") 
				{
					if ($Idioma == "E")
						echo "ENM/INSTRUCCION:&nbsp;";				
					else
						echo "ENM/INSTRUCTION:&nbsp;";
				}
				else
				{
					echo "ENM/INSTRUCCION:&nbsp;";
				}
			?>
            </td>
            <td><?php echo $Corr ?>&nbsp;&nbsp;</td>
            <td> 
              <?php
				if ($Idioma!="") 
				{
					if ($Idioma == "E")
						echo "FECHA DISP.:&nbsp;";				
					else
						echo "&nbsp;";
				}
				else
				{
					echo "FECHA DISP.:&nbsp;";
				}
			?>
            </td>
            <td> 
              <?php
				if ($Idioma!="") 
				{
					if ($Idioma == "E")
						echo substr($FechaDisp,8,2).".".substr($FechaDisp,5,2).".".substr($FechaDisp,0,4);				
					else
						echo "&nbsp;";
				}
				else
				{
					echo substr($FechaDisp,8,2).".".substr($FechaDisp,5,2).".".substr($FechaDisp,0,4);
				}
			?>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="14" colspan="3">&nbsp;</td>
    </tr>
    <tr valign="top"> 
      <td height="108" colspan="3" align="center"> <table width="40%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000">
          <tr align="center"> 
            <td width="100%" colspan="3"><font style="font-size=12px"><strong><?php echo $MarcaCatodo; ?></strong></font> 
              <table width="100%" border="0" cellpadding="3" cellspacing="0">
                <tr align="center"> 
                  <td width="34%">&nbsp;</td>
                  <td width="35%">&nbsp;</td>
                  <td width="31%">ppm</td>
                </tr>
              </table></td>
          </tr>
          <?php
			if (isset($Lote))
			{
				//ACTUALIZA TABLA PARA TRABAJAR CON LOS VALORES <
				$Consulta = "select * ";
				$Consulta.= " from sec_web.tmp_leyes_catodos t1 inner join proyecto_modernizacion.sub_clase t2 ";
				$Consulta.= " on t2.cod_clase = '3009' and t1.cod_leyes = t2.nombre_subclase ";
				$Consulta.= " where not isnull(t2.valor_subclase6) and t2.valor_subclase6 <> '' and t2.valor_subclase6 <> 0";
				$Consulta.= " order by t2.valor_subclase2";
				$Respuesta2 = mysqli_query($link,$Consulta);
				while ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					if (($Fila2["valor"] <= $Fila2["valor_subclase6"]) && ($Fila2["signo"] == "<"))
					{
						$Actualizar = "update sec_web.tmp_leyes_catodos set ";
						$Actualizar.= " valor = '".$Fila2["valor_subclase7"]."'";
						$Actualizar.= " where cod_paquete = '".$Fila2["cod_paquete"]."'";
						$Actualizar.= " and num_paquete = '".$Fila2["num_paquete"]."'";
						$Actualizar.= " and cod_leyes = '".$Fila2["cod_leyes"]."'";
						mysqli_query($link,$Actualizar);
						//echo $Actualizar."<br>";
					}
				}
				//-----------------------------------------------
				//VERSION DEL CERTIFICADO
				$Consulta2 = "select ifnull(max(version),0) as version from sec_web.certificacion_catodos ";
				$Consulta2.= " where corr_enm = '".$Corr."'";
				$Respuesta2 = mysqli_query($link,$Consulta2);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$VersionAnt = $Fila2["version"];				
					$Version = $Fila2["version"] + 1;
				}
				//-----------------------				
				$Consulta = "select t1.cod_leyes, sum(t1.peso_paquete) as peso_paquetes, sum(t1.peso_paquete * t1.valor) as fino";
				$Consulta.= " from sec_web.tmp_leyes_catodos t1 inner join proyecto_modernizacion.sub_clase t2 ";
				$Consulta.= " on t2.cod_clase = '3009' and t1.cod_leyes = t2.nombre_subclase ";
				$Consulta.= " group by t1.cod_leyes";
				$Consulta.= " order by t2.valor_subclase2";
				$Respuesta = mysqli_query($link,$Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					echo "<tr align='center'>\n";
					//LEY
					$Consulta = "select * from proyecto_modernizacion.leyes where cod_leyes = '".$Fila["cod_leyes"]."'";
					$Respuesta2 = mysqli_query($link,$Consulta);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						echo "<td  width='35%'>".$Fila2["abreviatura"]."</td>\n";	
					}
					else
                  	{
						echo "<td width='35%'>".$Fila["cod_leyes"]."</td>\n";
					}
					if (($PesoLote != 0) && ($Fila["fino"] != 0))
						$ValorLey = $Fila["fino"] / $Fila["peso_paquetes"];
					else
						$ValorLey = 0;
					//SIGNO
					$Signo = "=";
					$Rango = 0;
					$Consulta = "select * ";
					$Consulta.= " from proyecto_modernizacion.sub_clase ";
					$Consulta.= " where cod_clase = '3009' ";
					$Consulta.= " and (not isnull(valor_subclase6) and valor_subclase6 <> '' and valor_subclase6 <> 0)";
					$Consulta.= " and nombre_subclase = '".$Fila["cod_leyes"]."'";
					$Respuesta2 = mysqli_query($link,$Consulta);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						if (round($ValorLey,3) < round($Fila2["valor_subclase6"],3))
						{
							$Signo = "<";
							$Rango = $Fila2["valor_subclase6"];
						}					
					}
                  	echo "<td width='34%'>".$Signo."</td>\n";
					//GRABA Y VERIFICA LEYES
					$Modificado = "N";																					
					if ($Reescribir == "S")
					{
						$Consulta = "select * from sec_web.certificacion_catodos ";
						$Consulta.= " where corr_enm = '".$Corr."' ";
						$Consulta.= " and num_certificado = '".$NumCertificado."'";
						$Consulta.= " and version = '".$VersionAnt."'";
						$Consulta.= " and cod_leyes = '".$Fila["cod_leyes"]."'";						
						$Respuesta2 = mysqli_query($link,$Consulta);
						if ($Fila2 = mysqli_fetch_array($Respuesta2))
						{							
							if ($Proceso != "P")
							{
								if (round($Fila2["valor"],3) != round($ValorLey,3))
								{
									$Actualizar = "update sec_web.certificacion_catodos set ";
									$Actualizar.= " modificado = 'S'";
									$Actualizar.= " where corr_enm = '".$Corr."' ";
									$Actualizar.= " and num_certificado = '".$NumCertificado."'";
									$Actualizar.= " and cod_leyes = '".$Fila["cod_leyes"]."'";
									$Actualizar.= " and version = '".$VersionAnt."'";
									mysqli_query($link,$Actualizar);
								}
								//INSERTA EN LA TABLA CERTIFICACION CATODO
								$FechaG = date("Y-m-d H:i:s");
								$Insertar = "INSERT INTO sec_web.certificacion_catodos (corr_enm, num_certificado, version, cod_leyes, valor, signo, fecha, rut) ";
								$Insertar.= " VALUES ('".$Corr."', '".$NumCertificado."', '".$Version."', '".$Fila["cod_leyes"]."', ";
								if ($Signo == "<")
									$Insertar.= " '".$Rango."', ";
								else
									$Insertar.= " '".round($ValorLey,1)."', ";
								$Insertar.= "'".$Signo."','".$FechaG."','".$CookieRut."')";
								mysqli_query($link,$Insertar);
								//----------------------------------------
								//ACTUALIZA CAMPO GENERACION EN TABLA SOLICITUD_CERTIFICADO
								$Actualizar = "update sec_web.solicitud_certificado set ";
								$Actualizar.= " generacion = 'S'";
								$Actualizar.= " ,rut_generador = '".$CookieRut."'";
								$Actualizar.= " ,num_certificado = '".$NumCertificado."'";
								$Actualizar.= " ,version = '".$Version."'";
								$Actualizar.= " ,fecha_generacion = '".$FechaG."'";									
								$Actualizar.= " where corr_enm = '".$Corr."'";
								$Actualizar.= " and cod_bulto = '".$Mes."'";
								$Actualizar.= " and num_bulto = '".$Lote."'";
								$Actualizar.= " and num_certificado = '".$NumCertificado."'";
								$Actualizar.= " and version = '".$VersionAnt."'";
								mysqli_query($link,$Actualizar);
								//---------------------------------------------------------
							}
							$Modificado = "S";
						}
					}
					else
					{
						if ($Proceso != "P")
						{						
							//INSERTA EN LA TABLA CERTIFICACION CATODO
							$FechaG = date("Y-m-d H:i:s");
							$Insertar = "INSERT INTO sec_web.certificacion_catodos (corr_enm, num_certificado, version, cod_leyes, valor, signo, fecha, rut) ";
							$Insertar.= " VALUES ('".$Corr."', '".$NumCertificado."', '".$Version."','".$Fila["cod_leyes"]."', ";
							if ($Signo == "<")
								$Insertar.= " '".$Rango."', ";
							else
								$Insertar.= " '".round($ValorLey,1)."', ";
							$Insertar.= "'".$Signo."','".$FechaG."','".$CookieRut."')";
							mysqli_query($link,$Insertar);
							//----------------------------------------
							//ACTUALIZA CAMPO GENERACION EN TABLA SOLICITUD_CERTIFICADO
							$Actualizar = "update sec_web.solicitud_certificado set ";
							$Actualizar.= " generacion = 'S'";
							$Actualizar.= " ,rut_generador = '".$CookieRut."'";
							$Actualizar.= " ,num_certificado = '".$NumCertificado."'";
							$Actualizar.= " ,version = '".$Version."'";
							$Actualizar.= " ,fecha_generacion = '".$FechaG."'";
							$Actualizar.= " where corr_enm = '".$Corr."'";
							$Actualizar.= " and cod_bulto = '".$Mes."'";
							$Actualizar.= " and num_bulto = '".$Lote."'";
							mysqli_query($link,$Actualizar);
							//---------------------------------------------------------
						}
					}
					//CANTIDAD DE DECIMALES POR COD_LEYES					
					if (($Fila["cod_leyes"] == "26") || ($Fila["cod_leyes"] == "48"))
					{
						$NumDecimales = 0;
					}						
					else
					{ 
						$NumDecimales = 1;
					}
					if ($Proceso != "P")
					{
						//VALOR					
						$Consulta = "select * from sec_web.certificacion_catodos ";
						$Consulta.= " where corr_enm = '".$Corr."' ";
						$Consulta.= " and num_certificado = '".$NumCertificado."'";
						$Consulta.= " and cod_leyes = '".$Fila["cod_leyes"]."'";
						if ($VersionAnt == 0)
							$Consulta.= " and version = '1'";
						else
							$Consulta.= " and version = '".$Version."'";
						$Respuesta2 = mysqli_query($link,$Consulta);
						if ($Fila2 = mysqli_fetch_array($Respuesta2))
						{
							if ($Fila2["modificado"] == "S")
								echo "<td width='31%'><font color='RED'>";
							else
								echo "<td width='31%'><font color='BLACK'>";
							if ($Signo == "<")
								echo number_format(round($Rango,1),$NumDecimales,",","");
							else
								echo number_format(round($Fila2["valor"],1),$NumDecimales,",","");
						}
						echo "</font></td>\n";
						echo "</tr>\n";
					}
					else
					{
						$Consulta = "select * from sec_web.certificacion_catodos ";
						$Consulta.= " where corr_enm = '".$Corr."' ";
						$Consulta.= " and num_certificado = '".$NumCertificado."'";
						$Consulta.= " and cod_leyes = '".$Fila["cod_leyes"]."'";
						if ($VersionAnt == 0)
							$Consulta.= " and version = '1'";
						else
							$Consulta.= " and version = '".$Version."'";
						$Respuesta2 = mysqli_query($link,$Consulta);					
						if ($Fila2 = mysqli_fetch_array($Respuesta2))
						{
							if ($Fila2["modificado"] == "S")
							{
								if ($Signo == "<")
									echo "<td width='31%'><font color='RED'>".number_format(round($Rango,1),$NumDecimales,",","")."</font></td>\n";
								else
									echo "<td width='31%'><font color='RED'>".number_format(round($ValorLey,1),$NumDecimales,",","")."</font></td>\n";
							}
							else
							{
								if ($Signo == "<")
									echo "<td width='31%'><font color='BLACK'>".number_format(round($Rango,1),$NumDecimales,",","")."</font></td>\n";	
								else
									echo "<td width='31%'><font color='BLACK'>".number_format(round($ValorLey,1),$NumDecimales,",","")."</font></td>\n";	
							}
						}
						else
						{
							if ($Signo == "<")							
								echo "<td width='31%'><font color='BLACK'>".number_format(round($Rango,1),$NumDecimales,",","")."</font></td>\n";
							else
								echo "<td width='31%'><font color='BLACK'>".number_format(round($ValorLey,1),$NumDecimales,",","")."</font></td>\n";
						}
					}
				}                
			}
			?>
        </table></td>
    </tr>
    <tr>
      <td height="14" colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td height="14" colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td height="20" colspan="3" align="center"><font style="font-size:8px"> 
        <?php
				if ($Idioma!="") 
				{
					if ($Idioma == "E")
						echo "LOS CONTENIDOS DE IMPUREZAS 
        CORRESPONDEN A UN PROMEDIO PONDERADO DE LAS PRODUCCIONES INCLUIDAS EN 
        EL LOTE.";				
					else
						echo "THE ABOVE IMPURITIES CONTENTS RESPOND TO A WEIGHTED A AVERAGE OF THE CATHODES INCLUDES IN THIS LOT.";
				}
				else
				{
					echo "LOS CONTENIDOS DE IMPUREZAS 
        CORRESPONDEN A UN PROMEDIO PONDERADO DE LAS PRODUCCIONES INCLUIDAS EN 
        EL LOTE.";
				}
			?>
        </font></td>
    </tr>
    <tr> 
      <td height="14" colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td height="14" colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td height="14" colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td height="14" colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td height="14" colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td height="14" colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td height="20" colspan="3" align="right"><strong> 
        <?php
				if ($Idioma!="") 
				{
					if ($Idioma == "E")
						//echo "JEFE LABORATORIO ANALITICO";
						echo "JEFE CONTROL CALIDAD";			
					else
						//echo "CHIEF ANALYTICAL LABORATORY";
						echo "CHIEF QUALITY CONTROL";
				}
				else
				{
					//echo "JEFE LABORATORIO ANALITICO";
					echo "JEFE CONTROL CALIDAD";
				}
			?>
        </strong></td>
    </tr>
    <tr> 
      <td height="22" colspan="3"> 
        <?php
		$Nombre = "";
		$Consulta = "select * from proyecto_modernizacion.funcionarios ";
		if ($Emisor != "")
			$Consulta.= " where rut = '".$Emisor."'";
		else
			$Consulta.= " where rut = '".$CookieRut."'";
		$Respuesta = mysqli_query($link,$Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Nombre = substr(strtoupper($Fila["nombres"]),0,1)." ".substr(strtoupper($Fila["apellido_paterno"]),0,1)." ".substr(strtoupper($Fila["apellido_materno"]),0,1);
		}
		echo "<strong>&nbsp;&nbsp;/".$Nombre."</strong>";
	  ?>
        &nbsp;</td>
    </tr>
    <tr> 
      <td height="22" colspan="3" align="center"> <input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso('I');"> 
      </td>
    </tr>
    <tr> 
      <td colspan="3"> 
        <?php 
		if ($FechaCreacion == "")	  
	  		echo date("H:i:s"); 
		else
			echo substr($FechaCreacion,11)
	  ?>
      </td>
    </tr>
    <tr> 
      <td colspan="3"> 
        <?php 
		if ($FechaCreacion == "")	  
	  		echo date("d").".".date("m").".".date("Y"); 
		else
			echo substr($FechaCreacion,8,2).".".substr($FechaCreacion,5,2).".".substr($FechaCreacion,0,4);
	  ?>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
