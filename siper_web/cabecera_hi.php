<? 
include('conectar_ori.php');
include('funciones/siper_funciones.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
function BuscaUnidad()
{
	var f=document.FrmCabecera;
	
	f.action='cabecera_hi.php?TxtBuscaUnidad='+f.TxtBuscaUnidad.value;
	f.submit();
}
function Salir(Opt)
{
	var f=document.FrmCabecera;
	
	if(top.frames['Procesos'].document.Mantenedor.Salida.value==='C')
		top.location = "../principal/sistemas_usuario.php?CodSistema=29&Nivel=1&CodPantalla=6";
	else
		top.location = "../principal/sistemas_usuario.php?CodSistema=29&Nivel=0";

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
    <td colspan="2" align="center"><img src="imagenes/cab_hi.jpg" alt="" height="52" border="0"></td>
    </tr>
  <tr >
    <td background="imagenes/bg_sup.gif" class="BordeTop">&nbsp;<img src="imagenes/arbol.gif">&nbsp;Buscador de Unidades Operativas&nbsp;
      <input name='TxtBuscaUnidad' type='text' value='<? echo $TxtBuscaUnidad;?>' style='width:150' />
      <a href="javascript:BuscaUnidad()"><img src="imagenes/btn_aceptar.png" alt='Aceptar' width="18" height="18" border="0" align="absmiddle" /></a><span class="ColorTabla02">
      <SELECT name="CmbUnidades" onChange="top.frames['Organica'].BuscaItem()">
        <option value="S" SELECTed="SELECTed">Seleccionar</option>
        <?
		if($TxtBuscaUnidad!='')
		{
			ObtieneAccesoOrg2($CookieRut,&$AccesoOrg);
			if($AccesoOrg!='')
			{
				$Consulta="SELECT * from sgrs_areaorg where CTAREA='5' ".$AccesoOrg."";
				$Consulta.=" and upper(NAREA) like '%".strtoupper($TxtBuscaUnidad)."%'";
				$Consulta.=" order by NAREA";	
				$RespTarea=mysqli_query($link, $Consulta);
				while($FilaTarea=mysql_fetch_array($RespTarea))
				{
					if(strtoupper($FilaTarea[NAREA])==strtoupper($CmbUnidades))
						echo "<option value='".$FilaTarea[CPARENT].$FilaTarea[CAREA].",' SELECTed>".$FilaTarea[NAREA]."</option>";
					else
						echo "<option value='".$FilaTarea[CPARENT].$FilaTarea[CAREA].",'>".$FilaTarea[NAREA]."</option>";
				}
			}
		}
	  ?>
      </SELECT><? //echo $Consulta;?>
    </span><input name="PestanaActiva" type="hidden" value="1">
	<?
		OrigenOrg($CodSelTarea,&$Ruta,&$CodNiveles);
		//echo $Ruta."<br>";
	?>	</td>	
    <td background="imagenes/bg_sup.gif" class="BordeTop" align="right">
	<font style="FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #9c3031; FONT-FAMILY: Arial, Helvetica, sans-serif">
	<? 
	ObtieneUsuario($CookieRut,&$NombreUser);
	echo "Usuario: ".$NombreUser;?>	</font>
	<a href="Manual_Usuario_hi.pdf" target="_blank">
	</font><img src="imagenes/acrobat.png" alt='Manual de Usuario' width="25" height="25" border="0"></a><a href="javascript:Salir();"><img src="imagenes/btn_volver3.png" alt='Salir' width="25" height="25" border="0"></a>&nbsp;&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
