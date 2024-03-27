<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
		$Consulta="select * from pcip_eec_disponibilidades where cod_sistema='".$CmbSistema."' and tipo_disponibilidad='R' and cod_equipo='".$CmbEquipos."' and ano='".$Ano."' and mes='".$Mes."'";		
		$Resp = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		if(!$Fila=mysql_fetch_array($Resp))
		{
			$Datos=explode('~~',$Valores);
			$Insertar="insert into pcip_eec_disponibilidades (cod_sistema,cod_equipo,tipo_disponibilidad,ano,mes,valor,valor_real,observacion) values ";
			$Insertar.="('".$CmbSistema."','".$CmbEquipos."','R','".$Ano."','".$Mes."','".str_replace(',','.',$TxtValorDisp)."','".str_replace(',','.',$TxtValorReal)."','".$TxtObs."')";
			//echo $Insertar."<br>";
			mysql_query($Insertar);
			$Mensaje=1;
			$Cod=$CmbSistema."~".$CmbEquipos."~".$Ano."~".$Mes;
		}	
		$Mensaje=2;
		$Cod=$CmbSistema."~".$CmbEquipos."~".$Ano."~".$Mes;
		header('location:pcip_mantenedor_disponibilidad_real_proceso.php?Opcion=M&Codigos='.$Cod.'&Mensaje=1&Mensaje=2');
	break;
	case "M":
		$Cod=explode('~',$Codigos);
		$Datos=explode('~~',$Valores);
		$Actualizar="UPDATE pcip_eec_disponibilidades set valor='".str_replace(',','.',$TxtValorDisp)."',valor_real='".str_replace(',','.',$TxtValorReal)."',observacion='".$TxtObs."' where tipo_disponibilidad='R' and cod_sistema = '".$Cod[0]."' and cod_equipo='".$Cod[1]."' and ano='".$Cod[2]."' and mes='".$Cod[3]."'";
		//echo $Actualizar."<br>";
		mysql_query($Actualizar);
		$Mensaje=3;
		header('location:pcip_mantenedor_disponibilidad_real_proceso.php?Opcion=M&Codigos='.$Codigos.'&Mensaje=3');
	break;
	case "E":
		$Mensaje='1';
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
			$Cod=explode('~',$Codigo);
			$Eliminar="delete from pcip_eec_disponibilidades where tipo_disponibilidad='R' and cod_sistema = '".$Cod[0]."' and cod_equipo='".$Cod[1]."' and ano='".$Cod[2]."' and mes='".$Cod[3]."'";
			mysql_query($Eliminar);
		}
		header("location:pcip_mantenedor_disponibilidad_real.php?Mensaje=".$Mensaje."&Buscar=S&Ano=".date('Y'));
	break;
}

?>