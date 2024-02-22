<?php include("../principal/conectar_pmn_web.php");

if(!isset($DiaF))
	$DiaF=date('d');
if(!isset($MesF))
	$MesF=date('m');
if(!isset($AnoF))
	$AnoF=date('Y');
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
		case "S":
			window.close();
			break;
		case "R":
			f.action = "pmn_detalle_deselenizacion.php";
			
			f.submit();
			break;
	}
}

function CargaDatos(RB)
{
	var f = document.frmConsulta;
	var StrDia="";
	var StrFecha="";
	var StrMod="";
	var Horno="";
	var Funda="";
	var HT="";
	var HP="";
	//alert (RB.value);
	var Vector=RB.value.split('~');//0:NumHorno,1:Numfunda;2:HornadaTotal;3:HornadaParcial
	/*alert(Vector[0]);
	alert(Vector[1]);
	alert(Vector[2]);
	alert (Vector[3]);*/

	StrDia=(Vector[4].substr(8,2));
	StrMes=(Vector[4].substr(5,2));
	StrAno=(Vector[4].substr(0,4));
	Strprod=(Vector[5]);
	Strsubp=(Vector[6]);
		/*alert (Vector[4]);
				alert (Vector[5]);*/
	window.opener.document.frmPrincipalRpt.action ="pmn_principal_reportes.php?ModifDese=S&NumHorno01=" + Vector[0] + "&NumFunda01="+Vector[1]+"&HornadaTotal01="+Vector[2] +"&HornadaParcial01="+Vector[3]+"&Dia01=" +StrDia + "&Mes01=" + StrMes + "&Ano01=" + StrAno + "&Prod01=" + Strprod + "&Subp01=" + Strsubp+"&Tab8=true";
	window.opener.document.frmPrincipalRpt.submit();
	window.close();
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
  <table width="650" border="0">
  <tr>
  <td>
  <table width="650" height="20" border="0">
  <tr>
      <td class="TituloCabeceraAzul"><strong class="TituloCabeceraAzul">Detalle Planta de Selenio por D&iacute;a</strong></td>
  </tr>
  </table>
  <table width="650" border="0" cellpadding="3" cellspacing="1" class="TablaInterior">
    <tr> 
      <td width="116" class="titulo_azul">Fecha Inicio: </td>
      <td width="223"><select name="DiaConsulta" style="width:50px">
          <?php				
				for ($i=1;$i<=31;$i++)
				{
					if (isset($DiaConsulta))
					{
						if ($i == $DiaConsulta)
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
        </select> <select name="MesConsulta" style="width:100px">
          <?php				
				for ($i=1;$i<=12;$i++)
				{
					if (isset($MesConsulta))
					{
						if ($i == $MesConsulta)
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
        </select> <select name="AnoConsulta" style="width:60px">
          <?php				
				for ($i=2002;$i<=date("Y");$i++)
				{
					if (isset($AnoConsulta))
					{
						if ($i == $AnoConsulta)
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
      <td width="289" class="titulo_azul">Fecha Termino
        <select name="DiaF" id="select">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaF))
			{
				if ($DiaF == $i)
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
        </select> <select name="MesF" id="select2">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesF))
			{
				if ($MesF == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </select> <select name="AnoF" id="select3">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoF))
			{
				if ($AnoF == $i)
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
    <tr>
      <td>&nbsp;</td>
      <td>
          <input type="button" name="btnVerDia" value="Consultar" onClick="Proceso('R');" style="width:70px">
          &nbsp; 
          <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
          </td>
     </tr>
  </table>
    <table width="650" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="TituloCabeceraAzul"> 
      <td width="44">&nbsp;</td>
      <td width="138" align="center"><strong>Funcionario</strong></td>
      <td width="106" align="center"><strong>Fecha</strong></td>
      <td width="90" align="center"><strong>Hornada</strong></td>
      <td width="77" align="center"><strong>Turno</strong></td>
      <td width="164" align="center"><strong>Prod. Calcina</strong></td>
      <td width="164" align="center"><strong>Otros Productos</strong></td>
    </tr>

	<?php
		
	//echo "<table width='650' border='0' cellpadding='3' cellspacing='0' class='TablaDetalle'>";  
	$Delete = "delete from tmp_hornadas_pta_selenio";
	mysqli_query($link, $Delete);	
	$FechaI = $AnoConsulta."-".$MesConsulta."-".$DiaConsulta;
	$FechaF = $AnoF."-".$MesF."-".$DiaF;
	$Consulta = "select t1.rut, t1.fecha, t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial,t1.turno, t1.prod_calcina, concat(left(t2.nombres,1),'. ',t2.apellido_paterno) as nombre";
	$Consulta.= " from pmn_web.deselenizacion t1 left join proyecto_modernizacion.funcionarios t2 on t1.rut = t2.rut";
	$Consulta.= " where t1.fecha between '".$FechaI."' and '".$FechaF."' ";
	$Consulta.= " order by t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<imput type='hidden' name='CheckModificar'>";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	$indicador1="P";
	$indicador2 ="O";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
			$insertar="INSERT INTO tmp_hornadas_pta_selenio(rut,fecha,num_horno,num_funda,hornada_total,hornada_parcial,turno,prod_calcina,nombre,apellido_paterno,indicador)";			
			$insertar.=" values ('".$Row[rut]."','".$Row["fecha"]."','".$Row[num_horno]."','".$Row[num_funda]."','".$Row[hornada_total]."','".$Row[hornada_parcial]."','".$Row[turno]."','".$Row[prod_calcina]."','".$Row["nombres"]."','".$Row["nombre"]."','".$indicador1."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);	
	}
					//aqui busco otros productos
		$Consulta1 = "select t1.cod_producto,t1.cod_subproducto,t1.rut, t1.fecha, t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial,t1.turno,concat(left(t2.nombres,1),'. ',t2.apellido_paterno) as nombre";
		$Consulta1.= " from pmn_web.observaciones t1 left join proyecto_modernizacion.funcionarios t2 on t1.rut = t2.rut";
		$Consulta1.= " where t1.fecha between '".$FechaI."' and '".$FechaF."' ";
		$Consulta1.= " order by t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial";
		$Respuesta1 = mysqli_query($link, $Consulta1);
		$cal = 0;
		while ($Row1 = mysqli_fetch_array($Respuesta1))
	{
			$insertar1="INSERT INTO tmp_hornadas_pta_selenio(rut,fecha,num_horno,num_funda,hornada_total,hornada_parcial,cod_producto,cod_subproducto,turno,prod_calcina,nombre,apellido_paterno,indicador)";			
			$insertar1.=" values ('".$Row1[rut]."','".$Row1["fecha"]."','".$Row1[num_horno]."','".$Row1[num_funda]."','".$Row1[hornada_total]."','".$Row1[hornada_parcial]."','".$Row1["cod_producto"]."','".$Row1["cod_subproducto"]."','".$Row1[turno]."','".$cal."','".$Row1["nombres"]."','".$Row1["nombre"]."','".$indicador2."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar1);	
	}

//aqui busco otros productos
	$Consulta2 = "select t1.cod_producto,t1.cod_subproducto,t1.indicador,t1.rut, t1.fecha, t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial,t1.turno, t1.prod_calcina,nombre,apellido_paterno as nombre";
	$Consulta2.= " from pmn_web.tmp_hornadas_pta_selenio t1";
	$Consulta2.= " where t1.fecha between '".$FechaI."' and '".$FechaF."' ";
	$Consulta2.= " order by t1.num_horno,t1.num_funda,t1.hornada_total,t1.hornada_parcial";
	//echo $Consulta2."<br>";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	while ($Row2 = mysqli_fetch_array($Respuesta2))
	{
		echo "<tr>\n";
		echo "<td><input type='radio' name='CheckModificar' value='".$Row2[num_horno]."~".$Row2[num_funda]."~".$Row2[hornada_total]."~".$Row2[hornada_parcial]."~".$Row2["fecha"]."~".$Row2["cod_producto"]."~".$Row2["cod_subproducto"]."' onClick='CargaDatos(this);'><input type='hidden' name='fecha' value='".$Row2["fecha"]."' >";
		echo "<input type='hidden' name='IdDia' value='".substr($Row2["fecha"],8,2)."'>\n";
		$IdDia=substr($Row2["fecha"],8,2);
		echo "<input type='hidden' name='IdMes' value='".substr($Row2["fecha"],5,2)."'>\n";
		$IdMes=substr($Row2["fecha"],5,2);
		echo "<input type='hidden' name='IdAno' value='".substr($Row2["fecha"],0,4)."'></td>\n";
		$IdAno=substr($Row2["fecha"],0,4);
		    // <td width="138" align="center"><strong>Funcionario</strong></td>

		echo "<td align='left'>".ucwords(strtolower($Row2["nombre"]))."&nbsp;</td>\n";
		echo "<td>".$Row2["fecha"]."&nbsp;</td>\n";
		echo "<td>".$Row2[num_horno]."-".$Row2[num_funda]."-".$Row2[hornada_total]."-".$Row2[hornada_parcial]."</td>\n";
		$Consulta= "select * from proyecto_modernizacion.sub_clase where cod_clase ='1' and cod_subclase = '".$Row2[turno]."'";
		$Respuesta1=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta1);  
		echo "<td align='center'>".$Fila["nombre_subclase"]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row2[prod_calcina]."&nbsp;</td>\n";
		if ($Row2[indicador]=="O")
		{
			
			if ($Row2["cod_subproducto"]=='23')
			{
				echo "<td align='center'>REMANENTE</td>\n";
			}
			else
			{
				echo "<td align='center'>REPROCESO</td>\n";

			}				
		}
		else
		{
			//echo "<td>&nbsp;</td>\n";
			echo "<td align='center'>-----</td>\n";
		}	
		echo "</tr>\n";
	}
	
?>
</table>
</td>
</tr>
</table>
</form>
</body>
</html>
