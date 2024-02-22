<?php 
$CodigoDeSistema = 7;
$CodigoDePantalla = 21;
include("../principal/conectar_principal.php");
?>
<html>
<head>
<title>Sistema RAM</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frm1;
	switch (opt)
	{
		case "G":			
			if (f.Producto.value=="S")
			{
				alert("Debe Seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if (f.SubProducto.value=="S")
			{
				alert("Debe Seleccionar Subproducto");
				f.SubProducto.focus();
				return;
			}
			if (f.PesoHum.value=="")
			{
				alert("Debe Ingresar Peso Humedo");
				f.PesoHum.focus();
				return;
			}
			f.action="ram_stock_piso_circulante01.php?Proceso=G";
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
				var msg = confirm("¿Seguro que desea eliminar esta relacion?");
				if (msg==true)
				{				
					f.action="ram_stock_piso_circulante01.php?Proceso=E&Valores=" + Valores;
					f.submit();
				}
				else
				{
					return;
				}
			}
			break;
		case "X":
			f.action = "ram_stock_piso_circulante_excel.php";
			f.submit();
			break;
		case "I":
			window.print();
			break;
		case "R":
			var ValorChkLeyes="A";
			if (f.ChkLeyes[1].checked)
				ValorChkLeyes="M";
			f.action = "ram_stock_piso_circulante.php?ChkLeyes=" + ValorChkLeyes;
			f.submit();
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=7&Nivel=1&CodPantalla=19";
			f.submit();
			break;
		case "IC":
			window.open("ram_param_circulante_cookie.php?Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=50,left=10,width=700,height=450,scrollbars=yes,resizable = yes");					
			break;
	}	
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="80%"  border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr>
          <td>Mes-A&ntilde;o</td>
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
            </select>            </td>
          <td width="27%" colspan="2" align="right"><input name="BtnCookie" type="submit" id="BtnCookie" value="Ingreso de Cookie" onClick="Proceso('IC')"></td>
        </tr>
        <tr>
          <td width="20%">Producto</td>
          <td colspan="5"><select name="Producto" onChange="Proceso('R')">
<option value="S">SELECCIONAR</option>
<?php
	$Consulta = "select * from proyecto_modernizacion.productos order by descripcion";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Producto == $Fila["cod_producto"])
			echo "<option selected value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>";
		else
			echo "<option value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>";
	}
?>		  		  
          </select></td>
        </tr>
        <tr>
          <td>SubProducto</td>
          <td colspan="5"><select name="SubProducto" onChange="Proceso('R')">
<option value="S">SELECCIONAR</option>		  
		  <?php
	$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto='".$Producto."' order by descripcion";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($SubProducto == $Fila["cod_subproducto"])
			echo "<option selected value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>";
		else
			echo "<option value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>";
	}
?>	
          </select></td>
        </tr>
        <tr>
          <td>Peso Humedo</td>
          <td colspan="5"><input name="PesoHum" type="text" id="PesoHum" value="<?php echo $PesoHum; ?>" size="20" maxlength="10"></td>
          </tr>
        <tr align="center">
          <td class="Detalle01">Opcion de Leyes:            </td>
          <td colspan="5" align="center" class="Detalle01">
<?php
	if ($ChkLeyes == "M")
	{
		echo "<input name='ChkLeyes' type='radio' value='A' checked onClick=\"Proceso('R')\">Automaticas&nbsp\n";
		echo "<input checked name='ChkLeyes' type='radio' value='M' onClick=\"Proceso('R')\">Manuales\n";
	}
	else
	{
		echo "<input checked name='ChkLeyes' type='radio' value='A' checked onClick=\"Proceso('R')\">Automaticas&nbsp\n";
		echo "<input name='ChkLeyes' type='radio' value='M' onClick=\"Proceso('R')\">Manuales\n";
	}		  
?> </td>
          </tr>
