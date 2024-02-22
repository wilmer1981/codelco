<html>
<head>
<title>Directorio</title>
</head>

<body>
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaPrincipal">
  <tr align="center">
    <td colspan="4" valign="top" nowrap class="Detalle03"><strong><?php echo $Titulo; ?> 
</strong></td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td valign="top" align="left">Archivo</td>
	<td valign="top" align="center">Tama&ntilde;o</td>
  </tr>

  <?php
if (!isset($Dir) || substr($Dir,-3)=="/..")
{
	//$Dir = 'archivos/inversion/Sistema de Inversiones Corporativo - CODELCO';
	$Nivel=1;
}
$ArrArchivos = array();
$Directorio=opendir($Dir);
$i=0;
$ContCDV=0;
$ContENM=0;
while ($Archivo = readdir($Directorio)) 
{
	if (($Archivo !='.' && $Archivo !=''))
	{ 		
		$FechaHora = date("d-m-Y H:i:s", filemtime($Dir."/".$Archivo));
		$Peso = filesize($Dir."/".$Archivo);
		$ArrArchivo[$i][0] = $Archivo;
		$ArrArchivo[$i][1] = $FechaHora;
		$ArrArchivo[$i][2] = $Peso;
	}
	$i++;
}
closedir($Directorio);
if (count($ArrArchivo)>0)
{
	reset($ArrArchivo);
	//krsort($ArrArchivo);
	while (list($k,$v)=each($ArrArchivo))
	{
		echo "<tr>\n";
		if ($Nivel==1 && $v[0]=="..")
		{
			//NADA
		}
		else
		{
			if(is_dir($Dir."/".$v[0]))
			{
				echo "<td><img src=\"archivos/ico_carpeta.gif\" border='0' align='absmiddle'>&nbsp;";
				echo "<a href=\"directorio.php?Dir=".$Dir."/".$v[0]."\">";
				if ($v[0]=="..")
					echo $v[0]." Volver";
				else
					echo $v[0];
				"</a>";
				echo "</td>\n";
				echo "<td align=\"right\">&lt;DIR&gt;</td>";
			}
			else
			{
				echo "<td><img src=\"archivos/img_listado.gif\" border='0' align='absmiddle'>&nbsp;";
				echo "<a href=\"".$Dir."/".$v[0]."\" target=\"_blanck\">".$v[0]."</a>";
				echo "</td>\n";
				echo "<td align=\"right\">".number_format(($v[2]/1000),0,",",".")." kb</td>";
			}		
			echo "</tr>\n";
		}
	}
}
clearstatcache();
?>
</table>
<br>
</body>
</html>
