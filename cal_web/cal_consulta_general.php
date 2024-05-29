<?php 
	$CodigoDeSistema = 1;
	$CookieRut= $_COOKIE["CookieRut"];

	$CmbProductos       = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:"";
	$CmbSubProducto     = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbCCosto          = isset($_REQUEST["CmbCCosto"])?$_REQUEST["CmbCCosto"]:"";
	$CmbDias            = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:1;
	$CmbMes             = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno             = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbDiasT           = isset($_REQUEST["CmbDiasT"])?$_REQUEST["CmbDiasT"]:date("d");
	$CmbMesT            = isset($_REQUEST["CmbMesT"])?$_REQUEST["CmbMesT"]:date("m");
	$CmbAnoT            = isset($_REQUEST["CmbAnoT"])?$_REQUEST["CmbAnoT"]:date("Y");
	$LimitFinAux        = isset($_REQUEST["LimitFinAux"])?$_REQUEST["LimitFinAux"]:50;
	$Opc                = isset($_REQUEST["Opc"])?$_REQUEST["Opc"]:1;
	$Opcion             = isset($_REQUEST["Opcion"])?$_REQUEST["Opcion"]:"";
	$CmbTipoAnalisis    = isset($_REQUEST["CmbTipoAnalisis"])?$_REQUEST["CmbTipoAnalisis"]:"";
	$CmbTipo            = isset($_REQUEST["CmbTipo"])?$_REQUEST["CmbTipo"]:"";
	$Enabal             = isset($_REQUEST["Enabal"])?$_REQUEST["Enabal"]:"";
	$CmbPeriodo         = isset($_REQUEST["CmbPeriodo"])?$_REQUEST["CmbPeriodo"]:"";
	$CmbAreasProceso    = isset($_REQUEST["CmbAreasProceso"])?$_REQUEST["CmbAreasProceso"]:"";

//	$CodigoDePantalla = 22;
	/*
	if (!isset($CmbDias))
	{
		$CmbDias=1;
		$CmbMes=date("n");
		$CmbAno=date("Y");
		$CmbDiasT=date("j");
		$CmbMesT=date("n");
		$CmbAnoT=date("Y");
	}*/
	include("../principal/conectar_principal.php");

	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$Nivel=$Fila["nivel"];

