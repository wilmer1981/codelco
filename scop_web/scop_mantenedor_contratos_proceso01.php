<? 
	include("../principal/conectar_scop_web.php");
	include("funciones/scop_funciones.php");
	$Encontro=false;
	$Rut=$CookieRut;
	$Fecha=date('Y-m-d H:i:s');
	switch($Opcion)
	{
		case "N":	// NUEVO CONTRATOS	
			$Consulta="select * from scop_contratos where cod_contrato = '".$TxtContrato."'";
			$Resp=mysqli_query($link, $Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{	
				if($CmbAcuerdoCu=='P')
				{
					$TipoCu=2;				    		
					$Acuerdo_Cu=str_replace(".","",$PFCU);
					$Acuerdo_Cu=str_replace(",",".",$Acuerdo_Cu);
				}
				else
				{
					$TipoCu=1;				    		
					$Acuerdo_Cu=$CmbAcuerdoCu;
				}
				if($CmbAcuerdoAg=='P')
				{
					$TipoAg=2;				    		
					$Acuerdo_Ag=str_replace(".","",$PFAG);
					$Acuerdo_Ag=str_replace(",",".",$Acuerdo_Ag);
				}
				else
				{
					$TipoAg=1;				    		
					$Acuerdo_Ag=$CmbAcuerdoAg;
				}
				if($CmbAcuerdoAu=='P')
				{
					$TipoAu=2;				    		
					$Acuerdo_Au=str_replace(".","",$PFAU);
					$Acuerdo_Au=str_replace(",",".",$Acuerdo_Au);
				}
				else
				{
					$TipoAu=1;				    		
					$Acuerdo_Au=$CmbAcuerdoAu;
				}
				$Inserta="INSERT INTO scop_contratos (cod_contrato,num_contrato,fecha_contrato,descrip_contrato,cod_tipo_contr,tipo_cu,acuerdo_cu,tipo_ag,acuerdo_ag,tipo_au,acuerdo_au,vigente)";
				$Inserta.=" values('".$TxtContrato."','".strtoupper($TxtNumContrato)."','".$TxtFechaContr."','".strtoupper(trim($TxtDescripcion))."','".$CmbTipoContrato."','".$TipoCu."','".$Acuerdo_Cu."','".$TipoAg."','".$Acuerdo_Ag."','".$TipoAu."','".$Acuerdo_Au."','".$CmbVig."')";
				mysql_query($Inserta);				
				$Mensaje="Registro Ingresado Exitosamente";	
				$Cod=$TxtContrato;
				$Ident=strtoupper($TxtNumContrato)."-".$CmbTipoContrato;
				//ENVIO PARA GUARDAR EN LA IDENTIFICACION EL NUM CONTRATO - EL TIPO DE CONTRATO
				CambioDeEstado($Rut,$Ident,$Fecha,$Ano,$Mes,1);
			}	
			else
			{
				$Mensaje="Este Registro Existe";
				$Cod=$TxtContrato;	
			}
			header('location:scop_mantenedor_contratos_proceso.php?Opc=M&Mensaje='.$Mensaje.'&Valores='.$Cod);			
		    break;		    
		case "M"://MODIFICAR CONTRATO
		    $Mensaje2=false;	
			if($CmbAcuerdoCu=='P')
			{
				$TipoCu=2;				    		
				$Acuerdo_Cu=str_replace(".","",$PFCU);
				$Acuerdo_Cu=str_replace(",",".",$Acuerdo_Cu);
			}
			else
			{
				$TipoCu=1;				    		
				$Acuerdo_Cu=$CmbAcuerdoCu;
			}
			if($CmbAcuerdoAg=='P')
			{
				$TipoAg=2;				    		
				$Acuerdo_Ag=str_replace(".","",$PFAG);
				$Acuerdo_Ag=str_replace(",",".",$Acuerdo_Ag);
			}
			else
			{
				$TipoAg=1;				    		
				$Acuerdo_Ag=$CmbAcuerdoAg;
			}
			if($CmbAcuerdoAu=='P')
			{
				$TipoAu=2;				    		
				$Acuerdo_Au=str_replace(".","",$PFAU);
				$Acuerdo_Au=str_replace(",",".",$Acuerdo_Au);
			}
			else
			{
				$TipoAu=1;				    		
				$Acuerdo_Au=$CmbAcuerdoAu;
			}
			$Actualizar="UPDATE scop_contratos set fecha_contrato='".$TxtFechaContr."', num_contrato='".strtoupper($TxtNumContrato)."', descrip_contrato='".strtoupper(trim($TxtDescripcion))."'";
			$Actualizar.=",cod_tipo_contr='".$CmbTipoContrato."', acuerdo_cu='".$Acuerdo_Cu."', acuerdo_ag='".$Acuerdo_Ag."', acuerdo_au='".$Acuerdo_Au."' , vigente='".$CmbVig."',tipo_cu='".$TipoCu."',tipo_ag='".$TipoAg."',tipo_au='".$TipoAu."'";
			$Actualizar.=" where cod_contrato='".$TxtContrato."'";	
			//echo $Actualizar."<br>";
			mysql_query($Actualizar);
			$Mensaje1="Registro Modificado Exitosamente";	
			header('location:scop_mantenedor_contratos_proceso.php?Opc=M&Valores='.$TxtContrato.'&Mensaje1='.$Mensaje1);	
            break;
			
		case "E":// ELIMINAR CONTRATO
			$Datos = explode("//",$Valor);
			foreach($Datos as $clave => $Codigo)
			{	
				$Consulta="select * from scop_contratos_flujos where cod_contrato = '".$Codigo."'";
				$Resp=mysqli_query($link, $Consulta);
				if(!$Fila=mysql_fetch_array($Resp))
				{					    							
					$Cadena=explode("~",$Codigo);			
					$Eliminar="delete from scop_contratos where cod_contrato='".$Codigo."'";
					//echo $Eliminar;
					mysql_query($Eliminar);
					$Mensaje="S";
				}
				else
				{
					$Mensaje="E";
				}	
			}	
			header("location:scop_mantenedor_contratos.php?Buscar=S&Mensaje=".$Mensaje."&CmbContrato=".$CmbContrato."&CmbTipoContrato=".$CmbTipoContrato."&CmbVig=".$CmbVig);
		    break;
		case "NF"://NUEVO FLUJO
			if($TipoDato==2)
				$Datos='F';
			else
				$Datos='E';	
			$Consulta="select * from scop_datos_enabal where cod_flujo = '".$TxtCodFlujo."' and ano='".$Ano."' and mes='".$Mes."' and tipo_mov='".$TipoDato."' and tipo_dato='".$Datos."' and origen='OTRO'";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{					    		
				$Inserta="INSERT INTO scop_datos_enabal (ano,mes,origen,tipo_mov,tipo_dato,cod_flujo,nom_flujo,peso,cobre,plata,oro,tipo)";
				$Inserta.=" values('".$Ano."','".$Mes."','OTRO','".$TipoDato."','".$Datos."','".trim($TxtCodFlujo)."','".$TxtDescripcion."','".$TxtPesoSeco."','".$TxtCu."','".$TxtAg."','".$TxtAu."','R')";
				//echo  $Inserta."<br>";
				mysql_query($Inserta);				
				$Mensaje="Flujo Ingresado Exitosamente";	
			}	
			else
				$Mensaje="Este Registro Existe";
			header('location:scop_mantenedor_contratos_otros_flujos.php?Opc=NF&Mensaje='.$Mensaje.'&Valores='.$Cod);			
		break;			
		case "MF"://MODIFICAR FLUJO
			if($TipoDato==2)
				$Datos2='F';
			else
				$Datos2='E';	
			$Datos=explode("~",$Cod);
			$Actualizar="UPDATE scop_datos_enabal set tipo_mov='".$TipoDato."', tipo_dato='".$Datos2."', ano='".$Ano."', mes='".$Mes."', peso='".$TxtPesoSeco."', cobre='".$TxtCu."', plata='".$TxtAg."', oro='".$TxtAu."', tipo='R'";
			$Actualizar.=" where ano='".$Datos[0]."' and mes='".$Datos[1]."' and origen='".$Datos[2]."' and tipo_mov='".$Datos[3]."' and tipo_dato='".$Datos[4]."' and cod_flujo='".$Datos[5]."' ";	
			mysql_query($Actualizar);
			$Mensaje1="Flujo Modificado Exitosamente";	
			header('location:scop_mantenedor_contratos_otros_flujos.php?Opc=NF&Mensaje1='.$Mensaje1);	
        break;
		case "EF"://ELIMINAR FLUJO
			    $Datos=explode("~",$Cod);			
				$Eliminar="delete from scop_datos_enabal where ano='".$Datos[0]."' and mes='".$Datos[1]."' and origen='".$Datos[2]."' and tipo_mov='".$Datos[3]."' and tipo_dato='".$Datos[4]."' and cod_flujo='".$Datos[5]."' ";
				mysql_query($Eliminar);
				//echo $Eliminar;
				$Mensaje2="Flujo Eliminado Exitosamente";	
				header('location:scop_mantenedor_contratos_otros_flujos.php?Opc=NF&Mensaje2='.$Mensaje2);	
		break;
		case "NRECEP":	// NUEVO RECEPCION
			$Consulta="select * from scop_contratos_flujos where cod_contrato = '".strtoupper($TxtContrato)."' and flujo='".$CmbFlujoRecep."' and tipo_flujo='".$Valor."' and tipo_inventario=2";
			$Resp=mysqli_query($link, $Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{					    		
				$Inserta="INSERT INTO scop_contratos_flujos (cod_contrato,flujo,tipo_flujo,tipo_inventario,signo)";
				$Inserta.=" values('".strtoupper(trim($TxtContrato))."','".$CmbFlujoRecep."','".$Valor."',2,'".$CmbSignoRec."')";
				//echo $Inserta."<br>";
				mysql_query($Inserta);				
				$MensajeFlujo="Flujo Ingresado Exitosamente";
				$Cod=$TxtContrato;	
			}
			else
			{
				$MensajeFlujo="Flujo Existente";
				$Cod=$TxtContrato;
			}
			header('location:scop_mantenedor_contratos_proceso.php?Opc=M&MensajeFlujo='.$MensajeFlujo.'&Valores='.$Cod.'&TabRec=true&CheckREC='.$CheckREC.'&R=S');	
		break;
		case "ERECEP":// ELIMINAR DATOS DE RECEPCION
				$Datos=explode("~",$Valores);				
				$Eliminar="delete from scop_contratos_flujos where cod_contrato='".$Datos[0]."' and flujo='".$Datos[1]."' and tipo_flujo='".$Datos[2]."' and tipo_inventario=2";
				//echo $Eliminar."<br>";
				mysql_query($Eliminar);
				$MensajeEli="Registro Eliminado Exitosamente";
				header('location:scop_mantenedor_contratos_proceso.php?Opc=M&MensajeEli='.$MensajeEli.'&Valores='.$Datos[0].'&TabRec=true');
		break;
		case "NBENE":	// NUEVO BENEFICIO/EMBARQUE
			$Consulta="select * from scop_contratos_flujos where cod_contrato = '".strtoupper($TxtContrato)."' and flujo='".$CmbFlujoBene."' and tipo_flujo='".$Valor."' and tipo_inventario=3";
			$Resp=mysqli_query($link, $Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{					    		
				$Inserta="INSERT INTO scop_contratos_flujos (cod_contrato,flujo,tipo_flujo,tipo_inventario,signo)";
				$Inserta.=" values('".strtoupper(trim($TxtContrato))."','".$CmbFlujoBene."','".$Valor."',3,'".$CmbSignoBene."')";
				//echo $Inserta."<br>";
				mysql_query($Inserta);				
				$MensajeFlujo="Flujo Ingresado Exitosamente";
				$Cod=$TxtContrato;	
			}
			else
			{
				$MensajeFlujo="Flujo Existente";
				$Cod=$TxtContrato;
			}
			header('location:scop_mantenedor_contratos_proceso.php?Opc=M&MensajeFlujo='.$MensajeFlujo.'&Valores='.$Cod.'&TabBen=true');	
		break;
		case "EBENE":// ELIMINAR DATOS DE RECEPCION
				$Datos=explode("~",$Valores);				
				$Eliminar="delete from scop_contratos_flujos where cod_contrato='".$Datos[0]."' and flujo='".$Datos[1]."' and tipo_flujo='".$Datos[2]."' and tipo_inventario=3";
				//echo $Eliminar."<br>";
				mysql_query($Eliminar);
				$MensajeEli="Registro Eliminado Exitosamente";
				header('location:scop_mantenedor_contratos_proceso.php?Opc=M&MensajeEli='.$MensajeEli.'&Valores='.$Datos[0].'&TabBen=true&CheckBEN='.$CheckBEN.'&R=S');
		break;
		case "NSKFIN":	// NUEVO STOCK FINAL
			$Consulta="select * from scop_contratos_flujos where cod_contrato = '".strtoupper($TxtContrato)."' and flujo='".$CmbFlujoFin."' and tipo_flujo='".$Valor."' and tipo_inventario in('1','4')";
			$Resp=mysqli_query($link, $Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{					    		
				$Inserta="INSERT INTO scop_contratos_flujos (cod_contrato,flujo,tipo_flujo,tipo_inventario,signo)";
				$Inserta.=" values('".strtoupper(trim($TxtContrato))."','".$CmbFlujoFin."','".$Valor."',4,'".$CmbSignoSF."')";
				//echo $Inserta."<br>";
				mysql_query($Inserta);		
				if($Valor!='OTRO')	
				{
					$Inserta="INSERT INTO scop_contratos_flujos (cod_contrato,flujo,tipo_flujo,tipo_inventario,signo)";
					$Inserta.=" values('".strtoupper(trim($TxtContrato))."','".$CmbFlujoFin."','".$Valor."',1,'".$CmbSignoSF."')";
					//echo $Inserta."<br>";
					mysql_query($Inserta);				
				}
				$MensajeFlujo="Flujo Ingresado Exitosamente";
				$Cod=$TxtContrato;	
			}
			else
			{
				$MensajeFlujo="Flujo Existente";
				$Cod=$TxtContrato;
			}
			header('location:scop_mantenedor_contratos_proceso.php?Opc=M&MensajeFlujo='.$MensajeFlujo.'&Valores='.$Cod.'&TabSF=true&CheckSF='.$CheckSF.'&R=S');	
		break;		
		case "ESKFIN":// ELIMINAR DATOS DE RECEPCION
				$Datos=explode("~",$Valores);				
				$Eliminar="delete from scop_contratos_flujos where cod_contrato='".$Datos[0]."' and flujo='".$Datos[1]."' and tipo_flujo='".$Datos[2]."' and tipo_inventario in('1','4')";
				//echo $Eliminar."<br>";
				mysql_query($Eliminar);
				$MensajeEli="Registro Eliminado Exitosamente";
				header('location:scop_mantenedor_contratos_proceso.php?Opc=M&MensajeEli='.$MensajeEli.'&Valores='.$Datos[0].'&TabSF=true');
		break;
	}
?>
