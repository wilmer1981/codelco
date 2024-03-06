<?php 	
	    ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename = "";
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
	$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	$Consulta = "SELECT ifnull(max(corr_fax)+1,1) as corrfax from sec_web.control_fax ";
	$Consulta.=" where YEAR(fecha_hora) = year(now())	";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$CorrFax = $Fila["corrfax"];
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut = $CookieRut;
	
	//DATOS
	$ValoresCheck = $_REQUEST["ValoresCheck"];
	$Tipo = $_REQUEST["Tipo"];

	$Datos=explode('//',$ValoresCheck);
	$Tara=0;
	$Piezas=0;
	$PesoNeto=0;
	$PesoBruto=0;
	foreach($Datos as $Clave => $Valor)
	{
		
		$Datos2=explode('~~',$Valor);
		$IE=$Datos2[0];
		if ($IE!="")
		{
			$OrdenEmb=$Datos2[0];
			//echo "ORDEN=".$OrdenEmb;
			$Codigo=$Datos2[1];
			$Envio=$Datos2[2];
			/*if($Codigo=='01')
			{*/
				$FechaHora=date('Y-m-d H:i:s');
				$Insertar="insert into sec_web.control_fax(num_envio,corr_fax,tipo,fecha_hora,rut) values (";
				$Insertar.=" '".$Envio."','".$CorrFax."','C','".$FechaHora."','".$Rut."')";
				mysqli_query($link, $Insertar);
				$Consulta = "SELECT t1.corr_enm as ie,t1.bulto_paquetes,t1.bulto_peso,t1.cod_bulto,t1.num_bulto,";
				$Consulta.= " t4.nom_aero_puerto as puerto,t2.descripcion as marca,t3.sigla_cliente as cliente,";
				$Consulta.= " t5.nombre_nave as cliente, t3.nombre_cliente as nombre_cliente, t5.nombre_nave as nombre_cliente, t1.tipo_embarque ";
				$Consulta.= " from sec_web.embarque_ventana t1 "; 
				$Consulta.= " left join sec_web.marca_catodos t2 on t1.cod_marca=t2.cod_marca";
				$Consulta.= " left join sec_web.cliente_venta t3 on t1.cod_cliente=t3.cod_cliente";
				$Consulta.= " left join sec_web.nave t5 on t1.cod_cliente=t5.cod_nave			";
				$Consulta.= " left join sec_web.puertos t4 on t1.cod_puerto=t4.cod_puerto";
				$Consulta.= " where corr_enm=".$IE." order by t1.corr_enm";
				$Respuesta=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					$Consulta = "SELECT sum(t2.num_unidades) as unidades from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
					$Consulta.= " on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete";
					$Consulta.= " where t1.cod_bulto='".$Fila["cod_bulto"]."' and t1.num_bulto=".$Fila["num_bulto"]." and t1.corr_enm=".$Fila["ie"];
					$Respuesta2=mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Respuesta2);
					$IE = $Fila["ie"];
					$Cliente = $Fila["cliente"];
					//PROGRAMA CODELCO
					$Consulta = "SELECT t1.cod_contrato, t1.mes_cuota, t1.partida, t1.fecha_disponible, t2.descripcion, t1.cod_contrato_maquila as asignacion ";
					$Consulta.= " from sec_web.programa_codelco t1 inner join proyecto_modernizacion.subproducto t2 ";
					$Consulta.= " on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
					$Consulta.= " where corr_codelco='".$IE."' ";
					$Respuesta3=mysqli_query($link, $Consulta);
					$Fila3=mysqli_fetch_array($Respuesta3);
					$ContCuotaPart = $Fila3["cod_contrato"].$Fila3["mes_cuota"].$Fila3["partida"];
					$FechaDisponible = substr($Fila3["fecha_disponible"],8,2)."/".substr($Fila3["fecha_disponible"],5,2)."/".substr($Fila3["fecha_disponible"],0,4);
					$FechaEmbarque = substr($Fila3["fecha_disponible"],8,2)."/".substr($Fila3["fecha_disponible"],5,2)."/".substr($Fila3["fecha_disponible"],0,4);
					$Material=$Fila3["descripcion"];
					//--
					$Marca = $Fila["marca"];
					$Asignacion = $Fila3["asignacion"];
					$Atados = $Fila["bulto_paquetes"];
					$Tara = ($Fila["bulto_paquetes"]);
					$Piezas = $Fila2["unidades"];
					$PesoNeto = $Fila["bulto_peso"];
					$PesoBruto = ($Fila["bulto_peso"] + $Fila["bulto_paquetes"]);
					switch ($Fila["tipo_embarque"])
					{
						case "T":
							$TipoVehiculo = "Vehiculo";
							$Vehiculo="Camion";
							$DescripVehiculo="Patente";
							$Patente="";
							break;
						default:
							$TipoVehiculo = "Transporte";
							$Vehiculo="Nave";
							$DescripVehiculo="Nom.Empresa o Motonave";
							$Patente="";
							break;
					}
					$NombreCliente = strtoupper($Fila["nombre_cliente"]);
				}
			//}
		}
	}
