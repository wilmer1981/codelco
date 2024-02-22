<?php
	function LlenaCombosPersonalPmn($NomCmb,$Proceso,$link)
	{
		$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
		$sql.= " from proyecto_modernizacion.sub_clase t1 inner join  proyecto_modernizacion.funcionarios t2 ";
		$sql.= " on t1.nombre_subclase = t2.rut ";
		$sql.= " where t1.cod_clase = '6002' and t1.valor_subclase1='".$Proceso."' ";
		$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
		$resultComboPMN = mysqli_query($link, $sql);
		while ($rowComboPMN = mysqli_fetch_array($resultComboPMN))
		{
			$Nombre = ucwords(strtolower($rowComboPMN["apellido_paterno"]." ".$rowComboPMN["apellido_materno"]." ".$rowComboPMN["nombres"]));
			if ($rowComboPMN["rut"] == $NomCmb)
			{
				echo "<option selected value='".$rowComboPMN["rut"]."'>".$Nombre."</option>\n";
			}
			else
			{
				echo "<option value='".$rowComboPMN["rut"]."'>".$Nombre."</option>\n";
			}
		}
	}
	

	function StockPmn_valor($Prod,$SubProd,$Ano,$Mes,$TipoOpe,$TipoMov,$Valor,$ValorC,$link)//TIPOMOV: SI ES PRODUCCION O BENEFICIO (P - B), TIPOOPE: SI ES INGRESAR Y ELIMINAR (I - E).
	{
		$Consulta="select * from pmn_web.stock_pmn where ano='".$Ano."' and mes='".$Mes."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
		$Resp=mysqli_query($link, $Consulta);
		if(!$Fila=mysqli_fetch_assoc($Resp))
		{
			$FechaAct=$Ano."-".$Mes."-01";
			$FechaAnt=explode('-',date('Y-m-d',mktime(0,0,0,intval($Mes)-1,'01',$Ano)));
			$Consulta="select sf_p,sf_c from pmn_web.stock_pmn where ano='".$FechaAnt[0]."' and mes='".$FechaAnt[1]."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);$StockIniP=0;$StockIniC=0;
			if($Fila=mysqli_fetch_assoc($Resp))
			{
				$StockIniP=$Fila["sf_p"];
				$StockIniC=$Fila["sf_c"];
			}	
			$Prod_P=0;
			$Prod_C=0;
			$Bene_P=0;
			$Bene_C=0;
			
			$Insertar="insert into pmn_web.stock_pmn (ano,mes,cod_producto,cod_subproducto,si_p,pr_p,bn_p,sf_p,si_c,pr_c,bn_c,sf_c)";
			$Insertar.=" values('".$Ano."','".$Mes."','".$Prod."','".$SubProd."','".$StockIniP."','0','0','".$StockIniP."','".$StockIniC."','0','0','".$StockIniC."')";
			//echo  "primer insert si no existe registro:   ".$Insertar."<br><br>";
			mysqli_query($link, $Insertar);
		}
		else
		{
			$StockIniP=$Fila["si_p"];
			$StockIniC=$Fila["si_c"];
			$Prod_P=$Fila["pr_p"];
			$Prod_C=$Fila["pr_c"];
			$Bene_P=$Fila["bn_p"];
			$Bene_C=$Fila["bn_c"];
		}
		$Actualiza="UPDATE pmn_web.stock_pmn set";
		switch($TipoOpe)
		{
			case "I":
				  switch($TipoMov)
				  {
				  		case "P"://PRODUCCION
							$StockSF_P=$StockIniP+$Valor+$Prod_P-$Bene_P;
							$Prod_PAct=$Valor+$Prod_P;
							$StockSF_C=$StockIniC+$ValorC+$Prod_C-$Bene_C;
							$Prod_CAct=$ValorC+$Prod_C;
							$Actualiza.=" pr_p='".$Prod_PAct."',sf_p='".$StockSF_P."'";
							$Actualiza.=" ,pr_c='".$Prod_CAct."',sf_c='".$StockSF_C."'";
						break;
				  		case "B"://BENEFICIO							
							$StockSF_P=$StockIniP-$Valor+$Prod_P-$Bene_P;
							$Bene_PAct=$Valor+$Bene_P;
							$StockSF_C=$StockIniC-$ValorC+$Prod_C-$Bene_C;
							$Bene_CAct=$ValorC+$Bene_C;
							$Actualiza.=" bn_p='".$Bene_PAct."',sf_p='".$StockSF_P."'";
							$Actualiza.=" ,bn_c='".$Bene_CAct."',sf_c='".$StockSF_C."'";
						break;
				  }
			break;
			case "E":
				  switch($TipoMov)
				  {
				  		case "P"://PRODUCCION
							$StockSF_P=$StockIniP - $Valor + $Prod_P - $Bene_P;
							$Prod_PAct=$Prod_P-$Valor;
							$StockSF_C=$StockIniC-$ValorC+$Prod_C-$Bene_C;
							$Prod_CAct=$Prod_C-$ValorC;
							$Actualiza.=" pr_p='".$Prod_PAct."',sf_p='".$StockSF_P."'";
							$Actualiza.=" ,pr_c='".$Prod_CAct."',sf_c='".$StockSF_C."'";
						break;
				  		case "B"://BENEFICIO
							$StockSF_P=$StockIniP+$Valor+$Prod_P-$Bene_P;
							$Bene_PAct=$Bene_P-$Valor;
							$StockSF_C=$StockIniC+$ValorC+$Prod_C-$Bene_C;
							$Bene_CAct=$Bene_C-$ValorC;
							$Actualiza.=" bn_p='".$Bene_PAct."',sf_p='".$StockSF_P."'";
							$Actualiza.=" ,bn_c='".$Bene_CAct."',sf_c='".$StockSF_C."'";
						break;
				  }
			break;
		}
		$Actualiza.=" where ano='".$Ano."' and mes='".$Mes."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
		mysqli_query($link, $Actualiza);
		
		RecarlculaStockPMN($Ano,$Mes,$Prod,$SubProd,$link);
	}

