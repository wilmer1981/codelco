<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = date("Y-m-d");
	$TxtLoteVentana=$IdProducto;
	if ($Proceso=="AC")//ACTUALIZA CABECERA
	{		
		$Actualizar = "UPDATE pmn_web.productos_externos set ";
		$Actualizar.= " referencia = '".$Referencia."', ";
		$Actualizar.= " observacion = '".$Observacion."', ";
		$Actualizar.= " lote_ventana = '".$TxtLoteVentana."' ";
		$Actualizar.= " where cod_producto = '".$ProductoExt."'";
		$Actualizar.= " and cod_subproducto = '".$SubproductoExt."'";
		$Actualizar.= " and id_producto = '".$Identificacion."'";
		mysqli_query($link, $Actualizar);
		header("location:pmn_principal_reportes.php?TxtLoteVentana=".$TxtLoteVentana."&ProductoExt=".$ProductoExt."&SubproductoExt=".$SubproductoExt."&Tipo=".$Tipo."&Identificacion=".$Identificacion."&Existe=NO&PesoResta=".$PesoResta."&Tab1=true&TabE=true&CmbMes=".$CmbMes);
	}
	if ($Tipo=="H")
	{		
		$Consulta ="select * from pmn_web.stock ";
		$Consulta.=" where cod_producto='".$ProductoExt."' and cod_subproducto='".$SubproductoExt."' ";
		//echo $Consulta."<br>";
		$Respuesta0=mysqli_query($link, $Consulta);
		if ($Fila0=mysqli_fetch_array($Respuesta0))
		{
			//Nada
		}
		else
		{
			if ($Producto!="25")
			{
				$insertar=" INSERT INTO pmn_web.stock (cod_producto,cod_subproducto,peso) values";
				$insertar.="('".$ProductoExt."','".$SubproductoExt."',0 )	";
				mysqli_query($link, $insertar);
				$Actualizar=" UPDATE proyecto_modernizacion.subproducto set mostrar_pmn='S' ";
				$Actualizar.=" where cod_producto='".$ProductoExt."' and cod_subproducto='".$SubproductoExt."' ";
				mysqli_query($link, $Actualizar);
			}
		}
		$Consulta="select * from proyecto_modernizacion.subproducto ";
		$Consulta.=" where cod_producto='".$ProductoExt."' and cod_subproducto='".$SubproductoExt."' ";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		if ($Fila[mostrar_pmn]=="S")
		{
			$Mostrar="S";
		}
	}
	
	if ($Proceso == "G1")
	{
	
		$Consulta = "select count(*) as Existe from pmn_web.productos_externos ";
		$Consulta.= " where cod_producto = '".$ProductoExt."'";
		$Consulta.= " and cod_subproducto = '".$SubproductoExt."'";
		$Consulta.= " and id_producto = '".$IdProducto."'";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		$Row = mysqli_fetch_array($Respuesta);
		
		
		if ($Row[Existe] > 0)
		{
			
			header("location:pmn_principal_reportes.php?TxtLoteVentana=".$TxtLoteVentana."&ProductoExt=".$ProductoExt."&Tipo=".$Tipo."&SubproductoExt=".$SubproductoExt."&Identificacion=".$IdProducto."&Existe=SI&Mensaje=Identificacion ya existe.&Tab1=true&TabE=true&CmbMes=".$CmbMes);
		}
		else
		{
			$Insertar = "INSERT INTO pmn_web.productos_externos (cod_producto,cod_subproducto,";
			$Insertar.= "id_producto, referencia, observacion,tipo,lote_ventana) ";
			$Insertar.= "values('".$ProductoExt."','".$SubproductoExt."','".$IdProducto."','".$Referencia."','".$Observacion."','".$Tipo."','".$TxtLoteVentana."')";
			//echo $Insertar."<br>";
			mysqli_query($link, $Insertar);
						
			header("location:pmn_principal_reportes.php?TxtLoteVentana=".$TxtLoteVentana."&ProductoExt=".$ProductoExt."&SubproductoExt=".$SubproductoExt."&Identificacion=".$IdProducto."&Tipo=".$Tipo."&Existe=NO&Tab1=true&TabE=true&CmbMes=".$CmbMes);
		}
	}
	if ($Proceso == "G2") //GRABA LOS NUEVOS DETALLES Y ACTUALIZA CABECERA
	{
		if ($DetModificado == "")
		{
			$Consulta = "select ifnull(max(referencia),0) as correlativo from pmn_web.detalle_productos_externos where ";
			$Consulta.= " cod_producto = '".$ProductoExt."'";
			$Consulta.= " and cod_subproducto = '".$SubproductoExt."'";
			$Consulta.= " and id_producto = '".$Identificacion."'";
			$Respuesta = mysqli_query($link, $Consulta);
			$Row = mysqli_fetch_array($Respuesta);
			$Correlativo = $Row[correlativo] + 1;
			$PesoBruto = str_replace(",",".",$PesoBruto);
			$PesoResta = str_replace(",",".",$PesoResta);
			$PesoFinal = $PesoBruto - $PesoResta;
			if ($Mostrar=="S")
			{
				$Actualizar=" UPDATE pmn_web.stock set peso=(peso +".$PesoFinal.") ";
				$Actualizar.=" where cod_producto='".$ProductoExt."' and cod_subproducto='".$SubproductoExt."' ";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}
			$Insertar = "INSERT INTO pmn_web.detalle_productos_externos (cod_producto, cod_subproducto,";
			$Insertar.= "id_producto, referencia, peso_bruto, peso_resta,stock_bad,fecha) ";
			$Insertar.= "values('".$ProductoExt."','".$SubproductoExt."','".$Identificacion."','".$Correlativo."','".$PesoBruto."','".$PesoResta."','".$PesoFinal."','".$Fecha."')";
			mysqli_query($link, $Insertar);
			//ACTUALIZA CABECERA
			$Actualizar = "UPDATE pmn_web.productos_externos set ";
			$Actualizar.= " referencia = '".$Referencia."', ";
			$Actualizar.= " observacion = '".$Observacion."', ";
			$Actualizar.= " lote_ventana = '".$TxtLoteVentana."' ";
			$Actualizar.= " where cod_producto = '".$ProductoExt."'";
			$Actualizar.= " and cod_subproducto = '".$SubproductoExt."'";
			$Actualizar.= " and id_producto = '".$Identificacion."'";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
			
			//echo "lerolerolero";
			//Movimientos_Pmn('',$ProductoExt,$SubproductoExt,'2',$PesoFinal,'1','','','1-1',$CookieRut,'I',$Correlativo,'0');
			
			header("location:pmn_principal_reportes.php?TxtLoteVentana=".$TxtLoteVentana."&ProductoExt=".$ProductoExt."&SubproductoExt=".$SubproductoExt."&Tipo=".$Tipo."&Identificacion=".$Identificacion."&Existe=NO&PesoResta=".$PesoResta."&Tab1=true&TabE=true&CmbMes=".$CmbMes."&CmbAno=".$CmbAno);
		}
		else
		{
			$PesoBruto = str_replace(",",".",$PesoBruto);
			$PesoResta = str_replace(",",".",$PesoResta);
			$PesoFinal = $PesoBruto - $PesoResta;
			if ($Mostrar=="S")
			{
				$Consulta="select sum(peso_bruto+peso_resta) as suma from pmn_web.detalle_productos_externos ";
				$Consulta.=" where cod_producto = '".$ProductoExt."' ";
				$Consulta.= " and cod_subproducto = '".$SubproductoExt."' ";
				$Consulta.= " and id_producto = '".$Identificacion."' ";
				$Consulta.= " and referencia = '".$DetModificado."' ";
				$Respuesta1=mysqli_query($link, $Consulta);
				$Fila1=mysqli_fetch_array($Respuesta1);
				$Menor=$Fila1[suma];
				$Mayor=$PesoBruto+$PesoResta;
				$Diferencia=$Mayor-$Menor;
				$Actualizar="UPDATE pmn_web.stock set peso=(peso -".$Diferencia.") ";
				$Actualizar.=" where cod_producto='".$ProductoExt."' and cod_subproducto='".$SubproductoExt."' ";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}
			$Actualizar = "UPDATE pmn_web.detalle_productos_externos set ";
			$Actualizar.= " peso_bruto = '".$PesoBruto."', ";
			$Actualizar.= " peso_resta = '".$PesoResta."', ";
			$Actualizar.="	stock_bad='".$PesoFinal."'";
			$Actualizar.= " where cod_producto = '".$ProductoExt."' ";
			$Actualizar.= " and cod_subproducto = '".$SubproductoExt."' ";
			$Actualizar.= " and id_producto = '".$Identificacion."' ";
			$Actualizar.= " and referencia = '".$DetModificado."' ";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			//ACTUALIZA CABECERA
			$Actualizar = "UPDATE pmn_web.productos_externos set ";
			$Actualizar.= " referencia = '".$Referencia."', ";
			$Actualizar.= " observacion = '".$Observacion."', ";
			$Actualizar.= " lote_ventana = '".$TxtLoteVentana."' ";
			$Actualizar.= " where cod_producto = '".$ProductoExt."'";
			$Actualizar.= " and cod_subproducto = '".$SubproductoExt."'";
			$Actualizar.= " and id_producto = '".$Identificacion."'";
			mysqli_query($link, $Actualizar);
			
			//echo "acacacacaca";
			//Movimientos_Pmn('',$ProductoExt,$SubproductoExt,'2',$PesoFinal,'1','','','1-1',$CookieRut,'M',$TxtLoteVentana."-".$DetModificado,'0');
			
			header("location:pmn_principal_reportes.php?TxtLoteVentana=".$TxtLoteVentana."&ProductoExt=".$ProductoExt."&SubproductoExt=".$SubproductoExt."&Tipo=".$Tipo."&Identificacion=".$Identificacion."&Existe=NO&PesoResta=".$PesoResta."&Tab1=true&TabE=true&CmbMes=".$CmbMes."&CmbAno=".$CmbAno);
		}
	}
	if ($Proceso == "G3")
	{
		//ACTUALIZA CABECERA
		$Actualizar = "UPDATE pmn_web.productos_externos set ";
		$Actualizar.= " referencia = '".$Referencia."', ";
		$Actualizar.= " observacion = '".$Observacion."' ";
		$Actualizar.= " lote_ventana = '".$TxtLoteVentana."' ";
		$Actualizar.= " where cod_producto = '".$ProductoExt."'";
		$Actualizar.= " and cod_subproducto = '".$SubproductoExt."'";
		$Actualizar.= " and id_producto = '".$Identificacion."'";
		mysqli_query($link, $Actualizar);
		header("location:pmn_principal_reportes.php?TxtLoteVentana=".$TxtLoteVentana."&ProductoExt=".$ProductoExt."&SubproductoExt=".$SubproductoExt."&Tipo=".$Tipo."&Identificacion=".$Identificacion."&Existe=NO&Tab1=true&TabE=true&CmbMes=".$CmbMes."&CmbAno=".$CmbAno);
	}
	if ($Proceso == "E") //ELIMINA UN DETALLE Y SI ES EL UNICO BORRA LA CABECERA
	{
		for ($i = 0;$i < strlen($Marcados); $i++)
		{
			if (substr($Marcados,$i,1) == "-")
			{
				$Valor = substr($Marcados,0,$i);
				$Marcados = substr($Marcados,$i + 1);
				if ($Mostrar=="S")
				{
					$Consulta="select peso from pmn_web.stock ";
					$Consulta.=" where cod_producto='".$ProductoExt."' and cod_subproducto='".$SubproductoExt."' ";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$Consulta="select (peso_bruto-peso_resta)as resta from pmn_web.detalle_productos_externos where";
					$Consulta.= " cod_producto = '".$Producto."'";
					$Consulta.= " and cod_subproducto = '".$Subproducto."'";
					$Consulta.= " and id_producto = '".$Identificacion."'";
					$Consulta.= " and referencia = '".$Valor."'";
					$Respuesta1=mysqli_query($link, $Consulta);
					$Fila1=mysqli_fetch_array($Respuesta1);
					if ($Fila1[resta] > $Fila["peso"])
					{
						$Mensaje="S";
					}
					else
					{
						$Actualizar="UPDATE pmn_web.stock set peso=(peso -".$Fila1[resta].") ";
						$Actualizar.=" where cod_producto='".$ProductoExt."' and cod_subproducto='".$SubproductoExt."' ";
						//echo $Actualizar."<br>";
						mysqli_query($link, $Actualizar);
					}
				}
				$Eliminar = "delete from pmn_web.detalle_productos_externos where ";
				$Eliminar.= " cod_producto = '".$ProductoExt."'";
				$Eliminar.= " and cod_subproducto = '".$SubproductoExt."'";
				$Eliminar.= " and id_producto = '".$Identificacion."'";
				$Eliminar.= " and referencia = '".$Valor."'";
				mysqli_query($link, $Eliminar);
				
				//Movimientos_Pmn('',$ProductoExt,$SubproductoExt,'2','','1','','','1-1',$CookieRut,'E',$Valor,'0');
				
				$i = 0;
			}
		}
		//CONSULTO SI SE ELIMINARON TODOS LOS DETALLES DEL SUBPRODUCTO, SI ES ASI SE BORRA EL REGISTRO IDENTIFICADOR
		$Consulta = "select count(*) as total_detalles from pmn_web.detalle_productos_externos where ";
		$Consulta.= " cod_producto = '".$ProductoExt."'";
		$Consulta.= " and cod_subproducto = '".$SubproductoExt."'";
		$Consulta.= " and id_producto = '".$Identificacion."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			if ($Row[total_detalles] == 0)
			{
				$Eliminar = "delete from pmn_web.productos_externos where ";
				$Eliminar.= " cod_producto = '".$ProductoExt."'";
				$Eliminar.= " and cod_subproducto = '".$SubproductoExt."'";
				$Eliminar.= " and id_producto = '".$Identificacion."'";
				mysqli_query($link, $Eliminar);
				header("location:pmn_principal_reportes.php?ProductoExt=".$ProductoExt."&Tipo=".$Tipo."&SubproductoExt=".$SubproductoExt."&Existe=NO&Tab1=true&TabE=true");
			}
			header("location:pmn_principal_reportes.php?TxtLoteVentana=".$TxtLoteVentana."&ProductoExt=".$ProductoExt."&SubproductoExt=".$SubproductoExt."&Tipo=".$Tipo."&Identificacion=".$Identificacion."&Existe=NO&PesoResta=".$PesoResta."&Tab1=true&TabE=true");
		}
		else
		{
			header("location:pmn_principal_reportes.php?TxtLoteVentana=".$TxtLoteVentana."&ProductoExt=".$ProductoExt."&SubproductoExt=".$SubproductoExt."&Tipo=".$Tipo."&Identificacion=".$Identificacion."&Existe=NO&PesoResta=".$PesoResta."&Tab1=true&TabE=true");
		}
	}
?>