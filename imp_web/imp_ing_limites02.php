<?php

$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Producto  = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
$Ley       = isset($_REQUEST["Ley"])?$_REQUEST["Ley"]:"";
$Proveedor = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
$Limite = isset($_REQUEST["Limite"])?$_REQUEST["Limite"]:"0.0";

	//$Limite = "0.0"; //Agregado por WSO
	
	$OptBoton = "G";

	if ($Proceso == "ML")
	{
		$OptBoton = "M";
		$Leyes = $Ley;
		include("../principal/conectar_imp_web.php");

		$sql = "SELECT * from limites ";
		$sql.= " where tipo_producto = '".$Producto."'";
		if ($Proveedor == ""){
			$sql.= " AND rut_proveedor = '000000000'";
		}else{	
			$sql.= " AND rut_proveedor = '".$Proveedor."'";
			$sql.= " AND cod_leyes = '".$Leyes."'";
		}
		//echo "Consulta:".$sql;
		$result = mysqli_query($link, $sql);
		//$row=mysqli_fetch_array($result);
		//echo "<br>Limites:";
		//var_dump($row);				
		if($row=mysqli_fetch_array($result))
		{
			$Limite = $row["limite"];
		}else{
			$Limite = "0.0";
		}
		
		include("../principal/cerrar_imp_web.php");
		//echo "Limite:".$Limite;
	}
?>
<html>
<head>
<title>Sistema de Impurezas</title>
<link rel="stylesheet" href="../principal/estilos/css_imp_web.css" type="text/css">
<script language="JavaScript">
<!--
function Proceso(opt)
{
	var f=document.frmLeyes;
	switch (opt)
	{
		case "G":
			if (f.Limite.value != "")
			{
				f.action="imp_ing_limites01.php?Proceso=GL";
				f.submit();
			}
			else
			{
				alert("Debe ingresar Limite");
				return;
			}
			break
		case "M":
			if (f.Limite.value != "")
			{
				f.action="imp_ing_limites01.php?Proceso=ML";
				f.submit();
			}
			else
			{
				alert("Debe ingresar Limite");
				return;
			}
			break
		case "S":
			window.close();
			break;
	}
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmLeyes" action="" method="post">
<table width="483" height="20" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr class="ColorTabla01">
		
      <td height="20"> <strong> 
        <?php
	if ($Proceso == "ML")
	{
  		echo "Modifica Ley";
	}
	else
	{	
		echo "Nueva Ley";
	}
	
  ?>
        </strong> </td>  
  	</tr>
</table>
  <div align="center">
    <table width="483" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr> 
        <td width="65">Producto:</td>
        <td width="403"><?php
		include("../principal/conectar_imp_web.php");
		if ($Producto != "000")
		{
			$sql = "SELECT * from productos where tipo_producto='".$Producto."'";
			$result = mysqli_query($link, $sql);
			if ($row = mysqli_fetch_array($result))
			{
				echo ucwords(strtolower($row["nombre"]));
			}
			else
			{
				echo "&nbsp;";
			}
		}
		else
		{
			echo "Productos en General";
		}
		?><input type="hidden" name="Producto" value="<?php echo $Producto;?>"></td>
      </tr>
      <tr> 
        <td>Proveedor:</td>
        <td><?php
		if (($Proveedor != "000000000") && ($Proveedor != ""))
		{
			$sql = "SELECT * from proveedores where tipo_producto='".$Producto."'";
			$sql.= " and rut_proveedor='".$Proveedor."'";
			$result = mysqli_query($link, $sql);
			if ($row = mysqli_fetch_array($result))
			{
				echo ucwords(strtolower($row["nombre"]));
			}
			else
			{
				echo "&nbsp;";
			}
		}
		else
		{
			echo "Proveedores en General";
		}
		include("../principal/cerrar_imp_web.php");
		?><input type="hidden" name="Proveedor" value="<?php echo $Proveedor;?>"></td>
      </tr>
    </table>
    <br>
    <table width="483" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
      <tr> 
        <td width="65">C&oacute;digo Ley</td>
        <td width="217"><SELECT name="Leyes" style="width:200px">
            <?php
	include("../principal/conectar_principal.php");
	$sql = "SELECT * from leyes order by cod_leyes";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		if ($Leyes == $row["cod_leyes"])
		{
			echo "<option SELECTed value='".$row["cod_leyes"]."'>".$row["cod_leyes"]." - ".ucwords(strtolower($row["nombre_leyes"]))."</option>";
		}
		else
		{
			echo "<option value='".$row["cod_leyes"]."'>".$row["cod_leyes"]." - ".ucwords(strtolower($row["nombre_leyes"]))."</option>";
		}
	}
?>
          </SELECT></td>
        <td width="47">L&iacute;mite</td>
        <td width="128">
			<input name="Limite" type="text" id="Limite" value="<?php echo number_format($Limite,4,',','.');?>" size="20" maxlength="10">
		</td>
      </tr>
      <tr align="center" valign="middle"> 
        <td colspan="4"><input type="button" name="BtnGrabar" value="Grabar" style="width:70px" onClick="Proceso('<?php echo $OptBoton;?>');"> 
          &nbsp; <input type="button" name="BtnCerrar" value="Cerrar" style="width:70px" onClick="Proceso('S');"> 
        </td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
