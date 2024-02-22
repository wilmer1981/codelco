<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
	
?>

<title>Observaciones Por Hito  </title>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opt)
{
	var f=document.FrmObs;
	switch (Opt)
	{
		case "OBS"://GRABA OBSERVACION
		var Datos='';
			for(i=2;i<f.elements.length;i++)
			{
				if(f.elements[i].name=='ChkDatos')
					Datos=Datos+f.elements[i].value+"~"+f.elements[i+1].value+"//";
			}
			Datos=Datos.substr(0,Datos.length-2);
			f.DatosEliminar.value=Datos;
			f.action = "sget_autoriza_nomina_integral01.php?Proceso=EHRuta";
			f.submit();
		break;
	}
}
</script><link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmObs" method="post" action="">
<input name="NumHoja" type="hidden" value="<? echo $NumHoja; ?>">
<textarea name="DatosEliminar" style="visibility:hidden;"></textarea>
<table width="85%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="910" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="90%" align="left"><img src="archivos/obs_anula_personas.png" width="400" height="40" /></td>
    <td width="10%" align="right"><a href="JavaScript:Proceso('OBS')"><img src="archivos/btn_activo.png" height="24" alt="Eliminar Personas y Envio Correo" width="24" border="0" align="absmiddle" /></a>&nbsp;<a href="JavaScript:Proceso('OBSDES')"></a>&nbsp;<a href="JavaScript:Proceso('S')"></a>	</td>
  </tr>
</table>
     	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" >
          <tr>
		  	  <td align="center" class="TituloTablaNaranja">Personal</td>
              <td align="center" class="TituloTablaNaranja">Cargo</td>
              <td align="center" class="TituloTablaNaranja">Observaci�n</td>
		  </tr>
          <?
		$Arreglo=explode('//',$PersonasE);
		while(list($c,$Per)=each($Arreglo))	
		{
			$Dato=explode('~',$Per);
			$NumHoja=$Dato[0];
			$RutPer=$Dato[1];
			$Consulta="SELECT t2.nombres,t2.ape_paterno,t2.ape_materno,t3.descrip_cargo,t2.rut";
			$Consulta.=" from sget_hoja_ruta_nomina_hitos_personas t1 inner join sget_personal t2 on t1.rut_personal=t2.rut ";
			$Consulta.=" left join sget_cargos t3 on t3.cod_cargo=t2.cargo";
			$Consulta.=" where t1.num_hoja_ruta ='".$NumHoja."' and t2.rut='".$RutPer."' and cod_hito='2' order by t2.ape_paterno";
			$RespDet=mysql_query($Consulta);
			$FilaDet=mysql_fetch_array($RespDet);	
			$Nombre=$FilaDet["rut"]." - ".$FilaDet[ape_paterno]." ".$FilaDet[ape_materno]." ".$FilaDet["nombres"];
		?>
          <tr>
		  	
            <td align='left' width="40%"><? echo $Nombre; ?><input class='SinBorde' type="hidden" name="ChkDatos" value="<? echo $NumHoja.'~'.$RutPer; ?>" checked="checked" /></td>
            <td align='left' width="35%"><? echo $FilaDet[descrip_cargo]; ?></td>
            <td align='center' width="25%"><textarea name="Obs" cols="50"><? echo $Obs; ?></textarea></td>
          </tr>
          <?
		}
		?>
        </table>
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
 
  
</form>