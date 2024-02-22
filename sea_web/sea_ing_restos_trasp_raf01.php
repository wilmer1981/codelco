<?php
include("../principal/conectar_sea_web.php");
//$Hora=date("Y-m-d H:i:s");
//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	$valida_fecha_movimiento = $ano_r.'-'.$mes_r.'-'.$dia_r;
	include("sea_valida_mes.php");
//*******************************************************************************//

if($Proceso == "G")
{
    $fecha_r = $ano_r.'-'.$mes_r.'-'.$dia_r;
	$Hora=$ano_r.'-'.$mes_r.'-'.$dia_r." ".date("H:i:s");
	$vector = explode('//',$Valores);
	while (list($c,$v) = each($vector))
	{
		$vector2 = explode(',',$v);
	    $hornada = $vector2[0];
		$subpro = $vector2[1];		
		$lado    = $vector2[2];		
		$unidades = $vector2[3];		
		$peso    = $vector2[4];		

	 	$consulta = "SELECT YEAR(NOW()) AS  ano, MONTH(NOW()) AS mes";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);				
		$consulta = "SELECT IFNULL(SUM(unid_fin),0) AS unidades, IFNULL(SUM(peso_fin),0) AS peso, cod_subproducto FROM sea_web.stock";
		$consulta.= " WHERE ano = ".$row[ano]." AND mes = ".$row[mes]." AND cod_producto = 19  and cod_subproducto = '".$subpro."' AND hornada = '".$hornada."'";
		$consulta.= " GROUP BY hornada";
		//echo $consulta."<br>";
		$rs3 = mysqli_query($link, $consulta);
		$row3 = mysqli_fetch_array($rs3);
		
		$unidades = $row3["unidades"];
		$peso = $row3["peso"];
						
		//(-) Traspaso o Beneficio.
		$consulta = "SELECT IFNULL(SUM(unidades),0), IFNULL(SUM(peso),0) FROM sea_web.movimientos";
		$consulta.= " WHERE tipo_movimiento IN (2,4,3) AND cod_producto = 19 and cod_subproducto = '".$subpro."' AND hornada = '".$hornada."'";
		//echo $consulta."<br>";
		$rs4 = mysqli_query($link, $consulta);
		$row4 = mysqli_fetch_array($rs4);
		
		$unidades = $unidades - $row4["unidades"];
		$peso = $peso - $row4["peso"];
		
		//Busca el flujo Asociado al producto y proceso.		
		$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 19";
		$consulta = $consulta." AND cod_subproducto = '".$subpro."'";
		$rs1 = mysqli_query($link, $consulta);
		if ($row1 = mysqli_fetch_array($rs1))
			$flujo = $row1["flujo"];
		else 
			$flujo = 0;		

		if ($unidades > 0)
		{
			$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,";
			$insertar = $insertar." campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
			$insertar = $insertar." VALUES(4,19,".$row3["cod_subproducto"].",".$hornada.",0,'".$fecha_r."','".$Lado_Aux."','".$cmbgrupo."',";
			if($cmbgrupo=='8')
			{
			
			
				$cmbfechaaux=substr($cmbfecha,0,strlen($cmbfecha)-1);	
				if(substr($cmbfecha,strlen($cmbfecha)-1,1)=='H'&&$row3["cod_subproducto"]=='8')
					$insertar = $insertar.$unidades.",".$flujo.",'".$cmbfechaaux."',".$peso.",'".$Hora."')";
				
				if(substr($cmbfecha,strlen($cmbfecha)-1,1)=='H'&&$row3["cod_subproducto"]!='8')
					$insertar = $insertar.$unidades.",".$flujo.",'".$cmbfechaaux."',".$peso.",'".$Hora."')";

					
				if(substr($cmbfecha,strlen($cmbfecha)-1,1)=='C'&&$row3["cod_subproducto"]!='8')
					$insertar = $insertar.$unidades.",".$flujo.",'".$cmbfechaaux."',".$peso.",'".$Hora."')";
					
			}
			else
			{  
				$insertar = $insertar.$unidades.",".$flujo.",'".$cmbfecha."',".$peso.",'".$Hora."')";
				
			}
			mysqli_query($link, $insertar);
		}		
	}
	
    $valores = "dia_r=".$dia_r."&mes_r=".$mes_r."&ano_r=".$ano_r."&Proceso=B&cmbgrupo=".$cmbgrupo; 

    header("Location:sea_ing_restos_trasp_raf.php?".$valores); 
	
	include("../principal/cerrar_sea_web.php");
}

?>
