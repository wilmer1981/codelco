<?php
	include("../principal/conectar_principal.php");
//	echo $ValoresAux;
	$Proceso = $_REQUEST["Proceso"];
	$Valores = $_REQUEST["Valores"];
	$CmbLey = $_REQUEST["CmbLey"];
	$TxtSTD1 = $_REQUEST["TxtSTD1"];
	$TxtSTD2 = $_REQUEST["TxtSTD2"];
	$TxtSTD3 = $_REQUEST["TxtSTD3"];
	$TxtSTD4 = $_REQUEST["TxtSTD4"];
	$TxtSTD5 = $_REQUEST["TxtSTD5"];

	switch ($Proceso)
	{
		case "N":
			$Existe=false;
			$Consulta="select * from cal_web.clasificacion_catodos where ";
			$Consulta.="cod_leyes ='".$CmbLey."'";
			$Resp=mysqli_query($link, $Consulta);
			echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
			{
				$Existe=true;
				header("location:sec_clasificacion_catodos_proceso.php?Existe=".$Existe."&Proceso=".$Proceso);
			}
			else
			{
				$Insertar=" insert into cal_web.clasificacion_catodos ";
				$Insertar.=" (cod_leyes,grado_a_codelco,grado_a_enami,rechazo,estandar,off_grade) values(";
				$Insertar.=" '".$CmbLey."','".$TxtSTD1."','".$TxtSTD2."','".$TxtSTD3."','".$TxtSTD4."','".$TxtSTD5."')";
				mysqli_query($link, $Insertar);
			
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.frmPrincipal.action='sec_clasificacion_catodos.php';";
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
				$Eliminar=" delete from cal_web.clasificacion_catodos ";
				$Eliminar.=" where cod_leyes ='".$arreglo[0]."'";
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";
			}
			header("location:sec_clasificacion_catodos.php");
		break;
		case "M":
			//$Datos2=explode('~',$Valores);
			$Actualizar=" UPDATE  cal_web.clasificacion_catodos set ";
			$Actualizar.="  grado_a_codelco='".$TxtSTD1."',grado_a_enami='".$TxtSTD2."' , rechazo='".$TxtSTD3."' ";
			$Actualizar.=" , estandar='".$TxtSTD4."',off_grade='".$TxtSTD5."' ";
			$Actualizar.=" where cod_leyes ='".$CmbLey."' ";
			mysqli_query($link, $Actualizar);
			echo $Actualizar;
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='sec_clasificacion_catodos.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
		break;
	}
?>