<?php   
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename="";
	if ( preg_match( '/MSIE/i', $userBrowser ) ) {
		$filename = urlencode($filename);
	}
	$filename = iconv('UTF-8', 'gb2312', $filename);
	$file_name = str_replace(".php", "", $file_name);
	header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
	header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
	
	header("content-disposition: attachment;filename={$file_name}");
	header( "Cache-Control: public" );
	header( "Pragma: public" );
	header( "Content-type: text/csv" ) ;
	header( "Content-Dis; filename={$file_name}" ) ;
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	$CookieRut=$_COOKIE["CookieRut"];

	if(isset($_REQUEST["Buscar"])) {
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar =  "";
	}
	if(isset($_REQUEST["Leyes"])) {
		$Leyes = $_REQUEST["Leyes"];
	}else{
		$Leyes = "";
	}
	if(isset($_REQUEST["Limite"])) {
		$Limite = $_REQUEST["Limite"];
	}else{
		$Limite =  "";
	}

	if(isset($_REQUEST["CmbAno"])) {
		$CmbAno = $_REQUEST["CmbAno"];
	}else{
		$CmbAno =  date("Y");
	}
	if(isset($_REQUEST["CmbMes"])) {
		$CmbMes = $_REQUEST["CmbMes"];
	}else{
		$CmbMes = date("m");
	}
	if(isset($_REQUEST["CmbDias"])) {
		$CmbDias = $_REQUEST["CmbDias"];
	}else{
		$CmbDias =  date("d");
	}

	if(isset($_REQUEST["CmbAnoT"])) {
		$CmbAnoT = $_REQUEST["CmbAnoT"];
	}else{
		$CmbAnoT =  date("Y");
	}
	if(isset($_REQUEST["CmbMesT"])) {
		$CmbMesT = $_REQUEST["CmbMesT"];
	}else{
		$CmbMesT = date("m");
	}
	if(isset($_REQUEST["CmbDiasT"])) {
		$CmbDiasT = $_REQUEST["CmbDiasT"];
	}else{
		$CmbDiasT =  date("d");
	}
	if(isset($_REQUEST["NomLeyes"])) {
		$NomLeyes = $_REQUEST["NomLeyes"];
	}else{
		$NomLeyes = "";
	}
	
	$TxtLeyes=$Leyes;
	$LimitIni=$Limite;
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 40;

	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	set_time_limit(5000);

