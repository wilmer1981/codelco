<?php
include("../principal/conectar_cal_web.php");

$NumSolicitud = $_REQUEST["NumSolicitud"];
$IdMuestra = $_REQUEST["IdMuestra"];
$PesoMuestra = $_REQUEST["PesoMuestra"];


$Consulta = "select * from cal_web.solicitud_analisis ";
$Consulta.= " where nro_solicitud = '".$NumSolicitud."' and id_muestra ='".$IdMuestra."' and recargo='R' ";
$Respuesta=mysqli_query($link, $Consulta);
if ($Fila=mysqli_fetch_array($Respuesta))
{
	header("location:../cal_web/cal_generacion_recargoR.php?Mostrar=S");
	//echo "ya existe"."<br>";
}
else
{
	$Consulta="select * from cal_web.solicitud_analisis ";
	$Consulta.= " where nro_solicitud = '".$NumSolicitud."' and id_muestra ='".$IdMuestra."'   ";
	$Respuesta1=mysqli_query($link, $Consulta);
	//echo $Consulta."<br>";
	if ($Fila1=mysqli_fetch_array($Respuesta1))
	{
		if ((is_null($Fila1["nro_semana"]))||($Fila1["nro_semana"]==""))
		{
			$NroSemana="NULL";
		}
		else
		{
			$NroSemana=$Fila1["nro_semana"];
		}
		if ((is_null($Fila1["año"]))||($Fila1["año"]==""))
		{
			$Ano="NULL";
		}
		else
		{
			$Ano=$Fila1["año"];
		}
		if ((is_null($Fila1["mes"]))||($Fila1["mes"]==""))
		{
			$Mes="NULL";
		}
		else
		{
			$Mes=$Fila1["mes"];
		}
		if ((is_null($Fila1["tipo"]))||($Fila1["tipo"]==""))
		{
			$Tipo="NULL";
		}
		else
		{
			$Tipo=$Fila1["tipo"];
		}
		if ($Fila1["tipo_solicitud"]=='A')
		{
			$insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,";
			$insertar =$insertar." cod_producto,cod_subproducto,cod_analisis,cod_tipo_muestra,tipo_solicitud,";
			$insertar =$insertar." nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,rut_proveedor,observacion,agrupacion,fecha_muestra,nro_semana,año,mes,tipo,peso_muestra)";
			$insertar =$insertar." values ('".$Fila1["rut_funcionario"]."','".$Fila1["fecha_hora"]."','".$Fila1["id_muestra"]."',";
			$insertar =$insertar." 'R','".$Fila1["cod_producto"]."','".$Fila1["cod_subproducto"]."', ";
			$insertar =$insertar." '".$Fila1["cod_analisis"]."','".$Fila1["cod_tipo_muestra"]."','".$Fila1["tipo_solicitud"]."',";
			$insertar =$insertar." '".$Fila1["nro_solicitud"]."','".$Fila1["cod_area"]."','".$Fila1["cod_ccosto"]."','".$Fila1["cod_periodo"]."',";
			$insertar =$insertar." '1','".$Fila1["rut_proveedor"]."','".$Fila1["observacion"]."', ";
			$insertar =$insertar." '".$Fila1["agrupacion"]."','".$Fila1["fecha_muestra"]."',".$NroSemana.",".$Ano.",".$Mes.",".$Tipo.",'".$PesoMuestra."')";
			mysqli_query($link, $insertar);
			$Consulta = "select * from cal_web.estados_por_solicitud where nro_solicitud = '".$Fila1["nro_solicitud"]."' and cod_estado='1'  ";  
			$Consulta.=" and rut_funcionario='".$Fila1["rut_funcionario"]."'		";
			$Respuesta2=mysqli_query($link, $Consulta);
			$Fila2=mysqli_fetch_array($Respuesta2);
			$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado ";
			$insertar.=" ,fecha_hora,ult_atencion,rut_proceso)";
			$insertar.=" values ('".$Fila1["rut_funcionario"]."','".$Fila1["nro_solicitud"]."','R','1','".$Fila2["fecha_hora"]."','N','".$Fila2["rut_proceso"]."')";
			mysqli_query($link, $insertar);
		}
		else
		{
			$Actualizar="UPDATE cal_web.solicitud_analisis set recargo='0',tipo_solicitud='A' ";
			$Actualizar.="where nro_solicitud='".$Fila1["nro_solicitud"]."' and id_muestra='".$Fila1["id_muestra"]."' ";
			$Actualizar.=" and fecha_hora='".$Fila1["fecha_hora"]."' and rut_funcionario='".$Fila1["rut_funcionario"]."'	";
			mysqli_query($link, $Actualizar);
			$Actualizar="UPDATE cal_web.estados_por_solicitud set recargo='0' where nro_solicitud='".$Fila1["nro_solicitud"]."' ";
			$Actualizar.="  and 	recargo ='".$Fila1["recargo"]."' and rut_funcionario='".$Fila1["rut_funcionario"]."'	";
			mysqli_query($link, $Actualizar);
			echo $Actualizar."<br>";
			$Actualizar="UPDATE cal_web.leyes_por_solicitud set recargo='0' where nro_solicitud='".$Fila1["nro_solicitud"]."' ";
			$Actualizar.=" and recargo='".$Fila1["recargo"]."' and fecha_hora='".$Fila1["fecha_hora"]."' and rut_funcionario='".$Fila1["rut_funcionario"]."' ";
			$Actualizar.=" and id_muestra='".$Fila1["id_muestra"]."'	";
			mysqli_query($link, $Actualizar);
			$Actualizar="UPDATE cal_web.registro_leyes set recargo='0' where nro_solicitud='".$Fila1["nro_solicitud"]."' ";
			$Actualizar.=" and recargo='".$Fila1["recargo"]."'	";
			mysqli_query($link, $Actualizar);
			$insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,";
			$insertar =$insertar." cod_producto,cod_subproducto,cod_analisis,cod_tipo_muestra,tipo_solicitud,";
			$insertar =$insertar." nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,rut_proveedor,observacion,agrupacion,fecha_muestra,nro_semana,año,mes,tipo,peso_muestra)";
			$insertar =$insertar." values ('".$Fila1["rut_funcionario"]."','".$Fila1["fecha_hora"]."','".$Fila1["id_muestra"]."',";
			$insertar =$insertar." 'R','".$Fila1["cod_producto"]."','".$Fila1["cod_subproducto"]."', ";
			$insertar =$insertar." '".$Fila1["cod_analisis"]."','".$Fila1["cod_tipo_muestra"]."','A',";
			$insertar =$insertar." '".$Fila1["nro_solicitud"]."','".$Fila1["cod_area"]."','".$Fila1["cod_ccosto"]."','".$Fila1["cod_periodo"]."',";
			$insertar =$insertar." '1','".$Fila1["rut_proveedor"]."','".$Fila1["observacion"]."', ";
			$insertar =$insertar." '".$Fila1["agrupacion"]."','".$Fila1["fecha_muestra"]."',".$NroSemana.",".$Ano.",".$Mes.",".$Tipo.",'".$PesoMuestra."')";
			mysqli_query($link, $insertar);
			$Consulta = "select * from cal_web.estados_por_solicitud where nro_solicitud = '".$Fila1["nro_solicitud"]."' ";
			$Consulta.=" and rut_funcionario='".$Fila1["rut_funcionario"]."' and cod_estado='1'  ";
			$Respuesta2=mysqli_query($link, $Consulta);
			$Fila2=mysqli_fetch_array($Respuesta2);
			$insertar =" insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado ";
			$insertar.=" ,fecha_hora,ult_atencion,rut_proceso)";
			$insertar.=" values ('".$Fila1["rut_funcionario"]."','".$Fila1["nro_solicitud"]."', ";
			$insertar.=" 'R','1','".$Fila2["fecha_hora"]."','N','".$Fila2["rut_proceso"]."')";
			mysqli_query($link, $insertar);
		}
		header("location:../cal_web/cal_generacion_recargoR.php?NumSolicitud=".$NumSolicitud."&IdMuestra=".$IdMuestra."&MensajeGenerar=S");
	}
	else
	{
		header("location:../cal_web/cal_generacion_recargoR.php?Encontro=N");
	}
}
?>
