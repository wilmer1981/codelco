<?
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	
	
?>

<title>Autorizaci�n de Gesti�n de Terceros</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opt)
{
	var f=document.FrmAut;
	var Mi="";
	switch (Opt)
	{
		case "G":
		Datos=Recuperar5(f.name);
		if(Datos == "")
			alert("Debe Ingresar a lo menos 1 Tarjeta");
		else
		{
			if(f.TxtFecha.value=='')
				alert("Debe Ingresar Fecha");
			else
			{
				var Largo=Datos.length;
				Datos=Datos.substring(0,Largo-2);
				//alert(Datos);
				f.action='sget_autoriza_nomina_integral01.php?Proceso=GT&Valores='+Datos;
				f.submit();
			}
		}
		break;
		case "S":
			window.close();
			break;
		case "I":
		window.print()
		
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
<input name="CodSistema" type="hidden" value="<? echo $CodSistema; ?>">
<input name="CodPantalla" type="hidden" value="<? echo $CodPantalla; ?>">
<input name="CodHito" type="hidden" value="<? echo $H; ?>">
<input name="NumHoja" type="hidden" value="<? echo $NumHoja; ?>">
<input name="CmbEmpresa" type="hidden" value="<? echo $CmbEmpresa; ?>">
<input name="CmbContrato" type="hidden" value="<? echo $CmbContrato; ?>">
<input name="TxtHoja" type="hidden" value="<? echo $TxtHoja; ?>">
<input name="CmbAno" type="hidden" value="<? echo $CmbAno; ?>">
<input name="CmbEstado" type="hidden" value="<? echo $CmbEstado; ?>">
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
    <td align="right"> 
	<a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png"  border="0"  alt=" Modificar " align="absmiddle"></a>
  <a href="JavaScript:Proceso('I')"><img src="archivos/Impresora.png"   alt="Imprimir" border="0" align="absmiddle"  ></a>

  <a href="JavaScript:Proceso('S')"><img src="archivos/close.png" alt="Imprimir" border="0" align="absmiddle" ></a></td>
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
        <td width="38%" align='center' class="TituloTablaNaranja" >Nombre</td>
        <td width="32%" align='center' class="TituloTablaNaranja" >Cargo</td>
        <td width="50%" align='center' class="TituloTablaNaranja" ><?
		  	$Consulta = "SELECT * from sget_hitos ";
			$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='".$CodPantalla."'   and gest_tercero_final='S' ";
			$RespH = mysql_query($Consulta);
			$LargoArreglo = 0;
			while ($FilaH=mysql_fetch_array($RespH))
			{
				echo $FilaH[abrev_hito]; 
				$ArregloLeyes[$LargoArreglo][0] = $FilaH[cod_hito];
				$ArregloLeyes[$LargoArreglo][1] = $FilaH[abrev_hito];
				$LargoArreglo++;
				$Consulta="SELECT distinct(fecha) ";
				$Consulta.=" from sget_hoja_ruta_nomina_hitos_personas  ";
				$Consulta.=" where num_hoja_ruta ='".$NumHoja."' and cod_hito='".$FilaH[cod_hito]."' ";
				$Resp1=mysql_query($Consulta);
				$Fila1=mysql_fetch_array($Resp1);
					$TxtFecha=$Fila1["fecha"];
			}
			?>
            <br />
            <input name="TxtFecha" type="text" readonly="readonly"   size="10" value="<? echo $TxtFecha; ?>" />
          &nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false" />&nbsp;</td>
      </tr>
      <?
$Consulta="SELECT t2.nombres,t2.ape_paterno,t2.ape_materno,t3.descrip_cargo,t2.rut,t1.num_hoja_ruta,t2.nro_tarjeta ";
$Consulta.=" from sget_hoja_ruta_nomina_hitos_personas t1 inner join sget_personal t2 on t1.rut_personal=t2.rut ";
$Consulta.=" left join sget_cargos t3 on t3.cod_cargo=t2.cargo";
$Consulta.=" where t1.num_hoja_ruta ='".$NumHoja."' and cod_hito='4' and aprob_rechazo='A' ";
/*echo "<input name='TxtNumTarjeta' type='hidden'  value=''><input name='ChkDatos' type='hidden'  value=''>";
*/$RespDet=mysql_query($Consulta);
while($FilaDet=mysql_fetch_array($RespDet))
{
?>
      <tr>
        <td align='left' class='BordeBajo'><? echo FormatearNombre($FilaDet["nombres"]).' '.FormatearNombre($FilaDet[ape_paterno]).' '.FormatearNombre($FilaDet[ape_materno]);   ?> &nbsp;</td>
        <td align='left' class="BordeBajo" ><? echo $FilaDet[descrip_cargo]; ?>&nbsp;</td>
        <td align='center' class="BordeBajo" ><?
		  	for ($i = 0; $i < $LargoArreglo; $i++)
			{
				$Consulta="SELECT * ";
				$Consulta.=" from sget_hoja_ruta_nomina_hitos_personas  ";
				$Consulta.=" where num_hoja_ruta ='".$FilaDet[num_hoja_ruta]."' and cod_hito='".$ArregloLeyes[$i][0]."'  and rut_personal='".$FilaDet["rut"]."' ";
				$RespDet2=mysql_query($Consulta);
				if($FilaDet2=mysql_fetch_array($RespDet2))
				{
					?>
            <input name="TxtNumTarjeta" type="text"    size="10" value="<? echo $FilaDet2[num_tarjeta]; ?>" />
            <input  type="hidden" name="DatosO" value="<? echo $FilaDet[num_hoja_ruta].'~'.$FilaDet["rut"].'~'.$ArregloLeyes[$i][0]; ?>">
            <?
				}
				else
				{
					?>
            <input name="TxtNumTarjeta" type="text"    size="10" value="<? echo $FilaDet[nro_tarjeta]; ?>" />
            <input  type="hidden" name="DatosO" value="<? echo $FilaDet[num_hoja_ruta].'~'.$FilaDet["rut"].'~'.$ArregloLeyes[$i][0]; ?>">
            <?
				}
			}
			?>
        </td>
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
<br></td>
   <td  background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td  height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td  height="15"><img src="archivos/images/interior/esq4.gif" ></td>
  </tr>
  </table>	
</form>
