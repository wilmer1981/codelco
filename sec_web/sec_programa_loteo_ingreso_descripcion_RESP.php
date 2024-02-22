<?php 	
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Proceso,ValorCheck)
{
	var Frm=document.FrmProceso;
	
	Frm.action="sec_programa_loteo_proceso01.php?Proceso=D&Valores="+ValorCheck+"&ValorCheck="+ValorCheck;
	Frm.submit();
	
}
function Salir()
{
	window.close();
}
</script>
<title>Modificacion Fecha Preembarque</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body onload="document.FrmProceso.TxtDescripcion.focus()" background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
  <table width="409" height="119" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="0" >
          <tr> 
            <td width="116">&nbsp;</td>
            <td width="269" align="right">&nbsp;&nbsp;</td>
          </tr>
          <tr> 
            <td><strong>Descripcion</strong></td>
            <td><textarea name="TxtDescripcion" style="width:270;height:50"></textarea> 
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="395" border="0">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('<?php echo $Proceso;?>','<?php echo $ValorCheck;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
