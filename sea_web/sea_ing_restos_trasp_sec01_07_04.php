<?php
include("../principal/conectar_sea_web.php");
$Hora=date("Y-m-d H:i:s");
//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	$valida_fecha_movimiento = $ano_r.'-'.$mes_r.'-'.$dia_r;
	include("sea_valida_mes.php");
//*******************************************************************************//
	
if($Proceso == "GE")
{
	$Fecha_mov = $ano_r."-".$mes_r."-".$dia_r;
	$vector = explode('//',$Valores);
	while (list($c,$v) = each($vector))
	{
		$Datos = explode(',',$v);
		$hornada =   $Datos[0];
		$ProdSubProd  =   $Datos[1];
		$lado    =   $Datos[2];
		$TrasUnidades = $Datos[3];
		$TrasPeso =    $Datos[4];
        $fechaB   =    $Datos[5];
	
		$Subpr = $ProdSubProd;
		$Hora = $Fecha_mov." ".date("H:i:s");
		switch($ProdSubProd)
		{
			case "1":
				$SubProd=21;//PRODUCTO EMBARQUE HVL
				break;
			case "2":
				$SubProd=22;//PRODUCTO EMBARQUE TTE
				break;
			case "3":
				$SubProd=23;//PRODUCTO EMBARQUE SUR ANDES
				break;
			case "4":
				$SubProd=25;//PRODUCTO EMBARQUE VENTANAS
				break;
			case "8":
				$SubProd=26;//PRODUCTO EMBARQUE HM VENTANAS
				break;
		}
		//Busca el flujo Asociado al producto y proceso.		
		$consulta = "SELECT flujo as flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 10 AND cod_producto = 19";
		$consulta = $consulta." AND cod_subproducto = '".$SubProd."'";
		//echo $consulta."<br>";
		$rs1 = mysqli_query($link, $consulta);
		if ($row1 = mysqli_fetch_array($rs1))
			$flujo = $row1["flujo"];
		else 
			$flujo = 0;
		$Unidad1 = 0;
		$Unidad2 = 0;
		$Unidad3 = 0;
		$Peso1 = 0;
		$Peso2 = 0;
		$Peso3 = 0;
		$consulta = "Select hornada,sum(unidades) as unidades, sum(peso) as peso from sea_web.movimientos where cod_producto = '19' and ";
		$consulta.=" cod_subproducto = '".$ProdSubProd."' and hornada = '".$hornada."' and tipo_movimiento = '3' group by hornada ";
		$resp = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($resp))
		{
			$Unidad1 = $row["unidades"];
			$Peso1 = $row["peso"];
		}
		
		$consulta1 = "Select hornada,sum(unidades) as unidades, sum(peso) as peso from sea_web.movimientos where cod_producto = '19' and ";
		$consulta1.=" cod_subproducto = '".$ProdSubProd."' and hornada = '".$hornada."' and tipo_movimiento IN ('4','10')  group by hornada ";
		$resp1 = mysqli_query($link, $consulta1);
		if ($row1 = mysqli_fetch_array($resp1))
		{
			$Unidad2 = $row1[unidades_resta];
			$Peso2 = $row1[peso_resta];
		}
		
		$consulta2 = "Select hornada,sum(unidades) as unidades, sum(peso) as peso from sea_web.restos_a_sec where cod_producto = '19' and ";
		$consulta2.=" cod_subproducto = '".$ProdSubProd."' and hornada = '".$hornada."' and tipo_movimiento = '1' group by hornada ";
		$resp2 = mysqli_query($link, $consulta2);
		if ($row2 = mysqli_fetch_array($resp2))
		{
			$Unidad3 = $row2["unidades"];
			$Peso3 = $row2["peso"];
		}
		
		$Unidades_tot = $Unidad1 - ($Unidad2 + $Unidad3);
		$Peso_tot = $Peso1 - ($Peso2 + $Peso3);
		if ($Peso_tot > 0 || $Unidades_tot > 0)
		{
			if ($TrasPeso > $Peso_tot)
			{
				$Peso = $Peso_tot;
				$Unidades = $Unidades_tot;
				$TrasPeso = $TrasPeso - $Peso_tot;
				$TrasUnidades = $TrasUnidades - $unidades_tot;
			}
			else
			{
				if ($TrasPeso <= $Peso_tot)
				{
					$Peso = $TrasPeso;
					$Unidades = $TrasUnidades;
					$TrasPeso = 0;$
					$TrasUnidades = 0;
				}
			}
			$inserta = "INSERT INTO sea_web.restos_a_sec (hornada, grupo,tipo_movimiento,cod_producto,cod_subproducto,fecha_movimiento, unidades,peso,fecha_beneficio)";
			$inserta.=" VALUES('".$hornada."','".$cmbgrupo."',1,19,'".$ProdSubProd."','".$Fecha_mov."','".$Unidades."','".$Peso."','".$fechaB."')";
			//echo $inserta."</br>";
			mysqli_query($link, $inserta);
		}
	}

}
//*************************
if($Proceso == "GT")
{
	$valida_fecha_movimiento = $TxtFechaFin;
	include("sea_valida_mes.php");
	$DatosL = explode('-',$Lotes);
	$Parametros = explode('//',$Valores);
	$ProdSubProd = explode('-',$producto);
	$CodLote = $DatosL[0];
	$NumLote = $DatosL[1];
	$PesoTot=0;
	$Subpr = $ProdSubProd[1];
	$PesoParcial = $PParcial;
	$PSeleccion = $PSelec;
	$PesoTraspaso = $PParcial;
	$UnidLote = 0;
	$PesoLote = 0;
	$Hora = $TxtFechaFin." ".date("H:i:s");

	switch($ProdSubProd[1])
	{
			case "1":
				$SubProd=21;//PRODUCTO EMBARQUE HVL
				break;
			case "2":
				$SubProd=22;//PRODUCTO EMBARQUE TTE
				break;
			case "3":
				$SubProd=23;//PRODUCTO EMBARQUE SUR ANDES
				break;
			case "4":
				$SubProd=25;//PRODUCTO EMBARQUE VENTANAS
				break;
			case "8":
				$SubProd=26;//PRODUCTO EMBARQUE HM VENTANAS
				break;
	}
	$PesoUno = 0;
	$PesoDos = 0;
	$UnidadUno = 0;
	$UnidadDos = 0;

	while (list($c,$v) = each($Parametros))
	{
		$Campos=explode('~',$v);
		$Grupo=$Campos[0];
		$FechaMov=$Campos[1];
		$Unidades=$Campos[2];
		$Peso=$Campos[3];
		$Hornada=$Campos[4];
		
		//Busca el flujo Asociado al producto y proceso.		
		
		$consulta = "SELECT flujo as flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 10 AND cod_producto = 19";
		$consulta = $consulta." AND cod_subproducto = '".$SubProd."'";
		$rs1 = mysqli_query($link, $consulta);
		
		if ($row1 = mysqli_fetch_array($rs1))
				$flujo = $row1["flujo"];
		else 
				$flujo = 0;
				
		$PesoUnid=round($Peso/$Unidades);
		$PesoUnid = number_format($PesoUnid,0);
		
		if (($Peso <= $PesoTraspaso) && $PesoTraspaso > 0)
		{
			$PesoLote = $PesoLote + $Peso;
			$seleccion="SELECT * from sea_web.restos_a_sec  where hornada = '".$Hornada."' and grupo = '".$Grupo."' and tipo_movimiento = '4'";
			$seleccion.=" and cod_producto = '19' and cod_subproducto = '".$ProdSubProd[1]."' and fecha_movimiento = '".$TxtFechaFin."'";
			$respuesta = mysqli_query($link, $seleccion);
			if ($Linea = mysqli_fetch_array($respuesta))
			{
				$sumapeso = $Peso + $Linea["peso"];
				$sumaunidad = $Unidades + $Linea["unidades"];
				$actualiza1="UPDATE sea_web.restos_a_sec set unidades = '".$sumaunidad."', peso = '".$sumapeso."' where hornada = '".$Hornada."' ";
				$actualiza1.=" and grupo = '".$Grupo."' and tipo_movimiento = '4' and fecha_movimiento = '".$TxtFechaFin."'";
				mysqli_query($link, $actualiza1);
				
				$elimina ="delete from sea_web.restos_a_sec where hornada = '".$Hornada."' and grupo = '".$Grupo."'";
				$elimina.=" and tipo_movimiento = '1' and year(fecha_movimiento) = '".substr($FechaMov,0,4)."'";
				mysqli_query($link, $elimina);

				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,";
				$insertar.=" campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
				$insertar.=" VALUES(10,19,'".$ProdSubProd[1]."','".$Hornada."',0,'".$TxtFechaFin."','','".$Grupo."',";
				$insertar.=" '".$Unidades."','".$flujo."','".$FechaMov."','".$Peso."','".$Hora."')";
				mysqli_query($link, $insertar);
				
			}
			else
			{
				$actualizar="UPDATE sea_web.restos_a_sec set tipo_movimiento = '4', fecha_movimiento = '".$TxtFechaFin."' where hornada = '".$Hornada."' and grupo = '".$Grupo."' and tipo_movimiento = '1'";
				$actualizar.=" and cod_producto = '19' and cod_subproducto = '".$ProdSubProd[1]."'";
				mysqli_query($link, $actualizar);
				
				$inserta2 = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,";
				$inserta2.=" campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
				$inserta2.=" VALUES(10,19,'".$ProdSubProd[1]."','".$Hornada."',0,'".$TxtFechaFin."','','".$Grupo."',";
				$inserta2.=" '".$Unidades."','".$flujo."','".$FechaMov."','".$Peso."','".$Hora."')";
				mysqli_query($link, $inserta2);

			}
			$PesoTraspaso = $PesoTraspaso - $Peso;
		}
		else
		{
			if ($Peso > $PesoTraspaso && $PesoTraspaso > 0)
			{
				$UnidadUno =  $PesoTraspaso / $PesoUnid;
				$UnidadUno = number_format($UnidadUno,0);
				$PesoUno   = $PesoTraspaso;
				$PesoDos   = $Peso - $PesoUno;
				$UnidadDos = $Unidades - $UnidadUno;
				$PesoLote = $PesoLote + $PesoUno;
				
				$consulta2="Select *  from sea_web.restos_a_sec where hornada = '".$Hornada."' and grupo = '".$Grupo."' and cod_producto = '19' and cod_subproducto = '".$ProdSubProd[1]."'";
				$consulta2.=" and tipo_movimiento = '1'";
				$resp2 = mysqli_query($link, $consulta2);
				if ($Fila = mysqli_fetch_array($resp2))
				{
					$Peso_parcial = $Fila["peso"] - $PesoTraspaso;
					$Unidad_parcial = $Fila[Unidades] - $UnidadUno;
					$actualizar="UPDATE sea_web.restos_a_sec set  peso = '".$Peso_parcial."',unidades='".$Unidad_parcial."', fecha_movimiento = '".$TxtFechaFin."' where hornada = '".$Hornada."' and grupo = '".$Grupo."' and tipo_movimiento = '1'";
					$actualizar.=" and cod_producto = '19' and cod_subproducto = '".$ProdSubProd[1]."'";
					mysqli_query($link, $actualizar);
					$Fecha_mov = $Fila[fecha_movimiento];
					$inserta1 = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
					$inserta1.=" VALUES(10,19,'".$ProdSubProd[1]."','".$Hornada."',0,'".$TxtFechaFin."','','".$Grupo."',";
					$inserta1.=" '".$UnidadUno."','".$flujo."','".$FechaMov."','".$PesoTraspaso."','".$Hora."')";
					mysqli_query($link, $inserta1);

					$insertar = "Insert into sea_web.restos_a_sec (hornada, grupo, tipo_movimiento, fecha_movimiento, cod_producto, cod_subproducto, unidades, peso,fecha_beneficio)";
					$insertar.=" values('".$Hornada."','".$Grupo."','4','".$TxtFechaFin."','19','".$ProdSubProd[1]."','".$UnidadUno."','".$PesoTraspaso."'";
					$insertar.=" '".$FechaMov."')";
						mysqli_query($link, $insertar);
				}
				$PesoTraspaso = 0;
			}
		}
	}	
	if ($PesoLote > 0)
	{
			$consultar="Select cod_bulto, num_bulto, fecha from sea_web.traspasos_sec where cod_bulto = '".$CodLote."' and num_bulto = '".$NumLote."' and year(fecha) = '".substr($TxtFechaFin,0,4)."'";
			$consultar.=" and cod_producto = '19' and cod_subproducto = '".$SubProd."'";
			$respuesta = mysqli_query($link, $consultar);
			if ($fila = mysqli_fetch_array($respuesta))
			{
				$actualiza ="UPDATE sea_web.traspasos_sec set peso = (peso + '".$PesoLote."') where cod_bulto = '".$CodLote."' and num_bulto = '".$NumLote."' and year(fecha) = '".substr($TxtFechaFin,0,4)."'";
				$actualiza.=" and cod_producto = '19' and cod_subproducto = '".$SubProd."'";
				mysqli_query($link, $actualiza);
			}
			else
			{
				$insertar= "Insert into sea_web.traspasos_sec (cod_bulto,num_bulto,fecha, cod_producto,cod_subproducto,peso)";
				$insertar.=" values('".$CodLote."','".$NumLote."','".$TxtFechaFin."','19','".$SubProd."','".$PesoLote."')";
				//echo $insertar."</br>";
				mysqli_query($link, $insertar);
		    }
	}

}

//************************
if($Proceso == "EM")
{
	$Datos=explode('//',$Valores);
	while (list($c,$v) = each($Datos))
	{
		$Campos=explode('~',$v);
		$Hornada = $Campos[0];
		$Grupo = $Campos[1];
		$Fecha = $Campos[2];
		$Unidades = $Campos[3];
		$Peso = $Campos[4];
		$eliminar = "delete from sea_web.restos_a_sec where  hornada = '".$Hornada."' and fecha_movimiento = '".$Fecha."' and cod_producto = '19' and";
		$eliminar.=" grupo = '".$Grupo."' and tipo_movimiento = '1'";
		mysqli_query($link, $eliminar);
	}
}

if ($proceso=="EM")
{
	header("Location:sea_eli_restos_trasp_sec_e01.php"); 
	include("../principal/cerrar_sea_web.php");
}
if ($Proceso=="GE")
{
	header("Location:sea_ing_restos_trasp_raf.php"); 
	include("../principal/cerrar_sea_web.php");
}
if ($Proceso=="GT")
{
	header("Location:sea_ing_restos_trasp_sec.php?recargapag=S"); 
	include("../principal/cerrar_sea_web.php");
}
?>
