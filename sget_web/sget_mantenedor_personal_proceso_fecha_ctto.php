<?
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$Dia = date("d");
	$Mes = date("m");
	$Ano = date("Y");
	$FechaHoy = $Ano."-".$Mes."-".$Dia;

?>
<title>Modificaci�n Masiva de Fecha Fin de Contrato</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opt)
{
	var f=document.FrmAut;
	switch (Opt)
	{
		case "G":
			if(f.TxtFecFinCtto.value=='')
			{
				alert('Debe Seleccionar Fecha Fin Contrato');
				return;
			}
			
			if (f.TxtFecFinCtto.value < f.FechaHoy.value)
			{
				alert('Fecha Modificaci�n Fecha T�rmino Contrato, No Puede Ser Menor a Fecha De Hoy');
				return;
			}	
			if(confirm('Esta Seguro de Actualizar Fecha Fin de Contrato Para Estas Personas'))
			{
		//	alert ("hola")
				f.action='sget_mantenedor_personal_proceso01.php?Proc=MF';//MODIFICAR FECHA FIN DE CONTRATO MASIVO
				f.submit();
			}
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
<input name="FechaHoy" type="hidden" value="<? echo $FechaHoy; ?>">

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
            <td width="74%" align="left"><img src="archivos/sub_tit_mod_fec_ctto.png" /></td>
            <td align="right"><a href="JavaScript:Proceso('G')">(Versi&oacute;n 
              1) <img src="archivos/btn_guardar.png"  border="0"  alt=" Modificar " align="absmiddle"></a><a href="JavaScript:Proceso('S')"><img src="archivos/close.png" alt="Imprimir" border="0" align="absmiddle" ></a></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="3"align="center" class="TituloTablaVerde"></td>
  </tr>
  <tr>  
    <td width="1%" align="center" class="TituloTablaVerde"></td>
    <td align="left"><table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" >
      <tr>
                  <td colspan="5" align='left' class="formulario2" >&nbsp;&nbsp;Fecha 
                    T�rmino Contrato 
                    <input name="TxtFecFinCtto" type="text" class="InputCen" id="TxtFecFinCtto" value="<? echo $TxtFecFinCtto; ?>" size="15" maxlength="10" readonly="readonly" /> 

          <span class="InputRojo">(*)</span> <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha"  border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFecFinCtto,TxtFecFinCtto,popCal);return false" />&nbsp;</td>

		</tr>
      <tr>
        <td width="35%" align='center' class="TituloTablaNaranja" >Personal Externo</td>
		<td width="15%" align='center' class="TituloTablaNaranja" >Contrato</td>
        <td width="25%" align='center' class="TituloTablaNaranja" >Fecha Inicio Ctto.</td>
		<td width="25%" align='center' class="TituloTablaNaranja" >Fecha T�rmino Ctto.</td>
		<td width="8%" align='center' class="TituloTablaNaranja" >Estado.</td>
      </tr>
<?
	$Str='';
	$Datos=explode('~~',$Valores);
	foreach($Datos as $c => $v)
	{
		$Str=$Str."'".$v."',";
	
	}
	if($Str!='')
	{
		$Str=substr($Str,0,strlen($Str)-1);
		$Str="in (".$Str.")";
		$Consulta="SELECT nombres,ape_paterno,ape_materno,fec_ini_ctto,fec_fin_ctto,cod_contrato,estado from sget_personal where rut ".$Str." order by ape_paterno,ape_materno";
		$Resp=mysql_query($Consulta);
		//echo $Consulta;
		while($FilaDet=mysql_fetch_array($Resp))
		{
		?>
		  <tr>
			 <td align='left' class='BordeBajo'><? echo FormatearNombre($FilaDet[ape_paterno]).' '.FormatearNombre($FilaDet[ape_materno]).' '.FormatearNombre($FilaDet["nombres"]);   ?> &nbsp;</td>
			 <td align='center' class="BordeBajo"><? echo $FilaDet["cod_contrato"]; ?></td>
			 <td align='center' class="BordeBajo"><? echo $FilaDet[fec_ini_ctto]; ?></td>
			 <td align='center' class="BordeBajo"><? echo $FilaDet[fec_fin_ctto]; ?></td>
			  <td align='center' class="BordeBajo"><? echo $FilaDet["estado"]; ?></td>
		  </tr>
		<?
		}
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
	}	
	echo "</script>";
?>