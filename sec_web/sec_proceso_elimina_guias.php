<?php 	
	include("../principal/conectar_sec_web.php");
	if($clave=='codelco01')
	{
		$Consulta=" SELECT
		det_guia_despacho_emb.cod_paquete,
		det_guia_despacho_emb.num_paquete,
		det_guia_despacho_emb.num_guia,
		det_guia_despacho_emb.secuencia_guia,
		det_guia_despacho_emb.cod_existencia
		FROM
		det_guia_despacho_emb
		Inner Join guia_despacho_emb ON det_guia_despacho_emb.num_guia = guia_despacho_emb.num_guia
		WHERE
		guia_despacho_emb.corr_enm =  '13472' AND
		guia_despacho_emb.num_envio =  '1460' AND
		guia_despacho_emb.cod_bulto =  'M' AND
		guia_despacho_emb.num_bulto =  '7160' ";
		$Respuesta=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			$Eliminar="DELETE FROM det_guia_despacho_emb WHERE cod_existencia='".$Fila[cod_existencia]."' AND num_guia='".$Fila["num_guia"]."' AND secuencia_guia='".$Fila[secuencia_guia]."' and  cod_paquete ='".$Fila["cod_paquete"]."' and  num_paquete ='".$Fila["num_paquete"]."' ";
			mysqli_query($link, $Eliminar);	
			echo $Eliminar."<br>";
		}
		$Eliminar="DELETE FROM guia_despacho_emb WHERE cod_bulto = 'M' and num_bulto='7160' and corr_enm='13472' ";
		mysqli_query($link, $Eliminar);
		echo $Eliminar."<br>";
	}



?>
