<?php
$CodigoDeSistema = 1;
$CookieRut= $_COOKIE["CookieRut"];

include("../principal/conectar_principal.php");
$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];

if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin = 30;
}
if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni = 0;
}

if(isset($_REQUEST["DiaIni"])) {
	$DiaIni = $_REQUEST["DiaIni"];
}else{
	$DiaIni = date("d");
}
if(isset($_REQUEST["MesIni"])) {
	$MesIni = $_REQUEST["MesIni"];
}else{
	$MesIni = date("m");
}
if(isset($_REQUEST["AnoIni"])) {
	$AnoIni = $_REQUEST["AnoIni"];
}else{
	$AnoIni = date("Y");
}
if(isset($_REQUEST["DiaFin"])) {
	$DiaFin = $_REQUEST["DiaFin"];
}else{
	$DiaFin = date("d");
}
if(isset($_REQUEST["MesFin"])) {
	$MesFin = $_REQUEST["MesFin"];
}else{
	$MesFin = date("m");
}
if(isset($_REQUEST["AnoFin"])) {
	$AnoFin = $_REQUEST["AnoFin"];
}else{
	$AnoFin = date("Y");
}

if(isset($_REQUEST["CmbAgrupacion"])) {
	$CmbAgrupacion = $_REQUEST["CmbAgrupacion"];
}else{
	$CmbAgrupacion = "";
}
if(isset($_REQUEST["CmbTipo"])) {
	$CmbTipo = $_REQUEST["CmbTipo"];
}else{
	$CmbTipo = "";
}
if(isset($_REQUEST["CmbPeriodo"])) {
	$CmbPeriodo = $_REQUEST["CmbPeriodo"];
}else{
	$CmbPeriodo = "";
}
if(isset($_REQUEST["IdMuestra"])) {
	$IdMuestra = $_REQUEST["IdMuestra"];
}else{
	$IdMuestra = "";
}

?>
<html>
<head>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
			f.submit(); 
			break;
		case "C":
			if (f.CmbAgrupacion.value=='-1')
			{
				alert("Debe Seleccionar Agrupacion ");
				f.CmbAgrupacion.focus();
				return;
			}
			if (f.CmbTipo.value=='-1')
			{
				alert("Debe Seleccionar Tipo ");
				f.CmbTipo.focus();
				return;
			}
			if (f.IdMuestra.value == "")
			{
				var m = confirm("Si no especifica Id. Muestra a Buscar\nLa consulta tomará todas las solicitudes\nEntre las Fechas Seleccionadas");
				if (m==true)
				{
					f.action = "cal_con_solicitudes.php";
					f.submit();
				}
				else
				{
					return;
				}
			}
			else
			{
				f.action = "cal_con_solicitudes.php";
				f.submit();
			}
			break;
		case "E":
			f.action = "cal_xls_solicitudes.php";
			f.submit();
			break;
	}
}

function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

function Recarga(URL,LimiteIni)
{
	var frm=document.frmPrincipal;
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "?LimitIni=" + LimiteIni;
	frm.submit(); 
}

