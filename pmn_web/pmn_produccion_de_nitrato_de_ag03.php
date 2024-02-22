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
			var StrFecha="";
			var StrElect="";
			var StrTurno="";
			for (i=0;i<f.IdFecha.length;i++)
			{
				if (f.IdFecha[i].checked == true)
				{
					StrElect=f.IdElectrolisis[i].value;
					StrTurno=f.IdTurno[i].value;
					StrFecha=f.IdFecha[i].value;
				}
			}
			StrDia=(StrFecha.substr(8,2));
			StrMes=(StrFecha.substr(5,2));
			StrAno=(StrFecha.substr(0,4));
			window.opener.document.frmPrincipal.action="pmn_produccion_de_nitrato_de_ag.php?Mostrar=S&Ver=O&E="+StrElect + "&D="+StrDia + "&M="+StrMes + "&A="+StrAno + "&Turno="+StrTurno;
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_produccion_de_nitrato_de_ag03.php";
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
			f.action = "pmn_produccion_de_nitrato_de_ag01.php?Proceso=S&parametros=" + valores;
			f.submit();
		}
	}
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">
  <table width="619" border="0" class="TablaDetalle">
    <tr>
    <td width="74">Fecha Incio</td>
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
    <td width="86">Fecha Termino</td>
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
  <table width="754" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="205" height="20" align="center"> Consultar - Eliminar&nbsp; 
        <input type="hidden" name="checkbox" value="" onClick="SeleccionarTodos(this.form)">
      <td width="58"><strong>Fecha</strong></td>
      <td width="54"><strong>Turno</strong></td>
      <td width="102"><strong>Num. Electrolisis.</strong></td>
      <td width="91"><strong>Peso Cristales</strong></td>
      <td width="96"><strong>Volumen Acido</strong></td>
      <td width="131"><strong>Volumen Final</strong></td>
    </tr>
    <?php  
	$Consulta =" select * from pmn_web.produccion_nitrato_ag "; 
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by fecha,num_electrolisis";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdElectrolisis'> \n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	echo "<input type='hidden' name='IdTurno'>\n";
	echo "<input type='hidden' name='IdFecha'>\n";
	$FechaAnt="";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		
		echo "<tr>\n"; 
		echo "<td align='center'>\n";
		echo "<input type='radio' name='IdFecha' value='".$Row["fecha"]."' onClick=\"Proceso('E');\">\n";
		echo ' <------>  ';
		echo "<input type='checkbox' name='checkbox' value='".$Row["fecha"]."' title='Eliminar la Fila' >\n";
		echo "</td>\n";
		echo "<td align='center'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
		switch ($Row[turno])
		{
			case "1":
				echo "<td align='center'>A</td>\n";	
			break;
			case "2":
				echo "<td align='center'>B</td>\n";	
			break;
			case "3":
				echo "<td align='center'>C</td>\n";	
			break;	
		}
		echo "<input type='hidden' name='IdElectrolisis' value='".$Row[num_electrolisis]."'>\n";
		$IdElectrolsis=$Row[num_electrolisis];
		echo "<input type='hidden' name='IdTurno' value='".$Row[turno]."'>\n";
		$IdTurno=$Row[turno];
		echo "<td align='center'>".$Row[num_electrolisis]."&nbsp;</td>\n";	
		echo "<td align='center'>".$Row[peso_cristales]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row[volumen_acido_nitrico]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row[volumen_final]."&nbsp;</td>\n";
		echo "</tr>\n";
		$FechaAnt=$Row["fecha"];
	}
?>
  </table>
</form>
</body>
</html>
