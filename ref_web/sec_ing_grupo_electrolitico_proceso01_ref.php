<?php
	include("../principal/conectar_sec_web.php");

	$opcion   = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$proceso  = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$txtgrupo = isset($_REQUEST["txtgrupo"])?$_REQUEST["txtgrupo"]:"";
	$cmbcircuito = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:"";
	$txttotal    = isset($_REQUEST["txttotal"])?$_REQUEST["txttotal"]:"";
	$cmbestado   = isset($_REQUEST["cmbestado"])?$_REQUEST["cmbestado"]:"";
	$txtdescobrizacion = isset($_REQUEST["txtdescobrizacion"])?$_REQUEST["txtdescobrizacion"]:"";
	$txthm          = isset($_REQUEST["txthm"])?$_REQUEST["txthm"]:"";
	$txtcatodos     = isset($_REQUEST["txtcatodos"])?$_REQUEST["txtcatodos"]:"";
	$txtanodos      = isset($_REQUEST["txtanodos"])?$_REQUEST["txtanodos"]:"";
	$cmbcalle       = isset($_REQUEST["cmbcalle"])?$_REQUEST["cmbcalle"]:"";
	$txtcubaslavado = isset($_REQUEST["txtcubaslavado"])?$_REQUEST["txtcubaslavado"]:"";
	$parametros     = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";
	
	$valido = 0;
	if( is_numeric($txtgrupo) && is_numeric($txttotal) && is_numeric($txtdescobrizacion) && is_numeric($txthm) &&
		is_numeric($txtcatodos) && is_numeric($txtanodos) && is_numeric($txtcubaslavado) )
	{
		$valido = 1;	
	}
	$Dia   = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
	$Mes   = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("n");
	$Ano   = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	if(strlen($Dia)==1)
		$Dia= "0".$Dia;
	if(strlen($Mes)==1)
		$Mes= "0".$Mes;

	$consulta_fecha_systema="SELECT left(sysdate(),10) as fecha2";
	$rss = mysqli_query($link, $consulta_fecha_systema);
	$rows = mysqli_fetch_array($rss);
	
	if (($proceso == "G") and ($opcion == "N"))
	{	
		if($valido == 1)
		{				
			$consulta = "SELECT * FROM ref_web.grupo_electrolitico2 ";
			$consulta.= " WHERE cod_grupo = '".$txtgrupo."'";
			$consulta.= " and fecha = '".$Ano."-".$Mes."-".$Dia."'";
			$rs = mysqli_query($link, $consulta);
			
			if ($row = mysqli_fetch_array($rs)) //Si Existe.
			{	
				$mensaje = "El Grupo Ya Existe";
				header("Location:sec_ing_grupo_electrolitico_proceso_ref.php?activar=S&mensaje=".$mensaje);
			}
			else //No Existe.
			{
				//Inserta en Sec_Web.
				$insertar = "INSERT INTO ref_web.grupo_electrolitico2 (fecha,cod_grupo,cod_circuito,num_cubas_tot,cod_estado,cubas_descobrizacion,hojas_madres,num_catodos_celdas,num_anodos_celdas,calle_puente_grua,cubas_lavado)";
				$insertar = $insertar." VALUES ('".$Ano."-".$Mes."-".$Dia."','".$txtgrupo."','".$cmbcircuito."','".$txttotal."','".$cmbestado."','".$txtdescobrizacion;
				$insertar = $insertar."','".$txthm."','".$txtcatodos."','".$txtanodos."','".$cmbcalle."','".$txtcubaslavado."')";
				//echo "insertar:".$insertar;
				mysqli_query($link, $insertar);	
				$mensaje = "Grupo grabado exitosamente.";			
				header("Location:sec_ing_grupo_electrolitico_proceso_ref.php?activar=S&mensaje=".$mensaje);
			}
		}else{
			$mensaje = "Error";	
			header("Location:sec_ing_grupo_electrolitico_proceso_ref.php?activar=S&mensaje=".$mensaje);
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
		  $mensaje = "Grupo(s) actualizado Correctamente";
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
		     mysqli_query($link, $actualizar_ge2);	
			$mensaje = "Grupo(s) actualizado Correctamente";				 
		}		
    	header("Location:sec_ing_grupo_electrolitico_proceso_ref.php?activar=S&mensaje=".$mensaje);		
	}
	
	if ($proceso == "E")
	{
		$valores = explode("-",$parametros);
		foreach($valores as $c => $v)
		{
			$eliminar = "DELETE FROM ref_web.grupo_electrolitico2 ";
			$eliminar.= " WHERE cod_grupo = '".$v."'";
			$eliminar.= " and fecha='".$Ano."-".$Mes."-".$Dia."'";
			//echo "Elin:".$eliminar;
			mysqli_query($link, $eliminar);						
		}
		$mensaje = "Grupo(s) Eliminado(s) Correctamente";
		//exit();
		header("Location:sec_ing_grupo_electrolitico_ref.php?activar=S&mensaje=".$mensaje);				
	}

	
	include("../principal/cerrar_sec_web.php");
?>