<?php
	$CodigoDeSistema = 3;
	$CodigoDePantalla =16; 
	include("../principal/conectar_principal.php");

	$TipoBalance  = isset($_REQUEST["TipoBalance"])?$_REQUEST["TipoBalance"]:"";
	$Producto     = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$FinoLeyes    = isset($_REQUEST["FinoLeyes"])?$_REQUEST["FinoLeyes"]:"";

	$AnoIni  = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date('Y');
	$MesIni  = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date('m');
	$DiaIni  = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date('d');
	$AnoFin  = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date('Y');
	$MesFin  = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date('m');
	$DiaFin  = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date('d');

	
	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	//alert (f.TipoBalance.value +"---"+f.Producto.value);
	switch (opt)
	{
		case "C":
			if(f.Producto.value=="S")
			{
				alert("Debe Seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if(f.SubProducto.value=="S")
			{
				alert("Debe Seleccionar SubProducto");
				f.SubProducto.focus();
				return;
			} 
			if(f.TipoBalance.value=="S")
			{
				alert("Debe Seleccionar Balance");
				f.TipoBalance.focus();
				return;
			}
			//alert (f.TipoBalance.value+" "+f.Producto.value+" "+f.SubProducto.value);
			switch (f.TipoBalance.value)
			{								
				case "3":
					if (f.Producto.value == "48")
					{
						f.action = "sec_con_balance_produccion_desp_lam.php";
					}
					else
					{
						if (f.Producto.value == "64")
						{
							switch (f.SubProducto.value)
							{
								case "1":
									f.action = "sec_con_balance_produccion_sulfato_cobre.php";
									break;
								case "5":
									f.action = "sec_con_balance_produccion_sulfato_cobre.php";
									break;
								case "7":
									f.action = "sec_con_balance_produccion_arseniato.php";
									break;
								case "8":
									f.action = "sec_con_balance_produccion_arseniato.php";
									break;			
							} 
						}
						else
						{
							if (f.Producto.value == "57")
							{
								switch (f.SubProducto.value)
								{
									case "11":
										f.action = "sec_con_balance_produccion_lodos_ref.php";
										break;
								}
							}
							else
							{
								if (f.Producto.value == "18")
								{
									switch (f.SubProducto.value)
									{
										case "1":
											f.action = "sec_con_balance_produccion_cat_com.php";
											break;
										case "3":
											f.action = "sec_con_balance_produccion_desc_normal.php";
											break;
										case "4":
											f.action = "sec_con_balance_produccion_desc_parcial.php";
											break;
										case "5":
											f.action = "sec_con_balance_produccion_ew.php";
											break;
									}
								}								
							}
						}	
					}
					f.submit();
					break;
				case "4":
					if (f.Producto.value == "48")
					{
						f.action = "sec_con_balance_pesaje_desp_lam.php";
					}
					else
					{
						if (f.Producto.value == "18" && f.SubProducto.value == "3")
						{
							f.action = "sec_con_balance_pesaje_desc_normal.php";
						}
						else
						{
							if (f.Producto.value == "57")
							{
								f.action = "sec_con_balance_pesaje_lodos_ref.php";
							}
							else
							{
								f.action = "sec_con_balance_pesaje.php";
								//f.action = "sec_con_balance_pesaje_poly.php";

							}
						}
					}
					f.submit();
					break;
				case "5":
					f.action = "sec_con_balance_recepcion.php";
					f.submit();
					break;
				case "6":
					if (f.Producto.value == "48")
					{
						f.action = "sec_con_balance_traspaso_desp_lam.php";
					}
					else
					{
						if (f.Producto.value == "18" && f.SubProducto.value == "3")
						{
							f.action = "sec_con_balance_traspaso_desc_normal.php";
						}
						else
						{
							f.action = "sec_con_balance_traspaso.php";
						}
					}
					f.submit();
					break;
				case "7":
					if (f.Producto.value == "48")
					{
						f.action = "sec_con_balance_embarque_desp_lam.php";
					}
					else
					{
						if (f.Producto.value == "18" && f.SubProducto.value == "3")
						{
							f.action = "sec_con_balance_embarque_desc_normal.php";
						}
						else
						{
							if (f.Producto.value == "57")
							{
								f.action = "sec_con_balance_embarque_lodos_ref.php";
							}
							else
							{
								f.action = "sec_con_balance_embarque.php";
							}
						}
					}
					f.submit();
					break;
				case "8":
					if (f.Producto.value == "48")
					{
						f.action = "sec_con_balance_stock_fin_desp_lam.php";
					}
					else
					{
						if (f.Producto.value == "18" && f.SubProducto.value == "3")
						{
							f.action = "sec_con_balance_stock_fin_desc_normal.php";
						}
						else
						{
							if (f.Producto.value == "57")
							{
								f.action = "sec_con_balance_stock_fin_lodos_ref.php";
							}
							else
							{
								f.action = "sec_con_balance_exist_final.php";
							}
						}
					}
					f.submit();
					break;
			}			
			break;
		case "E":
			if(f.Producto.value=="S")
			{
				alert("Debe Seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if(f.SubProducto.value=="S")
			{
				alert("Debe Seleccionar SubProducto");
				f.SubProducto.focus();
				return;
			} 
			if(f.TipoBalance.value=="S")
			{
				alert("Debe Seleccionar Balance");
				f.TipoBalance.focus();
				return;
			}
			switch (f.TipoBalance.value)
			{								
				case "3":
					if (f.Producto.value == "48")
					{
						f.action = "sec_con_balance_produccion_desp_lam_excel.php";
					}
					else
					{
						if (f.Producto.value == "64")
						{
							switch (f.SubProducto.value)
							{
								case "1":
									f.action = "sec_con_balance_produccion_sulfato_cobre_excel.php";
									break;
								case "5":
									f.action = "sec_con_balance_produccion_sulfato_cobre_excel.php";
									break;
								case "7":
									f.action = "sec_con_balance_produccion_arseniato_excel.php";
									break;
								case "8":
									f.action = "sec_con_balance_produccion_arseniato_excel.php";
									break;			
							} 
						}
						else
						{
							if (f.Producto.value == "57")
							{
								switch (f.SubProducto.value)
								{
									case "11":
										f.action = "sec_con_balance_produccion_lodos_ref_excel.php";
										break;
								}
							}
							else
							{
								if (f.Producto.value == "18")
								{
									switch (f.SubProducto.value)
									{
										case "1":
											f.action = "sec_con_balance_produccion_cat_com_excel.php";
											break;
										case "3":
											f.action = "sec_con_balance_produccion_desc_normal_excel.php";
											break;
										case "4":
											f.action = "sec_con_balance_produccion_desc_parcial_excel.php";
											break;
										case "5":
											f.action = "sec_con_balance_produccion_ew_excel.php";
											break;
									}
								}								
							}
						}	
					}
					f.submit();
					break;
				case "4":
					if (f.Producto.value == "48")
					{
						f.action = "sec_con_balance_pesaje_desp_lam_excel.php";
					}
					else
					{
						if (f.Producto.value == "18" && f.SubProducto.value == "3")
						{
							f.action = "sec_con_balance_pesaje_desc_normal_excel.php";
						}
						else
						{
							if (f.Producto.value == "57")
							{
								f.action = "sec_con_balance_pesaje_lodos_ref_excel.php";
							}
							else
							{
								f.action = "sec_con_balance_pesaje_excel.php";
							}
						}
					}
					f.submit();
					break;
				case "5":
					f.action = "sec_con_balance_recepcion_excel.php";
					f.submit();
					break;
				case "6":
					if (f.Producto.value == "48")
					{
						f.action = "sec_con_balance_traspaso_desp_lam_excel.php";
					}
					else
					{
						if (f.Producto.value == "18" && f.SubProducto.value == "3")
						{
							f.action = "sec_con_balance_traspaso_desc_normal_excel.php";
						}
						else
						{
							f.action = "sec_con_balance_traspaso_excel.php";
						}
					}
					f.submit();
					break;
				case "7":
					if (f.Producto.value == "48")
					{
						f.action = "sec_con_balance_embarque_desp_lam_excel.php";
					}
					else
					{
						if (f.Producto.value == "18" && f.SubProducto.value == "3")
						{
							f.action = "sec_con_balance_embarque_desc_normal_excel.php";
						}
						else
						{
							if (f.Producto.value == "57")
							{
								f.action = "sec_con_balance_embarque_lodos_ref_excel.php";
							}
							else
							{
								f.action = "sec_con_balance_embarque_excel.php";
							}
						}
					}
					f.submit();
					break;
				case "8":
					if (f.Producto.value == "48")
					{
						f.action = "sec_con_balance_stock_fin_desp_lam_excel.php";
					}
					else
					{
						if (f.Producto.value == "18" && f.SubProducto.value == "3")
						{
							f.action = "sec_con_balance_stock_fin_desc_normal_excel.php";
						}
						else
						{
							if (f.Producto.value == "57")
							{
								f.action = "sec_con_balance_stock_fin_lodos_ref_excel.php";
							}
							else
							{
								f.action = "sec_con_balance_exist_final_excel.php";
							}
						}
					}
					f.submit();
					break;
			}			
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
	}
}
function Recarga()
{
	var f = document.frmPrincipal;
	f.action = "sec_con_balance.php";
	f.submit();
}
</script>
</head>

<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php"); ?>
  <table width="770" height="315" border="0" cellpadding="3" cellspacing="3" class="TablaPrincipal">
    <tr>
      <td valign="top">
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td>TIPO MOVIMIENTO</td>
            <td colspan="2"><SELECT name="TipoBalance" style="width:250px" onChange="Recarga();">
              <option value="S">Seleccionar</option>
              <?php
				$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
				$Consulta.= " where cod_clase = '3011'";
				$Consulta.= " order by cod_subclase";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					if ($TipoBalance == $Fila["cod_subclase"])
						echo "<option value='".$Fila["cod_subclase"]."' SELECTed>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";
					else
						echo "<option value='".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";
				}
			?>
            </SELECT></td>
          </tr>
          <tr> 
            <td width="135">PRODUCTO</td>
            <td colspan="2"> <SELECT name="Producto" style="width:250px" onChange="Recarga();">
              <option value="S">Seleccionar</option>
              <?php
				$Consulta = "SELECT * from proyecto_modernizacion.productos ";
				$Consulta.= " where balance_sec like '%,".$TipoBalance.",%'";
				$Consulta.= " order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					if ($Producto == $Fila["cod_producto"])
						echo "<option value='".$Fila["cod_producto"]."' SELECTed>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					else
						echo "<option value='".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
				}
			?>
            </SELECT></td>
          </tr>
          <tr> 
            <td height="26">SUBPRODUCTO</td>
            <td colspan="2"> <SELECT name="SubProducto" style="width:250px">
              <option value="S">Seleccionar</option>
              <?php
				if ($Producto == 48) //$TipoBalance == 3 
				{
					echo "<option value='T' SELECTed>TODOS</option>\n";
				}
				else
				{
					$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
					$Consulta.= " where cod_producto = '".$Producto."'";
					$Consulta.= " and balance_sec like '%,".$TipoBalance.",%'";
					$Consulta.= " order by descripcion";
					$var=$Consulta;
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						if ($SubProducto == $Fila["cod_subproducto"])
							echo "<option value='".$Fila["cod_subproducto"]."' SELECTed>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						else
							echo "<option value='".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				}
			?>
            </SELECT> <?php //echo "Con".$Consulta;?> </td>
          </tr>
<?php	
//echo $Consulta;
	if ($TipoBalance <1 || $TipoBalance > 8)
	{
		  echo "<tr> \n";
            echo "<td>PERIODO</td> \n";
            echo "<td><SELECT name='DiaIni' style='width:60px'> \n";
				for ($i = 1; $i <= 31; $i++)
				{
					if (isset($DiaIni))
					{
						if ($i == $DiaIni)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
              echo "</SELECT> <SELECT name='MesIni' style='width:110px'>\n";
			  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				for ($i = 1; $i <= 12; $i++)
				{
					if (isset($MesIni))
					{
						if ($i == $MesIni)
							echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
              echo "</SELECT> <SELECT name='AnoIni' style='width:70px'>\n";
				for ($i = (date("Y")-1); $i <= (date("Y")+1); $i++)
				{
					if (isset($AnoIni))
					{
						if ($i == $AnoIni)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
              echo "</SELECT></td>\n";
            echo "<td><SELECT name='DiaFin' style='width:60px'>\n";
				for ($i = 1; $i <= 31; $i++)
				{
					if (isset($DiaFin))
					{
						if ($i == $DiaFin)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
              echo "</SELECT> <SELECT name='MesFin' style='width:110px'>\n";
				for ($i = 1; $i <= 12; $i++)
				{
					if (isset($MesFin))
					{
						if ($i == $MesFin)
							echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
              echo "</SELECT> <SELECT name='AnoFin' style='width:70px'>\n";
				for ($i = (date("Y")-1); $i <= (date("Y")+1); $i++)
				{
					if (isset($AnoFin))
					{
						if ($i == $AnoFin)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
              echo "</SELECT></td>\n";
          	echo "</tr>\n";
	}
	else
	{
		echo "<tr><td>MES</td> \n";
		echo "<td colspan=2><SELECT name='MesFin' style='width:110px'>\n";
		for ($i = 1; $i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($i == $MesFin)
					echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option SELECTed value='".$i."'>".$Meses[$i-1]."</option>\n";
				else
					echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
		}
	  echo "</SELECT> <SELECT name='AnoFin' style='width:70px'>\n";
		for ($i = (date("Y")-1); $i <= (date("Y")+1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($i == $AnoFin)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  echo "</SELECT></td>\n";
	echo "</tr>\n";
	}			
?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="75" colspan="3" align="center"> 
			<?php
			if ($Producto != 48)
			{
				echo "<table width='190' border='1' cellpadding='2' cellspacing='2' bordercolor='#000066'>\n";
				echo "<tr> \n";
				echo "<td width='68'>FINOS</td>\n";
				echo "<td width='102' align='center'> \n";
				if ($FinoLeyes == "F")
					echo "<input name='FinoLeyes' checked type='radio' value='F'>\n";
				else
					echo "<input name='FinoLeyes' type='radio' value='F'>\n";							
				echo "</td>\n";
				echo "</tr>\n";
				echo "<tr> \n";
				echo "<td>LEYES</td>\n";
				echo "<td align='center'>\n";
				if (($FinoLeyes == "L") || (!isset($FinoLeyes)))
					echo "<input type='radio' checked name='FinoLeyes' value='L'></td>\n";
				else
					echo "<input type='radio' name='FinoLeyes' value='L'></td>\n";
				echo "</tr>\n";
				echo "</table>\n";
			  }
			  ?></td>
          </tr>
          <tr> 
            <td colspan="3" align="center"><input name="BtnConsultar" type="button" value="Consultar" style="width:70px" onClick="Proceso('C');">
              <input name="BtnExcel" type="button" id="BtnExcel" style="width:70px" onClick="Proceso('E');" value="Excel"> 
              <input name="BtnSalir" type="button" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
          </tr>
        </table>
      </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
