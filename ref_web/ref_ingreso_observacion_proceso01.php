<?php
	include("../principal/conectar_sec_web.php");
	
	     $consulta="select * from ref_web.observaciones where cod_grupo='".$grupo."' and fecha='".$fecha."'";
		 $rs3 = mysqli_query($link, $consulta);
		 if ($row2 = mysqli_fetch_array($rs3))
		     {
    			 $actualizar = "UPDATE ref_web.observaciones SET Obs_gen = '".$observacion."'";
				 $actualizar.= " WHERE cod_grupo = '".$grupo."' and cod_circuito='".$circuito."'";
				 $actualizar.= " and fecha= '".$fecha."'";
			     mysqli_query($link, $actualizar);
			 }
		 else { $insertar2 = "INSERT INTO ref_web.observaciones (fecha,cod_circuito,cod_grupo,rayado,normal,piel_naranja,granulado,perforado,c_lateral,g_lateral,puntual,disperso,estampa,oreja,remache,extendida,abierto,brocoli,manchon,cerrado,Obs_gen)"; 
				$insertar2 = $insertar2."VALUES ('".$fecha."','".$circuito."','".$grupo."','0','0','0','0','0','0','0','0',";
				$insertar2=$insertar2."'0','0','0','0','0','0','0','0','0','0') ";
				mysqli_query($link, $insertar2);
				$actualizar = "UPDATE ref_web.observaciones SET Obs_gen = '".$observacion."'";
				$actualizar.= " WHERE cod_grupo = '".$grupo."' and cod_circuito='".$circuito."'";
				$actualizar.= " and fecha= '".$fecha."'";
			    mysqli_query($link, $actualizar);
			  }	 	 
	     $mensaje = "Observacion Guardada en Forma Satisfactoria";
		 header("Location:observacion_cortocircuito.php?activar=&mensaje=".$mensaje);
	
	
	
	
	
	include("../principal/cerrar_sec_web.php");
?>