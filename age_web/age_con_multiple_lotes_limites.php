<?php
	include("../principal/conectar_principal.php");
	$TipoConsulta  = isset($_REQUEST["TipoConsulta"])?$_REQUEST["TipoConsulta"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor  = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$Signo  = isset($_REQUEST["Signo"])?$_REQUEST["Signo"]:"";
	
?>
<html>
<head>
<title>Carga Leyes</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "G":
			var Valores="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked && f.elements[i+3].value!="" )
					Valores = Valores + f.elements[i].value + "//" + f.elements[i+2].value + "//" + f.elements[i+3].value + "~~";
			}
			if (Valores!="")
			{
				Valores = Valores.substring(0,(Valores.length)-2);
				f.action = "age_con_multiple_lotes_limites01.php?Proceso=G&Valores=" + Valores;
				f.submit();
			}
			else
			{
				alert("No Tiene Nada Ingresado");
				return
			}			
			break;
		case "E":			
			var msg=confirm("¿Seguro que desea Eliminar esta Plantilla?");
			if (msg==true)
			{
				f.action = "age_con_multiple_lotes_limites01.php?Proceso=E";
				f.submit();
			}			
			else
			{
				return;
			}		
			break;
		case "C":				
			var Valores="";
			var Valores2="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked && f.elements[i+3].value!="" )
				{
					Valores = Valores + f.elements[i].value + "~" + f.elements[i+2].value + "~" + f.elements[i+3].value + "~~";
					Valores2 = Valores2 + f.elements[i+1].value + f.elements[i+2].value + f.elements[i+3].value + ", ";
				}
			}
			if (Valores!="")
			{
				Valores = Valores.substring(0,(Valores.length)-2);
				Valores2 = Valores2.substring(0,(Valores2.length)-2);
			}
			window.opener.FrmPrincipal.TxtCodLimites.value=Valores;
			window.opener.FrmPrincipal.TxtLimitesMuestra.value=Valores2;
			window.close();
			break;		
		case "S":
			window.close();
			break;
		case "MT":
			var Valor=false;
			if (f.ChkTodos.checked==true)
				Valor=true;
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes")
					f.elements[i].checked = Valor;
			}
			break;
		case "R":
			f.action = "age_con_multiple_lotes_limites.php";
			f.submit();
			break;
	}
}
function Marca(J)
{
	var f=document.frmPopUp;
	if (f.elements[J].value != "")
	{
		f.elements[J-3].checked = true;
	}
	else
	{
		f.elements[J-3].checked = false;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<form name="frmPopUp" action="" method="post">
<table width="400"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" >
    <td colspan="12" class="Detalle01"><strong>Limites de Control </strong></td>
  </tr>
  <tr>
    <td colspan="3">SubProducto:</td>
    <td colspan="9"><select name="SubProducto" style="width:300" onChange="Proceso('R')">
      <option class="NoSelec" value="S">TODOS</option>
      <?php
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($SubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
    </select></td>
    </tr>
  <tr>
    <td colspan="3">Proveedor:</td>
    <td colspan="9"><select name="Proveedor" style="width:300" onChange="Proceso('R')">
      <option class="NoSelec" value="S">TODOS</option>
      <?php
				$Consulta = "select * from rec_web.proved t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rutprv_a=t2.rut_proveedor ";
				$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";
				$Consulta.= " order by t1.nomprv_a";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Proveedor == $Fila["RUTPRV_A"])
						echo "<option selected value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
					else
						echo "<option value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>";
				}
			?>
    </select></td>
    </tr>
  <tr align="center" class="ColorTabla02">
    <td colspan="12"><span class="ColorTabla02">
      <input name="BtnCargar" type="button" id="BtnOK2" value="Cargar" style="width:70px " onClick="Proceso('C')">
      <input name="BtnGuardar" type="button" id="BtnOK3" value="Guardar Plantilla" style="width:120px " onClick="Proceso('G')">
      <input name="BtnEliminar" type="button" id="BtnGuardar" value="Eliminar" style="width:70px " onClick="Proceso('E')">
      <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px " onClick="Proceso('S')">
    </span></td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td colspan="12"><strong>Mostrar Lotes Cuyas Leyes sean:</strong></td>
    </tr>
  <tr align="center" class="ColorTabla01">
    <td colspan="4"><input type="checkbox" name="ChkTodos" value="S" onClick="Proceso('MT')">
    Marca Todos</td>
    <td colspan="8"><strong>Analitos</strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td width="30">Selec.</td>
    <td width="47">Ley</td>
    <td width="24">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="30">Selec</td>
    <td width="47">Ley</td>
    <td width="24">&nbsp;</td>
    <td width="24">&nbsp;</td>
    <td width="24">Selec</td>
    <td width="24">Ley</td>
    <td width="24">&nbsp;</td>
    <td width="24">&nbsp;</td>
  </tr>
  <?php
	//$RegPorColum = round($CantLeyes/4);
	$RegPorColum=5;
	$Consulta = "select distinct t1.cod_leyes, LPAD(t1.cod_leyes,4,'0') as orden, t3.abreviatura as ley ";
	$Consulta.=" from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on ";
	$Consulta.= " t1.cod_leyes=t3.cod_leyes";
	$Consulta.= " where t1.cod_leyes<>'01'";
	$Consulta.= " order by orden";
	$Resp = mysqli_query($link, $Consulta);
	$ContColum = 1;
	$i = 7;
	echo "<tr>\n";
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Limite = ""; 
		$Signo = "";
		$Consulta = "select  * from age_web.limites ";
		if ($SubProducto!="" && $SubProducto!="S")
		{	
			$Consulta.= " where cod_producto = '1'";
			$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		}
		else
		{
			$Consulta.= " where cod_producto = '99'";
			$Consulta.= " and cod_subproducto = '99'";
		}
		if ($Proveedor!="" && $Proveedor!="S")
			$Consulta.= " and rut_proveedor = '".$Proveedor."'";
		else
			$Consulta.= " and rut_proveedor = '99999999-9'";
		$Consulta.= " and cod_leyes = '".$Fila["cod_leyes"]."'";
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux = mysqli_fetch_array($RespAux))
		{
			$Signo = isset($FilaAux["signo"])?$FilaAux["signo"]:"";
			$Limite = isset($FilaAux["limite"])?$FilaAux["limite"]:"";
		}
		echo "<td class='Detalle01' align='center'>";
		if ($Limite != "")
			echo "<input type='checkbox' checked name='ChkLeyes' value='".$Fila["cod_leyes"]."'>";	
		else
			echo "<input type='checkbox' name='ChkLeyes' value='".$Fila["cod_leyes"]."'>";	
		echo "<input type='hidden' name='ChkAbrevLeyes' value='".$Fila["ley"]."'></td>\n";
		echo "<td class='ColorTabla03' align='center'>".$Fila["ley"]."</td>\n";
		echo "<td align='center'>";
		echo "<select name='Signo'>";
		switch ($Signo)
		{
			case ">":
				echo "<option selected value='>'>></option>";
				echo "<option value='<'><</option>";
				echo "<option value='='>=</option>";	
				break;
			case "<":
				echo "<option value='>'>></option>";
				echo "<option selected value='<'><</option>";
				echo "<option value='='>=</option>";	
				break;
			case "=":
				echo "<option value='>'>></option>";
				echo "<option value='<'><</option>";
				echo "<option selected value='='>=</option>";	
				break;
			default:
				echo "<option value='>'>></option>";
				echo "<option value='<'><</option>";
				echo "<option value='='>=</option>";	
				break;						
		}
		echo "</select>";
		echo "</td>\n";
		echo "<td align='center'><input class='InputCen' name='Valor' type='text' size='8' maxlength='10' value='".$Limite."' onFocus='Marca(".(($i+3)).")' onBlur='Marca(".(($i+3)).")'></td>\n";
		if ($ContColum == 3)
		{		
			echo "</tr>\n";
			echo "<tr>\n";
			$ContColum = 1;
		}
		else
		{
			$ContColum++;			
		}
		$i = $i+4;
		
	}
	echo "</tr>\n";
?></table>
</form>

</body>
</html>
