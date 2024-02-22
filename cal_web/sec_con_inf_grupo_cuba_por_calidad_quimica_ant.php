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
			f.action ="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
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
      <td align="center"><strong>INFORME DE GRUPO CUBA POR CALIDAD QUIMICA DE 
        PESAJE DE PRODUCCION</strong></td>
    </tr>
  </table>
  <br>
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaInterior">
    <tr> 
      <td width="120" height="22">Fecha Inicio:</td>
      <td width="259"><select name="DiaIni" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select> <select name="MesIni" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </select> <select name="AnoIni" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select></td>
      <td width="355">Fecha Termino: 
        <select name="DiaFin" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select> <select name="MesFin" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </select> <select name="AnoFin" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select></td>
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
	$Consulta = "select * from proyecto_modernizacion.productos where cod_producto = '18' order by descripcion";     
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
 <tr align="center"><td colspan="6" class="ColorTabla02">CATODOS COMERCIALES</td></tr>
  <tr align="center" class="ColorTabla01"> 
    <td width="80">FECHA PESAJE</td>
    <td width="47">GRUPO</td>
    <td width="152">TIPO SUB PRODUCTO<br>
      (CALIDAD) </td>
    <td width="99">NRO SOLICITUD</td>
    <td width="66">ESTADO</td>
    <td width="47">PESO</td>
  </tr>
  <?php
	if ($Buscar==S)
	{
		set_time_limit(1000);
		$Consulta = " select t1.fecha_produccion, t1.cod_producto, t1.cod_subproducto, ";
		$Consulta.= " t1.cod_grupo,t1.peso_produccion";
		$Consulta.= " from sec_web.produccion_catodo t1 ";
		$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto not in ('3','4','6','7','8','9','10') and t1.cod_cuba != 00";
		$Consulta.= " and t1.fecha_produccion between '".$FechaInicio."' and '".$FechaTermino."'";
		$Consulta.= " group by t1.cod_grupo order by t1.fecha_produccion, t1.cod_grupo ";
		//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		$TotalPeso = 0;	
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$cont = 0;$Valor = 0;$Grado_A = 0;$Astm = 0;$Class = '';
			$Grupo = $Fila["cod_grupo"];
			$Cuba = $Fila["cod_cuba"];
			if(substr($Grupo,0,1) == 0)
				$Grupo = substr($Grupo,1,1);
			$Consulta = " SELECT t2.nro_solicitud,t2.cod_leyes, t2.valor, t2.cod_unidad,t1.recargo, t1.estado_actual from cal_web.solicitud_analisis as t1";
			$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2"; 
			$Consulta.= " ON t1.nro_solicitud = t2.nro_solicitud ";
			$Consulta.= " AND t1.fecha_hora = t2.fecha_hora ";
			$Consulta.= " AND t1.rut_funcionario = t2.rut_funcionario ";
			$Consulta.= " AND t1.id_muestra = t2.id_muestra ";
			$Consulta.= " AND t1.recargo = t2.recargo ";
			$Consulta.= " AND left(t2.id_muestra,5) like '%".str_pad($Grupo,2,'0',STR_APD_LEFT)."%'";
			$Consulta.= " WHERE t1.cod_producto = 18 AND t1.cod_subproducto='".$Fila["cod_subproducto"]."' and left(t1.fecha_muestra,10) = '".$Fila[fecha_produccion]."'";
			$Consulta.= " AND left(t1.id_muestra,5) like '%".str_pad($Grupo,2,'0',STR_APD_LEFT)."%'";
			$Consulta.= " AND t2.valor != '' AND t2.cod_leyes != 48";
			$Consulta.= " AND t1.cod_periodo='1' ";
			$Consulta.= " AND t1.tipo='1' ";
			$Consulta.= " AND t1.cod_analisis='1' ";
			$Consulta.= " AND t1.estado_actual = '6'";	
			//echo $Consulta;
			$rs = mysqli_query($link, $Consulta);
			$conta_a_co = 0;$conta_a_enm = 0;$conta_r = 0;$conta_s = 0;$nro_solicitud = "";$Recargo = "";$estado = 0;					
			while($row = mysqli_fetch_array($rs))
			{				
				$Consulta = "SELECT * FROM cal_web.clasificacion_catodos WHERE cod_leyes = $row["cod_leyes"]";
				$Rs = mysqli_query($link, $Consulta);
				if($fila = mysqli_fetch_array($Rs))
				{
					if ($row[valor] <= $fila[grado_a_codelco])
						$conta_a_co = 1;
					if (($row[valor] <= $fila[grado_a_enami])&&($row[valor] > $fila[grado_a_codelco])) 
						$conta_a_enm = 1;
					if ($row[valor] <= $fila[rechazo]&&($row[valor] > $fila[grado_a_enami]))
						$conta_r = 1;
					if ($row[valor] <= $fila[estandar]&&($row[valor] > $fila[rechazo]))
						$conta_s = 1;
					$cont = $cont + 1;
				}
				$nro_solicitud = $row["nro_solicitud"]; 
				$Recargo=$row["recargo"]; 
				$estado = $row["estado_actual"];
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
			if ($nro_solicitud != "")
			{
				echo "<tr>\n";
				echo "<td  align='center'>".substr($Fila["fecha_produccion"],8,2)."/".substr($Fila["fecha_produccion"],5,2)."/".substr($Fila["fecha_produccion"],0,4)."</td>\n";		
				echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
				echo "<td align='center'>".$Class."</td>\n";									
				if ($nro_solicitud == "")					
					echo "<td align='center'>&nbsp;</td>\n";					
				else
					echo "<td align='center'><a href=\"JavaScript:Historial('".$nro_solicitud."','".$Recargo."')\" class=\"LinksAzul\">".$nro_solicitud."</a></td>\n";		
				echo "<td align='center'>Finalizada</td>\n";					
				echo "<td align='right'>".number_format($Fila["peso_produccion"],0,",",".")."</td>\n";		
				echo "</tr>\n";
				$TotalPeso = $TotalPeso + $Fila["peso_produccion"];
			}
		}
	}	
