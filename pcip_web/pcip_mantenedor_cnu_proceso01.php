<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
		$Datos=explode('~~',$Valores);
		$Mes=1;
		while(list($c,$v)=each($Datos))
		{
			if($v=='')
				$v=0;
			$Insertar="insert into pcip_ena_datos_enabal (ano,mes,cod_flujo,nom_flujo,peso,tipo) values ";
			$Insertar.="('".$Ano."','".$Mes."','24','CARGA NUEVA UTIL A FUNDICION','".str_replace(',','.',$v)."','P')";
			//echo $Insertar."<br>";
			mysql_query($Insertar);
			$Mes++;
		}
		$Cod=$Ano."~24~P";
		header('location:pcip_mantenedor_cnu_proceso.php?Opcion=M&Codigos='.$Cod);
	break;
	case "M":
		$Cod=explode('~',$Codigos);
		$Datos=explode('~~',$Valores);
		$Mes=1;
		while(list($c,$v)=each($Datos))
		{
			if($v=='')
				$v=0;
			$Consulta="select * from pcip_ena_datos_enabal where ano='".$Cod[0]."' and mes='".$Mes."' and tipo='".$Cod[2]."'";	
			$RespMes=mysqli_query($link, $Consulta);
			if($FilaMes=mysql_fetch_array($RespMes))
			{
				$Actualizar="UPDATE pcip_ena_datos_enabal set peso='".str_replace(',','.',$v)."' where ano='".$Cod[0]."' and cod_flujo='".$Cod[1]."' and mes='".$Mes."' and tipo='".$Cod[2]."'";	
				//echo $Actualizar."<br>";
				mysql_query($Actualizar);
			}
			else
			{
				
				$Insertar="insert into pcip_ena_datos_enabal (ano,mes,cod_flujo,nom_flujo,peso,tipo) values ";
				$Insertar.="('".$Cod[0]."','".$Mes."','".$Cod[1]."','CARGA NUEVA UTIL A FUNDICION','".str_replace(',','.',$v)."','".$Cod[2]."')";
				//echo $Insertar."<br>";
				mysql_query($Insertar);
			}
			$Mes++;
		}
		header('location:pcip_mantenedor_cnu_proceso.php?Opcion=M&Codigos='.$Codigos);
	break;
	case "E":
		$Mensaje='1';
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
			$Cod=explode('~',$Codigo);
			$Eliminar="delete from pcip_ena_datos_enabal where ano='".$Cod[0]."' and tipo='".$Cod[2]."'";	
			mysql_query($Eliminar);
		}
		header("location:pcip_mantenedor_cnu.php?Mensaje=".$Mensaje."&Buscar=S&Ano=".$Cod[0]);
	break;
}

?>