<?php
	include("../principal/conectar_principal.php");
	$CodigoDeSistema=15;
	$CodigoDePantalla=90;
	if (!isset($TxtFechaIni))
		$TxtFechaIni = date("Y-m-d");
	if (!isset($ChkDefin))
		$ChkDefin = "S";
	if (!isset($ChkAplic))
		$ChkAplic = "C";
	switch ($ChkDefin)
	{
		case "S":
			$CmbProveedor="S";
			$CmbContrato="S";
			break;
		case "P":
			$CmbContrato="S";
			break;
		case "C":
			$CmbProveedor="S";
			break;
	}
	if ($Proc=="M")
	{
		$Datos = explode("~~",$Valores);	
		$Consulta = "select * from age_web.mermas ";
		$Consulta.= " where cod_producto='".$Datos[0]."'";
		$Consulta.= " and cod_subproducto='".$Datos[1]."'";
		$Consulta.= " and rut_proveedor='".$Datos[2]."'";
		$Consulta.= " and cod_contrato='".$Datos[3]."'";
		$Consulta.= " and tipo_aplicacion='".$Datos[4]."'";
		$Consulta.= " and referencia='".$Datos[5]."'";
		$Resp = mysqli_query($link, $Consulta);			
		if ($Fila = mysqli_fetch_array($Resp))
		{
			if ($Fila["cod_subproducto"]!="" && $Fila["rut_proveedor"]=="" && $Fila["cod_contrato"]=="")
			{
				$ChkDefin = "S";
			}
			else
			{
				if ($Fila["cod_subproducto"]!="" && $Fila["rut_proveedor"]!="" && $Fila["cod_contrato"]=="")
				{
					$ChkDefin = "P";
				}
				else
				{
					if ($Fila["cod_contrato"]!="")
						$ChkDefin = "C";
				}
			}
			$CmbSubProducto = $Fila["cod_subproducto"];
			$CmbProveedor = $Fila["rut_proveedor"];
			$CmbContrato = $Fila["cod_contrato"];
			$ChkAplic =$Fila["tipo_aplicacion"];
			$CmbReferencia = $Fila["referencia"];
			$TxtFechaIni = $Fila["fecha"];
			$TxtPorc = $Fila["porc"];
		}
	}
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f= document.frmPopUp;
	switch (opt)
	{
		case "G":
			if (f.CmbSubProducto.value=="S")
			{
				alert("Debe Seleccionar un SubProducto");
				f.CmbSubProducto.focus();
				return;
			}	
<?php			
if ($ChkDefin=="P")
{
	echo "if (f.CmbProveedor.value=='S')";
	echo "{";
	echo "alert('Debe Seleccionar un Proveedor');";
	echo "f.CmbProveedor.focus();";
	echo "return;";
	echo "}";
}
if ($ChkDefin=="C")
{
	echo "if (f.CmbContrato.value=='S')";
	echo "{";
	echo "alert('Debe Seleccionar un Contrato');";
	echo "f.CmbContrato.focus();";
	echo "return;";
	echo "}";
}
?>				
			if (f.CmbReferencia.value=="S")
			{
				alert("Debe Seleccionar una Referencia");
				f.CmbReferencia.focus();
				return;
			}	
			if (f.TxtPorc.value=="")
				f.TxtPorc.value=0;
			f.action = "age_ing_mermas01.php?Proceso="+f.Proc.value;
			f.submit();
			break;		
		case "S":
			window.opener.document.frmPrincipal.action = "age_ing_mermas.php";
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
		case "R":
			f.action = "age_ing_mermas02.php";
			f.submit();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body leftmargin="3" topmargin="5">
<body><DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>

<form name="frmPopUp" action="" method="post">
<input type="hidden" name="Proc" value="<?php echo $Proc?>">
        <br>
        <table width="450" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr align="center">
            <td colspan="2" class="Detalle01"><strong>DEFINICION DE PORCENTAJES DE MERMA </strong></td>
          </tr>
          <tr class="Detalle02">
            <td>Merma Definida por            </td>
            <td>
<?php
	switch ($ChkDefin)
	{
		case "S":
			echo "<input checked name='ChkDefin' type='radio' value='S' onClick=\"Proceso('R')\">SubProducto&nbsp;&nbsp;";
			echo "<input name='ChkDefin' type='radio' value='P' onClick=\"Proceso('R')\">Proveedor&nbsp;&nbsp;";
			echo "<input name='ChkDefin' type='radio' value='C' onClick=\"Proceso('R')\">Contrato";
			break;
		case "P":
			echo "<input name='ChkDefin' type='radio' value='S' onClick=\"Proceso('R')\">SubProducto&nbsp;&nbsp;";
			echo "<input checked name='ChkDefin' type='radio' value='P' onClick=\"Proceso('R')\">Proveedor&nbsp;&nbsp;";
			echo "<input name='ChkDefin' type='radio' value='C' onClick=\"Proceso('R')\">Contrato";
			break;
		case "C":
			echo "<input name='ChkDefin' type='radio' value='S' onClick=\"Proceso('R')\">SubProducto&nbsp;&nbsp;";
			echo "<input name='ChkDefin' type='radio' value='P' onClick=\"Proceso('R')\">Proveedor&nbsp;&nbsp;";
			echo "<input checked name='ChkDefin' type='radio' value='C' onClick=\"Proceso('R')\">Contrato";
			break;
	}
?>			
</td>
          </tr>  
          <tr>
            <td width="131" class="Detalle02">SubProducto:</td>
            <td width="300"><select name="CmbSubProducto" style="width:300" onChange="Proceso('R')">
              <option class="NoSelec" value="S">SELECCIONAR</option>
              <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' and recepcion<>'PMN'";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
            </select></td>
          </tr>
          <tr>
            <td class="Detalle02">Proveedor:</td>
            <td><select <?php if ($ChkDefin!="P"){ echo "disabled"; }?> name="CmbProveedor" style="width:300">
              <option class="NoSelec" value="S">SELECCIONAR</option>
              <?php
				$Consulta = "select t1.rut_proveedor, t2.nomprv_a ";
				$Consulta.= " from age_web.relaciones t1 left join rec_web.proved t2 on t1.rut_proveedor = t2.rutprv_a ";
				$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto= '".$CmbSubProducto."' order by t2.nomprv_a";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["rut_proveedor"])
						echo "<option selected value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
					else
						echo "<option value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
				}
			?>
            </select></td>
          </tr>
          <tr>
            <td class="Detalle02">Contrato:</td>
            <td><select <?php if ($ChkDefin!="C"){ echo "disabled"; }?> name="CmbContrato" style="width:300">
              <option class="NoSelec" value="S">SELECCIONAR</option>
              <?php
	$Consulta = "select * from age_web.contratos ";
	//if ($CmbSubProducto!="S" && isset($CmbSubProducto))
		$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."'";
	$Consulta.= " order by cod_producto, cod_subproducto, cod_contrato ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if (str_replace("~~"," ",$CmbContrato)==$Fila["cod_contrato"])
			echo "<option selected value='".str_replace(" ","~~",$Fila["cod_contrato"])."'>".$Fila["cod_contrato"]." - ".$Fila["descripcion"]."</option>\n";
		else
			echo "<option value='".str_replace(" ","~~",$Fila["cod_contrato"])."'>".$Fila["cod_contrato"]." - ".$Fila["descripcion"]."</option>\n";
	}
