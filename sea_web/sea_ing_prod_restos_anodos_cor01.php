<?php
	include("../principal/conectar_sea_web.php");

	if(isset($_REQUEST["proceso"])) {
		$proceso = $_REQUEST["proceso"];
	}else{
		$proceso = "";
	}
	if(isset($_REQUEST["cmbgrupo"])) {
		$cmbgrupo = $_REQUEST["cmbgrupo"];
	}else{
		$cmbgrupo = "";
	}

	
	$dia1 = $_REQUEST["dia1"];
	$mes1 = $_REQUEST["mes1"];
	$ano1 = $_REQUEST["ano1"];
	$dia2 = $_REQUEST["dia2"];
	$mes2 = $_REQUEST["mes2"];
	$ano2 = $_REQUEST["ano2"];

	$cmblado = $_REQUEST["cmblado"];
	$Hora = $_REQUEST["Hora"];
	$Minutos = $_REQUEST["Minutos"];
	$Hora2 = $_REQUEST["Hora2"];
	$Minutos2 = $_REQUEST["Minutos2"];

	$txttotalunid = $_REQUEST["txttotalunid"];
	$txtpesohm = $_REQUEST["txtpesohm"];
	$txtpesocor = $_REQUEST["txtpesocor"];

	if ($proceso == "B")
	{
		//Obtiene el lado cargado (Mar  Tierra) del grupo seleccionado. (el ms antiguo).
		$consulta = "SELECT campo1, fecha_movimiento,hora FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND numero_recarga = 0 AND campo1 IN ('M','T','N','S')";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' ORDER BY fecha_movimiento ASC";
		//echo $consulta."<br>";
		$rs9 = mysqli_query($link, $consulta);
		$row9 = mysqli_fetch_array($rs9);
		$Ano=substr($row9["fecha_movimiento"],0,4);
		$Mes=substr($row9["fecha_movimiento"],5,2);
		$Dia=substr($row9["fecha_movimiento"],8,2);
		$Hora2=substr($row9["hora"],11,2);
		$Minutos2=substr($row9["hora"],14,2);
		if($row9["fecha_movimiento"]." 08:00:00"<$row9["hora"])
		{
			$FechaInicio=$row9["fecha_movimiento"]." 08:00:00";
			$FechaTermino =date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano))." 07:59:59";
			$FechaTermino2 =date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano));
			$FechaInicio2=$row9["fecha_movimiento"];
		}
		else
		{
			$FechaInicio2=date("Y-m-d", mktime(1,0,0,$Mes,($Dia -1),$Ano));
			$FechaTermino2 =$row9["fecha_movimiento"];
			$FechaInicio=$FechaInicio2." 08:00:00";
			$FechaTermino =$FechaTermino2." 07:59:59";
		}
		$cmblado = $row9["campo1"];
		
		$linea = "ano2=".substr($row9["fecha_movimiento"],0,4)."&mes2=".substr($row9["fecha_movimiento"],5,2)."&dia2=".substr($row9["fecha_movimiento"],8,2);
		
			
		//Obtiene los valores que representan a los Anodos Ctes.
		$consulta = "SELECT valor_subclase1 AS valor FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002";			
		$rs = mysqli_query($link, $consulta);
			
		$parametros = "";
		$total_unidades = 0;
		$total_peso = 0;		
		while ($row = mysqli_fetch_array($rs))
		{
			//Obtiene las unidades de los Anodos Ctes y su peso.
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidadesmov, IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17";
			$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."' AND cod_subproducto = ".$row["valor"];
			$consulta = $consulta." AND numero_recarga = 0 AND fecha_movimiento between '".$FechaInicio2."' and '".$FechaTermino2."'";
			$consulta = $consulta." and hora between '".$FechaInicio."' and '".$FechaTermino."'";
			//echo $consulta."<br>";			
			
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
					
			//Genera los parametros.
			$parametros = $parametros.$row["valor"]."-".$row1["unidadesmov"]."-".$row1["peso"]."/";			

			$total_peso = $total_peso + $row1["peso"];
			$total_unidades = $total_unidades + $row1["unidadesmov"];		
		}
	
		//Saco el factor asociado al grupo.		
		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2004 AND cod_subclase = '".$cmbgrupo."'";
		$rs3 = mysqli_query($link, $consulta);
		$row3 = mysqli_fetch_array($rs3);
		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2003 AND cod_subclase = ".$row3["valor_subclase1"];
		$rs4 = mysqli_query($link, $consulta);
		$row4 = mysqli_fetch_array($rs4);
	
		//Codigos H.M.
		$consulta = "SELECT valor_subclase2 FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002"; //Colunma de H.M.
		$rs = mysqli_query($link, $consulta);
				
		$valoreshm = "";
		while ($row = mysqli_fetch_array($rs))
		{
			$valoreshm = $valoreshm.$row["valor_subclase2"].","; 
		}
		$valoreshm = substr($valoreshm,0,strlen($valoreshm)-1);
				
		//Obtiene la hornada y las unidades de los Anodos Restos H.M.
		$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidadesmov, IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 19";
		$consulta = $consulta." AND cod_subproducto in (".$valoreshm.") AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$consulta = $consulta." AND numero_recarga = 0 AND fecha_movimiento between '".$FechaInicio2."' and  '".$FechaTermino2."'";
		$consulta = $consulta." and hora between '".$FechaInicio."' and '".$FechaTermino."'";
		//echo $consulta."<br>";
		$rs5 = mysqli_query($link, $consulta);
		$row5 = mysqli_fetch_array($rs5);
				
		$linea = $linea."&parametros=".$parametros."&txttotalunid=".$total_unidades."&txttotalpeso=".$total_peso."&txtfactor=".$row4["valor_subclase1"];
		$linea = $linea."&cmbgrupo=".$cmbgrupo."&cmblado=".$cmblado."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&Hora=".$Hora."&Minutos=".$Minutos."&Hora2=".$Hora2."&Minutos2=".$Minutos2."&mostrar=S";
		$linea = $linea."&txthm1=".$row5["unidadesmov"]."&txthm2=".$row5["peso"];
				
		header("Location:sea_ing_prod_restos_anodos_cor.php?".$linea);
	}	
