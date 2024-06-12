<?php 
	include("../principal/conectar_pmn_web.php"); 
	//Dia=11&Mes=12&Ano=2023
	//pmn_ing_lixiviacion02.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&DiaF=".$DiaF."&MesF=".$MesF."&AnoF=".$AnoF
	$Dia=isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
	$Mes=isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano=isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");

	$fechaActual = date('Y-m-d h:i:s'); 
    $fechaSegundos = strtotime($fechaActual);

    $dia = date( "j", $fechaSegundos);
    $mes = date("n", $fechaSegundos);
    $ano = date("Y", $fechaSegundos);
	
	$DiaF=isset($_REQUEST["DiaF"])?$_REQUEST["DiaF"]:$dia;
	$MesF=isset($_REQUEST["MesF"])?$_REQUEST["MesF"]:$mes;
	$AnoF=isset($_REQUEST["AnoF"])?$_REQUEST["AnoF"]:$ano;

	$AnoActual=$ano;
	$MesActual=$mes;
	$DiaActual=$dia;

?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">

function Proceso(opt)
{
	var f=document.frmConsulta;
	var ValFecha='';
	
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
				var ValFechaAux=ValFecha.split('-');
				window.opener.document.frmPrincipalRpt.action = "pmn_lixiviacion.php?ModifLixi=S&DiaModif=" + ValFechaAux[2] + "&MesModif=" + ValFechaAux[1] + "&AnoModif=" + ValFechaAux[0] + "&TurnoModif=" + ValTurno + "&NumLixModif="+ValLixiv + "&FechaModif="+ValFecha+"&Tab6=true" ;
				window.opener.document.frmPrincipalRpt.submit();
				window.close();
			}
			break
		case "E":
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
				f.action = "pmn_ing_lixiviacion01.php?Proceso=E&Lixiv=" + ValLixiv + "&Turnito=" + ValTurno + "&Dia="+f.Dia.value + "&Mes="+f.Mes.value + "&Ano="+f.Ano.value + "&DiaF="+f.DiaF.value + "&MesF="+f.MesF.value + "&AnoF="+f.AnoF.value + "&FechaCarga="+ValFecha;
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

</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
<br>
    <table width="770" height="56" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr> 
        <td width="132" height="28" class="titulo_azul">Fecha Inicio Consulta</td>
        <td width="220"><select name="Dia">
            <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($Dia))
			{
				if ($Dia == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == $DiaActual)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
          </select> <select name="Mes">
            <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($Mes))
			{
				if ($Mes == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
          </select> <select name="Ano">
            <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($Ano))
			{
				if ($Ano == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == $AnoActual)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
          </select></td>
        <td width="98" class="titulo_azul">Fecha Termino</td>
        <td width="296">
			<select name="DiaF" id="DiaF">
				<?php
					for ($i = 1;$i <= 31; $i++)
					{
						if (isset($DiaF))
						{
							if ($DiaF == $i)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $DiaActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
				?>
          </select> 
          <select name="MesF" id="MesF">
            <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesF))
			{
				if ($MesF == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
          </select> 
          <select name="AnoF" id="AnoF">
            <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoF))
			{
				if ($AnoF == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == $AnoActual)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
          </select></td>
      </tr>
      <tr> 
        <td height="28">&nbsp;</td>
        <td colspan="3">
            <input type="button" name="btnVerDia" value="Ver Dia" onClick="Proceso('V');" style="width:70px">
            <input type="button" name="btnModificar" value="Modificar" onClick="Proceso('M')" style="width:70px">
            <input type="button" name="btnEliminar" value="Eliminar" onClick="Proceso('E');" style="width:70px">
            <input type="button" name="btnInprimit" value="Imprimir" onClick="Proceso('I')" style="width:70px">
            <input type="button" name="btnSalir" value="Salir" onClick="Proceso('S')" style="width:70px">
			</td>
      </tr>
    </table>

    
  <br>
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
		<td width="42" align="center" valign="middle">Hora Carga</td>
        <td width="49" align="center" valign="middle">Fecha Analisis</td>
        
        <!-- <td width="40" align="center" valign="middle">Hora</td>-->
        <td width="72" align="center" valign="middle">Hora Anal.</td>
        <td width="36" align="center" valign="middle">% Cu</td>
        <td width="39" align="center" valign="middle">% H2O</td>
        <td width="54" align="center" valign="middle">Fecha Filtracion</td>
        <td width="54" align="center" valign="middle">Hora Filtra.</td>
        <td width="43" align="center" valign="middle">B.A.D.</td>
        <td width="110" align="center" valign="middle">Operador</td>
        <td width="174" colspan="2" align="center" valign="middle">Jefe Tuno</td>
    </tr>
    <?php	
	$Mes    = str_pad($Mes, 2, "0", STR_PAD_LEFT);
	$Dia    = str_pad($Dia, 2, "0", STR_PAD_LEFT);
	$MesF    = str_pad($MesF, 2, "0", STR_PAD_LEFT);
	$DiaF    = str_pad($DiaF, 2, "0", STR_PAD_LEFT);
	$FechaI = $Ano."-".$Mes."-".$Dia;
	$FechaF = $AnoF."-".$MesF."-".$DiaF;
	$sql = "SELECT * from lixiviacion_barro_anodico";
	$sql.=" where (fecha between '".$FechaI."' and '".$FechaF."')  ";
//	$sql.= " where fecha='".$Fecha."'";
	$sql.= " ORDER BY num_lixiviacion,fecha,turno";

	echo "cvomnsulta:".$sql;
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		echo "<tr>\n";
		echo "<td width=1>";
		echo "<input type='radio' name='ChkLixiv' value='".$row["num_lixiviacion"]."'>";
		echo "</td>\n";
		echo "<td height=25 align='center' valign='middle'><input name='TxtNumLixid' readonly type='text' value='".$row["num_lixiviacion"]."' size=7 maxlength=7>";
		echo "<input type='hidden' name='Turno' value='".$row["turno"]."'>\n";
		echo "<input type='hidden' name='Fecha' value='".$row["fecha"]."'></td>\n";
		echo "<td align='center' valign='middle'><input name='TxtLixid'      readonly type='text' size=7  maxlength=7  value='".$row["lixiviador"]."'></td>\n";
		$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase=".$row["turno"];
		$result2 = mysqli_query($link, $sql);
		if ($row2=mysqli_fetch_array($result2))
			$TxtTurno = strtoupper($row2["nombre_subclase"]);
		else	
			$TxtTurno = "N";
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
		else	
			$TxtOperador = "No Encontrado";

		echo "<td align='center' valign='middle'><input name='TxtOperador'   readonly type='text' size=15 maxlength=15 value='".$TxtOperador."'></td>\n";
		$sql = "select * from proyecto_modernizacion.funcionarios where rut = '".$row["jefe_turno"]."'";
		$result2 = mysqli_query($link, $sql);
		if ($row2=mysqli_fetch_array($result2))
			$TxtJefeTurno = ucwords(strtolower(substr($row2["nombres"],0,1).". ".$row2["apellido_paterno"]));
		else	
			$TxtJefeTurno = "No Encontrado";
		
		echo "<td colspan=2 align='center' valign='middle'><input name='TxtJefeturno' readonly type='text' size=15 maxlength=15 value='".$TxtJefeTurno."'></td>\n";
		echo "</tr>\n";
	}
?>
  </table>

</form>
</body>
</html>