?>
<html>
<head>
<script language="JavaScript">
function Recarga(Opcion)
{
	var Frm=document.FrmConsultaGeneral;
	if (Frm.CheckEnabal.checked)
	{
		Frm.action= "cal_consulta_general.php?Opc=1&Enabal=S";
		Frm.submit();
	}
	else
	{
		Frm.action= "cal_consulta_general.php?Opc=1";
		Frm.submit();
	}
}
function Proceso(Opcion,Tipo)
{
	var Frm=document.FrmConsultaGeneral;
	var Producto="";
	var SubProducto="";
	var CCosto="";
	var Areas="";
	var Periodo="";
	var TotalDiasT=0;
	var CantDiasI=0;
	var CantDiasT=0;
	var TotalDiasI=0;
	var DifDias=0;
	
	if (Tipo=="")
	{
		alert ("Debe Seleccionar Opcion");
		return;
	}
		//alert (Frm.CmbPeriodo.value);
    switch (Tipo)
	{
		case "1":
			if (Frm.CmbProductos.value == "-1")
			{
				alert ("Debe Ingresar Producto");
				Frm.CmbProductos.focus();
				return;
			}
			else
			{
				Producto=Frm.CmbProductos.options[Frm.CmbProductos.selectedIndex].text;
			}
			if (Frm.CmbSubProducto.value == "-1")
			{
				alert ("Debe Ingresar SubProducto");
				Frm.CmbSubProducto.focus();
				return;
			}
			else
			{
				SubProducto=Frm.CmbSubProducto.options[Frm.CmbSubProducto.selectedIndex].text
			}
			break;
		case "3":		
			if (Frm.CmbCCosto.value=="-1")
			{
				alert ("Debe Ingresar Centro Costo");
				Frm.CmbCCosto.focus();
				return;
			}
			else
			{
				CCosto=Frm.CmbCCosto.options[Frm.CmbCCosto.selectedIndex].text;
			}
			break;
		case "2":	
			if (Frm.CmbAreasProceso.value=="-1")
			{
				alert ("Debe Ingresar Area");
				Frm.CmbAreasProceso.focus();
				return;
			}
			else
			{
				Areas=Frm.CmbAreasProceso.options[Frm.CmbAreasProceso.selectedIndex].text;
			}
			break;
	}		
	if (Frm.CmbPeriodo.value=="-1")
	{
		alert ("Debe Ingresar Periodo");
		Frm.CmbPeriodo.focus();
		return;
	}
		
	else
	{	
		Periodo=Frm.CmbPeriodo.options[Frm.CmbPeriodo.selectedIndex].text;
	}
		//
	switch (Opcion)
	{
		case "L":
			if (Frm.CheckEnabal.checked)
			{
				if (Frm.CmbSubProducto.value==-2)
				{
					if (Frm.CmbPeriodo.value==3)
					{
						Frm.action= "cal_consulta_general_respuesta.php?LimitIni=0&LimitFin="+Frm.LimitFinAux.value+"&Enabal=S";
						Frm.submit();	
					}
					else
					{
						alert("Debe Ingresar Periodo Mensual");
					}
				}
				else
				{
					Frm.action= "cal_consulta_general_respuesta.php?LimitIni=0&LimitFin="+Frm.LimitFinAux.value+"&Enabal=S";
					Frm.submit();
				}
			}
			else
			{
				if (Frm.CmbSubProducto.value==-2)
				{
					if (Frm.CmbPeriodo.value==3)
					{
					
						Frm.action= "cal_consulta_general_respuesta.php?LimitIni=0&LimitFin="+Frm.LimitFinAux.value;
						Frm.submit();
					}
					else
					{
						alert("Debe Ingresar Periodo Mensual");
					
					}
				}
				else
				{
						Frm.action= "cal_consulta_general_respuesta.php?LimitIni=0&LimitFin="+Frm.LimitFinAux.value;
						Frm.submit();
				}
			}
			break;
		case "E":
			if (Frm.CheckEnabal.checked)
			{
				if (Frm.CmbSubProducto.value==-2)
				{
					if (Frm.CmbPeriodo.value==3)
					{
						Frm.action= "cal_consulta_general_excel.php?Enabal=S";
						Frm.submit();	
					}
					else
					{
						alert("Debe Ingresar Periodo Mensual");
					}
				}
				else
				{
					Frm.action= "cal_consulta_general_excel.php?Enabal=S";
					Frm.submit();
				}
			}
			else
			{
				if (Frm.CmbSubProducto.value==-2)
				{
					if (Frm.CmbPeriodo.value==3)
					{
					
						Frm.action= "cal_consulta_general_excel.php"
						Frm.submit();
					}
					else
					{
						alert("Debe Ingresar Periodo Mensual");
					
					}
				}
				else
				{
						Frm.action= "cal_consulta_general_excel.php";
						Frm.submit();
				}
			}
			break;
	}			
}
function Salir()
{
	var Frm=document.FrmConsultaGeneral;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	Frm.submit();
}
function Habilitar(Opcion)
{
	var Frm=document.FrmConsultaGeneral;

	switch (Opcion)
	{
		case "1":
			if (Frm.CheckEnabal.checked)
			{
				Frm.action= "cal_consulta_general.php?Opc=1&Enabal=S";
				Frm.submit();			
			}
			else
			{
				Frm.action= "cal_consulta_general.php?Opc=1";
				Frm.submit();			
			}
			break;
		case "2":
			if (Frm.CheckEnabal.checked)
			{
				Frm.action= "cal_consulta_general.php?Opc=2&Enabal=S";
				Frm.submit();
			}
			else
			{
				Frm.action= "cal_consulta_general.php?Opc=2";
				Frm.submit();
			}
			break;
		case "3":
			if (Frm.CheckEnabal.checked)
			{
				Frm.action= "cal_consulta_general.php?Opc=3&Enabal=S";	
				Frm.submit();
			}
			else
			{
				Frm.action= "cal_consulta_general.php?Opc=3";	
				Frm.submit();
			}
			break;
	}
}


