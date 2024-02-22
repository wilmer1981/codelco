<?php
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	if ($Proceso == "M")
	{
		$Datos=explode('/',$Valores);
		$Correlativo=$Datos[0];
		$sql = "select * from pac_web.leyes_por_estanques";
		$sql.= " where correlativo= '".$Correlativo."'";
		$result = mysqli_query($link, $sql);
		if ($row=mysqli_fetch_array($result))
		{
			$CmbEK=$row[cod_estanque];
			$CmbDia=substr($row["fecha"],8,2);
			$CmbMes=substr($row["fecha"],5,2);
			$CmbAno=substr($row["fecha"],0,4);
			$Leyes=$row["cod_leyes"];
			$Valor= $row[valor];
			$Unidad = $row[cod_unidad];
		}
		else
		{
			$Valor= "0.0";
		}
	}
?>
<html>
<head>
<title>Proceso</title>
<link rel="stylesheet" href="../principal/estilos/css_imp_web.css" type="text/css">
<script language="Javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
<!--
function Proceso(opt,Valores)
{
	var f=document.frmLeyes;
	switch (opt)
	{
		case "N":
			if (f.CmbEK.value==''-1)
			{
				alert("Debe Seleccionar Estanque");
				f.CmbEK.focus();
				return;
			}
			if (f.Valor.value != "")
			{
				f.action="pac_ing_leyes_esp01.php?Proceso="+opt+"&Valores="+Valores;
				f.submit();
			}
			else
			{
				alert("Debe ingresar Valor");
				return;
			}
			break
		case "M":
			if (f.CmbEK.value==''-1)
			{
				alert("Debe Seleccionar Estanque");
				f.CmbEK.focus();
				return;
			}
			if (f.Valor.value != "")
			{
				f.action="pac_ing_leyes_esp01.php?Proceso="+opt+"&Valores="+Valores;
				f.submit();
			}
			else
			{
				alert("Debe ingresar Valor");
				return;
			}
			break
		case "S":
			window.close();
			break;
	}
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmLeyes" action="" method="post">
<input type="hidden" name="FechaProceso" value="<?php echo $FechaMuestra; ?>">
  <div align="center"> <br>
    <table width="596" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr> 
        <td height="5" colspan="4">&nbsp;</td>
      </tr>
      <tr> 
        <td colspan="4"><strong>EK:</strong>&nbsp;&nbsp;&nbsp;
		<select name="CmbEK" style="width:100">
		<option value="-1" selected>Seleccionar</option>
		<?php
			$Consulta=" select * from proyecto_modernizacion.sub_clase where cod_clase='9001' and cod_subclase <> '5'";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbEK==$Fila["cod_subclase"])
				{
					echo "<option value='$Fila["cod_subclase"]' selected>$Fila["nombre_subclase"]</option>";
				}
				else
				{
					echo "<option value='$Fila["cod_subclase"]'>$Fila["nombre_subclase"]</option>";
				}
			}
		?>
		</select>&nbsp;&nbsp;&nbsp;
		<strong>Fecha:</strong>&nbsp;&nbsp;&nbsp; 
          <?php
			echo "<select name='CmbDia' id='select7' size='1' style='width:40px;'>";
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDia))
				{
					if ($i==$CmbDia)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}
				else
				{
					if ($i==date("j"))
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}	
			}
			echo "</select>";
			echo "<select name='CmbMes' size='1' style='width:90px;'>";
			for($i=1;$i<13;$i++)
			{
				if (isset($CmbMes))
				{
					if ($i==$CmbMes)
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				
				}	
				else
				{
					if ($i==date("n"))
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				}	
			}
			echo "</select>";
			echo "<select name='CmbAno' size='1' style='width:70px;'>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAno))
				{
					if ($i==$CmbAno)
						{
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}
				else
				{
					if ($i==date("Y"))
						{
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";

						}
				}		
			}
		echo "</select>";
		/*echo "<select name='CmbHora' id='select33'>";
		for ($i=0;$i<=23;$i++)
		{
			if ($i<10)
				$Val = "0".$i;
			else	$Val = $i;
			if (isset($CmbHora))
			{	
				if ($CmbHora == $Val)
					echo "<option selected value='".$Val."'>".$Val."</option>\n";
				else	
					echo "<option value='".$Val."'>".$Val."</option>\n";		
			}
			else
			{	
				if (date('H') == $Val)
					echo "<option selected value='".$Val."'>".$Val."</option>\n";
				else
					echo "<option value='".$Val."'>".$Val."</option>\n";		
			}
		}
		echo "</select>";
		echo "<select name='CmbMinutos'>";
		for ($i=0;$i<=59;$i++)
		{
		if ($i<10)
			$Val = "0".$i;
		else
			$Val = $i;
			if (isset($CmbMinutos))
			{	
				if ($CmbMinutos == $Val)
					echo "<option selected value='".$Val."'>".$Val."</option>\n";
				else	
					echo "<option value='".$Val."'>".$Val."</option>\n";		
			}
			else
			{	
				if (date('i') == $Val)
					echo "<option selected value='".$Val."'>".$Val."</option>\n";
				else
					echo "<option value='".$Val."'>".$Val."</option>\n";		
			}
		}
		echo "</select>";*/ 
		?>
        </td>
      </tr>
      <tr> 
        <td width="76"><strong>C&oacute;digo Ley</strong></td>
        <td width="225">
		<select name="Leyes" style="width:200px">
        <?php
			$sql = "select * from proyecto_modernizacion.leyes order by cod_leyes";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_array($result))
			{
				if ($Leyes == $row["cod_leyes"])
				{
					echo "<option selected value='".$row["cod_leyes"]."'>".$row["cod_leyes"]." - ".ucwords(strtolower($row["nombre_leyes"]))."</option>";
				}
				else
				{
					echo "<option value='".$row["cod_leyes"]."'>".$row["cod_leyes"]." - ".ucwords(strtolower($row["nombre_leyes"]))."</option>";
				}
			}
		?>
        </select></td>
        <td width="49"><strong>Valor</strong></td>
        <td width="219"><input name="Valor" type="text" value="<?php echo number_format($Valor,4,',','.');?>" size="20" maxlength="10" onKeyDown="TeclaPulsada(true)"> 
        <select name="Unidad" style="width:80px">
        <?php
		  	$sql = "select * from proyecto_modernizacion.unidades order by cod_unidad";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_array($result))
			{
				if ($Unidad == $row[cod_unidad])
				{
					echo "<option selected value='".$row[cod_unidad]."'>".strtoupper($row["abreviatura"])."</option>\n";
				}
				else
				{
					echo "<option value='".$row[cod_unidad]."'>".strtoupper($row["abreviatura"])."</option>\n";
				}
			}
		 ?>
         </select></td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <br>
	  <table width="596" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr align="center" valign="middle"> 
        <td colspan="4"><input type="button" name="BtnGrabar" value="Grabar" style="width:70px" onClick="Proceso('<?php echo $Proceso;?>','<?php echo $Valores;?>');"> 
          &nbsp;<input type="button" name="BtnCerrar" value="Cerrar" style="width:70px" onClick="Proceso('S');"> 
        </td>
      </tr>
      </table>
  </div>
</form>
</body>
</html>
<?php
	if (isset($Mensaje))
	{
		echo "<script languaje='javascript'>";
		echo "var frm=document.frmLeyes;";
		echo "alert('".$Mensaje."');";
		echo "frm.Leyes.focus();";
		echo "</script>";
	}
?>