?>
<html>
<head>
</script>
<title>AVISO DE ENTREGA</title>
<style type="text/css">
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.Estilo2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
</style>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProgLoteo" method="post" action="">
<br>
<table width="730" border="0" cellpadding="3" cellspacing="1">
<tr>
	<td width="100" align="right">&nbsp;</td>
	<td width="400" align="right"><span class="Estilo2"><?php echo date("d")." de ".$Meses[date("n")-1]." del ".date("Y"); ?></span></td>
</tr>
<tr>
	<td colspan="2" align="center"><span class="Estilo1">AVISO DE ENTREGA N&deg; <?php echo $CorrFax; ?> </span></td>
</tr>	
<tr>
	<td colspan="2" >&nbsp;</td>
</tr>
<tr>
	<td  align="left"><span class="Estilo2">A:</span></td>
	<td  align="left" class="Estilo2">SUBGERENCIA DE OPERACIONES COMERCIALES</td>
</tr>
<tr>
	<td class="Estilo2" >CC:</td>
	<td class="Estilo2" >DEPTO. COBRANZAS E INGRESOS/CONTROL INGRESOS Y EGRESOS/SUBGERENCIA LOGISTICA</td>
</tr>
<tr>
	<td class="Estilo2">DE:</td>
	<td class="Estilo2">VENTANAS</td>
</tr>	
<tr>
	<td class="Estilo2" >REF:</td>
	<td class="Estilo2" >ENTREGAS EFECTUADAS A <?php echo $NombreCliente; ?></td>
</tr>
<tr>
  <td class="Estilo2" >&nbsp;</td>
  <td class="Estilo2" >FECHA:&nbsp;&nbsp; <?php echo $FechaEntrega; ?></td>
</tr>
<tr>
	<td colspan="2" >&nbsp;</td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >Cliente</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Cliente; ?></td>
</tr>
<tr valign="middle">
  <td class="Estilo2" >Asignaci&oacute;n</td>
  <td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Asignacion; ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >Cont./Cuota/Part.</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ContCuotaPart; ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >Fecha Disp.</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $FechaDisponible; ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >Fecha Emb.</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $FechaEmbarque; ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >IE</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $OrdenEmb; ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >Material</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Material; ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >Marca</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Marca; ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >Atados</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($Atados,0,",","."); ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >Piezas</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($Piezas,0,",","."); ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >Peso Bruto</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($PesoBruto,0,",","."); ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >Peso Neto</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($PesoNeto,0,",","."); ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >Tara</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($Tara,0,",","."); ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" ><?php echo $TipoVehiculo; ?></td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Vehiculo; ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" ><?php echo $DescripVehiculo; ?></td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Patente; ?></td>
</tr>
<tr valign="middle">
	<td class="Estilo2" >GUIAS NO.</td>
	<td class="Estilo2" >:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $NumGuia; ?></td>
</tr>
</table>
</form>
</body>
</html>
