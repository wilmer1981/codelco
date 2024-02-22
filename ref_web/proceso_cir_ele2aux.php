<?php
	include("../principal/conectar_ref_web.php");
	if (strlen($dia1==1))
	   $dia1='0'.$dia1;
	if (strlen($mes1==1))
	    $mes1='0'.$mes1;    
	$fecha=$ano1."-".$mes1."-".$dia1;
    if ($mostrar == "S")
	{
       $consulta="select turno,circuito_h2so4,volumen_h2so4 from electrolito where fecha='".$fecha."'";	
	 
	   $rs = mysqli_query($link, $consulta);
	   while ($row = mysqli_fetch_array($rs))
		{		
			echo '<tr>';
			echo '<td width="63" height="25">';
			echo '<input type="checkbox" name="checkbox" value="'.$row["cod_grupo"].'/'.$row[fecha_desconexion].'"></td>';
			//echo '<td width="54" align="center">'.$row[turno].'</td>';
			echo '<td width="82" align="center">'.$row[circuito_h2so4].'&nbsp</td>';			
			echo '<td width="166" align="center">'.$row[volumen_h2so4].'&nbsp</td>';
			echo '<td width="95" align="center">&nbsp</td>';
			echo '<td width="95" align="center">&nbsp</td>';
			echo '<td width="95" align="center">&nbsp</td>';
     		echo '<td width="95" align="center">&nbsp</td>';
			echo '<td width="95" align="center">&nbsp</td>';
			echo '</tr>';
		}
		/*header("Location:ingreso_cir_ele.php?activar=");*/
	}
?>	
