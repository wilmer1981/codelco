<?
	$CodigoDeSistema = 12;
	$CodigoDePantalla = 17;
	include("../principal/conectar_principal.php");
?>	
<html>
<head>
<title>Sistema de RAF</title>
<link href="../principal/estilos/css_imp_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
<!--
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "G": // GRABA o MODIFICA
			if (f.Productos.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Productos.focus();
				return;
			}
			if (f.SubProductos.value == "S")
			{
				alert("Debe seleccionar Sub-Producto");
				f.SubProductos.focus();
				return;
			}
			if (f.valor.value == "")
			{
				alert("Debe Ingresar valor");
				f.valor.focus();
				return;
			}
			if (f.cmbleyes.value == -1)
			{
				alert("Debe seleccionar Ley");
				f.cmbleyes.focus();
				return;
			}
			if (f.cmbunidad.value == -1)
			{
				alert("Debe seleccionar Unidad");
				f.cmbunidad.focus();
				return;
			}

			f.action = "raf_ing_leyes01.php?Proceso=G";
			f.submit();
			break;
		case "E": // ELIMINAR
			if (f.Productos.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Productos.focus();
				return;
			}
			if (f.SubProductos.value == "S")
			{
				alert("Debe seleccionar Sub-Producto");
				f.SubProductos.focus();
				return;
			}

			f.action = "raf_ing_leyes01.php?Proceso=E";
			f.submit();
			break;
		case "R": //RECARGA PAGINA			
			f.action = "raf_ing_leyes.php?Proceso=V";
			f.submit();
			break;
		case "S":  //SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=12";
			f.submit();
			break;
		case "C":
			f.action = "raf_ing_leyes.php?Proceso=V";
			f.submit();
			break;			 			 			
	}
}
//-->
</script>
<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<? 
	include("../principal/encabezado.php");
