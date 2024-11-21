<?php
	include("../principal/conectar_ref_web.php");
	
	$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:date("Y-m-d");
    $opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$proceso  = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$gruesas1  = isset($_REQUEST["gruesas1"])?$_REQUEST["gruesas1"]:"";
	$gruesas2  = isset($_REQUEST["gruesas2"])?$_REQUEST["gruesas2"]:"";
	$gruesas7  = isset($_REQUEST["gruesas7"])?$_REQUEST["gruesas7"]:"";
	$gruesas8  = isset($_REQUEST["gruesas8"])?$_REQUEST["gruesas8"]:"";
	$delgadas1  = isset($_REQUEST["delgadas1"])?$_REQUEST["delgadas1"]:"";
	$delgadas2  = isset($_REQUEST["delgadas2"])?$_REQUEST["delgadas2"]:"";
	$delgadas7  = isset($_REQUEST["delgadas7"])?$_REQUEST["delgadas7"]:"";
	$delgadas8  = isset($_REQUEST["delgadas8"])?$_REQUEST["delgadas8"]:"";
	$granuladas1  = isset($_REQUEST["granuladas1"])?$_REQUEST["granuladas1"]:"";
	$granuladas2  = isset($_REQUEST["granuladas2"])?$_REQUEST["granuladas2"]:"";
	$granuladas7  = isset($_REQUEST["granuladas7"])?$_REQUEST["granuladas7"]:"";
	$granuladas8  = isset($_REQUEST["granuladas8"])?$_REQUEST["granuladas8"]:"";
	$recuperado  = isset($_REQUEST["recuperado"])?$_REQUEST["recuperado"]:"";
	$ajuste  = isset($_REQUEST["ajuste"])?$_REQUEST["ajuste"]:"";
	$tipo    = isset($_REQUEST["tipo"])?$_REQUEST["tipo"]:"";

 if ($opcion=="N") 
	         {
		
			  $consulta="select * from ref_web.produccion where fecha='".$fecha."' and cod_grupo='1'";
			  $rs = mysqli_query($link, $consulta);
		      if (!$row = mysqli_fetch_array($rs))
			     {
				  $insertar1 = "insert into ref_web.produccion (fecha,cod_grupo,rechazo_delgadas,rechazo_gruesas,rechazo_granuladas) values ('".$fecha."','1','".$delgadas1."','".$gruesas1."','".$granuladas1."') ";
				  //echo $insertar1;
				  mysqli_query($link, $insertar1);
				 }
			  else {
			         $actualizar1 = "UPDATE ref_web.produccion SET rechazo_delgadas= '".$delgadas1."', rechazo_gruesas = '".$gruesas1."' ";
		      		 $actualizar1.= ", rechazo_granuladas = '".$granuladas1."' ";
		             $actualizar1.= " WHERE cod_grupo = '1' and fecha='".$fecha."'";
			         //echo $actualizar1;
		      	     mysqli_query($link, $actualizar1);
			  	   }
			  $consulta="select * from ref_web.produccion where fecha='".$fecha."' and cod_grupo='2'";
			  $rs = mysqli_query($link, $consulta);
		      if (!$row = mysqli_fetch_array($rs))
			     {	   	  
				  $insertar2 = "insert into ref_web.produccion (fecha,cod_grupo,rechazo_delgadas,rechazo_gruesas,rechazo_granuladas) values ('".$fecha."','2','".$delgadas2."','".$gruesas2."','".$granuladas2."') ";
				  //echo $insertar2;
				  mysqli_query($link, $insertar2);
				 }
			  else {
 			          $actualizar2 = "UPDATE ref_web.produccion SET rechazo_delgadas= '".$delgadas2."', rechazo_gruesas = '".$gruesas2."' ";
					  $actualizar2.= ", rechazo_granuladas = '".$granuladas2."' ";
					  $actualizar2.= " WHERE cod_grupo = '2' and fecha='".$fecha."'";
					  //echo $actualizar2;
					  mysqli_query($link, $actualizar2);
			       }
			  $consulta="select * from ref_web.produccion where fecha='".$fecha."' and cod_grupo='7'";
			  $rs = mysqli_query($link, $consulta);
		      if (!$row = mysqli_fetch_array($rs))
			     {	   	  	   	  
				  $insertar7 = "insert into ref_web.produccion (fecha,cod_grupo,rechazo_delgadas,rechazo_gruesas,rechazo_granuladas) values ('".$fecha."','7','".$delgadas7."','".$gruesas7."','".$granuladas7."') ";
				  //echo $insertar7;
				  mysqli_query($link, $insertar7);
				 }
			  else {
			  		$actualizar7 = "UPDATE ref_web.produccion SET rechazo_delgadas= '".$delgadas7."', rechazo_gruesas = '".$gruesas7."' ";
		      		$actualizar7.= ", rechazo_granuladas = '".$granuladas7."' ";
		      		$actualizar7.= " WHERE cod_grupo = '7' and fecha='".$fecha."'";
			  		//echo $actualizar7;
		      		mysqli_query($link, $actualizar7);
			       }
			  $consulta="select * from ref_web.produccion where fecha='".$fecha."' and cod_grupo='8'";
			  $rs = mysqli_query($link, $consulta);
		      if (!$row = mysqli_fetch_array($rs))
			     {	   	  	   	     	  
				  $insertar8 = "insert into ref_web.produccion (fecha,cod_grupo,rechazo_delgadas,rechazo_gruesas,rechazo_granuladas) values ('".$fecha."','8','".$delgadas8."','".$gruesas8."','".$granuladas8."') ";
				  //echo $insertar8;
				  mysqli_query($link, $insertar8);
				 }
			  else {
			        $actualizar8 = "UPDATE ref_web.produccion SET rechazo_delgadas= '".$delgadas8."', rechazo_gruesas = '".$gruesas8."' ";
		      		$actualizar8.= ", rechazo_granuladas = '".$granuladas8."' ";
		      		$actualizar8.= " WHERE cod_grupo = '8' and fecha='".$fecha."'";
			  		//echo $actualizar8;
		      		mysqli_query($link, $actualizar8);       
			       }
			  $consulta="select * from ref_web.recuperado where fecha='".$fecha."'";
			  $rs = mysqli_query($link, $consulta);
		      if (!$row = mysqli_fetch_array($rs))
			     {	   	  	   	     	  	   	   
			      $insertar_recuperado = "insert into ref_web.recuperado (fecha,recuperado) values ('".$fecha."','".$recuperado."') ";
		          //echo $insertar_recuperado;
		          mysqli_query($link, $insertar_recuperado);
				 }
			  else {
			        $actualizar8 = "UPDATE ref_web.recuperado SET recuperado= '".$recuperado."' ";
		      		$actualizar8.= " WHERE fecha='".$fecha."'";
			  		//echo $actualizar8;
		      		mysqli_query($link, $actualizar8);       
				   
				   }
			 $consulta="select * from ref_web.ajustes where fecha='".$fecha."'";
			 $rs=mysqli_query($link, $consulta);	   	  
			 if (!$row = mysqli_fetch_array($rs))
			     {	   	  	   	     	  	   	   
			      $insertar_ajuste = "insert into ref_web.ajustes (fecha,ajuste,tipo) values ('".$fecha."','".$ajuste."','".$tipo."') ";
		          //echo $insertar_ajuste;
		          mysqli_query($link, $insertar_ajuste);
				 }
			  else {
			        $actualizar_ajuste = "UPDATE ref_web.ajustes SET ajuste= '".$ajuste."',tipo='".$tipo."' ";
		      		$actualizar_ajuste.= " WHERE fecha='".$fecha."'";
			  		//echo $actualizar_ajuste;
		      		mysqli_query($link, $actualizar_ajuste);       
				   
				   }
			  
			  $mensaje = "Detalle(s) Modificado(s) Correctamente";
		      header("Location:prueba_hm.php?fecha=".trim($fecha));
			 
			 }

		
	
	include("../principal/cerrar_ref_web.php");
?>