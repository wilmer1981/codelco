<?php
	include("../principal/conectar_sec_web.php");
	$consulta_fecha_systema="SELECT left(sysdate(),10) as fecha2";
	$rss = mysqli_query($link, $consulta_fecha_systema);
	$rows = mysqli_fetch_array($rss);
	
	if (($proceso == "G") and ($opcion == "N"))
	{	
		$consulta = "SELECT * FROM ref_web.grupo_electrolitico2 ";
		$consulta.= " WHERE cod_grupo = '".$txtgrupo."'";
		$consulta.= " and fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs)) //Si Existe.
		{	
			$mensaje = "El Grupo Ya Existe";
			header("Location:sec_ing_grupo_electrolitico_proceso_ref.php?activar=&mensaje=".$mensaje);
		}
		else //No Existe.
		{
			//Inserta en Sec_Web.
			$insertar = "INSERT INTO ref_web.grupo_electrolitico2 (fecha,cod_grupo,cod_circuito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado)";
			$insertar = $insertar." VALUES ('".$Ano."-".$Mes."-".$Dia."','".$txtgrupo."','".$cmbcircuito."','".$txttotal."','".$cmbestado."','".$txtdescobrizacion;
			$insertar = $insertar."','".$txthm."','".$txtcatodos."','".$txtanodos."','".$cmbcalle."','".$txtcubaslavado."')";
			mysqli_query($link, $insertar);					
    		header("Location:sec_ing_grupo_electrolitico_proceso_ref.php?activar=");
		}				
	}
	
	if (($proceso == "G") and ($opcion == "M"))
	{
	   $consulta="select fecha,cod_grupo from ref_web.grupo_electrolitico2 where fecha= '".$Ano."-".$Mes."-".$Dia."' and cod_grupo = '".$txtgrupo."'";
	   $rs = mysqli_query($link, $consulta);
	   if (!($row = mysqli_fetch_array($rs))) //Si Existe.
		{ $insertar = "INSERT INTO ref_web.grupo_electrolitico2 (fecha,cod_grupo,cod_circuito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado)";
		  $insertar = $insertar." VALUES ('".$Ano."-".$Mes."-".$Dia."','".$txtgrupo."','".$cmbcircuito."','".$txttotal."','".$cmbestado."','".$txtdescobrizacion;
		  $insertar = $insertar."','".$txthm."','".$txtcatodos."','".$txtanodos."','".$cmbcalle."','".$txtcubaslavado."')";
		  mysqli_query($link, $insertar);
		  $actualizar_ge2 = "UPDATE sec_web.grupo_electrolitico2 SET cod_circuito = '".$cmbcircuito."', num_cubas_tot = '".$txttotal."'";
		  $actualizar_ge2.= ", cubas_descobrizacion = '".$txtdescobrizacion."', hojas_madres = '".$txthm."', cod_estado = '".$cmbestado."'";
		  $actualizar_ge2.= ", num_catodos_celdas = '".$txtcatodos."', num_anodos_celdas = '".$txtanodos."'";
		  $actualizar_ge2.= ", calle_puente_grua = '".$cmbcalle."', cubas_lavado = '".$txtcubaslavado."'";
		  $actualizar_ge2.= " WHERE cod_grupo = '".$txtgrupo."'";
		  $actualizar_ge2.= " and fecha= '".$Ano."-".$Mes."-01'";
		  mysqli_query($link, $actualizar_ge2);		
		  }
		else{$actualizar = "UPDATE ref_web.grupo_electrolitico2 SET cod_circuito = '".$cmbcircuito."', num_cubas_tot = '".$txttotal."'";
		     $actualizar.= ", cubas_descobrizacion = '".$txtdescobrizacion."', hojas_madres = '".$txthm."', cod_estado = '".$cmbestado."'";
		     $actualizar.= ", num_catodos_celdas = '".$txtcatodos."', num_anodos_celdas = '".$txtanodos."'";
		     $actualizar.= ", calle_puente_grua = '".$cmbcalle."', cubas_lavado = '".$txtcubaslavado."'";
		     $actualizar.= " WHERE cod_grupo = '".$txtgrupo."'";
		     $actualizar.= " and fecha= '".$Ano."-".$Mes."-".$Dia."'";
			 mysqli_query($link, $actualizar);
			 $actualizar_ge2 = "UPDATE sec_web.grupo_electrolitico2 SET cod_circuito = '".$cmbcircuito."', num_cubas_tot = '".$txttotal."'";
		     $actualizar_ge2.= ", cubas_descobrizacion = '".$txtdescobrizacion."', hojas_madres = '".$txthm."', cod_estado = '".$cmbestado."'";
		     $actualizar_ge2.= ", num_catodos_celdas = '".$txtcatodos."', num_anodos_celdas = '".$txtanodos."'";
		     $actualizar_ge2.= ", calle_puente_grua = '".$cmbcalle."', cubas_lavado = '".$txtcubaslavado."'";
		     $actualizar_ge2.= " WHERE cod_grupo = '".$txtgrupo."'";
		     $actualizar_ge2.= " and fecha= '".$Ano."-".$Mes."-01'";
		     mysqli_query($link, $actualizar_ge2);		}		
    	header("Location:sec_ing_grupo_electrolitico_proceso_ref.php?activar=");		
	}
	
	if ($proceso == "E")
	{
		$valores = explode("-",$parametros);
		while(list($c,$v) = each($valores))
		{
			$eliminar = "DELETE FROM ref_web.grupo_electrolitico2 ";
			$eliminar.= " WHERE cod_grupo = '".$v."'";
			$eliminar.= " and fecha='".$Ano."-".$Mes."-".$Dia."'";
			mysqli_query($link, $eliminar);						
		}
		
		$mensaje = "Grupo(s) Eliminado(s) Correctamente";
		header("Location:sec_ing_grupo_electrolitico_ref.php?mensaje=".$mensaje);				
	}

	
	include("../principal/cerrar_sec_web.php");
?>