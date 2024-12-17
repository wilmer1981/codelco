<?php
	include("../principal/conectar_principal.php");
	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Corr     = isset($_REQUEST["Corr"])?$_REQUEST["Corr"]:"";
	$Estado   = isset($_REQUEST["Estado"])?$_REQUEST["Estado"]:"";
	$PesoMuestra  = isset($_REQUEST["PesoMuestra"])?$_REQUEST["PesoMuestra"]:"";
	$SA       = isset($_REQUEST["SA"])?$_REQUEST["SA"]:"";
	$Recargo  = isset($_REQUEST["Recargo"])?$_REQUEST["Recargo"]:"";
	$DescPlantilla = isset($_REQUEST["DescPlantilla"])?$_REQUEST["DescPlantilla"]:"";
	$GeneraCorr = isset($_REQUEST["GeneraCorr"])?$_REQUEST["GeneraCorr"]:"";
	$Producto   = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";	
	
	switch ($Proceso)
	{
		case "G":	//GUARDA MALLA
			$Datos = explode("~~",$Valores);
			foreach($Datos as $k => $v)
			{
				$Datos2 = explode("///",$v);				
				$AuxId = $Datos2[0];
				$AuxSigno = str_replace("MAS","+",$Datos2[1]);
				$AuxSigno = str_replace("MENOS","-",$AuxSigno);
				$AuxMalla = str_replace("MAS","+",$Datos2[2]);
				$AuxMalla = str_replace("'"," ",$AuxMalla);
				$AuxUnidad = $Datos2[3];
				$AuxPeso = str_replace(",",".",$Datos2[4]);
				if ($AuxMalla != "")
				{
					$Consulta = "select * from cal_web.granulometria ";
					$Consulta.= " where nro_solicitud = '".$SA."' ";
					$Consulta.= " and recargo = '".$Recargo."' ";
					$Consulta.= " and corr = '".$AuxId."' ";
					$Consulta.= " order by corr";	
					$Respuesta = mysqli_query($link,$Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))
					{
						$Actualizar =  "UPDATE cal_web.granulometria SET ";
						$Actualizar.= " `signo` = '".$AuxSigno."' , ";
						$Actualizar.= " `malla` = '".$AuxMalla."' , ";
						$Actualizar.= " `cod_unidad` = '".$AuxUnidad."', ";
						$Actualizar.= " `peso` = '".$AuxPeso."', ";
						$Actualizar.= " `peso_muestra` = '".$PesoMuestra."', ";
						$Actualizar.= " `cod_estado` = '".$Estado."' ";
						$Actualizar.= " where nro_solicitud = '".$SA."' and recargo = '".$Recargo."' and corr = '".$AuxId."'";
						mysqli_query($link,$Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO cal_web.granulometria (`nro_solicitud`, `recargo`, `corr`, `signo`, `malla`, `cod_unidad`, `peso`, `peso_muestra`, `cod_estado`) ";
						$Insertar.= " VALUES ('".$SA."', '".$Recargo."', '".$AuxId."', '".$AuxSigno."', '".$AuxMalla."', '".$AuxUnidad."','".$AuxPeso."', '".$PesoMuestra."', '".$Estado."')";
						mysqli_query($link,$Insertar);
					}
					
				}				
			}
			header("location:cal_ing_granulometria.php?SA=".$SA."&Recargo=".$Recargo);
			break;
		case "E": //ELIMINA MALLA
			$Datos = explode("~~",$Valores);
			foreach($Datos as $k => $v)
			{											
				$Eliminar = "delete from cal_web.granulometria ";
				$Eliminar.= " where nro_solicitud = '".$SA."' ";
				$Eliminar.= " and recargo = '".$Recargo."' ";
				$Eliminar.= " and corr = '".$v."' ";
				mysqli_query($link,$Eliminar);					
			}
			header("location:cal_ing_granulometria.php?SA=".$SA."&Recargo=".$Recargo);
			break;
		case "GP": //GUARDA PLANTILLA
			if ($GeneraCorr == "S")		
			{
				$Consulta = "select ifnull(max(corr),0) as ultimo from cal_web.plantilla_granulometria ";
				$Respuesta = mysqli_query($link,$Consulta);
				if ($Fila = mysqli_fetch_array($Respuesta))
					$Corr = $Fila["ultimo"] + 1;
				else
					$Corr = 1;
			}
			$Consulta = "select * from cal_web.plantilla_granulometria ";
			$Consulta.= " where corr = '".$Corr."' ";
			$Respuesta = mysqli_query($link,$Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar =  "UPDATE cal_web.plantilla_granulometria SET ";
				$Actualizar.= " `cod_producto` = '".$Producto."' , ";
				$Actualizar.= " `cod_subproducto` = '".$SubProducto."' , ";
				$Actualizar.= " `descripcion` = '".$DescPlantilla."', ";
				$Actualizar.= " `malla` = '".$Valores."' ";
				$Actualizar.= " where corr = '".$Fila["corr"]."'";
				mysqli_query($Actualizar);
			}
			else
			{
				$Insertar = "INSERT INTO cal_web.plantilla_granulometria (`corr`, `cod_producto`, `cod_subproducto`, `descripcion`, `malla`) ";
				$Insertar.= " VALUES ('".$Corr."', '".$Producto."', '".$SubProducto."', '".$DescPlantilla."', '".$Valores."')";
				mysqli_query($link,$Insertar);
			}
			header("location:cal_ing_granulometria.php?SA=".$SA."&Recargo=".$Recargo);
			break;
		case "CP":	// CARGA PLANTILLA
			//Valores
			$Consulta = "select * from cal_web.plantilla_granulometria ";
			$Consulta.= " where corr = '".$Corr."'";
			$Respuesta = mysqli_query($link,$Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
				$Valores = $Fila["malla"];
			else
				$Valores = ""; 
			//Corr
			$Consulta = "select ifnull(max(corr),0) as ultimo from cal_web.granulometria ";
			$Consulta.= " where corr <> 'F' and nro_solicitud = '".$SA."' and recargo = '".$Recargo."'";
			$Respuesta = mysqli_query($link,$Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
				$AuxId = $Fila["ultimo"] + 1;
			else
				$AuxId = 1; 		
			$Datos = explode("~~",$Valores);
			foreach($Datos as $k => $v)
			{
				$Datos2 = explode("///",$v);								
				$AuxSigno = str_replace("MAS","+",$Datos2[0]);
				$AuxSigno = str_replace("MENOS","-",$AuxSigno);
				$AuxMalla = str_replace("MAS","+",$Datos2[1]);
				$AuxMalla = str_replace("'"," ",$AuxMalla);
				$AuxUnidad = $Datos2[2];
				$AuxPeso = 0;
				if ($AuxMalla != "")
				{
					$Consulta = "select * from cal_web.granulometria ";
					$Consulta.= " where nro_solicitud = '".$SA."' ";
					$Consulta.= " and recargo = '".$Recargo."' ";
					$Consulta.= " and corr = '".$AuxId."' ";
					$Consulta.= " order by corr";	
					$Respuesta = mysqli_query($link,$Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))
					{
						$Actualizar =  "UPDATE cal_web.granulometria SET ";
						$Actualizar.= " `signo` = '".$AuxSigno."' , ";
						$Actualizar.= " `malla` = '".$AuxMalla."' , ";
						$Actualizar.= " `cod_unidad` = '".$AuxUnidad."', ";
						$Actualizar.= " `peso` = '".$AuxPeso."', ";
						$Actualizar.= " `peso_muestra` = '".$PesoMuestra."', ";
						$Actualizar.= " `cod_estado` = '".$Estado."' ";
						$Actualizar.= " where nro_solicitud = '".$SA."' and recargo = '".$Recargo."' and corr = '".$AuxId."'";
						mysqli_query($link,$Actualizar);
					}
					else
					{
						$Insertar = "INSERT INTO cal_web.granulometria (`nro_solicitud`, `recargo`, `corr`, `signo`, `malla`, `cod_unidad`, `peso`, `peso_muestra`, `cod_estado`) ";
						$Insertar.= " VALUES ('".$SA."', '".$Recargo."', '".$AuxId."', '".$AuxSigno."', '".$AuxMalla."', '".$AuxUnidad."','".$AuxPeso."', '".$PesoMuestra."', '".$Estado."')";
						mysqli_query($link,$Insertar);
					}
					$AuxId++;
				}				
			}
			header("location:cal_ing_granulometria.php?SA=".$SA."&Recargo=".$Recargo);
			break;
		case "EP":	// ELIMINA PLANTILLA
			//Valores
			$Eliminar = "delete from cal_web.plantilla_granulometria ";
			$Eliminar.= " where corr = '".$Corr."'";
			mysqli_query($link,$Eliminar);				
			header("location:cal_ing_granulometria_carga_plantilla.php?Producto=".$Producto."&SubProducto=".$SubProducto);
			break;
	}
?>