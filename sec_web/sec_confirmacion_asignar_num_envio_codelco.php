<?php
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	
	$NumEnvio = isset($_REQUEST["NumEnvio"])?$_REQUEST["NumEnvio"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Tipo     = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
?>
<html>
<head>
<script language="JavaScript">
function Grabar()
{
	var Frm=document.FrmProceso;
	if (Frm.NumEnvio.value=="")
	{
		alert("Debe Ingresar Num.Envio");
		return;
	}
	
		Frm.action="sec_confirmacion_num_envio_codelco01.php?Envio="+Frm.NumEnvio.value+"&Tipo="+Frm.TipoAux.value+"&Valores="+Frm.ValoresAux.value+"&Proceso=Asignar";		
		Frm.submit();
}
function Salir()
{
	window.close();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body onload="document.FrmProceso.NumEnvio.focus()" background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
<input name="ValoresAux" type="hidden" value="<?php echo $Valores  ?>">
<input name="TipoAux" type="hidden" value="<?php echo $Tipo  ?>">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" >
          <tr> 
            <td width="113">&nbsp;</td>
            <td width="272" align="right"><strong>Fecha:&nbsp;<?php echo date('Y:m:d')?></strong>&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr> 
            <td>Numero Envio</td>
            <td> <input name="NumEnvio" type="text" id="NumEnvio" size="10" value="<?php echo $NumEnvio; ?>"></td>
          </tr>
          <!-- aqui la validacion-->
         
        </table>
        <br>
        <table width="395" border="0">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
