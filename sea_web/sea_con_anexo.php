<?php
$CodigoDeSistema = 16;
$CodigoDePantalla = 1;
include("../principal/conectar_principal.php");

if(isset($_REQUEST["Ano"])){
	$Ano = $_REQUEST["Ano"];
}else{
	$Ano = date("Y");
}
if(isset($_REQUEST["Mes"])){
	$Mes = $_REQUEST["Mes"];
}else{
	$Mes = date("m");
}

if(isset($_REQUEST["Mostrar"])){
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar = "";
}

/*
if (!isset($Ano))
	$Ano = date("Y");
if (!isset($Mes))
	$Mes = date("n");	
*/
if ($Mostrar == "S")
{
	//************************************** FLUJOS ********************************************	
	$Consulta = "SELECT * FROM sea_web.existencia_nodo";
	$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."'";
	$Consulta.= " AND bloqueado = '1'";
	//$Consulta.= " AND bloqueado = '0'";
	$Resp2 = mysqli_query($link, $Consulta);
	if (!$Fila2 = mysqli_fetch_array($Resp2))
	{
	
		//PROCESO
		$Unidades = array('02'=>100,'04'=>1000,'05'=>1000);
		$Fecha_Ini = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
		$Fecha_Ini_Hora = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01 08:00:00";
		//$Fecha_Ter = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-31";
		$Dias=date("d",(mktime(0,0,0,$Mes+1,1,$Ano)-1)); 
		if($Mes==12)
		{
			$Fecha_Ter = ($Ano+1)."-".str_pad(1,2,"0",STR_PAD_LEFT)."-03";
			$Fecha_Ter_Hora = ($Ano+1)."-".str_pad(1,2,"0",STR_PAD_LEFT)."-01 07:59:59";
			$Fecha_Ter2 = $Ano."-".str_pad(($Mes),"0",STR_PAD_LEFT)."-".$Dias;	
			/*if($Mes=='9'||$Mes=='11')
				$Fecha_Ter2 = $Ano."-".str_pad(($Mes),"0",STR_PAD_LEFT)."-".$Dias;
			else
				$Fecha_Ter2 = $Ano."-".str_pad(($Mes),"0",STR_PAD_LEFT)."-".$Dias;*/
			
		}	
		else
		{
			//echo "MES:".$Mes."<br>";
			$Fecha_Ter = $Ano."-".str_pad(($Mes+1),"0",STR_PAD_LEFT)."-01";
			//$Fecha_Ter2 = $Ano."-".str_pad(($Mes),"0",STR_PAD_LEFT)."-31";
			$Fecha_Ter2 = $Ano."-".str_pad(($Mes),"0",STR_PAD_LEFT)."-".$Dias;	
			/*if($Mes=='9'||$Mes=='11')
				$Fecha_Ter2 = $Ano."-".str_pad(($Mes),"0",STR_PAD_LEFT)."-30";
			else
				$Fecha_Ter2 = $Ano."-".str_pad(($Mes),"0",STR_PAD_LEFT)."-31";*/

			$Fecha_Ter_Hora = $Ano."-".str_pad(($Mes+1),"0",STR_PAD_LEFT)."-01 07:59:59";
		}	
		//Obtiene los todos flujos
		$Consulta = "SELECT * FROM proyecto_modernizacion.flujos WHERE sistema = 'SEA' and esflujo<>'N' ";
		$Consulta.= " ORDER BY cod_flujo";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			//Borra el Registro Existente
			$Eliminar = "DELETE FROM sea_web.stock_anexo";
			$Eliminar.= " WHERE mes = '".$Mes."'";
			$Eliminar.= " AND ano = '".$Ano."'";
			$Eliminar.= " AND flujo = '".$Fila["cod_flujo"]."'";
			mysqli_query($link, $Eliminar);
			
			//Consulta si el flujo representa el movimiento de beneficio
			$Consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo";
			$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
			$Resp3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Resp3))
			{
				if ($Fila3["cod_proceso"] == 2)
				{
					//Consulto el peso total por el flujo, considerando tambien fecha_benef
					$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
					$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
					$Consulta.= " AND ((fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."' and hora between '$Fecha_Ini_Hora' and '$Fecha_Ter_Hora' AND fecha_benef = '0000-00-00')";
					$Consulta.= " OR (fecha_benef BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'))";
					$Beneficio = "S";
				}
				else
				{
					$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
					$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
					$Consulta.= " AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."' and hora between '$Fecha_Ini_Hora' and '$Fecha_Ter_Hora' ";
					$Beneficio = "N";
				}
			}
			else
			{
				//Consulto el peso total por el flujo
				$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos";
				$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
				$Consulta.= " AND fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."' and hora between '$Fecha_Ini_Hora' and '$Fecha_Ter_Hora' ";
				$Beneficio = "N";
			}
			$Resp4 = mysqli_query($link, $Consulta);
			$Fila4 = mysqli_fetch_array($Resp4);
			//Consulto el en stock_piso_raf
			$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.stock_piso_raf";
			$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
			$Consulta.= " AND fecha BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
			$Resp5 = mysqli_query($link, $Consulta);
			$Fila5 = mysqli_fetch_array($Resp5);
				//if ($Fila["cod_flujo"]=='406')
				//	echo $Consulta."<br>";	
			//Consulto el en stock_piso_raf, del mes pasado.
			$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.stock_piso_raf";
			$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
			$Consulta.= " AND fecha BETWEEN SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)";
			$Consulta.= " AND SUBDATE('".$Fecha_Ter2."', INTERVAL 1 MONTH)";
			$Resp6 = mysqli_query($link, $Consulta);
			$Fila6 = mysqli_fetch_array($Resp6);
				//if ($Fila["cod_flujo"]=='406')
				//	echo $Consulta."<br>";	
			//Graba el Registro
			$Insertar = "INSERT INTO sea_web.stock_anexo (ano,mes,flujo,peso)";
			$Insertar.= " VALUES ('".$Ano."'";
			$Insertar.= ",'".$Mes."'";
			$Insertar.= ",'".$Fila["cod_flujo"]."'";
			$Insertar.= ",'".($Fila4["peso"] - $Fila5["peso"] + $Fila6["peso"])."')";			
			mysqli_query($link, $Insertar);
				//if ($Fila["cod_flujo"]=='406')
				//	echo $Insertar."<br>";			
			$PesoFlujoPiso=$Fila4["peso"] - $Fila5["peso"] + $Fila6["peso"];	
			$PesoFlujo = $Fila4["peso"] + $Fila6["peso"];
			$PesoFlujoTotal = 0;
			//$PesoFlujoTo tal = $Fila4["peso"] - $Fila5["peso"] + $Fila6["peso"];
			
			$Codigos = array('02'=>0,'04'=>0,'05'=>0);
			$Pesos = array('02'=>0,'04'=>0,'05'=>0);
			if ($Beneficio == "S")
			{
				$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada,";
				$Consulta.= " sum(t1.peso) AS peso_hornada";
				$Consulta.= " FROM sea_web.movimientos AS t1";
				$Consulta.= " WHERE t1.flujo = '".$Fila["cod_flujo"]."'";
				$Consulta.= " AND ((t1.fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."' and hora between '$Fecha_Ini_Hora' and '$Fecha_Ter_Hora' ";
				$Consulta.= " AND t1.fecha_benef = '0000-00-00')";
				$Consulta.= " OR (t1.fecha_benef BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'))";
				$Consulta.= " GROUP BY t1.hornada";
			}
			else
			{
				$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada,";
				$Consulta.= " sum(t1.peso) AS peso_hornada";
				$Consulta.= " FROM sea_web.movimientos AS t1";
				$Consulta.= " WHERE t1.flujo = '".$Fila["cod_flujo"]."'";
				$Consulta.= " AND t1.fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."' and hora between '$Fecha_Ini_Hora' and '$Fecha_Ter_Hora' ";
				$Consulta.= " GROUP BY t1.hornada";
			}
			$Resp7 = mysqli_query($link, $Consulta);//$PesoFlujoPisoTot=0;
				//if ($Fila["cod_flujo"]=='123')
				//	echo $Consulta."<br>";
			while ($Fila7 = mysqli_fetch_array($Resp7))		
			{
				//STOCK PISO RAF
				//$PesoFlujoPisoTot=0;
				$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso_piso FROM sea_web.stock_piso_raf";
				$Consulta.= " where cod_producto='".$Fila7["cod_producto"]."' ";
				$Consulta.= " and cod_subproducto='".$Fila7["cod_subproducto"]."' ";
				$Consulta.= " and hornada='".$Fila7["hornada"]."'";
				$Consulta.= " AND fecha BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'";
				$Consulta.= " AND flujo='".$Fila["cod_flujo"]."'";
				$RespPiso = mysqli_query($link, $Consulta);
				//if ($Fila["cod_flujo"]=='406')
				//	echo $Consulta."<br>";
				if ($FilaPiso = mysqli_fetch_array($RespPiso))
					$PesoPiso = $FilaPiso["peso_piso"];
				else
					$PesoPiso = 0;
				//$PesoFlujoPisoTot=$PesoPiso;	
				$Consulta = "select * from sea_web.leyes_por_hornada ";
				$Consulta.= " where cod_producto='".$Fila7["cod_producto"]."' ";
				$Consulta.= " and cod_subproducto='".$Fila7["cod_subproducto"]."' ";
				$Consulta.= " and hornada='".$Fila7["hornada"]."'";
				$Consulta.= " and cod_leyes in('02','04','05')";
				$RespLeyes = mysqli_query($link, $Consulta);
				//if ($Fila["cod_flujo"]=='406')
				//	echo $Consulta."<br>";

				while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
				{
					// aqui cambio - PesoPiso   por + PesoPiso
					$Codigos[$FilaLeyes["cod_leyes"]] = $Codigos[$FilaLeyes["cod_leyes"]] + (($Fila7["peso_hornada"] + $PesoPiso) * $FilaLeyes["valor"] / $Unidades[$FilaLeyes["cod_leyes"]]);					
					$Pesos[$FilaLeyes["cod_leyes"]] = $Pesos[$FilaLeyes["cod_leyes"]] + ($Fila7["peso_hornada"] + $PesoPiso);
					//if($Fila7["hornada"]=='201409943076'||$Fila7["hornada"]=='201410943077')
					//	echo $Fila7["peso_hornada"]." + ".$PesoPiso."<br>";
					//$PesoFlujoPisoTot=$PesoFlujoPisoTot+$Fila7["peso_hornada"]+$PesoPiso;					
				}
				
				$PesoPiso = 0;
			}
			/*if($PesoFlujoPisoTot!=0)
			{
				$Actualizar = "UPDATE sea_web.stock_anexo SET ";
				$Actualizar.= " peso = ".$PesoFlujoPisoTot;
				$Actualizar.= " WHERE mes = '".$Mes."' AND ano = '".$Ano."'";
				$Actualizar.= " AND flujo = '".$Fila["cod_flujo"]."'";
				mysqli_query($link, $Actualizar);
			}*/
						
			$Consulta = "SELECT * FROM sea_web.stock_piso_raf";
			$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
			$Consulta.= " AND fecha BETWEEN SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)";
			$Consulta.= " AND SUBDATE('".$Fecha_Ter."', INTERVAL 1 MONTH)";
			$Resp8 = mysqli_query($link, $Consulta);$PesoFlujoPisoTot=0;
			//if ($Fila["cod_flujo"]=='406')
			//	echo $Consulta."<br>";
			while ($Fila8 = mysqli_fetch_array($Resp8))
			{
				$PesoFlujoPisoTot=0;
				$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.stock_piso_raf";
				$Consulta.= " WHERE flujo = '".$Fila["cod_flujo"]."'";
				$Consulta.= " AND fecha BETWEEN '".$Fecha_Ini."'";
				$Consulta.= " AND '".$Fecha_Ter."'";
				$Consulta.= " AND cod_producto = '".$Fila8["cod_producto"]."'";
				$Consulta.= " AND cod_subproducto = '".$Fila8["cod_subproducto"]."'";
				$Consulta.= " AND hornada = '".$Fila8["hornada"]."'";
				$Resp9 = mysqli_query($link, $Consulta);
				$Fila9 = mysqli_fetch_array($Resp9);
				$Consulta = "SELECT cod_leyes, valor FROM sea_web.leyes_por_hornada";
				$Consulta.= " WHERE cod_producto = '".$Fila8["cod_producto"]."'";
				$Consulta.= " AND cod_subproducto = '".$Fila8["cod_subproducto"]."'";
				$Consulta.= " AND hornada = '".$Fila8["hornada"]."'";
				$Consulta.= " AND cod_leyes IN ('02','04','05')";
				$Resp10 = mysqli_query($link, $Consulta);
			        //if ($Fila["cod_flujo"]=='406')
			        //    echo $PesoFlujoPiso." - ".$Fila8["peso"]." - ".$Fila9["peso"]."<br>";	
				if ($Fila8["peso"] == $Fila9["peso"])
				{
					while ($Fila10 = mysqli_fetch_array($Resp10))
					{						
						$Codigos[$Fila10["cod_leyes"]] = $Codigos[$Fila10["cod_leyes"]] + ($Fila8["peso"] * $Fila10["valor"] / $Unidades[$Fila10["cod_leyes"]]);
						$Pesos[$Fila10["cod_leyes"]] = $Pesos[$Fila10["cod_leyes"]] + $Fila8["peso"];
					}
					$PesoFlujoPisoTot=$Fila8["peso"];	
				}
				else
				{
					while ($Fila10 = mysqli_fetch_array($Resp10))
					{						
						$Codigos[$Fila10["cod_leyes"]] = $Codigos[$Fila10["cod_leyes"]] + (($Fila8["peso"] - $Fila9["peso"]) * $Fila10["valor"] / $Unidades[$Fila10["cod_leyes"]]);
						//echo 	$Pesos[$Fila10["cod_leyes"]]." = ".$Pesos[$Fila10["cod_leyes"]]. "+"."(".$Fila8["peso"]." - ".$Fila9["peso"].")<br>";
						$Pesos[$Fila10["cod_leyes"]] = $Pesos[$Fila10["cod_leyes"]] + ($Fila8["peso"] - $Fila9["peso"]);
										
					}
					$PesoFlujoPisoTot=$PesoFlujoPiso+($Fila8["peso"]- $Fila9["peso"]);
				}
					
			}					
			$LeyCu = 0;
			$LeyAg = 0;
			$LeyAu = 0;
			if ($Pesos["02"]>0 && $Codigos["02"]>0)
				$LeyCu = (($Codigos["02"]/$Pesos["02"])*1);
			if ($Pesos["04"]>0 && $Codigos["04"]>0)
				$LeyAg = (($Codigos["04"]/$Pesos["04"])*1);
			if ($Pesos["05"]>0 && $Codigos["05"]>0)
				$LeyAu = (($Codigos["05"]/$Pesos["05"])*1);   

			//Actualiza el Registro por el Flujo
			if($PesoFlujoPisoTot!=0)
			{
				$Actualizar = "UPDATE sea_web.stock_anexo SET ";
				$Actualizar.= " peso = ".$PesoFlujoPisoTot;
				$Actualizar.= " WHERE mes = '".$Mes."' AND ano = '".$Ano."'";
				$Actualizar.= " AND flujo = '".$Fila["cod_flujo"]."'";
				//mysqli_query($link, $Actualizar);
			}
			$Actualizar = "UPDATE sea_web.stock_anexo SET fino_cu = (peso * ".str_replace(",",".",$LeyCu).")";
			$Actualizar.= ", fino_ag = (peso * ".str_replace(",",".",$LeyAg).")";
			$Actualizar.= ", fino_au = (peso * ".str_replace(",",".",$LeyAu).")";
			$Actualizar.= " WHERE mes = '".$Mes."' AND ano = '".$Ano."'";
			$Actualizar.= " AND flujo = '".$Fila["cod_flujo"]."'";
			mysqli_query($link, $Actualizar);			
		}
		//******************************* NODOS *********************************************			
		//Totales Por Nodo
		$mes_aux = $Mes - 1;
		$ano_aux = $Ano;
		
		if ($mes_aux == 0)
		{
			$mes_aux = 12;
			$ano_aux = $Ano - 1;
		}
		$FechaIni = $Ano."-".$Mes."-01";
		$FechaFin = $Ano."-".$Mes."-31";
		
		//Elimino las existencia de los nodos
		$Eliminar = "DELETE FROM sea_web.existencia_nodo";
		$Eliminar.= " WHERE  ano = '".$Ano."' AND mes = '".$Mes."'";
		mysqli_query($link, $Eliminar);
		$Copiar = "S";		
			
		$Consulta = "SELECT DISTINCT t1.nodo FROM proyecto_modernizacion.flujos t1";
		$Consulta.= " inner join proyecto_modernizacion.nodos t2 on t1.nodo=t2.cod_nodo";
		$Consulta.= " WHERE t1.sistema = 'SEA' and t2.virtual<>'S' ORDER BY nodo";
		$Resp1 = mysqli_query($link, $Consulta);
		while ($Fila1 = mysqli_fetch_array($Resp1))
		{	
			//if ($Fila1["nodo"]==84)	
			//	$Consulta = "select distinct cod_producto ";
			//else				
				$Consulta = "select distinct cod_producto, cod_subproducto ";
			$Consulta.= " from proyecto_modernizacion.relacion_prod_flujo_nodo ";
			$Consulta.= " where nodo='".$Fila1["nodo"]."'";
			//if($Fila1["nodo"]=='84'||$Fila1["nodo"]=='85'||$Fila1["nodo"]=='104'||$Fila1["nodo"]=='105')
			//	echo $Consulta."<br>";
			$RespAux = mysqli_query($link, $Consulta);
			$PesoNodo = 0;
			$Fino_Cu = 0;
			$Fino_Ag = 0;
			$Fino_Au = 0;
			while ($FilaAux = mysqli_fetch_array($RespAux))
			{
				$Consulta = "select t1.hornada, t1.peso_fin as peso, t2.cod_leyes, t2.valor";
				$Consulta.= " from sea_web.stock t1 LEFT JOIN sea_web.leyes_por_hornada t2 ";
				$Consulta.= " on t1.hornada=t2.hornada and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
				$Consulta.= " where t1.ano='".$Ano."' and t1.mes='".$Mes."'";
				// aca junto los restos
				//if ($FilaAux["cod_producto"]==19)
				//{
				//	$Consulta.= " and t1.cod_producto='".$FilaAux["cod_producto"]."'";
				//}
				//else
				//{
					$Consulta.= " and t1.cod_producto='".$FilaAux["cod_producto"]."' and t1.cod_subproducto='".$FilaAux["cod_subproducto"]."'";
				//}
				$Consulta.= " and t2.cod_leyes in('02','04','05')";
				$Consulta.= " order by t1.hornada, t2.cod_leyes";
				//if($Fila1["nodo"]=='84'||$Fila1["nodo"]=='85'||$Fila1["nodo"]=='104'||$Fila1["nodo"]=='105')
				//	echo $Consulta."<br>";
				$RespAux2 = mysqli_query($link, $Consulta);	
				$HornadaAnt	= "";		
				while ($FilaAux2=mysqli_fetch_array($RespAux2))
				{
					if ($HornadaAnt != $FilaAux2["hornada"])
					{
						$PesoNodo = $PesoNodo + $FilaAux2["peso"];		
					}
					switch ($FilaAux2["cod_leyes"])
					{
						case "02":
							$Fino_Cu = $Fino_Cu + (($FilaAux2["peso"]*$FilaAux2["valor"])/100);
							break;
						case "04":
							$Fino_Ag = $Fino_Ag + (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
							break;
						case "05":
							$Fino_Au = $Fino_Au + (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
							break;														
					}											
					$HornadaAnt = $FilaAux2["hornada"];
				}//FIN HORNADAS DEL NODO
				// Aca grabo nodo para posteriormente sumar si hay stock en piso
				if ($Copiar == "S")
				{
					$Insertar = "INSERT INTO sea_web.existencia_nodo (ano,mes,nodo,peso,fino_cu,fino_ag,fino_au)";
					$Insertar.= " VALUES ('".$Ano."',";
					$Insertar.= "'".$Mes."',";
					$Insertar.= "'".$Fila1["nodo"]."',";
					$Insertar.= "'".$PesoNodo."',";
					$Insertar.= "'".$Fino_Cu."',";
					$Insertar.= "'".$Fino_Ag."',";
					$Insertar.= "'".$Fino_Au."')";
					//mysqli_query($link, $Insertar);
				}	
				// + STOCK EN PISO POR PRODUCTO - SUBPRODUCTO
				$HornadaAnt='';
				$Consulta = "SELECT t1.hornada, sum(t1.peso) as peso , t2.cod_leyes, t2.valor";
				$Consulta.= " FROM sea_web.stock_piso_raf t1 LEFT JOIN sea_web.leyes_por_hornada t2";
				$Consulta.= " on t1.hornada=t2.hornada and t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto";
				$Consulta.= " WHERE t1.cod_producto = '".$FilaAux["cod_producto"]."'";
				//if ($FilaAux["cod_producto"] != 19)
					$Consulta.= " AND t1.cod_subproducto = '".$FilaAux["cod_subproducto"]."'";
				$Consulta.= " AND t1.fecha between '".$FechaIni."' AND '".$FechaFin."' ";
				$Consulta.= " and t2.cod_leyes in('02','04','05')";
				$Consulta.= " group by t1.hornada, t2.cod_leyes ";
				$Consulta.= " order by t1.hornada, t2.cod_leyes ";
				$RespAux2 = mysqli_query($link, $Consulta);
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					if ($HornadaAnt != $FilaAux2["hornada"])
					{
						$PesoNodo = $PesoNodo + $FilaAux2["peso"];			
					}
					switch ($FilaAux2["cod_leyes"])
					{
						case "02":
							$Fino_Cu = $Fino_Cu + (($FilaAux2["peso"]*$FilaAux2["valor"])/100);
							break;
						case "04":
							$Fino_Ag = $Fino_Ag + (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
							break;
						case "05":
							$Fino_Au = $Fino_Au + (($FilaAux2["peso"]*$FilaAux2["valor"])/1000);
							break;														
					}											
					$HornadaAnt = $FilaAux2["hornada"];
				}						
			}//FIN ACUMULA NODO
								
			if ($Copiar == "S")
			{
			 	$Consultar ="select * from sea_web.existencia_nodo where ano = '".$Ano."' and mes = '".$Mes."' and ";
				$Consultar.="nodo ='".$Fila1["nodo"]."'";
				$RespNodo = mysqli_query($link, $Consultar);
				if ($FilaN=mysqli_fetch_array($RespNodo))
				{
					$PesoNodo = $PesoNodo + $FilaN["peso"];
					$Fino_Cu = $Fino_Cu + $FilaN["fino_cu"];
					$Fino_Ag = $Fino_Ag + $FilaN["fino_ag"];
					$Fino_Au = $Fino_Au + $FilaN["fino_au"];
					$Actualizar ="UPDATE sea_web.existencia_nodo set peso = '".$PesoNodo."',";
					$Actualizar.="fino_cu = '".$Fino_Cu."',";
			    	$Actualizar.="fino_ag = '".$Fino_Ag."', fino_au = '".$Fino_Au."' ";
					$Actualizar.="where ano = '".$Ano."' and mes = '".$Mes."' and  nodo ='".$Fila1["nodo"]."' ";
					mysqli_query($link, $Actualizar);
					//if($Fila1["nodo"]=='84'||$Fila1["nodo"]=='85'||$Fila1["nodo"]=='104'||$Fila1["nodo"]=='105')
					//	echo $Actualizar."<br>";
				}
				else
				{
					$Insertar = "INSERT INTO sea_web.existencia_nodo (ano,mes,nodo,peso,fino_cu,fino_ag,fino_au)";
					$Insertar.= " VALUES ('".$Ano."',";
					$Insertar.= "'".$Mes."',";
					$Insertar.= "'".$Fila1["nodo"]."',";
					$Insertar.= "'".$PesoNodo."',";
					$Insertar.= "'".$Fino_Cu."',";
					$Insertar.= "'".$Fino_Ag."',";
					$Insertar.= "'".$Fino_Au."')";
					mysqli_query($link, $Insertar);
					//if($Fila1["nodo"]=='84'||$Fila1["nodo"]=='85'||$Fila1["nodo"]=='104'||$Fila1["nodo"]=='105')
					//	echo $Insertar."<br>";
					
				}				
			}
		}	
	}
}
?>
<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frm1;
	switch (opt)
	{
		case "AM":
			var Pag = "../principal/abrir_mes_anexo.php?Sistema=SEA&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.open(Pag,"","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
			break;
		case "CM":
			var msg = confirm("�Esta seguro que desea guardar esta version del Anexo.SEA?");
			if (msg)
			{
				f.action = "sea_con_anexo01.php?Proceso=G&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=16&Nivel=0";
			f.submit();
			break;
		case "I":
			window.print();
			break;
		case "E":
			f.action = "sea_con_anexo_excel.php?Mostrar=S&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			f.submit(); 
			break;
		case "C":
			f.action = "sea_con_anexo.php?Mostrar=S";
			f.submit(); 
			break;
	}	
}

