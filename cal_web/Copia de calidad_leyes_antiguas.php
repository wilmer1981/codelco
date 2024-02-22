<?php

	$Producto = '64';
	$Subproducto = '8';
	$FechaIni = '2006-01-01 08:00:00';
	$FechaFin = '2007-01-01 07:59:59';
	$contador = 0;
    $leidos = 0;
	$CreaTabla = "Create table cal_web.tmp_solpaso as select * from cal_web.solicitud_analisis_copy ";
	$CreaTabla.=" where (fecha_hora between '".$FechaIni."' and '".$FechaFin."') and cod_producto = '".$Producto."' ";
	$CreaTabla.=" and cod_subproducto = '".$Subproducto."'";
	mysqli_query($link, $CreaTabla);
	
	$Consulta ="select * from cal_web.tmp_solpaso";
	$Resp=mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Resp))
	{
        $leidos = $leidos + 1;
		$existe = 0;
		$Consulta2 ="select  * from cal_web.solicitud_analisis t1 ";
		$Consulta2.=" where t1.rut_funcionario = '".$Row["rut_funcionario"]."' and ";
		$Consulta2.=" t1.fecha_hora = '".$Row["fecha_hora"]."' and ";
		$Consulta2.=" t1.id_muestra = '".$Row["id_muestra"]."' and ";
		$Consulta2.=" t1.recargo = '".$Row["recargo"]."' ";
		$Resp2=mysqli_query($link, $Consulta2);
		if ($Fila=mysqli_fetch_array($Resp2))
		{
			$existe = 1;
		}
		if ($existe==0)
		{
			$Inserta =" insert into cal_web.solicitud_analisis (rut_funcionario,fecha_hora,id_muestra,recargo,nro_solicitud,";
			$Inserta.=" peso_muestra,cod_ccosto,cod_area,cod_periodo,cod_producto,cod_subproducto,cod_analisis,";
			$Inserta.=" cod_tipo_muestra,leyes,impurezas,enabal,tipo_solicitud,estado_actual,rut_proveedor,peso_retalla,observacion,";
			$Inserta.=" agrupacion,fecha_muestra,nro_semana,a�o,mes,frx,tipo)";
			$Inserta.=" Values('".$Row["rut_funcionario"]."','".$Row["fecha_hora"]."','".$Row["id_muestra"]."','".$Row["recargo"]."','".$Row["nro_solicitud"]."',";
			$Inserta.=" '".$Row[peso_muestra]."','".$Row[cod_ccosto]."','".$Row[cod_area]."','".$Row[cod_periodo]."','".$Row["cod_producto"]."',";
			$Inserta.=" '".$Row["cod_subproducto"]."','".$Row[cod_analisis]."','".$Row[cod_tipo_muestra]."','".$Row[leyes]."','".$Row[impurezas]."',";
			$Inserta.=" '".$Row[enabal]."','".$Row[tipo_solicitud]."','".$Row[estado_actual]."','".$Row["rut_proveedor"]."','".$Row[peso_retalla]."',";
			$Inserta.=" '".$Row[observacion]."','".$Row[agrupacion]."','".$Row[fecha_muestra]."','".$Row[nro_semana]."','".$Row[a�o]."',";
			$Inserta.=" '".$Row[mes]."','".$Row[frx]."','".$Row[tipo]."')";
			mysqli_query($link, $Inserta);

			$contador = $contador + 1;
   
		}
    }
	$borra = "drop table cal_web.tmp_solpaso";
	mysqli_query($link, $borra);
	echo "leidos...".$leidos."inserta.".$contador."</br>";
?>  
