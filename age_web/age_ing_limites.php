<?php
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 35;
	include("../principal/conectar_principal.php");

	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"S";
	$Proveedor   = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"S";
	$ChkTipo     = isset($_REQUEST["ChkTipo"])?$_REQUEST["ChkTipo"]:"L";
	$Plantilla   = isset($_REQUEST["Plantilla"])?$_REQUEST["Plantilla"]:"";

	$TxtFiltroPrv     = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$ChkTipo     = isset($_REQUEST["ChkTipo"])?$_REQUEST["ChkTipo"]:"L";
	$ChkTipo     = isset($_REQUEST["ChkTipo"])?$_REQUEST["ChkTipo"]:"L";


	/*
	if (!isset($SubProducto))
		$SubProducto="S";
	if (!isset($Proveedor))
		$Proveedor="S";
	if (!isset($ChkTipo))
		$ChkTipo="L";
	*/
?>
<html>
<head>
<title>AGE-Ingreso de Limites</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "N": //NUEVA PLANTILLA
			var tipo="L";
			if (f.ChkTipo[0].checked)
				tipo="L";
			if (f.ChkTipo[1].checked)
				tipo="P";				
			window.open("age_ing_limites02.php?Accion=N&Tipo="+tipo+"&CmbSubProducto="+f.SubProducto.value+"&CmbProveedor="+f.Proveedor.value,"","top=50,left=50,width=500,height=350,scrollbars=yes,resizable=yes");
			break;
		case "L": //VER LISTADO DE PLANTILLAS
		var tipo="L";
			if (f.ChkTipo[0].checked)
				tipo="L";
			if (f.ChkTipo[1].checked)
				tipo="P";		
			window.open("age_ing_limites03.php?Tipo="+tipo,"","top=20,left=30,width=650,height=450,scrollbars=yes,resizable=yes");
			break;
		case "M": //MODIFICAR PLANTILLA
			if (f.Plantilla.value=="S")
			{
				alert("No hay Plantilla seleccionada para Modificar");
				f.Plantilla.focus();
				return;
			}
			var tipo="L";
			if (f.ChkTipo[0].checked)
				tipo="L";
			if (f.ChkTipo[1].checked)
				tipo="P";		
			window.open("age_ing_limites02.php?Accion=M&Tipo="+tipo+"&TxtCodigo="+f.Plantilla.value+"&CmbSubProducto="+f.SubProducto.value+"&CmbProveedor="+f.Proveedor.value,"","top=50,left=50,width=500,height=350,scrollbars=yes,resizable=yes");
			break;
		case "G":
			var Valores="";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkLeyes" && f.elements[i].checked==true)
				{
					if (f.elements[i+1].value!="" || f.elements[i+2].value!="" || f.elements[i+3].value!="" || f.elements[i+4].value!="");
					{
						if (f.elements[i+1].value=="")
							f.elements[i+1].value=0;
						if (f.elements[i+2].value=="")
							f.elements[i+2].value=0;
						if (f.elements[i+3].value=="")
							f.elements[i+3].value=0;
						if (f.elements[i+4].value=="")
							f.elements[i+4].value="";
						Valores = Valores + f.elements[i].value + "//" + f.elements[i+1].value + "//" + f.elements[i+2].value + "//" + f.elements[i+3].value + "//" + f.elements[i+4].value + "~~";
					}
				}
			}
			if (Valores!="")
			{
				//alert(Valores);
				Valores = Valores.substring(0,(Valores.length)-2);
				f.ValoresAux.value=Valores;
				f.action = "age_ing_limites01.php?Proceso=GL";
				f.submit();
			}
			else
			{
				alert("No Tiene Nada Ingresado");
				return
			}			
			break;		
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=30&Nivel=1";
			f.submit();
			break;		
		case "R":
			f.action = "age_ing_limites.php";
			f.submit();
			break;
		case "MLP"://MANTENEDOR LIMITE MUESTRA PARALELA
			window.open("age_limite_particion_proceso.php?TipoProceso=REMUESTREO","","top=100,left=120,width=570,height=400,scrollbars=yes,resizable = yes");
			break;
	}
}
function Marca(J,pos)
{
	var f=document.frmPrincipal;
	switch (pos)
	{
		case 1:
			if (f.elements[J].value != "" || f.elements[J+1].value != "" || f.elements[J+2].value != "" || f.elements[J+3].value != "")
				f.elements[J-(pos)].checked = true;
			else
				f.elements[J-(pos)].checked = false;
			break;
		case 2:
			if (f.elements[J-1].value != "" || f.elements[J].value != "" || f.elements[J+1].value != "" || f.elements[J+2].value != "")
				f.elements[J-(pos)].checked = true;
			else
				f.elements[J-(pos)].checked = false;
			break;
		case 3:
			if (f.elements[J-2].value != "" || f.elements[J-1].value != "" || f.elements[J].value != "" || f.elements[J+1].value != "")
				f.elements[J-(pos)].checked = true;
			else
				f.elements[J-(pos)].checked = false;
			break;
		case 4:
			if (f.elements[J+3].value != "" || f.elements[J-2].value != "" || f.elements[J-1].value != "" || f.elements[J].value != "")
				f.elements[J-(pos)].checked = true;
			else
				f.elements[J-(pos)].checked = false;
			break;
	}	
}
function Recarga3()
{
	var Frm = document.frmPrincipal;
	Frm.action="age_ing_limites.php?Busq=S";
	Frm.submit();	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<input type="hidden" name="ValoresAux" value="">
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="600"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" >
    <td colspan="3" class="Detalle01"><strong>Limites de Control y Penalidades </strong></td>
  </tr>
  <tr align="center">
    <td colspan="3">
<?php
	switch ($ChkTipo)
	{
		case "L":		
			echo "<input onClick=\"Proceso('R')\" name='ChkTipo' type='radio' value='L' checked><strong>Limite de Control &nbsp;&nbsp;&nbsp;&nbsp;</strong>\n";
			echo "<input onClick=\"Proceso('R')\" name='ChkTipo' type='radio' value='P'>Penalidad\n";
			break;
		case "P":
			echo "<input onClick=\"Proceso('R')\" name='ChkTipo' type='radio' value='L'>Limite de Control &nbsp;&nbsp;&nbsp;&nbsp;\n";
			echo "<input onClick=\"Proceso('R')\" name='ChkTipo' type='radio' value='P' checked><strong>Penalidad</strong>\n";
			break;
		default:
			echo "<input onClick=\"Proceso('R')\" name='ChkTipo' type='radio' value='L' checked><strong>Limite de Control &nbsp;&nbsp;&nbsp;&nbsp;</strong>\n";
			echo "<input onClick=\"Proceso('R')\" name='ChkTipo' type='radio' value='P'>Penalidad\n";
			break;
	}
?>	&nbsp;&nbsp;&nbsp;&nbsp;<input name="BtnLimites" type="button" value="Mant. Limites M.Paralela" style="width:170px " onClick="Proceso('MLP')"></td>
    </tr>
  <tr>
    <td>SubProducto:</td>
    <td width="491"><select name="SubProducto" style="width:300" onChange="Proceso('R')">
      <option class="NoSelec" value="S">GENERICA</option>
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
    <td>Proveedor:</td>
    <td><select name="Proveedor" style="width:300" onChange="Proceso('R')">
      <option class="NoSelec" value="S">GENERICA</option>
      <?php
				$Consulta = "select * from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rut_prv=t2.rut_proveedor ";
				$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%' ";  					
				$Consulta.= " order by t1.nombre_prv";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Proveedor == $Fila["rut_prv"])
						echo "<option selected value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>";
					else
						echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>";
				}
			?>
    </select>
      ---> Filtro Prv&nbsp;
      <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
      <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()">
      </td>
    </tr>
  <tr>
    <td>Plantilla: </td>
    <td><select name="Plantilla" style="width:300" onChange="Proceso('R')">
      <option class="NoSelec" value="S">SELECCIONAR</option>
      <?php
				$Consulta = "select DISTINCT cod_plantilla, descripcion ";
				$Consulta.= " from age_web.limites ";
				$Consulta.= " where tipo='".$ChkTipo."' and cod_producto='1'";
				if ($SubProducto=="S")
					$Consulta.= " and cod_subproducto='0'";
				else
					$Consulta.= " and cod_subproducto='".$SubProducto."'";
				if ($Proveedor=="S")
					$Consulta.= " and rut_proveedor='99999999-9'";
				else
					$Consulta.= " and rut_proveedor ='".$Proveedor."'";
				$Consulta.= " order by descripcion ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Plantilla == $Fila["cod_plantilla"])
						echo "<option selected value='".$Fila["cod_plantilla"]."'>".strtoupper($Fila["descripcion"])."</option>";
					else
						echo "<option value='".$Fila["cod_plantilla"]."'>".strtoupper($Fila["descripcion"])."</option>";
				}
			  ?>
    </select>
      <input name="BtnNueva" type="button" id="BtnNueva2" value="Nueva" style="width:70px " onClick="Proceso('N')">
      <input name="BtnModificar" type="button" id="BtnNueva3" value="Modificar" style="width:70px " onClick="Proceso('M')"></td>
    </tr>
  <tr align="center">
    <td height="35" colspan="3">
	 <input name="BtnGuardar" type="button" id="BtnOK3" value="Guardar Cambios" style="width:120px " onClick="Proceso('G')">
     <input name="BtnListado" type="button" id="BtnListado" value="Listado" style="width:70px " onClick="Proceso('L')">
     <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
	 <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px " onClick="Proceso('S')">
	 </td>
  </tr>
  </table><br>
  <table width="560" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td width="90">Ley</td>
    <td width="60">
