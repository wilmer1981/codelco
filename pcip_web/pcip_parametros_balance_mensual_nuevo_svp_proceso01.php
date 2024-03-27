<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
	    $Consulta = "select * from pcip_svp_balance_mensual where cod_producto='".$CmbProducto."' and cod_negocio='".$CmbNegocio."' and orden='".$CmbOrdenProd."'";			
		$Resp=mysqli_query($link, $Consulta);
		if(!$Fila=mysql_fetch_array($Resp))
		{			
			if($CmbProducto!=4)
				$CmbSubProducto=0;
			$Insertar="insert into pcip_svp_balance_mensual (cod_producto,cod_subproducto,cod_negocio,cod_titulo,orden) values ";
			$Insertar.="('".$CmbProducto."','".$CmbSubProducto."','".$CmbNegocio."','".$CmbTitulo."','".$CmbOrdenProd."')";
			//echo $Insertar."<br>";
			mysql_query($Insertar);
			$Mensaje="Balance Ingresado Exitosamente";
			$Cod=$CmbProducto."~".$CmbNegocio."~".$CmbOrdenProd;
		}
		else
			$Mensaje="Registro Existente";
		$Cod=$CmbProducto."~".$CmbNegocio."~".$CmbOrdenProd;
		header('location:pcip_parametros_balance_mensual_nuevo_svp_proceso.php?Opcion=M&Codigos='.$Cod.'&Mensaje='.$Mensaje);
	break;
	case "M":
		$Cod=explode('~',$Codigos);
		if($CmbProducto!=4)
			$CmbSubProducto=0;
		$Actualizar="UPDATE pcip_svp_balance_mensual set cod_subproducto='".$CmbSubProducto."',cod_titulo='".$CmbTitulo."',orden='".$CmbOrdenProd."'";
		$Actualizar.=" where cod_producto = '".$Cod[0]."' and cod_negocio='".$Cod[1]."' and orden='".$Cod[2]."'";
		//echo $Actualizar."<br>";
		mysql_query($Actualizar);
		$Mensaje="Balance Modificado Exitosamente";
		$Codigos=$Cod[0]."~".$Cod[1]."~".$CmbOrdenProd;
		header('location:pcip_parametros_balance_mensual_nuevo_svp_proceso.php?Opcion=M&Codigos='.$Codigos.'&Mensaje='.$Mensaje);
	break;
	case "E":
		
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
			$Cod=explode('~',$Codigo);
			$Eliminar="delete from pcip_svp_balance_mensual where cod_producto = '".$Cod[0]."' and cod_negocio='".$Cod[1]."' and orden='".$Cod[2]."'";
			//echo "eliminar:  ".$Eliminar."<BR>";
			mysql_query($Eliminar);
			$Mensaje='Registro Eliminado Exitosamente';
		}
		header("location:pcip_parametros_balance_mensual_nuevo_svp.php?Mensaje=".$Mensaje."&Buscar=S");
	break;
	case "GI"://GRABAR TITULO
		$Inserta="insert into proyecto_modernizacion.sub_clase (cod_clase,cod_subclase,nombre_subclase,valor_subclase1,valor_subclase2,valor_subclase3,valor_subclase4,valor_subclase5,valor_subclase6,valor_subclase7)";
		$Inserta.=" values('31057','".$TxtCodigo."','".strtoupper($TxtNuevo)."','".$CmbNegocio."','0','0','0','0','0','0')";
		mysql_query($Inserta);
		//echo $Inserta;
		header("location:pcip_parametros_balance_mensual_nuevo_svp_titulo.php?Opc=GI&CmbNegocio=".$CmbNegocio);			
		break;
		
	case "MI"://MODIFICAR TITULO
		$Actualizar="UPDATE proyecto_modernizacion.sub_clase set nombre_subclase = '".strtoupper($TxtNuevo)."',valor_subclase1='".$CmbNegocio."'";
		$Actualizar.=" where cod_clase='31057' and cod_subclase='".$TxtCodigo."'" ;	
		//echo $Actualizar;
		mysql_query($Actualizar);
		header('location:pcip_parametros_balance_mensual_nuevo_svp_titulo.php?Opc=GI&CmbNegocio='.$CmbNegocio);	
		break;

	case "EI"://ELIMINAR TITULO
		$Eliminar="delete from proyecto_modernizacion.sub_clase where cod_clase='31057' and cod_subclase='".$Cod."'";
		mysql_query($Eliminar);
		//echo $Eliminar;
		header("location:pcip_parametros_balance_mensual_nuevo_svp_titulo.php?Opc=GI&CmbNegocio=".$CmbNegocio);
		break;			
	
}

?>