<?php
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');	
	
	if($OPC=='GO')
	{
		$Consulta="select max(CIDCONTROL+1) as maximo from sgrs_sipercontroles_obs ";
		$Resp=mysqli_query($link,$Consulta);
		if($Fila=mysqli_fetch_array($Resp))
		{
			if($Fila[maximo]=='')
				$TxtVeriObs='1';
			else		
				$TxtVeriObs=$Fila[maximo];
		}
		
		$Inserta="INSERT INTO sgrs_sipercontroles_obs  (CIDCONTROL,CCONTROL,CPELIGRO,TOBSERVACION,CAREA,CCONTACTO)";
		$Inserta.=" values('".$TxtVeriObs."','".$CODCONTROL."','".$Peligro."','".$ObsVeri."','".$Area."','".$CodCCONTACTO."')";		
		//echo $Inserta."<br>";
		mysqli_query($link,$Inserta);
	}
	else
	{
		$Actualiza="update sgrs_sipercontroles_obs set TOBSERVACION='".$ObsVeri."'  where CIDCONTROL='".$CIDCORR."' and CCONTROL='".$CODCONTROL."' and CPELIGRO='".$Peligro."' and CAREA='".$Area."' and CCONTACTO='".$CodCCONTACTO."'";		
		//echo $Actualiza."<br>";
		mysqli_query($link,$Actualiza);
	
	}
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.Mantenedor.action='procesos_organica.php?CodSelTarea=$CodSelTarea&TipoPestana=3';";
	echo "window.opener.document.Mantenedor.submit();";
	echo "window.close();";
	echo "</script>";
?>