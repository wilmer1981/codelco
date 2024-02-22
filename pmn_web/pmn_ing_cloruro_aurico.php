<?php $AnoActual=date("Y");
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 3;
	if (!isset($AnoCA))
	{
		$AnoCA=date("Y");
		$MesCA=date("m");
		$DiaCA=date("d");
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
		$AnoCA=date('Y');
		$MesCA=date('m');
		$DiaCA=date('d');
	}

?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
<!--
function ProcesoCA(opt,tipo)
{
	var f = document.frmPrincipalRpt;
	var Tipo="";
	switch (opt)
	{
		case "G":
		    var Datos='';
			for(i=1;i<f.elements.length;i++)
			{
				if(f.elements[i].name=='Dia')
					Datos=Datos+f.elements[i].value+"~"+f.elements[i+1].value+"~"+f.elements[i+2].value+"~"+f.elements[i+3].value+"~"+f.elements[i+4].value+"~"+f.elements[i+5].value+"~"+f.elements[i+6].value+"//";			
			}	
			//alert(Datos)
			f.DatosEnvio.value=Datos
			f.action = "pmn_ing_cloruro_aurico01.php?Opcion=G";
			f.submit();
		break;	
		case "E":
			if(f.Elim.value=='0')
				alert('Debe Seleccionar Da a Eliminar');
			else
			{
				var mensaje=confirm('Est Seguro de Eliminar Registro?');
				if(mensaje==true)
				{
					f.action = "pmn_ing_cloruro_aurico01.php?Opcion=E";
					f.submit();
				}
			}		
		break;
		case "R":
				f.action = "pmn_principal_reportes.php?Tab15=true";
				f.submit();
		break;
		case "R1":
				f.action = "pmn_ing_cloruro_aurico01.php?Opcion=R&Tab15=true";
				f.submit();
		break;
		case "Cancela":
			f.action = "pmn_principal_reportes.php?Tab15=true&Canc=S";
			f.submit();
		break;
		case "Excel":
			var URL = "pmn_ing_cloruro_aurico_xls.php?MesCA=" + f.MesCA.value + "&AnoCA=" + f.AnoCA.value ;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
		break;
		case "MFinal":
			f.action = "pmn_ing_cloruro_aurico01.php?Opcion=MFinal";
			f.submit();
		break;
	}
}

-->
</script>