<?php
	switch ($ChkTipo)
	{
		case "L":		
			echo "Min.";
			break;
		case "P":
			echo "Por.Cada<br>(%)";
			break;
		default:
			echo "Min.";
			break;
	}	
?>	</td>
    <td width="60"><?php
	switch ($ChkTipo)
	{
		case "L":		
			echo "Prom.";
			break;
		case "P":
			echo "Sobre<br>(%)";
			break;
		default:
			echo "Prom.";
			break;
	}	
?></td>
    <td width="60"><?php
	switch ($ChkTipo)
	{
		case "L":		
			echo "Max.";
			break;
		case "P":
			echo "Penalidad<br>(US$)";
			break;
		default:
			echo "Max.";
			break;
	}	
?></td>
	<td with="60" bgcolor="">Fecha Apl.</td>
    <td width="20">&nbsp;</td>
    <td width="90">Ley</td>
    <td width="60"><?php
	switch ($ChkTipo)
	{
		case "L":		
			echo "Min.";
			break;
		case "P":
			echo "Por.Cada<br>(%)";
			break;
		default:
			echo "Min.";
			break;
	}	
?></td>
    <td width="60"><?php
	switch ($ChkTipo)
	{
		case "L":		
			echo "Prom.";
			break;
		case "P":
			echo "Sobre<br>(%)";
			break;
		default:
			echo "Prom.";
			break;
	}	
