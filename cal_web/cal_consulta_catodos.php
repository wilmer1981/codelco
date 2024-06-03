<?php 
include("../principal/conectar_principal.php"); 

if(isset($_REQUEST["CmbDias"])) {
	$CmbDias = $_REQUEST["CmbDias"];
}else{
	$CmbDias =  date("d");
}
if(isset($_REQUEST["CmbMes"])) {
	$CmbMes = $_REQUEST["CmbMes"];
}else{
	$CmbMes =  date("m");
}
if(isset($_REQUEST["CmbAno"])) {
	$CmbAno = $_REQUEST["CmbAno"];
}else{
	$CmbAno =  date("Y");
}
if(isset($_REQUEST["CmbDiasT"])) {
	$CmbDiasT = $_REQUEST["CmbDiasT"];
}else{
	$CmbDiasT =  date("d");
}
if(isset($_REQUEST["CmbMesT"])) {
	$CmbMesT = $_REQUEST["CmbMesT"];
}else{
	$CmbMesT =  date("m");
}
if(isset($_REQUEST["CmbAnoT"])) {
	$CmbAnoT = $_REQUEST["CmbAnoT"];
}else{
	$CmbAnoT =  date("Y");
}

?>
<html>
<head>
<title>Control de Calidad</title>
<link href="../Principal/estilos/css_cal_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "R":
			f.action = "cal_consulta_catodos.php";
			f.submit();
			break;
		case "E":
			f.action = "cal_consulta_catodos_excel.php";
			f.submit();
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
			f.submit();
			break;
	}
}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
  <div align="center"><strong>CONSULTA DE CATODOS DIARIOS</strong><br>
  </div>
  <table width="788" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td width="88">Fecha Inicio:</td>
      <td width="325" align="left"> &nbsp; <select name="CmbDias">
          <?php
						for ($i=1;$i<=31;$i++)
						{
							if (isset($CmbDias))
							{
								if ($i==$CmbDias)
								{
									echo "<option selected value= '".$i."'>".$i."</option>";
								}
								else
								{
								  echo "<option value='".$i."'>".$i."</option>";
								}
							}
							else
							{
								if ($i==date("j"))
								{
									echo "<option selected value= '".$i."'>".$i."</option>";
								}
								else
								{
								  echo "<option value='".$i."'>".$i."</option>";
								}
							}	
						}
			?>
        </select> <select name="CmbMes">
          <?php
					  for($i=1;$i<13;$i++)
					  {
							if (isset($CmbMes))
							{
								if ($i==$CmbMes)
								{
									echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
								}
								else
								{
									echo "<option value='$i'>".$Meses[$i-1]."</option>\n";
								}
							
							}	
							else
							{
								if ($i==date("n"))
								{
									echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
								}
								else
								{
									echo "<option value='$i'>".$Meses[$i-1]."</option>\n";
								}
							}	
						}
			?>
        </select> <select name="CmbAno">
          <?php
						for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
						{
							if (isset($CmbAno))
							{
								if ($i==$CmbAno)
									{
										echo "<option selected value ='$i'>$i</option>";
									}
								else	
									{
										echo "<option value='".$i."'>".$i."</option>";
									}
							}
							else
							{
								if ($i==date("Y"))
									{
										echo "<option selected value ='$i'>$i</option>";
									}
								else	
									{
										echo "<option value='".$i."'>".$i."</option>";
									}
							}		
						}
				?>
        </select> &nbsp; </td>
      <td width="106" align="left">Fecha Termino:</td>
      <td width="242" align="left">
		<select name="CmbDiasT">
            <?php
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDiasT))
				{
					if ($i==$CmbDiasT)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
				}
				else
				{
					if ($i==date("j"))
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
				}	
			}
			?>
        </select>
		<select name="CmbMesT">
        <?php
			for($i=1;$i<13;$i++)
			{
				if (isset($CmbMesT))
				{
					if ($i==$CmbMesT)
					{
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$Meses[$i-1]."</option>\n";
					}
				
				}	
				else
				{
					if ($i==date("n"))
					{
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$Meses[$i-1]."</option>\n";
					}
				}	
			}
		?>
        </select> <select name="CmbAnoT">
        <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (isset($CmbAnoT))
			{
				if ($i==$CmbAnoT)
					{
						echo "<option selected value ='$i'>$i</option>";
					}
				else	
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
			}
			else
			{
				if ($i==date("Y"))
					{
						echo "<option selected value ='$i'>$i</option>";
					}
				else	
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
			}		
		}
		?>
        </select> </td>
    </tr>
    <tr> 
      <td colspan="4"><div align="center">
          <input type="button" name="btnConsulta" value="WEB" onClick="Proceso('R');" style="width:50px;">
          <input type="button" name="btnConsulta2" value="Excel" onClick="Proceso('E');" style="width:50px;">
          <input type="button" name="btnSalir" value="Salir" onClick="Proceso('S');" style="width:50px;">
        </div></td>
    </tr>
    <br>
  </table>