</head>
<body leftmargin="3" topmargin="2">
<form name="frmPrincipalTeluro" action="" method="post">
<input type="hidden" name="Marcados" value="">
<input type="hidden" name="CorrCT" value="<?php echo $CorrCT;?>">

  <?php //include("../principal/encabezado.php");?>
  <table width="98%" border="0" cellpadding="5" cellspacing="0" class="TituloCabeceraOz">
    <tr> 
      <td colspan="2" valign="top" > 
        <table width="100%" border="1" cellspacing="0" cellpadding="2" class="TablaInterior">
          <tr> 
            <td class="TituloCabeceraAzul" colspan="12">Producci&oacute;n</td>
		  </tr>	
         	 <tr> 
            <td width="119" class="titulo_azul">Fecha</td>
            <td width="1095" colspan="11">
			<?php
				if(isset($Mod)) 
				{
					//echo "<input type='hidden' name='DiaCA' value='".$DiaCA."'>\n";
					echo "<input type='hidden' name='MesCA' value='".$MesCA."'>\n";
					echo "<input type='hidden' name='AnoCA' value='".$AnoCA."'>\n";
					echo $DatoModifi;
					echo "<input type='hidden' name='Fecha' value='".$DatoModifi."'>";
				}
				else
				{
					/*echo "<select name='DiaCA' style='width:50px' onchange=ProcesoCA('R1')>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaCA))
						{
							if ($i == $DiaCA)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $DiaActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}*/
				  echo "</select> <select name='MesCA' style='width:100px' onchange=ProcesoCA('R')>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesCA))
						{
							if ($i == $MesCA)
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
				  echo "</select> <select name='AnoCA' style='width:60px' onchange=ProcesoCA('R')>\n";
					for ($i=2008;$i<=date("Y");$i++)
					{
						if (isset($AnoCA))
						{
							if ($i == $AnoCA)
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
            <!--<td>
			<input name="BtnConsultar" type="button" id="BtnConsultar3" onClick="Proceso('C');" value="Consultar"></td>-->
			<?php
			 /* $Consulta="select *,day(fecha) as dia,month(fecha) as mes,year(fecha) as ano from cloruro_aurico where year(fecha)='".$AnoCA."' and month(fecha)='".$MesCA."' and day(fecha)='".$DiaCA."'";
			  	
			  $Resp=mysqli_query($link, $Consulta);$Valor1='';$Valor2='';$Valor3='';$Valor4='';
			  if($Filas=mysqli_fetch_assoc($Resp))			  
			  {
			  	$Valor1=$Filas[prod_ca_V];
				$FechaAnterior=date('Y-m-d',mktime(0,0,0,$Filas[mes],$Filas[dia]-1,$Filas[ano]));
				$Consulta="select * from cloruro_aurico where fecha='".$FechaAnterior."'";
				$Resp2=mysqli_query($link, $Consulta);
				if($Filas2=mysqli_fetch_assoc($Resp2))
					$StockInicial=$Filas2[stockIni_V]+$Filas2[prod_ca_V]-$Filas2[ca_a_prod_V];
				else
					$StockInicial='0';
				
				if($Filas[ca_a_prod_V]!=0 && $Filas[ca_a_prod_V]!='')					
					$Valor2=$Filas[ca_a_prod_V];
				else
				{
					if($StockInicial>0)
						$Valor2=$StockInicial+$Valor1;
				}		
				$Valor3=$Filas[mue_a_proc_V];
				$Valor4=$Filas[cat_a_proc_V];
			  }	*/
			  $StockIni=0;
			 $FechaAnt=date('Y-m-d',mktime(0,0,0,$MesCA,'0',$AnoCA)) ;
			 $Consulta="select stockFin_V from cloruro_aurico where fecha='".$FechaAnt."'";
			 $Resp2=mysqli_query($link, $Consulta);
			 if($Filas2=mysqli_fetch_assoc($Resp2))
				 $StockIni=$Filas2[stockFin_V];
				 
			$UltimoDia=ultimoDiaMes($MesCA,$AnoCA); 
			?>
          </tr>
        </table>
		<br>
        <table width="100%" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td width="459" height="26" class="TituloCabeceraOz">Stock Inicial:
              <label>
              <input type="text" name="StockInicial" value="<?php echo number_format($StockIni,2,',','.')?>">
              </label></td>
            <td width="50">&nbsp;</td>
            <td width="350"><input name="btnAgregar" type="button" value="Grabar" onClick="ProcesoCA('G');">
              &nbsp;
              <!--<input name="btnAgregar3" type="button" value="Eliminar" onClick="ProcesoCA('E');">-->
              
              <input name="btnAgregar32" type="button" value="Cancelar" onClick="ProcesoCA('Cancela');">
              &nbsp;
              <input name="btnAgregar32" type="button" value="Excel" onClick="ProcesoCA('Excel');">
		    </td>
            <td width="10">&nbsp;</td>
            <td width="387" class="TituloCabeceraOz">&nbsp;</td>
          </tr>
        </table><br>
        <table width="100%" border="1" cellspacing="0" cellpadding="2" class="TablaInterior">
          <tr>
            <td colspan="7" align="center" class="TituloTablaNaranja">Producci&oacute;n de Cloruros &Aacute;uricos y Preparaci&oacute;n de Soluci&oacute;n Concentrada</td>
          </tr>
          <tr>
            <td width="107" align="center" class="titulo_azul">D&iacute;as</td>
            <td width="112" align="center" class="titulo_azul">Stock Inicial </td>
            <td width="255" align="center" class="titulo_azul">Producci&oacute;n C.A </td>
            <td width="188" align="center" class="titulo_azul">C.A a Proceso </td>
            <td width="183" align="center" class="titulo_azul">Stock C.A Boveda </td>
            <td width="185" align="center" class="titulo_azul">Muestras a Proceso </td>
            <td width="214" align="center" class="titulo_azul">Catodos Au a Proceso </td>
            <!--<td>
			<input name="BtnConsultar" type="button" id="BtnConsultar3" onClick="Proceso('C');" value="Consultar"></td>-->
          </tr>
		  	  <?php
			  $Total1=0;
			  $Total2=0;
			  $Total3=0;
			  $Total4=0;$Vuelta='1';
			  for($i=1;$i<=$UltimoDia;$i++)
			  {			  
				  $Consulta="select *,day(fecha) as dia,month(fecha) as mes,year(fecha) as ano from cloruro_aurico where year(fecha)='".$AnoCA."' and month(fecha)='".$MesCA."' and day(fecha)='".$i."' group by day(fecha) order by day(fecha) asc";
				  $Resp=mysqli_query($link, $Consulta);
				  if($Filas=mysqli_fetch_assoc($Resp))
				  {
						$FEC=$Filas[ano]."-".$Filas[mes]."-".$Filas[dia];
						if($Vuelta=='1')
						{
							$StockIni=$StockIni;
							$StockFinal=$StockIni+$Filas[prod_ca_V]-$Filas[ca_a_prod_V];
						}	
						else
						{
							$StockIni=$StockFinAnterior;	
							$StockFinal=$StockIni+$Filas[prod_ca_V]-$Filas[ca_a_prod_V];
						}	
						?>
						<tr>
						<td align="center" class="texto_bold" ><?php echo $Filas[dia];?>&nbsp;<input type="hidden" name="Dia" value="<?php echo $Filas[dia];?>"></td>
						<td align="right" bgcolor="#CCFFFF"><?php echo number_format($StockIni,4,',','.')?><input type="hidden" size="10" maxlength="8" name="StockIni" value="<?php echo number_format($StockIni,4,',','.');?>">&nbsp;</td>	
						<td align="right" class="texto_bold"><input type="text" size="10" maxlength="8" name="Valor1" value="<?php echo number_format($Filas[prod_ca_V],4,',','.');?>" onKeyDown="SoloNumeros(true,this)">&nbsp;</td>	
						<td align="right" class="texto_bold"><input type="text" size="10" maxlength="8" name="Valor2" value="<?php echo number_format($Filas[ca_a_prod_V],4,',','.');?>" onKeyDown="SoloNumeros(true,this)">&nbsp;</td>
						<td align="right" bgcolor="#CCFFFF"><?php echo number_format($StockFinal,4,',','.');?>&nbsp;</td>	
						<td align="right" bgcolor="#F2DDDC"><input type="text" size="10" maxlength="8" name="Valor3" value="<?php echo number_format($Filas[mue_a_proc_V],4,',','.');?>" onKeyDown="SoloNumeros(true,this)">&nbsp;</td>	
						<td align="right" bgcolor="#F2DDDC"><input type="text" size="10" maxlength="8" name="Valor4" value="<?php echo number_format($Filas[cat_a_proc_V],4,',','.');?>" onKeyDown="SoloNumeros(true,this)">&nbsp;</td>	
						</tr>
						<?php
						$Total1=$Total1+$Filas[prod_ca_V];
						$Total2=$Total2+$Filas[ca_a_prod_V];
						$Total3=$Total3+$Filas[mue_a_proc_V];
						$Total4=$Total4+$Filas[cat_a_proc_V];
						$StockFinAnterior=$StockFinal;
				  }
				  else
				  {
				  	?>
						<tr>
						<td align="center" class="texto_bold" ><?php echo $i;?>&nbsp;<input type="hidden" name="Dia" value="<?php echo $i;?>"></td>
						<td align="right" bgcolor="#CCFFFF"><?php echo number_format($StockIni,4,',','.')?><input type="hidden" size="10" maxlength="8" name="StockIni" value="<?php echo number_format($StockIni,4,',','.');?>">&nbsp;</td>	
						<td align="right" class="texto_bold"><input type="text" size="10" maxlength="8" name="Valor1" value="<?php echo number_format($Filas[prod_ca_V],4,',','.');?>" onKeyDown="SoloNumeros(true,this)">&nbsp;</td>	
						<td align="right" class="texto_bold"><input type="text" size="10" maxlength="8" name="Valor2" value="<?php echo number_format($Filas[ca_a_prod_V],4,',','.');?>" onKeyDown="SoloNumeros(true,this)">&nbsp;</td>
						<td align="right" bgcolor="#CCFFFF"><?php echo number_format($Filas[stockFin_V],4,',','.');?>&nbsp;</td>	
						<td align="right" bgcolor="#F2DDDC"><input type="text" size="10" maxlength="8" name="Valor3" value="<?php echo number_format($Filas[mue_a_proc_V],4,',','.');?>" onKeyDown="SoloNumeros(true,this)">&nbsp;</td>	
						<td align="right" bgcolor="#F2DDDC"><input type="text" size="10" maxlength="8" name="Valor4" value="<?php echo number_format($Filas[cat_a_proc_V],4,',','.');?>" onKeyDown="SoloNumeros(true,this)">&nbsp;</td>	
						</tr>
					<?php
				  }
				  $Vuelta++;
			  }
			  
			  //ACTUALIZO ULTIMO VALOR DEL MES GRABADO
			  if($StockFinAnterior!='0' && $StockFinAnterior!='')
			  {
				  $Actualiza="UPDATE cloruro_aurico set stockFin_V='".$StockFinAnterior."' where fecha='".$AnoCA."-".$MesCA."-".$UltimoDia."'";
				  mysqli_query($link, $Actualiza);
			  }	
				?>
				<tr>
				<td align="right" class="Text_Titulo_Etapa" colspan="2">Totales:</td>
				<td align="right" class="TituloCabeceraAzul"><?php echo number_format($Total1,4,',','.');?>&nbsp;</td>	
				<td align="right" class="TituloCabeceraAzul"><?php echo number_format($Total2,4,',','.');?>&nbsp;</td>
				<td align="right">&nbsp;</td>	
				<td align="right" bgcolor="#F2DDDC" class="TituloCabeceraAzul"><strong><?php echo number_format($Total3,4,',','.');?></strong>&nbsp;</td>	
				<td align="right" bgcolor="#F2DDDC" class="TituloCabeceraAzul"><strong><?php echo number_format($Total4,4,',','.');?></strong>&nbsp;</td>	
				</tr>
				<?php
		  ?>
		  <input type="hidden" name="Elim" value="<?php echo $ValorElim?>">
        </table>
	  </td>	
    </tr>
    <tr> 
      <td width="609" valign="top">&nbsp;</td>
      <td width="139" valign="top">&nbsp;</td>
    </tr>
  </table> <textarea name="DatosEnvio" style="visibility:hidden;"></textarea> 
  <?php //include("../principal/pie_pagina.php");?>  
</form>
</body>
</html>
<?php
function ultimoDiaMes($mes,$año) 
{ 
  for ($dia=28;$dia<=31;$dia++) 
	 if(checkdate($mes,$dia,$año)) $fecha="$dia"; 
  return $fecha; 
} 


echo "<script lenguaje='javascript'>";
	if($Msj=='Exis')
		echo "alert('Registro Existente')";
	if($Msj=='G')
		echo "alert('Registro Grabado con Exito')";
	if($Msj=='M')
		echo "alert('Registro Modificado con Exito')";
	if($Msj=='E')
		echo "alert('Registro Eliminado con Exito')";
	if($Msj=='NE')
		echo "alert('Registro no se Puede Eliminar, Existe Continuidad de Datos.')";
echo "</script>";
?>