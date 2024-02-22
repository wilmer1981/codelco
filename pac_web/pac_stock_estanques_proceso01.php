<?php
	include("../principal/conectar_pac_web.php");
	
	switch ($Proceso)
	{
		case "N":
			$Consulta="select cod_subclase from proyecto_modernizacion.sub_clase where cod_clase=9001 order by cod_subclase";
			$Respuesta=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Insertar="insert into pac_web.stock_estanques (ano,mes,cod_estanque,stock_inicial,recepcion,envio,ajuste,stock_actual) values (";
				$Insertar=$Insertar."$CmbAno,$CmbMes,".$Fila["cod_subclase"].",0,0,0,0,0)";
				mysqli_query($link, $Insertar);
			}		
			break;
		case "M":
			while (list($i,$p)=each($CheckEK))
			{
				if ($CmbSigno[$i]=='+')
				{
					$Ajuste=$TxtAjuste[$i];
					$StockActual=$TxtStockInicial[$i]+$TxtRecepcion[$i]-$TxtEnvio[$i]+$TxtAjuste[$i];
				}
				else
				{
					$StockAux=abs($TxtStockInicial[$i]+$TxtRecepcion[$i]-$TxtEnvio[$i]);
					if ($TxtAjuste[$i]<=$StockAux)
					{
						$Ajuste=$TxtAjuste[$i];
						$StockActual=abs($TxtStockInicial[$i]+$TxtRecepcion[$i]-$TxtEnvio[$i]-$TxtAjuste[$i]);
					}
					else
					{
						$Ajuste=0;
						$StockActual=0;
					}
				}
				$Modificar="UPDATE pac_web.stock_estanques set stock_inicial=".str_replace(",",".",$TxtStockInicial[$i]).",recepcion=".str_replace(",",".",$TxtRecepcion[$i]).",envio=".str_replace(",",".",$TxtEnvio[$i]).",signo='".$CmbSigno[$i]."',ajuste=".str_replace(",",".",$Ajuste).",stock_actual=".str_replace(",",".",$StockActual)." where ano='".$CmbAno."' and mes ='".$CmbMes."' and cod_estanque=".$p;
				mysqli_query($link, $Modificar);
			}	
			break;
		case "E":
			$EncontroRelacion=false;
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$AnoMes=substr($Datos,0,$i);
					$Ano=substr($AnoMes,0,4);
					$Mes=substr($AnoMes,4);
					$Eliminar ="delete from pac_web.stock_estanques where ano=".$Ano." and mes=".$Mes;
					mysqli_query($link, $Eliminar);
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}
	switch ($Proceso)
	{
		case "E":
			header("location:pac_stock_estanques.php?EncontroRelacion=".$EncontroRelacion);
			break;
		case "N":
			header("location:pac_stock_estanques_proceso.php?EncontroRelacion=".$EncontroRelacion."&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&Proceso=".$Proceso);
			break;
		case "M":
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmStockEstanques.action='pac_stock_estanques.php';";
			echo "window.opener.document.FrmStockEstanques.submit();";
			echo "window.close();";
			echo "</script>";
			break;	
	}
?>