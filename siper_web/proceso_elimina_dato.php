<?
if($Dato=='EIP')//CUANDO ES IDENTIFICACION DE PELIGRO
{
	$D1=$DatosPel;
	$D2=$CodPel;
}
if($Dato=='EAP')//CUANDO ES ASIGNACION DE PELIGRO
{
	$D1=$CodPel;
	$D2='';
}
?>
<script language="javascript">
function Eliminar(Opc,Parent,D1,D2)
{
	var f=document.FrmObs;
	if(f.ObsEli.value=='')
	{
		alert('Debe Ingresar Observación de Eliminación');
		f.ObsEli.focus();
		return;
	}
	if(f.Dato.value=='EMO')//ELIMINA ORGANICA EN PROCESO.PHP
	{
		f.action='procesos.php?Proceso='+Opc+'&Parent='+Parent;
		f.submit();
	}
	if(f.Dato.value=='EAO')//ELIMINA ACCESO ORGANICA
	{		
		f.action='acceso_organica01.php?Proceso=E&DatosRut='+Parent;
		//alert(f.action);
		f.submit();
	}
	if(f.Dato.value=='EMP')//ELIMINA MANTENEDOR PELIGRO 
	{		
		f.action='mantenedor_peligros01.php?Proceso=EP&CodConta='+Parent;
		//alert(f.action);
		f.submit();
	}
	if(f.Dato.value=='EMC')//ELIMINA MANTENEDOR PELIGRO 
	{		
		f.action='mantenedor_controles01.php?Proceso=EC&CodConta='+Parent;
		//alert(f.action);
		f.submit();
	}
	if(f.Dato.value=='ETV')//ELIMINA TIPO VERIFICADOR
	{		
		f.action='mantenedor_tipo_verificador01.php?Proceso=E&DatosUni='+Parent;
		//alert(f.action);
		f.submit();
	}
	if(f.Dato.value=='EIP')//ELIMINA IDENTIFICACION PELIGRO
	{		
		f.action='procesos.php?Proceso=EP&Parent='+Parent+'&DatosPel='+D1+'&CodPel='+D2;
		//alert(f.action);
		f.submit();
	}
	if(f.Dato.value=='EAP')//ELIMINA ASIGNACION PELIGRO
	{		
		f.action='procesos.php?Proceso=EC&Parent='+Parent+'&CodPel='+D1;
		//alert(f.action);
		f.submit();
	}
	//window.close();
}
</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<form name="FrmObs" method="post" action="">
<input name="Dato" type="hidden" value="<? echo $Dato;?>">
  <table width="448" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="3" align="right"><a href="javascript:Eliminar('<? echo $Proceso;?>','<? echo $Parent;?>','<? echo $D1;?>','<? echo $D2;?>')"><img src="imagenes/btn_guardar.png" alt='Grabar Item' border="0" align="absmiddle"></a></td>
    </tr>
 </table>
  <table width="425" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
	<td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
	<td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
    <td align="center">
		<table width="96%" border="0" cellpadding="0"  cellspacing="0">
		<tr>
		  <td colspan="3" class="TituloCabecera">Ingrese Observaci&oacute;n de Eliminaci&oacute;n </td>
		</tr>
		<tr>
		  <td colspan="3"><label>
			<textarea name="ObsEli" rows="10" cols="100"></textarea></label></td>
		</tr>
	  </table>
 	</td>
   <td width="1%" background="imagenes/interior2/form_der.gif"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="imagenes/interior2/esq3.gif" width="15" height="15"></td>
    <td height="15" background="imagenes/interior2/form_abajo.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
    <td width="1%" height="15"><img src="imagenes/interior2/esq4.gif" width="15" height="15"></td>
  </tr>
	
</tr>
</table>	
</form>