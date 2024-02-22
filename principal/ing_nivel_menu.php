<?php 
	include("conectar_principal.php");
?>
<html>
<head>
<title>Sistemas Locales</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "G": //GRABAR
			if (f.Sistema.value == "S")
			{
				alert("Debe seleccionar un sistema");
				f.Sistema.focus();
				return;
			}
			if (f.Nivel.value == "S")
			{
				alert("Debe seleccionar un Nivel del Sistema");
				f.Nivel.focus();
				return;
			}
			if (f.CodPantalla.value == "S")
			{
				alert("Debe seleccionar una pantalla");
				f.CodPantalla.focus();
				return;
			}
			if (f.NivelAgrup.value == "S")
			{
				alert("Debe seleccionar el Nivel en que quedar� la pantalla en el Men�");
				f.NivelAgrup.focus();
				return;
			}
			if (f.PantAgrup.value == "S")
			{
				alert("Debe seleccionar la pantalla de nivel superior de la que depende la nueva");
				f.PantAgrup.focus();
				return;
			}
			f.action = "ing_pantalla01.php?Proceso=G";
			f.submit();
			break
		case "M":  //MODIFICAR
			if (f.Sistema.value == "S")
			{
				alert("Debe seleccionar un sistema");
				f.Sistema.focus();
				return;
			}
			if (f.Nivel.value == "S")
			{
				alert("Debe seleccionar un Nivel del Sistema");
				f.Nivel.focus();
				return;
			}
			URL = "ing_pantalla02.php?Proceso=M&Sistema=" + f.Sistema.value + "&Nivel=" + f.Nivel.value;
			window.showModalDialog(URL,"top=10,left=50,width=500,heigth=400,scrollbars=YES, recizable=YES");			
			break
		case "S": //SALIR
			f.action = "sistemas_usuario.php?CodSistema=99";
			f.submit();
			break
	}	
}
function Recarga()
{
	var f = document.frmPrincipal;
	f.action = "ing_pantalla.php",
	f.submit();
	
}
//-->
</script>

</head>