function Detalle(flu)
{
	var f = frm1;		
	window.open("sea_con_anexo_det_flujo.php?Flujo=" + flu + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
function DetalleNodo(nodo)
{
	var f = frm1;		
	window.open("sea_con_anexo_det_nodo.php?Nodo=" + nodo + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top">
	  
<table width="650" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr align="center">
    <td height="23" colspan="4" class="ColorTabla02"><strong>ANEXO DEL SISTEMA DE ANODOS </strong></td>
  </tr>
  <tr>
    <td width="91" height="23">Mes Anexo</td>
    <td width="163">
      <select name="Mes">
        <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($Mes))
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $Mes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
      </select>
      <select name="Ano" size="1">
        <?php
			for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
			{
				if (!isset($Ano))
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $Ano)
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
      </select>
    </td>
    <td width="198"  align="right">Cierre Parcial:</td>
  <td width="163">
<?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='2' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='2' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1')";
	$Resp = mysqli_query($link, $Consulta);
	$CierreBalance = false;	
	if ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["estado"]=="C")
		{
			$CierreBalance = true;
			echo "<img src='../principal/imagenes/cand_cerrado.gif'>&nbsp;".$Fila["fecha_cierre"];
		}
		else
			echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
	else
	{
		echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}	
?></td>
  </tr>
  <tr>
    <td height="23" align="center">&nbsp;</td>
  <td height="23" align="center">&nbsp;</td>
    <td height="23" align="right">Cierre General:</td>
  <td height="23"><?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='2' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='2' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2')";
	$Resp = mysqli_query($link, $Consulta);
	$CierreBalance = false;
	if ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["estado"]=="C")
		{
			$CierreBalance = true;
			echo "<img src='../principal/imagenes/cand_cerrado.gif'>&nbsp;".$Fila["fecha_cierre"];
		}
		else
			echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
	else
	{
		echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
?></td>
  </tr>
  <tr align="center">
    <td height="23" colspan="4"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
        <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
        <?php			  
	if ($Mostrar == "S")
	{		
        echo "<input name='BtnExcel' type='button' style='width:70px;' onClick=\"Proceso('E')\" value='Excel'>\n";
	}
	//Consulto si las existencias del mes estab bloqueadas
	$Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM sea_web.existencia_nodo ";
	$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND bloqueado = '1'";    
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Respuesta);
	if ($Fila["valor"] == "0")
	{		
        echo "<input name='BrnCerrar' type='button' value='Cerrar Mes' style='width:70px;' onClick=\"Proceso('CM')\">";
	}
	else
	{
		if ($CierreBalance == false)
			echo "<input name='BrnAbrir' type='button' value='Abrir Mes' style='width:70px;' onClick=\"Proceso('AM')\">";
	}
?>
        <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
  </tr>
</table>
<br>
	<table width="650" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Flujo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="3" align="center">Leyes</td>
      <td colspan="3" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    </tr>
<?php	
if ($Mostrar == "S")
{		
	$Consulta = "SELECT t1.flujo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au  ";
	$Consulta.= " FROM sea_web.stock_anexo t1 inner join proyecto_modernizacion.flujos t2 ";
	$Consulta.= " on t1.flujo = t2.cod_flujo ";
	$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes;
	$Consulta.= " and t2.sistema = 'SEA'";
	$Consulta.= " and t2.esflujo <> 'N'";
	$Consulta.= " ORDER BY flujo";
	$Resp = mysqli_query($link, $Consulta);	
	while ($row = mysqli_fetch_array($Resp))
	{			
		if ($row["peso"] != 0)
		{
			echo '<tr>';
			echo '<td align="center">'.$row["flujo"].'</td>';
			echo '<td align="left"><a href="JavaScript:Detalle('.$row["flujo"].')">'.strtoupper($row["descripcion"]).'</a></td>';
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_cu"] / $row["peso"] * 100),2,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_ag"] / $row["peso"] * 1000),2,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_au"] / $row["peso"] * 1000),2,',','.').'</td>';	
			echo '<td align="right">'.number_format($row["fino_cu"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_ag"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_au"],0,',','.').'</td>';										
			echo '</tr>';
		}
	}
}			
?>		
	<tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Nodo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="3" align="center">Leyes</td>
      <td colspan="3" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    </tr>
