<?php
$CodigoDeSistema = 1;
$CookieRut= $_COOKIE["CookieRut"];
include("../principal/conectar_principal.php");
$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];
$Rut =$CookieRut;


if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni = 0;
}
if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin = 20;
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
if(isset($_REQUEST["CmbUsuarios"])) {
	$CmbUsuarios = $_REQUEST["CmbUsuarios"];
}else{
	$CmbUsuarios = "";
}
if(isset($_REQUEST["AnoIni2"])) {
	$AnoIni2 = $_REQUEST["AnoIni2"];
}else{
	$AnoIni2 = "";
}
if(isset($_REQUEST["AnoFin2"])) {
	$AnoFin2 = $_REQUEST["AnoFin2"];
}else{
	$AnoFin2 = "";
}
if(isset($_REQUEST["NumIni"])) {
	$NumIni = $_REQUEST["NumIni"];
}else{
	$NumIni = 0;
}
if(isset($_REQUEST["NumFin"])) {
	$NumFin = $_REQUEST["NumFin"];
}else{
	$NumFin = 0;
}

?>
<html>
<head>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt,N)
{
	var f = document.frmPrincipal;
		switch (opt)
	{
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
			f.submit(); 
			break;
		case "C":
			if(f.CmbPeriodo.value=='-1')
			{
				alert("Debe Seleccionar Periodo");
				f.CmbPeriodo.focus();
				return;
			}
			if ((N =='1')||(N =='2')||(N =='3'))
			{
				if(f.CmbUsuarios.value=='-1')
				{
				alert("Debe Seleccionar Usuario");
				f.CmbUsuarios.focus();
				return;
				}
			}
			var TotalDiasT=0;
			var CantDiasI=0;
			var CantDiasT=0;
			var TotalDiasI=0;
			var DifDias=0;
			var Mostrar =1;
			CantDiasI=365*parseInt(f.AnoIni.value);
			TotalDiasI=parseInt(CantDiasI)+(31*parseInt(f.MesIni.value))+parseInt(f.DiaIni.value);
			CantDiasT=365*parseInt(f.AnoFin.value);
			TotalDiasT=CantDiasT+(31*parseInt(f.MesFin.value))+parseInt(f.DiaFin.value);
			DifDias=TotalDiasT-TotalDiasI;
			if (DifDias > 65)
			{
				alert("Rango de busqueda debe ser 2 meses aprox.")
				Mostrar=2;
				return;
			}
			if (f.AnoFin.value==f.AnoIni.value)
			{
				if ((f.MesFin.value-f.MesIni.value)>2)
				{
					alert("El rango de fecha debe ser menor o igual a 2 meses");
					Mostrar=2;
					return;
				}
			}
			if (Mostrar == 1)
			{
				f.action = "cal_con_solicitudes_por_usuario.php";
				f.submit();
			}
			break;
		case "E":
			f.action = "cal_xls_solicitudes_por_usuario.php";
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
	/*if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 20;*/
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <table width="663" border="0">
    <tr> 
      <td width="657" align="center" valign="middle"><strong>Consulta de Solicitudes</strong></td>
    </tr>
  </table>
  <br>
  <table width="682" border="0" class="TablaDetalle">
    <tr> 
      <td width="96" height="26">Fecha Inicio</td>
      <td colspan="3"><select name="DiaIni" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}/*
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}*/
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
			}/*
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}*/
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
			}/*
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}*/
		}
		?>
        </select> </td>
      <td width="90">Fecha Termino</td>
      <td width="255"><select name="DiaFin" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}/*
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}*/
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
			}/*
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}*/
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
			}/*
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}*/
		}
		?>
        </select> </td>
    </tr>
    <tr> 
      <td height="24">Periodo</td>
      <td width="126"><font size="1"><font size="1"><font size="2"><strong> 
        <select name="CmbPeriodo" style="width:110">
          <option value ='-1' selected>Seleccionar</option>
          <?php 
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
        </strong> </font></font></font></td>
      <td width="27">&nbsp;</td>
      <td width="59">&nbsp; </td>
      <?php
	  if (($Nivel ==1)||($Nivel ==2)||($Nivel ==3) ||($Nivel ==6))

	 {  
	    echo "<td>Usuarios</td>";
        echo "<td><select name='CmbUsuarios'>";
        echo "   <option value='-1'>Seleccionar</option>";
        $Consulta = "select STRAIGHT_JOIN t1.rut,t1.nombres,t1.apellido_paterno,t1.apellido_materno from proyecto_modernizacion.funcionarios t1 ";
		$Consulta= $Consulta." inner join proyecto_modernizacion.sistemas_por_usuario t2  ";
		$Consulta= $Consulta." on t1.rut=t2.rut ";
		$Consulta= $Consulta." where t2.cod_sistema=1 and ((t2.nivel between 2 and 13) or (t2.nivel = 16)) order by t1.apellido_paterno,t1.apellido_materno,t1.nombres ";
		$Respuesta=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			if ($CmbUsuarios == $Fila["rut"])
			{
				echo"<option value='".$Fila["rut"]."'selected>".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]))." ".ucwords(strtolower($Fila["nombres"]))."</option>";
			}
			else
			{
				echo "<option value='".$Fila["rut"]."'>".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]))." ".ucwords(strtolower($Fila["nombres"]))."</option>";
			}
		}
		
        echo "</select></td>";
    	}
		?>	
	</tr>
    <tr align="center" valign="middle"> 
      <td height="24"><div align="left">Lineas por P&aacute;g.</div></td>
      <td height="24"><div align="left"><strong><font size="1"><font size="1"><font size="2"> 
          </font><font size="2"> 
          <input name="LimitFin" type="text" id="LimitFin5" value="<?php echo $LimitFin;?>" size="12" maxlength="12">
          </font></font></font> </strong></div></td>
      <td height="24" colspan="4"><div align="left"> 
          <input type="button" name="BtnConsulta2" value="Consultar" onClick="Proceso('C','<?php echo $Nivel; ?>');" style="width:70px;">
          &nbsp; 
          <input type="button" name="BtnExcel2" value="Excel" onClick="Proceso('E');" style="width:70px;">
          &nbsp; 
          <input type="button" name="BtnSalir2" value="Salir" onClick="Proceso('S')" style="width:70px;">
        </div></td>
    </tr>
  </table>
  <br>
