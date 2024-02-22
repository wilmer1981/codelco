<?php
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "E":
			var StrDia="";
			var StrMes="";
			var StrAno="";
			var StrHornada="";
			for (i=1;i<f.IdHornada.length;i++)
			{
				if (f.IdHornada[i].checked == true)
				{
					StrDia=f.IdDia[i].value;
					StrMes=f.IdMes[i].value;
					StrAno=f.IdAno[i].value;
					StrHornada=f.IdHornada[i].value;
				}
			}
			window.opener.document.frmPrincipalRpt.action = "pmn_principal_reportes.php?ConsultaHornoCarg=S&IdDiaHornoCarg=" + StrDia + "&IdMesHornoCarg=" + StrMes + "&IdAnoHornoCarg=" + StrAno + "&IdHornadaHornoCarg=" + StrHornada+ "&Tab2=true&TabHorno1=true";
			window.opener.document.frmPrincipalRpt.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_ing_carga_horno_trof02.php";
			f.submit();
			break;
	}
	
}
function SeleccionarTodos(f)
{
	try{	
		if (f.checkbox[0].checked == true)
			valor = true
		else valor = false;
				
		for(i=1; i<f.checkbox.length; i++)	
			f.checkbox[i].checked = valor;
	}catch(e){
	}
}
function ValoresChequeados(f)
{
	valores = "";
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			valores = valores + f.checkbox[i].value + '~';
	}
	return valores;
}
/************************/
function CantidadChecheado(f)
{
	cont = 0;
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			cont++;
	}	
	return cont;
}
function Eliminar(f)
{   /*var f = document.frmConsulta;*/
	var valores = ValoresChequeados(f);
	valores = valores.substr(0,valores.length-1);

	
	if (valores == "")	
	{
		alert("No Hay Casillas Seleccionadas");
		return;
	}
	else
	{
		if (confirm("Esta Seguro de Eliminar los Grupos Seleccionados"))
		{
			f.action = "pmn_ing_carga_horno_trof01.php?Proceso=S&parametros=" + valores;
			f.submit();
		}
	}
}
</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
  <table width="619" border="0" >
    <tr>
    <td width="74">Fecha Inci<span class="titulo_azul">o</span></td>
    <td width="208"><select name="DiaIniCon" style="width:50px;">
	<?php
	for ($i=1;$i<=31;$i++)
	{
		if (isset($DiaIniCon))
		{
			if ($i == $DiaIniCon)
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
      <select name="MesIniCon" style="width:90px;">
	  <?php
	 for ($i=1;$i<=12;$i++)
	{
		if (isset($MesIniCon))
		{
			if ($i == $MesIniCon)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		else
		{
			if ($i == $MesActual)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
	}
	  ?>
      </select>
      <select name="AnoIniCon" style="width:60px;">
	  <?php
	 for ($i=2002;$i<=date("Y");$i++)
	{
		if (isset($AnoIniCon))
		{
			if ($i == $AnoIniCon)
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
    <td width="86" class="titulo_azul">Fecha Termino</td>
    <td width="211"><select name="DiaFinCon" style="width:50px;">
	<?php
	for ($i=1;$i<=31;$i++)
	{
		if (isset($DiaFinCon))
		{
			if ($i == $DiaFinCon)
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
      <select name="MesFinCon" style="width:90px;">
	  <?php
	  	for ($i=1;$i<=12;$i++)
		{
			if (isset($MesFinCon))
			{
				if ($i == $MesFinCon)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
		}
		?>
      </select>
      <select name="AnoFinCon" style="width:60px;">
	  <?php
	  	for ($i=2002;$i<=date("Y");$i++)
		{
			if (isset($AnoFinCon))
			{
				if ($i == $AnoFinCon)
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
</table>
<br>
  <table width="620" border="0">
    <tr>
    <td align="center">
<input type="button" name="BtnConsultar" value="Consultar" style="width:70px" onClick="Proceso('C');">
      &nbsp; 
        <input name="btneliminar" type="button" id="btneliminar3" value="Eliminar"style="width:70"  onClick="Eliminar(this.form)"> 
	  &nbsp; 
	  <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
    </td>
  </tr>
</table>
<br>
  <table width="620" border="0" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center"  class="TituloCabeceraAzul"> 
      <td width="183">Consultar - Eliminar 
      <input type="hidden" name="checkbox" value="" onClick="SeleccionarTodos(this.form)"></td>
    <td width="83"><strong>Fecha</strong></td>
    <td width="98"><strong>Hornada</strong></td>
    <td width="253"><strong>Observacion</strong></td>
  </tr>
<?php  
	$Consulta = "select distinct(hornada),fecha, observacion from carga_horno_trof ";
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by fecha,hornada";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdHornada'>";
	echo "<input type='hidden' name='IdDia'>";
	echo "<input type='hidden' name='IdMes'>";
	echo "<input type='hidden' name='IdAno'>";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n"; 
		echo "<td align='center'>\n";
		echo "<input type='radio' class='SinBorde' name='IdHornada' value='".$Row["hornada"]."' onClick=\"Proceso('E');\">\n";
		echo ' <------>  ';
		echo "<input type='checkbox' class='SinBorde' name='checkbox' value='".$Row["hornada"]."/".$Row["fecha"]."' title='Eliminar la Fila' >\n";
		echo "</td>\n";
		echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
		echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
		echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
		echo "</td>\n";
		echo "<td align='center'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
		echo "<td align='center'>".$Row["hornada"]."&nbsp;</td>\n";
		echo "<td>".$Row["observacion"]."&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>
</table>
</form>
</body>
</html>