/******************/	
		
	// TRAE LOS DATOS YA GENERADOS PARA PODER CAMBIAR EL PESO.			
	if ($proceso == "B2")
	{


		$fecha_mov = $ano1.'-'.$mes1.'-'.$dia1; //fecha_produccion.
		$FechaInicio=$fecha_mov." 08:00:00";
		$FechaTermino =date("Y-m-d", mktime(1,0,0,$mes1,($dia1 +1),$ano1))." 07:59:59";
		$FechaTermino2 =date("Y-m-d", mktime(1,0,0,$mes1,($dia1 +1),$ano1));
		$fecha_carga = "";
		$peso_prod = 0;
		
		$consulta = "SELECT SUM(peso) AS peso_prod,	min(fecha_benef) as fecha_benef,hora";
		$consulta = $consulta." FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$consulta = $consulta." AND fecha_movimiento between '".$fecha_mov."' and '".$FechaTermino2."'";
		$consulta = $consulta." and hora between '".$FechaInicio."' and '".$FechaTermino."'";
		$consulta = $consulta." GROUP BY campo2";
		//echo $consulta."<br>";
		$rs6 = mysqli_query($link, $consulta);
		if ($row6 = mysqli_fetch_array($rs6))
		{
			$fecha_carga = $row6["fecha_benef"];
			$fecha_carga2 = $row6["fecha_benef"];
			$peso_prod = $row6[peso_prod];
		}	
		$consulta = "SELECT hora,fecha_movimiento FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$consulta = $consulta." AND fecha_movimiento= '".$fecha_carga."'";
		//echo $consulta."<br>";
		$rs6 = mysqli_query($link, $consulta);
		if ($row6 = mysqli_fetch_array($rs6))
		{
			$Hora2=substr($row6["hora"],11,2);
			$Minutos2=substr($row6["hora"],14,2);
			$Ano=substr($row6["fecha_movimiento"],0,4);
			$Mes=substr($row6["fecha_movimiento"],5,2);
			$Dia=substr($row6["fecha_movimiento"],8,2);
			if($row6["fecha_movimiento"]." 08:00:00"<$row6["hora"])
			{
				$fecha_carga = $row6["fecha_movimiento"];
				$FechaInicio=$fecha_carga." 08:00:00";
				$FechaTermino =date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano))." 07:59:59";
				$FechaTermino2 =date("Y-m-d", mktime(1,0,0,$Mes,($Dia +1),$Ano));
			}
			else
			{
				$fecha_carga = $row6["fecha_movimiento"];
				$fecha_carga =date("Y-m-d", mktime(1,0,0,$Mes,($Dia -1),$Ano));
				$FechaInicio=$fecha_carga." 08:00:00";
				$FechaTermino =$row6["fecha_movimiento"]." 07:59:59";
				$FechaTermino2 =$row6["fecha_movimiento"];
			}	
		}	
										
		//Obtiene los valores que representan a los Anodos Ctes.
		$consulta = "SELECT valor_subclase1 AS valor FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002";			
		$rs = mysqli_query($link, $consulta);
			
		$parametros = "";
		$total_unidades = 0;
		$total_peso = 0;		
		while ($row = mysqli_fetch_array($rs))
		{
			//Obtiene las unidades de los Anodos Ctes y su peso.
			$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidadesmov, IFNULL(SUM(peso),0) AS peso";
			$consulta = $consulta." FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17";
			$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."' AND cod_subproducto = ".$row["valor"];
			$consulta = $consulta." AND fecha_movimiento between '".$fecha_carga."' and '".$FechaTermino2."' AND numero_recarga = 1";
			$consulta = $consulta." and hora between '".$FechaInicio."' and '".$FechaTermino."'";
			//echo $consulta."<br>";			
			
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
					
			//Genera los parametros.
			$parametros = $parametros.$row["valor"]."-".$row1["unidadesmov"]."-".$row1["peso"]."/";			
					
			$total_peso = $total_peso + $row1["peso"];
			$total_unidades = $total_unidades + $row1["unidadesmov"];		
		}
		//Saco el factor asociado al grupo.		
		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2004 AND cod_subclase = '".$cmbgrupo."'";
		$rs3 = mysqli_query($link, $consulta);
		$row3 = mysqli_fetch_array($rs3);
		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2003 AND cod_subclase = ".$row3["valor_subclase1"];
		$rs4 = mysqli_query($link, $consulta);
		$row4 = mysqli_fetch_array($rs4);
	
		//Codigos H.M.
		$consulta = "SELECT valor_subclase2 FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002"; //Colunma de H.M.
		$rs = mysqli_query($link, $consulta);
				
		$valoreshm = "";
		while ($row = mysqli_fetch_array($rs))
		{
			$valoreshm = $valoreshm.$row["valor_subclase2"].","; 
		}
		$valoreshm = substr($valoreshm,0,strlen($valoreshm)-1);
				
		//Obtiene la hornada y las unidades de los Anodos Restos H.M.
		$consulta = "SELECT IFNULL(SUM(unidades),0) AS unidadesmov, IFNULL(SUM(peso),0) AS peso";
		$consulta = $consulta." FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 19";
		$consulta = $consulta." AND cod_subproducto in (".$valoreshm.") AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$consulta = $consulta." AND fecha_movimiento between '".$fecha_carga."' and '".$FechaTermino2."' AND numero_recarga = 1";
		$consulta = $consulta." and hora between '".$FechaInicio."' and '".$FechaTermino."'";
		
		$rs5 = mysqli_query($link, $consulta);
		$row5 = mysqli_fetch_array($rs5);						

		$peso_cor = 0;
		$peso_hm = 0;
		
		if (($total_peso != 0) and ($row5["peso"] != 0))
		{
			$peso_cor = round($peso_prod * (100 - $row4["valor_subclase1"]) / 100);
			$peso_hm  = round(($peso_prod * $row4["valor_subclase1"]) / 100);
		}
		else if (($total_peso == 0) and ($row5["peso"] != 0))
			{
				$peso_cor = 0; 
				$peso_hm =  $peso_prod;
			}
			else if (($total_peso != 0) and ($row5["peso"] == 0))			
				{
					$peso_cor = $peso_prod; 
					$peso_hm =  0;
				}	
				