?>
<html>
<head>
<title>Consulta Analisis por Producto</title>
</head>
<body>
<form name="FrmConsultaAnalisisProducto" method="post" action="">
	<table>
		<tr>
		<td><br>
			<?php
			$RutTB=0;
			if (($Buscar=='S') and ($TxtLeyes!=''))
			{
				if ($TxtLeyes!='')
				{
					$ArregloDescrip=explode('-',$TxtLeyes);
					reset($ArregloDescrip);
					$Largo=count($ArregloDescrip);
					for ($i=0;$i<$Largo;$i++)
					{
						//$Consulta="select t2.cod_leyes from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.nro_solicitud=t2.nro_soliditud  ";
					//	$Consulta.=" where not isnull(t1.nro_solicitud)  and t1.estado_actual !='7' and t1.estado_actual !='16' and  t1.fecha_hora between '".$FechaI."' and '".$FechaT."' and  t2.cod_leyes=".$ArregloDescrip[$i];
						$Consulta="select abreviatura from proyecto_modernizacion.leyes where cod_leyes=".$ArregloDescrip[$i];
						//echo $Consulta;
						$Respuesta=mysqli_query($link, $Consulta);
						if($Fila=mysqli_fetch_array($Respuesta))
						{
							$NomLeyes=$NomLeyes." ".$Fila["abreviatura"];
						}
					}
				}
						
				if (($CmbAno=="") || ($CmbMes=="")|| ($CmbDias==""))
				{
					$FechaI=date("Y-m-d")." 00:00:01";
					$FechaT=date("Y-m-d")." 23:59:59";
				}
				else
				{
					if(strlen($CmbDias)==1){
						$CmbDias= "0".$CmbDias;
					}
					if(strlen($CmbMes)==1){
						$CmbMes= "0".$CmbMes;
					}
					if(strlen($CmbDiasT)==1){
						$CmbDiasT= "0".$CmbDiasT;
					}
					if(strlen($CmbMesT)==1){
						$CmbMesT= "0".$CmbMesT;
					}
					$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
					$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
				}	
				
				$ArregloAux=explode('-',$TxtLeyes);
				//$ArregloAux=explode('-',$LeyesExistentes);
				reset($ArregloAux);
				$Arreglo=array();
				$Largo=count($ArregloAux);
				$AnchoTabla=0; //WSO
				for ($i=0;$i<$Largo;$i++)
				{
						$Consulta="select t2.cod_leyes,t3.abreviatura from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.nro_solicitud=t2.nro_solicitud inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes=t3.cod_leyes  ";
						$Consulta.=" where not isnull(t1.nro_solicitud)  and t1.estado_actual !='7' and t1.estado_actual !='16' and  t1.fecha_hora between '".$FechaI."' and '".$FechaT."' and  t2.cod_leyes='".$ArregloDescrip[$i]."' limit 1";
					//	$Consulta="select abreviatura from proyecto_modernizacion.leyes where cod_leyes=".$ArregloDescrip[$i];
					//	echo $Consulta."<br>";	
					//	$Consulta="select abreviatura from proyecto_modernizacion.leyes where cod_leyes=".$ArregloAux[$i];
					$Respuesta=mysqli_query($link, $Consulta);
					$LeyesExistentes="";
					if($Fila=mysqli_fetch_array($Respuesta))
					{
						$Arreglo[$ArregloAux[$i]][0]=$Fila["abreviatura"];
						$Arreglo[$ArregloAux[$i]][1]=$ArregloAux[$i];
						$AnchoTabla=$AnchoTabla	+ 50;
						$LeyesExistentes=$LeyesExistentes.$Fila['cod_leyes']."-";
					}
				}
				$AnchoTabla=$AnchoTabla	+ 500;
				if (count($Arreglo))
				{				
					
					echo "<table  border='1' >";
						echo "<tr>";
						echo "<td>Producto</td>";
						echo "<td>SubProducto</td>";
						echo "<td>Cant. Solicitudes</td>";
						echo "<td>Cant. Solicitudes Directas</td>";
						echo "<td>Cant. Solicitudes Finalizadas</td>";
						echo "<td>% Solicitudes Finalizadas</td>";
						reset($Arreglo);
						ksort($Arreglo);
							//while(list($Clave,$Valor)=each($Arreglo))
							$CodLeyes="";
							foreach($Arreglo as $Clave => $Valor)
							{
								echo "<td width='50' align='center'>";
								if ($Valor[0]!='')
								{
									echo $Valor[0];
									//$CodLeyes=$CodLeyes." t2.cod_leyes='".$Valor[1]."' or ";
									$CodLeyes=" t2.cod_leyes='".$Valor[1]."' or ";
								}
								else
								{
									echo "&nbsp;";
								}	
								echo "</td>";
							}
							$CodLeyes=substr($CodLeyes,0,strlen($CodLeyes)-3);
							// apura consulta
							$RutTB = substr($CookieRut,0,8);
							//echo $RutTB;
							$ConsTB = "SHOW TABLES FROM `cal_web`";
							$RespTB = mysqli_query($link, $ConsTB);
							while ($FilaTB = mysqli_fetch_array($RespTB))
							{
								if ($FilaTB["Tables_in_cal_web"] == "tmp_paso_".$RutTB)
								{
									$Borra = "DROP TABLE cal_web.tmp_paso_".$RutTB;
									mysqli_query($link, $Borra);
									//echo $Borra;
									
								}
							}
							$Consulta="create table cal_web.tmp_paso_".$RutTB." as select * from cal_web.solicitud_analisis ";
							$Consulta.=" where not isnull(nro_solicitud)  and estado_actual !='7' and estado_actual !='16' and  fecha_hora between '".$FechaI."' and '".$FechaT."' ";
							//echo $Consulta."<br>";
							mysqli_query($link, $Consulta);
							// hasta aca
							echo "</tr>";
						//echo "</table>";
						//echo "<table width='$AnchoTabla' border='1'>";
						
						//------QUERY MODIFICADA EN EL GROUP ANTES group by t2.producto,t3.subproducto ahora group by producto,subproducto
						//------DVS / LRC 13-06-2014
						function ObtenerTotalDirecta($Producto,$Subproducto,$Estado,$Directa,$link)
						{
							global $RutTB;
								$valor=0;
						$Consulta="select STRAIGHT_JOIN count(t1.nro_solicitud) as Cantidad from cal_web.tmp_paso_".$RutTB." t1 "; //cal_web.solicitud_analisis t1 ";
						$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
						$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
							$Consulta=$Consulta." inner join cal_web.estados_por_solicitud t4 on t1.nro_solicitud=t4.nro_solicitud and t4.cod_estado='12' ";
						$Consulta=$Consulta." where not isnull(t1.nro_solicitud)  and  t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$Subproducto."' and t1.recargo in (' ','','0')";
						$RespuestaFunction=mysqli_query($link, $Consulta);
							if ($FilaFunction=mysqli_fetch_array($RespuestaFunction))
							{
								$valor=$FilaFunction['Cantidad'];
							}
							return $valor;
						}
					
						function ObtenerTotal($Producto,$Subproducto,$Estado,$Directa,$link)
						{
							global $RutTB;
								$valor=0;
						$Consulta="select STRAIGHT_JOIN count(t1.nro_solicitud) as Cantidad from cal_web.tmp_paso_".$RutTB." t1 "; //cal_web.solicitud_analisis t1 ";
						$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
						$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
						$Consulta=$Consulta." where not isnull(t1.nro_solicitud)  and  t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$Subproducto."' and t1.recargo in (' ','','0')";
						if($Estado!='')
							$Consulta=$Consulta." and t1.estado_actual in ('6','32')"; // SOLICITUDES EN ESTADO TERMINADO
						$RespuestaFunction=mysqli_query($link, $Consulta);
							if ($FilaFunction=mysqli_fetch_array($RespuestaFunction))
							{
								$valor=$FilaFunction['Cantidad'];
							}
							return $valor;
						}
						$Consulta="select STRAIGHT_JOIN distinct t1.cod_producto,t1.cod_subproducto,t2.descripcion as producto,t3.descripcion as subproducto from cal_web.tmp_paso_".$RutTB." t1 "; //cal_web.solicitud_analisis t1 ";
						$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
						$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
						$Consulta=$Consulta." where not isnull(t1.nro_solicitud)  and  t1.fecha_hora between '".$FechaI."' and '".$FechaT."' group by producto,subproducto";
						$Respuesta2=mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta2))
						{
							$TotalSolicitud=ObtenerTotal($Fila["cod_producto"],$Fila["cod_subproducto"],'','',$link);
							$TotalSolicitudDirecta=ObtenerTotalDirecta($Fila["cod_producto"],$Fila["cod_subproducto"],'','S',$link);
							$TotalSolicitudTerminada=ObtenerTotal($Fila["cod_producto"],$Fila["cod_subproducto"],'6','',$link);
							$PorcentajeFinalizado=($TotalSolicitudTerminada*100)/$TotalSolicitud;
							echo "<tr align='center'>";
								echo "<td>".$Fila["producto"]."</td>";
								echo "<td>".$Fila["subproducto"]."</td>";
								echo "<td>".$TotalSolicitud."</td>";
								echo "<td>".$TotalSolicitudDirecta."</td>";
								echo "<td>".$TotalSolicitudTerminada."</td>";
								echo "<td>".number_format($PorcentajeFinalizado,2,',','.')." % </td>";
						
								$Consulta="select STRAIGHT_JOIN t2.cod_leyes,count(t2.cod_leyes)as total from cal_web.tmp_paso_".$RutTB." t1 inner join cal_web.leyes_por_solicitud t2 on ";
								$Consulta=$Consulta." t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo";
								$Consulta=$Consulta." inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes=t3.cod_leyes ";
								$Consulta=$Consulta." where  t1.cod_producto=".$Fila["cod_producto"]." and t1.cod_subproducto=".$Fila["cod_subproducto"]." and (".$CodLeyes.") and t1.fecha_hora between '".$FechaI."' and '".$FechaT."' group by t2.cod_leyes";
								//	echo $Consulta."</br>";
								$Respuesta3=mysqli_query($link, $Consulta);
								reset($Arreglo);
								//while(list($Clave,$Valor)=each($Arreglo))
								foreach($Arreglo as $Clave => $Valor)
								{
									$Arreglo[$Clave][0]="&nbsp;";
									$Arreglo[$Clave][1]="&nbsp;";				
								}
								while($FilaLeyes=mysqli_fetch_array($Respuesta3))
								{
									$Arreglo[$FilaLeyes["cod_leyes"]][0]=$FilaLeyes["total"];
									$Arreglo[$FilaLeyes["cod_leyes"]][1]=$FilaLeyes["total"];
								}
								reset($Arreglo);
								ksort($Arreglo);
								//while(list($Clave,$Valor)=each($Arreglo))
								foreach($Arreglo as $Clave => $Valor)
								{
									echo "<td>";
									echo $Valor[1];
									echo "</td>";
								}
							echo "</tr>";
						}
					echo "</table>";
				}	
			}	
			?>
			<br>
			<br>
		</td>
	    </tr>
    </table>
</form>
</body>
</html>
<?php 
          $ConsTB = "SHOW TABLES FROM cal_web";
          $RespTB = mysqli_query($link, $ConsTB);
          while ($FilaTB = mysqli_fetch_array($RespTB))
          {
               if ($FilaTB["Tables_in_cal_web"] == "tmp_paso_".$RutTB)
               {
                    $Borra = "DROP TABLE cal_web.tmp_paso_".$RutTB;
                   mysqli_query($link, $Borra);
                            //echo $Borra;
                }
           }
?>
