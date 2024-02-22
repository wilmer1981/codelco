<?php
	include("../principal/conectar_sec_web.php");
	$consulta_fecha_systema="SELECT left(sysdate(),10) as fecha2";
	$rss = mysqli_query($link, $consulta_fecha_systema);
	$rows = mysqli_fetch_array($rss);
	
	if (($proceso == "G") and ($opcion == "N"))
	{	
		$consulta = "SELECT * FROM sec_web.grupo_electrolitico2 ";
		$consulta.= " WHERE cod_grupo = '".$txtgrupo."'";
		$consulta.= " and fecha = '".$Ano."-".$Mes."-01'";
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs)) //Si Existe.
		{	
			$mensaje = "El Grupo Ya Existe";
			header("Location:sec_ing_grupo_electrolitico_proceso.php?activar=&mensaje=".$mensaje);
		}
		else //No Existe.
		{
			//Inserta en Sec_Web.
			$insertar = "INSERT INTO sec_web.grupo_electrolitico2 (fecha,cod_grupo,cod_circuito,cod_electrolito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado)";
			$insertar = $insertar." VALUES ('".$Ano."-".$Mes."-01','".$txtgrupo."','".$cmbcircuito."','".$cmbelectrolito."','".$txttotal."','".$cmbestado."','".$txtdescobrizacion;
			$insertar = $insertar."','".$txthm."','".$txtcatodos."','".$txtanodos."','".$cmbcalle."','".$txtcubaslavado."')";
			mysqli_query($link, $insertar);					
    		header("Location:sec_ing_grupo_electrolitico_proceso.php?activar=");
		}				
	}
	
	if (($proceso == "G") and ($opcion == "M"))
	{
	  $insertar = "INSERT INTO sec_web.grupo_electrolitico_modif (fecha,cod_grupo,cod_circuito,cod_electrolito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado)";
	  $insertar = $insertar." VALUES ('".$ano1."-".$mes1."-".$dia1."','".$txtgrupo."','".$cmbcircuito."','".$cmbelectrolito."','".$txttotal."','".$cmbestado."','".$txtdescobrizacion;
	  $insertar = $insertar."','".$txthm."','".$txtcatodos."','".$txtanodos."','".$cmbcalle."','".$txtcubaslavado."')";
	  mysqli_query($link, $insertar);					
      header("Location:sec_ing_grupo_electrolitico_proceso2.php?activar=");		
	}
	
	if ($proceso == "E")
	{
		$valores = explode("-",$parametros);
		while(list($c,$v) = each($valores))
		{
		     
			$eliminar = "DELETE FROM sec_web.grupo_electrolitico_modif ";
			$eliminar.= " WHERE cod_grupo = '".$v."' ";
			$eliminar.= " and fecha='".$Ano."-".$Mes."-".$Dia."' ";
			mysqli_query($link, $eliminar);						
		}
		
		$mensaje = "Grupo(s) Eliminado(s) Correctamente";
		header("Location:sec_ing_grupo_electrolitico.php?mensaje=".$mensaje);				
	}

	
	include("../principal/cerrar_sec_web.php");
?>