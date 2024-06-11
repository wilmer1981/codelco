<?php
	//include("../principal/conectar_comet_web.php");
	include("../principal/conectar_principal.php");

	$opc       = isset($_REQUEST["opc"])?$_REQUEST["opc"]:"";
	$proceso   = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$nodo	   = isset($_REQUEST["nodo"])?$_REQUEST["nodo"]:"";
	$sistema   = isset($_REQUEST["sistema"])?$_REQUEST["sistema"]:"";


	//$existencia		=$_REQUEST["existencia"];
	//$ajuste			=$_REQUEST["ajuste"];
	//$ExistenciaCheck

	$ExistenciaCheck = ''; //
	$AjusteCheck = '';

	if ($opc == 'M')
	{
		$consulta = "SELECT * FROM proyecto_modernizacion.nodos";
		$consulta.= " WHERE cod_nodo = '".$nodo."' AND sistema = '".$sistema."'";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		
		$txtnodo = $row["cod_nodo"];
		$txtdescripcion = $row["descripcion"];
		
		if ($row["virtual"] == 'S')
			$VirtualCheck = 'checked';
		
		if ($row["maquila"] == 'S')
		{
			$MaquilaCheck = 'checked';
			$HabDeducMetal = '';
			$porc_metal = $row["deduc_metal"];
		}
		else
			$HabDeducMetal = 'disabled';

		if ($row["valor1"] == 'P')
			$ProcesoCheck1 = 'checked';
		else if ($row["valor1"] == 'M')
			$ProcesoCheck2 = 'checked';
		else 
			$ProcesoCheck3 = 'checked';
		if ($row["contotales"]=='S')
			$ConTotalesCheck='checked';	
		$txtcuenta = $row["valor2"];
		$txtnombre = $row["valor3"];
		$txtorden = $row["valor4"];
		
		if ($row["fino_prom"] == 'CU')
			$FinoPromCheck1 = 'checked';
		if ($row["fino_prom"] == 'AG')
			$FinoPromCheck2 = 'checked';		
		if ($row["fino_prom"] == 'AU')
			$FinoPromCheck3 = 'checked';
		if ($row["fino_prom"] == 'PE')
			$FinoPromCheck4 = 'checked';
		
		$consulta = "SELECT * FROM proyecto_modernizacion.flujos";
		$consulta.= " WHERE nodo = '".$nodo."' AND sistema = '".$sistema."' AND cod_flujo IN ('EI', 'EF')";		
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
			$ExistenciaCheck = 'checked';

			
		$consulta = "SELECT * FROM proyecto_modernizacion.flujos";
		$consulta.= " WHERE nodo = '".$nodo."' AND sistema = '".$sistema."' AND cod_flujo IN ('A+', 'A-')";		
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))	
			$AjusteCheck = 'checked';
			
		$Bloq = 'readonly';

	}
	else
	{
		$ProcesoCheck2 = 'checked';
		$ExistenciaCheck = 'checked';
		$FinoPromCheck1 = 'checked';
		$HabDeducMetal = 'disabled';
		$ConTotalesCheck='checked';
		$Bloq = '';
		$AjusteCheck = '';
		$txtdescripcion = "";
		$txtnodo = "";
	
	}
?>
<html>
<head>
<title>Ingreso Nodo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Valida()
{
	f = document.FrmNodoPopUp;
	
	if (f.txtnodo.value == '')
	{
		alert("Debe Ingresar Nodo");
		return false;
	}
	
	if (f.txtdescripcion.value == '')
	{
		alert("Debe Ingresar Decripcion");
		return false;
	}
		
	return true;
}
/*******************/
function Proceso(opc)
{	
	f = document.FrmNodoPopUp;
	
	switch (opc) {
		case 'G':
			if (Valida())
			{
				f.action = "ing_nodo_flujo01.php?proceso=GN";
				f.submit();
			}
			break;
			
		case 'M':
			if (Valida())
			{
				f.action = "ing_nodo_flujo01.php?proceso=MN";
				f.submit();				
			}
			break;
			
		case 'C':
			
		case 'S':
			window.close();
			break;
	}
}
/****************/
function HabilitaMetal()
{	
	f = document.FrmNodoPopUp;
	
	if (f.maquila.checked == true)
		f.porc_metal.disabled = false;
	else
		f.porc_metal.disabled = true;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmNodoPopUp" action="" method="post">
<input name="sistema" type="hidden" value="<?php echo $sistema ?>">
  <table width="435" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr> 
      <td width="90">Nodo N&deg;</td>
    <td width="330"><input name="txtnodo" type="text" value="<?php echo $txtnodo ?>" size="10" onKeyDown="TeclaPulsada(false)" <?php echo $Bloq ?>>
&nbsp;        </td>
  </tr>
  <tr> 
    <td>Descripcion</td>
    <td><input name="txtdescripcion" type="text" value="<?php echo $txtdescripcion ?>" size="50" onblur="Replica()"></td>
  </tr>
</table>
  <br>
  <table width="435" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr> 
      <td width="152"><input name="existencia" type="checkbox" id="existencia" value="S" <?php echo $ExistenciaCheck ?>>
        Crea Existencias</td>
      <td width="121"><input name="ajuste" type="checkbox" id="ajuste" value="S" <?php echo $AjusteCheck ?>>
        Crea Ajustes</td>
      <td width="136">&nbsp;</td>
    </tr>
  </table>
  <br>
<table width="435" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr>
    <td align="center">
	<?php
		if ($opc == 'M') 
			echo '<input name="btngrabar" type="button" id="btnmodificar" value="Modificar" style="width:70" onClick="Proceso(\'M\')">';
		else
			echo '<input name="btngrabar" type="button" id="btngrabar" value="Grabar" style="width:70" onClick="Proceso(\'G\')">';
	?>
    <input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="Proceso('S')">	
	</td>	
  </tr>
</table>
</form>
</body>
</html>
