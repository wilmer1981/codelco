<?php include("../principal/conectar_ref_web.php");

    $consulta="select * from proyecto_modernizacion.funcionarios where rut='".$CookieRut."'  ";
	$rss = mysqli_query($link, $consulta);
	$rows = mysqli_fetch_array($rss);
    $nombre=$rows["nombres"]." ".$rows["apellido_paterno"]." ".$rows["apellido_materno"];
	if ($Proceso == "G")
	{
        $consulta="select * from ref_web.novedades where COD_NOVEDAD = '".$cod_novedad."'";
		$respuesta = mysqli_query($link, $consulta);
		if ($fila1=mysqli_fetch_array($respuesta))
		  {
		    if ($mantencion!='S')
			   {
		        $actualizar="UPDATE ref_web.novedades set NOVEDAD='".$observacion."', TURNO='".$cmbturno."', usuario='".$nombre."', mantencion='".$mantencion."', gerencia='".$gerencia."', estado='' where COD_NOVEDAD='".$cod_novedad."'";
			   }
			else {
			      $fecha_compromiso=$ano1.'-'.$mes1.'-'.$dia1;
				  if ($Estado=='2')
				     {
					  $consulta1="SELECT LEFT(SYSDATE(),10) as fecha_sistema";
					  $respuesta_sistema = mysqli_query($link, $consulta1);
		              $fila_sistema=mysqli_fetch_array($respuesta_sistema); 
					  $fecha_real=$fila_sistema[fecha_sistema];
					 }
				  else {
				         $fecha_real='0000-00-00';
				       }	 
			      $actualizar="UPDATE ref_web.novedades set NOVEDAD='".$observacion."', TURNO='".$cmbturno."', usuario='".$nombre."', mantencion='".$mantencion."', gerencia='".$gerencia."', ";
				  $actualizar.="compromiso='".$fecha_compromiso."', area='".$Area."', estado='".$Estado."',fecha_real='".$fecha_real."' where COD_NOVEDAD='".$cod_novedad."'";
				 }   
			//echo $actualizar;
			mysqli_query($link, $actualizar);
		  }
		else {
		      if ($mantencion!='S')
			      {
					  $Insertar = "INSERT INTO ref_web.novedades (FECHA,NOVEDAD, TURNO, usuario,mantencion,gerencia)";
					  $Insertar.= " VALUES ('".$fecha."','".$observacion."', '".$cmbturno."','".$nombre."','".$mantencion."','".$gerencia."')";
				  }
			   else {
			         $consulta1="SELECT LEFT(SYSDATE(),10) as fecha_sistema";
					 $respuesta_sistema = mysqli_query($link, $consulta1);
		             $fila_sistema=mysqli_fetch_array($respuesta_sistema);
					 $fecha_real='0000-00-00';
			         $Insertar = "INSERT INTO ref_web.novedades (FECHA,NOVEDAD, TURNO, usuario,mantencion,gerencia,compromiso,estado,fecha_real)";
					 $Insertar.= " VALUES ('".$fecha."','".$observacion."', '".$cmbturno."','".$nombre."','".$mantencion."','".$gerencia."','".$fila_sistema[fecha_sistema]."','".$Estado."','".$fecha_real."')";
			        }	  	  
		      //echo $Insertar;
              mysqli_query($link, $Insertar);
			 } 
			 
		  $consulta_datos="select t1.COD_NOVEDAD, t1.NOVEDAD, t1.FECHA, t1.TURNO, t1.usuario,t1.gerencia, ";
		  $consulta_datos.="t2.valor_subclase1, t2.nombre_subclase ";
		  $consulta_datos.="from ref_web.novedades as t1 ";
		  $consulta_datos.="inner join proyecto_modernizacion.sub_clase as t2 on t1.TURNO=t2.nombre_subclase ";
		  $consulta_datos.="where t1.fecha='".$fecha."' and t1.gerencia='S' and t2.cod_clase='1' ";
		  $consulta_datos.="order by t2.valor_subclase1 ";
		  $respuesta_datos = mysqli_query($link, $consulta_datos);
		  while ($fila_datos=mysqli_fetch_array($respuesta_datos))
		      {
			    $obs_turno=$obs_turno.chr(10).'TURNO '.$fila_datos[TURNO].chr(10).$fila_datos[NOVEDAD].chr(10);
				$fecha_obs=$fila_datos[FECHA];
				$usuario=$fila_datos[usuario];
			  }
		 include("../principal/cerrar_ref_web.php");	  
		 $link = mysql_connect("10.56.11.6","adm_user_ref","346347");
	     mysql_select_db("informe_diario", $link);
		     $consulta_gerencia="select * from informe_diario.novedades where fecha='".$fecha."' and Cod_tipo='5'";	  
			 $respuesta_gerencia = mysqli_query($link, $consulta_gerencia);
		     if ($fila_gerencia=mysqli_fetch_array($respuesta_gerencia))
			    {
		         $Eliminar = "DELETE FROM informe_diario.novedades WHERE fecha='".$fecha."' and Cod_tipo='5'";
		         mysqli_query($link, $Eliminar);
				} 	 
			$Insertar = "INSERT INTO informe_diario.novedades (Fecha,Rut, Cod_tipo, Nombre,Texto)";
		    $Insertar.= " VALUES ('".$fecha."','".$CookieRut."','5','".$nombre."','".$obs_turno."')";
			mysqli_query($link, $Insertar);
		mysqli_close($link);	
		include("../principal/conectar_ref_web.php");	
		header ("location:ing_general.php?fecha=$fecha");
	}
	if ($Proceso == "E")
	{
		$Eliminar = "DELETE FROM ref_web.novedades WHERE COD_NOVEDAD = '".$cod_novedad."'";
		mysqli_query($link, $Eliminar);
		header ("location:general.php?fecha=$fecha");
	}	   

?> 