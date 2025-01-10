<?php
include("../principal/conectar_sec_web.php");

$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Envio   = isset($_REQUEST["Envio"])?$_REQUEST["Envio"]:"";
$Ciudad  = isset($_REQUEST["Ciudad"])?$_REQUEST["Ciudad"]:"";
$Direccion = isset($_REQUEST["Direccion"])?$_REQUEST["Direccion"]:"";
$Rut       = isset($_REQUEST["Rut"])?$_REQUEST["Rut"]:"";
$SubCliente= isset($_REQUEST["SubCliente"])?$_REQUEST["SubCliente"]:"";
$FechaEmb  = isset($_REQUEST["FechaEmb"])?$_REQUEST["FechaEmb"]:"";
$Valores   = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
$ValoresIEAux  = isset($_REQUEST["ValoresIEAux"])?$_REQUEST["ValoresIEAux"]:"";

$TipoEmbarque  = isset($_REQUEST["TipoEmbarque"])?$_REQUEST["TipoEmbarque"]:"";
$RutCliente  = isset($_REQUEST["RutCliente"])?$_REQUEST["RutCliente"]:"";
$RutClienteO  = isset($_REQUEST["RutClienteO"])?$_REQUEST["RutClienteO"]:"";
$Receptor     = isset($_REQUEST["Receptor"])?$_REQUEST["Receptor"]:"";
$CodSubCliente  = isset($_REQUEST["CodSubCliente"])?$_REQUEST["CodSubCliente"]:"";
$CodSubClienteO  = isset($_REQUEST["CodSubClienteO"])?$_REQUEST["CodSubClienteO"]:"";
$CodCliente  = isset($_REQUEST["CodCliente"])?$_REQUEST["CodCliente"]:"";
$Comuna  = isset($_REQUEST["Comuna"])?$_REQUEST["Comuna"]:"";
$CodPrestador = isset($_REQUEST["CodPrestador"])?$_REQUEST["CodPrestador"]:"";

