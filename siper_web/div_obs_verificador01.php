<?php
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');	
	
	if($OPC=='GO')
	{
		$Consulta="select max(CIDVERIFICADOR+1) as maximo from sgrs_siperverificadores_obs ";
		$Resp=mysqli_query($link,$Consulta);
		if($Fila=mysqli_fetch_array($Resp))
		{
			if($Fila[maximo]=='')
				$TxtVeriObs='1';
			else		
				$TxtVeriObs=$Fila[maximo];
		}
		
		$Inserta="INSERT INTO sgrs_siperverificadores_obs  (CIDVERIFICADOR,COD_VERIFICADOR,CPELIGRO,TOBSERVACION,CAREA,CCONTACTO)";
		$Inserta.=" values('".$TxtVeriObs."','".$CodVeri."','".$Peligro."','".$ObsVeri."','".$Area."','".$CodCCONTACTO."')";		
		mysqli_query($link,$Inserta);
	}
	else
	{
		$Actualiza="update sgrs_siperverificadores_obs set TOBSERVACION='".$ObsVeri."'  where CIDVERIFICADOR='".$CIDCORR."' and COD_VERIFICADOR='".$CodVeri."' and CPELIGRO='".$Peligro."' and CAREA='".$Area."' and CCONTACTO='".$CodCCONTACTO."'";		
		//echo $Actualiza."<br>";
		mysqli_query($link,$Actualiza);
	}
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.Mantenedor.action='procesos_organica.php?CodSelTarea=$CodSelTarea&TipoPestana=2';";
	echo "window.opener.document.Mantenedor.submit();";
	echo "window.close();";
	echo "</script>";
?>