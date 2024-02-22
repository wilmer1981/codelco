<?php
 	        ob_end_clean();
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
	set_time_limit(10000);
?>
<html>
<head>
<title>Control de Calidad Muestra EFI</title>
</head>
<body>
<?php
	$ID_Muestra="EFI";
	$Consulta = "select distinct(t2.cod_leyes), t3.abreviatura ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta.= " and t1.recargo = t2.recargo ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes ";
	$Consulta.= " where t1.nro_solicitud is not null and t1.estado_actual != 16 and t1.id_muestra='".$ID_Muestra."'";
	$Consulta.= " order by t2.cod_leyes ";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	$LargoArreglo = 0;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		$ArregloLeyes[$LargoArreglo][0] = $Row["cod_leyes"];
		$ArregloLeyes[$LargoArreglo][1] = $Row["abreviatura"];
		$LargoArreglo++;
	}
	$Total = ($LargoArreglo * 70) + 550;
?>
<table border="1" cellpadding="0" cellspacing="0">
  <tr align="center" valign="middle"> 
    <td><strong>Solicitud</strong></td>
	<td><strong>Muestra</strong></td>
    <td><strong>Fec.Creacion</strong></td>	
    <td><strong>Producto</strong></td>
    <td ><strong>Subproducto</strong></td>
    <td><strong>Tipo Analisis</strong></td>
    <td><strong>Tipo Muestra</strong></td>
    <td><strong>Periodo</strong></td>
	<td>Fec.Muestra</td>
	<td>Recep.Mue</td>
	<td>Recep.Lab</td>
    <td><strong>Estado</strong></td>
	<td><strong>Fec.Estado.</strong></td>
    <td><strong>C. Costo.</strong></td>
    <?php
	for ($i = 0; $i < $LargoArreglo; $i++)
	{
		echo "<td width='70'>".$ArregloLeyes[$i][1]."</td>\n";
	}
