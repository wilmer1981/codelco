<?php
//pagina para mostrar el detalle de un usuario
$var=explode(";",$valor);
$cod=$var[0];
$tipo=$var[1];
$rut=$var[3];
include("../principal/conectar_principal.php");
//echo($rut);
//se recupera la informacion del usuario
if ($tipo=="PARTE" )
   {
//	$query="select * from bd_rrhh.antecedentes_personales where RUT= '".$rut."'";  
    $query="select cod_equipo from cia_web.asoc_partes_equipos where cod_parte= '".$cod."' and estado_asoc=1;";
	$result=mysql_query($query,$link);
	$resp=mysql_fetch_array($result);
	$cod=$resp["cod_equipo"];
	mysql_free_result($result);
//	echo($query);		
   }   

$query="select * from bd_rrhh.antecedentes_personales t1 , cia_web.asoc_equipos_usuarios t2 where cod_equipo= '".$cod."'";
$query = $query ." and t1.RUT= t2.rut_usuario and nro_asoc = (select max(nro_asoc) from cia_web.asoc_equipos_usuarios where cod_equipo= '".$cod."'";
$query = $query ."and t1.RUT= t2.rut_usuario)";
//echo ($query);
$result=mysql_query($query,$link);
$resp=mysql_fetch_array($result);
mysql_free_result($result);
//echo($query);

//if ($resp["RUT"] == "")
  //  {echo('no hay usuario');
	
//se recupera la informacion del centro de costo
//$var=substr($resp["COD_CENTRO_COSTO"],3,5);
//$var=explode(".",$var);
//$cc=$var[0].$var[1];
//echo($cc);
//$query="select descripcion from centro_costo where centro_costo='".$cc."';";
//$result=mysql_db_query("proyecto_modernizacion",$query,$link);
//$resp_tmp=mysql_fetch_array($result);
//mysql_free_result($result);
//$cc=$cc." - ".$resp_tmp["descripcion"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script type="text/javascript" src="funciones.js"></script>
<script language="JavaScript" type="text/javascript">
var popup=0;

function to_excel(valor)
{

	var URL,opciones;
	URL="ToExcel/ver_usuario_excel.php?valor=" + valor;
	opciones="toolbar=0,resizable=0,menubar=1,status=0";
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
	popup.moveTo(0,0);
}															
</script>
</head>

<body bgcolor="#CCCCCC" onUnload="verificar_popup(popup)">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table width="530" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="500" border="0" class="TablaInterior" align="center">
	<tr>
		<td class="ColorTabla01" align="center"><strong>DETALLE USUARIO</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table cellpadding="0" cellspacing="2" border="0" style="border:solid 2px #000000;" width="450" align="center">
		<tr>
			    <td style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC" align="center" colspan="2">Informaci&oacute;n 
                  Usuario </td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Rut</strong></td>
			      <td>&nbsp;&nbsp;&nbsp;<?php echo $resp["RUT"];?></td>
		</tr>
		<tr>
			    <td align="center" style="border:solid 1px #666666;" width="200"><strong>Nombres</strong></td>
			    <td>&nbsp;&nbsp;&nbsp;<?php echo $resp["NOMBRES"];?> </td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Apellido Paterno</strong></td>
			    <td>&nbsp;&nbsp;&nbsp;<?php echo $resp["APELLIDO_PATERNO"];?> </td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Apellido Materno</strong></td>
			    <td>&nbsp;&nbsp;&nbsp;<?php echo $resp["APELLIDO_MATERNO"];?> </td>
		</tr>
		<tr>
			<td align="center" style="border:solid 1px #666666;" width="200"><strong>Centro de Costo</strong></td>
			    <td>&nbsp;&nbsp;&nbsp;<?php echo $resp["cc_ubicacion"];?></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">
	<input type="button" name="ToExcel" value="Excel" style="width: 80px;" onClick="to_excel('<?php echo $valor?>')">&nbsp;&nbsp;&nbsp;
	<input type="button" name="Cerrar" value="Cerrar" onClick="javascript: window.close()" style="width: 80px;"></td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>
</form>
</body>
</html>
