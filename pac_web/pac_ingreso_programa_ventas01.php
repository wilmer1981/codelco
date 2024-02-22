<?php
	include("../principal/conectar_pac_web.php");
	$Rut =$CookieRut;
	switch ($Proceso)
	{
		case "O": //GRABAR
			$Consulta="select * from pac_web.programa_ventas ";
			$Consulta.=" where nro_contrato = '".$CmbContrato."' ";
			//echo $Consulta."<br>";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Mostrar='S';
			}
			else
			{
				$Insertar = "insert into pac_web.programa_ventas ";
				$Insertar.= "(rut_cliente,nro_contrato,tonelaje_total,fecha) ";
				$Insertar.= "values('".$CmbCliente."','".$CmbContrato."','".str_replace(",",".",$Tonelada)."','".$FechaHora."')";
				mysqli_query($link, $Insertar);
				$CmbCliente="";
			}
			header("location:pac_ingreso_programa_ventas.php?Mostrar=".$Mostrar."&CmbCliente=".$CmbCliente);
			break;
		case "G": //GRABAR
			if (count($ChkContrato1)>0)
			{
				while (list($i,$p) = each($ChkContrato1))
				{
					if ($ChkTonelaje1[$i]=='')
					{
						$ChkTonelaje1[$i]="NULL";
					}
					if ($ChkTonelaje2[$i]=='')
					{
						$ChkTonelaje2[$i]="NULL";
					}
					if ($ChkTonelaje3[$i]=='')
					{
						$ChkTonelaje3[$i]="NULL";
					}
					if ($ChkTonelaje4[$i]=='')
					{
						$ChkTonelaje4[$i]="NULL";
					}
					if ($ChkTonelaje5[$i]=='')
					{
						$ChkTonelaje5[$i]="NULL";
					}
					if ($ChkTonelaje6[$i]=='')
					{
						$ChkTonelaje6[$i]="NULL";
					}
					if ($ChkTonelaje7[$i]=='')
					{
						$ChkTonelaje7[$i]="NULL";
					}
					if ($ChkTonelaje8[$i]=='')
					{
						$ChkTonelaje8[$i]="NULL";
					}
					if ($ChkTonelaje9[$i]=='')
					{
						$ChkTonelaje9[$i]="NULL";
					}
					if ($ChkTonelaje10[$i]=='')
					{
						$ChkTonelaje10[$i]="NULL";
					}
					if ($ChkTonelaje11[$i]=='')
					{
						$ChkTonelaje11[$i]="NULL";
					}
					if ($ChkTonelaje12[$i]=='')
					{
						$ChkTonelaje12[$i]="NULL";
					}
								//Actualizar
					$Actualizar = "UPDATE pac_web.programa_ventas set ";
					$Actualizar.= " tonelaje1 = ".str_replace(",",".",$ChkTonelaje1[$i]).", ";
					$Actualizar.= " tonelaje2 = ".str_replace(",",".",$ChkTonelaje2[$i]).",  ";
					$Actualizar.= " tonelaje3 = ".str_replace(",",".",$ChkTonelaje3[$i]).",  ";
					$Actualizar.= " tonelaje4 = ".str_replace(",",".",$ChkTonelaje4[$i]).",  ";
					$Actualizar.= " tonelaje5 = ".str_replace(",",".",$ChkTonelaje5[$i]).", ";
					$Actualizar.= " tonelaje6 = ".str_replace(",",".",$ChkTonelaje6[$i]).",  ";
					$Actualizar.= " tonelaje7 = ".str_replace(",",".",$ChkTonelaje7[$i]).",  ";
					$Actualizar.= " tonelaje8 = ".str_replace(",",".",$ChkTonelaje8[$i]).",  ";
					$Actualizar.= " tonelaje9 = ".str_replace(",",".",$ChkTonelaje9[$i]).", ";
					$Actualizar.= " tonelaje10 = ".str_replace(",",".",$ChkTonelaje10[$i]).",  ";
					$Actualizar.= " tonelaje11 = ".str_replace(",",".",$ChkTonelaje11[$i]).",  ";
					$Actualizar.= " tonelaje12 = ".str_replace(",",".",$ChkTonelaje12[$i])."  ";
					$Actualizar.= " where nro_contrato = '".$p."'";
					$Actualizar.= " and rut_cliente = '".$ChkCliente[$i]."'";
					mysqli_query($link, $Actualizar);
				}
			}	
			header("location:pac_ingreso_programa_ventas.php");
			break;
		case "E":
			if (count($ChkContrato1)>0)
			{
				while (list($i,$p) = each($ChkContrato1))
				{
					// ELIMINA DETALLE
					$Eliminar = "delete from  pac_web.programa_ventas ";
					$Eliminar.= " where nro_contrato = '".$p."'"; 
					$Eliminar.= " and rut_cliente = '".$ChkCliente[$i]."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
				}
			}

			header("location:pac_ingreso_programa_ventas.php");
			break;
		
	}
?>