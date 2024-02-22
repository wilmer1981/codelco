<?php
include("conectar_principal.php");

if(isset($_GET["Proceso"])){
	$Proceso = $_GET["Proceso"];
}else{
	$Proceso = "";
}
//if($Proceso=='G'){
	$CCosto = $_REQUEST["CCosto"];
	$Descripcion = $_REQUEST["Descripcion"];
	$MostrarCal = $_REQUEST["MostrarCal"];
	$MostrarFrx = $_REQUEST["MostrarFrx"];
	$CmbArea = $_REQUEST["CmbArea"];
//}
	
 $centros = 0;
 $buena = 0;
 $error=0;
switch ($Proceso)
{
	case "A":
		$CreaPaso="CREATE table if not exists proyecto_modernizacion.tmp_ccostos  (ccosto varchar(10) not null default '',";
		$CreaPaso.="descrip varchar(50) not null default '', mostrar_cal char(1) not null default '',";
		$CreaPaso.="mostrar_frx char(1) not null default '', ccosto_enm varchar(10) not null default '',";
		$CreaPaso.="cod_area varchar(10) not null default '')";
		mysqli_query($link, $CreaPaso);
		
		$Borrado="delete from  proyecto_modernizacion.tmp_ccostos";
		mysqli_query($link, $Borrado);
		$Consulta="SELECT * FROM proyecto_modernizacion.centro_costo";
		$Respuesta=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			$Inserta="INSERT into proyecto_modernizacion.tmp_ccostos (ccosto,descrip,mostrar_cal,mostrar_frx,";
			$Inserta.="ccosto_enm,cod_area) values ('".$Fila["CENTRO_COSTO"]."','".$Fila["DESCRIPCION"]."','".$Fila["MOSTRAR_CALIDAD"]."',";
			$Inserta.="'".$Fila["MOSTRAR_FRX"]."','".$Fila["centro_costo_enm"]."','".$Fila["cod_area"]."')";
			mysqli_query($link, $Inserta);
			$centros = $centros + 1;
		} 
		$fp2= fopen ("../principal/archivos/ccostos.csv","r");
		
		$row2=0;
		//$data2= array();
		//while ($data2 = fgetcsv ($fp2, 1000, ",;"))
		while($data2 = fgetcsv($fp2, 1000, ";"))
  		{
			$num2 = count($data2);
          	$row2++;
          	for ($c2=0; $c2<$num2; $c2++)
          	{
				$var2     = $data2[$c2];  
				$costo    =  $data2[9];
				$nomcosto =  $data2[10];  
                //list($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$costo,$nomcosto) = split('[,;]',$var2);
	
				//list($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9,$costo,$nomcosto) = explode(";", $var2);
						
              	$consulta ="SELECT * from proyecto_modernizacion.tmp_ccostos where ccosto = '".strtoupper($costo)."'";
				$Resp1=mysqli_query($link, $consulta);

				if ($row=mysqli_fetch_array($Resp1))
				{
					//echo "entro al IF";
					$Actualiza="UPDATE proyecto_modernizacion.centro_costo seT DESCRIPCION = '".strtoupper($nomcosto)."',";
					$Actualiza.="MOSTRAR_CALIDAD = '".$row["mostrar_cal"]."',MOSTRAR_FRX = '".$row["mostrar_frx"]."'";
					$Actualiza.=" where CENTRO_COSTO = '".strtoupper($costo)."'";
					mysqli_query($link, $Actualiza);
					$buena = $buena + 1;
				}
				else
				{
					//echo "entro al ELSE";
				  	$insertar="INSERT into proyecto_modernizacion.centro_costo (centro_costo,descripcion,mostrar_calidad,";
					$insertar.="mostrar_frx,centro_costo_enm,cod_area) values ('".strtoupper($costo)."','".strtoupper($nomcosto)."',";
					$insertar.="'','N','9999','')";
					mysqli_query($link, $insertar);
					$buena = $buena + 1;
				 }
		    }
		}
    	fclose($fp2);

		/*
		$insertar="INSERT into proyecto_modernizacion.centro_costo (centro_costo,descripcion,mostrar_calidad,";
		$insertar.="mostrar_frx,centro_costo_enm) values ('9999','C.COSTO EXTERNOS','S','N','9999')";
		mysqli_query($link, $insertar);
		$buena = $buena + 1;
		*/

		$fp3= fopen ("../principal/archivos/cecos2.csv","r");
		$row3=0;
    	while ($data3 = fgetcsv ($fp3, 1000, ";"))
    	{
			$num3 = count ($data3);
          	$row3++;
          	for ($c3=0; $c3<$num3; $c3++)
          	{
            	$var3 = $data3[$c3];
                //list($costo2,$descripcion2) = split('[,;]',$var3);
				$costo2       =  $data3[0];
				$descripcion2 =  $data3[1];  
				//echo  "++".$num3."++".$costo2."++".$descripcion2."<br>";
				$buscar="SELECT * from proyecto_modernizacion.centro_costo where centro_costo = '".strtoupper($costo2)."'";
				$resp2=mysqli_query($link, $buscar);
				$Fila1=mysqli_fetch_array($resp2);
				if ($Fila1["CENTRO_COSTO"]=="")
				{
					$insertar="INSERT into proyecto_modernizacion.centro_costo (CENTRO_COSTO,DESCRIPCION,MOSTRAR_CALIDAD,";
					$insertar.="MOSTRAR_FRX) values ('".strtoupper($costo2)."','".strtoupper($descripcion2)."','','N')";
					mysqli_query($link, $insertar);
					$buena = $buena + 1;
				}
			}
		}
		fclose($fp3);
		if ($buena>0)
			$mensaje = "Costos Actualizados  Correctamente";
			else
			$mensaje= "Actualizacion con Errores Revise";
			break;
	case "G":
			$Consulta="SELECT * from proyecto_modernizacion.centro_costo WHERE centro_costo = '".strtoupper($CCosto)."'";
			$Resp=mysqli_query($link, $Consulta);
			if ($Fil=mysqli_fetch_array($Resp))
			{
				$Actualiza="UPDATE proyecto_modernizacion.centro_costo SET DESCRIPCION = '".strtoupper($Descripcion)."',";
				$Actualiza.="MOSTRAR_CALIDAD='".strtoupper($MostrarCal)."', MOSTRAR_FRX='".strtoupper($MostrarFrx)."', cod_area='".$CmbArea."'";
				$Actualiza.=" where centro_costo = '".strtoupper($CCosto)."'";
				mysqli_query($link, $Actualiza);
				$buena = $buena + 1;
			}
			else
			{
				$insertar="INSERT into proyecto_modernizacion.centro_costo (CENTRO_COSTO,DESCRIPCION,MOSTRAR_CALIDAD,MOSTRAR_FRX,";
				$insertar.="centro_costo_enm,cod_area) values ('".strtoupper($CCosto)."','".strtoupper($Descripcion)."',";
				$insertar.="'".strtoupper($MostrarCal)."','".strtoupper($MostrarFrx)."',";
				$insertar.="'9999','".$CmbArea."')";
				mysqli_query($link, $insertar);
				$buena = $buena + 1;
			}
			if ($buena>0)
			{
				$mensaje = "C.Costo  Grabado Correctamente";
			}
			else
			{
				$mensaje = "Error al Grabar C.Costo ".$CCosto;
				$error=1;
			}
			break;
	case "E":					
			$Consulta ="SELECT * from proyecto_modernizacion.centro_costo where centro_costo ='".strtoupper($CCosto)."'";
			$Respu=mysqli_query($link, $Consulta);
			if ($Row=mysqli_fetch_array($Respu))
			{
				$EliminoCC="DELETE from proyecto_modernizacion.centro_costo where centro_costo = '".strtoupper($CCosto)."'";
				mysqli_query($link, $EliminoCC);
				$buena = $buena + 1;
			}
			if ($buena>0)
			{
				$mensaje = "Eliminacion de C.Costo OK";
			}
			else
			{
				$mensaje = "Error al eliminar C. Costo ".$CCosto;
				$error = 1;
			}
			break;
	}
	if ($error==1)
			header("Location:actualiza_costos.php?Proceso=B&error=1&mensaje=".$mensaje);
			else
			header("Location:actualiza_costos.php?Proceso=N&error=0&mensaje=".$mensaje);
	
	include("cerrar_principal.php");
?>	