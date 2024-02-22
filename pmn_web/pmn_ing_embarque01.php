<?php
	include("../principal/conectar_pmn_web.php");
	include("pmn_funciones.php");	

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}
	if(isset($_REQUEST["Tipo"])){
		$Tipo = $_REQUEST["Tipo"];
	}else{
		$Tipo = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}
	if(isset($_REQUEST["Dia"])){
		$Dia = $_REQUEST["Dia"];
	}else{
		$Dia = "";
	}

	if(isset($_REQUEST["Corr"])){
		$Corr = $_REQUEST["Corr"];
	}else{
		$Corr = "";
	}


	switch ($Proceso)
	{
		case "G": //GRABAR
			
			$Valores=explode('//',$Valores);	
			$Fembarque=$Ano."-".$Mes."-".$Dia;
			//while(list($c,$v)=each($Valores))
			foreach ($Valores as $c => $v)
			{
				$v=explode('-/-',$v);
				$Insertar = "UPDATE pmn_web.pmn_pesa_bad_cabecera set fecha_embarque='".$Fembarque."'";
				$Insertar.= " where lote='".$v[0]."'";
				//ho $Insertar."<br />";
				//mysqli_query($link, $Insertar);

				if($Tipo=='SIPA')								
					Bitacora($v[0],'','','','','','','','','Se ingresa relacion Lote - Corr. SIPA de Palet '.$v[1],'I',$Corr,'','','');
				else
					Bitacora($v[0],'','','','','','','','','Se ingresa relacion Lote - Corr. ESPECIAL de Palet '.$v[1],'I',$CorrEs,'','','');	

				$valor1='5';$valor2='8';				
				if($v[1]=='A')
				{	$valor1='1';$valor2='4';	}
				for($i=$valor1;$i<=$valor2;$i++)
				{				
					$Insertar = "UPDATE pmn_web.pmn_pesa_bad_detalle set fecha_embarque='".$Fembarque."'";
					if($Tipo=='SIPA')								
						$Insertar.=",correlativo_sipa='".$Corr."'";
					else
						$Insertar.=",correlativo_sipa='".$CorrEs."'";	
					$Insertar.= ",palet_a_b='".$v[1]."'";
					$Insertar.= " where lote='".$v[0]."' and recargo='".$i."'";
					mysqli_query($link, $Insertar);
				}
			}
			if($Tipo=='SIPA')								
				header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Tipo=".$Tipo."&Corr=".$Corr);
			else
			{
				//$ActualizaDato=$CorrEs+1;
				$Insertar = "UPDATE pmn_web.pmn_corr_especial set corr_especial='".$CorrEs."'";
				mysqli_query($link, $Insertar);			
				header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Tipo=".$Tipo."&CorrEs=".$CorrEs);	
			}	
			break;
		case "C": //CANCELAR
			header("location:pmn_embarque.php");
			break;
		case "ELote":	
			$Insertar = "UPDATE pmn_web.pmn_pesa_bad_detalle set correlativo_sipa=null,fecha_embarque=null";
			$Insertar.= " where lote in (".str_replace('//',',',$Valores).")";
			mysqli_query($link, $Insertar);
			header("location:pmn_ing_embarque02.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&DiaF=".$DiaF."&MesF=".$MesF."&AnoF=".$AnoF."&Corr=".$Corr);
		break;
		case "ECorr":	
			$Valores=explode('//',$Valores);	
			//while(list($c,$v)=each($Valores))
			foreach ($Valores as $c => $v)
			{
				$v=explode('-/-',$v);
				$Actualiza = "UPDATE pmn_web.pmn_pesa_bad_cabecera set fecha_embarque=null";
				$Actualiza.= " where lote='".$v[0]."'";
				//echo $Actualiza."<br>";
				//mysqli_query($link, $Insertar);
				
				$valor1='5';$valor2='8';				
				if($v[1]=='A')
				{	$valor1='1';$valor2='4';	}
				for($i=$valor1;$i<=$valor2;$i++)
				{				
					$Actualiza = "UPDATE pmn_web.pmn_pesa_bad_detalle set fecha_embarque=null,correlativo_sipa=null,palet_a_b=null";
					$Actualiza.= " where lote='".$v[0]."' and recargo='".$i."'";
					//echo $Actualiza."<br />";
					mysqli_query($link, $Actualiza);
				}
				Bitacora($v[0],'','','','','','','','','Se elimina relacion Lote - Corr. SIPA de Palet '.$v[1],'E',$v[2],'','','');
			}			
			header("location:pmn_ing_embarque03.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&DiaF=".$DiaF."&MesF=".$MesF."&AnoF=".$AnoF."&Corr=".$Corr."&Tipo=".$Tipo);
		break;
	}
?>