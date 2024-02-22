<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "N":
		$Dato=explode('//',$Valor);
		while(list($c,$v)=each($Dato))
		{	
		    $MensajeExiste=false;
			$Val=explode('~',$v);	
		    $Consulta="select cod_producto,ano,mes from pcip_inp_precios_dore where dato='".$CmbDatos."' and  cod_producto='".$CmbProducto."' and ano='".$Ano."' and mes='".$Val[1]."'";
			$Resp=mysql_query($Consulta);
			//echo $Consulta."<br>";
			if(!$Fila=mysql_fetch_array($Resp))
			{
				$MensajeInserta=false;				
				$Insertar="insert into pcip_inp_precios_dore (dato,cod_producto,ano,mes,valor_real,valor_ppto) values ";
				$Insertar.="('".$CmbDatos."','".$CmbProducto."','".$Ano."','".$Val[1]."','0','0')";
				mysql_query($Insertar);	
				//echo $Insertar."<br>";
				$MensajeInserta=true;	
			}
			if($Val[2]=='R')
			{
				$Actualizar="UPDATE pcip_inp_precios_dore set valor_real='".intval($Val[3])."' where dato='".$CmbDatos."' and  cod_producto='".$CmbProducto."' and ano='".$Ano."' and mes='".$Val[1]."'";	
				mysql_query($Actualizar);	
				//echo $Actualizar."<br>";
			}
			if($Val[2]=='P')
			{
				$Actualizar1="UPDATE pcip_inp_precios_dore set valor_ppto='".intval($Val[3])."' where dato='".$CmbDatos."' and  cod_producto='".$CmbProducto."' and ano='".$Ano."' and mes='".$Val[1]."'";	
				mysql_query($Actualizar1);	
				//echo $Actualizar1."<br>";				
			}
	    $MensajeExiste=true;		
		}
		$Cod=$CmbDatos."~".$CmbProducto."~".$Ano."~".$Val[1];
		header('location:pcip_mantenedor_ingresos_proyectados_precios_proceso.php?Opcion=M&Codigos='.$Cod.'&MensajeExiste='.$MensajeExiste.'&MensajeInserta='.$MensajeInserta);
	break;
	case "M":
		$Dato=explode('//',$Valor);
		while(list($c,$v)=each($Dato))
		{	
		    $MensajeActualizar=false;
			$Val=explode('~',$v);			
			if($Val[2]=='R')
			{
		   		$Cod=explode('~',$Codigos);
				$Real=str_replace(".","",$Val[3]);
				$Real=str_replace(",",".",$Real);
				//echo $Real;
				$Actualizar="UPDATE pcip_inp_precios_dore set valor_real='".$Real."' where dato='".$Cod[0]."' and cod_producto='".$Cod[1]."' and ano='".$Cod[2]."' and mes='".$Val[1]."'";	
				mysql_query($Actualizar);	
				//echo $Actualizar."<br>";
			}
			if($Val[2]=='P')
			{
		   		$Cod=explode('~',$Codigos);
				$Ppto=str_replace(".","",$Val[3]);
				$Ppto=str_replace(",",".",$Ppto);
				//echo $Ppto;
				$Actualizar1="UPDATE pcip_inp_precios_dore set valor_ppto='".$Ppto."' where dato='".$Cod[0]."' and cod_producto='".$Cod[1]."' and ano='".$Cod[2]."' and mes='".$Val[1]."'";	
				mysql_query($Actualizar1);	
				//echo $Actualizar1."<br>";				
			}
		$MensajeActualizar=true;
		}			
		$Cod=$Cod[0]."~".$Cod[1]."~".$Cod[2]."~".$Val[1];	
		header('location:pcip_mantenedor_ingresos_proyectados_precios_proceso.php?Opcion=M&Codigos='.$Cod.'&MensajeActualizar='.$MensajeActualizar);
	break;
	case "E":
		$Mensaje='1';
		$Datos = explode("//",$Valores);
		while (list($clave,$Codigo)=each($Datos))
		{				
			$Cod=explode('~',$Codigo);
			$Eliminar="delete from pcip_inp_precios_dore where dato='".$Cod[0]."' and cod_producto='".$Cod[1]."' and  ano='".$Cod[2]."'";	
			mysql_query($Eliminar);
		}
		header("location:pcip_mantenedor_ingresos_proyectados_precios.php?Mensaje=".$Mensaje."&Buscar=S");
	break;
}

?>