<?php
	$HoraActual = date("H");
	$MinutoActual = date("i");
    $DiaActual=date("d");
    $MesActual=date("m");
    $AnoActual=date("Y");
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 5;
	include("../principal/conectar_pmn_web.php");
	//include('funciones/pmn_funciones.php'); 
	if ($ConsultaHornoP == "S")
	{
		$MostrarHornoProd = "S";
		$DiaHP = intval($IdDiaHornoP);
		$MesHP = intval($IdMesHornoP);
		$AnoHP = intval($IdAnoHornoP);
		$Dia = intval($IdDiaHornoP);
		$Mes = intval($IdMesHornoP);
		$Ano = intval($IdAnoHornoP);
		//echo "aca";
		$Hornada = $IdHornadaHornoP;
	}
	if($Recarga=='S')
	{
		$AnoHP=$AnoRecar;$MesHP=$MesRecar;$DiaHP=$DiaRecar;
		$MostrarHornoProd='S';
	}
	if ($MostrarHornoProd == "S")
	{
		$Consulta = "select * from pmn_web.produccion_horno_trof ";
		$Consulta.= " where fecha = '".$AnoHP."-".$MesHP."-".$DiaHP."'";
		$Consulta.= " and hornada = '".$Hornada."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$Hornada = $Row["hornada"];
			$Obs = $Row["observacion"];
			$GasIni = $Row[gas_natural_ini];
			$GasFin = $Row[gas_natural_fin];
			$NumAnodos = $Row[num_anodos];
			$Peso = $Row["peso"];
			$Operador = $Row[operador];
			$Color = $Row[color];
			$AnoCarga=substr($Row[inicio_fusion],0,4);
			$MesCarga=substr($Row[inicio_fusion],5,2);			
			$DiaCarga=substr($Row[inicio_fusion],8,2);			
			$HCarga=substr($Row[inicio_fusion],11,2);			
			$MinCarga=substr($Row[inicio_fusion],14,2);			
			
			$AnoOxida=substr($Row[inicio_oxida],0,4);
			$MesOxida=substr($Row[inicio_oxida],5,2);			
			$DiaOxida=substr($Row[inicio_oxida],8,2);			
			$HOxida=substr($Row[inicio_oxida],11,2);			
			$MinOxida=substr($Row[inicio_oxida],14,2);			
			
			$AnoMol=substr($Row[inicio_moldeo],0,4);
			$MesMol=substr($Row[inicio_moldeo],5,2);			
			$DiaMol=substr($Row[inicio_moldeo],8,2);			
			$HMol=substr($Row[inicio_moldeo],11,2);			
			$MinMol=substr($Row[inicio_moldeo],14,2);			

			$AnoTMol=substr($Row[termino_moldeo],0,4);
			$MesTMol=substr($Row[termino_moldeo],5,2);			
			$DiaTMol=substr($Row[termino_moldeo],8,2);			
			$HTMol=substr($Row[termino_moldeo],11,2);			
			$MinTMol=substr($Row[termino_moldeo],14,2);			

			$HD_fusion=$Row[HD_fusion];
			$HD_oxida=$Row[HD_oxida];
			$HD_moldeo=$Row[HD_moldeo];
			$HD_tmoldeo=$Row[HD_tmoldeo];
			$HDetenciones=$HD_fusion+$HD_oxida+$HD_moldeo+$HD_tmoldeo;
		}
	}
	if(isset($DiaHP))
		$Dia=$DiaHP;
	if(isset($MesHP))
		$Mes=$MesHP;
	if(isset($AnoHP))
		$Ano=$AnoHP;
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">

