<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

	if (!isset($Ptl))
		$Ptl1='ES';	
	else
		$Ptl1=$Ptl;	
	$Consulta="select * from pcip_eec_sistemas t1 ";
	$Consulta.=" where t1.cod_sistema='".$Cod."' ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$NomSistema=$Fila["nom_sistema"];
	}
			
?>
<title>Información Sistema <? echo $Ctto;?></title>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="javascript">
function Recarga(Opt)
{
	var f=document.FrmInfoCtto;

	f.action="pcip_info_relacion_sistema.php?Ptl="+Opt;
	f.submit();
}
function Salir()
{
	window.close();
}
</script>
<form name="FrmInfoCtto" action="" method="post">
<input type="hidden" name="Cod" value="<? echo $Cod;?>">
<input type="hidden" name="Ptl1" value="<? echo $Ptl1;?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="74%" align="left"><img src="archivos/sub_tit_info_sistemas.png" /></td><br>
    <td align="right"><a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0" /></a> </td>
  </tr>
</table>
<table width="100%"  border="0" align="center" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
		<tr>
		<?
		if ($Ptl1=='ES') 
			$Fondo="archivos/tab_slide_hm_next2.png"; 
		else 
			$Fondo="archivos/tab_slide_hm2.png";
		?>
		<!--<td width="1%" height="25" ><img src="<? echo $Fondo;?>"  ></td>-->
		<td width="1%" align="center" class="TituloTablaVerde"></td>	
		<?
		if ($Ptl1=='ES') 
			$Fondo="archivos/barra_medium_activa2.png"; 
		else 
			$Fondo="archivos/barra_medium2.png";
		?>
		<td width="33%"  height="25"  align="center" background="<? echo $Fondo;?>">
		<a href="JavaScript:Recarga('ES');"><?  
		if ($Ptl1=='ES') 
			echo "<span class='TituloTablaVerdeActiva'>"; 
		else 
			echo "<span class='TituloTablaVerde'>"; ?>
		   Información Equipos Por Sistema
		</span></a></td>  	
		<td width="0%" ><img src="archivos/tab_separator.gif"></td>
		<?
		if ($Ptl1=='CS') 
			$Fondo="archivos/barra_medium_activa2.png"; 
		else 
			$Fondo="archivos/barra_medium2.png";
		?>
		<td width="33%" height="25"  align="center" background="<? echo $Fondo;?>">
			<a href="JavaScript:Recarga('CS');">
			<?
			if ($Ptl1=='CS')  
				echo '<span class="TituloTablaVerdeActiva">';  
			else
				echo '<span class="TituloTablaVerde">';?>
			 Información Centro Costo por Sistema
			 </span></a></td>
		<td width="0%" ><img src="archivos/tab_separator.gif"  ></td>
		<? 	 if ($Ptl=="IS") 
				$Fondo="archivos/barra_medium_activa2.png"; 
			else 
				$Fondo="archivos/barra_medium2.png";
		?>
		<td width="33%"  height="25"  align="center" background="<? echo $Fondo;?>">
		<a href="JavaScript:Recarga('IS');">
		<?
		if ($Ptl=="IS")  
			echo '<span class="TituloTablaVerdeActiva">';  
		else 
			echo '<span class="TituloTablaVerde">'; ?>
			Información Indicadores por Sistema
			</span></a></td>
  </table>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="1%" align="center" class="TituloTablaVerde"></td>
        <td align="left" class="formulario2">&nbsp;&nbsp;Sistema:&nbsp;&nbsp;<? echo $NomSistema;?></td>
		<td width="0%" align="center" class="TituloTablaVerde"></td>
      </tr>
      <tr>
        <td width="1%" align="center" class="TituloTablaVerde"></td>
        <td align="center"><?
		switch (trim($Ptl1))
		{
			case "ES"://INFORMACION EQUIPOS POR SISTEMA
				include("pcip_info_equipo_sistema.php");
				break;
			case "CS"://INFORMACION CENTRO COSTOS POR SISTEMAS
				include("pcip_info_costos_sistema.php");
				break;
			case "IS"://INFORMACION INDICADORES POR SISTEMA
				include("pcip_info_indicadores_sistema.php");
				break;
		}
		?></td>
		<td width="0%" align="center" class="TituloTablaVerde"></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="TituloTablaVerde"></td>
      </tr>
  </table>
</form>