<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 7;
	include("../principal/conectar_pmn_web.php");
	include('funciones/pmn_funciones.php'); 
	if ($VerElect1== "K")
	{
		$Ano=$AnElect1;
		$Mes=$MeElect1;
		$Dia=$DiElect1;
		$NumElectrolisis=$NumElectrolisis2;
	}
	if($TabElec1=='true' && $VerElect1!= "K")
	{
		$Ano=$AnoMod;
		$Mes=$MesMod;
		$Dia=$DiaMod;
	}
	if($Electrodo1=='true')
	{
		$Ano=$AnElect1;
		$Mes=$MeElect1;
		$Dia=$DiElect1;
		$NumElectrolisis=$NumElectrolisis2;
	}
	if ($MostrarElect1 == "S")
	{
		if ($VerElect1=="S")
		{
			$Grupo=$GruElect1;
			$Correlativo=$CorElect1;
			$Ano=$AElect1;
			$Mes=$MElect1;
			$Dia=$DElect1;
		}
		else
		{
			$Ano=$AnoMod;
			$Mes=$MesMod;
			$Dia=$DiaMod;
		}
		$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " and turno = '".$Turno."' and hornada = '".$Hornada."'";//
		$Consulta.= " and grupo = '".$Grupo."'";
		$Consulta.= " and correlativo = '".$Correlativo."'";
		$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
		//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$Obs = $Row["observacion"];
			$Operador = $Row[operador];
			
			//if($Ver!="S")
			//{
			$CantAnodos = $Row[cant_anodos];
			$PesoAnodos = $Row[peso_anodos];
			$HornadaElect=$Row["hornada"];
			//}
			$JefeTurno = $Row[jefe_turno];
		}
	$MostrarElect1='';	
	$Consulta='S';
	$NumElectrolisis2=$NumElectrolisis;
	}
	if($B=='S')
	{
		$NumElectrolisis='';
		$Grupo='';
		$Correlativo='';
		$JefeTurno='S';
		$Operador='S';
		$Obs='';
	}
	if($Graba=='S')
	{
		$Ano=$AnoMod;
		$Mes=$MesMod;
		$Dia=$DiaMod;
		$NumElectrolisis2=$NumElectrolisis;
		$Consulta='S';
	}
	if($Elim=='S')
	{
		$Ano=$AnoMod;
		$Mes=$MesMod;
		$Dia=$DiaMod;
		$NumElectrolisis2=$Electrolisis;
		$Consulta='S';
	}
	if($Consulta=='S')
	{
		$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " and num_electrolisis = '".$NumElectrolisis2."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$NumElectrolisis=	$Row[num_electrolisis];
			$Turno=	$Row[turno];
			$Grupo=	$Row["grupo"];
			$Correlativo=	$Row[correlativo];
			$JefeTurno = $Row[jefe_turno];
			$Operador = $Row[operador];
			$Obs = $Row["observacion"];
		}			
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_pmn_web.css" rel="stylesheet" type="text/css">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ProcesoElect1(opt)
{
	var f = document.frmPrincipalRpt;
	switch (opt)
	{
		case "G": //GRABAR
			if (f.Grupo.value == "")
			{
				alert("Debe Ingresar Grupo");
				f.Grupo.focus();
				return;
			}
			if (f.NumElectrolisis.value == "")
			{
				alert("Debe Ingresar Num. Electrolisis");
				f.NumElectrolisis.focus();
				return;
			}
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
			if (f.HornadaElect.value == "-1")
			{
				alert("Debe Seleccionar Hornada");
				f.HornadaElect.focus();
				return;
			}
			if (f.CantAnodos.value == "")
			{
				alert("Debe Ingresar Cantidad de Anodos");
				f.CantAnodos.focus();
				return;
			}
			if (f.PesoAnodos.value == "")
			{
				alert("Debe Ingresar Peso de los Anodos");
				f.PesoAnodos.focus();
				return;
			}
			//alert(parseInt(f.PesoDispHorno.value)+"<"+parseInt(f.CantAnodos.value))
			if(parseInt(f.CantDispAnodos.value)<parseInt(f.CantAnodos.value))
			{
				alert('Cantidad de Anodos excede a Cantidad Anodos Disponible.')
				return;
			}
			f.action= "pmn_carga_elec_plata01.php?Proceso=G";
	 		f.submit();
			break;
		case "M": //MODIFICAE
			if(parseInt(f.CantDispAnodos.value)<parseInt(f.CantAnodos.value))
			{
				alert('Cantidad de Anodos excede a Cantidad Anodos Disponible.')
				return;
			}
			f.action= "pmn_carga_elec_plata01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR
			f.action= "pmn_carga_elec_plata01.php?Proceso=E";
	 		f.submit();
			break;
		case "C": //CANCELAR
			f.action= "pmn_carga_elec_plata01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //CANCELAR
			var URL = "pmn_carga_elect_plata03.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes,status=yes");
			break;
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=104";
	 		f.submit();
			break;
		case "Ver":
			var URL = "pmn_carga_elect_plata02.php?Electrolisis="+f.NumElectrolisis.value;
			window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
			//f.action="pmn_carga_elect_plata02.php?Electrolisis="+f.NumElectrolisis.value;
	 		//f.submit();
			break;
		case "R":
			f.action= "pmn_principal_reportes.php?Tab3=true&Electrodo1=true&NumElectrolisis2="+f.NumElectrolisis.value+"&AnElect1="+f.Ano.value+"&MeElect1="+f.Mes.value+"&DiElect1="+f.Dia.value;
	 		f.submit();
		break;	
	}
}
function TeclaPulsada1Elect1(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}

