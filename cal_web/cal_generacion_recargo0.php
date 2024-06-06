<?php
$CodigoDeSistema=1;
$CodigoDePantalla = 43;

$CookieRut=$_COOKIE["CookieRut"];
$Rut =$CookieRut;

include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y H:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

//$CodigoDePantalla = 5;
$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '1'  ";
$Respuesta =mysqli_query($link, $Consulta);
if($Fila =mysqli_fetch_array($Respuesta))
{
	$Nivel = $Fila["nivel"];
}

if(isset($_REQUEST["NumSolicitud"])) {
	$NumSolicitud = $_REQUEST["NumSolicitud"];
}else{
	$NumSolicitud = "";
}
if(isset($_REQUEST["IdMuestra"])) {
	$IdMuestra = $_REQUEST["IdMuestra"];
}else{
	$IdMuestra = "";
}
if(isset($_REQUEST["Mostrar"])) {
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar = "";
}
if(isset($_REQUEST["MensajeGenerar"])) {
	$MensajeGenerar = $_REQUEST["MensajeGenerar"];
}else{
	$MensajeGenerar = "";
}
if(isset($_REQUEST["MensajeLey"])) {
	$MensajeLey = $_REQUEST["MensajeLey"];
}else{
	$MensajeLey = "";
}
if(isset($_REQUEST["Encontro"])) {
	$Encontro = $_REQUEST["Encontro"];
}else{
	$Encontro = "";
}
if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni = 0;
}
?>
<html>
<head>
<title>Administracion de Solicitudes de Muestreo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Generar()
{
	var frm=document.FrmRecepcion;
	if (frm.NumSolicitud.value=="")
	{
		alert("Ingrese Nro Solicitud ");
		frm.NumSolicitud.focus();
		return;
	}
	if (frm.IdMuestra.value=="")
	{
		alert("Ingrese Nro Muestra ");
		frm.IdMuestra.focus();
		return;
	}
	frm.action="cal_generacion_recargo01.php";
	frm.submit();
}
function Salir()
{
	var Frm=document.FrmRecepcion;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=44";
	Frm.submit();
}
function MostrarLeyes(Sol)
{
	
	var Frm=document.FrmSolicitud;
	window.open("cal_leyes_recargo0.php?Sol="+Sol,""," fullscreen=yes,width=800,height=600,scrollbars=yes,resizable = yes");		
}	
</script>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmRecepcion" method="post" action="">
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="779" align="center" valign="top"><br>
        <br>        <table width="740" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr align="center" class="ColorTabla01">
            <td colspan="4"><em><strong>CREAR RECARGO &quot;0&quot; </strong></em></td>
          </tr>
          <tr> 
            <td width="90"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              </strong>Usuario: </font></font></td>
            <td colspan="3"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
	  	$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
		{	
			echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
		}	  
	  	else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
					}
			}
		  ?>
              </strong></font></font><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              </strong></font></font></td>
          </tr>
          <tr>
            <td>Fecha:</td>
          <td colspan="3"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $Fecha_Hora ?> </strong>&nbsp; <strong>
          <?php
			if (!isset($FechaHora))
  			{
				echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
				$FechaHora=date('Y-m-d H:i');
 			}
  			else
  			{ 
				echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
  			}
		  ?>
</strong></font></font></td>
          </tr>
          <tr> 
            <td height="31"><font size="2"> Nro Solicitud</font> </td>
            <td width="229" height="31"><input name="NumSolicitud" type="text" id="NumSolicitud" value="<?php  echo $NumSolicitud; ?>"></td>
            <td width="89"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Id 
              Muestra</font></font></font></font></font></font></td>
            <td width="344"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
              <input name="IdMuestra" type="text" id="IdMuestra" value="<?php  echo $IdMuestra; ?>">
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></td>
          </tr>
        </table>
        <br>
        <table width="430" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
          <tr> 
            <td width="314"><div align="right">
                <input name="BtnGenerar" type="button" id="BtnGenerar" value="Generar" onClick="Generar();">
              </div></td>
            <td width="160"><div align="center"> </div>
              <div align="center"> 
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70" onClick="Salir('');">
              </div></td>
            <td width="116">
			<?php
			if (($NumSolicitud!="")&&($IdMuestra!=""))
			{ 
				echo "<input name='BtnLeyes' type='button'  value='Leyes' onClick=\"MostrarLeyes('$NumSolicitud');\"></td>";
            }
			
			?>
			<td width="144">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
  </table>
 <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
		echo "<script languaje='JavaScript'>";
		if ($MensajeLey=='S')
		{
			echo "alert('Ud ha ingresado con exito  las leyes del recargo 0 ');";
		}
		if ($MensajeGenerar=='S')
		{
			echo "alert('Ud ha generado con exito el recargo 0 ');";
		}
		if ($Mostrar=='S')
		{
			echo "alert('Ya existe  recargo 0 para esta solicitud');";
		}
		if ($Encontro=='N')
		{
			echo "alert('Esta solicitud No Existe');";
		}
		echo "</script>"

?>
