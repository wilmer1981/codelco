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
	include("../principal/conectar_sec_web.php");
	if (!isset($CmbDias))
	{
		$CmbDias=date('j');
		$CmbMes=date('n');
		$CmbAno=date('Y');
	}
?>
<html>
<head><title>Consulta Pesaje de Paquetes a Embarque Excel</title></head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<table width="730" border="1" cellpadding="3" align="center" cellspacing="0">
  <?php
	echo "<tr>";
	echo "<td>Producto</td>";
	echo "<td>I.E</td>";
	echo "<td>Cliente/Destinatario</td>";
	echo "<td>Tons.</td>";
	echo "<td>Marca</td>";
	echo "<td>&nbsp;</td>";
	echo "<td>Serie Pqte.</td>";
	echo "<td>Pqts.</td>";
	echo "<td>Ctds.</td>";
	echo "<td>Peso Neto</td>";
	echo "</tr>";
	if (strlen($CmbDias)==1)
	{
		$CmbDias="0".$CmbDias;
	}
	if (strlen($CmbMes)==1)
	{
		$CmbMes="0".$CmbMes;
	}
	$Fecha=$CmbAno."-".$CmbMes."-".$CmbDias;
	$Fecha2=date('Y-m-d', mktime(1,0,0,$CmbMes,intval($CmbDias)+1,$CmbAno));
	$TotPqts=0;
	$TotCatodos=0;
	$TotPesoNeto=0;
	$Consulta="SELECT t2.cod_producto,t2.cod_subproducto,t3.descripcion from sec_web.lote_catodo t1 "; 
	$Consulta.="inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and ";
	$Consulta.="t1.num_paquete=t2.num_paquete inner join proyecto_modernizacion.subproducto t3 on ";
	$Consulta.="t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
	$Consulta.="where concat(t2.fecha_creacion_paquete,' ',t2.hora) between '".$Fecha." 08:00:00' and '".$Fecha2." 07:59:59' and t2.cod_producto in (18,48) ";
	$Consulta.="group by t2.cod_producto,t2.cod_subproducto";
	$RespuestaAgrup=mysqli_query($link, $Consulta);
	while($FilaAgrup=mysqli_fetch_array($RespuestaAgrup))
	{
		$SubTotPqts=0;
		$SubTotCatodos=0;
		$SubTotPesoNeto=0;
		$CrearTmp ="create temporary table if not exists sec_web.tmpConsultaEmb "; 
		$CrearTmp =$CrearTmp."(subproducto varchar (30),corr_ie bigint(8),cliente_nave varchar(30),";
		$CrearTmp =$CrearTmp."toneladas bigint(8),marca varchar(10),cod_lote varchar(1),num_lote_inicio varchar(12),";
		$CrearTmp =$CrearTmp."num_lote_final varchar(12),paquetes bigint(8),catodos bigint(8),peso_neto bigint(8))";
		mysqli_query($link, $CrearTmp);
		$Eliminar="delete from sec_web.tmpConsultaEmb";
		mysqli_query($link, $Eliminar);
		$Consulta="SELECT t1.cod_paquete,min(t1.num_paquete) as lote_inicio,max(t1.num_paquete) as lote_final,count(*) as paquetes,t4.cantidad_embarque as toneladas,t3.descripcion as subproducto,t1.corr_enm,sum(num_unidades) as catodos,t1.cod_marca,sum(peso_paquetes) as peso_neto,";
		$Consulta.="(case when not isnull(t6.nombre_nave) then t6.nombre_nave else t5.sigla_cliente end) as nombre_cliente ";
		$Consulta.="from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
		$Consulta.="on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
		$Consulta.="inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
		$Consulta.="inner join sec_web.programa_enami t4 on t1.corr_enm=t4.corr_enm ";
		$Consulta.="left join sec_web.cliente_venta t5 on t4.cod_cliente=t5.cod_cliente ";
		$Consulta.="left join sec_web.nave t6 on t4.cod_nave=t6.cod_nave ";
		$Consulta.="where concat(t2.fecha_creacion_paquete,' ',t2.hora) between '".$Fecha." 08:00:00' and '".$Fecha2." 07:59:59' and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  and t2.cod_producto='".$FilaAgrup["cod_producto"]."' and t2.cod_subproducto='".$FilaAgrup["cod_subproducto"]."' group by t1.corr_enm";
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			$Insertar="insert into sec_web.tmpConsultaEmb(subproducto,corr_ie,cliente_nave,toneladas,marca,cod_lote,num_lote_inicio,num_lote_final,paquetes,catodos,peso_neto) values (";
			$Insertar.="'".$Fila["subproducto"]."','$Fila["corr_enm"]','$Fila["nombre_cliente"]','$Fila[toneladas]','$Fila["cod_marca"]','$Fila["cod_paquete"]','$Fila[lote_inicio]','$Fila[lote_final]','$Fila["paquetes"]','$Fila[catodos]','$Fila[peso_neto]')";
			mysqli_query($link, $Insertar);
		}
		$Consulta="SELECT t1.cod_paquete,min(t1.num_paquete) as lote_inicio,max(t1.num_paquete) as lote_final,count(*) as paquetes,t4.cantidad_programada as toneladas,t3.descripcion as subproducto,t1.corr_enm,sum(num_unidades) as catodos,t1.cod_marca,sum(peso_paquetes) as peso_neto,";
		$Consulta.="(case when not isnull(t5.nombre_cliente) then t5.nombre_cliente else t6.nombre_nave end) as nombre_cliente ";
		$Consulta.="from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
		$Consulta.="on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
		$Consulta.="inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
		$Consulta.="inner join sec_web.programa_codelco t4 on t1.corr_enm=t4.corr_codelco ";
		$Consulta.="left join sec_web.cliente_venta t5 on t4.cod_cliente=t5.cod_cliente ";
		$Consulta.="left join sec_web.nave t6 on ceiling(t4.cod_cliente)=t6.cod_nave ";
		$Consulta.="where concat(t2.fecha_creacion_paquete,' ',t2.hora) between '".$Fecha." 08:00:00' and '".$Fecha2." 07:59:59'  and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t2.cod_producto='".$FilaAgrup["cod_producto"]."' and t2.cod_subproducto='".$FilaAgrup["cod_subproducto"]."' group by t1.corr_enm";
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			$Insertar="insert into sec_web.tmpConsultaEmb(subproducto,corr_ie,cliente_nave,toneladas,marca,cod_lote,num_lote_inicio,num_lote_final,paquetes,catodos,peso_neto) values (";
			$Insertar.="'".$Fila["subproducto"]."','$Fila["corr_enm"]','$Fila["nombre_cliente"]','$Fila[toneladas]','$Fila["cod_marca"]','$Fila["cod_paquete"]','$Fila[lote_inicio]','$Fila[lote_final]','$Fila["paquetes"]','$Fila[catodos]','$Fila[peso_neto]')";
			mysqli_query($link, $Insertar);
		}
		$Consulta="SELECT t1.cod_paquete,min(t1.num_paquete) as lote_inicio,max(t1.num_paquete) as lote_final,count(*) as paquetes,t4.peso_programado as toneladas,t3.descripcion as subproducto,t1.corr_enm,sum(num_unidades) as catodos,t1.cod_marca,sum(peso_paquetes) as peso_neto ";
		$Consulta.="from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
		$Consulta.="on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
		$Consulta.="inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto=t3.cod_producto and t2.cod_subproducto=t3.cod_subproducto ";
		$Consulta.="inner join sec_web.instruccion_virtual t4 on t1.corr_enm=t4.corr_virtual ";
		$Consulta.="where concat(t2.fecha_creacion_paquete,' ',t2.hora) between '".$Fecha." 08:00:00' and '".$Fecha2." 07:59:59' and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t2.cod_producto='".$FilaAgrup["cod_producto"]."' and t2.cod_subproducto='".$FilaAgrup["cod_subproducto"]."' group by t1.corr_enm";
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			$Insertar="insert into sec_web.tmpConsultaEmb(subproducto,corr_ie,cliente_nave,toneladas,marca,cod_lote,num_lote_inicio,num_lote_final,paquetes,catodos,peso_neto) values (";
			$Insertar.="'".$Fila["subproducto"]."','$Fila["corr_enm"]','','$Fila[toneladas]','$Fila["cod_marca"]','$Fila["cod_paquete"]','$Fila[lote_inicio]','$Fila[lote_final]','$Fila["paquetes"]','$Fila[catodos]','$Fila[peso_neto]')";
			mysqli_query($link, $Insertar);
		}
		$Consulta="SELECT * from sec_web.tmpConsultaEmb";
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			echo "<tr>";
			echo "<td>$Fila["subproducto"]</td>";
			echo "<td>$Fila["corr_ie"]</td>";
			echo "<td>$Fila["cliente_nave"]&nbsp;</td>";
			echo "<td>".$Fila[toneladas]."</td>";
			echo "<td>$Fila["marca"]</td>";
			echo "<td>$Fila[cod_lote]</td>";
			echo "<td>".$Fila[num_lote_inicio]."-".$Fila[num_lote_final]."</td>";
			echo "<td>".$Fila["paquetes"]."</td>";
			echo "<td>".$Fila[catodos]."</td>";
			echo "<td>".$Fila[peso_neto]."</td>";				
			echo "</tr>";
			$SubTotPqts=$SubTotPqts+$Fila["paquetes"];
			$SubTotCtds=$SubTotCtds+$Fila[catodos];
			$SubTotPesoNeto=$SubTotPesoNeto+$Fila[peso_neto];
			$TotPqts=$TotPqts+$Fila["paquetes"];
			$TotCtds=$TotCtds+$Fila[catodos];
			$TotPesoNeto=$TotPesoNeto+$Fila[peso_neto];
		}
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "<td>Sub-Total</td>";
		echo "<td>".$SubTotPqts."</td>";
		echo "<td>".$SubTotCtds."</td>";
		echo "<td>".$SubTotPesoNeto."</td>";				
		echo "</tr>";
	}	
	echo "<tr>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td>Total</td>";
	echo "<td>".$TotPqts."</td>";
	echo "<td>".$TotCtds."</td>";
	echo "<td>".$TotPesoNeto."</td>";				
	echo "</tr>";
   ?>
</table>
</body>
</html>
