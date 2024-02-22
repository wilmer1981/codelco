<?php 	
	include("../principal/conectar_principal.php");
	echo "<table border='1'>";
	echo "<tr>";
	echo "<td>PATENTE</td>";
	echo "<td>RUT TRANSPORTISTA</td>";
	echo "<td>RUT CHOFER</td>";
	echo "<td>NOMBRE TRANSPORTISTA</td>";
	echo "<td>NOMBRE CHOFER</td>";
	echo "</tr>";	
	$Consulta="SELECT * from sec_web.transporte_persona order by rut_transportista";
	$Respuesta=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		$Encontro=true;
		$Consulta="SELECT * FROM sec_web.transporte where RUT_TRANSPORTISTA  LIKE  '%".$Fila["rut_transportista"]."%' AND PATENTE_TRANSPORTE LIKE '%".$Fila[patente_camion]."%'";
		$Respuesta2=mysqli_query($link, $Consulta);
		if (!$Fila2=mysqli_fetch_array($Respuesta2))
		{
			$Encontro=false;
		}
		$Consulta="SELECT * FROM sec_web.persona where  rut_persona =  '".$Fila["rut_chofer"]."'";
		$Respuesta3=mysqli_query($link, $Consulta);
		if (!$Fila3=mysqli_fetch_array($Respuesta3))
		{
			$Encontro=false;
		}
		
		else
		{
			if ($Encontro==false)
			{
				echo "<tr>";
				echo "<td>".$Fila[patente_camion]."</td>";
				echo "<td>".$Fila["rut_transportista"]."</td>";
				echo "<td>".$Fila["rut_chofer"]."</td>";
				echo "<td>".$Fila2[nombre_transportista]."&nbsp;</td>";
				echo "<td>".$Fila3[nombre_persona]."&nbsp;</td>";
				echo "</tr>";
			}		
		}
	}
	echo "</table>";	
?>