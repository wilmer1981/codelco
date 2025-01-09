<?php 
include('conectar_consulta.php');
include('funciones/siper_funciones.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
function BuscaTarea()
{
	var f=document.FrmCabecera;
	
	f.action='cabecera_consulta.php?TxtBuscaTarea='+f.TxtBuscaTarea.value;
	f.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
 <link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<body>
<form name="FrmCabecera">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center"><img src="imagenes/cab1.jpg" alt="" height="52" border="0"></td>
    </tr>
  <tr >
    <td background="imagenes/bg_sup.gif" class="BordeTop">&nbsp;<img src="imagenes/arbol.gif">&nbsp;Buscador de Tareas&nbsp;
      <input name='TxtBuscaTarea' type='text' value='<?php echo $TxtBuscaTarea;?>' style='width:150' />
      <a href="javascript:BuscaTarea()"><img src="imagenes/btn_aceptar.png" alt='Aceptar' width="18" height="18" border="0" align="absmiddle" /></a><span class="ColorTabla02">
      <select name="CmbTareas" onChange="top.frames['Organica'].BuscaItem()">
        <option value="S" selected="selected">Seleccionar</option>
        <?php
		if($TxtBuscaTarea!='')
		{
			//ObtieneAccesoOrg2($CookieRut,&$AccesoOrg);
			//if($AccesoOrg!='')
			//{
				//$Consulta="select * from sgrs_areaorg where CTAREA='8' ".$AccesoOrg."";
				$Consulta="select * from sgrs_areaorg where CTAREA='8' ";
				$Consulta.=" and upper(NAREA) like '%".strtoupper($TxtBuscaTarea)."%'";
				$Consulta.=" order by NAREA";	
				$RespTarea=mysqli_query($link,$Consulta);
				while($FilaTarea=mysqli_fetch_array($RespTarea))
				{
					if(strtoupper($FilaTarea[NAREA])==strtoupper($CmbTareas))
						echo "<option value='".$FilaTarea[CPARENT].$FilaTarea[CAREA].",' selected>".$FilaTarea[NAREA]."</option>";
					else
						echo "<option value='".$FilaTarea[CPARENT].$FilaTarea[CAREA].",'>".$FilaTarea[NAREA]."</option>";
				}
			//}
		}
	  ?>
      </select><?php //echo "A:".$AccesoOrg."<br>C:".$Consulta;?>
    </span><input name="PestanaActiva" type="hidden" value="1">
	<?php
		OrigenOrg($CodSelTarea,&$Ruta,&$CodNiveles);
		//echo $Ruta."<br>";
		$IP_SERV = $HTTP_HOST;
	?>	</td>	
    <td background="imagenes/bg_sup.gif" class="BordeTop" align="right"><img src="../principal/imagenes/bola_cobre.gif"><a href="http://<?php echo $IP_SERV; ?>/proyecto/" style="text-decoration:none; color:#666666; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;" target="_blank">Sistemas Ventanas</a></td>
  </tr>
</table>
</form>
</body>
</html>
