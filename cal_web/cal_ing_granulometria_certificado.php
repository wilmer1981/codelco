<?php 
	include("../principal/conectar_principal.php");
	if ($Recargo == "N")
		$Recargo = "";
	$Consulta = "select t1.cod_producto, t1.cod_subproducto, t2.descripcion as prod, t3.descripcion as subprod from cal_web.solicitud_analisis t1 inner join proyecto_modernizacion.productos t2 ";
	$Consulta.= " on t1.cod_producto = t2.cod_producto inner join proyecto_modernizacion.subproducto t3 ";
	$Consulta.= " on t1.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
	$Consulta.= " where t1.nro_solicitud = '".$SA."'";
	$Consulta.= " and t1.recargo = '".$Recargo."'";
	$Respuesta = mysqli_query($link, $Consulta);	
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Producto = $Fila["cod_producto"];
		$SubProducto = $Fila["cod_subproducto"];
		$NomProducto = $Fila["prod"];
		$NomSubProducto = $Fila["subprod"];
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
<style type="text/css">
<!--
.Estilo1 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
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
		mysqli_query($link, $Eliminar);
		if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
		{
			//PARA DESCOBRIZADOS
			//TABLA PAQUETE_CATODO
			$Consulta = "select distinct ifnull(t1.grupo,'00') as cod_grupo, t1.fecha_produccion, peso_produccion ";
			$Consulta.= " from sec_web.catodos_desc_normal t1";
			$Consulta.= " where t1.cod_bulto = '".$Mes."'";
			$Consulta.= " and t1.num_bulto = '".$Lote."'";
			$Consulta.= " order by t1.fecha_produccion, t1.grupo ";
			$Respuesta = mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Consulta = "select * from sec_web.produccion_catodo ";
				$Consulta.= " where cod_grupo = '".$Fila["cod_grupo"]."'";
				$Consulta.= " and fecha_produccion = '".$Fila["fecha_produccion"]."'";
				$Consulta.= " and cod_muestra <> 'S' "; 
				$Consulta.= " and cod_producto = '18' "; 
				$Consulta.= " and cod_subproducto in (3,42,43,44) "; 
				$Consulta.= " order by fecha_produccion, cod_grupo, cod_cuba ";
				$Respuesta2 = mysqli_query($link, $Consulta);
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
					$Respuesta3 = mysqli_query($link, $Consulta);
					//echo $Consulta."<br>";								
					while($Fila3 = mysqli_fetch_array($Respuesta3))
					{						
						$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, ";
						$Insertar.= " fecha_creacion_paquete, nro_solicitud, cod_cuba, peso_produccion) ";
						$Insertar.= " values('".$Fila["cod_grupo"]."','".$Fila["fecha_produccion"]."','".$Fila3["cod_leyes"]."','".$Fila3["valor"]."', ";
						$Insertar.= " '".$Fila3["signo"]."', '".$Fila["fecha_produccion"]."', '".$Fila3["nro_solicitud"]."', '".$Fila2["cod_cuba"]."', '".$Fila["peso_produccion"]."')";
						mysqli_query($link, $Insertar);
					}
				}								
			}
		}
		else
		{			
			//TABLA PAQUETE_CATODO
			$Consulta = "select distinct ifnull(t2.cod_grupo,'00') as cod_grupo, t2.fecha_creacion_paquete ";
			$Consulta.= " from sec_web.lote_catodo t1	inner join";
			$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
			$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
			$Consulta.= " and t1.num_bulto = '".$Lote."'";
			//$Consulta.= " and t2.cod_grupo <> 0";
			$Consulta.= " order by t2.cod_grupo";
			$Respuesta = mysqli_query($link, $Consulta);
			$i = 0;
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Consulta = "select max(fecha_produccion) as fecha_produccion";
				$Consulta.= " from sec_web.produccion_catodo ";
				$Consulta.= " where cod_grupo = '".$Fila["cod_grupo"]."'";
				$Consulta.= " and fecha_produccion <= '".$Fila["fecha_creacion_paquete"]."'";
				$Respuesta2 = mysqli_query($link, $Consulta);
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
			reset($ArrProd);		
			$SeriePaquetes = "";
			$CodPaqueteAnt = "";
			$NumPaqueteAnt = 0;
			while (list($k,$v)=each($ArrProd))
			{	
				if (($v[0] == "00") || ($v[0] == "0") || ($v[0] == ""))
				{
					//CONSULTA LOTE EXTERNO
					$Consulta = "SELECT distinct t2.lote_origen ";
					$Consulta.= "FROM sec_web.lote_catodo t1 inner join sec_web.paquete_catodo_externo t2 ";
					$Consulta.= "on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
					$Consulta.= " WHERE t1.cod_bulto = '".$Mes."'  ";
					$Consulta.= " and t1.num_bulto = '".$Lote."' ";
					$Consulta.= " order by t2.cod_paquete, t2.num_paquete, t2.lote_origen ";
					$Respuesta = mysqli_query($link, $Consulta);
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
						$Respuesta2 = mysqli_query($link, $Consulta);
						$Encontro = false;
						while ($Fila2 = mysqli_fetch_array($Respuesta2))
						{
							$Encontro = true;
							$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
							$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
							$Respuesta3 = mysqli_query($link, $Consulta);				
							if ($Fila3 = mysqli_fetch_array($Respuesta3))
							{
								$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, ";
								$Insertar.= " fecha_creacion_paquete, nro_solicitud) ";
								$Insertar.= " values('".$Fila["lote_origen"]."', '".$v[1]."',";
								$Insertar.= " '".$Fila2["cod_leyes"]."','".$Fila2["valor"]."','".$Fila2["signo"]."', '".$v[2]."',";
								$Insertar.= " '".$Fila2["nro_solicitud"]."')";
								mysqli_query($link, $Insertar);			
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
						$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($v[2],5,2),substr($v[2],8,2),substr($v[2],0,4)));
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
							}
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
					$Respuesta2 = mysqli_query($link, $Consulta);
					$Encontro = false;
					while ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$Encontro = true;
						$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
						$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
						$Respuesta3 = mysqli_query($link, $Consulta);				
						if ($Fila3 = mysqli_fetch_array($Respuesta3))
						{
							$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete) ";
							$Insertar.= " values('".$v[0]."',";
							if ($v[0] >= 50)
								$Insertar.= "'".$v[2]."',";
							else
								$Insertar.= "'".$v[1]."',";
							$Insertar.= "'".$Fila2["cod_leyes"]."','".$Fila2["valor"]."','".$Fila2["signo"]."', '".$v[2]."')";
							mysqli_query($link, $Insertar);				
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
						$Respuesta3 = mysqli_query($link, $Consulta);
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
							$Respuesta4 = mysqli_query($link, $Consulta);
							while ($Fila4 = mysqli_fetch_array($Respuesta4))
							{
								$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
								$Consulta.= " and nombre_subclase = '".$Fila4["cod_leyes"]."'";
								$Respuesta5 = mysqli_query($link, $Consulta);				
								if ($Fila5 = mysqli_fetch_array($Respuesta5))
								{
									$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete) ";
									$Insertar.= " values('".$v[0]."','".$v[2]."','".$Fila4["cod_leyes"]."','".$Fila4["valor"]."','".$Fila4["signo"]."', '".$v[2]."')";
									mysqli_query($link, $Insertar);				
								}
							}
						}
					}
				}
			}//END WHILE			
		}//END IF
	}//END IF
	reset($ArrProd);
	while (list($k,$v)=each($ArrProd))
	{				
		$Encontro = false;		
		$Consulta2 = "select * from sec_web.tmp_leyes_grupos ";
		$Consulta2.= " where cod_grupo = '".$v[0]."' ";
		$Consulta.= " and fecha = '".$v[1]."'";
		//echo $Consulta2."<br>";
		$Respuesta2 = mysqli_query($link, $Consulta2);
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$Encontro = true;			
		}		
		if ($Encontro == false)
		{
			$Encontro = false;
			$Consulta2 = "select * from sec_web.tmp_leyes_grupos ";
			$Consulta2.= " where cod_grupo = '".$v[0]."'";
			$Respuesta2 = mysqli_query($link, $Consulta2);
			while ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				$Encontro = true;
				$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete) ";
				$Insertar.= " values('".$v[0]."','".$v[1]."','".$Fila2["cod_leyes"]."','".$Fila2["valor"]."','".$Fila2["signo"]."', '".$v[2]."')";
				mysqli_query($link, $Insertar);
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
	$Consulta.= " where cod_bulto = '".$Mes."' and num_bulto = '".$Lote."'";
	$Respuesta = mysqli_query($link, $Consulta);
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
	if (isset($Lote))
	{
		//TABLA EMBARQUE_VENTANA
		$Consulta = "select * from sec_web.embarque_ventana where cod_bulto = '".$Mes."' and num_bulto = '".$Lote."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{	
			if (strtoupper($Fila["tipo_enm_code"]) == "E") 
			{
				$Consulta2 = "select * from sec_web.programa_enami where corr_enm = '".$Fila["corr_enm"]."'";
				$Respuesta2 = mysqli_query($link, $Consulta2);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
					$CodCliente = $Fila2["cod_cliente"];
				else
					$CodCliente = "";
			}
			else
			{
				$Consulta2 = "select * from sec_web.programa_codelco where corr_codelco = '".$Fila["corr_enm"]."'";
				$Respuesta2 = mysqli_query($link, $Consulta2);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
					$CodCliente = $Fila2["cod_cliente"];
				else
					$CodCliente = "";			
			}
			$NumPaquetes = $Fila["bulto_paquetes"];
			$PesoLote = $Fila["bulto_peso"];				
			$FechaDisp = $Fila["fecha_envio"];			
			$NumEnvio = $Fila["corr_enm"];
			$MarcaCatodo = $Fila["cod_marca"];						
			$TipoEmbarque = $Fila["tipo_embarque"];
		}
		//MARCA CATODO
		$Consulta = "select * from sec_web.marca_catodos where cod_marca = '".$MarcaCatodo."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Idioma == "E")
				$MarcaCatodo = $Fila["descripcion"];
			else
				$MarcaCatodo = $Fila["descripcion_ingles"];
		}
		//TABLA PAQUETE_CATODO
		$Consulta = "SHOW TABLES FROM `sec_web`";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["Tables_in_sec_web"] == "tmp_leyes_catodos")
			{
				$Eliminar = "DROP TABLE `sec_web`.`tmp_leyes_catodos`";
				mysqli_query($link, $Eliminar);
			}
		}
		//VERIFICA SI ES GRUPO 00 o NO O SI ES CAT. DESC. NORMAL
		if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
		{	
			$Consulta = "create table `sec_web`.`tmp_leyes_catodos` as ";
			$Consulta.= " select t1.cod_grupo as cod_paquete, t1.fecha as num_paquete, t1.peso_produccion as peso_paquete, ";
			$Consulta.= " t1.cod_leyes, t1.valor, t1.signo ";
			$Consulta.= " from sec_web.tmp_leyes_grupos t1 ";
			mysqli_query($link, $Consulta);
		}
		else
		{
			$Consulta = "select distinct ifnull(t2.cod_grupo,'00') as cod_grupo ";
			$Consulta.= " from sec_web.lote_catodo t1	inner join";
			$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
			$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
			$Consulta.= " and t1.num_bulto = '".$Lote."'";
			$Consulta.= " order by t2.cod_grupo";
			$Respuesta = mysqli_query($link, $Consulta);
			$Grupo = 0;
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Grupo = $Fila["cod_grupo"];
			}
			if (($Grupo == "00") || ($Grupo == "0") || ($Grupo == ""))
			{
				$Consulta = "create table `sec_web`.`tmp_leyes_catodos` as ";
				$Consulta.= " select t1.cod_paquete, t1.num_paquete, t2.peso_paquete as peso_paquete, ";
				$Consulta.= " t3.cod_leyes, t3.valor, t2.cod_grupo, t3.signo ";
				$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo_externo t2  ";
				$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete  ";
				$Consulta.= " inner join sec_web.tmp_leyes_grupos t3 on t2.lote_origen = t3.cod_grupo ";
				//$Consulta.= " and t2.fecha_creacion_paquete = t3.fecha_creacion_paquete ";
				$Consulta.= " where t1.cod_bulto = '".$Mes."' and t1.num_bulto = '".$Lote."'  ";
				$Consulta.= " order by t1.cod_paquete, t1.num_paquete, t3.cod_leyes ";
				mysqli_query($link, $Consulta);
			}
			else
			{		
				$Consulta = "create table `sec_web`.`tmp_leyes_catodos` as ";
				$Consulta.= " select t1.cod_paquete, t1.num_paquete, t2.peso_paquetes as peso_paquete, ";
				$Consulta.= " t3.cod_leyes, t3.valor, t2.cod_grupo, t3.signo ";
				$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2  ";
				$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete  ";
				$Consulta.= " inner join sec_web.tmp_leyes_grupos t3 on t2.cod_grupo = t3.cod_grupo ";
				$Consulta.= " and t2.fecha_creacion_paquete = t3.fecha_creacion_paquete ";
				$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."' and t1.num_bulto = '".$Lote."'  ";
				$Consulta.= " order by t1.cod_paquete, t1.num_paquete, t3.cod_leyes ";
				mysqli_query($link, $Consulta);
			}
		}			
	}
