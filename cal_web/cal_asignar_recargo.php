<?php
  include("../principal/conectar_principal.php");
  	$Rut = $CookieRut;
	$Valores=$Muestras;
	for ($j = 0;$j <= strlen($Muestras); $j++)
	{
		if (substr($Muestras,$j,2) == "//")
		{
			$MuestraFecha = substr($Muestras,0,$j);
			for ($x=0;$x<=strlen($MuestraFecha);$x++)
			{
				if (substr($MuestraFecha,$x,2) == "~~")
				{
					$Muestra = substr($MuestraFecha,0,$x);			
					$Fecha = substr($MuestraFecha,$x+2,19);
					$Consulta = "select nro_solicitud from cal_web.solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila = mysqli_fetch_array($Respuesta);
					$NroSA.= $Fila["nro_solicitud"]." / ";
				}
			}
		$Muestras = substr($Muestras,$j + 2);
		$j = 0;
		}
	}
	$NroSA = substr($NroSA,0,strlen($NroSA)-3)
  
?>
<html>
<head>
<script language="JavaScript">

function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmAsignarRecargo;
	var teclaCodigo = event.keyCode; 

	if (teclaCodigo == 13)
	{
		Frm.BtnOk.focus();
	}
	else
	{
		if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
			   		event.keyCode=46;
			   }		
			}   
		}
		else
		{
			if ((Frm.TxtRecargos.value.substr(Frm.TxtRecargos.value.length-1,1)==",")||(Frm.TxtRecargos.value.substr(Frm.TxtRecargos.value.length-1,1)==""))
			{
				if ((teclaCodigo != 37)&&(teclaCodigo != 39))
				{
					event.keyCode=46;
				}	
			}
		}
	}	     
} 

function ValidaIngreso(Muestras)
{
	var Frm=document.FrmAsignarRecargo;
    if ((Frm.TxtRecargos.value=="") && (Frm.TxtRecargos.value <=0))
	{
		alert("Debe Ingresar Cantidad de Recargos");
		Frm.TxtRecargos.focus(); 
		return;
	} 
	//  alert(Muestras);
	 // alert(Frm.TxtRecargos.value);
	Frm.action= "cal_solicitud01.php?proceso=A&Muestras="+Muestras+"&CantRecargos="+Frm.TxtRecargos.value;
	Frm.submit();
}		
</script>
<title>Asignar Recargo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
</head>
<body background="../principal/imagenes/fondo3.gif" onLoad="document.FrmAsignarRecargo.TxtRecargos.focus();">
<form action="" method="post" name="FrmAsignarRecargo" id="FrmAsignarRecargo">
  <table width="431" border="0" cellpadding="5" class="tablaprincipal">
    <tr> 
      <td width="415" height="230">
		<table width="350" border="1" class="TablaInterior">
          <tr>
            <td ><strong>Versión 3  Asignar Recargos</strong></td>
          </tr>
          <tr>
            <td height="30"><strong>&nbsp;N&uacute;mero de Solicitud Analisi  : <?php echo $NroSA;?> </strong></td>
          </tr>
        </table>
		<br>
			Ej: 1,2,3 ==> (R1, R2, R3) O 4,6 ==> (R4, R6)
		<br>
        <table width="350" border="1">
          <tr>
            <td><strong>Recargos</strong> 
              <input type="text" name="TxtRecargos" onKeyDown="TeclaPulsada()" style="width:150">
              <font size="2">
              <input name="BtnOk" type="button" value="Ok" onClick="ValidaIngreso('<?php echo $Valores;?>');">
              </font>
		    </td>
          </tr>
      </table> </td>
    </tr>
  </table>
</form>
<br>
<br> 
<br>
</body>
</html>
