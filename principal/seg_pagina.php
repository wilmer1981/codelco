<?php 
	include("conectar_principal.php");

$CodSistema   = isset($_REQUEST["CodSistema"])?$_REQUEST["CodSistema"]:"";
$CodPantalla  = isset($_REQUEST["CodPantalla"])?$_REQUEST["CodPantalla"]:"";
$NivelSistema = isset($_REQUEST["NivelSistema"])?$_REQUEST["NivelSistema"]:"";
$NivelMenu    = isset($_REQUEST["NivelMenu"])?$_REQUEST["NivelMenu"]:"";
$Mensaje      = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
$PantAgrup      = isset($_REQUEST["PantAgrup"])?$_REQUEST["PantAgrup"]:"";


	//PantAgrup: 0	

?>
<html>
<head>
<title>Administrador de Sistemas</title>
<link href="estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	//alert(opt);
	switch (opt)
	{
		case "G":
			if (f.NivelSistema.value == "S")
			{
				alert("Debe Seleccionar el Nivel del sistema al que se le Asignara la Pagina");
				f.NivelSistema.focus();
				return;
			}
			if (f.NivelMenu.value == "S")
			{
				alert("Debe Seleccionar el Nivel del Menu en que quedara la Pagina");
				f.NivelMenu.focus();
				return;
			}
			if(f.PantAgrup.value == "S")
			{
				alert("Debe Seleccionar la opcion de Menu de nivel superior a la que esta enlazada esta pagina para este nivel");
				f.PantAgrup.focus();
				return;
			}
			f.action = "ing_pantalla01.php?Proceso=ING_SEG";
			f.submit();
			break
		case "E":
			var Valor="";
			for (i=0;i<f.length;i++)
			{
				if ((f.elements[i].name == "NivelAsoc") && (f.elements[i].checked == true))
				{
					Valor = f.elements[i].value;
				}
			}
			if (Valor == "")
			{
				alert("Debe Seleccionar 1 registro para Eliminar");
				return;
			}
			else
			{
				var msg = confirm("¿Seguro que desea Eliminar esta Pantalla de este Nivel?");
				if (msg == true)
				{
					f.action = "ing_pantalla01.php?Proceso=ELI_SEG&NivelElim=" + Valor;
					f.submit();
				}
				else
				{
					return;
				}
			}
			break
		case "S":
			window.close();
			break
	}
}

function Recarga()
{
	var f    = document.frmPrincipal;
	//f.action = "seg_pagina.php?CodSistema=<?php //echo $CodSistema?>&CodPantalla=<?php //echo $CodPantalla?>";
	f.action = "seg_pagina.php";
	f.submit();
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	background-image: url(imagenes/fondo3.gif);
}
</style>
</head>

<body leftmargin="3" topmargin="2">
<form name="frmPrincipal" method="post" action="">
<?php
	echo "<div style='position:absolute; width: 400px; height: 30px; left: 50px; top: 20px;'>\n";
	echo "<font class='Titulo'>".$Mensaje."</font>";
	echo "</div>\n";
