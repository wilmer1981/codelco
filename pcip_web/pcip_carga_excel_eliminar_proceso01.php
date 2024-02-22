<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

switch($Opcion)
{
	case "E":
		$Mensaje='';
		$Consulta = "select * from pcip_lista_excel where cod_excel='".$CmbExcel."' order by orden ";
		$Resp=mysql_query($Consulta);
		//echo $Consulta."<br>";
		while ($Fila=mysql_fetch_array($Resp))
		{
			$Codigo=$Fila[cod_excel];
			$CodigoSumi=$Fila[valor];
			//echo $CodigoSumi."<br>";
			$Tipocarga=$Fila[tipo_carga];
			$TipoExcel=$Fila[tipo_excel];

			if($Tipocarga=='A')
			{			  
				$Eliminar="delete from pcip_eec_suministros_detalle where cod_suministro='".$CodigoSumi."' and ano='".$Ano."' and  tipo='".$TipoExcel."'";	
				mysql_query($Eliminar);
				//echo $Eliminar;
				$Mensaje='2';
			}
			if($Tipocarga=='M')
			{
				$Eliminar="delete from pcip_eec_suministros_detalle where cod_suministro='".$CodigoSumi."' and ano='".$Ano."' and mes='".$Mes."' and  tipo='".$TipoExcel."'";	
				mysql_query($Eliminar);
				//echo $Eliminar;
				$Mensaje='2';
			}	
			if($Codigo=='31')
			{
				$Eliminar="delete from pcip_ere_estado_resultado where ano='".$Ano."' and mes='".$Mes."'";	
				mysql_query($Eliminar);
				//echo $Eliminar;
				$Mensaje='2';
			}
			if($Codigo=='32')
			{
				$Eliminar="delete from pcip_cdv_cuadro_diario_ventas where ano='".$Ano."' and mes='".$Mes."'";	
				mysql_query($Eliminar);
				//echo $Eliminar;
				$Mensaje='2';
			}
			if($Codigo=='36')
			{
				$Eliminar="delete from pcip_inp_tratam where ano='".$Ano."' and mes='".$Mes."'";	
				mysql_query($Eliminar);
				//echo $Eliminar;
				$Mensaje='2';
			}
			$Mensaje='Excel Eliminado Correctamente';					
		}
		echo "<script language='JavaScript'>";
		   echo "window.opener.document.FrmProceso.action='pcip_carga_excel.php?Mensaje=$Mensaje';";
		   echo "window.opener.document.FrmProceso.submit();";
		   echo "window.close();";
		echo "</script>";
	break;
}

?>