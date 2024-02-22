<html>
<head>
<!--------------------------------------- Estilos ----------------------------------------->
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>
<!--
.LINK{
	font:Arial, Helvetica, sans-serif;
	color:#FFFF00;
	text-align:center;
	text-decoration:none;
}

a:link{
	color:#FFFF00;
}	

a:hover{
	color:#FFFF00;
}

a:visited{
	color:#FFFF00;
}

a:active{
	color:#FFFFFF;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>CIA WEB</title>
</head>
<body bgcolor="#CCCCCC">
<table width="500" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td> <table width="470" border="0" class="TablaInterior" align="center">
          <tr> 
            
          <td class="ColorTabla01" align="center"><strong>ESTADO DE LA OPERACI&Oacute;N</strong></td>
          </tr>
          <tr><td>&nbsp;</td> </tr>
          <tr>
		  	<td align="center"><strong>Ingresando Datos ...</strong></td>
		  </tr>
		  <tr><td>&nbsp;</td></tr>
        </table></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
  </table>
<?php
//pagina para ingreso de datos generales
if(isset($op)==0)
{
	header('Location: info.php?op=21');
	exit;
}

include("../principal/conectar_principal.php");
include("funciones.php");

switch ($op)
{
	case 1:		//ingreso de equipos (excepto CMP ==> Computadores de Escritorio)
		$estado=4;	//disponible
		$nro_asoc=-1;	//nulo
		$var=explode(";",$tipo);
		$tipo=$var[0];
		//se obtiene el codigo para el equipo
		$codigo=genera_codigo($tipo,$link);
		//se ordena la fecha siguiendo el siguiente formato yyyy-mm-dd
		$fecha=explode("-",$fecha_compra);
		$fecha_compra=$fecha[2]."-".$fecha[1]."-".$fecha[0];
		$query="INSERT INTO hardware values('".$codigo."','".$cmbMarca."','".$cmbModelo."'";
		$query.=",'".$nro_serie."','".$fecha_compra."',".$p_garantia.",";
		$query.="'".$nro_factura."','".$nro_guia."','".$rut_proveedor."',";
		$query.=$estado.",".$nro_asoc.",'".$observaciones."','".$var[1]."','".$cod_activo_fijo."');";
		
		//se insertan los datos en la tabla cia_web.hardware
		$var=mysql_db_query("cia_web",$query,$link);
		break;
	case 2:		//ingreso de Computadores y sus perifericos
		$estado=4;	//disponible
		$nro_asoc=-1;	//nulo
		$var=explode(";",$tipo);
		$tipo=$var[0];
		
		//primero se ingresa la informacion del equipo
		$codigo=genera_codigo($tipo,$link);
		//se ordena la fecha siguiendo el siguiente formato yyyy-mm-dd
		$fecha=explode("-",$fecha_compra);
		$fecha_compra=$fecha[2]."-".$fecha[1]."-".$fecha[0];
		$query="INSERT INTO hardware values('".$codigo."','".$cmbMarca."','".$cmbModelo."'";
		$query.=",'".$nro_serie."','".$fecha_compra."',".$p_garantia.",";
		$query.="'".$nro_factura."','".$nro_guia."','".$rut_proveedor."',";
		$query.=$estado.",".$nro_asoc.",'".$observaciones."','EQUIPO','".$cod_activo_fijo."');";
		
		$var=mysql_db_query("cia_web",$query,$link);
		if(!$var)
			break;	
		//se ingresan los datos adicionales correspondientes al equipo
		$query="INSERT INTO detalle_equipos values('".$codigo."','".$procesador." ".$mhz."'";
		$query.=",".$ram.",".$disco_duro.",".$cant_seriales.",".$cant_paralelos.");";
		
		$var=mysql_db_query("cia_web",$query,$link);
		if(!$var)
			break;
		if($tipo=="CMP")
		{
			//ahora se ingresa la informacion de los perifericos
			//primero la informacion del monitor
			if($no_mon!="on")
			{
			$codigo_mon=genera_codigo("MON",$link);
			$query="INSERT INTO hardware values('".$codigo_mon."','".$mon_marca."','".$mon_modelo."'";
			$query.=",'".$mon_serie."','".$fecha_compra."',".$mon_garantia.",";
			$query.="'".$nro_factura."','".$nro_guia."','".$rut_proveedor."',";
			$query.=$estado.",".$nro_asoc.",'','PARTE','');";
			@mysql_db_query("cia_web",$query,$link);
			//ahora se asocian las 3 partes al equipo que se esta ingresando
			$query="INSERT INTO asoc_partes_equipos(cod_parte,fecha_inicio,fecha_termino,nro_asoc_eq_user,cod_equipo)";
			$query.=" values('".$codigo_mon."',CURRENT_DATE,NULL,0,'".$codigo."')";
			@mysql_db_query("cia_web",$query,$link);
			//se ingresan los nros de asociacion correspondientes en la tabla de hardware
			$new_nro_asoc=mysql_insert_id($link);
			$query="UPDATE hardware set nro_asociacion_activa=".$new_nro_asoc.",estado=1 where codigo='".$codigo_mon."';";
			@mysql_db_query("cia_web",$query,$link);
			}
			
			//ahora los datos del teclado
			if($no_kbd!="on")
			{
			$codigo_kbd=genera_codigo("KBD",$link);
			$query="INSERT INTO hardware values('".$codigo_kbd."','".$kbd_marca."','".$kbd_modelo."'";
			$query.=",'".$kbd_serie."','".$fecha_compra."',".$kbd_garantia.",";
			$query.="'".$nro_factura."','".$nro_guia."','".$rut_proveedor."',";
			$query.=$estado.",".$nro_asoc.",'','PARTE','');";
			@mysql_db_query("cia_web",$query,$link);
			$query="INSERT INTO asoc_partes_equipos(cod_parte,fecha_inicio,fecha_termino,nro_asoc_eq_user,cod_equipo)";
			$query.=" values('".$codigo_kbd."',CURRENT_DATE,NULL,0,'".$codigo."')";
			@mysql_db_query("cia_web",$query,$link);
			//se ingresan los nros de asociacion correspondientes en la tabla de hardware
			$new_nro_asoc=mysql_insert_id($link);
			$query="UPDATE hardware set nro_asociacion_activa=".$new_nro_asoc.",estado=1 where codigo='".$codigo_kbd."';";
			@mysql_db_query("cia_web",$query,$link);
			}
			
			//ahora los datos del mouse
			if($no_mou!="on")
			{
			$codigo_mou=genera_codigo("MOU",$link);
			$query="INSERT INTO hardware values('".$codigo_mou."','".$mou_marca."','".$mou_modelo."'";
			$query.=",'".$mou_serie."','".$fecha_compra."',".$mou_garantia.",";
			$query.="'".$nro_factura."','".$nro_guia."','".$rut_proveedor."',";
			$query.=$estado.",".$nro_asoc.",'','PARTE','');";
			@mysql_db_query("cia_web",$query,$link);
			$query="INSERT INTO asoc_partes_equipos(cod_parte,fecha_inicio,fecha_termino,nro_asoc_eq_user,cod_equipo)";	
			$query.=" values('".$codigo_mou."',CURRENT_DATE,NULL,0,'".$codigo."')";
			@mysql_db_query("cia_web",$query,$link);
			//se ingresan los nros de asociacion correspondientes en la tabla de hardware
			$new_nro_asoc=mysql_insert_id($link);
			$query="UPDATE hardware set nro_asociacion_activa=".$new_nro_asoc.",estado=1 where codigo='".$codigo_mou."';";
			@mysql_db_query("cia_web",$query,$link);
			}
		}
		$var=1;
		break;
	case 3:		//ingreso de proveedores
		//primero se construye el rut
		$rut_p=$rut."-".$verificador;
		
		$query="INSERT INTO proveedor values('".$rut_p."','".$r_social."','".$n_fantasia."',";
		$query.="'".$contacto_1."','".$contacto_2."','".$fono_1."','".$fono_2."','".$fax."');";
		
		$var=mysql_db_query("cia_web",$query,$link);
		break;
	case 4:		//ingreso de nuevos SW
		//se genera el nuevo codigo para el SW
		$codigo=genera_codigo("SWF",$link);
		//se ordena la fecha siguiendo el siguiente formato yyyy-mm-dd
		$fecha=explode("-",$fecha_compra);
		$fecha_compra=$fecha[2]."-".$fecha[1]."-".$fecha[0];
		//se escribe la consulta
		$query="INSERT INTO software values('".$codigo."','".$marca."','".$nombre."','".$version."',";
		$query.="'".$tipo."','".$fecha_compra."','".$nro_factura."','".$rut_proveedor."','".$descripcion."','".$nro_licencia."');";
		$var=mysql_db_query("cia_web",$query,$link);
		break;
	case 5:		//ingreso de reportes de fallas
		// consulto la tabla para sacar el numero de fallas del equipo
		//$dur== $durac && $duracion;
		//echo ($dur);
		$query= "SELECT COUNT(*) as contador from cia_web.historial_fallas where cod_equipo ='".$cod."';";
		$res_tmp=mysql_db_query("cia_web",$query,$link);
	    $r_tmp=mysql_fetch_array($res_tmp);
	    mysql_free_result($res_tmp);
		$nro_fall=$r_tmp["contador"];
		$nro_fall++;
		//echo ($nro_fall);
		//se preparan los datos para el ingreso
		$tipo_tarea=$opcion1." / ".$opcion2;
		$duracion=$duracion." ".$opcion_duracion;
		//se ingresan los datos
		$query="INSERT INTO cia_web.historial_fallas values('".$cod."','".$nro_fall."'";
		
		//echo($query);
		if($f_inicio=="on")
			$query.=",CURRENT_DATE";
		else
		{
			$fecha_inicio=explode("-",$fecha_inicio);
			$fecha_inicio=$fecha_inicio[2]."-".$fecha_inicio[1]."-".$fecha_inicio[0];
			$query.=",'".$fecha_inicio."'";
		}
		if($f_termino=="on")
			$query.=",CURRENT_DATE";
		else
			{
			$fecha_termino=explode("-",$fecha_termino);
			$fecha_termino=$fecha_termino[2]."-".$fecha_termino[1]."-".$fecha_termino[0];
			$query.=",'".$fecha_termino."'";
		}
		$query.=",'".$duracion."','".$tipo_tarea."','".$accion."','".$causa."','".$nro_asoc."','".$d_trabajo."','".$insumos."','".$tipo."');";
		//se ingresan los datos
		$var=mysql_db_query("cia_web",$query,$link);
		//echo ($query);
		//echo ($var);
		//echo($duracion."','"$tipo_tarea"','".$accion."','".$causa."','".$nro_asoc."','".$d_trabajo."','".$insumos."','".$tipo."'
		break;
}
echo '<script Language="Javascript">';
if($var)
	echo 'alert("Ingreso realizado con exito");';
else
	echo 'alert("Problemas al ingresar el nuevo Registro. Intentelo mas tarde.");';
if($op==5)
	echo 'window.close();';
else
	echo 'window.location.href="../principal/sistemas_usuario.php?CodSistema=18";';

echo '</script>';
mysql_close();
?>
</div>
</body>
</html>