<?php


$pagina->set_var("salir",$config['rootOrigen']);
//$_SESSION["CodSistemaSel"]=2;
	$pagina->set_block("plantilla_solicitud_analisis","PLANTILLA","bPLANTILLA");
		$Contador=0;
		$resp=$fx->obtenerPlantillas('','','','');
		while ($Fila=mysqli_fetch_assoc($resp)) {
			//$pagina->set_var("sistema", $Fila["cod_sistema"]);	
			//print_r($Fila);

			$idsinespacio=str_replace(" ","~", $Fila["id_muestra"]);

			// $idPlantilla=$Fila["cod_sistema"]."_".$Fila["id_muestra"]."_".$Fila["cod_producto"]."_".$Fila["cod_subproducto"]."_".str_replace(" ","~", $Fila["fecha_hora"]);

			$idPlantilla=$Fila["cod_sistema"]."_".$idsinespacio."_".$Fila["cod_producto"]."_".$Fila["cod_subproducto"]."_".str_replace(" ","~", $Fila["fecha_hora"]);
			$idPlantilla2=$_SESSION["CodSistemaSel"];

			$pagina->set_var("idPlantilla",$idPlantilla);
			$pagina->set_var("idPlantilla2",$idPlantilla2);

			$pagina->set_var("idMuestra", $Fila["id_muestra"]);	
			if ($resp2=$fx->obtenerSistema($Fila["cod_sistema"])) {
				$FilaSubProd=mysqli_fetch_assoc($resp2);
				$pagina->set_var("sistema",$FilaSubProd["nombre"]);
			}
			if ($resp1=$fx->obtenerProducto($Fila["cod_producto"])) {
				$FilaProd=mysqli_fetch_assoc($resp1);
				$pagina->set_var("producto",$FilaProd["descripcion"]);
			}
			if ($resp2=$fx->obtenerSubProducto($Fila["cod_producto"],$Fila["cod_subproducto"])) {
				$FilaSubProd=mysqli_fetch_assoc($resp2);
				$pagina->set_var("subProducto",$FilaSubProd["descripcion"]);
			}



			if ($resp3=$fx->obtenerTipoAnalisis($Fila["cod_analisis"])) {
				$FilaAnalisis=mysqli_fetch_assoc($resp3);
				$pagina->set_var("tipoAnalisis",$FilaAnalisis["nombre_subclase"]);
			}
			if ($resp4=$fx->obtenerMuestra($Fila["tipo"])) {
				$FilaTipoMuestra=mysqli_fetch_assoc($resp4);
				$pagina->set_var("tipoMuestra",$FilaTipoMuestra["nombre_subclase"]);
			}
			if ($resp5=$fx->obtenerPeriodo($Fila["cod_periodo"])) {
				$FilaTipoPeriodo=mysqli_fetch_assoc($resp5);
				$pagina->set_var("periodo",$FilaTipoPeriodo["nombre_subclase"]);
			}
			if ($resp6=$fx->obtenerAgrupacion($Fila["agrupacion"])) {
				$FilaAgrupacion=mysqli_fetch_assoc($resp6);
				$pagina->set_var("agrupacion",$FilaAgrupacion["nombre_subclase"]);
			}

			$Contador++;
			$pagina->parse("bPLANTILLA","PLANTILLA",true);
		};		 
		if ($Contador==0) {
				$pagina->set_var("bPLANTILLA",'');
		}
?>