<?php 
	include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 10;
	$Dia = str_pad($Dia,2,0,STR_PAD_LEFT);
	$Mes = str_pad($Mes,2,0,STR_PAD_LEFT);
	$Fecha = $Ano."-".$Mes."-".$Dia;
	$FechaConsulta = $Ano."-".$Mes."-01";
	$Consulta = "select * from sec_web.renovacion_prog_prod ";
	$Consulta.= " where fecha_renovacion = '".$FechaConsulta."' ";
	$Consulta.= " and dia_renovacion = '".intval($Dia)."' ";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		//CONCEPTO = A
		if (($Fila["cod_concepto"] == "A") && ($Fila["fila_renovacion"] == "1"))
		{
			$G_A1 = $Fila["cod_grupo"];
			$DP = $Fila["desc_parcial"];
			$EW = $Fila["electro_win"];
		}
		if (($Fila["cod_concepto"] == "A") && ($Fila["fila_renovacion"] == "2"))
		{
			$G_A2 = $Fila["cod_grupo"];
		}
		if (($Fila["cod_concepto"] == "A") && ($Fila["fila_renovacion"] == "3"))
		{
			$G_A3 = $Fila["cod_grupo"];
		}
		//CONCEPTO = B
		if (($Fila["cod_concepto"] == "B") && ($Fila["fila_renovacion"] == "4"))
		{
			$G_B1 = $Fila["cod_grupo"];
		}
		if (($Fila["cod_concepto"] == "B") && ($Fila["fila_renovacion"] == "5"))
		{
			$G_B2 = $Fila["cod_grupo"];
		}
			if (($Fila["cod_concepto"] == "B") && ($Fila["fila_renovacion"] == "6"))
		{
			$G_B3 = $Fila["cod_grupo"];
		}

		//Concepto C
		if (($Fila["cod_concepto"] == "C") && ($Fila["fila_renovacion"] == "7"))
		{
			$G_C1 = $Fila["cod_grupo"];
		}
		if (($Fila["cod_concepto"] == "C") && ($Fila["fila_renovacion"] == "8"))
		{
			$G_C2 = $Fila["cod_grupo"];
		}
		if (($Fila["cod_concepto"] == "C") && ($Fila["fila_renovacion"] == "9"))
		{
			$G_C3 = $Fila["cod_grupo"];
		}


		
		//CONCEPTO = D
		if (($Fila["cod_concepto"] == "D") && ($Fila["fila_renovacion"] == "10"))
		{
			$G_D1 = $Fila["cod_grupo"];
		}
		if (($Fila["cod_concepto"] == "D") && ($Fila["fila_renovacion"] == "11"))
		{
			$G_D2 = $Fila["cod_grupo"];
		}
		if (($Fila["cod_concepto"] == "D") && ($Fila["fila_renovacion"] == "12"))
		{
			$G_D3 = $Fila["cod_grupo"];
		}	
		if (($Fila["cod_concepto"] == "D") && ($Fila["fila_renovacion"] == "13"))
		{
			$G_D4 = $Fila["cod_grupo"];
		}
		if (($Fila["cod_concepto"] == "D") && ($Fila["fila_renovacion"] == "14"))
		{
			$G_D5 = $Fila["cod_grupo"];
		}
		if (($Fila["cod_concepto"] == "D") && ($Fila["fila_renovacion"] == "15"))
		{
			$G_D6 = $Fila["cod_grupo"];
		}			
		
	}
