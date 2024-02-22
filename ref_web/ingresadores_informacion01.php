<?php
	include("../principal/conectar_ref_web.php");
	if ($Proceso == "G")
	{
		$activar=1;
		$corriente =0;
		$corriente1 =0;
		$fecha = $ano1.'-'.$mes1.'-'.$dia1;
		$Col=1;
		$arreglo = explode("~",$Valor1); //Separa los parametros en un array.
		reset($arreglo);					
		while (list($clave, $valor) = each($arreglo))
		{		
			$corriente = $valor;
			if ($Col == '7')
				$rectificador = '49';
			else
				$rectificador = $Col;
			$jefe1 =$jefe;
			$Consulta = "select * from ref_web.rectificador_modificado where fecha = '".$fecha."' and cod_rectificador = '".$rectificador."'";
			//echo "FF".$Consulta;
			$rsp = mysqli_query($link, $Consulta);
			if ($fila=mysqli_fetch_array($rsp))
			{
				$Actualiza = "UPDATE ref_web.rectificador_modificado set corriente_aplicada = '".$corriente."', jefe_turno = '".$jefe1."'";
				$Actualiza.=" where fecha = '".$fecha."' and cod_rectificador = '".$rectificador."'";
				//echo "AA".$Actualiza;
				mysqli_query($link, $Actualiza);
			}
			else  
			{
				$insertar = "INSERT INTO ref_web.rectificador_modificado (fecha,cod_rectificador,corriente_aplicada,jefe_turno)"; 
				$insertar = $insertar."VALUES ('".$fecha."','".$rectificador."','".$corriente."','".$jefe1."')";
				//echo $insertar."<br>";
				mysqli_query($link, $insertar);
			}
			$Col++;
		}
		$Col=1;
		$arreglo = explode("~",$Valor2); //Separa los parametros en un array.
		reset($arreglo);					
		while (list($clave, $valor) = each($arreglo))
		{		
			$corriente1 = $valor;
			$cuba = $Col;
			$jefe2 =$jefe;
			$Consulta1="select * from ref_web.cubas_descobrizacion where fecha = '".$fecha."' and cod_cuba = '".$cuba."'";
			//echo $Consulta1."</br>";
			$rsp1 = mysqli_query($link, $Consulta1);
			if ($fila1=mysqli_fetch_array($rsp1))
			{
				$Actualiza1="UPDATE ref_web.cubas_descobrizacion set corriente_aplicada = '".$corriente1."',jefe_turno = '".$jefe2."'";
				$Actualiza1.=" where fecha = '".$fecha."' and cod_cuba ='".$cuba."'";
				//echo $Actualiza1."</br>";
				mysqli_query($link, $Actualiza1);
			}
			else
			{
				$insertar = "INSERT INTO ref_web.cubas_descobrizacion (fecha,cod_cuba,corriente_aplicada,jefe_turno)"; 
				$insertar = $insertar."VALUES ('".$fecha."','".$cuba."','".$corriente1."','".$jefe2."')";
				mysqli_query($link, $insertar);
			}
			$Col++;
		}			
	}	
	
		
		$mensaje = "Datos Actualizados Correctamente";						
		header("Location:ingresadores_informacion.php?fecha=".$fecha."&mensaje=".$mensaje."&activar=".$activar);		
		include("../principal/conectar_ref_web.php");
	

?>