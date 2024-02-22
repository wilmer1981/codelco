<?
//include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
	
?>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opc,CodVisita)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=1";
		break;
	}	
}
function VerMsj(Msj)
{
	if (Msj=='E')
		alert('Registro eliminado exitosamente');
	if(Msj=='ReIng')	
		alert('Visita ReIngresada para validacion');
}

</script>
<title>Mantenedor de Visitas Aviso</title>

<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">

<style type="text/css">
.TablaPrincipal tr td table tr td table tr .FilaAbeja2 p {
	font-family: Verdana, Geneva, sans-serif;
}
.TablaPrincipal tr td table tr td table tr .FilaAbeja2 {
	font-family: Verdana, Geneva, sans-serif;
}
.TablaPrincipal tr td table tr td {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 14px;
}
.FilaAbeja2 font {
	font-weight: normal;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
}
</style>

<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPrincipal" method="post" action="" >
  <table width="1020"  border="1" align="center"  cellpadding="0"  cellspacing="0" >
  <tr>
  <td> 
  <table width="1020"  border="0" align="center"  cellpadding="0"  cellspacing="0" >
    <tr>
            <td class="FilaAbeja2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
      <td height="15" class="FilaAbeja2">
      <font color="brown" face="Verdana, Geneva, sans-serif">
      <br>
            <br>
                  <br>
        Estimados(as):<br>
        Se informa a usted que este sistema se encuentra  deshabilitado.<br> 
        <br>
        Los pases de visitas deben ser generados  por el sistema de acreditaci&oacute;n y credencializaci&oacute;n corporativo, administrado por la<br>
         empresa Workmate, en el  link <a href="https://acred.codelco.rmworkmate.com/">https://acred.codelco.rmworkmate.com/</a><br>
         <br>
          Si tiene duda comunicarse con:<br> <br>
          Yuly Cisternas Abarz&uacute;a <br>
          Analista de Gesti&oacute;n <br>
          Gesti&oacute;n  y Fiscalizaci&oacute;n de Terceros<br>
          Gerencia  de Administraci&oacute;n<br>
  <a href="mailto:ycistern@codelco.cl">ycistern@codelco.cl</a><br> 
       <br>
       </font>
      </td>
      <td width="10%" align="right" valign="top" class="FilaAbeja2" >&nbsp;&nbsp;
			<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver "></a>
      </td>
    </tr>
  </table>
 </td>
 </tr>
 </table>
 
</form>