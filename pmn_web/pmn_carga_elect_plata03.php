<?php
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
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
			var StrElectrolisis="";
			for (i=0;i<f.IdFecha.length;i++)
			{
				if (f.IdFecha[i].checked == true)
				{
					StrElectrolisis=f.IdElectrolisis[i].value;
					StrCorrelativo=f.Correlativo[i].value;
					StrGrupo=f.Grupo[i].value;				
					StrTurno=f.Turno[i].value;
					StrFecha=f.IdFecha[i].value;
				}
			}
			StrFecha=StrFecha.split('~');
			StrDia=(StrFecha[0].substr(8,2));
			StrMes=(StrFecha[0].substr(5,2));
			StrAno=(StrFecha[0].substr(0,4));
			window.opener.document.frmPrincipalRpt.action ="pmn_principal_reportes.php?VerElect1=K&DiElect1=" + StrDia + "&MeElect1=" + StrMes + "&AnElect1=" + StrAno+"&Tab3=true&TabElec1=true&NumElectrolisis2="+StrFecha[1]+"&Consulta=S";
			window.opener.document.frmPrincipalRpt.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_carga_elect_plata03.php";
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
//	var valores = ValoresChequeados(f);
	//valores = valores.substr(0,valores.length-1);

	var Valores='';
	for(i=0;i<f.elements.length;i++)
	{
		if(f.elements[i].name=='checkbox' && f.elements[i].checked==true)
			Valores=Valores+f.elements[i].value+"//";
	}
	Valores = Valores.substr(0,Valores.length-2);
	if (Valores == "")	
	{
		alert("No Hay Casillas Seleccionadas");
		return;
	}
	else
	{
		if (confirm("Esta Seguro de Eliminar los Grupos Seleccionados"))
		{
			f.action = "pmn_carga_elec_plata01.php?Proceso=S&parametros=" + Valores;
			f.submit();
		}
	}
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
  <table width="619" border="0" class="TablaDetalle">
    <tr>
    <td width="69" class="titulo_azul">Fecha Incio</td>
    <td width="222"><select name="DiaIniCon" style="width:50px;">
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
    <td width="89" class="titulo_azul">Fecha Termino</td>
    <td width="221"><select name="DiaFinCon" style="width:50px;">
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
        &nbsp; </td>
  </tr>
</table>
<br>
  <table width="620" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="TituloCabeceraAzul"> 
      <td width="184" height="20" align="center"> Consultar - Eliminar&nbsp; 
        <input type="hidden" name="checkbox" value="" onClick="SeleccionarTodos(this.form)">
      <td width="111"><strong>Num. Electrolisis.</strong></td>
      <td width="97"><strong>Fecha</strong></td>
      <td width="87"><strong>Grupo</strong></td>
      <td width="128"><strong>Hornada</strong></td>
    </tr>
    <?php  
	$Consulta =" select * from pmn_web.carga_electrolisis_plata "; 
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by fecha,num_electrolisis";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdElectrolisis'> \n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	echo "<input type='hidden' name='Grupo'>\n";
	echo "<input type='hidden' name='Correlativo'>\n";
	echo "<input type='hidden' name='Turno'>\n";
	echo "<input type='hidden' name='IdFecha'>\n";
	$ElectAnt="";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		
		/*echo "<td align='center'>\n";
		echo "<input type='radio' name='IdElectrolisis' value='".$Row[num_electrolisis]."' onClick=\"Proceso('E');\">\n";*/
		if ($ElectAnt != $Row[num_electrolisis])
		{
			$Consulta="select count(*) as total from pmn_web.carga_electrolisis_plata "; 
			$Consulta.=" where fecha ='".$Row["fecha"]."' AND num_electrolisis = '".$Row[num_electrolisis]."'   ";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$TotalFilas=$Fila["total"];
			echo "<tr>\n"; 
			 /*echo '<td width="89" align="center">---->&nbsp;</td>';*/
			echo "<td align='center' rowspan='".$TotalFilas."'>\n";
			echo "<input type='radio' name='IdFecha' value='".$Row["fecha"]."~".$Row[num_electrolisis]."' class='SinBorde' onClick=\"Proceso('E');\">";
			echo ' <------>  ';
			echo "<input type='checkbox' name='checkbox' value='".$Row["fecha"]."~".$Row[num_electrolisis]."' class='SinBorde' title='Eliminar la Fila' >\n";
			echo "</td>\n";
			echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[num_electrolisis]."&nbsp;</td>\n";			
			echo "<td align='center' rowspan='".$TotalFilas."'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";	
		}
		echo "<input type='hidden' name='IdElectrolisis' value='".$Row[num_electrolisis]."'>\n";
		$IdElectrolisis=$Row[num_electrolisis];
		echo "<input type='hidden' name='Turno' value='".$Row[turno]."'>\n";
		$Turno=$Row[turno];
		echo "<input type='hidden' name='Grupo' value='".$Row["grupo"]."'>\n";
		$Grupo=$Row["grupo"];
		echo "<input type='hidden' name='Correlativo' value='".$Row[correlativo]."'>\n";
		$Correlativo=$Row[correlativo];
		echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
		$IdDia=substr($Row["fecha"],8,2);
		echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
		$IdMes=substr($Row["fecha"],5,2);
		echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
		$IdAno=substr($Row["fecha"],0,4);
		
		echo "<td align='center'>".$Row["grupo"]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row["hornada"]."&nbsp;</td>\n";
		echo "</tr>\n";
		$ElectAnt=$Row[num_electrolisis];
	}
?>
  </table>
</form>
</body>
</html>
