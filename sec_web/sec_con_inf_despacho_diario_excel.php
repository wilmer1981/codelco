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
	include("../principal/conectar_principal.php"); 
	// $link = mysql_connect('10.56.11.7','adm_bd','672312');
 	//mysql_SELECT_db("sec_web",$link);
	 $AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");
	 $MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	 $DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
 
	 $AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	 $MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
	 $DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d");
	/*
	if (!isset($DiaIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
		$AnoFin = date("Y");
	}
	*/
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
			//f.action ="sec_con_inf_despacho_diario_poly.php";
			f.action ="sec_con_inf_despacho_diario.php?vcontrol=S";
			f.submit();
			break;
		case "E":
			f.action ="sec_con_inf_despacho_diario_excel.php";
			f.submit();
			break;
		case "CA":
			var frm = document.frmPrincipal;
			var FechaInicio = frm.FechaInicio.value;
			var FechaTermino = frm.FechaTermino.value;
			window.open("sec_informe_camiones.php?FechaInicio="+FechaInicio+"&FechaTermino="+FechaTermino,"","statusbar=yes, menubar=no, resizable=yes, top=50, left=50, width=650, height=500, scrollbars=yes");
		//	window.open("sec_informe_camiones.php?Accion=N&Prog=<?php //echo $Programa; ?>","","statusbar=yes, menubar=no, resizable=yes, top=50, left=50, width=650, height=500, scrollbars=yes");
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
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <?php
/*   echo "<td align='right'>&nbsp;&nbsp;<img src='../principal/imagenes/logocodelco.gif'>&nbsp;</td>";
    echo "<img src='../principal/imagenes/logocodelco.gif'>";*/
   ?>
  </tr>
  <tr><strong> UNIDAD LOGISTICA</strong></tr>
  <tr> <strong>DIVISION VENTANAS</strong></tr>
  <td align="center"><strong>DESPACHO DIARIO </strong></td>
  </tr>
</table>
<form name="frmPrincipal" method="post" action="">


