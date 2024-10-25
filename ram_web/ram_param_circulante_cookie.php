<?php 
include("../principal/conectar_principal.php");

	$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Nodo = isset($_REQUEST["Nodo"])?$_REQUEST["Nodo"]:"";
	$Flujo = isset($_REQUEST["Flujo"])?$_REQUEST["Flujo"]:"";
	
	$ChkRecep = isset($_REQUEST["ChkRecep"])?$_REQUEST["ChkRecep"]:"";
	$ChkBenef = isset($_REQUEST["ChkBenef"])?$_REQUEST["ChkBenef"]:"";
	
	$PesoHum     = isset($_REQUEST["PesoHum"])?$_REQUEST["PesoHum"]:"";
	$PesoSeco    = isset($_REQUEST["PesoSeco"])?$_REQUEST["PesoSeco"]:"";
	$FinoCu      = isset($_REQUEST["FinoCu"])?$_REQUEST["FinoCu"]:"";
	$FinoAg      = isset($_REQUEST["FinoAg"])?$_REQUEST["FinoAg"]:"";
	$FinoAu      = isset($_REQUEST["FinoAu"])?$_REQUEST["FinoAu"]:"";
	$FinoAs      = isset($_REQUEST["FinoAs"])?$_REQUEST["FinoAs"]:"";
	
	$Mensaje     = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	
?>
<html>
<head>
<title>Sistema RAM</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style>
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "G":			
			if (f.Nodo.value=="S")
			{
				alert("Debe Seleccionar Nodo");
				f.Nodo.focus();
				return;
			}
			if (f.Flujo.value=="S")
			{
				alert("Debe Seleccionar Flujo");
				f.Flujo.focus();
				return;
			}
			if (f.PesoHum.value=="")
				f.PesoHum.value=0;
			if (f.PesoSeco.value=="")
				f.PesoSeco.value=0;
			if (f.FinoCu.value=="")
				f.FinoCu.value=0;
			if (f.FinoAg.value=="")
				f.FinoAg.value=0;
			if (f.FinoAu.value=="")
				f.FinoAu.value=0;
			if (f.FinoAs.value=="")
				f.FinoAs.value=0;
			if (f.ChkRecep.checked==false && f.ChkBenef.checked==false)
			{
				alert("Debe seleccionar si el ajuste va a la Recepcion, Beneficio o Ambos");
				return;
			}
			f.action="ram_param_circulante_cookie01.php?Proceso=G";
			f.submit();
			break;
		case "E":
			var Valores = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name == "Chk" && f.elements[i].checked==true)
					Valores = f.elements[i].value;
			}
			if (Valores=="")
			{			
				alert("No hay Nada Seleccionado para Eliminar");
				return;
			}
			else
			{
				var msg = confirm("\xBFSeguro que desea eliminar este valor?");
				if (msg==true)
				{				
					f.action="ram_param_circulante_cookie01.php?Proceso=E&Valores=" + Valores;
					f.submit();
				}
				else
				{
					return;
				}
			}
			break;
		case "I":
			window.print();
			break;
		case "R":
			f.action = "ram_param_circulante_cookie.php";
			f.submit();
			break;
		case "S":
			window.close();
			break;
	}	
}
</script></head>

