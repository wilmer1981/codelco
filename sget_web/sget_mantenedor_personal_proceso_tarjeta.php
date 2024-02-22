<?
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
?>
<title>Actualizacion Credencial</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opt)
{
	var f=document.FrmAut;
	switch (Opt)
	{
		case "G":
			f.action='sget_mantenedor_personal_proceso01.php?Proc=MT';//modificar solo tarjeta
			f.submit();
		break;
		case "S":
			window.close();
			break;
	}
}
</script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
.Estilo2 {color: #000000}
-->
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmAut" action="" method="post">
<input name="Valores" type="hidden" value="<? echo $Valores; ?>">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="948" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="74%" align="left"><img src="archivos/sub_tit_visar_cred_ctta.png" /></td>
    <td align="right"><a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png"  border="0"  alt=" Modificar " align="absmiddle"></a><a href="JavaScript:Proceso('S')"><img src="archivos/close.png" alt="Imprimir" border="0" align="absmiddle" ></a></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="3"align="center" class="TituloTablaVerde"></td>
  </tr>
  <tr>
    <td width="1%" align="center" class="TituloTablaVerde"></td>
    <td align="center"><table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" >
      <tr>
        <td width="50%" align='center' class="TituloTablaNaranja" >Nombre</td>
        <td width="50%" align='center' class="TituloTablaNaranja" >N&ordm; Tarjeta </td>
      </tr>
<?
	$Consulta="SELECT nombres,ape_paterno,ape_materno,nro_tarjeta from sget_personal where rut='".$Valores."'";
	$Resp=mysql_query($Consulta);
	//echo $Consulta;
	if($FilaDet=mysql_fetch_array($Resp))
	{
?>
      <tr>
        <td align='left' class='BordeBajo'><? echo FormatearNombre($FilaDet["nombres"]).' '.FormatearNombre($FilaDet[ape_paterno]).' '.FormatearNombre($FilaDet[ape_materno]);   ?> &nbsp;</td>
         <td align='center' class="BordeBajo"><input name="TxtTarj" type="text"    size="10" value="<? echo $FilaDet[nro_tarjeta]; ?>"></td>
      </tr>
<?
}
?>
    </table></td>
    <td width="0%" align="center" class="TituloTablaVerde"></td>
  </tr>
  <tr>
    <td colspan="3"align="center" class="TituloTablaVerde"></td>
  </tr>
</table>
</td>
   <td  background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td  height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td  height="15"><img src="archivos/images/interior/esq4.gif" ></td>
  </tr>
  </table>	
</form>
<?
	echo "<script languaje='JavaScript'>";
	if ($Mensaje!='')
	{
		echo "alert('".$Mensaje."');";
		echo "document.FrmAut.TxtTarj.focus();";
	}	
	echo "</script>";
?>