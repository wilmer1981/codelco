<?php
	include("../principal/conectar_principal.php");
//	echo $ValoresAux;

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$CmbLey  = isset($_REQUEST["CmbLey"])?$_REQUEST["CmbLey"]:"";
	$TxtSTD1 = isset($_REQUEST["TxtSTD1"])?$_REQUEST["TxtSTD1"]:"";
	$TxtSTD2 = isset($_REQUEST["TxtSTD2"])?$_REQUEST["TxtSTD2"]:"";
	$TxtSTD3 = isset($_REQUEST["TxtSTD3"])?$_REQUEST["TxtSTD3"]:"";


	switch ($Proceso)
	{
		case "N":
			$Existe=false;
			$Consulta="select * from cal_web.clasificacion_catodos_ew where ";
			$Consulta.="cod_leyes ='".$CmbLey."'";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
			{
				$Existe=true;
				header("location:sec_clasificacion_catodos_ew_proceso.php?Existe=".$Existe."&Proceso=".$Proceso);
			}
			else
			{
				$Insertar=" insert into cal_web.clasificacion_catodos_ew ";
				$Insertar.=" (cod_leyes,std_1,std_2,std_3) values(";
				$Insertar.=" '".$CmbLey."','".$TxtSTD1."','".$TxtSTD2."','".$TxtSTD3."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.frmPrincipal.action='sec_clasificacion_catodos_ew.php';";
				echo "window.opener.document.frmPrincipal.submit();";
				echo "window.close();</script>";
			}
		break;
		case "E":
			$Datos = explode("//",$Valores);
			//while (list($clave,$Codigo)=each($Datos))
			foreach($Datos as $clave => $Codigo)
			{
				$arreglo=explode("~",$Codigo);
				$Eliminar=" delete from cal_web.clasificacion_catodos_ew ";
				$Eliminar.=" where cod_leyes ='".$arreglo[0]."'";
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";
			}
			header("location:sec_clasificacion_catodos_ew.php");
		break;
		case "M":
			//$Datos2=explode('~',$Valores);
			$Actualizar=" UPDATE  cal_web.clasificacion_catodos_ew set ";
			$Actualizar.="  std_1='".$TxtSTD1."',std_2='".$TxtSTD2."' , std_3='".$TxtSTD3."' ";
			$Actualizar.=" where cod_leyes ='".$CmbLey."' ";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='sec_clasificacion_catodos_ew.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
		break;
	}
?>