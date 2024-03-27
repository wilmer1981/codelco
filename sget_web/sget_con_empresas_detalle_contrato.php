<?
	include("../principal/conectar_sget_web.php");
	$Consulta = "SELECT * from des_sget.sget_contratos t1  ";
	$Consulta.= " where t1.rut_empresa='".$IdEmpresa."' ";
	$Consulta.= " and t1.cod_contrato='".$IdContrato."' ";
	$Consulta.= " order by t1.cod_contrato";
	$Resp=mysqli_query($link, $Consulta); 
	if ($Fila=mysql_fetch_array($Resp))
	{
		$Contrato=$Fila["cod_contrato"];
		$Descripcion=$Fila["descrip_contrato"];
		$EncExterno=$Fila["nom_encargado_ext"];
		$EncInterno=$Fila["nom_encargado_int"];
		$FonoEncExterno=$Fila["fono_encargado_ext"];
		$FonoEncInterno=$Fila["fono_encargado_int"];
		$FechaInicio = substr($Fila["fecha_inicio"],8,2)."/".substr($Fila["fecha_inicio"],5,2)."/".substr($Fila["fecha_inicio"],0,4);
		$FechaTermino = substr($Fila["fecha_termino"],8,2)."/".substr($Fila["fecha_termino"],5,2)."/".substr($Fila["fecha_termino"],0,4);		
	}
	if(!isset($CmbEstado))
		$CmbEstado="A";
?>
<html>
<head>
<script language="JavaScript">
function Recarga()
{
	var f=document.frmDetalle;
	f.action="sget_con_empresas_detalle_contrato.php?Estado="+f.CmbEstado.value;
	f.submit();
}
</script>
<title>Detalle Contrato</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<form name="frmDetalle" method="post" action="">
<input type="hidden" name="IdEmpresa" value="<? echo $IdEmpresa;?>">
<input type="hidden" name="IdContrato" value="<? echo $IdContrato;?>">
<table width="500" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
  <tr bgcolor="#FF9900" class="Detalle02">
    <td height="25" colspan="6">Detalle Contrato </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="16" colspan="6">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="104"><strong>Contrato:</strong></td>
    <td colspan="5"><? echo $Contrato; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>Descripcion:</strong></td>
    <td colspan="5"><? echo $Descripcion ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>Encargado Externo:</strong></td>
    <td colspan="3"><? echo $EncExterno ?></td>
    <td width="28"><strong>Fono:</strong></td>
    <td width="72"><? echo $FonoEncExterno ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>Encargado Interno:</strong></td>
    <td colspan="3"><? echo $EncInterno ?></td>
    <td><strong>Fono:</strong></td>
    <td><? echo $FonoEncInterno ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>Fecha Inicio: </strong></td>
    <td width="110"><? echo $FechaInicio ?></td>
    <td width="89"><strong>Fecha Termino:</strong></td>
    <td width="100" colspan="3"><? echo $FechaTermino ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="104"><strong>Ver:</strong></td>
    <td colspan="5"><SELECT name="CmbEstado" onChange="Recarga()">
      <?
		switch($CmbEstado)
		{
			case "A":
				echo "<option value='A' SELECTed>ACTIVOS</option>";
				echo "<option value='I' >INACTIVOS</option>";
				echo "<option value='T' >TODOS</option>";
				break;
			case "I":
				echo "<option value='A'>ACTIVOS</option>";
				echo "<option value='I' SELECTed>INACTIVOS</option>";
				echo "<option value='T' >TODOS</option>";
				break;
			case "T":
				echo "<option value='A' >ACTIVOS</option>";
				echo "<option value='I' >INACTIVOS</option>";
				echo "<option value='T' SELECTed>TODOS</option>";
				break;
			default:
				echo "<option value='A' SELECTed>ACTIVOS</option>";
				echo "<option value='I' >INACTIVOS</option>";
				echo "<option value='T' >TODOS</option>";
				break;												 
		
		}
	?>
    </SELECT></td>
  </tr>  
  <tr align="center" bgcolor="#FFFFFF">
    <td colspan="6" class="Detalle02"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="window.print();">
    <input name="BtnCerrar" type="button" id="BtnCerrar" value="Cerrar" style="width:70px " onClick="window.close()"></td>
  </tr>
</table>
<br>
<table width="500" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaDetalle">
  <tr class="ColorTabla01" align="center">
    <td width="97">Rut</td>
    <td width="188">Nombre</td>
    <td width="156">Direccion</td>
    <td width="100">Nro. Tarjeta</td>
	<td width="100">Estado</td>
  </tr>
<?  
	include("../principal/conectar_sget_web.php");
	$Consulta="SELECT * from des_sget.sget_personal t1 ";
	$Consulta.= " where t1.rut_empresa='".$IdEmpresa."' ";
	if($CmbEstado!="T")
		$Consulta.= " and t1.estado='".$CmbEstado."'";
	$Consulta.= " and t1.cod_contrato='".$IdContrato."' ";
	$Consulta.= " order by t1.ape_paterno, t1.ape_materno, t1.nombres";
	//echo $Consulta;
	$Resp=mysqli_query($link, $Consulta); 
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Rut=substr($Fila["rut"],0,2).".".substr($Fila["rut"],2,3).".".substr($Fila["rut"],5,3)."-".substr($Fila["rut"],9,1);	
		echo "<tr bgcolor=\"#FFFFFF\">\n";
		echo "<td>".$Rut."</td>\n";
		echo "<td>".nl2br($Fila["ape_paterno"])." ".nl2br($Fila["ape_materno"])." ".nl2br($Fila["nombres"])."</td>\n";
		echo "<td>".nl2br($Fila["direccion"])."</td>\n";
		echo "<td align=\"center\">".$Fila["nro_tarjeta"]."</td>\n";
		echo "<td align=\"center\">".$Fila["estado"]."</td>\n";
		echo "</tr>\n";
	}
?>  
</table>
</form>
</body>
</html>
