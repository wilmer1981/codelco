<?php
	include("../principal/conectar_principal.php"); 
	 set_time_limit(8000);
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
<title>Sistema CAL-WEB</title>
<link rel="stylesheet" href="../Principal/estilos/css_principal.css" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sec_con_inf_grupo_cuba_por_calidad_quimica_leyes.php?Buscar=S";
			f.submit();
			break;
		case "E":
			f.action ="sec_con_inf_grupo_cuba_por_calidad_quimica_leyes_xls.php?Buscar=S";
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
      <td align="center"><strong>CLASIFICACION POR  CALIDAD QUIMICA DE CATODOS (Versi&oacute;n 2) </strong></td>
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
		<input name="btnexcel" type="button" value="Excel" style="width:70;" onClick="JavaScript:Proceso('E')"> 
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
    <td width="47">GRUPO</td>
    <td width="152">TIPO SUB PRODUCTO<br>
      (CALIDAD) </td>
    <td width="99">NRO SOLICITUD</td>
    <td width="66">ESTADO</td>
	<?php
	for ($i = 0; $i < $LargoArreglo; $i++)
	{
		echo "<td width='70' colspan='2'>".$ArregloLeyes[$i][1]."</td>\n";
	}
	?>
  </tr>
  <?php
	if ($Buscar==S)
	{
		$TotalPeso = 0;
		$Consulta = " SELECT distinct t1.nro_solicitud,t1.recargo,t1.id_muestra,t1.fecha_muestra from cal_web.solicitud_analisis t1 ";
		$Consulta.= " where (t1.cod_periodo='1') and (t1.estado_actual = '6') and cod_analisis='1' and t1.cod_producto ='18' and t1.cod_subproducto not in ('3','4','5','6','7','8','9','10') and (left(t1.fecha_muestra,10) between '$FechaInicio' and '$FechaTermino') order by t1.fecha_muestra,t1.nro_solicitud ";		
		//echo "uno".$Consulta."<br>";;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$cont = 0;$Valor = 0;$Grado_A = 0;$Astm = 0;$Class = '';
			$Grupo = $Fila["id_muestra"];
			$nro_solicitud = $Fila["nro_solicitud"];
			$Recargo=$Fila["recargo"];   
			$estado = $Fila["estado_actual"];
			$Consulta = " SELECT * from cal_web.leyes_por_solicitud where nro_solicitud = '".$Fila["nro_solicitud"]."'";// and recargo = '".$Fila["recargo"]."'";
			//echo "dos".$Consulta."<br>";
			$rs = mysqli_query($link, $Consulta);
			$conta_a_co = 0;$conta_a_enm = 0;$conta_r = 0;$conta_s = 0;$Recargo = "";$estado = 0;
			$Malo = 0;					
			while($row = mysqli_fetch_array($rs))
			{				
				$Consulta = "SELECT * FROM cal_web.clasificacion_catodos WHERE cod_leyes = $row["cod_leyes"]";
				$Rs = mysqli_query($link, $Consulta);
				if($fila = mysqli_fetch_array($Rs))
				{
					if ($row["valor"] <= $fila["grado_a_codelco"])
						$conta_a_co = 1;
					else	
						if (($row["valor"] <= $fila["grado_a_enami"])&&($row["valor"] > $fila["grado_a_codelco"])) 
							$conta_a_enm = 2;
						else	
							if ($row["valor"] <= $fila["rechazo"]&&($row["valor"] > $fila["grado_a_enami"]))
								$conta_r = 3;
							else	
								if ($row["valor"] <= $fila["estandar"]&&($row["valor"] > $fila["rechazo"]))
									$conta_s = 4;
							else
									$Malo = 5;	
					$cont = $cont + 1;
					
				}
			}
		
			if($cont != 0)
			{
			$Class = "";
				if ($Malo == 5)
				{
					$Malo = 1;
					$Class = "ESTANDAR 3 ER";  
					
				}

				else
					if ($conta_s == 4)
					$Class = "ESTANDAR 2 ER";
				else
					if ($conta_r == 3)
						$Class = "ESTANDAR 1 ER";
					else
						if($conta_a_enm == 2)
							$Class = "GRADO A ENAMI";
						else
						if ($conta_a_co == 1)
							$Class = "GRADO A";
								
			}
		$conta_a_co=0;
			echo "<tr>\n";
			echo "<td  align='center'>".substr($Fila["fecha_muestra"],8,2)."/".substr($Fila["fecha_muestra"],5,2)."/".substr($Fila["fecha_muestra"],0,4)."</td>\n";		
			echo "<td align='center'>".$Grupo."</td>\n";
			if ($Malo ==1)
				echo "<td align='center' bgcolor='#FF0000' >".$Class."</td>\n";
			else	
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
	<?php
	$Consulta = " SELECT STRAIGHT_JOIN distinct(t2.cod_leyes), t3.abreviatura from cal_web.solicitud_analisis t1 ";
	$Consulta = $Consulta." inner join cal_web.leyes_por_solicitud t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta = $Consulta." and t1.recargo = t2.recargo ";
	$Consulta = $Consulta." inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes ";
	$Consulta.= " where (t1.cod_periodo='1') and (t1.estado_actual = '6') and t1.cod_producto ='18' and t1.cod_subproducto in ('3','4') and (left(t1.fecha_muestra,10) between '$FechaInicio' and '$FechaTermino') order by t1.fecha_muestra,t1.nro_solicitud ";		
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$LargoArreglo = 0;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		$ArregloLeyes[$LargoArreglo][0] = $Row["cod_leyes"];
		$ArregloLeyes[$LargoArreglo][1] = $Row["abreviatura"];
		$LargoArreglo++;
	}
	$Total = ($LargoArreglo * 70) +650;
	?>
