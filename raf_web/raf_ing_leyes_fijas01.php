<?
	include("../principal/conectar_principal.php");
  $Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	switch ($Proceso)
	{
		case "G":
			$Consulta = "SELECT * FROM raf_web.leyes_fijas";
		    $Consulta.= " WHERE cod_producto = '$Productos'";
		    $Consulta.= " AND cod_subproducto = '$SubProductos'";
		    $Consulta.= " and cod_leyes = '".$cmbleyes."' AND fecha = '".$Fecha."'";
		  	$rs = mysqli_query($link, $Consulta);
		    if($Fila = mysql_fetch_array($rs))
		    {
			   $peso_humedo = 0;			  
		    }

			//INSERTA			
			$valor = str_replace(',','.',$valor);
			//echo "valor".$valor;
			$Insertar = "insert into raf_web.leyes_fijas (fecha,cod_producto,cod_subproducto,cod_leyes,valor,cod_unidad)";
			$Insertar.= " values('".$Fecha."','".$Productos."','".$SubProductos."','".$cmbleyes."','".$valor."','".$cmbunidad."')";
			mysql_query($Insertar);
			header("location:raf_ing_leyes_fijas.php?Proceso=V&Productos=".$Productos."&SubProductos=".$SubProductos."&Ano=".$Ano."&Mes=".$Mes."&Dia=".$Dia);
			break;
		case "E":
			$Eliminar = "delete from raf_web.leyes_fijas ";
			$Eliminar.= " where cod_producto = '".$Productos."' ";
			$Eliminar.= " and cod_subproducto = '".$SubProductos."' ";
			$Eliminar.= " and fecha = '".$Fecha."'";
			mysql_query($Eliminar);
			header("location:raf_ing_leyes_fijas.php?Proceso=V&Productos=".$Productos."&SubProductos=".$SubProductos."&Ano=".$Ano."&Mes=".$Mes."&Dia=".$Dia);
			break;
	}
?>