</script>
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
<?php
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 10;
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <table width="765" border="0">
    <tr> 
      <td width="695" align="center" valign="middle"><strong>Consulta de Solicitudes</strong></td>
    </tr>
  </table>
  <br>
  <table width="760" border="0" class="TablaDetalle">
    <tr> 
      <td width="86" height="24">Fecha Inicio</td>
      <td width="214"><select name="DiaIni" style="width:50px;">
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
		for ($i = (date("Y") - 4);$i <= (date("Y") + 1); $i++)
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
        </select> </td>
      <td width="94">Fecha Termino</td>
      <td colspan="3"> <select name="DiaFin" style="width:50px;">
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
        </select>
        <select name="MesFin" style="width:90px;">
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
		for ($i = (date("Y") - 4);$i <= (date("Y") + 1); $i++)
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
    <tr> 
      <td height="24">Periodo</td>
      <td><strong> 
	  <?php
	        echo '<select name="CmbPeriodo" style="width:110">';
    	    echo "<option value ='-1' selected>Todos</option>/n";
				$Consulta = "select * from sub_clase where cod_clase = 2 order by valor_subclase1";
				$Respuesta= mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					if ($CmbPeriodo == $Fila["cod_subclase"])
					{
						echo "<option value = '".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
					else
					{
						echo "<option value = '".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";
					}
				}
		      ?>
        </select>
        </strong></td>
      <td>Agrupacion</td>
      <td width="117"><select name="CmbAgrupacion">
          <option value="-1" selected>Seleccionar</option>
          <?php
	  	$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase = 1004 and valor_subclase1= 0 ";  
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			if ($CmbAgrupacion==$Fila["cod_subclase"])
			{
				echo "<option value= '".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
			}		
			else 
			{
				echo "<option value= '".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
			}
		}
		?>
        </select></td>
      <td width="46">Tipo</td>
      <td width="174"><select name="CmbTipo">
          <option value="-1" selected>Seleccionar</option>
          <?php
	  	$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase = 1005  ";  
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			if ($CmbTipo==$Fila["cod_subclase"])
			{
				echo "<option value= '".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
			}		
			else 
			{
				echo "<option value= '".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
			}
		}
		?>
        </select></td>
    </tr>
    <tr align="center" valign="middle"> 
      <td height="24"><div align="left">ID. Muestra </div></td>
      <td height="24"><div align="left"> 
          <input name="IdMuestra" type="text" id="IdMuestra" value="<?php echo $IdMuestra; ?>" size="30" maxlength="30">
        </div></td>
      <td height="24"><div align="left">Lineas por P&aacute;g. </div></td>
      <td height="24"><div align="left">
          <input name="LimitFin" type="text" id="LimitFin3" value="<?php echo $LimitFin;?>" size="12" maxlength="12">
        </div></td>
      <td height="24">&nbsp;</td>
      <td height="24"><div align="left"> </div></td>
    </tr>
    <tr align="center" valign="middle"> 
      <td height="24">&nbsp;</td>
      <td height="24">&nbsp;</td>
      <td height="24" colspan="3"><div align="left">
          <input type="button" name="BtnConsulta2" value="Consultar" onClick="Proceso('C');" style="width:70px;">
          <input type="button" name="BtnExcel2" value="Excel" onClick="Proceso('E');" style="width:70px;">
          <input type="button" name="BtnSalir2" value="Salir" onClick="Proceso('S')" style="width:70px;">
        </div></td>
      <td height="24">&nbsp;</td>
    </tr>
  </table>
  <br>
<?php
	$FechaIni = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaFin = $AnoFin."-".$MesFin."-".$DiaFin;
	$Consulta = "select distinct(t2.cod_leyes), t3.abreviatura ";
	if($AnoIni<2009 && $AnoIni>0)	
		$Consulta.= " from cal_histo.solicitud_analisis_a_".$AnoIni." t1 inner join cal_histo.leyes_por_solicitud_a_".$AnoIni." t2  ";
		else
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2  ";		
	$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes ";
	if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5')||($Nivel=='8'))
	{
		$Consulta.= " where t1.fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59'  and (t1.agrupacion='".$CmbAgrupacion."') and (t1.tipo='".$CmbTipo."')   ";
	}
	else 
	{
		$Consulta.= " where t1.fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' and (t1.cod_producto <> 1) and (t1.agrupacion='".$CmbAgrupacion."') and (t1.tipo='".$CmbTipo."') ";
	}
	if ($IdMuestra != "")
	{ 
		$Consulta.= " and t1.id_muestra like '%".$IdMuestra."%' ";
	}
	$Consulta.= " order by t2.cod_leyes ";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	$LargoArreglo = 0;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		$ArregloLeyes[$LargoArreglo][0] = $Row["cod_leyes"];
		$ArregloLeyes[$LargoArreglo][1] = $Row["abreviatura"];
		$LargoArreglo++;
	}
	$Total = ($LargoArreglo * 70) + 550;
	
?>	    
  <table width="<?php echo $Total;?>" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="110"><strong># Solicitud</strong></td>
      <td width="80"><strong>Agrupacion</strong></td>
	  <td width="80"><strong>Id. Muestra</strong></td>
      <td width="130"><strong>Fecha Muestra</strong></td>
      <td width="67"><strong>Producto</strong></td>
      <td width="85"><strong>SubProducto</strong></td>
      <td width="99"><strong>Estado</strong></td>
      <?php
	for ($i = 0; $i < $LargoArreglo; $i++)
	{
		echo "<td width='70'>".$ArregloLeyes[$i][1]."</td>\n";
	}
