<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	
	
	$peso_tara=str_replace('.','',$peso_tara);
	$peso_tara=str_replace(',','.',$peso_tara);
	$peso=str_replace('.','',$peso);
	$peso=str_replace(',','.',$peso);
	if ($proceso == "B")
	{
		$vector_prod = explode('-',$fecha_prod); //0:ano, 1:mes, 2:dia.
		$vector_ven = explode('-',$fecha_ven);
		
		$linea = "mostrarPSub2=S&recargapag1=S&cmbproducto2=".$producto."&cmbsubproducto2=".$subproducto."&cmbidentificacion2=".$id;
		$linea.= "&txtnumero2=".$num."&txtpesoNorm=".$peso."&txtpesoTara=".$peso_tara."&txtidAna=".$id_analisis;
		$linea.= "&dia1=".$vector_prod[2]."&mes1=".$vector_prod[1]."&ano1=".$vector_prod[0];
		$linea.= "&fecha_prodMod=".$fecha_prod."&fecha_venMod=".$fecha_ven;
		
		if ($fecha_ven == '0000-00-00')
		{		
			$linea.= "&cmbdisponibilidadMod=S";
			$linea.= "&dia2=".$vector_prod[2]."&mes2=".$vector_prod[1]."&ano2=".$vector_prod[0];			
		}
		else
		{
			$linea.= "&cmbdisponibilidadMod=V";
			$linea.= "&dia2=".$vector_ven[2]."&mes2=".$vector_ven[1]."&ano2=".$vector_ven[0];			
		}
	
		//echo "acaca";
		echo "<script language='JavaScript'>\n";
		echo "window.opener.document.frmPrincipalRpt.action='pmn_principal_reportes.php?".$linea."&Tab12=true';\n";
		echo "window.opener.document.frmPrincipalRpt.submit();\n";			
		echo "window.close();\n";
		echo "</script>\n";
		//header("Location:pmn_principal_reportes.php.php?".$linea."&Tab12=true");
	}
	
	$txtpeso2=str_replace('.','',$txtpeso2);
	$txtpeso2=str_replace(',','.',$txtpeso2);
	$txtpeso=str_replace('.','',$txtpeso);
	$txtpeso=str_replace(',','.',$txtpeso);
	//---------.
	if ($proceso == "G")
	{
		$fecha_prod = $ano1.'-'.str_pad($mes1,'2','0',STR_PAD_LEFT).'-'.$dia1;
		$fecha_ven = $ano2.'-'.str_pad($mes2,'2','0',STR_PAD_LEFT).'-'.$dia2;
		
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
			if($cmbdisponibilidad=='S')
				$fecha_ven='00-00-0000';
			else
				$fecha_ven=$fecha_ven;	
			$insertar = "INSERT INTO pmn_web.produccion_subproductos (fecha_produccion,cod_producto,cod_subproducto,identificacion,numero,peso,peso_tara,fecha_venta,id_analisis)";
			$insertar.= " VALUES ('".$fecha_prod."', '".$cmbproducto."', '".$cmbsubproducto."', '".$cmbidentificacion."', '".$txtnumero."',";
			$insertar.= "'".$txtpeso."','".$txtpeso2."', '".$fecha_ven."', '".$txtid."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);
			
			//Movimientos_Pmn('',$cmbproducto,$cmbsubproducto,'2',$txtpeso,$txtpeso2,'0',$txtnumero,'11',$CookieRut,'I',$fecha_prod,'0');
			
			$linea = "recargapag1=S&mostrarPSub=Q&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto."&cmbidentificacion=".$cmbidentificacion."&txtid=".$txtid."&cmbdisponibilidad=".$cmbdisponibilidad."&ano1=".$ano1."&mes1=".$mes1."&dia1=".$dia1."&Tab12=true";
			header("Location:pmn_principal_reportes.php?".$linea);
			//poly puse el break 2005-11-18
			break;
		}
	}
			
	//-------.
	if ($proceso == "M")
	{
		$fecha_prod = $ano1.'-'.str_pad($mes1,'2','0',STR_PAD_LEFT).'-'.$dia1;	
		$fecha_ven = $ano2.'-'.str_pad($mes2,'2','0',STR_PAD_LEFT).'-'.$dia2;
		
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
		
		//Movimientos_Pmn('',$cmbproducto,$cmbsubproducto,'2',$txtpeso,$txtpeso2,'0',$num_aux,'11',$CookieRut,'M',$fecha_prod,'0');
		
		$linea = "recargapag1=S&mostrarPSub=Q&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto."&txtid=".$txtid."&Tab12=true";
		header("Location:pmn_principal_reportes.php?".$linea);
	}
	
	//-------.
	if ($proceso == "E")
	{
		//para escoria pmn subproducto horno trof
		//echo "acaca ELIMINACION";
		if ($cmbproducto !="28")
		{
		
			$eliminar = "DELETE FROM pmn_web.produccion_subproductos";
			$eliminar.= " WHERE fecha_produccion = '".$fecha_aux_prod."' AND cod_producto = '".$producto_aux."' AND cod_subproducto = '".$subproducto_aux."'";
			$eliminar.= " AND identificacion = '".$id_aux."' AND numero = '".$num_aux."'";
			//echo $eliminar."<br>";
			mysqli_query($link, $eliminar);
			
			//Movimientos_Pmn('',$producto_aux,$subproducto_aux,'2','0','0','0',$num_aux,'11',$CookieRut,'E',$fecha_aux_prod,'0');
			
			$linea = "recargapag1=S&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto;
			header("Location:pmn_principal_reportes.php?".$linea."&Tab12=true");		
		}
		else
		{
			$i=1;
            $l = 0;
			$linea1 		=explode("~",$linea);
			//$producto 		=$linea1[0];
			//$subproducto	=$linea1[1];
			//$txtid 			=$linea1[2];
			//$identificacion	=$linea1[3];
			//$disponibilidad	=$linea1[4];
			
			$var1 = explode("~~",$Valor);
            	$il =count($var1);
            	for ($i=1; $i<=$il; $i++ )
            	{
                	list($fecha_venta,$numero,$peso) = explode("~",$var1[$i-1]);
					//echo $fecha_venta."<br>"; 
                	//if ($fecha_venta!="")
                	//{
						$fecha_ven = $ano2.'-'.str_pad($mes2,'2','0',STR_PAD_LEFT).'-'.$dia2;

                 		$eliminar = "DELETE FROM pmn_web.produccion_subproductos";
						$eliminar.= " WHERE  cod_producto = '".$producto_aux."' AND cod_subproducto = '".$subproducto_aux."'";
						if($fecha_prod!="")
							$eliminar=" and fecha_produccion = '".$fecha_aux_prod."'";
						if($fecha_venta!="")
							$eliminar=" and fecha_venta = '".$fecha_aux_ven."'";
						$eliminar.= " AND id_analisis = '".$id_analisis_aux."' AND numero = '".$num_aux."'";
						//echo $eliminar."<br>";
						mysqli_query($link, $eliminar);
						//echo "elei".$eliminar;
			
						//Movimientos_Pmn('',$producto_aux,$subproducto_aux,'2','0','0','',$num_aux,'11',$CookieRut,'E',$fecha_aux_prod,'0');
						
					//}
				}
				if ($todos>0)
				{
					$linea = "recargapag1=S&mostrarPSub=Q&cmbproducto=".$producto."&cmbsubproducto=".$subproducto."&cmbdisponibilidad=".$disponibilidad."&cmbidentificacion=".$identificacion."&txtid=".$txtid."&ano1=".$ano1."&mes1=".$mes1."&dia1=".$dia1;
				}
				else
				{	
					$linea = "recargapag1=S&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto;
				}
			
			header("Location:pmn_principal_reportes.php?".$linea."&Tab12=true");		
		}	
	}
?>
