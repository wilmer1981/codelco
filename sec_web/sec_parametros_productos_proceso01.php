<?php
	include("../principal/conectar_sec_web.php");
	
	switch ($Proceso)
	{
		case "N":
			//if (OptPesoValido)			
			$Consulta = "SELECT * FROM sec_web.parametros_productos WHERE cod_subproducto = ".$CmbSubProducto;
			$Rs = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Rs))
			{
				/*echo '<script languaje="JavaScript">';
				echo 'alert("Ya Existen Parametros Para Este Producto")';
				echo '</script>';*/
				//Ya Existe.
			}
			else 
			{
				$Insertar="insert into sec_web.parametros_productos (cod_subproducto,procedencia,peso_promedio,peso_valido,descripcion_ingles) values (";
				$Insertar = $Insertar."'$CmbSubProducto',";
				$Insertar = $Insertar."'$TxtProcedencia',";
				$Insertar = $Insertar."$TxtPesoPromedio,";
				$Insertar = $Insertar."'$OptPesoValido',";
				$Insertar = $Insertar."'$TxtDescripcionIngles')";
				mysqli_query($link, $Insertar);
			}
			break;
		case "M":
			$Modificar="UPDATE sec_web.parametros_productos set procedencia='".$TxtProcedencia."',peso_promedio=".$TxtPesoPromedio.",peso_valido='".$OptPesoValido."',descripcion_ingles='".$TxtDescripcionIngles."' where cod_subproducto='".$CmbSubProducto."'";
			mysqli_query($link, $Modificar);
			break;
		case "E":
			$EncontroRelacion=false;
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$SubProductoCorr=substr($Datos,0,$i);
					for ($j=0;$j<=strlen($SubProductoCorr);$j++)
					{
						if (substr($SubProductoCorr,$j,2)=="~~")
						{
							$SubProducto=substr($SubProductoCorr,0,$j);
							$Corr=substr($SubProductoCorr,$j+2);
							$Eliminar="delete from  sec_web.parametros_productos where cod_subproducto='".$SubProducto."'";
							mysqli_query($link, $Eliminar);
						}	
					}
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}
	if ($Proceso=="E")
	{
		header("location:sec_parametros_productos.php");
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmParamProducto.action='sec_parametros_productos.php';";
		echo "window.opener.document.FrmParamProducto.submit();";
		echo "window.close();";
		echo "</script>";
	}	
?>