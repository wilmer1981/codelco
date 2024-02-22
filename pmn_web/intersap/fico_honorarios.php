<?php
	include("inter_conectar.php");
	
	$NomArchivo="FicoHonorarios";
	$Archivo = fopen($NomArchivo,"w+");
	
	$Consulta = "select * from interfaces_sap.honorarios order by num_interno ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		if ($Fila["neto"]>0) 
		{
			$Mand="222";
			$Ano="2005";
			$Division="FV01";
			$RutProveedor=str_pad(str_replace(".","",$Fila["rut_proveedor"]),16," ",STR_PAD_RIGHT);
			$Lifnr=str_pad(str_replace(".","",$Fila["rut_proveedor"]),10," ",STR_PAD_RIGHT);
			$Mes=str_pad(substr($Fila["num_interno"],0,2),2,'0',STR_PAD_LEFT);
			$DocSap=str_pad($Fila["folio"],10," ",STR_PAD_LEFT);
			$Renta=str_pad($Fila["neto"],12,"0",STR_PAD_LEFT);
			$Monto=str_pad($Fila["retecion"],11,"0",STR_PAD_LEFT);
			$Consulta = "select * from factores where ano='".$Ano."' and mes='".$Mes."'";
			$Resp2=mysqli_query($link, $Consulta);
			if ($Fila2=mysqli_fetch_array($Resp2))
				$Factor=$Fila2["factor"];
			else
				$Factor=1;
			$RentaAct=round($Fila["neto"] * $Factor);
			$MontoAct=round($Fila["retecion"] * $Factor);
			$RentaAct=str_pad($RentaAct,12,"0",STR_PAD_LEFT);
			$MontoAct=str_pad($MontoAct,12,"0",STR_PAD_LEFT);
			$NombreProveedor=$Fila["nombre_proveedor"];
			$Linea = $Mand.$Ano.$Division.$RutProveedor.$Lifnr.$Mes.$DocSap.$Renta."  ".$Monto."  ".$RentaAct."  ".$MontoAct."CLP  ";
			fwrite($Archivo,$Linea."\r\n");
			echo $Linea."<br>";
		}
	}
	fclose($Archivo);
?>