?>
  <table width="770" height="251" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td height="219" align="center" valign="top"> 
        <table width="650" height="73" border="0" cellpadding="1" cellspacing="1" class="TablaInterior">
          <tr> 
            <td height="23" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"></td>
            <td>Fecha</td>
            <td><select name="Dia" style="width:50px;">
                <?
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			  ?>
              </select> <select name="Mes" style="width:90px;">
                <?
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </select> <select name="Ano" style="width:60px;">
                <?
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($Ano))
					{
						if ($Ano == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
				?>
              </select></td>
            <td align="center" valign="middle">&nbsp;</td>
          </tr>
          <tr> 
            <td width="15" height="23" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"> 
            </td>
            <td width="55">Producto</td>
            <td width="371"><select name="Productos" style="width:350" onChange="Proceso('R');">
            <option selected value="S">Seleccionar</option>
            <?
			$Consulta = "select * from proyecto_modernizacion.productos WHERE cod_producto = 42 order by descripcion";
			$result = mysql_query($Consulta);
			while ($Row = mysql_fetch_array($result))
			{
				if ($Productos == $Row["cod_producto"])
				{
					echo "<option selected value='".$Row["cod_producto"]."'>".$Row["cod_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
				else
				{
					echo "<option value='".$Row["cod_producto"]."'>".$Row["cod_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
			}
?>
              </select> </td>
            <td width="222" align="center" valign="middle"><input type="button" name="BtnGrabar" value="Grabar" onClick="Proceso('G');" style="width:70px"> 
              <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70px" onClick="Proceso('E');" value="Eliminar"></td>
          </tr>
          <tr> 
            <td height="23" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"></td>
            <td>SubProducto</td>
            <td><select name="SubProductos" style="width:350" onChange="Proceso('R');">
                <option selected value="S">Seleccionar</option>
                <?
				$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$Productos."' order by descripcion";
				$result = mysql_query($Consulta);
				while ($Row = mysql_fetch_array($result))
				{
					if ($SubProductos == $Row[cod_subproducto])
					{
						echo "<option selected value='".$Row[cod_subproducto]."'>".ucwords(strtolower($Row["descripcion"]))."</option>\n";
					}
					else
					{
						echo "<option value='".$Row[cod_subproducto]."'>".ucwords(strtolower($Row["descripcion"]))."</option>\n";
					}
				}
				?>
              </select></td>
            <td align="center" valign="middle"><input name="BtnConsultar" type="button" id="BtnConsultar" style="width:70px" onClick="Proceso('C');" value="Consultar"> 
              <input type="button" name="BtnSalir" value="Salir" onClick="Proceso('S');" style="width:70px"></td>
          </tr>
        </table>
        <br>       
        <table width="374" height="36" border="0" cellpadding="0" cellspacing="0" Class="TablaDetalle">
          <tr align="center" valign="middle" class="ColorTabla01"> 
            <td width="43" height="18"><strong>Ley</strong></td>
            <td width="123"><strong>Valor</strong></td>
            <td width="57"><strong>Unid</strong></td>
            <td width="148"><strong>Peso Humedo</strong></td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18"> <select name="cmbleyes">
                <?
			$Consulta = "SELECT * FROM proyecto_modernizacion.leyes";
			$rs = mysql_query($Consulta);
			echo '<option value="-1" selected>Ley</option>';
			while($fila = mysql_fetch_array($rs))
			{
				if($cmbleyes == $fila["cod_leyes"])				
					echo'<option value="'.$fila["cod_leyes"].'" selected>'.$fila["abreviatura"].'</option>';
				else
					echo'<option value="'.$fila["cod_leyes"].'">'.$fila["abreviatura"].'</option>';
			}						
			?>
              </select> </td>
			<?
			if($Proceso == "V")
			{
			  $Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
			  $Consulta = "SELECT * FROM raf_web.leyes_circulantes";
			  $Consulta.= " WHERE cod_producto = '$Productos'";
			  $Consulta.= " AND cod_subproducto = '$SubProductos'";
			  $Consulta.= " AND fecha = '".$Fecha."'";
			  $Consulta.= " AND peso_humedo != 0";
			  $rs = mysql_query($Consulta);
			  if($Fila = mysql_fetch_array($rs))
			  {
				 $peso_humedo = $Fila[peso_humedo];			  
			  }
			}
			?>  
            <td><input type="text" name="valor" value="<? echo $valor; ?>" size="7"></td>
            <td><select name="cmbunidad">
                <?
			$Consulta = "SELECT * FROM proyecto_modernizacion.unidades";
			$rs1 = mysql_query($Consulta);
			echo '<option value="-1" selected>Unidad</option>';
			while($fila = mysql_fetch_array($rs1))
			{
				if($cmbleyes == $fila[cod_unidad])				
					echo'<option value="'.$fila[cod_unidad].'" selected>'.$fila["abreviatura"].'</option>';
				else
					echo'<option value="'.$fila[cod_unidad].'">'.$fila["abreviatura"].'</option>';
			}						
			?>
              </select> </td>
            <td> 
              <input type="text" name="peso_humedo" value="<? echo $peso_humedo; ?>" size="12"></td>
          </tr>
        </table> 
        <br>
		<table width="166" border="0" cellpadding="0" cellspacing="0" Class="TablaDetalle">
		<?
            echo'<td colspan="3"><strong>Peso Humedo:&nbsp;'.$peso_humedo.'</strong></td>';
		?>		
          <tr align="center" valign="middle" class="ColorTabla01"> 
            <td width="42"><strong>Ley</strong></td>
            <td width="62"><strong>Valor</strong></td>
            <td width="59"><strong>Unid.</strong></td>
          </tr>
		<?
		if($Proceso == "V")
		{
		  $Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
		  $Consulta = "SELECT * FROM raf_web.leyes_circulantes";
		  $Consulta.= " WHERE cod_producto = '$Productos'";
		  $Consulta.= " AND cod_subproducto = '$SubProductos'";
		  $Consulta.= " AND fecha = '".$Fecha."'";
		  $rs = mysql_query($Consulta);
		  while($Fila = mysql_fetch_array($rs))
		  {
			  $Consulta = "SELECT abreviatura FROM proyecto_modernizacion.leyes	WHERE cod_leyes = $Fila["cod_leyes"]";
			  $resp = mysql_query($Consulta);
			  $Fil = mysql_fetch_array($resp);
			  
	          echo '<tr align="center" valign="middle">'; 
    	        echo '<td>'.$Fil["abreviatura"].'</td>';
        	    echo '<td>'.number_format($Fila[valor],2,',','').'</td>';

			  $Consulta = "SELECT abreviatura FROM proyecto_modernizacion.unidades WHERE cod_unidad = $Fila[cod_unidad]";
			  $resp = mysql_query($Consulta);
			  $Fil2 = mysql_fetch_array($resp);

	            echo '<td>'.$Fil2["abreviatura"].'</td>';
	          echo'</tr>';
		  }
		}  
		?> 
        </table>		
      </td>
    </tr>
  </table>

<? include("../principal/pie_pagina.php");?>
</form>
</body>
</html>
