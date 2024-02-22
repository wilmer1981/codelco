<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

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
	$LimitFin =  10;
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
	$NumIni =  0;
}
if(isset($_REQUEST["NumFin"])) {
	$NumFin = $_REQUEST["NumFin"];
}else{
	$NumFin =  0;
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


?>
<html>
<head>

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
<?php
/*
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 10;*/
		
		
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">

  <?php
  //hasta aqui 
  //pegar tabla del otro
  ?>
  		 <table width="758" height="17" border="0" cellpadding="0">
          <tr> 
           	<td width='90' align='center'>#CERTIFICADO</td>
           	<td width='174' align='center'>#SOLICITUD</td>
           	<td width='276' align='center'>NOMBRE GENERADOR</td>
           	<td width='170' align='center'>FECHA CERTIFICADO</td></tr>
			<br>
			
<?php	
/*
	if (!isset($AnoIni))
		$AnoIni = 0;
	if (!isset($NumIni))
		$NumIni = 0;
	if (!isset($AnoFin))
		$AnoFin = 0;
	if (!isset($NumFin))
		$NumFin = 0;*/
	$CertIni = $AnoIni."000000";
	$CertFin = $AnoFin."000000";
	$CertIni = $SolIni + $NumIni;
	$CertFin = $SolFin + $NumFin;
	
	$consulta="select * from cal_web.certificados where nro_certificado between '".$CertIni."' and '".$CertFin."' ";
	$consulta.= " and  SUBSTRING(fecha_hora,1,4) between '".$AnoIni."' and '".$AnoFin."' order by nro_certificado,nro_solicitud";
	$consulta = $consulta." LIMIT ".$LimitIni.", ".$LimitFin;

	$respuesta =mysqli_query($link, $consulta);
	while ($fila=mysqli_fetch_array($respuesta))
	{
		$nro		= $fila["nro_solicitud"];
		$cert		= $fila["nro_certificado"];
		$producto 	= $CmbProductos;
		$sub       	= $CmbSubProducto;
		
		 
		echo"<tr>";
		echo"<td width='90'><align='left'>".$fila["nro_certificado"]."</td>";
		//echo $fila["nro_certificado"]."</a></div></td>";

		$consulta1="select nro_sa_lims from cal_web.solicitud_analisis where nro_solicitud = '".$nro."' limit 1"; 
		$respuesta1=mysqli_query($link, $consulta1);
		$fila1=mysqli_fetch_array($respuesta1); 

		if ($fila1["nro_sa_lims"]=='') {
			echo"<td width='174'><align='center'>".$fila["nro_solicitud"]."</td>";
		}else{
			echo"<td width='174'><align='center'>".$fila1["nro_sa_lims"]."</td>";
		}


 		//echo"<td width='174'><align='center'>$fila["nro_solicitud"]</td>";
		$consulta2="select rut,apellido_paterno,apellido_materno,nombres from proyecto_modernizacion.funcionarios where rut ='".$fila["rut_generador"]."'";
		$respuesta2=mysqli_query($link, $consulta2);
		$fila2=mysqli_fetch_array($respuesta2);
		if ($fila["rut_generador"] == $fila2["rut"])	
		{
			$nombre=$fila2["nombres"]." ".$fila2["apellido_paterno"]." ".$fila2["apellido_materno"];
			echo"<td width='276'><align='center'>$nombre</td>";
		}
		$ano1=substr($fila["fecha_hora"],0,4);
		$mes1=substr($fila["fecha_hora"],5,2);
		$dia1=substr($fila["fecha_hora"],8,2);
		$min1=substr($fila["fecha_hora"],11,2);
		$seg1=substr($fila["fecha_hora"],14,2);
		$fecha_excel=$ano1."-".$mes1."-".$dia1."-".$min1."-".$seg1;
		/*$dia1=substr($fila2[fecha_hora,
		if (strlen($dia1) == 1)
		{
			$dia1 = '0'.$dia1;
		}
		if (strlen($mes1) ==1) 
  		{
			$mes1 = '0'.$mes1;
		}	*/		
		echo"<td width='170'><align='center'>$fecha_excel</td>";
		echo"</tr>";
	}
	
?>	
<?php

	//dejar esto para las paginas
?>
  </table>
</form>
</body>
</html>
