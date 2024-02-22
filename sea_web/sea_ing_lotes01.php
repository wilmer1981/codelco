<?php
	include("../principal/conectar_sea_web.php");
	//opcion=N&proceso=G&txtmarca=BL&txtlote=1001

	if (isset($_REQUEST["opcion"])) {
		$opcion = $_REQUEST["opcion"];
	}else {
		$opcion = '';
	}

	if (isset($_REQUEST["proceso"])) {
		$proceso = $_REQUEST["proceso"];
	}else {
		$proceso = '';
	}

	$txtmarca = $_REQUEST["txtmarca"];
	$txtlote  = $_REQUEST["txtlote"];
	$txtorigen  = $_REQUEST["txtorigen"];
	 
	$txthornada = $_REQUEST["txthornada"];
	$cmbanodos = $_REQUEST["cmbanodos"];

	if ($proceso == "B") //Buscar
	{
		$consulta = "SELECT * FROM relaciones WHERE lote_ventana = ".$txtlote;
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$parametros = "cmbanodos=".$row["cod_origen"]."&txthornada=".substr($row["hornada_ventana"],6,6);
			$parametros = $parametros."&txtorigen=".$row["lote_origen"]."&txtmarca=".$row["marca"];
			$parametros = $parametros."&ocultar=S&opc=M&mostrar=S&bloquear=S&txtlote=".$txtlote;
		}

		header("Location:sea_ing_lotes.php?".$parametros);
	}

	if (($proceso == "G") and ($opcion == "N"))//Grabar
	{
		$ano_hornada = date("Y");
		$mes_hornada = date("m");
		if (strlen($mes_hornada) == 1)
			$mes_hornada = "0".$mes_hornada;
		
		$txthornada = $ano_hornada.$mes_hornada.$txthornada;	
	
		$consulta = "SELECT * FROM relaciones WHERE lote_ventana = '".$txtlote."' ";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs)) //Existe
		{
			$mensaje = "El Lote ya existe";
			header("Location:sing_lotes.php?mensaje=".$mensaje);
		}
		else 
		{
			//Consulto a que ciclo pertenece la hornada.
			$consulta = "SELECT IFNULL(MAX(ciclo),0) AS ciclo FROM sea_web.relaciones WHERE cod_origen = ".$cmbanodos;
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			
			//Si la hornada es igual a la hornada de inicio (sub-clase), aumentar en 1.
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2005 AND cod_subclase = ".$cmbanodos;
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			
			if (substr($txthornada,6,4) == $row1["valor_subclase1"])
				$ciclo = $row["ciclo"] + 1;
			else
				$ciclo = $row["ciclo"];		
					
			$insertar = "INSERT INTO relaciones (cod_origen,lote_ventana,lote_origen,hornada_ventana,marca,ciclo)";
			$insertar = $insertar." VALUES (".$cmbanodos.",'".$txtlote."','".ucwords(strtolower($txtorigen))."',".$txthornada;
			$insertar = $insertar.",'".$txtmarca."',".$ciclo.")";			
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);
			header("Location:sea_ing_lotes.php");
		}
	}
	
	if (($proceso == "G") and ($opcion == "M")) //Actualizar
	{
			$actualizar = "UPDATE relaciones SET cod_origen = ".$cmbanodos.",lote_origen = '".ucwords(strtolower($txtorigen));
			$actualizar = $actualizar."',hornada_ventana = concat(left(hornada_ventana,6),".$txthornada."), marca = '".$txtmarca."'";
			$actualizar = $actualizar." WHERE lote_ventana = '".$txtlote."' ";
			mysqli_query($link, $actualizar);
			header("Location:sea_ing_lotes.php");	
	}
	
	
	if ($proceso == "E") //Eliminar
	{
		$consulta = "SELECT * FROM relaciones WHERE lote_ventana = '".$txtlote."' ";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$eliminar= "DELETE FROM relaciones WHERE lote_ventana = '".$txtlote."' ";
			mysqli_query($link, $eliminar);
			header("Location:sea_ing_lotes.php");	
		}
		else
		{
			$mensaje = "El Lote N� ".$txtlote." No Existe";
			header("Location:sea_ing_lotes.php?mensaje=".$mensaje);
		}		
	}
	

	include("../principal/cerrar_sea_web.php");
?>