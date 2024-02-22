<?php
	include("../principal/conectar_principal.php");
	switch ($Proceso)
	{
		case "G";
			$Consulta = "select * from age_web.recpromin ";
			$Consulta.= " where cod_producto='1'";
			$Consulta.= " and cod_subproducto='".$SubProducto."'";
			$Consulta.= " and rut_proveedor='".$Rut."'";
			$Consulta.= " and flujo='".$Flujos."'";
			$Resp = mysqli_query($link, $Consulta);
			if (!$Fila = mysqli_fetch_array($Resp))
			{				
				//INSERTA
				$Insertar = "insert into age_web.recpromin (cod_producto, cod_subproducto, rut_proveedor, tipo, flujo)";
				$Insertar.= " values('1','".$SubProducto."','".$Rut."','R','".$Flujos."')";
				mysqli_query($link, $Insertar);
			}
			echo "<script language='JavaScript'>";
			echo " window.opener.document.frmPrincipal.action = 'age_recpromin.php?Mostrar=S&SubProducto=".$SubProducto."';";
			echo " window.opener.document.frmPrincipal.submit();";
			echo " window.close();";
			echo "</script>";
			break;
		case "E";
			$Datos=explode('~~',$Valores);
			$SubProducto=$Datos[0];
			$Rut=$Datos[1];
			$Flujos=$Datos[2];
			$Eliminar = "delete from age_web.recpromin ";
			$Eliminar.= " where cod_producto='1'";
			$Eliminar.= " and cod_subproducto='".$SubProducto."'";
			$Eliminar.= " and rut_proveedor='".$Rut."'";
			$Eliminar.= " and flujo='".$Flujos."'";
			mysqli_query($link, $Eliminar);
			header("location:age_recpromin.php?Mostrar=S&SubProducto=".$SubProducto);
			break;
	}
?>