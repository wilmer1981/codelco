<?php
	include("../principal/conectar_principal.php"); 

	$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date('d');
	$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date('m');
	$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date('Y');
	$DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date('d');
	$MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date('m');
	$AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date('Y');

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

	$FechaInicio1 =date("Y-m-d", mktime(1,0,0,$MesIni,$DiaIni,$AnoIni));	

	$Fechainiturno =$FechaInicio;
	$Fechafturno = date("Y-m-d", mktime(1,0,0,intval(substr($Fechainiturno, 5, 2)) ,intval(substr($Fechainiturno, 8, 2)) + 1,intval(substr($Fechainiturno, 0, 4))));


	
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
			f.action ="sec_con_inf_pesaje_prod.php";
			f.submit();
			break;
		case "E":
			f.action ="sec_con_inf_pesaje_prod_excel.php";
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

<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><strong>DETALLE PESAJE DE PRODUCCION</strong></td>
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
      <td colspan="4" align="center"> <input name="btnConsultar" type="button" id="btnConsultar" style="width:70;" onClick="JavaScript:Proceso('C')" value="Consultar"> 
        <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')">
        <input name="btnExcel" type="button" id="btnExcel" style="width:70;" onClick="JavaScript:Proceso('E')" value="Excel">
        <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir"> 
      </td>
    </tr>
  </table>
  <br>
<?php
	$FechaAux = $FechaInicio;
		
	while (date($FechaAux) <= date($FechaTermino))
	{
		$Fechainiturno=$FechaAux;
		$Fechafturno= date("Y-m-d", mktime(1,0,0,substr($FechaAux,5,2),(intval(substr($FechaAux,8,2)) + 1),substr($FechaAux,0,4)));
	
		$Consulta = "SELECT ifnull(count(*),0) as total_reg from sec_web.produccion_catodo t1";
		$Consulta.= " where CONCAT(t1.fecha_produccion,' ',t1.hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";

		//$Consulta.= " where fecha_produccion = '".$FechaAux."'";
		//$Consulta.= " and cod_muestra <> 'S'";
		//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["total_reg"] <> 0)
			{
				echo "<br><table width='500' border='0' align='center' cellpadding='2' cellspacing='1' class='TablaInterior'>\n";
				echo "<tr> \n";
				echo "<td align='center'><strong>DIA: ".substr($FechaAux,8,2)."/".substr($FechaAux,5,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
				echo "</tr>\n";
				echo "</table>\n";
			}
		}							
		$Consulta = "SELECT distinct t2.cod_producto, t2.cod_subproducto, t2.descripcion ";
		$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
		$Consulta.= " order by t2.cod_producto, t2.cod_subproducto";
		$Respuesta = mysqli_query($link, $Consulta);
		$TotalDia = 0;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{						
			$Consulta = "SELECT * from sec_web.produccion_catodo ";
			$Consulta.= " where cod_producto = '".$Fila["cod_producto"]."'";
			$Consulta.= " and cod_subproducto = '".$Fila["cod_subproducto"]."'";
			$Consulta.= " and CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
			$Consulta.= " order by cod_grupo";			
			//$Consulta.= " and cod_muestra <> 'S'";
			$Respuesta2 = mysqli_query($link, $Consulta);
			$SubTotalPeso = 0;
			$CodProductoAnt = 0;
			$CodSubProductoAnt = 0;
			while ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				if (($Fila2["cod_producto"] != $CodProductoAnt) || ($Fila2["cod_subproducto"] != $CodSubProductoAnt))				
				{
					echo "</table>\n";
					echo "<table width='500' border='1' align='center' cellpadding='0' cellspacing='0' class='TablaDetalle'>\n";
					echo "<tr align='center' class='ColorTabla01'> \n";
					echo "<td width='57'><strong>".$Fila2["cod_producto"]."</strong></td>\n";
					echo "<td width='330' colspan='5'><strong>".$Fila["descripcion"]."</strong></td>\n";
					echo "</tr> \n";					
					echo "<tr align='center' class='ColorTabla01'> \n";		
					echo "<td width='76'>GRUPO</td>\n";
					echo "<td width='76'>MUESTRA</td>\n";
					echo "<td width='62'>LADO</td>\n";
					echo "<td width='65'>CUBA</td>\n";
					echo "<td width='87'>PESO</td>\n";
					echo "<td width='87'>HORA PESADA</td>\n";
					echo "</tr>\n";
				}
				echo "<tr>\n";
				echo "<td align='center'>".$Fila2["cod_grupo"]."</td>\n";
				echo "<td align='center'>".strtoupper($Fila2["cod_muestra"])."</td>\n";
				echo "<td align='center'>";
				if ($Fila2["cod_lado"] != "")
					echo strtoupper($Fila2["cod_lado"]);
				else
					echo "&nbsp;";
				echo "</td>\n";
				echo "<td align='center'>".$Fila2["cod_cuba"]."</td>\n";
				echo "<td align='right'>".number_format($Fila2["peso_produccion"],0,",",".")."</td>\n";
				echo "<td align='center'>".$Fila2["hora"]."</td>\n";

				echo "</tr>\n";
				$SubTotalPeso = $SubTotalPeso + $Fila2["peso_produccion"];
				$TotalDia = $TotalDia + $Fila2["peso_produccion"];
				$CodProductoAnt = $Fila2["cod_producto"];
				$CodSubProductoAnt = $Fila2["cod_subproducto"];				
			}
			if ($SubTotalPeso != 0)
			{
				echo "<tr>\n";				
				echo "<td align='right' colspan='4'><strong>SUB TOTAL PRODUCTO</strong></td>\n";
				echo "<td align='right'><strong>".number_format($SubTotalPeso,0,",",".")."</strong></td>\n";
				echo "</tr>\n<br>";						
			}			
		}		
		if ($TotalDia != 0)
		{
			echo "<tr>\n";				
			echo "<td align='right' colspan='4'><strong>TOTAL DIA :".substr($FechaAux,8,2)."/".substr($FechaAux,5,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
			echo "<td align='right'><strong>".number_format($TotalDia,0,",",".")."</strong></td>\n";
			echo "</tr>\n";						
		}
		$FechaAux = date("Y-m-d", mktime(1,0,0,substr($FechaAux,5,2),(intval(substr($FechaAux,8,2)) + 1),substr($FechaAux,0,4)));
		echo "</table>\n";
	}
?>
</form>
</body>
</html>