/*		echo "ano: ".substr($fecha_carga,0,4);
		echo "mes: ".substr($fecha_carga,5,2);
		echo "ano: ".substr($fecha_carga,8,2);
*/							
		$linea = $linea."&parametros=".$parametros."&txttotalunid=".$total_unidades."&txttotalpeso=".$total_peso."&txtfactor=".$row4["valor_subclase1"];
		$linea = $linea."&cmbgrupo=".$cmbgrupo."&cmblado=".$cmblado."&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&Hora=".$Hora."&Minutos=".$Minutos."&mostrar=S";
		$linea = $linea."&ano2=".substr($fecha_carga2,0,4)."&mes2=".substr($fecha_carga2,5,2)."&dia2=".substr($fecha_carga2,8,2);
		$linea = $linea."&Hora2=".$Hora2."&Minutos2=".$Minutos2;
		$linea = $linea."&txthm1=".$row5["unidadesmov"]."&txthm2=".$row5["peso"]."&cambiarboton=S";
		$linea = $linea."&txtpesoprod=".$peso_prod."&txtpesocor=".$peso_cor."&txtpesohm=".$peso_hm;
				
		header("Location:sea_ing_prod_restos_anodos_cor.php?".$linea);		
		
	}
			

/******************/

	
	if ($proceso == "G")
	{
        //*******************************************************************************//
        	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
         	$valida_fecha_movimiento = $ano1.'-'.$mes1.'-'.$dia1;
	        include("sea_valida_mes.php");
        //*******************************************************************************//		
	
		$fecha = $ano1.'-'.$mes1.'-'.$dia1;
		$fecha_hora = $ano1."-".$mes1."-".$dia1." ".$Hora.":".$Minutos;
		$fecha_carga = $ano2."-".$mes2."-".$dia2;
		$fecha_carga_hora = $ano2."-".$mes2."-".$dia2." ".$Hora2.":".$Minutos2;
		//echo $fecha_carga."<br>";
		//echo $fecha_carga_hora."<br>";
		if($fecha_carga." 08:00:00"<$fecha_carga_hora)
		{
			$FechaInicio=$fecha_carga." 08:00:00";
			$FechaTermino =date("Y-m-d", mktime(1,0,0,$mes2,($dia2 +1),$ano2))." 07:59:59";
			$FechaTermino2 =date("Y-m-d", mktime(1,0,0,$mes2,($dia2 +1),$ano2));
		}
		else
		{
			$FechaTermino2 =$fecha_carga;
			$FechaTermino =$fecha_carga." 07:59:59";
			$fecha_carga=date("Y-m-d", mktime(1,0,0,$mes2,($dia2 -1),$ano2));
			$FechaInicio=$fecha_carga." 08:00:00";
		}
		//echo $fecha_carga."<br>";
		//Valida que no se haga produccion el mismo dia de un grupo.
		$consulta = "SELECT * FROM sea_web.movimientos ";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND fecha_movimiento = '".$fecha."'";
		$consulta = $consulta." AND campo1 IN ('M','T','N','S') AND campo2 = '".$cmbgrupo."'";
		$rs20 = mysqli_query($link, $consulta);
		
		if ($row20 = mysqli_fetch_array($rs20))
		{
			//Ya existe produccion.
			header("Location:sea_ing_prod_restos_anodos_cor.php?existe=S&grupo=".$cmbgrupo."&fecha=".$dia1."-".$mes1."-".$ano1);
			//break;
		}
		//if($cmbgrupo==49)
		//	$cmblado=1;
	
		//Se concatena con la hornada, lo cual genera una hornada unica en la tabla.
		if (strlen($mes1) == 1) 
			$mes1 = "0".$mes1;
		$ano_mes = $ano1.$mes1;			
			
	
		//GENERA LA HORNADA RESTOS CTES.		
		
		$parametros = "";						
		if ($txttotalunid != 0)
			$prom_ctte = number_format($txtpesocor / $txttotalunid, 3 ,".", ""); 
		if ($txtpesohm != 0)
			$prom_hm = number_format($txtpesohm / $txthm1, 3 ,".", ""); 
			
		//echo $prom_ctte."<br>";
		//echo $prom_hm."<br>"; 				
		
		//Busca los productos que son Anodos Ctes.
		$consulta = "SELECT valor_subclase1 AS valor FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002";	
		$rs2 = mysqli_query($link, $consulta);

		while ($row2 = mysqli_fetch_array($rs2))
		{
			//Bucsca la hornada + 1, de Restos Ctes.
			$consulta = "SELECT MAX(case when length(substring(hornada_ventana,7,6))=4 then concat('00',substring(hornada_ventana,7,6)) else substring(hornada_ventana,7,6) end) AS hornada_max";
			$consulta = $consulta." FROM sea_web.hornadas";
			$consulta = $consulta." WHERE cod_producto = 19 AND cod_subproducto = ".$row2["valor"];
			//echo $consulta."<br>";
			
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			if (is_null($row["hornada_max"]))
			{
				//Busca la Horndada de inicio, Restos Ctes.
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2007 AND cod_subclase = ".$row2["valor"];
				$rs1 = mysqli_query($link, $consulta);
				$row1 = mysqli_fetch_array($rs1);
				$hornada1 = $ano_mes.$row1["valor_subclase1"];			
			}
			else{
				$hornada1 = $ano_mes.$row["hornada_max"] + 1;
			}
				
		
			//echo $hornada1."<br>";
		
			//Busca los movimientos asociados.
			$consulta = "SELECT SUM(unidades) AS unidmov FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17 AND numero_recarga = 0" ;
			$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."' AND cod_subproducto = ".$row2["valor"];
			$consulta = $consulta." AND fecha_movimiento between '".$fecha_carga."' and '".$FechaTermino2."'";
			$consulta = $consulta." and hora between '".$FechaInicio."' and '".$FechaTermino."'";
			//echo $consulta."<br>";						
			
			$rs4 = mysqli_query($link, $consulta);			
			$row4 = mysqli_fetch_array($rs4);
			if (!is_null($row4["unidmov"]))
			{				
				//Busca los movimientos asociados.
				$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17 AND numero_recarga = 0" ;
				$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."' AND cod_subproducto = ".$row2["valor"];
				$consulta = $consulta." AND fecha_movimiento between  '".$fecha_carga."' and '".$FechaTermino2."'";		
				$consulta = $consulta." and hora between '".$FechaInicio."' and '".$FechaTermino."'";		
				//echo "--".$consulta."<br>";	
				$rs3 = mysqli_query($link, $consulta);
				while ($row3 = mysqli_fetch_array($rs3))
				{
					//Busca el flujo Asociado al producto y proceso.
					$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 3 AND cod_producto = 19";
					$consulta = $consulta." AND cod_subproducto = ".$row2["valor"];
					$rs8 = mysqli_query($link, $consulta);
					if ($row8 = mysqli_fetch_array($rs8))
						$flujo = $row8["flujo"];
					else 
						$flujo = 0;
							
					//Asocia los Beneficios a Produccion( Crea los movimientos de Produccion ).	
					$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
					$insertar = $insertar." VALUES (3,19,".$row2["valor"].",".$hornada1.",".$row3["hornada"].",'".$fecha."','".$cmblado;
					$insertar = $insertar."','".$cmbgrupo."',".$row3["unidades"].",".$flujo.",'".$row3["fecha_movimiento"]."',".($row3["unidades"] * $prom_ctte).",'$fecha_hora')";					
					mysqli_query($link, $insertar);
					//echo $insertar."<br>";			
					
					//Actualiza los Beneficio para que no los vuelva a tomar.
					$actualizar = "UPDATE sea_web.movimientos SET numero_recarga = 1 WHERE tipo_movimiento = 2 AND cod_producto = 17 AND numero_recarga = 0";
					$actualizar = $actualizar." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."' AND cod_subproducto = ".$row2["valor"];
					$actualizar = $actualizar." AND hornada = ".$row3["hornada"]." AND unidades = ".$row3["unidades"];
					$actualizar = $actualizar." AND fecha_movimiento = '".$row3["fecha_movimiento"]."'";
					mysqli_query($link, $actualizar);
					//echo $actualizar."<br>";					
				}						
			}
		}
	
	
		//------//
		//Agrega � Resta la diferencia a un registo, el con mas unidades en la produccion.
		$consulta = "SELECT SUM(peso) AS peso_mov, fecha_benef FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha."' AND cod_subproducto <> 30";
		$consulta = $consulta." and hora = '".$fecha_hora."'";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$consulta = $consulta." GROUP BY fecha_movimiento";
		//echo $consulta."<br>";
		
		$rs8 = mysqli_query($link, $consulta);
		$row8 = mysqli_fetch_array($rs8);
		$diferencia = ($txtpesocor - $row8["peso_mov"]);
		/*echo $txtpesocor."<br>";
		echo $row8["peso_mov"]."<br>";
		echo $diferencia."<br>";*/
		$consulta = "SELECT * FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha."' AND fecha_benef = '".$row8["fecha_benef"]."'";
		$consulta = $consulta." and hora = '".$fecha_hora."'";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."' AND cod_subproducto <> 30";		 
		$consulta = $consulta." ORDER BY peso DESC";
		//echo $consulta."<br>";
		
		$rs9 = mysqli_query($link, $consulta);
		if ($row9 = mysqli_fetch_array($rs9))
		{
			$actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$diferencia.")";
			$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$row9["cod_subproducto"];
			$actualizar = $actualizar." AND hornada = ".$row9["hornada"]." AND numero_recarga = ".$row9["numero_recarga"];
			$actualizar = $actualizar." AND fecha_movimiento = '".$row9["fecha_movimiento"]."'";
			$actualizar = $actualizar." AND campo1 = '".$row9["campo1"]."' AND campo2 = '".$row9["campo2"]."' AND unidades = ".$row9["unidades"];
			$actualizar = $actualizar." AND fecha_benef = '".$row9["fecha_benef"]."' AND peso = '".$row9["peso"]."'";
			//echo $actualizar."<br>";
			mysqli_query($link, $actualizar);						
		}	
		//------//
		
	
		//CREA LAS HORNADAS DE LOS RESTOS CTES EN LA TABLA HORNADAS.
		$FecIni=$fecha_carga;
		$FecTer=date("Y-m-d", mktime(1,0,0,$mes2,($dia2 +1),$ano2));
		$FecIniHora=$fecha_carga." 08:00:00";
		$FecTerHora=date("Y-m-d", mktime(1,0,0,$mes2,($dia2 +1),$ano2))." 07:59:59";
		
		$consulta = "SELECT cod_subproducto, hornada, SUM(unidades) AS unidades, SUM(peso) AS peso FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$consulta = $consulta." AND fecha_movimiento = '".$fecha."' AND cod_subproducto <> 30";
		$consulta = $consulta." and hora = '".$fecha_hora."'";
		//$consulta = $consulta." AND fecha_movimiento between  '".$FecIni."' and '".$FecTer."' AND cod_subproducto <> 30";
		//$consulta = $consulta." and hora between '".$FecIniHora."' and '".$FecTerHora."'";

		$consulta = $consulta." GROUP BY hornada";
		//echo $consulta."<br>";
		$rs15 = mysqli_query($link, $consulta);
		while ($row15 = mysqli_fetch_array($rs15))
		{
			//Crea la Hornada en la tabla Hornadas (Restos Ctes.).
			$insertar = "INSERT INTO sea_web.hornadas (cod_producto, cod_subproducto, hornada_ventana, unidades, peso_unidades)"; 
			$insertar = $insertar." VALUES (19,".$row15["cod_subproducto"].",'".$row15["hornada"]."',".$row15["unidades"].",".$row15["peso"].")";				
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);

			//Crea parametros para mostrar en el popup.
			$parametros = $parametros.$row15["hornada"].'-'.$row15["unidades"].'-'.$row15["peso"].'/';				
		}	
	
		
	
		//GENERA LA HORNADA RESTOS DE RESTOS DE HOJAS MADRES.

		if ($txthm1 != 0)
		{
			//echo "ACA:".$txthm1;
			//Bucsca la hornada + 1, de Restos de Restos H.M.
			$consulta = "SELECT MAX(case when length(substring(hornada_ventana,7,6))=4 then concat('00',substring(hornada_ventana,7,6)) else substring(hornada_ventana,7,6) end) AS hornada_max";
			$consulta = $consulta." FROM sea_web.hornadas";
			$consulta = $consulta." WHERE cod_producto = 19 AND cod_subproducto = 30";
			$rs4 = mysqli_query($link, $consulta);
			$row4 = mysqli_fetch_array($rs4);
			if (is_null($row4["hornada_max"]))
			{
				//Busca la Horndada de inicio, Restos Ctes.		
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2007 AND cod_subclase = 30";
				$rs5 = mysqli_query($link, $consulta);
				$row5 = mysqli_fetch_array($rs5);
				$hornada2 = $ano_mes.$row5["valor_subclase1"];
			}
			else 
				$hornada2 = $ano_mes.$row4["hornada_max"] + 1;	
	
			//Buscar los codigos de H.M.
			$valores = "";
			$consulta = "SELECT valor_subclase2 AS hm FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002";
			$rs7 = mysqli_query($link, $consulta);			
	
			while ($row7 = mysqli_fetch_array($rs7)) 
			{
				$valores = $valores.$row7[hm].',';
			}
			$valores = substr($valores,0,strlen($valores)-1);
	
			$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 19 AND numero_recarga = 0" ;
			$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."' AND cod_subproducto in (".$valores.")";
			$consulta = $consulta." AND fecha_movimiento between '".$fecha_carga."' and '".$FechaTermino2."'";
			$consulta = $consulta." and hora between '".$FechaInicio."' and '".$FechaTermino."'";
			
			$rs6 = mysqli_query($link, $consulta);
			while ($row6 = mysqli_fetch_array($rs6))
			{
				//Busca el flujo Asociado al producto y proceso.
				$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 3 AND cod_producto = 19";
				$consulta = $consulta." AND cod_subproducto = 30";
				$rs9 = mysqli_query($link, $consulta);
				if ($row9 = mysqli_fetch_array($rs9))
					$flujo = $row9["flujo"];
				else 
					$flujo = 0;
									
				//Asocia los Beneficios a Produccion( Crea los movimientos de Produccion ).	
				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
				$insertar = $insertar." VALUES (3,19,30,".$hornada2.",".$row6["hornada"].",'".$fecha."','".$cmblado;
				$insertar = $insertar."','".$cmbgrupo."',".$row6["unidades"].",".$flujo.",'".$row6["fecha_movimiento"]."',".($row6["unidades"] * $prom_hm).",'$fecha_hora')";
				mysqli_query($link, $insertar);
				
				//Actualiza los Beneficio para que no los vuelva a tomar.
				$actualizar = "UPDATE sea_web.movimientos SET numero_recarga = 1 WHERE tipo_movimiento = 2 AND cod_producto = 19 AND numero_recarga = 0";
				$actualizar = $actualizar." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."' AND cod_subproducto = ".$row6["cod_subproducto"];						
				$actualizar = $actualizar." AND hornada = ".$row6["hornada"]." AND unidades = ".$row6["unidades"];
				$actualizar = $actualizar." AND fecha_movimiento = '".$row6["fecha_movimiento"]."'";
				mysqli_query($link, $actualizar);			
			}

			//Crea la Hornada en la tabla Hornadas (Restos de Restos H.M.).
			$insertar = "INSERT INTO sea_web.hornadas (cod_producto, cod_subproducto, hornada_ventana, unidades, peso_unidades)";
			$insertar = $insertar." VALUES (19,30,".$hornada2.",".$txthm1.",".$txtpesohm.")";
			mysqli_query($link, $insertar);
	
			//------//
			//Agrega � Resta la diferencia a un registo, el con mas unidades en la produccion.
			$consulta = "SELECT SUM(peso) AS peso_mov FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha."' AND hornada = ".$hornada2;
			$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
			$rs8 = mysqli_query($link, $consulta);
			$row8 = mysqli_fetch_array($rs8);
			$diferencia = $txtpesohm - $row8["peso_mov"];
			
			$consulta = "SELECT * FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha."' AND hornada = ".$hornada2;
			$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";		 
			
			$rs9 = mysqli_query($link, $consulta);
			if ($row9 = mysqli_fetch_array($rs9))
			{
				$actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$diferencia.")";
				$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$row9["cod_subproducto"];
				$actualizar = $actualizar." AND hornada = ".$row9["hornada"]." AND numero_recarga = ".$row9["numero_recarga"];
				$actualizar = $actualizar." AND fecha_movimiento = '".$row9["fecha_movimiento"]."'";
				$actualizar = $actualizar." AND campo1 = '".$row9["campo1"]."' AND campo2 = '".$row9["campo2"]."' AND unidades = ".$row9["unidades"];
				$actualizar = $actualizar." AND fecha_benef = '".$row9["fecha_benef"]."' AND peso = '".$row9["peso"]."'";
				//echo $actualizar."<br>";
				//mysqli_query($link, $actualizar);						
			}	
	
			
			$parametros = $parametros.$hornada2.'-'.$txthm1.'-'.$txtpesohm.'/';								
		}
		header("Location:sea_ing_prod_restos_anodos_cor.php?dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&mostrar=S&activar=S&valores=".$parametros);
	}
	
