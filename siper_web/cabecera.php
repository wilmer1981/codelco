<?phpphp 
include('conectar_sasso.php');
include('funciones/siper_funciones.php');
$CookieRut   = isset($_COOKIE['CookieRut'])?$_COOKIE['CookieRut']:"";
$TxtBuscaTarea = isset($_REQUEST["TxtBuscaTarea"])?$_REQUEST["TxtBuscaTarea"]:"";
$CmbTareas     = isset($_REQUEST["CmbTareas"])?$_REQUEST["CmbTareas"]:"";
$CodSelTarea = isset($_REQUEST["CodSelTarea"])?$_REQUEST["CodSelTarea"]:"";
$CodNiveles  = isset($_REQUEST["CodNiveles"])?$_REQUEST["CodNiveles"]:"";

/*if (isset($_COOKIE['CookieRut']))
{ 
   echo "ENTRO";
   foreach ($_COOKIE['CookieRut'] as $name => $value) 
   { 
       echo "$name : $value <br />\n"; 
   } 
}
else
	echo "SIN COOKIE";*/

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
function BuscaTarea()
{
	var f=document.FrmCabecera;
	
	f.action='cabecera.php?TxtBuscaTarea='+f.TxtBuscaTarea.value;
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
    <td colspan="2" align="center"><img src="imagenes/cab1.jpg" alt="" height="52" border="0"></td>
    </tr>
  <tr >
    <td background="imagenes/bg_sup.gif" class="BordeTop">&nbsp;<img src="imagenes/arbol.gif">&nbsp;Buscador de Tareas&nbsp;
      <input name='TxtBuscaTarea' type='text' value='<?phpphp echo $TxtBuscaTarea;?>' style='width:150' />
      <a href="javascript:BuscaTarea()"><img src="imagenes/btn_aceptar.png" alt='Aceptar' width="18" height="18" border="0" align="absmiddle" /></a><span class="ColorTabla02">
      <select name="CmbTareas" onChange="top.frames['Organica'].BuscaItem()">
        <option value="S" selected="selected">Seleccionar</option>
        <?phpphp
		if($TxtBuscaTarea!='')
		{
			$AccesoOrg = ObtieneAccesoOrg2($CookieRut,$AccesoOrg,$link);
			if($AccesoOrg!='')
			{
				$Consulta="select * from sgrs_areaorg where CTAREA='8' ".$AccesoOrg."";
				$Consulta.=" and upper(NAREA) like '%".strtoupper($TxtBuscaTarea)."%'";
				$Consulta.=" order by NAREA";	
				$RespTarea=mysqli_query($link,$Consulta);
				while($FilaTarea=mysqli_fetch_array($RespTarea))
				{
					if(strtoupper($FilaTarea["NAREA"])==strtoupper($CmbTareas))
						echo "<option value='".$FilaTarea["CPARENT"].$FilaTarea["CAREA"].",' selected>".$FilaTarea["NAREA"]."</option>";
					else
						echo "<option value='".$FilaTarea["CPARENT"].$FilaTarea["CAREA"].",'>".$FilaTarea["NAREA"]."</option>";
				}
			}
		}
	  ?>
      </select><?php //echo $Consulta;?>
    </span><input name="PestanaActiva" type="hidden" value="1">
	<?phpphp
		$Ruta='';
		$Ruta = OrigenOrg($CodSelTarea,$Ruta,$CodNiveles);
		//echo $Ruta."<br>";
	?>	</td>	
    <td background="imagenes/bg_sup.gif" class="BordeTop" align="right">
	<font style="FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #9c3031; FONT-FAMILY: Arial, Helvetica, sans-serif">
	<?phpphp 
	$NombreUser="";
	$NombreUser = ObtieneUsuario($CookieRut,$NombreUser,$link);
	echo "Usuario: ".$NombreUser;?>	</font>
	<a href="Manual_Usuario_SASSO.pdf" target="_blank">
	</font><img src="imagenes/acrobat.png" alt='Manual de Usuario' width="25" height="25" border="0"></a><a href="javascript:Salir();"><img src="imagenes/btn_volver3.png" alt='Salir' width="25" height="25" border="0"></a>&nbsp;&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
