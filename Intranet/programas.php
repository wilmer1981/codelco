<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="js/style.css" rel=stylesheet>
</head>

<body>
<table width="300" border="0" cellpadding="2" cellspacing="1" class="TablaPrincipal">
  <tr>
    <td colspan="3" class="titulo_codelco_informa">Programas y Utilidades</td>
  </tr>
  <tr align="center">
    <td width="121"  class="BordeInf"><font class="titulo_codelco_informa">Programa</font></td>
    <td width="56"  class="BordeInf"><font class="titulo_codelco_informa">Tama&ntilde;o</font></td>
    <td width="28"  class="BordeInf"><font class="titulo_codelco_informa">Tipo</font></td>
  </tr>  
<?
$ArrArchivos = array();
$Dir = 'informatica/programas';
$Directorio=opendir($Dir);
$i=0;
while ($Archivo = readdir($Directorio)) 
{
	if($Archivo != '..' && $Archivo !='.' && $Archivo !='')
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
		$Unidad="kb";
		echo "<tr>";
		//echo "<td align=\"right\" class=\"BordeInf\"><img src=\"images/vineta2.gif\" width=\"13\" height=\"12\" border=\"0\"></td>\n";		
		echo "<td align=\"left\" class=\"BordeInf\"><a href=\"".$Dir."/".$v[0]."\"><font class=\"main-menu\">";
		echo $v[0];
		echo "</font></a></td>";		
		if(is_dir($Dir."/".$v[0]))
		{
			echo "<td align=\"right\" class=\"BordeInf\">&nbsp;</td>\n";
			echo "<td align=\"right\" class=\"BordeInf\">&lt;DIR&gt;</td>\n";			
		}
		else		
		{			
			echo "<td align=\"right\" class=\"BordeInf\">".number_format(($v[2]/1000),3,",",".")."</td>\n";			
			echo "<td align=\"right\" class=\"BordeInf\">".$Unidad."</td>\n";
		}
		echo "</tr>\n";
	}
}
clearstatcache();		
?>  
  <tr align="center" bgcolor="#efefef">
    <td colspan="3" class="BordeInf"><a href="JavaScript:window.history.back();"><span>volver</span></a></td>
  </tr>
</table>
</body>
</html>
