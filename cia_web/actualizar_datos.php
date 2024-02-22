<?php
//pagina ocupada para actualizacion de datos
include("../principal/conectar_principal.php");
switch($op)
{
	case 1:		//termino asociacion equipo-parte
		//se cambia el estado de la asociacion en la tabla asoc_partes_equipos y se ingresa fecha_termino
		$query="UPDATE asoc_partes_equipos set estado_asoc=0,fecha_termino=CURRENT_DATE where nro_asoc=".$nro_asoc.";";
		@mysql_db_query("cia_web",$query,$link);
		//se cambia el estado del la parte a disponible
		$query="UPDATE hardware set estado=4,nro_asociacion_activa=-1 where codigo='".$cod."';";
		@mysql_db_query("cia_web",$query,$link);
		//se recarga la pagina ver_equipo.php
		header('Location: ver_equipo.php?valor='.$valor);
		exit;
		break;
	case 2:		//actualizacion datos equipo
		//se obtiene el codigo del equipo
		$var=explode(";",$valor);
		$cod=$var[0];
		//se reordena la fecha de compra
		$var=explode("-",$fecha_compra);
		$fecha_compra=$var[2]."-".$var[1]."-".$var[0];
		//se ingresan los datos actualizados
		$query="UPDATE hardware set marca='".$marca."',modelo='".$modelo."',nro_serie='".$nro_serie;
		$query.="',fecha_compra='".$fecha_compra."',p_garantia=".$p_garantia.",nro_factura='".$nro_factura."'";
		$query.=",nro_guia='".$nro_guia."',rut_proveedor='".$proveedor."',";
		$query.="observaciones='".$observaciones."',cod_activo_fijo='".$cod_activo_fijo."' where codigo='".$cod."';";
		@mysql_db_query("cia_web",$query,$link);
		if($TipoParte=='EQUIPO')
		{
			$query="UPDATE detalle_equipos set procesador='".$procesador."',ram='".$ram."',disco_duro='".$disco_duro."' ";
			$query.="where cod_equipo='".$cod."';";
			@mysql_db_query("cia_web",$query,$link);
		}	
		//se recarga la pagina ver_equipo.php
		header('Location: ver_equipo.php?valor='.$valor);
		exit;
		break;
	case 3:	//dar de baja un equipo
		//primero se dan de baja los equipos asociados
		$query="select nro_asociacion_activa,tipo from hardware where codigo='".$cod."';";
		$result=mysql_db_query("cia_web",$query,$link);
		$resp=mysql_fetch_array($result);
		mysql_free_result($result);
		if($resp["nro_asociacion_activa"]!=-1)	//tiene asociaciones
		{
			if($resp["tipo"]=="PARTE")
			{
				//se cambia el estado de la asociacion a inactiva
				$query="UPDATE asoc_partes_equipos set estado_asoc=0 where nro_asoc=".$resp["nro_asociacion_activa"].";";
				@mysql_db_query("cia_web",$query,$link);
			}
			else{	//es un equipo
				//se cambia el estado de todas las partes a disponible(4)
				$query="UPDATE hardware set estado=4,nro_asociacion_activa=-1 where codigo IN ";
				$query.="(select cod_parte from asoc_partes_equipos where nro_asoc_eq_user=";
				$query.=$resp["nro_asociacion_activa"]." and estado_asoc=1);";
				@mysql_db_query("cia_web",$query,$link);
				//se terminan todos las asociaciones con las partes
				$query="UPDATE asoc_partes_equipos set estado_asoc=0 where nro_asoc_eq_user=".$resp["nro_asociacion_activa"].";";
				@mysql_db_query("cia_web",$query,$link);
				//se termina la asociacion con el usuario
				$query="UPDATE asoc_equipos_usuarios set estado_asoc=0 where nro_asoc=".$resp["nro_asociacion_activa"].";";
				@mysql_db_query("cia_web",$query,$link);
			}
		}
		//ahora se cambia el estado y el nro de asoc del equipo
		$query="UPDATE hardware set estado=".$opcion.",nro_asociacion_activa=-1 where codigo='".$cod."';";
		@mysql_db_query("cia_web",$query,$link);
		break;
	case 4:		//recuperar un equipo que esta en estado "Para Baja"
		//se obtiene el codigo del equipo
		$var=explode(";",$valor);
		$cod=$var[0];
		//se cambia su estado a disponible
		$query="UPDATE hardware set estado=4 where codigo='".$cod."';";
		@mysql_db_query("cia_web",$query,$link);
		//se recarga la pagina ver_equipo.php
		header('Location: ver_equipo.php?valor='.$valor);
		exit;
		break;
	case 5:	//creacion de asociacion equipo-parte
		//se recupera el nro_asociacion_activa del equipo
		$query="select nro_asociacion_activa as nro from hardware where codigo='".$codigo_equipo."';";
		$result=mysql_db_query("cia_web",$query,$link);
		$resp=mysql_fetch_array($result);
		//se inserta el nuevo registro en la tabla asoc_partes_equipos
		$query="insert into asoc_partes_equipos values(NULL,'".$codigo_parte."',CURRENT_DATE,NULL,".$resp["nro"];
		$query.=",'".$codigo_equipo."',1);";
		@mysql_db_query("cia_web",$query,$link);
		//se recupera el nro_asoc generado
		$nro_asoc=mysql_insert_id($link);
		//se actualiza la informacion del hardware con el nuevo nro_de_asociacion; tb se actualiza el estado
		$query="UPDATE hardware set estado=1, nro_asociacion_activa=".$nro_asoc." where codigo='".$codigo_parte."';";
		@mysql_db_query("cia_web",$query,$link);
		break;
	case 6: 	//creacion de asociacion equipo-software
		//se ingresa el nuevo registro en la tabla de asociacion de equipos - sw
		$query="insert into asoc_sw_equipo values('".$sw."','".$cod_equipo."',CURRENT_DATE);";
		@mysql_db_query("cia_web",$query,$link);		
		break;
	case 7:		//creacion de asociacion parte-equipo
		//se recupera el nro_asociacion_activa del equipo
		$query="select nro_asociacion_activa as nro from hardware where codigo='".$codigo_equipo."';";
		$result=mysql_db_query("cia_web",$query,$link);
		$resp=mysql_fetch_array($result);
		//se inserta el nuevo registro en la tabla asoc_partes_equipos
		$query="insert into asoc_partes_equipos values(NULL,'".$codigo_parte."',CURRENT_DATE,NULL,".$resp["nro"];
		$query.=",'".$codigo_equipo."',1);";
		@mysql_db_query("cia_web",$query,$link);
		//se recupera el nro_asoc generado
		$nro_asoc=mysql_insert_id($link);
		//se actualiza la informacion del hardware con el nuevo nro_de_asociacion; tb se actualiza el estado
		$query="UPDATE hardware set estado=1, nro_asociacion_activa=".$nro_asoc." where codigo='".$codigo_parte."';";
		@mysql_db_query("cia_web",$query,$link);
		break;
	case 8:		//cambio de ubicacion de un equipo
		//se recupera el nro_asociacion_activa del equipo
		$query="select * from asoc_equipos_usuarios where nro_asoc in (select nro_asociacion_activa";
		$query.=" from hardware where codigo='".$cod_equipo."');";
		$result=mysql_db_query("cia_web",$query,$link);
		$resp=mysql_fetch_array($result);
		mysql_free_result($result);
		//se termina la asociacion actual
		$query="UPDATE asoc_equipos_usuarios set fecha_termino=CURRENT_DATE,estado_asoc=0 where nro_asoc=".$resp["nro_asoc"].";";
		@mysql_db_query("cia_web",$query,$link);
		//se crea una nueva asociacion
		$query="insert into asoc_equipos_usuarios values(NULL,'".$resp["cod_equipo"]."','".$new_ubi;
		$query.="','".$resp["rut_usuario"]."',CURRENT_DATE,NULL,1)";
		@mysql_db_query("cia_web",$query,$link);
		//se recupera el nro de asociacion generado
		$new_nro_asoc=mysql_insert_id($link);
		//se asigna el nuevo nro de asoc al equipo
		$query="UPDATE hardware set nro_asociacion_activa=".$new_nro_asoc." where codigo='".$cod_equipo."';";
		@mysql_db_query("cia_web",$query,$link);
		//se actualiza la informacion de las partes asociadas
		$query="select cod_parte,nro_asoc from asoc_partes_equipos where cod_equipo='".$cod_equipo."' and estado_asoc=1;";
		$result=mysql_db_query("cia_web",$query,$link);
		while($resp=mysql_fetch_array($result))
		{
			//se termina la asociacion actual
			$query="UPDATE asoc_partes_equipos set estado_asoc=0,fecha_termino=CURRENT_DATE where nro_asoc=".$resp["nro_asoc"].";";
			@mysql_db_query("cia_web",$query,$link);
			//se crea el nuevo registro de asociacion equipo - parte
			$query="insert into asoc_partes_equipos values(NULL,'".$resp["cod_parte"]."',CURRENT_DATE,NULL,";
			$query.=$new_nro_asoc.",'".$cod_equipo."',1);";
			@mysql_db_query("cia_web",$query,$link);
			//se recupera el nro de asociacion generado
			$new_parte=mysql_insert_id($link);
			//se asigna el nuevo nro de asociacion a la parte
			$query="UPDATE hardware set nro_asociacion_activa=".$new_parte." where codigo='".$resp["cod_parte"]."';";
			@mysql_db_query("cia_web",$query,$link);
		}
		break;
	case 9:		//cambio de usuario
		//se recupera la ubicacion actual del equipo
		$query="select cc_ubicacion from asoc_equipos_usuarios where nro_asoc=".$nro_asoc.";";
		$result=mysql_db_query("cia_web",$query,$link);
		$resp=mysql_fetch_array($result);
		$cc_ubi=$resp["cc_ubicacion"];
		mysql_free_result($result);
		//se termina la actual asociacion
		$query="UPDATE asoc_equipos_usuarios set estado_asoc=0,fecha_termino=CURRENT_DATE where nro_asoc=".$nro_asoc.";";
		@mysql_db_query("cia_web",$query,$link);
		//se crea la nueva asociacion equipo - user
		$query="insert into asoc_equipos_usuarios values(NULL,'".$cod_equipo."','".$cc_ubi."',";
		$query.="'".$rut_user."',CURRENT_DATE,NULL,1);";
		@mysql_db_query("cia_web",$query,$link);
		//se recupera el nro de asociacion generado
		$new_nro_asoc=mysql_insert_id($link);
		//se ingresa el nuevo nro de asociacion al equipo
		$query="UPDATE hardware set nro_asociacion_activa=".$new_nro_asoc." where codigo='".$cod_equipo."';";
		@mysql_db_query("cia_web",$query,$link);
		//se actualiza la informacion de las partes
		//primero se recuperan todas las partes
		$query="select nro_asoc,cod_parte from asoc_partes_equipos where nro_asoc_eq_user=".$nro_asoc." and estado_asoc=1;";
		$result=mysql_db_query("cia_web",$query,$link);
		while($resp=mysql_fetch_array($result))
		{
			//se termina la asociacion
			$query="UPDATE asoc_partes_equipos set estado_asoc=0,fecha_termino=CURRENT_DATE where nro_asoc=".$resp["nro_asoc"].";";
			@mysql_db_query("cia_web",$query,$link);
			//se crea el nuevo registro de asociacion equipo - parte
			$query="insert into asoc_partes_equipos values(NULL,'".$resp["cod_parte"]."',CURRENT_DATE,NULL,";
			$query.=$new_nro_asoc.",'".$cod_equipo."',1);";
			@mysql_db_query("cia_web",$query,$link);
			//se recupera el nro de asociacion generado
			$new_parte=mysql_insert_id($link);
			//se asigna el nuevo nro de asociacion a la parte
			$query="UPDATE hardware set nro_asociacion_activa=".$new_parte." where codigo='".$resp["cod_parte"]."';";
			@mysql_db_query("cia_web",$query,$link);
		}
		break;
	case 10:	//termino de asociacion equipo-user
		//se termina la asociacion equipo - user
		$query="UPDATE asoc_equipos_usuarios set fecha_termino=CURRENT_DATE,estado_asoc=0 where nro_asoc=".$nro_asoc.";";
		@mysql_db_query("cia_web",$query,$link);
		//se actualiza la informacion del equipo
		$query="UPDATE hardware set estado=4, nro_asociacion_activa=-1 where codigo='".$cod_equipo."';";
		@mysql_db_query("cia_web",$query,$link);
		//se actualiza la informacion de las partes
		$query="select cod_parte,nro_asoc from asoc_partes_equipos where nro_asoc_eq_user=".$nro_asoc." and estado_asoc=1;";
		$result=mysql_db_query("cia_web",$query,$link);
		while($resp=mysql_fetch_array($result))
		{
			//se terminan las asociaciones equipo-parte
			$query="UPDATE asoc_partes_equipos set fecha_termino=CURRENT_DATE,estado_asoc=0 where nro_asoc=".$resp["nro_asoc"].";";
			@mysql_db_query("cia_web",$query,$link);
			//se crea el nuevo registro para la parte
			$query="insert into asoc_partes_equipos values(NULL,'".$resp["cod_parte"]."',CURRENT_DATE,NULL";
			$query.=",0,'".$cod_equipo."',1);";
			@mysql_db_query("cia_web",$query,$link);
			//se recupera el nro de asociacion generado
			$new_parte=mysql_insert_id($link);
			//se asigna el nuevo nro a la parte
			$query="UPDATE hardware set nro_asociacion_activa=".$new_parte." where codigo='".$resp["cod_parte"]."';";
			@mysql_db_query("cia_web",$query,$link);
		}
		break;
	case 11:		//asinar un usuario a un equipo
		//se crea la asociacion entre el equipo y el usuario
		$query="insert into asoc_equipos_usuarios values(NULL,'".$cod_equipo."','".$new_ubi."','".$rut_user ;
		$query.="',CURRENT_DATE,NULL,1);";
		@mysql_db_query("cia_web",$query,$link);
		//se recupera el nuevo nro de asociacion asoc_equipos_usuarios
		$new_nro_asoc=mysql_insert_id($link);
		//se asigna el nuevo nro al equipo y se cambia su estado a asignado
		$query="UPDATE hardware set estado=1,nro_asociacion_activa=".$new_nro_asoc." where codigo='".$cod_equipo."';";
		@mysql_db_query("cia_web",$query,$link);
		//se actualiza la informacion de las partes asociadas al equipo
		$query="select cod_parte,nro_asoc from asoc_partes_equipos where cod_equipo='".$cod_equipo."' and estado_asoc=1;";
		$result=mysql_db_query("cia_web",$query,$link);
		while($resp=mysql_fetch_array($result))
		{
			//se termina la asociacion actual
			$query="UPDATE asoc_partes_equipos set fecha_termino=CURRENT_DATE,nro_asoc_eq_user=".$new_nro_asoc." where nro_asoc=".$resp["nro_asoc"].";";
			@mysql_db_query("cia_web",$query,$link);
			echo $query;
			//se crea la nueva asociacion entre parte y equipo
			//$query="insert into asoc_partes_equipos values(NULL,'".$resp["cod_parte"]."',CURRENT_DATE,NULL,".$new_nro_asoc;
			//$query.=",'".$cod_equipo."',1);";
			//@mysql_db_query("cia_web",$query,$link);
			//echo $query;
			//se recupera el nro de asociacion generado
			//$nro_asoc=mysql_insert_id($link);
			//se actualiza la informacion de la parte
			//$query="UPDATE hardware set nro_asociacion_activa=".$nro_asoc." where codigo='".$resp["cod_parte"]."';";
			//@mysql_db_query("cia_web",$query,$link);
			//echo $query;
		}
		break;
	case 12:		//guardar cambios del proveedor
		//se ingresan los nuevos valores
		$query="UPDATE proveedor set razon_social='".$razon_social."',nombre_fantasia='".$nombre_fantasia."'";
		$query.=",contacto_1='".$contacto_1."',contacto_2='".$contacto_2."',fono_1='".$fono_1."',fono_2='".$fono_2."'";
		$query.=",fax='".$fax."' where rut='".$rut."';";
		@mysql_db_query("cia_web",$query,$link);
		break;
	case 13:		//guardar cambios del software
		//se ingresan los nuevos valores de los datos
		$query="UPDATE software set marca='".$marca."',nombre='".$nombre."',version_sw='".$version_sw;
		$query.="',tipo='".$tipo."',nro_factura='".$nro_factura."',rut_proveedor='".$rut_proveedor;
		$query.="',descripcion='".$descripcion."' where codigo='".$codigo."';";
		@mysql_db_query("cia_web",$query,$link);
		break;
	case 14:	//eliminacion de asociacion equipo-sw
		//se borra el registro de la asociacion
		$var=explode(";",$Cod_Sw);
		$cod_sw=$var[0];
		$cod_eq=$var[1];
		$fecha=$var[2];
		$query="delete from asoc_sw_equipo where cod_sw='".$cod_sw."' and cod_equipo='".$cod_eq;
		$query.="' and fecha='".$fecha."';";
		@mysql_db_query("cia_web",$query,$link);
		
		//se redirecciona a la pagina de sw asociados
		header('Location: ver_sw_asoc.php?cod_equipo='.$cod_equipo);
		exit;
		break;
}
?>
<html>
<body>
<?php
if(isset($foo))
{
	if($foo==1)
	{
		echo '<script language="JavaScript">
		opener.popup.location.reload();
		window.close();
		</script>';
	}else{
		echo '<script language="JavaScript">
		opener.location.reload();
		window.close();
		</script>';
	}
}
else{
	echo '<script language="JavaScript">
	opener.location.reload();
	window.close();
	</script>';
}
?>
</body>
</html>
