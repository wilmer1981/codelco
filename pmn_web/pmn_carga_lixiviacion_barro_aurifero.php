<?php
	
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 11;
	include("../principal/conectar_pmn_web.php");
	//echo $Mostrar."<br>";
	if ($MostrarLixiv1 == "S")
	{
		
		$Consulta = "select * from pmn_web.carga_lixiviacion_barro_aurifero ";
		$Consulta.= " where fecha = '".$AnoAuri."-".$MesAuri."-".$DiaAuri."'";
		$Consulta.= " and turno = '".$Turno."'";
		$Consulta.= " and peso = '".$TxtPeso."'";
		$Consulta.= " and num_electrolisis = '".$TxtElectrolisis."'";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$OperadorLixiv1=$Row[operador];
			$TxtElectrolisis = $Row[num_electrolisis];
			$TxtPeso = $Row["peso"];
			$Correlativo = $Row[correlativo];
		}
	}
if ($MostrarLixiv1 == "C")
	{
		
		$DiaAuri=$DLixiv1;
		$MesAuri=$MLixiv1;
		$AnoAuri=$ALixiv1;
		$Turno=$TLixiv1;
		$TxtElectrolisis="";
		$TxtPeso="";
		$Consulta = "select * from pmn_web.carga_lixiviacion_barro_aurifero ";
		$Consulta.= " where fecha = '".$AnoAuri."-".$MesAuri."-".$DiaAuri."'";
		$Consulta.= " and turno = '".$Turno."'";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$OperadorLixiv1=$Row[operador];
						
		}
	}
if(!isset($MostrarLixiv1))	
{
	$Consulta="select ifnull(max(correlativo)+1,1) as maximo from pmn_web.carga_lixiviacion_barro_aurifero";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		$Correlativo=$Fila["maximo"];
	}				
}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ProcesoLixi1C(opt)
{
	var f = document.frmPrincipalRpt;
	switch (opt)
	{
		case "G": //GRABAR
			if (f.OperadorLixiv1.value == "S")
			{
				alert("Debe seleccionar Operador");
				f.OperadorLixiv1.focus();
				return;
			}		
			if (f.Correlativo.value == "")
			{
				alert("Debe Ingresar Correlativo");
				f.Correlativo.focus();
				return;
			}			
			if (f.TxtElectrolisis.value == "")
			{
				alert("Debe Ingresar Num. Electrolisis");
				f.TxtElectrolisis.focus();
				return;
			}
			if (f.TxtPeso.value == "")
			{
				alert("Debe Ingresar Cantidad de Anodos");
				f.TxtPeso.focus();
				return;
			}
			//alert(f.Operador.value);
			f.action= "pmn_carga_lixiviacion_barro_aurifero01.php?OperadorLixiv1="+f.OperadorLixiv1.value + "&Proceso=G";
	 		f.submit();
			break;
		case "M": //MODIFICAE
			f.action= "pmn_carga_lixiviacion_barro_aurifero01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR
			f.action= "pmn_carga_lixiviacion_barro_aurifero01.php?OperadorLixiv1="+f.OperadorLixiv1.value + "&Proceso=E";
	 		f.submit();
			break;
		case "C": //CANCELAR
			f.action= "pmn_carga_lixiviacion_barro_aurifero01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //Consultar
			//alert(f.Dia2.value)
			var URL = "pmn_carga_lixiviacion_barro_aurifero03.php?DiaIniCon=" + f.DiaAuri.value + "&MesIniCon=" + f.MesAuri.value + "&AnoIniCon=" + f.AnoAuri.value + "&DiaFinCon=" + f.DiaAuri.value + "&MesFinCon=" + f.MesAuri.value + "&AnoFinCon=" + f.AnoAuri.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			//f.action= "pmn_carga_lixiviacion_barro_aurifero.php?Mostrar=C";
	 		//f.submit();
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=106";
	 		f.submit();
			break;
	}
}
function TeclaPulsada2(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 0)
	{		
		eval("f." + salto + ".focus();");
	}
}
function TeclaPulsada1Lixi1(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}

