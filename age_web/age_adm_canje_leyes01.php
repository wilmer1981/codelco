<?php
	include("../principal/conectar_principal.php");
	
	$Fecha=$TxtFechaCanje;
	$FechaSolPqts=$TxtFechaSolPqts;
	$Param='';
	switch ($Proceso)
	{
		case "G"://NUEVO
			$Eliminar ="delete from age_web.leyes_por_lote_canje where lote='$TxtLote'";
			//echo $Eliminar;
			mysqli_query($link, $Eliminar);
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~~',$v);
				$CodLey=$Datos2[0];
				$NomLey=$Datos2[1];
				$NomUnidad=$Datos2[2];
				$ValorLey1=$Datos2[3];
				$ValorLey2=$Datos2[4];
				$ValorLey3=$Datos2[5];
				$ValorLey4=$Datos2[6];
				$ValorLeyR=$Datos2[7];
				$ValorIncR=$Datos2[8];
				$ValorLeyC=$Datos2[9];
				$ValorLeyF=$Datos2[10];
				$NumPqte=$Datos2[11];
				$Seguimiento=$Datos2[12];
				$CodUnidad=$Datos2[13];
				$Arbitral=$Datos2[14];
				$ForzarLey2=$Datos2[15];
				$CodLab=$Datos2[16];
				$OrdenEnsaye=$Datos2[17];
				if($ValorLey2=='')
					$ValorLey2=0;
				if($ValorLey3=='')
					$ValorLey3=0;
				if($ValorLey4=='')
					$ValorLey4=0;
				if($ValorLeyR=='')
					$ValorLeyR=0;
				if($ValorIncR=='')
					$ValorIncR=0;
				$Insertar="INSERT INTO age_web.leyes_por_lote_canje(lote,recargo,cod_leyes,valor1,valor2,valor3,valor4,cod_unidad,paquete_canje,valor_retalla,inc_retalla,ley_canje,observacion,plantilla_limite,pendiente,ley_forzada) values (";
				$Insertar.="'$TxtLote','0','$CodLey','".str_replace(',','.',$ValorLey1)."','".str_replace(',','.',$ValorLey2)."','".str_replace(',','.',$ValorLey3)."','".str_replace(',','.',$ValorLey4)."','$CodUnidad',";
				$Insertar.="'$NumPqte','".str_replace(',','.',$ValorLeyR)."','".str_replace(',','.',$ValorIncR)."','".str_replace(',','.',$ValorLeyC)."','$Seguimiento','$CmbPlantLimPart','$Arbitral','$ForzarLey2')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
				$Actualizar="UPDATE age_web.lotes set canjeable='S',fecha_sol_pqts='$FechaSolPqts',fecha_canje='$Fecha',laboratorio_externo='$CodLab',orden_ensaye='$OrdenEnsaye' ";
				$Actualizar.="where lote='".$TxtLote."'";
				//echo $Actualizar;
				mysqli_query($link, $Actualizar);
				//$Param="?TxtLote=".$TxtLote."&Calcular=S&Valores=".$Valores;
				$Param="?TxtLote=".$TxtLote;
			}		
			break;
		case "CMC"://CERRAR LOTE COMERCIAL
			$Actualizar="UPDATE age_web.lotes set fin_canje='S', fecha_fin_canje='$Fecha',estado_lote='4' ";
			$Actualizar.="where lote='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			$Actualizar="UPDATE age_web.detalle_lotes set estado_recargo='4' ";
			$Actualizar.="where lote='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			//$Param="?TxtLote=".$TxtLote."&Calcular=S&Valores=".$Valores;
			$Param="?TxtLote=".$TxtLote;
			break;
		case "MC"://MODIFICAR LOTE COMERCIAL
			$Actualizar="UPDATE age_web.lotes set fin_canje='', fecha_fin_canje='0000-00-00',estado_lote='1' ";
			$Actualizar.="where lote='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar."<br>";
			$Actualizar="UPDATE age_web.detalle_lotes set estado_recargo='1' ";
			$Actualizar.="where lote='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar."<br>";
			//$Param="?TxtLote=".$TxtLote."&Calcular=S&Valores=".$Valores;
			$Param="?TxtLote=".$TxtLote;
			break;
		case "ELI"://ELIMINAR REGISTRO GRABADO COMO CANJE PARA TOMAR LOS VALORES ORIGINALES DE LEYES
			
			$Eliminar="delete from age_web.leyes_por_lote_canje where lote='".$TxtLote."' and cod_leyes='".$CodLeyEli."'";
			mysqli_query($link, $Eliminar);
			//echo $Eliminar;
			$Actualizar="UPDATE age_web.lotes SET fin_canje='N' WHERE lote ='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			$Param="?TxtLote=".$TxtLote;
			break;	
	}
	header("location:age_adm_canje_leyes.php".$Param);
?>