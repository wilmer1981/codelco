<?php         ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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
	include("../principal/conectar_principal.php");
	if ($CheckEnabal == "S")
		$Enabal = "S";
	else $Enabal = "N";
	if ($CmbTipo=="-1")
		$Tipo="";
	else	$Tipo=" and t1.tipo='".$CmbTipo."'";
	if ($CmbTipoAnalisis=="-1")
		$TipoAnalisis="";
	else	$TipoAnalisis=" and t1.cod_analisis='".$CmbTipoAnalisis."'";
	$Consulta1 ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
	$Respuesta1 = mysqli_query($link, $Consulta1);
	$Fila1=mysqli_fetch_array($Respuesta1);
	$Nivel=$Fila1["nivel"];
	$Consulta = $Consulta." from cal_web.solicitud_analisis t1 ";
	$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
	$Consulta = $Consulta." t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo inner join 	proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes";
	$Consulta = $Consulta." where (t1.cod_periodo='".$CmbPeriodo."')".$Tipo.$TipoAnalisis;
	$Consulta = $Consulta." and (t1.estado_actual <> '7') ";
	//$Consulta = $Consulta." and (t1.estado_actual='5' or t1.estado_actual='6' or t1.estado_actual='31' or t1.estado_actual='32') ";
	if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5')||($Nivel=='8'))
	{
		$Consulta = $Consulta."  ";
	}
	else
	{
		$Consulta = $Consulta."  and t1.cod_producto <> 1 ";
	
	}
	
	if ($CmbSubProducto==-2)
	{
		$Consulta=$Consulta." and t1.cod_producto ='".$CmbProductos."'";
	}
	else
	{
		if ($CmbProductos != "-1")
		{
			$Consulta=$Consulta." and t1.cod_producto ='".$CmbProductos."'";
		}
		if ($CmbSubProducto != "-1")
		{
			
			$Consulta=$Consulta." and t1.cod_subproducto ='".$CmbSubProducto."'";
		}
	}	
	
	
	if ($CmbCCosto != "-1")
	{
		$Consulta = $Consulta." and t1.cod_ccosto='".$CmbCCosto."'";
	}
	if ($CmbAreasProceso != "-1")
	{
		$Consulta = $Consulta." and t1.cod_area=".$CmbAreasProceso;
	}
	//$FechaI=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
	//$FechaT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
	$Consulta = $Consulta." and (t1.fecha_muestra between '".$FechaI."' and '".$FechaT."')";	
	if ($Enabal=='S')
	{
		$Consulta = $Consulta." and (t1.enabal='S')";
	}
	$Seleccion1= "select distinct t3.cod_leyes,t4.abreviatura";
	$Seleccion2= "select distinct t1.nro_solicitud,t1.recargo ";
	$Criterio=$Seleccion1.$Consulta." order by t3.cod_leyes";
	$Respuesta1=mysqli_query($link, $Criterio);
	$Arreglo=array();	
	while($Fila1=mysqli_fetch_array($Respuesta1))
	{
		$Arreglo[$Fila1["cod_leyes"]][0]="";	
		$Arreglo[$Fila1["cod_leyes"]][1]=$Fila1["abreviatura"];
		$Arreglo[$Fila1["cod_leyes"]][2]="";
		
	}
	$Criterio=$Seleccion2.$Consulta." order by t1.fecha_muestra,t1.nro_solicitud";;
	$Respuesta2=mysqli_query($link, $Criterio);
