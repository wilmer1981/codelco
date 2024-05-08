<? 
	include("conectar.php"); 
	
?>
<html>
<head>
<title>Administrar Carpetas</title>
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
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkDir" && f.elements[i].checked==true)
				{
					Valor=Valor + f.elements[i].value + "~~";
				}
			}
			/*if (Valor=="")
			{
				alert("Debe Seleccionar uno mas Directorio(s)");
				return;
			}*/
			f.action="adm_carpetas01.php?Proceso=G&Directorios="+Valor;
			f.submit();
			break;
	}
}
function Recarga(carpeta)
{
	var f = document.frmPopUp;
	f.action="adm_carpetas.php?Dir="+carpeta;
	f.submit();
}
function Recarga_1()
{
	var f = document.frmPopUp;
	f.action="adm_carpetas.php";
	f.submit();
}
</script>
</head>

<body>
<form name="frmPopUp" action="" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="Tipo" value="<? echo $Tipo; ?>">
<input type="hidden" name="DirAnt" value="<?
for ($i=strlen($Dir);$i>0;$i--)
{
	if (substr($Dir,$i,1)=="/")
	{
		$DirAnt=substr($Dir,0,$i);
		break;
	}
}
echo $DirAnt;
?>">
<table width="380" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaPrincipal">
  <tr>
    <td colspan="3" class="titulo_codelco_informa">Administrador de Carpetas de Archivos de Usuarios </td>
  </tr>
  <tr align="center">
    <td colspan="3" class="BordeInf">
    <p><a href="JavaScript:AbrirPopUp('adm_destacados.php')"></a><span class="titulo_codelco_informa"><? if (isset($Mensaje)){ echo $Mensaje;}?></span></p></td>
  </tr>
  <tr>
    <td colspan="2" class="BordeInf">Usuario: </td>
    <td align="left"  class="BordeInf">
<select name="RutFun" onChange="Recarga_1()">

<?	
	//$link=mysql_connect("10.56.11.7","adm_bd","672312");
	mysql_select_db("proyecto_modernizacion",$link);	
	$Consulta = "select * from proyecto_modernizacion.funcionarios order by apellido_paterno, apellido_materno, nombres, rut"; 
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		$Nombre = strtoupper($Fila["apellido_paterno"])." ".strtoupper($Fila["apellido_materno"])." ".strtoupper($Fila["nombres"]);
		if ($RutFun==$Fila["rut"])
			echo "<option selected value=\"".$Fila["rut"]."\">".$Nombre."</option>";
		else
			echo "<option value=\"".$Fila["rut"]."\">".$Nombre."</option>";
	}
	mysql_close($link);
?>	 </select>
	</td>
  </tr>
  <tr>
    <td colspan="2" class="BordeInf">Todas:</td>
    <td class="BordeInf">
<?	
	include("conectar.php");
	$Consulta = "select distinct directorio from intranet.directorios where rut_funcionario='".$RutFun."' and directorio='*'";
	$Resp = mysql_query($Consulta);
	$ChkTodas="N";
	if ($Fila = mysql_fetch_array($Resp))
	{
		$ChkTodas="S";
	}		

	if ($ChkTodas=="S")
	{
		echo "<input checked name=\"ChkTodas\" type=\"radio\" value=\"S\">Si&nbsp;&nbsp; ";
		echo "<input name=\"ChkTodas\" type=\"radio\" value=\"N\">No";
	}
	else
	{
		echo "<input name=\"ChkTodas\" type=\"radio\" value=\"S\">Si&nbsp;&nbsp; ";
		echo "<input checked name=\"ChkTodas\" type=\"radio\" value=\"N\">No";
	}
?>	  </td>
  </tr>
  <tr align="center">
    <td colspan="3" class="BordeInf"><label></label><input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">       
    <input name="BtnCerrar" type="button" id="BtnCerrar" value="Cerrar" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  <tr>
    <td width="14" align="right" class="BordeInf">&nbsp;</td>
    <td width="23" align="right" class="BordeInf">&nbsp;</td>
    <td align="left"  class="BordeInf"><font class="titulo_codelco_informa">Carpeta Autorizada  </font></td>
  </tr>
<? 	
	$ArrArchivos = array();
	if ($Dir=="" || $Dir=="archivos")
	{
		$Dir = 'archivos';
	}	
	else
	{		
		echo "<tr>";
		echo "<tr>\n";			
		echo "<td width=\"217\" align=\"left\"  class=\"BordeInf\" colspan=\"4\">";
		echo "<a href=\"JavaScript:Recarga('".$DirAnt."')\">".$DirAnt."/</a>";
		echo "</td>\n";
		echo "</tr>\n";
	}
	
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
				$Consulta = "select * from intranet.directorios where rut_funcionario='".$RutFun."' and directorio='".$Dir."/".$v[0]."'";
				$Resp=mysql_query($Consulta);
				$Checked="";
				if ($Fila=mysql_fetch_array($Resp))
					$Checked="checked";
				echo "<tr>";
				echo "<tr>\n";
				echo "<td width=\"20\" align=\"right\" class=\"BordeInf\"><img src=\"images/vineta2.gif\" width=\"13\" height=\"12\" border=\"0\"></td>\n";
				echo "<td width=\"20\" align=\"right\" class=\"BordeInf\"><input ".$Checked." type=\"checkbox\" name=\"ChkDir\" value=\"".$Dir."/".$v[0]."\"></td>\n";				
				echo "<td width=\"217\" align=\"left\"  class=\"BordeInf\" colspan=\"2\">";
				if (is_dir($Dir."/".$v[0]))
					echo "<a href=\"JavaScript:Recarga('".$Dir."/".$v[0]."')\">&lt;".strtolower($v[0])."&gt;</a>";
				else
					echo "&lt;".strtolower($v[0])."&gt;";
				echo "</td>\n";
				echo "</tr>\n";
			}
		}
	}
	clearstatcache();		
?>  
  <tr bgcolor="#efefef">
    <td colspan="3" align="right" class="BordeInf">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