function RecarlculaStockPMN($Ano,$Mes,$Prod,$SubProd,$link)
{
	/*------------------RECALCULA TODO EL PRODUCTO------------------------*/
	$MesMas=0;
	for($i=$Mes;$i<=12;$i++)
	{
		$Consulta2="select sf_p,sf_c from pmn_web.stock_pmn where ano='".$Ano."' and mes='".$i."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
		$Resp2=mysqli_query($link, $Consulta2);
		if($Fila2=mysqli_fetch_assoc($Resp2))
		{
			$ValorInicialP2=$Fila2["sf_p"];
			$ValorInicialC2=$Fila2["sf_c"];
		}
		$MesMas = $i+1;
		if($MesMas<=12)
		{
		$Consulta="select * from pmn_web.stock_pmn where ano='".$Ano."' and mes='".$MesMas."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";			
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_assoc($Resp))
		{								
			$STockFinal1=$ValorInicialP2+$Fila["pr_p"]-$Fila["bn_p"];
			$STockFinal2=$ValorInicialC2+$Fila["pr_c"]-$Fila["bn_c"];
			$Actualiza="UPDATE pmn_web.stock_pmn set si_p='".$ValorInicialP2."', sf_p='".$STockFinal1."',si_c='".$ValorInicialC2."', sf_c='".$STockFinal2."' where ano='".$Ano."' and mes='".$MesMas."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";																				
			mysqli_query($link, $Actualiza);
			$ValorInicialP=$STockFinal1;
			$ValorInicialC=$STockFinal2;
		}	
		else
		{
			$Inserta="insert into pmn_web.stock_pmn values('".$Ano."','".$MesMas."','".$Prod."','".$SubProd."','".$ValorInicialP2."','0','0','".$ValorInicialP2."','".$ValorInicialC2."','0','0','".$ValorInicialC2."')";
			mysqli_query($link, $Inserta);
		}	
		}
	}
}	

function MuestraSTOCK($Ano,$Mes,$Prod,$SubProd,$TipoPC,$link)
{
	$ConsultaStock="select sf_p,sf_c from pmn_web.stock_pmn where ano='".$Ano."' and mes='".$Mes."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
	$RespStock=mysqli_query($link, $ConsultaStock);
	if($FilaStock=mysqli_fetch_assoc($RespStock))
	{
		if($TipoPC=='P')//PESO
			$ValorStock=$FilaStock["sf_p"];
		else
			$ValorStock=$FilaStock["sf_c"];
	}
	else
		$ValorStock=0;
		
	return($ValorStock);	
}	
?>