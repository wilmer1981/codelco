<?php
	include("../principal/conectar_sec_web.php");
		//saco rut

	$CookieRut  = $_COOKIE["CookieRut"];

	$dia1    = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:"";
	$mes1    = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
	$ano1    = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";
	$hr1   = isset($_REQUEST["hr1"])?$_REQUEST["hr1"]:"";
	$mm1   = isset($_REQUEST["mm1"])?$_REQUEST["mm1"]:"";
	$dia2  = isset($_REQUEST["dia2"])?$_REQUEST["dia2"]:"";
	$mes2  = isset($_REQUEST["mes2"])?$_REQUEST["mes2"]:"";
	$ano2  = isset($_REQUEST["ano2"])?$_REQUEST["ano2"]:"";
	$hr2   = isset($_REQUEST["hr2"])?$_REQUEST["hr2"]:"";
	$mm2   = isset($_REQUEST["mm2"])?$_REQUEST["mm2"]:"";


	$opcion   = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$cmbgrupo = isset($_REQUEST["cmbgrupo"])?$_REQUEST["cmbgrupo"]:"";
	$cmbtipo      = isset($_REQUEST["cmbtipo"])?$_REQUEST["cmbtipo"]:"";
	$txtkah1      = isset($_REQUEST["txtkah1"])?$_REQUEST["txtkah1"]:"";
	$txtkah2      = isset($_REQUEST["txtkah2"])?$_REQUEST["txtkah2"]:"";
	$tipo_desc= isset($_REQUEST["tipo_desc"])?$_REQUEST["tipo_desc"]:"";

	
	$cmbrectificador = isset($_REQUEST["cmbrectificador"])?$_REQUEST["cmbrectificador"]:"";
	$programa = isset($_REQUEST["programa"])?$_REQUEST["programa"]:"";

	$fecha     = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$cod_grupo = isset($_REQUEST["cod_grupo"])?$_REQUEST["cod_grupo"]:"";
	$tipo_desconexion = isset($_REQUEST["tipo_desconexion"])?$_REQUEST["tipo_desconexion"]:"";
	$fecha_desconexion  = isset($_REQUEST["fecha_desconexion"])?$_REQUEST["fecha_desconexion"]:"";
	$proceso  = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";

	$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
	$Respuesta  = mysqli_query($link, $Consulta);
	$Fila       = mysqli_fetch_array($Respuesta);
	$Nivel      = $Fila["nivel"];
	$Fecha_Hora = date("d-m-Y h:i");
	$meses = array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut   = $CookieRut;

	$HoraActual   = date("H");
	$MinutoActual = date("i");
	$Fecha_modif  = date("Y-m-d");

	if (strlen($mes1)==1)  
	{
		$mes1='0'.$mes1;
	}
	if (strlen($dia1)==1)
	{
		$dia1='0'.$dia1;
	}	

	$fecha_des = $ano1."-".$mes1."-".$dia1." ".$hr1.":".$mm1;
	//echo "f".$fecha_des;
	$var=strlen($mes2);	
	if ($var==1)
	{
		$mes2="0$mes2";
	}
	$var=strlen($dia2);
	if($var==1)
	{
		$dia2="0$dia2";
	}	
	$var=strlen($hr2);
	if($var==1)
	{
		$hr2="0$hr2";
	}	
	$var=strlen($mm2); 
	if($var==1)
	{
		$mm2="0$mm2";
	}	

	
		
	$fecha_con = $ano2."-".$mes2."-".$dia2." ".$hr2.":".$mm2;

	if (($proceso == "G") and ($opcion == "N"))
	{
		//echo "TIPO DESC:".$tipo_desc."<BR>";
		if ($tipo_desc!='R')
		{
				$consulta = "SELECT * FROM sec_web.cortes_refineria WHERE cod_grupo = '".$cmbgrupo."' AND fecha_desconexion = '".$fecha_des."'";
				//echo $consulta."<br>";
				$rs = mysqli_query($link, $consulta);
				if ($row = mysqli_fetch_array($rs))
				{
					$mensaje = "Ya Exite la Fecha de Desconexion para Este Grupo";
					header("Location:sec_ing_estadistica_cortes_proceso_ref.php?activar=&mensaje=".$mensaje);
				}
			    else
				 {
						 $insertar = "INSERT INTO sec_web.cortes_refineria (tipo_desconexion,cod_grupo,fecha_desconexion,fecha_conexion,kahdird,kahdirc)";
						 $insertar = $insertar." VALUES ('".$cmbtipo."','".$cmbgrupo."','".$fecha_des."','".$fecha_con."','".$txtkah1."','".$txtkah2."')";		
						 mysqli_query($link, $insertar);

						 $insertar = "INSERT INTO raf_web.ti_cortes_refineria (tipo_desconexion,cod_grupo,fecha_desconexion,fecha_conexion,kahdird,kahdirc)";
						 $insertar = $insertar." VALUES ('".$cmbtipo."','".$cmbgrupo."','".$fecha_des."','".$fecha_con."','".$txtkah1."','".$txtkah2."')";		
						 mysqli_query($link, $insertar);

						 //echo $insertar."<br>";
						 if (strlen($mes1)==1)
							 {
							  $mes1='0'.$mes1;
							 }
						 if (strlen($dia1)==1)
							{
							  $dia1='0'.$dia1;
							}
						 $fecha=$ano1.'-'.$mes1.'-'.$dia1;
						 //echo "PROGRAMA:".$programa."<br>";
						  if ($programa<>"PP")
				  			{
								//header("Location:Conexiones.php?fecha=".$fecha);
								header("Location:sec_ing_estadistica_cortes_proceso_ref.php?fecha=".$fecha);//PARA MODIFICAR
							}
						  if ($programa=="PP")
						  	{
								header("Location:sec_ing_estadistica_cortes_proceso_ref2.php?opcion=N&fecha=".$fecha);
								
							}
					} 
			}
		else {
				$consulta="select distinct cod_grupo from ref_web.grupo_electrolitico2 where rectificador='".$cmbrectificador."' order by cod_grupo";
				$respuesta=mysqli_query($link, $consulta);
				while ($row_grupo=mysqli_fetch_array($respuesta))
					{
						$insertar = "INSERT INTO sec_web.cortes_refineria (tipo_desconexion,cod_grupo,fecha_desconexion,fecha_conexion,kahdird,kahdirc)";
						$insertar = $insertar." VALUES ('".$cmbtipo."','".$row_grupo["cod_grupo"]."','".$fecha_des."','".$fecha_con."',".$txtkah1.",'".$txtkah2."')";		
						mysqli_query($link, $insertar);
						//INSERTAR PARA INTERFACES PI
						$insertar = "INSERT INTO raf_web.ti_cortes_refineria (tipo_desconexion,cod_grupo,fecha_desconexion,fecha_conexion,kahdird,kahdirc)";
						$insertar = $insertar." VALUES ('".$cmbtipo."','".$row_grupo["cod_grupo"]."','".$fecha_des."','".$fecha_con."',".$txtkah1.",'".$txtkah2."')";		
						mysqli_query($link, $insertar);

						//echo $insertar."<br>";
					
					}
				 if (strlen($mes1)==1)
					 {
					  $mes1='0'.$mes1;
					 }
				 if (strlen($dia1)==1)
					{
					  $dia1='0'.$dia1;
					}
				$fecha=$ano1.'-'.$mes1.'-'.$dia1;

				 
			 		if ($programa<>"PP")
						 {
							header("Location:Conexiones.php?fecha=".$fecha);
							
						}
					if ($programa=="PP")
						{
							header("Location:sec_ing_estadistica_cortes_proceso_ref2.php?opcion=N&fecha=".$fecha);
							
						}
			 }					  
			/*}*/
	}
		
	if (($proceso == "G") and ($opcion == "M"))
	{


		//selecciono datos para guardar datos que seran modificados e insertar en tabla modificaciones
		$Consulta = " select tipo_desconexion,substring(fecha_conexion,1,16) as fecha_c,kahdird,kahdirc  from sec_web.cortes_refineria";
		$Consulta = $Consulta."  WHERE cod_grupo = '".$cmbgrupo."' AND fecha_desconexion = '".$fecha_des."'";
 		$fila = mysqli_query($link, $Consulta);
		if ($row = mysqli_fetch_array($fila))
		{
			$Tipo 		= $row["tipo_desconexion"];
			$Fecha_con 	= $row["fecha_c"];
			$Kd 		= $row["kahdird"];
			$Kc 		= $row["kahdirc"];
			$estado1 = '0';
			$estado2 = '0';
			$estado3 = '0';
			$estado4 = '0';
		//echo "Tipo".$Tipo;
		
		 	if($Tipo <> $cmbtipo)
		 	{
		 		$estado1 = '1';
		 	}
		 	if($Kd <> $txtkah1)
		 	{
		 		$estado2 = '1'; 
		 	}

			
			if($Fecha_con <> $fecha_con)
		 	{
				$estado3 = '1'; 
		 	}

		 	if($Kc <> $txtkah2)
		 	{ 
		 		$estado4 = '1';
		 	}
		
		
			//GRABO LOS DATOS DEL QUE MODIFICA
			$insertar = "INSERT INTO ref_web.control_movimientos (fecha_movimiento,fecha_modificacion,rut_modificacion,estado1,estado2,estado3,estado4)";
			$insertar = $insertar." VALUES ('".$fecha_des."','".$Fecha_modif."','".$Rut."','".$estado1."','".$estado2."','".$estado3."','".$estado4."')"; 
			mysqli_query($link, $insertar);
		}
		
		$actualizar = "UPDATE sec_web.cortes_refineria SET tipo_desconexion = '".$cmbtipo."',fecha_conexion = '".$fecha_con."'";
		$actualizar = $actualizar.",kahdird = '".$txtkah1."',kahdirc = '".$txtkah2."'";
		$actualizar = $actualizar." WHERE cod_grupo = '".$cmbgrupo."' AND fecha_desconexion = '".$fecha_des."'";
		mysqli_query($link, $actualizar);
		//ACTUALIZACION INTERFACES PI
		$actualizar = "UPDATE raf_web.ti_cortes_refineria SET tipo_desconexion = '".$cmbtipo."',fecha_conexion = '".$fecha_con."'";
		$actualizar = $actualizar.",kahdird = '".$txtkah1."',kahdirc = '".$txtkah2."'";
		$actualizar = $actualizar." WHERE cod_grupo = '".$cmbgrupo."' AND fecha_desconexion = '".$fecha_des."'";
		mysqli_query($link, $actualizar);

		if (strlen($mes1)==1)  
		    {
			   $mes1='0'.$mes1;
			}
		if (strlen($dia1)==1)
		    {
			   $dia1='0'.$dia1;
			}	
		$fecha=$ano1.'-'.$mes1.'-'.$dia1;
		//header("Location:Conexiones.php?fecha=".$fecha);
		
		
		 if ($programa<>"PP")
			{

				header("Location:Conexiones.php?fecha=".$fecha);
				//header("Location:sec_ing_estadistica_cortes_proceso_ref.php?fecha=".$fecha);
			}
		if ($programa=="PP")
			{
			
			
				header("Location:sec_ing_estadistica_cortes_proceso_ref2.php?fecha=".$fecha);
			}

	}
	
	if ($proceso == "E")
	{
		
			$eliminar = "DELETE FROM sec_web.cortes_refineria WHERE cod_grupo = '".$cod_grupo."' AND fecha_desconexion = '".$fecha_desconexion."'";
			mysqli_query($link, $eliminar);
			//ELIMINAR EN INTERFCES PI
			$eliminar = "DELETE FROM raf_web.ti_cortes_refineria WHERE cod_grupo = '".$cod_grupo."' AND fecha_desconexion = '".$fecha_desconexion."'";
			mysqli_query($link, $eliminar);
		
		
		header("Location:Conexiones.php?fecha=".$fecha);	
	}
	
	include("../principal/cerrar_sec_web.php");
?>