<body>
<form action="" method="post" name="frmPopUp">
<table width="515"  border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr>
    <td align="right">Mes-A&ntilde;o</td>
    <td colspan="3"><select name="Mes" onChange="Proceso('R')">
        <?php
	for ($i=1;$i<=12;$i++)
	{
		if (isset($Mes))
		{
			if ($i==$Mes)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		else
		{
			if ($i==date("n"))
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else
				echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
	}
?>
      </select>
        <select name="Ano" onChange="Proceso('R')">
          <?php
	for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
	{
		if (isset($Ano))
		{
			if ($i==$Ano)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if ($i==date("Y"))
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
?>
        </select>
    </td>
  </tr>
  <tr>
    <td width="79" align="right">Nodo</td>
    <td colspan="3"><select name="Nodo" onChange="Proceso('R')">
      <option value="S">SELECCIONAR</option>
      <?php
	$Consulta = "select * from proyecto_modernizacion.nodos where sistema='CIR' order by cod_nodo";
	$Resp = mysqli_query($link,$Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Nodo == $Fila["cod_nodo"])
			echo "<option selected value='".$Fila["cod_nodo"]."'>".str_pad($Fila["cod_nodo"],3,"0",STR_PAD_LEFT)." - ".$Fila["descripcion"]."</option>";
		else
			echo "<option value='".$Fila["cod_nodo"]."'>".str_pad($Fila["cod_nodo"],3,"0",STR_PAD_LEFT)." - ".$Fila["descripcion"]."</option>";
	}
?>
    </select></td>
  </tr>
  <tr>
    <td align="right">Flujo</td>
    <td colspan="3"><select name="Flujo" onChange="Proceso('R')">
      <option value="S">SELECCIONAR</option>
      <?php
	$Consulta = "select * from proyecto_modernizacion.flujos ";
	$Consulta.= " where nodo='".$Nodo."' and sistema='CIR' and esflujo<>'N' order by cod_flujo";
	$Resp = mysqli_query($link,$Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Flujo == $Fila["cod_flujo"])
			echo "<option selected value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],3,"0",STR_PAD_LEFT)." - ".$Fila["descripcion"]."</option>";
		else
			echo "<option value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],3,"0",STR_PAD_LEFT)." - ".$Fila["descripcion"]."</option>";
	}
?>
    </select></td>
  </tr>
  <tr class="ColorTabla02">
    <td align="right">Peso Humedo </td>
    <td width="140"><input name="PesoHum" type="text" id="PesoHum2" value="<?php echo $PesoHum; ?>" size="20" maxlength="10"></td>
    <td width="64" align="right">Peso Seco </td>
    <td width="197"><input name="PesoSeco" type="text" id="PesoHum3" value="<?php echo $PesoSeco; ?>" size="20" maxlength="10"></td>
  </tr>
  <tr class="ColorTabla02">
    <td align="right">Fino Cu </td>
    <td><input name="FinoCu" type="text" id="PesoHum4" value="<?php echo $FinoCu; ?>" size="20" maxlength="10"></td>
    <td align="right">Fino Ag </td>
    <td><input name="FinoAg" type="text" id="PesoHum5" value="<?php echo $FinoAg; ?>" size="20" maxlength="10"></td>
  </tr>
  <tr class="ColorTabla02">
    <td align="right">Fino Au </td>
    <td><input name="FinoAu" type="text" id="PesoHum6" value="<?php echo $FinoAu; ?>" size="20" maxlength="10"></td>
    <td align="right">Fino As </td>
    <td><input name="FinoAs" type="text" id="FinoAg" value="<?php echo $FinoAs; ?>" size="20" maxlength="10"></td>
  </tr>
  <tr>
    <td colspan="4" align="center">Movimiento:
      <input name="ChkRecep" type="checkbox" id="ChkRecep" value="S">
Recepci&oacute;n
<input name="ChkBenef" type="checkbox" id="ChkBenef" value="S">
Beneficio</td>
    </tr>
  <tr align="center">
    <td colspan="4">
      <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
      <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:70px " onClick="Proceso('E')">
      <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')">
    </td>
  </tr>
</table>
<br>
<table width="99%"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01">
    <td width="4%">Elim</td>
    <td width="9%">Tipo.Mov.</td>
    <td width="5%">Flujo</td>
    <td width="22%">Descripcion</td>
    <td width="10%">Peso.Hum.</td>
    <td width="9%">Peso.Seco</td>
    <td width="8%">Fino.Cu</td>
    <td width="7%">Fino.Ag</td>
    <td width="3%">Fino.Au</td>
    <td width="4%">Fino.As</td>
    <td width="6%">Ley.Cu</td>
    <td width="6%">Ley.Ag</td>
    <td width="3%">Ley.Au</td>
    <td width="4%">Ley.As</td>
  </tr>
<?php  
	$TotalPesoHum = 0;
	$TotalPesoSeco = 0;
	$TotalFinoCu = 0;
	$TotalFinoAg = 0;
	$TotalFinoAu = 0;
	$TotalFinoAs = 0;
		
	$Consulta = "select * from ram_web.cookie ";
	$Consulta.= " where ano='".$Ano."' and mes='".$Mes."'";
	$Consulta.= " order by flujo, tipo_movimiento ";
	$Resp = mysqli_query($link,$Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr>\n";
		$ValorRadio = $Fila["tipo_movimiento"]."//".$Fila["flujo"];
		echo "<td align='center'><input name='Chk' type='radio' value='".$ValorRadio."'></td>\n";
		echo "<td align='center'>".$Fila["tipo_movimiento"]."</td>\n";
		echo "<td align='center'>".$Fila["flujo"]."</td>\n";
		//FLUJO
		$Consulta = "select * from proyecto_modernizacion.flujos ";
		$Consulta.= " where sistema='CIR' and cod_flujo='".$Fila["flujo"]."'";
		$Resp2 = mysqli_query($link,$Consulta);
		if ($Fila2=mysqli_fetch_array($Resp2))
			echo "<td>".$Fila2["descripcion"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_humedo"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_seco"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_cu"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_ag"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_au"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_as"],0,",",".")."</td>\n";
		if ($Fila["fino_cu"]>0 && $Fila["peso_seco"]>0)
			echo "<td align='right'>".number_format(($Fila["fino_cu"]/$Fila["peso_seco"])*100,2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($Fila["fino_ag"]>0 && $Fila["peso_seco"]>0)
			echo "<td align='right'>".number_format(($Fila["fino_ag"]/$Fila["peso_seco"])*1000,0,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($Fila["fino_au"]>0 && $Fila["peso_seco"]>0)
			echo "<td align='right'>".number_format(($Fila["fino_au"]/$Fila["peso_seco"])*1000,1,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($Fila["fino_as"]>0 && $Fila["peso_seco"]>0)
			echo "<td align='right'>".number_format(($Fila["fino_as"]/$Fila["peso_seco"])*100,2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		echo "</tr>\n";
		$TotalPesoHum = $TotalPesoHum + $Fila["peso_humedo"];
		$TotalPesoSeco = $TotalPesoSeco + $Fila["peso_seco"];
		$TotalFinoCu = $TotalFinoCu + $Fila["fino_cu"];
		$TotalFinoAg = $TotalFinoAg + $Fila["fino_ag"];
		$TotalFinoAu = $TotalFinoAu + $Fila["fino_au"];
		$TotalFinoAs = $TotalFinoAs + $Fila["fino_as"];
	}
	/*TOTALES
	echo "<tr>\n";
	echo "<td align='right' colspan='4'><strong>TOTAL</strong></td>\n";
	echo "<td align='right'>".number_format($TotalPesoHum,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalPesoSeco,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalFinoCu,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalFinoAg,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalFinoAu,0,",",".")."</td>\n";
	if ($TotalFinoCu>0 && $TotalPesoSeco>0)
		echo "<td align='right'>".number_format(($TotalFinoCu/$TotalPesoSeco)*100,0,",",".")."</td>\n";
	else
		echo "<td align='right'>0</td>\n";
	if ($TotalFinoAg>0 && $TotalPesoSeco>0)
		echo "<td align='right'>".number_format(($TotalFinoAg/$TotalPesoSeco)*1000,0,",",".")."</td>\n";
	else
		echo "<td align='right'>0</td>\n";
	if ($TotalFinoAu>0 && $TotalPesoSeco>0)
		echo "<td align='right'>".number_format(($TotalFinoAu/$TotalPesoSeco)*1000,0,",",".")."</td>\n";
	else
		echo "<td align='right'>0</td>\n";
	echo "</tr>\n";*/
?>  
</table>
</form>
</body>
</html>
<?php
	if ($Mensaje!="")
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."');";	
		echo "</script>";
	}
?>
