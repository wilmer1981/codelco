<?php
	 include("../principal/conectar_ref_web.php");
	 if ($proceso == "G")
	 {
	 $fecha=$ano1."-".$mes1."-".$dia1;
	 $consulta = "SELECT * FROM ref_web.iniciales WHERE  fecha='".$fecha."'"; 
	 $respuesta =mysqli_query($link, $consulta);
	 if ($fila=mysqli_fetch_array($respuesta)) 
	 {
	   $Mensaje="El registro ya existe, intente nuevamente...";
	    header("Location:ingreso_cat_ini.php?Mensaje=".$Mensaje);
	 }
	 else	
	 {
	 $insertar="insert into ref_web.iniciales(fecha,turno,produccion_mfci,produccion_mdb,produccion_mco,consumo,observacion,stock,rechazo_cat_ini) values ('".$fecha."','".$txt_turno."','".$txt_produccion_mfci."','".$txt_produccion_mdb."','".$txt_produccion_mco."','".$txt_consumo."','".$txt_observacion."','".$txt_stock."','".$txt_rechazo_cat_ini."')";
	 //*echo $insertar."<br>";
	 mysqli_query($link, $insertar);
	 header("Location:ingreso_cat_ini.php");
	 }
	} 
	
	 $fecha=$ano1."-".$mes1."-".$dia1; 
	 if ($proceso == "M") 
	 {	 
		 $busqueda = "SELECT * FROM ref_web.iniciales WHERE fecha ='".$fecha."'";
		 //*echo $busqueda. "<br>";
		 $resultado = mysqli_query($link, $busqueda);
		 if($row=mysqli_fetch_array($resultado))
		 {
		 $fecha = explode("-",$row["fecha"]);
		 $muestra = "fecha=".$row["fecha"]."&turno=".$row[txt_turno]."&produccion_mfci=".$row[txt_produccion_mfci]."&produccion_mdb=".$row[txt_produccion_mdb]."&produccion_mco=".$row[txt_produccion_mco]."&consumo=".$row[txt_consumo]."&observacion=".$row[txt_observacion]."&stock=".$row[txt_stock]."&rechazo_cat_ini=".$row[txt_rechazo_cat_ini]."";
		 }
		 
		 $fecha=$ano1."-".$mes1."-".$dia1; 
		 $actualiza = "UPDATE ref_web.iniciales set fecha ='".$fecha."', turno ='".$txt_turno."', produccion_mfci ='".$txt_produccion_mfci."', produccion_mdb ='".$txt_produccion_mdb."', produccion_mco ='".$txt_produccion_mco."',consumo ='".$txt_consumo."',observacion ='".$txt_observacion."',stock ='".$txt_stock."',rechazo_cat_ini ='".$txt_rechazo_cat_ini."'";
		 $actualiza.= "where fecha= '".$fecha."'";
		 //*echo $actualiza."<br>";
		 mysqli_query($link, $actualiza);
		 header("Location:popup_catodos_iniciales.php?".$muestra);

		 /*while($row= mysqli_fetch_array($acuatliza))
		  {	  
		  $fecha = .$row["fecha"].;
		  $txt_gru = .$row["grupo"].;
		  $txt_rech_del = .$row[rechazo_delgadas].;
		  $txt_rech_gra = .$row[rechazo_granuladas].;
		  $txt_rech_gru = .$row[rechazo_gruesas].;
		  $txt_total_recu = .$row[total_recuperado].;
		 
		  mysql_free_actualiza($actualiza);*/
		 // header("Location:ingreso_cat_ini.php");	  
	}
	
	
	if ($proceso == "B")
	{
		$consulta = "select * from ref_web.iniciales where fecha = '".$fecha."'";
		//*echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
	    	$linea = "mostrar=S&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row["fecha"]."&txt_turno=".$row[turno]."&txt_produccion_mfci=".$row[produccion_mfci]."&txt_produccion_mdb=".$row[produccion_mdb]."&txt_produccion_mco=".$row[produccion_mco]."&txt_consumo=".$row[consumo]."&txt_observacion=".$row["observacion"]."&txt_stock=".$row[stock]."&txt_rechazo_cat_ini=".$row[rechazo_cat_ini]."";
		}
		 header("Location:popup_catodos_iniciales.php?".$linea);
	}
?>