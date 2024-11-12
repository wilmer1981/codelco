<?php include("../principal/conectar_ref_web.php");
	$fecha_hoy = date("Y-m-d");

	$CookieRut  = $_COOKIE["CookieRut"];

	$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$opcion       = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";  
	$cod_novedad  = isset($_REQUEST["cod_novedad"])?$_REQUEST["cod_novedad"]:"";
	$mantencion   = isset($_REQUEST["mantencion"])?$_REQUEST["mantencion"]:"";
	$observacion  = isset($_REQUEST["observacion"])?$_REQUEST["observacion"]:"";
	$cmbturno     = isset($_REQUEST["cmbturno"])?$_REQUEST["cmbturno"]:"";
	$gerencia     = isset($_REQUEST["gerencia"])?$_REQUEST["gerencia"]:"";
	$Condicion_insegura  = isset($_REQUEST["Condicion_insegura"])?$_REQUEST["Condicion_insegura"]:"";
	
	$Area    = isset($_REQUEST["Area"])?$_REQUEST["Area"]:"";
	$Estado  = isset($_REQUEST["Estado"])?$_REQUEST["Estado"]:"";

	$fecha    = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$dia1     = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:""; 
	$mes1     = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";  
	$ano1     = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:""; 

	$Proceso2     = isset($_REQUEST["Proceso2"])?$_REQUEST["Proceso2"]:"";
	$Marca        = isset($_REQUEST["Marca"])?$_REQUEST["Marca"]:"";  
	$ValoresElim  = isset($_REQUEST["ValoresElim"])?$_REQUEST["ValoresElim"]:""; 	
	$ValoresElim2 = isset($_REQUEST["ValoresElim2"])?$_REQUEST["ValoresElim2"]:"";  

	$Proceso3     = isset($_REQUEST["Proceso3"])?$_REQUEST["Proceso3"]:"";
	$Marca2        = isset($_REQUEST["Marca2"])?$_REQUEST["Marca2"]:"";  

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
		//echo "Hola".$Estado."&".$mantencion;
        $consulta="select * from ref_web.novedades where COD_NOVEDAD = '".$cod_novedad."'";
		$respuesta = mysqli_query($link, $consulta);
		if ($fila1=mysqli_fetch_array($respuesta))
		{
			if ($mantencion!='S') //en ingreso $mantencion =  ' '
			{
				//   echo "entro a actualizar";
		        $actualizar="UPDATE ref_web.novedades set NOVEDAD='".$observacion."', TURNO='".$cmbturno."', usuario='".$nombre."', mantencion='".$mantencion."', gerencia='".$gerencia."' ,Condicion_insegura='".$Condicion_insegura."', estado='$Estado' where COD_NOVEDAD='".$cod_novedad."'";
				//echo $actualizar;				
			}
			else 
			{
				$fecha_compromiso=$ano1.'-'.$mes1.'-'.$dia1;
				if ($Estado=='2')
				{
					  $consulta1="SELECT LEFT(SYSDATE(),10) as fecha_sistema";
					  $respuesta_sistema = mysqli_query($link, $consulta1);
		              $fila_sistema=mysqli_fetch_array($respuesta_sistema); 
					  $fecha_real=$fila_sistema["fecha_sistema"];
				}
				else 
				{
				      $fecha_real='0000-00-00';
				}	 
			    $actualizar="UPDATE ref_web.novedades set NOVEDAD='".$observacion."', TURNO='".$cmbturno."', usuario='".$nombre."', mantencion='".$mantencion."', gerencia='".$gerencia."', Condicion_insegura='".$Condicion_insegura."', ";
				$actualizar.="compromiso='".$fecha_compromiso."', area='".$Area."', estado='$Estado',fecha_real='".$fecha_real."' where COD_NOVEDAD='".$cod_novedad."'";
				//echo "Actualizar:".$actualizar."<br>";		  
			}   			
			mysqli_query($link, $actualizar);
		  }
		else 
		{
		      if ($mantencion!='S')
			  {
			  		if ($cmbturno=='C' && $fecha_hoy==$fecha)
					{
					  $Insertar = "INSERT INTO ref_web.novedades (FECHA,NOVEDAD, TURNO, usuario,mantencion,gerencia,Condicion_insegura)";
					  $Insertar.= " VALUES ('".$Fecha_mas."','".$observacion."', '".$cmbturno."','".$nombre."','".$mantencion."','".$gerencia."','".$Condicion_insegura."')";					
					}
					else
					{
					  $Insertar = "INSERT INTO ref_web.novedades (FECHA,NOVEDAD, TURNO, usuario,mantencion,gerencia,Condicion_insegura)";
					  $Insertar.= " VALUES ('".$fecha."','".$observacion."', '".$cmbturno."','".$nombre."','".$mantencion."','".$gerencia."','".$Condicion_insegura."')";
				  	}
			}
			else 
			{
					$consulta1="SELECT LEFT(SYSDATE(),10) as fecha_sistema";
					$respuesta_sistema = mysqli_query($link, $consulta1);
		            $fila_sistema=mysqli_fetch_array($respuesta_sistema);
					$fecha_real='0000-00-00';
					// echo "area".$Area;
			        $Insertar = "INSERT INTO ref_web.novedades (FECHA,NOVEDAD, TURNO, usuario,mantencion,gerencia,Condicion_insegura,compromiso,area,estado,fecha_real)";
					$Insertar.= " VALUES ('".$fecha."','".$observacion."', '".$cmbturno."','".$nombre."','".$mantencion."','".$gerencia."','".$Condicion_insegura."','".$fila_sistema["fecha_sistema"]."','".$Area."','".$Estado."','".$fecha_real."')";
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
		  $obs_turno="";
		  while ($fila_datos=mysqli_fetch_array($respuesta_datos))
		      {
			    $obs_turno=$obs_turno.chr(10).'TURNO '.$fila_datos["TURNO"].chr(10).$fila_datos["NOVEDAD"].chr(10);
				$fecha_obs=$fila_datos["FECHA"];
				$usuario=$fila_datos["usuario"];
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
		mysqli_close($link);	
		include("../principal/conectar_ref_web.php");	
		header ("location:ing_general.php?fecha=$fecha&opcion=$opcion&cod_novedad=$cod_novedad&turno=$cmbturno");
	}
	
	if ($Proceso == "E")
	{
		$Eliminar = "DELETE FROM ref_web.novedades WHERE COD_NOVEDAD = '".$cod_novedad."'";
		mysqli_query($link, $Eliminar);
		header ("location:general.php?fecha=$fecha");
	}	
	
	if ($Proceso2 == "ME")
	{
		
		$actualiza = "Update ref_web.novedades set estado = '2', fecha_real = '".$fecha."'";
		$actualiza.= "  WHERE COD_NOVEDAD = '".$cod_novedad."'";
		mysqli_query($link, $actualiza);
		header ("location:general_poly2.php?fecha=$fecha");
	}	   
   
	if ($Proceso2 == "E")//ELIMINA LOS DATOS SELECIONADOS PENDIENTES
	{
		$Datos=explode("~~",$ValoresElim);
		foreach($Datos as $c => $v)
		{
			
			$Eliminar = "DELETE FROM ref_web.novedades WHERE COD_NOVEDAD = '".$v."'";
			mysqli_query($link, $Eliminar);
		}	
		header ("location:general.php?fecha=$fecha&Marca=".$Marca);
	}	
	 if ($Proceso2 == "GE")//GRABA COMO REALIZADAS DATOS SELECIONADOS PENDIENTES
	{
		$Datos=explode("~~",$ValoresElim);
		foreach($Datos as $c => $v)
		{
			
			$Actualizar = "Update ref_web.novedades set estado = '3', fecha_real = '".$fecha."'";
			$Actualizar.=" WHERE COD_NOVEDAD = '".$v."'";
			mysqli_query($link, $Actualizar);
		}	
		header ("location:general_poly2.php?fecha=$fecha&Marca=".$Marca);
	}	   
  
	if ($Proceso3 == "E")//ELIMINA LOS DATOS SELECIONADOS REALIZADAS
	{
		$Datos=explode("~~",$ValoresElim2);
		foreach($Datos as $c => $v)
		{
			
			$Eliminar = "DELETE FROM ref_web.novedades WHERE COD_NOVEDAD = '".$v."'";
			//echo $Eliminar."<br>";
			mysqli_query($link, $Eliminar);
		}	
		header ("location:general.php?fecha=$fecha&Marca2=".$Marca2);
	}	   

?> 
