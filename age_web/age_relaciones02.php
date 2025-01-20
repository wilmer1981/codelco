<?php
	include("../principal/conectar_principal.php");
	
	$Proceso = isset($_REQUEST['Proceso']) ? $_REQUEST['Proceso'] : '';
	$ProcesoActual = isset($_REQUEST['ProcesoActual']) ? $_REQUEST['ProcesoActual'] : '';
	$Valores = isset($_REQUEST['Valores']) ? $_REQUEST['Valores'] : '';
	$ChkTipoFlujo = isset($_REQUEST['ChkTipoFlujo']) ? $_REQUEST['ChkTipoFlujo'] : '';
	$TipoBusq = isset($_REQUEST['TipoBusq']) ? $_REQUEST['TipoBusq'] : '';
    $Rut = isset($_REQUEST['Rut']) ? $_REQUEST['Rut'] : '';
	$TxtFiltroPrv = isset($_REQUEST['TxtFiltroPrv']) ? $_REQUEST['TxtFiltroPrv'] : '';
	$Busq = isset($_REQUEST['Busq']) ? $_REQUEST['Busq'] : '';
	$ChkGrupo = isset($_REQUEST['ChkGrupo']) ? $_REQUEST['ChkGrupo'] : '';
	$Flujos = isset($_REQUEST['Flujos'])?$_REQUEST['Flujos']:"";
	$SubProducto = isset($_REQUEST['SubProducto']) ? $_REQUEST['SubProducto'] : '';
	$Valores = isset($_REQUEST['Valores']) ? $_REQUEST['Valores'] : '';
	$ChkTipoFlujo = isset($_REQUEST['ChkTipoFlujo']) ? $_REQUEST['ChkTipoFlujo'] : 'RAM';
	$ChkOrden = isset($_REQUEST['ChkOrden']) ? $_REQUEST['ChkOrden'] : 'R';
	$TipoFlujo = isset($_REQUEST['ChkTipoFlujo']) ? $_REQUEST['ChkTipoFlujo'] : 'RAM';
	
	$TxtLeyesMuestra = isset($_REQUEST['TxtLeyesMuestra']) ? $_REQUEST['TxtLeyesMuestra'] : '';
	$TxtCodLeyes = isset($_REQUEST['TxtCodLeyes']) ? $_REQUEST['TxtCodLeyes'] : '';
	$TxtCodImpurezas = isset($_REQUEST['TxtCodImpurezas']) ? $_REQUEST['TxtCodImpurezas'] : '';

	$Orden = isset($_REQUEST['Orden']) ? $_REQUEST['Orden'] : '';

	if($Proceso=='M')
	{
		$Datos=explode('~~',$Valores);
		$SubProducto=isset($Datos[0])?$Datos[0]:"";
		$Rut=isset($Datos[1])?$Datos[1]:"";
		$Flujos=isset($Datos[2])?$Datos[2]:"";
		$ChkGrupo=isset($Datos[3])?$Datos[3]:"";
		//$TxtLeyesMuestra=$Datos[4];
		$TxtCodLeyes=isset($Datos[4])?$Datos[4]:"";
		$TxtCodImpurezas=isset($Datos[5])?$Datos[5]:"";
		//$LeyesMuestra=$Datos[4]."~".$Datos[5];
		$LeyesMuestra=$TxtCodLeyes."~".$TxtCodImpurezas;

		$Datos2=explode('~',$LeyesMuestra);
		foreach($Datos2 as $c => $v)
		{
			$Consulta = "select distinct t1.cod_leyes, LPAD(t1.cod_leyes,4,'0') as orden, t3.abreviatura as ley";
			$Consulta.=" from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
			$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on ";
			$Consulta.= " t1.cod_leyes=t3.cod_leyes";
			$Consulta.= " where t1.cod_leyes='$v' and t3.abreviatura <> '' ";
			//echo $Consulta."<br>";
			$RespLey=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($RespLey);
			//$TxtLeyesMuestra=$TxtLeyesMuestra.$Fila["ley"]."~";
			$ley = isset($Fila['ley'])?$Fila['ley']:"";
			$TxtLeyesMuestra=$LeyesMuestra.$ley."~";
		}
	}

