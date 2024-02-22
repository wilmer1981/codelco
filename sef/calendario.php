<? 
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); 
	if (!isset($Mes))
	{
		$Mes = date("n");
		$Ano = date("Y");
	}
?>
<html>
<head>
<title>Calendario</title>
<link href="estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript">
function Proceso(opt, obj)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "R":
			f.action = "calendario.php";
			f.submit();
			break;
		case "E1":
			obj.style.background="#0030CE";
			obj.style.color="#FFFFFF";
			break;
		case "E2":
			obj.style.background="";
			obj.style.color="";
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="200"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02">
    <td colspan="7"><select name="Mes" onChange="Proceso('R')">
<?
	for ($i=1;$i<=12;$i++)
	{
		if (isset($Mes))
		{
			if ($Mes == $i)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		else
		{
			if (date("n") == $i)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
	}
?>	
    </select>
      <select name="Ano" onChange="Proceso('R')">
<?
	for ($i=date("Y")-2;$i<=date("Y")+1;$i++)
	{
		if (isset($Ano))
		{
			if ($Ano == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if (date("Y") == $i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
?>		  
    </select></td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td>Lun</td>
    <td>Mar</td>
    <td>Mie</td>
    <td>Jue</td>
    <td>Vie</td>
    <td>Sab</td>
    <td>Dom</td>
  </tr>
<?
	$CantDias = date("t", mktime(0,0,0,$Mes,1,$Ano));	
	echo "<tr>\n";
	$PosDiaUno = date("w", mktime(0,0,0,$Mes,1,$Ano));
	if ($PosDiaUno == 0)
		$PosDiaUno = 7;
	$ContPos = $PosDiaUno;
	$PrimerDia = true;	
	for ($Dia=1;$Dia<=$CantDias;$Dia++)
	{  		
		if ($PrimerDia)
		{
			for ($i=1;$i<$PosDiaUno;$i++)
			{
				echo "<td align='center'>&nbsp;</td>\n";
			}
			echo "<td align='center' onMouseOver=\"Proceso('E1',this)\" onMouseOut=\"Proceso('E2',this)\">".$Dia."</td>\n";
			$PrimerDia = false;
		}
		else
		{
			echo "<td align='center' onMouseOver=\"Proceso('E1',this)\" onMouseOut=\"Proceso('E2',this)\">".$Dia."</td>\n";
		}		
		if ($ContPos == 7)
		{
			echo "</tr>\n";
			echo "<tr>\n";
			$ContPos = 0;
		}
		$ContPos = $ContPos + 1;
		if ($Dia == $CantDias)
		{
			$PosDiaFin = date("w", mktime(0,0,0,$Mes,$CantDias,$Ano));
			if ($PosDiaFin == 0)
				$PosDiaFin = 7;
			for ($i=$PosDiaFin;$i<=6;$i++)
			{
				echo "<td align='center'>&nbsp;</td>\n";
			}
		}
	}
	echo "</tr>\n";
?>  
</table>
</form>
</body>
</html>
