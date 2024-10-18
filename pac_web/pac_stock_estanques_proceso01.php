<?php
	include("../principal/conectar_pac_web.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");

	$Ano    =isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes    =isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");

	$CheckEK         = isset($_REQUEST["CheckEK"])?$_REQUEST["CheckEK"]:"";
	$TxtStockInicial = isset($_REQUEST["TxtStockInicial"])?$_REQUEST["TxtStockInicial"]:"";
	$TxtStockActual  = isset($_REQUEST["TxtStockActual"])?$_REQUEST["TxtStockActual"]:"";
	$TxtRecepcion = isset($_REQUEST["TxtRecepcion"])?$_REQUEST["TxtRecepcion"]:"";
	$TxtEnvio     = isset($_REQUEST["TxtEnvio"])?$_REQUEST["TxtEnvio"]:"";
	$CmbSigno     = isset($_REQUEST["CmbSigno"])?$_REQUEST["CmbSigno"]:"";
	$TxtAjuste    = isset($_REQUEST["TxtAjuste"])?$_REQUEST["TxtAjuste"]:"";

	$Fecha = $CmbAno."-".$CmbMes."-".date("d");
	
	switch ($Proceso)
	{
		case "N":
			$Consulta="SELECT cod_subclase from proyecto_modernizacion.sub_clase where cod_clase=9001 order by cod_subclase";
			$Respuesta=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				//$Insertar="insert into pac_web.stock_estanques (ano,mes,cod_estanque,stock_inicial,recepcion,envio,ajuste,stock_actual) values (";
				//$Insertar=$Insertar."$CmbAno,$CmbMes,".$Fila["cod_subclase"].",0,0,0,0,0)";
				$Insertar="INSERT INTO pac_web.stock_estanques (fecha,cod_estanque,stock_inicial,recepcion,envio,ajuste,stock_actual) values (";
				$Insertar.=" '".$Fecha."','".$Fila["cod_subclase"]."',0,0,0,0,0)";
				mysqli_query($link, $Insertar);
			}		
			break;
		case "M":
			if (is_array($CheckEK ) || is_object($CheckEK))
			{
				foreach($CheckEK as $i => $p)
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
					//$Modificar="UPDATE pac_web.stock_estanques set stock_inicial=".str_replace(",",".",$TxtStockInicial[$i]).",recepcion=".str_replace(",",".",$TxtRecepcion[$i]).",envio=".str_replace(",",".",$TxtEnvio[$i]).",signo='".$CmbSigno[$i]."',ajuste=".str_replace(",",".",$Ajuste).",stock_actual=".str_replace(",",".",$StockActual)." where ano='".$CmbAno."' and mes ='".$CmbMes."' and cod_estanque=".$p;
					$Modificar="UPDATE pac_web.stock_estanques set stock_inicial=".str_replace(",",".",$TxtStockInicial[$i]).",recepcion=".str_replace(",",".",$TxtRecepcion[$i]).",envio=".str_replace(",",".",$TxtEnvio[$i]).",signo='".$CmbSigno[$i]."',ajuste=".str_replace(",",".",$Ajuste).",stock_actual=".str_replace(",",".",$StockActual)." ";
					$Modificar.=" WHERE EXTRACT(YEAR FROM fecha) ='".$CmbAno."' AND EXTRACT(MONTH FROM fecha) ='".$CmbMes."' and cod_estanque='".$p."' ";
						mysqli_query($link, $Modificar);
				}
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
			//echo "window.close();";
			echo "</script>";
			break;	
	}
?>