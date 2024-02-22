<?php
include("../principal/conectar_pmn_web.php");

if(isset($_REQUEST["AnoIniCon"])){
	$AnoIniCon = $_REQUEST["AnoIniCon"];
}else{
	$AnoIniCon = "";
}
if(isset($_REQUEST["MesIniCon"])){
	$MesIniCon = $_REQUEST["MesIniCon"];
}else{
	$MesIniCon = "";
}
if(isset($_REQUEST["DiaIniCon"])){
	$DiaIniCon = $_REQUEST["DiaIniCon"];
}else{
	$DiaIniCon = "";
}
if(isset($_REQUEST["AnoFinCon"])){
	$AnoFinCon = $_REQUEST["AnoFinCon"];
}else{
	$AnoFinCon = "";
}
if(isset($_REQUEST["MesFinCon"])){
	$MesFinCon = $_REQUEST["MesFinCon"];
}else{
	$MesFinCon = "";
}
if(isset($_REQUEST["DiaFinCon"])){
	$DiaFinCon = $_REQUEST["DiaFinCon"];
}else{
	$DiaFinCon = "";
}

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
			var StrFecha="";
			for (i=1;i<f.IdFecha.length;i++)
			{
				if (f.IdFecha[i].checked == true)
				{
					/*StrDia=f.IdDia[i].value;
					StrMes=f.IdMes[i].value;
					StrAno=f.IdAno[i].value;*/
					StrFecha=f.IdFecha[i].value;
				}
			}
			StrDia=(StrFecha.substr(8,2));
			StrMes=(StrFecha.substr(5,2));
			StrAno=(StrFecha.substr(0,4));
			window.opener.document.FrmIngOro.action = "pmn_oro_compra.php?Tab1=true&TabOC=true&VerOro=S&IdDiaOro=" + StrDia + "&IdMesOro=" + StrMes + "&IdAnoOro=" + StrAno + "&IdFechaOro=" + StrFecha;
			window.opener.document.FrmIngOro.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action ="pmn_ing_oro_compra02.php";
			f.submit();
			break;
		case "Excel":
			f.action="pmn_xls_ing_oro_compra.php?DiaIniCon="+f.DiaIniCon.value +"&AnoIniCon="+f.AnoIniCon.value +"&MesIniCon="+f.MesIniCon.value+"&DiaIniCon="+f.DiaFinCon.value +"&AnoFinCon="+f.AnoFinCon.value +"&MesFinCon="+f.MesFinCon.value;
			f.target="_blank";
			f.submit();	
		break;
		case "I":
		window.print();
		break;		
	}
	
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
  <table width="748" border="0" class="TablaDetalle">
    <tr>
    <td width="76" class="titulo_azul">Fecha Incio</td>
    <td width="215"><select name="DiaIniCon" style="width:50px;">
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
    <td width="350"><select name="DiaFinCon" style="width:50px;">
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
  <table width="750" border="0">
    <tr>
    <td width="744" align="center">
<input type="button" name="BtnConsultar" value="Consultar" style="width:70px" onClick="Proceso('C');">
        &nbsp; 
        <input name="BtnExcel" type="button" id="BtnExcel" style="width:70px" onClick="Proceso('Excel');" value="Excel">
        &nbsp; 
        <input name="BtnExcel2" type="button" id="BtnExcel2" style="width:70px" onClick="Proceso('I');" value="Imprimir"> 
        &nbsp; 
        <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
    </td>
  </tr>
</table>
<br>
  <table width="1039" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="TituloCabeceraAzul"> 
      <td width="24">&nbsp;</td>
      <td width="135"><strong>Fecha</strong></td>
      <td width="72"><strong>Num Barra</strong></td>
      <td width="89"><strong>Peso Barra</strong></td>
      <td width="92"><strong>Ley Oro</strong></td>
      <td width="76"><strong>Peso Fino Oro</strong></td>
      <td width="70"><strong>Ley Plata</strong></td>
      <td width="81"><strong>Peso Fino Plata</strong></td>
      <td width="81"><strong>Rut Origen</strong></td>
      <td width="297"><strong>Observacion</strong></td>
    </tr>
    <?php  
	$Consulta="select * from pmn_web.ingreso_oro_compra ";
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by correlativo,num_barra";
	$Respuesta=mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdFecha'>\n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	$FechaAnt="";
	$TotalPeso=0;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n"; 
		echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
		$IdDia=substr($Row["fecha"],8,2);
		echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
		$IdMes=substr($Row["fecha"],5,2);
		echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
		$IdAno=substr($Row["fecha"],0,4);
		if ($FechaAnt!=$Row["fecha"])
		{
			$Consulta="select count(*) as total from pmn_web.ingreso_oro_compra  ";
			$Consulta.=" where fecha='".$Row["fecha"]."'	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$TotalFilas=$Fila["total"];
			//echo $TotalFilas."<br>";
			echo "<td align='center' rowspan='".$TotalFilas."'>\n";
			echo "<input type='radio' name='IdFecha' value='".$Row["fecha"]."' onClick=\"Proceso('E');\">\n";
			echo "</td>\n";
			echo "<td align='center' rowspan='".$TotalFilas."'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
		}
		echo "<td align='left'>".$Row["num_barra"]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row["peso_barra"]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row["ley_oro"]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row["peso_oro"]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row["ley_plata"]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row["peso_plata"]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row["rut_origen"]."&nbsp;</td>\n";		
		echo "<td align='left'>".$Row["observacion"]."&nbsp;</td>\n";
		echo "</tr>\n";
		$FechaAnt=$Row["fecha"];
		$TotalPeso = $TotalPeso+$Row["peso_barra"];
	}
	echo "<tr>";
		echo "<td>";
		echo "</td>";
		echo "<td align='right'><strong>Total</strong></td>";									
		echo "<td align='center' colspan='2'><strong>";
		echo $TotalPeso;
		echo "</strong></td>";
	echo "</tr>";
?>
  </table>
</form>
</body>
</html>
