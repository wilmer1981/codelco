<?php
include("../principal/conectar_sea_web.php");

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso =  "";
}
if(isset($_REQUEST["Valores"])) {
	$Valores = $_REQUEST["Valores"];
}else{
	$Valores =  "";
}
if(isset($_REQUEST["PParcial"])) {
	$PParcial = $_REQUEST["PParcial"];
}else{
	$PParcial =  "";
}
if(isset($_REQUEST["PSelec"])) {
	$PSelec = $_REQUEST["PSelec"];
}else{
	$PSelec =  "";
}
if(isset($_REQUEST["Lotes"])) {
	$Lotes = $_REQUEST["Lotes"];
}else{
	$Lotes =  "";
}
if(isset($_REQUEST["producto"])) {
	$producto = $_REQUEST["producto"];
}else{
	$producto =  "";
}

$Hora=date("Y-m-d H:i:s");
//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	$valida_fecha_movimiento = $ano_r.'-'.$mes_r.'-'.$dia_r;
	include("sea_valida_mes.php");
//*******************************************************************************//
//    verificacion de datos 07-06-2010
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
			$Unidad2 = $row1["unidades_resta"];
			$Peso2 = $row1["peso_resta"];
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
	$Hora = $TxtFechaFin." ".date("H:i:s");
	$PesoUno = 0;$PesoDos = 0;$UnidadUno = 0;$UnidadDos = 0;
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
		$PesoUnid= $Peso/$Unidades;
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
			}
			else
			{
				$actualizar="UPDATE sea_web.restos_a_sec set tipo_movimiento = '4', fecha_movimiento = '".$TxtFechaFin."' where hornada = '".$Hornada."' and grupo = '".$Grupo."' and tipo_movimiento = '1'";
				$actualizar.=" and cod_producto = '19' and cod_subproducto = '".$ProdSubProd[1]."'";
				mysqli_query($link, $actualizar);
			}
			$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,";
			$insertar.=" fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
			$insertar.=" VALUES(10,19,'".$ProdSubProd[1]."','".$Hornada."',0,'".$TxtFechaFin."','','".$Grupo."',";
			$insertar.=" '".$Unidades."','".$flujo."','".$FechaMov."','".$Peso."','".$Hora."')";
			 mysqli_query($link, $insertar);				
			$PesoTraspaso = $PesoTraspaso - $Peso;
			if ($PesoTraspaso < $PesoUnid)
				$PesoTrapaso = 0;
		}
		else
		{
			if ($Peso > $PesoTraspaso && $PesoTraspaso > 0)
			{
				$UnidadUno =  round($PesoTraspaso / $PesoUnid);
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
					 mysqli_query($link, $actualizar);
					$Fecha_mov = $Fila["fecha_movimiento"];
				}
				if($PesoDos > 0)
				{
						$insertar = "Insert into sea_web.restos_a_sec (hornada, grupo, tipo_movimiento, fecha_movimiento, cod_producto, cod_subproducto, unidades, peso)";
						$insertar.=" values('".$Fila["hornada"]."','".$Fila["grupo"]."','1','".$Fila["fecha_movimiento"]."','19','".$Fila["cod_subproducto"]."','".$UnidadDos."','".$PesoDos."')";
						mysqli_query($link, $insertar);
				}
				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,";
				$insertar.=" fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
				$insertar.=" VALUES(10,19,'".$ProdSubProd[1]."','".$Hornada."',0,'".$TxtFechaFin."','','".$Grupo."',";
				$insertar.=" '".$UnidadUno."','".$flujo."','".$FechaMov."','".$PesoUno."','".$Hora."')";
				mysqli_query($link, $insertar);				

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
				mysqli_query($link, $insertar);
		    }
	}

}