<body>
<form name="frmPrincipal" method="post" action="">
<?php include("encabezado.php");?>
  <table width="780" border="0" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr> 
      <td width="780" align="center" valign="top"><br>
        <table width="650" height="143" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="132" height="30">Sistema </td>
            <td width="397"><select name="Sistema" style="width:300" onChange="Recarga();">
                <option value="S">Seleccionar</option>
                <?php
			$sql = "select * from sistemas order by cod_sistema";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_array($result))
			{
				if ($Sistema == $row[cod_sistema])
				{
					echo "<option value='".$row[cod_sistema]."' selected>".strtoupper($row["nombre"])." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
				}
				else
				{
					echo "<option value='".$row[cod_sistema]."'>".strtoupper($row["nombre"])." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
				}
			}
		?>
              </select></td>
          </tr>
          <tr> 
            <td height="25">Nivel de Acceso</td>
            <td><select name="Nivel" style="width:300" onChange="Recarga();">
                <option value="S">Seleccionar</option>
                <?php	
		  	$sql = "select * from niveles_por_sistema where cod_sistema = ".$Sistema." order by nivel";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_array($result))
			{
				if ($Nivel == $row[nivel])
				{
					echo "<option value='".$row[nivel]."' selected>".$row[nivel]." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
				}
				else
				{
					echo "<option value='".$row[nivel]."'>".$row[nivel]." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
				}
			}
		  ?>
              </select></td>
          </tr>
          <tr> 
            <td height="24">C&oacute;digo Pantalla</td>
            <td><select name="CodPantalla" style="width:300">
                <option value="S">Seleccionar</option>
                <?php 
				$sql = "select * from pantallas where cod_sistema = ".$Sistema." order by cod_pantalla";
				$result = mysqli_query($link, $sql);
				while ($row = mysqli_fetch_array($result))
				{
					if ($CodPantalla == $row[cod_pantalla])
					{
						echo "<option selected value='".$row[cod_pantalla]."'>".$row[cod_pantalla]." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
					}
					else
					{
						echo "<option value='".$row[cod_pantalla]."'>".$row[cod_pantalla]." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
					}
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td height="25">Nivel de Men&uacute;</td>
            <td><select name="NivelAgrup" onChange="JavaScript:Recarga();" style="width:300px">
                <option value="S" selected>Seleccionar</option>
                <?php
					$sql = "select * from sub_clase where cod_clase = 5 order by cod_subclase";
					$result = mysqli_query($link, $sql);
					while ($row = mysqli_fetch_array($result))
					{
						if ($NivelAgrup == $row["cod_subclase"])
						{
							echo "<option selected value='".$row["cod_subclase"]."'>".$row["cod_subclase"]." - ".$row["nombre_subclase"]."</option>\n";
						}
						else
						{
							echo "<option value='".$row["cod_subclase"]."'>".$row["cod_subclase"]." - ".$row["nombre_subclase"]."</option>\n";
						}
					}
				?>
              </select></td>
          </tr>
          <tr> 
            <td height="39">Depende de <img src="imagenes/left-flecha.gif" width="11" height="11"></td>
            <td><select name="PantAgrup" style="width:300">
                <?php 
				if ((isset($NivelAgrup)) && ($NivelAgrup != "S"))
				{
					if ($NivelAgrup == 0)
					{
						echo "<option value='0'>No Tiene Dependencia</option>\n";
					}
					else
					{					
						echo "<option value=S'>Seleccionar</option>\n";
						$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2";
						$sql.= " where t1.cod_sistema = ".$Sistema;
						$sql.= " and t1.cod_sistema = t2.cod_sistema";
						$sql.= " and t1.cod_pantalla = t2.cod_pantalla";
						$sql.= " and t1.nivel = ".$Nivel;
						$sql.= " and t1.nivel_agrup < ".$NivelAgrup;
						$sql.= " and t1.nivel_agrup > ".($NivelAgrup - 2);
						$sql.= " order by t1.cod_pantalla";
						$result = mysqli_query($link, $sql);
						while ($row = mysqli_fetch_array($result))
						{
							if ($PantAgrup = $row[cod_pantalla])
							{
								echo "<option value='".$row[cod_pantalla]."'>".$row[cod_pantalla]." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
							}
							else
							{
								echo "<option value='".$row[cod_pantalla]."'>".$row[cod_pantalla]." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
							}
						}			
					}
				 }
				 else
				 {
				 	echo "<option value=S'>Seleccionar</option>\n";	
				 }
			  ?>
              </select>
              (Pant. Nivel Superior) </td>
          </tr>
        </table>
        <br> <table border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td colspan="6" class="ColorTabla01">Diagrama de Men� Seg�n Sistema 
              y Nivel de Acceso</td>
          </tr>
          <?php
if (((isset($Nivel)) && ($Nivel != "S")) && ((isset($Sistema)) && ($Sistema != "S")))
{
  	$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
	$sql.= " where t1.cod_sistema = ".$Sistema;
	$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
	$sql.= " and t1.cod_sistema = t2.cod_sistema ";
	$sql.= " and t1.nivel = ".$Nivel;
	$sql.= " and t1.nivel_agrup = 0";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		echo "<tr>\n";
		echo "<td><img src='imagenes/left-flecha.gif'><font color='#FFFFFF'>".ucwords(strtolower($row["descripcion"]))."</font></td>\n";
		echo "<td colspan=5>&nbsp;</td>";
		echo "</tr>";
		$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
		$sql.= " where t1.cod_sistema = ".$Sistema;
		$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
		$sql.= " and t1.cod_sistema = t2.cod_sistema ";
		$sql.= " and t1.nivel = ".$Nivel;
		$sql.= " and t1.nivel_agrup = 1 ";
		$sql.= " and t1.cod_pant_agrup = ".$row[cod_pantalla];
		$result1 = mysqli_query($link, $sql);
		while ($row1 = mysqli_fetch_array($result1))
		{	
			echo "<tr>\n";
			echo "<td>&nbsp;</td>";
			echo "<td><img src='imagenes/left-flecha.gif'><font color='#FFFFFF'>".ucwords(strtolower($row1["descripcion"]))."</font></td>";
			echo "<td colspan=4>&nbsp;</td>";
			echo "</tr>";
			$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
			$sql.= " where t1.cod_sistema = ".$Sistema;
			$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
			$sql.= " and t1.cod_sistema = t2.cod_sistema ";
			$sql.= " and t1.nivel = ".$Nivel;
			$sql.= " and t1.nivel_agrup = 2 ";
			$sql.= " and t1.cod_pant_agrup = ".$row1[cod_pantalla];
			$result2 = mysqli_query($link, $sql);
			while ($row2 = mysqli_fetch_array($result2))
			{
				echo "<tr>\n";
				echo "<td colspan=2>&nbsp;</td>";
				echo "<td><img src='imagenes/left-flecha.gif'><font color='#FFFFFF'>".ucwords(strtolower($row2["descripcion"]))."</font></td>";
				echo "<td colspan=3>&nbsp;</td>";
				echo "</tr>";
				$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
				$sql.= " where t1.cod_sistema = ".$Sistema;
				$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
				$sql.= " and t1.cod_sistema = t2.cod_sistema ";
				$sql.= " and t1.nivel = ".$Nivel;
				$sql.= " and t1.nivel_agrup = 3 ";
				$sql.= " and t1.cod_pant_agrup = ".$row2[cod_pantalla];
				$result3 = mysqli_query($link, $sql);
				while ($row3 = mysqli_fetch_array($result3))
				{
					echo "<tr>\n";
					echo "<td colspan=3>&nbsp;</td>";
					echo "<td><img src='imagenes/left-flecha.gif'><font color='#FFFFFF'>".ucwords(strtolower($row3["descripcion"]))."</font></td>";
					echo "<td colspan=2>&nbsp;</td>";
					echo "</tr>";
					$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
					$sql.= " where t1.cod_sistema = ".$Sistema;
					$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
					$sql.= " and t1.cod_sistema = t2.cod_sistema ";
					$sql.= " and t1.nivel = ".$Nivel;
					$sql.= " and t1.nivel_agrup = 4 ";
					$sql.= " and t1.cod_pant_agrup = ".$row3[cod_pantalla];
					$result4 = mysqli_query($link, $sql);
					while ($row4 = mysqli_fetch_array($result4))
					{
						echo "<tr>\n";
						echo "<td colspan=4>&nbsp;</td>";
						echo "<td><img src='imagenes/left-flecha.gif'><font color='#FFFFFF'>".ucwords(strtolower($row4["descripcion"]))."</font></td>";
						echo "<td>&nbsp;</td>";
						echo "</tr>";
						$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
						$sql.= " where t1.cod_sistema = ".$Sistema;
						$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
						$sql.= " and t1.cod_sistema = t2.cod_sistema ";
						$sql.= " and t1.nivel = ".$Nivel;
						$sql.= " and t1.nivel_agrup = 5 ";
						$sql.= " and t1.cod_pant_agrup = ".$row4[cod_pantalla];
						$result5 = mysqli_query($link, $sql);
						while ($row5 = mysqli_fetch_array($result5))
						{
							echo "<tr>\n";
							echo "<td colspan=5>&nbsp;</td>";
							echo "<td><img src='imagenes/left-flecha.gif'><font color='#FFFFFF'>".ucwords(strtolower($row5["descripcion"]))."</font></td>";
							echo "</tr>";
						}
					}
				}
			}
		}
	}
}
  ?>
        </table></td>
    </tr>
  </table>
<?php include("pie_pagina.php");?>  
  </form>
</body>
</html>