<?php	
if ($Mostrar == "S")
{					
	$Consulta = "SELECT t1.nodo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au ";
	$Consulta.= " FROM sea_web.existencia_nodo t1 inner join proyecto_modernizacion.nodos t2 ";
	$Consulta.= " on t1.nodo = t2.cod_nodo";
	$Consulta.= " WHERE t1.ano = ".$Ano." AND t1.mes = ".$Mes;
	$Consulta.= " and t2.sistema = 'SEA' ";
	$Consulta.= " and t2.virtual<>'S' ";
	$Consulta.= " ORDER BY nodo";			
	$Resp = mysqli_query($link, $Consulta);			
	while ($row = mysqli_fetch_array($Resp))
	{			
		if ($row["peso"] != 0)
		{
			echo '<tr>';
			echo '<td align="center">'.$row["nodo"].'</td>';
			echo '<td align="left"><a href="JavaScript:DetalleNodo('.$row["nodo"].')">'.strtoupper($row["descripcion"]).'</a></td>';
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_cu"] / $row["peso"] * 100),2,',','.').'</td>';
			echo '<td align="right">'.number_format(($row["fino_ag"] / $row["peso"] * 1000),2,',','.').'</td>';
			echo '<td align="right">'.round(($row["fino_au"] / $row["peso"] * 1000),2).'</td>';	
			echo '<td align="right">'.number_format($row["fino_cu"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_ag"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_au"],0,',','.').'</td>';												
			echo '</tr>';
		}
	}	
}			
?>
</table>      </td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>