?>
        
  <table width="600" height="684" border="0" align="center">
    <tr> 
      <td width="29%" height="44" align="center"> DEPTO. CONTROL CALIDAD<br>LABORATORIO ANALITICO </td>
      <td width="52%" align="center"><img src="../principal/imagenes/letrasenami.gif" width="160" height="40"></td>
      <td width="19%" align="center"><strong> 
        </strong></td>
    </tr>
    <tr> 
      <td height="22" colspan="3" align="center">&nbsp;</td>	  
    </tr>
    <tr> 
      <td height="22" colspan="3" align="center" class="Estilo1"> 
        GRANULOMETRIA</td>
    </tr>
    <tr> 
      <td height="16" colspan="3" align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td height="30">CLIENTE<font style="font-size=12px"> :
        </font></td>
      <td height="30" colspan="2"><?php echo strtoupper($DescCliente);?></td>
    </tr>
    <tr> 
      <td height="25">PRODUCTO</td>
      <td height="25" colspan="2"><?php echo strtoupper($NomSubProducto);?></td>
    </tr>
    <tr>
      <td height="22">DESC. PRODUCTO:</td>
      <td height="22" colspan="2"><?php echo strtoupper($DescProducto);?></td>
    </tr>
    <tr>
      <td height="22">SOLICITUD DE ANALISIS: </td>
      <td height="22" colspan="2"><?php echo substr($SA,4);?></td>
    </tr>
    <tr>
      <td height="24">FECHA</td>
      <td height="24" colspan="2"><?php echo date("d-m-Y");?></td>
    </tr>
    <tr>
      <td height="16">&nbsp;</td>
      <td height="16" colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="16">&nbsp;</td>
      <td height="16" colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr valign="top"> 
      <td colspan="3" align="center"><font style="font-size=12px">&nbsp; 
        </font>   <table width="400" border="1" cellpadding="5" cellspacing="1" class="TablaInterior">
          <tr align="center">
            <td colspan="4"><strong>PESOS DE TODA LA MUESTRA </strong></td>
          </tr>
          <tr align="center">
            <td><strong>MALLAS</strong></td>
            <td><strong>PESO GRS. </strong></td>
            <td><strong>%</strong></td>
            <td><strong>ACUMULADO</strong></td>
          </tr>