//************************
if($Proceso == "EM")
{
	$Datos=explode('~',$Valores);
	$FechaMov=$Datos[3];
	$ProdSubProd=$Datos[1];
	$Grupo = $Datos[2];
	$Hornada = $Datos[0];
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
	
	$Encuentro = 0;
	$Consulta0 = "Select *  from sea_web.restos_a_sec where hornada = '".$Hornada."' and fecha_movimiento = '".$FechaMov."' and ";
	$Consulta0.=" cod_producto = '19' and cod_subproducto = '".$ProdSubProd."' and grupo = '".$Grupo."' and tipo_movimiento = '1'";
	$Resp0=mysqli_query($link, $Consulta0);
	if($Fil0=mysqli_fetch_array($Resp0))
	{
		$Encuentro=1;
		$Eliminar = "delete from sea_web.restos_a_sec where hornada = '".$Hornada."' and fecha_movimiento = '".$FechaMov."' and ";
		$Eliminar.=" cod_producto = '19' and cod_subproducto = '".$ProdSubProd."' and grupo = '".$Grupo."' and tipo_movimiento = '1'";
		mysqli_query($link, $Eliminar);
	}
	if($Encuentro==1)
	{
		$Consulta="SELECT * from sea_web.movimientos where tipo_movimiento='10' and cod_producto='19' and cod_subproducto='".$ProdSubProd."'";
		$Consulta.=" and hornada = '".$Hornada."' and fecha_movimiento = '".$FechaMov."' and campo2 = '".$Grupo."'";
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Resp))
		{
			$Eliminar1="delete from sea_web.movimientos where tipo_movimiento='10' and cod_producto='19' and cod_subproducto='".$ProdSubProd."'";
			$Eliminar1.=" and hornada = '".$Hornada."' and fecha_movimiento = '".$FechaMov."' and campo2 = '".$Grupo."'";
			mysqli_query($link, $Eliminar1);
		}
	}

}
//**************** Elimina traspasos de restos a Embarque ******************
if($Proceso == "ET")
{
	$Datos=explode("~~",$Valores);
	while(list($k,$v)=each($Datos))
	{
		$Datos2=explode("//",$v);
		$FechaMov=$Datos2[0];
		$Subprod=$Datos2[1];
		$Hornada=$Datos2[2];
		$Grupo=$Datos2[3];
		$Peso=$Datos2[4];
		$SubPr=0;
		switch($Subprod)
		{
			case "1":
				$SubPr=21;//PRODUCTO EMBARQUE HVL
				break;
			case "2":
				$SubPr=22;//PRODUCTO EMBARQUE TTE
				break;
			case "3":
				$SubPr=23;//PRODUCTO EMBARQUE SUR ANDES
				break;
			case "4":
				$SubPr=25;//PRODUCTO EMBARQUE VENTANAS
				break;
			case "8":
				$SubPr=26;//PRODUCTO EMBARQUE HM VENTANAS
				break;
		}
	    $PesoTras = 0;$UnidTras = 0;$SiElim=0;$PTraspaso=0;
		if($SubPr <> 0)
		{
			$BuscaFecha="SELECT max(fecha) as fechita from sea_web.traspasos_sec where cod_producto = '19' and ";
			$BuscaFecha.=" cod_subproducto = '".$SubPr."' ";
			$Respu=mysqli_query($link, $BuscaFecha);
			if($Fil=mysqli_fetch_array($Respu))
			{
				$RevisaT="SELECT * from sea_web.traspasos_sec where cod_producto = '19' and cod_subproducto = '".$SubPr."' and ";
				$RevisaT.=" fecha = '".$Fil["fechita"]."' ";
				$Resp=mysqli_query($link, $RevisaT);
				if($Row=mysqli_fetch_array($Resp))
				{
					if($Row["peso"] > $Peso)
					{
						$Actualiza="UPDATE sea_web.traspasos_sec set peso = (peso - '".$Peso."') where cod_producto = '19' and ";
						$Actualiza.=" cod_subproducto = '".$SubPr."' and fecha = '".$Fil["fechita"]."' and cod_bulto = '".$Row["cod_bulto"]."' ";
						$Actualiza.=" and num_bulto = '".$Row["num_bulto"]."' ";
						mysqli_query($link, $Actualiza);
						$SiElim = 1;
					}
					else
					{
						$BorraReg="delete from sea_web.traspasos_sec where cod_producto = '19' and  cod_subproducto = '".$SubPr."' and ";
						$BorraReg.=" fecha = '".$Fil["fechita"]."' and cod_bulto = '".$Row["cod_bulto"]."' and num_bulto = '".$Row["num_bulto"]."'";
						mysqli_query($link, $BorraReg);
						$SiElim = 1;
					}
				}
			}
			if($SiElim==1)
			{
				$Elimina="delete from sea_web.restos_a_sec where hornada = '".$Hornada."' and grupo = '".$Grupo."' and cod_producto = '19' and ";
				$Elimina.=" cod_subproducto = '".$Subprod."' and tipo_movimiento = '4'";
				mysqli_query($link, $Elimina);

				$EliminaMov="delete from sea_web.movimientos where tipo_movimiento ='10' and cod_producto = '19' and ";
				$EliminaMov.=" cod_subproducto = '".$Subprod."' and hornada = '".$Hornada."' and campo2 = '".$Grupo."'";
				mysqli_query($link, $EliminaMov);
			}
		}
	}
}
if($Proceso == "EP")
{
	$Datos=explode("~",$Valores);
	$SubPr   = $Datos[0];
	$Grupo   = $Datos[1];
	$Hornada = $Datos[2];
	$Fecha   = $Datos[3];
 	switch ($SubPr)
	{
		case "21":
			$SubProd = 1;
			break;
		case "22":
			$SubProd = 2;
			break;
		case "23":
			$SubProd = 3;
			break;
		case "25":
			$SubProd = 4;
			break;
		case "26":
			$SubProd = 8;
			break;
	}
	$BorraTrasp="delete from sea_web.restos_a_sec where hornada = '".$Hornada."' and grupo = '".$Grupo."' and tipo_movimiento = '1' and ";
	$BorraTrasp.=" fecha_movimiento = '".$Fecha."' and cod_producto = '19' and cod_subproducto = '".$SubProd."'";
	mysqli_query($link, $BorraTrasp);
	//echo $BorraTrasp;
}

//**************+**********  Fin *******************************************

if($Proceso=="GE")
{
	header("Location:sea_ing_restos_trasp_raf.php"); 
	include("../principal/cerrar_sea_web.php");
}
if($Proceso=="ET")
{
	header("Location:sea_ing_restos_trasp_sec02.php"); 
	include("../principal/cerrar_sea_web.php");
}
if($Proceso=="EM")
{
					
	header("Location:sea_eli_restos_trasp_sec_e01.php"); 
	include("../principal/cerrar_sea_web.php");
}

if($Proceso!="GE" && $Proceso!="ET" && $Proceso !="EM")
{
	header("Location:sea_ing_restos_trasp_sec.php"); 
	include("../principal/cerrar_sea_web.php");
}
?>
