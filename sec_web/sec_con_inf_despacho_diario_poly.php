<?php
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
			f.action ="sec_con_inf_despacho_diario_poly.php";
			f.submit();
			break;
		case "E":
			f.action ="sec_con_inf_despacho_diario_excel.php";
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

</script><link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <?php
//   echo "<td align='right'>&nbsp;&nbsp;<img src='../principal/imagenes/logocodelco.gif'>&nbsp;</td>";
    echo "<img src='../principal/imagenes/logocodelco.gif'>";
   ?>
  </tr>
  <tr><strong> PLANIFICACION VENTAS</strong></tr>
  <tr> <strong>DIVISION VENTANAS</strong></tr>  
  <td align="center"><strong>DESPACHO DIARIO </strong></td>
  </tr>
</table>
<form name="frmPrincipal" method="post" action="">
  <table width="850" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
    <tr> 
      <td width="86">Fecha Inicio: </td>
      <td width="259"><SELECT name="DiaIni" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </SELECT> <SELECT name="MesIni" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </SELECT> <SELECT name="AnoIni" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </SELECT></td>
      <td width="119">Fecha Termino:</td>
      <td width="265"><SELECT name="DiaFin" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </SELECT> <SELECT name="MesFin" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </SELECT> <SELECT name="AnoFin" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </SELECT></td>
    </tr>
    <tr> 
      <td colspan="4" align="center"> <input name="btnConsultar" type="button" id="btnConsultar" style="width:70" onClick="JavaScript:Proceso('C')" value="Consultar"> 
        <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')">
		<input name="btnExcel" type="button" id="btnExcel" style="width:70" onClick="JavaScript:Proceso('E')" value="Excel">
        <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"> 
      </td>
    </tr>
	
  </table>
<br>
<?php
		echo "<br>\n";
		echo "<table width='950' height='14'  border='1' align='center' cellpadding='0' cellspacing='0'>\n";
		echo "<tr class='ColorTabla01'>\n";
		echo "<td width='52' align='center'>N� ENVIO</td>\n";
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
		echo "<td width='30' align='center'>CAM.</td>\n";
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
	/*$Consulta = "SELECT distinct t1.fecha_guia  from  sec_web.guia_despacho_emb t1";
	$Consulta.= " where t1.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."'";
	$Consulta.= " and t1.cod_estado <>'A'  order by t1.fecha_guia";
	$Respuesta = mysqli_query($link, $Consulta);
//echo "FF".$Consulta;
		echo 
		mysql_num_rows($Respuesta);*/
		$FechaAux = $FechaInicio;
	while ($FechaInicio<= $FechaTermino)  
	{
	
	
		$Consulta = "SELECT distinct t2.cod_cliente, t1.num_envio, t1.corr_enm, t1.fecha_guia as fecha, t3.descripcion as marca, t3.cod_marca, ";
		$Consulta.= " t2.cod_bulto, t2.num_bulto,t1.peso_bruto,t2.cod_producto, t2.cod_subproducto,t1.patente_guia,t1.rut_chofer,t2.cod_puerto,t2.cod_sub_cliente";
		$Consulta.= " from sec_web.guia_despacho_emb t1 inner join sec_web.embarque_ventana t2 ";
		$Consulta.= " on t1.num_envio = t2.num_envio and t1.corr_enm = t2.corr_enm ";
		$Consulta.= " left join sec_web.marca_catodos t3 ";
		$Consulta.= " on t2.cod_marca = t3.cod_marca";	
		$Consulta.= " where t1.fecha_guia ='".$FechaInicio."'  group by t1.corr_enm order by t1.fecha_guia,t1.num_envio";
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
			$Consulta = "SELECT * ";
			$Consulta.= " from sec_web.programa_codelco ";
			$Consulta.= " where  corr_codelco = '".$Fila["corr_enm"]."'";
			$Consulta.= " and cod_producto = '".$Fila["cod_producto"]."' and cod_subproducto = '".$Fila["cod_subproducto"]."'";
			$Respuesta3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Respuesta3))
			{
				$Consulta = " SELECT t2.num_guia,count(t2.num_paquete) as paquetes, sum(peso_paquetes) pesoneto";
				$Consulta.= " from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2"; 
 				$Consulta.= " on t1.num_guia = t2.num_guia and t1.fecha_guia = t2.fecha_embarque";
				$Consulta.= " where t1.cod_estado <>'A' and t1.fecha_guia = '".$FechaInicio."' and";
				$Consulta.= " t1.num_envio = '".$Fila["num_envio"]."' and t2.cod_estado = 'c' and t1.corr_enm = '".$Fila3["corr_codelco"]."' group by t2.num_guia order by t1.num_envio";
				//echo "Con".$Consulta;
				$Respuesta2 = mysqli_query($link, $Consulta);
				//$TotalPaquetes = 0;
				$TotalUnidades = 0;
				$TotalPeso = 0;
				$PesoBruto = 0;
				$PesoNeto = 0;
				$conta = 0;
				$paquetes = 0;
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
					$TotalCamiones = $TotalCamiones + 1;
				}
					//echo "<tr>\n"; 
				if ($Fila3["corr_codelco"] > 9999)
					echo "<tr bgcolor=\"#FFFF99\">";
				echo "<td>".$Fila["num_envio"]."</td>\n";
				echo "<td>".$Fila["fecha"]."</td>\n";
				echo "<td>".$Fila3["cod_contrato_maquila"]."</td>\n";
				echo "<td>".$NombreCliente."</td>\n";
				echo "<td align='center'>".$Fila3["corr_codelco"]."</td>\n";
				echo "<td align='center'>".$Fila3["cod_producto"]."</td>\n";
				echo "<td align='center'>".$Fila["cod_marca"]."</td>\n";
				echo "<td align='right'>".number_format($paquetes,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($PesoNeto,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($PesoBruto,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($conta,0,",",".")."</td>\n";
				echo "<td align='right'>".number_format($conta,0,",",".")."</td>\n";
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
				$Consulta = "SELECT nom_aero_puerto as puerto from sec_web.puertos ";
				$Consulta.= " where cod_puerto ='".$Fila["cod_puerto"]."'";
				$Respuesta3 = mysqli_query($link, $Consulta);
				
				if ($Fila5 = mysqli_fetch_array($Respuesta3))
				{
					echo "<td>".$Fila5["puerto"]."&nbsp;</td>\n";
				}
				else
				{
					echo "<td>&nbsp;</td>\n";
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
	$Consulta.= "sum(t2.num_unidades) as unidades, sum(t2.peso_paquetes) as peso  ";
	$Consulta.= "from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2  ";
	$Consulta.= "on t1.num_guia=t2.num_guia inner join proyecto_modernizacion.subproducto t4  ";
	$Consulta.= "on t2.cod_producto = t4.cod_producto and t2.cod_subproducto = t4.cod_subproducto  ";
	/*$Consulta.= "inner join sec_web.lote_catodo t3 on t2.fecha_creacion_paquete = t3.fecha_creacion_paquete ";
	$Consulta.= "and t2.cod_paquete = t3.cod_paquete and t2.num_paquete = t3.num_paquete ";*/
	$Consulta.= "where t1.cod_estado <>'A'  and t1.fecha_guia between '".$FechaAux."' and '".$FechaTermino."'  ";
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



</form>
</body>
</html>
<?php include("../principal/cerrar_ram_web.php") ?>
