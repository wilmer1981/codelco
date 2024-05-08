<? 
	include("conectar.php"); 
	
?>
<html>
<head>
<title>Subir Archivos</title>
<link href="js/style.css" rel=stylesheet>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "S":
			window.close();
			break;
		case "G":
			var Valor="";
			/*if (f.Archivo="")
			{
				alert("Debe Seleccionar un Archivo");
				f.Archivo.focus();
				return;
			}*/
			for (i=1;i<f.elements.length;i++)
			{
				<?
					if ($Tipo=="SUBIR_USER_ADM" || $Tipo=="SUBIR_INF_ADM")
						echo "if (f.elements[i].name==\"ChkDir\")";
					else					
						echo "if (f.elements[i].name==\"ChkDir\" && f.elements[i].checked==true)";
				?>
				{
					Valor=f.elements[i].value;
				}
			}
			if (Valor=="")
			{
				alert("Debe Seleccionar un Directorio");
				return;
			}
			f.action="subir_archivos_usuario01.php?Proceso=G&Directorio="+Valor;
			f.submit();
			break;
	}
}
</script>
</head>

<body>
<form name="frmPopUp" action="" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="Tipo" value="<? echo $Tipo; ?>">
<table width="380" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaPrincipal">
  <tr>
    <td colspan="3" class="titulo_codelco_informa">Administrador de Archivos  </td>
  </tr>
  <tr align="center">
    <td colspan="3" class="BordeInf">
    <p><a href="JavaScript:AbrirPopUp('adm_destacados.php')"></a><span class="titulo_codelco_informa"><? if (isset($Mensaje)){ echo $Mensaje;}?></span></p></td>
  </tr>
  <tr>
    <td colspan="2" align="right" class="BordeInf">Archivo: </td>
    <td align="left"  class="BordeInf">      <input name="Archivo" type="file" id="Archivo">    </td>
  </tr>
  <tr align="center">
    <td colspan="3" class="BordeInf"><input name="BtnSubir" type="button" id="BtnSubir" value="Subir" style="width:70px " onClick="Proceso('G')">       <input name="BtnCerrar" type="button" id="BtnCerrar" value="Cerrar" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  <tr>
    <td width="14" align="right" class="BordeInf">&nbsp;</td>
    <td width="23" align="right" class="BordeInf">&nbsp;</td>
    <td align="left"  class="BordeInf"><font class="titulo_codelco_informa">Carpeta</font><font class="main-menu">&nbsp;&nbsp;&nbsp;(Destino del Archivo a Subir </font>)</td>
  </tr>
<? 
	if ($Tipo=="SUBIR_USER_ADM" || $Tipo=="SUBIR_INF_ADM")
	{
		switch ($Tipo)
		{
			case "SUBIR_USER_ADM":
				$Dir = 'informatica/programas';
				break;
			case "SUBIR_INF_ADM":
				$Dir = 'informatica/programasinf';
				break;
		}
		echo "<tr>";
		echo "<tr>\n";
		echo "<td width=\"20\" align=\"right\" class=\"BordeInf\"><img src=\"images/vineta2.gif\" width=\"13\" height=\"12\" border=\"0\"></td>\n";
		echo "<td width=\"20\" align=\"right\" class=\"BordeInf\"><input type=\"hidden\" name=\"ChkDir\" value=\"".$Dir."\">&nbsp;</td>\n";
		echo "<td width=\"217\" align=\"left\"  class=\"BordeInf\" colspan=\"2\"><font class=\"main_menu\">&lt;".$Dir."&gt;</font></td>\n";
		echo "</tr>\n";
	}
	else
	{
		$Consulta = "select distinct directorio from intranet.directorios ";
		$Consulta.= " where rut_funcionario='".$CookieSubir."' and directorio='*' ";
		$Resp = mysql_query($Consulta);
		if ($Fila = mysql_fetch_array($Resp))
		{
			$ArrArchivos = array();
			$Dir = 'archivos';
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
					if(is_dir($Dir."/".$v[0]))
					{
						echo "<tr>";
						echo "<tr>\n";
						echo "<td width=\"20\" align=\"right\" class=\"BordeInf\"><img src=\"images/vineta2.gif\" width=\"13\" height=\"12\" border=\"0\"></td>\n";
						echo "<td width=\"20\" align=\"right\" class=\"BordeInf\"><input type=\"radio\" name=\"ChkDir\" value=\"".$v[0]."\"></td>\n";
						echo "<td width=\"217\" align=\"left\"  class=\"BordeInf\" colspan=\"2\">&lt;".strtolower($v[0])."&gt;</td>\n";
						echo "</tr>\n";
					}
				}
			}
			clearstatcache();		
		}
		else
		{
			$Consulta = "select distinct directorio from intranet.directorios where rut_funcionario='".$CookieSubir."'";
			$Resp = mysql_query($Consulta);
			while ($Fila = mysql_fetch_array($Resp))
			{		
				echo "<tr>\n";
				echo "<td width=\"20\" align=\"right\" class=\"BordeInf\"><img src=\"images/vineta2.gif\" width=\"13\" height=\"12\" border=\"0\"></td>\n";
				echo "<td width=\"20\" align=\"right\" class=\"BordeInf\"><input type=\"radio\" name=\"ChkDir\" value=\"".$Fila["directorio"]."\"></td>\n";
				echo "<td width=\"217\" align=\"left\"  class=\"BordeInf\" colspan=\"2\">&lt;".strtolower($Fila["directorio"])."&gt;</td>\n";
				echo "</tr>\n";
			}
		}
	}
?>  
  <tr bgcolor="#efefef">
    <td colspan="3" align="right" class="BordeInf">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
