<?php
	include("../principal/conectar_principal.php");
	$Mensaje = "";
	switch ($Proceso)
	{		
		case "G":
			//echo count($Participa)."<br>";
			//echo $TipoProd."<br>";
			while (list($i,$v) = each($Participa))
			{				
				if ($v != "0")
				{
					$Peso = $PesoProd[$i];
					//echo $Peso."<br>";
					$Error = false;					
					if ($Participa[$i] == "P")//PARCIAL
					{						
						//CONSULTO SI TIENE PESADA VIRTUAL
						$Consulta = "select * from sec_web.produccion_desc_normal ";
						$Consulta.= " where fecha_produccion = '".$Fecha[$i]."'";
						$Consulta.= " and cod_grupo = '99'";
						$Consulta.= " and cod_cuba = '".str_pad($Grupo[$i],2,0,STR_PAD_LEFT)."'";
						$Consulta.= " and cod_lado = '".$TipoProd."'";
						//echo $Consulta."<br>";
						$Respuesta2 = mysqli_query($link, $Consulta);
						if ($Fila2 = mysqli_fetch_array($Respuesta2))
						{
							//consulto si fue asignado, pero tengo que considerar que este registro ya tiene asignado peso.
							
							//CONSULTO SI YA FUE ASIGNADO PESO PARCIAL.
							$Consulta = "select * from sec_web.catodos_desc_normal ";
							$Consulta.= " where fecha_produccion = '".$Fecha[$i]."'";
							$Consulta.= " and grupo = '".str_pad($Grupo[$i],2,0,STR_PAD_LEFT)."'";
							//$Consulta.= " and cuba in ('".$Cubas[$i]."')";
							$Consulta.= " and tipo = '".$TipoProd."'";
							//echo $Consulta."<br>";
							$Respuesta3 = mysqli_query($link, $Consulta);
							if ($Fila3 = mysqli_fetch_array($Respuesta3))
							{
								$PesoAux = $Fila2["peso_produccion"];
							}
							else
							{
								$PesoAux = $Fila2["peso_produccion"];
								$Peso = $Peso - $PesoAux;
							}							
						}
						else
						{
							$Error = true;
							$Mensaje.= $Grupo[$i]."///";
						}
					}
					if ($Error == false)
					{
						//CONSULTO SI TIENE PESADA VIRTUAL
						$Consulta = "select * from sec_web.produccion_desc_normal ";
						$Consulta.= " where fecha_produccion = '".$Fecha[$i]."'";
						$Consulta.= " and cod_grupo = '99'";
						$Consulta.= " and cod_cuba = '".str_pad($Grupo[$i],2,0,STR_PAD_LEFT)."'";
						$Consulta.= " and cod_lado = '".$TipoProd."'";
						//echo $Consulta."<br>";
						$Respuesta2 = mysqli_query($link, $Consulta);
						if ($Fila2 = mysqli_fetch_array($Respuesta2))
						{					
							//CONSULTO SI YA FUE ASIGNADO PESO PARCIAL.
							$Consulta = "select * from sec_web.catodos_desc_normal ";
							$Consulta.= " where fecha_produccion = '".$Fecha[$i]."'";
							$Consulta.= " and grupo = '".str_pad($Grupo[$i],2,0,STR_PAD_LEFT)."'";
							//$Consulta.= " and cuba in (".$Cubas[$i].")";
							$Consulta.= " and tipo = '".$TipoProd."'";
							//echo $Consulta."<br>";
							$Respuesta3 = mysqli_query($link, $Consulta);
							if ($Fila3 = mysqli_fetch_array($Respuesta3))
							{
								$Peso = $Peso - $Fila3["peso_produccion"];								
							}														
						}
						//echo $Peso."<br>";												
						$Consulta = "select * from sec_web.catodos_desc_normal ";
						$Consulta.= " where cod_bulto = '".$CodBulto."'";
						$Consulta.= " and num_bulto = '".$NumBulto."'";
						$Consulta.= " and fecha_creacion_bulto = '".$FechaLote."'";
						$Consulta.= " and grupo = '".str_pad($Grupo[$i],2,0,STR_PAD_LEFT)."'";
						$Consulta.= " and fecha_produccion = '".$Fecha[$i]."'";
						//$Consulta.= " and cuba in (".$Cubas[$i].")";
						$Consulta.= " and tipo = '".$TipoProd."'";
						//echo $Consulta."<br>";
						$Respuesta = mysqli_query($link, $Consulta);
						if ($Fila = mysqli_fetch_array($Respuesta))
						{
							$Actualizar = "UPDATE sec_web.catodos_desc_normal set ";
							$Actualizar.= " participa = '".$Participa[$i]."' ";
							$Actualizar.= " , peso_produccion = '".$Peso."' ";
							$Actualizar.= " where cod_bulto = '".$CodBulto."'";
							$Actualizar.= " and num_bulto = '".$NumBulto."'";
							$Actualizar.= " and fecha_creacion_bulto = '".$FechaLote."'";
							$Actualizar.= " and grupo = '".str_pad($Grupo[$i],2,0,STR_PAD_LEFT)."'";
							$Actualizar.= " and fecha_produccion = '".$Fecha[$i]."'";
							$Actualizar.= " and tipo = '".$TipoProd."'";
							//echo $Actualizar;
							mysql_query ($Actualizar);
						}
						else
						{					
							$Insertar = "INSERT INTO sec_web.catodos_desc_normal ";
							$Insertar.= " (cod_bulto, num_bulto, fecha_creacion_bulto, grupo, ";
							$Insertar.= " fecha_produccion, peso_produccion, participa, tipo) ";
							$Insertar.= " VALUES ('".$CodBulto."', '".$NumBulto."', '".$FechaLote."', ";
							$Insertar.= " '".str_pad($Grupo[$i],2,0,STR_PAD_LEFT)."', '".$Fecha[$i]."', ";
							$Insertar.= " '".$Peso."', '".$Participa[$i]."', '".$TipoProd."')";
							//echo $Insertar;
							mysqli_query($link, $Insertar);
						}
					}
				}
				else
				{
					$Eliminar = "delete from sec_web.catodos_desc_normal";
					$Eliminar.= " where cod_bulto = '".$CodBulto."'";
					$Eliminar.= " and num_bulto = '".$NumBulto."'";
					$Eliminar.= " and fecha_creacion_bulto = '".$FechaLote."'";
					$Eliminar.= " and grupo = '".str_pad($Grupo[$i],2,0,STR_PAD_LEFT)."'";
					$Eliminar.= " and fecha_produccion = '".$Fecha[$i]."'";
					//echo $Eliminar."<br>";				
					mysqli_query($link, $Eliminar);
				}
			}
			header("location:sec_asigna_grupo_cuba01.php?Mensaje=".$Mensaje."&FechaLote=".$FechaLote."&Ano=".$Ano."&CodBulto=".$CodBulto."&NumBulto=".$NumBulto."&ConsProd=S&MesIni=".$MesIni."&AnoIni=".$AnoIni);
			break;
		case "E":
			$ArrAux = explode("/",$Valores);
			$Eliminar = "delete from sec_web.catodos_desc_normal ";
			$Eliminar.= " where cod_bulto = '".$ArrAux[0]."'";
			$Eliminar.= " and num_bulto = '".$ArrAux[1]."'";
			$Eliminar.= " and fecha_creacion_bulto = '".$ArrAux[2]."'";
			$Eliminar.= " and grupo = '".str_pad($ArrAux[3],2,0,STR_PAD_LEFT)."'";
			$Eliminar.= " and fecha_produccion = '".$ArrAux[5]."'";
			mysqli_query($link, $Eliminar);
			header("location:sec_asigna_grupo_cuba.php?Ano=".$Ano."&CodBulto=".$ArrAux[0]."&NumBulto=".$ArrAux[1]);
			break;
	}
?>