<br>
<?php
		echo "<br>\n";
		echo "<table width='700' height='14'  border='1' align='center' cellpadding='0' cellspacing='0'>\n";
		echo "<tr class='ColorTabla01'>\n";
		echo "<td width='30' align='center'>N� ENVIO</td>\n";
		echo "<td width='140' align='center'>FECHA DESPACHO</td>\n";
		echo "<td width='70' align='center'>ASIGNACION</td>\n";
		echo "<td width='50' align='center'>DESTINATARIO.</td>\n";
		echo "<td width='42' align='center'>INST.EMB.</td>\n";
		echo "<td width='64' align='center'>FLUJO</td>\n";
		echo "<td width='51' align='center'>MARCA</td>\n";
		echo "<td width='77' align='center'>PQTE.</td>\n";
		echo "<td width='100' align='center'>PESO NETO</td>\n";
		echo "<td width='100' align='center'>PESO BRUTO</td>\n";
		echo "<td width='45' align='center'>GUIAS</td>\n";
		//echo "<td width='30' align='center'>CAM.</td>\n";
		echo "<td width='91' align='center'>CODIGO</td>\n";
		echo "<td width='110' align='center'>TRANS.</td>\n";
		echo "<td width='91' align='center'>PUERTO</td>\n";
		echo "<td width='120' align='center'>DESTINO</td>\n";
		echo "</tr>\n";
		
	//aqui colocar el whilw controlando la fecha de la guia segun query guardado
	$TotalPaquetes = 0;
	$TotalPesoNeto = 0;
	$TotalPesoBruto = 0;
	$TotalGuias = 0;
	$TotalCamiones = 0;
	$ArregloFecha=0;
		$Borrar="Delete from sec_web.tmp_despacho_diario";
		mysqli_query($link, $Borrar);
		$FechaAux = $FechaInicio;
	while ($FechaInicio<= $FechaTermino)  
	{
		$Consulta = "SELECT distinct t2.cod_cliente, t1.num_envio, t1.corr_enm, t1.fecha_guia as fecha, t3.descripcion as marca, t3.cod_marca, ";
		$Consulta.= " t2.cod_bulto, t2.num_bulto,t1.peso_bruto,t2.cod_producto, t2.cod_subproducto,t1.patente_guia,t1.rut_chofer,t2.cod_puerto,t2.cod_sub_cliente";
		$Consulta.= " from sec_web.guia_despacho_emb t1 inner join sec_web.embarque_ventana t2 ";
		$Consulta.= " on t1.num_envio = t2.num_envio and t1.corr_enm = t2.corr_enm ";
		$Consulta.= " left join sec_web.marca_catodos t3 ";
		$Consulta.= " on t2.cod_marca = t3.cod_marca";	
		$Consulta.= " where t1.fecha_guia ='".$FechaInicio."' and t1.cod_estado != 'A' group by t1.corr_enm order by t1.fecha_guia,t1.num_envio";
		$Respuesta = mysqli_query($link, $Consulta);
	//echo $Consulta;

		while ($Fila = mysqli_fetch_array($Respuesta))
		{	
			$Consulta = "SELECT  * from sec_web.cliente_venta where cod_cliente = '".$Fila["cod_cliente"]."'";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				$NombreCliente = $Fila2["sigla_cliente"];
				$codigo_nave = $Fila["cod_cliente"];
			}
			else
			{
				$Consulta = "SELECT  * from sec_web.nave where cod_nave = '".intval($Fila["cod_cliente"])."'";
				$Respuesta2 = mysqli_query($link, $Consulta);
				if ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$NombreCliente = $Fila2["nombre_nave"];
					$codigo_nave = $Fila2["cod_nave"];
				}
				else
				{
					$NombreCliente = "&nbsp;";
					$codigo_nave = " ";

				}
			}
			$conta = 0;
			$Consulta = "SELECT * ";
			$Consulta.= " from sec_web.programa_codelco ";
			$Consulta.= " where  corr_codelco = '".$Fila["corr_enm"]."'";
			$Consulta.= " and cod_producto = '".$Fila["cod_producto"]."' and cod_subproducto = '".$Fila["cod_subproducto"]."'";
			$Respuesta3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Respuesta3))
			{
				$Consulta = " SELECT t2.num_guia,count(t2.num_paquete) as paquetes, sum(peso_paquetes) pesoneto,t1.patente_guia";
				$Consulta.= " from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2"; 
 				$Consulta.= " on t1.num_guia = t2.num_guia and t1.fecha_guia = t2.fecha_embarque";
				$Consulta.= " where t1.cod_estado <>'A' and t1.fecha_guia = '".$FechaInicio."' and";
				$Consulta.= " t1.num_envio = '".$Fila["num_envio"]."' and t2.cod_estado = 'c' ";
				$Consulta.=" and t1.corr_enm = '".$Fila3["corr_codelco"]."' group by t2.num_guia order by t1.num_envio";
				//echo "Con".$Consulta;
				$Respuesta2 = mysqli_query($link, $Consulta);
				
				//$TotalPaquetes = 0;
				$TotalUnidades = 0;
				$TotalPeso = 0;
				$PesoBruto = 0;
				$PesoNeto = 0; 
				
				$paquetes = 0;
				$PatenteAux='';
				$pate=0;
				
				while ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					$PesoBruto = $PesoBruto + $Fila2["pesoneto"] + $Fila2["paquetes"];
					$PesoNeto = $PesoNeto + $Fila2["pesoneto"];
				
					$conta = $conta + 1;
					$paquetes = $paquetes + $Fila2["paquetes"];
					$TotalPaquetes = $TotalPaquetes + $Fila2["paquetes"];
					$TotalPesoNeto = $TotalPesoNeto + $Fila2["pesoneto"];
					$TotalPesoBruto = $TotalPesoBruto + $Fila2["pesoneto"] + $Fila2["paquetes"];
					$TotalGuias = $TotalGuias + 1;
					
				}
					//echo "<tr>\n"; 
				if ($Fila3["corr_codelco"] > 15000)
					echo "<tr bgcolor=\"#FFFF99\">";
				echo "<td>".$Fila["num_envio"]."</td>\n";
				echo "<td>".$Fila["fecha"]."</td>\n";
				echo "<td>".$Fila3["cod_contrato_maquila"]."</td>\n";
				echo "<td>".$NombreCliente."</td>\n";
				echo "<td align='center'>".$Fila3["corr_codelco"]."</td>\n";
				echo "<td align='center'>".$Fila3["cod_producto"]."/".$Fila3["cod_subproducto"]."</td>\n";
				//echo "<td align='center'>".$Fila3["cod_producto"]."</td>\n";
				echo "<td align='center'>".$Fila["cod_marca"]."</td>\n";
				echo "<td align='right'>".number_format($paquetes,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($PesoNeto,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($PesoBruto,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($conta,0,",",".")."</td>\n";
				//echo "<td align='right'>".number_format($pate,0,",",".")."</td>\n";
				echo "<td align='center'>".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."</td>\n";
				$Consulta = "SELECT t2.nombre_transportista as nombre from sec_web.transporte_persona t1 ";
				$Consulta.= " left join sec_web.transporte t2 on t1.rut_transportista=t2.rut_transportista and t1.patente_camion=t2.patente_transporte";
				$Consulta.= " where t1.patente_camion='".$Fila["patente_guia"]."' and t1.rut_chofer='".$Fila["rut_chofer"]."'";
				$Respuesta3 = mysqli_query($link, $Consulta);
				if ($Fila4 = mysqli_fetch_array($Respuesta3))
				{
					echo "<td>".$Fila4["nombre"]."&nbsp;</td>\n";
				}
				else
				{
					echo "<td>&nbsp;</td>\n";
				}
				//puerto
				$Consulta = "SELECT cod_puerto,nom_aero_puerto as puerto from sec_web.puertos ";
				$Consulta.= " where cod_puerto ='".$Fila["cod_puerto"]."'";
				$Respuesta3 = mysqli_query($link, $Consulta);
				
				if ($Fila5 = mysqli_fetch_array($Respuesta3))
				{
					echo "<td>".$Fila5["puerto"]."&nbsp;</td>\n";
					$puerto = $Fila["cod_puerto"];
				}
				else
				{
					echo "<td>&nbsp;</td>\n";
					$puerto = "";
				}
				//destino
				if ($Fila["cod_sub_cliente"] != '*')
				{
					$Consulta = "SELECT  * from sec_web.sub_cliente_vta where cod_cliente = '".$Fila["cod_cliente"]."'";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Fila6 = mysqli_fetch_array($Respuesta2))
						$NombreCliente = $Fila6["ciudad"];
				}
				else
				{
					$Consulta = "SELECT  * from sec_web.puertos where cod_puerto = '".$Fila3["cod_puerto_destino"]."'";
					$Respuesta2 = mysqli_query($link, $Consulta);
					if ($Fila7 = mysqli_fetch_array($Respuesta2))
					{
						$NombreCliente = $Fila7["nom_aero_puerto"];
					}
					else
					{
					$NombreCliente = "&nbsp;";
					}
				}
					echo "<td>".$NombreCliente."&nbsp;</td>\n";
				//	echo "FFFF".$Fila["fecha"]."***".$codigo_nave."***".$puerto;
					$Insertar= "insert into sec_web.tmp_despacho_diario(puerto,fecha,asignacion,nave,enm,producto,subproducto,paquetes,peso_neto,peso_bruto,camiones)"; 
					$Insertar.=" values('".$puerto."','".$Fila["fecha"]."','".$Fila3["cod_contrato_maquila"]."','".$codigo_nave."','".$Fila3["corr_codelco"]."',";
					$Insertar.=" '".$Fila3["cod_producto"]."','".$Fila3["cod_subproducto"]."','".$paquetes."',";
					$Insertar.=" '".$PesoNeto."','".$PesoBruto."','".$pate."')";
					mysqli_query($link, $Insertar);
					//echo "III".$Insertar;  
				echo "</tr>\n";	
			}
		}
		$consulta = "SELECT DATE_ADD('".$FechaInicio."',INTERVAL 1 DAY) AS fecha";
		$rs10 = mysqli_query($link, $consulta);
		$row10 = mysqli_fetch_array($rs10);
		$FechaInicio = $row10["fecha"];				
	}	
	?>
	<tr class="ColorTabla02">
	<?php
	
	//echo "<tr class="ColorTabla02">\n";
		echo "<td colspan='7'><strong></strong></td>\n";
		echo "<td align='right'><strong>".number_format($TotalPaquetes,0,",",".")."</strong></td>\n";
		echo "<td align='right'><strong>".number_format($TotalPesoNeto,0,",",".")."</strong></td>\n";
		echo "<td align='right'><strong>".number_format($TotalPesoBruto,0,",",".")."</strong></td>\n";
		echo "<td align='right'><strong>".number_format($TotalGuias,0,",",".")."</strong></td>\n";
		echo "<td align='right'><strong>".number_format($TotalCamiones,0,",",".")."</strong></td>\n";
		echo "<td colspan='7'>&nbsp;</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "<br>";
