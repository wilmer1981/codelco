<?php
	 include("../principal/conectar_ref_web.php");
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
	 $consulta_x="select  cod_grupo from ref_web.produccion where fecha='".$fecha."'";
	 $respuesta_x =mysqli_query($link, $consulta_x);
	 $guardo='N';
	    
	 $consulta = "SELECT * FROM ref_web.produccion WHERE  fecha='".$fecha."' and cod_grupo='1'";
	 $consulta .="order by cod_grupo";
	// echo $consulta;
	 $respuesta =mysqli_query($link, $consulta);
     if ($row1=mysqli_fetch_array($respuesta))
	 {
	   $Mensaje="El registro ya existe.";
     header("Location:ingreso_produccion_maquinas.php?Mensaje=".$Mensaje);
	 }
	 else
	 {
      if(($txt_delgadas1 <> '') or ($txt_granuladas1 <> '') or ($txt_gruesas1 <> '') or ($txt_total_recuperado1 <> ''))
	   	{		
		  $insertar1="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)";
		  $insertar1 = $insertar1."values ('".$fecha."','".$txt_grupo1."','".$txt_delgadas1."','".$txt_granuladas1."','".$txt_gruesas1."','".$txt_total_recuperado1."','".$txt_observacion1."')";
		  mysqli_query($link, $insertar1);
		  $guardo='S';
		}
		 
        }
		 
        $consulta = "SELECT * FROM ref_web.produccion WHERE  fecha='".$fecha."' and cod_grupo='2'";
		$consulta .="order by cod_grupo";
		$respuesta =mysqli_query($link, $consulta);
		if ($row1=mysqli_fetch_array($respuesta))
		{
			$Mensaje="El registro ya existe.";
        }
		 else
		 {
		 if(($txt_delgadas2 <> '') or ($txt_granuladas2 <> '') or ($txt_gruesas2 <> '') or ($txt_total_recuperado2 <> ''))
	   	{
		  $insertar2="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)";
		  $insertar2 = $insertar2."values ('".$fecha."','".$txt_grupo2."','".$txt_delgadas2."','".$txt_granuladas2."','".$txt_gruesas2."','".$txt_total_recuperado2."','".$txt_observacion2."')";
		  mysqli_query($link, $insertar2);
		  $guardo='S';
		}
    	}
		
  		$consulta = "SELECT * FROM ref_web.produccion WHERE  fecha='".$fecha."' and cod_grupo='7'";
		$consulta .="order by cod_grupo";
		$respuesta =mysqli_query($link, $consulta);
		if ($row1=mysqli_fetch_array($respuesta))
		{
			$Mensaje="El registro ya existe.";
     }
		else
	    {
        if(($txt_delgadas3 <> '') or ($txt_granuladas3 <> '') or ($txt_gruesas3 <> '') or ($txt_total_recuperado3 <> ''))
	   	{		
		  $insertar3 ="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)"; 
		  $insertar3 = $insertar3."values ('".$fecha."','".$txt_grupo3."','".$txt_delgadas3."','".$txt_granuladas3."','".$txt_gruesas3."','".$txt_total_recuperado3."','".$txt_observacion3."')";
		  mysqli_query($link, $insertar3);
		  $guardo='S';
		}
		}
			
        

		$consulta = "SELECT * FROM ref_web.produccion WHERE  fecha='".$fecha."' and cod_grupo='8'";
		$consulta .="order by cod_grupo";
		$respuesta =mysqli_query($link, $consulta);
		if ($row1=mysqli_fetch_array($respuesta))
		{
				$Mensaje="El registro ya existe.";

        }
		 else
 	    {
		if(($txt_delgadas4 <> '') or ($txt_granuladas4 <> '') or ($txt_gruesas4 <> '') or ($txt_total_recuperado4 <> ''))
	   	{		
		  $insertar4 ="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)"; 
		  $insertar4 = $insertar4."values ('".$fecha."','".$txt_grupo4."','".$txt_delgadas4."','".$txt_granuladas4."','".$txt_gruesas4."','".$txt_total_recuperado4."','".$txt_observacion4."')";
		  mysqli_query($link, $insertar4);
		  $guardo='S';
		}
		}
		 if ($guardo=='S')
			{
			   $Mensaje="Los datos se guardaron satisfactoriamente.";
			}		 
		 
		 
 	    if(($txt_stock <> '') or ($txt_peso_promedio <> '') or ($txt_kah_promedio <> ''))
	   	{  
	    $insertar5="insert into ref_web.detalle_produccion(fecha,stock,peso_promedio,lectura_rectificador)";
		$insertar5 = $insertar5."values ('".$fecha."','".$txt_stock."','".$txt_lectura_rectificador."')";	
        mysqli_query($link, $insertar5);
		}
        if (isset($Mensaje))
		{
			header("location:ingreso_hmadres.php?Mensaje=".$Mensaje);
		}
		else
		{
			header("location:ingreso_hmadres.php");
		}
		
	 }


	
     if ($proceso == "M")
	 {	 
		 $busqueda = "SELECT * FROM ref_web.produccion WHERE fecha ='".$fecha."' order by cod_grupo asc";
		 //echo $busqueda."<br>";
		 $resultado = mysqli_query($link, $busqueda);
		 while ($row1=mysqli_fetch_array($resultado))
		 {
		 	$fecha = explode("-",$row1["fecha"]);
		    $muestra = "&rechazo_delgadas=".$row1[txt_delgadas1]."&rechazo_granuladas=".$row1[txt_granuladas1]."&rechazo_gruesas=".$row1[txt_gruesas1]."&total_recuperado=".$row1[txt_total_recuperado1]."&observacion=".$row1[txt_observacion1]."";
		 }
		   
      if(($txt_delgadas1 <> '') or ($txt_granuladas1 <> '') or ($txt_gruesas1 <> '') or ($txt_total_recuperado1 <> ''))
			{
		    $fecha=$ano1."-".$mes1."-".$dia1; 
		 	$actualiza = "UPDATE ref_web.produccion set rechazo_delgadas ='".$txt_delgadas1."', rechazo_granuladas ='".$txt_granuladas1."', rechazo_gruesas ='".$txt_gruesas1."',total_recuperado='".$txt_total_recuperado1."',observacion ='".$txt_observacion1."'";
			//echo $actualiza; 
		 	$actualiza.= "where fecha= '".$fecha."' and cod_grupo='1'";
		 	//*echo $actualiza."<br>";
			//}
		 	mysqli_query($link, $actualiza);
            }

      else

              if(($txt_delgadas1 = '') or ($txt_granuladas1 = '') or ($txt_gruesas1 = '') or ($txt_total_recuperado1 = ''))
              {
                $insertar1="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)";
                $insertar1 = $insertar1."values ('".$fecha."','".$txt_grupo1."','".$txt_delgadas1."','".$txt_granuladas1."','".$txt_gruesas1."','".$txt_total_recuperado1."','".$txt_observacion1."')";
                $insertar1 = $insertar1."where fecha= '".$fecha."' and cod_grupo='1'";
                mysqli_query($link, $insertar1);
		      }

		 
			
		 
		 if($row2=mysqli_fetch_array($resultado))
		 {
		 	$fecha = explode("-",$row2["fecha"]);
	        $muestra.= "fecha=".$row2["fecha"]."&rechazo_delgadas=".$row2[txt_delgadas2]."&rechazo_granuladas=".$row2[txt_granuladas2]."&rechazo_gruesas=".$row2[txt_gruesas2]."&total_recuperado=".$row2[txt_total_recuperado2]."&observacion=".$row2[txt_observacion2]."";
		 }  
		 
		 
      if(($txt_delgadas2 <> '') or ($txt_granuladas2 <> '') or ($txt_gruesas2 <> '') or ($txt_total_recuperado2 <> ''))
			{
		 	$fecha=$ano1."-".$mes1."-".$dia1; 
		 	$actualiza = "UPDATE ref_web.produccion set fecha ='".$fecha."',rechazo_delgadas ='".$txt_delgadas2."', rechazo_granuladas ='".$txt_granuladas2."', rechazo_gruesas ='".$txt_gruesas2."',total_recuperado='".$txt_total_recuperado2."',observacion ='".$txt_observacion2."'";
		 	$actualiza.= "where fecha= '".$fecha."'and cod_grupo='2'";
		 	//echo $actualiza."<br>";
		 	mysqli_query($link, $actualiza);
  	}
		 
		 
			
		 
		 if($row3=mysqli_fetch_array($resultado))
		 {
		 	$fecha = explode("-",$row3["fecha"]);
			$muestra .="fecha=".$row3["fecha"]."&rechazo_delgadas=".$row3[txt_delgadas3]."&rechazo_granuladas=".$row3[txt_granuladas3]."&rechazo_gruesas=".$row3[txt_gruesas3]."&total_recuperado=".$row3[txt_total_recuperado3]."&observacion=".$row3[txt_observacion3]."";		 
		 }
		 
		 
        if(($txt_delgadas3 <> '') or ($txt_granuladas3 <> '') or ($txt_gruesas3 <> '') or ($txt_total_recuperado3 <> ''))
			{
		 	$fecha=$ano1."-".$mes1."-".$dia1; 
		 	$actualiza = "UPDATE ref_web.produccion set fecha ='".$fecha."',rechazo_delgadas ='".$txt_delgadas3."', rechazo_granuladas ='".$txt_granuladas3."', rechazo_gruesas ='".$txt_gruesas3."',total_recuperado='".$txt_total_recuperado3."',observacion ='".$txt_observacion3."'";
		 	$actualiza.= "where fecha= '".$fecha."'and cod_grupo='7'";
		 	//echo $actualiza."<br>";
		 	mysqli_query($link, $actualiza);
            }

			
		 if($row4=mysqli_fetch_array($resultado))
		 {
		 	$fecha = explode("-",$row4["fecha"]);
			$muestra.= "fecha=".$row4["fecha"]."&rechazo_delgadas=".$row4[txt_delgadas4]."&rechazo_granuladas=".$row4[txt_granuladas4]."&rechazo_gruesas=".$row4[txt_gruesas4]."&total_recuperado=".$row4[txt_total_recuperado4]."&observacion=".$row4[txt_observacion4]."";		 
		 }
		 

    		if(($txt_delgadas4 <> '') or ($txt_granuladas4 <> '') or ($txt_gruesas4 <> '') or ($txt_total_recuperado4 <> ''))
			{
		 	$fecha=$ano1."-".$mes1."-".$dia1; 
		 	$actualiza = "UPDATE ref_web.produccion set fecha ='".$fecha."',rechazo_delgadas ='".$txt_delgadas4."', rechazo_granuladas ='".$txt_granuladas4."', rechazo_gruesas ='".$txt_gruesas4."',total_recuperado='".$txt_total_recuperado4."',observacion ='".$txt_observacion4."'";
		 	$actualiza.= "where fecha= '".$fecha."'and cod_grupo='8'";
		 	//echo $actualiza."<br>";
		 	mysqli_query($link, $actualiza);
      }
			
			
			
			$busqueda = "SELECT * FROM ref_web.detalle_produccion WHERE fecha ='".$fecha."'";
			
		 	$resultado = mysqli_query($link, $busqueda);
		 	if($row=mysqli_fetch_array($resultado))
		 	{
		 		$fecha = explode("-",$row["fecha"]);
		    	$muestra.= "fecha=".$row["fecha"]."&stock=".$row[txt_stock]."&lectura_rectificador=".$row[txt_lectura_rectificador]."";
		 	}
		    $fecha=$ano1."-".$mes1."-".$dia1; 
		 	$actualiza = "UPDATE ref_web.detalle_produccion set fecha ='".$fecha."',stock ='".$txt_stock."',lectura_rectificador ='".$txt_lectura_rectificador."'";
		 	$actualiza.= "where fecha= '".$fecha."'";
		 	//echo $actualiza."<br>";
		 	mysqli_query($link, $actualiza);
			
			header("Location:ingreso_hmadres.php?".$muestra);			 
		 }
	  

    $fecha=$ano1."-".$mes1."-".$dia1;
	if ($proceso == "B")
	{
		$consulta = "select * from ref_web.produccion where fecha = '".$fecha."'";
		$consulta .= "order by cod_grupo";
		
        $rs = mysqli_query($link, $consulta);
		if ($row1 =mysqli_fetch_array($rs))
		    {
					$rs = mysqli_query($link, $consulta);
					while ($row1 =mysqli_fetch_array($rs))
					{
						switch ($row1["cod_grupo"])
						{
							case "1":
								$linea = "&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row1["fecha"]."&txt_grupo1=".$row1["cod_grupo"]."&txt_delgadas1=".$row1[rechazo_delgadas]."&txt_granuladas1=".$row1[rechazo_granuladas]."&txt_gruesas1=".$row1[rechazo_gruesas]."&txt_total_recuperado1=".$row1[total_recuperado]."&txt_observacion1=".$row1["observacion"]."";			
								break;
							case "2":
								$linea = $linea."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row1["fecha"]."&txt_grupo2=".$row1["cod_grupo"]."&txt_delgadas2=".$row1[rechazo_delgadas]."&txt_granuladas2=".$row1[rechazo_granuladas]."&txt_gruesas2=".$row1[rechazo_gruesas]."&txt_total_recuperado2=".$row1[total_recuperado]."&txt_observacion2=".$row1["observacion"]."";			
								break;
							case "7":
								$linea = $linea."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row1["fecha"]."&txt_grupo3=".$row1["cod_grupo"]."&txt_delgadas3=".$row1[rechazo_delgadas]."&txt_granuladas3=".$row1[rechazo_granuladas]."&txt_gruesas3=".$row1[rechazo_gruesas]."&txt_total_recuperado3=".$row1[total_recuperado]."&txt_observacion3=".$row1["observacion"]."";			
								break;
							case "8":
								$linea = $linea."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row1["fecha"]."&txt_grupo4=".$row1["cod_grupo"]."&txt_delgadas4=".$row1[rechazo_delgadas]."&txt_granuladas4=".$row1[rechazo_granuladas]."&txt_gruesas4=".$row1[rechazo_gruesas]."&txt_total_recuperado4=".$row1[total_recuperado]."&txt_observacion4=".$row1["observacion"]."";	
								break;	
						}
						//echo  $linea."<br>";
					}
		     }
		else{
		        $insertar1="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)";
		  		$insertar1 = $insertar1."values ('".$fecha."','1','0','0','0','0','0')";
				mysqli_query($link, $insertar1);
				$insertar2="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)";
		  		$insertar2 = $insertar2."values ('".$fecha."','2','0','0','0','0','0')";
		  		mysqli_query($link, $insertar2);
				$insertar3="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)";
		  		$insertar3 = $insertar3."values ('".$fecha."','7','0','0','0','0','0')";
		  		mysqli_query($link, $insertar3);
				$insertar4="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)";
		  		$insertar4 = $insertar4."values ('".$fecha."','8','0','0','0','0','0')";
		  		mysqli_query($link, $insertar4);
				 $insertar5="insert into ref_web.detalle_produccion(fecha,stock,lectura_rectificador)";
				$insertar5 = $insertar5."values ('".$fecha."','0','0')";	
       			 mysqli_query($link, $insertar5);
		
		
		
		     }	 
		/*if ($row1 = mysqli_fetch_array($rs))
        {
	    	$linea = "&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row1["fecha"]."&txt_grupo1=".$row1["cod_grupo"]."&txt_delgadas1=".$row1[rechazo_delgadas]."&txt_granuladas1=".$row1[rechazo_granuladas]."&txt_gruesas1=".$row1[rechazo_gruesas]."&txt_total_recuperado1=".$row1[total_recuperado]."&txt_observacion1=".$row1["observacion"]."";
        }
        if ($row2 = mysqli_fetch_array($rs))
        {
	    	$linea = $linea."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row2["fecha"]."&txt_grupo2=".$row2["cod_grupo"]."&txt_delgadas2=".$row2[rechazo_delgadas]."&txt_granuladas2=".$row2[rechazo_granuladas]."&txt_gruesas2=".$row2[rechazo_gruesas]."&txt_total_recuperado2=".$row2[total_recuperado]."&txt_observacion2=".$row2["observacion"]."";
        }
        if ($row3 = mysqli_fetch_array($rs))
        {
	    	$linea = $linea."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row3["fecha"]."&txt_grupo3=".$row3["cod_grupo"]."&txt_delgadas3=".$row3[rechazo_delgadas]."&txt_granuladas3=".$row3[rechazo_granuladas]."&txt_gruesas3=".$row3[rechazo_gruesas]."&txt_total_recuperado3=".$row3[total_recuperado]."&txt_observacion3=".$row3["observacion"]."";
        }

        if ($row4 = mysqli_fetch_array($rs))
        {
	    	$linea = $linea."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row4["fecha"]."&txt_grupo4=".$row4["cod_grupo"]."&txt_delgadas4=".$row4[rechazo_delgadas]."&txt_granuladas4=".$row4[rechazo_granuladas]."&txt_gruesas4=".$row4[rechazo_gruesas]."&txt_total_recuperado4=".$row4[total_recuperado]."&txt_observacion4=".$row4["observacion"]."";
        }*/


		$consulta = "select * from ref_web.detalle_produccion where fecha = '".$fecha."'";
		//*echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);		
		if ($row = mysqli_fetch_array($rs))
		{	
			$linea = $linea."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row["fecha"]."&txt_stock=".$row[stock]."&txt_lectura_rectificador=".$row[lectura_rectificador]."";
		}
        if($linea<>'')
			{
              header("Location:ingreso_hmadres.php?mostrar=S".$linea);
			}
			else
			{
		      $linea="&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1;
              header("Location:ingreso_hmadres.php?mostrar=S".$linea);
		 	}
		 	
	}
?>
