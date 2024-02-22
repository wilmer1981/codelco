<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
		$Sumi=explode('~',DatosSumistros($CmbSuministro));
		$CodUnid=$Sumi[2];
		$Datos=explode('~~',$Valores);
		$Mes=1;
		while(list($c,$v)=each($Datos))
		{
			if($v=='')
				$v=0;
			$Insertar="insert into pcip_eec_suministros_detalle (cod_suministro,ano,mes,cod_cc,valor,tipo,cod_unidad) values ";
			$Insertar.="('".$CmbSuministro."','".$Ano."','".$Mes."','','".str_replace(',','.',$v)."','V','".$CodUnid."')";
			//echo $Insertar."<br>";
			mysql_query($Insertar);
			$Mes++;
		}
		$Cod=$CmbGrupoSuministro."~".$CmbSuministro."~".$Ano;
		header('location:pcip_mantenedor_precios_proyectado_suministro_proceso.php?Opcion=M&Codigos='.$Cod);
	break;
	case "M":
		$Cod=explode('~',$Codigos);
		$Sumi=explode('~',DatosSumistros($Cod[1]));
		$CodUnid=$Sumi[2];
		$Datos=explode('~~',$Valores);
		$Mes=1;
		while(list($c,$v)=each($Datos))
		{
			if($v=='')
				$v=0;
			$Consulta="select * from pcip_eec_suministros_detalle where cod_suministro='".$Cod[1]."' and  ano='".$Cod[2]."' and mes='".$Mes."' and tipo='V'";	
			$RespMes=mysql_query($Consulta);
			if($FilaMes=mysql_fetch_array($RespMes))
			{
				$Actualizar="UPDATE pcip_eec_suministros_detalle set valor='".str_replace(',','.',$v)."' where cod_suministro='".$Cod[1]."' and  ano='".$Cod[2]."' and mes='".$Mes."' and tipo='V'";	
				//echo $Actualizar."<br>";
				mysql_query($Actualizar);
			}
			else
			{
				
				$Insertar="insert into pcip_eec_suministros_detalle (cod_suministro,ano,mes,cod_cc,valor,cod_unidad,tipo) values ";
				$Insertar.="('".$Cod[1]."','".$Cod[2]."','".$Mes."','','".str_replace(',','.',$v)."','".$Cod[4]."','V')";
				//echo $Insertar."<br>";
				mysql_query($Insertar);
			}
			$Mes++;
		}
		header('location:pcip_mantenedor_precios_proyectado_suministro_proceso.php?Opcion=M&Codigos='.$Codigos);
	break;
	case "E":
		$Mensaje='1';
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
			$Cod=explode('~',$Codigo);
			$Eliminar="delete from pcip_eec_suministros_detalle where cod_suministro='".$Cod[1]."' and  ano='".$Cod[2]."' and tipo='V'";	
			mysql_query($Eliminar);
		}
		header("location:pcip_mantenedor_precios_proyectado_suministro.php?Mensaje=".$Mensaje."&Buscar=S&Ano=".$Cod[2]."&CmbSuministro=".$Cod[1]."&CmbGrupoSuministro=".$Cod[0]);
	break;
}

?>