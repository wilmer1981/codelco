<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
	
?>

<title>Observaciones Por Hito  </title>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">

function muestra(numero) 
{
 	var f=document.FrmObs;
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	
	{
		if (ie4)
		{
			eval(numero + ".style.visibility = 'visible'");
		
		}
	}
	//eval("f.Obs.value=f.ObsHito_"+ Hito +".value");
}
function oculta(numero) 
{

	var f=document.FrmObs;
f.Obs.value='';
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	
	{
		if (ie4)
		{
			eval(numero + ".style.visibility = 'hidden'");
		}
	}
}


function Proceso(Opt)
{
	var f=document.FrmObs;
	switch (Opt)
	{
		case "S":
			window.close();
		break;
		case "I":
			window.print()
		break;	
		case "GOBS"://GRABA OBSERVACION
			f.action = "sget_ingreso_obs01.php?Proceso=GOBS";
			f.submit();
		break;
	}
}
function Eliminar(fecha,numero)
{	
	var f=document.FrmObs;
	f.action = "sget_ingreso_obs01.php?Proceso=EOBS&FechaHrs="+fecha;
	f.submit();
}
function Modificar(fecha,numero)
{	
	var f=document.FrmObs;
	URL="sget_detalle_observacion.php?NumHoja="+numero+"&FechaHrs="+fecha+"&Hito="+f.CodHito.value+"&Form="+f.name+"&Mod=S";
	opciones='top=100,toolbar=0,resizable=0,menubar=0,status=0,width=400,height=300,scrollbars=0';
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.moveTo((screen.width - 640)/2,0);

}
</script><link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmObs" method="post" action="">
<input name="CodSistema" type="hidden" value="<? echo $CodSistema; ?>">
<input name="CodPantalla" type="hidden" value="<? echo $CodPantalla; ?>">
<input name="CodHito" type="hidden" value="<? echo $H; ?>">
<input name="NumHoja" type="hidden" value="<? echo $NumHoja; ?>">
<table width="76%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="910" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="74%" align="left"><img src="archivos/sub_tit_obs_hito.png" /></td>
    <td align="right"><?
	if($Mos != 'N')
	{
		?>
        <a href="JavaScript:muestra('Observacionxx')"><img src="archivos/btn_ingreso_obs.png"  border="0" alt="Agregar Observaci&oacute;n" align="absmiddle" /></a>&nbsp;
        <?
	}
	?>
        <a href="JavaScript:Proceso('I')"><img src="archivos/Impresora.png" width="25" height="25" border="0" alt="Imprimir" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Proceso('S')"><img src="archivos/cerrar1.png" width="25" height="25" border="0" alt="Cerrar" align="absmiddle" /></a></td>
  </tr>
</table>
     <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
       <tr>
         <td colspan="3"align="center" class="TituloTablaVerde"></td>
       </tr>
       <tr>
         <td width="1%" align="center" class="TituloTablaVerde"></td>
         <td align="center"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
           <tr>
             <td class="formulario2" >
                 <?
	
	$Consulta="SELECT descrip_hito from sget_hitos  where cod_hito='".$H."'";
	$Resp0=mysqli_query($link, $Consulta);
	$FilaResp=mysql_fetch_array($Resp0);
	echo 'Hito:'.'&nbsp;'.$FilaResp[descrip_hito];

	?>             </td>
           </tr>
           <tr>
             <td class="formulario2" >&nbsp;</td>
           </tr>
           <tr>
             <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
               <tr>
                 <td colspan="2" class="TituloCabecera" >Observaci&oacute;n</td>
                 <td width="20%" class="TituloCabecera" >Fecha</td>
               </tr>
               <?


	
		$Consulta="SELECT * from sget_hoja_ruta_hitos_observaciones ";
		$Consulta.="  where num_hoja_ruta='".$NumHoja."' and cod_hito='".$H."'";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			?>
               <tr>
                 <td width="7%">
				 <a href="JavaScript:Eliminar('<? echo $Fila["fecha_hora"] ?>','<? echo $NumHoja;?>')"><img src="archivos/elim_hito.png" width="20" height="20" alt="Eliminar Observaci�n" align="absmiddle" border="0"></a>&nbsp;<a href="JavaScript:Modificar('<? echo $Fi["fecha_hora"]a] ?>','<? echo $NumHoja;?>')"><img src="archivos/btn_modificar.png"  width="20" height="20" border="0" align="absmiddle" alt="Modificar Observaci�n" ></a>
				 
				 &nbsp;</td>
                 <td width="73%"><? echo $Fila["observacion"];?></td>
                 <td><? echo substr($Fila["fecha_hora"],0,10);?>&nbsp;</td>
               </tr>
               <?
		}
		?>
             </table>
</td>
           </tr>
         </table>
           </td>
         <td width="0%" align="center" class="TituloTablaVerde"></td>
       </tr>
       <tr>
         <td colspan="3"align="center" class="TituloTablaVerde"></td>
       </tr>
     </table>
     <br><br>
     <br>
	 <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
    <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15"></td>
	<td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15"></td>
  </tr>
  </table>
<br>
<div id='Observacionxx'  style='FILTER: alpha(opacity=100); overflow:auto; VISIBILITY: hidden; WIDTH: 380px; height:196px; POSITION: absolute; moz-opacity: .75; opacity: .75;  left: 270px; top: 48px;'>
	<table width="77%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="614" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>

	
		<table width="320" border="0" align="center" cellpadding="2" cellspacing="0" >
		
		<tr >
		  <td >
		  <span class="titulo_azul">
		  <img src="archivos/vineta.gif" border="0">Ingreso&nbsp;Observaci�n</span>
		  </td>
         <td  align="right" >
		  <a href="JavaScript:Proceso('GOBS')"><img src="archivos/btn_guardar.png" height="20" alt="Guardar" width="20" border="0" align="absmiddle" /></a> 
		  <a href="JavaScript:oculta('Observacionxx')"><img src="archivos/cerrar1.png" width="25" height="25" border="0" alt="Cerrar" align="absmiddle"></a> 
		  </td>
		</tr>   
     
		<tr>
		<td colspan="2" align='center' >
		 <textarea name="Obs" cols="80" rows="8" wrap="VIRTUAL" ><? echo $Obs; ?></textarea>
		</td>
		</tr>
		
	   </table>
	   </td>
	 <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
    <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15"></td>
	<td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15"></td>
  </tr>
  </table>
  </div> 
  
</form>