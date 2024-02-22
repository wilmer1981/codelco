<?php 
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 3;
	if (!isset($AnoTe))
	{
		$AnoTe=date("Y");
		$MesTe=date("m");
		$DiaTe=date("d");
	}
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	
	if(!isset($Mod))
		$Opc='Graba';
	if($ConsultaP=='S')
	{
		$Consulta="select *,year(fechahora) as ano,month(fechahora) as Mes, day(fechahora) as dia from pmn_web.cobre_teluro where correlativo='".$Corr."'";
		//echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_assoc($Resp))
		{
			$CorrCT=$Fila[correlativo];
			if($Fila[tipo]=='P')
			{
				$AnoTe=$Fila[ano];
				$MesTe=$Fila[Mes];
				$DiaTe=$Fila[dia];
				$PesoTe=$Fila["peso"];
				$OperadorTe=$Fila[operador];
				$LixiviacionP=$Fila[n_lixiviacion];
				$TurnoTe=$Fila[turno];
				$Opc='Modifi';
				$Mod='M';
				$BuscaTeluro='S';
			}
			else
			{
				$AnoTeB=$Fila[ano];
				$MesTeB=$Fila[Mes];
				$DiaTeB=$Fila[dia];
				$PesoTeB=$Fila["peso"];
				$OperadorTeB=$Fila[operador];
				$TurnoTeB=$Fila[turno];
				$Opc='Modifi';
				$ModB='M';
				$BuscaTeluroB='S';
			}
			$DatoModifiTe=$Fila[ano]."-".$Fila[Mes]."-".$DiaTeB;
		}
	}	
	if($Canc=='S')
	{
		$AnoTe=date('Y');
		$MesTe=date('m');
		$DiaTe=date('d');
		$PesoTe='';
		$OperadorTe='S';
		$LixiviacionP='';
		$TurnoTe='S';
	}

?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
<!--
function ProcesoTe(opt,tipo)
{
	var f = document.frmPrincipalRpt;
	var Tipo="";
	switch (opt)
	{
		case "Graba":
			if(f.LixiviacionP.value=='' && tipo=='P')
			{
				alert("Debe Ingresar N� Lixiviacion");
				f.LixiviacionP.focus();
				return;
			}
			if(f.OperadorTe.value=='S' && tipo=='P')
			{
				alert("Debe seleccionar Operador");
				f.OperadorTe.focus();
				return;
			}
			if(f.PesoTe.value=='' && tipo=='P')
			{
				alert("Debe ingresar peso");
				f.PesoTe.focus();
				return;
			}
			if(f.OperadorTeB.value=='S' && tipo=='B')
			{
				alert("Debe seleccionar Operador");
				f.OperadorTeB.focus();
				return;
			}
			if(f.PesoTeB.value=='' && tipo=='B')
			{
				alert("Debe ingresar peso");
				f.PesoTeB.focus();
				return;
			}
			f.action = "pmn_ing_cobre_teluro01.php?Opcion=N&Tipo="+tipo;
			f.submit();
		break;	
		case "Modifi":
			if(f.PesoTe.value=='')
			{
				alert("Debe ingresar peso");
				f.PesoCirc.focus();
				return;
			}
			f.action = "pmn_ing_cobre_teluro01.php?Opcion=M&Tipo="+tipo;
			f.submit();
		break;	
		case "ConsultaP":
			URL="pmn_ing_cobre_teluro_proceso.php?Opc=P&Tipo=P";
			window.open(URL,"","top=50px,left=60px, width=750px, height=400px, menubar=no, resizable=yes, scrollbars=yes,status=yes");
		break;
		case "ConsultaB":
			URL="pmn_ing_cobre_teluro_proceso.php?Opc=P&Tipo=B";
			window.open(URL,"","top=50px,left=60px, width=750px, height=400px, menubar=no, resizable=yes, scrollbars=yes,status=yes");
		break;
		case "E":
			var mensaje=confirm("Est� seguro de eliminar el registro.");
			if(mensaje==true)
			{
				f.action = "pmn_ing_cobre_teluro01.php?Opcion=E";
				f.submit();
			}			
		break;
		case "Cancela":
			f.action = "pmn_principal_reportes.php?Tab14=true&Canc=S";
			f.submit();
		break;
	}
}