$NombreCliente = isset($_REQUEST["NombreCliente"])?$_REQUEST["NombreCliente"]:"";
$Nombre    = isset($_REQUEST["Nombre"])?$_REQUEST["Nombre"]:"";
$Sigla     = isset($_REQUEST["Sigla"])?$_REQUEST["Sigla"]:"";
$CodPais   = isset($_REQUEST["CodPais"])?$_REQUEST["CodPais"]:"";
$Telefono1 = isset($_REQUEST["Telefono1"])?$_REQUEST["Telefono1"]:"";
$Telefono2 = isset($_REQUEST["Telefono2"])?$_REQUEST["Telefono2"]:"";
$Fax       = isset($_REQUEST["Fax"])?$_REQUEST["Fax"]:"";
$RutC      = isset($_REQUEST["RutC"])?$_REQUEST["RutC"]:"";
$TxtComuna = isset($_REQUEST["TxtComuna"])?$_REQUEST["TxtComuna"]:"";
$TxtCiudad = isset($_REQUEST["TxtCiudad"])?$_REQUEST["TxtCiudad"]:"";
$TxtDivSAP = isset($_REQUEST["TxtDivSAP"])?$_REQUEST["TxtDivSAP"]:"";
$TxtAlmSAP = isset($_REQUEST["TxtAlmSAP"])?$_REQUEST["TxtAlmSAP"]:"";
$Obs       = isset($_REQUEST["Obs"])?$_REQUEST["Obs"]:"";
$ValoresCheck = isset($_REQUEST["ValoresCheck"])?$_REQUEST["ValoresCheck"]:"";


	switch ($Proceso)
	{
		case "Autorizar":
		$datos = explode("//",$Valores);
		reset($datos); 
		foreach($datos as $clave => $valor)//arreglo[0]:cod_paquete;arreglo[1]:num_paquete;arreglo[2]:Fecha_creacion_paquete
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
		header("location:sec_autorizacion_despacho.php?Mostrar=S&Envio=".$Envio."&Mensaje2=S");	
		break;
		case "Transporte":
			/*$IEAux=$ValoresIEAux;
			$IE = explode("//",$IEAux);
			reset($IE); 
			$Encontro=false;
			while (list($claveInstEmb,$InsEmb)=each($IE))
			{
				$Consulta="SELECT * from sec_web.embarque_ventana where num_envio='".$Envio."' ";
				//$Consulta.=" and corr_enm='".$InsEmb."'	and (not isnull(cod_sub_cliente)and cod_sub_cliente <>'')  ";
				$Consulta.=" and corr_enm='".$InsEmb."'  ";
				$Respuesta1=mysqli_query($link, $Consulta);
				if ($Fila1=mysqli_fetch_array($Respuesta1))	
				{
					$Encontro=true;
				}
				else
				{
					$Encontro=false;
				}			
			}
			if ($Encontro==true)
			{
				//$Mensaje="Este Envio esta autorizado no se puede modificar transportista	";
			}
			else
			{*/
				$Fecha = date("Y-m-d");
				//echo "valor ieAux   ".$ValoresIEAux."<br>";
				//echo "valores:    ".$Valores."<br>";
				$datosIE = explode("//",$ValoresIEAux);
				reset($datosIE); 
				foreach($datosIE as $claveIe => $valorIe)
				{
					$datos = explode("//",$Valores);
					reset($datos); 
					foreach($datos as $clave => $valor)//arreglo[0]:cod_paquete;arreglo[1]:num_paquete;arreglo[2]:Fecha_creacion_paquete
					{
						$Consulta="SELECT * from sec_web.relacion_transporte_inst_embarque ";
						$Consulta.=" where corr_enm='".$valorIe."'	";
						$Respuesta=mysqli_query($link, $Consulta);
						if($Fila=mysqli_fetch_array($Respuesta))
						{
							$Actualizar="UPDATE sec_web.relacion_transporte_inst_embarque ";
							$Actualizar.=" set rut_transportista='".$valor."' where corr_enm='".$valorIe."' ";
							//echo $Actualizar."<br>";
							mysqli_query($link, $Actualizar);
							$Mensaje="Transportista Actualizado correctamente.";
						}
						else
						{
							$insertar="INSERT INTO relacion_transporte_inst_embarque ";	
							$insertar.="(rut_transportista,corr_enm,fecha)  ";
							$insertar.= " values ('".$valor."','".$valorIe."','".$Fecha."')";
							//echo $insertar."<br>";
							mysqli_query($link, $insertar);
							$Mensaje="Transportista insertado correctamente.";
						}
					}
				}	
			//}
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProceso.action='sec_autorizacion_despacho.php?Envio=".$Envio."&Mensaje=".$Mensaje."&Ciudad=".$Ciudad."&Direccion=".$Direccion."&RutCliente=".$Rut."&SubCliente=".$SubCliente."&Mostrar=S';";
			echo "window.opener.document.FrmProceso.submit();";
			echo "window.close();";
			echo "</script>";
		break;
		case "Cancelar":
			header("location:sec_autorizacion_despacho.php");	
		break;
		case "AgregarSubCliente":
			$Consulta="SELECT * from sec_web.nave where cod_nave=CEILING('".$CodCliente."')";
			$Respuesta0=mysqli_query($link, $Consulta);
			if(!$Fila0=mysqli_fetch_array($Respuesta0))
			{
				$insertar="INSERT INTO sec_web.nave  (cod_nave,nombre_nave,ventanas)";
				$insertar.="values('".intval($CodCliente)."','".$NombreCliente."','S')			";
				mysqli_query($link, $insertar);
				$Consulta="SELECT max(Id) as mayor	from sec_web.sub_cliente_vta	";
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2);
				$Mayor=$Fila2["mayor"]+1;
				$insertar="INSERT INTO sec_web.sub_cliente_vta (Id,cod_cliente,cod_sub_cliente, ";
				$insertar.="ciudad,comuna,direccion,rut_cliente)values ";
				$insertar.="('".$Mayor."','".$CodCliente."','".$CodSubCliente."','".$Ciudad."' ";
				$insertar.=" ,'".$Comuna."','".$Direccion."','".$RutCliente."')		";
				mysqli_query($link, $insertar);
			}
			else
			{			
				$Consulta="SELECT * from sec_web.sub_cliente_vta where cod_cliente=CEILING('".$CodCliente."')";
				$Consulta.=" and cod_sub_cliente=CEILING('".$CodSubCliente."')		";
				$Respuesta1=mysqli_query($link, $Consulta);
				if($Fila1=mysqli_fetch_array($Respuesta1))
				{
					$Actualizar="UPDATE sec_web.sub_cliente_vta set ciudad='".$Ciudad."', ";
					$Actualizar.="comuna='".$Comuna."',direccion='".$Direccion."',rut_cliente='".$RutCliente."'	";
					$Actualizar.="where cod_cliente=CEILING('".$CodCliente."') and cod_sub_cliente=CEILING('".$CodSubCliente."')			"; 
					mysqli_query($link, $Actualizar);
				}
				else
				{	
					$Consulta="SELECT max(Id) as mayor	from sec_web.sub_cliente_vta	";
					$Respuesta2=mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Respuesta2);
					$Mayor=$Fila2["mayor"]+1;
					$insertar="INSERT INTO sec_web.sub_cliente_vta (Id,cod_cliente,cod_sub_cliente, ";
					$insertar.="ciudad,comuna,direccion,rut_cliente)values ";
					$insertar.="('".$Mayor."','".$CodCliente."','".$CodSubCliente."','".$Ciudad."' ";
					$insertar.=" ,'".$Comuna."','".$Direccion."','".$RutCliente."')		";
					mysqli_query($link, $insertar);
				}
			}
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmProceso.action='sec_autorizacion_despacho.php?Envio=".$Envio."&Mostrar=S';";
		echo "window.opener.document.FrmProceso.submit();";
		echo "window.close();";
		echo "</script>";
		break;
		case "AgregarReceptor":
		$Consulta="SELECT * from sec_web.prestador ";
		$Consulta.="where cod_prestador_servicio='".$CodPrestador."' and rut='".$Rut."'";
		$Respuesta=mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$Actualizar="UPDATE sec_web.prestador set ";
			$Actualizar.="nombre='".$NombreCliente."', ";
			$Actualizar.="sigla='".$Sigla."', ";
			$Actualizar.="direccion='".$Direccion."', ";
			$Actualizar.="cod_pais='".$CodPais."', ";
			$Actualizar.="telefono_1='".$Telefono1."', ";
			$Actualizar.="telefono_2='".$Telefono2."', ";
			$Actualizar.="fax='".$Fax."', ";
			$Actualizar.="comuna='".$TxtComuna."', ";
			$Actualizar.="ciudad='".$TxtCiudad."', ";
			$Actualizar.="division_sap='".$TxtDivSAP."', ";
			$Actualizar.="almacen_sap='".$TxtAlmSAP."', ";
			$Actualizar.="observacion='".$Obs."' ";
			$Actualizar.=" where rut='".$Rut."' and cod_prestador_servicio='".$CodPrestador."' ";
			mysqli_query($link, $Actualizar);
			
		}
		else
		{
			$Consulta="SELECT max(CEILING(cod_prestador_servicio)) as mayor from sec_web.prestador  ";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$CodPrestador=$Fila["mayor"]+1;
			$insertar="insert into sec_web.prestador ";
			$insertar.="(cod_prestador_servicio,rut,nombre,sigla,direccion,cod_pais,telefono_1,telefono_2,fax,observacion,ventanas,comuna,ciudad,division_sap,
			almacen_sap) values ";
			$insertar.="('".$CodPrestador."','".$Rut."','".$NombreCliente."','".$Sigla."','".$Direccion."','".$CodPais."',";
			$insertar.=" '".$Telefono1."','".$Telefono2."','".$Fax."','".$Obs."','S','".$TxtComuna."','".$TxtCiudad."','".$TxtDivSAP."','".$TxtAlmSAP."')	";
			mysqli_query($link, $insertar);
		}
		echo "<script languaje='JavaScript'>";
		if ($TipoEmbarque="T")
		{
			echo "window.opener.document.FrmProceso.action='sec_autorizacion_despacho.php?Envio=".$Envio."&RutCliente=".$RutC."&Mostrar=S';";
		}
		else
		{
			echo "window.opener.document.FrmProceso.action='sec_autorizacion_despacho.php?Envio=".$Envio."&RutCliente=".$RutC."&Mostrar=S&Ver=S';";		
		}
		echo "window.opener.document.FrmProceso.submit();";
		echo "window.close();";
		echo "</script>";
		break;
		case "ActualizaFecha":
			$Consulta="SELECT * from sec_web.embarque_ventana";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				$Actualizar="UPDATE sec_web.embarque_ventana ";
				$Actualizar.=" set fecha_envio='".$Fila["fecha_programacion"]."' where num_envio='".$Fila["num_envio"]."' and corr_enm='".$Fila["corr_enm"]."'";
				$Actualizar.=" and cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}	
		break;
		case "ModificarSubCliente":
		$Consulta="SELECT * from sec_web.embarque_ventana where ";
		$Consulta.=" num_envio='".$Envio."' and fecha_envio='".$FechaEnvio."'  and ((rut_cliente ='') or  (isnull(rut_cliente)))	";
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProceso.action='sec_autorizacion_despacho.php?Envio=".$Envio."&Direccion=".$Dir."&RutCliente=".$RutCliente."&Ciudad=".$Ciu."&SubCliente=".$SubCliente."&Mostrar=S';";
			echo "window.opener.document.FrmProceso.submit();";
			echo "window.close();";
			echo "</script>";
		}
		else
		{
			$Actualizar="UPDATE sec_web.embarque_ventana set rut_cliente='".$RutCliente."',cod_sub_cliente='".$SubCliente."'  where ";
			$Actualizar.="num_envio='".$Envio."' and fecha_envio='".$FechaEnvio."' ";
			mysqli_query($link, $Actualizar);
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProceso.action='sec_autorizacion_despacho.php?Envio=".$Envio."&Mostrar=S';";
			echo "window.opener.document.FrmProceso.submit();";
			echo "window.close();";
			echo "</script>";
		} 
		break;
		case "Lote":
			$Consulta="SELECT * from sec_web.paquete_catodo ";
			$Consulta.=" where cod_paquete='B' and num_paquete ";
			$Consulta.=" between '2047' and '2058' and fecha_creacion_paquete='2004-02-24'";  
			$Respuesta=mysqli_query($link, $Consulta);
			$cant=0;
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				$Actualizar="UPDATE sec_web.paquete_catodo cod_estado='c', sw='2'    ";
				$Actualizar.=" where cod_paquete='B' and num_paquete between '2047'	and '2058' ";
				$Actualizar.=" and fecha_creacion_paquete='2004-02-24' ";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
				$insertar="INSERT INTO sec_web.lote_catodo (cod_bulto,num_bulto,cod_paquete,num_paquete, ";
				$insertar.="fecha_creacion_lote,cod_marca,corr_enm,cod_estado,cod_cliente,sw,disponibilidad)values";
				$insertar.="('B','1749','".$Fila["cod_paquete"]."','".$Fila["num_paquete"]."','2004-02-24','01AZ','12333','c',";
				$insertar.="'LX091','2','T')			";
				mysqli_query($link, $insertar);
				//echo $insertar."<br>";
				$cant++;
			}
			echo $cant;
		break;
		case "EliminarTransportista":
			$datos = explode("//",$ValoresCheck);
			reset($datos); 
			foreach($datos as $clave => $valor)
			{
				$arreglo = explode("~~",$valor);
				$Eliminar="DELETE from sec_web.relacion_transporte_inst_embarque ";
				$Eliminar.=" where rut_transportista='".$arreglo[0]."' and corr_enm='".$arreglo[1]."'	";
				mysqli_query($link, $Eliminar);
				$ValoresIE=$arreglo[1];
			}
		header("location:sec_detalle_transportista.php?ValoresIE=".$ValoresIE);	
		break;
		case "EliminarRelacion":
		$datos = explode("//",$ValoresCheck);	
		reset($datos); 
		foreach($datos as $clave => $valor)
		{
			$Consulta="SELECT * from sec_web.embarque_ventana where corr_enm='".$valor."' ";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			if($Fila["despacho_paquetes"] > 0)
			{
				$I=$I.$Fila["corr_enm"].",";
				$Mensaje="No se puede quitar la relacion ya que la Instruccion ".$I." se esta  despachando";
			}
			else
			{
				$Eliminar="DELETE FROM sec_web.embarque_ventana where num_envio='".$Envio."' ";
				$Eliminar.=" and corr_enm='".$valor."' ";
				mysqli_query($link, $Eliminar);
				$Eliminar="DELETE FROM sec_web.transporte_inst_embarque where corr_enm='".$valor."' ";
				mysqli_query($link, $Eliminar);
				$Consulta="SELECT * from sec_web.programa_enami where corr_enm='".$valor."' ";
				$Respuesta1=mysqli_query($link, $Consulta);
				if($Fila1=mysqli_fetch_array($Respuesta1))
				{
					$Actualizar="UPDATE sec_web.programa_enami set estado2='T' where corr_enm='".$valor."' ";	
					mysqli_query($link, $Actualizar);
				}
				else
				{
					$Actualizar="UPDATE sec_web.programa_codelco set estado2='T' where corr_codelco='".$valor."' ";	
					mysqli_query($link, $Actualizar);
				}
			}
		}
		header("location:sec_autorizacion_despacho.php?Mostrar=S&Envio=".$Envio."&Mensaje=".$Mensaje);	
		break;
	}
?>

