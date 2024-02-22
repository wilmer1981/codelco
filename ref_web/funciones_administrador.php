<?phpphp

function LLenaComboDia($Dia,$DiaActual)
{
	for ($i = 1; $i <= 31; $i++)
	{		
		if ($Dia == "")
			$Compara = $DiaActual;
		else	$Compara = $Dia;	
		if ($i == $Compara)
		{
			echo "<option value='".$i."' selected>".$i."</option>\n";
		}
		else
		{
			echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
return $i;	
}

function LLenaComboMes($Mes,$MesActual)
{
	$Meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");	
	for ($i = 1; $i <= 12; $i++)
	{
		if ($Mes == "")
			$Compara = $MesActual;
		else	$Compara = $Mes;
		if ($i == $Compara)
		{
			echo "<option value='".$i."' selected>".$Meses[$i - 1]."</option>\n";
		}
		else
		{
			echo "<option value='".$i."'>".$Meses[$i - 1]."</option>\n";
		}
	}
return $i;	
}

function LLenaComboAno($Ano,$AnoActual)
{
	for ($i = 2003; $i <= date("Y"); $i++)
	{
		if ($Ano == "")
			$Compara = $AnoActual;
		else	$Compara = $Ano;
		if ($i == $Compara)
		{
			echo "<option value='".$i."' selected>".$i."</option>\n";
		}
		else
		{
			echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
}


function aumentar_dias($fecha,$i)
{
 $sql="SELECT  ADDDATE('$fecha',INTERVAL '$i' DAY) as fecha";
 $result=mysqli_query($link, $sql);
 $row = mysqli_fetch_array($result);
 $variable =$row["fecha"];
return $variable;
}


function restar_dias($fecha,$i)
{
 $sql="SELECT  SUBDATE('$fecha',INTERVAL '$i' DAY) as fecha";
 $result=mysqli_query($link, $sql);
 $row = mysqli_fetch_array($result);
 $variable =$row["fecha"];
 return $variable;
}

?>