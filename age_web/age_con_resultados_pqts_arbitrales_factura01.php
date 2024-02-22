<?php
	include("../principal/conectar_principal.php");

	$Consulta ="select t2.cod_subclase from age_web.lotes t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='15009' and t1.laboratorio_externo=t2.cod_subclase ";
	$Consulta.="where t1.orden_ensaye='".$TxtOrdenEns."' order by t1.lote desc limit 1";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Resp);
	$CodLab=strtoupper($Fila["cod_subclase"]);
	$Eliminar="delete from age_web.facturacion_canje_leyes where orden_ensaye='".$TxtOrdenEns."'";
	mysqli_query($link, $Eliminar);
	$Insertar="insert into age_web.facturacion_canje_leyes (cod_laboratorio,num_factura,fecha_factura,tipo_moneda,valor_moneda,fecha_moneda_desde,fecha_moneda_hasta,orden_ensaye) values ";
	$Insertar.="('$CodLab','$TxtFactura','$TxtFechaFactura','$TxtTipoMoneda','$TxtValorMoneda','$TxtFechaIni','$TxtFechaFin','$TxtOrdenEnsaye')";
	//echo $Insertar;
	mysqli_query($link, $Insertar);
	header("location:age_con_resultados_pqts_arbitrales_factura.php?TxtOrdenEns=".$TxtOrdenEns);
?>