?>
            </select></td>
          </tr>
          <tr class="Detalle01">
            <td>Aplicar por:            </td>
            <td>
<?php
	switch ($ChkAplic)
	{
		case "C":
			echo "<input checked name='ChkAplic' type='radio' value='C' onClick=\"Proceso('R')\">Clase de Producto&nbsp;&nbsp;&nbsp;";
			echo "<input name='ChkAplic' type='radio' value='L' onClick=\"Proceso('R')\">Lugar de Destino ";
			break;
		case "L";
			echo "<input name='ChkAplic' type='radio' value='C' onClick=\"Proceso('R')\">Clase de Producto&nbsp;&nbsp;&nbsp;";
			echo "<input checked name='ChkAplic' type='radio' value='L' onClick=\"Proceso('R')\">Lugar de Destino ";
			break;		
	}
?>
</td>
          </tr>
          <tr>
            <td class="Detalle01">Referencia:</td>
            <td><select name="CmbReferencia" id="CmbReferencia">
<?php
	echo "<option class='NoSelec' value='S'>SELECCIONAR</option>\n";
	switch ($ChkAplic)
	{
		case "C":
			$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15001' order by valor_subclase1";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{
				if ($CmbReferencia == $Fila["nombre_subclase"])
					echo "<option selected value='".$Fila["nombre_subclase"]."'>".strtoupper($Fila["valor_subclase1"])."</option>\n";
				else
					echo "<option value='".$Fila["nombre_subclase"]."'>".strtoupper($Fila["valor_subclase1"])."</option>\n";
			}
			break;
		case "L":
			$Consulta = "select * from ram_web.tipo_lugar order by cod_tipo_lugar";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{
				if ($CmbReferencia == $Fila["cod_tipo_lugar"])
					echo "<option selected value='".$Fila["cod_tipo_lugar"]."'>".str_pad($Fila["cod_tipo_lugar"],2,'0',STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion_lugar"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_tipo_lugar"]."'>".str_pad($Fila["cod_tipo_lugar"],2,'0',STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion_lugar"])."</option>\n";
			}
			break;
	}
?>			
               </select>&nbsp;&nbsp;&nbsp;
			  <input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false">
		 
		 
		  </td>						
          </tr>
          <tr>
            <td class="Detalle01">Porcentaje:</td>
            <td><input name="TxtPorc" type="text" id="TxtPorc" value="<?php echo $TxtPorc; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada(true)">
              (%)</td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
          </tr>
  </table>
</form>
</body>
</html>