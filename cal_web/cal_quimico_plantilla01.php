<?php
	include("../principal/conectar_principal.php");
	if(isset($_REQUEST["Opcion"])) {
		$Opcion = $_REQUEST["Opcion"];
	}else{
		$Opcion =  "";
	}
	if(isset($_REQUEST["sprod"])) {
		$sprod = $_REQUEST["sprod"];
	}else{
		$sprod =  "";
	}
	if(isset($_REQUEST["prod"])) {
		$prod = $_REQUEST["prod"];
	}else{
		$prod =  "";
	}
	if(isset($_REQUEST["elimina_pla"])) {
		$elimina_pla = $_REQUEST["elimina_pla"];
	}else{
		$elimina_pla =  "";
	}
	
	switch ($Opcion)
	{		
		case "S":
			header("location:../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=12");	
			break;
		case "E":
			for ($i=0;$i<=strlen($Leyes);$i++)
			{
				if (substr($Leyes,$i,2)=="//")
				{
					$Ley = substr($Leyes,0,$i);
					$Eliminar = "delete from cal_web.leyes_por_plantillas where rut_funcionario='0' and cod_plantilla=".$Cod_Plantilla." and cod_leyes='".$Ley."'";
					mysqli_query($link, $Eliminar);
					$Leyes=substr($Leyes,$i+2);
					$i=0;
				}
			}
			$Consulta = "select * from cal_web.leyes_por_plantillas where rut_funcionario='0' and cod_plantilla=".$Cod_Plantilla;
			$Respuesta=mysqli_query($link, $Consulta);
			if (!$Fila=mysqli_fetch_array($Respuesta))
			{
				$Eliminar = "delete from cal_web.plantillas where rut_funcionario='0' and cod_plantilla=".$Cod_Plantilla;
				mysqli_query($link, $Eliminar);
				$TxtNombrePlantilla="";
			}
			header ("location:cal_quimico_plantilla.php?Productos=".$CmbProductos."&SubProductos=".$CmbSubProducto."&Plantilla=".$Cod_Plantilla."&NombrePlantilla=".$TxtNombrePlantilla);		
			break;
	
			case "Z":
					
				$producto=$prod;
				$sproducto=$sprod;
				$Datos=explode("//",$elimina_pla);
				$contador = count($Datos);
			
			
				
				for ($i=0;$i<=$contador; $i++)
					
				{ 
					list($Rut,$Cod_Plantilla,$prod,$sprod)= explode(":",$Datos[$i]);
					$Consulta = "select * from cal_web.leyes_por_plantillas where rut_funcionario = '".$Rut."' and  cod_plantilla='".$Cod_Plantilla."'";
					$Respuesta=mysqli_query($link, $Consulta);
				    while ($Fila=mysqli_fetch_array($Respuesta))
					{
					    $rut_e = $Fila["rut_funcionario"];
						$num_p = $Fila["cod_plantilla"];
                        $ley   = $Fila["cod_leyes"];
						$Eliminar = "delete from cal_web.leyes_por_plantillas where rut_funcionario='$rut_e' and cod_plantilla='$num_p' and cod_leyes ='$ley'";
						mysqli_query($link, $Eliminar);
					}
					$Consulta = "select * from cal_web.plantillas where rut_funcionario = '".$Rut."' and  cod_plantilla='".$Cod_Plantilla."'";
					$Respuesta=mysqli_query($link, $Consulta);
				    while ($Fila=mysqli_fetch_array($Respuesta))
					{
					    $rut_eli = $Fila["rut_funcionario"];
						$num_eli = $Fila["cod_plantilla"];
                      
						$Eliminar = "delete from cal_web.plantillas where rut_funcionario='$rut_eli' and cod_plantilla='$num_eli'";
						mysqli_query($link, $Eliminar);
					}


				}
					
				header ("location:cal_con_plantilla.php?Mostrar=J&producto=".$producto."&sproducto=".$sproducto);
				break;	
			
			/*for ($i=0;$i<=strlen($elimina_pla);$i++)
			{
				if (substr($elimina_pla,$i,2)=="//")
				{
					$Pla = substr($elimina_pla,0,$i);
					$Eliminar = "delete from cal_web.leyes_por_plantillas where rut_funcionario='0' and cod_plantilla=".$Cod_Plantilla." and cod_leyes='".$Ley."'";
					mysqli_query($link, $Eliminar);
					$Leyes=substr($Leyes,$i+2);
					$i=0;
				}
			}
			$Consulta = "select * from cal_web.leyes_por_plantillas where rut_funcionario='0' and cod_plantilla=".$Cod_Plantilla;
			$Respuesta=mysqli_query($link, $Consulta);
			if (!$Fila=mysqli_fetch_array($Respuesta))
			{
				$Eliminar = "delete from cal_web.plantillas where rut_funcionario='0' and cod_plantilla=".$Cod_Plantilla;
				mysqli_query($link, $Eliminar);
				$TxtNombrePlantilla="";
			}
			header ("location:cal_quimico_plantilla.php?Productos=".$CmbProductos."&SubProductos=".$CmbSubProducto."&Plantilla=".$Cod_Plantilla."&NombrePlantilla=".$TxtNombrePlantilla);		
			break;	
			
		**************/	
			
		case "L":
			header("location:cal_quimico_plantilla.php");
			break;	
	}
?>
<html>
<head>
<title></title>
</head>
<body>
</body>
</html>
