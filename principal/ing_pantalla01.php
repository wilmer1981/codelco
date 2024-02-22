<?php
	include ("conectar_principal.php");

	if(isset($_GET["Proceso"])){
		$Proceso = $_GET["Proceso"];
	}else{
		$Proceso = "";
	}

	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}

    //VARIABLES POST 
	//if($Proceso=="G" || $Proceso=="M"){
		$Sistema     = $_REQUEST["Sistema"];
		$Descripcion = $_REQUEST["Descripcion"];
		$CodPantalla = $_REQUEST["CodPantalla"];
		$Link        = $_REQUEST["Link"];
		$TipoPag     = $_REQUEST["TipoPag"];
		$Orden       = $_REQUEST["Orden"];
		$EstPag      = $_REQUEST["EstPag"];
		$NivelSistema  = $_REQUEST["NivelSistema"];
		$NivelMenu     = $_REQUEST["NivelMenu"];
		$PantAgrup     = $_REQUEST["PantAgrup"];
		$CodSistema    = $_REQUEST["CodSistema"];
		$NivelElim     = $_REQUEST["NivelElim"];
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