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
	$LimitIni =  0;
}
if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin =  30;
}

if(isset($_REQUEST["AnoIni"])) {
	$AnoIni = $_REQUEST["AnoIni"];
}else{
	$AnoIni =  date("Y");
}
if(isset($_REQUEST["AnoFin"])) {
	$AnoFin = $_REQUEST["AnoFin"];
}else{
	$AnoFin =  date("Y");
}
if(isset($_REQUEST["NumIni"])) {
	$NumIni = $_REQUEST["NumIni"];
}else{
	$NumIni = "";
}
if(isset($_REQUEST["NumFin"])) {
	$NumFin = $_REQUEST["NumFin"];
}else{
	$NumFin = "";
}
if(isset($_REQUEST["SolIni"])) {
	$SolIni = $_REQUEST["SolIni"];
}else{
	$SolIni =  0;
}
if(isset($_REQUEST["SolFin"])) {
	$SolFin = $_REQUEST["SolFin"];
}else{
	$SolFin =  0;
}
if(isset($_REQUEST["CmbProductos"])) {
	$CmbProductos = $_REQUEST["CmbProductos"];
}else{
	$CmbProductos = "";
}
if(isset($_REQUEST["CmbSubProducto"])) {
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
}else{
	$CmbSubProducto = "";
}

?>
<html>
<head>
<title>Consulta por Rengo de Certificados</title>
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
				alert("Debe Ingresar #Cert. de Inicio");
				f.NumIni.focus();
				return;
			}
			if (f.NumFin.value=="")
			{
				alert("Debe Ingresar #Cert. de Termino");
				f.NumFin.focus();
				return;
			}
			f.action = "cal_por_rango_certificado.php";
			f.submit();
			break;
		case "E":
			if (f.NumIni.value=="")
			{
				alert("Debe Seleccionar #Cert. de Inicio");
				f.NumIni.focus();
				return;
			}
			if (f.NumFin.value=="")
			{
				alert("Debe Seleccionar #Cert. de Termino");
				f.NumFin.focus();
				return;
			}
			f.action = "cal_xls_por_rango_certificado.php?AnoIni=" + f.AnoIni.value + "&NumIni=" + f.NumIni.value + "&AnoFin=" + f.AnoFin.value + "&NumFin=" + f.NumFin.value;

			//f.action = "cal_xls_por_rango_certificado.php?AnoIni=" + f.AnoIni.value + "&CertIni=" + f.CertIni.value + "&AnoFin=" + f.AnoFin.value + "&CertFin=" + f.CertFin.value;
			f.submit();
			break;
	}
}

function mostrar_cert(nro_solicitud,nro_certificado)
{
	var frm=document.frmPrincipal;
	frm.action="cal_consulta2.php?nro_certificado="+nro_certificado+"&nro_solicitud="+nro_solicitud;
	frm.submit();
}
function TeclaPulsada1(salto) 
{ 
	var frm = document.frmPrincipal;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("frm." + salto + ".focus();");
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
  <table width="758" border="0">
    <tr>
      <td width="695" align="center" valign="middle"><strong>Consulta por Rango de Cetificados</strong></td>
    </tr>
  </table>
  <br>
  <table width="758" border="0" class="TablaDetalle">
    <tr> 
      <td width="110">N° Certificado Inicio</td>
      <td width="132"><select name="AnoIni" style="width:60px;">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoIni))
				{
					if ($i == $AnoIni)
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
		
          </select> <input name="NumIni" type="text" id="NumIni2"  onKeyDown="TeclaPulsada1('NumFin')" value="<?php echo $NumIni; ?>" size="10" maxlength="15"></td>
      <td width="120">N° Certificado Termino</td>
      <td width="148"><select name="AnoFin" style="width:60px;">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoFin))
				{
					if ($i == $AnoFin)
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
		
        </select> <input name="NumFin" type="text" id="NumFin2" value="<?php echo $NumFin; ?>" size="10" maxlength="15"></td>
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
  <?php
  //hasta aqui 
  //pegar tabla del otro
  ?>
  		 <table width="758" height="17" border="0" cellpadding="0" bordercolor="#b26c4a" class="TablaInterior">
          <tr class="ColorTabla01"> 
           	<td width='125'><div align='center'>#CERTIFICADO</div></td>
           	<td width='174'><div align='center'>#SOLICITUD</div></td>
           	<td width='276'><div align='center'>NOMBRE GENERADOR</div></td>
           	<td width='170'><div align='center'>FECHA CERTIFICADO </div></td>
<?php

	//if (!isset($AnoIni))
	//	$AnoIni = 0;
	if ($NumIni=="")
		$NumIni = 0;
	//if (!isset($AnoFin))
	//	$AnoFin = 0;
	if ($NumFin=="")
		$NumFin = 0;
	$CertIni = $AnoIni."000000";
	$CertFin = $AnoFin."000000";

	$CertIni = $SolIni + $NumIni;
	$CertFin = $SolFin + $NumFin;
	
	$consulta="select * from cal_web.certificados where nro_certificado between '".$CertIni."' and '".$CertFin."' ";
	$consulta.= " and  SUBSTRING(fecha_hora,1,4) between '".$AnoIni."' and '".$AnoFin."' order by nro_certificado,nro_solicitud";
	$consulta.= " LIMIT ".$LimitIni.", ".$LimitFin;
	$respuesta =mysqli_query($link, $consulta);
	while ($fila=mysqli_fetch_array($respuesta))
	{
		$nro		= $fila["nro_solicitud"];
		$cert		= $fila["nro_certificado"];
		$producto 	= $CmbProductos;
		$sub       	= $CmbSubProducto;
		
		 
		echo"<tr>";
		echo"<td width='100'><div align='center'><a href=\"JavaScript:mostrar_cert('".$nro."','".$cert."')\">\n";
		echo $fila["nro_certificado"]."</a></div></td>";

		$consulta1="select nro_sa_lims from cal_web.solicitud_analisis where nro_solicitud = '".$nro."' limit 1"; 
		$respuesta1=mysqli_query($link, $consulta1);
		$fila1=mysqli_fetch_array($respuesta1); 

		if ($fila1["nro_sa_lims"]=='') {
			echo"<td width='150'><div align='center'>".$fila["nro_solicitud"]."</div></td>";
		}else{
			echo"<td width='150'><div align='center'>".$fila1["nro_sa_lims"]."</div></td>";
		}

		$consulta2="select rut,apellido_paterno,apellido_materno,nombres from proyecto_modernizacion.funcionarios where rut ='".$fila["rut_generador"]."'";
		$respuesta2=mysqli_query($link, $consulta2);
		$fila2=mysqli_fetch_array($respuesta2);
		if ($fila["rut_generador"] == $fila2["rut"])	
		{
			$nombre=$fila2["nombres"]." ".$fila2["apellido_paterno"]." ".$fila2["apellido_materno"];
			echo"<td width='300'><div align='center'>$nombre</div></td>";
		}
		echo"<td width='200'><div slign='LEFT'>".$fila["fecha_hora"]."</div></td>";
		echo"</tr>";
	}
	
?>	
<?php

	//dejar esto para las paginas
?>
  </table>
  <table width="758" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="25" align="center" valign="middle">Paginas &gt;&gt; 
              <?php		
		$Consulta = "select count(*) as total_registros ";
		$Consulta.= " from cal_web.certificados ";
		$Consulta.= " where nro_certificado between '".$CertIni."' and '".$CertFin."'";
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
				$StrPaginas.=  "<a href=JavaScript:Recarga('cal_por_rango_certificado.php','".($i * $LimitFin)."');>";
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
