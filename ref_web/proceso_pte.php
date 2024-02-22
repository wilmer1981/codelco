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
	 $consulta = "SELECT * FROM ref_web.pte WHERE  fecha='".$fecha."' and turno='A'";
	 $consulta .="order by turno";
	// echo $consulta;
	 $respuesta =mysqli_query($link, $consulta);
     if ($row1=mysqli_fetch_array($respuesta))
	 {
	   $Mensaje="El registro ya existe.";
       header("Location:ingreso_pte.php?Mensaje=".$Mensaje);
	 }
	 else
	 {
      if(($txt_reactores1 <> '') or ($txt_sulfato_cobre1 <> '') or ($txt_arseniato_ferico1 <> '') or ($txt_sales_niquel1 <> ''))
	   	{
		  $insertar1="insert into ref_web.pte(fecha,turno,reactores,sulfato_cobre,arseniato_ferico,sales_niquel,observacion)";
		  $insertar1 = $insertar1."values ('".$fecha."','".$txt_turno1."','".$txt_reactores1."','".$txt_sulfato_cobre1."','".$txt_arseniato_ferico1."','".$txt_sales_niquel1."','".$txt_observacion1."')";
		  mysqli_query($link, $insertar1);
		}

        }

        $consulta = "SELECT * FROM ref_web.pte WHERE  fecha='".$fecha."' and turno='B'";
		$consulta .="order by turno";
		$respuesta =mysqli_query($link, $consulta);
		if ($row1=mysqli_fetch_array($respuesta))
		{
			$Mensaje="El registro ya existe.";
        }
		 else
		 {
	    if(($txt_reactores2 <> '') or ($txt_sulfato_cobre2 <> '') or ($txt_arseniato_ferico2 <> '') or ($txt_sales_niquel2 <> ''))
	   	{
		  $insertar2="insert into ref_web.pte(fecha,turno,reactores,sulfato_cobre,arseniato_ferico,sales_niquel,observacion)";
		  $insertar2 = $insertar2."values ('".$fecha."','".$txt_turno2."','".$txt_reactores2."','".$txt_sulfato_cobre2."','".$txt_arseniato_ferico2."','".$txt_sales_niquel2."','".$txt_observacion2."')";
		  mysqli_query($link, $insertar2);
		}
     	}

  		$consulta = "SELECT * FROM ref_web.pte WHERE  fecha='".$fecha."' and turno='C'";
		$consulta .="order by turno";
		$respuesta =mysqli_query($link, $consulta);
		if ($row1=mysqli_fetch_array($respuesta))
		{
			$Mensaje="El registro ya existe.";
     }
		else
	    {
        if(($txt_reactores3 <> '') or ($txt_sulfato_cobre3 <> '') or ($txt_arseniato_ferico3 <> '') or ($txt_sales_niquel3 <> ''))
	   	{
		  $insertar3="insert into ref_web.pte(fecha,turno,reactores,sulfato_cobre,arseniato_ferico,sales_niquel,observacion)";
		  $insertar3 = $insertar3."values ('".$fecha."','".$txt_turno3."','".$txt_reactores3."','".$txt_sulfato_cobre3."','".$txt_arseniato_ferico3."','".$txt_sales_niquel1."','".$txt_observacion1."')";
		  mysqli_query($link, $insertar3);
		}
		}
        if (isset($Mensaje))
		{
			header("location:ingreso_pte.php?Mensaje=".$Mensaje);
		}
		else
		{
			header("location:ingreso_pte.php");
		}

	 }



     if ($proceso == "M")
	 {
	    /* $fecha=$ano1."-".$mes1."-".$dia1;*/
		 $busqueda = "SELECT * FROM ref_web.pte WHERE fecha ='".$fecha."' ";
		 $resultado = mysqli_query($link, $busqueda);
		 while ($row1=mysqli_fetch_array($resultado))
		 {
		 	$fecha = explode("-",$row1["fecha"]);
		    $muestra = "&reactores=".$row1[txt_reactores1]."&sulfato_cobre=".$row1[txt_sulfato_cobre1]."&arseniato_ferico=".$row1[txt_arseniato_ferico1]."&sales_niquel=".$row1[txt_sales_niquel1]."&observacion=".$row1[txt_observacion1]."";
		 }

        if(($txt_reactores1 <> '') or ($txt_sulfato_cobre1 <> '') or ($txt_arseniato_ferico1 <> '') or ($txt_sales_niquel1 <> ''))
			{
		    $fecha=$ano1."-".$mes1."-".$dia1;
		 	$actualiza = "UPDATE ref_web.pte set reactores ='".$txt_reactores1."', sulfato_cobre ='".$txt_sulfato_cobre1."', arseniato_ferico ='".$txt_arseniato_ferico1."',sales_niquel='".$txt_sales_niquel1."',observacion ='".$txt_observacion1."' ";
			//echo $actualiza;
		 	$actualiza.= "where fecha= '".$fecha."' and turno='A'";
		 //	echo $actualiza."<br>";
			//}
		 	mysqli_query($link, $actualiza);
            }
        if ($row2=mysqli_fetch_array($resultado))
		 {
		 	$fecha = explode("-",$row2["fecha"]);
		    $muestra = "&reactores=".$row2[txt_reactores2]."&sulfato_cobre=".$row2[txt_sulfato_cobre2]."&arseniato_ferico=".$row2[txt_arseniato_ferico2]."&sales_niquel=".$row2[txt_sales_niquel2]."&observacion=".$row1[txt_observacion2]."";
		 }

        if(($txt_reactores2 <> '') or ($txt_sulfato_cobre2 <> '') or ($txt_arseniato_ferico2 <> '') or ($txt_sales_niquel2 <> ''))
			{
		    $fecha=$ano1."-".$mes1."-".$dia1;
		 	$actualiza = "UPDATE ref_web.pte set reactores ='".$txt_reactores2."', sulfato_cobre ='".$txt_sulfato_cobre2."', arseniato_ferico ='".$txt_arseniato_ferico2."',sales_niquel='".$txt_sales_niquel2."',observacion ='".$txt_observacion2."'";
			//echo $actualiza;
		 	$actualiza.= "where fecha= '".$fecha."' and turno='B'";
		 	//*echo $actualiza."<br>";
			//}
		 	mysqli_query($link, $actualiza);
            }




        if ($row3=mysqli_fetch_array($resultado))
		 {
		 	$fecha = explode("-",$row3["fecha"]);
		    $muestra = "&reactores=".$row3[txt_reactores3]."&sulfato_cobre=".$row3[txt_sulfato_cobre3]."&arseniato_ferico=".$row3[txt_arseniato_ferico3]."&sales_niquel=".$row3[txt_sales_niquel3]."&observacion=".$row3[txt_observacion3]."";
		 }

        if(($txt_reactores3 <> '') or ($txt_sulfato_cobre3 <> '') or ($txt_arseniato_ferico3 <> '') or ($txt_sales_niquel3 <> ''))
			{
		    $fecha=$ano1."-".$mes1."-".$dia1;
		 	$actualiza = "UPDATE ref_web.pte set reactores ='".$txt_reactores3."', sulfato_cobre ='".$txt_sulfato_cobre3."', arseniato_ferico ='".$txt_arseniato_ferico3."',sales_niquel='".$txt_sales_niquel3."',observacion ='".$txt_observacion3."'";
			//echo $actualiza;
		 	$actualiza.= "where fecha= '".$fecha."' and turno='C'";
		 	//*echo $actualiza."<br>";
			//}
		 	mysqli_query($link, $actualiza);
            }
			header("Location:ingreso_pte.php?mostrar=S&fecha=$fecha&entrar=S");
		 }


    $fecha=$ano1."-".$mes1."-".$dia1;
	if ($proceso == "B")
	{
		$consulta = "select * from ref_web.pte where fecha = '".$fecha."' ";
		$consulta .= "order by turno";
		$rs = mysqli_query($link, $consulta);
		//echo $consulta;
			if ($row1 =mysqli_fetch_array($rs))
		    {		
				$rs = mysqli_query($link, $consulta);
				while ($row1 =mysqli_fetch_array($rs))
				{
					switch ($row1[turno])
					{
						case "A":
							$linea = "&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row1["fecha"]."&txt_turno1=".$row1[turno]."&txt_reactores1=".$row1[reactores]."&txt_sulfato_cobre1=".$row1[sulfato_cobre]."&txt_arseniato_ferico1=".$row1[arseniato_ferico]."&txt_sales_niquel1=".$row1[sales_niquel]."&txt_observacion1=".$row1["observacion"]."";
							break;
						case "B":
							$linea.= "&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row1["fecha"]."&txt_turno2=".$row1[turno]."&txt_reactores2=".$row1[reactores]."&txt_sulfato_cobre2=".$row1[sulfato_cobre]."&txt_arseniato_ferico2=".$row1[arseniato_ferico]."&txt_sales_niquel2=".$row1[sales_niquel]."&txt_observacion2=".$row1["observacion"]."";
							break;
						case "C":
							$linea.= "&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row1["fecha"]."&txt_turno3=".$row1[turno]."&txt_reactores3=".$row1[reactores]."&txt_sulfato_cobre3=".$row1[sulfato_cobre]."&txt_arseniato_ferico3=".$row1[arseniato_ferico]."&txt_sales_niquel3=".$row1[sales_niquel]."&txt_observacion3=".$row1["observacion"]."";
							break;
						
					}
				 }
			}
				
	       else
		      {
	            $insertar1="insert into ref_web.pte(fecha,turno,reactores,sulfato_cobre,arseniato_ferico,sales_niquel,observacion)"; 
  			    $insertar1 = $insertar1."values ('".$fecha."','A','0','0','0','0','0')";
                mysqli_query($link, $insertar1);
  				$insertar2="insert into ref_web.pte(fecha,turno,reactores,sulfato_cobre,arseniato_ferico,sales_niquel,observacion)"; 
  				$insertar2 = $insertar2."values ('".$fecha."','B','0','0','0','0','0')";
  				mysqli_query($link, $insertar2);
  				$insertar3="insert into ref_web.pte(fecha,turno,reactores,sulfato_cobre,arseniato_ferico,sales_niquel,observacion)"; 
  				$insertar3 = $insertar3."values ('".$fecha."','C','0','0','0','0','0')";
  				mysqli_query($link, $insertar3);
    		  }	 
		
        if($linea<>'')
			{
              header("location:ingreso_pte.php?mostrar=S".$linea);
			}
			else
			{
		      $linea="&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1;
              header("location:ingreso_pte.php?mostrar=S".$linea);
		 	}
	}		
?>