<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut=$_COOKIE["CookieRut"];
$Rut =$CookieRut;
$CodigoDeSistema = 1;
$CodigoDePantalla = 58;

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
if(isset($_REQUEST["PesoMuestra"])) {
	$PesoMuestra = $_REQUEST["PesoMuestra"];
}else{
	$PesoMuestra = "";
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
if(isset($_REQUEST["Encontro"])) {
	$Encontro = $_REQUEST["Encontro"];
}else{
	$Encontro = "";
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
	if(frm.PesoMuestra.value=="")
	{
		alert("Debe ingresar Peso Muestra");
		frm.PesoMuestra.focus();
		return;
	}
	frm.action="cal_generacion_recargoR01.php";
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
<?php
	if (!isset($LimitIni))
		$LimitIni = 0;
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <?php include("../principal/encabezado.php")?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="756"><table width="761" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="93"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              </strong>Usuario: </font></font></td>
            <td width="235"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
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
              </strong></font></font></td>
            <td width="92">Fecha:</td>
            <td colspan="3"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php echo $Fecha_Hora ?>
              </strong>&nbsp; <strong> <?php
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
            <td height="31"> <font size="1"><font size="1"><font size="2"> 
              <!-- <select name="AnoIni2" style="width:60px;">-->
              <?php
			/*for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($AnoIni2))
				{
					if ($i == $AnoIni2)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
				else
				{
					if ($i == date("Y"))
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else	echo "<option value='".$i."'>".$i."</option>\n";
				}
			}*/
		?>
              <!-- </select>-->
              </font></font></font> <?php
			/*if (!isset($AnoIni2))
			$AnoIni2 = 0;
			if (!isset($NumSolicitud))
			{
				$NumSolicitud = 0;
				$NumSolicitud = $AnoIni2."000000";
				$NumSolicitud = $NumSolicitud + $NumSolicitud;
			}*/
			?>
              <input name="NumSolicitud" type="text" id="NumSolicitud" value="<?php  echo $NumSolicitud; ?>"></td>
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Id 
              Muestra</font></font></font></font></font></font></td>
            <td width="128"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2"> 
              <input name="IdMuestra" type="text" id="IdMuestra" value="<?php  echo $IdMuestra; ?>">
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></td>
            <td width="90">Peso Muestra</td>
            <td width="90"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="1"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><strong><strong><font size="1"><font size="2">
              <input name="PesoMuestra" type="text" id="PesoMuestra" style="width:60"  value="<?php  echo $PesoMuestra; ?>">
              </font></font></strong></strong></strong></strong></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></td>
          </tr>
        </table>
        <table width="761" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
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
				//echo "<input name='BtnLeyes' type='button'  value='Leyes' onClick=\"MostrarLeyes('$NumSolicitud');\"></td>";
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
		if ($MensajeGenerar=='S')
		{
			echo "alert('Ud ha generado con exito el recargo R ');";
		}
		if ($Mostrar=='S')
		{
			echo "alert('Ya existe  recargo R para esta solicitud');";
		}
		if ($Encontro=='N')
		{
			echo "alert('Esta solicitud No Existe');";
		}
		echo "</script>"

?>
