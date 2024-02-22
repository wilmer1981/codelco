<?php
	include("../principal/conectar_principal.php");	
	switch($Proceso)
	{
		case "N":
			$Insertar="INSERT INTO sipa_web.conjunto(CONJTO_C,RUTPRV_C,MINPRV_C,PRDPRV_C) values(";
			$Insertar.="'$TxtConjunto','$CmbProveedor','$CmbMinaPrv','$CmbSubProducto')";
			mysqli_query($link, $Insertar);
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='rec_ingreso_conjuntos.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "M":
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~~',$v);
				$Conjunto=$Datos2[0];
				$RutProveedor=$Datos2[1];
				$CodMina=$Datos2[2];
				$CodSubProducto=$Datos2[3];
				$Actualizar="UPDATE sipa_web.conjunto set CONJTO_C='".$TxtConjunto2."' where CONJTO_C='".$Conjunto."' and RUTPRV_C='".$RutProveedor."' and MINPRV_C='".$CodMina."' and PRDPRV_C='".$CodSubProducto."'";
				mysqli_query($link, $Actualizar);
			}	
			header('location:rec_ingreso_conjuntos.php');
			break;
		case "E":
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~~',$v);
				$Conjunto=$Datos2[0];
				$RutProveedor=$Datos2[1];
				$CodMina=$Datos2[2];
				$CodSubProducto=$Datos2[3];
				$Eliminar="delete from sipa_web.conjunto where CONJTO_C='".$Conjunto."' and RUTPRV_C='".$RutProveedor."' and MINPRV_C='".$CodMina."' and PRDPRV_C='".$CodSubProducto."'";
				mysqli_query($link, $Eliminar);
			}
			header('location:rec_ingreso_conjuntos.php');
			break;
	}
?>