<?php
$CodigoDeSistema = 1;
$CookieRut= $_COOKIE["CookieRut"];

include("../principal/conectar_principal.php");
$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];

if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni = 0;
}
if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin = 30;
}
if(isset($_REQUEST["AnoIni"])) {
	$AnoIni = $_REQUEST["AnoIni"];
}else{
	$AnoIni = date("Y");
}
if(isset($_REQUEST["NumIni"])) {
	$NumIni = $_REQUEST["NumIni"];
}else{
	$NumIni = '';
}
if(isset($_REQUEST["AnoFin"])) {
	$AnoFin = $_REQUEST["AnoFin"];
}else{
	$AnoFin = date("Y");
}
if(isset($_REQUEST["NumFin"])) {
	$NumFin = $_REQUEST["NumFin"];
}else{
	$NumFin = '';
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
			if (f.NumIni.value=="")
			{
				alert("Debe Seeccionar #S.A. de Inicio");
				f.NumIni.focus();
				return;
			}
			if (f.NumFin.value=="")
			{
				alert("Debe Seeccionar #S.A. de Termino");
				f.NumFin.focus();
				return;
			}
			f.action = "cal_con_fechas.php";
			f.submit();
			break;
		case "E":
			if (f.NumIni.value=="")
			{
				alert("Debe Seeccionar #S.A. de Inicio");
				f.NumIni.focus();
				return;
			}
			if (f.NumFin.value=="")
			{
				alert("Debe Seeccionar #S.A. de Termino");
				f.NumFin.focus();
				return;
			}
			f.action = "cal_xls_fechas.php?AnoIni=" + f.AnoIni.value + "&NumIni=" + f.NumIni.value + "&AnoFin=" + f.AnoFin.value + "&NumFin=" + f.NumFin.value;
			f.submit();
			break;
	}
}

function Historial(SA,Rec,N)
{
	if ((N=='13')||(N=='1')||(N=='2')||(N=='3')||(N=='5'))
	{
		window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
	}
	else
	{
		window.open("cal_con_registro_leyes_sin_leyes.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");						
	}
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
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <table width="765" border="0">
    <tr>
      <td width="695" align="center" valign="middle"><strong>Consulta Estados de Solicitud</strong></td>
    </tr>
  </table>
  <br>
  <table width="765" border="0" class="TablaDetalle">
    <tr> 
      <td width="101">#Solicitud Inicio</td>
      <td width="132"><select name="AnoIni" style="width:60px;">
          <?php
			for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoIni))
				{
					if ($i == $AnoIni)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}/*
				else
				{
					if ($i == date("Y"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}*/
			}
		?>
        </select> <input name="NumIni" type="text" id="NumIni" value="<?php echo $NumIni; ?>" size="10" maxlength="15"></td>
      <td width="116">#Solicitud Termino</td>
      <td width="148"><select name="AnoFin" style="width:60px;">
          <?php
			for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoFin))
				{
					if ($i == $AnoFin)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}/*
				else
				{
					if ($i == date("Y"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}*/
			}
		?>
        </select> <input name="NumFin" type="text" id="NumFin" value="<?php echo $NumFin; ?>" size="10" maxlength="15"></td>
      <td width="92">Lineas por P&aacute;g.</td>
      <td width="147"><input name="LimitFin" type="text" id="LimitFin" value="<?php echo $LimitFin;?>" size="12" maxlength="12"></td>
    </tr>
    <tr align="center" valign="middle"> 
      <td colspan="6"> <input type="button" name="BtnConsulta" value="Consultar" onClick="Proceso('C');" style="width:70px;">
        <input type="button" name="BtnExcel" value="Excel" onClick="Proceso('E');" style="width:70px;">
        <input type="button" name="BtnSalir" value="Salir" onClick="Proceso('S')" style="width:70px;"> 
      </td>
    </tr>
  </table>
  <br>
  <table width="1000" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="107"><strong># Solicitud</strong></td>
      <td width="85"><strong>Id. Muestra</strong></td>
      <td width="86"><strong>Fecha Muestra</strong></td>
      <td width="78"><strong>Creada</strong></td>
      <td width="98"><strong>Recep. Muest.</strong></td>
      <td width="96"><strong>Env. Laborat.</strong></td>
      <td width="122"><strong>Recep Laborat.</strong></td>
      <td width="128"><strong>Atend. Quimico</strong></td>
      <td width="83"><strong>Finalizada</strong></td>
      <td width="94"><strong>Ult. Estado</strong></td>
    </tr>
    <?php
	if ($AnoIni=="")
		$AnoIni = 0;
	if ($NumIni=="")
		$NumIni = 0;
	if ($AnoFin=="")
		$AnoFin = 0;
	if ($NumFin=="")
		$NumFin = 0;
	$SolIni = $AnoIni."000000";
	$SolFin = $AnoFin."000000";
	$SolIni = $SolIni + $NumIni;
	$SolFin = $SolFin + $NumFin;
	$Consulta = "select nro_solicitud,recargo, if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado, id_muestra, ";
	$Consulta.= " rut_funcionario, fecha_hora,fecha_muestra ";
	if($AnoIni<2009 && $AnoIni>0){
		$Consulta.=" from cal_histo.solicitud_analisis_a_".$AnoIni;
	}else{
		$Consulta.= " ,nro_sa_lims from cal_web.solicitud_analisis ";
		$Consulta.= " where (nro_solicitud between '".$SolIni."' and '".$SolFin."') or (nro_sa_lims between '".$NumIni."' and '".$NumFin."' )  ";	
	}
		//$Consulta = $Consulta. " where (t1.nro_solicitud between '".$SolIni."' and '".$SolFin."' ) or (t1.nro_sa_lims between '".$SolIni."' and '".$SolFin."' )  ";
