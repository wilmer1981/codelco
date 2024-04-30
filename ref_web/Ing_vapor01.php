<?php include("../principal/conectar_ref_web.php");  
 $Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
 $fecha     = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";  
 $turno     = isset($_REQUEST["turno"])?$_REQUEST["turno"]:"";

	if ($Proceso == "G")
	{   
	    if ($temp1=='')
	      {
		    $temp1=0;
		  }
	    if ($temp2=='')
	      {
		    $temp2=0;
		  }
		if ($temp3=='')
	      {
		    $temp3=0;
		  }
		if ($temp4=='')
	      {
		    $temp4=0;
		  }
		if ($presion1=='')
	      {
		    $presion1=0;
		  }   
		if ($presion2=='')
	      {
		    $presion2=0;
		  }   
		if ($presion3=='')
	      {
		    $presion3=0;
		  }   
		if ($presion4=='')
	      {
		    $presion4=0;
		  }
		  if ($temp5=='')
	      {
		    $temp5=0;
		  }
	    if ($temp6=='')
	      {
		    $temp6=0;
		  }
		if ($temp7=='')
	      {
		    $temp7=0;
		  }
		if ($temp8=='')
	      {
		    $temp8=0;
		  }
		if ($presion5=='')
	      {
		    $presion5=0;
		  }   
		if ($presion6=='')
	      {
		    $presion6=0;
		  }   
		if ($presion7=='')
	      {
		    $presion7=0;
		  }   
		if ($presion8=='')
	      {
		    $presion8=0;
		  }
		  if ($temp9=='')
	      {
		    $temp9=0;
		  }
	    if ($temp10=='')
	      {
		    $temp10=0;
		  }
		if ($temp11=='')
	      {
		    $temp11=0;
		  }
		if ($temp12=='')
	      {
		    $temp12=0;
		  }
		if ($presion9=='')
	      {
		    $presion9=0;
		  }   
		if ($presion10=='')
	      {
		    $presion10=0;
		  }   
		if ($presion11=='')
	      {
		    $presion11=0;
		  }   
		if ($presion12=='')
	      {
		    $presion12=0;
		  }          
		if ($presion13=='')
	      {
		    $presion13=0;
		  }          
		if ($presion14=='')
	      {
		    $presion14=0;
		  }          
		if ($presion15=='')
	      {
		    $presion15=0;
		  }          


		$consulta="select * from ref_web.vapor where FECHA='".$fecha."' and TURNO='".$turno."' and INSTANTE='1'";
		//echo $consulta."<br>";
		$respuesta = mysqli_query($link, $consulta);
		if (!$fila1=mysqli_fetch_array($respuesta))  
	      {
		    $Insertar = "INSERT INTO ref_web.vapor (FECHA, TURNO, INSTANTE, TEMP1, TEMP2, TEMP3, TEMP4, TEMP5,PRE1, PRE2, PRE3, PRE4, PRE5)";
		    $Insertar.= " VALUES ('".$fecha."','".$turno."', '1', '".$temp1."', '".$temp2."', '".$temp3."', '".$temp4."', '".$temp13."' ";  
		    $Insertar.= " , '".$presion1."', '".$presion2."', '".$presion3."', '".$presion4."', '".$presion13."')";
		    //echo $Insertar."<br>";
			mysqli_query($link, $Insertar);
		  } 
         else { $actualiza = "UPDATE ref_web.vapor set TEMP1 ='".$temp1."', TEMP2 ='".$temp2."', TEMP3 ='".$temp3."',TEMP4 ='".$temp4."',TEMP5 ='".$temp13."',";
			    $actualiza.= " PRE1 = '".$presion1."', PRE2 = '".$presion2."', PRE3 = '".$presion3."', PRE4 = '".$presion4."', PRE5 = '".$presion13."' where fecha= '".$fecha."' and INSTANTE ='1' and TURNO = '".$turno."'";
		 	    //echo $actualiza."<br>";
			  	mysqli_query($link, $actualiza);
			  } 
      
	    $consulta="select * from ref_web.vapor where FECHA='".$fecha."' and TURNO='".$turno."' and INSTANTE='2'";
		//echo $consulta."<br>";
		$respuesta = mysqli_query($link, $consulta);
		if (!$fila1=mysqli_fetch_array($respuesta))  
	      {
		   $Insertar = "INSERT INTO ref_web.vapor (FECHA, TURNO, INSTANTE, TEMP1, TEMP2, TEMP3, TEMP4,TEMP5, PRE1, PRE2, PRE3, PRE4, PRE5)";
		   $Insertar.= " VALUES ('".$fecha."','".$turno."', '2', '".$temp5."', '".$temp6."', '".$temp7."', '".$temp8."', '".$temp14."' ";  
		   $Insertar.= " , '".$presion5."', '".$presion6."', '".$presion7."', '".$presion8."', '".$presion14."')";
		   //echo $Insertar;
           mysqli_query($link, $Insertar);
		  }
		 else { $actualiza = "UPDATE ref_web.vapor set TEMP1 ='".$temp5."', TEMP2 ='".$temp6."', TEMP3 ='".$temp7."',TEMP4 ='".$temp8."',TEMP5 ='".$temp14."',";
			    $actualiza.= " PRE1 = '".$presion5."', PRE2 = '".$presion6."', PRE3 = '".$presion7."', PRE4 = '".$presion8."', PRE5 = '".$presion14."' where fecha= '".$fecha."' and INSTANTE ='2' and TURNO = '".$turno."'";
		 	    //echo $actualiza."<br>";
			  	mysqli_query($link, $actualiza);
			  }   
		  
		   
	    $consulta="select * from ref_web.vapor where FECHA='".$fecha."' and TURNO='".$turno."' and INSTANTE='3'";
		//echo $consulta."<br>";
		$respuesta = mysqli_query($link, $consulta);
		if (!$fila1=mysqli_fetch_array($respuesta))  
	      {
		   $Insertar = "INSERT INTO ref_web.vapor (FECHA, TURNO, INSTANTE, TEMP1, TEMP2, TEMP3, TEMP4, TEMP5, PRE1, PRE2, PRE3, PRE4, PRE5)";
		   $Insertar.= " VALUES ('".$fecha."','".$turno."', '3', '".$temp9."', '".$temp10."', '".$temp11."', '".$temp12."', '".$temp15."' ";  
		   $Insertar.= " , '".$presion9."', '".$presion10."', '".$presion11."', '".$presion12."', '".$presion15."')";
		   //echo $Insertar;
           mysqli_query($link, $Insertar);
		  }
		else { $actualiza = "UPDATE ref_web.vapor set TEMP1 ='".$temp9."', TEMP2 ='".$temp10."', TEMP3 ='".$temp11."',TEMP4 ='".$temp12."',TEMP5 ='".$temp15."',";
			    $actualiza.= " PRE1 = '".$presion9."', PRE2 = '".$presion10."', PRE3 = '".$presion11."', PRE4 = '".$presion12."', PRE5 = '".$presion15."' where fecha= '".$fecha."' and INSTANTE ='3' and TURNO = '".$turno."'";
		 	    //echo $actualiza."<br>";
			  	mysqli_query($link, $actualiza);
			  }   
      $fecha=ltrim($fecha);
	  header("location:Ing_vapor.php?fecha=$fecha");
		 
	}


?> 
