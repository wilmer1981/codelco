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
			var StrCorr="";
			for (i=0;i<f.IdFecha.length;i++)
			{
				if (f.IdFecha[i].checked == true)
				{					
					StrFecha = f.IdFecha[i].value;			
					StrCorr = f.IdCorrelativo.value;
					StrDia = f.IdDia[i].value;
					StrMes = f.IdMes[i].value;
					StrAno = f.IdAno[i].value;
				}
			}
			window.opener.document.frmPrincipal.action="pmn_produccion_elect_oro.php?Ver=O&D="+StrDia + "&M="+StrMes + "&A="+StrAno;
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_produccion_elect_oro03.php";
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
			f.action = "pmn_produccion_elect_oro01.php?Proceso=S&parametros=" + valores;
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
  <table width="619" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="242" height="20" align="center"> Consultar - Eliminar 
        <input type="hidden" name="checkbox" value="">
      <td width="173"><strong>Fecha</strong></td>
      <td width="195"><strong>Correlativo</strong></td>
    </tr>
    <?php  
	$Consulta =" select * from pmn_web.produccion_electrolisis_oro "; 
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by fecha,correlativo";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdFecha'>\n";
	echo "<input type='hidden' name='IdCorrelativo'>\n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	
	$FechaAnt="";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n"; 	
		if ($FechaAnt != $Row["fecha"])
		{
			$FechaAnt = $Row["fecha"];
			$consulta = "SELECT COUNT(*) AS total FROM pmn_web.produccion_electrolisis_oro";
			$consulta.= " WHERE fecha = '".$Row["fecha"]."'";
			//echo $consulta."<br>";
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			$TotalFila = $row1["total"];

			
			echo "<td align='center' rowspan='".$TotalFila."'>\n";
			echo "<input type='radio' name='IdFecha' value='".$Row["fecha"]."' onClick=\"Proceso('E');\">\n";
			echo ' <------>  ';
			echo "<input type='checkbox' name='checkbox' value='".$Row["fecha"]."' title='Eliminar la Fila'>\n";
			echo "</td>\n";
			echo "<td align='center' rowspan='".$TotalFila."'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";			
		}					
		echo "<td align='center'>".$Row[correlativo]."&nbsp;</td>\n";
			
		echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
		$DiaConsulta=substr($Row["fecha"],8,2);
		echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
		$MesConsulta=substr($Row["fecha"],0,4);
		echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
		$AnoConsulta=substr($Row["fecha"],0,4);
		echo "</tr>\n";
	}
?>
  </table>
</form>
</body>
</html>