function ProcesoHorno2(opt)
{
	 var f = frmPrincipalHorno2;
	 switch (opt)
	 {
	 	case "GC":
			if (f.Hornada.value == "")
			{
				alert("Debe Ingresar Hornada");
				f.Hornada.focus();
				return;
			}
			f.action= "pmn_ing_produccion_horno_trof01.php?Proceso=GC";
			f.submit();
			break;
		case "EC":
			var mensaje = confirm("�Esta seguro que desea eliminar �sta Hornada?");
			if (mensaje == true)
			{
				f.action= "pmn_ing_produccion_horno_trof01.php?Proceso=EC";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "S":  //SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=06&Nivel=1&CodPantalla=103";
			f.submit();
			break
	 	case "R":
			f.action= "pmn_principal_reportes.php?Tab2=true&TabHorno2=true&Recarga=S&DiaRecar="+f.Dia.value+"&MesRecar="+f.Mes.value+"&AnoRecar="+f.Ano.value+'&Hornada='+f.Hornada.value;
			f.submit();
			break;
		case "B":
			var URL = "pmn_ing_produccion_horno_trof02.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "C":
			f.action= "pmn_ing_produccion_horno_trof01.php?Proceso=C";
			f.submit();
			break;
	 }     
}

function ProcesoProductoHorno2(opt)
{
	var f = frmPrincipalHorno2;
	switch (opt)
	{
		case "GP":
			if (f.Producto.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if (f.Subproducto.value == "S")
			{
				alert("Debe seleccionar Sub-Producto");
				f.Subproducto.focus();
				return;
			}
			if (f.CmbTurno.value == "S")
			{
				alert("Debe seleccionar Turno");
				f.CmbTurno.focus();
				return;
			}
			if (f.NumOllas.value == "")
			{
				alert("Debe ingresar n�mero de Ollas");
				f.NumOllas.focus();
				return;
			}
			f.action= "pmn_ing_produccion_horno_trof01.php?Proceso=GP";
			f.submit();
			break;
		case "EP":
			var mensaje = confirm("�Esta seguro que desea eliminar �ste(os) registro?");
			if (mensaje == true)
			{
				f.action= "pmn_ing_produccion_horno_trof01.php?Proceso=EP";
				f.submit();
			}
			else
			{
				return;
			}
			break;
	}
}

function ProcesoLeyesHorno2(opt)
{
	var f = frmPrincipalHorno2;
	switch (opt)
	{
		case "GL":
			if (f.CmbLeyes.value == "S")
			{
				alert("Debe seleccionar Ley");
				f.CmbLeyes.focus();
				return;
			}
			
			f.action= "pmn_ing_produccion_horno_trof01.php?Proceso=GL";
			f.submit();
			break;
		case "EL":
			var mensaje = confirm("�Esta seguro que desea eliminar �ste(os) registro?");
			if (mensaje == true)
			{
				f.action= "pmn_ing_produccion_horno_trof01.php?Proceso=EL";
				f.submit();
			}
			else
			{
				return;
			}
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipalHorno2" method="post" action="">
<?php //include("../principal/encabezado.php")?>
  <table width="98%" border="0" cellpadding="5" cellspacing="0" class="TituloCabeceraOz">
    <tr>
      <td align="center" valign="middle">
	   <table width="455" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="64" height="30" class="titulo_azul">Fecha</td>
            <td width="264">
              <?php 
				if ($MostrarHornoProd == "S")
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
            <td width="106"><input name="ver" type="button" style="width:70" value="Consultar" onClick="ProcesoHorno2('B');"></td>
          </tr>
        </table>
        <br>
		<table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="98" class="titulo_azul">Hornada</td>
            <td width="78"><?php
				if ($MostrarHornoProd == "S")
				{
					echo $Hornada."<input name='Hornada' type='hidden' value='".$Hornada."' size=15 maxlength=20>\n";
				}	
				else	echo "<input name='Hornada' type='text' value='".$Hornada."' size=15 maxlength=20>\n";
			?></td>
            <td width="103" class="titulo_azul">Observaci&oacute;n</td>
            <td colspan="3"><textarea name="Obs" cols="100"><?php echo $Obs; ?></textarea></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Gas Natural I</td>
            <td><input name="GasIni" type="text" value="<?php echo $GasIni; ?>" size="12" maxlength="15"></td>
            <td class="titulo_azul">Gas Natural F</td>
            <td width="82"><input name="GasFin" type="text" value="<?php echo $GasFin; ?>" size="12" maxlength="15"></td>
            <td width="73" class="titulo_azul">Operador</td>
            <td width="228"><select name="Operador" style="width:220px">
            <option value="S">Seleccionar</option>
			<?php
				//LlenaCombosPersonalPmnHornoP(&$Operador,"4");
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sub_clase t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.nombre_subclase = t2.rut ";
				$sql.= " where t1.cod_clase = '6015' and t1.valor_subclase1='4' ";
				$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
				$resultComboPMN = mysqli_query($link, $sql);
				while ($rowComboPMN = mysqli_fetch_array($resultComboPMN))
				{
					$Nombre = ucwords(strtolower($rowComboPMN["apellido_paterno"]." ".$rowComboPMN["apellido_materno"]." ".$rowComboPMN["nombres"]));
					if ($rowComboPMN[rut] == $Operador)
					{
						echo "<option selected value='".$rowComboPMN[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$rowComboPMN[rut]."'>".$Nombre."</option>\n";
					}
				}
			?>
          </select>
		  <?php //echo $slq;?>            </td>
          </tr>
          <tr> 
            <td class="titulo_azul">N. &Aacute;nodos</td>
            <td><strong> 
              <input name="NumAnodos" type="text" value="<?php echo $NumAnodos; ?>" size="12" maxlength="15">
              </strong></td>
            <td class="titulo_azul">Peso (Kgs)</td>
            <td><strong> 
              <input name="Peso" type="text" value="<?php echo number_format($Peso,2,',','.'); ?>" size="12" maxlength="15" onKeyDown="SoloNumeros(true,this)">
              </strong></td>
            <td class="titulo_azul">Color </td>
            <td><select name="Color" id="Color" style="width:150px;">
                <?php
				echo "<option value='S' selected>Seleccionar</option>";
				$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 6001 order by cod_subclase ";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Color == $Row["cod_subclase"])
						echo "<option value='".$Row["cod_subclase"]."' selected>".$Row["nombre_subclase"]."</option>\n";
					else echo "<option value='".$Row["cod_subclase"]."'>".$Row["nombre_subclase"]."</option>\n";	
				}
			?>
              </select>            </td>
          </tr>
          <tr>
            <td class="titulo_azul">Inicio Carga (Fusi&oacute;n) </td>
            <td colspan="3">
<?php 
					echo "<select name='DiaCarga' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaCarga))
						{
							if ($i == $DiaCarga)
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
				  echo "</select> <select name='MesCarga' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesCarga))
						{
							if ($i == $MesCarga)
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
				  echo "</select> <select name='AnoCarga' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($AnoCarga))
						{
							if ($i == $AnoCarga)
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
			?>			
			<select name="HCarga" id="HCarga">
			  <?php
					for ($i=0;$i<=23;$i++)
					{
						if ($i<10)
							$Valor = "0".$i;
						else	$Valor = $i;
						if (isset($HCarga))
						{	
							if ($HCarga == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
						else
						{	
							if ($HoraActual == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
					}
					?>
					</select>
					<strong>:</strong>
					<select name="MinCarga">
					  <?php
						for ($i=0;$i<=59;$i++)
						{
							if ($i<10)
								$Valor = "0".$i;
							else	$Valor = $i;
							if (isset($MinCarga))
							{	
								if ($MinCarga == $Valor)
									echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
								else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
							}
							else
							{
								if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";
							}
						}
						?>
					</select>&nbsp;</td>
            <td class="titulo_azul">Horas Detenci&oacute;n</td>
            <td><label>
              <input name="HD_fusion" type="text" id="HD_fusion" value="<?php echo $HD_fusion;?>" size="2" maxlength="2">
            </label></td>
          </tr>
          <tr>
            <td class="titulo_azul"><span class="formulario">Inicio Oxidaci&oacute;n </span></td>
            <td colspan="3"><?php 
					echo "<select name='DiaOxida' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaOxida))
						{
							if ($i == $DiaOxida)
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
				  echo "</select> <select name='MesOxida' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesOxida))
						{
							if ($i == $MesOxida)
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
				  echo "</select> <select name='AnoOxida' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($AnoOxida))
						{
							if ($i == $AnoOxida)
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
			?>
              <select name="HOxida" id="HOxida">
                <?php
					for ($i=0;$i<=23;$i++)
					{
						if ($i<10)
							$Valor = "0".$i;
						else	$Valor = $i;
						if (isset($HOxida))
						{	
							if ($HOxida == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
						else
						{	
							if ($HoraActual == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
					}
					?>
              </select>
              <strong>:</strong>
              <select name="MinOxida">
                <?php
						for ($i=0;$i<=59;$i++)
						{
							if ($i<10)
								$Valor = "0".$i;
							else	$Valor = $i;
							if (isset($MinOxida))
							{	
								if ($MinOxida == $Valor)
									echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
								else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
							}
							else
							{
								if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";
							}
						}
						?>
              </select>
            &nbsp;</td>
            <td class="titulo_azul">Horas Detenci&oacute;n</td>
            <td><input name="HD_oxida" type="text" id="HD_oxida" value="<?php echo $HD_oxida;?>" size="2" maxlength="2"></td>
          </tr>
          <tr>
            <td class="titulo_azul">Inicio Moldeo </td>
            <td colspan="3"><?php 
					echo "<select name='DiaMol' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaMol))
						{
							if ($i == $DiaMol)
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
				  echo "</select> <select name='MesMol' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesMol))
						{
							if ($i == $MesMol)
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
				  echo "</select> <select name='AnoMol' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($AnoMol))
						{
							if ($i == $AnoMol)
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
			?>
              <select name="HMol" id="HMol">
                <?php
					for ($i=0;$i<=23;$i++)
					{
						if ($i<10)
							$Valor = "0".$i;
						else	$Valor = $i;
						if (isset($HMol))
						{	
							if ($HMol == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
						else
						{	
							if ($HoraActual == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
					}
					?>
              </select>
              <strong>:</strong>
              <select name="MinMol">
                <?php
						for ($i=0;$i<=59;$i++)
						{
							if ($i<10)
								$Valor = "0".$i;
							else	$Valor = $i;
							if (isset($MinMol))
							{	
								if ($MinMol == $Valor)
									echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
								else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
							}
							else
							{
								if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";
							}
						}
						?>
              </select>
&nbsp;</td>
            <td class="titulo_azul">Horas Detenci&oacute;n</td>
            <td><input name="HD_moldeo" type="text" id="HD_moldeo" value="<?php echo $HD_moldeo;?>" size="2" maxlength="2"></td>
          </tr>
          <tr>
            <td class="titulo_azul">Termino Moldeo </td>
            <td colspan="3"><?php 
					echo "<select name='DiaTMol' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaTMol))
						{
							if ($i == $DiaTMol)
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
				  echo "</select> <select name='MesTMol' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesTMol))
						{
							if ($i == $MesTMol)
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
				  echo "</select> <select name='AnoTMol' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($AnoTMol))
						{
							if ($i == $AnoTMol)
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
			?>
              <select name="HTMol" id="HTMol">
                <?php
					for ($i=0;$i<=23;$i++)
					{
						if ($i<10)
							$Valor = "0".$i;
						else	$Valor = $i;
						if (isset($HTMol))
						{	
							if ($HTMol == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
						else
						{	
							if ($HoraActual == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
					}
					?>
              </select>
              <strong>:</strong>
              <select name="MinTMol">
                <?php
						for ($i=0;$i<=59;$i++)
						{
							if ($i<10)
								$Valor = "0".$i;
							else	$Valor = $i;
							if (isset($MinTMol))
							{	
								if ($MinTMol == $Valor)
									echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
								else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
							}
							else
							{
								if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";
							}
						}
						?>
              </select>
&nbsp;</td>
            <td class="titulo_azul">Horas Detenci&oacute;n</td>
            <td><input name="HD_tmoldeo" type="text" id="HD_tmoldeo" value="<?php echo $HD_tmoldeo;?>" size="2" maxlength="2"></td>
          </tr>
          <tr>
            <td class="titulo_azul">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td class="titulo_azul">Total Detenciones </td>
            <td class="formulario"><input name="HDetenciones" type="text" id="HDetenciones" value="<?php echo $HDetenciones;?>" size="3"> 
            Horas </td>
          </tr>
        </table>
		<table width="700" border="0">
          <tr>
            <td align="center" valign="middle"> 
              <input name="BtnGrabar" type="button" value="Grabar" style="width:70px;" onClick="ProcesoHorno2('GC');">
              &nbsp; 
              <input name="BtnEliminar" type="button" value="Eliminar" style="width:70px;" onClick="ProcesoHorno2('EC');">
              &nbsp; 
              <input name="BtnCancelar" type="submit" id="BtnCancelar" style="width:70px;" onClick="ProcesoHorno2('C');" value="Cancelar">
            &nbsp;</td>
          </tr>
        </table>
        <hr>
	<table width="760" border="0">
          <tr>
            <td width="375" valign="top"> 
              <table width="370" align="left" cellpadding="3" cellspacing="0" class="TablaInterior">
                <tr> 
                  <td class="titulo_azul">Producto</td>
                  <td colspan="3"><strong> 
                    <select name="Producto" style="width:220px" onChange="ProcesoHorno2('R');">
                      <option value="S">Seleccionar</option>
                      <?php
				$Consulta = "select distinct(t2.cod_producto), t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.productos t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1 = t2.cod_producto and t1.nombre_subclase='4'";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				$Existe = "N";
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					$Existe = "S";
					if ($Producto == $Row["cod_producto"])
						echo "<option selected value='".$Row["cod_producto"]."'>";														
					else	echo "<option value='".$Row["cod_producto"]."'>";
					//printf("%'03d",$Row["cod_producto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
/*				if ($Existe == "S")				
					echo "<option value='S'>-----------------------------</option>\n";
				$Consulta = "select * from proyecto_modernizacion.productos order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Producto == $Row["cod_producto"])
								echo "<option selected value='".$Row["cod_producto"]."'>";														
							else	echo "<option value='".$Row["cod_producto"]."'>";
							//printf("%'03d",$Row["cod_producto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}*/
			?>
                    </select>
                    </strong></td>
                </tr>
                <tr> 
                  <td width="84" class="titulo_azul">SubProducto</td>
                  <td colspan="3"><strong> 
                    <select name="Subproducto" style="width:220px">
                      <option value="S">Seleccionar</option>
                      <?php
				$Consulta = "select distinct(t2.cod_subproducto), t2.descripcion ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.subproducto t2 on ";
				$Consulta.= " t1.cod_clase='6003' and t1.valor_subclase1='".$Producto."' and ";
				$Consulta.= " t1.valor_subclase2 = t2.cod_subproducto and t2.cod_producto='".$Producto."' and t1.nombre_subclase='4'";
				$Consulta.= " order by t2.descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				$Existe = "N";
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					$Existe = "S";
					if ($Producto == $Row["cod_subproducto"])
						echo "<option selected value='".$Row["cod_subproducto"]."'>";														
					else	echo "<option value='".$Row["cod_subproducto"]."'>";
					//printf("%'03d",$Row["cod_subproducto"]);
					echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}
				/*if ($Existe == "S")				
					echo "<option value='S'>-----------------------------</option>\n";
				$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$Producto."' order by descripcion";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Subproducto == $Row["cod_subproducto"])
								echo "<option selected value='".$Row["cod_subproducto"]."'>";														
							else	echo "<option value='".$Row["cod_subproducto"]."'>";
							//printf("%'03d",$Row["cod_subproducto"]);
							echo " ".ucwords(strtolower($Row["descripcion"]))."</option>\n";
				}*/
			?>
                    </select>
                    </strong></td>
                </tr>
                <tr> 
                  <td class="titulo_azul">Turno</td>
                  <td width="50">
				  <select name="CmbTurno" style="width:50px" onChange="Proceso('R');">
                    <?php
				$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase not in('2') order by cod_subclase";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					if ($Row["cod_subclase"] == $CmbTurno)
						echo "<option selected value='".$Row["cod_subclase"]."'>".$Row["nombre_subclase"]."</option>";
					else	echo "<option value='".$Row["cod_subclase"]."'>".$Row["nombre_subclase"]."</option>";
				}
			?>
                  </select></td>
                  <td width="56">N. Ollas</td>
                  <td width="115"><input name="NumOllas" type="text" id="NumOllas2" value="<?php echo $NumOllas; ?>" size="12" maxlength="15">
                    <input name="BtnOKDetalle" type="button" id="BtnOKDetalle" value="OK" onClick="ProcesoProductoHorno2('GP');"></td>
                </tr>
              </table>
            
            </td>
            <td width="375" valign="top"><table width="370" cellpadding="3" border="0" cellspacing="0" class="TablaInterior">
                <tr class="TituloCabeceraAzul" > 
                  <td width="18"><input name="BtnElimDetalle" type="button" style="width:30px;" onClick="ProcesoProductoHorno2('EP');" value="X"></td>
                  <td width="52"><center>
                      <strong> Turno</strong></center></td>
                  <td width="140"><center>
                      <strong> Prod.Subproducto</strong></center></td>
                  <td width="87"><center>
                      <strong> N. Ollas</strong></center></td>
                </tr>
                <?php
					$Consulta = "select t1.turno, t1.cod_producto, t1.cod_subproducto, t1.num_ollas,";
					$Consulta.= " t2.nombre_subclase as nom_turno, t3.descripcion as nom_subproducto";
					$Consulta.= " from pmn_web.detalle_prod_horno_trof t1 left join proyecto_modernizacion.sub_clase t2 on ";
					$Consulta.= " t1.turno = t2.cod_subclase and t2.cod_clase = 1 left join proyecto_modernizacion.subproducto t3 on ";
					$Consulta.= " t1.cod_subproducto = t3.cod_subproducto and t3.cod_producto = t1.cod_producto ";
					$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Consulta.= " and hornada = '".$Hornada."'";
					$Consulta.= " order by turno, cod_producto, cod_subproducto";
					$Respuesta = mysqli_query($link, $Consulta);
					$i = 1;
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						echo "<tr align='center'>\n";
						echo "<td> <input name='ChkTurno[".$i."]' class='SinBorde' type='checkbox' value='".$Row[turno]."'><input name='ChkProducto[".$i."]' type='hidden' value='".$Row["cod_producto"]."'><input name='ChkSubProducto[".$i."]' type='hidden' value='".$Row["cod_subproducto"]."'></td>\n";
						echo "<td> <input readonly name='TxtTurno' type='text' size='2' value='".$Row[nom_turno]."'></td>\n";
						echo "<td> <input readonly name='TxtSubProd' type='text' size='30' value='".$Row["nom_subproducto"]."'></td>\n";
						echo "<td> <input readonly name='TxtNumOllas' type='text' size='9' value='".$Row[num_ollas]."'></td>\n";
						echo "</tr>\n";
						$i++;
					}
				?>
              </table> </td>
          </tr>
        </table>
        <table width="370" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="57" class="titulo_azul">Leyes</td>
            <td colspan="3"><select name="CmbLeyes" style="width:200px;">
                <?php
				echo'<option value = "S">Seleccionar</option>';
				$Consulta = "select distinct(t2.cod_leyes), t2.nombre_leyes, t2.abreviatura ";
				$Consulta.= " from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.leyes t2 on ";
				$Consulta.= " t1.cod_clase='6005' and t1.valor_subclase1 = t2.cod_leyes and t1.nombre_subclase='5'";
				$Consulta.= " order by t2.nombre_leyes";
				$Respuesta = mysqli_query($link, $Consulta);
				$Existe = "N";
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					$Existe = "S";
					if ($CmbLeyes == $Row["cod_leyes"])
						echo "<option selected value='".$Row["cod_leyes"]."'>";														
					else	echo "<option value='".$Row["cod_leyes"]."'>";
					//printf("%'03d",$Row["cod_subproducto"]);
					echo " ".ucwords(strtolower($Row["nombre_leyes"]))." (".$Row["abreviatura"].")</option>\n";
				}
				//echo $Consulta;
				if ($Existe == "S")				
					echo "<option value='S'>-----------------------------</option>\n";
				$Consulta1="select cod_leyes, abreviatura, nombre_leyes from leyes order by nombre_leyes"; 
				$Respuesta = mysqli_query($link, $Consulta1);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbLeyes==$Fila["cod_leyes"])
					{
						echo "<option value = '".$Fila["cod_leyes"]."' selected>".ucwords(strtolower($Fila["nombre_leyes"]))." (".$Fila["abreviatura"].")</option>\n";
					}
					else
					{
						echo "<option value = '".$Fila["cod_leyes"]."'>".ucwords(strtolower($Fila["nombre_leyes"]))." (".$Fila["abreviatura"].")</option>\n";
					}
				}
			?>
              </select> <?php //echo $Consulta;?></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Muestra 1</td>
            <td width="92"><input name="Muestra01" type="text" id="Muestra012" onKeyDown="SoloNumeros(true,this)" size="15" maxlength="15"></td>
            <td colspan="2"> <select name="Hora01" id="select3">
                <?php
					for ($i=0;$i<=23;$i++)
					{
						if ($i<10)
							$Valor = "0".$i;
						else	$Valor = $i;
						if (isset($Hora01))
						{	
							if ($Hora01 == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
						else
						{	
							if ($HoraActual == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
					}
					?>
              </select> <strong>:</strong> <select name="Minutos01">
                <?php
						for ($i=0;$i<=59;$i++)
						{
							if ($i<10)
								$Valor = "0".$i;
							else	$Valor = $i;
							if (isset($Minutos01))
							{	
								if ($Minutos01 == $Valor)
									echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
								else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
							}
							else
							{
								if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";
							}
						}
						?>
              </select></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Muestra 2</td>
            <td><input name="Muestra02" type="text" id="Muestra022" onKeyDown="SoloNumeros(true,this)" size="15" maxlength="15"></td>
            <td colspan="2"><select name="Hora02" id="select4">
                <?php
					for ($i=0;$i<=23;$i++)
					{
						if ($i<10)
							$Valor = "0".$i;
						else	$Valor = $i;
						if (isset($Hora02))
						{	
							if ($Hora02 == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
						else
						{	
							if ($HoraActual == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
					}
					?>
              </select> <strong>:</strong> <select name="Minutos02">
                <?php
						for ($i=0;$i<=59;$i++)
						{
							if ($i<10)
								$Valor = "0".$i;
							else	$Valor = $i;
							if (isset($Minutos02))
							{	
								if ($Minutos02 == $Valor)
									echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
								else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
							}
							else
							{
								if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";
							}
						}
						?>
              </select></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Muestra 3</td>
            <td><input name="Muestra03" type="text" id="Muestra032" onKeyDown="SoloNumeros(true,this)" size="15" maxlength="15"> 
            </td>
            <td width="118"><select name="Hora03" id="select6">
                <?php
					for ($i=0;$i<=23;$i++)
					{
						if ($i<10)
							$Valor = "0".$i;
						else	$Valor = $i;
						if (isset($Hora03))
						{	
							if ($Hora03 == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
						else
						{	
							if ($HoraActual == $Valor)
								echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
							else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
						}
					}
					?>
              </select> <strong>:</strong> <select name="Minutos03">
                <?php
						for ($i=0;$i<=59;$i++)
						{
							if ($i<10)
								$Valor = "0".$i;
							else	$Valor = $i;
							if (isset($Minutos03))
							{	
								if ($Minutos03 == $Valor)
									echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
								else		echo "<option value='".$Valor."'>".$Valor."</option>\n";		
							}
							else
							{
								if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";				
							}
						}
						?>
              </select></td>
            <td width="76"><input name="BtnOKLeyes" type="button" id="BtnOKLeyes4" value="OK" onClick="ProcesoLeyesHorno2('GL');"></td>
          </tr>
        </table>
        <table width="760" border="0">
          <tr>
            <td align="center" valign="top" > 
				<table width="370" cellpadding="3" border="0" cellspacing="0" class="TablaInterior">
                <tr class="TituloCabeceraAzul"> 
                  <td width="20"><input name="BtnElimLeyes" type="button" value="X" style="width:30px;" onClick="ProcesoLeyesHorno2('EL');"></td>
                  <td width="53"><center>
                      <strong> Leyes  </strong></center></td>
                  <td width="10"><center>
                      </center></td>
				  <td width="103"><center>
                      <strong> Muestra 1  </strong></center></td>
				  <td width="103"><center>
                      <strong> Hora 1  </strong></center></td>	  
                  <td width="95"><center>
                      <strong> Muestra 2</strong></center></td>
                  <td width="103"><center>
                      <strong> Hora 2  </strong></center></td>	  
				  <td width="101"><center>
                      <strong> Muestra 3</strong></center></td>
                	<td width="103"><center>
                      <strong> Hora 3  </strong></center></td>	  
				</tr>
				<?php
					$Consulta = "select t1.cod_leyes, t2.abreviatura, t1.muestra01, t1.muestra02, t1.muestra03,t3.abreviatura as AbrevUni,hora01,hora02,hora03 ";
					$Consulta.= " from pmn_web.leyes_prod_horno_trof t1 inner join proyecto_modernizacion.leyes t2 on ";
					$Consulta.= " t1.cod_leyes = t2.cod_leyes ";
					$Consulta.=" inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad  ";
					$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Consulta.= " and hornada = '".$Hornada."'";
					$Consulta.= " order by cod_leyes";
					//echo $Consulta."<br>";
					$Respuesta = mysqli_query($link, $Consulta);
					$i=1;
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						echo "<tr align='center'>\n";
						echo "<td> <input name='ChkLey[".$i."]' type='checkbox' class='SinBorde' value='".$Row["cod_leyes"]."'></td>\n";
						echo "<td> <input readonly name='TxtLey' type='text' size='5' maxlength='10' value='".$Row["abreviatura"]."'></td>\n";
						echo "<td width='10'>".$Row[AbrevUni]."</td>";
						echo "<td> <input readonly name='TxtMuestra1' type='text' size='9' value='".$Row[muestra01]."'></td>\n";
						echo "<td> <input readonly name='TxtHora01' type='text' size='9' value='".$Row[hora01]."'></td>\n";
						echo "<td> <input readonly name='TxtMuestra2' type='text' size='9' value='".$Row[muestra02]."'></td>\n";
						echo "<td> <input readonly name='TxtHora02' type='text' size='9' value='".$Row[hora02]."'></td>\n";
						echo "<td> <input readonly name='TxtMuestra3' type='text' size='9' value='".$Row[muestra03]."'></td>\n";
						echo "<td> <input readonly name='TxtHora03' type='text' size='9' value='".$Row[hora03]."'></td>\n";
						echo "</tr>\n";
						$i++;
					}
				?>
              </table></td>
          </tr>
        </table>        
      </td>
</tr>
</table>
</form>
	</body>
</html>

