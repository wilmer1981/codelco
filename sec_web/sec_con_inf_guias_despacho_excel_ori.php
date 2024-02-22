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
	if (!isset($DiaIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
		$AnoFin = date("Y");
	}
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sec_con_inf_guias_despacho.php";
			f.submit();
			break;
		case "E":
			f.action ="sec_con_inf_guias_despacho_excel.php";
			f.submit();
			break;
		case "S":
			f.action ="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}

</script>
</head>

<body class="TablaPrincipal">
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" colspan="10"><strong>INFORME DE GUIAS DE DESPACHO</strong></td>
  </tr>
</table>
<form name="frmPrincipal" method="post" action="">
  <br>
<?php
	$TotalResumen=array();
	$Consulta = "SELECT t3.cod_producto,t3.cod_subproducto";
	$Consulta.= " from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.= " on t1.num_guia=t2.num_guia and t2.cod_estado='c' ";
	$Consulta.= " inner join sec_web.embarque_ventana t3 on t3.num_envio=t1.num_envio ";
	$Consulta.= " where t1.cod_estado <> 'A' and t1.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."' ";
	$Consulta.= " group by t3.cod_producto,t3.cod_subproducto";
	$Respuesta = mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		$Clave=$Fila["cod_producto"];
		$TotalResumen[$Clave][0]=0;
		$TotalResumen[$Clave][1]=0;
		$TotalResumen[$Clave][2]=0;
	}
	$Consulta = "SELECT distinct t2.cod_cliente, t1.num_envio, t1.corr_enm, t3.descripcion as marca, ";
	$Consulta.= " t2.cod_bulto, t2.num_bulto";
	$Consulta.= " from sec_web.guia_despacho_emb t1 inner join sec_web.embarque_ventana t2 ";
	$Consulta.= " on t1.num_envio = t2.num_envio and t1.corr_enm = t2.corr_enm ";
	$Consulta.= " inner join sec_web.marca_catodos t3 ";
	$Consulta.= " on t2.cod_marca = t3.cod_marca";	
	$Consulta.= " where t1.cod_estado <>'A' and t1.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."' order by t2.num_envio";
	$Respuesta = mysqli_query($link, $Consulta);
	//echo $Consulta;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{	
		$Consulta = "SELECT  * from sec_web.cliente_venta where cod_cliente = '".$Fila["cod_cliente"]."'";
		$Respuesta2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$NombreCliente = $Fila2["sigla_cliente"];
		}
		else
		{
			$Consulta = "SELECT  * from sec_web.nave where cod_nave = '".intval($Fila["cod_cliente"])."'";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				$NombreCliente = $Fila2["nombre_nave"];
			}
			else
			{
				$NombreCliente = "&nbsp;";
			}
		}
		echo "<table width='320' border='1' align='center' cellpadding='0' cellspacing='0'>\n";
		echo "<tr>\n";
		echo "<td width='74'><strong>CLIENTE</strong></td>\n";
		echo "<td width='240' colspan='4'>".$NombreCliente."</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td><strong>N� ENVIO</strong></td>\n";
		echo "<td colspan='4' align='left'>".$Fila["num_envio"]."</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td><strong>COLOR</strong></td>\n";
		echo "<td colspan='4'>".$Fila["marca"]."</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td><strong>LOTE</strong></td>\n";
		echo "<td colspan='4'>".strtoupper($Fila["cod_bulto"])." - ".$Fila["num_bulto"]."</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "<br>\n";
		echo "<table width='804' height='14'  border='1' align='center' cellpadding='0' cellspacing='0'>\n";
		echo "<tr class='ColorTabla01'>\n";
		echo "<td width='52' align='center'>N� GUIA</td>\n";
		echo "<td width='60' align='center'>FECHA</td>\n";
		echo "<td width='50' align='center'>T.PAQU.</td>\n";
		echo "<td width='42' align='center'>T.UNI.</td>\n";
		echo "<td width='64' align='center'>PESO NETO</td>\n";
		echo "<td width='51' align='center'>PATENTE</td>\n";
		echo "<td width='77' align='center'>RUT CHOFER</td>\n";
		echo "<td width='143' align='center'>NOMBRE CHOFER</td>\n";
		echo "<td width='61' align='center'>HH GUIA</td>\n";
		echo "<td width='89' align='center'>HH ENTRADA</td>\n";
		echo "<td width='91' align='center'>HH SALIDA</td>\n";
		echo "<td width='91' align='center'>TRANSPORTISTA</td>\n";
		echo "</tr>\n";
		$Consulta = "SELECT * ";
		$Consulta.= " from sec_web.guia_despacho_emb ";
		$Consulta.= " where cod_estado <>'A' and num_envio = '".$Fila["num_envio"]."' and corr_enm = '".$Fila["corr_enm"]."'";
		$Consulta.= " and fecha_guia between '".$FechaInicio."' and '".$FechaTermino."'";
		$Consulta.= " order by fecha_guia, num_guia";
		$Respuesta2 = mysqli_query($link, $Consulta);
		$TotalPaquetes = 0;
		$TotalUnidades = 0;
		$TotalPeso = 0;
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			echo "<tr>\n";
			echo "<td>".$Fila2["num_guia"]."</td>\n";
			echo "<td>".substr($Fila2["fecha_guia"],8,2).".".substr($Fila2["fecha_guia"],5,2).".".substr($Fila2["fecha_guia"],0,4)."</td>\n";
			//--------------------------------------------DETALLE GUIA-------------------------------------------
			$Consulta = "SELECT t2.cod_paquete, t2.num_paquete, sum(t2.num_unidades) as unidades, ";
			$Consulta.= " sum(t2.peso_paquetes) as peso, count(*) as tot_paquetes ";
			$Consulta.= " from sec_web.paquete_catodo t2 ";
			$Consulta.= " where t2.num_guia = '".$Fila2["num_guia"]."' and t2.fecha_embarque= '".$Fila2["fecha_guia"]."'";
			$Consulta.= " group by t2.num_guia";
			//echo $Consulta."<br>";
			$Respuesta3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Respuesta3))
			{
				echo "<td align='right'>".number_format($Fila3["tot_paquetes"],0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($Fila3["unidades"],0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($Fila3["peso"],0,",",".")."</td>\n";
				$TotalPaquetes = $TotalPaquetes + $Fila3["tot_paquetes"];
				$TotalUnidades = $TotalUnidades + $Fila3["unidades"];
				$TotalPeso = $TotalPeso + $Fila3["peso"];
			}
			else
			{
				echo "<td>&nbsp;</td>\n";
				echo "<td>&nbsp;</td>\n";
				echo "<td>&nbsp;</td>\n";
			}
			//---------------------------------------------------------------------------------------------------
			echo "<td>".$Fila2["patente_guia"]."</td>\n";
			echo "<td align='right'>".$Fila2["rut_chofer"]."</td>\n";
			$Consulta = "SELECT * from sec_web.persona where rut_persona like '%".trim($Fila2["rut_chofer"])."%'";			
			$Respuesta3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Respuesta3))
				echo "<td>".$Fila3["nombre_persona"]."</td>\n";
			else	echo "<td>&nbsp;</td>\n";
			//--------------------CONSULTO PESAJE DEL CAMION----------------------------------------------
			$Consulta = "SELECT hora_entrada, hora_salida from sipa_web.despachos ";
			$Consulta.= " where guia_despacho='".$Fila2["num_guia"]."' and fecha = '".$Fila2["fecha_guia"]."' ";
			$Consulta.= " and replace(patente,'-','') = replace(substring('".trim($Fila2["patente_guia"])."',1,7),'-','')";
			$Respuesta3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Respuesta3))
			{
				echo "<td>".$Fila2["hora_guia"]."</td>\n";
				echo "<td>".$Fila3["hora_entrada"]."</td>\n";
				echo "<td>".$Fila3["hora_salida"]."</td>\n";
			}
			else
			{
				echo "<td>".$Fila2["hora_guia"]."</td>\n";
				echo "<td>&nbsp;</td>\n";
				echo "<td>&nbsp;</td>\n";
			}
			//--------------------CONSULTO TRANSPORTISTA----------------------------------------------
			$Consulta = "SELECT t2.nombre_transportista as nombre from sec_web.transporte_persona t1 ";
			$Consulta.= " left join sec_web.transporte t2 on t1.rut_transportista=t2.rut_transportista and t1.patente_camion=t2.patente_transporte";
			$Consulta.= " where t1.patente_camion='".$Fila2[patente_guia]."' and t1.rut_chofer='".$Fila2["rut_chofer"]."'";
			$Respuesta3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Respuesta3))
			{
				echo "<td>".$Fila3["nombre"]."&nbsp;</td>\n";
			}
			else
			{
				echo "<td>&nbsp;</td>\n";
			}
			//---------------------------------------------------------------------------------------------

			echo "</tr>\n";	
		}
		echo "<tr>\n";
		echo "<td colspan='2'><strong>TOTALES</strong></td>\n";
		echo "<td align='right'><strong>".number_format($TotalPaquetes,0,",",".")."</strong></td>\n";
		echo "<td align='right'><strong>".number_format($TotalUnidades,0,",",".")."</strong></td>\n";
		echo "<td align='right'><strong>".number_format($TotalPeso,0,",",".")."</strong></td>\n";
		echo "<td colspan='7'>&nbsp;</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "<br>";
		$Consulta="SELECT cod_producto,cod_subproducto from sec_web.embarque_ventana where num_envio=".$Fila["num_envio"];
		$Respuesta3=mysqli_query($link, $Consulta);
		$Fila3=mysqli_fetch_array($Respuesta3);
		$Clave=$Fila3["cod_producto"];
		$TotalResumen[$Clave][0]=$TotalResumen[$Clave][0]+$TotalPaquetes;
		$TotalResumen[$Clave][1]=$TotalResumen[$Clave][1]+$TotalUnidades;
		$TotalResumen[$Clave][2]=$TotalResumen[$Clave][2]+$TotalPeso;
	}
