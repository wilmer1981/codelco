<?php
	include("../principal/conectar_ref_web.php");
	if ($proceso == "G")
 	{
     $fecha = $ano1.'-'.$mes1.'-'.$dia1;
     $consulta = "SELECT * FROM ref_web.produccion WHERE  fecha='".$fecha."'";
     $respuesta=mysqli_query($link, $consulta);
	 if ($fila=mysqli_fetch_array($respuesta))
     {   
		$Mensaje="El registro ya existe, intente nuevamente...";
		header("Location:ingreso_hojas_madres.php?Mensaje=".$Mensaje);
	 }
	 else
	 {
		 $insertar="insert into ref_web.produccion(fecha,grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,stock,peso_promedio,kah_promedio,observacion) values ('".$fecha."','".$txt_gru."','".$txt_rech_del."','".$txt_rech_gra."','".$txt_rech_gru."','".$txt_total_recu."','".$txt_stock."','".$txt_peso_promedio."','".$txt_kah_promedio."','".$txt_observacion."')";
		 mysqli_query($link, $insertar);
		 header("Location:ingreso_hojas_madres.php");
	 }
	}
	
	$fecha=$ano1."-".$mes1."-".$dia1; 

	 if ($proceso == "M") 
	 {	 
		 $busqueda = "SELECT * FROM ref_web.produccion WHERE fecha ='".$fecha."'";
		 //*echo $busqueda. "<br>";
		 $resultado = mysqli_query($link, $busqueda);
		 while ($row=mysqli_fetch_array($resultado))
		 {
		 $fecha = explode("-",$row["fecha"]);
		 $muestra = "fecha=".$row["fecha"]."&grupo=".$row[txt_gru]."&rechazo_delgadas=".$row[txt_rech_del]."&rechazo_granuladas=".$row[txt_rech_gra]."&rechazo_gruesas=".$row[txt_rech_gru]."&total_recuperado=".$row[txt_total_recuperado]."&stock=".$row[stock]."&peso_promedio=".$row[peso_promedio]."&kah_promedio=".$row[kah_promedio]."&observacion=".$row["observacion"]."";
		 //echo $muestra. "<br>";
		 header("Location:popup_hoja_madre.php?" .$muestra);
		 }
		 
		 $fecha=$ano1."-".$mes1."-".$dia1; 
		 $actualiza = "UPDATE ref_web.produccion set fecha= '".$fecha."', grupo='".$txt_gru."', rechazo_delgadas='".$txt_rech_del."', rechazo_granuladas='".$txt_rech_gra."', rechazo_gruesas='".$txt_rech_gru."', total_recuperado='".$txt_total_recu."', stock='".$txt_stock."', peso_promedio='".$txt_peso_promedio."', kah_promedio='".$txt_kah_promedio."',observacion='".$txt_observacion."'";
		 $actualiza.= " where fecha= '".$fecha."'";
		 //*echo $actualiza."<br>";
		 mysqli_query($link, $actualiza);
		 /*while($row= mysqli_fetch_array($acuatliza))
		  {	  
		  $fecha = .$row["fecha"].;
		  $txt_gru = .$row["grupo"].;
		  $txt_rech_del = .$row[rechazo_delgadas].;
		  $txt_rech_gra = .$row[rechazo_granuladas].;
		  $txt_rech_gru = .$row[rechazo_gruesas].;
		  $txt_total_recu = .$row[total_recuperado].;
		 
		  mysql_free_actualiza($actualiza);*/
		  header("Location:popup_hoja_madre.php?");	  
	}
	
	
	if ($proceso == "B")
	{
		$consulta = "select * from  ref_web.produccion where fecha = '".$fecha."'";
		//*echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$linea = "mostrar=S&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."fecha=".$row["fecha"]."&txt_gru=".$row["grupo"]."&txt_rech_del=".$row[rechazo_delgadas]."&txt_rech_gra=".$row[rechazo_granuladas]."&txt_rech_gru=".$row[rechazo_gruesas]."&txt_total_recu=".$row[total_recuperado]."&txt_stock=".$row[stock]."&txt_peso_promedio=".$row[peso_promedio]."&txt_kah_promedio=".$row[kah_promedio]."&txt_observacion=".$row["observacion"]."";
		//*echo $linea."<br>";	
		}
		 header("Location:popup_hoja_madre.php?".$linea);
	}
	
?>