<?php
	include("../principal/conectar_principal.php"); 

	$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date('d');
	$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date('m');
	$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date('Y');
	$DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date('d');
	$MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date('m');
	$AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date('Y');

	$NumSolicitud = isset($_REQUEST["NumSolicitud"])?$_REQUEST["NumSolicitud"]:"";

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
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sec_con_num_solicitud.php";
			f.submit();
			break;
		case "E":
			f.action ="sec_con_num_solicitud_excel.php";
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

<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><strong>CONSULTA PROGRAMA DE LOTEO</strong></td>
    </tr>
  </table>
  <br>
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
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
      <td>Num. Prog:</td>
      <td><input name="NumSolicitud" type="text" id="NumSolicitud" value="<?php echo $NumSolicitud; ?>"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="4" align="center"> <input name="btnConsultar" type="button" style="width:70" onClick="JavaScript:Proceso('C')" value="Consultar"> 
        <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')">
        <input name="btnExcel" type="button" id="btnExcel" style="width:70" onClick="JavaScript:Proceso('E')" value="Excel">
        <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"> 
      </td>
    </tr>
  </table>
<br>
  <table width="847" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width='54' align="center">Prog.N�</td>
      <td width='57' align="center">I.E</td>
      <td width='83' align="center">PTO. EMB.</td>
      <td width='45' align="center">PTO. DEST.</td>
      <td width='74' align="center">Nave/Cliente</td>
      <td width='62' align="center">Fecha Prog.</td>
      <td width='58' align="center">Fecha Emb</td>
      <td width='79' align="center">Peso Prog.</td>
      <td width='78' align="center">Peso Prep.</td>
      <td width='64' align="center">Diferencia</td>
      <td width='78' align="center">N� Lote</td>
      <td width="41" align="center">Est.</td>
    </tr>    
    <?php			
			$CrearTmp = "create temporary table if not exists sec_web.tmpprograma "; 
			$CrearTmp.= "(corr_ie bigint(8),cliente_nave varchar(30),fecha date,fecha_programacion date,";
			$CrearTmp.= "cantidad_programada bigint(8),num_prog_loteo varchar(3),producto varchar(30),";
			$CrearTmp.= "subproducto varchar (30),pto_destino varchar (30),pto_emb varchar (30),";
			$CrearTmp.= "tipo char(1),cod_contrato varchar(10),estado char(1),fecha_disponible date, enm_code char(1),";
			$CrearTmp.= "cod_puerto varchar(3),cod_puerto_destino varchar(3))";
			mysqli_query($link, $CrearTmp);
			//CONSULTA TABLA PROGRAMA ENAMI
			$Consulta = "SELECT t1.fecha_disponible,t1.estado2,t6.descripcion as producto,t2.descripcion as subproducto,t3.nom_aero_puerto as pto_emb,t4.nom_aero_puerto as pto_destino,t5.sigla_cliente,";
			$Consulta.= "t1.eta_programada,t1.corr_enm,t1.cantidad_embarque,t1.num_prog_loteo, t1.cod_puerto, t1.cod_puerto_destino";
			$Consulta.= " from sec_web.programa_enami t1";
			$Consulta.= " left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta.= " left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta.= " left join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto ";
			$Consulta.= " left join sec_web.puertos t4 on t1.cod_puerto_destino=t4.cod_puerto ";
			$Consulta.= " left join sec_web.cliente_venta t5 on t1.cod_cliente=t5.cod_cliente ";
			$Consulta.= " where t1.tipo <> 'V' and t1.estado2 <>'C' and ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo)))";
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar = "insert into sec_web.tmpprograma (corr_ie,fecha_programacion, cliente_nave,cantidad_programada,num_prog_loteo ,producto,subproducto,";
				$Insertar.= "pto_destino ,pto_emb,tipo,estado,fecha_disponible,enm_code, cod_puerto, cod_puerto_destino) values(";
				$Insertar.= "'".$Fila["corr_enm"]."', '".$Fila["eta_programada"]."','".$Fila["sigla_cliente"]."','".$Fila["cantidad_embarque"]."','".$Fila["num_prog_loteo"]."','".$Fila["producto"]."','".$Fila["subproducto"]."','".$Fila["pto_destino"]."','".$Fila["pto_emb"]."','E',";
				$Insertar.= "'".$Fila["estado2"]."','".$Fila["fecha_disponible"]."','E','".$Fila["cod_puerto"]."','".$Fila["cod_puerto_destino"]."')";
				mysqli_query($link, $Insertar);
			}
			//CONSULTA TABLA PROGRAMA CODELCO
			$Consulta = "SELECT t1.fecha_disponible,t1.fecha_programacion,t1.estado2,";
			$Consulta.= " (case when not isnull(t3.nombre_cliente) then t3.nombre_cliente else t4.nombre_nave end) as nombre_cliente,";
			$Consulta.= " t1.corr_codelco,t6.descripcion as producto,t2.descripcion as subproducto,t1.cantidad_programada,t1.num_prog_loteo";
			$Consulta.= " from sec_web.programa_codelco t1";
			$Consulta.= " left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
			$Consulta.= " left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta.= " left join sec_web.cliente_venta t3 on t1.cod_cliente=t3.cod_cliente ";
			$Consulta.= " left join sec_web.nave t4 on ceiling(t1.cod_cliente)=t4.cod_nave ";
			$Consulta.= " where t1.estado2 <>'C' and ((t1.num_prog_loteo <>'')||(not isnull(t1.num_prog_loteo)))";
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar = "insert into sec_web.tmpprograma (corr_ie,fecha_programacion,cliente_nave,cantidad_programada,num_prog_loteo ,producto,subproducto,tipo,estado,fecha_disponible,enm_code) values(";
				$Insertar.= "'".$Fila["corr_codelco"]."', '".$Fila["fecha_programacion"]."','".$Fila["nombre_cliente"]."','".$Fila["cantidad_programada"]."','".$Fila["num_prog_loteo"]."','".$Fila["producto"]."','".$Fila["subproducto"]."','C',";
				$Insertar.= " '".$Fila["estado2"]."','".$Fila["fecha_disponible"]."','C')";
				mysqli_query($link, $Insertar);   
			}
			$Consulta = "SELECT * from sec_web.tmpprograma ";
			$Consulta.= " where fecha_programacion between '".$FechaInicio."' and '".$FechaTermino."'";
			if ($NumSolicitud != "")
				$Consulta.= " and num_prog_loteo = '".$NumSolicitud."'";
			$Consulta.= " order by fecha_programacion, num_prog_loteo";
			$Respuesta = mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckProgLoteo'><input type='hidden' name ='NumProgLoteo'><input type='hidden' name='CheckFecha'>";
			$TotalPesoProgramado = 0;
			$TotalPesoPreparado = 0;
			$TotalDiferencia = 0;
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Consulta="SELECT t1.cod_bulto,t1.num_bulto,sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
				$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
				$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_ie"]." and t1.cod_estado='a' group by t1.corr_enm";
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2);
				$MostrarBoton=true;
				echo "<tr>"; 
				$Cont2++;
				echo "<td width='85' align='center'>".$Fila["num_prog_loteo"]."</td>";
				echo "<td width='40'>".$Fila["corr_ie"]."</td>";
				$Consulta = "SELECT * from sec_web.puertos where cod_puerto = '".$Fila["cod_puerto"]."'";
				$Respuesta3 = mysqli_query($link, $Consulta);
				if ($Fila3 = mysqli_fetch_array($Respuesta3))					
					echo "<td width='205'>".$Fila3["nom_aero_puerto"]."</td>";
				else
					echo "<td width='205'>&nbsp;</td>";
				$Consulta = "SELECT * from sec_web.puertos where cod_puerto = '".$Fila["cod_puerto_destino"]."'";
				$Respuesta3 = mysqli_query($link, $Consulta);
				if ($Fila3 = mysqli_fetch_array($Respuesta3))					
					echo "<td width='205'>".$Fila3["nom_aero_puerto"]."&nbsp;</td>";
				else
					echo "<td width='205'>&nbsp;</td>";
				echo "<td width='205'>".$Fila["cliente_nave"]."&nbsp;</td>";
				echo "<td width='100' align='center'>".substr($Fila["fecha_programacion"],8,2)."/".substr($Fila["fecha_programacion"],5,2)."/".substr($Fila["fecha_programacion"],0,4)."</td>";
				echo "<td width='100' align='center'>".substr($Fila["fecha_disponible"],8,2)."/".substr($Fila["fecha_disponible"],5,2)."/".substr($Fila["fecha_disponible"],0,4)."</td>";
				echo "<td width='80' align='right'>".number_format(($Fila["cantidad_programada"]*1000),0,",",".")."</td>";
				echo "<td width='100' align='right'>".number_format($Fila2["peso_preparado"],0,",",".")."&nbsp;</td>";
				echo "<td width='100' align='right'>".number_format(abs($Fila["cantidad_programada"]*1000-$Fila2["peso_preparado"]),0,",",".")."&nbsp;</td>";
				$TotalPesoProgramado = $TotalPesoProgramado + ($Fila["cantidad_programada"]*1000);
				$TotalPesoPreparado = $TotalPesoPreparado + $Fila2["peso_preparado"];
				$TotalDiferencia = $TotalDiferencia + abs($Fila["cantidad_programada"]*1000-$Fila2["peso_preparado"]);
				if ($Fila2["cod_bulto"] != "")
					echo "<td width='80' align='right'>".$Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</td>";
				else
					echo "<td width='80' align='right'>&nbsp;</td>";
				echo "<td width='40' align='center'>";
				if ($Fila["estado"] != "")
					echo $Fila["estado"];
				else
					echo "&nbsp;";
				echo "</td>";
				echo "</tr>";
			}
		?>
<tr>
      <td align="center" colspan="7"><div align="right"><strong>TOTALES</strong></div></td>
      <td align="right"><strong><?php echo number_format($TotalPesoProgramado,0,",","."); ?></strong></td>
      <td align="right"><strong><?php echo number_format($TotalPesoPreparado,0,",","."); ?></strong></td>
      <td align="right"><strong><?php echo number_format($TotalDiferencia,0,",","."); ?></strong></td>
      <td align="center" colspan="2">&nbsp;</td>	  
    </tr>		
  </table>
</form>
</body>
</html>
