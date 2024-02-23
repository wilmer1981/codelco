<?php
	include("../principal/conectar_principal.php"); 

	$Buscar = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";

	$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");
	$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");

	$AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	$MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
	$DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d");


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
<title>Sistema SEC-WEB</title>
<link rel="stylesheet" href="../Principal/estilos/css_principal.css" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sec_con_inf_grupo_cuba_por_calidad_quimica.php?Buscar=S";
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
function Historial(SA,Rec)
{
	window.open("../cal_web/cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><strong>CLASIFICACION POR  CALIDAD QUIMICA DE CATODOS</strong></td>
    </tr>
  </table>
  <br>
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
    <tr> 
      <td width="120" height="22">Fecha Inicio:</td>
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
      <td width="355">Fecha Termino: 
        <SELECT name="DiaFin" style="width:50px;">
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
    <tr align="center"> 
      <td height="22" colspan="3"> <input type="Button" name="Submit" value="Consultar" onClick="Proceso('C')"> 
        <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')"> 
        <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"> 
      </td>
    </tr>
    <tr> 
      <td height="22"><strong>PRODUCTO:</strong></td>
      <td height="22" colspan="2"><strong> 
        <?php 
	$Consulta = "SELECT * from proyecto_modernizacion.productos where cod_producto = '18' order by descripcion";     
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))                   
		echo $Fila["descripcion"];
	else
		echo "&nbsp;";
	?>
        </strong></td>
    </tr>
    <tr> 
      <td height="22"><strong>SUBPRODUCTO:</strong></td>
      <td height="22" colspan="2"><strong>Todos (Excepto Electrowing)</strong></td>
    </tr>
  </table>
<br>
<table width="550" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
 <tr align="center"><td colspan="5" class="ColorTabla02">CATODOS COMERCIALES</td></tr>
  <tr align="center" class="ColorTabla01"> 
    <td width="80">FECHA PESAJE</td>
    <td  width="70">GRUPO</td>
    <td width="152">TIPO SUB PRODUCTO<br>
      (CALIDAD) </td>
    <td width="99">NRO SOLICITUD</td>
    <td width="66">ESTADO</td>
  </tr>
  <?php
	if ($Buscar==S)
	{
		$TotalPeso = 0;
		$Consulta = " SELECT distinct t1.nro_solicitud,t1.recargo,t1.id_muestra,t1.fecha_muestra from cal_web.solicitud_analisis t1 ";
		$Consulta.= " where (t1.cod_periodo='1') and (t1.estado_actual = '6') and cod_analisis='1' and t1.cod_producto ='18' and t1.cod_subproducto not in ('3','4','5','6','7','8','9','10') and (left(t1.fecha_muestra,10) between '$FechaInicio' and '$FechaTermino') order by t1.fecha_muestra,t1.nro_solicitud ";		
		//echo "uno".$Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$cont = 0;$Valor = 0;$Grado_A = 0;$Astm = 0;$Class = '';
			$Grupo = $Fila["id_muestra"];
			$nro_solicitud = $Fila["nro_solicitud"];
			$Recargo=$Fila["recargo"]; 
			$estado = $Fila["estado_actual"];
			$Consulta = " SELECT * from cal_web.leyes_por_solicitud where nro_solicitud = '".$Fila["nro_solicitud"]."' and recargo = '".$Fila["recargo"]."'";
			//echo "dos".$Consulta."<br>";
			$rs = mysqli_query($link, $Consulta);
			$conta_a_co = 0;$conta_a_enm = 0;$conta_r = 0;$conta_s = 0;$Recargo = "";$estado = 0;					
			while($row = mysqli_fetch_array($rs))
			{				
				$Consulta = "SELECT * FROM cal_web.clasificacion_catodos WHERE cod_leyes = '".$row["cod_leyes"]."' ";
				//echo "tres".$Consulta;
				$Rs = mysqli_query($link, $Consulta);
				if($fila = mysqli_fetch_array($Rs))
				{
					if ($row["valor"] <= $fila["grado_a_codelco"])
						$conta_a_co = 1;
					else	
						if (($row["valor"] <= $fila["grado_a_enami"])&&($row["valor"] > $fila["grado_a_codelco"])) 
							$conta_a_enm = 1;
						else	
							if ($row["valor"] <= $fila["rechazo"]&&($row["valor"] > $fila["grado_a_enami"]))
								$conta_r = 1;
							else	
								if ($row["valor"] <= $fila["estandar"]&&($row["valor"] > $fila["rechazo"]))
									$conta_s = 1;
					$cont = $cont + 1;
				}
			}
			if($cont != 0)
			{
				if ($conta_s == 1)
					$Class = "ESTANDAR";
				else
					if ($conta_r == 1)
						$Class = "RECHAZO";
					else
						if($conta_a_enm == 1)
							$Class = "GRADO A ENAMI";
						else
							$Class = "GRADO A";
			}
			
			
			//echo "<tr class=\"Detalle01\">\n";		
			echo "<tr>\n";
			echo "<td  align='center'>".substr($Fila["fecha_muestra"],8,2)."/".substr($Fila["fecha_muestra"],5,2)."/".substr($Fila["fecha_muestra"],0,4)."</td>\n";		
			echo "<td class=\"Detalle01\" align='center'>".$Grupo."</td>\n";
			echo "<td align='center'>".$Class."</td>\n";									
			if ($nro_solicitud == "")					
				echo "<td align='center'>&nbsp;</td>\n";					
			else
				echo "<td align='center'><a href=\"JavaScript:Historial('".$nro_solicitud."','".$Recargo."')\" class=\"LinksAzul\">".$nro_solicitud."</a></td>\n";		
			echo "<td align='center'>Finalizada</td>\n";					
			echo "</tr>\n";
		}
	}	
