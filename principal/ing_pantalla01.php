<?php
	include ("conectar_principal.php");

$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Valores      = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
$Mensaje      = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";

    //VARIABLES POST 
	//if($Proceso=="G" || $Proceso=="M"){
		$Sistema      = isset($_REQUEST["Sistema"])?$_REQUEST["Sistema"]:"";
		$Descripcion  = isset($_REQUEST["Descripcion"])?$_REQUEST["Descripcion"]:"";
		$CodPantalla  = isset($_REQUEST["CodPantalla"])?$_REQUEST["CodPantalla"]:"";
		$PantAgrup    = isset($_REQUEST["PantAgrup"])?$_REQUEST["PantAgrup"]:"";
		$NivelMenu    = isset($_REQUEST["NivelMenu"])?$_REQUEST["NivelMenu"]:"";
		$CodSistema   = isset($_REQUEST["CodSistema"])?$_REQUEST["CodSistema"]:"";
		$NivelSistema = isset($_REQUEST["NivelSistema"])?$_REQUEST["NivelSistema"]:"";
		$Link         = isset($_REQUEST["Link"])?$_REQUEST["Link"]:"";
		$Orden        = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
		$TipoPag      = isset($_REQUEST["TipoPag"])?$_REQUEST["TipoPag"]:"";
		$EstPag       = isset($_REQUEST["EstPag"])?$_REQUEST["EstPag"]:"";
		$NivelElim    = isset($_REQUEST["NivelElim"])?$_REQUEST["NivelElim"]:"";
	//}

	switch ($Proceso)
	{
		case "G":
			$Error = "N";
			$Mensaje = "";
			$sql = "SELECT * from proyecto_modernizacion.pantallas where cod_sistema = '".$Sistema."' and cod_pantalla = '".$CodPantalla."'";
			$result = mysqli_query($link, $sql);
			if ($row = mysqli_fetch_array($result))
			{
				$Error = "S";
				$Mensaje = "Operacion no realizada, Pantalla ya existe";				
			}
			else
			{								
				$sql = "INSERT INTO proyecto_modernizacion.pantallas(cod_sistema, cod_pantalla, descripcion, link, tipo, orden,estado)";
				$sql.= " VALUES ('".$Sistema."','".$CodPantalla."','".$Descripcion."','".$Link."', '".$TipoPag."', '".$Orden."','".$EstPag."')";
				mysqli_query($link, $sql);
			}
			header("location:ing_pantalla02.php?Sistema=".$Sistema."&Proceso=M&CodPantalla=".$CodPantalla."&Error=".$Error."&Mensaje=".$Mensaje);
			break;
		case "A":
			$Error = "N";
			$Mensaje = "";
			$Actualizar = "UPDATE proyecto_modernizacion.pantallas SET ";
			$Actualizar.= " descripcion = '".$Descripcion."', ";
			$Actualizar.= " link = '".$Link."', ";
			$Actualizar.= " tipo = '".$TipoPag."', ";
			$Actualizar.= " orden = '".$Orden."', ";
			$Actualizar.= " estado = '".$EstPag."'";
			$Actualizar.= " WHERE cod_sistema = '".$Sistema."'";
			$Actualizar.= " AND cod_pantalla = '".$CodPantalla."'";
			mysqli_query($link, $Actualizar);
			header("location:ing_pantalla02.php?Sistema=".$Sistema."&Proceso=M&CodPantalla=".$CodPantalla."&Error=".$Error."&Mensaje=".$Mensaje);
			break;
		case "E":
			for ($i = 0; $i <= strlen($Valores); $i++)
			{
				if (substr($Valores,$i,1) == "/")
				{
					$CodPantalla = substr($Valores,0,$i);
					//ELIMINO DE LA TABLA ACCESO_MENU LAS RELACIONES A LA PANTALLA
					$Eliminar = "DELETE from proyecto_modernizacion.acceso_menu where ";
					$Eliminar.= " cod_sistema = '".$Sistema."' ";
					$Eliminar.= " AND cod_pantalla = '".$CodPantalla."' ";
					mysqli_query($link, $Eliminar);

					//ELIMINO DE LA TABLA PANTALLAS					
					$Eliminar = "DELETE FROM proyecto_modernizacion.pantallas WHERE ";
					$Eliminar.= " cod_sistema = '".$Sistema."' ";
					$Eliminar.= " AND cod_pantalla = '".$CodPantalla."' ";
					mysqli_query($link, $Eliminar);
					$Valores = substr($Valores,$i+1);
					$i = 0;
				}
			}
			header("location:ing_pantalla.php?Sistema=".$Sistema);
			break;
		case "ING_SEG":
			if ($NivelSistema == "S")
					$NivelAux1 = 0;
			else 	$NivelAux1 = $NivelSistema;
			if ($NivelMenu == "S")
				$NivelAux2 = 0;
			else 	$NivelAux2 = $NivelMenu;
			if ($PantAgrup == "S")
				$NivelAux3 = 0;
			else 	$NivelAux3 = $PantAgrup;
			$sql = "select * from proyecto_modernizacion.acceso_menu where cod_sistema = ".$CodSistema." and cod_pantalla = ".$CodPantalla;
			$sql.= " and nivel = ".$NivelAux1;	
			$result = mysqli_query($link, $sql);
			if ($row = mysqli_fetch_array($result))
			{
				$Actualizar = "UPDATE proyecto_modernizacion.acceso_menu SET nivel_agrup = ".$NivelAux2.", cod_pant_agrup=".$NivelAux3;
				$Actualizar = $Actualizar." where cod_sistema = ".$CodSistema;
				$Actualizar = $Actualizar." and cod_pantalla = ".$CodPantalla;
				$Actualizar = $Actualizar." and nivel = ".$NivelAux1;
				mysqli_query($link, $Actualizar);	
				header("location:seg_pagina.php?CodSistema=".$CodSistema."&CodPantalla=".$CodPantalla."&NivelSistema=".$NivelSistema."&NivelMenu=".$Nivelmenu."&PantAgrup=".$PantAgrup);
			}
			else
			{
				if ($NivelSistema == "S")
					$NivelAux1 = 0;
				else 	$NivelAux1 = $NivelSistema;
				if ($NivelMenu == "S")
					$NivelAux2 = 0;
				else 	$NivelAux2 = $NivelMenu;
				if ($PantAgrup == "S")
					$NivelAux3 = 0;
				else 	$NivelAux3 = $PantAgrup;
				$Insertar = "insert into proyecto_modernizacion.acceso_menu (cod_sistema, cod_pantalla, nivel, nivel_agrup, cod_pant_agrup)";
				$Insertar.= " values (".$CodSistema.", ".$CodPantalla.", ".$NivelAux1.", ".$NivelAux2.", ".$NivelAux3.")";
				mysqli_query($link, $Insertar);
				header("location:seg_pagina.php?CodSistema=".$CodSistema."&CodPantalla=".$CodPantalla);	
			}
			break;	
		case "ELI_SEG":
			$Eliminar = "delete from proyecto_modernizacion.acceso_menu where cod_sistema = ".$CodSistema." and cod_pantalla = ".$CodPantalla." and nivel = ".$NivelElim;
			mysqli_query($link, $Eliminar);
			header("location:seg_pagina.php?CodSistema=".$CodSistema."&CodPantalla=".$CodPantalla);
			break;
		case "S":
			header("location:sistemas_usuario.php?CodSistema=99");
			break;
	}	
?>