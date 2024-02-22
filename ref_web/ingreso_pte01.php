<?php
	 include("../principal/conectar_ref_web.php");
	 if ($proceso == "G")
	 {
	 $fecha=$ano1."-".$mes1."-".$dia1;
	 $consulta = "SELECT * FROM circulacion_electrolito.pte WHERE  fecha='".$fecha."'"; 
	 $respuesta =mysqli_query($link, $consulta);
	 if ($fila=mysqli_fetch_array($respuesta)) 
	 {
	   $Mensaje="El registro ya existe, intente nuevamente...";
	    header("Location:ingreso_pte.php?Mensaje=".$Mensaje);
	 }
	 else	
	 {
	 $insertar="insert into circulacion_electrolito.pte(fecha,turno,reactores,sulfato_cobre,arseniato_ferico,sales_niquel) values ('".$fecha."','".$txt_turno."','".$txt_reactores."','".$txt_sulfato_cobre."','".$txt_arseniato_ferico."','".$txt_sales_niquel."')";
	 //*echo $insertar."<br>";
	 mysqli_query($link, $insertar);
	 header("Location:ingreso_pte.php");
	 }
	} 
	
	 $fecha=$ano1."-".$mes1."-".$dia1; 
	 if ($proceso == "M") 
	 {	 
		 $busqueda = "SELECT * FROM circulacion_electrolito.pte WHERE fecha ='".$fecha."'";
		 //*echo $busqueda. "<br>";
		 $resultado = mysqli_query($link, $busqueda);
		 if($row=mysqli_fetch_array($resultado))
		 {
		 $fecha = explode("-",$row["fecha"]);
		 $muestra = "fecha=".$row["fecha"]."&turno=".$row[txt_turno]."&reactores=".$row[txt_reactores]."&sulfato_cobre=".$row[txt_sulfato_cobre]."&arsenitato_ferico=".$row[txt_arseniato_ferico]."&sales_niquel=".$row[txt_sales_niquel]."";
		 }
		 
		 $fecha=$ano1."-".$mes1."-".$dia1; 
		 $actualiza = "UPDATE circulacion_electrolito.pte set fecha ='".$fecha."', turno ='".$txt_turno."', reactores ='".$txt_reactores."', sulfato_cobre ='".$txt_sulfato_cobre."', arseniato_ferico ='".$txt_arseniato_ferico."',sales_niquel ='".$txt_sales_niquel."'";
		 $actualiza.= "where fecha= '".$fecha."'";
		 //*echo $actualiza."<br>";
		 mysqli_query($link, $actualiza);
		 header("Location:ingreso_pte.php?".$muestra);
	
	}
	
	
	if ($proceso == "B")
	{
		$consulta = "select * from circulacion_electrolito.pte where fecha = '".$fecha."'";
		//*echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
	    	$linea = "mostrar=S&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row["fecha"]."&txt_turno=".$row[turno]."&txt_reactores=".$row[reactores]."&txt_sulfato_cobre=".$row[sulfato_cobre]."&txt_arseniato_ferico=".$row[arseniato_ferico]."&txt_sales_niquel=".$row[sales_niquel]."";		}
		 header("Location:ingreso_pte.php?".$linea);
	}
?>