<?php		
	//PESO TOTAL
	$Consulta = "select distinct peso_muestra as peso_total, cod_estado as estado from cal_web.granulometria where nro_solicitud = '".$SA."' and recargo = '".$Recargo."' order by corr";	
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$PesoMuestra = $Fila["peso_total"];
		$Estado = $Fila["estado"];
	}
	//-----------
	$Consulta = "select * from cal_web.granulometria ";
	$Consulta.= " where nro_solicitud = '".$SA."' and recargo = '".$Recargo."' order by corr";	
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '1007' and cod_subclase = '".$Fila["cod_unidad"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			$Signo = $Fila2["nombre_subclase"];
		else
			$Signo = "";
		$Malla = $Fila["signo"]." ".$Fila["malla"]." ".$Signo;
		echo "<tr align='center'>\n";
		echo "<td><strong>".$Malla."</strong></td>\n";
		echo "<td>".number_format($Fila["peso"],1,",",".")."</td>\n";
		if ($PesoMuestra > 0)
		{
			$Porcentaje = round(100*$Fila["peso"]/$PesoMuestra,2);
			$Acum = round($Acum + (100*$Fila["peso"]/$PesoMuestra),2);			
		}
		else
		{
			$Porcentaje = 0;
			$Acum = 0;	
		}
		$TotalPeso = $TotalPeso + $Fila["peso"];
		echo "<td>".number_format($Porcentaje,2,",",".")."</td>\n";
		echo "<td>".number_format($Acum,2,",",".")."</td>\n";
		echo "</tr>\n";
	}
