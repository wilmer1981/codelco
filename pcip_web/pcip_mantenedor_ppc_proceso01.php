<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
		$Datos=explode('~~',$Valores);
		$Mes=1;
		if($CmbNegocio=='')
			$CmbNegocio=0;
		if($CmbTitulo=='')
			$CmbTitulo=0;
		while(list($c,$v)=each($Datos))
		{
			if($v=='')
				$v=0;
			$Insertar="insert into pcip_ppc_detalle (version,ano,mes,cod_asignacion,cod_procedencia,tipo,cod_negocio,cod_titulo,valor) values ";
			$Insertar.="('".$CmbVersion."','".$Ano."','".$Mes."','".$CmbProd."','".$CmbAsig."','".$CmbOrigen."',".$CmbNegocio.",".$CmbTitulo.",'".str_replace(',','.',$v)."')";
			//echo $Insertar."<br>";
			mysql_query($Insertar);
			$Mes++;
		}
		$Cod=$CmbVersion."~".$Ano."~".$CmbProd."~".$CmbAsig."~".$CmbNegocio."~".$CmbOrigen."~".$CmbTitulo;
		header('location:pcip_mantenedor_ppc_proceso.php?Opcion=M&Codigos='.$Cod);
	break;
	case "M":
		$Cod=explode('~',$Codigos);
		$Datos=explode('~~',$Valores);
		$Mes=1;
		while(list($c,$v)=each($Datos))
		{
			if($v=='')
				$v=0;
			$Consulta="select * from pcip_ppc_detalle where version='".$Cod[0]."' and ano='".$Cod[1]."' and mes='".$Mes."' and cod_asignacion='".$Cod[2]."'";
			$Consulta.=" and cod_procedencia='".$Cod[3]."' and tipo='".$Cod[5]."' and cod_negocio='".$Cod[4]."' and cod_titulo='".$Cod[6]."'";	
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{
				$Actualizar="UPDATE pcip_ppc_detalle t1 set valor='".str_replace(',','.',$v)."' where t1.version='".$Cod[0]."' and t1.ano='".$Cod[1]."' and t1.cod_asignacion='".$Cod[2]."' and t1.cod_procedencia='".$Cod[3]."' and t1.tipo='".$Cod[5]."' and t1.cod_negocio='".$Cod[4]."' and t1.cod_titulo='".$Cod[6]."' and mes='".$Mes."'";
				//echo $Actualizar."<br>";
				mysql_query($Actualizar);
			}
			else
			{	
				$Insertar="insert into pcip_ppc_detalle (version,ano,mes,cod_asignacion,cod_procedencia,tipo,cod_negocio,cod_titulo,valor) values ";
				$Insertar.="('".$Cod[0]."','".$Cod[1]."','".$Mes."','".$Cod[2]."','".$Cod[3]."','".$Cod[5]."','".$Cod[4]."','".$Cod[6]."','".str_replace(',','.',$v)."')";
				//echo $Insertar."<br>";
				mysql_query($Insertar);
			}
			$Mes++;
		}
		$Cod=$Cod[0]."~".$Cod[1]."~".$Cod[2]."~".$Cod[3]."~".$Cod[4]."~".$Cod[5]."~".$Cod[6];
		header('location:pcip_mantenedor_ppc_proceso.php?Opcion=M&Codigos='.$Cod);
	break;
	case "E":
		$Mensaje='1';
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
			$Cod=explode('~',$Codigo);
			$Eliminar="delete from pcip_ppc_detalle where version='".$Cod[0]."' and ano='".$Cod[1]."' and cod_asignacion='".$Cod[2]."' and cod_procedencia='".$Cod[3]."' and tipo='".$Cod[5]."' and cod_negocio='".$Cod[4]."' and cod_titulo='".$Cod[6]."'";
			//echo $Eliminar."<br>";
			mysql_query($Eliminar);
		}
		header("location:pcip_mantenedor_ppc.php?Mensaje=".$Mensaje);
	break;
}

?>