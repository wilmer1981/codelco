<?php
include("../principal/conectar_pmn_web.php");	
include("pmn_funciones.php");
if(isset($_REQUEST["xls"])){
	$xls = $_REQUEST["xls"];
}else{
	$xls = "";
}
if(isset($_REQUEST["Pag"])){
	$Pag = $_REQUEST["Pag"];
}else{
	$Pag = "";
}
if(isset($_REQUEST["Buscar"])){
	$Buscar = $_REQUEST["Buscar"];
}else{
	$Buscar = "";
}

if(isset($_REQUEST["Ano"])){
	$Ano = $_REQUEST["Ano"];
}else{
	$Ano = date('Y');
}
if(isset($_REQUEST["Mes"])){
	$Mes = $_REQUEST["Mes"];
}else{
	$Mes = date('m');
}

if(isset($_REQUEST["Accion"])){
	$Accion = $_REQUEST["Accion"];
}else{
	$Accion = "";
}



if($xls=='')
{
?>
<title>Consultas</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="javascript">

var popup=0;
function Proceso(Proc,Pag)
{
	var f=document.PrinElectPLata;
	switch(Proc)
	{
		case "B":
			f.action="pmn_consultas_bitacora.php?Pag="+Pag+"&Buscar=S&Mes="+f.Mes.value;
			f.submit();
		break
		case "EX":
			var URL = "pmn_consultas_bitacora.php?xls=S&Mes="+f.Mes.value+"&Accion="+f.Accion.value+"&Ano="+f.Ano.value;
			window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=162";
			f.submit();
		break;		
	}
}		
</script>
<style type="text/css">

.Estilo7 {font-size: 14px}

</style>
<form name="PrinElectPLata" method="post">
<table width="60%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
    <td align="center"><table width="100%" border="0" cellpadding="0"  cellspacing="2">
      <tr>
        <td width="98" height="35" align="left" class="formulario"   ><img src="archivos/LblCriterios.png" /> </td>
        <td align="center" valign="top" class="formulario Estilo7">Bitacora</td>
        <td width="214" align="right" class="formulario">
		<a href="JavaScript:Proceso('B','3')"><img src="archivos/Btn_buscar.gif"   alt="Buscar" width="25" height="27"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="javascript:Proceso('EX','3')"><img src="archivos/excel.png" alt='Excel' width="25" height="25" border="0" align="absmiddle" /></a> &nbsp;
		<a href="javascript:window.print()"><img src="archivos/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp; 
		<a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle" /></a></td>
      </tr>
      <tr>
        <td align="left" class="formulario">Mes</td>
        <td class="formulario"><span class="ColorTabla02">
          <select name="Mes">
            <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($Mes))
			{
				if ($Mes == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}/*
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}*/
		}
		?>
          </select>&nbsp;
		<select name='Ano'>
		<option value="-1" selected="selected">Seleccionar</option>
		<?php
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if (isset($Ano))
					{
						if ($i == $Ano)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}/*
					else
					{
						if ($i == $AnoActual)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	
							echo "<option value='".$i."'>".$i."</option>\n";
					}*/
				}
				?>
		</select>		  
        </span></td>
        <td class="formulario">&nbsp;</td>
      </tr>
      <tr>
        <td class="formulario">Acci&oacute;n</td>
        <td class="formulario">
		<select name="Accion">
		<option selected="selected" value="T">Todos</option>
		<?php
			switch($Accion)
			{
				case "I":
					?>
					<option value="I" selected="selected">Ingresos</option>
					<option value="M">Modificaciones</option>
					<option value="E">Eliminaciones</option>
					<?php
				break;
				case "M":
					?>
					<option value="I">Ingresos</option>
					<option value="M" selected="selected">Modificaciones</option>
					<option value="E">Eliminaciones</option>
					<?php
				break;
				case "E":
					?>
					<option value="I">Ingresos</option>
					<option value="M">Modificaciones</option>
					<option value="E" selected="selected">Eliminaciones</option>
					<?php
				break;
				default:
					?>
					<option value="I">Ingresos</option>
					<option value="M">Modificaciones</option>
					<option value="E">Eliminaciones</option>
					<?php
				break;
			}
		?>
		</select>
		&nbsp;</td>
        <td class="formulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="6" class="formulario">&nbsp;</td>
      </tr>
    </table></td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"></td>
  </tr>