</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmBAurifero" method="post" action="">
<?php //include("../principal/encabezado.php")?>
  <table width="98%" height="330" border="0" class="TituloCabeceraOz">
    <tr>
      <td align="center" valign="top">
	  <table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="106" height="30" class="titulo_azul">Fecha:</td>
            <td width="262"> 
              <?php 
				if (($Mostrar == "S") || ($Mostrar == "C"))
				{
					echo "<input type='hidden' name='DiaAuri' value='".$DiaAuri."'>\n";
					echo "<input type='hidden' name='MesAuri' value='".$MesAuri."'>\n";
					echo "<input type='hidden' name='AnoAuri' value='".$AnoAuri."'>\n";
					printf("%'02d",$DiaAuri);
					echo "-";
					printf("%'02d",$MesAuri);
					echo "-";
					printf("%'04d",$AnoAuri);
				}
				else
				{
					echo "<select name='DiaAuri' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaAuri))
						{
							if ($i == $DiaAuri)
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
				  echo "</select> <select name='MesAuri' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesAuri))
						{
							if ($i == $MesAuri)
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
				  echo "</select> <select name='AnoAuri' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($AnoAuri))
						{
							if ($i == $AnoAuri)
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
            <td class="titulo_azul">Turno: </td>
            <td width="150"> 
              <?php
				if (($Mostrar == "S")|| ($Mostrar == "C"))
				{
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '1' and cod_subclase = '".$Turno."'";
					//echo $Consulta."<br>";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Row = mysqli_fetch_array($Respuesta))
					{
						echo strtoupper($Row["nombre_subclase"])."<input type='hidden' name='Turno' value='".$Row["cod_subclase"]."'>";
					}
				}
				else
				{
					echo "<select name='Turno' style='width:50px'>\n";
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase not in('2') order by cod_subclase";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($Row["cod_subclase"] == $Turno)
							echo "<option selected value='".strtoupper($Row["cod_subclase"])."'>".strtoupper($Row["nombre_subclase"])."</option>";
						else 	echo "<option value='".strtoupper($Row["cod_subclase"])."'>".strtoupper($Row["nombre_subclase"])."</option>";
					}
					echo "</select>\n";
				}
			?>
            </td>
            <td width="113"><input name="BtnConsultar" type="button" id="BtnConsultar" style="width:70" onClick="ProcesoLixi1C('B');" value="Consultar"></td>
          </tr>
          <tr> 
            <td width="106" class="titulo_azul">Operador:</td>
           
		    <td width="262">
				<?php 
					/*if (($Mostrar == "S") || ($Mostrar == "C"))
					{
						echo "<select name='Operador' disabled style='width:220px'>";
					}
					else
					{
						echo "<select name='Operador' style='width:220px'>";
					}*/
				?>	
				<select name='OperadorLixiv1' id="OperadorLixiv1" onChange="TeclaPulsada2('Correlativo')"  style='width:220px'>";
				<?php
				echo "<option value='S'>Seleccionar</option>";
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sub_clase t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.nombre_subclase = t2.rut ";
				$sql.= " where t1.cod_clase = '6015' and t1.valor_subclase1='5' ";
				$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
				$resultComboPMN = mysqli_query($link, $sql);
				while ($rowComboPMN = mysqli_fetch_array($resultComboPMN))
				{
					$Nombre = ucwords(strtolower($rowComboPMN["apellido_paterno"]." ".$rowComboPMN["apellido_materno"]." ".$rowComboPMN["nombres"]));
					if ($rowComboPMN[rut] == $OperadorLixiv1)
					{
						echo "<option selected value='".$rowComboPMN[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$rowComboPMN[rut]."'>".$Nombre."</option>\n";
					}
				}				
/*                echo "<option value='S'>Seleccionar</option>";
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
				}*/
				?>
              </select><?php //echo $sql;?></td>
            <td width="97" class="titulo_azul">Correlativo</td>
            <td colspan="2">
			
			<input name="Correlativo" type="text" onKeyDown="TeclaPulsada1Lixi1('TxtElectrolisis')" size="7" readonly="" id="Correlativo" value="<?php echo $Correlativo;?>"></td>			
          	
		  </tr>
        </table>
        <br>
        <table width="100%" border="0" class="TablaInterior">
          <tr> 
            <td width="85">&nbsp;</td>
            <td width="81" class="titulo_azul">N&deg;&nbsp;Electrolisis:</td>
            <td width="129"><input name="TxtElectrolisis" type="text" id="TxtElectrolisis" onKeyDown="TeclaPulsada1Lixi1('TxtPeso')" value="<?php echo $TxtElectrolisis;?>" size="20" maxlength="20"></td>
            <td width="41" class="titulo_azul">Peso:</td>
            <td width="133"><input name="TxtPeso" type="text" id="TxtPeso" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($TxtPeso,2,',','');?>" size="20" maxlength="20"></td>
            <td width="63" align="left" valign="middle" class="titulo_azul">Humedad: </td>
            <td width="196" align="left" valign="middle"><input name="TxtHumedad" type="text" id="TxtHumedad" onKeyDown="TeclaPulsada1Lixi1('BtnGrabar')" value="<?php echo number_format($TxtHumedad,2,',','.') ?>" size="15" maxlength="15"></td>
          </tr>
          <tr align="center" valign="middle"> 
            <td colspan="7"> <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:60px;" onClick="ProcesoLixi1C('G');"> 
              <input name="BtnModificar" type="button" id="BtnModificar" value="Modificar" style="width:60px;" onClick="ProcesoLixi1C('M');"> 
              <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:60px;" onClick="ProcesoLixi1C('E');"> 
            <input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:60px;" onClick="ProcesoLixi1C('C');"></td>
          </tr>
        </table>
        <br>
        <table width="549" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr class="TituloCabeceraAzul"> 
            <td width="37" height="15" >&nbsp;</td>
            <td width="69" align="center"><strong>Turno</strong></td>
            <td width="127" align="center"><strong>Num. Elec.</strong></td>
            <td width="98" align="center"><strong>Correlativo</strong></td>
            <td width="98" align="center"><strong>Peso</strong></td>
            <td width="106" align="center"><strong>Humedad</strong></td>
          </tr>
          <?php	
	$Consulta = "select * from pmn_web.carga_lixiviacion_barro_aurifero ";
	$Consulta.= " where fecha = '".$AnoAuri."-".$MesAuri."-".$DiaAuri."'";	  
	//$Consulta.= " and  turno = '".$Turno."'";	  
	$Consulta.= " order by turno,num_electrolisis";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	$i=1;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'><input type='checkbox' name='ChkTurno[".$i."]' value='".$Row[turno]."'>\n";
		echo "<input type='hidden' name='ChkNumElec[".$i."]' value='".$Row[num_electrolisis]."'>\n";
		echo "<input type='hidden' name='ChkPeso[".$i."]' value='".$Row["peso"]."'>\n";
		echo "<input type='hidden' name='ChkHumedad[".$i."]' value='".$Row[humedad]."'>\n";
		echo "</td>\n";
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase = ".$Row[turno];
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp2))
		{
			echo "<td align='center'>".strtoupper($Row2["nombre_subclase"])."</td>\n";
		}
		else
		{
			echo "<td>&nbsp;</td>\n";
		}
		echo "<td align='center'>".$Row[num_electrolisis]."</td>\n";
		echo "<td align='center'>".$Row[correlativo]."</td>\n";		
		echo "<td align='center' >".number_format($Row["peso"],2,",","")."</td>\n";
		echo "<td align='center' >".number_format($Row[humedad],2,",","")."</td>\n";		
		echo "</tr>\n";
		$i++;
	}
?>
      </table> </td>
	</tr>
</table>
<?php //include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