<?php
	if ($ChkLeyes == "M")
	{
?>		  
        <tr align="center" class="ColorTabla02">
          <td>Hum (%) </td>
          <td width="15%"><input name="TxtLeyHum" type="text" id="TxtLeyHum" value="<?php echo $TxtLeyHum; ?>" size="10" maxlength="8"></td>
          <td width="13%">Ley Cu (%) </td>
          <td width="25%"><input name="TxtLeyCu" type="text" id="TxtLeyCu" value="<?php echo $TxtLeyCu; ?>" size="10" maxlength="8"></td>
          <td>Ley Ag (g/T</td>
          <td><input name="TxtLeyAg" type="text" id="TxtLeyAg" value="<?php echo $TxtLeyAg; ?>" size="10" maxlength="8"></td>
        </tr>
        <tr align="center" class="ColorTabla02">
          <td>Ley Au (g/T)</td>
          <td><input name="TxtLeyAu" type="text" id="TxtLeyAu" value="<?php echo $TxtLeyAu; ?>" size="10" maxlength="8"></td>
          <td>Ley As (%) </td>
          <td><input name="TxtLeyAs" type="text" id="TxtLeyAs" value="<?php echo $TxtLeyAs; ?>" size="10" maxlength="8"></td>
          <td colspan="2">&nbsp;</td>
        </tr>
<?php
	}
?>
		
        <tr align="center">
          <td colspan="6">              <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
              <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:70px " onClick="Proceso('E')">
              <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
              <input name="BtnExcel" type="button" id="BtnEliminar32" value="Excel" style="width:70px " onClick="Proceso('X')">
              <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')">              </td>
        </tr>
      </table>        
      <br>
        <br>
        <table width="99%"  border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr class="ColorTabla01">
            <td width="4%">Elim</td>
            <td width="4%">Prod</td>
            <td width="4%">Sub</td>
            <td width="26%">Descripcion</td>
            <td width="10%">Peso.Hum</td>
            <td width="9%">Peso.Seco</td>
            <td width="8%">Fino.Cu</td>
            <td width="7%">Fino.Ag</td>
            <td width="4%">Fino.Au</td>
            <td width="4%">Fino.As</td>
            <td width="6%">Ley.Cu</td>
            <td width="7%">Ley.Ag</td>
            <td width="3%">Ley.Au</td>
            <td width="4%">Ley.As</td>
          </tr>
<?php	
	if (!isset($Mes))	
	{
	 	$Mes = date("n");
		$Ano = date("Y");
	} 
	$FechaAux1 = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
	$FechaAux2 = date("Y-m-d", mktime(0,0,0,intval(substr($FechaAux1,5,2)),1-1,intval(substr($FechaAux1,0,4))));
	$Consulta = "select * from ram_web.stock_piso "; 
	$Consulta.= " where fecha = '".$FechaAux2."'";
	$Consulta.= " order by cod_producto, cod_subproducto"; 
	$Resp = mysqli_query($link, $Consulta);
	$TotalPesoSeco = 0;
	$TotalFinoCu = 0;
	$TotalFinoAg = 0;
	$TotalFinoAu = 0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr>\n";
		$ValorRadio = $Fila["cod_producto"]."//".$Fila["cod_subproducto"];
		echo "<td align='center'><input name='Chk' type='radio' value='".$ValorRadio."'></td>\n";
		echo "<td align='center'>".$Fila["cod_producto"]."</td>\n";
		echo "<td align='center'>".$Fila["cod_subproducto"]."</td>\n";
		//SUBPRODUCTO
		$Consulta = "select * from proyecto_modernizacion.subproducto ";
		$Consulta.= " where cod_producto='".$Fila["cod_producto"]."'";
		$Consulta.= " and cod_subproducto='".$Fila["cod_subproducto"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			echo "<td>".$Fila2["descripcion"]."</td>\n";
		else
			echo "<td>&nbsp;</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_humedo"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_seco"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_cu"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_ag"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_au"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["fino_as"],0,",",".")."</td>\n";
		if ($Fila["peso_seco"]!=0 && $Fila["fino_cu"]!=0)
			echo "<td align='right'>".number_format(($Fila["fino_cu"]/$Fila["peso_seco"])*100,2,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($Fila["peso_seco"]!=0 && $Fila["fino_ag"]!=0)
			echo "<td align='right'>".number_format(($Fila["fino_ag"]/$Fila["peso_seco"])*1000,0,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($Fila["peso_seco"]!=0 && $Fila["fino_au"]!=0)
			echo "<td align='right'>".number_format(($Fila["fino_au"]/$Fila["peso_seco"])*1000,1,",",".")."</td>\n";
		else
			echo "<td align='right'>0</td>\n";
		if ($Fila["peso_seco"]!=0 && $Fila["fino_as"]!=0)
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
	echo "<tr>\n";
	echo "<td colspan='4' align='right'><strong>TOTAL</strong></td>\n";
	echo "<td align='right'>".number_format($TotalPesoHum,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalPesoSeco,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalFinoCu,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalFinoAg,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalFinoAu,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalFinoAs,0,",",".")."</td>\n";
	if ($TotalPesoSeco!=0 && $TotalFinoCu!=0)
		echo "<td align='right'>".number_format(($TotalFinoCu/$TotalPesoSeco)*100,2,",",".")."</td>\n";
	else
		echo "<td align='right'>0</td>\n";
	if ($TotalPesoSeco!=0 && $TotalFinoAg!=0)
		echo "<td align='right'>".number_format(($TotalFinoAg/$TotalPesoSeco)*1000,0,",",".")."</td>\n";
	else
		echo "<td align='right'>0</td>\n";
	if ($TotalPesoSeco!=0 && $TotalFinoAu!=0)
		echo "<td align='right'>".number_format(($TotalFinoAu/$TotalPesoSeco)*1000,1,",",".")."</td>\n";
	else
		echo "<td align='right'>0</td>\n";
	if ($TotalPesoSeco!=0 && $TotalFinoAs!=0)
		echo "<td align='right'>".number_format(($TotalFinoAs/$TotalPesoSeco)*100,2,",",".")."</td>\n";
	else
		echo "<td align='right'>0</td>\n";
	echo "</tr>\n";
?>		           
        </table>        
	  </td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
