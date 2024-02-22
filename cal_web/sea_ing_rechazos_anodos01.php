<?php
	include("../principal/conectar_sea_web.php");

	$proceso        = $_REQUEST["proceso"];
	$cmbsubprod     = $_REQUEST["cmbsubprod"];
	$txtrecuperados = $_REQUEST["txtrecuperados"];
	$txtrechazos    = $_REQUEST["txtrechazos"];
	$cmbloteenami   = $_REQUEST["cmbloteenami"];

	$dia = $_REQUEST["dia"];
	$mes = $_REQUEST["mes"];
	$ano = $_REQUEST["ano"];

	
	if ($proceso == "G")
	{
		$fecha = $ano.'-'.$mes.'-'.$dia.' '.date("H:i:s");
		$hornada = explode("~",$cmbloteenami); // 0: lote_enami, 1: marca, 2: lote_origen, 3: hornada.
		
		//Busca el flujo Asociado al producto y proceso.		
		$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 6 AND cod_producto = 17";
		$consulta = $consulta." AND cod_subproducto = ".$cmbsubprod;
		//echo $consulta."<br>";

		$rs1 = mysqli_query($link, $consulta);
		if ($row1 = mysqli_fetch_array($rs1))
			$flujo = $row1["flujo"];
		else 
			$flujo = 0;		

		//Consulta si existe.
		$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND hornada = ".$hornada[3]." AND cod_subproducto = ".$cmbsubprod;
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			//Actualizar en rechazos.
			$actualizar = "UPDATE rechazos SET recuperables = ".$txtrecuperados.",rechazados = ".$txtrechazos;
			$actualizar = $actualizar." WHERE hornada = ".$hornada[3]." AND cod_subproducto = ".$cmbsubprod." AND cod_defecto = 0 AND cod_tipo = 6";			
			mysqli_query($link, $actualizar);
			
			//consulta peso para las unidades.
			$consulta = "SELECT (".$txtrechazos." * (peso_unidades / unidades)) AS peso FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = ".$cmbsubprod." AND hornada_ventana = ".$hornada[3];
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			
			//Actualizar en Movimientos.
			$actualizar = "UPDATE movimientos SET unidades = ".$txtrechazos.", peso = ".$row2["peso"];
			$actualizar = $actualizar." WHERE tipo_movimiento = 6 AND cod_producto = 17 AND cod_subproducto = ".$cmbsubprod." AND hornada =".$hornada[3];
			mysqli_query($link, $actualizar);
						
			
			//Borra los detalles y los vuelve a ingresar.
			$eliminar = "DELETE FROM rechazos WHERE hornada = ".$hornada[3]." AND cod_subproducto = ".$cmbsubprod." AND cod_defecto <> 0 AND cod_tipo = 6"; 
			mysqli_query($link, $eliminar);
			
			//Ingresa los detalles de los rechazos y recuperables.
			$arreglo = explode("/",$parametros); //Separa los parametros en un array.
			reset($arreglo);					
			while (list($clave, $valor) = each($arreglo))
			{		
				$detalle = explode("~",$valor); //check - observacion - recuperables - rechazados. 
				
				$insertar = "INSERT INTO rechazos VALUES (6,'".$fecha."','',".$cmbproducto.",".$cmbsubprod.",".$hornada[3].",".$detalle[1].",'";
				$insertar = $insertar.$CookieRut."',".$detalle[2].",".$detalle[3].",0)";
				mysqli_query($link, $insertar);			
			}
			
			$mensaje = "Rechazos Actualizados Correctamente";
			header("Location:sea_ing_rechazos_anodos.php?mensaje=".$mensaje);
		}
		else
		{
			//Insertar.

			//Ingresa los totales de rechazos y recuperables.
			
			//En Rechazos.
			$insertar = "INSERT INTO rechazos VALUES (6,'".$fecha."','',".$cmbproducto.",".$cmbsubprod.",".$hornada[3].",0,'";
			$insertar = $insertar.$CookieRut."',".$txtrecuperados.",".$txtrechazos.",0)";
			mysqli_query($link, $insertar);
			
			//consulta peso para las unidades.
			$consulta = "SELECT (".$txtrechazos." * (peso_unidades / unidades)) AS peso FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = ".$cmbsubprod." AND hornada_ventana = ".$hornada[3];
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			
			//En Movimientos.
			$insertar = "INSERT INTO movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso)";
			$insertar = $insertar." VALUES (6,".$cmbproducto.",".$cmbsubprod.",".$hornada[3].",0,'".$fecha."',";
			$insertar = $insertar."0,0,".$txtrechazos.",".$flujo.",".$row2["peso"].")";
			mysqli_query($link, $insertar);
	
			//Ingresa los detalles de los rechazos y recuperables.
			$arreglo = explode("/",$parametros); //Separa los parametros en un array.
			reset($arreglo);					
			while (list($clave, $valor) = each($arreglo))
			{		
				$detalle = explode("~",$valor); //check - observacion - recuperables - rechazados. 
				
				$insertar = "INSERT INTO rechazos VALUES ('6','".$fecha."','','".$cmbproducto."','".$cmbsubprod."','".$hornada[3]."','".$detalle[1]."','";
				$insertar = $insertar.$CookieRut."','".$detalle[2]."','".$detalle[3]."',0)";
				//echo $insertar."<br>";
				mysqli_query($link, $insertar);			
			}
			
			$mensaje = "Rechazos Grabados Correctamente";
			header("Location:sea_ing_rechazos_anodos.php?mensaje=".$mensaje);								
		}
	}
	
	//Consulta los Rechazos.
	if ($proceso == "B")
	{				
		$arreglo = explode("~",$cmbloteenami); //0: lote_enami, 1: marca, 2: lote origen, 3: hornada.
		$valores = "recargapag=S&mostrar=S&cmbloteenami=".$cmbloteenami."&cmbsubprod=".$cmbsubprod."&hornada=".$arreglo[3];
		$valores = $valores."&ano=".$ano."&mes=".$mes."&dia=".$dia;
		
		$consulta = "SELECT * FROM relaciones WHERE lote_ventana = ".$arreglo[0]." AND hornada_ventana = ".$arreglo[3];
		$rs2 = mysqli_query($link, $consulta);
		$row2 = mysqli_fetch_array($rs2);		
		$valores = $valores."&marca=".$row2["marca"]."&loteorigen=".$row2["lote_origen"];
				
		$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND cod_defecto = 0 AND cod_subproducto = ".$cmbsubprod." AND hornada = ".$arreglo[3];
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{			
			$valores = $valores."&txtrecuperados=".$row[recuperables]."&txtrechazos=".$row[rechazados];
			//recuperar los detalles.
			$parametros = "";
			$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND cod_defecto <> 0 AND cod_subproducto = ".$cmbsubprod." AND hornada = ".$arreglo[3];
			$i=0;
			$rs1 = mysqli_query($link, $consulta);
			while ($row1 = mysqli_fetch_array($rs1))
			{
				$parametros = $parametros."0~".$row1[cod_defecto]."~".$row1[recuperables]."~".$row1[rechazados]."/";
				$i++;
			}
			
			//--.
			$stropc = "";
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = '2008' ORDER BY cod_subclase";
			$rs10 = mysqli_query($link, $consulta);
			while ($row10 = mysqli_fetch_array($rs10))
			{
				$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND cod_defecto = '".$row10["cod_subclase"]."' AND cod_subproducto = ".$cmbsubprod." AND hornada = ".$arreglo[3];
				//echo $consulta."<br>";
				$rs11 = mysqli_query($link, $consulta);
				if ($row11 = mysqli_fetch_array($rs11))
					$stropc = $stropc.'1~';
				else
					$stropc = $stropc.'0~';
			}
			//--.
			
			$valores = $valores."&verificatabla=S&agregafila=N&numero=".$i;
			$valores = $valores."&parametros=".$parametros."&stropc=".$stropc;
		
		
			$arreglo = explode("-",$row[fecha_ini]); //0: ano, 1: mes, 2: dia.
			$valores = $valores."&ano=".$arreglo[0]."&mes=".$arreglo[1]."&dia=".substr($arreglo[2],0,2);
		}				

		header("Location:sea_ing_rechazos_anodos.php?".$valores);
	}
	
	//Elimina los Rechazos.
	if ($proceso == "E")
	{
		$arreglo = explode("~",$cmbloteenami); //0: lote_enami, 1: marca, 2: lote origen, 3: hornada.
		
		$consulta = "SELECT * FROM rechazos WHERE cod_tipo = 6 AND hornada = ".$arreglo[3]." AND cod_subproducto = ".$cmbsubprod;
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			//Elimina de movimiento.
			$eliminar = "DELETE FROM movimientos WHERE tipo_movimiento = 6 AND cod_producto = 17 AND cod_subproducto = ".$cmbsubprod." AND hornada = ".$arreglo[3];
			mysqli_query($link, $eliminar);
			
			//Elimina de rechazos.
			$eliminar = "DELETE FROM rechazos WHERE cod_tipo = 6 AND hornada = ".$arreglo[3]." AND cod_subproducto = ".$cmbsubprod;
			mysqli_query($link, $eliminar);
			
			$mensaje = "Rechazos Eliminados Correctante";
		}				
		else 
			$mensaje = "No Existen Rechazos para Este Lote";
			
		header("Location:sea_ing_rechazos_anodos.php?mensaje=".$mensaje);
	}
	
	include("../principal/cerrar_sea_web.php");
?>