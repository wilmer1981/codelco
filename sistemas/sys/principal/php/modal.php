<?php

switch($_GET["Opcion"])
{
	case 'aplicarLeyes':
		$cantidad=count($_POST);
		$cadLey='';
		$cadImp='';
		$cadLeyFis='';
	 	$resp=$fx->obtenerLeyes(''); 		 	 
		while($FilasLeyes=mysqli_fetch_assoc($resp)){		
			if ($_POST["ley".$FilasLeyes["cod_leyes"]]=='S') {
					$codigoLey=$FilasLeyes["cod_leyes"];
					$cadLey.=$codigoLey."~~".$_POST["unidades".$FilasLeyes["cod_leyes"]]."//";
					//echo "vamos los pibe"."<br>";
			}	
		}
		$resp=$fx->obtenerImpureza('');
		while($FilasLeyes=mysqli_fetch_assoc($resp)){
			if ($_POST["impure".$FilasLeyes["cod_leyes"]]=='S') {
					$codigoImp=$FilasLeyes["cod_leyes"];
					$cadImp.=$codigoImp."~~".$_POST["unidades".$FilasLeyes["cod_leyes"]]."//";
			}
		}

		$resp=$fx->obtenerLeyesFisicas('');
		while($FilasLeyes=mysqli_fetch_assoc($resp)){

			if ($_POST["impure".$FilasLeyes["cod_leyes"]]=='S') {

					$codigoLeyFis=$FilasLeyes["cod_leyes"];

					$cadLeyFis.=$codigoLeyFis."~~".$_POST["unidades".$FilasLeyes["cod_leyes"]]."//";
					//echo "vamos los pibe"."<br>";
			}
		}

		$cadImp=$cadImp.$cadLeyFis;
		


	//	echo $_SESSION["cadenaLeyes"];
		
		require_once("json_contructor.php");
		//echo "hasta Aqui bien";

		//$json["p"] = "formulario3";
		$json["sucess"] = true;
		$json["MuestraMensaje"] = false;
		$json["tipoRefresh"]='Refresco';
		
		
		$json["cadenaLeyes"]=$cadLey;
		$json["cadenaImpurezas"]=$cadImp;
		echo json_encode($json);	
		
		
		exit();
		break;
//boton ver Plantilla
	case 'obtenerSubProducto':
		//print_r( $_POST);
		$arraySubProducto=array (); 
		$respSubProducto=$fx->obtenerSubProducto($producto,'');
		$cont=0;
		while ($FilaSubProd=mysqli_fetch_assoc($respSubProducto)) {
			# code...
			$arraySubProducto[$cont]['id']=$FilaSubProd["cod_subproducto"];
			$arraySubProducto[$cont]['nombre']=$FilaSubProd["descripcion"];

			if ($_POST["idSubProducto"]==$FilaSubProd["cod_subproducto"])
				$arraySubProducto[$cont]['selected']="selected";
			else
				$arraySubProducto[$cont]['selected']="";
			
			$cont++;
		}
		$json["dato"]=$arraySubProducto;
		echo json_encode($json);
	exit();
		break;

	case 'newPlantilla':
		

		$pagina->set_var("guardarPlantilla",'guardarNewPlantilla');

		$cod_sistema=$_GET["Plantilla"];
		
		//echo $cod_sistema;

		$pagina->set_block('modal','NOMSISTEMA','bNOMSISTEMA');	
		$respCmb=$fx->obtenerSistema('');	 
		//$resp=$dataBaseMysql->consulta($Consulta);		 
		while($Fila0=mysqli_fetch_assoc($respCmb))
		{
		    $pagina->set_var("vSistema",$Fila0["cod_sistema"]);
			if ($Fila0["cod_sistema"]==$cod_sistema) {
			    	$pagina->set_var("cheSistema","selected");
			    }else{$pagina->set_var("cheSistema","");}    
		    //$pagina->set_var("cheCampamento","checked");
			$pagina->set_var("sigSistema",$Fila0["nombre"]);
			$pagina->set_var("nombSistema",$Fila0["descripcion"]);
			$pagina->parse("bNOMSISTEMA","NOMSISTEMA",true);
		}


		$pagina->set_var("idmuestra", '');	                     
        $pagina->set_var("descripcion", '');


        $pagina->set_block('modal','NOMCCOSTO','bNOMCCOSTO');	
	        $respCecos=$fx->obtenerCentroCosto('');
	        while($Fila1=mysqli_fetch_assoc($respCecos))
			{
			    $pagina->set_var("vcCosto",$Fila1["CENTRO_COSTO"]);
				if ($Fila1["CENTRO_COSTO"]==$Fila["cod_ccosto"]) {
				    	$pagina->set_var("checCosto","selected");
				    }else{$pagina->set_var("checCosto","");}    
			    //$pagina->set_var("cheCampamento","checked");
				//$pagina->set_var("sigSistema",$Fila1["nombre"]);
				$pagina->set_var("nombcCosto",$Fila1["DESCRIPCION"]);
				$pagina->parse("bNOMCCOSTO","NOMCCOSTO",true);
			}

		$pagina->set_block('modal','NOMAREA','bNOMAREA');	
	        $respArea=$fx->obtenerArea('');
	        while($Fila2=mysqli_fetch_assoc($respArea))
			{
			    $pagina->set_var("varea",$Fila2["COD_AREA"]);
				if ($Fila2["COD_AREA"]==$Fila["cod_area"]) {
				    	$pagina->set_var("chearea","selected");
				    }else{$pagina->set_var("chearea","");}    
			    //$pagina->set_var("cheCampamento","checked");
				//$pagina->set_var("sigSistema",$Fila2["nombre"]);
				$pagina->set_var("nombarea",$Fila2["AREA"]);
				$pagina->parse("bNOMAREA","NOMAREA",true);
			}


			$pagina->set_block('modal','NOMPRODUCTO','bNOMPRODUCTO');	
	        $respProducto=$fx->obtenerProducto('');
	        while($Fila3=mysqli_fetch_assoc($respProducto))
			{
			    $pagina->set_var("vProducto",$Fila3["cod_producto"]);
				if ($Fila3["cod_producto"]==$Fila["cod_producto"]) {
				    	$pagina->set_var("cheProducto","selected");
				    }else{$pagina->set_var("cheProducto","");}    
			    //$pagina->set_var("cheCampamento","checked");
				//$pagina->set_var("sigSistema",$Fila3["nombre"]);
				$pagina->set_var("nombProducto",$Fila3["descripcion"]);
				$pagina->parse("bNOMPRODUCTO","NOMPRODUCTO",true);
			}

			$pagina->set_block('modal','NOMSUBPRODUCTO','bNOMSUBPRODUCTO');	
	        $respSubProducto=$fx->obtenerSubProducto($Fila["cod_producto"],'');
	        while($Fila4=mysqli_fetch_assoc($respSubProducto))
			{
			    $pagina->set_var("vSubProducto",$Fila4["cod_producto"]);
				if ($Fila4["cod_producto"]==$Fila["cod_producto"]) {
				    	$pagina->set_var("cheSubProducto","selected");
				    }else{$pagina->set_var("cheSubProducto","");}    
			    //$pagina->set_var("cheCampamento","checked");
				//$pagina->set_var("sigSistema",$Fila4["nombre"]);
				$pagina->set_var("nombSubProducto",$Fila4["descripcion"]);
				$pagina->parse("bNOMSUBPRODUCTO","NOMSUBPRODUCTO",true);
			}	

			$pagina->set_block('modal','TIPOANALISIS','bTIPOANALISIS');	
	        $respTipoAnalisis=$fx->obtenerTipoAnalisis('');
	        while($Fila5=mysqli_fetch_assoc($respTipoAnalisis))
			{
			    $pagina->set_var("vTipoAnalisis",$Fila5["cod_subclase"]);
				if ($Fila5["cod_subclase"]==$Fila["cod_analisis"]) {
				    	$pagina->set_var("cheTipoAnalisis","selected");
				    }else{$pagina->set_var("cheTipoAnalisis","");}    
			    //$pagina->set_var("cheCampamento","checked");
				//$pagina->set_var("sigSistema",$Fila5["nombre"]);
				$pagina->set_var("nombTipoAnalisis",$Fila5["nombre_subclase"]);
				$pagina->parse("bTIPOANALISIS","TIPOANALISIS",true);
			}	

			$pagina->set_block('modal','TIPO','bTIPO');	
	        $respTipoMuestra=$fx->obtenerMuestra('');
	        while($Fila6=mysqli_fetch_assoc($respTipoMuestra))
			{
			    $pagina->set_var("vTipo",$Fila6["cod_subclase"]);
				if ($Fila6["cod_subclase"]==$Fila["tipo"]) {
				    	$pagina->set_var("cheTipo","selected");
				    }else{$pagina->set_var("cheTipo","");}    
				$pagina->set_var("nombTipo",$Fila6["nombre_subclase"]);
				$pagina->parse("bTIPO","TIPO",true);
			}	

			$pagina->set_var("leyes", $Fila["leyes"]);
	        $pagina->set_var("impurezas", $Fila["impurezas"]);

	        $pagina->set_block('modal','TIPOAGRUPACION','bTIPOAGRUPACION');	
	        $respAgrupacion=$fx->obtenerAgrupacion('');
	        while($Fila7=mysqli_fetch_assoc($respAgrupacion))
			{
			    $pagina->set_var("vAgrupacion",$Fila7["cod_subclase"]);
				if ($Fila7["cod_subclase"]==$Fila["agrupacion"]) {
				    	$pagina->set_var("cheAgrupacion","selected");
				    }else{$pagina->set_var("cheAgrupacion","");}    
			    //$pagina->set_var("cheCampamento","checked");
				//$pagina->set_var("sigSistema",$Fila7["nombre"]);
				$pagina->set_var("nombAgrupacion",$Fila7["nombre_subclase"]);
				$pagina->parse("bTIPOAGRUPACION","TIPOAGRUPACION",true);
			}


			$pagina->set_block('modal','TIPOPERIODO','bTIPOPERIODO');	
	        $respPeriodo=$fx->obtenerPeriodo('');
	        while($Fila8=mysqli_fetch_assoc($respPeriodo))
			{
			    $pagina->set_var("vPeriodo",$Fila8["cod_subclase"]);
				if ($Fila8["cod_subclase"]==$Fila["cod_periodo"]) {
				    	$pagina->set_var("chePeriodo","selected");
				    }else{$pagina->set_var("chePeriodo","");}    
			    //$pagina->set_var("cheCampamento","checked");
				//$pagina->set_var("sigSistema",$Fila8["nombre"]);
				$pagina->set_var("nombPeriodo",$Fila8["nombre_subclase"]);
				$pagina->parse("bTIPOPERIODO","TIPOPERIODO",true);
			}

			
			//LEYES 
		$cadenaLeyes=explode('//', $Fila["leyes"]);
		$cantidadLeyes=count($cadenaLeyes);	
		//print_r($cadenaLeyes);
		for ($i=0; $i < count($cadenaLeyes); $i++) { 
			if ($cadenaLeyes[$i]!='') {
				$leyesUnidad[$i]=explode('~~', $cadenaLeyes[$i]);
			}
		}
		$cantidadLeyesPorUnidad=count($leyesUnidad);
		
		//IMPUREZAS
		$cadenaImpurezas=explode('//', $Fila["impurezas"]);
		$cantidadImpurezas=count($cadenaImpurezas);	
		
		for ($i=0; $i < count($cadenaImpurezas); $i++) { 
			if ($cadenaImpurezas[$i]!='') {
				$impurezaUnidad[$i]=explode('~~', $cadenaImpurezas[$i]);
			}
			
		}
		$cantidadImpurezasPorUnidad=count($impurezaUnidad);

		$pagina->set_block('modal','UNIDAD','bUNIDAD');	
		$respUni=$fx->obtenerUnidades('');	 	 
		while($FilasUnidad=mysqli_fetch_assoc($respUni))
		{
		    $pagina->set_var("ValueUnidad",$FilasUnidad["cod_unidad"]);
			$pagina->set_var("nombUnidad",$FilasUnidad["abreviatura"]);  
			$pagina->parse("bUNIDAD","UNIDAD",true);
		}

		$pagina->set_block('modal','LISTLEYES','bLISTLEYES');	
		$resp=$fx->obtenerLeyes('');	 	 
		while($FilasLeyes=mysqli_fetch_assoc($resp))
		{
		    $pagina->set_var("idLey",$FilasLeyes["cod_leyes"]);



			$pagina->set_var("nombreLey",$FilasLeyes["abreviaturaLey"]);  
			$pagina->parse("bLISTLEYES","LISTLEYES",true);
		}





		$pagina->set_block('modal','IMPUREZAS','bIMPUREZAS');	
		$resp2=$fx->obtenerImpureza('');	  
		while($FilasLeyes2=mysqli_fetch_assoc($resp2))
		{
		    $pagina->set_var("idImpure",$FilasLeyes2["cod_leyes"]);
			$pagina->set_var("nombreImpure",$FilasLeyes2["abreviaturaLey"]);  
			$pagina->parse("bIMPUREZAS","IMPUREZAS",true);
		}





		$pagina->set_block('modal','LEYFIS','bLEYFIS');	
		$resp3=$fx->obtenerLeyesFisicas('');	 
		while($FilasLeyes3=mysqli_fetch_assoc($resp3))
		{
		    $pagina->set_var("idLeyFis",$FilasLeyes3["cod_leyes"]);
			$pagina->set_var("nombreLeyFis",$FilasLeyes3["abreviaturaLey"]);  	
			$pagina->parse("bLEYFIS","LEYFIS",true);
		}

   		
	break;
	case 'verPlantilla':
		
		//echo $_GET["Plantilla"];



		$separaPlantilla=explode('_', $_GET["Plantilla"]);

		$cod_sistema=$separaPlantilla[0];
		$id_muestra=$separaPlantilla[1];

		$id_muestra=str_replace("~", " ", $id_muestra);
		$cod_producto=$separaPlantilla[2];
		$cod_subproducto=$separaPlantilla[3];
		$fechaHora=$separaPlantilla[4];
		$fechaHora=str_replace("~", " ", $fechaHora);


		$resp=$fx->obtenerPlantillas($cod_sistema,$cod_producto,$cod_subproducto,$id_muestra);
		if ($Fila=mysqli_fetch_assoc($resp)) {


			
			if ($resp2=$fx->obtenerSistema($cod_sistema)) {
				$FilaSubProd=mysqli_fetch_assoc($resp2);
				$pagina->set_var("sistema",$FilaSubProd["descripcion"]);
			}

			$pagina->set_var("idmuestra", $Fila["id_muestra"]);	                     
	        $pagina->set_var("descripcion", $Fila["descripcion"]);
	        
	        $respCecos=$fx->obtenerCentroCosto($Fila["cod_ccosto"]);
				if ($FilaCecos=mysqli_fetch_assoc($respCecos)	) {
					$pagina->set_var("cCosto", $FilaCecos["DESCRIPCION"] );
				}else
				$pagina->set_var("cCosto", "");
			$respArea=$fx->obtenerArea($Fila["cod_area"]);
				if ($FilaArea=mysqli_fetch_assoc($respArea)) {
				$pagina->set_var("area", $FilaArea["AREA"] );
				}else
				$pagina->set_var("area", "");
			$respProducto=$fx->obtenerProducto($Fila["cod_producto"]);
				if ($FilaProducto=mysqli_fetch_assoc($respProducto)) {
				$pagina->set_var("producto", $FilaProducto["descripcion"] );
				}else
				$pagina->set_var("producto", "");
			$respSubProducto=$fx->obtenerSubProducto($Fila["cod_producto"],$Fila["cod_subproducto"]);
				if ($FilaSubProducto=mysqli_fetch_assoc($respSubProducto)) {
				$pagina->set_var("subProducto", $FilaSubProducto["descripcion"] );
				}else
				$pagina->set_var("subProducto", "");	
			$respTipoAnalisis=$fx->obtenerTipoAnalisis($Fila["cod_analisis"]);
				if ($FilaTipoAnalisis=mysqli_fetch_assoc($respTipoAnalisis)) {
				$pagina->set_var("tipoAnalis", $FilaTipoAnalisis["nombre_subclase"] );
				}else
				$pagina->set_var("tipoAnalis", "");	
	        //$pagina->set_var("tipoAnalis", $Fila["cod_analisis"]);
			
			/*$respTipoMuestra=$fx->obtenerMuestra($Fila["cod_tipo_muestra"]);
				if ($FilaTipoMuestra=mysqli_fetch_assoc($respTipoMuestra)) {
				$pagina->set_var("tipoMuestra", $FilaTipoMuestra["nombre_subclase"] );
				}else
				$pagina->set_var("tipoMuestra", "");		*/	        

				switch (  $Fila["cod_tipo_muestra"])  {
			 	case '1':
			 		$pagina->set_var("tipoMuestra","An&aacute;lisis");
			 		break;
			 	case '2':
			 		$pagina->set_var("tipoMuestra","Muestreo");
			 		break;
		 		case '3':
		 			$pagina->set_var("tipoMuestra","An&aacutelisis y Muestreo");
		 		break;
			 	default:
			 		$pagina->set_var("tipoMuestra","Sin Asignar");
		 		break;
			 } 






			$respTipo=$fx->obtenerTipo($Fila["tipo"]);
				if ($FilaTipo=mysqli_fetch_assoc($respTipo)) {
				$pagina->set_var("tipo", $FilaTipo["nombre_subclase"] );
				}else
				$pagina->set_var("tipo", "");	

			 
				$pagina->set_var("leyes", $Fila["leyes"]);

 
				 $pagina->set_var("impurezas", $Fila["impurezas"]);

	        $respAgrupacion=$fx->obtenerAgrupacion($Fila["agrupacion"]);
				if ($FilaAgrupacion=mysqli_fetch_assoc($respAgrupacion)) {
				$pagina->set_var("agrupacion", $FilaAgrupacion["nombre_subclase"] );
				}else
				$pagina->set_var("agrupacion", "");
	        $pagina->set_var("fecha", $Fila["fecha_hora"]);

	        $respPeriodo=$fx->obtenerPeriodo($Fila["cod_periodo"]);
				if ($FilaPeriodo=mysqli_fetch_assoc($respPeriodo)) {
				$pagina->set_var("periodo", $FilaPeriodo["nombre_subclase"] );
				}else
				$pagina->set_var("periodo", "");

   		}
	break;


//boton editar Plantilla
	case 'savePlantilla':
		
			//$pagina->set_var('plantilla',$_GET["Plantilla"]);

		//echo $_GET["Plantilla"];
		$pagina->set_var("guardarPlantilla", 'guardarPlantilla');

		$separaPlantilla=explode('_', $_GET["Plantilla"]);


		$cod_sistema=$separaPlantilla[0];
		$id_muestra=$separaPlantilla[1];

		$id_muestra=str_replace("~", " ", $id_muestra);

		$cod_producto=$separaPlantilla[2];
		$cod_subproducto=$separaPlantilla[3];
		$fechaHora=$separaPlantilla[4];
		$fechaHora=str_replace("~", " ", $fechaHora);

		$pagina->set_var("idProducto", $cod_producto);
		$pagina->set_var("idSubProducto",$cod_subproducto );
		$pagina->set_var("idmuestraOri",$id_muestra );
		$pagina->set_var("fechaOri",$fechaHora );
		


		$pagina->set_block('modal','NOMSISTEMA','bNOMSISTEMA');	
		$respCmb=$fx->obtenerSistema('');	 
		//$resp=$dataBaseMysql->consulta($Consulta);		 
		while($Fila0=mysqli_fetch_assoc($respCmb))
		{
		    $pagina->set_var("vSistema",$Fila0["cod_sistema"]);
			if ($Fila0["cod_sistema"]==$cod_sistema) {
			    	$pagina->set_var("cheSistema","selected");
			    }else{$pagina->set_var("cheSistema","");}    
		    //$pagina->set_var("cheCampamento","checked");
			$pagina->set_var("sigSistema",$Fila0["nombre"]);
			$pagina->set_var("nombSistema",$Fila0["descripcion"]);
			$pagina->parse("bNOMSISTEMA","NOMSISTEMA",true);
		}


		$resp=$fx->obtenerPlantillas($cod_sistema,$cod_producto,$cod_subproducto,$id_muestra);
		if ($Fila=mysqli_fetch_assoc($resp)) {
		
			if ($resp2=$fx->obtenerSistema($Fila["cod_sistema"])) {
				$FilaSubProd=mysqli_fetch_assoc($resp2);
				$pagina->set_var("sistema",$FilaSubProd["nombre"]);
			}

			switch (  $Fila["cod_tipo_muestra"])  {
			 	case '1':
			 		$pagina->set_var("cheTipoMuestra1","selected");
			 		$pagina->set_var("cheTipoMuestra2","");
			 		$pagina->set_var("cheTipoMuestra3","");
			 		$pagina->set_var("tipoMuestra","Análisis");
			 		break;
			 	case '2':
			 		$pagina->set_var("cheTipoMuestra1","");
			 		$pagina->set_var("cheTipoMuestra2","selected");
			 		$pagina->set_var("cheTipoMuestra3","");
			 		
			 		$pagina->set_var("tipoMuestra","Muestreo");
			 		break;
		 		case '3':
		 			$pagina->set_var("cheTipoMuestra1","");
			 		$pagina->set_var("cheTipoMuestra2","");
		 			$pagina->set_var("cheTipoMuestra3","selected");
		 			$pagina->set_var("tipoMuestra","Análisis y Muestreo");
		 		break;
			 	default:

			 		$pagina->set_var("cheTipoMuestra1","");
			 		$pagina->set_var("cheTipoMuestra2","");
		 			$pagina->set_var("cheTipoMuestra3","selected");# code...
		 		break;
			 } 


			$pagina->set_var("idmuestra", $Fila["id_muestra"]);	                     
	        $pagina->set_var("descripcion", $Fila["descripcion"]);
	        
	        $pagina->set_block('modal','NOMCCOSTO','bNOMCCOSTO');	
	        $respCecos=$fx->obtenerCentroCosto('');
	        while($Fila1=mysqli_fetch_assoc($respCecos))
			{
			    $pagina->set_var("vcCosto",$Fila1["CENTRO_COSTO"]);
				if ($Fila1["CENTRO_COSTO"]==$Fila["cod_ccosto"]) {
				    	$pagina->set_var("checCosto","selected");
				    }else{$pagina->set_var("checCosto","");}    
			    //$pagina->set_var("cheCampamento","checked");
				//$pagina->set_var("sigSistema",$Fila1["nombre"]);
				$pagina->set_var("nombcCosto",$Fila1["DESCRIPCION"]);
				$pagina->parse("bNOMCCOSTO","NOMCCOSTO",true);
			}
			/*
	        $respCecos=$fx->obtenerCentroCosto($Fila["cod_ccosto"]);
				if ($FilaCecos=mysqli_fetch_assoc($respCecos)	) {
					$pagina->set_var("cCosto", $FilaCecos["DESCRIPCION"] );
				}else
				$pagina->set_var("cCosto", "");
			*/

			$pagina->set_block('modal','NOMAREA','bNOMAREA');	
	        $respArea=$fx->obtenerArea('');
	        while($Fila2=mysqli_fetch_assoc($respArea))
			{
			    $pagina->set_var("varea",$Fila2["COD_AREA"]);
				if ($Fila2["COD_AREA"]==$Fila["cod_area"]) {
				    	$pagina->set_var("chearea","selected");
				    }else{$pagina->set_var("chearea","");}    
			    //$pagina->set_var("cheCampamento","checked");
				//$pagina->set_var("sigSistema",$Fila2["nombre"]);
				$pagina->set_var("nombarea",$Fila2["AREA"]);
				$pagina->parse("bNOMAREA","NOMAREA",true);
			}	

			$pagina->set_block('modal','NOMPRODUCTO','bNOMPRODUCTO');	
	        $respProducto=$fx->obtenerProducto('');
	        while($Fila3=mysqli_fetch_assoc($respProducto))
			{
			    $pagina->set_var("vProducto",$Fila3["cod_producto"]);
				if ($Fila3["cod_producto"]==$Fila["cod_producto"]) {
				    	$pagina->set_var("cheProducto","selected");
				    }else{$pagina->set_var("cheProducto","");}    
			    //$pagina->set_var("cheCampamento","checked");
				//$pagina->set_var("sigSistema",$Fila3["nombre"]);
				$pagina->set_var("nombProducto",$Fila3["descripcion"]);
				$pagina->parse("bNOMPRODUCTO","NOMPRODUCTO",true);
			}			

			$pagina->set_block('modal','NOMSUBPRODUCTO','bNOMSUBPRODUCTO');	
	        $respSubProducto=$fx->obtenerSubProducto($Fila["cod_producto"],'');
	        while($Fila4=mysqli_fetch_assoc($respSubProducto))
			{
			    $pagina->set_var("vSubProducto",$Fila4["cod_producto"]);
				if ($Fila4["cod_producto"]==$Fila["cod_producto"]) {
				    	$pagina->set_var("cheSubProducto","selected");
				    }else{$pagina->set_var("cheSubProducto","");}    
			    //$pagina->set_var("cheCampamento","checked");
				//$pagina->set_var("sigSistema",$Fila4["nombre"]);
				$pagina->set_var("nombSubProducto",$Fila4["descripcion"]);
				$pagina->parse("bNOMSUBPRODUCTO","NOMSUBPRODUCTO",true);
			}	

/*

			$respSubProducto=$fx->obtenerSubProducto($Fila["cod_producto"],$Fila["cod_subproducto"]);
				if ($FilaSubProducto=mysqli_fetch_assoc($respSubProducto)) {
				$pagina->set_var("subProducto", $FilaSubProducto["descripcion"] );

				}else
				$pagina->set_var("subProducto", "");*/

			$pagina->set_block('modal','TIPOANALISIS','bTIPOANALISIS');	
	        $respTipoAnalisis=$fx->obtenerTipoAnalisis('');
	        while($Fila5=mysqli_fetch_assoc($respTipoAnalisis))
			{
			    $pagina->set_var("vTipoAnalisis",$Fila5["cod_subclase"]);
				if ($Fila5["cod_subclase"]==$Fila["cod_analisis"]) {
				    	$pagina->set_var("cheTipoAnalisis","selected");
				    }else{$pagina->set_var("cheTipoAnalisis","");}    
				$pagina->set_var("nombTipoAnalisis",$Fila5["nombre_subclase"]);
				$pagina->parse("bTIPOANALISIS","TIPOANALISIS",true);
			}	
				
			$pagina->set_block('modal','TIPO','bTIPO');	
	        $respTipoMuestra=$fx->obtenerMuestra('');
	        while($Fila6=mysqli_fetch_assoc($respTipoMuestra))
			{
			    $pagina->set_var("vTipo",$Fila6["cod_subclase"]);
				if ($Fila6["cod_subclase"]==$Fila["tipo"]) {
				    	$pagina->set_var("cheTipo","selected");
				    }else{$pagina->set_var("cheTipo","");}    
				$pagina->set_var("nombTipo",$Fila6["nombre_subclase"]);
				$pagina->parse("bTIPO","TIPO",true);
			}	

	        $pagina->set_var("leyes", $Fila["leyes"]);
	        $pagina->set_var("impurezas", $Fila["impurezas"]);

	        $pagina->set_block('modal','TIPOAGRUPACION','bTIPOAGRUPACION');	
	        $respAgrupacion=$fx->obtenerAgrupacion('');
	        while($Fila7=mysqli_fetch_assoc($respAgrupacion))
			{
			    $pagina->set_var("vAgrupacion",$Fila7["cod_subclase"]);
				if ($Fila7["cod_subclase"]==$Fila["agrupacion"]) {
				    	$pagina->set_var("cheAgrupacion","selected");
				    }else{$pagina->set_var("cheAgrupacion","");}    
				$pagina->set_var("nombAgrupacion",$Fila7["nombre_subclase"]);
				$pagina->parse("bTIPOAGRUPACION","TIPOAGRUPACION",true);
			}

			$pagina->set_block('modal','TIPOPERIODO','bTIPOPERIODO');	
	        $respPeriodo=$fx->obtenerPeriodo('');
	        while($Fila8=mysqli_fetch_assoc($respPeriodo))
			{
			    $pagina->set_var("vPeriodo",$Fila8["cod_subclase"]);
				if ($Fila8["cod_subclase"]==$Fila["cod_periodo"]) {
				    	$pagina->set_var("chePeriodo","selected");
				    }else{$pagina->set_var("chePeriodo","");}    

				$pagina->set_var("nombPeriodo",$Fila8["nombre_subclase"]);
				$pagina->parse("bTIPOPERIODO","TIPOPERIODO",true);
			}
   		}

 		$pagina->set_block('modal','UNIDAD','bUNIDAD');	
		$respUni=$fx->obtenerUnidades('');	 	 
		while($FilasUnidad=mysqli_fetch_assoc($respUni))
		{
		    $pagina->set_var("ValueUnidad",$FilasUnidad["cod_unidad"]);
			$pagina->set_var("nombUnidad",$FilasUnidad["abreviatura"]);  
			$pagina->parse("bUNIDAD","UNIDAD",true);
		}

		

		//04~~4
		//05~~4
		//02~~1

		//04
		//4

		//05
		//4

		//02
		//1

		//LEYES 
		$cadenaLeyes=explode('//', $Fila["leyes"]);
		$cantidadLeyes=count($cadenaLeyes);	
		//print_r($cadenaLeyes);
		for ($i=0; $i < count($cadenaLeyes); $i++) { 
			if ($cadenaLeyes[$i]!='') {
				$leyesUnidad[$i]=explode('~~', $cadenaLeyes[$i]);
			}
			//print_r($leyesUnidad[$i]);
		}
		$cantidadLeyesPorUnidad=count($leyesUnidad);
		
		//IMPUREZAS
		$cadenaImpurezas=explode('//', $Fila["impurezas"]);
		$cantidadImpurezas=count($cadenaImpurezas);	
		//print_r($cadenaImpurezas);
		for ($i=0; $i < count($cadenaImpurezas); $i++) { 
			if ($cadenaImpurezas[$i]!='') {
				$impurezaUnidad[$i]=explode('~~', $cadenaImpurezas[$i]);
			}
			//print_r($impurezaUnidad[$i]);
		}
		$cantidadImpurezasPorUnidad=count($impurezaUnidad);


		$pagina->set_block('modal','LISTLEYES','bLISTLEYES');	
		$resp=$fx->obtenerLeyes('');	 	 
		while($FilasLeyes=mysqli_fetch_assoc($resp))
		{
			$pagina->set_var("VISUALIZACOMBOLEYES","none");
		    $pagina->set_var("idLey",$FilasLeyes["cod_leyes"]);
		    
		    for ($i=0; $i < count($cadenaLeyes)-1; $i++) { 
				if ($leyesUnidad[$i][0]==$FilasLeyes["cod_leyes"]) 
				{
					$pagina->set_var("VISUALIZACOMBOLEYES","block");
			    	$pagina->set_var("checked".$FilasLeyes["cod_leyes"],"checked");
			    }
			    else
			    	$pagina->set_var("checked","");

				$pagina->set_var("selectedunidadLeyes".$leyesUnidad[$i][0]."~~".$leyesUnidad[$i][1],"selected");
			}
			    


			$pagina->set_var("nombreLey",$FilasLeyes["abreviaturaLey"]);  
			$pagina->parse("bLISTLEYES","LISTLEYES",true);
		}





		$pagina->set_block('modal','IMPUREZAS','bIMPUREZAS');	
		$resp2=$fx->obtenerImpureza('');	  
		while($FilasLeyes2=mysqli_fetch_assoc($resp2))
		{
			$pagina->set_var("VISUALIZACOMBOIMPURE","none");
		    $pagina->set_var("idImpure",$FilasLeyes2["cod_leyes"]);
		    for ($i=0; $i < count($cadenaImpurezas)-1; $i++) { 
				if ($impurezaUnidad[$i][0]==$FilasLeyes2["cod_leyes"]) {
					$pagina->set_var("VISUALIZACOMBOIMPURE","block");
			    	 $pagina->set_var("checked".$FilasLeyes2["cod_leyes"],"checked");
			    }else
			    	$pagina->set_var("checked","");
		    	$pagina->set_var("selectedunidadImpure".$impurezaUnidad[$i][0]."~~".$impurezaUnidad[$i][1],"selected");
			}
			$pagina->set_var("nombreImpure",$FilasLeyes2["abreviaturaLey"]);  
			$pagina->parse("bIMPUREZAS","IMPUREZAS",true);
		}
		$pagina->set_block('modal','LEYFIS','bLEYFIS');	
		$resp3=$fx->obtenerLeyesFisicas('');	 
		while($FilasLeyes3=mysqli_fetch_assoc($resp3))
		{
			$pagina->set_var("VISUALIZACOMBOIMPUREDOS","none");
		    $pagina->set_var("idLeyFis",$FilasLeyes3["cod_leyes"]);
		    for ($i=0; $i < count($cadenaImpurezas)-1; $i++) { 
				if ($impurezaUnidad[$i][0]==$FilasLeyes3["cod_leyes"]) {
					$pagina->set_var("VISUALIZACOMBOIMPUREDOS","block");
			    	 $pagina->set_var("checked".$FilasLeyes3["cod_leyes"],"checked");
			    }else
			    	$pagina->set_var("checked","");
				$pagina->set_var("selectedunidadImpureDos".$impurezaUnidad[$i][0]."~~".$impurezaUnidad[$i][1],"selected");
			}
			$pagina->set_var("nombreLeyFis",$FilasLeyes3["abreviaturaLey"]);  	
			$pagina->parse("bLEYFIS","LEYFIS",true);
		}	  		
	break;

	case 'guardarPlantilla':

	//print_r($_POST);

		require_once("json_contructor.php");

				$resp=$fx->obtenerPlantillas($_POST["sistema"],$_POST["idProducto"],$_POST["idSubProducto"],$_POST["idmuestraOri"]);	
				if($Fila=mysqli_fetch_assoc($resp))
				{
					$Query="update cal_web.plantilla_solicitud_analisis set id_muestra='".$_POST["idmuestra"]."', fecha_hora='".date("Y-m-d G:i:s")."',descripcion='".$_POST["descripcion"]."', cod_ccosto='".$_POST["cCosto"]."', cod_area='".$_POST["area"]."', cod_producto='".$_POST["producto"]."', cod_subproducto='".$_POST["cmbsubProducto"]."', cod_analisis='".$_POST["tipoAnalis"]."',tipo='".$_POST["tipo"]."', cod_tipo_muestra='".$_POST["tipoMuestra"]."', agrupacion='".$_POST["agrupacion"]."', leyes='".$_POST["leyesSave"]."', impurezas='".$_POST["impurezasSave"]."' where fecha_hora = '".$_POST["fechaOri"]."' AND cod_producto='".$_POST["idProducto"]."' AND cod_subproducto='".$_POST["idSubProducto"]."' AND id_muestra = '".$_POST["idmuestraOri"]."' AND cod_sistema='".$_POST["sistema"]."' AND cod_periodo='".$_POST["periodo"]."'";
				}
				//echo $Query;
				if($dataBaseMysql->QueryAction($Query)=='')
				{

					$json["sucess"] = true;
					$json["p"] = "formulario3";
					$json["mensaje"] = "Plantilla Modificada con exito";
				}
				else
				{
					$json["sucess"] = false;
					$json["mensaje"] = mysql_error();
				}
		echo json_encode($json);	
		exit();
	break;
	case 'guardarNewPlantilla':
	//print_r($_POST);
		require_once("json_contructor.php");
				{
					$Query="insert into cal_web.plantilla_solicitud_analisis (id_muestra,fecha_hora,descripcion,cod_ccosto,cod_area,cod_producto,cod_subproducto,cod_analisis,cod_tipo_muestra,agrupacion,cod_sistema,cod_periodo,leyes,impurezas,tipo_solicitud,tipo) value ('".$_POST["idmuestra"]."', '".date("Y-m-d G:i:s")."','".$_POST["descripcion"]."', '".$_POST["cCosto"]."', '".$_POST["area"]."', '".$_POST["producto"]."', '".$_POST["cmbsubProducto"]."', '".$_POST["tipoAnalis"]."', '".$_POST["tipoMuestra"]."', '".$_POST["agrupacion"]."','".$_POST["sistema"]."','".$_POST["periodo"]."','".$_POST["leyesSave"]."','".$_POST["impurezasSave"]."','R','".$_POST["tipo"]."')";
				}
				//echo $Query;
				if($dataBaseMysql->QueryAction($Query)=='')
				{
					$json["sucess"] = true;
					$json["p"] = "formulario3";
					$json["mensaje"] = "Plantilla Agregada con exito";
				}
				else
				{
					$json["sucess"] = false;
					$json["mensaje"] = mysql_error();
				}
		echo json_encode($json);	
		exit();
	break;
	case 'editarSolicitud':
		
		$separaSolicitud=explode('_', $_GET["Solicitud"]);	
		$idMuestra=$separaSolicitud[0];

		$idPlantilla=explode('~', $idMuestra);

		$idMuestra=str_replace("+"," ", $idMuestra);

		$cod_Producto=$separaSolicitud[1];
		$cod_SubProducto=$separaSolicitud[2];
		$fechaHora=$separaSolicitud[3];

		$FechaHora=explode('~', $fechaHora);
		//$pagina->set_var("fecha", $FechaHora[0]);
		//$pagina->set_var("hora", $FechaHora[1]);
		$Fechita=$FechaHora[0]." ".$FechaHora[1];

		$resp=$fx->obtenerSolicitudAnalisis($cod_Producto,$cod_SubProducto, $idMuestra,$Fechita,$CookieRut);
		if($Fila=mysqli_fetch_assoc($resp)){
			//echo $Fila["fecha_muestra"];
			
			$FechaHorita=explode(' ', $Fila["fecha_muestra"]);
			$pagina->set_var("fecha", $FechaHorita[0]);
			$pagina->set_var("hora", $FechaHorita[1]);

		}

		



		$pagina->set_var("plantilla", $idPlantilla[0]."_".$cod_Producto."_".$cod_SubProducto);
		$fechaHora=str_replace("~", " ", $fechaHora);

		

		$pagina->set_var("idMuestra", $idMuestra);
		$pagina->set_var("idMuestraOri", $idMuestra);
		$pagina->set_var("cod_producto", $cod_Producto);
		$pagina->set_var("cod_subProducto", $cod_SubProducto); 
		$pagina->set_var("fechaOri", $fechaHora);

		break;
	case 'guardarSolicitud':
		//print_r($_POST);
		require_once("json_contructor.php");

				//echo $_POST["datetime1"];
				//echo $_POST["datetime2"];
				$FechaMasHora=$_POST["datetime1"]." ".$_POST["datetime2"];

				$resp=$fx->obtenerSolicitudAnalisis($_POST["cod_producto"],$_POST["cod_subProducto"],'',$_POST["fechaOri"],$CookieRut);	
				if($Fila=mysqli_fetch_assoc($resp))
				{
					$Query="update cal_web.solicitud_analisis set id_muestra='".$_POST["idMuestra"]."'
					, fecha_muestra='".$FechaMasHora."'
					 where fecha_hora = '".$_POST["fechaOri"]."' AND cod_producto='".$_POST["cod_producto"]."' AND cod_subproducto='".$_POST["cod_subProducto"]."' AND id_muestra = '".$_POST["idMuestraOri"]."'";
				}
				//echo $Query;
				if($dataBaseMysql->QueryAction($Query)=='')
				{

					$json["sucess"] = true;
					$json["p"] = "formulario";
					$json["mensaje"] = "Solicitud Modificada con exito";
				}
				else
				{
					$json["sucess"] = false;
					$json["mensaje"] = mysql_error();
				}
		echo json_encode($json);	
		exit();
	break;


	case 'eliminarPlantilla':
	require_once("json_contructor.php");
		$ArrayDatos=explode('_', $_GET["Plantilla"]);



		//print_r($_GET);

		//print_r($ArrayDatos) ;
		$IdSistema=$ArrayDatos[0];
		
		$IdMuestra=$ArrayDatos[1];

		//$IdMuestra=$separaPlantilla[1];

		$IdMuestra=str_replace("~", " ", $IdMuestra);

		$cod_Producto=$ArrayDatos[2];
		$cod_SubProducto=$ArrayDatos[3];
		$fechaHora=$ArrayDatos[4];
		$fechaHora=str_replace("~", " ", $fechaHora);

		$resp=$fx->obtenerPlantillas($IdSistema,$cod_Producto,$cod_SubProducto,$IdMuestra);	
		if($Fila=mysqli_fetch_assoc($resp))
		{
			$Query="DELETE FROM cal_web.plantilla_solicitud_analisis where fecha_hora = '".$fechaHora."' AND cod_producto='".$cod_Producto."' AND cod_subproducto='".$cod_SubProducto."' AND id_muestra = '".$IdMuestra."'";
		}
		//cho $Query;
		if($dataBaseMysql->QueryAction($Query)=='')
		{		
			$json["sucess"] = true;
			$json["p"] = "Formu";
			$json["mensaje"] = "La Plantilla fue eliminada con exito";
		}else
		{
			$json["sucess"] = false;
			$json["mensaje"] = mysql_error();
		}
		echo json_encode($json);
		exit();
	break;

	case 'eliminarsolicitud':
		$ArrayDatos=explode('_', $_GET["Solicitud"]);

		//print_r($ArrayDatos) ;

		$IdMuestra=$ArrayDatos[0];
		$IdMuestra=str_replace("+", " ", $IdMuestra);

		$cod_Producto=$ArrayDatos[1];
		$cod_SubProducto=$ArrayDatos[2];
		$fechaHora=$ArrayDatos[3];	
			
		require_once("json_contructor.php");

			$resp=$fx->obtenerSolicitudAnalisis($cod_Producto,$cod_SubProducto,$IdMuestra,$fechaHora,$CookieRut);	
				if($Fila=mysqli_fetch_assoc($resp))
				{
					$Query="DELETE FROM cal_web.solicitud_analisis where fecha_hora = '".$fechaHora."' AND cod_producto='".$cod_Producto."' AND cod_subproducto='".$cod_SubProducto."' AND rut_funcionario = '".$CookieRut."' and id_muestra = '".$IdMuestra."' ";
				}
				//echo $Query;
				if($dataBaseMysql->QueryAction($Query)=='')
				{		
					$json["sucess"] = true;
					$json["p"] = "JForm";
					$json["mensaje"] = "La solicitud fue eliminada con exito";
				}else
				{
					$json["sucess"] = false;
					$json["mensaje"] = mysql_error();
				}
		
			echo json_encode($json);
			exit();
	break;

	case 'asignarSA':
		require_once("json_contructor.php");
		$ArrayDatos=explode('_', $_GET["Solicitud"]);
		$IdMuestra=$ArrayDatos[0];

		$IdMuestra=str_replace("+", " ", $IdMuestra);
		$cod_Producto=$ArrayDatos[1];
		$cod_SubProducto=$ArrayDatos[2];
		$fechaHora=$ArrayDatos[3];

		$resp=$fx->obtenerSolicitudAnalisis($cod_Producto,$cod_SubProducto,$IdMuestra,$fechaHora,$CookieRut);	
		if($Fila=mysqli_fetch_assoc($resp))
		{
			$resp2=$fx->obtenerMaxNroSa();	 
			if ($Fila2 = mysqli_fetch_assoc($resp2))
			{
				if ((substr($Fila2["NroMayor"],0,4)) == (date("Y")))
				{
					$NroSA =$Fila2["NroMayor"]+1;										
				}
				else
				{
					$NroSA=date("Y")."000001";	
				}
			}
			else
			{
				$NroSA=date("Y")."000001";	
			}

			$Query="update cal_web.solicitud_analisis SET nro_solicitud='".$NroSA."' where fecha_hora = '".$fechaHora."' AND cod_producto='".$cod_Producto."' AND cod_subproducto='".$cod_SubProducto."' AND rut_funcionario = '".$CookieRut."' and id_muestra = '".$IdMuestra."'";
			
			if($dataBaseMysql->QueryAction($Query)=='')
			{
				//echo "hasta aqui";
				//SE INSERTA EL ESTADO 1(CREADAS) O 12(ENVIADA A C.CALIDAD) EN LA TABLA ESTADOS_POR_SOLICITUD
				$Insertar = "insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) values(";
				if ($Fila["cod_tipo_muestra"]==1)
				{
					$Actualizar = "update cal_web.solicitud_analisis set nro_solicitud =".$NroSA.",estado_actual='12' where rut_funcionario ='".$CookieRut."' and fecha_hora ='".$fechaHora."' and id_muestra='".$IdMuestra."'";
					$Insertar=$Insertar."'$CookieRut','$NroSA','12','$fechaHora','$CookieRut')";
					$Insertar2="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) values(";
					$Insertar2=$Insertar2."'$CookieRut','$NroSA','1','$fechaHora','$CookieRut')";
					
					
					$dataBaseMysql->QueryAction($Insertar2);
					
				}
				else
				{
					$Actualizar = "update cal_web.solicitud_analisis set nro_solicitud =".$NroSA.",estado_actual='1' where rut_funcionario ='".$CookieRut."' and fecha_hora ='".$fechaHora."' and id_muestra='".$IdMuestra."'";
					$Insertar = $Insertar."'$CookieRut','$NroSA','1','$fechaHora','$CookieRut')";
					
				}
				
				$dataBaseMysql->QueryAction($Actualizar);
				$dataBaseMysql->QueryAction($Insertar);

				if ($NroSA=="")
							{
								$NroSA = $Fila["nro_solicitud"];
								$Eliminar = "delete from cal_web.leyes_por_solicitud where rut_funcionario ='".$CookieRut."' and fecha_hora ='".$fechaHora."' and nro_solicitud = ".$NroSA."";
								$dataBaseMysql->QueryAction($Eliminar);
								//mysql_query($Eliminar);
							}
							if (!is_null($Fila["leyes"]) or ($Fila["leyes"] !=''))
							{
								$Leyes =$Fila["leyes"];
								for ($k = 0;$k <= strlen($Leyes); $k++)
								{
									if (substr($Leyes,$k,2) == "//")
									{
										$LeyesUnidades = substr($Leyes,0,$k);
										for ($f=0;$f<=strlen($LeyesUnidades);$f++)
										{
											if (substr($LeyesUnidades,$f,2) == "~~")
											{
												$Ley = substr($LeyesUnidades,0,$f);			
												$Unidad = substr($LeyesUnidades,$f+2,strlen($LeyesUnidades));
												$Insertar3 = "insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('$CookieRut','$fechaHora','$NroSA','$Ley','$Unidad','$cod_Producto','$cod_SubProducto','$IdMuestra')";
												//echo $Insertar3;
												$dataBaseMysql->QueryAction($Insertar3);
												//mysql_query($Insertar);
											}
										}
									$Leyes = substr($Leyes,$k + 2);
									$k = 0;
									}
								}		
							}//SE INSERTAN LAS IMPUREZAS ALMACENADAS EN EL CAMPO IMPUREZAS DE LA TABLA SOLICITUDES_ANALISIS 
							//EN LA TABLA LEYES_POR_SOLICITUD									
							$Impurezas =$Fila["impurezas"];
							if (!is_null($Fila["impurezas"]) or ($Fila["impurezas"] !=''))
							{
								for ($k = 0;$k <= strlen($Impurezas); $k++)
								{
									if (substr($Impurezas,$k,2) == "//")
									{
										$ImpurezasUnidades = substr($Impurezas,0,$k);
										for ($f=0;$f<=strlen($ImpurezasUnidades);$f++)
										{
											if (substr($ImpurezasUnidades,$f,2) == "~~")
											{
												$Impureza = substr($ImpurezasUnidades,0,$f);			
												$Unidad = substr($ImpurezasUnidades,$f+2,strlen($ImpurezasUnidades));
												$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('$CookieRut','$fechaHora','$NroSA','$Impureza','$Unidad','$cod_Producto','$cod_SubProducto','$IdMuestra')";
												$dataBaseMysql->QueryAction($Insertar);
												//mysql_query($Insertar);
											}
										}
									$Impurezas = substr($Impurezas,$k + 2);
									$k = 0;
									}
								}
							}









				$json["sucess"] = true;
				$json["p"] = "JForm";
				$json["mensaje"] = "El Numero De Solicitud ".$NroSA." Fue Agrego Con Exito";
			}
			else
			{
				$json["sucess"] = false;
				$json["mensaje"] = mysql_error();
			}
		}//existencia de la solicitud	
		echo json_encode($json);
		exit();
	break;
}
?>

