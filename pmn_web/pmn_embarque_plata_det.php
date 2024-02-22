<?php
	include("../principal/conectar_principal.php");
	if($Vuelta!='S')
	{
		$Dato=explode('~',$Acta);
		$Acta=$Dato[5];
	}
	$FechaEmbarque = $AnoEmb."-".str_pad($MesEmb,2,"0",STR_PAD_LEFT)."-".str_pad($DiaEmb,2,"0",STR_PAD_LEFT); 
?>
<html>
<head>
<title>Definir Cubas Para Pesaje</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
-->
</style>
<script language="javascript">
function TeclaPulsada(salto) 
{ 
	var f = document.frmPlata;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}

function Proceso(opt)
{
	var f = document.frmPlata;
	switch (opt)
	{
		case "G":						
			if (f.Electrolisis.value == "" || parseInt(f.Electrolisis.value)==0)
			{
				alert("Debe Ingresar Electrolisis");
				f.Electrolisis.focus();
				return;
			}
			if (f.NumCajas.value == "" || parseInt(f.NumCajas.value)==0)
			{
				alert("Debe Ingresar Cantidad de Cajas");
				f.NumCajas.focus();
				return;
			}
			if (f.Numcaja1.value =="" || parseInt(f.Numcaja1.value)==0)
			{
				alert("Debe Ingresar N� de caja Inicial");
				f.Numcaja1.focus();
				return;
			}
			if (f.Numcaja2.value =="" || parseInt(f.Numcaja2.value)==0)
			{
				alert("Debe Ingresar N� de caja Final");
				f.Numcaja2.focus();
				return;
			}
			if (parseInt(f.Numcaja2.value) < parseInt(f.Numcaja1.value))
			{
				alert("N� de Caja Final No Puede Ser Menor que N� de Caja Inicial");
				f.Numcaja2.value=" ";
				f.Numcaja1.value=" ";
				f.Numcaja1.focus();
				return;
			}		
			f.action = "pmn_embarque_plata01.php?Opcion=G_Electrolisis";
			f.submit();
			break;
		case "E":			
			
			var ActaElim = frmPlata.Acta.value;
			var ElectrolisisElim = "";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name == "ChkElectrolisis" && f.elements[i].checked)
				{										
					var ElectrolisisElim = f.elements[i].value;
				}
			}
			if (ElectrolisisElim == "")
			{
				alert("No hay ninguna Electrolisis seleccionada para Eliminar");
				return;
			}
			else
			{
				var msg = confirm("�Seguro que desea Eliminar esta Electrolisis con sus Cajas?");
				if (msg==true)
				{
					f.action = "pmn_embarque_plata01.php?Opcion=E_Electrolisis&ActaElim=" + ActaElim + "&ElectrolisisElim=" + ElectrolisisElim;
					f.submit();
				}
				else
				{
					return;
				}
			}
			break;
		case "S":			
			window.close();
			break;
		case "I":
			f.BtnGrabar.style.visibility = "hidden";
			f.BtnEliminar.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnGrabar.style.visibility = "";
			f.BtnEliminar.style.visibility = "";
			f.BtnImprimir.style.visibility = "";
			f.BtnSalir.style.visibility = "";
			break;					
	}
}

function Modifica(elec,cant,ini,fin)
{
	var f = document.frmPlata;
	f.Electrolisis.value=elec;
	f.NumCajas.value=cant;
	f.Numcaja1.value=ini;
	f.Numcaja2.value=fin;
}
</script>
</head>