?>
</table>
<br>
<table width="550" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
 <tr align="center"><td colspan="7" class="ColorTabla02">CATODOS EW VENTANAS</td></tr>
  <tr align="center" class="ColorTabla01"> 
    <td width="80">FECHA PESAJE</td>
    <td width="70">GRUPO/CUBA</td>
    <td width="152">TIPO SUB PRODUCTO<br>
      (CALIDAD) </td>
    <td width="99">NRO SOLICITUD</td>
    <td width="66">ESTADO</td>
  </tr>
  <?php
	if ($Buscar==S)
	{
		$TotalPeso = 0;
		$Consulta = " SELECT distinct t1.nro_solicitud,t1.recargo,t1.id_muestra,t1.fecha_muestra from cal_web.solicitud_analisis t1 ";
		$Consulta.= " where (t1.cod_periodo='1') and (t1.estado_actual = '6') and t1.cod_producto ='18' and t1.cod_subproducto in ('3','4') and (left(t1.fecha_muestra,10) between '$FechaInicio' and '$FechaTermino') order by t1.fecha_muestra,t1.nro_solicitud ";		
		//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$cont = 0;$Valor = 0;$Grado_A = 0;$Astm = 0;$Class = '';
			$Grupo = $Fila["id_muestra"];
			$nro_solicitud = $Fila["nro_solicitud"];
			$Recargo=$Fila["recargo"]; 
			$estado = $Fila["estado_actual"];
			$Consulta = " SELECT * from cal_web.leyes_por_solicitud where nro_solicitud = '".$Fila["nro_solicitud"]."' and recargo = '".$Fila["recargo"]."'";
			//echo $Consulta."<br>";
			$rs = mysqli_query($link, $Consulta);
			$conta_a_co = 0;$conta_a_enm = 0;$conta_r = 0;$conta_s = 0;$Recargo = "";$estado = 0;					
			while($row = mysqli_fetch_array($rs))
			{				
				$Consulta = "SELECT * FROM cal_web.clasificacion_catodos WHERE cod_leyes = $row["cod_leyes"]";
				//echo $Consulta;
				$Rs = mysqli_query($link, $Consulta);
				if($fila = mysqli_fetch_array($Rs))
				{
					if ($row["valor"] <= $fila["grado_a_codelco"])
						$conta_a_co = 1;
					if (($row["valor"] <= $fila["grado_a_enami"])&&($row["valor"] > $fila["grado_a_codelco"])) 
						$conta_a_enm = 1;
					if ($row["valor"] <= $fila["rechazo"]&&($row["valor"] > $fila["grado_a_enami"]))
						$conta_r = 1;
					if ($row["valor"] <= $fila["estandar"]&&($row["valor"] > $fila["rechazo"]))
						$conta_s = 1;
					$cont = $cont + 1;
				}
			}
			if($cont != 0)
			{
				if ($conta_s == 1)
					$Class = "ESTANDAR";
				else
					if ($conta_r == 1)
						$Class = "RECHAZO";
					else
						if($conta_a_enm == 1)
							$Class = "GRADO A ENAMI";
						else
							$Class = "GRADO A";
			}
			echo "<tr>\n";
			echo "<td  align='center'>".substr($Fila["fecha_muestra"],8,2)."/".substr($Fila["fecha_muestra"],5,2)."/".substr($Fila["fecha_muestra"],0,4)."</td>\n";		
			echo "<td class=\"Detalle01\" align='center'>".$Grupo."</td>\n";
			echo "<td align='center'>".$Class."</td>\n";									
			if ($nro_solicitud == "")					
				echo "<td align='center'>&nbsp;</td>\n";					
			else
				echo "<td align='center'><a href=\"JavaScript:Historial('".$nro_solicitud."','".$Recargo."')\" class=\"LinksAzul\">".$nro_solicitud."</a></td>\n";		
			echo "<td align='center'>Finalizada</td>\n";					
			echo "</tr>\n";
		}
	}	
?>
</table>

<br>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"> <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"></td>
  </tr>
</table>
</form>
</body>
</html>

