<?
	include("../principal/conectar_principal.php"); 

	$Archivo = "archivos/clientes/clientes.txt";
	if(file_exists($Archivo))
	{
		$Arr = file($Archivo);
		$Eliminar='delete from fac_web.clientes';
		mysql_query($Eliminar);
		$ContRegistros=0;
		while (list ($Linea, $Contenido) = each ($Arr)) 
		{
			$Pos=strpos($Contenido,"Cargo") ;
			//echo $Contenido."<br><BR>";
			$Linea=substr($Contenido,($Pos+28));
			$Linea = str_replace('","',';',$Linea);
			$Linea = str_replace('",',';',$Linea);
			$Linea = str_replace(',"',';',$Linea);
			$Linea = str_replace(';;',' ; ; ',$Linea);
			$Linea = trim(str_replace("'"," ",$Linea));
			$Linea = substr($Linea,0,strlen($Linea)-1);
			//echo $Linea."<br><BR>";
			$ContCampos=1;
			for($i=0;strlen($Linea);$i++)
			{
				if(substr($Linea,$i,1)==";"||($i==strlen($Linea)))
				{
					if($i==strlen($Linea)) 
						$Valor=substr($Linea,0,$i);
					else
						$Valor=substr($Linea,0,$i);
					switch($ContCampos)
					{
						case 1:
							$Rut = trim($Valor);
						case 2:
							$RazonSocial = trim($Valor);
						case 3:
							$NombreFantasia = trim($Valor);
						case 4:
							$Giro = trim($Valor);
						case 5:
							$Origen = trim($Valor);
						case 6:
							$Nivel = trim($Valor);
						case 7:
							$Estado = trim($Valor);
						case 8:
							$Sucursal = trim($Valor);
						case 9:
							$NomSucursal = trim($Valor);
						case 10:
							$DireccionSucursal = trim($Valor);
						case 11:
							$Comuna = trim($Valor);
						case 12:
							$Pais = trim($Valor);
						case 13:
							$Telefono = trim($Valor);
						case 14:
							$Internet = trim($Valor);
						case 15:
							$DireccionCobranza = trim($Valor);
						case 16:
							$Contacto = trim($Valor);
						case 17:
							$Contactos = trim($Valor);
						case 18:
							$Cargo = trim($Valor);
						case 19:
							$Nombre = trim($Valor);
						case 20:
							$Internet2 = trim($Valor);
					}
					$ContCampos++;
					$Linea = substr($Linea,($i+1));
					$i=0;
				}
			}
			$Insertar = "insert into fac_web.clientes (rut,razon_social,nombre_fantasia,giro,origen,nivel,estado,sucursal,nom_sucursal,direccion_sucursal,comuna,pais,telefono,internet,direccion_cobranza,contacto,contactos,cargo,nombre,internet2) values (";
			$Insertar.= "'".str_replace(".","",$Rut)."','".$RazonSocial ."','".$NombreFantasia."','".$Giro."','".$Origen."','".$Nivel."','".$Estado."','".$Sucursal."','".$NomSucursal."','".$DireccionSucursal."','".$Comuna."','".$Pais."','".$Telefono."','".$Internet."','".$DireccionCobranza."','".$Contacto."','".$Contactos."','".$Cargo."','".$Nombre."','".$Internet2."')";
			//echo $Insertar."<br><br>";
			mysql_query($Insertar);
			$ContRegistros++;
		}
		$Mensaje="Cantidad de Clientes Grabados:".$ContRegistros;
	}
	else
		$Mensaje="Archivo no Existe";
	
	header('location:fac_sube_clientes.php?Mensaje='.$Mensaje);	  		         
	//echo "CANTIDAD DE CLIENTES:".$ContRegistros;
?>