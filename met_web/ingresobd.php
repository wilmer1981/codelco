<?

	include("../principal/encabezado.php");
	include("conectar.php"); 
	echo $NombreArch;
	$Archivo = "../met_web/archivos/".$NombreArch;

	if(file_exists($Archivo))
	{
		$Arr = file($Archivo);
		$bd=$Valor;
		echo $bd;
		while (list ($Linea, $Contenido) = each ($Arr)) 
		{
			echo $Linea."<br>";
			$Pos=strpos($Contenido,"Cargo") ;
			$Linea=substr($Contenido,($Pos+0));
			$Linea = str_replace('","',';',$Linea);
			$Linea = str_replace('",',';',$Linea);
			$Linea = str_replace(',"',';',$Linea);
			$Linea = str_replace(';;',' ; ; ',$Linea);
			$Linea = trim(str_replace("'"," ",$Linea));
			$Linea = substr($Linea,0,strlen($Linea)+1);
			$ContCampos=1;
			for($i=0;strlen($Linea);$i++)
			{
				if(substr($Linea,$i,1)==";"||($i==strlen($Linea)))
				{
					if($i==strlen($Linea)) 
						$Valor=substr($Linea,0,$i);
					else
						$Valor=substr($Linea,0,$i);
		$bandera=0;
					switch($ContCampos)
					{
					
						case 1:
							$FECHA = trim($Valor);
							$uno=substr($FECHA, 0, 2);
							$dos=substr($FECHA, 3, 2);
							$tres=substr($FECHA, 6, 4);
							
							$cad2 = ($tres."-".$dos."-".$uno);
							
						$sql2="Select * from $bd where FECHA=$'cad2'";
						$s=mysql_query($sql2);
						if ($s != '')
							{
								$bandera=1;
							}
							else
							{
								$bandera=0;
							}
						case 2:
							$TMOV = trim($Valor);
						case 3:
							$FLUJO = trim($Valor);
						case 4:
							$ITEM = trim($Valor);
						case 5:
							$PSECO = trim($Valor);
						case 6:
							$FCOBRE = trim($Valor);
						case 7:
							$FPLATA = trim($Valor);
						case 8:
							$FORO = trim($Valor);
							
					}
					$ContCampos++;
					$Linea = substr($Linea,($i+1));
					$i=0;
				}
			}
			if ($bandera==0)
			{
				
				$Insertar = "insert into $bd (FECHA,T_MOV,N_FLUJO,NOM_PRODUCTO,P_SECO,F_COBRE,F_PLATA,F_ORO) values (";
				$Insertar.= "'".str_replace(".","",$cad2)."','".$TMOV ."','".$FLUJO."','".$ITEM."','".$PSECO."','".$FCOBRE."','".$FPLATA."','".$FORO."')";
				//echo $Insertar;
				mysql_query($Insertar);
				
			}
				
			else
			{
				echo "Los datos han sidos ingresados";
			}
			
			$ContRegistros++;
		}
		$Mensaje="Cantidad de Clientes Grabados:".$ContRegistros;
	}
	else
		$Mensaje="Archivo no Existe";

	include("../principal/pie_pagina.php");  		         
?>