?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style>
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmRegistros;
	switch (opt)
	{
		case "G":
			if(f.SubProducto.value=='S')
			{
				alert('Debe Seleccionar SubProducto');
				f.SubProducto.focus();
				return;
			}
			if(f.Rut.value=='S')
			{
				alert('Debe Seleccionar Proveedor');
				f.Rut.focus();
				return;
			}
			if (f.ProcesoActual.value!="M")
			{
				/*if(f.Flujos.value=='S')
				{
					alert('Debe Seleccionar Flujos');
					f.Flujos.focus();
					return;
				}*/
			}
			f.action = "age_relaciones01.php?Proceso=" + f.ProcesoActual.value + "&SubProducto="+f.SubProducto.value+"&Rut=" + f.Rut.value + "&Flujos=" + f.Flujos.value;
			f.submit();
			break;
		case "S":
			window.opener.document.frmPrincipal.action = "age_relaciones.php?TipoBusq="+f.TipoBusq.value+"&Mostrar=S&SubProducto="+f.SubProducto.value+"&Proveedor="+f.Rut.value+"&Flujos="+f.Flujos.value+"&ChkTipoFlujo="+f.ChkTipoFlujo.value+"&TipoFlujo="+f.ChkTipoFlujo.value;
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
		case "R":
			f.action = "age_relaciones02.php";
			f.submit();
			break;
	}
}
function Recarga2()
{
	var f=document.frmRegistros;
	f.action = "age_relaciones02.php";
	f.submit();
}
function Recarga3()
{
	var Frm=document.frmRegistros;
	Frm.action="age_relaciones02.php?Busq=S";
	Frm.submit();	
}
function CargaParametros(opt)
{
	var f=document.frmRegistros;

	switch (opt)
	{
		case "LEY":
			URL="age_seleccion_leyes_relacion.php?CodLeyes="+f.TxtCodLeyes.value+"&CodImpurezas="+f.TxtCodImpurezas.value;
			break;
	}	
	window.open(URL,"","top=30,left=30,width=600,height=500,status=yes,scrollbars=yes,resizable=yes");
}
</script></head>

<body>
<form name="frmRegistros" action="" method="post">
<input type="hidden" name="TipoBusq" value="<?php echo $TipoBusq; ?>">
  <table width="400" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr align="center" class="ColorTabla01"> 
      <td colspan="2"><strong>
        <?php
	if ($Proceso == "N")
	{
		$ProcesoActual = "G";
		echo "Nuevo ";
	}
	if ($Proceso == "M")
	{
		$ProcesoActual = "M";
		echo "Modificacion de ";
	}
	?>
        Registro</strong><input type="hidden" name="ProcesoActual" value="<?php echo $ProcesoActual; ?>"></td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
	    <tr align="center">
      <td colspan="2">
<?php
	switch ($ChkTipoFlujo)
	{
		case "RAM":
			echo "<input checked name='ChkTipoFlujo' type='radio' value='RAM' onClick=\"Proceso('R')\">Flujos RAM&nbsp;&nbsp;";
			echo "<input name='ChkTipoFlujo' type='radio' value='PMN' onClick=\"Proceso('R')\">Flujos PLAMEN";		
			break;
		case "PMN":
			echo "<input name='ChkTipoFlujo' type='radio' value='RAM' onClick=\"Proceso('R')\">Flujos RAM&nbsp;&nbsp;";
			echo "<input checked name='ChkTipoFlujo' type='radio' value='PMN' onClick=\"Proceso('R')\">Flujos PLAMEN";		
			break;			
	}

?>
</td>
    </tr>
    <tr> 
      <td width="61">SubProducto:</td>
      <td width="320"> <select name="SubProducto" style="width:300">
          <option class="NoSelec" value="S">SELECCIONAR</option>
          <?php
		$Consulta = "select cod_subproducto, descripcion, ";
		$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
		$Consulta.= " from proyecto_modernizacion.subproducto ";
		$Consulta.= " where cod_producto='1' ";
		switch ($ChkTipoFlujo)
		{
			case "RAM":
				$Consulta.= " and (recepcion='' or recepcion='RAM') ";
				break;
			case "PMN":
				$Consulta.= " and (recepcion='PMN') ";
				break;
		}		
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
      <td bgcolor="#FFFFFF">Orden Por: </td>
      <td bgcolor="#FFFFFF"><?php
switch ($ChkOrden)
{
	case "R":
		echo '<input checked name="ChkOrden" type="radio" value="R" onClick="Recarga2()">Rut&nbsp;&nbsp;';
		echo '<input name="ChkOrden" type="radio" value="N" onClick="Recarga2()">Nombre';
		break;
	case "N":
		echo '<input name="ChkOrden" type="radio" value="R" onClick="Recarga2()">Rut&nbsp;&nbsp;';
		echo '<input checked name="ChkOrden" type="radio" value="N" onClick="Recarga2()">Nombre';
		break;

}

