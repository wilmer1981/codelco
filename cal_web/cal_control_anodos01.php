<?php	
	include("../principal/conectar_principal.php");

	$TipoProducto = $_REQUEST["TipoProducto"];
	$Proceso 	  = $_REQUEST["Proceso"];
	$TxtCodigo 	  = $_REQUEST["TxtCodigo"];
	$Valores 	  = $_REQUEST["Valores"];
	$Modif 		  = $_REQUEST["Modif"];
	$TxtDescripcion = $_REQUEST["TxtDescripcion"];
	$CmbPlantilla = $_REQUEST["CmbPlantilla"];

	$Datos = explode("-",$TipoProducto);
	$Producto = $Datos[0];
	$SubProducto = $Datos[1];

	switch ($Proceso)
	{
		case "G":		
			if ($Modif=="S")
			{
				$Consulta = "SELECT DISTINCT corr, descripcion FROM sea_web.limites ";
				$Consulta.= " WHERE sistema='CAL' and cod_producto = '".$Producto."'";
				$Consulta.= " AND cod_subproducto = '".$SubProducto."' and corr='".$TxtCodigo."'";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$TxtDescripcion=$Fila["descripcion"];
				}
			}	
			//ELIMINO DATO ANTERIOR
			$Eliminar = "delete from sea_web.limites ";
			$Eliminar.= " where cod_producto = '".$Producto."'";
			$Eliminar.= " and cod_subproducto = '".$SubProducto."'"; 
			$Eliminar.= " and sistema = 'CAL'"; 
			$Eliminar.= " and corr = '".$TxtCodigo."'"; 
			mysqli_query($link, $Eliminar);
			//----------------------------
			$Datos = explode("//",$Valores);
			//foreach($Datos as $k => $v)
			foreach($Datos as $k => $v )
			{
				$Datos2 = explode("~~",$v);
				$CodLey = $Datos2[0];
				$Signo = $Datos2[1];
				$Valor = str_replace(",",".",$Datos2[2]);				
				$Insertar = "insert into sea_web.limites (cod_producto, cod_subproducto, cod_leyes, signo, limite, sistema, corr, descripcion) ";
				$Insertar.= " values('".$Producto."','".$SubProducto."','".$CodLey."','".$Signo."','".$Valor."', 'CAL', '".$TxtCodigo."', '".strtoupper($TxtDescripcion)."')";
				mysqli_query($link, $Insertar);		
			}
			if ($Modif=="S")
			{
				header("location:cal_control_anodos.php?TipoProducto=".$TipoProducto."&CmbPlantilla=".$TxtCodigo);
			}
			else
			{
				echo "<script languaje='JavaScript'>";
				echo "window.opener.frmPrincipal.action='cal_control_anodos.php?TipoProducto=".$TipoProducto."&CmbPlantilla=".$TxtCodigo."';";
				echo "window.opener.frmPrincipal.submit();";
				echo "window.close();";
				echo "</script>";
			}
			break;
		case "E":
			$Eliminar = "delete from sea_web.limites ";
			$Eliminar.= " where cod_producto = '".$Producto."'";
			$Eliminar.= " and cod_subproducto = '".$SubProducto."'"; 
			$Eliminar.= " and sistema = 'CAL'"; 
			$Eliminar.= " and corr = '".$CmbPlantilla."'"; 
			mysqli_query($link, $Eliminar);			
			header("location:cal_control_anodos.php?TipoProducto=".$TipoProducto."&CmbPlantilla=".$CmbPlantilla);
			break;
	}	
?>
