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
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sec_con_inf_boletas_cortes.php";
			f.submit();
			break;
		case "S":
			f.action ="../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
function Excel()
{
 var f=document.frmPrincipal;
 f.action ="sec_con_inf_boletas_cortes_excel.php";
 f.submit();
}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <?php		
	if ($cmbconsulta == "8")
	{
		echo "<tr class='TablaInterior'>\n";
		echo "<td width='78'>Producto</td>\n";
		echo "<td width='263'><select name='Producto' style='width:250px;' onChange='Recarga()'>\n";     
		echo "<option selected value='S'>Seleccionar</option>\n";
		$Consulta = "select * from proyecto_modernizacion.productos order by descripcion";     
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))                   
		{
			if ($Fila["cod_producto"] == $Producto)
				echo "<option selected value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
			else
				echo "<option value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
		}
		echo "</select></td>\n";
		echo "<td width='99'>SubProducto</td>\n";
		echo "<td width='241'><select name='SubProducto' style='width:250px;' onChange='Recarga()'>\n";    
		echo "<option selected value='S'>Seleccionar</option>\n";
		$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$Producto."' order by descripcion";     
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))                   
		{
			if ($Fila["cod_subproducto"] == $SubProducto)
				echo "<option selected value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
			else
				echo "<option value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
		}        
		echo "</select></td>\n";
		echo "</tr>\n";
	}
	if ($cmbconsulta == "9")
	{
		echo "<tr>\n";
		echo "<td>Nro. Solicitud:</td>\n";
		echo "<td><input name='NumSolicitud' size='10' type='text' value='".$NumSolicitud."'></td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>
  <tr align="center"> 
    <td colspan="4"><strong>INFORME DIGITACION BOLETAS DE PESAJE</strong></td>
  </tr>
  <tr> 
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr> 
    <td width="92">Fecha Inicio:</td>
    <td width="263"><select name="DiaIni" style="width:50px;">
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
    <td width="112">Fecha Termino:</td>
    <td width="264"><select name="DiaFin" style="width:50px;">
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
      </select>
    </td>
  </tr>
  <tr align="center"> 
    <td colspan="4">
	  <input name="btnexcel" type="button" style="width:70" onClick="JavaScript:Excel()" value="Excel"> 
      <input type="submit" name="Submit" value="Consultar" style="width:70" onClick="JavaScript:Proceso('C')">
      <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')"> 
      <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir">
    </td>
  </tr>
</table>
<br>
<table width="786" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01"> 
    <td width="45">GRUPO</td>
    <td width="73">TIPO DESC.</td>
    <td width="86">NUM. CIRC.</td>
    <td width="96">HORA DESC.</td>
    <td width="80">KAH DIR. D</td>
    <td width="74">KAH INV. D</td>
    <td width="94">FECHA CONEX.</td>
    <td width="80">HORA CONEX.</td>
    <td width="63">KAH DIR.C</td>
    <td width="72">KAH INV.C</td>
  </tr>  
  <?php
	$Consulta = "select * from sec_web.cortes_refineria ";
	$Consulta.= " where fecha_desconexion between '".$FechaInicio." 00:00:00' and '".$FechaTermino." 23:59:59' ";
	$Consulta.= " order by fecha_desconexion";
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalCortes = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
		echo "<td align='center'>".$Fila["tipo_desconexion"]."</td>\n";
		echo "<td align='center'>&nbsp;</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_desconexion"],11,5)."</td>\n";
		echo "<td align='right'>".$Fila["kahdird"]."</td>\n";
		echo "<td align='right'>".$Fila["kahinvd"]."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_desconexion"],8,2)."/".substr($Fila["fecha_desconexion"],5,2)."/".substr($Fila["fecha_desconexion"],0,4)."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_conexion"],11,5)."</td>\n";
		echo "<td align='right'>".$Fila["kahdirc"]."</td>\n";
		echo "<td align='right'>".$Fila["kahinvc"]."</td>\n";
		echo "</tr>\n";
		$TotalCortes++;
	}
	?>
	
  <tr> 
    <td colspan="10"><strong>TOTAL CORTES EN PERIODO <?php echo $DiaIni."/".$MesIni."/".$AnoFin." al ".$DiaFin."/".$MesFin."/".$AnoFin ?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <?php echo $TotalCortes ?> </strong></td>
  </tr>
</table>
<br>
<br>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"><input name="btnexcel2" type="button" style="width:70" onClick="JavaScript:Excel()" value="Excel"> 
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Proceso('I')"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Proceso('S')" value="Salir">
      </td>
	 
  </tr>
</table>
</form>
</body>
</html>
