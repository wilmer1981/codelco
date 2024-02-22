<?php
	include("../principal/conectar_principal.php");
	switch ($Proceso)
	{
		case "G";
			$Consulta = "select * from age_web.relaciones ";
			$Consulta.= " where cod_producto='1'";
			$Consulta.= " and cod_subproducto='".$SubProducto."'";
			$Consulta.= " and rut_proveedor='".$Rut."'";
			$Consulta.= " and flujo='".$Flujos."'";
			$Resp = mysqli_query($link, $Consulta);
			if (!$Fila = mysqli_fetch_array($Resp))
			{				
				//INSERTA
				$Insertar = "insert into age_web.relaciones (cod_producto, cod_subproducto, rut_proveedor, flujo, grupo,leyes,impurezas)";
				$Insertar.= " values('1','".$SubProducto."','".$Rut."','".$Flujos."','".$ChkGrupo."','$TxtCodLeyes','$TxtCodImpurezas')";
				mysqli_query($link, $Insertar);
				//INSERTAR EN IMPUREZAS
				$Consulta="select nombre_prv from sipa_web.proveedores where rut_prv='".$Rut."' ";
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Resp))	
				{
					$CodProd=str_pad($SubProducto,3,'0',STR_PAD_LEFT);
					$RutPrv=str_pad(str_replace('-','',$Rut),9,'0',STR_PAD_LEFT);
					$NomPrv=$Fila["nombre_prv"];
					$Consulta="select * from imp_web.proveedores where tipo_producto='".$CodProd."' and rut_proveedor='".$RutPrv."'";
					//echo $Consulta."<br>";
					$Resp2=mysqli_query($link, $Consulta);
					if(!$Fila2=mysqli_fetch_array($Resp2))
					{
						$Insertar="insert into imp_web.proveedores(tipo_producto,rut_proveedor,nombre) values(";
						$Insertar.="'".$CodProd."','".$RutPrv."','".$NomPrv."')";
						//echo $Insertar."<br>";
						mysqli_query($link, $Insertar);
					}
				}
				
				
			}
			echo "<script language='JavaScript'>";
			echo " window.opener.document.frmPrincipal.action = 'age_relaciones.php?TipoBusq=".$TipoBusq."&Mostrar=S&SubProducto=".$SubProducto."&Proveedor=".$Proveedor."&Flujos=".$Flujos."&ChkTipoFlujo=".$ChkTipoFlujo."&TipoFlujo=".$ChkTipoFlujo."';";
			echo " window.opener.document.frmPrincipal.submit();";
			echo " window.close();";
			echo "</script>";
			break;
		case "M":
			$Consulta = "select * from age_web.relaciones ";
			$Consulta.= " where cod_producto='1'";
			$Consulta.= " and cod_subproducto='".$SubProducto."'";
			$Consulta.= " and rut_proveedor='".$Rut."'";
			//echo $Consulta;
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{				
				//ACTUALIZAR
				$Actualizar = "UPDATE age_web.relaciones SET ";
				if ($Flujos == "S")
					$Actualizar.= " flujo = '0'";
				else
					$Actualizar.= " flujo = '".$Flujos."'";
				$Actualizar.= " , grupo = '".$ChkGrupo."'";
				$Actualizar.= ",leyes='$TxtCodLeyes'";
				$Actualizar.= ",impurezas='$TxtCodImpurezas'";
				$Actualizar.= " where cod_producto='1'";
				$Actualizar.= " and cod_subproducto='".$SubProducto."'";
				$Actualizar.= " and rut_proveedor='".$Rut."'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar;
			}
			echo "<script language='JavaScript'>";
			echo " window.opener.document.frmPrincipal.action = 'age_relaciones.php?TipoBusq=".$TipoBusq."&Mostrar=S&SubProducto=".$SubProducto."&Proveedor=".$Proveedor."&Flujos=".$Flujos."&ChkTipoFlujo=".$ChkTipoFlujo."&TipoFlujo=".$ChkTipoFlujo."';";
			echo " window.opener.document.frmPrincipal.submit();";
			echo " window.close();";
			echo "</script>";
			break;
		case "E";
			$Datos=explode('~~',$Valores);
			$SubProducto=$Datos[0];
			$Rut=$Datos[1];
			$Flujos=$Datos[2];
			$Eliminar = "delete from age_web.relaciones ";
			$Eliminar.= " where cod_producto='1'";
			$Eliminar.= " and cod_subproducto='".$SubProducto."'";
			$Eliminar.= " and rut_proveedor='".$Rut."'";
			$Eliminar.= " and flujo='".$Flujos."'";
			mysqli_query($link, $Eliminar);
			header("location:age_relaciones.php?TipoBusq=".$TipoBusqueda."&Mostrar=S&SubProducto=".$SubProducto."&Proveedor=".$Proveedor."&Flujos=".$Flujos."&ChkTipoFlujo=".$TipoFlujo."&TipoFlujo=".$TipoFlujo);
			break;
	}
?>