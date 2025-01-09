<?php
	include('conectar_ori.php');
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<script language="javascript">
function BuscaControles()
{
	var Pestana=top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value;
	
	top.frames['Procesos'].location='procesos_organica.php?TipoPestana='+Pestana+'&CmbPeligros='+top.frames['Procesos'].document.Mantenedor.CmbPeligros.value+'&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value;

}
function GrabarControles()
{
	var f=document.ObsVerificador;		
	
	f.action='div_obs_controles01.php';
	f.submit();				
}
function CerrarDiv()
{
	var f=document.ObsVerificador;	
	window.opener.document.Mantenedor.action='procesos_organica.php?CodSelTarea='+f.CodSelTarea.value+'&TipoPestana=3';
	window.opener.document.Mantenedor.submit();
	window.close();
}

</script>
<body>
<form name="ObsVerificador">
  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>  
  <input type="hidden" name="CodPelGu" value="<?php echo $CodPelGu;?>" />
  <input type="hidden" name="Area" value="<?php echo $AREA;?>" />
  <input type="hidden" name="Peligro" value="<?php echo $CodPel;?>" />
  <input type="hidden" name="CODCONTROL" value="<?php echo $CODCONTROL;?>" />
  <input type="hidden" name="CodSelTarea" value="<?php echo $CodSelTarea;?>" />
  <input type="hidden" name="CodCCONTACTO" value="<?php echo $CodCCONTACTO;?>" />
  <input type="hidden" name="OPC" value="<?php echo $Opc;?>" />  
	  <table width="50%" height="90%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td height="1%"><img src="imagenes/interior2/esq1.gif" width="15" height="15"></td>
		<td width="98%" height="15" background="imagenes/interior2/form_arriba.gif"><img src="imagenes/interior2/transparent.gif" width="4" height="15"></td>
		<td height="1%"><img src="imagenes/interior2/esq2.gif" width="15" height="15"></td>
	  </tr>
		<tr>
	   <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
		  <td  align="right" class="TablaPricipalColor">
		  <a href="javascript:GrabarControles()"><img src="imagenes/btn_guardar.png" alt='Grabar Item' border="0" align="absmiddle"></a>
		  <a href="JavaScript:CerrarDiv()"><img src="imagenes/cerrar1.png" width="25" height="25" border="0" alt="Cerrar" align="absmiddle"></a>
		  </td>    	
	   <td width="1%" background="imagenes/interior2/form_der.gif"></td>
		</tr>
	  <tr>
	   <td width="1%" background="imagenes/interior2/form_izq.gif"></td>
		<td align="center" class="TablaPricipalColor">
			<table width="100%" border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
			<tr>
			  <td class="TituloCabecera" align="center">Ingrese Especificacion del Control</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td><label>
			  <?php
			  	if($Opc=='GO')
				{
			  ?>
				<textarea name="ObsVeri" rows="10" cols="40"></textarea></label>
			  <?php
			  	}
				else
				{
					 $ConsultaE2="select * from sgrs_sipercontroles_obs where CIDCONTROL='".$CIDCONTROL."' and CCONTROL='".$CODCONTROL."' and CPELIGRO='".$CodPel."' and CAREA='".$AREA."'";
					 //echo $ConsultaE2."<br>";
					 $RespE2=mysqli_query($link,$ConsultaE2);
					 if($FilaE2=mysqli_fetch_array($RespE2))
					 {
					 	echo "<input type='hidden' name='CIDCORR' value='".$CIDCONTROL."'>";
					 	echo "<textarea name='ObsVeri' rows='10' cols='40'>".$FilaE2[TOBSERVACION]."</textarea></label>";					 				  		 	
					 }	
			  	}
			  ?>	
				</td>
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
  </td>
  <td height="138"></tr>
  </table>
 </form>		
 </body>
</html>			