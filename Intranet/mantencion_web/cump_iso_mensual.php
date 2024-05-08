<? //include("../conectar.php"); ?>
<html>
<head>
<title>SAM-WEB, Codelco División Ventanas</title>
<!-- FUNCIONES -->
<Script>
function Volver()
{
	var f= document.frm_principal;
	//f.action='http://10.56.11.4/index.php?Pagina=menu_dinamico2.php?CodMenu=124';
	f.action='../index.php?Pagina=menu_dinamico2.php?CodMenu=124';
	f.submit();
}

function Valida()
{
  var largo = 0;
  var f = document.frm_principal;
  largo = f.cmb_mes_i.value.length;
  
  if (largo==1)
  		largo = "0"+f.cmb_mes_i.value;
		else
		largo = f.cmb_mes_i.value;
  if (f.cmb_cc.value==-1)
  {
	alert("Debe escojer el area");
	f.cmb_cc.focus();
	return;
  }
  var ccosto = f.cmb_cc.value;
  var Ano =  f.cmb_ano_i.value;
  //alert (ccosto+"_"+largo+"_"+Ano+".ppt");
  //f.action="http://10.56.11.9/proyecto/sam_web/cump_iso_mes/"+ccosto+"_"+largo+"_"+Ano+".ppt";
  f.action="../archivos/Mantencion/cump_iso_mes/"+ccosto+"_"+largo+"_"+Ano+".ppt";
  f.submit();
}
</Script>
</head>
<body bgcolor="#CCCCCC" text="#336699" link="#336699" vlink="#336699" alink="#336699" leftmargin="10" topmargin="5" Onload="JavaScript:document.frm_principal.cmb_cc.focus()">
<form name="frm_principal" action=""  method="get">
  <input type="hidden" name="Mes" value="<? $Mes; ?>">

 <table border="2" cellpadding="0" cellspacing="0" width="800" height="300">
 <tr>
 <td>
  <table border="0" cellpadding="0" cellspacing="0" width="741" height="256">
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
      <table width="100%" border="0" cellspacing="2" cellpadding="2" align="center" height="80">
        <tr>
          <td width="50%">
          </td>
          <td width="50%">
            <div align="right"> <font size=1 face="verdana" color="#336699">
              <?
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
            <td valign="top"> <b><font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000000">
			&nbsp;&nbsp;Informe Mensual Cumplimiento Iso</font><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#000000"></font></b><br>
              <br>
			  <br>
<?
  echo "<table cellpadding=1 cellspacing=1 border=1 bgcolor=#ffe89f bordercolor=#000099 align='center'>\n";
  echo "<tr>\n";
  echo "<td align=center bgcolor=#6060b0>";
  //CC
  echo "<b><font face=verdana style='font-size: 9pt; color=#ffffff; font-weight: bold;'>Areas: </font></b>";
  echo "</td>";
  echo "<td>";
  echo "<select name=cmb_cc>\n";
  echo "<option value='-1'>[Seleccionar]</option>\n";
  echo "<option value='ref'>Refineria Electrolitica</option>\n";
  echo "<option value='pmn'>Planta Metales Nobles</option>\n";
  echo "<option value='fun'>Fundicion</option>\n";
  echo "<option value='cte'>Central Termica y Planta de Oxigeno</option>\n";
  echo "<option value='pac'>Planta Acido</option>\n";
  echo "<option value='raf'>Refino a Fuego</option>\n";
  echo "<option value='ram'>Recep. Almacenamiento  y Mezcla</option>\n";
  echo "</select>\n";
  echo "</td>";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "<td align=center bgcolor=#6060b0>";
  //CC
  echo "<b><font face=verdana style='font-size: 9pt; color=#ffffff; font-weight: bold;'>Periodo: </font></b>";
  echo "</td>";
  echo "<td>";
  $mes_ini=date("m"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
  $ano_ini=date("Y"); //ENTREGA NUMERO DE AÑO DE 4 DIGITOS (2002)
  // MES
  echo "<select name=cmb_mes_i>\n";
  for ($i=1; $i<=12; $i++)
  {
	  if ($i==1)
	  {
		  $str_mes='ENERO';
	  }
	  elseif ($i==2)
	  {
		  $str_mes='FEBRERO';
	  }
	  elseif ($i==3)
	  {
		 $str_mes='MARZO';
	  }
	  elseif ($i==4)
	  {
		  $str_mes='ABRIL';
	  }
	  elseif ($i==5)
	  {
		  $str_mes='MAYO';
	  }
	  elseif ($i==6)
	  {
		  $str_mes='JUNIO';
	  }
	  elseif ($i==7)
	  {
		  $str_mes='JULIO';
	  }
	  elseif ($i==8)
	  {
		  $str_mes='AGOSTO';
	  }
	  elseif ($i==9)
	  {
		  $str_mes='SEPTIEMBRE';
	  }
	  elseif ($i==10)
	  {
		  $str_mes='OCTUBRE';
	  }
	  elseif ($i==11)
	  {
		  $str_mes='NOVIEMBRE';
	  }
	  elseif ($i==12)
	  {
		  $str_mes='DICIEMBRE';
	  }
	  if ($opc==1)
	  {
		if ($i==$cmb_mes_i)
	  	{
		  	echo "<option value='$i' selected>&nbsp;$str_mes&nbsp;</option>\n";
	  	}
	  	else
	 	{
		  	echo "<option value='$i'>&nbsp;$str_mes&nbsp;</option>\n";
	  	}
	  }
	  else
	  {
	  	if ($i==$mes_ini)
	  	{
		  	echo "<option value='$i' selected>&nbsp;$str_mes&nbsp;</option>\n";
	  	}
	  	else
	 	{
		  	echo "<option value='$i'>&nbsp;$str_mes&nbsp;</option>\n";
	  	}
	}
}
  echo "</select>\n";
  // AÑO (i indica la cantidad de años que me muestra ahora 5 desde el 2001)
  $AnoM = date("Y");
  echo "<select name=cmb_ano_i>\n";
  //for ($i=1999; $i<=2015; $i++)
  for ($i=2008; $i<=$AnoM;$i++)
  {
  	if ($opc==1)
	{
		if ($i==$cmb_ano_i)
	  	{
		  	echo "<option value='$i' selected>&nbsp;$i&nbsp;</option>\n";
	  	}
	  	else
	  	{
		  	echo "<option value='$i'>&nbsp;$i&nbsp;</option>\n";
	  	}
	}
	else
	{
		if ($i==$ano_ini)
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
   echo "</td>\n";
   echo "</tr>\n";
   echo "</table>\n";
   echo "</td>\n";
   echo "</tr>\n";
   echo "</table>\n";
?>
   <br>
	<input type=button value="Ver Archivo" onClick="Valida()" >
	<br><br>
        <input type=button value="Salir" onClick="Volver()">
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
