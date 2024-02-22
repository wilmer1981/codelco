<?php
	//Id_Muestra=03&Fecha=2023-11-24&Producto=001&Proveedor=083048069
	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else {
		$Proceso = "";
	}
	if(isset($_REQUEST["Id_Muestra"])){
		$Id_Muestra = $_REQUEST["Id_Muestra"];
	}else {
		$Id_Muestra = "";
	}

	if(isset($_REQUEST["Producto"])){
		$Producto = $_REQUEST["Producto"];
	}else {
		$Producto = "";
	}

	if(isset($_REQUEST["Proveedor"])){
		$Proveedor = $_REQUEST["Proveedor"];
	}else {
		$Proveedor = "";
	}

	if(isset($_REQUEST["Leyes"])){
		$Leyes = $_REQUEST["Leyes"];
	}else {
		$Leyes = "";
	}

	
	if(isset($_REQUEST["Fecha"])){
		$FechaMuestra = $_REQUEST["Fecha"];
	}else{
		$FechaMuestra = "";
	}
	
	if(isset($_REQUEST["FechaProceso"])){
		$FechaProceso = $_REQUEST["FechaProceso"];
	}else{
		$FechaProceso = "";
	}
	
	$OptBoton = "G";
	$Valor= "0.0";
	if ($Proceso == "ML")
	{

		$Ley = $_REQUEST["Ley"];
		//$Ano = $_REQUEST["Ano"];
		//$Mes = $_REQUEST["Mes"];
		//$Dia = $_REQUEST["Dia"];

		//$Fecha = $Ano."-".$Mes."-".$Dia;
		$OptBoton = "M";
		$Leyes = $Ley;
		include("../principal/conectar_imp_web.php");
		$sql = "SELECT * from leyes_especiales ";
		$sql.= " where id_muestra = '".$Id_Muestra."'";
		$sql.= " and tipo_producto = '".$Producto."'";
		$sql.= " and rut_proveedor = '".$Proveedor."'";
		$sql.= " and cod_leyes = '".$Leyes."'";		
		$result = mysqli_query($link, $sql);
		if ($row=mysqli_fetch_array($result))
		{
			$Valor= $row["valor"];
			$Unidad = $row["cod_unidad"];
		}
		else
		{
			$Valor= "0.0";
		}
		include("../principal/cerrar_imp_web.php");
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
			if (f.Valor.value != "")
			{
				f.action="imp_ing_leyes_esp01.php?Proceso=GL";
				f.submit();
			}
			else
			{
				alert("Debe ingresar Valor para la Muestra");
				return;
			}
			break
		case "M":
			if (f.Valor.value != "")
			{
				f.action="imp_ing_leyes_esp01.php?Proceso=ML";
				f.submit();
			}
			else
			{
				alert("Debe ingresar Valor para la Muestra");
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
<input type="hidden" name="FechaProceso" value="<?php echo $FechaMuestra; ?>">
<table width="484" height="20" border="0" align="center" cellpadding="3" cellspacing="0">
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
    <table width="484" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr> 
        <td width="66">Producto:</td>
        <td width="404">
          <?php
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
			echo "No hay Producto Seleccionado &nbsp;";
		}
		?>
          <input type="hidden" name="Producto" value="<?php echo $Producto;?>"></td>
      </tr>
      <tr> 
        <td>Proveedor:</td>
        <td>
          <?php
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
			echo "No hay proveedor Seleccionado";
		}
		include("../principal/cerrar_imp_web.php");
		?>
          <input type="hidden" name="Proveedor" value="<?php echo $Proveedor;?>"></td>
      </tr>
      <tr>
        <td>ID Muestra</td>
        <td><?php echo $Id_Muestra; ?> <input name="ID" type="hidden" value="<?php echo $Id_Muestra;?>"></td>
      </tr>
    </table>
    <br>
    <table width="596" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr> 
        <td height="5" colspan="4">&nbsp;</td>
      </tr>
      <tr> 
        <td width="69">C&oacute;digo Ley</td>
        <td width="216">
			<SELECT name="Leyes" style="width:200px">
            <?php
				include("../principal/conectar_principal.php");
				$sql = "SELECT * FROM leyes order by cod_leyes";
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
        <td width="33">Valor</td>
        <td width="197"><input name="Valor" type="text" id="Valor" value="<?php echo number_format($Valor,4,',','.');?>" size="20" maxlength="10">
          <SELECT name="Unidad" style="width:60px">
		  <?php
		  	$sql = "SELECT * from unidades order by cod_unidad";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_array($result))
			{
				if ($Unidad == $row["cod_unidad"])
				{
					echo "<option SELECTed value='".$row["cod_unidad"]."'>".strtoupper($row["abreviatura"])."</option>\n";
				}
				else
				{
					echo "<option value='".$row["cod_unidad"]."'>".strtoupper($row["abreviatura"])."</option>\n";
				}
			}
		  ?>
          </SELECT></td>
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