?></td>
    <td width="60"><?php
	switch ($ChkTipo)
	{
		case "L":		
			echo "Max.";
			break;
		case "P":
			echo "Penalidad<br>(US$)";
			break;
		default:
			echo "Max.";
			break;
	}	
?></td>
	<td width="60">Fecha Apl.</td>
  </tr>
  <?php
	//$RegPorColum = round($CantLeyes/4);
	$RegPorColum=5;
	$Consulta = "select distinct t1.cod_leyes, LPAD(t1.cod_leyes,4,'0') as orden, t3.abreviatura as ley ";
	$Consulta.=" from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on ";
	$Consulta.= " t1.cod_leyes=t3.cod_leyes ";
	$Consulta.= " where t1.cod_leyes<>'00' and t1.cod_leyes<>'' and length(t1.cod_leyes)>=2";
	$Consulta.= " order by orden";
	
	$Resp = mysqli_query($link, $Consulta);
	$ContColum = 1;
	$i = 12;
	echo "<tr>\n";
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$LimiteMin = "";
		$LimiteMed = "";
		$LimiteMax = "";
		$FechaA ="";
		$Consulta = "select  * from age_web.limites ";
		$Consulta.= " where cod_plantilla = '".$Plantilla."'";
		$Consulta.= " and cod_leyes = '".$Fila["cod_leyes"]."'";
		//echo $Consulta."<br>";
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux = mysqli_fetch_array($RespAux))
		{
			$LimiteMin = $FilaAux["limite_minimo"];
			$LimiteMed = $FilaAux["limite_medio"];
			$LimiteMax = $FilaAux["limite_maximo"];
			$FechaA = substr($FilaAux["anomes"],0,4)."/".substr($FilaAux["anomes"],4,2);
		}
		echo "<td class='Detalle03' align='left'><em>";
		if ($LimiteMin!="" || $LimiteMed!="" || $LimiteMax!="")
			echo "<input type='checkbox' checked name='ChkLeyes' value='".$Fila["cod_leyes"]."'>";	
		else
			echo "<input type='checkbox' name='ChkLeyes' value='".$Fila["cod_leyes"]."'>";	
		echo $Fila["ley"].":</em></td>\n";
		echo "<td align='center'><input class='InputCen' name='ValorMin' type='text' size='8' maxlength='10' value='".$LimiteMin."' onFocus='Marca(".(($i+1)).",1)' onBlur='Marca(".(($i+1)).",1)' onKeyDown=\"TeclaPulsada2('S',true,this.form,'')\"></td>\n";		
		echo "<td align='center'><input class='InputCen' name='ValorMed' type='text' size='8' maxlength='10' value='".$LimiteMed."' onFocus='Marca(".(($i+2)).",2)' onBlur='Marca(".(($i+2)).",2)' onKeyDown=\"TeclaPulsada2('S',true,this.form,'')\"></td>\n";		
		echo "<td align='center'><input class='InputCen' name='ValorMax' type='text' size='8' maxlength='10' value='".$LimiteMax."' onFocus='Marca(".(($i+3)).",3)' onBlur='Marca(".(($i+3)).",3)' onKeyDown=\"TeclaPulsada2('S',true,this.form,'')\"></td>\n";				
		echo "<td align='center'><input class='InputCen' name='FechaA'  type='text' size='8' maxlength='10' value='".$FechaA."' onFocus='Marca(".(($i+4)).",3)' onBlur='Marca(".(($i+4)).",3)' onKeyDown=\"TeclaPulsada2('S',true,this.form,'')\"></td>\n";				
		if ($ContColum == 2)
		{					
			echo "</tr>\n";
			echo "<tr>\n";
			$ContColum=1;
		}
		else
		{
			$ContColum++;			
			echo "<td>&nbsp;</td>\n";
		}
		$i = $i+4;
	}
	echo "</tr>\n";
?></table>
<br>  </td>
    </tr>
  </table>
 <?php include("../principal/pie_pagina.php")?>
</form> 
</body>
</html>
