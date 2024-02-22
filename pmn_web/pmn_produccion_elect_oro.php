<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 135;
	include("../principal/conectar_pmn_web.php");
	if ($Ver=="O")
	{
		$Correlativo="";
		$Operador="";
		$Evpf="";
		$Resto="";
		$CatodoSeco="";
		$CloruroAurico="";
	}
	if ($Mostrar == "S")
	{
		if ($Ver=="S")
		{
			$A�o=$A;
			$Mes=$M;
			$Dia=$D;
		}
		$Consulta = "select * from pmn_web.produccion_electrolisis_oro ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " and correlativo = '".$Correlativo."'";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$Operador = $Row[operador];
			$Evpf = $Row[evpf];
			$Resto = $Row[resto];
			$CatodoSeco = $Row[catodo_seco];
			$CloruroAurico = $Row[cloruro_aurico];
		}
	}
	if (($Ver=="O")||($Ver=="S"))
	{
		$Correlativo="";
		$Operador="";
		$Evpf="";
		$Resto="";
		$CatodoSeco="";
		$CloruroAurico="";
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
		case "G": //GRABAR
			if (f.Correlativo.value == "")
			{
				alert("Debe Ingresar Correlativo");
				f.Correlativo.focus();
				return;
			}
			if (f.Operador.value == "S")
			{
				alert("Debe seleccionar Operador");
				f.Operador.focus();
				return;
			}
			if (f.Evpf.value == "S")
			{
				alert("Debe seleccionar EVPF");
				f.Evpf.focus();
				return;
			}			
			if (f.Resto.value == "")
			{
				alert("Debe Ingresar Resto");
				f.Resto.focus();
				return;
			}
			if (f.CatodoSeco.value == "")
			{
				alert("Debe Ingresar Catodo Seco");
				f.CatodoSeco.focus();
				return;
			}
			if (f.CloruroAurico.value == "")
			{
				alert("Debe Ingresar Cloruro Aurico");
				f.CloruroAurico.focus();
				return;
			}			
						
			f.action= "pmn_produccion_elect_oro01.php?Proceso=G";
	 		f.submit();
			break;
		case "M": //MODIFICAE
			f.action= "pmn_produccion_elect_oro01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR
			f.action= "pmn_produccion_elect_oro01.php?Proceso=E";
	 		f.submit();
			break;
		case "C": //CANCELAR
			f.action= "pmn_produccion_elect_oro01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //CANCELAR
			var URL ="pmn_produccion_elect_oro03.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
			//f.action= "pmn_descarga_elec_plata.php?";
	 		//f.submit();
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=133";
	 		f.submit();
			break;	
	}
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" border="0" class="TablaPrincipal">
    <tr>
    <td><table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="131" height="30">Fecha:</td>
            <td colspan="2"> 
              <?php 
				if ($Ver=="O")
				{
					$Ano=$A;
					$Mes=$M;
					$Dia=$D;
				}
				if (($Mostrar == "S")||($Ver=="O"))
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
            </td>
            <td width="114">&nbsp;</td>
            <td width="101"><input name="ver" type="button" style="width:70" value="Consultar" onClick="Proceso('B');"> 
            </td>
            <td width="147">&nbsp;</td>
          </tr>
          <tr> 
            <td>Correlativo:</td>
            <td colspan="2"><input name="Correlativo" type="text" id="Correlativo" value="<?php echo $Correlativo;?>"></td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp; </td>
          </tr>
          <tr> 
            <td>Operador:</td>
            <td colspan="2"><strong> 
              <select name="Operador" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				$Consulta="select * from proyecto_modernizacion.sub_clase t1 ";
				$Consulta.=" inner join proyecto_modernizacion.funcionarios t2 on t2.rut = t1.nombre_subclase";
				$Consulta.=" where cod_clase='6000' and valor_subclase4='op' order by apellido_paterno";
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
				echo "<option value='S'>-----------------------------</option>\n";

				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sistemas_por_usuario t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.rut = t2.rut ";
				$sql.= " where t1.cod_sistema = '6' ";
				$sql.= " and t1.nivel = '8' ";
				$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
				echo $sql;
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
				$Consulta="select * from proyecto_modernizacion.funcionarios where ((cod_centro_costo='02-35.34')or (cod_centro_costo='02-35.32') ";
				$Consulta.=" or (cod_centro_costo='02-35.33') or (cod_centro_costo='02-35.31') or (cod_centro_costo='02-35.35') or (cod_centro_costo='02-35.36'))order by apellido_paterno,apellido_materno,nombres ";
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
			?>
              </select>
              </strong></td>
            <td>EVPF:</td>
            <td colspan="2"><select name="Evpf" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				$Consulta="select * from proyecto_modernizacion.sub_clase t1 ";
				$Consulta.=" inner join proyecto_modernizacion.funcionarios t2 on t2.rut = t1.nombre_subclase";
				$Consulta.=" where cod_clase='6000' and valor_subclase4='evpf' order by apellido_paterno DESC ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila = mysqli_fetch_array($Respuesta)) 
				{
					$Nombre = ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"]));
					if ($Fila[rut] == $Evpf)
					{
						echo "<option selected value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
				}				
				echo "<option value='S'>-----------------------------</option>\n";
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sistemas_por_usuario t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.rut = t2.rut ";
				$sql.= " where t1.cod_sistema = '6' ";
				$sql.= " and t1.nivel = '4' ";
				$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
				$result = mysqli_query($link, $sql);
				while ($row = mysqli_fetch_array($result))
				{
					$Nombre = ucwords(strtolower($row["apellido_paterno"]." ".$row["apellido_materno"]." ".$row["nombres"]));
					if ($row[rut] == $Evpf)
					{
						echo "<option selected value='".$row[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$row[rut]."'>".$Nombre."</option>\n";
					}
				}						
			?>
              </select></td>
          </tr>
          <tr> 
            <td>Resto:</td>
            <td width="120"><input name="Resto" type="text" id="CantOrejas3" value="<?php echo $Resto;?>" size="20" maxlength="20"></td>
            <td width="109">Catodo Seco:</td>
            <td><input name="CatodoSeco" type="text" id="CantOrejas2" value="<?php echo $CatodoSeco;?>" size="20" maxlength="20"></td>
            <td>Cloruro Aurico:</td>
            <td><input name="CloruroAurico" type="text" id="CloruroAurico" value="<?php echo $CloruroAurico;?>" size="15" maxlength="15"></td>
          </tr>
        </table>
        <br> 
        <table width="761" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"> <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:60px;" onClick="Proceso('G');"> 
              <input name="BtnModificar" type="button" id="BtnModificar" value="Modificar" style="width:60px;" onClick="Proceso('M');"> 
              <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:60px;" onClick="Proceso('E');"> 
              <input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:60px;" onClick="Proceso('C');"> 
              <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60px;" onClick="Proceso('S');"> 
            </td>
          </tr>
        </table>
        <br> 
        <table width="600" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr align="center" valign="middle" class="ColorTabla01"> 
            <td width="62" height="15">&nbsp;</td>
            <td width="98"><strong>Correlativo</strong></td>
            <td width="121"><strong>Resto</strong></td>
            <td width="137"><strong>Catodo Seco</strong></td>
            <td width="139"><strong>Cloruro Aurico</strong></td>
          </tr>
          <?php	
	
	$Consulta = "select * from pmn_web.produccion_electrolisis_oro ";
	$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";	  
	$Consulta.= " order by correlativo";
	$Respuesta = mysqli_query($link, $Consulta);
	$i=1;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		
		echo "<td align='center'><input type='checkbox' name='ChkCorrelativo[".$i."]' value='".$Row[correlativo]."'>\n";
		//echo "<input type='hidden' name='ChkGrupo[".$i."]' value='".$Row["grupo"]."'>\n";
		echo "</td>\n";
		echo "<td align='right'>".$Row[correlativo]."</td>\n";		
		echo "<td align='right'>".$Row[resto]."</td>\n";
		echo "<td align='right'>".$Row[catodo_seco]."</td>\n";
		echo "<td align='right'>".$Row[cloruro_aurico]."</td>\n";		
		echo "</tr>\n";
		$i++;
	}
?>
        </table></td>
  </tr>
</table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