-->
</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="3" topmargin="2">
<form name="frmPrincipalTeluro" action="" method="post">
<input type="hidden" name="Marcados" value="">
<input type="hidden" name="CorrCT" value="<?php echo $CorrCT;?>">
  <?php //include("../principal/encabezado.php");?>
  <table width="98%" border="0" cellpadding="5" cellspacing="0" class="TituloCabeceraOz">
    <tr> 
      <td colspan="2" valign="top" > 
        <table width="100%" border="0" cellspacing="0" cellpadding="2" class="TablaInterior">
          <tr> 
            <td class="TituloCabeceraAzul" colspan="6">Producci&oacute;n</td>
		  </tr>	
          <tr> 
            <td class="titulo_azul">Fecha</td>
            <td colspan="3">
			<?php
				if(isset($Mod)) 
				{
					echo "<input type='hidden' name='DiaTe' value='".$DiaTe."'>\n";
					echo "<input type='hidden' name='MesTe' value='".$MesTe."'>\n";
					echo "<input type='hidden' name='AnoTe' value='".$AnoTe."'>\n";
					echo $DatoModifiTe;
					echo "<input type='hidden' name='Fecha' value='".$DatoModifiTe."'>";
				}
				else
				{
					echo "<select name='DiaTe' style='width:50px' >\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaTe))
						{
							if ($i == $DiaTe)
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
				  echo "</select> <select name='MesTe' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesTe))
						{
							if ($i == $MesTe)
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
				  echo "</select> <select name='AnoTe' style='width:60px'>\n";
					for ($i=2008;$i<=date("Y");$i++)
					{
						if (isset($AnoTe))
						{
							if ($i == $AnoTe)
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
			?></td>
            <td><input name="btnAgregar2" type="button" value="Consultar" onClick="ProcesoTe('ConsultaP');"></td>
            <td>&nbsp;</td>
            <!--<td>
			<input name="BtnConsultar" type="button" id="BtnConsultar3" onClick="Proceso('C');" value="Consultar"></td>-->
          </tr>
          <tr> 
            <td width="132" class="titulo_azul">N&deg; Lixiviaci&oacute;n </td>
            <td width="390">
			<?php
			if(!isset($Mod)) 
			{
			?>
			<label>
              <input name="LixiviacionP" type="text" size="9" maxlength="8" value="<?php echo $LixiviacionP;?>"/>
            </label>
			<?php
			}
			else
			{
				echo $LixiviacionP; echo "<input name='LixiviacionP' type='hidden' size='9' maxlength='8' value='".$LixiviacionP."'/>";
			}
			?></td>
            <td width="102" class="titulo_azul">Turno</td>
            <td width="120">
              <?php
			if ($Mod == "M")
			{
				$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase='".$TurnoTe."'";
				$result2 = mysqli_query($link, $sql);
				if ($row2=mysqli_fetch_array($result2))
					echo "<font>".strtoupper($row2["nombre_subclase"])."</font>";
				else	echo "<font>N</font>";
				echo "<input type='hidden' name='TurnoTe' value='".$TurnoTe."'>";
			}
			else
			{		
				echo "<select name='TurnoTe' style='width:50'>\n";
				$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase not in('2') order by cod_subclase";
				$result = mysqli_query($link, $sql);
				while ($row=mysqli_fetch_array($result))
				{
					if ($TurnoTe == $row["cod_subclase"])
						echo "<option selected value='".$row["cod_subclase"]."'>".strtoupper($row["nombre_subclase"])."</option>\n";
					else	echo "<option value='".$row["cod_subclase"]."'>".strtoupper($row["nombre_subclase"])."</option>\n";
				}
				echo "</select>\n";
			}
			?>  			&nbsp;</td>
            <td width="69" class="titulo_azul">Operador</td>
            <td width="449"><select name="OperadorTe" style="width:300px">
              <option value="S">Seleccionar</option>
              <?php
				LlenaCombosPersonalPmn(&$OperadorTe,'2');
				?>
            </select></td>
          </tr>
          <tr>
            <td class="titulo_azul">Peso</td>
            <td colspan="5"><span class="titulo_azul">
              <input name="PesoTe" type="text" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($PesoTe,2,',','.');?>" size="8" maxlength="6" />
            </span></td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="459" height="26" class="TituloCabeceraOz">
			<?php
			$Consulta="select peso,tipo from pmn_web.cobre_teluro where tipo='P'";
			$Resps=mysqli_query($link, $Consulta);$Suma=0;
			while($Filas=mysqli_fetch_assoc($Resps))
			{
				if($Filas[tipo]=='P')
					$Suma=$Suma+$Filas["peso"];
				else
					$Suma=$Suma-$Filas["peso"];	
			}
			echo "Acumulado Producci&oacute;n: ".number_format($Suma,02,',','.');
			?>			
			&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="315"><input name="btnAgregar" type="button" value="Grabar" onClick="ProcesoTe('<?php echo $Opc;?>','P');">&nbsp;<input name="btnAgregar3" type="button" value="Eliminar" onClick="ProcesoTe('E');">&nbsp;<input name="btnAgregar32" type="button" value="Cancelar" onClick="ProcesoTe('Cancela');"></td>
            <td width="45">&nbsp;</td>
            <td width="387" class="TituloCabeceraOz">&nbsp;</td>
          </tr>
      </table>
	  <br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="TablaInterior">
          <tr> 
            <td class="TituloCabeceraAzul" colspan="6">Beneficio</td>
		  </tr>	
          <tr> 
            <td class="titulo_azul">Fecha</td>
            <td colspan="3">
			<?php
				if(isset($ModB)) 
				{
					echo "<input type='hidden' name='DiaTeB' value='".$DiaTeB."'>\n";
					echo "<input type='hidden' name='MesTeB' value='".$MesTeB."'>\n";
					echo "<input type='hidden' name='AnoTeB' value='".$AnoTeB."'>\n";
					echo $DatoModifiTe;
				}
				else
				{
					echo "<select name='DiaTeB' style='width:50px' >\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaTeB))
						{
							if ($i == $DiaTeB)
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
				  echo "</select> <select name='MesTeB' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesTeB))
						{
							if ($i == $MesTeB)
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
				  echo "</select> <select name='AnoTeB' style='width:60px'>\n";
					for ($i=2008;$i<=date("Y");$i++)
					{
						if (isset($AnoTeB))
						{
							if ($i == $AnoTeB)
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
			?></td>
            <td width="69"><input name="btnAgregar2" type="button" value="Consultar" onClick="ProcesoTe('ConsultaB');"></td>
            <td width="449">&nbsp;</td>
            <!--<td>
			<input name="BtnConsultar" type="button" id="BtnConsultar3" onClick="Proceso('C');" value="Consultar"></td>-->
          </tr>
          <tr> 
            <td width="132" class="titulo_azul">Turno</td>
            <td width="390"><?php
			if ($ModB == "M")
			{
				$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase='".$TurnoTeB."'";
				$result2 = mysqli_query($link, $sql);
				if ($row2=mysqli_fetch_array($result2))
					echo "<font>".strtoupper($row2["nombre_subclase"])."</font>";
				else	echo "<font>N</font>";
				echo "<input type='hidden' name='TurnoTeB' value='".$TurnoTeB."'>";
			}
			else
			{		
				echo "<select name='TurnoTeB' style='width:50'>\n";
				$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase not in('2') order by cod_subclase";
				$result = mysqli_query($link, $sql);
				while ($row=mysqli_fetch_array($result))
				{
					if ($TurnoTeB == $row["cod_subclase"])
						echo "<option selected value='".$row["cod_subclase"]."'>".strtoupper($row["nombre_subclase"])."</option>\n";
					else	echo "<option value='".$row["cod_subclase"]."'>".strtoupper($row["nombre_subclase"])."</option>\n";
				}
				echo "</select>\n";
			}
			?>
&nbsp;</td>
            <td width="102" class="titulo_azul">Operador</td>
            <td colspan="3"><select name="OperadorTeB" style="width:300px">
              <option value="S">Seleccionar</option>
              <?php
				LlenaCombosPersonalPmn(&$OperadorTeB,'2');
				?>
            </select></td>
          </tr>
          <tr>
            <td class="titulo_azul">Peso</td>
            <td colspan="5"><span class="titulo_azul">
              <input name="PesoTeB" type="text" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($PesoTeB,2,',','.');?>" size="8" maxlength="6" />
            </span></td>
          </tr>
        </table>
	  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr>
          <td width="459" height="26" class="TituloCabeceraOz">
			<?php
			$Consulta="select peso,tipo from pmn_web.cobre_teluro where tipo='B'";
			$Resps=mysqli_query($link, $Consulta);$Suma2=0;
			while($Filas=mysqli_fetch_assoc($Resps))
			{
				$Suma2=$Suma2+$Filas["peso"];
			}
			echo "Acumulado Beneficio: ".number_format($Suma2,02,',','.');
			?>			
		  &nbsp;</td>
          <td width="40">&nbsp;</td>
          <td width="325"><input name="btnAgregar4" type="button" value="Grabar" onClick="ProcesoTe('<?php echo $Opc;?>','B');">
            <input name="btnAgregar33" type="button" value="Eliminar" onClick="ProcesoTe('E');">
            <input name="btnAgregar322" type="button" value="Cancelar" onClick="ProcesoTe('Cancela');"></td>
          <td width="45">&nbsp;</td>
          <td width="387" class="TituloCabeceraOz">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr> 
      <td width="609" valign="top">&nbsp;</td>
      <td width="139" valign="top">&nbsp;</td>
    </tr>
  </table>
  <?php //include("../principal/pie_pagina.php");?>  
</form>
</body>
</html>
<?php
echo "<script lenguaje='javascript'>";
	if($MsjTe=='1')
		echo "alert('Registro Guardado con Exito')";
	if($MsjTe=='2')
		echo "alert('Registro Modificado con Exito')";
echo "</script>";
?>