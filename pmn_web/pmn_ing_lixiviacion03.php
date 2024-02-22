<?php 
	include("../principal/conectar_pmn_web.php"); 

	if(isset($_REQUEST["Dia"])){
		$Dia=$_REQUEST["Dia"];
	}else{
		$Dia="";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes=$_REQUEST["Mes"];
	}else{
		$Mes="";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano=$_REQUEST["Ano"];
	}else{
		$Ano="";
	}

	$NumLix=$_REQUEST["NumLix"];
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function Proceso(opt)
{
	var f=document.frmConsulta;
	switch (opt)
	{		
		case "M":
			var LargoForm = f.elements.length;
			var ValLixiv = "";
			var ValTurno = "";
			for (i = 0; i < LargoForm; i++)
			{
				if ((f.elements[i].name == "ChkLixiv") && (f.elements[i].checked == true))
				{
					ValLixiv = f.elements[i].value;
					ValTurno = f.elements[i+2].value;
					ValFecha= f.elements[i+3].value;
					break;
				}
			}
			if (ValLixiv == "")
			{
				alert("Debe seleccionar un registro para Modificar");
				return;
			}
			else
			{
				//window.opener.document.frmPrincipal.action = "pmn_ing_lixiviacion.php?Modif=L&DiaModif=" + f.Dia.value + "&MesModif=" + f.Mes.value + "&AnoModif=" + f.Ano.value + "&TurnoModif=" + ValTurno + "&NumLixModif="+ValLixiv;
				window.opener.document.frmPrincipalRpt.action = "pmn_lixiviacion.php?ModifLixi=L&TurnoModif="+ValTurno + "&NumLixModif="+ValLixiv + "&FechaModif="+ValFecha+"&Tab6=true";
				window.opener.document.frmPrincipalRpt.submit();
				window.close();
			}
			break
		case "E2":
			var LargoForm = f.elements.length;
			var ValLixiv = "";
			var ValTurno = "";
			for (i = 0; i < LargoForm; i++)
			{
				if ((f.elements[i].name == "ChkLixiv") && (f.elements[i].checked == true))
				{
					ValLixiv = f.elements[i].value;
					ValTurno = f.elements[i+2].value;
					ValFecha = f.elements[i+3].value;
					break;
				}
			}
			if (ValLixiv == "")
			{
				alert("Debe seleccionar un registro para Eliminar");
				return;
			}
			else
			{
				f.action = "pmn_ing_lixiviacion01.php?Proceso=E2&Lixiv=" + ValLixiv + "&Turnito=" +ValTurno + "&Fecha="+ValFecha;
				f.submit();
			}
			break
		case "I":
			window.print();
			break
		case "V":
			f.action = "pmn_ing_lixiviacion02.php";
			f.submit();
			break
		case "S":
			window.close();
			break
	}
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body class="TituloCabeceraOz" leftmargin="3" topmargin="2">
<form name="frmConsulta" action="" method="post">
<div id="div02" style="position:absolute; left: 10px; top: 21px; width: 795px; height: 34px;"> 
    <table width="770" height="30" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr> 
        <td height="28"> <div align="center">
            <input type="button" name="btnEliminar" value="Eliminar" onClick="Proceso('E2');" style="width:70px">
            <input type="button" name="btnModificar" value="Modificar" onClick="Proceso('M')" style="width:70px">
            <input type="button" name="btnInprimit" value="Imprimir" onClick="Proceso('I')" style="width:70px">
            <input type="button" name="btnSalir" value="Salir" onClick="Proceso('S')" style="width:70px">
          </div></td>
      </tr>
    </table>
</div>
  <div style="position:absolute; left: 11px; top: 65px; width: 906px; height: 71px;"> 
    <table width="903" height="20" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
      <tr bgcolor="#CCCCCC"> 
        <td height="20" colspan="16" class="titulo_azul">LIXIVIACION</td>
      </tr>
      <tr class="TituloCabeceraAzul"> 
        <td width="1" height="20">&nbsp;</td>
        <td width="42" height="20" align="center" valign="middle"># Lixiv.i</td>
        <td width="53" align="center" valign="middle">Lixiviador</td>
        <td width="40" align="center" valign="middle">Acidc</td>
		<td width="42" align="center" valign="middle">Fecha Carga</td>
        <td width="40" align="center" valign="middle">Hora Carga</td>
        <td width="49" align="center" valign="middle">Fecha Analisis</td>
        <td width="72" align="center" valign="middle">Hora Anal.</td>
        <td width="36" align="center" valign="middle">% Cu</td>
        <td width="39" align="center" valign="middle">% HDO</td>
        <td width="54" align="center" valign="middle">Fecha Filtracion</td>
        <td width="54" align="center" valign="middle">Hora Filtra.</td>
        <td width="43" align="center" valign="middle">B.A.D.</td>
        <td width="110" align="center" valign="middle">Operador</td>
        <td width="174" colspan="2" align="center" valign="middle">Jefe Tuno</td>
      </tr>
      <?php	 
	$Fecha = $Ano."-".$Mes."-".$Dia;
	$sql = "select * from lixiviacion_barro_anodico";
	$sql.= " where num_lixiviacion='".$NumLix."'";
	$sql.= " order by turno";
	//echo $sql."<br>"; 
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		echo "<tr>\n";
		echo "<td width=1>";
		echo "<input type='radio' name='ChkLixiv' value='".$row["num_lixiviacion"]."'>";
		echo "</td>\n";
		echo "<td height=25 align='center' valign='middle'><input name='TxtNumLixid' readonly type='text' value='".$row["num_lixiviacion"]."' size=7 maxlength=7>";
		echo "<input type='hidden' name='Turno' value='".$row["turno"]."'></td>\n";
		echo "<input type='hidden' name='Fecha' value='".$row["fecha"]."'></td>\n";
		echo "<td align='center' valign='middle'><input name='TxtLixid'      readonly type='text' size=7  maxlength=7  value='".$row["lixiviador"]."'></td>\n";
		$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase=".$row["turno"];
		$result2 = mysqli_query($link, $sql);
		if ($row2=mysqli_fetch_array($result2))
			$TxtTurno = strtoupper($row2["nombre_subclase"]);
		else	$TxtTurno = "N";
		
		echo "<td align='center' valign='middle'><input name='TxtAcidc'      readonly type='text' size=7  maxlength=10 value='".$row["acidc"]."'></td>\n";		
		echo "<td align='center' valign='middle'><input name='TxtFecha'      readonly type='text' size=11  maxlength=10 value='".$row["fecha_carga"]."'></td>\n";
		//echo "<td align='center' valign='middle'><input name='TxtDia'        readonly type='text' size=7  maxlength=7  value='".$row[dia_carga]."'></td>\n";
		echo "<td align='center' valign='middle'><input name='TxtHora'       readonly type='text' size=10 maxlength=10 value='".$row["hora_carga"]."'></td>\n";
		echo "<td align='center' valign='middle'><input name='TxtFechaAnalisis'        readonly type='text' size=11  maxlength=7  value='".$row["fecha_analisis"]."'></td>\n";
		echo "<td align='center' valign='middle'><input name='TxtHoraAnal'   readonly type='text' size=10 maxlength=10 value='".$row["hora_analisis"]."'></td>\n";
		echo "<td align='center' valign='middle'><input name='TxtPorcCobre'  readonly type='text' size=10 maxlength=10 value='".$row["porc_cobre"]."'></td>\n";
		echo "<td align='center' valign='middle'><input name='TxtPorcAgua'  readonly type='text' size=10 maxlength=10 value='".$row["porc_agua"]."'></td>\n";
		echo "<td align='center' valign='middle'><input name='TxtFechaFiltracion' readonly type='text' size=11 maxlength=10 value='".$row["fecha_filtracion"]."'></td>\n";
		echo "<td align='center' valign='middle'><input name='TxtHoraFiltra' readonly type='text' size=10 maxlength=10 value='".$row["hora_filtracion"]."'></td>\n";
		echo "<td align='center' valign='middle'><input name='TxtBAD'        readonly type='text' size=10 maxlength=10 value='".$row["bad"]."'></td>\n";
		$sql = "select * from proyecto_modernizacion.funcionarios where rut = '".$row["operador"]."'";
		$result2 = mysqli_query($link, $sql);
		if ($row2=mysqli_fetch_array($result2))
			$TxtOperador = ucwords(strtolower(substr($row2["nombres"],0,1).". ".$row2["apellido_paterno"]));
		else	$TxtOperador = "No Encontrado";
		echo "<td align='center' valign='middle'><input name='TxtOperador'   readonly type='text' size=15 maxlength=15 value='".$TxtOperador."'></td>\n";
		$sql = "select * from proyecto_modernizacion.funcionarios where rut = '".$row["jefe_turno"]."'";
		$result2 = mysqli_query($link, $sql);
		if ($row2=mysqli_fetch_array($result2))
			$TxtJefeTurno = ucwords(strtolower(substr($row2["nombres"],0,1).". ".$row2["apellido_paterno"]));
		else	$TxtJefeTurno = "No Encontrado";
		echo "<td colspan=2 align='center' valign='middle'><input name='TxtJefeturno' readonly type='text' size=15 maxlength=15 value='".$TxtJefeTurno."'></td>\n";
		echo "</tr>\n";
	}
?>
    </table>
</div>
</form>
</body>
</html>