?>
    </tr>
    <?php	
	$Consulta = "select fecha_muestra,nro_solicitud,recargo, if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado, id_muestra, ";
	$Consulta.= " rut_funcionario, fecha_hora,agrupacion,fecha_muestra ";
	if($AnoIni<2009 && $AnoIni>0)
		$Consulta.= " from cal_histo.solicitud_analisis_a_".$AnoIni." t1 ";
		else
		$Consulta.= " ,nro_sa_lims from cal_web.solicitud_analisis t1 ";
	if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
	{
		$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' and (t1.agrupacion='".$CmbAgrupacion."') and (t1.tipo='".$CmbTipo."') ";
	}
	else
	{
		$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' and t1.cod_producto <> 1 and (t1.agrupacion='".$CmbAgrupacion."') and (t1.tipo='".$CmbTipo."')";
	}
	$Consulta.= " and (not isnull(nro_solicitud) or nro_solicitud = '')";
	if ($CmbPeriodo != '-1')
	{
		$Consulta.= "and (t1.cod_periodo = '".$CmbPeriodo."') ";
	}
	if ($IdMuestra != "")
	{ 
		$Consulta.= " and t1.id_muestra like '%".$IdMuestra."%' ";
	}
	$Consulta.= " order by nro_solicitud,recargo_ordenado";
	$Consulta.=" LIMIT ".$LimitIni.", ".$LimitFin;
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr align='left' valign='middle'>\n";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
		{
			$Recargo='N';
			if ($Row["nro_sa_lims"]=='') {
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."')\">\n";
				echo $Row["nro_solicitud"]."</a></td>\n";
			}else{
				$Recargo='N';
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."')\">\n";
				echo $Row["nro_sa_lims"]."</a></td>\n";
			}



			//$Recargo='N';
			//echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."')\">\n";
			//echo $Row["nro_solicitud"]."</a></td>\n";
		}
		else
		{
			if ($Row["nro_sa_lims"]=='') {

				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."')\">\n";
				echo $Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";
			}else{
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."')\">\n";
				echo $Row["nro_sa_lims"]."-".$Row["recargo"]."</td>\n";
			}



			//echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."')\">\n";
			//echo $Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";
		}
		$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase = 1004 and cod_subclase = '".$Row["agrupacion"]."'";
		$Resp1=mysqli_query($link, $Consulta);
		$Fil1=mysqli_fetch_array($Resp1);
		echo "<td>".$Fil1["nombre_subclase"]."</td>\n";
		echo "<td>".$Row["id_muestra"]."</td>\n";
		if ((!is_null($Row["fecha_muestra"])) && ($Row["fecha_muestra"] != ""))
			echo "<td align='center'>".substr($Row["fecha_muestra"],8,2)."/".substr($Row["fecha_muestra"],5,2)."/".substr($Row["fecha_muestra"],0,4)." ".substr($Row["fecha_muestra"],11,5)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		//----------------------Producto y  Subproducto --------------------------------------
		$Consulta = "select t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto from ";
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta.="cal_histo.solicitud_analisis_a_".$AnoIni." t1 ";
		else
			$Consulta.="cal_web.solicitud_analisis t1 ";
		$Consulta.= " inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto  ";
		$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
		$Consulta.= " where t1.nro_solicitud = '".$Row["nro_solicitud"]."' ";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
		{	
			$Consulta = $Consulta;
		}
		else	
		{
			$Consulta.= " and recargo = '".$Row["recargo"]."'";
		}
		//echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Resp);  
		echo "<td align ='center'>".$Fila["AbrevProducto"]."</td>";
		echo "<td align = 'center'>".$Fila["AbrevSubProducto"]."</td>";
		//---------ESTADO ACTUAL---------------------------------------
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta = "select * from cal_histo.solicitud_analisis_a_".$AnoIni." t1 left join proyecto_modernizacion.sub_clase t2 ";
			else
			$Consulta = "select * from cal_web.solicitud_analisis t1 left join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t2.cod_clase = '1002' and t1.estado_actual = t2.cod_subclase ";		
		$Consulta.= " where nro_solicitud = '".$Row["nro_solicitud"]."'";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
			$Consulta = $Consulta;
		else	$Consulta.= " and recargo = '".$Row["recargo"]."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp))
			echo "<td>".$Row2["nombre_subclase"]."</td>\n";
		else	echo "<td>&nbsp;</td>\n";
		//-------------------------------------------------------
		for ($i = 0; $i < $LargoArreglo; $i++)
		{
			if($AnoIni < 2009 && $AnoIni > 0)
				$Consulta = "select *,t2.abreviatura from cal_histo.leyes_por_solicitud_a_".$AnoIni." t1";
				else
				$Consulta = "select *,t2.abreviatura from cal_web.leyes_por_solicitud t1";
			$Consulta.= " inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad ";  
			$Consulta.= " where t1.nro_solicitud = '".$Row["nro_solicitud"]."'";
			if (!is_null($Row["recargo"]) || ($Row["recargo"] != ""))
			{
				$Consulta.= " and t1.recargo = '".$Row["recargo"]."' ";
			}
			$Consulta.= " and t1.cod_leyes = '".$ArregloLeyes[$i][0]."'";
			//echo $Consulta."</br>";
			$Resp = mysqli_query($link, $Consulta);
			if ($Row2 = mysqli_fetch_array($Resp))
			{
				if ((is_null($Row2["valor"])) || ($Row2["valor"] == ""))
					echo "<td width='70'>&nbsp;</td>\n";
				else	//echo "<td width='70'>".$Row2["valor"]."&nbsp;</td>\n";
					if ($Row2["candado"]== 1)
					{
						echo "<td width='70'><font color='green'>".number_format($Row2["valor"],3)."&nbsp;".$Row2["abreviatura"]."</font></td>\n";
					}
					else
					{
						echo "<td width='70'>".number_format($Row2["valor"],3)."&nbsp;".$Row2["abreviatura"]."</td>\n";
					}
			}
			else
			{
				echo "<td width='70' align='center'><img src='../principal/imagenes/ico_x.gif'></td>\n";
			}	
		}
		echo "</tr>\n";
	}
