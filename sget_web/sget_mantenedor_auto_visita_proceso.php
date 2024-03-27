<? include("../principal/conectar_sget_web.php");


	$Consulta="SELECT * from sget_visitas where corr_visita = '".$RechazaVis."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtObsAutoriza=$Fila["observacion_autoriza"];
	}	
?>
<html>
<head>
<title>Observaci�n Rechazo Autorizaci�n</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmProceso;
	switch(Opcion)
	{
		case "G":
			if(f.TxtObsAutoriza.value!='')
			{
				f.action="sget_mantenedor_visitas_proceso01.php?Opcion=ReVisita";
				f.submit();
			}
			else
			{
				alert('Debe ingresar observaci�n');
				return;
			}
		break;
	}
}
function Salir()
{
	window.close();
}
</script>
</head>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<style type="text/css">
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
<input name="Opc" type="hidden" value="<? echo $Opc; ?>">
<input name="RechazaVis" type="hidden" value="<? echo $RechazaVis; ?>">
<table width="50%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1em.gif" width="15" height="15"></td>
	<td width="848" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2em.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
              
            <td width="87%" align="left">&nbsp;</td>
              <td width="13%" align="right">
			  <a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a>&nbsp;
			  <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a>  </td>
  </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
            <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" >
                <tr>
                  <td width="109" height="28" class="FilaAbeja2">Motivo Rechazo </td>
                  <td width="460" height="28" class="FilaAbeja2"><label>
                    <textarea name="TxtObsAutoriza" cols="100" rows="5"><? echo $TxtObsAutoriza;?></textarea>
                  </label></td>
                </tr>
              </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   <br></td>
   <td width="1" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="1" height="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="1" height="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
  </tr>
  </table>
</form>
</body>
</html>