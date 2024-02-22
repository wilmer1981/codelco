<?php
include("../principal/conectar_sec_web.php");
	switch ($Proceso)
	{
		case "Autorizar":
		$datos = explode("//",$Valores);
		reset($datos); 
		while (list($clave,$valor)=each($datos))//arreglo[0]:cod_paquete;arreglo[1]:num_paquete;arreglo[2]:Fecha_creacion_paquete
		{
			$Pregunta=$Pregunta." corr_enm='".$valor."' or";
		}
		$Pregunta=substr($Pregunta,0,strlen($Pregunta)-2);
		if ($TipoEmbarque!="T")
		{
			$Actualizar="UPDATE sec_web.embarque_ventana set rut_cliente='".$RutClienteO."' ";
			$Actualizar.=" ,cod_sub_cliente='*',cod_estiba='".$Receptor."' where  num_envio='".$Envio."' and 	";
			$Actualizar.=$Pregunta;
			//cho $Actualizar;
			mysqli_query($link, $Actualizar);
		}
		else
		{
			$Actualizar="UPDATE sec_web.embarque_ventana set rut_cliente='".$RutClienteO."' ";
			$Actualizar.=" ,cod_sub_cliente='".$CodSubClienteO."' where  num_envio='".$Envio."' and 	";
			$Actualizar.=$Pregunta;
			mysqli_query($link, $Actualizar);
		}
		header("location:sec_autorizacion_despacho.php?Mostrar=S&Envio=".$Envio);	
		break;
		case "Transporte":
			$IEAux=$ValoresIEAux;
			$IE = explode("//",$IEAux);
			reset($IE); 
			$Encontro=false;
			while (list($claveInstEmb,$InsEmb)=each($IE))
			{
				$Consulta="select * from sec_web.embarque_ventana where num_envio='".$Envio."' ";
				$Consulta.=" and corr_enm='".$InsEmb."'	and (not isnull(cod_sub_cliente)and cod_sub_cliente <>'')  ";
				//echo $Consulta."<br>";
				$Respuesta1=mysqli_query($link, $Consulta);
				if ($Fila1=mysqli_fetch_array($Respuesta1))	
				{
					$Encontro=true;
				
				}			
			}
			if ($Encontro==true)
			{
				$Mensaje="Este Envio esta autorizado no se puede modificar transportista	";
			}
			else
			{
				$Fecha = date("Y-m-d");
				$datosIE = explode("//",$ValoresIEAux);
				reset($datosIE); 
				while (list($claveIe,$valorIe)=each($datosIE))
				{
					$datos = explode("//",$Valores);
					reset($datos); 
					while (list($clave,$valor)=each($datos))//arreglo[0]:cod_paquete;arreglo[1]:num_paquete;arreglo[2]:Fecha_creacion_paquete
					{
						$Consulta="select * from sec_web.relacion_transporte_inst_embarque ";
						$Consulta.=" where corr_enm='".$datosIE."'	";
						$Respuesta=mysqli_query($link, $Consulta);
						if($Fila=mysqli_fetch_array($Respuesta))
						{
							$Actualizar=" upadate sec_web.relacion_transporte_inst_embarque ";
							$Actualizar.=" set rut_transportista='".$valor."' where corr_enm='".$valorIe."' ";
							mysqli_query($link, $Actualizar);
						}
						else
						{
							$insertar="INSERT INTO relacion_transporte_inst_embarque ";	
							$insertar.="(rut_transportista,corr_enm,fecha)  ";
							$insertar.= " values ('".$valor."','".$valorIe."','".$Fecha."')";
							mysqli_query($link, $insertar);
						}
					}
				}	
			}
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProceso.action='sec_autorizacion_despacho.php?Envio=".$Envio."&Mensaje=".$Mensaje."&Ciudad=".$Ciudad."&Direccion=".$Direccion."&RutCliente=".$Rut."&SubCliente=".$SubCliente."&Mostrar=S';";
			echo "window.opener.document.FrmProceso.submit();";
			echo "window.close();";
			echo "</script>";
		break;
		case "Cancelar":
			header("location:sec_autorizacion_despacho.php");	
		break;
	}
//	header("location:sec_autorizacion_despacho.php?Mostrar=S&Envio=".$Envio);	
?>

