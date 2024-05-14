<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	$Proceso       = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$CmbMes        = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("n");
	$CmbAno        = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbSubProducto= isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor  = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$TxtValores = isset($_REQUEST["TxtValores"])?$_REQUEST["TxtValores"]:"";
	$TxtAjuPeso   = isset($_REQUEST["TxtAjuPeso"])?$_REQUEST["TxtAjuPeso"]:"";
	$TxtAjuCu     = isset($_REQUEST["TxtAjuCu"])?$_REQUEST["TxtAjuCu"]:"";
	$TxtAjuAg     = isset($_REQUEST["TxtAjuAg"])?$_REQUEST["TxtAjuAg"]:"";
	$TxtAjuAu     = isset($_REQUEST["TxtAjuAu"])?$_REQUEST["TxtAjuAu"]:"";


	if ($Proceso=="M")
	{
		$Datos01=explode("~~",$TxtValores);
		$CmbAno = $Datos01[0];
		$CmbMes = $Datos01[1];
		$CmbProducto = $Datos01[2];
		$CmbSubProducto = $Datos01[3];
		$CmbProveedor = $Datos01[4];
		$Consulta = "select * from age_web.ajustes ";
		$Consulta.= " where ano='".$CmbAno."' and mes='".$CmbMes."' ";
		$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProducto."' and rut_proveedor='".$CmbProveedor."' ";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Resp))
		{
			$TxtAjuPeso=$Fila["peso_seco"];
			$TxtAjuCu=$Fila["fino_cu"];
			$TxtAjuAg=$Fila["fino_ag"];
			$TxtAjuAu=$Fila["fino_au"];
		}
	}
?>
<html>
<head>
<title>Ajustes Manuales</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmPopUp;
	switch (opt)
	{
		case "R":
			f.action="age_con_cambios_sa_ajuste_manual.php";
			f.submit();
			break;
		case "G":
			if (f.CmbSubProducto.value=="S")
			{
				alert("Debe Seleccionar Producto");
				f.CmbSubProducto.focus();
				return;
			}
			if (f.CmbProveedor.value=="S")
			{
				alert("Debe Seleccionar Proveedor");
				f.CmbProveedor.focus();
				return;
			}
			if (f.TxtAjuPeso.value=="" && f.TxtAjuCu.value=="" && f.TxtAjuAg.value=="" && f.TxtAjuAu.value=="")
			{
				alert("Debe Ingresar Algun Ajuste");
				f.TxtAjuPeso.focus();
				return;
			}
			f.action="age_con_cambios_sa01.php?Proceso=AM";
			f.submit();
			break;
		case "S":
			window.opener.frmPrincipal.action="age_con_cambios_sa.php?Mostrar=S&Mes=" + f.CmbMes.value + "&Ano="+f.CmbAno.value;
			window.opener.frmPrincipal.submit();
			window.close();
			break;
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
<table width="392" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666" class="TablaInterior">
  <tr align="center" class="ColorTabla01">
    <td height="23" colspan="2">Ingreso Ajustes Manuales </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">Mes Ajuste :</td>
    <td>
      <select name="CmbMes" id="CmbMes">
        <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($CmbMes))
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $CmbMes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
      </select>
      <select name="CmbAno" size="1" id="CmbAno">
        <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (!isset($CmbAno))
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $CmbAno)
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
      </select>
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">Producto:</td>
    <td width="300"><select name="CmbSubProducto" id="CmbSubProducto" style="width:250" onChange="Proceso('R')">
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
					if ($CmbSubProducto == $Fila["cod_subproducto"])
						echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>\n";
				}
			  ?>
    </select></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">Proveedor:</td>
    <td><select name="CmbProveedor" id="CmbProveedor" style="width:300">
      <option class="NoSelec" value="S">TODOS</option>
      <?php
				$Consulta = "select * from rec_web.proved t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rutprv_a=t2.rut_proveedor ";
				$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$CmbSubProducto."'";
				$Consulta.= " order by t1.nomprv_a";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbProveedor == $Fila["RUTPRV_A"])
						echo "<option selected value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>\n";
					else
						echo "<option value='".$Fila["RUTPRV_A"]."'>".str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)."-".$Fila["NOMPRV_A"]."</option>\n";
				}
			?>
    </select></td>
  </tr>
  <tr align="center" class="ColorTabla01">
    <td colspan="2">Ajustes</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">Peso Seco:</td>
    <td><input name="TxtAjuPeso" type="text" id="TxtAjuPeso" value="<?php echo $TxtAjuPeso; ?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">Cu:</td>
    <td><input name="TxtAjuCu" type="text" id="TxtAjuCu" value="<?php echo $TxtAjuCu; ?>" size="12" maxlength="10"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">Ag:</td>
    <td><input name="TxtAjuAg" type="text" id="TxtAjuAg" value="<?php echo $TxtAjuAg; ?>" size="12" maxlength="10"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="right">Au: </td>
    <td><input name="TxtAjuAu" type="text" id="TxtAjuAu" value="<?php echo $TxtAjuAu ?>" size="12" maxlength="10"></td>
  </tr>
  <tr align="center" bgcolor="#efefef">
    <td colspan="2" ><input name="BtnGrabar" type="button" id="BtnGrabar" style="width:70px;" onClick="Proceso('G')" value="Grabar">
        <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
  </tr>
</table>
</form>
</body>
</html>
