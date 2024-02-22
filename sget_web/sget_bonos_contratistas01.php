<? 
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$Fecha_Creacion= date("Y-m-d G:i:s");
	switch($Opcion)
	{
		case "N"://NUEVO BONO
			$Eliminar="delete from sget_bonos_contratistas where cod_contrato='".$CmbContrato."' and ano = '".$CmbAno."' and num_bono='".$CmbNumBono."'";
			mysql_query($Eliminar);
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~~',$v);
				if($Datos2[1]!=0&&$Datos2[1]!="")
				{
					$Insertar="Insert Into sget_bonos_contratistas(cod_contrato,rut_persona,ano,num_bono,monto,fecha)";
					$Insertar.="values('".$CmbContrato."','".$Datos2[0]."','".$CmbAno."',".$CmbNumBono.",'".intval(str_replace('.','',$Datos2[1]))."','".date('Y-m-d')."')";
					mysql_query($Insertar);
				}	
			}
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='sget_bonos_contratistas.php?Buscar=S';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
		break;
		case "M"://MODIFICAR BONO
			$Eliminar="delete from sget_bonos_contratistas where cod_contrato='".$CmbContrato."' and ano = '".$CmbAno."' and num_bono='".$CmbNumBono."'";
			mysql_query($Eliminar);
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~~',$v);
				if($Datos2[1]!=0&&$Datos2[1]!="")
				{
					$Insertar="Insert Into sget_bonos_contratistas(cod_contrato,rut_persona,ano,num_bono,monto,fecha)";
					$Insertar.="values('".$CmbContrato."','".$Datos2[0]."','".$CmbAno."',".$CmbNumBono.",'".intval(str_replace('.','',$Datos2[1]))."','".date('Y-m-d')."')";
					mysql_query($Insertar);
				}
			}
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='sget_bonos_contratistas.php?Buscar=S';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
		break;
		case "E"://ELIMINAR EVALUACION
			$Datos=explode('||',$Valores);
			foreach($Datos as $c => $v)
			{
				$Codigos=explode('~~',$v);
				$Eliminar="delete from sget_evaluacion_adm where cod_contrato='".$Codigos[0]."' and nro_evaluacion='".$Codigos[1]."'";
				//echo $Eliminar;
				mysql_query($Eliminar);	
			}
			header("location:sget_bonos_contratistas.php?Buscar=S");
		break;
	}
?>
