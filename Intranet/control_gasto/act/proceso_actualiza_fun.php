<? 
	include("conectarRRHH.php");
	$consulta = "SELECT APELLIDO_PATERNO, APELLIDO_MATERNO, NOMBRES, RUT, COD_CENTRO_COSTO ";
	$consulta = "$consulta FROM antecedentes_personales ORDER BY APELLIDO_PATERNO";
	$result = mysql_query($consulta);
	$i = 0;
	while ($row = mysql_fetch_array($result))
	{
		$BD_RRHH[$i][0] = $row[RUT];
		$NombreFun = strtoupper($row[APELLIDO_PATERNO])." ".strtoupper($row[APELLIDO_MATERNO])." ".strtoupper($row[NOMBRES]);
        $BD_RRHH[$i][1] = $NombreFun;
		$PrimerDig = substr($row[COD_CENTRO_COSTO],3,2);
		$SegundoDig = substr($row[COD_CENTRO_COSTO],6,2);
		$BD_RRHH[$i][2] =  "$PrimerDig$SegundoDig";
		//echo "Funcionario: ".$BD_RRHH[$i][0]." ".$BD_RRHH[$i][1]." ".$BD_RRHH[$i][2]."<br>\n";
		$i++;
	}
   	mysql_close($link);
	include("conectarCGASTOS.php");
	$BorrarFun = "DELETE FROM usuario";
	mysql_query($BorrarFun,$link);
	//INSERTAR REGISTROS NUEVOS
	$i = 0;
	$LargoArreglo = count($BD_RRHH);
	while ( $i < $LargoArreglo)
	{
		$Insertar = "INSERT INTO USUARIO (RUT_FUNCIONARIO, NOMBRE, CENTRO_COSTO) ";
		$Insertar = "$Insertar VALUES('".$BD_RRHH[$i][0]."', '".$BD_RRHH[$i][1]."', '".$BD_RRHH[$i][2]."')";
		//echo "Funcionario: ".$BD_RRHH[$i][0]." ".$BD_RRHH[$i][1]." ".$BD_RRHH[$i][2]."<br>\n";
		mysql_query($Insertar,$link);
		$i++;
	}
	//-------------------------
	mysql_close($link);
	header("location:actualiza_funcionarios.php?OK=S");
?>
