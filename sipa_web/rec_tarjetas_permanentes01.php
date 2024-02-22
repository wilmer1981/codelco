<?php
	include("../principal/conectar_principal.php");
//	echo $ValoresAux;

	$Proceso = $_REQUEST["Proceso"];
	$Valores = $_REQUEST["Valores"];
	$TxtPatente = $_REQUEST["TxtPatente"];
	$TxtTarjeta = $_REQUEST["TxtTarjeta"];
	$CmbCodMop = $_REQUEST["CmbCodMop"];


	switch ($Proceso)
	{
		case "N":
			$Existe=false;
			$Consulta="SELECT * from sipa_web.tarjetas_permanentes where ";
			$Consulta.="patente ='".$TxtPatente."'";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
			{
				$Existe=true;
				header("location:rec_tarjetas_permanentes_proceso.php?Existe=".$Existe."&Proceso=".$Proceso);
			}
			else
			{
				$Insertar=" INSERT INTO sipa_web.tarjetas_permanentes ";
				$Insertar.=" (patente,tarjeta,cod_mop) VALUES(";
				$Insertar.=" '".strtoupper($TxtPatente)."','".$TxtTarjeta."','".$CmbCodMop."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.frmPrincipal.action='rec_tarjetas_permanentes.php';";
				echo "window.opener.document.frmPrincipal.submit();";
				echo "window.close();</script>";
			}
		break;
		case "E":
			$Datos = explode("//",$Valores);
			foreach($Datos as $clave => $Codigo)
			{
				$arreglo=explode("~",$Codigo);
				$Eliminar=" DELETE from sipa_web.tarjetas_permanentes ";
				$Eliminar.=" where patente ='".$arreglo[0]."'";
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";
			}
			header("location:rec_tarjetas_permanentes.php");
		break;
		case "M":
			//$Datos2=explode('~',$Valores);
			$Actualizar=" UPDATE  sipa_web.tarjetas_permanentes SET ";
			$Actualizar.="  tarjeta='".$TxtTarjeta."',cod_mop='".$CmbCodMop."'";
			$Actualizar.=" WHERE patente ='".$TxtPatente."' ";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='rec_tarjetas_permanentes.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
		break;
	}
?>