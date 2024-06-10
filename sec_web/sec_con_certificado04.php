<?php 	
	include("../principal/conectar_principal.php");

	$Corr  = isset($_REQUEST["Corr"])?$_REQUEST["Corr"]:"";
	$Lote   = isset($_REQUEST["Lote"])?$_REQUEST["Lote"]:"";
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$Mes    = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$CodProducto      = isset($_REQUEST["CodProducto"])?$_REQUEST["CodProducto"]:"";
	$CodSubProducto   = isset($_REQUEST["CodSubProducto"])?$_REQUEST["CodSubProducto"]:"";

	if ($Mes=='A' && $Lote==25000)
	{
		$CmbAno =2007;
	}

	$Ano = $CmbAno;  

	$Consulta = "SELECT distinct t2.cod_producto, t2.cod_subproducto ";
	$Consulta.= " from sec_web.lote_catodo t1	inner join";
	$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
	$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and  t1.cod_bulto = '".$Mes."'";
	$Consulta.= " and t1.num_bulto = '".$Lote."'";
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

	$Consulta.= " order by t2.cod_producto, t2.cod_subproducto";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$CodProducto = $Fila["cod_producto"];
		$CodSubProducto = $Fila["cod_subproducto"];
	}	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<script language="JavaScript">
function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
</head>

