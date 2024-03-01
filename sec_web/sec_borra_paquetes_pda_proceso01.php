<?php
	include("../principal/conectar_principal.php");
	$EncontroRelacion=false;
	
	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Buscar  = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$TxtFechaFin  = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:date('Y-m-d');

	switch ($Proceso)
	{
		case "E"://ELIMINAR TRANSPORTE
			$EncontroRelacion=false;
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
					$Datos1 = explode('~',$Valor);
					$Fecha   = $Datos1[0];
					$Patente = $Datos1[1];
					$Codigo  = $Datos1[2];
					$Numero  = $Datos1[3];
					//echo "Valor".$Valor;
					
					$Consulta = "SELECT * from sec_web.paquetes_pda where fecha_hora = '".$Fecha."' and patente = '".$Patente."' and cod_paquete = '".$Codigo."' and num_paquete = '".$Numero."' ";
					//$Consulta = "SELECT * from sec_web.paquetes_pda where fecha_hora = '".$Valor."' ";
					//echo "RRR".$Consulta;

					$Respuesta =mysqli_query($link, $Consulta);
					if($Fila =mysqli_fetch_array($Respuesta))
					{
						$Elimina= "delete from sec_web.paquetes_pda where fecha_hora = '".$Fila["fecha_hora"]."' and patente = '".$Fila["patente"]."' and cod_paquete = '".$Codigo."' and num_paquete = '".$Numero."' ";
						//echo "EEE".$Elimina;
						mysqli_query($link, $Elimina);		
					}
			}
			break;	
						
	}
	
	if ($Proceso=="E")
	{
		//header("location:sec_borra_paquetes_pda_otro.php?Buscar=S&TxtBuscar=".$TxtBuscar."&TxtFechaFin=".$TxtFechaFin);
		header("location:sec_borra_paquetes_pda_otro.php?Buscar=S&Buscar=".$Buscar."&TxtFechaFin=".$TxtFechaFin);
	}
	
?>