?>
  </tr>
  <?php
 	$var1 = 0;$var2 = 0;
 	$consulta1="select distinct t1.nro_solicitud as Nro_Soli,t1.id_muestra,t1.recargo,t1.fecha_hora,t1.cod_tipo_muestra,t1.rut_funcionario,t1.cod_ccosto,t1.cod_analisis,t1.cod_periodo";
	$consulta1.=",t2.abreviatura as AbrevProducto";
	$consulta1.=",t3.abreviatura as AbrevSubProducto";
	$consulta1.=",t4.nombre_subclase as NomClase4";
	$consulta1.=",t5.nombre_subclase as NomClase5";
	$consulta1.=", t6.fecha_hora as Hora6, t6.cod_estado as CodEst6";
	$consulta1.=",t7.DESCRIPCION as NomCCosto,t1.fecha_muestra";
	$consulta1.=" from cal_web.solicitud_analisis t1";
	$consulta1.=" left join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
	$consulta1.=" left join proyecto_modernizacion.subproducto t3 on t1.cod_subproducto=t3.cod_subproducto and t1.cod_producto=t3.cod_producto";
	$consulta1.=" left join proyecto_modernizacion.sub_clase t4 on t4.cod_clase = 1000 and t1.cod_analisis=t4.cod_subclase";
	$consulta1.=" left join proyecto_modernizacion.sub_clase t5 on t5.cod_clase = 2 and t1.cod_periodo=t5.cod_subclase";
	$consulta1.=" left join cal_web.estados_por_solicitud t6 on t1.nro_solicitud=t6.nro_solicitud and t1.recargo=t6.recargo and t6.cod_estado = '6'";
	$consulta1.=" left join proyecto_modernizacion.centro_costo t7 on t1.cod_ccosto=t7.CENTRO_COSTO";
	$consulta1.=" where t1.nro_solicitud is not null and t1.estado_actual !='16' and t1.id_muestra='".$ID_Muestra."' ";
	$consulta1.=" order by t1.nro_solicitud, t1.recargo ";
	//echo $consulta1;
	$Resp1=mysqli_query($link, $consulta1);
	while($Row=mysqli_fetch_array($Resp1))
	{
		echo "<tr align='left' valign='middle'>\n";
		$var2 = $var2 + 1;
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
			echo "<td>".$Row[Nro_Soli]."</td>\n";
		else
			echo "<td>".$Row[Nro_Soli]."-".$Row["recargo"]."</td>\n";
		echo "<td>".$Row["id_muestra"]."</td>\n";
		echo "<td>".$Row["fecha_hora"]."</td>\n";	
		echo "<td align ='center'>".$Row[AbrevProducto]."</td>";
		echo "<td align ='center'>".$Row[AbrevSubProducto]."</td>";
		if($Row[NomClase4]=='')
			echo "<td>".$Row["cod_analisis"]."</td>\n";
		else
			echo "<td>".$Row[NomClase4]."</td>\n";	
		echo "<td align = 'center'>".$Row[cod_tipo_muestra]."</td>";
		if($Row[NomClase5]=='')
			echo "<td>".$Row[cod_periodo]."</td>\n";
		else
			echo "<td>".$Row[NomClase5]."</td>\n";
		echo "<td>".$Row["fecha_hora"]."</td>\n";

		//FECHA RECEPCION DE MUESTREO
		$Consulta = "select * ";
		$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$Row[Nro_Soli]."' ";			
		$Consulta.= " and t1.cod_estado='2' "; //RECEPCIONADO muestrera	
		$RespAux1 = mysqli_query($link, $Consulta);
		if ($FilaAux1=mysqli_fetch_array($RespAux1))
		{
			$FechaRecepMuest=$FilaAux1["fecha_hora"];
		}
		else
		{
			$FechaRecepMuest="";
		}		

		//FECHA RECEPCION LABORATORIO
		$Consulta = "select * ";
		$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$Row[Nro_Soli]."' ";			
		$Consulta.= " and t1.cod_estado='4' "; //RECEPCIONADO LABORATORIO	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaRecepLab=$FilaAux["fecha_hora"];
		}
		else
		{
			$FechaRecepLab="";
		}	
		echo "<td>".$FechaRecepMuest."</td>\n";
		echo "<td>".$FechaRecepLab."</td>\n";
		//---------ESTADO ACTUAL---------------------------------------
		$wfecha = "";
		$westado = "";
		$wfechaF = "";
		$westadoF = "";
		$wfechaF = $Row[Hora6];
		$westadoF= $Row[CodEst6];
		$consulta2="select nro_solicitud, fecha_hora, cod_estado from cal_web.estados_por_solicitud ";
		$consulta2.=" where rut_funcionario='".$Row["rut_funcionario"]."' and nro_solicitud = '".$Row[Nro_Soli]."' and recargo = '".$Row["recargo"]."'";
		//echo "consulta2:            ".$consulta2."<br>";
		$respf=mysqli_query($link, $consulta2);
		while($Rowf=mysqli_fetch_array($respf))
		{
			if($Rowf["fecha_hora"] > $wfecha)
			{
				$wfecha = $Rowf["fecha_hora"];
				$westado = $Rowf["cod_estado"];
			}
		}
		if($westadoF=='6')
		{
			if($wfecha >= $wfechaF)
				$westado = $westadoF;
			else
				$wfecha = $wfechaF;
		}
		$Consulta3 = "select nombre_subclase from proyecto_modernizacion.sub_clase t2 ";
		$Consulta3.= " where t2.cod_clase = '1002' and t2.cod_subclase  = '".$westado."' ";		
		$Resp = mysqli_query($link, $Consulta3);
		if ($Row2 = mysqli_fetch_array($Resp))
			echo "<td>".$Row2["nombre_subclase"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "<td>".$wfecha."</td>\n";
		if($Row[NomCCosto]=='')
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td>".$Row[NomCCosto]."</td>\n";	
		//-------------------------------------------------------
		for ($i = 0; $i < $LargoArreglo; $i++)
		{
			$Consulta = "select *,t2.abreviatura from cal_web.leyes_por_solicitud t1";
			$Consulta.= " inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad ";  
			$Consulta.= " where t1.rut_funcionario='".$Row["rut_funcionario"]."' and t1.fecha_hora='".$Row["fecha_hora"]."' and t1.nro_solicitud = '".$Row[Nro_Soli]."' ";
			if (!is_null($Row["recargo"]) || ($Row["recargo"] != ""))
				$Consulta.= " and t1.recargo = '".$Row["recargo"]."' ";
			$Consulta.= " and t1.cod_leyes = '".$ArregloLeyes[$i][0]."'";
			//echo "Consulta leyes:     ".$Consulta."<br>";
			$Resp = mysqli_query($link, $Consulta);
			if ($Row2 = mysqli_fetch_array($Resp))
			{
				    if ((is_null($Row2[valor])) || ($Row2[valor] == ""))
						echo "<td >&nbsp;&nbsp;</td>\n";
					else
						echo "<td >".number_format($Row2[valor],3,",","")."</td>\n";
			}
			else
				echo "<td  align='center'>X</td>\n";
		}
		echo "</tr>\n";
	}
?>
</table>
</body>
</html>
<?php
function FechasProceso($SA,$Recargo,$Estado)
{
	$FechaEstSA="";
	$Consulta = "select fecha_hora from cal_web.estados_por_solicitud where nro_solicitud = '".$SA."' ";			
	$Consulta.= " and recargo='".$Recargo."' ";	
	$Consulta.= " and t1.cod_estado='".$Estado."' "; 
	$RespEstSA = mysqli_query($link, $Consulta);
	if ($FilaEstSA=mysqli_fetch_array($RespEstSA))
		$FechaEstSA=$FilaEstSA["fecha_hora"];
	return($FechaEstSA);
}

?>