?>
  </table>
  <table width="760" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="25" align="center" valign="middle">Paginas &gt;&gt; 
              <?php		
		$Consulta = "select count(*) as total_registros ";
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta.= " from cal_histo.solicitud_analisis_a_".$AnoIni." t1 ";
			else
			$Consulta.= " from cal_web.solicitud_analisis t1 ";
		if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
		{
			$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' and (t1.agrupacion='".$CmbAgrupacion."') and (t1.tipo='".$CmbTipo."')";
		}
		else
		{
			$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59'and t1.cod_producto <> 1 and (t1.agrupacion='".$CmbAgrupacion."') and (t1.tipo='".$CmbTipo."')";
		}
		$Consulta.= " and (not isnull(nro_solicitud) or nro_solicitud = '')";
		if ($CmbPeriodo != '-1')
		{
			$Consulta.= "and (t1.cod_periodo = '".$CmbPeriodo."') ";
		}
		if ($IdMuestra != "")
		{ 
			$Consulta.= " and t1.id_muestra like '%".$IdMuestra."%' ";
		}
		$Respuesta = mysqli_query($link, $Consulta);
		$Row = mysqli_fetch_array($Respuesta);
		$Coincidencias = $Row["total_registros"];
		$NumPaginas = ($Coincidencias / $LimitFin);
		$LimitFinAnt = $LimitIni;
		$StrPaginas = "";
		for ($i = 0; $i <= $NumPaginas; $i++)
		{
			$LimitIni = ($i * $LimitFin);
			if ($LimitIni == $LimitFinAnt)
			{
				$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
			}
			else
			{
				$StrPaginas.=  "<a href=JavaScript:Recarga('cal_con_solicitudes.php','".($i * $LimitFin)."');>";
				$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
			}
		}
		echo substr($StrPaginas,0,-15);
?>
            </td>
          </tr></table>
</form>
</body>
</html>