</script>
<title>Consulta General</title>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaGeneral" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td width="761" align="center" valign="middle">
	  <table width="755" border="0" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
	  <tr align="center" bgcolor="#FFFFFF" class="ColorTabla01">
	    <td colspan="3">CONSULTA GENERAL DE CONTROL CALIDAD </td>
	    </tr>
	  <tr bgcolor="#FFFFFF">
	  <td width="249">
	  <?php
	  	if ($Opc=="1")
		{
	  		echo "<input type='radio' name='Opcion' checked onClick=Habilitar('1')>";
		}
		else
		{
	  		echo "<input type='radio' name='Opcion' onClick=Habilitar('1')>";		
		}	
	  ?>	
              Producto-SubProducto </td>
	  <td width="213">
	  <?php
	  	if ($Opc=="2")
		{
			echo "<input type='radio' name='Opcion' checked onClick=Habilitar('2')>";
		}
		else
		{
			echo "<input type='radio' name='Opcion' onClick=Habilitar('2')>";		
		}	
	  ?>		
              Proceso </td>
	  <td width="275">
	  <?php
	  	if ($Opc=="3")
		{
	  	   echo "<input type='radio' name='Opcion' checked onClick=Habilitar('3')>";
		}
		else
		{
	  	   echo "<input type='radio' name='Opcion' onClick=Habilitar('3')>";
		}  
	  ?>
              Centro Costo</td>
	  </tr>
	  </table>
	  <br>
	  <table width="755" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF" class="ColorTabla01">
            <td colspan="4">OPCIONES DE BUSQUEDA </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="11%"> Producto:</td>
            <td width="37%" align="left" bgcolor="#efefef">
			<select name="CmbProductos" style="width:250" onChange="Recarga();" <?php if ($Opc!=1) echo "Disabled";?>>
				<option value="-1" selected>Seleccionar</option><?php
				if ($Opc=="1")
				{
					if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
					{
						$Consulta="SELECT cod_producto,descripcion from productos order by descripcion"; 
					}
					else
					{
						$Consulta="SELECT cod_producto,descripcion from productos  order by descripcion"; 
					}
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbProductos==$Fila["cod_producto"])
						{
							echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}
						else
						{
							echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}
					}
				}
		
		    ?>              
			</select> </td>
            <td width="13%">C.C.:</td>
            <td width="39%" bgcolor="#efefef"><strong> 
              <?php
			  	if ($Opc=="3")
				{	
					echo "<select name='CmbCCosto' style='width:250'>";
					echo "<option value ='-1' selected>Seleccionar</option>\n;";
					$Consulta = "SELECT centro_costo,descripcion from centro_costo  where mostrar_calidad='S' order by centro_costo";
					$Respuesta = mysqli_query ($link,$Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbCCosto==$Fila["centro_costo"])
						{
							echo "<option value = '".$Fila["centro_costo"]."' selected>".$Fila["centro_costo"]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
						}
						else
						{
							echo "<option value = '".$Fila["centro_costo"]."'>".$Fila["centro_costo"]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
						}	
					}
					echo "<option value ='-1'>____________________________________________________</option>\n";
					$Consulta = "SELECT centro_costo,descripcion from centro_costo  where mostrar_calidad<>'S' order by centro_costo";
					$Respuesta = mysqli_query ($link,$Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbCCosto==$Fila["centro_costo"])
						{
							echo "<option value = '".$Fila["centro_costo"]."' selected>".$Fila["centro_costo"]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
						}
						else
						{
							echo "<option value = '".$Fila["centro_costo"]."'>".$Fila["centro_costo"]." - ".ucwords(strtolower($Fila["descripcion"]))."</option>\n"; 
						}	
					}
				}
				else
				{
					echo "<select name='CmbCCosto' disabled style='width:250'>";
					echo "<option value ='-1' selected>Seleccionar</option>\n;";				
				}	
			?>
              </select>
              </strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>SubProducto:</td>
            <td bgcolor="#efefef"><select name="CmbSubProducto" style="width:250" <?php if ($Opc!=1) echo "disabled"; ?>>
            <?php
				if ($Opc=="1")
				{
					if ($CmbProductos==59)
					{
						echo "<option value='-2' selected>Todos</option>";
					}
					else
					{
						echo "<option value='-1' selected>Seleccionar</option>";
					}
					if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
					{
						$Consulta="SELECT cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'"; 
					}
					else
					{
						if ($CmbProductos=='1')
						{
							$Consulta="SELECT cod_subproducto,descripcion from subproducto where cod_producto = '1' and cod_subproducto='92' "; 											
						}
						else
						{
							$Consulta="SELECT cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'"; 
						}
					}	
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
						{
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						}
						else
						{
												
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}	
					}
				}
				else
				{
					echo "<option value='-1' selected>Seleccionar</option>";					
				}			
		    ?>
              </select> </td>
            <td>Area:</td>
            <td bgcolor="#efefef"><strong> 
              <?php
					if ($Opc=="2")
					{
					    echo "<select name='CmbAreasProceso' style='width:250'>";
						echo "<option value ='-1' selected>Seleccionar</option>\n;";
						$Consulta = "SELECT nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase = 3 order by cod_subclase";
						$Respuesta = mysqli_query ($link, $Consulta);
						while ($Fila=mysqli_fetch_array($Respuesta))
						{
							if ($CmbAreasProceso == $Fila["cod_subclase"])
							{
								echo "<option value = '".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 				
							}
							else
							{
								echo "<option value = '".$Fila["cod_subclase"]."'>".$Fila["cod_subclase"]." - ".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
							}	
						}

					}	  
					else
					{
						  echo "<select name='CmbAreasProceso' disabled style='width:250'>";
						  echo "<option value ='-1' selected>Seleccionar</option>\n;";				
					} 
				?>
              </select>
              </strong></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>Periodo:</td>
            <td bgcolor="#efefef"> 
              <?php	
					if (($Opc=="1")||($Opc=="2")||($Opc=="3"))
					{
						echo "<select name='CmbPeriodo' style='width:130'>";
					}
					else
					{
						echo "<select name='CmbPeriodo' disabled style='width:130'>";					
					}	
                	echo "<option value ='-1' selected>Seleccionar</option>";
					$Consulta = "SELECT * from sub_clase where cod_clase = 2 order by cod_subclase";
					$Respuesta= mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Respuesta))
					{
						$Descripcion = str_replace(".","",$Fila["nombre_subclase"]);
						
						if ($CmbPeriodo==$Fila["cod_subclase"])
						{
						
							echo "<option value = '".$Fila["cod_subclase"]."' selected>".$Descripcion."</option>\n";						
						}
						else
						{
							echo "<option value = '".$Fila["cod_subclase"]."'>".$Descripcion."</option>\n";
						}	
					}
					echo "</select>&nbsp;";
						
				?>
				
            </td>
			<td>Enabal:</td>
			<td bgcolor="#efefef">
            <?php
				if ($Enabal=='S')
				{
					echo "<input type='checkbox' name='CheckEnabal' value='S' checked> ";
				}
				else
				{
					echo "<input type='checkbox' name='CheckEnabal' value='S'> ";
				}
	  		?>
		  </td>
          </tr>
		  <tr bgcolor="#FFFFFF">
		  <td>Tipo Muestra:</td>
		  <td colspan="1" bgcolor="#efefef">
			<?php					
					echo "<select name='CmbTipo' style='width:110'>";
					echo "<option value='-1' selected>Todos</option>";
					$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase=1005 order by cod_subclase";
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($Fila["cod_subclase"]== $CmbTipo)
						{
							echo "<option value =".$Fila["cod_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";				
						}
						else
						{
							echo "<option value =".$Fila["cod_subclase"].">".$Fila["nombre_subclase"]."</option>";
						}	
					}
					echo "</select>";
					?>
					<td>Tipo Analisis:</td><td bgcolor="#efefef"><?php 
					echo "<select name='CmbTipoAnalisis' style='width:120'>";
					echo "<option value = '-1' selected>Todos</option>\n";
					$Consulta= "SELECT * from sub_clase where cod_clase = 1000";
					$Respuesta= mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbTipoAnalisis == $Fila["cod_subclase"])
						{
							echo "<option value ='".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 			
						}
						else			
						{	
							if ($Fila["cod_subclase"]=='1')
							{
								echo "<option value ='".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
							}
							else
							{
								echo "<option value ='".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
							}
						}
					}
			?>		
		  </td>
		  </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="26" align="left">Fecha Inicio:</td>
            <td colspan="1" bgcolor="#efefef"><?php

					echo "<select name='CmbDias'>";
						for ($i=1;$i<=31;$i++)
						{
							if (isset($CmbDias))
							{
								if ($i==$CmbDias)
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
					echo"</select>";
					echo"<select name='CmbMes'>";
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
					echo "<select name='CmbAno'>";
						for ($i=date("Y")-8;$i<=date("Y")+1;$i++)
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
	    			echo "</select>&nbsp;&nbsp;";
					?>
					</td>	<td>Fecha Termino:</td>
						<td bgcolor="#efefef"><?php
					echo "<select name='CmbDiasT'>";
					for ($i=1;$i<=31;$i++)
					{
						if (isset($CmbDiasT))
						{
							if ($i==$CmbDiasT)
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
				  echo "<select name='CmbMesT'>";
				  for($i=1;$i<13;$i++)
				  {
						if (isset($CmbMesT))
						{
							if ($i==$CmbMesT)
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
				   echo "<select name='CmbAnoT'>";
				   for ($i=date("Y")-8;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAnoT))
						{
							if ($i==$CmbAnoT)
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
				?></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>Ver Adicional:</td>
            <td colspan="3" bgcolor="#efefef"><input name="ChkAgrupacion" type="checkbox" value="S">
            Agrupacion 
              <input name="ChkFechaMuestra" type="checkbox" value="S">
            FechaMuestra
            <input name="ChkProducto" type="checkbox" value="S"> 
            Producto 
            <input name="ChkSubProducto" type="checkbox" value="S">
            SubProducto 
            <input name="ChkPesoMuestra" type="checkbox" value="S">
            Peso Muestra 
            <input name="ChkObservacion" type="checkbox" value="S">
            Observacion </td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td>N&deg; Result:</td>
            <td colspan="3" bgcolor="#efefef"><input name="LimitIni" type="hidden" value="0"><input name="LimitFinAux" type="text" value="<?php echo $LimitFinAux; ?>" size="10" maxlength="4"></td>
          </tr>
          <tr bgcolor="#FFFFFF" class="Detalle02"> 
            <td height="30" colspan="4" align="center"><input name="BtnImprimir" type="button" value="Consultar" style="width:70" onClick="Proceso('L','<?php echo $Opc; ?>');"> 
              &nbsp; 
              <input name="BtnExcel" type="button" value="Excel" style="width:70" onClick="Proceso('E','<?php echo $Opc; ?>');">
              &nbsp;
            <input name="BtnSalir" type="button" value="Salir" style="width:70" onClick="Salir();">            </td>
          </tr><br>
        </table>
	  <br>
	  </td>
	</tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