?>
<div style="position:absolute; width: 527px; height: 97px; left: 8px; top: 10px;">
    <table width="500" border="0" cellpadding="2" cellspacing="0" style="border=solid 1px #000000" class="TablaInterior">
      <tr> 
        <td width="16" align="center" valign="middle"><img src="imagenes/left-flecha.gif" width="11" height="11"></td>
        <td width="157">Sistema </td>
        <td width="315"> 
          <?php
		$sql = "select * from sistemas where cod_sistema = '".$CodSistema."' ";
		$result = mysqli_query($link, $sql);
		if ($row = mysqli_fetch_array($result))
		{
			echo $row["nombre"];
		}
		else
		{
			echo "Error, Sistema no Encontrado...Favor Cierre la ventana";
		}
		?>
          <input type="hidden" name="CodSistema" value="<?php echo $CodSistema;?>"></td>
      </tr>
      <tr> 
        <td align="center" valign="middle"><img src="imagenes/left-flecha.gif" width="11" height="11"></td>
        <td>Pantalla </td>
        <td> 
          <?php
		$sql = "SELECT * FROM pantallas ";
		$sql.= " WHERE cod_sistema = '".$CodSistema."' and cod_pantalla = '".$CodPantalla."' ";
		$result = mysqli_query($link, $sql);
		if ($row = mysqli_fetch_array($result))
		{
			echo $row["descripcion"];
		}
		else
		{
			echo "Error, Sistema no Encontrado...Favor Cierre la ventana";
		}
		?>
          <input type="hidden" name="CodPantalla" value="<?php echo $CodPantalla;?>"></td>
      </tr>
      <tr> 
        <td colspan="2" valign="middle"><strong>Nuevo Acceso</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td align="center" valign="middle"><font color="#FFFFFF"><img src="imagenes/left-flecha.gif" width="11" height="11"></font></td>
        <td>Nivel de Sistema</td>
        <td><select name="NivelSistema" style="width:300px" onChange="Recarga();">
            <option value="S">Seleccionar Nivel de Sistema</option>
            <?php
			$sql = "SELECT * FROM niveles_por_sistema WHERE cod_sistema = '".$CodSistema."' order by nivel";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_array($result))
			{
				if ($NivelSistema == $row["nivel"])
				{
					echo "<option selected value='".$row["nivel"]."'>".$row["nivel"]." - ".$row["descripcion"]."</option>\n";
				}
				else
				{
					echo "<option value='".$row["nivel"]."'>".$row["nivel"]." - ".$row["descripcion"]."</option>\n";
				}
			}
		?>
          </select></td>
      </tr>
      <tr> 
        <td align="center" valign="middle"><font color="#FFFFFF"><img src="imagenes/left-flecha.gif" width="11" height="11"></font></td>
        <td>Ubicada en: </td>
        <td><select name="NivelMenu" style="width:300px" onChange="Recarga();">
            <?php
			for ($i=0;$i<=1;$i++)
			{
				if ($NivelMenu == $i)
				{
					if ($i == 0)
					{
						echo "<option selected value='".$i."'>Men&uacute; Principal del Sistema</option>\n";
					}
					else
					{
						echo "<option selected value='".$i."'>Dentro de una Carpeta</option>\n";
					}
				}
				else
				{
					if ($i == 0)
					{
						echo "<option value='".$i."'>Men&uacute; Principal del Sistema</option>\n";
					}
					else
					{
						echo "<option value='".$i."'>Dentro de una Carpeta</option>\n";
					}
				}
			}
		?>
          </select></td>
      </tr>
      <tr> 
        <td align="center" valign="middle"><font color="#FFFFFF"><img src="imagenes/left-flecha.gif" width="11" height="11"></font></td>
        <td>Dentro de la Carpeta : </td>
        <td><select name="PantAgrup" style="width:300px">
           <!-- <option value="S">Seleccionar Dependencia</option>-->
            <?php 
				if ($NivelMenu!="" && $NivelMenu != "S")
				{
					if ($NivelMenu == 0)
					{
						echo "<option value='0'>No Tiene Dependencia</option>\n";
					}
					else
					{
						$Consulta = "SELECT distinct t1.cod_pantalla, t2.descripcion ";
						$Consulta.= " FROM proyecto_modernizacion.acceso_menu t1 INNER JOIN proyecto_modernizacion.pantallas t2 ON ";
						$Consulta.= " t1.cod_sistema = t2.cod_sistema AND t1.cod_pantalla = t2.cod_pantalla";
						$Consulta.= " WHERE t1.cod_sistema = '".$CodSistema."' ";												
						$Consulta.= " AND t2.tipo = '3'";
						$Consulta.= " ORDER BY t1.cod_pantalla";	
						$result = mysqli_query($link, $Consulta);
						while ($row = mysqli_fetch_array($result))
						{
							if ($PantAgrup = $row["cod_pantalla"])
							{
								echo "<option value='".$row["cod_pantalla"]."'>".$row["cod_pantalla"]." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
							}
							else
							{
								echo "<option value='".$row["cod_pantalla"]."'>".$row["cod_pantalla"]." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
							}
						}			
					}
				 }
				 else
				 {
				 	echo "<option value='0'>No Tiene Dependencia</option>\n";
				 }
			  ?>
          </select></td>
      </tr>
    </table>