//echo $Consulta;
	$Consulta.= " order by nro_solicitud,recargo_ordenado";
	$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr align='center' valign='middle'>\n";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
		{
			$Recargo='N';

			if ($Row["nro_sa_lims"]=='') {
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."','".$Nivel."')\">\n";
			echo $Row["nro_solicitud"]."</a></td>\n";
			}else{
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."','".$Nivel."')\">\n";
			echo $Row["nro_sa_lims"]."</a></td>\n";
			}

			//echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."','".$Nivel."')\">\n";
			//echo $Row["nro_solicitud"]."</a></td>\n";
		}
		else
		{
			$nro_sa_lims = isset($Fila["nro_sa_lims"])?$Fila["nro_sa_lims"]:"";
			if ($nro_sa_lims=='') {
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."','".$Nivel."')\">\n";
				echo $Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";
			}else{
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."','".$Nivel."')\">\n";
				echo $Row["nro_sa_lims"]."-".$Row["recargo"]."</td>\n";
			}

			//echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."','".$Nivel."')\">\n";
			//echo $Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";
		}
		echo "<td>".$Row["id_muestra"]."</td>\n";
		//---------FECHA MUESTRA---------------------------------------
				echo "<td align='center'>".substr($Row["fecha_muestra"],8,2)."/".substr($Row["fecha_muestra"],5,2)."/".substr($Row["fecha_muestra"],0,4)." ".substr($Row["fecha_muestra"],11,5)."</td>\n";
		//------------------------------------------------------------
		for ($i = 1;$i <= 6; $i++)
		{
			if($AnoIni<2009 && $AnoIni>0)	
				$Consulta = "select * from cal_histo.estados_por_solicitud_a_".$AnoIni;
				else
				$Consulta = "select * from cal_web.estados_por_solicitud ";
			$Consulta.= " where nro_solicitud = '".$Row["nro_solicitud"]."' ";
			if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
				$Consulta = $Consulta;
			else	$Consulta.= " and recargo = '".$Row["recargo"]."'";
			$Consulta.= " and cod_estado = '".$i."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Row2 = mysqli_fetch_array($Resp))
				echo "<td>".substr($Row2["fecha_hora"],8,2)."/".substr($Row2["fecha_hora"],5,2)."/".substr($Row2["fecha_hora"],0,4)."\n".substr($Row2["fecha_hora"],11,5)."</td>\n";
			else	echo "<td>&nbsp;</td>\n";
		}
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
			$Consulta.= " from cal_histo.solicitud_analisis_a_".$AnoIni;
			else
			$Consulta.= " from cal_web.solicitud_analisis ";
		$Consulta.= " where nro_solicitud between '".$SolIni."' and '".$SolFin."'";
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
				$StrPaginas.=  "<a href=JavaScript:Recarga('cal_con_fechas.php','".($i * $LimitFin)."');>";
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
