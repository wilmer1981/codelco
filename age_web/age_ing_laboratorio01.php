<?php
	include("../principal/conectar_principal.php");

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$TxtLab  = isset($_REQUEST["TxtLab"])?$_REQUEST["TxtLab"]:"";
	$TxtCod  = isset($_REQUEST["TxtCod"])?$_REQUEST["TxtCod"]:"";
	$CmbTipoCambio  = isset($_REQUEST["CmbTipoCambio"])?$_REQUEST["CmbTipoCambio"]:"";
	$TxtValorCu  = isset($_REQUEST["TxtValorCu"])?$_REQUEST["TxtValorCu"]:"";
	$TxtValorAg  = isset($_REQUEST["TxtValorAg"])?$_REQUEST["TxtValorAg"]:"";
	$TxtValorAu  = isset($_REQUEST["TxtValorAu"])?$_REQUEST["TxtValorAu"]:"";
	$ChkSelec    = isset($_REQUEST["ChkSelec"])?$_REQUEST["ChkSelec"]:"";

	switch ($Proceso)
	{
		case "N":
			$Insertar = "insert into proyecto_modernizacion.sub_clase (cod_clase,cod_subclase,nombre_subclase,valor_subclase1,valor_subclase2,valor_subclase3,valor_subclase4) ";
			$Insertar.= " values('15009','$TxtCod','$TxtLab','$CmbTipoCambio','$TxtValorCu','$TxtValorAg','$TxtValorAu')";
			mysqli_query($link, $Insertar);
			//echo $Insertar."<br>";
			header("location:age_ing_laboratorio02.php?Proc=M&Valores=".$TxtCod);
			break;	
		case "M":
			$Actualizar = " UPDATE proyecto_modernizacion.sub_clase set ";
			$Actualizar.= " nombre_subclase='".$TxtLab."'";
			$Actualizar.= " , valor_subclase1='".$CmbTipoCambio."'";
			$Actualizar.= " , valor_subclase2='".str_replace(",",".",$TxtValorCu)."'";
			$Actualizar.= " , valor_subclase3='".str_replace(",",".",$TxtValorAg)."'";
			$Actualizar.= " , valor_subclase4='".str_replace(",",".",$TxtValorAu)."'";
			$Actualizar.= " where cod_clase='15009'";
			$Actualizar.= " and cod_subclase='".$TxtCod."'";
			mysqli_query($link, $Actualizar);
			header("location:age_ing_laboratorio02.php?Proc=M&Valores=".$TxtCod);
			break;
		case "E":			
			$Datos = explode("~~",$ChkSelec);			
			$Eliminar = "delete from proyecto_modernizacion.sub_clase ";
			$Eliminar.= " where cod_clase='15009'";
			$Eliminar.= " and cod_subclase='".$Datos[0]."'";
			//echo $Eliminar;
			mysqli_query($link, $Eliminar);			
			header("location:age_ing_laboratorio.php");
			break;		
	}
?>