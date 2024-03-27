<? include("conectar_principal.php");?>
<html>
<head>
<title>Sistemas Locales - Control de Acceso</title>
<link rel="stylesheet" href="estilos/css_principal.css">
<!-- FUNCIONES -->
<script>
function Consulta(forma, opcion)
{
	var FechaActual = forma.AnoActual.value + forma.MesActual.value + forma.DiaActual.value;
	var FechaInicio = forma.cmb_ano.value + forma.cmb_mes.value + forma.cmb_dia.value;
	var FechaTermino = forma.cmb_ano_fin.value + forma.cmb_mes_fin.value + forma.cmb_dia_fin.value;
	if (FechaInicio > FechaActual)
	{
		alert("La Fecha de Inicio es Mayor a la Actual");
		forma.cmb_dia.focus();
		return;
	}
	if (FechaTermino < FechaInicio)
	{
		alert("La Fecha de Termino es Menor a la Fecha de Inicio");
		forma.cmb_dia_fin.focus();
		return;
	}
	if (FechaTermino > FechaActual)
	{
		alert("La Fecha de Termino es Mayor a la Actual");
		forma.cmb_dia_fin.focus();
		return;
	}
	// FECHA TOPE
	var DiaTope = forma.cmb_dia.value;
	if (forma.cmb_mes.value == 12)
	{
		var MesTope = "01";
	}
	else
	{
		var MesTope = forma.cmb_mes.value;
		MesTope++;
		if (MesTope < 10)
		{
			MesTope = "0" + MesTope;
		}
	}
	if (forma.cmb_mes.value == 12)
	{
		var AnoTope = forma.cmb_ano.value;
		AnoTope++;
	}
	else
	{
		var AnoTope = forma.cmb_ano.value;
	}
	var FechaTope = AnoTope + MesTope + DiaTope;
	if (FechaTermino > FechaTope)
	{
		alert ("La Consulta no Puede ser mayor a 1 MES");
		forma.cmb_dia_fin.focus();
		return;
	}
	if (opcion==1)
	{
		forma.action='control_accesos01.php';
		forma.submit();
	}
	if (opcion==2)
	{
		forma.action='graficos/graf_control_accesos.php';
		forma.submit();
	}
}
function Salir(f)
{
	f.action = "sistemas_usuario.php?CodSistema=99";
	f.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin=3 topmargin=3 marginheight="0" marginwidth="0" >
<form name="frm_principal" action=""  method="post">
  <table width="770" border="0" cellspacing="0" cellpadding="0" class="TablaPrincipal">
    <tr>
      <td height="316" valign="top"> 
        <?
	$dia_actual = date("d");
	$mes_actual = date("m"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
	$ano_actual = date("Y"); //ENTREGA NUMERO DE A�O DE 4 DIGITOS (2002)
	echo "<input type='hidden' name='DiaActual' value='$dia_actual'>\n";
	echo "<input type='hidden' name='MesActual' value='$mes_actual'>\n";
	echo "<input type='hidden' name='AnoActual' value='$ano_actual'>\n";
	//FUNCION DE FECHA
	$dias = array("Domingo","Lunes","Martes","Mi�rcoles","Jueves","Viernes","S�bado");
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  	$str_dia = date("w");
  	$str_dia = $str_dia;
	$dia = date("j");
	$mes = date("n");
	$mes = $mes - 1;
	$ano = date("Y");
  	//FIN FUNCION DE FECHA
  echo "<table width='500' cellpadding=3 cellspacing=0 border=0 align=center class='TablaInterior'>";
//MES DE CONSULTA
  echo "<tr>\n";
  $dia_actual=date("j");
  $mes_actual=date("n"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
  $ano_actual=date("Y"); //ENTREGA NUMERO DE A�O DE 4 DIGITOS (2002)
  echo "<td><font>Fecha Inicio:</font></td>\n";
  echo "<td>\n";
  echo "<SELECT name='cmb_dia'>\n";
	for ($i=1; $i<=31; $i++)
  	{
		if ($i < 10)
		{
			$cont_dia = "0$i";
		}
		else
		{
			$cont_dia = $i;
		}
		echo "<option value='$cont_dia'>&nbsp;".$cont_dia."&nbsp;</option>\n";
  	}
  echo "</SELECT>\n";
  // MES
  echo "<SELECT name=cmb_mes >\n";
  for ($i=1; $i<=12; $i++)
  {
  	  if ($i < 10)
	  {
	  	$Valor = "0$i";
	  }
	  else
	  {
	  	$Valor = $i;
	  }
  	  $num_mes = $mes_actual;
	  $num_aux = $i - 1;
	  if ($opcion==1)
	  {
		if ($i==$cmb_mes)
	  	{
		  	echo "<option value='$Valor' SELECTed>&nbsp;$meses[$num_aux]&nbsp;</option>\n";
	  	}
		else
		{
			echo "<option value='$Valor'>&nbsp;$meses[$num_aux]&nbsp;</option>\n";
		}
	  }
	  else
	  {
	  	if ($i==$num_mes)
	  	{
		  	echo "<option value='$Valor' SELECTed>&nbsp;$meses[$num_aux]&nbsp;</option>\n";
	  	}
	  	else
	 	{
		  	echo "<option value='$Valor'>&nbsp;$meses[$num_aux]&nbsp;</option>\n";
	  	}
	}
}
  echo "</SELECT>\n";
  // A�O (i indica la cantidad de años que me muestra ahora 5 desde el 2001)
  echo "<SELECT name=cmb_ano>\n";
  for ($i=2001; $i<=date('Y')+1; $i++)
  {
  	if ($opcion==1)
	{
		if ($i==$cmb_ano)
	  	{
		  	echo "<option value='$i' SELECTed>&nbsp;$i&nbsp;</option>\n";
	  	}
	}
	else
	{
		if ($i==$ano_actual)
	  	{
		  	echo "<option value='$i' SELECTed>&nbsp;$i&nbsp;</option>\n";
	  	}
	  	else
	  	{
		  	echo "<option value='$i'>&nbsp;$i&nbsp;</option>\n";
	  	}
	}
  }
  echo "</SELECT>\n";
  echo "<SELECT name=HoraIni>";
  for ($i=0;$i<=23;$i++)
  {
  	if ($i < 10)
	{
		$Valor = "0".$i;
	}
	else
	{
		$Valor = $i;
	}
  	echo "<option value='".$Valor."'>".$Valor."</option>";
  }
  echo "</SELECT>";
  echo "<SELECT name=MinIni>";
  for ($i=0;$i<=59;$i++)
  {
  	if ($i < 10)
	{
		$Valor = "0".$i;
	}
	else
	{
		$Valor = $i;
	}
  	echo "<option value='".$Valor."'>".$Valor."</option>";
  }
  echo "</SELECT>";
  echo "<font size=1>HRS.</font>";
  echo "</td>";
  echo "</tr><tr>";
  // FECHA TERMINO
  $dia_actual=date("d");
  $mes_actual=date("n"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
  $ano_actual=date("Y"); //ENTREGA NUMERO DE A�O DE 4 DIGITOS (2002)
  echo "<td><font>Fecha Termino:</font></td>\n";
  echo "<td>\n";
  echo "<SELECT name='cmb_dia_fin'>\n";
	for ($i=1; $i<=31; $i++)
  	{
		if ($i < 10)
		{
			$cont_dia = "0$i";
		}
		else
		{
			$cont_dia = $i;
		}
		if ($i == $dia_actual)
		{
			echo "<option value='$cont_dia' SELECTed>&nbsp;".$cont_dia."&nbsp;</option>\n";
		}
		else
		{
			echo "<option value='$cont_dia'>&nbsp;".$cont_dia."&nbsp;</option>\n";
		}
  	}
  echo "</SELECT>\n";
  // MES
  echo "<SELECT name=cmb_mes_fin >\n";
  for ($i=1; $i<=12; $i++)
  {
  	  if ($i < 10)
	  {
	  	$Valor = "0$i";
	  }
	  else
	  {
	  	$Valor = $i;
	  }
  	  $num_mes = $mes_actual;
	  $num_aux = $i - 1;
	  if ($opcion==1)
	  {
		if ($i==$cmb_mes)
	  	{
		  	echo "<option value='$Valor' SELECTed>&nbsp;$meses[$num_aux]&nbsp;</option>\n";
	  	}
		else
		{
			echo "<option value='$Valor'>&nbsp;$meses[$num_aux]&nbsp;</option>\n";
		}
	  }
	  else
	  {
	  	if ($i==$num_mes)
	  	{
		  	echo "<option value='$Valor' SELECTed>&nbsp;$meses[$num_aux]&nbsp;</option>\n";
	  	}
	  	else
	 	{
		  	echo "<option value='$Valor'>&nbsp;$meses[$num_aux]&nbsp;</option>\n";
	  	}
	}
}
  echo "</SELECT>\n";
  // A�O (i indica la cantidad de años que me muestra ahora 5 desde el 2001)
  echo "<SELECT name=cmb_ano_fin>\n";
  for ($i=2001; $i<=date('Y')+1; $i++)
  {
  	if ($opcion==1)
	{
		if ($i==$cmb_ano)
	  	{
		  	echo "<option value='$i' SELECTed>&nbsp;$i&nbsp;</option>\n";
	  	}
	}
	else
	{
		if ($i==$ano_actual)
	  	{
		  	echo "<option value='$i' SELECTed>&nbsp;$i&nbsp;</option>\n";
	  	}
	  	else
	  	{
		  	echo "<option value='$i'>&nbsp;$i&nbsp;</option>\n";
	  	}
	}
  }
  echo "</SELECT>\n";
  echo "<SELECT name=HoraFin>";
  for ($i=0;$i<=23;$i++)
  {
  	if ($i < 10)
	{
		$Valor = "0".$i;
	}
	else
	{
		$Valor = $i;
	}
	if ($Valor == 23)
	{
  		echo "<option value='".$Valor."' SELECTed>".$Valor."</option>";
	}
	else
	{
		echo "<option value='".$Valor."'>".$Valor."</option>";
	}
  }
  echo "</SELECT>";
  echo "<SELECT name=MinFin>";
  for ($i=0;$i<=59;$i++)
  {
  	if ($i < 10)
	{
		$Valor = "0".$i;
	}
	else
	{
		$Valor = $i;
	}
  	if ($Valor == 59)
	{
  		echo "<option value='".$Valor."' SELECTed>".$Valor."</option>";
	}
	else
	{
		echo "<option value='".$Valor."'>".$Valor."</option>";
	}
  }
  echo "</SELECT>";
  echo "<font size=1>HRS.</font>";
  echo "</td>";
  echo "</tr>";
  echo "</table>";
?><br>

        <table width="500" border="0" cellspacing="0" cellpadding="3" align="center" class="TablaDetalle">
          <tr valign="LEFT"> 
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Usuario</font></td>
            <td align="LEFT"> <SELECT name="USUARIO" style="width:300px;">
                <option value="S">Todos</option>
                <?
	$Consulta = "SELECT distinct(T1.RUT), CONCAT(T2.APELLIDO_PATERNO, ' ', T2.APELLIDO_MATERNO, ' ', T2.NOMBRES) AS NOMBRE ";
	$Consulta.= " FROM proyecto_modernizacion.CONTROL_ACCESO T1 INNER JOIN proyecto_modernizacion.FUNCIONARIOS T2 ON T1.RUT = T2.RUT  ORDER BY NOMBRE";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysql_fetch_array($Respuesta))
	{
		echo "<option value='".$Row[RUT]."'>".$Row["nombre"]."</option>\n";
	}
?>
              </SELECT> </td>
          </tr>
          <tr valign="LEFT"> 
            <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Sistema</font></td>
            <td align="LEFT"> <SELECT name="SISTEMA" style="width:300px;">
                <option value="S">Todos</option>
                <?
	$Consulta = "SELECT * FROM proyecto_modernizacion.SISTEMAS ORDER BY COD_SISTEMA";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysql_fetch_array($Respuesta))
	{
		echo "<option value='".$Row[cod_sistema]."'>".ucwords(strtolower($Row["descripcion"]))."</option>\N";
	}
?>
              </SELECT> </td>
          </tr>
          <tr valign="bottom"> 
            <td height="40" COLSPAN="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>EXTRAS 
              PARA GR�FICO</strong></font></td>
          </tr>
          <tr valign="LEFT"> 
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Tipo 
              Consulta </font></td>
            <td align="LEFT"> <SELECT name="TIPO_CONSULTA">
                <option value="COUNT(DISTINCT(RUT))">CANTIDAD DE PERSONAS</option>
                <option value="COUNT(*)">CANTIDAD DE ACCESOS</option>
              </SELECT> </td>
          </tr>
          <tr valign="LEFT"> 
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Tipo 
              de Grafico</font></td>
            <td align="LEFT"> <SELECT name="TIPO_GRAF">
                <option value="bars">BARRAS</option>
                <option value="lines">LINEAS</option>
                <option value="pie">PIE</option>
                <option value="linepoints">LINEAS Y PUNTOS</option>
                <option value="points">PUNTOS</option>
                <option value="area">AREA</option>
              </SELECT> </td>
          </tr>
        </table>
        <br> <div align="center"> 
          <input name="button" type=button onClick='JavaScript:Consulta(this.form,1)' value='Consulta WEB' >
          <input name="button" type=button onClick='JavaScript:Consulta(this.form,2)' value='Consulta Gr&aacute;fico' >
          <input name="btnSalir" type="button" value="Salir" onClick="JavaScript:Salir(this.form);" style="width:90px">
        </div></td>
    </tr>
  </table>
</form>				                
</body>
</html>
