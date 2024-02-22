<?
	$CodigoDeSistema = 13;
	$CodigoDePantalla =2; 
	include("../principal/conectar_principal.php");
	include("../principal/conectar_sef_web.php");	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "C":	
			if (f.TipoInforme.value == "S")
			{
				alert("Debe seleccionar Tipo de Informe");
				f.TipoInforme.focus();
				return;
			}
			if (!f.VerTodosPeriodos.checked && !f.VerTurno.checked && !f.VerDiario.checked && !f.VerSemanal.checked && !f.VerMensual.checked)
			{
				alert("Debe seleccionar Periodo (turno, diario, etc.)");
				return;
			}
			if (!f.VerTodosAnalisis.checked && !f.VerLeyes.checked && !f.VerImpurezas.checked)
			{
				alert("Debe seleccionar Leyes o Impurezas");
				return;
			}
			if (!f.ChkLeyes.checked && !f.ChkFinos.checked)
			{
				alert("Debe seleccionar Leyes o Finos");
				return;
			}						
			f.action =	"sef_con_generica_web.php";
			f.submit();
			break;
		case "E":	
			if (f.TipoInforme.value == "S")
			{
				alert("Debe seleccionar Tipo de Informe");
				f.TipoInforme.focus();
				return;
			}
			if (!f.VerTodosPeriodos.checked && !f.VerTurno.checked && !f.VerDiario.checked && !f.VerSemanal.checked && !f.VerMensual.checked)
			{
				alert("Debe seleccionar Periodo (turno, diario, etc.)");
				return;
			}
			if (!f.VerTodosAnalisis.checked && !f.VerLeyes.checked && !f.VerImpurezas.checked)
			{
				alert("Debe seleccionar Leyes o Impurezas");
				return;
			}
			if (!f.ChkLeyes.checked && !f.ChkFinos.checked)
			{
				alert("Debe seleccionar Leyes o Finos");
				return;
			}						
			f.action =	"sef_con_generica_excel.php";
			f.submit();
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=13";
			f.submit();
			break;
	}
}

function Recarga()
{
	var f = document.frmPrincipal;
	f.action = "sef_con_generica.php";
	f.submit();
}
</script>
</head>

<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<? include("../principal/encabezado.php"); ?>
  <table width="770" height="315" border="0" cellpadding="3" cellspacing="3" class="TablaPrincipal">
    <tr>
      <td valign="top">
<table width="650" height="165" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="69" height="26">Informe</td>
            <td width="468"><SELECT name="TipoInforme">
                <option value="S" SELECTed>Seleccionar</option>
                <option value="1">Produccion Blister</option>
				<option value="2">Carga Fria a C.P.S.</option>
				<option value="3">Escoria Retorno C.P.S. a Pozo</option>
				<option value="4">Metal Blanco C.T. a C.P.S.</option>
				<option value="5">Escoria Retorno C.T. a H.E.T.E.</option>
				<option value="6">Escoria H.E.T.E. a Botadero</option>
				<option value="7">Metal Blanco H.E.T.E. a C.P.S.</option>
				<option value="8">Metal Blanco H.E.T.E. a C.T.</option>
				<option value="9">Escoria y Metal Blanco H.E.T.E. a Pozo</option>
				<!--<option value="10">Polvos Miljo</option>
				<option value="11">Polvos Pepa</option>-->
              </SELECT></td>
          </tr>
          <tr>
            <td height="32">Periodo</td>
            <td height="32"><SELECT name="DiaIni" style="width:50px;">
              <?
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == 1)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
            </SELECT>
              <SELECT name="MesIni" style="width:90px;">
                <?
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
              </SELECT>
              <SELECT name="AnoIni" style="width:60px;">
                <?
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
              </SELECT>
AL
<SELECT name="DiaFin" style="width:50px;">
  <?
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
</SELECT>
<SELECT name="MesFin" style="width:90px;">
  <?
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
</SELECT>
<SELECT name="AnoFin" style="width:60px;">
  <?
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
</SELECT></td>
          </tr>
          <tr>
            <td height="29">Ver Datos </td>
            <td height="29" valign="middle">              <input name="VerTodosPeriodos" type="checkbox" id="VerTodosPeriodos" value="S" checked>
              Todos              
              <input name="VerTurno" type="checkbox" id="VerTurno" value="S">
Por Turno
  <input name="VerDiario" type="checkbox" id="VerDiario" value="S">
Diarios
<input name="VerSemanal" type="checkbox" id="VerSemanal" value="S">
Semanales
<input name="VerMensual" type="checkbox" id="VerMensual" value="S">
Mensuales</td>
          </tr>
          <tr>
            <td height="29">Ver Analisis </td>
            <td height="29" valign="middle"><input name="VerTodosAnalisis" type="checkbox" id="VerTodosAnalisis" value="S" checked>
              Todos              
              <input name="VerLeyes" type="checkbox" id="VerLeyes2" value="S">
Leyes(Cu, Ag, Au)
  <input name="VerImpurezas" type="checkbox" id="VerImpurezas2" value="S">
Impurezas</td>
          </tr>
          <tr>
            <td height="29">Calculos</td>
            <td height="29" valign="middle"><input name="ChkLeyes" type="checkbox" id="ChkLeyes3" value="S" checked>
LEYES
  <input name="ChkFinos" type="checkbox" id="ChkFinos2" value="S">
FINOS </td>
          </tr>
          <tr> 
            <td height="49" colspan="2" align="center">&nbsp;  </td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input name="BtnConsultar" type="button" value="Consultar" style="width:70px" onClick="Proceso('C');">
              <input name="BtnExcel" type="button" id="BtnExcel" style="width:70px" onClick="Proceso('E');" value="Excel">
              <input name="BtnSalir" type="button" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
          </tr>
        </table>
      <br>
      </td>
    </tr>
</table>
<? include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