<body background="../Principal/imagenes/fondo3.gif">
<?php
	$Error = "";
	$ArrProd = array();
	if ($Lote!="")
	{
		$Eliminar = "delete from sec_web.tmp_leyes_grupos";
		mysqli_query($link, $Eliminar);
		if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
		{
			//PARA DESCOBRIZADOS
			//TABLA PAQUETE_CATODO
			$Consulta = "SELECT distinct ifnull(t1.grupo,'00') as cod_grupo, t1.fecha_produccion, peso_produccion ";
			$Consulta.= " from sec_web.catodos_desc_normal t1";
			$Consulta.= " where t1.cod_bulto = '".$Mes."'";
			$Consulta.= " and t1.num_bulto = '".$Lote."'";
			$Consulta.= " order by t1.fecha_produccion, t1.grupo ";
			$Respuesta = mysqli_query($link, $Consulta);
			//echo $Consulta."<br>";
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				if($CodSubProducto != "3")
				{
					$Consulta = "SELECT * from sec_web.produccion_catodo ";
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
							//echo "Nro. SA = ".$Fila3["nro_solicitud"]." LEY = ".$Fila3["cod_leyes"]." VALOR = ".$Fila3["valor"]."<br>";
							$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, ";
							$Insertar.= " fecha_creacion_paquete, nro_solicitud, cod_cuba, peso_produccion) ";
							$Insertar.= " values('".$Fila["cod_grupo"]."','".$Fila["fecha_produccion"]."','".$Fila3["cod_leyes"]."','".$Fila3["valor"]."', ";
							$Insertar.= " '".$Fila3["signo"]."', '".$Fila["fecha_produccion"]."', '".$Fila3["nro_solicitud"]."', '".$Fila2["cod_cuba"]."', '".$Fila["peso_produccion"]."')";
							mysqli_query($link, $Insertar);
						}
					}			
				}
				else
				{
				
					//while ($Fila2 = mysqli_fetch_array($Respuesta2))
					//{					
					
						$Consulta = " SELECT t2.nro_solicitud,t2.cod_leyes, t2.valor, t2.signo, t2.cod_unidad, t1.estado_actual from cal_web.solicitud_analisis as t1";
						$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2"; 
						$Consulta.= " ON t1.nro_solicitud = t2.nro_solicitud ";
						$Consulta.= " AND t1.fecha_hora = t2.fecha_hora ";
						$Consulta.= " AND t1.rut_funcionario = t2.rut_funcionario ";
						$Consulta.= " AND t1.id_muestra = t2.id_muestra ";
						$Consulta.= " AND t1.recargo = t2.recargo ";
						if ($Mes=='A' && $Lote==25000)
						{
							$Consulta.= " AND t2.id_muestra = '".$Fila["cod_grupo"]."'";
						}
						else
						{
							$Consulta.= " AND left(t2.id_muestra,5) like '%".intval($Fila["cod_grupo"])."%'";
						}
						$Consulta.= " WHERE t1.cod_producto = 18 AND left(t1.fecha_muestra,10) = '".$Fila["fecha_produccion"]."'";
							if ($Mes=='A' && $Lote==25000)
							{
								$Consulta.= " AND t1.id_muestra = '".$Fila["cod_grupo"]."'";
							}
							else
							{
								$Consulta.= " AND left(t1.id_muestra,5) like '%".intval($Fila["cod_grupo"])."%'";
							}	
						$Consulta.= " AND t2.valor != '' "; //AND t2.cod_leyes != 48";
						$Consulta.= " AND t1.cod_periodo='1' ";
						$Consulta.= " AND t1.tipo='1' ";
						$Consulta.= " AND t1.cod_analisis='1' ";
						$Consulta.= " AND t1.estado_actual <> '7'";	
						$Respuesta3 = mysqli_query($link, $Consulta);
						//echo $Consulta."<br>";								
						while($Fila3 = mysqli_fetch_array($Respuesta3))
						{
							//echo "Nro. SA = ".$Fila3["nro_solicitud"]." LEY = ".$Fila3["cod_leyes"]." VALOR = ".$Fila3["valor"]."<br>";
							$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, ";
							$Insertar.= " fecha_creacion_paquete, nro_solicitud, cod_cuba, peso_produccion) ";
							$Insertar.= " values('".$Fila["cod_grupo"]."','".$Fila["fecha_produccion"]."','".$Fila3["cod_leyes"]."','".$Fila3["valor"]."', ";
							$Insertar.= " '".$Fila3["signo"]."', '".$Fila["fecha_produccion"]."', '".$Fila3["nro_solicitud"]."', '".$Fila2["cod_cuba"]."', '".$Fila["peso_produccion"]."')";
							mysqli_query($link, $Insertar);
						}
					//}			

				}
				
									
			}
		}
		else
		{
			//TABLA PAQUETE_CATODO
			$Consulta = "SELECT distinct ifnull(t2.cod_grupo,'00') as cod_grupo, t2.fecha_creacion_paquete ";
			$Consulta.= " from sec_web.lote_catodo t1	inner join";
			$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
			$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
			$Consulta.= " and t1.num_bulto = '".$Lote."'";
			$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

			$Consulta.= " order by t2.cod_grupo";
			//echo $Consulta;
			$Respuesta = mysqli_query($link, $Consulta);
			$i = 0;
			while ($Fila = mysqli_fetch_array($Respuesta))
			{			
				$Consulta = "SELECT max(fecha_produccion) as fecha_produccion";
				$Consulta.= " from sec_web.produccion_catodo ";
				$Consulta.= " where cod_grupo = '".$Fila["cod_grupo"]."'";
				$Consulta.= " and fecha_produccion <= '".$Fila["fecha_creacion_paquete"]."'";
				//echo $Consulta;
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
					//echo $Fila["cod_grupo"]."  ".$Fila2["fecha_produccion"]."  ". $Fila["fecha_creacion_paquete"]."<br>";
				}
			}
			reset($ArrProd);
			$SeriePaquetes = "";
			$CodPaqueteAnt = "";
			$NumPaqueteAnt = 0;
			$i = 0;
			//while (list($k,$v)=each($ArrProd))
			foreach($ArrProd as $k => $v)
			{	
				if (($v[0] == "00") || ($v[0] == "0") || ($v[0] == ""))
				{
					//CONSULTA LOTE EXTERNO
					$Consulta = "SELECT distinct t2.lote_origen ";
					$Consulta.= "FROM sec_web.lote_catodo t1 inner join sec_web.paquete_catodo_externo t2 ";
					$Consulta.= "on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
					$Consulta.= " WHERE t1.cod_bulto = '".$Mes."'  ";
					$Consulta.= " and t1.num_bulto = '".$Lote."' ";
					$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

					$Consulta.= " order by t2.cod_paquete, t2.num_paquete, t2.lote_origen ";
					
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Respuesta))
					{					
						//---------------------
						$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
						$Consulta.= " t2.signo, t1.nro_solicitud ";
						$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
						$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
						$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
						$Consulta.= " where ((t1.tipo = 1 and t1.id_muestra = '".$Fila["lote_origen"]."') ";
						$Consulta.= " or (tipo = '2' and t1.id_muestra = '".$Fila["lote_origen"]."-R')) ";				
						$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
						$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
						$Consulta.= " and t1.cod_producto = '18'";
						$Consulta.= "order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
						$Respuesta2 = mysqli_query($link, $Consulta);
						$Encontro = false;
						while ($Fila2 = mysqli_fetch_array($Respuesta2))
						{
							$Encontro = true;
							$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
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
					$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
					$Consulta.= " t2.signo, t1.nro_solicitud ";
					$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
					$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
					$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
					$Consulta.= " where ((t1.tipo = 1 and (t1.id_muestra = '".$v[0]."' or t1.id_muestra = '".intval($v[0])."')) ";
					$Consulta.= " or (tipo = '2' and (t1.id_muestra = '".$v[0]."-R' or t1.id_muestra = '".intval($v[0])."-R'))) ";
					if ($v[0] >= 50)
					{ 
						//CUANDO SON VIRTUALES TRABAJO CON LA FECHA CREACION PAQUETE				
						/*$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($v[2],5,2),substr($v[2],8,2),substr($v[2],0,4)));
						//ingreso algo
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
					$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
					$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
					$Consulta.= " and t1.cod_producto = '18'";
					$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
					//echo $Consulta."<br>";
					$Respuesta2 = mysqli_query($link, $Consulta);
					$Encontro = false;
					while ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$Encontro = true;
						$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
						$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
						$Respuesta3 = mysqli_query($link, $Consulta);				
						if ($Fila3 = mysqli_fetch_array($Respuesta3))
						{
							$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete, nro_solicitud) ";
							$Insertar.= " values('".$v[0]."',";
							if ($v[0] >= 50)
								$Insertar.= "'".$v[2]."',";
							else
								$Insertar.= "'".$v[1]."',";
							$Insertar.= "'".$Fila2["cod_leyes"]."','".$Fila2["valor"]."','".$Fila2["signo"]."', '".$v[2]."', '".$Fila2["nro_solicitud"]."')";
							mysqli_query($link, $Insertar);				
						}
					}
					if (($v[0] >= 50) && ($Encontro == false))
					{
						$Consulta = "SELECT max(t1.fecha_muestra) as fecha_muestra";
						$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
						$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
						$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
						$Consulta.= " where ((t1.tipo = 1 and (t1.id_muestra = '".$v[0]."' or t1.id_muestra = '".intval($v[0])."')) ";
						$Consulta.= " or (tipo = '2' and (t1.id_muestra = '".$v[0]."-R' or t1.id_muestra = '".intval($v[0])."-R'))) ";				
						$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
						$Consulta.= " and t1.fecha_muestra < '".substr($Fecha1,0,7)."-01 00:00:00' ";
						$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
						$Consulta.= " and t1.cod_producto = '18'";
						//echo "CCCC".$Consulta;
						$Respuesta3 = mysqli_query($link, $Consulta);
						while ($Fila3 = mysqli_fetch_array($Respuesta3))
						{
							$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
							$Consulta.= " t2.signo, t1.nro_solicitud ";
							$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
							$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
							$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
							$Consulta.= " where ((t1.tipo = 1 and (t1.id_muestra = '".$v[0]."' or t1.id_muestra = '".intval($v[0])."')) ";
							$Consulta.= " or (tipo = '2' and (t1.id_muestra = '".$v[0]."-R' or t1.id_muestra = '".intval($v[0])."-R'))) ";				
							$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
							$Consulta.= " and t1.fecha_muestra < '".$Fila["fecha_muestra"]."' "; //FECHA MAXIMA ENCONTRADA (DESDE LA FECHA QUE NO ENCONTRO)
							$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
							$Consulta.= " and t1.cod_producto = '18'";
							$Consulta.= " order by t2.cod_leyes";
							$Respuesta4 = mysqli_query($link, $Consulta);
							while ($Fila4 = mysqli_fetch_array($Respuesta4))
							{
								$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
								$Consulta.= " and nombre_subclase = '".$Fila4["cod_leyes"]."'";
								$Respuesta5 = mysqli_query($link, $Consulta);				
								if ($Fila5 = mysqli_fetch_array($Respuesta5))
								{
									$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete, nro_solicitud) ";
									$Insertar.= " values('".$v[0]."','".$v[2]."','".$Fila4["cod_leyes"]."','".$Fila4["valor"]."','".$Fila4["signo"]."', '".$v[2]."', '".$Fila4["nro_solicitud"]."')";
									mysqli_query($link, $Insertar);				
								}
							}
						}
					}
				}			
			}//FIN WHILE						
		}//FIN ELSE
	}
?>
<strong>LOTE: <?php echo strtoupper($Mes)."-".str_pad($Lote, 6, "0", STR_PAD_LEFT) ?></strong><br>
<br>
<table width="800" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01"> 
<?php  
if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
{
	echo "<td width='10%'>GRUPO </td>\n";
	echo "<td width='10%'>CUBA </td>\n";
	//echo "<td width='20%'>TIPO SUB PRODUCTO(CALIDAD) </td>\n";
	echo "<td width='10%'>FECHA</td>\n";
	echo "<td width='8%'>SOLICITUD</td>";
    echo "<td width='15%'>PESO</td>";
}
else
{
    $Consulta = "SELECT distinct ifnull(t2.cod_grupo,'00') as cod_grupo ";
	$Consulta.= " from sec_web.lote_catodo t1	inner join";
	$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
	$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
	$Consulta.= " and t1.num_bulto = '".$Lote."'";
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

	$Consulta.= " order by t2.cod_grupo";
	//echo "CON".$Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$Grupo = 0;
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Grupo = $Fila["cod_grupo"];
	}
	if (($Grupo == "00") || ($Grupo == "0") || ($Grupo == ""))
	{
		echo "<td width='10%'>LOTE </td>\n";			
	}
	else
	{
		echo "<td width='10%'>GRUPO </td>\n";
	}
	//echo "<td width='20%'>TIPO SUB PRODUCTO(CALIDAD) </td>\n";
	echo "<td width='8%'>SOLICITUD</td>";
    echo "<td width='15%'>NUM. PAQ.</td>";
}
?>	        
    <?php
	$Consulta = "SELECT distinct t1.cod_leyes ";
	$Consulta.= " from sec_web.tmp_leyes_grupos t1 inner join proyecto_modernizacion.sub_clase t2 ";
	$Consulta.= " on t2.cod_clase = '3009' and t1.cod_leyes = t2.nombre_subclase ";
	$Consulta.= " order by t2.valor_subclase2 ";
	$Respuesta = mysqli_query($link, $Consulta);
	$i = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{	
		$Consulta = "SELECT * from proyecto_modernizacion.leyes where cod_leyes = '".$Fila["cod_leyes"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			echo "<td>".$Fila2["abreviatura"]."</td>\n";
			$ArrLeyes[$i] = $Fila2["cod_leyes"];	
		}
		$i++;
	}
	echo "<td>CALIDAD</td>\n";
?>
  </tr>
  <?php
 		$ArrGrupos = array();		
		$Consulta = "SELECT distinct cod_grupo, cod_cuba, fecha, nro_solicitud, fecha2, fecha_creacion_paquete ";
		$Consulta.= " from sec_web.tmp_leyes_grupos ";
		$Consulta.= " order by cod_grupo, fecha";
		$Respuesta = mysqli_query($link, $Consulta);
		$TotalPaquetes = 0;
		$i = 0;
		$CodGrupo = "";
		$CodGrupoAnt = "";
		while ($Fila = mysqli_fetch_array($Respuesta))
		{	
			$ArrGrupos[$i][0] = $Fila["cod_grupo"];
			$i++;
			echo "<tr>\n";
			$Consulta = "SELECT * from cal_web.solicitud_analisis ";
			$Consulta.= " where nro_solicitud = '".$Fila["nro_solicitud"]."'";
			$Consulta.= " and (recargo = '' or isnull(recargo))";
			$Respuesta2 = mysqli_query($link, $Consulta);			
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				if ($Fila2["estado_actual"] <> 6)
					echo "<td align='center' bgcolor='RED'>";
				else
					echo "<td align='center'>";
			}
			else
			{
				echo "<td align='center'>";
			}						
			if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
			{
				echo $Fila["cod_grupo"];			
				echo "</td>\n";
				echo "<td align='center'>".$Fila["cod_cuba"]."</td>\n";
				echo "<td align='center'>".substr($Fila["fecha"],8,2)."/".substr($Fila["fecha"],5,2)."/".substr($Fila["fecha"],0,4)."</td>\n";			
			}
			else
			{
				echo "<a href=\"sec_con_certificado_det_pqtes.php?Mes=".$Mes."&Lote=".$Lote."&Grupo=".$Fila["cod_grupo"]."&Ano=".$Ano."\">".$Fila["cod_grupo"]."</a>";			
				echo "</td>\n";
			}
			echo "<td align='center'>";			
			echo "<a href=\"JavaScript:Historial(".$Fila["nro_solicitud"].",'')\">".$Fila["nro_solicitud"]."</a>";
			echo "</td>\n";
			if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
			{
				$Consulta = "SELECT t1.grupo, sum(peso_produccion)  as total_paquetes";
				$Consulta.= " from sec_web.catodos_desc_normal t1 ";
				$Consulta.= " where t1.grupo = '".$Fila["cod_grupo"]."'";
				$Consulta.= " and t1.cod_bulto = '".$Mes."'";
				$Consulta.= " and t1.num_bulto = '".$Lote."'";
				$Consulta.= " group by t1.grupo ";
			}
			else
			{
				if (strlen($Fila["cod_grupo"]) > 2)
				{
					$Consulta = "SELECT ifnull(COUNT(*),0) as total_paquetes";
					$Consulta.= " from sec_web.lote_catodo t1 inner join";
					$Consulta.= " sec_web.paquete_catodo_externo t2 ";
					$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
					$Consulta.= " where t1.cod_bulto = '".$Mes."'";
					$Consulta.= " and t1.num_bulto = '".$Lote."'";
					$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

					$Consulta.= " and t2.lote_origen = '".$Fila["cod_grupo"]."'";
					$Consulta.= " order by t2.lote_origen";
				}
				else
				{
					$Consulta = "SELECT ifnull(COUNT(*),0)  as total_paquetes";
					$Consulta.= " from sec_web.lote_catodo t1 inner join";
					$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
					$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
					$Consulta.= " and t1.num_bulto = '".$Lote."'";
					$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

					$Consulta.= " and t2.cod_grupo = '".$Fila["cod_grupo"]."'";				
					$Consulta.= " order by t2.cod_grupo";
				}						
			}
			$Respuesta2 = mysqli_query($link, $Consulta);
			$Paquetes = "";			
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{								
				if ($CodGrupoAnt != $Fila["cod_grupo"])
				{
					$Filas = 0;
					$Consulta = "SELECT distinct cod_grupo, fecha, nro_solicitud, fecha2, fecha_creacion_paquete ";
					$Consulta.= " from sec_web.tmp_leyes_grupos ";
					$Consulta.= " where cod_grupo = '".$Fila["cod_grupo"]."'";
					$Respuesta3 = mysqli_query($link, $Consulta);					
					while ($Fila3 = mysqli_fetch_array($Respuesta3))
					{
						$Filas++;				
					}
					echo "<td align='right' rowspan='".$Filas."'>".$Fila2["total_paquetes"]."</td>";
					$TotalPaquetes = $TotalPaquetes + $Fila2["total_paquetes"];
				}
			}			
			$conta_a_co = 0;$conta_a_enm = 0;$conta_r = 0;$conta_s = 0;$Recargo = "";$estado = 0;					
			reset($ArrLeyes);
			//foreach($ArrLeyes as $k => $v)
			foreach($ArrLeyes as $k => $v)
			{
				$Consulta = "SELECT t1.valor, t1.signo ";
				$Consulta.= " from sec_web.tmp_leyes_grupos t1 left join proyecto_modernizacion.sub_clase t2 ";
				$Consulta.= " on t2.cod_clase = '3009' and t1.cod_leyes = t2.nombre_subclase ";
				$Consulta.= " where t1.cod_grupo = '".$Fila["cod_grupo"]."'";
				$Consulta.= " and t1.fecha = '".$Fila["fecha"]."'";
				$Consulta.= " and t1.nro_solicitud = '".$Fila["nro_solicitud"]."'";
				$Consulta.= " and t1.cod_leyes = '".$v."'";
				$Consulta.= " order by t2.valor_subclase2 ";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					echo "<td>".$Fila2["signo"]."".number_format($Fila2["valor"],1,",",".")."</td>\n";
					//echo "<td width='20%'>TIPO SUB PRODUCTO(CALIDAD) </td>\n";
					//*************NUEVO************
					$Consulta = "SELECT * FROM cal_web.clasificacion_catodos WHERE cod_leyes = '".$v."' ";
					//echo $Consulta;
					$Rs = mysqli_query($link, $Consulta);
					$cont = 0;
					if($fila = mysqli_fetch_array($Rs))
					{
						if ($Fila2["valor"] <= $fila["grado_a_codelco"])
							$conta_a_co = 1;
						else	
							if (($Fila2["valor"] <= $fila["grado_a_enami"])&&($Fila2["valor"] > $fila["grado_a_codelco"])) 
								$conta_a_enm = 1;
							else	
								if ($Fila2["valor"] <= $fila["rechazo"]&&($Fila2["valor"] > $fila["grado_a_enami"]))
									$conta_r = 1;
								else	
									if ($Fila2["valor"] <= $fila["estandar"]&&($Fila2["valor"] > $fila["rechazo"]))
										$conta_s = 1;
						$cont = $cont + 1;
					}
				}
				else
				{
					echo "<td>&nbsp;</td>\n";
				}
				
			}
			if($cont != 0)
			{
				if ($conta_s == 1)
					$Class = "ESTANDAR";
				else
					if ($conta_r == 1)
						$Class = "RECHAZO";
					else
						if($conta_a_enm == 1)
							$Class = "GRADO A ENAMI";
						else
							$Class = "GRADO A";
			}
			echo "<td>".$Class."</td>\n";
			echo "</tr>\n";
			
			$CodGrupoAnt = $Fila["cod_grupo"];
		}
		$Consulta = "SELECT distinct ifnull(t2.cod_grupo,'00') as cod_grupo ";
		$Consulta.= " from sec_web.lote_catodo t1	inner join";
		$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
		$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
		$Consulta.= " and t1.num_bulto = '".$Lote."'";
		$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

		$Consulta.= " order by t2.cod_grupo";
		$Respuesta = mysqli_query($link, $Consulta);			
		while ($Fila = mysqli_fetch_array($Respuesta))
		{	
			$Encontro = false;
			reset($ArrGrupos);
			//while (list($k,$v)=each($ArrGrupos))
			foreach($ArrGrupos as $k => $v)				
			{
				if ($v[0] == $Fila["cod_grupo"])
				{
					$Encontro = true;
				}
			}
			if (($Encontro == false) && ($Fila["cod_grupo"] != "00") && ($Fila["cod_grupo"] != "0") && ($Fila["cod_grupo"] != "") && (!is_null($Fila["cod_grupo"])))
			{
				echo "<tr>\n";
				$Consulta = "SELECT * from cal_web.solicitud_analisis ";
				$Consulta.= " where nro_solicitud = '".$Fila["nro_solicitud"]."'";
				$Consulta.= " and (recargo = '' or isnull(recargo))";
				$Respuesta2 = mysqli_query($link, $Consulta);			
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					if ($Fila2["estado_actual"] <> 6)
						echo "<td align='center' bgcolor='RED'>";
					else
						echo "<td align='center'>";
				}
				else
				{
					echo "<td align='center'>";
				}
				echo "<a href=\"sec_con_certificado_det_pqtes.php?Mes=".$Mes."&Lote=".$Lote."&Grupo=".$Fila["cod_grupo"]."\">".$Fila["cod_grupo"]."</a>";
				echo "</td>\n";					
				echo "<td align='right'>&nbsp;</td>";
				if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
				{
					$Consulta = "SELECT t1.grupo, sum(peso_produccion)  as total_paquetes";
					$Consulta.= " from sec_web.catodos_desc_normal t1 ";
					$Consulta.= " where t1.grupo = '".$Fila["cod_grupo"]."'";
					$Consulta.= " and t1.cod_bulto = '".$Mes."'";
					$Consulta.= " and t1.num_bulto = '".$Lote."'";
					$Consulta.= " group by t1.grupo ";
				}
				else
				{
					if (strlen($Fila["cod_grupo"]) > 2)
					{
						$Consulta = "SELECT COUNT(*)  as total_paquetes";
						$Consulta.= " from sec_web.lote_catodo t1	inner join";
						$Consulta.= " sec_web.paquete_catodo_externo t2 ";
						$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
						$Consulta.= " where t1.cod_bulto = '".$Mes."'";
						$Consulta.= " and t1.num_bulto = '".$Lote."'";
						$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

						$Consulta.= " and t2.lote_origen = '".$Fila["cod_grupo"]."'";
						$Consulta.= " order by t2.lote_origen";
					}
					else
					{
						$Consulta = "SELECT COUNT(*)  as total_paquetes";
						$Consulta.= " from sec_web.lote_catodo t1	inner join";
						$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
						$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
						$Consulta.= " and t1.num_bulto = '".$Lote."'";
						$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

						$Consulta.= " and t2.cod_grupo = '".$Fila["cod_grupo"]."'";
						$Consulta.= " order by t2.cod_grupo";
					}				
				}
				$Respuesta2 = mysqli_query($link, $Consulta);
				$Paquetes = "";			
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					if ($CodGrupoAnt != $Fila["cod_grupo"])
					{
						$Filas = 0;
						$Consulta = "SELECT distinct cod_grupo, fecha, nro_solicitud, fecha2, fecha_creacion_paquete ";
						$Consulta.= " from sec_web.tmp_leyes_grupos ";
						$Consulta.= " where cod_grupo = '".$Fila["cod_grupo"]."'";
						$Respuesta3 = mysqli_query($link, $Consulta);					
						while ($Fila3 = mysqli_fetch_array($Respuesta3))
						{
							$Filas++;				
						}
						echo "<td align='right' rowspan='".$Filas."'>".$Fila2["total_paquetes"]."</td>";
						$TotalPaquetes = $TotalPaquetes + $Fila2["total_paquetes"];
					}
					echo "<td align='right'>".$Fila2["total_paquetes"]."</td>";
					$TotalPaquetes = $TotalPaquetes + $Fila2["total_paquetes"];
				}
				else
				{
					echo "<td align='right'>0</td>";
				}				
				echo "</tr>";
				$CodGrupoAnt = $Fila["cod_grupo"];
			}
		}
	?>
  <tr> 
<?php  if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
	{
		$SpanColumnas = 4;
	}
	else
	{
		$SpanColumnas = 2;
	}
?>	
    <td colspan="<?php echo $SpanColumnas; ?>"><strong>TOTALES</strong></td>
    <td align="right"><strong><?php echo $TotalPaquetes; ?></strong></td>
    <?php
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
	if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
	{	
		$Consulta = "create table `sec_web`.`tmp_leyes_catodos` (key ind01(cod_paquete,num_paquete)) as ";
		$Consulta.= " SELECT t1.cod_grupo as cod_paquete, t1.fecha as num_paquete, t1.peso_produccion as peso_paquete, ";
		$Consulta.= " t1.cod_leyes, t1.valor, t1.signo ";
		$Consulta.= " from sec_web.tmp_leyes_grupos t1 ";
		//echo $Consulta;
	}
	else
	{
		if (($Grupo == "00") || ($Grupo == "0") || ($Grupo == ""))
		{
			$Consulta = "create table `sec_web`.`tmp_leyes_catodos` (key ind01(cod_paquete,num_paquete)) as ";
			$Consulta.= " SELECT t1.cod_paquete, t1.num_paquete, t2.peso_paquete as peso_paquete, ";
			$Consulta.= " t3.cod_leyes, t3.valor, t2.cod_grupo, t3.signo ";
			$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo_externo t2  ";
			$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete  ";
			$Consulta.= " inner join sec_web.tmp_leyes_grupos t3 on t2.lote_origen = t3.cod_grupo ";
			//$Consulta.= " and t2.fecha_creacion_paquete = t3.fecha_creacion_paquete ";
			$Consulta.= " where t1.cod_bulto = '".$Mes."' and t1.num_bulto = '".$Lote."'  ";
			$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and year(t1.fecha_creacion_paquete) = '".$Ano."'";

			$Consulta.= " order by t1.cod_paquete, t1.num_paquete, t3.cod_leyes ";
			//echo $Consulta;
		}
		else
		{
			$Consulta = "create table `sec_web`.`tmp_leyes_catodos` (key ind01(cod_paquete,num_paquete)) as ";
			$Consulta.= " SELECT t1.cod_paquete, t1.num_paquete, t2.peso_paquetes as peso_paquete, ";
			$Consulta.= " t3.cod_leyes, t3.valor, t2.cod_grupo, t3.signo ";
			$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2  ";
			$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete  ";
			$Consulta.= " inner join sec_web.tmp_leyes_grupos t3 on t2.cod_grupo = t3.cod_grupo ";
			$Consulta.= " and t2.fecha_creacion_paquete = t3.fecha_creacion_paquete ";
			$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."' and t1.num_bulto = '".$Lote."'  ";
			$Consulta.= " order by t1.cod_paquete, t1.num_paquete, t3.cod_leyes ";		
		}
	}
	mysqli_query($link, $Consulta);
	//ACTUALIZA TABLA PARA TRABAJAR CON LOS VALORES <
	$Consulta = "SELECT * ";
	$Consulta.= " from sec_web.tmp_leyes_catodos t1 inner join proyecto_modernizacion.sub_clase t2 ";
	$Consulta.= " on t2.cod_clase = '3009' and t1.cod_leyes = t2.nombre_subclase ";
	$Consulta.= " where not isnull(t2.valor_subclase6) and t2.valor_subclase6 <> '' and t2.valor_subclase6 <> 0";
	$Consulta.= " order by t2.valor_subclase2";
	//echo "CCC".$Consulta;
	$Respuesta2 = mysqli_query($link, $Consulta);
	while ($Fila2 = mysqli_fetch_array($Respuesta2))
	{
		if (($Fila2["valor"] <= $Fila2["valor_subclase6"]) && ($Fila2["signo"] == "<"))
		{			
			$Actualizar = "UPDATE sec_web.tmp_leyes_catodos set ";
			$Actualizar.= " valor = '".$Fila2["valor_subclase7"]."'";
			$Actualizar.= " where cod_paquete = '".$Fila2["cod_paquete"]."'";
			$Actualizar.= " and num_paquete = '".$Fila2["num_paquete"]."'";
			$Actualizar.= " and cod_leyes = '".$Fila2["cod_leyes"]."'";
			mysqli_query($link, $Actualizar);
		}
	}
	//-----------------------------------------------
	//VALOR LEY
	$Consulta = "SELECT t1.cod_leyes, sum(t1.peso_paquete) as peso_paquetes, sum(t1.peso_paquete * t1.valor) as fino";
	$Consulta.= " from sec_web.tmp_leyes_catodos t1 inner join proyecto_modernizacion.sub_clase t2 ";
	$Consulta.= " on t2.cod_clase = '3009' and t1.cod_leyes = t2.nombre_subclase ";
	$Consulta.= " group by t1.cod_leyes";
	$Consulta.= " order by t2.valor_subclase2";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{				
		//PESO LOTE
		$PesoLote = 0;
		$Consulta = "SELECT sum(t2.peso_paquetes) as peso_lote";
		$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2";
		$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
		$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."' and num_bulto = '".$Lote."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$PesoLote = $Fila2["peso_lote"];
		}
		if (($PesoLote != 0) && ($Fila["fino"] != 0))
			$ValorLey = $Fila["fino"] / $Fila["peso_paquetes"];
		else
			$ValorLey = 0;
		//CANTIDAD DE DECIMALES POR COD_LEYES					
		if (($Fila["cod_leyes"] == "26") || ($Fila["cod_leyes"] == "48"))
		{
			$NumDecimales = 0;
		}						
		else
		{ 
			$NumDecimales = 1;
		}
		//SIGNO
		$Signo = "=";
		$Consulta = "SELECT * ";
		$Consulta.= " from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '3009' ";
		$Consulta.= " and (not isnull(valor_subclase6) and valor_subclase6 <> '' and valor_subclase6 <> 0)";
		$Consulta.= " and nombre_subclase = '".$Fila["cod_leyes"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			if (round($ValorLey,3) < round(($Fila2["valor_subclase6"] * 1),3))
				$Signo = "<";						
		}
		if ($Signo == "<")						
			echo "<td><strong>".$Signo."".number_format(round($Fila2["valor_subclase6"],1),$NumDecimales,",","")."</strong></td>\n";
		else
			echo "<td><strong>".$Signo."".number_format(round($ValorLey,1),$NumDecimales,",","")."</strong></td>\n";
	}		
	
?>
  </tr>
</table>
<div align="center"><br>
  <br>
  <input name="BtnImprimir" type="button" value="Imprimir" onClick="window.print();" style="width:70px">
  <input name="BtnSalir" type="button" value="Salir" onClick="window.close();" style="width:70px">
</div>
</body>
</html>
