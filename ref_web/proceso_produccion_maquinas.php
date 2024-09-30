<?php
	 include("../principal/conectar_ref_web.php");
$proceso = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$ano1   = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";
$mes1   = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
$dia1   = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:"";
$txt_turno1 = isset($_REQUEST["txt_turno1"])?$_REQUEST["txt_turno1"]:"";
	
	 if ($proceso == "G")
	 {
		 if (strlen($mes1)==1)
		 {
		 	$mes1="0".$mes1;
		 }
		 if (strlen($dia1)==1)
		 {
		 	$dia1="0".$dia1;
		 }
		 $fecha=$ano1."-".$mes1."-".$dia1;
		
		 $guardo='N'; 
		 $consulta = "SELECT * FROM ref_web.iniciales WHERE  fecha='".$fecha."' and turno='".$txt_turno1."'"; 
		 $consulta .="order by turno";
		 $respuesta =mysqli_query($link, $consulta);
		 if ($row1=mysqli_fetch_array($respuesta))
		 {
			$Mensaje="El registro ya existe.";
		 }
		 else
		 {
			if(($txt_mfci1 <> '') or ($txt_mdb1 <> '') or ($txt_mco1 <> ''))
			{		
			  $insertar1="insert into ref_web.iniciales(fecha,turno,produccion_mfci,produccion_mdb,produccion_mco,observacion)"; 
			  $insertar1 = $insertar1."values ('".$fecha."','".$txt_turno1."','".$txt_mfci1."','".$txt_mdb1."','".$txt_mco1."','".$txt_observacion1."')";
			  mysqli_query($link, $insertar1);
			  $guardo='S';
			}
		}
	
		 $consulta = "SELECT * FROM ref_web.iniciales WHERE  fecha='".$fecha."' and turno='".$txt_turno2."'"; 
		 $consulta .="order by turno";
		 $respuesta =mysqli_query($link, $consulta);
		 if ($row1=mysqli_fetch_array($respuesta))
		 {
			$Mensaje="El registro ya existe.";
		 }
		 else
		 {
			if(($txt_mfci2 <> '') or ($txt_mdb2 <> '') or ($txt_mco2 <> ''))
			{		
			  $insertar2="insert into ref_web.iniciales(fecha,turno,produccion_mfci,produccion_mdb,produccion_mco,observacion)"; 
			  $insertar2 = $insertar2."values ('".$fecha."','".$txt_turno2."','".$txt_mfci2."','".$txt_mdb2."','".$txt_mco2."','".$txt_observacion2."')";
			  mysqli_query($link, $insertar2);
			  $guardo='S';
			}
		}	
		 $consulta = "SELECT * FROM ref_web.iniciales WHERE  fecha='".$fecha."' and turno='".$txt_turno3."'"; 
		 $consulta .="order by turno";
		 $respuesta =mysqli_query($link, $consulta);
		 if ($row1=mysqli_fetch_array($respuesta))
		 {
			$Mensaje="El registro ya existe.";
		 }
		 else
		 {
			if(($txt_mfci3 <> '') or ($txt_mdb3 <> '') or ($txt_mco3 <> ''))
			{		
			  $insertar3="insert into ref_web.iniciales(fecha,turno,produccion_mfci,produccion_mdb,produccion_mco,observacion)"; 
			  $insertar3 = $insertar3."values ('".$fecha."','".$txt_turno3."','".$txt_mfci3."','".$txt_mdb3."','".$txt_mco3."','".$txt_observacion3."')";
			  mysqli_query($link, $insertar3);
			  $guardo='S';
			}
		}
		if ($guardo=='S')
		    {$Mensaje="Los datos se guardaron satisfactoriamente.";}
				
		if(($txt_stock <> '') or ($txt_rechazo_cat_ini <> '') or ($txt_rechazo_lam_ini <> ''))
		{  
			$insertar4="insert into ref_web.detalle_iniciales(fecha,stock,rechazo_cat_ini,rechazo_lam_ini,catodos_en_renovacion)";
			$insertar4 = $insertar4."values ('".$fecha."','".$txt_stock."','".$txt_rechazo_cat_ini."','".$txt_rechazo_lam_ini."','".$txt_catodos_en_renovacion."')";	
			mysqli_query($link, $insertar4);
			
		}
		if (isset($Mensaje))
		{
			header("location:ingreso_produccion_maquinas.php?Mensaje=".$Mensaje);
		}
		else
		{
			header("location:ingreso_produccion_maquinas.php");
		}	
	}
	
		 
	if ($proceso == "M") 
	 {	
	     $ano1=substr($fecha,0,4);
		 $mes1=substr($fecha,5,2);
		 $dia1=substr($fecha,8,2); 
		 $busqueda = "SELECT * FROM ref_web.iniciales WHERE fecha ='".$fecha."'";
		 $resultado = mysqli_query($link, $busqueda);
		 while ($row1=mysqli_fetch_array($resultado))
		 {
			$txt_mfci1 = isset($row1["txt_mfci1"])?$row1["txt_mfci1"]:"";
			$txt_mdb1 = isset($row1["txt_mdb1"])?$row1["txt_mdb1"]:"";
			$txt_mco1 = isset($row1["txt_mco1"])?$row1["txt_mco1"]:"";
			$txt_observacion1 = isset($row1["txt_observacion1"])?$row1["txt_observacion1"]:"";
		    $muestra = "&produccion_mfci=".$txt_mfci1."&produccion_mdb=".$txt_mdb1."&produccion_mco=".$txt_mco1."&observacion=".$txt_observacion1."&txt_rechazo_cat_ini_a=".$row1["rechazo_cat_ini_turno"]."&txt_rechazo_lam_ini_a=".$row1["rechazo_lam_ini_turno"]."&txt_catodos_en_renovacion_a=".$row1["catodos_en_renovacion_turno"]."";
		 }
		    if(($txt_mfci1 <> '') or ($txt_mdb1 <> '') or ($txt_mco1 <> ''))
			{
				$actualiza = "UPDATE ref_web.iniciales set produccion_mfci ='".$txt_mfci1."', produccion_mdb ='".$txt_mdb1."', produccion_mco ='".$txt_mco1."',observacion ='".$txt_observacion1."', ";
				$actualiza.= " rechazo_cat_ini_turno='".$txt_rechazo_cat_ini_a."',rechazo_lam_ini_turno='".$txt_rechazo_lam_ini_a."', catodos_en_renovacion_turno='".$txt_catodos_en_renovacion_a."' where fecha= '".$fecha."' and turno='A'";
		 	    mysqli_query($link, $actualiza);
			}

			if($row2=mysqli_fetch_array($resultado))
			{
				$muestra.= "fecha=".$row2["fecha"]."&produccion_mfci=".$row2["txt_mfci2"]."&produccion_mdb=".$row2["txt_mdb2"]."&produccion_mco=".$row2["txt_mco2"]."&observacion=".$row2["txt_observacion2"]."&txt_rechazo_cat_ini_b=".$row2["rechazo_cat_ini_turno"]."&txt_rechazo_lam_ini_b=".$row2["rechazo_lam_ini_turno"]."&txt_catodos_en_renovacion_b=".$row2["catodos_en_renovacion_turno"]."";
			}  
			 if(($txt_mfci2 <> '') or ($txt_mdb2 <> '') or ($txt_mco2 <> ''))
			{
				$actualiza = "UPDATE ref_web.iniciales set fecha ='".$fecha."',produccion_mfci ='".$txt_mfci2."', produccion_mdb ='".$txt_mdb2."', produccion_mco ='".$txt_mco2."',observacion ='".$txt_observacion2."', ";
				$actualiza.= "  rechazo_cat_ini_turno='".$txt_rechazo_cat_ini_b."',rechazo_lam_ini_turno='".$txt_rechazo_lam_ini_b."', catodos_en_renovacion_turno='".$txt_catodos_en_renovacion_b."' where fecha= '".$fecha."'and turno='B'";
				mysqli_query($link, $actualiza);
			}
			 if($row3=mysqli_fetch_array($resultado))
			 {
				$muestra .="fecha=".$row3["fecha"]."&produccion_mfci=".$row3["txt_mfci3"]."&produccion_mdb=".$row3["txt_mdb3"]."&produccion_mco=".$row3["txt_mco3"]."&observacion=".$row1["txt_observacion3"]."&txt_rechazo_cat_ini_c=".$row3["rechazo_cat_ini_turno"]."&txt_rechazo_lam_ini_c=".$row3["rechazo_lam_ini_turno"]."&txt_catodos_en_renovacion_c=".$row3["catodos_en_renovacion_turno"]."";
			 }
			if(($txt_mfci3 <> '') or ($txt_mdb3 <> '') or ($txt_mco3 <> ''))
			{
				$actualiza = "UPDATE ref_web.iniciales set fecha ='".$fecha."',produccion_mfci ='".$txt_mfci3."', produccion_mdb ='".$txt_mdb3."', produccion_mco ='".$txt_mco3."',observacion ='".$txt_observacion3."', ";
				$actualiza.= " rechazo_cat_ini_turno='".$txt_rechazo_cat_ini_c."',rechazo_lam_ini_turno='".$txt_rechazo_lam_ini_c."', catodos_en_renovacion_turno='".$txt_catodos_en_renovacion_c."' where fecha= '".$fecha."'and turno='C'";
				mysqli_query($link, $actualiza);
		    }
			$busqueda = "SELECT * FROM ref_web.detalle_iniciales WHERE fecha ='".$fecha."'";
		 	$resultado = mysqli_query($link, $busqueda);
		 	if($row=mysqli_fetch_array($resultado))
		 	{
		    	$muestra.= "fecha=".$row["fecha"]."&stock=".$row["txt_stock"]."&rechazo_cat_ini=".$row["txt_rechazo_cat_ini"]."&rechazo_cat_ini=".$row["txt_rechazo_lam_ini"]."";
		 	}
			if(($txt_stock <> '') or ($txt_rechazo_cat_ini <> '') or ($txt_rechazo_lam_ini <> '') or ($txt_catodos_en_renovacion <> '') )
			{
				$actualiza = "UPDATE ref_web.detalle_iniciales set fecha ='".$fecha."',stock ='".$txt_stock."',rechazo_cat_ini ='".$txt_rechazo_cat_ini."',rechazo_lam_ini ='".$txt_rechazo_lam_ini."',catodos_en_renovacion ='".$txt_catodos_en_renovacion."'";
				$actualiza.= "where fecha= '".$fecha."'";                                                                           
				mysqli_query($link, $actualiza);
			}
			header("Location:proceso_produccion_maquinas.php?proceso=B&fecha=".$fecha."");		 
     }
     if ($fecha=='')
	    {$fecha=$ano1."-".$mes1."-".$dia1;} 
	else {
			$ano1=substr($fecha,0,4);
		    $mes1=substr($fecha,5,2);
		    $dia1=substr($fecha,8,2);
			
	}		    
	if ($proceso == "B")
	{
	    $ano1=substr($fecha,0,4);
		$mes1=substr($fecha,5,2);
		$dia1=substr($fecha,8,2);
        $consulta = "select * from ref_web.iniciales where fecha = '".$fecha."'";
		$consulta .= "order by turno";
		$rs = mysqli_query($link, $consulta);
		if ($row1 =mysqli_fetch_array($rs))
		    {
				$rs = mysqli_query($link, $consulta);
				while ($row1 =mysqli_fetch_array($rs))
				{
					switch ($row1["turno"])
					{
						case "A":
							 $linea = "&fecha=".$fecha."&txt_turno1=".$row1["turno"]."&txt_mfci1=".$row1["produccion_mfci"]."&txt_mdb1=".$row1["produccion_mdb"]."&txt_mco1=".$row1["produccion_mco"]."&txt_observacion1=".$row1["observacion"]."&txt_rechazo_cat_ini_a=".$row1["rechazo_cat_ini_turno"]."&txt_rechazo_lam_ini_a=".$row1["rechazo_lam_ini_turno"]."&txt_catodos_en_renovacion_a=".$row1["catodos_en_renovacion_turno"]."";
							 break;
						case "B":
							 $linea.= "&fecha=".$fecha."&txt_turno2=".$row1["turno"]."&txt_mfci2=".$row1["produccion_mfci"]."&txt_mdb2=".$row1["produccion_mdb"]."&txt_mco2=".$row1["produccion_mco"]."&txt_observacion2=".$row1["observacion"]."&txt_rechazo_cat_ini_b=".$row1["rechazo_cat_ini_turno"]."&txt_rechazo_lam_ini_b=".$row1["rechazo_lam_ini_turno"]."&txt_catodos_en_renovacion_b=".$row1["catodos_en_renovacion_turno"]."";
							 break;
						case "C":
							 $linea.= "&fecha=".$fecha."&txt_turno3=".$row1["turno"]."&txt_mfci3=".$row1["produccion_mfci"]."&txt_mdb3=".$row1["produccion_mdb"]."&txt_mco3=".$row1["produccion_mco"]."&txt_observacion3=".$row1["observacion"]."&txt_rechazo_cat_ini_c=".$row1["rechazo_cat_ini_turno"]."&txt_rechazo_lam_ini_c=".$row1["rechazo_lam_ini_turno"]."&txt_catodos_en_renovacion_c=".$row1["catodos_en_renovacion_turno"]."";
							 break;
					}
				}
			 }
		else {
	            $insertar1="insert into ref_web.iniciales(fecha,turno,produccion_mfci,produccion_mdb,produccion_mco,observacion,rechazo_cat_ini_turno,rechazo_lam_ini_turno,catodos_en_renovacion_turno)"; 
  			    $insertar1 = $insertar1."values ('".$fecha."','A','0','0','0','0','0','0','0')";
                mysqli_query($link, $insertar1);
  				$insertar2="insert into ref_web.iniciales(fecha,turno,produccion_mfci,produccion_mdb,produccion_mco,observacion,rechazo_cat_ini_turno,rechazo_lam_ini_turno,catodos_en_renovacion_turno)"; 
  				$insertar2 = $insertar2."values ('".$fecha."','B','0','0','0','0','0','0','0')";
  				mysqli_query($link, $insertar2);
  				$insertar3="insert into ref_web.iniciales(fecha,turno,produccion_mfci,produccion_mdb,produccion_mco,observacion,rechazo_cat_ini_turno,rechazo_lam_ini_turno,catodos_en_renovacion_turno)"; 
  				$insertar3 = $insertar3."values ('".$fecha."','C','0','0','0','0','0','0','0')";
  				mysqli_query($link, $insertar3);
  				$insertar4="insert into ref_web.detalle_iniciales(fecha,stock,rechazo_cat_ini,rechazo_lam_ini,catodos_en_renovacion)";
  				$insertar4 = $insertar4."values ('".$fecha."','0','0','0','0')";	
  				mysqli_query($link, $insertar4);	
		     }	 
				
     	$consulta = "select * from ref_web.detalle_iniciales where fecha = '".$fecha."'";
		$rs = mysqli_query($link, $consulta);		
		if ($row = mysqli_fetch_array($rs))
			{	
				$linea = $linea."&fecha=".$fecha."&txt_stock=".$row["stock"]."&txt_rechazo_cat_ini=".$row["rechazo_cat_ini"]."&txt_rechazo_lam_ini=".$row["rechazo_lam_ini"]."&txt_catodos_en_renovacion=".$row["catodos_en_renovacion"]."";
			}	
		if($linea<>'')
			{ 
			 	header("location:ingreso_produccion_maquinas.php?mostrar=S".$linea);
			}
			else
			{
			        $linea="&fecha=".$fecha;
				    header("location:ingreso_produccion_maquinas.php?mostrar=S".$linea);
		 	}
 }
?>
