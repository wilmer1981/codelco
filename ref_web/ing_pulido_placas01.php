<?php
include("../principal/conectar_ref_web.php"); 

$sqls = "select * from ref_web.pulido_placas WHERE FECHA = '$fecha' AND TURNO = '$turno'";
$results=mysqli_query($link, $sqls);
$num = mysqli_num_rows($results);


	if ($Proceso == "G")
	{  
		$Insertar1 = "INSERT INTO ref_web.pulido_placas (FECHA,TURNO,COD_OPERACION, PLACAS_NEGRAS, PLACAS_PERNOS)";
		$Insertar1.= " VALUES ('".$fecha."','".$turno."','1','".$arman1."', '".$arman2."')";
        mysqli_query($link, $Insertar1);
		//echo $Insertar1."<br>";
		$Insertar2 = "INSERT INTO ref_web.pulido_placas (FECHA,TURNO,COD_OPERACION, PLACAS_NEGRAS, PLACAS_PERNOS)";
		$Insertar2.= " VALUES ('".$fecha."','".$turno."','2','".$cambian1."', '".$cambian2."')";
		//echo $Insertar2."<br>";
        mysqli_query($link, $Insertar2);
		$Insertar3 = "INSERT INTO ref_web.pulido_placas (FECHA,TURNO,COD_OPERACION, PLACAS_NEGRAS, PLACAS_PERNOS)";
		$Insertar3.= " VALUES ('".$fecha."','".$turno."','3','".$stock1."', '".$stock2."')";
        //echo $Insertar3."<br>";
		mysqli_query($link, $Insertar3);
		
		header ("location:Ing_pulido_placas.php?fecha=$fecha");
	}
	if ($Proceso == "E")
	{
		$Eliminar = "DELETE FROM ref_web.pulido_placas WHERE FECHA = '".$fecha."' and TURNO='".$turno."' and COD_OPERACION='".$cod_operacion."'";
		//echo $Eliminar;
		 mysqli_query($link, $Eliminar);
		header ("location:pulido_placas.php?fecha=$fecha");
	}	   
    if ($Proceso == "M")
   {
					$Actualizar1 = " UPDATE ref_web.pulido_placas SET ";
					$Actualizar1.= " PLACAS_NEGRAS = '".$arman1."', ";
					$Actualizar1.= " PLACAS_PERNOS = '".$arman2."', ";
					$Actualizar1.= " TURNO = '".$turno."' ";
					$Actualizar1.= " WHERE COD_OPERACION = '1' AND FECHA = '$fecha' AND  TURNO = '$turno' ";
					mysqli_query($link, $Actualizar1);

					$Actualizar2 = " UPDATE ref_web.pulido_placas SET ";
					$Actualizar2.= " PLACAS_NEGRAS = '".$cambian1."', ";
					$Actualizar2.= " PLACAS_PERNOS = '".$cambian2."', ";
					$Actualizar2.= " TURNO = '".$turno."' ";
					$Actualizar2.= " WHERE COD_OPERACION = '2' AND FECHA = '$fecha' AND  TURNO = '$turno' ";
					mysqli_query($link, $Actualizar2);

					$Actualizar3 = " UPDATE ref_web.pulido_placas SET ";
					$Actualizar3.= " PLACAS_NEGRAS = '".$stock1."', ";
					$Actualizar3.= " PLACAS_PERNOS = '".$stock2."', ";
					$Actualizar3.= " TURNO = '".$turno."' ";
					$Actualizar3.= " WHERE COD_OPERACION = '3' AND FECHA = '$fecha' AND  TURNO = '$turno' ";
					mysqli_query($link, $Actualizar3);

		      header ("location:pulido_placas.php?fecha=$fecha");

         }

?> 
