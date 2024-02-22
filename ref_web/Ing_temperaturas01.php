<?php include("../principal/conectar_ref_web.php");    

	if ($Proceso == "G")
	{   
	
	    if ($inicio1A=='')
	      {
		    $inicio1A=0;
		  }
	    if ($inicio1B=='')
	      {
		    $inicio1B=0;
		  }
		if ($inicio2A=='')
	     {
		   $inicio2A=0;
		 } 
		if ($inicio2B=='')
	      {
		    $inicio2B=0;
		  }
		if ($inicio3A=='')
	      {
		    $inicio3A=0;
		  }
		if ($inicio3B=='')
	      {
		    $inicio3B=0;
		  }
		if ($inicio4A=='')
	      {
		    $inicio4A=0;
		  }
		if ($inicio4B=='')
	      {
		    $inicio4B=0;
		  }
		if ($inicio5A=='')
	      {
		    $inicio5A=0;
		  }
		if ($inicio5B=='')
	      {
		    $inicio5B=0;
		  }
		if ($inicio6A=='')
	      {
		    $inicio6A=0;
		  }
		if ($inicio7A=='')
		    $inicio7A=0;
		if ($inicio7B=='')
		    $inicio7B=0;
		if ($inicioHMA=='')
	      {
		    $inicioHMA=0;
		  }
		if ($inicioHMB=='')
	      {
		    $inicioHMB=0;
		  }
		if ($inicioparcialA=='')
	      {
		    $inicioparcialA=0;
		  }
		if ($inicioparcialB=='')
	      {
		    $inicioparcialB=0;
		  }
		if ($inicio6B=='')
	      {
		    $inicio6B=0;
		  }
		if ($medio1A=='')
	      {
		    $medio1A=0;
		  }
	    if ($medio1B=='')
	      {
		    $medio1B=0;
		  }
		if ($medio2A=='')
	     {
		   $medio2A=0;
		 } 
		if ($medio2B=='')
	      {
		    $medio2B=0;
		  }
		if ($medio3A=='')
	      {
		    $medio3A=0;
		  }
		if ($medio3B=='')
	      {
		    $medio3B=0;
		  }
		if ($medio4A=='')
	      {
		    $medio4A=0;
		  }
		if ($medio4B=='')
	      {
		    $medio4B=0;
		  }
		if ($medio5A=='')
	      {
		    $medio5A=0;
		  }
		if ($medio5B=='')
	      {
		    $medio5B=0;
		  }
		if ($medio6A=='')
	      {
		    $medio6A=0;
		  }
		if ($medio6B=='')
	      {
		    $medio6B=0;
		  }
		if ($medio7A=='')
		    $medio7A=0;
		if ($medio7B=='')
		    $medio7B=0;
		if ($medioHMA=='')
	      {
		    $medioHMA=0;
		  }
		if ($medioHMB=='')
	      {
		    $medioHMB=0;
		  }

		if ($medioparcialA=='')
	      {
		    $medioparcialA=0;
		  }
		if ($medioparcialB=='')
	      {
		    $medioparcialB=0;
		  }

	    if ($fin1A=='')
	      {
		    $fin1A=0;
		  }
	    if ($fin1B=='')
	      {
		    $fin1B=0;
		  }
		if ($fin2A=='')
	     {
		   $fin2A=0;
		 } 
		if ($fin2B=='')
	      {
		    $fin2B=0;
		  }
		if ($fin3A=='')
	      {
		    $fin3A=0;
		  }
		if ($fin3B=='')
	      {
		    $fin3B=0;
		  }
		if ($fin4A=='')
	      {
		    $fin4A=0;
		  }
		if ($fin4B=='')
	      {
		    $fin4B=0;
		  }
		if ($fin5A=='')
	      {
		    $fin5A=0;
		  }
		if ($fin5B=='')
	      {
		    $fin5B=0;
		  }
		if ($fin6A=='')
	      {
		    $fin6A=0;
		  }
		if ($fin7A=='')
		    $fin7A=0;
		if ($fin7B=='')
		    $fin7B=0;
		if ($finHMA=='')
	      {
		    $finHMA=0;
		  }
		if ($finHMB=='')
	      {
		    $finHMB=0;
		  }
		if ($finparcialA=='')
	      {
		    $finparcialA=0;
		  }
		if ($finparcialB=='')
	      {
		    $finparcialB=0;
		  }
		if ($fin6B=='')
	      {
		    $fin6B=0;
		  }
		                                      
		$consulta="select * from ref_web.temperaturas where FECHA='".$fecha."' and TURNO='".$turno."' and INSTANTE='1'";
		//echo $consulta."<br>";
		$respuesta = mysqli_query($link, $consulta);
		if (!$fila1=mysqli_fetch_array($respuesta))  
	      {
		    $Insertar = "INSERT INTO ref_web.temperaturas (FECHA, TURNO, INSTANTE, TEMP1, TEMP2, TEMP3, TEMP4, TEMP5, TEMP6, TEMP7, TEMP8, TEMP9, TEMP10, TEMP11, TEMP12, TEMP13, TEMP14, TEMP15, TEMP16,TEMP17,TEMP18)";
		    $Insertar.= " VALUES ('".$fecha."','".$turno."', '1', '".$inicio1A."', '".$inicio1B."', '".$inicio2A."', '".$inicio2B."','".$inicio3A."','".$inicio3B."','".$inicio4A."','".$inicio4B."','".$inicio5A."','".$inicio5B."','".$inicio6A."','".$inicio6B."'";  
		    $Insertar.= " , '".$inicioHMA."', '".$inicioHMB."', '".$inicioparcialA."', '".$inicioparcialB."','".$inicio7A."','".$inicio7B."')";
		    //echo $Insertar."<br>";
			mysqli_query($link, $Insertar);
		  } 
         else { $actualiza = "UPDATE ref_web.temperaturas set TEMP1 ='".$inicio1A."', TEMP2 ='".$inicio1B."', TEMP3 ='".$inicio2A."',TEMP4 ='".$inicio2B."',";
			    $actualiza.= " TEMP5 = '".$inicio3A."', TEMP6 = '".$inicio3B."', TEMP7 = '".$inicio4A."', TEMP8 = '".$inicio4B."', TEMP9 = '".$inicio5A."', TEMP10 = '".$inicio5B."', TEMP11 = '".$inicio6A."', TEMP12 = '".$inicio6B."', TEMP17= '".$inicio7A."', TEMP18 = '".$inicio7B."', TEMP13 = '".$inicioHMA."', TEMP14 = '".$inicioHMB."', TEMP15 = '".$inicioparcialA."', TEMP16 = '".$inicioparcialB."' where fecha= '".$fecha."' and INSTANTE ='1' and TURNO = '".$turno."'";
		 	    //echo $actualiza."<br>";
			  	mysqli_query($link, $actualiza);
			  } 
		$consulta="select * from ref_web.temperaturas where FECHA='".$fecha."' and TURNO='".$turno."' and INSTANTE='2'";
		//echo $consulta."<br>";
		$respuesta = mysqli_query($link, $consulta);
		if (!$fila1=mysqli_fetch_array($respuesta))  
	      {
		    $Insertar = "INSERT INTO ref_web.temperaturas (FECHA, TURNO, INSTANTE, TEMP1, TEMP2, TEMP3, TEMP4, TEMP5, TEMP6, TEMP7, TEMP8, TEMP9, TEMP10, TEMP11, TEMP12, TEMP13, TEMP14, TEMP15, TEMP16, TEMP17, TEMP18)";
		    $Insertar.= " VALUES ('".$fecha."','".$turno."', '2', '".$medio1A."', '".$medio1B."', '".$medio2A."', '".$medio2B."','".$medio3A."','".$medio3B."','".$medio4A."','".$medio4B."','".$medio5A."','".$medio5B."','".$medio6A."','".$medio6B."'";  
		    $Insertar.= " , '".$medioHMA."', '".$medioHMB."', '".$medioparcialA."', '".$medioparcialB."','".$medio7A."','".$medio7B."')";
		    //echo $Insertar."<br>";
			mysqli_query($link, $Insertar);
		  } 
         else { $actualiza = "UPDATE ref_web.temperaturas set TEMP1 ='".$medio1A."', TEMP2 ='".$medio1B."', TEMP3 ='".$medio2A."',TEMP4 ='".$medio2B."',";
			    $actualiza.= " TEMP5 = '".$medio3A."', TEMP6 = '".$medio3B."', TEMP7 = '".$medio4A."', TEMP8 = '".$medio4B."', TEMP9 = '".$medio5A."', TEMP10 = '".$medio5B."', TEMP11 = '".$medio6A."', TEMP12 = '".$medio6B."', TEMP17 = '".$medio7A."', TEMP18 = '".$medio7B."', TEMP13 = '".$medioHMA."', TEMP14 = '".$medioHMB."', TEMP15 = '".$medioparcialA."', TEMP16 = '".$medioparcialB."' where fecha= '".$fecha."' and INSTANTE ='2' and TURNO = '".$turno."'";
		 	    //echo $actualiza."<br>";
			  	mysqli_query($link, $actualiza);
			  } 	  
       $consulta="select * from ref_web.temperaturas where FECHA='".$fecha."' and TURNO='".$turno."' and INSTANTE='3'";
		//echo $consulta."<br>";
		$respuesta = mysqli_query($link, $consulta);
		if (!$fila1=mysqli_fetch_array($respuesta))  
	      {
		    $Insertar = "INSERT INTO ref_web.temperaturas (FECHA, TURNO, INSTANTE, TEMP1, TEMP2, TEMP3, TEMP4, TEMP5, TEMP6, TEMP7, TEMP8, TEMP9, TEMP10, TEMP11, TEMP12, TEMP13, TEMP14, TEMP15, TEMP16,TEMP17,TEMP18)";
		    $Insertar.= " VALUES ('".$fecha."','".$turno."', '3', '".$fin1A."', '".$fin1B."', '".$fin2A."', '".$fin2B."','".$fin3A."','".$fin3B."','".$fin4A."','".$fin4B."','".$fin5A."','".$fin5B."','".$fin6A."','".$fin6B."'";  
		    $Insertar.= " , '".$finHMA."', '".$finHMB."', '".$finparcialA."', '".$finparcialB."','".$fin7A."','".$fin7B."')";
		    //echo $Insertar."<br>";
			mysqli_query($link, $Insertar);
		  } 
         else { $actualiza = "UPDATE ref_web.temperaturas set TEMP1 ='".$fin1A."', TEMP2 ='".$fin1B."', TEMP3 ='".$fin2A."',TEMP4 ='".$fin2B."',";
			    $actualiza.= " TEMP5 = '".$fin3A."', TEMP6 = '".$fin3B."', TEMP7 = '".$fin4A."', TEMP8 = '".$fin4B."', TEMP9 = '".$fin5A."', TEMP10 = '".$fin5B."', TEMP11 = '".$fin6A."', TEMP12 = '".$fin6B."', TEMP13 = '".$finHMA."', TEMP14 = '".$finHMB."', TEMP15 = '".$finparcialA."', TEMP16 = '".$finparcialB."',TEMP17='".$fin7A."',TEMP18='".$fin7B."' where fecha= '".$fecha."' and INSTANTE ='3' and TURNO = '".$turno."'";
		 	    //echo $actualiza."<br>";
			  	mysqli_query($link, $actualiza);
			  } 
	       
      $fecha=ltrim($fecha);
	  header("location:Ing_temperaturas.php?fecha=$fecha");
		 
	}


?> 
