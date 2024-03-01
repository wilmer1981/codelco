<?php
	include("../principal/conectar_principal.php");
	$EncontroRelacion=false;

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Buscar  = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$CheckRut = isset($_REQUEST["CheckRut"])?$_REQUEST["CheckRut"]:"N";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Mrut     = isset($_REQUEST["Mrut"])?$_REQUEST["Mrut"]:"";
	$TxtRut     = isset($_REQUEST["TxtRut"])?$_REQUEST["TxtRut"]:"";

	$TxtPatente   = isset($_REQUEST["TxtPatente"])?$_REQUEST["TxtPatente"]:"";
	$TxtNombre    = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$TxtMarca     = isset($_REQUEST["TxtMarca"])?$_REQUEST["TxtMarca"]:"";
	$TxtAno       = isset($_REQUEST["TxtAno"])?$_REQUEST["TxtAno"]:"";
	$TxtPeso      = isset($_REQUEST["TxtPeso"])?$_REQUEST["TxtPeso"]:"";
	$TxtCapacidad = isset($_REQUEST["TxtCapacidad"])?$_REQUEST["TxtCapacidad"]:"";
	$TxtAcoplado  = isset($_REQUEST["TxtAcoplado"])?$_REQUEST["TxtAcoplado"]:"";
	$TxtSW        = isset($_REQUEST["TxtSW"])?$_REQUEST["TxtSW"]:"";	
	$TxtGiro     = isset($_REQUEST["TxtGiro"])?$_REQUEST["TxtGiro"]:"";

	//if($Proceso=="NP" || $Proceso=="MP" || $Proceso=="EP"  ){
	$TxtRutPersona = isset($_REQUEST["TxtRutPersona"])?$_REQUEST["TxtRutPersona"]:"";
	$TxtRutTrans = isset($_REQUEST["TxtRutTrans"])?$_REQUEST["TxtRutTrans"]:"";
	$TxtSWP = isset($_REQUEST["TxtSWP"])?$_REQUEST["TxtSWP"]:"";
	$TxtNombrePers = isset($_REQUEST["TxtNombrePers"])?$_REQUEST["TxtNombrePers"]:"";
	$TxtCodCalJuri = isset($_REQUEST["TxtCodCalJuri"])?$_REQUEST["TxtCodCalJuri"]:"";
	$TxtCodRegion = isset($_REQUEST["TxtCodRegion"])?$_REQUEST["TxtCodRegion"]:"";
	$TxtCiudad = isset($_REQUEST["TxtCiudad"])?$_REQUEST["TxtCiudad"]:"";
	$TxtDomicilio = isset($_REQUEST["TxtDomicilio"])?$_REQUEST["TxtDomicilio"]:"";
	$TxtFono1 = isset($_REQUEST["TxtFono1"])?$_REQUEST["TxtFono1"]:"";
	$TxtFono2 = isset($_REQUEST["TxtFono2"])?$_REQUEST["TxtFono2"]:"";
	$TxtFax = isset($_REQUEST["TxtFax"])?$_REQUEST["TxtFax"]:"";
	//}
		

	$Existe="N";

	switch ($Proceso)
	{
		case "IT"://NUEVo
			 if($Buscar == "S" )
			 {
			
			 //	$TxtRut_=substr($TxtRut,1,-2)
				$Consulta="Select * from sec_web.transporte where rut_transportista= '".$TxtRut."' and patente_transporte='".$TxtPatente."'and acoplado_camion= '".$TxtAcoplado."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if(!$Fila=mysqli_fetch_array($Respuesta))
				{
					$Insertar="insert into sec_web.transporte () values (";
					$Insertar.="'$TxtRut','$TxtPatente','$TxtNombre','$TxtMarca','$TxtAno','$TxtPeso','$TxtCapacidad','$TxtAcoplado','$TxtSW','$TxtGiro')";
					mysqli_query($link, $Insertar);
					$Msj="Registro ingresado existosamente.";
				}
				else
					$Existe="S";
					
			 }
			break;
		case "MT"://MODIFICA TRANSPORTE 
			$Modificar="UPDATE sec_web.transporte set patente_transporte='".$TxtPatente."',nombre_transportista='".$TxtNombre."',marca_modelo_transporte='".$TxtMarca."',";
			$Modificar.="ano_transporte='".$TxtAno."', peso_tara_transporte='".$TxtPeso."',capacidad_transporte='".$TxtCapacidad."',acoplado_camion='".$TxtAcoplado."',sw='".$TxtSW."', giro_transportista='".$TxtGiro."'";
			$Modificar.="where rut_transportista='".$TxtRut."' and patente_transporte='".$TxtPatente."' and acoplado_camion='".$TxtAcoplado."'";
			mysqli_query($link, $Modificar);
				echo $Modificar."<br>";
				
			$Msj="Registro modificado existosamente.";
			break;
		case "NP"://NUEVA PERSONA
				$Consulta="Select * from sec_web.transporte_persona where rut_chofer= '".$TxtRutPersona."' and patente_camion= '".$TxtPatente."' and rut_transportista= '".$TxtRutTrans."'";
				//echo $Consulta;
				$Respuesta=mysqli_query($link, $Consulta);
				if(!$Fila=mysqli_fetch_array($Respuesta))
				{
					$Insertar="insert into sec_web.transporte_persona () values (";
					$Insertar.="'$TxtPatente','$TxtRutPersona','$TxtRutTrans ','$TxtSWP')";
					mysqli_query($link, $Insertar);
					$Insertar1="insert into sec_web.persona () values (";
					$Insertar1.="'$TxtRutPersona','$TxtNombrePers','$TxtCodCalJuri ','$TxtCodRegion','$TxtCiudad','$TxtDomicilio','$TxtFono1','$TxtFono2','$TxtFax','$TxtSWP')";
					mysqli_query($link, $Insertar1);
					$Msj="Registro ingresado existosamente.";
				}
				else{
					$Existe="S";
				}
						
			break;
		case "MP"://MODIFICA PERSONA
		  	$Modificar="UPDATE sec_web.persona set rut_persona='$TxtRutPersona',nombre_persona='$TxtNombrePers',cod_cal_jurid='$TxtCodCalJuri',cod_region_persona='$TxtCodRegion',ciudad_persona='$TxtCiudad', ";
			$Modificar.="domic_persona='$TxtDomicilio',fono1_persona='$TxtFono1',fono2_persona='$TxtFono2',fax_persona='$TxtFax',sw='$TxtSWP'";
			$Modificar.=" where rut_persona='".$TxtRutPersona."' ";
			mysqli_query($link, $Modificar);
			$Msj="Registro modificado existosamente.";
				
			break;
		case "EP"://ELIMINAR PERSONA
		    $CodigoRut=$TxtRutPersona;
		    $Eliminar ="delete from sec_web.transporte_persona where rut_chofer= '".$CodigoRut."' and patente_camion= '".$TxtPatente."' and rut_transportista= '".$TxtRutTrans."' ";
			mysqli_query($link, $Eliminar);
			$Msj="Registro eliminado exitosamente.";
			$Eliminar1 ="delete from sec_web.persona where rut_persona= '".$CodigoRut."' ";
			mysqli_query($link, $Eliminar1);

			break;
		case "E"://ELIMINAR TRANSPORTE
			$EncontroRelacion=false;
			$Datos=explode('//',$Valores);
			foreach($Datos as $Clave => $Valores)
			{
				//$Consulta="select * from sec_web.transporte_persona where rut_transportista ='$Valor'";
				//echo $Consulta;
				//$Respuesta=mysqli_query($link, $Consulta);
				//if(!$Fila=mysqli_fetch_array($Respuesta))
				//{
					$Consulta ="select * from sec_web.transporte_persona where rut_transportista= '".$Valores."' ";
					$Resp=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Resp))
					{
						$Eliminar1 ="delete from sec_web.persona where rut_persona= '".$Fila["rut_chofer"]."' ";
						//echo $Eliminar1."<br>";
						mysqli_query($link, $Eliminar1);
						$Msj="Registro eliminado exitosamente.";					
					}	
					$Eliminar ="delete from sec_web.transporte_persona where rut_transportista= '".$Valores."'";
					mysqli_query($link, $Eliminar);
					$Msj="Registro eliminado exitosamente.";
					//echo $Eliminar."<br>";
					$Eliminar ="delete from sec_web.transporte where rut_transportista='".$Valores."'";
					mysqli_query($link, $Eliminar);
					$Msj="Registro eliminado exitosamente.";

					//echo $Eliminar."<br>";
				//}
				//else
				//{
				//	$EncontroRelacion=true;
				//}	
			}
			break;	
						
	}
	/////////////////////////termino case////////////////////////////////////
	
	if ($Proceso=="E")
	{
		header("location:ingreso_transporte_persona.php?BuscarNombre=S&TxtBuscar=".$TxtBuscar."&EncontroRelacion=".$EncontroRelacion);
	}
	else
	{
		if ($Proceso=="IT" || $Proceso=="MT" )
		{
			if ($Existe=="S")
				header("location:ingreso_Transporte_persona_proceso.php?Proceso=IT&Existe=S&Valores=".$Valores);
			else
			{
				echo "<script languaje='JavaScript'>";
				
				echo "window.opener.document.FrmIngTransporte.action='ingreso_transporte_persona.php?Msj=".$Msj."';";
				echo "window.opener.document.FrmIngTransporte.submit();";
				//echo "window.close();";
				echo "</script>";
			}
		}	
		else
		{
			 if ($Existe=="S")
			 {
				echo "alert('persona ya fue ingresada');";
			 }
			 else
			 {
					echo "<script languaje='JavaScript'>";
					echo "window.opener.document.FrmIngTransporte.action='ingreso_transporte_persona.php';";
					echo "window.opener.document.FrmIngTransporte.submit();";
					//echo "window.close();";
					echo "</script>";
			}
		}	
	}	
	
?>