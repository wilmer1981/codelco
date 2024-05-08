<? //include("../conectar.php"); ?>
<html>
<head>
<title>SIM-WEB, CODELCO Fundici&oacute;n y Refiner&iacute;a Ventanas</title>
<!-- FUNCIONES -->
<script>
function Consulta()
{
	var f= document.frm_principal;
	 var meses = new Array(12);
	 meses[0] = "Enero";
	 meses[1] = "Febrero";
	 meses[2] = "Marzo";
	 meses[3] = "Abril";
	 meses[4] = "Mayo";
	 meses[5] = "Junio";
	 meses[6] = "Julio";
	 meses[7] = "Agosto";
	 meses[8] = "Septiembre";
	 meses[9] = "Octubre";
	 meses[10] = "Noviembre";
	 meses[11] = "Diciembre";
	 //var j = (f.Mes.value * 1);
	if (f.Ano.value > f.AnoActual.value)
	{
		alert("La Año de Consulta es Mayor que Año Actual");
		f.Ano.focus();
		return;
	}
	var planilla = "plan_rep_mayor_"+f.Ano.value+".xls";
	//f.action="http://10.56.11.4/archivos/Mantencion/reparacion_mayor/"+planilla;
	f.action="../archivos/Mantencion/reparacion_mayor/"+planilla;
	f.submit();
}
function Volver()
{
	var f= document.frm_principal;
	//f.action='http://10.56.11.4/index.php?Pagina=menu_dinamico2.php?CodMenu=123';
	f.action='../index.php?Pagina=menu_dinamico2.php?CodMenu=123';
	f.submit();
}
</script>
<style>
<!--a:hover{color:#FF0000;}-->
<!--a{text-decoration:none}-->
</style>
</head>
<body bgcolor="#CCCCCC" text="#000000" link="#336699" vlink="#336699" alink="#336699" leftmargin="10" topmargin="5" onload="JavaScript:frm_principal.Ano.focus()">
<form name="frm_principal" action=""  method="get">
  <input type='hidden' name='MesAlfa' value='<? echo $Mes_Alfa; ?>'>
  <table border="2" cellpadding="0" cellspacing="0" width="700" height="280">
  <tr>
  <td>
  <table border="0" cellpadding="0" cellspacing="0" width="650" height="250">
    <!-- fwtable fwsrc="planilla.png" fwbase="planilla.gif" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->
    <tr>
	<td>&nbsp;</td>
  </tr>

  <tr>
   <td colspan="9">&nbsp;</td>
   <td>&nbsp;</td>
  </tr>
  <tr>
   <td rowspan="2">&nbsp;</td>
    <td colspan="7" valign="top" align="center" bgcolor="#CCCCCC">
            <div align="right"> <font size=1 face="verdana">
              <?
					$mes_actual = date("m"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
				    $ano_actual = date("Y"); //ENTREGA NUMERO DE AÑO DE 4 DIGITOS (2002)
					echo "<input type='hidden' name='MesActual' value='$mes_actual'>\n";
					echo "<input type='hidden' name='AnoActual' value='$ano_actual'>\n";
					//FUNCION DE FECHA
					$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				  	$mes = date("n");
				  	$mes = $mes - 1;
				  	$ano = date("Y");
				  	echo "$meses[$mes] de $ano";
				  	//FIN FUNCION DE FECHA
				?>
              </font> </div>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
		<tr><td>&nbsp;</td></tr>
          <tr>
            <td valign="top"> <b><font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#336699">
              &nbsp;&nbsp;</font><font size="3" face="Verdana, Arial, Helvetica, sans-serif">Plan Reparaciones
              Mayores</font></b><br>
              <br>
			  

<?

  echo "<table cellpadding=2 cellspacing=1 border=1 bgcolor=#FFE89F bordercolor=#000099 align=center >";
//MES DE CONSULTA
  echo "<tr>\n";
  $mes_actual=date("n"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
  $ano_actual=date("Y"); //ENTREGA NUMERO DE AÑO DE 4 DIGITOS (2002)
 echo "<td bgcolor='#6060B0'><font face='Verdana,Geneva,Arial,Helvetica,sans-serif' size=1 color='white'>AÑO  A CONSULTAR</font></td>\n";
 echo "<td> &nbsp;</td>";
 echo "<td>\n";
  // AÑO (i indica la cantidad de años que me muestra ahora 5 desde el 2001)
  echo "<select name=Ano>\n";
  for ($i=2007; $i<=2016; $i++)
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
  echo "</tr>";
  echo "</table>";
?>
            </td>
    	  </tr>
    	</table>
    <br>
	    <input type=button value="Ver Informe" onClick="Consulta()" >
	<br><br>
	    <input type=button value="Salir" onClick="Volver()" >
      </td>
   <td rowspan="2">&nbsp;</td>
   <td>&nbsp;</td>
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
