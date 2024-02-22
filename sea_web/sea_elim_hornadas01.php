<?php
include("../principal/conectar_sec_web.php");


f.action="sea_elim_hornadas01.php?Proceso=EM&Valores="+Valores;
if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso =  "";
}
if(isset($_REQUEST["Valores"])) {
	$Valores = $_REQUEST["Valores"];
}else{
	$Valores=  "";
}


$DatosParam=explode('//',$Valores);
	//while(list($c,$v)=each($DatosParam))
	foreach($DatosParam as $c=>$v)
	{
		$datos=explode('~',$v);	
		$Hornada=$datos[0];
		$cod_prod=$datos[1];
		$cod_subprod=$datos[2];
		$unid=$datos[3];
		$peso_unid=$datos[4];
		
		$ano=$datos[5];
		$nrohornada=$datos[6];
		$mostrar=$datos[7];
		$recargapag=$datos[8];
    	
		$graboalguno = "N";
		
		//Elimina Hornadas desde sea_web.stock
		$Elimina="DELETE FROM sea_web.stock WHERE hornada = '".$Hornada."' and cod_subproducto = '".$cod_subprod."'";
		$check=mysqli_query($link, $Elimina);
		if( $check!==true ){
			$Msj = 1;//ERROR EN LA SQL
		} else {
				$Msj = 2;// SQL CORRECTA
				$graboalguno = "S";
		}	

        if ($Msj = 2) 
		{		
        //Elimina Hornadas desde sea_web.movimientos 		
		$Elimina="DELETE FROM sea_web.movimientos WHERE hornada = '".$Hornada."' and cod_subproducto = '".$cod_subprod."'";
		$check=mysqli_query($link, $Elimina);
		if( $check!==true ){
			$Msj = 4;//ERROR EN LA SQL			
		} else {
				$Msj = 2;// SQL CORRECTA
				$graboalguno = "S";				
		}	
		}

        if ($Msj = 2) 
		{
        //Elimina Hornadas desde sea_web.relaciones 
		$Elimina="DELETE FROM sea_web.relaciones WHERE hornada_ventana = '".$Hornada."'";
		$check=mysqli_query($link, $Elimina);
		if( $check!==true ){
			$Msj = 5;//ERROR EN LA SQL		
		} else {
				$Msj = 2;// SQL CORRECTA
				$graboalguno = "S";				
		}	
		}

		if ($Msj = 2) 
		{
        //Elimina Hornadas desde sea_web.leyes_por_hornada 		
		$Elimina="DELETE FROM sea_web.leyes_por_hornada WHERE hornada = '".$Hornada."' and cod_subproducto = '".$cod_subprod."'";
		$check=mysqli_query($link, $Elimina);
		if( $check!==true ){
			$Msj = 6;//ERROR EN LA SQL		
		} else {
				$Msj = 2;// SQL CORRECTA
				$graboalguno = "S";				
		}							
		}

        if ($Msj = 2) 
		{
        //Elimina Hornadas desde sea_web.hornadas
		$Elimina="DELETE FROM sea_web.hornadas WHERE hornada_ventana = '".$Hornada."' and cod_subproducto = '".$cod_subprod."'";
		$check=mysqli_query($link, $Elimina);
		if( $check!==true ){
			$Msj = 3;//ERROR EN LA SQL	
		} else {
				$Msj = 2;// SQL CORRECTA
				$graboalguno = "S";
		}	
		}

        if ($graboalguno=='S')
		{
    	    //Inserta Persona que elimino Hornadas
			$Insertar="insert into sea_web.sea_eliminacion_hornada_auditoria01 (rut,fecha_hora,hornada,cod_producto,cod_subproducto,unidad,peso)";
			$Insertar.=" values('".$CookieRut."','".date('Y-m-d G:i:s')."','".$Hornada."','".$cod_prod."','".$cod_subprod."','".$unid."','".$peso_unid."')";
			$check=mysqli_query($link, $Insertar);
			if( $check!==true ){
				$Msj = 10;//ERROR EN LA SQL
			} 
		}
	}
header('location:sea_elim_hornadas.php?Msj='.$Msj.'&ano='.$ano.'&txthornada='.$nrohornada.'&mostrar='.$mostrar.'&recargapag='.$recargapag);
?>