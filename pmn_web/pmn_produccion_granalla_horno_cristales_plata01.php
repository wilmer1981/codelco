<?php

include("../principal/conectar_pmn_web.php");
$Rut =$CookieRut;
$Fecha = $CmbAno."-".$CmbMes."-".$CmbDias; 
switch ($Opcion)
{
	case "O"://Graba la cabecera e ingresa el N�electrolisis y cantidad de cajas 
 		$Consulta = "select * from pmn_web.produccion_granalla where fecha = '".$Fecha."' and num_caja = '".$NumCaja."'  ";
		//echo $Consulta."<br>";				
		$Respuesta=mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			//echo "Nada";
		}
		else 		
		{
			$insertar="INSERT INTO produccion_granalla(rut,fecha,num_caja,num_electrolisis,peso_bruto,valor_declarado,num_sello,promedio_cajas)";			
			$insertar.=" values ('".$Rut."','".$Fecha."','".$NumCaja."','".$NumElectrolisis."','".$PesoBruto."','".$ValorDec."','".$Sello."','".$ProCajas."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);	
		}	
	header("location:pmn_produccion_granalla_horno_cristales_plata.php?Mostrar=C&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&CmbDias=".$CmbDias."&ProCajas=".$ProCajas."&Bloquear=B");
	break;
	case "M"://Graba el detalle
	for ($j = 0;$j <= strlen($ValoresElectrolito); $j++)
	{
		if (substr($ValoresElectrolito,$j,2) == "//")
			{
				$ElectCajasPesoSello = substr($ValoresElectrolito,0,$j);
				for ($x=0;$x<=strlen($ElectCajasPesoSello);$x++)
				{
					if (substr($ElectCajasPesoSello,$x,2) == "~~")
					{
						$Electrolito = substr($ElectCajasPesoSello,0,$x);			
						$CajasPesoSello = substr($ElectCajasPesoSello,$x+2,strlen($ElectCajasPesoSello));
						for ($y = 0 ; $y <=strlen($CajasPesoSello); $y++ )
						{
							if (substr($CajasPesoSello,$y,2)=="||")
							{
								$Cajas = substr($CajasPesoSello,0,$y);
								$PesoSello =substr($CajasPesoSello,$y+2,strlen($CajasPesoSello));
								for ($f = 0 ; $f <=strlen($PesoSello); $f++ )
								{
									if (substr($PesoSello,$f,2)=="@@")
									{	
									$Peso=substr($PesoSello,0,$f);
									$Sello=substr($PesoSello,$f+2,strlen($PesoSello));
									if ($Peso!= "")
									{
										$PesoSobrante=($Peso-$ProCajas);	
									}
									else
									{
										$PesoSobrante="NULL";
										$Peso="NULL";
									}
									if ($Sello=="")
									{
										$Sello="NULL";
									}
									if ($PesoSobrante <= '0')
									{
										$PesoSobrante="NULL";
									}
									$Actualizar="UPDATE pmn_web.produccion_granalla set peso = ".str_replace(",",".",$Peso).",peso_sobrante= ".str_replace(",",".",$PesoSobrante).",sello=".str_replace(",",".",$Sello)." where num_electrolisis = '".$Electrolito."' and caja = '".$Cajas."'";	
									mysqli_query($link, $Actualizar);								
									}
								}
							}
						}
					}
				}
			$ValoresElectrolito = substr($ValoresElectrolito,$j + 2);
			$j = 0;
			}
		}					
	header("location:pmn_produccion_granalla_horno_cristales_plata.php?Mostrar=C&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&CmbDias=".$CmbDias."&CmbOperador=".$CmbOperador."&TxtObservacion=".$TxtObservacion."&ProCajas=".$ProCajas."&Bloquear=".$Bloquear);
	break;
	case "E2"://Borra el detalle
	for ($j = 0;$j <= strlen($ValoresElectrolito); $j++)
	{
		if (substr($ValoresElectrolito,$j,2) == "//")
			{
				$ElectCajasPeso = substr($ValoresElectrolito,0,$j);
				for ($x=0;$x<=strlen($ElectCajasPeso);$x++)
				{
					if (substr($ElectCajasPeso,$x,2) == "~~")
					{
						$Electrolito = substr($ElectCajasPeso,0,$x);			
						$CajasPeso = substr($ElectCajasPeso,$x+2,strlen($ElectCajasPeso));
						for ($y = 0 ; $y <=strlen($CajasPeso); $y++ )
						{
							if (substr($CajasPeso,$y,2)=="||")
							{
								$Cajas = substr($CajasPeso,0,$y);
								$Peso =substr($CajasPeso,$y+2,strlen($CajasPeso));
								$Eliminar="delete from pmn_web.produccion_granalla where num_electrolisis = '".$Electrolito."' and caja = '".$Cajas."' and fecha = '".$Fecha."'";
								mysqli_query($link, $Eliminar);		
							}
						}
					}
				}
			$ValoresElectrolito = substr($ValoresElectrolito,$j + 2);
			$j = 0;
			}
		}					
	header("location:pmn_produccion_granalla_horno_cristales_plata.php?Mostrar=C&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&CmbDias=".$CmbDias."&CmbOperador=".$CmbOperador."&TxtObservacion=".$TxtObservacion."&ProCajas=".$ProCajas."&Bloquear=".$Bloquear);
	break;
	case "E":
		$Eliminar="delete from pmn_web.produccion_granalla where  fecha = '".$Fecha."'";
		//echo $Eliminar."<br>";
		mysqli_query($link, $Eliminar);		
		header("location:pmn_produccion_granalla_horno_cristales_plata.php");
	break;

}
?>
