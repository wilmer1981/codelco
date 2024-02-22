<?php
include("../principal/conectar_sea_web.php");
$Hora=date("Y-m-d H:i:s");
//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	$valida_fecha_movimiento = $ano_r.'-'.$mes_r.'-'.$dia_r;
	include("sea_valida_mes.php");
//*******************************************************************************//
	
if($Proceso == "G")
{
	$Fecha_mov = $ano_r."-".$mes_r."-".$dia_r;
	$Datos = explode('//',$Valores);
	$Hornada = $Datos[0];
	$Grupo =   $Datos[1];
	$Fecha =   $Datos[2];
	$Unidades = $Datos[3];
	$Peso =    $Datos[4];
	if (substr($Hornada,6,2)=="96")
		$ProdSubProd = 2;
	if (substr($Hornada,6,2)=="95")
		$ProdSubProd = 1;
	if (substr($Hornada,6,2)=="97")
		$ProdSubProd = 3;
	if (substr($Hornada,6,2)=="93")
		$ProdSubProd = 8;

	if ((substr($Hornada,6,2)!="97") && (substr($Hornada,6,2)!="95") && (substr($Hornada,6,2)!="96") && (substr($Hornada,6,2)!="93"))
		$ProdSubProd = 4;
	$Subpr = $ProdSubProd;
	$Hora = $Fecha." ".date("H:i:s");
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
	$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 10 AND cod_producto = 19";
	$consulta = $consulta." AND cod_subproducto = '".$SubProd."'";
	//echo $consulta."<br>";
	$rs1 = mysqli_query($link, $consulta);
	if ($row1 = mysqli_fetch_array($rs1))
		$flujo = $row1["flujo"];
	else 
		$flujo = 0;
	$PesoUnid=round($Peso/$Unidades);
	$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,";
	$insertar = $insertar." campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
	$insertar = $insertar." VALUES(10,19,".$ProdSubProd.",'".$Hornada."',0,'".$Fecha_mov."','','".$Grupo."',";
	$insertar = $insertar.$Unidades.",".$flujo.",'".$Fecha."','".$Peso."','".$Hora."')";
	mysqli_query($link, $insertar);
	//echo $insertar;
	$inserta = "INSERT INTO sea_web.restos_a_sec (hornada, grupo,tipo_movimiento,cod_producto,cod_subproducto,fecha_movimiento, unidades,peso)";
	$inserta.=" VALUES('".$Hornada."','".$Grupo."',1,19,'".$ProdSubProd."','".$Fecha_mov."','".$Unidades."','".$Peso."')";
	mysqli_query($link, $inserta);
	//echo $inserta;

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
		$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 10 AND cod_producto = 19";
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
				//echo $actualiza1."</br>";
				mysqli_query($link, $actualiza1);
				$elimina ="delete from sea_web.restos_a_sec where hornada = '".$Hornada."' and grupo = '".$Grupo."'";
				$elimina.=" and tipo_movimiento = '1' and year(fecha_movimiento) = '".substr($FechaMov,0,4)."'";
				//echo $elimina."</br>";
				mysqli_query($link, $elimina);
			}
			else
			{
				$actualizar="UPDATE sea_web.restos_a_sec set tipo_movimiento = '4', fecha_movimiento = '".$TxtFechaFin."' where hornada = '".$Hornada."' and grupo = '".$Grupo."' and tipo_movimiento = '1'";
				$actualizar.=" and cod_producto = '19' and cod_subproducto = '".$ProdSubProd[1]."'";
				//echo $actualizar."</br>";
				mysqli_query($link, $actualizar);
			}
			$PesoTraspaso = $PesoTraspaso - $Peso;
			if ($PesoTraspaso < $PesoUnid)
				$PesoTrapaso = 0;
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
				$consulta2="Select * from sea_web.restos_a_sec where hornada = '".$Hornada."' and grupo = '".$Grupo."' and cod_producto = '19' and cod_subproducto = '".$ProdSubProd[1]."'";
				$consulta2.=" and tipo_movimiento = '1'";
				$resp2 = mysqli_query($link, $consulta2);
				if ($Fila = mysqli_fetch_array($resp2))
				{
					$actualizar="UPDATE sea_web.restos_a_sec set tipo_movimiento = '4', peso = '".$PesoUno."',unidades='".$UnidadUno."', fecha_movimiento = '".$TxtFechaFin."' where hornada = '".$Hornada."' and grupo = '".$Grupo."' and tipo_movimiento = '1'";
					$actualizar.=" and cod_producto = '19' and cod_subproducto = '".$ProdSubProd[1]."'";
					//echo $actualizar."</br>";
					mysqli_query($link, $actualizar);
					$Fecha_mov = $Fila[fecha_movimiento];
				}
				if ($PesoDos > 0)
				{
						$insertar = "Insert into sea_web.restos_a_sec (hornada, grupo, tipo_movimiento, fecha_movimiento, cod_producto, cod_subproducto, unidades, peso)";
						$insertar.=" values('".$Fila[hornada]."','".$Fila["grupo"]."','1','".$Fila[fecha_movimiento]."','19','".$Fila["cod_subproducto"]."','".$UnidadDos."','".$PesoDos."')";
						//echo $insertar."</br>";
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
			//echo $consultar."</br>";
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
	$Datos=explode('~',$Valores);
	$FechaMov=$Datos[0];
	$ProdSubProd=$Datos[1];
	$Subpr=$ProdSubProd;
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
	
	$Eliminar="delete from sea_web.traspasos_sec where fecha='$FechaMov' and cod_producto='19' and cod_subproducto='$SubProd'";
	mysqli_query($link, $Eliminar);
	$Eliminar="delete from sea_web.movimientos where tipo_movimiento='10' and fecha_movimiento='$FechaMov' and cod_producto='19' and cod_subproducto='$ProdSubProd'";
	mysqli_query($link, $Eliminar);
	$eliminar = "delete from sea_web.restos_a_sec where fecha_movimiento = '".$FechaMov."' and cod_producto = '19' and";
	$eliminar.=" cod_subproducto = '".$ProdSubProd."' and grupo = '".$Grupo."' and tipo_movimiento = '1'";
	mysqli_query($link, $eliminar);

}
if ($Proceso == "G")
{
	header("Location:sea_ing_restos_trasp_raf.php"); 
	include("../principal/cerrar_sea_web.php");
}
else
{
		header("Location:sea_ing_restos_trasp_sec.php?recargapag=S"); 
		include("../principal/cerrar_sea_web.php");
}
?>
