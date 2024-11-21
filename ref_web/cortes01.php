<?php
include("../principal/conectar_ref_web.php");  

	$ano1   = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");
	$mes1   = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
	$dia1   = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");
	$parametros   = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";
	$guardar      = isset($_REQUEST["guardar"])?$_REQUEST["guardar"]:"";
	$modificar    = isset($_REQUEST["modificar"])?$_REQUEST["modificar"]:"";
	$circuito     = isset($_REQUEST["circuito"])?$_REQUEST["circuito"]:"";
 
 if ($guardar == "S")
	{
	    if ( strlen($mes1)==1 )
           {$mes1='0'.$mes1;}	
        if ( strlen($dia1)==1 )
           {$dia1='0'.$dia1;}	
		$fecha = $ano1.'-'.$mes1.'-'.$dia1;
		$arreglo = explode("/",$parametros); //Separa los parametros en un array.
		reset($arreglo);					
		foreach($arreglo as $clave => $valor)
		{		
			$detalle = explode("~",$valor);
			if ($detalle[0]!='')
               { if ($detalle[2]=='')
			        {$detalle[2]=0;}
				 if ($detalle[3]=='')
				    {$detalle[3]=0;}
					}
				$consulta="select * from ref_web.cortocircuitos where fecha='".$fecha."' and cod_circuito='".$circuito."' and cod_grupo='".$detalle[0]."'";
				$rs = mysqli_query($link, $consulta);
				if (!$fila=mysqli_fetch_array($rs))		 
			       {
				     if($detalle[0]<>'')
					   {  
					    $insertar = "INSERT INTO ref_web.cortocircuitos (cod_grupo,cod_circuito,cont_dia,fecha,cortos_nuevo,cortos_semi)"; 
					    $insertar = $insertar."VALUES ('".$detalle[0]."','".$circuito."','".$detalle[1]."','".$fecha."','".$detalle[2]."','".$detalle[3]."')";
					    //echo $insertar."<br>";
					    mysqli_query($link, $insertar);
					    $insertar2 = "INSERT INTO ref_web.observaciones (fecha,cod_circuito,cod_grupo,normal,rayado,cristalizado,granulado,c_barro,cordon,rigido,abierto,abierto_c_barro,cerrado,cristalizado2,puntual,extendido,fino,estampa,dispersa,remache,oreja,superior,inferior,lateral,Obs_gen)"; 
					    $insertar2 = $insertar2."VALUES ('".$fecha."','".$circuito."','".$detalle[0]."','".$detalle[4]."','".$detalle[5]."','".$detalle[6]."','".$detalle[7]."','".$detalle[8]."','".$detalle[9]."','".$detalle[10]."','".$detalle[11]."',";
					    $insertar2=$insertar2."'".$detalle[12]."','".$detalle[13]."','".$detalle[14]."','".$detalle[15]."','".$detalle[16]."','".$detalle[17]."','".$detalle[18]."','".$detalle[19]."','".$detalle[20]."','".$detalle[21]."','".$detalle[22]."','".$detalle[23]."','".$detalle[24]."','".$detalle[25]."') ";
					    mysqli_query($link, $insertar2);
					    //echo $insertar2."<br>";
						$fecha = $ano1.'-'.$mes1.'-'.$dia1;
					    $Mensaje = "Los datos fueron ingresados correctamente";						
		                header("Location:cortes2_aux.php?fecha=$fecha&Mensaje=".$Mensaje);
						}
					}		 
				else {$fecha = $ano1.'-'.$mes1.'-'.$dia1;
				      $Mensaje = "Los datos ingresados ya existen, reingrese";						
		              header("Location:cortes2_aux.php?fecha=$fecha&Mensaje=".$Mensaje);}	
       }			
		
	}
if ($modificar=='S')
   	{
	    if ( strlen($mes1)==1 )
           {$mes1='0'.$mes1;}	
        if ( strlen($dia1)==1 )
           {$dia1='0'.$dia1;}
		$fecha = $ano1.'-'.$mes1.'-'.$dia1;
		$arreglo = explode("/",$parametros); //Separa los parametros en un array.
		reset($arreglo);					
		foreach($arreglo as $clave => $valor)
		{		
			$detalle = explode("~",$valor);
			if ($detalle[0]!='')
            { 
				if ($detalle[2]=='')
			        {$detalle[2]=0;}
				if ($detalle[3]=='')
				    {$detalle[3]=0;}
			}
			var_dump($detalle);
					
					   $actualizar1 = "UPDATE ref_web.cortocircuitos SET cortos_nuevo = '".$detalle[2]."', cortos_semi = '".$detalle[3]."'";
		               $actualizar1.= " WHERE cod_grupo = '".$detalle[0]."' and fecha='$fecha' ";
					   echo "<br><br>".$actualizar1."<br>";
		               mysqli_query($link, $actualizar1);
					   //echo $actualizar1;	
						//try { 					   
					   $actualizar = "UPDATE ref_web.observaciones SET normal = '".$detalle[4]."', rayado = '".$detalle[5]."', cristalizado='".$detalle[6]."', granulado='".$detalle[7]."', c_barro='".$detalle[8]."',";
					   $actualizar.=" cordon='".$detalle[9]."', rigido='".$detalle[10]."', abierto='".$detalle[11]."', abierto_c_barro='".$detalle[12]."',cerrado='".$detalle[13]."',cristalizado2='".$detalle[14]."',puntual='".$detalle[15]."', ";
					   $actualizar.="extendido='".$detalle[16]."',fino='".$detalle[17]."', estampa='".$detalle[18]."', dispersa='".$detalle[19]."',remache='".$detalle[20]."',oreja='".$detalle[21]."', superior='".$detalle[22]."', inferior='".$detalle[23]."', lateral='".$detalle[24]."', Obs_gen='".$detalle[25]."' ";
		               $actualizar.= " WHERE cod_grupo = '".$detalle[0]."' and fecha='$fecha' ";
					   echo "<br>actualizar:".$actualizar."<br>";
		               mysqli_query($link, $actualizar);
					  	
					//} catch (mysqli_sql_exception $e) { 
						  //var_dump($e);
						 // exit; 
					  // } 					   
						
					    //echo $insertar2."<br>";
					    $Mensaje = "Los datos fueron modificados correctamente";						
		               // header("Location:cortes2_aux.php?fecha=$fecha&Mensaje=".$Mensaje);
					
        }			
		
	}


?> 
