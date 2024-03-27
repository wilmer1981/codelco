<?
	include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
	if($Mod =='S')
	{
		$Consulta="SELECT * from sget_hoja_ruta_hitos_observaciones ";
		$Consulta.="  where num_hoja_ruta='".$NumHoja."' and fecha_hora='".$FechaHrs."'";
		$RespMO=mysqli_query($link, $Consulta);
		if($FilaMO=mysql_fetch_array($RespMO))
		{
			$Obs=$FilaMO["observacion"];
		
		}
	}
?>

<title>Modificar Observacion</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opt)
{
	var f=document.FrmDeObs;
	var Mi="";
	switch (Opt)
	{
		case "S":
			window.close();
			break;
		case "MOBS"://GRABA OBSERVACION
			f.action = "sget_ingreso_obs01.php?Proceso=MOBS&FechaHrs="+f.FechaHrs.value+"&Form="+f.Form.value+"&CodHito="+f.CodHito.value
			f.submit();
		break;	
	}
}
</script>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
.Estilo2 {color: #000000}
-->
</style>
<form name="FrmDeObs" action="" method="post">
<input name="FechaHrs" type="hidden" value="<? echo $FechaHrs;?>">
<input name="Form" type="hidden" value="<? echo $Form;?>">
<input name="NumHoja" type="hidden" value="<? echo $NumHoja;?>">
<input name="CodHito" type="hidden" value="<? echo $Hito;?>">
<table width="30%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
<table width="91%" height="152" border="0" align="center" cellpadding="2" cellspacing="0" >
		<tr >
		  <td width="158" >
		  <span class="titulo_azul">
		  <img src="archivos/vineta.gif" border="0">Modificar&nbsp;Observaci�n</span>		  </td>
          <td width="141"  align="right" >
		  <a href="JavaScript:Proceso('MOBS')"><img src="archivos/btn_guardar.png"  alt="Guardar" border="0" align="absmiddle" /></a> 
		  <a href="JavaScript:Proceso('S')"><img src="archivos/close.png" border="0" alt="Cerrar" align="absmiddle"></a>		  </td>
		</tr>   
		<tr>
		<td colspan="2" align='center'>
		 <textarea name="Obs" cols="75" rows="15" wrap="VIRTUAL" ><? echo $Obs; ?></textarea>		</td>
		</tr>
	    </table>
  </td>
  <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
</form>