/*****************/
	if ($proceso == "M")
	{
        //*******************************************************************************//
        	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
         	$valida_fecha_movimiento = $fecha_aux;
	        include("sea_valida_mes.php");
        //*******************************************************************************//		
	
		$fecha_mov = $ano1.'-'.$mes1.'-'.$dia1; //Si cambia la fecha
		$fecha_hora = $ano1."-".$mes1."-".$dia1." ".$Hora.":".$Minutos;
		$prom_ctte = 0;
		$prom_hm = 0;
		
		if ($txttotalunid != 0)
			$prom_ctte = number_format($txtpesocor / $txttotalunid, 3 ,".", ""); 
		if ($txtpesohm != 0)
			$prom_hm = number_format($txtpesohm / $txthm1, 3 ,".", ""); 
			
		//echo $prom_ctte."<br>";
		//echo $prom_hm."<br>";
		

		//Actualiza los pesos y fecha_movimiento en los movimientos de produccion.
		$consulta = "SELECT * ";
		$consulta = $consulta." FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$consulta = $consulta." AND fecha_movimiento = '".$fecha_aux."'";		
		$rs1 = mysqli_query($link, $consulta);		
		//echo $consulta."<br>";

		
		while ($row1 = mysqli_fetch_array($rs1))
		{
			if ($row1["cod_subproducto"] != 30)
			{
				$actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$prom_ctte."), fecha_movimiento = '".$fecha_mov."',hora='$fecha_hora' ";
				$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$row1["cod_subproducto"];
				$actualizar = $actualizar." AND hornada = ".$row1["hornada"]." AND fecha_movimiento = '".$row1["fecha_movimiento"]."'";
				$actualizar = $actualizar." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
				mysqli_query($link, $actualizar);
				//echo $actualizar."<br>";								
			}
			else 
			{
				$actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$prom_hm."), fecha_movimiento = '".$fecha_mov."',hora='$fecha_hora' ";
				$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$row1["cod_subproducto"];
				$actualizar = $actualizar." AND hornada = ".$row1["hornada"]." AND fecha_movimiento = '".$row1["fecha_movimiento"]."'";				
				$actualizar = $actualizar." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";				
				mysqli_query($link, $actualizar);
				//echo $actualizar."<br>";				
			}
		}
			
//--------/
		//Para producto externo.
		//Agrega � Resta la diferencia a un registo, el con mas unidades en la produccion.
		$consulta = "SELECT SUM(peso) AS peso_mov, fecha_benef FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha_mov."' AND cod_subproducto <> 30";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$consulta = $consulta." GROUP BY fecha_movimiento";
		//echo $consulta."<br>";
		$rs8 = mysqli_query($link, $consulta);
		if ($row8 = mysqli_fetch_array($rs8))
		{
			$diferencia = $txtpesocor - $row8["peso_mov"];
			
			$consulta = "SELECT * FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha_mov."' and fecha_benef = '".$row8["fecha_benef"]."'";
			$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."' AND cod_subproducto <> 30";
			$consulta = $consulta." ORDER BY peso DESC";
			//echo $consulta."<br>";			
			
			$rs9 = mysqli_query($link, $consulta);
			if ($row9 = mysqli_fetch_array($rs9))
			{
				$actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$diferencia.")";
				$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$row9["cod_subproducto"];
				$actualizar = $actualizar." AND hornada = ".$row9["hornada"]." AND numero_recarga = ".$row9["numero_recarga"];
				$actualizar = $actualizar." AND fecha_movimiento = '".$row9["fecha_movimiento"]."'";
				$actualizar = $actualizar." AND campo1 = '".$row9["campo1"]."' AND campo2 = '".$row9["campo2"]."' AND unidades = ".$row9["unidades"];
				$actualizar = $actualizar." AND fecha_benef = '".$row9["fecha_benef"]."' AND peso = '".$row9["peso"]."'";
				//echo $actualizar."<br>";
				mysqli_query($link, $actualizar);						
			}					
		}
		
		//Para Resto de Resto.
		$consulta = "SELECT SUM(peso) AS peso_mov, hornada FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha_mov."' AND cod_subproducto = 30";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$consulta = $consulta." GROUP BY hornada";
		$rs8 = mysqli_query($link, $consulta);
		if ($row8 = mysqli_fetch_array($rs8))
		{
			$diferencia = $txtpesohm - $row8["peso_mov"];
			
			$consulta = "SELECT * FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha_mov."' AND hornada = ".$row8["hornada"];
			$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";		 
			
			$rs9 = mysqli_query($link, $consulta);
			if ($row9 = mysqli_fetch_array($rs9))
			{
				$actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$diferencia.")";
				$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$row9["cod_subproducto"];
				$actualizar = $actualizar." AND hornada = ".$row9["hornada"]." AND numero_recarga = ".$row9["numero_recarga"];
				$actualizar = $actualizar." AND fecha_movimiento = '".$row9["fecha_movimiento"]."'";
				$actualizar = $actualizar." AND campo1 = '".$row9["campo1"]."' AND campo2 = '".$row9["campo2"]."' AND unidades = ".$row9["unidades"];
				$actualizar = $actualizar." AND fecha_benef = '".$row9["fecha_benef"]."' AND peso = '".$row9["peso"]."'";
				//echo $actualizar."<br>";
				mysqli_query($link, $actualizar);						
			}					
		}		
		
//-------/		
		
		//Actualiza los pesos y fecha_benef en los movimientos de traspaso.
		$consulta = "SELECT * ";
		$consulta = $consulta." FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 19";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$consulta = $consulta." AND fecha_benef = '".$fecha_aux."'";		
		$rs2 = mysqli_query($link, $consulta);
		//echo $consulta."<br>";
		
		while ($row2 = mysqli_fetch_array($rs2))
		{
			if ($row2["cod_subproducto"] != 30)
			{		
				$actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$prom_ctte."), fecha_benef = '".$fecha_mov."'";
				$actualizar = $actualizar." WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$row2["cod_subproducto"];
				$actualizar = $actualizar." AND hornada = ".$row2["hornada"]." AND fecha_movimiento = '".$row2["fecha_movimiento"]."'";
				$actualizar = $actualizar." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";				
				mysqli_query($link, $actualizar);
				//echo $actualizar."<br>";
			}
			else
			{
				$actualizar = "UPDATE sea_web.movimientos SET peso = (unidades * ".$prom_hm."), fecha_benef = '".$fecha_mov."'";
				$actualizar = $actualizar." WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$row2["cod_subproducto"];
				$actualizar = $actualizar." AND hornada = ".$row2["hornada"]." AND fecha_movimiento = '".$row2["fecha_movimiento"]."'";
				$actualizar = $actualizar." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";				
				mysqli_query($link, $actualizar);
				//echo $actualizar."<br>";				
			}
		}
		
//--------/
		//Para producto externo.
		//Agrega � Resta la diferencia a un registo, el con mas unidades en los traspasos.
		$consulta = "SELECT SUM(peso) AS peso_mov, hornada FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 4 AND fecha_benef = '".$fecha_mov."' AND cod_subproducto <> 30";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$rs8 = mysqli_query($link, $consulta);
		if ($row8 = mysqli_fetch_array($rs2))
		{
			$diferencia = $txtpesocor - $row8["peso_mov"];
			
			$consulta = "SELECT * FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 4 AND fecha_benef = '".$fecha_mov."' AND hornada = ".$row8["hornada"];
			$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";		 
			$consulta = $consulta." ORDER BY unidades DESC";
			$consulta = $consulta." LIMIT 0,1";
			
			$rs9 = mysqli_query($link, $consulta);
			if ($row9 = mysqli_fetch_array($rs9))
			{
				$actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$diferencia.")";
				$actualizar = $actualizar." WHERE tipo_movimiento = 4 AND cod_producto = 19 AND cod_subproducto = ".$row9["cod_subproducto"];
				$actualizar = $actualizar." AND hornada = ".$row9["hornada"]." AND numero_recarga = ".$row9["numero_recarga"];
				$actualizar = $actualizar." AND fecha_movimiento = '".$row9["fecha_movimiento"]."'";
				$actualizar = $actualizar." AND campo1 = '".$row9["campo1"]."' AND campo2 = '".$row9["campo2"]."' AND unidades = ".$row9["unidades"];
				$actualizar = $actualizar." AND fecha_benef = '".$row9["fecha_benef"]."' AND peso = '".$row9["peso"]."'";
				//echo $actualizar."<br>";
				mysqli_query($link, $actualizar);						
			}					
		}
		
		//Para Resto de Resto.
		$consulta = "SELECT SUM(peso) AS peso_mov, hornada FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha_mov."' AND cod_subproducto = 30";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$rs8 = mysqli_query($link, $consulta);
		if ($row8 = mysqli_fetch_array($rs2))
		{
			$diferencia = $txtpesohm - $row8["peso_mov"];
			
			$consulta = "SELECT * FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha_mov."' AND hornada = ".$row8["hornada"];
			$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";		 
			$consulta = $consulta." ORDER BY unidades DESC";
			
			$rs9 = mysqli_query($link, $consulta);
			if ($row9 = mysqli_fetch_array($rs9))
			{
				$actualizar = "UPDATE sea_web.movimientos SET peso = (peso + ".$diferencia.")";
				$actualizar = $actualizar." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$row9["cod_subproducto"];
				$actualizar = $actualizar." AND hornada = ".$row9["hornada"]." AND numero_recarga = ".$row9["numero_recarga"];
				$actualizar = $actualizar." AND fecha_movimiento = '".$row9["fecha_movimiento"]."'";
				$actualizar = $actualizar." AND campo1 = '".$row9["campo1"]."' AND campo2 = '".$row9["campo2"]."' AND unidades = ".$row9["unidades"];
				$actualizar = $actualizar." AND fecha_benef = '".$row9["fecha_benef"]."' AND peso = '".$row9["peso"]."'";
				//echo $actualizar."<br>";
				mysqli_query($link, $actualizar);						
			}					
		}		
		
//-------/		
		
				
		//Actualiza unidades y peso en la tabla hornada.
		$consulta = "SELECT cod_subproducto, hornada, SUM(unidades) AS unidades, SUM(peso) AS peso";
		$consulta = $consulta." FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19";
		$consulta = $consulta." AND campo2 = '".$cmbgrupo."' AND campo1 = '".$cmblado."'";
		$consulta = $consulta." AND fecha_movimiento = '".$fecha_aux."'";
		$consulta = $consulta." GROUP BY cod_subproducto, hornada";
		$rs = mysqli_query($link, $consulta);
		//echo $consulta."<br>";
				
		while ($row = mysqli_fetch_array($rs))
		{
			$actualizar = "UPDATE sea_web.hornadas SET unidades = ".$row["unidades"].", peso_unidades = ".$row["peso"]; 
			$actualizar = $actualizar." WHERE cod_producto = 19 AND cod_subproducto = ".$row["cod_subproducto"];
			$actualizar = $actualizar." AND hornada_ventana = ".$row["hornada"];
			mysqli_query($link, $actualizar);
			//echo $actualizar."<br>";
		}		
				
		header("Location:sea_ing_prod_restos_anodos_cor.php");
	}	
	
	if ($proceso == "E")
	{
        //*******************************************************************************//
        	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
         	$valida_fecha_movimiento = $fecha_aux;
	        include("sea_valida_mes.php");
        //*******************************************************************************//	

		$FechaInicio=$fecha_aux." 08:00:00";
		$FechaTermino =date("Y-m-d", mktime(1,0,0,$mes1,($dia1 +1),$ano1));
		$FechaTermino2 =date("Y-m-d", mktime(1,0,0,$mes1,($dia1 +1),$ano1))." 07:59:59";
		//echo $Hora2."<br>";
		//echo $Minutos2."<br>";
		if($ano2."-".$mes2."-".$dia2." 08:00:00"<$ano2."-".$mes2."-".$dia2." ".$Hora2.":".$Minutos2)
		{
			$fecha_carga  = $ano2."-".$mes2."-".$dia2;
			$fecha_carga1 = date("Y-m-d", mktime(1,0,0,$mes2,($dia2 +1),$ano2));
			$hora_carga = $fecha_carga." 08:00:00";
			$hora_carga1 = date("Y-m-d", mktime(1,0,0,$mes2,($dia2 +1),$ano2))." 07:59:59";
		}
		else
		{
			$fecha_carga  = date("Y-m-d", mktime(1,0,0,$mes2,($dia2 -1),$ano2));
			$fecha_carga1 = $ano2."-".$mes2."-".$dia2;;
			$hora_carga = $fecha_carga." 08:00:00";
			$hora_carga1 = date("Y-m-d", mktime(1,0,0,$mes2,($dia2 +1),$ano2))." 07:59:59";
		}	
		//Borrar en la tabla Hornadas.
		$consulta = "SELECT DISTINCT cod_producto, cod_subproducto, hornada";
		$consulta = $consulta." FROM sea_web.movimientos ";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND fecha_movimiento between  '".$fecha_aux."' and '".$FechaTermino."' AND campo2 =  '".$cmbgrupo."'";
		$consulta = $consulta." and hora between '".$FechaInicio."' and '".$FechaTermino2."'";
		$consulta = $consulta." AND campo1 = '".$cmblado."' AND fecha_benef between '".$fecha_carga."' and '".$fecha_carga1."'";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			$eliminar = "DELETE FROM sea_web.hornadas";
			$eliminar = $eliminar." WHERE cod_producto = ".$row["cod_producto"];
			$eliminar = $eliminar." AND cod_subproducto = ".$row["cod_subproducto"]." AND hornada_ventana = ".$row["hornada"];
			mysqli_query($link, $eliminar);
			//echo $eliminar."<br>";
		}

		//Actualiza Movimientos de Benefio.
		$actualizar = "UPDATE sea_web.movimientos SET numero_recarga = 0";
		$actualizar = $actualizar." WHERE tipo_movimiento = 2 AND fecha_movimiento between  '".$fecha_carga."' and '".$fecha_carga1."' AND campo2 = '".$cmbgrupo."'";
		$actualizar = $actualizar." and hora between '".$hora_carga."' and '".$hora_carga1."'";
		$actualizar = $actualizar." AND campo1 = '".$cmblado."' AND numero_recarga = 1";
		mysqli_query($link, $actualizar);
		//echo $actualizar."<br>";
		
		//Elimina Movimientos de Produccion.
		$eliminar = "DELETE FROM sea_web.movimientos";
		$eliminar = $eliminar." WHERE tipo_movimiento = 3 AND fecha_movimiento = '".$fecha_aux."' and '".$FechaTermino."' AND campo2 =  '".$cmbgrupo."'";
		$eliminar = $eliminar."	and hora between '".$FechaInicio."' and '".$FechaTermino2."'";
		$eliminar = $eliminar." AND campo1 = '".$cmblado."' AND fecha_benef between '".$fecha_carga."' and '".$fecha_carga1."'";
		mysqli_query($link, $eliminar);
		//echo $eliminar."<br>";
		
		//Elimina Movimientos de Traspaso.
		$eliminar = "DELETE FROM sea_web.movimientos";
		$eliminar = $eliminar." WHERE tipo_movimiento = 4 AND fecha_benef = '".$fecha_aux."'  and '".$FechaTermino."'  AND campo2 = '".$cmbgrupo."'";	
		$eliminar = $eliminar."	and hora between '".$FechaInicio."' and '".$FechaTermino2."'";
		$eliminar = $eliminar." AND campo1 = '".$cmblado."'";
		mysqli_query($link, $eliminar);
		//echo $eliminar."<br>";
				
		header("Location:sea_ing_prod_restos_anodos_cor.php");				
	}
	
	include("../principal/cerrar_sea_web.php");
?>