?>	

	<br>
  <table width="617" height="14"  border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="500" align="center">RESUMEN DESPACHO DIARIO </td>
	 </tr>
	</table>   	
  <BR>
  <table width="617" height="14"  border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="78" align="center">FLUJO</td>
      <td width="294" align="center">PRODUCTO</td>
	    <td width="82" align="center">PAQUETES</td>
      <td width="75" align="center">PESO NETO</td>
	   
	   
    </tr>
    <?php  


    $Consulta = "SELECT t2.fecha_creacion_paquete, t2.cod_producto,t2.cod_subproducto,t4.descripcion, count(*) as num_paquetes, ";
	$Consulta.= "sum(t2.num_unidades) as unidades, sum(t2.peso_paquetes) as peso ";
	$Consulta.= "from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.= "on t1.num_guia=t2.num_guia and t1.fecha_guia=t2.fecha_embarque inner join proyecto_modernizacion.subproducto t4 ";
	$Consulta.= "on t2.cod_producto = t4.cod_producto and t2.cod_subproducto = t4.cod_subproducto ";
	/*$Consulta.= "inner join sec_web.lote_catodo t3 on t2.fecha_creacion_paquete = t3.fecha_creacion_paquete ";
	$Consulta.= "and t2.cod_paquete = t3.cod_paquete and t2.num_paquete = t3.num_paquete ";*/
	$Consulta.= "where t1.cod_estado <>'A' and t1.fecha_guia between '".$FechaAux."' and '".$FechaTermino."' ";
	$Consulta.= " and t2.cod_estado = 'c'";
	$Consulta.= "group by t2.cod_producto, t2.cod_subproducto ";

	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	//echo $Consulta;
	$TotalPaquetes = 0;
	$TotalUnidades = 0;            
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["cod_producto"]."/".$Fila["cod_subproducto"]."</td>\n";
		echo "<td>".$Fila["descripcion"]."</td>\n";
		
		echo "<td align='right'>".number_format($Fila["num_paquetes"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";
		echo "</tr>\n";
		$TotalPeso = $TotalPeso + $Fila["peso"];
		$TotalPaquetes = $TotalPaquetes + $Fila["num_paquetes"];
		
	}
?>
    <tr class="ColorTabla02"> 
      <td align="left" colspan="2"><strong>TOTALES</strong></td>
   
      <td align="right"><strong><?php echo number_format($TotalPaquetes,0,",","."); ?></strong></td>
	     <td align="right"><strong><?php echo number_format($TotalPeso,0,",","."); ?></strong></td>
    
    </tr>
  </table>
  <BR>
<?php
//aqui resumen por nave 
?>
	<br>
  <table width="617" height="14"  border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="500" align="center">RESUMEN DESPACHO DIARIO POR PUERTOS </td>
	 </tr>
	</table>   	
  <BR>
  
  <table width="617" height="14"  border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
 

    <tr class="ColorTabla01">
	 	<td width="82" align="center">PUERTO</td>

      <td width="200" align="center">MOTONAVE</td>
      <td width="100" align="center">ASIGNACION</td>
	   <td width="50" align="center">FLUJO</td>
		 <td width="82" align="center">PAQUETES</td>
		 
      <td width="75" align="center">PESO NETO</td>
    <td width="75" align="center">PESO BRUTO</td>
    
    </tr>
    <?php  
//saco resumen de tabla tmp_despacho_diario


		$TotalP = 0;
		$TotalN = 0;
		$TotalB = 0;
		$TotalC = 0;

		
		$Consulta = "SELECT distinct  puerto from sec_web.tmp_despacho_diario";
		$Consulta.= " where enm < 15000";
		
		$Resp1= mysqli_query($link, $Consulta);

		while ($Row = mysqli_fetch_array($Resp1))
		{

			if ($Row["puerto"] != "")
			{
				$Consulta = "SELECT nom_aero_puerto from sec_web.puertos";
				$Consulta.= " where cod_puerto = '".$Row["puerto"]."'";
				
				$Resp2 = mysqli_query($link, $Consulta);
				while ($Fila1 = mysqli_fetch_array($Resp2))
				{
					$TotalPuertoPaq = 0;
					$TotalPuertoN = 0;
					$TotalPuertoB = 0;
					$TotalPuertoC = 0;

					//echo "WW".$Consulta;
					echo  "<tr>\n";
					echo "<td>".$Fila1["nom_aero_puerto"]."</td>\n";
					echo "<td>&nbsp;</td>\n";
					echo "<td>&nbsp;</td>\n";
					echo "<td>&nbsp;</td>\n";
					echo "<td>&nbsp;</td>\n";
					echo "<td>&nbsp;</td>\n";
					//echo "<td>&nbsp;</td>\n";
					echo  "</tr>\n";
					$Consulta = " SELECT distinct nave from sec_web.tmp_despacho_diario";
					$Consulta.= " where puerto = '".$Row["puerto"]."' and enm < 15000";
					$Resp3= mysqli_query($link, $Consulta);
					while ($Fila4 = mysqli_fetch_array($Resp3))
					{
						$Consulta = "SELECT nombre_nave from sec_web.nave";
						$Consulta.= " where cod_nave = '".$Fila4["nave"]."'";
						$Resp4 = mysqli_query($link, $Consulta);
						$Fila2=mysqli_fetch_array($Resp4);
						$TotalPaquetes=0;
						$TotalNaveN =0;
						$TotalNaveB =0;
						$TotalCamionesNave=0;
						echo  "<tr>\n";
						echo "<td>&nbsp;</td>\n";
						echo "<td>".$Fila2["nombre_nave"]."</td>\n";
						echo "<td>&nbsp;</td>\n";
						echo "<td>&nbsp;</td>\n";
						echo "<td>&nbsp;</td>\n";
						echo "<td>&nbsp;</td>\n";
						echo "<td>&nbsp;</td>\n";
					//	echo "<td>&nbsp;</td>\n";
						echo  "</tr>\n";
						$Consulta = " SELECT distinct asignacion  from sec_web.tmp_despacho_diario";
						$Consulta.= " where puerto = '".$Row["puerto"]."' and nave = '".$Fila4["nave"]."' and enm < 15000";
						$Respasig= mysqli_query($link, $Consulta);
						while ($Filaasig = mysqli_fetch_array($Respasig))
						{
						
							$TotalAsigN		= 0;
							$TotalAsigB		= 0;
							$TotalAsigP		= 0;	
							echo  "<tr>\n";
							echo "<td>&nbsp;</td>\n";
							echo "<td>&nbsp;</td>\n";
							echo "<td>".$Filaasig["asignacion"]."</td>\n";
							echo "<td>&nbsp;</td>\n";
							echo "<td>&nbsp;</td>\n";
							echo "<td>&nbsp;</td>\n";
							echo "<td>&nbsp;</td>\n";
							//echo "<td>&nbsp;</td>\n";

							$Consulta = "SELECT producto,subproducto,sum(paquetes) as paquetes,sum(peso_neto) as neto,sum(peso_bruto) as bruto,";
							$Consulta.=" sum(camiones) as camiones from sec_web.tmp_despacho_diario";
							$Consulta.= " where puerto = '".$Row["puerto"]."'";
							$Consulta.= " and nave = '".$Fila4["nave"]."' and asignacion = '".$Filaasig["asignacion"]."' and enm < 15000"; 
							$Consulta.= " group by puerto,nave,asignacion,producto,subproducto"; 
							$Resp5= mysqli_query($link, $Consulta);
								while ($Fila3 = mysqli_fetch_array($Resp5))
								{
									echo  "<tr>\n";
									echo "<td>&nbsp;</td>\n";
									echo "<td>&nbsp;</td>\n";
									echo "<td>&nbsp;</td>\n";
									echo "<td>".$Fila3["producto"]."/".$Fila3["subproducto"]. "</td>\n";
									echo "<td align='right'>".number_format($Fila3["paquetes"],0,",",".")."</td>\n";
									echo "<td align='right'>".number_format($Fila3["neto"],0,",",".")."</td>\n";
									echo "<td align='right'>".number_format($Fila3["bruto"],0,",",".")."</td>\n";
									//echo "<td>&nbsp;</td>\n";
									echo  "</tr>\n";
									//Total asignacion
									$TotalAsigN		= $TotalAsigN	 + $Fila3["neto"];
									$TotalAsigB		= $TotalAsigB	 + $Fila3["bruto"];
									$TotalAsigP		= $TotalAsigP	 + $Fila3["paquetes"];	
									
									//Total Nave		
									$TotalNaveN   = $TotalNaveN  	+  $Fila3["neto"];
									$TotalNaveB   = $TotalNaveB  	+  $Fila3["bruto"];
									$TotalPaquetes  = $TotalPaquetes +  $Fila3["paquetes"];
									
									$TotalCamionesNave = $TotalCamionesNave + $Fila3["camiones"];
									
									//Total Puerto
									$TotalPuertoPaq = $TotalPuertoPaq +  $Fila3["paquetes"];
									$TotalPuertoN = $TotalPuertoN 	  +  $Fila3["neto"];
									$TotalPuertoB = $TotalPuertoB     +  $Fila3["bruto"];
									$TotalPuertoC = $TotalPuertoC     +  $Fila3["camiones"];
									//Total Total
									$TotalP = $TotalP + $Fila3["paquetes"];
									$TotalN = $TotalN + $Fila3["neto"];
									$TotalB = $TotalB + $Fila3["bruto"];
									$TotalC = $TotalC + $Fila3["camiones"];
									
							}
							
							echo "<tr class='ColorTabla02'>";
							
							echo "<td align'left' colspan='4'<strong>TOTAL ASIGNACION</srtong></td>\n";
						//	echo "<td align 'left' colspan='2'</td>\n";
						//	echo "<td>&nbsp;</td>\n";
						//	echo "<td>&nbsp;</td>\n";
							echo "<td align='right'>".number_format($TotalAsigP,0,",",".")."</td>\n";
							echo "<td align='right'>".number_format($TotalAsigN,0,",",".")."</td>\n";
							echo "<td align='right'>".number_format($TotalAsigB,0,",",".")."</td>\n";
							echo  "</tr>\n";

						}	
							
							
						echo "<tr class='ColorTabla02'>";
						
						echo "<td align'left' colspan='4'<strong>TOTAL MOTONAVE</srtong></td>\n";
						//echo "<td align 'left' colspan='1'</td>\n";
						//echo "<td>&nbsp;</td>\n";
						echo "<td align='right'>".number_format($TotalPaquetes,0,",",".")."</td>\n";
						echo "<td align='right'>".number_format($TotalNaveN,0,",",".")."</td>\n";
						echo "<td align='right'>".number_format($TotalNaveB,0,",",".")."</td>\n";
					//	echo "<td align='right'>".number_format($TotalCamionesNave,0,",",".")."</td>\n";
						
						echo  "</tr>\n";
					}
					echo "<tr class='ColorTabla01'>";
					echo "<td align'left' colspan='4'<strong>TOTAL PUERTO</srtong></td>\n";
					echo "<td align='right'>".number_format($TotalPuertoPaq,0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($TotalPuertoN,0,",",".")."</td>\n";
					echo "<td align='right'>".number_format($TotalPuertoB,0,",",".")."</td>\n";
				//	echo "<td align='right'>".number_format($TotalPuertoC,0,",",".")."</td>\n";
					
					echo  "</tr>\n";
				}	
			}	
		}
		$Consulta = "SELECT sum(paquetes) as otro_paquetes,sum(peso_neto) as otro_neto,sum(peso_bruto) as otro_bruto,";
		$Consulta.= " sum(camiones) as otro_camiones from sec_web.tmp_despacho_diario  where (puerto = '' ||  enm > 15000)";
		$Resp6= mysqli_query($link, $Consulta);
		if ($Fila6 = mysqli_fetch_array($Resp6))
		{
			echo "<tr class='ColorTabla01'>";
			echo "<td align'left' colspan='4'<strong>OTROS DESPACHOS</srtong></td>\n";
			echo "<td align='right'>".number_format($Fila6["otro_paquetes"],0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fila6["otro_neto"],0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fila6["otro_bruto"],0,",",".")."</td>\n";
		//	echo "<td align='right'>".number_format($Fila6["otro_camiones"],0,",",".")."</td>\n";
			echo  "</tr>\n";
		}
		$TotalP = $TotalP + $Fila6["otro_paquetes"];
		$TotalN = $TotalN + $Fila6["otro_neto"];
		$TotalB = $TotalB + $Fila6["otro_bruto"];
		$TotalC = $TotalC + $Fila6["otro_camiones"];
		echo "<tr class='ColorTabla01'>";
		echo "<td align'left' colspan='4'<strong>TOTAL DESPACHO</srtong></td>\n";
		echo "<td align='right'>".number_format($TotalP,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($TotalN,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($TotalB,0,",",".")."</td>\n";
		//echo "<td align='right'>".number_format($TotalC,0,",",".")."</td>\n";
		echo  "</tr>\n";

?>		
  </table>
  <BR>

</form>
</body>
</html>
<?php include("../principal/cerrar_ram_web.php") ?>