</table>
<br />
<?php
if($Buscar=='S')
{
?>
<table width="60%" align="center"  border="0" cellpadding="0"  cellspacing="0">
  <tr>
    <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
    <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
  </tr>
  <tr>
    <td width="1%" background="archivos/images/interior/izquierdo.png"> </td>
    <td align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
      <tr align="center" class="TituloCabeceraAzul">
        <td width="189" height="15" class="TituloCabeceraAzul">Rut Realizo</td>
        <td width="76">Acci�n</td>
        <td width="103">Fecha Hora Bitacora</td>
        <td width="52">Lote</td>
        <td width="51">Recargo</td>
        <td width="48">Lixi.</td>
        <td width="222">Observaci�n</td>
      </tr>
      <?php	
	  $Consulta = "SELECT * from pmn_web.pmn_bad_bitacora";
	  $Consulta.= " where month(fecha_hora_bita)='".$Mes."' and year(fecha_hora_bita)='".$Ano."'";
	  if($Accion!='T')
	  	$Consulta.=" and accion='".$Accion."'";
	  $Respuesta = mysqli_query($link, $Consulta);
	  $Total02=0;$Total03=0;$Total04=0;$Total05=0;
	  while ($Row = mysqli_fetch_array($Respuesta))
	  {
	  	  $RetAccion=AccionBitacora($Row["accion"]);	
		  ?>
		  <tr align="center" class="TituloCabecera">
			<td align="left" ><?php echo NomUsuario($Row["rut_realizo"]); ?></td>
			<td align="left"><?php echo $RetAccion; ?>&nbsp;</td>
			<td align="right"><?php echo $Row["fecha_hora_bita"]; ?>&nbsp;</td>
			<td align="right" class="TituloCabeceraSalmon"><?php echo $Row["lote"]; ?>&nbsp;</td>
			<td align="right"><?php echo $Row["recargo"]; ?>&nbsp;</td>
			<td align="right" class="TituloCabeceraSalmon"><?php echo $Row["num_lixiviacion"]; ?>&nbsp;</td>
			<td align="right" class="TituloCabeceraAmarillo"><textarea rows="3" cols="50" disabled="disabled"><?php echo $Row["obs"]; ?></textarea></td>
		  </tr>
		  <?php
	  }
	  ?>
    </table>
      � </td>
    <td width="1%" background="archivos/images/interior/derecho.png"></td>
  </tr>
  <tr>
    <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
    <td height="15" background="archivos/images/interior/abajo.png"></td>
    <td width="1%" height="15"><img src="archivos/images/interior/esq4.png" /></td>
  </tr>
</table>
<?php
}
?>
<br />
<p>&nbsp;</p>
</form>
<?php
}
else
{
ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename="";
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
?>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<table width="100%" border="1" cellpadding="0"  cellspacing="0">
      <tr>
        <td colspan="7" align="center" valign="top" class="TituloCabeceraAzul">Lotes por correlativos </td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="TituloCabeceraAzul">Mes</td>
        <td colspan="5" class="formulario"><span class="ColorTabla02">
            <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($Mes))
			{
				if ($Mes == $i)
					echo ucwords(strtolower($Meses[$i - 1]));
			}
		}
		?>
		&nbsp;
		<?php
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if (isset($Ano))
					{
						if ($i == $Ano)
							echo $i;
					}
				}
				?>
        </span></td>
  </tr>
      <tr>
        <td colspan="2" align="left" class="TituloCabeceraAzul">Accion</td>
        <td colspan="5" class="formulario">
          <?php
			switch($Accion)
			{
				case "I":
					echo "Ingresos";
				break;
				case "M":
		          echo "Modificaciones";
				break;
				case "E":
		          echo "Eliminaciones";
				break;
				default:
		          echo "Todos";
				break;
			}
		?>
        </td>
      </tr>
</table>
	<br />
	<table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
      <tr align="center" class="TituloCabeceraAzul">
        <td width="189" height="15" class="TituloCabeceraAzul">Rut Realizo</td>
        <td width="76">Acci&oacute;n</td>
        <td width="103">Fecha Hora Bitacora</td>
        <td width="52">Lote</td>
        <td width="51">Recargo</td>
        <td width="48">Lixi.</td>
        <td width="222">Observaci&oacute;n</td>
      </tr>
      <?php	
	  $Consulta = "select * from pmn_web.pmn_bad_bitacora";
	  $Consulta.= " where month(fecha_hora_bita)='".$Mes."' and year(fecha_hora_bita)='".$Ano."'";
	  if($Accion!='T')
	  	$Consulta.=" and accion='".$Accion."'";
	  $Respuesta = mysqli_query($link, $Consulta);
	  $Total02=0;$Total03=0;$Total04=0;$Total05=0;
	  while ($Row = mysqli_fetch_array($Respuesta))
	  {
	  	  $RetAccion=AccionBitacora($Row["accion"]);	
		  ?>
      <tr align="center" class="TituloCabecera">
        <td align="left" ><?php echo NomUsuario($Row["rut_realizo"]); ?></td>
        <td align="left"><?php echo $RetAccion; ?>&nbsp;</td>
        <td align="right"><?php echo $Row["fecha_hora_bita"]; ?>&nbsp;</td>
        <td align="right" class="TituloCabeceraSalmon"><?php echo $Row["lote"]; ?>&nbsp;</td>
        <td align="right"><?php echo $Row["recargo"]; ?>&nbsp;</td>
        <td align="right" class="TituloCabeceraSalmon"><?php echo $Row["num_lixiviacion"]; ?>&nbsp;</td>
        <td align="right" class="TituloCabeceraAmarillo"><?php echo $Row["obs"]; ?></td>
      </tr>
      <?php
	  }
	  ?>
    </table>
	<br />
	<?php	
}
?>
