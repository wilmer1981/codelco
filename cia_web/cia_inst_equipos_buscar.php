<? 
	include("../principal/conectar_principal.php");
?>
<html>
<head>
<title>Buscar</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript">
function Recarga(codigo)
{
	var f=document.frmPopUp;
	window.opener.location="cia_inst_equipos.php?TxtCodEquipo="+codigo;
	//window.opener.document.frmPrincipal.submit();
	window.close();
}
function Recarga2(codigo)
{
	var f=document.frmPopUp;
	f.action="cia_inst_equipos_buscar.php?Valida="+codigo;
	f.submit();
}
function Salir()
{
	window.close();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<form name="frmPopUp" action="" method="post"><table width="550" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaInterior">
      <tr align="center">
        <td colspan="2">VER VALIDADOS </td>
        <td colspan="5">
<?
switch ($Valida)
{
	case "T":
		echo "<input name=\"ChkValida1\" type=\"radio\" value=\"T\" onClick=\"Recarga2('T')\" checked>TODO&nbsp;&nbsp;";
		echo "<input name=\"ChkValida2\" type=\"radio\" value=\"S\" onClick=\"Recarga2('S')\">SI&nbsp;&nbsp;";
		echo "<input name=\"ChkValida3\" type=\"radio\" value=\"\" onClick=\"Recarga2('')\">NO&nbsp;&nbsp;";
		echo "<input name=\"ChkValida4\" type=\"radio\" value=\"P\" onClick=\"Recarga2('P')\">OBSERVACIONES";
		break;
	case "S":
		echo "<input name=\"ChkValida1\" type=\"radio\" value=\"T\" onClick=\"Recarga2('T')\">TODO&nbsp;&nbsp;";
		echo "<input name=\"ChkValida2\" type=\"radio\" value=\"S\" onClick=\"Recarga2('S')\" checked>SI&nbsp;&nbsp;";
		echo "<input name=\"ChkValida3\" type=\"radio\" value=\"\" onClick=\"Recarga2('')\">NO&nbsp;&nbsp;";
		echo "<input name=\"ChkValida4\" type=\"radio\" value=\"P\" onClick=\"Recarga2('P')\">OBSERVACIONES";
		break;
	case "":
		echo "<input name=\"ChkValida1\" type=\"radio\" value=\"T\" onClick=\"Recarga2('T')\">TODO&nbsp;&nbsp;";
		echo "<input name=\"ChkValida2\" type=\"radio\" value=\"S\" onClick=\"Recarga2('S')\">SI&nbsp;&nbsp;";
		echo "<input name=\"ChkValida3\" type=\"radio\" value=\"\" onClick=\"Recarga2('')\" checked>NO&nbsp;&nbsp;";
		echo "<input name=\"ChkValida4\" type=\"radio\" value=\"P\" onClick=\"Recarga2('P')\">OBSERVACIONES";
		break;
	case "P":
		echo "<input name=\"ChkValida1\" type=\"radio\" value=\"T\" onClick=\"Recarga2('T')\">TODO&nbsp;&nbsp;";
		echo "<input name=\"ChkValida2\" type=\"radio\" value=\"S\" onClick=\"Recarga2('S')\">SI&nbsp;&nbsp;";
		echo "<input name=\"ChkValida3\" type=\"radio\" value=\"\" onClick=\"Recarga2('')\">NO&nbsp;&nbsp;";
		echo "<input name=\"ChkValida4\" type=\"radio\" value=\"P\" onClick=\"Recarga2('P')\" checked>OBSERVACIONES";
		break;
	default:
		echo "<input name=\"ChkValida1\" type=\"radio\" value=\"T\" onClick=\"Recarga2('T')\" checked>TODO&nbsp;&nbsp;";
		echo "<input name=\"ChkValida2\" type=\"radio\" value=\"S\" onClick=\"Recarga2('S')\">SI&nbsp;&nbsp;";
		echo "<input name=\"ChkValida3\" type=\"radio\" value=\"\" onClick=\"Recarga2('')\">NO&nbsp;&nbsp;";
		echo "<input name=\"ChkValida4\" type=\"radio\" value=\"P\" onClick=\"Recarga2('P')\">OBSERVACIONES";
		break;
	}
?>
</td>
      </tr>
      <tr align="center">
        <td colspan="7">          <input name="BtnSalir" type="button" id="BtnAgregar" value="Cerrar" onClick="Salir()" style="width:70px ">
            </td>
      </tr>
      <tr align="center" class="ColorTabla01">
        <td width="9">&nbsp;</td>
        <td align="left" width="88">USUARIO</td>
        <td width="78">C.C.</td>
        <td width="141">SERIE. CPU</td>
        <td width="99">SERIA MONI. </td>
        <td width="96">NOM_PC</td>
      </tr>
<?
	$Consulta = "select * from ins_equipo.equipo ";
	if ($Valida!="T")
		$Consulta.= " where validado='".$Valida."' ";
	$Consulta.= " order by nom_pc";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysql_fetch_array($Resp))	  
	{
		echo "<tr>\n";
		echo "<td><input name=\"ChkEquipo\" type=\"radio\" value=\"".$Fila["cod_equipo"]."\" onClick=\"Recarga('".$Fila["cod_equipo"]."')\"></td>\n";
		$Consulta = "select * from proyecto_modernizacion.funcionarios where rut='".$Fila["usuario"]."'";
		$RespAux=mysqli_query($link, $Consulta);
		if ($FilaAux=mysql_fetch_array($RespAux))
			$NomUser=strtoupper($FilaAux["apellido_paterno"])." ".strtoupper(substr($FilaAux["apellido_materno"],0,1)).". ".strtoupper($FilaAux["nombres"]);
		else
			$NomUser=$Fila["usuario"];
		$Consulta = "select * from ins_equipo.detalle_equipo where cod_equipo='".$Fila["cod_equipo"]."' ";
		$Consulta.= " and (cod_clase='18902' or cod_clase='18903')";
		$RespAux=mysqli_query($link, $Consulta);
		$SerieCpu="";
		$SerieMoni="";
		while ($FilaAux=mysql_fetch_array($RespAux))
		{
			switch ($FilaAux["cod_clase"])
			{
				case "18902":
					$SerieCpu=$FilaAux["campo1"];
					break;
				case "18903":
					$SerieMoni=$FilaAux["campo1"];
					break;
			}									
		}
		echo "<td align='left'>".$NomUser."&nbsp;</td>\n";
		echo "<td align='center'>".$Fila["centro_costo"]."&nbsp;</td>\n";
		echo "<td align='left'>".$SerieCpu."&nbsp;</td>\n";
		echo "<td align='left'>".$SerieMoni."&nbsp;</td>\n";
		echo "<td align='left'>".$Fila["nom_pc"]."</td>\n";
		echo "</tr>\n";
	}
?>	  
    </table>
</form>
</body>
</html>
