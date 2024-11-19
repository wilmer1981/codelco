<?php include("../principal/conectar_ref_web.php");
	$CookieRut   = $_COOKIE["CookieRut"];
	$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$opcion       = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";  
	$cod_novedad  = isset($_REQUEST["cod_novedad"])?$_REQUEST["cod_novedad"]:"";
	$mantencion  = isset($_REQUEST["mantencion"])?$_REQUEST["mantencion"]:"";
	$pte         = isset($_REQUEST["pte"])?$_REQUEST["pte"]:"";
	$Condicion_insegura  = isset($_REQUEST["Condicion_insegura"])?$_REQUEST["Condicion_insegura"]:"";
	$observacion  = isset($_REQUEST["observacion"])?$_REQUEST["observacion"]:"";
	$cmbturno  = isset($_REQUEST["cmbturno"])?$_REQUEST["cmbturno"]:"";
	$Estado       = isset($_REQUEST["Estado"])?$_REQUEST["Estado"]:"";
	$Area         = isset($_REQUEST["Area"])?$_REQUEST["Area"]:"";
	$fecha    = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$dia1      = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");
	$mes1      = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
    $ano1      = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");
	
	
    $consulta="select * from proyecto_modernizacion.funcionarios where rut='".$CookieRut."'  ";
	$rss = mysqli_query($link, $consulta);
	$rows = mysqli_fetch_array($rss);
    $nombre=$rows["nombres"]." ".$rows["apellido_paterno"]." ".$rows["apellido_materno"];
	
	if ($Proceso == "G")
	{
        $consulta="select * from ref_web.novedades_jefe_pte where COD_NOVEDAD = '".$cod_novedad."'";
		$respuesta = mysqli_query($link, $consulta);
		if ($fila1=mysqli_fetch_array($respuesta))
		  {
		     if ($mantencion!='S')
			   {
		        $actualizar="UPDATE ref_web.novedades_jefe_pte set NOVEDAD='".$observacion."', TURNO='".$cmbturno."',usuario='".$nombre."',mantencion='".$mantencion."',Condicion_insegura='".$Condicion_insegura."',pte='".$pte."' where COD_NOVEDAD='".$cod_novedad."'";
			   }
			  else{
			       $fecha_compromiso=$ano1.'-'.$mes1.'-'.$dia1;
				    if ($Estado=='2')
				     {
					  $consulta1="SELECT LEFT(SYSDATE(),10) as fecha_sistema";
					  $respuesta_sistema = mysqli_query($link, $consulta1);
		              $fila_sistema=mysqli_fetch_array($respuesta_sistema); 
					  $fecha_real=$fila_sistema['fecha_sistema'];
					 }
				  else {
				         $fecha_real='0000-00-00';
				       }	 
			       $actualizar="UPDATE ref_web.novedades_jefe_pte set NOVEDAD='".$observacion."', TURNO='".$cmbturno."', usuario='".$nombre."', mantencion='".$mantencion."',Condicion_insegura='".$Condicion_insegura."',";
				   $actualizar.="compromiso='".$fecha_compromiso."', area='".$Area."', estado='".$Estado."',pte='".$pte."',fecha_real='".$fecha_real."' where COD_NOVEDAD='".$cod_novedad."'";
			      }    	
			//echo $actualizar;
			mysqli_query($link, $actualizar);
		  }
		else {
		       if ($mantencion!='S')
			      {
				   $Insertar = "INSERT INTO ref_web.novedades_jefe_pte (FECHA,NOVEDAD, TURNO,usuario,mantencion,Condicion_insegura,pte)";
				   $Insertar.= " VALUES ('".$fecha."','".$observacion."', '".$cmbturno."','".$nombre."','".$mantencion."','".$Condicion_insegura."','".$pte."')";
				  }
			   else {
			         $consulta1="SELECT LEFT(SYSDATE(),10) as fecha_sistema";
					 $respuesta_sistema = mysqli_query($link, $consulta1);
		             $fila_sistema=mysqli_fetch_array($respuesta_sistema);
					 $fecha_real='0000-00-00';
			         $Insertar = "INSERT INTO ref_web.novedades_jefe_pte (FECHA,NOVEDAD, TURNO, usuario,mantencion,Condicion_insegura,compromiso,area,estado,pte,fecha_real)";
					 $Insertar.= " VALUES ('".$fecha."','".$observacion."', '".$cmbturno."','".$nombre."','".$mantencion."','".$Condicion_insegura."','".$fila_sistema['fecha_sistema']."','".$Area."','".$Estado."','".$pte."','".$fecha_real."')";
		            }	  	  
		      //echo $Insertar;
              mysqli_query($link, $Insertar);
			 } 
		//header ("location:ing_general_jefe_pte.php?fecha=$fecha");
	    header ("location:ing_general_jefe_pte.php?fecha=$fecha&opcion=$opcion&cod_novedad=$cod_novedad&turno=$cmbturno");
	}
	if ($Proceso == "E")
	{
		$Eliminar = "DELETE FROM ref_web.novedades_jefe_pte WHERE COD_NOVEDAD = '".$cod_novedad."'";
		mysqli_query($link, $Eliminar);
		header ("location:general_jefe_pte.php?fecha=$fecha");
	}	   

?> 
