<?php
	include("../principal/conectar_pmn_web.php");
	$Rut =$CookieRut;
	$Fecha = $Ano."-".$Mes."-".$Dia;
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Consulta = "select * from pmn_web.carga_electrolito_cubas_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.carga_electrolito_cubas_plata set";
				$Actualizar.= " operador = '".$Operador."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";				
				$Actualizar.= " and num_electrolisis = '".$NumElectrolisis."'";
				//echo $Actualizar."<br>"; 
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.carga_electrolito_cubas_plata ";
				$Insertar.= "(rut, fecha, num_electrolisis,operador) ";
				$Insertar.= "values('".$Rut."','".$Fecha."','".$NumElectrolisis."','".$Operador."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
				for ($i=1;$i<=6;$i++)
				{
					//Insertar
					$Insertar = "INSERT INTO pmn_web.detalle_cubas_electrolito_plata ";
					$Insertar.= "(rut, fecha, num_electrolisis,num_cubas) ";
					$Insertar.= "values('".$Rut."','".$Fecha."','".$NumElectrolisis."','".$i."')";
					mysqli_query($link, $Insertar);
				}		
				
			}
			header("location:pmn_carga_electrolito_cubas.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumElectrolisis=".$NumElectrolisis."&Operador=".$Operador);
			break;
		case "G2": //GRABAR
			if (count($ChkElectrolisis)>0)
			{
				while (list($i,$p) = each($ChkElectrolisis))
				{
					//Actualizar
					$Actualizar = "UPDATE pmn_web.detalle_cubas_electrolito_plata set ";
					$Actualizar.= " nitrato_plata = '".$ChkNitrato[$i]."', ";
					$Actualizar.= " acido_nitrico = '".$ChkAcido[$i]."'  ";
					$Actualizar.= " where fecha = '".$Fecha."' ";				
					$Actualizar.= " and num_electrolisis = '".$p."'";
					$Actualizar.= " and num_cubas = '".$ChkCubas[$i]."' ";		
					mysqli_query($link, $Actualizar);
				}
			}	
			header("location:pmn_carga_electrolito_cubas.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumElectrolisis=".$NumElectrolisis."&Operador=".$Operador);
			break;
		case "M":
			if (count($ChkElectrolisis)>0)
			{
				while (list($i,$p) = each($ChkElectrolisis))
				{
					header("location:pmn_carga_electrolito_cubas.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumElectrolisis=".$p."&NumCubas=".$ChkCubas[$i]."&NitratoPlata=".$ChkNitrato[$i]."&AcidoNitrico=".$ChkAcido[$i]."&Operador=".$Operador);
				}
			}
			else
			{
				header("location:pmn_carga_electrolito_cubas.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			break;
		case "E":
			$Eliminar="delete from pmn_web.carga_electrolito_cubas_plata where  fecha = '".$Fecha."' and num_electrolisis = '".$NumElectrolisis."'";
			mysqli_query($link, $Eliminar);		
			$Eliminar="delete from pmn_web.detalle_cubas_electrolito_plata where  fecha = '".$Fecha."' and num_electrolisis = '".$NumElectrolisis."'";
			mysqli_query($link, $Eliminar);		
			header("location:pmn_carga_electrolito_cubas.php");
			break;
		case "E2":
			if (count($ChkElectrolisis)>0)
			{
				while (list($i,$p) = each($ChkElectrolisis))
				{
					// ELIMINA DETALLE
					$Eliminar = "delete from  pmn_web.detalle_cubas_electrolito_plata ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and num_electrolisis = '".$p."'";					
					$Eliminar.= " and num_cubas = '".$ChkCubas[$i]."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
				}
			}

			header("location:pmn_carga_electrolito_cubas.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumElectrolisis=".$NumElectrolisis);
			break;
			case "S":
			
			if (count($checkbox)>0)
			{  $valores = explode("~",$parametros);
		        while(list($c,$v) = each($valores))
		            {
					 $Eliminar = "delete from  pmn_web.detalle_cubas_electrolito_plata ";
					 $Eliminar.= " and num_electrolisis = '".$v."'";					
					 //echo $Eliminar."<br>";
					 mysqli_query($link, $Eliminar);
					}
			}		
			
			
		case "C": //CANCELAR
			header("location:pmn_carga_electrolito_cubas.php");
			break;
	}
?>