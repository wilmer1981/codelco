<?php 	
	include("../principal/conectar_sec_web.php");
	$FechaEnvio = date("Y-m-d");
	switch ($Proceso)
	{
		case "G":
			$Datos=explode('//',$ValoresAux);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~~',$Valor);
				$corr_enm=$Datos2[0];
				$cod_bulto=$Datos2[1];				
				$num_bulto=$Datos2[2];
				$fecha_embarque=$Datos2[3];
				$fecha_programacion=$Datos2[4];
				$bulto_peso=$Datos2[5];
				$bulto_paquetes=$Datos2[6];
				$cod_marca=$Datos2[7];
				$cod_producto=$Datos2[8];
				$cod_subproducto=$Datos2[9];
				$cod_cliente=$Datos2[10];
				$insertar="INSERT INTO sec_web.embarque_ventana ";
				$insertar.=" (num_envio,corr_enm,cod_bulto,num_bulto,fecha_embarque,fecha_programacion, ";
				$insertar.=" bulto_paquetes,bulto_peso,cod_marca,cod_producto,cod_subproducto,cod_cliente ";
				$insertar.=" ,tipo_enm_code,cod_puerto,cod_nave,tipo_embarque,fecha_envio) values ";
				$insertar.="('".$Envio."','".$corr_enm."','".$cod_bulto."','".$num_bulto."','".$fecha_embarque."', ";
				$insertar.=" '".$fecha_programacion."','".$bulto_paquetes."','".$bulto_peso."','".$cod_marca."','".$cod_producto."', ";
				$insertar.=" '".$cod_subproducto."','".$cod_cliente."','C','".$CodPuerto."','".$CodNave."','".$TipoEmbarque."','".$FechaEnvio."') ";
				mysqli_query($link, $insertar);
				$Actualizar="UPDATE sec_web.programa_codelco set estado2='C' where  ";
				$Actualizar.=" corr_codelco='".$Datos2[0]."'										";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmConfirmacion.action='sec_confirmacion_num_envio_codelco.php?NumPaqueteI01=".$NumPaqueteI01."&NumPaqueteF01=".$NumPaqueteF01."&Tipo=".$Tipo."&Ver=N';";
			echo "window.opener.document.FrmConfirmacion.submit();";
			echo "window.close();";
			echo "</script>";
			break;
			case "E":
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Datos2=explode('~',$Valor);
				$Eliminar="delete from sec_web.embarque_ventana where ";
				$Eliminar.=" num_envio='".$Datos2[0]."' and corr_enm='".$Datos2[1]."'					  ";
				mysqli_query($link, $Eliminar);
				$Consulta="select * from sec_web.relacion_transporte_inst_embarque ";
				$Consulta.=" where corr_enm='".$Datos[1]."'		";
				$Respuesta=mysqli_query($link, $Consulta);
				if($Fila=mysqli_fetch_array($Respuesta));
				{
					$Eliminar="delete  from sec_web.relacion_transporte_inst_embarque ";
					$Eliminar.=" where corr_enm='".$Datos2[1]."' 			";
					mysqli_query($link, $Eliminar);
				}
				$Actualizar="UPDATE sec_web.programa_codelco set estado2='T' where  ";
				$Actualizar.="  corr_codelco='".$Datos2[1]."'										";
				mysqli_query($link, $Actualizar);
			}
			header("location:sec_confirmacion_num_envio_codelco.php?Tipo=".$Tipo);	
			break;
			
	}
?>
