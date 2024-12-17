<?php
	include("../principal/conectar_principal.php");
	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	
	if($Proceso=='M')
	{
		$Datos=explode('~~',$Valores);
		$SubProducto=$Datos[0];
		$Rut=$Datos[1];
		$TxtCodLeyes=$Datos[4];
		$TxtCodImpurezas=$Datos[5];
		
		$Consulta = "select t1.rut_proveedor,t1.cod_subproducto,t3.nomprv_a as nombre,t2.abreviatura as subproducto ";
		$Consulta.= " from age_web.relaciones t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto=1 and t1.cod_subproducto=t2.cod_subproducto";
		$Consulta.="  left join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a ";
		$Consulta.= " where t1.rut_proveedor='".$Rut."' and t1.cod_subproducto='".$SubProducto."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$NomPrv=$Fila["rut_proveedor"]." ".$Fila["nombre"];
			$NomSubprod=$Fila["subproducto"];
		}
		
		$LeyesMuestra=$Datos[4]."~".$Datos[5];
		$Datos2=explode('~',$LeyesMuestra);
		$TxtLeyesMuestra='';
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
			$ley = isset($Fila["ley"])?$Fila["ley"]:"";
			$TxtLeyesMuestra=$TxtLeyesMuestra.$ley."~";
		}
	}
?>
<html>
<head>
<title>CAL-Asignacion Leyes Producto - Proveedor</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style>
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmRegistros;
	switch (opt)
	{
		case "G":
			f.action = "cal_leyes_prv01.php?Proceso=" + f.ProcesoActual.value + "&SubProducto="+f.SubProducto.value+"&Rut=" + f.Rut.value;
			f.submit();
			break;
		case "S":
			window.opener.document.frmPrincipal.action = "cal_leyes_prv.php?Mostrar=S&SubProducto="+f.SubProducto.value+"&Proveedor="+f.Rut.value;
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
		case "R":
			f.action = "cal_leyes_prv02.php";
			f.submit();
			break;
	}
}
function CargaParametros(opt)
{
	var f=document.frmRegistros;

	switch (opt)
	{
		case "LEY":
			URL="cal_seleccion_leyes_prv.php?CodLeyes="+f.TxtCodLeyes.value+"&CodImpurezas="+f.TxtCodImpurezas.value;
			break;
	}	
	window.open(URL,"","top=30,left=30,width=600,height=500,status=yes,scrollbars=yes,resizable=yes");
}
</script></head>

<body>
<form name="frmRegistros" action="" method="post">
<input type="hidden" name="SubProducto" value="<?php echo $SubProducto; ?>">
<input type="hidden" name="TipoBusq" value="<?php echo $TipoBusq; ?>">
<input type="hidden" name="Rut" value="<?php echo $Rut; ?>">
  <table width="400" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr align="center" class="ColorTabla01"> 
      <td colspan="2"><strong>
        <?php
		$ProcesoActual = "M";
		echo "Modificacion de ";
	?>
        Leyes - Impurezas</strong><input type="hidden" name="ProcesoActual" value="<?php echo $ProcesoActual; ?>"></td>
    </tr>
    <tr>
    <td width="61">SubProducto</td>
    <td><?php echo $NomSubprod;?></td>
    </tr>
    <tr>
    <td width="61">Proveedor</td>
    <td><?php echo $NomPrv;?></td>
    </tr>
    <tr>
      <td width="61">Definir:</td>
      <td width="320"><input name="BtnLeyes" type="button" id="BtnLeyes2" value="Definir" readonly onClick="CargaParametros('LEY')">
        (Leyes para recepcion sipa,  generacion S.A. Auto.)
          <input name="TxtLeyesMuestra" type="text" class="InputColor" size="50" readonly value='<?php echo $TxtLeyesMuestra;?>'>
        <input name="TxtCodLeyes" type="hidden" value="<?php echo $TxtCodLeyes;?>">
		<input name="TxtCodImpurezas" type="hidden" value="<?php echo $TxtCodImpurezas;?>">
		</td>		
    </tr>
    <tr align="center"> 
      <td colspan="2"><input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')"> 
        <input name="BtnSalir" type="submit" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  </table>
</form>
</body>
</html>
