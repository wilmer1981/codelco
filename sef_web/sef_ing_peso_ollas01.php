<?
	include("../principal/conectar_sef_web.php");
	switch ($Proceso)
	{
		case "CAN":
			header("location:sef_ing_peso_ollas.php");
			break;
		case "G":
			$Consulta = "SELECT * from sef.producto_por_equipo ";
			$Consulta.= " where Cod_equipo = '".$Equipo."' and Cod_producto = '".$Producto."'";
			$Respuesta = mysql_query($Consulta);
			if ($Fila = mysql_fetch_array($Respuesta))
			{
				//ACTUALIZA
				$Actualizar = "UPDATE sef.producto_por_equipo set ";
				$Actualizar.= " Peso_base = '".str_replace(",",".",$PesoOlla)."'";
				$Actualizar.= " where Cod_equipo = '".$Equipo."' and Cod_producto = '".$Producto."'";
				mysql_query($Actualizar);
			}
			else
			{
				//INGRESA NUEVO
				$Insertar = "INSERT INTO sef.`producto_por_equipo` ";
				$Insertar.= " (`Cod_equipo`, `Cod_producto`, `Peso_base`) ";
				$Insertar.= " VALUES ('".$Equipo."', '".$Producto."', '".str_replace(",",".",$PesoOlla)."');";
				mysql_query($Insertar);
			}
			header("location:sef_ing_peso_ollas.php");
			break;
		case "E":
			$Consulta = "delete from sef.producto_por_equipo ";
			$Consulta.= " where Cod_equipo = '".$C_Equipo."' and Cod_producto = '".$C_Producto."'";
			mysql_query($Consulta);
			header("location:sef_ing_peso_ollas.php");
			break;
	}
	include("../principal/cerrar_sef_web.php");
?>