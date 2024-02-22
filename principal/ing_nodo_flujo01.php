<?php	
	//include("../principal/conectar_comet_web.php");
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["proceso"])){
		$proceso=$_REQUEST["proceso"];
	}else{
		$proceso="";
	}

	$nodo			=$_REQUEST["nodo"];
	$sistema		=$_REQUEST["sistema"];
	$tipo     		=$_REQUEST["tipo"];

	$txtflujo		=$_REQUEST["txtflujo"];
	$txtdescripcion	=$_REQUEST["txtdescripcion"];
	$radiotipo			=$_REQUEST["radiotipo"];

	$existencia		=$_REQUEST["existencia"];
	$ajuste			=$_REQUEST["ajuste"];
	
	
	if ($proceso == 'GN') //Graba Nodo.
	{	
		$consulta = "SELECT * FROM proyecto_modernizacion.nodos";
		$consulta.= " WHERE cod_nodo = '".$nodo."' AND sistema = '".$sistema."'";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mensaje = "Los Datos Ingresados Ya Existen";
			
			echo '<script language="JavaScript">';
			echo 'alert("'.$mensaje.'");';
			echo 'window.history.back()';
			echo '</script>';
			//break;
		}else{

			if ($sistema == 'PMN')	
				$tipo_balance = 'PMN';
			else
				$tipo_balance = 'CCU';
			
				
			//Inserta Nodo.
			$insertar = "INSERT INTO proyecto_modernizacion.nodos (cod_nodo, descripcion, sistema, valor1, tipo_balance, virtual)";
			$insertar.= " VALUES ('".$nodo."', '".$txtdescripcion."', '".$sistema."', 'M', '$tipo_balance', 'N')";
			mysqli_query($link, $insertar);

			if ($existencia == 'S')
			{
				//Crea las Existencias para el Comet.
				$insertar = "INSERT INTO proyecto_modernizacion.flujos (cod_flujo, descripcion, nodo, tipo, sistema, esflujo, orden, mostrar)";
				$insertar.= " VALUES ('EI', 'EXISTENCIA INICIAL', '".$nodo."', 'E', '".$sistema."', 'N', '1', 'S')";
				mysqli_query($link, $insertar);
				
				$insertar = "INSERT INTO proyecto_modernizacion.flujos (cod_flujo, descripcion, nodo, tipo, sistema, esflujo, orden, mostrar)";
				$insertar.= " VALUES ('EF', 'EXISTENCIA FINAL', '".$nodo."', 'S', '".$sistema."', 'N', '4', 'S')";
				mysqli_query($link, $insertar);
			}
			
			if ($ajuste == 'S')
			{
				//Crea los Ajustes para el Comet.
				$insertar = "INSERT INTO proyecto_modernizacion.flujos (cod_flujo, descripcion, nodo, tipo, sistema, esflujo, orden, mostrar, detalle_ajuste)";
				$insertar.= " VALUES ('A+', 'AJUSTE', '$nodo', 'E', '$sistema', 'N', '3', 'S', 'S')";
				mysqli_query($link, $insertar);
				
				$insertar = "INSERT INTO proyecto_modernizacion.flujos (cod_flujo, descripcion, nodo, tipo, sistema, esflujo, orden, mostrar, detalle_ajuste)";
				$insertar.= " VALUES ('A-', 'AJUSTE', '$nodo', 'S', '$sistema', 'N', '3', 'S', 'S')";
				mysqli_query($link, $insertar);				
			}

			echo '<script language="JavaScript">';
			echo 'window.opener.document.FrmNodoFlujo.action = "ing_nodo_flujo.php?recargapag=S";';
			echo 'window.opener.document.FrmNodoFlujo.submit();';
			echo 'window.close()';
			echo '</script>';
		}
	}
	
	//---.
	if ($proceso == 'MN')
	{
		if ($virtual != 'S')
			$virtual = 'N';
	
		$actualizar = "UPDATE proyecto_modernizacion.nodos SET";
		$actualizar.= " descripcion = '".$txtdescripcion."'";
		$actualizar.= " WHERE cod_nodo = '".$nodo."' AND sistema = '".$sistema."'";
		//echo $actualizar."<br>";
		mysqli_query($link, $actualizar);
		
		if ($existencia == 'S')
		{
			//Si esta checheada no hacer nada.
			$consulta = "SELECT * FROM proyecto_modernizacion.flujos";
			$consulta.= " WHERE nodo = '".$nodo."' AND sistema = '".$sistema."' AND cod_flujo IN ('EI', 'EF')";
			$rs = mysqli_query($link, $consulta);
			if (!$row = mysqli_fetch_array($rs))
			{
				//Crea las Existencias para el Comet.
				$insertar = "INSERT INTO proyecto_modernizacion.flujos (cod_flujo, descripcion, nodo, tipo, sistema, esflujo, orden, mostrar)";
				$insertar.= " VALUES ('EI', 'EXISTENCIA INICIAL', '".$nodo."', 'E', '".$sistema."', 'N', '1', 'S')";
				mysqli_query($link, $insertar);
				
				$insertar = "INSERT INTO proyecto_modernizacion.flujos (cod_flujo, descripcion, nodo, tipo, sistema, esflujo, orden, mostrar)";
				$insertar.= " VALUES ('EF', 'EXISTENCIA FINAL', '".$nodo."', 'S', '".$sistema."', 'N', '4', 'S')";
				mysqli_query($link, $insertar);			
			}							
		}
		else
		{
			$eliminar = "DELETE FROM proyecto_modernizacion.flujos";
			$eliminar.= " WHERE nodo = '".$nodo."' AND sistema = '".$sistema."' AND cod_flujo IN ('EI', 'EF')";
			mysqli_query($link, $eliminar);			
		}
		
		if ($ajuste == 'S')
		{
			$eliminar = "DELETE FROM proyecto_modernizacion.flujos";
			$eliminar.= " WHERE nodo = '".$nodo."' AND sistema = '".$sistema."' AND cod_flujo IN ('A+', 'A-')";
			mysqli_query($link, $eliminar);		
		
			//Crea los Ajustes para el Comet.
			$insertar = "INSERT INTO proyecto_modernizacion.flujos (cod_flujo, descripcion, nodo, tipo, sistema, esflujo, orden, mostrar, detalle_ajuste)";
			$insertar.= " VALUES ('A+', 'AJUSTE CONTA', '$nodo', 'E', '$sistema', 'N', '3', 'S', 'S')";
			mysqli_query($link, $insertar);
			
			$insertar = "INSERT INTO proyecto_modernizacion.flujos (cod_flujo, descripcion, nodo, tipo, sistema, esflujo, orden, mostrar, detalle_ajuste)";
			$insertar.= " VALUES ('A-', 'AJUSTE CONTA', '$nodo', 'S', '$sistema', 'N', '3', 'S', 'S')";
			mysqli_query($link, $insertar);				
		}
		else
		{
			$eliminar = "DELETE FROM proyecto_modernizacion.flujos";
			$eliminar.= " WHERE nodo = '".$nodo."' AND sistema = '".$sistema."' AND cod_flujo IN ('A+', 'A-')";
			mysqli_query($link, $eliminar);		
		}		

		echo '<script language="JavaScript">';
		echo 'window.close()';
		echo '</script>';								
	}
	
	//---.
	if ($proceso == 'EN') //Elimina Nodo Y sus Flujos Asociados.
	{
		//while(list($c,$v) = each($checkbox))
		foreach ($checkbox as $c => $v)
		{
			//Elimina Detalle.
			$eliminar = "DELETE FROM proyecto_modernizacion.flujos";
			$eliminar.= " WHERE nodo = '".$v."' AND sistema = '".$sistema."'";
			mysqli_query($link, $eliminar);
				
			//Elimina Nodo.		
			$eliminar = "DELETE FROM proyecto_modernizacion.nodos";
			$eliminar.= " WHERE cod_nodo = '".$v."' AND sistema = '".$sistema."'";
			mysqli_query($link, $eliminar);			
			if($sistema=='PMN')//ELIMINA TODOS LOS FLUJOS DE LA TABLA RELACION_FLUJOS DE PMN_WEB
			{
				$eliminar = "DELETE FROM pmn_web.relacion_flujo";	
				$eliminar.= " WHERE nodo = '".$v."'";
				mysqli_query($link, $eliminar);
			}
			header("Location:ing_nodo_flujo.php?recargapag=1&cmbsistema=".$sistema);
		}
	}
	
	
	//---.PARA TRABAJAR CON FLUJOS
	if ($proceso == 'GF')
	{	
		$consulta = "SELECT * FROM proyecto_modernizacion.flujos";
		$consulta.= " WHERE cod_flujo = '".$txtflujo."' AND nodo = '".$nodo."' AND sistema = '".$sistema."'";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mensaje = "Los Datos Ingresados Ya Existen";
			
			echo '<script language="JavaScript">';
			echo 'alert("'.$mensaje.'");';
			echo 'window.history.back()';
			echo '</script>';
			//break;		
		}
		else
		{
			$orden = 3;
			$insertar = "INSERT INTO proyecto_modernizacion.flujos (cod_flujo, descripcion, nodo, tipo, sistema, calcular, suma, resta, tabla, esflujo,orden)";
			$insertar.= " VALUES ('".$txtflujo."', '".$txtdescripcion."', '".$nodo."', '".$radiotipo."', '".$sistema."', '".$radiocalcula."',";
			$insertar.= "'".$txtsuma."', '".$txtresta."', '".$cmbtabla."','".$virtual."','".$orden."')";
			mysqli_query($link, $insertar);
			//INSERTAR EN LA TABLA RELACION FLUJO PMN
			$insertar = "INSERT INTO pmn_web.relacion_flujo(nodo,flujo,cod_producto,cod_subproducto,tipo_mov,signo)";
			$insertar.= " VALUES ('".$nodo."', '".$txtflujo."', '".$cmbproducto."', '".$cmbsubproducto."', '".$cmbmovimiento."', '".$Signo."')";
			mysqli_query($link, $insertar);
			$linea = "nodo=".$nodo."&sistema=".$sistema;
			header("Location:ing_nodo_flujo_detalle.php?".$linea);
		}
	}
	
	//---.
	if ($proceso == 'MF')
	{
		if ($prodprincipal == '')
			$orden = 3;
		else
			$orden = 2;
		if ($txtflujo == 'EI')
			$orden = 1;
		if ($txtflujo == 'EF')
			$orden = 4;		
			
		$actualizar = "UPDATE proyecto_modernizacion.flujos SET"; 
		$actualizar.= " descripcion = '".$txtdescripcion."',";
		$actualizar.= " tipo = '".$radiotipo."',";
		$actualizar.= " calcular = '".$radiocalcula."',";
		$actualizar.= " suma = '".$txtsuma."',";
		$actualizar.= " resta = '".$txtresta."',";
		$actualizar.= " tabla = '".$cmbtabla."',";
		$actualizar.= " esflujo = '".$virtual."' ";
		$actualizar.= " WHERE nodo = '".$nodo."' AND tipo = '".$tipo."' AND cod_flujo = '".$txtflujo."' AND sistema = '".$sistema."'";
		mysqli_query($link, $actualizar);
		$actualizar = "UPDATE pmn_web.relacion_flujo SET"; 
		$actualizar.= " cod_producto = '".$cmbproducto."',";
		$actualizar.= " cod_subproducto = '".$cmbsubproducto."',";
		$actualizar.= " tipo_mov = '".$cmbmovimiento."' ";
		$actualizar.= " WHERE nodo = '".$nodo."' AND flujo = '".$txtflujo."'";
		mysqli_query($link, $actualizar);
		$linea = "nodo=".$nodo."&sistema=".$sistema;
		header("Location:ing_nodo_flujo_detalle.php?".$linea);
	}
	//---.
	if ($proceso == 'EF')
	{	
		$eliminar = "DELETE FROM proyecto_modernizacion.flujos";	
		$eliminar.= " WHERE nodo = '".$nodo."' AND tipo = '".$tipo."' AND cod_flujo = '".$txtflujo."' AND sistema = '".$sistema."'";
		mysqli_query($link, $eliminar);
		$eliminar = "DELETE FROM pmn_web.relacion_flujo";	
		$eliminar.= " WHERE nodo = '".$nodo."' AND flujo = '".$txtflujo."'";
		mysqli_query($link, $eliminar);
		$linea = "nodo=".$nodo."&sistema=".$sistema;
		header("Location:ing_nodo_flujo_detalle.php?".$linea);		
	}
?>
