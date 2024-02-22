<?php 
if(isset($_GET["TipoProd"])){
	$TipoProd = $_GET["TipoProd"];
}else {
	$TipoProd = "";
}
if(isset($_GET["RutProv"])){
	$RutProv = $_GET["RutProv"];
}else {
	$RutProv = "";
}


ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename = "";
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
$filename = urlencode($filename);
}
$filename = iconv('UTF-8', 'gb2312', $filename);
$file_name = str_replace(".php", "", $file_name);

header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
header("content-disposition: attachment;filename={$file_name}");
header( "Cache-Control: public" );
header( "Pragma: public" );
header( "Content-type: text/csv" ) ;
header( "Content-Dis; filename={$file_name}" ) ;
header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_principal.php");
	$sql = "SELECT t1.cod_leyes, t1.nombre_leyes, t2.abreviatura as unidad ";
	$sql.= " from leyes t1, unidades t2 ";
	$sql.= " where t1.cod_unidad = t2.cod_unidad";
	$sql.= " order by t1.cod_leyes";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		$valor = intval($row["cod_leyes"]);
		$Leyes[$valor][0] = $row["nombre_leyes"];
		$Leyes[$valor][1] = $row["unidad"];
	}
	include("../principal/cerrar_principal.php");
	include("../principal/conectar_imp_web.php");
?>
<html>
<head>
<title>Leyes Ponderadas</title>
<link href="../principal/estilos/css_imp_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function Proceso(opcion)
{
	var f = document.frmPrincipal;
	switch (opcion)
	{
		case "C":
			window.close();		
			break;	
		case "E":
			f.target = "_blank";
			f.action = "imp_xls_leyes_prov.php?TipoProd=" + f.TipoProd.value + "&RutProv=" + f.RutProv.value;			
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
//-->
</script>
</head>

<body link="#FFFF33" vlink="#FFFF33" alink="#FFFF33">
<form name="frmPrincipal" action="" method="post">
  <table width="590" border="1" cellspacing="1" cellpadding="1">
    <tr> 
      <td colspan="5"><strong><font><u>LEYES ESPECIALESPOR PROVEEDOR</u></font></strong> 
      </td>
    </tr>
    <tr> 
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr> 
      <td width="108"><strong>PROVEEDOR</strong></td>
      <td colspan="4"> 
        <?php
			$consulta = "SELECT * from proveedores where rut_proveedor = '".$RutProv."'";	
			$result = mysqli_query($link, $consulta);
			if ($row = mysqli_fetch_array($result))
				echo $row["rut_proveedor"]." - ".ucwords(strtolower($row["nombre"]));
			else
				echo "&nbsp;";
		?>
      </td>
    </tr>
    <tr> 
      <td><strong>PRODUCTO</strong></td>
      <td colspan="4"> 
        <?php
	$consulta = "SELECT * from productos where tipo_producto = '".$TipoProd."'";	
	$result = mysqli_query($link, $consulta);
	if ($row = mysqli_fetch_array($result))
		echo $row["tipo_producto"]." - ".ucwords(strtolower($row["nombre"]));
	else
		echo "&nbsp;";
	?>
      </td>
    </tr>
    <tr> 
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr bgcolor='<?php echo $ColorTabla1; ?>'> 
      <td width=108 align='center'><font color='#000000'><strong>FECHA</strong></font></td>
      <td width=72 align='center'><font color='#000000'><strong>CODIGO</strong></font></td>
	  <td width=90 align='center'><font color='#000000'><strong>ID. MUESTRA</strong></font></td>	  
      <td width=257 align='center'><font color='#000000'><strong>DESCRIPCION</strong></font></td>
      <td width=83 align='center'><font color='#000000'><strong>VALOR</strong></font></td>
      <td width=54 align='center'><strong>UNI.</strong></td>
      <?php			        
		$sql = "SELECT * from leyes_especiales where ";
		$sql.= " tipo_producto = '".$TipoProd."'";
		$sql.= " and rut_proveedor = '".$RutProv."'";
		$sql.= " order by fecha, id_muestra, cod_leyes, valor";
		$result = mysqli_query($link, $sql);
		$FechaAnt="";
		$IdAnt="";
		while ($row = mysqli_fetch_array($result))
		{
			echo "<tr bgcolor='$ColorTabla2'>\n";
			if (($FechaAnt == $row["fecha"]) && ($IdAnt == $row["id_muestra"]))			
			{
				echo "<td colspan=2>&nbsp;</td>";
			}
			else
			{
				echo "<td align='center'><font color='#FFFF33'>";
				echo substr($row["fecha"],8,2)."-".substr($row["fecha"],5,2)."-".substr($row["fecha"],0,4);
				echo "</font></td>\n";
				echo "<td align='center'><font color='#FFFF33'>".$row["id_muestra"]."</font></td>";				
			}
			echo "<td align='center'><font color='#FFFF33'>".$row["cod_leyes"]."</font></td>";
			$CodLey = intval($row["cod_leyes"]);
			echo "<td align='left'><font color='#FFFF33'>".$Leyes[$CodLey][0]."</font></td>";
			echo "<td align='right'><font color='#FFFF33'>".number_format($row["valor"],4,',','.')."</font></td>";
			$sql = "SELECT * from proyecto_modernizacion.unidades where cod_unidad = '".$row["cod_unidad"]."'";			
			$result2 = mysqli_query($link, $sql);
			if ($row2 = mysqli_fetch_array($result2))
			{
				echo "<td align='center'><font color='#FFFF33'>".strtoupper($row2["abreviatura"])."</font></td>";
			}
			else
			{
				echo "<td align='center'>&nbsp;</td>";
			}
			echo "</tr>\n";
			$FechaAnt=$row["fecha"];
			$IdAnt=$row["id_muestra"];
		}
?>
  </table>
  <br>
  <table width="100" border="0" align="center" cellpadding="7" cellspacing="1">
    <tr> 
      <td align="center" valign="middle"><input type="button" name="BtnPrint" value="Imprimir" style="width:110" onClick="JavaScript:Proceso('I');"></td>
      <td align="center" valign="middle"><input type="button" name="BtnExcel" value="Generar Excel" style="width:110" onClick="JavaScript:Proceso('E');"></td>
      <td align="center" valign="middle"><input type="button" name="BtnCerrar" value="Cerrar Ventana" style="width:110" onClick="JavaScript:Proceso('C');"></td>
    </tr>
  </table>
  <input type="hidden" name="TipoProd" value="<?php echo $TipoProd;?>">
<input type="hidden" name="RutProv" value="<?php echo $RutProv;?>">
</form>
</body>
</html>
