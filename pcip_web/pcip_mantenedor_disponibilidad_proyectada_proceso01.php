<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
		$Consulta="select * from pcip_eec_disponibilidades where tipo_disponibilidad='P' and cod_sistema = '".$CmbSistema."' and cod_equipo='".$CmbEquipos."' and ano='".$Ano."'";
		//echo $Consulta;
		//echo "alert('hola');";
		$Resp=mysqli_query($link, $Consulta);
		if(!$Fila=mysql_fetch_array($Resp))
		{
			$Datos=explode('||',$Valores);
			$Mes=1;
			while(list($c,$v)=each($Datos))
			{
				if($v!='')
				{
					$Datos2=explode('~~',$v);
					if($Datos2[0]=='')
						$Datos2[0]=0;
					if($Datos2[1]=='')
						$Datos2[1]=0;
					if($Datos2[2]=='')
						$Datos2[2]=0;
					$Insertar="insert into pcip_eec_disponibilidades (cod_sistema,cod_equipo,tipo_disponibilidad,ano,mes,hrs_oper_d,hrs_mant_men,hrs_mant_may) values ";
					$Insertar.="('".$CmbSistema."','".$CmbEquipos."','P','".$Ano."','".$Mes."','".str_replace(',','.',$Datos2[0])."','".str_replace(',','.',$Datos2[1])."','".str_replace(',','.',$Datos2[2])."')";
					echo $Insertar."<br>";
					mysql_query($Insertar);
				}
				$Mes++;
			}
			$Mensaje='1';
		}
		else
			$Mensaje='2';
		$Cod=$CmbSistema."~".$CmbEquipos."~".$Ano;
		header('location:pcip_mantenedor_disponibilidad_proyectada_proceso.php?Opcion=M&Codigos='.$Cod.'&Mensaje='.$Mensaje);
	break;
	case "M":
		$Cod=explode('~',$Codigos);
		$Datos=explode('||',$Valores);
		$Mes=1;
		while(list($c,$v)=each($Datos))
		{
			if($v!='')
			{
				$Datos2=explode('~~',$v);
				if($Datos2[0]=='')
					$Datos2[0]=0;
				if($Datos2[1]=='')
					$Datos2[1]=0;
				if($Datos2[2]=='')
					$Datos2[2]=0;
				$Consulta="select * from pcip_eec_disponibilidades ";
				$Consulta.=" where tipo_disponibilidad='P' and cod_sistema = '".$Cod[0]."' and cod_equipo='".$Cod[1]."' and ano='".$Cod[2]."' and mes='".$Mes."'";
				$Resp=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
					$Actualizar="UPDATE pcip_eec_disponibilidades set hrs_oper_d='".str_replace(',','.',$Datos2[0])."',hrs_mant_men='".str_replace(',','.',$Datos2[1])."',hrs_mant_may='".str_replace(',','.',$Datos2[2])."' ";
					$Actualizar.=" where tipo_disponibilidad='P' and cod_sistema = '".$Cod[0]."' and cod_equipo='".$Cod[1]."' and ano='".$Cod[2]."' and mes='".$Mes."'";
					//echo $Actualizar."<br>";
					mysql_query($Actualizar);
					$Mensaje='3';
				}
				else
				{
					$Insertar="insert into pcip_eec_disponibilidades (cod_sistema,cod_equipo,tipo_disponibilidad,ano,mes,hrs_oper_d,hrs_mant_men,hrs_mant_may) values ";
					$Insertar.="('".$Cod[0]."','".$Cod[1]."','P','".$Cod[2]."','".$Mes."','".str_replace(',','.',$Datos2[0])."','".str_replace(',','.',$Datos2[1])."','".str_replace(',','.',$Datos2[2])."')";
					//echo $Insertar."<br>";
					mysql_query($Insertar);
				}
			}
			$Mes++;
		}
		header('location:pcip_mantenedor_disponibilidad_proyectada_proceso.php?Opcion=M&Codigos='.$Codigos.'&Mensaje='.$Mensaje);
	break;
	case "E":
		$Mensaje='1';
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
			$Cod=explode('~',$Codigo);
			$Eliminar="delete from pcip_eec_disponibilidades where tipo_disponibilidad='P' and cod_sistema = '".$Cod[0]."' and cod_equipo='".$Cod[1]."' and ano='".$Cod[2]."'";
			mysql_query($Eliminar);
		}
		header("location:pcip_mantenedor_disponibilidad_proyectada.php?Mensaje=".$Mensaje."&Buscar=S&Ano=".date('Y'));
	break;
}

?>