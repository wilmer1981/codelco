<?php
	include("../principal/conectar_pmn_web.php");
	
	if ($proceso == "B")
	{
		$vector_prod = explode('-',$fecha_prod); //0:ano, 1:mes, 2:dia.
		$vector_ven = explode('-',$fecha_ven);
		
		$linea = "mostrar=S&recargapag1=S&cmbproducto=".$producto."&cmbsubproducto=".$subproducto."&cmbidentificacion=".$id;
		$linea.= "&txtnumero=".$num."&txtpeso=".$peso."&txtpeso2=".$peso2."&txtid=".$id_analisis;
		$linea.= "&dia1=".$vector_prod[2]."&mes1=".$vector_prod[1]."&ano1=".$vector_prod[0];
		$linea.= "&fecha_prod=".$fecha_prod."&fecha_ven=".$fecha_ven;
		
		if ($fecha_ven == '0000-00-00')
		{		
			$linea.= "&cmbdisponibilidad=S";
			$linea.= "&dia2=".$vector_prod[2]."&mes2=".$vector_prod[1]."&ano2=".$vector_prod[0];			
		}
		else
		{
			$linea.= "&cmbdisponibilidad=V";
			$linea.= "&dia2=".$vector_ven[2]."&mes2=".$vector_ven[1]."&ano2=".$vector_ven[0];			
		}


		header("Location:pmn_ing_produccion_subproductos.php?".$linea);
	}
	
	//---------.
	if ($proceso == "G")
	{
		$fecha_prod = $ano1.'-'.$mes1.'-'.$dia1;
		$fecha_ven = $ano2.'-'.$mes2.'-'.$dia2;
		
		$consulta = "SELECT * FROM pmn_web.produccion_subproductos";
		$consulta.= " WHERE fecha_produccion = '".$fecha_prod."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND identificacion = '".$cmbidentificacion."' AND numero = '".$txtnumero."'";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mensaje = "Los Datos Ingresados Ya Existen";
			
			echo '<script language="JavaScript">';
			echo 'alert("'.$mensaje.'");';
			echo 'window.history.back()';
			echo '</script>';
			break;
		}
		else
		{
			$insertar = "INSERT INTO pmn_web.produccion_subproductos (fecha_produccion,cod_producto,cod_subproducto,identificacion,numero,peso,peso_tara,fecha_venta,id_analisis)";
			$insertar.= " VALUES ('".$fecha_prod."', '".$cmbproducto."', '".$cmbsubproducto."', '".$cmbidentificacion."', '".$txtnumero."',";
			$insertar.= "'".$txtpeso."','".$txtpeso2."', '".$fecha_ven."', '".$txtid."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);
			
			$linea = "recargapag1=S&mostrar=Q&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto."&cmbidentificacion=".$cmbidentificacion."&txtid=".$txtid."&cmbdisponibilidad=".$cmbdisponibilidad."&ano1=".$ano1."&mes1=".$mes1."&dia1=".$dia1;
			header("Location:pmn_ing_produccion_subproductos.php?".$linea);
			//poly puse el break 2005-11-18
			break;
		}
	}
			
	//-------.
	if ($proceso == "M")
	{
		$fecha_prod = $ano1.'-'.$mes1.'-'.$dia1;	
		$fecha_ven = $ano2.'-'.$mes2.'-'.$dia2;
		
		$actualizar = "UPDATE pmn_web.produccion_subproductos SET ";
		$actualizar.= " fecha_produccion = '".$fecha_prod."',";
		$actualizar.= " cod_producto = '".$cmbproducto."',";
		$actualizar.= " cod_subproducto = '".$cmbsubproducto."',";		
		$actualizar.= " identificacion = '".$cmbidentificacion."',";		
		$actualizar.= " numero = '".$txtnumero."',";
		$actualizar.= " peso = '".$txtpeso."',";
		$actualizar.= " peso_tara = '".$txtpeso2."',";
		$actualizar.= " fecha_venta = '".$fecha_ven."',";
		$actualizar.= " id_analisis = '".$txtid."'";
		$actualizar.= " WHERE fecha_produccion = '".$fecha_aux_prod."' AND cod_producto = '".$producto_aux."' AND cod_subproducto = '".$subproducto_aux."'";
		$actualizar.= " AND identificacion = '".$id_aux."' AND numero = '".$num_aux."' AND peso = '".$peso_aux."' AND fecha_venta = '".$fecha_aux_ven."'";
		//echo $actualizar."<br>";
		mysqli_query($link, $actualizar);
		
		$linea = "recargapag1=S&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto;
		header("Location:pmn_ing_produccion_subproductos.php?".$linea);
	}
	
	//-------.
	if ($proceso == "E")
	{
		//para escoria pmn subproducto horno trof
		if ($cmbproducto !="28")
		{
		
			$eliminar = "DELETE FROM pmn_web.produccion_subproductos";
			$eliminar.= " WHERE fecha_produccion = '".$fecha_aux_prod."' AND cod_producto = '".$producto_aux."' AND cod_subproducto = '".$subproducto_aux."'";
			$eliminar.= " AND identificacion = '".$id_aux."' AND numero = '".$num_aux."'";
			mysqli_query($link, $eliminar);
			$linea = "recargapag1=S&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto;
			header("Location:pmn_ing_produccion_subproductos.php?".$linea);		
		}
		else
		{
			$i=1;
            $l = 0;
			$linea1 		=explode("~",$linea);
			$producto 		=$linea1[0];
			$subproducto	=$linea1[1];
			$txtid 			=$linea1[2];
			$identificacion	=$linea1[3];
			$disponibilidad	=$linea1[4];
			
			$var1 = explode("~~",$Valor);
            	$il =count($var1);
            	for ($i=1; $i<=$il; $i++ )
            	{
                	list($fecha_venta,$numero,$peso) = explode("~",$var1[$i-1]);
                	if ($fecha_venta!="")
                	{
						$fecha_ven = $ano2.'-'.$mes2.'-'.$dia2;

                 		$eliminar = "DELETE FROM pmn_web.produccion_subproductos";
						$eliminar.= " WHERE fecha_venta = '".$fecha_venta."' AND cod_producto = '".$producto."' AND cod_subproducto = '".$subproducto."'";
						$eliminar.= " AND id_analisis = '".$txtid."' AND numero = '".$numero."'";
						
						mysqli_query($link, $eliminar);
						//echo "elei".$eliminar;
					}
				}
				if ($todos>0)
				{
					$linea = "recargapag1=S&mostrar=Q&cmbproducto=".$producto."&cmbsubproducto=".$subproducto."&cmbdisponibilidad=".$disponibilidad."&cmbidentificacion=".$identificacion."&txtid=".$txtid."&ano1=".$ano1."&mes1=".$mes1."&dia1=".$dia1;
				}
				else
				{	
					$linea = "recargapag1=S&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto;
				}
			
			header("Location:pmn_ing_produccion_subproductos.php?".$linea);		
		}	
	}
?>