?>		  
          <tr align="center">
            <td>&nbsp;</td>
            <td><strong><?php echo number_format($TotalPeso,0,",","."); ?></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>        <font style="font-size:8px">&nbsp; 
        </font></td>
    </tr>
    <tr> 
      <td height="16" colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td height="16" colspan="3">&nbsp;</td>
    </tr>
    <tr align="right"> 
      <td height="16" colspan="3">_______________________</td>
    </tr>
    <tr> 
      <td height="22" colspan="3" align="right"><strong> 
        Jefe Muestreo y Refino 
        </strong></td>
    </tr>
    <tr> 
      <td height="24" colspan="3"> 
        <?php
		$Nombre = "";
		$Consulta = "select * from proyecto_modernizacion.funcionarios ";
		if ($Emisor != "")
			$Consulta.= " where rut = '".$Emisor."'";
		else
			$Consulta.= " where rut = '".$CookieRut."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Nombre = substr(strtoupper($Fila["nombres"]),0,1)." ".substr(strtoupper($Fila["apellido_paterno"]),0,1)." ".substr(strtoupper($Fila["apellido_materno"]),0,1);
		}
		echo "<strong>&nbsp;&nbsp;/".$Nombre."</strong>";
	  ?>
        &nbsp;</td>
    </tr>
    <tr> 
      <td height="24" colspan="3" align="center"> <input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso('I');"> 
      </td>
    </tr>
    <tr> 
      <td height="22" colspan="3"> 
        <?php 
		if ($FechaCreacion == "")	  
	  		echo date("H:i:s"); 
		else
			echo substr($FechaCreacion,11)
	  ?>
      </td>
    </tr>
    <tr> 
      <td height="22" colspan="3"> 
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