<body onLoad="document.frmPlata.Cuba.focus();" class="TituloCabeceraOz">
<form name="frmPlata" action="" method="post">
  <table width="430" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr align="center">
      <td colspan="5" class="TituloCabeceraAzul"><strong>DETALLE  ACTA  EMBARQUE DE PLATA </strong></td>
    </tr>
    <tr>
      <td colspan="5"><input type="hidden" name="GrupoProd" value="<?php echo $GrupoProd; ?>">
      <input type="hidden" name="FechaProduccion" value="<?php echo $FechaProduccion; ?>">
      &nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="titulo_azul">Acta: <?php echo $Acta; ?>      <input name="Acta" type="hidden" size="10" maxlength="3" value="<?php echo $Acta; ?>"></td>
      <td colspan="3" class="titulo_azul">Fecha Embarque: <?php echo substr($FechaEmbarque,8,2)."-".substr($FechaEmbarque,5,2)."-".substr($FechaEmbarque,0,4); ?>
      <input type="hidden" name="FechaEmbarque" value="<?php echo $FechaEmbarque; ?>"></td>
    </tr>
    <tr>
      <td colspan="2" class="titulo_azul">Electrolisis: 
      <input name="Electrolisis" type="text" id="Cuba" size="20" maxlength="20" onKeyDown="TeclaPulsada('NumCajas')"></td>
      <td width="202" colspan="3" class="titulo_azul">Cantidad de Cajas: 
	  <?php
     //poly <input name="NumCajas" type="text" id="Cuba2" size="10" maxlength="4" onKeyDown="TeclaPulsada('BtnGrabar')"></td>?>
      <input name="NumCajas" type="text" id="Cuba2" size="10" maxlength="4" onKeyDown="TeclaPulsada('Numcaja1')"></td>

    </tr>
	
	    <tr>
      <td colspan="5" class="titulo_azul">Granalla de Plata (N� cajas) Desde :    
        <input name="Numcaja1" type="text" id="Numcaja1" size="10" maxlength="20" onKeyDown="TeclaPulsada('Numcaja2')">
        Hasta :
        <input name="Numcaja2" type="text" id="Numcaja2" size="10" maxlength="20" onKeyDown="TeclaPulsada('BtnGrabar')"></td>
    </tr>

	
	
	
    <tr align="center">
      <td colspan="5"><input name="BtnGrabar" type="button" id="BtnGrabar4" value="Grabar" style="width:70px " onClick="Proceso('G')">
        <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:70px " onClick="Proceso('E')">
        <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
        <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
    <tr class="TituloCabeceraAzul" align="center">
      	<td width="39" align="center" &nbsp;></td>
      	<td width="59" align="center">Electrolisis</td>
		<td align="center">Cantidad</td>
        <td align="center">N&deg; Caja Ini </td>
        <td align="center">N&deg; Caja Fin </td>
    </tr>
<?php	
	$Consulta = "select * ";
	$Consulta.= " from pmn_web.detalle_embarque_plata ";
	$Consulta.= " where ano = '".$AnoEmb."'";
	$Consulta.= " and mes = '".intval($MesEmb)."'";
	$Consulta.= " and  num_acta = '".$Acta."'";
	$Consulta.= " order by num_electrolisis ";
	//echo $Consulta."<br>";
	
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr align='center'>\n";
		echo "<td align='center'><input type='radio' name='ChkElectrolisis' value='".$Fila["num_electrolisis"]."' onClick=\"Modifica('".$Fila["num_electrolisis"]."','".number_format($Fila["cantidad"],0,",",".")."','".number_format($Fila["caja_ini"],0,",",".")."','".number_format($Fila["caja_fin"],0,",",".")."')\">\n";
		echo "<td align='center'>".$Fila["num_electrolisis"]."</td>\n";
		echo "<td align='center'>".number_format($Fila["cantidad"],0,",",".")."</td>\n";
		if ($Fila[caja_ini] > 0)
		{
			echo "<td align='center'>".$Fila["caja_ini"]."</td>\n";
		}
		else
		{
			echo "<td align='center'>&nbsp;</td>\n";
		}		
		if ($Fila[caja_fin] > 0)
		{
			echo "<td align='center'>".$Fila["caja_fin"]."</td>\n";
		}
		else
		{
			echo "<td align='center'>&nbsp;</td>\n";
		}	
		echo "</tr>\n";
		$TotalCajas = $TotalCajas + $Fila["cantidad"];
		
	}
	echo "<tr>\n";
	echo "<td colspan='2'><strong>TOTAL</strong></td>\n";
	echo "<td align='center'>".number_format($TotalCajas,0,",",".")."</td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "<td>&nbsp;</td>\n";
	echo "</tr>\n";
?>	
  </table>

</form>
</body>
</html>
