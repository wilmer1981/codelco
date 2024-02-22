<?php
	 
//echo  "Codigo Sistema:".$_SESSION["CodSistemaSel"]."<br>";
//echo  "Rut:".$CookieRut;
//$_SESSION["CodSistemaSel"]=2;
//print_r($_POST);

/*
if(!isset($_SESSION["fechaCreacion"])) 	
	$FechaHora=date("Y-m-d G:i:s");
else
	$FechaHora=$_SESSION["fechaCreacion"];*/

$FechaHora=date("Y-m-d G:i:s");
$pagina->set_var("fechaHora",$FechaHora);

//echo $_SESSION["CodSistemaSel"];
//echo $_POST["plantilla"];

if (isset($_POST["plantilla2"])) {
	$_POST["plantilla"]=$_POST["plantilla2"];
	$codProducto=$_POST["cod_producto"];
	$codSubproducto=$_POST["cod_subProducto"];
	$FechaHora=$_POST["fechaOri"];
}

 
$pagina->set_var("salir",$config['rootOrigen']);

//##############################################################
//	LISTADO COMPLETO DE LOS CAMPAMENTOS QUE EXISTEN
//##############################################################
$pagina->set_block('gen_solicitud_analisis','CMBSOLICITUD','bCMBSOLICITUD');	
$resp1=$fx->obtenerPlantillaDetalles($_SESSION["CodSistemaSel"]);	 
		//$resp=$dataBaseMysql->consulta($Consulta);		 
		while($Fila1=mysqli_fetch_assoc($resp1))
		{
			$idPlantilla=$Fila1["id_muestra"]."_".$Fila1["cod_producto"]."_".$Fila1["cod_subproducto"];
			//echo $idPlantilla."<br>";
		    $pagina->set_var("valuePlantilla",$idPlantilla);
			if ($idPlantilla==$_POST["plantilla"]) 
			{
			    $pagina->set_var("chePlantilla","SELECTed");
			    $idMuestra=$Fila1["id_muestra"];
			    $codProducto=$Fila1["cod_producto"];
			    $codSubproducto=$Fila1["cod_subproducto"];
			}
			else
			{
				$pagina->set_var("chePlantilla","");
			}    
		   	
		   	$pagina->set_var("id_muestra",strtoupper($Fila1["id_muestra"]) );
			$pagina->set_var("nomPlantilla",strtoupper($Fila1["nombre_plantilla"]));
			$pagina->set_var("nomProducto",strtoupper($Fila1["nombre_producto"]));
			$pagina->set_var("nomSubProducto",strtoupper($Fila1["nombre_subproducto"]));

			$pagina->parse("bCMBSOLICITUD","CMBSOLICITUD",true);
		}


		$pagina->set_block('gen_solicitud_analisis','SOLICITUD','bSOLICITUD');
		
		$Contador=0;

 		//$resp=$fx->obtenerSolicitudAnalisis($_GET["cod_producto"],$_GET["cod_subproducto"],$_GET["idMuestra"],$_GET["fecha"]);
		$resp=$fx->obtenerSolicitudAnalisis($codProducto,$codSubproducto, '','',$CookieRut);
		//$resp=$fx->obtenerPlantillas($_SESSION["CodSistemaSel"],$codProducto,$codSubproducto,$idMuestra);	 
		//$resp=$dataBaseMysql->consulta($Consulta);		 
		while($Fila=mysqli_fetch_assoc($resp))
		{ 	

			if (!$Fila["nro_solicitud"]){
							//print_r ($Fila);
			$idsinespacio=str_replace(" ","+", $Fila["id_muestra"]);


			// $pagina->set_var("IdSolicitud", $Fila["id_muestra"]."_".$Fila["cod_producto"]."_".$Fila["cod_subproducto"]."_". str_replace(" ","~", $Fila["fecha_hora"]));
			$pagina->set_var("IdSolicitud", $idsinespacio."_".$Fila["cod_producto"]."_".$Fila["cod_subproducto"]."_". str_replace(" ","~", $Fila["fecha_hora"]));

			
			$pagina->set_var("fechaHora", $Fila["fecha_hora"]);
			$pagina->set_var("idMuestra", $Fila["id_muestra"]);
			

				$respArea=$fx->obtenerArea($Fila["cod_area"]);
				if ($FilaArea=mysqli_fetch_assoc($respArea)) {
					$pagina->set_var("nombreArea", $FilaArea["AREA"] );
				}else
				$pagina->set_var("nombreArea", "");

				$respCecos=$fx->obtenerCentroCosto($Fila["cod_ccosto"]);
				if ($FilaCecos=mysqli_fetch_assoc($respCecos)	) {
					$pagina->set_var("centroCosto", $FilaCecos["DESCRIPCION"] );
				}else
				$pagina->set_var("centroCosto", "");	

			$pagina->set_var("leyes", $Fila["leyes"]);
			$pagina->set_var("impurezas", $Fila["impurezas"]);
			
			if (!$Fila["fecha_muestra"]) {
				$pagina->set_var("periodo", "Sin Periodo");
				$pagina->set_var("disabled2", "disabled");
			}else{
				$pagina->set_var("periodo", "AD - ".$Fila["fecha_muestra"]);
				$pagina->set_var("disabled2", "");
			}

			if (!$Fila["nro_solicitud"]) {
				$pagina->set_var("sa", "Sin Nro Solicitud");
				$pagina->set_var("disabled", "");
			}else{
				$pagina->set_var("sa", $Fila["nro_solicitud"]);
				$pagina->set_var("disabled", "disabled");
			}

			 
			

			$Contador++;
			$pagina->parse("bSOLICITUD","SOLICITUD",true);

				
			}

		}
 		



 		if ($Contador==0) {
				$pagina->set_var("bSOLICITUD",'');
			}



?>