</div>
<div style="position:absolute; left: 7px; top: 180px; width: 357px; height: 26px;">
<table border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td colspan="6">Diagrama de Men&uacute; Seg&uacute;n Sistema y 
              Nivel de Acceso
			</td>
          </tr>
          <?php
//if (((isset($NivelSistema)) && ($NivelSistema != "S")) && ((isset($CodSistema)) && ($CodSistema != "S")))
if (($NivelSistema!="" && $NivelSistema != "S") && ($CodSistema!="" && $CodSistema != "S"))
{
  	$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
	$sql.= " where t1.cod_sistema = '".$CodSistema."' ";
	$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
	$sql.= " and t1.cod_sistema = t2.cod_sistema ";
	$sql.= " and t1.nivel = '".$NivelSistema."' ";
	$sql.= " and t1.nivel_agrup = 0";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		echo "<tr>\n";
		echo "<td><img src='imagenes/left-flecha.gif'><font>".ucwords(strtolower($row["descripcion"]))."</font></td>\n";
		echo "<td colspan=5>&nbsp;</td>";
		echo "</tr>";
		$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
		$sql.= " where t1.cod_sistema = '".$CodSistema."' ";
		$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
		$sql.= " and t1.cod_sistema = t2.cod_sistema ";
		$sql.= " and t1.nivel = '".$NivelSistema."' ";
		$sql.= " and t1.nivel_agrup = 1 ";
		$sql.= " and t1.cod_pant_agrup = '".$row["cod_pantalla"]."' ";
		$result1 = mysqli_query($link, $sql);
		while ($row1 = mysqli_fetch_array($result1))
		{	
			echo "<tr>\n";
			echo "<td>&nbsp;</td>";
			echo "<td><img src='imagenes/left-flecha.gif'><font>".ucwords(strtolower($row1["descripcion"]))."</font></td>";
			echo "<td colspan=4>&nbsp;</td>";
			echo "</tr>";
			$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
			$sql.= " where t1.cod_sistema = '".$CodSistema."' ";
			$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
			$sql.= " and t1.cod_sistema = t2.cod_sistema ";
			$sql.= " and t1.nivel = '".$NivelSistema."' ";
			$sql.= " and t1.nivel_agrup = 2 ";
			$sql.= " and t1.cod_pant_agrup = '".$row1["cod_pantalla"]."' ";
			$result2 = mysqli_query($link, $sql);
			while ($row2 = mysqli_fetch_array($result2))
			{
				echo "<tr>\n";
				echo "<td colspan=2>&nbsp;</td>";
				echo "<td><img src='imagenes/left-flecha.gif'><font>".ucwords(strtolower($row2["descripcion"]))."</font></td>";
				echo "<td colspan=3>&nbsp;</td>";
				echo "</tr>";
				$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
				//$sql.= " where t1.cod_sistema = '".$Sistema."' ";
				$sql.= " where t1.cod_sistema = '".$CodSistema."' ";
				$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
				$sql.= " and t1.cod_sistema = t2.cod_sistema ";
				//$sql.= " and t1.nivel = '".$Nivel."' ";
				$sql.= " and t1.nivel = '".$NivelSistema."' ";
				$sql.= " and t1.nivel_agrup = 3 ";
				$sql.= " and t1.cod_pant_agrup = '".$row2["cod_pantalla"]."' ";
				$result3 = mysqli_query($link, $sql);
				while ($row3 = mysqli_fetch_array($result3))
				{
					echo "<tr>\n";
					echo "<td colspan=3>&nbsp;</td>";
					echo "<td><img src='imagenes/left-flecha.gif'><font>".ucwords(strtolower($row3["descripcion"]))."</font></td>";
					echo "<td colspan=2>&nbsp;</td>";
					echo "</tr>";
					$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
					//$sql.= " where t1.cod_sistema = '".$Sistema."' ";
					$sql.= " where t1.cod_sistema = '".$CodSistema."' ";
					$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
					$sql.= " and t1.cod_sistema = t2.cod_sistema ";
					//$sql.= " and t1.nivel = '".$Nivel."' ";
					$sql.= " and t1.nivel = '".$NivelSistema."' ";
					$sql.= " and t1.nivel_agrup = 4 ";
					$sql.= " and t1.cod_pant_agrup = '".$row3["cod_pantalla"]."' ";
					$result4 = mysqli_query($link, $sql);
					while ($row4 = mysqli_fetch_array($result4))
					{
						echo "<tr>\n";
						echo "<td colspan=4>&nbsp;</td>";
						echo "<td><img src='imagenes/left-flecha.gif'><font>".ucwords(strtolower($row4["descripcion"]))."</font></td>";
						echo "<td>&nbsp;</td>";
						echo "</tr>";
						$sql = "select t1.cod_pantalla, t2.descripcion from acceso_menu t1, pantallas t2 ";
						//$sql.= " where t1.cod_sistema = ".$Sistema."' ";
						$sql.= " where t1.cod_sistema = '".$CodSistema."' ";
						$sql.= " and t1.cod_pantalla = t2.cod_pantalla ";
						$sql.= " and t1.cod_sistema = t2.cod_sistema ";
						//$sql.= " and t1.nivel = '".$Nivel."' ";
						$sql.= " and t1.nivel = '".$NivelSistema."' ";
						$sql.= " and t1.nivel_agrup = 5 ";
						$sql.= " and t1.cod_pant_agrup = '".$row4["cod_pantalla"]."' ";
						$result5 = mysqli_query($link, $sql);
						while ($row5 = mysqli_fetch_array($result5))
						{
							echo "<tr>\n";
							echo "<td colspan=5>&nbsp;</td>";
							echo "<td><img src='imagenes/left-flecha.gif'><font>".ucwords(strtolower($row5["descripcion"]))."</font></td>";
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
</div>  
<div style="position:absolute; left: 163px; top: 140px; width: 234px; height: 24px;">
    <table width="200" border="0" cellspacing="0" cellpadding="0">
      <tr align="center" valign="middle"> 
        <td><input type="button" name="BtnGrabar" value="Grabar" onClick="Proceso('G')" style="width:80px;"></td>
        <td><input type="button" name="BtnEliminar" value="Eliminar" onClick="Proceso('E');" style="width:80px;"></td>
        <td><input type="button" name="BtnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:80px;"></td>
      </tr>
    </table>

</div>
<div style="position:absolute; left: 370px; top: 180px;">
    <table width="300" border="0" cellspacing="0" cellpadding="3" class="TablaDetalle">
      <tr align="center" class="ColorTabla01"> 
        <td colspan="2"><font size="2">Niveles Asociados a la Pantalla </font></td>
      </tr>
<?php	  
	$sql = "SELECT t1.cod_sistema, t1.nivel, t2.descripcion FROM acceso_menu t1, niveles_por_sistema t2 ";
	$sql.= " WHERE t1.cod_sistema = '".$CodSistema."' AND t1.cod_pantalla = '".$CodPantalla."' ";
	$sql.= " AND t1.cod_sistema = t2.cod_sistema AND t1.nivel = t2.nivel order by t1.nivel";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		echo "<tr>\n"; 
		echo "<td width=36 align='center'><input type='radio' name='NivelAsoc' value='".$row["nivel"]."'></td>\n";;
		echo "<td width=264><font face='verdana' size=1>".$row["nivel"]." - ".ucwords(strtolower($row["descripcion"]))."</font></td>\n";
		echo "</tr>\n";
	}
	?>
    </table>

</div>
</form>
</body>
</html>