<br>
<br>
  <table width="787" border="1" cellpadding="1" cellspacing="1"  class="TablaInterior">
    <tr class="ColorTabla01"> 
      <td width="56"><strong>Dia</strong></td>
      <td width="43"><strong>Cu</strong></td>
      <td width="39"><strong>O</strong></td>
      <td width="38"><strong>S</strong></td>
      <td width="42"><strong>Sb</strong></td>
      <td width="42"><strong>Te</strong></td>
      <td width="42"><strong>Sn</strong></td>
      <td width="42"><strong>Fe</strong></td>
      <td width="42"><strong>Pb</strong></td>
      <td width="40"><strong>Ni</strong></td>
      <td width="40"><strong>Bi</strong></td>
      <td width="42"><strong>As</strong></td>
      <td width="42"><strong>Se</strong></td>
      <td width="42"><strong>Au</strong></td>
      <td width="51"><strong>Ag</strong></td>
    </tr>
    <?php  
	if(strlen($CmbDias)==1){
		$CmbDias= "0".$CmbDias;
	}
	if(strlen($CmbMes)==1){
		$CmbMes= "0".$CmbMes;
	}
	if(strlen($CmbDiasT)==1){
		$CmbDiasT= "0".$CmbDiasT;
	}
	if(strlen($CmbMesT)==1){
		$CmbMesT= "0".$CmbMesT;
	}
	$FechaInicio = $CmbAno."-".$CmbMes."-".$CmbDias;
	$FechaTermino = $CmbAnoT."-".$CmbMesT."-".$CmbDiasT;
	$Consulta = "select year(t1.fecha_muestra) as ano, ";
	$Consulta.= " case when length(month(t1.fecha_muestra))=1 then concat('0',month(t1.fecha_muestra)) else month(t1.fecha_muestra) end as mes, ";
	$Consulta.= " case when length(DAYOFMONTH(t1.fecha_muestra))=1 then concat('0',DAYOFMONTH(t1.fecha_muestra)) else DAYOFMONTH(t1.fecha_muestra) end as dia, ";
	$Consulta.= " concat(year(t1.fecha_muestra),'-',month(t1.fecha_muestra),'-',DAYOFMONTH(t1.fecha_muestra)) as fecha_muestra ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto = '1' ";
	$Consulta.= " and t1.cod_analisis = '1' and t1.tipo='1' and t1.tipo_solicitud = 'R' ";
	$Consulta.= " and t1.fecha_muestra between '".$FechaInicio." 00:00:00' and '".$FechaTermino." 23:59:59' ";
	$Consulta.= " and t1.cod_periodo = '1' and agrupacion = '7'";
	$Consulta.= " group by ano, mes, dia";
	$Consulta.= " order by ano, mes, dia";
	//echo $Consulta."</br>";
	$Respuesta = mysqli_query($link, $Consulta);
	$Cont = 1;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$SumaImpurezas = 0;
		//echo $Fila["fecha_muestra"]." ".$Fila["ano"]." ".$Fila["mes"]." ".$Fila["dia"]."</br>";
		echo "<tr>\n";
		if ($CmbMes == $CmbMesT)
			echo "<td>".$Fila["dia"]."</td>";
			//echo "<td>".substr($Fila["fecha_muestra"],8,2)."</td>";
		else echo "<td>".$Fila["dia"]."/".$Fila["mes"]."/".$Fila["ano"]."</td>";
		//	echo "<td>".substr($Fila["fecha_muestra"],8,2)."/".substr($Fila["fecha_muestra"],6,2)."/".substr($Fila["fecha_muestra"],0,4)."</td>";
		echo "<td><input type='text' name='TxtCu".$Cont."' value='' size='10' readonly></td>";
		$CodLey = "";
		for ($i=1;$i<=2;$i++)
		{
			switch ($i)
			{
				case 1:
					$CodLey = "48";
					break;
				case 2:
					$CodLey = "26";
					break;
			}	
			$Consulta = "select STRAIGHT_JOIN  t1.fecha_muestra, t2.cod_leyes, round(AVG(t2.valor)) as valor ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
			$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo= t2.recargo ";
			$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto = '1' ";
			$Consulta.= " and t1.cod_analisis = '1' and t1.tipo='1' and t1.tipo_solicitud = 'R' ";
			$Consulta.= " and t1.fecha_muestra between '".$Fila["fecha_muestra"]." 00:00:00' and '".$Fila["fecha_muestra"]." 23:59:59' ";
			$Consulta.= " and t2.candado = '1' and t1.cod_periodo = '1'";
			$Consulta.= " and (t2.cod_leyes = '".$CodLey."') and agrupacion = '7'";
			$Consulta.= " group by t1.fecha_muestra, t2.cod_leyes ";
			$Consulta.= " order by t1.fecha_muestra, t2.cod_leyes ";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				echo "<td>".str_replace(".",",",$Fila2["valor"])."</td>";
				if ($CodLey != "48")
					$SumaImpurezas = $SumaImpurezas + $Fila2["valor"];
			}
			else
			{
				echo "<td>&nbsp;</td>";			
			}
		}
		for ($i=1;$i<=11;$i++)
		{
			switch ($i)
			{
				case 1:
					$CodLey = "09";
					break;
				case 2:
					$CodLey = "44";
					break;
				case 3:
					$CodLey = "30";
					break;
				case 4:
					$CodLey = "31";
					break;
				case 5:
					$CodLey = "39";
					break;
				case 6:
					$CodLey = "36";
					break;
				case 7:
					$CodLey = "27";
					break;
				case 8:
					$CodLey = "08";
					break;
				case 9:
					$CodLey = "40";
					break;
				case 10:
					$CodLey = "05";
					break;
				case 11:
					$CodLey = "04";
					break;
			}	
			if ($CodLey == "04")
				$Consulta = "select STRAIGHT_JOIN t1.fecha_muestra, t2.cod_leyes, round(AVG(t2.valor)) as valor ";
			else	$Consulta = "select t1.fecha_muestra, t2.cod_leyes, round(AVG(t2.valor),1) as valor ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
			$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo= t2.recargo ";
			$Consulta.= " where t1.cod_producto = '18' and t1.cod_subproducto = '1' ";
			$Consulta.= " and t1.cod_analisis = '1' and t1.tipo='1' and t1.tipo_solicitud = 'R' ";
			$Consulta.= " and t1.fecha_muestra between '".$Fila["fecha_muestra"]." 00:00:00' and '".$Fila["fecha_muestra"]." 23:59:59' ";
			$Consulta.= " and t2.candado = '1' and t1.cod_periodo = '1'";
			$Consulta.= " and (t2.cod_leyes = '".$CodLey."') and agrupacion = '7'";
			$Consulta.= " group by t1.fecha_muestra, t2.cod_leyes ";
			$Consulta.= " order by t1.fecha_muestra, t2.cod_leyes ";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{				
				echo "<td>".str_replace(".",",",$Fila2["valor"])."</td>";
				$SumaImpurezas = $SumaImpurezas + $Fila2["valor"];
			}
			else
			{
				echo "<td>&nbsp;</td>";			
			}
		}
		$Cu = 100-($SumaImpurezas/10000);
		echo "<script languaje='JavaScript'> document.frmPrincipal.TxtCu".$Cont.".value = '".round($Cu,3)."';</script>";
		echo "</tr>";
		$Cont++;
	}
?>
  </table>
</form>
</body>
</html>