function TeclaPulsada2Elect1(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 0)
	{		
		eval("f." + salto + ".focus();");
	}
}

</script>
</head>
	<?php
		if ($MostrarElect1!= "S")
		{
			echo '<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" >';
		}
		else
		{
			echo '<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" >';
		}
	?>	
<body>	
<form name="frmPrincipalElect1" method="post" action="">
  <table width="98%" height="330" border="0" class="TituloCabeceraOz">
    <tr>
		
      <td align="center" valign="top">
	    <table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="106" height="30" class="titulo_azul">Fecha:</td>
            <td width="262" colspan="2"> 
              <?php 
				if (($MostrarElect1 == "S")|| ($VerElect1=="K"))
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
            <td>&nbsp;</td>
            <td width="150"><input name="ver" type="button" style="width:70" value="Consultar" onClick="ProcesoElect1('B');"> 
            </td>
            <td width="113">&nbsp;</td>
          </tr>
          <tr> 
            <td width="106" class="titulo_azul">Num. Electrolisis:</td>
            <td width="131"><input name="NumElectrolisis" type="text" id="NumElectrolisis2" onKeyDown="TeclaPulsada1Elect1('Turno')"  value="<?php echo $NumElectrolisis;?>"></td>
            <td width="131"><input name="BtnElectrisis" type="button" id="BtnElectrisis" value="Ver Elect" onClick="ProcesoElect1('Ver');" ></td>
            <td width="97" class="titulo_azul">Turno: </td>
            <td colspan="2"> 
              <?php
				if ($MostrarElect1 == "S")
				{
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '1' and cod_subclase = '".$Turno."'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Row = mysqli_fetch_array($Respuesta))
					{
						echo strtoupper($Row["nombre_subclase"])."<input type='hidden' name='Turno' value='".$Row["cod_subclase"]."'>";
					}
				}
				else
				{
					echo "<select name='Turno' id='Turno'  style='width:50px'>\n";
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
          </tr>
          <tr> 
            <td class="titulo_azul">Grupo:</td>
            <td colspan="2"><input name="Grupo" type="text" id="Grupo2" onKeyDown="TeclaPulsada1Elect1('Correlativo2')" value="<?php echo $Grupo;?>"></td>
            <td class="titulo_azul">Correlativo:</td>
            <td colspan="2"><input name="Correlativo" type="text" id="Correlativo2" onKeyDown="TeclaPulsada1Elect1('JefeTurno')" value="<?php echo $Correlativo;?>"></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Jefe Turno</td>
            <td colspan="2"><select name="JefeTurno" id="JefeTurno" onChange="TeclaPulsada2Elect1('Operador')" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				//LlenaCombosPersonalPmn(&$JefeTurno,'1');
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sub_clase t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.nombre_subclase = t2.rut ";
				$sql.= " where t1.cod_clase = '6015' and t1.valor_subclase1='1' ";
				$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
				$resultComboPMN = mysqli_query($link, $sql);
				while ($rowComboPMN = mysqli_fetch_array($resultComboPMN))
				{
					$Nombre = ucwords(strtolower($rowComboPMN["apellido_paterno"]." ".$rowComboPMN["apellido_materno"]." ".$rowComboPMN["nombres"]));
					if ($rowComboPMN[rut] == $JefeTurno)
					{
						echo "<option selected value='".$rowComboPMN[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$rowComboPMN[rut]."'>".$Nombre."</option>\n";
					}
				}
				?>
              </select></td>
            <td class="titulo_azul">Operador:</td>
            <td colspan="2"><select name="Operador" onChange="TeclaPulsada2Elect1('Obs')" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				//LlenaCombosPersonalPmn(&$Operador,'5');
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sub_clase t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.nombre_subclase = t2.rut ";
				$sql.= " where t1.cod_clase = '6015' and t1.valor_subclase1='5' ";
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
              </select></td>
			  <?php // echo $val;?>
          </tr>
          <tr> 
            <td class="titulo_azul">Observaci&oacute;n:</td>
            <td colspan="5"><input name="Obs" type="text" id="Obs" onKeyDown="TeclaPulsada1Elect1('Hornada')" value="<?php echo $Obs;?>" size="80" maxlength="80"></td>
          </tr>
  </table>
        <br>
        <table width="100%" border="0" class="TablaInterior">
          <tr> 
            <td width="129" class="titulo_azul">#Hornada:</td>
            <td width="216">
			<?php
			if ($MostrarElect1 != "S")
			{
			?>
			<select name="HornadaElect" onChange="ProcesoElect1('R')">
			<option value='-1' selected="selected">Seleccionar</option>
			<?php
			$FechaCon=$Ano."-".$Mes."-".$Dia;
			$ConsulHorn="select hornada from pmn_web.produccion_horno_trof where year(fecha) >= '2011'";
			//if(isset($HornadaElect))
				//$ConsulHorn.=" where hornada='".$HornadaElect."'";	
			$ConsulHorn.=" order by hornada asc";
			$RespHorn=mysqli_query($link, $ConsulHorn);
			while($FilaHorn=mysqli_fetch_array($RespHorn))
			{
				$Consul2="select num_anodos,peso from pmn_web.produccion_horno_trof where hornada='".$FilaHorn["hornada"]."'";
				$Resp2=mysqli_query($link, $Consul2);$NumAnodos=0;$PesoProd=0;
				while($Fila2=mysqli_fetch_array($Resp2))		
				{		
					$NumAnodos=$Fila2[num_anodos];
					$PesosProd=$Fila2["peso"];
				}	
				$Consul3="select cant_anodos,peso_anodos from pmn_web.carga_electrolisis_plata where hornada='".$FilaHorn["hornada"]."'";
				$Resp3=mysqli_query($link, $Consul3);$NumAnodos2=0;$PesoAnodos2=0;
				while($Fila3=mysqli_fetch_array($Resp3))		
				{
					$PesoAnodos2=$PesoAnodos2+$Fila3[peso_anodos];		
					$NumAnodos2=$NumAnodos2+$Fila3[cant_anodos];
				}	
					
				$ValorResta=$NumAnodos-$NumAnodos2;
				$ValorRestaPesoAux=$PesosProd-$PesoAnodos2;
				if($ValorResta>'0')
				{
					if($HornadaElect==$FilaHorn["hornada"])
					{
						$Anodos=$ValorResta;
						$PesosProd2=$ValorRestaPesoAux;
						echo "<option selected value='".$FilaHorn["hornada"]."'>".$FilaHorn["hornada"]."</option>";
					}	
					else
						echo "<option value='".$FilaHorn["hornada"]."'>".$FilaHorn["hornada"]."</option>";	
				}
			}
			?>
			</select>
			<?php
			}
			else
			{
				$Consul2="select num_anodos,peso from pmn_web.produccion_horno_trof where hornada='".$HornadaElect."'";
				$Resp2=mysqli_query($link, $Consul2);$NumAnodos=0;$PesoProd=0;
				while($Fila2=mysqli_fetch_array($Resp2))		
				{		
					$NumAnodos=$Fila2[num_anodos];
					$PesosProd=$Fila2["peso"];
				}	
				$Consul3="select cant_anodos,peso_anodos from pmn_web.carga_electrolisis_plata where hornada='".$HornadaElect."'";
				$Resp3=mysqli_query($link, $Consul3);$NumAnodos2=0;$PesoAnodos2=0;
				while($Fila3=mysqli_fetch_array($Resp3))		
				{
					$PesoAnodos2=$PesoAnodos2+$Fila3[peso_anodos];		
					$NumAnodos2=$NumAnodos2+$Fila3[cant_anodos];
				}	
				$ValorResta=$NumAnodos-$NumAnodos2;
				$ValorRestaPesoAux=$PesosProd-$PesoAnodos2;
				$Anodos=$ValorResta;
				$PesosProd2=$ValorRestaPesoAux;
				echo $HornadaElect;
				echo "<input type='hidden' name='HornadaElect' value='".$HornadaElect."'>";
				
			}
			?>
			<input type="hidden" name="CantDispAnodos" value="<?php echo $Anodos;?>">
			<!--<input name="Hornada" type="text" id="Hornada" onKeyDown="TeclaPulsada1Elect1('CantAnodos')" value="<?php echo $Hornada;?>" size="20" maxlength="20">--></td>
            <td width="298" class="titulo_azul"><?php echo "Anodos Disp.: <font color='FF0000'>".$Anodos."</font><br>Peso: <font color='FF0000'>".number_format($PesosProd2,2,',','.')."</font>";?>&nbsp;</td>
            <td width="133"><span class="titulo_azul">Cant. Anodos:</span></td>
            <td width="134" class="titulo_azul"><input name="CantAnodos" type="text" id="CantAnodos" onKeyDown="TeclaPulsada1Elect1('PesoAnodos')" value="<?php echo $CantAnodos;?>" size="15" maxlength="15"></td>
            <td width="41"><span class="titulo_azul">Peso:</span></td>
            <td width="298" align="left" valign="middle"><input name="PesoAnodos" type="text" id="PesoAnodos" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($PesoAnodos,2,',','.');?>" size="20" maxlength="20"></td>
          </tr>
          <tr align="center" valign="middle"> 
            <td colspan="7"> 
              <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:60px;" onClick="ProcesoElect1('G');">
              <input name="BtnModificar" type="button" id="BtnModificar" value="Modificar" style="width:60px;" onClick="ProcesoElect1('M');">
              <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:60px;" onClick="ProcesoElect1('E');">
              <input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:60px;" onClick="ProcesoElect1('C');">
              <!--<input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60px;" onClick="ProcesoElect1('S');">-->            </td>
          </tr>
        </table>
        <br>
       	<table width="761" border="0" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr class="TituloCabeceraAzul"> 
            <td width="45" height="15">&nbsp;</td>
            <td width="81"><strong>Turno</strong></td>
            <td width="90"><strong>Grupo</strong></td>
            <td width="100"><strong>Num. Elec.</strong></td>
            <td width="129"><strong>Hornada</strong></td>
            <td width="93"><strong>Correlativo</strong></td>
            <td width="108"><strong>Cant. Anodos</strong></td>
            <td width="112"><strong>Peso</strong></td>
          </tr>
			<?php
				$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
				$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";	
			    $Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";	
				$Consulta.= " order by turno, grupo, num_electrolisis, hornada, correlativo";
				$Respuesta = mysqli_query($link, $Consulta);
				$i=1;
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					echo "<tr>\n";
					echo "<td align='center'><input type='checkbox' name='ChkTurno[".$i."]' value='".$Row[turno]."'>\n";
					echo "<input type='hidden' name='ChkGrupo[".$i."]' value='".$Row["grupo"]."'>\n";
					echo "<input type='hidden' name='ChkNumElec[".$i."]' value='".$Row[num_electrolisis]."'>\n";
					echo "<input type='hidden' name='ChkHornada[".$i."]' value='".$Row["hornada"]."'>\n";
					echo "<input type='hidden' name='ChkCorrelativo[".$i."]' value='".$Row[correlativo]."'>\n";
					echo "</td>\n";
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase = ".$Row[turno];
					$Resp2 = mysqli_query($link, $Consulta);
					if ($Row2 = mysqli_fetch_array($Resp2))
					{
						echo "<td>".strtoupper($Row2["nombre_subclase"])."</td>\n";
					}
					else
					{
						echo "<td>&nbsp;</td>\n";
					}
					echo "<td>".$Row["grupo"]."</td>\n";
					echo "<td>".$Row[num_electrolisis]."</td>\n";
					echo "<td>".$Row["hornada"]."</td>\n";
					echo "<td>".$Row[correlativo]."</td>\n";
					echo "<td>".$Row[cant_anodos]."</td>\n";
					echo "<td>".number_format($Row[peso_anodos],2,',','.')."</td>\n";
					echo "</tr>\n";
					$i++;
				}
			?>		  
        </table> 
	  </td>
	</tr>
</table>
</form>
</body>
</html>