?>
<html>
<head>
<title>Consulta General</title>
</head>
<body>
<form name="FrmConsultaGeneral" method="post" action="">
	  <table width="755">
          <tr> 
            <td><strong>C.Costo:</strong></td>
            <td colspan="15"><?php 
			$ConsultaN = "select centro_costo,descripcion ";
			$ConsultaN.= " from centro_costo  where mostrar_calidad='S' and centro_costo = '".$CmbCCosto."' order by centro_costo";
			$RespuestaN = mysqli_query ($link, $ConsultaN);
			if ($FilaN=mysqli_fetch_array($RespuestaN))
			{
				$CCosto = $FilaN[centro_costo]." - ".ucwords(strtolower($FilaN["descripcion"]));
			}
			else
			{
				$CCosto="";
			}
			echo $CCosto;
			?></td>
          </tr>
          <tr> 
            <td><strong>Area:</strong></td>
            <td colspan="15"><?php 
			$ConsultaN = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase ";
			$ConsultaN.= "where cod_clase = '3' and cod_subclase= '".CmbAreasProceso."' order by cod_subclase";
			$RespuestaN = mysqli_query ($link, $ConsultaN);
			if ($FilaN=mysqli_fetch_array($RespuestaN))
			{
				$Area = ucwords(strtolower($FilaN["nombre_subclase"]));
			}
			else
			{
				$Area="";
			}
			echo $Area;
			?></td>
          </tr>
          <tr> 
            <td><strong>Tipo Analisis:</strong></td>
            <td colspan="15"> 
              <?php
			  if ($CmbTipoAnalisis=='-1')
			  {
				 echo "Todos";
			  }
			  else
			  {	
				if ($CmbTipoAnalisis=='1')
				 {
					echo "Quimico";  
				 }
				 else
				 {
					echo "Fisico";  
				 }
			  } 	
			?>
            </td>
          </tr>
          <tr> 
            <td width="17%"><strong>Tipo Producto:</strong></td>
            <td colspan="15"><?php 
			$ConsultaN="select cod_producto,descripcion from productos where cod_producto='".$CmbProductos."' order by descripcion"; 
			$RespuestaN = mysqli_query ($link, $ConsultaN);
			if ($FilaN=mysqli_fetch_array($RespuestaN))
			{
				$Producto = ucwords(strtolower($FilaN["descripcion"]));
			}
			else
			{
				$Producto="";
			}
			echo $Producto;
			?></td>
          </tr>
          <tr> 
            <td><strong>Tipo SubProducto:</strong></td>
            <td colspan="15"><?php 
			$ConsultaN="select cod_subproducto,descripcion from subproducto ";
			$ConsultaN.="where cod_producto = '".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."'"; 
			$RespuestaN = mysqli_query ($link, $ConsultaN);
			if ($FilaN=mysqli_fetch_array($RespuestaN))
			{
				$SubProducto = ucwords(strtolower($FilaN["descripcion"]));
			}
			else
			{
				$SubProducto="";
			}
			echo $SubProducto;
			?></td>
          </tr>
          <tr> 
            <td><strong>Tipo Muestra:</strong></td>
            <td colspan="15"> 
              <?php 
				$Con="select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase=1005";
				$Con=$Con." and cod_subclase = '".$CmbTipo."'";
				$Respuesta= mysqli_query($link, $Con);
				$Fila= mysqli_fetch_array($Respuesta); 
				$Tipo= $Fila["nombre_subclase"];
				if ($CmbTipo=='-1')
				{	
					echo "Todos";
				}
				else
				{	
					echo $Tipo ;
				}
			?>
            </td>
          </tr>
          <tr> 
            <td><strong>Periodo:</strong></td>
            <td colspan="15"> 
              <?php 
				$ConsultaN = "select * from proyecto_modernizacion.sub_clase where cod_clase = 2 and cod_subclase = '".$CmbPeriodo."' order by cod_subclase";
				$RespuestaN= mysqli_query($link, $ConsultaN);
				while ($FilaN = mysqli_fetch_array($RespuestaN))
				{
					$Periodo=$FilaN["nombre_subclase"];
				}
				echo $Periodo."&nbsp;&nbsp;&nbsp;&nbsp;";				
     			echo "<strong>Fecha Inicio:</strong> ".substr($FechaI,8,2)."/".substr($FechaI,5,2)."/".substr($FechaI,0,4)." <strong>Fecha Termino:</strong> ".substr($FechaT,8,2)."/".substr($FechaT,5,2)."/".substr($FechaT,0,4);
			?>
            </td>
          </tr>
        </table>
	    <br>
        <table border='1'>
			<tr>
			<?php				
				if (count($Arreglo)>0)
				{
					echo "<td align='center'>S.A</td>";
					echo "<td align='center'>Id.Muestra</td>";
					//SE ASIGNA LA CABECERA DE LA LISTA CONTENIDA EN EL ARREGLO	
					reset($Arreglo);
					while(list($Clave,$Valor)=each($Arreglo))
					{
						echo "<td>";
						echo $Valor[0]."Signo";
						echo "</td>";
						echo "<td>";
						echo $Valor[1];
						echo "</td>";
						echo "<td>";
						echo $Valor[2]."Unidad";
						echo "</td>";
					}
?>					
					<td align='center'>Agrupacion</td>
					<td align='center'>Fecha Muestra</td>
					<td align='center'>Producto</td>
					<td align='center'>SubProducto</td>
					<td align='center'>Peso Muestra</td>
					<td align='center'>Observacion</td>
					</tr>
<?php					
					while ($Fila=mysqli_fetch_array($Respuesta2))
					{
						echo "<tr>";
						if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==""))
						{
							echo "<td align='rigth'>".$Fila["nro_solicitud"]."</td>";
							$Consulta ="select t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra,t1.observacion from cal_web.solicitud_analisis t1 ";
							$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
							$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto "; 
							$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"];
							$Resultado=mysqli_query($link, $Consulta);
							$FilaDatos=mysqli_fetch_array($Resultado);
							//echo "<td align='left'>".$FilaDatos["nombre_subclase"]."</td>";							
							echo "<td align='center'>".$FilaDatos["id_muestra"]."</td>";							
							//echo "<td align='center'>".$FilaDatos["fecha_muestra"]."</td>";
							//echo "<td align='center'>".$FilaDatos["producto"]."</td>";
							//echo "<td align='center'>".$FilaDatos["subproducto"]."</td>";
						}
						else
						{
							echo "<td align='rigth'>".$Fila["nro_solicitud"]."-".$Fila["recargo"]."</td>";								
							$Consulta ="select t1.cod_producto,t1.cod_subproducto,t4.nombre_subclase,t1.fecha_hora,t1.id_muestra,t2.abreviatura as producto,t3.abreviatura as subproducto,t1.fecha_muestra,t1.observacion from cal_web.solicitud_analisis t1 ";
							$Consulta=$Consulta." inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
							$Consulta=$Consulta." inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
							$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t4 on t1.agrupacion = t4.cod_subclase and t4.cod_clase='1004' where t1.nro_solicitud=".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."'";
							$Resultado=mysqli_query($link, $Consulta);
							$FilaDatos=mysqli_fetch_array($Resultado);
							//echo "<td align='left'>".$FilaDatos["nombre_subclase"]."</td>";							
							echo "<td align='center'>".$FilaDatos["id_muestra"]."</td>";									
							//echo "<td align='center'>".$FilaDatos["fecha_muestra"]."</td>";
							//echo "<td align='center'>".$FilaDatos["producto"]."</td>";
							//echo "<td align='center'>".$FilaDatos["subproducto"]."</td>";
						}	
						//SE LIMPIA EL ARREGLO
						reset($Arreglo);
						while(list($Clave,$Valor)=each($Arreglo))
						{
							$Arreglo[$Clave][1]="&nbsp;";
							$Arreglo[$Clave][2]="&nbsp;";
							$Arreglo[$Clave][3]="&nbsp;";				
						}
						//SE ASIGNAN LOS VALORES AL ARREGLO
						$Consulta ="select t1.cod_leyes,t1.valor,t1.signo,t2.abreviatura from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.nro_solicitud = ".$Fila["nro_solicitud"]." and t1.recargo='".$Fila["recargo"]."' ";
						$Respuesta3=mysqli_query($link, $Consulta);
						while($Fila3=mysqli_fetch_array($Respuesta3))
						{
							if ($Fila3["signo"]=="N")
							{
								$Arreglo[$Fila3["cod_leyes"]][2]="ND";
							}
							else
							{
								if ($Fila3["signo"]=="=")
								{
									$Valor=number_format($Fila3["valor"],3,",","");
									$Arreglo[$Fila3["cod_leyes"]][2]=$Valor;
									$Arreglo[$Fila3["cod_leyes"]][3]=$Fila3["abreviatura"];
								}
								else
								{
									$Valor=number_format($Fila3["valor"],3,",","");
									$Arreglo[$Fila3["cod_leyes"]][1]=$Fila3["signo"];
									$Arreglo[$Fila3["cod_leyes"]][2]=$Valor;
									$Arreglo[$Fila3["cod_leyes"]][3]=$Fila3["abreviatura"];
								}
							}		
						}
						//SE LLENA LA LISTA CON VALORES DEL ARREGLO
						reset($Arreglo);
						while(list($Clave,$Valor)=each($Arreglo))
						{
							echo "<td>";
							//musetro el valor en la posicion 1  
							echo $Valor[1];
							echo "</td>";
							echo "<td>";
							echo $Valor[2];
							echo "</td>";
							echo "</td>";
							echo "<td>";
							echo $Valor[3];
							echo "</td>";
						}
						echo "<td align='left'>".$FilaDatos["nombre_subclase"]."</td>";							
						echo "<td align='center'>".$FilaDatos["fecha_muestra"]."</td>";
						echo "<td align='center'>".$FilaDatos["producto"]."</td>";
						echo "<td align='center'>".$FilaDatos["subproducto"]."</td>";
						if (($FilaDatos["cod_producto"]=='42')&&(($FilaDatos["cod_subproducto"]=='33')||($FilaDatos["cod_subproducto"]=='35')))
						{
							$pos = strpos(strtoupper($FilaDatos["id_muestra"]),"R-");
							if ($pos === false)
							{
								echo "<td width='60' align='right'>&nbsp;</td>";
								echo "<td width='60'>".$FilaDatos["observacion"]."&nbsp;</td>";
							}
							else
							{
								$Consulta="select pesont_a from rec_web.despachos where lote_a='".substr($FilaDatos["id_muestra"],0,6)."' and recarg_a='".trim(substr($FilaDatos["id_muestra"],$pos+2))."'";
								$Resp=mysqli_query($link, $Consulta);
								if ($FilaPeso=mysqli_fetch_array($Resp))
								{
									echo "<td width='60' align='right'>".$FilaPeso["pesont_a"]."</td>";
									echo "<td width='60'>".$FilaDatos["observacion"]."&nbsp;</td>";
								}
								else
								{
									echo "<td width='60' align='right'>&nbsp;</td>";
									echo "<td width='60'>".$FilaDatos["observacion"]."&nbsp;</td>";
								}
							}
						}
						else
						{
							echo "<td width='60'>&nbsp;</td>";
							echo "<td width='60'>".$FilaDatos["observacion"]."&nbsp;</td>";
						}	
						echo "</tr>";
					}
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td width='60'>".$FilaDatos["observacion"]."&nbsp;</td>";
					echo "</tr>";
				}
			?>
        </table>
</form>
</body>
</html>
