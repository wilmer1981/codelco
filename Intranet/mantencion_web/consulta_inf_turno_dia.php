<? // include("../conectar.php"); ?>
<html>
<head>
<title>SAM-WEB, Codelco Fundici&oacute;n y Refiner&iacute;a Ventanas</title>
<!-- FUNCIONES -->
<script>
function Consulta()
{
	var f= document.frm_principal;
	var FechaActual = f.AnoActual.value + f.MesActual.value + f.DiaActual.value;
	var FechaConsulta = f.Ano.value + f.Mes.value + f.Dia.value;
	if (FechaConsulta > FechaActual)
	{
		alert("La Fecha de Consulta es Mayor a la Actual");
		f.Dia.focus();
		return;
	}
	var turno = f.Turno.value;
	if (turno=="")
	{
		alert ("debe seleccionar turno");
		f.Turno.focus()
		return;
	}
	//f.action="http://10.56.11.4/archivos/Mantencion/info_turno/inf_"+turno+"_"+FechaConsulta+".xls";
	f.action="../archivos/Mantencion/info_turno/inf_"+turno+"_"+FechaConsulta+".xls";
	f.submit();
}
function Salir()
{
	var f= document.frm_principal;
	//f.action="http://10.56.11.4/index.php?Pagina=menu_dinamico2.php?CodMenu=160";
	f.action="../index.php?Pagina=menu_dinamico2.php?CodMenu=160";
	f.submit();
}
</script>
<style>
<!--a:hover{color:#FF0000;}-->
<!--a{text-decoration:none}-->
</style>
</head>
<body bgcolor="#CCCCCC" text="#000000" link="#336699" vlink="#336699" alink="#336699" leftmargin="10" topmargin="5" onload="JavaScript:frm_principal.Dia.focus()">
<form name="frm_principal" action=""  method="get">
<table border="2" cellpadding="0" cellspacing="0" width="760" height="300">
<tr>
<td>
  <table border="0" cellpadding="0" cellspacing="0" width="741" height="256">
    <!-- fwtable fwsrc="planilla.png" fwbase="planilla.gif" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->

  <tr>
   <td rowspan="2">&nbsp;</td>
    <td colspan="7" valign="top" align="center" bgcolor="#CCCCCC">
      <table width="100%" border="0" cellspacing="2" cellpadding="2" align="center" height="100">
        <tr>
          <td width="50%">
          </td>
          <td width="50%">
            <div align="right"> <font size=1 face="verdana">
              <?
				  	$dia_actual = date("d");
					$mes_actual = date("m"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
				    $ano_actual = date("Y"); //ENTREGA NUMERO DE AÑO DE 4 DIGITOS (2002)
					echo "<input type='hidden' name='DiaActual' value='$dia_actual'>\n";
					echo "<input type='hidden' name='MesActual' value='$mes_actual'>\n";
					echo "<input type='hidden' name='AnoActual' value='$ano_actual'>\n";
					//FUNCION DE FECHA
					$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
					$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  					$str_dia = date("w");
  					$str_dia = $str_dia;
					$dia = date("j");
				  	$mes = date("n");
				  	$mes = $mes - 1;
				  	$ano = date("Y");
				  	echo "$dias[$str_dia] $dia de $meses[$mes] de $ano";
				  	//FIN FUNCION DE FECHA
				?>
              </font> </div>
          </td>
        </tr>
      </table>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td valign="top"> <b><font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#336699"> 
              &nbsp;&nbsp;</font><font size="3" face="Verdana, Arial, Helvetica, sans-serif">Consulta 
              de Informe de Turno Por D&iacute;a</font></b><br>
              <br>
			  <br>
<?
  echo "<table cellpadding=2 cellspacing=1 border=2 bgcolor=#FFE89F bordercolor=#000099 align=center >";
//MES DE CONSULTA

  echo "<tr>\n";
  $dia_actual=date("j");
  $mes_actual=date("n"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
  $ano_actual=date("Y"); //ENTREGA NUMERO DE AÑO DE 4 DIGITOS (2002)
  echo "<td bgcolor='#6060B0'><font face='Verdana,Geneva,Arial,Helvetica,sans-serif' size=1 color='white'>FECHA CONSULTA:</font></td>\n";
  echo "<td>\n";
  echo "<select name='Dia'>\n";
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
		if ($cont_dia == $dia_actual)
		{
			echo "<option value='$cont_dia' selected>&nbsp;".$cont_dia."&nbsp;</option>\n";
		}
		else
		{
			echo "<option value='$cont_dia'>&nbsp;".$cont_dia."&nbsp;</option>\n";
		}
  	}
  echo "</select>\n";
  // MES
  echo "<select name=Mes >\n";
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
		  	echo "<option value='$Valor' selected>&nbsp;$meses[$num_aux]&nbsp;</option>\n";
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
		  	echo "<option value='$Valor' selected>&nbsp;$meses[$num_aux]&nbsp;</option>\n";
	  	}
	  	else
	 	{
		  	echo "<option value='$Valor'>&nbsp;$meses[$num_aux]&nbsp;</option>\n";
	  	}
	}
}
  echo "</select>\n";
  // AÑO (i indica la cantidad de años que me muestra ahora 5 desde el 2001)
  echo "<select name=Ano>\n";
  for ($i=2008; $i<=2015; $i++)
  {
  	if ($opcion==1)
	{
		if ($i==$cmb_ano)
	  	{
		  	echo "<option value='$i' selected>&nbsp;$i&nbsp;</option>\n";
	  	}
	}
	else
	{
		if ($i==$ano_actual)
	  	{
		  	echo "<option value='$i' selected>&nbsp;$i&nbsp;</option>\n";
	  	}
	  	else
	  	{
		  	echo "<option value='$i'>&nbsp;$i&nbsp;</option>\n";
	  	}
	}
  }
  echo "</select>\n";
  echo "</td>";
  echo "<td bgcolor='#6060B0'><font face='Verdana,Geneva,Arial,Helvetica,sans-serif' size=1 color='White'>TURNO: </font></td>\n";
  echo "<td>\n";
  echo "<select name='Turno'>";
  echo "<option value='A' selected> A </option>";
  echo "<option value='B'> B </option>";
  echo "<option value='C'> C </option>";
  echo "<option value='V'> V </option>";
  echo "</select>";
  echo "</td>\n";  
  echo "</tr>";
  echo "</table>";
?>
            </td>
    	  </tr>
    	</table>
    <br>
	    <input type=button value="Ver Informe Turno" onClick="Consulta()" >
	<br><br>
        <input type=button value="Salir" onClick="Salir()">
      </td>
   <td rowspan="2"></td>
   <td></td>
  </tr>
  <tr>
   <td colspan="7">&nbsp;</td>
   <td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
</table>
</form>
</body>
</html>
<? //include("../cerrar.php") ?>
