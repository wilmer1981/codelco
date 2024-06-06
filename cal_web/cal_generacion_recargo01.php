<?php
$CodigoDeSistema=1;
include("../principal/conectar_principal.php");

$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$NumSolicitud = isset($_REQUEST["NumSolicitud"])?$_REQUEST["NumSolicitud"]:"";
$IdMuestra    = isset($_REQUEST["IdMuestra"])?$_REQUEST["IdMuestra"]:"";


if($Proceso!="S")
{
	$Consulta = "select * from cal_web.solicitud_analisis ";
	$Consulta.= " where nro_solicitud = '".$NumSolicitud."' and id_muestra ='".$IdMuestra."' and recargo ='0' ";
	$Respuesta=mysqli_query($link, $Consulta);
	if ($Fila=mysqli_fetch_array($Respuesta))
	{
		header("location:../cal_web/cal_generacion_recargo0.php?Mostrar=S");
	}
	else
	{
		$Consulta = "select max(recargo) as numero from cal_web.solicitud_analisis ";
		$Consulta.= " where nro_solicitud = '".$NumSolicitud."' and id_muestra ='".$IdMuestra."'  ";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$Consulta="select * from cal_web.solicitud_analisis ";
		$Consulta.= " where nro_solicitud = '".$NumSolicitud."' and id_muestra ='".$IdMuestra."' and recargo = '".$Fila["numero"]."'  ";
		$Respuesta1=mysqli_query($link, $Consulta);
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
			$insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,";
			$insertar =$insertar." cod_producto,cod_subproducto,cod_analisis,cod_tipo_muestra,tipo_solicitud,";
			$insertar =$insertar." nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,rut_proveedor,observacion,agrupacion,fecha_muestra,nro_semana,año,mes,tipo)";
			$insertar =$insertar." values ('".$Fila1["rut_funcionario"]."','".$Fila1["fecha_hora"]."','".$Fila1["id_muestra"]."',";
			$insertar =$insertar." '0','".$Fila1["cod_producto"]."','".$Fila1["cod_subproducto"]."', ";
			$insertar =$insertar." '".$Fila1["cod_analisis"]."','".$Fila1["cod_tipo_muestra"]."','".$Fila1["tipo_solicitud"]."',";
			$insertar =$insertar." '".$Fila1["nro_solicitud"]."','".$Fila1["cod_area"]."','".$Fila1["cod_ccosto"]."','".$Fila1["cod_periodo"]."',";
			$insertar =$insertar." '1','".$Fila1["rut_proveedor"]."','".$Fila1["observacion"]."', ";
			$insertar =$insertar." '".$Fila1["agrupacion"]."','".$Fila1["fecha_muestra"]."',".$NroSemana.",".$Ano.",".$Mes.",".$Tipo.")";
			mysqli_query($link, $insertar);
			$Consulta = "select * from cal_web.estados_por_solicitud where nro_solicitud = '".$Fila1["nro_solicitud"]."'  and recargo = '".$Fila["numero"]."' ";  
			$Respuesta2=mysqli_query($link, $Consulta);
			$Fila2=mysqli_fetch_array($Respuesta2);
			$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso)";
			$insertar.="values ('".$Fila1["rut_funcionario"]."','".$Fila1["nro_solicitud"]."','0','1','".$Fila2["fecha_hora"]."','N','".$Fila2["rut_proceso"]."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);
			header("location:../cal_web/cal_generacion_recargo0.php?NumSolicitud=".$NumSolicitud."&IdMuestra=".$IdMuestra."&MensajeGenerar=S");
		}
		else
		{
			header("location:../cal_web/cal_generacion_recargo0.php?Encontro=N");
	
		}
	}
}
if($Proceso=="S")
{
	$Consulta = "select * from cal_web.solicitud_analisis ";
	$Consulta.= " where nro_solicitud = '".$NumSolicitud."' and id_muestra ='".$IdMuestra."' and recargo ='1' ";
	$Respuesta=mysqli_query($link, $Consulta);
	if ($Fila=mysqli_fetch_array($Respuesta))
	{
		$ahora = 1;
		header("location:../cal_web/cal_genera_recargo_1_sel.php?Mostrar=S");
	}
	else
	{
		$ActSol= "UPDATE cal_web.solicitud_analisis set recargo = '0' ";
		$ActSol.= " where nro_solicitud = '".$NumSolicitud."' and id_muestra ='".$IdMuestra."' and recargo = ''";
		mysqli_query($link, $ActSol);
		$ActEst="UPDATE cal_web.estados_por_solicitud set recargo = '0' ";
		$ActEst.= " where nro_solicitud = '".$NumSolicitud."' and regargo =''  ";
		mysqli_query($link, $ActEst);
		$ActLey="UPDATE cal_web.leyes_por_solicitud set recargo = '0' ";
		$ActLey.= " where nro_solicitud = '".$NumSolicitud."' and id_muestra ='".$IdMuestra."' and recargo=''  ";
		mysqli_query($link, $ActLey);
		
		$Consulta1="select * from cal_web.solicitud_analisis ";
		$Consulta1.= " where nro_solicitud = '".$NumSolicitud."' and id_muestra ='".$IdMuestra."' and recargo = '0'  ";
		$Respuesta1=mysqli_query($link, $Consulta1);
		if ($Fila1=mysqli_fetch_array($Respuesta1))
		{
			if ((is_null($Fila1["nro_semana"])) || ($Fila1["nro_semana"]==""))
				$NroSemana="NULL";
				else
				$NroSemana=$Fila1["nro_semana"];

			if ((is_null($Fila1["año"])) || ($Fila1["año"]==""))
				$Ano="NULL";
				else
				$Ano=$Fila1["año"];
				
			if ((is_null($Fila1["mes"])) || ($Fila1["mes"]==""))
				$Mes="NULL";
				else
				$Mes=$Fila1["mes"];

			if ((is_null($Fila1["tipo"])) || ($Fila1["tipo"]==""))
				$Tipo="NULL";
				else
				$Tipo=$Fila1["tipo"];

			$insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,";
			$insertar.=" nro_solicitud,cod_ccosto,cod_area,cod_periodo,cod_producto,cod_subproducto,cod_analisis,cod_tipo_muestra,";
			$insertar.="leyes,tipo_solicitud,estado_actual,rut_proveedor,observacion,agrupacion,fecha_muestra,nro_semana,año,mes,tipo)";
			$insertar.=" values ('".$Fila1["rut_funcionario"]."','".$Fila1["fecha_hora"]."','".$Fila1["id_muestra"]."',";
			$insertar.=" '1','".$Fila1["nro_solicitud"]."','".$Fila1["cod_ccosto"]."','".$Fila1["cod_area"]."',";
			$insertar.="'".$Fila1["cod_periodo"]."','".$Fila1["cod_producto"]."','".$Fila1["cod_subproducto"]."', ";
			$insertar.=" '".$Fila1["cod_analisis"]."','".$Fila1["cod_tipo_muestra"]."','01~~1//','".$Fila1["tipo_solicitud"]."',";
			$insertar.=" '3','".$Fila1["rut_proveedor"]."','".$Fila1["observacion"]."','".$Fila1["agrupacion"]."', ";
			$insertar.=" '".$Fila1["fecha_muestra"]."',".$NroSemana.",".$Ano.",".$Mes.",".$Tipo.")";
			mysqli_query($link, $insertar);
			$Consulta = "select * from cal_web.estados_por_solicitud where nro_solicitud = '".$Fila1["nro_solicitud"]."'  and recargo = '0' ";  
			$Respuesta2=mysqli_query($link, $Consulta);
			$Fila2=mysqli_fetch_array($Respuesta2);
			$insertar1 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso)";
			$insertar1.="values ('".$Fila1["rut_funcionario"]."','".$Fila1["nro_solicitud"]."','1','3','".$Fila2["fecha_hora"]."','N','".$Fila2["rut_proceso"]."')";
			mysqli_query($link, $insertar1);
			$Consulta3="select * from cal_web.leyes_por_solicitud where nro_solicitud = '".$Fila1["nro_solicitud"]."' and recargo = '0' ";
			$Respuesta3=mysqli_query($link, $Consulta3);
			$Fila3=mysqli_fetch_array($Respuesta3);
			$insertar2="insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,";
			$insertar2.="cod_unidad,activa,candado,cod_producto,cod_subproducto,id_muestra,signo,proceso,virtual)";
			$insertar2.=" values('".$Fila1["rut_funcionario"]."','".$Fila1["fecha_hora"]."','".$Fila1["nro_solicitud"]."',";
			$insertar2.="'1','01','".$Fila3["activa"]."','1','0','".$Fila3["cod_producto"]."','".$Fila3["cod_subproducto"]."',";
			$insertar2.="'".$Fila3["id_muestra"]."','=','".$Fila3["proceso"]."','".$Fila3["virtual"]."')";
			//echo "hh  ".$insertar2;
			mysqli_query($link, $insertar2);
			header("location:../cal_web/cal_genera_recargo_1_sel.php?NumSolicitud=".$NumSolicitud."&IdMuestra=".$IdMuestra."&MensajeGenerar=S");
		}
		else
		{
			header("location:../cal_web/cal_genera_recargo_1_sel.php?Encontro=N");
		}
	}

}
?>
