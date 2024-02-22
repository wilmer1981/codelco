<?
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");

	if (!isset($Ptl))
		$Ptl1='IC';	
	else
		$Ptl1=$Ptl;		
?>
<title>Información Contrato <? echo $Ctto;?></title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Recarga(Opt)
{
	var f=document.FrmInfoCtto;

	f.action="sget_info_ctto.php?Ptl="+Opt;
	f.submit();
}
function Salir()
{
	window.close();
}
</script>
<form name="FrmInfoCtto" action="" method="post">
<input type="hidden" name="Ctto" value="<? echo $Ctto;?>">
<input type="hidden" name="Ptl1" value="<? echo $Ptl1;?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="74%" align="left"><img src="archivos/sub_tit_info_ctto.png" /></td>
    <td align="right"><a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0" /></a> </td>
  </tr>
</table>
<table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
		<tr>
		<?
		if ($Ptl1=='IC') 
			$Fondo="archivos/tab_slide_hm_next2.png"; 
		else 
			$Fondo="archivos/tab_slide_hm2.png";
		?>
		<!--<td width="1%" height="25" ><img src="<? echo $Fondo;?>"  ></td>-->
		<td width="1%" align="center" class="TituloTablaVerde"></td>	
		<?
		if ($Ptl1=='IC') 
			$Fondo="archivos/barra_medium_activa2.png"; 
		else 
			$Fondo="archivos/barra_medium2.png";
		?>
		<td  align="center"  height="25" background="<? echo $Fondo;?>">
		<a href="JavaScript:Recarga('IC')"><?  
		if ($Ptl1=='IC') 
			echo "<span class='TituloTablaVerdeActiva'>"; 
		else 
			echo "<span class='TituloTablaVerde'>"; ?>
		Datos Contratos
		</span></a></td>  	
		<td width="1" ><img src="archivos/tab_separator.gif"></td>
		<?
		if ($Ptl1=='IM') 
			$Fondo="archivos/barra_medium_activa2.png"; 
		else 
			$Fondo="archivos/barra_medium2.png";
		?>
		<td  align="center" height="25" background="<? echo $Fondo;?>">
			<a href="JavaScript:Recarga('IM')">
			<?
			if ($Ptl1=='IM')  
				echo '<span class="TituloTablaVerdeActiva">';  
			else
				echo '<span class="TituloTablaVerde">';  
			 ?>Modificaciones Contrato</span></a></td>
		<td width="1" ><img src="archivos/tab_separator.gif"  ></td>
		<? 	 if ($Ptl=="IS") 
				$Fondo="archivos/barra_medium_activa2.png"; 
			else 
				$Fondo="archivos/barra_medium2.png";
		?>
		<td  align="center"  height="25" background="<? echo $Fondo;?>">
		<a href="JavaScript:Recarga('IS')">
		<?
		if ($Ptl=="IS")  
			echo '<span class="TituloTablaVerdeActiva">';  
		else 
			echo '<span class="TituloTablaVerde">'; ?>
			 SubContratistas Contrato</span></a>
		</td>
		<td width="3" ><img src="archivos/tab_separator.gif" ></td>
		<? 	 if ($Ptl=="IR") 
			$Fondo="archivos/barra_medium_activa2.png"; 
		else 
			$Fondo="archivos/barra_medium2.png";
		?>
		<td  align="center"  height="25" background="<? echo $Fondo;?>">
		<a href="JavaScript:Recarga('IR')">
		<?
		if ($Ptl=="IR")  
			echo '<span class="TituloTablaVerdeActiva">';  
		else 
			echo '<span class="TituloTablaVerde">'; 
		?>
		Reajustes Contratos</span></a></td>
		<td width="3" ><img src="archivos/tab_separator.gif" ></td>
		<? 	 if ($Ptl=="IRS") 
			$Fondo="archivos/barra_medium_activa2.png"; 
		else 
			$Fondo="archivos/barra_medium2.png";
		?>
		<td  align="center"  height="25" background="<? echo $Fondo;?>">
		<a href="JavaScript:Recarga('IRS')">
		<?
		if ($Ptl=="IRS")  
			echo '<span class="TituloTablaVerdeActiva">';  
		else 
			echo '<span class="TituloTablaVerde">'; 
		?>
		Reajustes Sueldos</span></a></td>

		</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="1%" align="center" class="TituloTablaVerde"></td>
        <td align="center"><?
		switch (trim($Ptl1))
		{
			case "IC"://INFORMACION CONTRATO
				include("sget_info_ctto_general.php");
				break;
			case "IM"://INFORMACION CONTRATO MODIFICACIONES
				include("sget_info_ctto_mod.php");
				break;
			case "IS"://INFORMACION CONTRATO SUBCONTRATISTAS RELACIONADAS
				include("sget_info_ctto_SubC.php");
				break;
			case "IR"://INFORMACION CONTRATO REAJUSTES
				include("sget_info_ctto_reajuste.php");
				break;
			case "IRS"://INFORMACION SUELDOS REAJUSTES
				include("sget_info_ctto_reajuste_sueldo.php");
				break;
		}
		?><br></td>
        <td width="0%" align="center" class="TituloTablaVerde"></td>
      </tr>
      <tr>
        <td colspan="3"align="center" class="TituloTablaVerde"></td>
      </tr>
    </table>
  <br />	
</form>