<?php 
	include("conectar_principal.php");

	//Proceso=G&valores_niveles=valores_sistema=&valores_niveles=
	//Proceso=G&valores_sistema=99/&valores_niveles=1/

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else {
		$Proceso = "";
	}
	if(isset($_REQUEST["valores_niveles"])){
		$valores_niveles = $_REQUEST["valores_niveles"];
	}else {
		$valores_niveles = "";
	}
	if(isset($_REQUEST["valores_sistema"])){
		$valores_sistema = $_REQUEST["valores_sistema"];
	}else {
		$valores_sistema = "";
	}
	if(isset($_REQUEST["funcionarios"])){
		$funcionarios = $_REQUEST["funcionarios"];
	}else {
		$funcionarios = "";
	}
	/*
	echo "Proceso".$Proceso."<br>";
	echo "valores_sistema:".$valores_sistema."<br>";
	echo "valores_niveles:".$valores_niveles."<br>";
	exit();
	*/

	$largo_s = strlen($valores_sistema);
	$largo_v = strlen($valores_niveles);
	for ($i=0; $i < $largo_s; $i++)
	{
		if (substr($valores_sistema,$i,1) == "/")
		{				
			$valor_s = substr($valores_sistema,0,$i);				
			$valores_sistema = substr($valores_sistema,$i+1);
			$i = 0;
			$sql = "SELECT * from sistemas_por_usuario";
			$sql.= " where rut = '".$funcionarios."'";
			$sql.= " AND cod_sistema = ".$valor_s;
			$result = mysqli_query($link, $sql);
			if ($row = mysqli_fetch_array($result))
			{
				// EXISTE SISTEMA PARA EL USUARIO
				for ($j=0; $j < $largo_v; $j++)
				{
					if (substr($valores_niveles,$j,1) == "/")
					{				
						$valor_n = substr($valores_niveles,0,$j);				
						$valores_niveles = substr($valores_niveles,$j+1);
						$j=0;
						switch ($Proceso)
						{
							case "G":
								if ($valor_n != "S")
								{
									$actualizar = "UPDATE sistemas_por_usuario set nivel =  ".$valor_n;
									$actualizar.=" where rut ='".$funcionarios."' and cod_sistema =".$valor_s; 
									mysqli_query($link, $actualizar);						 
								}
								break;
							case "E":
								$Eliminar = "delete from sistemas_por_usuario ";
								$Eliminar.=" where rut ='".$funcionarios."' and cod_sistema =".$valor_s; 
								mysqli_query($link, $Eliminar);
								break;
						}							
						break;
					}
				}
			}
			else
			{
				if ($Proceso == "G") // SOLO SI EL PROCESO ES GRABAR POR QUE SINO NO SE PUEDE ELIMINAR
				{
					$Insertar = "INSERT INTO sistemas_por_usuario";
					$Insertar = "$Insertar (rut, cod_sistema, nivel)";
					$Insertar = "$Insertar VALUES ('".$funcionarios."',". $valor_s.", 0)";
					//INSERTO MAS ABAJO PARA ASEGURARME QUE HAY VALORES DE NIVELES					
					for ($j=0; $j < $largo_v; $j++)
					{
						if (substr($valores_niveles,$j,1) == "/")
						{				
							$valor_n = substr($valores_niveles,0,$j);				
							$valores_niveles = substr($valores_niveles,$j+1);
							$j=0;
							if ($valor_n != "S")
							{
								$actualizar = "UPDATE sistemas_por_usuario set nivel =  ".$valor_n;
								$actualizar.=" where rut ='".$funcionarios."' and cod_sistema =".$valor_s;  
								//--------AQUI INSERTO-----
								mysqli_query($link, $Insertar);
								//-------------------------
								mysqli_query($link, $actualizar);
														 
							}
							
							break;
						}
					}
				}
			}				 
		 }			 
	}			
	header ("location:ing_fun_nivel.php?Mensaje=Datos Guardados Exitosamente&funcionarios=".$funcionarios);
	include("cerrar_principal.php");

?>