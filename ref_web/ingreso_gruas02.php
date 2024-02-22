<?php  include("../principal/conectar_ref_web.php");

/*$consulta_fecha_actual="select left(SYSDATE(),10) as fecha2";
$resultado=mysqli_query($link, $consulta_fecha_actual);
$row1 = mysqli_fetch_array($resultado);
$fecha2=$row1[fecha2];*/
 
 	$fecha_hoy = date("Y-m-d");

    $consulta="select * from proyecto_modernizacion.funcionarios where rut='".$CookieRut."'  ";
	$rss = mysqli_query($link, $consulta);
	$rows = mysqli_fetch_array($rss);
	//echo "Area".$Area."#".$Proceso;
		$ano = substr($fecha,0,4);
		$mes =   substr($fecha,5,2);
		$dia = substr($fecha,8,2);
		if ($opcion!='M')
			$Fecha_mas = date("Y-m-d",mktime(1,0,0,$mes,($dia - 1),$ano));
		else
			 $Fecha_mas = $fecha;  
    $nombre=$rows["nombres"]." ".$rows["apellido_paterno"]." ".$rows["apellido_materno"];


 
	if ($Proceso == "G")
	{

	    $time=$hora.':'.$minuto.':00';
		if ($opcion == '')
		{
			$Insertar = "INSERT INTO historia_gruas (cod_grua,fecha,turno,estado,condicion,area_mantencion,observacion)";
			$Insertar.= " VALUES ('".$grua."','".$fecha."','".$turno."','".$estado."','".$Condicion_insegura."','".$area."','".$observacion."')";
		//	echo $Insertar;
			mysqli_query($link, $Insertar);
			
			//inserto novedades
		/*	echo "Hola".$estado."&".$mantencion;
			if ($mantencion!='S')
			{
				if ($turno=='C' && $fecha_hoy==$fecha)
				{
					$Insertar = "INSERT INTO ref_web.novedades (FECHA,NOVEDAD, TURNO, usuario,mantencion,gerencia,Condicion_insegura)";
					$Insertar.= " VALUES ('".$Fecha_mas."','".$observacion."', '".$turno."','".$nombre."','".$mantencion."','".$gerencia."','".$Condicion_insegura."')";					
				}
				else
				{
					$Insertar = "INSERT INTO ref_web.novedades (FECHA,NOVEDAD, TURNO, usuario,mantencion,gerencia,Condicion_insegura)";
					$Insertar.= " VALUES ('".$fecha."','".$observacion."', '".$turno."','".$nombre."','".$mantencion."','".$gerencia."','".$Condicion_insegura."')";
				}
			}
			echo $Insertar;
			mysqli_query($link, $Insertar);*/
		}
		else
		{
			$Actualizar = "UPDATE historia_gruas set observacion = '".$observacion."',estado= '".$estado."' where cod_grua = '".$grua."' ";
			$Actualizar.= "and fecha = '".$fecha_grua."' and turno = '".$turno."'  ";
			//echo "AAA".$Actualizar;
			mysqli_query($link, $Actualizar);
			$fecha = $fecha_grua;
			$opcion = "M";
		}
	/*	aquiiiiiiiiiiiiiiiiii*/
		
  /*     $consulta="select * from ref_web.novedades where COD_NOVEDAD = '".$cod_novedad."'";
		$respuesta = mysqli_query($link, $consulta);
	
		if ($fila1=mysqli_fetch_array($respuesta))
		{
			if ($mantencion!='S') //en ingreso $mantencion =  ' '
			{
				//   echo "entro a actualizar";
		        $actualizar="UPDATE ref_web.novedades set NOVEDAD='".$observacion."', TURNO='".$cmbturno."', usuario='".$nombre."', mantencion='".$mantencion."', gerencia='".$gerencia."' ,Condicion_insegura='".$Condicion_insegura."', estado='' where COD_NOVEDAD='".$cod_novedad."'";
				//echo $actualizar;				
			}
			else 
			{
				$fecha_compromiso=$ano1.'-'.$mes1.'-'.$dia1;
				if ($estado=='2')
				{
					  $consulta1="SELECT LEFT(SYSDATE(),10) as fecha_sistema";
					  $respuesta_sistema = mysqli_query($link, $consulta1);
		              $fila_sistema=mysqli_fetch_array($respuesta_sistema); 
					  $fecha_real=$fila_sistema[fecha_sistema];
				}
				else 
				{
				      $fecha_real='0000-00-00';
				}	 
			      	  $actualizar="UPDATE ref_web.novedades set NOVEDAD='".$observacion."', TURNO='".$cmbturno."', usuario='".$nombre."', mantencion='".$mantencion."', gerencia='".$gerencia."', Condicion_insegura='".$Condicion_insegura."', ";
				  	  $actualizar.="compromiso='".$fecha_compromiso."', area='".$Area."', estado='".$Estado."',fecha_real='".$fecha_real."' where COD_NOVEDAD='".$cod_novedad."'";
						//echo $actualizar."<br>";		  
			}   			
				mysqli_query($link, $actualizar);
		}
		else 
		{
		      if ($mantencion!='S')
			  {
			  		if ($turno=='C' && $fecha_hoy==$fecha)
					{
					  $Insertar = "INSERT INTO ref_web.novedades (FECHA,NOVEDAD, TURNO, usuario,mantencion,gerencia,Condicion_insegura)";
					  $Insertar.= " VALUES ('".$Fecha_mas."','".$observacion."', '".$turno."','".$nombre."','".$mantencion."','".$gerencia."','".$Condicion_insegura."')";					
					}
					else
					{
					  $Insertar = "INSERT INTO ref_web.novedades (FECHA,NOVEDAD, TURNO, usuario,mantencion,gerencia,Condicion_insegura)";
					  $Insertar.= " VALUES ('".$fecha."','".$observacion."', '".$turno."','".$nombre."','".$mantencion."','".$gerencia."','".$Condicion_insegura."')";
				  	}
			}
			
				echo "Hola".$estado."&".$mantencion;
		/*	else 
			{
					$consulta1="SELECT LEFT(SYSDATE(),10) as fecha_sistema";
					$respuesta_sistema = mysqli_query($link, $consulta1);
		            $fila_sistema=mysqli_fetch_array($respuesta_sistema);
					$fecha_real='0000-00-00';
					// echo "area".$Area;
			        $Insertar = "INSERT INTO ref_web.novedades (FECHA,NOVEDAD, TURNO, usuario,mantencion,gerencia,Condicion_insegura,compromiso,area,estado,fecha_real)";
					$Insertar.= " VALUES ('".$fecha."','".$observacion."', '".$cmbturno."','".$nombre."','".$mantencion."','".$gerencia."','".$Condicion_insegura."','".$fila_sistema[fecha_sistema]."','".$Area."','".$Estado."','".$fecha_real."')";
		    }	  	  
		      //echo $Insertar;
            mysqli_query($link, $Insertar);
		} 
		$consulta_datos="select t1.COD_NOVEDAD, t1.NOVEDAD, t1.FECHA, t1.TURNO, t1.usuario,t1.gerencia, ";
		$consulta_datos.="t2.valor_subclase1, t2.nombre_subclase ";
		$consulta_datos.="from ref_web.novedades as t1 ";
		$consulta_datos.="inner join proyecto_modernizacion.sub_clase as t2 on t1.TURNO=t2.nombre_subclase ";
		$consulta_datos.="where t1.gerencia='S' and t2.cod_clase='1' and ";
		if ($cmbturno=='C' && $fecha_hoy == $fecha)
		  	$consulta_datos.=" t1.fecha='".$Fecha_mas."' ";
		else
			$consulta_datos.=" t1.fecha='".$fecha."' ";
		$consulta_datos.="order by t1.turno ";
		 // echo "AAA".$consulta_datos;
		$respuesta_datos = mysqli_query($link, $consulta_datos);
		while ($fila_datos=mysqli_fetch_array($respuesta_datos))
		{
			$obs_turno=$obs_turno.chr(10).'TURNO '.$fila_datos[TURNO].chr(10).$fila_datos[NOVEDAD].chr(10);
			$fecha_obs=$fila_datos[FECHA];
			$usuario=$fila_datos[usuario];
		}
		$consulta_gerencia="select * from informe_diario.novedades where ";
		if ($cmbturno=='C' && $fecha_hoy == $fecha)
			$consulta_gerencia.=" fecha='".$Fecha_mas."' ";
		else
			$consulta_gerencia.=" fecha= '".$fecha."' ";
		$consulta_gerencia.=" and Cod_tipo='5'";	  
		$respuesta_gerencia = mysqli_query($link, $consulta_gerencia);
			// echo "GERENCIA".$consulta_gerencia;
		if ($fila_gerencia=mysqli_fetch_array($respuesta_gerencia))
		{    
			$Eliminar = "DELETE FROM informe_diario.novedades WHERE ";
			if ($cmbturno=='C' && $fecha_hoy == $fecha) 
				$Eliminar.= " fecha='".$Fecha_mas."' ";
			else
				$Eliminar.=" fecha='".$fecha."' ";
			$Eliminar.=" and Cod_tipo='5'";
				// echo "DELETE".$Eliminar;
		    mysqli_query($link, $Eliminar);
		} 	
		if ($cmbturno=='C' && $fecha_hoy == $fecha)
		{
			$Insertar = "INSERT INTO informe_diario.novedades (Fecha,Rut, Cod_tipo, Nombre,Texto)";
		 	$Insertar.= " VALUES ('".$Fecha_mas."', '".$CookieRut."','5','".$nombre."','".$obs_turno."')";
		}
		else
		{
			$Insertar = "INSERT INTO informe_diario.novedades (Fecha,Rut, Cod_tipo, Nombre,Texto)";
		 	$Insertar.= " VALUES ('".$fecha."', '".$CookieRut."','5','".$nombre."','".$obs_turno."')";
		}	
			//echo "IIII---".$Insertar;
		mysqli_query($link, $Insertar);
	}
		
	//	aquiiiiiiiiiiiiiiiiii*/
	header ("location:principal_gruas.php?fecha=".$fecha."&cmbgrua=".$grua."&FechaInicio1=".$FechaInicio1."&FechaTermino1=".$FechaTermino1."&opcion=".$opcion);
	}
	
	if ($Proceso == "E")
	{
	
		 $Eliminar = "DELETE FROM ref_web.historia_gruas where cod_grua = '".$cod_grua."' and fecha='".$fecha_grua."' and turno='".$turno."' ";
	//echo "EEEE".$Eliminar;
		mysqli_query($link, $Eliminar);
		$opcion = "E";
	//	echo "FFF".$FechaInicio;
		header ("location:principal_gruas.php?FechaInicio1=".$FechaInicio."&FechaTermino1=".$FechaTermino."&cmbgrua=".$cod_grua."&opcion=".$opcion);
		
	} 
?>