?>
  <tr> 
    <td colspan="5"><strong>TOTALES</strong></td>
    <td align="right"><strong><?php echo number_format($TotalPeso,0,",",".") ?></strong></td>
  </tr>
</table>
<br>
<table width="550" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
 <tr align="center"><td colspan="7" class="ColorTabla02">CATODOS DESCOBRIZADOS</td></tr>
  <tr align="center" class="ColorTabla01"> 
    <td width="80">FECHA PESAJE</td>
    <td width="47">GRUPO</td>
	<td width="42">CUBA</td>	  
    <td width="152">TIPO SUB PRODUCTO<br>
      (CALIDAD) </td>
    <td width="99">NRO SOLICITUD</td>
    <td width="66">ESTADO</td>
    <td width="47">PESO</td>
  </tr>
  <?php
	if ($Buscar==S)
	{
		set_time_limit(1000);
		$Consulta = " select t1.fecha_produccion, t1.cod_producto, t1.cod_subproducto, ";
		$Consulta.= " t1.cod_grupo, t1.cod_cuba, t1.peso_produccion";
		$Consulta.= " from sec_web.produccion_catodo t1 ";
		$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto in('3','4') and t1.cod_cuba != 00";
		$Consulta.= " and t1.fecha_produccion between '".$FechaInicio."' and '".$FechaTermino."'";
		$Consulta.= " order by t1.fecha_produccion, t1.cod_grupo, t1.cod_cuba";
		//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		$TotalPeso = 0;	
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$cont = 0;$Valor = 0;$Grado_A = 0;$Astm = 0;$Class = '';
			$Grupo = $Fila["cod_grupo"];
			$Cuba = $Fila["cod_cuba"];
			if(substr($Grupo,0,1) == 0)
				$Grupo = substr($Grupo,1,1);
			if(substr($Cuba,0,1) == 0 AND substr($Cuba,1,1) != 0)
				$Cuba = substr($Cuba,1,1);
			$Consulta = " SELECT t2.nro_solicitud,t2.cod_leyes, t2.valor, t2.cod_unidad,t1.recargo, t1.estado_actual from cal_web.solicitud_analisis as t1";
			$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2"; 
			$Consulta.= " ON t1.nro_solicitud = t2.nro_solicitud ";
			$Consulta.= " AND t1.fecha_hora = t2.fecha_hora ";
			$Consulta.= " AND t1.rut_funcionario = t2.rut_funcionario ";
			$Consulta.= " AND t1.id_muestra = t2.id_muestra ";
			$Consulta.= " AND t1.recargo = t2.recargo ";
			$Consulta.= " AND left(t2.id_muestra,5) like '%".str_pad($Grupo,2,'0',STR_APD_LEFT)."%'";//str_pad($Grupo,2,'0',STR_APD_LEFT)
			$Consulta.= " WHERE t1.cod_producto = 18 AND t1.cod_subproducto='".$Fila["cod_subproducto"]."' and left(t1.fecha_muestra,10) = '".$Fila[fecha_produccion]."'";
			$Consulta.= " AND left(t1.id_muestra,5) like '%".str_pad($Grupo,2,'0',STR_APD_LEFT)."%' AND right(t1.id_muestra,2) like '%".$Cuba."%'";
			$Consulta.= " AND t2.valor != '' AND t2.cod_leyes != 48";
			$Consulta.= " AND t1.cod_periodo='1' ";
			$Consulta.= " AND t1.tipo='1' ";
			$Consulta.= " AND t1.cod_analisis='1' ";
			$Consulta.= " AND t1.estado_actual = '6'";	
			//echo $Consulta;
			$rs = mysqli_query($link, $Consulta);
			$conta_a_co = 0;$conta_a_enm = 0;$conta_r = 0;$conta_s = 0;$nro_solicitud = "";$Recargo = "";$estado = 0;					
			while($row = mysqli_fetch_array($rs))
			{				
				$Consulta = "SELECT * FROM cal_web.clasificacion_catodos WHERE cod_leyes = $row["cod_leyes"]";
				$Rs = mysqli_query($link, $Consulta);
				if($fila = mysqli_fetch_array($Rs))
				{
					if ($row[valor] <= $fila[grado_a_codelco])
						$conta_a_co = 1;
					if (($row[valor] <= $fila[grado_a_enami])&&($row[valor] > $fila[grado_a_codelco])) 
						$conta_a_enm = 1;
					if ($row[valor] <= $fila[rechazo]&&($row[valor] > $fila[grado_a_enami]))
						$conta_r = 1;
					if ($row[valor] <= $fila[estandar]&&($row[valor] > $fila[rechazo]))
						$conta_s = 1;
					$cont = $cont + 1;
				}
				$nro_solicitud = $row["nro_solicitud"]; 
				$Recargo=$row["recargo"]; 
				$estado = $row["estado_actual"];
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
			if ($nro_solicitud != "")
			{
				echo "<tr>\n";
				echo "<td  align='center'>".substr($Fila["fecha_produccion"],8,2)."/".substr($Fila["fecha_produccion"],5,2)."/".substr($Fila["fecha_produccion"],0,4)."</td>\n";		
				echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
				echo "<td align='center'>".$Fila["cod_cuba"]."</td>\n";
				echo "<td align='center'>".$Class."</td>\n";									
				if ($nro_solicitud == "")					
					echo "<td align='center'>&nbsp;</td>\n";					
				else
					echo "<td align='center'><a href=\"JavaScript:Historial('".$nro_solicitud."','".$Recargo."')\" class=\"LinksAzul\">".$nro_solicitud."</a></td>\n";		
				echo "<td align='center'>Finalizada</td>\n";					
				echo "<td align='right'>".number_format($Fila["peso_produccion"],0,",",".")."</td>\n";		
				echo "</tr>\n";
				$TotalPeso = $TotalPeso + $Fila["peso_produccion"];
			}
		}
	}	
?>
  
  <tr> 
    <td colspan="6"><strong>TOTALES</strong></td>
    <td align="right"><strong><?php echo number_format($TotalPeso,0,",",".") ?></strong></td>
  </tr>
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

