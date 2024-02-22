<?php
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 8;
	include("../principal/conectar_pmn_web.php");
	if ($Consulta == "S")
	{
		$Mostrar = "S";
		$Dia = $IdDia;
		$Mes = $IdMes;
		$Ano = $IdAno;
		$NumElectrolisis = $IdElectrolisis;
	}
	if ($Mostrar == "S")
	{
		$Consulta = "select * from pmn_web.carga_electrolito_cubas_plata ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
		//	$Grupo = $Row["grupo"];
		//	$EnergiaElec = $Row[energia_elec];
			$NumElectrolsis =$Row[num_electrolisis]; 
			$Operador = $Row[operador];
		}
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "R":
			f.action="pmn_carga_fusion_barro_aurifero.php";
			f.submit();
		break;
		case "G": //GRABAR			
			if (f.NumElectrolisis.value == "")
			{
				alert("Debe Ingresar Num. Electrolisis");
				f.NumElectrolisis.focus();
				return;
			}
			if (f.Operador.value == 'S')
			{
				alert("Debe Seleccionar Operador");
				f.Operador.focus();
				return;
			}
			f.action= "pmn_carga_electrolito_cubas01.php?Operador="+f.Operador.value+ "&Proceso=G";
	 		f.submit();
			break;
		case "G2": //GRABAR DETALLE			
			f.action= "pmn_carga_electrolito_cubas01.php?Operador="+f.Operador.value+ "&Proceso=G2";
	 		f.submit();
			break;
		case "M2": //MODIFICAR DETALLE
			f.action= "pmn_carga_electrolito_cubas01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR TODO
			var mensaje = confirm("¿Seguro que desea Eliminar todos los registros asociados al N° Electrolisis ?");
			if (mensaje==true)
			{
				f.action= "pmn_carga_electrolito_cubas01.php?Operador="+f.Operador.value + "&Proceso=E";
	 			f.submit();
			}
			else
			{
				return;
			}
			break;
		case "E2": //ELIMINAR
			var mensaje = confirm("¿Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				f.action= "pmn_carga_electrolito_cubas01.php?Operador="+f.Operador.value+ "&Proceso=E2";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "C": //CANCELAR
			f.action= "pmn_carga_electrolito_cubas01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //CANCELAR
			var URL = "pmn_carga_electrolito_cubas02.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=104";
	 		f.submit();
			break;
	}

}
var fila = 12; //Posicion Inicial de la Fila.
var col = 4;
function Activar(f)
{
	if (f.todos.checked == true)
		valor = true
	else valor = false;		

	pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = f.elements.length;
	for (i=pos; i<largo; i=i+col)
	{	
		if (f.elements[i].type != 'checkbox')
			return;
		else 
			f.elements[i].checked = valor;
	}	
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="780" border="0" class="TablaPrincipal">
    <tr>
      <td width="774" height="238">
<table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Usuario: 
              </font></font></td>
            <td colspan="2"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              <?php
					$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
					$Resultado= mysqli_query($link, $Consulta);
					if ($Fila =mysqli_fetch_array($Resultado))
					{	
						echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
					}	  
					else
					{
						$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
						$Respuesta = mysqli_query($link, $Consulta);
						if ($Fila=mysqli_fetch_array($Respuesta))
						{
							echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
						}
					}
		  			?>
              </strong></font></font></td>
            <td colspan="2" align="right"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $Fecha_Hora ?> 
              </strong>&nbsp; <strong> 
              <?php
					if (!isset($FechaHora))
					{
						echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
						$FechaHora=date('Y-m-d H:i');
					}
					else
					{ 
						echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
					}
				  ?>
              </strong></font></font></td>
          </tr>
          <tr> 
            <td width="105">Fecha:</td>
            <td colspan="4"> 
              <?php 
				if ($Mostrar == "S")
				{
					echo "<input type='hidden' name='Dia' value='".$Dia."'>\n";
					echo "<input type='hidden' name='Mes' value='".$Mes."'>\n";
					echo "<input type='hidden' name='Ano' value='".$Ano."'>\n";
					printf("%'02d",$Dia);
					echo "-";
					printf("%'02d",$Mes);
					echo "-";
					printf("%'04d",$Ano);
				}
				else
				{
					echo "<select name='Dia' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($Dia))
						{
							if ($i == $Dia)
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
				  echo "</select> <select name='Mes' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($Mes))
						{
							if ($i == $Mes)
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
				  echo "</select> <select name='Ano' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($Ano))
						{
							if ($i == $Ano)
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
					echo "</select>\n";
				}
			?>
              <input name="ver" type="button" style="width:70" value="Consultar" onClick="Proceso('B');"> 
            </td>
          </tr>
          <tr> 
            <td width="105">Num. Electrolisis:</td>
            <td width="228"> 
              <?php
				if ($Mostrar == "S")
				{
					echo $NumElectrolisis;
					echo "<input name='NumElectrolisis' type='hidden' value='".$NumElectrolisis."'>\n";
				}
				else
				{
              		echo "<input name='NumElectrolisis' type='text' value='".$NumElectrolisis."'>\n";
				}
			  ?>
            </td>
            <td width="105">Operador:</td>
            <td colspan="2"> 
              <?php
				/*if (($Mostrar == "S") || ($Mostrar == "C"))
				{
					echo "<select name='Operador' disabled style='width:220px'>";
                }
				else
				{
					echo "<select name='Operador'  style='width:220px'>";
				}*/
				echo "<select name='Operador'  style='width:220px'>";
				echo "<option value='S'>Seleccionar</option>";
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sistemas_por_usuario t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.rut = t2.rut ";
				$sql.= " where t1.cod_sistema = '6' ";
				$sql.= " and t1.nivel = '8' ";
				$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
				$result = mysqli_query($link, $sql);
				while ($row = mysqli_fetch_array($result))
				{
					$Nombre = ucwords(strtolower($row["apellido_paterno"]." ".$row["apellido_materno"]." ".$row["nombres"]));
					if ($row[rut] == $Operador)
					{
						echo "<option selected value='".$row[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$row[rut]."'>".$Nombre."</option>\n";
					}
				}
				echo "<option value='S'>-----------------------------</option>\n";
				$Consulta="select * from proyecto_modernizacion.funcionarios where ((cod_centro_costo='02-35.31')or (cod_centro_costo='02-35.32') ";
				$Consulta.=" or (cod_centro_costo='02-35.33') or (cod_centro_costo='02-35.34') or (cod_centro_costo='02-35.35') or (cod_centro_costo='02-35.36'))order by apellido_paterno,apellido_materno,nombres ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila = mysqli_fetch_array($Respuesta)) 
				{
					$Nombre = ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"]));
					if ($Fila[rut] == $Operador)
					{
						echo "<option selected value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
				}
			?></select>
              </td>
          </tr>
        </table>
		  
        <br>
        <table width="760" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"> <input name="BtnGrabar" type="button" id="BtnGrabar2" value="Grabar" style="width:60px;" onClick="Proceso('G');">
              <input name="BtnEliminar" type="button" id="BtnEliminar2" value="Eliminar" style="width:60px;" onClick="Proceso('E');"> 
              <input name="BtnCancelar" type="button" id="BtnCancelar2" value="Cancelar" style="width:60px;" onClick="Proceso('C');"> 
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60px;" onClick="Proceso('S');"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="595" height="18" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="18" height="15"><input type="checkbox" name="todos" value="checkbox" onClick="Activar(this.form)"></td>
            <td width="175"><strong>#Cubas</strong></td>
            <td width="225"><strong>Nitrato Plata (Lts)</strong></td>
            <td width="167"><strong>Acido Nitrico (Lts)</strong></td>
          </tr>
        <?php	
		$Consulta = "select * from pmn_web.detalle_cubas_electrolito_plata ";
		$Consulta= $Consulta." where fecha = '".$Ano."-".$Mes."-".$Dia."' and ";
		$Consulta= $Consulta." num_electrolisis = '".$NumElectrolisis."'  order by num_cubas,fecha ";
		$Respuesta = mysqli_query($link, $Consulta);
		$i=1;
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>";
			echo "<td align='center'><input type='checkbox' name='ChkElectrolisis[".$i."]' value='".$Row[num_electrolisis]."'></td>";
			echo "<td align='center'><input type='text' style='width:175'  name='ChkCubas[".$i."]' readonly value='".$Row[num_cubas]."'></td>";
			echo "<td align='center'><input type='text' style='width:225' name='ChkNitrato[".$i."]' value='".$Row[nitrato_plata]."'></td>";
			echo "<td align='center'><input type='text' style='width:167' name='ChkAcido[".$i."]' value='".$Row[acido_nitrico]."'></td>";
			echo "</tr>";
			$i++;
		}
		?>
        </table>
        <br>
        <table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="52">&nbsp;</td>
            <td width="199">&nbsp;</td>
            <td width="239"><div align="center">
                <input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="Proceso('G2');">
                <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="Proceso('E2');">
                <input name="BtnSalir2" type="button" id="BtnSalir" value="Salir" style="width:60px;" onClick="Proceso('S');">
              </div></td>
            <td width="245" align="center">&nbsp; </td>
          </tr>
        </table></td>
  </tr>
</table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