?>
<html>
<head>
<title>Programa de Renovacion</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "G":
			f.action = "ref_ing_ren_prog_prod01_resp.php?Proceso=G";
			f.submit();
			break;
		case "S":
			window.opener.document.frmPrincipal.action = "Renovacion_grupos_resp.php?opcion=H";
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
	}
}
</script>
<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPopUp" action="" method="post">
  <table width="350" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td width="90"><strong>Fecha:</strong></td>
      <td width="295"> 
        <?php
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	if ((isset($Dia)) && (isset($Mes)) && (isset($Ano)))
	{
		echo "<input type='hidden' name='Dia' value='".$Dia."'>";
		echo "<input type='hidden' name='Mes' value='".$Mes."'>";
		echo "<input type='hidden' name='Ano' value='".$Ano."'>";
		echo str_pad($Dia,2,0,STR_PAD_LEFT)." / ".$Meses[intval($Mes) - 1]." / ".$Ano;
	}
	else
	{		
		echo "<select name='Dia'>\n";
		for ($i=1;$i<=31;$i++)
		{
			if (isset($Dia))
			{
				if ($Dia == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if (date("j") == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
      	echo "</select> <select name='Mes'>\n";
		for ($i=1;$i<=12;$i++)
		{
			if (isset($Mes))
			{
				if (intval($Mes) == $i)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
			else
			{
				if (date("n") == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
      	echo "</select> <select name='Ano'>\n";
		for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++)
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
      	echo "</select>\n";
	}
?>
      </td>
    </tr>
    <tr> 
      <td><strong>Desc. Parcial</strong></td>
      <td><select name="DP">
          <option value="">&nbsp;</option>
          <?php
		$Consulta = "select * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '3101' order by nombre_subclase";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($DP == $Fila["valor_subclase1"])
				echo "<option selected value='".$Fila["valor_subclase1"]."'>".strtoupper($Fila["valor_subclase1"])."</option>\n";
			else
				echo "<option value='".$Fila["valor_subclase1"]."'>".strtoupper($Fila["valor_subclase1"])."</option>\n";
		}
	?>
        </select></td>
    </tr>
    <tr> 
      <td><strong>E.W.</strong></td>
      <td><select name="EW">
          <option value="">&nbsp;</option>
          <?php
		$Consulta = "select * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '3102' order by nombre_subclase";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($EW == $Fila["valor_subclase1"])
				echo "<option selected value='".$Fila["valor_subclase1"]."'>".strtoupper($Fila["valor_subclase1"])."</option>\n";
			else
				echo "<option value='".$Fila["valor_subclase1"]."'>".strtoupper($Fila["valor_subclase1"])."</option>\n";
		}
	?>
        </select></td>
    </tr>
    <tr align="center"> 
      <td colspan="2"> 
        <input type="button" name="Grabar" value="Grabar" style="width:70px;" onClick="Proceso('G')"> 
        <input type="button" name="Submit2" value="Salir" style="width:70px;" onClick="Proceso('S')">
      </td>
    </tr>
  </table>
<br>
  <table width="350" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr align="center" class="ColorTabla01"> 
      <td><strong>Fila</strong></td>
      <td><strong>Concepto</strong></td>
      <td><strong>Grupo</strong></td>
    </tr>
    <tr align="center"> 
      <td width="69">1</td>
      <td width="86">A</td>
      <td width="168"><select name="G_A1">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_A1 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>
    <tr align="center"> 
      <td>2</td>
      <td>A</td>
      <td><select name="G_A2">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_A2 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>
	
	
    <tr align="center"> 
      <td>3</td>
      <td>A</td>
      <td><select name="G_A3">
          <option value="">&nbsp;</option>
		  
          <?php
		  		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_A3 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
		
	?>
        </select></td>
    </tr>
    <tr align="center"> 
      <td>4</td>
      <td>B</td>
      <td><select name="G_B1">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_B1 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>
    <tr align="center"> 
      <td>5</td>
      <td>B</td>
      <td><select name="G_B2">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_B2 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>
	
	
    <tr align="center"> 
      <td>6</td>
      <td>B</td>
      <td><select name="G_B3">
          <option value="">&nbsp;</option>
		  
		  
          <?php	
		  	
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_B3 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
		
	?>
        </select></td>
    </tr>
	
	
	
	    <tr align="center"> 
      <td>7</td>
      <td>C</td>
      <td><select name="G_C1">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_C1 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>

    <tr align="center"> 
      <td>8</td>
      <td>C</td>
      <td><select name="G_C2">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_C2 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>

	    <tr align="center"> 
      <td>9</td>
      <td>C</td>
      <td><select name="G_C3">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_C3 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>


	
    <tr align="center"> 
      <td>10</td>
      <td>D</td>
      <td><select name="G_D1">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_D1 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>
    <tr align="center"> 
      <td>11</td>
      <td>D</td>
      <td><select name="G_D2">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_D2 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>
    <tr align="center"> 
      <td>12</td>
      <td>D</td>
      <td><select name="G_D3">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_D3 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>
    <tr align="center"> 
      <td>13</td>
      <td>D</td>
      <td><select name="G_D4">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_D4 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>
    <tr align="center"> 
      <td>14</td>
      <td>D</td>
      <td><select name="G_D5">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_D5 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>
    <tr align="center"> 
      <td>15</td>
      <td>D</td>
      <td><select name="G_D6">
          <option value="">&nbsp;</option>
          <?php		
		for ($i = 1; $i <= 48; $i++)
		{
			if ($G_D6 == str_pad($i,2,0,STR_PAD_LEFT))
				echo "<option selected value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
			else
				echo "<option value='".str_pad($i,2,0,STR_PAD_LEFT)."'>".str_pad($i,2,0,STR_PAD_LEFT)."</option>\n";
		}
	?>
        </select></td>
    </tr>
  </table>
</form>
</body>
</html>