<?php


	$SolIni = $AnoIni2."000000";
	$SolFin = $AnoFin2."000000";
	$SolIni = $SolIni + $NumIni;
	$SolFin = $SolFin + $NumFin;

	if(strlen($MesIni)==1){
		$MesIni ="0".$MesIni;
	 }
	 if(strlen($MesFin)==1){
		$MesFin ="0".$MesFin;
	 }
	 if(strlen($DiaIni)==1){
		$DiaIni ="0".$DiaIni;
	 }
	 if(strlen($DiaFin)==1){
		$DiaFin ="0".$DiaFin;
	 }

	$FechaIni = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaFin = $AnoFin."-".$MesFin."-".$DiaFin;
?>	    
  <table width="<?php echo $Total;  ?>" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="125"><strong># Solicitud</strong></td>
      <td width="81"><strong>Agrupacion</strong></td>
	  <td width="81"><strong>Id. Muestra</strong></td>
      <td width="132"><strong>Fecha Muestra</strong></td>
      <td width="68"><strong>Producto</strong></td>
      <td width="86"><strong>SubProducto</strong></td>
      <td width="78"><strong>Estado</strong></td>
      <?php
    echo "</tr>";
	$Consulta = "select fecha_muestra,nro_solicitud,recargo, if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado, id_muestra, ";
	$Consulta.= " rut_funcionario, fecha_hora,agrupacion ";
	if($AnoIni<2009 && $AnoIni>0)
		$Consulta.= " from cal_histo.solicitud_analisis_a_".$AnoIni." t1 ";
		else
		$Consulta.= " ,nro_sa_lims from cal_web.solicitud_analisis t1 ";
	if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
	{
		$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59'";
	}
	else
	{
		$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' and t1.cod_producto <> 1 ";
	}
	if (($Nivel ==1)|| ($Nivel==2)||($Nivel ==3) || ($Nivel==6))
	{
		$Consulta.= " and (not isnull(nro_solicitud) or nro_solicitud = '') and (t1.cod_periodo = '".$CmbPeriodo."') ";
         if($CmbUsuarios!='-1' && $CmbUsuarios !="")
		 	$Consulta.=" and rut_funcionario = '".$CmbUsuarios."'";
	}
	else
	{	
		$Consulta.= " and (not isnull(nro_solicitud) or nro_solicitud = '') and (t1.cod_periodo = '".$CmbPeriodo."')";
		if($Rut!="")
			$Consulta.=" and rut_funcionario = '".$Rut."'";
	}
		
	$Consulta.= " order by nro_solicitud,recargo_ordenado";
	//echo $Consulta."<br>";
	$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
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
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."')\">\n";
				echo $Row["nro_sa_lims"]."</a></td>\n";
			}

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
		$Consulta = "select STRAIGHT_JOIN t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto";
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta.=" from cal_histo.solicitud_analisis_a_".$AnoIni." t1 ";
			else
			$Consulta.=" from cal_web.solicitud_analisis t1 ";
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
		//echo $Consulta;
		$Resp = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp))
			echo "<td>".$Row2["nombre_subclase"]."</td>\n";
		else	echo "<td>&nbsp;</td>\n";
		//-------------------------------------------------------
		
		echo "</tr>\n";
	}
?>
  </table>
  <table width="667" border="0" cellpadding="0" cellspacing="0">
          <tr>
            
      <td width="667" height="25" align="center" valign="middle"><strong> </strong>Paginas 
        &gt;&gt; 
        <?php		
		$Consulta = "select count(*) as total_registros ";
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta.= " from cal_histo.solicitud_analisis_a_".$AnoIni." t1 ";
			else
			$Consulta.= " from cal_web.solicitud_analisis t1 ";
		if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
		{
			$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59'";
		}
		else
		{
			$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' and t1.cod_producto <> 1 ";
		}
		if (($Nivel ==1)|| ($Nivel==2)||($Nivel ==3) || ($Nivel ==6))
		{
			$Consulta.= " and (not isnull(nro_solicitud) or nro_solicitud = '') and (t1.cod_periodo = '".$CmbPeriodo."') and rut_funcionario = '".$CmbUsuarios."'";
		}
		else
		{	
			$Consulta.= " and (not isnull(nro_solicitud) or nro_solicitud = '') and (t1.cod_periodo = '".$CmbPeriodo."') and rut_funcionario = '".$Rut."'";
		}
		//echo $Consulta."<br>";
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
				$StrPaginas.=  "<a href=JavaScript:Recarga('cal_con_solicitudes_por_usuario.php','".($i * $LimitFin)."');>";
				$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
			}
		}
		echo substr($StrPaginas,0,-15);
?>
      </td>
          </tr></table>
<p>&nbsp;</p></form>
</body>
</html>
