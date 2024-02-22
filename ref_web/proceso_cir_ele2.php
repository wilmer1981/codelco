<?php
	include("../principal/conectar_ref_web.php");
	
	$fecha=$ano1."-".$mes1."-".$dia1;
    if ($mostrar == "S")
	{
		$consulta = "select t1.turno,t1.circuito_h2so4,t1.volumen_h2so4,t2.circuito_dp,t2.volumen_dp,t3.destino_pte,t3.circuito_pte,t3.volumen_pte from ref_web.electrolito as t1 ";
        $consulta = $consulta."inner join  ref_web.desc_parcial as t2 on t1.fecha=t2.fecha and t1.turno=t2.turno ";
        $consulta = $consulta."inner join ref_web.tratamiento_electrolito as t3 on t2.fecha=t3.fecha and t2.turno=t3.turno ";
        $consulta = $consulta."where t1.fecha = '".$fecha."' and t1.turno = '".$turno."' ";
		echo $consulta."<br>";
	/*	$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{		
			echo '<tr>';
			echo '<td width="63" height="25">';
			//echo '<input type="checkbox" name="checkbox" value="'.$row["cod_grupo"].'/'.$row[fecha_desconexion].'"></td>';
			//echo '<td width="54" align="center">'.$row[turno].'</td>';
			echo '<td width="82" align="center">'.$row[circuito_h2so4].'</td>';			
			echo '<td width="166" align="center">'.$row[volumen_h2so4].'</td>';
			echo '<td width="95" align="center">'.$row[circuito_dp].'</td>';
			echo '<td width="165" align="center">'.$row[volumen_dp]).'</td>';
			echo '<td width="89" align="center">'.$row[destino_pte].'</td>';
     		echo '<td width="89" align="center">'.$row[circuito_pte].'</td>';
			echo '<td width="89" align="center">'.$row[volumen_pte].'</td>';
			echo '</tr>';
		}*/
		header("Location:ingreso_cir_ele.php?activar=");
	}
?>	