?>
        &nbsp;&nbsp;&nbsp;---> Filtro Prv&nbsp;
        <input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
        <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()"></td>
    </tr>
    <tr> 
      <td>Proveedor:</td>
      <td><select name="Rut" style="width:300">
          <option class="NoSelec" value='S'>SELECCIONAR</option>
          <?php
			$Consulta = "select * from sipa_web.proveedores ";
			if($Busq=='S'&&$TxtFiltroPrv!='')
			   $Consulta.= " where nombre_prv like '%".$TxtFiltroPrv."%' ";  			
			switch ($ChkOrden)
			{
				case "R":
					$Consulta.= "order by lpad(rut_prv,10,'0')";
					break;
				case "N":
					$Consulta.= "order by trim(nombre_prv)";
					break;
			
			}
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Resp))
			{
				if (trim($Rut) == trim($Fila["rut_prv"]))
					echo "<option selected value='".trim($Fila["rut_prv"])."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
				else
					echo "<option value='".trim($Fila["rut_prv"])."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
			}
		?>
        </select></td>
    </tr>
    <tr>
      <td>Flujo:</td>
      <td><select name="Flujos" style="width:300">
        <option class="NoSelec" value="S">SIN FLUJO</option>
        <?php
				$Consulta = "select distinct t1.cod_flujo,t1.descripcion,lpad(t1.cod_flujo,3,'0') as orden ";
				$Consulta.= " from proyecto_modernizacion.flujos t1 ";
				$Consulta.= " where t1.esflujo<>'N' and t1.sistema='".$ChkTipoFlujo."' and sub_tipo='R'";				
				$Consulta.= " order by orden";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Flujos == $Fila["cod_flujo"])
						echo "<option selected value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],0,3,STR_PAD_LEFT)."-".$Fila["descripcion"]."</option>";
					else
						echo "<option value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],3,'0',STR_PAD_LEFT)."-".$Fila["descripcion"]."</option>";
				}
			?>
      </select></td>
    </tr>
    <tr> 
      <td>Grupo:</td>
      <td>
<?php	  
	switch ($ChkGrupo)
	{
		case "P":
			echo "<input checked name=\"ChkGrupo\" type=\"radio\" value=\"P\">Principal&nbsp;&nbsp;\n";
			echo "<input name=\"ChkGrupo\" type=\"radio\" value=\"V\">Varios&nbsp;&nbsp;\n";
			echo "<input name=\"ChkGrupo\" type=\"radio\" value=\"\">No Definido\n";			
			break;
		case "V":
			echo "<input name=\"ChkGrupo\" type=\"radio\" value=\"P\">Principal&nbsp;&nbsp;\n";
			echo "<input checked name=\"ChkGrupo\" type=\"radio\" value=\"V\">Varios&nbsp;&nbsp;\n";
			echo "<input name=\"ChkGrupo\" type=\"radio\" value=\"\">No Definido\n";			
			break;
		default:
			echo "<input name=\"ChkGrupo\" type=\"radio\" value=\"P\">Principal&nbsp;&nbsp;\n";
			echo "<input name=\"ChkGrupo\" type=\"radio\" value=\"V\">Varios&nbsp;&nbsp;\n";
			echo "<input checked name=\"ChkGrupo\" type=\"radio\" value=\"\">No Definido\n";			
			break;
	}
?>
</td></tr>
      <td>Definir:</td>
      <td><input name="BtnLeyes" type="button" id="BtnLeyes2" value="Definir" readonly="true" onClick="CargaParametros('LEY')">
        (Leyes para recepcion sipa,  generacion S.A. Auto.)
          <input name="TxtLeyesMuestra" type="text" class="InputColor" size="50" readonly="true" value='<?php echo $TxtLeyesMuestra;?>'>
        <input name="TxtCodLeyes" type="hidden" value="<?php echo $TxtCodLeyes;?>">
		<input name="TxtCodImpurezas" type="hidden" value="<?php echo $TxtCodImpurezas;?>">
		</td>		
    
    <tr align="center"> 
      <td colspan="2"><input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')"> 
        <input name="BtnSalir" type="submit" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  </table>
</form>
</body>
</html>