<table width="550" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
 <tr align="center">
   <td colspan="7" class="ColorTabla02">CATODOS EW VENTANAS </td>
 </tr>
  <tr align="center" class="ColorTabla01"> 
    <td width="80">FECHA PESAJE</td>
    <td width="70">GRUPO/CUBA</td>
    <td width="152">TIPO SUB PRODUCTO<br>
      (CALIDAD) </td>
  	
    <td width="99">NRO SOLICITUD</td>
	<td width="66" >PESO VALIDADO</td> 
	<td width="66" >PESO LADO P+MUESTRA</td> 
    <td width="66">ESTADO</td>
	<?php
	for ($i = 0; $i < $LargoArreglo; $i++)
	{
		echo "<td width='70' colspan='1'>".$ArregloLeyes[$i][1]."</td>\n";
	}
	?>
  </tr>
  <?php
	if ($Buscar==S)
	{
		$TotalPeso = 0;
		$Consulta = " SELECT distinct t1.nro_solicitud,t1.recargo,t1.id_muestra,t1.fecha_muestra from cal_web.solicitud_analisis t1 ";
		$Consulta.= " where (t1.cod_periodo='1') and (t1.estado_actual = '6') and t1.cod_producto ='18' and t1.cod_subproducto in ('3','4') and (left(t1.fecha_muestra,10) between '$FechaInicio' and '$FechaTermino') order by t1.fecha_muestra,t1.nro_solicitud ";		
		//echo $Consulta."<br>";
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
			$conta_a_co = 0;$conta_a_enm = 0;$conta_r = 0;$conta_s = 0;$Recargo = ""; $estado = 0; $conta_off = 0; $conta_fuera_rango=0;					
			$std_1='';$std_2='';$std_3='';$std_og='';
			while($row = mysqli_fetch_array($rs))
			{				
				$Consulta = "SELECT * FROM cal_web.clasificacion_catodos_ew WHERE cod_leyes = $row["cod_leyes"]";
				//echo $Consulta;
				$Rs = mysqli_query($link, $Consulta);
				if($fila = mysqli_fetch_array($Rs))
				{
					if ($row["valor"] <= $fila[std_1])
						$std_1='S';
					if($row["valor"] > $fila[std_1] && $row["valor"] <= $fila[std_2])
						$std_2='S';
					if($row["valor"] > $fila[std_2] && $row["valor"] <= $fila[std_3])
						$std_3='S';
					if($row["valor"] > $fila[std_3])
						$std_og='S';	
					/*if ($row["valor"] <= $fila["grado_a_codelco"])
						$conta_a_co = 1;
					if (($row["valor"] <= $fila["grado_a_enami"])&&($row["valor"] > $fila["grado_a_codelco"])) 
						$conta_a_enm = 1;
					if ($row["valor"] <= $fila["rechazo"]&&($row["valor"] > $fila["grado_a_enami"]))
						$conta_r = 1;
					if ($row["valor"] <= $fila["estandar"]&&($row["valor"] > $fila["rechazo"]))
						$conta_s = 1;
					if ($row["valor"] <= $fila[off_grade]&&($row["valor"] > $fila["estandar"]))
						$conta_off = 1;
	
					if ($row["valor"] > 70  &&($row["valor"] > $fila[off_grade]))
						$conta_fuera_rango = 1;*/
					$cont = $cont + 1;
				}
			}
			if($cont != 0)  
			{
				if ($std_og == 'S')
				{
					$Class = "OFF Grade";
					$SubP=49;
				}
				else

				if ($std_3 == 'S')
				{
					$Class = "ESTANDAR 3 EW";
					$SubP=49;
				}
				else
				if ($std_2 == 'S')
				{
					$Class = "ESTANDAR 2 EW";
					$SubP=17;
				}
				else
					if ($std_1 == 'S')
					{
						$Class = "ESTANDAR 1 EW";
						$SubP=16;
					}
			}
			
			
			/*if($cont != 0)  
			{
				if ($conta_fuera_rango == 1)
				{
					$Class = "ESTANDAR 3 EW";
					$SubP=49;
				}
				else

				if ($conta_off == 1)
				{
					$Class = "ESTANDAR 3 EW";
					$SubP=49;
				}
				else
				if ($conta_s == 1)
				{
					$Class = "ESTANDAR 2 EW";
					$SubP=17;
				}
				else
					if ($conta_r == 1)
					{
						$Class = "ESTANDAR 1 EW";
						$SubP=16;
					}
					else
						if($conta_a_enm == 1)
						{
							$Class = "ESTANDAR 1 EW";
							$SubP=16;
						}
						else
						{
							$Class = "ESTANDAR 1 EW";
							$SubP=16;
						}
			}*/
			echo "<tr>\n";
			echo "<td  align='center'>".substr($Fila["fecha_muestra"],8,2)."/".substr($Fila["fecha_muestra"],5,2)."/".substr($Fila["fecha_muestra"],0,4)."</td>\n";		
			echo "<td align='center'>".$Grupo."</td>\n";
			echo "<td align='center'>".$Class."</td>\n";									
			if ($nro_solicitud == "")					
				echo "<td align='center'>&nbsp;</td>\n";					
			else
				echo "<td align='center'><a href=\"JavaScript:Historial('".$nro_solicitud."','".$Recargo."')\" class=\"LinksAzul\">".$nro_solicitud."</a></td>\n";		
			echo "<td align='center'>";
			$Grupo_A=trim($Grupo);
			$Dato=explode("C",$Grupo);
			$Grup=trim($Dato[0]);
			$Cub=trim(str_replace('.','',$Dato[1]));
			$Cuba=trim(str_replace('-','',$Cub));
			$Cuba=$Cuba*1;
			$Consulta="SELECT sum(num_unidades) as suma_unidades,sum(peso_paquetes) as suma_paquetes from sec_web.lote_catodo t1 ";
			$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
			$Consulta.=" and t1.num_paquete=t2.num_paquete ";
			$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
			$Consulta.=" where t2.nro_solicitud = '".$nro_solicitud."'  ";
			//$Consulta.= " and t2.cod_grupo = '".trim($Grup)."'  and ceiling(t2.cod_cuba) ='".(str_replace('-','',$Cuba))."' ";
			//$Consulta.= " and t2.cod_grupo = '".trim($Grup)."'  and ceiling(cod_cuba) ='".(str_replace('-','',$Cuba))."' ";
			$RespEti=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($FilaEti=mysqli_fetch_array($RespEti))
			{
				echo number_format($FilaEti[suma_paquetes],0,",",".");
			}
			echo '&nbsp';
			echo "</td>";
			/********PESO LADO + MUESTRA*******************/
			echo "<td align='center'>";
			$FechaM=substr($Fila["fecha_muestra"],0,10);
			$Dia=substr($FechaM,8,2);
			$Mes=substr($FechaM,5,2);
			$Ano=substr($FechaM,0,4);
			$FechaMuestra=$Dia.'-'.$Mes.'-'.$Ano;
			$FechaMas=suma_fechas($FechaMuestra,2);
			$FechaMenos=resta_fechas($FechaMuestra,2);
			
			$Dia2=substr($FechaMenos,0,2);
			$Mes2=substr($FechaMenos,3,2);
			$Ano2=substr($FechaMenos,6,4);
			$FechaMenos2=$Ano2.'-'.$Mes2.'-'.$Dia2;
			
			$Dia3=substr($FechaMas,0,2);
			$Mes3=substr($FechaMas,3,2);
			$Ano3=substr($FechaMas,6,4);
			$FechaMas2=$Ano3.'-'.$Mes3.'-'.$Dia3;
			
			$Con = " SELECT count(cod_cuba) as cantidad ";
			$Con.= " from sec_web.produccion_catodo t1 where";
			$Con.="  fecha_produccion between  '".$FechaMenos2."' and '".$FechaMas2."' and ";
			//$Con.="   t1.fecha_produccion='".substr($Fila["fecha_muestra"],0,10)."' and ";
			$Con.= " t1.cod_producto = '18' and t1.cod_subproducto = '5' ";
			$Con.= " and t1.cod_grupo = '".trim($Grup)."' and t1.cod_lado = 'P'  ";
			$Con.= " group by   t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, t1.cod_lado ";
			//echo "**************"."<br>";
			//echo $Con."<br>";
			$ResCant = mysqli_query($link, $Con);
			$FiCant=mysqli_fetch_array($ResCant);
			$CantCubas=$FiCant[cantidad];
			
			/***********VALOR MUESTRA******************/
			$Consulta = " SELECT t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, t1.cod_lado, ";
			$Consulta.= " ifnull(sum(t1.peso_produccion),0) as peso, ifnull(sum(t1.peso_tara),0) as peso_tara,t1.fecha_produccion ";
			$Consulta.= " from sec_web.produccion_catodo t1 where";
			//$Consulta.="   t1.fecha_produccion='".substr($Fila["fecha_muestra"],0,10)."' ";
			$Consulta.="  fecha_produccion between  '".$FechaMenos2."' and '".$FechaMas2."'";
			$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto = '5' ";
			$Consulta.= " and t1.cod_grupo = '".$Grup."' and (t1.cod_lado is null or t1.cod_lado = '') and t1.cod_muestra='S' ";
			$Consulta.= " group by  t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, t1.cod_lado ";
			//echo "con".$Consulta."<br>";
			$Respuesta3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Respuesta3))
			{
				if($CantCubas <> 0)
					$Mu=$Fila3["peso"]/$CantCubas; 
				else
					$Mu=0;
				$Muestra=number_format($Mu,0,",",".");
			}
			else
				$Muestra=0;
			//VALOR PESO LADO P
			$Con = " SELECT t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, t1.cod_lado, ";
			$Con.= " ifnull(sum(t1.peso_produccion),0) as peso, ifnull(sum(t1.peso_tara),0) as peso_tara, count(*) as colillas, t1.fecha_produccion ";
			$Con.= " from sec_web.produccion_catodo t1 where";
			//$Con.="  fecha_produccion='".substr($Fila["fecha_muestra"],0,10)."' and ";
			$Con.="  fecha_produccion between  '".$FechaMenos2."' and '".$FechaMas2."' and ";
			$Con.= "  t1.cod_producto = '18' and t1.cod_subproducto = '5' ";
			$Con.= " and t1.cod_grupo = '".trim($Grup)."' and t1.cod_lado = 'P' and ceiling(cod_cuba) ='".(str_replace('-','',$Cuba))."' ";
			$Con.= " group by   t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, t1.cod_lado ";
			//echo "**************"."<br>";
			$Res0 = mysqli_query($link, $Con);
			if($Fi0=mysqli_fetch_array($Res0))
				$LadoP=$Fi0["peso"]; 
			else
				$LadoP=0;
			$PesoReal=$LadoP+$Muestra;	
				
			echo number_format($PesoReal,0,",",".");
			$PesoReal=0;
			$LadoP=0;
			$Mues=0;
			echo "</td>\n";
			
			
			/**********************************************/
			
			echo "<td align='center'>Finalizada</td>\n";
			for ($i = 0; $i < $LargoArreglo; $i++)
			{
			$Consulta = "SELECT *,t2.abreviatura from cal_web.leyes_por_solicitud t1";
			$Consulta.= " inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad ";  
			$Consulta.= " where t1.nro_solicitud = '".$nro_solicitud."'";
			if (!is_null($Recargo) || ($Recargo != ""))
			{
				$Consulta.= " and t1.recargo = '".$Recargo."' ";
			}
			$Consulta.= " and t1.cod_leyes = '".$ArregloLeyes[$i][0]."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Row2 = mysqli_fetch_array($Resp))
			{
				if ((is_null($Row2["valor"])) || ($Row2["valor"] == ""))
				{	
					if ($Row2[signo]=="N")
					{
						echo "<td width='70'>ND</td>\n";
					}
					else
					{	
						echo "<td width='70'>&nbsp;</td>\n";
					}
				}
				else	//echo "<td width='70'>".$Row2["valor"]."&nbsp;</td>\n";
					if ($Row2[candado]== 1)
					{
						if($Row2[signo]=="=")
						{
							echo "<td width='70'><font color='green'>".str_replace(".",",",$Row2["valor"])."</font></td>\n";
							//echo "<td width='70'><font color='green'>".$Row2["abreviatura"]."</font></td>\n";
						}
						else
						{
							echo "<td width='70'><font color='green'>".str_replace(".",",",$Row2["valor"])."</font></td>\n";
							//echo "<td width='70'><font color='green'>".$Row2["abreviatura"]."</font></td>\n";
						}
					}
					else
					{
						if($Row2[signo]=="=")
						{
							echo "<td width='70'>".str_replace(".",",",$Row2["valor"])."</td>\n";
							//echo "<td width='70'><font color='green'>".$Row2["abreviatura"]."</font></td>\n";
						}
						else
						{
							echo "<td width='70'>".str_replace(".",",",$Row2["valor"])."</td>\n";
							//echo "<td width='70'><font color='green'>".$Row2["abreviatura"]."</font></td>\n";
						}
					}
				}
			else
			{
				echo "<td width='70' align='center'>&nbsp;</td>\n";
				
			}				
		}						
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

<?php
function suma_fechas($fecha,$ndias)
{
	  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=split("/", $fecha);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año)+ $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
      return ($nuevafecha);  
}
function resta_fechas($fecha,$ndias)
{
	  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=split("/", $fecha);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año)- $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
      return ($nuevafecha);  
}

 

?>
