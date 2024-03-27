<?
	include("../principal/conectar_principal.php");
  $Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	switch ($Proceso)
	{
		case "G":
			$Eliminar = "delete from raf_web.leyes_circulantes ";
			$Eliminar.= " where cod_producto = '".$Productos."' ";
			$Eliminar.= " and cod_subproducto = '".$SubProductos."' ";
			$Eliminar.= " and fecha = '".$Fecha."'";
			$Eliminar.= " and cod_leyes = '".$cmbleyes."'";
			mysql_query($Eliminar);

		    $Consulta = "SELECT * FROM raf_web.leyes_circulantes";
		    $Consulta.= " WHERE cod_producto = '$Productos'";
		    $Consulta.= " AND cod_subproducto = '$SubProductos'";
		    $Consulta.= " AND fecha = '".$Fecha."'";
		    $Consulta.= " AND peso_humedo != 0";
		    $rs = mysqli_query($link, $Consulta);
		    if($Fila = mysql_fetch_array($rs))
		    {
			   $peso_humedo = 0;			  
		    }

			//INSERTA			
			$valor = str_replace(',','.',$valor);
			$Insertar = "insert into raf_web.leyes_circulantes (fecha,cod_producto,cod_subproducto,cod_leyes,valor,peso_humedo,cod_unidad)";
			$Insertar.= " values('".$Fecha."','".$Productos."','".$SubProductos."','".$cmbleyes."','".$valor."','".$peso_humedo."','".$cmbunidad."')";
			mysql_query($Insertar);
			header("location:raf_ing_leyes.php?Proceso=V&Productos=".$Productos."&SubProductos=".$SubProductos."&Ano=".$Ano."&Mes=".$Mes."&Dia=".$Dia);
			break;
		case "E":
			$Eliminar = "delete from raf_web.leyes_circulantes ";
			$Eliminar.= " where cod_producto = '".$Productos."' ";
			$Eliminar.= " and cod_subproducto = '".$SubProductos."' ";
			$Eliminar.= " and fecha = '".$Fecha."'";
			mysql_query($Eliminar);
			header("location:raf_ing_leyes.php?Proceso=V&Productos=".$Productos."&SubProductos=".$SubProductos."&Ano=".$Ano."&Mes=".$Mes."&Dia=".$Dia);
			break;
	}
?>