?>	
	<br>
  <table width="617" height="14"  border="1" align="center" cellpadding="0" cellspacing="0">
    <tr class="ColorTabla01"> 
      <td width="500" align="center" colspan="7"><strong>RESUMEN GUIAS DE DESPACHO</strong></td>
	 </tr>
	</table>   	
  <BR>
  <table width="617" height="14"  border="1" align="center" cellpadding="0" cellspacing="0">
    <tr class="ColorTabla01"> 
      <td width="78" align="center">CODIGO</td>
      <td width="294" align="center" colspan="3">DESCRIPCION PRODUCTO</td>
      <td width="75" align="center">PESO</td>
      <td width="82" align="center">PAQUETES</td>
      <td width="76" align="center">UNIDADES</td>
    </tr>
    <?php  
	$Consulta = "SELECT t2.cod_producto,t2.cod_subproducto,t4.descripcion, count(*) as num_paquetes, ";
	$Consulta.= "sum(t2.num_unidades) as unidades, sum(t2.peso_paquetes) as peso  ";
	$Consulta.= "from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2  ";
	$Consulta.= "on t1.num_guia=t2.num_guia and t1.fecha_guia=t2.fecha_embarque inner join proyecto_modernizacion.subproducto t4  ";
	$Consulta.= "on t2.cod_producto = t4.cod_producto and t2.cod_subproducto = t4.cod_subproducto  ";
	$Consulta.= "where t1.cod_estado <>'A' and t1.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."'  ";
	$Consulta.= "group by t2.cod_producto, t2.cod_subproducto ";
	$Consulta.= " and t2.cod_estado = 'c'";
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	$TotalPaquetes = 0;
	$TotalUnidades = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["cod_producto"]."/".$Fila["cod_subproducto"]."</td>\n";
		echo "<td colspan='3'>".$Fila["descripcion"]."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["num_paquetes"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["unidades"],0,",",".")."</td>\n";
		echo "</tr>\n";
		$TotalPeso = $TotalPeso + $Fila["peso"];
		$TotalPaquetes = $TotalPaquetes + $Fila["num_paquetes"];
		$TotalUnidades = $TotalUnidades + $Fila["unidades"];
	}
?>
    <tr class="ColorTabla02"> 
      <td align="left" colspan="4"><strong>TOTALES</strong></td>
      <td align="right"><strong><?php echo number_format($TotalPeso,0,",","."); ?></strong></td>
      <td align="right"><strong><?php echo number_format($TotalPaquetes,0,",","."); ?></strong></td>
      <td align="right"><strong><?php echo number_format($TotalUnidades,0,",","."); ?></strong></td>
    </tr>
  </table>
  <BR>
</form>
</body>
</html>
<?php include("../principal/cerrar_ram_web.php") ?>