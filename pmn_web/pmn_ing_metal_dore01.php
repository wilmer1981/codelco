<?php
	include("../principal/conectar_pmn_web.php");
	$Rut =$CookieRut;
	$Fecha = $Ano."-".$Mes."-".$Dia;
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Encontro=false;
			for ($i=$LimiteInicial;$i<=$LimiteFinal;$i++)
			{
				$Consulta="select * from pmn_web.ingreso_metal_dore ";
				$Consulta.=" where fecha='".$Fecha."' and num_barra='".$i."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					$Encontro=true;
					$Mensaje="S";
				}
			}
			
			if ($Encontro==false)
			{
				for ($i=$LimiteInicial;$i<=$LimiteFinal;$i++)
				{
					//Insertar
					$Insertar = "INSERT INTO pmn_web.ingreso_metal_dore ";
					$Insertar.= "(rut, fecha,num_lote,num_barra,lote_ventana) ";
					$Insertar.= "values('".$Rut."','".$Fecha."','".$NumLote."','".$i."','".$TxtLoteVentana."')";
					//echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
				}
			}		
			header("location:pmn_principal_reportes.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumLote=".$NumLote."&Mensaje=".$Mensaje."&Tab1=true&TabM=true");
			break;
		case "G2": //GRABAR
			if (count($ChkLote)>0)
			{
				while (list($i,$p) = each($ChkLote))
				{
					$Consulta="select peso_barra from pmn_web.ingreso_metal_dore ";
					$Consulta.=" where fecha = '".$Fecha."' ";				
					$Consulta.= " and num_lote = '".$p."'";
					$Consulta.= " and num_barra = '".$ChkBarra[$i]."' ";														 
					//echo $Consulta."<br>";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Menor=$Fila[peso_barra];
					$Mayor=$ChkPeso[$i];
					$Diferencia=$Mayor-$Menor;
					$Actualizar="UPDATE pmn_web.stock set peso=(peso +".$Diferencia.") ";
					$Actualizar.=" where cod_producto='44' and cod_subproducto='2' ";
					//echo $Actualizar."<br>";
					mysqli_query($link, $Actualizar);
					//Actualizar
					$Actualizar = "UPDATE pmn_web.ingreso_metal_dore set ";
					$Actualizar.= " peso_barra = '".$ChkPeso[$i]."', ";
					$Actualizar.= " lote_ventana = '".$TxtLoteVentana."' ";
					$Actualizar.= " where fecha = '".$Fecha."' ";				
					$Actualizar.= " and num_lote = '".$p."'";
					$Actualizar.= " and num_barra = '".$ChkBarra[$i]."' ";		
					//echo $Actualizar."<br>";
					mysqli_query($link, $Actualizar);
					
				}
			}	
			header("location:pmn_principal_reportes.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumLote=".$NumLote."&Tab1=true&TabM=true");
			break;
		case "E":
			$Consulta="select sum(peso_barra) as suma from pmn_web.ingreso_metal_dore  ";
			$Consulta.=" where  fecha = '".$Fecha."' and num_lote = '".$NumLote."' ";
			//echo $Consulta."<br>";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Actualizar="UPDATE pmn_web.stock set peso=(peso +".$Fila[suma].") ";
			$Actualizar.=" where cod_producto='44' and cod_subproducto='2' ";
			echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			$Eliminar="delete from pmn_web.ingreso_metal_dore where  fecha = '".$Fecha."' and num_lote = '".$NumLote."'";
			mysqli_query($link, $Eliminar);		
			//header("location:pmn_ing_metal_dore.php");*/
			break;
		case "E2":
			if (count($ChkLote)>0)
			{
				while (list($i,$p) = each($ChkLote))
				{
					$Consulta="select peso from pmn_web.stock ";
					$Consulta.=" where cod_producto='44' and cod_subproducto='2' ";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					if ($ChkPeso[$i] > $Fila["peso"])
					{
						$Mensaje2="S";
					}
					else
					{
						// ELIMINA DETALLE
						$Eliminar = "delete from pmn_web.ingreso_metal_dore ";
						$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
						$Eliminar.= " and num_lote = '".$p."'";					
						$Eliminar.= " and num_barra = '".$ChkBarra[$i]."'";
						//echo $Eliminar."<br>";
						mysqli_query($link, $Eliminar);
						$Actualizar="UPDATE pmn_web.stock set peso=(peso -".$ChkPeso[$i].") ";
						$Actualizar.=" where cod_producto='44' and cod_subproducto='2' ";
						//echo $Actualizar."<br>";
						mysqli_query($link, $Actualizar);
					}
				}
			}
			header("location:pmn_principal_reportes.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumLote=".$NumLote."&Mensaje2=".$Mensaje2."&Tab1=true&TabM=true");
			break;
		case "C": //CANCELAR
			header("location:pmn_principal_reportes.php?&Tab1=true&TabM=true");
			break;
	}
?>