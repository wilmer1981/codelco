<?php
	include("../principal/conectar_principal.php");	
	switch($Proceso)
	{
		case "N":
			$Insertar="INSERT INTO sipa_web.camion(PATENT_A,R_PROV_A,C_FAEN_A,C_PROD_A,PROM_BR,PROM_TR) values(";
			$Insertar.="'$TxtPatente','$CmbProveedor','$CmbMinaPrv','$CmbSubProducto','".str_replace(',','.',$TxtPromBr)."','".str_replace(',','.',$TxtPromTr)."')";
			mysqli_query($link, $Insertar);
			header('location:rec_ingreso_camiones.php');
			break;
		case "M":
			$Datos2=explode('~~',$Valores);
			$Patente=$Datos2[0];
			$RutProveedor=$Datos2[1];
			$CodMina=$Datos2[2];
			$CodSubProducto=$Datos2[3];
			$Actualizar="UPDATE sipa_web.camion set PROM_BR='".str_replace(',','.',$TxtPromBr)."',PROM_TR='".str_replace(',','.',$TxtPromTr)."' ";
			$Actualizar.="where PATENT_A='".$Patente."' and R_PROV_A='".$RutProveedor."' and C_FAEN_A='".$CodMina."' and C_PROD_A='".$CodSubProducto."'";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='rec_ingreso_camiones.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "E":
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~~',$v);
				$Patente=$Datos2[0];
				$RutProveedor=$Datos2[1];
				$CodMina=$Datos2[2];
				$CodSubProducto=$Datos2[3];
				$Eliminar="delete from sipa_web.camion where PATENT_A='".$Patente."' and R_PROV_A='".$RutProveedor."' and C_FAEN_A='".$CodMina."' and C_PROD_A='".$CodSubProducto."'";
				mysqli_query($link, $Eliminar);
			}
			header('location:rec_ingreso_camiones.php');
			break;
	}
?>